<?php exit;?>
<!--{template common/header}-->
<!--{eval if(!function_exists('init_n5app'))include DISCUZ_ROOT.'./source/plugin/zhikai_n5appgl/common.php'; if(!function_exists('init_n5app')) exit('Authorization error!');}-->
<!--{eval include_once DISCUZ_ROOT.'./source/plugin/zhikai_n5appgl/nvbing5.php'}-->
<!--{eval $list = array();}-->
<!--{eval $wheresql = category_get_wheresql($cat);}-->
<!--{eval $list = category_get_list($cat, $wheresql, $page);}-->
<script type="text/javascript" src="template/zhikai_n5app/js/TouchSlide.1.1.source.js"></script>
{if strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'micromessenger')}
<style type="text/css">.bg {padding-top: 0;}</style>
<div class="n5qj_wxgdan cl">
	<a href="javascript:history.back();" class="wxmsf"></a>
	<a href="search.php?mod=portal" class="wxmss"></a>
</div><!--Fr om www.xhkj 5.com-->
{else}
<div class="n5qj_tbys nbg cl">
	<a href="javascript:history.back();" class="n5qj_zcan"><div class="zcanfh">{$n5app['lang']['qjfanhui']}</div></a>
	<a href="search.php?mod=portal" class="n5qj_ycan sousuo"></a>
	<span>$cat[catname]</span>
</div>
{/if}
<style type="text/css">
.n5sq_ztfl {margin-bottom: 0;}
</style>
<!--{if $cat[subs]}-->
<script src="template/zhikai_n5app/js/zhutufl.js"></script>
<div class="n5sq_ztfl">
    <div class="ztfl_flzt">
        <div class="ztfl_fllb">
            <ul>
				<!--{loop $cat[subs] $value}-->
				<li><a href="{$portalcategory[$value['catid']]['caturl']}" class="xi2">$value[catname]</a></li>
				<!--{/loop}-->
            </ul>
        </div>
    </div>
</div>
<!--{/if}-->
{$n5app['news_block']}

<div class="n5mh_xwlb cl">
	<!--{loop $list['list'] $value}-->
	<!--{eval $highlight = article_title_style($value);}-->
	<!--{eval $article_url = fetch_article_url($value);}-->
		<div class="xwlb_lbss cl">
			<div class="cl">
				<div class="xwlb_lbwz y cl" <!--{if $value[pic]}--><!--{else}-->style="width: 100%;"<!--{/if}-->>
					<h2><a href="$article_url">$value[title]</a></h2>
					<div class="xwcz_lysj z cl" style="margin-top:5px;"><!--{if $value[catname] && $cat[subs]}--><a href="{$portalcategory[$value['catid']]['caturl']}">$value[catname]</a><!--{/if}-->$value[dateline]</div>
				</div>
				<!--{if $value[pic]}-->
				<div class="xwlb_lbtp z cl">
					<a href="$article_url"><img src="$value[pic]" alt="$value[title]" /></a>
				</div>
				<!--{/if}-->
			</div>
		</div>
	<!--{/loop}-->
</div><!--Fr om www.xhkj 5.com-->
<style type="text/css">
	.page {margin: 30px 10px 30px 10px;}
</style>
<!--{if $list['multi']}-->{$list['multi']}<!--{/if}-->

<script src="template/zhikai_n5app/js/swipe.js"></script>
<script>
	var dots=document.getElementsByClassName('dot');
	var slider = new Swipe(document.getElementById('slider'), {
	startSlide: 0,
	speed: 400,
	auto: 3000,
	continuous: true,
	disableScroll: false,
	stopPropagation: false,
	callback: function(pos){
		document.getElementsByClassName('on')[0].className='dot';
		dots[pos].className='dot on';
	}
	});
</script>
<div class="n5qj_wbys cl">
	<a href="forum.php?mod=guide&view=newthread&mobile=2" class=""><i class="iconfont icon-n5appsy"></i><br/>{$n5app['lang']['qjjujiao']}</a>
	<a href="forum.php?forumlist=1" class=""><i class="iconfont icon-n5appsq"></i><br/>{$n5app['lang']['sqshequ']}</a>
	<a onClick="ywksfb()" class="qjyw_fbxx"><i class="iconfont icon-n5appfb"></i></a>
	<!--{if $n5app['dbdhdsl'] == 1}--><a href="group.php" class=""><i class="iconfont icon-n5appqz"></i><br/>{$n5app['lang']['sssswzqz']}</a>
	<!--{elseif $n5app['dbdhdsl'] == 2}--><a href="home.php?mod=follow" class=""><i class="iconfont icon-n5appht"></i><br/>{$n5app['lang']['qjhuati']}</a>
	<!--{elseif $n5app['dbdhdsl'] == 3}--><a href="{$n5app['dbdhsasllj']}" class="qjyw_fxxx"><i class="iconfont icon-n5appdsl"></i><br/>{$n5app['dbdhsaslwz']}</a>
	<!--{/if}-->
	<!--{if $n5app['dbdhssl'] == 1}--><a href="<!--{if $_G[uid]}-->home.php?mod=space&uid=$_G[uid]&do=profile&mycenter=1<!--{else}-->member.php?mod=logging&action=login<!--{/if}-->" <!--{if $_G[uid]}-->class="qjyw_txys"<!--{/if}-->><!--{if $_G[uid]}--><!--{avatar($_G[uid])}--><!--{else}--><i class="iconfont icon-n5appwd"></i><!--{/if}--><br/>{$n5app['lang']['qjwode']}<!--{if $_G[member][newprompt]}--><b></b><!--{/if}--><!--{if $_G[member][newpm]}--><b></b><!--{/if}--></a>
	<!--{elseif $n5app['dbdhssl'] == 2}--><a href="{$n5app['dbdhssllj']}" class="qjyw_fxxx"><i class="iconfont icon-n5appfx"></i><br/>{$n5app['dbdhsslwz']}</a><!--{/if}-->
</div>
<div class="wbys_yqmb"></div>
<!--{template common/footer}-->