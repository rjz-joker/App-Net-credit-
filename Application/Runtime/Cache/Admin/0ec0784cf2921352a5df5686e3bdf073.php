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
<script src="/Public/js/jquery.form.js"></script>
<script src="/Public/js/jquery-1.7.2.min.js"></script>
<style>
    .btn {
        -moz-user-select: none;
        background-image: none;
        border: 1px solid transparent;
        border-radius: 4px;
        cursor: pointer;
        display: inline-block;
        font-size: 14px;
        font-weight: normal;
        line-height: 1.42857;
        margin-bottom: 0;
        padding: 6px 12px;
        text-align: center;
        vertical-align: middle;
        white-space: nowrap;
    }

    .btn-success {
        background-color: #5cb85c;
        border-color: #4cae4c;
        color: #ffffff;
    }
</style>

<div id="page-wrapper">

    <div class="row">
        <div class="col-md-6">
            <?php if(authCheck('Admin/Post/add',session(C('ADMIN_INFO'))['id'])): ?><a href="<?php echo U('Post/add');?>" class="btn btn-success">添加文章</a><?php endif; ?>
        </div>

        <table class="layui-table" lay-skin="line">
            <thead>
            <tr>
                <th>编号</th>
                <th>标题</th>
                <!--<th>类型</th>-->
                <th>发布时间</th>
                <th>分类</th>
                <td>状态</td>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
            <?php if(is_array($model)): foreach($model as $key=>$v): ?><tr>
                    <td><?php echo ($v["id"]); ?></td>
                    <td><?php echo ($v["title"]); ?></td>
                    <!--<td>-->
                    <!--<?php if($v["type"] == 1): ?><span class="label label-success">普通</span>-->
                    <!--<?php elseif($v["type"] == 2): ?><span class="label label-info">置顶</span>-->
                    <!--<?php elseif($v["type"] == 3): ?><span class="label label-primary">热门</span>-->
                    <!--<?php elseif($v["type"] == 4): ?><span class="label label-warning">推荐</span>-->
                    <!--<?php endif; ?>-->
                    <!--</td>-->
                    <td><?php echo (date("Y/m/d H:i:s",$v["time"])); ?></td>
                    <td><?php echo ($v["category_title"]); ?></td>
                    <td>
                        <?php if($v["status"] == 1): ?>发布
                            <?php else: ?>
                            <span style="color:red">未发布</span><?php endif; ?>
                    </td>

                    <td>
                        <?php if(authCheck('Admin/Post/update',session(C('ADMIN_INFO'))['id'])): ?><a href="<?php echo U('Post/update',array('id'=>$v['id']));?>">编辑</a> |<?php endif; ?>

                        <?php if(authCheck('Admin/Post/delete',session(C('ADMIN_INFO'))['id'])): ?><a href="<?php echo U('Post/delete',array('id'=>$v['id']));?>" style="color:red;"
                               onclick="javascript:return del('您真的确定要删除吗？\n\n删除后将不能恢复!');">删除</a><?php endif; ?>
                    </td>
                </tr><?php endforeach; endif; ?>
            </tbody>
        </table>
        <div class="clearfix"></div>
        <div id="show_page">
            <?php echo ($page); ?>
        </div>


    </div>
</div>
<script>
    function del(msg) {
//    var msg = "您真的确定要删除吗？\n\n删除后将不能恢复!请确认！";
        if (confirm(msg) == true) {
            return true;
        } else {
            return false;
        }
    }

    jQuery(document).ready(function () {
        //高亮当前选中的导航
        var myNav = $(".side-nav a");
        for (var i = 0; i < myNav.length; i++) {
            var links = myNav.eq(i).attr("href");
            var myURL = document.URL;
            var durl = /http:\/\/([^\/]+)\//i;
            domain = myURL.match(durl);
            var result = myURL.replace("http://" + domain[1], "");
            if (links == result) {
                myNav.eq(i).parents(".dropdown").addClass("open");
            }
        }
    });


</script>
</body>
</html>