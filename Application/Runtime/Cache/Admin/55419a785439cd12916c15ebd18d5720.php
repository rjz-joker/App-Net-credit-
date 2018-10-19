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

<body>

<div class="page-content">

    <div class="row">
        <div class="col-xs-12">
            <div class="row">
                <div class="col-xs-12">
                    <div class="table-header">
                        权限列表
                        <?php if(authCheck('Admin/Rule/add',session(C('ADMIN_INFO'))['id'])): ?><a href="<?php echo U('Rule/add');?>">
                                <span class="btn btn-success btn-sm tooltip-success" data-rel="tooltip"
                                      data-placement="left">添加权限</span>
                            </a><?php endif; ?>
                    </div>

                    <div class="table-responsive">
                        <table id="sample-table-2" class="table table-striped table-bordered table-hover">
                            <thead>
                            <tr>
                                <th>权限名</th>
                                <th>链接</th>
                                <th>级别</th>
                                <th>操作</th>
                            </tr>
                            </thead>

                            <tbody>
                            <!--数据start-->
                            <?php if(is_array($lists)): $i = 0; $__LIST__ = $lists;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
                                    <td>
                                        <span style="display:block;text-indent: <?php echo ($vo['level']*20); ?>px;"><?php if($vo["pid"] != 0): ?>└─<?php endif; echo ($vo["title"]); ?></span>
                                    </td>

                                    <td>
                                        <?php echo ($vo["name"]); ?>
                                    </td>
                                    <td>
                                        <?php if($vo["level"] == 1): ?><span style="color: darkred">模块</span><?php endif; ?>
                                        <?php if($vo["level"] == 2): ?><span style="color: #00a0e9">控制器</span><?php endif; ?>
                                        <?php if($vo["level"] == 3): ?><span style="color:forestgreen">方法</span><?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="visible-md visible-lg hidden-sm hidden-xs action-buttons">
                                            <?php if(authCheck('Admin/Rule/add',session(C('ADMIN_INFO'))['id'])): ?><a class="pink" href="<?php echo U('Rule/add',array('id'=>$vo['id']));?>"
                                                   title="添加子分类">
                                                    <i class="icon-ok bigger-130">添加子分类</i>
                                                </a><?php endif; ?>

                                            <?php if(authCheck('Admin/Rule/edit',session(C('ADMIN_INFO'))['id'])): ?><a class="green" href="<?php echo U('Rule/edit',array('id'=>$vo['id']));?>"
                                                   title="修改">
                                                    <i class="icon-pencil bigger-130">修改</i>
                                                </a><?php endif; ?>

                                            <?php if(authCheck('Admin/Rule/del',session(C('ADMIN_INFO'))['id'])): ?><a class="red" onclick="delMenu('<?php echo ($vo["id"]); ?>','<?php echo ($vo["title"]); ?>')" title="删除">
                                                    <i class="icon-trash bigger-130">删除</i>
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

    function delMenu(id, title) {
        layer.confirm('确定要删除权限[' + title + ']？', {
            btn: ['确定', '取消']
        }, function () {
            $.post("<?php echo U('Rule/del');?>", {'id': id}, function (res) {
                layer.alert(res.info);
                location.reload();
            });

        }, function () {

        });
    }
    jQuery(function ($) {
//        var oTable1 = $('#sample-table-2').dataTable({
//            "aoColumns": [
//                {"bSortable": false},
//                null, null,
//                {"bSortable": false}
//            ]
//        });




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

</body>
</html>