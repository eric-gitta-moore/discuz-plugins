<?php

/**
 *      [Sanree] (C)2012-2099 Sanree Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: sanree_brand_help.php $
 */

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}

$do = $_G['sr_do'];
$doarray = array('list', 'upgrading');
$do = !in_array($do,$doarray) ? 'list' : $do;
$_G['sr_page'] = isset($_G['sr_page']) ? $_G['sr_page'] : 0;
if ($do == 'upgrading') {
    $helpid = intval($_G['sr_helpid']);
	if(submitcheck('addsubmit')){
	    $setarr = array();
	    $title = dhtmlspecialchars(trim($_G['sr_title']));
		if (empty($title)) {
			cpmsg_error($langs['error_helptitle']);
		}		
		$setarr['cateid'] = intval(trim($_G['sr_cateid']));
		$setarr['title'] = $title;
		$setarr['url'] = dhtmlspecialchars(trim($_G['sr_url']));
		$setarr['displayorder'] = intval(trim($_G['sr_displayorder']));
		$setarr['status'] = intval(trim($_G['sr_status']));
		if ($helpid) {
		
			C::t('#sanree_brand_help#sanree_brand_help')->update($helpid, $setarr);
			
		} else {

		    $setarr['dateline'] = TIMESTAMP;			
			C::t('#sanree_brand_help#sanree_brand_help')->insert($setarr);

		}	
		sanreeupdatecache('help');	
		cpmsg($langs['succeed'], $gotourl.'help', 'succeed');				
	}
	else {
	    showsubmenu($menustr);	
	
		if($helpid>0) {
		    $menustr = $langs['edithelp'];
		    $result = C::t('#sanree_brand_help#sanree_brand_help')->get_by_helpid($helpid);	
        }
		else {	
		    $menustr = $langs['addhelp'];
			$result['displayorder'] = 0;
			$result['status'] = 1;
		}		
		showformheader($thisurl1."&do=".$do."&helpid=".$helpid."&page=".$page, 'enctype');
		showtableheader($menustr, 'nobottom');
		showsetting($langs['helpcate'], array('cateid', $helpcate), $result['cateid'], 'select');	
		showsetting($langs['helptitle'], 'title', $result['title'], 'text');	
		showsetting($langs['helpurl'], 'url', $result['url'], 'text');		
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
					C::t('#sanree_brand_help#sanree_brand_help')->update($id,$setarr);
				}
			}
		}	
		if($_G['sr_delete']) {

			C::t('#sanree_brand_help#sanree_brand_help')->delete($_G['sr_delete']);
			
		}	
		sanreeupdatecache('help');
		cpmsg($langs['succeed'], $gotourl.'help', 'succeed');	
		
	}
	else
	{	
		showsubmenu($menustr);

		$skeyword = $_G['sr_skeyword'];
		showformheader($thisurl1);
		showtableheader($langs['searchbar'], '', 'style="border:1px solid #F0F7FD"');
		showtablerow('', '', $langs['skeyword'].'<input type="text" name="skeyword" value="'.$skeyword.'" class="txt" style="width:200px;" /> <input type="submit" value="'.$langs['search'].'" class="btn" name="searchsubmit"/>');
		showtablefooter();
		showformfooter();
 						
		showformheader($thisurl1);
		showtableheader($langs['help'], 'nobottom');
		showsubtitle(array('','display_order', $langs['helptitle'] , $langs['status'], $langs['helpcate'], 'time','operation'));
		$perpage = 10;
		$srchadd = $searchtext = $extra = $srchuid = '';
		$page = max(1, intval($_G['sr_page']));
		$orderby = 'cateid, displayorder,helpid  desc';
		
		if(!empty($skeyword)){
		
			$searchfield = array('title');
			$search = array();
			foreach($searchfield as $v) {
			
				$search[] = "(".$v." LIKE '%".$skeyword."%')";
				
			}
			$searchtext .= " AND (".implode(' OR ',$search).")";
			$extra = '&skeyword='.urlencode($skeyword);
		}
				
		$count = C::t('#sanree_brand_help#sanree_brand_help')->count_by_wherec($searchtext);
		$multipage=multi($count, $perpage, $page, ADMINSCRIPT."?action=plugins&operation=config&act=$act&identifier=sanree_brand_help&pmod=admincp$extra");	
		$datalist = C::t('#sanree_brand_help#sanree_brand_help')->fetch_all_by_searchc($searchtext,$orderby,(($page - 1) * $perpage),$perpage);

		foreach($datalist as $value) {

            $statusstr = $value['status']==1 ? ' checked="checked"':'';
			showtablerow('', array('class="td25"', 'class="td28"','', 'class="td28"'), array(
				"<input class=\"checkbox\" type=\"checkbox\" name=\"delete[$value[helpid]]\" value=\"$value[helpid]\">",
				"<input type=\"text\" class=\"txt\" size=\"12\" name=\"help_displayorder[$value[helpid]]\" value=\"$value[displayorder]\">",
				"<input type=\"text\" class=\"txt\" size=\"12\" name=\"help_title[$value[helpid]]\" value=\"$value[title]\">",
				"<input type=\"checkbox\"  size=\"12\" name=\"help_status[$value[helpid]]\" value=\"1\" $statusstr>",
				$helpcate[$value['cateid']][1],
				$value['dateline'] ? dgmdate($value['dateline']):'',
				'<a href="###" onclick="location.href=\''.ADMINSCRIPT.'?action=plugins&operation=config&act=list&identifier=sanree_brand_help&pmod=admincp&do=upgrading&helpid='.$value['helpid']."&page=".$page.'\'">'.$lang['edit'].'</a>'
			));
			
		}
		echo '<tr><td>&nbsp;</td><td colspan="7"><div><a href="###" onclick="location.href=\''.ADMINSCRIPT.'?action=plugins&operation=config&act=list&identifier=sanree_brand_help&pmod=admincp&do=upgrading\'" class="addtr">'.$langs['addhelp'].'</a></div></td></tr>';			
		showsubmit('submit', 'submit', 'del', '', $multipage, false);
		showtablefooter();
		showformfooter();
	}	
}
//From:www_YMG6_COM
?>