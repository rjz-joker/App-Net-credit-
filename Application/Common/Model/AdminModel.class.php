<?php
namespace Common\Model;
/*
 *      后台用户模型
 * */
class AdminModel extends \Think\Model {

    /*
     *  生成加密后的密码
     * */
    public function getPass($str){
        $str = sha1(md5(md5($str).C('auth_code')));
        return strtoupper($str);
    }


}