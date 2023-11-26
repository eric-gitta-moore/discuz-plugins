<?PHP exit('QQÈº£º550494646');?>
<div class="ainuo_u_profile cl">

	<div class="section cl">
		<ul class="cl">
			<!--{if in_array($_G[adminid], array(1, 2))}-->
			<li><em>Email</em><span>$space[email]</span></li>
			<!--{/if}-->
			<li><em>{lang email_status}</em><span><!--{if $space[emailstatus] > 0}-->{lang profile_verified}<!--{else}-->{lang profile_no_verified}<!--{/if}--></span></li>
			<li><em>{lang video_certification}</em><span><!--{if $space[videophotostatus] > 0}-->{lang profile_certified} <!--{if $showvideophoto}-->&nbsp;&nbsp;(<a href="home.php?mod=space&uid=$space[uid]&do=videophoto" id="viewphoto" onclick="showWindow(this.id, this.href, 'get', 0)">{lang view_certification_photos}</a>)<!--{/if}--><!--{else}-->{lang profile_no_certified}<!--{/if}--></span></li>
			<!--{if $space[spacenote]}--><li class="cl"><em class="xg1">{lang spacenote}</em><span>$space[spacenote]</span></li><!--{/if}--><!--Fr om w ww.m oq u8 .com -->
			<!--{if $space[customstatus]}--><li class="xg1 cl"><em>{lang permission_basic_status}</em><span>$space[customstatus]</span></li><!--{/if}-->
			<!--{if $space[group][maxsigsize] && $space[sightml]}--><li class="cl"><em class="xg1">{lang personal_signature}</em><span>$space[sightml]</span></li><!--{/if}-->
		</ul>
		<ul class="tjxx cl">
        	<div class="atit cl">{lang stat_info}</div>
			<li class="cl">
				<a href="javacript:;">{lang friends_num}<span>$space[friends]</span></a>
				<!--{if helper_access::check_module('doing')}-->
					
					<a href="javacript:;">{lang doings_num}<span>$space[doings]</span></a>
				<!--{/if}-->
				<!--{if helper_access::check_module('blog')}-->
					
					<a href="javacript:;">{lang blogs_num}<span>$space[blogs]</span></a>
				<!--{/if}-->
				<!--{if helper_access::check_module('album')}-->
					
					<a href="javacript:;">{lang albums_num}<span>$space[albums]</span></a>
				<!--{/if}-->
				<!--{if $_G['setting']['allowviewuserthread'] !== false}-->
					
					<!--{eval $space['posts'] = $space['posts'] - $space['threads'];}-->
					<a href="javacript:;">{lang replay_num}<span>$space[posts]</span></a>
					
					<a href="javacript:;">{lang threads_num}<span>$space[threads]</span></a>
				<!--{/if}-->

			</li>
		</ul>
        <ul class="cl">
        	
            <!--{if $space[buyercredit]}-->
            <li><em>{lang eccredit_sellerinfo}</em><span><a href="home.php?mod=space&uid=$space[uid]&do=trade&view=eccredit#sellcredit">$space[buyercredit] <img src="{STATICURL}image/traderank/buyer/$space[buyerrank].gif" border="0" class="vm" /></a></span></li>
            <!--{/if}-->
            <!--{if $space[sellercredit]}-->
            <li><em>{lang eccredit_buyerinfo}</em><span><a href="home.php?mod=space&uid=$space[uid]&do=trade&view=eccredit#buyercredit">$space[sellercredit] <img src="{STATICURL}image/traderank/seller/$space[sellerrank].gif" border="0" class="vm" /></a></span></li>
            <!--{/if}-->
            <li><em>{lang credits}</em><span>$space[credits]</span></li>
            <!--{loop $_G[setting][extcredits] $key $value}-->
            <!--{if $value[title]}-->
            <li><em>$value[title]</em><span>{$space["extcredits$key"]} $value[unit]</span></li>
            <!--{/if}-->
            <!--{/loop}-->
            <li><em>{lang used_space}</em><span>$space[attachsize]</span></li>
        </ul>

		<ul class="cl">
        	<div class="atit cl" style="margin-top:0;">$alang_basicziliao</div>
			<!--{loop $profiles $value}-->
			<li><em>$value[title]</em><span>$value[value]</span></li>
			<!--{/loop}-->
		</ul>
        <!--{if $space['medals']}-->
            <ul class="cl">
                <li class="md_ctrl cl">
                    <em>{lang medals}</em>
                    <span>
                        <a href="home.php?mod=medal">
                        <!--{loop $space['medals'] $medal}-->
                            <img src="{STATICURL}/image/common/$medal[image]" alt="$medal[name]" id="md_{$medal[medalid]}" onmouseover="showMenu({'ctrlid':this.id, 'menuid':'md_{$medal[medalid]}_menu', 'pos':'12!'});" />
                        <!--{/loop}-->
                        </a>
                    </span>
                </li>
            </ul>
            <!--{loop $space['medals'] $medal}-->
                <div id="md_{$medal[medalid]}_menu" class="tip tip_4" style="display: none;">
                    <div class="tip_horn"></div>
                    <div class="tip_c">
                        <h4>$medal[name]</h4>
                        <p>$medal[description]</p>
                    </div>
                </div>
            <!--{/loop}-->
        <!--{/if}-->
        <!--{if $_G['setting']['verify']['enabled']}-->
            <!--{eval $showverify = true;}-->
            <ul class="cl">
            <li>
            	<em>{lang profile_verify}</em>
                <span>
                    <!--{loop $_G['setting']['verify'] $vid $verify}-->
                        <!--{if $verify['available']}-->
                            <!--{if $showverify}-->
                            
                            <!--{eval $showverify = false;}-->
                            <!--{/if}-->
                
                            <!--{if $space['verify'.$vid] == 1}-->
                                &nbsp;<a href="home.php?mod=spacecp&ac=profile&op=verify&vid=$vid"><!--{if $verify['icon']}--><img src="$verify['icon']" class="vm" alt="$verify[title]" title="$verify[title]" /><!--{else}-->$verify[title]<!--{/if}--></a>
                            <!--{elseif !empty($verify['unverifyicon'])}-->
                                &nbsp;<a href="home.php?mod=spacecp&ac=profile&op=verify&vid=$vid"><!--{if $verify['unverifyicon']}--><img src="$verify['unverifyicon']" class="vm" alt="$verify[title]" title="$verify[title]" /><!--{/if}--></a>
                            <!--{/if}-->
                
                        <!--{/if}-->
                    <!--{/loop}-->
                </span>
            </li>
            </ul>
        <!--{/if}-->
        <!--{if $count}-->
            <ul class="cl">
                <li><em>$alang_manage_forums</em><span>
                    <!--{loop $manage_forum $key $value}-->
                    &nbsp;<a href="forum.php?mod=forumdisplay&fid=$key">$value</a>
                    <!--{/loop}-->
                </span>
                </li>
            </ul>
        <!--{/if}-->
        <!--{if $groupcount}-->
            <ul class="cl">
                <li><em>{lang joined_group}</em><span>
                <!--{loop $usergrouplist $key $value}-->
                &nbsp;&nbsp;<a href="forum.php?mod=group&fid={$value['fid']}">$value['name']</a>
                <!--{/loop}-->
            	</span></li>
            </ul>
        <!--{/if}-->
	</div>


<div class="section cl">
	
	<ul>
    	<div class="atit cl">{lang active_profile}</div>
		<!--{if $space[adminid]}--><li><em class="xg1">{lang management_team}&nbsp;&nbsp;</em><span style="color:{$space[admingroup][color]}"><a href="home.php?mod=spacecp&ac=usergroup&gid=$space[adminid]">{$space[admingroup][grouptitle]}</a> {$space[admingroup][icon]}</span></li><!--{/if}-->
		<li><em class="xg1">{lang usergroup}</em><span style="color:{$space[group][color]}"{if $upgradecredit !== false} class="xi2" onmouseover="showTip(this)" tip="{lang credits} $space[credits], {lang thread_groupupgrade} $upgradecredit {lang credits}"{/if}><a href="home.php?mod=spacecp&ac=usergroup&gid=$space[groupid]">{$space[group][grouptitle]}</a> {$space[group][icon]}</span> <!--{if !empty($space['groupexpiry'])}-->&nbsp;{lang group_useful_life}&nbsp;<!--{date($space[groupexpiry], 'Y-m-d H:i')}--><!--{/if}--></li>
		<!--{if $space[extgroupids]}--><li><em class="xg1">{lang group_expiry_type_ext}&nbsp;&nbsp;</em><span>$space[extgroupids]</span></li><!--{/if}-->
	</ul>
	<ul id="pbbs" class="cl" style="margin-bottom:18px;">
		<!--{if $space[oltime]}--><li><em>{lang online_time}</em><span>$space[oltime] {lang hours}</span></li><!--{/if}-->
		<li><em>{lang regdate}</em><span>$space[regdate]</span></li>
		<li><em>{lang last_visit}</em><span>$space[lastvisit]</span></li>
		<!--{if $_G[uid] == $space[uid] || $_G[group][allowviewip]}-->
		<li><em>{lang register_ip}</em><span>$space[regip] - $space[regip_loc]</span></li>
		<li><em>{lang last_visit_ip}</em><span>$space[lastip]:$space[port] - $space[lastip_loc]</span></li>
		<!--{/if}-->
		<!--{if $space[lastactivity]}--><li><em>{lang last_activity_time}</em><span>$space[lastactivity]</span></li><!--{/if}-->
		<!--{if $space[lastpost]}--><li><em>{lang last_post_time}</em><span>$space[lastpost]</span></li><!--{/if}-->
		<!--{if $space[lastsendmail]}--><li><em>{lang last_send_email}</em><span>$space[lastsendmail]</span></li><!--{/if}-->
		<li><em>{lang time_offset}</em>
			<!--{eval $timeoffset = array({lang timezone});}-->
			<span>$timeoffset[$space[timeoffset]]</span>
		</li>
	</ul>
</div>

</div>
