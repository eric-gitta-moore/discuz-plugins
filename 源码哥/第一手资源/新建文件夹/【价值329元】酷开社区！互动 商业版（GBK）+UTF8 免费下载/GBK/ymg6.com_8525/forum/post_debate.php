<?php echo '源码哥免费分享，仅供学习，请支持正版！';exit;?>
<dl class="posot_col ccdebate cl">
  <dt><span>* </span>双方观点：</dt>
  <dd>

<div class="exfm yanjiao guandian bianluns cl">
	<div class="sinf">
		<dl>
			<dt><span class="rq">*</span><label for="affirmpoint">{lang debate_square_point}:</label></dt>
			<dd><textarea name="affirmpoint" id="affirmpoint" class="yanjiao" tabindex="1" style="width:685px;">$debate[affirmpoint]</textarea></dd>
			<dt><span class="rq">*</span><label for="negapoint">{lang debate_opponent_point}:</label></dt>
			<dd><textarea name="negapoint" id="negapoint" class="yanjiao" tabindex="1" style="width:685px;">$debate[negapoint]</textarea></dd>
		</dl>
	</div>
	<div class="sadd ">
		<dl>
			<dd class="dtc"><label for="endtime">{lang endtime}:</label></dd>
			<dd class="hasd">
				<input type="text" name="endtime" id="endtime" class="px" onclick="showcalendar(event, this, true)" autocomplete="off" value="$debate[endtime]" tabindex="1" />
				<a href="javascript:;" class="dpbtn" onclick="showselect(this, 'endtime')">^</a>
			</dd>
			<dd class="dtc"><label for="umpire">{lang debate_umpire}:</label></dd>
			<dd>
				<p><input type="text" name="umpire" id="umpire" class="px" onblur="checkuserexists(this.value, 'checkuserinfo')" value="$debate[umpire]" tabindex="1" /><span id="checkuserinfo"></span></p>
			</dd>
			<!--{hook/post_debate_extra}-->
		</dl>
	</div>
</div>
</dd>
</dl>
<script type="text/javascript" reload="1">
function checkuserexists(username, objname) {
	if(!username) {
		$(objname).innerHTML = '';
		return;
	}
	var x = new Ajax();
	username = BROWSER.ie && document.charset == 'utf-8' ? encodeURIComponent(username) : username;
	x.get('forum.php?mod=ajax&inajax=1&action=checkuserexists&username=' + username, function(s){
		var obj = $(objname);
		obj.innerHTML = s;
	});
}

EXTRAFUNC['validator']['special'] = 'validateextra';
function validateextra() {
	if($('postform').affirmpoint.value == '') {
		showDialog('{lang post_debate_message_1}', 'alert', '', function () { $('postform').affirmpoint.focus() });
		return false;
	}
	if($('postform').negapoint.value == '') {
		showDialog('{lang post_debate_message_2}', 'alert', '', function () { $('postform').negapoint.focus() });
		return false;
	}
	return true;
}
</script>
