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
		<link rel="stylesheet" href="/Public/css/feedback.css" />
		<style>
		.auth_item{
			border-top: 1px solid #EDEDED;
			border-bottom: none;
			line-height: 38px;
		}
		.info_li input{
			font-size: 14px;
		}
		.auth_item_title{
			margin-left: 12px;
		}
		</style>
		<link rel="stylesheet" href="/Public/js/LArea/LArea.css">
		<script src="/Public/js/LArea/Bank.js"></script>
		<script src="/Public/js/LArea/City.js"></script>
	    <script src="/Public/js/LArea/LArea.js"></script>
	</head>
	<body>
	<div class="head">
		<a href="<?php echo U('Auth/index');?>" class="back">
			<i class="fa fa-angle-left"></i>
		</a>
		<span>银行卡认证</span>
		<!--<a href="javascript:;" class="submit">提交</a>-->
	</div>

		<div class="auth_info">
			<form action="<?php echo U('Auth/bank');?>" method="post" target="_self">
				<input size="30" name="user_id" value="<?php echo ($user_info["id"]); ?>" type="hidden"/>
				<textarea rows="5" cols="60" name="risk_item" style="display: none"><?php echo ($json); ?></textarea>

				<ul>
					<li class="info_li">
						<span>姓　　名:</span>
						<input type="text" name="acct_name" value="<?php echo ($user_info["name"]); ?>" placeholder="请输入您的真实姓名">
					</li>
					<li class="info_li">
						<span>身份证号:</span>
						<input type="text" name="id_no" value="<?php echo ($user_info["idcard"]); ?>"  placeholder="请输入您的身份证号">
						<div class="auth_item_status auth_status_true">
						</div>
					</li>
					<li class="info_li">
						<span>银行卡号:</span>
						<input type="text" name="card_no" value="<?php echo ($user_info["bank_num"]); ?>" placeholder="请输入您的银行卡号">
						<div class="auth_item_status auth_status_true">
						</div>
					</li>
				</ul>
                
                  <button class="btn_borrow" type="submit">提交</button>
				<div class="info_alert">
					<p class="info_alert_title">温馨提示</p>
					<div>
						<span>
							放款使用，需填写本人名下有效银行卡
						</span>
						<!--<br>-->
						<!--<span>-->
							<!--2.确保银行预留手机号码正确-->
						<!--</span>-->
					</div>
				</div>
			</form>
		</div>
		<script>
			var area1 = new LArea();
		    area1.init({
		        'trigger': '#bank_name',
		        'valueTo': '',
		        'keys': {
		            id: 'id',
		            name: 'name'
		        }, //绑定数据源相关字段 id对应valueTo的value属性输出 name对应trigger的value属性输出
		        'type': 1, //数据源类型
		        'data': Bankname //数据源
		    });
		    area1.value=[0,0];
			var area2 = new LArea();
		    area2.init({
		        'trigger': '#bank_city',
		        'valueTo': '',
		        'keys': {
		            id: 'id',
		            name: 'name'
		        }, //绑定数据源相关字段 id对应valueTo的value属性输出 name对应trigger的value属性输出
		        'type': 1,
		        'data': LAreaData //数据源
		    });
		    area2.value=[0,0];

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