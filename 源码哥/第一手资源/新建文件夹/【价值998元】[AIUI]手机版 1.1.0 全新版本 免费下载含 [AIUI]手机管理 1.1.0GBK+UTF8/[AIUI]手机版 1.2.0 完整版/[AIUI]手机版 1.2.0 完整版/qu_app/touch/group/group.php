<?PHP exit('QQÈº£º550494646');?>
<!--{template common/header}-->
<!--{if $_G['inajax'] == 1}-->
<!--{template group/group_list}-->
<!--{else}-->
<header class="header">
    <div class="nav">
        <a href="javascript:;" onclick="history.go(-1)" class="z"><i class="iconfont icon-back"></i></a>
        <span class="name">
            <!--{if $action != 'create'}-->$_G[forum][name]<!--{else}-->{lang group_create_new}<!--{/if}-->
        </span><!--From www.mo q u8 .com -->
        <!--{if $action != 'create'}-->
        <!--{if $_G['uid']}-->
            <!--{eval $favid = DB::result_first('SELECT count(*) FROM '.DB::table('home_favorite').' WHERE id='.$_G[forum][fid].' and uid='.$_G[uid].'');}-->
        <!--{else}-->
            <!--{eval $favid = 0;}-->
        <!--{/if}-->
        <a href="forum.php?mod=post&action=newthread&fid=$_G[fid]" class="y ainuo_nologin"><i class="iconfont icon-post"></i></a>
        <a href="home.php?mod=spacecp&ac=favorite&type=group&id={$_G[forum][fid]}&handlekey=sharealbumhk_{$_G[forum][fid]}&formhash={FORMHASH}" class="y fav">{if $favid}<i class="iconfont icon-favorfill"></i>{else}<i class="iconfont icon-favor"></i>{/if}</a>
        <!--{/if}-->
    </div>
</header>
<!--{template common/top_fix}-->

	<div class="ainuo_group">
		<div class="cl">
			<!--{if $action != 'create'}-->
					
                	<div class="list_top" {if $_G['forum']['banner']} style="background:url($_G[forum][banner]) no-repeat; background-size:cover;"{else}style="background:url(template/qu_app/touch/style/css/images/group_bg.png) no-repeat; background-size:cover;"{/if}>
                    <div class="acover_black"></div>
                    <div {if $_G['forum']['banner']}class="list_topcon new"{else}class="list_topcon"{/if}>
                    	<img src="$_G[forum][icon]" alt="$_G[forum][name]" width="48" height="48" />
                        <h2>$_G[forum][name]</h2>
                        <p>
                        	{lang credits}: $_G[forum][commoncredits]<span>|</span>{lang group_moderator_title}: <!--{eval $i = 1;}--><!--{loop $groupmanagers $manage}--><!--{if $i <= 0}-->, <!--{/if}--><!--{eval $i--;}-->$manage[username] <!--{/loop}-->
                        </p>
                        <!--{if helper_access::check_module('group') && $status != 'isgroupuser'}-->
							<a ainuoto="forum.php?mod=group&action=join&fid=$_G[fid]" class="ainuo_nologin jiaru ainuodialog">{lang group_join_group}</a>
                        <!--{/if}-->
                        <!--{if $status == 'isgroupuser'}-->
                        	<a ainuoto="forum.php?mod=group&action=out&fid=$_G[fid]" class="yijiaru ainuodialog">{lang group_exit}</a>
						<!--{/if}-->
                    </div>
                    </div>

				<!--{if $status != 2 && $status != 3}-->
			  <div {if $_G['forum']['ismoderator']}class="tb"{else}class="tb tb_mod"{/if}>
					<ul id="groupnav">
						<li {if ($action != 'memberlist') && ($action != 'invite') && ($action != 'manage')}class="a"{/if}><a href="forum.php?mod=forumdisplay&action=list&fid=$_G[fid]" title="">{lang group_discuss_area}</a></li>
						<li {if $action == 'memberlist' || $action == 'invite'}class="a"{/if}><a href="forum.php?mod=group&action=memberlist&fid=$_G[fid]" title="">{lang group_member_list}</a></li>
						<!--{if $_G['forum']['ismoderator']}--><li {if $action == 'manage'}class="a"{/if}><a href="forum.php?mod=group&action=manage&fid=$_G[fid]">{lang group_admin}</a></li><!--{/if}-->
						<!--{if CURMODULE == 'group'}--><!--{hook/group_nav_extra}--><!--{else}--><!--{hook/forumdisplay_nav_extra}--><!--{/if}-->
					</ul>
				</div>
                <div class="grey_line cl"></div>
				<!--{/if}-->
			<!--{/if}-->

			<!--{if $action == 'index' && $status != 2 && $status != 3}-->
				<!--{template group/group_index}-->
			<!--{elseif $action == 'list'}-->
            <div id="athreadlist" style="position: relative;">
    			<div class="g_threadlist cl">
        			<ul id="ainuoloadmore" class="ainuoloadmore">
            			<form method="post" autocomplete="off" name="moderate" id="moderate" action="forum.php?mod=topicadmin&action=moderate&fid=$_G[fid]&infloat=yes&nopost=yes">
                			<input type="hidden" name="formhash" value="{FORMHASH}" />
                			<input type="hidden" name="listextra" value="$extra" />
                    		<!--{if $_G['forum_threadcount']}-->
								<!--{template group/group_list}-->
							<!--{else}-->
                        		<div class="emp cl"><i class="iconfont icon-meiyougengduole"></i><p>{lang forum_nothreads}</p></div>
                    		<!--{/if}-->
            			</form>
        			</ul>
    			</div>
			</div>
            <div id="ainuoloadempty"></div>
            <!--{if $_G[forum][threads] && ($_G[forum][threads] > $_G[tpp])}-->
            <div id="loading" class="loading G-animate-load-wrap">
                <div class="load-loading"><span class="loading02"></span> <span class="load-word">$alang_loading</span></div>
            </div>
            <!--{/if}-->

			<!--{elseif $action == 'memberlist'}-->
				<!--{template group/group_memberlist}-->
			<!--{elseif $action == 'create'}-->
				<!--{template group/group_create}-->
			<!--{elseif $action == 'invite'}-->
				<!--{template group/group_invite}-->
			<!--{elseif $action == 'manage'}-->
				<!--{template group/group_manage}-->
			<!--{/if}-->
		</div>
		
	</div>
    
{if $_GET[action] == 'list'}
<script>
	var ainuo_forum_html = '';
	var ainuo_forum_empty = '<div class="inner">$alang_nomore</div>';
	var ainuo_forum_emptyfail = '<div class="inner">$alang_loadfail</div>';				
	var ainuo_forum_loading = false;
	var ainuo_forum_aperpage = '$_G[tpp]';
	var ainuo_forum_ainuomaxpage = $maxpage;
	var ainuo_forum_url = 'forum.php?mod=forumdisplay&fid={$_G[fid]}&action=list&page=';
</script>
{/if}
<script>
$('.fav').on('click', function() {
	popup.open('<div class="ainuooverlay"><div class="preloader-indicator-overlay"></div><div class="preloader-indicator-modal"><span class="preloader preloader-white"></span></div></div>');
	<!--{if !$_G[uid]}-->
		popup.open('{lang nologin_tip}', 'confirm', 'member.php?mod=logging&action=login');
		return false;
	<!--{/if}-->
	var obj = $(this);
	$.ajax({
		type:'POST',
		url:obj.attr('href') + '&handlekey=favbtn&inajax=1',
		data:{'favoritesubmit':'true', 'formhash':'{FORMHASH}'},
		dataType:'xml',
	})
	.success(function(s) {
		popup.open(s.lastChild.firstChild.nodeValue);
		evalscript(s.lastChild.firstChild.nodeValue);
	})
	.error(function() {
		window.location.href = obj.attr('href');
		popup.close();
	});
	return false;
});
$('.ainuo_nologin').on('click', function() {
	<!--{if !$_G[uid]}-->
		popup.open('{lang nologin_tip}', 'confirm', 'member.php?mod=logging&action=login');
		return false;
	<!--{/if}-->
});
</script>

<!--{/if}-->
<!--{template common/footer}-->