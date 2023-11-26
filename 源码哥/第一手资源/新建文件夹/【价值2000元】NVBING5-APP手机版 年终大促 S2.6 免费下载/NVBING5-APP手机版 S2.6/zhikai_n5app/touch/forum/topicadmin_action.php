<?php exit;?>
<!--{template common/header}-->
<div class="tip">
<!--{if in_array($_GET[action], array('delpost', 'banpost', 'warn', 'live', 'copy', 'split', 'merge'))}-->
	<form id="topicadminform" method="post" autocomplete="off" action="forum.php?mod=topicadmin&action=$_GET[action]&modsubmit=yes&modclick=yes&mobile=2" >
		<input type="hidden" name="formhash" value="{FORMHASH}" />
		<input type="hidden" name="fid" value="$_G[fid]" />
		<input type="hidden" name="tid" value="$_G[tid]" />
		<input type="hidden" name="page" value="$_G[page]" />
		<input type="hidden" name="reason" value="{lang topicadmin_mobile_mod}" />
    <!--{if $_GET[action] == 'delpost'}-->
            <dt>{lang admin_delpost_confirm}</dt>
            $deleteid
			<dd><input type="submit" name="modsubmit" id="modsubmit" value="{lang confirms}" class="formdialog button2"><a href="javascript:;" onclick="popup.close();" >{lang cancel}</a></dd>
	<!--{elseif $_GET[action] == 'banpost'}-->
		<dt>
            <p>{lang admin_banpost_confirm}</p>
            $banid
            <p><label><input type="radio" name="banned" class="pr" value="1" $checkban />{lang admin_banpost}</label></p>
			<p><label><input type="radio" name="banned" class="pr" value="0" $checkunban />{lang admin_unbanpost}</label></p>
		</dt>
		<dd><input type="submit" name="modsubmit" id="modsubmit" value="{lang confirms}" class="formdialog button2"><a href="javascript:;" onclick="popup.close();" >{lang cancel}</a></dd>
    <!--{elseif $_GET[action] == 'warn'}-->
		<dt>
            <p>{lang admin_warn_confirm}</p>
            $warnpid
            <p><label><input type="radio" name="warned" class="pr" value="1" $checkwarn />{lang topicadmin_warn_add}</label></p>
			<p><label><input type="radio" name="warned" class="pr" value="0" $checkunwarn />{lang topicadmin_warn_delete}</label></p>
		</dt>
		<dd><input type="submit" name="modsubmit" id="modsubmit" value="{lang confirms}" class="formdialog button2"><a href="javascript:;" onclick="popup.close();" >{lang cancel}</a></dd>
	<!--{elseif $_GET[action] == 'live'}-->
		<dt>
			<p><label><input type="radio" name="live" class="pr" value="1" <!--{if $_G[forum][livetid] != $_G[tid]}-->checked<!--{/if}-->/>{lang admin_live}</label></p>
			<p><label><input type="radio" name="live" class="pr" value="0" <!--{if $_G[forum][livetid] == $_G[tid]}-->checked<!--{/if}-->/>{lang admin_live_cancle}</label></p>
		</dt>
		<dd><input type="submit" name="modsubmit" id="modsubmit" value="{lang confirms}" class="formdialog button2"><a href="javascript:;" onclick="popup.close();" >{lang cancel}</a></dd>
	<!--{elseif $_GET[action] == 'copy'}-->
		<dt>
			<p class="mbn tahfx">{lang admin_target}: <select name="copyto" id="copyto" class="ps vm" onchange="ajaxget('forum.php?mod=ajax&action=getthreadtypes&fid=' + this.value, 'threadtypes')">$forumselect</select></p>
			<p class="mbn tahfx">{lang admin_targettype}: <span id="threadtypes"><select name="threadtypeid" class="ps vm"><option value="0" /></option></select></span></p>
		</dt>
		<dd><input type="submit" name="modsubmit" id="modsubmit" value="{lang confirms}" class="formdialog button2"><a href="javascript:;" onclick="popup.close();" >{lang cancel}</a></dd>
	<!--{elseif $_GET[action] == 'split'}-->
		<dt>
			<p>{lang admin_split_newsubject} <input type="text" name="subject" id="subject" class="px" size="20" /></p><br />
			<p>{lang admin_split_comment}</p>
			<p><textarea name="split" id="split" class="pt" style="width: 212px; height:120px" /></textarea></p>
		</dt>
		<dd><input type="submit" name="modsubmit" id="modsubmit" value="{lang confirms}" class="formdialog button2"><a href="javascript:;" onclick="popup.close();" >{lang cancel}</a></dd>
	<!--{elseif $_GET[action] == 'merge'}-->
		<dt>
			<p>{lang admin_merge_tid}</p><br />
			<p><input type="text" name="othertid" id="othertid" class="px" size="10" /></p>
		</dt>
		<dd><input type="submit" name="modsubmit" id="modsubmit" value="{lang confirms}" class="formdialog button2"><a href="javascript:;" onclick="popup.close();" >{lang cancel}</a></dd>
    <!--{/if}-->
    </form>
<!--{else}-->
    	<dt>{lang admin_threadtopicadmin_error}</dt>
		<dd><input type="button" onclick="popup.close();" value="{lang confirms}" /></dd>
<!--{/if}-->
</div>
<!--{template common/footer}-->
