<?php

/**
 *      [fx8.cc] (C)2014-2017 ymg6.Com.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: sanree_brand_index.php sanree $
 */

if(!defined('IN_DISCUZ')) {
	exit('');
}

$flashadurl = 'data/cache/sanree_brand_flashad.xml';
$pid = 0;
$cateid = intval($_G['sr_tid']);
$did = intval($_G['sr_did']);
$tag = intval($_G['sr_tag']);
$copyrightshow = ($copyrightpass=='www.fx8.cc') ? 0 : 1;
if ($isindexlist==1) {

    if (isset($_GET['listmode'])) {
	
		$listmode = intval($_G[sr_listmode]);
		
	} else {
	
		$listmode = $isindexlist;
		
	}
	
} else {

	$listmode 	= intval($_G['sr_listmode']);
	
}
!in_array($listmode,array(0, 1, 2)) && $listmode = 0;
$slistmode = $listmode;
!in_array($slistmode,array(0, 1)) && $slistmode = 0;
$perpage = $shownum;
$page = intval($_G['sr_page']);
$page = max(1, intval($page));
$start = ($page - 1) * $perpage;
$start = max(0, $start);
$filter = intval($_G['sr_filter']);
$filterarr = array(1, 2 , 3, 4, 5, 6);
!in_array($filter,$filterarr) && $filter = 1;
$multi = '';
$keyword = dhtmlspecialchars(trim($_G['sr_keyword']));
$allcategorytitle = '';
$category_list = $subcategory_list = array();
require_once libfile('class/'.$plugin['identifier'].'_category','plugin/'.$plugin['identifier']);
$categoryclass = new sanree_brand_category($plugin['identifier'], $allcategorytitle);
$categoryclass->show($is_rewrite);
$pid = $categoryclass->_pid;
$category_list = $categoryclass->_category_list;
$subcategory_list = $categoryclass->_subcategory_list;
$navigation = $categoryclass->_navigation;
$location = $categoryclass->_location;
$subcategory_bird = $categoryclass->getsubcategory_bird($category_list);

if ($isselfdistrict==1) {

	require_once libfile('class/'.$plugin['identifier'].'_selfdistrict','plugin/'.$plugin['identifier']);
	$districtclass = new sanree_brand_selfdistrict($plugin['identifier']);

} else {

	require_once libfile('class/'.$plugin['identifier'].'_district','plugin/'.$plugin['identifier']);
	$districtclass = new sanree_brand_district($plugin['identifier']);

}
$districtclass->show($is_rewrite);
$districtcategory_list = $districtclass->_category_list;
$districtnavigation = $districtclass->_navigation;
$districtsearch = $districtclass->_search;
$where = $businesses_list = array();
if (!empty($tag)) {

	$tagname = C::t('#sanree_brand#sanree_brand_tag')->gettagid_by_tagid($tag);
	$where[] = "t.brandtag LIKE '%".$tagname."%'";

}
if (is_array($districtsearch)) {
	foreach($districtsearch as $key => $val) {

		$where[] = "t.$key = '$val'";

	}
}
if ($cateid>0) {

    $cateids = array();
	$cateids[] = $cateid;
	if (is_array($subcategory_list)) {

	   foreach($subcategory_list as $key => $val) {

		   $cateids[] = $key;

	   }

	}
	$ids = implode($cateids, ',');
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

	$searchfield = array('t.name', 't.propaganda ', 't.introduction', 't.contact', 't.weburl', 't.address', 't.qq', 't.brandno',
	       't.msn', 't.wangwang', 't.baiduhi', 't.skype', 't.tel', 't.weburl', 't.description', 't.keywords',
		   't.birthprovince', 't.birthcity', 't.birthdist', 't.birthcommunity',
		   't.srbirthprovince', 't.srbirthcity', 't.srbirthdist', 't.srbirthcommunity',
		   't.mappos', 't.googlemappos', 't.brandtag'
	);
	$searchtext = array();
	foreach($searchfield as $v) {

		$searchtext[] = "(".$v." LIKE '%".$keyword."%')";

	}
	$where[] = '('.implode(' OR ',$searchtext).')';
	$defaultkeyword = $keyword;
	$extra = '&keyword='.urlencode($keyword);

}
$pidurl = getcateurl(array('tid' => $pid));
$orderurl1 = getcateurl(array('filter' => 1));
$orderurl2 = getcateurl(array('filter' => 2));
$orderurl3 = getcateurl(array('filter' => 3));
$orderurl4 = getcateurl(array('filter' => 4));
$orderurl5 = getcateurl(array('filter' => 5));
$bigurl = getcateurl(array('filter' => 1, 'listmode'=>2));
$smallurl = getcateurl(array('filter' => 1, 'listmode'=>1));
$orderclass['ordertime'] = ($filter!=1) ? 'ordertime' : 'ordertimeon';
$orderclass['orderview'] = ($filter!=2) ? 'orderview' : 'orderviewon';
$orderclass['orderrecommend'] = ($filter!=3) ? 'orderrecommend' : 'orderrecommendon';
$orderclass['orderdiscount'] = ($filter!=4) ? 'orderdiscount' : 'orderdiscounton';
$orderclass['orderclick'] = ($filter!=5) ? 'orderclick' : 'orderclickon';
$orderclass['orderexponent'] = ($filter!=6) ? 'orderexponent' : 'orderexponenton';
$allcount = C::t('#sanree_brand#sanree_brand_businesses')->count_by_wherec(array('c.status=1', 't.status=1', 't.isshow=1'));
$orderby = 't.istop desc,t.isrecommend desc,t.groupid desc, t.displayorder,t.bid desc';	
if ($filter==2) {

	$orderby = 't.dateline desc';
		
} elseif ($filter==3) {

	$where[] = '(t.isrecommend=1 or t.istop=1)';
	$orderby = 't.istop desc,t.displayorder,t.isrecommend desc';
		
} elseif ($filter==4) {

	$orderby = 't.discount desc';
		
} elseif ($filter==5) {

	$orderby = 'tt.views desc';
		
} elseif ($filter==6) {

	$orderby = 't.recommendationindex desc';
		
}

$count = C::t('#sanree_brand#sanree_brand_businesses')->count_by_wherec($where);
if ($count>0) {

	require_once libfile('function/discuzcode');
    $j = 0;
	$fbusinesses_list=array();
	foreach(C::t('#sanree_brand#sanree_brand_businesses')->fetch_all_by_searchc($where, $orderby, ($page - 1) * $perpage, $perpage) as $value) {

	    $i = $j % 3;
	    $j++;
        $value['poster'] = srfiximages($value['poster']);
		$value['weburl'] = str_replace('http://','',$value['weburl']);	
		$value['propaganda'] = empty($value['propaganda']) ? srlang('zanwustr') : discuzcode($value['propaganda'], 0, 0);
		$value['introduction'] = empty($value['introduction']) ? srlang('zanwustr') : discuzcode($value['introduction'], 0, 0);
		$value['contact'] = empty($value['contact']) ? srlang('zanwustr') : discuzcode($value['contact'], 0, 0);
		$value['cateurl'] = getcateurl(array('tid' => $value['cateid']),TRUE);
		$value['turl'] = getburl($value);
		$value['alt'] = str_replace('{catename}', $value['name'], srlang('weburltip'));
		$value['addtime'] = dgmdate($value['addtime'] );
		$value['forum_thread'] = C::t('#sanree_brand#forum_thread')->fetch($value['tid']);
		$value['weburlstr'] = empty($value['weburl']) ? srlang('zanwustr') : '<a href="http://'.$value['weburl'].'" rel="nofollow" target="_blank" title="'.$value['alt'].'">'.$value['weburl'].'</a>';
		$value['address'] = empty($value['address']) ? srlang('zanwustr') : $value['address'];
		$value['recommendationindex'] = empty($value['recommendationindex']) ? '99.9' : $value['recommendationindex'];
		$value['class'] = $value['istop'] ? 'dtop': '';
		$value['class'] = empty($value['class']) && $value['isrecommend'] ? 'drec': $value['class'];
		$value['discount'] = intval($value['discount']);
		$value['tel114url'] = '';
		$tel114id = intval($value['tel114id']);
		if (($tel114id >0)&&($tel114version >=1121)) {
		
			$url = $tel114_is_rewrite ? 'tel114-view-'.$tel114id.'.html' : 'plugin.php?id=sanree_tel114&mod=view&tid='.$tel114id;
			$value['tel114url'] = "<a href=\"".$url."\" onclick=\"showWindow('showtelkey', this.href)\"><img height=18 width=18 align=\"absmiddle\" src=\"".sr_brand_IMG."/tel114.png\" /></a>";
			
		}
		if ($ismultiple==1&&$value['allowmultiple']==1) {
			$icqline = getfirsticq($value[$icq]);
			$value['icq'] = empty($icqline) ? srlang('zanwustr') : str_replace('{icqnumber}',$icqline, $icqshow);	
			$value['tel'] = getfirsticq($value['tel']);	
		} else {
			$value['qq'] = empty($value['qq']) ? srlang('zanwustr') : str_replace('{icqnumber}',getfirsticq($value['qq']), $icqshow);
		}	
		$businesses_list[$i][] = $value;
		$fbusinesses_list[] = array(
		    'name' => $value['name'],
			'jindex' => $j,
			'poster' => ($issmallpic==1) ? brand_getlogo($value['bid'], 0 , 120, 85, 'fixnone') : $value['poster'],
			'propaganda' => $value['propaganda'],
			'cateurl' => $value['cateurl'],
			'currentlocation' => $categoryclass->getcatelocal($value['cateid']),
			'addtime' => $value['addtime'],
			'weburlstr' => $value['weburlstr'],
			'tel114url' => $value['tel114url'],
			'catename' => $value['catename'],
			'uid' => $value['uid'],
			'tid' => $value['tid'],
			'turl' => $value['turl'],
			'username' => $value['username'],
			'allowmultiple' => $value['allowmultiple'],
			'qq' => $value['qq'],
			'msn' => $value['msn'],
			'wangwang' => $value['wangwang'],
			'icq' => $value['icq'],
			'address' => $value['address'],
			'groupid' => $value['groupid'],
			'groupimg' => getgroupimg($value['groupid']),
			'tel' => $value['tel'],
			'discount' => $config['selectdiscountshow'][$value['discount']],
			'recommendationindex' => $value['recommendationindex'],
			'class' => $j % 3 == 0 ? ' class="'.$value['class'].'"':' class="mr10 '.$value['class'].'"',
			'forum_thread' => array(
							'views' 	=> $value['forum_thread']['views'],
							'replies' 	=> $value['forum_thread']['replies'],
							'favtimes' 	=> $value['forum_thread']['favtimes']  
							)
		);
	}
	
	$murl= $is_rewrite ? getcateurl(array('tid' => $cateid, 'listmode' => $listmode)).'?t'.$extra : getcateurl(array('tid' => $cateid, 'listmode' => $listmode, 'tag'=>$tag)).$extra;
	$multi = multi ( $count, $perpage, $page, $murl);
	
}
$published_data3 = str_replace('{adminabouturl}', $adminabouturl, srlang('published_data3'));
$orderby = 't.istop desc,t.displayorder, t.dateline desc';
$recommendlist=array();
foreach(C::t('#sanree_brand#sanree_brand_businesses')->fetch_all_by_searchc(array('c.status=1', 't.isrecommend=1', 't.status=1'), $orderby, 0, $Recommendnum) as $value) {

	$value['recommendimg'] = srfiximages($value['recommendimg'], 'common', '/none1.gif');
	if ($reurlmode==1) {
	
		$url = empty($value['weburl']) || $value['weburl']=='http://' ? getburl($value) : $value['weburl'];
		
	} else {
	
		$url = getburl($value);
		
	}
	$recommendlist[]= array('name'=> $value['name'], 'img' => '<img src="'.$value['recommendimg'].'" alt="'.$value['name'].'" />', 'url' => $url);
	
}
$templatefile = templateEx($plugin['identifier'].':'.$template.'/index');
$_G['style']['tpldirectory'] = 'tpl/'.$_G['template'];
$_G['style']['tplfile'] = 'index';
$_G['style']['tplsavemod'] = 1;
include $templatefile;
?>