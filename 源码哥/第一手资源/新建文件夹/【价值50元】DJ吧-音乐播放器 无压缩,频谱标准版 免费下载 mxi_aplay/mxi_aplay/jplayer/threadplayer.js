var crimp = '';
var loading= "./source/plugin/mxi_aplay/template/image/loading.gif";
(function($){
    $(document).ready(function(){
        var aid = '';
        var nextObj;

        //js控制mp3列表
        if($('.play-item').length>1){
            $('.mp3List').show();
            var mp3list = "";
            $('.play-item').each(function(){
                mp3list += '<tr aid="'+$(this).attr('aid')+'"><td>'+$(this).attr('title')+'</td><td>'+$('.mp3Category').text()+'</td><td><span class="mp3_down"></span><span class="mp3_collect"></span><span class="mp3_share"></span></td></tr>';
            });
            $('.mp3ListBox table').html(mp3list);
        }else{
            $('.mp3List,.mp3ListBox').hide();
        }

        $('.play-item').click(function(){
            var _this = $(this);
            aid = _this.attr('aid');
            $('#line').animate({bottom: '0'}, 1000, 'swing', function(){
                if($('.mp3List').is(':visible')){
                    $('.mp3ListBox').show();
                }
            });

            $("#jp-progress").removeAttr('style');
            crimp = _this.attr('crimp').replace(".mp3", ".png");
			 crimp = _this.attr('crimp');//
			 aid = _this.attr('aid');//
            if(_this.attr('crimp')=='1'){
				/*$("#jp-progress").removeAttr('style').css('background','url('+loading+')');
				$.get('plugin.php?id=mxi_aplay&mod=waveform&aid='+aid,function(data){					
					$("#jp-progress").removeAttr('style').css('background','url('+data+')');
					_this.attr('crimp')=data;
				 	_this.trigger('click');
				})*/
                
             }else{
                $("#jp-progress").removeAttr('style').css('background','url('+crimp+')');
            }

            nextObj = $('.jp-play_'+aid);
            $(".jp-play-bar").css('width',0);
            $(".pause-item").hide();
            $(".play-item").show();
            _this.prev().show();
            _this.hide();
 
            $("#jquery_jplayer").jPlayer("setMedia", {mp3:_this.attr('url')});
            $("#jquery_jplayer").jPlayer("play");

            $('.mp3ListItems').find('tr').removeClass('current');
            $('.mp3ListItems').find('tr[aid="'+aid+'"]').addClass('current');

            if(_this.attr('price')>0){
				$('.mp3Down').attr('href', 'forum.php?mod=misc&action=attachpay&aid=' + aid);
			}else{
				$('.mp3Down').attr('href', 'forum.php?mod=attachment&aid=' + _this.attr('packaid'));
			}
			
            return false;
        });

        $("#jplay_play").bind('click',function(){
            if(aid==''){
                $('.play-item').first().trigger('click');
            }else{
                $("#jquery_jplayer").jPlayer("play");
                $(".jp-pause_"+aid).show();
                $(".jp-play_"+aid).hide();
            }
        });

        $("#jplay_puase").bind('click',function(){
            if(aid){
                $.jPlayer.pause();
                $(".jp-pause_"+aid).hide();
                $(".jp-play_"+aid).show();
            }
        });

        var playNext = function(obj){
            //body next
            var next = obj.parents('ignore_js_op').next().find('.play-item');
            if(obj.parents('ignore_js_op').next().length>0){
                next.trigger('click');
            }else{
                if(obj.parents('ignore_js_op').next().length==0){
                    $('.play-item').first().trigger('click');
                }else{
                    playNext(next);
                }
            }
        };


        //初始化		
        $("#jquery_jplayer").jPlayer({
            solution: "flash, html",
            swfPath: SITEURL+mxi_aplay_DIR+"jplayer/",
            volume: 0.5,
            supplied: "mp3,m4a",
            wmode: "window",
            cssSelectorAncestor: "#jp_container",
            cssSelector:{
                duration: '.jp-duration',
                seekBar:'.jp-seek-bar',
                playBar:'.jp-play-bar',
                play: '.jp-play',
                pause: '.jp-pause',
                mute: '.jp-mute',
                unmute: '.jp-unmute',volumeBar: '.jp-volume-bar',
            },
            //errorAlerts:true,
            ended:function(){
                playNext(nextObj);
            }
        });

        $('.pause-item').click(function(){
            $.jPlayer.pause();
            $('#line').animate({bottom: '-60px'}, 1000);
            $(".pause-item").hide();
            $(".play-item").show();
            $('.mp3ListBox').hide();
            return false;
        });

        //收藏
        $('.mp3Collect').click(function(){
            $('#k_favorite').trigger('click');
        });

        //分享
        $('.mp3Share').click(function(){
            $('#k_share').trigger('click');
        });

        //列表
        $('.mp3List').click(function(){
            $('.mp3ListBox').toggle();
        });

        $('.mp3ListItems tr').click(function(){
            $('.mp3ListItems').find('tr').removeClass('current');
            $(this).addClass('current');
            $('.jp-play_'+$(this).attr('aid')).trigger('click');
            return false;
        });

        $('.mp3ListItems .icon_close').click(function(){
            $('.mp3ListBox').hide();
        });

    });
})(jQuery);

function drawImage(mp3Name){
    document.getElementById('jp-progress').style.background = 'url('+crimp+')';
}

//end