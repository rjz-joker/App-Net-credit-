<?php
//获取后台登录用户信息
function nl_get_adminuser(){
    if(!empty($_SESSION['NorthCMS_AdminUser'])){
        $arr = $_SESSION['NorthCMS_AdminUser'];
        if(!empty($arr)){
            return $arr;
        }
        return '';
    }
    return '';
}

function getAdminId(){
    return nl_get_adminuser()['id'];
}

//auth权限认证
function authCheck($ruleName,$uid){
    if(session(C('ADMIN_INFO'))['username'] == 'admin'){
        return true;
    }else{
        $auth = new \Think\Auth();
        return $auth->check($ruleName,$uid);
    }

}

//生成一个订单号
function mackOid(){
    $yCode = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J');
    $orderSn = $yCode[intval(date('Y')) - 2011] . strtoupper(dechex(date('m'))) . date('d') . substr(time(), -5) . substr(microtime(), 2, 5) . sprintf('%02d', rand(0, 99));
    return $orderSn;
}

function getAdminUserName($id){
    $username= M('Admin')->where(array('id'=>$id))->getField('username');
    return $username;
}

//操作记录
function add_log($admin_id,$url,$msg){
    $data=array(
        'admin_id'=>$admin_id,
        'url'=>$url,
        'msg'=>$msg,
        'create_time'=>time()
    );
    M('log')->add($data);
}
