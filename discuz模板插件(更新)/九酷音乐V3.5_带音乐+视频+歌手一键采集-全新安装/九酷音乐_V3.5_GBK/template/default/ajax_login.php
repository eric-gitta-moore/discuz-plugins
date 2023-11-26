<?php
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
header("Content-type: text/html;charset=gb2312");
include "../../source/global/global_conn.php";
include "../../source/global/global_inc.php";
include "source/common.php";
close_browse();
global $userlogined;
if($userlogined){
	$showstr="<ul class=\"top-user\">";
   	$showstr=$showstr."<li><a href=\"".linkweburl($qianwei_in_userid,$qianwei_in_username)."\" target=\"_blank\">".$qianwei_in_username."</a></li><li class=\"pie\">|</li>";
   	$showstr=$showstr."<li><a href=\"".cd_upath.rewrite_url('index.php?p=account&a=assets')."\" target=\"_blank\">个人账户</a></li><li class=\"pie\">|</li>";
   	$showstr=$showstr."<li><a href=\"".cd_upath.rewrite_url('index.php?p=dance&a=share')."\" target=\"_blank\">分享音乐</a></li><li class=\"pie\">|</li>";
   	$showstr=$showstr."<li class=\"down-menu\"><span><a href=\"".cd_upath.rewrite_url('index.php?p=user&a=profileModify')."\" target=\"_blank\">设置</a></span></li>";
   	$showstr=$showstr."<li><a href=\"javascript:void(0)\" onclick=\"goutRequest();\">退出</a></li>";
   	$showstr=$showstr."</ul>";
}else{
	$showstr="<div class=\"topLogin\"><div class=\"webLogin\">[ <a href=\"".cd_webpath.rewrite_url('user.php?do=login')."\" class=\"color\">立即登录</a> ]或[ <a href=\"".cd_webpath.rewrite_url('user.php?do=register')."\" class=\"color\">注册</a> ]</div><div class=\"appLogin\" style=\"width:132px;\"></div><div>";
}
	echo $showstr;
?>