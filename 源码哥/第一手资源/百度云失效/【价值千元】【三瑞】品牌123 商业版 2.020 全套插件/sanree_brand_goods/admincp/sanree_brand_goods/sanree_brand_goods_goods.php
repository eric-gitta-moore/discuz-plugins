<?php

/**
 *      [fx8.cc] (C)2014-2017 ymg6.Com.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: sanree_brand_goods_goods.php sanree $
 */
if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('2014072523P9ep9MXpl9||6873||1413856801');
}
$do= isset($_G['sr_do']) ? $_G['sr_do'] : 'list';
$page = isset($_G['sr_page']) ? intval($_G['sr_page']) : 1;
$page = max(1, $page);
if(!in_array($do, array('list', 'upgrading', 'businessesaudit', 'ajax'))) {
	$do = 'list';
}
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
		$multipage=multi($count, $perpage, $page, ADMINSCRIPT."?action=plugins&operation=config&act=$act&identifier=sanree_brand_goods&pmod=admincp$extra");
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
	    $gid = intval($_G['sr_gid']);
	    if (submitcheck('refuse')) {
		    C::t('#sanree_brand_goods#sanree_brand_goods')->update($gid , array('reason' => dhtmlspecialchars(trim($_G['sr_reason'])), 'status' => -1));
			goods_notice($gid,'goods_refuse');
			cpmsg($langs['succeed'], "action=plugins&operation=config&act=".$act."&do=businessesaudit&identifier=sanree_brand_goods&pmod=admincp&page=".$page, 'succeed');	
		}
		else {
			if($gid>0) {
				$result = C::t('#sanree_brand_goods#sanree_brand_goods')->getusername_by_gid($gid);	
				showsubmenu($menustr);	 
				showformheader($thisurl."&do=".$do."&gid=".$gid."&page=".$page.'&control='.$control, 'enctype');
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
		if($gid = intval($_G['sr_gid'])) {
			C::t('#sanree_brand_goods#sanree_brand_goods')->update($gid , array('isshow' => 1, 'status' => 1));
			goods_fixthread($gid);
			goods_notice($gid,'goods_adminpass');
			attention_information($gid, 'goods');
		}
		cpmsg($langs['succeed'], "action=plugins&operation=config&act=".$act."&do=businessesaudit&identifier=sanree_brand_goods&pmod=admincp&page=".$page, 'succeed');	
	}
	elseif(submitcheck('batch')) {
		if($ids = dimplode($_G['sr_delete'])) {
			C::t('#sanree_brand_goods#sanree_brand_goods')->update($_G['sr_delete'], array('isshow' => 1, 'status' => 1));
			goods_fixthread($_G['sr_delete']);
			goods_notice($_G['sr_delete'],'goods_pass');
			attention_information($_G['sr_delete'], 'goods');
		}
		cpmsg($langs['succeed'], "action=plugins&operation=config&act=".$act."&do=businessesaudit&identifier=sanree_brand_goods&pmod=admincp&page=".$page, 'succeed');
	}
	elseif(submitcheck('submit')){ 
		if($_G['sr_delete']) {
		    $tids = array();
		    foreach (C::t('#sanree_brand_goods#sanree_brand_goods')->fetch_all_tid_by_gids($_G['sr_delete']) as $val) {
				$tids[] = $val[tid];
			}
			require_once libfile('function/delete');
            deletethread($tids);		
			C::t('#sanree_brand_goods#sanree_brand_goods')->delete($_G['sr_delete']);
		}		
		cpmsg($langs['succeed'], "action=plugins&operation=config&act=".$act."&do=businessesaudit&identifier=sanree_brand_goods&pmod=admincp&cateid=".$cateid.'&page='.$page, 'succeed');
	 }
	 else
	 {
		$category = C::t('#sanree_brand_goods#sanree_brand_goods_category')->fetch_all_category();
		$cates = array();
		foreach($category as $v) {
			$cates[$v[cateid]] = $v;
		}
		$skeyword = $_G['sr_skeyword'];
		
		showsubmenu($menustr);	 
		showformheader('plugins&operation=config&identifier=sanree_brand_goods&pmod=admincp&act=goods&do=businessesaudit');
		showtableheader($langs['searchbar'], '', 'style="border:1px solid #F0F7FD"');
		showtablerow('', '', $langs['skeyword'].'<input type="text" name="skeyword" value="'.$skeyword.'" class="txt" style="width:200px;" /> <input type="submit" value="'.$langs['search'].'" class="btn" name="searchsubmit"/>');
		showtablefooter();
		showformfooter();
		
		showformheader('plugins&operation=config&act='.$act.'&do=businessesaudit&identifier=sanree_brand_goods&pmod=admincp&page='.$page);
		showtableheader($langs['unauditbusinesses'], 'nobottom');
		showsubtitle(array('',$langs['showorder'],$langs['catename'], $lang['name'], $langs['istop'], $langs['isshow'],$langs['status'], $langs['reason'],'time', 'operation'));
		$perpage = 10;
		$resultempty = FALSE;
		$orderby = $searchtext = $extra = $srchuid = '';
		$orderby = "displayorder,istop desc, dateline desc, status";
		$searchtext = ' AND status<>1 ';
		if(!empty($skeyword)){
		
			$searchfield = array('name', 'goodsno', 'keywords', 'description', 'smallpic',
			 'memo','bigpic', 'ip' , 'price', 'minprice' , 'maxprice' , 'reserveprice',
			 'introduction' ,'content' , 'reason');
			$search = array();
			foreach($searchfield as $v) {
			
				$search[] = "(".$v." LIKE '%".$skeyword."%')";
				
			}
			$searchtext .= " AND (".implode(' OR ',$search).")";
			$extra = '&skeyword='.urlencode($skeyword);
		}
		$count = C::t('#sanree_brand_goods#sanree_brand_goods')->count_by_where($searchtext);
		$multipage=multi($count, $perpage, $page, ADMINSCRIPT."?action=plugins&operation=config&act=$act&identifier=sanree_brand_goods&pmod=admincp$extra");
		$datalist = C::t('#sanree_brand_goods#sanree_brand_goods')->fetch_all_by_search($searchtext,$orderby,(($page - 1) * $perpage),$perpage);
		foreach($datalist as $row) {
			$istopstr = $row[istop]==1 ?  $langs['yes']:$langs['no'];
			$statusstr = $row[status]==1 ? $langs['yes']:$langs['no'];
			$isshowstr = $row[isshow]==1 ? $langs['yes']:$langs['no'];
			showtablerow('', array('', 'class="td25"','','class="td26"'), array(
			"<input class=\"checkbox\" type=\"checkbox\" name=\"delete[$row[gid]]\" value=\"$row[gid]\">" ,
			$row[displayorder],
			$cates[$row[cateid]]["name"],
			$row[name],
			$istopstr,
			$isshowstr,
			$statusstr,
			'<div style="width:50px;overflow:hidden; height:40px;" title="'.$row[reason].'">'.$row[reason].'</div>',
			dgmdate($row[dateline]),
			'<a href="###" onclick="location.href=\''.ADMINSCRIPT.'?action=plugins&operation=config&act=goods&identifier=sanree_brand_goods&pmod=admincp&do=upgrading&gid='.$row['gid']."&page=".$page.'\'">'.$lang['edit'].'</a>',
			'<a href="###" onclick="location.href=\''.ADMINSCRIPT.'?action=plugins&operation=config&act=goods&identifier=sanree_brand_goods&pmod=admincp&do=businessesaudit&control=pass&gid='.$row['gid']."&page=".$page.'\'">'.$langs['pass'].'</a>',
			'<a href="###" onclick="location.href=\''.ADMINSCRIPT.'?action=plugins&operation=config&act=goods&identifier=sanree_brand_goods&pmod=admincp&do=businessesaudit&control=refuse&gid='.$row['gid']."&page=".$page.'\'">'.$langs['refuse'].'</a>',
			));
			
		}
		showsubmit('batch', $langs['batchshen'], '<INPUT class=checkbox onclick="checkAll(\'prefix\', this.form, \'delete\')" type=checkbox name=chkall><LABEL for=chkall>'.$langs['delorhen'].'</LABEL>', "<input class=\"checkbox\" type=\"hidden\" name=\"cateid\" value=\"$cateid\"><input type=\"submit\" id=\"del_submit\" class=\"btn\" onclick=\"return(confirm('".$langs['confirmationdel']."'))\" name=\"submit\" value=\"".$langs['batchdel']."\">", $multipage);		showtablefooter();
		showformfooter();
	}

} elseif  ($do == 'upgrading') {

		$gid = isset($_G['sr_gid']) ? intval($_G['sr_gid']) : 0;
		if(submitcheck('addsubmit')){
		$aid = array();
		$ishome = intval($_G['sr_ishome']);

		foreach($_G['sr_attachnew'] as $key => $value) {
		
		    if ($value['isimage'] ==1) {
			
				$aid[] = $key;
				
			}
				
		}
		if (count($aid)<1) {
			cpmsg_error(goods_modlang('inputpicture'));	
		}	
		if ($ishome<1) {
			$ishome = $aid[0];
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
		$price = dhtmlspecialchars(trim($_G['sr_price']));
		if (empty($price)) {
		
			cpmsg_error($langs['inputprice']);
			
		}	
		$minprice = dhtmlspecialchars(trim($_G['sr_minprice']));
		if (empty($minprice)) {
		
			cpmsg_error($langs['inputminprice']);
			
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
		///$setarr['introduction'] = dhtmlspecialchars(trim($_G['sr_introduction']));
		$setarr['priceunit'] = intval(trim($_G['sr_priceunit']));
		$setarr['price'] = sprintf("%.2f", dhtmlspecialchars(trim($_G['sr_price'])));;
		$setarr['minprice'] = sprintf("%.2f", dhtmlspecialchars(trim($_G['sr_minprice'])));
		///$setarr['maxprice'] = sprintf("%.2f", dhtmlspecialchars(trim($_G['sr_maxprice'])));
		///$setarr['reserveprice'] = sprintf("%.4f", dhtmlspecialchars(trim($_G['sr_reserveprice'])));
		///$setarr['stock'] = intval(trim($_G['sr_stock']));
		///$setarr['grade'] = intval(trim($_G['sr_grade']));
		///$setarr['sales'] = intval(trim($_G['sr_sales']));
		///$setarr['attribute'] = dhtmlspecialchars(trim($_G['sr_attribute']));
		$setarr['istop'] = intval(trim($_G['sr_istop']));
		$setarr['isrecommend'] = intval(trim($_G['sr_isrecommend']));
		$setarr['displayorder'] = intval(trim($_G['sr_displayorder']));
		$setarr['ishot'] = intval(trim($_G['sr_ishot']));
		$setarr['memo'] = dhtmlspecialchars(trim($_G['sr_memo']));
		$setarr['allowreply'] = intval(trim($_G['sr_allowreply']));	
		$setarr['isshow'] = intval(trim($_G['sr_isshow']));	
		$setarr['unit'] = dhtmlspecialchars(trim($_G['sr_unit']));
		$setarr['buylink'] = dhtmlspecialchars(trim($_G['sr_buylink']));
		///$setarr['startdate'] = !empty($_G['sr_startdate']) ? strtotime($_G['sr_startdate']) : 0;
		///$setarr['enddate'] = !empty($_G['sr_enddate']) ? strtotime($_G['sr_enddate']) : 0;	
		$goodsno = dhtmlspecialchars(trim($_G['sr_goodsno']));
		if (!empty($goodsno)) {
		    if ($gid<1) {
				$count=C::t('#sanree_brand_goods#sanree_brand_goods')->count_by_where(" AND goodsno='$goodsno'");
			}
			else { 
				$count=C::t('#sanree_brand_goods#sanree_brand_goods')->count_by_where(" AND goodsno='$goodsno' AND name <> '$name'");
			}
			if ($count>0) {
			
				cpmsg_error($langs['ishavegoodsno']);
				
			}			
			preg_match("/[^0-9a-zA-Z]/", $goodsno, $matches);
			if (count($matches)>0) {
				cpmsg_error($langs['errorgoodsno']);
			}
			$setarr['goodsno'] = $goodsno;
		}	

		if ($gid>0) {
			C::t('#sanree_brand_goods#sanree_brand_goods')->update($gid, $setarr);
		}
		else {
		    $setarr['dateline'] = TIMESTAMP;
			$setarr['ip'] = $_G['clientip'];
			$setarr['status'] = 1;
			$gid = C::t('#sanree_brand_goods#sanree_brand_goods')->insert($setarr, TRUE);	
			attention_information($gid, 'goods');	
		}
		C::t('#sanree_brand_goods#sanree_brand_goods')->update($gid, $setarr);
		goods_fixthread($gid);
		cpmsg($langs['succeed'],'action=plugins&operation=config&act=goods&identifier=sanree_brand_goods&pmod=admincp&page='.$page, 'succeed');				
	}
	else {
	    showsubmenu($menustr);	
		if($gid>0) {
		    $menustr = $langs['editbusi'];
		    $result = C::t('#sanree_brand_goods#sanree_brand_goods')->getusername_by_gid($gid);	
			$br = C::t('#sanree_brand#sanree_brand_businesses')->getusername_by_bid($result['bid']);
			$result['brandname'] = $br['name'];
			$result['startdate'] = empty($result['startdate']) ? '' : dgmdate($result['startdate']);
			$result['enddate'] = empty($result['enddate']) ? '' : dgmdate($result['enddate']);
			$result['weburl'] = empty($result['weburl']) ? '' : str_replace("http://", '', $result['weburl']);
        } else {	
		    $menustr = $langs['addbusi'];
			$result= array();
			$result['status'] = 1;
			$result['displayorder'] = 0;
			$result['isshow'] = 1;
			$result['buylink'] = 'http://';
			$result['user'] = C::t('#sanree_brand#xcommon_member')->fetch_all_username_by_uid($_G['uid']);	
		}
		
		$cateselect = "<option value=\"0\" selected>".$langs['pselect']."</option>\n";
		$category = goods_loadcache('admincate');
		$cates = array();
		foreach($category as $group) {
		
			if($group['cateid'] == $result['cateid']) {
			
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
			var url = '<?php echo ADMINSCRIPT?>?action=plugins&operation=config&act=goods&identifier=sanree_brand_goods&pmod=admincp&do=ajax&page='+spage;
			showWindow('selbrand',url);
			return false;
		}
		</script>
		<?php	
			
		showformheader($thisurl."&do=".$do."&gid=".$gid."&page=".$page, 'enctype');
		showtableheader($menustr, 'nobottom');				
		showsetting($langs['catename'], '', '', '<select name="cateid">'.$cateselect.'</select>', '', '', $langs['bitian']);
		showsetting($langs['brandname'], 'brandname', $result['brandname'], 'text','','','<button id="selbrand" onclick="showselbrand();">'.$langs['selectbrand'].'</button>&nbsp;&nbsp;Page:<input type="text" name="spage" size=2 id="spage" />', ' id="brandname" ');	
		showsetting($langs['goodsname'], 'name', $result['name'], 'text', '', '', $langs['bitian']);
		showsetting('keywords', 'keywords', $result['keywords'], 'text');
		showsetting('description', 'description', $result['description'], 'textarea');
		showsetting($langs['buylink'], 'buylink', $result['buylink'], 'text');
        ///showsetting($langs['introduction'], 'introduction', $result['introduction'], 'textarea');
		goods_srshowsetting($langs['content'], 'content', $result, 'srimg','','', $langs['bitian']);
		
		$unitselect = "";
		$unitlist = explode("\r\n", $selectpriceunit);
		$unitliststr = array();
		foreach($unitlist as $row) {
		
	        list($key , $value) = explode("=", $row);
			$key = trim($key);
			$value = goods_shtmlspecialchars(trim($value));			
			if($key == $result['priceunit']) {
			
				$unitselect .= "<option value=\"$key\" selected>$value</option>\n";
				
			} else {
			
				$unitselect .= "<option value=\"$key\">$value</option>\n";
				
			}
			
		}
		showsetting($langs['priceunit'], '', '', '<select name="priceunit">'.$unitselect.'</select>', '', '', $langs['bitian']);
		showsetting($langs['price'], 'price', $result['price'], 'text', '', '', $langs['bitian']);
		showsetting($langs['minprice'], 'minprice', $result['minprice'], 'text', '', '', $langs['bitian']);
		showsetting($langs['unit'], 'unit', $result['unit'], 'text', '', '', $langs['unittip']);
		///showsetting($langs['maxprice'], 'maxprice', $result['maxprice'], 'text');
		///showsetting($langs['reserveprice'], 'reserveprice', $result['reserveprice'], 'text');
		///showsetting($langs['attribute'], 'attribute', $result['attribute'], 'text');
		///showsetting($langs['stock'], 'stock', $result['stock'], 'text');
		///showsetting($langs['sales'], 'sales', $result['sales'], 'text');
		///showsetting($langs['grade'], 'grade', $result['grade'], 'text');
		showsetting($langs['goodsno'], 'goodsno', $result['goodsno'], 'text');		
		showsetting($langs['displayorder'], 'displayorder', $result['displayorder'], 'text');
		///showsetting($langs['startdate'], 'startdate', $result['startdate'], 'calendar');	
		///showsetting($langs['enddate'], 'enddate', $result['enddate'], 'calendar');			
		$result['dateline'] && showsetting($langs['dateline'], 'dateline', dgmdate($result['dateline']), 'text','1');
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
					C::t('#sanree_brand_goods#sanree_brand_goods')->update($id,$setarr);
					goods_fixthread($id) ;
				}
				
			}
			
		}	 
		if($_G['sr_delete']) {
		
		    $tids = array();
		    foreach (C::t('#sanree_brand_goods#sanree_brand_goods')->fetch_all_tid_by_gids($_G['sr_delete']) as $val) {
			
				$tids[] = $val[tid];
				
			}
			require_once libfile('function/delete');
            deletethread($tids);
			C::t('#sanree_brand_goods#sanree_brand_goods')->delete($_G['sr_delete']);
			
		}		
		cpmsg($langs['succeed'], "action=plugins&operation=config&act=".$act."&identifier=sanree_brand_goods&pmod=admincp&cateid=".$cateid.'&page='.$page, 'succeed');
		
	 } else {
	 
		$category = C::t('#sanree_brand_goods#sanree_brand_goods_category')->fetch_all_category();
		$cates = array();
		foreach($category as $v) {
			$cates[$v['cateid']] = $v;
		}
		$skeyword = isset($_G['sr_skeyword']) ? $_G['sr_skeyword'] : '';
		showsubmenu($menustr);	 
		showformheader($thisurl);
		showtableheader($langs['searchbar'], '', 'style="border:1px solid #F0F7FD"');
		showtablerow('', '', $langs['skeyword'].'<input type="text" name="skeyword" value="'.$skeyword.'" class="txt" style="width:200px;" /> <input type="submit" value="'.$langs['search'].'" class="btn" name="searchsubmit"/>');
		showtablefooter();
		showformfooter();
		
		showformheader($thisurl.'&page='.$page);
		showtableheader($langs['goods'], 'nobottom');
		showsubtitle(array('',$langs['showorder'],$langs['catename'],'tid', $lang['name'], $langs['istop'], $langs['isrecommend'], $langs['ishot'],$langs['reply'], $langs['isshow'],$langs['status'],'time', 'operation'));
		$perpage = 10;
		$resultempty = FALSE;
		$orderby = $searchtext = $extra = $srchuid = '';
		$orderby = 'istop desc,isrecommend desc, ishot desc, displayorder, gid desc';	
		$searchtext = ' AND status=1 ';	
		if (!empty($cateid)) {
		
			$searchtext .= "AND cateid ='".$cateid."'";

		}

		if(!empty($skeyword)){
		
			$searchfield = array('name', 'goodsno', 'keywords', 'description', 'smallpic',
			 'memo','bigpic', 'ip' , 'price', 'minprice' , 'maxprice' , 'reserveprice',
			 'introduction' ,'content' , 'reason', 'tid');
			$search = array();
			foreach($searchfield as $v) {
			
				$search[] = "(".$v." LIKE '%".$skeyword."%')";
				
			}
			$searchtext .= " AND (".implode(' OR ',$search).")";
			$extra = '&skeyword='.urlencode($skeyword);
		}		
		$count = C::t('#sanree_brand_goods#sanree_brand_goods')->count_by_where($searchtext);
		if ($cateid) $extra .="&cateid=".$cateid;
		$multipage=multi($count, $perpage, $page, ADMINSCRIPT."?action=plugins&operation=config&act=$act&identifier=sanree_brand_goods&pmod=admincp$extra");
		$datalist = C::t('#sanree_brand_goods#sanree_brand_goods')->fetch_all_by_search($searchtext,$orderby,(($page - 1) * $perpage),$perpage);
		foreach($datalist as $row) {
		
			$isrecommendstr = $row['isrecommend']==1 ? ' checked="checked"':'';
			$istopstr = $row['istop']==1 ? ' checked="checked"':'';
			$statusstr = $row['status']==1 ? $langs['yes']:$langs['no'];
			$ishotstr = $row['ishot']==1 ? ' checked="checked"':'';
			$isshowstr = $row['isshow']==1 ? ' checked="checked"':'';
			$allowreplystr = $row['allowreply']==1 ? ' checked="checked"':'';
			showtablerow('', array('', 'class="td25"','','class="td26"'), array(
			"<input class=\"checkbox\" type=\"checkbox\" name=\"delete[$row[gid]]\" value=\"$row[gid]\">" ,
			"<input type=\"text\" class=\"txt\" size=\"12\" name=\"group_displayorder[$row[gid]]\" value=\"$row[displayorder]\">",
			$cates[$row['cateid']]["name"],
			'<a target="_blank" href="forum.php?mod=viewthread&amp;tid='.$row["tid"].'">'.$row["tid"].'</a>',			
			"<input type=\"text\" class=\"txt\" size=\"12\" name=\"group_name[$row[gid]]\" value=\"$row[name]\">",
			"<input type=\"checkbox\"  size=\"12\" name=\"group_istop[$row[gid]]\" value=\"1\" $istopstr>",
			"<input type=\"checkbox\"  size=\"12\" name=\"group_isrecommend[$row[gid]]\" value=\"1\" $isrecommendstr>",
			"<input type=\"checkbox\"  size=\"12\" name=\"group_ishot[$row[gid]]\" value=\"1\" $ishotstr>",
			"<input type=\"checkbox\"  size=\"12\" name=\"group_allowreply[$row[gid]]\" value=\"1\" $allowreplystr>",
			"<input type=\"checkbox\"  size=\"12\" name=\"group_isshow[$row[gid]]\" value=\"1\" $isshowstr>",
			$statusstr,
			dgmdate($row['dateline']),
			'<a href="###" onclick="location.href=\''.ADMINSCRIPT.'?action=plugins&operation=config&act=goods&identifier=sanree_brand_goods&pmod=admincp&do=upgrading&gid='.$row['gid']."&page=".$page.'\'">'.$lang['edit'].'</a>'));
			
		}
		showsubmit('submit', 'submit', 'del', "<input class=\"checkbox\" type=\"hidden\" name=\"cateid\" value=\"$cateid\">", $multipage);
		showtablefooter();
		showformfooter();
	}
}
//From:www_YMG6_COM
?>