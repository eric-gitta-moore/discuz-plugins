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
</div>
{else}
<div class="n5qj_tbys nbg cl">
<a href="javascript:history.back();" class="n5qj_zcan"><div class="zcanfh">{$n5app['lang']['qjfanhui']}</div></a>
<span>{$n5app['lang']['kjmmyz']}</span>
</div>
{/if}
<div class="n5sq_bkjm cl">
	<div class="n5sq_jmsm cl"></div>
	<p>{$n5app['lang']['kjmmyzts']}</p>
	<div class="bkjm_mmsr">
	<form method="post" autocomplete="off"  id="invalueform" name="invalueform" action="home.php?mod=misc&ac=inputpwd" {if $_G[inajax]}onsubmit="ajaxpost(this.id, 'return_$_GET[handlekey]');"{/if}>
	<!--{if $_G[inajax]}--><input type="hidden" name="handlekey" value="$_GET[handlekey]" /><!--{/if}-->
	<input type="hidden" name="refer" value="$_SERVER[REQUEST_URI]" />
	<input type="hidden" name="blogid" value="$invalue[blogid]" />
	<input type="hidden" name="albumid" value="$invalue[albumid]" />
	<input type="hidden" name="pwdsubmit" value="true" />
	<input type="hidden" name="formhash" value="{FORMHASH}" />
		<div class="c mbn">
			<input type="password" name="viewpwd" value="" class="mmsrmm" />
		</div>
		<p class="o pns">
			<button type="submit" name="submit" value="true" class="mmsrqr">{lang submit}</button>
		</p>
	</form>
	</div>
	<!--{if $_G[inajax]}-->
	<script type="text/javascript">
		function succeedhandle_$_GET[handlekey](url, msg, values) {
			if(values['succeed'] == 1) {
				window.location.href = url;
			}
		}
	</script>
			<!--{/if}-->
</div>
<!--{template common/footer}-->