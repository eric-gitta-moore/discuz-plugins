<?PHP exit('QQÈº£º550494646');?> 
<!--{if $_GET['from'] != 'preview' && !empty($post['ratelog'])}-->
<div class="av_pingfen cl">
    <span class="canyu"><a href="forum.php?mod=misc&action=rate&tid=$_G[tid]&pid=$post[pid]" class="dialog"><!--{echo count($postlist[$post[pid]][totalrate]);}-->$alang_canyu</a></span>
    <div class="y">
    <!--{loop $post['ratelogextcredits'] $id $score}-->
        <!--{if $score > 0}-->
            <span class="xi1">/{$_G['setting']['extcredits'][$id][title]}+$score</span>
        <!--{/if}-->
    <!--{/loop}-->
    </div>
</div>
<!--{/if}-->


	<!--{if $_GET['from'] != 'preview' && !empty($post['ratelog'])}-->
		<dl id="ratelog_$post[pid]" class="avrate">
				<div id="post_rate_$post[pid]"></div>
                <dd>
				<!--{if $_G['setting']['ratelogon']}-->
					<table width="100%">
						<tbody>
							<!--{loop $post['ratelog'] $uid $ratelog}-->
							<tr id="rate_{$post[pid]}_{$uid}">
								<th>
									<a href="home.php?mod=space&uid=$uid"><!--{echo avatar($uid, 'small');}--></a>
								</th>
                                <td>
                                <a href="home.php?mod=space&uid=$uid">$ratelog[username]</a>
                                {if $post['ratelogextcredits']}
                                <span>(
								<!--{loop $post['ratelogextcredits'] $id $score}-->
									<!--{if $ratelog['score'][$id] > 0}-->
										 {$_G['setting']['extcredits'][$id][title]}+$ratelog[score][$id]
									<!--{/if}-->
								<!--{/loop}-->
                                )</span>
                                {/if}
                                <p>$ratelog[reason]</p>
                                </td>
							</tr>
							<!--{/loop}-->
						</tbody>
					</table>
					<p class="ratc">
						<a href="forum.php?mod=misc&action=viewratings&tid=$_G[tid]&pid=$post[pid]">+{lang rate_view}</a>
					</p>
				<!--{/if}-->
			</dd>
		</dl>
	<!--{else}-->
		<div id="post_rate_div_$post[pid]"></div>
	<!--{/if}-->