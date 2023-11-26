<?php

/**
 *      [fx8.cc] (C)2014-2017 ymg6.Com.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: sanree_brand_businesseslist.php sanree $
 */
if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('||http://taobao.ilovezj.com/||http://taobao.ilovezj.com/');
}
$do= $_G['sr_do'];
$page = max(1, intval($_G['sr_page']));
if(!in_array($do, array('ajax', 'list', 'upgrading', 'businessesaudit', 'plug', 'config', 'batchbrand'))) {

	$do = 'list';
	
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
			
if ($do == 'ajax') {
		include template('common/header');
		echo '<h3 class="flb mn"><span><a href="javascript:;" class="flbc" onclick="MyhideWindow();" title="'.$lang['close'].'">'.$lang['close'].'</a></span>'.$langs['selecttag'].'</h3>';
		$skeyword = $_G['sr_skeyword'];
		?>
		<script language="javascript" reload="1">
		Array.prototype.S=String.fromCharCode(2);  
		Array.prototype.in_array=function(e)  
		{  
			var r=new RegExp(this.S+e+this.S);  
			return (r.test(this.S+this.join(this.S)+this.S));  
		}  		
		function MyhideWindow() {
			hideWindow('settag',1,0);
			$('domfx').innerHTML = '<style type="text/css">object{visibility:visible;}</style>';
		}
		  function fixa(){
			  var objs = $('fwin_content_settag').getElementsByTagName('a');
			  for(var i = 0; i < objs.length; i++) {
				  objs[i].setAttribute('fwin', 'settag');
				  objs[i].setAttribute('id', 'settag'+i);
				  if (objs[i].href.indexOf('page')>0) {
					  var u = objs[i].href;
					  objs[i].setAttribute('href', '###');
					  _attachEvent(objs[i], 'click', function (){
					  showWindow('settag',u);});
				  }
			  }
		  }
			function settag(name,id){
				$("spage").value="<?php echo $page;?>";
				if (!arrayObj.in_array(name)) arrayObj.push(name);
				arrayObj.sort();
				$("brandtag").value= arrayObj.join(',');
			}	  
		</script>
		<?php
		$anchor = isset($_GET['anchor']) ? dhtmlspecialchars($_GET['anchor']) : '';
		echo '<script language="javascript">function chkadd() {ajaxpost(\'cpform\', \'fwin_content_settag\', \'fwin_content_settag\',\'\',\'\',function(){fixa();});return false;}</script>';
  	    echo '<form name="cpform" onsubmit="return chkadd();" method="POST" autocomplete="off" action="'.ADMINSCRIPT.'?action='.$thisurl.'&do=ajax&ajaxtarget=fwin_content_settag&inajax=1" id="cpform">'.
		'<input type="hidden" name="formhash" value="'.FORMHASH.'" />'.
		'<input type="hidden" id="formscrolltop" name="scrolltop" value="" />'.
		'<input type="hidden" id="inajax" name="inajax" value="1" />'.
		'<input type="hidden" name="anchor" value="'.$anchor.'" />';		
		showtableheader('', '', 'style="border:1px solid #F0F7FD"');
		showtablerow('', '', $langs['skeyword'].'<input type="text" name="skeyword" value="'.$skeyword.'" class="txt" style="width:200px;" /> <input type="submit" value="'.$langs['search'].'" class="btn" name="searchsubmit"/>');
		showtablefooter();
		showformfooter();
		
		showtableheader($langs['listtip'], 'nobottom','style="width:600px"');
		$perpage = 5;
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
		$extra .= '&do=ajax';	
		$count = C::t('#sanree_brand#sanree_brand_tag')->count_by_where($searchtext);
		$multipage=multi($count, $perpage, $page, ADMINSCRIPT."?action=plugins&operation=config&act=$act&identifier=sanree_brand&pmod=admincp$extra");
		foreach(C::t('#sanree_brand#sanree_brand_tag')->fetch_all_by_search($searchtext,$orderby,(($page - 1) * $perpage),$perpage) as $row) {

			showtablerow('class="hover" style="cursor:pointer" onclick="settag(\''.$row['tagname'].'\',\''.$row['tagid'].'\')"', array(), array($row['tagname']));
			
		}
		showsubmit('','',$multipage);		
		showtablefooter();
		include template('common/footer');
} elseif  ($do == 'businessesaudit') {

    $control= $_G['sr_control'];
	if(!in_array($control, array('pass', 'refuse'))) {
	
		$control = '';
		
	}
	if ($control=='refuse') {
	
	    $bid = intval($_G['sr_bid']);
	    if (submitcheck('refuse')) {
		
		    C::t('#sanree_brand#sanree_brand_businesses')->update($bid , array('reason' => dhtmlspecialchars(trim($_G['sr_reason'])), 'status' => -1));
			sendbrand_notice($bid,'brand_refuse');
			cpmsg($langs['succeed'], "action=plugins&operation=config&act=".$act."&do=businessesaudit&identifier=sanree_brand&pmod=admincp&page=".$page, 'succeed');	
			
		} else {
		
			if($bid>0) {
			
				$result = C::t('#sanree_brand#sanree_brand_businesses')->getusername_by_bid($bid);	
				showsubmenu($menustr);	 
				showformheader($thisurl."&do=".$do."&bid=".$bid."&page=".$page.'&control='.$control, 'enctype');
				showtableheader('', 'nobottom');
				showsetting($langs['name'], 'name', $result['name'], 'text','no');
				showsetting($langs['refusereason'], 'reason', $result['reason'], 'textarea');
				showsubmit('refuse', 'submit');
				showtablefooter();
				showformfooter();
								
			}		
			exit();
			
		}
		
	} elseif ($control=='pass') {
	
		if($bid = intval($_G['sr_bid'])) {
		
			C::t('#sanree_brand#sanree_brand_businesses')->update($bid , array('isshow' => 1, 'status' => 1));
			fixthread($bid);
			syngroup($bid);
			sendbrand_notice($bid,'brand_adminpass');
			
		}
		cpmsg($langs['succeed'], "action=plugins&operation=config&act=".$act."&do=businessesaudit&identifier=sanree_brand&pmod=admincp&page=".$page, 'succeed');	
		
	} elseif(submitcheck('batch')) {
	
		if($ids = dimplode($_G['sr_delete'])) {
		
			C::t('#sanree_brand#sanree_brand_businesses')->update($_G['sr_delete'], array('isshow' => 1, 'status' => 1));
			fixthread($_G['sr_delete']);
			syngroup($_G['sr_delete']);
			sendbrand_notice($_G['sr_delete'],'brand_pass');
			
		}
		cpmsg($langs['succeed'], "action=plugins&operation=config&act=".$act."&do=businessesaudit&identifier=sanree_brand&pmod=admincp&page=".$page, 'succeed');
		
	} elseif(submitcheck('submit')){ 
	
		if($_G['sr_delete']) {
		
			C::t('#sanree_brand#sanree_brand_businesses')->delete($_G['sr_delete']);
			
		}		
		cpmsg($langs['succeed'], "action=plugins&operation=config&act=".$act."&do=businessesaudit&identifier=sanree_brand&pmod=admincp&cateid=".$cateid.'&page='.$page, 'succeed');
		
	} else {
	
		$category = C::t('#sanree_brand#sanree_brand_category')->fetch_all_category();
		$cates = array();
		foreach($category as $v) {
		
			$cates[$v[cateid]] = $v;
			
		}
		$skeyword = $_G['sr_skeyword'];
		showsubmenu($menustr);	 
		showformheader($thisurl.'&do='.$do);
		showtableheader($langs['searchbar'], '', 'style="border:1px solid #F0F7FD"');
		showtablerow('', '', $langs['skeyword'].'<input type="text" name="skeyword" value="'.$skeyword.'" class="txt" style="width:200px;" /> <input type="submit" value="'.$langs['search'].'" class="btn" name="searchsubmit"/>');
		showtablefooter();
		showformfooter();
		showformheader('plugins&operation=config&act='.$act.'&do=businessesaudit&identifier=sanree_brand&pmod=admincp&page='.$page);
		showtableheader($langs['unauditbusinesses'], 'nobottom');
		showsubtitle(array('',$langs['showorder'],$langs['catename'], $langs['subscriber'], $lang['name'], $langs['istop'], $langs['isshow'],$langs['status'], $langs['reason'],'time', 'operation'));
		$perpage = 10;
		$resultempty = FALSE;
		$orderby = $searchtext = $extra = $srchuid = '';
		$orderby = "displayorder,istop desc, dateline desc, status";
		$searchtext = ' AND status<>1 ';
		$extra = '&do='.$do;
		if(!empty($skeyword)){
		
			$searchfield = array('name', 'propaganda', 'introduction', 'contact', 'poster');
			$search = array();
			foreach($searchfield as $v) {
			
				$search[] = "(".$v." LIKE '%".$skeyword."%')";
				
			}
			$searchtext .= " AND (".implode(' OR ',$search).")";
			$extra .= '&skeyword='.urlencode($skeyword);
		}
		$count = C::t('#sanree_brand#sanree_brand_businesses')->count_by_where($searchtext);
		$multipage=multi($count, $perpage, $page, ADMINSCRIPT."?action=plugins&operation=config&act=$act&identifier=sanree_brand&pmod=admincp$extra");
		foreach(C::t('#sanree_brand#sanree_brand_businesses')->fetch_all_by_search($searchtext,$orderby,(($page - 1) * $perpage),$perpage) as $row) {
		
			$istopstr = $row[istop]==1 ?  $langs['yes']:$langs['no'];
			$statusstr = $row[status]==1 ? $langs['yes']:$langs['no'];
			$isshowstr = $row[isshow]==1 ? $langs['yes']:$langs['no'];
			showtablerow('', array('', 'class="td25"','','class="td26"'), array(
			"<input class=\"checkbox\" type=\"checkbox\" name=\"delete[$row[bid]]\" value=\"$row[bid]\">" ,
			$row[displayorder],
			$cates[$row[cateid]]["name"],
			'<a target="_blank" href="home.php?mod=space&amp;uid='.$row["uid"].'">'.C::t('#sanree_brand#xcommon_member')->fetch_all_username_by_uid($row[uid]).'</a>',
			$row[name],
			$istopstr,
			$isshowstr,
			$statusstr,
			'<div style="width:50px;overflow:hidden; height:40px;" title="'.$row[reason].'">'.$row[reason].'</div>',
			dgmdate($row[dateline]),
			'<a href="###" onclick="location.href=\''.ADMINSCRIPT.'?action=plugins&operation=config&act=businesseslist&identifier=sanree_brand&pmod=admincp&do=upgrading&bid='.$row['bid']."&page=".$page.'\'">'.$lang['edit'].'</a>',
			'<a href="###" onclick="location.href=\''.ADMINSCRIPT.'?action=plugins&operation=config&act=businesseslist&identifier=sanree_brand&pmod=admincp&do=businessesaudit&control=pass&bid='.$row['bid']."&page=".$page.'\'">'.$langs['pass'].'</a>',
			'<a href="###" onclick="location.href=\''.ADMINSCRIPT.'?action=plugins&operation=config&act=businesseslist&identifier=sanree_brand&pmod=admincp&do=businessesaudit&control=refuse&bid='.$row['bid']."&page=".$page.'\'">'.$langs['refuse'].'</a>',
			));
			
		}
		showsubmit('batch', $langs['batchshen'], '<INPUT class=checkbox onclick="checkAll(\'prefix\', this.form, \'delete\')" type=checkbox name=chkall><LABEL for=chkall>'.$langs['delorhen'].'</LABEL>', "<input class=\"checkbox\" type=\"hidden\" name=\"cateid\" value=\"$cateid\"><input type=\"submit\" id=\"del_submit\" class=\"btn\" onclick=\"return(confirm('".$langs['confirmationdel']."'))\" name=\"submit\" value=\"".$langs['batchdel']."\">", $multipage);		showtablefooter();
		showformfooter();
		
	}
	
} elseif ($do == 'upgrading') {

    $bid = intval($_G['sr_bid']);
	if(submitcheck('addsubmit')) {

	    $setarr = array();
		$cateid=intval($_G['sr_cateid']);
		if ($cateid<1) {
		
			cpmsg_error($langs['error_cateid']);
			
		}
	    $name = dhtmlspecialchars(trim($_G['sr_name']));
		if (empty($name)) {
		
			cpmsg_error($langs['error_nametip']);
			
		}			
		if ($bid < 1) {
		
			if ($_FILES['poster']) {
			
				if ($_FILES['poster']['error']>0) {
				
					cpmsg_error($langs['error_poster']);
					
				}
				
			} else {
			
				if (empty($_G['sr_poster'])&&$bid<1) {
				
					cpmsg_error($langs['error_poster']);
					
				}
				
			}
			
		}
		$setarr['name'] = $name;
		$setarr['cateid'] = $cateid;
		$setarr['keywords'] = dhtmlspecialchars(trim($_G['sr_keywords']));
		$setarr['description'] = dhtmlspecialchars(trim($_G['sr_description']));
		$setarr['propaganda'] = dhtmlspecialchars(trim($_G['sr_propaganda']));
		$setarr['introduction'] = dhtmlspecialchars(trim($_G['sr_introduction']));
		$setarr['contact'] = dhtmlspecialchars(trim($_G['sr_contact']));
		$setarr['weburl'] = dhtmlspecialchars(trim($_G['sr_weburl']));
		if ($ismultiple==1) {
			$setarr['qq'] = replaceparting(dhtmlspecialchars(trim($_G['sr_qq'])));
			$setarr['msn'] = replaceparting(dhtmlspecialchars(trim($_G['sr_msn'])));
			$setarr['wangwang'] = replaceparting(dhtmlspecialchars(trim($_G['sr_wangwang'])));
			$setarr['baiduhi'] = replaceparting(dhtmlspecialchars(trim($_G['sr_baiduhi'])));
			$setarr['skype'] = replaceparting(dhtmlspecialchars(trim($_G['sr_skype'])));
			$setarr['tel'] = replaceparting(dhtmlspecialchars(trim($_G['sr_tel'])));
			$setarr['allowmultiple'] = intval($_G['sr_allowmultiple']);
		} else {
			$setarr['qq'] = dhtmlspecialchars(trim($_G['sr_qq']));
			$setarr['tel'] = dhtmlspecialchars(trim($_G['sr_tel']));
		}
		$setarr['address'] = dhtmlspecialchars(trim($_G['sr_address']));
		$setarr['weixin'] = dhtmlspecialchars(trim($_G['sr_weixin']));
		
		$setarr['weixinpublic'] = dhtmlspecialchars(trim($_G['sr_weixinpublic']));

		$setarr['recommendationindex'] = dhtmlspecialchars(trim($_G['sr_recommendationindex']));
		$setarr['recommendationindex'] = sprintf("%.1f", $setarr['recommendationindex']);
		$setarr['weburl'] = 'http://'.str_replace("http://", '', $setarr['weburl']);		
		$setarr['istop'] = intval(trim($_G['sr_istop']));
		$setarr['isrecommend'] = intval(trim($_G['sr_isrecommend']));
		$setarr['groupid'] = intval(trim($_G['sr_groupid']));
		$setarr['displayorder'] = intval(trim($_G['sr_displayorder']));
		$setarr['isshow'] = intval(trim($_G['sr_isshow']));
		$setarr['memo'] = dhtmlspecialchars(trim($_G['sr_memo']));
		$setarr['allowalbum'] = intval(trim($_G['sr_allowalbum']));	
		$setarr['allowfastpost'] = intval(trim($_G['sr_allowfastpost']));	
		$setarr['startdate'] = !empty($_G['sr_startdate']) ? strtotime($_G['sr_startdate']) : 0;
		$setarr['enddate'] = !empty($_G['sr_enddate']) ? strtotime($_G['sr_enddate']) : 0;	
		$setarr['discount'] = intval(dhtmlspecialchars(trim($_G['sr_discount'])));
		$setarr['tel114id'] = intval(trim($_G['sr_tel114id']));
		$setarr['pbid'] = intval(trim($_G['sr_pbid']));
		$setarr['brandmf'] = implode(',',$_G['sr_brandmf']);
		$setarr['brandtag'] = dhtmlspecialchars(trim($_G['sr_brandtag']));				
		$setarr['isshowbrandname'] = intval(trim($_G['sr_isshowbrandname']));
		$setarr['iscard'] = intval(trim($_G['sr_iscard']));	
		$setarr['carddetail'] = dhtmlspecialchars(trim($_G['sr_carddetail']));	
		
		$brandno = dhtmlspecialchars(trim($_G['sr_brandno']));
		if (!empty($brandno)) {
		
		    if ($bid<1) {
			
				$count=C::t('#sanree_brand#sanree_brand_businesses')->count_by_where(" AND brandno='$brandno'");
				
			} else { 
			
				$count=C::t('#sanree_brand#sanree_brand_businesses')->count_by_where(" AND brandno='$brandno' AND name <> '$name'");
				
			}
			if ($count>0) {
			
				cpmsg_error($langs['ishavebrandno']);
				
			}			
			preg_match("/[^0-9a-zA-Z]/", $brandno, $matches);
			if (count($matches)>0) {
			
				cpmsg_error($langs['errorbrandno']);
				
			}
			$setarr['brandno'] = $brandno;
		}
		if ($mapapi=='google') {
			$setarr['googlemappos'] = dhtmlspecialchars(trim($_G['sr_mappos']));
		} else {
			$setarr['mappos'] = dhtmlspecialchars(trim($_G['sr_mappos']));
		}
		
        if ($_G['sr_birthprovince']) {
		
			$setarr['birthprovince'] = dhtmlspecialchars(trim($_G['sr_birthprovince']));
			$setarr['birthcity'] = dhtmlspecialchars(trim($_G['sr_birthcity']));
			$setarr['birthdist'] = dhtmlspecialchars(trim($_G['sr_birthdist']));
			$setarr['birthcommunity'] = dhtmlspecialchars(trim($_G['sr_birthcommunity']));
			
		}
        if ($_G['sr_srbirthprovince']) {
		
			$setarr['srbirthprovince'] = dhtmlspecialchars(trim($_G['sr_srbirthprovince']));
			$setarr['srbirthcity'] = dhtmlspecialchars(trim($_G['sr_srbirthcity']));
			$setarr['srbirthdist'] = dhtmlspecialchars(trim($_G['sr_srbirthdist']));
			$setarr['srbirthcommunity'] = dhtmlspecialchars(trim($_G['sr_srbirthcommunity']));
			
		}		
				
		$user = dhtmlspecialchars(trim($_G['sr_user']));
		$uid = 0;
		if ($user) {
		
			$t = C::t('#sanree_brand#xcommon_member')->fetch_uid_by_username($user);	
			if($t) {
			
				$uid = $setarr['uid'] = $t;
				
			} else {
			
				cpmsg_error($langs['error_nouser']);
				
			}
			
		} else {
		
			cpmsg_error($langs['error_nouser']);
			
		}
		$owner = dhtmlspecialchars(trim($_G['sr_owner']));
		if ($owner) {
		
			$t = C::t('#sanree_brand#xcommon_member')->fetch_uid_by_username($owner);	
			if($t) {
			
				$ownerid = $setarr['ownerid'] = $t;
				
			}
			else {
			
				cpmsg_error($langs['error_noowner']);
				
			}
			
		} else {
		
			$setarr['ownerid'] = 0;
			
		}	

		if ($bid>0) {
		
			C::t('#sanree_brand#sanree_brand_businesses')->update($bid, $setarr);
			fixalbum($bid, $setarr['uid']);
		}
		else {
		
		    $setarr['dateline'] = TIMESTAMP;
			$setarr['ip'] = $_G['clientip'];
			$setarr['status'] = 1;
			$bid = C::t('#sanree_brand#sanree_brand_businesses')->insert($setarr, TRUE);
					
		}
		$setarr = array();
		if($_FILES['poster']) {
		
			$data = array('extid' => $bid);			
			$post = myupload_icon_banner($bid, $data, $_FILES['poster'], $uid);
			if ($post) {
			
				$setarr['poster'] = $post[0];
				$setarr['caid'] = $post[1];
				
			}
			
		}
		if($_G['sr_deletelogo']) {
		
			$result = C::t('#sanree_brand#sanree_brand_businesses')->getusername_by_bid($bid);		
			$valueparse = parse_url($result['weixinpublicpic']);
			if(!isset($valueparse['host'])) {
			
				$result['weixinpublicpic'] && @unlink($_G['setting']['attachurl'].'common/'.$result['weixinpublicpic']);
				
			}
			$setarr['weixinpublicpic'] = '';
			
		} else {
		
			if($_FILES['weixinpublicpic']) {
			
				$data = array('extid' => $bid);
				$post = myupload_icon_banner($bid, $data, $_FILES['weixinpublicpic'], $uid);
				if ($post) {
				
					$setarr['weixinpublicpic'] = $post[0];
					
				}
				
			} else {
			
				$setarr['weixinpublicpic'] = $_G['sr_weixinpublicpic'];
				
			}
					
		}
		
		if($_G['sr_deletenewbanner']) {
		
			$result = C::t('#sanree_brand#sanree_brand_businesses')->getusername_by_bid($bid);		
			$valueparse = parse_url($result['newbanner']);
			if(!isset($valueparse['host'])) {
			
				$result['newbanner'] && @unlink($_G['setting']['attachurl'].'common/'.$result['newbanner']);
				
			}
			$setarr['newbannerurl'] = '';
			$setarr['newbanner'] = '';
			
		} else {

			$newbanner_list =  $_FILES['newbanner'];
			$_FILES['newbanner'] = array();
			foreach($newbanner_list['name'] as $key => $value) {
				$_FILES['newbanner'][] = array(
					'name' => $value,
					'type' => $newbanner_list['type'][$key],
					'tmp_name' => $newbanner_list['tmp_name'][$key],
					'error' => $newbanner_list['error'][$key],
					'size' => $newbanner_list['size'][$key]
				);
				
			}

			if($_FILES['newbanner']) {
				$setarr['newbannerurl'] = implode(',', $_G['sr_newbannerurl']);
				$setarr['newbanner'] = implode(',', $_G['sr_newbanner']);
				foreach($_FILES['newbanner'] as $newbanner) {
					$data = array('extid' => $bid);
					$post = myupload_icon_banner($bid, $data, $newbanner, $uid);
					if ($post) {
					
						$setarr['newbanner'] .= ','.$post[0];
					}
				}
				
			} else {

				$setarr['newbannerurl'] = implode(',', $_G['sr_newbannerurl']);
				$setarr['newbanner'] = implode(',', $_G['sr_newbanner']);
				
			}
		}

		if($_G['sr_deletewezgimg']) {

			$result = C::t('#sanree_brand#sanree_brand_businesses')->getusername_by_bid($bid);
			$valueparse = parse_url($result['wezgimg']);
			if(!isset($valueparse['host'])) {

				$result['wezgimg'] && @unlink($_G['setting']['attachurl'].'common/'.$result['wezgimg']);

			}
			$setarr['wezgimg'] = '';

		} elseif ($_FILES['wezgimg']) {
			$data = array('extid' => $bid);
			$post = myupload_icon_banner($bid, $data, $_FILES['wezgimg'], $uid);
			if ($post) {

				$setarr['wezgimg'] = $post[0];

			}

		} else {

			$setarr['wezgimg'] = $_G['sr_wezgimg'];

		}

		if($_G['sr_deletelogo1']) {
		
			$result = C::t('#sanree_brand#sanree_brand_businesses')->getusername_by_bid($bid);		
			$valueparse = parse_url($result['recommendimg']);
			if(!isset($valueparse['host'])) {
			
				$result['recommendimg'] && @unlink($_G['setting']['attachurl'].'common/'.$result['recommendimg']);
				
			}
			$setarr['recommendimg'] = '';
			
		} else {
		
			if($_FILES['recommendimg']) {
			
				$data = array('extid' => $bid);
				$setarr['recommendimg'] = upload_icon_banner($data, $_FILES['recommendimg'], 'brand_recommendimg');
				
			} else {
			
				$setarr['recommendimg'] = $_G['sr_recommendimg'];
				
			}
					
		}
		if($_G['sr_deletelogo2']) {
		
			$result = C::t('#sanree_brand#sanree_brand_businesses')->getusername_by_bid($bid);		
			$valueparse = parse_url($result['banner']);
			if(!isset($valueparse['host'])) {
			
				$result['banner'] && @unlink($_G['setting']['attachurl'].'common/'.$result['banner']);
				
			}
			$setarr['banner'] = '';
			
		} else {
		
			if($_FILES['banner']) {
			
				$data = array('extid' => $bid);
				$setarr['banner'] = upload_icon_banner($data, $_FILES['banner'], 'brand_banner');
				
			} else {
			
				$setarr['banner'] = $_G['sr_banner'];
				
			}		
		}
		if($_G['sr_deletelogo3']) {
		
			$result = C::t('#sanree_brand#sanree_brand_businesses')->getusername_by_bid($bid);		
			$valueparse = parse_url($result['weixinimg']);
			if(!isset($valueparse['host'])) {
			
				$result['weixinimg'] && @unlink($_G['setting']['attachurl'].'category/'.$result['weixinimg']);
				
			}
			$setarr['weixinimg'] = '';
			
		} else {
		
			if($_FILES['weixinimg']) {
			
				$data = array('extid' => $bid);			
				$post = myupload_icon_banner($bid, $data, $_FILES['weixinimg'], $uid);
				if ($post) {
				
					$setarr['weixinimg'] = $post[0];
					
				}
				
			} else {
			
				$setarr['weixinimg'] = $_G['sr_weixinimg'];
				
			}		
		}		
		if ($_G['sr_bodystyle']) {
			$cresult = C::t('#sanree_brand#sanree_brand_businesses')->getusername_by_bid($bid);	
			$bodyarr = unserialize($cresult['templateconfig']);
			$bodystyle = $_G['sr_bodystyle'];
			$bodyarr['bodystyle']['isuse'] = intval($bodystyle['isuse']);
			$bodyarr['bodystyle']['ishideheader'] = intval($bodystyle['ishideheader']);
			$bodyarr['bodystyle']['notbackimg'] = intval($bodystyle['notbackimg']);
			$bodyarr['bodystyle']['backgroundcolor'] = dhtmlspecialchars(trim($bodystyle['backcolor'])); 
		    $bodyarr['bodystyle']['backgroundattachment'] = chkthis($attachment, dhtmlspecialchars(trim($bodystyle['selectattachment'])));
			$bodyarr['bodystyle']['backgroundrepeat'] = chkthis($repeat, dhtmlspecialchars(trim($bodystyle['selectrepeat']))); 
			$bodyarr['bodystyle']['backgroundpositionx'] = chkthis($positionx, dhtmlspecialchars(trim($bodystyle['selectpositionx'])));
			$bodyarr['bodystyle']['backgroundpositiony'] = chkthis($positiony, dhtmlspecialchars(trim($bodystyle['selectpositiony'])));
			$backgroundimage= '';
			if($_FILES['backgroundimage']) {
				$data = array('extid' => $bid);			
				$post = myupload_icon_banner($bid, $data, $_FILES['backgroundimage'], $uid);
				if ($post) {
				
					$backgroundimage = $post[0];
					
				}
			} else {
			
				$backgroundimage = dhtmlspecialchars(trim($_G['sr_backgroundimage'])); 
				
			}
			$bodyarr['bodystyle']['backgroundimage'] = $backgroundimage; 
			$setarr['templateconfig']= serialize($bodyarr);
		}
					
		C::t('#sanree_brand#sanree_brand_businesses')->update($bid, $setarr);
		
		if (C::t('#sanree_brand#sanree_brand_businesses_module')->count_by_where(' AND bid='.$bid)>0) {

			C::t('#sanree_brand#sanree_brand_businesses_module')->update_by_bid($bid, $_G['sr_module']);
		
		} else {
		
		    $addarray = array();
			$addarray= $_G['sr_module'];
			$addarray[bid] = $bid;
			C::t('#sanree_brand#sanree_brand_businesses_module')->insert($addarray);
			
		}
		hookscript('sanreemoduleupdate', 'global', 'funcs', array('bid' => $bid,'data' => $_G['sr_module']), 'sanreemoduleupdate');	
		fixthread($bid);
		syngroup($bid);
		deletecachebrandpic($bid);
		sanreeupdatecache('hotbrandlist');
		sanreeupdatecache('recommendlist');
		sanreeupdatecache('newbrandlist');		
		cpmsg($langs['succeed'],'action=plugins&operation=config&act=businesseslist&identifier=sanree_brand&pmod=admincp&page='.$page, 'succeed');				
		
	} else {
	    showsubmenu($menustr);	
		if($bid>0) {
		
		    $menustr = $langs['editbusi'];
		    $result = C::t('#sanree_brand#sanree_brand_businesses')->getusername_by_bid($bid);	
			$result['owner'] = C::t('#sanree_brand#xcommon_member')->fetch_all_username_by_uid($result['ownerid']);
			$result['startdate'] = empty($result['startdate']) ? '' : dgmdate($result['startdate']);
			$result['enddate'] = empty($result['enddate']) ? '' : dgmdate($result['enddate']);
			if ($mapapi=='google') {
				$result['mappos'] = $result['googlemappos'];
			}
			$templateconfig = unserialize($result['templateconfig']);
			$result['propaganda'] = str_replace('&amp;', '&',$result['propaganda']);
			$result['introduction'] = str_replace('&amp;', '&',$result['introduction']);
			$result['contact'] = str_replace('&amp;', '&',$result['contact']);
			$result['brandtaglist'] = '';	
			if ($result['brandtag']) {
				$brandtagarr= explode(',', $result['brandtag']);
				$result['brandtaglist'] = '["'.implode('","',$brandtagarr).'"]';
			}
			
        } else {	
		
		    $menustr = $langs['addbusi'];
			$result['status'] = 1;
			$result['displayorder'] = 0;
			$result['isshow'] = 1;
			$result['user'] = C::t('#sanree_brand#xcommon_member')->fetch_all_username_by_uid($_G['uid']);
			$result['recommendationindex'] = sprintf("%.1f", $defaultzhishu);
			$result['groupid'] = $defaultconfig['groupid'];
			$result['allowalbum'] = $defaultconfig['allowalbum'];
			$result['allowfastpost'] = $defaultconfig['allowfastpost'];
			$result = array_merge($result, $defaultconfig['module']);
			$templateconfig= array();
			$templateconfig['bodystyle'] = $defaultconfig['bodystyle']; 
			$result['brandtaglist'] = '';

		}
		
		$cateselect = "<option value=\"0\" selected>".$langs['pselect']."</option>\n";
		$category = sanreeloadcache('admincate');
		$cates = array();
		foreach($category as $group) {
		
			if($group[cateid] == $result[cateid]) {
			
				$cateselect .= "<option value=\"$group[cateid]\" selected>$group[name]</option>\n";
				
			} else {
			
				$cateselect .= "<option value=\"$group[cateid]\">$group[name]</option>\n";
				
			}
			
		}
			
		$groupselect = "<option value=\"0\" selected>".$langs['pselect']."</option>\n";
		$category = C::t('#sanree_brand#sanree_brand_group')->fetch_all_group();
		$cate = array();
		foreach($category as $data) {
		
			$cate[] = array('cateid' => $data[groupid] , 'name' => $data[groupname]);
			
		}
		foreach($cate as $group) {
		
			if($group[cateid] == $result[groupid]) {
			
				$groupselect .= "<option value=\"$group[cateid]\" selected>$group[name]</option>\n";
				
			} else {
			
				$groupselect .= "<option value=\"$group[cateid]\">$group[name]</option>\n";
				
			}
			
		}
					
		if($result['poster']) {
		
			$valueparse = parse_url($result['poster']);
			if(isset($valueparse['host'])) {
			
				$grouplogo = $result['poster'];
				
			} else {
			
				$grouplogo = $_G['setting']['attachurl'].'category/'.$result['poster'].'?'.random(6);
				
			}
			$grouplogohtml = '<label></label><br /><img width="180" height="128" src="'.$grouplogo.'" />';
			
		}			
		$result['weburl'] = str_replace("http://", '', $result['weburl']);	
		showformheader($thisurl."&do=".$do."&bid=".$bid."&page=".$page, 'enctype');
		showtableheader($menustr, 'nobottom');
		showsetting($langs['catename'], '', '', '<select name="cateid">'.$cateselect.'</select>', '', '', $langs['bitian']);
		showsetting($langs['group'], '', '', '<select name="groupid">'.$groupselect.'</select>');
		showsetting($langs['discount'], '', '', brand_discountsetting($result['discount']));

		if ($isselfdistrict==1) {
		
		    echo '<script language="javascript" src="source/plugin/sanree_brand/tpl/good/js/district.js"></script>';
			$html = brand_setting('birthcity', $result);
			if($html) {
			
				showsetting($langs['region'], '', '', $html);
				
			}	
					
		} else {
		
			include_once libfile('function/profile');
			$html = profile_setting('birthcity', $result);
			if($html) {
			
				showsetting($langs['region'], '', '', $html);
				
			}
			
		}
		
		$mflist = array();
		foreach(C::t('#sanree_brand#sanree_brand_mf')->fetch_all_mf() as $data) {
		
			$mflist[] = array($data['mfid'], $data['mfname']);
			
		}
		
		
			
		showsetting($langs['brandmf'], array('brandmf',$mflist), explode(',', $result['brandmf']), 'mcheckbox');
		
		
		?>
		<div id="domfx"></div>
		<script language="javascript">
		disallowfloat = 'newthread';
		var arrayObj = new Array(<?php echo $result['brandtaglist'];?>);
		function showseltag() {
			var spage = $('spage').value;
			var url = '<?php echo ADMINSCRIPT?>?action=plugins&operation=config&act=businesseslist&identifier=sanree_brand&pmod=admincp&do=ajax&page='+spage;
			showWindow('settag',url);
			return false;
		}
		</script>
		<?php	
		
		showsetting($langs['brandtag'], '', '', '<input type="text" id="brandtag" name="brandtag" value="'.$result['brandtag'].'">','','','<button id="settag" onclick="showseltag();">'.$langs['selecttag'].'</button>&nbsp;&nbsp;Page:<input type="text" name="spage" size=2 id="spage" />', ' id="brandname" ');
		showsetting('name', 'name', $result['name'], 'text', '', '', $langs['bitian']);
		showsetting($langs['poster'], 'poster', $result['poster'], 'file', '', 0, $langs['logoruler'].$grouplogohtml);		
		showsetting($langs['subscriber'], 'user', $result['user'], 'text');
		showsetting($langs['owner'], 'owner', $result['owner'], 'text');
		showsetting($lang['keywords'], 'keywords', $result['keywords'], 'text');
		showsetting($lang['description'], 'description', $result['description'], 'textarea');
		showsetting($langs['propaganda'], 'propaganda', $result['propaganda'], 'textarea');
		showsetting($langs['introduction'], 'introduction', $result['introduction'], 'textarea');
		showsetting($langs['contact'], 'contact', $result['contact'], 'textarea');
		if ($ismultiple==1) {
			showsetting($langs['allowmultiple'], 'allowmultiple', $result['allowmultiple'], 'radio','','',$langs['allowmultipletip']);
			showsetting($langs['tel'], 'tel', $result['tel'], 'text', '', '',$langs['multipletip']);	
			showsetting($langs['qq'], 'qq', $result['qq'], 'text', '', '',$langs['multipletip']);
			showsetting($langs['msn'], 'msn', $result['msn'], 'text', '', '',$langs['multipletip']);
			showsetting($langs['wangwang'], 'wangwang', $result['wangwang'], 'text', '', '',$langs['multipletip']);
			showsetting($langs['baiduhi'], 'baiduhi', $result['baiduhi'], 'text', '', '',$langs['multipletip']);
			showsetting($langs['skype'], 'skype', $result['skype'], 'text', '', '',$langs['multipletip']);
		} else {
			showsetting($langs['tel'], 'tel', $result['tel'], 'text');	
			showsetting($langs['qq'], 'qq', $result['qq'], 'text');
		}
		showsetting($langs['weburl'], 'weburl', $result['weburl'], 'text');			
		showsetting($langs['address'], 'address', $result['address'], 'text');
		showsetting($langs['weixin'], 'weixin', $result['weixin'], 'text');
		showsetting($langs['weixinpublic'], 'weixinpublic', $result['weixinpublic'], 'text');
		
		$grouplogohtml='';
		$grouplogo='';
		if($result['weixinimg']) {
		
			$valueparse = parse_url($result['weixinimg']);
			if(isset($valueparse['host'])) {
			
				$grouplogo = $result['weixinimg'];
				
			} else {
			
				$grouplogo = $_G['setting']['attachurl'].'category/'.$result['weixinimg'].'?'.random(6);
				
			}
			$grouplogohtml = '<label><input type="checkbox" class="checkbox" name="deletelogo3[$result[bid]]" value="yes" /> '.$lang['delete'].'</label><br /><img width="120" height="120" src="'.$grouplogo.'" />';
			
		}		
		showsetting($langs['weixinimg'], 'weixinimg', $result['weixinimg'], 'filetext', '', '',$langs['logoruler3'].$grouplogohtml);
		$grouplogohtml='';
		$grouplogo='';
		if($result['weixinpublicpic']) {
		
			$valueparse = parse_url($result['weixinpublicpic']);
			if(isset($valueparse['host'])) {
			
				$grouplogo = $result['weixinpublicpic'];
				
			} else {
			
				$grouplogo = $_G['setting']['attachurl'].'category/'.$result['weixinpublicpic'].'?'.random(6);
				
			}
			$grouplogohtml = '<label><input type="checkbox" class="checkbox" name="deletelogo[$result[bid]]" value="yes" /> '.$lang['delete'].'</label><br /><img width="120" height="120" src="'.$grouplogo.'" />';
			
		}		
		showsetting($langs['weixinpublicpic'], 'weixinpublicpic', $result['weixinpublicpic'], 'file', '', '',$langs['logoruler3'].$grouplogohtml);
		
		showsetting($langs['recommendationindex'], 'recommendationindex', $result['recommendationindex'], 'text','','',$langs['recommendationindextip']);
		showsetting($langs['showorder'], 'displayorder', $result['displayorder'], 'text');
		$result['dateline'] && showsetting($langs['dateline'], 'dateline', dgmdate($result[dateline]), 'text','1');
		$result['ip'] && showsetting($langs['ip'], 'ip', $result[ip], 'text','1');
		showsetting($langs['audited'], 'status', $result['status'], 'radio','no');
		showsetting($langs['istop'], 'istop', $result['istop'], 'radio');
		showsetting($langs['isrecommend'], 'isrecommend', $result['isrecommend'], 'radio');	
		$grouplogohtml='';
		$grouplogo='';
		if($result['recommendimg']) {
		
			$valueparse = parse_url($result['recommendimg']);
			if(isset($valueparse['host'])) {
			
				$grouplogo = $result['recommendimg'];
				
			} else {
			
				$grouplogo = $_G['setting']['attachurl'].'common/'.$result['recommendimg'].'?'.random(6);
				
			}
			$grouplogohtml = '<label><input type="checkbox" class="checkbox" name="deletelogo1[$result[bid]]" value="yes" /> '.$lang['delete'].'</label><br /><img width="180" height="90" src="'.$grouplogo.'" />';
			
		}
		showsetting($langs['recommendimg'], 'recommendimg', $result['recommendimg'], 'filetext', '', 0, $langs['logoruler1'].$grouplogohtml);			
		showsetting($langs['isshow'], 'isshow', $result['isshow'], 'radio');
		showsetting($langs['brandno'], 'brandno', $result['brandno'], 'text','','', $langs['brandnotip']);
	?>
	<script type="text/javascript\" src="static/js/calendar.js"></script>
	<script>disallowfloat = 'newthread';</script>
<?php if ($mapapi=='baidu'){ ?>	
<script type="text/javascript" src="http://api.map.baidu.com/api?v=1.2"></script>
<script type="text/javascript" src=" http://api.map.baidu.com/library/CityList/1.2/src/CityList_min.js"></script>
<?php }?>
<?php if ($mapapi=='google'){ ?>	
<script src="http://ditu.google.cn/maps/api/js?sensor=false" type="text/javascript"></script>
<?php }?>
<TR><TD class=td27 colSpan=2 s="111"><?php echo $langs['mappos']?></TD></TR>
<TR class=noborder><TD class="vtop rowform"><INPUT class=txt name=mappos  value="<?php echo $result['mappos'];?>"id="mappoint_mappoint"> </TD>
<TD class="vtop tips2" s="111">&nbsp;&nbsp;<a href="plugin.php?id=sanree_brand&mod=map&do=marked&mappoint=<?php echo $result['mappos'];?>" id="showmap" onclick="showWindow('showmap',this.href);return false;"><?php echo $langs['marked']?></a></TD></TR>
	<?php		
	    showsetting($langs['allowalbum'], 'allowalbum', $result['allowalbum'], 'radio');
		showsetting($langs['allowfastpost'], 'allowfastpost', $result['allowfastpost'], 'radio');
		showsetting($langs['iscard'], 'iscard', $result['iscard'], 'radio','',1);
		showsetting($langs['carddetail'], 'carddetail', $result['carddetail'], 'textarea');
		showtagfooter('tbody');			
		showsetting($langs['startdate'], 'startdate', $result['startdate'], 'calendar');	
		showsetting($langs['enddate'], 'enddate', $result['enddate'], 'calendar');
		showsetting($langs['isshowbrandname'], 'isshowbrandname', $result['isshowbrandname'], 'radio');
		if(!$config['isbird']) {
			
			$grouplogohtml='';
			$grouplogo='';
			if($result['banner']) {
			
				$valueparse = parse_url($result['banner']);
				if(isset($valueparse['host'])) {
				
					$grouplogo = $result['banner'];
					
				} else {
				
					$grouplogo = $_G['setting']['attachurl'].'common/'.$result['banner'].'?'.random(6);
					
				}
				$grouplogohtml = '<label><input type="checkbox" class="checkbox" name="deletelogo2[$result[bid]]" value="yes" /> '.$lang['delete'].'</label><br /><img width="180" height="90" src="'.$grouplogo.'" />';
				
			}
			showsetting($langs['banner'], 'banner', $result['banner'], 'filetext', '', 0, $langs['logoruler2'].$grouplogohtml);
			
		} else {
			
			$newbanner = explode(',', $result['newbanner']);
			$newbannerurl = explode(',', $result['newbannerurl']);
			$grouplogohtml='';
			$grouplogo='';
			if($result['newbanner']) {
			
				$valueparse = parse_url($result['banner']);
				if(isset($valueparse['host'])) {

					$grouplogo = $result['newbanner'];
					
				} else {

					$newbanner1 = $_G['setting']['attachurl'].'category/'.$newbanner[0].'?'.random(6);
					$newbanner2 = $_G['setting']['attachurl'].'category/'.$newbanner[1].'?'.random(6);
					$newbanner3 = $_G['setting']['attachurl'].'category/'.$newbanner[2].'?'.random(6);
					$newbanner4 = $_G['setting']['attachurl'].'category/'.$newbanner[3].'?'.random(6);
					$newbanner5 = $_G['setting']['attachurl'].'category/'.$newbanner[4].'?'.random(6);
					
				}
				$grouplogohtml = $newbanner[0] ? '<label><input type="checkbox" class="checkbox" name="deletenewbanner[]" value="yes" /> '.$lang['delete'].'</label><br /><img width="180" height="90" src="'.$newbanner1.'" />' : '';
				$grouplogohtm2 = $newbanner[1] ? '<br /><img width="180" height="90" src="'.$newbanner2.'" />' : '';
				$grouplogohtm3 = $newbanner[2] ? '<br /><img width="180" height="90" src="'.$newbanner3.'" />' : '';
				$grouplogohtm4 = $newbanner[3] ? '<br /><img width="180" height="90" src="'.$newbanner4.'" />' : '';
				$grouplogohtm5 = $newbanner[4] ? '<br /><img width="180" height="90" src="'.$newbanner5.'" />' : '';
				
			}
			
			showsetting($langs['newbanner1'], 'newbanner[]', $newbanner[0], 'filetext', '', 0, $langs['newbanner_tip'].$grouplogohtml);
			showsetting($langs['newbannerurl1'], 'newbannerurl[]', $newbannerurl[0], 'text');
			showsetting($langs['newbanner2'], 'newbanner[]', $newbanner[1], 'filetext', '', 0, $langs['newbanner_tip'].$grouplogohtm2);
			showsetting($langs['newbannerurl2'], 'newbannerurl[]', $newbannerurl[1], 'text');
			showsetting($langs['newbanner3'], 'newbanner[]', $newbanner[2], 'filetext', '', 0, $langs['newbanner_tip'].$grouplogohtm3);
			showsetting($langs['newbannerurl3'], 'newbannerurl[]', $newbannerurl[2], 'text');
			showsetting($langs['newbanner4'], 'newbanner[]', $newbanner[3], 'filetext', '', 0, $langs['newbanner_tip'].$grouplogohtm4);
			showsetting($langs['newbannerurl4'], 'newbannerurl[]', $newbannerurl[3], 'text');
			showsetting($langs['newbanner5'], 'newbanner[]', $newbanner[4], 'filetext', '', 0, $langs['newbanner_tip'].$grouplogohtm5);
			showsetting($langs['newbannerurl5'], 'newbannerurl[]', $newbannerurl[4], 'text');
			
		}

		$is_we = C::t('common_plugin')->fetch_by_identifier('sanree_we');
		if ($is_we) {

			foreach(C::t('common_pluginvar')->fetch_all_by_pluginid($is_we['pluginid']) as $pluginvar => $val) {

				$variable = $val['variable'];
				$wapconfig[$variable] = $val['value'];

			}

			if ($wapconfig['isopen'] && $wapconfig['is_zg']) {

				if ($result['wezgimg']) {

					$valueparse = parse_url($result['wezgimg']);
					if(isset($valueparse['host'])) {

						$grouplogo = $result['wezgimg'];

					} else {

						$wezgimg = $_G['setting']['attachurl'].'category/'.$result['wezgimg'].'?'.random(6);

					}

					$zggrouplogohtm = $wezgimg ? '<label><input type="checkbox" class="checkbox" name="deletewezgimg" value="yes" /> '.$lang['delete'].'</label><br /><img width="180" height="90" src="'.$wezgimg.'" />' : '';

				}

				showsetting($langs['wezgimg'], 'wezgimg', $result['wezgimg'], 'filetext', '', 0, $langs['wezgimg_tip'].$zggrouplogohtm);

			}

		}

		showsetting($langs['pbid'], 'pbid', $result['pbid'], 'text', '' , '', $langs['pbidtip']);
		showsetting($langs['tel114id'], 'tel114id', $result['tel114id'], 'text', '' , '', $langs['tel114idtip']);
		$moduleresult = C::t('#sanree_brand#sanree_brand_businesses_module')->fetch_by_bid($bid);
		if (!$moduleresult) {
			$moduleresult = $defaultconfig['module'];
		}
		foreach(C::t('#sanree_brand#sanree_brand_businesses_module')->fetch_all_column() as $key =>$column)	{

			$columnname = $column[data];
			$type = $column[type];
			showsetting($langs['module'][$columnname], 'module['.$columnname.']', $moduleresult[$columnname], $type);
		
		}		
		$bodystyle = $templateconfig['bodystyle']; 
		$grouplogohtml = '';
		if($bodystyle['backgroundimage']) {
		
			$valueparse = parse_url($bodystyle['backgroundimage']);
			if(isset($valueparse['host'])) {
			
				$grouplogo = $bodystyle['backgroundimage'];
				
			} else {
			
				$grouplogo = $_G['setting']['attachurl'].'category/'.$bodystyle['backgroundimage'].'?'.random(6);
				
			}
			$grouplogohtml = '<label></label><br /><img width="180" height="128" src="'.$grouplogo.'" />';
			
		}
		showtablefooter();
		showtableheader($langs['templateconfig']);		
		showsetting($langs['isenableback'], 'bodystyle[isuse]', $bodystyle['isuse'], 'radio',0,1);
		showsetting($langs['hideheader'], 'bodystyle[ishideheader]', $bodystyle['ishideheader'], 'radio');
		showsetting($langs['backcolor'], 'bodystyle[backcolor]', $bodystyle['backgroundcolor'], 'color');
		showsetting($langs['backgroundimage'], 'backgroundimage', $bodystyle['backgroundimage'], 'filetext', '', '',$grouplogohtml);	
		showsetting($langs['notbacktip'], 'bodystyle[notbackimg]', $bodystyle['notbackimg'], 'radio');
		showsetting($langs['selectrepeatshow'], array('bodystyle[selectrepeat]',$repeat),$bodystyle['backgroundrepeat'], 'select');
		showsetting($langs['selectattachment'], array('bodystyle[selectattachment]',$attachment),$bodystyle['backgroundattachment'], 'select');
		showsetting($langs['backgroundpositionx'], array('bodystyle[selectpositionx]',$positionx),$bodystyle['backgroundpositionx'], 'select');
		showsetting($langs['backgroundpositiony'], array('bodystyle[selectpositiony]',$positiony),$bodystyle['backgroundpositiony'], 'select');
		showtagfooter('tbody');			
		showsetting($langs['memo'], 'memo', $result['memo'], 'textarea');
		showsubmit('addsubmit');
		showtablefooter();
		showformfooter();
				
	}

}
elseif  ($do == 'batchbrand') {

    $control= $_G['sr_control'];
	if(!in_array($control, array('allopenallowalbum', 'allcloseallowalbum', 'allopenallowfastpost', 'allcloseallowfastpost','fixtemplateconfig', 'allopenallowmultiple', 'allcloseallowmultiple'))) {
	
		$control = '';
		
	}
	if (submitcheck('fixmodulecolumn', 1)) {
	
		$pertask = isset($_G['sr_pertask']) ? intval($_G['sr_pertask']) : 100;
		$current = isset($_G['sr_current']) && $_G['sr_current'] > 0 ? intval($_G['sr_current']) : 0;
		$next = $current + $pertask;	
		$nextlink = "action=plugins&operation=config&act=businesseslist&do=batchbrand&identifier=sanree_brand&pmod=admincp&current=$next&pertask=$pertask&fixmodulecolumn=yes";
		if(fixmodule($current, $pertask)) {
			cpmsg("$langs[fixmodulecolumn_processing]: ".cplang('counter_processing', array('current' => $current, 'next' => $next)), $nextlink, 'loading');
		} else {
			cpmsg($langs['fixmodulecolumn_succeed'], 'action=plugins&operation=config&act='.$act.'&do=batchbrand&identifier=sanree_brand&pmod=admincp', 'succeed');
		}
		
	} elseif (submitcheck('fixalbum', 1)) {
	
		$pertask = isset($_G['sr_pertask']) ? intval($_G['sr_pertask']) : 100;
		$current = isset($_G['sr_current']) && $_G['sr_current'] > 0 ? intval($_G['sr_current']) : 0;
		$next = $current + $pertask;	
		$nextlink = "action=plugins&operation=config&act=businesseslist&do=batchbrand&identifier=sanree_brand&pmod=admincp&current=$next&pertask=$pertask&fixalbum=yes";
		if(fixalbumall($current, $pertask)) {
			cpmsg("$langs[fixalbum_processing]: ".cplang('counter_processing', array('current' => $current, 'next' => $next)), $nextlink, 'loading');
		} else {
			cpmsg($langs['fixalbum_succeed'], 'action=plugins&operation=config&act='.$act.'&do=batchbrand&identifier=sanree_brand&pmod=admincp', 'succeed');
		}
		
	} elseif(submitcheck('forumsubmit', 1)) {
	
		$nextlink = "action=plugins&operation=config&act=businesseslist&do=batchbrand&identifier=sanree_brand&pmod=admincp&current=$next&pertask=$pertask&forumsubmit=yes";
		$processed = 0;	
		$pertask = trim($_G['sr_pertask']);
		$columnlist = array();
		foreach(C::t('#sanree_brand#sanree_brand_businesses_module')->fetch_all_column() as $key =>$column)	{
			$columnlist[] = $column[data];
		}		
		if (in_array($pertask,$columnlist)) {
			C::t('#sanree_brand#sanree_brand_businesses_module')->update_all(array($pertask =>intval($_G['sr_'.$pertask])));
		}
		cpmsg($langs['succeed'], "action=plugins&operation=config&act=".$act."&do=batchbrand&identifier=sanree_brand&pmod=admincp", 'succeed');
		
	}elseif( $control == 'allopenallowalbum') {
	
	    C::t('#sanree_brand#sanree_brand_businesses')->update_all(array('allowalbum' =>1));
		cpmsg($langs['succeed'], "action=plugins&operation=config&act=".$act."&do=batchbrand&identifier=sanree_brand&pmod=admincp", 'succeed');
		
	}elseif( $control == 'allcloseallowalbum') {
	
	    C::t('#sanree_brand#sanree_brand_businesses')->update_all(array('allowalbum' =>0));
		cpmsg($langs['succeed'], "action=plugins&operation=config&act=".$act."&do=batchbrand&identifier=sanree_brand&pmod=admincp", 'succeed');
		
	}elseif( $control == 'allopenallowfastpost') {
	
	    C::t('#sanree_brand#sanree_brand_businesses')->update_all(array('allowfastpost' =>1));
		cpmsg($langs['succeed'], "action=plugins&operation=config&act=".$act."&do=batchbrand&identifier=sanree_brand&pmod=admincp", 'succeed');
		
	}elseif( $control == 'allcloseallowfastpost') {
	
	    C::t('#sanree_brand#sanree_brand_businesses')->update_all(array('allowfastpost' =>0));
		cpmsg($langs['succeed'], "action=plugins&operation=config&act=".$act."&do=batchbrand&identifier=sanree_brand&pmod=admincp", 'succeed');
		
    }elseif($control == 'fixtemplateconfig') {
	
		$templateconfig = array();
		$templateconfig['bodystyle'] = $defaultconfig['bodystyle'];	
	    C::t('#sanree_brand#sanree_brand_businesses')->update_all(array('templateconfig' =>serialize($templateconfig)));
		cpmsg($langs['succeed'], "action=plugins&operation=config&act=".$act."&do=batchbrand&identifier=sanree_brand&pmod=admincp", 'succeed');
	
	}elseif( $control == 'allopenallowmultiple') {
	
	    ($ismultiple==1) && C::t('#sanree_brand#sanree_brand_businesses')->update_all(array('allowmultiple' =>1));
		cpmsg($langs['succeed'], "action=plugins&operation=config&act=".$act."&do=batchbrand&identifier=sanree_brand&pmod=admincp", 'succeed');
		
	}elseif( $control == 'allcloseallowmultiple') {
	
	    ($ismultiple==1) && C::t('#sanree_brand#sanree_brand_businesses')->update_all(array('allowmultiple' =>0));
		cpmsg($langs['succeed'], "action=plugins&operation=config&act=".$act."&do=batchbrand&identifier=sanree_brand&pmod=admincp", 'succeed');
			
	} else {
		showsubmenu($menustr);
		showtableheader('', 'nobottom');		
		showtablerow('', array(), 
		array(
			'<ul class="tab1">'.
			'<li><a href="'.ADMINSCRIPT.'?action=plugins&operation=config&act=businesseslist&do=list&identifier=sanree_brand&pmod=admincp"><span>'.$langs['businesses_base'].'</span></a></li>'.
			'<li><a href="'.ADMINSCRIPT.'?action=plugins&operation=config&act=businesseslist&do=plug&identifier=sanree_brand&pmod=admincp"><span>'.$langs['businesses_plug'].'</span></a></li>'.
			'<li><a href="'.ADMINSCRIPT.'?action=plugins&operation=config&act=businesseslist&do=config&identifier=sanree_brand&pmod=admincp"><span>'.$langs['businesses_config'].'</span></a></li>'.					
			'<li class="current"><a href="'.ADMINSCRIPT.'?action=plugins&operation=config&act=businesseslist&do=batchbrand&identifier=sanree_brand&pmod=admincp"><span>'.$langs['batchbrand'].'</span></a></li>'.								
			'</ul>'
		));
		showtips($langs['batchbrandconfigtip']);
		showtableheader($langs['batchbrandconfig'], 'nobottom');		
		?>
		<script language="javascript">
		function allopenallowalbum(){
			if(confirm('<?php echo $langs['allopenallowalbumtip'];?>')) {
				location.href= '<?php echo ADMINSCRIPT?>?action=plugins&operation=config&act=businesseslist&do=batchbrand&identifier=sanree_brand&pmod=admincp&control=allopenallowalbum';
			}
		}
		function allcloseallowalbum(){
			if(confirm('<?php echo $langs['allcloseallowalbumtip'];?>')) {
				location.href= '<?php echo ADMINSCRIPT?>?action=plugins&operation=config&act=businesseslist&do=batchbrand&identifier=sanree_brand&pmod=admincp&control=allcloseallowalbum';
			}
		}
		function allopenallowfastpost(){
			if(confirm('<?php echo $langs['allopenallowfastposttip'];?>')) {
				location.href= '<?php echo ADMINSCRIPT?>?action=plugins&operation=config&act=businesseslist&do=batchbrand&identifier=sanree_brand&pmod=admincp&control=allopenallowfastpost';
			}
		}
		function allcloseallowfastpost(){
			if(confirm('<?php echo $langs['allcloseaallowfastposttip'];?>')) {
				location.href= '<?php echo ADMINSCRIPT?>?action=plugins&operation=config&act=businesseslist&do=batchbrand&identifier=sanree_brand&pmod=admincp&control=allcloseallowfastpost';
			}
		}
		function allfixtemplateconfig(){
			if(confirm('<?php echo $langs['allfixtemplateconfigtip'];?>')) {
				location.href= '<?php echo ADMINSCRIPT?>?action=plugins&operation=config&act=businesseslist&do=batchbrand&identifier=sanree_brand&pmod=admincp&control=fixtemplateconfig';
			}
		}
		function allopenallowmultiple(){
			if(confirm('<?php echo $langs['allopenallowmultipletip'];?>')) {
				location.href= '<?php echo ADMINSCRIPT?>?action=plugins&operation=config&act=businesseslist&do=batchbrand&identifier=sanree_brand&pmod=admincp&control=allopenallowmultiple';
			}
		}
		function allcloseallowmultiple(){
			if(confirm('<?php echo $langs['allcloseallowmultipletip'];?>')) {
				location.href= '<?php echo ADMINSCRIPT?>?action=plugins&operation=config&act=businesseslist&do=batchbrand&identifier=sanree_brand&pmod=admincp&control=allcloseallowmultiple';
			}
		}								
		</script>	
		<?php
		showtablerow('', array(), array(
			'<input onclick="allopenallowalbum();" type="button" class="btn" id="allopenallowalbum" name="allopenallowalbum" value="'.$langs['allopenallowalbum'].'" /> &nbsp;'.
			'<input onclick="allcloseallowalbum();" type="button" class="btn" id="allcloseallowalbum" name="allcloseallowalbum" value="'.$langs['allcloseallowalbum'].'" /> &nbsp;'.
			'<input onclick="allopenallowfastpost();" type="button" class="btn" id="allopenallowfastpost" name="allopenallowfastpost" value="'.$langs['allopenallowfastpost'].'" /> &nbsp;'.
			'<input onclick="allcloseallowfastpost();" type="button" class="btn" id="allcloseallowfastpost" name="allcloseallowfastpost" value="'.$langs['allcloseallowfastpost'].'" />',
			($ismultiple!=1) ? '' : '<input onclick="allopenallowmultiple();" type="button" class="btn" id="allopenallowmultiple" name="allopenallowmultiple" value="'.$langs['allopenallowmultiple'].'" />',
			($ismultiple!=1) ? '' : '<input onclick="allcloseallowmultiple();" type="button" class="btn" id="allcloseallowfastpost" name="allcloseallowfastpost" value="'.$langs['allcloseallowmultiple'].'" />',
		));
		showtablefooter();
		showformheader($thisurl.'&page='.$page.'&do=batchbrand');
		showtableheader();
		showsubtitle(array('', 'counter_amount'));
		showhiddenfields(array('pertask' => ''));
		showtablerow('', array('class="td21"'), array(
			"$langs[fixalbum]",
			'<input name="pertask2" type="text" class="txt" value="30" /><input type="submit" class="btn" name="fixalbum" onclick="this.form.pertask.value=this.form.pertask2.value" value="'.$lang['submit'].'" />'
		));	
		showtablerow('', array('class="td21"'), array(
			"$langs[fixmodulecolumn]",
			'<input name="pertask1" type="text" class="txt" value="30" /><input type="submit" class="btn" name="fixmodulecolumn" onclick="this.form.pertask.value=this.form.pertask1.value" value="'.$lang['submit'].'" />'
		));			
		foreach(C::t('#sanree_brand#sanree_brand_businesses_module')->fetch_all_column() as $key =>$column)	{
		
			$columnname = $column[data];
			$type = $column[type];	
			showtablerow('', array('class="td21 rowform"'), array(
				'<ul><li>'.$langs['module'][$columnname].':</li>
				 <li><input class="radio" type="radio" name="'.$columnname.'" value="1" >&nbsp;'.$lang['yes'].'</li>
				 <li class="checked"><input class="radio" type="radio" name="'.$columnname.'" value="0" checked>&nbsp;'.$lang['no'].'</li></ul>',
				'<input type="submit" class="btn" name="forumsubmit" onclick="if(!confirm(\''.$langs['allsubmit'].'\')) return false;this.form.pertask.value=\''.$columnname.'\'" value="'.$lang['submit'].'" />'
			));
			
		}
		showtablefooter();
		$murl = ADMINSCRIPT."?action=plugins&operation=config&act=businesseslist&do=config&identifier=sanree_brand&pmod=admincp#tempconfig";
		showtips(str_replace('{murl}', $murl, $langs['fixtemplateconfigtip']));
		showtableheader();	
		showtablerow('', array(''), array(
			'<input type="button" onclick="allfixtemplateconfig();" class="btn" name="fixtemplateconfig" value="'.$langs['fixtemplateconfig'].'" />'
		));			
		showtablefooter();
		showformfooter();
	
	}
	
} elseif  ($do == 'config') {

	if(submitcheck('submit')) {
	
		$adddatafield = array();
		foreach(C::t('#sanree_brand#sanree_brand_businesses_module')->fetch_all_column() as $key =>$column)	{

			$columnname = $column[data];
			$type = $column[type];
			if ($type=='radio') {
				$adddatafield []= $columnname;
			}
		
		}	
		$moduledata = array();
		$moduledata['groupid'] = intval($_G['sr_groupid']); 
		$moduledata['allowalbum'] = intval($_G['sr_allowalbum']); 
		$moduledata['allowfastpost'] = intval($_G['sr_allowfastpost']);
		if ($ismultiple==1) {
			$moduledata['allowmultiple'] = intval($_G['sr_allowmultiple']);
		}
		if ($_G['sr_bodystyle']) {
			$bodyarr = array();
			$bodystyle = $_G['sr_bodystyle'];
			$bodyarr['isuse'] = intval($bodystyle['isuse']);
			$bodyarr['ishideheader'] = intval($bodystyle['ishideheader']);
			$bodyarr['notbackimg'] = intval($bodystyle['notbackimg']);
			$bodyarr['backgroundcolor'] = dhtmlspecialchars(trim($bodystyle['backcolor'])); 
		    $bodyarr['backgroundattachment'] = chkthis($attachment, dhtmlspecialchars(trim($bodystyle['selectattachment'])));
			$bodyarr['backgroundrepeat'] = chkthis($repeat, dhtmlspecialchars(trim($bodystyle['selectrepeat']))); 
			$bodyarr['backgroundpositionx'] = chkthis($positionx, dhtmlspecialchars(trim($bodystyle['selectpositionx'])));
			$bodyarr['backgroundpositiony'] = chkthis($positiony, dhtmlspecialchars(trim($bodystyle['selectpositiony'])));
			$backgroundimage= '';
			if($_FILES['backgroundimage']) {
				$data = array('extid' => -99);	
				$post = myupload_icon_banner($bid, $data, $_FILES['backgroundimage'], $uid);
				if ($post) {
				
					$backgroundimage = $post[0];
					
				}
			} else {
			
				$backgroundimage = dhtmlspecialchars(trim($_G['sr_backgroundimage'])); 
				
			}
			$bodyarr['backgroundimage'] = $backgroundimage; 
			$moduledata['bodystyle']=  $bodyarr;
		}
				 
		foreach($adddatafield as $line) {
		
			$moduledata['module'][$line]= intval($_G['sr_'.$line]);
			
		}
		$contents= "<?php\r//Sanree cache file, DO NOT modify me!\r    $"."branddefault='".serialize($moduledata)."';\r?>";
		sysfilecache($contents, "sanree_brand_config.php");
		cpmsg($langs['succeed'], "action=plugins&operation=config&act=".$act."&do=config&identifier=sanree_brand&pmod=admincp&cateid=".$cateid.'&page='.$page, 'succeed');
		
	 } else {
	    
		showsubmenu($menustr);
		showtableheader('', 'nobottom');		
		showtablerow('', array(), 
		array(
			'<ul class="tab1">'.
			'<li><a href="'.ADMINSCRIPT.'?action=plugins&operation=config&act=businesseslist&do=list&identifier=sanree_brand&pmod=admincp"><span>'.$langs['businesses_base'].'</span></a></li>'.
			'<li><a href="'.ADMINSCRIPT.'?action=plugins&operation=config&act=businesseslist&do=plug&identifier=sanree_brand&pmod=admincp"><span>'.$langs['businesses_plug'].'</span></a></li>'.
			'<li class="current"><a href="'.ADMINSCRIPT.'?action=plugins&operation=config&act=businesseslist&do=config&identifier=sanree_brand&pmod=admincp"><span>'.$langs['businesses_config'].'</span></a></li>'.					
			'<li><a href="'.ADMINSCRIPT.'?action=plugins&operation=config&act=businesseslist&do=batchbrand&identifier=sanree_brand&pmod=admincp"><span>'.$langs['batchbrand'].'</span></a></li>'.								
			'</ul>'
		));
		showtablefooter();
		$category = C::t('#sanree_brand#sanree_brand_group')->fetch_all_group();
		$cate = array();
		foreach($category as $data) {
		
			$cate[] = array(0 => $data[groupid] , 1 => $data[groupname]);
			
		}
		showtips($langs['brandconfigtip']);
		showformheader($thisurl.'&page='.$page.'&do=config', 'enctype');
		showtableheader($langs['businesses_defaultconfig'], 'nobottom');
		showsetting($langs['group'], array('groupid', $cate), $defaultconfig['groupid'], 'select');
	    showsetting($langs['allowalbum'], 'allowalbum', $defaultconfig['allowalbum'], 'radio');
		showsetting($langs['allowfastpost'], 'allowfastpost', $defaultconfig['allowfastpost'], 'radio');
		if ($ismultiple==1) {
			showsetting($langs['allowmultiple'], 'allowmultiple', $defaultconfig['allowmultiple'], 'radio');	
		}	
		foreach(C::t('#sanree_brand#sanree_brand_businesses_module')->fetch_all_column() as $key =>$column)	{

			$columnname = $column[data];
			$type = $column[type];
			showsetting($langs['module'][$columnname], $columnname, $defaultconfig['module'][$columnname], $type);
		
		}
		showtablerow('', array(), array('<p id="tempconfig">&nbsp;</p>',''));
		$bodystyle = $defaultconfig['bodystyle'];
		if($bodystyle['backgroundimage']) {
		
			$valueparse = parse_url($bodystyle['backgroundimage']);
			if(isset($valueparse['host'])) {
			
				$grouplogo = $bodystyle['backgroundimage'];
				
			} else {
			
				$grouplogo = $_G['setting']['attachurl'].'category/'.$bodystyle['backgroundimage'].'?'.random(6);
				
			}
			$grouplogohtml = '<label></label><br /><img width="180" height="128" src="'.$grouplogo.'" />';
			
		}
		showtableheader($langs['newtemplateconfig']);		
		showsetting($langs['isenableback'], 'bodystyle[isuse]', $bodystyle['isuse'], 'radio',0,1);
		showsetting($langs['hideheader'], 'bodystyle[ishideheader]', $bodystyle['ishideheader'], 'radio');
		showsetting($langs['backcolor'], 'bodystyle[backcolor]', $bodystyle['backgroundcolor'], 'color');
		showsetting($langs['backgroundimage'], 'backgroundimage', $bodystyle['backgroundimage'], 'filetext', '', '',$grouplogohtml);	
		showsetting($langs['notbacktip'], 'bodystyle[notbackimg]', $bodystyle['notbackimg'], 'radio');
		showsetting($langs['selectrepeatshow'], array('bodystyle[selectrepeat]',$repeat),$bodystyle['backgroundrepeat'], 'select');
		showsetting($langs['selectattachment'], array('bodystyle[selectattachment]',$attachment),$bodystyle['backgroundattachment'], 'select');
		showsetting($langs['backgroundpositionx'], array('bodystyle[selectpositionx]',$positionx),$bodystyle['backgroundpositionx'], 'select');
		showsetting($langs['backgroundpositiony'], array('bodystyle[selectpositiony]',$positiony),$bodystyle['backgroundpositiony'], 'select');
		showtagfooter('tbody');			
		showsubmit('submit', 'submit', '', '', $multipage, false);
		showtablefooter();
		showformfooter();
		
	}
	
}
elseif  ($do == 'plug') {

	if(submitcheck('submit')) {
	
		$adddatafield = array();
		foreach(C::t('#sanree_brand#sanree_brand_businesses_module')->fetch_all_column() as $key =>$column)	{

			$columnname = $column[data];
			$type = $column[type];
			if ($type=='radio') {
				$adddatafield []= $columnname;
			}
		
		}	
		if(is_array($_G['sr_group_name'])) {
		
			foreach($_G['sr_group_name'] as $id => $title) {
			
				$setarr = array(
					'groupid' => intval($_G['sr_group_groupid'][$id]),
					'recommendationindex' => sprintf("%.1f", $_G['sr_group_recommendationindex'][$id]),
				);
				C::t('#sanree_brand#sanree_brand_businesses')->update($id,$setarr);
				$moduledata = array();
				foreach($adddatafield as $line) {
				
					$moduledata[$line]= intval($_G['sr_group_'.$line][$id]);
					
				}
				C::t('#sanree_brand#sanree_brand_businesses_module')->replaceupdate($id,$moduledata);
											
			}
			
		}	 	
		cpmsg($langs['succeed'], "action=plugins&operation=config&act=".$act."&do=plug&identifier=sanree_brand&pmod=admincp&cateid=".$cateid.'&page='.$page, 'succeed');
		
	 } else {
	 
		$category = C::t('#sanree_brand#sanree_brand_category')->fetch_all_category();
		$cates = array();
		foreach($category as $v) {
		
			$cates[$v[cateid]] = $v;
			
		}
		$skeyword = $_G['sr_skeyword'];
		showsubmenu($menustr);
		
		showtableheader('', 'nobottom');		
		showtablerow('', array(), 
		array(
			'<ul class="tab1">'.
			'<li><a href="'.ADMINSCRIPT.'?action=plugins&operation=config&act=businesseslist&do=list&identifier=sanree_brand&pmod=admincp"><span>'.$langs['businesses_base'].'</span></a></li>'.
			'<li class="current"><a href="'.ADMINSCRIPT.'?action=plugins&operation=config&act=businesseslist&do=plug&identifier=sanree_brand&pmod=admincp"><span>'.$langs['businesses_plug'].'</span></a></li>'.
			'<li><a href="'.ADMINSCRIPT.'?action=plugins&operation=config&act=businesseslist&do=config&identifier=sanree_brand&pmod=admincp"><span>'.$langs['businesses_config'].'</span></a></li>'.					
			'<li><a href="'.ADMINSCRIPT.'?action=plugins&operation=config&act=businesseslist&do=batchbrand&identifier=sanree_brand&pmod=admincp"><span>'.$langs['batchbrand'].'</span></a></li>'.							
			'</ul>'
		));
		showtablefooter();
					 
		showformheader($thisurl.'&do=plug');
		showtableheader($langs['searchbar'], '', 'style="border:1px solid #F0F7FD"');
		showtablerow('', '', $langs['skeyword'].'<input type="text" name="skeyword" value="'.$skeyword.'" class="txt" style="width:200px;" /> <input type="submit" value="'.$langs['search'].'" class="btn" name="searchsubmit"/>');
		showtablefooter();
		showformfooter();
		showformheader($thisurl.'&page='.$page.'&do=plug');
		showtableheader($langs['businesseslist'], 'nobottom');
		$addfield = array('ID', $lang['name'], $langs['group'], $langs['recommendationindex']);
		$adddatafield = array();
		foreach(C::t('#sanree_brand#sanree_brand_businesses_module')->fetch_all_column() as $key =>$column)	{

			$columnname = $column[data];
			$type = $column[type];
			if ($type=='radio') {
				$addfield []= $langs['module'][$columnname].'<br /><input type="checkbox" name="chkall'.$columnname.'" id="chkall'.$columnname.'" class="checkbox" onclick="checkAll(\'prefix\', this.form, \'group_'.$columnname.'\',\'chkall'.$columnname.'\')" /><label for="chkall'.$columnname.'">'.$langs['quanxuan'].'</label>';
				$adddatafield []= $columnname;
			}
		
		}
		showsubtitle($addfield);
		$perpage = 10;
		$resultempty = FALSE;
		$orderby = $searchtext = $extra = $srchuid = '';
		$orderby = 'bid desc';	
		$searchtext = ' AND status=1 ';	
		if (!empty($cateid)) {
		
			$searchtext .= "AND cateid ='".$cateid."'";

		}

		if(!empty($skeyword)){
		
			$searchfield = array('name', 'propaganda', 'introduction', 'contact', 'poster', 'brandno',
			 'memo','weburl', 'ip' , 'reason', 'qq' , 'address' , 'tel',
			 'birthprovince' ,'birthcity' , 'birthdist', 'birthcommunity');
			$search = array();
			foreach($searchfield as $v) {
			
				$search[] = "(".$v." LIKE '%".$skeyword."%')";
				
			}
			$searchtext .= " AND (".implode(' OR ',$search).")";
			$extra = '&skeyword='.urlencode($skeyword);
		}	
		
		$category = C::t('#sanree_brand#sanree_brand_group')->fetch_all_group();
		$cate = array();
		foreach($category as $data) {
		
			$cate[] = array('cateid' => $data[groupid] , 'name' => $data[groupname]);
			
		}	
		$count = C::t('#sanree_brand#sanree_brand_businesses')->count_by_where($searchtext);
		if ($cateid) $extra .="&cateid=".$cateid;
		$multipage=multi($count, $perpage, $page, ADMINSCRIPT."?action=plugins&operation=config&act=$act&do=plug&identifier=sanree_brand&pmod=admincp$extra");
		foreach(C::t('#sanree_brand#sanree_brand_businesses')->fetch_all_by_search($searchtext,$orderby,(($page - 1) * $perpage),$perpage) as $row) {
		
		    $module = C::t('#sanree_brand#sanree_brand_businesses_module')->fetch_by_bid($row["bid"]);
			$groupselect = "<select name=\"group_groupid[$row[bid]]\"><option value=\"0\">".$langs['gselect']."</option>\n";
			foreach($cate as $group) {
			
				if($group['cateid'] == $row['groupid']) {
				
					$groupselect .= "<option value=\"$group[cateid]\" selected>$group[name]</option>\n";
					
				} else {
				
					$groupselect .= "<option value=\"$group[cateid]\">$group[name]</option>\n";
					
				}
				
			}
			$groupselect .= '</select>';
					
			$datashow = array(
				"<input type=\"hidden\" name=\"group_name[$row[bid]]\" value=\"$row[bid]\"  />".$row["bid"] ,
				"<input type=\"text\" name=\"group_tmp[$row[bid]]\" value=\"$row[name]\" disabled=\"disabled\" />",
				$groupselect,
				"<input type=\"text\" class=\"txt\" name=\"group_recommendationindex[$row[bid]]\" value=\"$row[recommendationindex]\" />",
			);
			foreach ($adddatafield as $fieldrow) {
			
			    $ischeckedstr = $module[$fieldrow]==1 ? ' checked="checked"':'';
				$datashow[] = "<input type=\"checkbox\"  size=\"12\" name=\"group_".$fieldrow."[$row[bid]]\" value=\"1\" $ischeckedstr>";
				
			}
			showtablerow('', array('', '', '', 'class="td25"'), $datashow);
			
		}
		showsubmit('submit', 'submit', '', '', $multipage, false);
		showtablefooter();
		showformfooter();		
	}
	
}
elseif  ($do == 'list') {

	if(submitcheck('submit')) {
	
		if(is_array($_G['sr_group_name'])) {
		
			foreach($_G['sr_group_name'] as $id => $title) {
			
				if(!$_G['sr_delete'][$id]) {
				
					$setarr = array(
						'name' => $_G['sr_group_name'][$id],
						'displayorder' => $_G['sr_group_displayorder'][$id],
						'istop' => intval($_G['sr_group_istop'][$id]),
						'isrecommend' => intval($_G['sr_group_isrecommend'][$id]),
						'isshow' => intval($_G['sr_group_isshow'][$id]),
						'allowalbum' => intval($_G['sr_group_allowalbum'][$id]),
						'allowfastpost' => intval($_G['sr_group_allowfastpost'][$id]),
					);
					C::t('#sanree_brand#sanree_brand_businesses')->update($id,$setarr);
					fixthread($id);
					syngroup($id);
					deletecachebrandpic($id);
					
				}
				
			}
			
		}	 
		if($_G['sr_delete']) {

			C::t('#sanree_brand#sanree_brand_businesses')->delete($_G['sr_delete']);
			
		}	
		sanreeupdatecache('hotbrandlist');
		sanreeupdatecache('recommendlist');
		sanreeupdatecache('newbrandlist');			
		cpmsg($langs['succeed'], "action=plugins&operation=config&act=".$act."&identifier=sanree_brand&pmod=admincp&cateid=".$cateid.'&page='.$page, 'succeed');
		
	 } else {
	 
		$category = C::t('#sanree_brand#sanree_brand_category')->fetch_all_category();
		$cates = array();
		foreach($category as $v) {
		
			$cates[$v[cateid]] = $v;
			
		}
		$skeyword = $_G['sr_skeyword'];
		showsubmenu($menustr);
		
		showtableheader('', 'nobottom');		
		showtablerow('', array(), 
		array(
			'<ul class="tab1">'.
			'<li class="current"><a href="'.ADMINSCRIPT.'?action=plugins&operation=config&act=businesseslist&do=list&identifier=sanree_brand&pmod=admincp"><span>'.$langs['businesses_base'].'</span></a></li>'.
			'<li><a href="'.ADMINSCRIPT.'?action=plugins&operation=config&act=businesseslist&do=plug&identifier=sanree_brand&pmod=admincp"><span>'.$langs['businesses_plug'].'</span></a></li>'.
			'<li><a href="'.ADMINSCRIPT.'?action=plugins&operation=config&act=businesseslist&do=config&identifier=sanree_brand&pmod=admincp"><span>'.$langs['businesses_config'].'</span></a></li>'.			
			'<li><a href="'.ADMINSCRIPT.'?action=plugins&operation=config&act=businesseslist&do=batchbrand&identifier=sanree_brand&pmod=admincp"><span>'.$langs['batchbrand'].'</span></a></li>'.					
			'</ul>'
		));
		showtablefooter();
					 
		showformheader($thisurl);
		showtableheader($langs['searchbar'], '', 'style="border:1px solid #F0F7FD"');
		showtablerow('', '', $langs['skeyword'].'<input type="text" name="skeyword" value="'.$skeyword.'" class="txt" style="width:200px;" /> <input type="submit" value="'.$langs['search'].'" class="btn" name="searchsubmit"/>');
		showtablefooter();
		showformfooter();
		showformheader($thisurl.'&page='.$page);
		showtableheader($langs['businesseslist'], 'nobottom');
		showsubtitle(array('ID',$langs['showorder'],$langs['catename'],'tid','qtid', $langs['subscriber'], $lang['name'], $langs['istop'], $langs['isrecommend'],$langs['isshow'],$langs['talbum'],$langs['pmsg'],$langs['status'],'time', 'operation'));
		$perpage = 10;
		$resultempty = FALSE;
		$orderby = $searchtext = $extra = $srchuid = '';
		$orderby = 'istop desc,isrecommend desc,groupid desc, displayorder, bid desc';	
		$searchtext = ' AND status=1 ';	
		if (!empty($cateid)) {
		
			$searchtext .= "AND cateid ='".$cateid."'";

		}

		if(!empty($skeyword)){
		
			$searchfield = array('name');
			$search = array();
			foreach($searchfield as $v) {
			
				$search[] = "(".$v." LIKE '%".$skeyword."%')";
				
			}
			$searchtext .= " AND (".implode(' OR ',$search).")";
			$extra = '&skeyword='.urlencode($skeyword);
		}		
		$count = C::t('#sanree_brand#sanree_brand_businesses')->count_by_where($searchtext);
		if ($cateid) $extra .="&cateid=".$cateid;
		$multipage=multi($count, $perpage, $page, ADMINSCRIPT."?action=plugins&operation=config&act=$act&identifier=sanree_brand&pmod=admincp$extra");
		foreach(C::t('#sanree_brand#sanree_brand_businesses')->fetch_all_by_search($searchtext,$orderby,(($page - 1) * $perpage),$perpage) as $row) {
		
			$isrecommendstr = $row[isrecommend]==1 ? ' checked="checked"':'';
			$viewurl = getburl($row);;
			$istopstr = $row[istop]==1 ? ' checked="checked"':'';
			$statusstr = $row[status]==1 ? $langs['yes']:$langs['no'];
			$isshowsstr = $row[isshow]==1 ? ' checked="checked"':'';
			$allowalbumstr = $row[allowalbum]==1 ? ' checked="checked"':'';
			$allowfastpoststr = $row[allowfastpost]==1 ? ' checked="checked"':'';
			showtablerow('', array('', 'class="td25"','','class="td26"'), array(
			"<input class=\"checkbox\" type=\"checkbox\" name=\"delete[$row[bid]]\" value=\"$row[bid]\">".$row["bid"] ,
			"<input type=\"text\" class=\"txt\" size=\"12\" name=\"group_displayorder[$row[bid]]\" value=\"$row[displayorder]\">",
			$cates[$row[cateid]]["name"],
			'<a target="_blank" href="forum.php?mod=viewthread&amp;tid='.$row["tid"].'">'.$row["tid"].'</a>',
			'<a target="_blank" href="forum.php?mod=group&fid='.$row["syngrouptid"].'">'.$row["syngrouptid"].'</a>',
			'<a target="_blank" href="home.php?mod=space&amp;uid='.$row["uid"].'">'.C::t('#sanree_brand#xcommon_member')->fetch_all_username_by_uid($row[uid]).'</a>',
			"<input type=\"text\" class=\"txt\" size=\"12\" name=\"group_name[$row[bid]]\" value=\"$row[name]\">",
			"<input type=\"checkbox\"  size=\"12\" name=\"group_istop[$row[bid]]\" value=\"1\" $istopstr>",
			"<input type=\"checkbox\"  size=\"12\" name=\"group_isrecommend[$row[bid]]\" value=\"1\" $isrecommendstr>",
			"<input type=\"checkbox\"  size=\"12\" name=\"group_isshow[$row[bid]]\" value=\"1\" $isshowsstr>",
			"<input type=\"checkbox\"  size=\"12\" name=\"group_allowalbum[$row[bid]]\" value=\"1\" $allowalbumstr>",
			"<input type=\"checkbox\"  size=\"12\" name=\"group_allowfastpost[$row[bid]]\" value=\"1\" $allowfastpoststr>",
			$statusstr,
			dgmdate($row[dateline]),
			'<a href="###" onclick="location.href=\''.ADMINSCRIPT.'?action=plugins&operation=config&act=businesseslist&identifier=sanree_brand&pmod=admincp&do=upgrading&bid='.$row['bid']."&page=".$page.'\'">'.$langs['do_edit'].'</a> | '.
			'<a href="'.$viewurl.'" target="_blank">'.$langs['do_view'].'</a>',
			));
			
		}
		showsubmit('submit', 'submit', 'del', "<input class=\"checkbox\" type=\"hidden\" name=\"cateid\" value=\"$cateid\">", $multipage, false);
		showtablefooter();
		showformfooter();
		
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