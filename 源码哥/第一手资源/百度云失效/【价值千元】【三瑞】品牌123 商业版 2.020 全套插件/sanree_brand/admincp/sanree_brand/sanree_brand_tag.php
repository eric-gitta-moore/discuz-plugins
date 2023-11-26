<?php

/**
 *      [Sanree] (C)2012-2099 Sanree Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: sanree_brand_tag.php $
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
		if(is_array($_G['sr_tag_tagname'])) {
			foreach($_G['sr_tag_tagname'] as $id => $tagname) {
				if(!$_G['sr_delete'][$id]) {
					$setarr=array(
						'displayorder' => $_G['sr_tag_displayorder'][$id],
						'tagname' => $_G['sr_tag_tagname'][$id],
					);
					C::t('#sanree_brand#sanree_brand_tag')->update($id,$setarr);
				}
			}
		}	
		if(is_array($_G['sr_newtagname'])) {
			foreach($_G['sr_newtagname'] as $k => $v) {
				if($v) {
					$setarr = array(
						'tagname' => $v,
						'displayorder' => $_G['sr_newdisplayorder'][$k],
						'dateline' => TIMESTAMP,
						'status' => 1,					
					);
					C::t('#sanree_brand#sanree_brand_tag')->insert($setarr);
				}
			}
		}
				 
		if($_G['sr_delete']) {

			C::t('#sanree_brand#sanree_brand_tag')->delete($_G['sr_delete']);
			
		}	
		cpmsg($langs['succeed'],'action=plugins&operation=config&act=tag&identifier=sanree_brand&pmod=admincp&page='.$page, 'succeed');	
	
	}
	else
	{	
?>
<script type="text/JavaScript">
	var rowtypedata = [
		[
			[1,'', 'td25'],
			[1,'<input type="text" class="txt" name="newdisplayorder[]" size="3">', 'td28'],
			[1,'<input type="text" class="txt" name="newtagname[]" size="3">', 'td26']
		]
	];
</script>
<?php	
		$page = max(1, intval($_G['sr_page']));
		showsubmenu($menustr);	
		showformheader($thisurl."&page=".$page);
		showtableheader($langs['tag'], 'nobottom');
		showsubtitle(array('','display_order', 'name'));
		$perpage = 10;
		$srchadd = $searchtext = $extra = $srchuid = '';
		$orderby = 'displayorder';
		$count = C::t('#sanree_brand#sanree_brand_tag')->count_by_where($searchtext);
		$multipage=multi($count, $perpage, $page, ADMINSCRIPT."?action=plugins&operation=config&act=tag&identifier=sanree_brand&pmod=admincp$extra");
		$datalist = C::t('#sanree_brand#sanree_brand_tag')->fetch_all_by_search($searchtext,$orderby,(($page - 1) * $perpage),$perpage);
		foreach($datalist as $value) {
			showtablerow('', array('class="td25"', 'class="td25"', 'class="td26"'), array(
			"<input class=\"checkbox\" type=\"checkbox\" name=\"delete[$value[tagid]]\" value=\"$value[tagid]\">",
			"<input type=\"text\" class=\"txt\" size=\"12\" name=\"tag_displayorder[$value[tagid]]\" value=\"$value[displayorder]\">",
			"<input type=\"text\" class=\"txt\" size=\"12\" name=\"tag_tagname[$value[tagid]]\" value=\"$value[tagname]\">",
			));
		}
		echo '<tr><td>&nbsp;</td><td colspan="5"><div><a href="###" onclick="addrow(this, 0)" class="addtr">'.$langs['addtag'].'</a></div></td></tr>';			
		showsubmit('submit', 'submit', 'del', '', $multipage);
		showtablefooter();
		showformfooter();
	}	
}
//From:www_YMG6_COM
?>