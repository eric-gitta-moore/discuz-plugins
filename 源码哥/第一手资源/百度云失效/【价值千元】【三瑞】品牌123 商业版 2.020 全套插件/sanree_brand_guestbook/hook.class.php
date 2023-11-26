<?php

/**
 *      [Sanree] (C)2012-2099 Sanree Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: hook.class.php $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
define('APPP_BRAND_GUESTBOOK','sanree_brand_guestbook');
define('APPC',DISCUZ_ROOT.'./source/plugin/sanree_brand/condition/');
define('SANREE_BRAND_GUESTBOOK_APPH',DISCUZ_ROOT.'./source/plugin/'.APPP_BRAND_GUESTBOOK.'/hook/');
$modfile = APPC.'index.php';
@require_once($modfile);
$modfile = SANREE_BRAND_GUESTBOOK_APPH.'index.php';
@require_once($modfile);
?>