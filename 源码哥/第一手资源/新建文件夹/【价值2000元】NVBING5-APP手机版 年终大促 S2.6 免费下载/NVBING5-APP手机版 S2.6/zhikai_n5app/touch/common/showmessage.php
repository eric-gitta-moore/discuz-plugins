<?php exit;?>
<!--{if $param['login']}-->
	<!--{if $_G['inajax']}-->
	<!--{eval dheader('Location:member.php?mod=logging&action=login&inajax=1&infloat=1');exit;}-->
	<!--{else}-->
	<!--{eval dheader('Location:member.php?mod=logging&action=login');exit;}-->
	<!--{/if}-->
<!--{/if}-->
<!--{template common/header}-->
<!--{eval if(!function_exists('init_n5app'))include DISCUZ_ROOT.'./source/plugin/zhikai_n5appgl/common.php'; if(!function_exists('init_n5app')) exit('Authorization error!');}-->
<!--{eval include_once DISCUZ_ROOT.'./source/plugin/zhikai_n5appgl/nvbing5.php'}-->
<!--{if $_G['inajax']}-->
<div class="tip" style="height:150px;">
	<dt id="messagetext">
			<p>$show_message</p>
        <!--{if $_G['forcemobilemessage']}-->
        	<p >
            	<a href="{$_G['setting']['mobile']['pageurl']}" class="mtn">{lang continue}</a><br />
                <a href="javascript:history.back();">{lang goback}</a>
            </p>
        <!--{/if}-->
		<!--{if $url_forward && !$_GET['loc']}-->
			<!--<p><a class="grey" href="$url_forward">{lang message_forward_mobile}</a></p>-->
			<script type="text/javascript">
				setTimeout(function() {
					window.location.href = '$url_forward';
				}, '3000');
			</script>
		<!--{elseif $allowreturn}-->
			<div class="tip_qx"><input type="button" class="button" onclick="window.location.reload();" value="{lang close}"></div>
		<!--{/if}-->
	</dt>
</div>
<!--{else}-->
{if strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'micromessenger')}
<style type="text/css">.bg {padding-top: 0;}</style>
<div class="n5qj_wxgdan cl">
	<a href="javascript:history.back();" class="wxmsf"></a>
	<a href="search.php?mod=forum" class="wxmss"></a>
</div>
{else}
<div class="n5qj_tbys nbg cl">
	<a href="javascript:history.back();" class="n5qj_zcan"><div class="zcanfh">&#36820;&#22238;</div></a>
	<a href="search.php?mod=forum" class="n5qj_ycan sousuo"></a>
	<span>&#25552;&#31034;</span>
</div>
{/if}
<style type="text/css">
</style>
<div class="jump_c">
	<div class="n5qj_tstp cl"></div>
	<p class="tsnrs">$show_message</p>
    <!--{if $_G['forcemobilemessage']}-->
        <a href="javascript:history.back();" class="mtn">{lang continue}</a>
        <a href="javascript:history.back();">{lang goback}</a>
    <!--{/if}-->
	<!--{if $url_forward}-->
		<a href="$url_forward">{lang message_forward_mobile}</a>
	<!--{elseif $allowreturn}-->
		<!--{if $_G['forcemobilemessage']}--><!--{else}--><!--{/if}-->
	<!--{/if}-->
</div>

<!--{/if}-->
<!--{template common/footer}-->