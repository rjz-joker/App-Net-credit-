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
                <div class="col-xs-12">
                    <div class="table-header">
                        借款记录
                    </div>

                    <div class="table-responsive">
                        <table id="sample-table-2" class="table table-striped table-bordered table-hover">
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
                                <th>备注</th>
                                <th>操作</th>
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
                                        <?php if($vo["review_time"] == 0): ?>----
                                            <?php else: ?>
                                            <span class="label label-warning"><?php echo (date("Y-m-d",$vo["review_time"])); ?></span><?php endif; ?>
                                    </td>
                                    <td class="hidden-480">
                                        <?php if($vo["review_time"] == 0): ?>----
                                            <?php else: ?>
                                            <span class="label label-warning"><?php echo (date("Y-m-d",$vo['review_time']+$vo['day']*24*3600)); ?></span><?php endif; ?>
                                    </td>
                                    <td class="hidden-480">
                                        <?php if($vo["payment_time"] == 0): ?>----
                                            <?php else: ?>
                                            <span class="label label-warning"><?php echo (date("Y-m-d",$vo["payment_time"])); ?></span><?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if($vo["review_time"] == 0): ?>----
                                            <?php else: ?>
                                            <?php if(($vo["yq"] > 0) && (($vo["borrow_status"] == 1) || ($vo["borrow_status"] == 4))): ?><span
                                                    style="color: #ff0000"><?php echo ($vo['yq']); ?> 天</span>
                                                <?php else: ?>
                                                未逾期<?php endif; endif; ?>
                                    </td>
                                    <td>
                                        <?php if($vo["review_time"] == 0): ?>----
                                            <?php else: ?>
                                            <?php if(($vo["yq"] > 0) && (($vo["borrow_status"] == 1)|| ($vo["borrow_status"] == 4))): ?><span
                                                    style="color: #ff0000"><?php echo (sprintf('%.2f',$vo['yq']*nl_get_customConfig('yu_money')*$vo['money']/100)); ?></span>
                                                <?php else: ?>
                                                ----<?php endif; endif; ?>
                                    </td>
                                    <td><?php echo ($vo["review_note"]); ?></td>
                                    <td>
                                        <div class="visible-md visible-lg hidden-sm hidden-xs btn-group">

                                            <?php if(authCheck('Admin/Loan/delLoan',session(C('ADMIN_INFO'))['id'])): ?><a class="btn btn-xs btn-danger delLoan" title="删除"
                                                   dataid="<?php echo ($vo["id"]); ?>">
                                                    <i class="icon-trash bigger-120">删除</i>
                                                </a><?php endif; ?>

                                        </div>

                                    </td>
                                </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>


        </div><!-- /.col -->
    </div><!-- /.row -->
</div><!-- /.page-content -->

<script type="text/javascript">
    layui.use('form', function () {
        var form = layui.form();
    });

    $(function () {

        $(".delLoan").on('click', function () {
            var uid = $(this).attr('dataid');
            layer.confirm('确定要删除该订单吗？', {
                btn: ['确定', '取消']
            }, function () {
                $.ajax({
                    url: "<?php echo U('Loan/delLoan');?>",
                    type: 'get',
                    data: {
                        id: uid
                    },
                    success: function (data) {
                        if (!data.status) {
                            layer.msg("删除失败!");
                        } else {
                            layer.msg("删除订单成功!");
                            location.reload();
                        }
                    }
                });
            });
        });
    });


    jQuery(function ($) {
        var oTable1 = $('#sample-table-2').dataTable({
            "aoColumns": [
                {"bSortable": false},
                null, null, null, null, null, null, null, null, null, null, null, null, null, null,null,null,
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


<div class="resetStatusDiv" style="display: none;min-width: 300px;">
    <form class="layui-form" action="<?php echo U('User/resetStatus');?>" method="post" onsubmit="return changeStatus();">
        <input type="hidden" name="id" value="">
        <div class="layui-form-item">
            <label class="layui-form-label">状态</label>
            <div class="layui-input-block">
                <input type="radio" name="status" value="1" title="正常">
                <input type="radio" name="status" value="0" title="风控">
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn" lay-submit="">提交修改</button>
            </div>
        </div>
    </form>
</div>

<div class="resetRateDiv" style="display: none;min-width: 300px;margin-top: 15px;">
    <form class="layui-form" action="<?php echo U('User/resetRate');?>" method="post" onsubmit="return changeRate();">
        <input type="hidden" name="id" value="">
        <div class="layui-form-item">
            <div class="layui-inline">
                <label class="layui-form-label">贷款额度</label>
                <div class="layui-input-inline">
                    <input type="text" name="quota" autocomplete="off" class="layui-input">
                </div>
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-inline">
                <label class="layui-form-label">用户日息</label>
                <div class="layui-input-inline">
                    <input type="text" name="rate" autocomplete="off" class="layui-input">
                </div>
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-input-block">
                <button class="layui-btn" lay-submit="">提交修改</button>
            </div>
        </div>
    </form>
</div>

</body>
</html>