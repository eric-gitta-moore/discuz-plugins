<?php exit;?>
<!--{eval if(!function_exists('init_n5app'))include DISCUZ_ROOT.'./source/plugin/zhikai_n5appgl/common.php'; if(!function_exists('init_n5app')) exit('Authorization error!');}-->
<!--{eval include_once DISCUZ_ROOT.'./source/plugin/zhikai_n5appgl/nvbing5.php'}-->
<script src="template/zhikai_n5app/js/jquery.memoticons.js" type="text/javascript"></script>
<div class="n5sq_kshf n5gr_plrz cl">
	<form method="post" autocomplete="off" id="mood_addform" action="home.php?mod=spacecp&ac=doing&view=$_GET[view]" onsubmit="if($('message').value == msgstr){return false;}">
		<div class="plrz_srk cl">
			<textarea name="message" id="message" class="pt" rows="4" placeholder="{$n5app['lang']['hykjsssrk']}"></textarea>
		</div>
		<div class="plrz_fbbq n5ss_ssfb cl">
			<div class="y cl">
				<span class="n5ss_tbqm z">
				<!--{if $_G['group']['maxsigsize']}-->
					<i>{$n5app['lang']['hykjtbqm']}</i><input type="checkbox" name="to_signhtml" id="sendreasonpm" class="pc" value="1" /><label for="sendreasonpm" class="y"></label>
				<!--{/if}-->
				</span>
				<button type="submit" name="add" id="add" class="pn">{lang publish}</button>
			</div>
			<div class="z cl">
				<a href="JavaScript:void(0)" id="message_face" class="qtcz_bqan"></a>
			</div>
		</div>
		<style type="text/css">
			#facebox {height: 150px;}
			.facebox li img {width: 47%;}
		</style>
		<div id="kshf_bqzs" class="plrz_bqzs"></div>
		<input type="hidden" name="addsubmit" value="true" />
		<input type="hidden" name="refer" value="$theurl" />
		<input type="hidden" name="topicid" value="$topicid" />
		<input type="hidden" name="formhash" value="{FORMHASH}" />
	</form>
	<script type="text/javascript">
		var jq = jQuery.noConflict(); 
		jq("#message_face").jqfaceedit({txtAreaObj:jq("#message"),containerObj:jq('#kshf_bqzs')});
	</script>
</div>