<?php

/**
 *      [Caogen8!] (C)2014-2018 Www.Caogen8.co.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: uninstall.php 37712 2017-12-10 19:32:26Z ²Ý-¸ù-°É $
 */

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}

@unlink('./data/sysdata/cache_zhuzhu_taobao_category.php');
@unlink('./data/sysdata/cache_zhuzhu_taobao_cat.php');
@unlink('./data/sysdata/cache_zhuzhu_taobao_brand.php');

$sql = <<<EOF
DROP TABLE IF EXISTS `pre_zhuzhu_taobao_brand`;
DROP TABLE IF EXISTS `pre_zhuzhu_taobao_cat`;
DROP TABLE IF EXISTS `pre_zhuzhu_taobao_category`;
EOF;

C::t('common_setting')->update('zhuzhu_seo', '');
updatecache('setting');

runquery($sql);

$finish = TRUE;