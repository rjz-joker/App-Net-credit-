<?php
namespace Admin\Controller;
use Think\Page;

class MenuController extends PublicController {

    /*
     *  菜单管理
     * */
    public function index(){
        $limits = 30;
        $menu_model = D("Menu");
        if(IS_POST){
            //更新排序
            $sort = I("post.sort");
            foreach($sort as $key => $val){
                $menu_model->where(array('id'=>$key))->save(array('sort'=>$val));
            }
        }
        $count= $menu_model->count();
        $Page = new Page($count,$limits);
        $show = $Page->show();
        $menu = $menu_model->where('status=1')->order("pid,sort")->limit($Page->firstRow.','.$Page->listRows)->select();
        $menu =createTree($menu);
        $this->assign("lists",$menu);
        $this->assign("page",$show);
        $this->display();
    }

    /*
     *  添加菜单
     * */
    public function add(){
        $menu_model = D("Menu");
        if(IS_POST){

            $pid = I("post.pid",0,'intval');
            $title = I("post.title",'','trim');
            $href = I("post.href",'','trim');
            $sort = I("post.sort",99,'intval');
            $status = 1;
            $icon = I("post.icon",'');
            if(!$title){
                $this->error("菜单名称不能为空!");
            }
            $arr = array(
                'pid' => $pid,
                'title' => $title,
                'sort' => $sort,
                'status' => $status,
                'icon'  => $icon,
                'href' => $href
            );
            $status = $menu_model->add($arr);
            if(!$status){
                $this->error("操作失败,请重试!",U('Menu/index'));
            }
            add_log(getAdminId(),CONTROLLER_NAME.'/'.ACTION_NAME,'添加了菜单id为：'.$status);
            $this->success("菜单添加成功!",U('Menu/index'));
        }else{
            $menu = $menu_model->where('status=1')->order("pid,sort")->select();
            $menu =createTree($menu);
            $this->assign("lists",$menu);
            $this->display();
        }

    }

    /*
     *  删除菜单
     * */
    public function del(){
        $id=I("post.id");
        if(!$id){
            $this->error("参数错误!");
        }
        $status=M("menu")->where(array('pid'=>$id))->find();
        if($status){
            $this->error("删除失败,该菜单下有子菜单!");
        }else{
            if(M("menu")->where(array('id'=>$id))->delete()){
                $this->success("删除菜单成功!");
            }

        }

    }

    /*
     *  编辑菜单
     * */
    public function edit(){
        $id=I("get.id",0,'intval');
        if(!$id){
            $this->error("参数错误!");
        }
        $menu_model = D("Menu");
        if(IS_POST){
            $pid = I("post.pid",0,'intval');
            $title = I("post.title",'','trim');
            $href = I("post.href",'','trim');
            $sort = I("post.sort",99,'intval');
            $status = I("post.status",1,'intval');
            $noauth = I("post.noauth",0,'intval');
            $icon = I("post.icon",'');
            if(!$title){
                $this->error("菜单名称不能为空!");
            }
            $arr = array(
                'pid' => $pid,
                'title' => $title,
                'sort' => $sort,
                'status' => $status,
                'noauth' => $noauth,
                'icon'  => $icon,
                'href' => $href
            );
            $status = $menu_model->where(array('id'=>$id))->save($arr);
            if(!$status){
                $this->error("操作失败,请重试!");
            }
            $this->success("菜单编辑成功!",U('Menu/index'));
            exit;
        }
        $menu = $menu_model->order("pid,sort")->select();
        $this->assign("lists",$menu);
        $info=$menu_model->where(array('id'=>$id))->find();
        if(!$info){
            $this->error("不存在该菜单!");
        }
        $this->assign('data',$info);
        $this->display();
    }






}