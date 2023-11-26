<?php
/*
	Install Uninstall Upgrade AutoStat System Code
*/
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
//start to put your own code 
$sql = <<<EOF
CREATE TABLE IF NOT EXISTS `pre_aljdm_type` (
  `id` mediumint(9) unsigned NOT NULL AUTO_INCREMENT,
  `upid` mediumint(9) unsigned NOT NULL,
  `subid` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `displayorder` char(50) NOT NULL,
  `bindlink` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
);
EOF;
runquery($sql);
//finish to put your own code
$finish = TRUE;
?>