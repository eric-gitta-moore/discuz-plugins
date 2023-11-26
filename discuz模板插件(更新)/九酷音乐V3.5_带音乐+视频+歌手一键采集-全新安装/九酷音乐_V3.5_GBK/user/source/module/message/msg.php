<?php
	include "../source/global/global_inc.php";
	VerifyLogin($qianwei_in_userid);
	$new = SafeRequest("new","get");
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
						<li class="inform">
							<a class="on" href="<?php echo cd_upath.rewrite_url('index.php?p=message&a=msg'); ?>">我的私信</a>
						</li>
					</ul>
				</div>
				<div class="main_nav2">
					<ul>
						<li<?php if($new == ""){echo " class=\"current\"";} ?>>
							<a href="<?php echo cd_upath.rewrite_url('index.php?p=message&a=msg'); ?>">全部私信</a>
						</li>
						<li<?php if($new == "1"){echo " class=\"current\"";} ?>>
							<a href="<?php echo cd_upath.rewrite_url('index.php?p=message&a=msg&new=1'); ?>">未读私信</a>
						</li>
					</ul>
					<div id="tooltip" class="refresh">

					</div>
				</div>
				<div id="msg" class="minHeight500">
						<?php
							global $db;
							if($new){
								$sql="select * from ".tname('message')." where cd_uids='$qianwei_in_userid' and cd_dataid=0 and cd_readid=1 order by cd_addtime desc";
							}else{
								$sql="select * from ".tname('message')." where cd_uids='$qianwei_in_userid' and cd_dataid=0 order by cd_addtime desc";
							}

							$Arr = getuserpage($sql,10);//sql,每页显示条数
							$result = $db->query($Arr[2]);
							$num = $db->num_rows($result);
							$a=0;
							if($result){
								if($num>0){
									echo '<div class="msgIgnore">';
										echo '<span class="name">全部私信列表</span>';
										echo '<span class="delAll" fromUid="'.$qianwei_in_userid.'">清空所有私信</span>';
									echo '</div>';
									echo '<div class="msgList">';
									echo '<ul>';
									while ($row = $db ->fetch_array($result)){
										$cd_content = preg_replace("/\[em:(\d+)]/is", "<img src=\"".cd_upath."static/images/emot/e\\1.gif\" class=\"face\">", $row['cd_content']);

										$a=$a+1;
										if($row['cd_uid']){
											$user = $db->getrow("select cd_nicheng from ".tname('user')." where cd_id='".$row['cd_uid']."'");
											echo '<li id="ms-'.$row['cd_id'].'">';
											echo '<div class="icon"><a href="'.linkweburl($row['cd_uid'],$row['cd_uname']).'" target="_blank"><img class="avatar-58" src="'.getavatar($row['cd_uid'],48).'" title="'.$user['cd_nicheng'].'"/></a></div>';
											echo '<div class="pm">';
											echo '<div class="h">';
											echo '<div class="f">';
											echo '<p><a href="'.linkweburl($row['cd_uid'],$row['cd_uname']).'" target="_blank">'.$user['cd_nicheng'].'</a> <span class="mtime">'.datetime($row['cd_addtime']).'</span></p>';
											echo '<div class="c">'.$cd_content;
											if($row['cd_readid']==1){
												echo '<span class="re">(未阅读)</span>';
											}else{
												echo '<span class="nore">(已阅读)</span>';
											}
											echo '<p><a href="'.cd_upath.'index.php?p=message&a=msgDetail&toUid='.$row['cd_id'].'" target="_blank">查看详情</a></p></div>';
											echo '<a class="del" mid="'.$row['cd_id'].'" type="0" toUid="'.$row['cd_uid'].'" fromUid="'.$row['cd_uids'].'">删除</a>';
											echo '</div>';
											echo '</div>';
											echo '</div>';
											echo '</li>';
										}else{
											$db->query("update ".tname('message')." set cd_readid='0' where cd_id='".$row['cd_id']."'");
											echo '<li id="ms-'.$row['cd_id'].'">';
											echo '<div class="icon"><img class="avatar-58" src="'.cd_upath.'static/images/systempm.gif" title="'.$row['cd_uname'].'"/></a></div>';
											echo '<div class="pm">';
											echo '<div class="h">';
											echo '<div class="f">';
											echo '<p>'.$row['cd_uname'].' <span class="mtime">'.datetime($row['cd_addtime']).'</span></p>';
											echo '<div class="c">'.$cd_content.'</div>';
											echo '<a class="del" mid="'.$row['cd_id'].'" type="0" toUid="'.$row['cd_uids'].'" fromUid="'.$row['cd_uid'].'">删除</a>';
											echo '</div>';
											echo '</div>';
											echo '</div>';
											echo '</li>';
										}
									}
									echo '</ul>';
									echo '</div>';
								}else{
									if($new){
										echo '<div class="nothing">没有未读私信!</div>';
									}else{
										echo '<div class="nothing">暂未收到任何私信!</div>';
									}
								}
							}
						?>
					
					<?php if($num>0){?><div class="page"><div class="pages"><?php echo $Arr[0]; ?><input type="text" maxlength="5" onkeydown="function c(event,val){e = event ? event :(window.event ? window.event : null);if(e.keyCode==13){val = parseInt(val);val=isNaN(val)||(val<=0)?1:val;window.location.href='<?php echo cd_upath; ?>index.php?p=<?php echo SafeRequest("p","get"); ?>&a=<?php echo SafeRequest("a","get"); ?>&new=<?php echo SafeRequest("new","get"); ?>&pages='+val+'';return false;}else{return true;}};if(!c(event,this.value))return false;" title="输入页码，按回车快速跳转"/></div></div><div id="currPage"><?php echo SafeRequest("pages","get"); ?></div><?php } ?>
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
<script type="text/javascript">listenMsg.start();nav.init();nav.userMenu();nav.helpNoticeInit();</script>
<script type="text/javascript" src="<?php echo cd_upath; ?>static/space/js/message.js"></script>
<script type="text/javascript">
	nav.helpNoticeInit();
	messageLib.msgDelInit();
	messageLib.msgAllDelInit();	
	messageLib.msgIgnoreInit();
</script>
</body>
</html>