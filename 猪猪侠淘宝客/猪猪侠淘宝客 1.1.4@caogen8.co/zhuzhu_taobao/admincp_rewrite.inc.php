<?php

/**
 *      [Caogen8!] (C)2014-2018 Www.Caogen8.co.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: admincp_admincp_rewrite.inc.php 37712 2018-03-01 11:31:15Z ²Ý-¸ù-°É $
 */

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
$lang = array_merge($lang, $scriptlang['zhuzhu_taobao']);

if($_GET['ac'] == 'rule') {

	$rule = array();
	$zhuzhu_taobao = dunserialize($_G['setting']['zhuzhu_taobao']);
	$rewritedata = array(

		'rulesearch' => array(
			'taobao'            => $zhuzhu_taobao['taobao']['rule'],
			'taobao-tbk'		=> $zhuzhu_taobao['taobao-tbk']['rule'],
			'taobao-tbk-cat'	=> $zhuzhu_taobao['taobao-tbk-cat']['rule'],
			'taobao-tbk-9k9'	=> $zhuzhu_taobao['taobao-tbk-9k9']['rule'],
			'taobao-tqg'		=> $zhuzhu_taobao['taobao-tqg']['rule'],
			'taobao-tbrand'		=> $zhuzhu_taobao['taobao-tbrand']['rule'],
			'taobao-tbrand-view' => $zhuzhu_taobao['taobao-tbrand-view']['rule'],
			'taobao-uatm'		=> $zhuzhu_taobao['taobao-uatm']['rule'],
			'taobao-uatm-cat'	=> $zhuzhu_taobao['taobao-uatm-cat']['rule'],
			'taobao-quan'		=> $zhuzhu_taobao['taobao-quan']['rule'],
			'taobao-quan-cat'	=> $zhuzhu_taobao['taobao-quan-cat']['rule'],
			'taobao-view'		=> $zhuzhu_taobao['taobao-view']['rule'],
		),

		'rulereplace' => array(
			'taobao'			=> 'plugin.php?id=zhuzhu_taobao',
			'taobao-tbk'		=> 'plugin.php?id=zhuzhu_taobao&mod=tbk',
			'taobao-tbk-cat'	=> 'plugin.php?id=zhuzhu_taobao&mod=tbk&cat={cat}',
			'taobao-tbk-9k9'	=> 'plugin.php?id=zhuzhu_taobao&mod=tbk&ac=9k9',
			'taobao-tqg'		=> 'plugin.php?id=zhuzhu_taobao&mod=tqg',
			'taobao-tbrand'		=> 'plugin.php?id=zhuzhu_taobao&mod=tbrand',
			'taobao-tbrand-view' => 'plugin.php?id=zhuzhu_taobao&mod=tbrand&op=view&brand_id={brand_id}',
			'taobao-uatm'       => 'plugin.php?id=zhuzhu_taobao&mod=uatm',
			'taobao-uatm-cat'	=> 'plugin.php?id=zhuzhu_taobao&mod=uatm&favorites_id={favorites_id}',
			'taobao-quan'		=> 'plugin.php?id=zhuzhu_taobao&mod=quan',
			'taobao-quan-cat'	=> 'plugin.php?id=zhuzhu_taobao&mod=quan&category_id={category_id}',
			'taobao-view'       => 'plugin.php?id=zhuzhu_taobao&mod=jump_url&num_iid={num_iid}',
		),

		'rulevars' => array(

			//jia
			'taobao'			=> array(''),
			'taobao-tbk'		=> array(''),
			'taobao-tbk-cat'	=> array('{cat}' => '([0-9]+)'),
			'taobao-tbk-9k9'	=> array(''),
			'taobao-tqg'		=> array(''),
			'taobao-tbrand'		=> array(''),
			'taobao-tbrand-view' => array('{brand_id}' => '([0-9]+)'),
			'taobao-uatm'       => array(''),
			'taobao-uatm-cat'	=> array('{favorites_id}' => '([0-9]+)'),
			'taobao-quan'		=> array(''),
			'taobao-quan-cat'	=> array('{category_id}' => '([0-9]+)'),
			'taobao-view'       => array('{num_iid}' => '([0-9]+)'),

		)
	);
	$rule['{apache1}'] = $rule['{apache2}'] = $rule['{iis}'] = $rule['{iis7}'] = $rule['{zeus}'] = $rule['{nginx}'] = '';
	foreach($rewritedata['rulesearch'] as $k => $v) {
		if(!$zhuzhu_taobao[$k]['available']) {
			continue;
		}
		$v = !$_G['setting']['rewriterule'][$k] ? $v : $_G['setting']['rewriterule'][$k];
		$pvmaxv = count($rewritedata['rulevars'][$k]) + 2;
		$vkeys = array_keys($rewritedata['rulevars'][$k]);
		$rewritedata['rulereplace'][$k] = pvsort($vkeys, $v, $rewritedata['rulereplace'][$k]);
		$v = str_replace($vkeys, $rewritedata['rulevars'][$k], addcslashes($v, '?*+^$.[]()|'));
		$rule['{apache1}'] .= 'RewriteCond %{QUERY_STRING} ^(.*)$'."\n".'RewriteRule ^(.*)/'.$v.'$ $1/'.pvadd($rewritedata['rulereplace'][$k])."&%1\n";
		if($k != 'forum_archiver') {
			$rule['{apache2}'] .= 'RewriteCond %{QUERY_STRING} ^(.*)$'."\n".'RewriteRule ^'.$v.'$ '.$rewritedata['rulereplace'][$k]."&%1\n";
		} else {
			$rule['{apache2}'] .= 'RewriteCond %{QUERY_STRING} ^(.*)$'."\n".'RewriteRule ^archiver/'.$v.'$ archiver/'.$rewritedata['rulereplace'][$k]."&%1\n";
		}
		$rule['{iis}'] .= 'RewriteRule ^(.*)/'.$v.'(\?(.*))*$ $1/'.addcslashes(pvadd($rewritedata['rulereplace'][$k]).'&$'.($pvmaxv + 1), '.?')."\n";
		$rule['{iis7}'] .= '&lt;rule name="'.$k.'"&gt;'."\n\t".'&lt;match url="^(.*/)*'.str_replace('\.', '.', $v).'\?*(.*)$" /&gt;'."\n\t".'&lt;action type="Rewrite" url="{R:1}/'.str_replace(array('&', 'page\%3D'), array('&amp;amp;', 'page%3D'), addcslashes(pvadd($rewritedata['rulereplace'][$k], 1).'&{R:'.$pvmaxv.'}', '?')).'" /&gt;'."\n".'&lt;/rule&gt;'."\n";
		$rule['{zeus}'] .= 'match URL into $ with ^(.*)/'.$v.'\?*(.*)$'."\n".'if matched then'."\n\t".'set URL = $1/'.pvadd($rewritedata['rulereplace'][$k]).'&$'.$pvmaxv."\nendif\n";
		$rule['{nginx}'] .= 'rewrite ^([^\.]*)/'.$v.'$ $1/'.stripslashes(pvadd($rewritedata['rulereplace'][$k]))." last;\n";
	}
	echo str_replace(array_keys($rule), $rule, cplang('rewrite_message'));

}else{
	if(!submitcheck('admincp_rewritesubmit')) {

		showtips('admincp_rewrite_tips');
		showformheader('plugins&operation=config&identifier=zhuzhu_taobao&pmod=admincp_rewrite');
		showtableheader();
		showtitle(cplang('admincp_rewritestatus'));
		showsubtitle(array('page', 'var', 'rule', 'available'));

		if(in_array('zhuzhu_taobao', $_G['setting']['plugins']['available'])) {
			$admincp_rewrite['taobao']        = array('taobao.html', '');
			$admincp_rewrite['taobao-tbk']    = array('taobao-tbk.html', '');
			$admincp_rewrite['taobao-tbk-9k9']    = array('taobao-tbk-9k9.html', '');
			$admincp_rewrite['taobao-tbk-cat']    = array('taobao-tbk-{cat}.html', '{cat}');
			$admincp_rewrite['taobao-uatm']  = array('taobao-uatm.html', '');
			$admincp_rewrite['taobao-uatm-cat']  = array('taobao-uatm-{favorites_id}.html', '{favorites_id}');
			$admincp_rewrite['taobao-tqg']  = array('taobao-tqg.html', '');
			$admincp_rewrite['taobao-tbrand']  = array('taobao-tbrand.html', '');
			$admincp_rewrite['taobao-tbrand-view']  = array('taobao-tbrand-{brand_id}.html', '{brand_id}');
			$admincp_rewrite['taobao-quan']  = array('taobao-quan.html', '');
			$admincp_rewrite['taobao-quan-cat']  = array('taobao-quan-{category_id}.html', '{category_id}');
			$admincp_rewrite['taobao-view']  = array('taobao-view-{num_iid}.html', '{num_iid}');
		}

		$zhuzhu_taobao = dunserialize($_G['setting']['zhuzhu_taobao']);
		foreach($admincp_rewrite as $key => $value) {
			$rule = $zhuzhu_taobao[$key]['rule'] ? $zhuzhu_taobao[$key]['rule'] : $value[0];
			$available = $zhuzhu_taobao[$key]['available'] ? ' checked="checked"' : '';
			showtablerow('', array('class="td24"', 'class="td31"', 'class="longtxt"', 'class="td25"'), array(
				cplang($key),
				$value[1],
				'<input type="text" name="zhuzhu_taobao['.$key.'][rule]" class="txt" value="'.$rule.'" />',
				'<input type="checkbox" name="zhuzhu_taobao['.$key.'][available]" class="checkbox" value="1"'.$available.' />',
			));
		}

		showsubmit('admincp_rewritesubmit', 'submit');
		showtablefooter();
		showformfooter();

	} else {

		$zhuzhu_taobao = serialize($_GET['zhuzhu_taobao']);
		DB::query("REPLACE INTO ".DB::table('common_setting')." (skey, svalue) VALUES ('zhuzhu_taobao', '$zhuzhu_taobao')");
		updatecache('setting');

		cpmsg('admincp_rewrite_update_succeed', 'action=plugins&operation=config&identifier=zhuzhu_taobao&pmod=admincp_rewrite', 'succeed');
	}
}


	function pvsort($key, $v, $s) {
		$r = '/';
		$p = '';
		foreach($key as $k) {
			$r .= $p.preg_quote($k);
			$p = '|';
		}
		$r .= '/';
		preg_match_all($r, $v, $a);
		$a = $a[0];
		$a = array_flip($a);
		foreach($a as $key => $value) {
			$s = str_replace($key, '$'.($value + 1), $s);
		}
		return $s;
	}

	function pvadd($s, $t = 0) {
		$s = str_replace(array('$6', '$5', '$4', '$3', '$2', '$1'), array('~7', '~6', '~5', '~4', '~3', '~2'), $s);
		if(!$t) {
			return str_replace(array('~7', '~6', '~5', '~4', '~3', '~2'), array('$7', '$6', '$5', '$4', '$3', '$2'), $s);
		} else {
			return str_replace(array('~7', '~6', '~5', '~4', '~3', '~2'), array('{R:7}', '{R:6}', '{R:5}', '{R:4}', '{R:3}', '{R:2}'), $s);
		}
	}
//WWW.CAOGEN8.CO
?>