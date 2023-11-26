<?PHP exit('QQÈº£º550494646');?>
<!--{eval $_G['home_tpl_titles'] = array($album['albumname'], '{lang album}');}-->
<!--{eval $friendsname = array(1 => '{lang friendname_1}',2 => '{lang friendname_2}',3 => '{lang friendname_3}',4 => '{lang friendname_4}');}-->
<!--{template common/header}-->

<header class="header">
    <div class="nav">
    	<!--{if $space[self] && helper_access::check_module('album')}-->
			<a href="home.php?mod=spacecp&ac=upload" class="y" style="margin-right:30px;"><i class="iconfont icon-cameraadd"></i></a>
		<!--{/if}-->
		<a ainuoto="home.php?mod=spacecp&ac=favorite&type=album&id=$album[albumid]&spaceuid=$space[uid]&handlekey=sharealbumhk_{$album[albumid]}" id="a_favorite" class="ainuo_nologin ainuodialog y"><i class="iconfont icon-favor"></i></a>	
        <a href="javascript:;" onclick="history.go(-1)" class="z"><i class="iconfont icon-back"></i></a>
        <span class="name"><!--{if $space[self]}-->{$alang_view}{lang album}<!--{else}-->{$alang_view}{$space[username]}{$alang_de}{lang album}<!--{/if}--></span>
    </div>
</header>
<div class="ainuo_album_view cl">
	<div class="cl">
    	<div class="cl">
        	<div class="cl">
	
		
		<div class="dashedtip cl">
			
			<div class="y">
				<!--{if $space[self]}--><a href="{if $album[albumid] > 0}home.php?mod=spacecp&ac=album&op=edit&albumid=$album[albumid]{else}home.php?mod=spacecp&ac=album&op=editpic&albumid=0{/if}">{lang edit}</a><!--{/if}-->
				<!--{if ($_G[uid] == $album[uid] || checkperm('managealbum')) && $album[albumid] > 0}-->
					<span class="pipe">|</span><a ainuoto="home.php?mod=spacecp&ac=album&op=delete&albumid=$album[albumid]&uid=$album[uid]&handlekey=delalbumhk_{$album[albumid]}" id="album_delete_$album[albumid]" class="ainuodialog">{lang delete}</a>
				<!--{/if}-->
			</div>
			<!--{if $album['catname']}-->
			<span class="xg1">{lang system_cat}</span><a href="home.php?mod=space&do=album&catid=$album[catid]&view=all">$album[catname]</a><span class="pipe">|</span>
			<!--{/if}-->
			<!--{if $album[picnum]}-->{lang total} $album[picnum] {lang album_pics}<!--{/if}-->
			<!--{if $album['friend']}-->
			<span class="xg1"> &nbsp; {$friendsname[$value[friend]]}</span>
			<!--{/if}-->
		</div>
		
		<!--{if $list}-->
			<!--{if $album[depict]}--><div class="adepict">$album[depict]</div><!--{/if}-->
            <div class="piclist">
                <div class="picfall">
                    <!--{loop $list $key $value}-->
                    <div class="pin">
                        <a href="home.php?mod=space&uid=$value[uid]&do=$do&picid=$value[picid]"><!--{if $value[pic]}--><img class="ainuolazyload" data-original="$value[pic]" alt="" /><!--{/if}--></a><!--{if $value[status] == 1}--><p>{lang moderate_need}</p><!--{/if}-->
                    </div>
                    <!--{/loop}-->
                </div>
            </div>
			<!--{if $pricount}--><p>{lang hide_pic}</p><!--{/if}-->
			<!--{if $multi}--><div class="pgs cl mtm">$multi</div><!--{/if}-->
		<!--{else}-->
			<!--{if !$pricount}--><p class="emp">{lang no_pics}</p><!--{/if}-->
			<!--{if $pricount}--><p>{lang hide_pic}</p><!--{/if}-->
		<!--{/if}-->

		

					</div>
				</div>
		</div>
	</div>



	



<!--{template common/footer}-->