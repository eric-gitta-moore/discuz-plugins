<?php

/**
 *      [fx8.cc] (C)2014-2017 ymg6.Com.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: sanree_brand_list.php 2 2012-01-03 13:05:56 sanree $
 */

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('||http://taobao.ilovezj.com/||http://taobao.ilovezj.com/');
}
$do= $_G['sr_do'];

if(!in_array($do, array('list', 'upgrading'))) {
	$do = 'list';
}

if ($do == 'upgrading') {
    $cateid = intval($_G['sr_cateid']);
	if(submitcheck('addsubmit')){
	    $setarr = array();
	    $name = dhtmlspecialchars(trim($_G['sr_name']));
		if (empty($name)) {
			cpmsg_error($langs['error_nametip']);
		}



		if($_G['sr_deleteclogo']) {

			$result = C::t('#sanree_brand#sanree_brand_category')->get_by_cateid($cateid);
			$valueparse = parse_url($result['clogo']);
			if(!isset($valueparse['host'])) {

				$result['clogo'] && @unlink($_G['setting']['attachurl'].'common/'.$result['clogo']);

			}
			$setarr['clogo'] = '';

		} else {

			if($_FILES['clogo']) {

				$data = array('extid' => $cateid);
				$setarr['clogo'] = upload_icon_banner($data, $_FILES['clogo'], 'brand_category');

			} else {

				$setarr['clogo'] = $_G['sr_clogo'];

			}

		}

		$setarr['name'] = $name;
		$setarr['cateid'] = $cateid;
		$setarr['keywords'] = dhtmlspecialchars(trim($_G['sr_keywords']));
		$setarr['description'] = dhtmlspecialchars(trim($_G['sr_description']));
		$setarr['status'] = intval(trim($_G['sr_status']));
		$setarr['displayorder'] = intval(trim($_G['sr_displayorder']));
		$setarr['syngroupid'] = intval(trim($_G['sr_syngroupid']));
		$user = dhtmlspecialchars(trim($_G['sr_user']));
		if ($user) {
		
			$t = C::t('#sanree_brand#xcommon_member')->fetch_uid_by_username($user);	
			if($t) {
			
				$setarr['uid'] = $t;
				
			}
			else {
			
				cpmsg_error($langs['error_nouser']);
				
			}
			
		}

		if ($cateid) {
			C::t('#sanree_brand#sanree_brand_category')->update($cateid, $setarr);
		}
		else {
		    $setarr['dateline'] = TIMESTAMP;
			C::t('#sanree_brand#sanree_brand_category')->insert($setarr);
		}
		sanreeupdatecache('category');
		cpmsg($langs['succeed'], $gotourl.'list', 'succeed');				
	}
	else {
	    showsubmenu($menustr);	
		if($cateid>0) {
		    $menustr = $langs['editcate'];
		    $result = C::t('#sanree_brand#sanree_brand_category')->get_by_cateid($cateid);	
        }
		else {	
		    $menustr = $langs['addcate'];
			$result['status'] = 1;
			$result['displayorder'] = 0;
		}

		if($result['clogo']) {

			$valueparse = parse_url($result['clogo']);
			if(isset($valueparse['host'])) {

				$grouplogo = $result['clogo'];

			} else {

				$grouplogo = $_G['setting']['attachurl'].'common/'.$result['clogo'].'?'.random(6);

			}
			$grouplogohtml = '<label><input type="checkbox" class="checkbox" name="deleteclogo" value="yes" /> '.$lang['delete'].'</label><br /><img width="25" height="25" src="'.$grouplogo.'" />';

		}
		require_once libfile('function/group');
		$groupselect = get_groupselect(0, $result['syngroupid'], 0);
		showformheader($thisurl."&do=".$do."&cateid=".$cateid."&page=".$page, 'enctype');
		showtableheader($menustr, 'nobottom');
		showsetting('name', 'name', $result['name'], 'text');
		showsetting($langs['syngroupid'], '', '', '<select name="syngroupid">'.$groupselect.'</select>');
		!$result['pcateid'] ? showsetting($langs['uploadimg'], 'clogo', $result['clogo'], 'filetext', '', '',$grouplogohtml) : '';
		showsetting('keywords', 'keywords', $result['keywords'], 'text');
		showsetting('description', 'description', $result['description'], 'textarea');
		showsetting($langs['showorder'], 'displayorder', $result['displayorder'], 'text');
		$result['dateline'] && showsetting($langs['dateline'], 'dateline', dgmdate($result[dateline]), 'text','1');
		showsetting($langs['auditstatus'], 'status', $result['status'], 'radio');
		showsubmit('addsubmit');
		showtablefooter();
		showformfooter();		
	}
}
elseif ($do == 'list') {
	if(submitcheck('submit')){
	    $newforum = $_G['sr_newforum'];
		$neworder = $_G['sr_newforum'];
		$newsyngroupid = $_G['sr_newsyngroupid'];
		if(is_array($newforum)) {
			foreach($newforum as $fup => $forums) {
			
				$forum = C::t('#sanree_brand#sanree_brand_category')->fetch($fup);
				foreach($forums as $key => $forumname) {
				
					if(empty($forumname)) {
						continue;
					}
					$forumfields = array();
					$forumfields['name'] = $forumname;
					$forumfields['pcateid'] = $forum['cateid'];
					$forumfields['keywords'] = '';
					$forumfields['description'] = '';
					$forumfields['status'] = 1;
					$forumfields['displayorder'] = $neworder[$fup][$key];
					$forumfields['syngroupid'] = $newsyngroupid[$fup][$key];
					$forumfields['dateline'] = TIMESTAMP;
					C::t('#sanree_brand#sanree_brand_category')->insert($forumfields);
					
				}
			}
		}

		if(is_array($_G['sr_groupnamenewadd'])) {
			foreach($_G['sr_groupnamenewadd'] as $k => $v) {
				if($v) {
					$setarr = array(
						'name' => $v,
						'displayorder' => $_G['sr_groupordernewadd'][$k],
						'syngroupid' => $_G['sr_groupsyngroupidnewadd'][$k],
						'dateline' => TIMESTAMP
					);
					C::t('#sanree_brand#sanree_brand_category')->insert($setarr);
				}
			}
		}
	
		if(is_array($_G['sr_group_title'])) {	    
			foreach($_G['sr_group_title'] as $id => $title) {
				if(!$_G['sr_delete'][$id]) {
					$setarr = array(
						'name' => $_G['sr_group_title'][$id],
						'displayorder' => $_G['sr_group_order'][$id],
						'syngroupid' => $_G['sr_group_syngroupid'][$id],
						'status' => intval($_G['sr_group_status'][$id]),
					);
					C::t('#sanree_brand#sanree_brand_category')->update($id,$setarr);
				}
			}
			
		}		
		if($_G['sr_delete']) {
			C::t('#sanree_brand#sanree_brand_category')->delete($_G['sr_delete']);
		}		
		sanreeupdatecache('category');
		cpmsg($langs['succeed'], "action=".$thisurl, 'succeed');
	}else{
		showsubmenu($menustr);
		showformheader($thisurl);
		require_once libfile('function/group');	
		$m="<select name=\"groupsyngroupidnewadd[]\">".get_groupselect(0, 0, 0)."</select>";
		$n="<select name=\"newsyngroupid[{1}][]\">".get_groupselect(0, 0, 0)."</select>";
?>
<script type="text/JavaScript">
var rowtypedata = [
[[1,'','td25'],[1,'<input type="text" class="txt" name="groupordernewadd[]" value="0">', 'td25'],[1,'<input type="text" class="txt" name="groupnamenewadd[]">', 'td26'],[2,'<?php echo $m;?>', 'td25']],
[[1,'','td25'],[1,'<input type="text" class="txt" name="neworder[{1}][]" value="0" />', 'td25'],[1, '<div class="board" ><input name="newforum[{1}][]" value="<?php echo $langs["newsubcate"]?>" type="text" class="txt" /></div>', 'td26'],[2,'<?php echo $n;?>', 'td25']],
];
</script>
<?php

		showtableheader($langs['telcate'], 'nobottom');
		showsubtitle(array('',$langs['showorder'],  $langs['catename'], $langs['pic'] , $langs['syngroupidstr'], $langs['status'], $langs['count'], 'operation'));
		$category = C::t('#sanree_brand#sanree_brand_category')->getcategory_by_pcateid(0);
		foreach($category as $group) {
			$count = C::t('#sanree_brand#sanree_brand_businesses')->count_by_cateid($group['cateid']);
			$ststr = $group['keywords'] && $group['description'] ? $langs['yes']:'';
			$statusstr = $group[status]==1 ? ' checked="checked"':'';
			$grouplogohtml='';
			$grouplogo='';
			if($group['clogo']) {

				$valueparse = parse_url($group['clogo']);
				if(isset($valueparse['host'])) {

					$grouplogo = $group['clogo'];

				} else {

					$grouplogo = $_G['setting']['attachurl'].'common/'.$group['clogo'].'?'.random(6);

				}
				$grouplogohtml = '</label><br /><img width="25" height="25" src="'.$grouplogo.'" />';

			}
			showtablerow('', array('', 'class="td25"', 'class="td26"', 'class="td25"'), array(
						"<input class=\"checkbox\" type=\"checkbox\" name=\"delete[$group[cateid]]\" value=\"$group[cateid]\">",
						"<input type=\"text\" class=\"txt\" name=\"group_order[$group[cateid]]\" value=\"$group[displayorder]\">",					
						"<input type=\"text\" class=\"txt\" name=\"group_title[$group[cateid]]\" value=\"$group[name]\">".$ststr,
						$grouplogohtml,
						"<select name=\"group_syngroupid[$group[cateid]]\">".get_groupselect(0, $group['syngroupid'], 0)."</select>",
						"<input type=\"checkbox\"  size=\"12\" name=\"group_status[$group[cateid]]\" value=\"1\" $statusstr>",
						$count,
						'<a href="###" onclick="location.href=\''.ADMINSCRIPT.'?action=plugins&operation=config&act=list&do=upgrading&identifier=sanree_brand&pmod=admincp&do=upgrading&cateid='.$group['cateid']."&page=".$_G['sr_page'].'\'">'.$lang['edit'].'</a>',
						'<a href="###" onclick="location.href=\''.ADMINSCRIPT.'?action=plugins&operation=config&act=businesseslist&identifier=sanree_brand&pmod=admincp&cateid='.$group[cateid].'\'">'.cplang('view').'</a>'
					));
		   $subcategory = C::t('#sanree_brand#sanree_brand_category')->getcategory_by_pcateid($group[cateid]);
		   foreach($subcategory as $subgroup) {
		   
			   $subcount = C::t('#sanree_brand#sanree_brand_businesses')->count_by_cateid($subgroup['cateid']);
			   $subststr = $subgroup['keywords'] && $subgroup['description'] ? $langs['yes']:'';
			   $substatusstr = $subgroup[status]==1 ? ' checked="checked"':'';
			   showtablerow('', array('', 'class="td25"', 'class="td26"', 'class="td25"'), array(
							"<input class=\"checkbox\" type=\"checkbox\" name=\"delete[$subgroup[cateid]]\" value=\"$subgroup[cateid]\">",
							"<input type=\"text\" class=\"txt\" name=\"group_order[$subgroup[cateid]]\" value=\"$subgroup[displayorder]\">",					
							"<div class=\"board\"><input type=\"text\" class=\"txt\"  name=\"group_title[$subgroup[cateid]]\" value=\"$subgroup[name]\">$subststr</div>",
							'',
				            "<select name=\"group_syngroupid[$subgroup[cateid]]\">".get_groupselect(0, $subgroup['syngroupid'], 0)."</select>",
							"<input type=\"checkbox\"  size=\"12\" name=\"group_status[$subgroup[cateid]]\" value=\"1\" $substatusstr>",
							$subcount,
							'<a href="###" onclick="location.href=\''.ADMINSCRIPT.'?action=plugins&operation=config&act=list&do=upgrading&identifier=sanree_brand&pmod=admincp&do=upgrading&cateid='.$subgroup['cateid']."&page=".$_G['sr_page'].'\'">'.$lang['edit'].'</a>',
							'<a href="###" onclick="location.href=\''.ADMINSCRIPT.'?action=plugins&operation=config&act=businesseslist&identifier=sanree_brand&pmod=admincp&cateid='.$subgroup[cateid].'\'">'.cplang('view').'</a>'
						));  
						 
		   }
		   echo '<tr><td>&nbsp;</td><td>&nbsp;</td><td><div><a href="###" onclick="addrow(this, 1, '.$group['cateid'].')" class="addtr">'.$langs['addsubcate'].'</a></div></td></tr>';
		}
		echo '<tr><td>&nbsp;</td><td colspan="5"><div><a href="###" onclick="addrow(this, 0)" class="addtr">'.$langs['addcate'].'</a></div></td></tr>';		
		showsubmit('submit', 'submit', 'del', '', $multipage);
		showtablefooter();
		showformfooter();		
	}
}
//www-FX8-co
?>