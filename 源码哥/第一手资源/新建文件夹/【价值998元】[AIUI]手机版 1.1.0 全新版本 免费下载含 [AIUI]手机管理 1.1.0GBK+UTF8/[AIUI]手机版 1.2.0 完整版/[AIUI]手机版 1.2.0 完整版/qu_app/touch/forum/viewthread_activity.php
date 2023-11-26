<?PHP exit('QQÈº£º550494646');?>
<script type="text/javascript">
	function checkform(theform) {
		if (theform.message.value.length > 250) {
			alert('{lang activiy_guest_more}');
			theform.message.focus();
			return false;
		}
		return true;
	}
</script>

<div class="avact_img"><!--{if $activity['thumb']}--><img src="$activity['thumb']" /><!--{/if}--></div>
<div class="ainuo_vact cl">
	<table width="100%">
    	<tr>
    		<th>{lang activity_type}</th>
            <td>$activity[class]</td>
        </tr>
        <tr>
    		<th>{lang activity_starttime}</th>
            <td>
            	<!--{if $activity['starttimeto']}-->
					{lang activity_start_between}
				<!--{else}-->
					$activity[starttimefrom]
				<!--{/if}-->
            </td>
        </tr>
        <tr>
    		<th>{lang activity_space}</th>
            <td>$activity[place]</td>
        </tr>
        <tr>
    		<th>{lang gender}</th>
            <td>
            	<!--{if $activity['gender'] == 1}-->
					{lang male}
				<!--{elseif $activity['gender'] == 2}-->
					{lang female}
				<!--{else}-->
					 {lang unlimited}
				<!--{/if}-->
            </td>
        </tr>
        <!--{if $activity['cost']}-->
        <tr>
    		<th>{lang activity_payment}</th>
            <td>$activity[cost] {lang payment_unit}<!--{hook/viewthread_activity_extra1}--></td>
        </tr>
        <!--{/if}-->
        <!--{if !$_G['forum_thread']['is_archived']}-->
            <tr>
                <th>{lang activity_already}</th>
                <td>
                    <em>$allapplynum</em> {lang activity_member_unit}
                    
                </td>
            </tr>
            <!--{if $activity['number']}-->
            <tr>
                <th>{lang activity_about_member}</th>
                <td>$aboutmembers {lang activity_member_unit}</td>
            </tr>
            <!--{/if}-->
            <!--{if $activity['expiration']}-->
            <tr>
                <th>{lang post_closing}</th>
                <td>$activity[expiration]<!--{hook/viewthread_activity_extra2}--></td>
            </tr>            
            <!--{/if}-->            
        <!--{/if}-->
    </table>
</div>
<!--{eval $astarttimefrom = DB::result_first('SELECT starttimefrom FROM '.DB::table('forum_activity').' WHERE tid ='.$thread[tid].'')}-->
<!--{eval $astarttimeto = DB::result_first('SELECT starttimeto FROM '.DB::table('forum_activity').' WHERE tid ='.$thread[tid].'')}-->
<!--{eval $aexpiration = DB::result_first('SELECT expiration FROM '.DB::table('forum_activity').' WHERE tid ='.$thread[tid].'')}-->
<!--{eval $anowtime = time()}-->

<!--{if !$_G['forum_thread']['is_archived']}-->
	<!--{if $post['invisible'] == 0}-->
    <div class="woyaocanjia cl">
    <!--{if $aexpiration}-->
    	<!--{if $anowtime < $aexpiration}-->
        		<!--{if $applied && $isverified < 2}-->
                    <!--{if !$activityclose}--><button type="submit" value="true" name="applylistsubmit" class="acttoggle_cancel">{lang activity_join_cancel}</button><!--{/if}-->
                <!--{elseif !$activityclose}-->
                        <!--{if $isverified != 2}-->
                            <!--{if !$activity['number'] || $aboutmembers > 0}--><button value="true" name="ijoin" class="acttoggle_join">{lang activity_join}</button><!--{/if}-->
                        <!--{else}-->
                            <button value="true" name="ijoin" onclick="showDialog($('activityjoin').innerHTML, 'info', '{lang complete_data}')">{lang complete_data}</button>
                        <!--{/if}-->
                <!--{/if}-->
        <!--{else}-->
        	<button style="background:#999;">$alang_activity_over</button>
        <!--{/if}-->
    <!--{else}-->
    	<!--{if $astarttimeto}-->
            <!--{if $astarttimeto < $anowtime}-->
            	<button style="background:#999;">$alang_activity_over</button>
            <!--{else}-->
            	<!--{if $applied && $isverified < 2}-->
                    <!--{if !$activityclose}--><button type="submit" value="true" name="applylistsubmit" class="acttoggle_cancel">{lang activity_join_cancel}</button><!--{/if}-->
                <!--{elseif !$activityclose}-->
                        <!--{if $isverified != 2}-->
                            <!--{if !$activity['number'] || $aboutmembers > 0}--><button value="true" name="ijoin" class="acttoggle_join">{lang activity_join}</button><!--{/if}-->
                        <!--{else}-->
                            <button value="true" name="ijoin" onclick="showDialog($('activityjoin').innerHTML, 'info', '{lang complete_data}')">{lang complete_data}</button>
                        <!--{/if}-->
                <!--{/if}-->
            <!--{/if}-->
        <!--{else}-->
            <!--{if $applied && $isverified < 2}-->
                <!--{if !$activityclose}--><button type="submit" value="true" name="applylistsubmit" class="acttoggle_cancel">{lang activity_join_cancel}</button><!--{/if}-->
            <!--{elseif !$activityclose}-->
                    <!--{if $isverified != 2}-->
                        <!--{if !$activity['number'] || $aboutmembers > 0}--><button value="true" name="ijoin" class="acttoggle_join">{lang activity_join}</button><!--{/if}-->
                    <!--{else}-->
                        <button value="true" name="ijoin" onclick="showDialog($('activityjoin').innerHTML, 'info', '{lang complete_data}')">{lang complete_data}</button>
                    <!--{/if}-->
            <!--{/if}-->
        <!--{/if}-->
    <!--{/if}-->

        
        
        
        <!--{if ($_G['forum_thread']['authorid'] == $_G['uid'] || (in_array($_G['group']['radminid'], array(1, 2)) && $_G['group']['alloweditactivity']) || ( $_G['group']['radminid'] == 3 && $_G['forum']['ismoderator'] && $_G['group']['alloweditactivity']))}-->
            
            <a href="misc.php?mod=invite&action=thread&id=$_G[tid]&activity=1">{lang invite}</a>
            <a href="forum.php?mod=misc&action=activityapplylist&tid=$_G[tid]&pid=$post[pid]{if $_GET['from']}&from=$_GET['from']{/if}" onclick="showWindow('activity', this.href, 'get', 0)" title="{lang manage}">{lang manage}</a>
            <a href="forum.php?mod=misc&action=activityexport&tid=$_G[tid]" title="{lang pm_archive}">{lang pm_archive}</a>
        <!--{/if}-->
    </div>
    <!--{/if}-->
<!--{/if}-->



<!--{if $_G['uid'] && !$activityclose && (!$applied || $isverified == 2)}-->
	<div id="activityjoin" class="activityjoin cl">
    	<div class="ainuo_join activityjoin_con cl">
            <div class="xw1">{lang activity_join}
                <!--{if $post['invisible'] == 0}-->
                        <!--{if $applied && $isverified < 2}-->
                            
                            <!--{if !$activityclose}-->
                            <!--{/if}-->
                        <!--{elseif !$activityclose}-->
                            <!--{if $isverified != 2}-->
                            <!--{else}-->
                            <font color="#f60">({lang complete_data})</font>
                            <!--{/if}-->
                        <!--{/if}-->
                    <!--{/if}-->
            </div>
        <!--{if $_G['forum']['status'] == 3 && helper_access::check_module('group') && $isgroupuser != 'isgroupuser'}-->
            <p style="padding:10px 10px 0 10px">{lang activity_no_member}</p>
            <p style="padding:10px"><a href="forum.php?mod=group&action=join&fid=$_G[fid]" class="xi2">{lang activity_join_group}</a></p>
        <!--{else}-->
            <form name="activity" class="activity" id="activity" method="post" autocomplete="off" action="forum.php?mod=misc&action=activityapplies&fid=$_G[fid]&tid=$_G[tid]&pid=$post[pid]{if $_GET['from']}&from=$_GET['from']{/if}&mobile=2" >
                <input type="hidden" name="formhash" value="{FORMHASH}" />
    
                <!--{if $_G['setting']['activitycredit'] && $activity['credit'] && !$applied}--><p class="kouchu">{lang activity_need_credit} $activity[credit] {$_G['setting']['extcredits'][$_G['setting']['activitycredit']][title]}</p><!--{/if}-->
                    <!--{if $activity['cost']}-->
                       <p class="zhifu">
                       <label><input class="pr" type="radio" value="0" name="payment" id="payment_0" checked="checked" />{lang activity_pay_myself}</label><br />
                       <label><input class="pr" type="radio" value="1" name="payment" id="payment_1" />{lang activity_would_payment} </label> 
                       <input name="payvalue" size="3" class="txt_s" /> {lang payment_unit}
                       </p>
                    <!--{/if}-->
                    <!--{if !empty($activity['ufield']['userfield'])}-->
                    <ul>
                        <!--{loop $activity['ufield']['userfield'] $fieldid}-->
                        <!--{if $settings[$fieldid][available]}-->
                            <li><span class="info">$settings[$fieldid][title]<em>*</em></span>
                            $htmls[$fieldid]</li>
                        <!--{/if}-->
                        <!--{/loop}-->
                    </ul>
                    <!--{/if}-->
                    <!--{if !empty($activity['ufield']['extfield'])}-->
                        <!--{loop $activity['ufield']['extfield'] $extname}-->
                            $extname<input type="text" name="$extname" maxlength="200" class="txt" value="{if !empty($ufielddata)}$ufielddata[extfield][$extname]{/if}" />
                        <!--{/loop}-->
                    <!--{/if}-->
                    <p class="atxt"><textarea name="message" maxlength="250" placeholder="{lang leaveword}">$applyinfo[message]</textarea></p>
                <div class="mmtn">
                    <!--{if $_G['setting']['activitycredit'] && $activity['credit'] && checklowerlimit(array('extcredits'.$_G['setting']['activitycredit'] => '-'.$activity['credit']), $_G['uid'], 1, 0, 1) !== true}-->
                        <p class="dashedtip">{$_G['setting']['extcredits'][$_G['setting']['activitycredit']][title]} {lang not_enough}$activity['credit']</p>
                    <!--{else}-->
                        <input type="hidden" name="activitysubmit" value="true">
                        <em class="xi1" id="return_activityapplies"></em>
                        <button type="submit" class="ainuobaoming"><span>{lang submit}</span></button>
                        <a href="javascript:;" class="cancelbaoming">{lang cancel}</a>
                    <!--{/if}-->
                </div>
            </form>
    
            <script type="text/javascript">
                function succeedhandle_activityapplies(locationhref, message) {
                    showDialog(message, 'notice', '', 'location.href="' + locationhref + '"');
                }
            </script>
        <!--{/if}-->
            </div>
    </div>
<!--{elseif $_G['uid'] && !$activityclose && $applied}-->
<div id="activityjoincancel" class="activityjoincancel cl">
	<div class="ainuo_join activityjoincancel_con cl">
        <div class="xw1">{lang activity_join_cancel}</div>
        <form name="activity" class="activity" method="post" autocomplete="off" action="forum.php?mod=misc&action=activityapplies&fid=$_G[fid]&tid=$_G[tid]&pid=$post[pid]{if $_GET['from']}&from=$_GET['from']{/if}">
        <input type="hidden" name="formhash" value="{FORMHASH}" />
        <p class="atxt">
            <textarea name="message" placeholder="{lang leaveword}" /></textarea>
        </p>
        <div class="mmtn">
        	<button type="submit" name="activitycancel"  value="true"><span>{lang submit}</span></button>
            <a href="javascript:;" class="cancelbaoming">{lang cancel}</a>
        </div>
        </form>
    </div>
</div>
<!--{/if}-->

<!--{if $applylist}-->
<div class="ainuo_approed cl">
	<div class="cl">
    <p>{lang activity_new_join} $applynumbers {lang activity_member_unit}</p>
    <table class="dt" cellpadding="5" cellspacing="5">
        <tr>
            <th>$alang_user</th>
            <!--{if $activity['cost']}-->
            <th >{lang activity_payment}</th>
            <!--{/if}-->
            <th>{lang activity_jointime}</th>
        </tr>
        <!--{loop $applylist $apply}-->
            <tr>
                <td>
                    <a href="home.php?mod=space&uid={$apply[uid]}&do=profile">$apply[username]</a>
                </td>
                <!--{if $activity['cost']}-->
                <td><!--{if $apply[payment] >= 0}-->$apply[payment] {lang payment_unit}<!--{else}-->{lang activity_self}<!--{/if}--></td>
                <!--{/if}-->
                <td>$apply[dateline]</td>
            </tr>
        <!--{/loop}-->
    </table>
    </div>
</div>
<!--{/if}-->

<!--{if $applylistverified}-->
<div class="ainuo_approed afild cl">
	<div class="cl">
    <p>{lang activity_new_signup} $noverifiednum {lang activity_member_unit}</p>
    <table class="dt" cellpadding="5" cellspacing="5">
        <tr>
            <th>{lang leaveword}</th>
            <!--{if $activity['cost']}-->
            <th >{lang activity_payment}</th>
            <!--{/if}-->
            <th>{lang activity_jointime}</th>
        </tr>
        <!--{loop $applylistverified $apply}-->
            <tr>
                <td>
                    <a href="home.php?mod=space&uid={$apply[uid]}&do=profile">$apply[username]</a>
                </td>
                <!--{if $activity['cost']}-->
                <td><!--{if $apply[payment] >= 0}-->$apply[payment] {lang payment_unit}<!--{else}-->{lang activity_self}<!--{/if}--></td>
                <!--{/if}-->
                <td>$apply[dateline]</td>
            </tr>
        <!--{/loop}-->
    </table>
    </div>
</div>
<!--{/if}-->

<div id="postmessage_$post[pid]" class="postmessage">$post[message]</div>

<script>
$(document).on('click', '.ainuobaoming', function() {
Zepto('.page').append('<div class="ainuooverlay"><div class="preloader-indicator-overlay"></div><div class="preloader-indicator-modal"><span class="preloader preloader-white"></span></div></div>');
var obj = $(this);
var formobj = $(this.form);
$.ajax({
	type:'POST',
	url:formobj.attr('action') + '&handlekey='+ formobj.attr('id') +'&inajax=1',
	data:formobj.serialize(),
	dataType:'xml'
})
.success(function(s) {
		if(s.lastChild.firstChild.nodeValue.indexOf("$alang_activity_success") >= 0){
			Zepto('.ainuooverlay').remove();
			Zepto.toast('$alang_activity_success',1500,'toast');
			evalscript(s.lastChild.firstChild.nodeValue);
		}else{
			Zepto('.ainuooverlay').remove();
			popup.open(s.lastChild.firstChild.nodeValue);
			evalscript(s.lastChild.firstChild.nodeValue);
		}
	})
	.error(function() {
		window.location.href = obj.attr('href');
		Zepto('.ainuooverlay').remove();
	});
	return false;
});
</script>