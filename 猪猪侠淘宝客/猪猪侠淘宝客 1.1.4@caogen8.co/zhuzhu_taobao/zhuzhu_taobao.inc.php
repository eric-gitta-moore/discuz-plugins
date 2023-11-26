<?php

/**
 *      [Caogen8!] (C)2014-2018 Www.Caogen8.co.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: zhuzhu_taobao.inc.php 10689 2017-07-31 08:32:33Z Вн-Иљ-АЩ $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

require_once(DISCUZ_ROOT.'./source/plugin/zhuzhu_taobao/sdk/TopSdk.php');

loadcache(array('zhuzhu_taobao_category', 'zhuzhu_taobao_brand', 'zhuzhu_taobao_cat', 'zhuzhu_taobao_seo'));

$var = $_G['cache']['plugin']['zhuzhu_taobao'];

$appkey = $var['appkey'];
$secret = $var['appsecret'];
$appadzoneid = explode('_', $var['adzoneid']);
$appadzoneid = $appadzoneid['3'];

$img = './source/plugin/zhuzhu_taobao/static/image/';
$jump_url = 'plugin.php?id=zhuzhu_taobao&mod=jump_url&num_iid=';
$go_taobao = 'plugin.php?id=zhuzhu_taobao&mod=app&backurl=';

$hotkeys =  explode('|', $var['hot_key']);
$sch_history = $_G['cookie']['sch_history'];
if($_G['mobile']) {
	$sch_history = diconv($sch_history, 'utf-8', CHARSET);
}
$sch_history_list = explode('|', $sch_history);
$sch_history_list = array_unique($sch_history_list);
foreach($sch_history_list as $key=>$v){
	if($v){
		$sch_list[] = $v;
	}
}

$index_slide = explode("\n", $var['index_slide']);
foreach($index_slide as $key => $value) {
	list($pic, $url, $bgcolor) = explode('#', $value);
	$slide[$key]['pic'] = $pic;
	$slide[$key]['url'] = $url;
	$slide[$key]['bgcolor'] =  str_replace(array("\r\n", "\r", "\n"), "", $bgcolor);
	if($key == '0'){
	$bg_arr .= '"#'.$slide[$key]['bgcolor'].'"';
	}else{
	$bg_arr .= ',"#'.$slide[$key]['bgcolor'].'"';
	}
}

if(!$_G['mobile']) {
	hookscriptoutput();
}

$zz_nav = unserialize($var['nav_show']);
$zz_foot_tag = explode("|", $var['foot_tag']);
$zz_seo = unserialize($_G['setting']['zhuzhu_seo']);

$modarray = array('index', 'quan', 'tbk', 'tkl', 'tqg', 'uatm', 'tbrand', 'jump_url', 'app', 'img', 'api');
$mod = !in_array($_G['mod'], $modarray) ? 'index' : $_G['mod'];

require DISCUZ_ROOT.'./source/plugin/zhuzhu_taobao/module/taobao_'.$mod.'.php';

?>