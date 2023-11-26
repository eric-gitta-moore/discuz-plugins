<?php

/**
 *      [Caogen8!] (C)2014-2018 Www.Caogen8.co.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: admincp_category.inc.php 33234 2017-10-21 11:45:11Z ²Ý-¸ù-°É $
 */

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}

$lang = array_merge($lang, $scriptlang['zhuzhu_taobao']);
loadcache(array('zhuzhu_taobao_category', 'plugin'));
@include DISCUZ_ROOT.'./data/sysdata/cache_zhuzhu_taobao_category.php';
$category = $_G['cache']['zhuzhu_taobao_category'] = $zhuzhu_taobao_category;

if(empty($_GET['ac'])) {

	if(!submitcheck('listsubmit')) {

		showformheader('plugins&operation=config&identifier=zhuzhu_taobao&pmod=admincp_category');
		showtableheader();
		showsubtitle(array('del', 'displayorder', 'name', 'keyword', '', ''));
		foreach ($category as $key=>$value) {
			if($value['level'] == 0) {
				echo showcategoryrow($key, 0, '');
			}
		}
		echo '<tr><td class="td25">&nbsp;</td><td colspan="5"><div><a class="addtr" onclick="addrow(this, 0, 0)" href="http://t.cn/RvMznky##">'.cplang('add_cate').'</a></div></td></tr>';
		showsubmit('listsubmit', 'submit', 'del', '', $multipage);
		showtablefooter();
		showformfooter();
		echo '
<script type="text/JavaScript">
var rowtypedata = [
	[[1,\'\', \'td25\'], [1,\'<input type="text" class="txt" name="neworder[{1}][]" value="0" />\', \'td25\'], [1, \'<div class="parentboard"><input type="text" class="txt" value="" name="newname[{1}][]"/></div>\']],
	[[1,\'\', \'td25\'], [1,\'<input type="text" class="txt" name="neworder[{1}][]" value="0" />\', \'td25\'], [1, \'<div class="board"><input type="text" class="txt" value="" name="newname[{1}][]"/></div>\'], [1, \'<input type="text" class="txt" value="" name="newkeyword[{1}][]"/>\']],
	[[1,\'\', \'td25\'], [1,\'<input type="text" class="txt" name="neworder[{1}][]" value="0" />\', \'td25\'], [1, \'<div class="childboard"><input type="text" class="txt" value="" name="newname1[{1}][]"/></div>\'], [1,\'<input type="text" class="txt" name="newkeyword[{1}][]" value="0" />\', \'td26\'], [1, \'\'], [1, \'\']],
];
</script>';

	} else {

		if(is_array($_GET['delete'])) {
			C::t('#zhuzhu_taobao#zhuzhu_taobao_category')->delete($_GET['delete']);
		}

		if(is_array($_GET['name'])) {
			foreach($_GET['name'] as $key => $value) {
				$data = array(
					'name'         => $value,
					'displayorder' => $_GET['displayorder'][$key],
					'available'    => $_GET['available'][$key],
					'keyword'    => $_GET['keyword'][$key],
				);
				DB::update('zhuzhu_taobao_category', $data, array('category_id' => $key));
			}
		}

		if($_GET['newname']) {
			foreach($_GET['newname'] as $upid=>$names) {
				foreach($names as $nameid=>$name) {
					$data = array(
						'name'         => $name,
						'upid'         => $upid,
						'displayorder' => $_GET['neworder'][$upid][$nameid],
						'keyword' => $_GET['keyword'][$upid][$nameid],
						'available'    => 1,
					);
					DB::insert('zhuzhu_taobao_category', $data);
				}
			}
		}

		build_cache_zhuzhu_taobao_category();
		cpmsg('cate_edit_succeed', 'action=plugins&operation=config&identifier=zhuzhu_taobao&pmod=admincp_category', 'succeed');
	}
}elseif($_GET['ac'] == 'edit') {

	$category = C::t('#zhuzhu_taobao#zhuzhu_taobao_category')->fetch($_GET['id']);
	if(empty($category)) {
		cpmsg('category_nonexistence', '', 'error');
	}

	if(!submitcheck('editsubmit')) {

		showformheader('plugins&operation=config&identifier=zhuzhu_taobao&pmod=admincp_category&ac=edit&id='.$category['category_id'], 'enctype');
		showtableheader();
		showsetting('displayorder', 'name', $category['displayorder'], 'text');
		showsetting('name', 'name', $category['name'], 'text');
		showsetting('keyword', 'keyword', $category['keyword'], 'text');
		showsetting('pic', 'pic', $category['pic'], 'filetext');
		showsubmit('editsubmit', 'submit');
		showtablefooter();
		showformfooter();

	} else {

		if(!$_GET['name'] || !$_GET['keyword']) {
			cpmsg('category_invalid', '', 'error');
		}
		if(substr($_GET['pic'], 4) !== 'http'){
			require_once libfile('function/home');
			if($pic = pic_upload($_FILES['pic'], 'portal', 100, 100)) $_GET['pic'] = $pic['pic'];
			if($pic && $adscreen['pic']) pic_delete($adscreen['pic'], 'portal', 1);
		}

		$data = array(
			'name' => $_GET['name'],
			'keyword' => $_GET['keyword'],
			'displayorder' => $_GET['displayorder'],
			'pic' => $_GET['pic'],
		);
		C::t('#zhuzhu_taobao#zhuzhu_taobao_category')->update($category['category_id'], $data);

		build_cache_zhuzhu_taobao_category();
		cpmsg('category_edit_succeed', 'action=plugins&operation=config&identifier=zhuzhu_taobao&pmod=admincp_category', 'succeed');
	}
}

function showcategoryrow($key, $level = 0, $last = '') {
	global $_G;

	$value = $_G['cache']['zhuzhu_taobao_category'][$key];
	$return = '';

	if($level == 2) {
		$class = $last ? 'lastchildboard' : 'childboard';
		$return = '<tr class="hover"><td class="td25"><input type="checkbox" class="checkbox" name="delete[]" value="'.$value['category_id'].'" /></td><td class="td25"><input type="text" class="txt" name="displayorder['.$value['category_id'].']" value="'.$value['displayorder'].'" /></td><td><div class="'.$class.'">'.
		'<input type="text" name="name['.$value['category_id'].']" value="'.$value['name'].'" class="txt" /></div>'.
		'</div>'.
		'</td><td class="td26"><input type="text" name="keyword['.$value['category_id'].']" value="'.$value['keyword'].'" /></td><td><input type="checkbox" class="checkbox" name="hot['.$value['category_id'].']" value="1"'.($value['hot'] ? 'checked="checked"' : '').' /></td><td><input type="checkbox" class="checkbox" name="available['.$value['category_id'].']" value="1"'.($value['available'] ? 'checked="checked"' : '').' /></td></tr>';
		for($i=0,$L=count($value['children']); $i<$L; $i++) {
			$return .= showcategoryrow($value['children'][$i], 3, $i==$L-1);
		}
	} elseif($level == 1) {
		$return = '<tr class="hover"><td class="td25"><input type="checkbox" class="checkbox" name="delete[]" value="'.$value['category_id'].'" /></td><td class="td25"><input type="text" class="txt" name="displayorder['.$value['category_id'].']" value="'.$value['displayorder'].'" /></td><td><div class="board">'.
		'<input type="text" name="name['.$value['category_id'].']" value="'.$value['name'].'" class="txt" />'.
		'</div>'.
		'</td><td><input type="text" name="keyword['.$value['category_id'].']" value="'.$value['keyword'].'" class="txt" /></td><td></td><td><a href="admin.php?action=plugins&operation=config&identifier=zhuzhu_taobao&pmod=admincp_category&ac=edit&id='.$value['category_id'].'" class="act">'.cplang('edit').'</a></td></tr>';
		for($i=0,$L=count($value['children']); $i<$L; $i++) {
			$return .= showcategoryrow($value['children'][$i], 2, $i==$L-1);
		}
	} else {
		$return = '<tr class="hover"><td class="td25"><input type="checkbox" class="checkbox" name="delete[]" value="'.$value['category_id'].'" /></td><td class="td25"><input type="text" class="txt" name="displayorder['.$value['category_id'].']" value="'.$value['displayorder'].'" /></td><td><div class="parentboard">'.
		'<input type="text" name="name['.$value['category_id'].']" value="'.$value['name'].'" class="txt" />'.
		'</div>'.
		'</td><td></td><td></td><td></td></tr>';
		for($i=0,$L=count($value['children']); $i<$L; $i++) {
			$return .= showcategoryrow($value['children'][$i], 1, '');
		}
		$return .= '<tr><td class="td25"></td><td colspan="5"><div class="lastboard"><a class="addtr" onclick="addrow(this, 1, '.$value['category_id'].')" href="http://t.cn/RvMznky##">'.cplang('add_subcate').'</a></div>';
	}
	return $return;
}

function build_cache_zhuzhu_taobao_category() {

	$data = array();

	$query = DB::query("SELECT * FROM ".DB::table('zhuzhu_taobao_category')." ORDER BY displayorder");
	while($value = DB::fetch($query)) {
		$value['name'] = dhtmlspecialchars($value['name']);
		$data[$value['category_id']] = $value;
	}

	foreach($data as $key => $value) {
		$upid = $value['upid'];
		$data[$key]['level'] = 0;
		if($upid && isset($data[$upid])) {
			$data[$upid]['children'][] = $key;
			while($upid && isset($data[$upid])) {
				$data[$key]['level'] += 1;
				$upid = $data[$upid]['upid'];
			}
		}
	}
	updatecache('zhuzhu_taobao:zhuzhu_taobao_category');
	writetocache('zhuzhu_taobao_category', getcachevars(array('zhuzhu_taobao_category' => $data)));
}
//From:www_caogen8_co
?>