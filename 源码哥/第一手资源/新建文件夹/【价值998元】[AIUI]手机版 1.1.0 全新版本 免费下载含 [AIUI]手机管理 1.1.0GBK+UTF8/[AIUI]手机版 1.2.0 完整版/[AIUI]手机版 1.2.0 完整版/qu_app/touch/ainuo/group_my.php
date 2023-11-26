<?php

/**
 *      [Discuz!] (C)2001-2099 Comsenz Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: group_my.php 30630 2012-06-07 07:16:14Z zhengqingpeng $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}


$grouplistmanage = amygrouplist($_G['uid'], 'lastupdate', array('f.name', 'ff.icon'), 30, 0, 1);
$grouplistjiaru = amygrouplist($_G['uid'], 'lastupdate', array('f.name', 'ff.icon'), 30, 0, 2);

function agrouplist($orderby = 'displayorder', $fieldarray = array(), $num = 1, $fids = array(), $sort = 0, $getcount = 0, $grouplevel = array()) {
	$query = C::t('forum_forum')->fetch_all_for_grouplist($orderby, $fieldarray, $num, $fids, $sort, $getcount);
	if($getcount) {
		return $query;
	}
	$grouplist = array();
	foreach($query as $group) {
		$group['iconstatus'] = $group['icon'] ? 1 : 0;
		isset($group['icon']) && $group['icon'] = aget_groupimg($group['icon'], 'icon');
		isset($group['banner']) && $group['banner'] = aget_groupimg($group['banner']);
		$group['orderid'] = $orderid ? intval($orderid) : '';
		isset($group['dateline']) && $group['dateline'] = $group['dateline'] ? dgmdate($group['dateline'], 'd') : '';
		isset($group['lastupdate']) && $group['lastupdate'] = $group['lastupdate'] ? dgmdate($group['lastupdate'], 'd') : '';
		$group['level'] = !empty($grouplevel) ? intval($grouplevel[$group['fid']]) : 0;
		isset($group['description']) && $group['description'] = cutstr($group['description'], 130);
		$grouplist[$group['fid']] = $group;
		$orderid ++;
	}

	return $grouplist;
}

function amygrouplist($uid, $orderby = '', $fieldarray = array(), $num = 0, $start = 0, $ismanager = 0, $count = 0) {
	$uid = intval($uid);
	if(empty($uid)) {
		return array();
	}//Form  ww w.moqu 8.com
	$groupfids = $grouplevel = array();
	$query = C::t('forum_groupuser')->fetch_all_group_for_user($uid, $count, $ismanager, $start, $num);
	if($count == 1) {
		return $query;
	}
	foreach($query as $group) {
		$groupfids[] = $group['fid'];
		$grouplevel[$group['fid']] = $group['level'];
	}
	if(empty($groupfids)) {
		return false;
	}
	$mygrouplist = agrouplist($orderby, $fieldarray, $num, $groupfids, 0, 0, $grouplevel);

	return $mygrouplist;
}

function aget_groupimg($imgname, $imgtype = '') {
	global $_G;
	$imgpath = $_G['setting']['attachurl'].'group/'.$imgname;
	if($imgname) {
		return $imgpath;
	} else {
		if($imgtype == 'icon') {
			return 'static/image/common/groupicon.gif';
		} else {
			return '';
		}
	}
}




?>