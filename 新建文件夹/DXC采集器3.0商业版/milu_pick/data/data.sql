SET FOREIGN_KEY_CHECKS=0;
-- ----------------------------
-- Table structure for `pre_strayer_evo_log`
-- ----------------------------
DROP TABLE IF EXISTS `pre_strayer_evo_log`;
CREATE TABLE `pre_strayer_evo_log` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `url` varchar(255) NOT NULL,
  `type` tinyint(1) unsigned NOT NULL,
  `why` tinyint(1) unsigned NOT NULL,
  `dateline` int(10) unsigned NOT NULL,
  `data_id` int(9) unsigned NOT NULL,
  `rules_name` varchar(150) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=19 DEFAULT CHARSET=gbk;

-- ----------------------------
-- Records of pre_strayer_evo_log
-- ----------------------------

-- ----------------------------
-- Table structure for `pre_strayer_article_content`
-- ----------------------------
DROP TABLE IF EXISTS `pre_strayer_article_content`;
CREATE TABLE `pre_strayer_article_content` (
  `cid` mediumint(8) unsigned NOT NULL auto_increment,
  `aid` mediumint(8) unsigned NOT NULL default '0',
  `content` text NOT NULL,
  `pageorder` smallint(6) unsigned NOT NULL default '0',
  `dateline` int(10) unsigned NOT NULL default '0',
  PRIMARY KEY  (`cid`),
  KEY `aid` (`aid`,`pageorder`),
  KEY `pageorder` (`pageorder`)
) ENGINE=MyISAM AUTO_INCREMENT=109950 DEFAULT CHARSET=gbk;

-- ----------------------------
-- Records of pre_strayer_article_content
-- ----------------------------

-- ----------------------------
-- Table structure for `pre_strayer_article_title`
-- ----------------------------
DROP TABLE IF EXISTS `pre_strayer_article_title`;
CREATE TABLE `pre_strayer_article_title` (
  `is_bbs` tinyint(1) unsigned NOT NULL,
  `username` char(15) NOT NULL,
  `public_time` int(10) unsigned NOT NULL,
  `forum_typeid` mediumint(8) unsigned NOT NULL,
  `forum_fid` mediumint(8) unsigned NOT NULL,
  `blog_small_cid` mediumint(8) unsigned NOT NULL,
  `blog_big_cid` mediumint(8) unsigned NOT NULL,
  `portal_cid` mediumint(8) unsigned NOT NULL,
  `view_num` mediumint(8) unsigned NOT NULL,
  `from` varchar(255) NOT NULL,
  `fromurl` varchar(255) NOT NULL,
  `forum_id` mediumint(8) unsigned NOT NULL,
  `blog_id` mediumint(8) unsigned NOT NULL,
  `portal_id` mediumint(8) unsigned NOT NULL,
  `raids` text NOT NULL,
  `uid` mediumint(8) unsigned NOT NULL,
  `status` tinyint(1) unsigned NOT NULL,
  `author` varchar(100) NOT NULL,
  `is_water_img` tinyint(1) NOT NULL,
  `article_tag` varchar(255) NOT NULL,
  `tag` tinyint(8) unsigned NOT NULL,
  `summary` varchar(255) NOT NULL,
  `is_download_img` tinyint(1) unsigned NOT NULL,
  `pid` int(10) unsigned NOT NULL,
  `pic` tinyint(1) unsigned NOT NULL,
  `url_hash` char(32) NOT NULL,
  `url` varchar(255) NOT NULL,
  `last_modify` int(10) unsigned NOT NULL,
  `dateline` int(10) unsigned NOT NULL,
  `contents` smallint(6) unsigned NOT NULL,
  `title` varchar(255) NOT NULL,
  `reply_num` smallint(5) unsigned NOT NULL,
  `aid` int(12) unsigned NOT NULL auto_increment,
  `article_dateline` int(10) unsigned NOT NULL,
  `public_pid` text NOT NULL,
  PRIMARY KEY  (`aid`)
) ENGINE=MyISAM AUTO_INCREMENT=32257 DEFAULT CHARSET=gbk;

-- ----------------------------
-- Records of pre_strayer_article_title
-- ----------------------------

-- ----------------------------
-- Table structure for `pre_strayer_category`
-- ----------------------------
DROP TABLE IF EXISTS `pre_strayer_category`;
CREATE TABLE `pre_strayer_category` (
  `displayorder` smallint(6) unsigned NOT NULL,
  `name` varchar(255) NOT NULL,
  `cid` mediumint(8) unsigned NOT NULL auto_increment,
  PRIMARY KEY  (`cid`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=gbk;

-- ----------------------------
-- Records of pre_strayer_category
-- ----------------------------

-- ----------------------------
-- Table structure for `pre_strayer_evo`
-- ----------------------------
DROP TABLE IF EXISTS `pre_strayer_evo`;
CREATE TABLE `pre_strayer_evo` (
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

-- ----------------------------
-- Records of pre_strayer_evo
-- ----------------------------

-- ----------------------------
-- Table structure for `pre_strayer_fastpick`
-- ----------------------------
DROP TABLE IF EXISTS `pre_strayer_fastpick`;
CREATE TABLE `pre_strayer_fastpick` (
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

-- ----------------------------
-- Records of pre_strayer_fastpick
-- ----------------------------

-- ----------------------------
-- Table structure for `pre_strayer_member`
-- ----------------------------
DROP TABLE IF EXISTS `pre_strayer_member`;
CREATE TABLE `pre_strayer_member` (
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

-- ----------------------------
-- Records of pre_strayer_member
-- ----------------------------

-- ----------------------------
-- Table structure for `pre_strayer_picker`
-- ----------------------------
DROP TABLE IF EXISTS `pre_strayer_picker`;
CREATE TABLE `pre_strayer_picker` (
  `pid` int(10) unsigned NOT NULL auto_increment,
  `pick_cid` smallint(6) unsigned NOT NULL,
  `public_class` varchar(250) NOT NULL,
  `public_type` tinyint(1) unsigned NOT NULL,
  `lastrun` int(10) unsigned NOT NULL,
  `nextrun` int(10) unsigned NOT NULL,
  `login_test_url` varchar(250) NOT NULL,
  `login_cookie` text NOT NULL,
  `is_login` tinyint(1) unsigned NOT NULL,
  `is_public_del` tinyint(1) unsigned NOT NULL,
  `is_page_public` tinyint(1) unsigned NOT NULL,
  `reply_uid` varchar(250) NOT NULL,
  `public_reply_seq` tinyint(1) NOT NULL,
  `is_public_reply` tinyint(1) unsigned NOT NULL,
  `reply_max_num` varchar(100) NOT NULL,
  `article_min_len` smallint(6) unsigned NOT NULL,
  `run_times` smallint(5) unsigned NOT NULL,
  `only_in_domain` tinyint(1) unsigned NOT NULL,
  `max_redirs` tinyint(1) unsigned NOT NULL,
  `reply_get_type` tinyint(1) unsigned NOT NULL,
  `time_out` tinyint(1) unsigned NOT NULL,
  `cron_minute` char(36) NOT NULL,
  `cron_hour` tinyint(2) NOT NULL,
  `cron_day` tinyint(2) NOT NULL,
  `cron_weekday` tinyint(1) NOT NULL,
  `page_url_auto` tinyint(1) unsigned NOT NULL,
  `is_auto_public` tinyint(1) unsigned NOT NULL,
  `content_page_get_mode` tinyint(1) unsigned NOT NULL,
  `content_page_get_type` tinyint(1) unsigned NOT NULL,
  `public_start_time` int(10) NOT NULL,
  `public_end_time` int(10) NOT NULL,
  `reply_filter_rules` text NOT NULL,
  `content_filter_rules` text NOT NULL,
  `title_filter_rules` text NOT NULL,
  `rss_url` text NOT NULL,
  `reply_filter_html` text NOT NULL,
  `content_filter_html` text NOT NULL,
  `many_page_list` text NOT NULL,
  `manyou_max_level` tinyint(1) unsigned NOT NULL,
  `manyou_start_url` varchar(250) NOT NULL,
  `rules_type` tinyint(1) unsigned NOT NULL,
  `rules_hash` char(32) NOT NULL,
  `rules_var` text NOT NULL,
  `is_download_file` tinyint(1) NOT NULL,
  `auto_del_ad` tinyint(1) NOT NULL,
  `is_auto_pick` tinyint(1) NOT NULL,
  `jump_num` tinyint(5) unsigned NOT NULL,
  `public_uid` varchar(250) NOT NULL,
  `reply_fiter_replace` text NOT NULL,
  `is_fiter_reply` tinyint(1) NOT NULL,
  `page_link_rules` text NOT NULL,
  `page_get_type` tinyint(1) NOT NULL,
  `page_fiter` tinyint(1) NOT NULL,
  `page_url_other` text NOT NULL,
  `dateline` int(10) unsigned NOT NULL,
  `url_range_type` tinyint(1) NOT NULL,
  `reply_is_extend` tinyint(1) unsigned NOT NULL,
  `page_url_auto_step` tinyint(5) NOT NULL default '1',
  `rules_match_url` varchar(250) NOT NULL,
  `name` varchar(50) NOT NULL,
  `view_num` char(20) NOT NULL,
  `url_page_range` varchar(250) NOT NULL,
  `theme_get_type` tinyint(1) NOT NULL,
  `content_page_rules` text NOT NULL,
  `page_url_auto_start` mediumint(8) NOT NULL,
  `reply_replace_rules` text NOT NULL,
  `title_replace_rules` text NOT NULL,
  `page_url_auto_end` mediumint(8) NOT NULL,
  `many_list_start_url` varchar(250) NOT NULL,
  `page_url_no_contain` text NOT NULL,
  `page_url_contain` text NOT NULL,
  `pick_num` smallint(6) unsigned NOT NULL,
  `is_download_img` tinyint(1) NOT NULL,
  `is_water_img` tinyint(1) NOT NULL,
  `page_url_no_other` text NOT NULL,
  `theme_url_test` text NOT NULL,
  `page_url_test` varchar(250) NOT NULL,
  `content_get_type` tinyint(1) NOT NULL,
  `keyword_title` text NOT NULL,
  `theme_rules` text NOT NULL,
  `content_is_page` tinyint(1) NOT NULL,
  `keyword_flag` tinyint(1) unsigned NOT NULL,
  `keyword_title_exclude` text NOT NULL,
  `keyword_content` text NOT NULL,
  `page_link_fiter` tinyint(1) unsigned NOT NULL,
  `page_link_url_contain` text NOT NULL,
  `page_link_url_no_contain` text NOT NULL,
  `keyword_content_exclude` text NOT NULL,
  `public_uid_type` tinyint(1) unsigned NOT NULL,
  `public_uid_group` varchar(255) NOT NULL,
  `reply_uid_type` tinyint(1) unsigned NOT NULL,
  `reply_uid_group` varchar(255) NOT NULL,
  `is_fiter_title` tinyint(1) unsigned NOT NULL,
  `content_rules` text NOT NULL,
  `is_fiter_content` tinyint(1) unsigned NOT NULL,
  `content_replace_rules` text NOT NULL,
  `reply_rules` text NOT NULL,
  `is_word_replace` tinyint(1) unsigned NOT NULL,
  `stop_time` char(15) NOT NULL,
  `displayorder` smallint(6) unsigned NOT NULL,
  `picker_hash` char(32) NOT NULL,
  `article_public_sort` tinyint(1) unsigned NOT NULL,
  `is_get_other` tinyint(1) unsigned NOT NULL,
  `from_get_type` tinyint(1) unsigned NOT NULL,
  `from_get_rules` text NOT NULL,
  `author_get_type` tinyint(1) unsigned NOT NULL,
  `author_get_rules` text NOT NULL,
  `dateline_get_type` tinyint(1) unsigned NOT NULL,
  `dateline_get_rules` text NOT NULL,
  `public_time_type` tinyint(3) unsigned NOT NULL,
  `reply_dateline` varchar(25) NOT NULL,
  PRIMARY KEY  (`pid`)
) ENGINE=MyISAM AUTO_INCREMENT=93 DEFAULT CHARSET=gbk;

-- ----------------------------
-- Records of pre_strayer_picker
-- ----------------------------

-- ----------------------------
-- Table structure for `pre_strayer_rules`
-- ----------------------------
DROP TABLE IF EXISTS `pre_strayer_rules`;
CREATE TABLE `pre_strayer_rules` (
  `reply_get_type` tinyint(1) unsigned NOT NULL,
  `dateline` int(10) unsigned NOT NULL,
  `content_page_get_type` tinyint(1) unsigned NOT NULL,
  `content_page_get_mode` tinyint(1) unsigned NOT NULL,
  `content_page_rules` text NOT NULL,
  `is_fiter_reply` tinyint(1) unsigned NOT NULL,
  `content_get_type` tinyint(1) unsigned NOT NULL,
  `rules_name` varchar(80) NOT NULL,
  `page_url_test` varchar(250) NOT NULL,
  `reply_page_link_rules` varchar(250) NOT NULL,
  `content_rules` text NOT NULL,
  `reply_replace_rules` text NOT NULL,
  `rule_desc` varchar(250) NOT NULL,
  `filter_rules` varchar(250) NOT NULL,
  `page_get_type` tinyint(4) NOT NULL,
  `reply_filter_rules` text NOT NULL,
  `list_ID` varchar(250) NOT NULL,
  `list_ID_test` varchar(250) NOT NULL,
  `url_var` text NOT NULL,
  `detail_ID_test` varchar(250) NOT NULL,
  `detail_ID` varchar(250) NOT NULL,
  `reply_rules` varchar(250) NOT NULL,
  `theme_get_type` tinyint(1) NOT NULL,
  `page_link_rules` text NOT NULL,
  `is_fiter_content` tinyint(1) NOT NULL,
  `reply_is_extend` tinyint(1) NOT NULL,
  `is_fiter_title` tinyint(1) NOT NULL,
  `title_replace_rules` text NOT NULL,
  `content_filter_rules` text NOT NULL,
  `title_filter_rules` text NOT NULL,
  `content_replace_rules` text NOT NULL,
  `theme_rules` varchar(250) NOT NULL,
  `reply_page_url_test` varchar(250) NOT NULL,
  `theme_url_test` varchar(250) NOT NULL,
  `page_url` varchar(250) NOT NULL,
  `rules_type` tinyint(1) unsigned NOT NULL,
  `rules_hash` char(32) NOT NULL,
  `rid` int(10) unsigned NOT NULL auto_increment,
  `is_get_other` tinyint(1) unsigned NOT NULL,
  `from_get_type` tinyint(1) unsigned NOT NULL,
  `author_get_type` tinyint(1) unsigned NOT NULL,
  `from_get_rules` text NOT NULL,
  `dateline_get_type` tinyint(1) unsigned NOT NULL,
  `author_get_rules` text NOT NULL,
  `dateline_get_rules` text NOT NULL,
  `rule_author` varchar(200) NOT NULL,
  PRIMARY KEY  (`rid`)
) ENGINE=MyISAM AUTO_INCREMENT=65 DEFAULT CHARSET=gbk;

-- ----------------------------
-- Records of pre_strayer_rules
-- ----------------------------

-- ----------------------------
-- Table structure for `pre_strayer_searchindex`
-- ----------------------------
DROP TABLE IF EXISTS `pre_strayer_searchindex`;
CREATE TABLE `pre_strayer_searchindex` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `domain_hash` char(32) NOT NULL,
  `rid` int(9) unsigned NOT NULL,
  `type` tinyint(1) unsigned NOT NULL,
  `dateline` int(10) unsigned NOT NULL,
  `path_hash` char(32) NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `domain_hash` (`domain_hash`),
  KEY `type` (`type`)
) ENGINE=MyISAM AUTO_INCREMENT=2902 DEFAULT CHARSET=gbk;

-- ----------------------------
-- Records of pre_strayer_searchindex
-- ----------------------------

-- ----------------------------
-- Table structure for `pre_strayer_setting`
-- ----------------------------
DROP TABLE IF EXISTS `pre_strayer_setting`;
CREATE TABLE `pre_strayer_setting` (
  `skey` varchar(255) NOT NULL default '',
  `svalue` text NOT NULL,
  PRIMARY KEY  (`skey`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

-- ----------------------------
-- Records of pre_strayer_setting
-- ----------------------------
INSERT INTO `pre_strayer_setting` VALUES ('url', 'http://www.discuz.net/');
INSERT INTO `pre_strayer_setting` VALUES ('uid_range', '122645,2861762');
INSERT INTO `pre_strayer_setting` VALUES ('is_login', '2');
INSERT INTO `pre_strayer_setting` VALUES ('login_cookie', '');
INSERT INTO `pre_strayer_setting` VALUES ('num', '1000');
INSERT INTO `pre_strayer_setting` VALUES ('member_field', 'N;');
INSERT INTO `pre_strayer_setting` VALUES ('jump_num', '50');
INSERT INTO `pre_strayer_setting` VALUES ('username_chinese', '2');
INSERT INTO `pre_strayer_setting` VALUES ('reg_pwd', 'dfG56#$fg');
INSERT INTO `pre_strayer_setting` VALUES ('reg_num', '1000');
INSERT INTO `pre_strayer_setting` VALUES ('reg_jump_num', '500');
INSERT INTO `pre_strayer_setting` VALUES ('regdate_type', '1');
INSERT INTO `pre_strayer_setting` VALUES ('regdate_start_time', '');
INSERT INTO `pre_strayer_setting` VALUES ('public_end_time', '');
INSERT INTO `pre_strayer_setting` VALUES ('lastvisit_type', '1');
INSERT INTO `pre_strayer_setting` VALUES ('public_start_time', '');
INSERT INTO `pre_strayer_setting` VALUES ('lastactivity_type', '1');
INSERT INTO `pre_strayer_setting` VALUES ('lastactivity_start_time', '');
INSERT INTO `pre_strayer_setting` VALUES ('lastactivity_end_time', '');
INSERT INTO `pre_strayer_setting` VALUES ('regip', '');
INSERT INTO `pre_strayer_setting` VALUES ('oltime', '0,5');
INSERT INTO `pre_strayer_setting` VALUES ('extcredits1_type', '2');
INSERT INTO `pre_strayer_setting` VALUES ('extcredits1', '1,10');
INSERT INTO `pre_strayer_setting` VALUES ('extcredits2_type', '2');
INSERT INTO `pre_strayer_setting` VALUES ('extcredits2', '1,10');
INSERT INTO `pre_strayer_setting` VALUES ('extcredits3_type', '2');
INSERT INTO `pre_strayer_setting` VALUES ('extcredits3', '1,10');
INSERT INTO `pre_strayer_setting` VALUES ('avata_jump_num', '50');
INSERT INTO `pre_strayer_setting` VALUES ('set_type', '1');
INSERT INTO `pre_strayer_setting` VALUES ('oltime_type', '2');
INSERT INTO `pre_strayer_setting` VALUES ('avatar_user_set', '28069,28169');
INSERT INTO `pre_strayer_setting` VALUES ('avatar_setting_member', '1');
INSERT INTO `pre_strayer_setting` VALUES ('rand_ip', '202.106.189.3,202.106.189.4,202.106.189.6,218.247.166.82,218.30.119.114,218.30.119.114 4408,218.64.220.220,218.64.220.2,219.148.122.113,219.232.236.116,221.225.1.239,222.188.10.1,222.223.65.3,222.73.26.211,58.211.0.113,58.214.238.238,202.105.55.38,221.179.35.71,222.64.185.148,114.255.171.231,125.77.200.134');
INSERT INTO `pre_strayer_setting` VALUES ('public_groupid', 'N;');
INSERT INTO `pre_strayer_setting` VALUES ('avatar_web_url', 'http://uc.discuz.net/');
INSERT INTO `pre_strayer_setting` VALUES ('avata_from_uid', '1560705');
INSERT INTO `pre_strayer_setting` VALUES ('cover_avatar', '1');
INSERT INTO `pre_strayer_setting` VALUES ('regdate_end_time', '');
INSERT INTO `pre_strayer_setting` VALUES ('ip_type', '1');
INSERT INTO `pre_strayer_setting` VALUES ('push_title_header', '');
INSERT INTO `pre_strayer_setting` VALUES ('push_title_footer', '');
INSERT INTO `pre_strayer_setting` VALUES ('push_content_header', '');
INSERT INTO `pre_strayer_setting` VALUES ('push_content_body', '');
INSERT INTO `pre_strayer_setting` VALUES ('push_content_footer', '');
INSERT INTO `pre_strayer_setting` VALUES ('push_reply_header', '');
INSERT INTO `pre_strayer_setting` VALUES ('push_reply_body', '');
INSERT INTO `pre_strayer_setting` VALUES ('push_reply_footer', '');
INSERT INTO `pre_strayer_setting` VALUES ('vir_open', '1');
INSERT INTO `pre_strayer_setting` VALUES ('vir_online_member_count', '20');
INSERT INTO `pre_strayer_setting` VALUES ('vir_online_guest_count', '60,80');
INSERT INTO `pre_strayer_setting` VALUES ('vir_data_bei', '3.5');
INSERT INTO `pre_strayer_setting` VALUES ('online_data_from', '1');
INSERT INTO `pre_strayer_setting` VALUES ('online_data_user_set', '23423|435634');
INSERT INTO `pre_strayer_setting` VALUES ('vir_must_online', '');
INSERT INTO `pre_strayer_setting` VALUES ('vir_data_forum', '');
INSERT INTO `pre_strayer_setting` VALUES ('vir_data_usergroup', 'a:3:{i:0;s:2:\"10\";i:1;s:2:\"11\";i:2;s:2:\"12\";}');
INSERT INTO `pre_strayer_setting` VALUES ('vir_cache_time', '10');
INSERT INTO `pre_strayer_setting` VALUES ('fp_open', '2');
INSERT INTO `pre_strayer_setting` VALUES ('fp_cloud_open', '1');
INSERT INTO `pre_strayer_setting` VALUES ('fp_usergroup', '');
INSERT INTO `pre_strayer_setting` VALUES ('fp_forum', '');
INSERT INTO `pre_strayer_setting` VALUES ('fp_article_from', '2');
INSERT INTO `pre_strayer_setting` VALUES ('fp_seo_open', '2');
INSERT INTO `pre_strayer_setting` VALUES ('fp_word_replace_open', '2');
INSERT INTO `pre_strayer_setting` VALUES ('fp_open_auto', '1');
INSERT INTO `pre_strayer_setting` VALUES ('0', '1');
INSERT INTO `pre_strayer_setting` VALUES ('fp_open_evo', '1');
INSERT INTO `pre_strayer_setting` VALUES ('push_open_bbshide', '2');
INSERT INTO `pre_strayer_setting` VALUES ('article_batch_num', '15');
INSERT INTO `pre_strayer_setting` VALUES ('fp_open_mod', 'a:2:{i:0;s:1:\"1\";i:1;s:1:\"2\";}');
INSERT INTO `pre_strayer_setting` VALUES ('login_test_url', 'http://www.discuz.net/home.php?mod=space&uid=1575902&do=profile');
INSERT INTO `pre_strayer_setting` VALUES ('clear_log', '1352975540');
INSERT INTO `pre_strayer_setting` VALUES ('clear_search_index', '1353580516');
INSERT INTO `pre_strayer_setting` VALUES ('pick_clear_cache', '1353852310');
INSERT INTO `pre_strayer_setting` VALUES ('open_seo', '1');
INSERT INTO `pre_strayer_setting` VALUES ('open_seo_mod', 'a:3:{i:0;s:1:\"1\";i:1;s:1:\"2\";i:2;s:1:\"3\";}');

-- ----------------------------
-- Table structure for `pre_strayer_timing`
-- ----------------------------
DROP TABLE IF EXISTS `pre_strayer_timing`;
CREATE TABLE `pre_strayer_timing` (
  `id` int(10) unsigned NOT NULL auto_increment,
  `pid` int(10) unsigned NOT NULL,
  `data_id` int(10) unsigned NOT NULL,
  `public_type` tinyint(1) unsigned NOT NULL,
  `public_dateline` int(10) unsigned NOT NULL,
  `public_info` text NOT NULL,
  `content_type` tinyint(1) unsigned NOT NULL,
  PRIMARY KEY  (`id`),
  KEY `aid` USING BTREE (`data_id`,`pid`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=gbk;

-- ----------------------------
-- Records of pre_strayer_timing
-- ----------------------------

-- ----------------------------
-- Table structure for `pre_strayer_url`
-- ----------------------------
DROP TABLE IF EXISTS `pre_strayer_url`;
CREATE TABLE `pre_strayer_url` (
  `pid` mediumint(10) unsigned NOT NULL,
  `dateline` int(10) NOT NULL,
  `host` varchar(50) NOT NULL,
  `hash` char(32) NOT NULL,
  `uid` int(12) unsigned NOT NULL auto_increment,
  PRIMARY KEY  (`uid`),
  KEY `hash` (`hash`)
) ENGINE=MyISAM AUTO_INCREMENT=1192675 DEFAULT CHARSET=gbk;

-- ----------------------------
-- Records of pre_strayer_url
-- ----------------------------
