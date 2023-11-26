<?PHP exit('QQÈº£º550494646');?>

<div class="ainuo_postvideolink cl" id="ainuo_postvideolink">
    <div class="ainuo_postvideolink_con">
        <div class="acon cl">
            <textarea class="apx" id="ainuo_linkdz" name="ainuo_linkdz" placeholder="$nh_post_va5"></textarea>
        </div>
        <div class="tipnews cl">$nh_post_va3</div>
        <div class="tijiao cl">
            <a href="javascript:;" onclick="addilink('[media]'+document.getElementById('ainuo_linkdz').value+'[/media]')" id="tijiao">{lang submit}</a>
            <a href="javascript:;" id="quxiao" class="canceluplink">{lang cancel}</a>
        </div>
    </div>
</div>

<script>
function addilink(aid) {
	if(aid =="[media][/media]"){
		Zepto.toast('$alang_not_empty',1500,'toast');
		return;
	}
	Zepto.toast('$alang_cz_success',1500,'toast');
	$('.ainuo_postvideolink').removeClass('is-visible');
	seditor_insertunit('need', aid);
	
}
</script>