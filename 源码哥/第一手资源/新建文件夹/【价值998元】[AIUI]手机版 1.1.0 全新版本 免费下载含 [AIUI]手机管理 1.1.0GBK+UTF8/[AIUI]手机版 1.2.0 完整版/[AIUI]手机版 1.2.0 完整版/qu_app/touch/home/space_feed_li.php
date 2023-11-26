<?PHP exit('QQÈº£º550494646');?>
<li class="cl $value[magic_class]" id="feed_{$value[feedid]}_li" onmouseover="feed_menu($value[feedid],1);" onmouseout="feed_menu($value[feedid],0);">
	<!--{if $value[uid] && empty($_G['home']['tpl'][hidden_more])}-->
	<a href="home.php?mod=spacecp&ac=feed&op=menu&feedid=$value[feedid]" class="o{if $_G['uid'] == $value[uid]} del{/if}" id="a_feed_menu_$value[feedid]" onclick="showWindow(this.id, this.href, 'get', 0);doane(event);" title="{if $_G['uid'] != $value[uid]}{lang shield_feed}{else}{lang delete_feed}{/if}" style="display:none;">{lang menu}</a>
	<!--{/if}-->
	<div class="ex cl">
		<a class="t" href="home.php?mod=space&uid={$uid}&do=home&view=$_GET[view]&appid=$value[appid]&icon=$value[icon]" title="{lang just_look_dynamic}">
        <!--{if $value[icon] == 'blog'}-->
        	<span class="a1"><i class="iconfont icon-icon_gongzuorijitongji"></i></span>
        <!--{elseif $value[icon] == 'doing'}-->
        	<span class="a2"><i class="iconfont icon-icon00102"></i></span>
        <!--{elseif $value[icon] == 'album'}-->
        	<span class="a3"><i class="iconfont icon-xiangce"></i></span>
        <!--{elseif $value[icon] == 'friend'}-->
        	<span class="a4"><i class="iconfont icon-haoyoudaifu"></i></span>
        <!--{elseif $value[icon] == 'thread'}-->
        	<span class="a5"><i class="iconfont icon-icon00105"></i></span>
        <!--{elseif $value[icon] == 'share'}-->
        	<span class="a6"><i class="iconfont icon-share-r"></i></span>
        <!--{/if}-->
        </a>
		
		<div class="ec">
        	<div class="zshm cl">
                $value[title_template] 
                <!--{if $value[new]}--><span style="color:red;">New</span> <!--{/if}-->
                <span class="adate y"><!--{date($value[dateline], 'u')}--></span>
            </div>
			

			<!--{if $value['body_template']}-->
			<div class="d"{if $value['image_3']} style="clear: both; zoom: 1;"{/if}>
				$value[body_template]
			</div>
			<!--{/if}-->
            <div class="mypic cl">
                <!--{if $value['image_1']}-->
                <a href="$value[image_1_link]"{$value[target]}><img src="$value[image_1]" alt="" class="vm" /></a>
                <!--{/if}-->
                <!--{if $value['image_2']}-->
                <a href="$value[image_2_link]"{$value[target]}><img src="$value[image_2]" alt="" class="vm" /></a>
                <!--{/if}-->
                <!--{if $value['image_3']}-->
                <a href="$value[image_3_link]"{$value[target]}><img src="$value[image_3]" alt="" class="vm" /></a>
                <!--{/if}-->
                <!--{if $value['image_4']}-->
                <a href="$value[image_4_link]"{$value[target]}><img src="$value[image_4]" alt="" class="vm" /></a>
                <!--{/if}-->
			</div>
			<!--{if !empty($value['body_data']['flashvar'])}-->
				<!--{if !empty($value['body_data']['imgurl'])}-->
				<table class="mtm" title="{lang click_play}" onclick="javascript:showFlash('{$value['body_data']['host']}', '{$value['body_data']['flashvar']}', this, '{$value['feedid']}');"><tr><td class="vdtn hm" style="background: url($value['body_data']['imgurl']) no-repeat">
					<img src="{IMGDIR}/vds.png" alt="{lang click_play}" />
				</td></tr></table>
				<!--{else}-->
				<img src="{IMGDIR}/vd.gif" alt="{lang click_play}" onclick="javascript:showFlash('{$value['body_data']['host']}', '{$value['body_data']['flashvar']}', this, '{$value['feedid']}');" class="tn" />
				<!--{/if}-->
			<!--{elseif !empty($value['body_data']['musicvar'])}-->
			<img src="{IMGDIR}/music.gif" alt="{lang click_play}" onclick="javascript:showFlash('music', '{$value['body_data']['musicvar']}', this, '{$value['feedid']}');" class="tn" />
			<!--{elseif !empty($value['body_data']['flashaddr'])}-->
			<img src="{IMGDIR}/flash.gif" alt="{lang click_view}" onclick="javascript:showFlash('flash', '{$value['body_data']['flashaddr']}', this, '{$value['feedid']}');" class="tn" />
			<!--{/if}-->

			<!--{if $user_list[$value['hash_data']]}-->
			<p>{lang other_participants}:<!--{eval echo implode(', ', $user_list[$value['hash_data']]);}--></p>
			<!--{/if}-->

			<!--{if trim(str_replace('&nbsp;', '', $value['body_general']))}-->
			<div class="quote{if $value['image_1']} z{/if}"><blockquote>$value[body_general]</blockquote></div>
			<!--{/if}-->
		</div>
	</div>

	<!--{if $value['idtype']=='doid'}-->
	<div id="{$key}_$value[id]" style="display:none;"></div>
	<!--{elseif $value['idtype']}-->
	<div id="feedcomment_$value[feedid]" style="display:none;"></div>
	<!--{/if}-->
</li>