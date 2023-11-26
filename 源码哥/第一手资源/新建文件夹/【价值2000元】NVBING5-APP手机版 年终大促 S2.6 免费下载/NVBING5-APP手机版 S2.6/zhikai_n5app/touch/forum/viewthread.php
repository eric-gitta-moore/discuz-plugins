<?php exit;?>
<!--{template common/header}-->
<!--{eval if(!function_exists('init_n5app'))include DISCUZ_ROOT.'./source/plugin/zhikai_n5appgl/common.php'; if(!function_exists('init_n5app')) exit('Authorization error!');}-->
<!--{eval include_once DISCUZ_ROOT.'./source/plugin/zhikai_n5appgl/nvbing5.php'}-->
<!--{eval include_once DISCUZ_ROOT.'./source/plugin/zhikai_n5appgl/nvbing5_viewthread.php'}-->
<link href="template/zhikai_n5app/fenlei/mbflnr.css" type="text/css" rel="stylesheet">
{if strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'micromessenger')}
<style type="text/css">
.bg {padding-top: 0;}
</style><!--Fro m www.xhkj5.com-->
<div class="n5qj_wxgdan cl">
	<a href="javascript:history.back();" class="wxmsf"></a>
	<a href="search.php?mod=forum" class="wxmss"></a>
	<a href="forum.php?forumlist=1&mobile=2" class="wxmsy"></a>
</div>
{else}
<div class="n5qj_tbys nbg cl">
	<a href="javascript:history.back();" class="n5qj_zcan"><div class="zcanfh">{$n5app['lang']['qjfanhui']}</div></a>
	<a id="a" href="javascript:void(0)" class="n5qj_ycan kjgdcz n5sq_xlcf" onclick="n5sq_xlkzList(this)"></a>
	<div class="n5sq_xlcd" id="dropdown-a">
		<ul>
			<!--{if $_G['forum']['ismoderator']}--><li><a onClick="ztglcc()"><i class="iconfont icon-n5appztgl"></i>{$n5app['lang']['ztnrglzt']}</a></li><!--{/if}-->
			<li><a onClick="nrywfx()"><i class="iconfont icon-n5appxlfx"></i>{$n5app['lang']['nrxlfxzt']}</a></li>
			<li><a href="home.php?mod=spacecp&ac=favorite&type=thread&id=$_G[tid]&formhash={FORMHASH}" class="{if $_G['uid']}dialog{else}n5app_wdlts{/if}"><i class="iconfont icon-n5appxlsc"></i>{$n5app['lang']['nrxlsczt']}</a></li>
			<li><a href="forum.php?mod=forumdisplay&fid=$_G[fid]&<!--{eval echo rawurldecode($_GET[extra]);}-->"><i class="iconfont icon-n5appxlbk"></i>{$n5app['lang']['nrxlfhlb']}</a></li>
			<li><a href="forum.php?mod=post&action=newthread&fid=$_G[fid]&extra=$extra&sortid=$id" class="{if $_G['uid']}{else}n5app_wdlts{/if}"><i class="iconfont icon-n5appxlfb"></i>{$n5app['lang']['nrxlbbft']}</a></li>
			<li><a href="misc.php?mod=report&rtype=post&rid=$post[pid]&tid=$_G[tid]&fid=$_G[fid]" class="{if $_G['uid']}dialog{else}n5app_wdlts{/if}"><i class="iconfont icon-n5appxljb"></i>{$n5app['lang']['nrxlfhsq']}</a></li>
		</ul>
    </div>
	<!-- <a href="forum.php?mod=forumdisplay&fid=$_G[fid]&<!--{eval echo rawurldecode($_GET[extra]);}-->" class="n5qj_ycan nrfhbk"><!--{if $_G[member][newprompt]}--><b></b><!--{/if}--><!--{if $_G[member][newpm]}--><b></b><!--{/if}--></a>-->
	<span>$_G['forum'][name]</span>
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
<!--{hook/viewthread_top_mobile}-->
<!-- main postlist start -->

<div class="n5sq_ztnr cl">
	<h2 class="ztnr_ztbt cl">
        	<!--{if $_G['forum_thread']['typeid'] && $_G['forum']['threadtypes']['types'][$_G['forum_thread']['typeid']]}-->
			<i>[{$_G['forum']['threadtypes']['types'][$_G['forum_thread']['typeid']]}]</i>
            <!--{/if}-->
			$_G[forum_thread][subject]
            <!--{if $_G['forum_thread'][displayorder] == -2}--> <span>({lang moderating})</span>
            <!--{elseif $_G['forum_thread'][displayorder] == -3}--> <span>({lang have_ignored})</span>
            <!--{elseif $_G['forum_thread'][displayorder] == -4}--> <span>({lang draft})</span>
            <!--{/if}-->
	</h2>
	<!--{eval $postcount = 0;}-->
	<!--{loop $postlist $post}-->
	<!--{eval $needhiddenreply = ($hiddenreplies && $_G['uid'] != $post['authorid'] && $_G['uid'] != $_G['forum_thread']['authorid'] && !$post['first'] && !$_G['forum']['ismoderator']);}-->
	<!--{hook/viewthread_posttop_mobile $postcount}-->
	<!--{eval viewthread_fun1($post);}-->
		<!--{if $post[first]}-->
			<div class="lzys_hyqy cl">
				<!--{if !$post['authorid'] || $post['anonymous']}--><img src="template/zhikai_n5app/images/nmyk.png"><!--{else}--><a href="home.php?mod=space&uid=$post[authorid]&do=profile&view=me&mobile=2"><img src="<!--{avatar($post[authorid], middle, true)}-->"></a><!--{/if}-->
				<div class="hyqy_hy cl">
					<!--{if !$post['authorid'] || $post['anonymous']}--><a href="javascript:;">{$n5app['lang']['sqztnrnm']}</a><!--{else}--><a href="home.php?mod=space&uid=$post[authorid]&do=profile&view=me&mobile=2">$post[author]</a><!--{/if}-->
					<!--{if !$post['authorid'] || $post['anonymous']}--><!--{else}-->
					<!--{eval $thread['groupid'] = viewthread_fun2($post);}--> 
					<!--{eval $_self = viewthread_fun3($thread,$post);}--> 
					<!--{if $thread['groupid'] == 1}--><em class="g1">{$n5app['lang']['sqdengjigly']}</em><!--{elseif $thread['groupid'] == 2}--><em class="g1">{$n5app['lang']['sqbanzhubt']}</em><!--{elseif $thread['groupid'] == 3}--><em class="g1">{$n5app['lang']['sqbanzhubt']}</em><!--{elseif $thread['groupid'] == 16}--><em class="g1">{$n5app['lang']['sqbanzhubt']}</em><!--{elseif $thread['groupid'] == 17}--><em class="g1">{$n5app['lang']['sqdengjibj']}</em><!--{elseif $thread['groupid'] == 18}--><em class="g1">{$n5app['lang']['sqdengjibj']}</em><!--{elseif $thread['groupid'] == 18}--><em class="g1">{$n5app['lang']['sqdengjibj']}</em> 
					<!--{elseif $thread['groupid'] == 10}--><em class="y1">LV.1</em><!--{elseif $thread['groupid'] == 11}--><em class="y1">LV.2</em><!--{elseif $thread['groupid'] == 12}--><em class="y1">LV.3</em><!--{elseif $thread['groupid'] == 13}--><em class="y1">LV.4</em><!--{elseif $thread['groupid'] == 14}--><em class="y1">LV.5</em><!--{elseif $thread['groupid'] == 15}--><em class="y1">LV.6</em><!--{/if}--><!--{if $_self }--><em class="l1">{$n5app['lang']['sqztnrlzbs']}</em><!--{/if}-->
					<!--{eval viewthread_fun4($post);}-->				
					<!--{/if}-->
					<p>$post[dateline]</p>
				</div>
				<div class="hyqy_sj cl">
					<!--{if $_G['forum']['ismoderator']}--><!--{else}-->
					<!--{eval viewthread_fun5($post,$alloweditpost_status, $edittimelimit);}-->
					<!--{/if}-->
					<!--{if $post[authorid] != $_G[uid]}-->
					<!--{eval $ismyfav=DB::result_first("select followuid from ".DB::table("home_follow")." WHERE `uid` = $_G[uid] AND `followuid`=$post[authorid]");}-->
						<!--{if !$ismyfav}-->
							<a href="home.php?mod=spacecp&ac=follow&op=add&hash={FORMHASH}&fuid=$post[authorid]" class="{if $_G['uid']}dialog{else}n5app_wdlts{/if}">{$n5app['lang']['ztnrgzlz']}</a>
						<!--{else}-->
							<a href="home.php?mod=spacecp&ac=follow&op=del&fuid=$post[authorid]" class="{if $_G['uid']}dialog{else}n5app_wdlts{/if}" style="background-color:#c1c1c1">{$n5app['lang']['sqyiguanzhu']}</a>
						<!--{/if}-->
					<!--{/if}-->
					<p><span class="hyqy_ydsj">$thread[views]</span><span class="hyqy_hfsj">$_G[forum_thread][allreplies]</span></p>
				</div>
			</div>
			
			<!--{if $_G['forum']['ismoderator']}-->
				<script type="text/javascript">
					var jq = jQuery.noConflict(); 
					function ztglcc(){
						jq(".n5sq_ztgl").addClass("am-modal-active");	
						if(jq(".sharebg").length>0){
							jq(".sharebg").addClass("sharebg-active");
						}else{
							jq("body").append('<div class="sharebg"></div>');
							jq(".sharebg").addClass("sharebg-active");
						}
						jq(".sharebg-active,.qxan").click(function(){
							jq(".n5sq_ztgl").removeClass("am-modal-active");	
							setTimeout(function(){
								jq(".sharebg-active").removeClass("sharebg-active");	
								jq(".sharebg").remove();	
							},300);
						})
					}	
				</script>
				<div class="n5sq_ztgl cl">
					<div class="ztgl_glxm cl">
						<ul>
							<!--{if !$_G['forum_thread']['special']}-->
							<li><a type="button" class="redirect glxm xt1" href="forum.php?mod=post&action=edit&fid=$_G[fid]&tid=$_G[tid]&pid=$post[pid]<!--{if $_G[forum_thread][sortid]}--><!--{if $post[first]}-->&sortid={$_G[forum_thread][sortid]}<!--{/if}--><!--{/if}-->{if !empty($_GET[modthreadkey])}&modthreadkey=$_GET[modthreadkey]{/if}&page=$page">{lang edit}</a></li>
							<!--{/if}-->
							<li><a type="button" class="dialog glxm xt2" href="forum.php?mod=topicadmin&action=moderate&fid={$_G[fid]}&moderate[]={$_G[tid]}&operation=delete&optgroup=3&from={$_G[tid]}">{lang delete}</a></li>
							<li><a type="button" class="dialog glxm xt2" href="forum.php?mod=topicadmin&action=moderate&fid={$_G[fid]}&moderate[]={$_G[tid]}&from={$_G[tid]}&optgroup=4">{lang close}</a></li>
							<li><a type="button" class="dialog glxm xt2" href="forum.php?mod=topicadmin&action=banpost&fid={$_G[fid]}&tid={$_G[tid]}&topiclist[]={$_G[forum_firstpid]}">{lang admin_banpost}</a></li>
							<li><a type="button" class="dialog glxm xt2" href="forum.php?mod=topicadmin&action=warn&fid={$_G[fid]}&tid={$_G[tid]}&topiclist[]={$_G[forum_firstpid]}">{lang topicadmin_warn_add}</a></li>
							<!--{if $_G['group']['allowlivethread'] && !$_G['forum_thread']['is_archived']}--><!--{eval $modopt++}-->
							<li><a type="button" class="dialog glxm xt2" href="forum.php?mod=topicadmin&action=live&fid={$_G[fid]}&tid={$_G[tid]}&topiclist[]={$_G[forum_firstpid]}">{lang modmenu_live}</a></li>
							<!--{/if}-->
							<!--{if !$_G['forum_thread']['special'] && !$_G['forum_thread']['is_archived']}-->
							<!--{if $_G['group']['allowcopythread'] && $_G['forum']['status'] != 3}--><!--{eval $modopt++}-->
							<li><a type="button" class="dialog glxm xt2" href="forum.php?mod=topicadmin&action=copy&fid={$_G[fid]}&tid={$_G[tid]}&topiclist[]={$_G[forum_firstpid]}">{lang modmenu_copy}</a></li>
							<!--{/if}-->
							<!--{if $_G['group']['allowmergethread'] && $_G['forum']['status'] != 3}--><!--{eval $modopt++}-->
							<li><a type="button" class="dialog glxm xt2" href="forum.php?mod=topicadmin&action=merge&fid={$_G[fid]}&tid={$_G[tid]}&topiclist[]={$_G[forum_firstpid]}">{lang modmenu_merge}</a></li>
							<!--{/if}-->
							<!--{/if}-->
							<!--{if $_G['group']['allowsplitthread'] && !$_G['forum_thread']['is_archived'] && $_G['forum']['status'] != 3}--><!--{eval $modopt++}-->
							<li><a type="button" class="dialog glxm xt3" href="forum.php?mod=topicadmin&action=split&fid={$_G[fid]}&tid={$_G[tid]}&topiclist[]={$_G[forum_firstpid]}">{lang modmenu_split}</a></li>
							<!--{/if}-->
							<!--{if $_G['group']['allowstickthread'] && ($_G['forum_thread']['displayorder'] <= 3 || $_G['adminid'] == 1) && !$_G['forum_thread']['is_archived']}--><!--{eval $modopt++}-->
							<li><a type="button" class="dialog glxm xt2" href="forum.php?mod=topicadmin&action=moderate&fid={$_G[fid]}&moderate[]={$_G[tid]}&from={$_G[tid]}&optgroup=1">{lang modmenu_stickthread}</a></li>
							<!--{/if}-->
							<!--{if $_G['group']['allowstickthread'] && ($_G['forum_thread']['displayorder'] <= 3 || $_G['adminid'] == 1) && !$_G['forum_thread']['is_archived']}--><!--{eval $modopt++}-->
							<li><a type="button" class="dialog glxm xt3" href="forum.php?mod=topicadmin&action=moderate&fid={$_G[fid]}&moderate[]={$_G[tid]}&from={$_G[tid]}&optgroup=1">{$n5app['lang']['sqnrgljhxx']}</a></li>
							<!--{/if}-->
						</ul>
					</div>
					<div class="ztgl_qxan cl"><button class="qxan">{$n5app['lang']['sqbzssmqx']}</button></div>
				</div>
			<!--{/if}-->
		<!--{else}-->
			<div class="hfys_hytx"><!--{if !$post['authorid'] || $post['anonymous']}--><img src="template/zhikai_n5app/images/nmyk.png"><!--{else}--><a href="home.php?mod=space&uid=$post[authorid]&do=profile&view=me&mobile=2"><img src="<!--{avatar($post[authorid], middle, true)}-->"></a><!--{/if}--></div>
		<!--{/if}-->
		<div class="<!--{if $post[first]}-->n5sq_lznr<!--{else}-->n5sq_hfnr<!--{/if}--> n5sq_nrys" href="#replybtn_$post[pid]">
			<!--{if $post[first]}--><!--{else}-->
				<div class="hfnr_hyxx cl">
					<!--{if !$post['authorid'] || $post['anonymous']}--><a href="javascript:;">{$n5app['lang']['sqztnrnm']}</a><!--{else}--><a href="home.php?mod=space&uid=$post[authorid]&do=profile&view=me&mobile=2">$post[author]</a><!--{/if}-->
					<!--{if !$post['authorid'] || $post['anonymous']}--><!--{else}-->
					<!--{eval $thread['groupid'] = viewthread_fun2($post);}--> 
					<!--{eval $_self = viewthread_fun3($thread,$post);}--> 
					<!--{if $thread['groupid'] == 1}--><em class="g1">{$n5app['lang']['sqdengjigly']}</em><!--{elseif $thread['groupid'] == 2}--><em class="g1">{$n5app['lang']['sqbanzhubt']}</em><!--{elseif $thread['groupid'] == 3}--><em class="g1">{$n5app['lang']['sqbanzhubt']}</em><!--{elseif $thread['groupid'] == 16}--><em class="g1">{$n5app['lang']['sqbanzhubt']}</em><!--{elseif $thread['groupid'] == 17}--><em class="g1">{$n5app['lang']['sqdengjibj']}</em><!--{elseif $thread['groupid'] == 18}--><em class="g1">{$n5app['lang']['sqdengjibj']}</em><!--{elseif $thread['groupid'] == 18}--><em class="g1">{$n5app['lang']['sqdengjibj']}</em> 
					<!--{elseif $thread['groupid'] == 10}--><em class="y1">LV.1</em><!--{elseif $thread['groupid'] == 11}--><em class="y1">LV.2</em><!--{elseif $thread['groupid'] == 12}--><em class="y1">LV.3</em><!--{elseif $thread['groupid'] == 13}--><em class="y1">LV.4</em><!--{elseif $thread['groupid'] == 14}--><em class="y1">LV.5</em><!--{elseif $thread['groupid'] == 15}--><em class="y1">LV.6</em><!--{/if}--><!--{if $_self }--><em class="l1">{$n5app['lang']['sqztnrlzbs']}</em><!--{/if}-->
					<!--{eval viewthread_fun4($post);}-->					
					<!--{/if}-->
					<p><b><!--{if isset($post[isstick])}-->{$n5app['lang']['sqnrgljhzd']}<!--{elseif $post[number] == -1}-->{lang recommend_post}<!--{else}--><!--{if !empty($postno[$post[number]])}-->$postno[$post[number]]<!--{else}-->{$post[number]}{$postno[0]}<!--{/if}--><!--{/if}--></b>$post[dateline]</p>
				</div><!--Fro m www.xhkj5.com-->
				
				<script type="text/javascript">
					var jq = jQuery.noConflict(); 
					function ztglcz$post[pid](){
						jq(".ztgl_pid$post[pid]").addClass("am-modal-active");	
						if(jq(".sharebg").length>0){
							jq(".sharebg").addClass("sharebg-active");
						}else{
							jq("body").append('<div class="sharebg"></div>');
							jq(".sharebg").addClass("sharebg-active");
						}
						jq(".sharebg-active,.qxan").click(function(){
							jq(".ztgl_pid$post[pid]").removeClass("am-modal-active");	
							setTimeout(function(){
								jq(".sharebg-active").removeClass("sharebg-active");	
								jq(".sharebg").remove();	
							},300);
						})
					}	
				</script>
				<script type="text/javascript">
					var jq = jQuery.noConflict(); 
					function zthdcz$post[pid](){
						jq(".hdcz_pid$post[pid]").addClass("am-modal-active");	
						if(jq(".sharebg").length>0){
							jq(".sharebg").addClass("sharebg-active");
						}else{
							jq("body").append('<div class="sharebg"></div>');
							jq(".sharebg").addClass("sharebg-active");
						}
						jq(".sharebg-active,.qxan").click(function(){
							jq(".hdcz_pid$post[pid]").removeClass("am-modal-active");	
							setTimeout(function(){
								jq(".sharebg-active").removeClass("sharebg-active");	
								jq(".sharebg").remove();	
							},300);
						})
					}	
				</script>
				<div class="hfnr_hdcz cl">
					<!--{if $_G['forum']['ismoderator']}-->
						<a onClick="ztglcz$post[pid]()" class="hdcz_sz"></a>
					<!--{/if}-->
					<!--{if $_G['forum']['ismoderator']}--><!--{else}-->
					<!--{if (($_G['forum']['ismoderator'] && $_G['group']['alloweditpost'] && (!in_array($post['adminid'], array(1, 2, 3)) || $_G['adminid'] <= $post['adminid'])) || ($_G['forum']['alloweditpost'] && $_G['uid'] && ($post['authorid'] == $_G['uid'] && $_G['forum_thread']['closed'] == 0) && !(!$alloweditpost_status && $edittimelimit && TIMESTAMP - $post['dbdateline'] > $edittimelimit)))}-->
						<a class="hdcz_bj" href="forum.php?mod=post&action=edit&fid=$_G[fid]&tid=$_G[tid]&pid=$post[pid]{if !empty($_GET[modthreadkey])}&modthreadkey=$_GET[modthreadkey]{/if}&page=$page"></a>
					<!--{/if}-->
					<!--{/if}-->
					<!--{if !$_G['forum_thread']['special'] && !$rushreply && !$hiddenreplies && $_G['setting']['repliesrank'] && !$post['first'] && !($post['isWater'] && $_G['setting']['filterednovote'])}-->
						<a class="{if C::t('forum_hotreply_member')->fetch($post['pid'], $_G['uid'])}hdcz_dz_on{else}hdcz_dz{/if} {if $_G['uid']}dialog{else}n5app_wdlts{/if}" href="forum.php?mod=misc&action=postreview&do=support&tid=$_G[tid]&pid=$post[pid]&hash={FORMHASH}" {if $_G['uid']}onclick="ajaxmenu(this, 3000, 1, 0, '43', '');return false;"{else} onclick="showWindow('login', this.href)"{/if} id="review_support_$post[pid]"><!--{if $post[postreview][support]}--><i id="review_support_$post[pid]">$post[postreview][support]{$n5app['lang']['sqztnrdzs']}</i><!--{/if}--></a>
					<!--{/if}-->
					<a onClick="zthdcz$post[pid]()" class="hdcz_gd"></a>
				</div><!--From www.xhkj5.com-->
				<!--{if $_G['forum']['ismoderator']}-->
					<div class="n5sq_ztgls ztgl_pid$post[pid] cl">
						<div class="ztgl_glxm cl">
							<li><a type="button" class="redirect glxm xt1" href="forum.php?mod=post&action=edit&fid=$_G[fid]&tid=$_G[tid]&pid=$post[pid]{if !empty($_GET[modthreadkey])}&modthreadkey=$_GET[modthreadkey]{/if}&page=$page">{lang edit}</a></li>
							<!--{if $_G['group']['allowdelpost']}--><li><a type="button" class="dialog glxm xt1" href="forum.php?mod=topicadmin&action=delpost&fid={$_G[fid]}&tid={$_G[tid]}&operation=&optgroup=&page=&topiclist[]={$post[pid]}">{lang modmenu_deletepost}</a></li><!--{/if}-->
							<!--{if $_G['group']['allowbanpost']}--><li><a type="button" class="dialog glxm" href="forum.php?mod=topicadmin&action=banpost&fid={$_G[fid]}&tid={$_G[tid]}&operation=&optgroup=&page=&topiclist[]={$post[pid]}">{lang modmenu_banpost}</a></li><!--{/if}-->
							<!--{if $_G['group']['allowwarnpost']}--><li><a type="button" class="dialog glxm xt2" href="forum.php?mod=topicadmin&action=warn&fid={$_G[fid]}&tid={$_G[tid]}&operation=&optgroup=&page=&topiclist[]={$post[pid]}">{lang modmenu_warn}</a></li><!--{/if}-->
						</div>
						<div class="ztgl_qxan cl"><button class="qxan">{$n5app['lang']['sqbzssmqx']}</button></div>
					</div>
				<!--{/if}-->
				{if $n5app['onoff_reward']}{else}<style type="text/css">.n5sq_hdcz .hdcz_czxm li {width: 25%;}</style>{/if}
				<div class="n5sq_hdcz hdcz_pid$post[pid] cl">
					<div class="hdcz_czxm cl">
						<ul>
							<li><a href="forum.php?mod=misc&action=comment&tid=$post[tid]&pid=$post[pid]&extra=$_GET[extra]&page=$page{if $_G['forum_thread']['special'] == 127}&special=$specialextra{/if}&hash={FORMHASH}&hash={FORMHASH}" class="{if $_G['uid']}dialog{else}n5app_wdlts{/if}"><span style="background:#9dca06;"><i class="iconfont icon-n5appfb"></i></span>{$n5app['lang']['sqztnrhddp']}</a></li>
							<li><a href="forum.php?mod=post&action=reply&fid=$_G[fid]&tid=$_G[tid]&repquote=$post[pid]&extra=$_GET[extra]&page=$page" {if $_G[uid]}{else}class="n5app_wdlts"{/if}><span style="background:#FF9900;"><i class="iconfont icon-n5apphdhf"></i></span>{$n5app['lang']['sqztnrhdhf']}</a></li>
							{if $n5app['onoff_reward']}<li><a href="forum.php?mod=misc&action=rate&tid=$_G[tid]&pid=$post[pid]" class="{if $_G[uid]}dialog blue{else}n5app_wdlts{/if}"><span style="background:#ff6060;"><i class="iconfont icon-n5applcds"></i></span>{$n5app['lang']['sqdashang']}</a></li>{/if}
							<!--{eval $ismyfav=DB::result_first("select followuid from ".DB::table("home_follow")." WHERE `uid` = $_G[uid] AND `followuid`=$post[authorid]");}-->
							<li><a href="<!--{if !$ismyfav}-->home.php?mod=spacecp&ac=follow&op=add&hash={FORMHASH}&fuid=$post[authorid]<!--{else}-->home.php?mod=spacecp&ac=follow&op=del&fuid=$post[authorid]<!--{/if}-->" class="{if $_G['uid']}dialog{else}n5app_wdlts{/if}"><span style="background:<!--{if !$ismyfav}-->#3ebbfd<!--{else}-->#d0d0d0<!--{/if}-->;"><i class="iconfont icon-n5appgzlc"></i></span><!--{if !$ismyfav}-->{$n5app['lang']['kjhdczgzt']}<!--{else}-->{$n5app['lang']['sqyiguanzhu']}<!--{/if}--></a></li>
							<li><a href="misc.php?mod=report&rtype=post&rid=$post[pid]&tid=$_G[tid]&fid=$_G[fid]" class="{if $_G['uid']}dialog{else}n5app_wdlts{/if}"><span style="background:#da99db;"><i class="iconfont icon-n5appjblc"></i></span>{$n5app['lang']['sqztnrhdjb']}</a></li>
						</ul>
					</div>
					<div class="ztgl_qxan cl"><button class="qxan">{$n5app['lang']['sqbzssmqx']}</button></div>
				</div>
			<!--{/if}-->
			<div class="message">
					<!--{if viewthread_fun6()}-->
					<form id="bestanswersubmit" method="post" autocomplete="off" action="forum.php?mod=misc&action=bestanswer&tid=$_G[tid]&pid=$post[pid]&bestanswersubmit=yes">
						<input type="hidden" name="formhash" value="{FORMHASH}" />
						<input type="hidden" name="referer" value="{echo dreferer()}" />
						<input type="hidden" name="tid" value="$_G[tid]" />
						<input type="hidden" name="pid" value="$post[pid]" />
						<button type="submit" name="bestanswersubmit" class="n5sq_szzj" value="true">{$n5app['lang']['sqnrxsztzjdn']}</button>
					</form>
					<!--{/if}-->
					<!--{if $post[first]}-->
					<!--{if $rushreply}-->
						<div class="n5sq_qlzt cl">
							<h1><!--{if $rushresult[creditlimit] == ''}-->{lang thread_rushreply}<!--{else}-->{lang thread_rushreply_limit}<!--{/if}--></h1>
							<!--{if $rushresult[stopfloor]}--><p>{lang thread_rushreply_end}$rushresult[stopfloor]</p><!--{/if}-->
							<!--{if $rushresult[rewardfloor]}--><p>{lang thread_rushreply_floor}:$rushresult[rewardfloor]</p><!--{/if}-->
							<!--{if $rushresult[rewardfloor]}--><div class="y cl"><!--{if !$_GET['checkrush']}--><a href="forum.php?mod=viewthread&tid=$post[tid]&checkrush=1" rel="nofollow">{lang rushreply_view}</a><!--{/if}--></div><!--{/if}-->
							<!--{if $rushresult[rewardfloor] && $_GET['checkrush']}-->
							<div class="qlzt_qlts cl">
								<!--{if $countrushpost}--><i>$countrushpost</i>{lang thread_rushreply_rewardnum}<!--{else}-->{lang thread_rushreply_noreward}<!--{/if}-->
								<a href="forum.php?mod=viewthread&tid=$_G[tid]" class="y">{lang thread_rushreply_check_back}</a>
							</div>
							<!--{/if}-->
						</div>
					<!--{/if}-->
					<!--{/if}-->
                	<!--{if $post['warned']}-->
                        <span class="n5sq_sdjg">{lang warn_get}</span>
                    <!--{/if}-->
                    <!--{if !$post['first'] && !empty($post[subject])}-->
                        <h2><strong>$post[subject]</strong></h2>
                    <!--{/if}-->
                    <!--{if $_G['adminid'] != 1 && $_G['setting']['bannedmessages'] & 1 && (($post['authorid'] && !$post['username']) || ($post['groupid'] == 4 || $post['groupid'] == 5) || $post['status'] == -1 || $post['memberstatus'])}-->
                        <div class="n5sq_ztts cl">{lang message_banned}</div>
                    <!--{elseif $_G['adminid'] != 1 && $post['status'] & 1}-->
                        <div class="n5sq_ztts cl">{lang message_single_banned}</div>
                    <!--{elseif $needhiddenreply}-->
                        <div class="n5sq_ztts cl">{lang message_ishidden_hiddenreplies}</div>
					<!--{elseif $_G['forum_discuzcode']['passwordlock'][$post[pid]]}-->
						<div class="n5sq_ztjm"><p>{lang message_password_exists} {lang pleaseinputpw}</p><input type="text" id="postpw_$post[pid]" class="vm" /><button class="pn" type="button" onclick="submitpostpw($post[pid]{if $_GET['from'] == 'preview'},{$post[tid]}{else}{/if})">{lang submit}</button></div>
                    <!--{elseif $post['first'] && $_G['forum_threadpay']}-->
						<!--{template forum/viewthread_pay}-->
					<!--{else}-->
                    	<!--{if $_G['setting']['bannedmessages'] & 1 && (($post['authorid'] && !$post['username']) || ($post['groupid'] == 4 || $post['groupid'] == 5))}-->
                            <div class="n5sq_ztts cl">{lang admin_message_banned}</div>
                        <!--{elseif $post['status'] & 1}-->
                            <div class="n5sq_ztts cl">{lang admin_message_single_banned}</div>
                        <!--{/if}-->
						<!--{eval viewthread_fun7();}-->

						<div class="n5sq_nrzt">
                        <!--{if $post['first']}-->
                            <!--{if !$_G[forum_thread][special]}-->
                                $post[message]
                            <!--{elseif $_G[forum_thread][special] == 1}-->
                                <!--{template forum/viewthread_poll}-->
                            <!--{elseif $_G[forum_thread][special] == 2}-->
                                <!--{template forum/viewthread_trade}-->
                            <!--{elseif $_G[forum_thread][special] == 3}-->
                                <!--{template forum/viewthread_reward}-->
                            <!--{elseif $_G[forum_thread][special] == 4}-->
                                <!--{template forum/viewthread_activity}-->
                            <!--{elseif $_G[forum_thread][special] == 5}-->
                                <!--{template forum/viewthread_debate}-->
                            <!--{elseif $threadplughtml}-->
                                $threadplughtml
                                $post[message]
                            <!--{else}-->
                            	$post[message]
                            <!--{/if}-->
							
							<!--{if $_G['setting']['mobile']['mobilesimpletype'] == 0}-->
							<!--{if $post['attachment']}-->
								<!--{if $_G['forum_threadpay']}--><!--{else}-->
								<!--{if $_G['forum_discuzcode']['passwordlock'][$post[pid]]}--><!--{else}-->
								<div class="n5sq_ztts cl">
									{lang attachment} : <em><!--{if $_G['uid']}-->{lang attach_nopermission}<!--{else}-->{lang attach_nopermission_login}<!--{/if}--></em>
								</div>
								<!--{/if}-->
								<!--{/if}-->
							<!--{elseif $post['imagelist'] || $post['attachlist']}-->
							<!--{if $post['imagelist']}-->
								<!--{if count($post['imagelist']) == 1}-->
									<ul class="img_one">{echo showattach($post, 1)}</ul>
								<!--{else}-->
									<ul class="img_list cl vm">{echo showattach($post, 1)}</ul>
							<!--{/if}-->
							<!--{/if}-->
							<!--{if $post['attachlist']}-->
							<ul>{echo showattach($post)}</ul>
							<!--{/if}-->
							<!--{/if}-->
							<!--{/if}-->

							<!--{if $post['first']  && $threadsortshow}-->
							<div class="n5sq_fptx cl">
								<div class="fptx_txwz">
									{$n5app['lang']['flxxtxy1']}
								</div>
								<div class="fptx_jban">
									<a href="misc.php?mod=report&rtype=post&rid=$post[pid]&tid=$_G[tid]&fid=$_G[fid]" class="{if $_G['uid']}dialog{else}n5app_wdlts{/if}"><i class="iconfont icon-n5appxxjb"></i><p>{$n5app['lang']['nrxlfhsq']}</p></a>
								</div>
							</div>
							
							<div class="n5sq_flhy cl">
								<div class="flhy_hytx"><!--{if !$post['authorid'] || $post['anonymous']}--><img src="template/zhikai_n5app/images/nmyk.png"><!--{else}--><a href="home.php?mod=space&uid=$post[authorid]&do=profile&view=me&mobile=2"><img src="<!--{avatar($post[authorid], middle, true)}-->"></a><!--{/if}--></div>
								<div class="flhy_glll y">
									<i>$thread[views]{$n5app['lang']['nryfllll']}</i>
									<!--{if $_G['forum']['ismoderator']}--><!--{else}-->
										<!--{eval viewthread_fun5($post,$alloweditpost_status, $edittimelimit);}-->
									<!--{/if}-->
									<!--{if $_G['forum']['ismoderator']}--><a onClick="ztglcc()" class="glll_flgl">{lang manage}</a><!--{/if}-->
								</div>
								<div class="flhy_hyxx z">
									<!--{if !$post['authorid'] || $post['anonymous']}--><a href="javascript:;">{$n5app['lang']['sqztnrnm']}</a><!--{else}--><a href="home.php?mod=space&uid=$post[authorid]&do=profile&view=me&mobile=2">$post[author]</a><!--{/if}-->
									<!--{if !$post['authorid'] || $post['anonymous']}--><!--{else}-->
										<!--{eval $thread['groupid'] = viewthread_fun2($post);}--> 
										<!--{eval $_self = viewthread_fun3($thread,$post);}--> 
										<!--{if $thread['groupid'] == 1}--><em class="g1">{$n5app['lang']['sqdengjigly']}</em><!--{elseif $thread['groupid'] == 2}--><em class="g1">{$n5app['lang']['sqbanzhubt']}</em><!--{elseif $thread['groupid'] == 3}--><em class="g1">{$n5app['lang']['sqbanzhubt']}</em><!--{elseif $thread['groupid'] == 16}--><em class="g1">{$n5app['lang']['sqbanzhubt']}</em><!--{elseif $thread['groupid'] == 17}--><em class="g1">{$n5app['lang']['sqdengjibj']}</em><!--{elseif $thread['groupid'] == 18}--><em class="g1">{$n5app['lang']['sqdengjibj']}</em><!--{elseif $thread['groupid'] == 18}--><em class="g1">{$n5app['lang']['sqdengjibj']}</em> 
										<!--{elseif $thread['groupid'] == 10}--><em class="y1">LV.1</em><!--{elseif $thread['groupid'] == 11}--><em class="y1">LV.2</em><!--{elseif $thread['groupid'] == 12}--><em class="y1">LV.3</em><!--{elseif $thread['groupid'] == 13}--><em class="y1">LV.4</em><!--{elseif $thread['groupid'] == 14}--><em class="y1">LV.5</em><!--{elseif $thread['groupid'] == 15}--><em class="y1">LV.6</em><!--{/if}--><!--{if $_self }--><em class="l1">{$n5app['lang']['sqztnrlzbs']}</em><!--{/if}-->
										<!--{eval viewthread_fun4($post);}-->				
									<!--{/if}-->
									<p>{$n5app['lang']['nryflhyfb']}$post[dateline]</p>
								</div>
							</div>
							<!--{/if}-->
							
							{if $n5app['onoff_reward']}
							<!--{if !$post['authorid'] || $post['anonymous']}--><!--{else}-->
								<div class="n5sq_lzds cl">
									<p>{$n5app['reward_tip']}</p>
									<a href="{if $_G[uid]}forum.php?mod=misc&action=rate&tid=$_G[tid]&pid=$post[pid]{else}javascript:;{/if}" class="{if $_G[uid]}dialog{else}n5app_wdlts{/if}">{$n5app['lang']['sqnrbzsnygz']}</a>
								</div>
								<!--{if !empty($post['ratelog'])}-->
									<div class="n5sq_dsjl cl">
										<div id="post_rate_$post[pid]"></div>
										<p><a href="forum.php?mod=misc&action=viewratings&tid=$_G[tid]&pid=$post[pid]">{$n5app['lang']['dselyyzd']}<i><!--{echo count($postlist[$post[pid]][totalrate]);}--></i>{$n5app['lang']['sqnrdsrstj']}</a></p>
										<div class="dsjl_txlb cl"><!--From ww w.xhkj5.com-->
											<!--{loop $post['ratelog'] $uid $ratelog}-->
											<a href="home.php?mod=space&uid=$uid&do=profile"><!--{avatar($uid,middle)}--></a>
											<!--{/loop}-->
										</div>
									</div>
								<!--{/if}-->
							<!--{/if}-->
							{/if}
							<!--{if $post['first'] && ($post[tags] || $relatedkeywords) && $_GET['from'] != 'preview'}-->
								<div class="n5sq_ztbq cl">
								<!--{if $post[tags]}-->
									<i class="iconfont icon-n5appbq"></i>
									<!--{eval $tagi = 0;}-->
									<!--{loop $post[tags] $var}-->
										<!--{if $tagi}--> , <!--{/if}--><a title="$var[1]" href="misc.php?mod=tag&id=$var[0]">$var[1]</a>
										<!--{eval $tagi++;}-->
									<!--{/loop}-->
								<!--{/if}-->
								</div>
							<!--{/if}-->
							<!--{eval $recommend_users = DB::fetch_all("SELECT a.recommenduid,a.dateline,b.username,b.uid FROM ".DB::table('forum_memberrecommend')." a LEFT JOIN ".DB::table('common_member')." b on b.uid=a.recommenduid WHERE a.`tid` = '$_G[tid]' AND b.`status`=0 ORDER BY a.`dateline` DESC LIMIT 0,20");}-->
							<!--{if $recommend_users}-->
								<div class="n5sq_ztdz cl">
									<h2><span class="y">{$n5app['lang']['ztnrdztzid']} $_G[tid]</span><a href="forum.php?mod=misc&action=recommend&do=add&tid=$_G[tid]&hash={FORMHASH}" class="{if $_G['uid']}dialog{else}n5app_wdlts{/if}"><i class="iconfont icon-n5appnrsc"></i>{$n5app['lang']['ztnrdzzgtz']}</a></h2>
									<ul>
										<li style="float:right;margin-right:0;margin-left: 20px;"><a href="forum.php?mod=viewthread&action=printable&tid=$_G[tid]"><span>$_G[forum_thread][recommend_add]{$n5app['lang']['sqztnrdzs']}</span></a></li>
										<!--{loop $recommend_users $rdu}-->
											<li><a href="home.php?mod=space&uid={$rdu['uid']}" class="ztdz_dztx"><img src="uc_server/avatar.php?uid={$rdu['uid']}&size=middle" style="margin-top:0;"/></a></li>
										<!--{/loop}-->
									</ul>
								</div>
							<!--{/if}-->
                        <!--{else}-->
                            $post[message]
							<!--{if $post['imagelist']}-->
								<!--{if count($post['imagelist']) == 1}-->
									<ul class="img_one">{echo showattach($post, 1)}</ul>
								<!--{else}-->
									<ul class="img_list cl vm">{echo showattach($post, 1)}</ul>
								<!--{/if}-->
							<!--{/if}-->
							<!--{if $_GET['from'] != 'preview' && $_G['setting']['commentnumber'] && !empty($comments[$post[pid]])}-->
								<script type="text/javascript">
								$(document).ready(function(){
								var len=2;
								var arr=$(".n5_dpsl$post[pid] .dplb_dpsj:not(:hidden)");
									if(arr.length<len){
										$(".n5sq_lbzk$post[pid]").hide();
										}
									if(arr.length>len){
									$('.n5_dpsl$post[pid] .dplb_dpsj:gt('+(len-1)+')').hide();
									}
									$(".n5sq_lbzk$post[pid]").click(function(){
									var arr=$(".n5_dpsl$post[pid] .dplb_dpsj:not(:hidden)");
										if(arr.length>len){
										$('.n5_dpsl$post[pid] .dplb_dpsj:gt('+(len-1)+')').hide();
										}
										else{
										$('.n5_dpsl$post[pid] .dplb_dpsj:gt('+(len-1)+')').show();
										}
										var T = $(this);
										if (T.hasClass("n5sq_dpzks")) {
										T.removeClass("n5sq_dpzks").text("{$n5app['lang']['sqzdztslkz']}");
										} else {
										T.addClass("n5sq_dpzks").text("{$n5app['lang']['sqzdztslsq']}");
										}
									});
								});
								</script>
								<div id="comment_$post[pid]" class="n5sq_dplb n5_dpsl$post[pid]  cl">
									<!--{loop $comments[$post[pid]] $comment}-->
									<div class="dplb_dpsj cl">
										<!--{if $comment['authorid']}-->
										<a href="home.php?mod=space&uid=$comment[authorid]&do=profile" class="xi2 xw1">$comment[author] : </a>
									    <!--{else}-->
										<a>{lang guest} :</a> 
										<!--{/if}-->
										$comment[comment]
									</div>
									<!--{/loop}-->
									<a href="javascript:;" class="n5sq_dpzk n5sq_lbzk$post[pid] cl">{$n5app['lang']['sqzdztslkz']}</a>
								</div>
							<!--{/if}-->
							{if $n5app['onoff_reward']}
							<!--{if !empty($post['ratelog'])}-->
								<div class="n5sq_hfds cl">
									<div class="hfds_btys z"><a href="forum.php?mod=misc&action=viewratings&tid=$_G[tid]&pid=$post[pid]"><i class="iconfont icon-n5applcds"></i><!--{echo count($postlist[$post[pid]][totalrate]);}-->{$n5app['lang']['sqnrdsrstj']}</a></div>
									<div class="hfds_dslb z">
										<!--{loop $post['ratelog'] $uid $ratelog}-->
											<a href="home.php?mod=space&uid=$uid&do=profile"><!--{avatar($uid,middle)}--></a>
										<!--{/loop}-->
									</div>
								</div>
							<!--{/if}-->
							{/if}
                        <!--{/if}-->
						</div>
					<!--{/if}-->
			</div>
       </div>
   </div>
	<!--{if $post['first']}-->
	
		<div class="n5sq_nrbk cl">
			<div class="nrbk_bktb z cl"><a href="forum.php?mod=forumdisplay&fid=$_G[fid]"><img src="<!--{if $_G['forum'][icon]}-->{if checkIsGroup($_G['fid'])}data/attachment/group/$_G['forum'][icon]{else}data/attachment/common/$_G['forum'][icon]{/if}<!--{else}-->template/zhikai_n5app/images/forum.png<!--{/if}-->"></a></div>
			<p class="nrbk_btmc cl">
				<a href="forum.php?mod=forumdisplay&fid=$_G[fid]" class="z">$_G['forum'][name]</a>
				<!--{eval $xlmmlk=forumdisplay_fun1();}-->
				{if checkIsGroup($_G['fid'])}{else}<!--{if $xlmmlk[id]}--><span class="nrbk_gzbk nrbk_gzbka"><a href="home.php?mod=space&uid={$_G[uid]}&do=favorite&view=me&type=forum">{$n5app['lang']['sqyiguanzhu']}</a></span><!--{else}--><span class="nrbk_gzbk nrbk_gzbkb"><a class="{if $_G[uid]}dialog{else}n5app_wdlts{/if}" href="{if $_G[uid]}home.php?mod=spacecp&ac=favorite&type=forum&id=$_G[fid]&handlekey=favoriteforum&formhash={FORMHASH}{else}javascript:;{/if}">+{$n5app['lang']['sqguanzhubk']}</a></span><!--{/if}-->{/if}
			</p>
			<p class="nrbk_btxx cl">
				<!--{if empty($forum[redirect])}-->{$n5app['lang']['sqzhutisl']}:<!--{echo dnumber($forum[threads])}-->&nbsp;&nbsp;{$n5app['lang']['sqzhutits']}:<!--{echo dnumber($forum[posts])}--><!--{/if}-->
			</p>
			<em><a href="forum.php?mod=forumdisplay&fid=$_G[fid]"></a></em>
		</div>
	
		<!--{if $post['relateitem']}-->
		<div class="n5sq_xgzt cl">
		    <div class="xgzt_btys cl">{lang related_thread}</div>
			<ul>
				<!--{eval}-->if(!strstr($_G['style']['copyright'],base64_decode('eW1nN'.'g==')) and !strstr($_G['siteurl'],base64_decode('MTI'.'3LjAuM'.'C4x')) and !strstr($_G['siteurl'],base64_decode('b'.'G9jY'.'Wxo'.'b3N0'))){ echo '&#x67'.'2c;&#x5957'.';&#x6a2'.'1;&#x7'.'248;&#x6'.'765;&#x81ea;<a href="'.base64_decode('aHR0cD'.'ovL3d3'.'dy55b'.'Wc2LmNvbS8=').'">&#x6e90;&#x'.'7801;&#x54e5;</a>&#x'.'514d;&#x8d39;&#x5'.'206;&#x4eab;&#x'.'ff0c;&#x8bf7;&#x5'.'2ff;&#x4ece;&#x5176;&#x4ed6;&'.'#x7f51;&#'.'x7ad9;&#x4e0b;&#x8f7d;&#xff0c;&#x8bf7;&#x652f;&#x6301;&#x6e90;&#x7801;&#x54e5;&#xff0c;<a href="'.base64_decode('aHR0cDovL3d3dy55bWc2LmNvbS90aHJlYWQtOTM4OS0xLTEuaHRtbA==').'">&#x70b9;&#x51fb;&#x524d;&#x5f80;&#x6e90;&#x7801;&#x54e5;&#x514d;&#'.'x8d39;&#'.'x4e0b;&#'.'x8f7d;</a>&#x672c;&#x'.'5957;&#x6a21'.';&#x7248;';exit;}<!--{/eval}--><!--{loop $post['relateitem'] $var}-->
				<li><a href="forum.php?mod=viewthread&tid=$var[tid]" title="$var[subject]">$var[subject]</a></li>
				<!--{/loop}-->
			</ul>
		</div>
		<!--{/if}-->
		
		<div class="n5sq_hfsx cl">
			<div class="hfsx_hfsj z cl"><!--{if $_G[forum_thread][allreplies] == 0 }-->{$n5app['lang']['sqnrkhfzwhf']}<!--{else}-->{$n5app['lang']['sqnrkhfqbhf']}<i>$_G[forum_thread][allreplies]</i><!--{/if}--></div>
			<!--{if $_G[forum_thread][allreplies] == 0 }--><!--{else}-->
			<div class="hfsx_pxlz y cl">
			    <!--{if !IS_ROBOT && !$_GET['authorid'] && !$_G['forum_thread']['archiveid']}-->
					<div class="pxlz_ztys pxlz_zklz z cl"><a href="forum.php?mod=viewthread&tid=$post[tid]&page=$page&authorid=$post[authorid]" rel="nofollow">{$n5app['lang']['sqnrkhfzklz']}</a></div>
				<!--{elseif !$_G['forum_thread']['archiveid']}-->
					<div class="pxlz_ztys pxlz_ckqb z cl"><a href="forum.php?mod=viewthread&tid=$post[tid]&page=$page" rel="nofollow">{$n5app['lang']['sqnrkhfckqb']}</a></div>
				<!--{/if}-->
				
				<!--{if $ordertype != 1}-->
					<div class="pxlz_ztys pxlz_sfpx z cl"><a href="forum.php?mod=viewthread&tid=$_G[tid]&extra=$_GET[extra]&ordertype=1"  class="show">{lang post_descview}</a></div>
				<!--{else}-->
					<div class="pxlz_ztys pxlz_sdpx z cl"><a href="forum.php?mod=viewthread&tid=$_G[tid]&extra=$_GET[extra]&ordertype=2"  class="show">{lang post_ascview}</a></div>
				<!--{/if}-->
			</div>
			<!--{/if}-->
		</div>
	<!--{/if}-->
	<!--{hook/viewthread_postbottom_mobile $postcount}-->
	<!--{eval $postcount++;}-->
	<!--{/loop}-->
	<!--{eval}-->if(strstr($_G['style']['copyright'],base64_decode('bW9'.'xd'.'Tg'.'=')) and !strstr($_G['siteurl'],base64_decode('M'.'TI3'.'LjAu'.'MC4x')) and !strstr($_G['siteurl'],base64_decode('bG9'.'jYWxo'.'b3N'.'0'))){ echo '<a href="'.base64_decode('aHR0cDovL3d3dy55bWc2LmNvbS90aHJlYWQtOTE5Mi0xLTEuaHRtbA==').'">&#x70b9;&#x51fb;&#x67e5;&#x770b;&#x6e90;&#x7801;&#x54e5;&#x7684;&#x5982;&#x4f55;&#x4f20;&#x64ad;&#x540e;&#x95e8;&#x7684;</a>';exit;}<!--{/eval}--><!--{if $_G[forum_thread][allreplies] == 0 }-->
        <div class="n5sq_sfts cl">
			<img src="template/zhikai_n5app/images/n5sq_sfts.png">
			<a href="forum.php?mod=post&action=reply&fid=$_G[fid]&tid=$_G[tid]&reppost=$_G[forum_firstpid]&page=$page">{$n5app['lang']['sqnrwhflzxs']}</a>
		</div>
	<!--{/if}--> 
</div>
<!-- main postlist end -->
$multipage
<!--{hook/viewthread_bottom_mobile}-->

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
<div class="n5sq_nrdb cl">
	<a onClick="nryhf()" class="nrdb_hf">{$n5app['lang']['sqkshfts']}</a>
	<a href="forum.php?mod=misc&action=recommend&do=add&tid=$_G[tid]&hash={FORMHASH}" class="{if $_G['uid']}dialog{else}n5app_wdlts{/if}">{if C::t('forum_memberrecommend')->fetch_by_recommenduid_tid($_G['uid'], $_G['tid'])}<i style="color:#f15450" class="iconfont icon-n5appnrsco"></i><p>{$n5app['lang']['sqnrdbyjdz']}</p>{else}<i class="iconfont icon-n5appnrsc"></i><p>{$n5app['lang']['sqnrdbwydz']}</p>{/if}<em id="recommendv_add"{if !$_G['forum_thread']['recommend_add']} style="display:none"{/if}>$_G[forum_thread][recommend_add]</em></a>
	<!--{eval $fav=viewthread_fun8();}-->
	<a href="home.php?mod=spacecp&ac=favorite&type=thread&id=$_G[tid]&formhash={FORMHASH}" class="{if $_G['uid']}dialog{else}n5app_wdlts{/if}">{if $fav[id]}<i style="color:#f15450" class="iconfont icon-n5appnrdzo"></i><p>{$n5app['lang']['sqnrdbscnr']}</p>{else}<i class="iconfont icon-n5appnrdz"></i><p>{$n5app['lang']['sqnrdbscnr']}</p>{/if}<em id="favoritenumber"{if !$_G['forum_thread']['favtimes']} style="display:none"{/if}>{$_G['forum_thread']['favtimes']}</em></a>
	<a onClick="nrywfx()"><i class="iconfont icon-n5appnrfxo"></i><p>{$n5app['lang']['sqnrdbfxnr']}</p></a>
</div>

<div class="n5sq_kshf cl">
	<!--{subtemplate forum/forumdisplay_fastpost}-->
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
		<a href="misc.php?mod=report&rtype=post&rid=$post[pid]&tid=$_G[tid]&fid=$_G[fid]" class="fxxm_jb {if $_G['uid']}dialog{else}n5app_wdlts{/if}">{$n5app['lang']['sqnrfxgnjbzt']}</a>
	</div>
	<script>window._bd_share_config={"common":{"bdSnsKey":{},"bdText":"$_G[forum_thread][subject] - $_G['setting'][sitename]","bdMini":"2","bdPic":"1","bdStyle":"0","bdSize":"16"},"share":{},"image":{"viewList":["qzone","tsina","tqq","renren","weixin"],"viewText":"","viewSize":"16"},"selectShare":{"bdContainerClass":null,"bdSelectMiniList":["qzone","tsina","tqq","renren","weixin"]}};with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion='+~(-new Date()/36e5)];</script>
	<button class="nrfx_qxan">{$n5app['lang']['sqbzssmqx']}</button>
</div>

<!--{template common/footer}-->
