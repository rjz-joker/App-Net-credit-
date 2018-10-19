<?php

namespace Home\Controller;

use Think\Controller;

class ZmxyController extends Controller
{

    //数据编码格式
    public $charset = "UTF-8";
    //芝麻分配给商户的 appId
    public $appId = "1002962";
    public $ras;
    public $curl;
    public $url = "https://zmopenapi.zmxy.com.cn/openapi.do?";

    function __construct()
    {
        parent::__construct();
        $this->ras = new RasController();
        $this->curl = new CurlController();
    }


    function index()
    {

        if (!empty($_GET['openid'])) {
            $zmxy = M('zmxy');

            $openid = $_GET['openid'];
            $request = $this->ZhimaCreditScoreGetRequest($openid);//芝麻信用评分

            $request = json_decode($request, true);
            $request['biz_response'] = $this->ras->rsaDecrypt($request['biz_response']);

            $zmf = $request['biz_response'];
            //echo $zmf;
            $zmf = json_decode($zmf, true);
            $info = (cookie('info'));
            $date = date("Y-m-d H:i:s");
            $data['type'] = '芝麻信用评分';
            $data['name'] = $info['name'];
            $data['carid'] = $info['carid'];
            $data['list'] = $zmf['zm_score'];
            $data['openid'] = $openid;
            $data['searchdate'] = $date;
            $data['mobile'] = $info['mobile'];

            $zm=D('zmxy')->where("mobile=$info[mobile]")->select();
            if($zm){
                $zmxy->where("id=".$zm[0][id])->save($data);
            }else{
                $zmxy->add($data);
            }

            $biz_no = $zmf['biz_no'];
            $hygz = $this->zhimacreditwatchlistiiget($openid);//行业关注名单2.0版

            $hygz = json_decode($hygz, true);

            $biz_response = $this->ras->rsaDecrypt($hygz['biz_response']);
            $biz_response = json_decode($biz_response, true);
            if ($biz_response['[is_matched'] == true) {
                $data['list'] = '命中';
            } else {
                $data['list'] = '未命中';
            }
            $data['type'] = '行业关注名单';

            if($zm){
			//	exit(var_dump($zm[0]['id']));
                $zmxy->where("id=".$zm[0]['id'])->save($data);
            }else{
                $zmxy->add($data);
            }

            $this->success('授权成功', U('Auth/index'));
        }
    }

    function ZhimaCreditScoreGetRequest($openid)
    {

        $app_id = $this->appId;
        $chrset = $this->charset;
        $method = "zhima.credit.score.get";
        $version = "1.0";
        $array = array(
            'transaction_id' => $this->transaction_id(),
            'product_code' => 'w1010100100000000001',
            'open_id' => $openid,
        );
        $buildQuery = $this->curl->buildQueryWithoutEncode($array);
        $params = urlencode($this->ras->rsaEncrypt($buildQuery));
        $sign = urlencode($this->ras->sign($buildQuery));

        $url = $this->url . "app_id=" . $this->appId . "&charset=" . $this->charset . "&method=" . $method . "&version=" . $version . "&platform=zmop&params=" . $params . "&sign=" . $sign;
        $request = $this->curl->curl($url);
        return $request;

    }

    function zhimacreditwatchlistiiget($openid)
    {//行业关注名单2.0版

        $app_id = $this->appId;
        $chrset = $this->charset;
        $method = "zhima.credit.watchlistii.get";
        $version = "1.0";
        $array = array(
            'transaction_id' => $this->transaction_id(),
            'product_code' => 'w1010100100000000022',
            'open_id' => $openid,
        );
        $buildQuery = $this->curl->buildQueryWithoutEncode($array);
        $params = urlencode($this->ras->rsaEncrypt($buildQuery));

        $sign = urlencode($this->ras->sign($buildQuery));

        $url = $this->url . "app_id=" . $this->appId . "&charset=" . $this->charset . "&method=" . $method . "&version=" . $version . "&platform=zmop&params=" . $params . "&sign=" . $sign;
        $request = $this->curl->curl($url);
        return $request;

    }

    function zhimacustomercertificationquery($name, $carid)
    {//芝麻认证查询

        $app_id = $this->appId;
        $chrset = $this->charset;
        $method = "zhima.customer.certification.query";
        $version = "1.0";
        $biz_no = $this->customer($name, $carid);
        $array = array(
            'biz_no' => $biz_no,
        );
        $buildQuery = $this->curl->buildQueryWithoutEncode($array);
        $params = urlencode($this->ras->rsaEncrypt($buildQuery));

        $sign = urlencode($this->ras->sign($buildQuery));

        $url = $this->url . "app_id=" . $this->appId . "&charset=" . $this->charset . "&method=" . $method . "&version=" . $version . "&platform=zmop&params=" . $params . "&sign=" . $sign;
        $request = $this->curl->curl($url);
        return $request;

    }

    function zhimacreditantifraudrisklist($carid, $name, $mobile)
    {//欺诈关注清单

        $app_id = $this->appId;
        $chrset = $this->charset;
        $method = "zhima.credit.antifraud.risk.list";
        $version = "1.0";
        $array = array(
            'transaction_id' => $this->transaction_id(),
            'product_code' => 'w1010100003000001283',
            'cert_type' => 'IDENTITY_CARD',
            'cert_no' => $carid,
            'name' => $name,
            'mobile' => $mobile
        );
        $buildQuery = $this->curl->buildQueryWithoutEncode($array);
        $params = urlencode($this->ras->rsaEncrypt($buildQuery));

        $sign = urlencode($this->ras->sign($buildQuery));

        $url = $this->url . "app_id=" . $this->appId . "&charset=" . $this->charset . "&method=" . $method . "&version=" . $version . "&platform=zmop&params=" . $params . "&sign=" . $sign;
        $request = $this->curl->curl($url);
        return $request;

    }

    function zhimacreditantifraudverify($carid, $name, $mobile)
    {//欺诈信息验证

        $app_id = $this->appId;
        $chrset = $this->charset;
        $method = "zhima.credit.antifraud.verify";
        $version = "1.0";
        $array = array(
            'transaction_id' => $this->transaction_id(),
            'product_code' => 'w1010100000000002859',
            'cert_type' => 'IDENTITY_CARD',
            'cert_no' => $carid,
            'name' => $name,
            'mobile' => $mobile
        );
        $buildQuery = $this->curl->buildQueryWithoutEncode($array);
        $params = urlencode($this->ras->rsaEncrypt($buildQuery));

        $sign = urlencode($this->ras->sign($buildQuery));

        $url = $this->url . "app_id=" . $this->appId . "&charset=" . $this->charset . "&method=" . $method . "&version=" . $version . "&platform=zmop&params=" . $params . "&sign=" . $sign;
        $request = $this->curl->curl($url);
        return $request;

    }

    function zhimacreditantifraudscoreget($carid, $name, $mobile)
    {//申请欺诈评分

        $app_id = $this->appId;
        $chrset = $this->charset;
        $method = "zhima.credit.antifraud.score.get";
        $version = "1.0";
        $array = array(
            'transaction_id' => $this->transaction_id(),
            'product_code' => 'w1010100003000001100',
            'cert_type' => 'IDENTITY_CARD',
            'cert_no' => $carid,
            'name' => $name,
            'mobile' => $mobile
        );
        $buildQuery = $this->curl->buildQueryWithoutEncode($array);
        $params = urlencode($this->ras->rsaEncrypt($buildQuery));

        $sign = urlencode($this->ras->sign($buildQuery));

        $url = $this->url . "app_id=" . $this->appId . "&charset=" . $this->charset . "&method=" . $method . "&version=" . $version . "&platform=zmop&params=" . $params . "&sign=" . $sign;
        $request = $this->curl->curl($url);
        return $request;

    }

    function transaction_id()
    {
        $one = date("Ymdhis");
        $two = '';
        for ($i = 0; $i < 16; $i++) {
            $two .= rand(0, 9);
        }
        $str = $one . $two;

        return $str;
    }


    /**
     * 芝麻认证
     */
    function auth()
    {

        if (IS_POST) {



            header("Content-type: text/html; charset=utf-8");
            $name = I('post.name');
            $carid = I('post.carid');
            $mobile = I('post.mobile');
            $cookie = array(
                'name' => $name,
                'carid' => $carid,
                'mobile' => $mobile
            );
            cookie('info', $cookie);/**/
            $app_id = $this->appId;
            $charset = $this->charset;
            $method = "zhima.auth.info.authorize";
            $version = "1.0";
            $array = array(
                'identity_type' => '2',
                'identity_param' => '{"name":"' . $name . '","certType":"IDENTITY_CARD","certNo":"' . $carid . '"}',
                'biz_params' => '{"auth_code":"M_H5","channelType":"apppc","state":"' . $this->transaction_id() . '"}',
            );
            $buildQuery = $this->curl->buildQueryWithoutEncode($array);

//            $buildQuery=json_encode($buildQuery);

            $params = urlencode($this->ras->rsaEncrypt($buildQuery));

            $sign = urlencode($this->ras->sign($buildQuery));

            $url = "https://zmopenapi.zmxy.com.cn/openapi.do?" . "app_id=" . $app_id . "&charset=" . $charset . "&method=" . $method . "&version=" . $version . "&params=" . $params . "&sign=" . $sign;

            header("location:" . $url);

        } else {

            $user_info = getLoginUser();
            $idcard_info = D('auth_idcard')->where("uid=$user_info[id]")->find();

            $this->assign("user", $user_info);
            $this->assign("idcard", $idcard_info);
            $this->display();
        }

    }


    function callback()
    {
        if (!empty($_GET['params'])) {
            $params = $_GET['params'];

            $sign = $_GET['sign'];

            $params = $this->ras->rsaDecrypt($params);
            $verify = $this->ras->verify($params, $sign);//验签
            $params = explode('&', $params);
            foreach ($params as $key => $value) {
                $array[$key] = explode('=', $value);
            }
            foreach ($array as $key => $value) {

                $arr[$key] = array($value[0] => urldecode($value[1]));

            }

            foreach ($arr as $key => $value) {
                if ($value['success'] == "true") {
                    $a = 1;
                }
            }
            if ($a) {
                foreach ($arr as $k => $v) {
                    if ($v['open_id']) {
                        header("location:" . C('site_url') . "Home/Zmxy/index/openid/" . $v['open_id']);
                    }
                }
            } else {
                header("location:" . C('site_url') . "/Home/Zmxy/auth");
            }

        }

    }


    function customer($name = '', $carid = '')
    {
        //if($_POST['submit']){
        //$name=$_POST['name'];
        //$carid=$_POST['carid'];
        /*$cookie=array(
            'name'=>$name,
            'carid'=>$carid,
            'mobile'=>$_POST['mobile']
        );*/
        //cookie('info',$cookie);
        $app_id = $this->appId;
        $chrset = $this->charset;
        $method = "zhima.customer.certification.initialize";
        $version = "1.0";
        $array = array(
            'transaction_id' => $this->transaction_id(),
            'product_code' => 'w1010100000000002978',
            'biz_code' => 'FACE',
            'identity_param' => '{"identity_type":"CERT_INFO","cert_type":"IDENTITY_CARD","cert_name":"' . $name . '","cert_no":"' . $carid . '"} ',
            'ext_biz_param' => '{}'
        );
        $buildQuery = $this->curl->buildQueryWithoutEncode($array);
        //echo $buildQuery;
        $params = urlencode($this->ras->rsaEncrypt($buildQuery));

        $sign = urlencode($this->ras->sign($buildQuery));

        $url = "https://zmopenapi.zmxy.com.cn/openapi.do?" . "app_id=" . $this->appId . "&charset=" . $this->charset . "&method=" . $method . "&version=" . $version . "&params=" . $params . "&sign=" . $sign;
        //print_r($url);
        //header("location:".$url);
        $request = $this->curl->curl($url);
        $request = json_decode($request, true);
        $biz_response = $this->ras->rsaDecrypt($request['biz_response']);
        $biz_response = json_decode($biz_response, true);
        return $biz_response['biz_no'];
        //print_r($biz_response);
        //}
        //$this->display();
    }

    function xieyi()
    {
        $this->display();
    }
}