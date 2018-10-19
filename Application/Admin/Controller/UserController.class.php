<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/3/10 0010
 * Time: 20:35
 *  后台会员管理控制器
 */

namespace Admin\Controller;

use Think\Page;

header("content-Type: text/html; charset=Utf-8");

class UserController extends PublicController
{

    //会员列表
    public function index()
    {

        //将消息变为已读
        $d['is_new'] = 1;
        D('User')->where('is_new=0')->save($d);

        //导出数据
        if (isset($_GET['aliziExcel'])) {
            add_log(getAdminId(),CONTROLLER_NAME.'/'.ACTION_NAME,'导出了用户数据');
            $user_model = D("User");
            $DB_PREFIX = C('DB_PREFIX');
            $users = $user_model
                ->join("LEFT JOIN {$DB_PREFIX}auth_idcard on {$DB_PREFIX}user.id = {$DB_PREFIX}auth_idcard.uid")
                ->join("LEFT JOIN {$DB_PREFIX}auth_info on {$DB_PREFIX}user.id = {$DB_PREFIX}auth_info.uid")
                ->join("LEFT JOIN {$DB_PREFIX}auth_bank on {$DB_PREFIX}user.id = {$DB_PREFIX}auth_bank.uid")
                ->field("{$DB_PREFIX}auth_idcard.*,{$DB_PREFIX}auth_info.*,{$DB_PREFIX}user.*,{$DB_PREFIX}auth_bank.bank_num")
                ->select();


            foreach ($users as $key => $value) {
                foreach ($users[$key] as $k => $v) {

//                    if ($users[$key]['sex'] == "m") {
//                        $users[$key]['sex'] = '男';
//                    } elseif ($users[$key]['sex'] == "w") {
//                        $users[$key]['sex'] = '女';
//                    }

                    if (in_array($k, array('photo_face', 'more_money', 'uid', 'photo_back', 'photo', 'is_marray', 'is_credit', 'is_car', 'is_home', 'is_marry',
                        'password', 'cid', 'status'))) {
                        unset($users[$key][$k]);
                    }
                }
            }

            $title = array(
                'id' => '会员id',
                'name' => '姓名',
                'idcard' => '身份证号',
                'bank_num' => '银行卡号',
                'mobile' => '手机号',
                'quota' => '额度',
                'rate' => '日息',
                'live_city' => '居住城市',
                'live_address' => '详细地址',
                'live_time' => '居住时长',
               'work_industry' => '从事行业',
                'work_posts' => '工作岗位',
                'work_name' => '单位名称',
                'work_city' => '单位地址',
                'work_address' => '详细地址',
                'work_tel' => '单位电话',
                'month_salary' => '月收入',
                'people_name_1' => '亲属姓名',
                'people_tel_1' => '亲属电话',
                'people_name_2' => '同事或朋友姓名',
                'people_tel_2' => '同事或朋友电话',
                'age' => '年龄',
				'edu' => '文化程度',
				'is_hun' => '婚姻状况'
            );
            parent::aliziExcel($users, $title, date('Y-m-d'));
            exit;

        }

        $limits = 30;
        $user_model = D("User");
        $where = array('status' => '-1');

        $name = I('get.name');
        if ($name) {
            $where['name'] = array('like', "%$name%");
            $this->name = $name;
        }

        $mobile = I('get.mobile');
        if ($mobile) {
            $where['mobile'] = $mobile;
        }

        $status = I('get.status', '-2', 'intval');
        if ($status > 0) {
            $where['status'] = $status;
        }

        $this->where = $where;
        if (!$where['mobile'])
            unset($where['mobile']);
        if (!$where['name'])
            unset($where['name']);
        if ($where['status'] == '-1')
            unset($where['status']);

        $count = $user_model->where($where)->count();
        $Page = new Page($count, $limits);
        $show = $Page->show();

        //获取登录人信息
        $login_info = nl_get_adminuser();
        $login_info = D('Admin')->where("id=$login_info[id]")->find();
        //属于哪个权限组
        $group_access = D('think_auth_group_access')->where("uid=$login_info[id]")->select();

        foreach ($group_access as $key => $val) {
            if ($val['group_id'] == 2) {       //说明是业务员
                if ($login_info['mobile']) {
                    $where['north_user.recommend'] = $login_info['recommend'];
                    break;
                }
            } elseif ($val['group_id'] == 3) {//说明是审核
                if ($login_info['yids']) {
                    $yids = explode(",", $login_info['yids']);
                    foreach ($yids as $k => $v) {
                        $mobiles[] = D('Admin')->field("recommend")->where("id=$v")->find();
                    }
                    $recommends = '';//存储所有用户recommend
                    foreach ($mobiles as $k1 => $v1) {
                        $recommends = $recommends . $v1['recommend'] . ',';
                    }
                    if ($recommends && ($recommends != ',')) {
                        $recommends = substr($recommends, 0, -1);
                        $where['north_user.recommend'] = array('in', $recommends);
                    }
                    break;
                }
            }
        }

        $DB_PREFIX = C('DB_PREFIX');
        $user = $user_model
            ->join("LEFT JOIN {$DB_PREFIX}auth_idcard on {$DB_PREFIX}user.id = {$DB_PREFIX}auth_idcard.uid")
            ->field("{$DB_PREFIX}user.*,{$DB_PREFIX}auth_idcard.name")
            ->where($where)
            ->order('id Desc')
            //->limit($Page->firstRow . ',' . $Page->listRows)
            ->select();

        $loan_model = D("Loan");
        for ($i = 0; $i < count($user); $i++) {
            $n = $loan_model->where(array('uid' => $user[$i]['id'], 'borrow_status' => 1))->count();
            $user[$i]['borrow'] = $n;
            $n = $loan_model->where(array('uid' => $user[$i]['id'], 'borrow_status' => 2))->count();
            $user[$i]['fborrow'] = $n;
            $n = $loan_model->where(array('uid' => $user[$i]['id'], 'payment_status' => 1))->count();
            $user[$i]['payment'] = $n;
        }

        $this->assign("lists", $user);
        $this->assign("page", $show);
        $this->display();
    }

    //重置密码
    public function resetPass($id = 0)
    {
        if (!$id) {
            $this->error("参数错误");
        }
        $user_model = D("User");
        $newPass = getNumStr(6);
        $status = $user_model->where("id=$id")->save(array('password' => getPass2User($newPass)));
        if (!$status) {
            $this->error("操作失败");
        }
        add_log(getAdminId(),CONTROLLER_NAME.'/'.ACTION_NAME,'重置用户密码,用户id:'.$id);
        $this->success($newPass);
    }

    //修改状态
    function resetStatus($id = 0, $status = 1)
    {
        if (!$id) {
            $this->error("参数错误");
        }
        $user_model = D("User");
        $status = $user_model->where("id=$id")->save(array('status' => $status));
        if (!$status) {
            $this->error("操作失败");
        }
        add_log(getAdminId(),CONTROLLER_NAME.'/'.ACTION_NAME,'修改用户状态:'.$status);
        $this->success("操作成功");
    }

    //删除会员
    function delUser($id = 0)
    {
        if (!$id) {
            $this->error("参数错误");
        }

        $idcard = D("auth_idcard")->field('idcard')->where(array('uid' => $id))->find();
        if ($idcard) {

            D("zmxy")->where('carid=' . $idcard['idcard'])->delete();

        }
        D("auth_idcard")->where("uid=$id")->delete();
        D("auth_bank")->where("uid=$id")->delete();
        D("auth_mobile")->where("uid=$id")->delete();
        $user_model = D("User");

        $status = $user_model->where("id=$id")->delete();
        if (!$status) {
            $this->error("操作失败");
        }
        $mobile = $user_model->where("id=$id")->getField('mobile');
        add_log(getAdminId(),CONTROLLER_NAME.'/'.ACTION_NAME,'删除会员,手机号为:'.$mobile);
        $this->success("操作成功");
    }


    //打印信息
    public function printUser($id = 0)
    {
        if (!$id) {
            $this->error("参数错误");
        }
        $user_model = D("User");
        $DB_PREFIX = C('DB_PREFIX');
        $authInfo = $user_model
            ->where(array("{$DB_PREFIX}user.id" => $id))
            ->join("LEFT JOIN {$DB_PREFIX}auth_idcard on {$DB_PREFIX}user.id = {$DB_PREFIX}auth_idcard.uid")
            ->join("LEFT JOIN {$DB_PREFIX}auth_info on {$DB_PREFIX}user.id = {$DB_PREFIX}auth_info.uid")
            ->join("LEFT JOIN {$DB_PREFIX}auth_bank on {$DB_PREFIX}user.id = {$DB_PREFIX}auth_bank.uid")
            ->field("{$DB_PREFIX}auth_idcard.*,{$DB_PREFIX}auth_info.*,{$DB_PREFIX}user.*,{$DB_PREFIX}auth_bank.bank_num,{$DB_PREFIX}auth_bank.acct_name,{$DB_PREFIX}auth_bank.id_card")
            ->find();

        //芝麻信用信息
//        $zmxy_model = D('Zmxy');
//        $where['mobile'] = $authInfo['mobile'];
//        $zmxy = $zmxy_model->where($where)->select();

        $this->assign('id', $id);
        //$this->assign('zmxy', $zmxy);
        $this->assign('data', $authInfo);
        $this->display();
    }


    //短信群发
    public function qunfa()
    {
        $phones = I('post.phones');
        $uid = I('post.uid');
        if(!$uid) $this->ajaxReturn(array('status'=>0));
        $info = D('Auth_idcard')->where("uid=$uid")->find();
        if(!$info) $this->error("该用户未认证身份，发送失败");
        $status = D('Smslog')->sendReviewSms($phones, 'qunfa',$info['name']);
        if($status){
            $this->success("群发成功");
        }else{
            $this->error("群发失败");
        }

    }


    //用户ID查询用户认证信息
    public function viewAuth()
    {
        $id = I('get.id', 0, 'intval');
        if (!$id) {
            $this->error("参数错误!");
        }
        add_log(getAdminId(),CONTROLLER_NAME.'/'.ACTION_NAME,'查看用户资料，用户id:'.$id);
        $user_model = D("User");
        $DB_PREFIX = C('DB_PREFIX');
        $authInfo = $user_model
            ->where(array("{$DB_PREFIX}user.id" => $id))
            ->join("LEFT JOIN {$DB_PREFIX}auth_idcard on {$DB_PREFIX}user.id = {$DB_PREFIX}auth_idcard.uid")
            ->join("LEFT JOIN {$DB_PREFIX}auth_info on {$DB_PREFIX}user.id = {$DB_PREFIX}auth_info.uid")
            ->join("LEFT JOIN {$DB_PREFIX}auth_bank on {$DB_PREFIX}user.id = {$DB_PREFIX}auth_bank.uid")
            ->field("{$DB_PREFIX}auth_idcard.*,{$DB_PREFIX}auth_info.*,{$DB_PREFIX}user.*,{$DB_PREFIX}auth_bank.bank_num,{$DB_PREFIX}auth_bank.acct_name,{$DB_PREFIX}auth_bank.id_card")
            ->find();


        $mobile_model = D("Auth_mobile");
        $mobile_info = $mobile_model->where(array('uid' => $id))->find();

        if ($mobile_info) {

            if(!$mobile_info['data'] || $mobile_info['data']=='null'){
                $this->assign('getReport',1);
            }
            $array = object_to_array(json_decode($mobile_info['data']));
            $authInfo['mobileAuthStatus'] = $mobile_info['status'];
            $authInfo['data'] = $array;
        } else {
            $authInfo['mobileAuthStatus'] = 0;
        }

        foreach ($authInfo as $key => $val) {
            if (empty($val) && $key != "photo_face" && $key != "photo" && $key != "photo_back" && $key != "mobileAuthStatus") {
                $authInfo[$key] = "未填写";
            }
        }

        $this->assign('id', $id);
        $this->assign('data', $authInfo);
        $this->display();

    }

    public function getReport(){
        $id = I("post.id");
        add_log(getAdminId(),CONTROLLER_NAME.'/'.ACTION_NAME,'手动获取用户运营商数据,用户id:'.$id);
        $mobile_model = D("Auth_mobile");
        $mobile_info = $mobile_model->where(array('uid' => $id))->find();
        import('@.Class.Limu');
        $Limu = new \Limu();
        $mobile_obj = $Limu->ApiCommonGetResult($mobile_info['token'],'mobile');
        $arr['status'] = 1;
        $arr['data'] = json_encode(object_to_array($mobile_obj->data));

        $status = $mobile_model->where(array('uid'=>$id))->save($arr);
        if($status && $arr['data']){
            $this->success("获取成功!");
        }else{
            $this->error("获取失败!");
        }
    }

    //立木通话详单
    public function viewAuth_mobile()
    {
        $id = I("post.id");
        add_log(getAdminId(),CONTROLLER_NAME.'/'.ACTION_NAME,'获取用户本地运营商数据,用户id:'.$id);
        // 记录写入数据库
        $data['status'] = 2;
        $data['uid'] = $id;
        $mobile_model = D("Auth_mobile");
        //如果有数据则 更新
        if ($mobile_model->where(array('uid' => $id))->find()) {
            if (!$mobile_model->where(array('uid' => $id))->save($data)) {
                $this->error("更新数据失败!");
            } else {
                $this->success("操作成功!");
            }

        } else {
             $this->error("更新数据失败!");
        }
    }


    //重新认证
    public function rz_mobile()
    {
        $id = I("post.id");
        if(!$id)    $this->error("参数错误!");
        add_log(getAdminId(),CONTROLLER_NAME.'/'.ACTION_NAME,'重新认证用户运营商，用户id:'.$id);
        $status = D('auth_mobile')->where("uid=$id")->delete();
        if ($status) {
            $this->success('认证成功');
        } else {
            $this->error("认证失败!");
        }
    }


    //调整额度及日息
    public function resetRate()
    {
        $id = I("post.id", 0, 'intval');
        $rate = I("post.rate");
        $quota = I("post.quota", 0, 'intval');
        if (!$id) {
            $this->error("参数错误!");
        }
        add_log(getAdminId(),CONTROLLER_NAME.'/'.ACTION_NAME,'调整用户id:'.$id.'日息:'.$rate.'额度:'.$quota);
        $user_model = D("User");
        if (!$rate || !$quota) {
            $this->error("用户额度及日息不规范!");
        }
        $min_money = nl_get_customConfig('min_money');
        if ($quota <= $min_money) {
            $this->error("用户额度必须大于系统预设最小额度!");
        }
        $status = $user_model->where(array('id' => $id))->save(array('rate' => $rate, 'quota' => $quota));
        if (!$status) {
            $this->error("调整失败!");
        }
        $this->success("操作成功!");
    }
	
	
	public function recommend(){
		
		if(IS_POST){
			$recommends=I('post.recommends');
			$status = M('recommend')->where('id=1')->save(array('recommends'=>$recommends));
			if($status){
				$this->success("操作成功!");
			}else{
				$this->error("调整失败,无修改信息!");
			}
			
		}else{
			$data = M('recommend')->where('id=1')->getField('recommends');
			$this->recommends=$data;
			$this->display();
		}
		
	}


}