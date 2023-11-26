<?php exit;?>
	<!--{if $tasklist}-->
	<div class="n5rw_rwlb cl">
		<ul>
			<!--{loop $tasklist $task}-->
				<li>
				<a href="home.php?mod=task&do=view&id=$task[taskid]" class="n5rw_ztlj">
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
						<!--{if $_GET['item'] == 'doing'}-->
						<div class="n5rw_wcjd cl">
							<div class="n5rw_jdys cl">
								<span class="n5rw_jdxs cl" style="width: {if $task[csc]}$task[csc]%{else}8px{/if}">&nbsp;</span>
								<p class="n5rw_tpsj cl">{lang task_complete} $task[csc]%</p>
							</div>
						</div>
						<!--{/if}-->
					</div>
				</a>
				</li>
			<!--{/loop}-->
		</ul>
	</div>
	<!--{else}-->
		<div class="n5qj_wnr">
			<img src="template/zhikai_n5app/images/n5sq_gzts.png">
			<p><!--{if $_GET['item'] == 'new'}-->{lang task_nonew}<!--{elseif $_GET['item'] == 'doing'}-->{lang task_nodoing}<!--{else}-->{lang data_nonexistence}<!--{/if}--></p>
		</div>
	<!--{/if}-->