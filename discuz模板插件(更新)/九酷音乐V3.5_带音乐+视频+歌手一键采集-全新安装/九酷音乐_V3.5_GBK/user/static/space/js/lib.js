function createXMLHttpRequest(){
       	if (window.XMLHttpRequest) {
		XMLHttpReq=new XMLHttpRequest();
	}
	else if (window.ActiveXObject) {
	    try {
	        XMLHttpReq=new ActiveXObject("Msxml2.XMLHTTP");
	    } catch (e) {
	        try{
		    XMLHttpReq=new ActiveXObject("Micrsost.XMLHTTP");
		} catch(e){}
	    }
	}
}
function getHttpObject() {
    var objType = false;
    try {
        objType = new ActiveXObject('Msxml2.XMLHTTP');
    } catch(e) {
        try {
            objType = new ActiveXObject('Microsoft.XMLHTTP');
        } catch(e) {
            objType = new XMLHttpRequest();
        }
    }
    return objType;
}
function processResponse() {
	if(XMLHttpReq.readyState==4){
	        if(XMLHttpReq.status==200){
	                var msg=XMLHttpReq.responseText;
	                if(msg == "Msg_001"){
	                        asyncbox.tips("验证码不正确，请更改！", "error", 1000);
	                } else if(msg == "Msg_006"){
	                        asyncbox.tips("登录帐号已经被注册，请更换一个！", "error", 1000);
	                } else if(msg == "Msg_007"){
	                        asyncbox.tips("名字已经被占用，请更换一个！", "error", 1000);
	                } else if(msg == "Msg_008"){
	                        asyncbox.tips("注册成功，请上传您的头像！", "success", 1500);
	                        window.setTimeout("location.href='"+avatar_url+"';", 2000);
	                } else if(msg == "Msg_013"){
	                        asyncbox.tips("注册完成并成功发送邮件，请上传您的头像！", "success", 1500);
	                        window.setTimeout("location.href='"+avatar_url+"';", 2000);
	                } else if(msg == "Msg_014"){
	                        asyncbox.tips("UCenter API: 用户名不合法！", "error", 3000);
	                } else if(msg == "Msg_015"){
	                        asyncbox.tips("UCenter API: 包含不允许注册的词语！", "error", 3000);
	                } else if(msg == "Msg_016"){
	                        asyncbox.tips("UCenter API: 用户名已经存在！", "error", 3000);
	                } else if(msg == "Msg_017"){
	                        asyncbox.tips("UCenter API: Email 格式有误！", "error", 3000);
	                } else if(msg == "Msg_018"){
	                        asyncbox.tips("UCenter API: Email 不允许注册！", "error", 3000);
	                } else if(msg == "Msg_019"){
	                        asyncbox.tips("UCenter API: Email 已经被注册！", "error", 3000);
	                } else if(msg == "Msg_020"){
	                        asyncbox.tips("UCenter API: 错误未定义！", "wait", 3000);
	                } else if(msg == "Msg_030"){
	                        asyncbox.tips("邮箱已经被占用，请更换一个！", "error", 1000);
	                } else if(msg == "Msg_009"){
	                        asyncbox.tips("密保问题不正确，请更改！", "error", 1000);
	                } else if(msg == "Msg_010"){
	                        asyncbox.tips("密保答案不正确，请更改！", "error", 1000);
	                } else if(msg == "Msg_011"){
	                        asyncbox.tips("密码已经重设成功，请登录！", "success", 1500);
	                        window.setTimeout("location.href='"+login_url+"';", 2000);
	                } else if(msg == "Msg_012"){
	                        asyncbox.tips("登录帐号不存在，请更改！", "error", 1000);
	                } else if(msg == "Msg_002"){
	                        asyncbox.tips("登录成功，即将引导您进入个人中心！", "success", 1500);
	                        window.setTimeout("location.href='"+home_url+"';", 2000);
	                } else if(msg == "Msg_032"){
	                        asyncbox.tips("登录成功，即将引导您进入个人中心！", "success", 1500);
	                        window.setTimeout("location.href='"+zone_domain+"index.php?p=user&a=callback&uc=l_in';", 2000);
	                } else if(msg == "Msg_021"){
	                        asyncbox.tips("激活完成，即将引导您进入个人中心！", "success", 1500);
	                        window.setTimeout("location.href='"+zone_domain+"index.php?p=user&a=callback&uc=l_in';", 2000);
	                } else if(msg == "Msg_027"){
	                        asyncbox.tips("对不起，该帐号已经被锁定！", "wait", 1000);
	                } else if(msg == "Msg_023"){
	                        asyncbox.tips("帐号或密码错误，请重试！", "error", 1000);
	                } else {
	                        asyncbox.tips(unescape(msg), "error", 1000);
	                        window.setTimeout("document.location.reload()", 1500);
	                }
	        } else {
	                asyncbox.tips("您请求的页面出现异常错误！", "error", 1000);
	        }
	}
}
function register(){
	var r_ReI_1 = $('ReI_1').value;
	var r_ReI_2 = $('ReI_2').value;
	var r_ReI_3 = $('ReI_3').value;
	var r_ReI_4 = $('ReI_4').value;
	var r_ReI_5 = $('ReI_5').value;
	var r_ReI_year = $('ReI_year').value;
	var r_ReI_month = $('ReI_month').value;
	var r_ReI_day = $('ReI_day').value;
	var r_ReI_sheng = $('ReI_sheng').value;
	var r_ReI_shi = $('ReI_shi').value;
	var r_ReI_11 = $('ReI_11').value;
	var r_ReI_12 = $('ReI_12').value;
	var r_ReI_13 = $('ReI_13').value;
	if( 3 > strLen(r_ReI_1) || 15 < strLen(r_ReI_1) || !/^([\S])*$/.test($("ReI_1").value) || !/^([^<>'"\/\\])*$/.test($("ReI_1").value) ){
	        $('Re_1').innerHTML = '<div class="err_message error"><span class="icon">3-15字符，禁止空格或< > \' \" / \\</span></div>';
	        return;
	}else{
	        $('Re_1').innerHTML = '<div class="err_message right"><span class="rightIcon"></span></div>';
	}
	if( 6 > strLen(r_ReI_2) ){
	        $('Re_2').innerHTML = '<div class="err_message error"><span class="icon">密码至少要输入6个字符！</span></div>';
	        return;
	}else{
	        $('Re_2').innerHTML = '<div class="err_message right"><span class="rightIcon"></span></div>';
	}
	if( $("ReI_3").value !== $("ReI_2").value ){
	        $('Re_3').innerHTML = '<div class="err_message error"><span class="icon">两次输入密码不一致！</span></div>';
	        return;
	}else{
	        $('Re_3').innerHTML = '<div class="err_message right"><span class="rightIcon"></span></div>';
	}
	if( 2 > strLen(r_ReI_4) || 12 < strLen(r_ReI_4) || !/^([\S])*$/.test($("ReI_4").value) || !/^([^0-9])*$/.test($("ReI_4").value) || !/^([^<>'"\/\\])*$/.test($("ReI_4").value) ){
	        $('Re_4').innerHTML = '<div class="err_message error"><span class="icon">2-12字符，禁止空格数字或< > \' \" / \\</span></div>';
	        return;
	}else{
	        $('Re_4').innerHTML = '<div class="err_message right"><span class="rightIcon"></span></div>';
	}
	if( '' == $("ReI_5").value ){
	        $('Re_5').innerHTML = '<div class="err_message error"><span class="icon">请选择您的性别！</span></div>';
	        return;
	}else{
	        $('Re_5').innerHTML = '<div class="err_message right"><span class="rightIcon"></span></div>';
	}
	if( '' == $("ReI_year").value || '' == $("ReI_month").value || '' == $("ReI_day").value ){
	        $('Re_birthday').innerHTML = '<div class="err_message error"><span class="icon">请选择您的生日！</span></div>';
	        return;
	}else{
	        $('Re_birthday').innerHTML = '<div class="err_message right"><span class="rightIcon"></span></div>';
	}
	if( '' == $("ReI_sheng").value || '' == $("ReI_shi").value ){
	        $('Re_city').innerHTML = '<div class="err_message error"><span class="icon">请选择您的城市！</span></div>';
	        return;
	}else{
	        $('Re_city').innerHTML = '<div class="err_message right"><span class="rightIcon"></span></div>';
	}
	if( '' == $("ReI_11").value || 0 < strLen(r_ReI_11) && isEmail(r_ReI_11)==false ){
	        $('Re_11').innerHTML = '<div class="err_message error"><span class="icon">请输入正确的电子邮箱！</span></div>';
	        return;
	}else{
	        $('Re_11').innerHTML = '<div class="err_message right"><span class="rightIcon"></span></div>';
	}
	if( 5 > strLen(r_ReI_12) || 12 < strLen(r_ReI_12) || !/^[1-9][0-9]{4,}$/.test($("ReI_12").value) ){
	        $('Re_12').innerHTML = '<div class="err_message error"><span class="icon">请输入正确的QQ号码！</span></div>';
	        return;
	}else{
	        $('Re_12').innerHTML = '<div class="err_message right"><span class="rightIcon"></span></div>';
	}
	if( 4 != strLen(r_ReI_13) ){
	        $('Re_13').innerHTML = '<div class="err_message error"><span class="icon">请输入正确的验证码！</span></div>';
	        return;
	}else{
	        $('Re_13').innerHTML = '<div class="err_message right"><span class="rightIcon"></span></div>';
	}
	createXMLHttpRequest();
	XMLHttpReq.open("GET", zone_domain+"source/module/user/ajax.php?ac=register&name="+escape(r_ReI_1)+"&pwd="+escape(r_ReI_2)+"&nick="+escape(r_ReI_4)+"&sex="+escape(r_ReI_5)+"&year="+escape(r_ReI_year)+"&month="+escape(r_ReI_month)+"&day="+escape(r_ReI_day)+"&sheng="+escape(r_ReI_sheng)+"&shi="+escape(r_ReI_shi)+"&email="+escape(r_ReI_11)+"&qq="+escape(r_ReI_12)+"&code="+escape(r_ReI_13), true);
	XMLHttpReq.onreadystatechange= processResponse;
	XMLHttpReq.send(null);
}
function lostpasswd(){
	var p_ReI_1 = $('ReI_1').value;
	var p_ReI_2 = $('ReI_2').value;
	var p_ReI_3 = $('ReI_3').value;
	var p_ReI_4 = $('ReI_4').value;
	var p_ReI_5 = $('ReI_5').value;
	var p_ReI_6 = $('ReI_6').value;
	if( 1 > strLen(p_ReI_1) ){
	        $('Re_1').innerHTML = '<div class="err_message error"><span class="icon">登录帐号不允许为空！</span></div>';
	        return;
	}else{
	        $('Re_1').innerHTML = '<div class="err_message right"><span class="rightIcon"></span></div>';
	}
	if( 1 > strLen(p_ReI_2) ){
	        $('Re_2').innerHTML = '<div class="err_message error"><span class="icon">密保问题不允许为空！</span></div>';
	        return;
	}else{
	        $('Re_2').innerHTML = '<div class="err_message right"><span class="rightIcon"></span></div>';
	}
	if( 1 > strLen(p_ReI_3) ){
	        $('Re_3').innerHTML = '<div class="err_message error"><span class="icon">密保答案不允许为空！</span></div>';
	        return;
	}else{
	        $('Re_3').innerHTML = '<div class="err_message right"><span class="rightIcon"></span></div>';
	}
	if( 6 > strLen(p_ReI_4) ){
	        $('Re_4').innerHTML = '<div class="err_message error"><span class="icon">重设密码至少要输入6个字符！</span></div>';
	        return;
	}else{
	        $('Re_4').innerHTML = '<div class="err_message right"><span class="rightIcon"></span></div>';
	}
	if( $("ReI_5").value !== $("ReI_4").value ){
	        $('Re_5').innerHTML = '<div class="err_message error"><span class="icon">两次输入密码不一致！</span></div>';
	        return;
	}else{
	        $('Re_5').innerHTML = '<div class="err_message right"><span class="rightIcon"></span></div>';
	}
	if( 4 != strLen(p_ReI_6) ){
	        $('Re_6').innerHTML = '<div class="err_message error"><span class="icon">请输入正确的验证码！</span></div>';
	        return;
	}else{
	        $('Re_6').innerHTML = '<div class="err_message right"><span class="rightIcon"></span></div>';
	}
	createXMLHttpRequest();
	XMLHttpReq.open("GET", zone_domain+"source/module/user/ajax.php?ac=lostpasswd&name="+escape(p_ReI_1)+"&question="+escape(p_ReI_2)+"&answer="+escape(p_ReI_3)+"&pwd="+escape(p_ReI_5)+"&code="+escape(p_ReI_6), true);
	XMLHttpReq.onreadystatechange= processResponse;
	XMLHttpReq.send(null);
}
function login(){
	var l_ReI_1 = $('ReI_1').value;
	if( 1 > strLen(l_ReI_1) ){
	        $('Re_Msg').innerHTML = '<img src="'+zone_domain+'static/space/images/icon/wrong.gif" />&nbsp;<font color="#F25A04">用户名不允许为空！</font>';
	        return;
	}
	var l_ReI_2 = $('ReI_2').value;
	if( 1 > strLen(l_ReI_2) ){
	        $('Re_Msg').innerHTML = '<img src="'+zone_domain+'static/space/images/icon/wrong.gif" />&nbsp;<font color="#F25A04">密码不允许为空！</font>';
	        return;
	}
	var l_ReI_3 = $('ReI_3').value;
	if( 4 != strLen(l_ReI_3) ){
	        $('Re_Msg').innerHTML = '<img src="'+zone_domain+'static/space/images/icon/wrong.gif" />&nbsp;<font color="#F25A04">请输入四位验证码！</font>';
	        return;
	}
	        createXMLHttpRequest();
	        XMLHttpReq.open("GET", zone_domain+"source/module/user/ajax.php?ac=login&name="+escape(l_ReI_1)+"&pwd="+escape(l_ReI_2)+"&code="+escape(l_ReI_3), true);
	        XMLHttpReq.onreadystatechange= processResponse;
	        XMLHttpReq.send(null);
}
function strLen(str){
        var charset = document.charset;
	var len = 0;
	for(var i = 0; i < str.length; i++) {
	        len += str.charCodeAt(i) < 0 || str.charCodeAt(i) > 255 ? (charset == "gb2312" ? 3 : 2) : 1;
	}
	return len;
}
function isEmail(input){
	if(input.match(/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/)) {
	        return true;
	}
	return false;
}