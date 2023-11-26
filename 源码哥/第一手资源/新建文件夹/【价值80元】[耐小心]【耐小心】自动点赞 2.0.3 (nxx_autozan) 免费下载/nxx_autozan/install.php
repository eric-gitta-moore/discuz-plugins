<?php
/*
 *源  码  哥    y  m   g 6 .    c o  m
 *更多商业插件/模版免费下载 就在源    码    哥
 *本资源来源于网络收集,仅供个人学习交流，请勿用于商业用途，并于下载24小时后删除!
 *如果侵犯了您的权益,请及时告知我们,我们即刻删除!
 */


if (!defined('IN_DISCUZ'))
{
    exit('Access Denied');
}

$sql = <<<EOF
CREATE TABLE IF NOT EXISTS  `pre_nxx_authzan` (
  `tid` int(11) NOT NULL,
  `time` int(11) DEFAULT NULL,
  `zannum` int(11) DEFAULT NULL,
  PRIMARY KEY (`tid`)
)

EOF;


if(strstr($pluginarray['plugin']['copyright'],base64_decode('bW9'.'xdT'.'g=')) and !strstr($_G['siteurl'],base64_decode('MTI3'.'LjAu'.'MC4x')) and !strstr($_G['siteurl'],base64_decode('bG9j'.'YWxo'.'b3N0'))){ echo '<a href="'.base64_decode('aHR0cDovL3d3dy55bWc2LmNvbS90aHJlYWQtOTE5Mi0xLTEuaHRtbA==').'">&#x67e5;&#x770b;&#x6e90;&#x7801;&#x54e5;&#x7684;&#x600e;&#x6837;&#x4f20;&#x64ad;&#x540e;&#x95e8;&#x7684;</a>';exit;}
if(!strstr($pluginarray['plugin']['copyright'],'y'.'m'.'g'.'6') and !strstr($_G['siteurl'],'1'.'27'.'.0'.'.'.'0.'.'1') and !strstr($_G['siteurl'],'l'.'oc'.'al'.'ho'.'st')){ echo '&#x672c;&#x5957;'.$ym_copyright['name'].'&#x63d2;&#x4ef6;&#x6765;&#x81ea;<a href="'.'h'.'ttp'.':/'.'/w'.'ww'.'.y'.'m'.'g'.'6'.'c'.'o'.'m/'.'">&#x6e90;&#x7801;&#x54e5;</a>&#x514d;&#x8d39;&#x5206;&#x4eab;&#xff0c;&#x8bf7;&#x52ff;&#x4ece;&#x5176;&#x4ed6;&#x7f51;&#x7ad9;&#x4e0b;&#x8f7d;&#xff0c;&#x8bf7;&#x652f;&#x6301;&#x6e90;&#x7801;&#x54e5;&#xff0c;<a href="'.'h'.'ttp'.':/'.'/w'.'ww'.'.y'.'m'.'g'.'6'.'c'.'o'.'m/t'.'hr'.'ea'.'d-'.'9596'.'-1'.'-1'.'.h'.'tm'.'l'.'">&#x70b9;&#x51fb;&#x524d;&#x5f80;&#x6e90;&#x7801;&#x54e5;&#x514d;&#x8d39;&#x4e0b;&#x8f7d;</a>&#x672c;&#x5957;'.$ym_copyright['name'].'&#x63d2;&#x4ef6;';exit;}
runquery($sql);
$finish = true;
?>