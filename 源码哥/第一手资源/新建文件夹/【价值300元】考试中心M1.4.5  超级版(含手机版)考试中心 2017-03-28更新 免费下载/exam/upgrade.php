<?php
/*
 *源码哥：www.ymg6.com
 *更多商业插件/模版免费下载 就在源码哥
 *本资源来源于网络收集,仅供个人学习交流，请勿用于商业用途，并于下载24小时后删除!
 *如果侵犯了您的权益,请及时告知我们,我们即刻删除!
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

include "install.php";
$ver = $_GET['fromversion'];
 
if($ver < 'M1.2.1')
{
//M1.1.7
@mysql_query("ALTER TABLE ".DB::table('tiny_exam3_paper')." ADD COLUMN `long` int(10) unsigned NOT NULL DEFAULT '0';");
@mysql_query("ALTER TABLE ".DB::table('tiny_exam3_paper')." ADD COLUMN `readgroup` varchar(255) NOT NULL DEFAULT '';");
@mysql_query("ALTER TABLE ".DB::table('tiny_exam3_group')." CHANGE `num_max` `num_max` MEDIUMINT(3) DEFAULT NULL;");
@DB::query("UPDATE ".DB::table('tiny_exam3_group')." SET `num_max`=null where `num_max`='0'");	
 
//M1.2.1
$sql = <<<EOF
	ALTER TABLE `pre_tiny_exam3_paper` CHANGE `pwd` `pwd` VARCHAR(6) CHARSET gbk COLLATE gbk_chinese_ci DEFAULT '' NOT NULL;

	DROP TABLE IF EXISTS `pre_tiny_exam3_wrong`;
 
	CREATE TABLE IF NOT EXISTS `pre_tiny_exam3_wrong` (
	  `wid` int(10) unsigned NOT NULL AUTO_INCREMENT,
	  `eid` int(10) unsigned NOT NULL DEFAULT '0',
	  `uid` int(8) unsigned NOT NULL DEFAULT '0',
	  `pid` int(8) unsigned NOT NULL DEFAULT '0',
	  `cid` mediumint(8) unsigned NOT NULL DEFAULT '0',
	  `status` tinyint(1) unsigned NOT NULL DEFAULT '0',
	  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
	  `tid` mediumint(10) unsigned NOT NULL DEFAULT '0',
	  `type` tinyint(1) NOT NULL DEFAULT '0',
	  `sys_result` varchar(255) NOT NULL DEFAULT '',
	  `user_result` varchar(255) NOT NULL DEFAULT '',
	  PRIMARY KEY (`wid`)
	) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=gbk;
	

	DROP TABLE IF EXISTS `pre_tiny_exam3_log`;
	
	CREATE TABLE IF NOT EXISTS `pre_tiny_exam3_log` (
	  `lid` int(10) unsigned NOT NULL AUTO_INCREMENT,
	  `uid` int(8) unsigned NOT NULL DEFAULT '0',
	  `pid` int(8) unsigned NOT NULL DEFAULT '0',
	  `cid` mediumint(8) unsigned NOT NULL DEFAULT '0',
	  `score` decimal(4,1) unsigned NOT NULL DEFAULT '0.0',
	  `starttime` int(10) unsigned NOT NULL DEFAULT '0',
	  `endtime` int(10) unsigned NOT NULL DEFAULT '0',
	  `status` tinyint(1) unsigned NOT NULL DEFAULT '0',
	  `commenttime` int(10) unsigned NOT NULL DEFAULT '0',
	  `total` decimal(5,1) NOT NULL DEFAULT '0.0',
	  `comment` varchar(255) NOT NULL DEFAULT '',
	  PRIMARY KEY (`lid`,`uid`,`pid`)
	) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=gbk;


	DROP TABLE IF EXISTS `pre_tiny_exam3_log_exam`;
	
	CREATE TABLE IF NOT EXISTS `pre_tiny_exam3_log_exam` (
	  `leid` int(10) unsigned NOT NULL AUTO_INCREMENT,
	  `eid` int(10) unsigned NOT NULL DEFAULT '0',
	  `lid` int(10) unsigned NOT NULL DEFAULT '0',
	  `uid` int(8) unsigned NOT NULL DEFAULT '0',
	  `pid` int(8) unsigned NOT NULL DEFAULT '0',
	  `cid` mediumint(8) unsigned NOT NULL DEFAULT '0',
	  `type` tinyint(1) unsigned NOT NULL DEFAULT '0',
	  `result` varchar(255) NOT NULL DEFAULT '',
	  `addtime` int(10) unsigned NOT NULL DEFAULT '0',
	  `status` tinyint(1) NOT NULL DEFAULT '0',
	  `score` decimal(3,1) unsigned DEFAULT NULL,
	  `score2` decimal(3,1) unsigned DEFAULT NULL,
	  PRIMARY KEY (`leid`)
	) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=gbk;
EOF;
runquery($sql);	

@DB::query("UPDATE ".DB::table('tiny_exam3_paper')." SET `pwd`='' where `pwd`='0'");	
}

if($ver < 'M1.2.3')
{
	@mysql_query("ALTER TABLE ".DB::table('tiny_exam3_exam')." DROP COLUMN `time`;"); 
}

if($ver < 'M1.2.8')
{
	@mysql_query("ALTER TABLE ".DB::table('tiny_exam3_group')." ADD COLUMN `assoc` varchar(255) NOT NULL DEFAULT '';");
}


if($ver < 'M1.3.0')
{
	@mysql_query("ALTER TABLE ".DB::table('tiny_exam3_log_exam')." DROP PRIMARY KEY, ADD PRIMARY KEY (`leid`);");
}



if($ver < 'M1.3.4')
{
	@mysql_query("ALTER TABLE ".DB::table('tiny_exam3_wrong')." DROP COLUMN `subject`;"); 
	@mysql_query("ALTER TABLE ".DB::table('tiny_exam3_log')."  DROP COLUMN `title`;"); 
}
 

if($ver < 'M1.3.5')
{
	@mysql_query("ALTER TABLE ".DB::table('tiny_exam3_log')." ADD COLUMN `userinfo` varchar(255) NOT NULL DEFAULT '';");
}
 
$finish = true;