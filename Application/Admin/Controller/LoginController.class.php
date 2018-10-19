<?php

namespace Admin\Controller;

use Think\Controller;

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/27
 * Time: 8:40
 */
class LoginController extends Controller
{

    public function index()
    {
        if ($this->is_Login()) $this->redirect(U('Index/index'), array(), 0);
        if (IS_POST) {
            $username = I("post.username", '', 'trim');
            $password = I("post.password", '', 'trim');
            if (!$username || !$password) $this->error("用户名或密码不能为空!");
            $Admin = D("Admin");
            $where = array('username' => $username, 'password' => $Admin->getPass($password));
            $admin = $Admin->where($where)->find();
            if (!$admin) $this->error("用户名或密码输入有误!");
            if ($admin['status'] != 1) $this->error("您的帐号已被禁用,请联系管理员!");
            $this->set_Login($admin);
            add_log(getAdminId(),CONTROLLER_NAME.'/'.ACTION_NAME,'进入了后台');
            $this->success("登录成功!", U('Index/index'), 2);
        } else {
            $this->display();
        }
    }

    public function is_Login()
    {
        $admin = session(C("ADMIN_INFO"));
        return empty($admin) ? false : true;
    }

    public function set_Login($admin = '')
    {
        if (!empty($admin)) {
            M("Admin")->where(array('id' => $admin['id']))->save(array('login_time' => time(), 'login_ip' => get_client_ip()));
            unset($admin['password']);
            session(C("ADMIN_INFO"), $admin);

            $overtime = trim(nl_get_customConfig("overtime"));
            if($overtime<>0 && is_numeric($overtime)){     //登出超时
                session("login_time", time());
            }

        } else {
            session(C("ADMIN_INFO"), null);
        }
    }


}