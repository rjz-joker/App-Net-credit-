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
	</head>
	<body>
	<div class="head">
		<a href="<?php echo U('User/index');?>" class="back">
			<i class="fa fa-angle-left"></i>
		</a>
		<span>信息认证</span>
	</div>
		<a href="<?php echo U('Auth/info');?>">
			<li class="auth_item">
				<div class="auth_item_icon">
					<i class="fa fa-info-circle fa-2x fa-fw icon-b"></i>
				</div>
				<div class="auth_item_title">
					个人基本情况
				</div>
<?php if($status['info']): ?><div class="auth_item_status auth_status_true">
					<span>已填写</span>
					<i class="fa fa-angle-right"></i>
				</div>
<?php else: ?>
				<div class="auth_item_status">
					<span>未填写</span>
					<i class="fa fa-angle-right"></i>
				</div><?php endif; ?>
			</li>
		</a>


<!--个人工作-->
		<a href="<?php echo U('Auth/work');?>">
			<li class="auth_item">
				<div class="auth_item_icon">
					<i class="fa fa-info fa-2x fa-fw icon-b"></i>
				</div>
				<div class="auth_item_title">
					个人工作情况
				</div>
				<?php if($status['work']): ?><div class="auth_item_status auth_status_true">
						<span>已填写</span>
						<i class="fa fa-angle-right"></i>
					</div>
					<?php else: ?>
					<div class="auth_item_status">
						<span>未填写</span>
						<i class="fa fa-angle-right"></i>
					</div><?php endif; ?>
			</li>
		</a>



	<!--紧急联系人-->
	<a href="<?php echo U('Auth/relation');?>">
		<li class="auth_item">
			<div class="auth_item_icon">
				<i class="fa fa-mobile fa-2x fa-fw icon-b"></i>
			</div>
			<div class="auth_item_title">
				紧急联系人
			</div>
			<?php if($status['relation']): ?><div class="auth_item_status auth_status_true">
					<span>已填写</span>
					<i class="fa fa-angle-right"></i>
				</div>
				<?php else: ?>
				<div class="auth_item_status">
					<span>未填写</span>
					<i class="fa fa-angle-right"></i>
				</div><?php endif; ?>
		</li>
	</a>


	<!--身份认证-->
	<a href="<?php echo U('Auth/idcard');?>">
		<li class="auth_item">
			<div class="auth_item_icon">
				<i class="fa fa-user fa-2x fa-fw icon-b"></i>
			</div>
			<div class="auth_item_title">
				身份认证
			</div>
			<?php if($status['idcard']): ?><div class="auth_item_status auth_status_true">
					<span>已认证</span>
					<i class="fa fa-angle-right"></i>
				</div>
				<?php else: ?>
				<div class="auth_item_status">
					<span>去认证</span>
					<i class="fa fa-angle-right"></i>
				</div><?php endif; ?>
		</li>
	</a>


		<!--手机认证  立木-->
		<a href="<?php echo U('Auth/mobile');?>">
			<li class="auth_item">
				<div class="auth_item_icon">
					<i class="fa fa-mobile fa-2x fa-fw icon-b"></i>
				</div>
				<div class="auth_item_title">
					手机认证
				</div>
				<?php if($status['mobile']): ?><div class="auth_item_status auth_status_true">
						<span>已认证</span>
						<i class="fa fa-angle-right"></i>
					</div>
					<?php else: ?>
					<div class="auth_item_status">
						<span>去认证</span>
						<i class="fa fa-angle-right"></i>
					</div><?php endif; ?>
			</li>
		</a>

		<a href="<?php echo U('Auth/bank');?>">
			<li class="auth_item">
				<div class="auth_item_icon">
					<i class="fa fa-bank fa-2x fa-fw icon-b"></i>
				</div>
					<div class="auth_item_title">
					银行卡认证
				</div>
				<?php if($status['bank']): ?><div class="auth_item_status auth_status_true">
						<span>已认证</span>
						<i class="fa fa-angle-right"></i>
					</div>
					<?php else: ?>
					<div class="auth_item_status">
						<span>去认证</span>
						<i class="fa fa-angle-right"></i>
					</div><?php endif; ?>
			</li>
		</a>

       


		<div style="margin-top: 10px;margin-left: 20px;">
			<h6>提示</h6>
			<h6>请务必提交真实的客户信息，若多次提交虚假信息，您的账号会被禁用。</h6>
			<a href="<?php echo U('Index/index');?>"><button class="btn_borrow">申请贷款</button></a>
		</div>
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