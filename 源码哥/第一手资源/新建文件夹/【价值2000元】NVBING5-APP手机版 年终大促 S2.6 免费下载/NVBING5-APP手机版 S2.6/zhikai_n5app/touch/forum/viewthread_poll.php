<?php exit;?>
<div id="postmessage_$post[pid]" class="postmessage">$post[message]</div>
<div class="n5sq_tpzt cl">
<form id="poll" name="poll" method="post" autocomplete="off" action="forum.php?mod=misc&action=votepoll&fid=$_G[fid]&tid=$_G[tid]&pollsubmit=yes{if $_GET[from]}&from=$_GET[from]{/if}&quickforward=yes&mobile=2" >
	<input type="hidden" name="formhash" value="{FORMHASH}" />
	<div class="tpzt_btys cl">
		<div class="tpbt_dbt"><!--{if $multiple}-->{lang poll_multiple}{lang thread_poll}<!--{if $maxchoices}--><i>{lang poll_more_than}</i><!--{/if}--><!--{else}-->{lang poll_single}{lang thread_poll}<!--{/if}--></div>
		<div class="tpbt_xbt">
			<!--{if $visiblepoll && $_G['group']['allowvote']}--><i>{lang poll_after_result}</i><!--{/if}-->
			<i>{lang poll_voterscount}</i>
			<!--{if $_G[forum_thread][remaintime]}--><p><i>{lang poll_count_down}<!--{if $_G[forum_thread][remaintime][0]}-->$_G[forum_thread][remaintime][0] {lang days}<!--{/if}--><!--{if $_G[forum_thread][remaintime][1]}-->$_G[forum_thread][remaintime][1] {lang poll_hour}<!--{/if}-->$_G[forum_thread][remaintime][2] {lang poll_minute}</i><p>
			<!--{elseif $expiration && $expirations < TIMESTAMP}--><p><i>{lang poll_end}</i><p><!--{/if}-->
		</div>
	</div>
	<div class="tpzt_tpsj cl">
		<!--{loop $polloptions $key $option}-->
		<!--{eval $i++;}-->
		<!--{eval $imginfo=$option['imginfo'];}-->
		<div class="tpsj_tpxh cl">
			<!--{if $imginfo}-->
				<div class="tpsj_tptp cl"><img id="aimg_$imginfo[aid]" aid="$imginfo[aid]" src="$imginfo[small]" onclick="zoom(this, this.getAttribute('zoomfile'), 0, 0, '{$_G[setting][showexif]}')" zoomfile="$imginfo[big]" alt="$imginfo[filename]" title="$imginfo[filename]" w="$imginfo[width]" /></div>
			<!--{/if}-->
			<div class="tpsj_tpxz cl">
			<!--{if $_G['group']['allowvote']}-->
				<input type="$optiontype" id="option_$key" name="pollanswers[]" value="$option[polloptionid]" {if $_G['forum_thread']['is_archived']}disabled="disabled"{/if}  />
			<!--{/if}-->
				<label for="option_$key">$key.$option[polloption]</label>
			</div>
			<div class="tpsj_tpjd cl">
				<span class="tpjd_jdxs cl" style="width: $option[percent]%; background-color:#$option[color]">&nbsp;</span>
				<p class="tpjd_tpsj cl">
					<span class="z">$option[votes]{$n5app['lang']['sqtoupiaodw']}</span>
					<span class="y">$option[percent]%</span>
				</p>
			</div>
		</div>
		<!--{/loop}-->
	</div>
	<div class="tpzt_ants cl">	
        <!--{if $_G['group']['allowvote'] && !$_G['forum_thread']['is_archived']}-->
            <input type="submit" name="pollsubmit" id="pollsubmit" value="{lang submit}" class="pn" />
            <!--{if $overt}-->
                <div class="n5sq_ztts cl">{lang poll_msg_overt}</div>
            <!--{/if}-->
        <!--{elseif !$allwvoteusergroup}-->
            <!--{if !$_G['uid']}-->
            <div class="n5sq_ztts cl">{lang poll_msg_allwvote_user}</div>
            <!--{else}-->
            <div class="n5sq_ztts cl">{lang poll_msg_allwvoteusergroup}</div>
            <!--{/if}-->
        <!--{elseif !$allowvotepolled}-->
           <div class="n5sq_ztts cl">{lang poll_msg_allowvotepolled}</div>
        <!--{elseif !$allowvotethread}-->
            <div class="n5sq_ztts cl">{lang poll_msg_allowvotethread}</div>
        <!--{/if}-->
	</div>
</form>
</div>