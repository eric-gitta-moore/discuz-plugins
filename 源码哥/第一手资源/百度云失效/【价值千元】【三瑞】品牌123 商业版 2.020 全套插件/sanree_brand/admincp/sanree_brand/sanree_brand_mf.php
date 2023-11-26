<?php

/**
 *      [Sanree] (C)2012-2099 Sanree Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: sanree_brand_mf.php $
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
		if(is_array($_G['sr_mf_mfname'])) {
			foreach($_G['sr_mf_mfname'] as $id => $mfname) {
				if(!$_G['sr_delete'][$id]) {
					$setarr=array(
						'displayorder' => $_G['sr_mf_displayorder'][$id],
						'mfname' => $_G['sr_mf_mfname'][$id],
					);
					C::t('#sanree_brand#sanree_brand_mf')->update($id,$setarr);
				}
			}
		}	
		if(is_array($_G['sr_newmfname'])) {
			foreach($_G['sr_newmfname'] as $k => $v) {
				if($v) {
					$setarr = array(
						'mfname' => $v,
						'displayorder' => $_G['sr_newdisplayorder'][$k],
						'dateline' => TIMESTAMP,
						'status' => 1,					
					);
					C::t('#sanree_brand#sanree_brand_mf')->insert($setarr);
				}
			}
		}
				 
		if($_G['sr_delete']) {

			C::t('#sanree_brand#sanree_brand_mf')->delete($_G['sr_delete']);
			
		}	
		cpmsg($langs['succeed'],'action=plugins&operation=config&act=mf&identifier=sanree_brand&pmod=admincp&page='.$page, 'succeed');	
	
	}
	else
	{	
?>
<script type="text/JavaScript">
	var rowtypedata = [
		[
			[1,'', 'td25'],
			[1,'<input type="text" class="txt" name="newdisplayorder[]" size="3">', 'td28'],
			[1,'<input type="text" class="txt" name="newmfname[]" size="3">', 'td26']
		]
	];
</script>
<?php	
		showsubmenu($menustr);	
		showformheader($thisurl);
		showtableheader($langs['mf'], 'nobottom');
		showsubtitle(array('','display_order', 'name'));
		$perpage = 10;
		$srchadd = $searchtext = $extra = $srchuid = '';
		$page = max(1, intval($_G['sr_page']));
		$orderby = 'displayorder';
		$count = C::t('#sanree_brand#sanree_brand_mf')->count_by_where($searchtext);
		$multipage=multi($count, $perpage, $page, ADMINSCRIPT."?action=plugins&operation=config&act=mf&identifier=sanree_brand&pmod=admincp$extra");
		$datalist = C::t('#sanree_brand#sanree_brand_mf')->fetch_all_by_search($searchtext,$orderby,(($page - 1) * $perpage),$perpage);
		foreach($datalist as $value) {
			showtablerow('', array('class="td25"', 'class="td25"', 'class="td26"'), array(
			"<input class=\"checkbox\" type=\"checkbox\" name=\"delete[$value[mfid]]\" value=\"$value[mfid]\">",
			"<input type=\"text\" class=\"txt\" size=\"12\" name=\"mf_displayorder[$value[mfid]]\" value=\"$value[displayorder]\">",
			"<input type=\"text\" class=\"txt\" size=\"12\" name=\"mf_mfname[$value[mfid]]\" value=\"$value[mfname]\">",
			));
		}
		echo '<tr><td>&nbsp;</td><td colspan="5"><div><a href="###" onclick="addrow(this, 0)" class="addtr">'.$langs['addmf'].'</a></div></td></tr>';			
		showsubmit('submit', 'submit', 'del', '', $multipage);
		showtablefooter();
		showformfooter();
	}	
}
//From:www_YMG6_COM
?>