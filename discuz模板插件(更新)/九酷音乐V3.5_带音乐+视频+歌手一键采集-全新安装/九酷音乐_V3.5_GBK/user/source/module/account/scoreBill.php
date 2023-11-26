<?php
	include "../source/global/global_inc.php";
        global $db,$qianwei_in_userid;
	VerifyLogin($qianwei_in_userid);
	$cid = SafeRequest("cid","get");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
	<title>我的账单详情 - <?php echo cd_webname; ?></title>
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
		<div class="user_menu" id="account">
			<?php include "source/module/system/left_menu.php"; ?>
		</div>
		<div class="user_main">
			<div class="uMain_content">
				<div class="main_nav">
					<ul>
						<li class="me_account">
							<a href="<?php echo cd_upath.rewrite_url('index.php?p=account&a=assets'); ?>">个人账户</a>
						</li>
						<li class="me_score">
							<a class="on" href="<?php echo cd_upath.rewrite_url('index.php?p=account&a=scoreBill'); ?>">积分账单</a>
						</li>
					</ul>
				</div>
				<div class="main">
					<div id="tooltip" class="refresh">

					</div>
				</div>



				<div class="minHeight500">
					<div id="modifyProfile" class="score">
						<ul class="title">
							<li><a<?php if($cid == ""){echo " class=\"current\"";} ?> href="<?php echo cd_upath.rewrite_url('index.php?p=account&a=scoreBill'); ?>">全部明细</a></li>
							<li><a<?php if($cid == "1"){echo " class=\"current\"";} ?> href="<?php echo cd_upath.rewrite_url('index.php?p=account&a=scoreBill&cid=1'); ?>">全部收入</a></li>
							<li><a<?php if($cid == "2"){echo " class=\"current\"";} ?> href="<?php echo cd_upath.rewrite_url('index.php?p=account&a=scoreBill&cid=2'); ?>">全部支出</a></li>
							<li><a<?php if($cid == "3"){echo " class=\"current\"";} ?> href="<?php echo cd_upath.rewrite_url('index.php?p=account&a=scoreBill&cid=3'); ?>">过期积分</a></li>
						</ul>
						<ul class="list">
							<li class="title">
								<div class="source">来源/用途</div>
								<div class="revenue">收入</div>
								<div class="expenditure">支出</div>
								<div class="time">日期</div>
								<div class="overdue">过期时间</div>
								<div class="receive">积分状态</div>
							</li>
							<?php
								$a=0;
								if($cid == 1){
									$sql="select * from ".tname('bill')." where cd_type=1 and cd_uid='$qianwei_in_userid' and cd_points>=1 order by cd_addtime desc";
								}elseif($cid == 2){
									$sql="select * from ".tname('bill')." where cd_type=0 and cd_uid='$qianwei_in_userid' and cd_points>=1 order by cd_addtime desc";
								}elseif($cid == 3){
									$sql="select * from ".tname('bill')." where cd_type=1 and cd_state=3 and cd_uid='$qianwei_in_userid' and cd_points>=1 order by cd_addtime desc";
								}else{
									$sql="select * from ".tname('bill')." where cd_uid='$qianwei_in_userid' and cd_points>=1 order by cd_addtime desc";
								}
								$Arr=getuserpage($sql,20);//sql,每页显示条数
								$result=$db->query($Arr[2]);
								$num=$db->num_rows($result);
								if($num){
									while ($row = $db ->fetch_array($result)){
										$a=$a+1;
										echo '<li>';
										echo '<div class="source">';
										echo '<span class="icon_mini_'.$row['cd_icon'].'"></span>';
										echo '<span class="te">'.$row['cd_title'].'</span>';
										echo '</div>';
										echo '<div class="revenue">';
										if($row['cd_type']==1){
											echo '+'.$row['cd_points'];
										}
										echo '</div>';
										echo '<div class="expenditure">';
										if($row['cd_type']==0){
											echo '-'.$row['cd_points'];
										}
										echo '</div>';
										echo '<div class="time">'.date("Y-m-d",strtotime($row['cd_addtime'])).'</div>';
										echo '<div class="overdue">'.date("Y-m-d",strtotime($row['cd_endtime'])).'</div>';
										echo '<div class="receive">';
										if($row['cd_type']==1){
											if($row['cd_state']==1){
												echo '<span style="color:#ff0000;">未领取</span>';
											}elseif($row['cd_state']==2){
												echo '已领取';
											}elseif($row['cd_state']==3){
												echo '已过期';
											}else{
												echo '自动领取';
											}
										}else{
											echo '已扣除';
										}
										echo '</div>';
										echo '</li>';
									}
								}else{
									echo '<div class="nothing">还没有任何账单。</div>';
								}
							?>
						</ul>
					</div>
					<?php if($num>0){?><div class="page"><div class="pages"><?php echo $Arr[0]; ?><input type="text" maxlength="5" onkeydown="function c(event,val){e = event ? event :(window.event ? window.event : null);if(e.keyCode==13){val = parseInt(val);val=isNaN(val)||(val<=0)?1:val;window.location.href=zone_domain+'<?php echo "index.php?p=account&a=scoreBill&cid=".SafeRequest("cid","get")."&pages="; ?>'+val;return false;}else{return true;}};if(!c(event,this.value))return false;" title="输入页码，按回车快速跳转"/></div></div><?php } ?>
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
<script type="text/javascript">listenMsg.start();nav.init();nav.userMenu();nav.helpNoticeInit();</script>
<script type="text/javascript" src="<?php echo cd_upath; ?>static/space/js/message.js"></script>
<script type="text/javascript">
	messageLib.msgDelInit();
	messageLib.msgAllDelInit();	
	messageLib.msgIgnoreInit();
</script>
</body>
</html>