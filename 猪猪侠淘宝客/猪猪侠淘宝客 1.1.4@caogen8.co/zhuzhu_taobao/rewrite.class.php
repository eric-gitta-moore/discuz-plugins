<?php

/**
 *      [Caogen8!] (C)2014-2018 Www.Caogen8.co.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: rewrite.class.php 37712 2018-03-01 17:57:48Z ²Ý-¸ù-°É $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class plugin_zhuzhu_taobao {

	function plugin_zhuzhu_taobao() {
		global $_G;
		$zhuzhu_rewrite = dunserialize($_G['setting']['zhuzhu_taobao']);

		if($zhuzhu_rewrite['taobao']['available']) {
			$_G['setting']['output']['preg']['search']['taobao'] = "/<a href\=\"plugin.php\?id\=zhuzhu_taobao\"([^\>]*)\>/e";
			$_G['setting']['output']['preg']['replace']['taobao'] = "plugin_zhuzhu_taobao::rewriteoutput('taobao', 0)";
		}
		if($zhuzhu_rewrite['taobao-tbk']['available']) {
			$_G['setting']['output']['preg']['search']['taobao-tbk'] = "/<a href\=\"plugin.php\?id\=zhuzhu_taobao&(amp;)mod\=tbk\"([^\>]*)\>/e";
			$_G['setting']['output']['preg']['replace']['taobao-tbk'] = "plugin_zhuzhu_taobao::rewriteoutput('taobao-tbk', 0)";
		}
		if($zhuzhu_rewrite['taobao-tbk-cat']['available']) {
			$_G['setting']['output']['preg']['search']['taobao-tbk-cat'] = "/<a href\=\"plugin.php\?id\=zhuzhu_taobao&(amp;)mod\=tbk&(amp;)?cat\=(\d+)\"([^\>]*)\>/e";
			$_G['setting']['output']['preg']['replace']['taobao-tbk-cat'] = "plugin_zhuzhu_taobao::rewriteoutput('taobao-tbk-cat', 0, '\\1', '\\3')";
		}
		if($zhuzhu_rewrite['taobao-tbk-9k9']['available']) {
			$_G['setting']['output']['preg']['search']['taobao-tbk-9k9'] = "/<a href\=\"plugin.php\?id\=zhuzhu_taobao&(amp;)mod\=tbk&(amp;)?ac\=9k9\"([^\>]*)\>/e";
			$_G['setting']['output']['preg']['replace']['taobao-tbk-9k9'] = "plugin_zhuzhu_taobao::rewriteoutput('taobao-tbk-9k9', 0, '\\1', '\\3')";
		}
		if($zhuzhu_rewrite['taobao-tqg']['available']) {
			$_G['setting']['output']['preg']['search']['taobao-tqg'] = "/<a href\=\"plugin.php\?id\=zhuzhu_taobao&(amp;)mod\=tqg\"([^\>]*)\>/e";
			$_G['setting']['output']['preg']['replace']['taobao-tqg'] = "plugin_zhuzhu_taobao::rewriteoutput('taobao-tqg', 0)";
		}
		if($zhuzhu_rewrite['taobao-tbrand']['available']) {
			$_G['setting']['output']['preg']['search']['taobao-tbrand'] = "/<a href\=\"plugin.php\?id\=zhuzhu_taobao&(amp;)mod\=tbrand\"([^\>]*)\>/e";
			$_G['setting']['output']['preg']['replace']['taobao-tbrand'] = "plugin_zhuzhu_taobao::rewriteoutput('taobao-tbrand', 0)";
		}
		if($zhuzhu_rewrite['taobao-tbrand-view']['available']) {
			$_G['setting']['output']['preg']['search']['taobao-tbrand-view'] = "/<a href\=\"plugin.php\?id\=zhuzhu_taobao&(amp;)mod\=tbrand&(amp;)?op\=view&(amp;)?brand_id\=(\d+)\"([^\>]*)\>/e";
			$_G['setting']['output']['preg']['replace']['taobao-tbrand-view'] = "plugin_zhuzhu_taobao::rewriteoutput('taobao-tbrand-view', 0, '\\1', '\\4')";
		}
		if($zhuzhu_rewrite['taobao-uatm']['available']) {
			$_G['setting']['output']['preg']['search']['taobao-uatm'] = "/<a href\=\"plugin.php\?id\=zhuzhu_taobao&(amp;)mod\=uatm\"([^\>]*)\>/e";
			$_G['setting']['output']['preg']['replace']['taobao-uatm'] = "plugin_zhuzhu_taobao::rewriteoutput('taobao-uatm', 0)";
		}
		if($zhuzhu_rewrite['taobao-uatm-cat']['available']) {
			$_G['setting']['output']['preg']['search']['taobao-uatm-cat'] = "/<a href\=\"plugin.php\?id\=zhuzhu_taobao&(amp;)mod\=uatm&(amp;)?favorites_id\=(\d+)\"([^\>]*)\>/e";
			$_G['setting']['output']['preg']['replace']['taobao-uatm-cat'] = "plugin_zhuzhu_taobao::rewriteoutput('taobao-uatm-cat', 0, '\\1', '\\3')";
		}
		if($zhuzhu_rewrite['taobao-quan']['available']) {
			$_G['setting']['output']['preg']['search']['taobao-quan'] = "/<a href\=\"plugin.php\?id\=zhuzhu_taobao&(amp;)mod\=quan\"([^\>]*)\>/e";
			$_G['setting']['output']['preg']['replace']['taobao-quan'] = "plugin_zhuzhu_taobao::rewriteoutput('taobao-quan', 0)";
		}
		if($zhuzhu_rewrite['taobao-quan-cat']['available']) {
			$_G['setting']['output']['preg']['search']['taobao-quan-cat'] = "/<a href\=\"plugin.php\?id\=zhuzhu_taobao&(amp;)mod\=quan&(amp;)?category_id\=(\d+)\"([^\>]*)\>/e";
			$_G['setting']['output']['preg']['replace']['taobao-quan-cat'] = "plugin_zhuzhu_taobao::rewriteoutput('taobao-quan-cat', 0, '\\1', '\\3')";
		}
		if($zhuzhu_rewrite['taobao-view']['available']) {
			$_G['setting']['output']['preg']['search']['taobao-view'] = "/<a href\=\"plugin.php\?id\=zhuzhu_taobao&(amp;)?mod\=jump_url&(amp;)?num_iid\=(\d+)\"([^\>]*)\>/e";
			$_G['setting']['output']['preg']['replace']['taobao-view'] = "plugin_zhuzhu_taobao::rewriteoutput('taobao-view', 0, '\\1', '\\3')";
		}

	}

	function global_footer(){
		global $_G;

		return '<!-- rewrite_replace -->';
	}

	function rewriteoutput($type, $returntype) {
		global $_G;

		$fextra = '';

		//taobao
		if($type == 'taobao') {
			list(,,, $extra) = func_get_args();
			$r = array();
		}
		if($type == 'taobao-tbk') {
			list(,,, $extra) = func_get_args();
			$r = array();
		}
		if($type == 'taobao-tbk-9k9') {
			list(,,, $extra) = func_get_args();
			$r = array();
		}
		if($type == 'taobao-tbk-cat') {
			list(,,, $cat, $extra) = func_get_args();
			$r = array(
				'{cat}' => $cat ? $cat : 0,
			);
		}
		if($type == 'taobao-tqg') {
			list(,,, $extra) = func_get_args();
			$r = array();
		}
		if($type == 'taobao-view') {
			list(,,, $num_iid, $extra) = func_get_args();
			$r = array(
				'{num_iid}' => $num_iid ? $num_iid : 0,
			);
		}
		if($type == 'taobao-quan') {
			list(,,, $extra) = func_get_args();
			$r = array();
		}
		if($type == 'taobao-quan-cat') {
			list(,,, $category_id, $extra) = func_get_args();
			$r = array(
				'{category_id}' => $category_id ? $category_id : 0,
			);
		}
		if($type == 'taobao-uatm') {
			list(,,, $extra) = func_get_args();
			$r = array();
		}
		if($type == 'taobao-uatm-cat') {
			list(,,, $favorites_id, $extra) = func_get_args();
			$r = array(
				'{favorites_id}' => $favorites_id ? $favorites_id : 0,
			);
		}
		if($type == 'taobao-tbrand-view') {
			list(,,, $brand_id, $extra) = func_get_args();
			$r = array(
				'{brand_id}' => $brand_id ? $brand_id : 0,
			);
		}

		$zhuzhu_rewrite = dunserialize($_G['setting']['zhuzhu_taobao']);
		$href = str_replace(array_keys($r), $r, $zhuzhu_rewrite[$type]['rule']).$fextra;
		if(!$returntype) {
			return '<a href="'.$href.'"'.(!empty($extra) ? stripslashes($extra) : '').'>';
		} else {
			return $href;
		}
	}
}
//WWW.CAOGEN8.CO
?>