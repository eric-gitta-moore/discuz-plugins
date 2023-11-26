<?PHP exit('QQÈº£º550494646');?>
<!--{template common/header}-->

<!--{if !$_G[inajax]}-->
<!-- header start -->
<header class="header">
    <div class="nav">
        <a href="#" class="z back"><i class="iconfont icon-back"></i></a>
        <span class="name">
        <!--{if $op == 'find'}-->
			{lang people_might_know}
		<!--{elseif $op == 'request'}-->
			{lang friend_request}
		<!--{elseif $op == 'group'}-->
			{lang set_friend_group}
		<!--{/if}-->
        </span>
    </div>
</header>
<!-- header end -->

<div class="ainuo_myvisit cl">
	<div class="cl">
    {if $_GET['op'] == 'find'}
    <div class="ainuo_usertb cl">
        <ul class="tb avisit cl">
            <li{$a_actives[visitor]}><a href="home.php?mod=space&do=friend&view=visitor">$alang_zuixinlaifang</a></li>
            <li{$a_actives[trace]}><a href="home.php?mod=space&do=friend&view=trace">{lang my_trace}</a></li>
            <li$actives[find]><a href="home.php?mod=spacecp&ac=friend&op=find">$alang_findhy</a></li>
            <li{$a_actives[blacklist]}><a href="home.php?mod=space&do=friend&view=blacklist">{lang my_blacklist}</a></li>
        </ul>
    </div>
    {/if}
    {if $_GET['ac'] == 'invite' || ($_GET['ac'] == 'friend' && ($_GET['op'] == 'group' || $_GET['op'] == 'request'))}
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
		<div class="cl">
<!--{/if}-->

		<!--{if $op =='ignore'}-->
        <div class="ainuo_upop_box cl">
            <h2>{lang lgnore_friend}</h2>
			<form method="post" autocomplete="off" id="friendform_{$uid}" name="friendform_{$uid}" action="home.php?mod=spacecp&ac=friend&op=ignore&uid=$uid&confirm=1" {if $_G[inajax]}onsubmit="ajaxpost(this.id, 'return_$_GET[handlekey]');"{/if}>
				<input type="hidden" name="referer" value="{echo dreferer()}">
				<input type="hidden" name="friendsubmit" value="true" />
				<input type="hidden" name="formhash" value="{FORMHASH}" />
				<input type="hidden" name="from" value="$_GET[from]" />
				<!--{if $_G[inajax]}--><input type="hidden" name="handlekey" value="$_GET[handlekey]" /><!--{/if}-->
				<div class="acon cl">{lang determine_lgnore_friend}</div>
				<p class="cl">
					<button type="submit" name="friendsubmit_btn" value="true">{lang determine}</button>
				</p>
			</form>
			<script type="text/javascript">
				function succeedhandle_{$_GET[handlekey]}(url, msg, values) {
					if(values['from'] == 'notice') {
						deleteQueryNotice(values['uid'], 'pendingFriend');
					} else if(typeof friend_delete == 'function') {
						friend_delete(values['uid']);
					}
				}
			</script>
        </div>
		<!--{elseif $op == 'find'}-->

			<!--{if !empty($recommenduser) || $nearlist || $friendlist || $onlinelist}-->
			<div class="amaybe cl">
				<!--{if !empty($recommenduser)}-->
				<h2>{lang recommend_user}</h2>
				<ul class="buddy cl">
					<!--{loop $recommenduser $key $value}-->
					<li>
						<div class="avt"><a href="home.php?mod=space&uid=$value[uid]" title="$value[username]"><!--{avatar($value[uid],middle)}--></a></div>
						<h4><a href="home.php?mod=space&uid=$value[uid]" title="$value[username]">$value[username]</a></h4>
						<p title="$value[reason]" class="maxh">$value[reason]</p>
						<p><a ainuoto="home.php?mod=spacecp&ac=friend&op=add&uid=$value[uid]" id="a_near_friend_$key" class="ainuodialog addbuddy">{lang add_friend}</a></p>
					</li>
					<!--{/loop}-->
				</ul>
				<!--{/if}-->

				<!--{if $nearlist}-->
				<h2>{lang surprise_they_near}</h2>
				<ul class="buddy cl">
					<!--{loop $nearlist $key $value}-->
					<li>
						<div class="avt"><a href="home.php?mod=space&uid=$value[uid]" title="$value[username]"><!--{avatar($value[uid],middle)}--></a></div>
						<h4><a href="home.php?mod=space&uid=$value[uid]" title="$value[username]">$value[username]</a></h4>
						<p><a ainuoto="home.php?mod=spacecp&ac=friend&op=add&uid=$value[uid]" id="a_near_friend_$key" class="ainuodialog addbuddy">{lang add_friend}</a></p>
					</li>
					<!--{/loop}-->
				</ul>
				<!--{/if}-->

				<!--{if $friendlist}-->
				<h2>{lang friend_friend_might_know}</h2>
				<ul class="buddy cl">
					<!--{loop $friendlist $key $value}-->
					<li>
						<div class="avt"><a href="home.php?mod=space&uid=$value[uid]" title="$value[username]"><!--{avatar($value[uid],middle)}--></a></div>
						<h4><a href="home.php?mod=space&uid=$value[uid]" title="$value[username]">$value[username]</a></h4>
						<p><a ainuoto="home.php?mod=spacecp&ac=friend&op=add&uid=$value[uid]&handlekey=friendhk_{$value[uid]}" id="a_friend_friend_$key" class="ainuodialog addbuddy">{lang add_friend}</a></p>
					</li>
					<!--{/loop}-->
				</ul>
				<!--{/if}-->

				<!--{if $onlinelist}-->
				<h2>{lang they_online_add_friend}</h2>
				<ul class="buddy cl">
					<!--{loop $onlinelist $key $value}-->
					<li>
						<div class="avt"><a href="home.php?mod=space&uid=$value[uid]" title="$value[username]"><!--{avatar($value[uid],middle)}--></a></div>
						<h4><a href="home.php?mod=space&uid=$value[uid]" title="$value[username]">$value[username]</a></h4>
						<p><a ainuoto="home.php?mod=spacecp&ac=friend&op=add&uid=$value[uid]&handlekey=onlinehk_{$value[uid]}" id="a_online_friend_$key" class="ainuodialog addbuddy">{lang add_friend}</a></p>
					</li>
					<!--{/loop}-->
				</ul>
				<!--{/if}-->
             </div>
			<!--{else}-->
                <div class="emp"><i class="iconfont icon-meiyougengduole"></i><p>{lang find_know_nofound}</p></div>
			<!--{/if}-->

		<!--{elseif $op == 'search'}-->

			<h3 class="tbmu">{lang search_member_result}:</h3>
			<!--{template home/space_list}-->

		<!--{elseif $op=='changenum'}-->
        <div class="ainuo_upop_box cl" style="width:280px;">
        	<h2>{lang friend_hot}</h2>
			<form method="post" autocomplete="off" id="changenumform_{$uid}" name="changenumform_{$uid}" action="home.php?mod=spacecp&ac=friend&op=changenum&uid=$uid">
				<input type="hidden" name="referer" value="{echo dreferer()}">
				<!--{if $_G[inajax]}--><input type="hidden" name="handlekey" value="$_GET[handlekey]" /><!--{/if}-->
				<input type="hidden" name="formhash" value="{FORMHASH}" />
				<div class="acon cl">
					<p class="yjh">{lang adjust_friend_hot}</p>
					<p>{lang new_hot}:<input type="text" name="num" value="$friend[num]" class="linepx" /> ({lang num_0_999})</p>
				</div>
				<p class="cl">
					<button type="submit" name="changenumsubmit" value="true">{lang determine}</button>
				</p>
			</form>
			<script type="text/javascript" reload="1">
				function succeedhandle_$_GET[handlekey](url, msg, values) {
					friend_delete(values['uid']);
					document.getElementById('spannum_'+values['fid']).innerHTML = values['num'];
				}
			</script>
        </div>
		<!--{elseif $op=='changegroup'}-->
        <div class="ainuo_upop_box cl">
			<h2>{lang set_friend_group}</h2>
			<form method="post" autocomplete="off" id="changegroupform_{$uid}" name="changegroupform_{$uid}" action="home.php?mod=spacecp&ac=friend&op=changegroup&uid=$uid" {if $_G[inajax]}onsubmit="ajaxpost(this.id, 'return_$_GET[handlekey]');"{/if}>
				<input type="hidden" name="referer" value="{echo dreferer()}">
				<input type="hidden" name="changegroupsubmit" value="true" />
				<!--{if $_G[inajax]}--><input type="hidden" name="handlekey" value="$_GET[handlekey]" /><!--{/if}-->
				<input type="hidden" name="formhash" value="{FORMHASH}" />
				<div class="acon1 cl">
					<table><tr>
					<!--{eval $i=0;}-->
					<!--{loop $groups $key $value}-->
					<td style="padding:8px 8px 0 0;"><label><input type="radio" name="group" value="$key"$groupselect[$key] />$value</label></td>
					<!--{if $i%2==1}--></tr><tr><!--{/if}-->
					<!--{eval $i++;}-->
					<!--{/loop}-->
					</tr></table>
				</div>
				<p class="cl">
					<button type="submit" name="changegroupsubmit_btn" value="true">{lang determine}</button>
				</p>
			</form>
			<script type="text/javascript">
				function succeedhandle_$_GET[handlekey](url, msg, values) {
					friend_changegroup(values['gid']);
				}
			</script>
		</div>
		<!--{elseif $op=='editnote'}-->
		 <div class="ainuo_upop_box cl">
			
            <h2 class="flb">{lang friend_note}</h2>
			<form method="post" autocomplete="off" id="editnoteform_{$uid}" name="editnoteform_{$uid}" action="home.php?mod=spacecp&ac=friend&op=editnote&uid=$uid" {if $_G[inajax]}onsubmit="ajaxpost(this.id, 'return_$_GET[handlekey]');"{/if}>
				<input type="hidden" name="referer" value="{echo dreferer()}">
				<input type="hidden" name="editnotesubmit" value="true" />
				<!--{if $_G[inajax]}--><input type="hidden" name="handlekey" value="$_GET[handlekey]" /><!--{/if}-->
				<input type="hidden" name="formhash" value="{FORMHASH}" />
				<div class="acon cl">
					<p class="yjh">{lang friend_note_message}</p>
					<input type="text" name="note" class="linepx mtn" value="$friend[note]" />
				</div>
				<p class="cl">
					<button type="submit" name="editnotesubmit_btn" class="pn pnc" value="true">{lang determine}</button>
				</p>
			</form>
			<script type="text/javascript">
				function succeedhandle_$_GET[handlekey](url, msg, values) {
					var uid=values['uid'];
					var elem = document.getElementById('friend_note_'+uid);
					if(elem) {
						elem.innerHTML = values['note'];
					}
				}
			</script>
		</div>
		<!--{elseif $op=='group'}-->

			<p class="fenzu cl">
				<a href="home.php?mod=spacecp&ac=friend&op=group"{if !isset($_GET[group])} class="a"{/if}>{lang all_friends}</a>
				<!--{loop $groups $key $value}-->
				<a href="home.php?mod=spacecp&ac=friend&op=group&group=$key"{if isset($_GET[group]) && $_GET[group]==$key} class="a"{/if}>$value</a>
				<!--{/loop}-->
			</p>
			<p class="dashedtip">{lang friend_group_hot_message}</p>

			<!--{if $list}-->
			<form method="post" autocomplete="off" action="home.php?mod=spacecp&ac=friend&op=group&ref">
				<div id="friend_ul">
					<ul class="buddy cl">
					<!--{loop $list $key $value}-->
						<li>
							<div class="avt"><a href="home.php?mod=space&uid=$value[uid]"><!--{avatar($value[uid],small)}--></a></div>
							<h4><input type="checkbox" name="fuids[]" value="$value[uid]" class="pc" /> <a href="home.php?mod=space&uid=$value[uid]">$value[username]</a><em class="hot">{lang hot}:$value[num]</em></h4>
							<p class="group">$value[group]</p>
						</li>
					<!--{/loop}-->
					</ul>
				</div>
				<div class="szyhz cl">
					<label for="chkall" onclick="checkAll(this.form, 'fuids')"><input type="checkbox" name="chkall" id="chkall" class="pc" />{lang select_all}</label>
					{lang set_member_group}:
					<select name="group" class="ps vm">
					<!--{loop $groups $key $value}-->
						<option value="$key">$value</option>
					<!--{/loop}-->
					</select>
                    <div class="cl">
						<button type="submit" name="btnsubmit" value="true" class="ainuoformdialog">{lang determine}</button>
                    </div>
				</div>
				<!--{if $multi}--><div class="pgs cl mtm">$multi</div><!--{/if}-->
				<input type="hidden" name="formhash" value="{FORMHASH}" />
				<input type="hidden" name="groupsubmin" value="true" />
			</form>
			<!--{else}-->
            <div class="emp"><i class="iconfont icon-meiyougengduole"></i><p>{lang no_friend_list}</p></div>
			<!--{/if}-->

		<!--{elseif $op=='groupname'}-->
			<h3 class="flb">
				<em id="return_$_GET[handlekey]">{lang friends_group}</em>
				<!--{if $_G[inajax]}--><span><a href="javascript:;" onclick="hideWindow('$_GET[handlekey]');" class="flbc" title="{lang close}">{lang close}</a></span><!--{/if}-->
			</h3>
			<div id="__groupnameform_{$group}">
				<form method="post" autocomplete="off" id="groupnameform_{$group}" name="groupnameform_{$group}" action="home.php?mod=spacecp&ac=friend&op=groupname&group=$group" {if $_G[inajax]}onsubmit="ajaxpost(this.id, 'return_$_GET[handlekey]');"{/if}>
					<input type="hidden" name="referer" value="{echo dreferer()}">
					<input type="hidden" name="groupnamesubmit" value="true" />
					<!--{if $_G[inajax]}--><input type="hidden" name="handlekey" value="$_GET[handlekey]" /><!--{/if}-->
					<input type="hidden" name="formhash" value="{FORMHASH}" />
					<div class="c">
						<p>{lang set_friend_group_name}</p>
						<p class="mtm">{lang new_name}:<input type="text" name="groupname" value="$groups[$group]" size="15" class="px" /></p>
					</div>
					<p class="o pns">
						<button type="submit" name="groupnamesubmit_btn" value="true" class="pn pnc"><strong>{lang determine}</strong></button>
					</p>
				</form>
				<script type="text/javascript">
					function succeedhandle_$_GET[handlekey](url, msg, values) {
						friend_changegroupname(values['gid']);
					}
				</script>
			</div>

		<!--{elseif $op=='groupignore'}-->
			<h3 class="flb">
				<em id="return_$_GET[handlekey]">{lang set_member_feed}</em>
				<!--{if $_G[inajax]}--><span><a href="javascript:;" onclick="hideWindow('$_GET[handlekey]');" class="flbc" title="{lang close}">{lang close}</a></span><!--{/if}-->
			</h3>
			<div id="$group">
				<form method="post" autocomplete="off" id="groupignoreform" name="groupignoreform" action="home.php?mod=spacecp&ac=friend&op=groupignore&group=$group" {if $_G[inajax]}onsubmit="ajaxpost(this.id, 'return_$_GET[handlekey]');"{/if}>
					<input type="hidden" name="referer" value="{echo dreferer()}">
					<input type="hidden" name="groupignoresubmit" value="true" />
					<!--{if $_G[inajax]}--><input type="hidden" name="handlekey" value="$_GET[handlekey]" /><!--{/if}-->
					<input type="hidden" name="formhash" value="{FORMHASH}" />
					<div class="c">
						<!--{if !isset($space['privacy']['filter_gid'][$group])}-->
						<p>{lang not_show_feed_homepage}</p>
						<!--{else}-->
						<p>{lang show_feed_homepage}</p>
						<!--{/if}-->
					</div>
					<p class="o pns">
						<button type="submit" name="groupignoresubmit_btn" class="pn pnc" value="true"><strong>{lang determine}</strong></button>
					</p>
				</form>
			</div>
		<!--{elseif $op=='request'}-->

			<div class="arequest cl">
				<div id="add_friend_div" class="dashedtip cl">
                    {lang select_friend_application_do}
                    <!--{if $maxfriendnum}-->
                    <p>
                    	({lang max_friend_num})
                        <!--{if $_G[magic][friendnum]}-->
                        <img src="{STATICURL}image/magic/friendnum.small.gif" alt="friendnum" class="vm" />
                        <a id="a_magic_friendnum" href="home.php?mod=magic&mid=friendnum" onclick="showWindow(this.id, this.href, 'get', '0')">{lang expansion_friend}</a>
                        ({lang expansion_friend_message})
                        <!--{/if}-->
                    </p>
                    <!--{/if}-->
                </div>
                <!--{if $list}-->
				<div class="pizhunall cl">
					<a href="home.php?mod=spacecp&ac=friend&op=addconfirm&key=$space[key]">{lang confirm_all_applications}</a>
                    <a href="home.php?mod=spacecp&ac=friend&op=ignore&confirm=1&key=$space[key]">{lang ignore_all_friends_application}</a>
				</div>
				<!--{/if}-->
				
			</div>
			<!--{if $list}-->
            <div class="pizhuhy cl">
			<ul id="friend_ul">
				<!--{loop $list $key $value}-->
				<li id="friend_tbody_$value[fuid]">
					<table cellpadding="0" cellspacing="0" width="100%">
						<tr>
							<th width="52">
								<a href="home.php?mod=space&uid=$value[fuid]"><!--{avatar($value[fuid],middle)}--></a>
							</th>
							<td style="font-size:14px;">
								<h4>
									<a href="home.php?mod=space&uid=$value[fuid]">$value[fusername]</a>
									<span><!--{date($value[dateline], 'n-j H:i')}--></span>
								</h4>
								<div id="friend_$value[fuid]">
									<!--{if $value[note]}--><p class="ayy"><blockquote id="quote">$value[note]</blockquote></p><!--{/if}-->
									
									<p class="agt"><a href="home.php?mod=spacecp&ac=friend&op=getcfriend&fuid=$value[fuid]&handlekey=cfrfriendhk_{$value[uid]}" id="a_cfriend_$key">{lang your_common_friends}</a></p>
									<p class="apz cl">
										<a ainuoto="home.php?mod=spacecp&ac=friend&op=add&uid=$value[fuid]&handlekey=afrfriendhk_{$value[uid]}" id="afr_$value[fuid]" class="ainuodialog">{lang confirm_applications}</a>
										<a ainuoto="home.php?mod=spacecp&ac=friend&op=ignore&uid=$value[fuid]&confirm=1&handlekey=afifriendhk_{$value[uid]}" id="afi_$value[fuid]" class="ainuodialog hl">{lang ignore}</a>
									</p>
								</div>
							</td>
						</tr>
						<tbody id="cf_$value[fuid]"></tbody>
					</table>
				</li>
				<!--{/loop}-->
			</ul>
            </div>
			<!--{if $multi}--><div class="pgs cl mtm">$multi</div><!--{/if}-->
			<!--{else}-->
            <div class="emp"><i class="iconfont icon-meiyougengduole"></i><p>{lang no_new_friend_application}</p></div>
			<!--{/if}-->

		<!--{elseif $op=='getcfriend'}-->
		<div class="ainuo_upop_box cl">
        	<h2>{lang common_friends}</h2>
			
			<div class="acon1" style="width: 280px;">
				<!--{if $list}-->
				<!--{if count($list)>14}-->
				<p>{lang max_view_15_friends}</p>
				<!--{else}-->
				<p>{lang you_have_common_friends}</p>
				<!--{/if}-->
				<ul class="mtm ml mls cl">
					<!--{loop $list $key $value}-->
					<li>
						<div class="avt"><a href="home.php?mod=space&uid=$value[uid]"><!--{avatar($value[uid],small)}--></a></div>
						<p><a href="home.php?mod=space&uid=$value[uid]" title="$value[username]">$value[username]</a></p>
					</li>
					<!--{/loop}-->
				</ul>
				<!--{else}-->
				<p>{lang you_have_no_common_friends}</p>
				<!--{/if}-->
			</div>
		</div>
		<!--{elseif $op=='add'}-->
        <div class="ainuo_upop_box cl" style="width:280px;">
        	<h2>{lang add_friend}</h2>
			<form method="post" autocomplete="off" id="addform_{$tospace[uid]}" name="addform_{$tospace[uid]}" action="home.php?mod=spacecp&ac=friend&op=add&uid=$tospace[uid]" {if $_G[inajax]}onsubmit="ajaxpost(this.id, 'return_$_GET[handlekey]');"{/if}>
				<input type="hidden" name="referer" value="{echo dreferer()}" />
				<input type="hidden" name="addsubmit" value="true" />
				<!--{if $_G[inajax]}--><input type="hidden" name="handlekey" value="$_GET[handlekey]" /><!--{/if}-->
				<input type="hidden" name="formhash" value="{FORMHASH}" />
				<div class="acon1 cl">
					<table>
						<tr>
							<th valign="top" width="52" class="avt"><a href="home.php?mod=space&uid=$tospace[uid]"><!--{avatar($tospace[uid],middle)}--></th>
							<td valign="top" style="font-size:14px;">{lang add} <strong>{$tospace[username]}</strong>{lang add_friend_note}:<br />
								<input type="text" name="note" value="" class="linepx" />
								<p class="ainuofenzu">
									{lang friend_group}: <select name="gid" class="ps">
									<!--{loop $groups $key $value}-->
									<option value="$key" {if empty($space['privacy']['groupname']) && $key==1} selected="selected"{/if}>$value</option>
									<!--{/loop}-->
									</select>
								</p>
							</td>
						</tr>
					</table>
				</div>
				<p class="cl">
					<button type="submit" name="addsubmit_btn" id="addsubmit_btn" value="true" class="ainuoformdialog">{lang determine}</button>
				</p>
			</form>
        </a>
		<!--{elseif $op=='add2'}-->
		<div class="ainuo_upop_box cl">
            <h2>{lang approval_the_request}</h2>
			<form method="post" autocomplete="off" id="addratifyform_{$tospace[uid]}" name="addratifyform_{$tospace[uid]}" action="home.php?mod=spacecp&ac=friend&op=add&uid=$tospace[uid]" {if $_G[inajax]}onsubmit="ajaxpost(this.id, 'return_$_GET[handlekey]');"{/if}>
				<input type="hidden" name="referer" value="{echo dreferer()}" />
				<input type="hidden" name="add2submit" value="true" />
				<input type="hidden" name="from" value="$_GET[from]" />
				<!--{if $_G[inajax]}--><input type="hidden" name="handlekey" value="$_GET[handlekey]" /><!--{/if}-->
				<input type="hidden" name="formhash" value="{FORMHASH}" />
				<div class="acon1 cl">
					<table cellspacing="0" cellpadding="0">
						<tr>
							<th valign="top" width="52" class="avt"><a href="home.php?mod=space&uid=$tospace[uid]"><!--{avatar($tospace[uid],middle)}--></th>
							<td valign="top" style="font-size:14px;">
								<p>{lang approval_the_request_group}:</p>
								<table><tr>
								<!--{eval $i=0;}-->
								<!--{loop $groups $key $value}-->
								<td style="padding:8px 8px 0 0;"><label for="group_$key"><input type="radio" name="gid" id="group_$key" value="$key"$groupselect[$key] />$value</label></td>
								<!--{if $i%2==1}--></tr><tr><!--{/if}-->
								<!--{eval $i++;}-->
								<!--{/loop}-->
								</tr></table>
							</td>
						</tr>
					</table>
				</div>
				<p class="cl">
					<button type="submit" name="add2submit_btn" value="true">{lang approval}</button>
				</p>
			</form>
            </div>
			<script type="text/javascript">
				function succeedhandle_$_GET[handlekey](url, msg, values) {
					if(values['from'] == 'notice') {
						deleteQueryNotice(values['uid'], 'pendingFriend');
					} else {
						myfriend_post(values['uid']);
					}
				}
			</script>
		<!--{elseif $op=='getinviteuser'}-->
			$jsstr
		<!--{/if}-->

<!--{if !$_G[inajax]}-->
		</div>
	</div>
</div>
<!--{/if}-->
<script>
function checkAll(form, name) {
	for(var i = 0; i < form.elements.length; i++) {
		var e = form.elements[i];
		if(e.name.match(name)) {
			e.checked = form.elements['chkall'].checked;
		}
	}
}
</script>
<!--{template common/footer}-->
