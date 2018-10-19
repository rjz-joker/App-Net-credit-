<?php
namespace Org\Util;
/*
		验证短信接口
		http://smsbao.com/
 */
class Sms{

	/*
		phone   : 发送手机号
		content : 发送内容
		返回0成功,其他内容为错误信息/错误码
	 */
	public function sendSms($phone,$content){
		$smsuser = nl_get_customConfig('smsuser');
		$smspass = md5(nl_get_customConfig('smspass'));
		$url = "http://api.smsbao.com/sms?u={$smsuser}&p={$smspass}&m={$phone}&c=".urlencode($content);
		$r = file_get_contents($url);
		if($r == '0'){
			return 0;
		}else{
			return $r;
		}
	}


	/*
	错误代码表
	30：密码错误
	40：账号不存在
	41：余额不足
	42：帐号过期
	43：IP地址限制
	50：内容含有敏感词
	51：手机号码不正确
	 */

}