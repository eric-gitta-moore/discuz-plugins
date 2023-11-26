<?php exit;?>
<div class="ztfb_tszt cl">
	<!--{if $_GET[action] == 'newthread'}-->
		<div class="tszt_fbxm cl">
			<div class="fbxm_xmbt z">{lang reward_price}</div>
			<div class="fbxm_xmnr z">
				<input type="text" name="rewardprice" id="rewardprice" class="px" size="6" onkeyup="getrealprice(this.value)" value="{$_G['group']['minrewardprice']}" tabindex="1" />
				<div class="tszt_tsxx">
					{lang reward_price_min} {$_G['group']['minrewardprice']} {$_G['setting']['extcredits'][$_G['setting']['creditstransextra'][2]][unit]}
					<!--{if $_G['group']['maxrewardprice'] > 0}-->, {lang reward_price_max} {$_G['group']['maxrewardprice']} {$_G['setting']['extcredits'][$_G['setting']['creditstransextra'][2]][unit]}<!--{/if}-->
					, {lang you_have} <!--{echo getuserprofile('extcredits'.$_G['setting']['creditstransextra'][2]);}--> {$_G['setting']['extcredits'][$_G['setting']['creditstransextra'][2]][unit]}{$_G['setting']['extcredits'][$_G['setting']['creditstransextra'][2]][title]}
				</div><!--Fr om www.xhkj 5.com-->
				<!--{if $_G['setting']['rewardexpiration'] > 0}-->
				<div class="d">
					$_G['setting']['rewardexpiration'] {lang post_reward_message}
				</div>
				<!--{/if}-->
			</div>
		</div>
	<!--{/if}-->
	<!--{hook/post_reward_extra}-->
</div>