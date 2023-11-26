<?php exit;?>
<!--{template common/header}-->
<!--{eval if(!function_exists('init_n5app'))include DISCUZ_ROOT.'./source/plugin/zhikai_n5appgl/common.php'; if(!function_exists('init_n5app')) exit('Authorization error!');}-->
<!--{eval include_once DISCUZ_ROOT.'./source/plugin/zhikai_n5appgl/nvbing5.php'}-->
<!--{if $op == 'delete'}-->
<div class="tip">
<form method="post" autocomplete="off" action="portal.php?mod=portalcp&ac=article&op=delete&aid=$_GET[aid]">
	<dt>
		<!--{if $_G['group']['allowpostarticlemod'] && $article['status'] == 1}-->
		{lang article_delete_sure}
		<input type="hidden" name="optype" value="0" class="pc" />
		<!--{else}-->
		<label class="lb"><input type="radio" name="optype" value="0" class="pc" />{lang article_delete_direct}</label>
		<label class="lb"><input type="radio" name="optype" value="1" class="pc" checked="checked" />{lang article_delete_recyclebin}</label>
		<!--{/if}-->
	</dt>
	<dd>
		<button type="submit" name="btnsubmit" value="true" class="formdialog button2">{lang confirms}</button>
		<a href="javascript:;" onclick="popup.close();">{$n5app['lang']['sqbzssmqx']}</a>
	</dd>
	<input type="hidden" name="aid" value="$_GET[aid]" />
	<input type="hidden" name="referer" value="{echo dreferer()}" />
	<input type="hidden" name="deletesubmit" value="true" />
	<input type="hidden" name="formhash" value="{FORMHASH}" />
</form>
</div>
<!--{else}-->
<div class="n5qj_tbys nbg cl">
	<a href="javascript:history.back();" class="n5qj_zcan"><div class="zcanfh">{$n5app['lang']['qjfanhui']}</div></a>
	<a href="search.php?mod=forum" class="n5qj_ycan sousuo"></a>
	<span>{$n5app['lang']['tishi']}</span>
</div>
<div class="jump_c">
	<p><img src="template/zhikai_n5app/images/chat.png"></p>
	<p class="tsnrs">{$n5app['lang']['sjbbnfbzxts']}</p>
</div>
<!--{/if}-->
<!--{template common/footer}-->