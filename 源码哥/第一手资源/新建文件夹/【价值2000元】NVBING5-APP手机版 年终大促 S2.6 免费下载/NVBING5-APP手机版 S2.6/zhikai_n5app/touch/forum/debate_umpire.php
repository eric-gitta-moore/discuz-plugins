<?php exit;?>
<!--{template common/header}-->
<div class="n5sq_jsbl cl">
<a href="javascript:;" onclick="popup.close();" class="ztds_gbck"></a>
<form method="post" autocomplete="off" id="postform" action="forum.php?mod=misc&action=debateumpire&tid=$_G[tid]&umpiresubmit=yes&infloat=yes{if !empty($_GET['from'])}&from=$_GET['from']{/if}"{if !empty($_GET['infloat'])} onsubmit="ajaxpost('postform', 'return_$_GET['handlekey']', 'return_$_GET['handlekey']', 'onerror');return false;"{/if}>
		<input type="hidden" name="formhash" id="formhash" value="{FORMHASH}" />
		<!--{if !empty($_GET['infloat'])}--><input type="hidden" name="handlekey" value="$_GET['handlekey']" /><!--{/if}-->
		<table class="tfm" cellspacing="0" cellpadding="0"><!--From ww w.xhkj5.com-->
			<div class="jsbl_hsfd cl">
				<div class="hsfd_btys">{lang debate_winner}</div>
				<label class="lb"><input type="radio" name="winner" value="1" class="pr" $winnerchecked[1] id="winner1" />{lang debate_square}</label>
				<label class="lb"><input type="radio" name="winner" value="2" class="pr" $winnerchecked[2] id="winner2" />{lang debate_opponent}</label>
				<label class="lb"><input type="radio" name="winner" value="3" class="pr" $winnerchecked[3] id="winner3" />{lang debate_draw}</label>
			</div>

			<div class="jsbl_zjbs cl">
				<div class="zjbs_btys">{lang debate_bestdebater}</div>
				<select onchange="$('bestdebater').value=this.options[this.options.selectedIndex].value" class="ps">
					<option value=""><strong>{lang debate_recommend_list}</strong></option>
					<option value="">------------------------------</option>
					<!--{loop $candidates $candidate}-->
						<option value="$candidate[username]"{if $candidate[username] == $debate[bestdebater]} selected="selected"{/if}>$candidate[username] ( $candidate[voters] {lang debate_poll}, <!--{if $candidate[stand] == 1}-->{lang debate_square}<!--{elseif $candidate[stand] == 2}-->{lang debate_opponent}<!--{/if}-->)</option>
					<!--{/loop}-->
				</select>
				<p><input type="text" name="bestdebater" id="bestdebater" class="px" value="$debate[bestdebater]" size="20" /></p>
				<p class="d">{lang debate_list_nonexistence}</p>
			</div>
			<div class="jsbl_cpgd cl">
				<div class="cpgd_btys">{lang debate_umpirepoint}</div>
				<textarea id="umpirepoint" name="umpirepoint" class="pt">$debate[umpirepoint]</textarea>
			</div>
		</table><!--Fro m www.xhkj5.com-->
	
	<div class="jsbl_jsan cl">
		<button class="pn" type="submit" name="umpiresubmit" value="true" class="submit"><span>{lang submit}</span></button>
	</div>
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
	<!--{/if}-->
}
</script>
<!--{/if}-->
<!--{template common/footer}-->