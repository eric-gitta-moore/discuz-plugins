<?php
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

function rules_share(){
	global $_G,$head_url,$header_config;
	$info = get_share_serach('rule');
	$info['header'] = pick_header_output($header_config, $head_url);
	return $info;
}

function download_system_rules_data(){
	$rid = intval($_GET['id']);
	if(!$rid) return 'error';
	$rpcClient = rpcClient();
	$client_info = get_client_info();
	$re = $rpcClient->download_data('rule', $rid, $client_info);
	if(is_object($re) || $re->Number == 0){
		if($re->Message) return  milu_lang('phprpc_error', array('msg' => $re->Message));
		$re = (array)$re;
	}
	if($re){
		$re = serialize_iconv($re);
		rules_add($re);
		return 'ok';
	}else{
		return 0;
	} 
}

function rules_add($rules_data){
	if(!$rules_data) return;
	$rules_data = serialize_iconv($rules_data);
	$rules_data = get_table_field_name('strayer_rules', $rules_data);
	$rules_hash = $rules_data['rules_hash'];
	$check = DB::result(DB::query("SELECT COUNT(*) FROM ".DB::table('strayer_rules')." WHERE rules_hash ='".$rules_hash."'"),0);
	$rules_data = paddslashes($rules_data);
	unset($rules_data['rid']);
	del_search_index(2);	
	if($check){
		DB::update("strayer_rules", $rules_data, array("rules_hash" => $rules_hash));
		return 1;
	}else{
		$pid = DB::insert('strayer_rules', $rules_data, TRUE);
		return 2;
	}
}

function share_system_rules_data(){
	global $_G;
	$rid = intval($_GET['id']);
	if(!$rid) exit('error');
	$client_info = get_client_info();
	if(!$client_info) return milu_lang('share_no_allow');
	$rules_data = get_rules_info($rid);
	if(!$rules_data) exit('error');
	$rpcClient = rpcClient();
	unset($rules_data['rid']);
	$rules_data['rules_name'] = $_GET['rules_name'];
	$rules_data['rule_desc'] = $_GET['rules_desc'];
	$re = $rpcClient->upload_data('rule', $rules_data, $client_info);
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

function get_rules_info($rid = '', $field = '*'){
	global $_G;
	$rid = $rid ? $rid : $_GET['rid'];
	$where_field = is_numeric($rid) ? 'rid' : 'rules_hash';
	if($where_field == 'rules_hash' && !$rid) return array();
	return DB::fetch_first("SELECT $field FROM ".DB::table('strayer_rules')." WHERE $where_field='$rid'");
}


function rules_list(){
	global $_G,$head_url,$header_config;
	$page = $_GET['page'] ? intval($_GET['page']) : 1;
	$perpage = 35;
	$start = ($page-1)*$perpage;
	$mpurl .= '&perpage='.$perpage;
	$perpages = array($perpage => ' selected');
	$mpurl = '?'.PICK_GO.'system_rules&myac=rules_list';
	$count = DB::result(DB::query("SELECT COUNT(*) FROM ".DB::table('strayer_rules')), 0);
	if($count) {
		$query = DB::query("SELECT * FROM ".DB::table('strayer_rules')." ORDER BY rid DESC LIMIT $start,$perpage ");	
		while(($v = DB::fetch($query))) {
			$v['rule_desc'] = cutstr(trim($v['rule_desc']), 245);
			$data['rs'][] = $v;
		}
	}
	$data['header'] = pick_header_output($header_config, $head_url);
	$data['is_lan'] = check_env(2, 0) ? 'no' : 'yes';
	$data['multipage'] = multi($count, $perpage, $page, $mpurl);
	return $data;
}
function rules_edit(){
	global $_G,$header_config,$head_url;
	$submit = $_GET['addsubmit'];
	$setarr = $_POST['set'];
	$setarr['list_ID'] = trim($setarr['list_ID']);
	$setarr['detail_ID'] = trim($setarr['detail_ID']);
	$rid = $_GET['rid'] ? $_GET['rid'] : $_GET['rules_hash'];
	$copy =$_GET['pick_copy'];
	$setarr = dstripslashes($setarr);
	$setarr['url_var'] = serialize(dstripslashes($_GET['url_var']));
	$setarr['title_filter_rules'] = serialize(dstripslashes($_GET['title_filter_rules']));
	$setarr['content_filter_rules'] = serialize(dstripslashes($_GET['content_filter_rules']));
	$setarr['reply_filter_rules'] = serialize(dstripslashes($_GET['reply_filter_rules']));
	if($submit){
		if(empty($setarr['rules_name'])) cpmsg_error(milu_lang('rules_no_empty'));
		$copy = $_GET['copy'];
		if($rid && !$copy){
			$msg = milu_lang('modify');
			if(empty($setarr['reply_is_extend'])) $setarr['reply_is_extend'] = 0;
			DB::update('strayer_rules', $setarr, array('rid' => $rid));
		}else{
			$setarr['rules_hash'] = create_hash();
			$rid = DB::insert('strayer_rules', $setarr, TRUE);
			$msg =  milu_lang('add');
		}
		$url = PICK_GO.'system_rules&myac=rules_list&rid='.$rid;
		if(!$rid) cpmsg_error($msg.milu_lang('fail'));
		$rules_hash = $setarr['rules_hash'] ? $setarr['rules_hash'] : $_POST['rules_hash'];
		rules_update($rules_hash);//规则同步
		del_search_index(2);
		cpmsg(milu_lang('rules_notice', array('msg' => $msg)), $url, 'succeed');
	}else{
		num_limit('strayer_rules', 3000, 's_num_limit');
		$data = get_rules_info($rid);
		if($_GET['turn_type']){
			$data = get_trun_data();
			if($_GET['turn_type'] == 'picker') unset($data['rules_type']);
			$data['theme_url_test'] = $data['theme_url_test'] ? $data['theme_url_test'] : $data['detail_ID_test'];
			$data['detail_ID_test'] = $data['detail_ID_test'] ? $data['detail_ID_test'] : $data['theme_url_test'];
		}
		$data = dstripslashes($data);
		$data['url_var'] = unserialize($data['url_var']);
		$data['title_filter_rules'] = unserialize($data['title_filter_rules']);
		$data['content_filter_rules'] = unserialize($data['content_filter_rules']);
		$data['reply_filter_rules'] = unserialize($data['reply_filter_rules']);
		$data = dhtmlspecialchars($data);
		$data['rid'] = $rid;
		$data['copy'] = $copy;
		$data['header'] = pick_header_output($header_config, $head_url);
		if(!$rid) $data['rule_author'] = $_G['setting']['bbname'];
		return $data;
	}
	
}
function rules_del() {
	global $_G;
	$rid = $_GET['rid'];
	if(!$rid) cpmsg_error(milu_lang('select_rules'));
	$confirm = $_GET['confirm'];
	if($confirm || is_array($rid)){
		$rid_arr = is_array($rid) ? $rid : array($rid);
		foreach($rid_arr as $rid){
			DB::query('DELETE FROM '.DB::table('strayer_rules')." WHERE rid= '$rid'");
		}
		cpmsg(milu_lang('rules_del_success').'!', PICK_GO.'system_rules&myac=rules_list&rid='.$rid, 'succeed');
	}else{
		cpmsg(milu_lang('del_confirm'), PICK_GO.'system_rules&myac=rules_del&rid='.$rid.'&confirm=1', 'form');
	}
}


function rules_export() {
	global $_G;
	$rid = $_GET['rid'];
	if(!$rid) cpmsg_error(milu_pick('select_rules'));
	$rules_info = get_rules_info($rid);
	unset($rules_info['rid']);
	exportfile($rules_info,$rules_info['rules_name']);
}

function rules_import(){
	global $_G,$header_config,$head_url;
	$data['header'] = pick_header_output($header_config, $head_url);
	$submit = $_GET['addsubmit'];
	$update_flag = $_GET['update_flag'];
	num_limit('strayer_rules', 3000, 's_num_limit');
	if($submit){
		$rules_code = $_GET['rules_code'];
		if($rules_code){
			$data = $rules_code;
		}else{
			$file_name =  str_iconv($_FILES['rules_file']['tmp_name']);
			$fp = fopen($file_name, 'r');
			$data = fread($fp,$_FILES['rules_file']['size']);
		}
		$arr = pimportfile($data);
		//采集器名称为空，则对将当前的时间戳做为采集器文件名
		if(empty($arr['rules_name'])) $arr['rules_name'] = $_G['timestamp'];
		unset($arr['rid'], $arr['version']);	//销毁采集器记录的ID与 版本号
		$arr = daddslashes($arr);		//对值重新addslashes操作
		if($arr['pick']['pid']) cpmsg_error(milu_lang('import_error2', array('url' => PICK_GO)));
		if(!$arr['rules_hash']){
			cpmsg_error(milu_lang('rules_error_data'));
		}
		$check = DB::result(DB::query("SELECT COUNT(*) FROM ".DB::table('strayer_rules')." WHERE rules_hash='$arr[rules_hash]'"), 0);
		if($check && !$update_flag){
			if(!$rules_code) $rules_code = $data;
			cpmsg(milu_lang('cover_notice').'?<input type="hidden" value="'.dstripslashes($data).'" name="rules_code">', PICK_GO.'system_rules&myac=rules_import&pid='.$pid.'&addsubmit=1&update_flag=1', 'form');
		}
		$arr = get_table_field_name('strayer_rules', $arr);
		unset($arr['rid']);//去掉主键
		if($update_flag){
			$rules_hash = $arr['rules_hash'];
			rules_update($rules_hash);
			unset($arr['rules_hash']);
			DB::update('strayer_rules', $arr, array('rules_hash' => $rules_hash));
		}else{
			DB::insert('strayer_rules', $arr, TRUE);
		}
		del_search_index(2);
		cpmsg(milu_lang('import_finsh'), PICK_GO."system_rules&myac=rules_list", 'succeed');
	}
	return $data;
}

function show_rules( $type=1, $html = 0 , $selected = ''){
	$query = DB::query("SELECT * FROM ".DB::table('strayer_rules')." WHERE rules_type = ".$type." ORDER BY rid DESC ");	
	while(($v = DB::fetch($query))) {
		if($selected && $v['rid'] == $selectd) $selected_html = 'selected="selected"'; 
		$str .= '<option '.$selected_html.' value="'.$v['rules_hash'].'">'.$v['rules_name'].'</option>';
		$rs[] = $v;
	}
	if($html){
		return $str;
	}else{
		return $rs;
	}
}


function create_variable(){
	global $_G;
	ob_clean();
	ob_end_flush();
	$url = format_url($_GET['url']);
	$rid = $_GET['rid'];
	$arr = explode('(*)', $url);
	$count = count($arr);
	$data = get_rules_info($rid);
	$url_var = unserialize($data['url_var']);
	for($i=1;$i<$count;$i++){
		if($url_var[$i]['var_type'][$i] ==  'select' || $url_var[$i]['var_type'][$i] ==  'selects'){
			 $show_keyword = "display:none";
			 
		}else{
			$show_ext = "display:none";
		}	 
		if($url_var[$i]['var_type'][$i] == 'text')  $select_text = 'selected="selected"';
		if($url_var[$i]['var_type'][$i] == 'textarea')  $select_textarea = 'selected="selected"';
		if($url_var[$i]['var_type'][$i] == 'select')  $select_select = 'selected="selected"';
		if($url_var[$i]['var_type'][$i] == 'selects')  $select_selects = 'selected="selected"';
		if($url_var[$i]['var_ext_keyword'][$i] == 1) $check_box = 'checked="checked" ';
		$html .= '<tr class="hover"><td><input name="url_var['.$i.'][var_title]['.$i.']" type="text" value="'.$url_var[$i]['var_title'][$i].'" class="shorttxt" id="var_title['.$i.']" size="15"></td><td><select class="var_ext_select_'.$i.'" onchange="show_var_ext(this.value, '.$i.')" name="url_var['.$i.'][var_type]['.$i.']" id="var_type['.$i.']">
			<option '.$select_text.' value="text" selected="">'.milu_lang('text').'(text)</option>
			<option '.$select_textarea.' value="textarea">'.milu_lang('textarea').'(textarea)</option>
			<option '.$select_select.' value="select">'.milu_lang('select').'(select)</option>
			<option '.$select_selects.' value="selects">'.milu_lang('selects').'(selects)</option>
		</select></td>
<td>
  <label id="var_keyword_'.$i.'" style="'.$show_keyword.'">
  <input '.$check_box.' name="url_var['.$i.'][var_ext_keyword]['.$i.']" type="checkbox" id="var_ext_keyword['.$i.']" value="checkbox" />'.milu_lang('open_keyword').'</label>
  <div id="var_select_'.$i.'" style="'.$show_ext.'"><textarea style="float:left" rows="6" ondblclick="textareasize(this, 1)" onkeyup="textareasize(this, 0)" name="url_var['.$i.'][var_ext_select]['.$i.']" id="var_ext_select['.$i.']" cols="50" class="tarea">'.$url_var[$i]['var_ext_select'][$i].'</textarea>
<span style="float:left"> <em>'.milu_lang('desc_demo').'</em> </span></div></td>
<td><textarea rows="6" ondblclick="textareasize(this, 1)" onkeyup="textareasize(this, 0)" name="url_var['.$i.'][var_desc]['.$i.']" id="var_desc'.$i.'" cols="50" class="tarea">'.$url_var[$i]['var_desc'][$i].'</textarea></td>
</tr>';
	    unset($show_keyword,$show_ext,$select_text,$select_textarea,$select_select,$select_selects);
	}
	echo $html;
	define(FOOTERDISABLED, false);
	exit();
}
?>