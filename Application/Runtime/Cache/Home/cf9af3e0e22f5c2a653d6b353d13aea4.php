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


<div class="borrow_ul">
    <?php if(!empty($data)): if(is_array($data)): foreach($data as $key=>$vo): ?><div class="borrow_li" data-oid="<?php echo ($vo["oid"]); ?>">
                <?php if($vo['borrow_status'] == 1): ?><!-- 贷款成功 -->
                    <?php if($vo['payment_status']): ?><!-- 还款成功 -->
                        <i class="fa fa-calendar-check-o icon"></i>
                        <?php else: ?>
                        <!-- 尚未还款 -->
                        <i class="fa fa-calendar-o icon"></i><?php endif; ?>
                    <?php elseif($vo['borrow_status'] == 2): ?>
                    <!-- 贷款失败 -->
                    <i class="fa fa-calendar-times-o icon"></i>
                    <?php else: ?>
                    <!-- 等待审核 -->
                    <i class="fa fa-calendar-minus-o icon"></i><?php endif; ?>


                <span class="orderNum">借款订单:<?php echo ($vo["oid"]); ?></span>
                <div class="info">
                    <span>金额</span>
                    <i class="fa fa-cny"></i>
                    <span class="bm"><?php echo ($vo["money"]); ?></span>
                    <span>期限</span>
                    <span class="bm"><?php echo ($vo["day"]); ?></span>
                    <span>天</span>
                </div>
                <span class="order_time">
					<?php echo (date("Y-m-d H:i",$vo["create_time"])); ?>
				</span>
                <a class="view">
					<span>   <?php if($vo["borrow_status"] == 0 ): ?>待审核<?php endif; ?>
                     <?php if($vo["borrow_status"] == 1 ): ?>待还款<?php endif; ?>
                        <?php if($vo["borrow_status"] == 2 ): ?>已拒绝<?php endif; ?>
                           <?php if($vo["borrow_status"] == 4 ): ?>还款完成<?php endif; ?>
             
              
              
    
              
                   </span>
                    <i class="fa fa-angle-right"></i>
                </a>
            </div><?php endforeach; endif; ?>
		<?php if($is_show): ?><div style="width: 100%;text-align: center">
            <span id="protocol" style="display: none"><?php echo ($protocol); ?></span>
			<span id="t" style="display: none"><?php echo date('Y-m-d',time());?></span>
          <input type="button" onclick="getPro()" style="margin-right: 10px;background-color: #40A0D4;color: #fff;" value="申请帮还">
        </div><?php endif; ?>
        <?php else: ?>
        <h2 style="text-align: center">无借款数据</h2><?php endif; ?>
</div>

<div class="page">
    <?php echo ($page); ?>
</div>

<script>
    $(function () {
        $(".borrow_ul .borrow_li").on('click', function () {
            var oid = $(this).attr('data-oid');
            var url = "<?php echo U('Loan/view',array('oid'=>'oidreplace'));?>";
            url = url.replace('oidreplace', oid);
            window.location.href = url;
        });
    });
	
	    function getPro() {
        var pro = $('#protocol').text();
        var pro1=pro.replace('time',$('#t').text());
        var pro2=pro1.replace('uname',"<?php echo ($user_info["name"]); ?>");
        var pro3=pro2.replace('idcard',"<?php echo ($auth_idcard["idcard"]); ?>");
        var pro4=pro3.replace('mobile',"<?php echo ($user["mobile"]); ?>");
        var pro5= pro4.replace('ucid',"<?php echo ($user["cid"]); ?>");


        layer.open({
            type: 1,
            title: '代偿规则',
            shadeClose: true,
            shade: 0.8,
            area: ['380px', '90%'],
            style: 'margin-left:10%;position:fixed; bottom:0; left:0; width: 80%; height: 100%; padding:10px 0; border:none;overflow-y:scroll',
            content: "<div style='padding: 0 15px'>"+pro5+"</div>"
        });
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