<?php
	include "../source/global/global_inc.php";
	global $db;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
	<title>音乐分享人推荐 - <?php echo cd_webname; ?></title>
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
<div class="people_content">
	<div class="title">
		<span>音乐分享人推荐</span>
		<ul class="right">
			<li class="share"><a class="indexList on" sid="list5" href="<?php echo cd_upath.rewrite_url('index.php?p=home&a=usershare'); ?>">全部音乐分享人</a><b></b></li>
			<li class="certification"><a class="indexList on" sid="list3" href="<?php echo cd_upath.rewrite_url('index.php?p=home&a=producer'); ?>">全部音乐认证</a><b></b></li>
			<li class="certification on"><a class="indexList on" sid="list3" href="<?php echo cd_upath.rewrite_url('index.php?p=home&a=usersharerec'); ?>">音乐分享人推荐</a><b></b></li>
			<li class="certification"><a class="indexList on" sid="list3" href="<?php echo cd_upath.rewrite_url('index.php?p=home&a=producerrec'); ?>">音乐认证推荐</a><b></b></li>
		</ul>
	</div>
	<div class="content">
		<ul class="people">
			<?php
				$a = 0;
				$sql = "select * from ".tname('user')." where cd_lock=0 and cd_checkmusic=0 and cd_isbest=1 order by cd_id desc";
				$Arr = getwebpage($sql,50,"index.php?p=home&a=usersharerec");
				$result = $db->query($Arr[2]);
				$num = $db->num_rows($result);
				if($num==0){
					echo '<div class="nothing">暂时还没有音乐分享人推荐啊！</div>';
				}else{
					if($result){
						while ($row = $db ->fetch_array($result)){
							$a=$a+1;
							echo '<li>';
							echo '<div class="face">';
							echo '<a target="_blank" href="'.linkweburl($row['cd_id'],$row['cd_name']).'" title="'.$row['cd_nicheng'].'"><img id="menu-avatar" src="'.getavatar($row['cd_id'],200).'"></a>';
							echo '<span>';
							echo '<a target="_blank" href="'.linkweburl($row['cd_id'],$row['cd_name']).'">'.$row['cd_nicheng'].'</a>';
							echo '<a class="certify" href="javascript:;" title="已获得音乐认证" onclick="openWebsite.openTo(\'musiccertify\');"></a>';
							if($row['cd_checkmm']){
								echo '<a class="certify_mm" href="javascript:;" title="通过了美女认证" onclick="openWebsite.openTo(\'certify\');"></a>';
							}
							echo '</span>';
							echo '</div>';
							echo '<div class="text"><span>分享：'.$row['cd_musicnum'].'首</span><span>粉丝：'.$row['cd_fansnum'].'人</span></div>';
							echo '</li>';

						}
					}
				}
			?>
		</ul>
	</div>
</div>
<?php if($Arr[3]>1){ ?>
<div class="people_page">
	<div class="pages">
		<?php echo $Arr[0]; ?><input type="text" maxlength="5" onkeydown="function c(event,val){e = event ? event :(window.event ? window.event : null);if(e.keyCode==13){val = parseInt(val);val=isNaN(val)||(val<=0)?1:val;window.location.href=zone_domain+'<?php echo "index.php?p=home&a=usersharerec&pages="; ?>'+val;return false;}else{return true;}};if(!c(event,this.value))return false;" title="输入页码，按回车快速跳转"/>
	</div>
</div>
<?php } ?>
<div class="bottom">
	<div class="footer">
		<?php include "source/module/system/footer.php"; ?>
	</div>
</div>
<script type="text/javascript">
	nav.init();
	nav.userMenu();
	libs.checkLogin();
	select.init('sex');
	select.init('province');
</script>
</body>
</html>