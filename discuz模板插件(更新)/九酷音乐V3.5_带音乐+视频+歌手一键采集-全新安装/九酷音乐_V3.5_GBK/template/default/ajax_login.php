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
   	$showstr=$showstr."<li><a href=\"".cd_upath.rewrite_url('index.php?p=account&a=assets')."\" target=\"_blank\">�����˻�</a></li><li class=\"pie\">|</li>";
   	$showstr=$showstr."<li><a href=\"".cd_upath.rewrite_url('index.php?p=dance&a=share')."\" target=\"_blank\">��������</a></li><li class=\"pie\">|</li>";
   	$showstr=$showstr."<li class=\"down-menu\"><span><a href=\"".cd_upath.rewrite_url('index.php?p=user&a=profileModify')."\" target=\"_blank\">����</a></span></li>";
   	$showstr=$showstr."<li><a href=\"javascript:void(0)\" onclick=\"goutRequest();\">�˳�</a></li>";
   	$showstr=$showstr."</ul>";
}else{
	$showstr="<div class=\"topLogin\"><div class=\"webLogin\">[ <a href=\"".cd_webpath.rewrite_url('user.php?do=login')."\" class=\"color\">������¼</a> ]��[ <a href=\"".cd_webpath.rewrite_url('user.php?do=register')."\" class=\"color\">ע��</a> ]</div><div class=\"appLogin\" style=\"width:132px;\"></div><div>";
}
	echo $showstr;
?>