<?php
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

function member_set(){
	global $head_url,$header_config;
	if(!submitcheck('addsubmit')) {
		$info = pick_common_get();
		$info['header'] = pick_header_output($header_config, $head_url);
		$info['member_field'] = dunserialize($info['member_field']);
		if(!$info['url']) $info['url'] = 'http://www.discuz.net/';//默认的
		if(!$info['jump_num']) $info['jump_num'] = 45;//默认的
		return $info;
	}else{
		$set = $_GET['set'];
		$set['member_field'] = serialize($_GET['member_field']);
		pick_common_set($set);
		cpmsg(milu_lang('op_success'), PICK_GO."member", 'succeed');	
	}
	
}

function member_get($run = 0){
	if(intval($_GET['clear'])) cache_del('member_get');
	$member_cache = load_cache('member_get');
	$save_data = $member_cache ? $member_cache : '';
	global $head_url,$header_config,$_G;
	$temp_cache_data = '';
	if(!$_GET['submit'] || $run == 0) {
		num_limit('strayer_member', '15000', 'member_num_limit');
		$info['header'] = pick_header_output($header_config, $head_url);
		$info['save_data'] = $save_data;
		return $info;
	}else{
		if(intval($_GET['submit']) == 2 ) unset($save_data);
		if(!$save_data) show_pick_info(milu_lang('start_config'));
		$info = pick_common_get();
		$info['jump_num'] = $info['jump_num'] ? $info['jump_num'] : 45;
		$now_get = $save_data['now_get'] ? $save_data['now_get'] : 0; 
		$info['member_field'] = dunserialize($info['member_field']);
		$limit_num = $info['jump_num'] > $info['num'] ? $info['num'] : $info['jump_num'];
		$uid_arr = get_data_range($info['uid_range'], $now_get, $limit_num); 
		$all_get_time = $save_data['all_get_time'] ? $save_data['all_get_time'] : 0; 
		$success_count = $save_data['success_count'] ? $save_data['success_count'] : 0; 
		$uid_url_arr = get_user_url_arr($info['url'], $uid_arr['list']);
		$all_uid_count = $uid_arr['all_num'];
		$get_count = $temp_cache_data['get_count'] = $save_data['get_count'] ? $save_data['get_count'] : ($info['num'] && ( $info['num'] < $all_uid_count ) ? $info['num'] : $all_uid_count);
		foreach($uid_url_arr as $k => $v){
			d_s();
			show_pick_info(array(milu_lang('pick_url'), $v['url']), 'url', array('li_no_end' => 1, 'no_border' => 1, 'now' => $now_get+1) );
			$info['get_url'] = $v['url'];
			$re = pick_get_user_info($info);
			$now_get++;
			$pro = ceil(100 * ($success_count/$get_count));
			
			$get_time = d_e(0);
			$all_get_time += $get_time;
			$avg_get_time = $all_get_time/$success_count;
			$wait_count = $get_count - $success_count;
			$wait_time = $avg_get_time * $wait_count;
			$wait_time = ($success_count == 0 && $wait_time == 0) ? milu_lang('un_know') : $wait_time;
			$pro = ($success_count == 0 && $pro == 0) ? '0%' : $pro;
			if(function_exists('php_set')){			
				$memory = (100 * (get_memory()/php_set('memory_limit'))); 
				$memory = ($memory || $memory != 0) ? sprintf('%.0f%%',$memory) : milu_lang('un_know');
			} 
			$show_arr = array('pro' => $pro, 'wait_time' => $wait_time, 'memory' => $memory, 'wait_count' => $wait_count, 'now' => $now_get+1);
			$temp_cache_data['now_get'] = $now_get;
			$temp_cache_data['all_get_time'] = $all_get_time;
			if(is_array($re)){
				$check = DB::result(DB::query("SELECT COUNT(*) FROM ".DB::table('strayer_member')." WHERE get_uid ='$v[uid]' AND get_web_url='$info[url]'"), 0);				
				if($check) {
					show_pick_info($re['username'].' '.milu_lang('data_have'), 'err', $show_arr);
				}else{	
					$success_count++;
					$temp_cache_data['success_count'] = $show_arr['success_count'] = $success_count;
					$show_arr['wait_count'] = $get_count - $success_count;
					$wait_time = $avg_get_time * $wait_count;
					$show_arr['wait_time'] = $wait_time;
					$setarr = format_member_data($re);
					$setarr['get_dateline'] = $_G['timestamp'];
					$setarr['get_uid'] = $v['uid'];
					$setarr['get_web_url'] = $info['url'];
					$setarr = paddslashes($setarr);
					DB::insert("strayer_member", $setarr, true);
					show_pick_info($re['username'].' '.milu_lang('info_add'), 'success', $show_arr);
				}
				
			}else{
				if($re == -1) show_pick_info(milu_lang('no_get_content'), 'err', $show_arr);
				if($re == -2) show_pick_info(milu_lang('no_any_info'), 'err', $show_arr);
				if($re == -3) show_pick_info(milu_lang('no_must_info'), 'err', $show_arr);
				if($re == -4) show_pick_info(milu_lang('no_user_space'), 'err', $show_arr);
				if($re == -5) show_pick_info(milu_lang('username_no_chinese'), 'err', $show_arr);//
				if($re == -6) show_pick_info(milu_lang('AccessDenied'), 'err', $show_arr);//
			}
			if($success_count == $get_count || $success_count > $get_count) {
				break;
			}	 
			if(is_int($now_get / $info['jump_num']) && $now_get != 0  && $success_count < $get_count){
				cache_data('member_get', $temp_cache_data, 3600);
				data_go('member&myac=member_get&submit=1');
				exit();
			}
		}
		if($success_count < $get_count && $info['reg_num']) {
			if($info['jump_num'] > $get_count){
				cache_data('member_get', $temp_cache_data, 3600);
				data_go('member&myac=member_get&submit=1');
				exit();
			}
			show_pick_info(milu_lang('no_member_reg'), 'finsh');
		}	
		$all_get_time_str = diff_time($all_get_time, 1);
		$all_get_time_str = $all_get_time_str ? $all_get_time_str : sprintf('%.2f',$all_get_time).'秒';
		$finsh_output = milu_lang('pick_user_finsh', array('n' => $now_get, 's' => $success_count, 'n_s' => $now_get-$success_count, 'all' => $all_get_time_str, 'avg' => sprintf('%.2f',$avg_get_time) ));
		cache_del('member_get');
		$show_arr['wait_count'] = $show_arr['wait_time'] = 0;
		$show_arr['pro'] = 100;
		$show_arr['memory'] = $memory;
		show_pick_info($finsh_output, 'finsh', $show_arr);
	}
	
}

function credits_list(){
	global $_G;
	if(empty($_G['setting']['extcredits'])) return;
	foreach($_G['setting']['extcredits'] as $key => $value) {
		$arr[] = array('name' => 'extcredits'.$key, 'title' => $value['title']);
	}
	return $arr;
}

function member_list(){
	global $head_url,$header_config;
	$type = $info['type'] = $args['type'] = $_GET['type'];
	$s = $info['s'] = $args['s'] = $_GET['s'];
	$search_type = $info['search_type'] = $args['search_type'] = $_GET['search_type'];
	$perpage = $info['perpage'] = $args['perpage'] = $_GET['perpage'];//每页显示
	if(!submitcheck('submit')) {
		$list_arr = member_data_list($args);
		$info['list'] = $list_arr['list'];
		$info['count'] = $list_arr['count'];
		$info['multipage'] = $list_arr['multipage'];
		$info['header'] = pick_header_output($header_config, $head_url);
		$info['credits_list'] = credits_list();
		return $info;
	}else{
		$submit_type = $_GET['submit_type'];
		if($submit_type != 'search'){
			$uid_arr = $_GET['uidarray'];
			if(!$uid_arr) cpmsg_error(milu_lang('no_c_data'));
			member_data_del($uid_arr);
			cpmsg(milu_lang('op_success'), PICK_GO."member&myac=member_list", 'succeed');	
		}else{
			$list_arr = member_data_list($args);
			$info['list'] = $list_arr['list'];
			$info['count'] = $list_arr['count'];
			$info['multipage'] = $list_arr['multipage'];
			$info['header'] = pick_header_output($header_config, $head_url);
			$info['credits_list'] = credits_list();
			return $info;
		}
	}
}

function member_del(){
	$uid = intval($_GET['uid']);
	if(!$_GET['submit']){
		cpmsg(milu_lang('del_user_confirm'), PICK_GO.'member&myac=member_del&uid='.$uid.'&submit=1', 'form');
	}else{
		member_data_del($uid);
		cpmsg(milu_lang('op_success'), PICK_GO."member&myac=member_list", 'succeed');	
	}
}


function member_export(){
	global $_G;
	$field_name = '';
	$filename = date('Ymd', TIMESTAMP).'.csv';
	$info_arr  = get_member_field(array(), 2);
	$query = DB::query("SELECT * FROM ".DB::table('strayer_member')."  ORDER BY get_dateline ASC LIMIT 0,10000 ");
	$v_new = array();	
	while(($v = DB::fetch($query))) {
		$key_arr = array_keys($v);
		foreach($key_arr as $k2 => $v2){
			$name = $info_arr[$v2];
			if(!$name) continue;
			if($v2 == 'regdate' || $v2 == 'lastvisit' || $v2 == 'lastactivity' || $v2 == 'lastpost') $v[$v2] = $v[$v2] ? dgmdate($v[$v2]) : 0;//处理时间
			$v_new[$name] = $v[$v2];
		}
		$data[] = $v_new;
	}


	$key_arr = array_keys($data[0]);
	$field_name .= implode(',', $key_arr); 
	foreach($data as $k => $v){
		$value_arr = array_values($v);
		$field_value .= implode(',', $value_arr)."\n";
	}
	$detail = $field_name."\n".$field_value;
	ob_end_clean();
	header('Content-Encoding: none');
	header('Content-Type: application/octet-stream');
	header('Content-Disposition: attachment; filename='.$filename);
	header('Pragma: no-cache');
	header('Expires: 0');
	if($_G['charset'] != 'gbk') {
		$detail = diconv($detail, $_G['charset'], 'GBK');
	}
	echo $detail;
	define(FOOTERDISABLED, false);
	exit();
}

function member_edit(){
	global $head_url,$header_config;
	if(!submitcheck('editsubmit')) {
		$uid = intval($_GET['uid']);
		$info = member_info($uid);
		$info = pstripslashes($info);
		$info = dhtmlspecialchars($info);
		$yearselect = $monthselect = $dayselect = "<option value=\"\">".cplang('nolimit')."</option>\n";
		$yy=dgmdate(TIMESTAMP, 'Y');
		for($y=$yy; $y>=$yy-100; $y--) {
			$y = sprintf("%04d", $y);
			$yearselect .= "<option value=\"$y\" ".($info['birthyear'] == $y ? 'selected' : '').">$y</option>\n";
		}
		$info['yearselect'] = $yearselect;
		for($m=1; $m<=12; $m++) {
			$m = sprintf("%02d", $m);
			$monthselect .= "<option value=\"$m\" ".($info['birthmonth'] == $m ? 'selected' : '').">$m</option>\n";
		}
		$info['monthselect'] = $monthselect;
		for($d=1; $d<=31; $d++) {
			$d = sprintf("%02d", $d);
			$dayselect .= "<option value=\"$d\" ".($info['birthday'] == $d ? 'selected' : '').">$d</option>\n";
		}
		$info['dayselect'] = $dayselect;
		$info['bloodtype_select'] = select_output(array('A', 'B', 'AB', milu_lang('other')), milu_lang('other'), 'set[bloodtype]', $info['bloodtype']);
		$info['education_select'] = select_output(array(milu_lang('boshi'), milu_lang('shuoshi'), milu_lang('benke'), milu_lang('zuanke'), milu_lang('zhongxue'), milu_lang('xiaoxue'), milu_lang('other')), milu_lang('other'), 'set[education]', $info['education']);
		$info['regdate'] = $info['regdate'] ? dgmdate($info['regdate'], 'Y-m-d H:i') : '';
		$info['lastvisit'] = $info['lastactivity'] ? dgmdate($info['lastvisit'], 'Y-m-d H:i') : '';
		$info['lastactivity'] = $info['lastactivity'] ? dgmdate($info['lastactivity'], 'Y-m-d H:i') : '';
		$info['lastpost'] = $info['lastpost'] ? dgmdate($info['lastpost'], 'Y-m-d H:i') : '';
		$info['header'] = pick_header_output($header_config, $head_url, array('current' => 'member_list'));
		return $info;
	}else{
		$uid = intval($_GET['uid']);
		if(!$uid) cpmsg_error(milu_lang('err'));
		$setarr = paddslashes($_GET['set']);
		DB::update('strayer_member', $setarr, array('uid' => $uid));
		cpmsg(milu_lang('op_success'), PICK_GO."member&myac=member_edit&uid=".$uid, 'succeed');	
	}
}

//发布设置
function member_public_set(){
	global $head_url,$header_config;
	if(!$_GET['submit']) {
		$info = pick_common_get();
		$info['header'] = pick_header_output($header_config, $head_url);
		$info['credits_list'] = credits_list();
		$info['regdate_start_time'] = $info['regdate_start_time'] ? dgmdate($info['regdate_start_time'], 'Y-m-d H:i') : '';
		$info['regdate_end_time'] = $info['regdate_end_time'] ? dgmdate($info['regdate_end_time'], 'Y-m-d H:i') : '';
		$info['user_group_select'] = user_group_select('set[public_groupid]', unserialize($info['public_groupid']));
		return $info;
	}else{
		$set = $_GET['set'];
		if(!$set['reg_pwd']) cpmsg_error(milu_lang('no_pwd'));
		$update = intval($_GET['update']);
		$set['member_field'] = serialize($_GET['member_field']);
		$set['public_groupid'] = serialize($set['public_groupid']);
		$set['regdate_start_time'] = strtotime($set['regdate_start_time']);
		$set['regdate_end_time'] = strtotime($set['regdate_end_time']);
		pick_common_set($set);
		if($set['set_type'] == 2) data_go('member&myac=member_public_info&tpl=no');
		cpmsg(milu_lang('save_success'), PICK_GO."member&myac=member_public_set", 'succeed');
	}
}

function member_public_info(){
	if($_GET['finished']) {
		cpmsg(milu_lang('run_finsh'), PICK_GO."member&myac=member_public_set", 'succeed');
	}
	if(!$_GET['confirmed']){
		cpmsg(milu_lang('uping')."<script type=\"text/JavaScript\">setTimeout(\"$('loadingform').submit();\", 60000);</script>", PICK_GO."member&myac=member_public_set&update=1", 'download', '', '<div id="percent">0%</div>', FALSE);
		$total = member_count();
		$ajax_url = "admin.php?".PICK_GO."member&myac=ajax_func&inajax=1&af=member_public_info&tpl=no&confirmed=1";
		$finsh_url = "admin.php?".PICK_GO."member&myac=member_public_info&finished=1";
		echo pick_loading($ajax_url, $finsh_url, $total, array('bat_num' => 500));
	}else{
		ob_end_clean();
		$total = intval($_GET['total']);
		$pp = intval($_GET['pp']);
		$currow = intval($_GET['currow']);
		$query = DB::query("SELECT * FROM ".DB::table('strayer_member')." LIMIT $currow,$pp");
		while($rs = DB::fetch($query)) {
			$setarr = get_member_setarr($rs);
			$setarr = paddslashes($setarr);
			DB::update('strayer_member', $setarr, array('uid' => $rs['uid']));
		}
		if($currow + $pp > $total) {
			echo 'TRUE';
			exit();
		}

		echo 'GO';
		exit();
	}
}

//导入在线会员数据
function member_import_online(){
	$step = $_GET['step'];
	$url = GET_URL.'plugin.php?id=pick_user:member&myac=download&tpl=no';
	$go_url = PICK_GO.'member&myac=member_import_online';
	
	if(!$_GET['step'])  cpmsg(milu_lang('get_user_dataing'), $go_url.'&step=1&tpl=no', 'loading', '', false);
	if($step == 1){
		if(!function_exists('gzinflate')) cpmsg_error(milu_lang('disable_func', array('f' => 'gzinflate')));
		$msg_arr = get_contents($url.'&get_type=1&v='.urlencode(PICK_VERSION), array('cache' => -1));
		//echo $url.'&get_type=1&v='.urlencode(PICK_VERSION);
		if($msg_arr < 0) cpmsg_error(milu_lang('no_conn_server'));
		$msg_arr = json_decode(base64_decode($msg_arr));
		echo '<table class="tb tb2 ">
<tbody><tr class="header hover"><td>'.milu_lang('hove_user_data').'</td><td></td><td></td></tr>
<tr class="hover"><td><div class="tipsblock"><ul id="tipslis"><li>'.milu_lang('user_data_size').':'.$msg_arr->size.'</li ><li>'.milu_lang('update_dateline').': '.dgmdate($msg_arr->modify_dateline).' </li ><li>'.milu_lang('member_count').':  '.$msg_arr->count.milu_lang('tiao').'</li ></ul></div></td><td><input type="button" class="btn" onclick="window.location.href=\'?'.$go_url.'&step=2&tpl=no&c='.$msg_arr->count.'\'" value="'.milu_lang('confirm_download').'"></td></tr></tbody></table>';
	}else if($step == 2){
		cpmsg(milu_lang('data_downloading'), $go_url.'&step=3&tpl=no&c='.$_GET['c'], 'loading', '', false);
	}else if($step == 3){
		if($_GET['finished']) {
			cpmsg(milu_lang('run_finsh'), PICK_GO."member&myac=member_list", 'succeed');
		}
		pload('F:spider');
		$snoopy_obj = get_snoopy_obj();
		$data_text = get_img_content($url.'&get_type=2&v='.urlencode(PICK_VERSION), $snoopy_obj);
		if(!$data_text) cpmsg_error(milu_lang('download_fail'));
		$file_name = PICK_CACHE.'/temp_m.zip';
		file_put_contents($file_name, $data_text);
		require_once libfile('class/zip');
		$zip_obj = new SimpleUnzip($file_name);
		foreach($zip_obj->Entries as $k => $v){
			$data = unserialize(base64_decode(dstripslashes($v->Data)));
		}
		@unlink($file_name);
		$data = serialize(serialize_iconv($data));
		file_put_contents(PICK_CACHE.'/temp_m.txt', $data);
		$per_num = 250;
		pcpmsg_loading(milu_lang('importing'), PICK_GO."member&myac=member_import_online&tpl=no&step=3&finished=1", 'loadingform', '', '<div id="percent">0%</div>', FALSE);
		$ajax_url = "admin.php?".PICK_GO."member&myac=ajax_func&inajax=1&af=member_import_online&step=4&tpl=no&confirmed=1";
		$finsh_url = "admin.php?".PICK_GO."member&myac=member_list";
		//echo $ajax_url;exit();
		echo pick_loading($ajax_url, $finsh_url, $_GET['c'], array('bat_num' => $per_num));
	}else if($step == 4){
		$file_name = PICK_CACHE.'/temp_m.txt';
		ob_end_clean();
		$pp = intval($_GET['pp']);
		$currow = intval($_GET['currow']);
		$data = file_get_contents($file_name);
		
		if(!$data) {
			echo 'TRUE';
			exit();
		}

		//$data = dstripslashes($data);
		$data = unserialize($data);
		$i = 1;
		foreach((array)$data as $k => $v){
			if($i > $pp ) break;
			import_member_data($v);
			$i++;
			unset($data[$k]);
		}
		if(!$data) {
			echo 'TRUE';
			@unlink($file_name);
			exit();
		}
		$data = file_put_contents($file_name, serialize($data));
		echo 'GO';
		exit();
	}
	
}

function import_member_data($v, $list=1){
	if(!$v) return;
	$v = paddslashes($v);
	if(!$v['get_uid'] || !$v['get_web_url']) return; 
	$count = DB::result(DB::query("SELECT COUNT(*) FROM ".DB::table('strayer_member')." WHERE  username='$v[username]'"), 0);
	if($count) return;
	$uid = DB::insert('strayer_member', $v, TRUE);
}

function get_member_setarr($v){
	global $_G;
	$v = dstripslashes($v);
	$info = pick_common_get();
	$setarr = $v;
	$setarr['oltime'] = $info['oltime_type'] == 1 && $v['oltime'] ? $v['oltime'] : get_data_range($info['oltime'], -1, 1) ;
	$setarr['regdate'] = $info['regdate_type'] == 1 && $v['regdate'] ? $v['regdate'] : get_rand_time($info['regdate_start_time'], $info['regdate_end_time']);
	$setarr['lastvisit'] = $setarr['lastactivity'] = rand($setarr['regdate'], $_G['timestamp']);
	$setarr['email'] = $v['email'] ? $v['email'] : rand_email($v['username']);
	if(!$v['qq']){
		if(strexists($setarr['email'], '@qq.com')){
			$qq_arr = explode('@', $setarr['email']);
			$setarr['qq'] = $qq_arr[0];
		}else{
			$setarr['qq'] = rand(55054836, 1450250164);
		}
	}
	$info['rand_ip'] = $info['rand_ip'] ? $info['rand_ip'] : '202.106.189.3,202.106.189.4,202.106.189.6,218.247.166.82,218.30.119.114,218.30.119.114 4408,218.64.220.220,218.64.220.2,219.148.122.113,219.232.236.116,221.225.1.239,222.188.10.1,222.223.65.3,222.73.26.211,58.211.0.113,58.214.238.238,202.105.55.38,221.179.35.71,222.64.185.148,114.255.171.231,125.77.200.134';//默认的ip地址列表	
	$ip_arr = format_wrap($info['rand_ip'], ',');
	$rand_ip = parray_rand($ip_arr);
	$setarr['lastip'] = $info['ip_type'] == 1 && $v['lastip'] ? $v['lastip'] : $rand_ip;
	$setarr['regip'] = $info['ip_type'] == 1 && $v['regip'] ? $v['regip'] : $rand_ip; 
	$credits_list = credits_list();
	foreach((array)$credits_list as $k2 => $v2){
		$setarr[$v2['name']] = $info[$v2['name'].'_type'] == 1 && $v[$v2['name']] ? $v[$v2['name']] : get_data_range($info[$v2['name']], -1, 1);
	}
	return $setarr;
}

function member_public($run = 0){
	if(intval($_GET['clear'])) cache_del('member_public');
	$cache_data = load_cache('member_public');
	$save_data = $cache_data ? $cache_data : '';
	$temp_cache_data = '';
	global $head_url,$header_config,$_G;
	if(!$_GET['submit'] || $run == 0) {
		$info['header'] = pick_header_output($header_config, $head_url);
		$info['save_data'] = $save_data;
		return $info;
	}else{
		if(intval($_GET['submit']) == 2 ) unset($save_data);
		if(!$save_data) show_pick_info(milu_lang('start_config'));
		$info = pick_common_get();
		$info['reg_jump_num'] = $info['reg_jump_num'] ? $info['reg_jump_num'] : 100;
		$now_get = $save_data['now_get'] ? $save_data['now_get'] : 0;
		$start_dateline = $save_data['start_dateline'] ? $save_data['start_dateline'] : TIMESTAMP;
		$member_count = member_count('WHERE data_uid=0'); 
		if(!$save_data && !$member_count) {
			show_pick_info(milu_lang('no_member_import_reg', array('url' => '?'.PICK_GO.'member&myac=member_import_online&tpl=no')), 'finsh');
			return FALSE;
		}
		$all_uid_count = $member_count;
		$get_count = $temp_cache_data['get_count'] = $save_data['get_count'] ? $save_data['get_count'] : ($info['reg_num'] && ( $info['reg_num'] < $all_uid_count ) ? $info['reg_num'] : $all_uid_count );
		
		$success_count = $save_data['success_count'] ? $save_data['success_count'] : 0; 
		$limit_num = $info['reg_jump_num'] > $get_count ? $get_count : $info['reg_jump_num'];
		$query = DB::query("SELECT * FROM ".DB::table('strayer_member')." WHERE data_uid=0 ORDER BY get_dateline DESC LIMIT 0,$limit_num ");
		while(($v = DB::fetch($query))) {
			
			show_pick_info(array(milu_lang('reg_member'), '<a>'.$v['username'].'</a>'), 'left', array('li_no_end' => 1, 'no_border' => 1, 'now' => $now_get+1) );
			$info['get_url'] = $v['url'];
			$v['password'] = $info['reg_pwd'];
			
			$v = get_member_setarr($v);
			$re = pick_reg($v);
			
			$now_get++;
			$pro = ceil(100 * ($success_count/$get_count));
			
			$all_get_time = TIMESTAMP - $start_dateline;
			
			$avg_get_time = $all_get_time/$success_count;
			$wait_count = $get_count - $success_count;
			$wait_time = $avg_get_time * $wait_count;
			if(function_exists('php_set')){			
				$memory = (100 * (get_memory()/php_set('memory_limit'))); 
				$memory = ($memory || $memory != 0) ? sprintf('%.0f%%',$memory) : milu_lang('un_know');
			} 
			$show_arr = array('pro' => $pro, 'wait_time' => $wait_time, 'memory' => $memory, 'wait_count' => $wait_count, 'now' => $now_get+1);
			$temp_cache_data['now_get'] = $now_get;
			if(is_array($re)){
				DB::update('strayer_member', array('public_dateline' => $_G['timestamp'], 'data_uid' => $re['uid']), array('uid' => $v['uid']));
				$success_count++;
				$temp_cache_data['success_count'] = $success_count;
				$show_arr['wait_count'] = $wait_count - 1;
				$show_arr['pro'] = ceil(100 * ($success_count/$get_count));
				show_pick_info(milu_lang('reg_finsh'), 'success', $show_arr);
				
			}else{
				DB::update('strayer_member', array('data_uid' => -1), array('uid' => $v['uid']));//标记
				show_pick_info($re, 'err', $show_arr);
			}
			if($success_count == $get_count || $success_count > $get_count) break;
			
			$temp_cache_data['start_dateline'] = $start_dateline;
			if(is_int($now_get / $info['reg_jump_num']) && $now_get != 0 && $success_count < $get_count){
				cache_data('member_public', $temp_cache_data, 3600);
				data_go('member&myac=member_public&submit=1');
				exit();
			}
		}
		
		$all_get_time = TIMESTAMP - $start_dateline;
		$avg_get_time = $all_get_time/$success_count;
		if($success_count < $get_count && $info['reg_num']) {
			if($info['reg_jump_num'] > $get_count){
				if(member_count('WHERE data_uid=0') > 0){
					cache_data('member_public', $temp_cache_data, 3600);
					data_go('member&myac=member_public&submit=1');
					exit();
				}
			}
			show_pick_info(milu_lang('no_member_reg'), 'finsh');
		}	
		$all_get_time_str = diff_time($all_get_time, 1);
		$all_get_time_str = $all_get_time_str ? $all_get_time_str : ceil($all_get_time).milu_lang('sec');
		$finsh_output = milu_lang('reg_over', array('n' => $now_get, 's' => $success_count, 'n_s' => $now_get-$success_count, 'all' => $all_get_time_str, 'avg' => sprintf('%.3f',$avg_get_time)));
		cache_del('member_public');
		$show_arr['wait_count'] = $show_arr['wait_time'] = 0;
		$show_arr['pro'] = 100;
		$show_arr['memory'] = $memory;
		show_pick_info($finsh_output, 'finsh', $show_arr);
	}
	
}


function member_data_del($uid){
	if(!$uid) return;
	$uid_arr = !is_array($uid) && $uid ? array($uid) : $uid;
	DB::query('DELETE FROM '.DB::table('strayer_member')." WHERE uid IN (".dimplode($uid_arr).")");
}



function member_data_list($args = array()){
	global $_G;
	extract($args);
	$page = $_GET['page'] ? intval($_GET['page']) : 1;
	$perpage = $perpage ? $perpage : 30;
	$start = ($page-1)*$perpage;
	$mpurl .= '&perpage='.$perpage.'&s='.$s.'&search_type='.$search_type.'&type='.$type;
	$mpurl = '?'.PICK_GO.'member&myac=member_list'.$mpurl;
	$where = 'WHERE 1=1';
	if($s){
		if($search_type == 0 || !$search_type) {
			$where .= " AND username like '%$s%'";
		}else if($search_type == 1){
			$where .= " AND uid like '%$s%'";
		}else if($search_type == 2){
			$where .= " AND email like '%$s%'";
		}		
	}
	if($type == 1){
		$where .= " AND (data_uid=0 OR data_uid<0)";
	}else if($type == 2){
		$where .= " AND data_uid>0";
	}
	$count = member_count($where);
	if($count) {
		$query = DB::query("SELECT * FROM ".DB::table('strayer_member')." $where  ORDER BY get_dateline DESC LIMIT $start,$perpage ");	
		while(($v = DB::fetch($query))) {
			$v['get_url'] = $v['get_web_url'].'home.php?mod=space&uid='.$v['get_uid'].'&do=profile';
			$v['show_get_dateline'] = dgmdate($v['get_dateline']);
			$v['show_regdate'] = $v['regdate'] ? dgmdate($v['regdate']) : '';
			$v['show_public_dateline'] = $v['public_dateline'] ? dgmdate($v['public_dateline']) : '';
			$data['list'][] = $v;
		}
	}
	$data['count'] = $count;
	$data['multipage'] = multi($count, $perpage, $page, $mpurl);	
	return $data;
}

//头像采集设置
function avatar_set(){
	global $head_url,$header_config;
	if(!$_GET['submit']) {
		$info = pick_common_get();
		$info['header'] = pick_header_output($header_config, $head_url);
		return $info;
	}else{
		$set = $_GET['set'];
		pick_common_set($set);
		cpmsg(milu_lang('save_success'), PICK_GO."member&myac=avatar_set", 'succeed');
	}
}

function avatar_get($run = 0){
	if (!session_id()) session_start();
	pload('F:spider');
	if(intval($_GET['clear'])) unset($_SESSION['avatar_get']);
	$save_data = $_SESSION['avatar_get'] ? $_SESSION['avatar_get'] : '';
	global $head_url,$header_config,$_G;
	if(!$_GET['submit'] || $run == 0) {
		$info['header'] = pick_header_output($header_config, $head_url);
		$info['save_data'] = $save_data;
		return $info;
	}else{
		$submit = intval($_GET['submit']);
		if($submit == 2) unset($save_data);
		if(!$save_data) show_pick_info(milu_lang('start_config'));
		$info = pick_common_get();
		if(!$info['avatar_web_url']) {
			show_pick_info(milu_lang('please_set_avatar_url'), 'show_err');
			return FALSE;
		}
		if(!$info['avata_from_uid']) {
			show_pick_info(milu_lang('set_pick_uid_start'), 'show_err');
			return FALSE;
		}
		$info['avata_jump_num'] = $info['avata_jump_num'] ? $info['avata_jump_num'] : 100;
		$now_get = $save_data['now_get'] ? $save_data['now_get'] : 0;
		
		$limit_num = $info['avata_jump_num'] ? $info['avata_jump_num'] : 50;
		$success_count = $save_data['success_count'] ? $save_data['success_count'] : 0; 
		if($info['avatar_setting_member'] == 1){//设置所有已导入的会员
			if($save_data['get_count']){//查询总共需要设置的
				$get_count = $save_data['get_count'];
			}else{
				$all_count =  DB::result(DB::query("SELECT COUNT(*) FROM ".DB::table('common_member')." c Inner Join ".DB::table('strayer_member')." p ON p.data_uid=c.uid WHERE p.data_uid>0 "), 0);
				$get_count =  $_SESSION['avatar_get']['get_count'] = $all_count;
			}
			if(!$get_count) {
				show_pick_info(milu_lang('no_import_user_data'), 'show_err');
				return FALSE;
			}	
			$query = DB::query("SELECT c.uid,c.username,p.data_uid FROM ".DB::table('common_member')." c Inner Join ".DB::table('strayer_member')." p ON p.data_uid=c.uid WHERE p.data_uid>0 ORDER BY p.get_dateline DESC LIMIT $success_count,$limit_num ");	
			while(($v = DB::fetch($query))) {
				$uid_arr[] = $v['uid'];
			}
		}else{//用户自定义
			
			$re_arr = get_data_range($info['avatar_user_set'], $success_count, $limit_num); 
			$uid_arr = $re_arr['list'];
			$_SESSION['avatar_get']['get_count'] = $get_count = $save_data['get_count'] ? $save_data['get_count'] : $re_arr['all_num'];
			//var_dump($get_count);
		}
		$avatar_get_uid = $save_data['avatar_get_uid'] ? $save_data['avatar_get_uid'] : $info['avata_from_uid'];
		$all_get_time = $save_data['all_get_time'] ? $save_data['all_get_time'] : 0; 
		$snoop_obj = get_snoopy_obj($snoopy_args);
		foreach($uid_arr as $k => $uid){
			
			$v['avatar_web_url'] = $info['avatar_web_url'];
			$v['avatar_get_uid'] = $avatar_get_uid+1;
			$v['cover_avatar'] = $info['cover_avatar'];
			$v['now_get'] = $now_get+1;
			$v['uid'] = $uid;
			$v['get_count'] = $get_count;
			$v['cover_avatar'] = $info['cover_avatar'];
			$v['success_count'] = $success_count;
			$v['all_get_time'] = $all_get_time;
			$v['avata_jump_num'] = $info['avata_jump_num'];
			if(!check_uid($uid)){//不存在的用户
				$show_arr = get_show_arr($now_get, $success_count, $get_count, $all_get_time);
				$show_args = array_merge($show_arr, array('li_no_end' => 1, 'no_border' => 1, 'now' => $v['now_get']));
				show_pick_info(array(milu_lang('uid_no_exists', array('u' => '<a target="_blank" href="home.php?mod=space&uid='.$uid.'&do=profile">'.$uid.'</a>'))), 'left', $show_args);
				$get_re['success_count'] = $v['success_count'] = $v['success_count'] + 1;
				$get_re['get_count'] = $get_count;
				$get_re['now'] = $v['now_get']  = $v['now_get'];
				$get_re['all_get_time'] = $all_get_time;
				$get_re['avatar_get_uid'] = $v['avatar_get_uid'];
				$_SESSION['avatar_get']['now_get'] = $v['now_get'];
				$_SESSION['avatar_get']['avatar_get_uid'] = $v['avatar_get_uid'];
				$_SESSION['avatar_get']['all_get_time'] = $all_get_time;
				$_SESSION['avatar_get']['success_count'] = $v['success_count'];
				$show_args = get_show_arr($v['now_get'], $v['success_count'], $get_count, $all_get_time);
				show_pick_info(milu_lang('jump'), 'err', $show_args);
				avatar_page_jump($v['now_get'], $v['avata_jump_num'], $get_count);
			}else{
				$get_re = $test_re = get_web_avatar($v);//采集头像
			}
			unset($test_re['content']);//debug
			$now_get = $get_re['now'];
			$success_count = $get_re['success_count'];			
			
			$all_get_time = $get_re['all_get_time'];
			$get_count = $get_re['get_count'];

			$avatar_get_uid = $_SESSION['avatar_get']['avatar_get_uid'] = $get_re['avatar_get_uid'];
			
			$show_arr = get_show_arr($now_get, $success_count, $get_count, $all_get_time);
			$_SESSION['avatar_get']['now_get'] = $now_get;
			$_SESSION['avatar_get']['all_get_time'] = $all_get_time;
		}
		$all_get_time_str = diff_time($all_get_time, 1);
		$all_get_time_str = $all_get_time_str ? $all_get_time_str : ceil($all_get_time).milu_lang('sec');
		$avg_get_time = $all_get_time / $success_count;
		$finsh_output = milu_lang('pick_avatar_finsh', array('n' => $now_get, 'g' => $success_count, 'all' => $all_get_time_str, 'avg' => sprintf('%.2f',$avg_get_time)));
		//unset($_SESSION['avatar_get']);
		show_pick_info($finsh_output, 'finsh');
	}
}

function check_uid($uid){
	if(!$uid) return FALSE;
	return DB::result(DB::query("SELECT COUNT(*) FROM ".DB::table('common_member')." WHERE uid = '$uid' "), 0);
}

function get_show_arr($now_get, $success_count, $get_count, $all_get_time = 0, $end = 1){
	$pro = ceil(100 * ($success_count/$get_count));
	if($pro == 101 || $pro > 101) return FALSE; 
	if($end == 1) $get_time = d_e(0);
	$all_get_time += $get_time;
	$avg_get_time = $success_count >0 ? $all_get_time/$success_count : 0;
	$wait_count = $get_count - $success_count;
	$wait_time = $avg_get_time * $wait_count;
	if(function_exists('php_set')){			
		$memory = (100 * (get_memory()/php_set('memory_limit'))); 
		$memory = ($memory || $memory != 0) ? sprintf('%.0f%%',$memory) : milu_lang('un_know');
	} 
	$show_arr = array('pro' => $pro, 'wait_time' => $wait_time, 'memory' => $memory, 'wait_count' => $wait_count, 'now' => $now_get, 'all_get_time' => $all_get_time);
	return $show_arr;
}

//从目标网站获取头像
function get_web_avatar($args, $i = 0){
	d_s();
	$info = $args;
	if($i > 49) {
		show_pick_info(milu_lang('alway_no_get'), 'show_err');
		exit();
	}
	extract($args);

	$_SESSION['avatar_get']['now_get'] = $info['now_get'] = $now_get;
	$_SESSION['avatar_get']['avatar_get_uid'] = $info['avatar_get_uid'] = $avatar_get_uid;
	$_SESSION['avatar_get']['all_get_time'] = $all_get_time;
	$avatar = get_avatar($avatar_get_uid, 'middle');
	$icon_url = $avatar_web_url.$avatar;
	show_pick_info(array(milu_lang('the_uid'),' <a target="_blank" href="'.$icon_url.'">'.$avatar_get_uid.'</a>'.milu_lang('the_avatar')), 'left', array('li_no_end' => 1, 'no_border' => 1, 'now' => $now_get) );
	$snoopy_args = array();
	$snoopy_obj = get_snoopy_obj($snoopy_args);

	if(!$snoopy_obj){
		show_pick_info(milu_lang('no_get_avatar'), 'err', $show_arr);
		$info['all_get_time'] = $all_get_time;
		$info['now_get']++;
		$info['avatar_get_uid']++;
		avatar_page_jump($now_get, $avata_jump_num, $get_count);
		return get_web_avatar($info, $i + 1); 
	}
	$img_re = get_img_content($icon_url, $snoopy_obj);//得到的是middle的头像
	$show_arr = get_show_arr($now_get, $success_count, $get_count, $all_get_time);
	$info['all_get_time'] = $show_arr['all_get_time'];
	if(!$img_re) {
		show_pick_info(milu_lang('avatar_no_exists'), 'err', $show_arr);
		$info['now_get']++;
		$info['avatar_get_uid']++;
		avatar_page_jump($now_get, $avata_jump_num, $get_count);
		return get_web_avatar($info, $i + 1); 
	}
	if(strlen($img_re) == 3972 || strlen($img_re) < 1000){//3972是discuz默认头像的大小
		show_pick_info(milu_lang('user_no_set_avatar'), 'err', $show_arr);
		$info['now_get']++;
		$info['avatar_get_uid']++;
		avatar_page_jump($now_get, $avata_jump_num, $get_count);
		return get_web_avatar($info, $i + 1); 
	}else{//得到头像
		$now_time = time();
		$show_arr['show_js'] = 'show_icon(\''.$show_arr['now'].'\');';
		show_pick_info('<img width="48" height="48" style="margin:5px 0;float:right;" src="'.$icon_url.'">', 'success', $show_arr);
		show_pick_info(array(milu_lang('the_uid_set'), '<a target="_blank" href="home.php?mod=space&uid='.$uid.'&do=profile">'.$uid.'</a>'.milu_lang('the_user_set_avatar')), 'left', array('li_no_end' => 1, 'no_border' => 1, 'now' =>  '-'.$show_arr['now'].$now_time) );
		$size_arr = array('middle', 'big', 'small');//顺序一定不可以变
		$create_re = create_avatar_dir($uid ,$size);//建立头像目录
		if(!$create_re) {
			show_pick_info(milu_lang('avatar_dir_no_wirte'), 'err', $show_arr);
			return FALSE;
		}
		foreach($size_arr as $size){
			if($size != 'middle') {
				$icon_url = $avatar_web_url.get_avatar($avatar_get_uid, $size);
				$img_re = get_img_content($icon_url, $snoopy_obj);
			}
			$avatar_dir_save = './uc_server/'.get_avatar($uid, $size);
			if($cover_avatar == 1 && file_exists($avatar_dir_save)){//覆盖旧头像
				@unlink($avatar_dir_save);
			}
			
			$put_re = file_put_contents($avatar_dir_save, $img_re);//写入头像
			
			if(!$put_re) {
				show_pick_info(milu_lang('avatar_dir_no_wirte'), 'err', $show_arr);
				return FALSE;
			}	
		}		
		$success_count++;
		$_SESSION['avatar_get']['success_count'] = $success_count;
		$show_arr = get_show_arr($now_get, $success_count, $get_count, $all_get_time);
		$show_arr['now_get']++;
		$show_arr['avatar_get_uid']++;
		$show_arr['get_count'] = $get_count;
		$show_info_arr = $show_arr;			
		$show_info_arr['now'] = '-'.$show_arr['now'].$now_time;
		show_pick_info(milu_lang('success'), 'success', $show_info_arr);
		avatar_page_jump($now_get, $avata_jump_num, $get_count);
		$arr = array('content' => $img_re, 'avatar_get_uid' => $avatar_get_uid+1, 'now_get' => $now_get+1, 'success_count' => $success_count, 'get_count' => $get_count);
		return $show_arr ? array_merge($show_arr, $arr) : $arr;
	}
}

function avatar_page_jump($now_get, $avata_jump_num, $get_count){
	if($now_get == 0  || !is_int($now_get / $avata_jump_num)) return FALSE;
	data_go('member&myac=avatar_get&submit=1&jump=1');
	exit();
}




function get_avatar($uid, $size = 'middle', $type = '', $dir = false) {
	$size = in_array($size, array('big', 'middle', 'small')) ? $size : 'middle';
	$uid = abs(intval($uid));
	$uid = sprintf("%09d", $uid);
	$dir1 = substr($uid, 0, 3);
	$dir2 = substr($uid, 3, 2);
	$dir3 = substr($uid, 5, 2);
	$typeadd = $type == 'real' ? '_real' : '';
	if($dir){
		return 'data/avatar/'.$dir1.'/'.$dir2.'/'.$dir3.'/';
	}else{
		return 'data/avatar/'.$dir1.'/'.$dir2.'/'.$dir3.'/'.substr($uid, -2).$typeadd."_avatar_$size.jpg";
	}
	
}



function create_avatar_dir($uid, $size = 'middle'){
	$avatar_dir = get_avatar($uid, $size, '', true);
	$avatar_dir_save = DISCUZ_ROOT.'uc_server/'.$avatar_dir;
	return dmkdir($avatar_dir_save);
}


function member_count($where = ''){
	return DB::result(DB::query("SELECT COUNT(*) FROM ".DB::table('strayer_member').' '.$where), 0);
}

function member_info($uid){
	$arr = DB::fetch_first("SELECT * FROM ".DB::table('strayer_member')." WHERE uid='$uid'");
	return $arr;
}


function rand_email($username){
	$arr = array('@126.com', '@163.com', '@qq.com', '@gmail.com', '@hotmail.com', '@sina.com', '@yahoo.com.cn', '@yahoo.cn', '@sohu.com', '@139.com' );
	$a = rand(0 , (count($arr) - 1));
	$h = $arr[$a];
	$a=ereg('['.chr(0xa1).'-'.chr(0xff).']', $username);
    $b=ereg('[0-9]', $username);
    $c=ereg('[a-zA-Z]', $username);
	if((!$a && $b && $c) || (!$a && $b && !$c) || (!$a && !$b && $c)){
		$f = $username; 
	}else{
		if($h == '@qq.com') return rand(5054836, 8054836).'@qq.com';
		$rand_arr = array_merge(range(0,9),range("a","z"));
		$rand_arr = array_merge($rand_arr, range('A','Z'));
		shuffle($rand_arr);
		$len = rand(6,10);
		$f = implode('',array_slice($rand_arr,0, $len)); 
	}
	return $f.$h;
}


function pick_get_user_info($args){
	extract($args);
	$url = $get_url;
	$content = get_contents($url, array('cookie' => $login_cookie, 'cache' => -1));
	if($content == -1) return -1;//获取不到网页内容
	if(strexists($content, 'AccessDenied by limit')) return -6;
	$info_arr = dom_get_manytext($content, 'div#ct div.mn li');
	//获取用户名
	preg_match_all('/<title>(.*)'.milu_lang('the_user_info').'/i',$content, $matchs);
	$username = str_iconv(trim($matchs[1][0]));
	if(!$info_arr) {
		if(strexists($content, 'alert_error')) return -4;
		return -2;//获取不到任何资料
	}
	if($username && $username_chinese == 1){
		$check_re = ischinese($username);
		if($check_re != 'allcn' && $username_chinese == 1) return -5;//用户名不是中文
	}	
	$info_field_arr = $member_field ? get_member_field($member_field, 2) : array();
	$all_field_arr = get_member_field(array(), 3);
	$i = 0;
	$ip_arr = array('regip', 'lastip');//ip字段
	foreach((array)$info_arr as $k => $v){
		preg_match('/<em>(.*)<\/em>/is', $v, $v_arr);
		$v_name = $v_arr[1];
		$search_re = array_search($v_name, $all_field_arr);
		if(!$search_re) continue;
 		$v = str_replace($v_arr[0], '', $v);
		$v = trim($v);
		$re_arr[$search_re] = $v;
		if($info_field_arr){
			$must_search_re = array_search($v_name, $info_field_arr);
			if($must_search_re) $must_arr[$must_search_re] = $v;
			
		}
		if(in_array($search_re, $ip_arr)){//IP字段
			$re_arr[$search_re] = str_replace(' -', '', $re_arr[$search_re]);
			$re_arr[$search_re] = trim($re_arr[$search_re]);
		}
	}
	if($info_field_arr && (count($must_arr) != count($info_field_arr) || !$matchs[1][0] )) return -3;//取不到所有必须资料
	$re_arr['username'] =  $matchs[1][0];
	$re_arr = $must_arr ? array_merge($re_arr, $must_arr) : $re_arr;
	if(!$re_arr) return -2;
	return $re_arr;
}

function format_member_data($data_arr){
	foreach($data_arr as $k2 => $value){
		$re_arr[$k2] = $value;
		if($k2 == 'birthyear#birthmonth#birthday'){//生日
			$re_arr['birthyear'] = strcut('a'.$value, 'a', milu_lang('year'));;
			$re_arr['birthmonth'] = strcut($value, milu_lang('year'), milu_lang('month'));
			$re_arr['birthday'] = strcut($value, milu_lang('month'), milu_lang('day'));
			unset($re_arr[$k2]);
		}
		
		if($k2 == 'birthprovince#birthcity#birthdist#birthcommunity' || $k2 == 'resideprovince#residecity#residedist#residecommunity#residesuite'){//出生地 || 居住地
			$split_arr= explode(' ',$value);
			$key_arr = explode('#', $k2);
			$combine_arr = array_combine($key_arr, $split_arr);
			$re_arr = $combine_arr ? array_merge($re_arr, $combine_arr) : $re_arr;
			unset($re_arr[$k2]);
		}
		
		if($k2 == 'regdate' || $k2 == 'lastvisit' || $k2 == 'lastactivity' || $k2 == 'lastpost') $re_arr[$k2] = strtotime($re_arr[$k2]);//处理时间
		
		//个人主页
		if($k2 == 'site') $re_arr[$k2] = _striptext($re_arr[$k2]);
	}
	return $re_arr;
}

function get_member_info(){
	$info_str = milu_lang('member_field_str');
	$url = format_url($_GET['url']);
	$test_uid = intval(format_url($_GET['test_uid']));
	$uid_range = $test_uid ? $test_uid : format_url($_GET['uid_range']);
	$login_cookie = format_cookie($_GET['login_cookie']);
	$uid_arr = get_data_range($uid_range);
	$arr = get_user_url_arr($url, $uid_arr['list']);
	$test_url = $arr[0]['url'];
	if(!$test_url) show_pick_window(milu_lang('get_link_list_test'), milu_lang('no_set_uidurl'), array('w' => 620,'h' => '400','f' => 1));
	$content = get_contents($test_url, array('cookie' => $login_cookie));
	if($content == -1){
		show_pick_window(milu_lang('get_link_list_test'), milu_lang('check_user_url'), array('w' => 620,'h' => '400','f' => 1));
	}
	
	$info_arr = dom_get_manytext($content, 'div#ct div.mn li');
	//获取用户名
	preg_match_all('/<title>(.*)'.milu_lang('the_user_info').'/i',$content, $matchs);
	$re_arr[milu_lang('user_name')] =  $matchs[1][0];
	if(!$info_arr){
		show_pick_window(milu_lang('get_link_list_test'), milu_lang('pick_must_set_cookie'), array('w' => 620,'h' => '400','f' => 1));
	}
	$info_field_arr = explode('|', $info_str);
	$i = 0;
	foreach((array)$info_arr as $k => $v){
		foreach($info_field_arr as $k2 => $v2){
			$v2_arr = format_wrap($v2, '@@');
			$v2 = $v2_arr[1];
			if(strexists($v, $v2)){
				$value = str_replace('<em>'.$v2.'</em>', '', $v);
				if(strexists($v2, 'IP')){
					$value = str_replace(' -', '', $value);
				}
				$re_arr[$v2] = trim($value);
			}
		}
	}
	$output .= '<p>'.milu_lang('the_test_url').' : <a target="_brank" href="'.$test_url.'">'.$test_url.'</a></p></br>';
	$output .= '<table class="tb tb2">';
	foreach((array)$re_arr as $k => $v){
		$output .=  '<tr><td>'.$k.' : </td><td>'.$v.'</td></tr>';
	}
	$output .= '</table>';
	show_pick_window(milu_lang('get_link_list_test'), $output, array('w' => 620,'h' => '400','f' => 1));
}



function show_member_field_html($field_arr  = array(), $input_name = 'member_field'){
	$info_arr  = get_member_field();
	$html = '<ul id="member_field_ul" class="filter_html">';
	$display_arr = array(milu_lang('user_name'));
	foreach($info_arr as $k => $v){
		$name = $v;
		$checked = in_array($k, $field_arr) ? 'checked="checked"' : '';
		$disabled = in_array($k, $display_arr) ? 'disabled="disabled" checked="checked" ' : '';
		$show_input_name = in_array($k, $display_arr) ? 'dis_' : $input_name;
		$html .=  '<li><label><input '.$checked.' type="checkbox" '.$disabled.' class="'.$show_input_name.'" value="'.$k.'"  name="'.$show_input_name.'[]">'.$name.'</label></li>';
	}
	$html .= '</ul>';
	return $html;
}

function get_member_field($field_arr = array(), $type = 1){
	$info_str = milu_lang('member_field_str');
	$info_arr = format_wrap($info_str, '|');
	$field_merge_arr = array(
		'birthyear#birthmonth#birthday' => milu_lang('bbb'),
		'birthprovince#birthcity#birthdist#birthcommunity' => milu_lang('bbbb'),
		'resideprovince#residecity#residedist#residecommunity#residesuite' => milu_lang('rrrrr'),
	);
	foreach($info_arr as $k => $v){
		if(!in_array($k, $field_arr) && $field_arr) continue;
		$charset = GBK ? 'GB2312' : 'UTF-8';
		$v_arr = format_wrap($v, '@@');
		$v = $v_arr[1]; 
		$name = htmlentities($v, ENT_QUOTES, $charset);
		if($type == 1) {
			$arr[] = $name;
		}else if($type == 2){
			$arr[$v_arr[0]] = $name;
			if(array_key_exists($v_arr[0],$field_merge_arr)){
				$arr = field_merge($v_arr[0], $field_merge_arr[$v_arr[0]],$arr);
			}
		}else{
			$arr[$v_arr[0]] = $name;
		}
		
	}
	return $arr;
}


function member_log(){
	global $head_url,$header_config;
	if(!submitcheck('addsubmit')) {
		$info = pick_common_get();
		$info['header'] = pick_header_output($header_config, $head_url);
		$info['member_field'] = unserialize($info['member_field']);
		if(!$info['url']) $info['url'] = 'http://www.discuz.net/';//默认的
		if(!$info['jump_num']) $info['jump_num'] = 45;//默认的
		return $info;
	}else{
		$set = $_GET['set'];
		$set['member_field'] = serialize($_GET['member_field']);
		pick_common_set($set);
		cpmsg(milu_lang('op_success'), PICK_GO."member", 'succeed');	
	}
}

function field_merge($key, $value, $arr = array()){
	$key_arr = format_wrap($key, '#');
	$value_arr = format_wrap($value, '#');array(milu_lang('b_year'), milu_lang('b_month'), milu_lang('b_day'));
	$combine_arr = array_combine($key_arr, $value_arr);
	unset($arr[$key]);
	$arr = $combine_arr ? array_merge($arr, $combine_arr) : $arr;
	return $arr;
}

function get_user_url_arr($url, $uid_arr, $slien = ''){
	$get_url_arr = array();
	if($slien){
		$slien_arr = explode(',', $slien);
		$uid_arr = array_slice($uid_arr, $slien_arr[0], $slien_arr[1]);
	}
	foreach($uid_arr as $k => $v){
		$get_url_arr[$k]['url'] = $url.'home.php?mod=space&uid='.$v.'&do=profile';
		$get_url_arr[$k]['uid'] = $v;
	}
	return $get_url_arr;
}


function pick_reg($info){
	$member = $info;
	extract($info);
	global $_G;
	loaducenter();
	require_once libfile('function/misc');
	require_once libfile('function/profile');
	include_once libfile('class/member');
	$activation = array();
	if(!$activation) {
		$usernamelen = dstrlen($username);
		if($usernamelen < 3) {
			return milu_lang('too_short');
		} elseif($usernamelen > 15) {
			return milu_lang('too_long');
		}
		$username = addslashes(trim(dstripslashes($username)));
		$email = trim($email);
	}

	if(!$activation) {
		$uid = uc_user_register($username, $password, $email, $questionid, $answer, $_G['clientip']);
	
		if($uid <= 0) {
			if($uid == -1) {
				return milu_lang('bad_word');
			} elseif($uid == -2) {
				return milu_lang('system_bad_word');
			} elseif($uid == -3) {
				return milu_lang('reged');
			} elseif($uid == -4) {
				return milu_lang('wrong_email');
			} elseif($uid == -5) {
				return milu_lang('bad_email');
			} elseif($uid == -6) {
				return milu_lang('email_reged');
			} else {
				return milu_lang('unknow_error');
			}
		}
	} else {
		list($uid, $username, $email) = $activation;
	}
	if(DB::result_first("SELECT uid FROM ".DB::table('common_member')." WHERE uid='$uid'")) {
		if(!$activation) {
			uc_user_delete($uid);
		}
		return milu_lang('uid_reged');
	}
	$init_arr = explode(',', $_G['setting']['initcredits']);
	$groupinfo['groupid'] = $_G['setting']['newusergroupid'];

	$password = md5(random(10));
	$secques = $questionid > 0 ? random(8) : '';
	//用户资料
	$profile['constellation'] = get_constellation($birthmonth, $birthday);
	$profile['zodiac'] = get_zodiac($birthyear);
	$profile['gender'] = $gender == milu_lang('baomi') ? 0 : ( $gender == milu_lang('man') ? 1 : 0) ;
	$profile_field_arr = array('birthyear', 'birthmonth', 'birthday', 'birthprovince', 'birthcity', 'birthdist', 'birthcommunity', 'resideprovince', 'residecity', 'residedist', 'residecommunity', 'residesuite', 'site', 'bio', 'interest', 'idcardtype', 'idcard', 'bloodtype', 'height', 'weight', 'qq', 'msn', 'taobao', 'yahoo', 'icq', 'alipay', 'lookingfor', 'position', 'occupation', 'education', 'company', 'graduateschool', 'revenue', 'telephone', 'mobile', 'constellation', 'realname', 'zodiac', 'affectivestatus');
	foreach($profile_field_arr as $k => $v){
		$profile[$v] = $$v;
	} 
	$lastactivity =rand($regdate, ($regdate + 3600*24*2));
	if($regipsql) {
		DB::query($regipsql);
	}
	
	$credits = 0;
	if(!empty($_G['setting']['creditsformula'])) {
		eval("\$credits = round(".$_G['setting']['creditsformula'].");");
	}
	$userdata = array(
		'uid' => $uid,
		'username' => $username,
		'password' => $password,
		'email' => $email,
		'adminid' => 0,
		'groupid' => $groupinfo['groupid'],
		'regdate' => $regdate,
		'credits' => $credits,
		'timeoffset' => 9999
	);
	$status_data = array(
		'uid' => $uid,
		'regip' => $regip,
		'lastip' => $lastip,
		'lastvisit' => $lastvisit,
		'lastactivity' => $lastactivity,
		'lastpost' => $lastpost,
		'lastsendmail' => 0,
	);
	$profile['uid'] = $uid;
	$field_forum['uid'] = $uid;
	$field_forum['sightml'] = $sightmlm;
	
	$field_home['uid'] = $uid;
	
	
	DB::insert('common_member', paddslashes($userdata));
	DB::insert('common_member_status', paddslashes($status_data));
	DB::insert('common_member_profile', paddslashes($profile));
	DB::insert('common_member_field_forum', paddslashes($field_forum));
	DB::insert('common_member_field_home', paddslashes($field_home));
	
	
	if($verifyarr) {
		$setverify = array(
			'uid' => $uid,
			'username' => $username,
			'verifytype' => '0',
			'field' => daddslashes(serialize($verifyarr)),
			'dateline' => $lastactivity,
		);
		DB::insert('common_member_verify_info', $setverify);
		DB::insert('common_member_verify', array('uid' => $uid));
	}
	$count_data = array(
		'uid' => $uid,
		'oltime' => $oltime ? $oltime : 0,
		'extcredits1' => $extcredits1 ? $extcredits1 : $init_arr[1],
		'extcredits2' => $extcredits2 ? $extcredits2 : $init_arr[2],
		'extcredits3' => $extcredits3 ? $extcredits3 : $init_arr[3],
		'extcredits4' => $extcredits4 ? $extcredits4 : $init_arr[4],
		'extcredits5' => $extcredits5 ? $extcredits5 : $init_arr[5],
		'extcredits6' => $extcredits6 ? $extcredits6 : $init_arr[6],
		'extcredits7' => $extcredits7 ? $extcredits7 : $init_arr[7],
		'extcredits8' => $extcredits8 ? $extcredits8 : $init_arr[8]
	);
	DB::insert('common_member_count', paddslashes($count_data));
	DB::insert('common_setting', array('skey' => 'lastmember', 'svalue' => $username), false, true);
	manyoulog('user', $uid, 'add');
	
	$totalmembers = DB::result_first("SELECT COUNT(*) FROM ".DB::table('common_member'));
	$userstats = array('totalmembers' => $totalmembers, 'newsetuser' => $username);
	
	checkusergroup($uid);//更新用户所在的用户组
	
	save_syscache('userstats', $userstats);
	$re_arr['uid'] = $uid;
	return $re_arr;

}

function no_member_tips(){
	$tips_arr = dunserialize(pick_common_get(0, 'pick_tips'));
	if($tips_arr['no_user']) return;
	$check = DB::result(DB::query("SELECT COUNT(*) FROM ".DB::table('strayer_member')), 0);
	if($check) return;
	return show_tips('<div class="tipsblock"><li>'.milu_lang('no_member_tips', array('url' => '?'.PICK_GO.'member&myac=member_import_online&tpl=no')).'</li></ul></div>', array('key' => 'no_user', 'w' => 380, 'h' => 250));

}
?>