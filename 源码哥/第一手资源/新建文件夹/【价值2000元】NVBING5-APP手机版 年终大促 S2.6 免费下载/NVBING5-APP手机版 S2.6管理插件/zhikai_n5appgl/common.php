<?php
function init_n5app(){
	global $_G;
	loadcache('plugin');
	$n5app = $_G['cache']['plugin']['zhikai_n5appgl'];
	$n5app['forums'] = dunserialize($n5app['forums']);
	$n5app['recomforums'] = dunserialize($n5app['recomforums']);
	$n5app['guide_block'] = n5app_block($n5app['guide_block']);
	$n5app['news_block'] = n5app_block($n5app['news_block']);
	$n5app['bbs_block'] = n5app_block($n5app['bbs_block']);
	$n5app['group_block'] = n5app_block($n5app['group_block']);
	$n5app['forumstyle'] = dunserialize( $_G['cache']['plugin']['zhikai_n5appgl']['forumstyle'] );
	$n5app['lang'] = dzlang();
	return $n5app;
}//Fro m www.xhkj5.com
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
}
function n5app_block($blocks){
	global $_G;
	$blocks = str_replace(array('<!--{block/','}-->'),'',$blocks);
	$blocks = explode(PHP_EOL,$blocks);
	$data = '';
	foreach($blocks as $bid){
		$data .= n5app_blocktags($bid);
	}//From www.ym g6.co m
	return $data;
}
function n5app_blocktags($parameter) {
	include_once libfile('function/block');
	loadcache('blockclass');
	$bid = dintval(trim($parameter));
	block_get_batch($bid);
	$data = block_fetch_content($bid, true);
	return $data;
}//From ww w.xhkj5.com
?>
