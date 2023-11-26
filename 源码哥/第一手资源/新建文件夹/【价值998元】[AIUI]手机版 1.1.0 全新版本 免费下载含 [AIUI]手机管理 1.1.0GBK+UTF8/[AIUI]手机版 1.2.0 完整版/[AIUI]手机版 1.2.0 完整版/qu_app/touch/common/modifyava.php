<?PHP exit('QQÈº£º550494646');?>
<style>
.ainuomodifiava{ margin:50px 20px 0 20px; text-align:center;}
.ainuomodifiava img{ width:80px; height:80px;}
</style>
<div class="ainuomodifiava cl">
	<div class="iava_con cl">
        <img src="{avatar($space[uid], big, true)}" />
    </div>
    <p>
    	<input type="file" id="file" accept="image/*">
        <a href="javascript:;">$alang_umodifyava</a>
    	<a href="#" class="back">$alang_wancheng</a>
    </p>
    
</div>
<link href="template/qu_app/touch/style/avatar/css/avatar.css?{VERHASH}" rel="stylesheet" type="text/css" media="all">
<script src="template/qu_app/touch/style/avatar/js/exif.js"></script>
<script src="template/qu_app/touch/style/avatar/js/MegaPixImage.js"></script>
<script src="template/qu_app/touch/style/avatar/js/hammer.js"></script>
<script src="template/qu_app/touch/style/avatar/js/iscroll-zoom.js"></script>
<script src="template/qu_app/touch/style/avatar/js/jquery.photoClip.js"></script>
<script>
var jsvar=[];
	jsvar['siteurl'] = '{$_G[siteurl]}';
	jsvar['appurl'] = 'plugin.php?id=qu_app';
	jsvar['avatar_big'] = '{$auser[avatar_big]}';
	jsvar['formhash'] = '{FORMHASH}';
</script>

<section id="reset_avatar">
    <div id="canvas_fullscreen" style="display: none;position:absolute;bottom:0px;left:0px; z-index:189;">
        <div class="header" style="z-index:199">
            <div class="nav">
                <a href="javascript:;" class="cancel z" onclick="$('#canvas_fullscreen').hide();$('html,body').removeClass('hidden');">{lang cancel}</a>
                <span class="name">$alang_umodifyava</span>
				<a id="finish" href="javascript:;" class="y" style="font-size:14px;">$alang_wancheng</a>
            </div>
        </div>

        <div id="canvas_content">

            <div class="canvas_edit">
                <div id="canvas_area"></div>
                <div class="canvas_opera" style="z-index:999;">
                    <button id="positive-rotate"><i class="iconfont icon-youxuanzhuan"></i></button>
                    <button id="inverse-rotate"><i class="iconfont icon-zuoxuanzhuan"></i></button>
                    <button id="reduction"><i class="iconfont icon-suoxiao"></i></button>
                    <button id="magnification"><i class="iconfont icon-fangda"></i></button>
                </div>
            </div>
            <img fileName="" id="canvas_view" class="hide">
            <canvas id="canvas_preview"></canvas>
        </div>

    </div>

    <div class="canvas_lazy_tip hide"><span>1%</span><div class="spinner"></div></div>
    <div class="canvas_lazy_cover hide"></div>

</section>

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
			EXIF.getData(oFile, function() {
				EXIF.getAllTags(this);
				var orientation = EXIF.getTag(this,'Orientation');
				if (orientation>1) { need_rotate = 1; }
			});
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

function canvasShow(){
    $('.canvas_lazy_cover,.canvas_lazy_tip').hide();
    $('#canvas_fullscreen').show();
    $('html,body').addClass("hidden");
}

function canvasToImage(base64){
    var imgData = base64 || document.getElementById('canvas_preview').toDataURL('image/jpeg',1);
    $('.photo-clip-rotateLayer img').attr('src',imgData);
    canvasShow();
}

function uploadImage(img_data) {
	Zepto('.page').append('<div class="ainuooverlay"><div class="preloader-indicator-overlay"></div><div class="preloader-indicator-modal"><span class="preloader preloader-white"></span></div></div>');
    $.ajax({
        type:'POST',
        url:jsvar['appurl']+'&m=avatar',
        data:{image_file:img_data,formhash:jsvar['formhash']},
        dataType: 'JSON',
        beforeSend: function(XMLHttpRequest){
            $('.canvas_lazy_cover,.canvas_lazy_tip').show();
        }, 
		success:function(data) {
			if(data.status) {
				 $('.img_left img').attr('src',img_data);
				 $('#canvas_fullscreen,.canvas_lazy_cover,.canvas_lazy_tip').hide();
				 $('html,body').removeClass('hidden');
				 Zepto('.ainuooverlay').remove();
				 Zepto.toast('$alang_cz_success',1500,'toast');
			}
        }, 
		error:function(){
            alert('$alang_pleasetye');
        }
	});
}
</script>