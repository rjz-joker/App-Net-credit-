<?php

//↓↓↓↓↓↓↓↓↓↓请在这里配置您的基本信息↓↓↓↓↓↓↓↓↓↓↓↓↓↓↓
//商户编号是商户在连连钱包支付平台上开设的商户号码，为18位数字，如：201306081000001016
$llpay_config['oid_partner'] = '201711290001211797';

//秘钥格式注意不能修改（左对齐，右边有回车符）
$llpay_config['RSA_PRIVATE_KEY'] ='-----BEGIN RSA PRIVATE KEY-----
MIICXQIBAAKBgQDROKMP5/8Iw54rZBpCcw4XeNpOUUJdN6WrVj6qbGi917JcGXB5
JBrLVvdbuOqrJAUdHnzWGl8iBcXXpv56dgM3zEZ+EEcHQNWVEo8zBnRv1BdXHqlp
u7nT0wQ625fJKz7UCz13tqOMoqPSO01TwGMgJjD8g79ad4G3GbAenzrmwwIDAQAB
AoGABQWL/GTAHVC8qiPz8WZbjzqqWrjek+gzBMLELEj/1panxEgkB/RS5FCJDV2J
3GO377P8oRLu950V25A5iWzttM0EhLSckumgSvKCnAanvyhIgU+AWWvRRK4j2ifE
m5u5EI/aDcEytZdadM6bNNr6sSma4Gkq3hGkn5yPiXtQ6+ECQQD1PdwxnHFuQ8qM
5uTIpiM0PDXmCFkDk8IhpFjG+028CWF08Jmqym57gSR7NKt+vJjxzjyhGDSQTMQ7
6LHTByGzAkEA2mZBqmEZ8KTm3z107pXbWR3CVsrnWshoshoEUa3/XixzQG7IXCtW
x0UnoyARheo1IdOHuw9uFFZu2VxUvC/+sQJBALe9x1JsUhg5NnLnM5aZ01p5mjBl
JLwnYpXuGo3LD2zI4nnJInjx/mEOWxTsW2kzSKwyxv4zsn5C5eu05jaj6z0CQBSL
a//wFHWbvZAgguByvmiasQ5jFfJnSdn/MorQeGZOfiUAht6MwSQLsFfbC2ryhj8B
XBJPuEY3f0P5OItfZHECQQCnWJFPwIHHS4mBPEJvcr3NEWrSpDNnjIR6GR34RbaX
tepO3evLhsqy8rRRCQMp+Va2W6oyvF3YaupAFJjQoRuF
-----END RSA PRIVATE KEY-----';	

//安全检验码，以数字和字母组成的字符
$llpay_config['key'] = '201710240001053004_test_20171024';

//↑↑↑↑↑↑↑↑↑↑请在这里配置您的基本信息↑↑↑↑↑↑↑↑↑↑↑↑↑↑↑

//版本号
$llpay_config['version'] = '1.0';

//防钓鱼ip
$llpay_config['userreq_ip'] = '10.10.246.110';

//证件类型
$llpay_config['id_type'] = '0';

//签名方式 不需修改
$llpay_config['sign_type'] = strtoupper('RSA');

//订单有效时间  分钟为单位，默认为10080分钟（7天） 
$llpay_config['valid_order'] ="10080";

//字符编码格式 目前支持 gbk 或 utf-8
$llpay_config['input_charset'] = strtolower('utf-8');

//访问模式,根据自己的服务器是否支持ssl访问，若支持请选择https；若不支持请选择http
$llpay_config['transport'] = 'http';
?>