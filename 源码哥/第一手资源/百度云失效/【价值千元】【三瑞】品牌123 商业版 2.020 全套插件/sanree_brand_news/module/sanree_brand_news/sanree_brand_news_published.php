<?php

/**
 *      [fx8.cc] (C)2014-2017 ymg6.Com.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: sanree_brand_news_published.php sanree $
 */

if(!defined('IN_DISCUZ')) {
	exit('2014072820Zq5a00tJ50||7908||1402027202');
}

if (!$_G['uid']) {

	showmessage(srlang('nologin'), '', array(), array('login' => true));
	
}
if (!in_array($_G['group']['groupid'], $addgroup)) {

	showmessage($stopaddtip);
	
}
$brandcount = C::t('#sanree_brand#sanree_brand_businesses')->count_by_wherec(array('t.uid='.$_G['uid'],'c.status=1','t.status=1'));
if ($brandcount<1) {

	$href = $allurl;
	$href = str_replace("'", "\'", $href);	
	$extra = array(
		'showdialog' => false,
		'extrajs' => "<script type=\"text/javascript\" reload=\"1\">setTimeout(\"window.location.href ='".$href."';\", 3000);</script>"
	);
    showmessage(news_modlang('pleaseaddbrand'),'',array(),$extra);
	
}

$nid=intval($_G['sr_nid']);
$bid=intval($_G['sr_bid']);
if ($nid>0) {

	$result = C::t('#sanree_brand_news#sanree_brand_news')->getusername_by_nidanduid($_G['uid'], $nid);
	if (!$result) {
	
		showmessage(news_modlang('nonid'));
		
	}
	$result['startdate'] = empty($result['startdate']) ? '' : dgmdate($result['startdate']);
	$result['enddate'] = empty($result['enddate']) ? '' : dgmdate($result['enddate']);   
	$pid= intval($result['pid']); 
	$tid= intval($result['tid']);
	 
} else {

    $result= array();
    $result[isshow] = 1;
	$result[bid] = $bid;
		
}

if(submitcheck('postsubmit')) {

	$cateid=intval($_G['sr_cateid']);
	$aid = array();
	$ishome = intval($_G['sr_ishome']);
	foreach($_G['sr_attachnew'] as $key => $value) {
	
		$aid[] = $key;
			
	}

    $bid = intval($_G['sr_bid']);	
	$newsname=dhtmlspecialchars(trim($_G['sr_newsname']));
	$keywords=dhtmlspecialchars(trim($_G['sr_keywords']));
	$description=dhtmlspecialchars(trim($_G['sr_description']));
	$content =dhtmlspecialchars(trim($_G['sr_content'])); 
	$brand = C::t('#sanree_brand#sanree_brand_businesses')->usergetbusinesses_by_bid($bid, $_G[uid]);	
	if (!$brand) {
	
		showmessage(srlang('error_bid'));
		
	}
	if(dstrlen($content) > 4000) {
	
		showmessage(news_modlang('post_content_toolong'));
		
	}
	if ($cateid<1) {
	
		showmessage(srlang('nocateid'));
		
	}	
	if (empty($newsname)) {
	
		showmessage(news_modlang('noname'));
		
	}
	$st = $_G['sr_st'];
	$extrastr = '';
	if (!empty($st)) {
	
		$extrastr ='&st='.$st;
		
	}	
	if ($nid<1) {
	
	    $sendcount = C::t('#sanree_brand_news#sanree_brand_news')->count_by_where(" AND bid='$bid'");
		$groupmaxnews = news_getgroupmax($bid);
		if ($sendcount> $groupmaxnews) {
		
			showmessage(news_modlang('ismaxnews'));
			
		}	
		$count=C::t('#sanree_brand_news#sanree_brand_news')->count_by_where(" AND name='$newsname'");
		if ($count>0) {
		
			showmessage(news_modlang('ishavecom'));
			
		}
		$url_forward =  srreferer() ? $_G['referer'] : 'plugin.php?id=sanree_brand_news&mod=mynews&view=index'.$extrastr;
		
	} else {
	
		$url_forward =  srreferer() ? $_G['referer'] : 'plugin.php?id=sanree_brand_news&mod=mynews&view=index'.$extrastr;
		
	}
	if ($ishome<1) {
	
		$ishome = $aid[0];
		
	}

	$setarr = array();
	$setarr['cateid'] = $cateid;
	$setarr['aids'] = implode($aid, '|');
	$setarr['content'] = $content;
	$setarr['bid'] = $bid;
	$setarr['name'] = $newsname;
	$setarr['keywords'] = $keywords;
	$setarr['description'] = $description;
	$setarr['homeaid'] = $ishome;	
	require_once libfile('function/post');
	$att = getattach(0, 0, $ishome);
	$setarr['smallpic'] = $att[attachs]['unused'][0][attachment];
	$setarr['startdate'] = !empty($_G['sr_startdate']) ? strtotime($_G['sr_startdate']) : 0;
	$setarr['enddate'] = !empty($_G['sr_enddate']) ? strtotime($_G['sr_enddate']) : 0;		
	$setarr['displayorder'] = intval(trim($_G['sr_displayorder']));
	$setarr['isshow'] = intval(trim($_G['sr_isshow']));
	$extra = array();

	if ($_G['inajax']) {

	    $href = $url_forward;
		$href = str_replace("'", "\'", $href);	
		$url_forward = '';	
		$extra = array(
			'showdialog' => false,
			'extrajs' => "<script type=\"text/javascript\" reload=\"1\">hideWindow('publisheddlg', 0, 1);setTimeout(\"window.location.href ='".$href."';\", 3000);</script>"
		);
		
	}
	if ($nid<1) {	
			
	    $setarr['ip'] = $_G['clientip'];
		$setarr['dateline'] = TIMESTAMP;
		$setarr['status'] = $config["isshen"] == 1 ? 0 : 1;	
		$setarr['status'] = (in_array($groupid, $nochkgroup)) ? 1 : $setarr['status'];
		
		$setarr['uid'] = $_G['uid'];
		$nid = C::t('#sanree_brand_news#sanree_brand_news')->insert($setarr, TRUE);
		news_fixthread($nid);
		
		if (in_array($groupid, $nochkgroup)) {
			attention_information($nid, 'news');
		    showmessage(news_modlang('okmessage'),$url_forward,array(),$extra);
		
		} else {
		
			if ( $config["isshen"] == 1 ) {
			
				showmessage(srlang('yesmessage'),$url_forward,array(),$extra);
				
			}
			else {
			
				
				attention_information($nid, 'news');
				showmessage(news_modlang('okmessage'),$url_forward,array(),$extra);
				
			}
		}		
	}
	else {
	
		C::t('#sanree_brand_news#sanree_brand_news')->update($nid,$setarr);
		news_fixthread($nid);
		showmessage(srlang('editmessage'),$url_forward,array(),$extra);
		
	}	
}
else {
	$category_list = array();
	$category = news_loadcache('usercate');
	foreach($category as $value) {
	
		$category_list[] = $value;
		
	}
	$orderby = 'displayorder,dateline desc';
	$where = array();
	$where[] = 't.uid='.$_G['uid'];
	$where[] = 'c.status=1';
	$where[] = 't.status=1';
	$mybrandlist = C::t('#sanree_brand#sanree_brand_businesses')->fetch_all_by_searchc($where, $orderby, 0, 1000);	
	$selectlist = array();
	foreach($mybrandlist as $data) {
		$selectlist[] =array( 'bid'=> $data['bid'], 'name' => $data['name'], 'selected' => '');
	}			
	$navtitle = srlang('dengjititle');
	$addteltitle = $config['djtitle'] ? $config['djtitle'] : news_modlang('post_new_news');
	$allowfastpost = true;
	$allowpostattach = true;
	$_G[fid] = $bindingforum;
	if ($_G['setting']['version']=='X2') {
	
		require_once DISCUZ_ROOT.'./source/plugin/sanree_brand_news/X2/function/function_upload.php';
		$swfconfig = getuploadconfig($_G['uid'], $_G['fid']);
		$thisconfig= array();
		$thisconfig[jspath] = 'source/plugin/sanree_brand_news/X2/js/';
		$thisconfig[imgdir] = 'source/plugin/sanree_brand_news/X2/images/';
		$thisconfig[cookiepre] = $_G[config][cookie][cookiepre];
		$thisconfig[cookiedomain] = $_G[config][cookie][cookiedomain];
		$thisconfig[cookiepath] = $_G[config][cookie][cookiepath];
		$thisconfig[file_types] = $swfconfig[attachexts][ext];
		$thisconfig[file_types_description] = $swfconfig[attachexts][depict];
	
	} else {
	
		require_once libfile('function/upload');
		$swfconfig = getuploadconfig($_G['uid'], $_G['fid']);
		$thisconfig= array();
		$thisconfig[jspath] = $_G[setting][jspath];
		$thisconfig[imgdir] = 'static/image/common';
		$thisconfig[cookiepre] = $_G[config][cookie][cookiepre];
		$thisconfig[cookiedomain] = $_G[config][cookie][cookiedomain];
		$thisconfig[cookiepath] = $_G[config][cookie][cookiepath];
		$thisconfig[file_types] = $swfconfig[attachexts][ext];
		$thisconfig[file_types_description] = $swfconfig[attachexts][depict];			
		
	}

	if ($result[isshow]==1) {
	
		$isshowst = ' checked="checked" ';
		$notshowst = '';
		
	} else {
	
		$isshowst = '';
		$notshowst = ' checked="checked" ';
		
	}
	$result['content'] = str_replace('&amp;', '&',$result['content']);
	include templateEx($plugin['identifier'].':'.$template."/".$mod);
	
}
//From:www_YMG6_COM
?>