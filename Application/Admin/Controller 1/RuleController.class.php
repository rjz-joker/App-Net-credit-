<?php

namespace Admin\Controller;

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/4/27
 * Time: 8:40
 */

class RuleController extends PublicController {

    public function index(){

        if(IS_POST){

        }else{
            $rules = D('think_auth_rule')->order("id asc")->select();
            $rules=createTree($rules);
            $this->assign('lists',$rules);
            $this->display();
        }

    }

    /**
     * 添加权限
     */
    public function add(){
        if(IS_POST){
            $data=I('post.');

            $result=D('think_auth_rule')->add($data);
            if ($result) {
                add_log(getAdminId(),CONTROLLER_NAME.'/'.ACTION_NAME,'添加了权限id'.$result);
                $this->success('添加成功',U('Rule/index'));
            }else{
                $this->error('添加失败');
            }
        }else{
            $rules=D('think_auth_rule')->order('sort')->select();
            $rules=createTree($rules);
            $id=I('get.id');
            $this->assign('lists',$rules);
            $this->assign('rid',$id);
            $this->display();
        }

    }

    /**
     * 修改权限
     */
    public function edit(){
        if(IS_POST){
            $data=I('post.');

            $map=array(
                'id'=>I('get.id')
            );
            $result=D('think_auth_rule')->where($map)->save($data);
            if ($result) {
                add_log(getAdminId(),CONTROLLER_NAME.'/'.ACTION_NAME,'修改了权限id'.I('get.id'));
                $this->success('修改成功',U('Rule/index'));
            }else{
                $this->error('修改失败');
            }
        }else{
            $id = I('get.id');
            $rules=D('think_auth_rule')->order('sort')->select();
            $rules=createTree($rules);
            $rule=D('think_auth_rule')->where("id=$id")->find();
            $this->assign('rule',$rule);
            $this->assign('lists',$rules);
            $this->display();
        }

    }

    /**
     * 删除权限
     */
    public function del(){
        $id=I('post.id');
        $map=array(
            'id'=>$id
        );
        $result2=D('think_auth_rule')->where(array('pid'=>$id))->find();
        if($result2){
            $this->error('请先删除子权限');
        }else{
            $result=D('think_auth_rule')->where($map)->delete();
            if($result){
                add_log(getAdminId(),CONTROLLER_NAME.'/'.ACTION_NAME,'删除了权限id:'.$id);
                $this->success('删除成功');
            }
        }

    }




}