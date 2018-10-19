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
</head>
<body>
<div class="head">
    <a href="<?php echo U('Index/index');?>" class="back">
        <i class="fa fa-angle-left"></i>
    </a>
    <span>会员中心</span>
</div>
<a href="<?php echo U('Auth/index');?>">
    <li class="auth_item">
        <div class="auth_item_icon">
            <i class="fa fa-user fa-2x fa-fw icon-b"></i>
        </div>
        <div class="auth_item_title">
            信息认证
        </div>
        <div class="auth_item_status">
            <i class="fa fa-angle-right"></i>
        </div>
    </li>
</a>

    <a href="<?php echo U('User/findpass');?>">
        <li class="auth_item">
            <div class="auth_item_icon">
                <i class="fa fa-shield fa-2x fa-fw icon-b"></i>
            </div>
            <div class="auth_item_title">
                修改密码
            </div>
            <div class="auth_item_status">
                <i class="fa fa-angle-right"></i>
            </div>
        </li>
    </a>

<a href="<?php echo U('Page/feedback');?>">
    <li class="auth_item">
        <div class="auth_item_icon">
            <i class="fa fa-commenting-o fa-2x fa-fw icon-b"></i>
        </div>
        <div class="auth_item_title">
            问题反馈
        </div>
        <div class="auth_item_status">
            <i class="fa fa-angle-right"></i>
        </div>
    </li>
</a>

    <a href="javascript:;" id="logoutBtn">
        <li class="auth_item">
            <div class="auth_item_icon">
                <i class="fa fa-unlock-alt fa-2x fa-fw icon-b"></i>
            </div>
            <div class="auth_item_title">
                退出登录
            </div>
            <div class="auth_item_status">
                <i class="fa fa-angle-right"></i>
            </div>
        </li>
    </a>
	

<script>
    $(function () {
        $("#logoutBtn").on('click', function () {
            var url = "<?php echo U('User/logout');?>";
            layer.open({
                content: '您确定要退出登录吗？'
                , btn: ['退出', '取消']
                , yes: function (index) {
                    window.location.href = url;
                }
            });
        });
    });
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