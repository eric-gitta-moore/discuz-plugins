<?php exit;?>
<div class="ztfb_tszt cl">
<table cellspacing="0" cellpadding="0">
    <div class="tszt_fbxm cl">
		<div class="fbxm_xmbt z">{lang post_trade_name}</div>
		<div class="fbxm_xmnr z"><input type="text" name="item_name" id="item_name" class="px" placeholder="{$n5app['lang']['sqfbbitiansm']}" value="$trade[subject]" tabindex="1" /></div>
    </div><!--From  www.xhkj5.com-->
    <div class="tszt_fbxm cl">
		<div class="fbxm_xmbt z">{lang post_trade_number}</div>
		<div class="fbxm_xmnr z">
			<input type="text" name="item_number" id="item_number" class="px pxs" placeholder="{$n5app['lang']['sqfbbitiansm']}" value="$trade[amount]" tabindex="1" />
			<select id="item_quality" class="ps pss" name="item_quality" tabindex="1">
				<option value="1" {if $trade['quality'] == 1}selected="selected"{/if}>{lang trade_new}</option>
				<option value="2" {if $trade['quality'] == 2}selected="selected"{/if}>{lang trade_old}</option>
			</select>
		</div>
    </div>
    <div class="tszt_fbxm cl">
		<div class="fbxm_xmbt z">{lang post_trade_transport}</div>
		<div class="fbxm_xmnr z">
			<select name="transport" id="transport" width="108" change="$('logisticssetting').style.display = $('transport').value == 'virtual' ? 'none' : ''" class="ps">
			<option value="virtual" {if $trade['transport'] == 3}selected="selected"{/if}>{lang post_trade_transport_virtual}</option>
			<option value="seller" {if $trade['transport'] == 1}selected="selected"{/if}>{lang post_trade_transport_seller}</option>
			<option value="buyer" {if $trade['transport'] == 2}selected="selected"{/if}>{lang post_trade_transport_buyer}</option>
			<option value="logistics" {if $trade['transport'] == 4}selected="selected"{/if}>{lang trade_type_transport_physical}</option>
			<option value="offline" {if $trade['transport'] == 0}selected="selected"{/if}>{lang post_trade_transport_offline}</option>
			</select>
        </div>
    </div><!--Fr om www.xhkj 5.com-->
    <div class="tszt_fbxm cl">
		<div class="fbxm_xmbt z">{lang post_trade_price}</div>
		<div class="fbxm_xmnr z">
			<div class="mbm">
				<input type="text" name="item_price" id="item_price" class="px mbn" placeholder="{lang post_current_price}" value="$trade[price]" tabindex="1" />
				<input type="text" name="item_costprice" id="item_costprice" class="px mbn" placeholder="{lang post_original_price}" value="$trade[costprice]" tabindex="1" />
			</div>
			<!--{if $_G['setting']['creditstransextra'][5] != -1}-->
			<div class="mbm">
				<input type="text" name="item_credit" id="item_credit" class="px  mbn" placeholder="{lang post_current_credit}({$_G['setting']['extcredits'][$_G['setting']['creditstransextra'][5]][title]})" value="$trade[credit]" tabindex="1" />
				<input type="text" name="item_costcredit" id="item_costcredit" class="px  mbn" placeholder="{lang post_original_credit}({$_G['setting']['extcredits'][$_G['setting']['creditstransextra'][5]][title]})" value="$trade[costcredit]" tabindex="1" />
			</div>
			<!--{/if}-->
			<div class="mbm" id="logisticssetting" style="display:{if !$trade['transport'] || $trade['transport'] == 3}none{/if}">
				<input type="text" name="postage_mail" id="postage_mail" class="px" placeholder="{lang post_trade_transport_mail}" value="$trade[ordinaryfee]" tabindex="1" />
				<input type="text" name="postage_express" id="postage_express" class="px" placeholder="{lang post_trade_transport_express}" value="$trade[expressfee]" tabindex="1" />
				<input type="text" name="postage_ems" id="postage_ems" class="px" placeholder="EMS" value="$trade[emsfee]" tabindex="1" />
			</div>
		</div>
    </div><!--Fr om www.xhkj5.com-->
    <div class="tszt_fbxm cl">
		<div class="fbxm_xmbt z">{lang post_trade_paymethod}</div>
		<div class="fbxm_xmnr z">
			<select name="paymethod" id="paymethod" width="108" change="display('tenpayseller')" class="ps" tabindex="1">
			<!--{if $_G[setting][ec_tenpay_opentrans_chnid]}-->
				<option value="0" {if $trade[tenpayaccount]}selected{/if}>{lang post_trade_paymethod_online}</option>
			<!--{/if}-->
			<option value="1" {if !$trade[tenpayaccount]}selected{/if}>{lang post_trade_paymethod_offline}</option>
			</select>
        </div>
    </div>
    <div id="tenpayseller" class="tszt_fbxm cl" style="{if !$trade[tenpayaccount]}display:none{/if}">
		<div class="fbxm_xmbt z">{lang post_trade_tenpay_seller}</div>
		<div class="fbxm_xmnr z"><input type="text" name="tenpay_account" id="tenpay_account" class="px" value="$trade[tenpayaccount]" tabindex="2" /></div>
    </div>
    <div class="tszt_fbxm cl">
		<div class="fbxm_xmbt z">{lang post_trade_locus}</div>
		<div class="fbxm_xmnr z"><input type="text" name="item_locus" id="item_locus" class="px" placeholder="{$n5app['lang']['sqfbxttiansm']}" value="$trade[locus]" tabindex="1" /></div>
    </div>
	<div class="tszt_fbxm cl">
		<div class="fbxm_xmbt z">{lang valid_before}</div>
		<div class="fbxm_xmnr z"><input type="text" name="item_expiration" id="item_expiration" class="px datetime" placeholder="{$n5app['lang']['sqfbqszsjs']}" autocomplete="off" tabindex="1" /></div>
    </div>
    <!--{if $allowpostimg}-->
    <div class="tszt_fbxm cl">
		<div class="fbxm_xmbt z">{lang post_trade_picture}</div>
		<div class="fbxm_xmnr z">
			<button type="button" class="pn" onclick="uploadWindow($_G['fid'],function (aid, url){tradeaid_upload(aid, url)})"><em><!--{if $tradeattach[attachment]}-->{lang update}<!--{else}-->{lang upload}<!--{/if}--></em></button>
			<input type="hidden" name="tradeaid" id="tradeaid" {if $tradeattach[attachment]}value="$tradeattach[aid]" {/if}/>
			<input type="hidden" name="tradeaid_url" id="tradeaid_url" />
			<div id="tradeattach_image" class="fbxm_hdtp"> 
				<!--{if $tradeattach[attachment]}--> 
				<a href="$tradeattach[url]/$tradeattach[attachment]" target="_blank"><img class="spimg" src="$tradeattach[url]/{if $tradeattach['thumb']}{eval echo getimgthumbname($tradeattach['attachment']);}{else}$tradeattach[attachment]{/if}" alt="" /></a> 
				<!--{/if}--> 
			</div>
		</div>
    </div>
    <!--{/if}--> 
    <!--{hook/post_trade_extra}-->
</table>
</div>
<script type="text/javascript" reload="1">
simulateSelect('item_quality');
simulateSelect('paymethod');
simulateSelect('transport');
//EXTRAFUNC['validator']['special'] = 'validateextra';
function validateextra() {
	if(Scratching('postform').item_name.value == '') {
		showDialog('{lang post_goods_error_message_1}', 'alert', '', function () { Scratching('postform').item_name.focus() });
		return false;
	}
	if(Scratching('postform').item_number.value == '') {
		showDialog('{lang post_goods_error_message_2}', 'alert', '', function () { Scratching('postform').item_number.focus() });
		return false;
	}
	if(Scratching('postform').item_price.value == '' && Scratching('postform').item_credit.value == '') {
		showDialog('{lang post_goods_error_message_3}', 'alert', '', function () { Scratching('postform').item_price.focus() });
		return false;
	}
	return true;
}
function tradeaid_upload(aid, url) {	Scratching('tradeaid_url').value = url;	updatetradeattach(aid, url, '{$_G['setting']['attachurl']}forum');}
</script> 