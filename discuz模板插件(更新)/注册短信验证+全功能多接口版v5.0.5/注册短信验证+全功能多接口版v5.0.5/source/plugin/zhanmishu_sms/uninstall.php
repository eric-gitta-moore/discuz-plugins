<?php

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}


$sql = <<<EOF
DROP TABLE  IF EXISTS pre_zhanmishu_sms;
DROP TABLE  IF EXISTS pre_zhanmishu_template;
DROP TABLE  IF EXISTS pre_zhanmishu_notice;
DROP TABLE  IF EXISTS pre_zhanmishu_tsetting;
DROP TABLE  IF EXISTS pre_zhanmishu_var;
EOF;
runquery($sql);

$finish = TRUE;
?>