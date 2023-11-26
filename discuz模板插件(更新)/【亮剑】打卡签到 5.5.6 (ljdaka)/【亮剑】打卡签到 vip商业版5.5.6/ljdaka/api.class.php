<?php

/*
 * CopyRight  : [www.moqu8.com!] (C)2014-2015
 * Document   : Ä§È¤°É£ºwww.moqu8.com
 * Created on : 2015-01-17,21:45:40
 * Author     : Ä§È¤°É(QQ£º10373458)  $
 * Description: This is NOT a freeware, use is subject to license terms.
 *              Ä§È¤°É³öÆ· ±ØÊô¾«Æ·¡£
 *              Ä§È¤°ÉÔ´ÂëÂÛÌ³ È«ÍøÊ×·¢ http://www.moqu8.com£»
 */
if (!defined('IN_DISCUZ')) {
    exit('Access Denied');
}

class ljdaka_api {
	function forumdisplay_mobilesign() {
		require_once DISCUZ_ROOT.'./source/plugin/wechat/wechat.lib.class.php';
		$url = WeChatHook::getPluginUrl('ljdaka:ranklist');
		$return = array(
		 'text' => lang('plugin/ljdaka', 'm2'),
		 'link' => $url,
		);
		return $return;
	}

}

?>
