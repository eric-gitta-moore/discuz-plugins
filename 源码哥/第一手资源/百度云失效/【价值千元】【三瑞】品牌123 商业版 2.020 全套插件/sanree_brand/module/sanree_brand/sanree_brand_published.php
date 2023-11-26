<?php

/**
 *      [fx8.cc] (C)2014-2017 ymg6.Com.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: sanree_brand_published.php sanree $
 */

if(!defined('IN_DISCUZ')) {
	exit('');
}

if (!$_G['uid']) {

	showmessage(srlang('nologin'), '', array(), array('login' => true));
	
}
if (!in_array($_G['group']['groupid'],$addgroup)) {

	showmessage($stopaddtip);
	
}
$bid = isset($_G['sr_bid']) ? intval($_G['sr_bid']) : 0;
$result = array();
$result['discount'] = 0;
if ($bid>0) {

	$result = C::t('#sanree_brand#sanree_brand_businesses')->getusername_by_bidanduid($_G['uid'], $bid);
	if (!$result) {
	
		showmessage(srlang('nobid'));
		
	}
	$result['weburl']=str_replace("http://", '', $result['weburl']);
	$result['propaganda'] = str_replace('&amp;', '&',$result['propaganda']);
	$result['introduction'] = str_replace('&amp;', '&',$result['introduction']);
	$result['contact'] = str_replace('&amp;', '&',$result['contact']);		
	if ($mapapi=='google') {
		$result['mappos'] = $result['googlemappos'];
	}	
		
} else {

	if ($regprice>0) {
	
		$account = getuserprofile('extcredits'.$creditunit);	
		if ($regprice>$account) {
		
			showmessage(srlang('nomoney'));
			
		}
		
	}
	
}
if(submitcheck('postsubmit')) {

	$cateid				= intval($_G['sr_cateid']);
	$name				= dhtmlspecialchars(trim($_G['sr_name']));
	$poster				= dhtmlspecialchars(trim($_G['sr_poster']));
	$propaganda			= dhtmlspecialchars(trim($_G['sr_propaganda']));
	$introduction 		= dhtmlspecialchars(trim($_G['sr_introduction'])); 
	$contact 			= dhtmlspecialchars(trim($_G['sr_contact'])); 
	if ($ismultiple==1) {
		$qq 				= replaceparting(dhtmlspecialchars(trim($_G['sr_qq'])));
		$msn 				= replaceparting(dhtmlspecialchars(trim($_G['sr_msn']))); 
		$wangwang 			= replaceparting(dhtmlspecialchars(trim($_G['sr_wangwang']))); 
		$baiduhi 			= replaceparting(dhtmlspecialchars(trim($_G['sr_baiduhi']))); 
		$skype 				= replaceparting(dhtmlspecialchars(trim($_G['sr_skype']))); 
		$tel 				= replaceparting(dhtmlspecialchars(trim($_G['sr_tel']))); 
	} else {
		$qq 				= dhtmlspecialchars(trim($_G['sr_qq']));
		$tel 				= dhtmlspecialchars(trim($_G['sr_tel'])); 
	}
	$address 			= dhtmlspecialchars(trim($_G['sr_address']));
	$mappos 			= dhtmlspecialchars(trim($_G['sr_mappos'])); 
	$weburl 			= 'http://'.str_replace('http://', '', dhtmlspecialchars(trim($_G['sr_weburl'])));
	
	if(dstrlen($propaganda) > 1000) {
	
		showmessage(srlang('post_propaganda_toolong'));
		
	}
	if(dstrlen($introduction) > 4000) {
	
		showmessage(srlang('post_introduction_toolong'));
		
	}
	if(dstrlen($contact) > 1000) {
	
		showmessage(srlang('post_contact_toolong'));
		
	}
	if ($cateid<1) {
	
		showmessage(srlang('nocateid'));
		
	}	
	if (empty($name)) {
	
		showmessage(srlang('noname'));
		
	}
	$caid=intval($_G['sr_caid']);
	if (($caid < 1)&&($bid < 1)) {
	
		showmessage(srlang('inputposter'));
		
	}	
	$attachment = C::t('#sanree_brand#sanree_brand_attachment')->fetch_firstbyaid($caid);
	if (!$attachment) {
	
		showmessage(srlang('inputposter'));
		
	}
	/*
	if (!$qq) {
	
		showmessage(srlang('inputqq'));
		
	}
	if (!$mappos) {
	
		showmessage(srlang('inputmappos'));
		
	}*/
	if (!$tel) {
	
		showmessage(srlang('inputtel'));
		
	}
	if (!$address) {
	
		showmessage(srlang('inputaddress'));
		
	}
	if ($bid<1) {
	
		$count=C::t('#sanree_brand#sanree_brand_businesses')->count_by_where(" AND name='$name'");
		if ($count>0) {
		
			showmessage(srlang('ishavecom'));
			
		}
		$url_forward = srreferer() ? $_G['referer'] : $allurl;
		$gothome = intval($_G['sr_gothome']);
		if ($gothome==1){
		
			$url_forward = $allurl;
			
		}		
		
	} else {
	
		$url_forward = srreferer() ? $_G['referer'] : 'plugin.php?id=sanree_brand&mod=mybrand';
		
	}
	

	$setarr = array();
	$setarr['cateid'] 			= $cateid;
	$setarr['poster'] 			= $attachment['attachment'];
	$setarr['caid'] 			= $caid;
	$setarr['propaganda'] 		= $propaganda;
	$setarr['introduction'] 	= $introduction;
	$setarr['weburl'] 			= $weburl;
	$setarr['contact'] 			= $contact;
	$setarr['qq'] 				= $qq;
	if ($ismultiple==1) {
		$setarr['msn'] 			= $msn;
		$setarr['wangwang'] 	= $wangwang;
		$setarr['baiduhi'] 		= $baiduhi;
		$setarr['skype'] 		= $skype;
	}
	$setarr['tel'] 				= $tel;
	$setarr['address'] 			= $address;
	if ($mapapi=='google') {
	
		$setarr['googlemappos'] = $mappos;
		
	} else {
	
		$setarr['mappos'] = $mappos;
		
	}	
	$setarr['discount'] = intval(dhtmlspecialchars(trim($_G['sr_discount'])));
	if ($_G['sr_srbirthprovince']) {
	
		$setarr['srbirthprovince'] 		= dhtmlspecialchars(trim($_G['sr_srbirthprovince']));
		$setarr['srbirthcity'] 			= dhtmlspecialchars(trim($_G['sr_srbirthcity']));
		$setarr['srbirthdist'] 			= dhtmlspecialchars(trim($_G['sr_srbirthdist']));
		$setarr['srbirthcommunity'] 	= dhtmlspecialchars(trim($_G['sr_srbirthcommunity']));
			
	}	
	if ($_G['sr_birthprovince']) {
	
		$setarr['birthprovince'] 		= dhtmlspecialchars(trim($_G['sr_birthprovince']));
		$setarr['birthcity'] 			= dhtmlspecialchars(trim($_G['sr_birthcity']));
		$setarr['birthdist'] 			= dhtmlspecialchars(trim($_G['sr_birthdist']));
		$setarr['birthcommunity'] 		= dhtmlspecialchars(trim($_G['sr_birthcommunity']));
			
	}		
	$extra = array();
	if ($_G['inajax']) {

	    $href = $url_forward;
		$href = str_replace("'", "\'", $href);	
		$url_forward = '';	
		$extra = array(
			'showdialog' => false,
			'extrajs' => "<script type=\"text/javascript\" reload=\"1\">hideWindow('publisheddlg', 0, 1);setTimeout(\"window.location.href ='".$href."';\", 30000);</script>"
		);

	}
	if ($bid<1) {	
	
		if ($ischkdistrict == 1) {
		
			if ($isselfdistrict == 1) {
			
				if (!$_G['sr_srbirthprovince']) {
				
					showmessage(srlang('inputdistrict'));
					
				}
				
			} else {
			
				if (!$_G['sr_birthprovince']) {
				
					showmessage(srlang('inputdistrict'));
					
				}
				
			}
			
		}	
		$setarr['name'] 					= $name;
	    $setarr['ip'] 						= $_G['clientip'];
		$setarr['dateline'] 				= TIMESTAMP;
		$setarr['regprice'] 				= $regprice;
		$setarr['creditunitname'] 			= $creditunitname;
		$setarr['status'] 					= $config["isshen"] == 1 ? 0 : 1;	
		$setarr['isshow'] 					= $config["isshen"] == 1 ? 0 : 1;	
		$setarr['uid'] 						= $_G['uid'];
		$setarr['recommendationindex'] 		= sprintf("%.1f", $defaultzhishu);
		$setarr['groupid'] 					= intval($defaultconfig['groupid']);
		$setarr['allowalbum'] 				= intval($defaultconfig['allowalbum']);
		$setarr['allowfastpost'] 			= intval($defaultconfig['allowfastpost']);
		$setarr['allowmultiple'] 			= intval($defaultconfig['allowmultiple']);
		$templateconfig 					= array();
		$templateconfig['bodystyle'] 		= $defaultconfig['bodystyle'];
		$setarr['templateconfig']			= serialize($templateconfig);		
		$bid = C::t('#sanree_brand#sanree_brand_businesses')->insert($setarr, TRUE);
		if ($bid>0) {
		
			$adddatafield = array();
			foreach(C::t('#sanree_brand#sanree_brand_businesses_module')->fetch_all_column() as $key =>$column)	{
	
				$columnname = $column[data];
				$type = $column[type];
				if ($type=='radio') {
					$adddatafield[$columnname]= $defaultconfig['module'][$columnname];
				}
			
			}
			if (C::t('#sanree_brand#sanree_brand_businesses_module')->count_by_where(' AND bid='.$bid)<1) {
			
				$addarray = array();
				$addarray = $adddatafield;
				$addarray[bid] = $bid;
				C::t('#sanree_brand#sanree_brand_businesses_module')->insert($addarray);
				
			}
			
		}		
		if ($regprice > 0) {
		
			$creditdata=array('extcredits'.$creditunit => -intval($regprice));	
			updatemembercount($_G[uid], $creditdata, true, 'BRD', 1);
			
		}	
		if ( $config["isshen"] == 1 ) {
		
			sendbrand_notice($bid,'brand_pending');
			sanreeupdatecache('newbrandlist');
			sanreeupdatecache('hotbrandlist');
			sanreeupdatecache('recommendlist');			
			showmessage(srlang('yesmessage'), $url_forward, array(), $extra);
			
		} else {
		
		    fixthread($bid);
			syngroup($bid);
			deletecachebrandpic($bid);
			sendbrand_notice($bid,'brand_pass');
			sanreeupdatecache('newbrandlist');
			sanreeupdatecache('hotbrandlist');
			sanreeupdatecache('recommendlist');			
			showmessage(srlang('okmessage'), $url_forward, array(), $extra);
			
		}	
			
	} else {
	
		C::t('#sanree_brand#sanree_brand_businesses')->update($bid, $setarr);
		if ($result['status'] == 1) {
		
			fixthread($bid);
			syngroup($bid);
			deletecachebrandpic($bid);
			
		}
		sanreeupdatecache('hotbrandlist');
		sanreeupdatecache('recommendlist');		
		showmessage(srlang('editmessage'), $url_forward, array(), $extra);
		
	}
		
} else {

	$category_list = array();
	$category = sanreeloadcache('usercate');
	foreach($category as $value) {
	
		$category_list[] = $value;
		
	}
	$navtitle = srlang('dengjititle');
	$addteltitle = $config['djtitle'] ? $config['djtitle'] : srlang('teladd');
	if ($isselfdistrict==1) {
	
			$districthtml = brand_setting('birthcity', $result);
				
	} else {
	
		include_once libfile('function/profile');
		$districthtml = profile_setting('birthcity', $result);
		
	}
	$discounthtml = brand_discountsetting($result['discount']);
	$pubtip_price = srlang('pubtip_price');
	$pubtip_price = str_replace(array('{regprice}', '{creditunitname}'), array($regprice, $creditunitname), $pubtip_price);
	$pubtip_shen = srlang('pubtip_shen');
	$pubtip_shen = str_replace(array('{admintel}'), array($admintel), $pubtip_shen);
	$pubtip_ok = srlang('pubtip_ok');
	$pubtip_ok = str_replace(array('{admintel}'), array($admintel), $pubtip_ok);
	if ($_G['inajax']==1) {	
	    include templateEx($plugin['identifier'].':'.$template."/".$mod.'_ajax');
	} else {	
	
		$newlist = array();
		foreach(C::t('#sanree_brand#sanree_brand_businesses')->fetch_all_by_searchc(array('c.status=1', 't.status=1', 't.isshow=1'), 't.bid desc' , 0, 8) as $value) {
		
			$value[url] = getburl($value);
			$newlist[] = $value;
			
		}		
		include templateEx($plugin['identifier'].':'.$template."/".$mod);
	}
	
}
//From:www_YMG6_COM
?>