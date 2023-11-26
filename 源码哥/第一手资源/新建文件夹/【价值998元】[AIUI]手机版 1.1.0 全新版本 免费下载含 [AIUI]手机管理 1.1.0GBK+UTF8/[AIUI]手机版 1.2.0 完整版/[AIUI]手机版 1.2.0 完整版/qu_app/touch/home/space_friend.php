<?PHP exit('QQÈº£º550494646');?>
<!--{if empty($diymode)}-->
<!--{template common/header}-->

<!--{block visittitle}-->
	<!--{if $_GET['view'] == 'blacklist'}-->
		{lang my_blacklist}
	<!--{elseif $_GET['view'] == 'trace'}-->
		{lang my_trace}
    <!--{elseif $_GET['view'] == 'find'}-->
		$alang_findhy
	<!--{elseif $_GET['view'] == 'visitor'}-->
		$alang_zuixinlaifang
    <!--{elseif $_GET['view'] == 'me'}-->
		{lang all_friend_list}
	<!--{/if}-->
<!--{/block}-->

<!-- header start -->
<header class="header">
    <div class="nav">
        <a href="#" class="z back"><i class="iconfont icon-back"></i></a>
        <span class="name">$visittitle</span>
    </div>
</header>
<!-- header end -->

<div class="ainuo_myvisit cl">
	<div class="cl">
    	{if $_GET['do'] == 'friend' && ($_GET['view'] == 'blacklist' || $_GET['view'] == 'trace' || $_GET['view'] == 'visitor')}
		<div class="ainuo_usertb cl">
        	<ul class="tb avisit cl">
                <li{$a_actives[visitor]}><a href="home.php?mod=space&do=friend&view=visitor">$alang_zuixinlaifang</a></li>
                <li{$a_actives[trace]}><a href="home.php?mod=space&do=friend&view=trace">{lang my_trace}</a></li>
                <li$actives[find]><a href="home.php?mod=spacecp&ac=friend&op=find">$alang_findhy</a></li>
                <li{$a_actives[blacklist]}><a href="home.php?mod=space&do=friend&view=blacklist">{lang my_blacklist}</a></li>
            </ul>
        </div>
        {/if}
        {if $_GET['do'] == 'friend' && ($_GET['view'] == 'me')}
		<div class="ainuo_usertb cl">
        	<ul class="tb ahaoyou cl">
                <li$actives[me]><a href="home.php?mod=space&do=friend">{lang friend_list}</a></li>
                <!--{if $_G['setting']['regstatus'] > 1}-->
                    <li$actives[invite]><a href="home.php?mod=spacecp&ac=invite">{lang invite_friend}</a></li>
                <!--{/if}-->
                <li$actives[request]><a href="home.php?mod=spacecp&ac=friend&op=request">{lang friend_request}</a></li>	
                <li$actives[group]><a href="home.php?mod=spacecp&ac=friend&op=group">{lang set_friend_group}</a></li>
            </ul>
        </div>
        {/if}
        <div class="grey_line cl"></div>
		<div class="section1 cl">
			<!--{if $space[self]}-->
				<div class="dashedtip cl">
					<!--{if $_GET['view']=='blacklist'}-->
						{lang blacklist_message}
					<!--{elseif $_GET['view']=='me'}-->
						<p class="y">
							{lang count_member}
						<!--{if $maxfriendnum}-->
							({lang max_friend_num})
							<!--{if $_G['setting']['magicstatus'] && $_G[setting][magics][friendnum]}-->
								<img src="{STATICURL}image/magic/friendnum.small.gif" alt="friendnum" class="vm" />
								<a id="a_magic_friendnum" href="home.php?mod=magic&mid=friendnum" onmousemove="showTip(this)" tip="{lang expansion_friend_message}" onclick="showWindow('magics', this.href, 'get', 0);return false;">{lang expansion_friend}</a>
							<!--{/if}-->
						<!--{/if}-->
						</p>
						<p class="z">
							{lang friend_message}
						</p>
					<!--{elseif $_GET['view']=='online'}-->
						<!--{if $_GET['type'] == 'friend'}-->
							{lang online_friend_visit}
						<!--{elseif $_GET['type']=='near'}-->
							{lang near_friend_visit}
						<!--{else}-->
							{lang view_online_friend}
						<!--{/if}-->
					<!--{elseif $_GET['view']=='visitor'}-->
						{lang visitor_list}
					<!--{elseif $_GET['view']=='trace'}-->
						{lang trace_list}
					<!--{/if}-->
				</div>

				<!--{if $_GET['view']=='blacklist'}-->
				<div class="add_black cl">
					<form method="post" autocomplete="off" name="blackform" action="home.php?mod=spacecp&ac=friend&op=blacklist&start=$_GET[start]">
						<table cellpadding="0" cellspacing="0" width="100%">
							<tr>
								<td>
									<input type="text" name="username" value="" placeholder="{lang add_blacklist}" />
								</td>
							</tr>
						</table>
						<input type="hidden" name="blacklistsubmit" value="true" />
						<input type="hidden" name="formhash" value="{FORMHASH}" />
                        <div class="cl">
                        	<button type="submit" name="blacklistsubmit_btn" id="moodsubmit_btn" value="true" class="formdialog">{lang add}</button>
                        </div>
					</form>
				</div>
				<!--{/if}-->
			<!--{/if}-->
<!--{else}-->
	<!--{if $_G[setting][homepagestyle]}-->
		<div id="ct" class="ct2 wp cl">
			<div class="mn">
				<div class="bm">
				<div class="bm_c">
	<!--{else}-->
		<!--{template common/header}-->

		<div id="ct" class="ct1 wp cl">
			<div class="mn">
				
				<div class="bm bw0">
					<div class="bm_c">
	<!--{/if}-->

<!--{/if}-->
			<!--{if $space[self]}-->
						<!--{if $list}-->
							<div id="friend_ul">
								<ul class="buddy cl">
								<!--{loop $list $key $value}-->
									<li id="friend_{$value[uid]}_li">
									<!--{if $value[username] == ''}-->
										<div class="avt"><img src="{STATICURL}image/magic/hidden.gif" alt="{lang anonymity}" /></div>
										<h4>{lang anonymity}</h4>
									<!--{else}-->
										<div class="avt">
											<a href="home.php?mod=space&uid=$value[uid]">
												<!--{if $ols[$value[uid]]}--><em class="gol" title="{lang online} {date($ols[$value[uid]], 'H:i')}"></em><!--{/if}-->
												<!--{avatar($value[uid],middle)}-->
											</a>
										</div>
										<h4>
											<span class="y">
											<!--{if $_GET['view'] == 'blacklist'}-->
												<a href="home.php?mod=spacecp&ac=friend&op=blacklist&subop=delete&uid=$value[uid]&start=$_GET[start]">{lang delete_blacklist}</a>
											<!--{elseif $_GET['view'] == 'visitor' || $_GET['view'] == 'trace'}-->
												<!--{date($value[dateline], 'n{lang month}j{lang day}')}-->
											<!--{elseif $_GET['view'] == 'online'}-->
												<!--{date($ols[$value[uid]], 'H:i')}-->
											<!--{else}-->
												<a ainuoto="home.php?mod=spacecp&ac=friend&op=changenum&uid=$value[uid]&handlekey=hotuserhk_{$value[uid]}" id="friendnum_$value[uid]" title="{lang hot}" class="hot ainuodialog">{lang hot}(<span id="spannum_$value[uid]">$value[num]</span>)</a>
											<!--{/if}-->
											</span>
											<a href="home.php?mod=space&uid=$value[uid]"{eval g_color($value[groupid]);}>$value[username]</a>
											<!--{eval g_icon($value[groupid]);}-->
											<!--{if $value['videostatus']}-->
												<img src="{IMGDIR}/videophoto.gif" alt="videophoto" class="vm" />
											<!--{/if}-->
											
										</h4>
                                        <!--{if $space[self] && $value[note]}-->
                                            <p id="friend_note_$value[uid]" class="note cl" title="$value[note]">$value[note]</p>
                                        <!--{/if}-->
                                        <p class="maxh">$value[recentnote]</p>
									<!--{/if}-->
										<div class="caozuo">
											<!--{if isset($value['follow']) && $key != $_G['uid'] && $value[username] != ''}-->
											<a ainuoto="home.php?mod=spacecp&ac=follow&op={if $value['follow']}del{else}add{/if}&fuid=$value[uid]&hash={FORMHASH}&from=a_followmod_" id="a_followmod_$key" class="ainuodialog {if $value['follow']}flw_btn_unfo{else}flw_btn_fo{/if}"><!--{if $value['follow']}-->$alang_quxiaoguanzhu<!--{else}-->$alang_guanzhu<!--{/if}--></a>
											<!--{/if}-->
										
											<!--{if !$value[isfriend] && $value[username] != ''}-->
											<a ainuoto="home.php?mod=spacecp&ac=friend&op=add&uid=$value[uid]&handlekey=adduserhk_{$value[uid]}" id="a_friend_$key" class="ainuodialog addf">{lang add_friend}</a>
											<!--{elseif !in_array($_GET['view'], array('blacklist', 'visitor', 'trace', 'online'))}-->
                                                <!--{if $value[isfriend] && !in_array($_GET['view'], array('blacklist', 'visitor', 'trace', 'online'))}-->
                                                    <a ainuoto="home.php?mod=spacecp&ac=friend&op=changegroup&uid=$value[uid]&handlekey=editgrouphk_{$value[uid]}" id="friend_group_$value[uid]" class="ainuodialog afz">{lang set_friend_group}</a>
                                                    <a ainuoto="home.php?mod=spacecp&ac=friend&op=editnote&uid=$value[uid]&handlekey=editnote_{$value[uid]}" id="friend_editnote_$value[uid]" class="ainuodialog abz">{lang friend_editnote}</a>
                                                    <a ainuoto="home.php?mod=spacecp&ac=friend&op=ignore&uid=$value[uid]&handlekey=delfriendhk_{$value[uid]}" id="a_ignore_$key" class="ainuodialog asc">{lang delete}</a>
                                                <!--{/if}-->
											<!--{/if}-->
										</div>
										
											
										
										<!--{if $value[uid] != $_G['uid'] && $value[username] != ''}-->
										<div id="interaction_$value[uid]_menu" class="p_pop" style="display: none; width: 80px;">
											<p><a href="home.php?mod=space&uid=$value[uid]&do=profile" title="{lang view_profile}">{lang view_profile}</a></p>
											<p><a href="home.php?mod=space&uid=$value[uid]" title="{lang visit_friend}">{lang visit_friend}</a></p>
											<p><a href="home.php?mod=spacecp&ac=poke&op=send&uid=$value[uid]" id="a_poke_$key" onclick="showWindow(this.id, this.href, 'get', 0);" title="{lang say_hi}">{lang say_hi}</a></p>
											<p><a href="home.php?mod=spacecp&ac=pm&op=showmsg&handlekey=showmsg_$value[uid]&touid=$value[uid]&pmid=0&daterange=2" id="a_sendpm_$key" onclick="showWindow('showMsgBox', this.href, 'get', 0)" title="{lang send_pm}">{lang send_pm}</a></p>
											<!--{hook/space_interaction_extra}-->
										</div>
										<!--{/if}-->
									</li>
								<!--{/loop}-->
								</ul>
							</div>
							<!--{if $multi}--><div class="pgs cl mtm">$multi</div><!--{/if}-->
						<!--{else}-->
		                	<!--{if $_GET['view'] == 'me' && !$friendnum}-->
		                    	<!--{if $specialuser_list}-->
		                            <div id="friend_ul">
		                            	<h2>{lang recommend_friend}</h2>
		                                <ul class="buddy cl">
		                                	<!--{loop $specialuser_list $key $value}-->
		                                    	<li id="friend_{$value[uid]}_li">
		                                        	<div class="avt">
		                                                <a href="home.php?mod=space&uid=$value[uid]">
		                                                    <!--{if $ols[$value[uid]]}--><em class="gol" title="{lang online} {date($ols[$value[uid]], 'H:i')}"></em><!--{/if}-->
		                                                    <!--{avatar($value[uid],middle)}-->
		                                                </a>
		                                            </div>
		                                            <h4>
		                                                <a href="home.php?mod=space&uid=$value[uid]">$value[username]</a>
		                                            </h4>
		                                            <p class="maxh">$value[reason]</p>
		                                            <div class="caozuo">
		                                            <!--{if isset($value['follow']) && $key != $_G['uid'] && $value[username] != ''}-->
													<a ainuoto="home.php?mod=spacecp&ac=follow&op={if $value['follow']}del{else}add{/if}&fuid=$value[uid]&hash={FORMHASH}&from=a_followmod_" id="a_followmod_$key" class="ainuodialog {if $value['follow']}flw_btn_unfo{else}flw_btn_fo{/if}"><!--{if $value['follow']}-->$alang_quxiaoguanzhu<!--{else}-->$alang_guanzhu<!--{/if}--></a>
													
													<!--{/if}-->
													<a ainuoto="home.php?mod=spacecp&ac=friend&op=add&uid=$value[uid]&handlekey=adduserhk_{$value[uid]}" id="a_friend_$key" title="{lang add_friend}" class="ainuodialog addf">{lang add_friend}</a></div>
		                                        </li>
		                                    <!--{/loop}-->
		                                </ul>
		                            </div>
		                        <!--{/if}-->
		                        <!--{if $online_list}-->
		                        	<div id="friend_ul">
		                            	<h2>{lang online_member}</h2>
		                                <ul class="buddy cl">
		                                	<!--{loop $online_list $key $value}-->
		                                    	<li id="friend_{$value[uid]}_li">
		                                        	<div class="avt">
		                                                <a href="home.php?mod=space&uid=$value[uid]" c="1">
		                                                    <!--{if $ols[$value[uid]]}--><em class="gol" title="{lang online} {date($ols[$value[uid]], 'H:i')}"></em><!--{/if}-->
		                                                    <!--{avatar($value[uid],middle)}-->
		                                                </a>
		                                            </div>
		                                            <h4>
		                                                <a href="home.php?mod=space&uid=$value[uid]">$value[username]</a>
		                                            </h4>
		                                            <p class="maxh">$value[recentnote]</p>
		                                            <div class="caozuo">
		                                            <!--{if isset($value['follow']) && $key != $_G['uid'] && $value[username] != '' && helper_access::check_module('follow')}-->
													<a ainuoto="home.php?mod=spacecp&ac=follow&op={if $value['follow']}del{else}add{/if}&fuid=$value[uid]&hash={FORMHASH}&from=a_followmod_" id="a_followmod_$key" class="ainuodialog {if $value['follow']}flw_btn_unfo{else}flw_btn_fo{/if}"><!--{if $value['follow']}-->$alang_quxiaoguanzhu<!--{else}-->$alang_guanzhu<!--{/if}--></a>
													
													<!--{/if}-->
													<a ainuoto="home.php?mod=spacecp&ac=friend&op=add&uid=$value[uid]&handlekey=adduserhk_{$value[uid]}" id="a_friend_$key" title="{lang add_friend}" class="ainuodialog addf">{lang add_friend}</a></div>
		                                        </li>
		                                    <!--{/loop}-->
		                                </ul>
		                            </div>
		                        <!--{/if}-->
		                    <!--{else}-->
								<div class="emp"><i class="iconfont icon-meiyougengduole"></i><p>{lang no_friend_list}</p></div>
		                    <!--{/if}-->
						<!--{/if}-->
						<script type="text/javascript">
							function succeedhandle_followmod(url, msg, values) {
								var fObj = document.getElementById(values['from']+values['fuid']);
								if(values['type'] == 'add') {
									fObj.innerHTML = '$alang_quxiaoguanzhu';
									fObj.className = 'flw_btn_unfo';
									fObj.href = 'home.php?mod=spacecp&ac=follow&op=del&fuid='+values['fuid']+'&from='+values['from'];
								} else if(values['type'] == 'del') {
									fObj.innerHTML = '$alang_guanzhu';
									fObj.className = 'flw_btn_fo';
									fObj.href = 'home.php?mod=spacecp&ac=follow&op=add&hash={FORMHASH}&fuid='+values['fuid']+'&from='+values['from'];
								}
							}
						</script>
				<!--{if $groups}-->
						</div>
					</div>
				<!--{/if}-->
			<!--{else}-->
				<p class="tbmu">{lang count_member}</p>
				<!--{template home/space_list}-->
			<!--{/if}-->
<!--{if empty($diymode)}-->
</div>
	
	</div>

</div>


<!--{else}-->
		</div>
	</div>
</div>
<!--{/if}-->
<!--{template common/footer}-->
