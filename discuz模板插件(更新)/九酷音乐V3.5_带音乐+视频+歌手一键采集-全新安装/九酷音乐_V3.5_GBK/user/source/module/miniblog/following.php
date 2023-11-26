<?php
	include "../source/global/global_inc.php";
	VerifyLogin($qianwei_in_userid);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
	<title>关注的说说 - <?php echo cd_webname; ?></title>
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
		<div class="user_menu" id="miniblogm">
			<?php include "source/module/system/left_menu.php"; ?>
		</div>
		<div class="user_main">
			<div class="uMain_content">
				<div class="main_nav">
					<ul>
						<li class="me_microblog">
							<a href="<?php echo cd_upath.rewrite_url('index.php?p=miniblog&a=me'); ?>">我的说说</a>
						</li>
						<li class="friend_microblog">
							<a href="<?php echo cd_upath.rewrite_url('index.php?p=miniblog&a=following'); ?>" class="on">好友们在说</a>
						</li>
					</ul>
					<div class="action">
						<a href="<?php echo cd_upath.rewrite_url('index.php?p=miniblog&a=me'); ?>">发表说说</a>
					</div>
				</div>
				<div class="main">
					<div id="tooltip" class="refresh">

					</div>
				</div>
				<div class="minHeight500">
					<div class="miniblogBox">
						<form>
							<div class="note">
								<div id="note" contenteditable="true" class="miniblogInput" name="note"></div>
							</div>
							<div class="action">
								<div id="emot_note" class="emot" to="note"></div>
								<div class="button">
									<span class="button-main">
										<span>
											<button id="send">发表</button>
										</span>
									</span>
								</div>
								<div id="miniblogMessage" class="miniblogMessage"></div>
							</div>
						</form>
					</div>
					<div class="miniblogList" id="miniblogList">
						<ul>
							<?php
								global $db;
								$a=0;
								$sql="select a.cd_content,a.cd_uid,a.cd_uname,b.cd_nicheng,b.cd_checkmusic,b.cd_checkmm,b.cd_grade,b.cd_viprank,a.cd_id,a.cd_commentnum,a.cd_addtime from ".tname('blog')." as a,".tname('user')." as b where a.cd_uid = b.cd_id and cd_uid in(".GetFolloWing($qianwei_in_userid,0).") order by cd_addtime desc";
								$Arr=getuserpage($sql,20);//sql,每页显示条数
								$result=$db->query($Arr[2]);
								$num=$db->num_rows($result);
								if($num){
									while ($row = $db ->fetch_array($result)){
										$a=$a+1;
										$cd_content = preg_replace("/\[em:(\d+)]/is", "<img src=\"".cd_upath."static/images/emot/e\\1.gif\" class=\"face\">", $row['cd_content']);
										echo '<li>';
										echo '<div class="avatar"><a href="'.linkweburl($row['cd_uid'],$row['cd_uname']).'" target="_blank"><img class="avatar-42" src="'.getavatar($row['cd_uid'],48).'"/></a></div>';
										echo '<div class="content">';
										echo '<div class="text"><a href="'.linkweburl($row['cd_uid'],$row['cd_uname']).'" target="_blank">'.$row['cd_nicheng'].'</a>'.CheckCertify($row['cd_checkmusic'],$row['cd_checkmm'],$row['cd_grade'],$row['cd_viprank']).'<span>：'.$cd_content.'</span></div>';
										echo '<div class="info">';
										echo '<span class="action"><a href="'.cd_upath.'index.php?p=space&a=miniblog&uid='.$row['cd_uid'].'&id='.$row['cd_id'].'" target="_blank">评论['.$row['cd_commentnum'].']</a></span>';
										echo '<span class="update_time">发表于:'.datetime(date('Y-m-d H:i:s',$row['cd_addtime'])).'</span>';
										echo '<span id="'.$row['cd_id'].'" class="del" bid="'.$row['cd_id'].'" title="删除" uid="'.$row['cd_uid'].'"></span>';
										echo '</div>';
										echo '</div>';
										echo '</li>';
									}
								}else{
									echo '<div class="nothing">还没有发表说说。</div>';
								}
							?>
						</ul>
						<?php if($num>0){?><div class="page"><div class="pages"><?php echo $Arr[0]; ?><input type="text" maxlength="5" onkeydown="function c(event,val){e = event ? event :(window.event ? window.event : null);if(e.keyCode==13){val = parseInt(val);val=isNaN(val)||(val<=0)?1:val;window.location.href='<?php echo cd_upath; ?>index.php?p=<?php echo SafeRequest("p","get"); ?>&a=<?php echo SafeRequest("a","get"); ?>&pages='+val+'';return false;}else{return true;}};if(!c(event,this.value))return false;" title="输入页码，按回车快速跳转"/></div></div><?php } ?>
					</div>
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
<script type="text/javascript" src="<?php echo cd_upath; ?>static/space/js/miniblog.js"></script>
<script type="text/javascript">
	nav.helpNoticeInit();
	miniblogLib.miniblogDelInit("#miniblogList"); 
	miniblogLib.miniblogAddInit();
</script>
</body>
</html>