<?php

/**
 *      [fx8.cc] (C)2014-2017 ymg6.Com.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: sanree_brand_guestbook_guestbook.php sanree $
 */
if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('2014061214b98wB3Bomz||7247||1422453601');
}
$do= $_G['sr_do'];
$page = max(1, intval($_G['sr_page']));
if(!in_array($do, array('list', 'upgrading', 'audit','ajax','view'))) {
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
			 'memo','weburl', 'ip' , 'refuse', 'qq' , 'address' , 'tel',
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
		$multipage=multi($count, $perpage, $page, ADMINSCRIPT."?action=plugins&operation=config&act=$act&identifier=sanree_brand_guestbook&pmod=admincp$extra");
		foreach(C::t('#sanree_brand#sanree_brand_businesses')->fetch_all_by_search($searchtext,$orderby,(($page - 1) * $perpage),$perpage) as $row) {

			showtablerow('class="hover" style="cursor:pointer" onclick="setbrand(\''.$row[name].'\')"', array(), array($row[name]));
			
		}
		showsubmit('','',$multipage);		
		showtablefooter();
		include template('common/footer');

} elseif  ($do == 'audit') {

	$guestbookid = intval($_G['sr_guestbookid']);
	if (submitcheck('submit')) {
	
		C::t('#sanree_brand_guestbook#sanree_brand_guestbook')->update($guestbookid , array('refuse' => dhtmlspecialchars(trim($_G['sr_refuse'])), 'status' => 1, 'opdate' => TIMESTAMP, 'cpuid'=>$_G[uid]));
		guestbook_notice($guestbookid, 'handle');
		cpmsg($langs['succeed'], "action=plugins&operation=config&act=".$act."&do=list&type=1&identifier=sanree_brand_guestbook&pmod=admincp&page=".$page, 'succeed');	
		
	} else {
	
		if($guestbookid>0) {
		
			$result = C::t('#sanree_brand_guestbook#sanree_brand_guestbook')->fetch_first_by_guestbookid($guestbookid);	
			showsubmenu($menustr);	
			showtableheader('', 'nobottom');
			showtablerow('', array(), array(shownavmenu(0, array(0,1), $langs)));
			showtablefooter();
			showformheader($thisurl."&do=".$do."&guestbookid=".$guestbookid."&page=".$page.'&control='.$control, 'enctype');
			showtableheader($langs['typeinfo0'], 'nobottom');
			$br = C::t('#sanree_brand#sanree_brand_businesses')->getusername_by_bid($result['bid']);
			$result['brandname'] = $br['name'];
			$result['username'] = empty($result['username']) ? $langs['guestuser']: $result['username'];
			
			showtablerow('','',array($langs['bguestbookid'].$result['guestbookid']));
			showtablerow('','',array($langs['busername'].$result['username']));
			showtablerow('','',array($langs['bbrandname'].$result['brandname']));				
			showtablerow('','',array($langs['bname'].$result['title']));
			showtablerow('','',array($langs['fullnameshow'].$result['fullname']));
			showtablerow('','',array($langs['baddress'].$result['address']));
			showtablerow('','',array($langs['bphone'].$result['phone']));
			showtablerow('','',array($langs['bemail'].$result['email']));
			showtablerow('','',array($langs['bqq'].$result['qq']));
			?>
			<tr><td colspan="2"><?php echo $langs['bwords'];?></td></tr>				
			<tr><td colspan="2"><p><div style="word-break:break-all;border:1px dashed #aaa; padding:10px; background-color:#CCCCCC">
			<?php echo dhtmlspecialchars($result['words']);?>
			</div></p></td></tr>
			<?php
			showsetting($langs['refuserefuse'], 'refuse', $result['refuse'], 'textarea');
			showsubmit('submit', 'submit');
			showtablefooter();
			showformfooter();				
		}		
	}

} elseif  ($do == 'view') {

    $guestbookid = intval($_G['sr_guestbookid']);
	if($guestbookid>0) {
		$result = C::t('#sanree_brand_guestbook#sanree_brand_guestbook')->fetch_first_by_guestbookid($guestbookid);	
		showsubmenu($menustr);
		showtableheader('', 'nobottom');
		showtablerow('', array(), array(shownavmenu(0, array(1, 2), $langs)));
		showtablefooter();
					 
		showtableheader($langs['temp_viewguestbook'], 'nobottom');
		$result['username'] = empty($result['username']) ? $langs['guestuser']: $result['username'];
        
		$dateline = $result[dateline] ? dgmdate($result[dateline]):'';
		$br = C::t('#sanree_brand#sanree_brand_businesses')->getusername_by_bid($result['bid']);
		$result['brandname'] = $br['name'];
		showtablerow('','',array($langs['bguestbookid'].$result['guestbookid']));
	    showtablerow('','',array($langs['busername'].$result['username']));
	    showtablerow('','',array($langs['bbrandname'].$result['brandname']));
        showtablerow('','',array($langs['bdateline'].$dateline));
		showtablerow('','',array($langs['bname'].$result['title']));
		showtablerow('','',array($langs['fullnameshow'].$result['fullname']));
		showtablerow('','',array($langs['baddress'].$result['address']));
		showtablerow('','',array($langs['bphone'].$result['phone']));
		showtablerow('','',array($langs['bemail'].$result['email']));
		showtablerow('','',array($langs['bqq'].$result['qq']));
		?>
		<tr><td colspan="2"><?php echo $langs['bwords'];?></td></tr>				
		<tr><td colspan="2"><p><div style="word-break:break-all;border:1px dashed #00f; padding:10px; background-color:#CCCCCC">
		<?php echo $result['words'];?>
		</div></p></td></tr>
		<tr><td colspan="2"><?php echo $langs['refuserefuse'];?></td></tr>				
		<tr><td colspan="2"><p><div style="word-break:break-all; border:1px dashed #00f; padding:10px; background-color:#CCCCCC">
		<?php echo $result['refuse'];?>
		</div></p></td></tr>		
		<?php
		$opdate = $result[opdate] ? dgmdate($result[opdate]):'';
		showtablerow('','',array($langs['bopdate'].$opdate));
		showtablefooter();
		echo '<input onclick="javascript:history.back()" class="btn" type="button" value="'.$langs['back'].'">';
		
	}	
		
} elseif  ($do == 'upgrading') {

		$guestbookid = intval($_G['sr_guestbookid']);
		if(submitcheck('addsubmit')){

	    $setarr = array();
	    $fullname = dhtmlspecialchars(trim($_G['sr_fullname']));
		if (empty($fullname)) {
			cpmsg_error($langs['error_fullnametip']);
		}
		$address = dhtmlspecialchars(trim($_G['sr_address']));
		if (empty($address)) {
			cpmsg_error($langs['error_addresstip']);
		}
		$phone = dhtmlspecialchars(trim($_G['sr_phone']));
		if (empty($phone)) {
			cpmsg_error($langs['error_phonetip']);
		}
				
	    $words = dhtmlspecialchars(trim($_G['sr_words']));
		if (empty($words)) {
			cpmsg_error($langs['error_wordstip']);
		}	
	    $title = dhtmlspecialchars(trim($_G['sr_title']));
		if (empty($title)) {
			cpmsg_error($langs['error_titletip']);
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
		$setarr['uid'] = $_G[uid];
		$setarr['username'] = $_G[username];
		$setarr['title'] = $title;
		$setarr['words'] = $words;
		$setarr['fullname'] = $fullname;
		$setarr['address'] = $address;
		$setarr['phone'] = $phone;
		$setarr['email'] = dhtmlspecialchars(trim($_G['sr_email']));
		$setarr['qq'] = dhtmlspecialchars(trim($_G['sr_qq']));
		$setarr['displayorder'] = intval(trim($_G['sr_displayorder']));
		$setarr['memo'] = dhtmlspecialchars(trim($_G['sr_memo']));

		if ($guestbookid>0) {
			C::t('#sanree_brand_guestbook#sanree_brand_guestbook')->update($guestbookid, $setarr);
		}
		else {
		    $setarr['dateline'] = TIMESTAMP;
			$setarr['ip'] = $_G['clientip'];
			$setarr['status'] = 0;
			$guestbookid = $guestbookid = C::t('#sanree_brand_guestbook#sanree_brand_guestbook')->insert($setarr, TRUE);
			guestbook_notice($guestbookid, 'reservation');		
		}
		cpmsg($langs['succeed'],'action=plugins&operation=config&act=guestbook&identifier=sanree_brand_guestbook&pmod=admincp&page='.$page, 'succeed');				
	} else {
	
	    showsubmenu($menustr);
		showtableheader('', 'nobottom');
		showtablerow('', array(), array(shownavmenu(0, array(0,1), $langs)));
		showtablefooter();
		if($guestbookid>0) {
		    $menustr = $langs['editbusi'];
		    $result = C::t('#sanree_brand_guestbook#sanree_brand_guestbook')->fetch_first_by_guestbookid($guestbookid);	
			$br = C::t('#sanree_brand#sanree_brand_businesses')->getusername_by_bid($result['bid']);
			$result['brandname'] = $br['name'];
        } else {	
		    $menustr = $langs['addbusi'];
			$result['status'] = 0;
			$result['displayorder'] = 0;
			$result['email'] = $_G['setting'][adminemail];
		}
		?>
		<div id="domfx"></div>
		<script language="javascript">
		disallowfloat = 'newthread';
		function showselbrand() {
		    var spage = $('spage').value;
			var url = '<?php echo ADMINSCRIPT?>?action=plugins&operation=config&act=guestbook&identifier=sanree_brand_guestbook&pmod=admincp&do=ajax&page='+spage;
			showWindow('selbrand',url);
			return false;
		}
		</script>
		<?php	
		$result['weburl'] = str_replace("http://", '', $result['weburl']);	
		showformheader($thisurl."&do=".$do."&guestbookid=".$guestbookid."&page=".$page, 'enctype');
		showtableheader($menustr, 'nobottom');	
		showsetting($langs['brandname'], 'brandname', $result['brandname'], 'text','','','<button id="selbrand" onclick="showselbrand();">'.$langs['selectbrand'].'</button>&nbsp;&nbsp;Page:<input type="text" name="spage" size=2 id="spage" />', ' id="brandname" ');	
		showsetting($langs['guestbooktitle'], 'title', $result['title'], 'text','','',$langs['bitian']);
		showsetting($langs['fullname'], 'fullname', $result['fullname'], 'text','','',$langs['bitian']);
		showsetting($langs['address'], 'address', $result['address'], 'text','','',$langs['bitian']);
		showsetting($langs['phone'], 'phone', $result['phone'], 'text','','',$langs['bitian']);
		showsetting($langs['email'], 'email', $result['email'], 'text');
		showsetting($langs['qq'], 'qq', $result['qq'], 'text');
		showsetting($langs['words'], 'words', $result['words'], 'textarea');
		showsetting($langs['displayorder'], 'displayorder', $result['displayorder'], 'text');
		$result['dateline'] && showsetting($langs['dateline'], 'dateline', dgmdate($result[dateline]), 'text','1');
		showsetting($langs['memo'], 'memo', $result['memo'], 'textarea');
		showsubmit('addsubmit');
		showtablefooter();
		showformfooter();
			
	}

} elseif  ($do == 'list') {

	if(submitcheck('submit')){
		 
		if($_G['sr_delete']) {
		
			C::t('#sanree_brand_guestbook#sanree_brand_guestbook')->delete($_G['sr_delete']);
			
		}		
		cpmsg($langs['succeed'], "action=plugins&operation=config&act=".$act."&identifier=sanree_brand_guestbook&pmod=admincp&cateid=".$cateid.'&page='.$page, 'succeed');
		
	 } else {
	 
		$skeyword = $_G['sr_skeyword'];
		showsubmenu($menustr);	
		$type =  intval($_G['sr_type']);
		!in_array($type, array(1, 2)) && $type = 0;
		showtableheader('', 'nobottom');
		$typeclass= array(0,1);
		showtablerow('', array(), array(shownavmenu($type, $typeclass, $langs)));
		showtablefooter();
		showformheader($thisurl);
		showtableheader($langs['searchbar'], '', 'style="border:1px solid #F0F7FD"');
		showtablerow('', '', $langs['skeyword'].'<input type="text" name="skeyword" value="'.$skeyword.'" class="txt" style="width:200px;" /> <input type="submit" value="'.$langs['search'].'" class="btn" name="searchsubmit"/>');
		showtablefooter();
		showformfooter();
		showformheader($thisurl.'&page='.$page);
		showtableheader($langs['guestbook'], 'nobottom');
		showsubtitle(array('',$langs['temp_guestname'],$langs['guestbooktitle'],$langs['temp_viewbrandname'],$langs['operationuser'],$langs['status'],'time', 'operation'));
		$perpage = 10;
		$resultempty = true;
		$orderby = $searchtext = $extra = $srchuid = '';
		$orderby = 'gb.displayorder,gb.guestbookid desc';	
		$searchtext = ' AND gb.status=0 ';	
		if ($type==1) $searchtext = ' AND gb.status=1 ';
		if ($type==2) {
		
			$searchtext = ' AND gb.isdelete=-1';
			$resultempty=false;
			
		}
		$extra = '&type='.$type;
		if(!empty($skeyword)){
		
			$searchfield = array('b.name','gb.guestbookid','gb.qq', 'gb.title', 'gb.words', 'gb.refuse', 'gb.fullname', 'gb.address', 'gb.phone', 'gb.email', 'gb.ip');
			$search = array();
			foreach($searchfield as $v) {
			
				$search[] = "(".$v." LIKE '%".$skeyword."%')";
				
			}
			$searchtext .= " AND (".implode(' OR ',$search).")";
			$extra = '&skeyword='.urlencode($skeyword);
		}	
		$count = C::t('#sanree_brand_guestbook#sanree_brand_guestbook')->count_by_wherec($searchtext,$resultempty);
		$multipage=multi($count, $perpage, $page, ADMINSCRIPT."?action=plugins&operation=config&act=$act&identifier=sanree_brand_guestbook&pmod=admincp$extra");
		$datalist = C::t('#sanree_brand_guestbook#sanree_brand_guestbook')->fetch_all_by_searchc($searchtext,$orderby,(($page - 1) * $perpage),$perpage,$resultempty);
		foreach($datalist as $row) {

			$statusstr = $row[status]==1 ? $langs['yes']:$langs['no'];
			$row[cpusername] = C::t('#sanree_brand#xcommon_member')->fetch_all_username_by_uid($row[cpuid]);
			showtablerow('', array(' width=50 ',' width=60 ','',' width=180 ',' width=50',' width=30',' width=120',' width=30'), array(
			"<input class=\"checkbox\" type=\"checkbox\" name=\"delete[$row[guestbookid]]\" value=\"$row[guestbookid]\">" ,
			!empty($row[username]) ? '<a href="home.php?mod=space&amp;uid='.$row[uid].'" target=_blank>'.$row[username].'</a>' : $langs['guestuser'],
			$row[title],
			'<a href="plugin.php?id=sanree_brand&mod=item&tid='.$row[bid].'" target=_blank>'.$row[brandname].'</a>',
			!empty($row[cpusername]) ? '<a href="home.php?mod=space&amp;uid='.$row[cpuid].'" target=_blank>'.$row[cpusername].'</a>' : '',
			$statusstr,
			dgmdate($row[dateline]),
			'<a href="###" onclick="location.href=\''.ADMINSCRIPT.'?action=plugins&operation=config&act=guestbook&identifier=sanree_brand_guestbook&pmod=admincp&do=audit&control=pass&guestbookid='.$row['guestbookid']."&page=".$page.'\'">'.$langs['chuli'].'</a>',
			'<a href="###" onclick="location.href=\''.ADMINSCRIPT.'?action=plugins&operation=config&act=guestbook&identifier=sanree_brand_guestbook&pmod=admincp&do=view&guestbookid='.$row['guestbookid']."&page=".$page.'\'">'.$lang['view'].'</a>',
			));
			
		}
		showsubmit('submit', 'submit', 'del', "", $multipage);
		showtablefooter();
		showformfooter();
		
	}
}

function shownavmenu($type, $typeclass, $langs) {

	$result ='<ul class="tab1">';
	$typelist = array();
	$typelist[$type] = ' class="current"';
    foreach($typeclass as $key => $value) {
	
	    if ($key>0) {
		
			$searchtext= ' AND status<>1 AND typeid='.($key-1);
			
		} else {
		
			$searchtext= ' AND status<>1';
		
		}
		$color = '';
		if ($key==0) {
			$ncount = C::t('#sanree_brand_guestbook#sanree_brand_guestbook')->count_by_where(' AND status<>1');
			$color = 'red';
		} elseif($key==1) {
			$ncount = C::t('#sanree_brand_guestbook#sanree_brand_guestbook')->count_by_where(' AND status<>0');
		} elseif($key==2) {
			$ncount = C::t('#sanree_brand_guestbook#sanree_brand_guestbook')->count_by_where(' AND isdelete =-1',false);
		}
		
		$result .='<li'.$typelist[$key].'><a href="'.ADMINSCRIPT.'?action=plugins&operation=config&act=guestbook&identifier=sanree_brand_guestbook&pmod=admincp&type='.$key.'"><span>'.$langs['typeinfo'.$key].'(<font color="'.$color.'">'.$ncount.'</font>)</span></a></li>';
		
	}
	$result.= '</ul>';
	return $result;
	
}
//From:www_YMG6_COM
?>