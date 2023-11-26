<?php

/**
 *      [Sanree] (C)2012-2099 Sanree Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: hook.class.php 2014-07-29 10:20:00 sanree checkedby fx8.cc $
 */

if(!defined('IN_DISCUZ')) {
	exit('');
}
class plugin_sanree_brand {

	function sanreebrandusermenu($param){
	
		global $_G;
		$config = $_G['cache']['plugin']['sanree_brand'];
		if (!$config['isopen']) {
		
			return;
			
		}		
		if ($param['bid']<1) {
			return;
		}
		if (!isset($_G['hookscriptvalues'])) {
			$_G['hookscriptvalues'] = array(
				'sign' => 'sanree',
				'bid' => $param['bid']
			);
		}		
	}	

	function sanreebrandmanagemenu($param){
	
		global $_G;
		$config = $_G['cache']['plugin']['sanree_brand'];
		if (!$config['isopen']) {
		
			return;
			
		}		
		if ($param['bid']<1) {
			return;
		}
		$brandresult = C::t('#sanree_brand#sanree_brand_businesses')->getusername_by_bidanduid($_G['uid'], $param['bid']);
		if ($brandresult['status']!=1) {
			return;
		}
		$isalbum = intval($config['isalbum']);
		$mapapi = trim($config['mapapi']);
		$albumgroup = unserialize($config['albumgroup']);
		$group = C::t('#sanree_brand#sanree_brand_group')->get_by_groupid($brandresult['groupid']);
		$allowtemplate = intval($group['allowtemplate']);
		$addhtml = '';
		if ($mapapi == 'baidu') {
			$addhtml = '<script type="text/javascript" src="http://api.map.baidu.com/api?v=1.2"></script><script type="text/javascript" src="http://api.map.baidu.com/library/CityList/1.2/src/CityList_min.js"></script>';
		} elseif ($mapapi=='google') {
			$addhtml = '<script src="http://maps.google.com/maps/api/js?sensor=false" type="text/javascript"></script>';
		}
		$_G['sanree_brand_managemenus'][] = array(
			'displayorder'=> 1, 
			'window' => 1,
			'name'=>'publisheddlg', 
			'title'=> srlang('editinfo'), 
			'url'=> 'plugin.php?id=sanree_brand&mod=published&bid='.$param['bid'],
			'class' => '',
			'addhtml' => $addhtml,
			'image' => 'source/plugin/sanree_brand/tpl/good/images/editinfo.png'
		);
		$_G['sanree_brand_managemenus'][] = array(
			'displayorder'=> 2, 
			'window' => 1,
			'name'=>'brandconfigdlg', 
			'title'=> srlang('baseconfig'), 
			'url'=> 'plugin.php?id=sanree_brand&mod=brandconfig&bid='.$param['bid'],
			'class' => '',
			'image' => 'source/plugin/sanree_brand/tpl/good/images/baseconfig.png'
		);
		$_G['sanree_brand_managemenus'][] = array(
			'displayorder'=> 3, 
			'window' => 1,
			'name'=>'brandconfigdlg', 
			'title'=> srlang('bannerconfig'), 
			'url'=> 'plugin.php?id=sanree_brand&mod=brandconfig&subdo=banner&bid='.$param['bid'],
			'class' => '',
			'image' => 'source/plugin/sanree_brand/tpl/good/images/bannerconfig.png'
		);		
		if ($allowtemplate==1) {
			$_G['sanree_brand_managemenus'][] = array(
				'displayorder'=> 4, 
				'window' => 1,
				'name'=>'brandconfigdlg', 
				'title'=> srlang('bodyconfig'), 
				'url'=> 'plugin.php?id=sanree_brand&mod=brandconfig&subdo=body&bid='.$param['bid'],
				'class' => '',
				'image' => 'source/plugin/sanree_brand/tpl/good/images/bodyconfig.png'
			);
		}
		$_G['sanree_brand_managemenus'][] = array(
			'displayorder'=> 5, 
			'window' => 1,
			'name'=>'brandconfigdlg', 
			'title'=> srlang('weixinconfig'), 
			'url'=> 'plugin.php?id=sanree_brand&mod=brandconfig&subdo=weixin&bid='.$param['bid'],
			'class' => '',
			'image' => 'source/plugin/sanree_brand/tpl/good/images/weixinconfig.png'
		);		
		if (($isalbum==1)&&(in_array($_G['group']['groupid'],$albumgroup))&&($brandresult[allowalbum]==1)) {
			$_G['sanree_brand_managemenus'][] = array(
				'displayorder'=> 5, 
				'window' => 0,
				'name'=>'albummanage', 
				'title'=> srlang('albummanage'), 
				'url'=> 'plugin.php?id=sanree_brand&mod=mybrand&view=myalbum&st=album_category&bid='.$param['bid'],
				'class' => '',
				'image' => 'source/plugin/sanree_brand/tpl/good/images/albummanage.png'
			);		
			$_G['sanree_brand_managemenus'][] = array(
				'displayorder'=> 6, 
				'window' => 1,
				'name'=>'creatalbumdlg', 
				'title'=> srlang('addalbum'), 
				'url'=> 'plugin.php?id=sanree_brand&amp;mod=ajax&amp;do=creatalbum&amp;bid='.$param['bid'],
				'class' => '',
				'image' => 'source/plugin/sanree_brand/tpl/good/images/addalbum.png'
			);
			$_G['sanree_brand_managemenus'][] = array(
				'displayorder'=> 7, 
				'window' => 0,
				'name'=>'imagemanage', 
				'title'=> srlang('imagemanage'), 
				'url'=> 'plugin.php?id=sanree_brand&mod=mybrand&view=myalbum&st=album&bid='.$param['bid'],
				'class' => '',
				'image' => 'source/plugin/sanree_brand/tpl/good/images/imagemanage.png',
			);	
			$_G['sanree_brand_managemenus'][] = array(
				'displayorder'=> 8, 
				'window' => 1,
				'name'=>'uploadpicdlg', 
				'title'=> srlang('uploadimg'), 
				'url'=> 'plugin.php?id=sanree_brand&amp;mod=ajax&amp;do=uploadpic&amp;bid='.$param['bid'],
				'class' => '',
				'image' => 'source/plugin/sanree_brand/tpl/good/images/uploadimg.png',
			);			
		}
		$_G['sanree_brand_managemenus'][] = array(
			'displayorder'=> 9, 
			'window' => 0,
			'name'=>'cmenu', 
			'title'=> srlang('managemsg'), 
			'url'=> 'plugin.php?id=sanree_brand&mod=mybrand&view=mymsg&bid='.$param['bid'],
			'class' => '',
			'image' => 'source/plugin/sanree_brand/tpl/good/images/mymsg.png'
		);
		if ($wapconfig = $_G['cache']['plugin']['sanree_we']['is_zg']) {
			$_G['sanree_brand_managemenus'][] = array(
				'displayorder'=> 10,
				'window' => 1,
				'name'=>'brandconfigdlg',
				'title'=> srlang('wezgimgbanner'),
				'url'=> 'plugin.php?id=sanree_brand&mod=brandconfig&subdo=wezgimg&bid='.$param['bid'],
				'class' => '',
				'image' => 'source/plugin/sanree_brand/tpl/good/images/wezgimg-icon.png'
			);
		}

	}

	function global_footer(){
	
		global $_G;

		$config = $_G['cache']['plugin']['sanree_brand'];
		if (!$config['isopen']) {
			return '';
		}			  
		$style = '<link href="source/plugin/sanree_brand/tpl/default/blockstyle.css" rel="stylesheet" type="text/css" />';
		if (file_exists(DISCUZ_ROOT."/data/cache/sanree_brand_diy.css")) {
		
			$style .= '<link href="data/cache/sanree_brand_diy.css" rel="stylesheet" type="text/css" />';
			
		}		
		return $style;
		
	}
	  
	function global_usernav_extra1(){
	
		global $_G;
		$config = $_G['cache']['plugin']['sanree_brand'];
		if (!$config['isopen']) {
		
			return '';
			
		}
		list($getid) = explode(':',$_GET['id']);
		$enterbrand = '';
		if ($_G['uid'] && $config['is_enterhint'] && $getid == 'sanree_brand' && (!$_GET['mod'] || $_GET['mod'] == 'index')) {

			$uidbrandcount = XDB::result_first("SELECT COUNT(*) FROM %t WHERE uid=%d", array('sanree_brand_businesses', $_G['uid']));

			if (!$uidbrandcount) {

				$ishintenter = C::t('#sanree_brand#sanree_brand_hint')->fetch_by_uid($_G['uid']);

				if (!$ishintenter['enter']) {

					$ahref = '
						<script language="javascript" src="source/plugin/sanree_brand/tpl/good/js/jquery-1.8.3.min.js"></script>
						<script>
						jQuery.noConflict();
						jQuery(function(){
							jQuery(".closebtn").click(function(){
								jQuery(".topfixed").css("display","none");
							})
						});
						function enterajax () {
							jQuery.ajax({
								type : \'POST\',
								url  : \'plugin.php?id=sanree_brand&mod=hint&\',
								data : "enter=1",
								async: false,
							})
						}
						</script>
						<link href="source/plugin/sanree_brand/tpl/good/hookstyle.css" rel="stylesheet" type="text/css" />
					';
					$ahref .= str_replace('{a}', '<a href="plugin.php?id=sanree_brand&mod=published" id="publisheddlg" onclick="showWindow(this.id, this.href, \'get\', 1)">',
						'<span class="topfixed">'.$config['enterhint'].'
							<span class="rightarrow"></span>
							<span onclick="if(document.getElementById(\'noprompt\').checked){enterajax()}" class="closebtn">X</span>
							<span class="nnbtn">
								<label>'.lang('plugin/sanree_brand', 'noprompt').'</label>
								<input id="noprompt" type="checkbox" name="noprompt" />
							</span>
						</span>'
					);
					$ahref = str_replace('{/a}', '</a>', $ahref);
					$enterbrand = $ahref;

				}
			}
		}
		$isshowtopnav = intval($config['isshowtopnav']);
		if ($isshowtopnav!=1) return $enterbrand;
		return '<a href="plugin.php?id=sanree_brand&mod=mybrand">'.lang('plugin/sanree_brand', 'mybrand').'</a> <span class="pipe"></span>'.$enterbrand;

	}

	  function discuzcode($data) {
	  
			global $_G,$thread;
			$config = $_G['cache']['plugin']['sanree_brand'];
			if (!$config['isopen']) {
			
				return;
				
			}
			$bindingforum = intval($config['bindingforum']);
			if ($bindingforum<1) return;
			if ($bindingforum != $thread['fid']) {	
			
				return;
				
			}
			if($data['caller'] == 'discuzcode') {
			
				$_G['discuzcodemessage'] = preg_replace("/\s?\[brandmap\](.+?)\[\/brandmap\]\s?/ies", '$this->getbrandmap(\'\\1\')', $_G['discuzcodemessage']);
				$_G['discuzcodemessage'] = preg_replace("/\s?\[poster\](.+?)\[\/poster\]\s?/ies", '$this->getbrandtemp(\'poster\',\'\\1\')', $_G['discuzcodemessage']);
				$_G['discuzcodemessage'] = preg_replace("/\s?\[propaganda\](.+?)\[\/propaganda\]\s?/ies", '$this->getbrandtemp(\'propaganda\',\'\\1\')', $_G['discuzcodemessage']);
				$_G['discuzcodemessage'] = preg_replace("/\s?\[introduction\](.+?)\[\/introduction\]\s?/ies", '$this->getbrandtemp(\'introduction\',\'\\1\')', $_G['discuzcodemessage']);
				$_G['discuzcodemessage'] = preg_replace("/\s?\[contact\](.+?)\[\/contact\]\s?/ies", '$this->getbrandtemp(\'contact\',\'\\1\')', $_G['discuzcodemessage']);
				$_G['discuzcodemessage'] = preg_replace("/\s?\[msn\](.+?)\[\/msn\]\s?/ies", '$this->icqcode(\'msn\',\'\\1\')', $_G['discuzcodemessage']);
				$_G['discuzcodemessage'] = preg_replace("/\s?\[wangwang\](.+?)\[\/wangwang\]\s?/ies", '$this->icqcode(\'wangwang\',\'\\1\')', $_G['discuzcodemessage']);
				$_G['discuzcodemessage'] = preg_replace("/\s?\[baiduhi\](.+?)\[\/skype\]\s?/ies", '$this->icqcode(\'baiduhi\',\'\\1\')', $_G['discuzcodemessage']);
				$_G['discuzcodemessage'] = preg_replace("/\s?\[skype\](.+?)\[\/skype\]\s?/ies", '$this->icqcode(\'skype\',\'\\1\')', $_G['discuzcodemessage']);						
				
			} else {
			
				$_G['discuzcodemessage'] = preg_replace("/\s?\[brandmap\](.+?)\[\/brandmap\]\s?/ies", '', $_G['discuzcodemessage']);
				$_G['discuzcodemessage'] = preg_replace("/\s?\[poster\](.+?)\[\/poster\]\s?/ies", '', $_G['discuzcodemessage']);
				$_G['discuzcodemessage'] = preg_replace("/\s?\[propaganda\](.+?)\[\/propaganda\]\s?/ies", '', $_G['discuzcodemessage']);
				$_G['discuzcodemessage'] = preg_replace("/\s?\[introduction\](.+?)\[\/introduction\]\s?/ies", '', $_G['discuzcodemessage']);
				$_G['discuzcodemessage'] = preg_replace("/\s?\[contact\](.+?)\[\/contact\]\s?/ies", '', $_G['discuzcodemessage']);	
				$_G['discuzcodemessage'] = str_replace('[/brandmap]', '', $_G['discuzcodemessage']);
				$_G['discuzcodemessage'] = str_replace('[/poster]', '', $_G['discuzcodemessage']);
				$_G['discuzcodemessage'] = str_replace('[/propaganda]', '', $_G['discuzcodemessage']);
				$_G['discuzcodemessage'] = str_replace('[/introduction]', '', $_G['discuzcodemessage']);
				$_G['discuzcodemessage'] = str_replace('[/contact]', '', $_G['discuzcodemessage']);
				
			}
			
	  }
	  
	function _getfirsticq($str){
	
		$str = trim($str);
		if (strpos($str, ',')>0) {
		
			return substr($str, 0, strpos($str, ','));
			
		}
		return $str;
		
	}	  
	  function icqcode($icq,$data) {
	  
			global $_G;	  
			$config = $_G['cache']['plugin']['sanree_brand'];
			if (!$config['isopen']) {
			
				return $data;
				
			}	
			$allicq = array('msn', 'wangwang', 'baiduhi', 'skype'); 
			if (in_array($icq, $allicq)) {
			
				$icqshow = trim($config[$icq.'code']);
			    $icqline = $this->_getfirsticq($data);
				$icqcode = empty($icqline) ? lang('plugin/sanree_brand','zanwustr') : str_replace('{icqnumber}',$icqline, $icqshow);
				return $icqcode;
				
			}
			return $data;
	  }
	  	  
	  function getbrandtemp($id, $data) {
	  
	     return "<div class=\"sanree_$id\" id=\"sanree_$id\">$data</div>";
		 
	  }
	  
	  function getbrandmap($mappos) {
	  
	      list($X, $Y) = explode(',',$mappos);
		  $mapinfo = "X=$X\tY=$Y";
		  return $mapinfo;	
		    
	  }
	  
}

class plugin_sanree_brand_home extends plugin_sanree_brand {

	function spacecp_credit_top_output() {
	
		global $_G;
		lang('spacecp');		
		$_G['lang']['spacecp']['BRD_credit'] = lang('plugin/sanree_brand', 'BRD');
		$_G['lang']['spacecp']['logs_credit_update_BRD'] = lang('plugin/sanree_brand', 'BRD');
		return '';
		
	} 
	
}
class plugin_sanree_brand_group extends plugin_sanree_brand {

	function group_nav_extra_output(){
	
	    global $_G;	
		$config = $_G['cache']['plugin']['sanree_brand'];
		if (intval($config['allowsyngroup'])!=1) return '';	
		$brandresult=C::t('#sanree_brand#sanree_brand_businesses')->fetch_first_byfid(intval($_GET['fid']));
		if (!brandresult) return '';	
		$group = C::t('#sanree_brand#sanree_brand_group')->get_by_groupid($brandresult['groupid']);
		if (intval($group['allowsyngroup'])!=1) {
			return '';
		}		
		$modfile=DISCUZ_ROOT.'./source/plugin/sanree_brand/function/function_core.php';
		@require_once($modfile);		
		$url = getburl($brandresult);
		return "<li ><a href=\"$url\" target=\"_blank\">".srlang('group_nav_extra')."</a></li>";
		
	}
	
}
class plugin_sanree_brand_forum extends plugin_sanree_brand {

    function viewthread_postfooter_output(){
	
	    global $_G;
		$config = $_G['cache']['plugin']['sanree_brand'];
		if (!$config['isopen']) {
		
		    return array();
			
		}
		if ($_G['uid']==1) return array();
		$bindingforum = intval($config['bindingforum']);
		if ($bindingforum<1) return array();
		if ((CURSCRIPT == 'forum') && $bindingforum == $_G['fid']) {
		
			$_G['group']['alloweditpost'] = 0;
			$_G['group']['allowdelpost'] = 0;
			$_G['group']['allowclosethread'] = 0;
			$_G['group']['allowmovethread'] = 0;
			$_G['group']['allowedittypethread'] = 0;
			$_G['group']['allowcopythread'] = 0;
			$_G['group']['allowsplitthread'] = 0;
			$_G['group']['allowrepairthread'] = 0;
			$_G['group']['allowwarnpost'] = 0;
			$_G['group']['allowmergethread'] = 0;
			$_G['group']['allowbanpost'] = 0;
			
		}
		return array();
			
	}
	
	function viewthread_title_extra_output() {
	    global $_G;
		$config = $_G['cache']['plugin']['sanree_brand'];
		if (!$config['isopen']) {
		
		    return '';
			
		}
		$bindingforum = intval($config['bindingforum']);
		if ($bindingforum<1) return '';
		if ((CURSCRIPT == 'forum') && $bindingforum == $_G['fid']) {
		
		   return $config['forumwarning'];
		   
		}			
		return '';
		
	}
	
	function forumdisplay_top_output() {
	
	    global $_G,$fastpost;
		$config = $_G['cache']['plugin']['sanree_brand'];
		if (!$config['isopen']) {
		
		    return '';
			
		}
		if ($_G[uid]==1) return '';
		$bindingforum = intval($config['bindingforum']);
		if ($bindingforum<1) return '';
		if ((CURSCRIPT == 'forum') && $bindingforum == $_G['fid']) {
		
		   $fastpost = 0;
		   
		}
		return '';
		
	}
	
	function viewthread_middle_output() {
	
	    global $_G,$allowfastpost,$thread;
		$config = $_G['cache']['plugin']['sanree_brand'];
		if (!$config['isopen']) {
		
		    return '';
			
		}
		if ($_G[uid]==1) return '';
		$bindingforum = intval($config['bindingforum']);
		if ($bindingforum<1) return '';
		if ((CURSCRIPT == 'forum') && $bindingforum == $_G['fid']) {
		
		   $result = C::t('#sanree_brand#sanree_brand_businesses')->getbusinesses_by_tid($thread['tid']);
		   if ($result['allowfastpost'] != 1) {
		   
			   $allowfastpost = FALSE;
			   
		   }
		   
		}
		return '';
		
	}	
	
	function post() {
	
	    global $_G, $mod;
		$config = $_G['cache']['plugin']['sanree_brand'];
		if (!$config['isopen']) {
		
		    return;
			
		}
		if ($_G[uid]==1) return;
		$action = $_G['gp_action'];
		$bindingforum = intval($config['bindingforum']);
		if ($bindingforum<1) return;
		if ((CURSCRIPT == 'forum') && ($mod == 'post') && $bindingforum == $_G['fid']) {
		
		   if ($action != 'reply') {
		   
			   showmessage('postperm_none_nopermission');
			   
		   }
		   $result = C::t('#sanree_brand#sanree_brand_businesses')->getbusinesses_by_tid($_G['tid']);
		   if ($result['allowfastpost'] != 1) {
		   
			   showmessage(lang('plugin/sanree_brand', 'nofastpostcontrol'));
			   
		   }
		   
		}
			
	}

	function viewthread_title_extra () {
		global $_G;
		$config = $_G['cache']['plugin']['sanree_brand'];
		$value = C::t('#sanree_brand#sanree_brand_businesses')->getbusinesses_by_tid($_G['thread']['tid']);
		if (!empty($value)) {
			$group = C::t('#sanree_brand#sanree_brand_group')->get_by_groupid($value['groupid']);
			if ($group['urlmod'] == 1|| $config['isonepage'] ==1 ) {
				$modfile=DISCUZ_ROOT.'./source/plugin/sanree_brand/function/function_core.php';
				@require_once($modfile);
				$getbrandurl = getdetailurl($value);
				return '
				<link href="source/plugin/sanree_brand/tpl/good/hookstyle.css" rel="stylesheet" type="text/css" />
				<div class="bbs_nlbox">
					<div class="nleft">
						<a href="'.$getbrandurl.'" class="link_mer">'.srlang('onclickgobrand').'</a>
						<div class="uparrow"></div>
						<div class="downarrow"></div>
					</div>
				</div>';
			}
		}
		return '';

	}
	
}

class plugin_sanree_brand_plugin extends plugin_sanree_brand {

	function sanree_brand_userrighttop_output($param){
	
		global $_G;
		$config = $_G['cache']['plugin']['sanree_brand'];
		if (!$config['isopen']) {
		
			return '';
			
		}	
		$values = $param['values'];
		if ($values['sign']!=='sanree') return;		
		$bid = intval($values['bid']);
		if ($bid<1) {
			return '';
		}
		$brandresult = C::t('#sanree_brand#sanree_brand_businesses')->getbusinesses_by_bid($bid);
		if (!$brandresult) {
			return '';
		}
		if ($brandresult['status']!=1) {
			return '';
		}	
		if ($_G['uid']!=1)	{
			return '';
		}
		return '';
		
	}
	
	function sanree_brand_index_toper_output($param){
	
		global $_G;
		$config = $_G['cache']['plugin']['sanree_brand'];
		if (!$config['isopen']) {
		
			return '';
			
		}	
		
		if ($_G['isopendiy']==1&&$_GET['diy']=='yes'&&$_G['uid']==1) {
		
		    $appver = strtolower($_G['setting']['version']);
			if ($appver=='x2.5') {
			
				$diysign=dsign('tpl/'.$_G['template'].'index');
				
				return '<div style="height:60px;line-height:60px;font-size:20px;text-align:center;background-color:#F5F7F9;" id="sanreediy"></div>
				<script language="javascript">if ($(\'diyform\')){$(\'diyform\').action=\'plugin.php?id=sanree_brand&mod=portalcp&ac=diy\';}if ($(\'sanreediy\')) {$(\'sanreediy\').innerHTML=\'DIY is loaded.\';}</script>';
				
			} elseif ($appver=='x2') {
			
				return '<div style="height:60px;line-height:60px;font-size:20px;text-align:center;background-color:#F5F7F9;" id="sanreediy"></div>
				<script language="javascript">if ($(\'diyform\')) {$(\'diyform\').action=\'plugin.php?id=sanree_brand&mod=portalcp&ac=diy\';
				$(\'sanreediy\').innerHTML=\'DIY is loaded.\';}</script>';
				
			}
			
			
		}
		return '';
		
	}
}
//From:www_YMG6_COM
?>