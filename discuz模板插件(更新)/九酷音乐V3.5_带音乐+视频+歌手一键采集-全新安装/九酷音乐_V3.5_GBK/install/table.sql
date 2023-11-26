
SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

/*数据表 `prefix_admin` 的结构*/

DROP TABLE IF EXISTS `prefix_admin`;

CREATE TABLE `prefix_admin` (
  `CD_ID` int(11) NOT NULL AUTO_INCREMENT,
  `CD_AdminUserName` varchar(64) NOT NULL,
  `CD_AdminPassWord` varchar(64) NOT NULL,
  `CD_LoginIP` varchar(128) DEFAULT NULL,
  `CD_LoginNum` int(11) DEFAULT '0',
  `CD_LastLogin` datetime DEFAULT NULL,
  `CD_IsLock` int(11) NOT NULL DEFAULT '0',
  `CD_Permission` varchar(128) NOT NULL,
  PRIMARY KEY (`CD_ID`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=gbk;

/*数据表 `prefix_menu` 的结构*/

DROP TABLE IF EXISTS `prefix_menu`;

CREATE TABLE `prefix_menu` (
  `cd_id` int(11) NOT NULL AUTO_INCREMENT,
  `cd_name` varchar(100) NOT NULL,
  `cd_url` varchar(255) NOT NULL,
  `cd_order` int(11) NOT NULL,
  PRIMARY KEY (`cd_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=gbk;

/*数据表 `prefix_bill` 的结构*/

DROP TABLE IF EXISTS `prefix_bill`;

CREATE TABLE `prefix_bill` (
  `cd_id` int(11) NOT NULL AUTO_INCREMENT,
  `cd_type` int(11) NOT NULL,
  `cd_uid` int(11) NOT NULL,
  `cd_uname` varchar(50) NOT NULL,
  `cd_icon` varchar(20) NOT NULL,
  `cd_title` text NOT NULL,
  `cd_points` int(11) NOT NULL,
  `cd_state` int(11) NOT NULL,
  `cd_addtime` datetime NOT NULL,
  `cd_endtime` datetime NOT NULL,
  PRIMARY KEY (`cd_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=gbk;

/*数据表 `prefix_blog` 的结构*/

DROP TABLE IF EXISTS `prefix_blog`;

CREATE TABLE `prefix_blog` (
  `cd_id` int(11) NOT NULL AUTO_INCREMENT,
  `cd_uid` int(11) NOT NULL,
  `cd_uname` varchar(50) NOT NULL,
  `cd_uip` varchar(50) DEFAULT NULL,
  `cd_title` varchar(100) DEFAULT NULL,
  `cd_content` text NOT NULL,
  `cd_hits` int(11) NOT NULL,
  `cd_commentnum` int(11) NOT NULL,
  `cd_addtime` int(11) NOT NULL,
  PRIMARY KEY (`cd_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=gbk;

/*数据表 `prefix_class` 的结构*/

DROP TABLE IF EXISTS `prefix_class`;

CREATE TABLE `prefix_class` (
  `CD_ID` int(11) NOT NULL AUTO_INCREMENT,
  `CD_Name` varchar(255) NOT NULL,
  `CD_AliasName` varchar(64) NOT NULL,
  `CD_Template` varchar(64) NOT NULL,
  `CD_FatherID` int(11) NOT NULL DEFAULT '1',
  `CD_SystemID` int(11) NOT NULL DEFAULT '1',
  `CD_TheOrder` int(11) NOT NULL DEFAULT '0',
  `CD_IsHide` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`CD_ID`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=gbk;

/*数据表 `prefix_comment` 的结构*/

DROP TABLE IF EXISTS `prefix_comment`;

CREATE TABLE `prefix_comment` (
  `cd_id` int(11) NOT NULL AUTO_INCREMENT,
  `cd_channel` int(11) NOT NULL,
  `cd_dataid` int(11) NOT NULL,
  `cd_content` text NOT NULL,
  `cd_uid` int(11) NOT NULL,
  `cd_uname` varchar(50) NOT NULL,
  `cd_uip` varchar(255) NOT NULL,
  `cd_addtime` datetime NOT NULL,
  PRIMARY KEY (`cd_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=gbk;

/*数据表 `prefix_dislike` 的结构*/

DROP TABLE IF EXISTS `prefix_dislike`;

CREATE TABLE `prefix_dislike` (
  `cd_id` int(11) NOT NULL AUTO_INCREMENT,
  `cd_uid` int(11) NOT NULL,
  `cd_uname` varchar(20) NOT NULL,
  `cd_musicid` int(11) NOT NULL,
  `cd_musicname` varchar(255) NOT NULL,
  `cd_classid` int(11) NOT NULL,
  `cd_addtime` int(11) NOT NULL,
  PRIMARY KEY (`cd_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=gbk;

/*数据表 `prefix_district` 的结构*/

DROP TABLE IF EXISTS `prefix_district`;

CREATE TABLE `prefix_district` (
  `cd_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `cd_name` varchar(255) NOT NULL DEFAULT '',
  `cd_level` tinyint(4) unsigned NOT NULL DEFAULT '0',
  `cd_usetype` tinyint(1) unsigned NOT NULL DEFAULT '0',
  `cd_upid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `cd_displayorder` smallint(6) NOT NULL DEFAULT '0',
  PRIMARY KEY (`cd_id`),
  KEY `cd_upid` (`cd_upid`,`cd_displayorder`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=gbk;

/*数据表 `prefix_music` 的结构*/

DROP TABLE IF EXISTS `prefix_music`;

CREATE TABLE `prefix_music` (
  `CD_ID` int(11) NOT NULL AUTO_INCREMENT,
  `CD_Name` varchar(255) NOT NULL,
  `CD_ClassID` int(11) NOT NULL,
  `CD_SpecialID` int(11) NOT NULL,
  `CD_SingerID` int(11) NOT NULL,
  `CD_UserID` int(11) DEFAULT NULL,
  `CD_User` varchar(50) DEFAULT NULL,
  `CD_UserNicheng` varchar(50) DEFAULT NULL,
  `CD_Pic` text,
  `CD_Url` text,
  `CD_DownUrl` text,
  `CD_Word` text,
  `CD_Lrc` text,
  `CD_Hits` int(11) NOT NULL,
  `CD_DownHits` int(11) NOT NULL,
  `CD_FavHits` int(11) NOT NULL,
  `CD_DianGeHits` int(11) NOT NULL,
  `CD_GoodHits` int(11) NOT NULL,
  `CD_BadHits` int(11) NOT NULL,
  `CD_AddTime` datetime DEFAULT NULL,
  `CD_Server` int(11) NOT NULL,
  `CD_Deleted` int(11) NOT NULL,
  `CD_IsBest` int(11) NOT NULL,
  `CD_Error` int(11) NOT NULL,
  `CD_Passed` int(11) NOT NULL,
  `CD_Points` int(11) NOT NULL,
  `CD_Grade` int(11) NOT NULL,
  `CD_Color` varchar(20) DEFAULT NULL,
  `CD_Skin` varchar(50) DEFAULT NULL,
  PRIMARY KEY (`CD_ID`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=gbk;

/*数据表 `prefix_down` 的结构*/

DROP TABLE IF EXISTS `prefix_down`;

CREATE TABLE `prefix_down` (
  `cd_id` int(11) NOT NULL AUTO_INCREMENT,
  `cd_uid` int(11) NOT NULL,
  `cd_uname` varchar(20) NOT NULL,
  `cd_musicid` int(11) NOT NULL,
  `cd_musicname` varchar(255) NOT NULL,
  `cd_classid` int(11) NOT NULL,
  `cd_addtime` int(11) NOT NULL,
  PRIMARY KEY (`cd_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=gbk;

/*数据表 `prefix_fans` 的结构*/

DROP TABLE IF EXISTS `prefix_fans`;

CREATE TABLE `prefix_fans` (
  `cd_id` int(11) NOT NULL AUTO_INCREMENT,
  `cd_uid` int(11) NOT NULL,
  `cd_uname` varchar(50) NOT NULL,
  `cd_uids` int(11) NOT NULL,
  `cd_unames` varchar(50) NOT NULL,
  `cd_addtime` datetime NOT NULL,
  PRIMARY KEY (`cd_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=gbk;

/*数据表 `prefix_fav` 的结构*/

DROP TABLE IF EXISTS `prefix_fav`;

CREATE TABLE `prefix_fav` (
  `cd_id` int(11) NOT NULL AUTO_INCREMENT,
  `cd_uid` int(11) NOT NULL,
  `cd_uname` varchar(20) NOT NULL,
  `cd_musicid` int(11) NOT NULL,
  `cd_musicname` varchar(255) NOT NULL,
  `cd_classid` int(11) NOT NULL,
  `cd_addtime` int(11) NOT NULL,
  PRIMARY KEY (`cd_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=gbk;

/*数据表 `prefix_feed` 的结构*/

DROP TABLE IF EXISTS `prefix_feed`;

CREATE TABLE `prefix_feed` (
  `cd_id` int(11) NOT NULL AUTO_INCREMENT,
  `cd_uid` int(11) NOT NULL,
  `cd_uname` varchar(50) DEFAULT NULL,
  `cd_icon` varchar(20) NOT NULL,
  `cd_title` text NOT NULL,
  `cd_data` text NOT NULL,
  `cd_image` varchar(255) DEFAULT NULL,
  `cd_imagelink` varchar(255) DEFAULT NULL,
  `cd_dataid` int(11) NOT NULL,
  `cd_addtime` datetime NOT NULL,
  PRIMARY KEY (`cd_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=gbk;

/*数据表 `prefix_footprints` 的结构*/

DROP TABLE IF EXISTS `prefix_footprints`;

CREATE TABLE `prefix_footprints` (
  `cd_id` int(11) NOT NULL AUTO_INCREMENT,
  `cd_uid` int(11) NOT NULL,
  `cd_uname` varchar(50) NOT NULL,
  `cd_uids` int(11) NOT NULL,
  `cd_unames` varchar(50) NOT NULL,
  `cd_addtime` datetime NOT NULL,
  PRIMARY KEY (`cd_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=gbk;

/*数据表 `prefix_friend` 的结构*/

DROP TABLE IF EXISTS `prefix_friend`;

CREATE TABLE `prefix_friend` (
  `cd_id` int(11) NOT NULL AUTO_INCREMENT,
  `cd_uid` int(11) NOT NULL,
  `cd_uname` varchar(50) NOT NULL,
  `cd_uids` int(11) NOT NULL,
  `cd_unames` varchar(50) NOT NULL,
  `cd_lock` int(11) NOT NULL,
  `cd_note` varchar(100) DEFAULT NULL,
  `cd_group` int(11) NOT NULL,
  `cd_hidden` int(11) NOT NULL,
  `cd_addtime` datetime NOT NULL,
  PRIMARY KEY (`cd_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=gbk;

/*数据表 `prefix_friendgroup` 的结构*/

DROP TABLE IF EXISTS `prefix_friendgroup`;

CREATE TABLE `prefix_friendgroup` (
  `cd_id` int(11) NOT NULL AUTO_INCREMENT,
  `cd_uid` int(11) NOT NULL,
  `cd_name` varchar(50) NOT NULL,
  `cd_count` int(11) NOT NULL,
  PRIMARY KEY (`cd_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=gbk;

/*数据表 `prefix_label` 的结构*/

DROP TABLE IF EXISTS `prefix_label`;

CREATE TABLE `prefix_label` (
  `cd_id` int(11) NOT NULL AUTO_INCREMENT,
  `cd_name` varchar(50) NOT NULL,
  `cd_type` varchar(50) NOT NULL,
  `cd_selflable` text NOT NULL,
  `cd_remark` varchar(150) NOT NULL,
  `cd_priority` int(11) NOT NULL,
  `cd_addtime` datetime NOT NULL,
  PRIMARY KEY (`cd_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=gbk;

/*数据表 `prefix_like` 的结构*/

DROP TABLE IF EXISTS `prefix_like`;

CREATE TABLE `prefix_like` (
  `cd_id` int(11) NOT NULL AUTO_INCREMENT,
  `cd_uid` int(11) NOT NULL,
  `cd_uname` varchar(20) NOT NULL,
  `cd_musicid` int(11) NOT NULL,
  `cd_musicname` varchar(255) NOT NULL,
  `cd_classid` int(11) NOT NULL,
  `cd_addtime` int(11) NOT NULL,
  PRIMARY KEY (`cd_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=gbk;

/*数据表 `prefix_link` 的结构*/

DROP TABLE IF EXISTS `prefix_link`;

CREATE TABLE `prefix_link` (
  `cd_id` int(11) NOT NULL AUTO_INCREMENT,
  `cd_name` varchar(50) NOT NULL,
  `cd_url` text,
  `cd_pic` text,
  `cd_classid` int(11) NOT NULL,
  `cd_input` text,
  `cd_isverify` int(11) NOT NULL,
  `cd_isindex` int(11) NOT NULL,
  `cd_theorder` int(11) NOT NULL,
  PRIMARY KEY (`cd_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=gbk;

/*数据表 `prefix_listen` 的结构*/

DROP TABLE IF EXISTS `prefix_listen`;

CREATE TABLE `prefix_listen` (
  `cd_id` int(11) NOT NULL AUTO_INCREMENT,
  `cd_uid` int(11) NOT NULL,
  `cd_uname` varchar(20) NOT NULL,
  `cd_musicid` int(11) NOT NULL,
  `cd_musicname` varchar(255) NOT NULL,
  `cd_classid` int(11) NOT NULL,
  `cd_addtime` int(11) NOT NULL,
  PRIMARY KEY (`cd_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=gbk;

/*数据表 `prefix_message` 的结构*/

DROP TABLE IF EXISTS `prefix_message`;

CREATE TABLE `prefix_message` (
  `cd_id` int(11) NOT NULL AUTO_INCREMENT,
  `cd_uid` int(11) NOT NULL,
  `cd_uname` varchar(50) NOT NULL,
  `cd_uids` int(11) NOT NULL,
  `cd_unames` varchar(50) NOT NULL,
  `cd_dataid` int(11) NOT NULL,
  `cd_readid` int(11) NOT NULL,
  `cd_content` text NOT NULL,
  `cd_addtime` datetime NOT NULL,
  PRIMARY KEY (`cd_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=gbk;

/*数据表 `prefix_mold` 的结构*/

DROP TABLE IF EXISTS `prefix_mold`;

CREATE TABLE `prefix_mold` (
  `CD_ID` int(11) NOT NULL AUTO_INCREMENT,
  `CD_Name` varchar(255) NOT NULL,
  `CD_TempPath` text NOT NULL,
  `CD_TheOrder` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`CD_ID`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=gbk;

/*数据表 `prefix_video` 的结构*/

DROP TABLE IF EXISTS `prefix_video`;

CREATE TABLE `prefix_video` (
  `CD_ID` int(11) NOT NULL AUTO_INCREMENT,
  `CD_ClassID` int(11) NOT NULL,
  `CD_Name` varchar(255) NOT NULL,
  `CD_User` varchar(50) DEFAULT NULL,
  `CD_Pic` text,
  `CD_SingerID` int(11) NOT NULL,
  `CD_Play` text,
  `CD_Hits` int(11) NOT NULL,
  `CD_IsIndex` int(11) NOT NULL,
  `CD_IsBest` int(11) NOT NULL,
  `CD_Color` varchar(20) DEFAULT NULL,
  `CD_AddTime` datetime NOT NULL,
  PRIMARY KEY (`CD_ID`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=gbk;

/*数据表 `prefix_videoclass` 的结构*/

DROP TABLE IF EXISTS `prefix_videoclass`;

CREATE TABLE `prefix_videoclass` (
  `CD_ID` int(11) NOT NULL AUTO_INCREMENT,
  `CD_Name` varchar(255) NOT NULL,
  `CD_TheOrder` int(11) NOT NULL,
  `CD_IsIndex` int(11) NOT NULL,
  PRIMARY KEY (`CD_ID`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=gbk;

/*数据表 `prefix_notice` 的结构*/

DROP TABLE IF EXISTS `prefix_notice`;

CREATE TABLE `prefix_notice` (
  `cd_id` int(11) NOT NULL AUTO_INCREMENT,
  `cd_uid` int(11) NOT NULL,
  `cd_uname` varchar(50) NOT NULL,
  `cd_uids` int(11) NOT NULL,
  `cd_unames` varchar(50) NOT NULL,
  `cd_icon` varchar(20) NOT NULL,
  `cd_data` text NOT NULL,
  `cd_dataid` int(11) NOT NULL,
  `cd_state` int(11) NOT NULL,
  `cd_addtime` datetime NOT NULL,
  PRIMARY KEY (`cd_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=gbk;

/*数据表 `prefix_page` 的结构*/

DROP TABLE IF EXISTS `prefix_page`;

CREATE TABLE `prefix_page` (
  `cd_id` int(11) NOT NULL AUTO_INCREMENT,
  `cd_name` varchar(50) NOT NULL,
  `cd_type` varchar(50) NOT NULL,
  `cd_html` int(11) NOT NULL,
  `cd_url` varchar(50) NOT NULL,
  `cd_template` varchar(50) NOT NULL,
  PRIMARY KEY (`cd_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=gbk;

/*数据表 `prefix_pay` 的结构*/

DROP TABLE IF EXISTS `prefix_pay`;

CREATE TABLE `prefix_pay` (
  `cd_id` int(11) NOT NULL AUTO_INCREMENT,
  `cd_type` int(11) NOT NULL,
  `cd_name` varchar(50) NOT NULL,
  `cd_points` int(11) NOT NULL,
  `cd_money` int(11) NOT NULL,
  PRIMARY KEY (`cd_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=gbk;

/*数据表 `prefix_paylog` 的结构*/

DROP TABLE IF EXISTS `prefix_paylog`;

CREATE TABLE `prefix_paylog` (
  `cd_id` int(11) NOT NULL AUTO_INCREMENT,
  `cd_type` int(11) NOT NULL,
  `cd_uid` int(11) NOT NULL,
  `cd_uname` varchar(50) DEFAULT NULL,
  `cd_title` varchar(200) NOT NULL,
  `cd_points` int(11) NOT NULL,
  `cd_money` int(11) NOT NULL,
  `cd_lock` int(11) NOT NULL,
  `cd_dataid` int(11) NOT NULL,
  `cd_addtime` int(11) NOT NULL,
  PRIMARY KEY (`cd_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=gbk;

/*数据表 `prefix_pic` 的结构*/

DROP TABLE IF EXISTS `prefix_pic`;

CREATE TABLE `prefix_pic` (
  `cd_id` int(11) NOT NULL AUTO_INCREMENT,
  `cd_uid` int(11) NOT NULL,
  `cd_uname` varchar(50) NOT NULL,
  `cd_uip` varchar(50) DEFAULT NULL,
  `cd_title` varchar(100) DEFAULT NULL,
  `cd_url` varchar(200) NOT NULL,
  `cd_hits` int(11) NOT NULL,
  `cd_praisenum` int(11) NOT NULL,
  `cd_replynum` int(11) NOT NULL,
  `cd_theorder` int(11) NOT NULL,
  `cd_weborder` int(11) NOT NULL,
  `cd_width` int(11) NOT NULL,
  `cd_height` int(11) NOT NULL,
  `cd_addtime` int(11) NOT NULL,
  PRIMARY KEY (`cd_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=gbk;

/*数据表 `prefix_pic_like` 的结构*/

DROP TABLE IF EXISTS `prefix_pic_like`;

CREATE TABLE `prefix_pic_like` (
  `cd_id` int(11) NOT NULL AUTO_INCREMENT,
  `cd_uid` int(11) NOT NULL,
  `cd_uname` varchar(20) NOT NULL,
  `cd_dataid` int(11) NOT NULL,
  `cd_addtime` int(11) NOT NULL,
  PRIMARY KEY (`cd_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=gbk;

/*数据表 `prefix_server` 的结构*/

DROP TABLE IF EXISTS `prefix_server`;

CREATE TABLE `prefix_server` (
  `CD_ID` int(11) NOT NULL AUTO_INCREMENT,
  `CD_Name` varchar(100) NOT NULL,
  `CD_Url` varchar(255) NOT NULL,
  `CD_DownUrl` varchar(255) DEFAULT NULL,
  `CD_Yes` int(11) NOT NULL,
  PRIMARY KEY (`CD_ID`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=gbk;

/*数据表 `prefix_session` 的结构*/

DROP TABLE IF EXISTS `prefix_session`;

CREATE TABLE `prefix_session` (
  `cd_id` int(11) NOT NULL AUTO_INCREMENT,
  `cd_uid` int(11) NOT NULL,
  `cd_uname` varchar(30) NOT NULL,
  `cd_uip` varchar(50) NOT NULL,
  `cd_logintime` int(11) NOT NULL,
  PRIMARY KEY (`cd_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=gbk;

/*数据表 `prefix_setting` 的结构*/

DROP TABLE IF EXISTS `prefix_setting`;

CREATE TABLE `prefix_setting` (
  `cd_key` varchar(255) NOT NULL DEFAULT '',
  `cd_value` text NOT NULL,
  PRIMARY KEY (`cd_key`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

/*数据表 `prefix_special` 的结构*/

DROP TABLE IF EXISTS `prefix_special`;

CREATE TABLE `prefix_special` (
  `CD_ID` int(11) NOT NULL AUTO_INCREMENT,
  `CD_ClassID` int(11) NOT NULL,
  `CD_Name` varchar(255) DEFAULT NULL,
  `CD_User` varchar(50) DEFAULT NULL,
  `CD_Pic` text,
  `CD_SingerID` int(11) NOT NULL,
  `CD_GongSi` varchar(50) DEFAULT NULL,
  `CD_YuYan` varchar(50) DEFAULT NULL,
  `CD_Intro` text,
  `CD_Hits` int(11) NOT NULL,
  `CD_IsBest` int(11) NOT NULL,
  `CD_Passed` int(11) NOT NULL,
  `CD_AddTime` datetime NOT NULL,
  PRIMARY KEY (`CD_ID`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=gbk;

/*数据表 `prefix_upload` 的结构*/

DROP TABLE IF EXISTS `prefix_upload`;

CREATE TABLE `prefix_upload` (
  `cd_id` int(11) NOT NULL AUTO_INCREMENT,
  `cd_userid` int(11) NOT NULL,
  `cd_username` varchar(30) NOT NULL,
  `cd_userip` varchar(50) NOT NULL,
  `cd_filetype` varchar(10) NOT NULL,
  `cd_filename` varchar(200) NOT NULL,
  `cd_filesize` int(11) NOT NULL,
  `cd_fileurl` varchar(200) NOT NULL,
  `cd_filetime` int(11) NOT NULL,
  PRIMARY KEY (`cd_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=gbk;

/*数据表 `prefix_user` 的结构*/

DROP TABLE IF EXISTS `prefix_user`;

CREATE TABLE `prefix_user` (
  `cd_id` int(11) NOT NULL AUTO_INCREMENT,
  `cd_name` varchar(30) NOT NULL,
  `cd_nicheng` varchar(30) DEFAULT NULL,
  `cd_password` varchar(50) NOT NULL,
  `cd_question` varchar(50) DEFAULT NULL,
  `cd_answer` varchar(50) DEFAULT NULL,
  `cd_email` varchar(100) DEFAULT NULL,
  `cd_sex` varchar(10) DEFAULT NULL,
  `cd_regdate` datetime NOT NULL,
  `cd_loginip` varchar(30) DEFAULT NULL,
  `cd_loginnum` int(11) NOT NULL,
  `cd_qq` varchar(15) DEFAULT NULL,
  `cd_logintime` datetime DEFAULT NULL,
  `cd_grade` int(11) NOT NULL,
  `cd_lock` int(11) NOT NULL,
  `cd_points` int(11) NOT NULL,
  `cd_birthday` varchar(20) DEFAULT NULL,
  `cd_vipindate` datetime DEFAULT NULL,
  `cd_vipenddate` datetime DEFAULT NULL,
  `cd_hits` int(11) NOT NULL,
  `cd_isbest` int(11) NOT NULL,
  `cd_money` int(11) DEFAULT NULL,
  `cd_friendnum` int(11) NOT NULL,
  `cd_rank` int(11) NOT NULL,
  `cd_uhits` int(11) NOT NULL,
  `cd_weekhits` int(11) NOT NULL,
  `cd_musicnum` int(11) NOT NULL,
  `cd_fansnum` int(11) NOT NULL,
  `cd_idolnum` int(11) NOT NULL,
  `cd_favnum` int(11) NOT NULL,
  `cd_address` varchar(100) DEFAULT NULL,
  `cd_qqprivacy` int(11) NOT NULL,
  `cd_introduce` text,
  `cd_groupnum` int(11) NOT NULL,
  `cd_checkmm` int(11) NOT NULL,
  `cd_checkmusic` int(11) NOT NULL,
  `cd_review` int(11) NOT NULL,
  `cd_sign` int(11) NOT NULL,
  `cd_signcumu` int(11) NOT NULL,
  `cd_signtime` datetime DEFAULT NULL,
  `cd_ucenter` int(11) NOT NULL,
  `cd_skinid` int(11) NOT NULL,
  `cd_vipgrade` int(11) NOT NULL,
  `cd_viprank` int(11) NOT NULL,
  `cd_verified` varchar(100) DEFAULT NULL,
  `cd_ulevel` int(11) NOT NULL,
  `cd_qqopen` varchar(255) DEFAULT NULL,
  `cd_qqimg` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`cd_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=gbk;

/*数据表 `prefix_wall` 的结构*/

DROP TABLE IF EXISTS `prefix_wall`;

CREATE TABLE `prefix_wall` (
  `cd_id` int(11) NOT NULL AUTO_INCREMENT,
  `cd_wallid` int(11) NOT NULL,
  `cd_dataid` int(11) NOT NULL,
  `cd_content` text NOT NULL,
  `cd_uid` int(11) NOT NULL,
  `cd_uname` varchar(50) NOT NULL,
  `cd_uip` varchar(255) NOT NULL,
  `cd_addtime` datetime NOT NULL,
  PRIMARY KEY (`cd_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=gbk;

/*数据表 `prefix_skin` 的结构*/

DROP TABLE IF EXISTS `prefix_skin`;

CREATE TABLE `prefix_skin` (
  `cd_id` int(11) NOT NULL AUTO_INCREMENT,
  `cd_classid` int(11) NOT NULL,
  `cd_name` varchar(50) NOT NULL,
  `cd_path` varchar(50) NOT NULL,
  `cd_points` int(11) NOT NULL,
  `cd_hits` int(11) NOT NULL,
  `cd_addtime` int(11) NOT NULL,
  PRIMARY KEY (`cd_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=gbk;

/*数据表 `prefix_skin_class` 的结构*/

DROP TABLE IF EXISTS `prefix_skin_class`;

CREATE TABLE `prefix_skin_class` (
  `cd_id` int(11) NOT NULL AUTO_INCREMENT,
  `cd_name` varchar(20) NOT NULL,
  PRIMARY KEY (`cd_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=gbk;

/*数据表 `prefix_slot` 的结构*/

DROP TABLE IF EXISTS `prefix_slot`;

CREATE TABLE `prefix_slot` (
  `cd_id` int(11) NOT NULL AUTO_INCREMENT,
  `cd_uid` int(11) NOT NULL,
  `cd_uname` varchar(50) NOT NULL,
  `cd_points` int(11) NOT NULL,
  `cd_number` int(11) NOT NULL,
  `cd_addtime` datetime NOT NULL,
  PRIMARY KEY (`cd_id`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=gbk;

/*数据表 `prefix_singer` 的结构*/

DROP TABLE IF EXISTS `prefix_singer`;

CREATE TABLE `prefix_singer` (
  `CD_ID` int(11) NOT NULL AUTO_INCREMENT,
  `CD_Name` varchar(255) DEFAULT NULL,
  `CD_User` varchar(50) DEFAULT NULL,
  `CD_Pic` text,
  `CD_Area` varchar(50) DEFAULT NULL,
  `CD_Intro` text,
  `CD_Hits` int(11) NOT NULL,
  `CD_IsBest` int(11) NOT NULL,
  `CD_Passed` int(11) NOT NULL,
  `CD_AddTime` datetime NOT NULL,
  PRIMARY KEY (`CD_ID`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=gbk;

/*数据表 `prefix_plugin` 的结构*/

DROP TABLE IF EXISTS `prefix_plugin`;

CREATE TABLE `prefix_plugin` (
  `CD_ID` int(11) NOT NULL AUTO_INCREMENT,
  `CD_Name` varchar(255) NOT NULL,
  `CD_Dir` text,
  `CD_File` text,
  `CD_IsIndex` int(11) NOT NULL,
  `CD_Author` varchar(50) DEFAULT NULL,
  `CD_Address` varchar(50) DEFAULT NULL,
  `CD_AddTime` datetime NOT NULL,
  PRIMARY KEY (`CD_ID`)
) ENGINE=MyISAM AUTO_INCREMENT=1 DEFAULT CHARSET=gbk;
