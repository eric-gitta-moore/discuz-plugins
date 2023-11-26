<?php exit;?>
<!--{template common/header}-->
<!--{eval if(!function_exists('init_n5app'))include DISCUZ_ROOT.'./source/plugin/zhikai_n5appgl/common.php'; if(!function_exists('init_n5app')) exit('Authorization error!');}-->
<!--{eval include_once DISCUZ_ROOT.'./source/plugin/zhikai_n5appgl/nvbing5.php'}-->
<div class="n5sq_spxx cl">
	<a href="javascript:;" onclick="popup.close();" class="ztds_gbck"></a>
	<!--{if $trade['thumb']}--><img src="$trade[thumb]"><!--{else}--><!--{/if}-->
	<div class="spxx_lb cl">
		<p><i>{$n5app['lang']['sqshangpinlx']}</i><!--{if $trade['quality'] == 1}-->{lang trade_new}<!--{/if}--><!--{if $trade['quality'] == 2}-->{lang trade_old}<!--{/if}-->{lang trade_type_buy}</p>
		<p><i>{lang trade_transport}</i>
				<!--{if $trade['transport'] == 0}-->{lang post_trade_transport_offline}<!--{/if}-->
				<!--{if $trade['transport'] == 1}-->{lang post_trade_transport_seller}<!--{/if}-->
				<!--{if $trade['transport'] == 2 || $trade['transport'] == 4}-->
					<!--{if $trade['transport'] == 4}-->{lang post_trade_transport_physical}<!--{/if}-->
					<!--{if !empty($trade['ordinaryfee']) || !empty($trade['expressfee']) || !empty($trade['emsfee'])}-->
						<!--{if !empty($trade['ordinaryfee'])}-->{lang post_trade_transport_mail} $trade[ordinaryfee] {lang payment_unit}<!--{/if}-->
						<!--{if !empty($trade['expressfee'])}--> {lang post_trade_transport_express} $trade[expressfee] {lang payment_unit}<!--{/if}-->
						<!--{if !empty($trade['emsfee'])}--> EMS $trade[emsfee] {lang payment_unit}<!--{/if}-->
					<!--{elseif $trade['transport'] == 2}-->{lang post_trade_transport_none}<!--{/if}-->
				<!--{/if}-->
				<!--{if $trade['transport'] == 3}-->{lang post_trade_transport_virtual}<!--{/if}-->
			</p><!--Fr om www.xhkj5.com-->
		<p><i>{$n5app['lang']['sqshangpinsj']}</i>
			<!--{if $trade[closed]}-->
				<em>{lang trade_timeout}</em>
			<!--{elseif $trade[expiration] > 0}-->
				{$trade[expiration]} {lang days} {$trade[expirationhour]} {lang trade_hour}
			<!--{elseif $trade[expiration] == 0}-->
				{$trade[expirationhour]} {lang trade_hour}
			<!--{elseif $trade[expiration] == -1}-->
				<em>{lang trade_timeout}</em>
			<!--{else}-->
				&nbsp;
			<!--{/if}-->
			</p>
		<p><i>{$n5app['lang']['sqshangpinsl']}</i>$trade[amount]</p>
		<!--{if $trade[locus]}--><p><i>{$n5app['lang']['sqshangpindd']}</i>$trade[locus]</p><!--{/if}-->
		<p><i>{$n5app['lang']['sqshangpinsc']}</i>$trade[totalitems]</p>
	</div>
</div>
<!--{template common/footer}-->