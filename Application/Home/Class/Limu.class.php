<?php
/*
	
	立木征信类

 */
class Limu{
		public $callbackUrl;
		public $ApiUrl = 'https://api.limuzhengxin.com/api/gateway';//正式
		//public $ApiUrl = 'https://t.limuzhengxin.cn:3443/api/gateway';//测试
		/*
			手机运营商数据查询
			请求方式：http post
			返回格式：json
			响应模式：异步
		 */
		public function ApiMobileGet($mobile,$passwd,$name,$idcard){
			$this->callbackUrl = C('site_url').'Home/Callback/mobileAuth.html';
			$data = array(
				'method'		=>	'api.mobile.get',
				'apiKey'		=>	nl_get_customConfig('limu_apiKey'),
				'callBackUrl'	=>	($this->callbackUrl),
				'version'		=>	'1.2.0',
				'username'		=>	$mobile,
				'accessType'    =>  'api',
				//'isReport'      =>  1,
				'identityName'  =>  $name,
				'identityCardNo'=>  $idcard,
				'password'		=>	base64_encode($passwd)
			);
			$data['sign'] = $this->mackSign($data);
			$r = $this->HttpPost($data);
			$obj = json_decode($r);
			return $obj;
		}


	//身份证认证
    public function ApiIdCardGet($name,$idcard){
        $data = array(
            'method'		=>	'api.identity.idcheck',
            'apiKey'		=>	nl_get_customConfig('limu_apiKey'),
            'version'		=>	'1.2.0',
            'accessType'    =>  'api',
            'name'          =>  $name,
            'identityNo'    =>  $idcard,
        );
        $data['sign'] = $this->mackSign($data);
        $r = $this->HttpPost($data);
        $obj = json_decode($r,true);
        return $obj;
    }


	/*
	 *
	 * 轮询
	 */
		public function ApiCommonGetstatus($token='',$bizType='mobile'){
			$data = array(
					"method" => "api.common.getStatus",
					"apiKey" => nl_get_customConfig('limu_apiKey'),
					"bizType" => $bizType,
					"token" => $token,
					'version'=>	'1.2.0',
			);
			$data['sign'] = $this->mackSign($data);
			$r = $this->HttpPost($data);
			$obj = json_decode($r);
			return $obj;
		}
		/*
			数据结果查询
			返回格式：json
			请求方式：http post
			响应模式：同步
		 */
		public function ApiCommonGetResult($token='',$bizType='mobile'){
			$data = array(
				'method'		=>	'api.common.getResult', //getReport 是报告   getResult 是运营商
				'apiKey'		=>	nl_get_customConfig('limu_apiKey'),
				'version'		=>	'1.2.0',
				'token'			=>	$token,
				'bizType'		=>	$bizType
			);
			$data['sign'] = $this->mackSign($data);
			$r = $this->HttpPost($data);
			$obj = json_decode($r);
			return $obj;
		}
	/*
	 *
	 * 提交验证码
	 */
			public function ApiMobileSendSms($token='',$smscode=''){

				$data = array(
					'method'=>'api.mobile.sendSms',
					'apiKey'		=>	nl_get_customConfig('limu_apiKey'),
					'version'		=>	'1.2.0',
					'token'			=>	$token,
					'smsCode'		=>$smscode);
				$data['sign'] = $this->mackSign($data);
				$r = $this->HttpPost($data);
				$obj = json_decode($r);
				return $obj;
			}

    /*
* 重构发送短信验证码
*
*/
    public function ApiSendSms($token='',$smscode=''){
        $data = array(
            'method'=>'api.common.input',
            'apiKey'		=>	nl_get_customConfig('limu_apiKey'),
            'version'		=>	'1.2.0',
            'token'			=>	$token,
            'input'		=>$smscode
        );
        $data['sign'] = $this->mackSign($data);
        $r = $this->HttpPost($data);
        $obj = json_decode($r);
        return $obj;
    }


		//签名
		private function mackSign($data){
			if(isset($data['sign'])){
				unset($data['sign']);
			}
			ksort($data);
			$str = '';
			foreach ($data as $key => $value) {
				$str .= '&'.$key.'='.$value;
			}
			$str .= nl_get_customConfig('limu_Secret');
			$str = substr($str,1);
			$str = sha1($str);
			return $str;
		}
		//提交
		private function HttpPost($data=array(),$timeout=3000){
		    $ch = curl_init();  
		    curl_setopt($ch, CURLOPT_URL, $this->ApiUrl);  
		    curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);  
		    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout-2);  
		    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 信任任何证书  
		    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 1); // 检查证书中是否设置域名  
		    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  
		    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Expect:')); //避免data数据过长问题  
		    curl_setopt($ch, CURLOPT_POST, true);  
		    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);  
		    $ret = curl_exec($ch);  
		    curl_close($ch);  
		    return $ret;
		}




}