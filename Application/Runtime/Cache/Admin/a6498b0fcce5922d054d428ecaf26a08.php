<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <!-- basic styles -->
    <link href="/Public/assets/css/bootstrap.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="/Public/assets/css/font-awesome.min.css"/>
    <link rel="stylesheet" href="/Public/plugins/layui/css/layui.css"/>
    <!--[if IE 7]>
    <link rel="stylesheet" href="/Public/assets/css/font-awesome-ie7.min.css"/>
    <![endif]-->
    <!-- page specific plugin styles -->
    <link rel="stylesheet" href="/Public/assets/css/jquery-ui-1.10.3.custom.min.css" />
    <link rel="stylesheet" href="/Public/assets/css/chosen.css" />
    <link rel="stylesheet" href="/Public/assets/css/datepicker.css" />
    <link rel="stylesheet" href="/Public/assets/css/bootstrap-timepicker.css" />
    <link rel="stylesheet" href="/Public/assets/css/daterangepicker.css" />
    <link rel="stylesheet" href="/Public/assets/css/colorpicker.css" />

    <!-- fonts -->
    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400,300"/>
    <!-- ace styles -->
    <link rel="stylesheet" href="/Public/assets/css/ace.min.css"/>
    <link rel="stylesheet" href="/Public/assets/css/ace-rtl.min.css"/>
    <link rel="stylesheet" href="/Public/assets/css/ace-skins.min.css"/>
    <!--[if lte IE 8]>
    <link rel="stylesheet" href="/Public/assets/css/ace-ie.min.css"/>
    <![endif]-->
    <!-- inline styles related to this page -->
    <!-- ace settings handler -->
    <script src="/Public/assets/js/ace-extra.min.js"></script>
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="/Public/assets/js/html5shiv.js"></script>
    <script src="/Public/assets/js/respond.min.js"></script>
    <![endif]-->
    <!-- basic scripts -->
    <!--[if !IE]> -->
    <script src="/Public/assets/js/jquery-2.0.3.min.js"></script>
    <!-- <![endif]-->
    <!--[if IE]>
    <script src="/Public/assets/js/jquery-1.10.2.min.js"></script>
    <![endif]-->
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
    <!-- page specific plugin scripts -->
    <script src="/Public/assets/js/jquery.dataTables.min.js"></script>
    <script src="/Public/assets/js/jquery.dataTables.bootstrap.js"></script>
    <!--[if lte IE 8]>
    <script src="/Public/assets/js/excanvas.min.js"></script>
    <![endif]-->
    <script src="/Public/assets/js/jquery-ui-1.10.3.custom.min.js"></script>
    <script src="/Public/assets/js/jquery.ui.touch-punch.min.js"></script>
    <script src="/Public/assets/js/chosen.jquery.min.js"></script>
    <script src="/Public/assets/js/fuelux/fuelux.spinner.min.js"></script>
    <script src="/Public/assets/js/date-time/bootstrap-datepicker.min.js"></script>
    <script src="/Public/assets/js/date-time/bootstrap-timepicker.min.js"></script>
    <script src="/Public/assets/js/date-time/moment.min.js"></script>
    <script src="/Public/assets/js/date-time/daterangepicker.min.js"></script>
    <script src="/Public/assets/js/bootstrap-colorpicker.min.js"></script>
    <script src="/Public/assets/js/jquery.knob.min.js"></script>
    <script src="/Public/assets/js/jquery.autosize.min.js"></script>
    <script src="/Public/assets/js/jquery.inputlimiter.1.3.1.min.js"></script>
    <script src="/Public/assets/js/jquery.maskedinput.min.js"></script>
    <script src="/Public/assets/js/bootstrap-tag.min.js"></script>

    <!-- ace scripts -->
    <!-- ace scripts -->
    <script src="/Public/assets/js/ace-elements.min.js"></script>
    <script src="/Public/assets/js/ace.min.js"></script>
    <!-- layerui -->
    <script src="/Public/plugins/layui/layui.js"></script>
    <script src="/Public/js/jquery.form.js"></script>
    <style>
        #show_page div a {
            height: 25px;
            width: auto;
            display: inline-block;
            color: #333;
            border: 1px solid #CCC;
            text-decoration: none;
            line-height: 25px;
            padding-left: 5px;
            padding-right: 5px;
            background-color: #F9F9F9;
        }

        #show_page div .current {
            height: 25px;
            width: auto;
            padding-left: 8px;
            padding-right: 8px;
            line-height: 25px;
            display: inline-block;
            background-color: #09F;
            color: #FFF;
        }

        #show_page div a:hover {
            background-color: #09F;
            color: #FFF;
            border: 1px solid #09F;
        }
    </style>
</head>
<script src="/Public/js/laydate/laydate.js"></script>
<body>
<?php $status=array( 0=>'等待审核', 1=>'等待还款', 2=>'还款完成', 3=>'已拒绝', 4=>'已还款' ); $datamap=array( 0=>array( 0=>0 ), 1=>array( 0=>1, 1=>2 ), 2=>array( 0=>3 ), 4=>array( 1=>2 ) ); ?>

<div class="page-content">
<?php if(authCheck('Admin/Loan/excel',session(C('ADMIN_INFO'))['id'])): ?><form action="<?php echo U('Loan/index');?>" target="_self" method="get">
            <input type="submit" class="btn btn-success btn-sm tooltip-success" data-rel="tooltip"
                data-placement="left"  name="aliziExcel" value="导出excel">
            </form><?php endif; ?>
    <div class="page-header align-center">
        <h1>
            借款列表
        </h1>
    </div><!-- /.page-header -->
    <div class="row">
        <div class="col-xs-12">
            <!-- PAGE CONTENT BEGINS -->
            <div style="text-align: center;">
                <form action="<?php echo U('Loan/index');?>" method="get">
                    姓名:
                    <input type="text" name="name" placeholder="姓名" value="<?php echo ($name); ?>">
                    &nbsp;&nbsp;&nbsp;手机号:
                    <input type="text" name="mobile" placeholder="手机号" value="<?php echo ($mobile); ?>">
                    &nbsp;&nbsp;&nbsp;放款时间:
                    <input type="text" name="review_time_start" placeholder="开始时间" value="<?php echo ($review_time_start); ?>"
                           onclick="laydate()">
                    至
                    <input type="text" name="review_time_end" placeholder="结束时间" value="<?php echo ($review_time_end); ?>" id="demo">
                    &nbsp;&nbsp;&nbsp;订单状态:
                    <select name="borrow_status">
                        <option value="-1"
                        <?php if($where['borrow_status'] == -1): ?>selected=""<?php endif; ?>
                        >全部</option>
                        <option value="0"
                        <?php if($where['borrow_status'] == 0): ?>selected=""<?php endif; ?>
                        >等待审核</option>
                        <option value="5"
                        <?php if($where['borrow_status'] == 5): ?>selected=""<?php endif; ?>
                        >等待打款</option>
                        <option value="1"
                        <?php if($where['borrow_status'] == 1): ?>selected=""<?php endif; ?>
                        >等待还款</option>
                        <option value="4"
                        <?php if($where['borrow_status'] == 4): ?>selected=""<?php endif; ?>
                        >还款完成</option>
                        <option value="2"
                        <?php if($where['borrow_status'] == 2): ?>selected=""<?php endif; ?>
                        >已拒绝</option>
                        <option value="3"
                        <?php if($yuqi == 3): ?>selected=""<?php endif; ?>
                         >已逾期</option>
                         <option value="8"
                        <?php if($is_jiechang == 8): ?>selected=""<?php endif; ?>
                         >已帮还</option>
                    </select>
                    <button class="btn btn-xs btn-info" type="submit">筛选</button>
                </form>
            </div>
            <br/>

            <div class="row">
                <div class="col-xs-12">
                    <div class="table-responsive">
                        <table id="sample-table-1" class="table table-striped table-bordered table-hover">
                            <thead>
                            <tr>
                                <th class="center">
                                    <label>
                                        <input type="checkbox" class="ace"/>
                                        <span class="lbl"></span>
                                    </label>
                                </th>
                                <th>ID</th>
                                <th>订单号</th>
                                <th>姓名</th>
                                <th>手机号</th>
                                <th>银行卡号</th>
                                <th>是否邀请</th>
                                <th>贷款统计</th>
                                <th class="hidden-480">借款金额</th>
                                <th>
                                    <i class="icon-time bigger-110 hidden-480"></i>
                                    借款期限
                                </th>
                                <th class="hidden-480">
                                    <i class="icon-time bigger-110 hidden-480"></i>
                                    申请时间
                                </th>
                                <th>订单状态</th>
                                <th>手续费</th>
                                <th>放款金额</th>
                                <th><i class="icon-time bigger-110 hidden-480"></i>放款时间</th>
                                <th><i class="icon-time bigger-110 hidden-480"></i>应还时间</th>
                                <th><i class="icon-time bigger-110 hidden-480"></i>还款时间</th>
                                <th><i class="icon-time bigger-110 hidden-480"></i>逾期</th>
                                <th>逾期费用</th>
                                <th>是否帮还</th>
                                <th>备注</th>
                                <th>操作</th>
                            </tr>
                            </thead>

                            <tbody>

                            <?php if(is_array($lists)): $i = 0; $__LIST__ = $lists;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
                                    <td class="center">
                                        <label>
                                            <input type="checkbox" class="ace"/>
                                            <span class="lbl"></span>
                                        </label>
                                    </td>

                                    <td>
                                        <a href="#"><?php echo ($vo["id"]); ?></a>
                                    </td>
                                    <td><?php echo ($vo["oid"]); ?></td>
                                    <td><?php echo ($vo["name"]); ?></td>
                                    
                                     <td><?php echo ($vo["mobile"]); ?></td>
                                     <td><?php echo ($vo["bank_num"]); ?></td>
                                     <td><?php echo ($vo['is_yao']?'是':'否'); ?></td>
                                     <td>
                                     <span class="label label-warning">次数:<?php echo ($vo["num"]); ?>,拒绝:<?php echo ($vo["fborrow"]); ?>,完成:<?php echo ($vo["payment_num"]); ?></span>
                                     </td>
                                    <td class="hidden-480"><?php echo ($vo["money"]); ?></td>
                                    <td>
                                        <span class="label label-warning"><?php echo ($vo["day"]); ?> 天</span>
                                    </td>
                                    <td class="hidden-480">
                                        <span class="label label-warning"><?php echo (date("Y-m-d",$vo["create_time"])); ?></span>
                                    </td>
                                    <td>
                                    <?php switch($vo["borrow_status"]): case "0": ?><span class="label label-primary">等待审核</span><?php break;?>
                                        <?php case "1": ?><span class="label label-danger">等待还款</span><?php break;?>
                                        <?php case "2": ?><span class="label label-warning">已拒绝</span><?php break;?>
                                        <?php case "4": ?><span class="label label-success">还款完成</span><?php break;?>
                                        <?php case "5": ?><span class="label label-purple">等待打款</span><?php break;?>
                                        <?php default: endswitch;?>
                                    </td>
                                    <td>
                                        <?php echo ($vo["fee"]); ?>
                                    </td>
                                    <td>
                                        <?php if($vo["review_money"] == 0): ?>----
                                            <?php else: ?>
                                            <?php echo ($vo["review_money"]); endif; ?>
                                    </td>
                                    <td class="hidden-480">
                                        <?php if($vo["review_time"] == 0): echo (date("Y-m-d",$vo["create_time"])); ?>
                                            <?php else: ?>
                                            <span class="label label-warning"><?php echo (date("Y-m-d",$vo["create_time"])); ?></span><?php endif; ?>
                                    </td>
                                    <td class="hidden-480">
                                        <?php if($vo["review_time"] == 0): echo (date("Y-m-d",$vo['create_time']+$vo['day']*24*3600)); ?>
                                            <?php else: ?>
                                            <span class="label label-warning"><?php echo (date("Y-m-d",$vo['create_time']+$vo['day']*24*3600)); ?></span><?php endif; ?>
                                    </td>
                                    <td class="hidden-480">
                                        <?php if($vo["payment_time"] == 0): ?>----
                                            <?php else: ?>
                                            <span class="label label-warning"><?php echo (date("Y-m-d",$vo['create_time']+$vo['day']*24*3600)); ?></span><?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if($vo["review_time"] == 0): ?>----
                                            <?php else: ?>
                                            <?php if(($vo["yq"] > 0) && (($vo["borrow_status"] == 1)|| ($vo["borrow_status"] == 4))): ?><span
                                                    style="color: #ff0000"><?php echo ($vo['yq']); ?> 天</span>
                                                <?php else: ?>
                                                未逾期<?php endif; endif; ?>
                                    </td>

                                    <td>
                                        <?php if($vo["review_time"] == 0): ?>----
                                            <?php else: ?>
                                            <?php if(($vo["yq"] > 0) && (($vo["borrow_status"] == 1)|| ($vo["borrow_status"] == 4))): ?><span
                                                    style="color: #ff0000">
                                                    <?php
 $yu_money = $vo['yq']*nl_get_customConfig('yu_money')*$vo['money']/100; if($yu_money>$vo['money']*nl_get_customConfig('yu_max_money')){ $yu_money=$vo['money']; } ?>
                                                    <?php echo $yu_money;?></span>
                                                <?php else: ?>
                                                ----<?php endif; endif; ?>
                                    </td>
                                    <td><?php echo ($vo['is_jiechang']?'已帮还':'否'); ?></td>
                                    <td><?php echo ($vo["review_note"]); ?></td>
                                    <td>
                                        <?php $t_status = $datamap[$vo['borrow_status']][$vo['payment_status']]; ?>
                                        <div class="visible-md visible-lg hidden-sm hidden-xs btn-group">

                                            <?php if(authCheck('Admin/User/viewAuth',session(C('ADMIN_INFO'))['id'])): ?><a href="<?php echo U('User/viewAuth',array('id'=>$vo['uid']));?>"
                                                   class="btn btn-xs btn-success" target="_blank" title="查看资料">
                                                    <i class="icon-search bigger-120">资料</i>
                                                </a><?php endif; ?>

                                            <?php $cuishou_time=time()+24*3600-($vo['review_time']+$vo['day']*24*3600); ?>

                                            <?php if(authCheck('Admin/Loan/sendSms',session(C('ADMIN_INFO'))['id'])): if($vo["borrow_status"] == 1): if(($cuishou_time > 0) AND ($vo["payment_time"] == 0)): ?><a class="btn btn-xs btn-info sendSms" dataid="<?php echo ($vo["uid"]); ?>"
                                                           title="逾期提醒">
                                                            <i class="icon-edit bigger-120">逾期提醒</i>
                                                        </a><?php endif; endif; endif; ?>
                                            
                                            <?php if(authCheck('Admin/Loan/dkLoan',session(C('ADMIN_INFO'))['id'])): if($vo['borrow_status'] == 5): ?><a class="btn btn-xs btn-yellow dkLoan"
                                                           dataid="<?php echo ($vo["id"]); ?>" title="打款">
                                                            <i class="icon-flag bigger-120">打款</i>
                                                </a><?php endif; endif; ?>


                                            <?php if($vo['borrow_status'] == 0): if(authCheck('Admin/Loan/resetStatus',session(C('ADMIN_INFO'))['id'])): ?><a class="btn btn-xs btn-warning resetStatus" dataid="<?php echo ($vo["id"]); ?>"
                                                       datauid="<?php echo ($vo["uid"]); ?>"
                                                       datamoney="<?php echo ($vo["money"]); ?>"
                                                       dataday="<?php echo ($vo["day"]); ?>" databanknum="<?php echo ($vo["bank_num"]); ?>"
                                                       dataname="<?php echo ($vo["name"]); ?>"
                                                       datareview_money="<?php echo ($vo["review_money"]); ?>"
                                                       style="background-color: purple"
                                                       title="审核订单">
                                                        <i class="icon-check bigger-120">审核</i>
                                                    </a><?php endif; ?>

                                                <?php else: ?>

                                                <?php if($vo["payment_status"] == 0): if(authCheck('Admin/Loan/statusLoan',session(C('ADMIN_INFO'))['id'])): ?><a class="btn btn-xs btn-yellow statusLoan"
                                                           dataid="<?php echo ($vo["id"]); ?>" title="还款">
                                                            <i class="icon-flag bigger-120">还款</i>
                                                        </a><?php endif; ?>

                                                    <?php if(authCheck('Admin/Loan/kouLoan',session(C('ADMIN_INFO'))['id'])): $time=time(); ?>
                                                        <?php $yinghuan_time =$vo['review_time']+$vo['day']*86400; ?>
                                                        <?php if($vo["is_kou"] == 0): if(($time) > $yinghuan_time): ?><a class="btn btn-xs btn-pink kouLoan"
                                                                   dataid="<?php echo ($vo["id"]); ?>" datauid="<?php echo ($vo["uid"]); ?>"
                                                                   dataday="<?php echo ($vo["day"]); ?>"
                                                                   datamoney="<?php echo (sprintf('%.2f',$vo['money']+$vo['yq']*nl_get_customConfig('yu_money')*$vo['money']/100)); ?>" title="到期扣款">
                                                                    <i class="icon-flag bigger-120">扣款</i>
                                                                </a><?php endif; endif; endif; ?>
                                                    
                                                    

                                                    <?php if(authCheck('Admin/Loan/xuqiLoan',session(C('ADMIN_INFO'))['id'])): ?><!--  <a class="btn btn-xs btn-purple xuqiLoan"
                                                           dataid="<?php echo ($vo["id"]); ?>" datauid="<?php echo ($vo["uid"]); ?>" title="续期">
                                                            <i class="icon-flag bigger-120">续期</i>
                                                        </a> --><?php endif; endif; endif; ?>
                                            
                                            
                                            
                                             <?php if(authCheck('Admin/Loan/kouLog',session(C('ADMIN_INFO'))['id'])): ?><a class="btn btn-xs btn-pink kouLog"
                                                             target="_blank" href="<?php echo U('Loan/kou_log',array('id'=>$vo['id']));?>" title="扣款记录">
                                                            <i class="icon-desktop bigger-120">扣款记录</i>
                                                        </a><?php endif; ?>
                                            

                                            <?php if(authCheck('Admin/Loan/show',session(C('ADMIN_INFO'))['id'])): ?><a class="btn btn-xs btn-success" title="贷款记录"
                                                   target="_blank" href="<?php echo U('Loan/show',array('id'=>$vo['uid']));?>">
                                                    <i class="icon-desktop bigger-120">贷款记录</i>
                                                </a><?php endif; ?>

                                            <?php if(authCheck('Admin/Loan/delLoan',session(C('ADMIN_INFO'))['id'])): ?><a class="btn btn-xs btn-danger delLoan" title="删除"
                                                   dataid="<?php echo ($vo["id"]); ?>">
                                                    <i class="icon-trash bigger-120">删除</i>
                                                </a><?php endif; ?>
                                            
                                             <?php if(authCheck('Admin/Loan/xieyi',session(C('ADMIN_INFO'))['id'])): ?><a href="<?php echo U('Loan/xieyi',array('id'=>$vo['uid']));?>" class="btn btn-xs btn-success xieyi" title="协议"
                                                   dataid="<?php echo ($vo["id"]); ?>" target="_blank">
                                                    <i class="icon-search bigger-120">协议</i>
                                                </a><?php endif; ?>

                                        </div>

                                    </td>
                                </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                            </tbody>
                        </table>
                    </div><!-- /.table-responsive -->
                </div><!-- /span -->
            </div><!-- /row -->

            <div id="show_page">
                <?php echo ($page); ?>
            </div>

            <div class="hr hr-18 dotted hr-double"></div>

        </div><!-- /.col -->
    </div><!-- /.row -->
</div><!-- /.page-content -->


<!-- inline scripts related to this page -->

<script type="text/javascript">
    jQuery(function ($) {
        var oTable1 = $('#sample-table-2').dataTable({
            "aoColumns": [
                {"bSortable": false},
                null, null, null, null, null, null, null, null, null, null, null, null, null, null, null, null,null,
                {"bSortable": false}
            ]
        });


        $('table th input:checkbox').on('click', function () {
            var that = this;
            $(this).closest('table').find('tr > td:first-child input:checkbox')
                .each(function () {
                    this.checked = that.checked;
                    $(this).closest('tr').toggleClass('selected');
                });

        });


        $('[data-rel="tooltip"]').tooltip({placement: tooltip_placement});
        function tooltip_placement(context, source) {
            var $source = $(source);
            var $parent = $source.closest('table')
            var off1 = $parent.offset();
            var w1 = $parent.width();

            var off2 = $source.offset();
            var w2 = $source.width();

            if (parseInt(off2.left) < parseInt(off1.left) + parseInt(w1 / 2)) return 'right';
            return 'left';
        }
    });

    layui.use('form', function () {
        var form = layui.form();
    });

    //发送催收短信
    $(".sendSms").on('click', function () {
        var uid = $(this).attr('dataid');
        layer.confirm('确定发送逾期提醒短信吗？', {
            btn: ['确定', '取消']
        }, function () {
            $.ajax({
                url: "<?php echo U('Loan/sendSms');?>",
                type: 'get',
                data: {
                    id: uid
                },
                success: function (data) {
                    if (!data.status) {
                        layer.msg("发送失败!");
                    } else {
                        layer.alert("发送成功!");
                    }
                }
            });
        });
    });

    $(function () {
        //审核
        $(".resetStatus").on('click', function () {
            var id = $(this).attr('dataid');
            var bank_num = $(this).attr('databanknum');
            var name = $(this).attr('dataname');
            var money = $(this).attr('datamoney');
            var review_money = $(this).attr('datareview_money');
            var uid = $(this).attr('datauid');
            var day = $(this).attr('dataday');
            $(".resetStatusDiv form input[name='id']").val(id);
            $(".resetStatusDiv form input[name='uid']").val(uid);
            $(".resetStatusDiv form input[name='day']").val(day);
            $(".resetStatusDiv form input[name='money']").val(money);
            $("#r_bank_num").val(bank_num);
            $("#r_name").val(name);
            $("#r_money").val(review_money);
            layer.open({
                type: 1,
                shade: false,
                title: false,
                content: $(".resetStatusDiv")
            });
        });

        $(".delLoan").on('click', function () {
            var id = $(this).attr('dataid');
            layer.confirm('确定要删除该订单吗？', {
                btn: ['确定', '取消']
            }, function () {
                $.ajax({
                    url: "<?php echo U('Loan/delLoan');?>",
                    type: 'get',
                    data: {
                        id: id
                    },
                    success: function (data) {
                        if (!data.status) {
                            layer.msg("删除失败!");
                        } else {
                            layer.alert("删除订单成功!");
                            location.reload();
                        }
                    }
                });
            });
        });

        //续期
        $(".xuqiLoan").on('click', function () {
            var id = $(this).attr('dataid');
            var uid = $(this).attr('datauid');
            layer.confirm('确定要续期订单吗？', {
                btn: ['确定', '取消']
            }, function () {
                $.ajax({
                    url: "<?php echo U('Loan/xuqiLoan');?>",
                    type: 'post',
                    data: {
                        id: id,
                        uid: uid
                    },
                    success: function (data) {
                        if (!data) {
                            layer.alert("续期失败!");
                        } else {
                            layer.alert("续期成功!");
                            location.reload();
                        }
                    }
                });
            });
        });

        //扣款
        $(".kouLoan").on('click', function () {
            var id = $(this).attr('dataid');
            var uid = $(this).attr('datauid');
            var day = $(this).attr('dataday');
            var money = $(this).attr('datamoney');
            layer.confirm('确定要扣款吗？', {
                btn: ['确定', '取消']
            }, function () {
                $.ajax({
                    url: "<?php echo U('Loan/kouLoan');?>",
                    type: 'post',
                    data: {
                        id: id,
                        uid: uid,
                        day: day,
                        money: money
                    },
                    success: function (data) {
                        if (!data) {
                            layer.alert("扣款失败!");
                        } else {
                            layer.alert("扣款成功!");
                            //location.reload();
                        }
                    }
                });
            });
        });

        //还款
        $(".statusLoan").on('click', function () {
            var id = $(this).attr('dataid');
            layer.confirm('确认用户已还款了吗？操作后将不能恢复!', {
                btn: ['确定', '取消']
            }, function () {
                $.ajax({
                    url: "<?php echo U('Loan/statusLoan');?>",
                    type: 'get',
                    data: {
                        id: id
                    },
                    success: function (data) {
                        if (!data.status) {
                            layer.msg("还款失败!");
                        } else {
                            layer.alert("订单还款成功!");
                            location.reload();
                            //  $(".loan_list_"+id).remove();
                        }
                    }
                });
            });
        });
        
         //打款
        $(".dkLoan").on('click', function () {
            var id = $(this).attr('dataid');
            layer.confirm('确认要给用户打款吗？', {
                btn: ['确定', '取消']
            }, function () {
                $.ajax({
                    url: "<?php echo U('Loan/dkLoan');?>",
                    type: 'get',
                    data: {
                        id: id
                    },
                    success: function (data) {
                        if (!data.status) {
                            layer.msg("打款失败!");
                        } else {
                            layer.alert("打款成功!");
                            location.reload();
                            //  $(".loan_list_"+id).remove();
                        }
                    }
                });
            });
        });

    });

    //时间插件
    laydate({
        elem: '#demo'
    });

    function changeStatus() {
        $(".resetStatusDiv form").ajaxSubmit({
            success: function (data) {
                if (data=='0') {
                    layer.closeAll();
                    layer.alert("审核失败,连连出错!");
                } else {
                    layer.closeAll();
                    layer.alert("操作成功！");
                    location.reload();
                }
            }
        });
        return false;
    }


</script>
<!--审核订单-->
<div class="resetStatusDiv" style="display: none;min-width: 350px;">
    <form class="layui-form" action="<?php echo U('Loan/resetStatus');?>" method="post" onsubmit="return changeStatus();">
        <input type="hidden" name="id" value="">
        <input type="hidden" name="uid" value="">
        <input type="hidden" name="day" value="">
        <input type="hidden" name="money" value="">
        <div class="layui-form-item" style="margin-top: 10px">
            <div class="layui-inline">
                <label class="layui-form-label">开户人</label>
                <div class="layui-input-inline">
                    <input type="text" id="r_name" class="layui-input" readonly>
                </div>
            </div>
        </div>

        <div class="layui-form-item">
            <div class="layui-inline">
                <label class="layui-form-label">卡　号</label>
                <div class="layui-input-inline">
                    <input type="text" id="r_bank_num" class="layui-input" readonly>
                </div>
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-inline">
                <label class="layui-form-label">金　额</label>
                <div class="layui-input-inline">
                    <input type="text" id="r_money" name="review_money" class="layui-input" readonly>
                </div>
            </div>
        </div>

        <div class="layui-form-item">
            <div class="layui-inline">
                <label class="layui-form-label">结　果</label>
                <div class="layui-input-inline">
                    <input type="radio" name="borrow_status" value="5" title="通过" checked="checked">
                    <input type="radio" name="borrow_status" value="2" title="拒绝">
                </div>
            </div>
        </div>

        <div class="layui-form-item">
            <div class="layui-inline">
                <label class="layui-form-label">短　信</label>
                <div class="layui-input-inline">
                    <input type="radio" name="sms" value="1" title="发送短信">
                    <input type="radio" name="sms" value="2" title="不发送短信" checked="checked">
                </div>
            </div>
        </div>

        <div class="layui-form-item">
            <div class="layui-inline">
                <label class="layui-form-label">状　态</label>
                <div class="layui-input-inline">
                    <input type="radio" name="user_status" value="1" title="拒绝该用户再申请">
                    <input type="radio" name="user_status" value="0" title="不设置" checked="checked">
                </div>
            </div>
        </div>
     

        <div class="layui-form-item layui-form-text">
            <label class="layui-form-label">备　注</label>
            <div class="layui-input-inline">
                <textarea placeholder="提示用户原因" name="review_note" class="layui-textarea"></textarea>
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn">保存状态</button>
            </div>
        </div>
    </form>
</div>
<!--审核订单end-->
</body>
</html>