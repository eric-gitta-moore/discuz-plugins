<?PHP exit('QQÈº£º550494646');?>
<!--{template common/header}-->
<!--{subtemplate home/spacecp_poke_type}-->
<!--{if !$_G[inajax]}-->
<div id="pt" class="bm cl">
	<div class="z"><a href="./" class="nvhm" title="{lang homepage}">$_G[setting][bbname]</a> <em>&rsaquo;</em> <a href="home.php">$_G[setting][navs][4][navname]</a> <em>&rsaquo;</em> {lang say_hi}</div>
</div>
<div id="ct" class="ct2_a wp cl">
	<div class="mn">
		<div class="bm bw0">
			<h1 class="mt"><img alt="poke" src="{STATICURL}image/feed/poke.gif" class="vm" /> {lang poke}</h1>
			<ul class="tb cl">
				<li$actives[poke]><a href="home.php?mod=spacecp&ac=poke">{lang poke_received}</a></li>
				<li$actives[send]><a href="home.php?mod=spacecp&ac=poke&op=send">{lang say_hi}</a></li>
			</ul>
<!--{/if}-->
<!--{if $op == 'send' || $op == 'reply'}-->
        <div class="ainuo_dazhaohu cl">
        	<div class="atit cl">{lang say_hi}</div>
			<form method="post" autocomplete="off" id="pokeform_{$tospace[uid]}" name="pokeform_{$tospace[uid]}" action="home.php?mod=spacecp&ac=poke&op=$op&uid=$tospace[uid]" {if $_G[inajax]}onsubmit="ajaxpost(this.id, 'return_$_GET[handlekey]');"{/if}>
				<input type="hidden" name="referer" value="{echo dreferer()}">
				<input type="hidden" name="pokesubmit" value="true" />
				<input type="hidden" name="formhash" value="{FORMHASH}" />
				<input type="hidden" name="from" value="$_GET[from]" /><!--From ww w.moq u8 .com -->
				<!--{if $_G[inajax]}--><input type="hidden" name="handlekey" value="$_GET[handlekey]" /><!--{/if}-->
				<div class="acon cl">
					<div class="mbm xs2">
					<!--{if $tospace[uid]}-->
						{lang to} <strong>{$tospace[username]}</strong> {lang say_hi}:
					<!--{else}-->
						<input type="text" name="username" value="" class="px" placeholder="{lang username}" />
					<!--{/if}-->
					</div>
					<ul class="poke cl">
						<!--{loop $icons $k $v}-->
						<li><label for="poke_$k"><input type="radio" name="iconid" id="poke_$k" value="{$k}" {if $k==3}checked="checked"{/if} />{$v}</label></li>
						<!--{/loop}-->
					</ul>
					<input type="text" name="note" id="note" value="" class="linepx" placeholder="{lang content}" />
					<p class="dashedtip cl">{lang max_text_poke_message}</p>
                    
                    <p class="cl">
                        <button type="submit" name="pokesubmit_btn" id="pokesubmit_btn" value="true" class="ainuoformdialog">{lang send}</button>
                    </p>
                </div>
			</form>
        </div>

<!--{elseif $op == 'view'}-->
			<!--{loop $list $key $subvalue}-->
			<p class="pbm mbm bbda">
				<!--{if $subvalue[fromuid]==$space[uid]}-->{lang me}<!--{else}--><a href="home.php?mod=space&uid=$subvalue[fromuid]" class="xi2">{$value[fromusername]}</a><!--{/if}-->:
				<span class="xw0">
					<!--{if $subvalue[iconid]}-->{$icons[$subvalue[iconid]]}<!--{else}-->{lang say_hi}<!--{/if}-->
					<!--{if $subvalue[note]}-->, {lang say}: $subvalue[note]<!--{/if}-->
					&nbsp; <span class="xg1"><!--{date($subvalue[dateline],'n-j H:i')}--></span>
				</span>
			</p>
			<!--{/loop}-->
			<div class="pbn ptm xg1 xw0">
				<a href="home.php?mod=spacecp&ac=poke&op=reply&uid=$value[uid]&handlekey=pokehk_{$value[uid]}" id="a_p_r_$value[uid]" onclick="showWindow(this.id, this.href, 'get', 0);">{lang back_to_say_hello}</a>
				<a href="home.php?mod=spacecp&ac=poke&op=ignore&uid=$value[uid]" id="a_p_i_$value[uid]" onclick="showWindow('pokeignore', this.href, 'get', 0);">{lang ignore}</a>
				<!--{if !$value['isfriend']}--><span class="pipe">|</span><a href="home.php?mod=spacecp&ac=friend&op=add&uid=$value[uid]&handlekey=addfriendhk_{$value[uid]}" id="a_friend_$value[uid]" onclick="showWindow(this.id, this.href, 'get', 0);">{lang add_friend}</a> <!--{/if}-->
			</div>
<!--{elseif $op == 'ignore'}-->

            <div class="ainuo_dazhaohu cl">
            <div class="atit cl">{lang lgnore_poke}</div>
			<form method="post" autocomplete="off" id="friendform_{$uid}" name="friendform_{$uid}" action="home.php?mod=spacecp&ac=poke&op=ignore&uid=$uid" {if $_G[inajax]}onsubmit="ajaxpost(this.id, 'return_$_GET[handlekey]');"{/if}>
				<input type="hidden" name="referer" value="{echo dreferer()}">
				<input type="hidden" name="ignoresubmit" value="true" />
				<input type="hidden" name="formhash" value="{FORMHASH}" />
				<input type="hidden" name="from" value="$_GET[from]" />
				<!--{if $_G[inajax]}--><input type="hidden" name="handlekey" value="$_GET[handlekey]" /><!--{/if}-->
				<div class="acon cl" style="width:200px">
                	{lang determine_lgnore_poke}
				<p class="cl">
					<button type="submit" name="ignoresubmit_btn" value="true">{lang determine}</button>
				</p>
                </div>
			</form>
            </div>
<!--{else}-->
			<p class="tbmu">{lang you_can_reply_ignore}<span class="pipe">|</span><a href="home.php?mod=spacecp&ac=poke&op=ignore" id="a_poke" onclick="showWindow('allignore', this.href, 'get', 0);">{lang ignore_all}</a></p>
			<!--{if $list}-->
			<div id="poke_ul" class="xld xlda">
				<!--{loop $list $key $value}-->
				<dl id="poke_$value[uid]" class="bbda cl">
					<dd class="m avt"><a href="home.php?mod=space&uid=$value[uid]"><!--{avatar($value[uid],small)}--></a></dd>
					<dt id="poke_td_$value[uid]">
						<p class="mbm">
							<a href="home.php?mod=space&uid=$value[fromuid]" class="xi2">{$value[fromusername]}</a>:
							<span class="xw0">
								<!--{if $value[iconid]}-->{$icons[$value[iconid]]}<!--{else}-->{lang say_hi}<!--{/if}-->
								<!--{if $value[note]}-->, {lang say}: $value[note]<!--{/if}-->
								&nbsp; <span class="xg1"><!--{date($value[dateline], 'n-j H:i')}--></span>
							</span>
						</p>
						<div class="pbn ptm xg1 xw0 cl">
							<div class="y"><a href="javascript:;" onclick="view_poke($value[uid]);">{lang see_all_poke}</a></div>
							<a href="home.php?mod=spacecp&ac=poke&op=reply&uid=$value[uid]&handlekey=pokereply" id="a_p_r_$value[uid]" onclick="showWindow('pokereply', this.href, 'get', 0);">{lang back_to_say_hello}</a>
							<a href="home.php?mod=spacecp&ac=poke&op=ignore&uid=$value[uid]&handlekey=pokeignore" id="a_p_i_$value[uid]" onclick="showWindow('pokeignore', this.href, 'get', 0);">{lang ignore}</a>
							<!--{if !$value['isfriend']}--><span class="pipe">|</span><a href="home.php?mod=spacecp&ac=friend&op=add&uid=$value[uid]&handlekey=addfriendhk_{$value[uid]}" id="a_friend_$value[uid]" onclick="showWindow(this.id, this.href, 'get', 0);">{lang add_friend}</a> <!--{/if}-->
						</div>
					</dt>
				</dl>
				<!--{/loop}-->
			</div>
			<!--{if $multi}--><div class="pgs cl mtm">$multi</div><!--{/if}-->
			<script type="text/javascript">
			function view_poke(uid) {
				ajaxget('home.php?mod=spacecp&ac=poke&op=view&uid='+uid, 'poke_td_'+uid);
			}
			<!--{if $_GET[fuid]}-->
				view_poke($_GET[fuid]);
			<!--{/if}-->
			</script>
			<!--{else}-->
                <div class="emp"><i class="iconfont icon-meiyougengduole"></i><p>{lang no_new_poke}</p></div>
			<!--{/if}-->

			<script type="text/javascript">
				function succeedhandle_pokereply(url, msg, values) {
					if(parseInt(values['uid'])) {
						$('poke_'+values['uid']).style.display = "none";
					}
				}
				function errorhandle_pokeignore(msg, values) {
					if(parseInt(values['uid'])) {
						$('poke_'+values['uid']).style.display = "none";
					}
				}
				function errorhandle_allignore(msg, values) {
					if($('poke_ul')) {
						$('poke_ul').innerHTML = '<div class="emp cl"><i class="iconfont icon-meiyougengduole"></i><p>{lang ignore_all_poke}</p></div>';
					}
				}
			</script>
<!--{/if}-->
<!--{if !$_G[inajax]}-->
		</div>
	</div>
	<div class="appl">
		<!--{subtemplate common/userabout}-->
	</div>
</div>
<!--{/if}-->
<!--{template common/footer}-->