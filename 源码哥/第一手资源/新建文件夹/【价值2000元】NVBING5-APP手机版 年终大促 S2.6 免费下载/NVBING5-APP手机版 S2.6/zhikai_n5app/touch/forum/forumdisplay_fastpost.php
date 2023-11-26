<?php exit;?>
<div id="post_new"></div>
<script src="template/zhikai_n5app/js/jquery.emoticons.js" type="text/javascript"></script>
<div class="kshf_ztys cl">
	<form method="post" autocomplete="off" id="fastpostform" action="forum.php?mod=post&action=reply&fid=$_G[fid]&tid=$_G[tid]&extra=$_GET[extra]&replysubmit=yes&mobile=2">
	<input type="hidden" name="formhash" value="{FORMHASH}" /> 
		<div class="kshf_syk cl"><textarea value="{$n5app['lang']['sqkshfts']}" class="px" name="message" id="fastpostmessage"></textarea></li></div>
		<!--{if $secqaacheck || $seccodecheck}-->
			<style type="text/css">
			.n5sq_ftyzm {background:#fff;padding:5px;border-radius: 2px;height: 30px;line-height: 30px;}
			.n5sq_ftyzm .txt {width: 70%;background: #fff;border: 0;font-size: 15px;border-radius: 0;outline: none;-webkit-appearance: none;padding: 2px 0;line-height: 23px;}
			.n5sq_ftyzm img {height: 25px;float: right;}
			</style>
			<div class="kshf_yzm cl"><!--{subtemplate common/seccheck}--></div>
		<!--{/if}-->
		<div class="kshf_czan cl">
			<div class="hshf_hfan y cl">
			<!--{if $_G[forum_thread][special] == 5 && empty($firststand)}-->
				<select id="stand" name="stand" class="hshf_gdxz" >
					<option value="">{$n5app['lang']['sqkshfgd']}</option>
					<option value="0">{lang debate_neutral}</option>
					<option value="1">{lang debate_square}</option>
					<option value="2">{lang debate_opponent}</option>
				</select>
			<!--{/if}-->
				<input type="button" value="{lang reply}" class="pn" name="replysubmit" id="fastpostsubmit">
			</div>
			<div class="hshf_qtcz z cl">
				<a href="JavaScript:void(0)" id="message_face" class="qtcz_bqan"></a>
				<a href="forum.php?mod=post&action=reply&fid=$_G[fid]&tid=$_G[tid]&reppost=$_G[forum_firstpid]&page=$page" class="qtcz_tpan {if $_G['uid']}{else}n5app_wdlts{/if}"></a>
			</div>
		</div>
		<div id="kshf_bqzs" class="kshf_bqzs"></div>		<!--{hook/viewthread_fastpost_button_mobile}-->
    </form>
</div>
<script type="text/javascript">
	var jq = jQuery.noConflict(); 
    jq("#message_face").jqfaceedit({txtAreaObj:jq("#fastpostmessage"),containerObj:jq('#kshf_bqzs')});
</script>
<script type="text/javascript">
	(function() {
		var form = $('#fastpostform');
		<!--{if !$_G[uid] || $_G[uid] && !$allowpostreply}-->
		$('#fastpostmessage').on('focus', function() {
			<!--{if !$_G[uid]}-->
				popup.open('{lang nologin_tip}', 'confirm', 'member.php?mod=logging&action=login');
			<!--{else}-->
				popup.open('{lang nopostreply}', 'alert');
			<!--{/if}-->
			this.blur();
		});
		<!--{else}-->
		$('#fastpostmessage').on('focus', function() {
			var obj = $(this);
			if(obj.attr('color') == 'gray') {
				obj.attr('value', '');
				obj.removeClass('grey');
				obj.attr('color', 'black');
				$('#fastpostsubmitline').css('display', 'block');
			}
		})
		.on('blur', function() {
			var obj = $(this);
			if(obj.attr('value') == '') {
				obj.addClass('grey');
				obj.attr('value', '{lang send_reply_fast_tip}');
				obj.attr('color', 'gray');
			}
		});
		<!--{/if}-->
		$('#fastpostsubmit').on('click', function() {
			var msgobj = $('#fastpostmessage');
			if(msgobj.val() == '{lang send_reply_fast_tip}') {
				msgobj.attr('value', '');
			}
			$.ajax({
				type:'POST',
				url:form.attr('action') + '&handlekey=fastpost&loc=1&inajax=1',
				data:form.serialize(),
				dataType:'xml'
			})
			.success(function(s) {
				evalscript(s.lastChild.firstChild.nodeValue);
			})
			.error(function() {
				window.location.href = obj.attr('href');
				popup.close();
			});
			return false;
		});

		$('#replyid').on('click', function() {
			$(document).scrollTop($(document).height());
			$('#fastpostmessage')[0].focus();
		});

	})();

	function succeedhandle_fastpost(locationhref, message, param) {
		var pid = param['pid'];
		var tid = param['tid'];
		if(pid) {
			$.ajax({
				type:'POST',
				url:'login.ashx?name=" + escape(names)',
				dataType:'xml'
			})
			.success(function(s) {
				$('#post_new').append(s.lastChild.firstChild.nodeValue);
			})
			.error(function() {
				window.location.href = 'forum.php?mod=viewthread&tid=' + tid;
				popup.close();
			});
		} else {
			if(!message) {
				message = '{lang postreplyneedmod}';
			}
			popup.open(message, 'alert');
		}
		$('#fastpostmessage').attr('value', '');
		if(param['sechash']) {
			$('.seccodeimg').click();
		}
	}

	function errorhandle_fastpost(message, param) {
		popup.open(message, 'alert');
	}
</script>
