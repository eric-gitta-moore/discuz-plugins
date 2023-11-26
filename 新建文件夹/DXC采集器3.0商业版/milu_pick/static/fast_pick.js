function fast_pick(){
	//var rules_type = $("rules_type").value;
	var article_url = $("article_url").value;
	if(article_url == '请输入文章地址') article_url = '';
	if(!article_url) {
		show_info('notice', '请输入文章地址');
		return false;
	}
	
	$('pick_loading').innerHTML = loading_html('请稍候');
	
	var ajaxurl = SITEURL+'plugin.php?id=milu_pick:fast_pick&myac=ajax_func&af=fastpick:fast_pick&inajax=1&tpl=no&xml=1&type='+fast_type+'&url='+encodeURIComponent(article_url)+'&rules_type=1';
	var x = new Ajax();
	var evo_msg = '';
	x.get(ajaxurl, function(s){
		if(s == '' || s == 'no' || s == 'null'){
			show_info('notice', '获取不到内容');
			return false;
		}else if(s == 'rpc_err'){
			show_info('err', '云服务端出错，建议您关闭云采集功能');
			return false;
		}
		try{
			var obj = eval( "(" + s + ")" );//转换后的JSON对象
		}catch(err){
			show_info('err', '出错，服务端异常！');;
			return;
		}
		var subject = strdecode(obj.title);
		var message = strdecode(obj.content);
		var evo = strdecode(obj.evo);
		if(evo == 1){
			evo_msg = ', 学习到一条新规则';
		}
		if(message){
			show_info('success', '成功'+evo_msg);
			if(fast_type == 'bbs'){
				switchEditor(0);
				$("subject").value= subject;
				message = message.replace(/<p>([\s\S]*?)<\/p>/ig, "$1<br />");
				message = message.replace(/<center>([\s\S]*?)<\/center>/ig, "[align=center]$1[/align]");
				$('e_textarea').value = html2bbcode(message);
				discuzcode('svd');
				switchEditor(1);
				$("subject").focus();
				
			}else{
				var fromurl = strdecode(obj.fromurl);
				if(fromurl) document.getElementsByName('fromurl')[0].value = fromurl;
				$("title").value= subject;				
				$('uchome-ttHtmlEditor').value  = message;
				var p = window.frames['uchome-ifrHtmlEditor'];
				var obj = p.window.frames['HtmlEditor'];
				obj.document.body.innerHTML = message;
				edit_save();
				$("title").focus();
			}
			
		}else{
			show_info('notice', '获取不到内容');
		}
	});
}
function show_info(type,msg){
	var show_img = 's1.gif'; 
	if(type == 'notice'){
		show_img = 's3.gif';
	}else if(type == 'err'){
		show_img = 's4.gif';
	}
	$('pick_loading').innerHTML = '<em><img style=" margin:3px 5px 0 0;float:left;" src="'+SITEURL +'source/plugin/milu_pick/static/image/'+show_img+'">'+msg+'</em>';
}

function loading_html(msg){
	return loading = '<em><img style=" margin:3px 5px 0 0;float:left;" src="static/image/common/loading.gif"> '+msg+'...</em>';
}

function pickFocus() {
	var msg = '请输入文章地址';
	var obj = $("article_url");
	if(obj.value == msg) {
		obj.value = '';
	}else if(obj.value == ''){
		obj.value = msg;
	}
}


function utf16to8(str) {
     var out, i, len, c;

     out = "";
     len = str.length;
     for(i = 0; i < len; i++) {
         c = str.charCodeAt(i);
         if ((c >= 0x0001) && (c <= 0x007F)) {
             out += str.charAt(i);
         } else if (c > 0x07FF) {
             out += String.fromCharCode(0xE0 | ((c >> 12) & 0x0F));
             out += String.fromCharCode(0x80 | ((c >>   6) & 0x3F));
             out += String.fromCharCode(0x80 | ((c >>   0) & 0x3F));
         } else {
             out += String.fromCharCode(0xC0 | ((c >>   6) & 0x1F));
             out += String.fromCharCode(0x80 | ((c >>   0) & 0x3F));
         }
     }
     return out;
}

function utf8to16(str) {
     var out, i, len, c;
     var char2, char3;

     out = "";
     len = str.length;
     i = 0;
     while(i < len) {
         c = str.charCodeAt(i++);
         switch(c >> 4)
         { 
           case 0: case 1: case 2: case 3: case 4: case 5: case 6: case 7:
             // 0xxxxxxx
             out += str.charAt(i-1);
             break;
           case 12: case 13:
             // 110x xxxx    10xx xxxx
             char2 = str.charCodeAt(i++);
             out += String.fromCharCode(((c & 0x1F) << 6) | (char2 & 0x3F));
             break;
           case 14:
             // 1110 xxxx   10xx xxxx   10xx xxxx
             char2 = str.charCodeAt(i++);
             char3 = str.charCodeAt(i++);
             out += String.fromCharCode(((c & 0x0F) << 12) |
                                            ((char2 & 0x3F) << 6) |
                                            ((char3 & 0x3F) << 0));
             break;
         }
     }

     return out;
}


var base64EncodeChars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/";
var base64DecodeChars = new Array(
     -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
     -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1,
     -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, -1, 62, -1, -1, -1, 63,
     52, 53, 54, 55, 56, 57, 58, 59, 60, 61, -1, -1, -1, -1, -1, -1,
     -1,   0,   1,   2,   3,   4,   5,   6,   7,   8,   9, 10, 11, 12, 13, 14,
     15, 16, 17, 18, 19, 20, 21, 22, 23, 24, 25, -1, -1, -1, -1, -1,
     -1, 26, 27, 28, 29, 30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40,
     41, 42, 43, 44, 45, 46, 47, 48, 49, 50, 51, -1, -1, -1, -1, -1);

function base64decode(str) {
     var c1, c2, c3, c4;
     var i, len, out;

     len = str.length;
     i = 0;
     out = "";
     while(i < len) {
         /* c1 */
         do {
             c1 = base64DecodeChars[str.charCodeAt(i++) & 0xff];
         } while(i < len && c1 == -1);
         if(c1 == -1)
             break;

         /* c2 */
         do {
             c2 = base64DecodeChars[str.charCodeAt(i++) & 0xff];
         } while(i < len && c2 == -1);
         if(c2 == -1)
             break;

         out += String.fromCharCode((c1 << 2) | ((c2 & 0x30) >> 4));

         /* c3 */
         do {
             c3 = str.charCodeAt(i++) & 0xff;
             if(c3 == 61)
                 return out;
             c3 = base64DecodeChars[c3];
         } while(i < len && c3 == -1);
         if(c3 == -1)
             break;

         out += String.fromCharCode(((c2 & 0XF) << 4) | ((c3 & 0x3C) >> 2));

         /* c4 */
         do {
             c4 = str.charCodeAt(i++) & 0xff;
             if(c4 == 61)
                 return out;
             c4 = base64DecodeChars[c4];
         } while(i < len && c4 == -1);
         if(c4 == -1)
             break;
         out += String.fromCharCode(((c3 & 0x03) << 6) | c4);
     }
     return out;
}
//input base64 encode
function strdecode(str){
	if(!str) return str;
	return utf8to16(base64decode(str));
}

