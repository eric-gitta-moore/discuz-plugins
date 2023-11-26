<?php exit;?>
<!--{template common/header}-->
<!--{eval if(!function_exists('init_n5app'))include DISCUZ_ROOT.'./source/plugin/zhikai_n5appgl/common.php'; if(!function_exists('init_n5app')) exit('Authorization error!');}-->
<!--{eval include_once DISCUZ_ROOT.'./source/plugin/zhikai_n5appgl/nvbing5.php'}-->
{if strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'micromessenger')}
<style type="text/css">.bg {padding-top: 0;}</style>
<div class="n5qj_wxgdan cl">
	<a href="javascript:history.back();" class="wxmsf"></a>
	<!--{if $_G['group']['allowmanagearticle'] || ($_G['group']['allowpostarticle'] && $article['uid'] == $_G['uid'] && (empty($_G['group']['allowpostarticlemod']) || $_G['group']['allowpostarticlemod'] && $article['status'] == 1)) || $categoryperm[$value['catid']]['allowmanage']}-->
	<a href="portal.php?mod=portalcp&ac=article&op=delete&aid=$article[aid]" class="wxmsc {if $_G['uid']}dialog{/if}"></a>
	<!--{else}-->
	<a href="search.php?mod=portal" class="wxmss"></a>
	<!--{/if}-->
</div>
{else}
<div class="n5qj_tbys nbg cl">
	<a href="javascript:history.back();" class="n5qj_zcan"><div class="zcanfh">{$n5app['lang']['qjfanhui']}</div></a>
	<a id="a" href="javascript:void(0)" class="n5qj_ycan kjgdcz n5sq_xlcf" onclick="n5sq_xlkzList(this)"></a>
	<div class="n5sq_xlcd" id="dropdown-a">
		<ul>
			<li><a onClick="nrywfx()"><i class="iconfont icon-n5appxlfx"></i>{$n5app['lang']['nrxlfxzt']}</a></li>
			<li><a href="home.php?mod=spacecp&ac=favorite&type=article&id=$article[aid]&handlekey=favoritearticlehk_{$article[aid]}" class="{if $_G['uid']}dialog{else}n5app_wdlts{/if}"><i class="iconfont icon-n5appxlsc"></i>{$n5app['lang']['nrxlsczt']}</a></li>
			<!--{loop $cat[ups] $value}-->
			<li><a href="{echo getportalcategoryurl($value[catid])}"><i class="iconfont icon-n5appxlbk"></i>{$n5app['lang']['nrxlfhlm']}</a></li>
			<!--{/loop}-->
			<li><a href="search.php?mod=portal"><i class="iconfont icon-n5appxlss"></i>{$n5app['lang']['nrxlsswz']}</a></li>
			<!--{if $_G['group']['allowmanagearticle'] || ($_G['group']['allowpostarticle'] && $article['uid'] == $_G['uid'] && (empty($_G['group']['allowpostarticlemod']) || $_G['group']['allowpostarticlemod'] && $article['status'] == 1)) || $categoryperm[$value['catid']]['allowmanage']}-->
			<li><a href="portal.php?mod=portalcp&ac=article&op=delete&aid=$article[aid]" class="dialog"><i class="iconfont icon-n5appxlscs"></i>{$n5app['lang']['nrxlscwz']}</a></li>
			<!--{/if}-->
		</ul>
    </div>
	<span>$cat[catname]</span>
</div>
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
{/if}
<div class="n5mh_xwbt cl">
	<h2>$article[title] <!--{if $article['status'] == 1}-->[{lang moderate_need}]<!--{elseif $article['status'] == 2}-->[{lang ignored}]<!--{/if}--></h2>
	<div class="xwbt_xwxx cl">
		<div class="xwxx_xwzz z cl">
			<a href="home.php?mod=space&uid=$article[uid]&do=profile"><!--{avatar($article[uid],middle)}--></a>
			<a href="home.php?mod=space&uid=$article[uid]&do=profile">$article[username]</a>
			<p>$article[dateline]</p>
		</div>
		<div class="xwxx_xwxx y cl">
			<div class="cl">
				<span class="y cl">
					<em class="xwxx_cksl z cl"><!--{if $article[viewnum] > 0}-->$article[viewnum]<!--{else}-->0<!--{/if}--></em>
					<em class="xwxx_hfsl z cl"><!--{if $article[commentnum] > 0}-->$article[commentnum]<!--{else}-->0<!--{/if}--></em>
				</span>
			</div>
			<p class="y cl">
				<!--{if $article[from]}-->{lang from}: <!--{if $article[fromurl]}--><a href="$article[fromurl]">$article[from]</a><!--{else}-->$article[from]<!--{/if}--><!--{/if}-->
			</p>
		</div>
	</div>
</div>

<div class="n5mh_xwnr cl">
	<div class="xwnr_xwzy">
		<i>{lang article_description}</i>: $article[summary]
	</div>
	<!--{if $content[title]}-->
		<div class="vm_pagetitle xw1">$content[title]</div>
	<!--{/if}-->
	<div class="xwnr_nrys">$content[content]</div>
				
	<!--{if $multi}-->$multi<!--{/if}-->

	<script type="text/javascript" src="{$_G[setting][jspath]}home.js?{VERHASH}"></script>
	<div id="click_div">
		<!--{template home/space_click}-->
	</div>
</div>

<!--{if $article['related']}-->
	<div id="related_article" class="n5mh_xgyd cl">
		<h2>{lang view_related}</h2>
		<ul class="xl xl2 cl" id="raid_div">
			<!--{loop $article['related'] $raid $rvalue}-->
				<input type="hidden" value="$raid" />
				<li><a href="{$rvalue[uri]}">{$rvalue[title]}</a></li>
			<!--{/loop}-->
		</ul>
	</div>
<!--{/if}-->	

<!--{if $article['allowcomment']==1}-->
	<!--{eval $data = &$article}-->
	<!--{subtemplate portal/portal_comment}-->
<!--{/if}-->		

<!--{if $_G['relatedlinks']}-->
	<script type="text/javascript">
		var relatedlink = [];
		<!--{loop $_G['relatedlinks'] $key $link}-->
		relatedlink[$key] = {'sname':'$link[name]', 'surl':'$link[url]'};
		<!--{/loop}-->
		relatedlinks('article_content');
	</script>
<!--{/if}-->
<input type="hidden" id="portalview" value="1">

<!--{template common/footer}-->