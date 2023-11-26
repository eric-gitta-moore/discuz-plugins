<?php

/**
 *      [fx8.cc] (C)2014-2017 ymg6.Com.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: sanree_brand_video_published.php sanree $
 */

if(!defined('IN_DISCUZ')) {
	exit('20131125098D7zaVQA8A||11681||1381384801');
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
    showmessage(video_modlang('pleaseaddbrand'),'',array(),$extra);
	
}

$cid=intval($_G['sr_cid']);
$bid=intval($_G['sr_bid']);
if ($cid>0) {

	$result = C::t('#sanree_brand_video#sanree_brand_video')->getusername_by_cidanduid($_G['uid'], $cid);
	if (!$result) {
	
		showmessage(video_modlang('nocid'));
		
	}
	$result['enddate'] = empty($result['enddate']) ? '' : dgmdate($result['enddate'], 'd');   
	$pid= intval($result['pid']); 
	$tid= intval($result['tid']);
	 
} else {

    $result= array();
    $result['isshow'] = 1;
	$result['bid'] = $bid;
	$result['width'] = '500';
	$result['height'] = '375';

}

if(submitcheck('postsubmit')) {

	$cateid=intval($_G['sr_cateid']);
    $bid = intval($_G['sr_bid']);
	$videoname=dhtmlspecialchars(trim($_G['sr_videoname']));
	$videourl=dhtmlspecialchars(trim($_G['sr_videourl']));
	$keywords=dhtmlspecialchars(trim($_G['sr_keywords']));
	$description=dhtmlspecialchars(trim($_G['sr_description']));
	$content =dhtmlspecialchars(trim($_G['sr_content'])); 
	$brand = C::t('#sanree_brand#sanree_brand_businesses')->usergetbusinesses_by_bid($bid, $_G[uid]);	
	if (!$brand) {
	
		showmessage(srlang('error_bid'));
		
	}
	$caid=intval($_G['sr_caid']);
	if (($caid < 1)&&($cid < 1)) {
	
		showmessage(video_modlang('inputsmallpic'));
		
	}	
	$attachment = C::t('#sanree_brand#sanree_brand_attachment')->fetch_firstbyaid($caid);
	if (!$attachment) {
	
		showmessage(video_modlang('inputsmallpic'));
		
	}	
	if(dstrlen($content) > 4000) {
	
		showmessage(video_modlang('post_content_toolong'));
		
	}
	if ($cateid<1) {
	
		showmessage(srlang('nocateid'));
		
	}	
	if (empty($videoname)) {
	
		showmessage(video_modlang('noname'));
		
	}
	$st = $_G['sr_st'];
	$extrastr = '';
	if (!empty($st)) {
	
		$extrastr ='&st='.$st;
		
	}	
	if ($cid<1) {
	
	    $sendcount = C::t('#sanree_brand_video#sanree_brand_video')->count_by_where(" AND bid='$bid'");
		$groupmaxvideo = video_getgroupmax($bid);
		if ($sendcount> $groupmaxvideo) {
		
			showmessage(video_modlang('ismaxvideo'));
			
		}	
		$count=C::t('#sanree_brand_video#sanree_brand_video')->count_by_where(" AND name='$videoname'");
		if ($count>0) {
		
			showmessage(video_modlang('ishavecom'));
			
		}
		$url_forward =  srreferer() ? $_G['referer'] : 'plugin.php?id=sanree_brand_video&mod=myvideo&view=index'.$extrastr;
		
	} else {
	
		$url_forward =  srreferer() ? $_G['referer'] : 'plugin.php?id=sanree_brand_video&mod=myvideo&view=index'.$extrastr;
		
	}
	if ($ishome<1) {
	
		$ishome = $aid[0];
		
	}

	$setarr = array();
	$setarr['cateid'] = $cateid;
	$setarr['content'] = $content;
	$setarr['bid'] = $bid;
	$setarr['name'] = $videoname;
	$setarr['videourl'] = $videourl;
	$setarr['keywords'] = $keywords;
	$setarr['description'] = $description;
	$setarr['displayorder'] = intval(trim($_G['sr_displayorder']));
	$setarr['width'] = intval(trim($_G['sr_width']));
	$setarr['height'] = intval(trim($_G['sr_height']));
	$setarr['isshow'] = intval(trim($_G['sr_isshow']));
	$setarr['smallpic'] = $attachment['attachment'];
	$setarr['homeaid'] = $caid;
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
	if ($cid<1) {	
					
	    $setarr['ip'] = $_G['clientip'];
		$setarr['dateline'] = TIMESTAMP;
		$setarr['status'] = $config["isshen"] == 1 ? 0 : 1;	
		$setarr['status'] = (in_array($groupid, $nochkgroup)) ? 1 : $setarr['status'];
		
		$setarr['uid'] = $_G['uid'];
		$cid = C::t('#sanree_brand_video#sanree_brand_video')->insert($setarr, TRUE);
		video_fixthread($cid);
		
		if (in_array($groupid, $nochkgroup)) {
		
		      showmessage(video_modlang('okmessage'),$url_forward,array(),$extra);
		
		} else {
		
			if ( $config["isshen"] == 1 ) {
			
				showmessage(video_modlang('yesmessage'),$url_forward,array(),$extra);
				
			}
			else {
			
				
				showmessage(video_modlang('okmessage'),$url_forward,array(),$extra);
				
			}
		}		
	}
	else {
		C::t('#sanree_brand_video#sanree_brand_video')->update($cid,$setarr);
		video_fixthread($cid);
		showmessage(srlang('editmessage'),$url_forward,array(),$extra);
		
	}	
} else {
	$category_list = array();
	$category = video_loadcache('usercate');
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
	$addteltitle = $config['djtitle'] ? $config['djtitle'] : video_modlang('post_new_video');
	$_G[fid] = $bindingforum;
	$selectunitstr='<select name="priceunit">';
	$selectpriceunit = $config['selectpriceunit'];
	$marr = explode("\r\n", $selectpriceunit);
	foreach($marr as $row) {
	
		list($key , $val) = explode("=", $row);
		$val = video_shtmlspecialchars(trim($val));	
		$selected = '';
		if($key == intval($result['priceunit'])) {
			$selected = ' selected';
		}
		$selectunitstr .='<option value="'.$key.'"'.$selected.'>'.$val.'</option>';
		
	}	
	$selectunitstr .='</select>';	
	if ($result[isshow]==1) {
	
		$isshowst = ' checked="checked" ';
		$notshowst = '';
		
	} else {
	
		$isshowst = '';
		$notshowst = ' checked="checked" ';
		
	}	
	include templateEx($plugin['identifier'].':'.$template."/".$mod);
	
}
//From:www_YMG6_COM
?>