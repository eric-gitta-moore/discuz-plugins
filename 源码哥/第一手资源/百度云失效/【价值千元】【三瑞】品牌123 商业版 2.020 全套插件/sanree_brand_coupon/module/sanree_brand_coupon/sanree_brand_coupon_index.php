<?php

/**
 *      [fx8.cc] (C)2014-2017 ymg6.Com.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: sanree_brand_coupon_index.php sanree $
 */
if(!defined('IN_DISCUZ')) {
	exit('20131125098bplwO8zuA||12679||1381384801');
}
$perpage = $shownum;
$copyrightshow = $copyrightpass=='www.fx8.cc' ? 0 : 1;
$pid		= 0;
$did 		= isset($_G['sr_did']) ? intval($_G['sr_did']) : 0;
$cid 		= isset($_G['sr_cid']) ? intval($_G['sr_cid']) : 0;
if ($isindexlist==1) {

    if (isset($_GET['listmode'])) {
	
		$listmode = intval($_G['sr_listmode']);
		
	} else {
	
		$listmode = 1;
		
	}
	
} else {

	$listmode 	= isset($_G['sr_listmode']) ? intval($_G['sr_listmode']) : 0;
	
}
!in_array($listmode,array(0, 1, 2)) && $listmode = 0;
$slistmode = $listmode;
!in_array($slistmode,array(0, 1)) && $slistmode = 0;

$cateid = isset($_G['sr_tid']) ? intval($_G['sr_tid']) : 0;
$page = isset($_G['sr_page']) ? intval($_G['sr_page']) : 1;
$page = max(1, intval($page));
$start = ($page - 1) * $perpage;
$start = max(0, $start);
$filter = intval($_G['sr_filter']);
$filterarr =  array(1, 2 , 3, 4, 5);
!in_array($filter,$filterarr) && $filter = 1;

$multi 		= '';
$keyword 	= isset($_G['sr_keyword']) ? dhtmlspecialchars(trim($_G['sr_keyword'])) : '';	
$category_list = $subcategory_list = array();
require_once libfile('class/'.$plugin['identifier'].'_category','plugin/'.$plugin['identifier']);
$categoryclass 		= new sanree_brand_coupon_category($plugin['identifier']);
$categoryclass->show($is_rewrite);
$pid 				= $categoryclass->_pid;
$category_list 		= $categoryclass->_category_list;
$subcategory_list 	= $categoryclass->_subcategory_list;
$navigation 		= $categoryclass->_navigation;
$location = $categoryclass->_location;
$nowcate = $categoryclass->_nowcate;

$pidurl 	= coupon_getcateurl(array('tid' => $cateid));
$orderurl1 	= coupon_getcateurl(array('filter' => 1));
$orderurl2 	= coupon_getcateurl(array('filter' => 2));
$orderurl3 	= coupon_getcateurl(array('filter' => 3));
$orderurl4 	= coupon_getcateurl(array('filter' => 4));
$orderurl5 	= coupon_getcateurl(array('filter' => 5));
$bigurl	= coupon_getcateurl(array('filter' => 1, 'listmode'=>2));
$smallurl	= coupon_getcateurl(array('filter' => 1, 'listmode'=>1));

$orderclass['ordertime'] = ($filter!=1) ? 'ordertime' : 'ordertimeon';
$orderclass['orderview'] = ($filter!=2) ? 'orderview' : 'orderviewon';
$orderclass['orderrecommend'] = ($filter!=3) ? 'orderrecommend' : 'orderrecommendon';
$orderclass['orderprice'] = ($filter!=4) ? 'orderprice' : 'orderpriceon';
$orderclass['orderclick'] = ($filter!=5) ? 'orderclick' : 'orderclickon';

$allcount = C::t('#sanree_brand_coupon#sanree_brand_coupon')->count_by_wherec(array('c.status=1', 't.status=1', 't.isshow=1'));
$allcountstr = coupon_modlang('allcountstr');
$allcountstr = str_replace('{allcount}', $allcount, $allcountstr);
$orderby = 't.istop desc,t.isrecommend desc,t.ishot desc, t.displayorder,t.cid desc';
$where = array();
$ascf = 'asc'.$filter;
$asc = array();
foreach($filterarr as $nfitem) {
    $asc['asc'.$nfitem] = 'asc';
}
$currentasc = intval($_G['cookie'][$ascf]);
$currentasc = in_array($currentasc, array(1, 2)) ? $currentasc : 1;
$asc[$ascf] = ($currentasc == 2) ? 'desc' : 'asc';
if ($filter==2) {

	$orderby = 't.dateline '.$asc['asc2'];
		
}
elseif ($filter==3) {

	$where[] = '(t.isrecommend=1 or t.istop=1)';
	$orderby = 't.isrecommend '.$asc['asc3'];
		
}
elseif ($filter==4) {

	$orderby = 't.minprice '.$asc['asc4'];
		
}		
elseif ($filter==5) {

	$orderby = 'tt.views '.$asc['asc5'];
		
}	


if ($cateid>0) {

    $cateids = array();
	$cateids[] = $cateid;
	if (is_array($subcategory_list)) {
	   foreach($subcategory_list as $key => $val) {
		   $cateids[] = $key;
	   }
	}
	$ids = implode($cateids,',');
	if ($pid == $cateid) {
		$where[] = 't.cateid in ('.$ids.')';
		$pidclass = ' class="cateon"';
	}
	else {
		$where[] = 't.cateid ='.$cateid ;
		$pidclass = '';
	}
	
	$where[] = 'c.status=1';
	$where[] = 't.status=1';
	$where[] = 't.isshow=1';		
	$result = $categoryclass->_curcatedata;	
	if (is_array($result)) {	
	
	    $result['keywords'] = trim($result['keywords']);
		$result['description'] = trim($result['description']);
		$result['description'] = str_replace('\r\n', '', $result['description']);
		$result['keywords'] && $metakeywords = $result['keywords'];
		$result['description'] && $metadescription = $result['description'];
		$navtitle = $result['name'].' - '.$config['title'];
					
	}

}
else {

	$where[] = 'c.status=1';
	$where[] = 't.status=1';
	$where[] = 't.isshow=1';
	
}
$extra = '';
$defaultkeyword = '';
if(!empty($keyword)){

	$searchfield = array('t.name', 't.content ', 't.description');
	$searchtext = array();
	foreach($searchfield as $v) {
	
		$searchtext[] = "(".$v." LIKE '%".$keyword."%')";
		
	}
	$where[] = '('.implode(' OR ',$searchtext).')';
	$defaultkeyword = $keyword;
	$extra = '&keyword='.urlencode($keyword);
	
}

$count = C::t('#sanree_brand_coupon#sanree_brand_coupon')->count_by_wherec($where);
if ($count>0) {

	require_once libfile('function/discuzcode');
	$fcoupon_list = array();
	$datalist = C::t('#sanree_brand_coupon#sanree_brand_coupon')->fetch_all_by_searchc($where, $orderby, ($page - 1) * $perpage, $perpage);
	foreach($datalist as $value) {
	
	    $value['cateurl'] = getcateurl(array('tid' => $value['cateid']),TRUE);
		$value['pic'] = coupon_getforumimg($value['homeaid'], 0 , 120, 120);
		$value['qq'] = empty($value['qq']) ? srlang('zanwustr') : '<a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin='.$value['qq'].'&site=qq&menu=yes"><img border="0" src="http://wpa.qq.com/pa?p=2:'.$value['qq'].':16" alt="'.srlang('qqtipmsg').'" title="'.srlang('qqtipmsg').'"></a>';	
		$discount = ($value['price']>0&&$value['minprice']>0&&$value['price'] > $value['minprice']) ? coupon_fixdiscount($value['price'], $value['minprice']).coupon_modlang('discountstr1'): coupon_modlang('discountstr2');
		if ($value['minprice']=='0.00') {
			$discount = coupon_modlang('free');
		}
	    $fcoupon_list[] = array(
			'name' => $value['name'], 
			'brandname' => $value['brandname'], 
			'brandurl' =>  coupon_brandgetburl($value['bid']), 
			'description' => cutstr($value['description'],30), 
			'cateurl' 		=> $value['cateurl'],
			'catename'		=> $value['catename'],
			'url'			=> coupon_getburl($value),
			'pic' 			=> $value['pic'],
			'price'			=> $value['price'],
			'minprice'		=> $value['minprice'],	
			'discount'		=> $discount,	
			'priceunit'		=> $value['priceunit'],	
			'dateline'		=> $value['dateline'] ? dgmdate($value['dateline']) : '',
			'enddate'		=> $value['enddate'] ? srlang('enddatestr').dgmdate($value['enddate'],'d') : '',
			'isrecommend' => intval($value['isrecommend']),
			'showname' => cutstr($value['name'],50),
			'showname1' => cutstr($value['name'],40),
		);
		
	}
	$murl= $is_rewrite ? coupon_getcateurl(array('tid' => $cateid, 'listmode' => $listmode)).'?t'.$extra : coupon_getcateurl(array('tid' => $cateid, 'listmode' => $listmode)).$extra;
	$multi = multi ( $count, $perpage, $page, $murl);	
}

$orderby = 't.istop desc,t.displayorder, t.dateline desc';
$where=array(
	'c.status=1',
	't.isrecommend=1',
	't.status=1'
 );
$recommendcoupon=array();
foreach(C::t('#sanree_brand#sanree_brand_coupon')->fetch_all_by_searchc($where, $orderby, 0, 3) as $value) {

	$value['url'] = coupon_getburl($value);
	$value['cateurl'] = getcateurl(array('tid' => $value['cateid']),TRUE);
	$pic = coupon_getforumimg($value['homeaid'], 0 , 140, 140);
	$recommendcoupon[]= array('url' =>$value['url'],'showname' => cutstr($value['name'],45),'name' => $value['name'],'catename' => $value['catename'],'cateurl' => $value['cateurl'], 'pic' => $pic);
	
}
$orderby = 't.ishot desc,t.displayorder, t.dateline desc';
$where=array(
	'c.status=1',
	't.ishot=1',
	't.status=1'
 );
$hotcoupon=array();
foreach(C::t('#sanree_brand#sanree_brand_coupon')->fetch_all_by_searchc($where, $orderby, 0, 3) as $value) {

	$value['url'] = coupon_getburl($value);
	$value['cateurl'] = getcateurl(array('tid' => $value['cateid']),TRUE);
	$pic = coupon_getforumimg($value['homeaid'], 0 , 140, 140);
	$hotcoupon[]= array('url' =>$value['url'],'showname' => cutstr($value['name'],25),'name' => $value['name'],'catename' => $value['catename'],'cateurl' => $value['cateurl'], 'pic' => $pic);
	
}

$orderby = 't.istop desc,t.displayorder, t.dateline desc';
$where=array(
	'c.status=1',
	't.isrecommend=1',
	't.status=1'
 );
$recommendlist=array();
foreach(C::t('#sanree_brand#sanree_brand_businesses')->fetch_all_by_searchc($where, $orderby, 0, $indexrecommendnum) as $value) {

    if ($value['recommendimg']) {
	
		$valueparse = parse_url($value['recommendimg']);
		if(isset($valueparse['host'])) {
		
			$value['recommendimg'] = $value['recommendimg'];
			
		} else {
		
			$value['recommendimg'] = $_G['setting']['attachurl'].'common/'.$value['recommendimg'].'?'.random(6);
			
		}
		
	} else {
	
		$value['recommendimg'] = sr_brand_coupon_IMG.'/none1.gif';
		
	}
	if ($reurlmode==1) {
	
		$url = empty($value['weburl']) || $value['weburl']=='http://' ? getburl($value): $value['weburl'];
		
	} else {
	
		$url = getburl($value);
		
	}
	$recommendlist[]= array('name'=> $value['name'], 'img' => '<img src="'.$value['recommendimg'].'" alt="'.$value['name'].'" />', 'url' =>$url);
	
}
$orderby = 'tviews desc';
$where=array(
	'c.status=1',
	't.status=1'
 );
$hotbrandnum = $indexrecommendnum>0 ? $indexrecommendnum : 9;
$hotbrandlist=array();
foreach(C::t('#sanree_brand#sanree_brand_businesses')->fetch_all_by_searchc($where, $orderby, 0, $hotbrandnum) as $value) {

    if ($value['poster']) {
	
		$valueparse = parse_url($value['poster']);
		if(isset($valueparse['host'])) {
		
			$value['poster'] = $value['poster'];
			
		} else {
		
			$value['poster'] = $_G['setting']['attachurl'].'category/'.$value['poster'].'?'.random(6);
			
		}
		
	}
	else {
	
		$value['poster'] = sr_brand_coupon_IMG.'/none2.gif';
		
	}
	if ($reurlmode==1) {
	
		$url = empty($value['weburl']) || $value['weburl']=='http://' ? getburl($value): $value['weburl'];
		
	}
	else {
	
		$url = getburl($value);
		
	}
	$hotbrandlist[]= array('views' => $value['tviews'],'name'=> $value['name'], 'img' => '<img src="'.$value['poster'].'" alt="'.$value['name'].'" />', 'url' =>$url);
	
}

$slidelist = array();
$slide = DB::fetch_first("SELECT * FROM ".DB::table('sanree_brand_coupon_slide'));
if ($slide) {

   for($j=1;$j<6;$j++) {

		if ($slide['pic'.$j])  {
		
			$picurl = coupon_fiximage($slide['pic'.$j]);
			$link =  $slide['movie'.$j]; 
			$slidelist[] =  array('pic' => $picurl, 'url' => $link);
			  
		}
   }
   
}
include templateEx($plugin['identifier'].':'.$template.'/index');
?>