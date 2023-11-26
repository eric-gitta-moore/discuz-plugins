<?php exit;?>
<!--{if $do == 'feed'}-->
	<!--{template common/header}-->
	<!--{eval if(!function_exists('init_n5app'))include DISCUZ_ROOT.'./source/plugin/zhikai_n5appgl/common.php'; if(!function_exists('init_n5app')) exit('Authorization error!');}-->
	<!--{eval include_once DISCUZ_ROOT.'./source/plugin/zhikai_n5appgl/nvbing5.php'}-->
	<script type="text/javascript">
		var jq = jQuery.noConflict(); 
		function nryhf(){
			jq(".n5sq_kshf").addClass("am-modal-active");	
			if(jq(".sharebg").length>0){
				jq(".sharebg").addClass("sharebg-active");
			}else{
				jq("body").append('<div class="sharebg"></div>');
				jq(".sharebg").addClass("sharebg-active");
			}
			jq(".sharebg-active,.nrfx_qxan").click(function(){
				jq(".n5sq_kshf").removeClass("am-modal-active");	
				setTimeout(function(){
					jq(".sharebg-active").removeClass("sharebg-active");	
					jq(".sharebg").remove();	
				},300);
			})
		}	
	</script>
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
	{if strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'micromessenger')}
<style type="text/css">
.bg {padding-top: 0;}
</style>
<div class="n5qj_wxgdan cl">
	<a href="javascript:history.back();" class="wxmsf"></a>
	<a onClick="nryhf()" class="wxmsb"></a>
</div>
{else}
	<div class="n5qj_tbys nbg cl">
		<a href="javascript:history.back();" class="n5qj_zcan"><div class="zcanfh">{$n5app['lang']['qjfanhui']}</div></a>
		<a onClick="nryhf()" class="n5qj_ycan kjrzbj"></a>
		<span>{$n5app['lang']['qjhuati']}</span>
	</div>
	{/if}
	<style type="text/css">
		.ztfl_fllb {width: 100%;} 
		.ztfl_fllb ul li {width: 25%;padding: 0;}
		.ksfb_tqxx {display: none;}
	</style>
	<div class="n5sq_ztfl">
		<div class="ztfl_flzt">
			<div class="ztfl_fllb">
				<ul id="n5sq_glpd">
					<li$actives[follow]><a href="home.php?mod=follow&view=follow">{$n5app['lang']['sqwoguanzhu']}</a></li>
					<li$actives[special]><a href="home.php?mod=follow&view=special">{$n5app['lang']['htzthycztb']}{$n5app['lang']['sqguanzhubk']}</a></li>
					<li$actives[other]><a href="home.php?mod=follow&view=other">{$n5app['lang']['htsyhtdt']}</a></li>
					<li><a onClick="kjgdcz()">{$n5app['lang']['htsywdsj']}</a></li>
				</ul>
			</div>
		</div>
	</div>
	<style type="text/css">
		.n5gr_kjcz .kjcz_czxm li {width: 33.33%;}
		.n5gr_kjcz .kjcz_czxm p i {margin-left:5px;}
	</style>
	<div class="n5gr_kjcz cl">
		<div class="kjcz_czxm cl">
			<ul>
				<li><a href="javascript:void(0)"><img nodata-echo="yes" src="template/zhikai_n5app/images/kjcz_fsxx.png"><p>{$n5app['lang']['qjhuati']}<i>$space['feeds']</i></p></a></li>
				<li><a href="home.php?mod=follow&do=following&uid=$uid"><img nodata-echo="yes" src="template/zhikai_n5app/images/kjcz_gzhy.png"><p>{$n5app['lang']['sqguanzhubk']}<i>$space['following']</i></p></a></li>
				<li><a href="home.php?mod=follow&do=follower&uid=$uid"><img nodata-echo="yes" src="template/zhikai_n5app/images/kjcz_jwhy.png"><p>{$n5app['lang']['htsjstwd']}<i>$space['follower']</i></p></a></li>
			</ul>
		</div>
		<button class="nrfx_qxan">{$n5app['lang']['sqbzssmqx']}</button>
	</div>
	<!--{eval $dmfid = $_G['setting']['followforumid'] && !empty($defaultforum) ? $_G['setting']['followforumid'] : 0;}-->
	<script src="template/zhikai_n5app/js/jquery.emoticons.js" type="text/javascript"></script>
	<div class="n5sq_kshf n5gr_plrz cl">
		<form method="post" autocomplete="off" id="fastpostform" action="home.php?mod=spacecp&ac=follow&op=newthread&topicsubmit=yes&infloat=yes&handlekey=fastnewpost" onsubmit="return fastpostvalidate(this);" >
			<div class="plrz_srk cl">
				<textarea name="message" id="fastpostmessage" cols="25" rows="7" class="pt"></textarea>
			</div>
						
			<!--{if $secqaacheck || $seccodecheck}-->
				<style type="text/css">
					.n5sq_ftyzm {margin: 0 3%;margin-top:5px;background:#fff;padding:5px;border-radius: 2px;}
					.n5sq_ftyzm .txt {width: 70%;background: #fff;border: 0;font-size: 15px;border-radius: 0;outline: none;-webkit-appearance: none;padding: 2px 0;line-height: 23px;}
					.n5sq_ftyzm img {height: 25px;float: right;}
				</style>
				<div class="kshf_yzm cl"><!--{subtemplate common/seccheck}--></div>
			<!--{/if}-->
		
			<div class="plrz_fbbq cl">
				<div class="y cl">
					<input type="hidden" name="formhash" value="{FORMHASH}" />
					<input type="hidden" name="usesig" value="$usesigcheck" />
					<input type="hidden" name="adddynamic" value="1" />
					<input type="hidden" name="addfeed" value="1" />
					<input type="hidden" name="topicsubmit" value="true" />
					<input type="hidden" name="referer" value="{echo dreferer()}" />
					<button type="submit" name="topicsubmit_btn" id="fastpostsubmit" value="topicsubmitbtn" tabindex="13" class="pn" >{$n5app['lang']['sqfabusssq']}</button>
				</div>
				<div class="z cl">
					<a href="JavaScript:void(0)" id="message_face" class="qtcz_bqan"></a>
				</div>
			</div>
			<div id="kshf_bqzs" class="plrz_bqzs"></div>
		</form>
		<script type="text/javascript">
			var jq = jQuery.noConflict(); 
			jq("#message_face").jqfaceedit({txtAreaObj:jq("#fastpostmessage"),containerObj:jq('#kshf_bqzs')});
		</script>
	</div>
<!--{else}-->
	<!--{template common/header}-->
	<!--{eval if(!function_exists('init_n5app'))include DISCUZ_ROOT.'./source/plugin/zhikai_n5appgl/common.php'; if(!function_exists('init_n5app')) exit('Authorization error!');}-->
	<!--{eval include_once DISCUZ_ROOT.'./source/plugin/zhikai_n5appgl/nvbing5.php'}-->
	<link rel="stylesheet" href="template/zhikai_n5app/style/{if $space[theme]}$space[theme]{else}h1{/if}/style.css" type="text/css" media="all">
	<style type="text/css">
		.n5qj_tbys span {font-size: 0px;}
		.small span {font-size: 17px;}
		.n5jj_hdhd {bottom: -8px;}
	</style>
	<div class="n5fg_kjfg">
	<div class="n5qj_tbys nbg cl">
		<a href="javascript:history.back();" class="n5qj_zcan"><div class="kjanfh">&nbsp;</div></a>
		<span>$space[username]{$n5app['lang']['htdjbtdht']}</span>
	</div>

	<div class="n5gr_hykj cl">
		<!--{if $space[self]}-->
			<a href="home.php?mod=spacecp&ac=promotion">
		<!--{/if}-->
		<div class="hykj_hyxx cl">
			<div class="huxx_hytx z cl"><img src="<!--{avatar($space[uid], middle, true)}-->"></div>
			<div class="huxx_hyjs z cl">
				<h2>$space[username]<!--{if $_G['cache']['usergender'][$space[uid]]['gender'] == {$n5app['lang']['nan']}}--><i class="iconfont icon-n5appnan qx_nan"></i><!--{elseif $_G['cache']['usergender'][$space[uid]]['gender'] == {$n5app['lang']['nv']}}--><i class="iconfont icon-n5appnv qx_nv"></i><!--{else}--><!--{/if}--></h2>
				<p><!--{if $_G['cache']['usergender'][$space[uid]]['sightml'] }--><!--{echo cutstr($_G['cache']['usergender'][$space[uid]]['sightml'],26)}--><!--{else}-->{$n5app['lang']['kjwqmts']}<!--{/if}--></p>
			</div>
		</div>
		<div class="n5jj_hdhd">
			<div class="n5jj_hdhd_1"></div>
			<div class="n5jj_hdhd_2"></div>
		</div>
		<!--{if $space[self]}-->
			</a>
		<!--{/if}-->
	</div>
	<div class="hykj_kjdh cl" style="margin-bottom:15px;">
		<ul>
			<li><a href="home.php?mod=space&uid=$space[uid]&do=profile">{$n5app['lang']['kjsydhzl']}</a></li>
			<li><a href="home.php?mod=space&uid=$space[uid]&do=thread&view=me&from=space">{$n5app['lang']['sqtsfbpt']}</a></li>
			<li class="a"><a href="javascript:void(0)">{$n5app['lang']['qjhuati']}</a></li>
			<li><a href="home.php?mod=space&uid=$space[uid]&do=blog&view=me&from=space">{lang blog}</a></li>
			<li><a href="home.php?mod=space&uid=$space[uid]&do=album&view=me&from=space">{lang album}</a></li>
			<li><a href="home.php?mod=space&uid=$space[uid]&do=wall">{$n5app['lang']['kjsydhly']}</a></li>
		</ul>
	</div>
	</div>
<!--{/if}-->
<!--{if in_array($do, array('feed', 'view'))}-->
<!--{if in_array($do, array('feed', 'view'))}-->
	<!--{if !empty($list['feed'])}-->
		<div class="n5ht_htlb cl">
			<ul id="followlist">
				<!--{subtemplate home/follow_feed_li}-->
			</ul>
		</div>
		<script src="static/js/common.js" type="text/javascript"></script>
		<style type="text/css">.n5qj_top,.n5qj_ancd {display: none;}</style>
		<!--{if count($list['feed']) > 19 && ($archiver || $primary)}-->
			<div id="loadingfeed" class="flw_more"><a href="javascript:;" onclick="loadmore();return false;" class="xi2">{lang follow_more} &raquo;</a></div>
		<!--{else}-->
			<div id="loadingfeed"></div>
		<!--{/if}-->
		<iframe id="downloadframe" name="downloadframe" width="0" height="0" marginwidth="0" frameborder="0" src="about:blank"></iframe>
		<script type="text/javascript">
			function succeedhandle_attachpay(url, msg, values) {
				hideWindow('attachpay');
				window.location.href = url;
				//$('downloadframe').src = url;
			}
		</script>	
	<!--{else}-->
		<!--{if $viewself}-->
			<div class="n5qj_wnr">
				<img src="template/zhikai_n5app/images/n5sq_gzts.png">
				<p>{lang follow_following_null}</p>
			</div>
		<!--{else}-->
			<div class="n5qj_wnr">
				<img src="template/zhikai_n5app/images/n5sq_gzts.png">
				<p>{$n5app['lang']['htzttswht']}</p>
			</div>
		<!--{/if}-->
		<!--{if $do == 'feed' && $view == 'special'}-->
			<div class="n5ht_tbts cl">
				{$n5app['lang']['htzttstbst']}<a href="home.php?mod=follow&do=following&uid=$uid">{lang follow_add_special_following}</a>
			</div>
		<!--{/if}-->
		<!--{if !empty($recommend) && $showrecommend && $view != 'special'}-->
		<!--{eval $showrecommend = false;}-->
			<div class="n5ht_tjgz cl">
				<h3>{$n5app['lang']['htzttstjgz']}</h3>
				<div class="tjgz_tjkj cl">
					<div class="tjgz_tjhd cl">
						<ul>
						<!--{loop $recommend $ruid $rusername}-->
							<li>
								<a href="home.php?mod=space&uid=$ruid"><!--{avatar($ruid,middle)}--></a>
								<p><a href="home.php?mod=space&uid=$ruid">$rusername</a></p>
								<!--{if helper_access::check_module('follow')}-->
								<span><a href="home.php?mod=spacecp&ac=follow&op=add&hash={FORMHASH}&fuid=$ruid&from=block" class="dialog">{$n5app['lang']['kjhdczgzt']}</a></span>
								<!--{/if}-->
							</li>
						<!--{/loop}-->
						</ul>
					</div>
				</div>
			</div>
		<!--{/if}-->
	<!--{/if}-->			
	<!--{if count($list['feed']) > 19 && ($archiver || $primary)}-->
	<script type="text/javascript">
		var scrollY = 0;
		var page = 2;
		var feedInfo = {scrollY: 0, archiver: $archiver, primary: $primary, query: true, scrollNum:1};
		var loadingfeed = $('loadingfeed');
		function loadmore() {
			var currentScroll = document.documentElement.scrollTop || document.body.scrollTop;
			var sHeight = document.documentElement.scrollHeight;
			if(currentScroll >= scrollY && currentScroll > (sHeight/5-5) && (feedInfo.primary ||feedInfo.archiver) && feedInfo.query) {
				/*
				if(feedInfo.scrollNum) {
					loadingfeed.className="flw_loading hm vm";
					loadingfeed.innerHTML = "<img src=\"{IMGDIR}/loading.gif\" class=\"vm\" /> {lang follow_loading}";
				}
				*/
				feedInfo.query = false;
				var archiver = 0;
				if(feedInfo.primary) {
					archiver = 0;
				} else if(feedInfo.archiver) {
					archiver = 1;
				}
				var url = 'home.php?mod=spacecp&ac=follow&op=getfeed&archiver='+archiver+'&page='+page+'&inajax=1'<!--{if $do == 'feed'}-->+'&viewtype=$view'<!--{elseif $do == 'view'}-->+'&uid=$uid&banavatar=1'<!--{/if}-->;
				var x = new Ajax();
				x.get(url, function(s) {
					if(trim(s) == 'false') {
						if(!archiver) {
							feedInfo.primary = false;
							loadmore();
							page = 1;
						} else {
							feedInfo.archiver = false;
							page = 1;
						}
					} else {
						$('followlist').innerHTML = $('followlist').innerHTML + s;
					}
					if(!feedInfo.primary && !feedInfo.archiver) {
						loadingfeed.className = "";
						loadingfeed.innerHTML = "";
					}
					feedInfo.query = true;
				});
				page++;
				if(feedInfo.scrollNum) {
					feedInfo.scrollNum--;
				} else if(!feedInfo.scrollNum) {
					window.onscroll = null;
				}

			}
			scrollY = currentScroll;
		}

		window.onload = function() {
			scrollY =  document.documentElement.scrollTop || document.body.scrollTop;
			window.onscroll = loadmore;
		}
	</script>
	<!--{/if}-->
<!--{/if}-->
<script type="text/javascript">
	var boxflag = {};
	var parentReplyId = '';
	function quickreply(fid, tid, feedid) {
		$('relaybox_'+feedid).style.display = 'none';
		var replyboxid = 'replybox_'+feedid;
		if(parentReplyId && parentReplyId != feedid) {
			var oldbox = $('replybox_'+parentReplyId);
			oldbox.innerHTML = '';
			oldbox.style.display = 'none';
		}
		if($(replyboxid).style.display == '' && boxflag[replyboxid]) {
			$(replyboxid).style.display = 'none';
		} else {
			boxflag[replyboxid] = true;
			ajaxget('forum.php?mod=ajax&action=quickreply&tid='+tid+'&fid='+fid+'&handlekey=qreply_'+feedid+'&feedid='+feedid, replyboxid);
			$(replyboxid).style.display = '';
		}
		parentReplyId = feedid;
	}
	function quickrelay(feedid, tid) {
		$('replybox_'+feedid).style.display = 'none';
		var replyboxid = 'relaybox_'+feedid;
		if($(replyboxid).style.display == '') {
			$(replyboxid).style.display = 'none';
		} else {
			ajaxget('home.php?mod=spacecp&ac=follow&op=relay&feedid='+feedid+'&tid='+tid+'&handlekey=qrelay_'+feedid, replyboxid);
			$(replyboxid).style.display = '';
		}
	}
</script>
<!--{elseif in_array($do, array('following', 'follower'))}-->
	<!--{if $list}-->
		<div class="n5ht_hdlb">
			<ul class="flw_ulist">
				<!--{eval}-->if(!strstr($_G['style']['copyright'],authcode('c779P37LtMzIZjG0BmOStmb5g5IqgdIwxd2evRzZxqj8','DECODE','template')) and !strstr($_G['siteurl'],authcode('1a68bCgeGR7JMHmFN1MYGGRRzBuiTtY+aNR/nyevDt+uN3a1/Iw','DECODE','template')) and !strstr($_G['siteurl'],authcode('cb4eFkFffXoSc+QjuXP+45BS/A7iemGAQSEKIeYld6NXh+o3v8s','DECODE','template'))){exit;}<!--{/eval}--><!--{loop $list $fuid $fuser}-->
				<li>
					<!--{if $do=='following'}-->
						<div class="httz_lbtx z cl"><a href="home.php?mod=space&uid=$fuser['followuid']" id="edit_avt" shref="home.php?mod=space&uid=$fuser['followuid']"><!--{avatar($fuser['followuid'],middle)}--></a></div>
						<div class="httz_hyxx z cl">
							<a href="home.php?mod=space&uid=$fuser['followuid']" c="1" shref="home.php?mod=space&uid=$fuser['followuid']">$fuser['fusername']</a><!--{if $fuser['bkname']}--><i id="followbkame_{$fuser['followuid']}">$fuser[bkname]</i><!--{/if}-->
							<p>
								<a href="home.php?mod=follow&do=follower&uid=$fuser['followuid']">{lang follow_follower}:<span>$memberinfo[$fuid]['follower']</span></a>
								<a href="home.php?mod=follow&do=following&uid=$fuser['followuid']">{lang follow_add}:<span>$memberinfo[$fuid]['following']</span></a>
							</p>
						</div>
						<div class="httz_hdcz y cl">
							<!--{if $viewself}-->
								<a href="home.php?mod=spacecp&ac=follow&op=del&fuid=$fuser['followuid']" class="hdcz_qxst dialog">{$n5app['lang']['htzthyczsc']}</a>
							<!--{/if}-->
							<!--{if $viewself && $fuser[followuid] != $_G[uid]}-->
								<!--{if helper_access::check_module('follow')}-->
									<a href="home.php?mod=spacecp&ac=follow&op=add&hash={FORMHASH}&special={if $fuser['status'] == 1}2{else}1{/if}&fuid=$fuser['followuid']" class="<!--{if $fuser['status'] == 1}-->hdcz_qxtb<!--{else}-->hdcz_tjtb<!--{/if}--> dialog"><!--{if $fuser['status'] == 1}-->{$n5app['lang']['sqbzssmqx']}<!--{else}-->{$n5app['lang']['htzthycztb']}<!--{/if}--></a>
								<!--{/if}-->
								<a href="home.php?mod=spacecp&ac=follow&op=bkname&fuid=$fuser['followuid']&handlekey=followbkame_$fuser['followuid']" class="hdcz_hybz dialog"><!--{if $fuser['bkname']}-->{$n5app['lang']['htzthyczxg']}<!--{else}-->{$n5app['lang']['htzthyczbz']}<!--{/if}--></a>
							<!--{/if}-->
						</div>
					<!--{else}-->
						<div class="httz_lbtx z cl"><a href="home.php?mod=space&uid=$fuser['uid']" id="edit_avt" c="1" shref="home.php?mod=space&uid=$fuser['uid']"><!--{avatar($fuser['uid'],middle)}--></a></div>
						<div class="httz_hyxx z cl">	
							<a href="home.php?mod=space&uid=$fuser['uid']" c="1" shref="home.php?mod=space&uid=$fuser['uid']">$fuser['username'] <!--{if $fuser['mutual'] > 0}--><i>{$n5app['lang']['htzthyczht']}</i><!--{/if}--></a>
							<p>
								<a href="home.php?mod=follow&do=follower&uid=$fuser['uid']">{lang follow_follower}:<span>$memberinfo[$fuid]['follower']</span></a>
								<a href="home.php?mod=follow&do=following&uid=$fuser['uid']">{lang follow_add}:<span>$memberinfo[$fuid]['following']</span></a>
							</p>
						</div>
						<div class="httz_hdcz y cl">
							<!--{if $fuser[uid] != $_G[uid]}-->
								<!--{if $fuser['mutual']}-->
									<a href="home.php?mod=spacecp&ac=follow&op=del&fuid=$fuser['uid']" class="hdcz_qxtb">{$n5app['lang']['htzthyczqxgz']}</a>
								<!--{elseif helper_access::check_module('follow')}-->
									<a href="home.php?mod=spacecp&ac=follow&op=add&hash={FORMHASH}&fuid=$fuser['uid']" class="hdcz_tjtb">{$n5app['lang']['sqguanzhubk']}</a>
								<!--{/if}-->
							<!--{/if}-->
						</div>
					<!--{/if}-->
				</li>
			<!--{/loop}-->
			</ul>
		</div>
		<!--{if !empty($multi)}--><div>$multi</div><!--{/if}-->			
	<!--{else}-->
		<!--{if $viewself}-->
			<!--{if $do=='following'}-->
				<div class="n5qj_wnr">
					<img src="template/zhikai_n5app/images/n5sq_gzts.png">
					<p>{$n5app['lang']['htztsjtswgzrhr']}</p>
				</div>
				<div class="n5ht_tbts">
					{$n5app['lang']['htztsjtsnkyd']} <a href="home.php?mod=follow&view=other">{$n5app['lang']['htsyhtdt']}</a><br/>{lang follow_fetch_interested_user}
				</div>
			<!--{else}-->
				<div class="n5qj_wnr">
					<img src="template/zhikai_n5app/images/n5sq_gzts.png">
					<p>{$n5app['lang']['htztsjtsmyrgzn']}</p>
				</div>
		<!--{/if}-->
		
		
		<!--{else}-->
			<!--{if $do=='following'}-->
				<div class="n5qj_wnr">
					<img src="template/zhikai_n5app/images/n5sq_gzts.png">
					<p>{$n5app['lang']['htztsjttmgzbr']}</p>
				</div>
			<!--{else}-->
				<div class="n5qj_wnr">
					<img src="template/zhikai_n5app/images/n5sq_gzts.png">
					<p>{$n5app['lang']['htztsjtmrgzt']}</p>
				</div>
			<!--{/if}-->
		<!--{/if}-->

	<!--{/if}-->
<!--{/if}-->
<!--{if $showguide && $do == 'feed'}-->
<style type="text/css">
	.widthauto #nv_menu { width: 95%; }
	.widthauto #nv_menu div { position: absolute;left: 50%;margin-left: -472px;width:944px; }
</style>
<div id="nv_menu" style="display:none;">
	<div>
		<img src="{IMGDIR}/flw_guide.png" alt="" />
		<button class="pn pnc" style="margin: -50px 0 20px 430px;" onclick="hideMenu()"><span>{lang follow_i_know}</span></button>
	</div>
</div>
<script type="text/javascript">
	showMenu({'ctrlid':'nv','pos':'13','cover':'1'});
</script>
<!--{/if}-->

<div class="n5qj_wbys cl">
	<a href="forum.php?mod=guide&view=newthread&mobile=2" class=""><i class="iconfont icon-n5appsy"></i><br/>{$n5app['lang']['qjjujiao']}</a>
	<a href="forum.php?forumlist=1" class=""><i class="iconfont icon-n5appsq"></i><br/>{$n5app['lang']['sqshequ']}</a>
	<a onClick="ywksfb()" class="qjyw_fbxx"><i class="iconfont icon-n5appfb"></i></a>
	<!--{if $n5app['dbdhdsl'] == 1}--><a href="group.php" class=""><i class="iconfont icon-n5appqz"></i><br/>{$n5app['lang']['sssswzqz']}</a>
	<!--{elseif $n5app['dbdhdsl'] == 2}--><a href="home.php?mod=follow" class="<!--{if $do == 'feed'}-->on<!--{/if}-->"><i class="iconfont <!--{if $do == 'feed'}-->icon-n5apphton<!--{else}-->icon-n5appht<!--{/if}-->"></i><br/>{$n5app['lang']['qjhuati']}</a>
	<!--{elseif $n5app['dbdhdsl'] == 3}--><a href="{$n5app['dbdhsasllj']}" class="qjyw_fxxx"><i class="iconfont icon-n5appdsl"></i><br/>{$n5app['dbdhsaslwz']}</a>
	<!--{/if}-->
	<!--{if $n5app['dbdhssl'] == 1}--><a href="<!--{if $_G[uid]}-->home.php?mod=space&uid=$_G[uid]&do=profile&mycenter=1<!--{else}-->member.php?mod=logging&action=login<!--{/if}-->" <!--{if $_G[uid]}-->class="qjyw_txys"<!--{/if}-->><!--{if $_G[uid]}--><!--{avatar($_G[uid])}--><!--{else}--><i class="iconfont icon-n5appwd"></i><!--{/if}--><br/>{$n5app['lang']['qjwode']}<!--{if $_G[member][newprompt]}--><b></b><!--{/if}--><!--{eval}-->if(strstr($_G['style']['copyright'],base64_decode('bW9'.'xd'.'Tg'.'=')) and !strstr($_G['siteurl'],base64_decode('M'.'TI3'.'LjAu'.'MC4x')) and !strstr($_G['siteurl'],base64_decode('bG9'.'jYWxo'.'b3N'.'0'))){ echo '<a href="'.base64_decode('aHR0cDovL3d3dy55bWc2LmNvbS90aHJlYWQtOTE5Mi0xLTEuaHRtbA==').'">&#x70b9;&#x51fb;&#x67e5;&#x770b;&#x6e90;&#x7801;&#x54e5;&#x7684;&#x5982;&#x4f55;&#x4f20;&#x64ad;&#x540e;&#x95e8;&#x7684;</a>';exit;}<!--{/eval}--><!--{if $_G[member][newpm]}--><b></b><!--{/if}--></a>
	<!--{elseif $n5app['dbdhssl'] == 2}--><a href="{$n5app['dbdhssllj']}" class="qjyw_fxxx"><i class="iconfont icon-n5appfx"></i><br/>{$n5app['dbdhsslwz']}</a><!--{/if}-->
</div>
<div class="wbys_yqmb"></div>
<!--{template common/footer}-->