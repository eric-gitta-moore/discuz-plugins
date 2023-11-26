<?PHP exit('QQÈº£º550494646');?>
<style>.ainuo_vtitle{ display:none;}</style>
<div class="ainuo_rwd_top cl">
    <div class="{if $_G['forum_thread']['price'] > 0}ainuo_rwd{elseif $_G['forum_thread']['price'] < 0}ainuo_rwd ainuo_rwld{/if} cl" >
        <div class="{if $_G['forum_thread']['price'] > 0}rusld{elseif $_G['forum_thread']['price'] < 0}rsld{/if}">
            <cite>$rewardprice</cite>{$_G['setting']['extcredits'][$_G['setting']['creditstransextra'][2]][title]}
        </div>
        <div class="rwdn">
            <div class="rwt cl">
                <div class="tit cl">
                    $_G[forum_thread][subject]
                </div>
                <div class="info cl">
                    <span>$_G[forum_thread][views] $alang_view</span><span>$_G[forum_thread][allreplies] $alang_huida</span>
                </div>
                    
            </div>
        </div>
    </div>
    <!--{if $_G['forum_thread']['price'] > 0 && !$_G['forum_thread']['is_archived']}--><!--From www.moq u8 .com -->
        
        {if $_G[uid]}
		<a href="javascript:;" class="ainuo_anwbtn fastcon_a">{lang reward_answer}</a>
        {else}
        <a href="javascript:;" class="ainuo_anwbtn ainuo_nologin">{lang reward_answer}</a>
        {/if}
    <!--{/if}-->
</div>

<!--{if $bestpost}-->
	<div class="ainuo_rwdbst cl">
		<h3 class="psth">{lang reward_bestanswer}<a href="forum.php?mod=redirect&goto=findpost&ptid=$bestpost[tid]&pid=$bestpost[pid]" class="full">{lang view_full_content}>></a></h3>
		<div class="pstl">
			<div class="psta">
            	<a href="home.php?mod=space&uid={$comment[authorid]}&do=profile">$bestpost[avatar]</a>
                <a href="home.php?mod=space&uid={$bestpost[authorid]}&do=profile">$bestpost[author]</a>
                
            </div>
			<div class="psti">
				<div class="con">$bestpost[message]</div>
			</div>
		</div>
	</div>
<!--{/if}-->

<div id="postmessage_$post[pid]">$post[message]</div>
<!--{if $post['attachment']}-->
	<div class="locked">{lang attachment}: <em><!--{if $_G['uid']}-->{lang attach_nopermission}<!--{elseif $_G['connectguest']}-->{lang attach_nopermission_connect_fill_profile}<!--{else}-->{lang attach_nopermission_login}<!--{/if}--></em></div>
<!--{elseif $post['imagelist'] || $post['attachlist']}-->
	<div class="pattl">
		<!--{if $post['imagelist']}-->
			 <!--{echo showattach($post, 1)}-->
		<!--{/if}-->
		<!--{if $post['attachlist']}-->
			 <!--{echo showattach($post)}-->
		<!--{/if}-->
	</div>
<!--{/if}-->
<!--{eval $post['attachment'] = $post['imagelist'] = $post['attachlist'] = '';}-->

<script type="text/javascript">
	$('.ainuo_anwbtn').on('click', function() {
		<!--{if !$_G[uid]}-->
			popup.open('{lang nologin_tip}', 'confirm', 'member.php?mod=logging&action=login');
			return false;
		<!--{/if}-->
	});
</script>

