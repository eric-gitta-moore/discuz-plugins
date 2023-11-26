<?php exit;?>
<!--{template common/header}-->
<!--{eval if(!function_exists('init_n5app'))include DISCUZ_ROOT.'./source/plugin/zhikai_n5appgl/common.php'; if(!function_exists('init_n5app')) exit('Authorization error!');}-->
<!--{eval include_once DISCUZ_ROOT.'./source/plugin/zhikai_n5appgl/nvbing5.php'}-->
<!--{if $op =='ignore' || $op =='add'}-->
<!--{else}-->
{if strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'micromessenger')}
<style type="text/css">
.bg {padding-top: 0;}
</style>
<div class="n5qj_wxgdan cl">
	<a href="javascript:history.back();" class="wxmsf"></a>
	<a href="home.php?mod=space&uid=$_G[uid]&do=profile&mycenter=1" class="wxmsw"></a>
</div>
{else}
<div class="n5qj_tbys nbg cl">
	<a href="javascript:history.back();" class="n5qj_zcan"><div class="zcanfh">{$n5app['lang']['qjfanhui']}</div></a>
	<a href="home.php?mod=space&uid=$_G[uid]&do=profile&mycenter=1" class="n5qj_ycan grtrnzx"></a>
	<span><!--{if $op=='add'}-->{$n5app['lang']['kjhygljwhy']}<!--{elseif $op =='ignore'}-->{$n5app['lang']['kjhyglschy']}<!--{elseif $op=='add2'}-->{$n5app['lang']['kjhyglhyqq']}<!--{/if}--></span>
</div>
{/if}
<style type="text/css">
.bg {background: #fff;}
</style>
<!--{/if}-->

<!--{if $op=='add'}-->
<div class="n5sq_jwhy">
	<a href="javascript:;" onclick="popup.close();" class="ztds_gbck"></a>
	<div class="ztds_mbxx cl">
		<!--{avatar($tospace[uid],middle)}-->
		<p class="mbxx_yhm">{$tospace[username]}</p>
		<p>{$n5app['lang']['kjhygljwhyts']}</p>
	</div>
	<form method="post" autocomplete="off" id="addform_{$tospace[uid]}" name="addform_{$tospace[uid]}" action="home.php?mod=spacecp&ac=friend&op=add&uid=$tospace[uid]" {if $_G[inajax]}onsubmit="ajaxpost(this.id, 'return_$_GET[handlekey]');"{/if}>
	<input type="hidden" name="referer" value="{echo dreferer()}" />
	<input type="hidden" name="addsubmit" value="true" />
	<!--{if $_G[inajax]}--><input type="hidden" name="handlekey" value="$_GET[handlekey]" /><!--{/if}-->
	<input type="hidden" name="formhash" value="{FORMHASH}" />
		<div class="ztds_dsys">
			<div class="jwhy_hyxm cl">
				<div class="hyxm_xmbt z">{$n5app['lang']['kjsydhly']}</div>
				<div class="hyxm_xmnr z"><input type="text" name="note" value="" size="35" class="px"  onkeydown="ctrlEnter(event, 'addsubmit_btn', 1);" /></div>
			</div>
			<div class="jwhy_hyxm cl">
				<div class="hyxm_xmbt z">{lang friend_group}</div>
				<div class="hyxm_xmnr z">
					<select name="gid" class="ps">
						<!--{loop $groups $key $value}-->
							<option value="$key" {if empty($space['privacy']['groupname']) && $key==1} selected="selected"{/if}>$value</option>
						<!--{/loop}-->
					</select>
				</div>
			</div>
		</div>
		<button type="submit" name="addsubmit_btn" id="addsubmit_btn" value="true" class="pn">{lang determine}</button>
	</form>
</div>
<!--{elseif $op =='ignore'}-->
<div class="tip">
<form method="post" autocomplete="off" id="friendform_{$uid}" name="friendform_{$uid}" action="home.php?mod=spacecp&ac=friend&op=ignore&uid=$uid&confirm=1" {if $_G[inajax]}onsubmit="ajaxpost(this.id, 'return_$_GET[handlekey]');"{/if}>
<input type="hidden" name="referer" value="{echo dreferer()}">
<input type="hidden" name="friendsubmit" value="true" />
<input type="hidden" name="formhash" value="{FORMHASH}" />
<input type="hidden" name="from" value="$_GET[from]" />
<!--{if $_G[inajax]}--><input type="hidden" name="handlekey" value="$_GET[handlekey]" /><!--{/if}-->
	<dt>{lang determine_lgnore_friend}</dt>
	<dd><button type="submit" name="friendsubmit_btn" class="formdialog button2" value="true">{lang determine}</button><a href="javascript:;" onclick="popup.close();">{$n5app['lang']['sqbzssmqx']}</a></dd>
</form>
</div>
<script type="text/javascript">
function succeedhandle_{$_GET[handlekey]}(url, msg, values) {
	if(values['from'] == 'notice') {
		deleteQueryNotice(values['uid'], 'pendingFriend');
	} else if(typeof friend_delete == 'function') {
		friend_delete(values['uid']);
	}
}
</script>
<!--{elseif $op=='add2'}-->
<div class="n5gr_hypz cl">
<form method="post" class="n5_hytgts" autocomplete="off" id="addratifyform_{$tospace[uid]}" name="addratifyform_{$tospace[uid]}" action="home.php?mod=spacecp&ac=friend&op=add&uid=$tospace[uid]" {if $_G[inajax]}onsubmit="ajaxpost(this.id, 'return_$_GET[handlekey]');"{/if}>
	<input type="hidden" name="referer" value="{echo dreferer()}" />
	<input type="hidden" name="add2submit" value="true" />
	<input type="hidden" name="from" value="$_GET[from]" />
	<!--{if $_G[inajax]}--><input type="hidden" name="handlekey" value="$_GET[handlekey]" /><!--{/if}-->
	<input type="hidden" name="formhash" value="{FORMHASH}" />
	<div class="hypz_pznr cl">
		<div class="pznr_hyxx cl">
			<a href="home.php?mod=space&uid=$tospace[uid]"><!--{avatar($tospace[uid],middle)}--></a>
			{lang approval_the_request_group}
		</div>
		<div class="pznr_fzxx cl">
		<!--{eval $i=0;}-->
		<!--{loop $groups $key $value}-->
			<label for="group_$key"><input type="radio" name="gid" id="group_$key" value="$key"$groupselect[$key] />$value</label>
		<!--{eval $i++;}-->
		<!--{/loop}-->
		</div>
	</div>
    <div class="hypz_pzan cl">
		<button type="submit" name="add2submit_btn" value="true" class="pn pnc">{lang approval}</button>
		<p>{$n5app['lang']['kjhygljjhyts']}</p>
	</div>
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
<!--{eval $nofooter = true;}-->
<!--{template common/footer}-->