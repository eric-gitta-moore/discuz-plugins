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
define('APPP_BRAND_DOMAIN','sanree_brand_domain');
define('APPC',DISCUZ_ROOT.'./source/plugin/sanree_brand/condition/');
define('APPP_BRAND_DOMAIN_APPH',DISCUZ_ROOT.'./source/plugin/'.APPP_BRAND_DOMAIN.'/hook/');
$modfile = APPC.'index.php';
@require_once($modfile);
$modfile = APPP_BRAND_DOMAIN_APPH.'index.php';
@require_once($modfile);

?>