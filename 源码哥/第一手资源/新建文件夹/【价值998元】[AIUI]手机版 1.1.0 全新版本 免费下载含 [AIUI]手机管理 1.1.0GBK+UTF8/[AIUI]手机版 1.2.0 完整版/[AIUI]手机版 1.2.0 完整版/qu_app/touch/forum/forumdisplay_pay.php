<?PHP exit('QQÈº£º550494646');?>
<!--{template common/header}-->
<!-- header start -->
<div class="header">
	<div class="nav">
    	<a href="javascript:;" onclick="history.go(-1)" class="z"><i class="iconfont icon-back"></i></a>
        <span class="name">$alang_tip</span>
	</div>
</div>
<!-- header end -->

<div class="ainuo_f_pass cl">
	<div class="cl">
		<div class="cl">
			<div class="cl">
				<h2 class="cl">{lang youneedpay} $paycredits {$_G['setting']['extcredits'][$_G['setting']['creditstransextra'][1]]['unit']}{$_G['setting']['extcredits'][$_G['setting']['creditstransextra'][1]]['title']} {lang onlyintoforum}</h2>
				<div class="acon cl">
					<form method="post" autocomplete="off" action="forum.php?mod=forumdisplay&fid=$_G[fid]&action=paysubmit">
						<input type="hidden" name="formhash" value="{FORMHASH}" />
						<p><button type="submit" name="loginsubmit" value="true">{lang confirmyourpay}</button></p>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<!--{template common/footer}-->
