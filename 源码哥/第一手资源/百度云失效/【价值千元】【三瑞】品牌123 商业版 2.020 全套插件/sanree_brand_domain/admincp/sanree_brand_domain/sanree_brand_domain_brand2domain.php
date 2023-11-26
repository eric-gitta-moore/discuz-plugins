<?php

/**
 *      [Sanree] (C)2012-2099 Sanree Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: sanree_brand_domain_brand2domain.php $
 */

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}

$do = isset($_G['sr_do']) ? $_G['sr_do'] : '';
$doarray = array('list', 'upgrading', 'ajax', 'ajaxdomain');
$do = !in_array($do, $doarray) ? 'list' : $do;
$page = isset($_G['sr_page']) ? $_G['sr_page'] : 0;
$page = max(1, intval($page));

if ($do == 'ajax') {
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
		$searchtext = ' AND status=1';	
		$duid = isset($_G['sr_duid']) ? $_G['sr_duid'] : '';
		if ($duid>0) {
			$searchtext.= ' AND uid = '. $duid;
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
		$extra .= '&do=ajax';	
		$count = C::t('#sanree_brand#sanree_brand_businesses')->count_by_where($searchtext);
		$multipage=multi($count, $perpage, $page, ADMINSCRIPT."?action=plugins&operation=config&act=$act&identifier=sanree_brand_domain&pmod=admincp$extra");
		foreach(C::t('#sanree_brand#sanree_brand_businesses')->fetch_all_by_search($searchtext,$orderby,(($page - 1) * $perpage),$perpage) as $row) {

			showtablerow('class="hover" style="cursor:pointer" onclick="setbrand(\''.$row[name].'\')"', array(), array($row[name]));
			
		}
		showsubmit('','',$multipage);		
		showtablefooter();
		
		include template('common/footer');
} 
elseif ($do == 'ajaxdomain') {
		include template('common/header');
		echo '<h3 class="flb mn"><span><a href="javascript:;" class="flbc" onclick="MyhideWindow();" title="'.$lang['close'].'">'.$lang['close'].'</a></span>'.$langs['selectdomain'].'</h3>';
		$category = C::t('#sanree_brand#sanree_brand_category')->fetch_all_category();
		$cates = array();
		foreach($category as $v) {
		
			$cates[$v['cateid']] = $v;
			
		}
		$skeyword = $_G['sr_skeyword'];
		?>
		<script language="javascript" reload="1">
		function MyhideWindow() {
			hideWindow('seldomain',1,0);
			$('domfx').innerHTML = '<style type="text/css">object{visibility:visible;}</style>';
		}
		  function fixa(){
			  var objs = $('fwin_content_seldomain').getElementsByTagName('a');
			  for(var i = 0; i < objs.length; i++) {
				  objs[i].setAttribute('fwin', 'seldomain');
				  objs[i].setAttribute('id', 'seldomain'+i);
				  if (objs[i].href.indexOf('page')>0) {
					  var u = objs[i].href;
					  objs[i].setAttribute('href', '###');
					  _attachEvent(objs[i], 'click', function (){
					  showWindow('seldomain',u);});
				  }
			  }
		  }
		</script>
		<?php
	
		$anchor = isset($_GET['anchor']) ? dhtmlspecialchars($_GET['anchor']) : '';
		echo '<script language="javascript">function setdomain(name,nuid){$("dspage").value="'.$page.'";$("domainname").value=name;thisuid=nuid;MyhideWindow();}function chkadd() {ajaxpost(\'cpform\', \'fwin_content_seldomain\', \'fwin_content_seldomain\',\'\',\'\',function(){fixa();});return false;}</script>';
  	    echo '<form name="cpform" onsubmit="return chkadd();" method="POST" autocomplete="off" action="'.ADMINSCRIPT.'?action='.$thisurl1.'&do=ajaxdomain&ajaxtarget=fwin_content_seldomain&inajax=1" id="cpform">'.
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
		$orderby = 'd.domainid desc';	
		$searchtext = ' AND d.status=1 AND b.id is NULL';	

		if(!empty($skeyword)){
		
			$searchfield = array('d.domainname');
			$search = array();
			foreach($searchfield as $v) {
			
				$search[] = "(".$v." LIKE '%".$skeyword."%')";
				
			}
			$searchtext .= " AND (".implode(' OR ',$search).")";
			$extra = '&skeyword='.urlencode($skeyword);
		}	
		$extra .= '&do=ajaxdomain';	
		$count = C::t('#sanree_brand_domain#sanree_brand_domain')->count_by_whered($searchtext);
		$multipage=multi($count, $perpage, $page, ADMINSCRIPT."?action=plugins&operation=config&act=$act&identifier=sanree_brand_domain&pmod=admincp$extra");
		foreach(C::t('#sanree_brand_domain#sanree_brand_domain')->fetch_all_by_searchd($searchtext,$orderby,(($page - 1) * $perpage),$perpage)as $row) {

			showtablerow('class="hover" style="cursor:pointer" onclick="setdomain(\''.$row['domainname'].'\','.$row['uid'].')"', array(), array($row[domainname].$okdomain));
			
		}
		showsubmit('','',$multipage);		
		showtablefooter();
		
		include template('common/footer');
}
elseif ($do == 'upgrading') {
    $id = intval($_G['sr_id']);
	if(submitcheck('addsubmit')){

	    $setarr = array();
		$domainname = dhtmlspecialchars(trim($_G['sr_domainname']));
		if (empty($domainname)) {
			cpmsg_error($langs['error_domaintitle']);
		}	
		$domain = C::t('#sanree_brand_domain#sanree_brand_domain')->fetch_by_domainname($domainname);	
		if (!$domain) {
		
			cpmsg_error($langs['error_domainid']);
			
		}	
		$brandname = dhtmlspecialchars(trim($_G['sr_brandname']));
		if (empty($brandname)) {
			cpmsg_error($langs['error_brandnametip']);
		}	
		
		$brand = C::t('#sanree_brand#sanree_brand_businesses')->fetch_by_brandname($brandname);	
		if (!$brand) {
		
			cpmsg_error($langs['error_bid']);
			
		}	
		if ($brand['uid'] != $domain['uid']) {
		
			cpmsg_error($langs['error_useruid']);
			
		}
		$setarr['bid'] = $brand['bid'];
		$setarr['uid'] = $brand['uid'];
		$setarr['username'] = $domain['username'];
		$setarr['domainid'] = $domain['domainid'];
		$setarr['status'] = intval(trim($_G['sr_status']));
		$setarr['isshow'] = intval(trim($_G['sr_isshow']));
		$setarr['memo'] =  dhtmlspecialchars(trim($_G['sr_memo']));			
		if ($id) {
            $result = C::t('#sanree_brand_domain#sanree_brand_domain_brand2domain')->get_by_id($id);
			if ($result['domainid'] == $domain['domainid']) {
				C::t('#sanree_brand_domain#sanree_brand_domain_brand2domain')->update($id, $setarr);
			}
			
		} else {
			$domain=C::t('#sanree_brand_domain#sanree_brand_domain_brand2domain')->get_by_domainid($domain['domainid']);
			if ($domain) {
 
				cpmsg_error($langs['error_bdomain_have']);			
					
			}
			$setarr['adminuid'] =  $_G['uid'];
		    $setarr['dateline'] = TIMESTAMP;			
			$id = C::t('#sanree_brand_domain#sanree_brand_domain_brand2domain')->insert($setarr, TRUE);

		}	
		makedomain($id);
		cpmsg($langs['succeed'], $gotourl.'brand2domain&page='.$page, 'succeed');		
			
	}
	else {
	    showsubmenu($menustr);	
	
		if($id>0) {
		
		    $menustr = $langs['editbrand2domain'];
		    $result = C::t('#sanree_brand_domain#sanree_brand_domain_brand2domain')->get_by_id($id);
			$br = C::t('#sanree_brand#sanree_brand_businesses')->getusername_by_bid($result['bid']);
			$result['brandname'] = $br['name'];		
			$domain = C::t('#sanree_brand_domain#sanree_brand_domain')->get_by_domainid($result['domainid']);
			$result['domainname'] = $domain['domainname'];		
			$edit = true;
		
        } else {	
		    $menustr = $langs['addbrand2domain'];
			$result['status'] = 1;
			$result['isshow'] = 1;	
			$edit = false;
		}	
		?>
		<div id="domfx"></div>
		<script language="javascript">
		disallowfloat = 'newthread';
		var thisuid = <?php echo intval($result['uid'])?>;
		function showselbrand() {
			if (thisuid<1) {
				alert('<?php echo $langs['pselectdomain']?>');
				return false;
			}
		    var spage = $('spage').value;
			var url = '<?php echo ADMINSCRIPT?>?action=plugins&operation=config&act=brand2domain&identifier=sanree_brand_domain&pmod=admincp&do=ajax&page='+spage+'&duid='+thisuid;
			showWindow('selbrand',url);
			return false;
		}
		function showseldomain() {
		    var dspage = $('dspage').value;
			var url = '<?php echo ADMINSCRIPT?>?action=plugins&operation=config&act=brand2domain&identifier=sanree_brand_domain&pmod=admincp&do=ajaxdomain&page='+dspage;
			showWindow('seldomain',url);
			return false;
		}		
		</script>
		<?php			
		$lststr1 = $edit ? '' : '<button id="seldomain" onclick="showseldomain();">'.$langs['selectdomain'].'</button>&nbsp;&nbsp;Page:<input type="text" name="dspage" size=2 id="dspage" />';
		$lststr2 = $edit ? ' id="domainname" readonly ' : '';
		showformheader($thisurl1."&do=".$do."&id=".$id."&page=".$page, 'enctype');
		showtableheader($menustr, 'nobottom');
		showsetting($langs['domainname'], 'domainname', $result['domainname'], 'text','','', $lststr1, $lststr2);			
		showsetting($langs['brandname'], 'brandname', $result['brandname'], 'text','','','<button id="selbrand" onclick="showselbrand();">'.$langs['selectbrand'].'</button>&nbsp;&nbsp;Page:<input type="text" name="spage" size=2 id="spage" />', ' id="brandname" ');		
		showsetting($langs['status'], 'status', $result['status'], 'radio');
		showsetting($langs['isshow'], 'isshow', $result['isshow'], 'radio');
		$result['dateline'] && showsetting($langs['dateline'], 'dateline', dgmdate($result['dateline']), 'text','1');
		showsetting($langs['memo'], 'memo', $result['memo'], 'textarea');			
		showsubmit('addsubmit');
		showtablefooter();
		showformfooter();
	}
} elseif ($do == 'list') {

	if(submitcheck('submit')){

		if(is_array($_G['sr_group_domainname'])) {
			foreach($_G['sr_group_domainname'] as $id => $value) {
			
			    if(!$_G['sr_delete'][$id]) {
				
					$setarr = array(
						'status' => intval($_G['sr_domain_status'][$id]),
						'isshow' => intval($_G['sr_domain_isshow'][$id])
					);
					C::t('#sanree_brand_domain#sanree_brand_domain_brand2domain')->update($id, $setarr);
					makedomain($id);
					
				}
			}
		}
		if($_G['sr_delete']) {

			C::t('#sanree_brand_domain#sanree_brand_domain_brand2domain')->delete($_G['sr_delete']);
			
		}	
		cpmsg($langs['succeed'], $gotourl.'brand2domain&page='.$page, 'succeed');	
		
	} else {	
		showsubmenu($menustr);

		$skeyword =  isset($_G['sr_skeyword']) ? $_G['sr_skeyword'] : '';
		showformheader($thisurl1);
		showtableheader($langs['searchbar'], '', 'style="border:1px solid #F0F7FD"');
		showtablerow('', '', $langs['skeyword'].'<input type="text" name="skeyword" value="'.$skeyword.'" class="txt" style="width:200px;" /> <input type="submit" value="'.$langs['search'].'" class="btn" name="searchsubmit"/>');
		showtablefooter();
		showformfooter();
						
		showformheader($thisurl1.'&page='.$page);
		showtableheader($langs['domain'], 'nobottom');
		showsubtitle(array('',$langs['domainname'], $langs['brandname'], $langs['user'], $langs['status'], $langs['isshow'], 'time', 'operation'));
		$perpage = 10;
		$srchadd = $searchtext = $extra = $srchuid = '';
		$orderby = 'a.isshow desc, a.status, a.id desc';

		if(!empty($skeyword)){
		
			$searchfield = array('d.domainname','b.name', 'a.uid', 'a.username');
			$search = array();
			foreach($searchfield as $v) {
			
				$search[] = "(".$v." LIKE '%".$skeyword."%')";
				
			}
			$searchtext .= " AND (".implode(' OR ',$search).")";
			$extra = '&skeyword='.urlencode($skeyword);
		}
				
		$count = C::t('#sanree_brand_domain#sanree_brand_domain_brand2domain')->count_by_whered($searchtext);
		$multipage=multi($count, $perpage, $page, ADMINSCRIPT."?action=plugins&operation=config&act=$act&identifier=sanree_brand_domain&pmod=admincp$extra");	
		$datalist = C::t('#sanree_brand_domain#sanree_brand_domain_brand2domain')->fetch_all_by_searchd($searchtext,$orderby,(($page - 1) * $perpage),$perpage);

		foreach($datalist as $value) {

            $statusstr = $value['status']==1 ? ' checked="checked"':'';
			$isshowstr = $value['isshow']==1 ? ' checked="checked"':'';
			$domain  = $value['domainname'].$okdomain;	
			$nurl = 'plugin.php?id=sanree_brand&mod=item&tid='.$value['bid'];		
			showtablerow('', array('class="td25"', '','', 'class="td28"'), array(
				"<input class=\"checkbox\" type=\"checkbox\" name=\"delete[$value[id]]\" value=\"$value[id]\">".
				"<input type=\"hidden\"  size=\"12\" name=\"group_domainname[$value[id]]\" value=\"$value[domainname]\" $statusstr>",
				$value['brandname']&&$value['bid'] ? '<a target="_blank" href="http://'.$domain.'">'.$domain.'</a>' : $domain,
				$value['brandname']&&$value['bid'] ? '<a target="_blank" href="'.$nurl.'">'.$value['brandname'].'</a>' : '',
				'<a target="_blank" href="home.php?mod=space&amp;uid='.$value["uid"].'">'.$value['username'].'</a>',				
				"<input type=\"checkbox\"  size=\"12\" name=\"domain_status[$value[id]]\" value=\"1\" $statusstr>",	
				"<input type=\"checkbox\"  size=\"12\" name=\"domain_isshow[$value[id]]\" value=\"1\" $isshowstr>",				
				$value['dateline'] ? dgmdate($value['dateline']):'',
				'<a href="###" onclick="location.href=\''.ADMINSCRIPT.'?action=plugins&operation=config&act=brand2domain&identifier=sanree_brand_domain&pmod=admincp&do=upgrading&id='.$value['id']."&page=".$page.'\'">'.$lang['edit'].'</a>'
			));
			
		}
		echo '<tr><td>&nbsp;</td><td colspan="7"><div><a href="###" onclick="location.href=\''.ADMINSCRIPT.'?action=plugins&operation=config&act=brand2domain&identifier=sanree_brand_domain&pmod=admincp&do=upgrading\'" class="addtr">'.$langs['addbrand'].'</a></div></td></tr>';				
		showsubmit('submit', 'submit', 'del', '', $multipage, false);
		showtablefooter();
		showformfooter();
	}	
}
//From:www_YMG6_COM
?>