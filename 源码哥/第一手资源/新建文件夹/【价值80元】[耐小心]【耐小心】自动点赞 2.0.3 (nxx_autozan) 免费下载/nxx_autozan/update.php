<?php
/*
 *源   码    哥  y  m     g     6     .  c     o m
 *更多商业插件/模版免费下载 就在源     码     哥
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

runquery($sql);
$finish = true;
?>