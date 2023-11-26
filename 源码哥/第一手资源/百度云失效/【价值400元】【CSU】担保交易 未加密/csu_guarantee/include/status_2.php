<?php
/*
 * 出处：源码哥
 * 官网: Www.fx8.cc
 * 备用网址: www.ymg6.com (请收藏备用!)
 * 技术支持/更新维护：QQ 154606914
 * 
 */
if(!defined('IN_DISCUZ')) {
	exit('Access Deined');
}
$rs = getorders("WHERE status in (0,5,6,7) AND ( uid=".$_G['uid']." OR other_side=".$_G['uid']." )");
if($rs) {
	foreach ($rs as $rss){
		$money = array();
		$money = dealprice($rss['price'],$rss['deduct_type']);
		$buyandsell = array();
		$buyandsell = bas($rss);
		$odop = array();
		$odop = orderop($rss);
		$echo .= '<li>
<span class="ab">'.date('m-d H:i',$rss['applytime']).'</span> 
<span class="aa"><a href="plugin.php?id=csu_guarantee&item=detail&gid='.$rss['id'].'" target="_blank">'.$rss['id'].'</a></span> 
<span class="af" style="width:350px;"><a href="plugin.php?id=csu_guarantee&item=detail&gid='.$rss['id'].'" target="_blank"><strong>'.$lang[58].$rss['price'].$lang[59].'</strong> '.$lang[60].':<i>'.$buyandsell['buy']['username'].'</i> '.$lang[61].':<i>'.$buyandsell['sell']['username'].'</i></a></span> 
<span class="ae">'.$odop.'</span></li>';
	}
}
else {
	$echo =  "<span class=\"af\" style=\" color:red;\"><strong>&nbsp;</strong>{$lang[62]}</span>";
}
//WWW.fx8.cc
?>