<?php
include "../source/global/global_inc.php";
global $db;
VerifyLogin($qianwei_in_userid);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>会员中心 - <?php echo cd_webname; ?></title>
<link type="text/css" href="<?php echo cd_upath; ?>static/css/core.css" rel="stylesheet" />
<link type="text/css" href="<?php echo cd_upath; ?>static/site/css/common.css" rel="stylesheet" />
<link type="text/css" href="<?php echo cd_upath; ?>static/space/css/common.css" rel="stylesheet" media="all" />
<link type="text/css" href="<?php echo cd_upath; ?>static/space/css/user.css" rel="stylesheet" media="all" />
<script type="text/javascript">
var domIsReady=false,domReadyList=[],domReadyObject=[],$call=function(callback,obj){if(typeof obj!=='object'){obj=document}if(domIsReady){callback.call(obj)}else{domReadyList.push(callback);domReadyObject.push(obj)}};
var site_domain="<?php echo cd_webpath; ?>";zone_domain="<?php echo cd_upath; ?>";
</script>
</head>
<body>
<div class="header"><?php include "source/module/system/header.php"; ?></div>
<div class="user">
	<div class="user_center">
		<div class="user_menu" id="mfeed">
			<?php include "source/module/system/left_menu.php"; ?>
		</div>
		<div class="user_main">
			<div class="uMain_home_left">
				<div class="stage_box">
					<div class="user_info">
						<div class="info">
							<div class="title">有什么新鲜事想告诉大家？</div>
							<span></span>
						</div>
						<span class="arrow"></span>
						<div class="doing">
							<div id="note" contenteditable="true" class="blogInput" name="note"></div>	
							<div id="act" class="act" style="display: block;">
								<div id="emot_note" class="emot" to="note"></div><!--表情-->
								<div class="button">
									<span class="button-main">
										<span>
											<button type="button" class="send">发布</button>
										</span>
									</span>
								</div>
							</div>
						</div>		
					</div>
					<div class="notice">
						<div class="title"></div>
						<ul class="box">
							<?php
        							$query = $db->query("select a.cd_uid,a.cd_uname,a.cd_points,a.cd_addtime,b.cd_nicheng from ".tname('slot')." as a,".tname('user')." as b where a.cd_uid = b.cd_id order by cd_addtime desc LIMIT 0,5");
        							while ($row = $db->fetch_array($query)) {
									echo '<li class="c1">';
									echo '<span class="name"><a href="'.linkweburl($row['cd_uid'],$row['cd_uname']).'" target="_blank">'.$row['cd_nicheng'].'</a></span>';
									echo '<div class="text">获得了幸运摇一摇奖励，获得<span>'.$row['cd_points'].'</span>积分奖励。</div>';
									echo '<span class="time">'.date("m-d H:i:s",strtotime($row['cd_addtime'])).'</span>';
									echo '</li>';
								}
							?>
							<!--<span class="more"></span>-->
						</ul>
					</div>
					<div class="feed_menu">
						<ul>
							<li>
								<a id="friend_feed" class="on" onclick="libs.feedNew(0);$('#refresh').attr({'cid':0, type:0});" href="javascript:;">好友动态</a>
							</li>
							<li>
								<a id="feed_all"  onclick="libs.feedNew(2);$('#refresh').attr({'cid':2, type:0});" href="javascript:;">全站动态</a>
							</li>
							<li>
								<a id="feed_me" onclick="libs.feedNew(3);$('#refresh').attr({'cid':3, type:0});" href="javascript:;">我的动态</a>
							</li>
						</ul>
					</div>
					<div class="feed_menu2">
						<ul id="a1">
							<li id="feed_0">
								<a onclick="libs.showFeedMenu(0, 0);$('#refresh').attr({'cid':0, type:0});" href="javascript:;">全部动态</a>
							</li>
							<li id="feed_1">
								<a onclick="libs.showFeedMenu(1, 0);$('#refresh').attr({'cid':0, type:1});" href="javascript:;">分享音乐</a>
							</li>
							<li id="feed_2">
								<a onclick="libs.showFeedMenu(2, 0);$('#refresh').attr({'cid':0, type:2});" href="javascript:;">收藏音乐</a>
							</li>
							<li id="feed_3">
								<a onclick="libs.showFeedMenu(3, 0);$('#refresh').attr({'cid':0, type:3});" href="javascript:;">发表说说</a>
							</li>
							<li id="feed_4">
								<a onclick="libs.showFeedMenu(4, 0);$('#refresh').attr({'cid':0, type:4});" href="javascript:;">上传照片</a>
							</li>
						</ul>
						<ul id="a2" style="display: none;">
							<li id="feedA_0">
								<a onclick="libs.showFeedMenu(0, 2);$('#refresh').attr({'cid':2, type:0});" href="javascript:;">全部动态</a>
							</li>
							<li id="feedA_1">
								<a onclick="libs.showFeedMenu(1, 2);$('#refresh').attr({'cid':2, type:1});" href="javascript:;">分享音乐</a>
							</li>
							<li id="feedA_2">
								<a onclick="libs.showFeedMenu(2, 2);$('#refresh').attr({'cid':2, type:2});" href="javascript:;">收藏音乐</a>
							</li>
							<li id="feedA_3">
								<a onclick="libs.showFeedMenu(3, 2);$('#refresh').attr({'cid':2, type:3});" href="javascript:;">发表说说</a>
							</li>
							<li id="feedA_4">
								<a onclick="libs.showFeedMenu(4, 2);$('#refresh').attr({'cid':2, type:4});" href="javascript:;">上传照片</a>
							</li>
						</ul>
						<div id="tooltip" class="refresh">
							<a class="eda" title="刷新" href="javascript:;" id="refresh" cid="4" type="0"> </a>
						</div>
					</div>
					<div class="feed" id="feed">
						<div class="load"></div>
					</div>
				</div>
			</div>
			<div class="uMain_home_right">
				<div class="space_user_info">
					<div class="user_sign" href="javascript:;" title="已经连续签到<?php echo $qianwei_in_sign; ?>天，累计签到<?php echo $qianwei_in_signcumu; ?>天" id="user_sign" num="<?php echo $qianwei_in_signcumu; ?>">
						<span class="date"><?php echo date('m',time()); ?>.<?php echo date('d',time()); ?></span>
						<span class="week">
						<?php
							if(date("w",time()) == 1){
								echo "周一";
							}elseif(date("w",time()) == 2){
								echo "周二";
							}elseif(date("w",time()) == 3){
								echo "周三";
							}elseif(date("w",time()) == 4){
								echo "周四";
							}elseif(date("w",time()) == 5){
								echo "周五";
							}elseif(date("w",time()) == 6){
								echo "周六";
							}else{
								echo "周日";
							}
						?>
						</span>
						<span id="checkinFaceId" class="face face_empty bg_checkin"></span>
						<span class="time_tip">DAY</span>
						<strong class="time" id="time"><?php echo $qianwei_in_sign; ?></strong>
						<button class="user_sign_but" onclick="$call(function(){libs.userSign()});" id="user_sign_but"></button>
					</div>
					<a href="javascript:;" class="random" onclick="libs.rand();">
						<span class="time_tip">NUM</span>
						<?php
							$slotsql = "select cd_number from ".tname('slot')." where cd_uid='$qianwei_in_userid'";
        						if($slotrow = $db->getrow($slotsql)){
								echo '<strong class="time" title="累计摇奖'.$slotrow['cd_number'].'次" id="time1">'.$slotrow['cd_number'].'</strong>';
							}else{
								echo '<strong class="time" title="累计摇奖0次" id="time1">0</strong>';
							}
						?>
					</a>
				</div>
				<div class="sFriendTitle">
					<span>最近访客</span>
					<p>
						<a href="<?php echo cd_upath.rewrite_url('index.php?p=relation&a=visitorIn'); ?>" target="_blank">更多</a>
					</p>
				</div>
				<ul class="sFriend">
					<?php
        					$query = $db->query("select a.cd_uid,a.cd_uname,a.cd_addtime,b.cd_nicheng from ".tname('footprints')." as a,".tname('user')." as b where a.cd_uid = b.cd_id and cd_uids='$qianwei_in_userid' order by cd_addtime desc LIMIT 0,9");
        					while ($row = $db->fetch_array($query)) {
							echo '<li>';
							echo '<div class="friendAvatar"><a href="'.linkweburl($row['cd_uid'],$row['cd_uname']).'" target="_blank"><img src="'.getavatar($row['cd_uid'],48).'" /></a></div>';
							echo '<div class="friendInfo"><span><a href="'.linkweburl($row['cd_uid'],$row['cd_uname']).'" title="'.$row['cd_nicheng'].'" target="_blank">'.$row['cd_nicheng'].'</a></span><p>'.date('m',strtotime($row['cd_addtime'])).'月'.date('d',strtotime($row['cd_addtime'])).'日</p></div>';
							echo '</li>';
						}
					?>
				</ul>
				<div class="sFriendTitle">
					<span>关注<em>[<?php echo $qianwei_in_idolnum; ?>]</em></span>
					<p>
						<a href="<?php echo cd_upath.rewrite_url('index.php?p=relation&a=following'); ?>" target="_blank">更多</a>
					</p>
				</div>
				<ul class="sFriend">
					<?php
        					$query = $db->query("select * from ".tname('friend')." where cd_uid='$qianwei_in_userid' order by cd_addtime desc LIMIT 0,9");
        					while ($row = $db->fetch_array($query)) {
							$user = $db->getrow("select cd_nicheng from ".tname('user')." where cd_id='".$row['cd_uids']."'");
							echo '<li>';
							echo '<div class="friendAvatar"><a href="'.linkweburl($row['cd_uids'],$row['cd_unames']).'"><img width="48" height="48" src="'.getavatar($row['cd_uids'],48).'" onerror="pubLibs.avatarError(this,\'small\');" title="'.$user['cd_nicheng'].'"/></a></div>';
							echo '<div class="friendInfo"><span><a href="'.linkweburl($row['cd_uids'],$row['cd_unames']).'" title="'.$user['cd_nicheng'].'">'.$user['cd_nicheng'].'</a></span><p></p></div>';
							echo '</li>';
						}
					?>
				</ul>
			</div>
		</div>
	</div>
	<div id="rand">
		
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
<script type="text/javascript" src="<?php echo cd_upath; ?>static/space/js/slot.js"></script>
<script type="text/javascript" src="<?php echo cd_upath; ?>static/space/js/miniblog.js"></script>
<script type="text/javascript">
	nav.helpNoticeInit();
	libs.feed();
	libs.showFeedMenu1();
	miniblogLib.miniblogHomeAddInit();
	account.doListenAccountInit();
</script>
</body>
</html>