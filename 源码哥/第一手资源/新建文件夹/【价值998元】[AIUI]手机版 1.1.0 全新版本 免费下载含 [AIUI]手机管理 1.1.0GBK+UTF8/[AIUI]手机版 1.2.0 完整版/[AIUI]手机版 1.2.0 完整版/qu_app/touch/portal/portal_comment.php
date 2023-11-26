<?PHP exit('QQÈº£º550494646');?>
<script type="text/javascript">
	function reply(obj){
		var o = $(obj).parent().parent().find('.tt_wenzhang_pinglun_list_repect');
		o.show();
		o.find("textarea").focus();
	}
	function noreply(obj){
		var o = $(obj).closest('.tt_wenzhang_pinglun_list_repect');
		o.hide();
	}

	function helc(){
		window.location.href='$_SERVER['REQUEST_URI']'+'#comment';
		window.location.reload();
	}
</script>

<div class="ainuo_newpost">
	<h2>$alang_newreply</h2>
	<ul>
    <!--{if $article[commentnum]}-->
		<!--{loop $commentlist $comment}-->
		<li>
            <a href="home.php?mod=space&uid={$comment[uid]}&do=profile{if $_G[uid] == $comment[uid]}&mycenter=1{else}{/if}" class="auth"><!--{avatar($comment[uid], 'middle')}--></a>
			<div class="list_des">
				
				<div class="ainfo">
                	<span>$comment[username]</span><span><!--{date($comment[dateline])}--></span>
                      
                        <!--{if ($_G['group']['allowmanagearticle'] || $_G['uid'] == $comment['uid']) && $_G['groupid'] != 7 && !$article['idtype']}-->
                        <a ainuoto="portal.php?mod=portalcp&ac=comment&op=edit&cid=$comment[cid]" id="c_$comment[cid]_edit" class="ainuodialog" style="display:none;">{lang edit}</a>
                        <a ainuoto="portal.php?mod=portalcp&ac=comment&op=delete&cid=$comment[cid]" id="c_$comment[cid]_delete"  class="ainuodialog">{lang delete}</a>
                        <!--{/if}-->
                </div>
				<div class="atit">
                	<!--{if $_G[adminid] == 1 || $comment[uid] == $_G[uid] || $comment[status] != 1}-->$comment[message]<!--{else}--> {lang moderate_not_validate}<!--{/if}-->
				</div>
				{eval $hasc = 0;}
				<!--{loop $subcommets $subcomment}-->
				{if ($subcomment[parentid] && $subcomment[parentid]==$comment[cid]) || ($comment[pid] && $subcomment[pid]==$comment[pid]) }
					{eval $hasc = 1;}
				{/if}
				<!--{/loop}-->
				{if $hasc ==1}
				<div class="tt_wenzhang_pinglun_list_c_list">
					<div class="tt_wenzhang_pinglun_list_c_list_icon"></div>                        	
					<dl>
						<!--{loop $subcommets $subcomment}-->
						{if ($subcomment[parentid] && $subcomment[parentid]==$comment[cid]) || ($comment[pid] && $subcomment[pid]==$comment[pid]) }
						<dd class="cl">
							<a href="/space-uid-{if $subcomment[uid]}$subcomment[uid]{else}$subcomment[authorid]{/if}.html" class="tt_wenzhang_pinglun_list_photo z" target="_blank">{if $subcomment[uid]}<!--{avatar($subcomment[uid], 'middle')}-->{else}<!--{avatar($subcomment[authorid], 'middle')}-->{/if}</a>
							<div class="tt_wenzhang_pinglun_list_des z">
								<a href="/space-uid-{if $subcomment[uid]}$subcomment[uid]{else}$subcomment[authorid]{/if}.html" class="tt_wenzhang_pinglun_list_name">{if $subcomment[username]}$subcomment[username]{else}$subcomment[author]{/if}</a>
								<span class="tt_wenzhang_pinglun_list_time"><!--{date($subcomment[dateline])}--></span>
								<div class="tt_wenzhang_pinglun_list_c"><!--{if $_G[adminid] == 1 || $subcomment[uid] == $_G[uid] || $subcomment[status] != 1}-->$subcomment[message]<!--{else}--> {lang moderate_not_validate}<!--{/if}--></div>                                   
							</div>
						</dd>
						{/if}
						<!--{/loop}-->
					</dl>
				</div>      
				{/if}
			</div>
			
		</li>
		
		
		<!--{if !empty($aimgs[$comment[cid]])}-->
			<script type="text/javascript" reload="1">aimgcount[{$comment[cid]}] = [<!--{echo implode(',', $aimgs[$comment[cid]]);}-->];attachimgshow($comment[cid]);</script>
		<!--{/if}-->
		<!--{/loop}-->
		<!--{if !empty($pricount)}-->
			<p class="mtn mbn y">{lang hide_portal_comment}</p>
		<!--{/if}-->
	<!--{else}-->
    <div class="emp"><p style="margin:0 20px;">$alang_replysofa</p></div>
    <!--{/if}-->
	</ul>
	
	{if $comment_total_page>1}
	<div class="tt_wenzhang_pinglun_more">
		<div class="tt_wenzhang_content_pager">
		<div class="tt_tiezi_list_page">
		{$commentpager}
		</div>
		</div>
		
	</div>
	{/if}
</div>
<style>
#afastreply .ainuo_facemenu{ padding:10px 0 0 0;}
</style>
<!--{if $_G['uid']}-->
<!--{eval $favid = DB::result_first('SELECT count(*) FROM '.DB::table('home_favorite').' WHERE id='.$article[aid].' and uid='.$_G[uid].'');}-->
<!--{else}-->
<!--{eval $favid = 0;}-->
<!--{/if}-->

<div class="article_bottom cl">
	<ul>
        <li><a href="javascript:;" class="ashare"><i class="iconfont icon-share"></i></a></li>
        <li><a href="home.php?mod=spacecp&ac=favorite&type=article&id=$article[aid]&handlekey=favoritearticlehk_{$article[aid]}" class="favbtn">{if !$favid}<i class="iconfont icon-favor"></i>{else}<i class="iconfont icon-favorfill" style="color:#ff9900;"></i>{/if}{if {$_G['forum_thread']['favtimes']}}{/if}</a></li>
		<li class="fastcon fastcon_a cl"><a href="javascript:;" id="fastcon"><i class="iconfont icon-write"></i><em>$alang_xpinglun</em></a></li>
	</ul>
</div>



<div id="afastreply" class="afastreply">
	<div class="afastreply_con">
		<form id="cform" name="cform" action="$form_url" method="post" autocomplete="off">
        	<div class="ainuowzhuifi cl">
			<textarea name="message" style="width:100%" placeholder="{lang send_reply_fast_tip}" rows="3" id="message"></textarea>
		
			<!--{if checkperm('seccode') && ($secqaacheck || $seccodecheck)}-->
				<!--{block sectpl}--><sec> <span id="sec<hash>" onclick="showMenu(this.id);"><sec></span><div id="sec<hash>_menu" class="p_pop p_opt" style="display:none"><sec></div><!--{/block}-->
				<div class="mtm"><!--{subtemplate common/seccheck}--></div>
			<!--{/if}-->
			<!--{if !empty($topicid) }-->
				<input type="hidden" name="referer" value="portal.php?mod=topic&topicid=$topicid#comment" />
				<input type="hidden" name="topicid" value="$topicid">
			<!--{else}-->
				<input type="hidden" name="portal_referer" value="{$_SERVER['REQUEST_URI']}#comment">
				<input type="hidden" name="referer" value="{$_SERVER['REQUEST_URI']}#comment" />
				<input type="hidden" name="id" value="$data[id]" />
				<input type="hidden" name="idtype" value="$data[idtype]" />
				<input type="hidden" name="aid" value="$aid">
			<!--{/if}-->
			<input type="hidden" name="formhash" value="{FORMHASH}">
			<input type="hidden" name="replysubmit" value="true">
			<input type="hidden" name="commentsubmit" value="true" />
			
			<div class="ainuobut cl">
            	<a href="javascript:;" id="message_face" class="pssmil" onclick="showFace(this.id, 'message');return false;">
					<i class="iconfont icon-emoji"></i>
				</a>
            	<input type="submit" name="commentsubmit_btn" id="commentsubmit_btn" value="$alang_postreply" class="fbpl" />
                <a class="cenclepl" href="javascript:;" style="margin-right:5px;">{lang cancel}</a>
            </div>
            <div id="ainuo_facemenu"></div>
        </div>
		</form>
	</div>
</div>
<style>
#afastreply .ainuo_facemenu li{ width:12.5%; float:left;text-align:center;}
#afastreply .ainuo_facemenu li img{ width:80%; height:auto;}
</style>
<!--{template common/showface}-->

<script type="text/javascript">
$(document).ready(function(){
	$("#fastcon").click(function(){
		<!--{if !$_G[uid]}-->
			popup.open('{lang nologin_tip}', 'confirm', 'member.php?mod=logging&action=login');
			return false;
		<!--{/if}-->
	});	
});

$(document).on('click', '.fbpl', function() {
	Zepto('.page').append('<div class="ainuooverlay"><div class="preloader-indicator-overlay"></div><div class="preloader-indicator-modal"><span class="preloader preloader-white"></span></div></div>');
	var obj = $(this);
	var formobj = $(this.form);
	$.ajax({
		type:'POST',
		url:formobj.attr('action') + '&handlekey='+ formobj.attr('id') +'&inajax=1',
		data:formobj.serialize(),
		dataType:'xml'
	})
	.success(function(s) {
		if(s.lastChild.firstChild.nodeValue.indexOf("$alang_cz_success") >= 0){
			Zepto('.ainuooverlay').remove();
			Zepto.toast('$alang_success',1500,'toast');
			setTimeout(function(){
				window.location.reload();
			},400)
		}else if(s.lastChild.firstChild.nodeValue.indexOf("$alang_wordlimit0") >= 0){
			Zepto('.ainuooverlay').remove();
			Zepto.toast('$alang_wordlimit2',1500,'toast');
		}else{
			Zepto('.ainuooverlay').remove();
			popup.open(s.lastChild.firstChild.nodeValue);
			evalscript(s.lastChild.firstChild.nodeValue);
		}
	})
	.error(function() {
		window.location.href = obj.attr('href');
		Zepto('.ainuooverlay').remove();
	});
	return false;
});

$('.favbtn').on('click', function() {
		<!--{if !$_G[uid]}-->
			popup.open('{lang nologin_tip}', 'confirm', 'member.php?mod=logging&action=login');
			return false;
		<!--{/if}-->
		Zepto('.page').append('<div class="ainuooverlay"><div class="preloader-indicator-overlay"></div><div class="preloader-indicator-modal"><span class="preloader preloader-white"></span></div></div>');
		var obj = $(this);
		$.ajax({
			type:'POST',
			url:obj.attr('href') + '&handlekey=favbtn&inajax=1',
			data:{'favoritesubmit':'true', 'formhash':'{FORMHASH}'},
			dataType:'xml',
		})
		.success(function(s) {
			if(s.lastChild.firstChild.nodeValue.indexOf("$alang_haveshoucang") >= 0){
				Zepto('.ainuooverlay').remove();
				Zepto.toast('$alang_haveshoucang',1500,'toast');
			}else if(s.lastChild.firstChild.nodeValue.indexOf("$alang_havescsucccess") >= 0){
				Zepto('.ainuooverlay').remove();
				Zepto.toast('$alang_havescsucccess2',1500,'toast');
				evalscript(s.lastChild.firstChild.nodeValue);
			}
			
		})
		.error(function() {
			window.location.href = obj.attr('href');
			Zepto('.ainuooverlay').remove();
		});
		return false;
	});
</script>