<?php exit;?>
<!--{template common/header}-->
<div class="n5sq_spgl cl">
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

<form id="tradeform" method="post" autocomplete="off" action="forum.php?mod=misc&action=tradeorder&tid=$_G[tid]&tradesubmit=yes&infloat=yes{if !empty($_GET['from'])}&from=$_GET['from']{/if}"{if !empty($_GET['infloat'])} onsubmit="ajaxpost('tradeform', 'return_$_GET['handlekey']', 'return_$_GET['handlekey']', 'onerror');return false;"{/if}>
<input type="hidden" name="formhash" value="{FORMHASH}" />
<!--{if !empty($_GET['infloat'])}--><input type="hidden" name="handlekey" value="$_GET['handlekey']" /><!--{/if}-->
<div class="spgl_glxx cl">
	<!--{loop $trades $trade}-->
	<style type="text/css">
	#sendreasonpm$trade[pid] {display:none;}
	#sendreasonpm$trade[pid] + label {display: block;position: relative;cursor:pointer;padding:2px;width:32px;height:16px;background: #ddd;border-radius: 60px;}
	#sendreasonpm$trade[pid] + label:before,#sendreasonpm$trade[pid] + label:after {display: block;position: absolute;top: 1px;left: 1px;bottom: 1px;content: "";}
	#sendreasonpm$trade[pid] + label:after {width: 18px;height:18px;background-color: #fff;border-radius: 100%;box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);transition: margin 0.4s;}
	#sendreasonpm$trade[pid] + label:before {right: 1px;background-color: #f1f1f1;border-radius: 60px;transition: background 0.4s;}
	#sendreasonpm$trade[pid]:checked + label:before {background-color: #41c2fc;}
	#sendreasonpm$trade[pid]:checked + label:after {margin-left: 16px;}
	</style>
	<div class="spgl_glnr cl">
		<a href="forum.php?mod=post&action=edit&fid=$thread[fid]&tid=$_G[tid]&pid=$trade[pid]">{lang edit}</a>$trade[subject]
		<div class="glnr_sppx cl"><div class="z">{$n5app['lang']['sqshangpinpx']}</div><div class="y"><input size="1" name="displayorder[{$trade[pid]}]" value="$trade[displayorderview]" class="px pxs" /></div></div>
		<div class="glnr_sptj cl"><div class="z">{$n5app['lang']['sqshangpintj']}</div><div class="y"><input id="sendreasonpm$trade[pid]" class="pc" type="checkbox" onclick="checkbox(this)" name="stick[{$trade[pid]}]" value="yes" {if $trade[displayorder] > 0}checked="checked"{elseif $_G['group']['tradestick'] <= $stickcount}disabled="disabled"{/if} /><label for="sendreasonpm$trade[pid]"></label></div></div>
	</div>
	<!--{/loop}-->
</div>



<div class="spgl_gltj">
	<div class="spgl_glts">{$n5app['lang']['tishi']}:{lang trade_update_stickmax} {$_G['group']['tradestick']}</div>
	<button tabindex="1" class="pn" type="submit" name="tradesubmit" value="true">{lang save}</button>
</div>

</form>

<script type="text/javascript" reload="1">
function succeedhandle_$_GET['handlekey'](locationhref) {
	location.href = locationhref;
}
</script>

</div>
<!--{template common/footer}-->