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


<div class="page-content">

    <div class="row">
        <div class="col-xs-12">
            <div class="row">
                <div class="col-xs-12">
                    <div class="table-header" style="position:relative;">
                        会员管理
						<?php if(authCheck('Admin/User/excel',session(C('ADMIN_INFO'))['id'])): ?><div style="display:block;position:absolute;left:100px;top:0;">
                        <form action="<?php echo U('User/index');?>" target="_self" method="get">
                            <input type="submit" class="btn btn-success btn-sm tooltip-success" data-rel="tooltip"
                                  data-placement="left"  name="aliziExcel" value="导出excel">
                        </form>
						</div><?php endif; ?>
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
                                <th>姓名</th>
                                <th class="hidden-480">手机号</th>
                                <th>额度</th>
                                <th>日息</th>
                                <th class="hidden-480">贷款统计</th>
                                <th>状态</th>
                                <th>是否邀请</th>
                                <th>注册时间</th>
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
                                    <td><?php echo ($vo["name"]); ?></td>
                                    <td class="hidden-480"><?php echo ($vo["mobile"]); ?></td>
                                    <td><?php echo ($vo["quota"]); ?></td>
                                    <td><?php echo ($vo["rate"]); ?>%</td>
                                    <td class="hidden-480">
                                        <span class="label label-warning">成功:<?php echo ($vo["borrow"]); ?>,失败:<?php echo ($vo["fborrow"]); ?>,完成:<?php echo ($vo["payment"]); ?></span>
                                    </td>
                                    <td>
                                        <?php if($vo['status'] == 1): ?>正常
                                            <?php else: ?>
                                            风控<?php endif; ?>
                                    </td>
									<td>
                                        <?php if($vo['is_yao'] == 1): ?>是
                                            <?php else: ?>
                                            否<?php endif; ?>
                                    </td>
                                    <td><?php echo (date('Y-m-d H:i:s',$vo["create_time"])); ?></td>
                                    <td>
                                        <div class="visible-md visible-lg hidden-sm hidden-xs action-buttons">

                                            <?php if(authCheck('Admin/User/viewAuth',session(C('ADMIN_INFO'))['id'])): ?><a class="blue" href="<?php echo U('User/viewAuth',array('id'=>$vo['id']));?>"
                                                   title="查看资料" target="_blank">
                                                    <i class="icon-zoom-in bigger-130"></i>
                                                </a><?php endif; ?>

                                            <?php if(authCheck('Admin/User/resetRate',session(C('ADMIN_INFO'))['id'])): ?><a class="green resetRate" href="#" title="调整额度" dataid="<?php echo ($vo["id"]); ?>"
                                                   dataquota="<?php echo ($vo["quota"]); ?>" datarate="<?php echo ($vo["rate"]); ?>">
                                                    <i class="icon-pencil bigger-130"></i>
                                                </a><?php endif; ?>

                                            <?php if(authCheck('Admin/User/resetStatus',session(C('ADMIN_INFO'))['id'])): ?><a class="pink resetStatus" href="#" title="更改状态" dataid="<?php echo ($vo["id"]); ?>">
                                                    <i class="icon-edit bigger-130"></i>
                                                </a><?php endif; ?>

                                            <?php if(authCheck('Admin/User/printUser',session(C('ADMIN_INFO'))['id'])): ?><a class="yellow" href="<?php echo U('User/printUser',array('id'=>$vo['id']));?>" target="_blank" title="打印信息">
                                                    <i class="icon-print bigger-130"></i>
                                                </a><?php endif; ?>

                                            <?php if(authCheck('Admin/User/delUser',session(C('ADMIN_INFO'))['id'])): ?><a class="red delUser" href="#" title="删除" dataid="<?php echo ($vo["id"]); ?>">
                                                    <i class="icon-trash bigger-130"></i>
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
        $(".resetPass").on('click', function () {
            var uid = $(this).attr('dataid');
            layer.confirm('确定要重置会员密码？', {
                btn: ['确定', '取消']
            }, function () {
                $.ajax({
                    url: "<?php echo U('User/resetPass');?>",
                    type: 'post',
                    data: {
                        id: uid
                    },
                    success: function (data) {
                        if (!data.status) {
                            layer.msg("重置密码失败!");
                        } else {
                            layer.alert("密码重置成功,新密码:" + data.info);
                        }
                    }
                });
            });
        });
        $(".resetStatus").on('click', function () {
            var uid = $(this).attr('dataid');
            $(".resetStatusDiv form input[name='id']").val(uid);
            layer.open({
                type: 1,
                shade: false,
                title: false,
                content: $(".resetStatusDiv")
            });
        });
        $(".resetRate").on('click', function () {
            var uid = $(this).attr('dataid');
            var rate = $(this).attr('datarate');
            var quota = $(this).attr('dataquota');
            $(".resetRateDiv form input[name='id']").val(uid);
            $(".resetRateDiv form input[name='quota']").val(quota);
            $(".resetRateDiv form input[name='rate']").val(rate);
            layer.open({
                type: 1,
                shade: false,
                title: false,
                content: $(".resetRateDiv")
            });
        });
        $(".delUser").on('click', function () {
            var uid = $(this).attr('dataid');
            layer.confirm('确定要删除该会员吗？', {
                btn: ['确定', '取消']
            }, function () {
                $.ajax({
                    url: "<?php echo U('User/delUser');?>",
                    type: 'get',
                    data: {
                        id: uid
                    },
                    success: function (data) {
                        if (!data.status) {
                            layer.msg("删除失败!");
                        } else {
                            layer.msg("删除会员成功!");
                            location.reload();
                        }
                    }
                });
            });
        });
    });
    function changeStatus() {
        $(".resetStatusDiv form").ajaxSubmit({
            success: function (data) {
                if (!data.status) {
                    layer.msg(data.info);
                } else {
                    layer.msg("操作成功!");
                    $('.resetStatusDiv').attr('style', 'display:none');
                    location.reload();
                }
            }
        });
        return false;
    }

    function changeRate() {
        $(".resetRateDiv form").ajaxSubmit({
            success: function (data) {
                if (!data.status) {
                    layer.msg(data.info);
                } else {
                    layer.msg("操作成功!");
                    $('.resetRateDiv').attr('style', 'display:none');
                    location.reload();
                }
            }
        });
        return false;
    }


    jQuery(function ($) {
        var oTable1 = $('#sample-table-2').dataTable({
            "aoColumns": [
                {"bSortable": false},
                null, null, null, null, null, null, null,null,null,
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