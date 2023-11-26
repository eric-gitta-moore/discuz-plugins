<?PHP exit('QQÈº£º550494646');?>
<!--{if $space[profileprogress] != 100}-->
    <div class="ainuo_myprocess cl">
    	<div class="acon cl">
        	<div class="pbg"><div class="pbr cl" style="width: {if $space[profileprogress] < 2}2{else}$space[profileprogress]{/if}%;"></div></div>
            <p>{lang profile_completed} $space[profileprogress]%, <a href="home.php?mod=spacecp&ac=profile" class="xi2">{lang fix_profile}</a></p>
		</div>
    </div>
<!--{/if}-->
<div class="ainuo_u_tjxx cl">
	<ul>
        {eval $extcreditsNum = 0;}
        <!--{loop $_G[setting][extcredits] $key $value}-->
        <!--{if $value[title]}-->
        {eval $extcreditsNum++}
        <!--{/if}-->
        <!--{/loop}-->
        {eval $extcreditsWidth = (100/($extcreditsNum+1));}
		<li style="width:{$extcreditsWidth}%">
        	<a href="home.php?mod=spacecp&ac=usergroup">$space[credits]<p>{lang credits}</p></a>
        </li>
        <!--{loop $_G[setting][extcredits] $key $value}-->
            <!--{if $value[title]}-->
            <li style="width:{$extcreditsWidth}%">
                <a href="home.php?mod=spacecp&ac=usergroup">{$space["extcredits$key"]} $value[unit]<p>$value[title]</p></a>
            </li>
            <!--{/if}-->
        <!--{/loop}-->
    </ul>
</div>
<!-- header end -->
<div class="grey_line cl"></div>

<div class="ainuo_userinfo cl">
	<div class="section1 cl">
		<ul>
        	<!--{eval $mynewpm = DB::result_first("SELECT sum(isnew) FROM ".DB::table('ucenter_pm_members')." where uid=".$_G[uid]."");}-->
        	<li class="a1"><a href="home.php?mod=space&do=pm"><i class="iconfont icon-community_light"></i>{$alang_my}$alang_mymessage<em><i class="iconfont icon-right_light"></i></em><!--{if $mynewpm}--><span>{$mynewpm}{$alang_newmessagenum}</span><!--{/if}--></a></li>
            
            <li class="a2"><a href="home.php?mod=space&do=notice"><i class="iconfont icon-notice"></i>{$alang_my}$alang_myremind<em><i class="iconfont icon-right_light"></i></em><!--{if $_G[member][newprompt]}--><span>{$_G[member][newprompt]}{$alang_newremmind}</span><!--{/if}--></a></li>
        	<!--{eval $space['posts'] = $space['posts'] - $space['threads'];}-->
        	<li class="a1">
            	<a href="home.php?mod=space&uid={$_G[uid]}&do=thread&view=me">
                	<i class="iconfont icon-edit"></i>{$alang_my}$alang_uzhuti<em><i class="iconfont icon-right_light"></i></em>
                </a>
            </li>
            <li class="a2">
            	<a href="home.php?mod=space&do=thread&view=me&type=reply&uid={$_G[uid]}">
                	<i class="iconfont icon-comment"></i>{$alang_my}$alang_uhuitie<em><i class="iconfont icon-right_light"></i></em>
                </a>
            </li>
            <li class="a3">
            	<a href="home.php?mod=space&uid={$_G[uid]}&do=favorite&view=me&type=thread">
                <i class="iconfont icon-favor"></i>{$alang_my}$alang_ushoucang<em><i class="iconfont icon-right_light"></i></em>
                </a>
            </li>
            <li class="a4">
            	<a href="home.php?mod=space&do=friend">
                	<i class="iconfont icon-friend"></i>{$alang_my}$alang_uhaoyou<em><i class="iconfont icon-right_light"></i></em>
                </a>
            </li>
            <!--{if helper_access::check_module('blog')}-->
            <li class="a5">
            	<a href="home.php?mod=space&uid={$_G[uid]}&do=blog&view=me">
                    <i class="iconfont icon-form"></i>{$alang_my}$alang_urizhi<em><i class="iconfont icon-right_light"></i></em>
                </a>
            </li>
            <!--{/if}-->
            <!--{if helper_access::check_module('album')}-->
            <li class="a6">
            	<a href="home.php?mod=space&uid={$space[uid]}&do=album&view=me">
                	<i class="iconfont icon-album"></i>{$alang_my}$alang_uxiangce<em><i class="iconfont icon-right_light"></i></em>
                </a>
            </li>
            <!--{/if}-->
            <!--{if helper_access::check_module('follow')}-->
            <li class="a7">
            	<a href="home.php?mod=follow">
                	<i class="iconfont icon-all"></i>{$alang_my}$alang_guangbo<em><i class="iconfont icon-right_light"></i></em>
                </a>
            </li>
            <!--{/if}-->
            <!--{if helper_access::check_module('doing')}-->
            <li class="a8">
            	<a href="home.php?mod=space&do=doing&view=me">
                	<i class="iconfont icon-time"></i>{$alang_my}$alang_ujilu<em><i class="iconfont icon-right_light"></i></em>
                </a>
            </li>
            <!--{/if}-->
        	<li class="a3"><a href="home.php?mod=space&do=friend&view=visitor"><i class="iconfont icon-peoplelist"></i>$alang_zuixinlaifang<em><i class="iconfont icon-right_light"></i></em></a></li>
            <li class="a4"><a href="home.php?mod=space&do=friend&view=trace"><i class="iconfont icon-footprint"></i>$alang_wodezuji<em><i class="iconfont icon-right_light"></i></em></a></li>
            <li class="a5"><a href="home.php?mod=spacecp"><i class="iconfont icon-settings"></i>$alang_mysetting<em><i class="iconfont icon-right_light"></i></em></a></li>
            <li class="a6"><a href="home.php?mod=spacecp&ac=credit"><i class="iconfont icon-vipcard"></i>$alang_creditinfo<em><i class="iconfont icon-right_light"></i></em></a></li>

            <li class="a7"><a href="home.php?mod=spacecp&ac=profile&op=verify"><i class="iconfont icon-vip"></i>{$alang_forum}{lang memcp_verify}<em><i class="iconfont icon-right_light"></i></em></a></li>
            <li class="a8"><a href="home.php?mod=spacecp&ac=profile&op=password"><i class="iconfont icon-lock"></i>{lang password_security}<em><i class="iconfont icon-right_light"></i></em></a></li>
            <li class="a9"><a href="home.php?mod=spacecp&ac=promotion"><i class="iconfont icon-coin"></i>{lang memcp_promotion}<em><i class="iconfont icon-right_light"></i></em></a></li>

		</ul>
	</div>
    <div class="grey_line cl"></div>
</div>
<div class="btn_exit" style="margin-bottom:5px;"><a ainuoto="member.php?mod=logging&action=logout&formhash={FORMHASH}" class="ainuodialog">{lang logout_mobile}</a></div>

<!--{template common/foot_bottom}-->