<?php


if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
  exit('Access Denied');
}

$field = C::t('#zhanmishu_sms#zhanmishu_sms')->fetch_all_field();
$table = DB::table('zhanmishu_sms');
$sql = '';
//is is verify ,  2 is editverify 3is edit second
if (!$field['status']) {
  $sql .= "ALTER TABLE $table ADD `status` smallint(3) NOT NULL DEFAULT '0';\n";
}
if (!$field['nationcode']) {
	$sql .= "ALTER TABLE $table ADD `nationcode` varchar(6) NOT NULL;\n";
}
if (!$field['isverify']) {
  $sql .= "ALTER TABLE $table ADD `isverify` smallint(3) NOT NULL DEFAULT '0';\n";
}
if (!$field['isaddextcredit']) {
  $sql .= "ALTER TABLE $table ADD `isaddextcredit` smallint(3) NOT NULL DEFAULT '0';\n";
}
if (!$field['ismobilereg']) {
	$sql .= "ALTER TABLE $table ADD `ismobilereg` smallint(3) NOT NULL DEFAULT '0';\n";
}
if (!$field['isregsuccess']) {
	$sql .= "ALTER TABLE $table ADD `isregsuccess` smallint(3) NOT NULL DEFAULT '0';\n";
}
if (!$field['ischangepwd']) {
  $sql .= "ALTER TABLE $table ADD `ischangepwd` smallint(3) NOT NULL DEFAULT '0';\n";
}
if (!$field['isblack']) {
  $sql .= "ALTER TABLE $table ADD `isblack` tinyint(1) NOT NULL DEFAULT '0';\n";
}

if (!$field['mts']) {
  $sql .= "ALTER TABLE $table ADD `mts` int(6) unsigned NOT NULL DEFAULT '0';\n";
  $sql .= "ALTER TABLE $table ADD `province` varchar(20) NOT NULL DEFAULT '';\n";
  $sql .= "ALTER TABLE $table ADD `catname` varchar(20) NOT NULL DEFAULT '';\n";
  $sql .= "ALTER TABLE $table ADD `telstring` varchar(20) NOT NULL DEFAULT '';\n";
  $sql .= "ALTER TABLE $table ADD `areavid` int(6) unsigned NOT NULL DEFAULT '0';\n";
  $sql .= "ALTER TABLE $table ADD `ispvid` int(6) unsigned NOT NULL DEFAULT '0';\n";
  $sql .= "ALTER TABLE $table ADD `carrier` varchar(20) NOT NULL DEFAULT '';\n";
  $sql .= "ALTER TABLE $table ADD INDEX mts (`mts`);\n";
  $sql .= "ALTER TABLE $table ADD INDEX province (`province`);\n";
  $sql .= "ALTER TABLE $table ADD INDEX catname (`catname`);\n";
  $sql .= "ALTER TABLE $table ADD INDEX telstring (`telstring`);\n";
  $sql .= "ALTER TABLE $table ADD INDEX areavid (`areavid`);\n";
  $sql .= "ALTER TABLE $table ADD INDEX ispvid (`ispvid`);\n";
  $sql .= "ALTER TABLE $table ADD INDEX carrier (`carrier`);\n";
}

$sql .="update  $table  set isregsuccess = '1' where uid > 0 and type = '1';\n";

$tablenotice = DB::table('zhanmishu_notice');
$countnotice = DB::fetch_first('show tables like \''.$tablenotice.'\'');
if (empty($countnotice)) {
  $sql .= <<<EOF
  CREATE TABLE IF NOT EXISTS pre_zhanmishu_notice (
    `nid` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
    `uid` mediumint(8) unsigned NOT NULL DEFAULT '0',
    `tid` mediumint(8) unsigned NOT NULL DEFAULT '0',
    `mobile` varchar(20) NOT NULL,
    `email` char(40) NOT NULL,
    `templateid` char(40) NOT NULL,
    `model` varchar(56) NOT NULL,
    `issendsms` tinyint(1) NOT NULL DEFAULT '0',
    `issendemail` tinyint(1) NOT NULL DEFAULT '0',
    `issendgroupsms` tinyint(1) NOT NULL DEFAULT '0',
    `issmssuccess` tinyint(1) NOT NULL DEFAULT '0',
    `isemailsuccess` tinyint(1) NOT NULL DEFAULT '0',
    `isgroupsmssuccess` tinyint(1) NOT NULL DEFAULT '0',
    `dateline` int(10) unsigned NOT NULL DEFAULT '0',
    `sendsmstime` int(10) unsigned NOT NULL DEFAULT '0',
    `sendemailtime` int(10) unsigned NOT NULL DEFAULT '0',
    `sendgroupsmstime` int(10) unsigned NOT NULL DEFAULT '0',
    `msg` varchar(80) NOT NULL DEFAULT '',
    `sub_code` varchar(80) NOT NULL DEFAULT '',
    `sub_msg` varchar(80) NOT NULL DEFAULT '',
    PRIMARY KEY (nid),
    KEY uid (uid),
    KEY mobile (mobile),
    KEY email (email),
    KEY sub_code (sub_code),
    KEY isemailsuccess (isemailsuccess),
    KEY issmssuccess (issmssuccess),
    KEY dateline (dateline)
  );
  CREATE TABLE IF NOT EXISTS pre_zhanmishu_tsetting (
    `tid` mediumint(8) unsigned NOT NULL,
    `uid` mediumint(8) unsigned NOT NULL DEFAULT '0',
    `mobile` varchar(20) NOT NULL,
    `issmsnotice` tinyint(1) NOT NULL DEFAULT '0',
    `isemailnotice` tinyint(1) NOT NULL DEFAULT '0',
    `dateline` int(10) unsigned NOT NULL DEFAULT '0',
     PRIMARY KEY (tid),
    KEY uid (uid),
    KEY issmsnotice (issmsnotice),
    KEY isemailnotice (isemailnotice),
    KEY dateline (dateline),
    KEY mobile (mobile));
EOF;
}

$tabletemplate = DB::table('zhanmishu_template');
$counttemplate = DB::fetch_first('show tables like \''.$tabletemplate.'\'');
if (empty($counttemplate)) {
  $sql .= <<<EOF
  CREATE TABLE IF NOT EXISTS pre_zhanmishu_template(
  `tid` mediumint(8) unsigned NOT NULL NOT NULL AUTO_INCREMENT,
  `uid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `templatename` varchar(20) NOT NULL,
  `sign` varchar(20) NOT NULL,
  `templateid` varchar(20) NOT NULL,
  `templateintro` varchar(255) NOT NULL,
  `templatetype` smallint(3) unsigned NOT NULL DEFAULT '0',
  `api` smallint(3) unsigned NOT NULL DEFAULT '0',
  `isopen` tinyint(1) NOT NULL DEFAULT '0',
  `dateline` int(10) unsigned NOT NULL DEFAULT '0',
   PRIMARY KEY (tid),
  KEY uid (uid),
  KEY templatename (templatename),
  KEY templateid (templateid),
  KEY templateintro (templateintro),
  KEY api (api),
  KEY templatetype (templatetype),
  KEY isopen (isopen),
  KEY dateline (dateline));

  CREATE TABLE IF NOT EXISTS pre_zhanmishu_var(
  `vid` mediumint(8) unsigned NOT NULL NOT NULL AUTO_INCREMENT,
  `uid` mediumint(8) unsigned NOT NULL DEFAULT '0',
  `varname` varchar(20) NOT NULL,
  `varvalue` varchar(20) NOT NULL,
  `varintro` varchar(255) NOT NULL,
  `dateline` int(10) unsigned NOT NULL DEFAULT '0',
   PRIMARY KEY (vid),
  KEY uid (uid),
  KEY varname (varname),
  KEY varintro (varintro),
  KEY dateline (dateline));
EOF;
}
if ($sql) {
	runquery($sql);
}



$finish = true;