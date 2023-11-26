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
$langs = $scriptlang[$pidentifier];
$rightlink='<div style="float:right;font-size:12px;">';
$rightlink.='<a href="'.ADMINSCRIPT.'?action=plugins&operation=config&act='.$pidentifier.'&do=upgrading&identifier='.$pidentifier.'&pmod=admincp">'.$langs['add'.$pidentifier].'</a>';
$rightlink.='|<a href="http://www.fx8.cc/" target="_blank">'.$langs['sanree'].'</a></div>';
?>