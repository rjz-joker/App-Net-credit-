<?php if (!defined('THINK_PATH')) exit(); session_start();?>
<!DOCTYPE html>
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
    <meta http-equiv="content-type" content="text/html;charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1"/>
    <title><?php echo C('site_title');?></title>
    <link rel="stylesheet" href="/Public/css/feedback.css"/>
    <link rel="stylesheet" href="/Public/plugins/layui/css/layui.css">
    <script src="/Public/plugins/layui/layui.js"></script>
    <style>
        .info_li .title {
            color: #999999;
            float: left;
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

        .login_Btn3 {
            background-color: #40A0D4;
            border-radius: 3px;
            color: #fff;
            display: block;
            font-size: 16px;
            height: 60px;
            margin: 25px auto;
            padding: 8px 0;
            text-align: center;
            width: 90%;
        }

    </style>
</head>
<body>
<div class="auth_info">

    <li class="info_li">
        <span class="title">订单号</span>
        <span class="cont"><?php echo ($borrow["oid"]); ?></span>
    </li>
    <li class="info_li">
        <span class="title">借款金额</span>
        <span class="cont"><?php echo ($borrow["money"]); ?>元</span>
    </li>
    <li class="info_li">
        <span class="title">借款期限</span>
        <span class="cont"><?php echo ($borrow["day"]); ?>天</span>
    </li>
    <li class="info_li">
        <span class="title">手续费用</span>
        <span class="cont"><?php echo ($borrow["fee"]); ?>元</span>
        <!-- <i class="fa fa-info-circle fa-2x fa-fw icon-b" style="font-size: 18px;" onclick="show_money()"></i> -->
    </li>
    <li class="info_li">
        <span class="title">到账银行</span>
        <span class="cont"><?php echo ($borrow["bank"]); ?></span>
    </li>
    <li class="info_li">
        <span class="title">到账金额</span>
        <span class="cont"><?php echo ($borrow["review_money"]); ?>元</span>
    </li>
    <li class="info_li">
        <span class="title">申请时间</span>
        <span class="cont">
                    <?php echo (date("Y-m-d",$borrow["create_time"])); ?>
                </span>
    </li>
    <li class="info_li">
        <span class="title">审核时间</span>
        <span class="cont">
                    <?php echo (date("Y-m-d",$borrow["create_time"])); ?>
                </span>
    </li>
    <li class="info_li">
        <span class="title">应还时间</span>
        <span class="cont">
                    <?php echo (date("Y-m-d",$borrow['create_time']+$borrow['day']*24*3600)); ?>
                </span>
    </li>
    
    <?php if($borrow['borrow_status'] == 1): if($borrow["expire_days"] > 0): ?><li class="info_li">
                <span class="title">逾期情况</span>
                <span class="cont">
                    <?php echo ($borrow["expire_days"]); ?>天
                </span>
            </li><?php endif; ?>
        
        <?php
 $_SESSION['yu_money']=sprintf('%.2f',$borrow['expire_days']*nl_get_customConfig('yu_money')*$borrow['money']/100); if($_SESSION['yu_money']>$borrow['money']*nl_get_customConfig('yu_max_money')){ $_SESSION['yu_money']=$borrow['money']; } if($_SESSION['yu_money']<0){ $_SESSION['yu_money']=0; } $_SESSION['money']=sprintf('%.2f',($borrow['money']+$_SESSION['yu_money'])); $_SESSION['oid']=$borrow['oid']; $_SESSION['borrow_money']=$borrow['money']; $_SESSION['day']=$borrow['day']; ?>

        <?php if($borrow["expire_days"] > 0): ?><li class="info_li">
                <span class="title">逾期费用</span>
                <span class="cont">
                    <?php
 echo $_SESSION['yu_money']; ?>元
                </span>
            </li><?php endif; ?>


        <?php if(($borrow["borrow_status"] == 1) AND ($borrow["payment_status"] != 1)): ?><div>
                
                <button class="login_Btn2" onclick="pay()">我要还款</button>
                <!-- <button class="login_Btn2" onclick="xu()">我要续期</button> -->
                <h6 class="login_Btn3"><br/>
                    恭喜您审核通过！
                </h6>
                <!--<h5 style="text-align: center">-->
                <!--<?php echo ($borrow["review_note"]); ?>-->
                <!--</h5>-->
            </div>
            <?php else: ?>
            <div>
                <button class="login_Btn2">已还款</button>
                <h6 class="login_Btn3">有借有还,再借不难！我们将给您更高的额度
                    <p>逾期还款将会影响您的个人征信，请保持良好的个人信用。</p>
                </h6>
            </div><?php endif; ?>

        <?php elseif($borrow["borrow_status"] == 2): ?>
        <?php if($borrow["review_time"] != 0): ?><li class="info_li">
                <span class="title">审核时间</span>
                <span class="cont">
                    <?php echo (date("Y-m-d H:i:s",$borrow["review_time"])); ?>
                </span>
            </li><?php endif; ?>
        <p class="info_alert_title" style="color:red">
            <?php if($borrow["borrow_status"] == 0 ): ?>等待审核<?php endif; ?>
            <?php if($borrow["borrow_status"] == 1 ): ?>等待还款<?php endif; ?>
            <?php if($borrow["borrow_status"] == 2 ): ?>已拒绝<?php endif; ?>
            <?php if($borrow["borrow_status"] == 4 ): ?>还款完成<?php endif; ?>
        </p>
        <div class="info_alert">
            <p class="info_alert_title">温馨提示</p>
            <div>
                <h6 class="login_Btn3"><br/>因综合信用评分不足，申请暂未通过！</h6>

                <h5 style="text-align: center">
                    <?php echo ($borrow["review_note"]); ?>
                </h5>
            </div>
        </div>
        <?php elseif($borrow["borrow_status"] == 4): ?>
        <li class="info_li">
            <span class="title">审核时间</span>
            <span class="cont">
                    <?php echo (date("Y-m-d H:i:s",$borrow["review_time"])); ?>
                </span>
        </li>
        <li class="info_li">
            <span class="title">还款时间</span>
            <span class="cont">
                    <?php echo (date("Y-m-d H:i:s",$borrow["payment_time"])); ?>
                </span>
        </li>
        <div>
            <button class="login_Btn2">已还款</button>
            <h6 class="login_Btn3">有借有还,再借不难！我们将给您更高的额度
                <p>逾期还款将会影响您的个人征信，请保持良好的个人信用。</p>
            </h6>
        </div>
        <?php else: ?>
        <div class="info_alert">
            <p class="info_alert_title">温馨提示</p>
            <div>
                <h6 class="login_Btn3">
                    您的贷款订单已提交成功,请等待系统审核!
                </h6>
            </div>
        </div><?php endif; ?>

</div>

<!--还款-->
<div class="payFor" style="display: none;min-width: 350px;">
    <a href="javascript:;" onclick="callpay()">
        <div class="layui-form-item" style="margin-top: 10px;min-height:60px;line-height:60px;">
            <img src="/Public/img/weixin.png" alt="">
        </div>
    </a>

    <hr/>

    <a href="<?php echo U('Loan/lianlian');?>">
        <div class="layui-form-item" style="margin-top: 10px;min-height:60px;line-height:60px;">
            <img src="/Public/img/yinlian.jpg" alt="">
        </div>
    </a>
</div>

<!--续期-->
<div class="payXu" style="display: none;min-width: 350px;">
    <a href="javascript:;" onclick="callpay2()">
        <div class="layui-form-item" style="margin-top: 10px;min-height:60px;line-height:60px;">
            <img src="/Public/img/weixin.png" alt="">
        </div>
    </a>

    <hr/>

    <a href="<?php echo U('Loan/lianlianxuqi');?>">
        <div class="layui-form-item" style="margin-top: 10px;min-height:60px;line-height:60px;">
            <img src="/Public/img/yinlian.jpg">
        </div>
    </a>
</div>

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
<script>
    layui.use('form', function () {
        var form = layui.form();
    });
    function pay() {
        location.href="<?php echo U('Loan/lianxikefu');?>";
        
    }

    function xu() {
        location.href="<?php echo U('Loan/lianlianxuqi');?>";
        return false;
        layer.open({
            type: 1,
            shade: false,
            title: "请选择付款方式",
            content: $(".payXu")
        });
    }
    
    function show_money(){
                layer.open({
                    content: "<h4>审核管理费:<?php echo ($borrow["shenhe"]); ?>元</h4><h4>借款管理费:<?php echo ($borrow["jiekuan"]); ?>元</h4><h4>利息:<?php echo ($borrow["lixi"]); ?>元</h4>"
                    ,btn: '我知道了'
                });
            
            }

    //调用微信JS api 支付
//    function jsApiCall() {
//        WeixinJSBridge.invoke(
//            'getBrandWCPayRequest',<?php echo ($jsApiParameters); ?>,
//            function (res) {
//                //支付成功程序位置
//                //alert(JSON.stringify(res));
//                if (res.err_msg == "get_brand_wcpay_request:ok") {
//                    alert('支付成功！');
//                    window.location.href = "<?php echo C('site_url');?>"+"Home/Loan/lists";
//                } else if (res.err_msg == "get_brand_wcpay_request:cancel") {
//                    alert('已取消支付');
//                    window.location.href = "<?php echo C('site_url');?>"+"Home/Loan/lists";
//                } else {
//                    //返回跳转到订单详情页面
//                    alert('支付失败');
//                    window.location.href = "<?php echo C('site_url');?>"+"Home/Loan/lists";
//                }
//            }
//        );
//    }
//
//    function callpay() {
//        if (typeof WeixinJSBridge == "undefined") {
//            if (document.addEventListener) {
//                document.addEventListener('WeixinJSBridgeReady', jsApiCall, false);
//            } else if (document.attachEvent) {
//                document.attachEvent('WeixinJSBridgeReady', jsApiCall);
//                document.attachEvent('onWeixinJSBridgeReady', jsApiCall);
//            }
//        } else {
//            jsApiCall();
//        }
//    }
//
//
//
//    //调用微信JS api 续期
//    function jsApiCall2(re) {
//      //alert(re);
//        WeixinJSBridge.invoke(
//            'getBrandWCPayRequest',
//          {
//              "appId":re.appId,
//              "nonceStr":re.nonceStr,
//              "package":re.package,
//              "paySign":re.paySign,
//              "signType":re.signType,
//              "timeStamp":re.timeStamp
//          }
//          ,
//            function (res) {
//                //支付成功程序位置
//                //alert(JSON.stringify(res));
//                if (res.err_msg == "get_brand_wcpay_request:ok") {
//                    alert('续期成功！');
//                    window.location.href = "<?php echo C('site_url');?>"+"Home/Loan/lists";
//                } else if (res.err_msg == "get_brand_wcpay_request:cancel") {
//                    alert('已取消支付');
//                    window.location.href = "<?php echo C('site_url');?>"+"Home/Loan/lists";
//                } else {
//                    //返回跳转到订单详情页面
//                    alert('续期失败');
//                    window.location.href = "<?php echo C('site_url');?>"+"Home/Loan/lists";
//                }
//            }
//        );
//    }
//
//
//    function callpay2() {
//        var oid = "<?php echo ($oid); ?>";
//        $.ajax({
//            type:"get",
//            url:"<?php echo U('Loan/view');?>",
//            cache:false,
//            async:false,
//            dataType:"json",
//            data:{oid:oid},
//            success:function (res) {
//          //alert(JSON.stringify(res));
//                if (typeof WeixinJSBridge == "undefined") {
//                    if (document.addEventListener) {
//                        document.addEventListener('WeixinJSBridgeReady', jsApiCall, false);
//                    } else if (document.attachEvent) {
//                        document.attachEvent('WeixinJSBridgeReady', jsApiCall);
//                        document.attachEvent('onWeixinJSBridgeReady', jsApiCall);
//                    }
//                } else {
//                    jsApiCall2(res);
//                }
//
//
//            }
//        });
//
//    }


</script>


</html>