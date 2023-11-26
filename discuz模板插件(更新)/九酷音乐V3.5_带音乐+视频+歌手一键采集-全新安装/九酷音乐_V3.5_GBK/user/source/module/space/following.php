<?php
include "../source/global/global_inc.php";
include "source/module/space/common.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
	<title><?php echo $qianwei_web_nicheng; ?>关注的人</title>
	<link href="/favicon.ico" rel="shortcut icon">
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
					<div id="danceList">
						<div class="spaceMTitle2">
							<p><?php echo $qianwei_web_callname; ?>的关系</p>
							<ul>
								<li class="current">
									<a href="javascript:;"><?php echo $qianwei_web_callname; ?>关注的人</a>
									<b></b>
								</li>
								<li>
									<a href="<?php echo cd_upath.rewrite_url('index.php?p=space&a=fans&uid='.$qianwei_web_userid); ?>"><?php echo $qianwei_web_callname; ?>的粉丝团</a>
									<b></b>
								</li>
								<?php if($qianwei_web_userid == $qianwei_in_userid){ ?>
								<li class="management">
									<a href="<?php echo cd_upath.rewrite_url('index.php?p=relation&a=following'); ?>">管理</a>
								</li>
								<?php } ?>
							</ul>
						</div>
						<div class="title_per"> </div>
						<div class="fansList">
							<?php
								global $db;
								$sql = "select * from ".tname('friend')." where cd_hidden=0 and cd_uid='$qianwei_web_userid' order by cd_addtime desc";
								$Arr = getwebpage($sql, 20, "index.php?p=space&a=".SafeRequest("a","get")."&uid=".$qianwei_web_userid);//sql,每页显示条数
								$result = $db->query($Arr[2]);
								$num = $db->num_rows($result);
								$a=0;
								if($result){
									if($num>0){
										echo '<ul>';
										while ($row = $db ->fetch_array($result)){
											$a=$a+1;
											$user = $db->getrow("select * from ".tname('user')." where cd_id='".$row['cd_uids']."'");
											if($user['cd_introduce']){
												$cd_introduce = getlen('len',15,$user['cd_introduce']);
											}else{
												$cd_introduce = '暂无介绍...';
											}
											echo '<li>';
											echo '<div class="avatar">';
											echo '<a href="'.linkweburl($row['cd_uids'],$row['cd_unames']).'"><img class="avatar-80" width="80" height="80" src="'.getavatar($row['cd_uids'],48).'"/></a>';
											echo '</div>';
											echo '<ul class="info">';
											echo '<li><a title="'.$user['cd_nicheng'].'" href="'.linkweburl($row['cd_uids'],$row['cd_unames']).'">'.$user['cd_nicheng'].'</a>'.CheckCertify($user['cd_checkmusic'],$user['cd_checkmm'],$user['cd_grade'],$user['cd_viprank']).'</li>';
											echo '<li>收藏<strong>'.$user['cd_favnum'].'</strong>首 、 粉丝<strong>'.$user['cd_fansnum'].'</strong>人</li>';
											echo '<li class="describes">简介：'.$cd_introduce.'</li>';
											echo '<li  class="action" id="fans">';
											$sql = "select cd_lock from ".tname('friend')." where cd_uid='$qianwei_in_userid' and cd_uids='".$row['cd_uids']."'";
											if($rows = $db->getrow($sql)){
												if($rows['cd_lock'] == '1'){
													echo '<a onclick="$call(function(){fans.fansDel('.$row['cd_uids'].', \'{'.$user['cd_nicheng'].'}\', 1)});" class="attention mutual" href="javascript:;"></a>';
												}else{
													$cd_groupid = $db->getone("select cd_id from ".tname('friend')." where cd_uid='$qianwei_in_userid' and cd_uids='".$row['cd_uids']."'");
													if($cd_groupid){
														echo '<a onclick="$call(function(){fans.fansDel('.$row['cd_uids'].', \'{'.$user['cd_nicheng'].'}\', 1)});" class="attention already" href="javascript:;"></a>';
													}else{
														echo '<a onclick="$call(function(){fans.fansAdd('.$row['cd_uids'].', \'{'.$user['cd_nicheng'].'}\', 1)});" class="attention" href="javascript:;"></a>';
													}
												}
											}else{
												echo '<a onclick="$call(function(){fans.fansAdd('.$row['cd_uids'].', \'{'.$user['cd_nicheng'].'}\', 1)});" class="attention" href="javascript:;"></a>';
											}
											echo '</li>';
											echo '</ul>';
										}
										echo '</ul>';
									}else{
										echo '<div class="nothing_fans">没关注任何人啊！</div>';
									}
								}
							?>
							<?php if($num>0){?>
								<div class="page" id="page">
									<div class="pages">
										<?php echo $Arr[0]; ?>
										<input type="text" maxlength="5" onkeydown="function c(event,val){e = event ? event :(window.event ? window.event : null);if(e.keyCode==13){val = parseInt(val);val=isNaN(val)||(val<=0)?1:val;window.location.href='<?php echo cd_upath.'index.php?p=space&a=following&uid='.$qianwei_web_userid.'&pages='; ?>'+val;return false;}else{return true;}};if(!c(event,this.value))return false;" title="输入页码，按回车快速跳转"/>
									</div>
								</div>
							<?php } ?>
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