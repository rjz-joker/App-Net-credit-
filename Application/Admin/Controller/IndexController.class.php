<?php
namespace Admin\Controller;
use Think\Auth;

header("Content-type: text/html; charset=utf-8");
class IndexController extends PublicController {
    /*
     *  后台主页
     * */
    public function index(){

        $menus = $this->getMenu();
        #权限控制
        $arr = session(C('ADMIN_INFO'));
        $auth = new Auth();
        if($arr['username'] != 'admin'){        //admin管理员无视所有权限
            foreach ($menus as $key=>$val) {
                $result = $auth->check(MODULE_NAME.'/'.$val['href'],$arr['id']);    #顶级菜单
                if(!$result){  #证明没有权限  T掉
                    unset($menus[$key]);
                }

                foreach ($val['children'] as $k=>$v) {
                    $v['href']=mb_substr($v['href'],1,strrpos($v['href'],'.')-1);
                    $result1 = $auth->check($v['href'],$arr['id']);    #内层菜单
                    if(!$result1){  #证明没有权限  T掉
                        unset($menus[$key]['children'][$k]);
                    }
                }

            }
        }


        //轮询查询新消息
        if(IS_AJAX){
            $json['loan_num']= D('Loan')->where("is_read=0")->count();
            $json['user_num']= D('User')->where("is_new=0")->count();
            $json['feed_num']= D('Feedback')->where("is_read=0")->count();
            $json['count_num']= $json['loan_num']+$json['user_num']+$json['feed_num'];
            $n=I('post.n');
            if($n == 1){
                $json['n'] = 1;  //首次进入
            }
            $this->ajaxReturn($json);
        }

        $this->assign('menu',$menus);
        $this->display();
    }

    /*
     *  后台控制面板
     * */
    public function main(){
        $DB_PREFIX = C('DB_PREFIX');
        $where["is_read"]=0;
        $loan = D("Loan")
            ->join("LEFT JOIN {$DB_PREFIX}user on {$DB_PREFIX}loan.uid = {$DB_PREFIX}user.id")
            ->join("LEFT JOIN {$DB_PREFIX}auth_idcard on {$DB_PREFIX}loan.uid = {$DB_PREFIX}auth_idcard.uid")
            ->join("LEFT JOIN {$DB_PREFIX}auth_info on {$DB_PREFIX}loan.uid = {$DB_PREFIX}auth_info.uid")
            ->join("LEFT JOIN {$DB_PREFIX}auth_bank on {$DB_PREFIX}loan.uid = {$DB_PREFIX}auth_bank.uid")
            ->field("{$DB_PREFIX}user.*,{$DB_PREFIX}loan.*,{$DB_PREFIX}auth_idcard.name,{$DB_PREFIX}auth_bank.bank_num")
            ->where($where)
            ->order("{$DB_PREFIX}loan.id DESC")
            ->select();
        $this->assign("lists", $loan);
        $this->display();
    }

    /*
     *  清除缓存
     * */
    public function delcha(){
        delDirAndFile(RUNTIME_PATH);
        $this->success("清理缓存成功!",U('Index/index'),2);
    }

    /*
   *  生成当前用户权限内的菜单
   * */
    private function getMenu(){
        $menu_model = D("Menu");
        //获取菜单列表
        $menu = $menu_model->getMenu();
        return $menu;
    }




}