<?php

namespace Admin\Controller;

class AdminController extends PublicController
{

    /*
     *  管理员列表
     * */
    public function index()
    {
        $Admin = D("Admin");
        $Access = D('think_auth_group_access');
        $Group = D('think_auth_group');
        $lists = $Admin->order("id")->select();

        foreach ($lists as $key => $val) {
            $where['uid'] = $val['id'];
            $group_id = $Access->where($where)->getField('group_id');    //该管理员所属组
			$title = $Group->where(array('id'=>$group_id))->getField('title');
            $lists[$key]['group'] = $title;
        }
		
        $this->assign('lists', $lists);
        $this->display();
    }

    /*
     *  禁用/启用管理员
     * */
    public function change()
    {
        $id = I("get.id", 0, 'intval');
        if (!$id) $this->error("参数有误!");
        $c_status = I("get.status", 0, 'intval');
        $Admin = D("Admin");
        $status = $Admin->where("id=$id")->save(array('status' => $c_status));
        if (!$status) {
            $this->error("操作失败!");
        } else {
            $this->success("操作成功!");
        }

    }

    /*
     *  删除管理员
     * */
    public function del()
    {
        $id = I("post.id", 0, 'intval');
        if (!$id) $this->error("参数有误!");
        $Admin = D("Admin");
        $Access = D('think_auth_group_access');
        $status = $Admin->where(array('id' => $id))->delete();
        $Access->where("uid=$id")->delete();
        if (!$status) {
            $this->error("操作失败!");
        } else {
            $this->success("删除管理员成功!");
        }

    }

    /*
     *  添加管理员
     * */
    public function add()
    {
        $Admin = D("Admin");
        if (IS_POST) {
            $username = I("post.username", '', 'trim');
            $password = I("post.password", '', 'trim');
            $repassword = I("post.repassword", '', 'trim');
            $realname = I("post.realname", '', 'trim');
            $mobile = I("post.mobile", '', 'trim');
            $recommend = I("post.recommend", '', 'trim');
            $yids = I('post.yids');
            $yids = implode(",", $yids);
//            if (!isMobileNum($mobile)) {
//                $this->error("手机号格式不正确");
//            }

            if (!$username) {
                $this->error("登录用户名不能为空!");
            }
            if (strlen($username) < 6 || strlen($username) > 12) {
                $this->error("用户名长度必须为 6 - 12 位!");
            }
            if (!$password) {
                $this->error("登录密码不能为空!");
            }
            if (strlen($password) < 6 || strlen($password) > 18) {
                $this->error("密码长度必须为 6 - 18 位!");
            }
            if ($password != $repassword) {
                $this->error("两次密码输入不一致!");
            }

            $password = $Admin->getPass($password);
            $r = $Admin->where(array('username' => $username))->count();
            if ($r) {
                $this->error("该用户名已存在!");
            }

            $gid = I("post.gid");
            if (!$gid) {
                $this->error("请选择权限组!");
            }

            $status = $Admin->add(array(
                'username' => $username,
                'password' => $password,
                'mobile' => $mobile,
                'realname' => $realname,
                'status' => I("post.status", 1, 'intval'),
                'create_time' => time(),
                'login_time' => 0,
                'login_ip' => '0.0.0.0',
                'yids' => $yids,
                'recommend' => $recommend
            ));
            if (!$status) {
                $this->error("添加失败!");
            } else {
                //添加用户到权限组
                $data['uid'] = $status;
                $data['group_id'] = $gid;
                D('think_auth_group_access')->add($data);
                $this->success("添加成功!");
            }

        } else {
            $yewus = D('think_auth_group_access')->where("group_id=2")->select();   //权限表所有业务员
            $uids = '';

            if ($yewus) {
                foreach ($yewus as $key => $val) {
                    $uids[] = $val['uid'];
                }

                if ($uids) {
                    $uid = implode(',', $uids);
                    $where['id'] = array('in', $uid);
                    $admin = D('Admin')->where($where)->select(); //admin表所有业务员
                }
            }


            $this->assign('admin', $admin);
            $group = D('think_auth_group')->select();
            $this->assign('group', $group);
            $this->display();
        }

    }

    /*
     *  编辑管理员信息
     * */
    public
    function edit()
    {
        $id = I("get.id", 0, 'intval');
        if (!$id) {
            $this->error("参数有误!");
        }
        $Admin = D("Admin");
        $info = $Admin->where(array('id' => $id))->find();
        if (!$info) {
            $this->error("不存在该管理员信息!");
        }
        if ($info && $info['username'] == 'admin') {
            $this->error("不允许修改创始人信息!");
        }
        if (IS_POST) {
            $username = I("post.username", '', 'trim');
            $password = I("post.password", '', 'trim');
            $repassword = I("post.repassword", '', 'trim');
            $realname = I("post.realname", '', 'trim');
            $mobile = I("post.mobile", '', 'trim');
            $yids = I('post.yids');
            if (!isMobileNum($mobile)) {
                $this->error("手机号格式不正确");
            }

            if (!$username) {
                $this->error("登录用户名不能为空!");
            }
            if (strlen($username) < 6 || strlen($username) > 12) {
                $this->error("用户名长度必须为 6 - 12 位!");
            }

            $r = $Admin->where(array('username' => $username))->find();
            if ($r && $r['id'] != $id) {
                $this->error("该用户名已存在!");
            }

            if ($yids) {
                $yids = implode(",", $yids);
            }

            $arr = array(
                'username' => $username,
                'status' => I("post.status", 1, 'intval'),
                'mobile' => $mobile,
                'yids' => $yids,
                'realname' => $realname
            );
            if ($password) {
                if (strlen($password) < 6 || strlen($password) > 18) {
                    $this->error("密码长度必须为 6 - 18 位!");
                }
                if ($password != $repassword) {
                    $this->error("两次密码输入不一致!");
                }
                $password = $Admin->getPass($password);
                $arr['password'] = $password;
            }
            $gid = I("post.gid");
            if (!$gid) {
                $this->error("请选择权限组!");
            }

            $status = $Admin->where("id=$id")->save($arr);

            //修改成功后 将用户id  group_id 插入到表中
            D('think_auth_group_access')->where("uid=$id")->delete();   //删除原数据
            foreach ($gid as $key => $val) {       //保存新数据
                $data['uid'] = $id;
                $data['group_id'] = $val;
                $status2 = D('think_auth_group_access')->add($data);
            }

            if ($status || $status2) {
                $this->success("编辑管理员成功!");
            } else {
                $this->error('编辑失败,无修改信息');
            }


        } else {
            $group = D('think_auth_group')->select();
            $access = D('think_auth_group_access')->where("uid=$id")->select();

            foreach ($group as $key => $val) {
                foreach ($access as $k => $v) {
                    if ($val['id'] == $v['group_id']) {
                        $group[$key]['checked'] = 1;
                    }
                }
            }

            $yewus = D('think_auth_group_access')->where("group_id=2")->select();   //权限表所有业务员
            $uids = '';

            if ($yewus) {
                foreach ($yewus as $key => $val) {
                    $uids[] = $val['uid'];
                }
                if ($uids) {
                    $uid = implode(',', $uids);
                    $where['id'] = array('in', $uid);
                    $admin = D('Admin')->where($where)->select(); //admin表所有业务员
                }
            }

            //当前审核员 可审核业务员
            $asse = D('Admin')->where("id=$id")->find();

            $this->assign('admin', $admin);
            $this->assign('asse', $asse);
            $this->assign('group', $group);
            $this->assign('data', $info);
            $this->display();
        }

    }

    //操作记录
    public function log(){
        $data = D('log')->order('id desc')->select();
        $this->assign('data', $data);
        $this->display();
    }


}