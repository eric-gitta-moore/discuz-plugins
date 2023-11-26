<?PHP exit('QQÈº£º550494646');?>
<!--{template common/header}-->
<div class="header">
    <div class="nav">
        <a href="javascript:;" onclick="history.go(-1)" class="z"><i class="iconfont icon-back_light"></i></a>	
        <span class="name">{lang rate}</span>
    </div>
</div>

<div class="ainuo_pop cl">
	<form id="rateform" method="post" autocomplete="off" action="forum.php?mod=misc&action=rate&ratesubmit=yes&infloat=yes" onsubmit="ajaxpost('rateform', 'return_rate', 'return_rate', 'onerror');">
		<input type="hidden" name="formhash" value="{FORMHASH}" />
		<input type="hidden" name="tid" value="$_G[tid]" />
		<input type="hidden" name="pid" value="$_GET[pid]" />
		<input type="hidden" name="referer" value="$referer" />
		<!--{if !empty($_GET['infloat'])}--><input type="hidden" name="handlekey" value="rate"><!--{/if}-->
		<div class="acon arate">
        	
			<table cellspacing="0" cellpadding="0" width="100%">
				<tr>
					<th width="60">$alang_credit</th>
					<th width="65">$alang_num</th>
					<th width="65">{lang rate_raterange}</th>
					<th width="65">{lang rate_todayleft}</th>
				</tr>
				<!--{eval $rateselfflag = 0;}-->
				<!--{loop $ratelist $id $options}-->
					<tr>
						<td>{$_G['setting']['extcredits'][$id][img]} {$_G['setting']['extcredits'][$id][title]}</td>
						<td>
							<input type="text" name="score$id" id="score$id" class="px z" value="0" style="width:50px;" />
						</td>
						<td>{$_G['group']['raterange'][$id]['min']} ~ {$_G['group']['raterange'][$id]['max']}</td>
						<!--{eval $rateselfflag = $_G['group']['raterange'][$id][isself] ? 1 : $rateselfflag;}-->
						<td>$maxratetoday[$id]</td>
					</tr>
				<!--{/loop}-->
			</table>
			<!--{if $rateselfflag}-->
				<div class="dashedtip cl" style="margin-top:10px;">{lang admin_rate}</div>
			<!--{/if}-->
			
			
		</div>
        <div class="cl" style="padding:0 10px; font-size:14px;">
        	<div class="z">{lang admin_pm}</div>
        	<label for="sendreasonpm" class="label-switch y">
				<input type="checkbox" name="sendreasonpm" id="sendreasonpm" /><div class="checkbox"></div>
            </label>
       	</div>
		<div class="ainuo_popbottom cl" style="padding:15px; margin-top:10px;">
			<button name="ratesubmit" type="submit" value="true" class="button button-fill button-success">{lang confirms}</button>
		</div>
	</form>
</div>


<!--{template common/footer}-->