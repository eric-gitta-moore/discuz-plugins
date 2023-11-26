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
define('APPP',$plugin['identifier']);
define('CURURL',ADMINSCRIPT.'?action=plugins&operation=config&identifier='.APPP.'&pmod=admincp');
define('CURURL_1','action=plugins&operation=config&identifier='.APPP.'&pmod=admincp');
define('CURURL_2','plugins&operation=config&identifier='.APPP.'&pmod=admincp');
define('APPC',DISCUZ_ROOT.'./source/plugin/sanree_brand/condition/');
$modfile = APPC.'index.php';
@require_once($modfile);
$newcount = C::t('#sanree_brand_domain#sanree_brand_domain')->count_by_where(' AND status<>1');
$langs = $scriptlang['sanree_brand_'.$pidentifier];
$rightlink='<div style="float:right;font-size:12px;">';
$rightlink.='<a style="color:red" href="'.ADMINSCRIPT.'?action=plugins&operation=config&act=list&do=audit&identifier=sanree_brand_domain&pmod=admincp">'.$langs['domainnew'].'('.$newcount.')</a>';
$rightlink.='|<a href="'.ADMINSCRIPT.'?action=plugins&operation=config&act=brand2domain&do=upgrading&identifier=sanree_brand_'.$pidentifier.'&pmod=admincp">'.$langs['addbrand2domain'].'</a>';
$rightlink.='|<a href="'.ADMINSCRIPT.'?action=plugins&operation=config&act=list&do=upgrading&identifier=sanree_brand_'.$pidentifier.'&pmod=admincp">'.$langs['add'.$pidentifier].'</a>';
$rightlink.='|<a href="http://www.fx8.cc/" target="_blank">'.$langs['sanree'].'</a></div>';
?>