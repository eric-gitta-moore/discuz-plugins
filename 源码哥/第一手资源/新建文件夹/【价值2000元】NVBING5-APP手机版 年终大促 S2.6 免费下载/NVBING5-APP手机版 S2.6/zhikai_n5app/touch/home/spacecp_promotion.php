<?php exit;?>
<!--{template common/header}-->
<!--{eval if(!function_exists('init_n5app'))include DISCUZ_ROOT.'./source/plugin/zhikai_n5appgl/common.php'; if(!function_exists('init_n5app')) exit('Authorization error!');}-->
<!--{eval include_once DISCUZ_ROOT.'./source/plugin/zhikai_n5appgl/nvbing5.php'}-->
{if strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'micromessenger')}
<style type="text/css">
.bg {padding-top: 0;}
</style>
<div class="n5qj_wxgdan cl">
	<a href="javascript:history.back();" class="wxmsf"></a>
	<a href="home.php?mod=space&uid=$_G[uid]&do=profile&mycenter=1" class="wxmsw"></a>
</div>
{else}
<div class="n5qj_tbys nbg cl">
	<a href="javascript:history.back();" class="n5qj_zcan"><div class="zcanfh">{$n5app['lang']['qjfanhui']}</div></a>
	<a href="home.php?mod=space&uid=$_G[uid]&do=profile&mycenter=1" class="n5qj_ycan grtrnzx"></a>
	<span>{$n5app['lang']['grzxxmfwtj']}</span>
</div><!--Fr om www.xhkj5.com-->
{/if}
<!--{if $_G['setting']['creditspolicy']['promotion_visit'] || $_G['setting']['creditspolicy']['promotion_register']}-->
<div class="fwtg_tsxx cl">
	<!--{if $_G['setting']['creditspolicy']['promotion_visit']}--><p>{$n5app['lang']['fwtgfwjljf']} <i>$visitstr</i></p><!--{/if}-->
	<!--{if $_G['setting']['creditspolicy']['promotion_register']}-->
		<p>
		<!--{if $_G['setting']['creditspolicy']['promotion_visit']}-->
			{$n5app['lang']['fwtgzcjljf']} <i>$regstr</i>
		<!--{else}-->
			{$n5app['lang']['fwtgzzcjljf']} <i>$regstr</i>
		<!--{/if}-->
		</p>
	<!--{/if}-->
</div>
<script src="template/zhikai_n5app/js/qrcode.min.js" type="text/javascript"></script>
<div class="fwtg_ewmx cl">
	<div class="ewmx_tgewm">
		<div id="qrcode"></div>
		<script type="text/javascript">
			var qrcode = new QRCode(document.getElementById("qrcode"), {
			text: "$_G[siteurl]?fromuid=$_G[uid]",
			width: 400,
			height: 400,
			colorDark : "#000000",
			colorLight : "#ffffff",
			correctLevel : QRCode.CorrectLevel.H
			});
		</script>
		<div class="ewmx_hyxx">
			<!--{avatar($_G[uid])}-->
			<h2>$_G[username]</h2>
			<p>{$n5app['lang']['fwtgyqxcy']}</p>
		</div>
	</div>
</div>
<!--{/if}-->
<!--{template common/footer}-->