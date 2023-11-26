<?php
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

$sql = <<<EOF
DROP TABLE IF EXISTS `cdb_zhikai_topic`;
EOF;
runquery($sql);

$finish = TRUE;
?>