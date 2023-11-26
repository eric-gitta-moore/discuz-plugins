<?php

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

//规则详情
function fastpick_info($id='', $field = '*', $table = 'fastpick'){
	global $_G;
	$id = $id ? $id : $_GET['id'];
	$id = intval($id);
	return DB::fetch_first("SELECT $field FROM ".DB::table('strayer_'.$table)." WHERE id='$id'");
}

function fastpick_evo_test(){
	pload('F:spider');
	$id = intval($_GET['id']);
	$rules_info = fastpick_info($id, '*', 'evo');
	$content = get_contents($rules_info['detail_ID_test']);
	$re = evo_rules_get_article($content, $rules_info);
	show_pick_window($re['title'], $re['content'], array('w' => 650,'h' => '460','f' => 1));
}


//列出一键采集规则
function fastpick_manage(){
	global $head_url,$header_config;
	$page = $_GET['page'] ? intval($_GET['page']) : 1;
	$perpage = 25;
	$start = ($page-1)*$perpage;
	$mpurl .= '&perpage='.$perpage;
	$perpages = array($perpage => ' selected');
	$mpurl = '?'.PICK_GO.'fast_pick&myac=fastpick_manage';
	$count = DB::result(DB::query("SELECT COUNT(*) FROM ".DB::table('strayer_fastpick')), 0);
	if($count) {
		$query = DB::query("SELECT * FROM ".DB::table('strayer_fastpick')." ORDER BY id DESC LIMIT $start,$perpage ");	
		while(($v = DB::fetch($query))) {
			$v['rule_desc'] = cutstr(trim($v['rule_desc']), 245);
			$info['rs'][] = $v;
		}
	}
	$info['multipage'] = multi($count, $perpage, $page, $mpurl);
	$info['count'] = $count;
	$info['is_lan'] = check_env(2, 0) ? 'no' : 'yes';
	if(!submitcheck('submit')) {
		$info['header'] = pick_header_output($header_config, $head_url);
		return $info;
	}else{
		$set = $_GET['set'];
		$set['member_field'] = serialize($_REQUEST['member_field']);
		pick_common_set($set);
		cpmsg(milu_lang('op_success'), PICK_GO."member", 'succeed');	
	}
}

//编辑规则
function fastpick_edit(){
	global $head_url,$header_config;
	$id = intval($_GET['id']);
	$copy = $_GET['copy'];
	
	if(!submitcheck('addsubmit')) {
		num_limit('strayer_fastpick', 3000, 'f_num_limit');
		$trun_info = get_trun_data();
		$info = $trun_info ? $trun_info : fastpick_info($id);
		$info['theme_url_test'] = $info['theme_url_test'] ? $info['theme_url_test'] : $info['detail_ID_test'];
		$info = pstripslashes($info);
		$info['title_filter_rules'] = dunserialize($info['title_filter_rules']);
		$info['content_filter_rules'] = dunserialize($info['content_filter_rules']);
		$info['content_filter_html'] = dunserialize($info['content_filter_html']);
		$info['header'] = pick_header_output($header_config, $head_url);
		$info['id'] = $id;
		return $info;
	}else{
		$setarr = $_GET['set'];
		$setarr['detail_ID'] = trim($setarr['detail_ID']);
		$setarr = dstripslashes($setarr);
		
		$setarr['title_filter_rules'] = serialize(dstripslashes($_GET['title_filter_rules']));
		$setarr['content_filter_rules'] = serialize(dstripslashes($_GET['content_filter_rules']));
		$setarr['content_filter_html'] = serialize(dstripslashes($_GET['content_filter_html']));
		
		if(empty($setarr['rules_name'])) cpmsg_error(milu_lang('rules_no_empty'));
		$setarr = paddslashes($setarr);
		if($id && !$copy){
			$msg = milu_lang('modify');
			DB::update('strayer_fastpick', $setarr, array('id' => $id));
		}else{
			$setarr['rules_hash'] = create_hash();
		
			$id = DB::insert('strayer_fastpick', $setarr, TRUE);
			$msg =  milu_lang('add');
		}
		$url = PICK_GO.'fast_pick&myac=fastpick_edit&id='.$id;
		if(!$id) cpmsg_error($msg.milu_lang('fail'));
		del_search_index(1);
		cpmsg(milu_lang('rules_notice', array('msg' => $msg)), $url, 'succeed');
	}
}


//导入规则
function fastpick_import(){
	global $head_url,$header_config;
	if(!submitcheck('submit')) {
		$info['header'] = pick_header_output($header_config, $head_url);
		num_limit('strayer_fastpick', 3000, 'f_num_limit');
		return $info;
	}else{
		$rules_code = $_GET['rules_code'];
		if($rules_code){
			$data = $rules_code;
		}else{
			$file_name =  str_iconv($_FILES['rules_file']['tmp_name']);
			$fp = fopen($file_name, 'r');
			$data = fread($fp,$_FILES['rules_file']['size']);
		}
		//print_r($data);
		$arr = pimportfile($data);
		if(empty($arr['rules_name'])) $arr['rules_name'] = $_G['timestamp'];
		unset($arr['id'], $arr['version']);	//销毁采集器记录的ID与 版本号
		if($arr['pick']['pid']) cpmsg_error(milu_lang('import_error2', array('url' => PICK_GO)));
		if(!$arr['rules_hash']){
			cpmsg_error(milu_lang('rules_error_data'));
		}
		$check = DB::result(DB::query("SELECT COUNT(*) FROM ".DB::table('strayer_fastpick')." WHERE id='$arr[id]'"), 0);
		if($check && !$update_flag){
			if(!$rules_code) $rules_code = $data;
			cpmsg(milu_lang('cover_notice').'?<input type="hidden" value="'.dstripslashes($rules_code).'" name="rules_code">', PICK_GO.'picker_manage&myfunc=rules_import&pid='.$pid.'&addsubmit=1&update_flag=1', 'form');
		}
		$arr = get_table_field_name('strayer_fastpick', $arr);
		unset($arr['rid']);//去掉主键
		$arr = paddslashes($arr);	
		if($update_flag){
			$rules_hash = $arr['rules_hash'];
			unset($arr['rules_hash']);
			DB::update('strayer_fastpick', $arr, array('rules_hash' => $rules_hash));
		}else{
			DB::insert('strayer_fastpick', $arr, TRUE);
		}
		del_search_index(1);
		cpmsg(milu_lang('import_finsh'), PICK_GO."fast_pick&myac=fastpick_import", 'succeed');	
	}
}



//导出规则
function fastpick_export() {
	global $_G;
	$id = $_GET['id'];
	if(!$id) cpmsg_error(milu_pick('select_rules'));
	$rules_info = fastpick_info($id);
	unset($rules_info['id']);
	$args = array(
		'type' => milu_lang('fastpick_rules'),
		'author' => $_G['setting']['bbname'],
		'rules_name' => $rules_info['rules_name'],
		'rule_desc' => $rules_info['rule_desc'],
	);
	$info['version'] = PICK_VERSION;
	exportfile($rules_info,$rules_info['rules_name'], $args);
}

function fastpick_set(){
	global $head_url,$header_config;
	if(!submitcheck('submit')) {
		require_once libfile('function/forumlist');
		$info = pick_common_get();
		$info['fp_open_mod'] = dunserialize($info['fp_open_mod']);
		$info['fp_open_mod'][0] = in_array(1, $info['fp_open_mod']) ? 1 : 0;//门户
		$info['fp_open_mod'][1] = in_array(2, $info['fp_open_mod']) ? 1 : 0;//论坛
		
		$info['fp_forum'] = dunserialize($info['fp_forum']);
		$info['fp_usergroup'] = dunserialize($info['fp_usergroup']);
		$info['forumselect'] = '<select name="set[fp_forum][]" size="10" multiple="multiple"><option value="">'.cplang('plugins_empty').'</option>'.forumselect(FALSE, 0, $info['fp_forum'], TRUE).'</select>';
		$info['header'] = pick_header_output($header_config, $head_url);
		return $info;
	}else{
		$set = $_GET['set'];
		
		$set['fp_open_mod'] = serialize($set['fp_open_mod']);
		
		if(!$set['fp_forum'][0] && count($set['fp_forum']) == 1) $set['fp_forum'] = '';
		if(!$set['fp_usergroup'][0] && count($set['fp_usergroup']) == 1) $set['fp_usergroup'] = '';
		pick_common_set($set);
		cpmsg(milu_lang('op_success'), PICK_GO."fast_pick&myac=fastpick_set", 'succeed');	
	}
}


function fastpick_del(){
	global $_G;
	$id = $_GET['id'];
	if(!$id) cpmsg_error(milu_lang('select_rules'));
	$confirm = $_GET['confirm'];
	if($confirm || is_array($id)){
		$id_arr = is_array($id) ? $id : array($id);
		foreach($id_arr as $id){
			DB::query('DELETE FROM '.DB::table('strayer_fastpick')." WHERE id= '$id'");
		}
		cpmsg(milu_lang('rules_del_success').'!', PICK_GO.'fast_pick&myac=fastpick_manage', 'succeed');
	}else{
		cpmsg(milu_lang('del_confirm'), PICK_GO.'fast_pick&myac=fastpick_del&id='.$id.'&confirm=1', 'form');
	}
}

function fastpick_share(){
	global $_G,$head_url,$header_config;
	$info = get_share_serach('fastpick');
	$info['header'] = pick_header_output($header_config, $head_url);
	return $info;
}

function share_fast_pick_data(){
	global $_G;
	$id = intval($_GET['id']);
	if(!$id) exit('error');
	$client_info = get_client_info();
	if(!$client_info) return milu_lang('share_no_allow');
	$rules_data = fastpick_info($id);
	if(!$rules_data) exit('error');
	$rpcClient = rpcClient();
	unset($rules_data['id'], $rules_data['login_cookie']);
	$rules_data['rules_name'] = $_GET['rules_name'];
	$rules_data['rule_desc'] = $_GET['rules_desc'];
	$re = $rpcClient->upload_data('fastpick', $rules_data, $client_info);
	if(is_object($re) || $re->Number == 0){
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


function download_fast_pick_data(){
	$id = intval($_GET['id']);
	$rpcClient = rpcClient();
	$client_info = get_client_info();
	$re = $rpcClient->download_data('fastpick', $id, $client_info);
	if(is_object($re) || $re->Number == 0){
		if($re->Message) return  milu_lang('phprpc_error', array('msg' => $re->Message));
		$re = (array)$re;
	}
	$re = serialize_iconv($re);
	import_fastpick_data($re);
	return 'ok';
}


function import_fastpick_data($arr){
	$check = DB::result(DB::query("SELECT COUNT(*) FROM ".DB::table('strayer_fastpick')." WHERE rules_hash='$arr[rules_hash]'"), 0);
	$arr = get_table_field_name('strayer_fastpick', $arr);
	unset($arr['id']);//去掉主键
	$arr = paddslashes($arr);
	del_search_index(1);	
	if($check){
		$rules_hash = $arr['rules_hash'];
		unset($arr['rules_hash']);
		 DB::update('strayer_fastpick', $arr, array('rules_hash' => $rules_hash));
	}else{
		return DB::insert('strayer_fastpick', $arr, TRUE);
	}
}

function import_evo_data($arr){
	global $_G;
	$arr = paddslashes($arr);
	$check = DB::result(DB::query("SELECT COUNT(*) FROM ".DB::table('strayer_evo')." WHERE domain_hash='$arr[domain_hash]' AND detail_ID_hash='$arr[detail_ID_hash]' AND status='1'"), 0);
	if($check) return;
	//删除之前的一些记录
	DB::query('DELETE FROM '.DB::table('strayer_evo')." WHERE domain_hash='$arr[domain_hash]' AND detail_ID_hash='$arr[detail_ID_hash]' AND status='0'");
	$arr['dateline'] = $_G['timestamp'];
	$arr['hit_num'] = 1;
	$arr['status'] = 1;
	$arr = get_table_field_name('strayer_evo', $arr);
	unset($arr['id']);//去掉主键
	del_search_index(3);
	return DB::insert('strayer_evo', $arr, TRUE);
}


function fast_pick(){
	global $_G;
	d_s('f_g');
	d_s('g_t');
	pload('F:spider');
	$url = $_GET['url'];
	$content = get_contents($url, array('cache' => -1));
	$get_time = d_e(0, 'g_t');
	$type = $_GET['type'] ? $_GET['type'] : 'bbs';

	$milu_set = pick_common_get();

	$data = (array)get_single_article($content, $url);
	
	if($milu_set['fp_word_replace_open'] == 1 && !VIP){//开启同义词替换
		$words = get_replace_words();
		if($data['title']) $data['title'] = strtr($data['title'], $words);
		if($data['content']) $data['content'] = strtr($data['content'], $words);
	}

	
	if($milu_set['fp_article_from'] == 1){//开启来源
		$data['fromurl'] = $url;
		if($type == 'bbs' && $data['content']){
			$data['content'] .= "[p=30, 2, left]".milu_lang('article_from').':'.$url."[/p]";
		}
	}
	$data['get_text_time'] = $get_time;
	$data['all_get_time'] = d_e(0, 'f_g');
	$data = $data ? $data : array();
	$data = js_base64_encode($data);
	$re = json_encode($data);
	return $re;
}

// type 1是单帖 2是内置规则 3学习到的规则
function write_evo_errlog($data, $url, $rule_info, $type = 0){
	global $_G;
	
	if(!$rule_info || !$url) return;
	if($data['title'] && $data['content']) return;
	if(!$data['title'] && $data['content']) {
		$why = 1;
	}else if(!$data['content'] && $data['title']){
		$why = 2;
	}else{
		$why = 0;
	}

	$p_key = 'id';
	if(!$type){
		if(array_key_exists('url_var', $rule_info)){//内置规则
			$type = 2;
			$p_key = 'rid';
		}else if(array_key_exists('evo_title_info', $rule_info)){//学习到的规则
			$type = 3;
		}else{
			$type = 1;
		}
	}
	if(!$rule_info[$p_key]) return;
	$set['why'] = $why;
	$set['dateline'] = $_G['timestamp'];
	$set['type'] = $type;
	$set['url'] = $url;
	$set['data_id'] = $rule_info[$p_key];
	$set['rules_name'] = $rule_info['rules_name'];
	$count = DB::result(DB::query("SELECT COUNT(*) FROM ".DB::table('strayer_evo_log')." WHERE type='$type' AND data_id='$rule_info[$p_key]' AND url='".daddslashes($url)."'"), 0);
	if($count) return;
	$set = paddslashes($set);
	return DB::insert('strayer_evo_log', $set, TRUE);
}

function fastpick_evo(){
	global $head_url,$header_config;
	$page = $_GET['page'] ? intval($_GET['page']) : 1;
	$perpage = 25;
	$start = ($page-1)*$perpage;
	$mpurl .= '&perpage='.$perpage;
	$perpages = array($perpage => ' selected');
	$mpurl = '?'.PICK_GO.'fast_pick&myac=fastpick_evo';
	$count = DB::result(DB::query("SELECT COUNT(*) FROM ".DB::table('strayer_evo')." WHERE status<>0"), 0);
	if($count) {
		$query = DB::query("SELECT * FROM ".DB::table('strayer_evo')." WHERE status<>0 ORDER BY dateline LIMIT $start,$perpage ");	
		while(($v = DB::fetch($query))) {
			$v['dateline'] = dgmdate($v['dateline']);
			$v['show_detail_ID_test'] = cutstr($v['detail_ID_test'], 20);
			$v['theme_rules'] = dhtmlspecialchars($v['theme_rules']);
			$v['content_rules'] = dhtmlspecialchars($v['content_rules']);
			$v['full_theme_rules'] = $v['theme_rules'];
			$v['full_content_rules'] = $v['content_rules'];
			$v['theme_rules'] = cutstr($v['theme_rules'], 20);
			$v['content_rules'] = cutstr($v['content_rules'], 20);
			$v['detail_ID'] = dhtmlspecialchars($v['detail_ID']);
			$info['rs'][] = $v;
		}
	}
	$info['multipage'] = multi($count, $perpage, $page, $mpurl);
	$info['count'] = $count;
	$info['header'] = pick_header_output($header_config, $head_url);
	return $info;
	
}

function fastpick_evo_del(){
	$id = $_GET['id'];
	if($id){
		$id_arr = is_array($id) ? $id : array($id);
		$id_str = base64_encode(serialize($id_arr));
	}
	$submit = $_GET['submit'];
	if($submit){
		$id_arr = unserialize(base64_decode($_GET['id_str']));
		DB::query("DELETE FROM ".DB::table('strayer_evo')." WHERE id IN (".dimplode($id_arr).")");
		DB::query("DELETE FROM ".DB::table('strayer_searchindex')." WHERE rid IN (".dimplode($id_arr).") AND type='34'");		
		cpmsg(milu_lang('del_finsh'), PICK_GO."fast_pick&myac=fastpick_evo", 'succeed');
	}else{
		cpmsg(milu_lang('del_confirm'), PICK_GO.'fast_pick&myac=fastpick_evo_del&id_str='.$id_str.'&submit=1', 'form');
	}	
}

function fastpick_evo_log(){
	global $head_url,$header_config;
	$page = $_GET['page'] ? intval($_GET['page']) : 1;
	$perpage = 25;
	$start = ($page-1)*$perpage;
	$mpurl .= '&perpage='.$perpage;
	$perpages = array($perpage => ' selected');
	$mpurl = '?'.PICK_GO.'fast_pick&myac=fastpick_evo_log';
	$count = DB::result(DB::query("SELECT COUNT(*) FROM ".DB::table('strayer_evo_log')), 0);
	$type_arr = array('1' => milu_lang('fast_pick_rules'), '2' => milu_lang('system_rules'), '3' => milu_lang('fastpick_evo'));
	$why_arr =  array('1' => milu_lang('no_get_title'), '2' => milu_lang('no_get_content'), '0' => milu_lang('no_get_all'));
	if($count) {
		$query = DB::query("SELECT * FROM ".DB::table('strayer_evo_log')." ORDER BY dateline DESC LIMIT $start,$perpage ");	
		while(($v = DB::fetch($query))) {
			$v['dateline'] = dgmdate($v['dateline']);
			$v['show_type'] = $type_arr[$v['type']];
			$v['show_why'] = $why_arr[$v['why']];
			$v['show_url'] = cutstr($v['url'], 50);
			if($v['type'] == 1){
				$v['go_url'] = '?'.PICK_GO.'fast_pick&myac=fastpick_edit&id='.$v['data_id'];
			}else if($v['type'] == 2){
				$v['go_url'] = '?'.PICK_GO.'system_rules&myac=rules_edit&rid='.$v['data_id'];
			}else if($v['type'] == 3){
				$v['go_url'] = '';
			}
			$info['rs'][] = $v;
		}
	}
	$info['multipage'] = multi($count, $perpage, $page, $mpurl);
	$info['count'] = $count;
	$info['header'] = pick_header_output($header_config, $head_url);
	return $info;
}

function fastpick_evo_log_del(){
	$id = $_GET['id'];
	if($id){
		$id_arr = is_array($id) ? $id : array($id);
		$id_str = base64_encode(serialize($id_arr));
	}
	$submit = $_GET['submit'];
	if($submit){
		$id_arr = unserialize(base64_decode($_GET['id_str']));
		DB::query("DELETE FROM ".DB::table('strayer_evo_log')." WHERE id IN (".dimplode($id_arr).")");
		cpmsg(milu_lang('del_finsh'), PICK_GO."fast_pick&myac=fastpick_evo_log", 'succeed');
	}else{
		cpmsg(milu_lang('del_confirm'), PICK_GO.'fast_pick&myac=fastpick_evo_log_del&id_str='.$id_str.'&submit=1', 'form');
	}	
}
?>