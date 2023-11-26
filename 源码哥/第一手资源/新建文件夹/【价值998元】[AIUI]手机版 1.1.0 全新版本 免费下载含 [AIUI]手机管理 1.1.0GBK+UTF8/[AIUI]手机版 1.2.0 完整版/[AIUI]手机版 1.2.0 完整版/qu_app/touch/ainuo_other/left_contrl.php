<?PHP exit('QQÈº£º550494646');?>
<div id="menu-mask" class="mm-menu-mask"></div>
<div id="mm-menu" class="mm-menu">
	<!--{if $_G['uid']}-->
    <div class="left_afterlogin cl">
    	<a href="{$_G['siteurl']}home.php?mod=space&uid={$_G[uid]}&do=profile&mycenter=1"><!--{avatar($_G[uid], 'middle')}-->{if $_G[member][newprompt] || $_G[member][newpm]}<em></em>{/if}$_G['username']</a>
    </div>
    <!--{else}-->
    <div class="left_beforelogin cl">
    	<a href="{$_G['siteurl']}member.php?mod=logging&action=login"><!--{avatar(0, 'middle')}-->$alang_loginfirst</a>
    </div>
    <!--{/if}--><!--From w ww.mo qu8 .com -->
    <!--{hook/global_misign_mobile}-->
    <div class="ainuoleft_nav cl">
        <!--{if $leftnav}-->
        <div class="cl">
            <ul>
                <!--{loop $leftnav $navlist}-->
                <!--{if $navlist[disable]}-->
                <li><a href="$navlist[url]"><i class="iconfont icon-{$navlist[pic]}" style="color:{$navlist[color]}"></i>$navlist[title]</a></li>
                <!--{/if}-->
                <!--{/loop}-->
            </ul>
        </div>
        <!--{/if}-->
    </div>
</div>