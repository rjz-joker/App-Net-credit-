<?php
namespace Home\Controller;
/*
	单页内容
 */
class PageController extends CommonController{

	//我要反馈
	public function feedback(){
		if(IS_POST){
			$mobile = I("post.mobile");
			$content = I("post.content");
			$feed_model = D("Feedback");
			if(!isMobileNum($mobile)){
				$this->error("手机号码不符合规范!");
			}
			if(strlen($content) == 0){
				$this->error("反馈内容不能为空!");
			}
			if(strlen($content) > 500){
				$this->error("反馈内容不能超过500字!");
			}
			$status = $feed_model->add(array('mobile'=>$mobile,'content'=>$content,'create_time'=>time(),'is_read'=>0));
			if(!$status){
				$this->error("提交反馈失败,请重试!");
			}
			$this->success("操作成功!");
		}
		$this->display();
	}

}