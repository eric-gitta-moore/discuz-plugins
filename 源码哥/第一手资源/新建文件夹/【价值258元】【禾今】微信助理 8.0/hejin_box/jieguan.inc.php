<?php
/*
 * 出处：源码哥
 * 官网: Www.fx8.cc
 * 备用网址: www.ymg6.com (请收藏备用!)
 * 技术支持/更新维护：QQ 154606914
 * 
 */
if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
require_once DISCUZ_ROOT.'./source/plugin/hejin_box/config.inc.php';
$model = addslashes($_GET['model']);
if(empty($model)){
	include template('hejin_box:admin/jieguan');
}

elseif($model=='jieguan'){
	if($_GET['formhash']==FORMHASH){
		if(file_exists(DISCUZ_ROOT . './source/plugin/wechat/wechat.lib.class.php')){
			require_once DISCUZ_ROOT . './source/plugin/wechat/wechat.lib.class.php';
			
			$receiveMsg = array(
    			'receiveMsg::text' => array('plugin' => 'hejin_box', 'include' => 'hejin_box.inc.php', 'class' => 'wxboxApi', 'method' => 'respond'),
				'receiveMsg::voice' => array('plugin' => 'hejin_box', 'include' => 'hejin_box.inc.php', 'class' => 'wxboxApi', 'method' => 'respond'),
    			'receiveMsg::image' => array('plugin' => 'hejin_box', 'include' => 'hejin_box.inc.php', 'class' => 'wxboxApi', 'method' => 'respond'),
    			'receiveEvent::subscribe' => array('plugin' => 'hejin_box', 'include' => 'hejin_box.inc.php', 'class' => 'wxboxApi', 'method' => 'respond'),
    			'receiveEvent::unsubscribe' => array('plugin' => 'hejin_box', 'include' => 'hejin_box.inc.php', 'class' => 'wxboxApi', 'method' => 'respond'),
				'receiveEvent::location' => array('plugin' => 'hejin_box', 'include' => 'hejin_box.inc.php', 'class' => 'wxboxApi', 'method' => 'respond'),
    			'receiveEvent::click' => array('plugin' => 'hejin_box', 'include' => 'hejin_box.inc.php', 'class' => 'wxboxApi', 'method' => 'respond'),
    			'receiveEvent::scan' => array('plugin' => 'hejin_box', 'include' => 'hejin_box.inc.php', 'class' => 'wxboxApi', 'method' => 'respond'),
			
			);
			
			WeChatHook::updateResponse($receiveMsg);
			WeChatHook::updateRedirect(array('plugin' => 'wechat', 'include' => 'response.class.php', 'class' => 'WSQResponse', 'method' => 'redirect'));
//			WeChatHook::updateViewPluginId('hejin_box');
			cpmsg(lang('plugin/hejin_box', 'jieguanok'), 'action=plugins&operation=config&do=' . $_GET['do'] . '&identifier=hejin_box&pmod=jieguan', 'succeed');


		}else{
			echo lang('plugin/hejin_box', 'jieguanno');
		}
	}
}

//WWW.fx8.cc
?>