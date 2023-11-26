<?php
/*
Author:·Ö.Ïí.°É
Website:www.fx8.cc
Qq:154-6069-14
*/
include 'language/'.currentlang().'.php';
$jlang = $language['js'];
echo 'var lang_charset=lang={};lang_charset.set="'.$_GET['charset'].'";';
foreach ($language['js'] as $k => $v) {
	echo 'lang._'.$k.'="'.$v.'";';
}
//WWW.fx8.cc
?>