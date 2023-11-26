<?php

if(!defined('IN_ADMINCP')) {
	exit('Access Denied');
}

//start to put your own code 
$sql = <<<EOF
DROP TABLE IF  EXISTS `pre_aljdm_type`;
EOF;
runquery($sql);
//finish to put your own code
@unlink(DISCUZ_ROOT.'./data/sysdata/cache_aljdm.php');
$finish = TRUE;

?>