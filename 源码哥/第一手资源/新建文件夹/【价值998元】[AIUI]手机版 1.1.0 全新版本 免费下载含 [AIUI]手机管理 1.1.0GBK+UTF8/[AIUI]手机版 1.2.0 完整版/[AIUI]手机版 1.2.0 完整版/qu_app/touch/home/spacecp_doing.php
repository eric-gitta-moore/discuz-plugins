<?PHP exit('QQÈº£º550494646');?>
<!--{template common/header}-->

<!--{if $_GET['op'] == 'delete'}-->
    <div class="ainuo_pop cl">
    	<div class="atit cl">{lang delete_log}</div>
	<form method="post" autocomplete="off" id="doingform_{$doid}_{$id}" name="doingform" action="home.php?mod=spacecp&ac=doing&op=delete&doid=$doid&id=$id">
		<!--{if $_G[inajax]}--><input type="hidden" name="handlekey" value="$_GET[handlekey]" /><!--{/if}-->
		<input type="hidden" name="referer" value="{echo dreferer()}" />
		<input type="hidden" name="formhash" value="{FORMHASH}" />
		<div class="acon cl">{lang determine_delete_doing}</div>
        <div class="ainuo_popbottom cl">
            <button name="deletesubmit" type="submit" class="aconfirm" value="true">{lang determine}</button>
            <a href="javascript:;" onclick="popup.close()" class="acancel">{lang cancel}</a>
        </div>
	</form>
    </div>
<!--{elseif $_GET['op'] == 'spacenote'}-->
	<!--{if $space[spacenote]}-->$space[spacenote]<!--{/if}-->
<!--{elseif $_GET['op'] == 'docomment' || $_GET['op'] == 'getcomment'}-->
	<!--{if helper_access::check_module('doing')}-->
    <div class="ainuo_pop cl">
        <div id="{$_GET[key]}_form_{$doid}_{$id}">
            <form id="{$_GET[key]}_docommform_{$doid}_{$id}" method="post" autocomplete="off" action="home.php?mod=spacecp&ac=doing&op=comment&doid=$doid&id=$id" {if $_G[inajax]}onsubmit="ajaxpost(this.id, 'return_$_GET[handlekey]');"{/if}>
                <div class="acon cl">
                    <textarea name="message" id="{$_GET[key]}_form_{$doid}_{$id}_t" rows="3" class="px" oninput="resizeTx(this);" onpropertychange="resizeTx(this);" onkeyup="strLenCalc(this, '{$_GET[key]}_form_{$doid}_{$id}_limit')" onkeydown="ctrlEnter(event, '{$_GET[key]}_replybtn_{$doid}_{$id}');"></textarea>
                    <input type="hidden" name="commentsubmit" value="true" />
                </div>
                <div class="ainuo_popbottom cl">
                    <button type="submit" name="do_button" id="{$_GET[key]}_replybtn_{$doid}_{$id}" class="aconfirm formdialog" value="true"><em>{lang reply}</em></button>
                    <a href="javascript:;" onclick="popup.close()" class="acancel">{lang cancel}</a>
                </div>
                
                <!--{if $_G[inajax]}--><input type="hidden" name="handlekey" value="$_GET[handlekey]" /><!--{/if}-->
                <input type="hidden" name="formhash" value="{FORMHASH}" />
            
            </form>
            <span id="return_$_GET[handlekey]"></span>
        </div>
    </div>
	<script type="text/javascript">
		function succeedhandle_$_GET[handlekey](url, msg, values) {
			docomment_get(values['doid'], '$_GET[key]');
		}
	</script>
	<!--{/if}-->
	<!--{if $_GET['op'] == 'getcomment'}-->
		<!--{template home/space_doing_li}-->
	<!--{/if}-->

<!--{else}-->

<div id="content">
	<!--{if helper_access::check_module('doing')}-->
	<!--{template home/space_doing_form}-->
	<!--{/if}-->
</div>

<!--{/if}-->

<!--{template common/footer}-->