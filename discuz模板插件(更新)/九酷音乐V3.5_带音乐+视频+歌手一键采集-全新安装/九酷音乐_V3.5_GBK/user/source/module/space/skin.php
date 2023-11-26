<?php
include "../source/global/global_inc.php";
VerifyLogin($qianwei_in_userid);
include "source/module/space/common.php";
$classId = SafeRequest("classId","get");
$orderBy = SafeRequest("orderBy","get");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
	<title>空间主题 - <?php echo cd_webname; ?></title>
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
				<div class="stageBoxCenter">
					<div class="minHeight940">
						<div class="spaceMTitle2"><p>装扮皮肤</p></div>
						<div class="title_per"> </div>
						<div class="headerNav">
							<div class="nav_item">
								<span>颜色:</span>
								<ul class="navTab">
									<li<?php if($classId == ""){echo " class=\"current\"";} ?>>
										<a href="<?php echo cd_upath; ?>index.php?p=space&a=skin<?php if($orderBy){echo '&orderBy='.$orderBy;} ?>">全部</a>
									</li>
									<?php
										global $db;
        									$query = $db->query("select cd_id,cd_name from ".tname('skin_class')." order by cd_id asc LIMIT 0,6");
        									while ($row = $db->fetch_array($query)) {
											echo "<li";
											if($classId == $row["cd_id"]){
												echo " class=\"current\"";
											}
											if($orderBy){
												$cd_orderBy = "&orderBy=".$orderBy;
											}else{
												$cd_orderBy = "";
											}
											echo "><a href=\"".cd_upath."index.php?p=space&a=skin&classId=".$row["cd_id"].$cd_orderBy."\">".$row["cd_name"]."</a><b></b></li>";
										}
									?>
								</ul>
							</div>
						</div>
						<div class="homeSkin_list">
							<div class="homeSkin_list_header">
								<h4 class="list_headerName">全部</h4>
								<p class="order">
									排序：
									<a<?php if($orderBy == ""){echo " class=\"bold\"";} ?> href="<?php echo cd_upath; ?>index.php?p=space&a=skin<?php if($classId){echo '&classId='.$classId;} ?>">最新上架</a>
									<span>|</span>
									<a<?php if($orderBy == "1"){echo " class=\"bold\"";} ?> href="<?php echo cd_upath; ?>index.php?p=space&a=skin<?php if($classId){echo '&classId='.$classId;} ?>&orderBy=1">超高人气</a>
								</p>
							</div>
							<ul class="homeSkin_list_body">
								<?php
									global $db;
									$i=0;
									if($orderBy){
										$orderBysql = "cd_hits";
									}else{
										$orderBysql = "cd_id";
									}
									if($classId){
										$sql="select * from ".tname('skin')." where cd_classid='$classId' order by $orderBysql desc";
									}else{
										$sql="select * from ".tname('skin')." order by $orderBysql desc";
									}
									$Arr=getuserpage($sql,20);//sql,每页显示条数
									$result=$db->query($Arr[2]);
									$num=$db->num_rows($result);
									if($num==0){
										echo '<div class="nothing_feed">'.ReplaceStr($qianwei_web_callname,"我","").'最近没有动态哦-.-!</div>';
									}else{
										if($result){
											while ($row = $db ->fetch_array($result)){
												$i=$i+1;

												echo '<li class="ornament ornament-hovered ">';
												echo '<div class="ornament-content" skinId="'.$row['cd_id'].'" skinPath="'.$row['cd_path'].'">';
												echo '<img class="previewImg" title="'.$row['cd_name'].'" skinId="'.$row['cd_id'].'" src="'.cd_upath.'static/space/skin/'.$row['cd_path'].'/thumb.jpg" onerror="$call(function(){libs.imageError(this);}, this)"/>';
												echo '<span class="ornament-status status-new"></span>';
												echo '<span class="click-preview" skinPath="'.$row['cd_path'].'" id="on'.$row['cd_id'].'">点击预览</span>';
												echo '</div>';
												echo '<div class="ornament-name">';
												echo '<span>'.$row['cd_name'].'</span>';
												echo '<p title="此皮肤需要消耗'.cd_webpoints.'积分">'.cd_webpoints.'积分</p>';
												echo '</div>';
												echo '</li>';
											}
										}
									}
								?>
							</ul>

							<div class="page">
								<div class="acButton">
									<span class="button2-main">
										<span>
											<button id="change" type="button" uid="<?php echo $qianwei_web_userid; ?>" BskinPath="<?php echo $qianwei_web_skinid; ?>">保存主题</button>
										</span>
									</span>
									<span class="button2-main">
										<span>
											<button id="default" type="button" uid="<?php echo $qianwei_web_userid; ?>" BskinPath="<?php echo $qianwei_web_skinid; ?>">恢复默认</button>
										</span>
									</span>
								</div>
								<div class="pages">
									<?php echo $Arr[0]; ?><input type="text" maxlength="5" onkeydown="function c(event,val){e = event ? event :(window.event ? window.event : null);if(e.keyCode==13){val = parseInt(val);val=isNaN(val)||(val<=0)?1:val;window.location.href='<?php echo cd_upath; ?>index.php?p=<?php echo SafeRequest("p","get"); ?>&a=<?php echo SafeRequest("a","get"); ?><?php if($classId){echo '&classId='.$classId;} ?><?php if($orderBy){echo '&orderBy='.$orderBy;} ?>&pages='+val+'';return false;}else{return true;}};if(!c(event,this.value))return false;" title="输入页码，按回车快速跳转"/>
								</div>
							</div>
						</div>
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
<script type="text/javascript" src="<?php echo cd_upath; ?>static/space/js/skin.js"></script>
<script type="text/javascript">skinLib.skinUpdate();</script>
</body>
</html>