<?php

/**
 *      [fx8.cc] (C)2014-2017 ymg6.Com.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: sanree_brand_signature_signature.php sanree $
 */
if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('2014061214ZqZQfEgNZb||8228||1402027202');
}
$do= $_G['sr_do'];
$page = max(1, intval($_G['sr_page']));
if(!in_array($do, array('list', 'upgrading'))) {
	$do = 'list';
}
if  ($do == 'upgrading') {

	$signatureid = intval($_G['sr_signatureid']);
	if(submitcheck('addsubmit')){

        $user = dhtmlspecialchars(trim($_G['sr_user']));
		if ($user) {
		
			$uid = C::t('#sanree_brand#xcommon_member')->fetch_uid_by_username($user);	
			if(!$uid) {
			
				cpmsg_error($langs['error_nouser']);
				
			}
			
		} else {
		
			cpmsg_error($langs['error_nouser']);
			
		}
	    $setarr = array();							
		$setarr['bid'] = intval($_G['sr_bid']);
		$setarr['allowshowsignature'] = intval($_G['sr_allowshowsignature']);
		$setarr['uid'] = $uid;
		if ($signatureid>0) {
		
			C::t('#sanree_brand_signature#sanree_brand_signature')->update($signatureid, $setarr);
			
		}
		cpmsg($langs['succeed'],'action=plugins&operation=config&act=signature&identifier=sanree_brand_signature&pmod=admincp&page='.$page, 'succeed');				
	} else {
	
	    showsubmenu($menustr);
		if($signatureid>0) {
		    $menustr = $langs['editbusi'];
		    $result = C::t('#sanree_brand_signature#sanree_brand_signature')->fetch_first_by_signatureid($signatureid);	
			$bids = array();
			$bids[] = array(0,$langs['selected']);
			foreach(C::t('#sanree_brand#sanree_brand_businesses')->fetch_all_by_search("AND uid=$_G[uid] AND status=1",'displayorder',0,1000) as $data) {
			
				$bids[] = array($data[bid],$data[name]);
				
			}
        }
		showformheader($thisurl."&do=".$do."&signatureid=".$signatureid."&page=".$page, 'enctype');
		showtableheader($menustr, 'nobottom');	
		showsetting($langs['username'], 'user', $result['username'], 'text','readonly');	
		showsetting($langs['brandname'], array('bid',$bids), $result['bid'], 'select');	
		showsetting($langs['allowshowsignature'], 'allowshowsignature', $result['allowshowsignature'], 'radio');
		showsubmit('addsubmit');
		showtablefooter();
		showformfooter();
			
	}

} elseif  ($do == 'list') {

	$skeyword = $_G['sr_skeyword'];
	showsubmenu($menustr);	
	showformheader($thisurl);
	showtableheader($langs['searchbar'], '', 'style="border:1px solid #F0F7FD"');
	showtablerow('', '', $langs['skeyword'].'<input type="text" name="skeyword" value="'.$skeyword.'" class="txt" style="width:200px;" /> <input type="submit" value="'.$langs['search'].'" class="btn" name="searchsubmit"/>');
	showtablefooter();
	showformfooter();
	showformheader($thisurl.'&page='.$page);
	showtableheader($langs['signature'], 'nobottom');
	showsubtitle(array($langs['username'],$langs['brandname'], 'operation'));
	$perpage = 10;
	$resultempty = true;
	$orderby = $searchtext = $extra = $srchuid = '';
	$orderby = 'si.signatureid desc';	
	if(!empty($skeyword)){
	
		$searchfield = array('m.username','si.signatureid','si.bid', 'b.name');
		$search = array();
		foreach($searchfield as $v) {
		
			$search[] = "(".$v." LIKE '%".$skeyword."%')";
			
		}
		$searchtext .= " AND (".implode(' OR ',$search).")";
		$extra = '&skeyword='.urlencode($skeyword);
	}	
	$count = C::t('#sanree_brand_signature#sanree_brand_signature')->count_by_wherec($searchtext,$resultempty);
	$multipage=multi($count, $perpage, $page, ADMINSCRIPT."?action=plugins&operation=config&act=$act&identifier=sanree_brand_signature&pmod=admincp$extra");
	$datalist = C::t('#sanree_brand_signature#sanree_brand_signature')->fetch_all_by_searchc($searchtext,$orderby,(($page - 1) * $perpage),$perpage,$resultempty);
	foreach($datalist as $row) {

		$statusstr = $row[status]==1 ? $langs['yes']:$langs['no'];
		$row[cpusername] = C::t('#sanree_brand#xcommon_member')->fetch_all_username_by_uid($row[cpuid]);
		showtablerow('', array(), array(
		!empty($row[username]) ? '<a href="home.php?mod=space&amp;uid='.$row[uid].'" target=_blank>'.$row[username].'</a>' : $langs['guestuser'],
		'<a href="plugin.php?id=sanree_brand&mod=item&tid='.$row[bid].'" target=_blank>'.$row[brandname].'</a>',
		'<a href="###" onclick="location.href=\''.ADMINSCRIPT.'?action=plugins&operation=config&act=signature&identifier=sanree_brand_signature&pmod=admincp&do=upgrading&signatureid='.$row['signatureid']."&page=".$page.'\'">'.$lang['edit'].'</a>',
		));
		
	}
	showsubmit('', '', '', "", $multipage);
	showtablefooter();
	showformfooter();

}
//www-FX8-co
?>