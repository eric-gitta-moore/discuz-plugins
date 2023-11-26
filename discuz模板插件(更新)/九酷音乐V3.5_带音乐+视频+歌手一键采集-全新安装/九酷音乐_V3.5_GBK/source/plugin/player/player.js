$(function() {
	$("#btnfold").click(function() {
		var tit = $(this).attr('title');
		if (tit == '点击收起') {
			$("#divplayer").animate({
				left: -540
			},
			{
				duration: 500
			});
			$(this).attr('title', '点击展开');
			if ($('#spansongnum1 span').html() > 0) {
				$('#divplayer').addClass("mini_version");
				$('#divplayer').addClass("m_player_folded");
				$('#divplayer').addClass("m_player_playing")
			} else {
				$('#divplayer').addClass("m_player_folded")
			}
			$('#divplayframe').hide();
			$('#divplayer').removeClass("mini_version")
		} else {
			$("#divplayer").animate({
				left: 0
			},
			{
				duration: 500
			});
			$('#divplayer').removeClass("m_player_folded");
			$('#divplayer').removeClass("m_player_playing");
			$(this).attr('title', '点击收起')
		}
	});
	$("#spansongnum1").click(function() {
		var shows = $('#divplayframe').css('display');
		if (shows == 'none') {
			$('#divplayframe').show();
			$('#divplayer').addClass("mini_version")
		} else {
			$('#divplayframe').hide();
			$('#divplayer').removeClass("mini_version")
		}
	});
	$("#btnclose").click(function() {
		$('#divplayframe').hide();
		$('#divplayer').removeClass("mini_version")
	});
	$("#btnlrc").click(function() {
		var shows = $('#player_lyrics_pannel').css('display');
		if (shows == 'none') {
			$('#player_lyrics_pannel').show()
		} else {
			$('#player_lyrics_pannel').hide()
		}
	});
	$("#closelrcpannel").click(function() {
		$('#player_lyrics_pannel').hide()
	});
	$("#jp-playlist-box li").live({
		"mouseover": function() {
			$(this).addClass("play_hover")
		},
		"mouseout": function() {
			$(this).removeClass("play_hover")
		}
	})
});