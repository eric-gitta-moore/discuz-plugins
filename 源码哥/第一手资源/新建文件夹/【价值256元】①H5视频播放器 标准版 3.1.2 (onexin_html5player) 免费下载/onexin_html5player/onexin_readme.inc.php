<?php
/**
 * Open Cloud Collection For Discuz!X 2.0+
 * ============================================================================
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和使用；
 * 不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * @package    onexin_occ
 * @module	   readme 
 * @date	   2017-06-23
 * @author	   King
 * @copyright  Copyright (c) 2017 Onexin Platform Inc. (http://www.onexin.com)
 */

/*
//--------------Tall us what you think!----------------------------------
*/

//
if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}

if(!empty($plugin['identifier'])){
	$url = 'http://onexin.onexin.com/showcase/?charset='.CHARSET.'&identifier='.$plugin['identifier'];
	echo dfsockopen($url);exit;
}

$url = 'http://addon.discuz.com/?@onexin';
dheader("location: ".$url);	