<?php
	include "../source/global/global_inc.php";
	global $db;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
	<title>美女认证 - <?php echo cd_webname; ?></title>
	<script type="text/javascript">
		var domIsReady=false,domReadyList=[],domReadyObject=[],$call=function(callback,obj){if(typeof obj!=='object'){obj=document}if(domIsReady){callback.call(obj)}else{domReadyList.push(callback);domReadyObject.push(obj)}};
		var site_domain="<?php echo cd_webpath; ?>";zone_domain="<?php echo cd_upath; ?>";
	</script>
	<link type="text/css" href="<?php echo cd_upath; ?>static/css/core.css" rel="stylesheet" />
	<link type="text/css" href="<?php echo cd_upath; ?>static/site/css/common.css" rel="stylesheet" media="all" />
	<script type="text/javascript" src="<?php echo cd_upath; ?>static/js/jquery/jquery.min.js"></script>
	<script type="text/javascript" src="<?php echo cd_upath; ?>static/js/core.js"></script>
	<script type="text/javascript" src="<?php echo cd_upath; ?>static/js/card.js"></script>
	<script type="text/javascript" src="<?php echo cd_upath; ?>static/js/dialog.js"></script>
	<script type="text/javascript" src="<?php echo cd_upath; ?>static/site/js/common.js"></script>
</head>
<body>
<div class="header"><?php include "source/module/system/header.php"; ?></div>
<div class="privilege">
	<div class="privilege_box">
		<div class="title"></div>
		<div class="box">
			<span>在认证通过后，系统将会奖励您800积分，魅力无限！</span>
			<span>真实认证通过后，照片被网站推荐后，每张推荐照片奖励100积分！</span>
			<span>真实认证通过后，每天签到积分变双倍，天天不差分！</span>
			<span>真实认证通过后，更容易被关注，明星MM万众瞩目！</span>
		</div>
		<a class="privilege_icon" href="<?php echo cd_upath.rewrite_url('index.php?p=user&a=applyCertify'); ?>">马上进行身份认证，获得更多特权  >></a>
	</div>
</div>
<div class="privilege_content">
	<ul class="mood" id="imageList">
		<?php
			$a = 0;
			$sql = "select cd_id,cd_name,cd_nicheng from ".tname('user')." where cd_lock=0 and cd_checkmm=1 order by cd_logintime desc,cd_loginnum desc";
			$Arr = getwebpage($sql,100,"index.php?p=home&a=privilege");
			$result = $db->query($Arr[2]);
			if($result){
				while ($row = $db ->fetch_array($result)){
					$a=$a+1;
					echo '<li class="imageBlock imageBlock_0 masonry-brick">';
					echo '<div class="box">';
					echo '<a href="'.linkweburl($row['cd_id'],$row['cd_name']).'" target="_blank"><img width="160" src="'.getavatar($row['cd_id'],200).'"></a>';
					echo '<div class="name">';
					echo '<p class="hover"><a href="'.linkweburl($row['cd_id'],$row['cd_name']).'" target="_blank">'.$row['cd_nicheng'].'</a><a title="赞我一下" onclick="user.praiseUser('.$row['cd_id'].', \''.$row['cd_nicheng'].'\', 0, 0, 1, 1);" class="praise_num" href="javascript:;"></a></p>';
					echo '<div class="clear"></div>';
					echo '</div>';
					echo '</div>';
					echo '</li>';
				}
			}
		?>
	</ul>
	<?php if($Arr[3]>1){ ?>
	<div id="imgPages" class="album_button" style="display:block;">
		<div class="pages"><?php echo $Arr[0]; ?><input type="text" maxlength="5" onkeydown="function c(event,val){e = event ? event :(window.event ? window.event : null);if(e.keyCode==13){val = parseInt(val);val=isNaN(val)||(val<=0)?1:val;window.location.href=zone_domain+'<?php echo "index.php?p=home&a=privilege&pages="; ?>'+val;return false;}else{return true;}};if(!c(event,this.value))return false;" title="输入页码，按回车快速跳转"/></div>
	</div>
	<?php } ?>
</div>
<div class="bottom">
	<div class="footer">
		<?php include "source/module/system/footer.php"; ?>
	</div>
</div>
<script type="text/javascript">
	nav.init();
	libs.checkLogin();
	nav.userMenu();
</script>
</body>
</html>