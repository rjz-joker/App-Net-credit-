<?php

namespace Home\Controller;

/*

	贷款功能控制器

 */
use Think\Page;

header("Content-type: text/html; charset=utf-8");

class LoanController extends CommonController
{

    //申请贷款
    public function index()
    {
		

        $Index = new IndexController();
        $auth_status= $Index->checkAuth();
        if ($auth_status != 4) {
            $this->error("请先完成信息认证!", U('Auth/index'));
        }
        $money = I("post.money", 0, 'intval');
        $day = I("post.day", 0, 'intval');
        if (!$money || !$day) {
            $this->error("参数错误!");
        }
        $user_info = getLoginUser();
		
		if($user_info['status']=='0'){
			$this->error("抱歉,您处于风控状态,暂不能申请贷款!");
		}
        //判断是否有未审核订单
        $loan_model = D("Loan");
        $NoBowr = $loan_model->where(array('uid' => $user_info['id'], 'borrow_status' => 0))->count();
		$NoBowr2 = $loan_model->where(array('uid' => $user_info['id'], 'borrow_status' => 5))->count();
        if ($NoBowr || $NoBowr2) {
            $this->error("您有待审核/等待打款订单,暂不能申请贷款!");
        }
        //判断是否有未还款订单
        $NoBowr = $loan_model->where(array('uid' => $user_info['id'], 'borrow_status' => 1, 'payment_status' => 0))->count();
        if ($NoBowr) {
            $this->error("您有未还款订单,暂不能申请贷款!");
        }

        //XX时间内拒绝XX次
        $refuse_time = trim(nl_get_customConfig("refuse_time"));
        $refuse_num = trim(nl_get_customConfig("refuse_num"));
        if ($refuse_time && $refuse_num) {
            $time = time() - $refuse_time * 60;  //第一次拒绝的时间
            $count = $loan_model->where(array('uid' => $user_info['id'], 'borrow_status' => 2, 'review_time' => array('gt', $time)))->order("id desc")->count();
            if ($count >= $refuse_num) {
                $refuse_msg = trim(nl_get_customConfig("refuse_msg"));
                $this->error($refuse_msg);
            }
        }
		
		
		$is_yao=false;
			if($user_info['mobile']){
				$recommends=M('recommend')->where('id=1')->getField('recommends');
				if($recommends){
					$recoms=explode(',',$recommends);
					if(in_array($user_info['mobile'],$recoms)){
						$is_yao=true;
					}

				}
			}
		
		if(!$is_yao){
		
		$today=strtotime(date("Y-m-d"),time());
		$time_end=$today+86400;
		
		$loan_count_day = nl_get_customConfig('loan_count_day');
		$loan_count = D('Loan')->where("create_time>$today and create_time<$time_end")->count();
		
		if($loan_count > $loan_count_day){
			$this->error('当日申请订单已满.请明日再试!');
		}
		}


        $min_money = nl_get_customConfig('min_money');
        $min_day = nl_get_customConfig('min_day');
        $max_day = nl_get_customConfig('max_day');
        $step_money = nl_get_customConfig('step_money');
        $money = intval($money / $step_money) * $step_money;
        if ($money > $user_info['quota'] || $money < $min_money) {
            $this->error("贷款金额不符合规范!");
        }
        if ($day > $max_day || $day < $min_day) {
            $this->error("贷款期限不符合规范!");
        }
        session("borrow", array('money' => $money, 'day' => $day));
        $this->success("操作成功!", U('Loan/borrow'));
    }

    //贷款确认
    public function borrow()
    {
        $user_info = getLoginUser();
        $borrow = session("borrow");
        $borrow['fee'] = ($user_info['rate'] / 100) * $borrow['money'] * $borrow['day'];
        $borrow['fee'] = Number_format($borrow['fee'], 2, '.', '');
		
		$borrow['shenhe']=$borrow['fee']*0.3;
		$borrow['jiekuan']=$borrow['fee']*0.6;
		$borrow['lixi']=$borrow['fee']*0.1;
		
        $borrow['money'] = Number_format($borrow['money'], 2, '.', '');
        $borrow['review_money'] = Number_format($borrow['money'] - $borrow['fee'], 2, '.', '');
        $bank_info = M("Auth_bank")->where(array('uid' => $user_info['id']))->find();
        $borrow['bank'] = $bank_info['bank_name'] . ' 尾号' . substr($bank_info['bank_num'], -4);
        ksort($borrow);
        $str = '';
        foreach ($borrow as $key => $value) {
            $str .= $key . '=' . $value;
        }
        $borrow['token'] = md5($str);
        if (IS_POST) {

            $token = I("post.token");
            if (!$token || $token != $borrow['token']) {
                $this->error("当前数据已过期,请刷新页面!");
            }
            $oid = mackOid();
            $arr = array(
                'uid' => $user_info['id'],
                'oid' => $oid,
                'money' => $borrow['money'],
                'day' => $borrow['day'],
                'fee' => $borrow['fee'],
                'bankname' => $bank_info['bank_name'],
                'banknum' => $bank_info['bank_num'],
                'review_money' => $borrow['review_money'],
                'create_time' => time(),
                'borrow_status' => 0,
                'review_time' => 1514901525,
                'review_note' => '',
                'payment_status' => 0,
                'payment_time' => 1514901525,
                'is_read'=>0
            );
            $loan_model = D("Loan");
            $status = $loan_model->add($arr);
            if (!$status) {
                $this->error("创建订单失败!");
            }
            session("borrow", null);
            $this->success("操作成功!", U('Loan/view', array('oid' => $oid)));
        }


        if ($user_info) {
            $auth_idcard = D('Auth_idcard')->where("uid=$user_info[id]")->find();
            $user = D('User')->where("id=$user_info[id]")->find();
            $user['cid'] = "*************" . substr($bank_info['bank_num'], -4);
            $this->assign('auth_idcard', $auth_idcard);
            $this->assign('user', $user);
            //贷款协议
            $protocol = D('Page')->where("id=4")->find();
            $this->assign('protocol', $protocol['content']);
        }

        $this->assign('borrow', $borrow);
        $this->display();
    }

    //贷款记录列表
    public function lists()
    {
        $user_info = getLoginUser();
		
		 //查找满足逾期条件的订单
        $yu_loan = M("Loan")->where(array('uid' => $user_info['id'], 'borrow_status' => 1))->find();
        if ($yu_loan) {
            $is_show=true;
            $yu_day = round((time() - $yu_loan['review_time'] - $yu_loan['day'] * 24 * 3600) / 86400);
            $can_loan_yu_day = nl_get_customConfig("can_loan_yu_day");
            if ($yu_day < $can_loan_yu_day) {
                $is_show=false;
            }
        } else{
            $is_show=false;
        }
        $this->assign('is_show',$is_show);
		$protocol = D('Page')->where("id=7")->find();
         $this->assign('protocol', $protocol['content']);
		
        $loan_model = D("Loan");
        $where = array('uid' => $user_info['id']);
        $count = $loan_model->where($where)->count();
        $Page = new Page($count, 10);
        $show = $Page->show();
        $lists = $loan_model->where($where)->limit($Page->firstRow . ',' . $Page->listRows)->order("id Desc")->select();
        $this->assign('data', $lists);
        $this->assign('page', $show);
        $this->assign('user_info', $user_info);
        $this->display();
    }

    //贷款记录查看
    public function view($oid = '')
    {
        if (!$oid) {
            $this->error("订单参数错误!");
        }
        $this->oid = $oid;
        $loan_model = D("Loan");
        $borrow = $loan_model->where(array('oid' => $oid))->find();
        if (!$borrow) {
            $this->error("订单不存在!");
        }
        $user_info = getLoginUser();
        if ($borrow['uid'] != $user_info['id']) {
            $this->error("您没有权限查看该订单!");
        }
        $info = M("Auth_bank")->where(array('uid' => $user_info['id']))->find();
        $borrow['bank'] = $info['bank_name'] . ' 尾号' . substr($info['bank_num'], -4);
		
		
      	if($borrow['review_time']){	//说明已审核
			$borrow['expire_days'] = round((time() - $borrow['review_time'] - $borrow['day'] * 24 * 3600) / 86400);
		}else{
			$borrow['expire_days']=0;
		}
		$borrow['shenhe']=$borrow['fee']*0.3;
		$borrow['jiekuan']=$borrow['fee']*0.6;
		$borrow['lixi']=$borrow['fee']*0.1;
	
//        ini_set('date.timezone', 'Asia/Shanghai');
//        require_once VENDOR_PATH . "v3wxpay/lib/WxPay.Api.php";
//        require_once VENDOR_PATH . "v3wxpay/WxPay.JsApiPay.php";
//        require_once VENDOR_PATH . 'v3wxpay/log.php';
//
//        if(IS_AJAX){    //续期
//            $price = $borrow['day']*nl_get_customConfig('xu_money')*$borrow['money']/100;
//            $price = $price * 100;
//            $order_name = "微信续期";
//            $order_id = $oid;
//            $notify_b = C("site_url") . "Home/Callback/weixinxuqi_notify";      //不能带参数 接收不到  好坑。。。参数放在SetAttach中
//            $tools = new \JsApiPay();
//            $wx = new WxController();
//            //$openId = $tools->GetOpenid();
//            $openId = $wx->getOpenId();
//            //②、统一下单
//            $input = new \WxPayUnifiedOrder();
//            $input->SetBody("$order_name");
//            $input->SetAttach("$order_id");
//            $input->SetOut_trade_no(\WxPayConfig::MCHID . date("YmdHis"));
//            $input->SetTotal_fee("$price");
//            $input->SetTime_start(date("YmdHis"));
//            $input->SetTime_expire(date("YmdHis", time() + 600));
//            $input->SetGoods_tag($order_id);
//            $input->SetNotify_url($notify_b);
//            $input->SetTrade_type("JSAPI");
//            $input->SetOpenid($openId);
//            $order = \WxPayApi::unifiedOrder($input);
//            $jsApiParameters = $tools->GetJsApiParameters($order);
//            $this->ajaxReturn(json_decode($jsApiParameters,true));
//
//        }else{  //支付
//            $price = $borrow['money']+$borrow['expire_days']*nl_get_customConfig('yu_money')*$borrow['money']/100;
//            $price = $price * 100;
//            $order_name = "微信支付";
//            $order_id = $oid;
//            $notify_b = C("site_url") . "Home/Callback/weixin_notify";      //不能带参数 接收不到  好坑。。。参数放在SetAttach中
//        }
//
//
//        //初始化日志
//        $logHandler = new \CLogFileHandler("logs/" . date('Y-m-d') . '.log');
//        $log = \Log::Init($logHandler, 15);
//
//        //①、获取用户openid
//        $tools = new \JsApiPay();
//        $wx = new WxController();
//        //$openId = $tools->GetOpenid();
//        $openId = $wx->getOpenId();
//        //②、统一下单
//        $input = new \WxPayUnifiedOrder();
//        $input->SetBody("$order_name");
//        $input->SetAttach("$order_id");
//        $input->SetOut_trade_no(\WxPayConfig::MCHID . date("YmdHis"));
//        $input->SetTotal_fee("$price");
//        $input->SetTime_start(date("YmdHis"));
//        $input->SetTime_expire(date("YmdHis", time() + 600));
//        $input->SetGoods_tag($order_id);
//        $input->SetNotify_url($notify_b);
//        $input->SetTrade_type("JSAPI");
//        $input->SetOpenid($openId);
//        $order = \WxPayApi::unifiedOrder($input);
//        $jsApiParameters = $tools->GetJsApiParameters($order);
//        $this->assign("jsApiParameters",$jsApiParameters);

        $this->assign('borrow', $borrow);
        $this->display();
    }


    //我要还款页
    public function pay()
    {
        $this->display();
    }

    //连连支付
    public function lianlian()
    {
	
        require_once(VENDOR_PATH . "lianlian/llpay.config.php");
        $user_info = getLoginUser();
        $json = array(
            "frms_ware_category" => "2010",         //商品类目
            "user_info_mercht_userno" => $llpay_config['oid_partner'],  //商户用户唯一标识
            "user_info_dt_register" => "20161015165530",    //注册时间  用户在平台的注册时间YYYYMMDDH24MISS
            "user_info_bind_phone" => $user_info['mobile'],      //用户在平台注册绑定手机
            "user_info_full_name" => $user_info['name'],          //用户注册姓名
            "user_info_id_no" => $user_info['idcard'], //用户注册证件号码
            "user_info_identify_type" => "1",           //实名认证方式  1：银行卡认证 2：现场认证 3：身份证远程认证 4：其它认证
            "user_info_identify_state" => "1"           //是否实名认证 1：是 0：无认证
        );
        $json = json_encode($json, JSON_UNESCAPED_UNICODE);
        $json = str_replace('"', '\"', $json);
        $this->assign("user_info", $user_info);
        $this->assign("oid_partner", $llpay_config['oid_partner']);
        $this->assign("json", $json);
        $this->display();
    }


    //连连支付api
    public function llpayapi()
    {
        require_once(VENDOR_PATH . "lianlian/llpay.config.php");
        require_once(VENDOR_PATH . "lianlian/lib/llpay_submit.class.php");

        //商户用户唯一编号
        $user_id = $_POST['user_id'];
        //支付类型
        $busi_partner = $_POST['busi_partner'];
        //商户网站订单系统中唯一订单号，必填
        $no_order = $_POST['no_order'];
        //付款金额
        $money_order = $_POST['money_order'];
        //商品名称
        $name_goods = $_POST['name_goods'];
        //订单描述
        $info_order = $_POST['info_order'];
        //卡号
        $card_no = $_POST['card_no'];
        //姓名
        $acct_name = $_POST['acct_name'];
        //身份证号
        $id_no = $_POST['id_no'];
        //协议号
        $no_agree = $_POST['no_agree'];
        //风险控制参数
        $risk_item = $_POST['risk_item'];
        //服务器异步通知页面路径
        $notify_url = C("site_url") . "Home/Callback/lian_notify";
        //需http://格式的完整路径，不能加?id=123这类自定义参数

        //页面跳转同步通知页面路径
        $return_url = C("site_url") . "Home/Callback/lian_return";
        //需http://格式的完整路径，不能加?id=123这类自定义参数，不能写成http://localhost/

        /************************************************************/

        //构造要请求的参数数组，无需改动
        $parameter = array(
            "version" => trim($llpay_config['version']),
            "oid_partner" => trim($llpay_config['oid_partner']),
            "user_id" => $user_id,
            "app_request" => "3",
            "sign_type" => trim($llpay_config['sign_type']),
            "busi_partner" => $busi_partner,
            "no_order" => $no_order.rand(1,200),
            "dt_order" => local_date('YmdHis', time()),
            "name_goods" => $name_goods,
            "info_order" => $no_order,
            "money_order" => $money_order,
            "notify_url" => $notify_url,
            "url_return" => $return_url,
            "no_agree" => $no_agree,
            "valid_order" => trim($llpay_config['valid_order']),
            "id_type" => "0",
            "id_no" => $id_no,
            "acct_name" => $acct_name,
            "risk_item" => $risk_item,
            "card_no" => $card_no,
            "pay_type"=>"D"
        );

        //建立请求
        $llpay_gateway_new = 'https://wap.lianlianpay.com/installment.htm';
        $llpaySubmit = new \LLpaySubmit($llpay_config,$llpay_gateway_new);
        $html_text = $llpaySubmit->buildRequestForm($parameter, "post", "确认");
        echo $html_text;
    }
	public function lianliankefu(){
		$this->display();
	}

    //连连支付续期
    public function lianlianxuqi()
    {
        require_once(VENDOR_PATH . "lianlian/llpay.config.php");
        $user_info = getLoginUser();
        $json = array(
            "frms_ware_category" => "2009",         //商品类目
            "user_info_mercht_userno" => $llpay_config['oid_partner'],  //商户用户唯一标识
            "user_info_dt_register" => "20161015165530",    //注册时间  用户在平台的注册时间YYYYMMDDH24MISS
            "user_info_bind_phone" => $user_info['mobile'],      //用户在平台注册绑定手机
            "user_info_full_name" => $user_info['name'],          //用户注册姓名
            "user_info_id_no" => $user_info['idcard'], //用户注册证件号码
            "user_info_identify_type" => "1",           //实名认证方式  1：银行卡认证 2：现场认证 3：身份证远程认证 4：其它认证
            "user_info_identify_state" => "1"           //是否实名认证 1：是 0：无认证
        );
        $json = json_encode($json, JSON_UNESCAPED_UNICODE);
        $json = str_replace('"', '\"', $json);
        $this->assign("user_info", $user_info);
        $this->assign("oid_partner", $llpay_config['oid_partner']);
        $this->assign("json", $json);
        $this->display();
    }


    //连连支付续期api
    public function llpayapixuqi()
    {
        require_once(VENDOR_PATH . "lianlian/llpay.config.php");
        require_once(VENDOR_PATH . "lianlian/lib/llpay_submit.class.php");

        //商户用户唯一编号
        $user_id = $_POST['user_id'];
        //支付类型
        $busi_partner = $_POST['busi_partner'];
        //商户网站订单系统中唯一订单号，必填
        $no_order = $_POST['no_order'];
        //付款金额
        $money_order = $_POST['money_order'];
        //商品名称
        $name_goods = $_POST['name_goods'];
        //订单描述
        $info_order = $_POST['info_order'];
        //卡号
        $card_no = $_POST['card_no'];
        //姓名
        $acct_name = $_POST['acct_name'];
        //身份证号
        $id_no = $_POST['id_no'];
        //协议号
        $no_agree = $_POST['no_agree'];
        //风险控制参数
        $risk_item = $_POST['risk_item'];

        //服务器异步通知页面路径
        $notify_url = C("site_url") . "Home/Callback/lianxuqi_notify";
        //需http://格式的完整路径，不能加?id=123这类自定义参数

        //页面跳转同步通知页面路径
        $return_url = C("site_url") . "Home/Callback/lianxuqi_return";
        //需http://格式的完整路径，不能加?id=123这类自定义参数，不能写成http://localhost/

        /************************************************************/

        //构造要请求的参数数组，无需改动
        $parameter = array(
            "oid_partner" => trim($llpay_config['oid_partner']),
            "app_request" => "3",
            "sign_type" => trim($llpay_config['sign_type']),
            "valid_order" => trim($llpay_config['valid_order']),
            "user_id" => $user_id,
            "busi_partner" => $busi_partner,
            "no_order" => $no_order,
            "dt_order" => local_date('YmdHis', time()),
            "name_goods" => $name_goods,
            "info_order" => $info_order,
            "money_order" => $money_order,
            "notify_url" => $notify_url,
            "url_return" => $return_url,
            "card_no" => $card_no,
            "acct_name" => $acct_name,
            "id_type" => "0",
            "id_no" => $id_no,
            "no_agree" => $no_agree,
            "risk_item" => $risk_item,
            "version" => trim($llpay_config['version']),
        );

        //建立请求
        $llpay_gateway_new = 'https://wap.lianlianpay.com/installment.htm';
        $llpaySubmit = new \LLpaySubmit($llpay_config,$llpay_gateway_new);
        $html_text = $llpaySubmit->buildRequestForm($parameter, "post", "确认");
        echo $html_text;
    }




}