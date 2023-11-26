<?PHP exit('QQÈº£º550494646');?>
<!--{template common/header}-->
<!-- header start -->
<div class="header">
	<div class="nav">
    	<a href="javascript:;" onclick="history.go(-1)" class="z"><i class="iconfont icon-back"></i></a>
        <span class="name">$alang_tip</span>
	</div>
</div>
<!-- header end --><!--Fr om w ww.moq  u8 .com -->
<div class="ainuo_f_pass cl">
	<div class="cl">
		<div class="cl">
			<div class="cl">
				<h2 class="cl">{lang forum_password_require}</h2>
				<div class="acon cl">
					<form method="post" autocomplete="off" action="forum.php?mod=forumdisplay&fid=$_G[fid]&action=pwverify">
						<input type="hidden" name="formhash" value="{FORMHASH}" />
						<input type="password" name="pw" class="px" />
						<p><button type="submit" name="loginsubmit" value="true">{lang submit}</button></p>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<!--{template common/footer}-->