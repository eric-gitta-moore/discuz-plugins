<?php

/**
 *      [fx8.cc] (C)2014-2017 ymg6.Com.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: function_core.php sanree $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

function guestbook_getgroupmax($bid) {
	$brandresult = C::t('#sanree_brand#sanree_brand_businesses')->getbusinesses_by_bid($bid);
    $groupid= $brandresult['groupid'];
	$group = C::t('#sanree_brand#sanree_brand_group')->get_by_groupid($groupid);
	if ($group) {
	    $brandmoduleresult = C::t('#sanree_brand#sanree_brand_group_module')->fetch_by_groupid($group[groupid]);
		return intval($brandmoduleresult['maxguestbook']);
	}
	return 20;
}

function guestbook_modlang($word) {
	return lang('plugin/sanree_brand_guestbook', $word);
}
function guestbook_htmlspecialchars($string){
	return str_replace(array('\"','&amp;', '&quot;', '&lt;', '&gt;'), array('"','&', '"', '<', '>') , $string);
}
function guestbook_getmodeurl($value){
    global $_G;
	$config = $_G['cache']['plugin']['sanree_brand_guestbook']; 
	$is_rewrite = $config['is_rewrite'];
	if ($is_rewrite) {
		$keylist = array('tid');
		$tid  = $value['bid'];
		$urlgoodsusermode = empty($config['urlguestbookusermode']) ? 'guestbook-{tid}.html': $config['urlguestbookusermode'];
		foreach($keylist as $line) {
			$urlgoodsusermode = str_replace("{".$line."}",$$line ,$urlgoodsusermode);
		}
		return $urlgoodsusermode;
	}
	return 'plugin.php?id=sanree_brand_guestbook&mod=userguestbook&tid='.$value['bid'];
}

function guestbook_notice($guestbookid, $act) {
    global $_G;
	if (in_array($act, array('reservation' , 'handle'))) {
		$guestbookids = array();
		if (!is_array($guestbookid)) {
		
			$guestbookids[] = $guestbookid;
			
		} else {
		
			$guestbookids = $guestbookid;
			
		}	
		foreach ($guestbookids as $iguestbookid) {
		
			$row = C::t('#sanree_brand_guestbook#sanree_brand_guestbook')->fetch_first_by_guestbookid($iguestbookid);
			if ($row) {
			
			    $brand = C::t('#sanree_brand#sanree_brand_businesses')->getusername_by_bid($row['bid']);
				if ($act== 'reservation') {
				
				    $lstr1 = guestbook_modlang('notice_str1');
					$url = 'plugin.php?id=sanree_brand_guestbook&mod=myguestbook&view=chuli&guestbookid='.$guestbookid;
					$welcomemsgtxt=  str_replace('{url}', $url, $lstr1);
					@notification_addex($brand['uid'], 'system', $welcomemsgtxt, array(), 1);
					
				} elseif ($act== 'handle') {
				
				    $lstr2 = guestbook_modlang('notice_str2');
					$url = 'plugin.php?id=sanree_brand_guestbook&mod=myguestbook&view=show&guestbookid='.$guestbookid;
					$welcomemsgtxt=  str_replace('{url}', $url, $lstr2);
					@notification_addex($row['uid'], 'system', $welcomemsgtxt, array(), 1);	
								
				}	
				
			}
			
		}
		
	}
	
}
//From:www_YMG6_COM
?>