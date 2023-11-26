<?PHP exit('QQÈº£º550494646');?>
<!--{template common/header}-->
<!--{subtemplate common/bgcolor}-->
<!-- header start -->
<header class="header">
    <div class="nav">
        <a href="javascript:;" onclick="history.go(-1)" class="z"><i class="iconfont icon-back"></i></a>
		<span class="category">
			<span class="name">
				{lang trade_displayorder}
			</span>
		</span>
    </div>
</header>
<!-- header end -->

<script type="text/javascript" reload="1">
	var max_obj = {$_G['group']['tradestick']};
	var p = $stickcount;
	function checkbox(obj) {
		if(obj.checked) {
			p++;
			for (var i = 0; i < $('tradeform').elements.length; i++) {
				var e = tradeform.elements[i];
				if(p == max_obj) {
					if(e.name.match('stick') && !e.checked) {
						e.disabled = true;
					}
				}
			}
		} else {
			p--;
			for (var i = 0; i < $('tradeform').elements.length; i++) {
				var e = tradeform.elements[i];
				if(e.name.match('stick') && e.disabled) {
					e.disabled = false;
				}
			}
		}
	}
</script>

<div class="ainuo_trade_order cl">
<form id="tradeform" method="post" autocomplete="off" action="forum.php?mod=misc&action=tradeorder&tid=$_G[tid]&tradesubmit=yes&infloat=yes{if !empty($_GET['from'])}&from=$_GET['from']{/if}"{if !empty($_GET['infloat'])} onsubmit="ajaxpost('tradeform', 'return_$_GET['handlekey']', 'return_$_GET['handlekey']', 'onerror');return false;"{/if}>
<div class="f_c">
		<input type="hidden" name="formhash" value="{FORMHASH}" />
		<!--{if !empty($_GET['infloat'])}--><input type="hidden" name="handlekey" value="$_GET['handlekey']" /><!--{/if}-->
		<div class="c">
			<table class="list" cellspacing="0" cellpadding="0">
				<thead class="th">
					<tr>
						<td class="id">ID</td>
						<td class="tj">{lang trade_update_stick}</td>
						<th>{lang post_trade_name}</th>
					</tr>
				</thead>
				<!--{loop $trades $trade}-->
				<tr>
					<td class="id"><input size="1" name="displayorder[{$trade[pid]}]" value="$trade[displayorderview]" class="px pxs" /></td>
					<td class="tj"><input class="pc" type="checkbox" onclick="checkbox(this)" name="stick[{$trade[pid]}]" value="yes" {if $trade[displayorder] > 0}checked="checked"{elseif $_G['group']['tradestick'] <= $stickcount}disabled="disabled"{/if} /></td>
					<th>$trade[subject]&nbsp;<a href="forum.php?mod=post&action=edit&fid=$thread[fid]&tid=$_G[tid]&pid=$trade[pid]" class="edit">{lang edit}</a></th>
				</tr>
				<!--{/loop}-->
			</table>
		</div>
</div>
<div class="postsave cl">
	<button tabindex="1" type="submit" class="formdialog" name="tradesubmit" value="true">{lang save}</button>
</div>
</form>
</div>

<script type="text/javascript" reload="1">
function succeedhandle_$_GET['handlekey'](locationhref) {
	location.href = locationhref;
}
</script>

<!--{template common/footer}-->