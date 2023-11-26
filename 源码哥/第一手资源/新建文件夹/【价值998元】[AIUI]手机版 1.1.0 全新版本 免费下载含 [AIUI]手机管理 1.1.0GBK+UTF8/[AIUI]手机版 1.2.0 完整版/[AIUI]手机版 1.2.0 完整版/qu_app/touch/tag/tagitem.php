<?PHP exit('QQÈº£º550494646');?>
<!--{template common/header}-->

<!-- header start -->
    <div class="header">
        <div class="nav">
            <a href="javascript:;" onclick="history.go(-1)" class="z"><i class="iconfont icon-back"></i></a>
			<span class="name">{lang tag}: $tagname</span>
           
        </div>
    </div>
<!-- header end --><!--From www.moq u8 .com -->
<!--{template common/top_fix}-->

<div class="ainuo_reltag cl">
	<div class="ainuo_usertb cl" style="background:#fff;">
        <ul class="tb arel cl">
        	<li {if $_GET[xx] != 'blog'}class="a"{/if}><a href="misc.php?mod=tag&id=$id">{lang related_thread}</a></li>
            <li {if $_GET[xx] == 'blog'}class="a"{/if}><a href="misc.php?mod=tag&id=$id&xx=blog">{lang related_blog}</a></li>
        </ul>
    </div>
    <div class="grey_line"></div>
<!--{if $_GET[xx] != 'blog'}-->
	<!--{if empty($showtype) || $showtype == 'thread'}-->
		<div class="threadlist cl">
			<ul class="cl">
				<!--{if $threadlist}-->
						<!--{loop $threadlist $thread}-->
							<li id="$thread[id]">
                                <a href="forum.php?mod=viewthread&tid=$thread[tid]&extra=$extra" class="normal">
                                <p $thread[highlight] class="tit cl">
                                    <!--{if $thread['digest'] > 0}-->
                                        <span class="jing">$alang_jing</span>
                                    <!--{/if}-->
                                    <!--{if $thread['special'] == 1}-->
                                        <span class="leixing">{lang thread_poll}</span>
                                    <!--{elseif $thread['special'] == 2}-->
                                        <span class="leixing">{lang thread_trade}</span>
                                    <!--{elseif $thread['special'] == 4}-->
                                        <!--{if $astarttimeto}-->
                                            <!--{if $astarttimeto < $anowtime}-->
                                            <span class="leixing" style="background:#999;">$alang_over</span>
                                            <!--{else}-->
                                            <span class="leixing">$alang_start</span>
                                            <!--{/if}-->
                                        <!--{else}-->
                                            <!--{if $astarttimefrom < $anowtime}-->
                                            <span class="leixing" style="background:#999;">$alang_over</span>
                                            <!--{else}-->
                                            <span class="leixing">$alang_start</span>
                                            <!--{/if}-->
                                        <!--{/if}-->
                                    <!--{elseif $thread['special'] == 5}-->
                                        <span class="leixing">{lang thread_debate}</span>
                                    <!--{/if}-->
                                    <!--{if $thread['price'] > 0}-->
                                        <!--{if $thread['special'] == '3'}-->
                                        <span class="leixing">$alang_xuanshang</span>
                                        <!--{else}-->
                                        <span class="leixing">$alang_xuanshang</span>
                                        <!--{/if}-->
                                    <!--{elseif $thread['special'] == '3' && $thread['price'] < 0}-->
                                        <span class="leixing" style="background:#829803;">{lang reward_solved}</span>
                                    <!--{/if}-->
                                    {$thread[subject]}
                                    <!--{if $thread['price'] > 0}-->
                                    <span class="price">$thread[price]</span>
                                    <!--{/if}-->
                                    
                                    <!--{if $_G['forum_thread']['recommendlevel']}-->
                                        <span class="recommend">{lang thread_recommend} $_G['forum_thread'][recommends]</span>
                                    <!--{/if}-->
                                    <!--{if $_G['forum_thread'][heatlevel]}-->
                                        <span class="heats">{lang hot_thread}</span>
                                    <!--{/if}-->
                                </p>
                                <!--{hook/forumdisplay_mobile_pic $key}-->
                                <!--{hook/forumdisplay_mobile_summary $key}-->
                                <!--{if $thread['special'] == 4}-->
                                <p class="activity cl">
                                    <!--{if $aplace}--><span><em>$alang_address : </em>$aplace</span><!--{/if}-->
                                    <!--{if $aplace}--><span><em>$alang_type : </em>$aclass</span><!--{/if}-->
                                    <!--{if $astarttimefrom}--><span><em>$alang_time : </em>{echo dgmdate($astarttimefrom)}<!--{if $astarttimeto}--> - {echo dgmdate($astarttimeto)}<!--{/if}--></span><!--{/if}-->
                                </p>
                                <!--{else}-->
                                <p class="auth cl">
                                    <!--{avatar($thread[authorid], 'small')}-->
                                    <span {if $groupcolor[$thread[authorid]]} style="color: $groupcolor[$thread[authorid]];"{/if}>$thread[author]</span>
                                    <span>&nbsp;/&nbsp;<i class="iconfont icon-time"></i>$thread[dateline]</span>
                                    <em><i class="iconfont icon-reply"></i>{$thread[replies]}</em><em><i class="iconfont icon-view"></i>$thread[views]</em>
                                </p>
                                <!--{/if}-->
                                </a>
                            </li>
						<!--{/loop}-->
					<!--{if empty($showtype)}-->
						<div class="tagmore cl"><a href="misc.php?mod=tag&id=$id&type=thread">{lang more}...</a></div>
					<!--{else}-->
						<!--{if $multipage}--><div class="pgs mtm cl">$multipage</div><!--{/if}-->
					<!--{/if}-->
				<!--{else}-->
                    <div class="emp"><i class="iconfont icon-meiyougengduole"></i><p>{lang no_content}</p></div>
				<!--{/if}-->
			</ul>
		</div>
	<!--{/if}-->
<!--{/if}-->

<!--{if $_GET[xx] == 'blog'}-->
	<!--{if helper_access::check_module('blog') && (empty($showtype) || $showtype == 'blog')}-->
		<div class="ainuo_tag_blog cl">
			<div class="cl">
				<!--{if $bloglist}-->
					<ul class="cl">
						<!--{loop $bloglist $blog}-->
							<li class="cl">
								<div class="avt"><a href="home.php?mod=space&uid=$blog[uid]"><!--{avatar($blog[uid],middle)}--></a></div>
                                <div class="avtr cl">
                                    <h2>
                                        <!--{if $blog['hot']}--><span class="hot">{lang hot} <em>$blog[hot]</em> </span><!--{/if}--><a href="home.php?mod=space&uid=$blog[uid]&do=blog&id=$blog[blogid]" target="_blank">$blog['subject']</a>
                                    </h2>
                                    <div class="info cl">
                                        <a href="home.php?mod=space&uid=$blog[uid]">$blog[username]</a> <span class="y">$blog[dateline]</span>
                                    </div>
                                    <div class="meg cl" id="blog_article_$blog[blogid]">
                                        <!--{if $blog[pic]}-->
                                        	<div class="atc"><a href="home.php?mod=space&uid=$blog[uid]&do=blog&id=$blog[blogid]"><img src="$blog[pic]" alt="$blog[subject]" /></a></div>
                                        <!--{/if}-->
                                        {eval $amsg = cutstr($blog[message],150)}
                                        $amsg
                                    </div>
                                    <div class="bot cl">
                                        <!--{if $blog[classname]}--><a href="home.php?mod=space&uid=$blog[uid]&do=blog&classid=$blog[classid]&view=me">#{$blog[classname]}#</a><!--{/if}-->
                                        <!--{if $blog[viewnum]}--><a href="home.php?mod=space&uid=$blog[uid]&do=blog&id=$blog[blogid]" style="margin-left:10px;" class="y">$blog[viewnum] {lang blog_read}</a><!--{/if}-->
                                        <a href="home.php?mod=space&uid=$blog[uid]&do=blog&id=$blog[blogid]#comment" class="y"><span id="replynum_$blog[blogid]">$blog[replynum]</span> {lang blog_replay}</a>
                                    </div>
                                </div>
							</li>
						<!--{/loop}-->
					</ul>
					<!--{if empty($showtype)}-->
						<div class="tagmore cl"><a href="misc.php?mod=tag&id=$id&type=blog&xx=blog">{lang more}...</a></div>
					<!--{else}-->
						<!--{if $multipage}--><div class="pgs mtm cl">$multipage</div><!--{/if}-->
					<!--{/if}-->
				<!--{else}-->
                    <div class="emp"><i class="iconfont icon-meiyougengduole"></i><p>{lang no_content}</p></div>
				<!--{/if}-->
			</div>
		</div>
	<!--{/if}-->
</div>
<!--{/if}-->

<!--{template common/footer}-->