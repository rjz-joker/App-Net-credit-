<?php

namespace Home\Controller;

use Think\Controller;

class IndexController extends Controller
{

    public function index()
    {
        $site_use = C("site_use");
        if ($site_use == 2) {  //证明微信端用
            $wx = new WxController();
            if (!session("openId")) {       //说明第一次登录或退出微信
                $openId=$wx->getOpenId();
                if (!$openId) {
                    $this->error('获取openId失败，请重新授权！');
                } else {
                    session("openId", $openId);
                }
            } else {
                $openId = session("openId");
            }
			
            $where['open_id'] = $openId;
            $user = D("User")->where($where)->find();

			if (C('site_use') == 1) {   //网页端
				if (!isLogin()) {
					$this->redirect('User/foreign');
				}
			} else {                //微信端
				if (!$user) {
					$this->redirect('User/reg');
				}else{
					$this->setLogin($user);
				}
        }
			
	
        }


        $index_info = D('Page')->where("id=6")->find();
        $this->assign('index_info', $index_info);
        if (isLogin()) {
            $user_info = getLoginUser();
            $this->user_info = $user_info;
            $this->AuthStatus = $this->checkAuth();

            $where['uid'] = $user_info['id'];
            $where['borrow_status'] = 1;
            $review_moneys = D('Loan')->where($where)->sum('money');
            if (!$review_moneys) {
                $review_moneys = 0;
            }
            $this->review_moneys = $review_moneys;
            $this->display();
        } else {
            $this->display('foreign');
        }
    }



    //设置前台用户登录状态
    protected function setLogin($arr = '')
    {
        $session_name = nl_get_customConfig('loginsession');
        if (empty($arr)) {
            session($session_name, null);
            return true;
        }
        session($session_name, $arr);
        return true;
    }


    //检查信息认证填写
    public function checkAuth()
    {
        if (!isLogin()) {
            return 0;
        }
        $user_info = getLoginUser();
        $AuthStatus = 4;

        $info_model = D("Auth_info");
        $info = $info_model->where(array('uid' => $user_info['id']))->find();
        if (!empty($info)) {
            foreach ($info as $key => $value) {
                if (empty($value) && $key!='zm_user' && $key!='zm_pass'  && $key!='work_tel') {
                    $AuthStatus--;
                    break;
                }
            }
        } else {
            $AuthStatus--;
        }

        $idcard_model = D("Auth_idcard");
        $info = $idcard_model->where(array('uid' => $user_info['id']))->find();
        if (!empty($info)) {
            foreach ($info as $key => $value) {
                if (empty($value)) {
                    $AuthStatus--;
                    break;
                }
            }
        } else {
            $AuthStatus--;
        }


        $bank_model = D("Auth_bank");
        $info = $bank_model->where(array('uid' => $user_info['id']))->find();
        if (!empty($info)) {
            foreach ($info as $key => $value) {
                if (empty($value) && $key == "bank_num") {
                    $AuthStatus--;
                    break;
                }
            }
        } else {
            $AuthStatus--;
        }


        $mobile_model = D("Auth_mobile");
        $info = $mobile_model->where(array('uid' => $user_info['id']))->find();
        if (!empty($info)) {
            foreach ($info as $key => $value) {
                if (empty($value) && $key == 'token') {
                    $AuthStatus--;
                    break;
                }
            }
        } else {
            $AuthStatus--;
        }


        return $AuthStatus;
    }


}