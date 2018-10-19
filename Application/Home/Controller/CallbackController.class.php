<?php

namespace Home\Controller;

/*

	接口回调

 */
use Think\Controller;

class CallbackController extends Controller
{

    //手机运营商认证回调
    public function mobileAuth(){
        $code = I("param.code");
        $token = I("param.token");
        //调试信息
        file_put_contents("auth.txt",$code.$token,FILE_APPEND);
        if($token){
            $mobile_model = D("Auth_mobile");
            $mobile_info = $mobile_model->where(array('token'=>$token))->find();
            file_put_contents("auth2.txt",'uid'.$mobile_info['uid'].'token'.$mobile_info['token'],FILE_APPEND);
            if($mobile_info){
                $arr = array();
                if($code == '0000'){
                    $arr['status'] = 1;
                    import('@.Class.Limu');
                    $Limu = new \Limu();
                    $mobile_obj = $Limu->ApiCommonGetResult($token,'mobile');
                    file_put_contents("auth3.txt",'code'.$mobile_obj->code,FILE_APPEND);
                    if($mobile_obj->code == '0000'){
                        $arr['data'] = json_encode(object_to_array($mobile_obj->data));
                    }else{
                        $arr['status'] = 2;
                        $arr['data'] = json_encode(array());
                    }
                }else{
                    $arr['status'] = 0;
                }
                $arr['code'] = $code;
                $status = $mobile_model->where(array('token'=>$token))->save($arr);
                if($status){
                    echo "success";
                }else{
                    $debug_str = 'status:'.$arr['status'].',data:'.$arr['data'].',status:'.$status;
                    file_put_contents("auth4.txt",'debug'.$debug_str,FILE_APPEND);
                }
            }
        }
    }

    //连连支付还款异步
    public function lian_notify()
    {
        require_once(VENDOR_PATH . "lianlian/llpay.config.php");
        require_once(VENDOR_PATH . "lianlian/lib/llpay_notify.class.php");
        //计算得出通知验证结果
        $llpayNotify = new \LLpayNotify($llpay_config);
        $llpayNotify->verifyNotify();

        if ($llpayNotify->result) { //验证成功
            //获取连连支付的通知返回参数，可参考技术文档中服务器异步通知参数列表
            $no_order = $llpayNotify->notifyResp['info_order'];//商户订单号
            $oid_paybill = $llpayNotify->notifyResp['oid_paybill'];//连连支付单号
            $result_pay = $llpayNotify->notifyResp['result_pay'];//支付结果，SUCCESS：为支付成功
            $money_order = $llpayNotify->notifyResp['money_order'];// 支付金额

            if ($result_pay == "SUCCESS") {
                //请在这里加上商户的业务逻辑程序代(更新订单状态、入账业务)
                //——请根据您的业务逻辑来编写程序——
                //payAfter($llpayNotify->notifyResp);

                //修改订单状态
                $data = array(
                    'borrow_status' => 4,
                    'payment_status' => 1,
                    'payment_time' => time(),
                    'review_note' => "还款成功(连连)"
                );
                $where['oid'] = $no_order;
                $status = D('Loan')->where($where)->save($data);
            }


            file_put_contents("log88.txt", "异步通知还款 验证成功:oid:$no_order\n", FILE_APPEND);
            die("{'ret_code':'0000','ret_msg':'交易成功'}"); //请不要修改或删除
            /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        } else {
            file_put_contents("log88.txt", "异步通知还款 验证失败\n", FILE_APPEND);
            //验证失败
            die("{'ret_code':'9999','ret_msg':'验签失败'}");
            //调试用，写文本函数记录程序运行情况是否正常
            //logResult("这里写入想要调试的代码变量值，或其他运行的结果记录");
        }

    }

    /**
     * 连连支付成功 返回页
     */
    public function lian_return()
    {
        require_once(VENDOR_PATH . "lianlian/llpay.config.php");
        require_once(VENDOR_PATH . "lianlian/lib/llpay_notify.class.php");
        include_once(VENDOR_PATH . 'lianlian/lib/llpay_cls_json.php');

        //计算得出通知验证结果
        $llpayNotify = new \LLpayNotify($llpay_config);
        $verify_result = $llpayNotify->verifyReturn();
        //验证成功
        if ($verify_result) {
            /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            //请在这里加上商户的业务逻辑程序代码

            //——请根据您的业务逻辑来编写程序（以下代码仅作参考）——
            //获取连连支付的通知返回参数，可参考技术文档中页面跳转同步通知参数列表
            $json = new \JSON;
            $res_data = $_POST["res_data"];

            //商户编号
            $oid_partner = $json->decode($res_data)->{'oid_partner'};

            //商户订单号
            $no_order = $json->decode($res_data)->{'no_order'};

            //支付结果
            $result_pay = $json->decode($res_data)->{'result_pay'};

            if ($result_pay == 'SUCCESS') {
                //判断该笔订单是否在商户网站中已经做过处理
                //如果没有做过处理，根据订单号（no_order）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
                //如果有做过处理，不执行商户的业务程序
            } else {
                echo "result_pay=" . $result_pay;
            }
            $this->success('支付成功', U('Loan/lists'));

            //——请根据您的业务逻辑来编写程序（以上代码仅作参考）——

            /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        } else {
            //验证失败
            //如要调试，请看llpay_notify.php页面的verifyReturn函数
            $this->error('支付失败', U('Loan/lists'));
        }

    }



    //连连支付续期异步
    public function lianxuqi_notify()
    {
        require_once(VENDOR_PATH . "lianlian/llpay.config.php");
        require_once(VENDOR_PATH . "lianlian/lib/llpay_notify.class.php");
        require_once(VENDOR_PATH . "lianlian/lib/llpay_submit.class.php");

        //计算得出通知验证结果
        $llpayNotify = new \LLpayNotify($llpay_config);
        $llpayNotify->verifyNotify();
        if ($llpayNotify->result) { //验证成功
            file_put_contents("log2.txt", "验证成功:\n", FILE_APPEND);
            //获取连连支付的通知返回参数，可参考技术文档中服务器异步通知参数列表
            $no_order = $llpayNotify->notifyResp['info_order'];//商户订单号
            $oid_paybill = $llpayNotify->notifyResp['oid_paybill'];//连连支付单号
            $result_pay = $llpayNotify->notifyResp['result_pay'];//支付结果，SUCCESS：为支付成功
            $money_order = $llpayNotify->notifyResp['money_order'];// 支付金额

            if ($result_pay == "SUCCESS") {
                file_put_contents("log2.txt", "异步通知 支付SUCCESS:\n", FILE_APPEND);
                //订单号
                $where['oid'] = $no_order;
                $loan = D("Loan")->where($where)->find();

                if ($loan['pid'] <> 0) {        //说明是第二次续期
                    $loan['id'] = $loan['pid'];
                }


                //还款计划
                $date = date("Y-m-d", $loan['review_time'] + $loan['day'] * 86400 + $loan['day'] * 86400);  //应还时间
                $date = "'" . $date . "'";
                $money = "'" . $loan['money'] . "'";
                $plan = "{'repaymentPlan':[{'date':$date,'amount':$money}]}";

                //短信参数
                $sms_arr = array(
                    "contract_type" => nl_get_customConfig("business_name"),
                    "contact_way" => nl_get_customConfig("business_tel")
                );
                $sms_json = json_encode($sms_arr, JSON_UNESCAPED_UNICODE);

                //构造要请求的参数数组，无需改动
                $parameter = array(
                    "oid_partner" => trim($llpay_config['oid_partner']),
                    "sign_type" => trim($llpay_config['sign_type']),
                    "user_id" => $loan['uid'],
                    "repayment_plan" => $plan,
                    "api_version" => trim($llpay_config['version']),
                    "repayment_no" => $loan['id'],
                    "sms_param" => $sms_json
                );

                //建立请求
                $llpay_gateway_new = 'https://repaymentapi.lianlianpay.com/repaymentplanchange.htm';

                $llpaySubmit = new \LLpaySubmit($llpay_config, $llpay_gateway_new);
                $json = $llpaySubmit->buildRequestJSON($parameter, $llpay_gateway_new);
				file_put_contents("log2.txt", "json1\n".$json, FILE_APPEND);
                $json = json_decode($json, true);
				file_put_contents("log2.txt", "json2\n".$json, FILE_APPEND);
                if ($json['ret_code'] == "0000") {     //证明交易成功
				file_put_contents("log2.txt", "异步通知\n".$json['ret_code'], FILE_APPEND);
                    //生成新订单
                    $d = array(
                        "uid" => $loan['uid'],
                        "oid" => mackOid(),
                        "money" => $loan['money'],
                        "day" => $loan['day'],
                        "fee" => $loan['fee'],
                        "bankname" => $loan['bankname'],
                        "banknum" => $loan['banknum'],
                        "create_time" => $loan['review_time'] + $loan['day'] * 86400,
                        "borrow_status" => 1,
                        "review_money" => $loan['review_money'],
                        "review_time" => $loan['review_time'] + $loan['day'] * 86400,
                        "review_note" => "续期订单",
                        "payment_status" => 0,
                        "payment_time" => 0,
                        "is_read" => 0,
                        "pid" => $loan['id']
                    );
                    $s = D("Loan")->add($d);
                    //4为已还款
                    $data = array(
                        'borrow_status' => 4,
                        'payment_status' => 1,
                        'payment_time' => time()
                    );
                    $status = D('Loan')->where($where)->save($data);
                }
            }

            die("{'ret_code':'0000','ret_msg':'交易成功'}"); //请不要修改或删除
        } else {
            file_put_contents("log.txt", "异步通知 验证失败\n", FILE_APPEND);
            //验证失败
            die("{'ret_code':'9999','ret_msg':'验签失败'}");
            //调试用，写文本函数记录程序运行情况是否正常
            //logResult("这里写入想要调试的代码变量值，或其他运行的结果记录");
        }

    }


    /**
     * 连连支付续期成功 返回页
     */
    public function lianxuqi_return()
    {
        require_once(VENDOR_PATH . "lianlian/llpay.config.php");
        require_once(VENDOR_PATH . "lianlian/lib/llpay_notify.class.php");
        include_once(VENDOR_PATH . 'lianlian/lib/llpay_cls_json.php');

        //计算得出通知验证结果
        $llpayNotify = new \LLpayNotify($llpay_config);
        $verify_result = $llpayNotify->verifyReturn();
        //验证成功
        if ($verify_result) {
            //——请根据您的业务逻辑来编写程序（以下代码仅作参考）——
            //获取连连支付的通知返回参数，可参考技术文档中页面跳转同步通知参数列表
            $json = new \JSON;
            $res_data = $_POST["res_data"];
            //商户编号
            $oid_partner = $json->decode($res_data)->{'oid_partner'};
            //商户订单号
            $no_order = $json->decode($res_data)->{'no_order'};
            //支付结果
            $result_pay = $json->decode($res_data)->{'result_pay'};
            if ($result_pay == 'SUCCESS') {
                $this->success('支付成功', U('Loan/lists'));
            } else {
                echo "result_pay=" . $result_pay;
            }
        }else{
            //验证失败
            //如要调试，请看llpay_notify.php页面的verifyReturn函数
            $this->error('支付失败', U('Loan/lists'));
        }

    }



    //连连授权成功或失败回调地址
    public function acct_return()
    {
        require_once(VENDOR_PATH . "lianlian/llpay.config.php");
        require_once(VENDOR_PATH . "lianlian/lib/llpay_notify.class.php");
        include_once(VENDOR_PATH . 'lianlian/lib/llpay_cls_json.php');

        //获取连连授权的通知返回参数，可参考技术文档中页面跳转同步通知参数列表
        $json = new \JSON;
        $status = $_GET['status'];
		file_put_contents('ll.txt',$status,FILE_APPEND);
		file_put_contents('ll.txt',$json,FILE_APPEND);
        if ($status == '0000') {
            $result = $_GET["result"];
            //支付结果
            $user_id = $json->decode($result)->{'user_id'};
            $agreeno = $json->decode($result)->{'agreeno'};
            $card_no = session("card_no");  //卡号
            $acct_name = session("acct_name");  //姓名
            $id_no = session("id_no");  //身份证
            if ($card_no && $user_id) {
                $data['bank_num'] = $card_no;
                $data['acct_name'] = $acct_name;
                $data['id_card'] = $id_no;
                $data['uid'] = $user_id;
                $data['agreeno'] = $agreeno;
				
				$info=D("Auth_bank")->where("uid=".$user_id)->find();
				if(!$info){
					$statu = D("Auth_bank")->add($data);
				}
                if ($statu) $this->success("认证成功", U('Auth/index'));
            } else {
                $this->error("参数错误!", U('Auth/index'));
            }

        } else {
            $this->error("填写信息有误,认证失败", U('Auth/index'));
        }

    }


    //微信还款异步回调页
    public function weixin_notify()
    {
        $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
        $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
        $order_id = $postObj->attach;
        $result = $postObj->result_code; //SUCCESS支付成功
		//file_put_contents('pay.txt',"oid:".$order_id,FILE_APPEND);
        if ($result != "SUCCESS") {
            die("error");
        }

        if($order_id){

            $data = array(
                'borrow_status' => 4,
                'payment_status' => 1,
                'payment_time' => time(),
				'review_note'=>'还款成功(微信)'
            );

            $where['oid']=trim($order_id);
            $status = D("Loan")->where($where)->save($data);
			//file_put_contents('pay.txt',"jinlaile..",FILE_APPEND);
                    die("<xml>
 <return_code><![CDATA[SUCCESS]]></return_code> 
 <return_msg><![CDATA[OK]]></return_msg> 
</xml>");
        }else{
            die("{'return_code':'ERROR'}");
        }

    }

    //微信续期回调页
    public function weixinxuqi_notify(){
        $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
        $postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
        $order_id = $postObj->attach;
        $result = $postObj->result_code; //SUCCESS支付成功
		
        if ($result != "SUCCESS") {
            die("error");
        }
       
        require_once(VENDOR_PATH . "lianlian/llpay.config.php");
        require_once(VENDOR_PATH . "lianlian/lib/llpay_notify.class.php");
        require_once(VENDOR_PATH . "lianlian/lib/llpay_submit.class.php");
        if($order_id){
            $where['oid'] = trim($order_id);
            $loan = D("Loan")->where($where)->find();

            if($loan['payment_status']){
                die("error");
            }

            if ($loan['pid'] <> 0) {        //说明是第二次续期
                $loan['id'] = $loan['pid'];
            }

            //还款计划
            $date = date("Y-m-d", $loan['review_time'] + $loan['day'] * 86400 + $loan['day'] * 86400);  //应还时间
            $date = "'" . $date . "'";
            $money = "'" . $loan['money'] . "'";
            $plan = "{'repaymentPlan':[{'date':$date,'amount':$money}]}";

            //短信参数
            $sms_arr = array(
                "contract_type" => nl_get_customConfig("business_name"),
                "contact_way" => nl_get_customConfig("business_tel")
            );
            $sms_json = json_encode($sms_arr, JSON_UNESCAPED_UNICODE);

            //构造要请求的参数数组，无需改动
            $parameter = array(
                "oid_partner" => trim($llpay_config['oid_partner']),
                "sign_type" => trim($llpay_config['sign_type']),
                "user_id" => $loan['uid'],
                "repayment_plan" => $plan,
                "api_version" => trim($llpay_config['version']),
                "repayment_no" => $loan['id'],
                "sms_param" => $sms_json
            );

            //建立请求
            $llpay_gateway_new = 'https://repaymentapi.lianlianpay.com/repaymentplanchange.htm';

            $llpaySubmit = new \LLpaySubmit($llpay_config, $llpay_gateway_new);
            $json = $llpaySubmit->buildRequestJSON($parameter, $llpay_gateway_new);
            $json = json_decode($json, true);
			
            if ($json['ret_code'] == "0000") {     //证明交易成功
                //生成新订单
                $d = array(
                    "uid" => $loan['uid'],
                    "oid" => mackOid(),
                    "money" => $loan['money'],
                    "day" => $loan['day'],
                    "fee" => $loan['fee'],
                    "bankname" => $loan['bankname'],
                    "banknum" => $loan['banknum'],
                    "create_time" => $loan['review_time'] + $loan['day'] * 86400,
                    "borrow_status" => 1,
                    "review_money" => $loan['review_money'],
                    "review_time" => $loan['review_time'] + $loan['day'] * 86400,
                    "review_note" => "续期订单",
                    "payment_status" => 0,
                    "payment_time" => 0,
                    "is_read" => 0,
                    "pid" => $loan['id']
                );
                $s = D("Loan")->add($d);
                //4为已还款
                $data = array(
                    'borrow_status' => 4,
                    'payment_status' => 1,
                    'payment_time' => time()
                );
                $status = D('Loan')->where($where)->save($data);
             die("<xml>
 <return_code><![CDATA[SUCCESS]]></return_code> 
 <return_msg><![CDATA[OK]]></return_msg> 
</xml>");
        }else{
            die("{'return_code':'ERROR'}");
        }


    }
	}
}