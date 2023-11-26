<?php

/**
 *      [fx8.cc] (C)2014-2017 ymg6.Com.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: sanree_brand_news_news.php sanree $
 */
if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('2014072820Zq5a00tJ50||7908||1402027202');
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
		$multipage=multi($count, $perpage, $page, ADMINSCRIPT."?action=plugins&operation=config&act=$act&identifier=sanree_brand_news&pmod=admincp$extra");
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
	    $nid = intval($_G['sr_nid']);
	    if (submitcheck('refuse')) {
		    C::t('#sanree_brand_news#sanree_brand_news')->update($nid , array('reason' => dhtmlspecialchars(trim($_G['sr_reason'])), 'status' => -1));
			news_notice($nid,'news_refuse');
			cpmsg($langs['succeed'], "action=plugins&operation=config&act=".$act."&do=businessesaudit&identifier=sanree_brand_news&pmod=admincp&page=".$page, 'succeed');	
		}
		else {
			if($nid>0) {
				$result = C::t('#sanree_brand_news#sanree_brand_news')->getusername_by_nid($nid);	
				showsubmenu($menustr);	 
				showformheader($thisurl."&do=".$do."&nid=".$nid."&page=".$page.'&control='.$control, 'enctype');
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
		if($nid = intval($_G['sr_nid'])) {
			C::t('#sanree_brand_news#sanree_brand_news')->update($nid , array('isshow' => 1, 'status' => 1));
			news_fixthread($nid);
			news_notice($nid,'news_adminpass');
			attention_information($nid, 'news');
		}
		cpmsg($langs['succeed'], "action=plugins&operation=config&act=".$act."&do=businessesaudit&identifier=sanree_brand_news&pmod=admincp&page=".$page, 'succeed');	
	}
	elseif(submitcheck('batch')) {
		if($ids = dimplode($_G['sr_delete'])) {
			C::t('#sanree_brand_news#sanree_brand_news')->update($_G['sr_delete'], array('isshow' => 1, 'status' => 1));
			news_fixthread($_G['sr_delete']);
			news_notice($_G['sr_delete'],'news_pass');
			attention_information($_G['sr_delete'], 'news');
		}
		cpmsg($langs['succeed'], "action=plugins&operation=config&act=".$act."&do=businessesaudit&identifier=sanree_brand_news&pmod=admincp&page=".$page, 'succeed');
	}
	elseif(submitcheck('submit')){ 
		if($_G['sr_delete']) {
		    $tids = array();
		    foreach (C::t('#sanree_brand_news#sanree_brand_news')->fetch_all_tid_by_nids($_G['sr_delete']) as $val) {
				$tids[] = $val[tid];
			}
			require_once libfile('function/delete');
            deletethread($tids);		
			C::t('#sanree_brand_news#sanree_brand_news')->delete($_G['sr_delete']);
		}		
		cpmsg($langs['succeed'], "action=plugins&operation=config&act=".$act."&do=businessesaudit&identifier=sanree_brand_news&pmod=admincp&cateid=".$cateid.'&page='.$page, 'succeed');
	 }
	 else
	 {
		$category = C::t('#sanree_brand_news#sanree_brand_news_category')->fetch_all_category();
		$cates = array();
		foreach($category as $v) {
			$cates[$v[cateid]] = $v;
		}
		$skeyword = $_G['sr_skeyword'];
		
		showsubmenu($menustr);	 
		showformheader('plugins&operation=config&identifier=sanree_brand_news&pmod=admincp&act=goods&do=businessesaudit');
		showtableheader($langs['searchbar'], '', 'style="border:1px solid #F0F7FD"');
		showtablerow('', '', $langs['skeyword'].'<input type="text" name="skeyword" value="'.$skeyword.'" class="txt" style="width:200px;" /> <input type="submit" value="'.$langs['search'].'" class="btn" name="searchsubmit"/>');
		showtablefooter();
		showformfooter();
		
		showformheader('plugins&operation=config&act='.$act.'&do=businessesaudit&identifier=sanree_brand_news&pmod=admincp&page='.$page);
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
		$count = C::t('#sanree_brand_news#sanree_brand_news')->count_by_where($searchtext);
		$multipage=multi($count, $perpage, $page, ADMINSCRIPT."?action=plugins&operation=config&act=$act&identifier=sanree_brand_news&pmod=admincp$extra");
		$datalist = C::t('#sanree_brand_news#sanree_brand_news')->fetch_all_by_search($searchtext,$orderby,(($page - 1) * $perpage),$perpage);
		foreach($datalist as $row) {
			$istopstr = $row[istop]==1 ?  $langs['yes']:$langs['no'];
			$statusstr = $row[status]==1 ? $langs['yes']:$langs['no'];
			$isshowstr = $row[isshow]==1 ? $langs['yes']:$langs['no'];
			showtablerow('', array('', 'class="td25"','','class="td26"'), array(
			"<input class=\"checkbox\" type=\"checkbox\" name=\"delete[$row[nid]]\" value=\"$row[nid]\">" ,
			$row[displayorder],
			$cates[$row[cateid]]["name"],
			$row[name],
			$istopstr,
			$isshowstr,
			$statusstr,
			'<div style="width:50px;overflow:hidden; height:40px;" title="'.$row[reason].'">'.$row[reason].'</div>',
			dgmdate($row[dateline]),
			'<a href="###" onclick="location.href=\''.ADMINSCRIPT.'?action=plugins&operation=config&act=news&identifier=sanree_brand_news&pmod=admincp&do=upgrading&nid='.$row['nid']."&page=".$page.'\'">'.$lang['edit'].'</a>',
			'<a href="###" onclick="location.href=\''.ADMINSCRIPT.'?action=plugins&operation=config&act=news&identifier=sanree_brand_news&pmod=admincp&do=businessesaudit&control=pass&nid='.$row['nid']."&page=".$page.'\'">'.$langs['pass'].'</a>',
			'<a href="###" onclick="location.href=\''.ADMINSCRIPT.'?action=plugins&operation=config&act=news&identifier=sanree_brand_news&pmod=admincp&do=businessesaudit&control=refuse&nid='.$row['nid']."&page=".$page.'\'">'.$langs['refuse'].'</a>',
			));
			
		}
		showsubmit('batch', $langs['batchshen'], '<INPUT class=checkbox onclick="checkAll(\'prefix\', this.form, \'delete\')" type=checkbox name=chkall><LABEL for=chkall>'.$langs['delorhen'].'</LABEL>', "<input class=\"checkbox\" type=\"hidden\" name=\"cateid\" value=\"$cateid\"><input type=\"submit\" id=\"del_submit\" class=\"btn\" onclick=\"return(confirm('".$langs['confirmationdel']."'))\" name=\"submit\" value=\"".$langs['batchdel']."\">", $multipage);		showtablefooter();
		showformfooter();
	}

} elseif  ($do == 'upgrading') {

		$nid = intval($_G['sr_nid']);
		if(submitcheck('addsubmit')){
		$aid = array();
		$ishome = intval($_G['sr_ishome']);

		foreach($_G['sr_attachnew'] as $key => $value) {
		
		    if ($value['isimage'] ==1) {
			
				$aid[] = $key;
				
			}
				
		}
		if (count($aid)>0) {
			if ($ishome<1) {
				$ishome = $aid[0];
			}
		}	
		
	    $setarr = array();
		$cateid=intval($_G['sr_cateid']);
		if ($cateid<1) {
		
			cpmsg_error($langs['error_cateid']);
			
		}
	    $name = dhtmlspecialchars(trim($_G['sr_name']));
		if (empty($name)) {
			cpmsg_error($langs['error_nametip']);
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
		$setarr['aids'] = implode($aid, '|');
		$setarr['homeaid'] = $ishome;			
		$setarr['name'] = $name;
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
		///$setarr['startdate'] = !empty($_G['sr_startdate']) ? strtotime($_G['sr_startdate']) : 0;
		///$setarr['enddate'] = !empty($_G['sr_enddate']) ? strtotime($_G['sr_enddate']) : 0;	

		if ($nid>0) {
			C::t('#sanree_brand_news#sanree_brand_news')->update($nid, $setarr);
		}
		else {
		    $setarr['dateline'] = TIMESTAMP;
			$setarr['ip'] = $_G['clientip'];
			$setarr['status'] = 1;
			$nid = C::t('#sanree_brand_news#sanree_brand_news')->insert($setarr, TRUE);
			attention_information($nid, 'news');
		}
		C::t('#sanree_brand_news#sanree_brand_news')->update($nid, $setarr);
		news_fixthread($nid);
		cpmsg($langs['succeed'],'action=plugins&operation=config&act=news&identifier=sanree_brand_news&pmod=admincp&page='.$page, 'succeed');				
	}
	else {
	    showsubmenu($menustr);	
		if($nid>0) {
		    $menustr = $langs['editbusi'];
		    $result = C::t('#sanree_brand_news#sanree_brand_news')->getusername_by_nid($nid);	
			$br = C::t('#sanree_brand#sanree_brand_businesses')->getusername_by_bid($result['bid']);
			$result['brandname'] = $br['name'];
			$result['startdate'] = empty($result['startdate']) ? '' : dgmdate($result['startdate']);
			$result['enddate'] = empty($result['enddate']) ? '' : dgmdate($result['enddate']);
        }
		else {	
		    $menustr = $langs['addbusi'];
			$result['status'] = 1;
			$result['displayorder'] = 0;
			$result['isshow'] = 1;
			$result['allowreply'] = 1;
			$result['user'] = C::t('#sanree_brand#xcommon_member')->fetch_all_username_by_uid($_G['uid']);	
		}
		
		$cateselect = "<option value=\"0\" selected>".$langs['pselect']."</option>\n";
		$category = news_loadcache('admincate');
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
		<script language="javascript">
		disallowfloat = 'newthread';
		function showselbrand() {
		    var spage = $('spage').value;
			var url = '<?php echo ADMINSCRIPT?>?action=plugins&operation=config&act=news&identifier=sanree_brand_news&pmod=admincp&do=ajax&page='+spage;
			showWindow('selbrand',url);
			return false;
		}
		</script>
		<?php	
		$result['weburl'] = str_replace("http://", '', $result['weburl']);	
		showformheader($thisurl."&do=".$do."&nid=".$nid."&page=".$page, 'enctype');
		showtableheader($menustr, 'nobottom');				
		showsetting($langs['catename'], '', '', '<select name="cateid">'.$cateselect.'</select>', '', '', $langs['bitian']);
		showsetting($langs['brandname'], 'brandname', $result['brandname'], 'text','','','<button id="selbrand" onclick="showselbrand();">'.$langs['selectbrand'].'</button>&nbsp;&nbsp;Page:<input type="text" name="spage" size=2 id="spage" />', ' id="brandname" ');	
		showsetting($langs['newsname'], 'name', $result['name'], 'text', '', '', $langs['bitian']);
		showsetting('keywords', 'keywords', $result['keywords'], 'text');
		showsetting($langs['description'], 'description', $result['description'], 'textarea');
		news_srshowsetting($langs['content'], 'content', $result, 'srimg','','', $langs['bitian']);
		showsetting($langs['displayorder'], 'displayorder', $result['displayorder'], 'text');
		///showsetting($langs['startdate'], 'startdate', $result['startdate'], 'calendar');	
		///showsetting($langs['enddate'], 'enddate', $result['enddate'], 'calendar');			
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
					C::t('#sanree_brand_news#sanree_brand_news')->update($id,$setarr);
					news_fixthread($id) ;
				}
				
			}
			
		}	 
		if($_G['sr_delete']) {
		
		    $tids = array();
		    foreach (C::t('#sanree_brand_news#sanree_brand_news')->fetch_all_tid_by_nids($_G['sr_delete']) as $val) {
			
				$tids[] = $val[tid];
				
			}
			require_once libfile('function/delete');
            deletethread($tids);
			C::t('#sanree_brand_news#sanree_brand_news')->delete($_G['sr_delete']);
			
		}		
		cpmsg($langs['succeed'], "action=plugins&operation=config&act=".$act."&identifier=sanree_brand_news&pmod=admincp&cateid=".$cateid.'&page='.$page, 'succeed');
		
	 } else {
	 
		$category = C::t('#sanree_brand_news#sanree_brand_news_category')->fetch_all_category();
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
		showtableheader($langs['news'], 'nobottom');
		showsubtitle(array('',$langs['showorder'],$langs['catename'],'tid', $lang['name'], $langs['istop'], $langs['isrecommend'], $langs['ishot'],$langs['reply'], $langs['isshow'],$langs['status'],'time', 'operation'));
		$perpage = 10;
		$resultempty = FALSE;
		$orderby = $searchtext = $extra = $srchuid = '';
		$orderby = 'istop desc,isrecommend desc, ishot desc, displayorder, nid desc';	
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
		$count = C::t('#sanree_brand_news#sanree_brand_news')->count_by_where($searchtext);
		if ($cateid) $extra .="&cateid=".$cateid;
		$multipage=multi($count, $perpage, $page, ADMINSCRIPT."?action=plugins&operation=config&act=$act&identifier=sanree_brand_news&pmod=admincp$extra");
		$datalist = C::t('#sanree_brand_news#sanree_brand_news')->fetch_all_by_search($searchtext,$orderby,(($page - 1) * $perpage),$perpage);
		foreach($datalist as $row) {
			$isrecommendstr = $row[isrecommend]==1 ? ' checked="checked"':'';
			$istopstr = $row[istop]==1 ? ' checked="checked"':'';
			$statusstr = $row[status]==1 ? $langs['yes']:$langs['no'];
			$ishotstr = $row[ishot]==1 ? ' checked="checked"':'';
			$isshowstr = $row[isshow]==1 ? ' checked="checked"':'';
			$allowreplystr = $row[allowreply]==1 ? ' checked="checked"':'';
			showtablerow('', array('', 'class="td25"','','class="td26"'), array(
			"<input class=\"checkbox\" type=\"checkbox\" name=\"delete[$row[nid]]\" value=\"$row[nid]\">" ,
			"<input type=\"text\" class=\"txt\" size=\"12\" name=\"group_displayorder[$row[nid]]\" value=\"$row[displayorder]\">",
			$cates[$row[cateid]]["name"],
			'<a target="_blank" href="forum.php?mod=viewthread&amp;tid='.$row["tid"].'">'.$row["tid"].'</a>',			
			"<input type=\"text\" class=\"txt\" size=\"12\" name=\"group_name[$row[nid]]\" value=\"$row[name]\">",
			"<input type=\"checkbox\"  size=\"12\" name=\"group_istop[$row[nid]]\" value=\"1\" $istopstr>",
			"<input type=\"checkbox\"  size=\"12\" name=\"group_isrecommend[$row[nid]]\" value=\"1\" $isrecommendstr>",
			"<input type=\"checkbox\"  size=\"12\" name=\"group_ishot[$row[nid]]\" value=\"1\" $ishotstr>",
			"<input type=\"checkbox\"  size=\"12\" name=\"group_allowreply[$row[nid]]\" value=\"1\" $allowreplystr>",
			"<input type=\"checkbox\"  size=\"12\" name=\"group_isshow[$row[nid]]\" value=\"1\" $isshowstr>",
			$statusstr,
			
			dgmdate($row[dateline]),
			'<a href="###" onclick="location.href=\''.ADMINSCRIPT.'?action=plugins&operation=config&act=news&identifier=sanree_brand_news&pmod=admincp&do=upgrading&nid='.$row['nid']."&page=".$page.'\'">'.$lang['edit'].'</a>'));
			
		}
		showsubmit('submit', 'submit', 'del', "<input class=\"checkbox\" type=\"hidden\" name=\"cateid\" value=\"$cateid\">", $multipage);
		showtablefooter();
		showformfooter();
	}
}
//From:www_YMG6_COM
?>