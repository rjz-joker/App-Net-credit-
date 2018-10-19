<?php
/*
 *  简易标签库
 *
 *
 * */
class TagLibNL extends \Think\Template\TagLib {
	
	protected $tags = array(
		// attr 属性列表close 是否闭合（0 或者1 默认为1，表示闭合）
        'sitecfg'   => array(
            'attr'          =>      'name',
            'close'         =>      0
        ),

	);



    //网站信息调用
    // <NL:sitecfg name="***" />
    public function _sitecfg($attr){
        $attr = $this->parseXmlAttr($attr,'sitecfg');
        $name = empty($attr['name']) ? 'name' : $attr['name'];
        $str = <<<str
<?php
        \$name = "site_$name";
        if(empty(\$name)){
            echo "";
        }else{
            echo htmlspecialchars_decode(C(\$name));
        }
?>
str;
        return $str;
    }

	
}