<?php

namespace Admin\Controller;

use Think\Auth;
use Think\Controller;

class PublicController extends Controller
{
    /*
     *  后台公共验证
     * */
    public function _initialize()
    {

        if (session(C('LOGIN_AUTH_KEY')) != C('LOGIN_AUTH_VAL')) {
            $this->error("页面不存在!", U('Home/Index/index'));
        }
        if (MODULE_NAME != "Public" && !$this->is_Login()) {
            $this->error("您还没有登录,请先登录!", U('Login/index'), 2);
        }

        #权限控制
        $arr = session(C('ADMIN_INFO'));
        $auth = new Auth();
        $rule_name = MODULE_NAME . '/' . CONTROLLER_NAME . '/' . ACTION_NAME;

        if ($arr['username'] != 'admin') {        //admin管理员无视所有权限
            $result = $auth->check($rule_name, $arr['id']);
            if (!$result) {
                $this->error('您没有权限访问');
            }

        }

    }

    //无操作 登出超时
    public function over(){
        session(C("ADMIN_INFO"),null);
        session("login_time",null);
        $this->error("操作超时,请重新登录!",U('Login/index'));
    }


    /*
     *  用户注销
     * */
    public function lock()
    {
        session(C("ADMIN_INFO"), null);
        $this->success("您已成功退出登录!", U('Login/index'), 3);
    }


    /*
     *  验证后台用户是否登录
     * */
    public function is_Login()
    {
        $admin = session(C("ADMIN_INFO"));
        return empty($admin) ? false : true;
    }


    /*
    * 导出Excel表格
    * @param $data 下载的数据
    * @param $keynames 下载的字段及标题，可执行函数。如array('id'=>'编号','time|date("Y-m-d",###)'=>'时间')
    * @param $filename 保存的文字名
    * @param bool $saveAs，如果为false则保存在服务器
    * @param string $title 表头
    */
    function aliziExcel($data, $keynames, $filename, $saveAs = true, $title = '')
    {
        import("ORG.PHPExcel.PHPExcel");
        $objExcel = new \PHPExcel();
        //标题
        $chars = 'A';
        $num = 1;
        if ($title) {
            $objExcel->getActiveSheet()->setCellValue($chars . $num, $title);
            $num++;
            $i = 1;
        }
        foreach ($keynames as $key => $va) {
            $objExcel->getActiveSheet()->setCellValueExplicit($chars . $num, "$va", \PHPExcel_Cell_DataType::TYPE_STRING);
            $objExcel->getActiveSheet()->getColumnDimension($chars)->setWidth(20);  // 高置列的宽度
            $chars++;
        }

        foreach ($data as $key => $o) {
            $char = 'a';
            $u1 = $i + 2;

            foreach ($keynames as $k => $v) {
                if (strpos($k, '||')) {
                    $arr = explode('||', $k);
                    $_str = is_null($o[$arr[0]]) ? 'null' : $o[$arr[0]];
                    $eval = str_replace('###', $_str, $arr[1]);
                    $rs = '';
                    eval("$rs = $eval;");
                    $line = $rs;
                } elseif (strpos($k, '##')) {
                    $arr = explode('##', $k);
                    $data = json_decode($arr[1], true);
                    $line = $data[$o[$arr[0]]];
                } else {
                    $line = $o[$k];
                }

                $objExcel->getActiveSheet()->setCellValueExplicit($char . $u1, $line, \PHPExcel_Cell_DataType::TYPE_STRING);
                $objExcel->getDefaultStyle()->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);//左对齐
                $char++;
            }
            $i++;
        }

        $objExcel->getActiveSheet()->getHeaderFooter()->setOddHeader('&L&BPersonal cash register&RPrinted on &D');
        $objExcel->getActiveSheet()->getHeaderFooter()->setOddFooter('&L&B' . $objExcel->getProperties()->getTitle() . '&RPage &P of &N');

        // 设置页方向和规模
        $objExcel->getActiveSheet()->getPageSetup()->setOrientation(\PHPExcel_Worksheet_PageSetup::ORIENTATION_PORTRAIT);
        $objExcel->getActiveSheet()->getPageSetup()->setPaperSize(\PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);
        $objExcel->setActiveSheetIndex(0);
        if ($ex == '2007') {
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
            header('Cache-Control: max-age=0');
            $objWriter = \PHPExcel_IOFactory::createWriter($objExcel, 'Excel2007');
            $objWriter->save('php://output');
            exit;
        } else {  //导出excel2003文档

            if ($saveAs == false) {
                $objWriter = \PHPExcel_IOFactory::createWriter($objExcel, 'Excel5');
                $objWriter->save($filename . '.xls');
            } else {
                header('Content-Type: application/vnd.ms-excel');
                header('Content-Disposition: attachment;filename="' . $filename . '.xls"');
                header('Cache-Control: max-age=0');
                $objWriter = \PHPExcel_IOFactory::createWriter($objExcel, 'Excel5');
                $objWriter->save('php://output');
                exit;
            }

        }
    }


}