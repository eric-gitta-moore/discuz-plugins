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
loadcache(array('zhuzhu_taobao_brand', 'zhuzhu_taobao_category', 'plugin'));
@include DISCUZ_ROOT.'./data/sysdata/cache_zhuzhu_taobao_category.php';
$category = $_G['cache']['zhuzhu_taobao_category'] = $zhuzhu_taobao_category;

if(empty($_GET['ac'])) {

	if(!submitcheck('listsubmit')) {

		showformheader('plugins&operation=config&identifier=zhuzhu_taobao&pmod=admincp_brand');
		showtableheader();
		showsubtitle(array('del', 'displayorder', 'name', 'keyword', 'category', ''));
		foreach($_G['cache']['zhuzhu_taobao_brand'] as $value) {
			showtablerow('', array('class="td25"', 'class="td25"', 'class="td26"', ''), array(
				'<input type="checkbox" class="checkbox" name="delete[]" value="'.$value['brand_id'].'" />',
				'<input type="text" class="txt" name="displayorder['.$value['brand_id'].']" value="'.$value['displayorder'].'" />',
				'<input type="text" class="td23" name="name['.$value['brand_id'].']" value="'.$value['name'].'" />',
				'<input type="text" class="td23" name="keyword['.$value['brand_id'].']" value="'.$value['keyword'].'" />',
				$category[$value['category_id']]['name'],
				'<a href="admin.php?action=plugins&operation=config&identifier=zhuzhu_taobao&pmod=admincp_brand&ac=edit&id='.$value['brand_id'].'" class="act">'.cplang('edit').'</a>',
			));
		}
		echo '<tr><td></td><td colspan="20"><div><a href="http://t.cn/RvMznky##" onclick="addrow(this, 0)" class="addtr">'.cplang('add_brand').'</a></div></td></tr>';
		showsubmit('listsubmit', 'submit', 'del');
		showtablefooter();
		showformfooter();
		echo '<script type="text/javascript">var rowtypedata = [[[1, \'\', \'td25\'], [1, \'<input type="text" class="txt" name="newdisplayorder[]" />\', \'td25\'], [1, \'<input type="text" class="txt" name="newname[]" />\', \'\'], [1, \'<input type="text" class="txt" name="newkeyword[]" />\', \'\']]];</script>';

	} else {

		if(is_array($_GET['delete'])) {
			C::t('#zhuzhu_taobao#zhuzhu_taobao_brand')->delete($_GET['delete']);
		}

		if(is_array($_GET['name'])) {
			foreach($_GET['name'] as $key => $value) {
				C::t('#zhuzhu_taobao#zhuzhu_taobao_brand')->update($key, array(
					'displayorder' => $_GET['displayorder'][$key],
					'name' => $_GET['name'][$key],
					'keyword' => $_GET['keyword'][$key],
				));
			}
		}

		if(is_array($_GET['newname'])) {
			foreach($_GET['newname'] as $key => $value) {
				if(empty($value)) continue;
				C::t('#zhuzhu_taobao#zhuzhu_taobao_brand')->insert(array(
					'displayorder' => $_GET['newdisplayorder'][$key],
					'name' => $_GET['newname'][$key],
					'keyword' => $_GET['newkeyword'][$key],
				));
			}
		}

		$query = C::t('#zhuzhu_taobao#zhuzhu_taobao_brand')->fetch_all_by_displayorder('', '', '', '', '');
		foreach($query as $value) {
			$zhuzhu_taobao_brand[$value['brand_id']] = $value;
		}
		savecache('zhuzhu_taobao_brand', $zhuzhu_taobao_brand);

		cpmsg('brand_update_succeed', 'action=plugins&operation=config&identifier=zhuzhu_taobao&pmod=admincp_brand', 'succeed');
	}
} elseif($_GET['ac'] == 'edit') {

	$brand = C::t('#zhuzhu_taobao#zhuzhu_taobao_brand')->fetch($_GET['id']);
	if(empty($brand)) {
		cpmsg('brand_nonexistence', '', 'error');
	}

	if(!submitcheck('editsubmit')) {

		showformheader('plugins&operation=config&identifier=zhuzhu_taobao&pmod=admincp_brand&ac=edit&id='.$brand['brand_id'], 'enctype');
		showtableheader();
		showsetting('displayorder', 'displayorder', $brand['displayorder'], 'text');
		showsetting('name', 'name', $brand['name'], 'text');
		showsetting('keyword', 'keyword', $brand['keyword'], 'text');
		showsetting('category_id', array('category_id', category_select()), $brand['category_id'], 'select');
		showsetting('logo', 'logo', $brand['logo'], 'filetext');
		showsetting('banner', 'banner', $brand['banner'], 'filetext');
		showsetting('big_banner', 'big_banner', $brand['big_banner'], 'filetext');
		showsubmit('editsubmit', 'submit');
		showtablefooter();
		showformfooter();

	} else {

		if(!$_GET['name']) {
			cpmsg('brand_invalid', '', 'error');
		}

		require_once libfile('function/home');
		if($pic = pic_upload($_FILES['logo'], 'portal', 100, 50)) $_GET['logo'] = $pic['pic'];
		if($pic = pic_upload($_FILES['banner'], 'portal', 100, 50)) $_GET['banner'] = $pic['pic'];
		if($pic = pic_upload($_FILES['big_banner'], 'portal', 100, 50)) $_GET['big_banner'] = $pic['pic'];

		$data = array(
			'name' => $_GET['name'],
			'keyword' => $_GET['keyword'],
			'displayorder' => $_GET['displayorder'],
			'logo' => $_GET['logo'],
			'banner' => $_GET['banner'],
			'big_banner' => $_GET['big_banner'],
			'category_id' => $_GET['category_id'],
		);
		C::t('#zhuzhu_taobao#zhuzhu_taobao_brand')->update($brand['brand_id'], $data);
		build_cache_plugin_zhuzhu_taobao_brand();
		cpmsg('brand_edit_succeed', 'action=plugins&operation=config&identifier=zhuzhu_taobao&pmod=admincp_brand', 'succeed');
	}
}

function category_select() {
	global $_G;

	$select[] = array(0, '');
	foreach($_G['cache']['zhuzhu_taobao_category'] as $category) {
		if($category['upid'] == '0') {
		$select[] = array($category['category_id'], $category['name']);
		}
	}
	return $select;
}
function build_cache_plugin_zhuzhu_taobao_brand() {

	$data = array();
	$query = C::t('#zhuzhu_taobao#zhuzhu_taobao_brand')->fetch_all_by_displayorder('', '', '', '', '');
	foreach($query as $value) {
		$data[$value['brand_id']] = $value;
	}
	savecache('zhuzhu_taobao_brand', $data);
}
//From:www_caogen8_co
?>
