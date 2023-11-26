<?PHP exit('QQÈº£º550494646');?>
<!--{template common/header}-->

<!--{if $_G['inajax']}-->
<div class="ainuo_debate_dp cl">
<div class="atit"><em id="return_$_GET['handlekey']">{lang debate_umpirecomment}</em></div>
<form method="post" autocomplete="off" id="postform" action="forum.php?mod=misc&action=debateumpire&tid=$_G[tid]&umpiresubmit=yes&infloat=yes{if !empty($_GET['from'])}&from=$_GET['from']{/if}"{if !empty($_GET['infloat'])} onsubmit="ajaxpost('postform', 'return_$_GET['handlekey']', 'return_$_GET['handlekey']', 'onerror');return false;"{/if}>
	<div class="cl">

		<input type="hidden" name="formhash" id="formhash" value="{FORMHASH}" />
		<!--{if !empty($_GET['infloat'])}--><input type="hidden" name="handlekey" value="$_GET['handlekey']" /><!--{/if}-->
		<div class="cl">
			<table width="100%" cellspacing="0" cellpadding="0">
				<tr>
					<th>{lang debate_winner}</th>
					<td>
						<label class="lb"><input type="radio" name="winner" value="1" class="pr" $winnerchecked[1] id="winner1" />{lang debate_square}</label>
						<label class="lb"><input type="radio" name="winner" value="2" class="pr" $winnerchecked[2] id="winner2" />{lang debate_opponent}</label>
						<label class="lb"><input type="radio" name="winner" value="3" class="pr" $winnerchecked[3] id="winner3" />{lang debate_draw}</label>
					</td>
				</tr>

				<tr>
					<th><label for="bestdebater">{lang debate_bestdebater}</label></th>
					<td>
						<p>
							<select onchange="document.getElementById('bestdebater').value=this.options[this.options.selectedIndex].value" class="px">
								<option value=""><strong>{lang debate_recommend_list}</strong></option>
								<option value="">------------------------------</option>
								<!--{loop $candidates $candidate}-->
									<option value="$candidate[username]"{if $candidate[username] == $debate[bestdebater]} selected="selected"{/if}>$candidate[username] ( $candidate[voters] {lang debate_poll}, <!--{if $candidate[stand] == 1}-->{lang debate_square}<!--{elseif $candidate[stand] == 2}-->{lang debate_opponent}<!--{/if}-->)</option>
								<!--{/loop}-->
							</select>
						</p>
						<p class="mtn"><input type="text" name="bestdebater" id="bestdebater" class="px a100" value="$debate[bestdebater]" size="20" /></p>
					</td>
				</tr>
                <tr>
					<td colspan="2">
						<p class="dtip">{lang debate_list_nonexistence}</p>
					</td>
				</tr>

				<tr>
					<th><label for="umpirepoint">{lang debate_umpirepoint}</label></th>
					<td><textarea id="umpirepoint" name="umpirepoint" class="px a100" rows="2">$debate[umpirepoint]</textarea></td>
				</tr>
			</table>
		</div>
	</div>
	<div class="pns">
		<button class="formdialog" type="submit" name="umpiresubmit" value="true" class="submit">{lang submit}</button>
	</div>
</form>
</div>

<script type="text/javascript" reload="1">
function succeedhandle_$_GET['handlekey'](locationhref) {
	<!--{if !empty($_GET['from'])}-->
		location.href = locationhref;
	<!--{else}-->
		ajaxget('forum.php?mod=viewthread&tid=$_G[tid]&viewpid=$_GET[pid]', 'post_$_GET[pid]');
		hideWindow('$_GET['handlekey']');
	<!--{/if}-->
}
</script>

<!--{/if}-->
<!--{template common/footer}-->