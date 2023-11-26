<?php
	include "../source/global/global_inc.php";
	VerifyLogin($qianwei_in_userid);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
	<title>空间首页照片排序 - <?php echo cd_webname; ?></title>
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
							<a class="on" href="<?php echo cd_upath.rewrite_url('index.php?p=album&a=me'); ?>">我的照片</a>
						</li>
						<li class="fond">
							<a href="<?php echo cd_upath.rewrite_url('index.php?p=album&a=praise'); ?>">喜欢的照片</a>
						</li>
						<li class="friend">
							<a href="<?php echo cd_upath.rewrite_url('index.php?p=album&a=following'); ?>">好友的照片</a>
						</li>
					</ul>
					<div class="action">
						<a href="<?php echo cd_upath.rewrite_url('index.php?p=album&a=add'); ?>">上传照片</a>
					</div>
				</div>
				<div class="main_nav2">
					<ul>
						<li>
							<a href="<?php echo cd_upath.rewrite_url('index.php?p=album&a=me'); ?>">照片列表</a>
						</li>
						<li class="current">
							<a href="<?php echo cd_upath.rewrite_url('index.php?p=album&a=imageSpaceSort'); ?>">首页显示</a>
						</li>
						<li>
							<a href="<?php echo cd_upath.rewrite_url('index.php?p=album&a=imageSort'); ?>">重新排序</a>
						</li>
					</ul>
					<div id="tooltip" class="refresh">

					</div>
				</div>
				<div class="minHeight500">
					<div class="imageSort">
						<?php
							global $db;
							$a=0;
							$sql="select * from ".tname('pic')." where cd_uid='$qianwei_in_userid' order by cd_weborder desc";
							$Arr=getuserpage($sql,70);//sql,每页显示条数
							$result=$db->query($Arr[2]);
							$num=$db->num_rows($result);
							if($num==0){
								echo '<div class="nothing">还没有上传照片啊，快上传您喜欢的照片吧！</div>';
							}else{
								if($result){
									echo '<div id="imageSort1" class="sortable">';
									while ($row = $db ->fetch_array($result)){
										$a=$a+1;
										echo '<img id="'.$row['cd_id'].'" class="imgfile" src="'.getalbumthumb($row['cd_url'],1).'" uid="'.$row['cd_uid'].'" height="80" width="80" onerror="$call(function(){libs.imageError(this);}, this)"/>';
									}
									echo '</div>';
									echo '<div class="space_sort_utton">';
									echo '<span class="button-main">';
									echo '<span><button id="saveButton">保存结果</button></span>';
									echo '</span>';
									echo '</div>';
									echo '<div id="imageSort2" class="sortable"></div>';
								}
							}
						?>
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
<script type="text/javascript" src="<?php echo cd_upath; ?>static/space/js/album.js"></script>
<script type="text/javascript" src="<?php echo cd_upath; ?>static/space/js/jquery/jquery.ui.custom.min.js"></script>
<script type="text/javascript">nav.helpNoticeInit();albumLib.imageSpaceSortInit();</script>
</body>
</html>