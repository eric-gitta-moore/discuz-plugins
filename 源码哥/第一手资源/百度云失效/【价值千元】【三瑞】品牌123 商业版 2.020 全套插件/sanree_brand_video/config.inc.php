<?php

/**
 *      [fx8.cc] (C)2014-2017 ymg6.Com.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: config.inc.php sanree $
 */

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
define('APPC',DISCUZ_ROOT.'./source/plugin/sanree_brand/condition/');
$modfile = APPC.'index.php';
@require_once($modfile);
$newcount = C::t('#sanree_brand_video#sanree_brand_video')->count_by_where(' AND status<>1');
$langs = $scriptlang['sanree_brand_'.$pidentifier];
$rightlink='<div style="float:right;font-size:12px;">';
$rightlink.='<a href="'.ADMINSCRIPT.'?action=plugins&operation=config&act='.$pidentifier.'&do=businessesaudit&identifier=sanree_brand_'.$pidentifier.'&pmod=admincp">'.$langs[$pidentifier.'new'].'('.$newcount.')</a>';
$rightlink.='|<a href="'.ADMINSCRIPT.'?action=plugins&operation=config&act='.$pidentifier.'&do=upgrading&identifier=sanree_brand_'.$pidentifier.'&pmod=admincp">'.$langs['add'.$pidentifier].'</a>';
$rightlink.='|<a href="plugin.php?id=sanree_brand" target="_blank">'.$langs['manage_nav_pluginshow'].'</a>';
$rightlink.='|<a href="http://www.fx8.cc/" target="_blank">'.$langs['sanree'].'</a></div>';
?>