<?php exit;?>
<!--{if !$post['message'] && (($_G['forum']['ismoderator'] && $_G['group']['alloweditpost'] && (!in_array($post['adminid'], array(1, 2, 3)) || $_G['adminid'] <= $post['adminid'])) || ($_G['forum']['alloweditpost'] && $_G['uid'] && $post['authorid'] == $_G['uid']))}-->
<div class="n5sq_ztts">{$n5app['lang']['sqspztdjzl']}<a href="forum.php?mod=post&action=edit&fid=$_G[fid]&tid=$_G[tid]&pid=$post[pid]&page=$page">{lang post_add_aboutcounter}</a></div>
<!--{else}-->
 <div class="postmessage">
 $post[message]
 </div>
<!--{/if}-->
<div class="n5sq_spzt cl">
	<!--{if count($trades) > 1 || ($_G['uid'] == $_G['forum_thread']['authorid'] || $_G['group']['allowedittrade'])}-->
		<div class="spzt_spgl cl">
			<i>{lang post_trade_totalnumber}: $tradenum</i>
			<!--{if !$_G['forum_thread']['is_archived'] && ($_G['uid'] == $_G['forum_thread']['authorid'] || $_G['group']['allowedittrade'])}-->
				<a href="forum.php?mod=misc&action=tradeorder&tid=$_G[tid]{if !empty($_GET['from'])}&from=$_GET['from']{/if}" class="dialog">{$n5app['lang']['sqspztspgl']}</a>
				<!--{if $_G['uid'] == $_G['forum_thread']['authorid']}--><!--{if $_G['group']['allowposttrade']}--><a href="forum.php?mod=post&action=reply&fid=$_G[fid]&tid=$_G[tid]&firstpid=$post[pid]&addtrade=yes{if !empty($_GET['from'])}&from=$_GET['from']{/if}">{$n5app['lang']['sqspzttjsp']}</a><!--{/if}--><!--{/if}-->
			<!--{/if}-->
		</div>
	<!--{/if}-->
	<!--{if $tradenum}-->
	<!--{if $trades}-->
    <!--{loop $trades $key $trade}-->
	<div class="spzt_spnr cl">
		<div class="zpzt_spxq cl">
			<div class="spxq_sptp cl">
				<!--{if $trade['displayorder'] > 0}--><div class="sptp_tjsp"></div><!--{/if}-->
				<!--{if $trade['thumb']}--><img src="$trade[thumb]"><!--{else}--><img src="template/zhikai_n5app/images/spxq_sptp.png"><!--{/if}--><span></span><em>$trade[subject]</em>
			</div>
			<div class="spxq_spjs cl">
				<p><i>{lang trade_type_viewthread}</i><!--{if $trade['quality'] == 1}-->{lang trade_new}<!--{/if}--><!--{if $trade['quality'] == 2}-->{lang trade_old}<!--{/if}-->{lang trade_type_buy}</p>
				<p><i>{lang trade_remaindays}</i><!--{if $trade[closed]}-->{lang trade_timeout}<!--{elseif $trade[expiration] > 0}-->{$trade[expiration]}{lang days}{$trade[expirationhour]}{lang trade_hour}<!--{elseif $trade[expiration] == -1}-->{lang trade_timeout}<!--{else}-->&nbsp;<!--{/if}--></p>
				<p><i>{lang trade_price}</i><!--{if $trade[price] > 0}--><span>$trade[price]{lang payment_unit}</span><!--{/if}-->
				<!--{if $_G['setting']['creditstransextra'][5] != -1 && $trade[credit]}-->
					<em><!--{if $trade[price] > 0}-->{lang trade_additional}:<!--{/if}-->$trade[credit]{$_G[setting][extcredits][$_G['setting']['creditstransextra'][5]][unit]}{$_G[setting][extcredits][$_G['setting']['creditstransextra'][5]][title]}</em></p>
				<!--{/if}-->
				<!--{if $trade[price] && $trade['costprice'] > 0 || $_G['setting']['creditstransextra'][5] != -1 && $trade[credit] && $trade['costcredit'] > 0}-->	
				<p><i>{lang trade_costprice}</i><!--{if $trade['costprice'] > 0}-->
						<del>$trade[costprice] {lang payment_unit}</del>
					<!--{/if}-->
					<!--{if $_G['setting']['creditstransextra'][5] != -1 && $trade['costcredit'] > 0}-->
						<del><!--{if $trade[costprice] > 0}-->{lang trade_additional} <!--{/if}-->$trade[costcredit] {$_G[setting][extcredits][$_G['setting']['creditstransextra'][5]][unit]}{$_G[setting][extcredits][$_G['setting']['creditstransextra'][5]][title]}</del>
					<!--{/if}--></p>
				<!--{/if}-->
				<div class="spjs_lxxq cl">
					<a href="forum.php?mod=viewthread&do=tradeinfo&tid=$_G[tid]&pid=$trade[pid]{if !empty($_GET[modthreadkey])}&modthreadkey=$_GET[modthreadkey]{/if}" class="spjs_ckxq dialog z cl">{$n5app['lang']['sqspztgdxx']}</a>
					<a href="home.php?mod=spacecp&ac=pm&op=showmsg&handlekey=showmsg_$post[authorid]&touid=$post[authorid]&pmid=0&daterange=2" class="spjs_lxmj y cl {if $_G['uid']}{else}n5app_wdlts{/if}">{$n5app['lang']['sqspztlxmj']}</a>
				</div>
			</div>
			<!--{hook/viewthread_trade_extra $key}-->
		</div>
	</div>
	<!--{/loop}-->
	<!--{/if}-->
	<div id="postmessage_$post[pid]">$post[counterdesc]</div>
	<!--{else}-->
	<div class="locked">{lang trade_nogoods}</div>
	<!--{/if}-->
</div>