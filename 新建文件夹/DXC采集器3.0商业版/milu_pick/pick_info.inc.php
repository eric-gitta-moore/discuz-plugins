<?php
if(!defined('IN_DISCUZ') ) {
	exit('Access Denied');
}
require_once(DISCUZ_ROOT.'source/plugin/milu_pick/config.inc.php');
pload('F:copyright');
$ac = $_GET['ac'];
if(!empty($ac) && function_exists($ac)) {
	$info = $ac();
	return;
}	
$user_arr = get_user_level();
$evo_check_msg = evo_check();
$evo_config_arr = evo_server_config();
$pick_count_msg = pick_count();

function pick_count(){
	//clear_pick_cache(1);//缓存定期清理
	//clear_search_index(1);//清除索引
	clear_log(1);//清除日志
	pload('C:cache');
	$arr['search_index']['name'] = milu_lang('rules_search_index');
	$arr['search_index']['msg'] = milu_lang('search_index_notice');
	$arr['search_index']['show'] =  '<span style=" width:120px; float:left">'.milu_lang('search_index_c').'<hr>';
	$type_arr = array('1' => milu_lang('fast_pick_rules'), '2' => milu_lang('dxc_system_rules'), '3' => milu_lang('fastpick_evo'));
	$type_arr2 = array('3' => milu_lang('server_'), '4' => milu_lang('local_'));
	foreach($type_arr as $k => $v){
		foreach($type_arr2 as $k2 => $v2){
			$type = $k.$k2;
			$show_name = '<span style=" width:120px; float:left">'.$type_arr[$k].$type_arr2[$k2].'</span>';
			$search_index_count = DB::result(DB::query("SELECT COUNT(*) FROM ".DB::table('strayer_searchindex')." WHERE type='$type'"), 0);
			$arr['search_index']['show'] .= $show_name.' '.$search_index_count.'<br />';
		}
	}
	$log_info = IO::info(PICK_DIR.'/data/log');
	$arr['log']['name'] = milu_lang('log_size');
	$arr['log']['msg'] = milu_lang('auto_pick_notice');
	$arr['log']['show'] = sizecount($log_info['size']);
	$cache_info = IO::info(PICK_CACHE, 1, 1);
	$arr['cache']['name'] = milu_lang('cache_file_size');
	$arr['cache']['show'] = milu_lang('cache_size_value', array('s' => sizecount($cache_info['size']), 'p' => PICK_CACHE_SIZE));
	$arr['cache']['msg'] = milu_lang('cache_notice');
	return $arr;
		
}



function evo_check(){
	/*
	$arr[0]['name'] = milu_lang('can_visit_url');
	$arr[0]['check'] = 1;
	if(!function_exists('ini_get')){
		$arr[0]['msg'] = milu_lang('no_open_no_run');
		$arr[0]['check'] = 0;
		$arr[0]['tip'] = milu_lang('no_get_value');
	}else{
		if(!ini_get('allow_url_fopen')){	
			$arr[0]['check'] = 0;
			$arr[0]['msg'] = milu_lang('pick_no_run');
		}
	}
	*/
	/*
	$arr[1]['name'] = milu_lang('open_crul');
	$arr[1]['check'] = 1;
	if(!function_exists('curl_init')){
		$arr[1]['msg'] = milu_lang('open_crul_notice');
		$arr[1]['check'] = 0;
	}
	*/
	$arr[2]['name'] =  milu_lang('open_tow_p');
	if(function_exists('fsockopen') || function_exists('pfsockopen')){
		$arr[2]['check'] = 1;
	}else{
		$arr[2]['check'] = 0;
		$arr[2]['msg'] = milu_lang('no_tow_notice');
	}
	$arr[3]['name'] =  'file_get_contents()'.milu_lang('func');
	if(function_exists('file_get_contents')){
		$arr[3]['check'] = 1;
	}else{
		$arr[3]['check'] = 0;
		if ($arr[2]['check'] == 0 && $arr[3]['check'] == 0) $arr[1]['msg'] = '<ul id="tipslis"><li>'.milu_lang('no_use_pick').'</li></ul>';
	}
	
	$arr[4]['name'] =  milu_lang('pick_dir_write');
	$arr[4]['check'] = 1;
	if(!dir_writeable(PICK_PATH.'/data/cache')){
		$arr[4]['check'] = 0;
		$arr[4]['msg'] = '<li>'.milu_lang('dir_no_write', array('dir' => './source/plugin/milu_pick/data/cache')).'</li>';
	}
	if(!dir_writeable(PICK_PATH.'/data/log')){
		$arr[4]['check'] = 0;
		$arr[4]['msg'] .= '<li>'.milu_lang('dir_no_write', array('dir' => './source/plugin/milu_pick/data/log')).'</li>';
	}
	if($arr[4]['msg']) $arr[4]['msg'] = '<ul id="tipslis">'.$arr[4]['msg'].'</ul>'; 
	/*
	$arr[6]['name'] =  '插件文件完整性';
	if($a == $b){
		$arr[6]['check'] = 1;
	}else{
		$arr[6]['check'] = 0;
		$arr[6]['msg'] = '<ul id="tipslis"><li>插件上传过程中，文件丢失，请重新上传文件</li></ul>';
	}
	*/
	
	$arr[7]['name'] =  milu_lang('open_gzinflate');
	if(function_exists('gzinflate')){
		$arr[7]['check'] = 1;
	}else{
		$arr[7]['check'] = 0;
		$arr[7]['msg'] = milu_lang('no_gzinflate_notice');
	}
	$arr[8]['name'] =  milu_lang('open_zend');
	if(($zend_re = is_zend()) > 0){
		$arr[8]['check'] = 1;
		$arr[8]['msg'] = milu_lang('zend_notice');
	}else{
		$arr[8]['check'] = 0;
		$arr[8]['msg'] = $zend_re == -1 ? milu_lang('http_visit', array('file' => 'source/plugin/milu_pick/zend/zendcheck.php')) : milu_lang('zend_enable');
	}
	return $arr;
}
//获取服务器参数
function evo_server_config(){
	$get = function_exists('ini_get') ? TRUE : FALSE;
	$memory_str = $get ? ini_get('memory_limit') : '-1';
	if($memory_str >0){
		$m = intval($memory_str);
		$memory_msg = milu_lang('memory_notice');
	}
	$config_arr['php_version'] = array(
		'name' => milu_lang('phpversion'),
		'value' => phpversion(),
		'msg' => '',
		'best_value' => '',
	);
	$config_arr['memory_limit'] = array(
		'name' => milu_lang('php_memory_set'),
		'value' => $memory_str == '-1' ?  milu_lang('un_know') : $memory_str,
		'msg' => $memory_msg,
		'best_value' => '256MB'.milu_lang('set_up'),
 	);
	$dis_fun = $get ? ini_get("disable_functions") : '-1';
	$config_arr['display_function'] = array(
		'name' => milu_lang('no_use_func'),
		'value' => $dis_fun ? ($dis_fun != '-1' ? $dis_fun : milu_lang('un_know')) : milu_lang('no_have'),
	);
	
	$max_time = $get ? ini_get("max_execution_time") : '-1';
	$config_arr['max_execution_time'] = array(
		'name' => milu_lang('time_out_time'),
		'value' => $max_time ? ($max_time != '-1' ? $max_time.milu_lang('sec') : milu_lang('un_know')) : milu_lang('no_limit'),
		'best_value' => milu_lang('no_limit'),
	);
	
	return $config_arr;
}


$_GET['tpl'] = $_GET['tpl'] ? $_GET['tpl'] : 'pick_info';
if($_GET['tpl'] != 'no' && $_GET['tpl']) include template('milu_pick:'.$_GET['tpl']);
?>