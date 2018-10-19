<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">

<meta name="viewport"
      content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0,user-scalable=no"/>
<meta name="format-detection" content="telephone=no">
<meta name="keywords" content="<NL:sitecfg name='keywords' />">
<meta name="description" content="<NL:sitecfg name='description' />">
<link rel="stylesheet" href="/Public/css/bootstrap.min.css"/>
<link rel="stylesheet" href="/Public/css/bootstrap-theme.min.css"/>
<link rel="stylesheet" href="/Public/css/font-awesome.min.css">
<link rel="stylesheet" href="/Public/css/style.css"/>
<link rel="stylesheet" href="/Public/css/iconfont.css"/>
<style>
    .curr {
        display: block;
        overflow: hidden;
        color: #40A0D4;
    }

    .no_curr {
        display: block;
        overflow: hidden;
        color: #333333;
    }
</style>
<script src="/Public/js/jquery.min.js"></script>
<script src="/Public/js/bootstrap.min.js"></script>
<script src="/Public/js/common.js"></script>
<script src="/Public/js/layer_mobile/layer.js"></script>
<!--[if lt IE 9]>
<script src="https://cdn.bootcss.com/html5shiv/3.7.3/html5shiv.min.js"></script>
<script src="https://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
    <title><?php echo C('site_title');?></title>
    <script src="/Public/js/jquery.form.js"></script>
    <link rel="stylesheet" href="/Public/css/feedback.css"/>
    <style>
        .user_login {
            background-color: #fff;
            margin-top: 10px;
        }

        body {
            background-color: #fff;
        }
        .low{
			color:red;
		}
    </style>
</head>
<body>
<div class="head">
    <a href="javascript:history.back(-1)" class="back">
        <i class="fa fa-angle-left"></i>
    </a>
    <span> 还款渠道</span>
</div>
<div class="hk_main" style="width: 100%;">
	<div class="hk" style="width: 100%;align-items: center;border: 1px solid deepskyblue;">
		<?php  $user_info=D(''); ?>
		<p>尊敬的客户您:&nbsp;需要还款总额(<span class="low"><?php echo session('money');?></span>)</p>
			<p>支付宝还款账户：<span class="low">1159691847@qq.com</span> </p> 
			<p>收款人：易贷钱包(*春霖)</p>		
			<p>微信还款账户：<span class="low">zrjr5168</span></p>
			<p>联系客服：<span class="low">4000861696</span></p>
			<p>备注：请认真核实备注借款人手机及姓名</p>
			<p>方便我们替您入账还款</p>
			
			<img src="/Public/img/121.png" style="width: 340px;height: 340px;"/>
		</div>
</div>
		


</div>

<script>
  
</script>

<div class="container-fluid" id="foooter" style="margin-top: 120px;">
    <nav class="navbar navbar-default navbar-fixed-bottom">
        <div class="navbar-inner navbar-content-center">
            <div class="row" id="nav-font" style="background: #fff;">

                <div class="col-xs-3 text-center">
                    <a style=" display: block; overflow: hidden;color:#40A0D4;" href="<?php echo U('Index/index');?>">
                        <span class="iconfont icon-shouye1" style="line-height: 33px;"></span>
                        <p style="margin-bottom: 0px;font-family: 'Microsoft YaHei';font-size: 12px;">我要借款</p>
                    </a>
                </div>

                <div class="col-xs-3 text-center">
                    <a style="display: block; overflow: hidden;color:#333333" href="<?php echo U('User/index');?>">
                        <span class="iconfont icon-gerenxinxi" style="line-height: 33px;"></span>
                        <p style="margin-bottom: 0px;font-family: 'Microsoft YaHei';font-size: 12px;">会员中心</p>
                    </a>
                </div>


                <div class="col-xs-3 text-center">
                    <a style=" display: block; overflow: hidden; color:#333333" href="<?php echo U('Loan/lists');?>">
                        <span class="iconfont icon-renwu" style="line-height: 33px;"></span>
                        <p style="margin-bottom: 0px;font-family: 'Microsoft YaHei';font-size: 12px;"> 借款管理</p>
                    </a>
                </div>

            </div>
        </div>

    </nav>

</div>
</body>
</html>