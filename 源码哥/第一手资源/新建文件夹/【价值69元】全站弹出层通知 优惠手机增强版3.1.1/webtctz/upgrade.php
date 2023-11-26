<?php
/*
 * CopyRight  : [fx8.cc!] (C)2014-2016
 * Document   : 源码哥：www.fx8.cc，www.ymg6.com
 * Created on : 2016-01-06,09:53:15
 * Author     : 源码哥(QQ：154606914) wWw.fx8.cc $
 * Description: This is NOT a freeware, use is subject to license terms.
 *              源码哥出品 必属精品。
 *              源码哥分享吧 全网首发 http://www.fx8.cc；
 */
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

if(!$fromversion)
	$fromversion = trim($_GET['fromversion']);
if($fromversion<'2.5.1' && $fromversion>='2.5.0'){
	$tablename = DB::table('webtctz_lists');
	$sql = <<<EOF
ALTER TABLE `{$tablename}` ADD COLUMN `users` varchar(1024) DEFAULT NULL AFTER `category`;
ALTER TABLE `{$tablename}` ADD COLUMN `tids` varchar(1024) DEFAULT NULL AFTER `users`;
ALTER TABLE `{$tablename}` ADD COLUMN `aids` varchar(1024) DEFAULT NULL AFTER `tids`;
ALTER TABLE `{$tablename}` ADD COLUMN `isopenborder` int(11) DEFAULT NULL AFTER `isopen`;
ALTER TABLE `{$tablename}` ADD COLUMN `plugins` varchar(1024) DEFAULT NULL AFTER `targets`;
ALTER TABLE `{$tablename}` ADD COLUMN `isclosetime` int(11) DEFAULT NULL AFTER `endtime`;
ALTER TABLE `{$tablename}` ADD COLUMN `isanimatestart` int(11) DEFAULT NULL AFTER `isclosetime`;
ALTER TABLE `{$tablename}` ADD COLUMN `iscloseshow` int(11) DEFAULT NULL AFTER `isanimatestart`;
ALTER TABLE `{$tablename}` ADD COLUMN `isfloat` int(11) DEFAULT NULL AFTER `iscloseshow`;
ALTER TABLE `{$tablename}` ADD COLUMN `zindex` int(11) DEFAULT NULL AFTER `isfloat`;
ALTER TABLE `{$tablename}` ADD COLUMN `isbg` int(11) DEFAULT NULL AFTER `zindex`;
ALTER TABLE `{$tablename}` ADD COLUMN `delay` int(11) DEFAULT NULL AFTER `isbg`;
ALTER TABLE `{$tablename}` ADD COLUMN `contentbg` varchar(1024) DEFAULT NULL AFTER `delay`;
ALTER TABLE `{$tablename}` ADD COLUMN `ccloseimg` varchar(1024) DEFAULT NULL AFTER `contentbg`;
ALTER TABLE `{$tablename}` ADD COLUMN `closeheight` decimal(10,2) DEFAULT NULL AFTER `ccloseimg`;
ALTER TABLE `{$tablename}` ADD COLUMN `closewidth` decimal(10,2) DEFAULT NULL AFTER `closeheight`;
ALTER TABLE `{$tablename}` ADD COLUMN `closepyright` decimal(10,2) DEFAULT NULL AFTER `closewidth`; 
ALTER TABLE `{$tablename}` ADD COLUMN `closepybottom` decimal(10,2) DEFAULT NULL AFTER `closepyright`; 
    
DROP TABLE IF EXISTS pre_webtctz_mobilelists;
CREATE TABLE pre_webtctz_mobilelists (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(1024) DEFAULT NULL,
  `isopen` int(11) DEFAULT NULL,
  `isopenborder` int(11) DEFAULT NULL,
  `targets` varchar(1024) DEFAULT NULL,
  `plugins` varchar(1024) DEFAULT NULL,
  `fids` varchar(1024) DEFAULT NULL,
  `usergroup` varchar(1024) DEFAULT NULL,
  `groups` varchar(1024) DEFAULT NULL,
  `category` varchar(1024) DEFAULT NULL,
  `users` varchar(1024) DEFAULT NULL,
  `tids` varchar(1024) DEFAULT NULL,
  `aids` varchar(1024) DEFAULT NULL,
  `type` int(11) DEFAULT NULL,
  `cimg` varchar(1024) DEFAULT NULL,
  `ctext` text,
  `curl` varchar(1024) DEFAULT NULL,
  `ciframe` varchar(1024) DEFAULT NULL,
  `chtml` text,
  `height` decimal(10,2) DEFAULT NULL,
  `width` decimal(10,2) DEFAULT NULL,
  `count` int(11) DEFAULT NULL,
  `position` int(11) DEFAULT NULL,
  `pyright` decimal(10,2) DEFAULT NULL,
  `pybottom` decimal(10,2) DEFAULT NULL,
  `transparency` decimal(10,2) DEFAULT NULL,
  `closetime` int(11) DEFAULT NULL,
  `interval` int(11) DEFAULT NULL,
  `starttime` int(11) DEFAULT NULL,
  `endtime` int(11) DEFAULT NULL,
  `isclosetime` int(11) DEFAULT NULL,
  `isanimatestart` int(11) DEFAULT NULL,
  `iscloseshow` int(11) DEFAULT NULL,
  `isfloat` int(11) DEFAULT NULL,
  `isbg` int(11) DEFAULT NULL,
  `zindex` int(11) DEFAULT NULL,
  `delay` int(11) DEFAULT NULL,
  `contentbg` varchar(1024) DEFAULT NULL,
  `ccloseimg` varchar(1024) DEFAULT NULL,
  `closeheight` decimal(10,2) DEFAULT NULL,
  `closewidth` decimal(10,2) DEFAULT NULL,
  `closepyright` decimal(10,2) DEFAULT NULL,
  `closepybottom` decimal(10,2) DEFAULT NULL,
  `dateline` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
);
EOF;
	runquery($sql);
	
}
if($fromversion<'2.5.5' && $fromversion>='2.5.1'){
	$tablename = DB::table('webtctz_lists');
	$sql = <<<EOF
ALTER TABLE `{$tablename}` ADD COLUMN `isopenborder` int(11) DEFAULT NULL AFTER `isopen`;
ALTER TABLE `{$tablename}` ADD COLUMN `plugins` varchar(1024) DEFAULT NULL AFTER `targets`;
ALTER TABLE `{$tablename}` ADD COLUMN `isclosetime` int(11) DEFAULT NULL AFTER `endtime`;
ALTER TABLE `{$tablename}` ADD COLUMN `isanimatestart` int(11) DEFAULT NULL AFTER `isclosetime`;
ALTER TABLE `{$tablename}` ADD COLUMN `iscloseshow` int(11) DEFAULT NULL AFTER `isanimatestart`;
ALTER TABLE `{$tablename}` ADD COLUMN `isfloat` int(11) DEFAULT NULL AFTER `iscloseshow`;
ALTER TABLE `{$tablename}` ADD COLUMN `zindex` int(11) DEFAULT NULL AFTER `isfloat`;
ALTER TABLE `{$tablename}` ADD COLUMN `isbg` int(11) DEFAULT NULL AFTER `zindex`;
ALTER TABLE `{$tablename}` ADD COLUMN `delay` int(11) DEFAULT NULL AFTER `isbg`;
ALTER TABLE `{$tablename}` ADD COLUMN `contentbg` varchar(1024) DEFAULT NULL AFTER `delay`;
ALTER TABLE `{$tablename}` ADD COLUMN `ccloseimg` varchar(1024) DEFAULT NULL AFTER `contentbg`;
ALTER TABLE `{$tablename}` ADD COLUMN `closeheight` decimal(10,2) DEFAULT NULL AFTER `ccloseimg`;
ALTER TABLE `{$tablename}` ADD COLUMN `closewidth` decimal(10,2) DEFAULT NULL AFTER `closeheight`;
ALTER TABLE `{$tablename}` ADD COLUMN `closepyright` decimal(10,2) DEFAULT NULL AFTER `closewidth`; 
ALTER TABLE `{$tablename}` ADD COLUMN `closepybottom` decimal(10,2) DEFAULT NULL AFTER `closepyright`; 
    
DROP TABLE IF EXISTS pre_webtctz_mobilelists;
CREATE TABLE pre_webtctz_mobilelists (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(1024) DEFAULT NULL,
  `isopen` int(11) DEFAULT NULL,
  `isopenborder` int(11) DEFAULT NULL,
  `targets` varchar(1024) DEFAULT NULL,
  `plugins` varchar(1024) DEFAULT NULL,
  `fids` varchar(1024) DEFAULT NULL,
  `usergroup` varchar(1024) DEFAULT NULL,
  `groups` varchar(1024) DEFAULT NULL,
  `category` varchar(1024) DEFAULT NULL,
  `users` varchar(1024) DEFAULT NULL,
  `tids` varchar(1024) DEFAULT NULL,
  `aids` varchar(1024) DEFAULT NULL,
  `type` int(11) DEFAULT NULL,
  `cimg` varchar(1024) DEFAULT NULL,
  `ctext` text,
  `curl` varchar(1024) DEFAULT NULL,
  `ciframe` varchar(1024) DEFAULT NULL,
  `chtml` text,
  `height` decimal(10,2) DEFAULT NULL,
  `width` decimal(10,2) DEFAULT NULL,
  `count` int(11) DEFAULT NULL,
  `position` int(11) DEFAULT NULL,
  `pyright` decimal(10,2) DEFAULT NULL,
  `pybottom` decimal(10,2) DEFAULT NULL,
  `transparency` decimal(10,2) DEFAULT NULL,
  `closetime` int(11) DEFAULT NULL,
  `interval` int(11) DEFAULT NULL,
  `starttime` int(11) DEFAULT NULL,
  `endtime` int(11) DEFAULT NULL,
  `isclosetime` int(11) DEFAULT NULL,
  `isanimatestart` int(11) DEFAULT NULL,
  `iscloseshow` int(11) DEFAULT NULL,
  `isfloat` int(11) DEFAULT NULL,
  `isbg` int(11) DEFAULT NULL,
  `zindex` int(11) DEFAULT NULL,
  `delay` int(11) DEFAULT NULL,
  `contentbg` varchar(1024) DEFAULT NULL,
  `ccloseimg` varchar(1024) DEFAULT NULL,
  `closeheight` decimal(10,2) DEFAULT NULL,
  `closewidth` decimal(10,2) DEFAULT NULL,
  `closepyright` decimal(10,2) DEFAULT NULL,
  `closepybottom` decimal(10,2) DEFAULT NULL,
  `dateline` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
);
EOF;
	runquery($sql);

	
}
if($fromversion<'2.6.0' && $fromversion>='2.5.5'){
	$tablename = DB::table('webtctz_lists');
	$sql = <<<EOF
ALTER TABLE `{$tablename}` ADD COLUMN `isclosetime` int(11) DEFAULT NULL AFTER `endtime`;
ALTER TABLE `{$tablename}` ADD COLUMN `isanimatestart` int(11) DEFAULT NULL AFTER `isclosetime`;
ALTER TABLE `{$tablename}` ADD COLUMN `iscloseshow` int(11) DEFAULT NULL AFTER `isanimatestart`;
ALTER TABLE `{$tablename}` ADD COLUMN `isfloat` int(11) DEFAULT NULL AFTER `iscloseshow`;
ALTER TABLE `{$tablename}` ADD COLUMN `zindex` int(11) DEFAULT NULL AFTER `isfloat`;
ALTER TABLE `{$tablename}` ADD COLUMN `isbg` int(11) DEFAULT NULL AFTER `zindex`;
ALTER TABLE `{$tablename}` ADD COLUMN `delay` int(11) DEFAULT NULL AFTER `isbg`;
ALTER TABLE `{$tablename}` ADD COLUMN `contentbg` varchar(1024) DEFAULT NULL AFTER `delay`;
ALTER TABLE `{$tablename}` ADD COLUMN `ccloseimg` varchar(1024) DEFAULT NULL AFTER `contentbg`;
ALTER TABLE `{$tablename}` ADD COLUMN `closeheight` decimal(10,2) DEFAULT NULL AFTER `ccloseimg`;
ALTER TABLE `{$tablename}` ADD COLUMN `closewidth` decimal(10,2) DEFAULT NULL AFTER `closeheight`;
ALTER TABLE `{$tablename}` ADD COLUMN `closepyright` decimal(10,2) DEFAULT NULL AFTER `closewidth`; 
ALTER TABLE `{$tablename}` ADD COLUMN `closepybottom` decimal(10,2) DEFAULT NULL AFTER `closepyright`; 
    
DROP TABLE IF EXISTS pre_webtctz_mobilelists;
CREATE TABLE pre_webtctz_mobilelists (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(1024) DEFAULT NULL,
  `isopen` int(11) DEFAULT NULL,
  `isopenborder` int(11) DEFAULT NULL,
  `targets` varchar(1024) DEFAULT NULL,
  `plugins` varchar(1024) DEFAULT NULL,
  `fids` varchar(1024) DEFAULT NULL,
  `usergroup` varchar(1024) DEFAULT NULL,
  `groups` varchar(1024) DEFAULT NULL,
  `category` varchar(1024) DEFAULT NULL,
  `users` varchar(1024) DEFAULT NULL,
  `tids` varchar(1024) DEFAULT NULL,
  `aids` varchar(1024) DEFAULT NULL,
  `type` int(11) DEFAULT NULL,
  `cimg` varchar(1024) DEFAULT NULL,
  `ctext` text,
  `curl` varchar(1024) DEFAULT NULL,
  `ciframe` varchar(1024) DEFAULT NULL,
  `chtml` text,
  `height` decimal(10,2) DEFAULT NULL,
  `width` decimal(10,2) DEFAULT NULL,
  `count` int(11) DEFAULT NULL,
  `position` int(11) DEFAULT NULL,
  `pyright` decimal(10,2) DEFAULT NULL,
  `pybottom` decimal(10,2) DEFAULT NULL,
  `transparency` decimal(10,2) DEFAULT NULL,
  `closetime` int(11) DEFAULT NULL,
  `interval` int(11) DEFAULT NULL,
  `starttime` int(11) DEFAULT NULL,
  `endtime` int(11) DEFAULT NULL,
  `isclosetime` int(11) DEFAULT NULL,
  `isanimatestart` int(11) DEFAULT NULL,
  `iscloseshow` int(11) DEFAULT NULL,
  `isfloat` int(11) DEFAULT NULL,
  `isbg` int(11) DEFAULT NULL,
  `zindex` int(11) DEFAULT NULL,
  `delay` int(11) DEFAULT NULL,
  `contentbg` varchar(1024) DEFAULT NULL,
  `ccloseimg` varchar(1024) DEFAULT NULL,
  `closeheight` decimal(10,2) DEFAULT NULL,
  `closewidth` decimal(10,2) DEFAULT NULL,
  `closepyright` decimal(10,2) DEFAULT NULL,
  `closepybottom` decimal(10,2) DEFAULT NULL,
  `dateline` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
);
EOF;
	runquery($sql);


}
if($fromversion<'2.6.1' && $fromversion>='2.6.0'){
	$tablename = DB::table('webtctz_lists');
	$sql = <<<EOF
ALTER TABLE `{$tablename}` ADD COLUMN `zindex` int(11) DEFAULT NULL AFTER `isfloat`;
ALTER TABLE `{$tablename}` ADD COLUMN `isbg` int(11) DEFAULT NULL AFTER `zindex`;
ALTER TABLE `{$tablename}` ADD COLUMN `delay` int(11) DEFAULT NULL AFTER `isbg`;
ALTER TABLE `{$tablename}` ADD COLUMN `contentbg` varchar(1024) DEFAULT NULL AFTER `delay`;
ALTER TABLE `{$tablename}` ADD COLUMN `ccloseimg` varchar(1024) DEFAULT NULL AFTER `contentbg`;
ALTER TABLE `{$tablename}` ADD COLUMN `closeheight` decimal(10,2) DEFAULT NULL AFTER `ccloseimg`;
ALTER TABLE `{$tablename}` ADD COLUMN `closewidth` decimal(10,2) DEFAULT NULL AFTER `closeheight`;
ALTER TABLE `{$tablename}` ADD COLUMN `closepyright` decimal(10,2) DEFAULT NULL AFTER `closewidth`; 
ALTER TABLE `{$tablename}` ADD COLUMN `closepybottom` decimal(10,2) DEFAULT NULL AFTER `closepyright`; 
    
DROP TABLE IF EXISTS pre_webtctz_mobilelists;
CREATE TABLE pre_webtctz_mobilelists (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(1024) DEFAULT NULL,
  `isopen` int(11) DEFAULT NULL,
  `isopenborder` int(11) DEFAULT NULL,
  `targets` varchar(1024) DEFAULT NULL,
  `plugins` varchar(1024) DEFAULT NULL,
  `fids` varchar(1024) DEFAULT NULL,
  `usergroup` varchar(1024) DEFAULT NULL,
  `groups` varchar(1024) DEFAULT NULL,
  `category` varchar(1024) DEFAULT NULL,
  `users` varchar(1024) DEFAULT NULL,
  `tids` varchar(1024) DEFAULT NULL,
  `aids` varchar(1024) DEFAULT NULL,
  `type` int(11) DEFAULT NULL,
  `cimg` varchar(1024) DEFAULT NULL,
  `ctext` text,
  `curl` varchar(1024) DEFAULT NULL,
  `ciframe` varchar(1024) DEFAULT NULL,
  `chtml` text,
  `height` decimal(10,2) DEFAULT NULL,
  `width` decimal(10,2) DEFAULT NULL,
  `count` int(11) DEFAULT NULL,
  `position` int(11) DEFAULT NULL,
  `pyright` decimal(10,2) DEFAULT NULL,
  `pybottom` decimal(10,2) DEFAULT NULL,
  `transparency` decimal(10,2) DEFAULT NULL,
  `closetime` int(11) DEFAULT NULL,
  `interval` int(11) DEFAULT NULL,
  `starttime` int(11) DEFAULT NULL,
  `endtime` int(11) DEFAULT NULL,
  `isclosetime` int(11) DEFAULT NULL,
  `isanimatestart` int(11) DEFAULT NULL,
  `iscloseshow` int(11) DEFAULT NULL,
  `isfloat` int(11) DEFAULT NULL,
  `isbg` int(11) DEFAULT NULL,
  `zindex` int(11) DEFAULT NULL,
  `delay` int(11) DEFAULT NULL,
  `contentbg` varchar(1024) DEFAULT NULL,
  `ccloseimg` varchar(1024) DEFAULT NULL,
  `closeheight` decimal(10,2) DEFAULT NULL,
  `closewidth` decimal(10,2) DEFAULT NULL,
  `closepyright` decimal(10,2) DEFAULT NULL,
  `closepybottom` decimal(10,2) DEFAULT NULL,
  `dateline` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
);
EOF;
	runquery($sql);


}

if($fromversion<'2.6.2' && $fromversion>='2.6.1'){
	$tablename = DB::table('webtctz_lists');
	$sql = <<<EOF
ALTER TABLE `{$tablename}` ADD COLUMN `isbg` int(11) DEFAULT NULL AFTER `zindex`;
ALTER TABLE `{$tablename}` ADD COLUMN `delay` int(11) DEFAULT NULL AFTER `isbg`;
ALTER TABLE `{$tablename}` ADD COLUMN `contentbg` varchar(1024) DEFAULT NULL AFTER `delay`;
ALTER TABLE `{$tablename}` ADD COLUMN `ccloseimg` varchar(1024) DEFAULT NULL AFTER `contentbg`;
ALTER TABLE `{$tablename}` ADD COLUMN `closeheight` decimal(10,2) DEFAULT NULL AFTER `ccloseimg`;
ALTER TABLE `{$tablename}` ADD COLUMN `closewidth` decimal(10,2) DEFAULT NULL AFTER `closeheight`;
ALTER TABLE `{$tablename}` ADD COLUMN `closepyright` decimal(10,2) DEFAULT NULL AFTER `closewidth`; 
ALTER TABLE `{$tablename}` ADD COLUMN `closepybottom` decimal(10,2) DEFAULT NULL AFTER `closepyright`; 
    
DROP TABLE IF EXISTS pre_webtctz_mobilelists;
CREATE TABLE pre_webtctz_mobilelists (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(1024) DEFAULT NULL,
  `isopen` int(11) DEFAULT NULL,
  `isopenborder` int(11) DEFAULT NULL,
  `targets` varchar(1024) DEFAULT NULL,
  `plugins` varchar(1024) DEFAULT NULL,
  `fids` varchar(1024) DEFAULT NULL,
  `usergroup` varchar(1024) DEFAULT NULL,
  `groups` varchar(1024) DEFAULT NULL,
  `category` varchar(1024) DEFAULT NULL,
  `users` varchar(1024) DEFAULT NULL,
  `tids` varchar(1024) DEFAULT NULL,
  `aids` varchar(1024) DEFAULT NULL,
  `type` int(11) DEFAULT NULL,
  `cimg` varchar(1024) DEFAULT NULL,
  `ctext` text,
  `curl` varchar(1024) DEFAULT NULL,
  `ciframe` varchar(1024) DEFAULT NULL,
  `chtml` text,
  `height` decimal(10,2) DEFAULT NULL,
  `width` decimal(10,2) DEFAULT NULL,
  `count` int(11) DEFAULT NULL,
  `position` int(11) DEFAULT NULL,
  `pyright` decimal(10,2) DEFAULT NULL,
  `pybottom` decimal(10,2) DEFAULT NULL,
  `transparency` decimal(10,2) DEFAULT NULL,
  `closetime` int(11) DEFAULT NULL,
  `interval` int(11) DEFAULT NULL,
  `starttime` int(11) DEFAULT NULL,
  `endtime` int(11) DEFAULT NULL,
  `isclosetime` int(11) DEFAULT NULL,
  `isanimatestart` int(11) DEFAULT NULL,
  `iscloseshow` int(11) DEFAULT NULL,
  `isfloat` int(11) DEFAULT NULL,
  `isbg` int(11) DEFAULT NULL,
  `zindex` int(11) DEFAULT NULL,
  `delay` int(11) DEFAULT NULL,
  `contentbg` varchar(1024) DEFAULT NULL,
  `ccloseimg` varchar(1024) DEFAULT NULL,
  `closeheight` decimal(10,2) DEFAULT NULL,
  `closewidth` decimal(10,2) DEFAULT NULL,
  `closepyright` decimal(10,2) DEFAULT NULL,
  `closepybottom` decimal(10,2) DEFAULT NULL,
  `dateline` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
);
EOF;
	runquery($sql);


}

if($fromversion<'2.6.3' && $fromversion>='2.6.2'){
	$tablename = DB::table('webtctz_lists');
	$sql = <<<EOF
ALTER TABLE `{$tablename}` ADD COLUMN `delay` int(11) DEFAULT NULL AFTER `isbg`;
ALTER TABLE `{$tablename}` ADD COLUMN `contentbg` varchar(1024) DEFAULT NULL AFTER `delay`;
ALTER TABLE `{$tablename}` ADD COLUMN `ccloseimg` varchar(1024) DEFAULT NULL AFTER `contentbg`;
ALTER TABLE `{$tablename}` ADD COLUMN `closeheight` decimal(10,2) DEFAULT NULL AFTER `ccloseimg`;
ALTER TABLE `{$tablename}` ADD COLUMN `closewidth` decimal(10,2) DEFAULT NULL AFTER `closeheight`;
ALTER TABLE `{$tablename}` ADD COLUMN `closepyright` decimal(10,2) DEFAULT NULL AFTER `closewidth`; 
ALTER TABLE `{$tablename}` ADD COLUMN `closepybottom` decimal(10,2) DEFAULT NULL AFTER `closepyright`; 
    
DROP TABLE IF EXISTS pre_webtctz_mobilelists;
CREATE TABLE pre_webtctz_mobilelists (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(1024) DEFAULT NULL,
  `isopen` int(11) DEFAULT NULL,
  `isopenborder` int(11) DEFAULT NULL,
  `targets` varchar(1024) DEFAULT NULL,
  `plugins` varchar(1024) DEFAULT NULL,
  `fids` varchar(1024) DEFAULT NULL,
  `usergroup` varchar(1024) DEFAULT NULL,
  `groups` varchar(1024) DEFAULT NULL,
  `category` varchar(1024) DEFAULT NULL,
  `users` varchar(1024) DEFAULT NULL,
  `tids` varchar(1024) DEFAULT NULL,
  `aids` varchar(1024) DEFAULT NULL,
  `type` int(11) DEFAULT NULL,
  `cimg` varchar(1024) DEFAULT NULL,
  `ctext` text,
  `curl` varchar(1024) DEFAULT NULL,
  `ciframe` varchar(1024) DEFAULT NULL,
  `chtml` text,
  `height` decimal(10,2) DEFAULT NULL,
  `width` decimal(10,2) DEFAULT NULL,
  `count` int(11) DEFAULT NULL,
  `position` int(11) DEFAULT NULL,
  `pyright` decimal(10,2) DEFAULT NULL,
  `pybottom` decimal(10,2) DEFAULT NULL,
  `transparency` decimal(10,2) DEFAULT NULL,
  `closetime` int(11) DEFAULT NULL,
  `interval` int(11) DEFAULT NULL,
  `starttime` int(11) DEFAULT NULL,
  `endtime` int(11) DEFAULT NULL,
  `isclosetime` int(11) DEFAULT NULL,
  `isanimatestart` int(11) DEFAULT NULL,
  `iscloseshow` int(11) DEFAULT NULL,
  `isfloat` int(11) DEFAULT NULL,
  `isbg` int(11) DEFAULT NULL,
  `zindex` int(11) DEFAULT NULL,
  `delay` int(11) DEFAULT NULL,
  `contentbg` varchar(1024) DEFAULT NULL,
  `ccloseimg` varchar(1024) DEFAULT NULL,
  `closeheight` decimal(10,2) DEFAULT NULL,
  `closewidth` decimal(10,2) DEFAULT NULL,
  `closepyright` decimal(10,2) DEFAULT NULL,
  `closepybottom` decimal(10,2) DEFAULT NULL,
  `dateline` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
);
EOF;
	runquery($sql);


}
if($fromversion<'2.7.0' && $fromversion>='2.6.3'){
    $tablename = DB::table('webtctz_lists');
    $sql = <<<EOF
ALTER TABLE `{$tablename}` ADD COLUMN `contentbg` varchar(1024) DEFAULT NULL AFTER `delay`;
ALTER TABLE `{$tablename}` ADD COLUMN `ccloseimg` varchar(1024) DEFAULT NULL AFTER `contentbg`;
ALTER TABLE `{$tablename}` ADD COLUMN `closeheight` decimal(10,2) DEFAULT NULL AFTER `ccloseimg`;
ALTER TABLE `{$tablename}` ADD COLUMN `closewidth` decimal(10,2) DEFAULT NULL AFTER `closeheight`;
ALTER TABLE `{$tablename}` ADD COLUMN `closepyright` decimal(10,2) DEFAULT NULL AFTER `closewidth`; 
ALTER TABLE `{$tablename}` ADD COLUMN `closepybottom` decimal(10,2) DEFAULT NULL AFTER `closepyright`; 
    
DROP TABLE IF EXISTS pre_webtctz_mobilelists;
CREATE TABLE pre_webtctz_mobilelists (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(1024) DEFAULT NULL,
  `isopen` int(11) DEFAULT NULL,
  `isopenborder` int(11) DEFAULT NULL,
  `targets` varchar(1024) DEFAULT NULL,
  `plugins` varchar(1024) DEFAULT NULL,
  `fids` varchar(1024) DEFAULT NULL,
  `usergroup` varchar(1024) DEFAULT NULL,
  `groups` varchar(1024) DEFAULT NULL,
  `category` varchar(1024) DEFAULT NULL,
  `users` varchar(1024) DEFAULT NULL,
  `tids` varchar(1024) DEFAULT NULL,
  `aids` varchar(1024) DEFAULT NULL,
  `type` int(11) DEFAULT NULL,
  `cimg` varchar(1024) DEFAULT NULL,
  `ctext` text,
  `curl` varchar(1024) DEFAULT NULL,
  `ciframe` varchar(1024) DEFAULT NULL,
  `chtml` text,
  `height` decimal(10,2) DEFAULT NULL,
  `width` decimal(10,2) DEFAULT NULL,
  `count` int(11) DEFAULT NULL,
  `position` int(11) DEFAULT NULL,
  `pyright` decimal(10,2) DEFAULT NULL,
  `pybottom` decimal(10,2) DEFAULT NULL,
  `transparency` decimal(10,2) DEFAULT NULL,
  `closetime` int(11) DEFAULT NULL,
  `interval` int(11) DEFAULT NULL,
  `starttime` int(11) DEFAULT NULL,
  `endtime` int(11) DEFAULT NULL,
  `isclosetime` int(11) DEFAULT NULL,
  `isanimatestart` int(11) DEFAULT NULL,
  `iscloseshow` int(11) DEFAULT NULL,
  `isfloat` int(11) DEFAULT NULL,
  `isbg` int(11) DEFAULT NULL,
  `zindex` int(11) DEFAULT NULL,
  `delay` int(11) DEFAULT NULL,
  `contentbg` varchar(1024) DEFAULT NULL,
  `ccloseimg` varchar(1024) DEFAULT NULL,
  `closeheight` decimal(10,2) DEFAULT NULL,
  `closewidth` decimal(10,2) DEFAULT NULL,
  `closepyright` decimal(10,2) DEFAULT NULL,
  `closepybottom` decimal(10,2) DEFAULT NULL,
  `dateline` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
);
EOF;
    runquery($sql);


}
if($fromversion<'3.0.0' && $fromversion>='2.7.0'){
    $sql = <<<EOF
DROP TABLE IF EXISTS pre_webtctz_mobilelists;
CREATE TABLE pre_webtctz_mobilelists (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(1024) DEFAULT NULL,
  `isopen` int(11) DEFAULT NULL,
  `isopenborder` int(11) DEFAULT NULL,
  `targets` varchar(1024) DEFAULT NULL,
  `plugins` varchar(1024) DEFAULT NULL,
  `fids` varchar(1024) DEFAULT NULL,
  `usergroup` varchar(1024) DEFAULT NULL,
  `groups` varchar(1024) DEFAULT NULL,
  `category` varchar(1024) DEFAULT NULL,
  `users` varchar(1024) DEFAULT NULL,
  `tids` varchar(1024) DEFAULT NULL,
  `aids` varchar(1024) DEFAULT NULL,
  `type` int(11) DEFAULT NULL,
  `cimg` varchar(1024) DEFAULT NULL,
  `ctext` text,
  `curl` varchar(1024) DEFAULT NULL,
  `ciframe` varchar(1024) DEFAULT NULL,
  `chtml` text,
  `height` decimal(10,2) DEFAULT NULL,
  `width` decimal(10,2) DEFAULT NULL,
  `count` int(11) DEFAULT NULL,
  `position` int(11) DEFAULT NULL,
  `pyright` decimal(10,2) DEFAULT NULL,
  `pybottom` decimal(10,2) DEFAULT NULL,
  `transparency` decimal(10,2) DEFAULT NULL,
  `closetime` int(11) DEFAULT NULL,
  `interval` int(11) DEFAULT NULL,
  `starttime` int(11) DEFAULT NULL,
  `endtime` int(11) DEFAULT NULL,
  `isclosetime` int(11) DEFAULT NULL,
  `isanimatestart` int(11) DEFAULT NULL,
  `iscloseshow` int(11) DEFAULT NULL,
  `isfloat` int(11) DEFAULT NULL,
  `isbg` int(11) DEFAULT NULL,
  `zindex` int(11) DEFAULT NULL,
  `delay` int(11) DEFAULT NULL,
  `contentbg` varchar(1024) DEFAULT NULL,
  `ccloseimg` varchar(1024) DEFAULT NULL,
  `closeheight` decimal(10,2) DEFAULT NULL,
  `closewidth` decimal(10,2) DEFAULT NULL,
  `closepyright` decimal(10,2) DEFAULT NULL,
  `closepybottom` decimal(10,2) DEFAULT NULL,
  `dateline` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
);
EOF;
    runquery($sql);


}
$finish = TRUE;
?>
