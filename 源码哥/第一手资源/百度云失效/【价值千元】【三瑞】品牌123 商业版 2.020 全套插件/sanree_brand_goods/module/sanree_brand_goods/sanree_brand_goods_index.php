<?php

/**
 *      [fx8.cc] (C)2014-2017 ymg6.Com.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: sanree_brand_goods_index.php sanree $
 */

if(!defined('IN_DISCUZ')) {
	exit('2014072523P9ep9MXpl9||6873||1413856801');
}
$perpage = $shownum;
$copyrightshow = $copyrightpass=='www.fx8.cc' ? 0 : 1;
$pid		= 0;
$did 		= intval($_G[sr_did]);
$gid 		= intval($_G[sr_gid]);
if ($isindexlist==1) {

    if (isset($_GET['listmode'])) {
	
		$listmode = intval($_G[sr_listmode]);
		
	} else {
	
		$listmode = 1;
		
	}
	
} else {

	$listmode 	= intval($_G[sr_listmode]);
	
}
!in_array($listmode,array(0, 1, 2)) && $listmode = 0;
$slistmode = $listmode;
!in_array($slistmode,array(0, 1)) && $slistmode = 0;

$cateid 	= intval($_G[sr_tid]);
$page 		= intval($_G[sr_page]);
$page 		= max(1, intval($page));
$start 		= ($page - 1) * $perpage;
$start 		= max(0, $start);
$filter 	= intval($_G[sr_filter]);
$filterarr =  array(1, 2 , 3, 4, 5);
!in_array($filter,$filterarr) && $filter = 1;

$multi 		= '';
$keyword 	= dhtmlspecialchars(trim($_G[sr_keyword]));	
$category_list = $subcategory_list = array();
require_once libfile('class/'.$plugin['identifier'].'_category','plugin/'.$plugin['identifier']);
$categoryclass 		= new sanree_brand_goods_category($plugin['identifier']);
$categoryclass->show($is_rewrite);
$pid 				= $categoryclass->_pid;
$category_list 		= $categoryclass->_category_list;
$subcategory_list 	= $categoryclass->_subcategory_list;
$navigation 		= $categoryclass->_navigation;
$location = $categoryclass->_location;

$pidurl 	= goods_getcateurl(array('tid' => $cateid));
$orderurl1 	= goods_getcateurl(array('filter' => 1));
$orderurl2 	= goods_getcateurl(array('filter' => 2));
$orderurl3 	= goods_getcateurl(array('filter' => 3));
$orderurl4 	= goods_getcateurl(array('filter' => 4));
$orderurl5 	= goods_getcateurl(array('filter' => 5));
$bigurl	= goods_getcateurl(array('filter' => 1, 'listmode'=>2));
$smallurl	= goods_getcateurl(array('filter' => 1, 'listmode'=>1));

$orderclass[ordertime] = ($filter!=1) ? 'ordertime' : 'ordertimeon';
$orderclass[orderview] = ($filter!=2) ? 'orderview' : 'orderviewon';
$orderclass[orderrecommend] = ($filter!=3) ? 'orderrecommend' : 'orderrecommendon';
$orderclass[orderdiscount] = ($filter!=4) ? 'orderdiscount' : 'orderdiscounton';
$orderclass[orderclick] = ($filter!=5) ? 'orderclick' : 'orderclickon';

$orderby = 't.istop desc,t.isrecommend desc,t.ishot desc, t.displayorder,t.gid desc';
$where = array();
if ($filter==2) {

	$orderby = 't.dateline desc';
		
}
elseif ($filter==3) {

	$where[] = '(t.isrecommend=1 or t.istop=1)';
	$orderby = 't.istop desc,t.displayorder,t.isrecommend desc';
		
}	
elseif ($filter==4) {

	$orderby = 't.price';
		
}
elseif ($filter==5) {

	$orderby = 'tt.views desc';
		
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
$defaultkeyword = goods_modlang('defaultkeyword');
if(!empty($keyword)){

	$searchfield = array('t.name', 't.content ', 't.description', 't.introduction', 't.attribute');
	$searchtext = array();
	foreach($searchfield as $v) {
	
		$searchtext[] = "(".$v." LIKE '%".$keyword."%')";
		
	}
	$where[] = '('.implode(' OR ',$searchtext).')';
	$defaultkeyword = $keyword;
	$extra = '&keyword='.urlencode($keyword);
	
}

$count = C::t('#sanree_brand_goods#sanree_brand_goods')->count_by_wherec($where);
if ($count>0) {

	require_once libfile('function/discuzcode');
	$fgoods_list = array();
	$datalist = C::t('#sanree_brand_goods#sanree_brand_goods')->fetch_all_by_searchc($where, $orderby, ($page - 1) * $perpage, $perpage);
	foreach($datalist as $value) {
	
	    $value['cateurl'] = goods_getcateurl(array('tid' => $value['cateid']),TRUE);
		$value['pic'] = goods_getforumimg($value['homeaid'], 0 , 168, 168);
		if ($ismultiple==1) {
			$icqline = getfirsticq($value[$icq]);
			$value['icq'] = empty($icqline) ? srlang('zanwustr') : str_replace('{icqnumber}',$icqline, $icqshow);	
		} else {
			$value['qq'] = empty($value['qq']) ? srlang('zanwustr') : str_replace('{icqnumber}',getfirsticq($value['qq']), $icqshow);
		}	
	    $fgoods_list[] = array(
			'name' => $value['name'], 
			'cateurl' 		=> $value['cateurl'],
			'catename'		=> $value['catename'],
			'url'			=> goods_getburl($value),
			'pic' 			=> $value['pic'],
			'price'			=> $value['price'],
			'minprice'		=> $value['minprice'],
			'qq'			=> $value['qq'],
			'icq'			=> $value['icq'],
			'priceunit'		=> $value['priceunit'],
		);
		
	}
	
	$murl= $is_rewrite ? goods_getcateurl(array('tid' => $cateid, 'listmode' => $listmode)).'?t'.$extra : goods_getcateurl(array('tid' => $cateid, 'listmode' => $listmode)).$extra;
	$multi = multi ( $count, $perpage, $page, $murl);	
}

$orderby = 't.istop desc,t.displayorder, t.dateline desc';
$where=array(
	'c.status=1',
	't.isrecommend=1',
	't.status=1'
 );
$recommendgoods=array();
foreach(C::t('#sanree_brand#sanree_brand_goods')->fetch_all_by_searchc($where, $orderby, 0, 4) as $value) {

	$value['url'] = goods_getburl($value);
	$value['pic'] = goods_getforumimg($value['homeaid'], 0 , 180, 180);
	$recommendgoods[]= array('pic' => $value['pic'], 'url' =>$value['url'],'name' => $value['name'],'gid' => $value['gid']);
	
}
$orderby = 't.istop desc,t.displayorder, t.dateline desc';
$where=array(
	'c.status=1',
	't.ishot=1',
	't.status=1'
 );
$hotgoods=array();
foreach(C::t('#sanree_brand#sanree_brand_goods')->fetch_all_by_searchc($where, $orderby, 0, 4) as $value) {

	$value['url'] = goods_getburl($value);
	$value['pic'] = goods_getforumimg($value['homeaid'], 0 , 180, 180);
	$hotgoods[]= array('priceunit'=> $value['priceunit'],'price'=> $value['price'],'minprice'=> $value['minprice'],'goodsname' => $value['name'],'pic' => $value['pic'], 'url' =>$value['url']);
	
}

$orderby = 't.istop desc,t.displayorder, t.dateline desc';
$where=array(
	'c.status=1',
	't.isrecommend=1',
	't.status=1'
 );
$Recommendnum = intval($brand_config['Recommendnum']);
$recommendlist=array();
foreach(C::t('#sanree_brand#sanree_brand_businesses')->fetch_all_by_searchc($where, $orderby, 0, $Recommendnum) as $value) {

    if ($value['recommendimg']) {
	
		$valueparse = parse_url($value['recommendimg']);
		if(isset($valueparse['host'])) {
		
			$value['recommendimg'] = $value['recommendimg'];
			
		} else {
		
			$value['recommendimg'] = $_G['setting']['attachurl'].'common/'.$value['recommendimg'].'?'.random(6);
			
		}
		
	}
	else {
	
		$value['recommendimg'] = sr_brand_IMG.'/none1.gif';
		
	}
	$value['forum_thread'] = C::t('#sanree_brand#forum_thread')->fetch($value['tid']);
	if ($reurlmode==1) {
	
		$url = empty($value['weburl']) || $value['weburl']=='http://' ? getburl($value): $value['weburl'];
		
	}
	else {
	
		$url = getburl($value);
		
	}
	$recommendlist[]= array('views' => $value['forum_thread']['views'],'name'=> $value['name'], 'img' => '<img src="'.$value['recommendimg'].'" alt="'.$value['name'].'" />', 'url' =>$url);
	
}
$slidelist = array();
$slide = DB::fetch_first("SELECT * FROM ".DB::table('sanree_brand_goods_slide'));
if ($slide) {
   for($j=1;$j<6;$j++) {

		if ($slide['pic'.$j])  {
		
			$picurl = goods_fiximage($slide['pic'.$j]);
			$link =  $slide['movie'.$j]; 
			$slidelist[] =  array('pic' => $picurl, 'url' => $link);
			  
		}
   }
}

if (defined('IN_MOBILE') && !defined('TPL_DEFAULT')) {
	
	foreach($GLOBALS['category_list'] as $key => $value) {
		if(!$key) {
			continue;	
		}
		$subcategory = C::t('#sanree_brand#sanree_brand_goods_category')->getcategory_by_pcateid(intval($key));
		$sub_lsit = array();
		foreach($subcategory as $subcate) {
			
			$subcate_list = array(
				'name' => $subcate['name'],
				'url' => 'plugin.php?id=sanree_brand_goods&mod=index&tid='.$subcate['cateid']
			);
			$sub_lsit[] = $subcate_list;
		}
		$value['sublist'] = $sub_lsit;
		$category_lists[] = $value;
	}
		
	$GLOBALS['category_list'] = $category_lists;

}

include templateEx($plugin['identifier'].':'.$template.'/index');
?>