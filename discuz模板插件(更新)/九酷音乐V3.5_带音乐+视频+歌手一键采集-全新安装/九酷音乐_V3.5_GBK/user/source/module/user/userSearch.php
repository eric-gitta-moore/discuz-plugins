<?php
	include "../source/global/global_inc.php";
	global $db;
        VerifyLogin($qianwei_in_userid);
	$key = unescape(SafeRequest("key","get"));
	$sex = SafeRequest("sex","get");
	$code = unescape(SafeRequest("code","get"));
	$searchsql = "";
	if($key){
		$searchsql.= "and cd_nicheng like '%".$key."%'";
	}
	if($sex){
		$searchsql.= "and cd_sex='".$sex."'";
	}
	if($code){
		$searchsql.= "and cd_address like '%".$code."%'";
	}
	$sql = "select * from ".tname('user')." where cd_lock=0 $searchsql order by cd_logintime desc";
	$num = $db->num_rows($db->query($sql));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
	<title>搜索用户 - <?php echo cd_webname; ?></title>
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
<div class="member_content">
	<div class="title">
		<div class="name">用户搜索</div>
		<div class="number">找到<span><?php echo $num; ?></span>人</div>
		<div class="right">
			<form id="searchForm" onSubmit="relation.userSearch();return false;">
				<div class="keywords"><span>昵称关键字:</span><input id="keyword" type="text" value="<?php echo $key; ?>" style="width:120px" size="10" name="keyword"></div>
				<div class="sex"><span>性别:</span><div class="list"><a id="sex" class="list_a" href="javascript:;">性别<b class="arrow"></b></a><div class="sort" style="display: none;"><a href="javascript:;">男</a><a href="javascript:;">女</a></div></div></div>
				<div class="province">
					<span>省份:</span>
					<div class="list_province">
						<a id="province" class="list_a" href="javascript:;" val=''>省份<b class="arrow"></b></a>
						<div class="sort_list" style="display: none;">
							<?php
								global $db;
        							$query = $db->query("select cd_name from ".tname('district')." where cd_level=1 order by cd_id asc");
        							while ($row = $db->fetch_array($query)) {
									echo '<a href="javascript:;" onclick="$(\'#province\').attr(\'val\',\''.$row['cd_name'].'\');">'.$row['cd_name'].'</a>';
								}
							?>
						</div>
					</div>
				</div>
				<input class="search" type="submit" value=""></input>
			</form>
		</div>
		<ul class="sort">
			<li><span><a href="<?php echo cd_upath.rewrite_url('index.php?p=home&a=useractive'); ?>">活跃用户</a></span></li>
			<li><span><a href="<?php echo cd_upath.rewrite_url('index.php?p=home&a=online'); ?>">在线用户</a></span></li>
			<li class="current"><span><a href="<?php echo cd_upath.rewrite_url('index.php?p=user&a=userSearch'); ?>">用户搜索</a></span></li>
		</ul>
	</div>
	<div class="box">
		<ul>
			<?php
				global $db;
				$a = 0;
				$Arr = getwebpage($sql,20,"index.php?p=user&a=userSearch");
				$result = $db->query($Arr[2]);
				if($num==0){
					echo '<div class="nothing">没有找到昵称中含有<strong>'.$key.'</strong>的用户!</div>';
				}else{
					if($result){
						while ($row = $db ->fetch_array($result)){
							$a=$a+1;
							echo '<li>';
							echo '<a title="'.$row['cd_nicheng'].'" href="'.linkweburl($row['cd_id'],$row['cd_name']).'" target="_blank"><img src="'.getavatar($row['cd_id'],120).'"></a>';
							echo '<div class="box_list">';
							echo '<a title="'.$row['cd_nicheng'].'" href="'.linkweburl($row['cd_id'],$row['cd_name']).'" target="_blank"><span class="name">'.$row['cd_nicheng'].'</span></a>';
							if($row['cd_checkmusic']){
								echo '<a class="certify" href="javascript:;" title="已获得音乐认证" onclick="openWebsite.openTo(\'musiccertify\');"></a>';
							}
							if($row['cd_checkmm']){
								echo '<a class="certify_mm" href="javascript:;" title="通过了美女认证" onclick="openWebsite.openTo(\'certify\');"></a>';
							}
							if($row['cd_grade']==1){
								echo '<a class="vip_style vip10'.getviprank($row['cd_viprank'],0).'" title="尊贵的VIP'.getviprank($row['cd_viprank'],0).'会员" onclick="openWebsite.openTo(\'vip\');" href="javascript:;"></a>';
							}
							echo '<p><a href="'.cd_upath.rewrite_url('index.php?p=space&a=following&uid='.$row['cd_id']).'" target="_blank" >关注'.$row['cd_idolnum'].'人、</a><a href="'.cd_upath.rewrite_url('index.php?p=space&a=fans&uid='.$row['cd_id']).'" target="_blank" >粉丝'.$row['cd_fansnum'].'人、</a><a href="'.cd_upath.rewrite_url('index.php?p=space&a=favorites&uid='.$row['cd_id']).'" target="_blank">收藏'.$row['cd_favnum'].'首</a></p>';
							if($row['cd_introduce']){
								echo '<p>介绍：'.$row['cd_introduce'].'</p>';
							}else{
								echo '<p>介绍：这家伙很懒，什么也没留下。</p>';
							}

							$sql = "select cd_lock from ".tname('friend')." where cd_uid='$qianwei_in_userid' and cd_uids='".$row['cd_id']."'";
							if($rows = $db->getrow($sql)){
								if($rows['cd_lock'] == '1'){
									echo '<a onclick="fans.fansDel('.$row['cd_id'].', \'{'.$row['cd_nicheng'].'}\', 1);" class="attention mutual" href="javascript:;"></a>';
								}else{
									$cd_groupid = $db->getone("select cd_id from ".tname('friend')." where cd_uid='$qianwei_in_userid' and cd_uids='".$row['cd_id']."'");
									if($cd_groupid){
										echo '<a onclick="fans.fansDel('.$row['cd_id'].', \''.$row['cd_nicheng'].'\', 1);" class="attention already" href="javascript:;"></a>';
									}else{
										echo '<a onclick="fans.fansAdd('.$row['cd_id'].', \''.$row['cd_nicheng'].'\', 1);" class="attention" href="javascript:;"></a>';
									}
								}
							}else{
								echo '<a onclick="fans.fansAdd('.$row['cd_id'].', \'{'.$row['cd_nicheng'].'}\', 1);" class="attention" href="javascript:;"></a>';
							}
							echo '</div>';
							echo '</li>';
						}
					}
				}
			?>
		</ul>
	</div>
	<?php if($Arr[3]>1){ ?>
	<div id="imgPages" class="album_button">
		<div class="pages">
			<?php echo $Arr[0]; ?><input type="text" maxlength="5" onkeydown="function c(event,val){e = event ? event :(window.event ? window.event : null);if(e.keyCode==13){val = parseInt(val);val=isNaN(val)||(val<=0)?1:val;window.location.href=zone_domain+'<?php echo "index.php?p=user&a=userSearch&pages="; ?>'+val;return false;}else{return true;}};if(!c(event,this.value))return false;" title="输入页码，按回车快速跳转"/>
		</div>
	</div>
	<?php } ?>
</div>

<div class="bottom">
	<div class="footer">
		<?php include "source/module/system/footer.php"; ?>
	</div>
</div>
<script type="text/javascript" src="<?php echo cd_upath; ?>static/space/js/relation.js"></script>
<script type="text/javascript">
	nav.init();
	nav.userMenu();
	libs.checkLogin();
	relation.init();
	select.init('sex');
	select.init('province');
</script>
</body>
</html>