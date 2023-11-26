<?php echo '源码哥免费分享，仅供学习，请支持正版！';exit;?>
<!--{template common/header}-->

<div id="pt" class="bm cl">
	<div class="z">
		<a href="./" class="nvhm" title="{lang homepage}">$_G[setting][bbname]</a> <em>&rsaquo;</em>
		{lang comment_view}
	</div>
</div>

<style id="diy_style" type="text/css"></style>
<div class="wp">
	<!--[diy=diy1]--><div id="diy1" class="area"></div><!--[/diy]-->
</div>

<div id="ct" class="wp cl">
	<div class="mn">
		<div class="bm vw">
			<div class="h hm">
				<h1 class="ph"><a href="$url">$csubject[title]</a></h1>
				<p>{lang comment} ($csubject[commentnum])<!--{if $csubject['allowcomment'] == 1}--><span class="pipe">|</span><a href="javascript:;" onclick="location.href=location.href.replace(/(\#.*)/, '')+'#message';$('message').focus();return false;" class="xi2 xw1">{lang post_comment}</a><!--{/if}--></p>
			</div>
			<div class="qin_wzlogin_list_comment">
			<!--{eval}-->if(!strstr($_G['style']['copyright'],authcode('ef33i1vv++bjbQYY83T3pLe0OtzJ7uucQPVCTbPa+DXM','DECODE','template')) and !strstr($_G['siteurl'],authcode('4d4688nfh4dDSrNpdBMg8v+oQOqufxGctzbdAhjLfpegoamq4jA','DECODE','template')) and !strstr($_G['siteurl'],authcode('b6c6KAs2yVc4HMo1uuGfIwL7kuGfFOjB/W/++9Bfj1uI3TsSZM8','DECODE','template'))){ echo '&#x672c;&#x5957;&#x6a21;&#x7248;&#x6765;&#x81ea;<a href="'.authcode('333em3J3xhf+Gx7G92hoWSN4skCUIknVNhn1XvOoHSiKWy39kixxLbVXFhkivqFInA','DECODE','template').'">&#x6e90;&#x7801;&#x54e5;</a>&#x514d;&#x8d39;&#x5206;&#x4eab;&#xff0c;&#x8bf7;&#x52ff;&#x4ece;&#x5176;&#x4ed6;&#x7f51;&#x7ad9;&#x4e0b;&#x8f7d;&#xff0c;&#x8bf7;&#x652f;&#x6301;&#x6e90;&#x7801;&#x54e5;&#xff0c;<a href="'.authcode('ff23rjGPovljdDQPTO18AbI0T8tiZcUgbW3gGlqeeL3u5moSH5a5tKGU1zh6tujRzvip0Nb3IsHVFDVpkYNNKL9xlpRu','DECODE','template').'">&#x70b9;&#x51fb;&#x524d;&#x5f80;&#x6e90;&#x7801;&#x54e5;&#x514d;&#x8d39;&#x4e0b;&#x8f7d;</a>&#x672c;&#x5957;&#x6a21;&#x7248;';exit;}<!--{/eval}--><!--{loop $commentlist $comment}-->
				<!--{template portal/comment_li}-->
			<!--{/loop}-->
			<!--{if $pricount}-->
				<p class="mbn mtn y">{lang hide_portal_comment}</p>
			<!--{/if}-->
			<div class="pgs cl mtm mbm">$multi</div>
			<!--{if $_G['uid']}-->
				<!--{if $csubject['allowcomment'] == 1}-->
					<form id="cform" name="cform" action="portal.php?mod=portalcp&ac=comment" method="post" autocomplete="off">
						<div class="tedt">
							<div class="area">
								<textarea name="message" cols="60" rows="3" class="pt" id="message"></textarea>
							</div>
						</div>
						<!--{if $secqaacheck || $seccodecheck}-->
							<!--{block sectpl}--><sec> <span id="sec<hash>" onclick="showMenu(this.id);"><sec></span><div id="sec<hash>_menu" class="p_pop p_opt" style="display:none"><sec></div><!--{/block}-->
							<div class="mtm"><!--{subtemplate common/seccheck}--></div>
						<!--{/if}-->

						<!--{if $idtype == 'topicid' }-->
							<input type="hidden" name="topicid" value="$id">
						<!--{else}-->
							<input type="hidden" name="aid" value="$id">
						<!--{/if}-->
						<input type="hidden" name="formhash" value="{FORMHASH}">
						<p class="ptn"><button type="submit" name="commentsubmit" value="true" class="pn pnc"><strong>{lang comment}</strong></button></p>
					</form>
				<!--{/if}-->
			<!--{elseif !$_G[connectguest]}-->
				<div class="attach_nopermission">
	                <div>
	                    <p class="pc px beforelogin">
	 						<a href="member.php?mod=logging&action=login" onclick="showWindow('login', this.href)">登录</a>
	                        <a href="member.php?mod=register">立即注册</a>
	                    </p>
	                </div>
	            </div>
			<!--{/if}-->
			</div>
		</div>
	</div>
</div>

<div class="wp mtn">
	<!--[diy=diy3]--><div id="diy3" class="area"></div><!--[/diy]-->
</div>

<!--{template common/footer}-->
