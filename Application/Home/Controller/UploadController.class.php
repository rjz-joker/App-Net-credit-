<?php

namespace Home\Controller;

use Think\Controller;
use Think\Upload;
use Think\Image;
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/2/18 0018
 * Time: 21:48
 *  公共文件上传控制器
 */
class UploadController extends Controller
{

    public function index()
    {
        $user_info = getLoginUser();
        $file_name = empty($_GET['n']) ? 'file' : $_GET['n'];

        if ($file_name && is_uploaded_file($_FILES[$file_name]["tmp_name"])) {
            $upload = new Upload();
            $maxSize = C('upload_maxsize');
            $maxSize = empty($maxSize) ? 2048 : intval($maxSize);
            $extensions = C('upload_extensions');
            $extensions = empty($extensions) ? '' : $extensions;
            $tmp = explode(',', $extensions);
            $exts = array();
            foreach ($tmp as $val) {
                $exts[] = $val;
            }
            $upload->maxSize = intval($maxSize) * 10240;//字节单位
            $upload->exts = $exts;
            $upload->savePath = '/';//设置附件上传目录
            $upload->subName = array('date', 'Y_m_d');
            $info = $upload->upload();

            if (!$info) {
                //上传错误提示错误信息
                $msg = $upload->getError();
            } else {
                //上传成功 获取上传文件信息
                $site_url = C('site_url');
                $info = reset($info);
                $info['url'] = '/Uploads' . $info['savepath'] . $info['savename'];
                $msg = "success";

				$image = new Image();
                $image->open('.'.$info['url']);
                $image->thumb(800,500)->save('.'.$info['url']);

            }

        } else {
            $msg = "没有选择文件!";
        }
        if ($msg == 'success') {
            //身份证正面,调用接口
            if($file_name=='p_photo_face'){
                //连连云慧眼
                $pubkey=nl_get_customConfig('pubkey');
                $secretkey=nl_get_customConfig('secretkey');
                $sign_time = date("YmdHis",time());
                $partner_order_id = $sign_time.$user_info['id'];
                $signStr=sprintf("pub_key=%s|partner_order_id=%s|sign_time=%s|security_key=%s", $pubkey, $partner_order_id, $sign_time, $secretkey);
                $signature=md5($signStr);
                //1.6.1 身份证正面OCR识别接口 服务接口地址： https://idsafe-auth.udcredit.com/front/4.3/api/idcard_front_photo_ocr/pub_key/{pub_key}, 其中{pubkey}为商户开户时提供给商户的公钥；
                $photo_face_url="https://idsafe-auth.udcredit.com/front/4.3/api/idcard_front_photo_ocr/pub_key/$pubkey";
                $p_face1=mb_substr($info['url'],1);
                $post_face_data = array(
                    'header'=>array(
                        'partner_order_id'=>$partner_order_id ,
                        'sign'=>$signature,
                        'sign_time'=>$sign_time
                    ),
                    'body'=>array(
                        'idcard_front_photo'=>base64_encode(file_get_contents($p_face1))
                    )
                );
                $photo_face_res = $this->http_post($photo_face_url,$post_face_data);
				file_put_contents('filelog.txt',$photo_face_res['result']['message']);
                //正面出错
                if(!$photo_face_res['result']['success']){
                    //$this->error('人像面不符,请重传。'.$photo_face_res['result']['message'].'code:'.$photo_face_res['result']['errorcode']);
					$this->error('人像面不符,请重传。'.$photo_face_res['result']['message'].'code:'.$photo_face_res['result']['errorcode'],'',true);
                }

                session('photo_session_data',$photo_face_res);
                $info['res_data']=$photo_face_res['data'];
            }

            $this->success($info, '', true);
        }
        $this->error($msg, '', true);

    }


    public function http_post($url,$post_data){
        $headers[] = 'Content-Type: application/json;charset=UTF-8';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        //post数据
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($post_data, JSON_UNESCAPED_UNICODE));
        curl_setopt($ch, CURLOPT_HEADER, 0);
        $json_data = curl_exec($ch);
        $r = json_decode($json_data,true);
        return $r;
    }


}