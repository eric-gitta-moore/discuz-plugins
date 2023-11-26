<?php exit;?>
<!--{template common/header}-->
<!--{eval if(!function_exists('init_n5app'))include DISCUZ_ROOT.'./source/plugin/zhikai_n5appgl/common.php'; if(!function_exists('init_n5app')) exit('Authorization error!');}-->
<!--{eval include_once DISCUZ_ROOT.'./source/plugin/zhikai_n5appgl/nvbing5.php'}-->
<script src="template/zhikai_n5app/js/qrcode.min.js" type="text/javascript"></script>
<div class="n5gr_wewm cl">
	<a href="javascript:;" onclick="popup.close();" class="ztds_gbck"></a>
    <div class="wewm_hyxx cl">
		<div class="hyxx_hytx z cl"><!--{avatar($space[uid],middle)}--></div>
		<div class="hyxx_hymc z cl"><h2>$space[username]</h2><p>{$n5app['lang']['kjssewmts']}</p></div>
	</div>
	<div class="wewm_ewmt cl">
		<div id="qrcode"></div>
	</div>
</div>
<script type="text/javascript">
var qrcode = new QRCode(document.getElementById("qrcode"), {
    text: "$_G['setting'][siteurl]/home.php?mod=space&uid=$space[uid]&do=profile&view=me",
    width: 400,
    height: 400,
    colorDark : "#000000",
    colorLight : "#ffffff",
    correctLevel : QRCode.CorrectLevel.H
});
</script>
<!--{eval $nofooter = true;}-->
<!--{template common/footer}-->