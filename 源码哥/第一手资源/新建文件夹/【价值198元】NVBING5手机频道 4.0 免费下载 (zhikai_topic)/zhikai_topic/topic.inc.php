<?php
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
if(defined('IN_MOBILE') != 2){
	dheader("location:misc.php?mod=mobile");
}
$entitle = daddslashes(trim($_GET['topic']));
$topic = C::t("#zhikai_topic#topic")->fetch_by_entitle($entitle,false);
if(!$entitle || !$topic) showmessage( lang('plugin/zhikai_topic', 'lang001') );
$seo = dunserialize($topic['seo']);
$seo = dhtmlspecialchars($seo);

$navtitle = $seo['title'];
if($seo['keywords']) $metakeywords = $seo['keywords'];
if($seo['description']) $metadescription = $seo['description'];
$topic['content'] = $topic['type'] == 1?n5app_block($topic['blocks']):$topic['html'];
$topic = dstripslashes($topic);
$n5app = init_n5app();
include template("zhikai_topic:topic");

function init_n5app(){
	global $_G;
	loadcache('plugin');
	$n5app = $_G['cache']['plugin']['zhikai_n5appgl'];
	$n5app['lang'] = dzlang();
	return $n5app;
}

function dzlang(){
	global $_G;
	$addonname = 'zhikai_n5appgl';
	$dlang = array();
	for($i=1;$i<1000;$i++){
		$key = 'lang'.sprintf("%03d", $i);
		$dlang[$key] = lang('plugin/'.$addonname, $key);
		$tmp = explode("=",$dlang[$key]);
		if(count($tmp) == 2){
			$dlang[$tmp[0]] = $tmp[1];
		}
	}
	return $dlang;
}//From www.ymg 6.c om

function n5app_block($blocks){
	global $_G;
	$blocks = str_replace(array('<!--{block/','}-->'),'',$blocks);
	$blocks = explode(PHP_EOL,$blocks);
	$data = '';
	foreach($blocks as $bid){
		$data .= n5app_blocktags($bid);
	}
	return $data;
}
function n5app_blocktags($parameter) {
	include_once libfile('function/block');
	loadcache('blockclass');
	$bid = dintval(trim($parameter));
	block_get_batch($bid);
	$data = block_fetch_content($bid, true);
	return $data;
}
?>  