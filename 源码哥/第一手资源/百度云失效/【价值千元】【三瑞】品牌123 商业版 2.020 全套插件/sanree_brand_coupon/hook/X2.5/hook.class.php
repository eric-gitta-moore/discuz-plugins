<?php

/**
 *      [Sanree] (C)2012-2099 Sanree Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: hook.class.php $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
define('$pidentifier', 'coupon');
$modfile=DISCUZ_ROOT.'./source/plugin/sanree_brand_coupon/function/function_core.php';
@require_once($modfile);
$modfile = DISCUZ_ROOT.'./source/plugin/sanree_brand_coupon/function/function_module.php';
@require_once($modfile);

class plugin_sanree_brand_coupon {

	function sanreebrandmanagemenu($param){
	
		global $_G;
		$config = $_G['cache']['plugin']['sanree_brand_coupon'];
		if (!$config['isopen']) {
		
			return;
			
		}	
		$brand_config = $_G['cache']['plugin']['sanree_brand'];
		if (!$brand_config['isopen']) {
		
			return;
			
		}			
		if ($param['bid']<1) {
			return;
		}
		$iscoupon = C::t('#sanree_brand#sanree_brand_businesses_module')->fetch_by_modename('iscoupon', $param['bid']);	
		if ($iscoupon!=1) {
		
			return;
			
		}		
		$_G['sanree_brand_managemenus'][] = array(
			'displayorder'=> 600, 
			'window' => 0,
			'name'=>'mycoupon', 
			'title'=> coupon_modlang('mycoupon'), 
			'url'=> 'plugin.php?id=sanree_brand_coupon&mod=mycoupon',
			'class' => '',
			'image' => 'source/plugin/sanree_brand_coupon/tpl/default/images/mycoupon.png'
		);
		$_G['sanree_brand_managemenus'][] = array(
			'displayorder'=> 601, 
			'window' => 1,
			'name'=>'publisheddlg', 
			'title'=> coupon_modlang('post_new_coupon'), 
			'url'=> 'plugin.php?id=sanree_brand_coupon&mod=published',
			'class' => '',
			'addhtml' => '<link rel="stylesheet" type="text/css" id="sanree_brand_coupon" href="source/plugin/sanree_brand_coupon/tpl/default/sanree_brand_coupon.css" />',
			'image' => 'source/plugin/sanree_brand_coupon/tpl/default/images/post_new_coupon.png'
		);
		
	}
	
      function sanreemoduleupdate($param) {
	  
	      global $_G;
	      $bid = intval($param[bid]);
		  $data = $param[data];
          $iscoupon = $data[iscoupon];
		  $gid = array();
		  if ($bid<1) return;
		  foreach(C::t('#sanree_brand_coupon#sanree_brand_coupon')->fetch_all_by_bid($bid) as $data) {

			  C::t('#sanree_brand_coupon#sanree_brand_coupon')->update($data[gid], array('isshow' => $iscoupon));
			  $gid[] = $data[gid];
			  
		  }
		  coupon_fixthread($gid);
		  
	  }
	  
	  function discuzcode($data) {
	  
			global $_G,$thread,$postlist;
			$brand_config = $_G['cache']['plugin']['sanree_brand'];
			if (!$brand_config['isopen']) {
			
				return;
				
			}	
			$ismultiple = intval($brand_config['ismultiple']);
			$allicq = array('qq', 'msn', 'wangwang', 'baiduhi', 'skype');
			$icq = trim($brand_config['icq']); 
			$icq = !in_array($icq, $allicq) ? 'qq' : $icq;
			$qqcode = trim($brand_config['qqcode']); 
			$msncode = trim($brand_config['msncode']); 
			$wangwangcode = trim($brand_config['wangwangcode']); 
			$baiduhicode = trim($brand_config['baiduhicode']); 
			$skypecode = trim($brand_config['skypecode']);
			$icqshow = $icq.'code'; 
			$icqshow = $$icqshow;
							
			$config = $_G['cache']['plugin']['sanree_brand_coupon'];
			if (!$config['isopen']) {
			
				return;
				
			}
			$bindingforum = intval($config['bindingforum']);
			if ($bindingforum<1) return;
			if ($bindingforum != $thread['fid']) {	
			
				return;
				
			}

			if($data['caller'] == 'discuzcode') {
					
			    $tid = intval($thread['tid']);
				$template = trim($config['template']);
				$template = empty($template) ? 'default' : $template;				
			    $couponresult = C::t('#sanree_brand_coupon#sanree_brand_coupon')->getcoupon_by_tid($tid);
				if ($couponresult&&$data['param'][12]==intval($couponresult['pid'])) {
				
					$modfile = DISCUZ_ROOT.'./source/plugin/sanree_brand/function/function_core.php';
					@require_once($modfile);				
				    $couponresult['gpicture'] = coupon_getforumimg($couponresult['homeaid'], 1 , 500, 565, 'fixnone');
					$couponresult['dateline'] = ($couponresult['dateline']) ? dgmdate($couponresult['dateline']) : '';
					$hookhtml = coupon_modlang('hookhtml');
					$hookhtml = str_replace('{viewnum}', intval($couponresult['viewnum']), $hookhtml );
					$hookhtml = str_replace('{downnum}', intval($couponresult['downnum']), $hookhtml );	
					$couponresult['icq'] = '';
					$couponresult['url'] = getmyburl_by_bid($couponresult['bid']);
					if ($ismultiple==1&&$couponresult['allowmultiple']==1) {
						$couponresult['icq'] = getallicq($couponresult[$icq]);
						$couponresult['tel'] = getfirsticq($couponresult['tel']);
						$couponresult['qq'] = getfirsticq($couponresult['qq']);
						$couponresult['msn'] = getfirsticq($couponresult['msn']);
						$couponresult['wangwang'] = getfirsticq($couponresult['wangwang']);
						$couponresult['baiduhi'] = getfirsticq($couponresult['baiduhi']);
						$couponresult['skype'] = getfirsticq($couponresult['skype']);	
						$couponresult['qq'] = empty($couponresult[$icq]) ? '' : str_replace('{icqnumber}',getfirsticq($couponresult[$icq]), $icqshow);			
					} else {
						$couponresult['qq'] = empty($couponresult['qq']) ? srlang('zanwustr') : str_replace('{icqnumber}',getfirsticq($couponresult['qq']), $icqshow);
						$couponresult['tel'] = getfirsticq($couponresult['tel']);
					}								
					include template('sanree_brand_coupon:discuzcode');
					$sreturn = str_replace(array("\r\n","  ",'###srcouponcontent###','###srcouponcondition###'), array('', '', $couponresult['content'], $couponresult['condition']), $sreturn);
					$_G['discuzcodemessage'] = trim($sreturn);
					
				}	
			}
			
	  }
	function sanreebrandusermenu($param){
	
		global $_G;
		$config = $_G['cache']['plugin']['sanree_brand_coupon'];
		if (!$config['isopen']) {
		
			return;
			
		}		
		if ($param['bid']<1) {
			return;
		}
		$iscoupon = C::t('#sanree_brand#sanree_brand_businesses_module')->fetch_by_modename('iscoupon', $param['bid']);	
		if ($iscoupon!=1) {
		
			return;
			
		}	
		$modulemenuname = empty($config['modulemenuname']) ? coupon_modlang('itemcoupon') : $config['modulemenuname'];
		$_G['sanree_brand_menus']['coupon'] = array('name'=>'coupon', 'title'=> $modulemenuname, 'url'=>coupon_getusermodeurl($param),'class' => ' class="normal"');
		
	}
		  
}

//class plugin_identifier_CURSCRIPT extends plugin_identifier {

class plugin_sanree_brand_coupon_plugin extends plugin_sanree_brand_coupon {
///function CURMODULE_USERDEFINE[_output]()
	function sanree_brand_userbar(){
	
		global $_G;
		$actives = array();
		$view = '';
		if ($_G['sr_id']=='sanree_brand_coupon') {
			$view = ' class="a"';
		}
		$config = $_G['cache']['plugin']['sanree_brand_coupon'];
		if (!$config['isopen']) {
		
			return;
			
		}
		$gcount[0] = C::t('#sanree_brand_coupon#sanree_brand_coupon')->count_by_wherec(array('t.uid='.$_G['uid'],'c.status=1','t.status=1'));
		$gcount[1] = C::t('#sanree_brand_coupon#sanree_brand_coupon')->count_by_wherec(array('t.uid='.$_G['uid'],'c.status=1','t.status=0'));
		$gcount[2] = C::t('#sanree_brand_coupon#sanree_brand_coupon')->count_by_wherec(array('t.uid='.$_G['uid'],'c.status=1','t.status=-1'));
		$gcount[3] = $gcount[0] + $gcount[1] +$gcount[2];		
		$result = '<li'.$view.'><a href="plugin.php?id=sanree_brand_coupon&mod=mycoupon&view=index">'.lang('plugin/sanree_brand_coupon','mycoupon').'('.$gcount[3].')</a></li>';
		return $result;
		
	}
		
}

class plugin_sanree_brand_coupon_forum extends plugin_sanree_brand_coupon {

    function viewthread_postfooter_output(){
	
	    global $_G;
		$config = $_G['cache']['plugin']['sanree_brand_coupon'];
		if (!$config['isopen']) {
		
		    return;
			
		}
		if ($_G[uid]==1) return;
		$action = $_GET['action'];
		$bindingforum = intval($config['bindingforum']);
		if ($bindingforum<1) return;
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
			
	}
	
	function viewthread_title_extra_output() {
	    global $_G;
		$config = $_G['cache']['plugin']['sanree_brand_coupon'];
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
		$config = $_G['cache']['plugin']['sanree_brand_coupon'];
		if (!$config['isopen']) {
		
		    return;
			
		}
		if ($_G[uid]==1) return;
		$action = $_GET['action'];
		$bindingforum = intval($config['bindingforum']);
		if ($bindingforum<1) return;
		if ((CURSCRIPT == 'forum') && $bindingforum == $_G['fid']) {
		
		   $fastpost = 0;
		   
		}
		
	}
	
	function viewthread_middle_output() {
	
	    global $_G,$allowfastpost,$thread;
		$config = $_G['cache']['plugin']['sanree_brand_coupon'];
		if (!$config['isopen']) {
		
		    return;
			
		}
		if ($_G[uid]==1) return;
		$action = $_GET['action'];
		$bindingforum = intval($config['bindingforum']);
		if ($bindingforum<1) return;
		if ((CURSCRIPT == 'forum') && $bindingforum == $_G['fid']) {
		
		   $result = C::t('#sanree_brand_coupon#sanree_brand_coupon')->getcoupon_by_tid($thread['tid']);
		   if ($result['allowreply'] != 1) {
		   
			   $allowfastpost = FALSE;
			   
		   }
		   
		}
		
	}	
	function viewthread(){
	
	    global $_G;
		$config = $_G['cache']['plugin']['sanree_brand_coupon'];
		if (!$config['isopen']) {
		
		    return;
			
		}
		if ($_G[uid]==1) return;
		$bindingforum = intval($config['bindingforum']);
		if ($bindingforum<1) return;
				
		if ((CURSCRIPT == 'forum') && $bindingforum == $_G['fid']) {
		
			$allowgroup = unserialize($config['allowgroup']);
			$groupid = $_G['group']['groupid'];
			if (!in_array($groupid, $allowgroup)) {
			
				showmessage(coupon_modlang('stopallowtip'));
				
			}
			$viewgroup = unserialize($config['viewgroup']);
			if (!in_array($groupid, $viewgroup)) {
			
				showmessage(coupon_modlang('stopviewtip'));
				
			}
			
		}
		
	}
		
	function post() {
	
	    global $_G, $mod;
		$config = $_G['cache']['plugin']['sanree_brand_coupon'];
		if (!$config['isopen']) {
		
		    return;
			
		}
		if ($_G[uid]==1) return;
		$action = $_GET['action'];
		$bindingforum = intval($config['bindingforum']);
		if ($bindingforum<1) return;
		if ((CURSCRIPT == 'forum') && ($mod == 'post') && $bindingforum == $_G['fid']) {
		
		   if ($action != 'reply') {
		   
			   showmessage('postperm_none_nopermission');
			   
		   }
		   $gresult = C::t('#sanree_brand_coupon#sanree_brand_coupon')->getcoupon_by_tid($_G['tid']);
		   if (!$gresult) {
		   
			   showmessage(lang('plugin/sanree_brand_coupon', 'nofastpostcontrol'));
			   
		   }
		   $result = C::t('#sanree_brand#sanree_brand_businesses')->getbusinesses_by_bid($gresult[bid]);
		   if ($result['allowfastpost'] != 1) {
		   
			   showmessage(lang('plugin/sanree_brand_coupon', 'nofastpostcontrol'));
			   
		   }
		   
		}
			
	} 
	
}
class plugin_sanree_brand_coupon_home extends plugin_sanree_brand_coupon {

	function spacecp_credit_top_output() {
	
		global $_G;
		lang('spacecp');		
		$_G['lang']['spacecp']['COU_credit'] = lang('plugin/sanree_brand_coupon', 'COU');
		$_G['lang']['spacecp']['logs_credit_update_COU'] = lang('plugin/sanree_brand_coupon', 'COU');
		
	} 
	
}
//From:www_YMG6_COM
?>