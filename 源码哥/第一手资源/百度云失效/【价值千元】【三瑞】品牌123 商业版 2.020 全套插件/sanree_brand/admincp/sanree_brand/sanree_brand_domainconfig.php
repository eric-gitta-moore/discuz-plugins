<?php

/**
 *      [Sanree] (C)2012-2099 Sanree Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: sanree_brand_domainconfig.php $
 */

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}

$do = $_G['sr_do'];
$doarray = array('list');
$do = !in_array($do,$doarray) ? 'list' : $do;

if ($do == 'list') {

		showsubmenu($menustr);
		$domain = trim($config['domain']);
		if (empty($domain)) {
		
			cpmsg($langs['notdomain'], 'action=plugins&operation=config&do='.$plugin['pluginid'], 'error');
			
		}	
		$langs['domaintipshow']= str_replace('{domain}',$domain,$langs['domaintipshow']);
        echo $langs['domaintipshow'];
		$filename =  DISCUZ_ROOT.'/source/plugin/sanree_brand/domain.php';
		$handle = fopen($filename, "r");
		$contents = fread($handle, filesize ($filename));
		fclose($handle);
		$contents = str_replace('{branddomain}',$domain,$contents);
		$contents = str_replace('{mdomain}',$mdomain,$contents);
		$contents = str_replace('{redomain}', $redomain,$contents);
		$contents = str_replace("\r\n","\r",$contents);
		sysfilecache($contents, "sanree_brand_domain.php");
			
}
//From:www_YMG6_COM
?>