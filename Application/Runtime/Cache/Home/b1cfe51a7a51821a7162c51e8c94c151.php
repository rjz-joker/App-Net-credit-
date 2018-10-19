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
		.info_li input{
			font-size: 14px;
			float: right;
		}
		.reg_Btn{
			border: none;
		}
		.refer_mobile{
			text-align: center;
			background-color: #fff;
			min-height: 200px;
		}
		.refer_mobile i{
			line-height: 70px;
		}
	</style>
</head>
<body>

<div class="head">
	<a href="javascript:history.go(-1);" class="back">
		<i class="fa fa-angle-left"></i>
	</a>
	<span>手机认证</span>
	<!--<a href="javascript:;" class="submit">提交</a>-->
</div>

<?php if($data['status'] == 0): ?><div id="querys">
		<div class="auth_info" >
			<form action="<?php echo U('Auth/mobile');?>" method="post" id="mobileForm">
				<ul>
					<li class="info_li">
						<span>真实姓名</span>
						<input type="text" name="name" id="name" placeholder="真实姓名" readonly value="<?php echo ($idcard["name"]); ?>">
					</li>
					<li class="info_li">
						<span>身份证号</span>
						<input type="text" name="idcard" id="idcard" placeholder="身份证号" readonly value="<?php echo ($idcard["idcard"]); ?>">
					</li>
					<li class="info_li">
						<span>手机号码</span>
						<input type="text" name="phone" id="phone" placeholder="手机号码" value="<?php echo ($user["mobile"]); ?>">
					</li>
					<li class="info_li">
						<span>服务密码</span>
						<input type="password" name="passwd" id="passwd" placeholder="手机服务密码">
					</li>
				</ul>
			</form>
		</div>
		<button class="reg_Btn" onclick="querysubmit();" id="submitBtn">提交</button>
	</div><?php endif; ?>
<?php if($data['status'] == 1): ?><div class="refer_mobile">

		<br>
		<span>恭喜您，已完成运营商认证。</span>
		<button class="reg_Btn">重新认证</button>
	</div><?php endif; ?>
<?php if($data['status'] == 2): ?><div id='searcherror'  class="refer_mobile">
		<i class="fa fa-minus-circle fa-3x"></i>
		<br>
		<span>非常抱歉，认证未通过。</span>
		<button class="reg_Btn">重新验证</button>
	</div><?php endif; ?>

<div id="smscodes" style="display:none">
	<div class="auth_info">
		<form action="<?php echo U('Auth/mobile_smscode');?>" method="post" id="mobileForms">
			<ul>
				<li class="info_li">
					<span>短信验证码</span>
					<input type="hidden" name="token" id="token" />
					<input type="text" name="smscode" id="smscode" placeholder="手机收到的短信验证码">
				</li>
			</ul>
		</form>
	</div>
	<button class="reg_Btn" id="submitBtns" onclick="validataSmsCode();">提交验证码</button>
</div>
<div id="endsearch" style="display:none;">
	<div class="refer_mobile">

		<br>
		<span>恭喜您，已完成运营商认证。</span>
		<button class="reg_Btn">重新认证</button>
	</div>

</div>
<div id="endsearch1" style="display:none;">
	<div class="refer_mobile">

		<br>
		<span>不要离开，系统正在备份数据...</span>
		<button class="reg_Btn">重新验证</button>
	</div>

</div>
<div id="beginsearch1" class="refer_mobile" style="display:none">

	<br>
	<span>您已经提交运营商认证。</span>
	<br>
	<span>验证码已经提交，请耐心等待！</span>
</div>
<div id="beginsearch" class="refer_mobile" style="display:none">

	<br>
	<span>您已经提交运营商认证。</span>
	<br>
	<span>请耐心等待...不要离开本页</span>
</div>

<script>
    function showsmscode(){
        $('#beginsearch').hide();
        $('#smscode').show();
    }
    $(function(){
        $(".refer_mobile .reg_Btn").on('click',function(){
            window.location.href = "<?php echo U('Auth/mobile',array('reset'=>1));?>";
        });
    });
    function querysubmit() {
        layer.open({
            type:2,
            shadeClose:false,
            content:'请耐心等待认证,不要离开本页',
        });
        var phone = $('#phone').val();
        var passwd = $('#passwd').val();
        var name = $('#name').val();
        var idcard = $('#idcard').val();

        $.post("<?php echo U('Auth/mobile');?>", {
            'phone' : phone,
            'passwd' : passwd,
            'name' : name,
            'idcard' : idcard,
            'loginType':'normal'
        }, function(data) {
            if(data.status==0){
                layer.closeAll();
                layer.open({
                    content:data.info,
                    skin:'msg',
                    time:3
                });
                return false;
            }else{
                processData(data);
            }

        });
    }
    function processData(data){

        if(data.code == "0010"){
            // alert(data.code);
            console.log(data.code);
            token = data.token;
            $("#token").val(token);
            //进入轮询
            Httppost("<?php echo U('Auth/ajax_mobile');?>",{token:token});
        }

        if(data.code == undefined || data.code == "") {
            return false;
        }
        if(data.code == "0100"){
            console.log(data.code);
            return false;
        }
        if(data.code == '2999'){
            console.log(data.code);
            //2999其他错误，经常出现。所以做一个特殊判断
            //重新提交
            var accountVal = $('#username').val();
            var passwordVal = $('#password').val();
            $.post("<?php echo U('Auth/mobile');?>", {
                'username' : accountVal,
                'password' : passwordVal,
                'loginType':'normal'
            }, function(data) {
                // alert(data.code);
                processData(data);
            });
            return true;
        }

        if("" != data.code && 0 != data.code.indexOf('0'))

        //发送请求成功
        if(data.code=='1102'){
            //手机密码不正确1
            console.log(data.code);
            layer.closeAll();
            layer.open({
                content:"手机号或者密码错误，请重新输入！",
                skin:'msg',
                time:3
            });
            return true;
        }

        if(data.code=='2017'){
            //查询次数过多
            console.log(data.code);
            layer.closeAll();
            layer.open({
                content:"查询次数过多,请稍后再试！",
                skin:'msg',
                time:3
            });
            return true;
        }


        if(data.code=='2027'){
            //身份证信息不正确
            console.log(data.code);
            layer.closeAll();
            layer.open({
                content:"身份证信息有误,请核实！",
                skin:'msg',
                time:3
            });
            return true;
        }

        if(data.code=='2008'){
            //身份证信息不正确
            console.log(data.code);
            layer.closeAll();
            layer.open({
                content:"短信验证码有误，请重新认证！",
                skin:'msg',
                time:3
            });
            return true;
        }

        if(data.code=='0200'){
            //报告生成成功
            console.log(data.code);
            layer.closeAll();
            layer.open({
                content:"认证成功！",
                skin:'msg',
                time:3
            });
            location.href="<?php echo U('Auth/index');?>";
            return true;
        }


        if(data.code == "0006"){
            console.log(data.code);
            layer.closeAll();
            $('#smscodes').show();
            $('#querys').hide();
            layer.open({
                content:"请输入手机验证码！",
                skin:'msg',
                time:3
            });

            return true;
        }else if(data.code == '0000'){
            console.log(data.code);
            layer.closeAll();
            layer.open({
                content:"数据准备成功，请等待数据输入！",
                skin:'msg',
                time:3
            });
            $('#smscodes').hide();
            $('#querys').hide();
            $('#endsearch').show();
            return true;

        }
        console.log(data.code);
        return true;
    }

    //验证短信验证码
    function validataSmsCode(){
        //检验空
        var v = $('#smscode').val();
        if(""==v.replace(/(^\s+)|(\s+$)/g,"")) {

            $('#smscode').addClass('error');
            layer.open({
                content:"验证码不能为空！",
                skin:'msg',
                time:3
            });

            return false;
        }

        $.post("<?php echo U('Auth/mobile_smscode');?>", {
            'smscode' : $('#smscode').val(),
            'token' : $('#token').val()
        }, function(data) {
            if('0009' == data.code)
            {
                //写入成功
                //继续轮询
                layer.open({
                    type:2,
                    shadeClose:false,
                    content:'请耐心等待认证,不要离开本页'
                });
                Httppost("<?php echo U('Auth/ajax_mobile');?>",{token:token});
            }else {
                layer.closeAll();
                layer.open({
                    content:data.msg + "请重新认证。",
                    skin:'msg',
                    time:3
                });
            }

        });

    }

    function Httppost(url,post){
        setTimeout(function() {
            $.post(url, post, function (data) {
                console.log(processData(data));
                if(!processData(data)) {
                    Httppost(url, post);
                }
            }, "json");
        },1000);
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