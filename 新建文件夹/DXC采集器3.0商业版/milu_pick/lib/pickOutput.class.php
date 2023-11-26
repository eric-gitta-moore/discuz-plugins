<?php

class pickOutput{
	public static function show_table($data, $name, $args = array()){
		$data_arr = $data[$name];
		$th_arr = $td_arr = $value_arr = array();
		$args['td_width'] = $args['td_width'] ? $args['td_width'] : 'auto';
		$args['table_width'] = $args['table_width'] ? $args['table_width'] : 'auto';
		foreach($data_arr as $k => $v){
			$th_arr[] = '<th class="split" width="'.$args['td_width'].'"><div class="box box-center">'.milu_lang($v['name']).'</div></th>';
			$value_arr = !is_array($v['value']) ? array($v['value']) : $v['value'];
			foreach($value_arr as $k2 => $v2){
				$td_arr[$k2][] = '<td class="split" width="'.$args['td_width'].'"><div class="box box-center">'.$v2.'</div></td>';
			}
		}
		$td_str = '';
		$th_str = implode('', $th_arr);
		foreach($td_arr as $k => $v){
			$td_str .= '<tr class="seo-general-keyword-summary  even ">'.implode('', $v).'</tr>';
		}
		return '<table  class="tb_seo table-2 table-seo-general" style="border-collapse:separate;  margin-right: 8px;width:'.$args['table_width'].'"><tbody><tr><caption><span style=" float:left">'.milu_lang($name).'</span>'.$args['caption'].'</caption></tr></tbody><tbody class="list-seo-general-keyword-detail"><tr class="header">'.$th_str.'</tbody> <tbody class="list_detail">'.$td_str.'</tbody></tbody><tbody></tbody><tbody></tbody></table>';
	}
	
	//输出头部
	public static function pick_header_output($args = array()){
		global $header_arr,$head_url;
		if(!$header_arr) return;
		$head_url = $head_url ? $head_url : '?'.PLUGIN_GO.$_GET['pmod'].'&myac=';
		$myac = $_GET['myac'];
		if(!$myac) $myac = $header_arr[0];
		$str = '<div class="itemtitle"><ul class="tab1" style="margin-top:8px;">';
		foreach($header_arr as $k => $v){	
			$current = $v == $myac || $args['current'] == $v ? 'class="current"' : ''; 
			$str .= '<li '.$current.'><a href="'.$head_url.$v.'"><span>'.milu_lang($v).'</span></a></li>';
		}
		$str .='</ul></div>';
		return $str;
	}
	
	static public function  show_tr($args , $type = 'input'){
		extract($args);
		$html = $html ? $html : self::$type($args['arr'], $args['info']);
		return "\n\r".self::add_tr($args, $html)."\n\r";
	}
	static public function add_tr($args, $html = ''){
		extract($args);
		$tr_id_str = $tr_id ? 'id="'.$tr_id.'_name"' : '';
		$output = $name ? '<tr '.$tr_id_str.'><td colspan="2" class="td27" s="1">'.$name.':&nbsp;&nbsp;&nbsp;'.$sec_name.'</td></tr>' : '';
		$tr_id = $tr_id ? 'id="'.$tr_id.'"' : '';
		$output .= '<tr '.$tr_id.' class="noborder" '.$style.'><td '.($td == 2 ? 'colspan="2"' : '').' class="vtop rowform">'.$html.'</td>'.($td == 2 ? '' : '<td class="vtop tips2" s="1">'.$desc.'</td>').'</tr>';
		return $output;
	}

	static public function show_title($title){
		return '<tr><th colspan="15" class="partition">'.$title.'</th></tr>';
	}
	static public function input($args, $info = array()){
		extract($args);
		$info[$name] = $info[$name] ? $info[$name] : $int_val;
		$set_name = $set_name == 1 || $type == 'file' ? $name : 'set['.$name.']';
		$type = $type ? $type : 'text';
		$class_name = $length ? 'longtxt' : 'txt'; 
		return '<input id="'.$name.'" type="'.$type.'" '.$js.' class="'.$class_name.' length_'.$length.'" name="'.$set_name.'" value="'.$info[$name].'">';
	}
	
	
	static public function textarea($args, $info = array()){
		extract($args);
		$length = $length ? $length : 6;
		$height = $height ? $height : 81;
		$info[$name] = $info[$name] ? $info[$name] : $int_val;
		$set_name = $set_name == 1 ? $name : 'set['.$name.']';
		$name_id = self::id_format($name);
		return '<textarea rows="6" ondblclick="textareasize(this, 1)" cols="50"  \'..\'="" onkeyup="textareasize(this, 0)" cols="'.$cols.'" id="'.$name_id.'" '.$js.' class="tarea length_'.$length.' '.$class.'" style="height:'.$height.'px;" name="'.$set_name.'">'.$info[$name].'</textarea>';
		
	}

	public static function ifcheck($var) {
		return $var ? ' checked' : '';
	}
	
	//array('name' => 'avatar_setting_member', 'int_val' => 1, 'js' => array('show_user_set(1)', 'show_user_set(2)'), 'lang_arr' => array('no_avatar_member', 'user_set'))
	static public function radio($args, $info = array()){
		extract($args);
		$str = '<ul onmouseover="altStyle(this);">';
		$lang = $lang ? $lang : array('yes', 'no');
		if($int_val && !$info[$name]) $info[$name] = $int_val;
		$info[$name] = $info[$name] ? $info[$name] : 1;
		$lang = $lang_arr ? $lang_arr : ($lang_type == 1 || !$lang_type ? array(milu_lang('_open'), milu_lang('_close')) : array(milu_lang('yes'), milu_lang('no')));
		$arr = $js_arr = array();
		if(count($lang) == 2 && $lang_type !=3) {
			$arr[1] = $lang[0];
			$arr[2] = $lang[1];
			$js_arr[1] = $js[0];
			$js_arr[2] = $js[1];
		}else{
			$arr = $lang;
			$js_arr = $js;
		}
		$value_name = $set_name == 1 ? $name : 'set['.$name.']';
		$name_id = self::id_format($name);
		foreach($arr as $i => $v){
			$li_checked = 'class="'.self::ifcheck($info[$name] == $i).'"';
			$radio_checked = self::ifcheck($info[$name] == $i);
			$js_show = $js_arr[($i)] ? 'onclick="'.$js_arr[($i)].'"' : '';
			
			$str .= '<li  '.$li_checked.'><label><input '.$js_show.' '.$radio_checked.' name="'.$value_name.'" type="radio" class="radio '.$class_name.' '.$name_id.'" id="'.$name_id.'_'.$i.'"  value="'.$i.'"><span>'.$v.'</span></label></li>';
		}
		
		$str .= '</ul>';
		return $str;
	}
	
	static public function select($args, $info = array()){
		extract($args);
		$flag = $flag ? $flag : 0;
		$multiple = $multiple ? 'multiple="multiple" size="10"' : '';
		$show_name = $multiple ? $name.'[]' : $name;
		$show_name = $set_name == 1 ? 'set['.$name.']' : $show_name;
		$select = '<select '.$js.' name="'.$show_name.'" '.$multiple.' class="'.$class.'" id="'.$id.'">';
		$key_arr = array_keys($option_arr);
		$int_val = isset($info[$name]) ? $info[$name] : $int_val;
		$int_val = isset($int_val) ? $int_val : $key_arr[0];
		$int_val_arr = is_array($int_val) ? $int_val : array($int_val);
		foreach($option_arr as $k => $v){
			$select_value = $flag == 0 ? $v : $k;
			$select_value = (string)$select_value;
			$selected = in_array($select_value, $int_val_arr) ? 'selected="selected"' : '';
			$select .= '<option '.$selected.' value="'.strip_tags($select_value).'">'.$v.'</option>';
		}
		$select .= '</select>';
		return $select;
	}
	
	static public function checkbox($args, $info = array()){
		extract($args);
		$html = '';
		$int_val = isset($info[$name]) ? $info[$name] : $int_val;
		$int_val_arr = is_array($int_val) ? $int_val : array($int_val);
		foreach($option_arr as $k => $v){
			$checked = in_array($k, $int_val_arr) ? 'checked="checked"' : '';
			$html .= '<input '.$checked.' id="'.$name.$k.'" name="'.$name.'[]" type="checkbox" value="'.$k.'" /><label for="'.$name.$k.'">'.$v.'</label>';
		}
		return $html;
	}
	
	
	
	static public function dateline($args, $info){
		global $_G;
		extract($args);
		$date_str = $date_type == 2 ? 'Y-m-d' : 'Y-m-d H:i';
		$length = $length ? $length : 2;
		$name_start = $name_arr[0] ? $name_arr[0] : $name.'_start';
		$name_end = $name_arr[1] ? $name_arr[1] : $name.'_end';
		$min_dateline = $_G['timestamp'] - 20*360*24*3600;//时间戳小于这个数，就不转换
		$start_time = ($info[$name_start] && is_int($info[$name_start]) && $info[$name_start] > $min_dateline) ? date($date_str, $info[$name_start]) : $info[$name_start];
		$end_time = ($info[$name_end] && is_int($info[$name_end]) && $info[$name_end] > $min_dateline) ? date($date_str, $info[$name_end]) : $info[$name_end];
		return '<script src="static/js/calendar.js?3R4" type="text/javascript" type="text/javascript"></script><input name="set['.$name_start.']" type="text" onclick="showcalendar(event, this, false)" value="'.$start_time.'" class="px length_'.$length.' '.$date_type.' mr20"><span class="mr20">'.milu_lang('_to').'</span><input name="set['.$name_end.']" type="text" value="'.$end_time.'" onclick="showcalendar(event, this, false)" class="px length_'.$length.' '.$date_type.' mr20">';	
	}
	
	static public function show_qq($qq, $style = 0){
		if(!$qq) return;
		return $style == 1 ? '<a target="_blank" style="float:left; width:23px; display:block; text-align:right" href="http://wpa.qq.com/msgrd?v=3&amp;uin='.$qq.'&amp;site=qq&amp;menu=yes"><img style="float:rigth; cursor:pointer" border="0" src="http://wpa.qq.com/pa?p=1:'.$qq.':4&i='.time().'" alt="'.milu_lang('hits_send_msg').'" title="'.milu_lang('hits_send_msg').'"></a>' : '<a target="_blank"  href="http://wpa.qq.com/msgrd?v=3&amp;uin='.$qq.'&amp;site=qq&amp;menu=yes"><img style=cursor:pointer" border="0" src="http://wpa.qq.com/pa?p=1:'.$qq.':4&i='.time().'" alt="'.milu_lang('hits_send_msg').'" title="'.milu_lang('hits_send_msg').'"></a>';
	}
	


	static function select_output($option_arr, $ini_val, $select_name, $now_value = '', $flag = 0){
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

	static function img_list_output($data_arr, $w = 650){
		if(!$data_arr) return;
		$output = '<ul class="img_list">';
		$w = $h = (($w-50)-18*6)/3;
		foreach((array)$data_arr as $k => $v){
			$output .= '<li style="width:'.$w.'; height:'.$h.';"><img src="'.$v.'" width="'.$w.'" height="'.$h.'"></li>';
		}
		$output .= '</ul>';
		return $output;
	}
	
	static function user_group_select($name, $ini_val = array(), $no_show_system = 0){
		global $_G,$lang;
		$name = $name ? $name : 'groupid';
		$groupselect = array();
		$usergroupid = $ini_val;
		$g_sql = '';
		if($no_show_system == 1) $g_sql = "type!='system' AND";
		$query = DB::query("SELECT type, groupid, grouptitle, radminid FROM ".DB::table('common_usergroup')." WHERE $g_sql groupid NOT IN ('6', '7') ORDER BY (creditshigher<>'0' || creditslower<>'0'), creditslower, groupid");
		while($group = DB::fetch($query)) {
			$group['type'] = $group['type'] == 'special' && $group['radminid'] ? 'specialadmin' : $group['type'];
			$groupselect[$group['type']] .= "<option value=\"$group[groupid]\" ".(in_array($group['groupid'], $usergroupid) ? 'selected' : '').">$group[grouptitle]</option>\n";
		}
		$groupselect = '<optgroup label="'.$lang['usergroups_member'].'">'.$groupselect['member'].'</optgroup>'.
			($groupselect['special'] ? '<optgroup label="'.$lang['usergroups_special'].'">'.$groupselect['special'].'</optgroup>' : '').
			($groupselect['specialadmin'] ? '<optgroup label="'.$lang['usergroups_specialadmin'].'">'.$groupselect['specialadmin'].'</optgroup>' : '').
			($no_show_system == 0 ? '<optgroup label="'.$lang['usergroups_system'].'">'.$groupselect['system'].'</optgroup>' : '');
		return '<select name="'.$name.'[]" multiple="multiple" size="10"><option value="">'.milu_lang('empty').'</option>'.$groupselect.'</select>';
	}
	
	
	//显示采集器底部的js
	static function bottom_js_output($info){
		if ($info['rules_type'] == 1){//采集器采用系统规则时，隐藏一些东西
			if ($info['rules_hash']) $show_bottom_js = "rules_show_page_set(1);hide_get_page('".$info['rules_hash']."');";
		}else if ($info['rules_type'] == 3 || !$info['rules_type']){
			$show_bottom_js = 'rules_show_page_set(3);';
		}else if($info['rules_type'] == 2){
			$show_bottom_js = 'rules_show_page_set(2);';
		}
		return $show_bottom_js;
	}
	
	
	static function pick_loading($ajax_url, $finsh_url, $total, $args = array()){
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
	
	static function pcpmsg_loading($message, $url = '', $type = '', $values = array(), $extra = '', $halt = TRUE) {
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
	
	
	static function show_test_text($name, $msg){
		global $_G;
		return '<p style="margin-bottom:5px;"><span style=" float:left;width:70px;">'.$name.':</span><textarea ondblclick="milu_view(\''.$_G['formhash'].rand(1,500).'\',this, \''.$name.'\')" class="tarea w_area"  cols="50" name="test" rows="6">'.$msg.'</textarea></p>';
	}
	
	
	static function test_replace_rules($str, $rules){
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
	
	static function windos_show_link($link_arr,$url = '', $args = array(), $filter_args = array()){
		extract($args);
		if(!$count) $count = count($link_arr);
		$link_html = '';
		if($link_arr){
			$link_html .= '<ul class="show_debug">';
			$i = 1;
			foreach($link_arr  as $k=>$v){
				if($v == '0'){
					$link_html .= '<li>'.milu_lang('el').'</li>';
				}else{
					if($url) $v = _expandlinks($v, $url);
					$show_i = $i;
					if((string)$k == 'x') $show_i = 'x';
					$href = $show_v = $v;
					if(filter_page_link($v, $filter_args)){ 
						$show_v = replace_something($v, $filter_args['page_url_replace'], $test = 1);
						$href = str_replace(array('<ins>', '</ins>', '<del>', '</del>'), '', $show_v);
						$link_html .= '<li>'.$show_i.'. <a  target="_blank"  href="'.$href.'">'.cutstr($show_v, 65).'</a></li>';
					}else{
						$link_html .= '<li><del>'.$show_i.'. <a  target="_blank"  href="'.$href.'">'.cutstr($show_v, 65).'</a></del></li>';
					}
				}	
				$i++;
				$show_i = $i;
			}
			$link_html .= '</ul>';
		}else{	
			$link_html = milu_lang('get_link_no_data').'!';
		}
		return $link_html;
	}
	
	static function create_rules_html($name = '', $rule_arr = array(), $show = FALSE){
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
	
	

	
	static function show_filter_html($filter_html_arr  = array(), $input_name = 'content_filter_html'){
		global $_G;
		$filter_html = $_G['cache']['evn_milu_pick']['filter_html'];
		$html = '<ul class="filter_html">';
		$big5 = $_G['config']['output']['language'] == 'zh_tw' && $_G['config']['output']['charset'] == 'big5' ? TRUE : FALSE;
		foreach($filter_html as $k => $v){
			if($v['no_show'] == 1) continue;
			$name = dhtmlspecialchars($v['name']);
			$checked = in_array($k, $filter_html_arr) ? 'checked="checked"' : '';
			$html .=  '<li><label><input '.$checked.' type="checkbox" class="'.$input_name.'" value="'.$k.'"  name="'.$input_name.'[]">'.$name.'</label></li>';
		}
		$html .= '</ul>';
		return $html;
	}
	
	static function show_var_html($key,$args, $now_v){
		global $_G;
		$long_text = $_G['cache']['evn_milu_pick']['long_text'];
		$type = $args['var_type'][$key];
		$title = $args['var_title'][$key];
		$desc = $args['var_desc'][$key];
		$ext_select = $args['var_ext_select'][$key];
		$ext_keyword = $args['var_ext_step'][$key];
		if(!filter_something($title, $long_text)) {
			$text_class = 'longtxt';
		}else{
			$text_class = 'txt';
		}
		$tr_start = '<tr><td colspan="2" class="td27" s="1"><span class="vtop rowform">'.$title.':</span></td></tr><tr  class="noborder"><td class="vtop rowform">';
		if($type == 'text'){
			$body = '<input type="text" value="'.$now_v.'" id="rules_var_'.$key.'" class="'.$text_class.'" name="rules_var['.$key.']">';
			if($ext_keyword) $body .= self::show_keyword_html($key);
		}else if($type == 'textarea'){
			$body = '<textarea  class="tarea" cols="50" id="rules_var_'.$key.'" name="rules_var['.$key.']" onkeyup="textareasize(this, 0)" ondblclick="textareasize(this, 1)" rows="6">'.$now_v.'</textarea>';
			if($ext_keyword) $body .= self::show_keyword_html($key);
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
	
	static function show_keyword_html($key, $type = 1){
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
	
	//显示分页
	static function show_page_output($content_arr){
		if(!$content_arr) return FALSE;
		$body .= '<p class="reply_count"><em>'.milu_lang('page_count', array('c' => count($content_arr))).'</em></p><br>';
		$body .= '<ul class="show_reply">';
		$i = 0;
		foreach((array)$content_arr as $k => $v){
			$i ++;
			$body .= '<li><h1>'.milu_lang('the_page', array('i' => $i)).'</h1><br>'.$v['content'].'</li>';
		}
		$body .= '</ul>';
		return $body;
	}

	
	static function pick_search_select($select_name, $select_pid, $no_show_id = 0, $multiple = false){
		$cat_arr = pick_category_list();
		$first_str = '<option value="">'.milu_lang('now_select_picker').'</option>';
		if($multiple){
			$multiple_str = 'multiple="multiple" size="10"';
			$first_selected = array_search(0, $select_pid) !== FALSE ? 'selected="selected"' : '';
			$first_str = '<option value="0" '.$first_selected.'>'.milu_lang('empty').'</option>';;
		}
		$html = '<select name="'.$select_name.'" '.$multiple_str.'>'.$first_str;
		foreach($cat_arr as $k_c => $v_c){
			$html .= '<optgroup label="'.$v_c[name].'">';
			$query = DB::query("SELECT name,pid FROM ".DB::table('strayer_picker')." WHERE pick_cid='$v_c[cid]' ORDER BY displayorder ASC,dateline DESC");
			while($rs = DB::fetch($query)) {
				if($rs['pid'] != $no_show_id || !$no_show_id){
					$selected = (!is_array($select_pid) && $rs['pid'] == $select_pid) || (is_array($select_pid) && in_array($rs['pid'], $select_pid)) ? 'selected="selected"' : ''; 
					$html .= '<option '.$selected.' value="'.$rs['pid'].'">'.$rs['name'].'</option>';
				}
			}
			$html .= '</optgroup>';
		}
		$html .= '</select>';
		return $html;
	}
	
	static function show_tips($msg, $args = array()){
		extract($args);
		$title = $title ? $title : milu_lang('msg_notice');
		$w = $w ? $w : 600;
		$h = $h ? $h : 387;
		$html = '<script type="text/javascript" language="javascript">
	show_html_window(\''.$key.'\', \'<em>'.$title.'</em>\', '.$w.', '.$h.', \'<div class="c bart" style=" width:100%; height:'.($h - 60).'px;">'.$msg.'</div><p class="o pns"><button onclick="pick_tips(\\\''.$key.'\\\');hideWindow(\\\''.$key.'\\\');" class="pn pnc" name="dsf" type="submit"><span>'.milu_lang('never_notice').'</span></button></p>\');</script>';
		return $html;
	}
	
	static function show_threadtypes_html($pre, $info = array()){
		global $_G;
		loadcache(array('threadsort_option_'.$info[$pre.'_threadtype_id']));
		$sortoptionarray = $_G['cache']['threadsort_option_'.$info[$pre.'_threadtype_id']];
		$show = '';
		
		$info['forum_threadtypes'] = (array)$info['forum_threadtypes'];

		/*新旧数据转换*/
		if($info['forum_threadtypes']['threadsort']['sortid'] != $info[$pre.'_threadtype_id']){
			pload('F:pick');
			$info['forum_threadtypes'] = forum_thread_data_format($info['forum_threadtypes'], $info[$pre.'_threadtype_id']);
		}
		foreach((array)$sortoptionarray as $k => $v){
			$v['sortid'] = $k;
			$show .= self::rules_get_show($v, $info, $pre);
		}
		return $show;
	}
	
	static function id_format($id){
		return str_replace(array('[', ']'), array('_', '_'), $id);
	}
	
	static function rules_get_show($info, $p_arr, $pre = 'forum'){
		$name = $info['sortid'];
		$p_arr[$pre.'_threadtypes'] = (array)$p_arr[$pre.'_threadtypes'];
		$radio_name = $pre.'_threadtypes[get_type]['.$name.']';
		$textarea_name = $pre.'_threadtypes[get_rules]['.$name.']';	
		$p_arr[$radio_name] = $p_arr[$pre.'_threadtypes']['get_type'][$name];
		
		$p_arr[$textarea_name] = $p_arr[$pre.'_threadtypes']['get_rules'][$name];					
		$show .= self::show_tr(
					array(
						'name' => $info['title'].'&nbsp;'.milu_lang('get_rules'),
						'sec_name' => self::insert_cursor(self::id_format($textarea_name), '[data]', milu_lang('insert_data')),
						'desc' => '',
						'arr' => array(
							'name' => $radio_name,
							'info' => $p_arr,
							'int_val' => 1,
							'set_name' => 1,
							'lang_type' => 3,
							'lang_arr' => array(1 => milu_lang('dom_get'), 2 => milu_lang('str_get')),
						),
					)
					,'radio');
		$p_arr[$textarea_name] = $p_arr[$pre.'_threadtypes']['get_rules'][$name];			
		$show .= self::show_tr(
					array(
						'name' => '',
						'desc' => '',
						'arr' => array(
							'name' => $textarea_name,
							'set_name' => 1,
							'int_val' => '',
							'info' => $p_arr,
							'class' => 'w_area',
						),
					)
					,'textarea');
		$show .= self::add_tr(array(), '<a onclick="rules_get_threadtypes(\''.$name.'\');" href="javascript:void(0);">'.milu_lang('hit_view_result').'</a>');					
		return $show;			
	}
	
	static function rules_get_output($args, $info = array()){
		extract($args);
		$radio_name = 'set['.$name.'_get_type]';
		$textarea_name = 'set['.$name.'_get_rules]';
		$info[$radio_name] = $info[$name.'_get_type'];
		$info[$textarea_name] = $info[$name.'_get_rules'];
		$radio_arr = array(1 => milu_lang('dom_get'), 2 => milu_lang('str_get'));
		if($textarea_desc){
			$desc_info = explode('@@@', $textarea_desc);
			$dom_is_show = $info[$radio_name] != 2 ? '' : 'style="display:none"'; 
			$str_is_show = $info[$radio_name] == 2 ? '' : 'style="display:none"'; 
			$dom_id_name = $name.'_dom';
			$str_id_name = $name.'_str';
			if(!$js){
				$js = array(1 => 'show_hide(\''.$dom_id_name.'\',\''.$str_id_name.'\',1)', 2 => 'show_hide(\''.$dom_id_name.'\',\''.$str_id_name.'\', 2)');
			}
			$textarea_desc = '<p '.$dom_is_show.' id="'.$dom_id_name.'">'.$desc_info[0].'</p><p '.$str_is_show.' id="'.$str_id_name.'">'.$desc_info[1].'</p>';
		}
		
		if($radio_name == 'set[best_answer_get_type]') {
			$radio_value_name = $name.'_get_type';
			$radio_arr[3] = milu_lang('best_answer_get_from_reply');
			$display = $$radio_value_name != 1 ? 'style="display:none"' : '';
			$textarea_desc = '<p '.$display.' id="best_answer_desc3">'.milu_lang('best_answer_desc3').'</p>';
		}else if($radio_name == 'set[ask_reward_price_get_type]') {
			$radio_value_name = $name.'_get_type';
			$radio_arr[3] = milu_lang('user_set');
			$display = $$radio_value_name != 1 ? 'style="display:none"' : '';
			$display1 = $$radio_value_name == 1 ? 'style="display:none"' : '';
			$textarea_desc = '<p '.$display1.' id="ask_reward_price_desc1">'.milu_lang('ask_reward_price_desc1').'</p><p '.$display.' id="ask_reward_price_desc3">'.milu_lang('ask_reward_price_desc3').'</p>';
		}
 		$show .= self::show_tr(
					array(
						'name' => $title,
						'sec_name' => self::insert_cursor(self::id_format($textarea_name), '[data]', milu_lang('insert_data')),
						'desc' => '',
						'arr' => array(
							'js' => $js,
							'name' => $radio_name,
							'info' => $info,
							'int_val' => 1,
							'set_name' => 1,
							'lang_type' => 3,
							'lang_arr' => $radio_arr,
						),
					)
					,'radio');
		$show .= self::show_tr(
					array(
						'name' => '',
						'desc' => $textarea_desc ? $textarea_desc : '',
						'arr' => array(
							'name' => $textarea_name,
							'set_name' => 1,
							'int_val' => '',
							'info' => $info,
							'class' => 'w_area',
						),
					)
					,'textarea');
					
		$show .= $no_test==1 ? '' : self::add_tr(array(), '<a onclick="'.$test_func.'(\''.$name.'\');" href="javascript:void(0);">'.milu_lang('hit_view_result').'</a>');
		
		return $show;
	}
	
	static function insert_cursor($to, $value, $title){
		return '<a href="javascript:void(0)" onclick="insertAtCursor(\''.$to.'\',\''.$value.'\')">'.$title.$value.'</a>';
	}
	
	public static function is_selected($var) {
		return $var ? ' selected' : '';
	}
	
	static public function show_cron_setting($info, $pre = 'pick'){
		$show = $weekdayselect = $dayselect = $hourselect = '';
		list($info['day'], $info['hour'], $info['minute']) = explode('-', $info[$pre.'_cron_loop_daytime']);
		$info['minute'] = str_replace("\t", ',', $info['minute']);
		$type_arr = array('month'=> milu_lang('_month'), 'week'=> milu_lang('_week'), 'day'=> milu_lang('_day'), 'hour'=> milu_lang('_hour'), 'now'=> milu_lang('_per'));
		$day_arr = array(milu_lang('day'), milu_lang('_one'), milu_lang('_two'), milu_lang('_three'), milu_lang('_four'), milu_lang('_five'), milu_lang('_six'));
		$now_time_arr = array('minute' => milu_lang('_mintu'), 'hour' => milu_lang('_hour_'), 'day' => milu_lang('_tian'));
		if ($info['day']) $time =  $info['day'];
		if ($info['hour']) $time =  $info['hour'];
		if ($info['minute']) $time =  $info['minute'];
		$info['loop_type'] = $info[$pre.'_cron_loop_type'] ? $info[$pre.'_cron_loop_type'] : 'month';
		foreach($type_arr as $k => $v) {
			$typeselect .= "<option value=\"$k\" ".($info['loop_type'] == $k ? 'selected' : '').">".$v."</option>";
		}
		
		foreach($day_arr as $k => $v) {
			$weekdayselect .= "<option value=\"$k\" ".($info['day'] == $k ? 'selected' : '').">".milu_lang('_week_')." ".$v."</option>";
		}
	
		for($i = 1; $i <= 31; $i++) {
			$dayselect .= "<option value=\"$i\" ".($info['day'] == $i ? 'selected' : '').">$i ".milu_lang('day')."</option>";
			
		}
		$dayselect .= '<option value="99" '.self::is_selected(99 == $info['day']).'>'.milu_lang('last_day').'</option>';
	
		for($i = 0; $i <= 23; $i++) {
			$hourselect .= "<option value=\"$i\" ".($info['hour'] == $i ? 'selected' : '').">$i ".milu_lang('point')."</option>";
		}
		$j = 0;
		for($i = 0; $i <= 5; $i++) {
			$j = $i * 10;
			$minuteselect .= "<option value=\"$j\" ".($info['minute'] == $j ? 'selected' : '').">$j ".milu_lang('_minute_')."</option>";
		}
		foreach($now_time_arr as $k => $v) {
			$now_timeselect .= "<option value=\"$k\" ".($info[$k] ? 'selected' : '').">".$v."</option>";
		}
		
		$show .= "<select id=\"J_time_".$pre."_select\" class=\"select_3 mr10\" name=\"".$pre."_looptype\">$typeselect</select>";
		
		$style = $info['loop_type'] != 'month' && $info['loop_type'] ? 'style="display:none;"' : '';
		$show .= "<span class=\"J_time_".$pre."_item\" id=\"J_time_".$pre."_month\"  $style><select class=\"select_3 mr10\" name=\"".$pre."_month_day\">$dayselect</select>";
		$show .= "<select  class=\"select_3 mr10\" name=\"".$pre."_month_hour\">$hourselect</select></span>";
		
		
		$style = $info['loop_type'] != 'week' ? 'style="display:none;"' : '';
		$show .= "<span class=\"J_time_".$pre."_item\" id=\"J_time_".$pre."_week\" $style><select class=\"select_3 mr10\" name=\"".$pre."_week_day\">$weekdayselect</select>";		
		$show .= "<select  class=\"select_3 mr10\" name=\"".$pre."_week_hour\">$hourselect</select></span>";
		
		$style = $info['loop_type'] != 'day' ? 'style="display:none;"' : '';
		$show .= "<span class=\"J_time_".$pre."_item\" id=\"J_time_".$pre."_day\" $style><select class=\"select_3 mr10\" name=\"".$pre."_day_hour\">$hourselect</select></span>";		
		$style = $info['loop_type'] != 'hour' ? 'style="display:none;"' : '';
		$show .= "<span class=\"J_time_".$pre."_item\" id=\"J_time_".$pre."_hour\" $style><select class=\"select_3 mr10\" name=\"".$pre."_hour_minute\">$minuteselect</select></span>";	
			
		$style = $info['loop_type'] != 'now' ? 'style="display:none;"' : '';
		$show .= "<span class=\"J_time_".$pre."_item\" id=\"J_time_".$pre."_now\" $style><input type=\"text\" style=\"width:80px;\" class=\"txt length_3\" name=\"".$pre."_now_time\" value=\"$time\"><select class=\"select_3 mr10\" name=\"".$pre."_now_type\">$now_timeselect</select></span>";
		$show .= '<span>'.($pre == 'pick' ? milu_lang('pick') : ($pre == 'auto_update' ? milu_lang('_update') : milu_lang('public'))).'</span><input type="text" style="width:80px;margin-left:10px;" class="txt length_3" name="set['.$pre.'_article_num]" value="'.$info[$pre.'_article_num'].'"> <span>'.milu_lang('article_num__').'</span>';
		$show .= self::add_tr(array('td' => 2), milu_lang($pre.'_article_num_notice'));
		
		$show = self::add_tr(array('name' => milu_lang('run_dateline'), 'td' => 2), $show);
		
		return $show;
	}
	
	public static function other_value_output($data_arr){
		$output = '<table class="tb tb2 "><tbody><tr class="header"><th width="51">'.milu_lang('field_name').'</th><th width="220">'.milu_lang('the_get_info').'</th><th width="80">'.milu_lang('trun_info').'</th></tr>';
		foreach($data_arr as $k => $v){
			$output .= '<tr class="td24"><td class="td25">'.$v['name'].'</td><td class="td24">'.$v['value'].'</td><td>'.($v['format_value'] ? $v['format_value'] : milu_lang('no_turn')).'</td></tr>';
		}
		$output .= '</tr></tbody></table>';
		return $output;
	}
	
	
	static function show_reply_output($reply_data, $args = array()){
		if(!$reply_data) return FALSE;
		$body = '';
		if(!is_array($reply_data[0])){
			$body .= '<br /><h1>'.milu_lang('get_data_count', array('data' => count($reply_data))).milu_lang('reply').':</h1>';
		}else{
			$body .= '<p class="reply_count"><em>'.milu_lang('reply_count', array('c' => count($reply_data))).'</em></p><br>';
		}
		$body .= '<ul class="show_reply">';
		$i = 0;
		$best_answer_output = '';
		foreach((array)$reply_data as $k => $v){
			$i ++;
			$member_info = $args['member_data_arr'] ? $args['member_data_arr'][$v['uid']] : array();
			if(isset($args['best_answer_key']) && $k == $args['best_answer_key']){
				$best_answer_output = '<h1 class="reply_left">'.milu_lang('best_answer_title').$args['reward_price_output'].'</h1>';
			}else{
				$best_answer_output = '';
			}
			if(is_array($v)){
				if($args['member_data_arr']){
					$body .= '<li><span class="reply_left">'.$i.'</span>'.$best_answer_output.'.'.'<div class="reply_user"><span style=" margin-left:0;"><a>'.$member_info['username'].'</a></span>'.milu_lang('_public_by').'<span>'.dgmdate($v['dateline']).'</span></div><span style=" float:left; margin-right:10px;"><img  src="'.$member_info['avatar_url'].'"></span><span>'.$v['content'].'</span></li>';
				}else{
					$body .= '<li><span class="reply_left">'.$i.'</span>'.$best_answer_output.'.'.$v['content'].'</li>';
				}
			}else{
				$body .= '<li><span class="reply_left">'.$i.'</span>'.$best_answer_output.'.'.$v.'</li>';
			}
			
		}
		$body .= '</ul>';
		return $body;
	}

}
?>