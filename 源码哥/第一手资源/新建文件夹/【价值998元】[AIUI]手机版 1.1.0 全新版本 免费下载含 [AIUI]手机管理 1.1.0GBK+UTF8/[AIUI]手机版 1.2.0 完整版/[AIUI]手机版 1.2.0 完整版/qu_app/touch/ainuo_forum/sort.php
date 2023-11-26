<?PHP exit('QQÈº£º550494646');?>
<div id="f_sortcon" class="f_sortcon cl" style="display:none;">
	<div class="cl">

        <div class="sort_sort cl">
            <div class="sort_desc cl">
                <div class="bm_h">$alang_shaixuan</div>
                <div class="sort_con">
                <ul>
                    <li><a href="forum.php?mod=forumdisplay&fid=$_G[fid]{if $_GET['archiveid']}&archiveid={$_GET['archiveid']}{/if}" {if $_GET['specialtype'] == ''}class="a"{/if}>{lang all}</a></li>
                    <!--{if $showpoll}--><li><a href="forum.php?mod=forumdisplay&fid=$_G[fid]&filter=specialtype&specialtype=poll$forumdisplayadd[specialtype]{if $_GET['archiveid']}&archiveid={$_GET['archiveid']}{/if}" {if $_GET['specialtype'] == 'poll'}class="a"{/if}>{lang thread_poll}</a></li><!--{/if}--><!--From w ww.ymg6 .com -->
                    <!--{if $showtrade}--><li><a href="forum.php?mod=forumdisplay&fid=$_G[fid]&filter=specialtype&specialtype=trade$forumdisplayadd[specialtype]{if $_GET['archiveid']}&archiveid={$_GET['archiveid']}{/if}" {if $_GET['specialtype'] == 'trade'}class="a"{/if}>{lang thread_trade}</a></li><!--{/if}--><!--From w ww.ymg6 .com -->
                    <!--{if $showreward}--><li><a href="forum.php?mod=forumdisplay&fid=$_G[fid]&filter=specialtype&specialtype=reward$forumdisplayadd[specialtype]{if $_GET['archiveid']}&archiveid={$_GET['archiveid']}{/if}" {if $_GET['specialtype'] == 'reward'}class="a"{/if}>{lang thread_reward}</a></li><!--{/if}-->
                    <!--{if $showactivity}--><li><a href="forum.php?mod=forumdisplay&fid=$_G[fid]&filter=specialtype&specialtype=activity$forumdisplayadd[specialtype]{if $_GET['archiveid']}&archiveid={$_GET['archiveid']}{/if}" {if $_GET['specialtype'] == 'activity'}class="a"{/if}>{lang thread_activity}</a></li><!--{/if}-->
                    <!--{if $showdebate}--><li><a href="forum.php?mod=forumdisplay&fid=$_G[fid]&filter=specialtype&specialtype=debate$forumdisplayadd[specialtype]{if $_GET['archiveid']}&archiveid={$_GET['archiveid']}{/if}" {if $_GET['specialtype'] == 'debate'}class="a"{/if}>{lang thread_debate}</a></li><!--{/if}--><!--From w ww.m oqu8 .com -->
                    <li><a href="forum.php?mod=forumdisplay&fid=$_G[fid]&filter=lastpost&orderby=lastpost$forumdisplayadd[lastpost]{if $_GET['archiveid']}&archiveid={$_GET['archiveid']}{/if}" class="{if $_GET['filter'] == 'lastpost'} a{/if}">{lang latest}</a></li>
                    <li><a href="forum.php?mod=forumdisplay&fid=$_G[fid]&filter=heat&orderby=heats$forumdisplayadd[heat]{if $_GET['archiveid']}&archiveid={$_GET['archiveid']}{/if}" class="{if $_GET['filter'] == 'heat'} a{/if}">{lang order_heats}</a></li>
                    <li><a href="forum.php?mod=forumdisplay&fid=$_G[fid]&filter=hot" class="{if $_GET['filter'] == 'hot'} a{/if}">{lang hot_thread}</a></li>
                    <li><a href="forum.php?mod=forumdisplay&fid=$_G[fid]&filter=digest&digest=1$forumdisplayadd[digest]{if $_GET['archiveid']}&archiveid={$_GET['archiveid']}{/if}" class="{if $_GET['filter'] == 'digest'} a{/if}">{lang digest_posts}</a></li>
                    </ul>
                </div>
            </div>
        
            <!--{if $showreward && $_GET['specialtype'] == 'reward'}-->
            <div class="sort_desc cl">
                <div class="bm_h">{lang thread_reward}</div>
                <div class="sort_con">
                <ul>
                    <li><a href="forum.php?mod=forumdisplay&fid=$_G[fid]&filter=specialtype&specialtype=reward$forumdisplayadd[specialtype]{if $_GET['archiveid']}&archiveid={$_GET['archiveid']}{/if}" {if $_GET['rewardtype'] == ''}class="a"{/if}>{lang all_reward}</a></li>
                    <!--{if $showpoll}--><li><a href="forum.php?mod=forumdisplay&fid=$_G[fid]&filter=specialtype&specialtype=reward$forumdisplayadd[specialtype]{if $_GET['archiveid']}&archiveid={$_GET['archiveid']}{/if}&rewardtype=1" {if $_GET['rewardtype'] == '1'}class="a"{/if}>{lang rewarding}</a></li><!--{/if}-->
                    <!--{if $showtrade}--><li><a href="forum.php?mod=forumdisplay&fid=$_G[fid]&filter=specialtype&specialtype=reward$forumdisplayadd[specialtype]{if $_GET['archiveid']}&archiveid={$_GET['archiveid']}{/if}&rewardtype=2" {if $_GET['rewardtype'] == '2'}class="a"{/if}>{lang reward_solved}</a></li><!--{/if}-->
                </ul>
                </div>
            </div>
            <!--{/if}-->
            <!--{if ($_G['forum']['threadtypes'] && $_G['forum']['threadtypes']['listable']) || count($_G['forum']['threadsorts']['types']) > 0}-->
            <div class="sort_desc cl">
                <div class="bm_h">{lang types}</div>
                <div class="sort_con">
                <ul>
                    <li><a href="forum.php?mod=forumdisplay&fid=$_G[fid]{if $_G['forum']['threadsorts']['defaultshow']}&filter=sortall&sortall=1{/if}{if $_GET['archiveid']}&archiveid={$_GET['archiveid']}{/if}" {if !$_GET['typeid'] && !$_GET['sortid']}class="a"{/if}>{lang all}</a></li>
                    <!--{if $_G['forum']['threadtypes']}-->
                        <!--{loop $_G['forum']['threadtypes']['types'] $id $name}-->
                            <!--{if $_GET['typeid'] == $id}-->
                            <li><a href="forum.php?mod=forumdisplay&fid=$_G[fid]{if $_GET['sortid']}&filter=sortid&sortid=$_GET['sortid']{/if}{if $_GET['archiveid']}&archiveid={$_GET['archiveid']}{/if}" class="a">$name</a></li>
                            <!--{else}-->
                            <li><a href="forum.php?mod=forumdisplay&fid=$_G[fid]&filter=typeid&typeid=$id$forumdisplayadd[typeid]{if $_GET['archiveid']}&archiveid={$_GET['archiveid']}{/if}">$name</a></li>
                            <!--{/if}-->
                        <!--{/loop}-->
                    <!--{/if}-->
                
                    <!--{if $_G['forum']['threadsorts']}-->
                        <!--{loop $_G['forum']['threadsorts']['types'] $id $name}-->
                            <!--{if $_GET['sortid'] == $id}-->
                            <li><a href="forum.php?mod=forumdisplay&fid=$_G[fid]{if $_GET['typeid']}&filter=typeid&typeid=$_GET['typeid']{/if}{if $_GET['archiveid']}&archiveid={$_GET['archiveid']}{/if}" class="a">$name</a></li>
                            <!--{else}-->
                            <li><a href="forum.php?mod=forumdisplay&fid=$_G[fid]&filter=sortid&sortid=$id$forumdisplayadd[sortid]{if $_GET['archiveid']}&archiveid={$_GET['archiveid']}{/if}">$name</a></li>
                            <!--{/if}-->
                        <!--{/loop}-->
                    <!--{/if}-->
                </ul>
                </div>
            </div>
            <!--{/if}-->
            <div id="sort_close"><i class="iconfont icon-close"></i></div>
        </div>
	</div>
</div>



    