var $j = jQuery.noConflict();     
// Use jQuery via $j(...)
$j(document).ready(function(){
});

if(PICK_URL) var RPC_URL = PICK_URL+'system_rules&tpl=no&myac=rpcServer&inajax=1';
var RPC_FUNCTIONS = ['test_window', 'load_keyword', 'show_rules_set', 'login_test', 'weibo_add','load_temp'];


function stopPage(url){
	if(BROWSER.ie){
		document.execCommand("stop") 
	}else{
		window.stop();
	}
	msg = $j("#stop_button").html();
	if(msg == '暂停')  {
		$j("#stop_button").html('继续');
	}else{
		if(url) location.href = url;
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



function getRpcClient()
{
    var rpcClient = null;
    if (typeof PHPRPC_Client != 'undefined') {
        var rpcClient = new PHPRPC_Client(
            RPC_URL + '&_=' + (new Date()).getTime(),
            RPC_FUNCTIONS
        );
        //rpcClient.setKeyLength(1024);
        //rpcClient.setEncryptMode(3);
    } else {
        alert('error');
    }
    return rpcClient;
}
function loading_html(msg){
	return loading = '<em><img src="static/image/common/loading.gif"> '+msg+'...</em>';
}

function s(n, msg) {
	if(msg) $j('.show_status_info').html(msg);
	if(n){
		if($j('.run_li_box #show_'+n+' .f_r').length) $j('.run_li_box #show_'+n+' .show_loading').remove();
		n = n - 1;
		$j('.run_li_box #show_'+n+' .show_loading').remove();
	}
	$('run_status').scrollTop = 100000000;
}
function c(){
	document.getElementById("notice").innerHTML = '';
}

function get_rules(){
	var content_type = $j(".content_type:radio:checked").val();
	
}
$j(function(){ 
	//$j($j(".tab_content").get(0)).show();   
	$j("#tab_menu li").click(function(){
		$j(this).addClass("current").siblings().removeClass("current");
		li_index =($j("#tab_menu li").index(this));
		$j("#step").val(li_index+1);
		$j(".tab_content").hide();
		$j($j(".tab_content").get(li_index)).show();
	});
});


function show_hide(show,hide,type){
	if(type == 2){
		showdom = hide;
		hidedom = show;
	}else{
		showdom = show;
		hidedom = hide;
	}
	var showarr=showdom.split('+');
	var hidearr=hidedom.split('+');
	for(i=0;i<showarr.length;i++){
		$j('#'+showarr[i]).show();
	}
	for(i=0;i<hidearr.length;i++){
		$j('#'+hidearr[i]).hide();	
	}
}

function format_url(url){
	if(!url) return;
	var reg1=new RegExp('<','g');
	var reg2=new RegExp('>','g');
	var reg3=new RegExp('"','g');
	url = url.replace(reg1,'[[JK%');
	url = url.replace(reg2,'JK%]]');
	url = url.replace(reg3,'[yinhao');
	return encodeURIComponent(url);
}

function create_variable(){
	page_url = $j('#page_url').val();
	rid = $j('#rid').val();
	$j("#bianliang").show();
	url = format_url(page_url);
	$j.post(PICK_URL+'system_rules&inajax=1&myac=create_variable&tpl=no&url='+url+'&rid='+rid,null,function (msg) {
		$j("#show_variable").html(msg);
	});
}
function show_var_ext(v,var_id){
	var type=1;
	if(v == 'select' || v == 'selects') type = 2;
	show_hide('var_keyword_'+var_id ,'var_select_'+var_id,type);
}
function check_web_type(id,test){
	url = format_url($j('#'+test).val());
	list_ID = format_url($j('#'+id).val());
	$j("#"+test+"_show").html(loading_html('正在检测'));
	$j.post(PICK_URL+'system_rules&inajax=1&myac=check_web_type&tpl=no&url='+url+'&list_ID='+list_ID,null,function (msg) {
		if(msg == 1){
			$j("#"+test+"_show").html('<font style="color:Green;">√识别成功</font>');
		}else{
			$j("#"+test+"_show").html('<font style="color:red;">×识别失败</font>');
		}
	});
}

function show_test_window(s,m,a,b,c,d,e,f,g,h){
	type = $j("."+a+":radio:checked").val();
	b = format_url($j('#'+b).val());
	c = format_url($j('#'+c).val());
	d = format_url($j('#'+d).val());
	e = format_url($j('#'+e).val());
	f = format_url($j('#'+f).val());
	g = format_url($j('#'+g).val());
	h = format_url($j('#'+h).val());
	showWindow('article_detail', PICK_URL+s+'&myac='+m+'&tpl=no&type='+type+'&inajax=1&b='+b+'&c='+c+'&d='+d+'&e='+e+'&f='+f+'&g='+g+'&h='+h);
}

function get_page_link(){
	is_filter = $j(".page_fiter:radio:checked").val();
	get_type = $j(".page_get_type_dom:radio:checked").val();
	page_url_no_other = format_url($j('#page_url_no_other').val());
	page_url_contain = format_url($j('#page_url_contain').val());
	page_url_no_contain = format_url($j('#page_url_no_contain').val());
	page_link_rules = format_url($j('#page_link_rules').val());
	page_url_test = format_url($j('#page_url_test').val());
	var login_cookie = format_url($j("#login_cookie").val());
	showWindow('article_detail', PICK_URL+'picker_manage&inajax=1&myfunc=ajax_func&af=system_get_link_test&tpl=no&is_filter='+is_filter+'&type='+get_type+'&page_url_no_other='+page_url_no_other+'&page_url_contain='+page_url_contain+'&page_url_no_contain='+page_url_no_contain+'&b='+page_link_rules+'&c='+page_url_test+'&login_cookie='+login_cookie);
}
function insertAtCursor(myField, myValue) {
	//IE support
	myField = document.getElementById(myField);
	if (document.selection) {
		myField.focus();
		sel = document.selection.createRange();
		sel.text = myValue;
	}else if (myField.selectionStart || myField.selectionStart == '0') {//MOZILLA/NETSCAPE support
		var startPos = myField.selectionStart;
		var endPos = myField.selectionEnd;
		myField.value = myField.value.substring(0, startPos) +  myValue + myField.value.substring(endPos, myField.value.length);
	}else {
		myField.value += myValue;
	}
}


function del_rules(id){
	$j("#"+id).remove();
}
function add_rules(name){
	max_id = 0;
	k = -1;
	$j("#"+name+"_tbody tr").each(function(i){
		tr_id = $j(this).attr('id');
		var arr=tr_id.split('_');
		arr_length=arr.length;
		tr_id = parseInt(arr[arr_length-1]);
		if(tr_id > max_id) max_id = tr_id;
		k++;
 	});
	if(k == 5) alert('骚年，别加太多了');
	$j.post(PICK_URL+'system_rules&myac=create_rules_html&inajax=1&tpl=no&i='+max_id+'&name='+name,null,function (msg) {
		if(k == -1){
			$j("#"+name+"_tbody").append(msg);
		}else{
			$j("#tr_"+name+'_'+max_id).after(msg);
		}
	});
}


function get_checked_arr(name){
	var chk_value =[];    
	$j('input[name="'+name+'[]"]:checked').each(function(){    
  		chk_value.push($j(this).val());    
  	});
	return chk_value;
}


function test_window(get_type, is_fiter, url_test, rule, replace_rule, id_name, show_type){
	showDialog('', 'info', loading_html('请稍候'));
	var filter_html_arr  = get_checked_arr('content_filter_html');
	
	get_type = $j("."+get_type+":radio:checked").val();
	is_fiter = $j("."+is_fiter+":radio:checked").val();
	url_test = format_url($j('#'+url_test).val());
	rule = format_url($j('#'+rule).val());
	replace_rule = format_url($j('#'+replace_rule).val());
	
	var login_cookie = format_url($j("#login_cookie").val());
	var fiter_arr = new Array();
	k = 0;
	$j("#"+id_name+"_tbody tr").each(function(i){
		tr_id = $j(this).attr('id');
		var arr=tr_id.split('_');
		arr_length=arr.length;
		id = parseInt(arr[arr_length-1]);
		type = $j("."+id_name+"_type_"+id+":radio:checked").val();
		rules = format_url($j('#'+id_name+'_'+id+'_rules').val());
		fiter_arr[i] = new Array();
		fiter_arr[i][0] = type;
		fiter_arr[i][1] = rules;
		k++;
 	});
	filter_data =  fiter_arr;
	if(show_type  == 'reply'){
		reply_is_extend = $j(".reply_is_extend:checkbox:checked").val();
		content_get_type = $j(".is_fiter_content:radio:checked").val();
		var reply_filter_html_arr  =  get_checked_arr('reply_filter_html');
		var replace_rule = $j('#reply_replace_rules').val();
		//if(content_get_type == 1){
			if(reply_is_extend == 1){
				get_type = $j(".content_get_type:radio:checked").val();
				rule = format_url($j('#content_rules').val());
				//alert($j('#reply_replace_rules').val());
				content_is_fiter = $j(".is_fiter_content:radio:checked").val();
				reply_is_fiter = $j(".is_fiter_reply:radio:checked").val();
				if(content_is_fiter == 1) {//内容过滤
					if(reply_is_fiter != 1) {//不过滤
						var filter_data = new Array();
						var replace_rule = $j('#content_replace_rules').val();
					}else{
						var replace_rule = $j('#content_replace_rules').val()+'\n\r'+$j('#reply_replace_rules').val();
						filter_html_arr = mergeArray(filter_html_arr, reply_filter_html_arr);
					}
					var c = filter_data.length;
					$j("#content_filter_rules_tbody tr").each(function(i){
						tr_id = $j(this).attr('id');
						var arr=tr_id.split('_');
						arr_length=arr.length;
						id = parseInt(arr[arr_length-1]);
						type = $j(".content_filter_rules_type_"+id+":radio:checked").val();
						rules = format_url($j('#content_filter_rules_'+id+'_rules').val());
						n = c + i;
						filter_data[n] = new Array();
						filter_data[n][0] = type;
						filter_data[n][1] = rules;
					});
					is_fiter = 1;
				}else{
					if(reply_is_fiter = 1) {//回复过滤
						is_fiter = 1;
						filter_html_arr = reply_filter_html_arr;
					}else{
						is_fiter = 2;	
						var filter_data = new Array();//两个都不过滤
						var replace_rule = '';
						var filter_html_arr = new Array();
					}
				}
			}else{//不继承
				get_type = $j(".reply_get_type:radio:checked").val();
				filter_html_arr = reply_filter_html_arr;
			}
		//}
	}
	if(show_type  == 'body' ){
		if(is_fiter == 2) filter_html_arr = new Array();
	} 
	replace_rule = format_url(replace_rule);
	var rpcClient = getRpcClient();
	var rpcCallback = function (result, args, output, warning) {
		if (!(result instanceof PHPRPC_Error)) {
			if (result == false) {
				
			} else {
				hideMenu('fwin_dialog', 'dialog');
				if(show_type == 'title') show_html_window('aa', '获取标题', 580, 460, output);
				if(show_type == 'body') show_html_window('bb', '获取内容', 780, 520, output);
				if(show_type == 'reply') show_html_window('cc', '获取回复', 780, 520, output);
				//showWindow('k', PICK_URL+'system_rules&myac=get_rpc_windowhtml&tpl=no','get','0');
			}
		}
	}
	rpcClient.test_window(get_type, url_test, is_fiter, rule, replace_rule, filter_data, show_type,login_cookie, filter_html_arr, rpcCallback);
}


function mergeArray(arr1, arr2) {
	var _arr = [];
	for (var i = 0; i < arr1.length; i++) {
		_arr.push(arr1[i]);
	}
	var _dup;
	for (var i = 0; i < arr2.length; i++){
		_dup = false;
		for (var _i = 0; _i < arr1.length; _i++){
			if (arr2[i] === arr1[_i]){
				_dup = true;
				break;
			}
		}
		if (!_dup){
			_arr.push(arr2[i]);
		}
	}
	
	return _arr;
}



function show_reply(){
	check_flag = $j(".reply_is_extend:checkbox:checked").val();
	if(check_flag == 1){
		show_hide('reply_show','',2);
	}else{
		show_hide('reply_show','',1);
	}
}

function milu_view(kk, obj, name) {
	show_html_window(kk, name, 620, 450, obj.innerHTML , 0);
}

function show_html_window(k, title, width, height, html, c){
	if(c==1) {
		c_html = 'text-align:center';
	}else{
		c_html = 'text-align:left';
	}
	show_html = '<h3 class="flb">'+title+'<span><a href="javascript:;" class="flbc" onclick="hideWindow(\''+k+'\');" title="关闭">点击就关闭窗口</a></span></h3><div class="article_detail c" style="width:'+width+'px;height:'+height+'px;overflow-y:scroll; '+c_html+'">'+ html+'</div>';
	showWindow(k, show_html, 'html');
}

function match_rules(){
	rules_match_url = format_url($j('#rules_match_url').val());
	var login_cookie = get_login_cookie();
	if(!rules_match_url){
		showDialog("网址是必须要填的  ~~(>_<)~~", 'notice');
		return;
	}
	$j("#show_match_rules_result").html(loading_html('正在努力的寻找规则，请稍候'));
	$j.post(PICK_URL+'system_rules&myac=ajax_func&af=pick_match_rules&inajax=1&tpl=no&xml=0&login_cookie='+login_cookie+'&url='+rules_match_url,null,function (msg) {
		if(msg == 'no' || msg == '' || !msg){
			no_rules();
		}else{
			$j("#show_match_rules_result").html('<font style="color:Green;">√手气不错，找到一条规则</font>');
			var obj = eval( "(" + msg + ")" );//转换后的JSON对象
			if(!obj[0]) no_rules();
			rules_type_select(obj[0],obj[1]);
		}
	});
	
}

function no_rules(){
	$j("#show_match_rules_result").html('<font style="color:red;">×抱歉，找不到匹配的规则，建议手动选择规则</font>');
	rules_type_select(0);
}

function rules_type_select(type,select_id){
	$j("#show_rules_select").html(loading_html('请稍候'));
	$j.post(PICK_URL+'system_rules&myac=show_rules_select&inajax=1&tpl=no&type='+type+'&select_id='+select_id,null,function (msg) {
		$j("#show_rules_select").html(msg);
		show_rules_set($j("#show_rules_set").val());
	});
}

function my_show_rules_set(v){//必须由此来触发，不解。
	show_rules_set(v);
}

function show_rules_set(v){
	//alert(v);return;
	var rpcClient = getRpcClient();
	var rpcCallback = function (result, args, output, warning) {
		if (!(result instanceof PHPRPC_Error)) {
			if (result == false) {
			} else {
				var var_set_output = '';
				var page_get_type = '';
				var page_link_rules = '';
				var page_url_test;
				if(output){
					var obj = eval( "(" + output + ")" );//转换后的JSON对象
					if(obj){
						var var_set_output = strdecode(obj.html);
						var page_get_type = strdecode(obj.page_get_type);
						var page_link_rules = strdecode(obj.page_link_rules);
						var page_url_test = strdecode(obj.page_url_test);
						rules_show_page_set(1);
					}
				}
				rules_show_page_set(1);
				if(!page_link_rules){
					if(page_get_type) $j("#show_get_page").hide();
				}
				$j("#show_url_var_set").html(var_set_output);	
				input_checked('page_get_type', page_get_type);
				$j("#page_link_rules").html(page_link_rules);
				$j("#page_url_test").val(page_url_test);
			}
		}
	}
	var args = new Array();
	args['rules_hash'] = v;
	rpcClient.show_rules_set(1,args, rpcCallback);
	$j.post(PICK_URL+'system_rules&myac=rules_edit&inajax=1&mytemp=common_get_content&inajax=1&rules_hash='+v,null,function (msg) {
		$j("#show_common_get_content").html($j(msg).find("root").text());
	});
}

function rules_show_page_set(type){
	$j("#show_get_page").show();
	var url_range_type = $j(".url_range_type:radio:checked").val();
	//$j(".url_range_type").removeAttr('checked');
	//$j("#ul_url_range_type li").attr('class', '');
	if(type == 1){//内置规则
		//$j("#url_range_type_page").attr('checked', 'checked');
		//$j("#li_url_range_type_page").attr('class', 'checked');
		$j("#model-r").show();
		$j("#page_url_hide_notice").hide();
		$j("#model-url-1").show();
		$j("#show_manyou").hide();
		$j("#show_rss").hide();
		$j("#many_list_page").hide();
		$j("#show_get_page").show();
		$j("#need_login").show();
		$j("#one_pick").hide();
		//内容
		$j("#show_common_get_content tbody").show();
		$j("#show_get_other").hide();
		$j("#page_url_hide_notice2").hide();
		_fiter_show('is_fiter_title', 'title_fiter_replace');
		_fiter_show('is_fiter_content', 'content_fiter_replace');
		_fiter_show('is_fiter_reply', 'reply_fiter_replace');
		_fiter_show('keyword_flag', 'show_keyword_filter');
		_fiter_show('is_get_other', 'show_get_other');
		show_reply();
		$j("#page_url_hide_notice").show();
		$j("#model-r").hide();
		$j("#model-url-1").hide();
		$j("#show_manyou").hide();
		$j("#show_rss").hide();
		$j("#many_list_page").hide();
		
	}else if(type == 2){///自定义
		$j("#page_url_hide_notice").hide();
		$j("#model-r").show();
		$j("#model-url-1").show();
		$j("#show_manyou").hide();
		$j("#show_rss").hide();
		$j("#many_list_page").hide();
		$j("#need_login").show();
		$j("#one_pick").hide();
		//内容
		
		if (url_range_type == 4){
			$j("#model-url-1").hide();
			$j("#show_rss").show();
			$j("#page_url_hide_notice").hide();
			$j("#show_get_page").hide();
		}else if(url_range_type == 2){
			$j("#show_get_page").hide();
		}else if(url_range_type == 5){
			$j("#show_get_page").hide();
			$j("#model-url-1").hide();
			$j("#many_list_page").show();
		}
		$j("#show_common_get_content tbody").show();
		$j("#show_get_other").hide();
		_fiter_show('is_fiter_title', 'title_fiter_replace');
		_fiter_show('is_fiter_content', 'content_fiter_replace');
		_fiter_show('is_fiter_reply', 'reply_fiter_replace');
		_fiter_show('keyword_flag', 'show_keyword_filter');
		_fiter_show('is_get_other', 'show_get_other');
		show_reply();
		$j("#page_url_hide_notice2").hide();
		
	}else if(type == 3){//一键采集
		$j("#show_manyou").show();
		$j("#show_login").hide();
		$j("#show_url_var_set").hide();
		$j("#show_get_page").hide();
		$j("#page_url_hide_notice").show();
		$j("#one_pick").show();
		$j("#model-r").hide();
		$j("#model-url-1").hide();
		$j("#show_rss").hide();
		//隐藏内容获取
		$j("#show_common_get_content tbody").hide();
		$j("#content_pick_filter").show();
		$j("#page_url_hide_notice2").show();
		if ($j(".keyword_flag:radio:checked").val() == 1) $j("#show_keyword_filter").show();
	}
}


function _fiter_show(fiter_id, show_id){
	if($j("."+fiter_id+":radio:checked").val() == 1){
		$j("#"+show_id).show();
	}else{
		$j("#"+show_id).hide();
	}
}

function hide_get_page(flag){
	if(flag){
		if(!$j("#page_link_rules").html()) $j("#show_get_page").hide();
	}
}
function input_checked(id,value){
	if(value == 1){
		$j("#"+id+"_1").attr('checked', 'checked');
		$j("#li_"+id+"_1").attr('class', 'checked');
		$j("#"+id+"_2").removeAttr('checked');
		$j("#li_"+id+"_2").attr('class', '');
		$j("#"+id+"_3").removeAttr('checked');
		$j("#li_"+id+"_3").attr('class', '');
		if(id == 'page_get_type') $j("#page_link_dom").show();
	}else if(value == 2){
		$j("#"+id+"_1").removeAttr('checked');
		$j("#li_"+id+"_1").attr('class', '');
		$j("#"+id+"_3").removeAttr('checked');
		$j("#li_"+id+"_3").attr('class', '');
		$j("#"+id+"_2").attr('checked', 'checked');
		$j("#li_"+id+"_2").attr('class', 'checked');
		if(id == 'page_get_type') $j("#page_link_dom").show();
	}else if(value == 3){
		$j("#"+id+"_1").removeAttr('checked');
		$j("#li_"+id+"_1").attr('class', '');
		$j("#"+id+"_2").removeAttr('checked');
		$j("#li_"+id+"_2").attr('class', '');
		$j("#"+id+"_3").attr('checked', 'checked');
		$j("#li_"+id+"_3").attr('class', 'checked');
		if(id == 'page_get_type') $j("#page_link_dom").hide();
	}
	
}

function show_keyword(v){
	$j(".show_keyword").slideToggle('fast');
	if($j(".show_keyword").attr('class')) {
		$j(".show_keyword").remove();
		return;
	}
	var arr=v.split('_');
	arr_length=arr.length;
	id = parseInt(arr[arr_length-1]);
	$j.post(PICK_URL+'system_rules&myac=show_keyword_html&inajax=1&tpl=no&type=2&key='+id,null,function (msg) {
		$j("#show_"+v).html(msg);
		$j(".show_keyword").slideToggle('fast');
		load_keyword(id);
		//$j("#"+v+'_link').after(msg);
	})
	
}
function load_keyword(id){
	keyword = $j(".search_keyword").val();
	if(!keyword) {
		keyword = $j("#rules_var_"+id).val();	
		$j(".search_keyword").val(keyword);
	}else{
		$j("#selectorBox").html(loading_html('正在查询，请稍候'));
	}
	var rpcClient = getRpcClient();
	var rpcCallback = function (result, args, output, warning) {
		if (!(result instanceof PHPRPC_Error)) {
			if (result == false) {
				//$j("#selectorBox").html('没有可用的长尾关键词');
			} else {
				$j("#selectorBox").html(output);
			}
		}
	}
	
	rpcClient.load_keyword(keyword);
}
function select_keyword(){
	
}

function url_page_range_test(){
	url = format_url($j("#url_page_range").val());
	auto = $j("#page_url_auto:checkbox:checked").val();
	if(auto == 'undefined') auto = 0;
	if(!url){
		showDialog("网址范围是必须要填的", 'notice');
		return;
	}
	start = $j("#page_url_auto_start").val();
	end = $j("#page_url_auto_end").val();
	step = $j("#page_url_auto_step").val();
	showWindow('kk', PICK_URL+'system_rules&myac=url_page_range_test&inajax=1&tpl=no&url='+url+'&auto='+auto+'&start='+start+'&end='+end+'&step='+step);
}


function many_list_test(id){
	type = $j(".many_page_list_type_"+id+":radio:checked").val();
	rules = encodeURIComponent(format_url($j('#many_page_list_'+id+'_rules').val()));
	test = encodeURIComponent(format_url($j('#many_page_list_'+id+'_test').val()));
	var login_cookie = format_url($j("#login_cookie").val());
	showWindow('kk', PICK_URL+'system_rules&tpl=no&myac=many_list_test&type='+type+'&rules='+rules+'&test='+test+'&login_cookie='+login_cookie);
}

function get_rss_link(){
	var rss_url = encodeURIComponent(format_url($j('#rss_url').val()));
	showWindow('kk', PICK_URL+'system_rules&tpl=no&inajax=1&myac=get_rss_url&rss_url='+rss_url);
}
function cnCode(str) {
	str = str.replace(/<\/?[^>]+>|\[\/?.+?\]|"/ig, "");
	str = str.replace(/\s{2,}/ig, ' ');
	return BROWSER.ie && document.charset == 'utf-8' ? encodeURIComponent(str) : str;
}
function addSort(obj) {
	if (obj.value == 'addoption') {
		showWindow('addoption', 'home.php?mod=spacecp&ac=blog&inajax=1&op=addoption&handlekey=addoption&oid='+obj.id);
 	}
}
function blogAddOption(sid, aid) {
	var obj = $(aid);
	var newOption = $(sid).value;
	newOption = newOption.replace(/^\s+|\s+$/g,"");
	$(sid).value = "";
	if (newOption!=null && newOption!='') {
		var newOptionTag=document.createElement('option');
		newOptionTag.text=newOption;
		newOptionTag.value="new:" + newOption;
		try {
			obj.add(newOptionTag, obj.options[0]);
		} catch(ex) {
			obj.add(newOptionTag, obj.selecedIndex);
		}
		obj.value="new:" + newOption;
		return true;
	} else {
		alert('分类名不能为空！');
		return false;
	}
}
function blogCancelAddOption(aid) {
	var obj = $(aid);
	obj.value=obj.options[0].value;
}

function change_public_type(type){
	if(type == 1){
		show_hide('portal_show+exfm+summary+article_portal', 'forums_show+blog_show+article_blog+article_tag+article_forum' ,1);
	}else if(type == 2){
		show_hide('forums_show+article_tag+article_forum', 'portal_show+blog_show+exfm+summary+article_portal+article_blog', 1);
		typeid = $j('#forum_typeid').val();
		if(!typeid) typeid = 0;
		getthreadtypes($j('#forums_show select').val(), typeid);
	}else if(type == 3){
		show_hide('blog_show+article_blog+article_tag', 'portal_show+forums_show+exfm+summary+article_portal+article_forum', 1);
	}else{
		show_hide('', 'portal_show+forums_show+exfm+summary+article_portal+blog_show+article_forum', 1);
	}
}

function getthreadtypes(catid, typeid){
	//ajaxget(PICK_URL+'picker_manage&myfunc=ajax_func&inajax=1&xml=1&af=getthreadtypes&inajax=1&tpl=no&fid=' + catid+'&typeid='+typeid, 'threadtypes');
	$j.post(PICK_URL+'picker_manage&myfunc=ajax_func&inajax=1&xml=0&af=getthreadtypes&inajax=1&tpl=no&fid=' + catid+'&typeid='+typeid,null,function (msg) {
		$j("#threadtypes").html(msg);
	})
	//alert($j("#threadtypes").text());
	//if(!$j("#threadtypes").text()) $j("#threadtypes").html();
}
function check_uid(uid){
	if(!uid) return false;
	$j.post(PICK_URL+'picker_manage&inajax=1&myfunc=ajax_func&af=check_uid&tpl=no&xml=0&uid='+uid,null,function (msg) {
		if(msg != 'no'){
			ajaxget(PICK_URL+'picker_manage&myfunc=ajax_func&af=get_person_blog_class&tpl=no&xml=1&uid='+uid, 'show_blog_class');
			return true;
		}else{
			showDialog("你所填的发布者的uid并不存在！", 'notice');
			return false;
		}
	})
	return false;
}


function public_check_save(){
	$j('#public_flag').val(1);
}


function get_content_page(){
	get_type = $j(".content_page_get_type:radio:checked").val();
	rules = format_url($j("#content_page_rules").val());
	page_type = format_url($j("#page_get_mode:checkbox:checked").val());
	url = format_url($j("#theme_url_test").val());
	var is_login = $j(".content_page_get_type:radio:checked").val();
	var login_cookie = format_url($j("#login_cookie").val());
	showWindow('kk', PICK_URL+'picker_manage&myfunc=ajax_func&inajax=1&af=system_get_link_test&tpl=no&xml=1&type='+get_type+'&b='+rules+'&page_type='+page_type+'&c='+url+'&is_filter=0&dom_type=content_page&login_cookie='+login_cookie+'&is_login='+is_login);
}

//
function login_test(){
	showDialog('', 'info', loading_html('请稍候'));
	var is_login = $j(".content_page_get_type:radio:checked").val();
	var login_cookie = format_url($j("#login_cookie").val());
	if($j("#login_test_url").length > 0){ 
		var login_test_url = format_url($j("#login_test_url").val());
	}else if($j("#theme_url_test").length > 0){
		var login_test_url = format_url($j("#theme_url_test").val());
	}
	$j.post(PICK_URL+'picker_manage&myfunc=ajax_func&inajax=1&af=login_test&tpl=no&xml=0&is_login='+is_login+'&login_cookie='+login_cookie+'&login_test_url='+login_test_url, null,function (msg) {
		hideMenu('fwin_dialog', 'dialog');
		show_html_window('aa', 'cookie登录测试', 580, 460, msg);
	})

}

function get_user_info(){
	var login_cookie = format_url($j("#login_cookie").val());
	var url = format_url($j("#url").val());
	var uid_range = format_url($j("#uid_range").val());
	var test_uid = format_url($j("#test_uid").val());
	showWindow('kk', PICK_URL+'member&myac=ajax_func&inajax=1&af=get_member_info&tpl=no&login_cookie='+login_cookie+'&url='+url+'&uid_range='+uid_range+'&test_uid='+test_uid);
}

function SetProgress(progress, show_time, show_count, memory) { 
	var progress_id = "loading"; 
	if (progress) { 
		if(isNaN(progress)) {
			$j("#" + progress_id + " > div").html(progress);
		}else{
			if(progress > 100) progress = 100;
			$j("#" + progress_id + " > div").css("width", String(progress) + "%"); //控制#loading div宽度 
			$j("#" + progress_id + " > div").html(String(progress) + "%"); //显示百分比
		}
	}
	if(show_time) {
		if(!isNaN(show_time)) show_time = CountDown(show_time*1000);
		$j('#wait_time').html('剩余时间: '+show_time);
	}
	if(show_count) {
		if(!isNaN(show_count)) show_count = show_count+' 个';
		$j('#wait_count').html('剩余: '+show_count);
	}
	if(memory) $j('#memory').html('内存使用: '+memory);

} 

function CountDown(diff_time){
	diff_time = parseInt(diff_time);
	if(diff_time>=0){
		d_str=24*60 * 60 * 1000;
		h_str=60 * 60 * 1000;
		m_str=60 * 1000;
		s_str=1000;
		d = Math.floor(diff_time / (d_str)); 
		h = Math.floor(diff_time  % d_str / (h_str)); 
		m = Math.floor((diff_time % d_str % (h_str))/(m_str));
		sec = Math.floor(((diff_time % d_str % (h_str))%(m_str))/s_str);
		d = d ? d+'天' : '';
		h = h ? h+'时' : '';
		m = m ? m+'分' : '';
		sec = sec ? sec+'秒' : '';
		if(d == '' && h == '' && m == '' && sec == '') return 0;
		return d+h+m+sec;
	}
}

function p_finsh(){
	$j(".show_loading").remove();
	var clear_log = $j('#pid').length ? '<input name="no_check_url" style="margin-top:10px;" type="checkbox" value="1" />重复采集' : '';
	$j(".show_button span").html('<button type="submit" value="2" name="submit"  class="button">重新执行</button>'+clear_log);	
}

function show_perent(i){
	$j(".infobox .infotitle1").html(String(progress) + "%")
}

function show_icon(n){
	if(!n) return;
	$j('.run_li_box #show_'+n).height(53);
	$j('.run_li_box #show_'+n).css('line-height', '53px');
	$j('.run_li_box #show_'+n+' .p_r').css('background', 'none');
	
}
function show_more(id){
	$j('#'+id).slideToggle('fast');
}


function share_picker_data(pid){
	var picker_desc = $("picker_desc").value;
	var pick_name = $("pick_name").value;
	$j.post(PICK_URL+'picker_manage&myfunc=ajax_func&inajax=1&af=share_picker_data&tpl=no&xml=0&pid='+pid+'&picker_desc='+picker_desc+'&pick_name='+pick_name, null,function (msg) {
		if(msg == -1){
			showDialog("抱歉，内网用户没有分享权限", 'notice');
		}else if(msg == -2){
			showDialog("抱歉，此规则已经被其他用户上传过了", 'notice');
		}else if(msg == 'ok' || !msg ){
			showDialog("操作成功，感谢您的分享!", 'right');
		}else{
			showDialog(msg, 'notice');
		}
	})
	hideWindow('share_pick');
}

function download_picker_data(pid){
	var cid = $j('.ps').val();
	$j.post(PICK_URL+'picker_manage&myfunc=ajax_func&inajax=1&af=download_picker_data&tpl=no&xml=0&pid='+pid+'&cid='+cid, null,function (msg) {
		if(msg >0){
			showDialog("下载并导入成功", 'right');
		}
	})
	hideWindow('download_pick');
}


function rules_data(id, type, data_type){
	var rules_name = '';
	var rules_desc = '';
	if(data_type == 'share'){	
		if(is_lan == 'yes') {
			showDialog("抱歉，内网用户没有分享权限", 'notice');//debug
			return;
		}
		var show_msg = '操作成功，感谢您的分享';
		var rules_name = $j("#rules_name").val();
		var rules_desc = $j("#rules_desc").val();
	}else{
		var show_msg = '下载并导入成功';
	}
	
	$j.post(PICK_URL+type+'&myac=ajax_func&inajax=1&af='+data_type+'_'+type+'_data&tpl=no&xml=0&id='+id+'&rules_name='+rules_name+'&rules_desc='+rules_desc, null,function (msg) {
		if(msg == 'ok'){
			showDialog(show_msg, 'right');
		}else if(msg == -2){
			showDialog("抱歉，此规则已经被其他用户上传过了", 'notice');
		}else{
			showDialog(msg, 'notice');
		}
	})
	hideWindow('download_rules');
}

function get_login_cookie(){
	var is_login = $j(".is_login:radio:checked").val();
	if(is_login == 2) return false;
	return format_url($j("#login_cookie").val());
	
}

//
function get_other_test(){
	var url = format_url($j("#theme_url_test").val());
	var login_cookie = get_login_cookie();
	var from_get_type = $j(".from_get_type:radio:checked").val();
	var author_get_type = $j(".author_get_type:radio:checked").val();
	var dateline_get_type = $j(".dateline_get_type:radio:checked").val();
	
	var from_get_rules = format_url($j("#from_get_rules").val());
	var author_get_rules = format_url($j("#author_get_rules").val());
	var dateline_get_rules = format_url($j("#dateline_get_rules").val());
	showWindow('kk', PICK_URL+'picker_manage&myac=ajax_func&inajax=1&af=get_other_test&tpl=no&login_cookie='+login_cookie+'&url='+url+'&from_get_type='+from_get_type+'&author_get_type='+author_get_type+'&dateline_get_type='+dateline_get_type+'&from_get_rules='+from_get_rules+'&author_get_rules='+author_get_rules+'&dateline_get_rules='+dateline_get_rules);
}

function rules_trun(id, type){
	var title = '转换规则';
	var c_html = '';
	var k = 'rules_trun';
	var select_arr = new Array();
	select_arr[0] = '<option value="fastpick">单贴采集规则</option>';
	select_arr[1] = '<option value="system">内置规则</option>';
	select_arr[2] = '<option value="picker">采集器配置</option>';
	if(type == 'fastpick'){
		var select_op = select_arr[1]+select_arr[2];
	}else if(type == 'system'){
		var select_op = select_arr[0]+select_arr[2];
	}else if(type == 'picker'){
		var select_op = select_arr[0]+select_arr[1];
	}else{
		var select_op = select_arr[0]+select_arr[1]+select_arr[2];
	}
	
	var select_html = '<div class="c bart" style=" width:100%; height:110px;"><p align="center" style=" margin-top:15px;height:70px"><select name="select" id="to_type">'+select_op+'</select></p>';
	var html = '<p align="center" >您希望将规则转换成什么？</p>'+select_html+'<p class="o pns"><button onclick="rules_trun_go('+id+', \''+type+'\');" class="pn pnc" name="dsf" type="submit"><span>确定</span></button><button onclick="hideWindow(\''+k+'\');" class="pn" name="dsf" type="reset"><em>取消</em></button></p></div>';
	
	show_html = '<h3 class="flb">'+title+'<span><a href="javascript:;" class="flbc" onclick="hideWindow(\''+k+'\');" title="关闭">点击就关闭窗口</a></span></h3><div class="article_detail c" style="width:250px;height:150px;overflow-y:scroll; '+c_html+'">'+ html+'</div>';
	showWindow(k, show_html, 'html');
}
function rules_trun_go(id, type){
	var to_type = $j("#to_type").val();
	var url = '';
	if(to_type == 'fastpick'){
		url = 'fast_pick&myac=fastpick_add';
	}else if(to_type == 'system'){
		url = 'system_rules&myac=fastpick_add';	
	}else if(to_type == 'picker'){
		url = 'picker_create';	
	}
	location.href = PICK_URL+url+'&turn_type='+type+'&turn_id='+id;
	hideWindow('rules_trun');
}

function pick_tips(key){
	$j.post(PICK_URL+'member&myac=ajax_func&inajax=1&myac=ajax_func&inajax=1&af=tips_no&key='+key, null,function (msg) {})
}

