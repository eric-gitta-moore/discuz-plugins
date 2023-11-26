<?php
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache");
header("Content-type: text/html;charset=gb2312");
include "../../source/global/global_conn.php";
include "../../source/global/global_inc.php";
close_browse();
$ac=SafeRequest("ac","get");
if($ac=="goodbad"){
	global $db;
	$CD_ID=SafeRequest("id","get");
	$sql="select * from ".tname('music')." where CD_ID=".$CD_ID;
	if($row=$db->getrow($sql)){
		$dhits=$row['CD_GoodHits'];
		$chits=$row['CD_BadHits'];
	}
	$showstr="<a class=\"dongStar\">评价：<font color=\"#FF3E3E\"><strong><i>+".$dhits."</i></strong></font> <font color=\"#398DFF\"><strong><i>-".$chits."</i></strong></font></a><a class=\"dongPing\" href=\"".LinkErrorUrl($row['CD_ID'])."\" target=\"_blank\" title=\"点击报错\">无法试听？</a>";
	echo $showstr;
}elseif($ac=="dohits"){
	global $db,$userlogined;
	$CD_ID=SafeRequest("id","get");
	$do=SafeRequest("do","get");
	$sql="select * from ".tname('music')." where CD_ID=".$CD_ID;
	if($row=$db->getrow($sql)){
                if($userlogined){
                        $cookies="like_music_".$CD_ID;
	                if(!empty($_COOKIE[$cookies])){
		                echo "Msg_cookie";
	                }else{
		                setcookie($cookies,"have",time()+86400);
	                        if($do=="good"){
                                        $likesql="select cd_id from ".tname('like')." where cd_uid=".$qianwei_in_userid." and cd_musicid=".$row['CD_ID'];
                                        $like=$db->getrow($likesql);
                                        if($like){
                                                $db->query("update ".tname('like')." set cd_addtime=".time()." where cd_id=".$like['cd_id']);
                                        }else{
                                                $setarr = array(
                                                        'cd_uid' => $qianwei_in_userid,
                                                        'cd_uname' => $qianwei_in_username,
                                                        'cd_musicid' => $row['CD_ID'],
                                                        'cd_musicname' => $row['CD_Name'],
                                                        'cd_classid' => $row['CD_ClassID'],
                                                        'cd_addtime' => time()
                                                );
                                                inserttable('like', $setarr, 1);
                                        }
		                        $db->query("update ".tname('music')." set CD_GoodHits=CD_GoodHits+1 where CD_ID=".$CD_ID);
		                        echo "Msg_like";
                                }else{
                                        $dislikesql="select cd_id from ".tname('dislike')." where cd_uid=".$qianwei_in_userid." and cd_musicid=".$row['CD_ID'];
                                        $dislike=$db->getrow($dislikesql);
                                        if($dislike){
                                                $db->query("update ".tname('dislike')." set cd_addtime=".time()." where cd_id=".$dislike['cd_id']);
                                        }else{
                                                $setarr = array(
                                                        'cd_uid' => $qianwei_in_userid,
                                                        'cd_uname' => $qianwei_in_username,
                                                        'cd_musicid' => $row['CD_ID'],
                                                        'cd_musicname' => $row['CD_Name'],
                                                        'cd_classid' => $row['CD_ClassID'],
                                                        'cd_addtime' => time()
                                                );
                                                inserttable('dislike', $setarr, 1);
                                        }
		                        $db->query("update ".tname('music')." set CD_BadHits=CD_BadHits+1 where CD_ID=".$CD_ID);
		                        echo "Msg_dislike";
                                }
	                }
                }else{
		        echo "Msg_login";
                }
	}
}
?>