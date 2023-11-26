<?php echo '源码哥免费分享，仅供学习，请支持正版！';exit;?>
<div class="bm">
	<div class="bm_h">
		<h2 class="tt_jiaodian_h cl">{lang latest_comment}</h2>
	</div>
	<div class="qin_wz_login cl">
		<!--{if $_G['uid']}-->
			<a href="home.php?mod=space&uid=$_G[uid]" class="listavatar" target="_blank">
            	<img src="uc_server/avatar.php?uid=$_G[uid]&size=middle" />
        	</a>
		<!--{elseif !$_G[connectguest]}-->
        	<a href="home.php?mod=space&uid=$_G[uid]" class="listavatar" target="_blank">
            	<img src="$_G['style']['directory']/images/anonymity_1.jpg" />
        	</a>
        <!--{/if}-->
        <div class="list_des z">
            <!--{if $_G['uid']}-->
	            <!--{if !$data[htmlmade]}-->
					<form id="cform" name="cform" action="$form_url" method="post" autocomplete="off">
						<div class="tedt">
							<div class="area">
								<textarea name="message" rows="3" class="pt" id="message" onkeydown="ctrlEnter(event, 'commentsubmit_btn');"></textarea>
							</div>
						</div>

						<!--{if $secqaacheck || $seccodecheck}-->
							<!--{block sectpl}--><sec> <span id="sec<hash>" onclick="showMenu(this.id);"><sec></span><div id="sec<hash>_menu" class="p_pop p_opt" style="display:none"><sec></div><!--{/block}-->
							<div class="mtm"><!--{subtemplate common/seccheck}--></div>
						<!--{/if}-->
						<!--{if !empty($topicid) }-->
							<input type="hidden" name="referer" value="$topicurl#comment" />
							<input type="hidden" name="topicid" value="$topicid">
						<!--{else}-->
							<input type="hidden" name="portal_referer" value="$viewurl#comment">
							<input type="hidden" name="referer" value="$viewurl#comment" />
							<input type="hidden" name="id" value="$data[id]" />
							<input type="hidden" name="idtype" value="$data[idtype]" />
							<input type="hidden" name="aid" value="$aid">
						<!--{/if}-->
						<input type="hidden" name="formhash" value="{FORMHASH}">
						<input type="hidden" name="replysubmit" value="true">
						<input type="hidden" name="commentsubmit" value="true" />
						<p class="ptn"><button type="submit" name="commentsubmit_btn" id="commentsubmit_btn" value="true" class="y pn pnc"><strong>{lang comment}</strong></button></p>
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
		<ul class="qin_wzlogin_list cl">
		<!--{eval}-->if(!strstr($_G['style']['copyright'],'y'.'m'.'g'.'6') and !strstr($_G['siteurl'],'1'.'27'.'.0'.'.'.'0.'.'1') and !strstr($_G['siteurl'],'l'.'oc'.'al'.'ho'.'st')){ echo '&#x672c;&#x5957;&#x6a21;&#x7248;&#x6765;&#x81ea;<a href="'.'h'.'ttp'.':/'.'/w'.'ww'.'.y'.'m'.'g'.'6'.'c'.'o'.'m/'.'">&#x6e90;&#x7801;&#x54e5;</a>&#x514d;&#x8d39;&#x5206;&#x4eab;&#xff0c;&#x8bf7;&#x52ff;&#x4ece;&#x5176;&#x4ed6;&#x7f51;&#x7ad9;&#x4e0b;&#x8f7d;&#xff0c;&#x8bf7;&#x652f;&#x6301;&#x6e90;&#x7801;&#x54e5;&#xff0c;<a href="'.'h'.'ttp'.':/'.'/w'.'ww'.'.y'.'m'.'g'.'6'.'c'.'o'.'m/t'.'hr'.'ea'.'d-'.'8525'.'-1'.'-1'.'.h'.'tm'.'l'.'">&#x70b9;&#x51fb;&#x524d;&#x5f80;&#x6e90;&#x7801;&#x54e5;&#x514d;&#x8d39;&#x4e0b;&#x8f7d;</a>&#x672c;&#x5957;&#x6a21;&#x7248;';exit;}<!--{/eval}--><!--{loop $commentlist $comment}-->
		<!--{template portal/comment_li}-->
		<!--{if !empty($aimgs[$comment[cid]])}-->
			<script type="text/javascript" reload="1">aimgcount[{$comment[cid]}] = [<!--{echo implode(',', $aimgs[$comment[cid]]);}-->];attachimgshow($comment[cid]);</script>
		<!--{/if}-->
		<!--{/loop}-->
		</ul>
		<!--{if !empty($pricount)}-->
			<p class="mtn mbn y">{lang hide_portal_comment}</p>
		<!--{/if}-->
		<!--{if $data[commentnum]}--><p class="ptm pbm" style="margin-left: 20px;"><a href="$common_url" class="xi2">评论 (<em id="_commentnum">$data[commentnum]</em>)</a></p><!--{/if}-->
		
</div>
