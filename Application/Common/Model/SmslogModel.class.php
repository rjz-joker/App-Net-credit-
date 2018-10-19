<?php

namespace Common\Model;

/*
 *  短信发送记录模型
 * */
use Think\Model;

class SmslogModel extends Model
{
    /*
		检查手机号当日发送次数是否超过限制
    	mobile:手机号
     */
    public function checkUp($mobile = '')
    {
        $day_time = strtotime(date("Y-m-d"));
        $arr = array('mobile' => $mobile, 'status' => 1, 'create_time' => array('GT', $day_time));
        $r = $this->where($arr)->count();
        $dcount = nl_get_customConfig('smsdcount');
        $dcount = empty($dcount) ? 4 : $dcount;
        if ($r > $dcount) {
            return false;
        }
        return true;
    }

        //短信宝版  正式用时把 后缀去掉
    public function sendSms_duanxinbao($phone,$content){
        $smsuser = nl_get_customConfig('smsuser');
        $smspass = md5(nl_get_customConfig('smspass'));
        $url = "http://api.smsbao.com/sms?u={$smsuser}&p={$smspass}&m={$phone}&c=".urlencode($content);
        $r = file_get_contents($url);
        if($r == '0'){
            return 0;
        }else{
            return $r;
        }
    }

    //华兴软通
    public function sendSms_huaxing($phone,$content){
        $smsuser = nl_get_customConfig('smsuser');
        $smspass = nl_get_customConfig('smspass');

        $data = array('pwd' => $smspass, 'reg' => $smsuser,'sourceadd'=>'', 'phone' => $phone, 'content' => $content);
        //$ca_info = '/cacert.pem';		//根证书文件路径,相对路径和绝对路径均可,推荐使用绝对路径;demo里文件和源码放在一起了，为了安全证书文件最好不要和应用代码放在一起
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, 'http://www.stongnet.com/sdkhttp/sendsms.aspx');
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2); 		//检查SSL证书公用名是否存在，并且是否与提供的主机名匹配
        curl_setopt($ch, CURLOPT_SSLVERSION, CURL_SSLVERSION_TLSv1);		//设置实现协议为TLS1.0版本
        //curl_setopt($ch, CURLOPT_CAINFO,  $ca_info);
        $json_data = curl_exec($ch);
        $error = curl_error($ch);
        $r = json_decode($json_data,true);
        if(!empty($error)){
            return $error;
        }else{
            return 0;
        }
    }

    //106
    public function sendSms_106($phone,$content){
        $smsuser = nl_get_customConfig('smsuser');
        $smspass = nl_get_customConfig('smspass');
        $ch = curl_init();
        $data = array('Pass' => $smspass, 'User' => $smsuser, 'Mobiles' => $phone, 'Content' => $content);

        curl_setopt($ch, CURLOPT_URL, 'http://smshttp.106api.com/SMS/SendSMS ');
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $json_data = curl_exec($ch);
        $r = json_decode($json_data,true);
        if($r['MsgID']){
            return 0;
        }else{
            return $r;
        }
    }




    public function sendSms($phone, $content)
    {
        $smsuser = nl_get_customConfig('smsuser');
        $ch = curl_init();
        $data = array('text' => $content, 'apikey' => $smsuser, 'mobile' => $phone);

        curl_setopt($ch, CURLOPT_URL, 'http://sms.yunpian.com/v2/sms/single_send.json');
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $json_data = curl_exec($ch);
        //解析返回结果（json格式字符串）
        $r = json_decode($json_data, true);

        if ($r['code'] == '0') {
            return 0;
        } else {
            return $r;
        }
    }


    /*
    	生成短信验证码内容并发送
		type:发送类型(如reg,findpass)
     */
    public function sendCode($mobile, $type)
    {
        $smstpl = array(
            'reg' => nl_get_customConfig('regsmstpl'),
            'findpass' => nl_get_customConfig('findpasstpl')
        );

        $code = rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9);
        $content = $smstpl[$type];
        $content = str_replace('{code}', $code, $content);
        $r = $this->sendSms($mobile, $content);
        if ($r == '0')
            $status = 1;
        else
            $status = 0;
        $arr = array(
            'type' => $type,
            'code' => $code,
            'mobile' => $mobile,
            'create_time' => time(),
            'status' => $status,
            'check' => 0
        );
        $this->add($arr);
        return $r;
    }

    /*
    生成审核成功/失败短信内容并发送
    type:发送类型(如success,fail)
    */
    public function sendReviewSms($mobile, $type, $bank_num = '0000')
    {
        $smstpl = array(
            'success' => nl_get_customConfig('successsmstpl'),
            'fail' => nl_get_customConfig('failsmstpl'),
            'cuishou' => nl_get_customConfig('cuishousmstpl'),
            'qunfa'=>nl_get_customConfig('qunfasmstpl')
        );
        $smsNo='';
        $content = $smstpl[$type];
        if ($type == 'success') {
            $code = 1111;
            //$content = $content;
        } elseif ($type == 'fail') {
            $code = 0000;
        } elseif ($type == 'cuishou') {
            $code = 2222;
            //$smsNo='SMS1657831067';
        }elseif ($type == 'qunfa'){
            $code = 3333;
            //$content = str_replace('{user}',$bank_num,$content);
        }

        $r = $this->sendSms($mobile, $content);
        if ($r == '0')
            $status = 1;
        else
            $status = 0;
        $arr = array(
            'type' => $type,
            'code' => $code,
            'mobile' => $mobile,
            'create_time' => time(),
            'status' => $status,
            'check' => 0
        );
        $this->add($arr);
        return $r;
    }

    /*
        检查验证码
        mobile:手机号
        code:验证码
     */
    public function checkCode($mobile, $code, $type)
    {
        $r = $this->where(array('mobile' => $mobile, 'code' => $code, 'type' => $type, 'check' => 0))->order("create_time Desc")->find();
        if (!$r) {
            return false;
        }
        $this->where(array('mobile' => $mobile, 'code' => $code, 'type' => $type))->save(array('check' => 1));
        return $r;
    }


}