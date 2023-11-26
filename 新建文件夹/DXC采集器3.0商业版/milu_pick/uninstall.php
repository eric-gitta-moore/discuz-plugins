<?php

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}

$sql = <<<EOF
DROP TABLE IF EXISTS `cdb_strayer_evo_log`, `cdb_strayer_article_content`, `cdb_strayer_article_title`, `cdb_strayer_category`, `cdb_strayer_evo`, `cdb_strayer_fastpick`, `cdb_strayer_member`, `cdb_strayer_picker`, `cdb_strayer_rules`, `cdb_strayer_searchindex`, `cdb_strayer_setting`, `cdb_strayer_timing`, `cdb_strayer_url`;
EOF;
runquery($sql);

$finish = TRUE;
?>