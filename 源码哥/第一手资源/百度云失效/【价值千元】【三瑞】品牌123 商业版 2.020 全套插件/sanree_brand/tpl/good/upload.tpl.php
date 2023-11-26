<?php (!defined('IN_SANREE')&&exit('Power By ymg6.Com'))?>
<!--{template common/header}-->
<div class="upfile">
	<h3 class="flb">
		<em id="return_upload">{lang upload}</em>
		<em id="uploadwindowing" class="mtn" style="visibility:hidden"><img src="{IMGDIR}/uploading.gif" alt="" /></em>
		<span><a href="javascript:;" class="flbc" onclick="hideWindow('upload', 0)" title="{lang close}">{lang close}</a></span>
	</h3>
	<div class="c">
		<form id="uploadform" class="uploadform ptm pbm" method="post" autocomplete="off" target="uploadattachframe" onsubmit="uploadWindowstart()" action="plugin.php?id=sanree_brand&mod=swfupload&operation=upload&inajax=yes&infloat=yes&simple=2" enctype="multipart/form-data">
			<input type="hidden" name="handlekey" value="upload" />
			<input type="hidden" name="uid" value="$_G['uid']">
			<input type="hidden" name="hash" value="{echo md5(substr(md5($_G['config']['security']['authkey']), 8).$_G['uid'])}">
			<div class="filebtn">
				<input type="file" name="Filedata" id="filedata" class="pf cur1" size="1" onchange="$('uploadform').submit()" />
				<button type="button" class="pn pnc"><strong>{lang sanree_brand:upload_selectfile}</strong></button>
			</div>
		</form>
		<p class="xg1 mtn">
			{lang sanree_brand:attachment_allow_exts}: <span class="xi1">$imgexts</span>
			<!--{if $_G['sr_type']=='backimage'}-->
			<span class="xi1">{lang sanree_brand:upload_backimagetip}</span>			
			<!--{elseif $_G['sr_type']=='wximage'}-->
			<span class="xi1">{lang sanree_brand:upload_wximagetip}</span>
			<!--{elseif $_G['sr_type']=='image'}-->
			{$logowh}
			<!--{elseif $_G['sr_w']&&$_G['sr_h']}-->
			{$input_imagetip}
			<!--{elseif $_G['sr_type']=='wezgimg'}-->
			<span class="xi1">{lang sanree_brand:upload_wezgimgtip}</span>
			<!--{else}-->
			<span class="xi1">{lang sanree_brand:input_image}</span>
			<!--{/if}-->
		</p>
		<iframe name="uploadattachframe" id="uploadattachframe" style="display: none;" onload="uploadWindowload();"></iframe>
	</div>
</div>

<!--{template common/footer}-->