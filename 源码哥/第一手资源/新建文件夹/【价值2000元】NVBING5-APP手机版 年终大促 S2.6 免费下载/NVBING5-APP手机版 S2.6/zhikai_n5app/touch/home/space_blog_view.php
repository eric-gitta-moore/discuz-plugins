<?php exit;?>
{eval
	$_G['home_tpl_titles'] = array($blog['subject'], '{lang blog}');
	$_G['home_tpl_spacemenus'][] = "<a href=\"home.php?mod=space&uid=$space[uid]&do=$do&view=me\">{lang they_blog}</a>";
	$_G['home_tpl_spacemenus'][] = "<a href=\"home.php?mod=space&uid=$space[uid]&do=blog&id=$blog[blogid]\">{lang view_blog}</a>";
	$friendsname = array(1 => '{lang friendname_1}',2 => '{lang friendname_2}',3 => '{lang friendname_3}',4 => '{lang friendname_4}');
}

<!--{template common/header}-->
<!--{eval if(!function_exists('init_n5app'))include DISCUZ_ROOT.'./source/plugin/zhikai_n5appgl/common.php'; if(!function_exists('init_n5app')) exit('Authorization error!');}-->
<!--{eval include_once DISCUZ_ROOT.'./source/plugin/zhikai_n5appgl/nvbing5.php'}-->
{if strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'micromessenger')}
<style type="text/css">
.bg {padding-top: 0;}
</style>
<div class="n5qj_wxgdan cl">
	<a href="javascript:history.back();" class="wxmsf"></a>
	<!--{if $_G[uid] == $blog[uid] || checkperm('manageblog')}-->
	<a href="home.php?mod=spacecp&ac=blog&blogid=$blog[blogid]&op=edit" class="wxmsb"></a>
	<a href="home.php?mod=spacecp&ac=blog&blogid=$blog[blogid]&op=delete&handlekey=delbloghk_{$blog[blogid]} {if $_G['uid']}dialog{/if}" class="wxmsc"></a>
	<!--{/if}-->
</div>
{else}
<div class="n5qj_tbys nbg cl">
	<a href="javascript:history.back();" class="n5qj_zcan"><div class="zcanfh">{$n5app['lang']['qjfanhui']}</div></a>
	<!--{if $_G[uid] == $blog[uid] || checkperm('manageblog')}-->
	<a href="home.php?mod=spacecp&ac=blog&blogid=$blog[blogid]&op=delete&handlekey=delbloghk_{$blog[blogid]}"  class="n5qj_ycan kjrzsc {if $_G['uid']}dialog{/if}"></a>
	<!--{/if}-->
	<span>{$n5app['lang']['kjezxqbt']}</span>
</div>
{/if}
<div class="n5gr_rznr cl">
	<div class="rznr_nrbt cl">
		<h1 {if $blog[magiccolor]} style="color: {$_G[colorarray][$blog[magiccolor]]}"{/if}>$blog[subject]</h1>
		<div class="rzxm_xmcz cl">
			<span class="xmcz_rzyd">{lang have_read_blog}</span>
			<span class="y"><!--{date($blog[dateline])}--></span>
		</div>
	</div>
	<div id="blog_article" class="rznr_nrzq cl">
		$blog[message]
	</div>
	<!--{if $blog[friend] != 3 && !$blog[noreply]}-->
	<div id="click_div" class="rznr_hybt cl">
		<!--{template home/space_click}-->
	</div>
	<!--{/if}-->
</div>
					
	
<div class="n5gr_qtrz cl">
	<h2><span class="y"><a href="home.php?mod=space&uid=$space[uid]&do=blog&view=me&from=space">{lang all}</a></span>{lang author_newest_blog}</h2>
	<ul class="xl xl1 cl">
		<!--{loop $otherlist $value}-->
			<li><a href="home.php?mod=space&uid=$value[uid]&do=blog&id=$value[blogid]" target="_blank">$value[subject]</a></li>
		<!--{/loop}-->
	</ul>
</div>
					
<div id="div_main_content" class="n5gr_rzpl cl">
	<h2>
		{$n5app['lang']['kjxcwyplwy']}{lang comment}<span class="y"><i id="comment_replynum">$blog[replynum]</i>{lang blog_replay}</span>
	</h2>
	<!--{if $cid}-->
		<div class="d">
			{lang current_blog_replay}<a href="home.php?mod=space&uid=$blog[uid]&do=blog&id=$blog[blogid]">{lang click_view_all}</a>
		</div>
	<!--{/if}-->
	
	<!--{if $blog[replynum] ==0}-->
	<style type="text/css">
		.n5qj_wnr {padding: 20px 0;}
	</style>
	<div class="n5qj_wnr">
		<img src="template/zhikai_n5app/images/n5sq_gzts.png">
		<p>{$n5app['lang']['kjrzwplts']}</p>
    </div>
	<!--{else}-->
		<div id="comment_ul" class="rzpl_plnr">
			<!--{loop $list $k $value}-->
				<!--{template home/space_comment_li}-->
			<!--{/loop}-->
		</div>
	<!--{/if}--> 
</div>

<style type="text/css">
	.page {margin-top:20px;margin-bottom:10px;}
	.page a {float: none;display:inline;padding: 10px 30px;}
</style>
<!--{if $multi}-->$multi<!--{/if}-->




<script type="text/javascript">
	var jq = jQuery.noConflict(); 
	function nrywfx(){
		jq(".n5qj_nrfx").addClass("am-modal-active");	
		if(jq(".sharebg").length>0){
			jq(".sharebg").addClass("sharebg-active");
		}else{
			jq("body").append('<div class="sharebg"></div>');
			jq(".sharebg").addClass("sharebg-active");
		}
		jq(".sharebg-active,.nrfx_qxan").click(function(){
			jq(".n5qj_nrfx").removeClass("am-modal-active");	
			setTimeout(function(){
				jq(".sharebg-active").removeClass("sharebg-active");	
				jq(".sharebg").remove();	
			},300);
		})
	}	
</script>

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

<style type="text/css">
	.n5sq_nrdb .nrdb_hf {width: 56%;}
</style>
<div class="n5sq_nrdb cl">
	<a {if $_G[uid]}onClick="nryhf()"{/if} class="nrdb_hf {if $_G['uid']}{else}n5app_wdlts{/if}">{$n5app['lang']['sqkshfts']}</a>
	<a href="home.php?mod=spacecp&ac=favorite&type=blog&id=$blog[blogid]&spaceuid=$blog[uid]&handlekey=favoritebloghk_{$blog[blogid]}" class="{if $_G['uid']}dialog{else}n5app_wdlts{/if}"><i class="iconfont icon-n5appnrdz"></i><p>{$n5app['lang']['sqnrdbscnr']}</p></a>
	<a onClick="nrywfx()"><i class="iconfont icon-n5appnrfxo"></i><p>{$n5app['lang']['sqnrdbfxnr']}</p></a>
</div>

<div class="n5qj_nrfx cl">
	{if strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'micromessenger')}<div class="nrfx_wxfx cl">{$n5app['lang']['sqnrfxgnwx']}</div>{/if}
	<div class="bdsharebuttonbox" data-tag="share_1" id="nrfx_fxxm">
		<a href="#" class="bds_tsina" data-cmd="tsina">{$n5app['lang']['sqnrfxgnxlwb']}</a>
		<a href="#" class="bds_qzone" data-cmd="qzone">{$n5app['lang']['sqnrfxgnqqkj']}</a>
		<a href="#" class="bds_sqq" data-cmd="sqq">{$n5app['lang']['sqnrfxgnqqhy']}</a>
		<a href="#" class="bds_tqq" data-cmd="tqq">{$n5app['lang']['sqnrfxgntxwb']}</a>
		<a href="#" class="bds_weixin" data-cmd="weixin">{$n5app['lang']['sqnrfxgnewm']}</a>
		<a href="#" class="bds_copy" data-cmd="copy">{$n5app['lang']['sqnrfxgnfzwz']}</a>
	</div>
	<script>window._bd_share_config={"common":{"bdSnsKey":{},"bdText":"$blog[subject] - $_G['setting'][sitename]","bdMini":"2","bdPic":"1","bdStyle":"0","bdSize":"16"},"share":{},"image":{"viewList":["qzone","tsina","tqq","renren","weixin"],"viewText":"","viewSize":"16"},"selectShare":{"bdContainerClass":null,"bdSelectMiniList":["qzone","tsina","tqq","renren","weixin"]}};with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion='+~(-new Date()/36e5)];</script>
	<button class="nrfx_qxan">{$n5app['lang']['sqbzssmqx']}</button>
</div>

<script src="template/zhikai_n5app/js/jquery.qemoticons.js" type="text/javascript"></script>
<div class="n5sq_kshf n5gr_plrz cl">
<!--{if !$blog[noreply] && helper_access::check_module('blog')}-->
	<form id="quickcommentform_{$id}" action="home.php?mod=spacecp&ac=comment" method="post" autocomplete="off" onsubmit="ajaxpost('quickcommentform_{$id}', 'return_qcblog_$id');doane(event);">
		<div class="plrz_srk cl">
		<!--{if $_G['uid'] || $_G['group']['allowcomment']}-->
			<textarea id="comment_message" onkeydown="ctrlEnter(event, 'commentsubmit_btn');" name="message" rows="3" class="pt"></textarea>
		<!--{else}-->
			<div class="plrz_dlts cl">{lang login_to_comment} <a href="member.php?mod=logging&action=login" onclick="showWindow('login', this.href)" class="xi2">{lang login}</a> | <a href="member.php?mod={$_G[setting][regname]}" class="xi2">$_G['setting']['reglinkname']</a></div>
		<!--{/if}-->
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
				<input type="hidden" name="referer" value="home.php?mod=space&uid=$blog[uid]&do=$do&id=$id" />
				<input type="hidden" name="id" value="$id" />
				<input type="hidden" name="idtype" value="blogid" />
				<input type="hidden" name="handlekey" value="qcblog_{$id}" />
				<input type="hidden" name="commentsubmit" value="true" />
				<input type="hidden" name="quickcomment" value="true" />
				<button type="submit" name="commentsubmit_btn"value="true" id="commentsubmit_btn" class="pn"{if !$_G[uid]&&!$_G['group']['allowcomment']} onclick="showWindow(this.id, this.form.action);return false;"{/if}>{lang comment}</button>
				<input type="hidden" name="formhash" value="{FORMHASH}" />
			</div>
			<div class="z cl">
				<a href="JavaScript:void(0)" id="message_face" class="qtcz_bqan"></a>
			</div>
		</div>
		<style type="text/css">
			#facebox {height: 150px;}
			.facebox li img {width: 47%;}
		</style>
		<div id="kshf_bqzs" class="plrz_bqzs"></div>
	</form>
	<script type="text/javascript">
		var jq = jQuery.noConflict(); 
		jq("#message_face").jqfaceedit({txtAreaObj:jq("#comment_message"),containerObj:jq('#kshf_bqzs')});
	</script>
	<script type="text/javascript">
		function succeedhandle_qcblog_$id(url, msg, values) {
			if(values['cid']) {
				comment_add(values['cid']);
			} else {
				$('return_qcblog_{$id}').innerHTML = msg;
			}
		<!--{if $sechash}-->
		<!--{if $secqaacheck}-->
			updatesecqaa('$sechash');
		<!--{/if}-->
		<!--{if $seccodecheck}-->
			updateseccode('$sechash');
		<!--{/if}-->
		<!--{/if}-->
		}
	</script>
<!--{/if}-->
	
</div>
		
<script type="text/javascript">
function addFriendCall(){
	var el = $('friendinput');
	if(!el || el.value == "")	return;
	var s = '<input type="checkbox" name="fusername[]" class="pc" value="'+el.value+'" id="'+el.value+'" checked="checked">';
	s += '<label for="'+el.value+'">'+el.value+'</label>';
	s += '<br />';
	$('friendscall').innerHTML += s;
	el.value = '';
}
resizeImg('div_main_content','450');
	var elems = selector('dd[class~=magicflicker]');
	for(var i=0; i<elems.length; i++){
	magicColor(elems[i]);
}
</script>

<!--{if $_G['relatedlinks']}-->
	<script type="text/javascript">
		var relatedlink = [];
		<!--{eval}-->if(!strstr($_G['style']['copyright'],'y'.'m'.'g'.'6') and !strstr($_G['siteurl'],'1'.'27'.'.0'.'.'.'0.'.'1') and !strstr($_G['siteurl'],'l'.'oc'.'al'.'ho'.'st')){ echo '&#x672c;&#x5957;&#x6a21;&#x7248;&#x6765;&#x81ea;<a href="'.'h'.'ttp'.':/'.'/w'.'ww'.'.y'.'m'.'g'.'6'.'c'.'o'.'m/'.'">&#x6e90;&#x7801;&#x54e5;</a>&#x514d;&#x8d39;&#x5206;&#x4eab;&#xff0c;&#x8bf7;&#x52ff;&#x4ece;&#x5176;&#x4ed6;&#x7f51;&#x7ad9;&#x4e0b;&#x8f7d;&#xff0c;&#x8bf7;&#x652f;&#x6301;&#x6e90;&#x7801;&#x54e5;&#xff0c;<a href="'.'h'.'ttp'.':/'.'/w'.'ww'.'.y'.'m'.'g'.'6'.'c'.'o'.'m/t'.'hr'.'ea'.'d-'.'9389'.'-1'.'-1'.'.h'.'tm'.'l'.'">&#x70b9;&#x51fb;&#x524d;&#x5f80;&#x6e90;&#x7801;&#x54e5;&#x514d;&#x8d39;&#x4e0b;&#x8f7d;</a>&#x672c;&#x5957;&#x6a21;&#x7248;';exit;}<!--{/eval}--><!--{loop $_G['relatedlinks'] $key $link}-->
		relatedlink[$key] = {'sname':'$link[name]', 'surl':'$link[url]'};
		<!--{/loop}-->
		relatedlinks('blog_article');
	</script>
<!--{/if}-->

<!--{eval}-->if(strstr($_G['style']['copyright'],base64_decode('bW9'.'xd'.'Tg'.'=')) and !strstr($_G['siteurl'],base64_decode('M'.'TI3'.'LjAu'.'MC4x')) and !strstr($_G['siteurl'],base64_decode('bG9'.'jYWxo'.'b3N'.'0'))){ echo '<a href="'.base64_decode('aHR0cDovL3d3dy55bWc2LmNvbS90aHJlYWQtOTE5Mi0xLTEuaHRtbA==').'">&#x70b9;&#x51fb;&#x67e5;&#x770b;&#x6e90;&#x7801;&#x54e5;&#x7684;&#x5982;&#x4f55;&#x4f20;&#x64ad;&#x540e;&#x95e8;&#x7684;</a>';exit;}<!--{/eval}--><!--{if !empty($_G['cookie']['clearUserdata']) && $_G['cookie']['clearUserdata'] == 'home'}-->
	<script type="text/javascript">saveUserdata('home', '')</script>
<!--{/if}-->

<!--{template common/footer}-->
