<?php

//获取当前用户信息
function getLoginUser(){
	$session_name = nl_get_customConfig('loginsession');
	$arr = session($session_name);
	if($arr){
		preg_match('/([\d]{4})([\d]{4})([\d]{4})([\d]{4})?/',$arr['cid'],$match);
		unset($match[0]);
		$arr['cid'] = implode(' ', $match);
		$arr['rmobile'] = mask_number($arr['mobile'],4);
	}
    $user_info =D("user")->where(array('id'=>$arr['id']))->find();
	if($user_info){
        $idcard_info =D("auth_idcard")->where(array('uid'=>$arr['id']))->find();
        $bank_info =D("auth_bank")->where(array('uid'=>$arr['id']))->find();
        $user_info['name'] =$idcard_info['name'];
        $user_info['idcard'] =$idcard_info['idcard'];
        $user_info['bank_num'] =$bank_info['bank_num'];
        $user_info['agreeno'] =$bank_info['agreeno'];
        unset($user_info['password']);
    }
    return $user_info;

}

//返回当前用户登录状态
function isLogin(){
	$info = getLoginUser();
	if(empty($info)){
		return false;
	}
	return true;
}

//生成一个订单号
function mackOid(){
	$yCode = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J');
	$orderSn = $yCode[intval(date('Y')) - 2011] . strtoupper(dechex(date('m'))) . date('d') . substr(time(), -5) . substr(microtime(), 2, 5) . sprintf('%02d', rand(0, 99));
	return $orderSn;
}

function startWith($str, $needle) {
	return strpos($str, $needle) === 0;
}