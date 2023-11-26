<?php exit;?>
<!--{template common/header}-->
<!--{eval if(!function_exists('init_n5app'))include DISCUZ_ROOT.'./source/plugin/zhikai_n5appgl/common.php'; if(!function_exists('init_n5app')) exit('Authorization error!');}-->
<!--{eval include_once DISCUZ_ROOT.'./source/plugin/zhikai_n5appgl/nvbing5.php'}-->
{if strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'micromessenger')}
<style type="text/css">
.bg {padding-top: 0;}
</style><!--Fr om www.xhkj5.com-->
<div class="n5qj_wxgdan cl">
	<a href="javascript:history.back();" class="wxmsf"></a>
	<a href="home.php?mod=space&uid=$_G[uid]&do=profile&mycenter=1" class="wxmsw"></a>
</div>
{else}
<div class="n5qj_tbys nbg cl">
	<a href="javascript:history.back();" class="n5qj_zcan"><div class="zcanfh">{$n5app['lang']['qjfanhui']}</div></a>
	<a href="home.php?mod=space&uid=$_G[uid]&do=profile&mycenter=1" class="n5qj_ycan grtrnzx"></a>
	<span>{$n5app['lang']['kjwdxxsbt']}</span>
</div>
{/if}
<style type="text/css">
	.ztfl_fllb {width: 100%;} 
	.ztfl_fllb ul li {width: 25%;padding: 0;}
</style>
<div class="n5sq_ztfl">
	<div class="ztfl_flzt">
		<div class="ztfl_fllb">
			<ul id="n5sq_glpd">
				<li$actives[privatepm] $actives[newpm]><a href="home.php?mod=space&do=pm&filter=privatepm">{lang private_pm}</a></li>
				<li$actives[announcepm]><a href="home.php?mod=space&do=pm&filter=announcepm">{lang announce_pm}</a></li>
				<li$actives[setting]><a href="home.php?mod=space&do=pm&subop=setting">{$n5app['lang']['kjwdxxxxsz']}</a></li>
				<li class="a"><a href="home.php?mod=spacecp&ac=pm">{$n5app['lang']['kjwdxxfsxx']}</a></li>
			</ul>
		</div>
	</div>
</div>
<script src="template/zhikai_n5app/js/jquery.xemoticons.js" type="text/javascript"></script>
<form id="pmform_{$pmid}" name="pmform_{$pmid}" method="post" autocomplete="off" action="home.php?mod=spacecp&ac=pm&op=send&touid=$touid&pmid=$pmid&mobile=2" >
<input type="hidden" name="referer" value="{echo dreferer();}" />
<input type="hidden" name="pmsubmit" value="true" />
<input type="hidden" name="formhash" value="{FORMHASH}" />
<!-- main post_msg_box start -->
	<!--{if !$touid}-->
		<div class="n5gr_fxxm cl">
			<div class="fxxm_xmbt z">{lang addressee}</div>
			<div class="fxxm_xmnr z"><input type="text" value="" tabindex="1" class="px" size="30" autocomplete="off" id="username" name="username" placeholder="{$n5app['lang']['kjwdjfqsrhym']}"></div>
		</div>
	<!--{/if}-->
		<div class="n5gr_fxnr cl">
			<textarea class="pt" tabindex="2" autocomplete="off" value="" cols="80" rows="7" id="sendmessage" name="message" placeholder="{$n5app['lang']['sqftktishi']}"></textarea>
		</div>
		<a href="JavaScript:void(0)" id="message_face" class="n5gr_bqan"></a>
		<div id="fbxxbqxs"></div>
		<div class="n5gr_fxan"><button id="pmsubmit_btn" class="btn_pn btn_pn_grey" disable="true"><span>{lang sendpm}</span></button></div>
<!-- main postbox start -->
</form><!--Fr om www.xhkj5.com-->
<script type="text/javascript">
	var jq = jQuery.noConflict(); 
    jq("#message_face").jqfaceedit({txtAreaObj:jq("#sendmessage"),containerObj:jq('#fbxxbqxs')});
</script>
<script type="text/javascript">
	(function() {
		$('#sendmessage').on('keyup input', function() {
			var obj = $(this);
			if(obj.val()) {
				$('.btn_pn').removeClass('btn_pn_grey').addClass('btn_pn_blue');
				$('.btn_pn').attr('disable', 'false');
			} else {
				$('.btn_pn').removeClass('btn_pn_blue').addClass('btn_pn_grey');
				$('.btn_pn').attr('disable', 'true');
			}
		});
		var form = $('#pmform_{$pmid}');
		$('#pmsubmit_btn').on('click', function() {
			var obj = $(this);
			if(obj.attr('disable') == 'true') {
				return false;
			}
			$.ajax({
				type:'POST',
				url:form.attr('action') + '&handlekey='+form.attr('id')+'&inajax=1',
				data:form.serialize(),
				dataType:'xml'
			})
			.success(function(s) {
				popup.open(s.lastChild.firstChild.nodeValue);
			})
			.error(function() {
				popup.open('{lang networkerror}', 'alert');
			});
			return false;
			});
	 })();
</script>
<!--{eval $nofooter = true;}-->
<!--{template common/footer}-->