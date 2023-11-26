<?php

/**
 *      [Sanree] (C)2012-2099 Sanree Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: sanree_brand_cmenu.php $
 */

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}

$do = $_G['sr_do'];
$doarray = array('list', 'upgrading');
$do = !in_array($do,$doarray) ? 'list' : $do;
$_G['sr_page'] = isset($_G['sr_page']) ? $_G['sr_page'] : 0;

if ($do == 'list') {
	if(submitcheck('submit')){
		if(is_array($_G['sr_cmenu_title'])) {
			foreach($_G['sr_cmenu_title'] as $id => $title) {
				if(!$_G['sr_delete'][$id]) {
					$setarr=array(
						'displayorder' => $_G['sr_cmenu_displayorder'][$id],
						'title' => $_G['sr_cmenu_title'][$id],
						'url' => $_G['sr_cmenu_url'][$id],
						'window' => intval($_G['sr_cmenu_window'][$id]),
						'status' => intval($_G['sr_cmenu_status'][$id]),
						'istop' => intval($_G['sr_cmenu_istop'][$id]),
					);
					C::t('#sanree_brand#sanree_brand_cmenu')->update($id,$setarr);
				}
			}
		}	
		if(is_array($_G['sr_newtitle'])) {
			foreach($_G['sr_newtitle'] as $k => $v) {
				if($v) {
					$setarr = array(
						'title' => $v,
						'displayorder' => $_G['sr_newdisplayorder'][$k],
						'url' => $_G['sr_newurl'][$k],
						'dateline' => TIMESTAMP,
						'status' => 1,
						'istop' => 0,						
					);
					C::t('#sanree_brand#sanree_brand_cmenu')->insert($setarr);
				}
			}
		}
				 
		if($_G['sr_delete']) {

			C::t('#sanree_brand#sanree_brand_cmenu')->delete($_G['sr_delete']);
			
		}	
		cpmsg($langs['succeed'],'action=plugins&operation=config&act=cmenu&identifier=sanree_brand&pmod=admincp&page='.$page, 'succeed');	
	
	}
	else
	{	
?>
<script type="text/JavaScript">
	var rowtypedata = [
		[
			[1,'', 'td25'],
			[1,'<input type="text" class="txt" name="newdisplayorder[]" size="3">', 'td28'],
			[1,'<input type="text" class="txt" name="newtitle[]" size="25">'],
			[1,'<input type="text" class="txt" name="newurl[]" size="40">', 'td26']
		]
	];
</script>
<?php	
		showsubmenu($menustr);	
		showformheader($thisurl);
		showtableheader($langs['cmenu'], 'nobottom');
		showsubtitle(array('','display_order', 'name', 'URL',$langs['menuistop'], $langs['window'], $langs['status']));
		$perpage = 10;
		$srchadd = $searchtext = $extra = $srchuid = '';
		$page = max(1, intval($_G['sr_page']));
		$orderby = 'displayorder';
		$count = C::t('#sanree_brand#sanree_brand_cmenu')->count_by_where($searchtext);
		$multipage=multi($count, $ppp, $page, ADMINSCRIPT."?action=company&operation=cmenu$extra");
		$datalist = C::t('#sanree_brand#sanree_brand_cmenu')->fetch_all_by_search($searchtext,$orderby,(($page - 1) * $perpage),$perpage);
		foreach($datalist as $value) {
		    $statusstr = $value[status]==1 ? ' checked="checked"':'';
			$istopstr = $value[istop]==1 ? ' checked="checked"':'';
			$windowstr = $value[window]==1 ? ' checked="checked"':'';
			showtablerow('', array('class="td25"', 'class="td28"','', 'class="td26"'), array(
			"<input class=\"checkbox\" type=\"checkbox\" name=\"delete[$value[id]]\" value=\"$value[id]\">",
			"<input type=\"text\" class=\"txt\" size=\"12\" name=\"cmenu_displayorder[$value[id]]\" value=\"$value[displayorder]\">",
			"<input type=\"text\" class=\"txt\" size=\"12\" name=\"cmenu_title[$value[id]]\" value=\"$value[title]\">",
			"<input type=\"text\" class=\"txt\" size=\"12\" name=\"cmenu_url[$value[id]]\" value=\"$value[url]\">",
			"<input type=\"checkbox\"  size=\"12\" name=\"cmenu_istop[$value[id]]\" value=\"1\" $istopstr>",
			"<input type=\"checkbox\"  size=\"12\" name=\"cmenu_window[$value[id]]\" value=\"1\" $windowstr>",
			"<input type=\"checkbox\"  size=\"12\" name=\"cmenu_status[$value[id]]\" value=\"1\" $statusstr>",
			));
		}
		echo '<tr><td>&nbsp;</td><td colspan="5"><div><a href="###" onclick="addrow(this, 0)" class="addtr">'.$langs['addcmenu'].'</a></div></td></tr>';			
		showsubmit('submit', 'submit', 'del', '', $multipage);
		showtablefooter();
		showformfooter();
	}	
}
//From:www_YMG6_COM
?>