<?php

/**
 * 魔趣吧.vip  [ 专业开发各种Discuz!插件 ]
 *
 * [魔趣吧!] (C)2014-2017 www.moqu8.com.  By www-魔趣吧-co
 *
 * Support: caogenba@qq.com QQ:1218894030
 *
 * Date: 2013-02-17 16:22:17 moqu8.com $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

//if (checkmobile()) $_GET['mobile'] = 'no';

require_once 'lev_class.php';

global $_G;


$C = new lev_class();//print_r(lev_class::$_G);

$_PLG     = lev_base::$PL_G;
$PLURL    = lev_base::$PLURL;
$PLNAME   = lev_base::$PLNAME;
$PLSTATIC = lev_base::$PLSTATIC;
$uploadurl= lev_base::$uploadurl;

$lm = lev_base::$lm;
$loadjs   = lev_base::$loadjs;
$remote   = lev_base::$remote;

$idxurl   = lev_base::$PLURL;

$lev_lang = lev_base::$lang;

$diydir   = lev_base::$diydir;

$navtitle = $lev_lang['navtitle'] ? $lev_lang['navtitle'] : lev_base::$navtitle;

$_G['setting']['bbname'] = $lev_lang['bbname'] ? $lev_lang['bbname'] : $_G['setting']['bbname'];

$metakeywords = $lev_lang['metakeywords'] ? $lev_lang['metakeywords'] : $metakeywords;

$metadescription = $lev_lang['metadescription'] ? $lev_lang['metadescription'] : $metadescription;



