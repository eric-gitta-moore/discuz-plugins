$(document).on('tap','.head_portrait', function() {
    $('#file').click();
});

need_rotate = 0;

var photoClip=$("#canvas_area").photoClip({

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
    $.ajax({
        type:'POST',
        url:jsvar['appurl']+'&m=avatar',
        data:{image_file:img_data,formhash:jsvar['formhash']},
        dataType: 'JSON',
        beforeSend: function(XMLHttpRequest){
            $('.canvas_lazy_cover,.canvas_lazy_tip').show();
        }, success:function(data) {
         if (data.status) {
             $('header img').attr('src',img_data);
             $('#canvas_fullscreen,.canvas_lazy_cover,.canvas_lazy_tip').hide();
             $('html,body').removeClass('hidden');
        }
        }, error:function(){
            alert('error');
        }
        });
}