<?php

/**
 *      [Caogen8!] (C)2014-2018 Www.Caogen8.co.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: taobao_index.php 10455 2017-06-28 02:03:20Z ²Ý-¸ù-°É $
 */

if (!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

//by xiaoqowen 2016.10.20  FROM:www.xiaoqiwen.cn
error_reporting(0);

$kw = $_GET["kw"];
//$kw=urldecode($kw);

$u='http://zhannei.baidu.com/api/customsearch/keywords?title='.$kw;

$comtxt=file_get_contents($u);


debug($comtxt);
$comtxts=array();
$comtxts=json_decode($comtxt,true);
$keyword_list=$comtxts['result']['res']['keyword_list'];
$len=count($keyword_list);
$keyword_list2='';
for ($x=0; $x<$len; $x++) {
$keyword_list2=$keyword_list2.$keyword_list[$x].' ';
}

$wordpos=$comtxts['result']['res']['wordpos'];

$leny=count($wordpos);
$wordpos2='';
for ($y=0; $y<$leny; $y++) {
$wordpos2=$wordpos2.$wordpos[$y].' ';
}


$keyword_list2=iconv("UTF-8", "GB2312//IGNORE",$keyword_list2);
$wordpos2=iconv("UTF-8", "GB2312//IGNORE",$wordpos2);
print_r ('¹Ø¼ü´Ê:'.$keyword_list2.'<br>');
print_r ('·Ö´Ê:'.$wordpos2.'<br>');
?>