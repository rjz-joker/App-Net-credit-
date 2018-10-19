<?php 
Session_Start();
$price=$_SESSION["pricesum"];
//echo $price;exit;
ini_set('date.timezone','Asia/Shanghai');
//error_reporting(E_ERROR);
require_once "lib/WxPay.Api.php";
require_once "WxPay.JsApiPay.php";
require_once 'log.php';



$price=$price*100;

$order_name="电子门票";
$order_id=$_SESSION["piao_id"];
$notify_b="http://www.weixinhuajue.cn/notify_piao.php?order_id=".$order_id."";
//echo $notify_b;
//初始化日志
$logHandler= new CLogFileHandler("logs/".date('Y-m-d').'.log');
$log = Log::Init($logHandler, 15);

//打印输出数组信息
function printf_info($data)
{
    foreach($data as $key=>$value){
        echo "<font color='#00ff55;'>$key</font> : $value <br/>";
    }
}

//①、获取用户openid
$tools = new JsApiPay();
$openId = $tools->GetOpenid();
$_SESSION["openid"]=$openId;
//$openId = $_POST['openid'];
//②、统一下单
$input = new WxPayUnifiedOrder();
$input->SetBody("$order_name");
$input->SetAttach("$order_name");
$input->SetOut_trade_no(WxPayConfig::MCHID.date("YmdHis"));
$input->SetTotal_fee("$price");
$input->SetTime_start(date("YmdHis"));
$input->SetTime_expire(date("YmdHis", time() + 600));
$input->SetGoods_tag("test");
$input->SetNotify_url("$notify_b");
$input->SetTrade_type("JSAPI");
$input->SetOpenid($openId);
$order = WxPayApi::unifiedOrder($input);
//echo '<font color="#f00"><b>统一下单支付单信息</b></font><br/>';
//printf_info($order);
$jsApiParameters = $tools->GetJsApiParameters($order);

//获取共享收货地址js函数参数
$editAddress = $tools->GetEditAddressParameters();

//③、在支持成功回调通知中处理成功之后的事宜，见 notify.php
/**
 * 注意：
 * 1、当你的回调地址不可访问的时候，回调通知会失败，可以通过查询订单来确认支付是否成功
 * 2、jsapi支付时需要填入用户openid，WxPay.JsApiPay.php中有获取openid流程 （文档可以参考微信公众平台“网页授权接口”，
 * 参考http://mp.weixin.qq.com/wiki/17/c0f37d5704f0b64713d5d2c37b468d75.html）
 */
?>

<html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/> 
    <title>众展网 - 微信支付</title>
    <script type="text/javascript">
	//调用微信JS api 支付
	function jsApiCall()
	{
		WeixinJSBridge.invoke(
			'getBrandWCPayRequest',
			<?php echo $jsApiParameters; ?>,
			function(res){
				WeixinJSBridge.log(res.err_msg);
				
				//支付成功程序位置
				
				if(res.err_msg == "get_brand_wcpay_request:ok"){
                   
				 //window.location.href="http://baiaotai.chengdongli.com/update_paystatus.php?meeting_id="+<?php// echo $meeting_id;?>;
                   alert('支付成功！');
				   window.location.href='http://www.weixinhuajue.cn/user_ticket.php?openid=<?php echo $_SESSION["openid"];?>';
				   
				   }else if (res.err_msg == "get_brand_wcpay_request:cancel") {  
   // message: "已取消微信支付!"
   
				   alert('已取消支付');
									   window.location.href="../../../../index.php";
 }else{
                       //返回跳转到订单详情页面
                       alert('支付失败');
                       window.location.href="../../../../index.php";
                         
                   }
				
				
				
				
				
				
				
				
				
				//alert(res.err_code+res.err_desc+res.err_msg);
			}
		);
	}

	function callpay()
	{
		if (typeof WeixinJSBridge == "undefined"){
		    if( document.addEventListener ){
		        document.addEventListener('WeixinJSBridgeReady', jsApiCall, false);
		    }else if (document.attachEvent){
		        document.attachEvent('WeixinJSBridgeReady', jsApiCall); 
		        document.attachEvent('onWeixinJSBridgeReady', jsApiCall);
		    }
		}else{
		    jsApiCall();
		}
	}
	//获取共享地址
	
	
	</script>
</head>
<body>
    <br/>
    
   
    <font color="#000"><b>订单名称:<span style="color:#000;font-size:22px"><?php echo $order_name;?></span></b></font><br/><br/>
     <font color="#000"><b>订单价格:<span style="color:#000;font-size:22px"><?php echo $price/100;?>元</span></b></font><br/><br/>
    
	<div align="center">
		<button style="width:210px; height:50px; border-radius: 15px;background-color:#9ACD32; border:0px #9ACD32 solid; cursor: pointer;  color:white;  font-size:16px;" type="button" onClick="callpay()" >立即支付</button>
	</div>
</body>
</html>