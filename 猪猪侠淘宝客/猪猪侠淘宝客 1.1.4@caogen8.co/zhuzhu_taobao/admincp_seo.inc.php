<?php

/**
 *      [Caogen8!] (C)2014-2018 Www.Caogen8.co.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: admincp_seo.inc.php 29364 2014-03-22 11:26:33Z mpage $
 */

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}

$lang = array_merge($lang, $scriptlang['zhuzhu_taobao']);

if(empty($_GET['ac'])) {

	if(!submitcheck('seosubmit')) {

		echo '<script type="text/javascript">
		function insertContent(obj, text) {
			var obj = obj.parentNode.parentNode.firstChild.lastChild;
			selection = document.selection;
			obj.focus();
			if(!isUndefined(obj.selectionStart)) {
				var opn = obj.selectionStart + 0;
				obj.value = obj.value.substr(0, obj.selectionStart) + text + obj.value.substr(obj.selectionEnd);
			} else if(selection && selection.createRange) {
				var sel = selection.createRange();
				sel.text = text;
				sel.moveStart(\'character\', -strlen(text));
			} else {
				obj.value += text;
			}
		}
		</script>';

		$zhuzhu_seo = dunserialize($_G['setting']['zhuzhu_seo']);
		$page = array(
			'index' => array(),
			'tbk' => array(),
			'uatm' => array(),
			'brand' => array(),
			'quan' => array(),
			'tqg' => array(),
		);
		showformheader('plugins&operation=config&do='.$plugin['pluginid'].'&identifier=zhuzhu_taobao&pmod=admincp_seo');
		showtableheader();
		foreach($page as $key => $value) {
			$code = cplang('seokeytip');
			foreach($value as $v) {
				$code .= '<a onclick="insertContent(this, \'{'.$v.'}\');return false;" href="javascript:;" title="'.cplang($v).'">{'.cplang($v).'}</a>';
			}
			showtitle('page_'.$key);
			showsetting('seotitle', 'zhuzhu_seo['.$key.'][seotitle]', $zhuzhu_seo[$key]['seotitle'], 'text', '', 0, '');
			showsetting('seokeywords', 'zhuzhu_seo['.$key.'][seokeywords]', $zhuzhu_seo[$key]['seokeywords'], 'text', '', 0, $code);
			showsetting('seodescription', 'zhuzhu_seo['.$key.'][seodescription]', $zhuzhu_seo[$key]['seodescription'], 'text', '', 0, '');
		}
		showsubmit('seosubmit');
		showtablefooter();
		showformfooter();

	} else {

		C::t('common_setting')->update('zhuzhu_seo', $_GET['zhuzhu_seo']);
		updatecache('setting');

		cpmsg('seo_update_succeed', 'action=plugins&operation=config&do='.$plugin['pluginid'].'&identifier=zhuzhu_taobao&pmod=admincp_seo', 'succeed');
	}
}
//From:www_caogen8_co
?>