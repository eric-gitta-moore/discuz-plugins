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
$rs = getorders("WHERE uid=".$_G['uid']." or other_side=".$_G['uid']);
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
if(submitcheck('agreedeal')){
	$_GET = daddslashes($_GET);
	$order = DB::fetch_first("SELECT * FROM ".DB::table('csu_guarantee')." WHERE id=".$_GET['gid']);
	if($order['status'] != 1) showmessage($lang[63]);
	if($order['other_side']!=$_G['uid']) showmessage($lang[64]);
	$update['other_contact'] = serialize(daddslashes($_GET['contact']));
	$update['status'] = 2;
	if(DB::update('csu_guarantee',$update,array('id'=>intval($_GET['gid'])))) showmessage($lang[65],dreferer());
}
if(submitcheck('den')){
	$_GET = daddslashes($_GET);
	$order = DB::fetch_first("SELECT * FROM ".DB::table('csu_guarantee')." WHERE id=".$_GET['gid']);
	if($order['status'] != 3) showmessage($lang[63]);
	if($order['other_side']!=$_G['uid']&&$order['uid']!=$_G['uid']) showmessage($lang[64]);
	$update['send'] = serialize($_GET['contact']);
	$update['status'] = 4;
	if(DB::update('csu_guarantee',$update,array('id'=>intval($_GET['gid'])))) showmessage($lang[65],dreferer());
}
if(submitcheck('finish')){
	$_GET = daddslashes($_GET);
	$order = DB::fetch_first("SELECT * FROM ".DB::table('csu_guarantee')." WHERE id=".$_GET['gid']);
	if($order['status'] != 4) showmessage($lang[63]);
	if($order['other_side']!=$_G['uid']&&$order['uid']!=$_G['uid']) showmessage($lang[64]);
	$update['status'] = 5;
	if(DB::update('csu_guarantee',$update,array('id'=>intval($_GET['gid'])))) showmessage($lang[65],dreferer());
}
if(submitcheck('closedeal')){
	$_GET = daddslashes($_GET);
	$order = DB::fetch_first("SELECT * FROM ".DB::table('csu_guarantee')." WHERE id=".$_GET['gid']);
	if($order['status'] != 1) showmessage($lang[63]);
	if($order['other_side']!=$_G['uid']&&$order['uid']!=$_G['uid']) showmessage($lang[64]);
	$update['status'] = 0;
	if(DB::update('csu_guarantee',$update,array('id'=>intval($_GET['gid'])))) showmessage($lang[65],dreferer());
}
if(submitcheck('dealtrouble')){
	$_GET = daddslashes($_GET);
	$order = DB::fetch_first("SELECT * FROM ".DB::table('csu_guarantee')." WHERE id=".$_GET['gid']);
	if($order['status'] != 4) showmessage($lang[63]);
	if($order['other_side']!=$_G['uid']&&$order['uid']!=$_G['uid']) showmessage($lang[64]);
	$update['status'] = 6;
	if(DB::update('csu_guarantee',$update,array('id'=>intval($_GET['gid'])))) showmessage($lang[65],dreferer());
}
//WWW.fx8.cc
?>