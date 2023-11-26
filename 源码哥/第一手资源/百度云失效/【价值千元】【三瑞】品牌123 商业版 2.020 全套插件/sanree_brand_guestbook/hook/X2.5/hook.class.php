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
$modfile=DISCUZ_ROOT.'./source/plugin/sanree_brand_guestbook/function/function_core.php';
@require_once($modfile);

class plugin_sanree_brand_guestbook {

	function sanreebrandmanagemenu($param){
	
		global $_G;
		$config = $_G['cache']['plugin']['sanree_brand_guestbook'];
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
		$isguestbook = C::t('#sanree_brand#sanree_brand_businesses_module')->fetch_by_modename('isguestbook', $param['bid']);	
		if ($isguestbook!=1) {
		
			return;
			
		}		
		$_G['sanree_brand_managemenus'][] = array(
			'displayorder'=> 400, 
			'window' => 0,
			'name'=>'mygoods', 
			'title'=> guestbook_modlang('myguestbook'), 
			'url'=> 'plugin.php?id=sanree_brand_guestbook&mod=myguestbook',
			'class' => '',
			'image' => 'source/plugin/sanree_brand_guestbook/tpl/default/images/myguestbook.png'
		);
		
	}

	function sanreebrandusermenu($param){
	
		global $_G;
		$config = $_G['cache']['plugin']['sanree_brand_guestbook'];
		if (!$config['isopen']) {
		
			return;
			
		}		
		if ($param['bid']<1) {
			return;
		}
		$isguestbook = C::t('#sanree_brand#sanree_brand_businesses_module')->fetch_by_modename('isguestbook', $param['bid']);	
		if ($isguestbook!=1) {
		
			return;
			
		}	
		$modulemenuname = empty($config['modulemenuname']) ? lang('plugin/sanree_brand_guestbook','itemguestbook') : $config['modulemenuname'];
		$_G['sanree_brand_menus']['guestbook'] = array('name'=>'guestbook', 'title'=>$modulemenuname, 'url'=>guestbook_getmodeurl($param),'class' => ' class="normal"');
		
	}	  

}

//class plugin_identifier_CURSCRIPT extends plugin_identifier {

class plugin_sanree_brand_guestbook_plugin extends plugin_sanree_brand_guestbook {
///function CURMODULE_USERDEFINE[_output]()
	function sanree_brand_userbar(){
	
		global $_G;
		$actives = array();
		$view = '';
		if ($_G['sr_id']=='sanree_brand_guestbook') {
			$view = ' class="a"';
		}
		
		$config = $_G['cache']['plugin']['sanree_brand_guestbook'];
		if (!$config['isopen']) {
		
			return;
			
		}
		$bids = array();
		foreach(C::t('#sanree_brand#sanree_brand_businesses')->fetch_all_by_search("AND uid=$_G[uid]",'displayorder',0,1000) as $data) {
			$bids[] = $data['bid'];
		}
		$gcount = array();
		$result = '';
		if (count($bids)>0) {
		
			$wherebids = implode($bids, ',');
			$gcount[0] = C::t('#sanree_brand_guestbook#sanree_brand_guestbook')->count_by_where(array('bid in ('.$wherebids.')', 'status=1'));
			$gcount[1] = C::t('#sanree_brand_guestbook#sanree_brand_guestbook')->count_by_where(array('bid in ('.$wherebids.')', 'status=0'));
			$gcount[3] = $gcount[0] + $gcount[1];
		    $result = '<li'.$view.'><a href="plugin.php?id=sanree_brand_guestbook&mod=myguestbook&view=list">'.lang('plugin/sanree_brand_guestbook','myguestbook').'('.intval($gcount[3]).')</a></li>';
			
		}		
		return $result;
		
	}
		
}
//From:www_YMG6_COM
?>