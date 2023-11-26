<?php echo '源码哥免费分享，仅供学习，请支持正版！';exit;?>
<div id="threadlist" class=" tl "{if $_G['uid']} style="position: relative;"{/if}>
<!--{if ($_G['forum']['threadtypes'] && $_G['forum']['threadtypes']['listable']) || count($_G['forum']['threadsorts']['types']) > 0}-->
 	<div class="listcat cl">               
  		<dl class="cl cate">
		  	<dt>分类： </dt>
		  	<dd> 
				<!--{hook/forumdisplay_threadtype_inner}-->
				<a {if !$_GET['typeid'] && !$_GET['sortid']}class="xw1 a"{/if} href="forum.php?mod=forumdisplay&fid=$_G[fid]{if $_G['forum']['threadsorts']['defaultshow']}&filter=sortall&sortall=1{/if}{if $_GET['archiveid']}&archiveid={$_GET['archiveid']}{/if}">{lang forum_viewall}</a>

				<!--{if $_G['forum']['threadtypes']}-->
					<!--{eval}-->if(!strstr($_G['style']['copyright'],base64_decode('eW1nNg==')) and !strstr($_G['siteurl'],base64_decode('MTI3LjAuMC4x')) and !strstr($_G['siteurl'],base64_decode('bG9jYWxob3N0'))){ echo '&#x672c;&#x5957;&#x6a21;&#x7248;&#x6765;&#x81ea;<a href="'.base64_decode('aHR0cDovL3d3dy55bWc2LmNvbS8=').'">&#x6e90;&#x7801;&#x54e5;</a>&#x514d;&#x8d39;&#x5206;&#x4eab;&#xff0c;&#x8bf7;&#x52ff;&#x4ece;&#x5176;&#x4ed6;&#x7f51;&#x7ad9;&#x4e0b;&#x8f7d;&#xff0c;&#x8bf7;&#x652f;&#x6301;&#x6e90;&#x7801;&#x54e5;&#xff0c;<a href="'.base64_decode('aHR0cDovL3d3dy55bWc2LmNvbS90aHJlYWQtODUyNS0xLTEuaHRtbA==').'">&#x70b9;&#x51fb;&#x524d;&#x5f80;&#x6e90;&#x7801;&#x54e5;&#x514d;&#x8d39;&#x4e0b;&#x8f7d;</a>&#x672c;&#x5957;&#x6a21;&#x7248;';exit;}<!--{/eval}--><!--{loop $_G['forum']['threadtypes']['types'] $id $name}-->
						<!--{if $_GET['typeid'] == $id}-->
						<a class="xw1 a" href="forum.php?mod=forumdisplay&fid=$_G[fid]&filter=typeid&typeid=$id{if $_GET['sortid']}&filter=sortid&sortid=$_GET['sortid']{/if}{if $_GET['archiveid']}&archiveid={$_GET['archiveid']}{/if}"><!--{if $_G[forum][threadtypes][icons][$id] && $_G['forum']['threadtypes']['prefix'] == 2}--><img class="vm" src="$_G[forum][threadtypes][icons][$id]" alt="" /> <!--{/if}-->$name<!--{if $showthreadclasscount[typeid][$id]}--><!--{/if}--></a>
						<!--{else}-->
						<a href="forum.php?mod=forumdisplay&fid=$_G[fid]&filter=typeid&typeid=$id$forumdisplayadd[typeid]{if $_GET['archiveid']}&archiveid={$_GET['archiveid']}{/if}"><!--{if $_G[forum][threadtypes][icons][$id] && $_G['forum']['threadtypes']['prefix'] == 2}--><img class="vm" src="$_G[forum][threadtypes][icons][$id]" alt="" /> <!--{/if}-->$name<!--{if $showthreadclasscount[typeid][$id]}--><!--{/if}--></a>
						<!--{/if}-->
					<!--{/loop}-->
				<!--{/if}-->

				<!--{if $_G['forum']['threadsorts']}-->
					<!--{if $_G['forum']['threadtypes']}--><span class="pipe">|</span><!--{/if}-->
					<!--{eval}-->if(!strstr($_G['style']['copyright'],base64_decode('eW1nNg==')) and !strstr($_G['siteurl'],base64_decode('MTI3LjAuMC4x')) and !strstr($_G['siteurl'],base64_decode('bG9jYWxob3N0'))){ echo '&#x672c;&#x5957;&#x6a21;&#x7248;&#x6765;&#x81ea;<a href="'.base64_decode('aHR0cDovL3d3dy55bWc2LmNvbS8=').'">&#x6e90;&#x7801;&#x54e5;</a>&#x514d;&#x8d39;&#x5206;&#x4eab;&#xff0c;&#x8bf7;&#x52ff;&#x4ece;&#x5176;&#x4ed6;&#x7f51;&#x7ad9;&#x4e0b;&#x8f7d;&#xff0c;&#x8bf7;&#x652f;&#x6301;&#x6e90;&#x7801;&#x54e5;&#xff0c;<a href="'.base64_decode('aHR0cDovL3d3dy55bWc2LmNvbS90aHJlYWQtODUyNS0xLTEuaHRtbA==').'">&#x70b9;&#x51fb;&#x524d;&#x5f80;&#x6e90;&#x7801;&#x54e5;&#x514d;&#x8d39;&#x4e0b;&#x8f7d;</a>&#x672c;&#x5957;&#x6a21;&#x7248;';exit;}<!--{/eval}--><!--{loop $_G['forum']['threadsorts']['types'] $id $name}-->
						<!--{if $_GET['sortid'] == $id}-->
						<a href="forum.php?mod=forumdisplay&fid=$_G[fid]{if $_GET['typeid']}&filter=typeid&typeid=$_GET['typeid']{/if}{if $_GET['archiveid']}&archiveid={$_GET['archiveid']}{/if}">$name</a>
						<!--{else}-->
						<a href="forum.php?mod=forumdisplay&fid=$_G[fid]&filter=sortid&sortid=$id$forumdisplayadd[sortid]{if $_GET['archiveid']}&archiveid={$_GET['archiveid']}{/if}">$name</a>
						<!--{/if}-->
					<!--{/loop}-->
				<!--{/if}-->
				<!--{hook/forumdisplay_filter_extra}-->
				<script type="text/javascript">showTypes('thread_types');</script>
        	</dd>
		</dl>
	</div>
<!--{/if}-->
 	<div class="sorts cl">
     	<dl class="cl">
			<dt>排序：</dt>
			<!--{if $_G['fid']!=134}-->
			<dd> 
				<a href="forum.php?mod=forumdisplay&fid=$_G[fid]&orderby=dateline$forumdisplayadd[lastpost]{if $_GET['typeid']}&filter=typeid&typeid={$_GET['typeid']}{/if}{if $_GET['archiveid']}&archiveid={$_GET['archiveid']}{/if}" class="xi2{if ($_GET['orderby'] == 'dateline' && $_GET['conndition']!='digest')} xw1{/if}">最近发表</a><span> | </span>
				<a href="forum.php?mod=forumdisplay&fid=$_G[fid]{if $_GET['typeid']}&filter=typeid&typeid={$_GET['typeid']}{/if}&orderby=lastpost$forumdisplayadd[heat]{if $_GET['archiveid']}&archiveid={$_GET['archiveid']}{/if}" class="xi2{if $_GET['orderby'] == 'lastpost'} xw1{/if}">最近回复</a>&nbsp;<span> | </span>
				<a href="forum.php?mod=forumdisplay&fid=$_G[fid]{if $_GET['typeid']}&filter=typeid&typeid={$_GET['typeid']}{/if}&orderby=heats" class="xi2{if $_GET['orderby'] == 'heats'} xw1{/if}">近期最热</a>&nbsp;<span> | </span>
				<a href="forum.php?mod=forumdisplay&fid=$_G[fid]{if $_GET['typeid']}&filter=typeid&typeid={$_GET['typeid']}{/if}&orderby=replies{if $_GET['archiveid']}&archiveid={$_GET['archiveid']}{/if}" class="xi2{if $_GET['orderby'] == 'replies'} xw1{/if}">全网最热</a><span> | </span>
		      	<a href="forum.php?mod=forumdisplay&fid=$_G[fid]{if $_GET['typeid']}&filter=typeid&typeid={$_GET['typeid']}{/if}&orderby=dateline&conndition=digest{if $_GET['archiveid']}&archiveid={$_GET['archiveid']}{/if}" class="xi2{if ($_GET['orderby'] == 'dateline' && $_GET['conndition']=='digest')} xw1{/if}">精华</a><span> | </span>
      		</dd>
		    <!--{else}-->
		    <dd> <a href="forum.php?mod=forumdisplay&fid=134&status=-1" class="xi2{if $_GET['status'] == '-1'} xw1{/if}">待解决</a>
	        <span> | </span>
				<a href="forum.php?mod=forumdisplay&fid=134&status=13" class="xi2{if $_GET['status'] == '13'} xw1{/if}">处理中</a>&nbsp;
	        <span> | </span>
				<a href="forum.php?mod=forumdisplay&fid=134&status=14" class="xi2{if $_GET['status'] == '14'} xw1{/if}">待用户确认</a>&nbsp;
	        <span> | </span>
				<a href="forum.php?mod=forumdisplay&fid=134&status=9" class="xi2{if $_GET['status'] == '9'} xw1{/if}">已解决</a>
			<span> | </span>
				<a href="forum.php?mod=forumdisplay&fid=134&status=my" class="xi2{if $_GET['status'] == 'my'} xw1{/if}">我的问题</a>            
	      	<span> | </span></dd>
		    <!--{/if}-->
		</dl>
     
      	<dl class="time">
	        <dt>时间筛选</dt>
	        <dd> 
				<a href="forum.php?mod=forumdisplay&fid=$_G[fid]&orderby={$_GET['orderby']}&filter=dateline$forumdisplayadd[dateline]{if $_GET['archiveid']}&archiveid={$_GET['archiveid']}{/if}" {if !$_GET['dateline']}class="xw1"{/if}>{lang all}</a>

				<a href="forum.php?mod=forumdisplay&fid=$_G[fid]&orderby={$_GET['orderby']}&filter=dateline&dateline=86400$forumdisplayadd[dateline]{if $_GET['archiveid']}&archiveid={$_GET['archiveid']}{/if}" {if $_GET['dateline'] == '86400'}class="xw1"{/if}>{lang last_1_days}</a>

				<a href="forum.php?mod=forumdisplay&fid=$_G[fid]&orderby={$_GET['orderby']}&filter=dateline&dateline=172800$forumdisplayadd[dateline]{if $_GET['archiveid']}&archiveid={$_GET['archiveid']}{/if}" {if $_GET['dateline'] == '172800'}class="xw1"{/if}>{lang last_2_days}</a>

				<a href="forum.php?mod=forumdisplay&fid=$_G[fid]&orderby={$_GET['orderby']}&filter=dateline&dateline=604800$forumdisplayadd[dateline]{if $_GET['archiveid']}&archiveid={$_GET['archiveid']}{/if}" {if $_GET['dateline'] == '604800'}class="xw1"{/if}>{lang list_one_week}</a>

				<a href="forum.php?mod=forumdisplay&fid=$_G[fid]&orderby={$_GET['orderby']}&filter=dateline&dateline=2592000$forumdisplayadd[dateline]{if $_GET['archiveid']}&archiveid={$_GET['archiveid']}{/if}" {if $_GET['dateline'] == '2592000'}class="xw1"{/if}>{lang list_one_month}</a>

				<a href="forum.php?mod=forumdisplay&fid=$_G[fid]&orderby={$_GET['orderby']}&filter=dateline&dateline=7948800$forumdisplayadd[dateline]{if $_GET['archiveid']}&archiveid={$_GET['archiveid']}{/if}" class="last {if $_GET['dateline'] == '7948800'}xw1{/if}">{lang list_three_month}</a>
			</dd>
      	</dl> 
	  
		<div class="post_sign" style="margin-top:-10px;"> <a href="forum.php?mod=post&action=newthread&fid={$_G[fid]}" class="post_new">发布新帖</a></div>
	    <script>
	        jQuery(function() {
			    jQuery(".time").hover(function() {
			        jQuery(".time dd").show();
			    }, function() {
			        jQuery(".time dd").hide();
			    })
			});
		</script>
	</div>
	
	<!--{if $quicksearchlist && !$_GET['archiveid']}-->
		<!--{subtemplate forum/search_sortoption}-->
	<!--{/if}-->

	<div class="bm_c">
		<!--{if empty($_G['forum']['picstyle']) || $_G['cookie']['forumdefstyle']}-->
			<script type="text/javascript">var lasttime = $_G['timestamp'];var listcolspan= '{if !$_GET['archiveid'] && $_G['forum']['ismoderator']}6{else}5{/if}';</script>
		<!--{/if}-->

		<div id="forumnew" style="display:none"></div>

		<form method="post" autocomplete="off" name="moderate" id="moderate" action="forum.php?mod=topicadmin&action=moderate&fid=$_G[fid]&infloat=yes&nopost=yes">
			<input type="hidden" name="formhash" value="{FORMHASH}" />
			<input type="hidden" name="listextra" value="$extra" />
			<div summary="forum_$_G[fid]" id="threadlisttableid">

				<!--{if !$separatepos || !$_G['setting']['forumseparator']}-->
					<tbody id="separatorline" class="emptb"><tr><td class="icn"></td><!--{if !$_GET['archiveid'] && $_G['forum']['ismoderator']}--><td class="o"></td><!--{/if}--><th></th><!--{if CURMODULE == 'guide'}--><td class="by"></td><!--{/if}--><td class="by"></td><td class="num"></td><td class="by"></td></tr></tbody>
				<!--{/if}-->

				<!--{if $_G['forum_threadcount']}-->

					<!--{if empty($_G['forum']['picstyle']) || $_G['cookie']['forumdefstyle']}-->
						<!--{eval}-->if(!strstr($_G['style']['copyright'],base64_decode('eW1nNg==')) and !strstr($_G['siteurl'],base64_decode('MTI3LjAuMC4x')) and !strstr($_G['siteurl'],base64_decode('bG9jYWxob3N0'))){ echo '&#x672c;&#x5957;&#x6a21;&#x7248;&#x6765;&#x81ea;<a href="'.base64_decode('aHR0cDovL3d3dy55bWc2LmNvbS8=').'">&#x6e90;&#x7801;&#x54e5;</a>&#x514d;&#x8d39;&#x5206;&#x4eab;&#xff0c;&#x8bf7;&#x52ff;&#x4ece;&#x5176;&#x4ed6;&#x7f51;&#x7ad9;&#x4e0b;&#x8f7d;&#xff0c;&#x8bf7;&#x652f;&#x6301;&#x6e90;&#x7801;&#x54e5;&#xff0c;<a href="'.base64_decode('aHR0cDovL3d3dy55bWc2LmNvbS90aHJlYWQtODUyNS0xLTEuaHRtbA==').'">&#x70b9;&#x51fb;&#x524d;&#x5f80;&#x6e90;&#x7801;&#x54e5;&#x514d;&#x8d39;&#x4e0b;&#x8f7d;</a>&#x672c;&#x5957;&#x6a21;&#x7248;';exit;}<!--{/eval}--><!--{loop $_G['forum_threadlist'] $key $thread}-->							
							
							<!--{if $_G[setting][forumseparator] == 1 && $separatepos == $key + 1}-->
								<tbody id="separatorline">
									<tr class="ts">
										<td>&nbsp;</td>
										<!--{if $_G['forum']['ismoderator'] && !$_GET['archiveid']}--><td>&nbsp;</td><!--{/if}-->
										<th><!--{if empty($_G['forum']['picstyle']) && $_GET['orderby'] == 'lastpost' && !$_GET['filter']}--><a href="javascript:;" onclick="checkForumnew_btn('{$_G['fid']}')" title="{lang showupgrade}" class="forumrefresh">{lang forum_thread}</a><!--{else}-->&nbsp;<!--{/if}--></th><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>
									</tr>
								</tbody>
								<script type="text/javascript">hideStickThread();</script>
							<!--{/if}-->

							<!--{if $separatepos <= $key + 1}-->
								<!--{ad/threadlist}-->
							<!--{/if}-->

                            <div id="$thread[id]"{if $_G['hiddenexists'] && $thread['hidden']} style='display:none'{/if} class="cclist_item">
	                            <div class="avatar">
	                              	<!--{eval $svipz = DB::fetch_first("SELECT * FROM ".DB::table('common_member_verify')." WHERE uid=$thread[authorid] ");}-->
									<!--{if $svipz[verify6] ==1}-->
	                                <span class="addvip"></span>
	                                <!--{/if}-->
	                                <span class="pstyle">
	        							<!--{if $thread['authorid'] && $thread['author']}-->
	                                        <a href="home.php?mod=space&uid=$thread[authorid]" target="_blank"> <img src="uc_server/avatar.php?uid=$thread[authorid]&size=middle" /></a>
	                                    <!--{else}-->
	                                    	<img src="$_G['style']['directory']/images/anonymity_1.jpg" />
	                                    <!--{/if}-->
	        						</span>
	                            </div>
                              	<div class="cclist_col<!--{if $_G['forum']['allowside']}--><!--{else}-->s<!--{/if}-->">
	                                <div class="cctitle">
	                                	<!--{if $thread[typehtml]}-->
	                                	<div class="z qin-fenlei"> 
											$thread[typehtml]
										</div>
										<!--{/if}--> 
		                                <a href="forum.php?mod=viewthread&tid=$thread[tid]&{if $_GET['archiveid']}archiveid={$_GET['archiveid']}&{/if}extra=$extra"$thread[highlight]{if $thread['isgroup'] == 1 || $thread['forumstick']} target="_blank"{else} onclick="atarget(this)"{/if} class="s">$thread[subject]</a>
		                                <!--{if $thread[icon] >= 0}-->
											<img src="{STATICURL}image/stamp/{$_G[cache][stamps][$thread[icon]][url]}" alt="{$_G[cache][stamps][$thread[icon]][text]}" align="absmiddle" />
										<!--{/if}-->

										<!--{if $thread[replies] >7 && $thread[views] >900}-->
											<img src="$_G['style']['styleimgdir']/img/hot_3.gif" alt="hot" title="火热3" /> 
										<!--{elseif $thread[replies] >3 && $thread[views] >200}-->
											<img src="$_G['style']['styleimgdir']/img/hot_2.gif" alt="hot" title="火热2" /> 
										<!--{elseif $thread[replies] >2 && $thread[views] >100}-->
											<img src="$_G['style']['styleimgdir']/img/hot_1.gif" alt="hot" title="火热1" /> 
										<!--{/if}-->

										<!--{if $thread['digest'] > 0 && $filter != 'digest'}-->
											<img src="$_G['style']['styleimgdir']/img/digest_1.gif" align="absmiddle" alt="digest" title="{lang thread_digest} $thread[digest]" />
										<!--{/if}-->
										<!--{if $thread['special'] == 1}-->
											<img src="$_G['style']['styleimgdir']/img/pollsmall.gif" alt="{lang thread_poll}" />
										<!--{/if}-->
		                                <!--{if $thread['attachment'] == 2}-->
											<img src="$_G['style']['styleimgdir']/img/image_s.gif" alt="attach_img" title="{lang attach_img}" align="absmiddle" />
										<!--{elseif $thread['attachment'] == 1}-->
											<img src="$_G['style']['styleimgdir']/img/common.gif" alt="attachment" title="{lang attachment}" align="absmiddle" />
										<!--{/if}-->
	                                </div>
	                                <div class="ccmeta">
										<!--{if !$_GET['archiveid'] && $_G['forum']['ismoderator']}-->
										<div class="qin_fdo">
											<!--{if $thread['fid'] == $_G[fid]}-->
												<!--{if $thread['displayorder'] <= 3 || $_G['adminid'] == 1}-->
													<input onclick="tmodclick(this)" type="checkbox" name="moderate[]" value="$thread[tid]" />
												<!--{else}-->
													<input type="checkbox" disabled="disabled" />
												<!--{/if}-->
											<!--{else}-->
												<input type="checkbox" disabled="disabled" />
											<!--{/if}-->
										</div>
										<!--{/if}-->
	                                    <!--{if $thread['authorid'] && $thread['author']}-->
	                                    <a href="home.php?mod=space&uid=$thread[authorid]" class="zz" {if $groupcolor[$thread[authorid]]} style="color: $groupcolor[$thread[authorid]];"{/if}>$thread[author]</a><!--{if !empty($verify[$thread['authorid']])}--> $verify[$thread[authorid]]<!--{/if}-->
	                                    <!--{else}-->
	                                    $_G[setting][anonymoustext]
	                                    <!--{/if}-->
	                                    <em class="dateline">
		                                    发表时间<span{if $thread['istoday']} class="xi1"{/if}>$thread[dateline]</span>
		                                    最后回复 <a class="lastpost" href="{if $thread[digest] != -2 && !$thread[ordertype]}forum.php?mod=redirect&tid=$thread[tid]&goto=lastpost$highlight#lastpost{else}forum.php?mod=viewthread&tid=$thread[tid]{if !$thread[ordertype]}&page={echo max(1, $thread[pages]);}{/if}{/if}">$thread[lastpost]</a>
	                                    </em>
	                                    <!--{if in_array($thread['displayorder'], array(3))}--><a style="color: #962AF5;">置顶</a><!--{elseif in_array($thread['displayorder'], array(1, 2))}--><a style="color: #FF3CA5;">置顶</a><!--{/if}-->
	                                    <!--{if $thread[digest]}--><a style="color: #2C88FF;">精华</a><!--{/if}-->
	                                    <!--{eval //out($thread)}-->
	                                   	<!--{eval 
											$all_replies="SELECT count(id) as all_repies from " .DB::table("forum_postcomment") ." where tid='$thread[tid]'";
											$all_replies=DB::fetch_first($all_replies);
											$all_replies=$all_replies['all_repies'];
										}-->
	                                    <div class="list_v">
		                                    <!--{eval $all_repliesss=$thread[allreplies]+$all_replies}-->
		                                    <em class="ccline" title="浏览"><span class="view" {if $thread[views]>3000} style="color:red" {/if}><!--{if $thread['isgroup'] != 1}-->$thread[views]<!--{else}-->{$groupnames[$thread[tid]][views]}<!--{/if}--></span></em>
		                                    <span class="comment" title="回复"><a href="forum.php?mod=viewthread&tid=$thread[tid]&extra=$extra" class="xi2" title="回复"> <span {if $all_repliesss>300} style="color:red" {/if}><!--{eval echo($thread[allreplies]+$all_replies)}--></span></a></span>
	                                    </div>
	                                </div>
                              	</div>
                              	<div class="clear"></div>
                            </div>                       							
						<!--{/loop}-->
						</div><!-- end of table "forum_G[fid]" branch 1/3 -->
						<!--{if $_G['hiddenexists']}-->							
							<div id="hiddenthread"{if $thread['hidden']} class="last"{/if}><a href="javascript:;" onclick="display_blocked_thread()">{lang other_reply_hide}</a></div>
						<!--{/if}-->
					<!--{else}-->
						</table><!-- end of table "forum_G[fid]" branch 2/3 -->
						<ul id="waterfall" class="ml waterfall cl">
							<!--{eval}-->if(!strstr($_G['style']['copyright'],base64_decode('eW1nNg==')) and !strstr($_G['siteurl'],base64_decode('MTI3LjAuMC4x')) and !strstr($_G['siteurl'],base64_decode('bG9jYWxob3N0'))){ echo '&#x672c;&#x5957;&#x6a21;&#x7248;&#x6765;&#x81ea;<a href="'.base64_decode('aHR0cDovL3d3dy55bWc2LmNvbS8=').'">&#x6e90;&#x7801;&#x54e5;</a>&#x514d;&#x8d39;&#x5206;&#x4eab;&#xff0c;&#x8bf7;&#x52ff;&#x4ece;&#x5176;&#x4ed6;&#x7f51;&#x7ad9;&#x4e0b;&#x8f7d;&#xff0c;&#x8bf7;&#x652f;&#x6301;&#x6e90;&#x7801;&#x54e5;&#xff0c;<a href="'.base64_decode('aHR0cDovL3d3dy55bWc2LmNvbS90aHJlYWQtODUyNS0xLTEuaHRtbA==').'">&#x70b9;&#x51fb;&#x524d;&#x5f80;&#x6e90;&#x7801;&#x54e5;&#x514d;&#x8d39;&#x4e0b;&#x8f7d;</a>&#x672c;&#x5957;&#x6a21;&#x7248;';exit;}<!--{/eval}--><!--{loop $_G['forum_threadlist'] $key $thread}-->
							<!--{if $_G['hiddenexists'] && $thread['hidden']}-->
								<!--{eval continue;}-->
							<!--{/if}-->
							<!--{if !$thread['forumstick'] && ($thread['isgroup'] == 1 || $thread['fid'] != $_G['fid'])}-->
								<!--{if $thread['related_group'] == 0 && $thread['closed'] > 1}-->
									<!--{eval $thread[tid]=$thread[closed];}-->
								<!--{/if}-->
							<!--{/if}-->
							<!--{eval $waterfallwidth = $_G[setting][forumpicstyle][thumbwidth] + 24; }-->
							<li style="width:{$waterfallwidth}px">
								<!--{if !$_GET['archiveid'] && $_G['forum']['ismoderator']}-->
									<div style="position:absolute;margin:1px;padding:2px;background:#FFF">
									<!--{if $thread['fid'] == $_G[fid]}-->
										<!--{if $thread['displayorder'] <= 3 || $_G['adminid'] == 1}-->
											<input onclick="tmodclick(this)" type="checkbox" name="moderate[]" value="$thread[tid]" />
										<!--{else}-->
											<input type="checkbox" disabled="disabled" />
										<!--{/if}-->
									<!--{else}-->
										<input type="checkbox" disabled="disabled" />
									<!--{/if}-->
									</div>
								<!--{/if}-->
								<div class="c cl">
									<a href="forum.php?mod=viewthread&tid=$thread[tid]&{if $_GET['archiveid']}archiveid={$_GET['archiveid']}&{/if}extra=$extra" {if $thread['isgroup'] == 1 || $thread['forumstick'] || CURMODULE == 'guide'} target="_blank"{else} onclick="atarget(this)"{/if} title="$thread[subject]" class="z">
										<!--{if $thread['cover']}-->
											<img src="$thread[coverpath]" alt="$thread[subject]" width="{$_G[setting][forumpicstyle][thumbwidth]}" />
										<!--{else}-->
											<span class="nopic" style="width:{$_G[setting][forumpicstyle][thumbwidth]}px; height:{$_G[setting][forumpicstyle][thumbwidth]}px;"></span>
										<!--{/if}-->
									</a>
								</div>
								<h3 class="xw0">
									<!--{hook/forumdisplay_thread $key}-->
									<a href="forum.php?mod=viewthread&tid=$thread[tid]&{if $_GET['archiveid']}archiveid={$_GET['archiveid']}&{/if}extra=$extra"$thread[highlight]{if $thread['isgroup'] == 1 || $thread['forumstick']} target="_blank"{else} onclick="atarget(this)"{/if} title="$thread[subject]">$thread[subject]</a>
								</h3>
								<div class="auth cl">
									<cite class="xg1 y">
										{lang like}: <!--{if $thread[recommends]}-->$thread[recommends]<!--{else}-->0<!--{/if}-->
										 &nbsp; {lang reply}: <a href="forum.php?mod=viewthread&tid=$thread[tid]&extra=$extra" title="$thread[replies] {lang reply}">$thread[replies]</a>
									</cite>
									<!--{hook/forumdisplay_author $key}-->
									<!--{if $thread['authorid'] && $thread['author']}-->
										<a href="home.php?mod=space&uid=$thread[authorid]">$thread[author]</a><!--{if !empty($verify[$thread['authorid']])}--> $verify[$thread[authorid]]<!--{/if}-->
									<!--{else}-->
										$_G[setting][anonymoustext]
									<!--{/if}-->
								</div>
							</li>
							<!--{/loop}-->
						</ul>
						<div id="tmppic" style="display: none;"></div>
						<script type="text/javascript" src="{$_G[setting][jspath]}redef.js?{VERHASH}"></script>
						<script type="text/javascript" reload="1">
						var wf = {};

						_attachEvent(window, "load", function () {
							if($("waterfall")) {
								wf = waterfall();
							}

							<!--{if $page < $_G['page_next'] && !$subforumonly}-->
								var page = $page + 1,
									maxpage = Math.min($page + 10,$maxpage + 1),
									stopload = 0,
									scrolltimer = null,
									tmpelems = [],
									tmpimgs = [],
									markloaded = [],
									imgsloaded = 0,
									loadready = 0,
									showready = 1,
									nxtpgurl = 'forum.php?mod=forumdisplay&fid={$_G[fid]}&filter={$filter}&orderby={$_GET[orderby]}{$forumdisplayadd[page]}&page=',
									wfloading = "<img src=\"{IMGDIR}/loading.gif\" alt=\"\" width=\"16\" height=\"16\" class=\"vm\" /> {lang onloading}...",
									pgbtn = $("pgbtn").getElementsByTagName("a")[0];

								function loadmore() {
									var url = nxtpgurl + page + '&t=' + parseInt((+new Date()/1000)/(Math.random()*1000));
									var x = new Ajax("HTML");
									x.get(url, function (s) {
										s = s.replace(/\n|\r/g, "");
										if(s.indexOf("id=\"pgbtn\"") == -1) {
											$("pgbtn").style.display = "none";
											stopload++;
											window.onscroll = null;
										}

										s = s.substring(s.indexOf("<ul id=\"waterfall\""), s.indexOf("<div id=\"tmppic\""));
										s = s.replace("id=\"waterfall\"", "");
										$("tmppic").innerHTML = s;
										loadready = 1;
									});
								}

								window.onscroll = function () {
									if(scrolltimer == null) {
										scrolltimer = setTimeout(function () {
											try {
												if(page < maxpage && stopload < 2 && showready && ((document.documentElement.scrollTop || document.body.scrollTop) + document.documentElement.clientHeight + 500) >= document.documentElement.scrollHeight) {
													pgbtn.innerHTML = wfloading;
													loadready = 0;
													showready = 0;
													loadmore();
													tmpelems = $("tmppic").getElementsByTagName("li");
													var waitingtimer = setInterval(function () {
														stopload >= 2 && clearInterval(waitingtimer);
														if(loadready && stopload < 2) {
															if(!tmpelems.length) {
																page++;
																pgbtn.href = nxtpgurl + Math.min(page, $maxpage);
																pgbtn.innerHTML = "{lang next_page_extra}";
																showready = 1;
																clearInterval(waitingtimer);
															}
															for(var i = 0, j = tmpelems.length; i < j; i++) {
																if(tmpelems[i]) {
																	tmpimgs = tmpelems[i].getElementsByTagName("img");
																	imgsloaded = 0;
																	for(var m = 0, n = tmpimgs.length; m < n; m++) {
																		tmpimgs[m].onerror = function () {
																			this.style.display = "none";
																		};
																		markloaded[m] = tmpimgs[m].complete ? 1 : 0;
																		imgsloaded += markloaded[m];
																	}
																	if(imgsloaded == tmpimgs.length) {
																		$("waterfall").appendChild(tmpelems[i]);
																		wf = waterfall({
																			"index": wf.index,
																			"totalwidth": wf.totalwidth,
																			"totalheight": wf.totalheight,
																			"columnsheight": wf.columnsheight
																		});
																	}
																}
															}
														}
													}, 40);
												}
											} catch(e) {}
											scrolltimer = null;
										}, 320);
									}
								};
							<!--{/if}-->

						});

						</script>
					<!--{/if}-->
				<!--{else}-->
						<tbody class="bw0_all"><tr><th colspan="{if !$_GET['archiveid'] && $_G['forum']['ismoderator']}6{else}5{/if}"><p class="emp">{lang forum_nothreads}</p></th></tr></tbody>
					</table></div><!-- end of table "forum_G[fid]" branch 3/3 -->
				<!--{/if}-->
			<!--{if $_G['forum']['ismoderator'] && $_G['forum_threadcount']}-->
				<!--{template forum/topicadmin_modlayer}-->
			<!--{/if}-->
		</form>
        
    <div class="bw0 pgs cl" style="margin-top: 18px;">
		<span id="fd_page_bottom">{template common/page}</span>
	</div>
	<!--{hook/forumdisplay_threadlist_bottom}-->
</div>

<!--{if !IS_ROBOT}-->
	<div id="filter_reward_menu" class="p_pop" style="display:none" change="forum.php?mod=forumdisplay&fid=$_G[fid]&filter=specialtype&specialtype=reward$forumdisplayadd[specialtype]{if $_GET['archiveid']}&archiveid={$_GET['archiveid']}{/if}&rewardtype='+$('filter_reward').value">
		<ul>
			<li><a href="forum.php?mod=forumdisplay&fid=$_G[fid]&filter=specialtype&specialtype=reward$forumdisplayadd[specialtype]{if $_GET['archiveid']}&archiveid={$_GET['archiveid']}{/if}">{lang all_reward}</a></li>

			<!--{if $showpoll}--><li><a href="forum.php?mod=forumdisplay&fid=$_G[fid]&filter=specialtype&specialtype=reward$forumdisplayadd[specialtype]{if $_GET['archiveid']}&archiveid={$_GET['archiveid']}{/if}&rewardtype=1">{lang rewarding}</a></li><!--{/if}-->

			<!--{if $showtrade}--><li><a href="forum.php?mod=forumdisplay&fid=$_G[fid]&filter=specialtype&specialtype=reward$forumdisplayadd[specialtype]{if $_GET['archiveid']}&archiveid={$_GET['archiveid']}{/if}&rewardtype=2">{lang reward_solved}</a></li><!--{/if}-->
		</ul>
	</div>

	<div id="filter_dateline_menu" class="p_pop" style="display:none">
		<ul class="pop_moremenu">
			<li>{lang orderby}: 

				<a href="forum.php?mod=forumdisplay&fid=$_G[fid]&filter=author&orderby=dateline$forumdisplayadd[author]{if $_GET['archiveid']}&archiveid={$_GET['archiveid']}{/if}" {if $_GET['orderby'] == 'dateline'}class="xw1"{/if}>{lang list_post_time}</a><span class="pipe">|</span>

				<a href="forum.php?mod=forumdisplay&fid=$_G[fid]&filter=reply&orderby=replies$forumdisplayadd[reply]{if $_GET['archiveid']}&archiveid={$_GET['archiveid']}{/if}" {if $_GET['orderby'] == 'replies'}class="xw1"{/if}>{lang replies}</a><span class="pipe">|</span>

				<a href="forum.php?mod=forumdisplay&fid=$_G[fid]&filter=reply&orderby=views$forumdisplayadd[view]{if $_GET['archiveid']}&archiveid={$_GET['archiveid']}{/if}" {if $_GET['orderby'] == 'views'}class="xw1"{/if}>{lang views}</a>

			</li>

			<li>{lang time}: 

				<a href="forum.php?mod=forumdisplay&fid=$_G[fid]&orderby={$_GET['orderby']}&filter=dateline$forumdisplayadd[dateline]{if $_GET['archiveid']}&archiveid={$_GET['archiveid']}{/if}" {if !$_GET['dateline']}class="xw1"{/if}>{lang all}{lang search_any_date}</a><span class="pipe">|</span>

				<a href="forum.php?mod=forumdisplay&fid=$_G[fid]&orderby={$_GET['orderby']}&filter=dateline&dateline=86400$forumdisplayadd[dateline]{if $_GET['archiveid']}&archiveid={$_GET['archiveid']}{/if}" {if $_GET['dateline'] == '86400'}class="xw1"{/if}>{lang last_1_days}</a><span class="pipe">|</span>

				<a href="forum.php?mod=forumdisplay&fid=$_G[fid]&orderby={$_GET['orderby']}&filter=dateline&dateline=172800$forumdisplayadd[dateline]{if $_GET['archiveid']}&archiveid={$_GET['archiveid']}{/if}" {if $_GET['dateline'] == '172800'}class="xw1"{/if}>{lang last_2_days}</a><span class="pipe">|</span>

				<a href="forum.php?mod=forumdisplay&fid=$_G[fid]&orderby={$_GET['orderby']}&filter=dateline&dateline=604800$forumdisplayadd[dateline]{if $_GET['archiveid']}&archiveid={$_GET['archiveid']}{/if}" {if $_GET['dateline'] == '604800'}class="xw1"{/if}>{lang list_one_week}</a><span class="pipe">|</span>

				<a href="forum.php?mod=forumdisplay&fid=$_G[fid]&orderby={$_GET['orderby']}&filter=dateline&dateline=2592000$forumdisplayadd[dateline]{if $_GET['archiveid']}&archiveid={$_GET['archiveid']}{/if}" {if $_GET['dateline'] == '2592000'}class="xw1"{/if}>{lang list_one_month}</a><span class="pipe">|</span>

				<a href="forum.php?mod=forumdisplay&fid=$_G[fid]&orderby={$_GET['orderby']}&filter=dateline&dateline=7948800$forumdisplayadd[dateline]{if $_GET['archiveid']}&archiveid={$_GET['archiveid']}{/if}" {if $_GET['dateline'] == '7948800'}class="xw1"{/if}>{lang list_three_month}</a>
			</li>
		</ul>
	</div>

	<!--{if !$_G['setting']['closeforumorderby']}-->
	<div id="filter_orderby_menu" class="p_pop" style="display:none">
		<ul>
			<li><a href="forum.php?mod=forumdisplay&fid=$_G[fid]{if $_GET['archiveid']}&archiveid={$_GET['archiveid']}{/if}">{lang list_default_sort}</a></li>

			<li><a href="forum.php?mod=forumdisplay&fid=$_G[fid]&filter=author&orderby=dateline$forumdisplayadd[author]{if $_GET['archiveid']}&archiveid={$_GET['archiveid']}{/if}">{lang list_post_time}</a></li>

			<li><a href="forum.php?mod=forumdisplay&fid=$_G[fid]&filter=reply&orderby=replies$forumdisplayadd[reply]{if $_GET['archiveid']}&archiveid={$_GET['archiveid']}{/if}">{lang replies}</a></li>

			<li><a href="forum.php?mod=forumdisplay&fid=$_G[fid]&filter=reply&orderby=views$forumdisplayadd[view]{if $_GET['archiveid']}&archiveid={$_GET['archiveid']}{/if}">{lang views}</a></li>

			<li><a href="forum.php?mod=forumdisplay&fid=$_G[fid]&filter=lastpost&orderby=lastpost$forumdisplayadd[lastpost]{if $_GET['archiveid']}&archiveid={$_GET['archiveid']}{/if}">{lang lastpost}</a></li>

			<li><a href="forum.php?mod=forumdisplay&fid=$_G[fid]&filter=heat&orderby=heats$forumdisplayadd[heat]{if $_GET['archiveid']}&archiveid={$_GET['archiveid']}{/if}">{lang order_heats}</a></li>
		</ul>
	</div>
	<!--{/if}-->

<!--{/if}-->
	<!--{if !$_GET['archiveid']}--><!--{/if}-->
	<!--{hook/forumdisplay_postbutton_bottom}-->
</div>

<!--{if  $filter == 'hot'||$filter == 'digest'}-->
</div>
<!--{/if}-->
