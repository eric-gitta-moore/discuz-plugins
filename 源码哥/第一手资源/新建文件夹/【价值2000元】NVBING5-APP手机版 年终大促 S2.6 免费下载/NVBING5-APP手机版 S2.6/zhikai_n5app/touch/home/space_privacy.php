<?php exit;?>
<!--{eval $_G['home_tpl_titles'] = array('{lang remind}');}-->
<!--{template common/header}-->
<!--{eval if(!function_exists('init_n5app'))include DISCUZ_ROOT.'./source/plugin/zhikai_n5appgl/common.php'; if(!function_exists('init_n5app')) exit('Authorization error!');}-->
<!--{eval include_once DISCUZ_ROOT.'./source/plugin/zhikai_n5appgl/nvbing5.php'}-->
{eval 
	$space['isfriend'] = $space['self'];
	if(in_array($_G['uid'], (array)$space['friends'])) $space['isfriend'] = 1;
	space_merge($space, 'count');
	space_merge($space, 'field_home');
}
<script type="text/javascript">
		var jq = jQuery.noConflict(); 
			function kjgdcz(){
			jq(".n5gr_kjcz").addClass("am-modal-active");	
			if(jq(".sharebg").length>0){
				jq(".sharebg").addClass("sharebg-active");
			}else{
				jq("body").append('<div class="sharebg"></div>');
				jq(".sharebg").addClass("sharebg-active");
			}
			jq(".sharebg-active,.nrfx_qxan").click(function(){
				jq(".n5gr_kjcz").removeClass("am-modal-active");	
				setTimeout(function(){
					jq(".sharebg-active").removeClass("sharebg-active");	
					jq(".sharebg").remove();	
				},300);
			})
		}	
</script>
<div class="n5fg_kjfg">
<div class="n5qj_tbys nbg cl">
	<a href="javascript:history.back();" class="n5qj_zcan"><div class="kjanfh">&nbsp;</div></a>
	<!--{if $space[self]}-->
		<a onClick="kjgdcz()" class="n5qj_ycan kjgdcz"></a>
	<!--{/if}-->
</div>

<!--{if $space[self]}--><!--{else}-->
	<div class="n5gr_kjcz cl">
		<div class="kjcz_czxm cl">
			<ul>
				<!--{eval require_once libfile('function/friend');$isfriend=friend_check($space[uid]);}-->
				<!--{if !$isfriend}-->
					<li><a href="home.php?mod=spacecp&ac=friend&op=add&uid=$space[uid]&handlekey=addfriendhk_{$space[uid]}" <!--{if $_G[uid]}-->class="dialog"<!--{/if}-->><img src="template/zhikai_n5app/images/kjcz_jwhy.png"><p>{lang add_friend}</p></a></li>
				<!--{else}-->
					<li><a href="home.php?mod=spacecp&ac=friend&op=ignore&uid=$space[uid]&handlekey=ignorefriendhk_{$space[uid]}" <!--{if $_G[uid]}-->class="dialog"<!--{/if}-->><img src="template/zhikai_n5app/images/kjcz_jwhy.png"><p>{lang ignore_friend}</p></a></li>
				<!--{/if}-->
				<!--{if helper_access::check_module('follow') && $space[uid] != $_G[uid]}-->
					<!--{eval $follow = 0;}-->
					<!--{eval $follow = C::t('home_follow')->fetch_all_by_uid_followuid($_G['uid'], $space['uid']);}-->
					<!--{if !$follow}-->
						<li><a href="home.php?mod=spacecp&ac=follow&op=add&hash={FORMHASH}&fuid=$space[uid]" <!--{if $_G[uid]}-->class="dialog"<!--{/if}-->><img src="template/zhikai_n5app/images/kjcz_gzhy.png"><p>{$n5app['lang']['kjhdczgzt']}</p></a></li>
					<!--{else}-->
						<li><a href="home.php?mod=spacecp&ac=follow&op=del&fuid=$space[uid]" <!--{if $_G[uid]}-->class="dialog"<!--{/if}-->><img src="template/zhikai_n5app/images/kjcz_gzhy.png"><p>{$n5app['lang']['htzthyczqxgz']}</p></a></li>
					<!--{/if}-->
				<!--{/if}-->
				<li><a href="<!--{if $_G[uid]}-->home.php?mod=spacecp&ac=pm&op=showmsg&handlekey=showmsg_$space[uid]&touid=$space[uid]&pmid=0&daterange=2<!--{else}-->member.php?mod=logging&action=login<!--{/if}-->"><img src="template/zhikai_n5app/images/kjcz_fsxx.png"><p>{$n5app['lang']['kjhdczfsxx']}</p></a></li>
				<li><a href="home.php?mod=space&uid=$space[uid]&do=share&view=me&from=space" class="dialog"><img src="template/zhikai_n5app/images/kjcz_ewm.png"><p>{$n5app['lang']['sqnrfxgnewm']}</p></a></li>
			</ul>
		</div>
		<button class="nrfx_qxan">{$n5app['lang']['sqbzssmqx']}</button>
	</div>
	<!--{/if}-->

	<div class="n5gr_hykj cl">
		<div class="hykj_hyxx cl">
			<div class="huxx_hytx z cl"><img src="<!--{avatar($space[uid], middle, true)}-->"></div>
			<div class="huxx_hyjs z cl">
				<h2>$space[username]</h2>
				<p><!--{if $sightml = strip_tags($space['sightml'])}--><!--{echo cutstr({$sightml},26)}-->{$sightml}<!--{else}-->{$n5app['lang']['kjwqmts']}<!--{/if}--></p>
			</div>
		</div>
	</div>
	<div class="hykj_kjdh cl">
		<ul>
			<li><a href="home.php?mod=space&uid=$space[uid]&do=profile">{$n5app['lang']['kjsydhzl']}</a></li>
			<li><a href="home.php?mod=space&uid=$space[uid]&do=thread&view=me&from=space">{$n5app['lang']['sqtsfbpt']}</a></li>
			<li><a href="home.php?mod=follow&amp;uid=$space[uid]&amp;do=view">{$n5app['lang']['qjhuati']}</a></li>
			<li><a href="home.php?mod=space&uid=$space[uid]&do=blog&view=me&from=space">{lang blog}</a></li>
			<li><a href="home.php?mod=space&uid=$space[uid]&do=album&view=me&from=space">{lang album}</a></li>
			<li><a href="home.php?mod=space&uid=$space[uid]&do=wall">{$n5app['lang']['kjsydhly']}</a></li>
		</ul>
	</div>
</div>

<div class="n5gr_ysts cl">
	<div class="ysts_ystb"></div>
	{$n5app['lang']['kjysts']}
	{$n5app['lang']['kjystss']}
</div>

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
