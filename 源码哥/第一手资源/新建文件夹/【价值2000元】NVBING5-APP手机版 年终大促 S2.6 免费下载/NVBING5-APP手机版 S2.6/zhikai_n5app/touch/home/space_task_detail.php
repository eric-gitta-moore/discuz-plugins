<?php exit;?>
<script src="static/js/common.js" type="text/javascript"></script>
<div class="n5rw_rwnr cl">
	<div class="rwnr_rwzt cl">
		<div class="n5rw_rwtb"><img src="$task[icon]"></div>
		<div class="n5rw_rwxx">
			<p class="n5rw_rwbt">$task[name]
				<!--{if $task['reward'] == 'credit'}-->
					<span class="n5rw_rwrq">{lang credits} $_G['setting']['extcredits'][$task[prize]][title] $task[bonus] $_G['setting']['extcredits'][$task[prize]][unit]</span>
				<!--{elseif $task['reward'] == 'magic'}-->
					<span class="n5rw_rwrq">{lang magics_title} $listdata[$task[prize]] $task[bonus] {lang magics_unit}</span>
				<!--{elseif $task['reward'] == 'medal'}-->
					<span class="n5rw_rwrq">{lang medals} $listdata[$task[prize]] <!--{if $task['bonus']}-->{lang expire} $task[bonus] {lang days}</span><!--{/if}-->
				<!--{elseif $task['reward'] == 'invite'}-->
					<span class="n5rw_rwrq">{lang invite_code} $task[prize] {lang expire} $task[bonus] {lang days}</span>
				<!--{elseif $task['reward'] == 'group'}-->
					<span class="n5rw_rwrq">{lang usergroup} $listdata[$task[prize]] <!--{if $task['bonus']}--> $task[bonus] {lang days}</span><!--{/if}-->
				<!--{/if}-->
			</p>
			<p class="n5rw_rwjs">$task[description]</p>
		</div>
	</div>
	
	
	<div class="rwnr_rwjs cl">
		<div class="rwjs_wctj cl">
			<!--{if $task['viewmessage']}-->
				$task[viewmessage]
			<!--{else}-->
						<th class="bbda">{lang task_complete_condition}</th>
						<td class="bbda">
						<!--{if $taskvars['complete']}-->
							<ul>
								<!--{loop $taskvars['complete'] $taskvar}-->
									<li>$taskvar[name] : $taskvar[value]</li>
								<!--{/loop}-->
							</ul>
						<!--{else}-->
							<p>{lang unlimited}</p>
						<!--{/if}-->
						</td>
					<!--{/if}-->
		</div>			
						<th class="bbda">{lang task_apply_condition}</th>
						<td class="bbda">
							<!--{if $task[applyperm] || $task[relatedtaskid] || $task[tasklimits] || $taskvars['apply']}-->
								<ul>
									<li><!--{if $task[grouprequired]}-->{lang usergroup}: $task[grouprequired] <!--{elseif $task['applyperm'] == 'member'}-->{lang task_general_users}<!--{elseif $task['applyperm'] == 'admin'}-->{lang task_admins}<!--{/if}--></li>
									<!--{if $task[relatedtaskid]}--><li>{lang task_relatedtask}: <a href="home.php?mod=task&do=view&id=$task[relatedtaskid]">$_G['taskrequired']</a></li><!--{/if}-->
									<!--{if $task[tasklimits]}--><li>{lang task_numlimit}: $task[tasklimits]</li><!--{/if}-->
									<!--{if $taskvars['apply']}-->
										<!--{loop $taskvars['apply'] $taskvar}-->
											<li>$taskvar[name]: $taskvar[value]</li>
										<!--{/loop}-->
									<!--{/if}-->
								</ul>
							<!--{else}-->
								<p>{lang unlimited}</p>
							<!--{/if}-->
						</td>
					</tr>
    </div>
				
    <div class="rwnr_sqjd cl">
		<!--{if $allowapply == '-1'}-->
			<div class="n5rw_wcjd cl">
				<div class="n5rw_jdys cl">
					<span class="n5rw_jdxs cl" style="width: {if $task[csc]}$task[csc]%{else}8px{/if}">&nbsp;</span>
					<p class="n5rw_tpsj cl">{lang task_complete} $task[csc]%</p>
				</div>
			</div>
			<p>
				<a href="home.php?mod=task&do=draw&id=$task[taskid]" class="formdialog"><img src="{STATICURL}image/task/{if $task[csc] >=100}reward.gif{else}rewardless.gif{/if}" /></a>
				<!--{if $task[csc] < 100}--><a href="home.php?mod=task&do=delete&id=$task[taskid]"><img src="{STATICURL}image/task/cancel.gif" alt="{lang task_quit}" /></a><!--{/if}-->
			</p>
		<!--{elseif $allowapply == '-2'}-->
			<p class="xg2 mbn">{lang task_group_nopermission}</p>
			<a href="javascript:;" onclick="doane(event);showDialog('{lang task_group_nopermission}')"><img src="{STATICURL}image/task/disallow.gif" title="{lang task_group_nopermission}" alt="{lang task_group_nopermission}" /></a>
		<!--{elseif $allowapply == '-3'}-->
			<p class="xg2 mbn">{lang task_applies_full}</p>
			<a href="javascript:;" onclick="doane(event);showDialog('{lang task_applies_full}')"><img src="{STATICURL}image/task/disallow.gif" title="{lang task_applies_full}" alt="{lang task_applies_full}" /></a>
		<!--{elseif $allowapply == '-4'}-->
			<p class="xg2 mbn">{lang task_lose_on}$task[dateline]</p>
		<!--{elseif $allowapply == '-5'}-->
			<p class="xg2 mbn">{lang task_complete_on}$task[dateline]</p>
		<!--{elseif $allowapply == '-6'}-->
			<p class="xg2 mbn">{lang task_complete_on}$task[dateline] &nbsp; {$task[t]}{lang task_applyagain}</p>
			<a href="javascript:;" onclick="doane(event);showDialog('{$task[t]}{lang task_applyagain}')"><img src="{STATICURL}image/task/disallow.gif" title="{$task[t]}{lang task_applyagain}" alt="{lang task_applies_full}" /></a>
		<!--{elseif $allowapply == '-7'}-->
			<p class="xg2 mbn">{lang task_lose_on}$task[dateline] &nbsp; {$task[t]}{lang task_reapply}</p>
			<a href="javascript:;" onclick="doane(event);showDialog('{$task[t]}{lang task_reapply}')"><img src="{STATICURL}image/task/disallow.gif" title="{$task[t]}{lang task_reapply}" alt="{lang task_applies_full}" /></a>
		<!--{elseif $allowapply == '2'}-->
			<p class="xg2 mbn">{lang task_complete_on}$task[dateline] &nbsp; {lang task_applyagain_now}</p>
		<!--{elseif $allowapply == '3'}-->
			<p class="xg2 mbn">{lang task_lose_on}$task[dateline] &nbsp; {lang task_reapply_now}</p>
		<!--{/if}-->
		<!--{if $allowapply > '0'}-->
			<a href="home.php?mod=task&do=apply&id=$task[taskid]"><img src="{STATICURL}image/task/apply.gif" alt="{lang task_newbie_apply}" /></a>
		<!--{/if}-->
	</div>
	<!--{if $task[applicants]}-->
		<a name="parter"></a>
		<div class="rwnr_cyhy cl">
			<div class="cyhy_sjtj cl">{lang task_applicants}</div>
			<div id="ajaxparter"></div>
		</div>
		<script type="text/javascript">ajaxget('home.php?mod=task&do=parter&id=$task[taskid]', 'ajaxparter');</script>
	<!--{/if}-->
</div>