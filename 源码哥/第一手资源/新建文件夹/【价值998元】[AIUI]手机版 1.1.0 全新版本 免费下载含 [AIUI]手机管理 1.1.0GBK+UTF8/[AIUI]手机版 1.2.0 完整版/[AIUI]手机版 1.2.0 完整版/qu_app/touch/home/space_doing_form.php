<?PHP exit('QQÈº£º550494646');?>
<script type="text/javascript">
var msgstr = '$defaultstr';
function handlePrompt(type) {
	var msgObj = $('message');
	if(type) {
		if(msgObj.value == msgstr) {
			msgObj.value = '';
			msgObj.className = 'xg2';
		}
		if($('message_menu')) {
			if($('message_menu').style.display == 'block') {
				showFace('message', 'message', msgstr);
			}
		}
		if(BROWSER.firefox || BROWSER.chrome) {
			showFace('message', 'message', msgstr);
		}
	} else {
		if(msgObj.value == ''){
			msgObj.value = msgstr;
			msgObj.className = 'xg1';
		}
	}
}
</script>
<!--{if $_G['inajax']}-->
<div class="ainuo_pop cl">
	<div class="atit cl">{lang reply}</div>
	<form method="post" autocomplete="off" id="mood_addform" action="home.php?mod=spacecp&ac=doing&view=$_GET[view]" onsubmit="if($('message').value == msgstr){return false;}">
    	<div class="acon cl">

                <div id="mood_statusinput" class="ainuo_nologin area">
					<textarea name="message" id="message" class="px" placeholder="{$alang_xsds}"></textarea>
				</div>

				<div id="return_doing" class="xi1 xw1"></div>
        </div>
        <div class="ainuo_popbottom cl" style="margin:0;">
            <button type="submit" name="add" id="add" class="aconfirm">{lang publish}</button>
            <a href="javascript:;" onclick="popup.close()" class="acancel">{lang cancel}</a>
        </div>

		<input type="hidden" name="addsubmit" value="true" />
		<input type="hidden" name="refer" value="$theurl" />
		<input type="hidden" name="topicid" value="$topicid" />
		<input type="hidden" name="formhash" value="{FORMHASH}" />
	</form>
</div>
<!--{else}-->
	<form method="post" autocomplete="off" id="mood_addform" action="home.php?mod=spacecp&ac=doing&view=$_GET[view]" onsubmit="if($('message').value == msgstr){return false;}">
    	<div class="acon cl">

                <div id="mood_statusinput" class="ainuo_nologin area">
					<textarea name="message" id="message" onfocus="handlePrompt(1);" onclick="showFace(this.id, 'message', msgstr);" onblur="handlePrompt(0);" onkeyup="strLenCalc(this, 'maxlimit')" onkeydown="ctrlEnter(event, 'add');" placeholder="{$alang_xsds}"></textarea>
				</div>
                <div class="bton">
					<button type="submit" name="add" id="add" class="ainuo_nologin">{lang publish}</button>
                </div>
                <div class="qianm cl" id="qianm" style="display:none;">
                	<!--{if $_G['group']['maxsigsize']}-->
					<label for="to_sign"><input type="checkbox" name="to_signhtml" id="to_sign" class="pc" value="1" />{lang doing_update_personal_signature}</label>
					<!--{/if}-->
                </div>

				<div id="return_doing" class="xi1 xw1"></div>
        </div>
        <div id="ainuo_facemenu"></div>
		<input type="hidden" name="addsubmit" value="true" />
		<input type="hidden" name="refer" value="$theurl" />
		<input type="hidden" name="topicid" value="$topicid" />
		<input type="hidden" name="formhash" value="{FORMHASH}" />
	</form>
<!--{/if}-->