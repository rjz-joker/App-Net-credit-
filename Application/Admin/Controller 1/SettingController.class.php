<?php
namespace Admin\Controller;
class SettingController extends PublicController {

    /*
     *  获取配置并显示表单
     * */
    public function index(){
        //获取前台模板列表
        $homeSkin = nl_getFoderlist(TMPL_PATH.'Home/',true);
        $adminSkin= nl_getFoderlist(TMPL_PATH.'Admin/',true);
        $this->assign('homeskin',$homeSkin);
        $this->assign('adminskin',$adminSkin);
        $this->display();
    }

    /*
     *  保存信息
     * */
    public function save(){
        add_log(getAdminId(),CONTROLLER_NAME.'/'.ACTION_NAME,'修改网站信息');

        $save_path = array(
            'site'  =>  array(
                'filename'  =>  'site',
                'rewrit'    =>  true
            ),
            'url'   =>  array(
                'filename'  =>  'url',
                'rewrit'    =>  false
            ),
            'debug' =>  array(
                'filename'  =>  'debug',
                'rewrit'    =>  true
            ),
            'upload'=>  array(
                'filename'  =>  'upload',
                'rewrit'    =>  true
            )
        );
        $action=I("get.action",'','trim');
        if(!$action){
            $this->error("提交参数有误!",'',true);
        }
        if($action != "skin"){
            $save_path = CONF_PATH.'/'.$save_path[$action]['filename'].'.php';
            foreach($_POST as $key => $val){
                $_POST[$key] = htmlspecialchars($val);
            }
            if($save_path[$action]['rewrit']){
                if(!nl_writeArr($_POST,$save_path)){
                    $this->error('修改配置失败','',true);
                }
            }else{
                if(!nl_updateArr($_POST,$save_path)){
                    $this->error('修改配置失败','',true);
                }
            }
        }else{
            $skin = I("post.skin");
            $homeskin = empty($skin['home'])?'default':$skin['home'];
            $adminskin = empty($skin['admin'])?'default':$skin['admin'];
            unset($_POST);
            $_POST = array(
                'DEFAULT_THEME' =>  $adminskin,
                'HOME_THEME'    =>  $homeskin
            );
            foreach($_POST as $key => $val){
                $_POST[$key] = htmlspecialchars($val);
            }
            $save_path = CONF_PATH.'/Admin/config.php';
            //更新后台配置文件
            if(!nl_updateArr($_POST,$save_path)){
                $this->error('修改配置失败','',true);
            }
            //更新前台配置文件
            $save_path = CONF_PATH.'/Home/config.php';
            unset($_POST);
            $_POST['DEFAULT_THEME'] = htmlspecialchars($homeskin);
            if(!nl_updateArr($_POST,$save_path)){
                $this->error('修改配置失败','',true);
            }
        }
        $this->success('修改成功','',true);
    }

    /*
     *  修改自己的密码
     * */
    public function modify(){
        if(IS_POST){
            $oldpass = I("post.oldpass",'','trim');
            $password=I("post.password",'','trim');
            $repass=I("post.repassword",'','trim');
            if(!$oldpass){
                $this->error("原密码不能为空!");
            }
            if(!$password){
                $this->error("新密码不能为空!");
            }
            if(strlen($password) < 6 || strlen($password) > 18){
                $this->error("密码长度必须为6-18位!");
            }
            if($password != $repass){
                $this->error("两次密码输入不一致!");
            }
            $admin_model=D("Admin");
            $uinfo=nl_get_adminuser();
            $info = $admin_model->where(array(
                                        'username'=>$uinfo['username'],
                                        'password'=>$admin_model->getPass($oldpass)
                                    ))->count();
            if(!$info){
                $this->error("原密码输入有误!");
            }
            $status=$admin_model->where(array(
                                        'username'=>$uinfo['username']
                                    ))->save(array(
                                        'password'=>$admin_model->getPass($password)
                                    ));
            if(!$status){
                $this->error("密码修改失败,请重试!");
            }
            add_log(getAdminId(),CONTROLLER_NAME.'/'.ACTION_NAME,'修改密码为:'.$repass);
            $this->success("新密码已生效,请牢记您的新密码!");
        }else{
            $this->display();
        }

    }


}