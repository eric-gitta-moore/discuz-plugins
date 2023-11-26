<?php

/**
 *      [fx8.cc] (C)2014-2017 ymg6.Com.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: sanree_brand_district.php sanree $
 */

if(!defined('IN_DISCUZ')) {
	exit('');
}
$container = $_G['sr_container'];
$showlevel = intval($_G['sr_level']);
$showlevel = $showlevel >= 1 && $showlevel <= 4 ? $showlevel : 4;
$values = array(intval($_G['sr_pid']), intval($_G['sr_cid']), intval($_G['sr_did']), intval($_G['sr_coid']));
$containertype = in_array($_G['sr_containertype'], array('birth', 'reside'), true) ? $_G['sr_containertype'] : 'birth';
$level = 1;
if($values[0]) {
	$level++;
} else if($_G['uid'] && !empty($_G['sr_showdefault'])) {

	space_merge($_G['member'], 'profile');
	$district = array();
	if($containertype == 'birth') {
		if(!empty($_G['member']['birthprovince'])) {
			$district[] = $_G['member']['birthprovince'];
			if(!empty($_G['member']['birthcity'])) {
				$district[] = $_G['member']['birthcity'];
			}
			if(!empty($_G['member']['birthdist'])) {
				$district[] = $_G['member']['birthdist'];
			}
			if(!empty($_G['member']['birthcommunity'])) {
				$district[] = $_G['member']['birthcommunity'];
			}
		}
	} else {
		if(!empty($_G['member']['resideprovince'])) {
			$district[] = $_G['member']['resideprovince'];
			if(!empty($_G['member']['residecity'])) {
				$district[] = $_G['member']['residecity'];
			}
			if(!empty($_G['member']['residedist'])) {
				$district[] = $_G['member']['residedist'];
			}
			if(!empty($_G['member']['residecommunity'])) {
				$district[] = $_G['member']['residecommunity'];
			}
		}
	}
	if(!empty($district)) {
		foreach(C::t('#sanree_brand#sanree_brand_district')->fetch_all_by_name($district) as $value) {
			$key = $value['level'] - 1;
			$values[$key] = $value['id'];
		}
		$level++;
	}
}
if($values[1]) {
	$level++;
}
if($values[2]) {
	$level++;
}
if($values[3]) {
	$level++;
}
$showlevel = $level;
$elems = array('srbirthprovince', 'srbirthcity', 'srbirthdist', 'srbirthcommunity');
$districthtml = srshowdistrict($values, $elems, $container, $showlevel, $containertype);
include templateEx($plugin['identifier'].':'.$template.'/district');
?>