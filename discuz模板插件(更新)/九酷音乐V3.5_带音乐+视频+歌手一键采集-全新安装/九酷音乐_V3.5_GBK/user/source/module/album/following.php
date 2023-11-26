<?php
	include "../source/global/global_inc.php";
	VerifyLogin($qianwei_in_userid);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
	<title>关注的照片 - <?php echo cd_webname; ?></title>
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
		<div class="user_menu"  id="albumm">
			<?php include "source/module/system/left_menu.php"; ?>
		</div>
		<div class="user_main">
			<div class="uMain_content">
				<div class="main_nav">
					<ul>
						<li class="me">
							<a href="<?php echo cd_upath.rewrite_url('index.php?p=album&a=me'); ?>">我的照片</a>
						</li>
						<li class="fond">
							<a href="<?php echo cd_upath.rewrite_url('index.php?p=album&a=praise'); ?>">喜欢的照片</a>
						</li>
						<li class="friend">
							<a class="on" href="<?php echo cd_upath.rewrite_url('index.php?p=album&a=following'); ?>">好友的照片</a>
						</li>
					</ul>
					<div class="action">
						<a href="<?php echo cd_upath.rewrite_url('index.php?p=album&a=add'); ?>">上传照片</a>
					</div>
				</div>
				<div class="main">
					<div id="tooltip" class="refresh">

					</div>
				</div>
				<?php
					global $db;
					$a=0;
					$sql="select * from ".tname('pic')." where cd_uid in(".GetFolloWing($qianwei_in_userid,0).") order by cd_addtime desc";
					$Arr=getuserpage($sql,100);//sql,每页显示条数
					$result=$db->query($Arr[2]);
					$num=$db->num_rows($result);
					$lpids="";
					if($num==0){
						echo '<div class="nothing">您关注的人暂时还没有照片啊！</div>';
					}else{
						if($result){
							echo '<ul id="imageList" class="image_following"></ul>';
							echo '<div id="imgLoading" class="image_loading"></div>';
							echo '<div id="imgPages" class="album_button page" style="display:none;">';
							while ($row = $db ->fetch_array($result)){
								$a=$a+1;
								$user = $db->getrow("select cd_nicheng from ".tname('user')." where cd_id='".$row['cd_uid']."'");
								$lpids=$lpids."{'pid': ".$row['cd_id'].",'src':'".getalbumthumb($row['cd_url'],2)."','create_time':'".datetime(date('Y-m-d',$row['cd_addtime']))."','uid':".$row['cd_uid'].",'praiseNum':".$row['cd_praisenum'].",'replyNum':".$row['cd_replynum'].",'width':".$row['cd_width'].",'height':".$row['cd_height'].",'avatar':'".getavatar($row['cd_uid'],48)."','nickname':'".$user['cd_nicheng']."'},";
							}
							$lpids=$lpids.']';
							$lpids=ReplaceStr($lpids,",]","");

							if($num>0){ ?>
							<div class="pages">
							<?php echo $Arr[0]; ?><input type="text" maxlength="5" onkeydown="function c(event,val){e = event ? event :(window.event ? window.event : null);if(e.keyCode==13){val = parseInt(val);val=isNaN(val)||(val<=0)?1:val;window.location.href=zone_domain+'<?php echo "index.php?p=album&a=following&pages="; ?>'+val;return false;}else{return true;}};if(!c(event,this.value))return false;" title="输入页码，按回车快速跳转"/>
							</div>
							<?php }
							echo '</div>';
						}
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
<script type="text/javascript">listenMsg.start();nav.init();nav.userMenu();</script>
<script type="text/javascript" src="<?php echo cd_upath; ?>static/js/jquery/jquery.masonry.min.js"></script>
<script type="text/javascript" src="<?php echo cd_upath; ?>static/space/js/album.js"></script>
<script type="text/javascript">
	nav.helpNoticeInit();
	var imgDatas = [<?php echo $lpids; ?>];
	imgLoaded.init('#imageList', imgDatas, 1);
	libs.spaceInit();
</script>
</body>
</html>