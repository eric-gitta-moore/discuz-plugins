<div id="editGroup">
	<input type="text" maxlength="7" style="width:121px;" class="input_normal" id="modifyfgName" value="<?php echo unescape(SafeRequest("fgName","post")); ?>">
	<span class="button-main">
		<span>
			<button type="button" onclick="$call(function(){relation.followingGroupModify(<?php echo SafeRequest("fgid","post"); ?>)});" id="edit">±à¼­</button>
		</span>
	</span>
</div>