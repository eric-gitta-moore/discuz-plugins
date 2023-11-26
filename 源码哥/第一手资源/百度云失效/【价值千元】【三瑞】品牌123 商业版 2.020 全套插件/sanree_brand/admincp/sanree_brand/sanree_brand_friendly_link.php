<?php

/**
 *      [Sanree] (C)2012-2099 Sanree Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: sanree_brand_friendly_link.php 2014-07-29 10:20:00 sanree checkedby fx8.cc $
 */

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('');
}

$do = $_G['sr_do'];
$doarray = array('list', 'upgrading');
$do = !in_array($do,$doarray) ? 'list' : $do;
$_G['sr_page'] = isset($_G['sr_page']) ? $_G['sr_page'] : 0;
if ($do == 'upgrading') {
    $flid = intval($_G['sr_flid']);
	if(submitcheck('addsubmit')){
	    $setarr = array();
	    $title = dhtmlspecialchars(trim($_G['sr_title']));
		if (empty($title)) {
			cpmsg_error($langs['error_title']);
		}		
		$setarr['title'] = $title;
		$setarr['url'] = dhtmlspecialchars(trim($_G['sr_url']));
		$setarr['displayorder'] = intval(trim($_G['sr_displayorder']));
		$setarr['status'] = intval(trim($_G['sr_status']));
		if ($flid) {
		
			C::t('#sanree_brand#sanree_brand_friendly_link')->update($flid, $setarr);
			
		} else {

		    $setarr['dateline'] = TIMESTAMP;			
			C::t('#sanree_brand#sanree_brand_friendly_link')->insert($setarr);

		}	
		cpmsg($langs['succeed'], $gotourl.'friendly_link', 'succeed');				
	}
	else {
	    showsubmenu($menustr);	
	
		if($flid>0) {
		    $menustr = $langs['edithelp'];
		    $result = C::t('#sanree_brand#sanree_brand_friendly_link')->get_by_id($flid);
        }
		else {	
		    $menustr = $langs['addhelp'];
			$result['displayorder'] = 0;
			$result['status'] = 1;
		}		
		showformheader($thisurl."&do=".$do."&flid=".$flid."&page=".$page, 'enctype');
		showtableheader($menustr, 'nobottom');
		showsetting('name', 'title', $result['title'], 'text');	
		showsetting('link', 'url', $result['url'], 'text');		
		showsetting($langs['showorder'], 'displayorder', $result['displayorder'], 'text');
		showsetting($langs['status'], 'status', $result['status'], 'radio');
		$result['dateline'] && showsetting($langs['dateline'], 'dateline', dgmdate($result[dateline]), 'text','1');
		showsubmit('addsubmit');
		showtablefooter();
		showformfooter();		
	}
} elseif ($do == 'list') {
	if(submitcheck('submit')){
		if(is_array($_G['sr_help_title'])) {
			foreach($_G['sr_help_title'] as $id => $title) {
				if(!$_G['sr_delete'][$id]) {
					$setarr=array(
						'displayorder' => $_G['sr_help_displayorder'][$id],
						'title' => $_G['sr_help_title'][$id],
						'status' => intval($_G['sr_help_status'][$id]),
					);
					C::t('#sanree_brand#sanree_brand_friendly_link')->update($id,$setarr);
				}
			}
		}	
		if($_G['sr_delete']) {

			C::t('#sanree_brand#sanree_brand_friendly_link')->delete($_G['sr_delete']);
			
		}	
		sanreeupdatecache('help');
		cpmsg($langs['succeed'], $gotourl.'friendly_link', 'succeed');	
		
	}
	else
	{	
		showsubmenu($menustr);

		$skeyword = $_G['sr_skeyword'];
		showformheader($thisurl);
		showtableheader($langs['searchbar'], '', 'style="border:1px solid #F0F7FD"');
		showtablerow('', '', $langs['skeyword'].'<input type="text" name="skeyword" value="'.$skeyword.'" class="txt" style="width:200px;" /> <input type="submit" value="'.$langs['search'].'" class="btn" name="searchsubmit"/>');
		showtablefooter();
		showformfooter();
 						
		showformheader($thisurl);
		showtableheader($langs['friendly_link'], 'nobottom');
		showsubtitle(array('','display_order', 'name' , $langs['status'],  'time','operation'));
		$perpage = 10;
		$srchadd = $searchtext = $extra = $srchuid = '';
		$page = max(1, intval($_G['sr_page']));
		$orderby = ' displayorder,flid  desc';
		
		if(!empty($skeyword)){
		
			$searchfield = array('title');
			$search = array();
			foreach($searchfield as $v) {
			
				$search[] = "(".$v." LIKE '%".$skeyword."%')";
				
			}
			$searchtext .= " AND (".implode(' OR ',$search).")";
			$extra = '&skeyword='.urlencode($skeyword);
		}
				
		$count = C::t('#sanree_brand#sanree_brand_friendly_link')->count_by_wherec($searchtext);
		$multipage=multi($count, $perpage, $page, ADMINSCRIPT."?action=plugins&operation=config&act=$act&identifier=sanree_brand&pmod=admincp$extra");	
		$datalist = C::t('#sanree_brand#sanree_brand_friendly_link')->fetch_all_by_searchc($searchtext,$orderby,(($page - 1) * $perpage),$perpage);

		foreach($datalist as $value) {

            $statusstr = $value['status']==1 ? ' checked="checked"':'';
			showtablerow('', array('class="td25"', 'class="td28"','', 'class="td28"'), array(
				"<input class=\"checkbox\" type=\"checkbox\" name=\"delete[$value[flid]]\" value=\"$value[flid]\">",
				"<input type=\"text\" class=\"txt\" size=\"12\" name=\"help_displayorder[$value[flid]]\" value=\"$value[displayorder]\">",
				"<input type=\"text\" class=\"txt\" size=\"12\" name=\"help_title[$value[flid]]\" value=\"$value[title]\">",
				"<input type=\"checkbox\"  size=\"12\" name=\"help_status[$value[flid]]\" value=\"1\" $statusstr>",
				$value['dateline'] ? dgmdate($value['dateline']):'',
				'<a href="###" onclick="location.href=\''.ADMINSCRIPT.'?action=plugins&operation=config&act=friendly_link&identifier=sanree_brand&pmod=admincp&do=upgrading&flid='.$value['flid']."&page=".$page.'\'">'.$lang['edit'].'</a>'
			));
			
		}
		echo '<tr><td>&nbsp;</td><td colspan="7"><div><a href="###" onclick="location.href=\''.ADMINSCRIPT.'?action=plugins&operation=config&act=friendly_link&identifier=sanree_brand&pmod=admincp&do=upgrading\'" class="addtr">'.$langs['add'].'</a></div></td></tr>';			
		showsubmit('submit', 'submit', 'del', '', $multipage, false);
		showtablefooter();
		showformfooter();
	}	
}
//From:www_YMG6_COM
?>