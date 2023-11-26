<?php

/**
 *      [fx8.cc] (C)2014-2017 ymg6.Com.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: sanree_brand_news_index.php sanree $
 */

if(!defined('IN_DISCUZ')) {
	exit('2014072820Zq5a00tJ50||7908||1402027202');
}
$perpage = $shownum;
$copyrightshow = $copyrightpass=='www.fx8.cc' ? 0 : 1;
$pid		= 0;
$did 		= intval($_G[sr_did]);
$nid 		= intval($_G[sr_nid]);
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
$filterarr =  array(1, 2 , 3, 4);
!in_array($filter,$filterarr) && $filter = 1;

$multi 		= '';
$keyword 	= dhtmlspecialchars(trim($_G[sr_keyword]));	
$category_list = $subcategory_list = array();
require_once libfile('class/'.$plugin['identifier'].'_category','plugin/'.$plugin['identifier']);
$categoryclass 		= new sanree_brand_news_category($plugin['identifier']);
$categoryclass->show($is_rewrite);
$pid 				= $categoryclass->_pid;
$category_list 		= $categoryclass->_category_list;
$subcategory_list 	= $categoryclass->_subcategory_list;
$navigation 		= $categoryclass->_navigation;
$location = $categoryclass->_location;
$nowcate = $categoryclass->_nowcate;

$pidurl 	= news_getcateurl(array('tid' => $cateid));
$orderurl1 	= news_getcateurl(array('filter' => 1));
$orderurl2 	= news_getcateurl(array('filter' => 2));
$orderurl3 	= news_getcateurl(array('filter' => 3));
$orderurl4 	= news_getcateurl(array('filter' => 4));
$bigurl	= news_getcateurl(array('filter' => 1, 'listmode'=>2));
$smallurl	= news_getcateurl(array('filter' => 1, 'listmode'=>1));

$orderclass['ordertime'] = ($filter!=1) ? 'ordertime' : 'ordertimeon';
$orderclass['orderview'] = ($filter!=2) ? 'orderview' : 'orderviewon';
$orderclass['orderrecommend'] = ($filter!=3) ? 'orderrecommend' : 'orderrecommendon';
$orderclass['orderclick'] = ($filter!=4) ? 'orderclick' : 'orderclickon';

$orderby = 't.istop desc,t.isrecommend desc,t.ishot desc, t.displayorder,t.nid desc';
$where = array();
if ($filter==2) {

	$orderby = 't.dateline desc';
		
}
elseif ($filter==3) {

	$where[] = '(t.isrecommend=1 or t.istop=1)';
	$orderby = 't.istop desc,t.displayorder,t.isrecommend desc';
		
}	
elseif ($filter==4) {

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

$count = C::t('#sanree_brand_news#sanree_brand_news')->count_by_wherec($where);
if ($count>0) {

	require_once libfile('function/discuzcode');
	$fnews_list = array();
	$datalist = C::t('#sanree_brand_news#sanree_brand_news')->fetch_all_by_searchc($where, $orderby, ($page - 1) * $perpage, $perpage);
	foreach($datalist as $value) {
	
	    $value['cateurl'] = getcateurl(array('tid' => $value['cateid']),TRUE);
		$value['pic'] = $value['homeaid'] ? news_getforumimg($value['homeaid'], 0 , 120, 100) : '';
		$value['qq'] = empty($value['qq']) ? srlang('zanwustr') : '<a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin='.$value['qq'].'&site=qq&menu=yes"><img border="0" src="http://wpa.qq.com/pa?p=2:'.$value['qq'].':16" alt="'.srlang('qqtipmsg').'" title="'.srlang('qqtipmsg').'"></a>';	
	    $fnews_list[] = array(
			'name' => $value['name'], 
			'brandname' => $value['brandname'], 
			'brandurl' =>  news_brandgetburl($value['bid']), 
			'description' => cutstr($value['description'],160), 
			'cateurl' 		=> $value['cateurl'],
			'catename'		=> $value['catename'],
			'url'			=> news_getburl($value),
			'pic' 			=> $value['pic'],
			'dateline'		=> $value['dateline'] ? dgmdate($value[dateline],'d') : '',
			'isrecommend' => intval($value['isrecommend']),
			'showname' => cutstr($value['name'],50),
			'showname1' => cutstr($value['name'],40),
		);
		
	}
	
	$murl= $is_rewrite ? news_getcateurl(array('tid' => $cateid, 'listmode' => $listmode)).'?t'.$extra : news_getcateurl(array('tid' => $cateid, 'listmode' => $listmode)).$extra;
	$multi = multi ( $count, $perpage, $page, $murl);	
}

$orderby = 't.istop desc,t.displayorder, t.dateline desc';
$where=array(
	'c.status=1',
	't.istop=1',
	't.status=1'
 );
$recommendnews=array();
foreach(C::t('#sanree_brand#sanree_brand_news')->fetch_all_by_searchc($where, $orderby, 0, 9) as $value) {

	$value['url'] = news_getburl($value);
	$value['cateurl'] = getcateurl(array('tid' => $value['cateid']),TRUE);
	$recommendnews[]= array('url' =>$value['url'],'showname' => cutstr($value['name'],45),'name' => $value['name'],'catename' => $value['catename'],'cateurl' => $value['cateurl']);
	
}
$orderby = 't.istop desc,t.displayorder, t.dateline desc';
$where=array(
	'c.status=1',
	't.ishot=1',
	't.status=1'
 );
$hotnews=array();
foreach(C::t('#sanree_brand#sanree_brand_news')->fetch_all_by_searchc($where, $orderby, 0, 12) as $value) {

	$value['url'] = news_getburl($value);
	$hotnews[]= array('name' => $value['name'],'showname' => cutstr($value['name'],40), 'url' =>$value['url']);
	
}

$orderby = 't.istop desc,t.displayorder, t.dateline desc';
$where=array(
	'c.status=1',
	't.isrecommend=1',
	't.status=1'
 );
$Recommendnum = 4;
$recommendlist=array();
foreach(C::t('#sanree_brand#sanree_brand_businesses')->fetch_all_by_searchc($where, $orderby, 0, $Recommendnum) as $value) {

    if ($value['recommendimg']) {
	
		$valueparse = parse_url($value['recommendimg']);
		if(isset($valueparse['host'])) {
		
			$value['recommendimg'] = $value['recommendimg'];
			
		} else {
		
			$value['recommendimg'] = $_G['setting']['attachurl'].'common/'.$value['recommendimg'].'?'.random(6);
			
		}
		
	} else {
	
		$value['recommendimg'] = sr_brand_news_IMG.'/none1.gif';
		
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
	
		$value['poster'] = sr_brand_news_IMG.'/none2.gif';
		
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
$slide = DB::fetch_first("SELECT * FROM ".DB::table('sanree_brand_news_slide'));
if ($slide) {

   for($j=1;$j<6;$j++) {

		if ($slide['pic'.$j])  {
		
			$picurl = news_fiximage($slide['pic'.$j]);
			$link =  $slide['movie'.$j]; 
			$slidelist[] =  array('pic' => $picurl, 'url' => $link);
			  
		}
   }
   
}
include templateEx($plugin['identifier'].':'.$template.'/index');
?>