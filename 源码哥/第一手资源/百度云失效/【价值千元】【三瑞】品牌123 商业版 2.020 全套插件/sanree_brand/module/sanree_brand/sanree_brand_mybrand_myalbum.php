<?php

/**
 *      [fx8.cc] (C)2014-2017 ymg6.Com.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: sanree_brand_mybrand_myalbum.php sanree $
 */
if(!defined('IN_DISCUZ')) {
	exit('');
}

if (!$_G['uid']) {

	showmessage(srlang('nologin'), '', array(), array('login' => true));
	
}

if ($isalbum!=1) {
	showmessage(srlang('stopalbumtip'));
}

if (!in_array($_G['group']['groupid'],$albumgroup)) {

	showmessage(srlang('stopalbumgrouptip'));
	
}
$st = $_G['sr_st'];
$starray = array('album_category', 'album');
$starrayv= array(1, 0, -1);;
$st = !in_array($st, $starray) ? 'album_category' : $st;
$stactives[$st] = ' class="a"';
$extra = '&view='.$view;
$extra .= '&st='.$st;
$bid = intval($_G['sr_bid']);
$extra .= '&bid='.$bid;
$brandresult = C::t('#sanree_brand#sanree_brand_businesses')->getusername_by_bidanduid($_G['uid'], $bid);
if (!$brandresult) {

	showmessage(srlang('nobrand'));
	
}
if ($brandresult['status']!=1) {
	showmessage(srlang('nostatus'));
}
if ($brandresult['allowalbum']!=1) {
	showmessage(srlang('noallowalbum'));
}

$brandresult['group'] = getgroup($brandresult['groupid']);
$brandresult['group']['grouplogo'] = $brandresult['group']['grouplogo'] ? fiximage($brandresult['group']['grouplogo']) : 'source/plugin/sanree_brand/tpl/good/images/vip0.gif';  
$brandresult['group']['maxalbumcategorytip'] = str_replace('{maxalbumcategory}',$brandresult['group']['maxalbumcategory'],srlang('maxalbumcategorytip'));
$brandresult['group']['maxalbumtip'] = str_replace('{maxalbum}',$brandresult['group']['maxalbum'],srlang('maxalbumtip'));
$brandresult['url'] = getburl($brandresult);

if ($st == 'album_category') {

    if(submitcheck('postsubmit')) {
	
		foreach($_G['sr_album_displayorder'] as $id => $title) {
			$setarr=array(
				'displayorder' => intval($_G['sr_album_displayorder'][$id]),
			);
			C::t('#sanree_brand#sanree_brand_album_category')->update($id,$setarr);
		}
		$extra = array();
		$_G['inajax'] = 1;
		$url_forward = srreferer() ? getburl_by_bid($bid) : 'plugin.php?id=sanree_brand&mod=mybrand&view=myalbum&st=album_category&bid='.$bid;
		if ($_G['inajax']) {
	
			$href = $url_forward;
			$href = str_replace("'", "\'", $href);	
			$url_forward = '';	
			$extra = array(
				'showdialog' => true,
				'extrajs' => "<script type=\"text/javascript\" reload=\"1\">//hideWindow();\r\nsetTimeout(\"window.location.href ='".$href."';\", 3000);</script>"
			);
			
		}				
		showmessage(srlang('savesucceed'), $url_forward, array(), $extra);
		
	} else {
		$perpage = 15;
		$page 		= isset($_G['sr_page']) ? intval($_G['sr_page']) : 1;
		$page 		= max(1, intval($page));
		$start 		= ($page - 1) * $perpage;
		$start 		= max(0, $start);
		$multi 		= '';
		$where = array();
		$where[] = 'uid='.$_G['uid'].' AND bid='.$bid;
		$count = C::t('#sanree_brand#sanree_brand_album_category')->count_by_wherec($where);
		if ($count>0) {
		
			require_once libfile('function/discuzcode');
			$orderby = 'displayorder,dateline desc';	
			$datalist = C::t('#sanree_brand#sanree_brand_album_category')->fetch_all_by_searchc($where, $orderby, ($page - 1) * $perpage, $perpage);
			$list = array();
			$wherealbum = array();
			$wherealbum[] = 'uid='.$_G['uid'];
			$wherealbum[] = 'catid = -1';	
			$pic_tip_format = srlang('pic_tip_format');
			$piccount =  C::t('#sanree_brand#sanree_brand_album')->count_by_wherec($wherealbum);
			foreach($datalist as $value) {
			
				$wherealbumsub = array();
				$wherealbumsub[] = 'uid='.$_G['uid'];		
				$wherealbumsub[] = 'catid = '.$value['catid'];
				$piccount =  C::t('#sanree_brand#sanree_brand_album')->count_by_wherec($wherealbumsub);
				$brandname  =  C::t('#sanree_brand#sanree_brand_businesses')->getname_by_bid($value['bid']);
				if ($isalbumthumb==1) {
					$value['pic'] = sr_albumimage($value['pic'], 120, 120);
				} else {				
					$value['pic']= empty($value['pic']) ? 'static/image/common/nophoto.gif' : $_G['setting']['attachurl'].'album/'.$value['pic'];
				}				
				$list[] =  array('displayorder'=> $value['displayorder'],'brandname'=> $brandname,'description' => $value['description'],'catid'=> $value['catid'],'uid' => $value['uid'],'name' => $value['catname'], 'id' => $value['catid'], 'pic' => $value['pic'], 'piccount' => str_replace('{n}', $piccount, $pic_tip_format));
			}
	
			$murl= 'plugin.php?id=sanree_brand&mod=mybrand'.$extra;
			$multi = multi ( $count, $perpage, $page, $murl);
			
		}	
	}

}
elseif ($st == 'album') {
		
	$brandgroup = C::t('#sanree_brand#sanree_brand_group')->get_by_groupid($brandresult['groupid']);
	$allowdeletealbum = intval($brandgroup['allowdeletealbum']);	
	if(submitcheck('postsubmit')) {
	
		foreach($_G['sr_album_displayorder'] as $id => $title) {
			$setarr=array(
				'ishome' => intval($_G['sr_album_ishome'][$id]),
				'displayorder' => intval($_G['sr_album_displayorder'][$id]),
			);
			C::t('#sanree_brand#sanree_brand_album')->update($id,$setarr);
		}
		$extra = array();
		$_G['inajax'] = 1;
		$url_forward = srreferer() ? getburl_by_bid($bid) : 'plugin.php?id=sanree_brand&mod=mybrand&view=myalbum&st=album&bid='.$bid;
		if ($_G['inajax']) {
	
			$href = $url_forward;
			$href = str_replace("'", "\'", $href);	
			$url_forward = '';	
			$extra = array(
				'showdialog' => true,
				'extrajs' => "<script type=\"text/javascript\" reload=\"1\">//hideWindow();\r\nsetTimeout(\"window.location.href ='".$href."';\", 3000);</script>"
			);
			
		}				
		showmessage(srlang('savesucceed'),$url_forward, array(), $extra);
		
	} else {
	
		$perpage = 15;
		$page 		= isset($_G['sr_page']) ? intval($_G['sr_page']) : 1;
		$page 		= max(1, intval($page));
		$start 		= ($page - 1) * $perpage;
		$start 		= max(0, $start);
		$multi 		= '';
		$where = array();
		$catid  	= intval($_G['sr_catid']);
		$catid = $catid<1 ? -1 : $catid;
		if ($catid>0) {
			$extra .= '&catid='.$catid;
		}
		$catname = $catid<1 ? '' : C::t('#sanree_brand#sanree_brand_album_category')->fetch_catname_by_catid($catid);
		$where[] = 'a.uid='.$_G['uid'];
		$where[] = 'a.bid='.$bid;
		if ($catid>0) {
			$where[] = 'a.catid='.$catid; 
		}
		$count = C::t('#sanree_brand#sanree_brand_album')->count_by_wherec($where);
		if ($count>0) {
		
			require_once libfile('function/discuzcode');
			$orderby = 'a.ishome desc,a.displayorder,a.albumid desc';	
			$datalist = C::t('#sanree_brand#sanree_brand_album')->fetch_all_by_searchc($where, $orderby, ($page - 1) * $perpage, $perpage);
			$list = array();
			foreach($datalist as $value) {
			
				$ishomestr = $value['ishome']==1 ? ' checked="checked"':'';
				if ($isalbumthumb==1) {
					$value['thumbpic'] = sr_albumimage($value['pic'], 120, 120);
				} else {
					$value['thumbpic']= empty($value['pic']) ? 'static/image/common/nophoto.gif' : $_G['setting']['attachurl'].'album/'.$value['pic'];
				}		
				$value['pic']= empty($value['pic']) ? 'static/image/common/nophoto.gif' : $_G['setting']['attachurl'].'album/'.$value['pic'];
				$list[] =  array('albumid' => $value['albumid'],'displayorder' => $value['displayorder'],'ishomestr'=> $ishomestr,'ishome' =>  $value['ishome'],'description' => $value['description'],'catid'=> $value['catid'],'uid' => $value['uid'],'name' => $value['name'], 'id' => $value['catid'], 'pic' => $value['pic'], 'thumbpic' => $value['thumbpic']);
			}
			$murl= 'plugin.php?id=sanree_brand&mod=mybrand'.$extra;
			$multi = multi ( $count, $perpage, $page, $murl);
			
		}

	}
}
include templateEx($plugin['identifier'].':'.$template."/".$mod.'_'.$view);
?>