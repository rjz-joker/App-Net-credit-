<?php

namespace Admin\Controller;

//	贷款管理控制器

use Think\Page;

class LoanController extends PublicController
{

    //贷款列表
    public function index()
    {
		
				//导出数据
        if (isset($_GET['aliziExcel'])) {
            add_log(getAdminId(),CONTROLLER_NAME.'/'.ACTION_NAME,'导出了借款数据');
			
			$DB_PREFIX = C('DB_PREFIX');
			$loans = D("Loan")
            ->join("LEFT JOIN {$DB_PREFIX}user on {$DB_PREFIX}loan.uid = {$DB_PREFIX}user.id")
            ->join("LEFT JOIN {$DB_PREFIX}auth_idcard on {$DB_PREFIX}loan.uid = {$DB_PREFIX}auth_idcard.uid")
			->join("LEFT JOIN {$DB_PREFIX}auth_info on {$DB_PREFIX}loan.uid = {$DB_PREFIX}auth_info.uid")
			->join("LEFT JOIN {$DB_PREFIX}auth_bank on {$DB_PREFIX}loan.uid = {$DB_PREFIX}auth_bank.uid")
            ->field("{$DB_PREFIX}user.mobile,{$DB_PREFIX}loan.*,{$DB_PREFIX}auth_info.*,{$DB_PREFIX}auth_idcard.name,{$DB_PREFIX}auth_idcard.idcard,{$DB_PREFIX}auth_bank.bank_num")
            ->order("{$DB_PREFIX}loan.id DESC")
            ->select();
			
			
			foreach ($loans as $key => $val) {
            if ($val['payment_time']) {
                $loans[$key]['yq'] = round(($val['payment_time'] - $val['review_time'] - $val['day'] * 24 * 3600) / 86400);
				
            } else{
                $loans[$key]['yq'] = round((time() - $val['review_time'] - $val['day'] * 24 * 3600) / 86400);	
            }
			
			if($loans[$key]['yq']<0){
				$loans[$key]['yq']=0;
				$loans[$key]['yu_money']=0;
			}
			
			$loans[$key]['create_time']=date('Y-m-d H:i:s',$loans[$key]['create_time']);
			if($loans[$key]['review_time']){
				$loans[$key]['should_time']=date('Y-m-d H:i:s',($loans[$key]['review_time']+$loans[$key]['day']*86400));
				$loans[$key]['review_time']=date('Y-m-d H:i:s',$loans[$key]['review_time']);
				
			}
			if($loans[$key]['payment_time']){
				$loans[$key]['payment_time']=date('Y-m-d H:i:s',$loans[$key]['payment_time']);
			}
			
			$loans[$key]['borrow_status']=getBorrowStatus($loans[$key]['borrow_status']);
			$loans[$key]['yu_money']=sprintf('%.2f',$loans[$key]['yq']*nl_get_customConfig('yu_money')*$loans[$key]['money']/100);
			if($loans[$key]['yu_money'] > $loans[$key]['money']*nl_get_customConfig('yu_max_money')){
				$loans[$key]['yu_money']=$loans[$key]['money'];
			}
			$loans[$key]['is_jiechang']=$loans[$key]['is_jiechang']?'已帮还':'否';
			
        }
			
			
			  $title = array(
                'id' => 'ID',
                'oid' => '订单号',
				'name' => '姓名',
                'mobile' => '手机号',
                'idcard' => '身份证号',
                'bank_num' => '银行卡号',
                'money' => '借款金额',
                'day' => '借款天数',
                'fee' => '手续费',
                'create_time' => ' 申请时间',
                'borrow_status' => '订单状态',
                'review_money' => '放款金额',
                'review_time' => '放款时间',
				'should_time'=>'应还时间',
                'payment_time' => '还款时间',
				'yq'=>'逾期天数',
				'yu_money'=>'逾期金额',
				'is_jiechang'=>'是否帮还',
				'live_city'=>'居住城市',
				'live_address'=>'居住地',
				'people_relation_1'=>'联系人1关系',
				'people_name_1'=>'联系人1姓名',
				'people_tel_1'=>'联系人1电话',
				'people_relation_2'=>'联系人2关系',
				'people_name_2'=>'联系人2姓名',
				'people_tel_2'=>'联系人2电话',
				'review_note' => '备注'
            );
            parent::aliziExcel($loans, $title, date('Y-m-d'));
            exit;
			
		}
		
		
        //将消息变为已读
        $d['is_read'] = 1;
        D('Loan')->where('is_read=0')->save($d);

        $loan_model = D("Loan");
        $limits = 20;
        $name = I('get.name');
        $mobile = I('get.mobile');
        $review_time_start = I('get.review_time_start');
        $review_time_end = I('get.review_time_end');
        if ($name) {
            $where['name'] = array('like', "%$name%");
            $this->name = $name;
        }
        if ($mobile) {
            $where['mobile'] = $mobile;
            $this->mobile = $mobile;
        }

        if ($review_time_start && !$review_time_end) {
            $this->error("请填入结束时间!");
        }

        if (!$review_time_start && $review_time_end) {
            $this->error("请填入开始时间!");
        }


        if ($review_time_start && $review_time_end) {
            if ($review_time_end < $review_time_start) {
                $this->error("填写的时间范围有误!");
            } else {
                $this->assign("review_time_start", $review_time_start);
                $this->assign("review_time_end", $review_time_end);
                $review_time_start = strtotime($review_time_start);
                $review_time_end = strtotime($review_time_end)+86400;
                $where['review_time'] = array('between', array($review_time_start, $review_time_end));
            }
        }


        $arr = array('-1', '0', '1', '2','3', '4','5','8');
        $status = I('get.borrow_status');
        if (in_array($status, $arr)) {
            $where['borrow_status'] = $status;
        } else {
            $where['borrow_status'] = 0;
        }

        if ($where['borrow_status'] == -1) {
            $this->assign("al", -1);
            unset($where['borrow_status']);
        }
		
		$time=strtotime(date("Y-m-d"),time());
		
		 if ($where['borrow_status'] == 3) {
            $this->assign("yuqi", 3);
            unset($where['borrow_status']);
		
			$where="borrow_status=1 and review_time<=($time-day*86400)";

        }
		
		 if ($where['borrow_status'] == 8) {
            $this->assign("is_jiechang", 8);
            unset($where['borrow_status']);
		
			$where="is_jiechang=1";
        }
		
        $this->where = $where;
        $count = $loan_model->where($where)->count();
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
        $loan = $loan_model
            ->join("LEFT JOIN {$DB_PREFIX}user on {$DB_PREFIX}loan.uid = {$DB_PREFIX}user.id")
            ->join("LEFT JOIN {$DB_PREFIX}auth_idcard on {$DB_PREFIX}loan.uid = {$DB_PREFIX}auth_idcard.uid")
            ->join("LEFT JOIN {$DB_PREFIX}auth_info on {$DB_PREFIX}loan.uid = {$DB_PREFIX}auth_info.uid")
            ->join("LEFT JOIN {$DB_PREFIX}auth_bank on {$DB_PREFIX}loan.uid = {$DB_PREFIX}auth_bank.uid")
            ->field("{$DB_PREFIX}user.*,{$DB_PREFIX}loan.*,{$DB_PREFIX}auth_idcard.name,{$DB_PREFIX}auth_bank.bank_num")
            ->where($where)
            ->order("{$DB_PREFIX}loan.id DESC")
            ->limit($Page->firstRow . ',' . $Page->listRows)
            ->select();
			
		//dump($loan_model->getLastSql());

		
        foreach ($loan as $key => $val) {
			$n = $loan_model->where(array('uid' => $val['uid']))->count();
            $loan[$key]['num'] = $n;
			$n = $loan_model->where(array('uid' => $val['uid'], 'borrow_status' => 1))->count();
            $loan[$key]['borrow'] = $n;
            $n = $loan_model->where(array('uid' => $val['uid'], 'borrow_status' => 2))->count();
            $loan[$key]['fborrow'] = $n;
            $n = $loan_model->where(array('uid' => $val['uid'], 'payment_status' => 1))->count();
            $loan[$key]['payment_num'] = $n;
			
			
            if ($val['payment_time']) {
                $loan[$key]['yq'] = round(($val['payment_time'] - $val['review_time'] - $val['day'] * 24 * 3600) / 86400);
            } else{
                $loan[$key]['yq'] = round((time() - $val['review_time'] - $val['day'] * 24 * 3600) / 86400);	
            }
	
			
        }
		

        $this->assign("lists", $loan);
        $this->assign("page", $show);
        $this->display();
    }
	
	
	public function xieyi(){
		$id= I('get.id');
		if(!$id){$this->error('参数错误!');}
			$DB_PREFIX = C('DB_PREFIX');
			$where['north_loan.uid'] = $id;
		  $loan = D('Loan')
            ->join("LEFT JOIN {$DB_PREFIX}user on {$DB_PREFIX}loan.uid = {$DB_PREFIX}user.id")
            ->join("LEFT JOIN {$DB_PREFIX}auth_idcard on {$DB_PREFIX}loan.uid = {$DB_PREFIX}auth_idcard.uid")
            ->join("LEFT JOIN {$DB_PREFIX}auth_bank on {$DB_PREFIX}loan.uid = {$DB_PREFIX}auth_bank.uid")
			->join("LEFT JOIN {$DB_PREFIX}auth_info on {$DB_PREFIX}loan.uid = {$DB_PREFIX}auth_info.uid")
            ->field("{$DB_PREFIX}user.*,{$DB_PREFIX}loan.*,{$DB_PREFIX}auth_idcard.name,{$DB_PREFIX}auth_idcard.idcard,{$DB_PREFIX}auth_bank.bank_num")
            ->where($where)
            ->find();
			
		$xieyi = D('Page')->where('id=4')->find();	
		
		$xieyi['content']=str_replace('oid',$loan['oid'],$xieyi['content']);
		$xieyi['content']=str_replace('time',date("Y-m-d H:i:s",$loan['create_time']),$xieyi['content']);
		$xieyi['content']=str_replace('uname',$loan['name'],$xieyi['content']);
		$xieyi['content']=str_replace('idcard',$loan['idcard'],$xieyi['content']);
		$xieyi['content']=str_replace('mobile',$loan['mobile'],$xieyi['content']);
		$xieyi['content']=str_replace('ucid',$loan['bank_num'],$xieyi['content']);
		
		$this->assign('content',$xieyi['content']);
		$this->display();
		
	}
	
		   //统计
    public function count(){
        
		$time=strtotime(date("Y-m-d"),time());
		//申请人数
		$data['loans'] = D('Loan')->count();
		//放款人数
		$data['f_loans']= D('Loan')->where("borrow_status in(1,4,5)")->count();
		//逾期人数
		$data['yu_people']=D('Loan')->where("borrow_status=1 and review_time<(".$time."-day*86400)")->count();
		//借款金额
		$data['jie_money']=D('loan')->sum('money');
		//放款金额
		$data['f_money']=D('loan')->where("borrow_status in(1,4,5)")->sum('review_money');
		//还款金额
		$data['h_money']=D('loan')->where("borrow_status=4")->sum('money');
		//打款完成
		$data['w_money']=D('loan')->where("borrow_status in(1,4,5)")->sum('review_money');
		//逾期金额
		$data['yu_money']=D('Loan')->where("borrow_status=1 and review_time<(".$time."-day*86400)")->sum('money');
		//累计逾期费
		$loans=D('Loan')->where("borrow_status=1")->select();
		
		$yu_moneys=0;
		foreach($loans as $key=>$val){
			$yq=round((time() - $val['review_time'] - $val['day'] * 24 * 3600) / 86400);
			if($yq>0){
				$yu_money=$yq*nl_get_customConfig('yu_money')*$val['money']/100;
				if($yu_money>nl_get_customConfig('yu_max_money')*$val['money']){
					$yu_money=$val['money'];
				}
				$yu_moneys+=$yu_money;
			}
		}
		$data['yu_fei']=$yu_moneys;
		
		//未到期金额
		$f_money = D('Loan')->where("borrow_status=1")->sum('money');
		$data['wei_money']=$f_money-$data['yu_money'];
		$this->assign('data',$data);
        $this->display();
    }

	//统计当日
    public function countDay(){
        //申请人数
		$today=strtotime(date("Y-m-d"),time());
		$time_end=$today+86400;
		$data['loans'] = D('Loan')->where("create_time>$today and create_time<$time_end")->count();
		//通过笔数
		$data['f_loans']= D('Loan')->where("borrow_status in(1,4,5) and review_time>$today and review_time<$time_end")->count();
		//放款金额
		$data['f_money']=D('loan')->where("borrow_status in(1,4,5) and review_time>$today and review_time<$time_end")->sum('money');
		
		
		//到期笔数
		$data['d_nums']=D('loan')->where("borrow_status in(1,4,5) and review_time>($today-day*86400) and review_time<($time_end-day*86400)")->count();
		//到期金额
		$data['d_money']=D('Loan')->where("borrow_status in(1,4,5) and review_time>($today-day*86400) and review_time<($time_end-day*86400)")->sum('money');
		
		//到期已还笔数
		$data['dh_nums']=D('loan')->where("borrow_status in(4) and review_time>($today-day*86400) and review_time<($time_end-day*86400)")->count();
		//到期已还金额
		$data['dh_money']=D('Loan')->where("borrow_status in(4) and review_time>($today-day*86400) and review_time<($time_end-day*86400)")->sum('money');
		
		//到期未还款笔数（逾期）
		$data['w_nums']=D('loan')->where("borrow_status=1 and review_time<($today-day*86400)")->count();
		//到期未还款金额（逾期）
		$data['w_money']=D('loan')->where("borrow_status=1 and review_time<($today-day*86400)")->sum('money');
		//打款完成
		$data['dk_money']=D('loan')->where("borrow_status in(1,4,5) and review_time>$today and review_time<$time_end")->sum('review_money');
		
		//到期未还款笔数（逾期）
		$data['yu_day_nums']=D('loan')->where("borrow_status=1 and review_time>($today-day*86400-86400) and review_time<($time_end-day*86400-86400)")->count();
		
		//累计逾期笔数 截至上一日合计的逾期笔数
		$data['yu_count']=D('loan')->where("borrow_status=1 and review_time<($today-day*86400)")->count();
		
		//当日逾期率 上一日已还笔数除以到期笔数的比率
		$data['yu_per']=sprintf('%.2f',$data['yu_day_nums']/$data['d_nums']);
		//累计逾期率 截至上一日合计已还笔数除以合计到期笔数的比率
		$h_num=D('loan')->where("borrow_status=4")->count();
		$all_num=D('loan')->where("borrow_status=1")->count();
		$data['yu_all_per']=sprintf('%.2f',$h_num/$all_num);
		

		$this->assign('data',$data);
        $this->display();
    }

    //删除订单
    public function delLoan($id = 0)
    {
        if (!$id) {
            $this->error("参数错误!");
        }
        add_log(getAdminId(),CONTROLLER_NAME.'/'.ACTION_NAME,'删除订单id:'.$id);
        $loan_model = D("Loan");
        $status = $loan_model->where(array('id' => $id))->delete();
        if (!$status) {
            $this->error("操作失败!");
        }
        $this->success("删除订单成功!");
    }
	
	public function dkLoan($id = 0){
		if (!$id) {
            $this->error("参数错误!");
        }
		 add_log(getAdminId(),CONTROLLER_NAME.'/'.ACTION_NAME,'打款订单id:'.$id);
		 $loan_model = D("Loan");
         $status = $loan_model->where(array('id' => $id))->save(array('borrow_status'=>1));
		 if (!$status) {
            $this->error("失败!");
        }
        $this->success("成功!");
		
	}


    /**
     * 显示用户所有贷款记录
     */
    public function show()
    {
        $id = I('get.id');
        add_log(getAdminId(),CONTROLLER_NAME.'/'.ACTION_NAME,'查看用户贷款记录,用户id:'.$id);
        $loan_model = D("Loan");
        $limits = 30;
        $count = $loan_model->count();
        $Page = new Page($count, $limits);
        $show = $Page->show();
        $DB_PREFIX = C('DB_PREFIX');
        $where['north_loan.uid'] = $id;
        $loan = $loan_model
            ->join("LEFT JOIN {$DB_PREFIX}user on {$DB_PREFIX}loan.uid = {$DB_PREFIX}user.id")
            ->join("LEFT JOIN {$DB_PREFIX}auth_idcard on {$DB_PREFIX}loan.uid = {$DB_PREFIX}auth_idcard.uid")
            ->join("LEFT JOIN {$DB_PREFIX}auth_info on {$DB_PREFIX}loan.uid = {$DB_PREFIX}auth_info.uid")
            ->join("LEFT JOIN {$DB_PREFIX}auth_bank on {$DB_PREFIX}loan.uid = {$DB_PREFIX}auth_bank.uid")
            ->field("{$DB_PREFIX}user.*,{$DB_PREFIX}loan.*,{$DB_PREFIX}auth_idcard.name,{$DB_PREFIX}auth_bank.bank_num")
            ->where($where)
            ->order("{$DB_PREFIX}loan.id DESC")
            ->limit($Page->firstRow . ',' . $Page->listRows)
            ->select();

        foreach ($loan as $key => $val) {
            if ($val['payment_time']) {
                $loan[$key]['yq'] = round(($val['payment_time'] - $val['review_time'] - $val['day'] * 24 * 3600) / 86400);
            } else {
                $loan[$key]['yq'] = round((time() - $val['review_time'] - $val['day'] * 24 * 3600) / 86400);

            }
        }

        $this->assign("lists", $loan);
        $this->assign("page", $show);
        $this->display();

    }

    //发送催收短信
    public function sendSms()
    {
        if (IS_AJAX) {
            $uid = I('get.id');
            add_log(getAdminId(),CONTROLLER_NAME.'/'.ACTION_NAME,'发送逾期提醒短信,用户id:'.$uid);
            $user_info = D('user')->where("id=$uid")->find();
            if (D('Smslog')->sendReviewSms($user_info['mobile'], 'cuishou')) {
                $this->ajaxReturn(array('status' => 0));
            } else {
                $this->ajaxReturn(array('status' => 1));
            }
        }
    }


    /**
     * 还款状态
     * @param int
     */
    public function statusLoan($id = 0)
    {

        if (!$id) {
            $this->error("参数错误!");
        }
        add_log(getAdminId(),CONTROLLER_NAME.'/'.ACTION_NAME,'修改还款状态,订单id:'.$id);
        $loan_model = D("Loan");
        $info = $loan_model->where(array('id' => $id))->find();
        if ($info && !$info['payment_status']) {
            //如果订单存在并且没有还款再处理
            //4为已还款
            $arr = array(
                'borrow_status' => 4,
                'payment_status' => 1,
                'payment_time' => time()
            );
            $status = $loan_model->where(array('id' => $id))->save($arr);
            if (!$status) {
                $this->error("操作还款失败!");
            }
            $this->success("订单还款成功!");
        }

    }

    /**
     * 续期
     * @param
     */
    public function xuqiLoan()
    {
        $id = I('post.id');
        $uid = I('post.uid');
        if (!$id || !$uid) $this->error("参数错误!");
        add_log(getAdminId(),CONTROLLER_NAME.'/'.ACTION_NAME,'续期订单id:'.$id);
        $loan_model = D("Loan");
        $loan = $loan_model->where(array('id' => $id))->find();
        if ($loan) {
            $id2= $id;
            if ($loan['pid'] <> 0) {      //说明是第二次续期
                $id = $loan['pid'];
            }

            //变更还款计划
            //调用连连授权API
            require_once(VENDOR_PATH . "lianlian/llpay.config.php");
            require_once(VENDOR_PATH . "lianlian/lib/llpay_submit.class.php");

            //还款计划
            $date = date("Y-m-d", $loan['review_time'] + $loan['day'] * 86400 + $loan['day'] * 86400);  //应还时间
            $date = "'" . $date . "'";
            $money = "'" . $loan['money'] . "'";
            $plan = "{'repaymentPlan':[{'date':$date,'amount':$money}]}";

            //短信参数
            $sms_arr = array(
                "contract_type" => nl_get_customConfig("business_name"),
                "contact_way" => nl_get_customConfig("business_tel")
            );
            $sms_json = json_encode($sms_arr, JSON_UNESCAPED_UNICODE);

            //构造要请求的参数数组，无需改动
            $parameter = array(
                "oid_partner" => trim($llpay_config['oid_partner']),
                "sign_type" => trim($llpay_config['sign_type']),
                "user_id" => $uid,
                "repayment_plan" => $plan,
                "api_version" => trim($llpay_config['version']),
                "repayment_no" => $id,
                "sms_param" => $sms_json
            );

            //建立请求
            $llpay_gateway_new = 'https://repaymentapi.lianlianpay.com/repaymentplanchange.htm';

            $llpaySubmit = new \LLpaySubmit($llpay_config, $llpay_gateway_new);
            $json = $llpaySubmit->buildRequestJSON($parameter, $llpay_gateway_new);
            $json = json_decode($json, true);

            if ($json['ret_code'] == "0000") {     //证明交易成功
                //生成新订单
                $d = array(
                    "uid" => $loan['uid'],
                    "oid" => mackOid(),
                    "money" => $loan['money'],
                    "day" => $loan['day'],
                    "fee" => $loan['fee'],
                    "bankname" => $loan['bankname'],
                    "banknum" => $loan['banknum'],
                    "create_time" => $loan['review_time'] + $loan['day'] * 86400,
                    "borrow_status" => 1,
                    "review_money" => $loan['review_money'],
                    "review_time" => $loan['review_time'] + $loan['day'] * 86400,
                    "review_note" => "续期订单",
                    "payment_status" => 0,
                    "payment_time" => 0,
                    "is_read" => 0,
                    "pid" => $id
                );
                $s = D("Loan")->add($d);
                //4为已还款
                $arr = array(
                    'borrow_status' => 4,
                    'payment_status' => 1,
                    'payment_time' => time()
                );
                $status = $loan_model->where(array('id' => $id2))->save($arr);
                echo 1;
            } else {
                echo 0;
            }

        }

    }



    //订单审核
    public function resetStatus()
    {
        $id = I("post.id", 0, 'intval');
        $uid = I("post.uid", 0, 'intval');
        $bank_info = D("Auth_bank")->where(array("uid" => $uid))->find();
        $borrow_status = I("post.borrow_status", 0, 'intval');
        $review_note = I("post.review_note", '');
        $review_money = I("post.review_money", '');
        $money = I("post.money", '');
        $sms_status = I("post.sms", 0, 'intval');
        $wx_status = I("post.wx", 0, 'intval'); //微信推送
        $day = I("post.day", 0, 'intval');
        if (!$id || !$uid) {
            $this->error("参数错误!");
        }
        add_log(getAdminId(),CONTROLLER_NAME.'/'.ACTION_NAME,'审核订单id:'.$id.'状态:'.$borrow_status);
        $loan_model = D("Loan");
        if (!$borrow_status) {
            $this->error("请选择审核结果!");
        }
        $i = $loan_model->where(array('id' => $id))->find();
        if (!$i)
            $this->error("订单不存在!");

        if ($borrow_status != 2) {
            if (!is_numeric($review_money) || $review_money < 0)
                $this->error("审批金额有误!");
        }
		
		if($borrow_status == 2){
			  $status = $loan_model
                ->where(array('id' => $id))
                ->save(array('borrow_status' => $borrow_status, 'review_money' => $review_money, 'review_note' => $review_note, 'review_time' => time(), 'pid' => 0));
			$user_status= I("post.user_status");
			if($user_status==1){
				D('User')->where(array('id'=>$uid))->save(array('status'=>'0'));
			}
				
            echo 1;
			exit;
		}

        //调用连连授权API
        require_once(VENDOR_PATH . "lianlian/llpay.config.php");
        require_once(VENDOR_PATH . "lianlian/lib/llpay_submit.class.php");

        //还款计划
        $time = time();
        $date = date("Y-m-d", $time + $day * 86400);
        $date = "'" . $date . "'";
        $money = "'" . $money . "'";
        $plan = "{'repaymentPlan':[{'date':$date,'amount':$money}]}";

        //短信参数
        $sms_arr = array(
            "contract_type" => nl_get_customConfig("business_name"),
            "contact_way" => nl_get_customConfig("business_tel")
        );
        $sms_json = json_encode($sms_arr, JSON_UNESCAPED_UNICODE);

        //构造要请求的参数数组，无需改动
        $parameter = array(
            "user_id" => $uid,
            "oid_partner" => trim($llpay_config['oid_partner']),
            "sign_type" => trim($llpay_config['sign_type']),
            "api_version" => trim($llpay_config['version']),
            "repayment_plan" => $plan,
            "repayment_no" => $id,
            "sms_param" => $sms_json,
            "pay_type" => "D",
            "no_agree" => $bank_info['agreeno'],
        );

        //建立请求
        $llpay_gateway_new = 'https://repaymentapi.lianlianpay.com/agreenoauthapply.htm';
        $llpaySubmit = new \LLpaySubmit($llpay_config, $llpay_gateway_new);
        $json = $llpaySubmit->buildRequestJSON($parameter, $llpay_gateway_new);
        $json = json_decode($json, true);
		//dump($json);exit;
        if ($json['ret_code'] == "0000") {     //证明连连发送短信成功
            //发送放款成功短信
            if ($borrow_status == 5 && $sms_status == 1) {
                $user_info = D('user')->where("id=$uid")->find();
                $bank_info = D('auth_bank')->where("uid=$uid")->find();
                $bank_num = substr($bank_info['bank_num'], -4);
                D('Smslog')->sendReviewSms($user_info['mobile'], 'success', $bank_num);
            }
            //发送放款失败短信
            if ($borrow_status == 2 && $sms_status == 1) {
                $user_info = D('user')->where("id=$i[uid]")->find();
                D('Smslog')->sendReviewSms($user_info['mobile'], 'fail');
            }



            $status = $loan_model
                ->where(array('id' => $id))
                ->save(array('borrow_status' => $borrow_status, 'review_money' => $review_money, 'review_note' => $review_note, 'review_time' => $time, 'pid' => 0));
            echo 1;
        } else {
            echo 0;
        }


    }

    //找到顶级订单id
    public function getFirstLoadId($pid){
        $loan_info = M('Loan')->where(array('id'=>$pid))->find();
        if($loan_info['pid'] !=0){
            $this->getFirstLoadId($loan_info['pid']);
        }
        return $loan_info['id'];
    }

    //扣款
    public function kouLoan()
    {
        $id = I("post.id", 0, 'intval');
        $uid = I("post.uid", 0, 'intval');
        $money = I("post.money", '');		
        $day = I("post.day", 0, 'intval');
        $user_info = D("User")->where(array("uid" => $uid))->find();
        $bank_info = D("Auth_bank")->where(array("uid" => $uid))->find();
        $idcard_info = D("Auth_idcard")->where(array("uid" => $uid))->find();
        if (!$id || !$uid) {
            $this->error("参数错误!");
        }
        add_log(getAdminId(),CONTROLLER_NAME.'/'.ACTION_NAME,'扣款订单id:'.$id);
        $loan_model = D("Loan");
        $loan_info = $loan_model->where(array('id' => $id))->find();
        if (!$loan_info) $this->error("订单不存在!");

        $id2= $id;
        if ($loan_info['pid'] <> 0) {
            $id = $this->getFirstLoadId($loan_info['pid']);
        }


        //调用连连授权API
        require_once(VENDOR_PATH . "lianlian/llpay.config.php");
        require_once(VENDOR_PATH . "lianlian/lib/llpay_submit.class.php");

        //异步通知路径
        $notify_url = C("site_url") . "Admin/Callback/lian_kou_notify";
        //还款计划日 即 应还日期
        $date = date("Y-m-d", $loan_info['review_time'] + $day * 86400);

        $json = array(
            "frms_ware_category" => "2010",         //商品类目
            "user_info_mercht_userno" => $llpay_config['oid_partner'],  //商户用户唯一标识
            "user_info_dt_register" => "20161015165530",    //注册时间  用户在平台的注册时间YYYYMMDDH24MISS
            "user_info_bind_phone" => $user_info['mobile'],      //用户在平台注册绑定手机
            "user_info_full_name" => $idcard_info['name'],          //用户注册姓名
            "user_info_id_no" => $idcard_info['idcard'], //用户注册证件号码
            "user_info_identify_type" => "1",           //实名认证方式  1：银行卡认证 2：现场认证 3：身份证远程认证 4：其它认证
            "user_info_identify_state" => "1"           //是否实名认证 1：是 0：无认证
        );
        $risk_item = json_encode($json, JSON_UNESCAPED_UNICODE);

        //构造要请求的参数数组，无需改动
        $parameter = array(
            "user_id" => $uid,
            "oid_partner" => trim($llpay_config['oid_partner']),
            "sign_type" => trim($llpay_config['sign_type']),
            "busi_partner" => "101001",
            "api_version" => trim($llpay_config['version']),
            "no_order" => $loan_info['oid'].rand(1,200),
			"info_order" => $loan_info['oid'],
            "dt_order" => local_date('YmdHis', time()),
            "name_goods" => "到期还款",
            "money_order" => $money,
            "notify_url" => $notify_url,
            "risk_item" => $risk_item,
            "schedule_repayment_date" => $date,
            "repayment_no" => $id,
            "pay_type" => "D",
            "no_agree" => $bank_info['agreeno'],
			"valid_order"=>"10080"
        );

        //建立请求
        $llpay_gateway_new = 'https://repaymentapi.lianlianpay.com/bankcardrepayment.htm';
        $llpaySubmit = new \LLpaySubmit($llpay_config, $llpay_gateway_new);
        $json = $llpaySubmit->buildRequestJSON($parameter, $llpay_gateway_new);
		//file_put_contents("adminlog.txt", "扣款异步通知1:\n" . $json, FILE_APPEND);
        $json = json_decode($json, true);
        //dump($json);exit;
        if ($json['ret_code'] == "0000") {     //证明连连发送短信成功
            file_put_contents("adminlog.txt", "扣款异步通知 验证成功:\n" . $json, FILE_APPEND);
            $status = $loan_model
                ->where(array('id' => $id2))
                ->save(array('borrow_status' => 4, 'payment_status' => 1, 'payment_time' => time(), 'review_note' => "扣款成功", 'is_kou' => 1));

            //扣款log表
            D("Koulog")->add(array('uid' => $uid, 'lid' => $loan_info['id'], 'create_time' => time(), 
			'status' => 1,'ret_msg'=>$json['ret_msg'],'ret_code'=>$json['ret_code'],'oid_paybill'=>$json['oid_paybill'],'money_order'=>$json['money_order']));
            echo 1;
        } else {
            file_put_contents("adminlog.txt", "扣款异步通知 验证失败:\n" . $json, FILE_APPEND);
            //扣款log表
            D("Koulog")->add(array('uid' => $uid, 'lid' => $loan_info['id'], 'create_time' => time(), 
			'status' => 0,'ret_msg'=>$json['ret_msg'],'ret_code'=>$json['ret_code'],'oid_paybill'=>$json['oid_paybill'],'money_order'=>$json['money_order']));
            echo 0;
        }

    }
	
	
	public function kou_log(){
		$id = I('get.id');
		if(!$id) $this->error('参数错误');
		$where['lid']=$id;
		$data = D("koulog")->where($where)->select();
		$this->assign('data',$data);
		$this->display();
	}

}