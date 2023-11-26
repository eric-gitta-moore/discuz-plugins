<?PHP exit('QQÈº£º550494646');?>
<style>
.ainuo_viewbi,.ainuo_vtitle{ display:none;}
</style>
<script type="text/javascript">var fid = parseInt('$_G[fid]'), tid = parseInt('$_G[tid]');</script>

<!-- header start -->
    <div class="header">
        <div class="nav">
            <a href="#" class="z back"><i class="iconfont icon-back"></i></a>	
			<span class="name">$alang_content</span>
            <a id="avmenu" href="javascript:;" class="y"><i class="iconfont icon-more"></i></a>
            <!--{subtemplate common/view_right}-->
        </div>
    </div>
    <!--{template common/top_fix}-->
<!-- header end -->



<!--{hook/viewthread_top_mobile}-->
<!-- main postlist start -->
<div class="postlist ainuoloadmore" id="ainuoloadmore">
	<!--{eval $postcount = 0;}-->
	<!--{loop $postlist $post}-->
	<!--{eval $needhiddenreply = ($hiddenreplies && $_G['uid'] != $post['authorid'] && $_G['uid'] != $_G['forum_thread']['authorid'] && !$post['first'] && !$_G['forum']['ismoderator']);}-->
	<!--{hook/viewthread_posttop_mobile $postcount}-->
    	
   <div class="{if $post['first']}plc{else}plcnotfirst{/if}" id="pid$post[pid]" {if $post[first]} style="border-bottom:none;"{/if}>
       <!--{if $post[first]}-->
       
       
       	<div class="ainuo_vtitle cl">
        	<div class="tit cl">
                <h1>$_G[forum_thread][subject]</h1>
                <!--{if (($_G['forum']['ismoderator'] && $_G['group']['alloweditpost'] && (!in_array($post['adminid'], array(1, 2, 3)) || $_G['adminid'] <= $post['adminid'])) || ($_G['forum']['alloweditpost'] && $_G['uid'] && ($post['authorid'] == $_G['uid'] && $_G['forum_thread']['closed'] == 0) && !(!$alloweditpost_status && $edittimelimit && TIMESTAMP - $post['dbdateline'] > $edittimelimit)))}-->
					<a class="titedit" href="forum.php?mod=post&action=edit&fid=$_G[fid]&tid=$_G[tid]&pid=$post[pid]{if !empty($_GET[modthreadkey])}&modthreadkey=$_GET[modthreadkey]{/if}&page=$page"><!--{if $_G['forum_thread']['special'] == 2 && !$post['message']}--><!--{else}-->{lang edit}<!--{/if}--></a>
                    <!--{if $_G['forum']['ismoderator']}-->
						<a href="javascript:;" class="titedit" onclick="ainuo_adminmanage('$post[pid]')">{lang manage}</a>
					<!--{/if}-->
					<!--{/if}-->
                    <!--{if $_G['forum_thread'][displayorder] == -2}--> <span>({lang moderating})</span>
                    <!--{elseif $_G['forum_thread'][displayorder] == -3}--> <span>({lang have_ignored})</span>
                    <!--{elseif $_G['forum_thread'][displayorder] == -4}--> <span>({lang draft})</span>
                    <!--{/if}-->
            </div>
            
                
        </div>
        <div class="ainuo_avatar cl">
           <div class="ava"><a href="{if $_G[uid] == $post[authorid]}home.php?mod=space&uid={$post[authorid]}&do=profile&mycenter=1{else}home.php?mod=space&uid={$post[authorid]}&do=profile{/if}"><img src="<!--{if !$post['authorid'] || $post['anonymous']}--><!--{avatar(0, middle, true)}--><!--{else}--><!--{avatar($post[authorid], middle, true)}--><!--{/if}-->" /></a></div>
           <div class="info cl">
                <h3>
                    <!--{if $post['authorid'] && $post['username'] && !$post['anonymous']}-->
                        <a href="{if $_G[uid] == $post[authorid]}home.php?mod=space&uid={$post[authorid]}&do=profile&mycenter=1{else}home.php?mod=space&uid={$post[authorid]}&do=profile{/if}" {if $post[groupcolor]} style="color: $post[groupcolor]"{/if}>$post[author]</a> $authorverifys
                        <span class="ainuo_first_level">Lv.$post['stars'] $post[authortitle]</span>
                        {if $post['gender'] == 1}
                        <i class="iconfont icon-male ainuo_first_genderm"></i>
                        {/if}
                        {if $post['gender'] == 2}
                        <i class="iconfont icon-female ainuo_first_gendern"></i>
                        {/if}
                        
                    <!--{else}-->
                        <!--{if !$post['authorid']}-->
                        <a href="javascript:;">{lang guest} <em>$post[useip]{if $post[port]}:$post[port]{/if}</em></a>
                        <!--{elseif $post['authorid'] && $post['username'] && $post['anonymous']}-->
                        <!--{if $_G['forum']['ismoderator']}--><a href="home.php?mod=space&uid=$post[authorid]">{lang anonymous}</a><!--{else}-->{lang anonymous}<!--{/if}-->
                        <!--{else}-->
                        $post[author] <em>{lang member_deleted}</em>
                        <!--{/if}-->
                    <!--{/if}-->
                   
                    <a href="home.php?mod=space&do=pm&subop=view&touid=$post[authorid]" class="lxmj ainuo_nologin y" style="color:#f30;">$alang_lxmj</a>
                </h3>
                <div class="cl">
                	<span class="z atopsecg">$post[dateline]</span>
                </div>
           </div>
       </div>
       
		<!--{else}-->
        <span class="avatar"><img src="<!--{if !$post['authorid'] || $post['anonymous']}--><!--{avatar(0, middle, true)}--><!--{else}--><!--{avatar($post[authorid], middle, true)}--><!--{/if}-->" /></span>
		<!--{/if}-->
        
       <div class="display pi {if $post[first]}piauthor{else}reply_grey{/if}" href="#replybtn_$post[pid]">
			{if !$post[first]}
               <ul class="authi">
                    <li class="grey">
                        
                        <!--{if $_G['forum']['ismoderator']}-->
                        <!-- manage start -->
                           <a href="javascript:;" class="v_manage" onclick="ainuo_replyselect('$post[pid]')"><i class="iconfont icon-moreandroid"></i></a>
                            
                        <!-- manage end -->  
                        <!--{/if}-->
                        <!--{if $allowpostreply}-->
							<a id="replybtn_$post[pid]" class="v_reply" href="forum.php?mod=post&action=reply&fid=$_G[fid]&tid=$_G[tid]&repquote=$post[pid]&extra=$_GET[extra]&page=$page"><i class="iconfont icon-mark"></i></a>
                        <!--{/if}-->
                        <!--{if !$_G['forum_thread']['special'] && !$rushreply && !$hiddenreplies && $_G['setting']['repliesrank'] && !$post['first'] && !($post['isWater'] && $_G['setting']['filterednovote'])}-->
                        <a class="y listzan external" href="javascript:;" onclick="listzan('$post[pid]')"><span id="review_support_$post[pid]">$post[postreview][support]</span><i class="iconfont icon-appreciate_light"></i></a>
                        <!--{/if}-->
                        
                        <!--{if $post['authorid'] && $post['username'] && !$post['anonymous']}-->
                            <a class="ausize" href="{if $_G[uid] == $post[authorid]}home.php?mod=space&uid={$post[authorid]}&do=profile&mycenter=1{else}home.php?mod=space&uid={$post[authorid]}&do=profile{/if}" {if $post[groupcolor]} style="color: $post[groupcolor]"{/if}>$post[author]</a> $authorverifys
						<span class="ainuo_first_level">Lv.$post['stars']</span>
                        <!--{eval $_self = $thread['author'] && $post['author'] == $thread['author'] && $post['position'] !== '1';}-->
                        <!--{if $_self}-->
                            <span class="ainuo_first_louzhu">{lang thread_author}</span>
                        <!--{/if}-->
                        <!--{if $post['gender'] == 1}-->
                        <i class="iconfont icon-male ainuo_first_genderm"></i>
                        <!--{/if}-->
                        <!--{if $post['gender'] == 2}-->
                        <i class="iconfont icon-female ainuo_first_gendern"></i>
                        <!--{/if}-->
                        <!--{else}-->
                            <!--{if !$post['authorid']}-->
                            <a href="javascript:;">{lang guest} <em>$post[useip]{if $post[port]}:$post[port]{/if}</em></a>
                            <!--{elseif $post['authorid'] && $post['username'] && $post['anonymous']}-->
                            <!--{if $_G['forum']['ismoderator']}--><a href="home.php?mod=space&uid=$post[authorid]">{lang anonymous}</a><!--{else}-->{lang anonymous}<!--{/if}-->
                            <!--{else}-->
                            $post[author] <em>{lang member_deleted}</em>
                            <!--{/if}-->
                        <!--{/if}-->
                    </li>
                    <li class="grey rely">
                        <span class="atopsecg">$post[dateline]&nbsp;<!--{if $post['status'] & 8}--><!--{if $_G['setting']['mobile']['mobilecomefrom']}-->{$_G['setting']['mobile']['mobilecomefrom']}<!--{else}-->{lang from_mobile}<!--{/if}--><!--{/if}--></span>
                        
                    </li>
                </ul>
            {/if}
			<div {if !$post[first]}class="huifusize message"{else}class="message"{/if}>
                	
                    <!--{if !$post['first'] && !empty($post[subject])}-->
                        <h2><strong>$post[subject]</strong></h2>
                    <!--{/if}-->
                    <!--{if $_G['adminid'] != 1 && $_G['setting']['bannedmessages'] & 1 && (($post['authorid'] && !$post['username']) || ($post['groupid'] == 4 || $post['groupid'] == 5) || $post['status'] == -1 || $post['memberstatus'])}-->
                        <div class="grey ainuo_vquote">{lang message_banned}</div>
                    <!--{elseif $_G['adminid'] != 1 && $post['status'] & 1}-->
                        <div class="grey ainuo_vquote">{lang message_single_banned}</div>
                    <!--{elseif $needhiddenreply}-->
                        <div class="grey ainuo_vquote">{lang message_ishidden_hiddenreplies}</div>
                    <!--{elseif $post['first'] && $_G['forum_threadpay']}-->
						<!--{template forum/viewthread_pay}-->
					<!--{else}-->

                    	<!--{if $_G['setting']['bannedmessages'] & 1 && (($post['authorid'] && !$post['username']) || ($post['groupid'] == 4 || $post['groupid'] == 5))}-->
                            <div class="grey ainuo_vquote">{lang admin_message_banned}</div>
                        <!--{elseif $post['status'] & 1}-->
                            <div class="grey ainuo_vquote">{lang admin_message_single_banned}</div>
                        <!--{/if}-->
                        <!--{if $_G['forum_thread']['price'] > 0 && $_G['forum_thread']['special'] == 0}-->
                            {lang pay_threads}: <strong>$_G[forum_thread][price] {$_G['setting']['extcredits'][$_G['setting']['creditstransextra'][1]][unit]}{$_G['setting']['extcredits'][$_G['setting']['creditstransextra'][1]][title]} </strong> <a href="forum.php?mod=misc&action=viewpayments&tid=$_G[tid]" >{lang pay_view}</a>
                        <!--{/if}-->
                        
                        <!--{if $post['first'] && $threadsort && $threadsortshow}-->
                        	<!--{if $threadsortshow['typetemplate']}-->
                                $threadsortshow[typetemplate]
                            <!--{elseif $threadsortshow['optionlist']}-->
                                <div class="ainuo_typeoption">
                                    <!--{if $threadsortshow['optionlist'] == 'expire'}-->
                                        {lang has_expired}
                                    <!--{else}-->
                                        <div class="ainuo_cgtl">
                                            {eval $aso = 1;}
                                            <!--{loop $threadsortshow['optionlist'] $option}-->
                                            {eval $aso++;}
                                                <!--{if $option['type'] != 'info'}-->
                                                    <dl class="cl" {if $aso % 2 == 0} style="background:#f8f8f8;"{/if}>
                                                        <dt>$option[title]:</dt>
                                                        
                                                        <dd><!--{if $option['value'] !== ''}-->$option[value] $option[unit]<!--{else}-->-<!--{/if}--></dd>
                                                    </dl>
                                                <!--{/if}-->
                                            <!--{/loop}-->
                                        </div>
                                        
                                    <!--{/if}-->
                                </div>
                            <!--{/if}-->
                        <!--{/if}-->
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
							
                        <!--{else}-->
                        
                            $post[message]
                        <!--{/if}-->

					<!--{/if}-->
                    
                    <!--{if $_G['forum_thread']['special'] == 3 && ($_G['forum']['ismoderator'] && (!$_G['setting']['rewardexpiration'] || $_G['setting']['rewardexpiration'] > 0 && ($_G[timestamp] - $_G['forum_thread']['dateline']) / 86400 > $_G['setting']['rewardexpiration']) || $_G['forum_thread']['authorid'] == $_G['uid']) && $post['authorid'] != $_G['forum_thread']['authorid'] && $post['first'] == 0 && $_G['uid'] != $post['authorid'] && $_G['forum_thread']['price'] > 0}-->
                        <p class="ainuo_bestanw cl"><a class="formdialog" href="javascript:;" onclick="setanswer($post['pid'], '$_GET[from]')">$alang_bestanw</a></p>
                    <!--{/if}-->
			</div>
			<!--{if $_G['setting']['mobile']['mobilesimpletype'] == 0}-->
			<!--{if $post['attachment']}-->
               <div class="grey ainuo_vquote">
               {lang attachment}: <em><!--{if $_G['uid']}-->{lang attach_nopermission}<!--{else}-->{lang attach_nopermission_login}<!--{/if}--></em>
               </div>
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
			
       </div>
   </div>
   {if $post[first]}
   		<div class="ainuo_viewbi cl">
                <!--{if ($post[tags] || $relatedkeywords) && $_GET['from'] != 'preview'}-->
                        <!--{if $post[tags]}-->
                        <div class="av_tag cl">
                            <!--{eval $tagi = 0;}-->
                            $alang_tag:
                            <!--{loop $post[tags] $var}-->
                                <!--{if $tagi}-->, <!--{/if}--><a title="$var[1]" href="misc.php?mod=tag&id=$var[0]">$var[1]</a>
                                <!--{eval $tagi++;}-->
                            <!--{/loop}-->
                         </div>
                        <!--{/if}-->
                        <!--{if $relatedkeywords}--><span>$relatedkeywords</span><!--{/if}-->
                <!--{/if}-->
               
                <!--{if ($_G['group']['allowrecommend'] || !$_G['uid']) && $_G['setting']['recommendthread']['status']}-->
                    <div class="view_bot_zan cl">
                        <div class="yizan cl">
                            <div class="addlist_box cl">
                                <a href="javascript:;" class="ainuozan"><em>$alang_zan</em></a>
                                <a href="forum.php?mod=misc&action=rate&tid=$_G[tid]&pid=$post[pid]" class="ainuoping"><em>$alang_shang</em></a>
                            </div>
                        </div>
                        
                    </div>
                   
                <!--{/if}-->
                <!--{if $_G['group']['raterange'] && $post['authorid']}-->
                    <!--{subtemplate forum/rate_con}-->
                <!--{/if}-->
        </div>
        <!--{if $dataad[ad_viewthread2]}-->$dataad[ad_viewthread2]<!--{/if}-->
   		<div class="cl" style="background:#f3f3f3; height:10px; border-top:1px solid #dedede;"></div>
        <!--{if $post['relateitem']}-->
			<div class="anuo_relate_post cl">
				<h2>{lang related_thread}</h2>
				<ul class="cl">
                	<!--{eval $rel_key = 0}-->
					<!--{loop $post['relateitem'] $var}-->
                    <!--{eval $rel_key++}-->
					<li><span class="span_{$rel_key}">{$rel_key}</span><a href="forum.php?mod=viewthread&tid=$var[tid]" title="$var[subject]">$var[subject]</a></li>
					<!--{/loop}-->
				</ul>
			</div>
            <div class="cl" style="background:#f3f3f3; height:10px; border-top:1px solid #dedede;"></div>
		<!--{/if}-->
		<div class="reply_bot cl">
			<div class="replytit cl">
            	<span>$alang_reply $allreply</span>
                <!--{if !$rushreply}-->
                    <!--{if $ordertype != 1}-->
                        <a href="forum.php?mod=viewthread&tid=$_G[tid]&extra=$_GET[extra]&ordertype=1"><i class="iconfont icon-order"></i>{lang post_descview}</a>
                    <!--{else}-->
                        <a href="forum.php?mod=viewthread&tid=$_G[tid]&extra=$_GET[extra]&ordertype=2"><i class="iconfont icon-order"></i>{lang post_ascview}</a>
                    <!--{/if}-->
                <!--{/if}-->
            </div>
            
            {if !$allreply}
            <div class="ccon cl">
            	<p><i class="iconfont icon-empty"></i></p>
            	$alang_replysofa
            </div>
            {/if}
		</div>
   {/if}
   <!--{hook/viewthread_postbottom_mobile $postcount}-->
   <!--{eval $postcount++;}-->
   <!--{/loop}-->

</div>
<div id="post_new"></div>
<!-- main postlist end -->
<div id="ainuoloadempty"></div>
{if $_G['ppp'] < $allreply}
<div id="loading" class="loading G-animate-load-wrap">
    <div class="load-loading"><span class="loading02"></span> <span class="load-word">$alang_loading</span></div>
</div>
{/if}
<!--{hook/viewthread_bottom_mobile}-->


<form method="post" autocomplete="off" name="modactions" id="modactions">
	<input type="hidden" name="formhash" value="{FORMHASH}" />
	<input type="hidden" name="optgroup" />
	<input type="hidden" name="operation" />
	<input type="hidden" name="listextra" value="$_GET[extra]" />
	<input type="hidden" name="page" value="$page" />
</form>

<!--{subtemplate forum/forumdisplay_fastpost}-->

<script type="text/javascript">
$('.favbtn').on('click', function() {
	<!--{if !$_G[uid]}-->
		popup.open('{lang nologin_tip}', 'confirm', 'member.php?mod=logging&action=login');
		return false;
	<!--{/if}-->
	Zepto('.page').append('<div class="ainuooverlay"><div class="preloader-indicator-overlay"></div><div class="preloader-indicator-modal"><span class="preloader preloader-white"></span></div></div>');
	var obj = $(this);
	$.ajax({
		type:'POST',
		url:'home.php?mod=spacecp&ac=favorite&type=thread&id=$_G[tid]&handlekey=favbtn&inajax=1',
		data:{'favoritesubmit':'true', 'formhash':'{FORMHASH}'},
		dataType:'xml',
	})
	.success(function(s) {
		if(s.lastChild.firstChild.nodeValue.indexOf("$alang_haveshoucang") >= 0){
			Zepto('.ainuooverlay').remove();
			Zepto.toast('$alang_haveshoucang',1000,'toast');
		}else if(s.lastChild.firstChild.nodeValue.indexOf("$alang_havescsucccess") >= 0){
			Zepto('.ainuooverlay').remove();
			Zepto.toast('$alang_havescsucccess2',1000,'toast');
		}
	})
	.error(function() {
		window.location.href = obj.attr('href');
		Zepto('.ainuooverlay').remove();
	});
	return false;
});
function listzan(apid) {
	<!--{if !$_G[uid]}-->
		popup.open('{lang nologin_tip}', 'confirm', 'member.php?mod=logging&action=login');
		return false;
	<!--{/if}-->
	var obj = $(this);
	popup.open('<div class="ainuooverlay"><div class="preloader-indicator-overlay"></div><div class="preloader-indicator-modal"><span class="preloader preloader-white"></span></div></div>');
	$.ajax({
		type : 'GET',
		url : 'forum.php?mod=misc&action=postreview&do=support&tid=$_G[tid]&pid='+apid+'&hash={FORMHASH}&inajax=1',
		dataType : 'xml'
	})
	.success(function(s) {
		if(s.lastChild.firstChild.nodeValue.indexOf("$alang_nbntp") >= 0){
			popup.close();
			Zepto.toast('$alang_nbndzo',1000,'toast');
		}else if(s.lastChild.firstChild.nodeValue.indexOf("$alang_nyjtp") >= 0){
			popup.close();
			Zepto.toast('$alang_nyjzg',1000,'toast');
		}else{
			popup.close();
			Zepto.toast('$alang_dzcg',1000,'toast');
			
			if(document.getElementById("review_support_"+apid).innerHTML){
				setTimeout((document.getElementById("review_support_"+apid).innerHTML = parseInt(document.getElementById("review_support_"+apid).innerHTML) + 1),500);
			}else{
				document.getElementById("review_support_"+apid).innerHTML = 1;
			}
		}
		
	})
	
	.error(function() {
		window.location.href = obj.attr('href');
		popup.close();
	});
	
	return false;
	
};
$('.ainuozan').on('tap', function() {
	<!--{if !$_G[uid]}-->
		popup.open('{lang nologin_tip}', 'confirm', 'member.php?mod=logging&action=login');
		return false;
	<!--{/if}-->
	var obj = $(this);
	Zepto('.page').append('<div class="ainuooverlay"><div class="preloader-indicator-overlay"></div><div class="preloader-indicator-modal"><span class="preloader preloader-white"></span></div></div>');
	$.ajax({
		type : 'GET',
		url:'forum.php?mod=misc&action=recommend&do=add&tid=$_G[tid]&hash={FORMHASH}&inajax=1',
		dataType : 'xml'
	})
	.success(function(s) {
		if(s.lastChild.firstChild.nodeValue.indexOf("$alang_yipingjia") >= 0){
			Zepto('.ainuooverlay').remove();
			Zepto.toast('$alang_dianzanguo',1000,'toast');
		}else if(s.lastChild.firstChild.nodeValue.indexOf("$alang_zanjiayi") >= 0){
			setTimeout((document.getElementById("ainuozannum").innerHTML = parseInt(document.getElementById("ainuozannum").innerHTML) + 1),500);
			Zepto('.ainuooverlay').remove();
			Zepto.toast('$alang_zanjiayi2',1000,'toast');
		}
	})
	return false;
	
});

function setanswer(pid, from){
	if(confirm('$alang_zjda')){
		document.getElementById('modactions').action='forum.php?mod=misc&action=bestanswer&tid=' + tid + '&pid=' + pid + '&from=' + from + '&bestanswersubmit=yes';
		var obj = $('#modactions');
		$.ajax({
			type:'POST',
			url:obj.attr('action') + '&inajax=1',
			data:obj.serialize(),
			dataType:'xml'
		})
		.success(function(s) {
			popup.open(s.lastChild.firstChild.nodeValue);
			evalscript(s.lastChild.firstChild.nodeValue);
		})
		.error(function() {
			window.location.href = obj.attr('href');
			popup.close();
		});		
	}
};

function ainuo_replyselect(pid) {
	var buttons1 = [
	  {
		text: '$alang_pleseselect',
		label: true
	  },
	  {
		text: '{lang edit}',
		onClick: function() {
			window.location.href = 'forum.php?mod=post&action=edit&fid=$_G[fid]&tid=$_G[tid]&pid='+pid+'{if !empty($_GET[modthreadkey])}&modthreadkey=$_GET[modthreadkey]{/if}&page=$page';
		}
	  },
	  <!--{if $_G['group']['allowdelpost']}-->
	  {
		text: '{lang modmenu_deletepost}',
		onClick: function() {
			var deleteurl = 'forum.php?mod=topicadmin&action=delpost&fid={$_G[fid]}&tid={$_G[tid]}&operation=&optgroup=&page=&topiclist[]='+pid;
			ainuoajax(deleteurl);
		}
	  },
	  <!--{/if}-->
	];
	var buttons2 = [
	  {
		text: '{lang cancel}',
		bg: 'danger'
	  }
	];
	var groups = [buttons1, buttons2];
	Zepto.actions(groups);
};
function ainuo_adminmanage(pid) {
	var buttons1 = [
	  {
		text: '$alang_pleseselect',
		label: true
	  },
	  {
		text: '{lang delete}',
		onClick: function() {
			var adeleteurl = 'forum.php?mod=topicadmin&action=moderate&fid={$_G[fid]}&moderate[]={$_G[tid]}&operation=delete&optgroup=3&from={$_G[tid]}';
			ainuoajax(adeleteurl);
		}
	  },
	  {
		text: '{lang close}',
		onClick: function() {
			var acloseurl = 'forum.php?mod=topicadmin&action=moderate&fid={$_G[fid]}&moderate[]={$_G[tid]}&from={$_G[tid]}&optgroup=4';
			ainuoajax(acloseurl);
		}
	  },
	];
	var buttons2 = [
	  {
		text: '{lang cancel}',
		bg: 'danger'
	  }
	];
	var groups = [buttons1, buttons2];
	Zepto.actions(groups);
};

function ainuoajax(aurl){
	Zepto('.page').append('<div class="ainuooverlay"><div class="preloader-indicator-overlay"></div><div class="preloader-indicator-modal"><span class="preloader preloader-white"></span></div></div>');
	$.ajax({
		type : 'GET',
		url: aurl,
		dataType : 'xml'
	})
	.success(function(s) {
		popup.open(s.lastChild.firstChild.nodeValue);
		evalscript(s.lastChild.firstChild.nodeValue);
		Zepto('.ainuooverlay').remove();
	})
	.error(function() {
		Zepto('.ainuooverlay').remove();
		Zepto.toast('$alang_pleasetye',1000,'toast');
	});
	return false;
}
</script>

