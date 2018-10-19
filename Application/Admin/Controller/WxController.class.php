<?php

namespace Admin\Controller;

use Think\Controller;

/**
 *
 * 获取用户openid类
 * 该类实现了从微信公众平台获取code、通过code获取openid和access_token
 *
 */
class WxController extends Controller
{

    public static $access_token = array();
    private static $appId = '';
    private static $appSecrt = '';
    public static $access_error = '';
    private static $file = 'access_token.json';
    public static $userInfoError = '';
    public static $openid = '';

    public function _initialize()
    {
        self::$appId = nl_get_customConfig("appId");
        self::$appSecrt = nl_get_customConfig("appSecret");
    }

    /**
     * [getOpenId 获取用户OPENID]
     * @return [type] [description]
     */
    public function getOpenId()
    {
        if (!isset($_GET['code'])) {
            //如果没有收到CODE返回值，就发送请求
            $baseUrl = urlencode('http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'] . '?' . $_SERVER['QUERY_STRING']);
            $url = self::PingUrl($baseUrl);
            header("location:$url");
            exit;
        } else {
            $code = $_GET['code'];
            $openid = self::caretFrom($code);
            return $openid;
        }
    }

    /**
     * [getUserInfo 获取用户信息]
     * @param  string $openid [description]
     * @return [array]         [description]
     */
    public function getUserInfo($openid = '')
    {
        if ($openid == '') {
            $openid = $this->getOpenId();
        }
        $url['access_token'] = self::getToken();
        $url['openid'] = $openid;
        $url['lang'] = 'zh_CN';
        $newurl = self::ToUrlParams($url);
        $baseUrl = "https://api.weixin.qq.com/cgi-bin/user/info?" . $newurl;
        $data = self::https_post($baseUrl);
        $data = json_decode($data, true);
        if (!isset($data['errcode']) && $data['openid'] != '') {
            return $data;
        } else {
            self::$userInfoError = 'ERRORCODE:' . $data['errcode'] . ',errmsg:' . $data['errmsg'];
            return FALSE;
        }
    }

    /**
     * [getToken 获取access_token]
     * @return [type] [description]
     */
    public static function getToken()
    {
        $token = json_decode(self::get_file(), true);
        if ($token['expires_time'] < time()) {
            $access_token = self::accessToken();
        } else {
            $access_token = $token;
        }
        return $access_token['access_token'];
    }

    /**
     * [accessToken 生成accountToken]
     * @return [array] [返回 $access_token['access_token'] $access_token['expires_time']]
     */
    private static function accessToken()
    {
        $url['grant_type'] = 'client_credential';
        $url['appid'] = self::$appId;
        $url['secret'] = self::$appSecrt;
        $newurl = self::ToUrlParams($url);
        $baseUrl = 'https://api.weixin.qq.com/cgi-bin/token?' . $newurl;
        $data = self::https_post($baseUrl);
        $data = json_decode($data, true);
        if ($data['access_token'] != '') {
            $access_token['access_token'] = $data['access_token'];
            $access_token['expires_time'] = time() + 7200;
            self::$access_token = $access_token;
            self::set_file(json_encode($access_token));
            return $access_token;
        } else {
            self::$access_error = "ERRORCODE:" . $data['errcode'] . ',errmsg:' . $data['errmsg'];
            return FALSE;
        }
    }

    //审核成功推送
    public function sendSuccessTemplate($template_id,$open_id)
    {
        $access_token = self::getToken();
        $template = array(
            'touser' => $open_id,
            'template_id' => $template_id,
            'url' => C("site_url"),
            'topcolor' => "#7B68EE",
            'data' => array(
                'first' => array('value' => urlencode("恭喜您申请审核通过"), 'color' => "#FF0000"),
                'keyword1' => array('value' => urlencode("审核通过！"), 'color' => '#FF0000'),
                'keyword2' => array('value' => urlencode(date("Y-m-d H:i:s")), 'color' => '#FF0000'),
                'remark' => array('value' => urlencode('感谢您的支持！'), 'color' => '#FF0000'),)
        );
        $json_template = json_encode($template);
        $url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=" . $access_token;
        $res = self::https_post($url, urldecode($json_template));
        return $res;
    }

    //审核失败推送
    public function sendErrorTemplate($template_id,$open_id)
    {
        $access_token = self::getToken();
        $template = array(
            'touser' => $open_id,
            'template_id' => $template_id,
            'url' => C("site_url"),
            'topcolor' => "#7B68EE",
            'data' => array(
                'first' => array('value' => urlencode("很遗憾，您的申请未通过"), 'color' => "#FF0000"),
                'keyword1' => array('value' => urlencode("您的资料不符合申请条件"), 'color' => '#FF0000'),
                'keyword2' => array('value' => urlencode('这是测试'), 'color' => '#FF0000'),
                'remark' => array('value' => urlencode('感谢您的支持'), 'color' => '#FF0000'),)
        );
        $json_template = json_encode($template);
        $url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=" . $access_token;
        $res = self::https_post($url, urldecode($json_template));
        return $res;
    }


    /**
     * [get_file 读取文件缓存]
     * @param  string $file [description]
     * @return [type]       [description]
     */
    private static function get_file($file = '')
    {
        if ($file == '') {
            $file = self::$file;
        }
        return trim(file_get_contents($file));
    }

    /**
     * [set_file_put 写入文件缓存]
     * @param [type] $data [description]
     */
    private static function set_file($data)
    {
        $file = self::$file;
        $fp = fopen($file, 'w');
        fwrite($fp, $data);
        fclose($fp);
    }

    /**
     * [PingUrl 重组URL]
     * @param [string] $baseUrl [当前网址]
     * return string  返回发送的跳转的网址
     */
    public static function PingUrl($baseUrl)
    {
        $url['appid'] = self::$appId;
        $url['redirect_uri'] = $baseUrl;
        $url['response_type'] = 'code';
        $url['scope'] = 'snsapi_userinfo';     //snsapi_base 只获取用户openid  snsapi_userinfo 弹出授权窗口 可获取用户地区 性别 昵称等信息
        $url['state'] = "STATE" . "#wechat_redirect";
        $newsUrl = self::ToUrlParams($url);
        return "https://open.weixin.qq.com/connect/oauth2/authorize?" . $newsUrl;
    }

    /**
     * [caretFrom 重组获取用户ID所需的参数]
     * @param  [string] $code [返回的code参数]
     * @return [string]       [用户openid]
     */
    public static function caretFrom($code)
    {
        $data['appid'] = self::$appId;
        $data['secret'] = self::$appSecrt;
        $data['code'] = $code;
        $data['grant_type'] = 'authorization_code';
        $newString = self::ToUrlParams($data);
        return self::SendFrom($newString);
    }

    /**
     * [SendFrom 获取opnid]
     * @param [string] $str [description]
     */
    private static function SendFrom($str)
    {
        $url = "https://api.weixin.qq.com/sns/oauth2/access_token?" . $str;
        $data = self::https_post($url);
        $data = json_decode($data, true);
        self::$openid = $data['openid'];
        return $data['openid'];
    }

    /**
     * [https_post POST OR GET发送]
     * @param  [string] $url  [接口地址]
     * @param  [array] $data [接口数据]
     * @return [json]       []
     */
    private static function https_post($url, $data = null)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        //添加
       // curl_setopt($curl, CURLOPT_REFERER, "http://www.baidu.com");  //构造来路
        //结束
        if (!empty($data)) {
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        }
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($curl);
        curl_close($curl);
        return $output;
    }

    /**
     * [ToUrlParams 重组url参数]
     * @param [array] $data [需要重组的数组]
     */
    protected static function ToUrlParams($data)
    {
        $url = "";
        foreach ($data as $key => $value) {
            $url .= $key . "=" . $value . "&";
        }
        $url = trim($url, "&");
        return $url;
    }

}