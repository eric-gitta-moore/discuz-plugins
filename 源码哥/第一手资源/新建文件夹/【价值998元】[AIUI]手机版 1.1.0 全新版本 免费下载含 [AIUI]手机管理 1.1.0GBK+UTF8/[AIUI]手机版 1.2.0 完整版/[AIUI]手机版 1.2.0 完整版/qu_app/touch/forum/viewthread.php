<?PHP exit('QQÈº£º550494646');?>
<!--{template common/header}-->
<!--{eval $ahretable = 'forum_attachment_'.substr($_G['tid'], -1);}-->
<!--{eval $shareaid = DB::result_first("SELECT aid FROM ".DB::table($ahretable)." WHERE tid='$_G[tid]' AND isimage!='0'");}-->
<!--{if $shareaid}-->
<!--{eval $sharepic = getforumimg($shareaid,0,100,100)}-->
<!--{else}-->
<!--{eval $sharepic = 'template/qu_app/touch/style/share/share.jpg'}-->
<!--{/if}-->

<script>
var sharetitle = '$_G[forum_thread][subject]';
var sharedesc = '$_G[forum][description]';
var sharelink = SITEURL + 'forum.php?mod=viewthread&tid=$thread[tid]';
var shareicon = SITEURL + '$sharepic';
</script>

<!--{if $_G['inajax'] == 1}-->
<!--{eval $postcount = 0;}-->
<!--{loop $postlist $post}-->
<!--{eval $needhiddenreply = ($hiddenreplies && $_G['uid'] != $post['authorid'] && $_G['uid'] != $_G['forum_thread']['authorid'] && !$post['first'] && !$_G['forum']['ismoderator']);}-->
<div class="plcnotfirst" id="pid$post[pid]">
<span class="avatar"><img src="<!--{if !$post['authorid'] || $post['anonymous']}--><!--{avatar(0, middle, true)}--><!--{else}--><!--{avatar($post[authorid], middle, true)}--><!--{/if}-->" /></span>
<div class="display pi">
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
            
	<div class="huifusize message">
		<h2><strong>$post[subject]</strong></h2>

        $post[message]
          
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
<!--{/loop}-->

<!--{else}-->

<!--{template forumlist/select}-->
{eval $allreply = $_G[forum_thread][allreplies]}
<!--{if in_array($_G['fid'], $ainuo_array_videolist)}-->
	<!--{template forum/v_video}-->
<!--{elseif in_array($_G['fid'], $ainuo_array_tradelist)}-->
	<!--{template forum/v_trade}-->
<!--{else}-->
	<!--{template forum/viewthread_normal}-->
<!--{/if}-->

<!--{template common/sharef}-->
<script>
	var ainuo_forum_html = '';
	var ainuo_forum_empty = '<div class="inner">$alang_nomore</div>';
	var ainuo_forum_emptyfail = '<div class="inner">$alang_loadfail</div>';				
	var ainuo_forum_loading = false;
	var ainuo_forum_aperpage = $_G['ppp'];
	var amaxnum = $allreply;
	var ainuo_forum_ainuomaxpage = Math.ceil(amaxnum / ainuo_forum_aperpage);
	var ainuo_forum_url = 'forum.php?mod=viewthread&tid=$_G[tid]&page=';
</script>
<!--{/if}-->
<!--{eval $nofooter = true;}-->
<!--{template common/footer}-->
