<?php

namespace Admin\Controller;

use Think\Page;

class GroupController extends PublicController
{

    //权限组列表
    public function index()
    {
        $limits = 30;
        $feed_model = D("think_auth_group");
        $count = $feed_model->count();
        $Page = new Page($count, $limits);
        $show = $Page->show();
        $feed = $feed_model->limit($Page->firstRow . ',' . $Page->listRows)->select();
        $this->assign("lists", $feed);
        $this->assign("page", $show);
        $this->display();
    }

    //添加权限组
    public function add()
    {
        if (IS_POST) {
            $data['title'] = I('post.title');
            if (!$data['title']) {
                $this->error('权限组名不能为空');
            }

            $where['title'] = $data['title'];
            $info = D('think_auth_group')->where($where)->find();
            if ($info) {
                $this->error('已存在的组名！请重填。');
            }

            $status = D('think_auth_group')->add($data);
            if ($status) {
                add_log(getAdminId(),CONTROLLER_NAME.'/'.ACTION_NAME,'添加权限组'.$data['title']);
                $this->success('添加成功');
            } else {
                $this->error('添加失败');
            }

        } else {
            $this->display();
        }

    }

    //编辑权限组
    public function edit()
    {
        if (IS_POST) {
            $id = I('get.id');
            $data['title'] = I('post.title');
            $status = D('think_auth_group')->where("id=$id")->save($data);
            if ($status) {
                add_log(getAdminId(),CONTROLLER_NAME.'/'.ACTION_NAME,'编辑权限组名称为:'.$data['title'].'id'.$id);
                $this->success('修改成功');
            } else {
                $this->error('修改失败');
            }

        } else {
            $id = I('get.id');
            $group = D('think_auth_group')->where("id=$id")->find();
            $this->assign('group', $group);
            $this->display();
        }
    }


    //删除权限组
    public function del()
    {
        $id = I('post.id');
        if (!$id) {
            $this->error("参数错误!");
        }

        $status = D("think_auth_group")->where(array('id' => $id))->delete();
        if (!$status) {
            $this->error("删除失败!");
        }
        $title=D("think_auth_group")->where(array('id' => $id))->getField('title');
        add_log(getAdminId(),CONTROLLER_NAME.'/'.ACTION_NAME,'删除权限组id:'.$id.'名称:'.$title);
        $this->success("删除成功!");
    }


    /**
     * 分配权限
     */
    public function rule()
    {
        if (IS_POST) {
            $data = I('post.');
            $map = array(
                'id' => $data['id']
            );
            $data['rules'] = implode(',', $data['rules']);
            $result = D('think_auth_group')->where($map)->save($data);
            if ($result) {
                add_log(getAdminId(),CONTROLLER_NAME.'/'.ACTION_NAME,'分配了组id'.$data['id'].'的权限');
                $this->success('操作成功', U('Group/index'));
            } else {
                $this->error('操作失败', U('Group/index'));
            }
        } else {
            $id = I('get.id');
            // 获取用户组数据
            $group_data = M('think_auth_group')->where(array('id' => $id))->find();
            $group_data['rules'] = explode(',', $group_data['rules']);
            // 获取规则数据
            $rule_data = D('think_auth_rule')->order('sort')->select();
            $rule_data = createTree($rule_data);
            $assign = array(
                'group_data' => $group_data,
                'rule_data' => $rule_data,
                'auth_ids_arr' => $group_data['rules'],
                'id' => $id
            );

            $this->assign($assign);
            $this->display();
        }

    }


}