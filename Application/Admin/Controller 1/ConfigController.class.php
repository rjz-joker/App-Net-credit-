<?php
namespace Admin\Controller;


class ConfigController extends PublicController {
    /**
     * 分类列表
     * @return [type] [description]
     */
    public function index()
    {
        $model = M('setting');
        $setting = $model->order('id ASC')->select();
        $this->assign('lists', $setting);
        $this->display();
    }

    /**
     * 添加分类
     */
    public function add()
    {
        if (IS_POST) {
            //如果用户提交数据
            $model = D("Setting");
            add_log(getAdminId(),CONTROLLER_NAME.'/'.ACTION_NAME,'添加扩展配置');
            if (!$model->create()) {
                // 如果创建失败 表示验证没有通过 输出错误提示信息
                $this->error($model->getError());
            } else {

                if ($model->add()) {
                    $this->success("添加配置成功", U('Config/index'));
                } else {
                    $this->error("添加配置失败");
                }
            }
        }else{
            $this->display();
        }

    }
    /**
     * 更新分类信息
     * @param  [type] $id [分类ID]
     * @return [type]     [description]
     */
    public function edit()
    {
        if (IS_POST) {
            $model = D("Setting");
            add_log(getAdminId(),CONTROLLER_NAME.'/'.ACTION_NAME,'修改扩展配置');
            if (!$model->create()) {
                $this->error($model->getError());
            }else{
                if ($model->save()) {
                    $this->success("修改配置成功", U('Config/index'));
                } else {
                    $this->error("修改配置失败");
                }
            }
        }else{
            $model = M('setting')->find(I('id',"addslashes"));
            $this->assign('list',$model);
            $this->display();
        }
    }

    /**
     * 删除分类
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function del($id)
    {
        $id = intval($id);
        $model = M('setting');
        $info = $model->where(array('id'=>$id))->find();
        add_log(getAdminId(),CONTROLLER_NAME.'/'.ACTION_NAME,'删除配置id'.$id.'描述：'.$info['description']);
        //验证通过
        $result = $model->delete($id);
        if($result){
            $this->success("字段删除成功", U('Config/index'));
        }else{
            $this->error("字段删除失败");
        }
    }


}