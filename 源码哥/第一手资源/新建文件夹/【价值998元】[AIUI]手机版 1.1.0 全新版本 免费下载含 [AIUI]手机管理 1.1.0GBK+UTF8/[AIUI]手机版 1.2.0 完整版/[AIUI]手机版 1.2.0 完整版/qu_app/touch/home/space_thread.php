<?PHP exit('QQÈº£º550494646');?>
<!--{template common/header}-->
<!--{if $space[uid] == $_G[uid]}-->
<!-- header start -->
<header class="header">
    <div class="nav">
        <a href="javascript:;" onclick="history.go(-1)" class="z"><i class="iconfont icon-back"></i></a>
        <span class="category"><span class="name">{lang mythread}</span></span>
    </div>
</header>
<!-- header end -->
<div class="ainuo_usertb cl">
    <ul class="tb amyth cl">
        <li {if $viewtype != 'reply'}class="a"{/if}><a href="home.php?mod=space&do=thread&view=me&type=thread&uid=$space[uid]&from=space">{lang topic}</a></li>
        <li {if $viewtype == 'reply'}class="a"{/if}><a href="home.php?mod=space&do=thread&view=me&type=reply&uid=$space[uid]&from=space">{lang reply}</a></li>
    </ul>
</div>
<div class="grey_line cl"></div>

<!--{else}-->
<!--{subtemplate common/usertop}-->
<!--{subtemplate common/usernav}-->
<div class="ainuo_usertb cl">
<!--{/if}--> 


<div class="ainuo_userthreadlist">
	
	<ul>
	<!--{if $list}-->
		<!--{loop $list $thread}-->
			<li>
            	<!--{if $viewtype == 'reply' || $viewtype == 'postcomment'}-->
                    <a href="forum.php?mod=redirect&goto=findpost&ptid=$thread[tid]&pid=$thread[pid]">
                <!--{else}-->
                    <a href="forum.php?mod=viewthread&tid=$thread[tid]">
                <!--{/if}-->
                	<div class="atit cl">
                    <!--{if in_array($thread['displayorder'], array(1, 2, 3, 4))}-->
                        <span class="ding">$alang_ding</span>
                    <!--{/if}-->
                    <!--{if $thread['digest'] > 0}-->
                        <span class="jing">$alang_jing</span>
                    <!--{/if}-->
                    <!--{if $thread[folder] == 'lock'}-->
                    <!--{elseif $thread['special'] == 1}-->
                        <span>{lang thread_poll}</span>
                    <!--{elseif $thread['special'] == 2}-->
                        <span>{lang thread_trade}</span>
                    <!--{elseif $thread['special'] == 3}-->
                        <span>{lang thread_reward}</span>
                    <!--{elseif $thread['special'] == 4}-->
                        <span>{lang thread_activity}</span>
                    <!--{elseif $thread['special'] == 5}-->
                        <span>{lang thread_debate}</span>
                    <!--{/if}-->
                    $thread[subject]
                    </div cl>
                    <p>
                        <span class="date">$forums[$thread[fid]] / $thread[dateline]</span>
                        <span class="num">{$thread[replies]} $alang_reply</span>
                        <span class="num">{$thread[views]} $alang_view</span>
                    </p>
                </a>
			</li>
		<!--{/loop}-->
	<!--{else}-->
        <div class="emp"><i class="iconfont icon-meiyougengduole"></i><p>{lang no_related_posts}</div>
	<!--{/if}-->
	</ul>
	<!--{if $multi}--><div class="pgs cl">$multi</div><!--{/if}-->
</div>
<!-- main threadlist end -->
<!--{subtemplate common/userbottom}-->
<!--{template common/footer}-->
