<?php
function select_output($option_arr, $ini_val, $select_name, $now_value = '', $flag = 0){
	$select = '<select name="'.$select_name.'" class="ps" >';
	foreach($option_arr as $k => $v){
		if(!$now_value) {
			$selected = ($flag == 0 ? $v : $k) == $ini_val ? 'selected="selected"' : '';
		}else{
			$selected = ($flag == 0 ? $v : $k) == $now_value ? 'selected="selected"' : '';
		}
		$select_value = $flag == 0 ? $v : $k;
		$select .= '<option '.$selected.' value="'.$select_value.'">'.$v.'</option>';
	}
	$select .= '</select>';
	return $select;
}

function radio_output($args, $info){
	extract($args);
	$str = '<ul onMouseOver="altStyle(this);">';
	$lang = $lang ? $lang : array('yes', 'no');
	if($int_val && !$info[$name]) $info[$name] = $int_val;
	$info[$name] = $info[$name] ? $info[$name] : 1;
	$count = count($lang) + 1;
 	for($i = 1; $i < $count; $i++){
		$li_checked = $info[$name] == $i ? 'class="checked"' : '';
		$radio_checked = $info[$name] == $i ? 'checked="checked"' : '';
		$show_lang = milu_lang($lang[$i-1]);
		$js_show = $js[($i-1)] ? 'onclick="'.$js[($i-1)].'"' : '';
		$str .= '<li  '.$li_checked.'><input '.$js_show.' '.$radio_checked.' name="set['.$name.']" type="radio" class="'.$name.'" id="'.$name.'_'.$i.'"  value="'.$i.'">
&nbsp;'.$show_lang.'</li>';
	}
	
	$str .= '</ul>';
	return $str;
}

function user_group_select($name, $ini_val = array()){
	global $_G,$lang;
	$name = $name ? $name : 'groupid';
	$groupselect = array();
	$usergroupid = $ini_val;
	$query = DB::query("SELECT type, groupid, grouptitle, radminid FROM ".DB::table('common_usergroup')." WHERE groupid NOT IN ('6', '7') ORDER BY (creditshigher<>'0' || creditslower<>'0'), creditslower, groupid");
	while($group = DB::fetch($query)) {
		$group['type'] = $group['type'] == 'special' && $group['radminid'] ? 'specialadmin' : $group['type'];
		$groupselect[$group['type']] .= "<option value=\"$group[groupid]\" ".(in_array($group['groupid'], $usergroupid) ? 'selected' : '').">$group[grouptitle]</option>\n";
	}
	$groupselect = '<optgroup label="'.$lang['usergroups_member'].'">'.$groupselect['member'].'</optgroup>'.
		($groupselect['special'] ? '<optgroup label="'.$lang['usergroups_special'].'">'.$groupselect['special'].'</optgroup>' : '').
		($groupselect['specialadmin'] ? '<optgroup label="'.$lang['usergroups_specialadmin'].'">'.$groupselect['specialadmin'].'</optgroup>' : '').
		'<optgroup label="'.$lang['usergroups_system'].'">'.$groupselect['system'].'</optgroup>';

	return '<select name="'.$name.'[]" multiple="multiple" size="10"><option value="">'.milu_lang('empty').'</option>'.$groupselect.'</select>';
}


//显示采集器底部的js
function bottom_js_output($info){
	if ($info['rules_type'] == 1){//采集器采用系统规则时，隐藏一些东西
		if ($info['rules_hash']) $show_bottom_js = "rules_show_page_set(1);hide_get_page('".$info['rules_hash']."');";
	}else if ($info['rules_type'] == 3 || !$info['rules_type']){
		$show_bottom_js = 'rules_show_page_set(3);';
	}else if($info['rules_type'] == 2){
		$show_bottom_js = 'rules_show_page_set(2);';
	}
	return $show_bottom_js;
}


function pick_loading($ajax_url, $finsh_url, $total, $args = array()){
	extract($args);
	$bat_num = $bat_num ? $bat_num : 2000;
	$str = "
			<script type=\"text/JavaScript\">
			var xml_http_building_link = '".cplang('xml_http_building_link')."';
			var xml_http_sending = '".cplang('xml_http_sending')."';
			var xml_http_loading = '".cplang('xml_http_loading')."';
			var xml_http_load_failed = '".cplang('xml_http_load_failed')."';
			var xml_http_data_in_processed = '".cplang('xml_http_data_in_processed')."';
			function show_data_loading(url, total, pp, currow) {
				var x = new Ajax('HTML', 'statusid');
				x.get(url+'&ajax=1&pp='+pp+'&total='+total+'&currow='+currow, function(s) {
					if(s != 'GO') {
						location.href = '$finsh_url';
					}
					currow += pp;
					var percent = ((currow / total) * 100).toFixed(0);
					percent = percent > 100 ? 100 : percent;
					var show_msg = percent == 100 ? '".milu_lang('run_finsh')."' : percent+'%';
					document.getElementById('percent').innerHTML = show_msg;
					document.getElementById('percent').style.backgroundPosition = '-'+percent+'%';
					if(currow < total) {
						show_data_loading(url, total, pp, currow);
					}
				});
			}
			show_data_loading('$ajax_url', $total, $bat_num, 0);
		</script>";
	return $str;	
}

function pcpmsg_loading($message, $url = '', $type = '', $values = array(), $extra = '', $halt = TRUE) {
	global $_G;
	$vars = explode(':', $message);
	$values['ADMINSCRIPT'] = ADMINSCRIPT;

	$classname = 'infotitle1';
	if($url) {
		$url = substr($url, 0, 5) == 'http:' ? $url : ADMINSCRIPT.'?'.$url;
	}
	$message = "<h4 class=\"$classname\">$message</h4>";
	$url .= $url && !empty($_G['gp_scrolltop']) ? '&scrolltop='.intval($_G['gp_scrolltop']) : '';

	$message = "<form method=\"post\" action=\"$url\" id=\"loadingform\"><input type=\"hidden\" name=\"formhash\" value=\"".FORMHASH."\"><br />$message$extra<img src=\"static/image/admincp/ajax_loader.gif\" class=\"marginbot\" /><br />".
	'<p class="marginbot"><a href="###" onclick="$(\'loadingform\').submit();" class="lightlink">'.cplang('message_redirect').'</a></p></form><br />';
	if($halt) {
		echo '<h3>'.cplang('discuz_message').'</h3><div class="infobox">'.$message.'</div>';
		exit();
	} else {
		echo '<div class="infobox">'.$message.'</div>';
	}
}


function show_test_text($name, $msg){
	global $_G;
	return '<p style="margin-bottom:5px;"><span style=" float:left;width:70px;">'.$name.':</span><textarea ondblclick="milu_view(\''.$_G['formhash'].rand(1,500).'\',this, \''.$name.'\')" class="tarea w_area"  cols="50" name="test" rows="6">'.$msg.'</textarea></p>';
}


function test_replace_rules($str, $rules){
	if(!$rules) return ;
	$rules = format_wrap(trim($rules));
	if($rules){
		foreach($rules as $k => $v){
			$v_arr = explode("@@", trim($v));
			$str = str_replace($v_arr[0], '<ins title="'.$v_arr[0].'">'.$v_arr[1].'</ins>', $str);
		}			
	}
	return $str;
}

function windos_show_link($link_arr,$url = '', $args = array(), $filter_args = array()){
	extract($args);
	if(!$count) $count = count($link_arr);
	if(!$notice) $notice = milu_lang('get_link', array('count' => $count));
	if($link_arr){
		$link_html = '<h1><a  target="_blank"  href="'.$url.'">'.$notice.':</a></h1><br>';
		$link_html .= '<ul class="show_debug">';
		$i = 1;
		foreach($link_arr  as $k=>$v){
			if($v == '0'){
				$link_html .= '<li>'.milu_lang('el').'</li>';
			}else{
				if($url) $v = _expandlinks($v, $url);
				if(filter_page_link($v, $filter_args)){ 
					$link_html .= '<li>'.$i.'. <a  target="_blank"  href="'.$v.'">'.cutstr($v, 65).'</a></li>';
				}else{
					$link_html .= '<li><del>'.$i.'. <a  target="_blank"  href="'.$v.'">'.cutstr($v, 65).'</a></del></li>';
				}
			}	
			$i++;
		}
		$link_html .= '</ul>';
	}else{	
		$link_html = milu_lang('get_link_no_data').'!';
	}
	return $link_html;
}

function create_rules_html($name = '', $rule_arr = array(), $show = FALSE){
	global $_G;
	if($_GET['name'] || $show) {
		ob_clean();
		ob_end_flush();
	}
	$name = $name ? $name : $_GET['name']; 
	$i = $_GET['i'] + 1;
	if(!$rule_arr){
		$rule_arr[$i] = $i;
	}
	$j = 0;
	foreach($rule_arr as $k => $v){
		$check = 'checked="checked"';
		if($v['type'] == 2 ){
			$check2 = $check;
		}else{
			$check1 = $check;
		}
		//$v['rules'] = dstripslashes($v['rules']);
		if($name == 'many_page_list'){
			$many_list_html = '<td width="450"><input name="'.$name.'['.$k.'][test]" type="text" class="mlongtxt" id="'.$name.'_'.$k.'_test" value="'.$v['test'].'">   <a  onclick="many_list_test(\''.$k.'\');" href="javascript:void(0)">'.milu_lang('test').'</a></td>';
			$width_pre = 'm'; 
		}
		$html .= '<tr id="tr_'.$name.'_'.$k.'" class="hover"><td width="100"><p><label><input '.$check1.' class="'.$name.'_type_'.$k.'" type="radio" name="'.$name.'['.$k.'][type]" value="1" />'.milu_lang('dom_get').'</label><br />
		<label><input '.$check2.' type="radio" name="'.$name.'['.$k.'][type]"  class="'.$name.'_type_'.$k.'" value="2" />'.milu_lang('text').'</label><br /></p></td><td width="200"><a id="insert_string_link"  href="javascript:void(0)"  onclick="insertAtCursor(\''.$name.'_'.$k.'_rules\',\'(*)\')">'.milu_lang('insert_var').'(*)</a><textarea rows="6" name="'.$name.'['.$k.'][rules]" id="'.$name.'_'.$k.'_rules"  cols="50" class="tarea '.$width_pre.'w_area" >'.$v['rules'].'</textarea></td>'.$many_list_html.'<td><a  onclick="del_rules(\'tr_'.$name.'_'.$k.'\');" href="javascript:void(0)">'.milu_lang('del').'</a></td></tr>';
		$j ++;
		unset($check1, $check2);
	}
	if($_GET['name'] || $show) {
		echo $html;
		define(FOOTERDISABLED, false);
		exit();
	}else{
		return $html;
	}	
	
}


//输出计划任务html
function show_cron_setting_output($info){
	$weekdayselect = $dayselect = $hourselect = '';
	$cronminute = str_replace("\t", ',', $info['cron_minute']);
	for($i = 0; $i <= 6; $i++) {
		$weekdayselect .= "<option value=\"$i\" ".($info['cron_weekday'] == $i ? 'selected' : '').">".cplang('misc_cron_week_day_'.$i)."</option>";
	}

	for($i = 1; $i <= 31; $i++) {
		$dayselect .= "<option value=\"$i\" ".($info['cron_day'] == $i ? 'selected' : '').">$i ".milu_lang('day')."</option>";
	}

	for($i = 0; $i <= 23; $i++) {
		$hourselect .= "<option value=\"$i\" ".($info['cron_hour'] == $i ? 'selected' : '').">$i ".milu_lang('hour')."</option>";
	}

	showsetting('misc_cron_edit_weekday', '', '', "<select name=\"set[cron_weekday]\"><option value=\"-1\">*</option>$weekdayselect</select>");
	showsetting('misc_cron_edit_day', '', '', "<select name=\"set[cron_day]\"><option value=\"-1\">*</option>$dayselect</select>");
	showsetting('misc_cron_edit_hour', '', '', "<select name=\"set[cron_hour]\"><option value=\"-1\">*</option>$hourselect</select>");
	showsetting('misc_cron_edit_minute', 'set[cron_minute]', $cronminute, 'text');
}

function show_filter_html($filter_html_arr  = array(), $input_name = 'content_filter_html'){
	global $_G;
	$filter_html = $_G['cache']['evn_milu_pick']['filter_html'];
	$html = '<ul class="filter_html">';
	foreach($filter_html as $k => $v){
		if($v['no_show'] == 1) continue;
		$charset = GBK ? 'gb2312' : 'UTF-8';
		$name = htmlentities($v['name'], ENT_QUOTES, $charset);
		$checked = in_array($k, $filter_html_arr) ? 'checked="checked"' : '';
		$html .=  '<li><label><input '.$checked.' type="checkbox" class="'.$input_name.'" value="'.$k.'"  name="'.$input_name.'[]">'.$name.'</label></li>';
	}
	$html .= '</ul>';
	return $html;
}

function show_var_html($key,$args, $now_v){
	//print_r($args);
	global $_G;
	$long_text = $_G['cache']['evn_milu_pick']['long_text'];
	$type = $args['var_type'][$key];
	$title = $args['var_title'][$key];
	$desc = $args['var_desc'][$key];
	$ext_select = $args['var_ext_select'][$key];
	$ext_keyword = $args['var_ext_keyword'][$key];
	if(!filter_something($title, $long_text)) {
		$text_class = 'longtxt';
	}else{
		$text_class = 'txt';
	}
	$tr_start = '<tr><td colspan="2" class="td27" s="1"><span class="vtop rowform">'.$title.':</span></td></tr><tr  class="noborder"><td class="vtop rowform">';
	if($type == 'text'){
		$body = '<input type="text" value="'.$now_v.'" id="rules_var_'.$key.'" class="'.$text_class.'" name="rules_var['.$key.']">';
		if($ext_keyword) $body .= show_keyword_html($key);
	}else if($type == 'textarea'){
		$body = '<textarea  class="tarea" cols="50" id="rules_var_'.$key.'" name="rules_var['.$key.']" onkeyup="textareasize(this, 0)" ondblclick="textareasize(this, 1)" rows="6">'.$now_v.'</textarea>';
		if($ext_keyword) $body .= show_keyword_html($key);
	}else if($type == 'select' || $type == 'selects'){
		$select_arr = format_wrap($ext_select);
		if(!$select_arr) $body = milu_lang('no_set_value');
		$multiple = $type == 'selects' ? 'multiple="multiple" style=" width:250px;" name="rules_var['.$key.'][]"' : 'name="rules_var['.$key.']"';
		$body = '<select  '.$multiple.' id="rules_var_'.$key.'">';
		foreach($select_arr as $k => $v){
			$v_arr = explode('=', $v);
			$selected = '';
			if(is_array($now_v)){
				if(in_array($v_arr[0], $now_v)) $selected = 'selected="selected"';
			}else{
				if($v_arr[0] == $now_v) $selected = 'selected="selected"';
			}
			$body .= '<option '.$selected.'  value="'.$v_arr[0].'">'.$v_arr[1].'</option>';
		}
		$body .= '</select>';
	}
	$tr_end = '<td s="1" class="vtop tips2">'.$desc.'</td></tr>';
	$html = $tr_start.$body.$tr_end;
	return $html;
}

function show_keyword_html($key, $type = 1){
	global $_G;
	$id = 'keyword_'.$key;
	if($_GET['type']) $type = $_GET['type'];
	if($_GET['key']) $key = $_GET['key'];
	$keyword = $_GET['keyword'];
	//$html .= '<span class="show_keyword_contain" id="'.$id.'"><a id="'.$id.'_link" class="showmenu" title="长尾关键词" onclick="show_keyword(\''.$id.'\');"  href="javascript:;">长尾关键词</a><span id="show_'.$id.'"></span></span>';
	$html .= '<span class="show_keyword_contain" id="'.$id.'"><span id="show_'.$id.'"></span></span>';
	 if($type == 1) return $html;
	 if($type == 2){
	 	ob_clean();
		ob_end_flush();
	 	$html = '<div class="show_keyword p_pof">
			<div class="pbm">
			<input class="search_keyword" name="" type="text" />  <input onclick="load_keyword(\''.$key.'\');" style="display:inline; float:none;" type="button" value="'.milu_lang('query').'"  class="btn">
			</div>
			<div class="ptn pbn" id="selBox">
			<ul class="xl xl2 cl" id="selectorBox">
				<em><img src="static/image/common/loading.gif"> '.milu_lang('querying').milu_lang('el').'</em>
			</ul>
			</div>
			<div class="cl">
				<span class="all_left"><label><input name="" type="checkbox" value="" />'.milu_lang('all_select').'</label></span>
				<button onclick="show_keyword(0)" class="y pn" type="button"><span>'.milu_lang('close').'</span></button>
			</div>
		</div>';
		echo $html;
		define(FOOTERDISABLED, false);
		exit();
	 }
}


function pick_search_select($select_name, $select_pid, $no_show_id = 0){
	$cat_arr = pick_category_list();
	$html = '<select name="'.$select_name.'"  ><option value="">'.milu_lang('now_select_picker').'</option>';
	foreach($cat_arr as $k_c => $v_c){
		$html .= '<optgroup label="'.$v_c[name].'">';
		$query = DB::query("SELECT name,pid FROM ".DB::table('strayer_picker')." WHERE pick_cid='$v_c[cid]' ORDER BY displayorder ASC,dateline DESC");
		while($rs = DB::fetch($query)) {
			if($rs['pid'] != $no_show_id || !$no_show_id){
				$selected = $rs['pid'] == $select_pid ? 'selected="selected"' : ''; 
				$html .= '<option '.$selected.' value="'.$rs['pid'].'">'.$rs['name'].'</option>';
			}
		}
		$html .= '</optgroup>';
	}
	$html .= '</select>';
	return $html;
}

function show_tips($msg, $args = array()){
	extract($args);
	$title = $title ? $title : milu_lang('msg_notice');
	$w = $w ? $w : 600;
	$h = $h ? $h : 387;
	$html = '<script type="text/javascript" language="javascript">
show_html_window(\''.$key.'\', \'<em>'.$title.'</em>\', '.$w.', '.$h.', \'<div class="c bart" style=" width:100%; height:'.($h - 60).'px;">'.$msg.'</div><p class="o pns"><button onclick="pick_tips(\\\''.$key.'\\\');hideWindow(\\\''.$key.'\\\');" class="pn pnc" name="dsf" type="submit"><span>'.milu_lang('never_notice').'</span></button></p>\');</script>';
	return $html;
}

?>