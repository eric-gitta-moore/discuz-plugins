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
$newcount = C::t('#sanree_brand_goods#sanree_brand_goods')->count_by_where(' AND status<>1');
$langs = $scriptlang['sanree_brand_'.CURMODE_SANREE_GOODS];
$rightlink='<div style="float:right;font-size:12px;">';
$rightlink.='<a href="'.ADMINSCRIPT.'?action=plugins&operation=config&act='.CURMODE_SANREE_GOODS.'&do=businessesaudit&identifier=sanree_brand_'.CURMODE_SANREE_GOODS.'&pmod=admincp">'.$langs[CURMODE_SANREE_GOODS.'new'].'('.$newcount.')</a>';
$rightlink.='|<a href="'.ADMINSCRIPT.'?action=plugins&operation=config&act='.CURMODE_SANREE_GOODS.'&do=upgrading&identifier=sanree_brand_'.CURMODE_SANREE_GOODS.'&pmod=admincp">'.$langs['add'.CURMODE_SANREE_GOODS].'</a>';
$rightlink.='|<a href="plugin.php?id=sanree_brand_'.CURMODE_SANREE_GOODS.'" target="_blank">'.$langs['manage_nav_pluginshow_'.CURMODE_SANREE_GOODS].'</a>';
$rightlink.='|<a href="http://www.fx8.cc/" target="_blank">'.$langs['sanree'].'</a></div>';
?>