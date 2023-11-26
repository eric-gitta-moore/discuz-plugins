<?php

/**
 *      [Sanree] (C)2012-2099 Sanree Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: sanree_brand_group.php $
 */

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}

$do = $_G['sr_do'];
$doarray = array('list', 'upgrading');
$do = !in_array($do,$doarray) ? 'list' : $do;
$_G['sr_page'] = isset($_G['sr_page']) ? $_G['sr_page'] : 0;

if ($do == 'list') {

	if(submitcheck('submit')){
	
		if(is_array($_G['sr_group_title'])) {
		
			foreach($_G['sr_group_title'] as $id => $title) {
			
				if(!$_G['sr_delete'][$id]) {
				
					$setarr=array(
						'groupname' => $_G['sr_group_title'][$id],
					);
					C::t('#sanree_brand#sanree_brand_group')->update($id,$setarr);
					
				}
				
			}
			
		}	 
		if($_G['sr_delete']) {

			C::t('#sanree_brand#sanree_brand_group')->delete($_G['sr_delete']);
			
		}
		if($_G['sr_delete_record']) {

			C::t('#sanree_brand#sanree_brand_record')->delete($_G['sr_delete_record']);
			cpmsg($langs['succeed'],'action=plugins&operation=config&act=group&plug=record&identifier=sanree_brand&pmod=admincp&page='.$page, 'succeed');
		
		}	
		cpmsg($langs['succeed'],'action=plugins&operation=config&act=group&identifier=sanree_brand&pmod=admincp&page='.$page, 'succeed');	
	
	} else {	
	
		showsubmenu($menustr);
		
		
		$plug = $_G['sr_plug'];
		if($plug == 'record') {
			
			showtableheader('', 'nobottom');		
			showtablerow('', array(), 
			array(
				'<ul class="tab1">'.
				'<li ><a href="'.ADMINSCRIPT.'?action=plugins&operation=config&act=group&do=list&identifier=sanree_brand&pmod=admincp"><span>'.$langs['brand_group'].'</span></a></li>'.
				'<li class="current"><a href="'.ADMINSCRIPT.'?action=plugins&operation=config&act=group&do=list&plug=record&identifier=sanree_brand&pmod=admincp"><span>'.$langs['promotion_record'].'</span></a></li>'.
				'</ul>'
			));
			showtablefooter();
			
			$skeyword = $_G['sr_skeyword'];
			showformheader($thisurl.'&plug=record');
			showtableheader($langs['searchbar'], '', 'style="border:1px solid #F0F7FD"');
			showtablerow('', '', $langs['skeyword'].'<input type="text" name="skeyword" value="'.$skeyword.'" class="txt" style="width:200px;" /> <input type="submit" value="'.$langs['search'].'" class="btn" name="searchsubmit"/>');
			showtablefooter();
			showformfooter();
							
			showformheader($thisurl);
			showtableheader($langs['promotion_record'], 'nobottom');
			showsubtitle(array('', $langs['promotion_brandname'], $langs['promotion_username'], $langs['promotion_former'], $langs['promotion_group'], $langs['promotion_time'], $langs['promotion_price']));
			$perpage = 10;
			$srchadd = $searchtext = $extra = $srchuid = '';
			$page = max(1, intval($_G['sr_page']));
			$orderby = ' rid  desc';
			
			if(!empty($skeyword)){
			
				$searchfield = array('bid', 'uid');
				$search = array();
				foreach($searchfield as $v) {
					$skeyword = $_G['sr_skeyword'];
					if($v == 'bid'){
						$skeyword = C::t('#sanree_brand#sanree_brand_businesses')->fetch_bid_by_brandname($skeyword);
						if(!$skeyword){
							$skeyword = 0;
						}
					}
					if($v == 'uid'){
						$skeyword = C::t('#sanree_brand#xcommon_member')->fetch_uid_by_username($skeyword);
						if(!$skeyword){
							$skeyword = 0;
						}
					}
					$search[] = "(".$v." LIKE '".$skeyword."')";
					
				}
				$searchtext .= " AND (".implode(' OR ',$search).")";
				$extra = '&skeyword='.urlencode($skeyword);
			}
					
			$count = C::t('#sanree_brand#sanree_brand_record')->count_by_wherec($searchtext);
			$multipage=multi($count, $perpage, $page, ADMINSCRIPT."?action=plugins&operation=config&act=$act&plug=record&identifier=sanree_brand&pmod=admincp$extra");	
			$datalist = C::t('#sanree_brand#sanree_brand_record')->fetch_all_by_searchc($searchtext,$orderby,(($page - 1) * $perpage),$perpage);
	
			foreach($datalist as $value) {
	
				$brandname = C::t('#sanree_brand#sanree_brand_businesses')->getname_by_bid($value['bid']);
				$ausername = C::t('#sanree_brand#xcommon_member')->fetch_all_username_by_uid($value['uid']);
				$group = C::t('#sanree_brand#sanree_brand_group')->getgroup_by_gid($value['gid']);
				$former = C::t('#sanree_brand#sanree_brand_group')->getgroup_by_gid($value['former']);
				showtablerow('', array('', '','', ''), array(
					"<input class=\"checkbox\" type=\"checkbox\" name=\"delete_record[$value[rid]]\" value=\"$value[rid]\">",
					$brandname,
					$ausername,
					!$former ? $langs['promotion_current_nograde'] : $former['groupname'],
					$group['groupname'],
					$value['dateline'] ? dgmdate($value['dateline']):'',
					$value['cost']
				));
				
			}
						
			showsubmit('submit', 'submit', 'del', '', $multipage, false);
			showtablefooter();
			showformfooter();
			
			return;
		}
		
		showtableheader('', 'nobottom');		
		showtablerow('', array(), 
		array(
			'<ul class="tab1">'.
			'<li class="current"><a href="'.ADMINSCRIPT.'?action=plugins&operation=config&act=group&do=list&identifier=sanree_brand&pmod=admincp"><span>'.$langs['brand_group'].'</span></a></li>'.
			'<li ><a href="'.ADMINSCRIPT.'?action=plugins&operation=config&act=group&do=list&plug=record&identifier=sanree_brand&pmod=admincp"><span>'.$langs['promotion_record'].'</span></a></li>'.
			'</ul>'
		));
		showtablefooter();
			
		showformheader($thisurl);
		showtableheader($langs['brand_group'], 'nobottom');
		showsubtitle(array('ID','order',$langs['group_name'],'',$langs['maxalbumcategory'],$langs['maxalbum'],$langs['group_nums'],'time', $langs['group_price'], $langs['group_status'],'operation'));
		
		$srchadd = $searchtext = $extra = $srchuid = '';
		$page = max(1, intval($_G['sr_page']));
		$orderby = 'groupid asc';
		$count = C::t('#sanree_brand#sanree_brand_group')->count_by_where($searchtext);
		$perpage = $count;
		$multipage=multi($count, $ppp, $page, ADMINSCRIPT."?action=company&operation=group$extra");
		$datalist = C::t('#sanree_brand#sanree_brand_group')->fetch_all_by_search($searchtext,$orderby,(($page - 1) * $perpage),$perpage);
		foreach($datalist as $value) {
		
		    $value['nums'] = C::t('#sanree_brand#sanree_brand_businesses')->count_by_groupid(intval($value['groupid']));
		    $value['isuse'] = $value['isuse']==1 ? $langs['yes'] : $langs['no'];
			showtablerow('', array('', 'class="td25"', 'class="td23"',''), array(
			"<input class=\"checkbox\" type=\"checkbox\" name=\"delete[$value[groupid]]\" value=\"$value[groupid]\">".$value['groupid'],
			$value['order'],
			"<input type=\"text\" class=\"txt\" size=\"12\" name=\"group_title[$value[groupid]]\" value=\"$value[groupname]\">",
			$value[grouplogo] ? "<img src=\"".fiximage($value['grouplogo'])."\" width=65 height=15>":'',
			$value[maxalbumcategory],
			$value[maxalbum],
			$value['nums'], dgmdate($value['dateline']), $value['price'], $value['isuse'],
			'<a href="###" onclick="location.href=\''.ADMINSCRIPT.'?action=plugins&operation=config&act=group&identifier=sanree_brand&pmod=admincp&do=upgrading&groupid='.$value['groupid']."&page=".$page.'\'">'.$lang['edit'].'</a>'));
			
		}
		$addurl = ADMINSCRIPT.'?action=plugins&operation=config&act=group&identifier=sanree_brand&pmod=admincp&do=upgrading';
		echo '<tr><td>&nbsp;</td><td colspan="5"><div><a href="###" onclick="location.href=\''.$addurl.'\'" class="addtr">'.$langs['addgroup'].'</a></div></td></tr>';			
		showsubmit('submit', 'submit', 'del', '', $multipage);
		showtablefooter();
		showformfooter();
		
	}	
	
} elseif($do=='upgrading') {

    $groupid = intval($_G['sr_groupid']);	
	$page = max(1, intval($_G['sr_page']));
	if(submitcheck('upgradingsubmit', 1)) {
	
		$setarr = array();
		$groupname = dhtmlspecialchars($_G['sr_groupname']);
		$isuse = dhtmlspecialchars($_G['sr_isuse']);		
		if (empty($groupname)) {
		
			cpmsg($langs['group_name_tips'],'','error');
			
		}
		
		$setarr['order'] = intval($_G['sr_order']);
		$setarr['price'] = intval($_G['sr_price']);
		$setarr['groupname'] = $groupname;
		$setarr['urlmod'] = intval(dhtmlspecialchars($_G['sr_urlmod']));
		$setarr['adminid'] = $_G['uid'];
		$setarr['isuse'] = $isuse==1 ? 1 : 0;
		$setarr['dateline']=TIMESTAMP;
		$setarr['maxalbumcategory'] = intval(dhtmlspecialchars($_G['sr_maxalbumcategory']));
		$setarr['maxalbum'] = intval(dhtmlspecialchars($_G['sr_maxalbum']));
		$setarr['allowtemplate'] = intval(dhtmlspecialchars($_G['sr_allowtemplate']));
		$setarr['allowdeletealbum'] = intval(dhtmlspecialchars($_G['sr_allowdeletealbum']));
		$setarr['allowbatchimage'] = intval(dhtmlspecialchars($_G['sr_allowbatchimage']));	
		$setarr['allowsyngroup'] = intval(dhtmlspecialchars($_G['sr_allowsyngroup']));
		$setarr['ismf'] = intval($_G['sr_ismf']);
		$setarr['istag'] = intval($_G['sr_istag']);
				
		if($groupid>0) {
		
			if($_FILES['grouplogo']) {
			
				$data = array('extid' => $_G['sr_groupid']);
				$logo =  upload_icon_banner($data, $_FILES['grouplogo'],'');
				
			} else {
			
				$logo = $_G['sr_grouplogo'];
				
			}
			if($logo) {
			
				$setarr['grouplogo'] = $logo;
				
			}
			if($_G['sr_deletelogo']) {

				$result = C::t('#sanree_brand#sanree_brand_group')->get_by_groupid($groupid);	
				$valueparse = parse_url($result['grouplogo']);
				if(!isset($valueparse['host'])) {
				
					@unlink($_G['setting']['attachurl'].'common/'.$result['grouplogo']);
					
				}
				$setarr['grouplogo'] = '';
				
			}
			if($_FILES['smallicons']) {
			
				$data = array('extid' => $_G['sr_groupid']);
				$smallicons =  upload_icon_banner($data, $_FILES['smallicons'],'');
				
			} else {
			
				$smallicons = $_G['sr_smallicons'];
				
			}
			if($smallicons) {
			
				$setarr['smallicons'] = $smallicons;
				
			}
			if($_G['sr_deletesmallicons']) {

				$result = C::t('#sanree_brand#sanree_brand_group')->get_by_groupid($groupid);	
				$valueparse = parse_url($result['smallicons']);
				if(!isset($valueparse['host'])) {
				
					@unlink($_G['setting']['attachurl'].'common/'.$result['smallicons']);
					
				}
				$setarr['smallicons'] = '';
				
			}
			DB::update('sanree_brand_group', $setarr,"groupid=".$groupid);
			
		} else {	
		
			if($_FILES['grouplogo']) {
			
				$data = array('extid' => TIMESTAMP);
				$grouplogo = upload_icon_banner($data, $_FILES['grouplogo'],'');

				
			} else {
			
				$grouplogo = $_G['sr_grouplogo'];
				
			}			
			$setarr['grouplogo']=$grouplogo;				    
			if($_FILES['smallicons']) {
			
				$data = array('extid' => TIMESTAMP);
				$smallicons = upload_icon_banner($data, $_FILES['smallicons'],'');

				
			} else {
			
				$smallicons = $_G['sr_smallicons'];
				
			}			
			$setarr['smallicons']=$smallicons;
						
			DB::insert('sanree_brand_group', $setarr);
		}
		if (C::t('#sanree_brand#sanree_brand_group_module')->count_by_where(' AND groupid='.$groupid)>0) {

			C::t('#sanree_brand#sanree_brand_group_module')->update_by_groupid($groupid, $_G['sr_module']);
		
		} else {
		
		    $addarray = array();
			$addarray= $_G['sr_module'];
			$addarray[groupid] = $groupid;
			C::t('#sanree_brand#sanree_brand_group_module')->insert($addarray);
			
		}		
		cpmsg($langs['succeed'],'action=plugins&operation=config&act=group&identifier=sanree_brand&pmod=admincp&page='.$page, 'succeed');	
			
	} else {
		
	    showsubmenu($menustr);	
		if($groupid>0) {
		
		    $menustr = 'group_modify';
			$result = C::t('#sanree_brand#sanree_brand_group')->get_by_groupid($groupid);	
			
        } else {	
		
		    $menustr = 'group_add';
			$result= array();
			$result['user']= C::t('#sanree_brand#xcommon_member')->fetch_all_username_by_uid($_G['uid']);	
			$result['dateline'] = TIMESTAMP;
			$result['nums'] = '0';
			$result['isuse'] = 1;
			$result['groupname']='';
			$result['maxalbumcategory'] = 5;
			$result['maxalbum'] = 50;			
		}
		$groupselect = '';
		$category = array();
		$category[] = array('cateid'=>0 ,'name'=> $langs['urlmod_default']);
		$category[] = array('cateid'=>1 ,'name'=> $langs['urlmod_onepage']);

		foreach($category as $group) {
		
			if($group[cateid] == $result[urlmod]) {
			
				$groupselect .= "<option value=\"$group[cateid]\" selected>$group[name]</option>\n";
				
			} else {
			
				$groupselect .= "<option value=\"$group[cateid]\">$group[name]</option>\n";
				
			}
			
		}
		
		?>
        <style type="text/css">
        	#domfx {
				background: none repeat scroll 0% 0% #F9EDBE;
				width: 200px;
				position: fixed;
				left: 80px;
				top: 24%;
				border-radius: 5px;
				text-align: center;
				display: none;
				color:#f00;
			}
			
			#domfx span {
				display: block;
				color: #09C;
				font-weight: 700;
				text-align: left;
				padding: 5px 10px;
				background: #f0e0b0;
			}
			
			#domfx tips {
				display: block;
				margin: 5px 20px;
				line-height: 20px;
			}
			
			#domfx font {
				display: block;
				margin: 5px 20px;
				line-height: 20px;
			}
        </style>
		<div id="domfx"></div>
		<script language="javascript">
		
		function valid_price(obj) {
			
			var cpform = document.getElementById('cpform');
			
			if(!obj.value){
				
				domfx.innerHTML = '<span><?php echo $langs['sanree_tip'] ?></span><?php echo $langs['promotion_price_null'] ?>'+'<?php echo $langs['promotion_price_tip'] ?>';
				domfx.style.display = 'block';
				obj.style.borderColor = '#F00';
				obj.value = 100;
				setTimeout("document.getElementById('domfx').style.display = 'none';cpform.price.focus();", 5000);
				
				return false;
			}else {
				obj.style.borderColor = '#21af1b';
				return true;
			}
		}
		
		function valid(value, flag) {
			
			var input = document.getElementById('promotion');
			var domfx = document.getElementById('domfx');
			var cpform = document.getElementById('cpform');
			
			if(!value){
				
				domfx.innerHTML = '<span><?php echo $langs['sanree_tip'] ?></span><?php echo $langs['valid_nonull'] ?>'+'<?php echo $langs['valid_nonull_tips'] ?>';
				domfx.style.display = 'block';
				input.style.borderColor = '#F00';
				setTimeout("document.getElementById('domfx').style.display = 'none';cpform.order.focus();", 5000);
				
				return false;
			}
			
			flag = typeof flag == 'undefined' ? false : flag;
			var url = parseInt(flag) ? 'plugin.php?id=sanree_brand&mod=promotion&valid='+value+'&flag='+flag : 'plugin.php?id=sanree_brand&mod=promotion&valid='+value;
			//location.href = url;
			if (window.XMLHttpRequest) {// code for IE7+, Firefox, Chrome, Opera, Safari
				 xmlhttp=new XMLHttpRequest();
			}
			else {// code for IE6, IE5
				xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
			}
				
			xmlhttp.onreadystatechange=function() {
				
				if (xmlhttp.readyState==4 && xmlhttp.status==200) {
					
					if(xmlhttp.responseText) {
						var valid_tips = '<?php echo $langs['valid_tips'] ?>';
						var valid_tips = valid_tips.replace('{rec}', xmlhttp.responseText);
						domfx.innerHTML = '<span><?php echo $langs['sanree_tip'] ?></span><?php echo $langs['valid'] ?>'+valid_tips;
						domfx.style.display = 'block';
						
						//input.style.borderWidth = '1px'
						//input.style.borderStyle = 'solid';
						input.style.borderColor = '#F00';
						setTimeout("document.getElementById('domfx').style.display = 'none';cpform.order.focus();", 5000);
						input.value = xmlhttp.responseText;
						
					}else {
						
						input.style.borderColor = '#21af1b';
						
					}
				
				}
			}
			xmlhttp.open("GET", url, true);
			xmlhttp.send();
		}
		
		function validate(obj, groupid) {
			
			if(!obj.groupname.value) {
				alert('<?php echo $langs['group_name_tips'] ?>');
				obj.groupname.focus();
				return false;
			}
			
			return valid_price(document.getElementById('promotion_price'));
		}
		</script>
		<?php
		
		$maxorder = C::t('#sanree_brand#sanree_brand_group')->get_by_maxorder();
		
		showformheader($thisurl."&do=".$do."&page=".$page."&groupid=".$groupid, 'enctype="multipart/form-data" onsubmit="return validate(this, '.$groupid.');"');
		showtableheader($langs[$menustr], 'nobottom');
		showsetting('operator', '', '', $result['user']);
		$result['order'] == NULL && showsetting('order', 'order',  ++$maxorder['order'], 'text','' ,'', $langs['bitian'].$langs['promotion_tip'], 'onblur="valid(this.value);" id="promotion"');		
		$result['order'] != NULL && showsetting('order', 'order',  $result['order'], 'text','' ,'', $langs['bitian'].$langs['promotion_tip'], 'onblur="valid(this.value, '.$groupid.');" id="promotion"');
		showsetting($langs['group_price'], 'price', $result['price'], 'text','' ,'', $langs['bitian'].$langs['promotion_price_tip'], 'onblur="valid_price(this);" id="promotion_price"');
		showsetting($langs['group_name'], 'groupname', $result['groupname'], 'text');
		showsetting($langs['urlmod'], '', '', '<select name="urlmod">'.$groupselect.'</select>');
		showsetting($langs['group_enable'], 'isuse', $result['isuse'], 'radio');
		showsetting($langs['allowtemplate'], 'allowtemplate', $result['allowtemplate'], 'radio');
		showsetting($langs['allowdeletealbum'], 'allowdeletealbum', $result['allowdeletealbum'], 'radio');
		showsetting($langs['allowbatchimage'], 'allowbatchimage', $result['allowbatchimage'], 'radio');	
		showsetting($langs['allowsyngroup'], 'allowsyngroup', $result['allowsyngroup'], 'radio');
		showsetting($langs['ismf'], 'ismf', $result['ismf'], 'radio');
		showsetting($langs['istag'], 'istag', $result['istag'], 'radio');		
		if($result['grouplogo']) {
		
			$grouplogo =fiximage($result['grouplogo']);
			$grouplogohtml = '<label><input type="checkbox" class="checkbox" name="deletelogo[$result[groupid]]" value="yes" /> '.$lang['delete'].'</label><br /><img src="'.$grouplogo.'"  />';
			
		}	
		showsetting($langs['group_icons'], 'grouplogo', $result['grouplogo'], 'filetext', '', 0,$grouplogohtml);
		$grouplogohtml= '';
		if($result['smallicons']) {
		
			$grouplogo =fiximage($result['smallicons']);
			$grouplogohtml = '<label><input type="checkbox" class="checkbox" name="deletesmallicons[$result[groupid]]" value="yes" /> '.$lang['delete'].'</label><br /><img src="'.$grouplogo.'"  />';
			
		}	
		showsetting($langs['group_smallicons'], 'smallicons', $result['smallicons'], 'filetext', '', 0,$grouplogohtml);
						
		showsetting('time', '', '', dgmdate($result['dateline']));
		showsetting($langs['maxalbumcategory'], 'maxalbumcategory', $result['maxalbumcategory'], 'text','','', $langs['albumistip']);
		showsetting($langs['maxalbum'], 'maxalbum', $result['maxalbum'], 'text','','', $langs['albumistip']);
		$moduleresult = C::t('#sanree_brand#sanree_brand_group_module')->fetch_by_groupid($groupid);
		foreach(C::t('#sanree_brand#sanree_brand_group_module')->fetch_all_column() as $key =>$column)	{
            
			$columnname = $column[data];
			$type = $column[type];
			showsetting($langs['module'][$columnname], 'module['.$columnname.']', $moduleresult[$columnname], $type);
		
		}		
		showsubmit('upgradingsubmit');
		showtablefooter();
		showformfooter();
			
	}
		
}
//From:www_YMG6_COM
?>