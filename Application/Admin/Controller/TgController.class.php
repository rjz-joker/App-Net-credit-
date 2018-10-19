<?php
namespace Admin\Controller;

//我要推广
class TgController extends PublicController {


	public function index(){
        add_log(getAdminId(),CONTROLLER_NAME.'/'.ACTION_NAME,'点击进入二维码页');
	    $admin = nl_get_adminuser();
        $ym=C("site_url");
        //set it to writable location, a place for temp generated PNG files
        $PNG_TEMP_DIR = VENDOR_PATH.'phpqrcode/temp/';

        //html PNG location prefix
        $PNG_WEB_DIR = 'Public/temp/';

        vendor("phpqrcode.qrlib");

        //ofcourse we need rights to create temp dir
        if (!file_exists($PNG_TEMP_DIR))
            mkdir($PNG_TEMP_DIR);

        if (!file_exists($PNG_WEB_DIR))
            mkdir($PNG_WEB_DIR);


        $filename = $PNG_TEMP_DIR.'test.png';

        //processing form input
        //remember to sanitize user input in real-life solution !!!
        $errorCorrectionLevel = 'L';
        if (isset($_REQUEST['level']) && in_array($_REQUEST['level'], array('L','M','Q','H')))
            $errorCorrectionLevel = $_REQUEST['level'];

        $matrixPointSize = 8;
        if (isset($_REQUEST['size']))
            $matrixPointSize = min(max((int)$_REQUEST['size'], 1), 10);


        if (isset($admin)) {
            //it's very important!
            if (trim($admin['recommend']) == '')
                die('data cannot be empty! <a href="?">未填写推荐码</a>');

            // user data
            $filename = $PNG_WEB_DIR.'wnbzd_'.$admin['recommend'].'.png';

            \QRcode::png($ym."Home/User/reg/recommend/$admin[recommend]", $filename, $errorCorrectionLevel, $matrixPointSize, 2);

        } else {
            echo 'You can provide data in GET parameter: <a href="?data=like_that"></a><hr/>';
            \QRcode::png('http://www.baidu.com', $filename, $errorCorrectionLevel, $matrixPointSize, 2);

        }
        $this->assign('tg',basename($filename));
        $this->display();
	}




}