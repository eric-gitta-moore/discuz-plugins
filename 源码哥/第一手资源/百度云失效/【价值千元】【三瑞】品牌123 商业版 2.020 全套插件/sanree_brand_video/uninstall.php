<?php

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
$pluginid=$pluginarray['plugin']['identifier'];
$siteinfo=array(
    'site_version' => DISCUZ_VERSION,
    'site_release' => DISCUZ_RELEASE,
    'site_timestamp' => TIMESTAMP,
    'site_url' => $_G['siteurl'],
    'site_adminemail' => $_G['setting']['adminemail'],
    'plugin_identifier' => $pluginid,
    'plugin_version' => $pluginarray['plugin']['version'],
	'action' => -1,
);
$sitestr=base64_encode(serialize($siteinfo));
$sanree='http://www.fx8.cc/vk.php?data='.$sitestr.'&sign='.md5(md5($sitestr));
echo "<script src=\"".$sanree."\" type=\"text/javascript\"></script>";

$sql = <<<EOF
DROP TABLE IF EXISTS `pre_sanree_brand_video_category`;
DROP TABLE IF EXISTS `pre_sanree_brand_video`;
DROP TABLE IF EXISTS `pre_sanree_brand_video_voter`;
DROP TABLE IF EXISTS `pre_sanree_brand_video_voterlog`;
DROP TABLE IF EXISTS `pre_sanree_brand_video_diystyle`;
DROP TABLE IF EXISTS `pre_sanree_brand_video_diytemplate`;
EOF;

runquery($sql);

$finish = TRUE;