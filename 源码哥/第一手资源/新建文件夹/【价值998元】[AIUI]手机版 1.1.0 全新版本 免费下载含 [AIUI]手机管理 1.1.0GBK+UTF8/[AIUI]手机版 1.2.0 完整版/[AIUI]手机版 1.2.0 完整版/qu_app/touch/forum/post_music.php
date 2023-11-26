<?PHP exit('QQÈº£º550494646');?>

<div class="ainuo_postmusic cl" id="ainuo_postmusic">
    <div class="ainuo_postmusic_con">
        <div class="acon cl">
            <textarea class="apx" id="ainuo_musicdz" name="ainuo_musicdz" placeholder="$nh_post_va51"></textarea>
        </div>
        <div class="tipnews cl">$nh_post_va31</div>
        <div class="tijiao cl">
            <a href="javascript:;" onclick="addiaudio('[audio]'+document.getElementById('ainuo_musicdz').value+'[/audio]')" id="tijiao">{lang submit}</a>
            <a href="javascript:;" id="quxiao" class="cancelupmusic">{lang cancel}</a>
        </div>
    </div>
</div>

<script>
function addiaudio(aid) {
	if(aid =="[audio][/audio]"){
		Zepto.toast('$alang_not_empty',1500,'toast');
		return;
	}
	Zepto.toast('$alang_cz_success',1500,'toast');
	$('.ainuo_postmusic').removeClass('is-visible');
	seditor_insertunit('need', aid);
	
}
</script>
 