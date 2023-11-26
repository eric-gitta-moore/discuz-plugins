<?php
include "../source/global/global_inc.php";
include "source/module/space/common.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
	<title><?php echo $qianwei_web_nicheng; ?>的说说</title>
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
					<div class="spaceMTitle2">
						<p><?php echo $qianwei_web_callname; ?>的说说</p>
						<?php if($qianwei_web_userid == $qianwei_in_userid){ ?><span class="management"><a href="<?php echo cd_upath.rewrite_url('index.php?p=miniblog&a=me'); ?>">管理</a></span><?php } ?>
						<ul>
							<li>
								<a href="<?php echo cd_upath.rewrite_url('index.php?p=space&a=feed&uid='.$qianwei_web_userid); ?>">全部动态</a>
								<b></b>
							</li>
							<li class="current">
								<a href="<?php echo cd_upath.rewrite_url('index.php?p=space&a=miniblog&uid='.$qianwei_web_userid); ?>">随便说说</a>
								<b></b>
							</li>
						</ul>
					</div>
					<div class="title_per"> </div>
					<?php if($cd_id){ ?>
						<div class="miniblogShow">
							<?php
								global $db;
								$sql="select * from ".tname('blog')." where cd_uid='$qianwei_web_userid' and cd_id='$cd_id'";
								$result=$db->query($sql);
								if($row=$db->fetch_array($result)){
									//$cookies="web_blog_".$cd_id;
									//if(!$_COOKIE[$cookies]=="yes"){
									//	setcookie($cookies,"yes",time()+86400);
										$db->query("update ".tname('blog')." set cd_hits=cd_hits+1 where cd_id='$cd_id'");
									//}
									$user = $db->getrow("select * from ".tname('user')." where cd_id='".$row['cd_uid']."'");

									$cd_content = preg_replace("/\[em:(\d+)]/is", "<img src=\"".cd_upath."static/images/emot/e\\1.gif\" class=\"emotImg\">", $row['cd_content']);
									echo '<ul>';
									echo '<li>';
									echo '<input id="showType" type="hidden" value="1">';
									echo '<div class="avatar">';
									echo '<a href="'.linkweburl($row['cd_uid'],$row['cd_uname']).'" target="_blank">';
									echo '<img class="avatar-42" src="'.getavatar($row['cd_uid'],48).'"/>';
									echo '</a>';
									echo '</div>';
									echo '<div class="content">';
									echo '<div class="text" uid="'.$row['cd_uid'].'">';
									echo '<a href="'.linkweburl($row['cd_uid'],$row['cd_uname']).'" style="float:left;margin-right:3px;">'.$user['cd_nicheng'].'</a>'.CheckCertify($user['cd_checkmusic'],$user['cd_checkmm'],$user['cd_grade'],$user['cd_viprank']).' ：'.$cd_content.'';
									echo '</div>';
									echo '<div class="info">';
									echo '<span class="time">发表于:'.datetime(date('Y-m-d H:i:s',$row['cd_addtime'])).'</span>';
									if($qianwei_web_userid == $qianwei_in_userid){
										echo '<span id="'.$row['cd_id'].'" class="del" title="删除" bid="'.$row['cd_id'].'" uid="'.$row['cd_uid'].'"></span>';
									}
									echo '<span id="replyNum" class="action">评论['.$row['cd_commentnum'].']</span>';
									echo '</div>';
									echo '</div>';
									echo '</li>';
									echo '</ul>';

									echo '<div class="miniblogComment">';
										echo '<div class="arrow"></div>';
										echo '<div class="topBox"></div>';
										echo '<div class="centerBox">';
											echo '<div class="replayUser" id="replayUser"></div>';
											echo '<div id="replayUserDel" class="dells" title="取消对此人的回复"></div>';
											echo '<div class="inputBox">';
												echo '<input type="hidden" name="bid" id="bid" value="'.$row['cd_id'].'" />';
												echo '<input type="hidden" name="uid" id="uid" value="'.$row['cd_uid'].'" />';
												echo '<div class="avatar"><img class="avatar-34" src="'.getavatar($qianwei_in_userid,48).'" /></div>';
												echo '<div class="note"><textarea id="note" name="note" style="overflow-y:hidden;"></textarea></div>';
												echo '<button id="send" uid="'.$row['cd_uid'].'" class="send">发表</button>';
											echo '</div>';

											echo '<div id="miniblogCommentList" class="miniblogCommentList">';
											if($row['cd_commentnum']){
												echo '<ul>';
        												$query = $db->query("select * from ".tname('comment')." where cd_channel=0 and cd_dataid='$cd_id' order by cd_addtime desc LIMIT 0,100");
        												while ($rows = $db->fetch_array($query)) {
														$user = $db->getrow("select cd_nicheng from ".tname('user')." where cd_id='".$row['cd_uid']."'");
														$cd_contents = preg_replace("/\[em:(\d+)]/is", "<img src=\"".cd_upath."static/images/emot/e\\1.gif\" class=\"emotImg\">", $rows['cd_content']);
														echo '<li>';
														echo '<div class="avatar"><a href="'.linkweburl($rows['cd_uid'],$rows['cd_uname']).'" target="_blank"><img class="avatar-34" src="'.getavatar($rows['cd_uid'],48).'"/></a></div>';
														echo '<div class="content">';
														echo '<div class="note"><a href="'.linkweburl($rows['cd_uid'],$rows['cd_uname']).'" target="_blank">'.$rows['cd_uname'].'</a>：'.$cd_contents.'</div>';
														echo '<div class="time">发表于:'.datetime($rows['cd_addtime']).'</div>';
														echo '<div class="replay">';
														if($rows['cd_uid'] != $qianwei_in_userid){
															echo '<a id="comment" class="comment" authorId="'.$rows['cd_uid'].'" nickname="'.GetAlias("qianwei_user","cd_name","cd_id",$rows['cd_uid']).'" cid="'.$rows['cd_id'].'">回复</a>';
														}else{
															echo '<span></span>';
														}
														if($qianwei_web_userid == $qianwei_in_userid){
															echo '<span cid="'.$rows['cd_id'].'" class="dell" title="删除"></span>';
														}else{
															echo '<span></span>';
														}
														echo '</div>';
														echo '</div>';
														echo '</li>';
													}
												echo '</ul>';
											}
											echo '</div>';
										echo '<div id="nums" type="hidden" num="'.$row['cd_commentnum'].'"></div>';
										echo '</div>';
										echo '<div class="bottomBox"></div>';
									echo '</div>';
								}else{
									echo '<div class="nothing">您查看的说说不存在，或已被删除！</div>';
								}
							?>
						</div>
					<?php }else{ ?>
					<div id="miniblogList" class="miniblogList">
						<!--有内容-->
						<ul>
							<input id="showType" type="hidden" value="1">
							<?php
								global $db;
								$i=0;
								$sql="select * from ".tname('blog')." where cd_uid='$qianwei_web_userid' order by cd_addtime desc";
								$Arr=getwebpage($sql, 15, "index.php?p=space&a=".SafeRequest("a","get")."&uid=".$qianwei_web_userid);//sql,每页显示条数
								$result=$db->query($Arr[2]);
								$num=$db->num_rows($result);
								if($num==0){
									echo '<div class="nothing_miniblog">'.ReplaceStr($qianwei_web_callname,"我","").'还没有发表说说哦!</div>';
								}else{
									if($result){
										while ($row = $db ->fetch_array($result)){
											$i=$i+1;
											$user = $db->getrow("select * from ".tname('user')." where cd_id='".$row['cd_uid']."'");
											$cd_content = preg_replace("/\[em:(\d+)]/is", "<img src=\"".cd_upath."static/images/emot/e\\1.gif\" class=\"emotImg\">", $row['cd_content']);
											//$cd_content = preg_replace("/\<br.*?\>/is", ' ', $cd_content);
											echo '<li>';
											echo '<div class="time"><em>'.date('Y',$row['cd_addtime']).'</em>'.date('m',$row['cd_addtime']).'/'.date('d',$row['cd_addtime']).'</div>';
											echo '<div class="content">';
											echo '<div class="text">';
											echo '<a href="'.linkweburl($row['cd_uid'],$row['cd_uname']).'" target="_blank" style="float:left;margin-right:3px;">'.$user['cd_nicheng'].'</a> '.CheckCertify($user['cd_checkmusic'],$user['cd_checkmm'],$user['cd_grade'],$user['cd_viprank']).' <span>：'.$cd_content.'</span>';
											echo '</div>';
											echo '<div class="info">';
											echo '<span class="action">';
											echo '<a href="'.cd_upath.'index.php?p=space&a=miniblog&uid='.$row['cd_uid'].'&id='.$row['cd_id'].'" target="_blank">评论['.$row['cd_commentnum'].']</a>';
											echo '</span>';
											echo '<span class="update_time">发表于：'.datetime(date('Y-m-d H:i:s',$row['cd_addtime'])).'</span>';
											if($qianwei_web_userid == $qianwei_in_userid){
												echo '<span id="'.$row['cd_id'].'" class="del" bid="'.$row['cd_id'].'" title="删除" uid="'.$row['cd_uid'].'"></span>';
											}else{
												echo '<span></span>';
											}
											echo '</div>';
											echo '</div>';
										}
									}
								}
							?>
						</ul>
						<?php if($num>0){?>
						<div class="page">
							<div class="pages">
								<?php echo $Arr[0]; ?><input type="text" maxlength="5" onkeydown="function c(event,val){e = event ? event :(window.event ? window.event : null);if(e.keyCode==13){val = parseInt(val);val=isNaN(val)||(val<=0)?1:val;window.location.href='<?php echo cd_upath.'index.php?p=space&a=miniblog&uid='.$qianwei_web_userid.'&pages='; ?>'+val;return false;}else{return true;}};if(!c(event,this.value))return false;" title="输入页码，按回车快速跳转"/>
							</div>
							<div id="currPage"><?php echo SafeRequest("pages","get"); ?></div>
						</div>
						<?php } ?>
						<!--没内容-->
					</div>
					<?php } ?>
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
<script type="text/javascript" src="<?php echo cd_upath; ?>static/space/js/miniblog.js"></script>
<script type="text/javascript">
	<?php if($cd_id){ ?>
	miniblogLib.miniblogDelInit(".info");
	miniblogLib.commentDelInit();
	miniblogLib.commentAddInit();
	miniblogLib.replayUserInit();
	miniblogLib.replayUserDelInit();
	<?php }else{ ?>
	miniblogLib.miniblogDelInit("#miniblogList");
	<?php } ?>
</script>
</body>
</html>