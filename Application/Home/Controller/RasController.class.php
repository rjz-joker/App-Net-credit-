<?php
namespace Home\Controller;
use Think\Controller;
class RasController extends Controller {
//	protected $privateKeyFilePath='e:/sun/cyyd/htdocs/rsa_private_key.pem';
//    protected $rsaPublicKeyFilePath='e:/sun/cyyd/htdocs/rsa_public_key.pem';

    protected $privateKeyFilePath='e:/sun/cdl/0602/rsa_private_key.pem';
    protected $rsaPublicKeyFilePath='e:/sun/cdl/0602/rsa_public_key.pem';
	/**
     * 加签
     * @param $data 要加签的数据
     * @param $privateKeyFilePath 私钥文件路径
     * @return string 签名
     */
    public function sign($data) {
		$privateKeyFilePath=$this->privateKeyFilePath;
        $priKey = file_get_contents($privateKeyFilePath);
        $res = openssl_get_privatekey($priKey);
        openssl_sign($data, $sign, $res);
        openssl_free_key($res);
        $sign = base64_encode($sign);
        return $sign;
    }

    /**
     * 验签
     * @param $data 用来加签的数据
     * @param $sign 加签后的结果
     * @param $rsaPublicKeyFilePath 公钥文件路径
     * @return bool 验签是否成功
     */
    public function verify($data,$sign) {
        //读取公钥文件
		$rsaPublicKeyFilePath=$this->rsaPublicKeyFilePath;
        $pubKey = file_get_contents($rsaPublicKeyFilePath);

        //转换为openssl格式密钥
        $res = openssl_get_publickey($pubKey);

        //调用openssl内置方法验签，返回bool值
        $result = (bool)openssl_verify($data, base64_decode($sign), $res);

        //释放资源
        openssl_free_key($res);

        return $result;
    }


    /**
     * rsa加密
     * @param $data 要加密的数据
     * @param $pubKeyFilePath 公钥文件路径
     * @return string 加密后的密文
     */
    public function rsaEncrypt($data){

		$pubKeyFilePath=$this->rsaPublicKeyFilePath;
		
        //读取公钥文件
        $pubKey = file_get_contents($pubKeyFilePath);

        //转换为openssl格式密钥openssl_get_publickey
        $res = openssl_get_publickey($pubKey);

        $maxlength =$this->getMaxEncryptBlockSize($res);

        $output='';
        while($data){
            $input= substr($data,0,$maxlength);
            $data=substr($data,$maxlength);
            openssl_public_encrypt($input,$encrypted,$pubKey);
            $output.= $encrypted;
        }
        $encryptedData =  base64_encode($output);
        return $encryptedData;
    }

    /**
     * 解密
     * @param $data 要解密的数据
     * @param $privateKeyFilePath 私钥文件路径
     * @return string 解密后的明文
     */
    public function rsaDecrypt($data){
		$privateKeyFilePath=$this->privateKeyFilePath;
        //读取私钥文件
        $priKey = file_get_contents($privateKeyFilePath);
		
        //转换为openssl格式密钥
        $res = openssl_get_privatekey($priKey);
        $data = base64_decode($data);
        $maxlength = $this->getMaxDecryptBlockSize($res);
        $output='';
        while($data){
            $input = substr($data,0,$maxlength);
            $data = substr($data,$maxlength);
            openssl_private_decrypt($input,$out,$res);
            $output.=$out;
        }
        return $output;
    }

    /**
     *根据key的内容获取最大加密lock的大小，兼容各种长度的rsa keysize（比如1024,2048）
     * 对于1024长度的RSA Key，返回值为117
     * @param $keyRes
     * @return float
     */
    public function getMaxEncryptBlockSize($keyRes){
        $keyDetail = openssl_pkey_get_details($keyRes);
        $modulusSize = $keyDetail['bits'];
        return $modulusSize/8 - 11;
    }

    /**
     * 根据key的内容获取最大解密block的大小，兼容各种长度的rsa keysize（比如1024,2048）
     * 对于1024长度的RSA Key，返回值为128
     * @param $keyRes
     * @return float
     */
    public function getMaxDecryptBlockSize($keyRes){
        $keyDetail = openssl_pkey_get_details($keyRes);
        $modulusSize = $keyDetail['bits'];
        return $modulusSize/8;
    }
}