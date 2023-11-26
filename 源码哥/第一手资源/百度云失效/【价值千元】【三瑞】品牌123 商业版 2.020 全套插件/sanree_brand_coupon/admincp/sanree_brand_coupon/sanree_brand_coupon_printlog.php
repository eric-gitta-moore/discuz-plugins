<?php

/**
 *      [fx8.cc] (C)2014-2017 ymg6.Com.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: sanree_brand_coupon_printlog.php sanree $
 */
if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('20131125098bplwO8zuA||12679||1381384801');
}
$do= $_G['sr_do'];
$page = max(1, intval($_G['sr_page']));
if(!in_array($do, array('list'))) {
	$do = 'list';
}
if  ($do == 'list') {

	if(submitcheck('submit')){
	
		if($_G['sr_delete']) {
		
			C::t('#sanree_brand_coupon#sanree_brand_coupon_printlog')->delete($_G['sr_delete']);
			
		}		
		cpmsg($langs['succeed'], 'action=plugins&operation=config&act='.$act.'&identifier=sanree_brand_coupon&pmod=admincp&act=printlog&page='.$page, 'succeed');
		
	 } else {

		$skeyword = $_G['sr_skeyword'];
		showsubmenu($menustr);	 
		showformheader($thisurl);
		showtableheader($langs['searchbar'], '', 'style="border:1px solid #F0F7FD"');
		showtablerow('', '', $langs['skeyword'].'<input type="text" name="skeyword" value="'.$skeyword.'" class="txt" style="width:200px;" /> <input type="submit" value="'.$langs['search'].'" class="btn" name="searchsubmit"/>');
		showtablefooter();
		showformfooter();
		
		showformheader($thisurl.'&page='.$page);
		showtableheader($langs['printlog'], 'nobottom');
		showsubtitle(array('',$langs['printcode'], $lang['name'], 'username', 'time', $langs['status']));
		$perpage = 10;
		$resultempty = FALSE;
		$orderby = $searchtext = $extra = $srchuid = '';
		$orderby = 't.printlogid desc';	
		$searchtext = '';	

		if(!empty($skeyword)){
		
			$searchfield = array('t.username','t.printcode','t.uid','t.puid');
			$search = array();
			foreach($searchfield as $v) {
			
				$search[] = "(".$v." LIKE '%".$skeyword."%')";
				
			}
			$searchtext .= " AND (".implode(' OR ',$search).")";
			$extra = '&skeyword='.urlencode($skeyword);
			
		}	
		$count = C::t('#sanree_brand_coupon#sanree_brand_coupon_printlog')->count_by_wherec($searchtext);
		$multipage=multi($count, $perpage, $page, ADMINSCRIPT."?action=plugins&operation=config&act=$act&identifier=sanree_brand_coupon&pmod=admincp$extra");
		$datalist = C::t('#sanree_brand_coupon#sanree_brand_coupon_printlog')->fetch_all_by_searchd($searchtext,$orderby,(($page - 1) * $perpage),$perpage);
		foreach($datalist as $row) {
		
			$row['status'] = coupon_modlang('couponst'.$row['status']);
			showtablerow('', array(), array(
			"<input class=\"checkbox\" type=\"checkbox\" name=\"delete[$row[printlogid]]\" value=\"$row[printlogid]\">" ,
			$row['printcode'],		
			'<div style=" line-height:20px; overflow:hidden;height:20px;width:200px;"><a href="plugin.php?id=sanree_brand_coupon&mod=couponshow&tid='.$row['cid'].'" target="_blank">'.$row[name].'</a></div>',
			'<a href="home.php?mod=space&amp;uid='.$row['uid'].'" target="_blank">'.$row['username'].'</a>',
			dgmdate($row[dateline]),
			$row['status']
			));
			
		}
		showsubmit('submit', 'submit', 'del', '', $multipage);
		showtablefooter();
		showformfooter();
	}
}
//From:www_YMG6_COM
?>