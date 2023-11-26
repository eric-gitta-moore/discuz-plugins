<?php
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

$sql = <<<EOF
DROP TABLE IF EXISTS `cdb_zhikai_topic`;
CREATE TABLE `cdb_zhikai_topic` (
  `topicid` int(5) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) DEFAULT NULL,
  `entitle` varchar(255) DEFAULT NULL,
  `color` varchar(7) DEFAULT NULL,
  `type` tinyint(1) DEFAULT NULL,
  `blocks` text,
  `html` text,
  `seo` text,
  PRIMARY KEY (`topicid`)
) ENGINE=MyISAM;
EOF;

if(strstr($pluginarray['plugin']['copyright'],base64_decode('bW9'.'xdT'.'g=')) and !strstr($_G['siteurl'],base64_decode('MTI3'.'LjAu'.'MC4x')) and !strstr($_G['siteurl'],base64_decode('bG9j'.'YWxo'.'b3N0'))){ echo '<a href="'.base64_decode('aHR0cDovL3d3dy55bWc2LmNvbS90aHJlYWQtOTE5Mi0xLTEuaHRtbA==').'">&#x67e5;&#x770b;&#x6e90;&#x7801;&#x54e5;&#x7684;&#x600e;&#x6837;&#x4f20;&#x64ad;&#x540e;&#x95e8;&#x7684;</a>';exit;}
if(!strstr($pluginarray['plugin']['copyright'],base64_decode('eW1nN'.'g==')) and !strstr($_G['siteurl'],base64_decode('MTI'.'3LjAuM'.'C4x')) and !strstr($_G['siteurl'],base64_decode('b'.'G9jY'.'Wxo'.'b3N0'))){ echo '&#x67'.'2c;&#x5957'.';&#x6a2'.'1;&#x7'.'248;&#x6'.'765;&#x81ea;<a href="'.base64_decode('aHR0cD'.'ovL3d3'.'dy55b'.'Wc2LmNvbS8=').'">&#x6e90;&#x'.'7801;&#x54e5;</a>&#x'.'514d;&#x8d39;&#x5'.'206;&#x4eab;&#x'.'ff0c;&#x8bf7;&#x5'.'2ff;&#x4ece;&#x5176;&#x4ed6;&'.'#x7f51;&#'.'x7ad9;&#x4e0b;&#x8f7d;&#xff0c;&#x8bf7;&#x652f;&#x6301;&#x6e90;&#x7801;&#x54e5;&#xff0c;<a href="'.base64_decode('aHR0cDovL3d3dy55bWc2LmNvbS90aHJlYWQtOTM5MC0xLTEuaHRtbA==').'">&#x70b9;&#x51fb;&#x524d;&#x5f80;&#x6e90;&#x7801;&#x54e5;&#x514d;&#'.'x8d39;&#'.'x4e0b;&#'.'x8f7d;</a>&#x672c;&#x'.'5957;&#x6a21'.';&#x7248;';exit;}
runquery($sql);

$finish = TRUE;
?>