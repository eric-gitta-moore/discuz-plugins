<?php

/**
 *      [fx8.cc] (C)2014-2017 ymg6.Com.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: sanree_brand_hello.php 2014-07-29 10:20:00 sanree checkedby fx8.cc $
 */

if(!defined('IN_DISCUZ')) {
	exit('');
}
$mod = 'index';
$pid = 0;
$tag = urldecode($_G['sr_tag']);
$cateid = intval($_G['sr_tid']);
$did = intval($_G['sr_did']);
$attes = intval($_G['sr_attestation']);
$copyrightshow = ($copyrightpass=='www.fx8.cc') ? 0 : 1;
if ($isindexlist==1 || $isindexlist==3) {

    if (isset($_GET['listmode'])) {
	
		$listmode = intval($_G[sr_listmode]);
		
	} else {
	
		$listmode = $isindexlist;
		
	}
	
} else {

	$listmode 	= intval($_G['sr_listmode']);
	
}
!in_array($listmode,array(0, 1, 2, 3)) && $listmode = 0;
$slistmode = $listmode;
!in_array($slistmode,array(0, 1, 2)) && $slistmode = 0;
list($showbig,$showmiddle,$showsmall) = explode(',',$config['helloshownum']);
$showbig = $showbig ? intval($showbig) : 10;
$showmiddle = $showmiddle ? intval($showmiddle) : 18;
$showsmall = $showsmall ? intval($showsmall) : 12;
$shownum = $showsmall;
$logow = 120;
$logoh = 85;
$slistmode= array();	
$slistmode['big'] = 0;
$slistmode['small'] = 0;
$slistmode['middle'] = 0;
$classindex = 0;
if ($listmode==0||$listmode==2) {
	$shownum = $showbig;
	$logow = 322;
	$logoh = 242;	
	$slistmode['big'] = 1;
	$classindex = 2;	
} elseif ($listmode==3) {
	$shownum = $showmiddle;
	$logow = 210;
	$logoh = 158;
	$slistmode['middle'] = 1;
	$classindex = 3;		
} elseif ($listmode==1){
	$logow = 130;
	$logoh = 98;
	$slistmode['small'] = 1;
	$classindex = 1;	
}
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
$allcategorytitle =  srlang('notlimited');
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

	$tagurl  = getcateurl();
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
$orderurl6 = getcateurl(array('filter' => 6));
$bigurl = getcateurl(array('filter' => 1, 'listmode'=>2));
$smallurl = getcateurl(array('filter' => 1, 'listmode'=>1));
$middleurl = getcateurl(array('filter' => 1, 'listmode'=>3));
$orderclass['ordertime'] = ($filter!=1) ? 'ordertime' : 'ordertimeon';
$orderclass['orderview'] = ($filter!=2) ? 'orderview' : 'orderviewon';
$orderclass['orderrecommend'] = ($filter!=3) ? 'orderrecommend' : 'orderrecommendon';
$orderclass['orderdiscount'] = ($filter!=4) ? 'orderdiscount' : 'orderdiscounton';
$orderclass['orderclick'] = ($filter!=5) ? 'orderclick' : 'orderclickon';
$orderclass['orderexponent'] = ($filter!=6) ? 'orderexponent' : 'orderexponenton';
if ($attes == 1) {
	$attestation = getcateurl(array('attestation' => 0));
	$checked = 'checked';
} else {
	$attestation = getcateurl(array('attestation' => 1));
}
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
if ($_G['cache']['plugin']['sanree_mcertification']['isopen'] && $attes==1) {
	$count_by = 'count_by_wherecrz';
	$fetch_all_by = 'fetch_all_by_searchrz';
} else {
	$count_by = 'count_by_wherec';
	$fetch_all_by = 'fetch_all_by_searchc';
}
$count = C::t('#sanree_brand#sanree_brand_businesses')->$count_by($where);
if ($count>0) {

	require_once libfile('function/discuzcode');
	$fbusinesses_list=array();
	foreach(C::t('#sanree_brand#sanree_brand_businesses')->$fetch_all_by($where, $orderby, ($page - 1) * $perpage, $perpage) as $value) {

		$value['recommendationindex'] = empty($value['recommendationindex']) ? '99.9' : $value['recommendationindex'];
		$value['class'] = $value['istop'] ? 'dtop': '';
		$value['class'] = empty($value['class']) && $value['isrecommend'] ? 'drec': $value['class'];
		$value['discount'] = intval($value['discount']);
		$value['tel114url'] = '';
		$tel114id = intval($value['tel114id']);
		if (($tel114id >0)&&($tel114version >=1121)) {
		
			$url = $tel114_is_rewrite ? 'tel114-view-'.$tel114id.'.html' : 'plugin.php?id=sanree_tel114&mod=view&tid='.$tel114id;
			$value['tel114url'] = "<a href=\"".$url."\" onclick=\"showWindow('showtelkey', this.href)\"><img height=18 width=18 align=\"absmiddle\" src=\"".sr_brand_IMG."/stel114.jpg\" /></a>";
			
		}
		if ($ismultiple==1&&$value['allowmultiple']==1) {
			$icqline = getfirsticq($value[$icq]);
			$value['icq'] = empty($icqline) ? srlang('zanwustr') : str_replace('{icqnumber}',$icqline, $icqshow);	
			$value['tel'] = getfirsticq($value['tel']);	
		} else {
			$value['qq'] = empty($value['qq']) ? srlang('zanwustr') : str_replace('{icqnumber}',getfirsticq($value['qq']), $icqshow);
		}	
		$voter = C::t('#sanree_brand#sanree_brand_voter')->getvotetotal_by_tid(intval($value['tid']));		
		$voter[2] = $voter[2] == 0 ? 1 : $voter[2];
		$v1 = round($voter[1]/$voter[2], 1);
		list($vn1, $vn2) = explode('.', $v1);
		$value['cateurl'] = getcateurl(array('tid' => $value['cateid']),TRUE);
		$mtf = $_G['cache']['plugin']['sanree_mcertification']['isopen'];
		list($tel) = explode(',',$value['tel']);
		if($mtf){
			$mcertification = C::t('#sanree_mcertification#sanree_mcertification')->gettype_by_bid(intval($value['bid']));
			$mgif = 'source/plugin/sanree_mcertification/tpl/default/mcertification/brandimg/none.png';
			if ($mcertification) {
				$mgif = $mcertification['type'] ? 'source/plugin/sanree_mcertification/tpl/default/mcertification/brandimg/personal.png' : 'source/plugin/sanree_mcertification/tpl/default/mcertification/brandimg/company.png';
			}
		}
		$fbusinesses_list[] = array(
			'weixin' => $value['weixin'],
			'wximg' => $value['weixinimg'],
			'wxplublic' => $value['weixinpublic'],
			'wxppic' => $value['weixinpublicpic'],
			'tel114id' => $value['tel114id'],
			'allowfastpost' => $value['allowfastpost'],
			'bid' => $value['bid'],
			'tid' => $value['tid'],
			'mtype' => $mcertification,
			'isrecommend' => $value['isrecommend'],
			'istop' => $value['istop'],		
			'mcertification' => $mgif,
		    'catename' => $value['catename'],
			'cateurl' => $value['cateurl'],
		    'name' => $value['name'],
			'poster' => ($issmallpic==1 && !$config['isbird']) ? brand_getlogo($value['bid'], 0 , $logow, $logoh, 'fixnone') : newtheme($value['poster']),
			'addtime' => dgmdate($value['addtime']),
			'tel114url' => $value['tel114url'],
			'turl' => getburl($value),
			'qq' => $value['qq'],
			'msn' => $value['msn'],
			'wangwang' => $value['wangwang'],
			'icq' => $value['icq'],
			'address' => empty($value['address']) ? srlang('zanwustr') : $value['address'],
			'groupsmallicons' => getgroupsmallicons($value['groupid']),			
			'tel' => $tel,
			'sdiscount' => $value['discount'],
			'pbid' => intval($value['pbid']),
			'iscard' => intval($value['iscard']),
			'discount' => $config['selectdiscountshow'][$value['discount']],
			'recommendarr' => explode('.', $value['recommendationindex']),
			'voter' => intval($vn1),
			'voter2' => intval($vn2),
			'satisfaction' => $voter[3],
			'detailurl' => getdetailurl($value),
			'recommendationindex' => $value['recommendationindex'],
			'class' => ' class="'.$value['class'].'" ',
			'forum_thread' => array(
							'views' 	=> $value['tviews'],
							)
		);
	}

	$murl= $is_rewrite ? getcateurl(array('tid' => $cateid, 'listmode' => $listmode)).'?t'.$extra : getcateurl(array('tid' => $cateid, 'listmode' => $listmode)).$extra;
	$multi = sanree_brand_multi ( $count, $perpage, $page, $murl);	
	
}

$recommendlist = sanreeloadcache('recommendlist');
$tabHead['goods'] = $tabHead['news'] = $tabHead['coupon'] ='';
$tabBody['goods'] = $tabBody['news'] = $tabBody['coupon'] ='';
$installmode = array();
$goods_config = $_G['cache']['plugin']['sanree_brand_goods'];
if ($goods_config['isopen']) {
	$modfile = DISCUZ_ROOT.'./source/plugin/sanree_brand_goods/function/function_module.php';
	@require_once($modfile);
	$modurl_goods = goods_getmodeurl();
	$selectpriceunit = $goods_config['selectpriceunit'];
	$marr = explode("\r\n", $selectpriceunit);
	foreach($marr as $row) {
	
		list($key , $val) = explode("=", $row);
		$goods_config['selectpriceunitshow'][trim($key)] = goods_shtmlspecialchars(trim($val));
		
	}
	$orderby = 't.istop desc,t.displayorder, t.dateline desc';
	$where=array(
		'c.status=1',
		't.isrecommend=1',
		't.status=1'
	 );
	$re_goodslist=array();
	foreach(C::t('#sanree_brand#sanree_brand_goods')->fetch_all_by_searchc($where, $orderby, 0, 5) as $value) {
	
		$value['url'] = goods_getburl($value);
		$value['pic'] = goods_getforumimg($value['homeaid'], 0 , 180, 135, 'fixwr');
		$priceunit = $goods_config['selectpriceunitshow'][$value['priceunit']];	
		$re_goodslist[]= array('pic' => $value['pic'], 'url' =>$value['url'],'name' => $value['name'],'gid' => $value['gid'], 'sminprice' => $priceunit.$value['minprice']);
		
	}
	$orderby = 't.dateline desc';
	$where=array(
		'c.status=1',
		't.status=1'
	 );
	$new_goodslist=array();
	foreach(C::t('#sanree_brand#sanree_brand_goods')->fetch_all_by_searchc($where, $orderby, 0, 5) as $value) {
	
		$value['url'] = goods_getburl($value);
		$value['pic'] = goods_getforumimg($value['homeaid'], 0 , 80, 80);
		$priceunit = $goods_config['selectpriceunitshow'][$value['priceunit']];		
		$new_goodslist[]= array('pic' => $value['pic'], 'url' =>$value['url'],'name' => $value['name'],'gid' => $value['gid'], 'sprice' => $priceunit.$value['price'], 'sminprice' => $priceunit.$value['minprice']);
		
	}
	if ($new_goodslist) $installmode[] = '"goods"';
	$tabHead['goods'] = ' class="c_active"';
	$tabBody['goods'] = ' c_current';	
}
$news_config = $_G['cache']['plugin']['sanree_brand_news'];
if ($news_config['isopen']) {
	$modfile = DISCUZ_ROOT.'./source/plugin/sanree_brand_news/function/function_module.php';
	@require_once($modfile);
	$modurl_news = news_getmodeurl();
	$orderby = 't.istop desc,t.displayorder, t.dateline desc';
	$where=array(
		'c.status=1',
		't.isrecommend=1',
		't.status=1',
		't.homeaid>0',
	 );
    $re_newslist = array(1);
	$re_news_imglist=array();
	foreach(C::t('#sanree_brand#sanree_brand_news')->fetch_all_by_searchc($where, $orderby, 0, 4) as $value) {
	
		$value['url'] = news_getburl($value);
		$value['pic'] = news_getforumimg($value['homeaid'], 0 , 80, 60);
		$re_news_imglist[]= array('pic' => $value['pic'], 'url' =>$value['url'],'name' => $value['name'],'gid' => $value['gid']);
		
	}
	$orderby = 't.istop desc,t.displayorder, t.dateline desc';
	$where=array(
		'c.status=1',
		't.isrecommend=1',
		't.status=1',
	 );
	$re_news_textlist=array();
	foreach(C::t('#sanree_brand#sanree_brand_news')->fetch_all_by_searchc($where, $orderby, 0, 10) as $value) {
	
		$value['url'] = news_getburl($value);
		$re_news_textlist[]= array('url' =>$value['url'],'name' => $value['name'],'gid' => $value['gid']);
		
	}
	$re_news_textlist1=array();
	for($i = 2; $i < 6; $i++) {
	
		if ($re_news_textlist[$i]) {
		
			$re_news_textlist1[]=$re_news_textlist[$i];
			
		}
		
	}
	$re_news_textlist2=array();
	for($i = 6; $i < 10; $i++) {
		if ($re_news_textlist[$i]) {
		
			$re_news_textlist2[]=$re_news_textlist[$i];
			
		}
	}	
	$orderby = 't.dateline desc';
	$where=array(
		'c.status=1',
		't.status=1',
	 );
	$new_newslist=array();
	foreach(C::t('#sanree_brand#sanree_brand_news')->fetch_all_by_searchc($where, $orderby, 0, 14) as $value) {
	
		$value['url'] = news_getburl($value);
		$new_newslist[]= array('url' =>$value['url'],'name' => $value['name'],'gid' => $value['gid']);
		
	}
	$tabHead['news'] = empty($tabHead['goods']) ? ' class="c_active"' : '';
	$tabBody['news'] = empty($tabBody['goods']) ? ' c_current' : '';
	if ($new_newslist) $installmode[] = '"news"';
	
}	
$coupon_config = $_G['cache']['plugin']['sanree_brand_coupon'];
if ($coupon_config['isopen']) {
	$modfile = DISCUZ_ROOT.'./source/plugin/sanree_brand_coupon/function/function_module.php';
	@require_once($modfile);
	$modurl_coupon = coupon_getmodeurl();
	$selectpriceunit = $coupon_config['selectpriceunit'];
	$marr = explode("\r\n", $selectpriceunit);
	foreach($marr as $row) {
	
		list($key , $val) = explode("=", $row);
		$coupon_config['selectpriceunitshow'][trim($key)] = coupon_shtmlspecialchars($val);
		
	}
	$orderby = 't.istop desc,t.displayorder, t.dateline desc';
	$where=array(
		'c.status=1',
		't.isrecommend=1',
		't.status=1'
	 );
	$re_couponlist=array();
	foreach(C::t('#sanree_brand#sanree_brand_coupon')->fetch_all_by_searchc($where, $orderby, 0, 5) as $value) {
	
		$value['url'] = coupon_getburl($value);
		$value['pic'] = coupon_getforumimg($value['homeaid'], 0 , 180, 135, 'fixwr');
		$priceunit = $coupon_config['selectpriceunitshow'][$value['priceunit']];	
		$re_couponlist[]= array('pic' => $value['pic'], 'url' =>$value['url'],'name' => $value['name'],'gid' => $value['gid'], 'sminprice' => $priceunit.$value['minprice']);
		
	}
	$orderby = 't.dateline desc';
	$where=array(
		'c.status=1',
		't.status=1'
	 );
	$new_couponlist=array();
	foreach(C::t('#sanree_brand#sanree_brand_coupon')->fetch_all_by_searchc($where, $orderby, 0, 6) as $value) {
	
		$value['url'] = coupon_getburl($value);
		$value['pic'] = coupon_getforumimg($value['homeaid'], 0 , 80, 60);
		$priceunit = $coupon_config['selectpriceunitshow'][$value['priceunit']];
		$enddate = $value['enddate'] ? coupon_modlang('enddatestr').dgmdate($value['enddate'],'d') : '';
		$new_couponlist[]= array('enddate'=> $enddate, 'pic' => $value['pic'], 'url' =>$value['url'],'name' => $value['name'],'gid' => $value['gid'], 'sprice' => $priceunit.$value['price'], 'sminprice' => $priceunit.$value['minprice']);
		
	}
	$tabHead['coupon'] = empty($tabHead['goods'])&&empty($tabHead['news']) ? ' class="c_active"' : '';
	$tabBody['coupon'] = empty($tabBody['goods'])&&empty($tabBody['news']) ? ' c_current' : '';
	if ($new_couponlist) $installmode[] = '"coupon"';
	
}
$installmodestr = implode(',', $installmode);
if($config['isbird']) {
	
	$slideid = 3;

} else {
	
	if ($hellobigslide==1) {
		$slideid = 2;
	} else {
		$slideid = 1;
	}
}
$slidelistarr = sanreeloadcache('slidelist');

$slide = DB::fetch_first("SELECT * FROM ".DB::table('sanree_brand_slide').' where id=3');
if(!$slide) {

	$slidelistarr[3] = array(
		array(
			'pic' => 'source/plugin/sanree_brand/tpl/bird/images/banner.jpg',
			'url' => 'http://www.fx8.cc/',
			'color' => '#EEEDE9'
		 ),
		array(
			'pic' => 'source/plugin/sanree_brand/tpl/bird/images/testbanner.jpg',
			'url' => 'http://www.fx8.cc/',
			'color' => '#FFE8EB'
		)
	);

}else {
	
	for($j=1;$j<6;$j++) {
		
		if(!$slide['pic'.$j]) {
			continue;
		}
		
		$slides = array(
			'pic' => $_G['setting']['attachurl'].'common/'.$slide['pic'.$j],
			'url' => $slide['movie'.$j],
			'color' => $slide['movie'.$j.$j]
		);
		$slidelistarr[3][] = $slides;
	}
	
}
$slidelist = $slidelistarr[$slideid];
$newbrandlist = sanreeloadcache('newbrandlist');
$hotbrandlist = sanreeloadcache('hotbrandlist');
if (intval($_G['cache']['plugin']['sanree_brand_help']['isopen'])==1) {

	$helpcate = sanreeloadcache('help');
		
}
$picload = ($isslideload==1) ? 'file' : 'src';

$friendly_link = C::t('#sanree_brand#sanree_brand_friendly_link')->fetch_all();

$themestyle = 'hello';
$stheme = array('christmas', 'newyear', 'springfestival');
if(in_array($frontpagestyle, $stheme)){
	$themestyle = $frontpagestyle;
}

$niceindexad = explode("\r\n",$config['niceindexad']);

include templateEx($plugin['identifier'].':'.$template.'/'.$themestyle);
?>