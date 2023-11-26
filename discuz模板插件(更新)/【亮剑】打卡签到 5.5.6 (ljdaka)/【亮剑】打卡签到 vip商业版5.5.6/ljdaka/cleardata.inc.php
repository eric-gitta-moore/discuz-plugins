<?php
/**
*
*数据清理
* 
* @author 余新启
* @copyright dzx30.com 2012-08-21
* 
*/
if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
include_once DISCUZ_ROOT.'./source/plugin/ljdaka/shiqu.inc.php';
$allowaction = array('list', 'detail', 'add');
$act = in_array(addslashes($_GET['act']), $allowaction) ? addslashes($_GET['act']) : 'list';

$settingfile = DISCUZ_ROOT . './data/sysdata/cache_ljdaka_setting.php';
if(file_exists($settingfile)){
	include $settingfile;
}

switch ($act){
	case 'list':
		showformheader("plugins&operation=config&identifier=ljdaka&pmod=cleardata&act=add");
		showtableheader(lang('plugin/ljdaka','cleardata_1'));
		showsetting(lang('plugin/ljdaka','cleardata_2'), 'x3', $wcache['x3'], 'radio', 0, 1,lang('plugin/ljdaka','cleardata_3'));
		showtagfooter('tbody');
		showsetting(lang('plugin/ljdaka','cleardata_4'), 'x4', $wcache['x4'], 'radio', 0, 1,lang('plugin/ljdaka','cleardata_5'));
		showtagfooter('tbody');
		showsetting(lang('plugin/ljdaka','cleardata_6'), array('jiankong', array(
				array(0, lang('plugin/ljdaka','cleardata_7')),
				array(1, lang('plugin/ljdaka','cleardata_8')),
				array(2,lang('plugin/ljdaka','cleardata_9')),
			)), $wcache['jiankong'], 'mradio','','',lang('plugin/ljdaka','cleardata_10'));
		showtagfooter('tbody');
		showsubmit('editsubmit');
		showtablefooter();
		showformfooter();
		break;
	case 'add':		
		if(submitcheck('editsubmit')){
			$wcache['x3']=intval($_GET['x3']);
			$wcache['x4']=intval($_GET['x4']);
			$wcache['jiankong']=intval($_GET['jiankong']);
			require_once libfile('function/cache');
			writetocache('ljdaka_setting', getcachevars(array('wcache' => $wcache)));//将管理中心配置项写入缓存
		
			if($wcache['x3']){
				$sql="delete from ".DB::table("plugin_daka");
				DB::query($sql);
				$sql="delete from ".DB::table("plugin_daka_user");
				DB::query($sql);
			}else{ 
					$day = date('d');
					$mon = date('m');
					$year = date('Y');
					$today = date('N');
					$time = date('Y-m-d H:i:s', mktime(0, 0, 0, $mon-$wcache['jiankong'], 1, $year));
					
					$sql="delete from ".DB::table("plugin_daka")." where timestamp<'".strtotime($time)."'";
					DB::query($sql);
			}
			cpmsg(lang('plugin/ljdaka','cleardata_11'), 'action=plugins&operation=config&identifier=ljdaka&pmod=cleardata', 'succeed');
			break;
		}
	
}
?>