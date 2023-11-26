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
define('$pidentifier', 'forumname');
$modfile=DISCUZ_ROOT.'./source/plugin/sanree_brand/function/function_core.php';
@require_once($modfile);
$modfile=DISCUZ_ROOT.'./source/plugin/sanree_brand_forumname/function/function_core.php';
@require_once($modfile);

class plugin_sanree_brand_forumname {

	function sidetopout(){
	
	    global $_G, $postlist;
		$brand_config = $_G['cache']['plugin']['sanree_brand'];
		if (!$brand_config['isopen']) {
		
		    return array();
			
		}	
		$config = $_G['cache']['plugin']['sanree_brand_forumname'];
		if (!$config['isopen']) {
		
		    return array();
			
		}
		$brandtitle = trim($config['brandtitle']);	
		$vipgroup = trim($config['vipgroup']);
		$color1 = isset($config['color1']) ? trim($config['color1']) : '#000000';
		$color2 = isset($config['color2']) ? trim($config['color2']) : '#0000FF';
		$color3 = isset($config['color3']) ? trim($config['color3']) : '#009900';
		$color4 = isset($config['color4']) ? trim($config['color4']) : '#FF0000';
		$vipgroup = str_replace(lang('plugin/sanree_brand_forumname', 'comma'), ',', $vipgroup);
		$vipgroup = preg_replace('/[^0-9,]/', '', $vipgroup);
		$vipgroup = array_filter(explode(",", $vipgroup));
		$return = array();
		foreach($postlist as $key =>$post){
 
			$brandlist = C::t('#sanree_brand#sanree_brand_businesses')->fetch_all_by_searche(array('t.uid='.intval($post['uid']), 'c.status=1', 't.status=1'), 'displayorder,dateline desc', 0, 20);	
			$brandcount = count($brandlist);
			$allbrand = array();
			foreach($brandlist as $value) {
				
				$color = $color1;
				if (in_array($value['groupid'], $vipgroup)) $color = $color2;
				if (intval($value['isrecommend'])==1) $color = $color3;
				if (intval($value['istop'])==1) $color = $color4;
				$allbrand[] = array(
					'name' => $value['name'],
					'url' => getburl($value),
					'color' => $color
				);
				
			}
			include template('sanree_brand_forumname:viewthread_sidetop');
			$return[]=trim($sreturn);	
		
		}	
		$return[0].= '<link href="source/plugin/sanree_brand_forumname/template/sanree_brand_forumname.css" rel="stylesheet" type="text/css" />';
		$return[0].= '<script src="source/plugin/sanree_brand_forumname/template/js/sanree_brand_forumname.js" type="text/javascript"></script>';
		return $return;	

	}
		  
}

class plugin_sanree_brand_forumname_forum extends plugin_sanree_brand_forumname {

    function viewthread_sidetop_output(){
	
		return parent::sidetopout();
		
	}
	
}
//From:www_YMG6_COM
?>