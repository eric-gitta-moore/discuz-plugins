<?php

/**
 *      [Caogen8!] (C)2014-2018 Www.Caogen8.co.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: admincp_brand.inc.php 33234 2017-08-08 11:30:14Z ²Ý-¸ù-°É $
 */

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}

$lang = array_merge($lang, $scriptlang['zhuzhu_taobao']);
loadcache(array('zhuzhu_taobao_cat', 'plugin'));

if(empty($_GET['ac'])) {

	if(!submitcheck('listsubmit')) {

		showformheader('plugins&operation=config&identifier=zhuzhu_taobao&pmod=admincp_cat');
		showtableheader();
		showsubtitle(array('del', 'displayorder', 'name', 'tb_cat', 'keyword', ''));
		foreach($_G['cache']['zhuzhu_taobao_cat'] as $value) {
			showtablerow('', array('class="td25"', 'class="td25"', 'class="td26"', ''), array(
				'<input type="checkbox" class="checkbox" name="delete[]" value="'.$value['cat_id'].'" />',
				'<input type="text" class="txt" name="displayorder['.$value['cat_id'].']" value="'.$value['displayorder'].'" />',
				'<input type="text" class="td23" name="name['.$value['cat_id'].']" value="'.$value['name'].'" />',
				'<input type="text" class="td23" name="tb_cat['.$value['cat_id'].']" value="'.$value['tb_cat'].'" />',
				'<input type="text" class="td23" name="tb_key['.$value['cat_id'].']" value="'.$value['tb_key'].'" />',
				'<input type="checkbox" class="checkbox" name="available['.$value['cat_id'].']" value="1"'.($value['available'] ? 'checked="checked"' : '').' />',
			));
		}
		echo '<tr><td></td><td colspan="20"><div><a href="http://t.cn/RvMznky##" onclick="addrow(this, 0)" class="addtr">'.cplang('add_cat').'</a></div></td></tr>';
		showsubmit('listsubmit', 'submit', 'del');
		showtablefooter();
		showformfooter();
		echo '<script type="text/javascript">var rowtypedata = [[[1, \'\', \'td25\'], [1, \'<input type="text" class="txt" name="newdisplayorder[]" />\', \'td25\'], [1, \'<input type="text" class="txt" name="newname[]" />\', \'\'], [1, \'<input type="text" class="txt" name="newtb_cat[]" />\', \'\'], [1, \'<input type="text" class="txt" name="newtb_key[]" />\', \'\']]];</script>';

	} else {

		if(is_array($_GET['delete'])) {
			C::t('#zhuzhu_taobao#zhuzhu_taobao_cat')->delete($_GET['delete']);
		}

		if(is_array($_GET['name'])) {
			foreach($_GET['name'] as $key => $value) {
				C::t('#zhuzhu_taobao#zhuzhu_taobao_cat')->update($key, array(
					'displayorder' => $_GET['displayorder'][$key],
					'name' => $_GET['name'][$key],
					'tb_cat' => $_GET['tb_cat'][$key],
					'tb_key' => $_GET['tb_key'][$key],
					'available'    => $_GET['available'][$key],
				));
			}
		}

		if(is_array($_GET['newname'])) {
			foreach($_GET['newname'] as $key => $value) {
				if(empty($value)) continue;
				C::t('#zhuzhu_taobao#zhuzhu_taobao_cat')->insert(array(
					'displayorder' => $_GET['newdisplayorder'][$key],
					'name' => $_GET['newname'][$key],
					'tb_cat' => $_GET['newtb_cat'][$key],
					'tb_key' => $_GET['newtb_key'][$key],
					'available'    => 1,
				));
			}
		}

		$query = C::t('#zhuzhu_taobao#zhuzhu_taobao_cat')->fetch_all_by_displayorder('', '', '', '', '');
		foreach($query as $value) {
			$zhuzhu_taobao_cat[$value['cat_id']] = $value;
		}
		savecache('zhuzhu_taobao_cat', $zhuzhu_taobao_cat);

		cpmsg('update_succeed', 'action=plugins&operation=config&identifier=zhuzhu_taobao&pmod=admincp_cat', 'succeed');
	}
}
//From:www_caogen8_co
?>
