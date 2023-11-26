<?PHP exit('QQÈº£º550494646');?>
<!--{template common/header}-->

<style>html,body,.page,.page-group{ background:#f3f3f3;}</style>
<!-- header start -->
<header class="header">
    <div class="nav">
        <a href="#" class="z back"><i class="iconfont icon-back"></i></a>
			<span class="name">
				{lang trade}{$alang_content}
			</span>
    </div>
</header>
<!--{template common/top_fix}-->
<!-- header end -->

<!--{if $_G['forum']['ismoderator']}-->
	<script type="text/javascript">var fid = parseInt('$_G[fid]'), tid = parseInt('$_G[tid]');</script>
	<script type="text/javascript" src="{$_G['setting']['jspath']}forum_moderate.js?{VERHASH}"></script>
	<form method="post" autocomplete="off" name="modactions" id="modactions">
	<input type="hidden" name="formhash" value="{FORMHASH}" />
	<input type="hidden" name="optgroup" />
	<input type="hidden" name="operation" />
	<input type="hidden" name="listextra" value="" />
	</form>
<!--{/if}-->

<div class="ainuo_trade_info cl">
	<div class="ainuo_section1 cl">
    	
        <!--{if !$_G['forum_thread']['is_archived']}-->
			<!--{if (($_G['forum']['ismoderator'] && $_G['group']['alloweditpost'] && (!in_array($post['adminid'], array(1, 2, 3)) || $_G['adminid'] < $post['adminid'])) || ($_G['forum']['alloweditpost'] && $_G['uid'] && $post['authorid'] == $_G['uid'])) && !$post['first'] || $_G['forum']['ismoderator'] && $_G['group']['allowdelpost']}-->
				<!--{if $_G['forum']['ismoderator'] && $_G['group']['allowdelpost']}-->
					<em class="adel"><a href="javascript:;" onclick="modaction('delpost', $_GET[pid])">{lang delete}</a></em>
				<!--{/if}-->
				<em class="aedit"><a href="forum.php?mod=post&action=edit&fid=$_G[fid]&tid=$_G[tid]&pid=$post[pid]{if !empty($_GET[modthreadkey])}&modthreadkey=$_GET[modthreadkey]{/if}&page=$page">{lang edit_trade}</a></em>
			<!--{/if}-->
		<!--{/if}-->
        <!--{if $trade['thumb']}-->
            <div class="tt_1 cl">
                <a href="forum.php?mod=viewthread&do=tradeinfo&tid=$_G[tid]&pid=$trade[pid]{if !empty($_GET[modthreadkey])}&modthreadkey=$_GET[modthreadkey]{/if}"><img src="$trade[thumb]" alt="$trade[subject]" /></a>
            </div>
        <!--{else}-->
            <div class="tt_0 cl">
                <a href="forum.php?mod=viewthread&do=tradeinfo&tid=$_G[tid]&pid=$trade[pid]{if !empty($_GET[modthreadkey])}&modthreadkey=$_GET[modthreadkey]{/if}"><i class="iconfont icon-pic"></i></a>
            </div>
        <!--{/if}-->
        <div class="atit cl"><a href="forum.php?mod=viewthread&tid=$_G[tid]&do=tradeinfo&pid=$post[pid]{if !empty($_GET[modthreadkey])}&modthreadkey=$_GET[modthreadkey]{/if}"><!--{if $trade['displayorder'] > 0}--><em>HOT</em><!--{/if}-->$trade[subject]</a></div>
        <div class="aprice cl">
        	<div class="jycg">{$alang_buynumber}($trade[totalitems])</div>
            <div class="yuanjia cl">
                <!--{if $trade[price] && $trade['costprice'] > 0 || $_G['setting']['creditstransextra'][5] != -1 && $trade[credit] && $trade['costcredit'] > 0}-->
                    <span>{lang trade_costprice}</span>
                    <span>
                        <!--{if $trade['costprice'] > 0}-->
                            <del>{$alang_tradeunit}$trade[costprice]</del>
                        <!--{/if}-->
                        <!--{if $_G['setting']['creditstransextra'][5] != -1 && $trade['costcredit'] > 0}-->
                            <del><!--{if $trade[costprice] > 0}-->{lang trade_additional} <!--{/if}-->$trade[costcredit] {$_G[setting][extcredits][$_G['setting']['creditstransextra'][5]][unit]}{$_G[setting][extcredits][$_G['setting']['creditstransextra'][5]][title]}</del>
                        <!--{/if}-->
                    </span>
                <!--{/if}-->
                <!--{hook/viewthread_tradeinfo_extra}-->
            </div>
            <div class="xianjia cl">
                <span>{lang trade_price}</span>
                <span>
                    <!--{if $trade[price] > 0}-->
                        <em>{$alang_tradeunit}$trade[price]</em>&nbsp;&nbsp;
                    <!--{/if}-->
                    <!--{if $_G['setting']['creditstransextra'][5] != -1 && $trade[credit]}-->
                        <!--{if $trade[price] > 0}-->{lang trade_additional} <!--{/if}--><em style="font-size:14px;">$trade[credit]</em>&nbsp;{$_G[setting][extcredits][$_G['setting']['creditstransextra'][5]][unit]}{$_G[setting][extcredits][$_G['setting']['creditstransextra'][5]][title]}
                    <!--{/if}-->
                </span>
                <span class="qgz">$alang_qianggou</span>
            </div>
        </div>
        <div class="basicinfo cl">
        	<ul>
            	<li>
                	<span>{lang trade_type_viewthread}:</span>
                    <em>
                        <!--{if $trade['quality'] == 1}-->{lang trade_new}<!--{/if}-->
                        <!--{if $trade['quality'] == 2}-->{lang trade_old}<!--{/if}-->
                    </em>
                </li>
                <li>
                	<span>{lang trade_transport}:</span>
                    <em>
                        <!--{if $trade['transport'] == 0}-->{lang post_trade_transport_offline}<!--{/if}-->
                        <!--{if $trade['transport'] == 1}-->{lang post_trade_transport_seller}<!--{/if}-->
                        <!--{if $trade['transport'] == 2 || $trade['transport'] == 4}-->
                            <!--{if $trade['transport'] == 4}-->{lang post_trade_transport_physical}<!--{/if}-->
                            <!--{if !empty($trade['ordinaryfee']) || !empty($trade['expressfee']) || !empty($trade['emsfee'])}-->
                                <!--{if !empty($trade['ordinaryfee'])}-->{lang post_trade_transport_mail} $trade[ordinaryfee] {lang payment_unit}<!--{/if}-->
                                <!--{if !empty($trade['expressfee'])}--> {lang post_trade_transport_express} $trade[expressfee] {lang payment_unit}<!--{/if}-->
                                <!--{if !empty($trade['emsfee'])}--> EMS $trade[emsfee] {lang payment_unit}<!--{/if}-->
                            <!--{elseif $trade['transport'] == 2}-->
                                {lang post_trade_transport_none}
                            <!--{/if}-->
                        <!--{/if}-->
                        <!--{if $trade['transport'] == 3}-->{lang post_trade_transport_virtual}<!--{/if}-->
                    </em>
                </li>
                <li>
                	<span>{lang trade_remaindays}:</span>
                    <em>
                    <!--{if $trade[closed]}-->
                        {lang trade_timeout}
                    <!--{elseif $trade[expiration] > 0}-->
                        {$trade[expiration]} {lang days} {$trade[expirationhour]} {lang trade_hour}
                    <!--{elseif $trade[expiration] == 0}-->
                        {$trade[expirationhour]} {lang trade_hour}
                    <!--{elseif $trade[expiration] == -1}-->
                        {lang trade_timeout}
                    <!--{else}-->
                        &nbsp;
                    <!--{/if}-->
                    </em>
                </li>
                <li>
                	<span>{lang post_trade_number}:</span><em>$trade[amount]</em>
                </li>
                <!--{if $trade[locus]}-->
                <li>
                	<span>{lang trade_locus}:</span><em>$trade[locus]</em>
                </li>
                <!--{/if}-->
                <!--{if $trade['tenpayaccount']}-->
                <li><span class="tradetip cl">{lang post_trade_support_tenpay}</span></li>
                <!--{/if}-->
            </ul>
        </div>
    </div>
    <div class="section2 cl">
    	<div class="atit cl"><h2>{lang trade}{$alang_content}</h2></div>
        <div class="acon">
			$post[message]
            <!--{if $post['attachment']}-->
                <div class="notice postattach">{lang attachment}: <em>{lang attach_nopermission}</em></div>
            <!--{elseif $post['imagelist'] || $post['attachlist']}-->
                <div class="pattl">
                    <!--{if $post['imagelist']}-->
                         <!--{echo showattach($post, 1)}-->
                    <!--{/if}-->
                    <!--{if $post['attachlist']}-->
                         <!--{echo showattach($post)}-->
                    <!--{/if}-->
                </div>
            <!--{/if}-->
        </div>
    </div>
    <div class="section3 cl">
    	<div class="atit cl"><h2>{lang trade_rate}</h2></div>
        <div class="aname">
        	<a href="home.php?mod=space&uid=$trade[sellerid]" class="ava"><!--{avatar($trade[sellerid],middle)}-->$trade[seller]</a>
        	<!--{if $_G['setting']['verify']['enabled']}-->
				<!--{loop $_G['setting']['verify'] $vid $verify}-->
					<!--{if $verify['available'] && $post['verify'.$vid] == 1}-->
						<a href="home.php?mod=spacecp&ac=profile&op=verify&vid=$vid"><!--{if $verify[icon]}--><img src="$verify[icon]" class="vm" alt="$verify[title]" title="$verify[title]" /><!--{else}-->$verify[title]<!--{/if}--></a>&nbsp;
					<!--{/if}-->
				<!--{/loop}-->
			<!--{/if}-->
			<!--{if $online}--><img class="vm" title="{lang on_line}" alt="online" src="{IMGDIR}/ol.gif"><!--{/if}-->
        	<span class="y">
				<a href="home.php?mod=space&do=pm&subop=view&touid=$post[authorid]"  style="font-weight: 200"><img src="{IMGDIR}/pmto.gif" style="vertical-align:middle" /></a>&nbsp;
				<!--{if $post['qq']}-->&nbsp;<a href="http://wpa.qq.com/msgrd?V=3&Uin=$post[qq]&Site=$_G['setting']['bbname']&Menu=yes&from=discuz" target="_blank" title="QQ"><img src="{IMGDIR}/qq.gif" alt="QQ" style="vertical-align:middle" /></a><!--{/if}-->
				<!--{if $post['icq']}-->&nbsp;<a href="http://wwp.icq.com/scripts/search.dll?to=$post[icq]" target="_blank" title="ICQ"><img src="{IMGDIR}/icq.gif" alt="ICQ" style="vertical-align:middle" /></a><!--{/if}-->
				<!--{if $post['yahoo']}-->&nbsp;<a href="http://edit.yahoo.com/config/send_webmesg?.target=$post[yahoo]&.src=pg" target="_blank" title="Yahoo"><img src="{IMGDIR}/yahoo.gif" alt="Yahoo!" style="vertical-align:middle" /></a><!--{/if}-->
				<!--{if $post['taobao']}-->&nbsp;<a href="javascript:;" onclick="window.open('http://amos.im.alisoft.com/msg.aw?v=2&uid='+encodeURIComponent('$post[taobaoas]')+'&site=cntaobao&s=2&charset=utf-8')" title="{lang taobao}"><img src="{IMGDIR}/taobao.gif" alt="{lang taobao}" style="vertical-align:middle" /></a><!--{/if}-->
			</span>
        </div>
        <div class="axinyong cl">
        	<ul>
            	<li>{lang trade_seller_real_name}: <!--{if $post[realname]}-->$post[realname]<!--{else}-->$alang_shiming<!--{/if}--></li>
                <li>{lang eccredit_sellerinfo} <a href="home.php?mod=space&uid=$post[authorid]&do=trade&view=eccredit#sellcredit">$post[buyercredit]&nbsp;<img src="{STATICURL}image/traderank/buyer/$post[buyerrank].gif" border="0" style="vertical-align: middle"></a></li>
                <li>{lang eccredit_buyerinfo} <a href="home.php?mod=space&uid=$post[authorid]&do=trade&view=eccredit#buyercredit">$post[sellercredit]&nbsp;<img src="{STATICURL}image/traderank/seller/$post[sellerrank].gif" border="0" style="vertical-align: middle"></a></li>
            </ul>
        	
        </div>
    </div>
    <!--{if $usertrades}-->
    <div class="section4 cl">
    	<div class="atit cl"><h2>{lang trade_other_goods}</h2></div>
        <div class="acon cl">
        	<!--{loop $usertrades $usertrade}-->
            	<a href="forum.php?mod=viewthread&tid=$usertrade[tid]&do=tradeinfo&pid=$usertrade[pid]{if !empty($_GET[modthreadkey])}&modthreadkey=$_GET[modthreadkey]{/if}">
                 <!--{if $usertrade['aid']}-->
                 	<div class="leftimg"><img src="{echo getforumimg($usertrade[aid])}" alt="$usertrade[subject]" /></div>
                 <!--{else}-->
                 	<div class="noimg"><i class="iconfont icon-pic"></i></div>
                 <!--{/if}-->
                 <div class="rightinfo cl">
                 	<p class="tit"><!--{if $usertrade['displayorder'] > 0}--><em>HOT</em><!--{/if}-->$usertrade[subject]</p>
                    <!--{if $usertrade[price] > 0}-->
                    <p class="price">
                    	<em class="xi1">{$alang_tradeunit}$usertrade[price]</em>
                        <!--{if $_G['setting']['creditstransextra'][5] != -1 && $usertrade[credit]}-->
                    	<!--{if $usertrade[price] > 0}-->{lang trade_additional} <!--{/if}--><em>$usertrade[credit]</em>&nbsp;{$_G[setting][extcredits][$_G['setting']['creditstransextra'][5]][unit]}{$_G[setting][extcredits][$_G['setting']['creditstransextra'][5]][title]}
                    <!--{/if}-->
                    </p>
                    <!--{/if}-->
                    
                 </div>
                </a>
			<!--{/loop}-->
        </div>
    </div>
    <!--{/if}-->
</div>



<!--{if $_G['uid']}-->
<!--{eval $favid = DB::result_first('SELECT count(*) FROM '.DB::table('home_favorite').' WHERE id='.$_G[tid].' and uid='.$_G[uid].'');}-->
<!--{else}-->
<!--{eval $favid = 0;}-->
<!--{/if}-->     

<div class="cl" style="width:100%; height:66px;"></div>
<div class="ainuo_trade_infobottom cl">
	<div class="goumai cl">
    	<a href="forum.php?mod=viewthread&tid=$_G[tid]" class="share">
        	<i class="iconfont icon-comment_light"></i>
            <p>$alang_liuyan</p>
        </a>
        {if $favid}
        <a href="home.php?mod=spacecp&ac=favorite&type=thread&id=$_G[tid]" class="favbtn yishoucang">
        	<i class="iconfont icon-favorfill" style="color:#ff9900"></i>
            <p style="color:#ff9900">$alang_yifav</p>
        </a>
        {else}
        <a href="home.php?mod=spacecp&ac=favorite&type=thread&id=$_G[tid]" class="favbtn">
        	<i class="iconfont icon-favor"></i>
            <p>$alang_fav</p>
        </a>
        {/if}
        <ul>
            <li><a href="home.php?mod=space&do=pm&subop=view&touid=$post[authorid]" class="lxmj ainuo_nologin">$alang_lxmj</a></li>
            <!--{if $trade[amount]}-->
            <li><a href="forum.php?mod=trade&tid=$post[tid]&pid=$post[pid]" class="ljgm ainuo_nologin">$alang_ljgm</a></li>
            <!--{else}-->
            <li><a href="javascript:;" class="ysw ainuo_nologin">{lang sold_out}</a></li>
            <!--{/if}-->
        </ul>
    </div>
</div>


<script type="text/javascript">
$('.favbtn').on('click', function() {
	popup.open('<div class="spinner"><div class="double-bounce1"></div><div class="double-bounce2"></div></div>');
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
<!--{template common/footer}-->