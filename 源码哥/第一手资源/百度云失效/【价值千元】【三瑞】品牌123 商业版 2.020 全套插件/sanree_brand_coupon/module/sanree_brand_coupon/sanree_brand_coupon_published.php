<?php

/**
 *      [fx8.cc] (C)2014-2017 ymg6.Com.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: sanree_brand_coupon_published.php sanree $
 */

if(!defined('IN_DISCUZ')) {
	exit('20131125098bplwO8zuA||12679||1381384801');
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
    showmessage(coupon_modlang('pleaseaddbrand'),'',array(),$extra);
	
}

$cid=intval($_G['sr_cid']);
$bid=intval($_G['sr_bid']);
if ($cid>0) {

	$result = C::t('#sanree_brand_coupon#sanree_brand_coupon')->getusername_by_cidanduid($_G['uid'], $cid);
	if (!$result) {
	
		showmessage(coupon_modlang('nocid'));
		
	}
	$result['enddate'] = empty($result['enddate']) ? '' : dgmdate($result['enddate'], 'd');   
	$pid= intval($result['pid']); 
	$tid= intval($result['tid']);
	 
} else {

    $result= array();
    $result['isshow'] = 1;
	$result['bid'] = $bid;
	$result['enddate'] = '';
	$result['rebateproportion'] = 0;

}

if(submitcheck('postsubmit')) {

	$cateid=intval($_G['sr_cateid']);
    $bid = intval($_G['sr_bid']);
	$stock = intval($_G['sr_stock']);	
	$couponname=dhtmlspecialchars(trim($_G['sr_couponname']));
	$keywords=dhtmlspecialchars(trim($_G['sr_keywords']));
	$description=dhtmlspecialchars(trim($_G['sr_description']));
	$content =dhtmlspecialchars(trim($_G['sr_content'])); 
	$condition =dhtmlspecialchars(trim($_G['sr_condition'])); 
	$price = sprintf("%.2f", dhtmlspecialchars(trim($_G['sr_price'])));
	$minprice = sprintf("%.2f", dhtmlspecialchars(trim($_G['sr_minprice'])));	
	$brand = C::t('#sanree_brand#sanree_brand_businesses')->usergetbusinesses_by_bid($bid, $_G[uid]);	
	if (!$brand) {
	
		showmessage(srlang('error_bid'));
		
	}
	$caid=intval($_G['sr_caid']);
	if (($caid < 1)&&($cid < 1)) {
	
		showmessage(coupon_modlang('inputsmallpic'));
		
	}	
	$attachment = C::t('#sanree_brand#sanree_brand_attachment')->fetch_firstbyaid($caid);
	if (!$attachment) {
	
		showmessage(coupon_modlang('inputsmallpic'));
		
	}	
	if(dstrlen($content) > 4000) {
	
		showmessage(coupon_modlang('post_content_toolong'));
		
	}
	if ($cateid<1) {
	
		showmessage(srlang('nocateid'));
		
	}	
	if (empty($couponname)) {
	
		showmessage(coupon_modlang('noname'));
		
	}
	if ($price<0) {
	
		showmessage(coupon_modlang('inputprice'));
		
	}
	if ($minprice<0) {
	
		showmessage(coupon_modlang('inputminprice'));
		
	}
	$st = $_G['sr_st'];
	$extrastr = '';
	if (!empty($st)) {
	
		$extrastr ='&st='.$st;
		
	}	
	if ($cid<1) {
	
	    $sendcount = C::t('#sanree_brand_coupon#sanree_brand_coupon')->count_by_where(" AND bid='$bid'");
		$groupmaxcoupon = coupon_getgroupmax($bid);
		if ($sendcount> $groupmaxcoupon) {
		
			showmessage(coupon_modlang('ismaxcoupon'));
			
		}	
		$count=C::t('#sanree_brand_coupon#sanree_brand_coupon')->count_by_where(" AND name='$couponname'");
		if ($count>0) {
		
			showmessage(coupon_modlang('ishavecom'));
			
		}
		$url_forward =  srreferer() ? $_G['referer'] : 'plugin.php?id=sanree_brand_coupon&mod=mycoupon&view=index'.$extrastr;
		
	} else {
	
		$url_forward =  srreferer() ? $_G['referer'] : 'plugin.php?id=sanree_brand_coupon&mod=mycoupon&view=index'.$extrastr;
		
	}
	if ($ishome<1) {
	
		$ishome = $aid[0];
		
	}

	$setarr = array();
	if ($isrebate==1) {
	
		$rebateproportion = intval($_G['sr_rebateproportion']);
		if ($rebateproportion<1||$rebateproportion>99) {
		
			showmessage(coupon_modlang('inputrebateproportion'));
			
		}
		$setarr['rebateproportion'] = $rebateproportion;
				
	}	
	$setarr['cateid'] = $cateid;
	$setarr['content'] = $content;
	$setarr['condition'] = $condition;
	$setarr['bid'] = $bid;
	$setarr['name'] = $couponname;
	$setarr['keywords'] = $keywords;
	$setarr['description'] = $description;
	$setarr['enddate'] = !empty($_G['sr_enddate']) ? strtotime($_G['sr_enddate']) : 0;		
	$setarr['displayorder'] = intval(trim($_G['sr_displayorder']));
	$setarr['isshow'] = intval(trim($_G['sr_isshow']));
	$setarr['smallpic'] = $attachment['attachment'];
	$setarr['homeaid'] = $caid;
	$setarr['priceunit'] = intval(trim($_G['sr_priceunit']));
	$setarr['unit'] = dhtmlspecialchars(trim($_G['sr_unit']));
	$setarr['price'] = $price;
	$setarr['minprice'] = $minprice;		
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
			
		if ($stock<1) {
		
			showmessage(coupon_modlang('inputstock'));
			
		}	
		$setarr['stock'] = $stock;		
	    $setarr['ip'] = $_G['clientip'];
		$setarr['dateline'] = TIMESTAMP;
		$setarr['status'] = $config["isshen"] == 1 ? 0 : 1;	
		$setarr['status'] = (in_array($groupid, $nochkgroup)) ? 1 : $setarr['status'];
		
		$setarr['uid'] = $_G['uid'];
		$cid = C::t('#sanree_brand_coupon#sanree_brand_coupon')->insert($setarr, TRUE);
		coupon_fixthread($cid);
		
		if (in_array($groupid, $nochkgroup)) {
		
		      showmessage(coupon_modlang('okmessage'),$url_forward,array(),$extra);
		
		} else {
		
			if ( $config["isshen"] == 1 ) {
			
				showmessage(srlang('yesmessage'),$url_forward,array(),$extra);
				
			}
			else {
			
				
				showmessage(coupon_modlang('okmessage'),$url_forward,array(),$extra);
				
			}
		}		
	}
	else {
	    $setarr['stock'] = $stock;
		C::t('#sanree_brand_coupon#sanree_brand_coupon')->update($cid,$setarr);
		coupon_fixthread($cid);
		showmessage(srlang('editmessage'),$url_forward,array(),$extra);
		
	}	
} else {
	$category_list = array();
	$category = coupon_loadcache('usercate');
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
	$addteltitle = $config['djtitle'] ? $config['djtitle'] : coupon_modlang('post_new_coupon');
	$_G[fid] = $bindingforum;
	$selectunitstr='<select name="priceunit">';
	$selectpriceunit = $config['selectpriceunit'];
	$marr = explode("\r\n", $selectpriceunit);
	foreach($marr as $row) {
	
		list($key , $val) = explode("=", $row);
		$val = coupon_shtmlspecialchars(trim($val));	
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
	$result['content'] = str_replace('&amp;', '&',$result['content']);		
	include templateEx($plugin['identifier'].':'.$template."/".$mod);
	
}
//From:www_YMG6_COM
?>