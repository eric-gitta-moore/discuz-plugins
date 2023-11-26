<?php
	include "../source/global/global_inc.php";
	close_browse();
	global $db;
?>
<div class="random_box">
	<a class="close" rel="close" href="javascript:;" id="close">关闭</a>
	<div class="number_wrap" style="margin-top:0;">
		<span scroll="box"><b rel="con" style="top: 0px;" id="whree1">0</b></span>
		<span scroll="box"><b rel="con" style="top: 0px;" id="whree2">0</b></span>
		<span scroll="box"><b rel="con" style="top: 0px;" id="whree3">0</b></span>
	</div>
	<?php
		$row=$db->getrow("select cd_id,cd_uid,cd_uname,cd_addtime from ".tname('slot')." where cd_uid='$qianwei_in_userid'");
			if(DateDiff(date("Y-m-d",strtotime($row['cd_addtime'])),date("Y-m-d")) == 0){
	?>
	<div class="random_result" rel="result_box">
		<div class="result_contents" rel="result_msg">
			<p style="font-size:14px;">
				您今天已摇过一次了，12:00后您可摇第二次！
				<br>
				每天摇两次，将得更多积分！
			</p>
		</div>
	</div>
			<?php }else{ ?>
	<div class="bottom" rel="start_box" id="slot"><a class="button" rel="start_btn" href="javascript:;" id="button">开始摇奖</a></div>
			<?php } ?>

	<div class="random_result" rel="result_box" style="display: none;" id="random">
		<div class="result_contents" rel="result_msg">
			恭喜您 本次摇奖获得
			<b id="score"></b>
			积分，请到&nbsp;<strong><a href="<?php echo cd_upath.rewrite_url('index.php?p=account&a=assets'); ?>">个人账户</a></strong>&nbsp;中领取。
			<br>
			每天摇两次，将得更多积分！
		</div>
	</div>
</div>

<script type="text/javascript">
	slotLib.Init();
</script>