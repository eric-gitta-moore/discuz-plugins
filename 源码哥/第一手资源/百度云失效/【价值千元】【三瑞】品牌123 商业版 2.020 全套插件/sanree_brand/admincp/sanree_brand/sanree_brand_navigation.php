<?php

/**
 *      [Sanree] (C)2012-2099 Sanree Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: sanree_brand_cmenu.php $
 */

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('');
}

$do = $_G['sr_do'];
$doarray = array('list', 'upgrading');
$do = !in_array($do,$doarray) ? 'list' : $do;
$_G['sr_page'] = isset($_G['sr_page']) ? $_G['sr_page'] : 0;

if ($do == 'list') {
	if(submitcheck('submit')){
		
		$setarr=array(
			'myalbum' => intval($_G['sr_myalbum']),
			'dzgroup' => intval($_G['sr_dzgroup']),
			'goods' => intval($_G['sr_goods']),
			'news' => intval($_G['sr_news']),
			'coupon' => intval($_G['sr_coupon']),
			'jobs' => intval($_G['sr_jobs']),
			'video' => intval($_G['sr_video']),
			'guestbook' => intval($_G['sr_guestbook']),
			'ordinary' => intval($_G['sr_ordinary']),
		);
		C::t('#sanree_brand#sanree_brand_menu_order')->update('0',$setarr);
		
		cpmsg($langs['succeed'],'action=plugins&operation=config&act=navigation&identifier=sanree_brand&pmod=admincp&page='.$page, 'succeed');	
	
	}
	else
	{	
		showsubmenu($menustr);	
		showformheader($thisurl);
		showtableheader($langs['navigation'], 'nobottom');
		showsubtitle(array($langs['navigation_name'], $langs['brandindex'], $langs['myalbum'],$langs['dzgroup'], $langs['h_goods'], $langs['h_news'], $langs['h_coupon'], $langs['h_jobs'], $langs['h_video'], $langs['h_guestbook'], $langs['ordinary']));
		$menuorder = C::t('#sanree_brand#sanree_brand_menu_order')->fetch_all();
		
		
		showtablerow('', array('class="td22"', 'class="td28"','class="td28"', 'class="td28"', 'class="td28"', 'class="td28"', 'class="td28"', 'class="td28"', 'class="td28"', 'class="td28"', 'class="td28"'), array(
		"$lang[display_order]",
		$menuorder['index'],
		"<input type=\"text\" class=\"txt\" size=\"12\" name=\"myalbum\" value=\"$menuorder[myalbum]\">",
		"<input type=\"text\" class=\"txt\" size=\"12\" name=\"dzgroup\" value=\"$menuorder[dzgroup]\">",
		"<input type=\"text\" class=\"txt\" size=\"12\" name=\"goods\" value=\"$menuorder[goods]\">",
		"<input type=\"text\" class=\"txt\" size=\"12\" name=\"news\" value=\"$menuorder[news]\">",
		"<input type=\"text\" class=\"txt\" size=\"12\" name=\"coupon\" value=\"$menuorder[coupon]\">",
		"<input type=\"text\" class=\"txt\" size=\"12\" name=\"jobs\" value=\"$menuorder[jobs]\">",
		"<input type=\"text\" class=\"txt\" size=\"12\" name=\"video\" value=\"$menuorder[video]\">",
		"<input type=\"text\" class=\"txt\" size=\"12\" name=\"guestbook\" value=\"$menuorder[guestbook]\">",
		"<input type=\"text\" class=\"txt\" size=\"12\" name=\"ordinary\" value=\"$menuorder[ordinary]\">",
		));
			
		showsubmit('submit', 'submit');
		showtablefooter();
		showformfooter();
	}	
}
//From:www_YMG6_COM
?>