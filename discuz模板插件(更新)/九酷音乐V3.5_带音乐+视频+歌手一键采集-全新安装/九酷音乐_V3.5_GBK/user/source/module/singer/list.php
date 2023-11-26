<?php
include "../source/global/global_inc.php";
global $qianwei_in_userid,$qianwei_in_username;
VerifyLogin($qianwei_in_userid);
$classId = unescape(SafeRequest("classId","get"));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
	<title>������� - <?php echo cd_webname; ?></title>
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
		<div class="user_menu" id="actionm">
			<?php include "source/module/system/left_menu.php"; ?>
		</div>
		<div class="user_main">
			<div class="uMain_content">
				<div class="main_nav">
					<ul>
						<li class="concert">
							<a class="on" href="<?php echo cd_upath.rewrite_url('index.php?p=singer&a=list'); ?>">�������</a>
						</li>
						<li class="find">
							<a href="<?php echo cd_upath.rewrite_url('index.php?p=singer&a=pass'); ?>">�������</a>
						</li>
					</ul>
					<div class="action">
						<a href="<?php echo cd_upath.rewrite_url('index.php?p=singer&a=share'); ?>">��������</a>
					</div>
				</div>
				<div class="main_nav2">
					<ul>
						<li<?php if($classId == ""){echo " class=\"current\"";} ?>><a href="<?php echo cd_upath.rewrite_url('index.php?p=singer&a=list'); ?>">ȫ������</a></li>
						<?php
							echo "<li";
							if($classId == "�������"){
								echo " class=\"current\"";
							}
							echo "><a href=\"".cd_upath."index.php?p=singer&a=list&classId=�������\">�������</a></li>";
							echo "<li";
							if($classId == "ŷ������"){
								echo " class=\"current\"";
							}
							echo "><a href=\"".cd_upath."index.php?p=singer&a=list&classId=ŷ������\">ŷ������</a></li>";
							echo "<li";
							if($classId == "�պ�����"){
								echo " class=\"current\"";
							}
							echo "><a href=\"".cd_upath."index.php?p=singer&a=list&classId=�պ�����\">�պ�����</a></li>";
						?>
					</ul>
					<div id="tooltip" class="refresh">

					</div>
				</div>
				<div id="imageList" class="minHeight500">
						<!--������-->
						<?php
							global $db;
							if($classId){
								$sql="select * from ".tname('singer')." where CD_Passed=0 and CD_User='$qianwei_in_username' and CD_Area='$classId' order by CD_AddTime desc";
							}else{
								$sql="select * from ".tname('singer')." where CD_Passed=0 and CD_User='$qianwei_in_username' order by CD_AddTime desc";
							}
							$Arr=getuserpage($sql,20);//sql,ÿҳ��ʾ����
							$result=$db->query($Arr[2]);
							$num=$db->num_rows($result);
							if($num==0){
								echo '<div class="nothing">����������֡�</div>';
							}else{
								if($result){
									echo '<div class="image_praise">';
									echo '<ul>';
									while ($row = $db ->fetch_array($result)){
										echo '<li>';
										echo '<div class="pic">';
										echo '<a href="'.LinkUrl("singer",$row['CD_ID'],1,$row['CD_ID']).'" target="_blank"><img class="avatar" src="'.LinkPicUrl($row['CD_Pic']).'" title="'.$row['CD_Name'].'" height="80" width="80" onerror="this.src=\''.cd_upath.'static/images/nopic.jpg\'"/></a>';
										echo '</div>';
										echo '<div class="option">';
										echo '<label style="cursor:pointer;">'.getlen("len","8",$row['CD_Name']).'</label>';
										echo '<label style="color:#FF0000;" class="delete" did="'.$row['CD_ID'].'">ɾ��</label>';
										echo '</div>';
										echo '</li>';
									}
									echo '</ul>';
									echo '</div>';
								}
							}
						?>
						<?php if($num>0){?>
						<div class="page">
							<div class="pages">
								<?php echo $Arr[0]; ?><input type="text" maxlength="5" onkeydown="function c(event,val){e = event ? event :(window.event ? window.event : null);if(e.keyCode==13){val = parseInt(val);val=isNaN(val)||(val<=0)?1:val;window.location.href='<?php echo cd_upath; ?>index.php?p=<?php echo SafeRequest("p","get"); ?>&a=<?php echo SafeRequest("a","get"); ?>&classId=<?php echo unescape(SafeRequest("classId","get")); ?>&pages='+val+'';return false;}else{return true;}};if(!c(event,this.value))return false;" title="����ҳ�룬���س�������ת"/>
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
<script type="text/javascript" src="<?php echo cd_upath; ?>static/space/js/singer.js"></script>
<script type="text/javascript">listenMsg.start();nav.init();nav.userMenu();singerLib.passDelInit();</script>
</body>
</html>