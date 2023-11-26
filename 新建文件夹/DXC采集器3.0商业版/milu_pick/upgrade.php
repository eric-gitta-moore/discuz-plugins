<?php


if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
require_once(DISCUZ_ROOT.'source/plugin/milu_pick/config.inc.php');
$fromversion = $_GET['fromversion'];
if(!$fromversion) return;
$sql = '';
if($fromversion == '2.0'){
	$sql = <<<EOF

alter table cdb_strayer_picker add content_filter_html text NOT NULL;
alter table cdb_strayer_picker add reply_filter_html text NOT NULL;
alter table cdb_strayer_picker add is_auto_public tinyint(1) unsigned NOT NULL;
alter table cdb_strayer_picker add public_reply_seq tinyint(1) unsigned NOT NULL;
alter table cdb_strayer_picker add reply_max_num varchar(100) NOT NULL;
alter table cdb_strayer_picker add is_public_reply tinyint(1) unsigned NOT NULL;
alter table cdb_strayer_picker add is_word_replace tinyint(1) unsigned NOT NULL;
alter table cdb_strayer_picker change is_download_flash is_download_file tinyint(1) unsigned NOT NULL;
alter table cdb_strayer_picker add is_page_public tinyint(1) unsigned NOT NULL;
alter table cdb_strayer_picker change public_uid public_uid varchar(250) NOT NULL;
alter table cdb_strayer_picker add reply_num smallint(5) unsigned NOT NULL;
alter table cdb_strayer_picker add is_public_del tinyint(1) unsigned NOT NULL;
alter table cdb_strayer_picker add reply_uid varchar(250) NOT NULL;
alter table cdb_strayer_picker add login_cookie text NOT NULL;
alter table cdb_strayer_picker add is_login tinyint(1) unsigned NOT NULL;
alter table cdb_strayer_picker add login_test_url varchar(250) NOT NULL;
alter table cdb_strayer_picker add nextrun int(10) unsigned NOT NULL;
alter table cdb_strayer_picker add lastrun int(10) unsigned NOT NULL;
alter table cdb_strayer_picker change cron_day cron_day tinyint(2) unsigned NOT NULL;
alter table cdb_strayer_picker add public_type tinyint(1) unsigned NOT NULL;
alter table cdb_strayer_picker add public_class varchar(250) NOT NULL;
alter table cdb_strayer_article_title add is_bbs tinyint(1) unsigned NOT NULL;
alter table cdb_strayer_article_title add reply_num smallint(5) unsigned NOT NULL;

EOF;

}

if($fromversion != '2.5' && $fromversion != 'vip2.5'){

$sql .= <<<EOF

alter table cdb_strayer_picker add pick_get_type tinyint(1) unsigned NOT NULL;
alter table cdb_strayer_picker add pick_cid smallint(6) unsigned NOT NULL;
alter table cdb_strayer_picker add keyword_flag tinyint(1) unsigned NOT NULL;
alter table cdb_strayer_picker add page_link_fiter tinyint(1) unsigned NOT NULL;
alter table cdb_strayer_picker add public_uid_type tinyint(1) unsigned NOT NULL;
alter table cdb_strayer_picker add reply_uid_type tinyint(1) unsigned NOT NULL;
alter table cdb_strayer_picker add displayorder smallint(1) unsigned NOT NULL;
alter table cdb_strayer_picker add public_time_type tinyint(1) unsigned NOT NULL;
alter table cdb_strayer_picker add dateline_get_type tinyint(1) unsigned NOT NULL;
alter table cdb_strayer_picker add author_get_type tinyint(1) unsigned NOT NULL;
alter table cdb_strayer_picker add from_get_type tinyint(1) unsigned NOT NULL;
alter table cdb_strayer_picker add is_get_other tinyint(1) unsigned NOT NULL;
alter table cdb_strayer_picker add article_public_sort tinyint(1) unsigned NOT NULL;
alter table cdb_strayer_picker add keyword_title text NOT NULL;
alter table cdb_strayer_picker add keyword_title_exclude text NOT NULL;
alter table cdb_strayer_picker add keyword_content text NOT NULL;
alter table cdb_strayer_picker add keyword_content_exclude text NOT NULL;
alter table cdb_strayer_picker add page_link_url_contain text NOT NULL;
alter table cdb_strayer_picker add page_link_url_no_contain text NOT NULL;
alter table cdb_strayer_picker add from_get_rules text NOT NULL;
alter table cdb_strayer_picker add author_get_rules text NOT NULL;
alter table cdb_strayer_picker add dateline_get_rules text NOT NULL;

alter table cdb_strayer_picker add picker_hash char(32) NOT NULL;
alter table cdb_strayer_picker add public_uid_group varchar(255) NOT NULL;
alter table cdb_strayer_picker add reply_uid_group varchar(255) NOT NULL;
alter table cdb_strayer_picker add reply_dateline varchar(25) NOT NULL;

alter table cdb_strayer_picker change page_url_auto_step page_url_auto_step tinyint(1) NOT NULL;

alter table cdb_strayer_article_title add article_dateline int(10) unsigned NOT NULL;

alter table cdb_strayer_rules add is_get_other tinyint(1) unsigned NOT NULL;
alter table cdb_strayer_rules add from_get_type tinyint(1) unsigned NOT NULL;
alter table cdb_strayer_rules add author_get_type tinyint(1) unsigned NOT NULL;
alter table cdb_strayer_rules add dateline_get_type tinyint(1) unsigned NOT NULL;
alter table cdb_strayer_rules add author_get_rules text NOT NULL;
alter table cdb_strayer_rules add from_get_rules text NOT NULL;
alter table cdb_strayer_rules add dateline_get_rules text NOT NULL;
alter table cdb_strayer_rules drop column rule_author;

CREATE TABLE `cdb_strayer_evo_log` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `url` varchar(255) NOT NULL,
  `type` tinyint(1) unsigned NOT NULL,
  `why` tinyint(1) unsigned NOT NULL,
  `dateline` int(10) unsigned NOT NULL,
  `data_id` int(9) unsigned NOT NULL,
  `rules_name` varchar(150) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=gbk;

CREATE TABLE `cdb_strayer_category` (
  `displayorder` smallint(6) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `cid` mediumint(8) unsigned NOT NULL auto_increment,
  PRIMARY KEY  (`cid`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=gbk;

CREATE TABLE `cdb_strayer_evo` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `content_get_type` tinyint(1) NOT NULL,
  `content_rules` text NOT NULL,
  `theme_get_type` text NOT NULL,
  `theme_rules` text NOT NULL,
  `detail_ID` varchar(255) NOT NULL,
  `detail_ID_test` varchar(255) NOT NULL,
  `domain_hash` char(32) NOT NULL,
  `domain` varchar(100) NOT NULL,
  `hit_num` int(10) NOT NULL,
  `status` tinyint(1) unsigned NOT NULL,
  `dateline` int(10) unsigned NOT NULL,
  `evo_text_info` text NOT NULL,
  `evo_title_info` text NOT NULL,
  `detail_ID_hash` char(32) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `domain_hash` USING BTREE (`domain_hash`,`detail_ID_hash`)
) ENGINE=MyISAM AUTO_INCREMENT=1583 DEFAULT CHARSET=gbk;


CREATE TABLE `cdb_strayer_fastpick` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `dateline` int(9) unsigned NOT NULL,
  `rules_type` tinyint(1) unsigned NOT NULL,
  `rules_name` varchar(255) NOT NULL,
  `is_login` tinyint(1) unsigned NOT NULL,
  `login_cookie` text NOT NULL,
  `detail_ID` varchar(255) NOT NULL,
  `theme_url_test` varchar(255) NOT NULL,
  `theme_get_type` tinyint(1) unsigned NOT NULL,
  `theme_rules` text NOT NULL,
  `is_fiter_title` tinyint(1) unsigned NOT NULL,
  `title_replace_rules` text NOT NULL,
  `title_filter_rules` text NOT NULL,
  `content_rules` text NOT NULL,
  `is_fiter_content` tinyint(1) unsigned NOT NULL,
  `content_replace_rules` text NOT NULL,
  `content_filter_html` text NOT NULL,
  `content_filter_rules` text NOT NULL,
  `content_page_get_type` tinyint(1) unsigned NOT NULL,
  `content_page_rules` text NOT NULL,
  `content_page_get_mode` tinyint(1) unsigned NOT NULL,
  `rule_desc` varchar(255) NOT NULL,
  `rules_hash` char(32) NOT NULL,
  `content_get_type` tinyint(1) unsigned NOT NULL,
  `is_get_other` tinyint(1) unsigned NOT NULL,
  `from_get_type` tinyint(1) unsigned NOT NULL,
  `from_get_rules` text NOT NULL,
  `author_get_type` tinyint(1) unsigned NOT NULL,
  `author_get_rules` text NOT NULL,
  `dateline_get_type` tinyint(3) unsigned NOT NULL,
  `dateline_get_rules` text NOT NULL,
  `rule_author` varchar(200) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=17861 DEFAULT CHARSET=gbk;

CREATE TABLE `cdb_strayer_member` (
  `username` char(15) NOT NULL,
  `uid` int(10) unsigned NOT NULL auto_increment,
  `gender` char(8) NOT NULL default '0',
  `birthyear` smallint(6) unsigned NOT NULL,
  `birthmonth` tinyint(3) unsigned NOT NULL,
  `birthday` tinyint(3) unsigned NOT NULL,
  `birthprovince` varchar(255) NOT NULL default '',
  `birthcity` varchar(255) NOT NULL default '',
  `birthdist` varchar(25) NOT NULL default '',
  `birthcommunity` varchar(255) NOT NULL default '',
  `resideprovince` varchar(255) NOT NULL default '',
  `residecity` varchar(255) NOT NULL default '',
  `residedist` varchar(20) NOT NULL default '',
  `residecommunity` varchar(255) NOT NULL default '',
  `residesuite` varchar(255) NOT NULL default '',
  `email` char(40) NOT NULL default '',
  `site` varchar(255) NOT NULL default '',
  `bio` text NOT NULL,
  `zipcode` varchar(255) NOT NULL default '',
  `interest` text NOT NULL,
  `oltime` smallint(6) unsigned NOT NULL,
  `regdate` int(9) unsigned NOT NULL,
  `lastvisit` int(9) unsigned NOT NULL,
  `address` varchar(255) NOT NULL default '',
  `regip` char(15) NOT NULL default '',
  `lastip` char(15) NOT NULL default '',
  `lastactivity` int(10) unsigned NOT NULL default '0',
  `lastpost` int(10) unsigned NOT NULL,
  `sightml` text NOT NULL,
  `idcardtype` varchar(255) NOT NULL default '',
  `idcard` varchar(255) NOT NULL default '',
  `bloodtype` varchar(255) NOT NULL default '',
  `height` varchar(255) NOT NULL,
  `weight` varchar(255) NOT NULL default '',
  `qq` varchar(255) NOT NULL default '',
  `msn` varchar(255) NOT NULL default '',
  `taobao` varchar(255) NOT NULL default '',
  `yahoo` varchar(255) NOT NULL default '',
  `icq` varchar(255) NOT NULL default '',
  `alipay` varchar(255) NOT NULL default '',
  `lookingfor` varchar(255) NOT NULL default '',
  `position` varchar(255) NOT NULL default '',
  `occupation` varchar(255) NOT NULL default '',
  `education` varchar(255) NOT NULL default '',
  `company` varchar(255) NOT NULL default '',
  `graduateschool` varchar(255) NOT NULL default '',
  `revenue` varchar(255) NOT NULL default '',
  `telephone` varchar(255) NOT NULL default '',
  `mobile` varchar(255) NOT NULL default '',
  `constellation` varchar(255) NOT NULL default '',
  `realname` varchar(255) NOT NULL default '',
  `zodiac` varchar(255) NOT NULL,
  `affectivestatus` varchar(255) NOT NULL default '',
  `data_uid` int(10) NOT NULL default '0',
  `get_dateline` int(10) unsigned NOT NULL,
  `get_uid` int(10) unsigned NOT NULL default '0',
  `public_dateline` int(10) unsigned NOT NULL,
  `get_web_url` varchar(255) NOT NULL,
  `extcredits1` int(10) unsigned NOT NULL,
  `extcredits2` int(10) unsigned NOT NULL,
  `extcredits3` int(10) unsigned NOT NULL,
  `extcredits4` int(10) unsigned NOT NULL,
  `extcredits5` int(10) unsigned NOT NULL,
  `extcredits6` int(10) unsigned NOT NULL,
  `extcredits7` int(10) unsigned NOT NULL,
  `extcredits8` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`uid`),
  KEY `get_dateline` USING BTREE (`get_dateline`,`uid`)
) ENGINE=MyISAM AUTO_INCREMENT=75814 DEFAULT CHARSET=gbk;


CREATE TABLE `cdb_strayer_searchindex` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `domain_hash` char(32) NOT NULL,
  `rid` int(9) unsigned NOT NULL,
  `type` tinyint(1) unsigned NOT NULL,
  `dateline` int(10) unsigned NOT NULL,
  `path_hash` char(32) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `domain_hash` (`domain_hash`),
  KEY `type` (`type`)
) ENGINE=MyISAM AUTO_INCREMENT=2898 DEFAULT CHARSET=gbk;


CREATE TABLE `cdb_strayer_setting` (
  `skey` varchar(255) NOT NULL default '',
  `svalue` text NOT NULL,
  PRIMARY KEY  (`skey`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;


CREATE TABLE `cdb_strayer_timing` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `pid` int(10) unsigned NOT NULL,
  `data_id` int(10) unsigned NOT NULL,
  `public_type` tinyint(1) unsigned NOT NULL,
  `public_dateline` int(10) unsigned NOT NULL,
  `public_info` text NOT NULL,
  `content_type` tinyint(1) unsigned NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `aid` USING BTREE (`data_id`,`pid`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=gbk;

EOF;
}
if(GBK){
	$sql = str_replace('DEFAULT CHARSET=gbk','DEFAULT CHARSET=utf8', $sql);
}else{
	$sql = str_replace('DEFAULT CHARSET=utf8','DEFAULT CHARSET=gbk', $sql);
}
$sql = str_replace('pre_strayer', $tablepre.'strayer', $sql);

runquery($sql);

$finish = TRUE;


?>