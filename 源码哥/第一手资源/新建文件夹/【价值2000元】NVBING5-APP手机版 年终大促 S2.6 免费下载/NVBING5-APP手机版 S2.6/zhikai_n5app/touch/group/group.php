<?php exit;?>
<!--{template common/header}-->
<!--{eval if(!function_exists('init_n5app'))include DISCUZ_ROOT.'./source/plugin/zhikai_n5appgl/common.php'; if(!function_exists('init_n5app')) exit('Authorization error!');}-->
<!--{eval include_once DISCUZ_ROOT.'./source/plugin/zhikai_n5appgl/nvbing5.php'}-->
			<!--{if $action != 'create'}-->
				<!--{eval include_once DISCUZ_ROOT.'./source/plugin/zhikai_n5appgl/nvbing5_groupsc.php'}-->
					<style type="text/css">
						.bg {padding-top: 0;}
						.large,.nbg {background: none;}
						.small {background: rgba(0, 0, 0, 0.5);}
						.n5qj_tbys span {font-size: 0px;}
						.small span {font-size: 17px;}
					</style>
					<div class="n5qj_tbys nbg cl">
						<a href="{if $action == 'list'}group.php{else}javascript:history.back();{/if}" class="n5qj_zcan"><div class="zcanfh">{$n5app['lang']['qjfanhui']}</div></a>
						<a id="a" href="javascript:void(0)" class="n5qj_ycan kjgdcz n5sq_xlcf" onclick="n5sq_xlkzList(this)"></a>
						<div class="n5sq_xlcd" id="dropdown-a">
							<ul>
								<li><a href="group.php"><i class="iconfont icon-n5appqz"></i>{$n5app['lang']['qunzu']}</a></li>
								<li><a href="forum.php?mod=forumdisplay&action=invite&fid={$_G[forum][fid]}" class="dialog"><i class="iconfont icon-n5appxlewm"></i>{$n5app['lang']['sssswzqz']}{$n5app['lang']['sqnrfxgnewm']}</a></li>
								<li><a href="search.php?mod=group&mobile=2"><i class="iconfont icon-n5appxlss"></i>{$n5app['lang']['qzszyybswqz']}</a></li>
							</ul>
						</div>
						<span>$_G[forum][name]</span>
					</div><!--Fro m www.xhkj5.com-->
					<script>
function n5sq_xlkzList(o) {
    hideList("n5sq_xlcd" + o.id);
    document.getElementById("dropdown-" + o.id).classList.toggle("n5sq_xlkz");
}
function hideList(option) {
    var dropdowns = document.getElementsByClassName("n5sq_xlcd");
    for (var i = 0; i < dropdowns.length; i++) {
        var openDropdown = dropdowns[i];
        if (openDropdown.id != option) {
            if (openDropdown.classList.contains('n5sq_xlkz')) {
                openDropdown.classList.remove('n5sq_xlkz');
            }
        }
    }
}
window.onclick = function(e) {
    if (!e.target.matches('.n5sq_xlcf')) {
        hideList("");
    }
}
</script>
					<div class="n5ht_yttb cl" style="background-image:url(<!--{if $_G['forum']['banner']}-->$_G[forum][banner]<!--{else}-->template/zhikai_n5app/images/htbg.jpg<!--{/if}-->) !important;background-repeat:no-repeat;background-position:center;background-size:cover !important;">
						<div class="yttb_tbxx cl">
							<div class="yttb_tbtb"><img src="$_G[forum][icon]" alt="$_G[forum][name]"/></div>
							<h2>$_G[forum][name]</h2>$_G[forum][leveltitle]
							<p class="yttb_htxx">{lang posts}$_G[forum][posts]<i>/</i>{lang member}$_G[forum][membernum]<i>/</i>{lang group_member_rank}$groupcache[ranking][data][today]<i>/</i>{lang credits}$_G[forum][commoncredits]</p>
							<button type="button" class="yttb_jran <!--{if $status == 'isgroupuser'}-->yttb_tcan <!--{/if}-->{if $_G[uid]}dialog{else}n5app_wdlts{/if}" href="<!--{if $status == 'isgroupuser'}-->forum.php?mod=group&action=out&fid=$_G[fid]<!--{else}-->forum.php?mod=group&action=join&fid=$_G[fid]<!--{/if}-->"><!--{if $status == 'isgroupuser'}-->{$n5app['lang']['wdhtnrjryq']}<!--{else}-->{$n5app['lang']['wdhtnrjrht']}<!--{/if}--></button>
							{if checkFavGroup($_G['fid'])}
								<button type="button" class="yttb_jran yttb_scht" href="home.php?mod=space&do=favorite&type=group&mobile=2">{$n5app['lang']['qzsjscbkbl']}</button>
							{else}
								<button type="button" class="yttb_jran yttb_scht {if $_G[uid]}dialog{else}n5app_wdlts{/if}" href="home.php?mod=spacecp&ac=favorite&type=group&id={$_G[forum][fid]}&handlekey=sharealbumhk_{$_G[forum][fid]}&formhash={FORMHASH}">{$n5app['lang']['sqnrdbscnr']}</button>
							{/if}
						</div>
						<div class="n5jj_hdhd">
							<div class="n5jj_hdhd_1"></div>
							<div class="n5jj_hdhd_2"></div>
						</div>
					</div>
				<!--{if $status != 2 && $status != 3}-->
					<style type="text/css">
						.ztfl_fllb {width: 100%;} 
						.ztfl_fllb ul li {<!--{if $_G['forum']['ismoderator']}-->width: 33.33%;<!--{else}-->width: 50%;<!--{/if}-->padding: 0;}
					</style>
					<div class="n5sq_ztfl">
						<div class="ztfl_flzt">
							<div class="ztfl_fllb">
								<ul id="n5sq_glpd">
									<li {if $action == 'list'}class="a"{/if}><a href="forum.php?mod=forumdisplay&action=list&fid=$_G[fid]#groupnav">{$n5app['lang']['qunzu']}</a></li>
									<li {if $action == 'memberlist' || $action == 'invite'}class="a"{/if}><a href="forum.php?mod=group&action=memberlist&fid=$_G[fid]#groupnav">{$n5app['lang']['qbhtcybl']}</a></li>
									<!--{if $_G['forum']['ismoderator']}--><li {if $action == 'manage'}class="a"{/if}><a href="forum.php?mod=group&action=manage&fid=$_G[fid]#groupnav">{$n5app['lang']['qzszyybftcqz']}</a></li><!--{/if}-->
								</ul>
							</div>
						</div>
					</div>
				<!--{/if}-->
			<!--{/if}-->

			<!--{if $action == 'index' && $status != 2 && $status != 3}-->
				<!--{template group/group_index}-->
			<!--{elseif $action == 'list'}-->
				<!--{template group/group_list}-->
			<!--{elseif $action == 'memberlist'}-->
				<!--{template group/group_memberlist}-->
			<!--{elseif $action == 'create'}-->
				<!--{template group/group_create}-->
			<!--{elseif $action == 'invite'}-->
				<!--{template group/group_invite}-->
			<!--{elseif $action == 'manage'}-->
				<!--{template group/group_manage}-->
			<!--{/if}-->

<!--{template common/footer}-->