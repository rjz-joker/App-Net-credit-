<?php

namespace Home\Controller;

class CommonController extends \Think\Controller
{

    public function _initialize()
    {
        //移动设备浏览且开启了手机独立主题，则切换模板
        $site_mobile = C('site_mobile');
        if (!empty($site_mobile) && ismobile()) {
            //设置默认默认主题为 mobile
            C('DEFAULT_THEME', 'mobile');
        }

        if(!IS_AJAX){
            if (!isLogin() && ACTION_NAME !='login' && ACTION_NAME !='reg'&& ACTION_NAME !='findpass') {
                $this->redirect('User/login');
            }
        }

    }

//设置前台用户登录状态
    protected function setLogin($arr = '')
    {
        $session_name = nl_get_customConfig('loginsession');
        if (empty($arr)) {
            session(null);
            return true;
        }
        session($session_name, $arr);
        return true;
    }

}