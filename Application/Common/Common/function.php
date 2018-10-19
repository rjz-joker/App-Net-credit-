<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/2/11 0011
 * Time: 23:30
 *  公共函数库
 */

//对象转数组
function object_to_array($obj){
    $_arr = is_object($obj) ? get_object_vars($obj) :$obj;
    foreach ($_arr as $key=>$val){
        $val = (is_array($val) || is_object($val)) ? object_to_array($val):$val;
        $arr[$key] = $val;
    }
    return $arr;
}

//循环删除目录和文件函数
function delDirAndFile( $dirName ){
    if ( $handle = opendir( "$dirName" ) ) {
        while ( false != ( $item = readdir( $handle ) ) ) {
            if ( $item != "." && $item != ".." ) {
                if ( is_dir( "$dirName/$item" ) ) {
                    delDirAndFile( "$dirName/$item" );
                } else {
                    unlink( "$dirName/$item");
                }
            }
        }
        closedir( $handle );
        rmdir( $dirName );
    }
}

function getBorrowStatus($status){
	switch ($status)
		{
		case 0:
		  return '等待审核';
		  break;  
		case 1:
		  return '等待还款';
		  break;
		case 2:
		  return '已拒绝';
		  break;
		 case 4:
		  return '还款完成';
		  break;
		 case 5:
		  return '等待打款';
		  break;
		}

}

//获取一个文件夹下文件/文件夹列表
function nl_getFoderlist($dir,$foder = false){
    $arr = array();
    if(is_dir($dir)){
        if($dh = opendir($dir)){
            while(($file = readdir($dh)) != false){
                if($file != "." && $file != ".."){
                    if(!$foder){
                        $arr[] = $file;
                    }else{
                        if(is_dir($dir.$file)){
                            $arr[] = $file;
                        }
                    }
                }
            }
            closedir($dh);
        }
    }
    return $arr;
}


//获取自定义配置内容
function nl_get_customConfig($key){
    $data['k'] = trim($key);
    if(!$key)
        return '';
    $arr = D('Setting')->where($data)->find();
    if(!$arr)
        return '';
    return $arr['val'];
}

/**
 * @param $data
 * @param int $pid
 * @return array    创建菜单树
 */
function createTree($data ,$pid=0){
    static $treeList=array();
    foreach ($data as $key=>$value) {
        if($value['pid'] == $pid){
            $treeList[] = $value;
            unset($data[$key]);
            createTree($data,$value['id']);
        }
    }
    return $treeList;
}



/**
 * [nl_writeArr 写入配置文件方法]
 * @param  [type] $arr      [要写入的数据]
 * @param  [type] $filename [文件路径]
 * @return [type]           [description]
 */
function nl_writeArr($arr, $filename) {
    return file_put_contents($filename, "<?php\r\nreturn " . var_export($arr, true) . ";");
}

/**
 * [nl_updateArr 更新配置文件方法]
 * @param  [type] $arr      [要更新的数据]
 * @param  [type] $filename [文件路径]
 * @return [type]           [description]
 */
function nl_updateArr($arr, $filename) {
    $file = include $filename;
    $res = array_merge($file, $arr);
    return nl_writeArr($res,$filename);
}

//判断是否为移动设备访问
function ismobile() {
    // 如果有HTTP_X_WAP_PROFILE则一定是移动设备
    if (isset ($_SERVER['HTTP_X_WAP_PROFILE']))
        return true;
    //此条摘自TPM智能切换模板引擎，适合TPM开发
    if(isset ($_SERVER['HTTP_CLIENT']) &&'PhoneClient'==$_SERVER['HTTP_CLIENT'])
        return true;
    //如果via信息含有wap则一定是移动设备,部分服务商会屏蔽该信息
    if (isset ($_SERVER['HTTP_VIA']))
        //找不到为flase,否则为true
        return stristr($_SERVER['HTTP_VIA'], 'wap') ? true : false;
    //判断手机发送的客户端标志,兼容性有待提高
    if (isset ($_SERVER['HTTP_USER_AGENT'])) {
        $clientkeywords = array(
            'nokia','sony','ericsson','mot','samsung','htc','sgh','lg','sharp','sie-','philips','panasonic','alcatel','lenovo','iphone','ipod','blackberry','meizu','android','netfront','symbian','ucweb','windowsce','palm','operamini','operamobi','openwave','nexusone','cldc','midp','wap','mobile'
        );
        //从HTTP_USER_AGENT中查找手机浏览器的关键字
        if (preg_match("/(" . implode('|', $clientkeywords) . ")/i", strtolower($_SERVER['HTTP_USER_AGENT']))) {
            return true;
        }
    }
    //协议法，因为有可能不准确，放到最后判断
    if (isset ($_SERVER['HTTP_ACCEPT'])) {
        // 如果只支持wml并且不支持html那一定是移动设备
        // 如果支持wml和html但是wml在html之前则是移动设备
        if ((strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') != false) && (strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false || (strpos($_SERVER['HTTP_ACCEPT'], 'vnd.wap.wml') < strpos($_SERVER['HTTP_ACCEPT'], 'text/html')))) {
            return true;
        }
    }
    return false;
}

/** 
* QQ号等或手机号中加星号掩码，保护隐私 
* @param    num     $num        QQ号或者手机号 
* @param    num     $star_num   添加星星个数
* @return   string              返回添加了星号后的QQ号或者手机号 
* @author   shuiguang  
*/   
function mask_number($num, $star_num = 4)  
{  
    $star_num = $star_num > strlen($num) ? strlen($num)-2 : (int)$star_num;
    if($star_num % 2 == 0)  
    {  
        $star_left = $star_right = $star_num/2;  
    }else{  
        $star_left = floor($star_num/2);  
        $star_right = $star_num - $star_left;  
    }  
    $len = strlen($num);  
    $left = floor($len/2)-$star_left;  
    $right = round($len/2)-$star_right;  
    $middle = $len - $left - $right;  
    $result = substr($num, 0, $left).str_repeat("*", $middle).substr($num, $left+$middle, $right);  
    return $result;  
}


//-----------------------------------------------------

//生成纯数字
function getNumStr($lenth = 1){
    $str = '';
    for ($i=0; $i < $lenth; $i++) { 
        $str .= rand(0,9);
    }
    return $str;
}
//加密会员密码
function getPass2User($str = ''){
    return sha1(md5($str));
}
//判断手机号格式
function isMobileNum($num){
    if (!is_numeric($num)){
        return false;
    }
    $t = preg_match('#^13[\d]{9}$|^14[5,7]{1}\d{8}$|^15[\d]{9}$|^17[\d]{9}$|^18[\d]{9}$#',$num);
    return $t?true:false;
}
/********************php验证身份证号码是否正确函数*********************/
function isIdcard( $id ){ 
      $id = strtoupper($id); 
      $regx = "/(^\d{15}$)|(^\d{17}([0-9]|X)$)/"; 
      $arr_split = array(); 
      if(!preg_match($regx, $id)) 
      { 
        return FALSE; 
      } 
      if(15==strlen($id)) //检查15位 
      { 
        $regx = "/^(\d{6})+(\d{2})+(\d{2})+(\d{2})+(\d{3})$/"; 
        @preg_match($regx, $id, $arr_split); 
		return true;
      } 
      else      //检查18位 
      { 
        $regx = "/^(\d{6})+(\d{4})+(\d{2})+(\d{2})+(\d{3})([0-9]|X)$/"; 
        @preg_match($regx, $id, $arr_split); 
        $dtm_birth = $arr_split[2] . '/' . $arr_split[3]. '/' .$arr_split[4]; 
        if(!strtotime($dtm_birth)) //检查生日日期是否正确 
        { 
          return FALSE; 
        } 
        else
        { 
			return true;
        } 
      } 
}


function https_curl($url,$data=null){
    // 初始化一个 cURL 对象
    $curl = curl_init();
    // 设置你需要抓取的URL
    curl_setopt($curl, CURLOPT_URL,$url);
    //必须加这个，不加不好使（不多加解释，东西太多了）
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);//对认证证书进行检验
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    if (!empty($data)){//post方式，否则是get方式
        //设置模拟post方式
        curl_setopt($curl,CURLOPT_POST,1);
        //传数据，get方式是直接在地址栏传的，这是post传参的解决方式
        curl_setopt($curl,CURLOPT_POSTFIELDS,$data);//$data可以是数组，json
    }
    // 设置cURL 参数，要求结果保存到字符串中还是输出到屏幕上。1是保存，0是输出
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    // 运行cURL，请求网页
    $output = curl_exec($curl);
    // 关闭URL请求
    curl_close($curl);
    return $output;
}





function isbank_ture($key,$bankcard,$realname,$cardno,$mobile){
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => "http://v.apistore.cn/api/v4/verifybankcard4?key=".$key."&bankcard=".$bankcard."&realName=".$realname."&cardNo=".$cardno."&mobile=".$mobile,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
    ));
    $response = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);
    if ($err) {
        return "cURL Error #:" . $err;
    } else {
        return $response;
    }
}


function isidcard_ture($key,$cardno,$realname){
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => "http://v.apistore.cn/api/v4/idcard?key=".$key."&cardNo=".$cardno."&realName=".$realname,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
        return "cURL Error #:" . $err;
    } else {
        return $response;
    }

}


//获取综合风险信息
function getDanger($key,$cardno,$realname){
    $curl = curl_init();
    curl_setopt_array($curl, array(
        CURLOPT_URL => "http://v.apistore.cn/api/c109/all?key=".$key."&realName=".$realname."&cardNo=".$cardno."&bankcard=&moblie=&mac=&ip=",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
        return "cURL Error #:" . $err;
    } else {
        return $response;
    }

}



/**
 * 获取排序后的分类
 * @param  [type]  $data  [description]
 * @param  integer $pid   [description]
 * @param  string  $html  [description]
 * @param  integer $level [description]
 * @return [type]         [description]
 */
function getSortedCategory($data,$pid=0,$html="|---",$level=0)
{
    $temp = array();
    foreach ($data as $k => $v) {
        if($v['pid'] == $pid){
            $str = str_repeat($html, $level);
            $v['html'] = $str;
            $temp[] = $v;

            $temp = array_merge($temp,getSortedCategory($data,$v['id'],'|---',$level+1));
        }

    }
    return $temp;
}

