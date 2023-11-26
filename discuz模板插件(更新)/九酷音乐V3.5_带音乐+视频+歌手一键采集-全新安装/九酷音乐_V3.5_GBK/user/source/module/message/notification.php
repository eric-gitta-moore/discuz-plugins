<?php
	include "../source/global/global_inc.php";
	VerifyLogin($qianwei_in_userid);
	$type = SafeRequest("type","get");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
	<title>全部通知 - <?php echo cd_webname; ?></title>
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
		<div class="user_menu" id="mnotification">
			<?php include "source/module/system/left_menu.php"; ?>
		</div>
		<div class="user_main">
			<div class="uMain_content">
				<div class="main_nav">
					<ul>
						<li class="inform">
							<a class="on" href="<?php echo cd_upath.rewrite_url('index.php?p=message&a=notification'); ?>">我的通知</a>
						</li>
					</ul>
				</div>
				<div class="main_nav2">
					<ul>
						<li<?php if($type == ""){echo " class=\"current\"";} ?>>
							<a href="<?php echo cd_upath.rewrite_url('index.php?p=message&a=notification'); ?>">全部通知</a>
						</li>
						<li<?php if($type == "dance"){echo " class=\"current\"";} ?>>
							<a href="<?php echo cd_upath.rewrite_url('index.php?p=message&a=notification&type=dance'); ?>">音乐</a>
						</li>
						<li<?php if($type == "miniblog"){echo " class=\"current\"";} ?>>
							<a href="<?php echo cd_upath.rewrite_url('index.php?p=message&a=notification&type=miniblog'); ?>">说说</a>
						</li>
						<li<?php if($type == "album"){echo " class=\"current\"";} ?>>
							<a href="<?php echo cd_upath.rewrite_url('index.php?p=message&a=notification&type=album'); ?>">图片</a>
						</li>
						<li<?php if($type == "wall"){echo " class=\"current\"";} ?>>
							<a href="<?php echo cd_upath.rewrite_url('index.php?p=message&a=notification&type=wall'); ?>">留言</a>
						</li>
						<li<?php if($type == "message"){echo " class=\"current\"";} ?>>
							<a href="<?php echo cd_upath.rewrite_url('index.php?p=message&a=notification&type=message'); ?>">私信</a>
						</li>
						<li<?php if($type == "fans"){echo " class=\"current\"";} ?>>
							<a href="<?php echo cd_upath.rewrite_url('index.php?p=message&a=notification&type=fans'); ?>">关注</a>
						</li>
						<li<?php if($type == "praise"){echo " class=\"current\"";} ?>>
							<a href="<?php echo cd_upath.rewrite_url('index.php?p=message&a=notification&type=praise'); ?>">赞扬</a>
						</li>
						<li<?php if($type == "account"){echo " class=\"current\"";} ?>>
							<a href="<?php echo cd_upath.rewrite_url('index.php?p=message&a=notification&type=account'); ?>">账户</a>
						</li>
						<li<?php if($type == "activity"){echo " class=\"current\"";} ?>>
							<a href="<?php echo cd_upath.rewrite_url('index.php?p=message&a=notification&type=activity'); ?>">活动</a>
						</li>
					</ul>
					<div id="tooltip" class="refresh">

					</div>
				</div>
				<div id="notification" class="minHeight500">
						<?php
							global $db;
							if($type){
								$sql="select * from ".tname('notice')." where cd_uids='$qianwei_in_userid' and cd_icon='$type' order by cd_addtime desc";
							}else{
								$sql="select * from ".tname('notice')." where cd_uids='$qianwei_in_userid' order by cd_addtime desc";
							}
							$Arr = getuserpage($sql,25);//sql,每页显示条数
							$result = $db->query($Arr[2]);
							$num = $db->num_rows($result);
							$a=0;
							if($result){
								if($num>0){
									echo '<div class="Ignore02">';
									if($type){
										echo '<span id="delall" onclick="messageLib.notificationAllDel('.$qianwei_in_userid.', \''.$type.'\', \'\', \'delall\');">清空该类全部通知</span>';
										echo '<span class="no">|&nbsp;|</span>';
										echo '<span id="delall2" onclick="messageLib.notificationAllDel('.$qianwei_in_userid.', \''.$type.'\', \'month\', \'delall2\');">删除该类一个月前通知</span>';
									}else{
										echo '<span id="delall" onclick="messageLib.notificationAllDel('.$qianwei_in_userid.', \'\', \'\', \'delall\');">清空全部通知</span>';
										echo '<span class="no">|&nbsp;|</span>';
										echo '<span id="delall2" onclick="messageLib.notificationAllDel('.$qianwei_in_userid.', \'\', \'month\', \'delall2\');">删除一个月前通知</span>';
									}
									echo '</div>';
									echo '<div class="notification">';
									echo '<ul>';
									while ($row = $db ->fetch_array($result)){
										$a=$a+1;
										$user = $db->getrow("select cd_nicheng from ".tname('user')." where cd_id='".$row['cd_uid']."'");
										echo '<li>';
										echo '<span class="icon_mini_'.$row['cd_icon'].'"></span>';
										echo '<span class="content">';
										if($row['cd_uid'] == 0){
											echo '<a href="javascript:;">系统提示：</a>';
										}else{
											echo '<a href="'.linkweburl($row['cd_uid'],$row['cd_uname']).'" target="_blank">'.$user['cd_nicheng'].'</a>';
										}
										echo '&nbsp;'.$row['cd_data'].'&nbsp;';
										if($row['cd_state'] == 1){
											echo '&nbsp;&nbsp;<img src="'.cd_upath.'static/space/images/icon/new.gif" />';
										}
										echo '</span>';
										echo '<span id="'.$row['cd_id'].'" class="ndel"  title="删除"></span>';
										echo '<span class="mtime">'.datetime($row['cd_addtime']).'</span>';
										echo '</li>';
									}
									echo '</ul>';
									echo '</div>';
									$db->query("update ".tname('notice')." set cd_state='0' where cd_uids='".$qianwei_in_userid."'");
								}else{
									echo '<div class="nothing">暂未收到任何通知!</div>';
								}
							}
						?>
					
					<?php if($num>0){?><div class="page"><div class="pages"><?php echo $Arr[0]; ?><input type="text" maxlength="5" onkeydown="function c(event,val){e = event ? event :(window.event ? window.event : null);if(e.keyCode==13){val = parseInt(val);val=isNaN(val)||(val<=0)?1:val;window.location.href='<?php echo cd_upath; ?>index.php?p=<?php echo SafeRequest("p","get"); ?>&a=<?php echo SafeRequest("a","get"); ?>&type=<?php echo SafeRequest("type","get"); ?>&pages='+val+'';return false;}else{return true;}};if(!c(event,this.value))return false;" title="输入页码，按回车快速跳转"/></div></div><div id="currPage"><?php echo SafeRequest("pages","get"); ?></div><?php } ?>
					<div id="type" style="display: none"><?php echo $type; ?></div>
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
<script type="text/javascript">listenMsg.start();nav.init();nav.userMenu();</script>
<script type="text/javascript" src="<?php echo cd_upath; ?>static/space/js/message.js"></script>
<script type="text/javascript">nav.helpNoticeInit();messageLib.notificationDelInit(); </script>
</body>
</html>