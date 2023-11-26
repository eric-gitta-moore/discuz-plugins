<?php

/**
 *      [fx8.cc] (C)2014-2017 ymg6.Com.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: sanree_brand_video_video.php sanree $
 */
if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('20131125098D7zaVQA8A||11681||1381384801');
}
$do= $_G['sr_do'];
$page = max(1, intval($_G['sr_page']));
if(!in_array($do, array('list', 'upgrading','businessesaudit', 'ajax'))) {
	$do = 'list';
}
if ($do == 'ajax') {
		include template('common/header');
		echo '<h3 class="flb mn"><span><a href="javascript:;" class="flbc" onclick="MyhideWindow();" title="'.$lang['close'].'">'.$lang['close'].'</a></span>'.$langs['selectbrand'].'</h3>';
		$category = C::t('#sanree_brand#sanree_brand_category')->fetch_all_category();
		$cates = array();
		foreach($category as $v) {
		
			$cates[$v[cateid]] = $v;
			
		}
		$skeyword = $_G['sr_skeyword'];
		?>
		<script language="javascript" reload="1">
		function MyhideWindow() {
			hideWindow('selbrand',1,0);
			$('domfx').innerHTML = '<style type="text/css">object{visibility:visible;}</style>';
		}
		  function fixa(){
			  var objs = $('fwin_content_selbrand').getElementsByTagName('a');
			  for(var i = 0; i < objs.length; i++) {
				  objs[i].setAttribute('fwin', 'selbrand');
				  objs[i].setAttribute('id', 'selbrand'+i);
				  if (objs[i].href.indexOf('page')>0) {
					  var u = objs[i].href;
					  objs[i].setAttribute('href', '###');
					  _attachEvent(objs[i], 'click', function (){
					  showWindow('selbrand',u);});
				  }
			  }
		  }
		</script>
		<?php
		$anchor = isset($_GET['anchor']) ? dhtmlspecialchars($_GET['anchor']) : '';
		echo '<script language="javascript">function setbrand(name){$("spage").value="'.$page.'";$("brandname").value=name;MyhideWindow();}function chkadd() {ajaxpost(\'cpform\', \'fwin_content_selbrand\', \'fwin_content_selbrand\',\'\',\'\',function(){fixa();});return false;}</script>';
  	    echo '<form name="cpform" onsubmit="return chkadd();" method="POST" autocomplete="off" action="'.ADMINSCRIPT.'?action='.$thisurl.'&do=ajax&ajaxtarget=fwin_content_selbrand&inajax=1" id="cpform">'.
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
		$orderby = 'istop desc,isrecommend desc,groupid desc, displayorder, bid desc';	
		$searchtext = ' AND status=1 ';	

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
		$extra .= '&do=ajax';	
		$count = C::t('#sanree_brand#sanree_brand_businesses')->count_by_where($searchtext);
		$multipage=multi($count, $perpage, $page, ADMINSCRIPT."?action=plugins&operation=config&act=$act&identifier=sanree_brand_video&pmod=admincp$extra");
		foreach(C::t('#sanree_brand#sanree_brand_businesses')->fetch_all_by_search($searchtext,$orderby,(($page - 1) * $perpage),$perpage) as $row) {

			showtablerow('class="hover" style="cursor:pointer" onclick="setbrand(\''.$row[name].'\')"', array(), array($row[name]));
			
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
	    $cid = intval($_G['sr_cid']);
	    if (submitcheck('refuse')) {
		    C::t('#sanree_brand_video#sanree_brand_video')->update($cid , array('reason' => dhtmlspecialchars(trim($_G['sr_reason'])), 'status' => -1));
			video_notice($cid,'video_refuse');
			cpmsg($langs['succeed'], "action=plugins&operation=config&act=".$act."&do=businessesaudit&identifier=sanree_brand_video&pmod=admincp&page=".$page, 'succeed');	
		}
		else {
			if($cid>0) {
				$result = C::t('#sanree_brand_video#sanree_brand_video')->getusername_by_cid($cid);	
				showsubmenu($menustr);	 
				showformheader($thisurl."&do=".$do."&cid=".$cid."&page=".$page.'&control='.$control, 'enctype');
				showtableheader('', 'nobottom');
				showsetting($langs['name'], 'name', $result['name'], 'text','no');
				showsetting($langs['refusereason'], 'reason', $result['reason'], 'textarea');
				showsubmit('refuse', 'submit');
				showtablefooter();
				showformfooter();				
			}		
			exit();
		}
	}
	elseif ($control=='pass') {
		if($cid = intval($_G['sr_cid'])) {
			C::t('#sanree_brand_video#sanree_brand_video')->update($cid , array('isshow' => 1, 'status' => 1));
			video_fixthread($cid);
			video_notice($cid,'video_adminpass');
		}
		cpmsg($langs['succeed'], "action=plugins&operation=config&act=".$act."&do=businessesaudit&identifier=sanree_brand_video&pmod=admincp&page=".$page, 'succeed');	
	}
	elseif(submitcheck('batch')) {
		if($ids = dimplode($_G['sr_delete'])) {
			C::t('#sanree_brand_video#sanree_brand_video')->update($_G['sr_delete'], array('isshow' => 1, 'status' => 1));
			video_fixthread($_G['sr_delete']);
			video_notice($_G['sr_delete'],'video_pass');
		}
		cpmsg($langs['succeed'], "action=plugins&operation=config&act=".$act."&do=businessesaudit&identifier=sanree_brand_video&pmod=admincp&page=".$page, 'succeed');
	}
	elseif(submitcheck('submit')){ 
		if($_G['sr_delete']) {
		    $tids = array();
		    foreach (C::t('#sanree_brand_video#sanree_brand_video')->fetch_all_tid_by_cids($_G['sr_delete']) as $val) {
				$tids[] = $val[tid];
			}
			require_once libfile('function/delete');
            deletethread($tids);		
			C::t('#sanree_brand_video#sanree_brand_video')->delete($_G['sr_delete']);
		}		
		cpmsg($langs['succeed'], "action=plugins&operation=config&act=".$act."&do=businessesaudit&identifier=sanree_brand_video&pmod=admincp&cateid=".$cateid.'&page='.$page, 'succeed');
	 }
	 else
	 {
		$category = C::t('#sanree_brand_video#sanree_brand_video_category')->fetch_all_category();
		$cates = array();
		foreach($category as $v) {
			$cates[$v[cateid]] = $v;
		}
		$skeyword = $_G['sr_skeyword'];
		
		showsubmenu($menustr);	 
		showformheader('plugins&operation=config&identifier=sanree_brand_video&pmod=admincp&act=goods&do=businessesaudit');
		showtableheader($langs['searchbar'], '', 'style="border:1px solid #F0F7FD"');
		showtablerow('', '', $langs['skeyword'].'<input type="text" name="skeyword" value="'.$skeyword.'" class="txt" style="width:200px;" /> <input type="submit" value="'.$langs['search'].'" class="btn" name="searchsubmit"/>');
		showtablefooter();
		showformfooter();
		
		showformheader('plugins&operation=config&act='.$act.'&do=businessesaudit&identifier=sanree_brand_video&pmod=admincp&page='.$page);
		showtableheader($langs['unauditbusinesses'], 'nobottom');
		showsubtitle(array('',$langs['showorder'],$langs['catename'], $lang['name'], $langs['istop'], $langs['isshow'],$langs['status'], $langs['reason'],'time', 'operation'));
		$perpage = 10;
		$resultempty = FALSE;
		$orderby = $searchtext = $extra = $srchuid = '';
		$orderby = "displayorder,istop desc, dateline desc, status";
		$searchtext = ' AND status<>1 ';
		if(!empty($skeyword)){
		
			$searchfield = array('name','memo','content', 'keywords' , 'description');
			$search = array();
			foreach($searchfield as $v) {
			
				$search[] = "(".$v." LIKE '%".$skeyword."%')";
				
			}
			$searchtext .= " AND (".implode(' OR ',$search).")";
			$extra = '&skeyword='.urlencode($skeyword);
		}
		$count = C::t('#sanree_brand_video#sanree_brand_video')->count_by_where($searchtext);
		$multipage=multi($count, $perpage, $page, ADMINSCRIPT."?action=plugins&operation=config&act=$act&identifier=sanree_brand_video&pmod=admincp$extra");
		$datalist = C::t('#sanree_brand_video#sanree_brand_video')->fetch_all_by_search($searchtext,$orderby,(($page - 1) * $perpage),$perpage);
		foreach($datalist as $row) {
			$istopstr = $row[istop]==1 ?  $langs['yes']:$langs['no'];
			$statusstr = $row[status]==1 ? $langs['yes']:$langs['no'];
			$isshowstr = $row[isshow]==1 ? $langs['yes']:$langs['no'];
			showtablerow('', array('', 'class="td25"','','class="td26"'), array(
			"<input class=\"checkbox\" type=\"checkbox\" name=\"delete[$row[cid]]\" value=\"$row[cid]\">" ,
			$row[displayorder],
			$cates[$row[cateid]]["name"],
			$row[name],
			$istopstr,
			$isshowstr,
			$statusstr,
			'<div style="width:50px;overflow:hidden; height:40px;" title="'.$row[reason].'">'.$row[reason].'</div>',
			dgmdate($row[dateline]),
			'<a href="###" onclick="location.href=\''.ADMINSCRIPT.'?action=plugins&operation=config&act=video&identifier=sanree_brand_video&pmod=admincp&do=upgrading&cid='.$row['cid']."&page=".$page.'\'">'.$lang['edit'].'</a>',
			'<a href="###" onclick="location.href=\''.ADMINSCRIPT.'?action=plugins&operation=config&act=video&identifier=sanree_brand_video&pmod=admincp&do=businessesaudit&control=pass&cid='.$row['cid']."&page=".$page.'\'">'.$langs['pass'].'</a>',
			'<a href="###" onclick="location.href=\''.ADMINSCRIPT.'?action=plugins&operation=config&act=video&identifier=sanree_brand_video&pmod=admincp&do=businessesaudit&control=refuse&cid='.$row['cid']."&page=".$page.'\'">'.$langs['refuse'].'</a>',
			));
			
		}
		showsubmit('batch', $langs['batchshen'], '<INPUT class=checkbox onclick="checkAll(\'prefix\', this.form, \'delete\')" type=checkbox name=chkall><LABEL for=chkall>'.$langs['delorhen'].'</LABEL>', "<input class=\"checkbox\" type=\"hidden\" name=\"cateid\" value=\"$cateid\"><input type=\"submit\" id=\"del_submit\" class=\"btn\" onclick=\"return(confirm('".$langs['confirmationdel']."'))\" name=\"submit\" value=\"".$langs['batchdel']."\">", $multipage);		showtablefooter();
		showformfooter();
	}

} elseif  ($do == 'upgrading') {

		$cid = intval($_G['sr_cid']);
		if(submitcheck('addsubmit')){
		
	    $setarr = array();
		$cateid=intval($_G['sr_cateid']);
		if ($cateid<1) {
		
			cpmsg_error($langs['error_cateid']);
			
		}
	    $name = dhtmlspecialchars(trim($_G['sr_name']));
		if (empty($name)) {
			cpmsg_error($langs['error_nametip']);
		}
	    $videourl = dhtmlspecialchars(trim($_G['sr_videourl']));
		if (empty($videourl)) {
			cpmsg_error($langs['error_videourltip']);
		}			
		$brandname = dhtmlspecialchars(trim($_G['sr_brandname']));
		if (empty($brandname)) {
			cpmsg_error($langs['error_brandnametip']);
		}		
		$brand = C::t('#sanree_brand#sanree_brand_businesses')->fetch_by_brandname($brandname);	
		if (!$brand) {
		
			cpmsg_error($langs['error_bid']);
			
		}						
		$setarr['bid'] = $brand[bid];	
		$setarr['name'] = $name;
		$setarr['videourl'] = $videourl;
		$setarr['width'] = intval(trim($_G['sr_width']));
		$setarr['height'] = intval(trim($_G['sr_height']));	
		$setarr['isshow'] = intval(trim($_G['sr_isshow']));	
		$setarr['uid'] = $brand[uid];
		$setarr['username'] = $brand[username];
		$setarr['cateid'] = $cateid;
		$setarr['keywords'] = dhtmlspecialchars(trim($_G['sr_keywords']));
		$setarr['description'] = dhtmlspecialchars(trim($_G['sr_description']));
		$setarr['content'] = dhtmlspecialchars(trim($_G['sr_content']));
		$setarr['istop'] = intval(trim($_G['sr_istop']));
		$setarr['isrecommend'] = intval(trim($_G['sr_isrecommend']));
		$setarr['displayorder'] = intval(trim($_G['sr_displayorder']));
		$setarr['ishot'] = intval(trim($_G['sr_ishot']));
		$setarr['memo'] = dhtmlspecialchars(trim($_G['sr_memo']));
		$setarr['allowreply'] = intval(trim($_G['sr_allowreply']));	
		$setarr['isshow'] = intval(trim($_G['sr_isshow']));	
	
		if ($cid>0) {
			C::t('#sanree_brand_video#sanree_brand_video')->update($cid, $setarr);
		} else {
		    $setarr['dateline'] = TIMESTAMP;
			$setarr['ip'] = $_G['clientip'];
			$setarr['status'] = 1;
			$cid = C::t('#sanree_brand_video#sanree_brand_video')->insert($setarr, TRUE);		
		}
		$setarr = array();
		if($_G['sr_deletelogo']) {
		
			$result = C::t('#sanree_brand_video#sanree_brand_video')->getusername_by_cid($cid);		
			$valueparse = parse_url($result['smallpic']);
			if(!isset($valueparse['host'])) {
			
				$result['smallpic'] && @unlink($_G['setting']['attachurl'].'category/'.$result['smallpic']);
				
			}
			$setarr['smallpic'] = '';
			
		} else {
		
			if($_FILES['smallpic']) {
			
				$data = array('extid' => $cid);
				$post = myupload_icon_banner($cid, $data, $_FILES['smallpic'], $uid);
				if ($post) {
				
					$setarr['smallpic'] = $post[0];
					$setarr['homeaid'] = $post[1];
					
				}
				
			} else {
			
				$setarr['smallpic'] = dhtmlspecialchars(trim($_G['sr_smallpic']));
				
			}
					
		}	
		C::t('#sanree_brand_video#sanree_brand_video')->update($cid, $setarr);
		video_fixthread($cid);
		cpmsg($langs['succeed'],'action=plugins&operation=config&act=video&identifier=sanree_brand_video&pmod=admincp&page='.$page, 'succeed');				
	}
	else {
	    showsubmenu($menustr);	
		if($cid>0) {
		
		    $menustr = $langs['editbusi'];
		    $result = C::t('#sanree_brand_video#sanree_brand_video')->getusername_by_cid($cid);	
			$br = C::t('#sanree_brand#sanree_brand_businesses')->getusername_by_bid($result['bid']);
			$result['brandname'] = $br['name'];
			$result['enddate'] = empty($result['enddate']) ? '' : dgmdate($result['enddate']);
			
        } else {	
		    $menustr = $langs['addbusi'];
			$result['status'] = 1;
			$result['displayorder'] = 0;
			$result['isshow'] = 1;
			$result['allowreply'] = 1;
			$result['user'] = C::t('#sanree_brand#xcommon_member')->fetch_all_username_by_uid($_G['uid']);	
			$result['width'] = '500';
			$result['height'] = '375';
		}
		
		$cateselect = "<option value=\"0\" selected>".$langs['pselect']."</option>\n";
		$category = video_loadcache('admincate');
		$cates = array();
		foreach($category as $group) {
		
			if($group[cateid] == $result[cateid]) {
			
				$cateselect .= "<option value=\"$group[cateid]\" selected>$group[name]</option>\n";
				
			} else {
			
				$cateselect .= "<option value=\"$group[cateid]\">$group[name]</option>\n";
				
			}
			
		}	
		?>
		<div id="domfx"></div>
		<script type="text/javascript" src="static/js/calendar.js"></script>
		<script language="javascript">
		disallowfloat = 'newthread';
		function showselbrand() {
		    var spage = $('spage').value;
			var url = '<?php echo ADMINSCRIPT?>?action=plugins&operation=config&act=video&identifier=sanree_brand_video&pmod=admincp&do=ajax&page='+spage;
			showWindow('selbrand',url);
			return false;
		}
		</script>
		<?php
		$grouplogohtml='';
		$grouplogo='';
		if($result['smallpic']) {
		
			$valueparse = parse_url($result['smallpic']);
			if(isset($valueparse['host'])) {
			
				$grouplogo = $result['smallpic'];
				
			} else {
			
				$grouplogo = $_G['setting']['attachurl'].'category/'.$result['smallpic'].'?'.random(6);
				
			}
			$grouplogohtml = '<label><input type="checkbox" class="checkbox" name="deletelogo[$result[cid]]" value="yes" /> '.$lang['delete'].'</label><br /><img width="180" height="90" src="'.$grouplogo.'" />';
			
		}		
		showformheader($thisurl."&do=".$do."&cid=".$cid."&page=".$page, 'enctype');
		showtableheader($menustr, 'nobottom');				
		showsetting($langs['catename'], '', '', '<select name="cateid">'.$cateselect.'</select>', '', '', $langs['bitian']);
		showsetting($langs['brandname'], 'brandname', $result['brandname'], 'text','','','<button id="selbrand" onclick="showselbrand();">'.$langs['selectbrand'].'</button>&nbsp;&nbsp;Page:<input type="text" name="spage" size=2 id="spage" />', ' id="brandname" ');	
		showsetting($langs['smallpic'], 'smallpic', $result['smallpic'], 'file', '', 0, $langs['smallpictip'].$grouplogohtml);
		showsetting($langs['videoname'], 'name', $result['name'], 'text', '', '', $langs['bitian']);
		showsetting($langs['videourl'], 'videourl', $result['videourl'], 'text', '', '', $langs['videourltip']);
		showsetting($langs['post_width'], 'width', $result['width'], 'text');
		showsetting($langs['post_height'], 'height', $result['height'], 'text');
		showsetting('keywords', 'keywords', $result['keywords'], 'text');
		showsetting('description', 'description', $result['description'], 'textarea');		
		showsetting($langs['content'], 'content', $result['content'], 'textarea');	
		showsetting($langs['displayorder'], 'displayorder', $result['displayorder'], 'text');		
		$result['dateline'] && showsetting($langs['dateline'], 'dateline', dgmdate($result[dateline]), 'text','1');
		showsetting($langs['audited'], 'status', $result['status'], 'radio','no');
		showsetting($langs['istop'], 'istop', $result['istop'], 'radio');
		showsetting($langs['isrecommend'], 'isrecommend', $result['isrecommend'], 'radio');	
		showsetting($langs['ishot'], 'ishot', $result['ishot'], 'radio');
	    showsetting($langs['allowreply'], 'allowreply', $result['allowreply'], 'radio');
		showsetting($langs['isshow'], 'isshow', $result['isshow'], 'radio');
		showsetting($langs['memo'], 'memo', $result['memo'], 'textarea');
		showsubmit('addsubmit');
		showtablefooter();
		showformfooter();
			
	}

} elseif  ($do == 'list') {

	if(submitcheck('submit')){
	
		if(is_array($_G['sr_group_name'])) {
		
			foreach($_G['sr_group_name'] as $id => $title) {
			
				if(!$_G['sr_delete'][$id]) {
				
					$setarr = array(
						'name' => $_G['sr_group_name'][$id],
						'displayorder' => $_G['sr_group_displayorder'][$id],
						'istop' => intval($_G['sr_group_istop'][$id]),
						'isrecommend' => intval($_G['sr_group_isrecommend'][$id]),
						'ishot' => intval($_G['sr_group_ishot'][$id]),
						'allowreply' => intval($_G['sr_group_allowreply'][$id]),
						'isshow' => intval($_G['sr_group_isshow'][$id]),
					);
					C::t('#sanree_brand_video#sanree_brand_video')->update($id,$setarr);
					video_fixthread($id) ;
				}
				
			}
			
		}	 
		if($_G['sr_delete']) {
		
		    $tids = array();
		    foreach (C::t('#sanree_brand_video#sanree_brand_video')->fetch_all_tid_by_cids($_G['sr_delete']) as $val) {
			
				$tids[] = $val[tid];
				
			}
			require_once libfile('function/delete');
            deletethread($tids);
			C::t('#sanree_brand_video#sanree_brand_video')->delete($_G['sr_delete']);
			
		}		
		cpmsg($langs['succeed'], "action=plugins&operation=config&act=".$act."&identifier=sanree_brand_video&pmod=admincp&cateid=".$cateid.'&page='.$page, 'succeed');
		
	 } else {
	 
		$category = C::t('#sanree_brand_video#sanree_brand_video_category')->fetch_all_category();
		$cates = array();
		foreach($category as $v) {
			$cates[$v[cateid]] = $v;
		}
		$skeyword = $_G['sr_skeyword'];
		showsubmenu($menustr);	 
		showformheader($thisurl);
		showtableheader($langs['searchbar'], '', 'style="border:1px solid #F0F7FD"');
		showtablerow('', '', $langs['skeyword'].'<input type="text" name="skeyword" value="'.$skeyword.'" class="txt" style="width:200px;" /> <input type="submit" value="'.$langs['search'].'" class="btn" name="searchsubmit"/>');
		showtablefooter();
		showformfooter();
		
		showformheader($thisurl.'&page='.$page);
		showtableheader($langs['video'], 'nobottom');
		showsubtitle(array('',$langs['showorder'],$langs['catename'],'tid', $lang['name'], $langs['istop'], $langs['isrecommend'], $langs['ishot'],$langs['reply'], $langs['isshow'],$langs['status'],'time', 'operation'));
		$perpage = 10;
		$resultempty = FALSE;
		$orderby = $searchtext = $extra = $srchuid = '';
		$orderby = 'istop desc,isrecommend desc, ishot desc, displayorder, cid desc';	
		$searchtext = ' AND status=1 ';	
		if (!empty($cateid)) {
		
			$searchtext .= "AND cateid ='".$cateid."'";

		}

		if(!empty($skeyword)){
		
			$searchfield = array('name','memo','content', 'keywords' , 'description');
			$search = array();
			foreach($searchfield as $v) {
			
				$search[] = "(".$v." LIKE '%".$skeyword."%')";
				
			}
			$searchtext .= " AND (".implode(' OR ',$search).")";
			$extra = '&skeyword='.urlencode($skeyword);
		}		
		$count = C::t('#sanree_brand_video#sanree_brand_video')->count_by_where($searchtext);
		if ($cateid) $extra .="&cateid=".$cateid;
		$multipage=multi($count, $perpage, $page, ADMINSCRIPT."?action=plugins&operation=config&act=$act&identifier=sanree_brand_video&pmod=admincp$extra");
		$datalist = C::t('#sanree_brand_video#sanree_brand_video')->fetch_all_by_search($searchtext,$orderby,(($page - 1) * $perpage),$perpage);
		foreach($datalist as $row) {
			$isrecommendstr = $row[isrecommend]==1 ? ' checked="checked"':'';
			$istopstr = $row[istop]==1 ? ' checked="checked"':'';
			$statusstr = $row[status]==1 ? $langs['yes']:$langs['no'];
			$ishotstr = $row[ishot]==1 ? ' checked="checked"':'';
			$isshowstr = $row[isshow]==1 ? ' checked="checked"':'';
			$allowreplystr = $row[allowreply]==1 ? ' checked="checked"':'';
			showtablerow('', array('', 'class="td25"','','class="td26"'), array(
			"<input class=\"checkbox\" type=\"checkbox\" name=\"delete[$row[cid]]\" value=\"$row[cid]\">" ,
			"<input type=\"text\" class=\"txt\" size=\"12\" name=\"group_displayorder[$row[cid]]\" value=\"$row[displayorder]\">",
			$cates[$row[cateid]]["name"],
			'<a target="_blank" href="forum.php?mod=viewthread&amp;tid='.$row["tid"].'">'.$row["tid"].'</a>',			
			"<input type=\"text\" class=\"txt\" size=\"12\" name=\"group_name[$row[cid]]\" value=\"$row[name]\">",
			"<input type=\"checkbox\"  size=\"12\" name=\"group_istop[$row[cid]]\" value=\"1\" $istopstr>",
			"<input type=\"checkbox\"  size=\"12\" name=\"group_isrecommend[$row[cid]]\" value=\"1\" $isrecommendstr>",
			"<input type=\"checkbox\"  size=\"12\" name=\"group_ishot[$row[cid]]\" value=\"1\" $ishotstr>",
			"<input type=\"checkbox\"  size=\"12\" name=\"group_allowreply[$row[cid]]\" value=\"1\" $allowreplystr>",
			"<input type=\"checkbox\"  size=\"12\" name=\"group_isshow[$row[cid]]\" value=\"1\" $isshowstr>",
			$statusstr,
			
			dgmdate($row[dateline]),
			'<a href="###" onclick="location.href=\''.ADMINSCRIPT.'?action=plugins&operation=config&act=video&identifier=sanree_brand_video&pmod=admincp&do=upgrading&cid='.$row['cid']."&page=".$page.'\'">'.$lang['edit'].'</a>'));
			
		}
		showsubmit('submit', 'submit', 'del', "<input class=\"checkbox\" type=\"hidden\" name=\"cateid\" value=\"$cateid\">", $multipage);
		showtablefooter();
		showformfooter();
	}
}
//From:www_YMG6_COM
?>