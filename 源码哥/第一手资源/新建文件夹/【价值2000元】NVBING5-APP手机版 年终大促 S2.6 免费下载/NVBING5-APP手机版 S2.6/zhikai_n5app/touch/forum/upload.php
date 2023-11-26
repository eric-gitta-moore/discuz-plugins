<?php exit;?>
<script type="text/javascript" src="template/zhikai_n5app/js/supload.js"></script>
<div class="n5sq_flct" id="upfilecoose">
	<h3 class="flb">
		<em id="return_upload">{lang upload}</em>
		<em id="uploadwindowing" class="mtn" style="visibility:hidden"><img src="{IMGDIR}/uploading.gif" alt="" /></em>
        <span><a href="javascript:;" class="flbcs" onclick="hideWindow('upfilecoose')" title="{lang close}">{lang close}</a></span>
	</h3>
	<div class="c">
		<form id="uploadform" class="uploadform ptm pbm" method="post" autocomplete="off" target="uploadattachframe" onsubmit="uploadWindowstart()" action="misc.php?mod=swfupload&operation=upload&type=$type&inajax=yes&infloat=yes&simple=2" enctype="multipart/form-data">
			<input type="hidden" name="handlekey" value="upload" />
			<input type="hidden" name="uid" value="$_G['uid']">
			<input type="hidden" name="hash" value="{echo md5(substr(md5($_G['config']['security']['authkey']), 8).$_G['uid'])}">
			<div class="filebtn">
				<input type="file" name="Filedata" id="filedata" class="pf cur1" size="1" onchange="Scratching('uploadform').submit()" />
			</div>
		</form>
		<p class="xg1 mtn">
			<!--{if $type == 'image'}-->{lang attachment_allow_exts}: <span class="xi1">$imgexts</span><!--{elseif $_G['group']['attachextensions']}-->{lang attachment_allow_exts}: <span class="xi1">{$_G['group']['attachextensions']}</span><!--{/if}-->
		</p>
		<iframe name="uploadattachframe" id="uploadattachframe" style="display: none;" onload="uploadWindowload();"></iframe>
	</div>
</div>