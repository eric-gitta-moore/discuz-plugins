<?php

/**
 *      [Sanree] (C)2012-2099 Sanree Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: sanree_brand_domain.php $
 */

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}

$do = isset($_G['sr_do']) ? $_G['sr_do'] : '';
$doarray = array('list', 'upgrading', 'ajax', 'audit');
$do = !in_array($do,$doarray) ? 'list' : $do;
$page = isset($_G['sr_page']) ? $_G['sr_page'] : 0;
$page = max(1, intval($page));

if  ($do == 'audit') {

    $control= isset($_G['sr_control']) ? $_G['sr_control'] : '';
	if(!in_array($control, array('pass', 'refuse'))) {
	
		$control = '';
		
	}
	if ($control=='refuse') {
	
	    $domainid = intval($_G['sr_domainid']);
	    if (submitcheck('refuse')) {
		
		    C::t('#sanree_brand_domain#sanree_brand_domain')->update($domainid , array('reason' => dhtmlspecialchars(trim($_G['sr_reason'])), 'status' => -1));
			senddomain_notice($domainid,'domain_refuse');
			cpmsg($langs['succeed'], "action=plugins&operation=config&act=".$act."&do=audit&identifier=sanree_brand_domain&pmod=admincp&page=".$page, 'succeed');	
			
		} else {
		
			if($domainid>0) {
			
				$result = C::t('#sanree_brand_domain#sanree_brand_domain')->get_by_domainid($domainid);	
				showsubmenu($menustr);	
				showformheader($thisurl1."&do=".$do."&domainid=".$domainid."&page=".$page.'&control='.$control, 'enctype');
				showtableheader('', 'nobottom');
				showsetting($langs['domainname'], 'domainname', $result['domainname'], 'text','no');
				showsetting($langs['refusereason'], 'reason', $result['reason'], 'textarea');
				showsubmit('refuse', 'submit');
				showtablefooter();
				showformfooter();
								
			}		
			exit();
			
		}
		
	} elseif ($control=='pass') {

		if($domainid = intval($_G['sr_domainid'])) {
		
			C::t('#sanree_brand_domain#sanree_brand_domain')->update($domainid , array('status' => 1));
			senddomain_notice($domainid, 'domain_adminpass');
			
		}
		cpmsg($langs['succeed'], "action=plugins&operation=config&act=".$act."&do=audit&identifier=sanree_brand_domain&pmod=admincp&page=".$page, 'succeed');	
		
	} elseif(submitcheck('batch')) {
	
		if($ids = dimplode($_G['sr_delete'])) {
		
			C::t('#sanree_brand_domain#sanree_brand_domain')->update($_G['sr_delete'], array('status' => 1));
			sendbrand_notice($_G['sr_delete'],'domain_adminpass');
			
		}
		cpmsg($langs['succeed'], "action=plugins&operation=config&act=".$act."&do=audit&identifier=sanree_brand_domain&pmod=admincp&page=".$page, 'succeed');
		
	} elseif(submitcheck('submit')){ 
	
		if($_G['sr_delete']) {
		
			C::t('#sanree_brand_domain#sanree_brand_domain')->delete($_G['sr_delete']);
			
		}		
		cpmsg($langs['succeed'], "action=plugins&operation=config&act=".$act."&do=audit&identifier=sanree_brand_domain&pmod=admincp&page=".$page, 'succeed');
		
	} else {
	
		showsubmenu($menustr);

		$skeyword = isset($_G['sr_keyword']) ? $_G['sr_keyword'] : '';
		showformheader($thisurl1.'&do=audit');
		showtableheader($langs['searchbar'], '', 'style="border:1px solid #F0F7FD"');
		showtablerow('', '', $langs['skeyword'].'<input type="text" name="skeyword" value="'.$skeyword.'" class="txt" style="width:200px;" /> <input type="submit" value="'.$langs['search'].'" class="btn" name="searchsubmit"/>');
		showtablefooter();
		showformfooter();

		showformheader($thisurl1.'&do=audit&page='.$page);
		showtableheader($langs['domain'], 'nobottom');
		showsubtitle(array('',$langs['domainname'], $langs['user'], $langs['price'], 'time', 'operation'));
		$perpage = 10;
		$srchadd = $searchtext = $extra = $srchuid = '';
		$searchtext = ' AND status <> 1 ';		
		$orderby = 'domainid desc';
		
		if(!empty($skeyword)){
		
			$searchfield = array('domainname', 'uid', 'username');
			$search = array();
			foreach($searchfield as $v) {
			
				$search[] = "(".$v." LIKE '%".$skeyword."%')";
				
			}
			$searchtext .= " AND (".implode(' OR ',$search).")";
			$extra = '&skeyword='.urlencode($skeyword);
		}
				
		$count = C::t('#sanree_brand_domain#sanree_brand_domain')->count_by_wherec($searchtext);
		$multipage=multi($count, $perpage, $page, ADMINSCRIPT."?action=plugins&operation=config&act=$act&do=audit&identifier=sanree_brand_domain&pmod=admincp$extra");	
		$datalist = C::t('#sanree_brand_domain#sanree_brand_domain')->fetch_all_by_searchc($searchtext,$orderby,(($page - 1) * $perpage),$perpage);

		foreach($datalist as $value) {

			$operationstr = '<a href="###" onclick="location.href=\''.ADMINSCRIPT.'?action=plugins&operation=config&act=list&identifier=sanree_brand_domain&pmod=admincp&do=upgrading&domainid='.$value['domainid']."&page=".$page.'\'">'.$lang['edit'].'</a>';
			$operationstr.= ' | <a href="###" onclick="location.href=\''.ADMINSCRIPT.'?action=plugins&operation=config&act=list&identifier=sanree_brand_domain&pmod=admincp&do=audit&control=pass&domainid='.$value['domainid']."&page=".$page.'\'">'.$langs['passdomain'].'</a>';
			$operationstr.= ' | <a href="###" onclick="location.href=\''.ADMINSCRIPT.'?action=plugins&operation=config&act=list&identifier=sanree_brand_domain&pmod=admincp&do=audit&control=refuse&domainid='.$value['domainid']."&page=".$page.'\'">'.$langs['refusedomain'].'</a>';				
			showtablerow('', array('class="td25"', '','', 'class="td28"'), array(
				"<input class=\"checkbox\" type=\"checkbox\" name=\"delete[$value[domainid]]\" value=\"$value[domainid]\">",
				$value[domainname].$okdomain,
				'<a target="_blank" href="home.php?mod=space&amp;uid='.$value["uid"].'">'.$value['username'].'</a>',
				$value['price'],				
				$value['dateline'] ? dgmdate($value['dateline']):'',
				$operationstr
			));
			
		}
		showsubmit('batch', $langs['batchshen'], '<INPUT class=checkbox onclick="checkAll(\'prefix\', this.form, \'delete\')" type=checkbox name=chkall><LABEL for=chkall>'.$langs['delorhen'].'</LABEL>', "<input type=\"submit\" id=\"del_submit\" class=\"btn\" onclick=\"return(confirm('".$langs['confirmationdel']."'))\" name=\"submit\" value=\"".$langs['batchdel']."\">", $multipage);		
		showtablefooter();
		showformfooter();
		
	}
}
elseif ($do == 'ajax') {
		include template('common/header');
		echo '<h3 class="flb mn"><span><a href="javascript:;" class="flbc" onclick="MyhideWindow();" title="'.$lang['close'].'">'.$lang['close'].'</a></span>'.$langs['selectbrand'].'</h3>';
		$category = C::t('#sanree_brand#sanree_brand_category')->fetch_all_category();
		$cates = array();
		foreach($category as $v) {
		
			$cates[$v['cateid']] = $v;
			
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
  	    echo '<form name="cpform" onsubmit="return chkadd();" method="POST" autocomplete="off" action="'.ADMINSCRIPT.'?action='.$thisurl1.'&do=ajax&ajaxtarget=fwin_content_selbrand&inajax=1" id="cpform">'.
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
		$count = C::t('#sanree_brand_domain#sanree_brand_domain')->count_by_where($searchtext);
		$multipage=multi($count, $perpage, $page, ADMINSCRIPT."?action=plugins&operation=config&act=$act&identifier=sanree_brand_domain&pmod=admincp$extra");
		foreach(C::t('#sanree_brand_domain#sanree_brand_domain')->fetch_all_by_search($searchtext,$orderby,(($page - 1) * $perpage),$perpage) as $row) {

			showtablerow('class="hover" style="cursor:pointer" onclick="setbrand(\''.$row[name].'\')"', array(), array($row[name]));
			
		}
		showsubmit('','',$multipage);		
		showtablefooter();
		
		include template('common/footer');
} elseif ($do == 'upgrading') {
    $domainid = intval($_G['sr_domainid']);
	if(submitcheck('addsubmit')){
	    $setarr = array();
		$domainname = dhtmlspecialchars(trim($_G['sr_domainname']));
		if (empty($domainname)) {
			cpmsg_error($langs['error_domaintitle']);
		}	
		chkdomain($domainname);	
		$user = dhtmlspecialchars(trim($_G['sr_username']));
		$uid = 0;
		if ($user) {
		
			$t = C::t('#sanree_brand#xcommon_member')->fetch_uid_by_username($user);	
			if($t) {
			
				$uid = $setarr['uid'] = $t;
				$setarr['username'] =  $user;
				
			} else {
			
				cpmsg_error($langs['error_nouser']);
				
			}
			
		} else {
		
			cpmsg_error($langs['error_nouser']);
			
		}		
		$setarr['domainname'] = $domainname;	
		$setarr['status'] = intval(trim($_G['sr_status']));
		$setarr['price'] = intval(trim($_G['sr_price']));
		$setarr['startdate'] = !empty($_G['sr_startdate']) ? strtotime($_G['sr_startdate']) : 0;
		$setarr['enddate'] = !empty($_G['sr_enddate']) ? strtotime($_G['sr_enddate']) : 0;
		$setarr['adminuid'] =  $_G['uid'];
		$setarr['memo'] =  dhtmlspecialchars(trim($_G['sr_memo']));			
		if ($domainid) {
		
			C::t('#sanree_brand_domain#sanree_brand_domain')->update($domainid, $setarr);
			
		} else {
			$count=C::t('#sanree_brand_domain#sanree_brand_domain')->count_by_where(' AND domainname=\''.$domainname.'\'');
			if ($count>0) {
 
				cpmsg_error($langs['error_bdomain_have']);			
					
			}	
		    $setarr['dateline'] = TIMESTAMP;			
			C::t('#sanree_brand_domain#sanree_brand_domain')->insert($setarr);

		}	
		cpmsg($langs['succeed'], $gotourl.'domain&act=list&page='.$page, 'succeed');				
	}
	else {
	    showsubmenu($menustr);	
	
		if($domainid>0) {
		    $menustr = $langs['editdomain'];
		    $result = C::t('#sanree_brand_domain#sanree_brand_domain')->get_by_domainid($domainid);	
			$result['startdate'] = empty($result['startdate']) ? '' : dgmdate($result['startdate']);
			$result['enddate'] = empty($result['enddate']) ? '' : dgmdate($result['enddate']);				
        }
		else {	
		    $menustr = $langs['adddomain'];
			$result['status'] = 1;
			$result['startdate'] = dgmdate(TIMESTAMP);
			$result['enddate'] = 0;
			$result['username'] =  $_G['username'];
			$result['price'] = 0;			
		}	
		?>
		<script type="text/javascript\" src="static/js/calendar.js"></script>
		<?php			
		showformheader($thisurl1."&do=".$do."&domainid=".$domainid."&page=".$page, 'enctype');
		showtableheader($menustr, 'nobottom');
		showsetting($langs['domainname'], 'domainname', $result['domainname'], 'text', '', '', $langs['bdomaintip'], $result['domainname'] ? ' readonly' : '');		
		showsetting($langs['startdate'], 'startdate', $result['startdate'], 'calendar');	
		showsetting($langs['enddate'], 'enddate', $result['enddate'], 'calendar', '', '', $langs['enddatetip']);
		showsetting($langs['user'], 'username', $result['username'], 'text');
		showsetting($langs['price'], 'price', $result['price'], 'text');		
		showsetting($langs['status'], 'status', $result['status'], 'radio');
		$result['dateline'] && showsetting($langs['dateline'], 'dateline', dgmdate($result['dateline']), 'text','1');
		showsetting($langs['memo'], 'memo', $result['memo'], 'textarea');		
		showsubmit('addsubmit');
		showtablefooter();
		showformfooter();		
	}
} elseif ($do == 'list') {
	if(submitcheck('submit')){

		if($_G['sr_delete']) {

            srdeletedomain($_G['sr_delete']);
			C::t('#sanree_brand_domain#sanree_brand_domain')->delete($_G['sr_delete']);
			
		}	
		cpmsg($langs['succeed'], $gotourl.'list&page='.$page, 'succeed');	
		
	}
	else
	{	
		showsubmenu($menustr);

		$skeyword =  isset($_G['sr_skeyword']) ? $_G['sr_skeyword'] : '';
		showformheader($thisurl1);
		showtableheader($langs['searchbar'], '', 'style="border:1px solid #F0F7FD"');
		showtablerow('', '', $langs['skeyword'].'<input type="text" name="skeyword" value="'.$skeyword.'" class="txt" style="width:200px;" /> <input type="submit" value="'.$langs['search'].'" class="btn" name="searchsubmit"/>');
		showtablefooter();
		showformfooter();
						
		showformheader($thisurl1.'&page='.$page);
		showtableheader($langs['domain'], 'nobottom');
		showsubtitle(array('', $langs['domainname'], $langs['user'], $langs['price'], 'time',  $langs['enddate'],'operation'));
		$perpage = 10;
		$srchadd = $searchtext = $extra = $srchuid = '';
		$searchtext = ' AND status = 1 ';
		$orderby = 'domainid desc';
		
		if(!empty($skeyword)){
		
			$searchfield = array('domainname', 'uid', 'username');
			$search = array();
			foreach($searchfield as $v) {
			
				$search[] = "(".$v." LIKE '%".$skeyword."%')";
				
			}
			$searchtext .= " AND (".implode(' OR ',$search).")";
			$extra = '&skeyword='.urlencode($skeyword);
		}
				
		$count = C::t('#sanree_brand_domain#sanree_brand_domain')->count_by_wherec($searchtext);
		$multipage=multi($count, $perpage, $page, ADMINSCRIPT."?action=plugins&operation=config&act=$act&identifier=sanree_brand_domain&pmod=admincp$extra");	
		$datalist = C::t('#sanree_brand_domain#sanree_brand_domain')->fetch_all_by_searchc($searchtext,$orderby,(($page - 1) * $perpage),$perpage);

		foreach($datalist as $value) {

			showtablerow('', array('class="td25"', '','', 'class="td28"'), array(
				"<input class=\"checkbox\" type=\"checkbox\" name=\"delete[$value[domainid]]\" value=\"$value[domainid]\">",
				$value['domainname'].$okdomain,
				'<a target="_blank" href="home.php?mod=space&amp;uid='.$value["uid"].'">'.$value['username'].'</a>',
				$value['price'],
				$value['dateline'] ? dgmdate($value['dateline']):'',
				$value['enddate'] ? dgmdate($value['enddate']):'',
				'<a href="###" onclick="location.href=\''.ADMINSCRIPT.'?action=plugins&operation=config&act=list&identifier=sanree_brand_domain&pmod=admincp&do=upgrading&domainid='.$value['domainid']."&page=".$page.'\'">'.$lang['edit'].'</a>'
			));
			
		}
		echo '<tr><td>&nbsp;</td><td colspan="7"><div><a href="###" onclick="location.href=\''.ADMINSCRIPT.'?action=plugins&operation=config&act=list&identifier=sanree_brand_domain&pmod=admincp&do=upgrading\'" class="addtr">'.$langs['adddomain'].'</a></div></td></tr>';			
		showsubmit('submit', 'submit', 'del', '', $multipage, false);
		showtablefooter();
		showformfooter();
	}	
}
//From:www_YMG6_COM
?>