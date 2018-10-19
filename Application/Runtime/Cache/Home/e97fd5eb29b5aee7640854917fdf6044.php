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
    <style>
        .input_item {
            border-bottom: 0;
        }
    </style>
</head>
<body>

<div class="big_head">
    <div class="head-nav">
        <a href="javascript:history.back(-1)">
            <span class="fa fa-angle-left"></span>
        </a>
    </div>
    <div class="head_logo">
        <img src="<?php echo C('site_logo');?>" alt=""/>
    </div>
</div>

<div class="content">
    <div class="user_login">
        <form action="<?php echo U('User/reg');?>" id="reg_form" method="post">
            <div class="input_item">
                <!--<i class="fa fa-mobile fa-2x"></i>-->
                <input type="tel" name="mobile" placeholder="手机" id="mobile" maxlength="11"
                       style="padding-left:25px;width:100%;height:50px;border: 1px solid #40A0D4;;border-radius: 5px;"/>
            </div>

            <div class="input_item">
                <!--<i class="fa fa-lock fa-2x"></i>-->
                <input type="password" name="passwd" placeholder="密码" id="passwd" maxlength="20"
                       style="padding-left:25px;width:100%;height:50px;border: 1px solid #40A0D4;;border-radius: 5px;margin-top: 15px;"/>
            </div>

          <!--     <div class="input_item">
                    <input type="text" name="yao_code" placeholder="邀请码" id="yao_code"
                           maxlength="20"
                           style="padding-left:25px;width:100%;height:50px;border: 1px solid #40A0D4;border-radius: 5px;margin-top: 15px;"/>
                </div> -->

            <div class="input_item">
                <!--<i class="fa fa-shield" style="font-size: 1.7em;"></i>-->
                <input id="vcode" name="vcode" type="text" placeholder="验证码"
                       style="padding-left:25px;width: 50%;height:50px;border: 1px solid #40A0D4;;border-radius: 5px;margin-top: 15px;"/>
                <a href="javascript:getCodeStep2();" class="forget_password"
                   style="font-family:inherit;margin-top:19px;width:38%;height:40px;line-height:40px;border: 1px solid #40A0D4;;border-radius: 5px;text-align: center">免费发送短信验证码</a>
            </div>
            <span id="pro" style="display: none"><?php echo ($protocol); ?></span>
            <div class="input_item" style="margin-top: 15px;">
                <input type="checkbox" name="agree" value="1" checked="checked"
                       style="height: 20px;width:20px;margin-left: 0px;border: 1px solid #40A0D4;;"/>
                <a onclick="getProtocol()" style="font-size: 18px;color: #40A0D4;;"> 我同意以上注册协议 </a>
            </div>
            <div class="input_item" style="margin-top: 15px;">
                <h6>提示</h6>
                <h6>请输入正确的电话号码。</h6>
            </div>

            <button class="reg_Btn" style="height:50px;border-radius: 10px;width: 90%;font-size:small;">申请贷款</button>
        </form>
    </div>
    <div class="cont_link">
        <a href="<?php echo U('User/login');?>" class="user_reg_link">
            <span>去登录</span>
            <i class="fa fa-arrow-circle-o-right"></i>
        </a>
        <a href="<?php echo U('Page/feedback');?>" class="feedback">
            <span>遇到问题</span>
            <i class="fa fa-question-circle-o"></i>
        </a>
    </div>

    <br/>
    <br/>


</div>
<div style="clear: both;width: 100%;text-align: center"><a href="<?php echo U('Index/index');?>">© Powered by
    <?php echo C('site_title');?></a></div>
<script>
    function getProtocol() {
        layer.open({
            type: 1 //Page层类型
            ,
            title: '用户使用协议'
            ,
            shadeClose: true
            ,
            shade: 0.8
            ,
            area: ['380px', '90%']
            ,
            style: 'margin-left:10%;position:fixed; bottom:0; left:0; width: 80%; height: 100%; padding:10px 0; border:none;overflow-y:scroll'
            ,
            content: '<div style="padding: 0 15px">' + $('#pro').text() + '</div>'
        });
    }


    var rtime = 60;
    $(function () {
        $("#mobile").on('keyup afterpaste', function () {
            $(this).val($(this).val().replace(/\D/g, ''));
        });
        $("#reg_form .input_item input").on('input', function () {
            var v = $(this).val();
            var obj = $($(this).parent()).find(".fa-close");
            if (v != '' && v != null) {
                $(obj).show();
            } else {
                $(obj).hide();
            }
        });
        $("#reg_form .input_item .fa-close").on('click', function () {
            var obj = $($(this).parent()).find("input");
            $(obj).val('');
            $(this).hide();
        });
        $(".reg_Btn").on('click', function () {
            var mobile = $("#mobile").val();
            var vcode = $("#vcode").val();
            var passwd = $("#passwd").val();
        
            layer.open({
                type: 2,
                shadeClose: false
            });
            $("#reg_form").ajaxSubmit({
                success: function (data) {
                    if (!data.status) {
                        layer.closeAll();
                        layer.open({
                            content: data.info,
                            skin: 'msg',
                            time: 3
                        });
                    } else {
                        layer.closeAll();
                        layer.open({
                            content: '注册成功!',
                            skin: 'msg',
                            time: 2
                        });
                        setTimeout(function () {
                            window.location.href = data.url;
                        }, 2000);
                    }
                }
            });
            return false;
        });
    });

    function getCodeStep1() {
        var mobile = $("#mobile").val();
  
    }


	
	function getCodeStep2(){
				var mobile = $("#mobile").val();
				$.ajax({
					async:false,
					type:"POST",
					url:"<?php echo U('User/getVCode');?>",
					data:{mobile:mobile},
					dataType:'json',
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
							rgetVcode();
						}
					}
				
				});
	
			}
			
    function rgetVcode() {
        var obj = $("#reg_form .input_item .forget_password");
        if (rtime > 1) {
            $(obj).attr('style', "font-family:inherit;margin-top:19px;width:38%;height:40px;line-height:40px;border: 1px solid #40A0D4;;border-radius: 5px;text-align: center");
            $(obj).attr('href','#');
            $(obj).html(rtime + "秒重试");
            rtime = rtime - 1;
            setTimeout(function () {
                rgetVcode();
            }, 1000);
        } else {
            $(obj).attr('style', "font-family:inherit;margin-top:19px;width:38%;height:40px;line-height:40px;border: 1px solid #40A0D4;;border-radius: 5px;text-align: center");
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