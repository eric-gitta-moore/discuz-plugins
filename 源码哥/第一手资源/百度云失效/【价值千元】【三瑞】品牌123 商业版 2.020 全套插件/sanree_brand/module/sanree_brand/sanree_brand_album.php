<?php

/**
 *      [fx8.cc] (C)2014-2017 ymg6.Com.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: sanree_brand_album.php sanree $
 */

if(!defined('IN_DISCUZ')) {
	exit('');
}

$bid = intval($_G['sr_bid']);

if ($isalbum!=1) {
	ajaxexit('');
}

$brandresult = C::t('#sanree_brand#sanree_brand_businesses')->getbusinesses_by_bid($bid);
if (!$brandresult) {
	ajaxexit('');
}
if ($brandresult[allowalbum]!=1) {
	ajaxexit('');
}
$brandresult[albumurl] = getalbumurl($brandresult[bid]);
$where =array();
$where[] = 'uid='.$brandresult['uid'];
$where[] = 'bid='.$bid;
$albumcat =  C::t('#sanree_brand#sanree_brand_album_category')->fetch_all_by_searchd($where, 'displayorder,dateline DESC');
$bids = array();
foreach($albumcat as $data) {

	$bids[] = $data[catid];
	
}
$maxpic = $maxishomepic;
$albumlist = array();
for($i = 0; $i < $maxpic; $i++) {

	$albumlist[$i]['pic'] = 'source/plugin/sanree_brand/tpl/good/images/nophoto.gif';
	$albumlist[$i]['thumbpic'] = 'source/plugin/sanree_brand/tpl/good/images/nophoto.gif';
	$albumlist[$i]['albumname'] = srlang('no_pic');
	
}
$aids="''";

if ($bids) {

	$where = "AND catid in(".implode($bids,",").") AND ishome=1";
	$albumdata =  C::t('#sanree_brand#sanree_brand_album')->fetch_all_by_searchex($where, 'ishome desc,displayorder,albumid desc', 0, $maxpic);
	include_once libfile('function/home');
	$aids='[';
	$tmparray=array();	
	foreach($albumdata as $key => $album) {
	
		$album['thumbpic'] = ($isalbumthumb==1) ? sr_albumimage($album['pic'], 165, 165) : pic_cover_get($album['pic'], 1);	
		$album['pic'] = pic_cover_get($album['pic'], 1);
		$albumlist[$key] = $album;
		$tmparray []= "'$album[albumid]'";
		
	}
	$aids .=implode($tmparray,",");
	$aids .=']';	
	
}

include templateEx($plugin['identifier'].':'.$template.'/album');
?>