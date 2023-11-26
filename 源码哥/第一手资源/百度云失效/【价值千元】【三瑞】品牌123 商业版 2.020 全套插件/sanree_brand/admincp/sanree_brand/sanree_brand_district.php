<?php

/**
 *      [fx8.cc] (C)2014-2017 ymg6.Com.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: sanree_brand_district.php 2 2012-01-03 13:05:56 sanree $
 */

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('');
}
$do=$_G['sr_do'];
$doarray=array('list','ajax');
$do= !in_array($do,$doarray) ? 'list' : $do;
$page = max(1, intval($_G['sr_page']));
$upid = intval($_G['sr_upid']);
$level = $upid>0 ? C::t('#sanree_brand#sanree_brand_district')->result_level_by_id($upid) : 0;
if (!in_array($level , array(0,1,2,3))) {

	cpmsg_error($langs['levelerror']);
	
}
if ($do == 'ajax') {
	if(submitcheck('submit')){
		if ($_G['sr_birthprovince']) {
			$setarr = array();
			$setarr['birthprovince'] = dhtmlspecialchars(trim($_G['sr_birthprovince']));
			$setarr['birthcity'] = dhtmlspecialchars(trim($_G['sr_birthcity']));
			$setarr['birthdist'] = dhtmlspecialchars(trim($_G['sr_birthdist']));
			$setarr['birthcommunity'] = dhtmlspecialchars(trim($_G['sr_birthcommunity']));
			$upid = 0;
			if ($setarr['birthprovince']) {
			  $p1 = C::t('#sanree_brand#common_district')->fetch_first_by_name($setarr['birthprovince'],0);
			  if ($p1) {
			       $upid = $p1[id];
			       if ($setarr['birthcity']) {
						$p2 = C::t('#sanree_brand#common_district')->fetch_first_by_name($setarr['birthcity'], $upid);
						if ($p2) {
						    $upid = $p2[id];
							$p3 = C::t('#sanree_brand#common_district')->fetch_first_by_name($setarr['birthdist'], $upid);
							if ($p3) {
							    $upid = $p3[id];
							    $p4 = C::t('#sanree_brand#common_district')->fetch_first_by_name($setarr['birthcommunity'], $upid);
								if ($p4) {
								    $upid = $p4[id];
								}
							}
						}
				   }
			  }
			}
			$result = C::t('#sanree_brand#common_district')->fetch_first_by_id($upid);
			if (($result['level']>0)&&($result['level']<4)) {
				importone($result[id], 0 ,1);
			}
			cpmsg($langs['succeed'], "action=".$thisurl, 'succeed');
		}	
		else {
			cpmsg_error($langs['error_emptydis']);
		}
		
	}
	else {
		include template('common/header');
		include_once libfile('function/profile');
		$districthtml = profile_setting('birthcity');
		showformheader($thisurl.'&do=ajax&page='.$page.'&upid='.$upid);	
		showtableheader('', 'nobottom');
		echo '<div style="height:170px;width:530px;"><h3 class="flb mn"><span><a href="javascript:;" class="flbc" onclick="hideWindow(\'showarea\',1,0);" title="{lang close}">{lang close}</a></span>'.
		    $langs['pleaseinputdis'].'</h3><div style="margin-left:10px;">'.$districthtml.'<p style="padding:10px; color:#3333CC; line-height:20px;">'.$langs['pleaseinputdistip'].'</p></div></div>';
		showsubmit('submit', 'import');
		showtablefooter();
		showformfooter();	
		include template('common/footer');
	}
}
elseif ($do == 'list') {
	$id = intval($_G['sr_id']);
	if(submitcheck('submit')){
		if(is_array($_G['sr_groupnamenewadd'])) {
			foreach($_G['sr_groupnamenewadd'] as $k => $v) {
				if($v) {
					$setarr = array(
						'name' => $v,
						'displayorder' => $_G['sr_groupordernewadd'][$k],
						'enabled' => 1,
						'upid' => $upid,
						'level' => $level+1,
						'usetype' =>3
					);
					C::t('#sanree_brand#sanree_brand_district')->insert($setarr);
				}
			}
		}	 
	
		if(is_array($_G['sr_group_name'])) {	    
			foreach($_G['sr_group_name'] as $id => $title) {
				if(!$_G['sr_delete'][$id]) {
					$setarr = array(
						'name' => $_G['sr_group_name'][$id],
						'displayorder' => $_G['sr_group_displayorder'][$id],
						'enabled' => intval($_G['sr_group_enabled'][$id]),
					);
					C::t('#sanree_brand#sanree_brand_district')->update($id,$setarr);
				}
			}
			
		}	
		
		if($_G['sr_delete']) {
		
			C::t('#sanree_brand#sanree_brand_district')->delete($_G['sr_delete']);
			
		}
		cpmsg($langs['succeed'], "action=".$thisurl."&upid=".$upid, 'succeed');
	}
	else {	
		showsubmenu($menustr);	 	
		showformheader($thisurl.'&page='.$page.'&upid='.$upid);
?>
  <script>
  disallowfloat = 'newthread';
  </script>
<script type="text/JavaScript">
var rowtypedata = [
[
  [2,'','td25'],
  [1,'<input type="text" class="txt" name="groupordernewadd[]" value="0">', 'td25'],
  [1,'<input type="text" class="txt" name="groupnamenewadd[]">', 'td26']]
];
</script>
<?php		
		$catename ='';
		getdistrictidname($upid,$catename,'',ADMINSCRIPT.'?action=plugins&operation=config&act=district&identifier=sanree_brand&pmod=admincp&upid={id}');	
		showtableheader('<a href="'.ADMINSCRIPT.'?action=plugins&operation=config&act=district&identifier=sanree_brand&pmod=admincp">'.$langs['district'].'</a> > '.$catename, 'nobottom');
		showsubtitle(array('', 'ID', 'order', 'name', 'enable', 'num', 'operation'));
		
		$perpage = 10;
		$orderby = $srchadd = $searchtext = $srchuid = '';
		$searchtext = "and upid=$upid";
		$orderby = 'displayorder';
		$count = C::t('#sanree_brand#sanree_brand_district')->count_by_where($searchtext);
		if ($upid) $extra .="&upid=".$upid;
		$multipage=multi($count, $perpage, $page, ADMINSCRIPT."?action=plugins&operation=config&act=$act&identifier=sanree_brand&pmod=admincp$extra");
		$datalist = C::t('#sanree_brand#sanree_brand_district')->fetch_all_by_search($searchtext,$orderby,(($page - 1) * $perpage),$perpage);
		
		foreach($datalist as $row) {
		    $count = C::t('#sanree_brand#sanree_brand_district')->count_by_id($row['id']);
			$enabledstr = $row[enabled]==1 ? ' checked="checked"':'';
			showtablerow('', array('', '','class="td25"','class="td26"'), array(
			"<input class=\"checkbox\" type=\"checkbox\" name=\"delete[$row[id]]\" value=\"$row[id]\">" ,
			$row[id],
			"<input type=\"text\" class=\"txt\" size=\"12\" name=\"group_displayorder[$row[id]]\" value=\"$row[displayorder]\">",
			"<input type=\"text\" class=\"txt\" size=\"12\" name=\"group_name[$row[id]]\" value=\"$row[name]\">",
			"<input type=\"checkbox\"  size=\"12\" name=\"group_enabled[$row[id]]\" value=\"1\" $enabledstr>",
			$count,
			in_array($level , array(0,1,2)) ? '<a href="###" onclick="location.href=\''.ADMINSCRIPT.'?action=plugins&operation=config&act=district&do=list&identifier=sanree_brand&pmod=admincp&do=upgrading&upid='.$row[id]."&page=".$_G['sr_page'].'\'" class="addtr">'.$langs['addsub'].'</a>' :''));
			
		}
		echo '<tr><td>&nbsp;</td><td colspan="5"><div><a href="###" onclick="addrow(this, 0)" class="addtr">'.$langs['addcate'].'</a> &nbsp;&nbsp;<a <a href="'.ADMINSCRIPT.'?action=plugins&operation=config&act=district&do=list&identifier=sanree_brand&pmod=admincp&do=ajax" id="showblock" onclick="showWindow(\'showarea\',this.href);return false;" class="addtr">'.$langs['importdistrict'].'</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="'.ADMINSCRIPT.'?action=plugins&operation=config&act=base&do=list&identifier=sanree_brand&pmod=admincp">'.$langs['clearalltip'].'</a></div></td></tr>';		
		showsubmit('submit', 'submit', 'del', "<input class=\"checkbox\" type=\"hidden\" name=\"id\" value=\"$id\">", $multipage);
		showtablefooter();
		showformfooter();		

	}	
}	
?>