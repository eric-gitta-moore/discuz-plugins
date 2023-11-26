<?php

/**
 *      [fx8.cc] (C)2014-2017 ymg6.Com.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: sanree_brand_brandconfig.php 2014-07-29 10:20:00 sanree checkedby fx8.cc $
 */

if(!defined('IN_DISCUZ')) {
	exit('');
}

if (!$_G['uid']) {

	showmessage(srlang('nologin'), '', array(), array('login' => true));
	
}
$bid=intval($_G['sr_bid']);
$result = C::t('#sanree_brand#sanree_brand_businesses')->getusername_by_bidanduid($_G['uid'], $bid);
if (!$result) {

	showmessage(srlang('nobid'));
	
}
$result['banner'] = empty($result['banner']) ? 'source/plugin/sanree_brand/tpl/good/images/banner.jpg' : $_G['setting']['attachurl'].'common/'.$result['banner'].'?'.random(6);
$do= $_G['sr_do'];
$subdo = $_G['sr_subdo'];
$dostr = $do;
if(!in_array($do, array('main', 'config', 'banner', 'body', 'weixin', 'mf', 'tag', 'wezgimg'))) {
	$do = 'main';
	$dostr = $subdo;  
	if(!in_array($subdo, array('config', 'banner', 'body', 'weixin', 'mf', 'tag', 'wezgimg'))) {
		$dostr = 'config';
	}
}
$active[$dostr] = ' class="a" ';
$config_title = srlang('config_title');
$config_title = str_replace('{brandname}', '<a href="'.getburl_by_bid($bid).'" target="_blank">'.$result['name']."</a>",$config_title);

$group = C::t('#sanree_brand#sanree_brand_group')->get_by_groupid($result['groupid']);
$allowtemplate = intval($group['allowtemplate']);

if ($do=='main') {
	include templateEx($plugin['identifier'].':'.$template."/".$mod.'_'.$do);
} elseif ($do=='config') {

	if(submitcheck('postsubmit')) {
	
		$setarr = array();
		$setarr['isshowbrandname'] = intval($_G['sr_isshowbrandname']);
		$setarr['iscard'] = intval($_G['sr_iscard']);
		$setarr['tel'] = replaceparting(dhtmlspecialchars(trim($_G['sr_tel'])));
		$setarr['qq'] = replaceparting(dhtmlspecialchars(trim($_G['sr_qq'])));
		$setarr['msn'] = replaceparting(dhtmlspecialchars(trim($_G['sr_msn'])));
		$setarr['wangwang'] = replaceparting(dhtmlspecialchars(trim($_G['sr_wangwang'])));
		$setarr['baiduhi'] = replaceparting(dhtmlspecialchars(trim($_G['sr_baiduhi'])));
		$setarr['skype'] = replaceparting(dhtmlspecialchars(trim($_G['sr_skype'])));
		C::t('#sanree_brand#sanree_brand_businesses')->update($bid, $setarr);	
		$extra = array();
		$_G['inajax']= 1;
		if ($_G['inajax']) {
	
			$href = srreferer() ? $_G['referer'] : getburl_by_bid($bid);
			$href = str_replace("'", "\'", $href);	
			$goto = srreferer() ? "\r\nsetTimeout(\"window.location.href ='".$href."';\", 3000);":'';
			$url_forward = '';	
			$extra = array(
				'showdialog' => false,
				'extrajs' => "<script type=\"text/javascript\" reload=\"1\">///hideWindow('publisheddlg', 0, 1);$goto</script>"
			);
			
		}
		showmessage(srlang('savesucceed'), '', array(), $extra);	
	
	} else {
	
		$check = array();
		$check['isshowbrandname'][0] = $result['isshowbrandname']!=1 ? ' checked="checked" ':'';
		$check['isshowbrandname'][1]= $result['isshowbrandname']==1 ? ' checked="checked" ':'';
		$check['iscard'][0] = $result['iscard']!=1 ? ' checked="checked" ':'';
		$check['iscard'][1]= $result['iscard']==1 ? ' checked="checked" ':'';		
		include templateEx($plugin['identifier'].':'.$template."/".$mod.'_'.$do);
		
	}
		
	
} elseif ($do=='wezgimg') {

	if(submitcheck('postsubmit')) {

		$setarr = array();
		$setarr['wezgimg'] = dhtmlspecialchars(trim($_G['sr_poster']));
		C::t('#sanree_brand#sanree_brand_businesses')->update($bid, $setarr);
		$extra = array();
		$_G['inajax']= 1;
		if ($_G['inajax']) {

			$href = srreferer() ? $_G['referer'] : getburl_by_bid($bid);
			$href = str_replace("'", "\'", $href);
			$goto = srreferer() ? "\r\nsetTimeout(\"window.location.href ='".$href."';\", 3000);":'';
			$url_forward = '';
			$extra = array(
				'showdialog' => false,
				'extrajs' => "<script type=\"text/javascript\" reload=\"1\">///hideWindow('publisheddlg', 0, 1);$goto</script>"
			);

		}
		showmessage(srlang('savesucceed'), '', array(), $extra);

	} else {

		$defaultwezgimg = 'source/plugin/sanree_we/tpl/bird/images/bg.gif';
		$wezgimg = $result['wezgimg'] ? $_G[setting][attachurl].'category/'.$result['wezgimg'].'?'.random(6) : $defaultwezgimg;
		include templateEx($plugin['identifier'].':'.$template."/".$mod.'_'.$do);

	}

} elseif ($do=='banner') {

	if(submitcheck('postsubmit')) {
	
		$_G['uid'] = intval($_G['uid']);
		if((empty($_G['uid']) && $_GET['operation'] != 'upload') || $_POST['hash'] != md5(substr(md5($_G['config']['security']['authkey']), 8).$_G['uid'])) {
			exit();
		} else {
			if($_G['uid']) {
				$_G['member'] = getuserbyuid($_G['uid']);
			}
			$_G['groupid'] = $_G['member']['groupid'];
			loadcache('usergroup_'.$_G['member']['groupid']);
			$_G['group'] = $_G['cache']['usergroup_'.$_G['member']['groupid']];
		}
		if(!$config['isbird']) {
			if($_FILES['Filedata']['error']==0){
				$tmpavatar = $_FILES['Filedata']['tmp_name'];
				list($width, $height, $type, $attr) = getimagesize($tmpavatar);
				if ($ischkpictype==1) {
				
					$imgtype = array(1, 2, 3, 6);
					if (!in_array($type, $imgtype)) {
						file_exists($tmpavatar) && @unlink($tmpavatar);
						$type= intval($type);
						echo 'DISCUZUPLOAD|1|4|'.$type.'|0|0|0|0';
						exit();			
					}
					
				}
			}
			else {
				echo 'DISCUZUPLOAD|1|-1|0|0|0|0|0';
				exit();		
			}
		}
		require_once(DISCUZ_ROOT.'./source/plugin/sanree_brand/class/class_sanree_common_upload.php');		
		new sanree_common_upload($bid);
		
	} else {
	
	    $goto = srreferer();
		$thisurl = $goto ? $_G['referer'] : getburl_by_bid($bid);
		include templateEx($plugin['identifier'].':'.$template."/".$mod.'_'.$do);
		
	}	

} elseif ($do=='body') {

	if ($allowtemplate!=1) {
		showmessage(srlang('allowtemplatenottip'));
	}
	$repeat = array();
	$repeat[] = array('', srlang('selectnull'));
	$repeat[] = array('inherit', srlang('selectdefault'));
	$repeat[] = array('repeat', srlang('selectrepeat'));
	$repeat[] = array('no-repeat', srlang('selectnorepeat'));
	$repeat[] = array('repeat-x', srlang('selectrepeatx'));
	$repeat[] = array('repeat-y', srlang('selectrepeaty'));
	$attachment= array();
	$attachment[] = array('', srlang('selectnull'));
	$attachment[] = array('inherit', srlang('selectdefault'));
	$attachment[] = array('fixed',  srlang('selectfixed'));
	$attachment[] = array('scroll', srlang('selectscroll'));
	$positionx= array();
	$positionx[] = array('', srlang('selectnull'));
	$positionx[] = array('top', srlang('selecttop'));
	$positionx[] = array('center', srlang('selectcenter'));	
	$positionx[] = array('bottom', srlang('selectbottom'));
	$positiony= array();
	$positiony[] = array('', srlang('selectnull'));
	$positiony[] = array('left', srlang('selectleft'));
	$positiony[] = array('center', srlang('selectcenter'));	
	$positiony[] = array('right', srlang('selectright'));
	if(submitcheck('postsubmit')) {
	
		$bodyarr = unserialize($result['templateconfig']);
		$bodyarr['bodystyle']['isuse'] = intval($_G['sr_isuse']);
		$bodyarr['bodystyle']['ishideheader'] = intval($_G['sr_ishideheader']);
		$bodyarr['bodystyle']['notbackimg'] = intval($_G['sr_notbackimg']);
		$bodyarr['bodystyle']['backgroundcolor'] = dhtmlspecialchars(trim($_G['sr_color'])); 
		if (!ereg("#[a-fA-F0-9]{6}$",$bodyarr['bodystyle']['backgroundcolor'])){
            showmessage(srlang('error_color'));
		}
		$bodyarr['bodystyle']['backgroundrepeat'] = chkthis($repeat, dhtmlspecialchars(trim($_G['sr_selectrepeat']))); 
		$bodyarr['bodystyle']['backgroundattachment'] = chkthis($attachment, dhtmlspecialchars(trim($_G['sr_selectattachment'])));
		$bodyarr['bodystyle']['backgroundpositionx'] = chkthis($positionx, dhtmlspecialchars(trim($_G['sr_selectpositionx'])));
		$bodyarr['bodystyle']['backgroundpositiony'] = chkthis($positiony, dhtmlspecialchars(trim($_G['sr_selectpositiony'])));
		$bodyarr['bodystyle']['backgroundimage'] = dhtmlspecialchars(trim($_G['sr_poster'])); 		
		$setarr = array();
		$setarr['templateconfig'] = serialize($bodyarr);
		C::t('#sanree_brand#sanree_brand_businesses')->update($bid, $setarr);
		$extra = array();
		$_G['inajax']= 1;
		if ($_G['inajax']) {
	
			$href = srreferer() ? $_G['referer'] : getburl_by_bid($bid);
			$href = str_replace("'", "\'", $href);	
			$goto = srreferer() ? "\r\nsetTimeout(\"window.location.href ='".$href."';\", 3000);":'';
			$url_forward = '';	
			$extra = array(
				'showdialog' => false,
				'extrajs' => "<script type=\"text/javascript\" reload=\"1\">///hideWindow('publisheddlg', 0, 1);$goto</script>"
			);
			
		}
		showmessage(srlang('savesucceed'), '', array(), $extra);	
	
	} else {
	
	    $templateconfig = unserialize($result[templateconfig]);
		$bodystyle = $templateconfig['bodystyle']; 
		$bodystyle = is_array($bodystyle) ? $bodystyle : $defaultconfig['bodystyle'];
		$check = array();
		$check['isuse'][0] = $bodystyle['isuse']!=1 ? ' checked="checked" ':'';
		$check['isuse'][1]= $bodystyle['isuse']==1 ? ' checked="checked" ':'';
		$check['ishideheader'][0] = $bodystyle['ishideheader']!=1 ? ' checked="checked" ':'';
		$check['ishideheader'][1]= $bodystyle['ishideheader']==1 ? ' checked="checked" ':'';
		$body['color'] = empty($bodystyle['backgroundcolor']) ? '#FFFFFF' : $bodystyle['backgroundcolor'];
		$selectrepeat='<select name="selectrepeat">';
		foreach($repeat as $value) {
		    $selected = $bodystyle['backgroundrepeat']==$value[0] ? ' selected': '';
			$selectrepeat.='<option value="'.$value[0].'"'.$selected.'>'.$value[1].'</option>';
		}
		$selectrepeat .='</select>';
		$backgroundimage = $bodystyle['backgroundimage'];
		$selectattachment='<select name="selectattachment">';
		foreach($attachment as $value) {
		    $selected = $bodystyle['backgroundattachment']==$value[0] ? ' selected': '';
			$selectattachment.='<option value="'.$value[0].'"'.$selected.'>'.$value[1].'</option>';
		}
		$selectattachment .='</select>';
		$check['notbackimg'] = $bodystyle['notbackimg']==1 ? ' checked="checked" ':'';
		$selectpositionx='<select name="selectpositionx">';
		foreach($positionx as $value) {
		    $selected = $bodystyle['backgroundpositionx']==$value[0] ? ' selected': '';
			$selectpositionx.='<option value="'.$value[0].'"'.$selected.'>'.$value[1].'</option>';
		}
		$selectpositionx.='</select>';
		$selectpositiony='<select name="selectpositiony">';
		foreach($positiony as $value) {
		    $selected = $bodystyle['backgroundpositiony']==$value[0] ? ' selected': '';
			$selectpositiony.='<option value="'.$value[0].'"'.$selected.'>'.$value[1].'</option>';
		}
		$selectpositiony .='</select>';			
		include templateEx($plugin['identifier'].':'.$template."/".$mod.'_'.$do);
		
	}
	
} elseif ($do=='weixin') {

	if(submitcheck('postsubmit')) {
	
		$setarr = array();
		$setarr['weixin'] = dhtmlspecialchars(trim($_G['sr_weixin']));
		$setarr['weixinimg'] = dhtmlspecialchars(trim($_G['sr_poster']));		

		$setarr['weixinpublic'] = dhtmlspecialchars(trim($_G['sr_weixinpublic']));
		$setarr['weixinpublicpic'] = dhtmlspecialchars(trim($_G['sr_wxpublic']));

		C::t('#sanree_brand#sanree_brand_businesses')->update($bid, $setarr);
		
		$extra = array();
		$_G['inajax']= 1;
		if ($_G['inajax']) {
	
			$href = srreferer() ? $_G['referer'] : getburl_by_bid($bid);
			$href = str_replace("'", "\'", $href);	
			$goto = srreferer() ? "\r\nsetTimeout(\"window.location.href ='".$href."';\", 3000);":'';
			$url_forward = '';	
			$extra = array(
				'showdialog' => false,
				'extrajs' => "<script type=\"text/javascript\" reload=\"1\">///hideWindow('publisheddlg', 0, 1);$goto</script>"
			);
			
		}
		showmessage(srlang('savesucceed'), '', array(), $extra);	
	
	} else {
			
		$backgroundimage = empty($result['weixinimg']) ? $defaultwxcodeimg : $_G['setting']['attachurl'].'category/'.$result['weixinimg'].'?'.random(6);
		$weixinpublicpic = !$result['weixinpublicpic'] ? $defaultwxcodeimg : $_G['setting']['attachurl'].'category/'.$result['weixinpublicpic'].'?'.random(6);
		include templateEx($plugin['identifier'].':'.$template."/".$mod.'_'.$do);
		
	}
	
} elseif ($do=='mf') {

	if(submitcheck('postsubmit')) {
	
		$setarr = array();
		$setarr['brandmf'] = implode(',',$_G['sr_brandmf']);
		
		C::t('#sanree_brand#sanree_brand_businesses')->update($bid, $setarr);
		
		$extra = array();
		$_G['inajax']= 1;
		if ($_G['inajax']) {
	
			$href = srreferer() ? $_G['referer'] : getburl_by_bid($bid);
			$href = str_replace("'", "\'", $href);	
			$goto = srreferer() ? "\r\nsetTimeout(\"window.location.href ='".$href."';\", 3000);":'';
			$url_forward = '';	
			$extra = array(
				'showdialog' => false,
				'extrajs' => "<script type=\"text/javascript\" reload=\"1\">///hideWindow('publisheddlg', 0, 1);$goto</script>"
			);
			
		}
		showmessage(srlang('savesucceed'), '', array(), $extra);	
	
	} else {
		
		
		$mflist = array();
		foreach(C::t('#sanree_brand#sanree_brand_mf')->fetch_all_mf() as $data) {
		
			$mflist[] = array($data['mfid'], $data['mfname']);
			
		}
		$brandmf = explode(',', $result['brandmf']);
		include templateEx($plugin['identifier'].':'.$template."/".$mod.'_'.$do);
		
	}
	
} elseif ($do=='tag') {

	if(submitcheck('postsubmit')) {
	
		$setarr = array();
		$setarr['brandtag'] = dhtmlspecialchars(trim($_G['sr_brandtag']));

		C::t('#sanree_brand#sanree_brand_businesses')->update($bid, $setarr);
		
		$extra = array();
		$_G['inajax']= 1;
		if ($_G['inajax']) {
	
			$href = srreferer() ? $_G['referer'] : getburl_by_bid($bid);
			$href = str_replace("'", "\'", $href);	
			$goto = srreferer() ? "\r\nsetTimeout(\"window.location.href ='".$href."';\", 3000);":'';
			$url_forward = '';	
			$extra = array(
				'showdialog' => false,
				'extrajs' => "<script type=\"text/javascript\" reload=\"1\">///hideWindow('publisheddlg', 0, 1);$goto</script>"
			);
			
		}
		showmessage(srlang('savesucceed'), '', array(), $extra);	
	
	} else {
			
		$resultempty = FALSE;
		$orderby = $searchtext = $extra = $srchuid = '';
		$orderby = 'tagid desc';	
		$searchtext = ' AND status=1 ';	

		if(!empty($skeyword)){
		
			$searchfield = array('tagname');
			$search = array();
			foreach($searchfield as $v) {
			
				$search[] = "(".$v." LIKE '%".$skeyword."%')";
				
			}
			$searchtext .= " AND (".implode(' OR ',$search).")";
			$extra = '&skeyword='.urlencode($skeyword);
		}	
		
		$count = C::t('#sanree_brand#sanree_brand_tag')->count_by_where($searchtext);
		$perpage = $count;
		$page = 1;
		
		$brandtag = C::t('#sanree_brand#sanree_brand_tag')->fetch_all_by_search($searchtext,$orderby,(($page - 1) * $perpage),$perpage);
		
		
		include templateEx($plugin['identifier'].':'.$template."/".$mod.'_'.$do);
		
	}
	
}
function chkthis($listarr, $data) {
	$setdata = array();
	foreach($listarr as $value){
		$setdata[] = $value[0];
	}
	if (!in_array($data, $setdata)) {
		return '';
	}
	return $data;
}
//From:www_YMG6_COM
?>