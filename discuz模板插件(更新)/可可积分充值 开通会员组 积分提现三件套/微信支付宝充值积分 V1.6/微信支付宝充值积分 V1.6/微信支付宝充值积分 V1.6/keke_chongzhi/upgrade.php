<?php
/*

 */

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}

$keke_chongzhi_credit= DB::table("keke_chongzhi_credit");
$sql = <<<EOF
CREATE TABLE IF NOT EXISTS `$keke_chongzhi_credit` (
  `creditid` int(10) unsigned NOT NULL,
  `bili` int(50) NOT NULL,
  `min` float(50,2) NOT NULL,
  `max` float(50,2) unsigned NOT NULL,
  `state` int(10) NOT NULL,
  `sxf` int(10) NOT NULL,
  `shunxu` int(10) NOT NULL,
  PRIMARY KEY  (`creditid`)
) ENGINE=MyISAM;

EOF;
runquery($sql);


$finish = TRUE;
@unlink(DISCUZ_ROOT . './source/plugin/keke_chongzhi/discuz_plugin_keke_chongzhi.xml');
@unlink(DISCUZ_ROOT . './source/plugin/keke_chongzhi/discuz_plugin_keke_chongzhi_SC_GBK.xml');
@unlink(DISCUZ_ROOT . './source/plugin/keke_chongzhi/discuz_plugin_keke_chongzhi_SC_UTF8.xml');
@unlink(DISCUZ_ROOT . './source/plugin/keke_chongzhi/discuz_plugin_keke_chongzhi_TC_BIG5.xml');
@unlink(DISCUZ_ROOT . './source/plugin/keke_chongzhi/discuz_plugin_keke_chongzhi_TC_UTF8.xml');
@unlink(DISCUZ_ROOT . 'source/plugin/keke_chongzhi/install.php');
@unlink(DISCUZ_ROOT . 'source/plugin/keke_chongzhi/upgrade.php');

?>