<?php exit;?>
<!--{if $debate[umpire]}-->
<!--{if $debate['umpirepoint']}-->
	<div class="n5sq_ztts n5sq_blhs cl">
		<p class="blhs_hsfd">
			<!--{if $debate[winner]}-->
			<!--{if $debate[winner] == 1}-->
			<label><strong>{lang debate_square}{lang debate_winner}</strong></label>
			<!--{elseif $debate[winner] == 2}-->
			<label><strong>{lang debate_opponent}{lang debate_winner}</strong></label>
			<!--{else}-->
			<label><strong>{lang debate_draw}</strong></label>
			<!--{/if}-->
			<!--{/if}-->
		</p>
		<p><strong>{lang debate_comment_dateline}</strong>: $debate[endtime]</p>
		<!--{if $debate[umpirepoint]}--><p><strong>{lang debate_umpirepoint}</strong>: $debate[umpirepoint]</p><!--{/if}-->
		<!--{if $debate[bestdebater]}--><p><strong>{lang debate_bestdebater}</strong>: $debate[bestdebater]</p><!--{/if}-->
	</div><!--From w ww.xhkj5.com-->
<!--{/if}-->
<!--{/if}-->
<div id="postmessage_$post[pid]" class="postmessage">$post[message]</div>
<div class="n5sq_blbf cl">
	<div class="blbf_zfbf cl">
		<div class="z cl">{$n5app['lang']['sqbianlunzf']} {echo $debate[affirmvoteswidth]}%</div>
		<div class="y cl">{echo $debate[negavoteswidth]}% {$n5app['lang']['sqbianlunff']}</div>
	</div>
	<div class="blbf_zfjd cl">
		<div class="z cl"><div style="height: 15px;width: {echo $debate[affirmvoteswidth]}%;background:#fcad30;border-radius: 15px;">&nbsp;</div></div>
		<div class="y cl"><div style="height: 15px;width: {echo $debate[negavoteswidth]}%;background:#41c2fc;border-radius: 15px;">&nbsp;</div></div>
	</div>
	<div class="n5sq_blgd cl">
		<div class="blgd_sfgd z cl"><div class="sfgd_gdys">{lang debate_square_point}<i>{lang debater}:$debate[affirmdebaters]</i></div><div class="sfgd_gdnr">$debate[affirmpoint]</div></div>
		<div class="blgd_sfgd y cl"><div class="sfgd_gdys">{lang debate_opponent_point}<i>{lang debater}:$debate[negadebaters]</i></div><div class="sfgd_gdnr">$debate[negapoint]</div></div>
	</div>
	<div class="n5sq_blzc cl">
		<!--{if !$_G['forum_thread']['is_archived']}--><a href="forum.php?mod=misc&action=debatevote&tid=$_G[tid]&stand=1" id="affirmbutton" class="z {if $_G['uid']}dialog{/if} cl" >{lang debate_support}{$n5app['lang']['sqbianlunzf']} $debate[affirmvotes]</a><!--{/if}-->
		<a href="forum.php?mod=misc&action=debatevote&tid=$_G[tid]&stand=2" id="negabutton" class="y {if $_G['uid']}dialog{/if} cl">{lang debate_support}{$n5app['lang']['sqbianlunff']} $debate[negavotes]</a>
	</div>
	<div class="n5sq_bljs cl">
		<!--{if $debate[endtime]}--><p>{lang endtime}: $debate[endtime] <!--{if $debate[umpire]}-->{lang debate_umpire}: $debate[umpire]<!--{/if}--></p><!--{/if}-->
		<!--{if $debate[umpire] && $_G['username'] && $debate[umpire] == $_G['member']['username']}-->
		<!--{if $debate[remaintime] && !$debate[umpirepoint]}-->
			<a href="forum.php?mod=misc&action=debateumpire&tid=$_G[tid]&pid=$post[pid]{if $_GET[from]}&from=$_GET[from]{/if}" class="{if $_G['uid']}dialog{/if}" >{lang debate_umpire_end}</a>
		<!--{elseif TIMESTAMP - $debate['dbendtime'] < 3600}-->
			<a href="forum.php?mod=misc&action=debateumpire&tid=$_G[tid]&pid=$post[pid]{if $_GET[from]}&from=$_GET[from]{/if}" class="{if $_G['uid']}dialog{/if}" >{lang debate_umpirepoint_edit}</a>
		<!--{/if}-->
		<!--{/if}-->
	</div>
</div>