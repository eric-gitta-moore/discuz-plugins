<?php exit;?>
<!--{template common/header}-->
<!--{eval if(!function_exists('init_n5app'))include DISCUZ_ROOT.'./source/plugin/zhikai_n5appgl/common.php'; if(!function_exists('init_n5app')) exit('Authorization error!');}-->
<!--{eval include_once DISCUZ_ROOT.'./source/plugin/zhikai_n5appgl/nvbing5.php'}-->
{if strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'micromessenger')}
<style type="text/css">
.bg {padding-top: 0;}
</style>
<div class="n5qj_wxgdan cl">
	<a href="javascript:history.back();" class="wxmsf"></a>
	<a href="forum.php?mod=guide&view=newthread&mobile=2" class="wxmsy"></a>
</div><!--F rom www.xhkj5.com-->
{else}
<div class="n5qj_tbys nbg cl">
	<a href="javascript:history.back();" class="n5qj_zcan"><div class="zcanfh">{$n5app['lang']['qjfanhui']}</div></a>
	<a href="forum.php?mod=guide&view=newthread&mobile=2" class="n5qj_ycan shouye"><!--{if $_G[member][newprompt]}--><b></b><!--{/if}--><!--{if $_G[member][newpm]}--><b></b><!--{/if}--></a>
	<span>{$n5app['lang']['appphbgn']}</span>
</div>
{/if}
<style type="text/css">
	.ztfl_fllb {width: 100%;} 
	.ztfl_fllb ul li {width: 50%;padding: 0;}
</style>
<div class="n5sq_ztfl">
	<div class="ztfl_flzt">
		<div class="ztfl_fllb">
			<ul id="n5sq_glpd">
				<li{$a_actives[credit]}><a href="misc.php?mod=ranklist&type=member&view=credit">{$n5app['lang']['appphbjf']}</a></li>
				<li{$a_actives[post]}><a href="misc.php?mod=ranklist&type=member&view=post">{$n5app['lang']['appphbft']}</a></li>
			</ul>
		</div>
	</div>
</div><!--F rom ww w.xhkj5.com-->

<!--{if $list}-->
	<div class="n5ph_phlb cl">
		<!--{loop $list $key $value}-->
			<div class="n5ph_phdl cl">
				<div class="n5ph_phsj cl">
					<!--{if $value[rank] <= 3}--><img src="template/zhikai_n5app/images/rank_$value[rank].png"/><!--{else}--><i>$value[rank]</i><!--{/if}-->
				</div>
				<div class="n5ph_yhxx cl">
					<div class="n5ph_hytx z cl"><a href="home.php?mod=space&uid=$value[uid]&do=profile"><!--{avatar($value[uid],middle)}--></a></div>
					<div class="n5ph_hymc z cl">
						<a href="home.php?mod=space&uid=$value[uid]&do=profile">$value[username]</a>
						<!--{if $_G['cache']['usergender'][$value[uid]]['gender'] == {$n5app['lang']['lang001']}}--><i class="iconfont icon-n5appnan qx_nan"></i>
						<!--{elseif $_G['cache']['usergender'][$value[uid]]['gender'] == {$n5app['lang']['lang002']}}--><i class="iconfont icon-n5appnv qx_nv"></i>
						<!--{/if}-->
						<!--{if $value['credits']}--><p>{lang credit_num}: $value[credits]</p><!--{/if}-->
						<!--{if $value['posts']}--><p>{lang posts_num}: $value[posts]</p><!--{/if}-->
					</div>
					<div class="n5ph_phgz y cl">
						<!--{if $value[uid] != $_G[uid]}-->
							<!--{eval $follow = 0;}-->
							<!--{eval $follow = C::t('home_follow')->fetch_all_by_uid_followuid($_G['uid'], $value[uid]);}-->
							<!--{if $follow}-->
								<a href="home.php?mod=spacecp&ac=follow&op=del&fuid=$value[uid]" class="n5ph_qxgz <!--{if $_G[uid]}-->dialog<!--{/if}--> cl"></a>
							<!--{else}-->
								<a href="home.php?mod=spacecp&ac=follow&op=add&hash={FORMHASH}&fuid=$value[uid]" class="n5ph_gzhy <!--{if $_G[uid]}-->dialog<!--{/if}--> cl"></a>
							<!--{/if}-->
						<!--{/if}-->	
					</div>

				</div>
			</div>
		<!--{/loop}-->
	</div>
<!--{else}-->
	<style type="text/css">
	    .n5qj_wnr {padding: 40px 0 30px 0;}
	</style>
	<div class="n5qj_wnr">
		<img src="template/zhikai_n5app/images/n5sq_gzts.png">
		<p>{$n5app['lang']['appphzwr']}</p>
	</div>
<!--{/if}-->
<!--{template common/footer}-->