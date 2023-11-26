<?php
if(!defined('IN_DISCUZ')) { exit('Access Denied'); }

$operation = $_GET['operation'];

define('PICK_PATH', DISCUZ_ROOT.'source/plugin/milu_pick');
define('PICK_URL', $_G['siteurl'].'/source/plugin/milu_pick/');

if(!function_exists('currentlang')){
	function currentlang() {
		$charset = strtoupper(CHARSET);
		if($charset == 'GBK') {
			return 'SC_GBK';
		} elseif($charset == 'BIG5') {
			return 'TC_BIG5';
		} elseif($charset == 'UTF-8') {
			global $_G;
			if($_G['config']['output']['language'] == 'zh_cn') {
				return 'SC_UTF8';
			} elseif ($_G['config']['output']['language'] == 'zh_tw') {
				return 'TC_UTF8';
			}
		} else {
			return '';
		}
	}

}

function zend_check(){
	if(!file_exists(PICK_PATH.'/zend/zendcheck')){//应用中心不允许上传zend加密文件，故临时更换检测方法。
		if (extension_loaded('Zend Optimizer') || extension_loaded('Zend Guard Loader') || get_cfg_var("zend_extension")||get_cfg_var("zend_optimizer.optimization_level")||get_cfg_var("zend_extension_manager.optimizer_ts")||get_cfg_var("zend_extension_ts")){
			return 1;
		}else{
			return -2;
		}
	}else{
		$zend_check = dfsockopen(PICK_URL.'/zend/zendcheck.php');
		if(!$zend_check) return -1;
		preg_match('/s=\'(.*?)\';v=\'(.*?)\';/is', $zend_check, $v_arr);
		$msg = $v_arr[1];
		if($msg == 'OK') return 1;
		return -2;
	}
	return 1;
}

if($operation == 'delete'){//卸载

}else if($operation == 'import'){//安装
	require_once libfile('class/xml');
	$extra = currentlang();
	$extra = $extra ? '_'.$extra : '';
	if(file_exists(PICK_PATH.'/discuz_plugin_milu_pick'.$extra.'.xml')) {
		$importtxt = @implode('', file(PICK_PATH.'/discuz_plugin_milu_pick'.$extra.'.xml'));
	} elseif(file_exists($entrydir.'/discuz_plugin_milu_pick.xml')) {
		$importtxt = @implode('', file(PICK_PATH.'/discuz_plugin_milu_pick_xml'));
	}
	if($importtxt) {
		$pluginarray = getimportdata('Discuz! Plugin', 0, 1);
		$_G['cache']['pluginlanguage_script']['milu_pick'] = $pluginarray['language']['scriptlang'];
		if(!empty($pluginarray['plugin']['name'])) {
			$entryversion = dhtmlspecialchars($pluginarray['plugin']['version']);
			if(strexists(strtolower($entryversion), 'vip')){//vip版本
				$zend_check = zend_check();
				if($zend_check == -1){
					cpmsg_error(temp_lang('http_visit', array('file' => PICK_URL.'/zend/zendcheck.php')) );
				}else if($zend_check == -2){
					cpmsg_error(temp_lang('zend_enable'));
				}
			}
		}
	}
	if(!dir_writeable(PICK_PATH.'/data/cache')){
		cpmsg_error(temp_lang('dir_no_write', array('dir' => './source/plugin/milu_pick/data/cache')));
	}
}


function temp_lang($langvar = null, $vars = array()) {
	global $_G;
	$key = 'milu_pick';
	$returnvalue = $_G['cache']['pluginlanguage_script'];
	$return = $langvar !== null ? (isset($returnvalue[$key][$langvar]) ? $returnvalue[$key][$langvar] : null) : $returnvalue[$key];
	$return = $return === null ? ($default !== null ? $default : $langvar) : $return;
	$searchs = $replaces = array();
	if($vars && is_array($vars)) {
		foreach($vars as $k => $v) {
			$searchs[] = '{'.$k.'}';
			$replaces[] = $v;
		}
	}
	if(is_string($return) && strpos($return, '{_G/') !== false) {
		preg_match_all('/\{_G\/(.+?)\}/', $return, $gvar);
		foreach($gvar[0] as $k => $v) {
			$searchs[] = $v;
			$replaces[] = getglobal($gvar[1][$k]);
		}
	}
	$return = str_replace($searchs, $replaces, $return);
	return $return;
}

?>