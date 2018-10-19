<?php
namespace Admin\Controller;
use Think\Page;

/**
 * 文章管理
 */
class PostController extends PublicController
{
    /**
     * 文章列表
     * @return [type] [description]
     */
    public function index($key="")
    {
        if($key === ""){
            $model = D('Post'); 
        }else{
            $where['post.title'] = array('like',"%$key%");
            $where['member.username'] = array('like',"%$key%");
            $where['category.title'] = array('like',"%$key%");
            $where['_logic'] = 'or';
            $model = D('Post')->where($where); 
        } 
        
        $count  = $model->where($where)->count();// 查询满足要求的总记录数
        $Page = new Page($count,15);// 实例化分页类 传入总记录数和每页显示的记录数(25)
        $allpage = intval(ceil($count / 15));
        $nowpage = I('get.p', 1, 'intval');
        $show = $Page->show();// 分页显示输出
        $post = $model->limit($Page->firstRow.','.$Page->listRows)->where($where)->order('id DESC')->select();

        foreach ($post as $key=>$value) {
            $category_title = D('Category')->where("id=$value[cate_id]")->field('title')->find();
            $post[$key]['category_title'] =$category_title['title'];
        }

        $this->assign('model', $post);
        $this->assign('page',$show);
        $this->assign('allpage', $allpage);
        $this->assign('nowpage', $nowpage);
        $this->display();     
    }
    /**
     * 添加文章
     */
    public function add()
    {
        //默认显示添加表单
        if (!IS_POST) {
        	$this->assign("category",getSortedCategory(M('category')->select()));
            $this->display();
        }
        if (IS_POST) {
            //如果用户提交数据
            $model = D("Post");
            if (!$model->create()) {
                // 如果创建失败 表示验证没有通过 输出错误提示信息
                $this->error($model->getError());
                exit();
            } else {
                $model->time=time();
                if ($model->add()) {
                    add_log(getAdminId(),CONTROLLER_NAME.'/'.ACTION_NAME,'添加了文章');
                    $this->success("添加成功", U('post/index'));
                } else {
                    $this->error("添加失败");
                }
            }
        }
    }
    /**
     * 更新文章信息
     * @param  [type] $id [文章ID]
     * @return [type]     [description]
     */
    public function update()
    {
    		$id = I('get.id','','intval');
        //默认显示添加表单
        if (!IS_POST) {
            $model = M('post')->where("id=$id")->find();
            $this->assign("category",getSortedCategory(M('category')->select()));
            $this->assign('post',$model);
            $this->display();
        }
        if (IS_POST) {
            $model = D("Post");
            if (!$model->create()) {
                $this->error($model->getError());
            }else{
                if ($model->save()) {
                    add_log(getAdminId(),CONTROLLER_NAME.'/'.ACTION_NAME,'修改了文章id:'.$id);
                    $this->success("更新成功", U('post/index'));
                } else {
                    $this->error("更新失败");
                }        
            }
        }
    }
    /**
     * 删除文章
     * @param  [type] $id [description]
     * @return [type]     [description]
     */
    public function delete($id)
    {
    		$id = intval($id);
        $model = M('post');
        $result = $model->where("id= %d",$id)->delete();
        if($result){
            $this->success("删除成功", U('post/index'));
        }else{
            $this->error("删除失败");
        }
    }
	public function push($id) {//post到前台
		$id = intval($id);
		if (IS_GET) {
			$status = M('post') -> where("id= %d",$id) -> getField('status');
			if ($status === '0') {
				$data['status'] = 1;
			} else {
				$data['status'] = 0;
			}
			$result = M('post') -> where("id= %d",$id) -> save($data);
			if ($result && $data['status'] === 1) {
				$this -> success("发布成功", U('post/index'));
			} elseif ($result && $data['status'] === 0) {
				$this -> success("撤销成功", U('post/index'));
			} else {
				$this -> error("操作失败");
			}
		} else {
			pass;

		}
	}
}
