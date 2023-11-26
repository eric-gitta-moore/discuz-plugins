<?php

/**
 *      [Sanree] (C)2012-2099 Sanree Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: sanree_brand_album.php 2014-07-29 10:20:00 sanree checkedby fx8.cc $
 */

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('');
}

$do = $_G['sr_do'];
$doarray = array('list', 'upgrading');
$do = !in_array($do,$doarray) ? 'list' : $do;
$_G['sr_page'] = isset($_G['sr_page']) ? $_G['sr_page'] : 0;

if ($do == 'upgrading') {
    $albumid = intval($_G['sr_albumid']);
	if(submitcheck('addsubmit')){
	    $setarr = array();
		$catid = intval(trim($_G['sr_catid']));
	    $albumname = dhtmlspecialchars(trim($_G['sr_albumname']));
		if ($catid<1) {
			cpmsg_error($langs['error_catetip']);
		}	
		$setarr['albumname'] = $albumname;
		$setarr['catid'] = $catid;
		$setarr['depict'] = dhtmlspecialchars(trim($_G['sr_depict']));
		$setarr['displayorder'] = intval(trim($_G['sr_displayorder']));
		$brand = C::t('#sanree_brand#sanree_brand_album_category')->get_by_catid($catid);	
		if (!$brand) {
		
			cpmsg_error($langs['error_bid']);
			
		}
		$setarr['bid'] = $brand['bid'];			
		$setarr['uid'] = $brand[uid];
		$setarr['username'] = $brand[username];	
		if ($albumid) {
			C::t('#sanree_brand#sanree_brand_album')->update($albumid, $setarr);
		}
		else {
			$picdata = array();
			if($_FILES['pic']) {
				if ($_FILES['pic']['error']==0){
				
					 $picdata = mypic_save($_FILES['pic'], $albumid);
	
				}
			}	
			if (empty($picdata['filepath'])) {
				cpmsg_error($langs['error_pictip']);
			}
			$setarr['pic'] = $picdata['filepath'];		
		    $setarr['dateline'] = TIMESTAMP;
					
			$albumid = C::t('#sanree_brand#sanree_brand_album')->insert($setarr, TRUE);
			fixalbumpic($catid, $setarr);
		}
		if (intval($_G['sr_istop'])==1) {
		
		    $data = C::t('#sanree_brand#sanree_brand_album')->get_by_albumid($albumid);
			C::t('#sanree_brand#sanree_brand_album_category')->update($data['catid'], array('pic' => $data['pic']));
			
		}		
		cpmsg($langs['succeed'], $gotourl.'album', 'succeed');				
	}
	else {
	    showsubmenu($menustr);	
		showtableheader('', 'nobottom');		
		showtablerow('', array(), 
		array(
			'<ul class="tab1">'.
			'<li><a href="'.ADMINSCRIPT.'?action=plugins&operation=config&act=album_category&identifier=sanree_brand&pmod=admincp"><span>'.$langs['albumcate'].'</span></a></li>'.
			'<li class="current"><a href="'.ADMINSCRIPT.'?action=plugins&operation=config&act=album&identifier=sanree_brand&pmod=admincp"><span>'.$langs['piclist'].'</span></a></li></ul>'
		));
		showtablefooter();		
		if($albumid>0) {
		    $menustr = $langs['editcate'];
		    $result = C::t('#sanree_brand#sanree_brand_album')->get_by_albumid($albumid);	
        }
		else {	
		    $menustr = $langs['addalbum'];
			$result['displayorder'] = 0;
			$result['username'] = $_G['username'];
			$result['istop'] = 0;
		}	
		$groupselect = "<option value=\"0\" selected>".$langs['albumselect']."</option>\n";
		$category = C::t('#sanree_brand#sanree_brand_album_category')->getcategory_by_pcateid(0);
		$cate = array();
		foreach($category as $data) {
			$cate[] = array('albumid' => $data[catid] , 'name' => $data[catname]);
		}
		foreach($cate as $group) {
		
			if($group[albumid] == $result[catid]) {
			
				$groupselect .= "<option value=\"$group[albumid]\" selected>$group[name]</option>\n";
				
			} else {
			
				$groupselect .= "<option value=\"$group[albumid]\">$group[name]</option>\n";
				
			}
			
		}		
		showformheader($thisurl."&do=".$do."&albumid=".$albumid."&page=".$page, 'enctype');
		showtableheader($menustr, 'nobottom');
	
		showsetting($langs['albumgroup'], '', '', '<select name="catid">'.$groupselect.'</select>');
		if($result['pic']) {
		
		    $pic = $result['pic'];
		    $grouplogohtml = '<label><img src="'. $_G['setting']['attachurl'].'album/'.$pic.'?'.random(6).'" width="100" /></label>';
			showtablerow('','',$grouplogohtml);
		}	
		else {
			showsetting($langs['pic'], 'pic', $pic, 'file');
		    showtablerow('','','<input type="hidden" name="hash" value="'.md5(substr(md5($_G['config']['security']['authkey']), 8).$_G['uid']).'">');			
		}
		showsetting($langs['albumname'], 'albumname', $result['albumname'], 'text');		
		showsetting('description', 'depict', $result['depict'], 'textarea');
		showsetting($langs['albumistop'], 'istop', $result['istop'], 'radio');
		showsetting($langs['showorder'], 'displayorder', $result['displayorder'], 'text');
		$result['dateline'] && showsetting($langs['dateline'], 'dateline', dgmdate($result[dateline]), 'text','1');
		showsubmit('addsubmit');
		showtablefooter();
		showformfooter();		
	}
}
elseif ($do == 'list') {
	if(submitcheck('submit')){

		if(is_array($_G['sr_album_title'])) {
			foreach($_G['sr_album_title'] as $id => $title) {
				if(!$_G['sr_delete'][$id]) {
					$setarr=array(
						'displayorder' => $_G['sr_album_displayorder'][$id],
						'albumname' => $_G['sr_album_title'][$id],
						'ishome' => intval($_G['sr_album_ishome'][$id]),
					);
					C::t('#sanree_brand#sanree_brand_album')->update($id,$setarr);
				}
			}
		}	
		if(is_array($_G['sr_newtitle'])) {
			foreach($_G['sr_newtitle'] as $k => $v) {
				if($v) {
					$setarr = array(
						'albumname' => $v,
						'displayorder' => $_G['sr_newdisplayorder'][$k],
						'pic' => $_G['sr_newurl'][$k],
						'dateline' => TIMESTAMP
					);
					C::t('#sanree_brand#sanree_brand_album')->insert($setarr);
				}
			}
		}
				 
		if($_G['sr_delete']) {

			mydeletepics($_G['sr_delete']);
			
		}	
		cpmsg($langs['succeed'], $gotourl.'album', 'succeed');	
		
	}
	else
	{	
		showsubmenu($menustr);
		
		showtableheader('', 'nobottom');		
		showtablerow('', array(), 
		array(
			'<ul class="tab1">'.
			'<li><a href="'.ADMINSCRIPT.'?action=plugins&operation=config&act=album_category&identifier=sanree_brand&pmod=admincp"><span>'.$langs['albumcate'].'</span></a></li>'.
			'<li class="current"><a href="'.ADMINSCRIPT.'?action=plugins&operation=config&act=album&identifier=sanree_brand&pmod=admincp"><span>'.$langs['piclist'].'</span></a></li></ul>'
		));
		showtablefooter();
				
		$skeyword = $_G['sr_skeyword'];
		showformheader($thisurl);
		showtableheader($langs['searchbar'], '', 'style="border:1px solid #F0F7FD"');
		showtablerow('', '', $langs['skeyword'].'<input type="text" name="skeyword" value="'.$skeyword.'" class="txt" style="width:200px;" /> <input type="submit" value="'.$langs['search'].'" class="btn" name="searchsubmit"/>');
		showtablefooter();
		showformfooter();
						
		showformheader($thisurl);
		showtableheader($langs['album'], 'nobottom');
		showsubtitle(array('','display_order', 'name', $langs['isrecommend'],'',$langs['albumuser'],$langs['albumgroup'],  'time','operation'));
		$perpage = 10;
		$srchadd = $searchtext = $extra = $srchuid = '';
		$page = max(1, intval($_G['sr_page']));
		$orderby = 'a.ishome desc,a.displayorder,a.albumid  desc';
		
		if(!empty($skeyword)){
		
			$searchfield = array('c.catname', 'c.pic', 'c.description', 'b.name','m.username',
			'a.albumname', 'a.depict', 'a.pic'
			);
			$search = array();
			foreach($searchfield as $v) {
			
				$search[] = "(".$v." LIKE '%".$skeyword."%')";
				
			}
			$searchtext .= " AND (".implode(' OR ',$search).")";
			$extra = '&skeyword='.urlencode($skeyword);
		}
				
		$count = C::t('#sanree_brand#sanree_brand_album')->count_by_whered($searchtext);
		$multipage=multi($count, $perpage, $page, ADMINSCRIPT."?action=plugins&operation=config&act=$act&identifier=sanree_brand&pmod=admincp$extra");	
		$category = C::t('#sanree_brand#sanree_brand_album_category')->getcategory_by_pcateid(0);
		$cate = array();
		foreach($category as $data) {
			$cate[$data[catid]] = $data[catname];
		}
		include_once libfile('function/home');
		$datalist = C::t('#sanree_brand#sanree_brand_album')->fetch_all_by_searched($searchtext,$orderby,(($page - 1) * $perpage),$perpage);
		foreach($datalist as $value) {

            $ishomestr = $value['ishome']==1 ? ' checked="checked"':'';
			$value['pic'] = pic_get($value['pic'], 'album', $value['thumb'], $value['remote']);
			showtablerow('', array('class="td25"', 'class="td28"','', 'class="td28"'), array(
			"<input class=\"checkbox\" type=\"checkbox\" name=\"delete[$value[albumid]]\" value=\"$value[albumid]\">",
			"<input type=\"text\" class=\"txt\" size=\"12\" name=\"album_displayorder[$value[albumid]]\" value=\"$value[displayorder]\">",
			"<input type=\"text\" class=\"txt\" size=\"12\" name=\"album_title[$value[albumid]]\" value=\"$value[albumname]\">",
			"<input type=\"checkbox\"  size=\"12\" name=\"album_ishome[$value[albumid]]\" value=\"1\" $ishomestr>",
			"<img src='$value[pic]' width =123 height=140 />",
			$value[username],
			$cate[$value[catid]],
			$value[dateline] ? dgmdate($value[dateline]):'',
			'<a href="###" onclick="location.href=\''.ADMINSCRIPT.'?action=plugins&operation=config&act=album&identifier=sanree_brand&pmod=admincp&do=upgrading&albumid='.$value['albumid']."&page=".$page.'\'">'.$lang['edit'].'</a>'
			));
			
		}
		echo '<tr><td>&nbsp;</td><td colspan="7"><div><a href="###" onclick="location.href=\''.ADMINSCRIPT.'?action=plugins&operation=config&act=album&identifier=sanree_brand&pmod=admincp&do=upgrading\'" class="addtr">'.$langs['addalbum'].'</a></div></td></tr>';			
		
		showsubmit('submit', 'submit', 'del', '', $multipage, false);
		showtablefooter();
		showformfooter();
	}	
}
//From:www_YMG6_COM
?>