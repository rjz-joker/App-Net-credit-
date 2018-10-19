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
		<script src="/Public/js/LArea/City.js"></script>
		<script src="/Public/js/LArea/Live.js"></script>
	    <script src="/Public/js/LArea/LArea.js"></script>
	    <script src="/Public/js/LArea/MonthSalary.js"></script>
	</head>
	<body>
		<div class="head">
			<a href="<?php echo U('Auth/index');?>" class="back">
				<i class="fa fa-angle-left"></i>
			</a>
			<span>个人工作情况</span>
			<!--<a href="javascript:;" class="submit">提交</a>-->
		</div>

		<div class="auth_info">
			<form action="<?php echo U('Auth/work');?>" method="post">
				<ul>
					<li class="info_li">
						<span>从事行业</span>
						<input type="text" placeholder="如：餐饮业" name="work_industry" value="<?php echo ($data["work_industry"]); ?>">
					</li>
					<li class="info_li">
						<span>工作岗位</span>
						<input type="text" placeholder="如：服务员/店长/美发师" name="work_posts" value="<?php echo ($data["work_posts"]); ?>">
					</li>
					<li class="info_photo_li" style="line-height: 50px;height: 50px;margin: 13px 0">
						<span class="text_bg">单位名称</span>
						<textarea name="work_name" rows="2" class="address" placeholder="如：北京智融时代餐饮管理有限公司"><?php echo ($data["work_name"]); ?></textarea>
					</li>
					<li class="info_li">
						<span>单位地址</span>
						<input type="text" name="work_city" id="city" value="<?php echo ($data["work_city"]); ?>" readonly>
						<div class="auth_item_status auth_status_true">
							<i class="fa fa-angle-right"></i>
						</div>
					</li>
					<li class="info_photo_li" style="line-height: 50px;height: 50px;margin: 13px 0">
						<span class="text_bg">详细地址</span>
						<textarea name="work_address" rows="2" class="address" placeholder="如：西城区城方街32号1栋16层302室"><?php echo ($data["work_address"]); ?></textarea>
					</li>
					<li class="info_li">
						<span>单位电话</span>
						<input type="text" placeholder="(选填)如：010-66194000" name="work_tel" value="<?php echo ($data["work_tel"]); ?>">
					</li>
					<li class="info_li">
						<span>月　　薪</span>
						<input type="text" name="month_salary" id="month_salary" value="<?php echo ($data["month_salary"]); ?>" readonly>
						<div class="auth_item_status auth_status_true">
							<i class="fa fa-angle-right"></i>
						</div>
					</li>
				</ul>

				<div class="info_alert">
					<p class="info_alert_title">温馨提示</p>
					<div>
						<span>
							1.保证隐私安全，不会与您所在单位联系
						</span>
						<br>
						<span>
							2.请根据您实际情况如实填写
						</span>
					</div>
				</div>
				<button class="btn_borrow submit" onClick="return false;" >提交</button>
			</form>
		</div>
		<script>
			var area1 = new LArea();
		    area1.init({
		        'trigger': '#city',
		        'valueTo': '',
		        'keys': {
		            id: 'id',
		            name: 'name'
		        }, //绑定数据源相关字段 id对应valueTo的value属性输出 name对应trigger的value属性输出
		        'type': 1, //数据源类型
		        'data': LAreaData //数据源
		    });
		    area1.value=[0,0,0];

            var area2 = new LArea();
            area2.init({
                'trigger': '#month_salary',
                'valueTo': '',
                'keys': {
                    id: 'id',
                    name: 'name'
                }, //绑定数据源相关字段 id对应valueTo的value属性输出 name对应trigger的value属性输出
                'type': 1, //数据源类型
                'data': MonthSalaryData //数据源
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