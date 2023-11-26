<?php
/*
 *源码哥：www.ymg6.com
 *更多商业插件/模版免费下载 就在源码哥
 *本资源来源于网络收集,仅供个人学习交流，请勿用于商业用途，并于下载24小时后删除!
 *如果侵犯了您的权益,请及时告知我们,我们即刻删除!
 */

	if(!defined('IN_DISCUZ')) {
		exit('Access Denied');
	}
 	require_once 'tiny.common.inc.php';
 

	if(isset($_GET['paper']) && intval($_GET['paper'])){
		if($config['show']==2 || $config['show']==3){
			$include_pg = true;
			include "paper.inc.php";
		}else{
			die('&#x6CA1;&#x6709;&#x5F00;&#x542F;&#x6A21;&#x62DF;&#x8003;&#x8BD5;&#x529F;&#x80FD;,&#x8BF7;&#x7EC3;&#x4E60;&#x7BA1;&#x7406;&#x5458;!');
		}
	}
	else if(isset($_GET['test']) && intval($_GET['test'])){
		if($config['show']==1 || $config['show']==3){
			$include_pg = true;
			include "test.inc.php";
		}
		else{
			die('&#x6CA1;&#x6709;&#x5F00;&#x542F;&#x9010;&#x9898;&#x7EC3;&#x4E60;&#x8003;&#x8BD5;&#x529F;&#x80FD;,&#x8BF7;&#x7EC3;&#x4E60;&#x7BA1;&#x7406;&#x5458;!');
		}
	}
	else{
		include "list.inc.php";
	}
 