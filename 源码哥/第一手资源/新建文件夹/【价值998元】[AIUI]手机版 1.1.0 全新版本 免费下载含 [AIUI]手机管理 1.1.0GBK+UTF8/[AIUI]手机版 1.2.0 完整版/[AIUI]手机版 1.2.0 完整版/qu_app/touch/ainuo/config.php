<?php
/*  V1.0
 *  FOR Discuz! X 
 *	ainuo design 
 *  QQ群：550494646
 */
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
global $_G;
require_once libfile('function/cache');
loadcache('ainuodata');

$cache = $_G['cache']['ainuodata'];
if($cache && ((TIMESTAMP - $cache['cachetime']) < 36000)) {
	$configData = $cache['data'];
	$leftnav = $cache['leftnav'];
	$quicknav = $cache['quicknav'];
	$updatecache = false;
}else{
	$configData = get_configData();
	$leftnav = get_leftnav();
	$quicknav = get_quicknav();
	$updatecache = true;
}
if($updatecache){
	$cache_data = array('cachetime' => TIMESTAMP,'data' => $configData,'annc' => $annclist,'leftnav' => $leftnav,'quicknav' => $quicknav,'zhiding' => $datazd,'moduleid' => $datamodule,'topnav' => $topnav,'newad' => $dataad);
	savecache('ainuodata', $cache_data);
}


//配置参数获取
function get_configData(){
	$query = DB::query("SELECT * from ".DB::table('qu_app')."");
	foreach(DB::fetch($query) as $key => $list){
		$data[$key] = $list;
	}
	return $data;
}

//左侧导航获取//Form  www.ymg6.com
function get_leftnav(){
	$query = DB::query('SELECT * FROM '.DB::table('qu_appnav').' ORDER BY displayorder ASC');
	while($list = DB::fetch($query)){
		$data[] = $list;
	}
	return $data;
}

//底部发帖弹出导航获取
function get_quicknav(){
	$query = DB::query('SELECT * FROM '.DB::table('qu_appquicknav').' ORDER BY displayorder ASC');
	while($list = DB::fetch($query)){
		$data[] = $list;
	}
	return $data;
}

function aremaintime($time) {
	$days = intval($time / 86400);
	$time -= $days * 86400;
	$hours = intval($time / 3600);
	$time -= $hours * 3600;
	$minutes = intval($time / 60);
	$time -= $minutes * 60;
	$seconds = $time;
	return array((int)$days, (int)$hours, (int)$minutes, (int)$seconds);
}

?>