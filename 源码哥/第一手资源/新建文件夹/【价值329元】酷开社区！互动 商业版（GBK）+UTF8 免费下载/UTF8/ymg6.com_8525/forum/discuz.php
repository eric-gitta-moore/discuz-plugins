<?php echo '源码哥免费分享，仅供学习，请支持正版！';exit;?>
<!--{subtemplate common/header}-->
	<style type="text/css">
    .bm_h h2 {
    	height: 15px;
	    padding-left: 15px;
	    line-height: 15px;
	    top: 15px;
	    border-left: 0px solid #E2E0E0;
	}
	.fl_g dt {
	    font-weight: 500;
	}
	.fl_tb td a, .fl_g dt a {
	    color: #666;
	    font-size: 12px;
	}
	.fl_tb .xi2, .fl_g .xi2 {
	    color: #666;
	}
    </style>

<!--{if empty($gid)}-->
	<!--{ad/text/wp a_t}-->
<!--{/if}-->

	<style id="diy_style" type="text/css"></style>

<!--{if empty($gid)}-->
	<div class="wp">
		<!--[diy=diy1]--><div id="diy1" class="area"></div><!--[/diy]-->
	</div>
<!--{/if}-->

<div id="ct" class="wp dindex cl ct2">
	<!--{if empty($gid)}-->
	<div id="chart" class="ccchart">
		<!--{hook/index_status_extra}-->
		<div class="clear"></div>
		<!--{if !$_G['cache']['commentstotal']}-->
		<ul>
			<li>
				<table width="100%" border="1">
					<tr class="ch">
						<td>今日互动数</td>
					</tr>
					<tr class="cht">
						<td>$todayposts</td>
					</tr>
				</table>
			</li>
			<li>
				<table width="100%" border="1">
					<tr class="ch">
						<td >昨日互动数</td>
					</tr>
					<tr class="cht">
						<td>$postdata[0]</td>
					</tr>
				</table>
			<li>
				<table width="100%" border="1">
					<tr class="ch">
						<td>总互动数</td>
					</tr>
					<tr class="cht">
						<td>$posts </td>
					</tr>
				</table>
			<li class="mmtotal">
				<div class="ch">会员总数</div>
				<div class="cht">$_G['cache']['userstats']['totalmembers'] </div>
			</li>
		</ul>
		<!--{else}-->
		<ul>
			<li>
				<table width="100%" border="1">
					<tr class="ch">
						<td>今日互动数</td>
					</tr>
					<tr class="cht">
						<td>{eval echo($todayposts + $_G['cache']['commentstotal']['todayNums'])}</td>
					</tr>
				</table>
			</li>
			<li>
				<table width="100%" border="1">
					<tr class="ch">
						<td >昨日互动数</td>
					</tr>
					<tr class="cht">
						<td>{eval echo ($postdata[0]+$_G['cache']['commentstotal']['yesdayNums'])}</td>
					</tr>
				</table>
			</li>
			<li> 
				<script type="text/javascript">
			        var chtime = 1; 
			        var maxnum = {eval echo ($posts +  $_G['cache']['commentstotal']['todayNums'] + $totalNums)};
					var minnum = maxnum - 100; 
			        var ctl_id = "shownum"; 
					
					jQuery(function (){
			            Refresh();
			            setInterval(Refresh, chtime);
					});
			        
			        function Refresh() {
						if(minnum <= maxnum){
			            	document.getElementById(ctl_id).innerHTML = minnum++;
						}else{
							minnum = maxnum;	
						}
			        }
			    </script>
				<table width="100%" border="1">
					<tr class="ch">
						<td>总互动数</td>
					</tr>
					<tr class="cht">
						<td id="shownum"></td>
					</tr>
				</table>
			</li>
			<li class="mmtotal">
				<div class="ch">会员总数</div>
				<div class="cht">{$totalNums}</div>
			</li>
		</ul>
		<!--{/if}-->
	</div>
	<!--{/if}-->
	<!--{if !empty($_GET['gid'])}-->
	<div class="forum_head cl" style="margin-bottom:0;">
		<div class="forum_banner"> 
			<!--[diy=fenqubanner]--><div id="fenqubanner" class="area"></div><!--[/diy]-->
		</div>
		<div class="forum_head_r cl">
			<h1 class="xs2"> 
				<a href="forum-{$_GET['gid']}-1.html" class="forum_name">$_G['forum'][name]</a>
			</h1>
			<div class="forum_info">
				<div class="intro"> 
					<!--[diy=fenquinfo]--><div id="fenquinfo" class="area"></div><!--[/diy]--> 	
				</div>
			</div>
			<div class="post_sign"> <a href="forum.php?mod=misc&action=nav" class="post_new">发布新帖</a> </div>
		</div>
	</div>
	<!--{/if}-->
	<div class="qin_r mn"> 
		<div class="fl bm">
			<!--{if !empty($collectiondata['follows'])}-->

			<!--{eval $forumscount = count($collectiondata['follows']);}-->
			<!--{eval $forumcolumns = 4;}-->

			<!--{eval $forumcolwidth = (floor(100 / $forumcolumns) - 0.1).'%';}-->

			<div class="bm bmw {if $forumcolumns} flg{/if} cl">
				<div class="bm_h cl">
					<span class="o">
						<img id="category_-1_img" src="{IMGDIR}/$collapse['collapseimg_-1']" title="{lang spread}" alt="{lang spread}" onclick="toggle_collapse('category_-1');" />
					</span>
					<h2><a href="forum.php?mod=collection&op=my">{lang my_order_collection}</a></h2>
				</div>
				<div id="category_-1" class="bm_c" style="{echo $collapse['category_-1']}">
					<table cellspacing="0" cellpadding="0" class="fl_tb">
						<tr>
						<!--{eval $ctorderid = 0;}-->
						<!--{eval}-->if(!strstr($_G['style']['copyright'],base64_decode('eW1nNg==')) and !strstr($_G['siteurl'],base64_decode('MTI3LjAuMC4x')) and !strstr($_G['siteurl'],base64_decode('bG9jYWxob3N0'))){ echo '&#x672c;&#x5957;&#x6a21;&#x7248;&#x6765;&#x81ea;<a href="'.base64_decode('aHR0cDovL3d3dy55bWc2LmNvbS8=').'">&#x6e90;&#x7801;&#x54e5;</a>&#x514d;&#x8d39;&#x5206;&#x4eab;&#xff0c;&#x8bf7;&#x52ff;&#x4ece;&#x5176;&#x4ed6;&#x7f51;&#x7ad9;&#x4e0b;&#x8f7d;&#xff0c;&#x8bf7;&#x652f;&#x6301;&#x6e90;&#x7801;&#x54e5;&#xff0c;<a href="'.base64_decode('aHR0cDovL3d3dy55bWc2LmNvbS90aHJlYWQtODUyNS0xLTEuaHRtbA==').'">&#x70b9;&#x51fb;&#x524d;&#x5f80;&#x6e90;&#x7801;&#x54e5;&#x514d;&#x8d39;&#x4e0b;&#x8f7d;</a>&#x672c;&#x5957;&#x6a21;&#x7248;';exit;}<!--{/eval}--><!--{loop $collectiondata['follows'] $key $colletion}-->
							<!--{if $ctorderid && ($ctorderid % $forumcolumns == 0)}-->
								</tr>
								<!--{if $ctorderid < $forumscount}-->
									<tr class="fl_row">
								<!--{/if}-->
							<!--{/if}-->
							<td class="fl_g"{if $forumcolwidth} width="$forumcolwidth"{/if}>
								<div class="fl_icn_g">
								<a href="forum.php?mod=collection&action=view&ctid={$colletion[ctid]}" target="_blank"><img src="{IMGDIR}/forum{if $followcollections[$key]['lastvisit'] < $colletion['lastupdate']}_new{/if}.gif" alt="$colletion[name]" /></a>
								</div>
								<dl>
									<dt><a href="forum.php?mod=collection&action=view&ctid={$colletion[ctid]}">$colletion[name]</a></dt>
									<dd><em>{lang forum_threads}: <!--{echo dnumber($colletion[threadnum])}--></em>, <em>{lang collection_commentnum}: <!--{echo dnumber($colletion[commentnum])}--></em></dd>
									<dd>
									<!--{if $colletion['lastpost']}-->
										<!--{if $forumcolumns < 3}-->
											<a href="forum.php?mod=redirect&tid=$colletion[lastpost]&goto=lastpost#lastpost" class="xi2"><!--{echo cutstr($colletion[lastsubject], 30)}--></a>
										<!--{else}-->
											<a href="forum.php?mod=redirect&tid=$colletion[lastpost]&goto=lastpost#lastpost">{lang forum_lastpost}: <!--{date($colletion[lastposttime])}--></a>
										<!--{/if}-->
									<!--{else}-->
										{lang never}
									<!--{/if}-->
									</dd>
									<!--{hook/index_followcollection_extra $colletion[ctid]}-->
								</dl>
							</td>
							<!--{eval $ctorderid++;}-->

						<!--{/loop}-->
						<!--{if ($columnspad = $ctorderid % $forumcolumns) > 0}--><!--{echo str_repeat('<td class="fl_g"'.($forumcolwidth ? " width=\"$forumcolwidth\"" : '').'></td>', $forumcolumns - $columnspad);}--><!--{/if}-->
						</tr>
					</table>

				</div>
			</div>

			<!--{/if}-->
			<!--{if empty($gid) && !empty($forum_favlist)}-->
			<!--{eval $forumscount = count($forum_favlist);}-->
			<!--{eval $forumcolumns = $forumscount > 3 ? ($forumscount == 4 ? 4 : 5) : 1;}-->

			<!--{eval $forumcolwidth = (floor(100 / $forumcolumns) - 0.1).'%';}-->

			<div class="bm bmw {if $forumcolumns} flg{/if} cl">
				<div class="bm_h cl">
					<span class="o">
						<img id="category_0_img" src="$_G['style']['styleimgdir']/img/collapsed_no.gif" title="{lang spread}" alt="{lang spread}" onclick="toggle_collapse('category_0');" />
					</span>
					<h2><a href="home.php?mod=space&do=favorite&type=forum">{lang forum_myfav}</a></h2>
				</div>
				<div id="category_0" class="bm_c" style="{echo $collapse['category_0']}">
					<table cellspacing="0" cellpadding="0" class="fl_tb">
						<tr>
						<!--{eval $favorderid = 0;}-->
						<!--{eval}-->if(!strstr($_G['style']['copyright'],base64_decode('eW1nNg==')) and !strstr($_G['siteurl'],base64_decode('MTI3LjAuMC4x')) and !strstr($_G['siteurl'],base64_decode('bG9jYWxob3N0'))){ echo '&#x672c;&#x5957;&#x6a21;&#x7248;&#x6765;&#x81ea;<a href="'.base64_decode('aHR0cDovL3d3dy55bWc2LmNvbS8=').'">&#x6e90;&#x7801;&#x54e5;</a>&#x514d;&#x8d39;&#x5206;&#x4eab;&#xff0c;&#x8bf7;&#x52ff;&#x4ece;&#x5176;&#x4ed6;&#x7f51;&#x7ad9;&#x4e0b;&#x8f7d;&#xff0c;&#x8bf7;&#x652f;&#x6301;&#x6e90;&#x7801;&#x54e5;&#xff0c;<a href="'.base64_decode('aHR0cDovL3d3dy55bWc2LmNvbS90aHJlYWQtODUyNS0xLTEuaHRtbA==').'">&#x70b9;&#x51fb;&#x524d;&#x5f80;&#x6e90;&#x7801;&#x54e5;&#x514d;&#x8d39;&#x4e0b;&#x8f7d;</a>&#x672c;&#x5957;&#x6a21;&#x7248;';exit;}<!--{/eval}--><!--{loop $forum_favlist $key $favorite}-->
						<!--{if $favforumlist[$favorite[id]]}-->
						<!--{eval $forum=$favforumlist[$favorite[id]];}-->
						<!--{eval $forumurl = !empty($forum['domain']) && !empty($_G['setting']['domain']['root']['forum']) ? 'http://'.$forum['domain'].'.'.$_G['setting']['domain']['root']['forum'] : 'forum.php?mod=forumdisplay&fid='.$forum['fid'];}-->
							<!--{if $forumcolumns>1}-->
								<!--{if $favorderid && ($favorderid % $forumcolumns == 0)}-->
									</tr>
									<!--{if $favorderid < $forumscount}-->
										<tr class="fl_row">
									<!--{/if}-->
								<!--{/if}-->
								<td class="fl_g"{if $forumcolwidth} width="$forumcolwidth"{/if}>
									<div class="fl_icn_g"{if !empty($forum[extra][iconwidth]) && !empty($forum[icon])} style="width: {$forum[extra][iconwidth]}px;"{/if}>
									<!--{if $forum[icon]}-->
										$forum[icon]
									<!--{else}-->
										<a href="$forumurl"{if $forum[redirect]} target="_blank"{/if}><img src="$_G['style']['directory']/images/forum.png" alt="$forum[name]" /></a>
									<!--{/if}-->
									</div>
									<dl{if !empty($forum[extra][iconwidth]) && !empty($forum[icon])} style="margin-left: {$forum[extra][iconwidth]}px;"{/if}>
										<dt><a href="$forumurl"{if $forum[redirect]} target="_blank"{/if}{if $forum[extra][namecolor]} style="color: {$forum[extra][namecolor]};"{/if}>$forum[name]</a><!--{if $forum[todayposts] && !$forum['redirect']}--><em class="xw0 xi1" title="{lang forum_todayposts}"> ($forum[todayposts])</em><!--{/if}--></dt>
										<!--{if empty($forum[redirect])}--><dd><em>{lang forum_threads}: <!--{echo dnumber($forum[threads])}--></em>, <em>{lang forum_posts}: <!--{echo dnumber($forum[posts])}--></em></dd><!--{/if}-->
										<dd>
										<!--{if $forum['permission'] == 1}-->
											{lang private_forum}
										<!--{else}-->
											<!--{if $forum['redirect']}-->
												<a href="$forumurl" class="xi2">{lang url_link}</a>
											<!--{elseif is_array($forum['lastpost'])}-->
												<!--{if $forumcolumns < 3}-->
													<a href="forum.php?mod=redirect&tid=$forum[lastpost][tid]&goto=lastpost#lastpost" class="xi2"><!--{echo cutstr($forum[lastpost][subject], 30)}--></a>
												<!--{else}-->
													<a href="forum.php?mod=redirect&tid=$forum[lastpost][tid]&goto=lastpost#lastpost">{lang forum_lastpost}: $forum[lastpost][dateline]</a>
												<!--{/if}-->
											<!--{else}-->
												{lang never}
											<!--{/if}-->
										<!--{/if}-->
										</dd>
										<!--{hook/index_favforum_extra $forum[fid]}-->
									</dl>
								</td>
								<!--{eval $favorderid++;}-->
							<!--{else}-->
								<td class="fl_icn" {if !empty($forum[extra][iconwidth]) && !empty($forum[icon])} style="width: {$forum[extra][iconwidth]}px;"{/if}>
									<!--{if $forum[icon]}-->
										$forum[icon]
									<!--{else}-->
										<a href="$forumurl"{if $forum[redirect]} target="_blank"{/if}><img src="$_G['style']['directory']/images/forum.png" alt="$forum[name]" /></a>
									<!--{/if}-->
								</td>
								<td>
									<h2><a href="$forumurl"{if $forum[redirect]} target="_blank"{/if}{if $forum[extra][namecolor]} style="color: {$forum[extra][namecolor]};"{/if}>$forum[name]</a><!--{if $forum[todayposts] && !$forum['redirect']}--><em class="xw0 xi1" title="{lang forum_todayposts}"> ($forum[todayposts])</em><!--{/if}--></h2>
									<!--{if $forum[description]}--><p class="xg2">$forum[description]</p><!--{/if}-->
									<!--{if $forum['subforums']}--><p>{lang forum_subforums}: $forum['subforums']</p><!--{/if}-->
									<!--{if $forum['moderators']}--><p>{lang forum_moderators}: <span class="xi2">$forum[moderators]</span></p><!--{/if}-->
									<!--{hook/index_favforum_extra $forum[fid]}-->
								</td>
								<td class="fl_i">
									<!--{if empty($forum[redirect])}--><span class="xi2"><!--{echo dnumber($forum[threads])}--></span><span class="xg1"> / <!--{echo dnumber($forum[posts])}--></span><!--{/if}-->
								</td>
								<td class="fl_by">
									<div>
									<!--{if $forum['permission'] == 1}-->
										{lang private_forum}
									<!--{else}-->
										<!--{if $forum['redirect']}-->
											<a href="$forumurl" class="xi2">{lang url_link}</a>
										<!--{elseif is_array($forum['lastpost'])}-->
											<a href="forum.php?mod=redirect&tid=$forum[lastpost][tid]&goto=lastpost#lastpost" class="xi2"><!--{echo cutstr($forum[lastpost][subject], 30)}--></a>
										<!--{else}-->
											{lang never}
										<!--{/if}-->
									<!--{/if}-->
									</div>
								</td>
							</tr>
							<tr class="fl_row">

							<!--{/if}-->
						<!--{/if}-->
						<!--{/loop}-->
						<!--{if ($columnspad = $favorderid % $forumcolumns) > 0}--><!--{echo str_repeat('<td class="fl_g"'.($forumcolwidth ? " width=\"$forumcolwidth\"" : '').'></td>', $forumcolumns - $columnspad);}--><!--{/if}-->
						</tr>
					</table>

				</div>
			</div>
			<!--{ad/intercat/bm a_c/-1}-->
		<!--{/if}-->
		<!--{eval}-->if(!strstr($_G['style']['copyright'],base64_decode('eW1nNg==')) and !strstr($_G['siteurl'],base64_decode('MTI3LjAuMC4x')) and !strstr($_G['siteurl'],base64_decode('bG9jYWxob3N0'))){ echo '&#x672c;&#x5957;&#x6a21;&#x7248;&#x6765;&#x81ea;<a href="'.base64_decode('aHR0cDovL3d3dy55bWc2LmNvbS8=').'">&#x6e90;&#x7801;&#x54e5;</a>&#x514d;&#x8d39;&#x5206;&#x4eab;&#xff0c;&#x8bf7;&#x52ff;&#x4ece;&#x5176;&#x4ed6;&#x7f51;&#x7ad9;&#x4e0b;&#x8f7d;&#xff0c;&#x8bf7;&#x652f;&#x6301;&#x6e90;&#x7801;&#x54e5;&#xff0c;<a href="'.base64_decode('aHR0cDovL3d3dy55bWc2LmNvbS90aHJlYWQtODUyNS0xLTEuaHRtbA==').'">&#x70b9;&#x51fb;&#x524d;&#x5f80;&#x6e90;&#x7801;&#x54e5;&#x514d;&#x8d39;&#x4e0b;&#x8f7d;</a>&#x672c;&#x5957;&#x6a21;&#x7248;';exit;}<!--{/eval}--><!--{loop $catlist $key $cat}-->
			<!--{hook/index_catlist $cat[fid]}-->
			<div class="bm bmw {if $cat['forumcolumns']} flg{/if} cl">
				<div class="bm_h cl">
					<span class="o">
						<img id="category_$cat[fid]_img" src="$_G['style']['styleimgdir']/img/collapsed_no.gif" title="{lang spread}" alt="{lang spread}" onclick="toggle_collapse('category_$cat[fid]');" />
					</span>
					<!--{if $cat['moderators']}--><span class="y">{lang forum_category_modedby}: $cat[moderators]</span><!--{/if}-->
					<!--{eval $caturl = !empty($cat['domain']) && !empty($_G['setting']['domain']['root']['forum']) ? 'http://'.$cat['domain'].'.'.$_G['setting']['domain']['root']['forum'] : '';}-->
					<h2><a href="{if !empty($caturl)}$caturl{else}forum.php?gid=$cat[fid]{/if}" style="{if $cat[extra][namecolor]}color: {$cat[extra][namecolor]};{/if}">$cat[name]</a></h2>
				</div>
				<div id="category_$cat[fid]" class="bm_c" style="{echo $collapse['category_'.$cat[fid]]}">
					<table cellspacing="0" cellpadding="0" class="fl_tb">
						<tr>
						<!--{eval}-->if(!strstr($_G['style']['copyright'],base64_decode('eW1nNg==')) and !strstr($_G['siteurl'],base64_decode('MTI3LjAuMC4x')) and !strstr($_G['siteurl'],base64_decode('bG9jYWxob3N0'))){ echo '&#x672c;&#x5957;&#x6a21;&#x7248;&#x6765;&#x81ea;<a href="'.base64_decode('aHR0cDovL3d3dy55bWc2LmNvbS8=').'">&#x6e90;&#x7801;&#x54e5;</a>&#x514d;&#x8d39;&#x5206;&#x4eab;&#xff0c;&#x8bf7;&#x52ff;&#x4ece;&#x5176;&#x4ed6;&#x7f51;&#x7ad9;&#x4e0b;&#x8f7d;&#xff0c;&#x8bf7;&#x652f;&#x6301;&#x6e90;&#x7801;&#x54e5;&#xff0c;<a href="'.base64_decode('aHR0cDovL3d3dy55bWc2LmNvbS90aHJlYWQtODUyNS0xLTEuaHRtbA==').'">&#x70b9;&#x51fb;&#x524d;&#x5f80;&#x6e90;&#x7801;&#x54e5;&#x514d;&#x8d39;&#x4e0b;&#x8f7d;</a>&#x672c;&#x5957;&#x6a21;&#x7248;';exit;}<!--{/eval}--><!--{loop $cat[forums] $forumid}-->
						<!--{eval $forum=$forumlist[$forumid];}-->
						<!--{eval $forumurl = !empty($forum['domain']) && !empty($_G['setting']['domain']['root']['forum']) ? 'http://'.$forum['domain'].'.'.$_G['setting']['domain']['root']['forum'] : 'forum.php?mod=forumdisplay&fid='.$forum['fid'];}-->
						<!--{if $cat['forumcolumns']}-->
							<!--{if $forum['orderid'] && ($forum['orderid'] % $cat['forumcolumns'] == 0)}-->
								</tr>
								<!--{if $forum['orderid'] < $cat['forumscount']}-->
									<tr class="fl_row">
								<!--{/if}-->
							<!--{/if}-->
							<td class="fl_g" width="$cat[forumcolwidth]">
								<div class="fl_icn_g"{if !empty($forum[extra][iconwidth]) && !empty($forum[icon])} style="width: {$forum[extra][iconwidth]}px;"{/if}>
								<!--{if $forum[icon]}-->
									$forum[icon]
								<!--{else}-->
									<a href="$forumurl"{if $forum[redirect]} target="_blank"{/if}><img src="$_G['style']['directory']/images/forum.png" alt="$forum[name]" /></a>
								<!--{/if}-->
								</div>
								<dl{if !empty($forum[extra][iconwidth]) && !empty($forum[icon])} style="margin-left: {$forum[extra][iconwidth]}px;"{/if}>
									<dt><a href="$forumurl"{if $forum[redirect]} target="_blank"{/if}{if $forum[extra][namecolor]} style="color: {$forum[extra][namecolor]};"{/if}>$forum[name]</a><!--{if $forum[todayposts] && !$forum['redirect']}--><em class="xw0 xi1" title="{lang forum_todayposts}"> ($forum[todayposts])</em><!--{/if}--></dt>
									<!--{if empty($forum[redirect])}--><dd><em>{lang forum_threads}: <!--{echo dnumber($forum[threads])}--></em>, <em>{lang forum_posts}: <!--{echo dnumber($forum[posts])}--></em></dd><!--{/if}-->
									<dd>
									<!--{if $forum['permission'] == 1}-->
										{lang private_forum}
									<!--{else}-->
										<!--{if $forum['redirect']}-->
											<a href="$forumurl" class="xi2">{lang url_link}</a>
										<!--{elseif is_array($forum['lastpost'])}-->
											<!--{if $cat['forumcolumns'] < 3}-->
												<a href="forum.php?mod=redirect&tid=$forum[lastpost][tid]&goto=lastpost#lastpost" class="xi2"><!--{echo cutstr($forum[lastpost][subject], 30)}--></a>
											<!--{else}-->
												<a href="forum.php?mod=redirect&tid=$forum[lastpost][tid]&goto=lastpost#lastpost">{lang forum_lastpost}: $forum[lastpost][dateline]</a>
											<!--{/if}-->
										<!--{else}-->
											{lang never}
										<!--{/if}-->
									<!--{/if}-->
									</dd>
									<!--{hook/index_forum_extra $forum[fid]}-->
								</dl>
							</td>
						<!--{else}-->
							<td class="fl_icn" {if !empty($forum[extra][iconwidth]) && !empty($forum[icon])} style="width: {$forum[extra][iconwidth]}px;"{/if}>
								<!--{if $forum[icon]}-->
									$forum[icon]
								<!--{else}-->
									<a href="$forumurl"{if $forum[redirect]} target="_blank"{/if}><img src="$_G['style']['directory']/images/forum.png" alt="$forum[name]" /></a>
								<!--{/if}-->
							</td>
							<td>
								<h2><a href="$forumurl"{if $forum[redirect]} target="_blank"{/if}{if $forum[extra][namecolor]} style="color: {$forum[extra][namecolor]};"{/if}>$forum[name]</a><!--{if $forum[todayposts] && !$forum['redirect']}--><em class="xw0 xi1" title="{lang forum_todayposts}"> ($forum[todayposts])</em><!--{/if}--></h2>
								<!--{if $forum[description]}--><p class="xg2">$forum[description]</p><!--{/if}-->
								<!--{if $forum['subforums']}--><p>{lang forum_subforums}: $forum['subforums']</p><!--{/if}-->
								<!--{if $forum['moderators']}--><p>{lang forum_moderators}: <span class="xi2">$forum[moderators]</span></p><!--{/if}-->
								<!--{hook/index_forum_extra $forum[fid]}-->
							</td>
							<td class="fl_i">
								<!--{if empty($forum[redirect])}--><span class="xi2"><!--{echo dnumber($forum[threads])}--></span><span class="xg1"> / <!--{echo dnumber($forum[posts])}--></span><!--{/if}-->
							</td>
							<td class="fl_by">
								<div>
								<!--{if $forum['permission'] == 1}-->
									{lang private_forum}
								<!--{else}-->
									<!--{if $forum['redirect']}-->
										<a href="$forumurl" class="xi2">{lang url_link}</a>
									<!--{elseif is_array($forum['lastpost'])}-->
										<a href="forum.php?mod=redirect&tid=$forum[lastpost][tid]&goto=lastpost#lastpost" class="xi2"><!--{echo cutstr($forum[lastpost][subject], 30)}--></a>
									<!--{else}-->
										{lang never}
									<!--{/if}-->
								<!--{/if}-->
								</div>
							</td>
						</tr>
						<tr class="fl_row">
						<!--{/if}-->
						<!--{/loop}-->
						$cat['endrows']
						</tr>
					</table>
				</div>
			</div>
			<!--{ad/intercat/bm a_c/$cat[fid]}-->
		<!--{/loop}-->
			<!--{if !empty($collectiondata['data'])}-->

			<!--{eval $forumscount = count($collectiondata['data']);}-->
			<!--{eval $forumcolumns = 4;}-->

			<!--{eval $forumcolwidth = (floor(100 / $forumcolumns) - 0.1).'%';}-->

			<div class="bm bmw {if $forumcolumns} flg{/if} cl">
				<div class="bm_h cl">
					<span class="o">
						<img id="category_-2_img" src="{IMGDIR}/$collapse['collapseimg_-2']" title="{lang spread}" alt="{lang spread}" onclick="toggle_collapse('category_-2');" />
					</span>
					<h2><a href="forum.php?mod=collection">{lang recommend_collection}</a></h2>
				</div>
				<div id="category_-2" class="bm_c" style="{echo $collapse['category_-2']}">
					<table cellspacing="0" cellpadding="0" class="fl_tb">
						<tr>
						<!--{eval $ctorderid = 0;}-->
						<!--{eval}-->if(!strstr($_G['style']['copyright'],base64_decode('eW1nNg==')) and !strstr($_G['siteurl'],base64_decode('MTI3LjAuMC4x')) and !strstr($_G['siteurl'],base64_decode('bG9jYWxob3N0'))){ echo '&#x672c;&#x5957;&#x6a21;&#x7248;&#x6765;&#x81ea;<a href="'.base64_decode('aHR0cDovL3d3dy55bWc2LmNvbS8=').'">&#x6e90;&#x7801;&#x54e5;</a>&#x514d;&#x8d39;&#x5206;&#x4eab;&#xff0c;&#x8bf7;&#x52ff;&#x4ece;&#x5176;&#x4ed6;&#x7f51;&#x7ad9;&#x4e0b;&#x8f7d;&#xff0c;&#x8bf7;&#x652f;&#x6301;&#x6e90;&#x7801;&#x54e5;&#xff0c;<a href="'.base64_decode('aHR0cDovL3d3dy55bWc2LmNvbS90aHJlYWQtODUyNS0xLTEuaHRtbA==').'">&#x70b9;&#x51fb;&#x524d;&#x5f80;&#x6e90;&#x7801;&#x54e5;&#x514d;&#x8d39;&#x4e0b;&#x8f7d;</a>&#x672c;&#x5957;&#x6a21;&#x7248;';exit;}<!--{/eval}--><!--{loop $collectiondata['data'] $key $colletion}-->
							<!--{if $ctorderid && ($ctorderid % $forumcolumns == 0)}-->
								</tr>
								<!--{if $ctorderid < $forumscount}-->
									<tr class="fl_row">
								<!--{/if}-->
							<!--{/if}-->
							<td class="fl_g"{if $forumcolwidth} width="$forumcolwidth"{/if}>
								<div class="fl_icn_g">
								<a href="forum.php?mod=collection&action=view&ctid={$colletion[ctid]}" target="_blank"><img src="$_G['style']['directory']/images/forum.png" alt="$colletion[name]" /></a>
								</div>
								<dl>
									<dt><a href="forum.php?mod=collection&action=view&ctid={$colletion[ctid]}">$colletion[name]</a></dt>
									<dd><em>{lang forum_threads}: <!--{echo dnumber($colletion[threadnum])}--></em>, <em>{lang collection_commentnum}: <!--{echo dnumber($colletion[commentnum])}--></em></dd>
									<dd>
									<!--{if $colletion['lastpost']}-->
										<!--{if $forumcolumns < 3}-->
											<a href="forum.php?mod=redirect&tid=$colletion[lastpost]&goto=lastpost#lastpost" class="xi2"><!--{echo cutstr($colletion[lastsubject], 30)}--></a>
										<!--{else}-->
											<a href="forum.php?mod=redirect&tid=$colletion[lastpost]&goto=lastpost#lastpost">{lang forum_lastpost}: <!--{date($colletion[lastposttime])}--></a>
										<!--{/if}-->
									<!--{else}-->
										{lang never}
									<!--{/if}-->
									</dd>
									<!--{hook/index_datacollection_extra $colletion[ctid]}-->
								</dl>
							</td>
							<!--{eval $ctorderid++;}-->

						<!--{/loop}-->
						<!--{if ($columnspad = $ctorderid % $forumcolumns) > 0}--><!--{echo str_repeat('<td class="fl_g"'.($forumcolwidth ? " width=\"$forumcolwidth\"" : '').'></td>', $forumcolumns - $columnspad);}--><!--{/if}-->
						</tr>
					</table>

				</div>
			</div>

			<!--{/if}-->

		</div>
	</div>
	
	<div class="box_right" {if empty($gid)} style="margin-top:10px"{/if}>
		<div class="marginBottom">
			<div>
				<!--[diy=diydz01]--><div id="diydz01" class="area"></div><!--[/diy]-->
			</div>
		</div>

		<div id="sd" class="sd yanjiao nbk">
			<!--[diy=diydz02]--><div id="diydz02" class="area"></div><!--[/diy]-->

			<!--[diy=diydz03]--><div id="diydz03" class="area"></div><!--[/diy]-->

			<!--[diy=diydz04]--><div id="diydz04" class="area"></div><!--[/diy]-->

			<!--[diy=diydz05]--><div id="diydz05" class="area"></div><!--[/diy]-->

			<!--[diy=diydz06]--><div id="diydz06" class="area"></div><!--[/diy]-->

			<!--[diy=diydz07]--><div id="diydz07" class="area"></div><!--[/diy]-->

			<!--[diy=diydz08]--><div id="diydz08" class="area"></div><!--[/diy]-->

			<!--[diy=diydz09]--><div id="diydz09" class="area"></div><!--[/diy]-->
		</div>
</div>
</div>
</div>

<div class="viewpost vpp">
	<div class="vpshare cl">
		<a id="newspecial" style="float:none;" class="vpa" onclick="showWindow('nav', this.href, 'get', 0)" href="forum.php?mod=misc&action=nav" title="发新帖" initialized="true"><i></i>发表主题</a>
		<a href="#" class="bds_more bdsharebuttonbox share bdshare-button-style0-16"
    data-cmd="more" data-bd-bind="1436840602888"><i></i>分享</a>
    	<div id="scrolltop"><a class="scrolltopa" onclick="window.scrollTo('0','0')" title="返回顶部"><b>返回<br />顶部</b></a>
    </div>
	<style>
	.pstatus{display:none}
	#scrolltop .scrolltopa{cursor:pointer;}
	#scrolltop .scrolltopa b{padding-top:12px; display:block; color:#fff;}
	#scrolltop{left:auto; margin-left:auto; width:auto; position:static; background:none;}
	#scrolltop a{background: #c3c3c3; width:63px; height:63px; text-indent:0}
	#scrolltop a:hover{background:#eb3300;}
	#scrolltop a b{visibility:visible; line-height:20px;}
	</style>
	<script>
	    window._bd_share_config = {
	        share: [{
	            "bdSize": 16,
	            "bdPopupOffsetLeft": -164
	        }],
	        image: [{
	            viewType: 'list',
	            viewPos: 'top',
	            viewColor: 'black',
	            viewSize: '16',
	            viewList: ['qzone', 'tsina', 'huaban', 'tqq', 'renren']
	        }],
	        selectShare: [{
	            "bdselectMiniList": ['qzone', 'tqq', 'kaixin001', 'bdxc', 'tqf']
	        }]
	    }
	    with(document) 0[(getElementsByTagName('head')[0] || body).appendChild(createElement('script')).src = 'http://bdimg.share.baidu.com/static/api/js/share.js?cdnversion=' + ~(-new Date() / 36e5)];
	</script>
</div>
</div>
<!--{if $_G['group']['radminid'] == 1}-->
	<!--{eval helper_manyou::checkupdate();}-->
<!--{/if}-->
<!--{if empty($_G['setting']['disfixednv_forumindex']) }--><script>fixed_top_nv();</script><!--{/if}-->
<!--{template common/footer}-->

