<?php

/**
 *      [fx8.cc] (C)2014-2017 ymg6.Com.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: class_sanree_brand_menu.php 2014-07-29 10:20:00 sanree checkedby fx8.cc $
 */

if(!defined('IN_DISCUZ')) {
	exit('');
}

class sanree_brand_menu{
     
	var $_category_list =array();
	var $_brand_header;
	var $_brand_header_one;
	var $_identifier;
	
	function __construct($identifier){
	
		$this->sanree_brand_menu($identifier);
				
	}
	
	function sanree_brand_menu($identifier) {
	
		$this->_identifier = $identifier;
		
	}
	
	function getmenu($brandresult, $active) {
	
		global $_G, $template, $bodycss, $ishideheader,$allurl;
		$group = C::t('#sanree_brand#sanree_brand_group')->get_by_groupid($brandresult['groupid']);
		global $myhomeurl, $referer, $addgroup; 
		$tmpconfig = $_G['cache']['plugin']['sanree_brand'];
		$allowsyngroup = intval($tmpconfig['allowsyngroup']);
		$isshowordinary = intval($tmpconfig['isshowordinary']);
		!defined('sr_brand_JS') && define('sr_brand_JS', sr_brand_TPL.'/'.$tmpconfig['template'].'/js');
		!defined('SANREE_BRAND_TEMPLATE') && define('SANREE_BRAND_TEMPLATE', sr_brand_TPL.'/'.$tmpconfig['template']);
		$allurl = gethomeurl();
		$myhomeurl = !empty($brandresult['brandno']) ? getbrandnourl($brandresult['brandno']) : getmyburl_by_bid($brandresult['bid']);
		$referer = urlencode($myhomeurl);
		if (!isset($_G['cache']['sanree_brand_topmenu'])||!is_array($_G['cache']['sanree_brand_topmenu'])) {
		
			sanreeupdatecache('menu');
			
		}	
		$menu = sanreeloadcache('topmenu');
		$headermenulist = array();
		$headermenulist['index'] = array('url'=> getburl($brandresult), 'title' => srlang('brandindex'), 'class' =>' class="normal"');
		($brandresult['allowalbum']==1)&& $headermenulist ['myalbum']= array('url'=> getalbumurl($brandresult['bid']), 'title' => srlang('myalbum'), 'class' =>' class="normal"');
		($allowsyngroup==1&&intval($group['allowsyngroup'])==1&&$brandresult['syngrouptid'])&& $headermenulist['dzgroup'] = array('url'=> 'forum.php?mod=group&amp;fid='.$brandresult['syngrouptid'], 'title' => srlang('dzgroup'), 'class' =>' class="normal"');
		
		hookscript('sanreebrandusermenu', 'global', 'funcs', array('bid' => $brandresult['bid']), 'sanreebrandusermenu');	
		if ($_G['sanree_brand_menus']) {
		
			foreach($_G['sanree_brand_menus'] as $row) {
			
				$row['url'] = str_replace('{tid}',$brandresult['tid'],$row['url']);
				$row['url'] = str_replace('{bid}',$brandresult['bid'],$row['url']);
				$row['url'] = str_replace('{pid}',$brandresult['pid'],$row['url']);
				$headermenulist[$row['name']] = $row;
				
			}

		}
		($isshowordinary==1)&& $headermenulist['ordinary'] = array('url'=> 'forum.php?mod=viewthread&amp;tid='.$brandresult['tid'], 'title' => srlang('ordinary'), 'class' =>' class="normal"');		
		foreach($menu as $row) {
		
			$row['url'] = str_replace('{tid}',$brandresult['tid'],$row['url']);
			$row['url'] = str_replace('{bid}',$brandresult['bid'],$row['url']);
			$row['url'] = str_replace('{pid}',$brandresult['pid'],$row['url']);
			$headermenulist['menu'.$row[id]] = $row;
			
		}
		$headermenulist[$active] && $headermenulist[$active]['class'] = ' class="active"';
		
		$headermenulists = $headermenulist;
		$headermenulist = array();
		$menuorder = C::t('#sanree_brand#sanree_brand_menu_order')->fetch_all();
		asort($menuorder);

		foreach($menuorder as $key => $row) {
			
			if($headermenulists[$key]) {
				
				$headermenulist[$key] = $headermenulists[$key];
			
			}
		}
		
		
		if (intval($_G['uid']) === intval($brandresult['uid'])) {
		
			define('IN_BRAND_USER', TRUE);
			hookscript('sanreebrandmanagemenu', 'global', 'funcs', array('bid' => $brandresult['bid']), 'sanreebrandmanagemenu');
			$managemenulist = array();
			$_G['sanree_brand_managemenus'][] = array(
				'displayorder'=> 9999, 
				'window' => 0,
				'name'=>'', 
				'title'=> '', 
				'url'=> '',
				'class' => '',
				'image' => 'source/plugin/sanree_brand/tpl/good/images/add.png'
			);			
			if ($_G['sanree_brand_managemenus']) {
			
				foreach($_G['sanree_brand_managemenus'] as $row) {
				
					$row['url'] = str_replace('{tid}',$brandresult['tid'],$row['url']);
					$row['url'] = str_replace('{bid}',$brandresult['bid'],$row['url']);
					$row['url'] = str_replace('{pid}',$brandresult['pid'],$row['url']);
					$managemenulist[] = $row;
				
				}
				$ncount = count($managemenulist);
				$mod = $ncount % 10;
				$mt = intval($ncount / 10);
				$oneh = 100;
				if ($mt == 0) {
					$ih = $oneh;
				} else {
				    if ($mod == 0) {
						$ih = $mt * $oneh;
					} else {
					    $ih = ($mt + 1) * $oneh;
					}
				}
				$ih += 10;
				$managemenulist = $this->array_sort($managemenulist, 'displayorder');
	
			}
			
		}

		$allowtemplate = intval($group['allowtemplate']);
		if ($allowtemplate==1) {		
			$templateconfig = unserialize($brandresult['templateconfig']);
			$bodystyle = $templateconfig['bodystyle']; 
			$bodycss = '';
			if ($bodystyle) {
				if (intval($bodystyle['isuse'])==1) {
					$bodycss="body {\r\n";
					if ($bodystyle['notbackimg']==1) {
						if (!empty($bodystyle['backgroundimage'])) {
							$bodycss.= "background-image:url('".$_G['setting']['attachurl'].'category/'."$bodystyle[backgroundimage]');\r\n";
						}				
					} else{
						$bodycss.= "background:none;\r\n";
					}
					if (!empty($bodystyle['backgroundrepeat'])) {
						$bodycss.= "background-repeat:$bodystyle[backgroundrepeat];\r\n";
					}
					if (!empty($bodystyle['backgroundcolor'])) {
						$bodycss.= "background-color:$bodystyle[backgroundcolor];\r\n";
					}
					if (!empty($bodystyle['backgroundattachment'])) {
						$bodycss.= "background-attachment:$bodystyle[backgroundattachment];\r\n";
					}	
					if (!empty($bodystyle['backgroundpositionx'])&&!empty($bodystyle['backgroundpositiony'])) {
						$bodycss.= "background-position:$bodystyle[backgroundpositionx] $bodystyle[backgroundpositiony];\r\n";
					}				
					$bodycss.="}";
					$ishideheader = intval($bodystyle['ishideheader']);
				}
			}
			if ($ishideheader==1) {
			
				$appVer = $_G['setting']['version'];
				include templateEx($this->_identifier.':'.$template.'/header_one_'.$appVer);
				
			}	
		} else {
		
			$ishideheader= 0;
			
		}
		include templateEx($this->_identifier.':'.$template.'/header');
		$this->_brand_header = $brand_header;
		$this->_brand_header_one = $brand_header_one;
	}
	
	function array_sort($arr, $keys, $type = 'asc') { 
	
		$keysvalue = $new_array = array();
		foreach ($arr as $k=>$v){
			$keysvalue[$k] = $v[$keys];
		}
		if($type == 'asc') {
			asort($keysvalue);
		} else {
			arsort($keysvalue);
		}
		reset($keysvalue);
		foreach ($keysvalue as $k=>$v) {
			$new_array[$k] = $arr[$k];
		}
		return $new_array; 
		
	} 
}
//From:www_YMG6_COM
?>
