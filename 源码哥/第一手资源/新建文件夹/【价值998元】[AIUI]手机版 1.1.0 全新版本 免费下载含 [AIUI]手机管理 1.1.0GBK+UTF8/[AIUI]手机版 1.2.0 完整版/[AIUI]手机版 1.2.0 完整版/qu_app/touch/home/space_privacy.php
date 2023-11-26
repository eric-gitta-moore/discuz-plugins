<?PHP exit('QQÈº£º550494646');?>
<!--{eval $_G['home_tpl_titles'] = array('{lang remind}');}-->
<!--{template common/header}-->
{eval 
	$space['isfriend'] = $space['self'];
	if(in_array($_G['uid'], (array)$space['friends'])) $space['isfriend'] = 1;
	space_merge($space, 'count');
	space_merge($space, 'field_home');
}

<header class="header">
    <div class="nav">
    	<a href="javascript:;" onclick="history.go(-1)" class="z"><i class="iconfont icon-back"></i></a>
        <span class="category"><span class="name">{lang privacy_prompt}</span></span>
    </div>
</header>
<div class="ainuo_privacy cl">
	<div class="cl">
		<div class="acon">
			<table cellpadding="0" cellspacing="0" width="100%" style="table-layout: fixed;">
				<tr>
					<td valign="top" width="65" class="hm">
						<div class="avt avtm"><a href="home.php?mod=space&uid=$space[uid]"><!--{avatar($space[uid],middle)}--></a></div>
					</td>
					<td valign="top" class="xs1">
						<h2 class="xs2">
							{lang set_privacy}
						</h2>
						<p class="ainfo">
							<!--{if $isfriend}-->
							<a href="home.php?mod=spacecp&ac=friend&op=ignore&uid=$space[uid]&handlekey=ignorefriendhk_{$space[uid]}" id="a_ignore" class="dialog">{lang ignore_friend}</a>
							<!--{else}-->
							<a href="home.php?mod=spacecp&ac=friend&op=add&uid=$space[uid]&handlekey=addfriendhk_{$space[uid]}" id="a_friend" class="dialog">{lang add_friend}</a>
							<!--{/if}-->
							<a href="home.php?mod=spacecp&ac=poke&op=send&uid=$space[uid]&handlekey=propokehk_{$space[uid]}" id="a_poke" class="dialog">{lang say_hi}</a>
							<a href="home.php?mod=space&do=pm&subop=view&touid=$space[uid]" id="a_pm">{lang send_pm}</a>
						</p>

						

					</td>
				</tr>
			</table>
		</div>
	</div>
</div>
<!--{template common/footer}-->
