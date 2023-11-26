<?PHP exit('QQÈº£º550494646');?>

<!--{template common/header}-->
<!--{if $space[uid] == $_G[uid]}-->
    <header class="header">
        <div class="nav">
            <a href="javascript:;" onclick="history.go(-1)" class="z back"><i class="iconfont icon-back"></i></a>
            <span class="category"><span class="name">{lang doing}</span>
            </span>
        </div>
    </header>
	<div class="ainuo_usertb cl">
        <ul class="tb ado cl">
        	<li$actives[me]><a href="home.php?mod=space&do=$do&view=me">{lang doing_view_me}</a></li>
            <li$actives[we]><a href="home.php?mod=space&do=$do&view=we">{lang me_friend_doing}</a></li>
			<li$actives[all]><a href="home.php?mod=space&do=$do&view=all">{lang view_all}</a></li>
        </ul>
    </div>
    <div class="grey_line cl"></div>
	<div class="ainuo_udoing cl">
    
<!--{else}-->
<!--{subtemplate common/usertop}-->
<!--{subtemplate common/usernav}-->
<div class="ainuo_udoing cl">
<!--{/if}--> 
    
			<div class="cl">
            	<div class="cl">
            		<div class="cl">
		

		
		<!--{if $searchkey}-->
			<div class="dashedtip">{lang doing_search_record} <span style="color: red; font-weight: 700;">$searchkey</span> {lang doing_record_list}</div>
		<!--{/if}-->
		
		<!--{if $dolist}-->
			<div class="doing_list cl">
			<!--{loop $dolist $dv}-->
			<!--{eval $doid = $dv[doid];}-->
			<!--{eval $_GET[key] = $key = random(8);}-->
				<li id="{$key}dl{$doid}" class="lione cl">
					<div class="avt cl"><a href="home.php?mod=space&uid=$dv[uid]"><!--{avatar($dv[uid],middle)}--></a></div>
					<div class="ainfo cl">
                    	<div class="atime cl">$dv[username]<span><!--{date($dv['dateline'], 'u')}--></span></div>
                        <div class="amsg cl">$dv[message] <!--{if $dv[status] == 1}--> <span>({lang moderate_need})</span><!--{/if}--></div> 
                        <!--{eval $list = $clist[$doid];}-->
                        <div class="brm" id="{$key}_$doid"{if empty($list) || !$showdoinglist[$doid]} style="display:none;"{/if}>
                            <span id="{$key}_form_{$doid}_0"></span>
                            <!--{template home/space_doing_li}-->
                        </div>
                        {if $_G[uid]}
                        <div class="caozuo cl">
                            <!--{if helper_access::check_module('doing')}-->
                            <a ainuoto="home.php?mod=spacecp&ac=doing&op=comment&doid=$doid&id=$id" class="ainuodialog">{lang reply}</a>
                            <!--{/if}-->
                            <!--{if $dv[uid]==$_G[uid]}-->
                            	<a ainuoto="home.php?mod=spacecp&ac=doing&op=delete&doid=$doid&id=$dv[id]&handlekey=doinghk_{$doid}_$dv[id]" id="{$key}_doing_delete_{$doid}_{$dv[id]}" class="ainuodialog">{lang delete}</a>
                            <!--{/if}-->
                        </div>
                        {/if}
					</div>
					
					
				</li>
			<!--{/loop}-->
			<!--{if $pricount}-->
				<p class="mtm">{lang hide_doing}</p>
			<!--{/if}-->
			</div>
			<!--{if $multi}-->
			<div class="pgs cl mtm">$multi</div>
			<!--{elseif $_GET[highlight]}-->
			<div class="pgs cl mtm"><div class="pg"><a href="home.php?mod=space&do=doing&view=me">{lang viewmore}</a></div></div>
			<!--{/if}-->
		<!--{else}-->
        	<div class="emp"><i class="iconfont icon-meiyougengduole"></i><p>{lang doing_no_replay}<!--{if $space[self]}-->{lang doing_now}<!--{/if}--></p></div>
		<!--{/if}-->

		<!--{if $diymode}-->
					</div>
				</div>
		<!--{/if}-->
		</div>
	</div>
 <!--{if helper_access::check_module('doing') && ($space[uid] == $_G[uid])}-->
<div class="cl" style="height:68px; width:100%"></div>
<div class="ainuo_viewdoing_bottom cl">
    <!--{template home/space_doing_form}-->
</div>
<!--{/if}-->
<!--{subtemplate common/showface}-->
<script>
$('.ainuo_nologin').on('click', function() {
	<!--{if !$_G[uid]}-->
		popup.open('{lang nologin_tip}', 'confirm', 'member.php?mod=logging&action=login');
		return false;
	<!--{/if}-->
});
</script>
<!--{subtemplate common/userbottom}-->
<!--{template common/footer}-->
