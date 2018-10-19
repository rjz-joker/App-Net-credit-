<?php
namespace Admin\Controller;
use Think\Page;

class FeedController extends PublicController {

	//反馈信息列表
	public function index(){
        //将消息变为已读
        $d['is_read'] = 1;
        D('Feedback')->where('is_read=0')->save($d);

        $limits = 15;
        $Feed = D("Feedback");
        $count= $Feed->count();
        $Page = new Page($count,$limits);
        $show = $Page->show();
        $feed = $Feed->order('id Desc')->limit($Page->firstRow.','.$Page->listRows)->select();
        $this->assign("lists",$feed);
        $this->assign("page",$show);
        $this->display();
	}

	//删除信息
	public function del(){
	    $id = I('post.id');
		if(!$id)    $this->error("参数错误!");
        $Feed = D("Feedback");
        $where['id']=$id;
		$info = $Feed->where($where)->find();
		$status=$Feed->where($where)->delete();
		if(!$status)   $this->error("删除失败!");
        add_log(getAdminId(),CONTROLLER_NAME.'/'.ACTION_NAME,'删除反馈信息:手机：'.$info['mobile'].'反馈内容:'.$info['content']);
		$this->success("删除成功!");
	}


}