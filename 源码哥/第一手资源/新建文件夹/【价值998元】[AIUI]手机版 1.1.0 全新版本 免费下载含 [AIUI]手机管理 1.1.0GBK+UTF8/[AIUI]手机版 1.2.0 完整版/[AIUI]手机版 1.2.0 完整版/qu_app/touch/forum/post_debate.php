<?PHP exit('QQÈº£º550494646');?>
<div class="exfm_debate cl">
	<div class="section cl">
		<table width="100%">
        	<tr>
            	<th><label for="affirmpoint">{lang debate_square_point}</label><span class="rq">*</span></th>
                <td><textarea name="affirmpoint" id="affirmpoint" rows="3" class="px" tabindex="1">$debate[affirmpoint]</textarea></td>
            </tr>
            <tr>
            	<th><label for="negapoint">{lang debate_opponent_point}</label><span class="rq">*</span></th>
                <td><textarea name="negapoint" id="negapoint" class="px" rows="3" tabindex="1">$debate[negapoint]</textarea></td>
            </tr>
            <tr>
            	<th><label for="endtime">{lang endtime}</label></th>
                <td><input type="text" name="endtime" id="endtime" class="ainuo_calendar px" autocomplete="off" value="$debate[endtime]" tabindex="1" readonly="readonly" />
				</td>
            </tr>
            <tr>
            	<th><label for="umpire">{lang debate_umpire}</label></th>
                <td><input type="text" name="umpire" id="umpire" class="px" onblur="checkuserexists(this.value, 'checkuserinfo')" value="$debate[umpire]" tabindex="1" /><span id="checkuserinfo"></span></td>
            </tr>
		</table>
	</div>
</div>
<div class="grey_line cl"></div>
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