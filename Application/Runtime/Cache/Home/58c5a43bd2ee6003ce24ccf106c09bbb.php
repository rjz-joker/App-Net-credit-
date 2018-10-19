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
		}
		</style>
		<link rel="stylesheet" href="/Public/js/LArea/LArea.css">
		<script src="/Public/js/LArea/Relation.js"></script>
		<script src="/Public/js/LArea/Relation2.js"></script>
	    <script src="/Public/js/LArea/LArea.js"></script>
	</head>
	<body>
		<div class="head">
			<a href="<?php echo U('Auth/index');?>" class="back">
				<i class="fa fa-angle-left"></i>
			</a>
			<span>紧急联系人</span>
			<!--<a href="javascript:;" class="submit">提交</a>-->
		</div>

		<div class="auth_info">
			<form action="<?php echo U('Auth/relation');?>" method="post">
				<ul>
					<li class="info_li">
						<span>与本人关系</span>
						<input type="text" name="people_relation_1" id="relation1" value="<?php echo ($data["people_relation_1"]); ?>" readonly="" style="width: 40%;">
						<div class="auth_item_status auth_status_true">
							<i class="fa fa-angle-right"></i>
						</div>
					</li>
					<li class="info_li">
						<span>姓名</span>
						<input type="text" placeholder="张三" name="people_name_1" value="<?php echo ($data["people_name_1"]); ?>">
					</li>
					<li class="info_li">
						<span>电话</span>
						<input type="tel" placeholder="138 **** ****" name="people_tel_1" value="<?php echo ($data["people_tel_1"]); ?>">
					</li>
				</ul>
				<hr style="border: 5px solid #f0f0f0;margin: 0;">
				<ul>
					<li class="info_li">
						<span>与本人关系</span>
						<input type="text" name="people_relation_2" id="relation2" value="<?php echo ($data["people_relation_2"]); ?>" readonly="" style="width: 40%;">
						<div class="auth_item_status auth_status_true">
							<i class="fa fa-angle-right"></i>
						</div>
					</li>
					<li class="info_li">
						<span>姓名</span>
						<input type="text" placeholder="张三" name="people_name_2" value="<?php echo ($data["people_name_2"]); ?>">
					</li>
					<li class="info_li">
						<span>电话</span>
						<input type="tel" placeholder="138 **** ****" name="people_tel_2" value="<?php echo ($data["people_tel_2"]); ?>">
					</li>
				</ul>
				<div class="info_alert">
					<p class="info_alert_title">温馨提示</p>
					<div>
						<span>
							1.我们不会电话审核，请放心填写
						</span>
						<br>
						<span>
							2.信息需真实有效，否则将导致贷款失败
						</span>
					</div>
				</div>
				<button class="btn_borrow submit" onClick="return false;" >提交</button>
			</form>
		</div>
		<script>
			var area1 = new LArea();
		    area1.init({
		        'trigger': '#relation1',
		        'valueTo': '',
		        'keys': {
		            id: 'id',
		            name: 'name'
		        }, //绑定数据源相关字段 id对应valueTo的value属性输出 name对应trigger的value属性输出
		        'type': 1, //数据源类型
		        'data': RelationData //数据源
		    });
		    area1.value=[0,0];
			var area2 = new LArea();
		    area2.init({
		        'trigger': '#relation2',
		        'valueTo': '',
		        'keys': {
		            id: 'id',
		            name: 'name'
		        }, //绑定数据源相关字段 id对应valueTo的value属性输出 name对应trigger的value属性输出
		        'type': 1, //数据源类型
		        'data': RelationData2 //数据源
		    });
		    area2.value=[0,0];
		    $(function(){
		    	$(".submit").on('click',function(){
		    		$(".auth_info form").ajaxSubmit({
		    			success:function(data){
		    				if(!data.status){
		    					layer.open({
		    						content:data.info,
		    						skin:'msg',
		    						time:3
		    					});
		    					return ;
		    				}
							layer.open({
								content:'保存成功!',
								skin:'msg',
								time:2
							});
							setTimeout(function(){
								window.location.href = "<?php echo U('Auth/index');?>";
							},2000);
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