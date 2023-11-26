<?php

/*
 * CopyRight  : [www.moqu8.com!] (C)2014-2015
 * Document   : 魔趣吧：www.moqu8.com
 * Created on : 2015-01-17,21:45:40
 * Author     : 魔趣吧(QQ：10373458)  $
 * Description: This is NOT a freeware, use is subject to license terms.
 *              魔趣吧出品 必属精品。
 *              魔趣吧源码论坛 全网首发 http://www.moqu8.com；
 */
if (!defined('IN_DISCUZ')) {
    exit('Access Denied');
}
include_once DISCUZ_ROOT.'./source/plugin/ljdaka/shiqu.inc.php';
$config = $_G['cache']['plugin']['ljdaka'];
$day = date('d');
$mon = date('m');
$year = date('Y');
$today = date('N');
$start = date('Y-m-d', mktime(0, 0, 0, $mon, $day - $today + 1, $year));
$end = date('Y-m-d H:i:s', mktime(23, 59, 59, $mon, $day - $today + 7, $year));
$tomon_s = date('Y-m-d H:i:s', mktime(0, 0, 0, $mon, 1, $year));
$tomon_e = date('Y-m-d H:i:s', mktime(23, 59, 59, $mon + 1, 0, $year));
$s_tomon_s = date('Y-m-d H:i:s', mktime(0, 0, 0, $mon-1, 1, $year));
$x_tomon_e = date('Y-m-d H:i:s', mktime(23, 59, 59, $mon , 0, $year));
$settingfile = DISCUZ_ROOT . './data/sysdata/cache_ljdaka_setting.php';
if(file_exists($settingfile)){
	include $settingfile;
}
//ini_set('max_execution_time','1111111111111');
if($_GET['act']=='y'){
	if(TIMESTAMP>$wcache['time_y']+$config['che_time']*60*60){
		$num = DB :: fetch_all("select uid,count(uid) x,sum(jinbi) v from " . DB :: table('plugin_daka') . " where  timestamp>='" . strtotime($tomon_s) . "' and timestamp<='" . strtotime($tomon_e) . "' group by uid ");
		
		foreach($num as $k=>$v){
			if(C::t('#ljdaka#plugin_daka_user_y')->fetch($v['uid'])){
				DB::update('plugin_daka_user_y',array('yueday'=>$v['x'],'yuemoney'=>$v['v'],'timestamp'=>TIMESTAMP),' uid='.$v['uid']);
			}else{
				$user=getuserbyuid($v['uid']);
				DB::insert('plugin_daka_user_y',array('uid'=>$v['uid'],'username'=>$user['username'],'yueday'=>$v['x'],'yuemoney'=>$v['v'],'timestamp'=>TIMESTAMP));
			}
		}
		$wcache['time_y']=TIMESTAMP;
		require_once libfile('function/cache');
		writetocache('ljdaka_setting', getcachevars(array('wcache' => $wcache)));//将管理中心配置项写入缓存
	}
}else{
	if(TIMESTAMP>$wcache['time']+$config['che_time']*60*60){
		$num = DB :: fetch_all("select uid,count(uid) x,sum(jinbi) v from " . DB :: table('plugin_daka') . " where  timestamp>='" . strtotime($start) . "' and timestamp<='" . strtotime($end) . "' group by uid ");
		foreach($num as $k=>$v){
			if(C::t('#ljdaka#plugin_daka_user_z')->fetch($v['uid'])){
				DB::update('plugin_daka_user_z',array('zhouday'=>$v['x'],'zhoumoney'=>$v['v'],'timestamp'=>TIMESTAMP),' uid='.$v['uid']);
			}else{
				$user=getuserbyuid($v['uid']);
				DB::insert('plugin_daka_user_z',array('uid'=>$v['uid'],'username'=>$user['username'],'zhouday'=>$v['x'],'zhoumoney'=>$v['v'],'timestamp'=>TIMESTAMP));
			}
		}
		$wcache['time']=TIMESTAMP;
		require_once libfile('function/cache');
		writetocache('ljdaka_setting', getcachevars(array('wcache' => $wcache)));//将管理中心配置项写入缓存
	}
}
?>