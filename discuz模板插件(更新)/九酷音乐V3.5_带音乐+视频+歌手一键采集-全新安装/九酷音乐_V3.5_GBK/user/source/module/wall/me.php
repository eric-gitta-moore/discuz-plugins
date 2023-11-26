<?php
	include "../source/global/global_inc.php";
	VerifyLogin($qianwei_in_userid);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
	<title>我的留言 - <?php echo cd_webname; ?></title>
	<script type="text/javascript">
		var domIsReady=false,domReadyList=[],domReadyObject=[],$call=function(callback,obj){if(typeof obj!=='object'){obj=document}if(domIsReady){callback.call(obj)}else{domReadyList.push(callback);domReadyObject.push(obj)}};
		var site_domain="<?php echo cd_webpath; ?>";zone_domain="<?php echo cd_upath; ?>";
	</script>
	<link type="text/css" href="<?php echo cd_upath; ?>static/css/core.css" rel="stylesheet" />
        <link type="text/css" href="<?php echo cd_upath; ?>static/site/css/common.css" rel="stylesheet" />
	<link type="text/css" href="<?php echo cd_upath; ?>static/space/css/common.css" rel="stylesheet" media="all" />
	<link type="text/css" href="<?php echo cd_upath; ?>static/space/css/user.css" rel="stylesheet" media="all" />
</head>
<body>

<div class="header"><?php include "source/module/system/header.php"; ?></div>
<div class="user">
	<div class="user_center">
		<div class="user_menu" id="wallm">
			<?php include "source/module/system/left_menu.php"; ?>
		</div>
		<div class="user_main">
			<div class="uMain_content">
				<div class="main_nav">
					<ul>
						<li class="message">
							<a href="<?php echo cd_upath.rewrite_url('index.php?p=wall&a=me'); ?>" class="on">我的留言</a>
						</li>
					</ul>
				</div>
				<div class="main">
					<div id="tooltip" class="refresh">

					</div>
				</div>
				<div id="wall_content" class="minHeight500">
							<?php
								global $db;
								$i=0;
								$sql="select * from ".tname('wall')." where cd_wallid=0 and cd_dataid='$qianwei_in_userid' order by cd_addtime desc";
								$Arr=getuserpage($sql, 10);//sql,每页显示条数
								$result=$db->query($Arr[2]);
								$num=$db->num_rows($result);
								if($num==0){ echo '<div class="nothing">囧啊```还木有人留言啊- -! 您来留个言吧。</div>'; }
								if($result){
									while ($row = $db ->fetch_array($result)){
										$user = $db->getrow("select cd_nicheng,cd_checkmusic,cd_checkmm,cd_grade,cd_viprank from ".tname('user')." where cd_id='".$row['cd_uid']."'");
										$cd_content = preg_replace("/\[em:(\d+)]/is", "<img src=\"".cd_upath."static/images/emot/e\\1.gif\" class=\"face\">", $row['cd_content']);
										//$cd_content = preg_replace("/\<br.*?\>/is", ' ', $cd_content);
										echo '<div class="wallLine" id="wall_'.$row['cd_id'].'">';
										echo '<div class="wallItem">';
										echo '<div class="arrow"><s></s></div>';
										echo '<div class="wI_avatar"><a href="'.linkweburl($row['cd_uid'],$row['cd_uname']).'"><img class="avatar-58" src="'.getavatar($row['cd_uid'],48).'" width="48" height="48"/></a></div>';
										echo '<div class="wI_content">';
										echo '<div class="wI_top">';
										echo '<span class="nickname"><a href="'.linkweburl($row['cd_uid'],$row['cd_uname']).'">'.$user['cd_nicheng'].'</a>'.CheckCertify($user['cd_checkmusic'],$user['cd_checkmm'],$user['cd_grade'],$user['cd_viprank']).'</span>';
										echo '<span class="info">留言：</span>';
										echo '<span id="del-w'.$row['cd_id'].'" class="del" title="删除" onclick="$call(function(){wallLib.doDelWall('.$qianwei_in_userid.', '.$row['cd_id'].', 0, 0)});" ></span>';
										echo '<span class="others">';
										echo '<span class="createTime">'.datetime($row['cd_addtime']).'</span>';
										//if($row['cd_uid'] != $qianwei_in_userid){
											echo '<span><a class="reply" onclick="$call(function(){wallLib.replyWall('.$row['cd_id'].', 0, 0, 0, '.$row['cd_uid'].')});" href="javascript:;">回复</a></span>';
										//}
										echo '</span>';
										echo '</div>';
										echo '<div class="wI_text">'.$cd_content.'</div>';
										echo '</div>';
										echo '</div>';
										echo '<div id="wallComment'.$row['cd_id'].'">';

        									$query = $db->query("select * from ".tname('wall')." where cd_wallid='".$row['cd_id']."' order by cd_addtime desc LIMIT 0,100");
        									while ($rows = $db->fetch_array($query)) {
											$users = $db->getrow("select cd_nicheng,cd_checkmusic,cd_checkmm,cd_grade,cd_viprank from ".tname('user')." where cd_id='".$rows['cd_uid']."'");
											$cd_contents = preg_replace("/\[em:(\d+)]/is", "<img src=\"".cd_upath."static/images/emot/e\\1.gif\" class=\"emotImg\">", $rows['cd_content']);
											echo '<div class="wallComment">';
											echo '<div class="wallCommentItem" id="walls_'.$rows['cd_id'].'">';
											echo '<div class="wC_avatar"><a href="'.linkweburl($rows['cd_uid'],$rows['cd_uname']).'"><img class="avatar-38" src="'.getavatar($rows['cd_uid'],48).'"/></a></div>';
											echo '<div class="wC_top">';
											echo '<span class="nickname"><a href="'.linkweburl($row['cd_uid'],$row['cd_uname']).'">'.$users['cd_nicheng'].'</a>'.CheckCertify($users['cd_checkmusic'],$users['cd_checkmm'],$users['cd_grade'],$users['cd_viprank']).'</span>';
											echo '<span id="del-c'.$rows['cd_id'].'" class="del" title="删除" onclick="$call(function(){wallLib.doDelWall('.$qianwei_in_userid.', '.$row['cd_id'].', '.$rows['cd_id'].', 0)});"></span>';
											echo '<span class="others">';
											echo '<span class="createTime">'.datetime($rows['cd_addtime']).'</span>';
											if($rows['cd_uid'] != $qianwei_in_userid){
												echo '<span><a href="javascript:;" onclick="$call(function(){wallLib.replyWall('.$row['cd_id'].', '.$rows['cd_id'].', '.$rows['cd_uid'].', \''.GetAlias("qianwei_user","cd_nicheng","cd_id",$rows['cd_uid']).'\', 0)});">回复</a></span>';
											}
											echo '</span>';
											echo '</div>';
											echo '<div class="wC_text">'.$cd_contents.'</div>';
											echo '</div>';
											echo '</div>';
											echo '<div id="exp"></div>';
										}

										echo '</div>';
										echo '<div id="wallCommentInputBox'.$row['cd_id'].'" class="wallCommentInputBox" style="display:none;">';
										echo '<div class="replayUser" id="replayUser_'.$row['cd_id'].'"></div>';
										echo '<div class="del" id="replayUserDel_'.$row['cd_id'].'" onclick="$call(function(){wallLib.delReplayUser('.$row['cd_id'].')});" title="取消对此人的回复"></div>';
										echo '<div class="wCI_input"><div id="wallCommentInput'.$row['cd_id'].'" contenteditable="true" class="wallCommentInput" name="wallCommentInput"></div></div>';
										echo '<div class="wCI_button"><span class="button-main"><span><button type="submit" id="wallcontSubmit" class="confirm" onclick="$call(function(){wallLib.confirmWall('.$row['cd_id'].', '.$qianwei_in_userid.')});">确认</button></span></span></div>';
										echo '<div class="wCI_cancel"><a class="cancel" href="javascript:;" onclick="$call(function(){wallLib.cancelWall('.$row['cd_id'].')});" >取消</a></div>';
										echo '<div id="wCI_message'.$row['cd_id'].'" class="wCI_message"></div>';
										echo '<div class="emot" id="emot_wallCommentInput'.$row['cd_id'].'"></div>';
										echo '</div>';
										echo '</div>';

									}
								}
							?>
					<?php if($num>0){?>
						<div class="page" id="page">
							<div class="pages">
								<?php echo $Arr[0]; ?><input type="text" maxlength="5" onkeydown="function c(event,val){e = event ? event :(window.event ? window.event : null);if(e.keyCode==13){val = parseInt(val);val=isNaN(val)||(val<=0)?1:val;window.location.href='<?php echo cd_upath; ?>index.php?p=<?php echo SafeRequest("p","get"); ?>&a=<?php echo SafeRequest("a","get"); ?>&pages='+val+'';return false;}else{return true;}};if(!c(event,this.value))return false;" title="输入页码，按回车快速跳转"/>
							</div>
							<div id="currPage"><?php echo SafeRequest("pages","get"); ?></div>
						</div>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
	<div class="user_copyright"><?php include "source/module/system/footer.php"; ?></div>
</div>
<script type="text/javascript" src="<?php echo cd_upath; ?>static/js/jquery/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo cd_upath; ?>static/js/core.js"></script>
<script type="text/javascript" src="<?php echo cd_upath; ?>static/js/card.js"></script>
<script type="text/javascript" src="<?php echo cd_upath; ?>static/js/dialog.js"></script>
<script type="text/javascript" src="<?php echo cd_upath; ?>static/js/jquery/jquery.plugins.js"></script>
<script type="text/javascript" src="<?php echo cd_upath; ?>static/space/js/common.js"></script>
<script type="text/javascript">listenMsg.start();nav.init();nav.userMenu();nav.helpNoticeInit();</script>
<script type="text/javascript" src="<?php echo cd_upath; ?>static/space/js/wall.js"></script>
</body>
</html>