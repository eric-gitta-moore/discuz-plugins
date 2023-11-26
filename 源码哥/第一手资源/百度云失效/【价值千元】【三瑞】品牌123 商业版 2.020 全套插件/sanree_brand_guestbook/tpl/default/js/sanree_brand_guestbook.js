function recode() {
   dateObj=new Date();
   $('checkcode').src='plugin.php?id=sanree_brand_guestbook&mod=checkcode&t='+dateObj.getTime(); 
}
function isTrueName(s) {
	var patrn = /^\s*[\u4e00-\u9fa5]{1,}[\u4e00-\u9fa5]{0,15}[\u4e00-\u9fa5]{1,}\s*$/; 
	if(!patrn.exec(s))
	{
		return false;
	}
	return true;
} 

function checkPhone( strPhone ) {
	var phoneRegWithArea = /^[0][0-9]{2,3}-[0-9]{5,10}$/;
	var phoneRegNoArea = /^[1-9]{1}[0-9]{5,8}$/;
	var phoneRegMob =/^0{0,1}(13[0-9]|18[0-9]|15[0-9])[0-9]{8}$/;
	
	if( strPhone.length > 9 ) {
		if( phoneRegWithArea.test(strPhone) ){
			return true;
		}
	}else{
		if( phoneRegNoArea.test( strPhone ) ){
			return true;
		}
	}
	if(phoneRegMob.test(strPhone)){

		return true;
	}
	return false;
}
function isEmail( str ){
	var myReg = /^[-_A-Za-z0-9]+@([_A-Za-z0-9]+\.)+[A-Za-z0-9]{2,3}$/;
	if(myReg.test(str)) return true;
	return false;
}
function isNumber( s ){  
	var regu = "^[0-9]+$";
	var re = new RegExp(regu);
	if (s.search(re) != -1) {
		return true;
	} else {
		return false;
	}
}