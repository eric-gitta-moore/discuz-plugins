<?PHP exit('QQÈº£º550494646');?>

<!--{if ($_GET[mod] != 'post') && ($_G['basescript'] != 'member') && ($_G['basescript'] != 'register')}-->
<a class="ainuo_right_more" id="ainuo_right_more"><i class="iconfont icon-more"></i></a>
<!--{/if}-->
<div class="ainuo_quick_bot" id="ainuo_quick_bot">
	<!--{if $_G['uid'] && getstatus($_G['member']['allowadmincp'], 1)}-->
        <!--{if ($_GET[forumlist] == 1) || ($_GET[mod] == 'guide') || ($_GET[mod] == 'topic')}-->
            <a href="javascript:;" onclick="openDiy()" class="ascrolldiy">DIY</a>
        <!--{/if}-->
    <!--{/if}-->
    
    <!--{if ($_G['basescript'] == 'group') && ($_G['mod'] != 'group') && ($_G['mod'] != 'viewthread')}-->
		<a href="forum.php?mod=group&action=create" class="ainuo_quick_post"><i class="iconfont icon-add1"></i></a>
    <!--{/if}-->
    
	<!--{if ($_GET[mod] == 'forumdisplay') || ($_GET[mod] == 'viewthread') || ($_GET[mod] == 'group')}-->
		<a href="forum.php?mod=post&action=newthread&fid=$_G[fid]" class="ainuo_quick_post"><i class="iconfont icon-post"></i></a>
    <!--{/if}-->
    
    <!--{if ($_GET[forumlist] != 1) && ($_GET[mod] != 'guide') && ($_GET[mod] != 'post') && ($_GET[mod] != 'topic')}-->
		<a href="javascript:;" id="ainuo_toggle_menu" class="ainuo_quick_menu"><i class="iconfont icon-menu1"></i></a>
    <!--{/if}-->

    <!--{if ($_GET[mod] != 'post') && ($_G['basescript'] != 'group')}-->
		<a href="javascript:;" onclick="location.reload();" class="ainuo_quick_menu"><i class="iconfont icon-refresh"></i></a>
    <!--{/if}-->
    <!--{if ($_GET[forumlist] != 1)}-->
		<a href="javascript:;" id="ainuo_toggle_top" class="ainuo_quick_menu"><i class="iconfont icon-top"></i></a>
    <!--{/if}-->
</div>


<script>
$('.ainuo_nologin').on('click', function() {
	<!--{if !$_G[uid]}-->
		popup.open('{lang nologin_tip}', 'confirm', 'member.php?mod=logging&action=login');
		return false;
	<!--{/if}-->
});
</script>


<script src="template/qu_app/touch/style/avatar/js/modify.js"></script>
<script>
need_rotate = 0;
var photoClip = $("#canvas_area").photoClip({
	width:200,
	height:200,
	file: "#file",
	view: "#canvas_view",
	ok: "#finish",
	loadStart: function () {
		$('.canvas_lazy_tip span').text('');
		$('.canvas_lazy_cover,.canvas_lazy_tip').show();

		oFile = file.files['0'];
		//EXIF.getData(oFile, function() {
		//	EXIF.getAllTags(this);
		//	var orientation = EXIF.getTag(this,'Orientation');
		//	if (orientation>1) { need_rotate = 1; }
		//});
	},
	loadComplete: function () {
		if (need_rotate) {
			oFile = file.files['0'];
			var resImg = document.getElementById('canvas_preview');
			var mpImg = new MegaPixImage(oFile,canvasToImage);
				mpImg.render(resImg,{
				orientation: orientation,
				quality: 1
			});
		}else{
			canvasShow();
		}
	},
	clipFinish: function (dataURL) {
		uploadImage(dataURL);
	}

});
</script>

