var crimp = ''; 
var loading= "./source/plugin/mxi_aplay/template/image/loading.gif";

(function($) {
    $(document).ready(function() {
        var uid = 0;
        var aid = 0;
        var nextObj;
        var alreadyAid = false;
        $('.mp3PlayIcon .play-item').click(function() {
            var _this = $(this);
            tid = _this.attr('tid');
            uid = _this.attr('uid');
            if (!alreadyAid) {
                aid = _this.attr('aid');
            } else {
                alreadyAid = false;
            }
            //
            var crimpObj = $('.mp3PlayIcon a[aid="' + aid + '"]');
            $("#jp-progress").removeAttr('style');
           // $('.mp3date').html(_this.attr('date'));
            $('.mp3Title').html(_this.attr('title'));
            //add mp3 category
            $('.mp3Collect').attr('href', 'home.php?mod=spacecp&ac=favorite&type=thread&id=' + tid);
            $('.mp3Share').attr('href', 'home.php?mod=spacecp&ac=share&type=thread&id=' + tid);

				 
			 price =_this.attr('price');
			 if(price>0){
				$('.mp3Down').attr('href', 'forum.php?mod=misc&action=attachpay&aid=' + aid);
			}else{
				$('.mp3Down').attr('href', 'forum.php?mod=attachment&aid=' + _this.attr('packaid'));
			}
            //mp3 down
            // $('.mp3Down').attr('href', 'forum.php?mod=misc&action=attachpay&aid=' + aid);
		
            if (crimpObj.attr('crimp') == '1') {
                /*$("#jp-progress").removeAttr('style').css('background', 'url('+loading+')');				
                $.get('plugin.php?id=mxi_aplay&mod=waveform&aid=' + aid,function(data) {
					crimpObj.attr('crimp',data);
                    $("#jp-progress").removeAttr('style').css('background', 'url(' + data + ')');
					_this.trigger('click');
                })*/
            } else {
                 $("#jp-progress").css('background', 'url(' + crimpObj.attr('waveform') + ')');
            }

            //begin crimp
            nextObj = $('.playlist').find('.mp3PlayIcon a[aid="' + aid + '"]');
            $(".jp-play-bar").css('width', 0);
            $(".pause-item").hide();
            $(".play-item").show();

            $(this).parent().find('.pause-item').show();
            $(this).parent().find('.play-item').hide();            
            var mp3Url = crimpObj.attr('url');

            $("#jquery_jplayer").jPlayer("setMedia", { mp3: mp3Url});               
            
            $("#jquery_jplayer").jPlayer("play");

            $('.mp3ListItems').find('tr').removeClass('current').hide();
            $('.mp3ListItems').find('tr[tid="' + tid + '"]').show();
            $('.mp3ListItems').find('tr[aid="' + aid + '"]').addClass('current');
            if ($('.mp3ListItems').find('tr[tid="' + tid + '"]').length > 1) {
                $('.mp3List').show();
            } else {
                $('.mp3List,.mp3ListBox').hide();
            }

            $('#line').animate({
                bottom: '0'
				},
				1000, 'swing',
				 function() {
					if ($('.mp3ListItems').find('tr[tid="' + tid + '"]').length > 1) {
						$('.mp3ListBox').show();
					}
            });

            $('.mp3author').html($(this).parent().find('.avatar').html());

        });

        $("#jplay_play").bind('click',
        function() {
            if (uid == '') {
                $('.playlist').find('tbody .play-item').first().trigger('click');
            } else {
                $("#jquery_jplayer").jPlayer("play");
                $(".jp-pause_" + tid).show();
                $(".jp-play_" + tid).hide();
            }
        });

        $("#jplay_puase").bind('click',
        function() {
            if (uid) {
                $.jPlayer.pause();
                $(".jp-pause_" + tid).hide();
                $(".jp-play_" + tid).show();
            }
        });
 
        var playNext = function(obj) {
            //multi attachemnt next
            if (obj.next('.mp3next').length > 0) {

                nextObj = obj.next('.mp3next');
                aid = nextObj.attr('aid');
				price = nextObj.attr('price');
				 
                $('.mp3ListItems').find('tr').removeClass('current');
                $('.mp3ListItems').find('tr[aid="' + aid + '"]').addClass('current');
                crimp = nextObj.attr('url').replace(".mp3", ".png");

                if (nextObj.attr('crimp') == '1') {
                    $("#jp-progress").removeAttr('style');
                    $("#jp-progress").removeAttr('style').css('background', 'url('+loading+')');
                    $.get('plugin.php?id=mxi_aplay&mod=waveform&aid=' + aid,
                    function(data) {
                        $("#jp-progress").removeAttr('style').css('background', 'url(' + data + ')');
                    })
                } else {
                    $("#jp-progress").css('background', 'url(' + crimp + ')');
                }
                $("#jquery_jplayer").jPlayer("setMedia", {
                    mp3:  nextObj.attr('url')//.substr(1)
                });
                $("#jquery_jplayer").jPlayer("play");
                //mp3 down
				 
				//if(_this.attr('price')>0){
				//	$('.mp3Down').attr('href', 'forum.php?mod=misc&action=attachpay&aid=' + aid);
				//}else{
				//	$('.mp3Down').attr('href', 'forum.php?mod=attachment&aid=' + _this.attr('packaid'));
				//}
			
                $('.mp3Down').attr('href', 'forum.php?mod=misc&action=attachpay&aid=' + aid);
            } else {
                //body next
                var next = obj.parents('tbody').next().find('.play-item');
                if (next.length > 0) {
                    next.trigger('click');
                } else {
                    if (obj.parents('tbody').next().length == 0) {
                        $('.playlist').find('tbody .play-item').first().trigger('click');
                    } else {
                        playNext(next);
                    }
                }
            }
        };

        //初始化
        $("#jquery_jplayer").jPlayer({
            solution: "flash, html",
            swfPath: SITEURL + mxi_aplay_DIR + "jplayer/",
            volume: 0.5,
            supplied: "mp3,m4a",
            wmode: "window",
            cssSelectorAncestor: "#jp_container",
            cssSelector: {
                duration: '.jp-duration',
                seekBar: '.jp-seek-bar',
                playBar: '.jp-play-bar',
                play: '.jp-play',
                pause: '.jp-pause',
                mute: '.jp-mute',
                unmute: '.jp-unmute',
				volumeBar: '.jp-volume-bar',
            },
            //errorAlerts:true,
            ended: function() {
                playNext(nextObj);
            }
        });

        $('.mp3PlayIcon .pause-item').click(function() {
            $.jPlayer.pause();
            $('#line').animate({
                bottom: '-60px'
            },
            1000);
            $(".pause-item").hide();
            $(".play-item").show();
            $('.mp3ListBox').hide();
        });

        //列表
        $('.mp3List').click(function() {
            $('.mp3ListBox').toggle();
        });

        $('.mp3ListItems tr').click(function() {
            alreadyAid = true;
            aid = $(this).attr('aid');
			_this = $(this);
            nextObj = $('.playlist').find('.mp3PlayIcon a[aid="' + aid + '"]');
            $('.mp3ListItems').find('tr').removeClass('current');
			 
            $(this).addClass('current');
			price = _this.attr('price');
			var trigger =  $('.playlist').find('.mp3PlayIcon .play-item[tid="' + $(this).attr('tid') + '"]');
			 
			trigger.attr('price',price);trigger.attr('packaid',_this.attr('packaid'));
			 
            $('.playlist').find('.mp3PlayIcon .play-item[tid="' + $(this).attr('tid') + '"]').trigger('click');
            return false;
        });

        $('.mp3ListItems .icon_close').click(function() {
            $('.mp3ListBox').hide();
        });

    });
})(jQuery);

function drawImage(mp3Name) {
    document.getElementById('jp-progress').style.background = 'url(' + crimp + ')';
}

//end
