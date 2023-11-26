<?PHP exit('QQÈº£º550494646');?>
<div class="ainuo_type cl">
	<div class="aleft cl">
    	<a href="forum.php?mod=forumdisplay&fid=$_G[fid]" class="{if $_GET['filter'] == ''} current{/if}">$alang_all</a>
        <a href="forum.php?mod=forumdisplay&fid=$_G[fid]&filter=author&orderby=dateline" class="{if $_GET['filter'] == 'author'} current{/if}">$alang_newthread</a>
        <a href="forum.php?mod=forumdisplay&fid=$_G[fid]&filter=heat&orderby=heats$forumdisplayadd[heat]{if $_GET['archiveid']}&archiveid={$_GET['archiveid']}{/if}" class="{if $_GET['filter'] == 'heat'} current{/if}">$alang_hot</a>
    </div>
    <div class="aright cl">
    	<a href="javascript:;" class="afilter"><i class="iconfont icon-filter"></i></a>
    	<!--{if $subexists}-->
    	<a href="javascript:;" class="asubforum">$alang_subforum<i class="iconfont icon-unfold"></i></a>
        <!--{/if}-->
    </div>
</div>
<div class="grey_line cl"></div>
<!--{template forum/forumdisplay_subforum}-->
<!--{template forum/sort}-->

