<?php
	include "../source/global/global_inc.php";
	close_browse();
	global $db;
?>
<div class="random_box">
	<a class="close" rel="close" href="javascript:;" id="close">�ر�</a>
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
				��������ҡ��һ���ˣ�12:00������ҡ�ڶ��Σ�
				<br>
				ÿ��ҡ���Σ����ø�����֣�
			</p>
		</div>
	</div>
			<?php }else{ ?>
	<div class="bottom" rel="start_box" id="slot"><a class="button" rel="start_btn" href="javascript:;" id="button">��ʼҡ��</a></div>
			<?php } ?>

	<div class="random_result" rel="result_box" style="display: none;" id="random">
		<div class="result_contents" rel="result_msg">
			��ϲ�� ����ҡ�����
			<b id="score"></b>
			���֣��뵽&nbsp;<strong><a href="<?php echo cd_upath.rewrite_url('index.php?p=account&a=assets'); ?>">�����˻�</a></strong>&nbsp;����ȡ��
			<br>
			ÿ��ҡ���Σ����ø�����֣�
		</div>
	</div>
</div>

<script type="text/javascript">
	slotLib.Init();
</script>