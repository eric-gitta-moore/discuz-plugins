<?php

/**
 *      [Discuz!] (C)2001-2099 Comsenz Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: function_core.php 26648 2011-12-19 03:03:50Z zhangguosheng $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

function senddomain_notice($domainid, $act) {
    global $_G, $okdomain;
	if (in_array($act, array('domain_pass' , 'domain_pending', 'domain_refuse', 'domain_adminpass'))) {
		$domainids = array();
		if (!is_array($domainid)) {
			$domainids[] = $domainid;
		}
		else {
			$domainids = $domainid;
		}	
		foreach ($domainids as $value) {
			$row = C::t('#sanree_brand_domain#sanree_brand_domain')->get_by_domainid($value);
			if ($row) {
			
				$welcomformat = domain_modlang($act);
				$user1txt = '<a href="home.php?mod=space&amp;uid='.$row['uid'].'">'.$row['username'].'</a>';
				$turl = getburl($row);
				$nametxt = addslashes($row['domainname']);
				$adminnametxt = '<a href="home.php?mod=space&amp;uid='.$_G['uid'].'">'.$_G['username'].'</a>';
				$timetxt = dgmdate(TIMESTAMP);
				$welcomemsgtxt = str_replace('{user}', $user1txt, $welcomformat);
				$welcomemsgtxt = str_replace('{domain}', $nametxt.$okdomain, $welcomemsgtxt);
				$welcomemsgtxt = str_replace('{time}', $timetxt, $welcomemsgtxt);
				$welcomemsgtxt = str_replace('{price}', $row['price'], $welcomemsgtxt);
				$welcomemsgtxt = str_replace('{unit}', $row['creditunitname'], $welcomemsgtxt);
				$welcomemsgtxt = str_replace('{adminuser}', $adminnametxt, $welcomemsgtxt);
				$welcomemsgtxt = str_replace('{reason}', $row['reason'], $welcomemsgtxt);
				$welcomemsgtxt = nl2br(str_replace(':', '&#58;', $welcomemsgtxt));
				@notification_addex($row['uid'], 'system', $welcomemsgtxt, array(), 1);
			
			}
		}
	}
}

function domain_modlang($word) {
	return lang('plugin/sanree_brand_domain', $word);
}

function getuserdomain($bid) {

    global $_G;
	$brand = C::t('#sanree_brand#sanree_brand_businesses')->fetch_first_bybid(intval($bid));	
	$config = $_G['cache']['plugin']['sanree_brand'];
	if (!empty($config['domain']) && $config['isbdomain']==1 && !empty($config['mdomain'])) {
		if ($brand['isallowdomain']==1 && !empty($brand['bdomain'])) {
			return 'http://'.$brand['bdomain'].'.'.$config['mdomain'].'/';
		}
	}
	return '';
		 
}

function domainfilecache($data, $file) {
	global $_G;
    $data = stripcslashes($data);
	$dir = DISCUZ_ROOT.'./data/cachedomain/';
	if(!is_dir($dir)) {
		dmkdir($dir, 0777);
	}
	if($fp = @fopen($dir.'cache_'.$file, 'wb')) {
		fwrite($fp, $data);
		fclose($fp);
	} else {
		exit('Can not write to cache files, please check directory ./data/ and ./data/cachedomain/ .');
	}
}

function makedomainbybidandbdomain($bid, $bdomain, $allowdomain) {
    $bdomain = strtolower(dhtmlspecialchars(trim($bdomain)));
	$bid = intval($bid);
	if (!empty($bdomain)) {
		$filename =  DISCUZ_ROOT.'/source/plugin/sanree_brand_domain/userdomain.php';
		$handle = fopen($filename, "r");
		$contents = fread($handle, filesize ($filename));
		fclose($handle);
		$contents = str_replace("\r\n","\r",$contents);
		$contents = str_replace('{bid}', $bid, $contents);
		$contents = str_replace('{allowdomain}', intval($allowdomain), $contents);
		domainfilecache($contents, md5($bdomain).".php");	
	}
}

function srdeletedomain($data) {
	global $okdomain;
    $deledata = array();
	if (!is_array($data)) {
		 $deledata[] = $data;
	} else {
		$deledata = $data;
	}
	foreach ($deledata as $domainid) {
		$domain = C::t('#sanree_brand_domain#sanree_brand_domain')->get_by_domainid($domainid);
		if ($domain) {
			@unlink(DISCUZ_ROOT.'./data/cachedomain/cache_'.md5($domain['domainname'].$okdomain).'.php');
		}
	}

}

function makedomain($id) {
	global $okdomain;
    $id = intval($id);
	$data = C::t('#sanree_brand_domain#sanree_brand_domain_brand2domain')->get_by_id($id);
	if ($data['bid']) {
	
		$info = C::t('#sanree_brand_domain#sanree_brand_domain')->get_by_domainid($data['domainid']);
		if ($info) {

			makedomainbybidandbdomain($data['bid'], $info['domainname'].$okdomain, $info['status'] && $data['status'] && $data['isshow']);	
			
		}
	}
}

function chkdomain($domain, $out = TRUE) {

	global $_G, $langs, $config;
	if (!$config) {
		$config = $_G['cache']['plugin']['sanree_brand_domain'];	
	}
	$filterdomainlisttmp = $config['filterdomainlist'];
	$mdomain = $config['mdomain'];
	$flist = explode("\r\n", $filterdomainlisttmp);
	$filterdomainlist = array();
	foreach($flist as $row) {
	
		$line = trim($row);
		if ($line) {
			$filterdomainlist[] = $line;
		}
		
	}	
	$bdomain = strtolower(dhtmlspecialchars(trim($domain)));
	if (empty($bdomain)) {
	
		return true;
		
	}	
	if ($bdomain==$mdomain || strpos($bdomain, $mdomain)) {
	
		if ($out) {
		    
			if (defined('IN_ADMINCP')) {
				cpmsg_error($langs['error_same_mdomain']);
			} else {
				showmessage(domain_modlang('error_same_mdomain'));
			}
			
		}		
		return false;
		
	}	
	if ($bdomain=='.') {
	
		if ($out) {
		    
			if (defined('IN_ADMINCP')) {
				cpmsg_error($langs['error_same_mdomain']);
			} else {
				showmessage(domain_modlang('error_same_mdomain'));
			}
			
		}			
		return false;
		
	}
	if (strlen($bdomain)>1 && $bdomain[strlen($bdomain)-1]=='.') {
	
		if ($out) {
		    
			if (defined('IN_ADMINCP')) {
				cpmsg_error($langs['error_same_mdomain']);
			} else {
				showmessage(domain_modlang('error_same_mdomain'));
			}
			
		}		
		return false;
		
	}			
	if (!preg_match("/^[a-z]{1}([a-z0-9]|[._-]){1,19}$/", $bdomain)) {
	
		if ($out) {
		    
			if (defined('IN_ADMINCP')) {
				cpmsg_error($langs['error_same_mdomain']);
			} else {
				showmessage(domain_modlang('error_same_mdomain'));
			}
			
		}			
		return false;
		
	}	
	if (in_array($bdomain, $filterdomainlist)) {
	
		if ($out) {
		    
			if (defined('IN_ADMINCP')) {
				cpmsg_error($langs['error_same_mdomain']);
			} else {
				showmessage(domain_modlang('error_same_mdomain'));
			}
			
		}				
		return false;
		
	}
	return true;
	
}
//From:www_YMG6_COM
?>