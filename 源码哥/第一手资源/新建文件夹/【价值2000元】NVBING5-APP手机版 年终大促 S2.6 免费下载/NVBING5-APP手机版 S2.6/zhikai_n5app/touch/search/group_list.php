<?php exit;?>
<!--{if empty($grouplist)}-->
	<div class="n5qj_wnr">
		<img src="template/zhikai_n5app/images/n5sq_gzts.png">
		<p>{$n5app['lang']['ssghgjcss']}</p>
	</div>
<!--{else}-->
	<div class="n5ht_tjht cl">
		<div class="tjht_tjlb cl">
			<ul>
			<!--{loop $grouplist $group}-->
				<li>
					<a href="forum.php?mod=group&fid=$group[fid]">
					<span class="tjlb_httb"><img src="$group[icon]"></span>
					<p class="tjlb_tjbt">$group[name]</p>
					<p class="tjlb_tjjs">{lang member}:$group[membernum] {lang threads}:$group[threads] {lang creating_time}:$group[dateline]</p>
					</a>
				</li>
			<!--{/loop}-->
			</ul>
		</div>
	</div>
	<!--{if !empty($multipage)}-->$multipage<!--{/if}-->
<!--{/if}-->
