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

<?php $status=array( 0=>'等待审核', 1=>'等待还款', 2=>'还款完成', 3=>'已拒绝', 4=>'已还款' ); $datamap=array( 0=>array( 0=>0 ), 1=>array( 0=>1, 1=>2 ), 2=>array( 0=>3 ), 4=>array( 1=>2 ) ); ?>

<div class="page-content">

    <div class="row">
        <div class="col-xs-12">

            <div class="row">
                <div class="space-6"></div>

                <div class="col-sm-7 infobox-container">

                    <a href="<?php echo U('Loan/index');?>" target="main">
                        <div class="infobox infobox-pink">

                            <div class="infobox-icon">
                                <i class="icon-shopping-cart"></i>
                            </div>

                            <div class="infobox-data">
                                <span class="infobox-data-number" id="loan_num"></span>
                                <div class="infobox-content">新订单</div>
                            </div>

                        </div>
                    </a>

                    <a href="<?php echo U('User/index');?>" target="main">
                        <div class="infobox infobox-blue  ">
                            <div class="infobox-icon">
                                <i class="icon-twitter"></i>
                            </div>

                            <div class="infobox-data">
                                <span class="infobox-data-number" id="user_num"></span>
                                <div class="infobox-content">新用户</div>
                            </div>
                        </div>
                    </a>

                    <a href="<?php echo U('Feed/index');?>" target="main">
                        <div class="infobox infobox-green">
                            <div class="infobox-icon">
                                <i class="icon-comments"></i>
                            </div>

                            <div class="infobox-data">
                                <span class="infobox-data-number" id="feed_num"></span>
                                <div class="infobox-content">反馈信息</div>
                            </div>
                        </div>
                    </a>
                </div>


                <div class="vspace-sm"></div>

            </div><!-- /row -->


            <div class="hr hr32 hr-dotted"></div>

            <div class="row">

                <div class="col-sm-12">
                    <div class="widget-box ">
                        <div class="widget-header">
                            <h4 class="lighter smaller">
                                <i class="icon-comment blue"></i>
                                新订单
                            </h4>
                        </div>

                        <div class="widget-body">
                            <div class="widget-main no-padding">
                                <div class="dialogs">

                                    <div class="row">
                                        <div class="col-xs-12">
                                            <div class="row">
                                                <div class="col-xs-12">
                                                    <div class="table-responsive">
                                                        <table id="sample-table-2"
                                                               class="table table-striped table-bordered table-hover">
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
                                                                <th>推荐码</th>
                                                                <th class="hidden-480">贷款金额</th>
                                                                <th>
                                                                    <i class="icon-time bigger-110"></i>
                                                                    贷款期限
                                                                </th>
                                                                <th >
                                                                    <i class="icon-time bigger-110"></i>
                                                                    申请时间
                                                                </th>
                                                                <th>订单状态</th>
                                                                <th>手续费</th>
                                                            </tr>
                                                            </thead>

                                                            <tbody>

                                                            <!--数据start-->
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
                                                                    <td><?php echo ($vo["recommend"]); ?></td>
                                                                    <td><?php echo ($vo["money"]); ?></td>
                                                                    <td>
                                                                        <span class="label label-warning"><?php echo ($vo["day"]); ?> 天</span>
                                                                    </td>
                                                                    <td>
                                                                        <span class="label label-warning"><?php echo (date("Y-m-d",$vo["create_time"])); ?></span>
                                                                    </td>
                                                                    <td>
                                                                        <?php echo ($status[$datamap[$vo['borrow_status']][$vo['payment_status']]]); ?>
                                                                    </td>
                                                                    <td>
                                                                        <?php echo ($vo["fee"]); ?>
                                                                    </td>
                                                                </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>

                                        </div><!-- /.col -->
                                    </div>


                                </div>
                            </div><!-- /widget-main -->
                        </div><!-- /widget-body -->
                    </div><!-- /widget-box -->
                </div><!-- /span -->
            </div><!-- /row -->

            <!-- PAGE CONTENT ENDS -->
        </div><!-- /.col -->
    </div><!-- /.row -->
</div><!-- /.page-content -->

</body>
<script>
    //轮询查询新消息
    $(function () {
        //刚进后台  先查询一次
        var time1 = setInterval(function () {
            $.post("<?php echo U('Index/index');?>", {'n': '1'}, function (res) {
                $("#loan_num").text(res.loan_num);
                $("#user_num").text(res.user_num);
                $("#feed_num").text(res.feed_num);
                if (res.n == 1) {
                    clearInterval(time1);
                    return;
                }
            });
        }, 5000);

        setInterval(function () {
            $.post("<?php echo U('Index/index');?>", '', function (res) {
                $("#loan_num").text(res.loan_num);
                $("#user_num").text(res.user_num);
                $("#feed_num").text(res.feed_num);
            });
        }, 300000);
    });


    jQuery(function ($) {
        var oTable1 = $('#sample-table-2').dataTable({
            "aoColumns": [
                {"bSortable": false},
                null, null, null, null,null,null,null,null,
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
    })


</script>
</html>