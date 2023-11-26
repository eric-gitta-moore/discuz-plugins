<?php
include "../source/global/global_inc.php";
include "source/module/space/common.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
	<title><?php echo $qianwei_web_nicheng; ?>的最近动态</title>
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
						<p><?php echo $qianwei_web_callname; ?>的最近动态</p>
						<ul>
							<li class="current">
								<a href="<?php echo cd_upath.rewrite_url('index.php?p=space&a=feed&uid='.$qianwei_web_userid); ?>">全部动态</a>
								<b></b>
							</li>
							<li>
								<a href="<?php echo cd_upath.rewrite_url('index.php?p=space&a=miniblog&uid='.$qianwei_web_userid); ?>">随便说说</a>
								<b></b>
							</li>
						</ul>
					</div>
					<div class="title_per"> </div>
					<div class="feedItem">
						<!--有内容-->
						<ul>
							<?php
								global $db;
								$i=0;
								$sql="select * from ".tname('feed')." where cd_uid='$qianwei_web_userid' order by cd_addtime desc";
								$Arr=getwebpage($sql, 15, "index.php?p=space&a=".SafeRequest("a","get")."&uid=".$qianwei_web_userid);//sql,每页显示条数
								$result=$db->query($Arr[2]);
								$num=$db->num_rows($result);
								if($num==0){
									echo '<div class="nothing_feed">'.ReplaceStr($qianwei_web_callname,"我","").'最近没有动态哦-.-!</div>';
								}else{
									if($result){
										while ($row = $db ->fetch_array($result)){
											$i=$i+1;
											$user = $db->getrow("select * from ".tname('user')." where cd_id='".$row['cd_uid']."'");
											$cd_content = preg_replace("/\[em:(\d+)]/is", "<img src=\"".cd_upath."static/images/emot/e\\1.gif\" class=\"face\">", $row['cd_data']);
											echo '<li>';
											echo '<div class="time"><em>'.date('Y',strtotime($row['cd_addtime'])).'</em>'.date('m',strtotime($row['cd_addtime'])).'/'.date('d',strtotime($row['cd_addtime'])).'</div>';
											echo '<i class="square"></i>';
											echo '<div class="feedContent"><a href="javascript:;" style="float:left;"><img width="16" height="16" class="feedIcon" src="'.cd_upath.'static/images/icon/icon_mini_'.$row['cd_icon'].'.gif" /></a><a href="'.linkweburl($row['cd_uid'],$row['cd_uname']).'" target="_blank">'.$user['cd_nicheng'].'</a> '.CheckCertify($user['cd_checkmusic'],$user['cd_checkmm'],$user['cd_grade'],$user['cd_viprank']).'&nbsp;'.$row['cd_title'].'&nbsp;&nbsp;<span class="createTime">'.datetime($row['cd_addtime']).'</span>';
											echo '<div class="detail">';
											if($row['cd_icon'] == 'album'){
        											$query = $db->query("select * from ".tname('pic')." where cd_uid='".$row['cd_uid']."' order by cd_addtime desc LIMIT 0,4");
        											while ($rows = $db->fetch_array($query)) {
													echo '<a href="'.cd_upath.rewrite_url('index.php?p=space&a=album&uid='.$row['cd_uid'].'&id='.$rows['cd_id']).'" target="_blank"><img onerror="$call(function(){libs.imageError(this);}, this)" src="'.getalbumthumb($rows['cd_url'],1).'" class="summaryimg" /></a>';
												}
											}else{
												echo $cd_content;
											}
											echo '</div>';
											echo '</div>';
											echo '</li>';
										}
									}
								}
							?>
						</ul>
						<?php if($num>0){?>
						<div class="page">
							<div class="pages">
								<?php echo $Arr[0]; ?><input type="text" maxlength="5" onkeydown="function c(event,val){e = event ? event :(window.event ? window.event : null);if(e.keyCode==13){val = parseInt(val);val=isNaN(val)||(val<=0)?1:val;window.location.href='<?php echo cd_upath.'index.php?p=space&a=feed&uid='.$qianwei_web_userid.'&pages='; ?>'+val;return false;}else{return true;}};if(!c(event,this.value))return false;" title="输入页码，按回车快速跳转"/>
							</div>
							<div id="currPage"><?php echo SafeRequest("pages","get"); ?></div>
						</div>
						<?php } ?>
						<!--没内容-->
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
</body>
</html>