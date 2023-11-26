<?php

/**
 *      [Sanree] (C)2012-2099 Sanree Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: sanree_brand_video_diytemplate.php $
 */

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}

$do = $_G['sr_do'];
$doarray = array('list', 'upgrading', 'copyrow');
$do = !in_array($do,$doarray) ? 'list' : $do;
$_G['sr_page'] = isset($_G['sr_page']) ? $_G['sr_page'] : 0;

if ($do == 'upgrading') {
    $diytemplateid = intval($_G['sr_diytemplateid']);
	if(submitcheck('addsubmit')){
	    $setarr = array();
	    $name = dhtmlspecialchars(trim($_G['sr_name']));
		if (empty($name)) {
			cpmsg_error($langs['error_templatenametip']);
		}	
	    $content = $_GET['content'];
		if (empty($content)) {
			cpmsg_error($langs['error_templatecontenttip']);
		}			
		$setarr['name'] = $name;
		$setarr['content'] = serialize($content);
		$setarr['displayorder'] = intval(trim($_G['sr_displayorder']));
		$setarr['status'] = intval(trim($_G['sr_status']));

		if ($diytemplateid) {
			C::t('#sanree_brand_video#sanree_brand_video_diytemplate')->srupdate($diytemplateid, $setarr, 'issys<>1');
		} else {

		    $setarr['dateline'] = TIMESTAMP;
			$setarr['uid'] = $_G[uid];
			$setarr['username'] = $_G[username];					
			C::t('#sanree_brand_video#sanree_brand_video_diytemplate')->insert($setarr);

		}		
		cpmsg($langs['succeed'], $gotourl.'diytemplate', 'succeed');				
	}
	else {
	    showsubmenu($menustr);	
		showtableheader('', 'nobottom');		
		showtablerow('', array(), 
		array(
			'<ul class="tab1">'.
			'<li><a href="'.ADMINSCRIPT.'?action=plugins&operation=config&act=diyconfig&identifier=sanree_brand_video&pmod=admincp"><span>'.$langs['diyconfig'].'</span></a></li>'.
			'<li class="current"><a href="'.ADMINSCRIPT.'?action=plugins&operation=config&act=diytemplate&identifier=sanree_brand_video&pmod=admincp"><span>'.$langs['diytemplate'].'</span></a></li>'.
			'<li><a href="'.ADMINSCRIPT.'?action=plugins&operation=config&act=diystyle&identifier=sanree_brand_video&pmod=admincp"><span>'.$langs['diystyle'].'</span></a></li>'.
			'</ul>'
		));
		showtablefooter();		
		if($diytemplateid>0) {
		    $menustr = $langs['edittemplate'];
		    $result = C::t('#sanree_brand_video#sanree_brand_video_diytemplate')->get_by_diytemplateid($diytemplateid);	
        }
		else {	
		    $menustr = $langs['addtemplate'];
			$result['displayorder'] = 0;
			$result['status'] = 1;
		}		
		showformheader($thisurl."&do=".$do."&diytemplateid=".$diytemplateid."&page=".$page, 'enctype');
		showtableheader($menustr, 'nobottom');
		showsetting($langs['templatename'], 'name', $result['name'], 'text');		
		$content = unserialize($result['content']) ? unserialize($result['content']) : $result['content'];
		showsetting($langs['templatecontent'], 'content', fixhtmlstr($content), 'textarea','','','','', '', true);
		showsetting($langs['showorder'], 'displayorder', $result['displayorder'], 'text');
		showsetting($langs['status'], 'status', $result['status'], 'radio');
		$result['dateline'] && showsetting($langs['dateline'], 'dateline', dgmdate($result[dateline]), 'text','1');
		showsubmit('addsubmit');
		showtablefooter();
		showformfooter();		
	}
} elseif ($do == 'copyrow') {

    $diytemplateid = intval($_G['sr_diytemplateid']);
	if ($diytemplateid>0) {
	
		$result = C::t('#sanree_brand_video#sanree_brand_video_diytemplate')->get_by_diytemplateid($diytemplateid);
		if ($result) {
		
			$setarr = array();
			$setarr['name'] = $langs['copyfuben'].'_'.$result['name'].'_'.TIMESTAMP;
			$setarr['content'] = $result['content'];
			$setarr['displayorder'] = intval($result['displayorder']);
			$setarr['status'] = 0;		
			$setarr['dateline'] = TIMESTAMP;
			$setarr['uid'] = $_G[uid];
			$setarr['username'] = $_G[username];					
			C::t('#sanree_brand_video#sanree_brand_video_diytemplate')->insert($setarr);
			
		}
		
	}	
	cpmsg($langs['copysucceed'], $gotourl.'diytemplate', 'succeed');
	
} elseif ($do == 'list') {
	if(submitcheck('submit')){

		if(is_array($_G['sr_diytemplate_name'])) {
			foreach($_G['sr_diytemplate_name'] as $id => $title) {
				if(!$_G['sr_delete'][$id]) {
					$setarr=array(
						'displayorder' => $_G['sr_diytemplate_displayorder'][$id],
						'name' => $_G['sr_diytemplate_name'][$id],
						'status' => intval($_G['sr_diytemplate_status'][$id]),
					);
					C::t('#sanree_brand_video#sanree_brand_video_diytemplate')->srupdate($id,$setarr, 'issys<>1');
				}
			}
		}	
	 
		if($_G['sr_delete']) {

			C::t('#sanree_brand_video#sanree_brand_video_diytemplate')->srdelete($_G['sr_delete'], 'issys<>1');
			
		}	
		cpmsg($langs['succeed'], $gotourl.'diytemplate', 'succeed');	
		
	}
	else
	{	
		showsubmenu($menustr);
		
		showtableheader('', 'nobottom');		
		showtablerow('', array(), 
		array(
			'<ul class="tab1">'.
			'<li><a href="'.ADMINSCRIPT.'?action=plugins&operation=config&act=diyconfig&identifier=sanree_brand_video&pmod=admincp"><span>'.$langs['diyconfig'].'</span></a></li>'.
			'<li class="current"><a href="'.ADMINSCRIPT.'?action=plugins&operation=config&act=diytemplate&identifier=sanree_brand_video&pmod=admincp"><span>'.$langs['diytemplate'].'</span></a></li>'.
			'<li><a href="'.ADMINSCRIPT.'?action=plugins&operation=config&act=diystyle&identifier=sanree_brand_video&pmod=admincp"><span>'.$langs['diystyle'].'</span></a></li>'.
			'</ul>'
		));
		showtablefooter();
				
		$skeyword = $_G['sr_skeyword'];
		showformheader($thisurl);
		showtableheader($langs['searchbar'], '', 'style="border:1px solid #F0F7FD"');
		showtablerow('', '', $langs['skeyword'].'<input type="text" name="skeyword" value="'.$skeyword.'" class="txt" style="width:200px;" /> <input type="submit" value="'.$langs['search'].'" class="btn" name="searchsubmit"/>');
		showtablefooter();
		showformfooter();
						
		showformheader($thisurl);
		showtableheader($langs['diytemplate'], 'nobottom');
		showsubtitle(array('','display_order', $langs['templatename'] , $langs['status'], $langs['system'],$langs['operationuser'],$langs['diytemplateuser'],  'time','operation'));
		$perpage = 10;
		$srchadd = $searchtext = $extra = $srchuid = '';
		$page = max(1, intval($_G['sr_page']));
		$orderby = 'displayorder, diytemplateid  desc';
		
		if(!empty($skeyword)){
		
			$searchfield = array('name', 'content');
			$search = array();
			foreach($searchfield as $v) {
			
				$search[] = "(".$v." LIKE '%".$skeyword."%')";
				
			}
			$searchtext .= " AND (".implode(' OR ',$search).")";
			$extra = '&skeyword='.urlencode($skeyword);
		}
				
		$count = C::t('#sanree_brand_video#sanree_brand_video_diytemplate')->count_by_wherec($searchtext);
		$multipage=multi($count, $perpage, $page, ADMINSCRIPT."?action=plugins&operation=config&act=$act&identifier=sanree_brand_video&pmod=admincp$extra");	
		$datalist = C::t('#sanree_brand_video#sanree_brand_video_diytemplate')->fetch_all_by_searchc($searchtext,$orderby,(($page - 1) * $perpage),$perpage);

		foreach($datalist as $value) {

            $statusstr = $value[status]==1 ? ' checked="checked"':'';
			$issysstr = $value[issys]==1 ? $langs['yes']:$langs['no'];
			$notedit = $value[issys]==1 ? 'disabled="disabled"':'';
			$showedithtml = $value[issys]!=1 ? '<a href="###" onclick="location.href=\''.ADMINSCRIPT.'?action=plugins&operation=config&act=diytemplate&identifier=sanree_brand_video&pmod=admincp&do=upgrading&diytemplateid='.$value['diytemplateid']."&page=".$page.'\'">'.$lang['edit'].'</a>' : '';
			showtablerow('', array('class="td25"', 'class="td28"','', 'class="td28"'), array(
			"<input class=\"checkbox\" type=\"checkbox\" name=\"delete[$value[diytemplateid]]\" value=\"$value[diytemplateid]\" $notedit>",
			"<input type=\"text\" class=\"txt\" size=\"12\" name=\"diytemplate_displayorder[$value[diytemplateid]]\" value=\"$value[displayorder]\" $notedit>",
			"<input type=\"text\" class=\"txt\" size=\"12\" name=\"diytemplate_name[$value[diytemplateid]]\" value=\"$value[name]\" $notedit>",
			"<input type=\"checkbox\"  size=\"12\" name=\"diytemplate_status[$value[diytemplateid]]\" value=\"1\" $statusstr $notedit>",
			$issysstr,
			$value[username],
			$value[dateline] ? dgmdate($value[dateline]):'',
			'<a href="###" onclick="location.href=\''.ADMINSCRIPT.'?action=plugins&operation=config&act=diytemplate&identifier=sanree_brand_video&pmod=admincp&do=copyrow&diytemplateid='.$value['diytemplateid']."&page=".$page.'\'">'.$langs['copynewtemplate'].'</a>',
			$showedithtml
			));
			
		}
		echo '<tr><td>&nbsp;</td><td colspan="7"><div><a href="###" onclick="location.href=\''.ADMINSCRIPT.'?action=plugins&operation=config&act=diytemplate&identifier=sanree_brand_video&pmod=admincp&do=upgrading\'" class="addtr">'.$langs['addtemplate'].'</a></div></td></tr>';			
		
		showsubmit('submit', 'submit', 'del', '', $multipage, false);
		showtablefooter();
		showformfooter();
	}	
}
//From:www_YMG6_COM
?>