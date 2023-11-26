<?php

/**
 *      [fx8.cc] (C)2014-2017 ymg6.Com.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: sanree_brand_goods_published.php sanree $
 */

if(!defined('IN_DISCUZ')) {
	exit('2014072523P9ep9MXpl9||6873||1413856801');
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
    showmessage(goods_modlang('pleaseaddbrand'),'',array(),$extra);
	
}

$gid=intval($_G['sr_gid']);
$bid=intval($_G['sr_bid']);
if ($gid>0) {

	$result = C::t('#sanree_brand_goods#sanree_brand_goods')->getusername_by_gidanduid($_G['uid'], $gid);
	if (!$result) {
	
		showmessage(goods_modlang('nogid'));
		
	}
	$result['startdate'] = empty($result['startdate']) ? '' : dgmdate($result['startdate']);
	$result['enddate'] = empty($result['enddate']) ? '' : dgmdate($result['enddate']);   
	$pid= intval($result['pid']); 
	$tid= intval($result['tid']);
	 
} else {

	if ($addprice>0) {
	
		$account = getuserprofile('extcredits'.$creditunit);		
		if ($addprice>$account) {
		
			showmessage($nonepricetip);
			
		}
		
	}
    $result = array();
    $result['isshow'] = 1;
	$result['bid'] = $bid;
	$result['buylink'] = 'http://';
	
}

if(submitcheck('postsubmit')) {

	$cateid=intval($_G['sr_cateid']);
	$aid = array();
	$ishome = intval($_G['sr_ishome']);
	foreach($_G['sr_attachnew'] as $key => $value) {
	
		$aid[] = $key;
			
	}

    $bid = intval($_G['sr_bid']);	
	$goodsname=dhtmlspecialchars(trim($_G['sr_goodsname']));
	$keywords=dhtmlspecialchars(trim($_G['sr_keywords']));
	$description=dhtmlspecialchars(trim($_G['sr_description']));
	///$introduction =dhtmlspecialchars(trim($_G['sr_introduction'])); 
	$content =dhtmlspecialchars(trim($_G['sr_content'])); 
	
	$price = sprintf("%.2f", dhtmlspecialchars(trim($_G['sr_price'])));
	$minprice = sprintf("%.2f", dhtmlspecialchars(trim($_G['sr_minprice'])));
	$maxprice = sprintf("%.2f", dhtmlspecialchars(trim($_G['sr_maxprice'])));
	$reserveprice = sprintf("%.2f", dhtmlspecialchars(trim($_G['sr_reserveprice'])));
	$goodsno=dhtmlspecialchars(trim($_G['sr_goodsno']));
			
	if ($price<0) {
	
		showmessage(goods_modlang('inputprice'));
		
	}
	if ($minprice<0) {
	
		showmessage(goods_modlang('inputminprice'));
		
	}	
	$brand = C::t('#sanree_brand#sanree_brand_businesses')->usergetbusinesses_by_bid($bid, $_G[uid]);	
	if (!$brand) {
	
		showmessage(srlang('error_bid'));
		
	}
	$brandmoduleresult = C::t('#sanree_brand#sanree_brand_businesses_module')->fetch_by_bid($bid);
	if ($brandmoduleresult['isgoods']!=1) {
	
		showmessage(goods_modlang('error_brand_pub'));
		
	}
	
	if (count($aid)<1) {
	
		showmessage(goods_modlang('inputpicture'));
			
	}
	if(dstrlen($content) > 4000) {
	
		showmessage(goods_modlang('post_content_toolong'));
		
	}
	if ($cateid<1) {
	
		showmessage(srlang('nocateid'));
		
	}	
	if (empty($goodsname)) {
	
		showmessage(goods_modlang('noname'));
		
	}
	$st = $_G['sr_st'];
	$extrastr = '';
	if (!empty($st)) {
	
		$extrastr ='&st='.$st;
		
	}	
	if ($gid<1) {
	
	    $sendcount = C::t('#sanree_brand_goods#sanree_brand_goods')->count_by_where(" AND bid='$bid'");
		$groupmaxgoods = goods_getgroupmax($bid);
		if ($sendcount>= $groupmaxgoods) {
		
			showmessage(goods_modlang('ismaxgoods'));
			
		}	
		$count=C::t('#sanree_brand_goods#sanree_brand_goods')->count_by_where(" AND name='$goodsname'");
		if ($count>0) {
		
			showmessage(goods_modlang('ishavecom'));
			
		}
		$url_forward = srreferer() ? $_G['referer'] : 'plugin.php?id=sanree_brand_goods&mod=mygoods&view=index'.$extrastr;
		
	} else {
	
		$url_forward = srreferer() ? $_G['referer'] : 'plugin.php?id=sanree_brand_goods&mod=mygoods&view=index'.$extrastr;
		
	}
	if ($ishome<1) {
	
		$ishome = $aid[0];
		
	}

	$setarr = array();
	$setarr['cateid'] = $cateid;
	$setarr['aids'] = implode($aid, '|');
	$setarr['introduction'] = $introduction;
	$setarr['content'] = $content;
	$setarr['bid'] = $bid;
	$setarr['name'] = $goodsname;
	$setarr['keywords'] = $keywords;
	$setarr['description'] = $description;
	$setarr['homeaid'] = $ishome;	
	require_once libfile('function/post');
	$att = getattach(0, 0, $ishome);
	$setarr['smallpic'] = $att[attachs]['unused'][0][attachment];
	$setarr['price'] = $price;
	$setarr['minprice'] = $minprice;
	$setarr['maxprice'] = $maxprice;
	$setarr['reserveprice'] = $reserveprice;
	$setarr['stock'] = intval(trim($_G['sr_stock']));
	$setarr['startdate'] = !empty($_G['sr_startdate']) ? strtotime($_G['sr_startdate']) : 0;
	$setarr['enddate'] = !empty($_G['sr_enddate']) ? strtotime($_G['sr_enddate']) : 0;		
	$setarr['displayorder'] = intval(trim($_G['sr_displayorder']));
	$setarr['isshow'] = intval(trim($_G['sr_isshow']));
	$setarr['priceunit'] = intval(trim($_G['sr_priceunit']));
	$setarr['unit'] = dhtmlspecialchars(trim($_G['sr_unit']));
	if ($isbuylink == 1) {
		$setarr['buylink'] = str_replace('http://', '', dhtmlspecialchars(trim($_G['sr_buylink'])));
	}	
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
	if (!empty($goodsno)) {
		if ($gid<1) {
			$count=C::t('#sanree_brand_goods#sanree_brand_goods')->count_by_where(" AND goodsno='$goodsno'");
		} else { 
			$count=C::t('#sanree_brand_goods#sanree_brand_goods')->count_by_where(" AND goodsno='$goodsno' AND name <> '$goodsname'");
		}
		if ($count>0) {
		
			showmessage(goods_modlang('ishavegoodsno'));
			
		}			
		preg_match("/[^0-9a-zA-Z]/", $goodsno, $matches);
		if (count($matches)>0) {
			showmessage(goods_modlang('errorgoodsno'));
		}
		$setarr['goodsno'] = $goodsno;
	}

	if ($gid<1) {	
			
	    $setarr['ip'] = $_G['clientip'];
		$setarr['dateline'] = TIMESTAMP;
		$setarr['status'] = $config["isshen"] == 1 ? 0 : 1;	
		$setarr['status'] = (in_array($groupid, $nochkgroup)) ? 1 : $setarr['status'];
		$setarr['uid'] = $_G['uid'];
		$setarr['addprice'] = $addprice;
		$gid = C::t('#sanree_brand_goods#sanree_brand_goods')->insert($setarr, TRUE);		
		if ($addprice > 0) {
		
			$creditdata=array('extcredits'.$creditunit => -intval($addprice));	
			updatemembercount($_G['uid'], $creditdata, true, 'GRD', 1);
			
		}	
		goods_fixthread($gid);
		
		if (in_array($groupid, $nochkgroup)) {
		
			attention_information($gid, 'goods');
		    showmessage(goods_modlang('okmessage'),$url_forward,array(),$extra);
		
		} else {
		
			if ( $config["isshen"] == 1 ) {
			
				showmessage(srlang('yesmessage'),$url_forward,array(),$extra);
				
			}
			else {
			
				attention_information($gid, 'goods');				
				showmessage(goods_modlang('okmessage'),$url_forward,array(),$extra);
				
			}
		}		
	} else {
	
		C::t('#sanree_brand_goods#sanree_brand_goods')->update($gid,$setarr);
		goods_fixthread($gid);
		showmessage(srlang('editmessage'),$url_forward,array(),$extra);
		
	}	
} else {
	$category_list = array();
	$category = goods_loadcache('usercate');
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
	
		$brandmoduleresult = C::t('#sanree_brand#sanree_brand_businesses_module')->fetch_by_bid($data['bid']);
		if ($brandmoduleresult['isgoods']==1) {
			$selectlist[] =array('bid'=> $data['bid'], 'name' => $data['name'], 'selected' => '');
		}
		
	}			
	$navtitle = srlang('dengjititle');
	$addteltitle = $config['djtitle'] ? $config['djtitle'] : goods_modlang('post_new_goods');
	$allowfastpost = true;
	$allowpostattach = true;
	$_G[fid] = $bindingforum;
	if ($_G['setting']['version']=='X2') {
	
		require_once DISCUZ_ROOT.'./source/plugin/sanree_brand_goods/X2/function/function_upload.php';
		$swfconfig = getuploadconfig($_G['uid'], $_G['fid']);
		$thisconfig= array();
		$thisconfig[jspath] = 'source/plugin/sanree_brand_goods/X2/js/';
		$thisconfig[imgdir] = 'source/plugin/sanree_brand_goods/X2/images/';
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
	
	$selectunitstr='<select name="priceunit">';
	$selectpriceunit = $config['selectpriceunit'];
	$marr = explode("\r\n", $selectpriceunit);
	foreach($marr as $row) {
	
		list($key , $val) = explode("=", $row);
		$val = goods_shtmlspecialchars(trim($val));	
		$selected = '';
		if($key == $result[priceunit]) {
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
	$pubtip_price = '';
	if ($addprice>0) {
		$pubtip_price = str_replace(array('{addprice}', '{creditunitname}'), array($addprice, $creditunitname), goods_modlang('pubtip_price'));
	}
	$result['content'] = str_replace('&amp;', '&',$result['content']);
	include templateEx($plugin['identifier'].':'.$template."/".$mod);
	
}
//From:www_YMG6_COM
?>