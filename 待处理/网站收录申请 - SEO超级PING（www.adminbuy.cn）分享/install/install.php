<?php

if(!defined('IN_ADMINCP')) {
	exit('Access Denied');
}

$sql = <<<EOF
CREATE TABLE IF NOT EXISTS `pre_study_seo_ping` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `tid` mediumint(8) unsigned NOT NULL default '0',
  `uid` mediumint(8) NOT NULL default '0',
  `baidu` tinyint(1) unsigned NOT NULL default '0',
  `google` tinyint(1) unsigned NOT NULL default '0',
  `threadurl` varchar(255) NOT NULL,
  `dateline` int(10) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM;
CREATE TABLE IF NOT EXISTS `pre_study_seo_ping_article` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `aid` mediumint(8) unsigned NOT NULL default '0',
  `uid` mediumint(8) NOT NULL default '0',
  `baidu` tinyint(1) unsigned NOT NULL default '0',
  `google` tinyint(1) unsigned NOT NULL default '0',
  `threadurl` varchar(255) NOT NULL,
  `dateline` int(10) NOT NULL default '0',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM;
EOF;
runquery($sql);

		$columns = array();
		$query = DB::query("SHOW COLUMNS FROM ".DB::table('study_seo_ping'));
		while($temp = DB::fetch($query)) {
			$columns[] = $temp['Field'];
		}
		
		//3.0.0
		if(!in_array('uid', $columns)){
			DB::query("ALTER TABLE ".DB::table('study_seo_ping')." ADD `uid` mediumint(8) NOT NULL default '0' AFTER `tid`");
		}
		if(!in_array('dateline', $columns)){
			DB::query("ALTER TABLE ".DB::table('study_seo_ping')." ADD `dateline` int(10) NOT NULL default '0'");
		}

		$finish = TRUE;

?>