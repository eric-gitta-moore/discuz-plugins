<?php
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

function get_pick_info($pid='', $field = '*'){
	global $_G;
	$pid = $pid ? $pid : $_GET['pid'];
	$pid = intval($pid);
	$data = DB::fetch_first("SELECT $field FROM ".DB::table('strayer_picker')." WHERE pid='$pid'");
	return $data;
}

function pick_category_list($select = FALSE){
	global $_G;
	$query = DB::query("SELECT * FROM ".DB::table('strayer_category')." ORDER BY displayorder ASC");
	while($rs = DB::fetch($query)) {
		if($select == TRUE){
			$arr[$rs['cid']] = $rs['name'];
		}else{
			$arr[] = $rs;
		}
	}
	if(!$arr){//如果没有分类
		$setarr = array(
			'displayorder' => 0,
			'name' => milu_lang('default_class'),
		);
		$insert_id = DB::insert('strayer_category', $setarr, TRUE);
		DB::query('UPDATE '.DB::table('strayer_picker')." SET pick_cid='$insert_id'");
	}
	return $arr;
}

function move_picker($pid, $to_cid){
	if(empty($pid) || empty($to_cid)) return;
	return DB::query('UPDATE '.DB::table('strayer_picker')." SET pick_cid='$to_cid' WHERE pid='$pid'");
}

//在线采集器
function pick_online(){
	global $_G,$head_url,$header_config;
	$info = get_share_serach('pick');
	$info['header'] = pick_header_output($header_config, $head_url);
	return $info;
}

function share_picker_data(){
	global $_G;
	require_once libfile('function/misc');
	$client_info = get_client_info();
	if(!$client_info) return milu_lang('share_no_allow');
	$pid = intval($_GET['pid']);
	if(!$pid) exit('error');
	$picker_data = get_pick_info($pid);
	if(!$picker_data['picker_hash']){
		$setarr['pick_hash'] = $picker_data['picker_hash'] = create_hash();
		DB::update('strayer_picker', $picker_data, array('pid' => $picker_data['pid']));
	}
	
	$picker_data['picker_desc'] = format_url($_GET['picker_desc']);
	$picker_data['name'] = format_url($_GET['pick_name']);
	if(!$picker_data) exit('error');
	if($picker_data['rules_hash']){
		pload('F:rules');
		$data['rules'] = get_rules_info($picker_data['rules_hash']);
		$data['rules']['domain'] = $domain;
	}
	$data['pick'] = $picker_data;
	$rpcClient = rpcClient();
	unset($picker_data['pid'], $data['rules']['login_cookie'], $data['pick']['login_cookie']);
	$re = $rpcClient->upload_data('pick', $data, $client_info);

	if(is_object($re) || $data->Number == 0){
		if($re->Message) return  milu_lang('phprpc_error', array('msg' => $re->Message));
		$re = (array)$re;
	}
	$re = is_array($re) ? $re[0] : $re;
	if($re < 0){
		return $re;
	}else{
		return 'ok';
	}
}


//下载采集数据
function download_picker_data(){
	$pid  = intval($_GET['pid']);
	$cid = intval($_GET['cid']);
	$rpcClient = rpcClient();
	$client_info = get_client_info();
	$re = $rpcClient->download_data('pick', $pid, $client_info);
	if(is_object($re) || $re->Number == 0){
		if($re->Message) return  milu_lang('phprpc_error', array('msg' => $re->Message));
		$re = (array)$re;
	}
	$re = serialize_iconv($re);
	return pick_import_data($re, $cid);
}


//导入采集器
function pick_import(){
	global $_G,$head_url,$header_config;
	if(!submitcheck('submit')) {
		num_limit('strayer_picker', 3000, 'p_num_limit');
		$info['header'] = pick_header_output($header_config, $head_url);
		return $info;
	}else{
		$rules_code = $_GET['rules_code'];
		$pick_cid = $_GET['pick_cid'];
		if($rules_code){
			$data = $rules_code;
		}else{
			$file_name =  str_iconv($_FILES['rules_file']['tmp_name']);
			$fp = fopen($file_name, 'r');
			$data = fread($fp,$_FILES['rules_file']['size']);
		}
		
		$arr = pimportfile($data);
		if($arr['rules_hash']) cpmsg_error(milu_lang('import_error', array('url' => PICK_GO)));
		if(!$arr['pick']['pid'] ) cpmsg_error(milu_lang('rules_error_data', array('url' => PICK_GO)));
		pick_import_data($arr, $pick_cid);
		cpmsg(milu_lang('import_finsh'), PICK_GO."picker_manage", 'succeed');
	}
}

function pick_import_data($arr, $pick_cid){
	global $_G;
	$arr['pick'] = get_table_field_name('strayer_picker', $arr['pick']);
	$del_data = array('pid','public_type','public_class', 'run_times', 'lastrun', 'nextrun'); //要去掉的字段名称
	foreach($del_data as $v){
		unset($arr['pick'][$v]);
	}
	$arr['pick'] = $arr['pick'];
	$arr['pick']['pick_cid'] = $pick_cid;
	$arr['pick']['displayorder'] = 0;//设为0，导入之后就排在最上面了 
	$arr['pick']['dateline'] = $_G['timestamp'];
	$arr['pick']['is_auto_public'] = 0;//自动发布设为否
	$insert_id = DB::insert('strayer_picker', paddslashes($arr['pick']), TRUE);//导入采集器
	if($arr['rules']){
		$rules_arr = $arr['rules'];	
		$check = DB::result(DB::query("SELECT COUNT(*) FROM ".DB::table('strayer_rules')." WHERE rules_hash='$rules_arr[rules_hash]'"), 0);		
		$rules_arr = get_table_field_name('strayer_rules', $rules_arr);
		unset($rules_arr['rid']);//去掉主键
		$rules_arr = paddslashes($rules_arr);
		if($check){//如果存在这个
			$rules_hash = $rules_arr['rules_hash'];
			unset($rules_arr['rules_hash']);
			DB::update('strayer_rules', $rules_arr, array('rules_hash' => $rules_hash));
		}else{
			DB::insert('strayer_rules', $rules_arr, TRUE);
		}
	}
	return $insert_id;
}

function show_pick_format($info){	
	$info['rules_var'] = dunserialize($info['rules_var']);
	$info['many_page_list'] = dunserialize($info['many_page_list']);
	$info['title_filter_rules'] = dunserialize($info['title_filter_rules']);
	$info['content_filter_rules'] = dunserialize($info['content_filter_rules']);
	$info['reply_filter_rules'] = dunserialize($info['reply_filter_rules']);
	$info['content_filter_html'] = dunserialize($info['content_filter_html']);
	$info['reply_filter_html'] = dunserialize($info['reply_filter_html']);
	$info['public_class'] = dunserialize($info['public_class']);
	$info['public_uid_group'] = dunserialize($info['public_uid_group']);
	$info['reply_uid_group'] = dunserialize($info['reply_uid_group']);
	if(!$info['jump_num'])  $info['jump_num'] = 45;
	if(!$info['time_out']) $info['time_out'] = 5;
	$info = dstripslashes($info);
	$info = dhtmlspecialchars($info);
	$time_pre = '1234321';//这是代表 - 符号
	
	if(strexists($info['public_start_time'], $time_pre)){//含有负号
		$info['public_start_time'] = str_replace($time_pre, '-', $info['public_start_time']);
	}else{
		if($info['public_start_time'] > TIMESTAMP - 20*365*24*3600){
			$info['public_start_time'] = $info['public_start_time'] ? dgmdate($info['public_start_time'], 'Y-m-d H:i') : '';
		}
	}
	if($info['public_end_time'] > TIMESTAMP - 20*365*24*3600){//如果时间不比二十年前的时间戳小，就是具体的时间，反之是小时
		$info['public_end_time'] = $info['public_end_time'] ? dgmdate($info['public_end_time'], 'Y-m-d H:i') : '';
	}
	$info = array_filter($info);

	return $info;
}

//删除采集器
function del_picker($pid){
	if(!$pid) return;
	DB::query('DELETE FROM '.DB::table('strayer_url')." WHERE pid= '$pid'");
	pload('F:article');
	article_batch_del($pid);
	del_pick_log($pid);
	DB::query('DELETE FROM '.DB::table('strayer_picker')." WHERE pid= '$pid'");
}

//某个分类下面的采集器
function category_picker($cid = 0, $get_field = '*'){
	$where = $cid > 0 ? " WHERE pick_cid='$cid'" : '';
	$query = DB::query("SELECT $get_field FROM ".DB::table('strayer_picker').$where);
	while($rs = DB::fetch($query)) {
		$data[] = $rs;
	}
	return $data;
}

//更新运行次数
function update_times($pid){
	if(!$pid) return;
	$pid = intval($pid);
	DB::query('UPDATE  '.DB::table('strayer_picker')." SET run_times=run_times+1 WHERE pid= '$pid'");
}

function create_file($filename, $value){
	
	$filename = $filename.".txt";
	$encoded_filename = urlencode($filename);
	$encoded_filename = str_replace("+", "%20", $encoded_filename);
	
	header('Content-Type: application/octet-stream');
	$ua = $_SERVER["HTTP_USER_AGENT"];
	if (preg_match("/MSIE/", $ua)) {
		header('Content-Disposition: attachment; filename="' . $encoded_filename . '"');
	} else if (preg_match("/Firefox/", $ua)) {
		header('Content-Disposition: attachment; filename*="utf8\'\'' . $filename . '"');
	} else {
		header('Content-Disposition: attachment; filename="' . $filename . '"');
	}
	print $value;
}




function system_get_link_test(){
	global $_G;
	pload('F:spider');
	$type = format_url($_REQUEST['type']);
	$is_filter = format_url($_REQUEST['is_filter']);
	$url = format_url($_REQUEST['c']);
	//$url = 'http://www.discuz.net/forum-26-1.html';//debug
	$rule = trim(str_iconv(format_url($_REQUEST['b'])));//记得转换中文
	$page_url_no_other = format_url($_REQUEST['page_url_no_other']);
	$page_url_contain = format_url($_REQUEST['page_url_contain']);
	$page_url_no_contain = format_url($_REQUEST['page_url_no_contain']);
	$page_url_no_other = format_url($_REQUEST['page_url_no_other']);
	$login_cookie = format_cookie($_GET['login_cookie']);
	if($_GET['dom_type'] == 'content_page') {
		$dom_type = 1;
	}else{
		$dom_type = 0;
	}	
	$content = get_contents($url, array('cookie' => $login_cookie));
	if($type == 1){//dom
		if($content != -1){
			$link_arr = dom_page_link($content, array('page_link_rules' => $rule, 'url' => $url), $dom_type);
		}
	}else if($type == 2){//字符
		if($content != -1){
			$link_arr = string_page_link($content, $rule, $url);
		}
	}else{//智能
		$link_arr = evo_get_pagelink($content, $url);
		//echo count($link_arr);
	}
	//print_r($link_arr);
	//exit();
	if($is_filter == 1 && $link_arr){
		$args = array(
			'page_url_no_other' => $page_url_no_other,
			'page_url_contain' => $page_url_contain,
			'page_url_no_contain' => $page_url_no_contain,
			'page_url_no_other' => $page_url_no_other,
		);
	}
	if($content == -1 ) {
		$link_html = milu_lang('unable_pick');
	}else if($content == -2){
		$link_html = milu_lang('get_time_out');
	}else{
		$link_html = windos_show_link($link_arr, '', array(), $args);
	}
	show_pick_window(milu_lang('get_link_test'), $link_html, array('w' => 620,'h' => '400','f' => 1));
}

function filter_page_link($now_url, $args){
	extract($args);
	if($page_url_no_other){//要过滤的网址
		$user_no_arr = format_wrap(trim($page_url_no_other));
		foreach($user_no_arr as $k => $v){
			$user_no_arr[$k] = str_replace('&amp;', '&', dhtmlspecialchars(trim($v)));
		}
		if(in_array($now_url, $user_no_arr)) return FALSE;
	}
	if(filter_something($now_url, $page_url_contain)) return FALSE;//必须包含
	if(!filter_something($now_url, $page_url_no_contain, TRUE)) return FALSE;//不包含
	return TRUE;
}




function test_window($get_type, $url_test, $is_fiter, $rules, $replace_rules, $filter_data,$show_type, $login_cookie, $filter_html_arr){
	$url_test = rpc_str($url_test);
	$rules = rpc_str($rules);
	$replace_rules = rpc_str($replace_rules);
	$login_cookie = rpc_str(urlencode($login_cookie));
	foreach($filter_data as $k => $v){
		if($v) $filter_data[$k][1] = rpc_str($v[1]);
	}
	$filter_html_arr = sarray_unique($filter_html_arr);//去重
	if($show_type == 'title'){
		$show_name = milu_lang('title');
	}else if($show_type == 'body'){
		$show_name = milu_lang('body');
	}else{
		$show_name = milu_lang('reply');
	}

	$contents = get_contents($url_test, array('cookie' => $login_cookie));
	
	$contents = dz_attach_format($url_test, $contents);
	$c_arr = format_article_imgurl($url_test, $contents);
	$contents = $c_arr['message'];
	if($get_type == 1){//dom
		if($show_type == 'reply'){
			$result_data = dom_get_manytext($contents, $rules);
		}else{
			if($show_type == 'title'){
				$dom_rules['title'] = $rules;
			}else{
				$dom_rules['content'] = $rules;
			}
			$re = dom_single_article($contents, $dom_rules);
			$result_data = $show_type == 'title' ? $re['title'] : $re['content'];
			
			
		}
	}else if($get_type == 2){//字符串
		if($contents != -1){
			if($show_type == 'reply'){
				$rules =  str_replace('[body]', '[reply]', $rules);
				$result_data = str_get_str($contents, $rules, $show_type, -1);
				unset($result_data[0]);
			}else{
				$result_data = str_get_str($contents, $rules, $show_type, 1);
			}
			
		}
	}else{//智能获取
		if($contents != -1){
			$re = get_single_article($contents, $url_test);
			if($show_type == 'title'){
				$result_data = $re['title'];
			}else{
				$result_data = $re['content'];
			}
		}
	}
	if($result_data == -1) {
		echo milu_lang('unable_pick');
		return;
	}else if($result_data == -2){
		echo milu_lang('get_time_out');
		return;
	}
	if(!$result_data) {
		echo(milu_lang('no_get_data').$show_name); 
		return;
	}
	
	
	$format_args = array(
		'is_fiter' => $is_fiter,
		'show_type' => $show_type,
		'result_data' => $result_data,
		'replace_rules' => $replace_rules,
		'filter_data' => $filter_data,
		'test' => 1,
		'filter_html' => $filter_html_arr,
	);
	
	$result_data = filter_article($format_args);
	if($show_type == 'reply'){
		$body = show_reply_output($result_data);
	}else{
		$body .= $result_data;
	}
	$body .= $notice;
	echo $body;
}


function show_reply_output($reply_data){
	if(!$reply_data) return FALSE;
	if(!is_array($reply_data[0])){
		$body .= '<p>'.milu_lang('get_data_count', array('data' => count($reply_data))).milu_lang('reply').':</p><br>';
	}else{
		$body .= '<p class="reply_count"><em>'.milu_lang('reply_count', array('c' => count($reply_data))).'</em></p><br>';
	}
	$body .= '<ul class="show_reply">';
	$i = 0;
	foreach((array)$reply_data as $k => $v){
		$i ++;
		if(is_array($v)){
			$body .= '<li>'.$i.'.'.$v['content'].'</li>';
		}else{
			$body .= '<li>'.$i.'.'.$v.'</li>';
		}
		
	}
	$body .= '</ul>';
	return $body;
}

function show_page_output($content_arr){
	if(!$content_arr) return FALSE;
	$body .= '<p class="reply_count"><em>'.milu_lang('page_count', array('c' => count($content_arr))).'</em></p><br>';
	$body .= '<ul class="show_reply">';
	$i = 0;
	foreach((array)$content_arr as $k => $v){
		$i ++;
		$body .= '<li>'.milu_lang('the_page', array('i' => $i)).'<br>'.$v['content'].'</li>';
	}
	$body .= '</ul>';
	return $body;
}


function show_rules_select($args){
	global $_G;
	$system_rules = $_G['cache']['evn_milu_pick']['system_rules'];
	$no_ajax = $args['no_ajax'];
	if($no_ajax != 1){
		ob_clean();
		ob_end_flush();
	}
	$type = $_GET['type'] ? $_GET['type'] : $args['type'];
	$select_id =  $_GET['select_id'] ? $_GET['select_id'] : $args['select_id'];
	if($select_id){
		$rules_info = DB::fetch_first("SELECT rules_type,rules_hash FROM ".DB::table('strayer_rules')." WHERE rules_hash='$select_id'");
		$type  = $rules_info['rules_type'];
	}
	$html = '<select id="select_rules_type" onchange="rules_type_select(this.value,0)" name="system_rules_type">';
	$html .= '<option value="0">'.milu_lang('select_rules').'</option>';
	foreach($system_rules as $k => $v){
		  $selected = $type == $k ? 'selected="selected"' : '';
          $html .= '<option '.$selected.' value="'.$k.'">'.$v.'</option>';   
	}
	$html .= '</select>';
	echo $html;
	if(!$type) return;
	$query = DB::query("SELECT rules_name,rules_hash FROM ".DB::table('strayer_rules')." WHERE rules_type='$type' ORDER BY rid DESC");
	$i = 0;
	$html = '<select name="set[rules_hash]" id="show_rules_set" onchange="my_show_rules_set(this.value)">';
	while($rs = DB::fetch($query)) {
		$i++;
		$selected = $select_id == $rs['rules_hash'] ? 'selected="selected"' : '';
        $html .= '<option '.$selected.' value="'.$rs['rules_hash'].'">'.$rs['rules_name'].'</option>';
	}
	$html .= '</select>';
	if($i == 0) $html = milu_lang('class_no_rules');
	echo $html;
	if($no_ajax != 1){
		define(FOOTERDISABLED, false);
		exit();
	}
}



function rules_list_simple($field = '*'){
	$count = DB::result(DB::query("SELECT COUNT(*) FROM ".DB::table('strayer_rules')), 0);
	if(!$count) return;
	$query = DB::query("SELECT ".$field." FROM ".DB::table('strayer_rules')." ORDER BY rid DESC");	
	while(($v = DB::fetch($query))) {
		$list[] = $v;
	}
	return $list;
}



function show_rules_set($show = 1, $args = array()){
	global $_G;
	pload('F:rules');
	$rules_hash = $_GET['rules_hash'] ? $_GET['rules_hash'] : $args['rules_hash'];
	$info = get_rules_info($rules_hash);
	if(DISCUZ_VERSION != 'X2') $info = dstripslashes($info);
	$url_var = unserialize($info['url_var']);
	//$info = dhtmlspecialchars($info);
	if(!$url_var) return;
	foreach($url_var as $k => $v){
		$html .= show_var_html($k, $v, $args['rules_set'][$k]);
	}
	if(!$show) return $html;
	$arr['page_get_type'] = $info['page_get_type'];
	$arr['page_link_rules'] = $info['page_link_rules'];
	$arr['page_url_test'] = $info['page_url_test'];
	$arr['html'] = $html;
	$arr = js_base64_encode($arr);
	echo json_encode($arr);
	//exit();
}



function load_keyword($keyword = ''){
	global $_G;
	$keyrowd = rpc_str($keyword);
	$keyword_arr = get_keyword($keyrowd);
	$li_html = '';
	if(!$keyword_arr) {
		$li_html = milu_lang('no_keyword');
	}else{	
		foreach($keyword_arr as $k => $v){
			$li_html .= '<li class="a"><label><input onclick="select_keyword();" type="checkbox" class="pc" checked="checked" value="'.$v.'" ><span class="xi2">'.$v.'</span></label></li>';
		}
	}
	echo $li_html;
	return $li_html;
}


function url_page_range_test(){
	global $_G;
	$url = rpc_str($_GET['url']);
	if(!strexists($url, '(*)')) {
		$new_arr = array($url);
		$count = 1;
	}else{
		$auto = $_GET['auto'];
		$start = $_GET['start'];
		$end = $_GET['end'];
		$step = $_GET['step'];
		if($auto == 'undefined') $auto = 0;
		$range_arr = range($start, $end, $step);
		$count = count($range_arr);
		$start = intval($start);
		$end = intval($end);
		$step = intval($step);
		$max_len = strlen($range_arr[$count - 1]);
		if($start == $end) {
			show_pick_window(milu_lang('get_link_list_test'), milu_lang('start_no_less_end'), array('w' => 620,'h' => '400','f' => 1));
			exit();
		}
		if($step == 0) {
			show_pick_window(milu_lang('get_link_list_test'), milu_lang('step_no_data'), array('w' => 620,'h' => '400','f' => 1));
			exit();
		}
		if($start > 1677215 || $end > 1677215) {
			show_pick_window(milu_lang('get_link_list_test'), milu_lang('long_data'), array('w' => 620,'h' => '400','f' => 1));
			exit();
		}
		if($count < 9){
			$new_arr = convert_url_range(array('url' => $url, 'auto' => $auto, 'start' => $start, 'end' => $end, 'step' => $step));
		}else{	
			$arr1 = array_slice($range_arr, 0, 4);
			array_push ($arr1, 0);
			$arr2 = array_slice($range_arr, $count-4, $count-1);
			$arr = array_merge($arr1, $arr2);
			foreach($arr as $k => $v){
				if($v == 0){
					$new_arr[$k] = 0;
				}else{
					$v = $auto ? str_pad($v, $max_len, "0", STR_PAD_LEFT) : $v;
					$key = array_search($v, $range_arr); 
					$new_arr[$key] = str_replace('(*)', $v, $url); 
				}
			}
		}
	}	
	$link_html = windos_show_link($new_arr,'',array('count' => $count));
	show_pick_window(milu_lang('get_link_list_test'), $link_html, array('w' => 620,'h' => '400','f' => 1));
}

function many_list_get_page($rules_arr,$start_url = ''){
	extract($rules_arr);
	//print_r($rules_arr);
	//exit();
	$url = $start_url ? $start_url : $test;
	$rules = stripslashes($rules);
	$content = get_contents($url, array('login_cookie' => $login_cookie, 'cache' => -1));
	if($type == 1){//dom
		$link_arr = dom_page_link($content, array('page_link_rules' => $rules, 'url_page_range'=>$url));
	}else{
		$link_arr = string_page_link($content, $rules, $url);
	}
	return $link_arr;
}


function many_list_test(){
	global $_G;
	$type = $_GET['type'];
	$rules = rpc_str($_GET['rules']);
	$url = rpc_str($_GET['test']);
	$login_cookie = format_cookie($_GET['login_cookie']);
	$link_arr = many_list_get_page(array('type'=>$type, 'rules' => $rules, 'test' => $url, 'login_cookie' => $login_cookie));
	$link_html = windos_show_link($link_arr);
	show_pick_window(milu_lang('get_link_list_test'), $link_html, array('w' => 620,'h' => '400','f' => 1));
}

function get_rss_url($show = 1, $rss_url = ''){
	pload('F:spider');
	$rss_url = $rss_url ? $rss_url : rpc_str($_GET['rss_url']);
	$url_arr = format_wrap($rss_url);
	$rss = get_rss_obj();
	$arr = $arr_new = array();
	foreach((array)$url_arr as $k => $v){
		$rs = $rss->Get(trim($v)); //不去掉空格好像不行
		$items = $rs['items'];
		foreach((array)$items as $k1 => $v1){
			$arr[] = $v1['link'];
		}
		$arr_new = array_merge($arr_new, $arr);
		unset($arr); 
	}
	if($show != 1) return $arr_new;
	$link_html = windos_show_link($arr_new);
	show_pick_window(milu_lang('get_link_list_test'), $link_html, array('w' => 620,'h' => '400','f' => 1));
}



//执行采集
function start_pick(){
	require_once(PICK_DIR.'/lib/pick.class.php');
	$pick = new pick();
	$pick->run_start();
}

//同步
function rules_update($rules_hash = ''){
	$rules_hash = $rules_hash ? $rules_hash : $_GET['rules_hash'];
	$v_info = get_rules_info($rules_hash);
	$field_arr = array('page_get_type', 'page_link_rules', 'page_url_test', 'theme_url_test', 'theme_get_type', 'theme_rules', 'is_fiter_title', 'title_replace_rules', 'title_filter_rules', 'content_get_type', 'is_fiter_content', 'content_filter_rules', 'is_fiter_reply', 'reply_is_extend', 'reply_get_type', 'reply_rules', 'reply_fiter_replace', 'reply_filter_rules', 'content_page_get_type', 'content_page_rules', 'content_page_get_mode', 'is_get_other', 'from_get_type', 'author_get_type', 'from_get_rules', 'author_get_rules', 'dateline_get_type', 'dateline_get_rules','reply_replace_rules', 'content_rules', 'content_replace_rules', 'reply_filter_html');
	foreach($field_arr as $k => $v){
		$setarr[$v] = $v_info[$v];
	}
	$query = DB::query("SELECT * FROM ".DB::table('strayer_picker')."  WHERE rules_hash ='$rules_hash'");
	while(($rs = DB::fetch($query))) {
		DB::update('strayer_picker', $setarr, array('rules_hash' => $rs['rules_hash']));
	}
}


function pick_log_list($pid = 0){
	$pid = $pid ? $pid : $_REQUEST['pid'];
	$pid = intval($pid);
	$log_dir = PICK_PATH.'/data/log/'.$pid.'/';
	require_once(PICK_DIR.'/lib/cache.class.php');
	$arr = IO::ls($log_dir);
	$output_html = '<ul id="log_list" class="show_debug" style=" width:90%">';
	$i = 0;
	foreach((array)$arr as $k => $v){
		$file_name = basename($v[1]);
		if($file_name == 'index.html') continue;
		$i++;
		$path = $v[1];
		$url = PICK_URL.'data/log/'.$pid.'/'.$file_name;
		$output_html .= '<li id="log_'.$i.'" style="border-bottom:1px dashed #FFCCFF; line-height:25px; height:25px;">'.$i.'. <a style="color:#333333"  target="_blank"  href="'.$url.'">'.$file_name.'</a><a href="javascript:void(0)" style=" float:right;color:#2366A8" onclick="del_log('.$pid.', \''.$file_name.'\','.$i.');">'.milu_lang('del').'</a></li>';
	}
	$output_html .= '</ul>';
	if(!$arr || count($arr) == 1) $output_html = milu_lang('no_log');
	show_pick_window(milu_lang('log_list'), $output_html, array('w' => 620,'h' => '400','f' => 1));
}


function del_log(){
	$pid = intval($_REQUEST['pid']);
	$file_name = rpc_str($_REQUEST['file_name']);
	$log_file = PICK_PATH.'/data/log/'.$pid.'/'.$file_name;
	@unlink($log_file);
}

//清空某个采集器的日志
function del_pick_log($pid){
	$log_dir = PICK_PATH.'/data/log/'.$pid;
	require_once(PICK_DIR.'/lib/cache.class.php');
	IO::rm($log_dir);
}


function pick_log($msg, $args = array() ){
	extract($args);
	$log_dir = PICK_PATH.'/data/log/'.$pid.'/';
	$log_file = $log_dir.date("Y-m-d", time()).'.txt';
	if(!is_dir($log_dir)) dmkdir($log_dir);
	$msg = clear_ad_html($msg);
	$msg = str_replace(milu_lang('loading'), '', $msg);
	if($memory) $m_str = 'memory:'.$memory;
	$log_str .= date("Y-m-d H:i:s").'	'.$m_str.'	'.strip_tags($msg)."\r\n";
	$log_str .= str_repeat('-',100)."\r\n";
	require_once(PICK_DIR.'/lib/cache.class.php');
	IO::write($log_file, $log_str, 1);
}




function get_other_test(){
	global $_G;
	pload('F:spider');
	$url = format_url($_GET['url']);
	$args['from_get_type'] = format_url($_GET['from_get_type']);
	$args['author_get_type'] = format_url($_GET['author_get_type']);
	$args['dateline_get_type'] = format_url($_GET['dateline_get_type']);
	$args['from_get_rules'] = format_url($_GET['from_get_rules']);
	$args['author_get_rules'] = format_url($_GET['author_get_rules']);
	$args['dateline_get_rules'] = format_url($_GET['dateline_get_rules']);
	$login_cookie = format_cookie($_GET['login_cookie']);
	
	$contents = get_contents($url, array('cookie' => $login_cookie));
	$data = get_other_info($contents, $args);
	$show_time = str_format_time($data['article_dateline']);
	$show_time = $show_time ? dgmdate($show_time) : '';
	if(!$data){
		$output = milu_lang('no_get_info');
	}else{
		$output = '<table class="tb tb2 "><tbody><tr class="header"><th width="51">'.milu_lang('field_name').'</th><th width="220">'.milu_lang('the_get_info').'</th><th width="80">'.milu_lang('trun_info').'</th></tr>
		
		<tr class="td24"><td class="td25">'.milu_lang('article_from').'</td><td class="td24">'.$data['from'].'</td><td>'.milu_lang('no_turn').'</td></tr>
		<tr class="td24"><td class="td25">'.milu_lang('old_author').'</td><td class="td24">'.$data['author'].'</td><td>'.milu_lang('no_turn').'</td></tr>
		<tr class="td24"><td class="td25">'.milu_lang('public_time').'</td><td class="td24">'.$data['article_dateline'].'</td><td>'.$show_time.'</td></tr>
		
		</tr></tbody></table>';
		if($args['dateline_get_rules']){
		 	$output .= milu_lang('get_other_notice');
		}
	}
	show_pick_window(milu_lang('get_other_show'), $output, array('w' => 645,'h' => '460','f' => 1));
}



function pick_match_rules(){
	$url = format_url($_GET['url']);d_s();
	$content = get_contents($url);
	$v = match_rules($url, $content, 2, 0);
	if(!$v || !is_array($v)) {
		$v = pick_match_coloud_rules($url);
		if($v['data_type'] == 1) {
			pload('F:rules');
			$v = $v['data'];
			rules_add($v);
			del_search_index(2);
		}	
	}
	if(!$v || !is_array($v)) return 'no';
	
	$re_arr = array($v['rules_type'],$v['rules_hash']);
	return json_encode($re_arr);
}

//搜索服务端规则
function pick_match_coloud_rules($url, $get_type = 2){
	
	$args = array(
		'get_type' => $get_type,
		'url' => $url,
	);
	$rpcClient = rpcClient();
	$client_info = get_client_info();
	$re = $rpcClient->cloud_match_rules($args, $client_info);
	if(is_object($re) || $re->Number == 0){
		if($re->Message) return  milu_lang('phprpc_error', array('msg' => $re->Message));
		$re = (array)$re;
	}
	return $re;
}

//导出文章
function export_article(){
	global $_G;
	$pid = intval($_GET['pid']);
	$pick_info = get_pick_info($pid, 'name');
	
	$query = DB::query("SELECT aid FROM ".DB::table('strayer_article_title')." WHERE pid ='$pid' ORDER BY aid DESC");	
	while(($v = DB::fetch($query))) {
		$a_info = article_info($v['aid']);
		//print_r($a_info);exit();
		if($a_info) $data[] = array(
			'title' => $a_info['title'],
			'summary' => $a_info['summary'],
			'url_hash' => $a_info['url_hash'],
			'url' => $a_info['url'],
			'dateline' => $a_info['dateline'],
			'content_arr' => $a_info['content_arr'],
			'reply' => $a_info['content_arr'],
			'is_bbs' => $a_info['is_bbs'],
			'from' =>  $a_info['from'],
			'fromurl' => $a_info['fromurl'],
			'author' =>  $a_info['author'],
			'article_tag' => $a_info['article_tag'],
			'tag' =>  $a_info['tag'],
			'pic' => $a_info['pic'],
			'contents' => $a_info['contents'],
			'reply_num' =>  $a_info['reply_num'],
		);
	}
	if(!$data) cpmsg_error(milu_lang('no_article_export'));
	$filename = $pick_info['name'].milu_lang('export_article_count', array('c' => count($data)) );
	export_article_file($data, $filename);
}



function export_article_file($data, $filename){
	$text = base64_encode(serialize($data));
	require_once libfile('class/zip');
	$zip = new zipfile();
	$zip->addFile($text, $filename.'.txt');
	$text = $zip->file();
	export_file($text, $filename.'.zip');
}

//导入文章
function import_article(){
	global $_G;
	$file_name = PICK_CACHE.'/temp_im.zip';
	if(!$_GET['checking'])  {
		$tmp_name =  str_iconv($_FILES['file']['tmp_name']);
		$fp = fopen($tmp_name, 'r');
		$data = fread($fp,$_FILES['file']['size']);
		$flag = file_put_contents($file_name, $data);
		cpmsg(milu_lang('import_article_loading'), PICK_GO.'picker_manage&myac=import_article&checking=1&pid='.$_GET['pid'], 'loading', '', false);
	}	
	require_once libfile('class/zip');
	$zip_obj = new SimpleUnzip($file_name);
	$total = 0;
	foreach($zip_obj->Entries as $k => $v){
		$data = unserialize(base64_decode(dstripslashes($v->Data)));
		//print_r($data);exit();
		$total += import_article_data($data);
		
	}
	@unlink($file_name);
	cpmsg(milu_lang('import_article_success', array('c' => $total)), PICK_GO."picker_manage", 'succeed');
}

function import_article_data($data, $pid = ''){
	$pid = $pid ? $pid : intval($_GET['pid']);
	if(!is_array($data)) return;
	$c = 0;
	foreach($data as $k => $v){
		
		$content_arr = $v['is_bbs'] == 1 ? $v['reply'] : $v['content_arr'];
		unset($v['content_arr'], $v['reply']);
		$v = paddslashes($v);
		if(!$v['url_hash']) continue;
		$count = DB::result(DB::query("SELECT COUNT(*) FROM ".DB::table('strayer_article_title')." WHERE url_hash='$v[url_hash]' AND pid='$pid'"), 0);
		if($count) continue; 
		$v['pid'] = $pid;
		unset($v['aid']);
		$aid = DB::insert('strayer_article_title', $v, TRUE);
		$c++;
		unset($setarr);
		
		foreach($content_arr as $k2 => $v2){
			$v2['aid'] = $aid;
			unset($v2['cid']);
			$v2 = paddslashes($v2);
			$cid = DB::insert('strayer_article_content', $v2, TRUE);
		}
	}
	return $c;
}


?>