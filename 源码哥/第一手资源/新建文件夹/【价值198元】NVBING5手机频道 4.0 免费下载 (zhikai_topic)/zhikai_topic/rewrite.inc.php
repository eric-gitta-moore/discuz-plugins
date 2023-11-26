<?php


if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
	if(!function_exists("rewritedata")) include libfile("function/admincp");
	$rule = array();
	$rewritedata = rewritedata();
	$rule['{apache1}'] = $rule['{apache2}'] = $rule['{iis}'] = $rule['{iis7}'] = $rule['{zeus}'] = $rule['{nginx}'] = '';
	foreach($rewritedata['rulesearch'] as $k => $v) {
		if(!in_array($k, $_G['setting']['rewritestatus'])) {
			continue;
		}
		$v = !$_G['setting']['rewriterule'][$k] ? $v : $_G['setting']['rewriterule'][$k];
		$pvmaxv = count($rewritedata['rulevars'][$k]) + 2;
		$vkeys = array_keys($rewritedata['rulevars'][$k]);
		$rewritedata['rulereplace'][$k] = pvsort($vkeys, $v, $rewritedata['rulereplace'][$k]);
		$v = str_replace($vkeys, $rewritedata['rulevars'][$k], addcslashes($v, '?*+^$.[]()|'));
		$rule['{apache1}'] .= "\t".'RewriteCond %{QUERY_STRING} ^(.*)$'."\n\t".'RewriteRule ^(.*)/'.$v.'$ $1/'.pvadd($rewritedata['rulereplace'][$k])."&%1\n";
		if($k != 'forum_archiver') {
			$rule['{apache2}'] .= 'RewriteCond %{QUERY_STRING} ^(.*)$'."\n".'RewriteRule ^'.$v.'$ '.$rewritedata['rulereplace'][$k]."&%1\n";
		} else {
			$rule['{apache2}'] .= 'RewriteCond %{QUERY_STRING} ^(.*)$'."\n".'RewriteRule ^archiver/'.$v.'$ archiver/'.$rewritedata['rulereplace'][$k]."&%1\n";
		}
		$rule['{iis}'] .= 'RewriteRule ^(.*)/'.$v.'(\?(.*))*$ $1/'.addcslashes(pvadd($rewritedata['rulereplace'][$k]).'&$'.($pvmaxv + 1), '.?')."\n";
		$rule['{iis7}'] .= "\t\t".'&lt;rule name="'.$k.'"&gt;'."\n\t\t\t".'&lt;match url="^(.*/)*'.str_replace('\.', '.', $v).'\?*(.*)$" /&gt;'."\n\t\t\t".'&lt;action type="Rewrite" url="{R:1}/'.str_replace(array('&', 'page\%3D'), array('&amp;amp;', 'page%3D'), addcslashes(pvadd($rewritedata['rulereplace'][$k], 1).'&{R:'.$pvmaxv.'}', '?')).'" /&gt;'."\n\t\t".'&lt;/rule&gt;'."\n";
		$rule['{zeus}'] .= 'match URL into $ with ^(.*)/'.$v.'\?*(.*)$'."\n".'if matched then'."\n\t".'set URL = $1/'.pvadd($rewritedata['rulereplace'][$k]).'&$'.$pvmaxv."\nendif\n";
		$rule['{nginx}'] .= 'rewrite ^([^\.]*)/'.$v.'$ $1/'.stripslashes(pvadd($rewritedata['rulereplace'][$k]))." last;\n";
	}
	
$rule['{apache1}'] .= "\tRewriteCond %{QUERY_STRING} ^(.*)$\n\tRewriteRule ^(.*)/nvbing5_(.+)\.html$ $1/plugin.php?id=zhikai_topic:topic&topic=$2&%1\n";
$rule['{apache2}'] .= "RewriteCond %{QUERY_STRING} ^(.*)$\nRewriteRule ^nvbing5_(.+)\.html$ plugin.php?id=zhikai_topic:topic&topic=$1&%1";
$rule['{iis}'] .= "RewriteRule ^(.*)/nvbing5_(.+)\.html(\?(.*))*$ $1/plugin\.php\?id=zhikai_topic:topic&topic=$2&$4";
$rule['{iis7}'] .= dhtmlspecialchars("\t\t<rule name=\"zhikai_topic\">\n\t\t\t<match url=\"^(.*/)*nvbing5_(.+).html\?*(.*)$\" />\n\t\t\t<action type=\"Rewrite\" url=\"{R:1}/plugin.php\?id=zhikai_topic:topic&amp;topic={R:2}&amp;{R:3}\" />\n\t\t</rule>\n");
$rule['{zeus}'] .= "match URL into $ with ^(.*)/nvbing5_(.+)\.html\?*(.*)$\nif matched then\n\tset URL = $1/plugin.php?id=zhikai_topic:topic&topic=$2&$3\nendif";
$rule['{nginx}'] .= "rewrite ^([^\.]*)/nvbing5_(.+)\.html$ $1/plugin.php?id=zhikai_topic:topic&topic=$2 last;\nif (!-e $request_filename) {\n\treturn 404;\n}";
echo str_replace(array_keys($rule), $rule, cplang('rewrite_message'));//From www.mo  qu8.com

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
	$s = str_replace(array('$3', '$2', '$1'), array('~4', '~3', '~2'), $s);
	if(!$t) {
		return str_replace(array('~4', '~3', '~2'), array('$4', '$3', '$2'), $s);
	} else {
		return str_replace(array('~4', '~3', '~2'), array('{R:4}', '{R:3}', '{R:2}'), $s);
	}

}
?>