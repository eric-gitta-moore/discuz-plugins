<?PHP exit('QQÈº£º550494646');?>
<div id="postmessage_$post[pid]" class="postmessage">$post[message]</div>

<script type="text/javascript">
<!--{if $optiontype=='checkbox'}-->
	var max_obj = $maxchoices;
	var p = 0;
<!--{/if}-->
</script>

<div class="ainuo_vpoll cl">
<form id="poll" name="poll" method="post" autocomplete="off" action="forum.php?mod=misc&action=votepoll&fid=$_G[fid]&tid=$_G[tid]&pollsubmit=yes{if $_GET[from]}&from=$_GET[from]{/if}&quickforward=yes" onsubmit="if($('post_$post[pid]')) {ajaxpost('poll', 'post_$post[pid]', 'post_$post[pid]');return false}">
	<input type="hidden" name="formhash" value="{FORMHASH}" />
	<div class="pinf">
		<!--{if $multiple}-->
        	<strong>{lang poll_multiple}{lang thread_poll}</strong>
            <!--{if $maxchoices}--><font style="font-size:12px;">({lang poll_more_than})</font><!--{/if}-->
        <!--{else}-->
        	<strong>{lang poll_single}{lang thread_poll}</strong>
		<!--{/if}-->
		<em>{lang poll_voterscount}</em>
        <!--{if $visiblepoll && $_G['group']['allowvote']}--><p style="color:#f60;font-size:12px;">{lang poll_after_result}</p><!--{/if}-->
	</div>

	<!--{hook/viewthread_poll_top}-->

	<!--{if $_G[forum_thread][remaintime]}-->
	<p class="ptmr">
		{lang poll_count_down}:
		<strong>
		<!--{if $_G[forum_thread][remaintime][0]}-->$_G[forum_thread][remaintime][0] {lang days}<!--{/if}-->
		<!--{if $_G[forum_thread][remaintime][1]}-->$_G[forum_thread][remaintime][1] {lang poll_hour}<!--{/if}-->
		$_G[forum_thread][remaintime][2] {lang poll_minute}
		</strong>
	</p>
	<!--{elseif $expiration && $expirations < TIMESTAMP}-->
	<p class="ptmr"><strong>{lang poll_end}</strong></p>
	<!--{/if}-->

	<div class="pcht">

		<table summary="poll panel" cellspacing="0" cellpadding="0" width="100%">
			<!--{if $isimagepoll}-->
				<!--{eval $i = 0;}-->
				<tr>
					<!--{loop $polloptions $key $option}-->
					<!--{eval $i++;}-->
					<!--{eval $imginfo=$option['imginfo'];}-->
					
					<td valign="bottom" id="polloption_$option[polloptionid]" width="100%" class="3">
						<div class="polltd cl">
                        	<div class="pollimgl">
                                <!--{if $imginfo}-->
                                <a href="javascript:;" title="$imginfo[filename]" >
                                    <img id="aimg_$imginfo[aid]" aid="$imginfo[aid]" src="$imginfo[big]" onclick="zoom(this, this.getAttribute('zoomfile'), 0, 0, '{$_G[setting][showexif]}')" zoomfile="$imginfo[big]" alt="$imginfo[filename]" title="$imginfo[filename]" w="$imginfo[width]" />
                                </a>
                                <!--{else}-->
                                <a href="javascript:;" title=""><img src="{IMGDIR}/nophoto.gif" width="130px" /></a>
                                <!--{/if}-->
                            </div>
                            <div class="pollimgr">
                                <p>
                                    <!--{if $_G['group']['allowvote']}-->
                                        <label><input class="pr" type="$optiontype" id="option_$key" name="pollanswers[]" value="$option[polloptionid]" {if $_G['forum_thread']['is_archived']}disabled="disabled"{/if} {if $optiontype=='checkbox'}onclick="poll_checkbox(this)"{else}onclick="$('pollsubmit').disabled = false"{/if} /></label>
                                    <!--{/if}-->
                                    $option[polloption]
                                </p>
                                <!--{if !$visiblepoll}-->
                                <div class="imgf imgf2">
                                    <span class="jdt" style="width: $option[width]; background-color:#$option[color]">&nbsp;</span>
                                    
                                </div>
                                <p class="imgfc">
                                        <span class="z">$option[votes]{lang debate_poll}</span>
                                        <span class="y">{$option[percent]}% </span>
                                    </p>
                                <!--{/if}-->
                            </div>
						</div>
					</td>
					<!--{if $key % 1 == 0 && isset($polloptions[$key])}--></tr><tr><!--{/if}-->
					<!--{/loop}-->
					<!--{if ($imgpad = $key % 1) > 0}--><!--{echo str_repeat('<td width="100%"></td>', 4 - $imgpad);}--><!--{/if}-->
				</tr>
			
			<!--{else}-->
				<!--{loop $polloptions $key $option}-->
					<tr{if $visiblepoll} class="ptl"{/if}>
						<!--{if $_G['group']['allowvote']}-->
							<td class="pslt"><input class="pr" type="$optiontype" id="option_$key" name="pollanswers[]" value="$option[polloptionid]" {if $_G['forum_thread']['is_archived']}disabled="disabled"{/if} {if $optiontype=='checkbox'}onclick="poll_checkbox(this)"{else}onclick="$('pollsubmit').disabled = false"{/if} /></td>
						<!--{/if}-->
						<td class="pvt" colspan="2">
							<label for="option_$key">$key. $option[polloption]</label>
						</td>
					</tr>
	
					<!--{if !$visiblepoll}-->
						<tr>
							<!--{if $_G['group']['allowvote']}-->
								<td class="pslt">&nbsp;</td>
							<!--{/if}-->
							<td {if $_G['group']['allowvote']}width="55%"{else}width="68%"{/if}>
								<div class="pbg">
									<div class="pbr" style="width: $option[width]; background-color:#$option[color]"></div>
								</div>
							</td>
							<td class="pollper">$option[percent]% <em style="color:#$option[color]">($option[votes])</em></td>
						</tr>
					<!--{/if}-->
				<!--{/loop}-->
			
			<!--{/if}-->
			<tr>
				<!--{if $_G['group']['allowvote']}-->
                	<!--{if $isimagepoll}-->
                    <!--{else}-->
                    	<td class="selector">&nbsp;</td>
                    <!--{/if}-->
                <!--{/if}-->
				<td colspan="{if $isimagepoll}{else}2{/if}" class="allow" style="padding:10px">
					<!--{hook/viewthread_poll_bottom}-->
					<!--{if $_G['group']['allowvote'] && !$_G['forum_thread']['is_archived']}-->
						<button class="pn formdialog" type="submit" name="pollsubmit" id="pollsubmit" value="true"{if $post['invisible'] < 0} disabled="disabled"{/if}><span>{lang submit}</span></button>
						
					<!--{elseif !$allwvoteusergroup}-->
						{lang poll_msg_allwvoteusergroup}
					<!--{elseif !$allowvotepolled}-->
						{lang poll_msg_allowvotepolled}
					<!--{elseif !$allowvotethread}-->
						{lang poll_msg_allowvotethread}
					<!--{/if}-->
				</td>
			</tr>
		</table>
        <!--{if $overt}-->
        <div class="polltips cl">
			({lang poll_msg_overt})
		</div>
        <!--{/if}-->
	</div>
</form>
</div>