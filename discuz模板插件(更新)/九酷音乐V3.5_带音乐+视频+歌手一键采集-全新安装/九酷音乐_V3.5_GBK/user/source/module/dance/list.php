<?php
include "../source/global/global_inc.php";
global $qianwei_in_userid;
VerifyLogin($qianwei_in_userid);
$classId = SafeRequest("classId","get");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
	<title>已审音乐 - <?php echo cd_webname; ?></title>
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
		<div class="user_menu" id="share">
			<?php include "source/module/system/left_menu.php"; ?>
		</div>
		<div class="user_main">
			<div class="uMain_content">
				<div class="main_nav">
					<ul>
						<li class="concert">
							<a class="on" href="<?php echo cd_upath.rewrite_url('index.php?p=dance&a=list'); ?>">已审音乐</a>
						</li>
						<li class="find">
							<a href="<?php echo cd_upath.rewrite_url('index.php?p=dance&a=pass'); ?>">待审音乐</a>
						</li>
					</ul>
					<div class="action">
						<a href="<?php echo cd_upath.rewrite_url('index.php?p=dance&a=share'); ?>">分享音乐</a>
					</div>
				</div>
				<div class="main_nav2">
					<ul>
						<li<?php if($classId == ""){echo " class=\"current\"";} ?>><a href="<?php echo cd_upath.rewrite_url('index.php?p=dance&a=list'); ?>">全部类型</a></li>
						<?php
							global $db;
        						$query = $db->query("select CD_ID,CD_Name from ".tname('class')." where CD_SystemID=1 and CD_FatherID=1 and CD_IsHide=0 order by CD_TheOrder asc LIMIT 0,8");
        						while ($row = $db->fetch_array($query)) {
								echo "<li";
								if($classId == $row["CD_ID"]){
									echo " class=\"current\"";
								}
								echo "><a href=\"".cd_upath.rewrite_url("index.php?p=dance&a=list&classId=".$row["CD_ID"])."\">".$row["CD_Name"]."</a></li>";
							}
						?>
					</ul>
					<div id="tooltip" class="refresh">

					</div>
				</div>
				<div id="favoritesList" class="minHeight500">
					<div class="private_dance_list">
						<!--有内容-->
						<?php
							global $db;
							$a=0;
							if($classId){
								$sql="select * from ".tname('music')." where CD_Passed=0 and CD_UserID='$qianwei_in_userid' and CD_ClassID='$classId' order by CD_AddTime desc";
							}else{
								$sql="select * from ".tname('music')." where CD_Passed=0 and CD_UserID='$qianwei_in_userid' order by CD_AddTime desc";
							}
							$Arr=getuserpage($sql,20);//sql,每页显示条数
							$result=$db->query($Arr[2]);
							$num=$db->num_rows($result);
							if($num==0){
								echo '<div class="nothing">暂无已审音乐。</div>';
							}else{
								if($result){
									echo '<ul id="list">';
									echo '<li class="title">';
									echo '<div class="song">音乐/分享人</div>';
									echo '<div class="time">分享时间</div>';
									echo '<div class="file">类别</div>';
									echo '<div class="add">添加</div>';
									echo '<div class="down">下载</div>';
									echo '</li>';
									while ($row = $db ->fetch_array($result)){
										$a=$a+1;
										echo '<li';
										if($a%2==0){
											echo ' class="c2"';
										}
										echo '>';
										echo '<div class="song">';
										echo '<span class="cbox"><input id="'.$row['CD_ID'].'" type="checkbox" name="did" value="'.$row['CD_ID'].'"></span>';
										echo '<div class="aleft">';
										echo '<a href="'.LinkUrl("music",$row['CD_ClassID'],1,$row['CD_ID']).'" target="p" class="mname">'.$a.'.&nbsp;&nbsp;'.$row["CD_Name"].'</a>';
										echo ' - ';
										echo '<a href="'.linkweburl($row['CD_UserID'],$row['CD_User']).'" class="nickname" title="'.$row['CD_UserNicheng'].'" target="_blank" uid="'.$row['CD_UserID'].'">'.$row['CD_UserNicheng'].'</a>';
										echo '</div>';
										echo '</div>';
										echo '<div class="time">'.datetime($row['CD_AddTime']).'</div>';
										echo '<div class="file"><a href="'.LinkClassUrl("music",$row['CD_ClassID'],1,1).'" target="_blank">'.GetAlias("qianwei_class","CD_Name","CD_ID",$row['CD_ClassID']).'</a></div>';
										echo '<div class="add"><a class="addition" onclick="dancePlayer.addPlayer(\''.$row['CD_ID'].'\',\''.$row['CD_UserID'].'\',\''.$row['CD_UserID'].'\')" href="javascript:;" title="添加歌曲"></a></div>';
										echo '<div class="down"><a class="download" onclick="dancePlayer.openDown(\''.$row['CD_ID'].'\',\''.$row['CD_UserID'].'\',\''.$row['CD_UserID'].'\');" href="javascript:;" title="下载歌曲"></a></div>';
										echo '</li>';
									}
									echo '</ul>';
								}
							}
						?>
					</div>
					<?php if($num>0){?>
					<div class="page">
						<div class="play_button">
							<a class="select_all" href="javascript:;" id="selectAll" onclick="dancePlayer.selectAllDance('list', '');">全选</a>	
							<a class="select_play" href="javascript:;" onclick="dancePlayer.playDance('list');">播放</a>
							<a class="select_add_list" href="javascript:;" onclick="dancePlayer.addInList('list');">加入列表</a>
						</div>
						<div class="pages">
							<?php echo $Arr[0]; ?><input type="text" maxlength="5" onkeydown="function c(event,val){e = event ? event :(window.event ? window.event : null);if(e.keyCode==13){val = parseInt(val);val=isNaN(val)||(val<=0)?1:val;window.location.href='<?php echo cd_upath; ?>index.php?p=<?php echo SafeRequest("p","get"); ?>&a=<?php echo SafeRequest("a","get"); ?>&classId=<?php echo SafeRequest("classId","get"); ?>&pages='+val+'';return false;}else{return true;}};if(!c(event,this.value))return false;" title="输入页码，按回车快速跳转"/>
						</div>
					</div>
					<?php } ?>
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
</body>
</html>