<?php
include "../source/global/global_inc.php";
global $db;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html;charset=gb2312" />
<meta name="Keywords" content="<?php echo cd_keywords; ?>" />
<meta name="Description" content="<?php echo cd_description; ?>" />
<title>会员首页 - <?php echo cd_webname; ?> - <?php echo cd_weburl; ?></title>
<link rel="stylesheet" type="text/css" href="<?php echo cd_upath; ?>static/css/core.css" />
<link rel="stylesheet" type="text/css" href="<?php echo cd_upath; ?>static/site/css/common.css" />
<script type="text/javascript" src="<?php echo cd_upath; ?>static/js/jquery/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo cd_upath; ?>static/js/core.js"></script>
<script type="text/javascript" src="<?php echo cd_upath; ?>static/js/card.js"></script>
<script type="text/javascript" src="<?php echo cd_upath; ?>static/js/dialog.js"></script>
<script type="text/javascript" src="<?php echo cd_upath; ?>static/site/js/common.js"></script>
<script type="text/javascript">var site_domain="<?php echo cd_webpath; ?>";zone_domain="<?php echo cd_upath; ?>";</script>
</head>
<body>
<div class="header"><?php include "source/module/system/header.php"; ?></div>
<div class="friend_content">
	<div class="title"><span class="name">他们在这里分享音乐、发现知音</span><span>当前活跃用户<strong><?php echo $db->num_rows($db->query("select cd_id from ".tname('user')." where cd_lock=0 and DateDiff(DATE(cd_logintime),'".date('Y-m-d')."')>=-3")); ?></strong>人</span></div>
	<ul class="irregular">
			<?php
				$a = 0;
        			$query = $db->query("select * from ".tname('user')." where cd_lock=0 and DateDiff(DATE(cd_logintime),'".date('Y-m-d')."')>=-3 order by cd_logintime desc LIMIT 0,9");
				echo '<li class="ir3"><img src="'.cd_upath.'static/site/images/bad_photo/7.jpg"></li>';
        			while ($row = $db->fetch_array($query)) {
					$a = $a+1;
					if($a == 1){
						echo '<li class="ir1">';
						echo '<a href="'.linkweburl($row['cd_id'],$row['cd_name']).'" title="'.$row['cd_nicheng'].'" target="_blank"><img src="'.getavatar($row['cd_id'],120).'"></a>';
						echo '</li>';
					}else{
						echo '<li class="ir2">';
						echo '<a href="'.linkweburl($row['cd_id'],$row['cd_name']).'" title="'.$row['cd_nicheng'].'" target="_blank"><img src="'.getavatar($row['cd_id'],120).'"></a>';
						echo '</li>';
					}
					if($a == 2){
						echo '<li class="ir2"><img src="'.cd_upath.'static/site/images/bad_photo/1.jpg"></li>';
					}elseif($a == 3){
						echo '<li class="ir2"><img src="'.cd_upath.'static/site/images/bad_photo/2.jpg"></li>';
					}elseif($a == 4){
						echo '<li class="ir2"><img src="'.cd_upath.'static/site/images/bad_photo/3.jpg"></li>';
					}elseif($a == 5){
						echo '<li class="ir2"><img src="'.cd_upath.'static/site/images/bad_photo/4.jpg"></li>';
					}elseif($a == 6){
						echo '<li class="ir2"><img src="'.cd_upath.'static/site/images/bad_photo/5.jpg"></li>';
					}elseif($a == 7){
						echo '<li class="ir2"><img src="'.cd_upath.'static/site/images/bad_photo/6.jpg"></li>';
					}
				}
			?>
	</ul>
</div>
<div class="friend_content_list">
	<div class="title">
		<span class="name">音乐认证</span>
		<span><a href="<?php echo cd_upath.rewrite_url('index.php?p=home&a=producerrec'); ?>" target="_blank">更多>></a></span>
	</div>
	<ul>
		<?php
        		$query = $db->query("select * from ".tname('user')." where cd_lock=0 and cd_checkmusic=1 order by cd_musicnum desc LIMIT 0,6");
        		while ($row = $db->fetch_array($query)) {
				if(!empty($row['cd_introduce'])){
					$cd_introduce = getlen("len","15",$row['cd_introduce']);
				}else{
					$cd_introduce = '这家伙很懒，什么也没留下。';
				}
				echo '<li>';
				echo '<div class="left"><a href="'.linkweburl($row['cd_id'],$row['cd_name']).'" target="_blank"><img alt="'.$row['cd_nicheng'].'" src="'.getavatar($row['cd_id'],120).'"></a><a href="'.linkweburl($row['cd_id'],$row['cd_name']).'" class="name" target="_blank">'.$row['cd_nicheng'].'</a></div>';
				echo '<div class="right">';
				echo '<strong>分享'.$row['cd_musicnum'].'首音乐</strong>';
				echo '<ul class="list"><li>关注：'.$row['cd_idolnum'].'人&nbsp;&nbsp;&nbsp;&nbsp;粉丝：'.$row['cd_fansnum'].'人 </li><li class="describes">个人介绍：'.$cd_introduce.'</li></ul>';
				echo '<a class="know" href="'.cd_upath.rewrite_url('index.php?p=space&a=dance&uid='.$row['cd_id']).'" target="_blank">更多音乐>></a>';
				echo '</div>';
				echo '</li>';
			}
		?>
	</ul>
</div>
<div class="friend_content">
	<div class="album_title">
		<span class="name">乐迷相册</span>
		<span><a href="<?php echo cd_upath.rewrite_url('index.php?p=home&a=album'); ?>" target="_blank">更多>></a></span>
	</div>
	<ul class="album">
		<?php
			$a = 0;
			$query = $db->query("select * from ".tname('pic')." order by cd_addtime desc LIMIT 0,12");
        		while ($row = $db->fetch_array($query)) {
				$a = $a+1;
				echo '<li id="image_'.$a.'" onmouseover="$(\'#image_'.$a.'\').addClass(\'on\');" onmouseout="$(\'#image_'.$a.'\').removeClass(\'on\');"><a href="'.cd_upath.rewrite_url('index.php?p=space&a=album&uid='.$row['cd_uid'].'&id='.$row['cd_id']).'" title="'.$row['cd_title'].'" target="_blank"><img width="160" src="'.getalbumthumb($row['cd_url'],0).'"><em></em></a></li>';
			}
		?>
	</ul>
</div>
<div class="bottom friend_bottom">
	<div class="footer"><?php include "source/module/system/footer.php"; ?></div>
</div>
<script type="text/javascript">
	nav.init();
	nav.userMenu();
	libs.checkLogin();
	libs.selectList();
	rolling.init();
	libs.spaceDanceListSmall(0, 10);
	var $links = $("#links");
	var $partner = $("#partner");
	var $Hlinks = $("#Hlinks");
	var $Hpartner = $("#Hpartner");
	$Hlinks.mouseover(function(){
		$partner.hide();
		$links.show();
		$Hlinks.attr("class", "default");
		$Hpartner.attr("class", "synergic");
	});
	$Hpartner.mouseover(function(){
		$links.hide();
		$partner.show();
		$Hpartner.attr("class", "current");
		$Hlinks.attr("class", "link");
	});
</script>
</body>
</html>