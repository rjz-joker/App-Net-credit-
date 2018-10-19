
function isMobile(num){
	return true;
	var myreg = /^(((13[0-9]{1})|(15[0-9]{1})|(18[0-9]{1}))|(17[0-9]{1})+\d{8})$/;
	if(!myreg.test(num)){
	    return false;
	}else{
		return true;
	}
}
