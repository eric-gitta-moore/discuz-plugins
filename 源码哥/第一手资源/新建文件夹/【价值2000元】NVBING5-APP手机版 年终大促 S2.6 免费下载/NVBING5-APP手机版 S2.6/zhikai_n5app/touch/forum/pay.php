<?php exit;?>
<!--{template common/header}-->
<div class="n5sq_szxq cl">
<form id="payform" method="post" autocomplete="off" action="forum.php?mod=misc&action=pay&paysubmit=yes&infloat=yes{if !empty($_GET['from'])}&from=$_GET['from']{/if}"{if !empty($_GET['infloat'])} onsubmit="ajaxpost('payform', 'return_$_GET['handlekey']', 'return_$_GET['handlekey']', 'onerror');return false;"{/if}>
	<div class="f_c">
		<input type="hidden" name="formhash" value="{FORMHASH}" />
		<input type="hidden" name="referer" value="{echo dreferer()}" />
		<input type="hidden" name="tid" value="$_G[tid]" />
		<!--{if !empty($_GET['infloat'])}--><input type="hidden" name="handlekey" value="$_GET['handlekey']" /><!--{/if}-->
		<div class="c">
			<table class="list" cellspacing="0" cellpadding="0" style="width:200px">
				<tr>
					<th>{lang author}</th>
					<td><a href="home.php?mod=space&uid=$thread[authorid]" target="_blank">$thread[author]</a></td>
				</tr>
				<tr>
					<th valign="top">{lang price}({$_G['setting']['extcredits'][$_G['setting']['creditstransextra'][1]][title]})</th>
					<td>$thread[price] {$_G['setting']['extcredits'][$_G['setting']['creditstransextra'][1]][unit]}</td>
				</tr>
				<tr>
					<th valign="top">{lang pay_author_income}({$_G['setting']['extcredits'][$_G['setting']['creditstransextra'][1]][title]})</th>
					<td>$thread[netprice] {$_G['setting']['extcredits'][$_G['setting']['creditstransextra'][1]][unit]}</td>
				</tr>
				<tr>
					<th valign="top">{lang pay_balance}({$_G['setting']['extcredits'][$_G['setting']['creditstransextra'][1]][title]})</th>
					<td>$balance {$_G['setting']['extcredits'][$_G['setting']['creditstransextra'][1]][unit]}</td>
				</tr>
			</table>
		</div>
	</div>
	<button type="submit" name="paysubmit" class="pn" value="true">{lang submit}</button>
</form>
</div>
<!--{if !empty($_GET['infloat'])}-->
<script type="text/javascript" reload="1">
function succeedhandle_$_GET['handlekey'](locationhref) {
	<!--{if !empty($_GET['from'])}-->
		location.href = locationhref;
	<!--{else}-->
		ajaxget('forum.php?mod=viewthread&tid=$_G[tid]&viewpid=$_GET[pid]', 'post_$_GET[pid]');
		hideWindow('$_GET['handlekey']');
		showCreditPrompt();
	<!--{/if}-->
}
</script>
<!--{/if}-->
<!--{template common/footer}-->