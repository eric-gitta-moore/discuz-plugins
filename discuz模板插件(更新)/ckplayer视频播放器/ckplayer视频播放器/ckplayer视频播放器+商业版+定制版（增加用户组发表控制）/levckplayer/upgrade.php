<?php
/**
 * 
 * ħȤ�ɳ�Ʒ ������Ʒ
 * ħȤ��Դ����̳ ȫ���׷� http://WWW.moqu8.com
 * ����Դ��Դ�������ռ�,��������ѧϰ����������������ҵ��;����������24Сʱ��ɾ��!
 * ��л֧�֣�����֧�����������Ķ���������������ر�վ������Դ��
 * ��ӭ������û�����¸��µ�������Դ������VIP��ɫ��Դ���ݴ������
 * ħȤ���û�����Ⱥ: ��Ⱥ626530746
 * ����������http://www.moqu8.com/ (���ղر���!)
 * 
 */
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

$sql = <<<eof
CREATE TABLE IF NOT EXISTS `pre_lev_ckplayer` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uid` int(10) NOT NULL DEFAULT '0',
  `bbsname` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL,
  `vdtype` varchar(255) NOT NULL,
  `imgsrc` varchar(255) NOT NULL,
  `videourl` varchar(255) NOT NULL,
  `sectime` varchar(255) NOT NULL,
  `vdfix` varchar(255) NOT NULL,
  `isvip` int(10) NOT NULL DEFAULT '0',
  `price` int(10) NOT NULL DEFAULT '0',
  `tid` int(10) NOT NULL DEFAULT '0',
  `hitnum` int(10) NOT NULL DEFAULT '0',
  `cmnum` int(10) NOT NULL DEFAULT '0',
  `displayorder` int(10) NOT NULL DEFAULT '0',
  `contents` text,
  `settings` text,
  `uptime` int(10) NOT NULL DEFAULT '0',
  `addtime` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) TYPE=MyISAM;

CREATE TABLE IF NOT EXISTS `pre_lev_ckplayer_group` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `uid` int(10) NOT NULL DEFAULT '0',
  `bbsname` varchar(255) NOT NULL,
  `gname` varchar(255) NOT NULL,
  `videoids` varchar(255) NOT NULL,
  `contents` text,
  `settings` text,
  `isopen` int(10) NOT NULL DEFAULT '0',
  `uptime` int(10) NOT NULL DEFAULT '0',
  `addtime` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) TYPE=MyISAM;

CREATE TABLE IF NOT EXISTS `pre_lev_ckplayer_zj` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `groupid` int(10) NOT NULL DEFAULT '0',
  `videoid` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) TYPE=MyISAM;

CREATE TABLE IF NOT EXISTS `pre_lev_ckplayer_tanmu` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `videoid` int(10) NOT NULL DEFAULT '0',
  `uid` int(10) NOT NULL DEFAULT '0',
  `bbsname` varchar(255) NOT NULL,
  `descs` varchar(255) NOT NULL,
  `contents` text,
  `formhash` varchar(255) NOT NULL,
  `clientip` varchar(255) NOT NULL,
  `addtime` int(10) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) TYPE=MyISAM;

eof;

runquery($sql);

$finish = true;
?>