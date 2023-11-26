<?php

/**
 *      [fx8.cc] (C)2014-2017 ymg6.Com.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: sanree_brand_maps_index.php sanree $
 */

if(!defined('IN_DISCUZ')) {
	exit('2014061214Ic3aq0hli3||15441||1402027202');
}
$perpage = $shownum;
$copyrightshow = $copyrightpass=='www.fx8.cc' ? 0 : 1;
$pid		= 0;
$cateid 	= intval($_G[sr_tid]);
$did 		= intval($_G[sr_did]);
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
$page 		= intval($_G[sr_page]);
$page 		= max(1, intval($page));
$start 		= ($page - 1) * $perpage;
$start 		= max(0, $start);
$filter 	= intval($_G[sr_filter]);
$filterarr =  array(1, 2 , 3, 4, 5, 6);
!in_array($filter,$filterarr) && $filter = 1;

$multi 		= '';
$keyword 	= dhtmlspecialchars(trim($_G[sr_keyword]));	
$category_list = $subcategory_list = array();
require_once libfile('class/sanree_brand_maps_category','plugin/sanree_brand_maps');
$categoryclass 		= new sanree_brand_category('sanree_brand');
$categoryclass->show($is_rewrite);
$pid 				= $categoryclass->_pid;
$category_list 		= $categoryclass->_category_list;
$subcategory_list 	= $categoryclass->_subcategory_list;
$navigation 		= $categoryclass->_navigation;
$location = $categoryclass->_location;

if ($isselfdistrict==1) {

	require_once libfile('class/sanree_brand_selfdistrict','plugin/sanree_brand');
	$districtclass 		= new sanree_brand_selfdistrict('sanree_brand');
	
}
else {

	require_once libfile('class/sanree_brand_district','plugin/sanree_brand');
	$districtclass 		= new sanree_brand_district('sanree_brand');
	
}
$districtclass->show($is_rewrite);
$districtcategory_list 		= $districtclass->_category_list;
$districtnavigation 		= $districtclass->_navigation;
$districtsearch = $districtclass->_search;
$businesses_list = array();
$where = array();
foreach($districtsearch as $key => $val) {

	$where[] = "t.$key = '$val'";
	
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
		
	} else {
	
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

} else {

	$where[] = 'c.status=1';
	$where[] = 't.status=1';
	$where[] = 't.isshow=1';
	
}

$defaultkeyword = srlang('defaultkeyword');
$extra = '';
if(!empty($keyword)){

	$searchfield = array('t.name', 't.propaganda ', 't.introduction', 't.contact', 't.weburl', 't.address', 't.tel');
	$searchtext = array();
	foreach($searchfield as $v) {
	
		$searchtext[] = "(".$v." LIKE '%".$keyword."%')";
		
	}
	$where[] = '('.implode(' OR ',$searchtext).')';
	$defaultkeyword = $keyword;
	$extra = '&keyword='.urlencode($keyword);
	
}

$pidurl 	= maps_getcateurl(array('tid' => $pid));
$orderurl1 	= maps_getcateurl(array('filter' => 1));
$orderurl2 	= maps_getcateurl(array('filter' => 2));
$orderurl3 	= maps_getcateurl(array('filter' => 3));
$orderurl4 	= maps_getcateurl(array('filter' => 4));
$orderurl5 	= maps_getcateurl(array('filter' => 5));
$orderurl6 = maps_getcateurl(array('filter' => 6));
$bigurl	= maps_getcateurl(array('filter' => 1, 'listmode'=>2));
$smallurl	= maps_getcateurl(array('filter' => 1, 'listmode'=>1));

$orderclass[ordertime] = ($filter!=1) ? 'ordertime' : 'ordertimeon';
$orderclass[orderview] = ($filter!=2) ? 'orderview' : 'orderviewon';
$orderclass[orderrecommend] = ($filter!=3) ? 'orderrecommend' : 'orderrecommendon';
$orderclass[orderdiscount] = ($filter!=4) ? 'orderdiscount' : 'orderdiscounton';
$orderclass[orderclick] = ($filter!=5) ? 'orderclick' : 'orderclickon';
$orderclass[orderexponent] = ($filter!=6) ? 'orderexponent' : 'orderexponenton';

$allwhere=array();
$allwhere[] = 'c.status=1';
$allwhere[] = 't.status=1';
$allwhere[] = 't.isshow=1';
$allcount = C::t('#sanree_brand#sanree_brand_businesses')->count_by_wherec($allwhere);

$orderby = 't.istop desc,t.isrecommend desc,t.groupid desc, t.displayorder,t.bid desc';	
if ($filter==2) {

	$orderby = 't.dateline desc';
		
}
elseif ($filter==3) {

	$where[] = '(t.isrecommend=1 or t.istop=1)';
	$orderby = 't.istop desc,t.displayorder,t.isrecommend desc';
		
}	
elseif ($filter==4) {

	$orderby = 't.discount desc';
		
}
elseif ($filter==5) {

	$orderby = 'tt.views desc';
		
} elseif ($filter==6) {

	$orderby = 't.recommendationindex desc';
		
}
$mapfield = 'mappos';
if ($mapapi=='google') {

	$where[] = 't.googlemappos is not null';
	$where[] = "t.googlemappos <> ''";	
	$mapfield = 'googlemappos';
	
} elseif ($mapapi=='baidu') {

	$where[] = 't.mappos is not null';
	$where[] = "t.mappos <> ''";
	$mapfield = 'mappos';
	
}

$count = C::t('#sanree_brand#sanree_brand_businesses')->count_by_wherec($where);
if ($count>0) {

	require_once libfile('function/discuzcode');
    $j=0;
	$fbusinesses_list=array();
	$mapposlist = array();
	$infolist = array();
	$code = 65;
	foreach(C::t('#sanree_brand#sanree_brand_businesses')->fetch_all_by_searchc($where, $orderby, ($page - 1) * $perpage, $perpage) as $value) {

		if($value['poster']) {
		
			$valueparse = parse_url($value['poster']);
			if(isset($valueparse['host'])) {
			
				$value['poster'] = $value['poster'];
				
			} else {
			
				$value['poster'] = $_G['setting']['attachurl'].'category/'.$value['poster'].'?'.random(6);
				
			}
			
		} else {
		
			$value['poster'] = sr_brand_IMG.'/none.gif';
			
		}
		$value['weburl'] = str_replace('http://','',$value['weburl']);	
		$value['propaganda'] = empty($value['propaganda']) ? srlang('zanwustr') : discuzcode($value['propaganda']);
		$value['introduction'] = empty($value['introduction']) ? srlang('zanwustr') : discuzcode($value['introduction']);
		$value['contact'] = empty($value['contact']) ? srlang('zanwustr') : discuzcode($value['contact']);
		$value['cateurl'] = getcateurl(array('tid' => $value['cateid']),TRUE);
		$value['turl'] = getburl($value);
		$value['alt']  = str_replace('{catename}', $value['name'], srlang('weburltip'));
		$value['addtime'] = dgmdate($value['addtime'] );
		$value['forum_thread'] = C::t('#sanree_brand#forum_thread')->fetch($value['tid']);
		$value['weburlstr'] = empty($value['weburl']) ? srlang('zanwustr') : '<a href="http://'.$value[weburl].'" rel="nofollow" target="_blank" title="'.$value[alt].'">'.$value[weburl].'</a>';
		$value['tel114url']	= '';
		$tel114id = intval($value['tel114id']);
		if (($tel114id >0)&&($tel114version >=1121)) {
		
			$url = $tel114_is_rewrite ? 'tel114-view-'.$tel114id.'.html' : 'plugin.php?id=sanree_tel114&mod=view&tid='.$tel114id;
			$value['tel114url'] = "<a href=\"".$url."\" onclick=\"showWindow('showtelkey', this.href)\"><img height=18 width=18 align=\"absmiddle\" src=\"".sr_brand_IMG."/tel114.png\" /></a>";
			
		}
		$value['qq'] = empty($value['qq']) ? srlang('zanwustr') : '<a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin='.$value['qq'].'&site=qq&menu=yes"><img border="0" src="http://wpa.qq.com/pa?p=2:'.$value['qq'].':41" alt="'.srlang('qqtipmsg').'" title="'.srlang('qqtipmsg').'"></a>';
		$value['address'] = empty($value['address']) ? srlang('zanwustr') : $value['address'];
		$value['recommendationindex'] = empty($value['recommendationindex']) ? '99.9' : $value['recommendationindex'];
		$value['tel'] = getfirsticq($value['tel']);
		$value['class'] = $value['istop'] ? 'dtop': '';
		$value['class'] = empty($value['class']) && $value['isrecommend'] ? 'drec': $value['class'];
		$value['discount'] = intval($value['discount']);
		$businesses_list[$i][] = $value;
		$fbusinesses_list[] = array(
		    'name' 			=> $value['name'],
			'poster' 		=> $value['poster'],
			'cateurl' 		=> $value['cateurl'],
			'currentlocation' => $categoryclass->getcatelocal($value['cateid']),
			'addtime' 		=> $value['addtime'],
			'weburlstr' 	=> $value['weburlstr'],
			'tel114url' 	=> $value['tel114url'],
			'catename'		=> $value['catename'],
			'uid'			=> $value['uid'],
			'tid'			=> $value['tid'],
			'turl'			=> $value['turl'],
			'username'		=> $value['username'],
			'qq'			=> $value['qq'],
			'address'		=> $value['address'],
			'groupid'		=> $value['groupid'],
			'groupimg'		=> getgroupimg($value['groupid']),
			'region'		=> $value['region'],
			'tel'			=> $value['tel'],
			'mappos'        => $value[$mapfield],
			'index'			=> $j,
			'code'          => chr($code),
		);
		$mapposlist[] = "'".$value[$mapfield]."'";
		$nowmapshowtxt = $mapshowtxt;
		$rearray= array('{goto}','{name}','{url}','{tel}','{logo}','{address}','{star}');
		$star= "<img src=\"$_G[siteurl]/source/plugin/sanree_brand/tpl/good/images/st.png\" />";
		$goto = str_replace('{url}', $value['turl'], maps_modlang('goto'));
		$toarray= array($goto,$value['name'],$value['turl'],$value['tel'],$value['poster'],$value['address'],$star.$star.$star.$star.$star);
		$nowmapshowtxt = str_replace($rearray,$toarray, $nowmapshowtxt);
		$infolist[] = "'".$nowmapshowtxt."'";
		$j++;
		$code++;
	}
	$mapposliststr = implode($mapposlist, ',');
	$infoliststr = implode($infolist, ',');
	$murl= $is_rewrite ? maps_getcateurl(array('tid' => $cateid, 'listmode' => $listmode)).'?t'.$extra : maps_getcateurl(array('tid' => $cateid, 'listmode' => $listmode)).$extra;
	$multi = sanreepage($count, $perpage, $murl);//multi ( $count, $perpage, $page, $murl);
	
}
$mapapistr = $mapapi == 'baidu' ? maps_modlang('baidumaps') : maps_modlang('googlemaps');
$navigation = '<em>&raquo;</em>'.$mapapistr;
include templateEx($plugin['identifier'].':'.$template."/".$mod.'_'.$mapapi);
?>