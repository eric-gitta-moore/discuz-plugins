<?php exit;?>
<!--{eval if(!function_exists('init_n5app'))include DISCUZ_ROOT.'./source/plugin/zhikai_n5appgl/common.php'; if(!function_exists('init_n5app')) exit('Authorization error!');}-->
<!--{eval include_once DISCUZ_ROOT.'./source/plugin/zhikai_n5appgl/nvbing5.php'}-->
<!--{if !empty($srchtype)}--><input type="hidden" name="srchtype" value="$srchtype" /><!--{/if}-->
<div class="n5ss_ssys cl">
	<div class="ssys_sssr z cl">
		<input value="$keyword" autocomplete="off" class="input" name="srchtxt" id="scform_srchtxt" value="">
	</div>
	<div class="ssys_ssqr z cl">
		<input type="hidden" name="searchsubmit" value="yes"><input type="submit" value="{lang search}" class="button2" id="scform_submit">
	</div>
</div>
