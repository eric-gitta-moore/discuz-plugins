<?php

/**
 *      [Discuz!] (C)2001-2099 Comsenz Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: misc_swfupload.php 18303 2010-11-18 09:56:38Z zhengqingpeng $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
$_G['sr_type'] = 'image';
if($_G['sr_operation'] == 'config') {

	$swfhash = md5(substr(md5($_G['config']['security']['authkey']), 8).$_G['uid']);
	$xmllang = lang('forum/swfupload');
	$imageexts = array('jpg','jpeg','gif','png','bmp');
	$extendtype = '';
	$_G['group']['attachextensions'] = '*.'.implode(',*.', $imageexts);
	$depict = 'Image File ';
	$max = 0;
	if(!empty($_G['group']['maxattachsize'])) {
		$max = intval($_G['group']['maxattachsize']);
	} else {
		$max = @ini_get(upload_max_filesize);
		$unit = strtolower(substr($max, -1, 1));
		if($unit == 'k') {
			$max = intval($max)*1024;
		} elseif($unit == 'm') {
			$max = intval($max)*1024*1024;
		} elseif($unit == 'g') {
			$max = intval($max)*1024*1024*1024;
		}
	}
	@header("Expires: -1");
	@header("Cache-Control: no-store, private, post-check=0, pre-check=0, max-age=0", FALSE);
	@header("Pragma: no-cache");
	@header("Content-type: application/xml; charset=utf-8");
	echo "<?xml version=\"1.0\" encoding=\"utf-8\"?><parameter><allowsExtend>".(!empty($_G['group']['attachextensions']) ? "<extend depict=\"$depict\">{$_G[group][attachextensions]}</extend>" : '')."</allowsExtend><language>$xmllang</language><config><userid>$_G[uid]</userid><hash>$swfhash</hash><maxupload>{$max}</maxupload>".(!empty($extendtype) ? "<limitType>$extendtype</limitType>" : "")."</config></parameter>";
    exit();
} elseif($_G['sr_operation'] == 'upload') {

	$catid = intval($_G['sr_fid']);
	$bid = intval($_G['sr_bid']);
	$_G['uid'] = intval($_G['sr_uid']);	
	if ($catid<1) {
		uploadmsg(1);
	}
	$albumcategory = C::t('#sanree_brand#sanree_brand_album_category')->userget_by_catid($catid, $_G['uid']);
	if (!$albumcategory) {
		uploadmsg(4);
	}
	$searchtext = ' AND uid='.$_G['uid'].' AND catid='.$catid;
	$count = C::t('#sanree_brand#sanree_brand_album')->count_by_where($searchtext);
	$maxalbum = getmaxalbumbycatid($catid,$_G['uid']);	
	if ($count >= $maxalbum) {
		uploadmsg(2);
	} else  {
		
		$picdata = array();
		if($_FILES['Filedata']) {
			if ($_FILES['Filedata']['error']==0){
				if ($albumfilesize > 0) {
					if($_FILES['Filedata']['size'] > $albumfilesize * 1024) {
						uploadmsg(5);
					}						
				}			
				 $picdata = mypic_save($_FILES['Filedata'], $albumid);
			}
		}	
		if (empty($picdata['filepath'])) {
			uploadmsg(3);
		}
		$setarr['pic'] = $picdata['filepath'];
		$setarr['albumname'] = empty($albumname) ? $picdata['filename'] : $albumname;
		$setarr['albumname'] = srfixfilename($setarr['albumname']);
		$setarr['catid'] = $catid;
		$setarr['depict'] = dhtmlspecialchars(trim($_G['sr_depict']));
		$setarr['displayorder'] = intval(trim($_G['sr_displayorder']));
		$setarr['dateline'] = TIMESTAMP;
		$setarr['uid'] = $_G['uid'];
		$setarr['bid'] = $bid;
		$setarr['username'] = $_G['username'];				
		$aid = C::t('#sanree_brand#sanree_brand_album')->insert($setarr, TRUE);
		fixalbumpic($catid, $setarr);
		uploadmsg(0, $aid);
		
	}
}
function uploadmsg($statusid, $aid=0) {
	global $_G;
	echo $statusid ? 'error' : $aid;
	exit;
}

function srfixfilename($str) {
	if (CHARSET=='utf-8') {
		return $str;
	}
	return iconv('UTF-8', 'GB2312', $str);
}
//From:www_YMG6_COM
?>