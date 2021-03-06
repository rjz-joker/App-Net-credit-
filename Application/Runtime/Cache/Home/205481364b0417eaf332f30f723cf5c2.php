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
    
    <link rel="stylesheet" href="/Public/css/feedback.css"/>
    <link rel="stylesheet" href="/Public/js/LArea/LArea.css">
    <script src="/Public/js/LArea/City.js"></script>
    <script src="/Public/js/LArea/Live.js"></script>
    <script src="/Public/js/LArea/LArea.js"></script>
    <script src="/Public/js/LArea/Relation.js"></script>
    <script src="/Public/js/LArea/MonthSalary.js"></script>
</head>
<body>


<div class="auth_info">
    <form action="<?php echo U('Auth/info');?>" method="post">
        <div class="head">
            <a href="<?php echo U('Auth/index');?>" class="back">
                <i class="fa fa-angle-left"></i>
            </a>
            <span>基本信息</span>
        </div>
        <ul>

            <li class="info_li">
                <span style=" float:left">现居城市:</span>
                <input type="text" name="live_city" id="city" value="<?php echo ($data["live_city"]); ?>" readonly
                       style="width:auto;border:none; float:left"> <i class="fa fa-angle-right"></i>
            </li>


            <li class="info_li">
                <span>详细地址:</span>
                <input type="text" name="live_address" id="address" value="<?php echo ($data["live_address"]); ?>"/>
            </li>


            <li class="info_li">
                <span style=" float:left">居住时长:</span>
                <input type="text" name="live_time" id="livetime" value="<?php echo ($data["live_time"]); ?>" readonly
                       style="width:auto;border:none; float:left"><i class="fa fa-angle-right"></i>
            </li>
			
			<li class="info_li">
                <span style=" float:left">您的年龄:</span>
                <input type="number" name="age" id="age" value="<?php echo ($data["age"]); ?>" 
                       style="width:auto;border:none; float:left">
            </li>
			
			<li class="info_li"  style=" float:left">
                <span style=" float:left">文化程度:</span>
                <select name='edu' style="width:auto;border:none; float:left">
					<option value='小学'>小学</option>
					<option value='初中'>初中</option>
					<option value='高中'>高中</option>
					<option value='大专'>大专</option>
					<option value='本科'>本科</option>
					<option value='博士'>博士</option>
					<option value='硕士'>硕士</option>
					<option value='无学历'>无学历</option>
				</select>
            </li>
			
			<li class="info_li"  style=" float:left">
                <span style=" float:left">婚姻状况:</span>
                <select name='is_hun' style="width:auto;border:none; float:left">
					<option value='未婚'>未婚</option>
					<option value='已婚'>已婚</option>
					<option value='丧偶'>丧偶</option>
				</select>
            </li>

            <!--<li class="info_li">-->
                <!--<span style=" float:left">地理位置:</span>-->
                <!--<input type="text" name="desc" id="desc" readonly-->
                       <!--style="width:auto;border:none; float:left" value="<?php echo ($data["desc"]); ?>">-->
                <!--<button  id="getDesc" onclick="return false;" style="background-color: #40A0D4;color: #fff;height: 30px;line-height: 30px;text-align: center;border-radius: 5px;">点击获取</button>-->
            <!--</li>-->


        </ul>
        <button class="btn_borrow submit" onClick="return false;">提交</button>
    </form>

</div>
<!--<script src="http://res.wx.qq.com/open/js/jweixin-1.1.0.js"> </script>-->
<!--<script src="/Public/js/weixin.js"> </script>-->
<!--<script src="http://libs.baidu.com/jquery/2.0.0/jquery.js"></script>-->
<script src="/Public/js/jquery.form.js"></script>
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

    var area2 = new LArea();
    area2.init({
        'trigger': '#livetime',
        'valueTo': '',
        'keys': {
            id: 'id',
            name: 'name'
        }, //绑定数据源相关字段 id对应valueTo的value属性输出 name对应trigger的value属性输出
        'type': 1, //数据源类型
        'data': livetimeData //数据源
    });
    area2.value = [0, 0];

//    wx.config({
//        debug: true, // 开启调试模式,调用的所有api的返回值会在客户端alert出来，若要查看传入的参数，可以在pc端打开，参数信息会通过log打出，仅在pc端时才会打印。
//        appId:"<?php echo ($sign['appId']); ?>", // 必填，公众号的唯一标识
//        timestamp:"<?php echo ($sign['timestamp']); ?>", // 必填，生成签名的时间戳
//        nonceStr:"<?php echo ($sign['nonceStr']); ?>", // 必填，生成签名的随机串
//        signature:"<?php echo ($sign['signature']); ?>",// 必填，签名，见附录1
//        jsApiList:[
//            'getNetworkType',//网络状态接口
//            //'openLocation',//使用微信内置地图查看地理位置接口
//            'getLocation' //获取地理位置接口
//        ] // 必填，需要使用的JS接口列表，所有JS接口列表见附录2
//    });
//
//    wx.ready(function(){
//        //获取地理位置
//        $("#getDesc").on('click', function () {
//            wx.getLocation({
//                success: function (res) {
//                    //alert(JSON.stringify(res));
//                    var latitude = res.latitude; // 纬度，浮点数，范围为90 ~ -90
//                    var longitude = res.longitude; // 经度，浮点数，范围为180 ~ -180。
//                    var speed = res.speed; // 速度，以米/每秒计
//                    var accuracy = res.accuracy; // 位置精度
//
//                    $.ajax({
//                        url: "http://apis.map.qq.com/ws/geocoder/v1/?location="+latitude+","+longitude+"&coord_type=5&key=5OLBZ-UVWR3-5AV32-34N4M-SWKMV-TKB7P&output=jsonp&callback=calllocation",
//                        type: "GET",
//                        dataType:'jsonp',
//                        jsonp:'calllocation'
//                    });
//                },
//                cancel: function (res) {
//                    alert('用户拒绝授权获取地理位置');
//                }
//            });
//        });
//
//    });
//
//    //初始化jsapi接口 状态
//    wx.error(function (res) {
//        //alert("调用微信jsapi返回的状态:"+res.errMsg);
//    });
//
//    //地位位置回调
//    function calllocation(data){
//        //$("#cover").hide();
//        //alert(data.result.address);
//        $("#desc").val(data.result.address);
//        $("#getDesc").hide();
//        //var address=data.result.formatted_addresses.recommend;
//    }

    $(function () {
        $(".submit").on('click', function () {

            $(".auth_info form").ajaxSubmit({
                success: function (data) {
                    if (!data.status) {
                        layer.open({
                            content: data.info,
                            skin: 'msg',
                            time: 3
                        });
                        return;
                    }
                    layer.open({
                        content: '保存成功!',
                        skin: 'msg',
                        time: 2
                    });
                    setTimeout(function () {
                        window.location.href = "<?php echo U('Auth/index');?>";
                    }, 2000);
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