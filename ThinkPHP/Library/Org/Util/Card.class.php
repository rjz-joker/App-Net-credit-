<?php
namespace Org\Util;
/*
    生成唯一用户卡号
 */
class Card{

    /**
     * 根据id获取一个随机唯一编码
     * @param $id 编号
     * @param int $prefix 前缀
     * @param int $width 除前缀外长度
     * @return string
     */
    public function generateNumber($id=1,$prefix=62){
        $str = '';
        $timestr = date("Y");
        $str .= substr($timestr,2);
        $timestr = date("m");
        $str .= $timestr;
        $timestr = date("d");
        $str .= substr($timestr,1);
        $str .= substr(time(),-1);
        $str .= rand(0,9);
        $timestr = date("H");
        $str .= $timestr;
        $timestr = date("s");
        $str .= substr($timestr,-1);
        $str .= '0000';
        //17 0349 5219 0000
        $card = $prefix . (string)($str + $id);
        return $card;
    }
}