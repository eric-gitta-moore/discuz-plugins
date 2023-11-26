<?php
	include "../source/global/global_inc.php";
	VerifyLogin($qianwei_in_userid);
	$toUid = SafeRequest("toUid","get");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
	<title>消息列表 - <?php echo cd_webname; ?></title>
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
		<div class="user_menu" id="messagem">
			<?php include "source/module/system/left_menu.php"; ?>
		</div>
		<div class="user_main">
			<div class="uMain_content">
				<div class="main_nav">
					<ul>
						<li class="letter">
							<a href="<?php echo cd_upath.rewrite_url('index.php?p=message&a=msg'); ?>"><span>我的私信</span></a>
						</li>
						<li class="particular"><a class="on" href="<?php echo cd_upath.rewrite_url('index.php?p=message&a=msgDetail&toUid='.$toUid); ?>"><span>查看详情</span></a></li>
					</ul>
				</div>
				<div id="msg" class="minHeight500">
					<?php
						$cd_id = SafeRequest("toUid","get");
						global $db;
						$sql="select * from ".tname('message')." where cd_uid<>0 and cd_uids='$qianwei_in_userid' and cd_id='$cd_id'";
						if($row=$db->getrow($sql)){
							$db->query("update ".tname('message')." set cd_readid='0' where cd_id='$cd_id'");
							$user = $db->getrow("select cd_nicheng from ".tname('user')." where cd_id='".$row['cd_uid']."'");
							echo '<div class="msgIgnore">';
							echo '<span class="name">与 <strong>'.$user['cd_nicheng'].'</strong> 的短消息对话</span>';
							echo '<span class="reMessage" fromUid="'.$qianwei_in_userid.'" toUid="'.$row['cd_uid'].'">删除本对话</span>';
							echo '</div>';
							echo '<div class="msgList">';
							echo '<ul>';

							$query = $db->query("select * from ".tname('message')." where cd_dataid='".$row['cd_id']."' order by cd_id asc");
							while ($rows = $db->fetch_array($query)) {
								$cd_content = preg_replace("/\[em:(\d+)]/is", "<img src=\"".cd_upath."static/images/emot/e\\1.gif\" class=\"face\">", $rows['cd_content']);

								$users = $db->getrow("select cd_nicheng from ".tname('user')." where cd_id='".$rows['cd_uid']."'");
								echo '<li id="msg-'.$rows['cd_id'].'">';
								echo '<div class="icon"><a href="'.linkweburl($rows['cd_uid'],$rows['cd_uname']).'" target="_blank"><img class="avatar-58" src="'.getavatar($rows['cd_uid'],48).'" title="'.$users['cd_nicheng'].'"/></a></div>';
								echo '<div class="pm">';
								echo '<div class="h">';
								echo '<div class="f">';
								echo '<p><a href="'.linkweburl($rows['cd_uid'],$rows['cd_uname']).'" target="_blank">'.$users['cd_nicheng'].'</a> <span class="mtime">'.datetime($rows['cd_addtime']).'</span> <span class="del" mcid="'.$rows['cd_id'].'" toUid="'.$row['cd_uids'].'">删除</span></p>';
								echo '<div class="c">'.$cd_content.'</div>';
								echo '</div>';
								echo '</div>';
								echo '</div>';
								echo '</li>';
							}

							echo '<li>';
							echo '<div class="icon"><a href="'.linkweburl($qianwei_in_userid,$qianwei_in_username).'" target="_blank"><img class="avatar-58" src="'.getavatar($qianwei_in_userid,48).'" title="'.$qianwei_in_nicheng.'"/></a></div>';
							echo '<div class="pm">';
							echo '<div class="h">';
							echo '<div class="f">';
							echo '<div class="c">';
							echo '<div id="fnote" contenteditable="true" class="messageSend" name="fnote"></div>';
							echo '<div id="emot_fnote" class="emot" to="fnote"></div>';
							echo '<span class="button-main"><span><button class="reMsg" type="button" toUid="'.$row['cd_uid'].'">回复</button></span></span>';
							echo '</div>';
							echo '</div>';
							echo '</div>';
							echo '</div>';
							echo '</li>';
							echo '</ul>';
							echo '</div>';
						}else{
							echo '<div class="nothing">非法操作，请指定操作对象。</div>';
						}
					?>
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
<script type="text/javascript" src="<?php echo cd_upath; ?>static/space/js/message.js"></script>
<script type="text/javascript">
	nav.helpNoticeInit();
	messageLib.reMsgDelInit(); 
	messageLib.msgAddInit();
	messageLib.reMsgOneDelInit();
</script>
</body>
</html>