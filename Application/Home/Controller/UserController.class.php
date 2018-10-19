<?php

namespace Home\Controller;

/*
	会员控制器
 */
use Org\Util\Card;

class UserController extends CommonController
{

    //会员中心
    public function index()
    {
        if (!isLogin()) {
            $this->redirect('User/login');
        } else {
            $this->display();
        }
    }

    //用户登录
    public function login()
    {
        if (isLogin()) {
            $this->redirect('Index/index');
        }
        $openId = session("openId");
        if (IS_POST) {
            $mobile = I("post.mobile");
            $passwd = I("post.passwd",0);
            if (!isMobileNum($mobile)) {
                $this->error("手机号码不符合规范!");
            }
            $user_model = D("User");


                if(strlen($passwd) < 6 || strlen($passwd) > 20){
                    $this->error("密码长度不符合规范!");
                }
                $passwd = getPass2User($passwd);
                $r = $user_model->where(array(
                    'mobile' => $mobile,
                    'password' => $passwd
                ))->find();
                if (!$r) {
                    $this->error("手机号或密码有误！");
                }


            unset($r['password']);
            $this->setLogin($r);
            $this->success("登录成功!", U('Index/index'));
        } else {
            $this->display();
        }

    }

    //注销登录
    public function logout()
    {
        $this->setLogin('');
        $this->redirect('Index/index');
    }

    //用户注册
    public function reg()
    {
        if (isLogin()) {
            $this->redirect('Index/index');
        }
        if (IS_POST) {
            $mobile = I("post.mobile");
            $vcode = I("post.vcode");
            $passwd = I("post.passwd", 0);
            $agree = I("post.agree", 0, 'intval');
          //  $yao_code = I("post.yao_code", '');
			
			$is_yao=0;
			if($mobile){
				$recommends=M('recommend')->where('id=1')->getField('recommends');
				if($recommends){
					$recoms=explode(',',$recommends);
					if(in_array($mobile,$recoms)){
						$is_yao=1;
					}

				}
			}
			
		
			if(!$is_yao){
				
				$today=strtotime(date("Y-m-d"),time());
				$time_end=$today+86400;
				$reg_count = D('Loan')->where("create_time>$today and create_time<$time_end")->count();
				$reg_count_day = nl_get_customConfig('reg_count_day');
	
				if($reg_count > $reg_count_day){
					$this->error('当日注册用户名额已满.请明日再试!');
				}
			}
		    
		
		   
            if ($agree == 0) {
                $this->error("您没同意注册协议!");
            }

            if (!isMobileNum($mobile)) {
                $this->error("手机号码不符合规范!");
            }
            if (strlen($vcode) != 4) {
                $this->error("验证码长度不规范!");
            }

            if (strlen($passwd) < 6 || strlen($passwd) > 20) {
                $this->error("密码长度不符合规范!");
             }


            $smslog_model = D("Smslog");
            $cinfo = $smslog_model->checkCode($mobile, $vcode, 'reg');
            if (!$cinfo) {
                $this->error("验证码输入有误!");
            }
            if ($cinfo['create_time'] - time() > 30 * 60) {
                $this->error("验证码已过期,请重新获取!");
            }

            $user_model = D("User");
            $r = $user_model->where(array('mobile' => $mobile))->count();
            if ($r) {
                $this->error("手机号已注册,请登录!");
            }
            $arr = array(
                'mobile' => $mobile,
                'password' => getPass2User($passwd),
                'cid' => '',
                'quota' => nl_get_customConfig('userquota'),
                'rate' => nl_get_customConfig('userrate'),
                'status' => 1,
                'is_new' => 0,
                //'recommend' => $recommend,
                'create_time' => time(),
                'open_id' => '',
				'is_yao'=>$is_yao
            );
            $status = $user_model->add($arr);

            if (!$status) {
                $this->error("操作失败!");
            }
            $card = new Card();
            $card_num = $card->generateNumber($status, 62);
            $user_model->where('mobile=' . $mobile)->save(array('cid' => $card_num));

            unset($arr['password']);
            $arr['id'] = $status;
            $arr['cid'] = $card_num;

            $this->setLogin($arr);
            $this->success("注册成功!", U('Index/index'));
        } else {
            //用户使用协议
            $recommend = I('get.recommend');
            $protocol = D('Page')->where("id=2")->find();
            $this->assign('protocol', $protocol['content']);
            $this->assign('recommend', $recommend);
            $this->display();

        }

    }

    //发送注册验证码
    public function getVCode($type = 'reg')
    {
		
        $mobile = I("post.mobile");
        if (!isMobileNum($mobile)) {
            $this->error("手机号码不符合规范!");
        }
        $smslog_model = D("Smslog");
        //验证当日发送次数
        if (!$smslog_model->checkUp($mobile)) {
            $this->error("您今日获取短信次数已用完,请明天再试!");
        }
        //短信发送成功返回0
        if ($smslog_model->sendCode($mobile, $type)) {
            $this->error("短信发送失败!");
        }
        $this->success("发送成功!");
    }

    //找回密码
    public function findpass()
    {
        if (IS_POST) {
            $mobile = I("post.mobile");
            $passwd = I("post.passwd");
            $vcode = I("post.vcode");
            if (isLogin()) {
                //$info = getLoginUser();
                //$mobile = $info['mobile'];
            }
            if (!isMobileNum($mobile)) {
                $this->error("手机号码不符合规范!!");
            }
            if (strlen($vcode) != 4) {
                $this->error("验证码长度不规范!");
            }
            if (strlen($passwd) < 6 || strlen($passwd) > 20) {
                $this->error("密码长度不符合规范!");
            }
            $smslog_model = D("Smslog");
            $cinfo = $smslog_model->checkCode($mobile, $vcode, 'findpass');
            if (!$cinfo) {
                $this->error("验证码输入有误!");
            }
            if ($cinfo['create_time'] - time() > 30 * 60) {
                $this->error("验证码已过期,请重新获取!");
            }
            $newpass = getPass2User($passwd);
            $user_model = D("User");
            $r = $user_model->where(array('mobile' => $mobile))->count();
            if (!$r) {
                $this->error("手机号尚未注册,请先注册!");
            }
            $status = $user_model->where(array('mobile' => $mobile))->save(array('password' => $newpass));
            if (!$status) {
                $this->error("操作失败!");
            }
            $this->success("密码修改成功!", U("User/index"));
        } else {
            $this->display();
        }
    }

}