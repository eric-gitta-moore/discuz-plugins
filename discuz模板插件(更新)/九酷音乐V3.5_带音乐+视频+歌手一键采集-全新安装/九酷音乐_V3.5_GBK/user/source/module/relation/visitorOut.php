<?php
	include "../source/global/global_inc.php";
	VerifyLogin($qianwei_in_userid);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
	<title>我看过谁 - <?php echo cd_webname; ?></title>
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
		<div class="user_menu" id="fansm">
			<?php include "source/module/system/left_menu.php"; ?>
		</div>
		<div class="user_main">
			<div class="uMain_content">
				<div class="main_nav">
					<ul>
						<li class="attention">
							<a href="<?php echo cd_upath.rewrite_url('index.php?p=relation&a=following'); ?>">我的关注</a>
						</li>
						<li class="fans">
							<a href="<?php echo cd_upath.rewrite_url('index.php?p=relation&a=fans'); ?>">我的粉丝</a>
						</li>
						<li class="praise">
							<a href="<?php echo cd_upath.rewrite_url('index.php?p=relation&a=userPraiseIn'); ?>">赞与被赞</a>
						</li>
						<li class="visitor">
							<a class="on" href="<?php echo cd_upath.rewrite_url('index.php?p=relation&a=visitorIn'); ?>">访问脚印</a>
						</li>
					</ul>
				</div>
				<div class="main_nav2">
					<ul>
						<li>
							<a href="<?php echo cd_upath.rewrite_url('index.php?p=relation&a=visitorIn'); ?>">谁看过我</a>
						</li>
						<li class="current">
							<a href="<?php echo cd_upath.rewrite_url('index.php?p=relation&a=visitorOut'); ?>">我看过谁</a>
						</li>
					</ul>
					<div id="tooltip" class="refresh">

					</div>
				</div>
				<div class="minHeight500">
					<div class="relation_userlist">
						<?php
							global $db;
							$sql = "select * from ".tname('footprints')." where cd_uid='$qianwei_in_userid' order by cd_addtime desc";
							$Arr = getuserpage($sql,12);//sql,每页显示条数
							$result = $db->query($Arr[2]);
							$num = $db->num_rows($result);
							$a=0;
							if($result){
								if($num>0){
									echo '<ul>';
									while ($row = $db ->fetch_array($result)){
										$a=$a+1;
										$user = $db->getrow("select cd_nicheng,cd_favnum,cd_fansnum,cd_introduce,cd_checkmusic,cd_checkmm,cd_grade,cd_viprank from ".tname('user')." where cd_id='".$row['cd_uids']."'");
										if($user['cd_introduce']){
											$cd_introduce = getlen('len',15,$user['cd_introduce']);
										}else{
											$cd_introduce = '这个人很懒，什么也没有留下。';
										}
										echo '<li>';
										echo '<div class="avatar">';
										echo '<a href="'.linkweburl($row['cd_uids'],$row['cd_unames']).'" target="_blank">';
										echo '<img class="avatar-80" width="80" height="80" src="'.getavatar($row['cd_uids'],48).'"/>';
										echo '</a>';
										echo '</div>';
										echo '<ul class="info">';
										echo '<li><a href="'.linkweburl($row['cd_uids'],$row['cd_unames']).'" target="_blank">'.$user['cd_nicheng'].'</a>'.CheckCertify($user['cd_checkmusic'],$user['cd_checkmm'],$user['cd_grade'],$user['cd_viprank']).'</li>';
										echo '<li>收藏<strong>'.$user['cd_favnum'].'</strong>首 、 粉丝<strong>'.$user['cd_fansnum'].'</strong>人</li>';
										echo '<li>操作时间：'.datetime($row['cd_addtime']).'</li>';
										echo '<li class="describes">简介：'.$cd_introduce.'</li>';
										echo '<li class="action">';
										$cd_groupid = $db->getone("select cd_id from ".tname('friend')." where cd_uid='$qianwei_in_userid' and cd_uids='".$row['cd_uids']."'");
										if($cd_groupid){
											echo '<a onclick="$call(function(){fans.fansDel('.$row['cd_uids'].', \''.$user['cd_nicheng'].'\', 1)});" class="attention mutual" href="javascript:;"></a>';
										}else{
											echo '<a onclick="$call(function(){fans.fansAdd('.$row['cd_uids'].', \''.$user['cd_nicheng'].'\', 1)});" class="attention" href="javascript:;"></a>';
										}
										echo '</li>';
										echo '</ul>';
										echo '</li>';
									}
									echo '</ul>';
								}else{
									echo '<div class="nothing">没有人来过呢！</div>';
								}
							}
						?>
					</div>
					
					<?php if($num>0){?><div class="page"><div class="pages"><?php echo $Arr[0]; ?><input type="text" maxlength="5" onkeydown="function c(event,val){e = event ? event :(window.event ? window.event : null);if(e.keyCode==13){val = parseInt(val);val=isNaN(val)||(val<=0)?1:val;window.location.href='<?php echo cd_upath; ?>index.php?p=<?php echo SafeRequest("p","get"); ?>&a=<?php echo SafeRequest("a","get"); ?>&pages='+val+'';return false;}else{return true;}};if(!c(event,this.value))return false;" title="输入页码，按回车快速跳转"/></div></div><?php } ?>

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
<script type="text/javascript" src="<?php echo cd_upath; ?>static/space/js/relation.js"></script>
<script type="text/javascript">nav.helpNoticeInit();relation.init();</script>
</body>
</html>