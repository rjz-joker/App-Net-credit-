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
		.user_login{
			background-color:#fff;margin-top: 10px;
		}
		body{
			background-color: #fff;
		}
		</style>
	</head>
	<body>
		<div class="head">
			<a href="javascript:history.back(-1)" class="back">
				<i class="fa fa-angle-left"></i>
			</a>
			<span>修改密码</span>
		</div>

		<div class="user_login">
			<form action="<?php echo U('User/findpass');?>" id="find_form" method="post">
				<div class="input_item">
					<i class="fa fa-mobile fa-2x"></i>
<?php if(isLogin()): $user_info=getLoginUser(); ?>
					<input type="hidden" name="mobile" id="mobile" value="<?php echo ($user_info["mobile"]); ?>" />
					<span style="width: 60%;font-size: 16px;color: #8B8989;margin-left: 10px;"><?php echo ($user_info["mobile"]); ?></span>
<?php else: ?>
					<input type="tel" name="mobile" placeholder="11位手机号码" id="mobile" maxlength="11" />
					<i class="fa fa-close" style="color:#5E5E5E;display: none;"></i><?php endif; ?>
				</div>
				<div class="input_item">
					<i class="fa fa-shield" style="font-size: 1.7em;"></i>
					<input id="vcode" name="vcode" type="text" placeholder="4位验证码" style="width: 60%;" />
					<i class="fa fa-close" style="color:#5E5E5E;display: none;"></i>
					<a href="javascript:getCodeStep2();" class="forget_password"> 获取验证码</a>
				</div>
				<div class="input_item">
					<i class="fa fa-lock fa-2x"></i>
					<input type="password" name="passwd" placeholder="6-20位新密码" id="passwd" maxlength="20" />
					<i class="fa fa-close" style="color:#5E5E5E;display: none;"></i>
				</div>
				<botton class="reg_Btn">确认修改</botton>
			</form>
		</div>

		<script>
		var rtime = 60;
		$(function(){
			$("#mobile").on('keyup afterpaste',function(){
				$(this).val($(this).val().replace(/\D/g,''));
			});
			$("#reg_form .input_item input").on('input',function(){
				var v = $(this).val();
				var obj = $($(this).parent()).find(".fa-close");
				if(v != '' && v != null){
					$(obj).show();
				}else{
					$(obj).hide();
				}
			});
			$("#reg_form .input_item .fa-close").on('click',function(){
				var obj = $($(this).parent()).find("input");
				$(obj).val('');
				$(this).hide();
			});
			$(".reg_Btn").on('click',function(){
				var mobile = $("#mobile").val();
				var vcode  = $("#vcode").val();
				var passwd = $("#passwd").val();
				
				if(passwd.length < 6 || passwd.length > 20){
					layer.open({
						content:'密码长度不符合规范!',
						skin:'msg',
						time:2
					});
					return ;
				}
				layer.open({
					type: 2,
					shadeClose: false
				});
				$("#find_form").ajaxSubmit({
					success:function(data){
						if(!data.status){
							layer.closeAll();
							layer.open({
								content:data.info,
								skin:'msg',
								time:3
							});
						}else{
							layer.closeAll();
							layer.open({
								content:'密码修改成功!',
								skin:'msg',
								time:2
							});
							setTimeout(function(){
								window.location.href = data.url;
							},2000);
						}
					}
				});
				return ;
			});
		});

		function getCodeStep2(){
			var mobile = $("#mobile").val();
		
			var imgcode = $(".layui-m-layerchild #imgcode").val();
			layer.open({type:2,shadeClose:false});
			$.post(
				"<?php echo U('User/getVCode');?>",
				{
					imgcode:imgcode,
					mobile:mobile,
					type:'findpass'
				},
				function(data){
					if(!data.status){
						layer.closeAll();
						layer.open({
							content:data.info,
							skin:'msg',
							time:3
						});
					}else{
						layer.closeAll();
						rgetVcode();
					}
				}
			);
		}
		function rgetVcode(){
			var obj = $("#find_form .input_item .forget_password");
			if(rtime > 1){
				$(obj).attr('style',"pointer-events: none;");
                $(obj).attr('href','#');
				$(obj).html(rtime+"秒重试");
				rtime = rtime-1;
				setTimeout(function(){
					rgetVcode();
				},1000);
			}else{
				$(obj).attr('style',"pointer-events:;");
                $(obj).attr('href','javascript:getCodeStep2();');
				$(obj).html("获取验证码");
				rtime = 60;
			}
		}

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