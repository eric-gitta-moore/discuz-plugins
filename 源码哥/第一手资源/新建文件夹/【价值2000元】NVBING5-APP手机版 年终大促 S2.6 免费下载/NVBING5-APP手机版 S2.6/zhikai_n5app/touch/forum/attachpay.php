<?php exit;?>
<!--{template common/header}-->
<div class="n5sq_ztds n5sq_fjgm cl">
<a href="javascript:;" onclick="popup.close();" class="ztds_gbck"></a>
<div class="ztds_mbxx cl">
<p class="mbxx_yhm">{lang pay_attachment}</p>
</div>
<form id="attachpayform" method="post" autocomplete="off" action="forum.php?mod=misc&action=attachpay&tid={$_G[tid]}{if !empty($_GET['infloat'])}&paysubmit=yes&infloat=yes" onsubmit="ajaxpost('attachpayform', 'return_$_GET['handlekey']', 'return_$_GET['handlekey']', 'onerror');return false;"{else}"{/if}>
		<input type="hidden" name="formhash" value="{FORMHASH}" />
		<input type="hidden" name="referer" value="{echo dreferer()}" />
		<input type="hidden" name="aid" value="$aid" /><!--F rom www.xhkj5.com-->
		<!--{if !empty($_GET['infloat'])}--><input type="hidden" name="handlekey" value="$_GET['handlekey']" /><!--{/if}-->
		<div class="ztds_dsys cl">
			<table class="list" cellspacing="0" cellpadding="0" style="width: 100%">
				<tr>
					<td class="dsys_jfmc">{lang author}</td>
					<td class="dsys_mrxe"><a href="home.php?mod=space&uid=$attach[uid]">$attach[author]</a></td>
				</tr>
				<tr>
					<td class="dsys_jfmc">{lang attachment}</td>
					<td class="dsys_mrxe"><div style="overflow:hidden">$attach[filename] <!--{if $attach['description']}-->($attach[description])<!--{/if}--></div></td>
				</tr>
				<tr>
					<td class="dsys_jfmc">{lang price}({$_G['setting']['extcredits'][$_G['setting']['creditstransextra'][1]][title]})</td>
					<td class="dsys_mrxe">$attach[price] {$_G['setting']['extcredits'][$_G['setting']['creditstransextra'][1]][unit]}</td>
				</tr><!--From ww w.ymg 6.com-->
				<!--{if $status != 1}-->
				<tr>
					<td class="dsys_jfmc">{lang pay_author_income}({$_G['setting']['extcredits'][$_G['setting']['creditstransextra'][1]][title]})</td>
					<td class="dsys_mrxe">$attach[netprice] {$_G['setting']['extcredits'][$_G['setting']['creditstransextra'][1]][unit]}</td>
				</tr>
				<tr>
					<td class="dsys_jfmc">{lang pay_balance}({$_G['setting']['extcredits'][$_G['setting']['creditstransextra'][1]][title]})</td>
					<td class="dsys_mrxe">$balance {$_G['setting']['extcredits'][$_G['setting']['creditstransextra'][1]][unit]}</td>
				</tr>
				<!--{/if}-->
				<!--{if $status == 1}-->
				<tr>
					<td class="dsys_jfmc">&nbsp;</td>
					<td class="dsys_mrxe">{lang status_insufficient}</td>
				</tr>
				<!--{elseif $status == 2}-->
				<tr>
					<td class="dsys_jfmc">&nbsp;</td>
					<td class="dsys_mrxe">{lang status_download}, <a href="forum.php?mod=attachment&aid=$aidencode" target="_blank">{lang download}</a></td>
				</tr>
				<!--{/if}-->
			</table>

			<!--{if $status != 1}-->
			<div class="dsys_tzkg cl">
				<div class="y cl"><input name="sendreasonpm" id="sendreasonpm" type="checkbox" class="pc" value="yes" /><label for="sendreasonpm"></label></div>
				<div class="z cl">{lang buy_all_attch}</div>
			</div>
			<button class="pn pnc dsys_dsan" type="submit" name="paysubmit" value="true"><!--{if $status == 0}-->{lang pay_attachment}<!--{else}-->{lang free_buy}<!--{/if}--></button>
			<!--{/if}-->
		</div>
	</div>
</form>

<!--{if !empty($_GET['infloat'])}-->
<script type="text/javascript" reload="1">
function succeedhandle_$_GET['handlekey'](locationhref) {
	ajaxget('forum.php?mod=viewthread&tid=$attach[tid]&viewpid=$attach[pid]', 'post_$attach[pid]');
	hideWindow('$_GET['handlekey']');
	showCreditPrompt();
}
</script>
<!--{/if}-->


<!--{template common/footer}-->