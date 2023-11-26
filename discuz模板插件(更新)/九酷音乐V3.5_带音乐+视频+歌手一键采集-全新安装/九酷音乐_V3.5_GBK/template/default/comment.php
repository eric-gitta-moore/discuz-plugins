<?php
include "../../source/global/global_conn.php";
include "../../source/global/global_inc.php";
include "source/common.php";
$cd_id=SafeRequest("id","get");
global $db,$userlogined;
$sql="select * from ".tname('music')." where CD_ID=".$cd_id;
if($row=$db->getrow($sql)){
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title><?php echo $row['CD_Name']; ?> - 音乐评论 - <?php echo cd_webname; ?></title>
<link href="<?php echo $TempImg; ?>css/comment.css" rel="stylesheet" type="text/css" />
<link href="<?php echo cd_webpath; ?>source/plugin/asynctips/asynctips.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?php echo $TempImg; ?>js/lib.js"></script>
<script type="text/javascript" src="<?php echo cd_webpath; ?>source/plugin/asynctips/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo cd_webpath; ?>source/plugin/asynctips/asyncbox.v1.4.5.js"></script>
<script type="text/javascript">
var root_url="<?php echo cd_webpath; ?>";
var temp_url="<?php echo $TempImg; ?>";
var comment_music_id="<?php echo $cd_id; ?>";
$ = function(em) {
    if (document.getElementById){ return document.getElementById(em); }
    else if (document.all){ return document.all[em]; }
    else if (document.layers){ return document.layers[em]; }
    else{ return null; }
}
</script>
</head>
<body>
<?php if(!$userlogined){ ?>
<div class="commentArea">
<div class="commentHeader">
<h1 class="floatLeft"><a href="<?php echo cd_upath; ?>" target="_blank"><?php echo $qianwei_in_username; ?></a></h1>
<a class="floatRight logout" href="<?php echo cd_webpath.rewrite_url('user.php?do=register'); ?>" target="_blank">注册</a>
</div>
<form method="get" onsubmit="login_comment();return false;">
<table>
<tr><td height="39">登录帐号：<input type="text" id="username" style="width:165px;height:25px;"></td></tr>
<tr><td height="40">登录密码：<input type="password" id="pwd" style="width:165px;height:25px;"></td></tr>
</table>
<div class="sendComment">
<span class="commentTip" id="i_result">请先<em>登录</em>后再评论！</span>
<button class="btnComment" type="submit">登 录</button>
</div>
</form>
</div>
<?php }else{ ?>
<div class="commentArea">
<div class="commentHeader">
<h2 class="floatLeft"><a href="<?php echo linkweburl($qianwei_in_userid,$qianwei_in_username); ?>" target="_blank"><?php echo $qianwei_in_username; ?></a></h2>
<a class="floatRight logout" href="javascript:void(0)" onclick="logout_comment();">退出</a>
</div>
<textarea id="content" cols="35" rows="5"></textarea>
<div class="sendComment">
<span class="commentTip" id="t_result">请<em>文明</em>发言！</span>
<button class="btnComment" type="button" onclick="post_comment()">评 论</button>
</div>
</div>
<?php } ?>
<div class="listArea" style="overflow-y:scroll;overflow-x:hidden;height:380px;">
<?php
$sql="select * from ".tname('comment')." where cd_channel=4 and cd_dataid=".$cd_id." order by cd_addtime desc";
$Arr=getuserpage($sql,10);
$result=$db->query($Arr[2]);
$num=$db->num_rows($result);
if($num==0){
echo "<center>还没有评论，赶快来抢占沙发吧！</center>";
}
if($result){
echo "<ul class=\"commentList\">";
while ($row = $db->fetch_array($result)) {
$cd_content = getlen("len","128",$row['cd_content']);
echo "<li><div class=\"commentHead\"><a href=\"".linkweburl($row['cd_uid'],$row['cd_uname'])."\" target=\"_blank\"><img src=\"".getavatars($row['cd_uid'],0)."\" width=\"30\" height=\"30\"></a></div><div class=\"commentWrap\"><span class=\"commentContent\"><a href=\"".linkweburl($row['cd_uid'],$row['cd_uname'])."\" target=\"_blank\" style=\"font-weight:bold;\">".$row['cd_uname'].": </a>".$cd_content."</span><span class=\"commentOpe\"><a class=\"commentReply replyAction\">".datetime($row['cd_addtime'])."</a></span></div></li>";
}
echo "</ul>";
}
?>
</div>
<div style="text-align:right;padding:0;margin:0;padding-right:20px;height:20px;line-height:20px;">
<?php echo $Arr[0]; ?>
</div>
</body>
</html>
<?php }else{
die(html_message("错误信息","数据不存在或已被删除！"));
} ?>