<?php

/**
 *      [Sanree] (C)2012-2099 Sanree Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: sanree_brand_video_diystyle.php $
 */

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}

$do = $_G['sr_do'];
$doarray = array('list', 'upgrading', 'copyrow');
$do = !in_array($do,$doarray) ? 'list' : $do;
$_G['sr_page'] = isset($_G['sr_page']) ? $_G['sr_page'] : 0;

if ($do == 'upgrading') {
    $diystyleid = intval($_G['sr_diystyleid']);
	if(submitcheck('addsubmit')){
	    $setarr = array();
	    $name = dhtmlspecialchars(trim($_G['sr_name']));
		if (empty($name)) {
			cpmsg_error($langs['error_nametip']);
		}	
		if ($diystyleid<1) {
		
			$count=C::t('#sanree_brand_video#sanree_brand_video_diystyle')->count_by_where(" AND name='$name'");
			
		} else { 
		
			$count=C::t('#sanree_brand_video#sanree_brand_video_diystyle')->count_by_where(" AND name='$name' AND diystyleid <> '$diystyleid'");
			
		}
		if ($count>0) {
		
			cpmsg_error($langs['ishavename']);
			
		}			
		if (!isstylename($name)) {
		
			cpmsg_error($langs['errorstylename']);
			
		}
	    $content = $_GET['content'];
		if (empty($content)) {
			cpmsg_error($langs['error_stylecontenttip']);
		}			
		$setarr['name'] = $name;
		$setarr['content'] = serialize($content);
		$setarr['displayorder'] = intval(trim($_G['sr_displayorder']));
		$setarr['status'] = intval(trim($_G['sr_status']));
	
		if ($diystyleid) {
			C::t('#sanree_brand_video#sanree_brand_video_diystyle')->srupdate($diystyleid, $setarr, 'issys<>1');
		} else {

		    $setarr['dateline'] = TIMESTAMP;
			$setarr['uid'] = $_G[uid];
			$setarr['username'] = $_G[username];					
			C::t('#sanree_brand_video#sanree_brand_video_diystyle')->insert($setarr);

		}
		video_diystyle();				
		cpmsg($langs['succeed'], $gotourl.'diystyle', 'succeed');				
	} else {
	    showsubmenu($menustr);	
		showtableheader('', 'nobottom');		
		showtablerow('', array(), 
		array(
			'<ul class="tab1">'.
			'<li><a href="'.ADMINSCRIPT.'?action=plugins&operation=config&act=diyconfig&identifier=sanree_brand_video&pmod=admincp"><span>'.$langs['diyconfig'].'</span></a></li>'.
			'<li><a href="'.ADMINSCRIPT.'?action=plugins&operation=config&act=diytemplate&identifier=sanree_brand_video&pmod=admincp"><span>'.$langs['diytemplate'].'</span></a></li>'.
			'<li class="current"><a href="'.ADMINSCRIPT.'?action=plugins&operation=config&act=diystyle&identifier=sanree_brand_video&pmod=admincp"><span>'.$langs['diystyle'].'</span></a></li>'.
			'</ul>'
		));
		showtablefooter();		
		if($diystyleid>0) {
		    $menustr = $langs['editstyle'];
		    $result = C::t('#sanree_brand_video#sanree_brand_video_diystyle')->get_by_diystyleid($diystyleid);	
        }
		else {	
		    $menustr = $langs['addstyle'];
			$result['displayorder'] = 0;
			$result['status'] = 1;
		}		
		showformheader($thisurl."&do=".$do."&diystyleid=".$diystyleid."&page=".$page, 'enctype');
		showtableheader($menustr, 'nobottom');
		showsetting($langs['stylename'], 'name', $result['name'], 'text','', '', $langs['stylenametip']);		
		$content = unserialize($result['content']) ? unserialize($result['content']) : $result['content'];
		showsetting($langs['stylecontent'], 'content', $content, 'textarea','' , '' ,$langs['stylecontenttip']);
		showsetting($langs['showorder'], 'displayorder', $result['displayorder'], 'text');
		showsetting($langs['status'], 'status', $result['status'], 'radio');
		$result['dateline'] && showsetting($langs['dateline'], 'dateline', dgmdate($result[dateline]), 'text','1');
		showsubmit('addsubmit');
		showtablefooter();
		showformfooter();		
	}
} elseif ($do == 'copyrow') {

    $diystyleid = intval($_G['sr_diystyleid']);
	if ($diystyleid>0) {
	
		$result = C::t('#sanree_brand_video#sanree_brand_video_diystyle')->get_by_diystyleid($diystyleid);
		if ($result) {
		
			$setarr = array();
			$setarr['name'] = $result['name'].'_'.TIMESTAMP;
			$setarr['content'] = $result['content'];
			$setarr['displayorder'] = intval($result['displayorder']);
			$setarr['status'] = 0;		
			$setarr['dateline'] = TIMESTAMP;
			$setarr['uid'] = $_G[uid];
			$setarr['username'] = $_G[username];					
			C::t('#sanree_brand_video#sanree_brand_video_diystyle')->insert($setarr);
			
		}
		
	}	
	video_diystyle();
	cpmsg($langs['copysucceed'], $gotourl.'diystyle', 'succeed');	
	
} elseif ($do == 'list') {

	if(submitcheck('submit')){

		if(is_array($_G['sr_diystyle_name'])) {
			foreach($_G['sr_diystyle_name'] as $id => $title) {
				if(!$_G['sr_delete'][$id]) {
					$setarr=array(
						'displayorder' => $_G['sr_diystyle_displayorder'][$id],
						'name' => $_G['sr_diystyle_name'][$id],
						'status' => intval($_G['sr_diystyle_status'][$id]),
					);
					C::t('#sanree_brand_video#sanree_brand_video_diystyle')->srupdate($id,$setarr, 'issys<>1');
				}
			}
		}	
	 
		if($_G['sr_delete']) {

			C::t('#sanree_brand_video#sanree_brand_video_diystyle')->srdelete($_G['sr_delete'], 'issys<>1');
			
		}	
		video_diystyle();
		cpmsg($langs['succeed'], $gotourl.'diystyle', 'succeed');	
		
	}
	else
	{	
		showsubmenu($menustr);
		
		showtableheader('', 'nobottom');		
		showtablerow('', array(), 
		array(
			'<ul class="tab1">'.
			'<li><a href="'.ADMINSCRIPT.'?action=plugins&operation=config&act=diyconfig&identifier=sanree_brand_video&pmod=admincp"><span>'.$langs['diyconfig'].'</span></a></li>'.
			'<li><a href="'.ADMINSCRIPT.'?action=plugins&operation=config&act=diytemplate&identifier=sanree_brand_video&pmod=admincp"><span>'.$langs['diytemplate'].'</span></a></li>'.
			'<li class="current"><a href="'.ADMINSCRIPT.'?action=plugins&operation=config&act=diystyle&identifier=sanree_brand_video&pmod=admincp"><span>'.$langs['diystyle'].'</span></a></li>'.
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
		showtableheader($langs['diystyle'], 'nobottom');
		showsubtitle(array('','display_order', $langs['stylename'] , $langs['status'], $langs['system'],$langs['operationuser'],$langs['diystyleuser'],  'time','operation'));
		$perpage = 10;
		$srchadd = $searchtext = $extra = $srchuid = '';
		$page = max(1, intval($_G['sr_page']));
		$orderby = 'displayorder, diystyleid  desc';
		
		if(!empty($skeyword)){
		
			$searchfield = array('name', 'content');
			$search = array();
			foreach($searchfield as $v) {
			
				$search[] = "(".$v." LIKE '%".$skeyword."%')";
				
			}
			$searchtext .= " AND (".implode(' OR ',$search).")";
			$extra = '&skeyword='.urlencode($skeyword);
		}
				
		$count = C::t('#sanree_brand_video#sanree_brand_video_diystyle')->count_by_wherec($searchtext);
		$multipage=multi($count, $perpage, $page, ADMINSCRIPT."?action=plugins&operation=config&act=$act&identifier=sanree_brand_video&pmod=admincp$extra");	
		$datalist = C::t('#sanree_brand_video#sanree_brand_video_diystyle')->fetch_all_by_searchc($searchtext,$orderby,(($page - 1) * $perpage),$perpage);

		foreach($datalist as $value) {

            $statusstr = $value[status]==1 ? ' checked="checked"':'';
			$issysstr = $value[issys]==1 ? $langs['yes']:$langs['no'];
			$notedit = $value[issys]==1 ? 'disabled="disabled"':'';
			$notedit = $value[issys]==1 ? 'disabled="disabled"':'';
			
			showtablerow('', array('class="td25"', 'class="td28"','', 'class="td28"'), array(
			"<input class=\"checkbox\" type=\"checkbox\" name=\"delete[$value[diystyleid]]\" value=\"$value[diystyleid]\" $notedit>",
			"<input type=\"text\" class=\"txt\" size=\"12\" name=\"diystyle_displayorder[$value[diystyleid]]\" value=\"$value[displayorder]\" $notedit>",
			"<input type=\"text\" class=\"txt\" size=\"12\" name=\"diystyle_name[$value[diystyleid]]\" value=\"$value[name]\" $notedit>",
			"<input type=\"checkbox\"  size=\"12\" name=\"diystyle_status[$value[diystyleid]]\" value=\"1\" $statusstr $notedit>",
			$issysstr,
			$value[username],
			$value[dateline] ? dgmdate($value[dateline]):'',
			'<a href="###" onclick="location.href=\''.ADMINSCRIPT.'?action=plugins&operation=config&act=diystyle&identifier=sanree_brand_video&pmod=admincp&do=copyrow&diystyleid='.$value['diystyleid']."&page=".$page.'\'">'.$langs['copyvideotyle'].'</a>',			
			$value[issys]!=1 ? '<a href="###" onclick="location.href=\''.ADMINSCRIPT.'?action=plugins&operation=config&act=diystyle&identifier=sanree_brand_video&pmod=admincp&do=upgrading&diystyleid='.$value['diystyleid']."&page=".$page.'\'">'.$lang['edit'].'</a>': ''
			));
			
		}
		echo '<tr><td>&nbsp;</td><td colspan="7"><div><a href="###" onclick="location.href=\''.ADMINSCRIPT.'?action=plugins&operation=config&act=diystyle&identifier=sanree_brand_video&pmod=admincp&do=upgrading\'" class="addtr">'.$langs['addstyle'].'</a></div></td></tr>';			
		showsubmit('submit', 'submit', 'del', '', $multipage, false);
		showtablefooter();
		showformfooter();
	}	
}
//From:www_YMG6_COM
?>