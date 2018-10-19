<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <!-- basic styles -->
    <link rel="stylesheet" href="/Public/plugins/layui/css/layui.css">
    <link href="/Public/assets/css/bootstrap.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="/Public/assets/css/font-awesome.min.css"/>
    <!--[if IE 7]>
    <link rel="stylesheet" href="/Public/assets/css/font-awesome-ie7.min.css"/>
    <![endif]-->
    <!-- page specific plugin styles -->
    <link rel="stylesheet" href="/Public/assets/css/jquery-ui-1.10.3.custom.min.css"/>
    <link rel="stylesheet" href="/Public/assets/css/jquery.gritter.css"/>
    <link rel="stylesheet" href="/Public/assets/css/select2.css"/>
    <link rel="stylesheet" href="/Public/assets/css/bootstrap-editable.css"/>
    <!-- fonts -->
    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400,300"/>
    <!-- ace styles -->
    <link rel="stylesheet" href="/Public/assets/css/ace.min.css"/>
    <link rel="stylesheet" href="/Public/assets/css/ace-rtl.min.css"/>
    <link rel="stylesheet" href="/Public/assets/css/ace-skins.min.css"/>

    <!--[if lte IE 8]>
    <link rel="stylesheet" href="/Public/assets/css/ace-ie.min.css"/>
    <![endif]-->
    <script src="/Public/assets/js/ace-extra.min.js"></script>
    <script src="/Public/assets/js/html5shiv.js"></script>
    <script src="/Public/assets/js/respond.min.js"></script>
    <script src="/Public/assets/js/jquery-2.0.3.min.js"></script>
    <script src="/Public/assets/js/jquery-1.10.2.min.js"></script>

    <!--[if !IE]> -->
    <script type="text/javascript">
        window.jQuery || document.write("<script src='/Public/assets/js/jquery-2.0.3.min.js'>" + "<" + "/script>");
    </script>
    <!-- <![endif]-->

    <!--[if IE]>
    <script type="text/javascript">
        window.jQuery || document.write("<script src='/Public/assets/js/jquery-1.10.2.min.js'>" + "<" + "/script>");
    </script>
    <![endif]-->

    <script type="text/javascript">
        if ("ontouchend" in document) document.write("<script src='/Public/assets/js/jquery.mobile.custom.min.js'>" + "<" + "/script>");
    </script>
    <script src="/Public/assets/js/bootstrap.min.js"></script>
    <script src="/Public/assets/js/typeahead-bs2.min.js"></script>
    <script src="/Public/assets/js/excanvas.min.js"></script>
    <script src="/Public/assets/js/jquery-ui-1.10.3.custom.min.js"></script>
    <script src="/Public/assets/js/jquery.ui.touch-punch.min.js"></script>
    <script src="/Public/assets/js/jquery.gritter.min.js"></script>
    <script src="/Public/assets/js/bootbox.min.js"></script>
    <script src="/Public/assets/js/jquery.slimscroll.min.js"></script>
    <script src="/Public/assets/js/jquery.easy-pie-chart.min.js"></script>
    <script src="/Public/assets/js/jquery.hotkeys.min.js"></script>
    <script src="/Public/assets/js/bootstrap-wysiwyg.min.js"></script>
    <script src="/Public/assets/js/select2.min.js"></script>
    <script src="/Public/assets/js/date-time/bootstrap-datepicker.min.js"></script>
    <script src="/Public/assets/js/fuelux/fuelux.spinner.min.js"></script>
    <script src="/Public/assets/js/x-editable/bootstrap-editable.min.js"></script>
    <script src="/Public/assets/js/x-editable/ace-editable.min.js"></script>
    <script src="/Public/assets/js/jquery.maskedinput.min.js"></script>
    <script src="/Public/assets/js/ace-elements.min.js"></script>
    <script src="/Public/assets/js/ace.min.js"></script>
    <script src="/Public/plugins/layui/layui.js"></script>
</head>

<body>

<div class="main-container" id="main-container">
    <script type="text/javascript">
        try {
            ace.settings.check('main-container', 'fixed')
        } catch (e) {
        }
    </script>

    <div class="main-container-inner">
        <div class="main-content">

            <div class="page-content">
                <div class="page-header">
                    <h1>
                        个人资料
                        <small>
                            <i class="icon-double-angle-right"></i>
                            <?php echo ($data["name"]); ?>
                        </small>
                    </h1>
                </div><!-- /.page-header -->

                <div class="row">
                    <div class="col-xs-12">
                        <!-- PAGE CONTENT BEGINS -->

                        <div>
                            <div id="user-profile-2" class="user-profile">
                                <div class="tabbable">
                                    <ul class="nav nav-tabs padding-18">
                                        <li class="active">
                                            <a data-toggle="tab" href="#home">
                                                <i class="green icon-user bigger-120"></i>
                                                个人信息
                                            </a>
                                        </li>

                                        <li>
                                            <a data-toggle="tab" href="#feed">
                                                <i class="orange icon-rss bigger-120"></i>
                                                认证信息
                                            </a>
                                        </li>

                                        <li>
                                            <a data-toggle="tab" href="#friends">
                                                <i class="blue icon-group bigger-120"></i>
                                                通话详单
                                            </a>
                                        </li>

                                        <!--<li>-->
                                        <!--<a data-toggle="tab" href="#sms">-->
                                        <!--<i class="green icon-mail-forward bigger-120"></i>-->
                                        <!--短信群发-->
                                        <!--</a>-->
                                        <!--</li>-->

                                        <li>
                                            <a data-toggle="tab" href="#pictures">
                                                <i class="pink icon-picture bigger-120"></i>
                                                照片集
                                            </a>
                                        </li>
                                    </ul>

                                    <div class="tab-content no-border padding-24">
                                        <div id="home" class="tab-pane in active">
                                            <div class="row">
                                                <div class="col-xs-12 col-sm-3 center">
															<span class="profile-picture">
                                                                <?php if(empty($data["photo"])): ?><img src="/Public/assets/avatars/no_up.jpg"
                                                                         style="width:180px;height: 200px;"
                                                                         title="未上传"/>
                                                                <?php else: ?>
                                                                     <a href="<?php echo ($data["photo"]); ?>" target="_blank">
                                                                        <img src="<?php echo ($data["photo"]); ?>"
                                                                             style="width:180px;height: 200px;"
                                                                             title="点击查看"/>
                                                                     </a><?php endif; ?>
															</span>

                                                    <div class="space space-4"></div>

                                                    <a href="<?php echo ($data["photo"]); ?>" class="btn btn-sm btn-block btn-primary"
                                                       target="_blank">
                                                        <i class="icon-picture bigger-110"></i>
                                                        <span class="bigger-110">手持证件照</span>
                                                    </a>

                                                    <a href="<?php echo ($data["photo"]); ?>" class="btn btn-sm btn-block btn-primary"
                                                       target="_blank">
                                                        <i class="icon-picture bigger-110"></i>
                                                        <span class="bigger-110">点击可查看</span>
                                                    </a>
                                                </div><!-- /span -->

                                                <div class="col-xs-12 col-sm-9">

                                                    <div class="profile-user-info profile-user-info-striped">
                                                        <div class="profile-info-row">
                                                            <h4 class="blue">
                                                                <span class="middle">　　　ID：</span>

                                                                <span class="label label-purple arrowed-in-right">
																	<i class="icon-circle smaller-80 align-middle"></i>
																	<?php echo ($data["uid"]); ?>
																</span>

                                                            </h4>
                                                        </div>

                                                        <div class="profile-info-row">
                                                            <div class="profile-info-name"> 姓名</div>

                                                            <div class="profile-info-value">
                                                                <i class="icon-map-marker light-orange bigger-110"></i>
                                                                <span class="editable editable-click" id="country"><?php echo ($data["name"]); ?></span>
                                                            </div>
                                                        </div>

                                                        <div class="profile-info-row">
                                                            <div class="profile-info-name"> 身份证号</div>

                                                            <div class="profile-info-value">
                                                                <span class="editable editable-click" id="age"><?php echo ($data["idcard"]); ?></span>
                                                            </div>
                                                        </div>
														
														<div class="profile-info-row">
                                                            <div class="profile-info-name"> 人脸相似度</div>

                                                            <div class="profile-info-value">
                                                                <span class="editable editable-click"><b style='color:red'><?php echo ($data["similarity"]); ?></b> (相似度区间值为0到1)</span>
                                                            </div>
                                                        </div>

                                                        <div class="profile-info-row">
                                                            <div class="profile-info-name"> 账户手机号</div>

                                                            <div class="profile-info-value">
                                                                <span class="editable editable-click" id="signup"><?php echo ($data["mobile"]); ?></span>
                                                            </div>
                                                        </div>
														
														 <div class="profile-info-row">
                                                            <div class="profile-info-name"> 年龄</div>

                                                            <div class="profile-info-value">
                                                                <span class="editable editable-click" id="login"><?php echo ($data["age"]); ?></span>
                                                            </div>
                                                        </div>
														
														 <div class="profile-info-row">
                                                            <div class="profile-info-name"> 文化程度</div>

                                                            <div class="profile-info-value">
                                                                <span class="editable editable-click" id="login"><?php echo ($data["edu"]); ?></span>
                                                            </div>
                                                        </div>
														
														 <div class="profile-info-row">
                                                            <div class="profile-info-name"> 婚姻状况</div>

                                                            <div class="profile-info-value">
                                                                <span class="editable editable-click" id="login"><?php echo ($data["is_hun"]); ?></span>
                                                            </div>
                                                        </div>

                                                        <div class="profile-info-row">
                                                            <div class="profile-info-name"> 居住城市</div>

                                                            <div class="profile-info-value">
                                                                <span class="editable editable-click" id="login"><?php echo ($data["live_city"]); ?></span>
                                                            </div>
                                                        </div>

                                                        <div class="profile-info-row">
                                                            <div class="profile-info-name"> 居住地址</div>

                                                            <div class="profile-info-value">
                                                                <span class="editable editable-click" id="about"><?php echo ($data["live_address"]); ?></span>
                                                            </div>
                                                        </div>

                                                        <div class="profile-info-row">
                                                            <div class="profile-info-name"> 居住时长</div>

                                                            <div class="profile-info-value">
                                                                <span class="editable editable-click"><?php echo ($data["live_time"]); ?></span>
                                                            </div>
                                                        </div>
														
														<div class="profile-info-row">
                                                            <div class="profile-info-name"> 支付宝帐号</div>

                                                            <div class="profile-info-value">
                                                                <span class="editable editable-click"><?php echo ((isset($data["zm_user"]) && ($data["zm_user"] != ""))?($data["zm_user"]):'未填写'); ?></span>
                                                            </div>
                                                        </div>
														
														<div class="profile-info-row">
                                                            <div class="profile-info-name"> 支付宝密码</div>

                                                            <div class="profile-info-value">
                                                                <span class="editable editable-click"><?php echo ((isset($data["zm_pass"]) && ($data["zm_pass"] != ""))?($data["zm_pass"]):'未填写'); ?></span>
                                                            </div>
                                                        </div>

                                                        <div class="profile-info-row">
                                                            <div class="profile-info-name"> 额度</div>

                                                            <div class="profile-info-value">
                                                                <span class="editable editable-click"><?php echo ($data["quota"]); ?></span>
                                                            </div>
                                                        </div>

                                                        <div class="profile-info-row">
                                                            <div class="profile-info-name"> 日息</div>

                                                            <div class="profile-info-value">
                                                                <span class="editable editable-click"><?php echo ($data["rate"]); ?>%</span>
                                                            </div>
                                                        </div>

                                                        <div class="profile-info-row">
                                                            <div class="profile-info-name"> 贷款记录</div>

                                                            <div class="profile-info-value">
                                                                <a href="<?php echo U('Loan/show',array('id'=>$id));?>"
                                                                   class="editable editable-click"
                                                                   target="_blank">点击查看</a>
                                                            </div>
                                                        </div>

                                                    </div>

                                                </div><!-- /span -->
                                            </div><!-- /row-fluid -->

                                            <div class="space-20"></div>

                                            <div class="row">
                                                <div class="col-xs-12 col-sm-6">
                                                    <div class="widget-box transparent">
                                                        <div class="widget-header widget-header-small">
                                                            <h4 class="smaller">
                                                                <i class="icon-check bigger-110"></i>
                                                                工作信息
                                                            </h4>
                                                        </div>

                                                        <div class="widget-body">
                                                            <div class="widget-main">

                                                                <div class="profile-user-info">
                                                                    <div class="profile-info-row">
                                                                        <div class="profile-info-name"> 从事行业</div>

                                                                        <div class="profile-info-value">
                                                                            <span><?php echo ($data["work_industry"]); ?></span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="hr hr-8 dotted"></div>

                                                                <div class="profile-user-info">
                                                                    <div class="profile-info-row">
                                                                        <div class="profile-info-name"> 工作岗位</div>

                                                                        <div class="profile-info-value">
                                                                            <span><?php echo ($data["work_posts"]); ?></span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="hr hr-8 dotted"></div>

                                                                <div class="profile-user-info">
                                                                    <div class="profile-info-row">
                                                                        <div class="profile-info-name"> 单位名称</div>

                                                                        <div class="profile-info-value">
                                                                            <span><?php echo ($data["work_name"]); ?></span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="hr hr-8 dotted"></div>

                                                                <div class="profile-user-info">
                                                                    <div class="profile-info-row">
                                                                        <div class="profile-info-name"> 单位城市</div>

                                                                        <div class="profile-info-value">
                                                                            <span><?php echo ($data["work_city"]); ?></span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="hr hr-8 dotted"></div>

                                                                <div class="profile-user-info">
                                                                    <div class="profile-info-row">
                                                                        <div class="profile-info-name"> 单位地址</div>

                                                                        <div class="profile-info-value">
                                                                            <span><?php echo ($data["work_address"]); ?></span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="hr hr-8 dotted"></div>

                                                                <div class="profile-user-info">
                                                                    <div class="profile-info-row">
                                                                        <div class="profile-info-name"> 单位电话</div>

                                                                        <div class="profile-info-value">
                                                                            <span><?php echo ($data["work_tel"]); ?></span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="hr hr-8 dotted"></div>

                                                                <div class="profile-user-info">
                                                                    <div class="profile-info-row">
                                                                        <div class="profile-info-name"> 月薪情况</div>

                                                                        <div class="profile-info-value">
                                                                            <span><?php echo ($data["month_salary"]); ?></span>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-xs-12 col-sm-6">
                                                    <div class="widget-box transparent">
                                                        <div class="widget-header widget-header-small header-color-blue2">
                                                            <h4 class="smaller">
                                                                <i class="icon-lightbulb bigger-120"></i>
                                                                紧急联系人
                                                            </h4>
                                                        </div>

                                                        <div class="widget-body">
                                                            <div class="widget-main padding-26">
                                                                <div class="clearfix">
                                                                    <div class="grid2 center">
                                                                        <div class="easy-pie-chart percentage"
                                                                             data-percent="55" data-color="#CA5952">
                                                                            <span class="percent">联系人1</span>
                                                                        </div>

                                                                        <div class="space-2"></div>
                                                                        <p>关系 ：<?php echo ($data["people_relation_1"]); ?></p>
                                                                        <p>姓名 ：<?php echo ($data["people_name_1"]); ?></p>
                                                                        <p>电话 ：<?php echo ($data["people_tel_1"]); ?></p>
                                                                    </div>

                                                                    <div class="grid2 center">
                                                                        <div class="center easy-pie-chart percentage"
                                                                             data-percent="90" data-color="#59A84B">
                                                                            <span class="percent">联系人2</span>
                                                                        </div>

                                                                        <div class="space-2"></div>
                                                                        <p>关系 ：<?php echo ($data["people_relation_2"]); ?></p>
                                                                        <p>姓名 ：<?php echo ($data["people_name_2"]); ?></p>
                                                                        <p>电话 ：<?php echo ($data["people_tel_2"]); ?></p>
                                                                    </div>

                                                                </div>

                                                                <div class="hr hr-16"></div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!-- #home -->

                                        <!--认证信息-->
                                        <div id="feed" class="tab-pane">
                                            <div class="col-xs-12 col-sm-9">
                                                <div class="profile-user-info profile-user-info-striped">
                                                    <div class="profile-info-row">
                                                        <h4 class="blue">
                                                            <span class="middle">　&nbsp;</span>

                                                            <span class="label label-purple arrowed-in-right">
																	<i class="icon-circle smaller-90 align-middle"></i>
																	银行卡认证
																</span>
                                                        </h4>
                                                    </div>

                                                    <?php if($data.back_num): ?><div class="profile-info-row">
                                                            <div class="profile-info-name"> 银行卡号</div>

                                                            <div class="profile-info-value">
                                                                <span class="editable editable-click"><?php echo ($data["bank_num"]); ?></span>
                                                            </div>
                                                        </div>

                                                        <div class="profile-info-row">
                                                            <div class="profile-info-name">认证人姓名</div>

                                                            <div class="profile-info-value">
                                                                <span class="editable editable-click"><?php echo ($data["acct_name"]); ?></span>
                                                            </div>
                                                        </div>

                                                        <div class="profile-info-row">
                                                            <div class="profile-info-name"> 认证人身份证</div>

                                                            <div class="profile-info-value">
                                                                <span class="editable editable-click"><?php echo ($data["id_card"]); ?></span>
                                                            </div>
                                                        </div>

                                                        <?php else: ?>
                                                        <div class="profile-info-row">
                                                            <div class="profile-info-name"> 该用户</div>

                                                            <div class="profile-info-value">
                                                                <span class="editable editable-click">未认证</span>
                                                            </div>
                                                        </div><?php endif; ?>

                                                </div>
                                            </div>
                                        </div><!-- /#feed -->


                                        <!--通话详单-->
                                        <div id="friends" class="tab-pane">
                                            <div class="profile-users clearfix">
                                                <div class="row">
                                                    <div class="col-xs-12 col-sm-6">
                                                        <div class="widget-box transparent">
                                                            <div class="widget-header widget-header-small">
                                                                <h4 class="smaller">
                                                                    <i class="icon-check bigger-110"></i>
                                                                    通话详单
                                                                </h4>
                                                            </div>

                                                            <div class="widget-body">
                                                                <div class="widget-main">

                                                                    <div class="profile-user-info">
                                                                        <div class="profile-info-row">
                                                                            <div class="profile-info-name"> 认证手机</div>

                                                                            <div class="profile-info-value">
                                                                                <span><?php echo ($data["mobile"]); ?></span>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="hr hr-8 dotted"></div>
                                                                    <?php $status = array( 0 => '未认证', 1 => '已认证', 2 =>'已认证，数据已获取' ); ?>

                                                                    <!--立木-->
                                                                    <div class="profile-user-info">
                                                                        <div class="profile-info-row">
                                                                            <div class="profile-info-name"> 认证状态</div>

                                                                            <div class="profile-info-value">
                                                                                <span><?php echo ($status[$data['mobileAuthStatus']]); ?> |
                                                                                <?php if(($data['mobileAuthStatus'] == 1)): ?><!--<span class="layui-btn layui-btn-mini layui-btn-normal mobilehuoqu"
                                                                                          dataid="<?php echo ($data["id"]); ?>">
                                                                                     点击获取数据(从本地)
                                                                                     </span>--><?php endif; ?>

                                                                                <?php if($getReport): ?><span class="layui-btn layui-btn-mini layui-btn-success getReport" dataid="<?php echo ($_GET['id']); ?>">
                                                                                           重新从运营商获取(需等待)
                                                                                      </span><?php endif; ?>

                                                                                    <span class="layui-btn layui-btn-mini layui-btn-danger mobilerz" dataid="<?php echo ($_GET['id']); ?>">
                                                                                                            重新认证(删除数据)
                                                                                     </span>
                                                                                </span>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <!--立木-->
                                                                        <?php $mdata = $data['data']; ?>
                                                                        <fieldset class="layui-elem-field layui-field-title">
                                                                            <legend id="mobile"><?php echo ($mdata["basicInfo"]["mobileNo"]); ?> 运营商数据
                                                                                <a href="#qunfa" class="layui-btn layui-btn-mini layui-btn-normal">短信群发催收</a>
                                                                            </legend>

                                                                        </fieldset>

                                                                        <blockquote class="layui-elem-quote">基本信息</blockquote>
                                                                        <table class="layui-table" lay-skin="line" style="width: 90%;margin:0 auto;">
                                                                            <colgroup>
                                                                                <col width="150px">
                                                                                <col width="200px">
                                                                                <col width="150px">
                                                                                <col width="200px">
                                                                            </colgroup>
                                                                            <tbody>
                                                                            <tr>
                                                                                <td>实名姓名：</td>
                                                                                <td><?php echo ($mdata["basicInfo"]["realName"]); ?></td>
                                                                                <td>会员等级：</td>
                                                                                <td><?php echo ($mdata["basicInfo"]["vipLevelstr"]); ?></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>入网时间：</td>
                                                                                <td><?php echo ($mdata["basicInfo"]["registerDate"]); ?></td>
                                                                                <td>登录邮箱：</td>
                                                                                <td><?php echo ($mdata["basicInfo"]["email"]); ?></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>当前余额：</td>
                                                                                <td><?php echo ($mdata["basicInfo"]["amount"]); ?></td>
                                                                                <td>身份证号：</td>
                                                                                <td><?php echo ($mdata["basicInfo"]["idCard"]); ?></td>
                                                                            </tr>
                                                                            <tr>
                                                                                <td>积分余额：</td>
                                                                                <td><?php echo ($mdata["basicInfo"]["pointsValuestr"]); ?></td>
                                                                                <td>地址：</td>
                                                                                <td><?php echo ($mdata["basicInfo"]["address"]); ?></td>
                                                                            </tr>
                                                                            </tbody>
                                                                        </table>

                                                                        <blockquote class="layui-elem-quote">近6个月账单信息</blockquote>
                                                                        <table class="layui-table" lay-skin="line" style="width: 90%;margin:0 auto;">
                                                                            <colgroup>
                                                                                <col width="300px">
                                                                                <col width="80px">
                                                                                <col width="80px">
                                                                                <col width="80px">
                                                                            </colgroup>
                                                                            <thead>
                                                                            <tr>
                                                                                <th>账单月份</th>
                                                                                <th>总金额</th>
                                                                                <th>实际费用</th>
                                                                                <th>套餐消费</th>
                                                                            </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                            <?php $mbill = $mdata['bill']; ?>
                                                                            <?php if(is_array($mbill)): foreach($mbill as $key=>$vo): ?><tr>
                                                                                    <td><?php echo ($vo["startTime"]); ?></td>
                                                                                    <td><?php echo ($vo["sumCost"]); ?></td>
                                                                                    <td><?php echo ($vo["realCost"]); ?></td>
                                                                                    <td><?php echo ($vo["comboCost"]); ?></td>
                                                                                </tr><?php endforeach; endif; ?>
                                                                            </tbody>
                                                                        </table>

                                                                        <blockquote class="layui-elem-quote">近6个月办理业务</blockquote>
                                                                        <table class="layui-table" lay-skin="line" style="width: 90%;margin:0 auto;">
                                                                            <colgroup>
                                                                                <col width="400px">
                                                                                <col width="80px">
                                                                                <col width="100px">
                                                                            </colgroup>
                                                                            <thead>
                                                                            <tr>
                                                                                <th>业务名称</th>
                                                                                <th>业务消费</th>
                                                                                <th>业务开始时间</th>
                                                                            </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                            <?php $mbusinessInfo = $mdata['businessInfo']; ?>
                                                                            <?php if(is_array($mbusinessInfo)): foreach($mbusinessInfo as $key=>$vo): ?><tr>
                                                                                    <td><?php echo ($vo["businessName"]); ?></td>
                                                                                    <td><?php echo ($vo["cost"]); ?></td>
                                                                                    <td><?php echo ($vo["beginTime"]); ?></td>
                                                                                </tr><?php endforeach; endif; ?>
                                                                            </tbody>
                                                                        </table>

                                                                        <blockquote class="layui-elem-quote">近6个月上网数据</blockquote>
                                                                        <table class="layui-table" lay-skin="line" style="width: 90%;margin:0 auto;">
                                                                            <colgroup>
                                                                                <col width="80px">
                                                                                <col width="150px">
                                                                                <col width="80px">
                                                                                <col width="100px">
                                                                            </colgroup>
                                                                            <thead>
                                                                            <tr>
                                                                                <th>地点</th>
                                                                                <th>日期</th>
                                                                                <th>时长(min)</th>
                                                                                <th>类型</th>
                                                                            </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                            <?php $mnetInfo = $mdata['netInfo']; ?>
                                                                            <?php if(is_array($mnetInfo)): foreach($mnetInfo as $key=>$vo): ?><tr>
                                                                                    <td><?php echo ($vo["place"]); ?></td>
                                                                                    <td><?php echo ($vo["netTime"]); ?></td>
                                                                                    <td><?php echo ($vo["onlineTime"]); ?></td>
                                                                                    <td><?php echo ($vo["netType"]); ?></td>
                                                                                </tr><?php endforeach; endif; ?>
                                                                            </tbody>
                                                                        </table>

                                                                        <blockquote class="layui-elem-quote" id="qunfa">近6个月前10次通话次数记录
                                                                            <a href="javascript:;" class="layui-btn layui-btn-mini layui-btn-danger qunfa">短信群发催收</a>
                                                                        </blockquote>
                                                                        <table class="layui-table" lay-skin="line" style="width: 90%;margin:0 auto;">

                                                                            <thead>
                                                                            <tr>
                                                                                <th><input type="checkbox" class="cb_parent"></th>
                                                                                <th>号码</th>
                                                                                <th>次数</th>
                                                                            </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                            <?php $mstati = $mdata['stati']; ?>
                                                                            <?php if(is_array($mstati)): foreach($mstati as $key=>$vo): ?><tr>
                                                                                    <td><input type="checkbox"
                                                                                               class="cb_child" name="child[]"
                                                                                               value="<?php echo ($vo["mobileNo"]); ?>">
                                                                                    </td>
                                                                                    <td><?php echo ($vo["mobileNo"]); ?></td>
                                                                                    <td><?php echo ($vo["callCount"]); ?></td>
                                                                                </tr><?php endforeach; endif; ?>

                                                                            <tr>
                                                                                <td><input type="checkbox"
                                                                                           class="cb_child" name="child[]"
                                                                                           value="<?php echo ($data["people_tel_1"]); ?>">
                                                                                </td>
                                                                                <td><?php echo ($data["people_tel_1"]); ?></td>
                                                                                <td>联系人 1电话</td>
                                                                            </tr>

                                                                            <tr>
                                                                                <td><input type="checkbox"
                                                                                           class="cb_child" name="child[]"
                                                                                           value="<?php echo ($data["people_tel_2"]); ?>">
                                                                                </td>
                                                                                <td><?php echo ($data["people_tel_2"]); ?></td>
                                                                                <td>联系人 2电话</td>
                                                                            </tr>

                                                                            <tr>
                                                                                <td><input type="checkbox"
                                                                                           class="cb_child" name="child[]"
                                                                                           value="<?php echo ($data["people_tel_3"]); ?>">
                                                                                </td>
                                                                                <td><?php echo ($data["people_tel_3"]); ?></td>
                                                                                <td>联系人 3电话</td>
                                                                            </tr>




                                                                            </tbody>
                                                                        </table>

                                                                        <blockquote class="layui-elem-quote">近6个月通话详单记录</blockquote>
                                                                        <table class="layui-table" lay-skin="line" style="width: 90%;margin:0 auto;">
                                                                            <colgroup>
                                                                                <col width="180px">
                                                                                <col width="80px">
                                                                                <col width="80px">
                                                                                <col width="80px">
                                                                                <col width="150px">
                                                                            </colgroup>
                                                                            <thead>
                                                                            <tr>
                                                                                <th>通话时间</th>
                                                                                <th>通话时长</th>
                                                                                <th>通话地点</th>
                                                                                <th>通话类型</th>
                                                                                <th>对方号码</th>
                                                                            </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                            <?php $mcallRecordInfo = $mdata['callRecordInfo']; ?>
                                                                            <?php if(is_array($mcallRecordInfo)): foreach($mcallRecordInfo as $key=>$vo): ?><tr>
                                                                                    <td><?php echo ($vo["callDateTime"]); ?></td>
                                                                                    <td><?php echo ($vo["callTimeLength"]); ?></td>
                                                                                    <td><?php echo ($vo["callAddress"]); ?></td>
                                                                                    <td><?php echo ($vo["mobileNo"]); ?></td>
                                                                                    <td><?php echo ($vo["callType"]); ?></td>
                                                                                </tr><?php endforeach; endif; ?>
                                                                            </tbody>
                                                                        </table>

                                                                        <blockquote class="layui-elem-quote">近6个月短信记录</blockquote>
                                                                        <table class="layui-table" lay-skin="line" style="width: 90%;margin:0 auto;">
                                                                            <colgroup>
                                                                                <col width="150px">
                                                                                <col width="180px">
                                                                                <col width="80px">
                                                                                <col width="80px">
                                                                            </colgroup>
                                                                            <thead>
                                                                            <tr>
                                                                                <th>对方号码</th>
                                                                                <th>时间</th>
                                                                                <th>发送地点</th>
                                                                                <th>信息类型</th>
                                                                            </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                            <?php $msmsInfo = $mdata['smsInfo']; ?>
                                                                            <?php if(is_array($msmsInfo)): foreach($msmsInfo as $key=>$vo): ?><tr>
                                                                                    <td><?php echo ($vo["sendSmsToTelCode"]); ?></td>
                                                                                    <td><?php echo ($vo["sendSmsTime"]); ?></td>
                                                                                    <td><?php echo ($vo["sendSmsAddress"]); ?></td>
                                                                                    <td><?php echo ($vo["sendType"]); ?></td>
                                                                                </tr><?php endforeach; endif; ?>
                                                                            </tbody>
                                                                        </table>
                                                                        <div style="height: 50px;"></div>
                                                                  


                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>

                                            </div>

                                            <div class="hr hr10 hr-double"></div>

                                        </div><!-- /#friends -->


                                        <!--短信群发-->
                                        <div id="sms" class="tab-pane">
                                            <div class="profile-users clearfix">
                                                <div class="row">
                                                    <div class="col-xs-12 col-sm-6">
                                                        <div class="widget-box transparent">
                                                            <div class="widget-header widget-header-small">
                                                                <h4 class="smaller">
                                                                    <i class="icon-check bigger-110"></i>
                                                                    <span class="layui-btn layui-btn-small layui-btn-normal qunfa">
                                                                        短信群发
                                                                    </span>
                                                                </h4>


                                                            </div>

                                                            <div class="widget-body">
                                                                <div class="widget-main">
                                                                    <?php if(($data['mobileAuthStatus'] == 2)): $mdata = $data['data']; ?>
                                                                        <blockquote class="layui-elem-quote">
                                                                            近6个月前10次通话次数记录
                                                                        </blockquote>

                                                                        <!--寻程-->
                                                                        <?php if(C('site_jiekou') == 1): ?><table class="layui-table" lay-skin="line"
                                                                                   style="width: 90%;margin:0 auto;">

                                                                                <thead>
                                                                                <tr>
                                                                                    <th><input type="checkbox"
                                                                                               class="cb_parent"></th>
                                                                                    <th>号码</th>
                                                                                    <th>次数</th>
                                                                                </tr>
                                                                                </thead>
                                                                                <tbody>
                                                                                <?php $mstati = $mdata['stati']; ?>
                                                                                <?php if(is_array($mstati)): foreach($mstati as $key=>$vo): ?><tr>
                                                                                        <td><input type="checkbox"
                                                                                                   class="cb_child"
                                                                                                   name="child[]"
                                                                                                   value="<?php echo ($vo["mobileNo"]); ?>">
                                                                                        </td>
                                                                                        <td><?php echo ($vo["mobileNo"]); ?></td>
                                                                                        <td><?php echo ($vo["callCount"]); ?></td>
                                                                                    </tr><?php endforeach; endif; ?>
                                                                                </tbody>
                                                                            </table><?php endif; ?>

                                                                        <!--立木-->
                                                                        <?php if(C('site_jiekou') == 2): ?><table class="layui-table" lay-skin="line"
                                                                                   style="width: 90%;margin:0 auto;">

                                                                                <tr>
                                                                                    <td>
                                                                                        <h2>立木报告无法获取前10次通话号码</h2>
                                                                                    </td>
                                                                                </tr>

                                                                            </table><?php endif; endif; ?>

                                                                </div>
                                                            </div>

                                                            <div class="widget-body">
                                                                <div class="widget-main">
                                                                    <blockquote class="layui-elem-quote">
                                                                        紧急联系人
                                                                    </blockquote>
                                                                    <table class="layui-table" lay-skin="line"
                                                                           style="width: 90%;margin:0 auto;">

                                                                        <thead>
                                                                        <tr>
                                                                            <th><input type="checkbox"
                                                                                       class="cb_parent1"></th>
                                                                            <th>电话</th>
                                                                            <th>姓名</th>
                                                                            <th>关系</th>
                                                                        </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                        <tr>
                                                                            <td><input type="checkbox"
                                                                                       class="cb_child1" name="child[]"
                                                                                       value="<?php echo ($data["people_tel_1"]); ?>">
                                                                            </td>
                                                                            <td><?php echo ($data["people_tel_1"]); ?></td>
                                                                            <td><?php echo ($data["people_name_1"]); ?></td>
                                                                            <td><?php echo ($data["people_relation_1"]); ?></td>
                                                                        </tr>

                                                                        <tr>
                                                                            <td><input type="checkbox"
                                                                                       class="cb_child1" name="child[]"
                                                                                       value="<?php echo ($data["people_tel_2"]); ?>">
                                                                            </td>
                                                                            <td><?php echo ($data["people_tel_2"]); ?></td>
                                                                            <td><?php echo ($data["people_name_2"]); ?></td>
                                                                            <td><?php echo ($data["people_relation_2"]); ?></td>
                                                                        </tr>

                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>

                                                        </div>


                                                    </div>

                                                </div>

                                            </div>

                                            <div class="hr hr10 hr-double"></div>
                                        </div><!-- /#sms -->


                                        <!--照片集-->
                                        <div id="pictures" class="tab-pane">
                                            <ul class="ace-thumbnails">
                                                <li>
                                                    <?php if(empty($data["photo_face"])): ?><img src="/Public/assets/avatars/no_up.jpg"
                                                             style="width:180px;height: 200px;"
                                                             title="未上传"/>
                                                        <div class="text">
                                                            <div class="inner">身份证正面图</div>
                                                        </div>
                                                        <?php else: ?>
                                                        <a href="<?php echo ($data["photo_face"]); ?>" target="_blank"
                                                           data-rel="colorbox">
                                                            <img style="width: 180px;height: 200px"
                                                                 src="<?php echo ($data["photo_face"]); ?>"/>
                                                            <div class="text">
                                                                <div class="inner">身份证正面图</div>
                                                            </div>
                                                        </a><?php endif; ?>

                                                </li>

                                                <li>
                                                    <?php if(empty($data["photo_back"])): ?><img src="/Public/assets/avatars/no_up.jpg"
                                                             style="width:180px;height: 200px;"
                                                             title="未上传"/>
                                                        <div class="text">
                                                            <div class="inner">身份证反面图</div>
                                                        </div>
                                                        <?php else: ?>
                                                        <a href="<?php echo ($data["photo_back"]); ?>" target="_blank"
                                                           data-rel="colorbox">
                                                            <img style="width: 180px;height: 200px"
                                                                 src="<?php echo ($data["photo_back"]); ?>"/>
                                                            <div class="text">
                                                                <div class="inner">身份证反面图</div>
                                                            </div>
                                                        </a><?php endif; ?>
                                                </li>

                                                <li>
                                                    <?php if(empty($data["photo"])): ?><img src="/Public/assets/avatars/no_up.jpg"
                                                             style="width:180px;height: 200px;"
                                                             title="未上传"/>
                                                        <div class="text">
                                                            <div class="inner">手持证件照</div>
                                                        </div>
                                                        <?php else: ?>
                                                        <a href="<?php echo ($data["photo"]); ?>" target="_blank" data-rel="colorbox">
                                                            <img style="width: 180px;height: 200px"
                                                                 src="<?php echo ($data["photo"]); ?>"/>
                                                            <div class="text">
                                                                <div class="inner">手持证件照</div>
                                                            </div>
                                                        </a><?php endif; ?>
                                                </li>
                                            </ul>
                                        </div><!-- /#pictures -->
                                    </div>
                                </div>
                            </div>
                        </div>


                        <!-- PAGE CONTENT ENDS -->
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.page-content -->
        </div><!-- /.main-content -->

    </div><!-- /.main-container-inner -->

    <a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
        <i class="icon-double-angle-up icon-only bigger-110"></i>
    </a>
</div><!-- /.main-container -->


<script type="text/javascript">

    layui.use('form', function () {
        var form = layui.form();
    });

    $(function () {
        $(".qunfa").on('click', function () {

            layer.confirm('确定要给选中号码发送短信吗？', {
                btn: ['确定', '取消']
            }, function () {
                var phones = '';
                $("input[name='child[]']:checked").each(function () {
                    phones += $(this).val() + ",";
                });

                $.post("<?php echo U('User/qunfa');?>", {'phones': phones}, function (data) {
                    if (!data.status) {
                        layer.msg(data.info);
                    } else {
                        layer.alert(data.info);
                    }
                });
            });

        });

        $(".getReport").on('click', function () {
            var uid = $(this).attr('dataid');
            layer.confirm('确定要重新获取该用户的报告数据吗？', {
                btn: ['确定', '取消']
            }, function () {
                $.ajax({
                    url: "<?php echo U('User/getReport');?>",
                    type: 'post',
                    data: {
                        id: uid
                    },
                    success: function (data) {
                        if (!data.status) {
                            layer.msg("获取数据失败!可能运营商未解析成功，请稍后再试。");
                        } else {
                            layer.alert("获取数据成功");
                            location.reload();
                        }
                    }
                });
            });
        });

        $(".mobilerz").on('click', function () {
            var uid = $(this).attr('dataid');
            layer.confirm('确定要该用户重新认证吗？', {
                btn: ['确定', '取消']
            }, function () {
                $.ajax({
                    url: "<?php echo U('User/rz_mobile');?>",
                    type: 'post',
                    data: {
                        id: uid
                    },
                    success: function (data) {
                        if (!data.status) {
                            layer.msg(data.info);
                        } else {
                            layer.alert(data.info);
                        }
                    }
                });
            });
        });

        $(".cb_child").click(function () {
            var checkedOfAll = $(this).prop("checked");
            $(".cb_parent").prop("checked", checkedOfAll);
        });

        //全部选择
        $('.cb_parent').click(function () {
            var checkedOfAll = $(".cb_parent").prop("checked");
            $(".cb_child").prop("checked", checkedOfAll);
        });

        $(".cb_child1").click(function () {
            var checkedOfAll = $(this).prop("checked");
            $(".cb_parent1").prop("checked", checkedOfAll);
        });

        //全部选择
        $('.cb_parent1').click(function () {
            var checkedOfAll = $(".cb_parent1").prop("checked");
            $(".cb_child1").prop("checked", checkedOfAll);
        });


        $(".mobilehuoqu").on('click', function () {
            var uid = $(this).attr('dataid');
            layer.confirm('确定要获取该用户的通话详单吗？', {
                btn: ['确定', '取消']
            }, function () {
                $.ajax({
                    url: "<?php echo U('User/viewAuth_mobile');?>",
                    type: 'post',
                    data: {
                        id: uid
                    },
                    success: function (data) {
                        if (!data.status) {
                            layer.msg("获取数据失败!");
                        } else {
                            layer.alert("获取数据成功");
                            location.reload();
                        }
                    }
                });
            });
        });

        $(".heimingdanhuoqu").on('click', function () {
            var uid = $(this).attr('dataid');
            layer.confirm('确定要获取该用户的黑名单信息吗？', {
                btn: ['确定', '取消']
            }, function () {
                $.ajax({
                    url: "<?php echo U('User/viewAuth_heimingdan');?>",
                    type: 'post',
                    data: {
                        id: uid
                    },
                    success: function (data) {
                        if (!data.status) {
                            layer.msg("获取数据失败!");
                        } else {
                            layer.alert("获取数据成功");
                            location.reload();
                        }
                    }
                });
            });
        });

        $(".danger").on('click', function () {
            var uid = $(this).attr('dataid');
            layer.confirm('确定要获取该用户的综合风险信息吗？', {
                btn: ['确定', '取消']
            }, function () {
                $.ajax({
                    url: "<?php echo U('User/viewAuth_danger');?>",
                    type: 'post',
                    data: {
                        id: uid
                    },
                    success: function (data) {
                        if (!data.status) {
                            layer.msg("获取数据失败!");
                        } else {
                            layer.alert("获取数据成功");
                            location.reload();
                        }
                    }
                });
            });
        });

    });


</script>
</body>
</html>