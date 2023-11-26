<?php

/**
 *      [fx8.cc] (C)2014-2017 ymg6.Com.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: sanree_brand_home.php zs $
 */
if(!defined('IN_DISCUZ')) {
	exit('');
}
$copyrightshow = ($copyrightpass=='www.fx8.cc') ? 0 : 1;
$pid    = 0;
$cateid = intval($_G['sr_tid']);
$did    = intval($_G['sr_did']);

$coupon_config   = $_G['cache']['plugin']['sanree_brand_coupon'];
$goods_config    = $_G['cache']['plugin']['sanree_brand_goods'];
$news_config     = $_G['cache']['plugin']['sanree_brand_news'];
$jobs_config     = $_G['cache']['plugin']['sanree_brand_jobs'];
$activity_config = $_G['cache']['plugin']['sanree_brand_activity'];
$tel_config      = $_G['cache']['plugin']['sanree_tel114'];

$brandurl = getcateurl();

$selectnotice = $config['nicenotice'];
$nicenoticeshow  = explode("\r\n", $selectnotice);

$selectnav = $config['nicenav'];
$nicennavshow  = explode("\r\n", $selectnav);

if ($config['nicepopularize']) {
	$nicepopularize = explode(',',$config['nicepopularize']);
}
$nicead = explode("\r\n",$config['nicead']);

$allcategorytitle =  srlang('notlimited');
$category_list = $subcategory_list = array();
require_once libfile('class/'.$plugin['identifier'].'_category','plugin/'.$plugin['identifier']);
$categoryclass = new sanree_brand_category($plugin['identifier'], $allcategorytitle);
$categoryclass->show($is_rewrite);
$pid = $categoryclass->_pid;
$category_list = $categoryclass->_category_list;
$navigation = $categoryclass->_navigation;
$location = $categoryclass->_location;
$subcategory_bird = $categoryclass->getsubcategory_bird($category_list);

$where = array();
$where [] = 'c.status=1';
$where [] = 't.status=1';
$where [] = 't.isshow=1';
$bwhere[] = 'c.status=1';
$bwhere[] = 't.status=1';
$bwhere[] = 't.isshow=1';
$tjwhere  = array('c.status=1', 't.isshow=1', 't.isshow=1', 't.isrecommend');
$hotwhere = array('c.status=1', 't.ishot=1', 't.status=1', 't.isshow=1');

$brandhotlist = sanreeloadcache('hotbrandlist');

$brandlist = array();
foreach(C::t('#sanree_brand#sanree_brand_businesses')->fetch_all_by_searchc($where, 'displayorder,bid desc', 0, 8) as $key => $brand) {

	$brand['poster']  = newtheme($brand['poster']);
	list($brand['tel']) = explode(',',$brand['tel']);
	if ($reurlmode==1) {

		$brand['url'] = empty($brand['weburl']) || $brand['weburl']=='http://' ? getburl($brand): $brand['weburl'];

	} else {

		$brand['url'] = getburl($brand);

	}

	$brandlist[$key]  = $brand;

}

$brandtjlist = array();
foreach(C::t('#sanree_brand#sanree_brand_businesses')->fetch_all_by_searchc($tjwhere, 't.istop desc,t.displayorder, t.dateline desc', 0, 24) as $key => $brandtj) {

	$brandtj['poster']  = newtheme($brandtj['poster']);
	if ($reurlmode==1) {

		$brandtj['url'] = empty($brandtj['weburl']) || $brandtj['weburl']=='http://' ? getburl($brandtj): $brandtj['weburl'];

	} else {

		$brandtj['url'] = getburl($brandtj);

	}
	$brandtjlist[$key]  = $brandtj;

}

$re = 3;
$brandtglist = array();
foreach ($nicepopularize as $key => $bid) {

	$brandtg = C::t('#sanree_brand#sanree_brand_businesses')->get_all_by_bid($bid);

	if ($goods_config['isopen'] && $brandtg['bid']) {

		$goodscount = DB::fetch_first("SELECT COUNT(*) FROM ".DB::table('sanree_brand_goods').' where bid='.$brandtg['bid']);
		$brandtg['tggoods'] = $goodscount['COUNT(*)'];

	}
	if ($coupon_config['isopen'] && $brandtg['bid']) {

		$couponcount = DB::fetch_first("SELECT COUNT(*) FROM ".DB::table('sanree_brand_goods').' where bid='.$brandtg['bid']);
		$brandtg['tgcoupon'] = $couponcount['COUNT(*)'];

	}

	$brandtg['poster']  = newtheme($brandtg['poster']);
	if ($reurlmode==1) {

		$brandtg['url'] = empty($brandtg['weburl']) || $brandtg['weburl']=='http://' ? getburl($brandtg): $brandtg['weburl'];

	} else {

		$brandtg['url'] = getburl($brandtg);

	}

	$brandtglist[$key] = $brandtg;
	$re--;
	if (!$re) {
		break;
	}
}

$arr = array(3,2,1);
if ($re) {
	foreach ($arr as $key) {
		$brandtglist[$key] = false;
		$re--;
		if (!$re) {
			break;
		}
	}
}

if ($coupon_config['isopen']) {
	$selectpriceunit = $coupon_config['selectpriceunit'];
	$marr = explode("\r\n", $selectpriceunit);
	foreach($marr as $row) {

		list($key , $val) = explode("=", $row);
		$coupon_config['selectpriceunitshow'][trim($key)] = coupon_shtmlspecialchars(trim($val));

	}
	$couponurl= coupon_getcateurl();
	$couponlist = array();
	foreach(C::t('#sanree_brand_coupon#sanree_brand_coupon')->fetch_all_by_searchc($bwhere, 'displayorder,bid desc', 0, 8) as $key => $coupon) {

		$coupon['pic'] = (intval($coupon['homeaid'])>0) ? coupon_getforumimg($coupon['homeaid'], 0 , 183, 155) : 'static/image/common/nophoto.gif';
		$coupon['url'] = coupon_getburl($coupon);
		$coupon['content'] = preg_replace("/\[attachimg\](\d+)\[\/attachimg\]/ies", '', $coupon['content']);
		$coupon['priceunit'] = $coupon_config['selectpriceunitshow'][$coupon['priceunit']];
		$couponlist[$key] = $coupon;

	}

	$couponhotlist = array();
	foreach(C::t('#sanree_brand_coupon#sanree_brand_coupon')->fetch_all_by_searchc($hotwhere, 't.istop desc,t.displayorder, t.dateline desc', 0, 5) as $key => $couponhot) {

		$couponhot['pic'] = (intval($couponhot['homeaid'])>0) ? coupon_getforumimg($couponhot['homeaid'], 0 , 75, 75) : 'static/image/common/nophoto.gif';
		$couponhot['url'] = coupon_getburl($couponhot);
		$couponhot['priceunit'] = $coupon_config['selectpriceunitshow'][$couponhot['priceunit']];
		$couponhotlist[$key] = $couponhot;

	}
}

if ($goods_config['isopen']) {
	$selectpriceunit = $goods_config['selectpriceunit'];
	$marr = explode("\r\n", $selectpriceunit);
	foreach($marr as $row) {

		list($key , $val) = explode("=", $row);
		$goods_config['selectpriceunitshow'][trim($key)] = goods_shtmlspecialchars(trim($val));

	}
	$goodsurl = goods_getcateurl();
	$goodslist = array();
	foreach(C::t('#sanree_brand_goods#sanree_brand_goods')->fetch_all_by_searchc($bwhere, 'displayorder,bid desc', 0, 6) as $key => $goods) {

		$goods['pic'] = goods_getforumimg($goods['homeaid'], 0 , 242, 230);
		$goods['url'] = goods_getburl($goods);
		$goods['content'] = preg_replace("/\[attachimg\](\d+)\[\/attachimg\]/ies", '', $goods['content']);
		$goods['priceunit'] = $goods_config['selectpriceunitshow'][$goods['priceunit']];
		$goodslist[$key] = $goods;

	}

	$goodshotlist = array();
	foreach(C::t('#sanree_brand_goods#sanree_brand_goods')->fetch_all_by_searchc($hotwhere, 't.istop desc,t.displayorder, t.dateline desc', 0, 3) as $key => $goodshot) {

		$goodshot['pic'] = goods_getforumimg($goodshot['homeaid'], 0 , 222, 133);
		$goodshot['url'] = goods_getburl($goodshot);
		$goodshot['priceunit'] = $goods_config['selectpriceunitshow'][$goodshot['priceunit']];
		$goodshotlist[$key] = $goodshot;

	}

	$goodstjlist = array();
	foreach(C::t('#sanree_brand_goods#sanree_brand_goods')->fetch_all_by_searchc($tjwhere, 'displayorder,bid desc', 0, 3) as $key => $goodstj) {

		$goodstj['pic'] = goods_getforumimg($goodstj['homeaid'], 0 , 490, 230);
		$goodstj['url'] = goods_getburl($goodstj);
		$goodstj['priceunit'] = $goods_config['selectpriceunitshow'][$goodstj['priceunit']];
		$goodstjlist[$key] = $goodstj;

	}
}

if ($news_config['isopen']) {
	$newsurl = news_getcateurl();
	$newslist = array();
	$re = 0;
	foreach(C::t('#sanree_brand_news#sanree_brand_news')->fetch_all_by_searchc($bwhere, 't.istop desc,t.displayorder, t.dateline desc', 0, 17) as $key => $news) {

		$news['pic'] = $news['homeaid'] ? news_getforumimg($news['homeaid'], 0 , 242, 230) : 'source/plugin/sanree_brand/tpl/nice/images/new_smallnopic.png';
		$news['url'] = news_getburl($news);

		if ($re < 8) {

			if ($re < 4) {
				$nl_tl[$key] = $news;
			} else {
				$nl_bl[$key] = $news;
			}

		} elseif ($re < 12) {

			if ($re == 8) {
				$news['content'] = preg_replace("/\[attachimg\](\d+)\[\/attachimg\]/ies", '', $news['content']);
				$nt_tn[$key] = $news;
			} else {
				$nt_bn[$key] = $news;
			}

		} elseif ($re < 18) {

			if ($re < 14) {
				$np_tp[$key] = $news;
			} else {
				$np_bn[$key] = $news;
			}

		}

		$re++;
	}

	$newstjlist = array();
	foreach(C::t('#sanree_brand_news#sanree_brand_news')->fetch_all_by_searchc($tjwhere, 't.istop desc,t.displayorder, t.dateline desc', 0, 5) as $key => $newstj) {

		$newstj['pic'] = $newstj['homeaid'] ? news_getforumimg($newstj['homeaid'], 0 , 350, 165) : 'source/plugin/sanree_brand/tpl/nice/images/new_smallnopic.png';
		$newstj['url'] = news_getburl($newstj);
		$newstjlist[$key] = $newstj;

	}
}

if ($jobs_config['isopen']) {
	$jobsurl = jobs_getcateurl();
	$jobslist = array();
	foreach(C::t('#sanree_brand_jobs#sanree_brand_jobs')->fetch_all_by_searchc($bwhere, 'displayorder,bid desc', 0, 10) as $key => $jobs) {

		$jobs['url'] = jobs_getburl($jobs);
		$jobslist[$key] = $jobs;

	}
}

if ($activity_config['isopen']) {
	$activityurl = activity_getcateurl();
	$activitylist = array();
	foreach(C::t('#sanree_brand_activity#sanree_brand_activity')->fetch_all_by_searchc($bwhere, 't.displayorder,t.dateline desc', 0, 5) as $key => $activity) {

		$activity['pic'] = $activity['homeaid'] ? activity_getforumimg($activity['homeaid'], 0 , 242, 230) : 'source/plugin/sanree_brand_activity/tpl/bird/images/nopic.jpg';
		$activity['url'] = activity_getburl($activity);
		$activity['content'] = preg_replace("/\[attachimg\](\d+)\[\/attachimg\]/ies", '', $activity['content']);
		$activity['startdate'] = dgmdate($activity['startdate'],'Y'.srlang('year').'m'.srlang('month').'d'.srlang('day').'');
		$activity['enddate'] = dgmdate($activity['enddate'],'Y'.srlang('year').'m'.srlang('month').'d'.srlang('day').'');
		$activitylist[$key] = $activity;

	}
}

if ($tel_config['isopen']) {
	$telurl = 'plugin.php?id=sanree_tel114';
	$tellist = array();
	$tel_category_list = C::t('#sanree_tel114#tel114_category')->fetch_all_category();
	foreach(C::t('#sanree_tel114#tel114_tel')->fetch_all_by_searchc(array('c.status=1','t.status=1'), 't.istop desc, t.displayorder, t.addtime desc', 0, 10) as $tel) {

		$tel['telcatename'] = $tel_category_list[$tel['cateid']]['name'];
		$tel['url']  = $tel114_is_rewrite ? 'tel114-view-'.$tel['telid'].'.html' : 'plugin.php?id=sanree_tel114&mod=view&tid='.$tel['telid'];
		$tel['name'] = $tel['companyname'];
		$tel['pic'] =  $tel['logo'] ? $_G['setting']['attachurl'].'common/'.$tel['logo'] : 'source/plugin/sanree_tel114/images/logo.jpg';
		$tellist[] = $tel;

	}
}

$userpostlist = array();
$newposter = XDB::fetch_all("SELECT tid, author, authorid, message, dateline FROM %t WHERE fid IN(%n) AND subject='' ORDER BY tid desc LIMIT 0,10", array('forum_post', (array)$bindingforum,));

for ($u = 0; $u < 5; $u++) {

	$newtid[] = $newposter[$u]['tid'];
	$postfour[] = $newposter[$u];
}

$re = 0;
$postbrand = C::t('#sanree_brand#sanree_brand_businesses')->usergetbusinesses_by_tid($newtid);
require_once libfile('function/discuzcode');
foreach ($postfour as $k => $v) {
	foreach ($postbrand as $kk => $vv) {

		if ($v['tid'] == $vv['tid']) {
			$v['message'] = discuzcode($v['message']);
			$v['url'] = getburl($vv);
			$v['dateline'] = dgmdate($v['dateline']);
			$userpostlist[] = array_merge($v,$vv);

		}
	}
}

$slide = DB::fetch_first("SELECT * FROM ".DB::table('sanree_brand_slide').' where id=4');
if(!$slide) {

	$slidelistarr[4] = array(
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
		$slidelistarr[4][] = $slides;
	}

}
$slidelist = $slidelistarr[4];

if (intval($_G['cache']['plugin']['sanree_brand_help']['isopen'])==1) {

	$helpcate = sanreeloadcache('help');

}

$_G['style']['tplfile'] = $template = templateEx($plugin['identifier'].':'.$template.'/home');
include $template;
?>