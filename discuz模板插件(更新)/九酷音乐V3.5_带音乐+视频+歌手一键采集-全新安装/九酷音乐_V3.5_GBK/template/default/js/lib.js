window.onerror = HideError;
function HideError(){
        return true;
}
(function() {
	qianwei = {
		quanxuan: function(obj) {
			with(document.getElementById(obj)) {
				var ins = getElementsByTagName("input");
				for (var i = 0; i < ins.length; i++) {
					if (i < 100) ins[i].checked = !ins[i].checked;
				}
			}
		},
		player: function(objName) {
			var mIdSrt = '';
			$('#' + objName + ' :checkbox').each(function() {
				if ($(this).attr('checked')) {
					mIdSrt += $(this).val() + ',';
				}
			});
			if (mIdSrt) {
				window.open(root_url + 'play.php?id=' + mIdSrt.substr(0, mIdSrt.length - 1));
			}
			 else {
				asyncbox.tips("��ѡ��Ҫ���ŵĸ�����", "wait", 1000);
			}
		},
		musicPlayer: function(ids) {
			var play_url = root_url + 'play.php';
			var winObj = null;
			if (ids.length == 0) return false;
			if (ids.length != 0) {
				if (ids.substr(ids.length - 1, 1) == ',') {
					ids = ids.substr(0, ids.length - 1);
				}
				play_url += '?id=' + ids;
			}
			winObj = window.open(play_url, "QianWeiMusicPlayer", "toolbar=yes,menubar=yes,scrollbars=yes,location=yes,status=yes,resizable=yes");
			winObj.focus();
			return false;
		}
	}
})();
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
function getplayer(_id){
        var theHttpRequest = getHttpObject();
        theHttpRequest.onreadystatechange = function() {processAJAX();};
        theHttpRequest.open("GET", temp_url+"ajax_player.php?id="+_id, true);
        theHttpRequest.send(null);
        function processAJAX(){
                if(theHttpRequest.readyState == 4) {
                        if(theHttpRequest.status == 200) {
                                document.getElementById("jp-playlist-box").innerHTML = unescape(theHttpRequest.responseText);
                        } else {
                                document.getElementById("jp-playlist-box").innerHTML = "�������ҳ������쳣����";
                        }
                }
        }
}
function getdown(_id){
        var theHttpRequest = getHttpObject();
        theHttpRequest.onreadystatechange = function() {processAJAX();};
        theHttpRequest.open("GET", temp_url+"ajax_down.php?ac=ajax&id="+_id, true);
        theHttpRequest.send(null);
        function processAJAX(){
                if(theHttpRequest.readyState == 4) {
                        if(theHttpRequest.status == 200) {
                                document.getElementById("download").innerHTML = unescape(theHttpRequest.responseText);
                        } else {
                                document.getElementById("download").innerHTML = "�������ҳ������쳣����";
                        }
                }
        }
}
function getavatar(){
        var theHttpRequest = getHttpObject();
        theHttpRequest.onreadystatechange = function() {processAJAX();};
        theHttpRequest.open("GET", temp_url+"ajax_avatar.php", true);
        theHttpRequest.send(null);
        function processAJAX(){
                if(theHttpRequest.readyState == 4) {
                        if(theHttpRequest.status == 200) {
                                document.getElementById("wall").innerHTML = unescape(theHttpRequest.responseText);
                        } else {
                                document.getElementById("wall").innerHTML = "�������ҳ������쳣����";
                        }
                }
        }
}
function getlogin(){
        var theHttpRequest = getHttpObject();
        theHttpRequest.onreadystatechange = function() {processAJAX();};
        theHttpRequest.open("GET", temp_url+"ajax_login.php", true);
        theHttpRequest.send(null);
        function processAJAX(){
                if(theHttpRequest.readyState == 4) {
                        if(theHttpRequest.status == 200) {
                                document.getElementById("userinfo").innerHTML = unescape(theHttpRequest.responseText);
                        } else {
                                document.getElementById("userinfo").innerHTML = "�������ҳ������쳣����";
                        }
                }
        }
}
function getdohits(_id){
        var theHttpRequest = getHttpObject();
        theHttpRequest.onreadystatechange = function() {processAJAX();};
        theHttpRequest.open("GET", temp_url+"ajax_like.php?ac=goodbad&id="+_id, true);
        theHttpRequest.send(null);
        function processAJAX(){
                if(theHttpRequest.readyState == 4) {
                        if(theHttpRequest.status == 200) {
                                document.getElementById("like").innerHTML = unescape(theHttpRequest.responseText);
                        } else {
                                document.getElementById("like").innerHTML = "�������ҳ������쳣����";
                        }
                }
        }
}
function up_down(_id, _do){
	createXMLHttpRequest();
	XMLHttpReq.open("GET", temp_url+"ajax_like.php?ac=dohits&id="+_id+"&do="+_do, true);
	XMLHttpReq.onreadystatechange= function(){
	        if(XMLHttpReq.readyState == 4){
	                if(XMLHttpReq.status == 200){
	                        if(XMLHttpReq.responseText == "Msg_login"){
	           	                asyncbox.tips("Ȩ�޲��������ȵ�¼���ٲ�����", "wait", 1000);
		                }
	                        if(XMLHttpReq.responseText == "Msg_cookie"){
	                                asyncbox.tips("��Ϣ��ɣ����Ѿ�������������", "wait", 2000);
		                }
	                        if(XMLHttpReq.responseText == "Msg_like"){
	                                asyncbox.tips("���۳ɹ���ͬʱ���Ϊϲ�������֣�", "success", 3000);
		                }
	                        if(XMLHttpReq.responseText == "Msg_dislike"){
	                                asyncbox.tips("���۳ɹ���ͬʱ���Ϊ��������֣�", "success", 3000);
		                }
                                getdohits(_id);
	                } else {
	           	        asyncbox.tips("�����쳣�������������ӣ�", "error", 1000);
	                }
	        }
	}
	XMLHttpReq.send(null);
}
function getlisten(){
        var theHttpRequest = getHttpObject();
        theHttpRequest.onreadystatechange = function() {processAJAX();};
        theHttpRequest.open("GET", temp_url+"ajax_listen.php?ac=ajax", true);
        theHttpRequest.send(null);
        function processAJAX(){
                if(theHttpRequest.readyState == 4) {
                        if(theHttpRequest.status == 200) {
                                document.getElementById("listen").innerHTML = unescape(theHttpRequest.responseText);
                        } else {
                                document.getElementById("listen").innerHTML = "�������ҳ������쳣����";
                        }
                }
        }
}
function his_del(_do, _id){
	createXMLHttpRequest();
	XMLHttpReq.open("GET", temp_url+"ajax_listen.php?ac=hisdel&do="+_do+"&id="+_id, true);
	XMLHttpReq.onreadystatechange= function(){
	        if(XMLHttpReq.readyState == 4){
	                if(XMLHttpReq.status == 200){
	                        if(XMLHttpReq.responseText == "Msg_login"){
	           	                asyncbox.tips("Ȩ�޲��������ȵ�¼���ٲ�����", "wait", 1000);
		                }
	                        if(XMLHttpReq.responseText == "Msg_del"){
	                                asyncbox.tips("��ϲ�������Ƴ��ɹ���", "success", 2000);
		                }
	                        if(XMLHttpReq.responseText == "Msg_alldel"){
	                                asyncbox.tips("��ϲ����¼�����ɣ�", "success", 3000);
		                }
                                getlisten();
	                } else {
	           	        asyncbox.tips("�����쳣�������������ӣ�", "error", 1000);
	                }
	        }
	}
	XMLHttpReq.send(null);
}
function goutRequest(){
	createXMLHttpRequest();
	XMLHttpReq.open("GET", temp_url+"source/ajax.php?ac=logout", true);
	XMLHttpReq.onreadystatechange= processResponse;
	XMLHttpReq.send(null);
}
function processResponse() {
	if(XMLHttpReq.readyState==4){
	        if(XMLHttpReq.status==200){
	                var msg=XMLHttpReq.responseText;
	                if(msg == "Msg_001"){
	                        asyncbox.tips("��֤�벻��ȷ������ģ�", "error", 1000);
	                } else if(msg == "Msg_002"){
	                        asyncbox.tips("��¼�ɹ����������������ص���ҳ��", "success", 1500);
	                        window.setTimeout("location.href='"+root_url+"';", 2000);
	                } else if(msg == "Msg_003"){
	                        asyncbox.tips("�ύ�ɹ�����л���ķ�����", "success", 1500);
	                } else if(msg == "Msg_004"){
	                        asyncbox.tips("���Ѿ��ղع������֣������ظ��ղأ�", "wait", 1000);
	                } else if(msg == "Msg_005"){
	                        asyncbox.tips("�ղسɹ���������ת���ҵĸ赥��", "success", 1500);
	                        window.setTimeout("location.href='"+favorites_url+"';", 2000);
	                } else if(msg == "Msg_006"){
	                        asyncbox.tips("��¼�ʺ��Ѿ���ע�ᣬ�����һ����", "error", 1000);
	                } else if(msg == "Msg_007"){
	                        asyncbox.tips("�����Ѿ���ռ�ã������һ����", "error", 1000);
	                } else if(msg == "Msg_008"){
	                        asyncbox.tips("ע��ɹ����������������ص���ҳ��", "success", 1500);
	                        window.setTimeout("location.href='"+root_url+"';", 2000);
	                } else if(msg == "Msg_009"){
	                        asyncbox.tips("�ܱ����ⲻ��ȷ������ģ�", "error", 1000);
	                } else if(msg == "Msg_010"){
	                        asyncbox.tips("�ܱ��𰸲���ȷ������ģ�", "error", 1000);
	                } else if(msg == "Msg_011"){
	                        asyncbox.tips("�����Ѿ�����ɹ������¼��", "success", 1500);
	                        window.setTimeout("location.href='"+login_url+"';", 2000);
	                } else if(msg == "Msg_012"){
	                        asyncbox.tips("��¼�ʺŲ����ڣ�����ģ�", "error", 1000);
	                } else if(msg == "Msg_013"){
	                        asyncbox.tips("ע����ɲ��ɹ������ʼ����������������ص���ҳ��", "success", 1500);
	                        window.setTimeout("location.href='"+root_url+"';", 2000);
	                } else if(msg == "Msg_014"){
	                        asyncbox.tips("UCenter API: �û������Ϸ���", "error", 3000);
	                } else if(msg == "Msg_015"){
	                        asyncbox.tips("UCenter API: ����������ע��Ĵ��", "error", 3000);
	                } else if(msg == "Msg_016"){
	                        asyncbox.tips("UCenter API: �û����Ѿ����ڣ�", "error", 3000);
	                } else if(msg == "Msg_017"){
	                        asyncbox.tips("UCenter API: Email ��ʽ����", "error", 3000);
	                } else if(msg == "Msg_018"){
	                        asyncbox.tips("UCenter API: Email ������ע�ᣡ", "error", 3000);
	                } else if(msg == "Msg_019"){
	                        asyncbox.tips("UCenter API: Email �Ѿ���ע�ᣡ", "error", 3000);
	                } else if(msg == "Msg_020"){
	                        asyncbox.tips("UCenter API: ����δ���壡", "wait", 3000);
	                } else if(msg == "Msg_021"){
	                        asyncbox.tips("������ɣ��������������ص���ҳ��", "success", 1500);
	                        window.setTimeout("location.href='"+root_url+"user.php?mod=callback&uc=o_in';", 2000);
	                } else if(msg == "Msg_022"){
	                        asyncbox.tips("��ϲ�����Ѿ��ɹ������ʺţ�", "success", 1500);
	                        window.setTimeout("location.href='"+root_url+"user.php?mod=callback&uc=c_in';", 2000);
	                } else if(msg == "Msg_023"){
	                        asyncbox.tips("�ʺŻ�������������ԣ�", "error", 1000);
	                } else if(msg == "Msg_024"){
	                        asyncbox.tips("��ϲ���������۳ɹ���", "success", 1500);
	                        window.setTimeout("document.location.reload()", 2000);
	                } else if(msg == "Msg_025"){
	                        asyncbox.tips("����Ϣ 30 ���Ժ��ٷ������ۣ�", "wait", 1000);
	                } else if(msg == "Msg_026"){
	                        getlogin();
	                        asyncbox.tips("���Ѿ���ȫ�˳��ˣ�", "wait", 1000);
	                } else if(msg == "Msg_027"){
	                        asyncbox.tips("�Բ��𣬸��ʺ��Ѿ���������", "wait", 1000);
	                } else if(msg == "Msg_028"){
	                        asyncbox.tips("��ϲ�����Ѿ��ɹ���¼��վ��", "success", 1500);
	                        window.setTimeout("document.location.reload()", 2000);
	                } else if(msg == "Msg_029"){
	                        asyncbox.tips("��ϲ�����Ѿ��ɹ��˳���վ��", "success", 1500);
	                        window.setTimeout("document.location.reload()", 2000);
	                } else if(msg == "Msg_030"){
	                        asyncbox.tips("�����Ѿ���ռ�ã������һ����", "error", 1000);
	                } else if(msg == "Msg_031"){
	                        asyncbox.tips("Ȩ�޲��������ȵ�¼���ٲ�����", "wait", 1000);
	                } else if(msg == "Msg_032"){
	                        asyncbox.tips("��¼�ɹ����������������ص���ҳ��", "success", 1500);
	                        window.setTimeout("location.href='"+root_url+"user.php?mod=callback&uc=o_in';", 2000);
	                } else if(msg == "Msg_033"){
	                        asyncbox.tips("���Ѿ���ȫ�˳��ˣ�", "wait", 1000);
	                        window.setTimeout("location.href='"+root_url+"user.php?mod=callback&uc=o_out';", 1500);
	                } else if(msg == "Msg_034"){
	                        asyncbox.tips("��ϲ�����Ѿ��ɹ���¼��վ��", "success", 1500);
	                        window.setTimeout("location.href='"+root_url+"user.php?mod=callback&uc=c_in';", 2000);
	                } else if(msg == "Msg_035"){
	                        asyncbox.tips("��ϲ�����Ѿ��ɹ��˳���վ��", "success", 1500);
	                        window.setTimeout("location.href='"+root_url+"user.php?mod=callback&uc=c_out';", 2000);
	                } else {
	                        asyncbox.tips(unescape(msg), "error", 1000);
	                        window.setTimeout("document.location.reload()", 1500);
	                }
	        } else {
	                asyncbox.tips("�������ҳ������쳣����", "error", 1000);
	        }
	}
}
function lostpasswd(){
	var p_ReI_1 = $('ReI_1').value;
	var p_ReI_2 = $('ReI_2').value;
	var p_ReI_3 = $('ReI_3').value;
	var p_ReI_4 = $('ReI_4').value;
	var p_ReI_5 = $('ReI_5').value;
	var p_ReI_6 = $('ReI_6').value;
	if( 1 > strLen(p_ReI_1) ){
	        $('Re_1').innerHTML = '<img src="'+temp_url+'css/check_error.gif" />&nbsp;��¼�ʺŲ�����Ϊ�գ�';
	        return;
	}else{
	        $('Re_1').innerHTML = '<img src="'+temp_url+'css/check_right.gif" />';
	}
	if( 1 > strLen(p_ReI_2) ){
	        $('Re_2').innerHTML = '<img src="'+temp_url+'css/check_error.gif" />&nbsp;�ܱ����ⲻ����Ϊ�գ�';
	        return;
	}else{
	        $('Re_2').innerHTML = '<img src="'+temp_url+'css/check_right.gif" />';
	}
	if( 1 > strLen(p_ReI_3) ){
	        $('Re_3').innerHTML = '<img src="'+temp_url+'css/check_error.gif" />&nbsp;�ܱ��𰸲�����Ϊ�գ�';
	        return;
	}else{
	        $('Re_3').innerHTML = '<img src="'+temp_url+'css/check_right.gif" />';
	}
	if( 6 > strLen(p_ReI_4) ){
	        $('Re_4').innerHTML = '<img src="'+temp_url+'css/check_error.gif" />&nbsp;������������Ҫ����6���ַ���';
	        return;
	}else{
	        $('Re_4').innerHTML = '<img src="'+temp_url+'css/check_right.gif" />';
	}
	if( $("ReI_5").value !== $("ReI_4").value ){
	        $('Re_5').innerHTML = '<img src="'+temp_url+'css/check_error.gif" />&nbsp;�����������벻һ�£�';
	        return;
	}else{
	        $('Re_5').innerHTML = '<img src="'+temp_url+'css/check_right.gif" />';
	}
	if( 4 != strLen(p_ReI_6) ){
	        $('Re_6').innerHTML = '<img src="'+temp_url+'css/check_error.gif" />&nbsp;��������ȷ����֤�룡';
	        return;
	}else{
	        $('Re_6').innerHTML = '<img src="'+temp_url+'css/check_right.gif" />';
	}
	createXMLHttpRequest();
	XMLHttpReq.open("GET", temp_url+"source/ajax.php?ac=lostpasswd&name="+escape(p_ReI_1)+"&question="+escape(p_ReI_2)+"&answer="+escape(p_ReI_3)+"&pwd="+escape(p_ReI_5)+"&code="+escape(p_ReI_6), true);
	XMLHttpReq.onreadystatechange= processResponse;
	XMLHttpReq.send(null);
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
	        $('Re_1').innerHTML = '<img src="'+temp_url+'css/check_error.gif" />&nbsp;����3��15���ַ�֮�䣬�����пո�� < > \' \" / \\ ���ַ���';
	        return;
	}else{
	        $('Re_1').innerHTML = '<img src="'+temp_url+'css/check_right.gif" />';
	}
	if( 6 > strLen(r_ReI_2) ){
	        $('Re_2').innerHTML = '<img src="'+temp_url+'css/check_error.gif" />&nbsp;��������Ҫ����6���ַ���';
	        return;
	}else{
	        $('Re_2').innerHTML = '<img src="'+temp_url+'css/check_right.gif" />';
	}
	if( $("ReI_3").value !== $("ReI_2").value ){
	        $('Re_3').innerHTML = '<img src="'+temp_url+'css/check_error.gif" />&nbsp;�����������벻һ�£�';
	        return;
	}else{
	        $('Re_3').innerHTML = '<img src="'+temp_url+'css/check_right.gif" />';
	}
	if( 2 > strLen(r_ReI_4) || 12 < strLen(r_ReI_4) || !/^([\S])*$/.test($("ReI_4").value) || !/^([^0-9])*$/.test($("ReI_4").value) || !/^([^<>'"\/\\])*$/.test($("ReI_4").value) ){
	        $('Re_4').innerHTML = '<img src="'+temp_url+'css/check_error.gif" />&nbsp;����2��12���ַ�֮�䣬�����пո����ֻ� < > \' \" / \\ ���ַ���';
	        return;
	}else{
	        $('Re_4').innerHTML = '<img src="'+temp_url+'css/check_right.gif" />';
	}
	if( '' == $("ReI_5").value ){
	        $('Re_5').innerHTML = '<img src="'+temp_url+'css/check_error.gif" />&nbsp;��ѡ�������Ա�';
	        return;
	}else{
	        $('Re_5').innerHTML = '<img src="'+temp_url+'css/check_right.gif" />';
	}
	if( '' == $("ReI_year").value || '' == $("ReI_month").value || '' == $("ReI_day").value ){
	        $('Re_birthday').innerHTML = '<img src="'+temp_url+'css/check_error.gif" />&nbsp;��ѡ���������գ�';
	        return;
	}else{
	        $('Re_birthday').innerHTML = '<img src="'+temp_url+'css/check_right.gif" />';
	}
	if( '' == $("ReI_sheng").value || '' == $("ReI_shi").value ){
	        $('Re_city').innerHTML = '<img src="'+temp_url+'css/check_error.gif" />&nbsp;��ѡ�����ĳ��У�';
	        return;
	}else{
	        $('Re_city').innerHTML = '<img src="'+temp_url+'css/check_right.gif" />';
	}
	if( '' == $("ReI_11").value || 0 < strLen(r_ReI_11) && isEmail(r_ReI_11)==false ){
	        $('Re_11').innerHTML = '<img src="'+temp_url+'css/check_error.gif" />&nbsp;��������ȷ�ĵ������䣡';
	        return;
	}else{
	        $('Re_11').innerHTML = '<img src="'+temp_url+'css/check_right.gif" />';
	}
	if( 5 > strLen(r_ReI_12) || 12 < strLen(r_ReI_12) || !/^[1-9][0-9]{4,}$/.test($("ReI_12").value) ){
	        $('Re_12').innerHTML = '<img src="'+temp_url+'css/check_error.gif" />&nbsp;��������ȷ��QQ���룡';
	        return;
	}else{
	        $('Re_12').innerHTML = '<img src="'+temp_url+'css/check_right.gif" />';
	}
	if( 4 != strLen(r_ReI_13) ){
	        $('Re_13').innerHTML = '<img src="'+temp_url+'css/check_error.gif" />&nbsp;��������ȷ����֤�룡';
	        return;
	}else{
	        $('Re_13').innerHTML = '<img src="'+temp_url+'css/check_right.gif" />';
	}
	createXMLHttpRequest();
	XMLHttpReq.open("GET", temp_url+"source/ajax.php?ac=register&name="+escape(r_ReI_1)+"&pwd="+escape(r_ReI_2)+"&nick="+escape(r_ReI_4)+"&sex="+escape(r_ReI_5)+"&year="+escape(r_ReI_year)+"&month="+escape(r_ReI_month)+"&day="+escape(r_ReI_day)+"&sheng="+escape(r_ReI_sheng)+"&shi="+escape(r_ReI_shi)+"&email="+escape(r_ReI_11)+"&qq="+escape(r_ReI_12)+"&code="+escape(r_ReI_13), true);
	XMLHttpReq.onreadystatechange= processResponse;
	XMLHttpReq.send(null);
}
function favorites(){
	var f_ReI_1 = $('ReI_1').value;
	if( 4 != strLen(f_ReI_1) ){
	        $('Re_1').innerHTML = '<img src="'+temp_url+'css/check_error.gif" />&nbsp;��֤��ӦΪ4λ����';
	        return;
	}else{
	        $('Re_1').innerHTML = '<img src="'+temp_url+'css/check_right.gif" />';
	}
	createXMLHttpRequest();
	XMLHttpReq.open("GET", temp_url+"source/ajax.php?ac=favorites&id="+favorites_music_id+"&code="+escape(f_ReI_1), true);
	XMLHttpReq.onreadystatechange= processResponse;
	XMLHttpReq.send(null);
}
function error(){
	var e_ReI_1 = $('ReI_1').value;
	if( 4 != strLen(e_ReI_1) ){
	        $('Re_1').innerHTML = '<img src="'+temp_url+'css/check_error.gif" />&nbsp;��֤��ӦΪ4λ����';
	        return;
	}else{
	        $('Re_1').innerHTML = '<img src="'+temp_url+'css/check_right.gif" />';
	}
	createXMLHttpRequest();
	XMLHttpReq.open("GET", temp_url+"source/ajax.php?ac=error&id="+error_music_id+"&code="+escape(e_ReI_1), true);
	XMLHttpReq.onreadystatechange= processResponse;
	XMLHttpReq.send(null);
}
function login(){
	var l_ReI_1 = $('ReI_1').value;
	if( 1 > strLen(l_ReI_1) ){
	        $('Re_1').innerHTML = '<img src="'+temp_url+'css/check_error.gif" />&nbsp;�û���������Ϊ�գ�';
	        return;
	}else{
	        $('Re_1').innerHTML = '<img src="'+temp_url+'css/check_right.gif" />';
	}
	var l_ReI_2 = $('ReI_2').value;
	if( 1 > strLen(l_ReI_2) ){
	        $('Re_2').innerHTML = '<img src="'+temp_url+'css/check_error.gif" />&nbsp;���벻����Ϊ�գ�';
	        return;
	}else{
	        $('Re_2').innerHTML = '<img src="'+temp_url+'css/check_right.gif" />';
	}
	var l_ReI_3 = $('ReI_3').value;
	if( 4 != strLen(l_ReI_3) ){
	        $('Re_3').innerHTML = '<img src="'+temp_url+'css/check_error.gif" />&nbsp;��������λ��֤�룡';
	        return;
	}else{
	        $('Re_3').innerHTML = '<img src="'+temp_url+'css/check_right.gif" />';
	}
	        createXMLHttpRequest();
	        XMLHttpReq.open("GET", temp_url+"source/ajax.php?ac=login&name="+escape(l_ReI_1)+"&pwd="+escape(l_ReI_2)+"&code="+escape(l_ReI_3), true);
	        XMLHttpReq.onreadystatechange= processResponse;
	        XMLHttpReq.send(null);
}
function logout_comment(){
	createXMLHttpRequest();
	XMLHttpReq.open("GET", temp_url+"source/ajax.php?ac=logout_comment", true);
	XMLHttpReq.onreadystatechange= processResponse;
	XMLHttpReq.send(null);
}
function login_comment(){
	if( '' == $("username").value || '' == $("pwd").value ){
	        $('i_result').innerHTML = '�ʺź����붼<em>������</em>Ϊ�գ�';
	        return;
	}else{
	        $('i_result').innerHTML = '����<em>�ύ</em>�У�...';
	}
	createXMLHttpRequest();
	XMLHttpReq.open("GET", temp_url+"source/ajax.php?ac=login_comment&name="+escape($("username").value)+"&pwd="+escape($("pwd").value), true);
	XMLHttpReq.onreadystatechange= processResponse;
	XMLHttpReq.send(null);
}
function post_comment(){
        var c_content = $('content').value;
        if( 6 > strLen(c_content) ){
	        $('t_result').innerHTML = '������������<em>6</em>���ַ���';
	        return;
	} else if( 128 < strLen(c_content) ){
	        $('t_result').innerHTML = '�����������<em>128</em>���ַ���';
	        return;
	}else{
	        $('t_result').innerHTML = '����<em>�ύ</em>�У�...';
	}
	createXMLHttpRequest();
	XMLHttpReq.open("GET", temp_url+"source/ajax.php?ac=post_comment&id="+comment_music_id+"&content="+escape(c_content), true);
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