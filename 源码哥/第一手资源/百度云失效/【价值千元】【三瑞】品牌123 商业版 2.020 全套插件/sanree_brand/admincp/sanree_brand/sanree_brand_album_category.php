<?php

/**
 *      [fx8.cc] (C)2014-2017 ymg6.Com.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: sanree_brand_album_category.php 2014-07-29 10:20:00 sanree checkedby fx8.cc $
 */

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('');
}
$do= $_G['sr_do'];

if(!in_array($do, array('list', 'upgrading'))) {
	$do = 'list';
}

if ($do == 'upgrading') {
    $catid = intval($_G['sr_catid']);
	if(submitcheck('addsubmit')){
	
	    $setarr = array();
	    $catname = dhtmlspecialchars(trim($_G['sr_catname']));
		if (empty($catname)) {
			cpmsg_error($langs['error_nametip']);
		}	
		$setarr['catname'] = $catname;
		$setarr['description'] = dhtmlspecialchars(trim($_G['sr_description']));
		$setarr['displayorder'] = intval(trim($_G['sr_displayorder']));

		if ($catid) {
		
			C::t('#sanree_brand#sanree_brand_album_category')->update($catid, $setarr);
			
		}
		else {
			$brandname = dhtmlspecialchars(trim($_G['sr_brandname']));
			if (empty($brandname)) {
				cpmsg_error($langs['error_brandnametip']);
			}		
			$brand = C::t('#sanree_brand#sanree_brand_businesses')->fetch_by_brandname($brandname);	
			if (!$brand) {
			
				cpmsg_error($langs['error_bid']);
				
			}
			$setarr['bid'] = $brand[bid];
			$setarr['uid'] = $brand[uid];
		    $setarr['dateline'] = TIMESTAMP;
			C::t('#sanree_brand#sanree_brand_album_category')->insert($setarr);
		}
		cpmsg($langs['succeed'], $gotourl.'album_category', 'succeed');				
	}
	else {
	    showsubmenu($menustr);	
		showtableheader('', 'nobottom');		
		showtablerow('', array(), 
		array(
			'<ul class="tab1">'.
			'<li class="current"><a href="'.ADMINSCRIPT.'?action=plugins&operation=config&act=album_category&identifier=sanree_brand&pmod=admincp"><span>'.$langs['albumcate'].'</span></a></li>'.
			'<li><a href="'.ADMINSCRIPT.'?action=plugins&operation=config&act=album&identifier=sanree_brand&pmod=admincp"><span>'.$langs['piclist'].'</span></a></li></ul>'
		));
		showtablefooter();
		$view= '';
		if($catid>0) {
		    $menustr = $langs['editalbumcate'];
		    $result = C::t('#sanree_brand#sanree_brand_album_category')->get_by_catid($catid);
			$view = 'readonly';	
        }
		else {	
		    $menustr = $langs['addalbumcate'];
			$result['status'] = 1;
			$result['displayorder'] = 0;
		}	
		showformheader($thisurl."&do=".$do."&catid=".$catid."&page=".$page, 'enctype');
		showtableheader($menustr, 'nobottom');
		($catid>0) && showsetting($langs['user'], 'user', $result['username'], 'text', $view);
		showsetting($langs['error_brand'], 'brandname', $result['brandname'], 'text', $view);
		showsetting($langs['albumcatename'], 'catname', $result['catname'], 'text');
		showsetting('description', 'description', $result['description'], 'textarea');
		$result['dateline'] && showsetting($langs['dateline'], 'dateline', dgmdate($result[dateline]), 'text','1');
		showsetting($langs['showorder'], 'displayorder', $result['displayorder'], 'text');
		showsubmit('addsubmit');
		showtablefooter();
		showformfooter();		
	}
}
elseif ($do == 'list') {
	if(submitcheck('submit')){

		if(is_array($_G['sr_groupnamenewadd'])) {
			foreach($_G['sr_groupnamenewadd'] as $k => $v) {
				if($v) {
					$setarr = array(
						'catname' => $v,
						'displayorder' => $_G['sr_groupordernewadd'][$k],
						'uid' => $_G['uid'],
						'dateline' => TIMESTAMP
					);
					C::t('#sanree_brand#sanree_brand_album_category')->insert($setarr);
				}
			}
		}
	
		if(is_array($_G['sr_group_title'])) {	    
			foreach($_G['sr_group_title'] as $id => $title) {
				if(!$_G['sr_delete'][$id]) {
					$setarr = array(
						'catname' => $_G['sr_group_title'][$id],
						'displayorder' => $_G['sr_group_order'][$id],
					);
					C::t('#sanree_brand#sanree_brand_album_category')->update($id,$setarr);
				}
			}
			
		}		
		if($_G['sr_delete']) {
			mydeletealbums($_G['sr_delete']);
			
		}		
		sanreeupdatecache('category');
		cpmsg($langs['succeed'], "action=".$thisurl, 'succeed');
	}else{
		showsubmenu($menustr);
		showtableheader('', 'nobottom');		
		showtablerow('', array(), 
		array(
			'<ul class="tab1">'.
			'<li class="current"><a href="'.ADMINSCRIPT.'?action=plugins&operation=config&act=album_category&identifier=sanree_brand&pmod=admincp"><span>'.$langs['albumcate'].'</span></a></li>'.
			'<li><a href="'.ADMINSCRIPT.'?action=plugins&operation=config&act=album&identifier=sanree_brand&pmod=admincp"><span>'.$langs['piclist'].'</span></a></li></ul>'
		));
		showtablefooter();
		
		$skeyword = $_G['sr_skeyword'];
		showformheader($thisurl);
		showtableheader($langs['searchbar'], '', 'style="border:1px solid #F0F7FD"');
		showtablerow('', '', $langs['skeyword'].'<input type="text" name="skeyword" value="'.$skeyword.'" class="txt" style="width:200px;" /> <input type="submit" value="'.$langs['search'].'" class="btn" name="searchsubmit"/>');
		showtablefooter();
		showformfooter();
				
		showformheader($thisurl);
		showtableheader($langs['albumcate'], 'nobottom');
		showsubtitle(array('',$langs['showorder'], $langs['albumcatename'], $langs['error_brand'],$langs['user'], $langs['count'],'time', 'operation'));
		
		$perpage = 10;
		$resultempty = FALSE;
		$orderby = $searchtext = $extra = $srchuid = '';
		$orderby = "c.displayorder,c.dateline desc ";
		$searchtext = ' AND c.upid=0 ';
		
		if(!empty($skeyword)){
		
			$searchfield = array('c.catname', 'c.pic', 'c.description', 'b.name','m.username');
			$search = array();
			foreach($searchfield as $v) {
			
				$search[] = "(".$v." LIKE '%".$skeyword."%')";
				
			}
			$searchtext .= " AND (".implode(' OR ',$search).")";
			$extra = '&skeyword='.urlencode($skeyword);
		}	
				
		$count = C::t('#sanree_brand#sanree_brand_album_category')->count_by_where($searchtext);
		$multipage=multi($count, $perpage, $page, ADMINSCRIPT."?action=plugins&operation=config&act=$act&identifier=sanree_brand&pmod=admincp$extra");	
		
		$category = C::t('#sanree_brand#sanree_brand_album_category')->fetch_all_by_search($searchtext,$orderby,(($page - 1) * $perpage),$perpage);
		foreach($category as $group) {
		
			$wherealbumsub = array();
		    $wherealbumsub[] = 'catid = '.$group[catid];		
			$count = C::t('#sanree_brand#sanree_brand_album')->count_by_wherec($wherealbumsub);
			$statusstr = $group[status]==1 ? ' checked="checked"':'';
			showtablerow('', array('', 'class="td25"', 'class="td27"'), array(
						"<input class=\"checkbox\" type=\"checkbox\" name=\"delete[$group[catid]]\" value=\"$group[catid]\">",
						"<input type=\"text\" class=\"txt\" name=\"group_order[$group[catid]]\" value=\"$group[displayorder]\">",					
						"<input type=\"text\" class=\"txt\"  name=\"group_title[$group[catid]]\" value=\"$group[catname]\">".$ststr,
						'<div style="width:260px; overflow: hidden;word-wrap:normal;	white-space:nowrap;	-o-text-overflow:ellipsis;	text-overflow:ellipsis;">'.$group['brandname'].'</div>',
						$group['username'],						
						$count,
						$group[dateline] ? dgmdate($group[dateline]):'',
						'<a href="###" onclick="location.href=\''.ADMINSCRIPT.'?action=plugins&operation=config&act=album_category&do=upgrading&identifier=sanree_brand&pmod=admincp&do=upgrading&catid='.$group['catid']."&page=".$_G['sr_page'].'\'">'.$lang['edit'].'</a>'
					));

		}
		echo '<tr><td>&nbsp;</td><td colspan="5"><div><a href="###" onclick="location.href=\''.ADMINSCRIPT.'?action=plugins&operation=config&act=album_category&do=upgrading&identifier=sanree_brand&pmod=admincp&do=upgrading\'" class="addtr">'.$langs['addalbumcate'].'</a></div></td></tr>';		
		showsubmit('submit', 'submit', 'del', '', $multipage, false);
		showtablefooter();
		showformfooter();		
	}
}
//www-FX8-co
?>