<?php
include "../source/global/global_inc.php";
include "source/module/space/common.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
	<title><?php echo $qianwei_web_nicheng; ?>的留言</title>
	<script type="text/javascript">
		var domIsReady=false,domReadyList=[],domReadyObject=[],$call=function(callback,obj){if(typeof obj!=='object'){obj=document}if(domIsReady){callback.call(obj)}else{domReadyList.push(callback);domReadyObject.push(obj)}};	
		var site_domain="<?php echo cd_webpath; ?>";zone_domain="<?php echo cd_upath; ?>";
	</script>
	<link type="text/css" href="<?php echo cd_upath; ?>static/css/core.css" rel="stylesheet" />
	<link type="text/css" href="<?php echo cd_upath; ?>static/space/css/common.css" rel="stylesheet" />
	<link type="text/css" href="<?php echo cd_upath; ?>static/space/css/space.css" rel="stylesheet" />
	<link type="text/css" id="skin" href="<?php echo cd_upath; ?>static/space/skin/<?php echo $qianwei_web_skinid; ?>/style.css" rel="stylesheet" />
</head>
<body>
<?php include "source/module/space/header.php"; ?>
<div class="spaceMain">
	<div class="mainTop"></div>
	<div class="mainCenter">
		<div class="publicLeft">
			<div class="stageBox">
				<div class="stageBoxTop">
					<span></span>
				</div>
				<div class="stageBoxCenter min_space_height">
					<div class="spaceWall">
						<div class="wallConsole">
							<div class="wallTitle">
								<span>留言板</span>
							</div>
							<div class="title_per"> </div>
							<div class="sW_box">
								<div class="sW_input"><div contenteditable="true" id="wallContent" class="wallContent" name="wallContent"></div></div>
								<div class="sW_button">
									<span class="button-main">
										<span>
											<button type="button" id="wallSubmit" onclick="$call(function(){wallLib.wallAddInit(<?php echo $qianwei_web_userid; ?>, 'd88eb702419ed442a8aa4bf9e1ee08972z3mE!WVA9KAhSmZMomdfIgTQtZzICn0tn9c1zq9@XpDwOpHwpu0nZQCRw')});">留言</button>
										</span>
									</span>
								</div>
								<div id="sW_message" class="wCI_message"></div>
								<div id="emot_wallContent" class="emot" to="wallContent"></div>
							</div>
						</div>
						<div id="wall_content" class="wall_content minHeight150">
							<?php
								if($cd_id){
									global $db;
									$sql="select * from ".tname('wall')." where cd_id='$cd_id'";
									$result=$db->query($sql);
									if($row=$db->fetch_array($result)){
										$cd_content = preg_replace("/\[em:(\d+)]/is", "<img src=\"".cd_upath."static/images/emot/e\\1.gif\" class=\"face\">", $row['cd_content']);
										//$cd_content = preg_replace("/\<br.*?\>/is", ' ', $cd_content);
										echo '<div class="wallLine" id="wall_'.$row['cd_id'].'">';
										echo '<div class="wallItem">';
										echo '<div class="arrow"><s></s></div>';
										echo '<div class="wI_avatar"><a href="'.linkweburl($row['cd_uid'],$row['cd_uname']).'"><img class="avatar-58" src="'.getavatar($row['cd_uid'],48).'" width="48" height="48"/></a></div>';
										echo '<div class="wI_content">';
										echo '<div class="wI_top">';
										echo '<span class="nickname"><a href="'.linkweburl($row['cd_uid'],$row['cd_uname']).'">'.GetAlias("qianwei_user","cd_nicheng","cd_id",$row['cd_uid']).'</a></span>';
										echo '<span class="info">留言：</span>';
										if($qianwei_web_userid == $qianwei_in_userid){
											echo '<span id="del-w'.$row['cd_id'].'" class="del" title="删除" onclick="$call(function(){wallLib.doDelWall('.$qianwei_web_userid.', '.$row['cd_id'].', 0, 0)});" ></span>';
										}
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
											$cd_contents = preg_replace("/\[em:(\d+)]/is", "<img src=\"".cd_upath."static/images/emot/e\\1.gif\" class=\"emotImg\">", $rows['cd_content']);
											echo '<div class="wallComment">';
											echo '<div class="wallCommentItem" id="walls_'.$rows['cd_id'].'">';
											echo '<div class="wC_avatar"><a href="'.linkweburl($rows['cd_uid'],$rows['cd_uname']).'"><img class="avatar-38" src="'.getavatar($rows['cd_uid'],48).'"/></a></div>';
											echo '<div class="wC_top">';
											echo '<span class="nickname"><a href="'.linkweburl($row['cd_uid'],$row['cd_uname']).'">'.GetAlias("qianwei_user","cd_nicheng","cd_id",$rows['cd_uid']).'</a></span>';
											if($qianwei_web_userid == $qianwei_in_userid){
												echo '<span id="del-c'.$rows['cd_id'].'" class="del" title="删除" onclick="$call(function(){wallLib.doDelWall('.$qianwei_web_userid.', '.$row['cd_id'].', '.$rows['cd_id'].', 0)});"></span>';
											}
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
										echo '<div class="wCI_button"><span class="button-main"><span><button type="submit" id="wallcontSubmit" class="confirm" onclick="$call(function(){wallLib.confirmWall('.$row['cd_id'].', '.$qianwei_web_userid.')});">确认</button></span></span></div>';
										echo '<div class="wCI_cancel"><a class="cancel" href="javascript:;" onclick="$call(function(){wallLib.cancelWall('.$row['cd_id'].')});" >取消</a></div>';
										echo '<div id="wCI_message'.$row['cd_id'].'" class="wCI_message"></div>';
										echo '<div class="emot" id="emot_wallCommentInput'.$row['cd_id'].'"></div>';
										echo '</div>';
										echo '</div>';
									}else{
										echo '<div class="nothing_wall">囧啊```还木有人留言啊- -! 您来留个言吧。</div>';
									}
								}else{
								global $db;
								$i=0;
								$sql="select * from ".tname('wall')." where cd_wallid=0 and cd_dataid='$qianwei_web_userid' order by cd_addtime desc";
								$Arr=getwebpage($sql, 10, "index.php?p=space&a=".SafeRequest("a","get")."&uid=".$qianwei_web_userid);//sql,每页显示条数
								$result=$db->query($Arr[2]);
								$num=$db->num_rows($result);
								if($num==0){ echo '<div class="nothing">囧啊```还木有人留言啊- -! 您来留个言吧。</div>'; }
								if($result){
									while ($row = $db ->fetch_array($result)){
										$cd_content = preg_replace("/\[em:(\d+)]/is", "<img src=\"".cd_upath."static/images/emot/e\\1.gif\" class=\"face\">", $row['cd_content']);
										//$cd_content = preg_replace("/\<br.*?\>/is", ' ', $cd_content);
										echo '<div class="wallLine" id="wall_'.$row['cd_id'].'">';
										echo '<div class="wallItem">';
										echo '<div class="arrow"><s></s></div>';
										echo '<div class="wI_avatar"><a href="'.linkweburl($row['cd_uid'],$row['cd_uname']).'"><img class="avatar-58" src="'.getavatar($row['cd_uid'],48).'" width="48" height="48"/></a></div>';
										echo '<div class="wI_content">';
										echo '<div class="wI_top">';
										echo '<span class="nickname"><a href="'.linkweburl($row['cd_uid'],$row['cd_uname']).'">'.GetAlias("qianwei_user","cd_nicheng","cd_id",$row['cd_uid']).'</a></span>';
										echo '<span class="info">留言：</span>';
										if($qianwei_web_userid == $qianwei_in_userid){
											echo '<span id="del-w'.$row['cd_id'].'" class="del" title="删除" onclick="$call(function(){wallLib.doDelWall('.$qianwei_web_userid.', '.$row['cd_id'].', 0, 0)});" ></span>';
										}
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
											$cd_contents = preg_replace("/\[em:(\d+)]/is", "<img src=\"".cd_upath."static/images/emot/e\\1.gif\" class=\"emotImg\">", $rows['cd_content']);
											echo '<div class="wallComment">';
											echo '<div class="wallCommentItem" id="walls_'.$rows['cd_id'].'">';
											echo '<div class="wC_avatar"><a href="'.linkweburl($rows['cd_uid'],$rows['cd_uname']).'"><img class="avatar-38" src="'.getavatar($rows['cd_uid'],48).'"/></a></div>';
											echo '<div class="wC_top">';
											echo '<span class="nickname"><a href="'.linkweburl($row['cd_uid'],$row['cd_uname']).'">'.GetAlias("qianwei_user","cd_nicheng","cd_id",$rows['cd_uid']).'</a></span>';
											if($qianwei_web_userid == $qianwei_in_userid){
												echo '<span id="del-c'.$rows['cd_id'].'" class="del" title="删除" onclick="$call(function(){wallLib.doDelWall('.$qianwei_web_userid.', '.$row['cd_id'].', '.$rows['cd_id'].', 0)});"></span>';
											}
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
										echo '<div class="wCI_button"><span class="button-main"><span><button type="submit" id="wallcontSubmit" class="confirm" onclick="$call(function(){wallLib.confirmWall('.$row['cd_id'].', '.$qianwei_web_userid.')});">确认</button></span></span></div>';
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
										<?php echo $Arr[0]; ?>
										<input type="text" maxlength="5" onkeydown="function c(event,val){e = event ? event :(window.event ? window.event : null);if(e.keyCode==13){val = parseInt(val);val=isNaN(val)||(val<=0)?1:val;window.location.href='<?php echo cd_upath.'index.php?p=space&a=wall&uid='.$qianwei_web_userid.'&pages='; ?>'+val;return false;}else{return true;}};if(!c(event,this.value))return false;" title="输入页码，按回车快速跳转"/>
										<div id="currPage"><?php echo SafeRequest("pages","get"); ?></div>
									</div>
								</div>
							<?php }} ?>
						</div>
					</div>
				</div>
				<div class="stageBoxBottom">
					<span></span>
				</div>
			</div>
		</div>
		<div class="publicRight">
			<?php include "source/module/space/right.php"; ?>
		</div>
	</div>
	<div class="mainBottom"></div>
</div>
<div class="spaceBottom">
	<?php include "source/module/space/footer.php"; ?>
</div>
<script type="text/javascript" src="<?php echo cd_upath; ?>static/js/jquery/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo cd_upath; ?>static/js/core.js"></script>
<script type="text/javascript" src="<?php echo cd_upath; ?>static/js/card.js"></script>
<script type="text/javascript" src="<?php echo cd_upath; ?>static/js/dialog.js"></script>
<script type="text/javascript" src="<?php echo cd_upath; ?>static/js/jquery/jquery.plugins.js"></script>
<script type="text/javascript" src="<?php echo cd_upath; ?>static/space/js/common.js"></script>
<script type="text/javascript">listenMsg.start();nav.init();nav.userMenu();</script>
<script type="text/javascript" src="<?php echo cd_upath; ?>static/space/js/wall.js"></script>
<script type="text/javascript">
	libs.spaceInit();
	$("#wallContent").elastic({maxHeight:130});
	$("#wallContent").emotEditor({allowed:300, charCount:true, emot:true, newLine:true});
</script>
</body>
</html>