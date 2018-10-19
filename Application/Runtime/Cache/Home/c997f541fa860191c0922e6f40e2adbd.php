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
		.info_li .title{
			color: #999999;
		}
		.borrow_alert{
			padding-left: 12px;
			padding-top: 10px;
		    background-color: #F0F0F0;
			min-height: 100px;
		}
		.borrow_alert span{
			color: #1880db;
			font-weight: bold;
		}
		.borrow_alert a{
			color: #1880db;
		}
		.borrow_alert p{
			margin-top: 8px;
		}
		.btn_borrow{
		    position: absolute;
		    bottom: 0px;
		}
		  .login_Btn2 {
            background-color: #40A0D4;
            border-radius: 3px;
            color: #fff;
            display: block;
            font-size: 24px;
            height: 40px;
            line-height: 40px;
            margin: 25px auto;
            text-align: center;
            width: 90%;
        }
		</style>
		<link rel="stylesheet" href="/Public/css/feedback.css" />
	</head>
	<body>
	
		<div class="auth_info">
			<form action="<?php echo U('Loan/borrow');?>" method="post" id="borrowForm">
				<input type="hidden" name="token" value="<?php echo ($borrow["token"]); ?>" />
				<li class="info_li">
					<span class="title">借款金额</span>
					<span><?php echo ($borrow["money"]); ?>元</span>
				</li>
				<li class="info_li">
					<span class="title">借款期限</span>
					<span><?php echo ($borrow["day"]); ?>天</span>
				</li>
				<li class="info_li">
					<span class="title">手续费用</span>
					<span><?php echo ($borrow["fee"]); ?>元<h4>(审核管理费:<?php echo ($borrow["shenhe"]); ?>元,借款管理费:<?php echo ($borrow["jiekuan"]); ?>元,利息:<?php echo ($borrow["lixi"]); ?>元)</h4></span>
					
					<!-- <i class="fa fa-info-circle fa-2x fa-fw icon-b" style="font-size: 18px;" onclick="show_money()"></i> -->
				</li>
				<li class="info_li">
					<span class="title">到账银行</span>
					<span class="val"><?php echo ($borrow["bank"]); ?></span>
				</li>
				<li class="info_li">
					<span class="title">到账金额</span>
					<span><?php echo ($borrow["review_money"]); ?>元</span>
				</li>
				<div class="borrow_alert">
					您需要<span><?php echo ($borrow["day"]); ?>天</span>后，还款<span><?php echo ($borrow["money"]); ?>元</span>
					<p>
						<input type="checkbox" name="vehicle" checked="checked" />
						同意 <a onclick="getPro()"> 《<?php echo C('site_title');?>借款协议》 </a>
					</p>
					
				</div>
				
			</form>

			<span id="protocol" style="display: none"><?php echo ($protocol); ?></span>
			<span id="t" style="display: none"><?php echo date('Y-m-d',time());?></span>
			<div>
					<button class="login_Btn2">确认申请</button>
				</div>
			
			
		</div>
		
		<script>
            function getPro() {
                var pro = $('#protocol').text();
                var pro1=pro.replace('time',$('#t').text());
                var pro2=pro1.replace('uname',"<?php echo ($auth_idcard["name"]); ?>");
                var pro3=pro2.replace('idcard',"<?php echo ($auth_idcard["idcard"]); ?>");
                var pro4=pro3.replace('mobile',"<?php echo ($user["mobile"]); ?>");
                var pro5= pro4.replace('ucid',"<?php echo ($user["cid"]); ?>");


                layer.open({
                    type: 1,
                    title: '借款合同',
                    shadeClose: true,
                    shade: 0.8,
                    area: ['380px', '90%'],
                    style: 'margin-left:10%;position:fixed; bottom:0; left:0; width: 80%; height: 100%; padding:10px 0; border:none;overflow-y:scroll',
                    content: "<div style='padding: 0 15px'>"+pro5+"</div>"
                });
            }


			function show_money(){
				layer.open({
					content: "<h4>审核管理费:<?php echo ($borrow["shenhe"]); ?>元</h4><h4>借款管理费:<?php echo ($borrow["jiekuan"]); ?>元</h4><h4>利息:<?php echo ($borrow["lixi"]); ?>元</h4>"
					,btn: '我知道了'
				});
			
			}

			$(function(){
				$(".login_Btn2").on('click',function(){
					var check = $("#borrowForm input[type='checkbox']").is(':checked');
					if(!check){
						layer.open({
							content: '请先同意贷款协议'
							,btn: '我知道了'
						});
						return ;
					}
					layer.open({
						type: 2,
						shadeClose: false
					});
					$("#borrowForm").ajaxSubmit({
						success:function(data){
							if(!data.status){
	    						layer.closeAll();
								layer.open({
									content:data.info,
									btn:['确定']
								});
							}else{
								window.location.href=data.url;
							}
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