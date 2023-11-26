<?php
/**
 *	Version: 1.0
 *	Date: 2013-8-16 22:44
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

$sql = <<<EOF

DROP TABLE IF EXISTS `pre_lev_ckplayer`;
DROP TABLE IF EXISTS `pre_lev_ckplayer_group`;
DROP TABLE IF EXISTS `pre_lev_ckplayer_zj`;
DROP TABLE IF EXISTS `pre_lev_ckplayer_tanmu`;

EOF;

runquery($sql);
$finish = true;
?>