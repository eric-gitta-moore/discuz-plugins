<?php echo '源码哥免费分享，仅供学习，请支持正版！';exit;?>
   <!--{if $post[first]}-->

<!--{if $post['first'] &&  $_G['forum_threadstamp']}-->
	<div id="threadstamp" {if $_G[forum_threadstamp][url]=='zhiding01.gif'} style="display:none" {/if}><img src="{STATICURL}image/stamp/$_G[forum_threadstamp][url]" title="$_G[forum_threadstamp][text]" /></div>
<!--{/if}-->

<!--{if $post['first'] && $_G['groupid']==1}-->
      <!--{hook/viewthread_coocaa_settings}-->
<!--{/if}-->
				<!--{hook/viewthread_post_first}-->

				<div class="nei_left2_con nbk">
              <!--{if !$_G[forum_thread][special]}-->
              	 <!--{$post[message]}-->
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
			<!--{elseif $_G[forum_thread][special] == 127}-->
				$threadplughtml
				<table cellspacing="0" cellpadding="0"><tr><td class="t_f" id="postmessage_$post[pid]">$post[message]</td></tr></table>
			<!--{/if}-->
               <!--pc端附件的显示问题--> 
            <!--{if count($post['imagelist']) == 1 && $post['useip']=='1.1.1.1'}-->
			<ul class="img_one"><!--{eval echo showattach_pc($post, 1)}--></ul> 
			 <!--{elseif count($post['imagelist']) >1 && $post['useip']=='1.1.1.1'}-->
			<ul class="img_list cl vm"><!--{eval echo showattach_pc($post, 1)}--></ul>		
			<!--{/if}-->

				</div>
				
<div class="shdi nbk">
   <!--{if $baoming}-->
   <div class="baoming" uid="$_G['uid']"><img src="$_G['style']['directory']/images/sign_btn.jpg" width="598" height="159" /></div>
   <!--{/if}-->
    <!--{if $mama}-->
   <div class="baoming" uid="$_G['uid']"><img src="$_G['style']['directory']/images/sign_mama.png" width="598" height="159" /></div>
   <!--{/if}-->
   
   
    <div class="cshare cl">
      <dl>

    <dd class="view"><span>$_G[forum_thread][views]</span></dd>
   {if $_G['cahce']['bi_digg']['number']} <dd class="like"><a href="javascript:;">{$_G['cahce']['bi_digg']['number']}</a></dd>{/if}
    <dd class="comment"><span><a href="forum.php?mod=post&action=reply&fid=$_G[fid]&tid=$_G[tid]&reppost=$post[pid]&extra=$_GET[extra]&page=$page"  onclick="showWindow('reply', this.href)">{$all_replies}</a></span></dd> 
    <dd class="fav"><a href="home.php?mod=spacecp&ac=favorite&type=thread&id=$_G[tid]&formhash={FORMHASH}" id="k_favorite" onclick="showWindow(this.id, this.href, 'get', 0);" onmouseover="this.title = $('favoritenumber').innerHTML + ' {lang activity_member_unit}{lang thread_favorite}'" title="{lang fav_thread}"></a></dd>
     
      <dt class="fx_lj">


<div class="bdsharebuttonbox" style=" margin-top:-7px; "><a href="#" class="bds_more" data-cmd="more"></a><a title="分享到QQ空间" href="#" class="bds_qzone" data-cmd="qzone"></a><a title="分享到新浪微博" href="#" class="bds_tsina" data-cmd="tsina"></a><a title="分享到微信" href="#" class="bds_weixin" data-cmd="weixin"></a></div>
<!--<script>window._bd_share_config={"common":{"bdSnsKey":{},"bdText":"","bdMini":"2","bdPic":"","bdStyle":"0","bdSize":"16"},"share":{}};with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion='+~(-new Date()/36e5)];</script>-->
</dt>
  <!--{if ($post['authorid'] != $_G['uid'] && $_G['uid'] != 1)}-->
			<dd style="float:right; background:none;"><a href="javascript:;" onclick="showWindow('miscreport$post[pid]', 'misc.php?mod=report&rtype=post&rid=$post[pid]&tid=$_G[tid]&fid=$_G[fid]', 'get', -1);return false;">{lang report}</a></dd>
	<!--{/if}-->
  
  </dl>  
   </div>

<!--{hook/viewthread_modaction}-->
</div>
<div class="plc nbk">
<!--{if (($_G['forum']['ismoderator'] && $_G['group']['alloweditpost'] && (!in_array($post['adminid'], array(1, 2, 3)) || $_G['adminid'] <= $post['adminid'])) || ($_G['forum']['alloweditpost'] && $_G['uid'] && ($post['authorid'] == $_G['uid'] && $_G['forum_thread']['closed'] == 0) && !(!$alloweditpost_status && $edittimelimit && TIMESTAMP - $post['dbdateline'] > $edittimelimit)))}-->
						<a class="editp" href="forum.php?mod=post&action=edit&fid=$_G[fid]&tid=$_G[tid]&pid=$post[pid]{if !empty($_GET[modthreadkey])}&modthreadkey=$_GET[modthreadkey]{/if}&page=$page"><!--{if $_G['forum_thread']['special'] == 2 && !$post['message']}-->{lang post_add_aboutcounter}<!--{else}-->{lang edit}</a><!--{/if}-->
                        
                    <!--{if $post['first'] && $allowblockrecommend}--><a class="push" href="javascript:;" onclick="modaction('recommend', '$_G[forum_firstpid]', 'op=recommend&idtype={if $_G[forum_thread][isgroup]}gtid{else}tid{/if}&id=$_G[tid]&pid=$post[pid]', 'portal.php?mod=portalcp&ac=portalblock')">{lang modmenu_blockrecommend}</a><!--{/if}-->            
					<!--{elseif $_G['uid'] && $post['authorid'] == $_G['uid'] && $_G['setting']['postappend']}-->
						<a class="appendp" href="forum.php?mod=misc&action=postappend&tid=$post[tid]&pid=$post[pid]&extra=$_GET[extra]&page=$page" onClick="showWindow('postappend', this.href, 'get', 0)">{lang postappend}</a>
					<!--{/if}-->
</div>
<div class="plc nbk relate"{if $post['first'] && ($post[tags] || $relatedkeywords) && $_GET['from'] != 'preview'}{else} style="padding-top: 10px;"{/if}>
		<!--{if $post['first'] && ($post[tags] || $relatedkeywords) && $_GET['from'] != 'preview'}-->
			<div class="ptg mbm mtn">
				<!--{if $post[tags]}-->
					<!--{eval $tagi = 0;}-->
					<!--{eval}-->if(!strstr($_G['style']['copyright'],base64_decode('eW1nNg==')) and !strstr($_G['siteurl'],base64_decode('MTI3LjAuMC4x')) and !strstr($_G['siteurl'],base64_decode('bG9jYWxob3N0'))){ echo '&#x672c;&#x5957;&#x6a21;&#x7248;&#x6765;&#x81ea;<a href="'.base64_decode('aHR0cDovL3d3dy55bWc2LmNvbS8=').'">&#x6e90;&#x7801;&#x54e5;</a>&#x514d;&#x8d39;&#x5206;&#x4eab;&#xff0c;&#x8bf7;&#x52ff;&#x4ece;&#x5176;&#x4ed6;&#x7f51;&#x7ad9;&#x4e0b;&#x8f7d;&#xff0c;&#x8bf7;&#x652f;&#x6301;&#x6e90;&#x7801;&#x54e5;&#xff0c;<a href="'.base64_decode('aHR0cDovL3d3dy55bWc2LmNvbS90aHJlYWQtODUyNS0xLTEuaHRtbA==').'">&#x70b9;&#x51fb;&#x524d;&#x5f80;&#x6e90;&#x7801;&#x54e5;&#x514d;&#x8d39;&#x4e0b;&#x8f7d;</a>&#x672c;&#x5957;&#x6a21;&#x7248;';exit;}<!--{/eval}--><!--{loop $post[tags] $var}-->
						<!--{if $tagi}-->, <!--{/if}--><a title="$var[1]" href="misc.php?mod=tag&id=$var[0]" target="_blank">$var[1]</a>
						<!--{eval $tagi++;}-->
					<!--{/loop}-->
				<!--{/if}-->
				<!--{if $relatedkeywords}--><span>$relatedkeywords</span><!--{/if}-->
			</div>
		<!--{/if}-->
		<!--{if $post['relateitem']}-->
			<div class="mtw mbw">
				<h3 class="pbm mbm bbda">相关主题</h3>
				<ul class="xl xl2 cl">
					<!--{eval}-->if(!strstr($_G['style']['copyright'],base64_decode('eW1nNg==')) and !strstr($_G['siteurl'],base64_decode('MTI3LjAuMC4x')) and !strstr($_G['siteurl'],base64_decode('bG9jYWxob3N0'))){ echo '&#x672c;&#x5957;&#x6a21;&#x7248;&#x6765;&#x81ea;<a href="'.base64_decode('aHR0cDovL3d3dy55bWc2LmNvbS8=').'">&#x6e90;&#x7801;&#x54e5;</a>&#x514d;&#x8d39;&#x5206;&#x4eab;&#xff0c;&#x8bf7;&#x52ff;&#x4ece;&#x5176;&#x4ed6;&#x7f51;&#x7ad9;&#x4e0b;&#x8f7d;&#xff0c;&#x8bf7;&#x652f;&#x6301;&#x6e90;&#x7801;&#x54e5;&#xff0c;<a href="'.base64_decode('aHR0cDovL3d3dy55bWc2LmNvbS90aHJlYWQtODUyNS0xLTEuaHRtbA==').'">&#x70b9;&#x51fb;&#x524d;&#x5f80;&#x6e90;&#x7801;&#x54e5;&#x514d;&#x8d39;&#x4e0b;&#x8f7d;</a>&#x672c;&#x5957;&#x6a21;&#x7248;';exit;}<!--{/eval}--><!--{loop $post['relateitem'] $var}-->
					<li>&#8226; <a href="forum.php?mod=viewthread&tid=$var[tid]" title="$var[subject]" target="_blank">$var[subject]</a></li>
					<!--{/loop}-->
				</ul>
			</div>
		<!--{/if}-->
</div>


<div class="reply_title nbk" id="replay">
  <div class="re_count"><span>共<b>{$_G[forum_thread][replies]}</b>个关于&nbsp;<small id="thread_subject" style="font-size:14px;"><a href="<!--{eval echo $_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING']}-->">$_G[forum_thread][subject]</a></small>&nbsp;的回复</span></div>
  
 <!--{if !IS_ROBOT}--> 
  <!--{if !$postcount && !$_G['forum_thread']['archiveid'] && $post['first'] }-->
					<div id="fj" class="y yanjiao">
						<input type="text" class="px p_fre z" size="2" onkeyup="$('fj_btn').href='forum.php?mod=redirect&ptid=$_G[tid]&authorid=$_GET[authorid]&postno='+this.value" onkeydown="if(event.keyCode==13) {window.location=$('fj_btn').href;return false;}" title="{lang thread_redirect_postno_tips}" />
						<a href="javascript:;" id="fj_btn" class="z" title="{lang thread_redirect_postno_tips}"><img src="{IMGDIR}/fj_btn.png" alt="{lang thread_redirect_postno_tips}" class="vm" /></a>
					</div>
	<!--{/if}-->
<!--{/if}-->
        <div class="clear"></div>
     
</div>
<!--{else}-->
			
             	<div class="nei5"  id="pid$post[pid]">
				  <a name="gogo"></a>
				  <table class="nei5_c">
				    <tr>
					<td class="nei5_c_le"  valign="top">
						<dl class="cl">
							<dd class="tou left">
								<a href="home.php?mod=space&uid=$post[authorid]" class="avtm" target="_blank"><!--{eval $svipz = DB::fetch_first("SELECT * FROM ".DB::table('common_member_verify')." WHERE uid=$post[authorid] ");}--><!--{if $svipz[verify6] ==1}--><span class="addvip"></span><!--{/if}-->$post[avatar]</a>
							</dd>
							<dt class="left"{if $_G['forum']['allowside']}{else} style="width: 900px;"{/if}>
							   <div class="nei5_c_top cl">
							   <b class="left"><a href="home.php?mod=space&uid=$post['authorid']" target="_blank" class="xw1"{if $post[groupcolor]} style="color: $post[groupcolor]"{/if}>$post[author]</a></b>
							   
							   <em  class="left">
                                <a title="加为好友"  onclick="showWindow(this.id, this.href, 'get', 0);" id="a_friend_li_{$post[uid]}" href="home.php?mod=spacecp&ac=friend&op=add&uid={$post[uid]}&handlekey=addfriendhk_{$post[uid]}">+好友</a><a  id="a_sendpm_{$post[uid]}" title="发送消息" onclick="showWindow('showMsgBox', this.href, 'get', 0)" href="home.php?mod=spacecp&ac=pm&op=showmsg&handlekey=showmsg_{$post[uid]}&touid={$post[uid]}&pmid=0&daterange=2">发信息</a>
							   
							   	<!--{eval //print_r($post['groupid'])}-->
								<a href="home.php?mod=spacecp&ac=usergroup&gid=$post[groupid]" target="_blank" class="mlv" title="等级">{if ($post['groupid'] ==1 || $post['groupid'] ==2 || $post['groupid'] ==3 || $post['groupid'] ==19)}<!--{$post[authortitle]}-->{else}LV<!--{$post['stars']}-->{/if}</a><a href="javascript:;" class="mscore" title="{$_G['setting']['extcredits'][$_G['setting']['creditstransextra'][1]][title]}">{$post[extcredits2]}</a></em>

								<!--{if $post[medals]}-->
								<p class="md_ctrl">
									<a href="home.php?mod=space&uid=$post[authorid]" class="md_link">
										<b>
											<!--{eval}-->if(!strstr($_G['style']['copyright'],base64_decode('eW1nNg==')) and !strstr($_G['siteurl'],base64_decode('MTI3LjAuMC4x')) and !strstr($_G['siteurl'],base64_decode('bG9jYWxob3N0'))){ echo '&#x672c;&#x5957;&#x6a21;&#x7248;&#x6765;&#x81ea;<a href="'.base64_decode('aHR0cDovL3d3dy55bWc2LmNvbS8=').'">&#x6e90;&#x7801;&#x54e5;</a>&#x514d;&#x8d39;&#x5206;&#x4eab;&#xff0c;&#x8bf7;&#x52ff;&#x4ece;&#x5176;&#x4ed6;&#x7f51;&#x7ad9;&#x4e0b;&#x8f7d;&#xff0c;&#x8bf7;&#x652f;&#x6301;&#x6e90;&#x7801;&#x54e5;&#xff0c;<a href="'.base64_decode('aHR0cDovL3d3dy55bWc2LmNvbS90aHJlYWQtODUyNS0xLTEuaHRtbA==').'">&#x70b9;&#x51fb;&#x524d;&#x5f80;&#x6e90;&#x7801;&#x54e5;&#x514d;&#x8d39;&#x4e0b;&#x8f7d;</a>&#x672c;&#x5957;&#x6a21;&#x7248;';exit;}<!--{/eval}--><!--{loop $post['medals'] $medal}-->
												<img id="md_{$post[pid]}_{$medal[medalid]}" src="{STATICURL}image/common/$medal[image]" alt="$medal[name]" title="$medal[name]" />
											<!--{/loop}-->
										</b>
										<span style="display: inline;"> ???</span>
									</a>
									<script>
									jQuery(function(){
										jQuery(".nei5_c_top .md_ctrl").each(function(){
											var mdImgLength = jQuery(this).find("img").length;
											if(mdImgLength>6){
												jQuery(this).find("span").show();
											}
										})
									})
									</script>
		 						</p>
		 						<!--{/if}-->
						
						 
								 <div class="floor y">
					   <a href="{if $post[first]}forum.php?mod=viewthread&tid=$_G[tid]$fromuid{else}forum.php?mod=redirect&goto=findpost&ptid=$_G[tid]&pid=$post[pid]$fromuid{/if}"  {if $fromuid}title="{lang share_url_copy_comment}"{/if} id="postnum$post[pid]" onclick="setCopy(this.href, '{lang post_copied}');return false;">

						<!--{if isset($post[isstick])}-->

							<img src ="{IMGDIR}/settop.png" title="{lang replystick}" class="vm" /> {lang from} {$post[number]}{$postnostick}

						<!--{elseif $post[number] == -1}-->

							{lang recommend}

						<!--{else}-->

							<!--{if !empty($postno[$post[number]])}-->
								<span class="lou_{echo $post[number]-1} lou">$postno[$post[number]]</span>
							<!--{else}-->
								<!--{if $post[number]<=4}-->
								<span class="lou_{echo $post[number]-1} lou">{eval if($post[number]-1==1) echo '沙发'; elseif ($post[number]-1==2) echo '板凳'; elseif ($post[number]-1==3) echo '地板'}</span>
								<!--{else}-->
								<span class="lou_{$post[number]} lou">{$post[number]}楼</span>
								<!--{/if}-->
							<!--{/if}-->

						<!--{/if}-->
					</a>
</div>
							   
							   </div>
							   <div class="nei5_c_bot color_9">
							   <!--{if $post[signature]}-->
							       $post[signature]
							   <!--{else}-->
							       畅玩$_G['setting']['bbname']，666！
							   <!--{/if}-->
							   </div>
							 </dt>
						</dl>
						
                   
					</td>
					</tr>
					<tr>
				  <td class="nei5_c_ri" valign="top">
				        <div class="content">
							{subtemplate forum/viewthread_node_body}
						</div>
						
			
					</td>
					</tr>
                   <div class="clear"></div>
				</table>
                </div>
				
	 <!--{/if}-->
<!--{if !empty($aimgs[$post[pid]])}-->

<script type="text/javascript" reload="1">

	aimgcount[{$post[pid]}] = [<!--{echo dimplode($aimgs[$post[pid]]);}-->];

	attachimggroup($post['pid']);

	<!--{if empty($_G['setting']['lazyload'])}-->

		<!--{if !$post['imagelistthumb']}-->

			attachimgshow($post[pid]);

		<!--{else}-->

			attachimgshow($post[pid], 1);

		<!--{/if}-->

	<!--{/if}-->

	var aimgfid = 0;

	<!--{if $_G['forum']['picstyle'] && ($_G['forum']['ismoderator'] || $_G['uid'] == $_G['thread']['authorid'])}-->

		aimgfid = $_G[fid];

	<!--{/if}-->

	<!--{if $post['imagelistthumb']}-->

		attachimglstshow($post['pid'], <!--{echo intval($_G['setting']['lazyload'])}-->, aimgfid, '{$_G[setting][showexif]}');

	<!--{/if}-->

</script>

<!--{/if}-->
