<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="stylesheet" href="/Public/plugins/layui/css/layui.css" media="all"/>
    <link rel="stylesheet" href="/Public/css/admin/global.css" media="all">
    <script type="text/javascript" src="/Public/plugins/layui/layui.js"></script>
    <script src="/Public/js/jquery-1.7.2.min.js"></script>
</head>
<body>


<div class="layui-tab">
    <ul class="layui-tab-title">
        <li class="layui-this">网站设置</li>
    </ul>
    <div class="layui-tab-content">
        <div class="layui-tab-item layui-show">
            <!--网站设置-->
            <form onsubmit="return AjaxSubmit(this);" action="<?php echo U('Setting/save',array('action'=>'site'));?>"
                  class="layui-form" method="post">
                <div class="layui-form-item">
                    <label class="layui-form-label">网站名称</label>
                    <div class="layui-input-block">
                        <input type="text" name="site_name" value="<?php echo C('site_name');?>" lay-verify="required"
                               placeholder="请输入网站名称" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">站点地址</label>
                    <div class="layui-input-block">
                        <input type="text" name="site_url" value="<?php echo C('site_url');?>" lay-verify="required"
                               placeholder="请输入网站完整地址(如:http://www.baidu.cn/)" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">网站标题</label>
                    <div class="layui-input-block">
                        <input type="text" name="site_title" value="<?php echo C('site_title');?>" lay-verify="required"
                               placeholder="请输入网站标题" class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">网站LOGO</label>
                    <div class="layui-input-block">
                        <input type="text" name="site_logo" value="<?php echo C('site_logo');?>" placeholder="请上传文件"
                               class="layui-input" onclick="uploadFile(this);">
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">推荐码开关</label>
                    <div class="layui-input-block">
                        <input type="radio" name="site_erwei" style="display: inline;" value="1"
                        <?php if(C('site_erwei') == 1): ?>checked="checked"<?php endif; ?>
                        >开　
                        <input type="radio" name="site_erwei" style="display: inline;" value="0"
                        <?php if(C('site_erwei') == 0): ?>checked="checked"<?php endif; ?>
                        >关
                    </div>
                </div>

                <!--<div class="layui-form-item">-->
                    <!--<label class="layui-form-label">接口商家</label>-->
                    <!--<div class="layui-input-block">-->
                        <!--<input type="radio" name="site_jiekou" style="display: inline;" value="1"-->
                        <!--<?php if(C('site_jiekou') == 1): ?>checked="checked"<?php endif; ?>-->
                        <!--&gt;寻程　-->
                        <!--<input type="radio" name="site_jiekou" style="display: inline;" value="2"-->
                        <!--<?php if(C('site_erwei') == 2): ?>checked="checked"<?php endif; ?>-->
                        <!--&gt;立木-->
                    <!--</div>-->
                <!--</div>-->

                <!--<div class="layui-form-item">-->
                    <!--<label class="layui-form-label">使用方式</label>-->
                    <!--<div class="layui-input-block">-->
                        <!--<input type="radio" name="site_use" style="display: inline;" value="1"-->
                        <!--<?php if(C('site_use') == 1): ?>checked="checked"<?php endif; ?>-->
                        <!--&gt;网页端　-->
                        <!--<input type="radio" name="site_use" style="display: inline;" value="2"-->
                        <!--<?php if(C('site_use') == 2): ?>checked="checked"<?php endif; ?>-->
                        <!--&gt;微信端-->
                    <!--</div>-->
                <!--</div>-->

                <div class="layui-form-item">
                    <label class="layui-form-label">关键字</label>
                    <div class="layui-input-block">
                        <input type="text" name="site_keywords" value="<?php echo C('site_keywords');?>" placeholder="请输入网站关键字"
                               class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item layui-form-text">
                    <label class="layui-form-label">网站描述</label>
                    <div class="layui-input-block">
                        <textarea name="site_description" placeholder="不支持JS及HTML,仅作为SEO描述文字" class="layui-textarea"><?php echo C('site_description');?></textarea>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">备案信息</label>
                    <div class="layui-input-inline">
                        <input type="text" name="site_icp" value="<?php echo C('site_icp');?>" placeholder="请输入备案信息"
                               class="layui-input">
                    </div>
                </div>
                <div class="layui-form-item layui-form-text">
                    <label class="layui-form-label">统计代码</label>
                    <div class="layui-input-block">
                        <textarea name="site_code" placeholder="支持任意JS,HTML代码.不光可以填入统计代码,还可以添加网站漂浮客服代码等等"
                                  class="layui-textarea"><?php echo C('site_code');?></textarea>
                    </div>
                </div>
                <div class="layui-form-item layui-form-text">
                    <label class="layui-form-label">版权信息</label>
                    <div class="layui-input-block">
                        <textarea name="site_copyright" placeholder="支持同上格式内容" class="layui-textarea"><?php echo C('site_copyright');?></textarea>
                    </div>
                </div>
                <div class="layui-form-item">
                    <div class="layui-input-block">
                        <?php if(authCheck('Admin/Setting/save',session(C('ADMIN_INFO'))['id'])): ?><button class="layui-btn" lay-submit="">修改信息</button><?php endif; ?>
                        <button type="reset" class="layui-btn layui-btn-primary">重置</button>
                    </div>
                </div>
            </form>
            <!--网站设置-->
        </div>
        <div class="layui-tab-item">
            <!--主题设置-->
            <form onsubmit="return AjaxSubmit(this);" action="<?php echo U('Admin/Setting/save',array('action'=>'skin'));?>"
                  class="layui-form" method="post">
                <div class="layui-form-item">
                    <label class="layui-form-label">前台主题</label>
                    <div class="layui-input-inline">
                        <select name="skin[home]" lay-filter="aihao">
                            <?php if(is_array($homeskin)): foreach($homeskin as $key=>$vo): if($vo != 'mobile'): ?><option value="<?php echo ($vo); ?>"
                                    <?php if( C('HOME_THEME') == $vo ): ?>selected=""<?php endif; ?>
                                    ><?php echo ($vo); ?></option><?php endif; endforeach; endif; ?>
                        </select>
                    </div>
                </div>
                <div class="layui-form-item">
                    <label class="layui-form-label">后台主题</label>
                    <div class="layui-input-inline">
                        <select name="skin[admin]" lay-filter="aihao">
                            <?php if(is_array($adminskin)): foreach($adminskin as $key=>$vo): ?><option value="<?php echo ($vo); ?>"
                                <?php if( C('DEFAULT_THEME') == $vo ): ?>selected=""<?php endif; ?>
                                ><?php echo ($vo); ?></option><?php endforeach; endif; ?>
                        </select>
                    </div>
                </div>
                <div class="layui-form-item">
                    <div class="layui-input-block">
                        <?php if(authCheck('Admin/Setting/save',session(C('ADMIN_INFO'))['id'])): ?><button class="layui-btn" lay-submit="">立即提交</button><?php endif; ?>
                        <button type="reset" class="layui-btn layui-btn-primary">重置</button>
                    </div>
                </div>
                <blockquote class="layui-elem-quote">
                    如未开启调试模式,请在设置新主题后清除缓存.<br>
                    其他渠道获取的主题方案请放置在Data/Skin/Home(后台为Admin)/下 <br>
                    不建议启用新主题后删除自带主题防止主题不适应出错.
                </blockquote>
            </form>
            <!--主题设置-->
        </div>
    </div>
</div>

<div style="display: none" id="upload_file">
    <input type="file" name="file" id="sitelogo"/>
</div>

<script src="/Public/js/jquery.form.js"></script>
<script>
    var upload_obj;

    layui.use('form', function () {
        var form = layui.form();
        form.verify();
    });
    layui.use('element', function () {
        var $ = layui.jquery, element = layui.element();
    });
    layui.use('upload', function () {
        layui.upload({
            url: '<?php echo U("Public/Upload/index");?>'
            , elem: '#sitelogo'
            , method: 'post'
            , success: function (res, obj) {
                if (res.status == 1) {
                    var info = res.info;
                    var fileurl = info[0].url;
                    $(upload_obj).val(fileurl);
                    layer.closeAll();
                } else {
                    layer.msg(res.info);
                }
            }
        });
    });
    function uploadFile(obj) {
        upload_obj = obj;
        layer.open({
            type: 1,
            shade: false,
            title: false,
            content: $('#upload_file')
        });
    }
    function AjaxSubmit(obj) {
        //拦截表单提交,以AJAX方式提交
        $(obj).ajaxSubmit({
            success: function (data, state) {
                if (state != 'success') {
                    layer.alert('页面提交出错,请重试!');
                } else if (data.status == 1) {
                    layer.alert('保存成功!');
                } else {
                    layer.alert(data.info);
                }
            }
        });
        return false;
    }
</script>



</body>
</html>