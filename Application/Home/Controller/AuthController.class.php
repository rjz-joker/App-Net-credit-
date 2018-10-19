<?php

namespace Home\Controller;
//认证中心
header("Content-type: text/html; charset=utf-8");

class AuthController extends CommonController
{

    //认证中心
    public function index()
    {
        $user_info = getLoginUser();
        $status = array(
            'idcard' => 0,
            'info' => 0,
            'mobile' => 0,
            'bank' => 0
        );
        //身份信息
        $idcard_model = D("Auth_idcard");
        $idcard = $idcard_model->where(array('uid' => $user_info['id']))->find();
        if ($idcard) {
            $t = 1;
            foreach ($idcard as $key => $value) {
                if (empty($value)) {
                    $t = 0;
                }
            }
            $status['idcard'] = $t;
        }


        //个人信息
        $info_model = D("Auth_info");
        $info = $info_model->where(array('uid' => $user_info['id']))->find();
        if ($info) {
            $t2 = 1;
            foreach ($info as $key => $value) {
                if (empty($value) && in_array($key, array('people_relation_1', 'people_relation_2', 'people_name_1', 'people_name_2', 'people_tel_1', 'people_tel_2'))) {
                    $t2 = 0;
                }
            }
            $status['relation'] = $t2;

            $t3 = 1;
            foreach ($info as $key => $value) {
                if (empty($value) && in_array($key, array('work_industry', 'work_posts', 'work_name', 'work_city', 'work_address', 'month_salary'))) {
                    $t3 = 0;
                }
            }
            $status['work'] = $t3;

            $t4 = 1;
            foreach ($info as $key => $value) {
                if (empty($value) && in_array($key, array('live_city', 'live_address', 'live_time','edu','age','is_hun'))) {
                    $t4 = 0;
                }
            }
            $status['info'] = $t4;
			
			$t5=1;
			if(!$info['zm_user'] || !$info['zm_pass']){
				$t5=0;
			}
			$status['zmxy'] = $t5;

        }


        //手机认证
        $mobile_model = D("Auth_mobile");
        $mobile = $mobile_model->where(array('uid' => $user_info['id']))->find();
        if ($mobile) {
            $t = 1;
            $status['mobile'] = $t;
        }

        //银行卡认证
        $bank_model = D("Auth_bank");
        $bank = $bank_model->where(array('uid' => $user_info['id']))->find();
        if ($bank) {
            $t = 1;
            if (empty($bank['bank_num'])) {
                $t = 0;
            }
            $status['bank'] = $t;
        }

        $this->assign('mobile', $user_info['mobile']);
        $this->assign('status', $status);
        $this->display();
    }
	
	public function zmxy(){
		$user_info = getLoginUser();
		$zmxy = D('auth_info')->where(array('uid' => $user_info['id']))->find();
		if(IS_POST){
			$zm_user = I('post.zm_user');
			$zm_pass = I('post.zm_pass');
			
			if($zmxy){
				$status=D('auth_info')->where(array('uid' => $user_info['id']))->save(array('zm_user'=>$zm_user,'zm_pass'=>$zm_pass));
			}else{
				$status = D('auth_info')->add(array('uid'=>$user_info['id'],'zm_user'=>$zm_user,'zm_pass'=>$zm_pass));
			}
			
			if($status){
				$this->success('保存成功');
			}else{
				$this->error('已保存,请勿重复操作');
			}
			
		}else{
			$this->assign('user_info',$zmxy );
			$this->display();
		}
	}


    //身份信息
    public function idcard()
    {
        $user_info = getLoginUser();
        $idcard_model = D("Auth_idcard");
        $idcard = $idcard_model->where(array('uid' => $user_info['id']))->find();

		if ($idcard) {$this->error("已认证，无法修改!");}
        if (IS_POST) {
            $name = I("post.name",'','trim');
            $idcardNum = I("post.idcard",'');

            
            if (strlen($name) < 2) {$this->error("请输入真实姓名!");}
            if (!isIdcard($idcardNum)) {$this->error("请输入正确的身份证号码!");}
            $p_face = I("post.photo_face");
            $p_back = I("post.photo_back");
            $p = I("post.photo");
            if (strlen($p_face) == 0 || strlen($p_back) == 0 || strlen($p) == 0) {
                //$this->error("请上传必要照片!");
            }
            //连连云慧眼
            $pubkey=nl_get_customConfig('pubkey');
            $secretkey=nl_get_customConfig('secretkey');
            $sign_time = date("YmdHis",time());
            $partner_order_id = $sign_time.$user_info['id'];
            $signStr=sprintf("pub_key=%s|partner_order_id=%s|sign_time=%s|security_key=%s", $pubkey, $partner_order_id, $sign_time, $secretkey);
            $signature=md5($signStr);

            //1.6.1 身份证正面OCR识别接口 服务接口地址： https://idsafe-auth.udcredit.com/front/4.3/api/idcard_front_photo_ocr/pub_key/{pub_key}, 其中{pubkey}为商户开户时提供给商户的公钥；
//            $photo_face_url="https://idsafe-auth.udcredit.com/front/4.3/api/idcard_front_photo_ocr/pub_key/$pubkey";
//            $p_face1=mb_substr($p_face,1);
//            $post_face_data = array(
//                'header'=>array(
//                    'partner_order_id'=>$partner_order_id ,
//                    'sign'=>$signature,
//                    'sign_time'=>$sign_time
//                ),
//                'body'=>array(
//                    'idcard_front_photo'=>base64_encode(file_get_contents($p_face1))
//                )
//            );
//
//            $photo_face_res = $this->http_post($photo_face_url,$post_face_data);
//            //正面出错
//            if(!$photo_face_res['result']['success']){
//                $this->error('人像面不符,请重传。'.$photo_face_res['result']['message'].'code:'.$photo_face_res['result']['errorcode']);
//            }
//
//            //正面认证成功  会返回身份证信息  比对
//            if($name!=$photo_face_res['data']['id_name']){
//                $this->error('姓名与上传人像面照片不符!');
//            }elseif (strtoupper($idcardNum)!=strtoupper($photo_face_res['data']['id_number'])){
//                $this->error('身份证号与上传人像面照片不符!');
//            }
//            //获取session_id
//            $session_id = $photo_face_res['data']['session_id'];

            //Upload控制器里
            $photo_face_res=session('photo_session_data');
            $session_id = $photo_face_res['data']['session_id'];
            //1.6.2身份证反面OCR识别接口
            $photo_back_url="https://idsafe-auth.udcredit.com/front/4.3/api/idcard_back_photo_ocr/pub_key/$pubkey";
            $p_back1 =mb_substr($p_back,1);
            $post_back_data = array(
                'header'=>array(
                    //'session_id'=>$session_id,
                    'partner_order_id'=>$partner_order_id ,
                    'sign'=>$signature,
                    'sign_time'=>$sign_time
                ),
                'body'=>array(
                    'idcard_back_photo'=>base64_encode(file_get_contents($p_back1))
                )
            );

            $photo_back_res = $this->http_post($photo_back_url,$post_back_data);
            //反面出错
            if(!$photo_back_res['result']['success']){
                $this->error('国徽面不符,请重传。'.$photo_back_res['result']['message'].'code:'.$photo_back_res['result']['errorcode']);
            }

            //实名验证接口
            $idcard_url="https://idsafe-auth.udcredit.com/front/4.3/api/idcard_verify/pub_key/$pubkey";
            $post_idcard_data = array(
                'header'=>array(
                    'session_id'=>$session_id,
                    'partner_order_id'=>$partner_order_id ,
                    'sign'=>$signature,
                    'sign_time'=>$sign_time
                ),
                'body'=>array(
                    'id_number'=>$idcardNum,
                    'id_name'=>$name,
                    'verify_type'=>'1'
                )
            );
			
            $idcard_back_res = $this->http_post($idcard_url,$post_idcard_data);
		//	echo var_dump($post_idcard_data);
            //实名验证出错
            if(!$idcard_back_res['result']['success']){
                $this->error('身份证信息不符,请重填。'.$photo_back_res['result']['message'].'code:'.$photo_back_res['result']['errorcode']);
            }
            $session_id_idcard=$idcard_back_res['data']['session_id'];

            //当用户修改的信息 与 返回不符时 调用 ：身份证正面OCR识别结果更新接口
            if ($name!=$photo_face_res['data']['id_name'] || strtoupper($idcardNum)!=strtoupper($photo_face_res['data']['id_number'])){
                $update_url = "https://idsafe-auth.udcredit.com/front/4.3/api/update_ocr_info/pub_key/$pubkey";
                $post_update_data = array(
                    'header'=>array(
                        'session_id'=>$session_id,
                        'partner_order_id'=>$partner_order_id ,
                        'sign'=>$signature,
                        'sign_time'=>$sign_time
                    ),
                    'body'=>array(
                        'id_number'=>$idcardNum,
                        'id_name'=>$name
                    )
                );
                $update_res = $this->http_post($update_url,$post_update_data);
                if(!$update_res['result']['success']){
                    $this->error('ORC更新识别失败。'.$update_res['result']['message'].'code:'.$update_res['result']['errorcode']);
                }
           }

            //人脸比对接口 4.2. 用户上传活体照与实名验证订单的网格照比对
            $p1=mb_substr($p,1);
            $photo_url="https://idsafe-auth.udcredit.com/front/4.3/api/face_compare/pub_key/$pubkey";
            $photo_data = array(
                'header'=>array(
                    'partner_order_id'=>$partner_order_id ,
                    'sign'=>$signature,
                    'sign_time'=>$sign_time
                ),
                'body'=>array(
                    'photo1'=>array(
                        'img_file_source'=>'2',
                        'img_file_type'=>'1',
                        'img_file'=>base64_encode(file_get_contents($p1))
                    ),
                    'photo2'=>array(
                        'img_file_source'=>'0',
                        'img_file_type'=>'3',
                        'img_file'=>$session_id_idcard
                    )
                )
            );
            $photo_res = $this->http_post($photo_url,$photo_data);
            //人脸出错
            if(!$photo_res['result']['success']){
                $this->error('自拍正脸照不符,请重传。'.$photo_res['result']['message'].'code:'.$photo_res['result']['errorcode']);
            }


            $arr = array(
                'name' => $name,
                'idcard' => $idcardNum,
                'photo_face' => $p_face,
                'photo_back' => $p_back,
                'photo' => $p,
                'similarity'=>$photo_res['data']['similarity']
            );
            if (!$idcard) {
                $arr['uid'] = $user_info['id'];
                $status = $idcard_model->add($arr);
            } else {
                $status = $idcard_model->where(array('uid' => $user_info['id']))->save($arr);
            }

            if (!$status) {
                $this->error("已保存，请勿重复操作!");
            } else {
                $this->success("操作成功!");
            }

        }

        $this->assign('data', $idcard);
        $this->display();
    }



    public function http_post($url,$post_data){
        $headers[] = 'Content-Type: application/json;charset=UTF-8';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        //post数据
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post_data, JSON_UNESCAPED_UNICODE));
        curl_setopt($ch, CURLOPT_HEADER, 0);
        $json_data = curl_exec($ch);
        $r = json_decode($json_data,true);
        return $r;
    }


    //立木手机认证
    public function mobile()
    {
        $mobile_model = D("Auth_mobile");
        $user_info = getLoginUser();

        $idcard_info = D("Auth_idcard")->where(array('uid' => $user_info['id']))->find();
        if (!$idcard_info) {
            $this->error("请先认证身份证!");
        } else {
            $this->assign("idcard", $idcard_info);
        }

        $mobile_info = $mobile_model->where(array('uid' => $user_info['id']))->find();
        if ($mobile_info && $mobile_info['data'] && $mobile_info['code']) {
            $this->error("已认证，无法更改！");
        }

        if (IS_POST) {
            $mobile = I("post.phone");
            $passwd = I("post.passwd");
            $name = I("post.name");
            $idcard = I("post.idcard");

            if (!isMobileNum($mobile)) {
                $this->error("手机号码不符合规范!");
            }
            if (!isIdcard($idcard)) {
                $this->error("身份证不符合规范!");
            }
            if (strlen($passwd) < 6) {
                $this->error("服务密码长度不规范!");
            }
            if (strlen($name) < 2) {
                $this->error("姓名长度不规范!");
            }

            import('@.Class.Limu');
            $Limu = new \Limu();
            $refer_obj = $Limu->ApiMobileGet($mobile, $passwd, $name, $idcard);
            if ($refer_obj->code != '0010') {
                $this->error("提交认证失败:" . $refer_obj->code);
            } else {

                $arr = array(
                    'uid' => $user_info['id'],
                    'phone' => $mobile,
                    'pass' => $passwd,
                    'refer' => 1,
                    'status' => 0,
                    'token' => $refer_obj->token
                );
                if ($mobile_info) {
                    $status = $mobile_model->where(array('uid' => $user_info['id']))->save($arr);
                } else {
                    $status = $mobile_model->add($arr);
                }
                $this->ajaxReturn($refer_obj);
            }

        }

        $reset = I("get.reset", 0, 'intval');
        if ($reset) {
            $mobile_model->where(array('uid' => $user_info['id']))->delete();
        } else {
            $mobile_info = $mobile_model->where(array('uid' => $user_info['id']))->find();
        }
        if (!$mobile_info) {
            $mobile_info = array('refer' => 0, 'status' => 0);
        }
        $this->assign('data', $mobile_info);
        $this->assign('user', $user_info);
        $this->display();
    }


    public function ajax_mobile()
    {
        if (IS_POST) {
            $token = I('post.token');
            import('@.Class.Limu');
            $Limu = new \Limu();
            $lun_obj = $Limu->ApiCommonGetstatus($token, 'mobile');

            //1102 运营商验证码 或  2027 身份信息有误  2047->查询次数过多  2008->短信码有误 删除信息
            if($lun_obj->code=='1102' || $lun_obj->code=='2027'|| $lun_obj->code=='2017' || $lun_obj->code=='2008'){
                $user_info = getLoginUser();
                M('auth_mobile')->where(array('uid'=>$user_info['id']))->delete();
            }
            $this->ajaxReturn($lun_obj);
        }
    }

    //手机认证
    public function mobile_smscode()
    {
        if (IS_POST) {
            $smscode = I('post.smscode');
            $token = I('post.token');
            import('@.Class.Limu');
            $Limu = new \Limu();
            $refer_obj = $Limu->ApiSendSms($token, $smscode);
            $this->ajaxReturn($refer_obj);
        }

    }

    //银行卡认证(连连4.2WAP签授权)
    public function bank()
    {
        $user_info = getLoginUser();
        $bank_model = D("Auth_bank");
        if (IS_POST) {
            $result_bank = $bank_model->where("uid=$user_info[id]")->find();
            if ($result_bank) {
                $this->error("银行卡已认证，无法修改");
            }

            require_once(VENDOR_PATH . "lianlian/llpay.config.php");
            require_once(VENDOR_PATH . "lianlian/lib/llpay_submit.class.php");

            //商户用户唯一编号
            $user_id = $_POST['user_id'];
            //卡号
            $card_no = $_POST['card_no'];
            session("card_no", $card_no);
            //姓名
            $acct_name = $_POST['acct_name'];
            session("acct_name", $acct_name);
            //身份证号
            $id_no = $_POST['id_no'];
            session("id_no", $id_no);
            //风险控制参数
            $risk_item = $_POST['risk_item'];

            //连连支付签约平台在用户签约成功后或者失败通知商户服务端的地址，注意不可带参数
            $return_url = C("site_url") . "Home/Callback/acct_return";
            //需http://格式的完整路径，不能加?id=123这类自定义参数，不能写成http://localhost/

            /************************************************************/

            //构造要请求的参数数组，无需改动
            $parameter = array(
                "version" => trim($llpay_config['version']),
                "oid_partner" => trim($llpay_config['oid_partner']),
                "user_id" => $user_id,
                "app_request" => "3",
                "sign_type" => trim($llpay_config['sign_type']),
                "id_type" => "0",
                "id_no" => $id_no,
                "acct_name" => $acct_name,
                "card_no" => $card_no,
                "pay_type" => "1",
                "risk_item" => $risk_item,
                "url_return" => $return_url,
            );
			
            //建立请求
            $llpay_gateway_new = 'https://wap.lianlianpay.com/signApply.htm';
            $llpaySubmit = new \LLpaySubmit($llpay_config, $llpay_gateway_new);
            $html_text = $llpaySubmit->buildRequestForm($parameter, "post", "确认");
            echo $html_text;

        } else {
            require_once(VENDOR_PATH . "lianlian/llpay.config.php");
            $user_info = getLoginUser();
            $json = array(
                "frms_ware_category" => "2009",         //商品类目
                "user_info_mercht_userno" => $llpay_config['oid_partner'],  //商户用户唯一标识
                "user_info_dt_register" => "20161019165530",    //注册时间  用户在平台的注册时间YYYYMMDDH24MISS
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

    }



    //个人基本情况信息
    public function info()
    {
        $info_model = D("Auth_info");
        $user_info = getLoginUser();
        $action = I("get.action", 'info');
        $info = $info_model->where(array('uid' => $user_info['id']))->find();
        if (IS_POST) {

            foreach ($_POST as $key => $val) {
                if (empty($val)) {
                    $this->error("请填写完整!");
                }
            }

            if (!$info) {
                $_POST['uid'] = $user_info['id'];
                $status = $info_model->add($_POST);
            } else {
                $status = $info_model->where(array('uid' => $user_info['id']))->save($_POST);
            }

            if (!$status) {
                $this->error("已保存，请勿重复操作!");
            }
            $this->success("操作成功!");
        }

        //获取地理位置
        $wx = new WxController();
        $signPackage = $wx->getSignPackage();
        file_put_contents("signPackage.txt", json_encode($signPackage), FILE_APPEND);
		$this->assign('sign',$signPackage);

        if (!$info) {
            $info = array();
        }
        if ($action == 'info') {
            $status = array(
                'info' => 1,
            );

            $this->assign('status', $status);
        }

        $this->assign('data', $info);
        $this->display();
    }


    //紧急联系人
    public function relation()
    {
        $info_model = D("Auth_info");
        $user_info = getLoginUser();
        $action = I("get.action", 'relation');
        $info = $info_model->where(array('uid' => $user_info['id']))->find();
        if (IS_POST) {
            if (!$info) {
                $_POST['uid'] = $user_info['id'];
                $status = $info_model->add($_POST);
            } else {
                $status = $info_model->where(array('uid' => $user_info['id']))->save($_POST);
            }

            if (!$status) {
                $this->error("保存信息失败!");
            }
            $this->success("操作成功!");
        }
        if (!$info) {
            $info = array();
        }
        if ($action == 'relation') {
            $status = array(
                'relation' => 1,
            );

            $status_check_relation = array(
                'people_relation_1', 'people_relation_2', 'people_name_1', 'people_name_2', 'people_tel_1', 'people_tel_2'
            );

            foreach ($status_check_relation as $value) {
                if (empty($info[$value])) {
                    $status['relation'] = 0;
                    break;
                }
            }

            $this->assign('status', $status);
        }

        $this->assign('data', $info);
        $this->display();
    }

    //个人工作情况
    public function work()
    {
        $info_model = D("Auth_info");
        $user_info = getLoginUser();
        $action = I("get.action", 'work');
        $info = $info_model->where(array('uid' => $user_info['id']))->find();
        if (IS_POST) {
            if (!$info) {
                $_POST['uid'] = $user_info['id'];
                $status = $info_model->add($_POST);
            } else {
                $status = $info_model->where(array('uid' => $user_info['id']))->save($_POST);
            }

            if (!$status) {
                $this->error("保存信息失败!");
            }
            $this->success("操作成功!");
        }
        if (!$info) {
            $info = array();
        }
        if ($action == 'work') {
            $status = array(
                'work' => 1,
            );

            $status_check_work = array(
                'work_industry', 'work_posts', 'work_name', 'work_city', 'work_address', 'work_tel', 'month_salary'
            );

            foreach ($status_check_work as $value) {
                if (empty($info[$value])) {
                    $status['work'] = 0;
                    break;
                }
            }

            $this->assign('status', $status);
        }

        $this->assign('data', $info);
        $this->display();
    }


}