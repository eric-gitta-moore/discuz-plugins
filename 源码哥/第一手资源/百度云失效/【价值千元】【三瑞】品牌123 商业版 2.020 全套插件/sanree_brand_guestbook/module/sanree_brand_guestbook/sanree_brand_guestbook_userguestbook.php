<?php

/**
 *      [fx8.cc] (C)2014-2017 ymg6.Com.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: sanree_brand_guestbook_userguestbook.php sanree $
 */

if(!defined('IN_DISCUZ')) {
	exit('2014061214b98wB3Bomz||7247||1422453601');
}
if ($_POST['ajaxseccodeverify']){
	session_start();
	if ($_SESSION['check_seccodeverify'] == strtoupper(dhtmlspecialchars(trim($_POST['ajaxseccodeverify'])))){
		echo 1;
	}
	exit();
}
$bid = intval($_G['sr_tid']);

$brandresult = C::t('#sanree_brand#sanree_brand_businesses')->getbusinesses_by_bid($bid);
if (!$brandresult) {
	showmessage(srlang('nobrand'));
}
if ($brandresult['status']!=1) {
	showmessage(srlang('nostatus'));
}
$brandmoduleresult = C::t('#sanree_brand#sanree_brand_businesses_module')->fetch_by_bid($bid);
if ($brandmoduleresult['isguestbook']!=1) {
	showmessage(guestbook_modlang('noguestbook'));
}
$sendcount = C::t('#sanree_brand_guestbook#sanree_brand_guestbook')->count_by_where(" AND bid='$bid'");
$groupmaxgguestbook = guestbook_getgroupmax($bid);
if ($sendcount> $groupmaxgguestbook) {

	showmessage(guestbook_modlang('ismaxgguestbook'));
	
}
if (($isopenbyclaim==1)&&($brandresult[uid]!=$brandresult[ownerid])) {

	showmessage(guestbook_modlang('notclaim'));
	
}	
$space = getuserbyuid($_G[uid], 1);
space_merge($space, 'profile');
chkbrandend($brandresult);	
if(submitcheck('postsubmit')) {
    session_start();
    if ($sendtimeout>0) {
	
		$condition = " AND ip='$_G[clientip]' ";
		$orderby = 'dateline desc';
		$nrow = C::t('#sanree_brand_guestbook#sanree_brand_guestbook')->fetch_all_by_search($condition, $orderby, 0, 1);
		$lasttime = intval($nrow[0][dateline]);
		$lasttime =  $lasttime=0 ? TIMESTAMP : $lasttime;
		$sendtimeout = $sendtimeout * 60;
		$waittime = $sendtimeout -  (TIMESTAMP - $lasttime);
		if ($waittime> 0) {
		
		    $fangshuatip = guestbook_modlang('fangshuatip');
			$fangshuatip = str_replace('{time}',$waittime, $fangshuatip);
			showmessage($fangshuatip);
			
		}
		
	}
	$title = dhtmlspecialchars(trim($_G['sr_title']));
	if (empty($title)) {
	
		showmessage(guestbook_modlang('post_inputtitletip'));
		
	}
	if ($isshowcode==1) {
		if ($_SESSION['check_seccodeverify']!= strtoupper(dhtmlspecialchars(trim($_G['sr_seccodeverify'])))) {

			showmessage(guestbook_modlang('post_inputseccodeverifyerrortip'));	
			
		}
		unset($_SESSION['check_seccodeverify']);
	}
		
	$fullname = dhtmlspecialchars(trim($_G['sr_fullname']));
	if (empty($fullname)) {
	
		showmessage(guestbook_modlang('post_inputfullnametip'));
		
	}
	$address = dhtmlspecialchars(trim($_G['sr_address']));
	if (empty($address)) {
	
		showmessage(guestbook_modlang('post_inputaddresstip'));
		
	}
	$phone = dhtmlspecialchars(trim($_G['sr_phone']));
	if (empty($phone)) {
	
		showmessage(guestbook_modlang('post_inputphonetip'));
		
	}
	$words = dhtmlspecialchars(trim($_G['sr_words']));
	if (empty($words)) {
	
		showmessage(guestbook_modlang('post_inputwordstip'));
		
	}
	$setarr = array();	
	$setarr['bid'] = $bid;
	$setarr['title'] = $title;
	$setarr['fullname'] = $fullname;
	$setarr['address'] = $address;
	$setarr['phone'] = $phone;
	$setarr['words'] = $words;
	$setarr['email'] = dhtmlspecialchars(trim($_G['sr_email']));
	$setarr['qq'] = dhtmlspecialchars(trim($_G['sr_qq']));
	$setarr['uid'] = $_G['uid'];
	$setarr['username'] = $_G['username'];
	$setarr['dateline'] = TIMESTAMP;
	$setarr['ip'] = $_G['clientip'];
	$setarr['status'] = 0;			
	$guestbookid = C::t('#sanree_brand_guestbook#sanree_brand_guestbook')->insert($setarr, TRUE);
	guestbook_notice($guestbookid, 'reservation');
	$extra = array();
	$url_forward = getburl_by_bid($bid);
	$href = $url_forward;
	$href = str_replace("'", "\'", $href);	
	$url_forward = '';	
	$extra = array(
		'showdialog' => false,
		'extrajs' => "<script type=\"text/javascript\" reload=\"1\">///hideWindow('publisheddlg', 0, 1);\r\nsetTimeout(\"window.location.href ='".$href."';\", 3000);</script>"
	);
	showmessage(guestbook_modlang('tjiaosucceed'), $url_forward, array(), $extra);
								
} else {
	
	if ($ismultiple==1&&$brandresult['allowmultiple']==1) {
		$icqline = getfirsticq($brandresult[$icq]);
		$brandresult['icq'] = empty($icqline) ? srlang('zanwustr') : str_replace('{icqnumber}',$icqline, $icqshow);	
		$brandresult['tel'] = getfirsticq($brandresult['tel']);
	} else {
		$brandresult['qq'] = empty($brandresult['qq']) ? srlang('zanwustr') : str_replace('{icqnumber}',getfirsticq($brandresult['qq']), $icqshow);
		$brandresult['tel'] = getfirsticq($brandresult['tel']);
	}
	$brandresult['groupimg'] = getgroupimg($brandresult['groupid']);
	$forum_thread = C::t('#sanree_brand#forum_thread')->fetch($brandresult['tid']);
	$brandresult['favtimes'] = $forum_thread['favtimes'];
	$brandresult['url'] = getburl($brandresult);
	$brandresult['poster'] = newtheme($brandresult['poster'], 'category', '/none.gif');
	if (empty($brandresult[banner])) {
		$brandresult[banner] = sr_brand_IMG.'/banner.jpg';
	}
	else {
		$valueparse = parse_url($brandresult['banner']);
		if(!isset($valueparse['host'])) {
			 $brandresult['banner'] = $_G['setting']['attachurl'].'common/'.$brandresult['banner'];
		}
	}
	$brandresult['discount'] = $brand_config['selectdiscountshow'][intval($brandresult['discount'])];
	$navigation = '<em>&raquo;</em><a href="'.$brandresult['url'].'">'.$brandresult['name'].'</a><em>&raquo;</em>'.guestbook_modlang('itemguestbook').'&nbsp;&raquo;&nbsp;'.$cate[catname];
	$navtitle = $brandresult['name'].' - '.$config['title'];
	
	if(!$brand_config['isbird']) {
	
		$lasttemplate = $template;
		$template = $brand_config['template'];
		require_once libfile('class/sanree_brand_menu','plugin/sanree_brand');
		$menuclass = new sanree_brand_menu('sanree_brand');
		$menuclass->getmenu($brandresult, 'guestbook');
		$brand_header = $menuclass->_brand_header;
		$brand_header_one = $menuclass->_brand_header_one;
		$template = $lasttemplate;
		
	} else {
	
		$lasttemplate = $template;
		$template = $brand_config['template'];
		require_once libfile('class/sanree_brand_newmenu','plugin/sanree_brand');
		new sanree_brand_newmenu($pidentifier, $brandresult, $mod);
		$template = $lasttemplate;

	}	
	
	$idtype = 'tid';
	$favoritelist = array();
	foreach(C::t('#sanree_brand#home_favorite')->fetch_all_by_id_idtype($brandresult['tid'], $idtype , 0, 9) as $value) {
	
		$favoritelist[] = $value;
		
	}
	$newlist = array();
	$where = array();
	$where[] = 'c.status=1';
	$where[] = 't.status=1';
	$where[] = 't.isshow=1';
	$orderby = 't.bid desc';	
	foreach(C::t('#sanree_brand#sanree_brand_businesses')->fetch_all_by_searchc($where, $orderby , 0, 9) as $value) {
	
		$value[url] = getburl($value);
		$voter = C::t('#sanree_brand#sanree_brand_voter')->getvotetotal_by_tid(intval($value['tid']));
	$value['satisfaction'] = intval($voter[3]);
	$value['poster'] = $_G['setting']['attachurl'].'category/'.$value['poster'];
		$newlist[] = $value;
		
	}
	
	if ($_G[sr_wap]=='yes') {
		$babyconfig = $_G['cache']['plugin']['sanree_bluebaby_fuzhu'];
		if($babyconfig['isopen']) {
			$orderby = 'displayorder,babyid  desc';
			$blue_baby = C::t('#sanree_we#sanree_we')->fetch_baby_by_search(' && isuse > 0 ',$orderby);
		}
		if (CHARSET=='utf-8') {
			define('C_CHARSET','_utf8');
		} else {
			define('C_CHARSET','');
		}
		$config = $_G['cache']['plugin']['sanree_we'];
		$metakeywords = $config['keywords'];
		$metadescription = $config['description'];
		include templateEx(sanree_we.':'.$template."/we_".$mod);
	} else {
		include templateEx($plugin['identifier'].':'.$template."/".$mod);
	}
	
}
//From:www_YMG6_COM
?>