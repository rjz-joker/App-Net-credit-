<?php

namespace Common\Model;

/*
 *  后台菜单模型
 * */
use Think\Model;
header("Content-type: text/html; charset=utf-8");
class MenuModel extends Model
{

    /*
     *  组建用户组权限内的菜单
     * */
    public function getMenu()
    {
        $menu = $this->where(array('pid' => 0,'status'=>1))->order("sort")->select();

        for ($n = 0; $n < count($menu); $n++) {
            $val = $menu[$n];
            $tmp = $this->where(array('pid' => $val['id'], 'status' => 1))->order("pid,sort")->select();
            if ($tmp) {
                for ($i = 0; $i < count($tmp); $i++) {
                    $tmp[$i]['href'] = U($tmp[$i]['href']);
                }
                $val['children'] = $tmp;
            } else {
                $val['href'] = U($val['href']);
            }
            $menu[$n] = $val;
        }
        return $menu;
    }


}