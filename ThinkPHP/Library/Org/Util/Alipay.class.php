<?php
namespace Org\Util;
//支付宝H5手机支付类
class Alipay{

	//发起支付请求
	public function pay($trade_no,$subject,$amount,$timeout){
		$AlipayPath = SITE_PATH.'Data/Plus/Alipay/';
		require_once $AlipayPath . 'service/AlipayTradeService.php';
		require_once $AlipayPath . 'buildermodel/AlipayTradeWapPayContentBuilder.php';
		require_once $AlipayPath . 'config.php';
		$notify_url=C('site_url')."Home/Callback/notifyPay.html";
		$return_url=C('site_url')."Home/Callback/returnPay.html";
	    $payRequestBuilder = new AlipayTradeWapPayContentBuilder();
	    $payRequestBuilder->setSubject($subject);
	    $payRequestBuilder->setBody($body);
	    $payRequestBuilder->setOutTradeNo($trade_no);
	    $payRequestBuilder->setTotalAmount($amount);
	    $payRequestBuilder->setTimeExpress($timeout);
	    $payResponse = new AlipayTradeService($config);
	    $result=$payResponse->wapPay($payRequestBuilder,$return_url,$notify_url);
	}

/*

		支付回调部分请在本类中验证签名并返回贷款订单号

 */

	//异步回调
	public function notifyFun(){
		$AlipayPath = SITE_PATH.'Data/Plus/Alipay/';
		require_once($AlipayPath . "config.php");
		require_once $AlipayPath . 'wappay/service/AlipayTradeService.php';
		$arr=$_POST;
		$alipaySevice = new AlipayTradeService($config); 
		$alipaySevice->writeLog(var_export($_POST,true));
		$result = $alipaySevice->check($arr);
		if($result) {
			//验证成功
		    if($_POST['trade_status'] == 'TRADE_FINISHED') {
		    	//支付完成,如果需要做退款接入
		    }else if ($_POST['trade_status'] == 'TRADE_SUCCESS') {
		    	//交易完成
		    }
			//商户订单号
			$out_trade_no = $_POST['out_trade_no'];
			//支付宝交易号
			$trade_no = $_POST['trade_no'];
			//交易状态
			$trade_status = $_POST['trade_status'];
			return $out_trade_no;
		}else {
		    //验证失败
		    return '';
		}

	}

	//同步回调
	public function returnFun(){
		require_once($AlipayPath."config.php");
		require_once $AlipayPath.'wappay/service/AlipayTradeService.php';
		$arr=$_GET;
		$alipaySevice = new AlipayTradeService($config); 
		$result = $alipaySevice->check($arr);
		if($result) {
			//验证成功
			//商户订单号
			$out_trade_no = htmlspecialchars($_GET['out_trade_no']);
			//支付宝交易号
			$trade_no = htmlspecialchars($_GET['trade_no']);
			return $out_trade_no;
		}else {
		    //验证失败
		    return false;
		}
	}


}