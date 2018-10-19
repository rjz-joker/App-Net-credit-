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
			<a href="javascript:history.back(-1)" class="back">
				<i class="fa fa-angle-left"></i>
			</a>
			<span>问题反馈</span>
		</div>
		<div class="content">
			<form action="<?php echo U('Page/feedback');?>" method="post" id="feenback_form">
				<div class="mobile">
					<span>联系电话</span> <br />
<?php if(isLogin()): $user_info=getLoginUser(); ?>
					<input type="hidden" name="mobile" value="<?php echo ($user_info["mobile"]); ?>" />
					<span style="width: 60%;font-size: 16px;color: #8B8989;margin-left: 5%;"><?php echo ($user_info["mobile"]); ?></span>
<?php else: ?>
					<input type="tel" name="mobile" maxlength="11" placeholder="请填写您的手机号" /><?php endif; ?>
				</div>
				<div class="problem">
					<span>我要反馈</span> <br />
					<textarea name="content" rows="8" placeholder="您好，请描述您的问题"></textarea>
					<span class="wordwrap"><l class="word">0</l>/500</span>
				</div>
				<a class="reg_Btn submit" href="javascript:;">提交</a>
			</form>
		</div>
		<script>
		$(function(){
			$("input[name='mobile']").on('keyup afterpaste',function(){
				$(this).val($(this).val().replace(/\D/g,''));
			});
			$("a.submit").on('click',function(){
				if(!isMobile($("input[name='mobile']").val())){
					layer.open({
						content:'手机号码不符合规范!',
						skin:'msg',
						time:2
					});
					return ;
				}
				var content = $("textarea[name='content']").val();
				if(content.lenth == 0){
					layer.open({
						content:'反馈内容不能为空!',
						skin:'msg',
						time:2
					});
					return ;
				}
				if(content.lenth > 500){
					layer.open({
						content:'反馈内容太长了!',
						skin:'msg',
						time:2
					});
					return ;
				}
				$("#feenback_form").ajaxSubmit({
					success:function(data){
						if(!data.status){
							layer.open({
								content:data.info,
								skin:'msg',
								time:3
							});
						}else{
							layer.open({
								content:'感谢反馈，我们会及时处理!',
								btn:'知道了'
							});
							setTimeout(function(){
								window.location.href = "<?php echo U('Index/index');?>";
							},3000);
						}
					}
				});
				return ;
			});
			$(".content .problem textarea").on('input',function(){
				var t_text = $(this).val();
				var t_num = t_text.length;
				if(t_num > 500){
					t_num = 500;
					t_text = t_text.substring(0,500);
					$(this).val(t_text);
				}
				$(".content .problem .wordwrap").html('<l class="word">'+t_num+'</l>/500');
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