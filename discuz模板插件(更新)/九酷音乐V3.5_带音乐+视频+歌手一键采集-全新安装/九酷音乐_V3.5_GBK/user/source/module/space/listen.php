<?php
include "../source/global/global_inc.php";
include "source/module/space/common.php";
$classId = !empty($_GET['classId']) ? $_GET['classId'] : '0';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
	<title><?php echo $qianwei_web_nicheng; ?>����������</title>
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
				<div class="stageBoxCenter min_space_height">
					<div class="spaceMTitle2">
						<p><?php echo $qianwei_web_callname; ?>�������������</p>
						<ul>
							<li<?php if($classId == "0"){echo " class=\"current\"";} ?>>
								<a href="<?php echo cd_upath.rewrite_url('index.php?p=space&a=listen&uid='.$qianwei_web_userid); ?>">ȫ������</a>
								<b></b>
							</li>
							<?php
								global $db;
        							$query = $db->query("select CD_ID,CD_Name from ".tname('class')." where CD_SystemID=1 and CD_FatherID=1 and CD_IsHide=0 order by CD_TheOrder asc LIMIT 0,4");
        							while ($row = $db->fetch_array($query)) {
									echo "<li";
									if($classId == $row["CD_ID"]){
										echo " class=\"current\"";
									}
									echo "><a href=\"".cd_upath.rewrite_url('index.php?p=space&a=listen&uid='.$qianwei_web_userid.'&classId='.$row['CD_ID'])."\">".$row["CD_Name"]."</a><b></b></li>";
								}
							?>
							<?php if($qianwei_web_userid == $qianwei_in_userid){ ?>
							<li class="management">
								<a href="<?php echo cd_upath.rewrite_url('index.php?p=dance&a=listen&i=me'); ?>">����</a>
							</li>
							<?php } ?>
						</ul>
					</div>
					<div class="title_per"> </div>
						<div class="danceFavoritesList">
						<!--������-->
							<form id="list">
									<?php
										global $db;
										$i=0;
										if($classId){
											$sql="select * from ".tname('listen')." where cd_uid='$qianwei_web_userid' and cd_classid='$classId' order by cd_addtime desc";
										}else{
											$sql="select * from ".tname('listen')." where cd_uid='$qianwei_web_userid' order by cd_addtime desc";
										}
										$Arr=getwebfavpage($sql, 20, "index.php?p=space&a=".SafeRequest("a","get")."&uid=".$qianwei_web_userid."&classId=".$classId);//sql,ÿҳ��ʾ����
										$result=$db->query($Arr[2]);
										$num=$db->num_rows($result);
										if($num==0){
											if($classId){
												echo '<div class="nothing_dance">�����û���κ�����</div>';
											}else{
												echo '<div class="nothing_recommend">'.ReplaceStr($qianwei_web_callname,"��","").'��û�������κ����֡�</div>';
											}
										}else{
											if($result){
												echo '<ul class="post_list">';
												echo '<li class="title">';
												echo '<div class="song">����/������</div>';
												echo '<div class="class">���</div>';
												echo '<div class="time">����ʱ��</div>';
												echo '<div class="points">�۷�</div>';
												echo '<div class="impression">ӡ��</div>';
												echo '<div class="add">���</div>';
												echo '<div class="down">����</div>';
												echo '</li>';
												while ($row = $db ->fetch_array($result)){
													$i=$i+1;
													$music = $db->getrow("select * from ".tname('music')." where CD_ID='".$row['cd_musicid']."'");
													if($music){
														echo '<li';
														if($i%2==0){
															echo ' class="c2"';
														}
														echo '>';
														echo '<div class="song">';
														echo '<span class="cbox"><input id="'.$row['cd_musicid'].'" type="checkbox" value="'.$row['cd_musicid'].'" name="did"></span>';
														echo '<div class="aleft">';
														echo '<a href="'.LinkUrl("music",$row['cd_classid'],1,$row['cd_musicid']).'" target="p" class="mname" onclick="dancePlayer.addPlayer(\''.$row['cd_musicid'].'\',\''.$row['cd_uid'].'\');">'.getlen('len',20,$music["CD_Name"]).'</a>';
														echo '&nbsp;-';
														echo '<a href="'.linkweburl($music['CD_UserID'],$music['CD_User']).'" class="nickname" title="'.$music['CD_UserNicheng'].'" target="_blank">'.$music['CD_UserNicheng'].'</a>';
														echo '</div>';
														echo '</div>';
														echo '<div class="class">'.GetAlias("qianwei_class","CD_Name","CD_ID",$music['CD_ClassID']).'</div>';
														echo '<div class="time" title="'.date('Y-m-d H:i:s',$row['cd_addtime']).'">'.datetime(date('Y-m-d H:i:s',$row['cd_addtime'])).'</div>';
														echo '<div class="points">';
														if($music['CD_Points']){
															echo $music['CD_Points'];
														}else{
															echo '���';
														}
														echo '</div>';
														echo '<div class="impression">';
														echo '<span id="d'.$row['cd_musicid'].'" class="icon">';
														echo '<b class="default"> </b><!--dislike����  past����  loveϲ��  recommendation�Ƽ�-->';
														echo '</span>';
														echo '</div>';
														echo '<div class="action">';
														echo '<a class="add" title="�����б�" href="javascript:;" onclick="dancePlayer.addPlayer(\''.$row['cd_musicid'].'\');"></a>';
														echo '</div>';
														echo '<div class="down">';
														echo '<a class="download" title="���ظ���" href="javascript:;" onclick="dancePlayer.openDown(\''.$row['cd_musicid'].'\',\''.$row['cd_uid'].'\')"></a>';
														echo '</div>';
														echo '</li>';
													}
												}
												echo "</ul>\n";
												echo "<div class=\"page\">\n";
												echo "<div class=\"play_button\">\n";
												echo "<a id=\"selectAll\" class=\"select_all\" onclick=\"dancePlayer.selectAllDance('list', '');\" href=\"javascript:;\">ȫѡ</a>\n";
												echo "<a class=\"select_play\" onclick=\"dancePlayer.playDance('list');\" href=\"javascript:;\">����</a>\n";
												echo "<a class=\"select_add_list\" onclick=\"dancePlayer.addInList('list');\" href=\"javascript:;\">�����б�</a>\n";
												echo "</div>";
												echo '<div class="page_sort"><div class="goto"><a class="go" href="javascript:void(0);" onclick="dancePlayer.getPage('.$Arr[3].',\''.cd_upath.'index.php?p=space&a=listen&uid='.$qianwei_web_userid.'&classId='.SafeRequest("classId","get").'&pages=!!PageNum!!\');return false;"><span>ȷ��</span></a><span class="other">ת��<input name="pageNum" id="pageNum" type="text" size="4" class="pageNum" maxlength="4" value="'.$Arr[3].'" onClick="this.value=\'\';" />ҳ</span></div><ul class="page_link">'.$Arr[0].'</ul></div>';
												echo "<div id=\"currPage\">".$Arr[4]."</div>";
												echo "</div>";
											}
										}
									?>
							</form>
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
<script type="text/javascript">
	var didStr = "<?php echo GetListen($qianwei_in_userid); ?>";
	spaceDance.spaceDanceStatus();
</script>
</body>
</html>