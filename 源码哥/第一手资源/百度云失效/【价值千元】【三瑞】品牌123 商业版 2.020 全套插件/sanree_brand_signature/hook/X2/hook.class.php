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
define('$pidentifier', 'signature');
$modfile=DISCUZ_ROOT.'./source/plugin/sanree_brand/function/function_core.php';
@require_once($modfile);
$modfile=DISCUZ_ROOT.'./source/plugin/sanree_brand_signature/function/function_core.php';
@require_once($modfile);

class plugin_sanree_brand_signature {

	function sanreebrandmanagemenu($param){
	
		global $_G;
		$config = $_G['cache']['plugin']['sanree_brand_signature'];
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
		
		$_G['sanree_brand_managemenus'][] = array(
			'displayorder'=> 500, 
			'window' => 0,
			'name'=>'mysignature', 
			'title'=> signature_modlang('mysignature'), 
			'url'=> 'plugin.php?id=sanree_brand_signature&mod=mysignature',
			'class' => '',
			'image' => 'source/plugin/sanree_brand_signature/tpl/default/images/mysignature.png'
		);
		
	}
	
	function threadout(){
	
	    global $_G, $thread;
		$brand_config = $_G['cache']['plugin']['sanree_brand'];
		if (!$brand_config['isopen']) {
		
		    return '';
			
		}	
		$selectdiscount = $brand_config['selectdiscount'];
		$marr = explode("\r\n", $selectdiscount);
		$brand_config['selectdiscountshow'] = array();
		foreach($marr as $row) {
		
			list($key , $val) = explode("=", $row);
			$brand_config['selectdiscountshow'][$key] = $val;
			
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
		$config = $_G['cache']['plugin']['sanree_brand_signature'];
		if (!$config['isopen']) {
		
		    return '';
			
		}
		$copyrightpass = trim($config['copyrightpass']);
		$copyrightshow = $copyrightpass=='www.fx8.cc' ? 0 : 1;		
		$viewsgroup = unserialize($config['viewsgroup']);
		$groupid = $_G['group']['groupid'];
		if (!in_array($groupid, $viewsgroup)) {
		
			return '';
			
		}
		$isallforums = intval($config['isallforums']);
		if ($isallforums!=1) {
			$showforums = unserialize($config['showforums']);
			if (!in_array($_G['fid'], $showforums)) {
			
				return '';
				
			}	
		}	
		$authorid = intval($thread['authorid']);
		if ($authorid <1) return '';			
		$signature = C::t('#sanree_brand_signature#sanree_brand_signature')->fetch_first_by_uid($authorid);
		if (intval($signature['allowshowsignature'])!=1) {
			return '';
		}		
		$value = C::t('#sanree_brand#sanree_brand_businesses')->getbusinesses_by_bid($signature['bid']);
		if ((!$value)&&($isallforums==1)) {
			$condition = array('t.uid = '.$thread['authorid'], 't.status=1');
			$orderby = 't.istop desc,t.displayorder,t.dateline desc';
			$start = 0;
			$ppp = 1;
			$allbrandlist = C::t('#sanree_brand#sanree_brand_businesses')->fetch_all_by_searchc($condition, $orderby, $start, $ppp);
			if (!$allbrandlist) return '';
			$value = $allbrandlist[0];		
		}
		
		if (!$value) return '';
		$value['poster'] = srfiximages($value['poster'], 'category', '/none.gif');
		$value['weburl'] = str_replace('http://','',$value['weburl']);	
		$value['propaganda'] = empty($value['propaganda']) ? srlang('zanwustr') : discuzcode($value['propaganda']);
		$value['introduction'] = empty($value['introduction']) ? srlang('zanwustr') : discuzcode($value['introduction']);
		$value['contact'] = empty($value['contact']) ? srlang('zanwustr') : discuzcode($value['contact']);
		$value['cateurl'] = getcateurl(array('tid' => $value['cateid']),TRUE);
		$value['url'] = getburl($value);
		$value['alt']  = str_replace('{catename}', $value['name'], srlang('weburltip'));
		$value['addtime'] = dgmdate($value['dateline'],'d');
		$value['forum_thread'] = C::t('#sanree_brand#forum_thread')->fetch($value['tid']);
		$value['weburlstr'] = empty($value['weburl']) ? srlang('zanwustr') : '<a href="http://'.$value[weburl].'" rel="nofollow" target="_blank" title="'.$value[alt].'">'.$value[weburl].'</a>';
		$value['address'] = empty($value['address']) ? srlang('zanwustr') : $value['address'];
		$value['recommendationindex'] = empty($value['recommendationindex']) ? '99.9' : $value['recommendationindex'];
		$value['class'] = $value['istop'] ? 'dtop': '';
		$value['class'] = empty($value['class']) && $value['isrecommend'] ? 'drec': $value['class'];
		$value['discount'] = intval($value['discount']);
		$managethis = false;
		if ($value['uid']==$_G['uid']) {
			$managethis = true;
		}	
		$value['icq'] = '';
		if ($ismultiple==1&&$value['allowmultiple']==1) {
			$value['icq'] = getallicq($value[$icq]);
			$value['tel'] = getfirsticq($value['tel']);
			$value['qq'] = getfirsticq($value['qq']);
			$value['msn'] = getfirsticq($value['msn']);
			$value['wangwang'] = getfirsticq($value['wangwang']);
			$value['baiduhi'] = getfirsticq($value['baiduhi']);
			$value['skype'] = getfirsticq($value['skype']);	
			$value['qq'] = empty($value[$icq]) ? '' : str_replace('{icqnumber}',getfirsticq($value[$icq]), $icqshow);			
		} else {
			$value['qq'] = empty($value['qq']) ? srlang('zanwustr') : str_replace('{icqnumber}',getfirsticq($value['qq']), $icqshow);
			$value['tel'] = getfirsticq($value['tel']);
		}			
		$brandresult = array(
		    'brand_name' 			=> $value['name'],
			'brand_poster' 		=> $value['poster'],
			'brand_propaganda' 	=> $value['propaganda'],
			'brand_cateurl' 		=> $value['cateurl'],
			'brand_addtime' 		=> $value['addtime'],
			'brand_weburlstr' 	=> $value['weburlstr'],
			'brand_tel114url' 	=> $value['tel114url'],
			'brand_catename'		=> $value['catename'],
			'brand_uid'			=> $value['uid'],
			'brand_tid'			=> $value['tid'],
			'brand_url'			=> $value['url'],
			'brand_username'		=> $value['username'],
			'brand_qq'			=> $value['qq'],
			'brand_icq'			=> $value['icq'],
			'brand_address'		=> $value['address'],
			'brand_groupid'		=> $value['groupid'],
			'brand_groupimg'		=> getgroupimg($value['groupid']),
			'brand_region'		=> $value['region'],
			'brand_tel'			=> $value['tel'],
			'brand_discount'	=> $brand_config['selectdiscountshow'][$value['discount']],
			'brand_recommendationindex'		=> $value['recommendationindex'],
			'brand_views' 	=> $value['views'],
			'brand_isrecommend' 	=> $value['isrecommend'],
		);
		include template('sanree_brand_signature:viewthread_modaction');
		$template=trim($sreturn);		
		return $template; 			
	}
	
	function postsightmlafterout(){
	
	    global $_G, $postlist;
		$brand_config = $_G['cache']['plugin']['sanree_brand'];
		if (!$brand_config['isopen']) {
		
		    return array();
			
		}						
		$config = $_G['cache']['plugin']['sanree_brand_signature'];
		if (!$config['isopen']) {
		
		    return array();
			
		}
		if (!$config['isreply']) {
		
		    return array();
			
		}		
		$viewsgroup = unserialize($config['viewsgroup']);
		$groupid = $_G['group']['groupid'];
		if (!in_array($groupid, $viewsgroup)) {
		
			return array();
			
		}
		$isallforums = intval($config['isallforums']);
		if ($isallforums!=1) {
			$showforums = unserialize($config['showforums']);
			if (!in_array($_G['fid'], $showforums)) {
			
				return array();
				
			}	
		}	
		$return = array();
		foreach($postlist as $key =>$post){

			$authorid = intval($post['authorid']);
			if ($authorid <1) {
			    $return[] = '';
				continue;
			}
			$signature = C::t('#sanree_brand_signature#sanree_brand_signature')->fetch_first_by_uid($authorid);
			if (intval($signature['allowshowsignature'])!=1) {
			    $return[] = '';
				continue;
			}
			$value = C::t('#sanree_brand#sanree_brand_businesses')->getbusinesses_by_bid($signature['bid']);
			if ((!$value)&&($isallforums==1)) {
				$condition = array('t.uid = '.$authorid, 't.status=1');
				$allbrandlist = C::t('#sanree_brand#sanree_brand_businesses')->fetch_all_by_searchc($condition, 't.istop desc,t.displayorder,t.dateline desc', 0, 1);	
				if (!$allbrandlist) {
					$return[] = '';
					continue;
				}
				$value = $allbrandlist[0];	
			}
			if (!$value) {
				$return[] = '';
				continue;
			}
			$brandresult = array(
				'brand_name' 		=> $value['name'],
				'brand_url'			=> getburl($value),
				'brand_tel'			=> getfirsticq($value['tel'])				
			);
			include template('sanree_brand_signature:viewthread_reply');
			$return[]=trim($sreturn);	
		
		}
		$return[0] = '';
		return $return;		

	}			  
}

class plugin_sanree_brand_signature_forum extends plugin_sanree_brand_signature {

    function viewthread_postbottom_output(){
	
	    global $page;	
		$return = parent::postsightmlafterout();
		$return[0] = parent::threadout();
		return $return;
		
	}
	
}
class plugin_sanree_brand_signature_plugin extends plugin_sanree_brand_signature {
///function CURMODULE_USERDEFINE[_output]()
	function sanree_brand_userbar(){
	
		global $_G;
		$actives = array();
		$view = '';
		if ($_G['sr_id']=='sanree_brand_signature') {
			$view = ' class="a"';
		}
		
		$config = $_G['cache']['plugin']['sanree_brand_signature'];
		if (!$config['isopen']) {
		
			return;
			
		}
		$bids = array();
		foreach(C::t('#sanree_brand#sanree_brand_businesses')->fetch_all_by_search("AND uid=$_G[uid]",'displayorder',0,1000) as $data) {
			$bids[] = $data['bid'];
		}
		$result = '<li'.$view.'><a href="plugin.php?id=sanree_brand_signature&mod=mysignature&view=list">'.lang('plugin/sanree_brand_signature','mysignature').'</a></li>';
		return $result;
		
	}
		
}
//From:www_YMG6_COM
?>