<?php
	include "../source/global/global_inc.php";
        global $db;
	VerifyLogin($qianwei_in_userid);
	$cid = SafeRequest("cid","get");
	$fgid = SafeRequest("fgid","get");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
	<title>我的关注 - <?php echo cd_webname; ?></title>
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
		<div class="user_menu" id="fansm">
			<?php include "source/module/system/left_menu.php"; ?>
		</div>
		<div class="user_main">
			<div class="uMain_content">
				<div class="main_nav">
					<ul>
						<li class="attention">
							<a class="on" href="<?php echo cd_upath.rewrite_url('index.php?p=relation&a=following'); ?>">我的关注</a>
						</li>
						<li class="fans">
							<a href="<?php echo cd_upath.rewrite_url('index.php?p=relation&a=fans'); ?>">我的粉丝</a>
						</li>
						<li class="praise">
							<a href="<?php echo cd_upath.rewrite_url('index.php?p=relation&a=userPraiseIn'); ?>">赞与被赞</a>
						</li>
						<li class="visitor">
							<a href="<?php echo cd_upath.rewrite_url('index.php?p=relation&a=visitorIn'); ?>">访问脚印</a>
						</li>
					</ul>
				</div>
				<div class="main">
					<div id="tooltip" class="refresh">

					</div>
				</div>
				<div class="minHeight500">
					<div class="friendList">
						<div id="followingGroupName" class="friendListHead">
							<ul class="screen">
								<li<?php if($cid==""){echo ' class="on"';} ?>><a href="<?php echo cd_upath.rewrite_url('index.php?p=relation&a=following'); ?>"><span>全部</span></a></li>
								<li<?php if($cid=="1"){echo ' class="on"';} ?>><a href="<?php echo cd_upath.rewrite_url('index.php?p=relation&a=following&cid=1'); ?>"><span>相互关注</span></a></li>
								<li<?php if($cid=="2"){echo ' class="on"';} ?>><a href="<?php echo cd_upath.rewrite_url('index.php?p=relation&a=following&cid=2'); ?>"><span>悄悄关注</span></a></li>
								<li<?php if($cid=="3"){echo ' class="on"';} ?>><a href="<?php echo cd_upath.rewrite_url('index.php?p=relation&a=following&cid=3'); ?>"><span>未分组</span></a></li>
								<?php
									if($fgid){
										$sql = "select cd_id,cd_name from ".tname('friendgroup')." where cd_id='$fgid'";
										if($group = $db->getrow($sql)){
											$cd_groupid = $group['cd_id'];
											$cd_groupname = $group['cd_name'];
											echo '<li class="on"><a href="'.cd_upath.'index.php?p=relation&a=following&cid=4&fgid='.$cd_groupid.'"><span>'.$cd_groupname.'</span></a></li>';
										}
									}
								?>
								<li>
									<a href="javascript:;" class="set_menu"><span>更多<b></b></span></a>
									<div class="m_set_list more_list" style="display: none;" id="followingGroupList">
										<?php
											global $db;
        										$query = $db->query("select * from ".tname('friendgroup')." where cd_uid='$qianwei_in_userid' order by cd_id asc");
											while ($row = $db->fetch_array($query)) {
												echo '<div class="list"><a class="list_clo" href="'.cd_upath.'index.php?p=relation&a=following&cid=4&fgid='.$row['cd_id'].'">'.$row['cd_name'].'</a></div>';
											}
										?>

										

										<div class="add">
											<a onclick="$('#friendGroupAdd').show();$('#addGroup1').hide();" href="javascript:;" id="addGroup1">添加分组</a>
										</div>
										<div class="create" id="friendGroupAdd" style="display: none;">
											<input id="addfgName" class="seh_v" type="text" value="">
											<span class="button2-main">
												<span>
													<button id="add" bskinpath="t2" uid="<?php echo $qianwei_in_userid; ?>" type="button">创建</button>
												</span>
											</span>
										</div>
									</div>
								</li>
							</ul>
							<?php
								global $db;
								if($cid == 1){
									$sql = "select * from ".tname('friend')." where cd_lock=1 and cd_uid='$qianwei_in_userid' order by cd_addtime desc";
								}elseif($cid == 2){
									$sql = "select * from ".tname('friend')." where cd_hidden=1 and cd_uid='$qianwei_in_userid' order by cd_addtime desc";
								}elseif($cid == 3){
									$sql = "select * from ".tname('friend')." where cd_group=0 and cd_uid='$qianwei_in_userid' order by cd_addtime desc";
								}elseif($cid == 4){
									$sql = "select * from ".tname('friend')." where cd_group='$fgid' and cd_uid='$qianwei_in_userid' order by cd_addtime desc";
								}else{
									$sql = "select * from ".tname('friend')." where cd_uid='$qianwei_in_userid' order by cd_addtime desc";
								}
								$Arr = getuserpage($sql,20);//sql,每页显示条数
								$result = $db->query($Arr[2]);
								$num = $db->num_rows($result);
							?>
							<div class="box">
								<div class="number" id="number" nid="<?php echo $num; ?>">该组共有<?php echo $num; ?>人</div>
								<?php
									if($fgid){
										echo '<span id="modify">';
										echo '<a class="change" id="change" href="javascript:;" onclick="relation.change('.$cd_groupid.', \''.$cd_groupname.'\');">修改分组名称</a>';
										echo '<a class="deletion" id="deletion" title="删除"  onclick="$call(function(){fans.followingGroupDel('.$cd_groupid.', 2, \''.$cd_groupname.'\')});" href="javascript:;">删除该分组</a>';
										echo '</span>';
									}
								?>

							</div>
						</div>
						<div id="followingList" class="followingList">
							<ul>
								<?php
									$a=0;
									if($result){
										if($num>0){
											while ($row = $db ->fetch_array($result)){
												$a=$a+1;
												$user = $db->getrow("select cd_nicheng,cd_checkmusic,cd_checkmm,cd_grade,cd_viprank from ".tname('user')." where cd_id='".$row['cd_uids']."'");
                                								$res = $db->getrow("select cd_id,cd_name from ".tname('friendgroup')." where cd_id='".$row['cd_group']."'");
												if($row['cd_group']){
													$groupname = $res['cd_name'];
												}else{
													$groupname = '未分组';
												}
												if($row['cd_hidden']==1){
													$cd_hidden = '【悄悄】';
												}else{
													$cd_hidden = '';
												}
												echo '<li>';
												echo '<div class="icon"><a href="'.linkweburl($row['cd_uids'],$row['cd_unames']).'" target="_blank"><img class="avatar-58" src="'.getavatar($row['cd_uids'],48).'"/></a></div>';
												echo '<div class="info">';
												echo '<div class="name"><a href="'.linkweburl($row['cd_uids'],$row['cd_unames']).'" target="_blank">'.$user['cd_nicheng'].$cd_hidden.'</a>'.CheckCertify($user['cd_checkmusic'],$user['cd_checkmm'],$user['cd_grade'],$user['cd_viprank']).'</div>';
												echo '<div class="group" onclick="relation.group(0, '.$row['cd_uids'].', \''.$user['cd_nicheng'].'\');"><a id="group_'.$row['cd_uids'].'" title="更换分组" href="javascript:;">'.$groupname.'</a></div>';
												echo '</div>';
												echo '<a class="del" title="解除好友" href="javascript:;"  onclick="relation.delFollowing(0, '.$row['cd_uids'].', \''.$user['cd_nicheng'].'\', 0, '.$row['cd_uid'].', \'\', 0, 0, 1);" ></a>';
												echo '</li>';
											}
										}else{
											echo '<div class="nothing">暂时还没有粉丝啊！</div>';
										}
									}
								?>
							</ul>												
							<?php if($num>0){?><div class="page"><div class="pages"><?php echo $Arr[0]; ?><input type="text" maxlength="5" onkeydown="function c(event,val){e = event ? event :(window.event ? window.event : null);if(e.keyCode==13){val = parseInt(val);val=isNaN(val)||(val<=0)?1:val;window.location.href='<?php echo cd_upath; ?>index.php?p=<?php echo SafeRequest("p","get"); ?>&a=<?php echo SafeRequest("a","get"); ?>&pages='+val+'';return false;}else{return true;}};if(!c(event,this.value))return false;" title="输入页码，按回车快速跳转"/></div></div><?php } ?>
						</div>
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
<script type="text/javascript" src="<?php echo cd_upath; ?>static/space/js/relation.js"></script>
<script type="text/javascript">nav.helpNoticeInit();relation.init();</script>
</body>
</html>