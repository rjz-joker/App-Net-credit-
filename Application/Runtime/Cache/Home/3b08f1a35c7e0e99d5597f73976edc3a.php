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
		<a href="<?php echo U('Auth/index');?>" class="back">
			<i class="fa fa-angle-left"></i>
		</a>
		<span>身份认证</span>
		<!--<a href="javascript:;" class="submit">提交</a>-->
	</div>

		<div class="auth_info">
			<form action="<?php echo U('Auth/idcard');?>" method="post">
				<ul>

					<li class="info_photo_li">
						<span class="text_bg">身份证照</span>
						<span class="text_sm">(人像面)</span>
						<div class="photo_show">
							<i class="fa fa-camera-retro fa-2x"></i>
							<div class="photo_img" style="background-image: url(<?php echo ($data["photo_face"]); ?>);"></div>
							<input type="hidden" name="photo_face" value="<?php echo ($data["photo_face"]); ?>">
							<input type="file" name="p_photo_face" id="p_photo_face" accept="image/jpg,image/jpeg,image/png" capture="camera" onchange="upLoadImg(this)" >
						</div>
					</li>
					<li class="info_photo_li">
						<span class="text_bg">身份证照</span>
						<span class="text_sm">(国徽面)</span>
						<div class="photo_show">
							<i class="fa fa-camera-retro fa-2x"></i>
							<div class="photo_img" style="background-image: url(<?php echo ($data["photo_back"]); ?>);"></div>
							<input type="hidden" name="photo_back" value="<?php echo ($data["photo_back"]); ?>">
							<input type="file" name="p_photo_back" id="p_photo_back" accept="image/jpg,image/jpeg,image/png" capture="camera" onchange="upLoadImg(this)" >
						</div>
					</li>
					<li class="info_photo_li">
						<span class="text_bg">手持证件</span>
						<span class="text_sm">(正脸照)</span>
						<div class="photo_show">
							<i class="fa fa-camera-retro fa-2x"></i>
							<div class="photo_img" style="background-image: url(<?php echo ($data["photo"]); ?>);"></div>
							<input type="hidden" name="photo" value="<?php echo ($data["photo"]); ?>">
							<input type="file" name="p_photo" id="p_photo" accept="image/jpg,image/jpeg,image/png" capture="camera" onchange="upLoadImg(this)" >
						</div>
					</li>
					<li class="info_li">
						<span>您的姓名:</span>
						<input type="text" id="name" placeholder="身份证姓名" name="name" value="<?php echo ($data["name"]); ?>">
					</li>
					<li class="info_li">
						<span>身份证号:</span>
						<input type="text" id="idcard" placeholder="如：110108201506252000" name="idcard" value="<?php echo ($data["idcard"]); ?>">
					</li>
				</ul>
  <button class="btn_borrow submit" onClick="return false;" >提交</button> 
				<div class="info_alert">
					<p class="info_alert_title">温馨提示</p>
					<div>

						<span>
							1.身份证照片需本人、清晰且完整
						</span>
						<span>
							2.请核实系统识别的姓名、身份证号码。如果系统识别的不正确请您修改
						</span>
					</div>
				</div>
			</form>
		</div>
		<script src="/Public/js/ajaxfileupload.js"></script>
		<script>
            var isLoad = 0;
            $(function(){
                $(".info_photo_li .photo_show i").on('click',function(){
                    var obj = $($(this).parent()).find("input");
                    $(obj).click();
                });
                $(".submit").on('click',function(){
                    layer.open({
                        type:2,
                        shadeClose:false,
                        content:'请耐心等待认证,不要离开本页'
                    });

                    $(".auth_info form").ajaxSubmit({
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
                                    content:'保存成功!',
                                    skin:'msg',
                                    time:2
                                });
                                setTimeout(function(){
                                    window.location.href = "<?php echo U('Auth/index');?>";
                                },2000);
                            }
                        }
                    });
                });
            });
            function upLoadImg(obj){
                if(isLoad){
                    layer.open({
                        content:'正在上传,请稍后...',
                        skin:'msg',
                        time:2
                    });
                    return;
                }else{
                    isLoad = 1;
                    upLoadImg(this);
                }
                var file_name = $(obj).val();
                var obj_id = $(obj).attr('id');
                var url = "<?php echo U('Upload/index',array('n'=>'name_rep'));?>";
                url = url.replace('name_rep',$(obj).attr('name'));
                var view_obj = $($(obj).parent()).find(".photo_img");
                if(file_name.length != 0){
                    layer.open({
                        type: 2,
                        shadeClose: false
                    });
                    $.ajaxFileUpload({
                        url:url,
                        fileElementId:obj_id,
                        dataType:'json',
                        success:function(data,state){
							//alert(data);
                            layer.closeAll();
                            if(!data.status){
                                layer.open({
                                    content:data.info,
                                    skin:'msg',
                                    time:3
                                });
                            }else{
                                var imgurl = data.info['url'];
								
                                if($(obj).attr('name')== 'p_photo_face'){
									$("#name").val(data.info.res_data['id_name']);
									$("#idcard").val(data.info.res_data['id_number']);
                                }
                                $(view_obj).removeAttr("style");
                                $(view_obj).attr('style',"background-image: url("+imgurl+");");
                                var relName = $(obj).attr('name');
                                relName = relName.replace('p_','');
                                $("input[name='"+relName+"']").val(imgurl);
                                layer.open({
                                    content:'上传成功!',
                                    skin:'msg',
                                    time:2
                                });
                            }
                        }
                    });
                }
                isLoad = 0;
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