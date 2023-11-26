var singerLib = {
	passDelInit: function() {
		$(".delete").click(function() {
			var did = $(this).attr("did");
			$.dialog({
				id: 'delDance',
				title: false,
				border: false,
				follow: $(this)[0],
				content: '确认要删除这位歌手么？',
				okValue: '确认',
				ok: function() {
					$.getJSON(zone_domain + "index.php?p=singer&a=doShareDel&callback=?", "did=" + did,
					function(data) {
						if (data['error'] == 20001) {
							libs.userNotLogin('您需要先登录才能进行此操作!');
							return false;
						} else {
							$.tipMessage("操作执行成功", 0, 1500, 0,
							function() {
								location.href = location.href;
							});
						}
					});
				},
				cancelValue: '取消',
				cancel: function() {}
			});
		});
	},
	shareAddInit: function() {
		var $singerAddMain = $('#singerAddMain');
		var $rsingerName = $('#rsingerName');
		var $msingerName = $('#msingerName');
		var $rArea = $('#rArea');
		var $mArea = $('#mArea');
		var $rPic = $('#rPic');
		var $mPic = $('#mPic');
		var $rIntro = $('#rIntro');
		var $singerNewAdd = $('#singerNewAdd');
		$rsingerName.focus(function() {
			$(this).addClass('input_focus');
			$msingerName.removeClass('input_tag2');
			$msingerName.addClass('input_tag1');
			$msingerName.html('作为歌手名称请您认真填写，合理的名称审核才会通过。');
		}).blur(function() {
			$(this).removeClass('input_focus');
			$(this).triggerHandler('keyup');
		}).keyup(function() {
			if ($(this).val() == '') {
				$msingerName.removeClass('input_tag1');
				$msingerName.addClass('input_tag2');
				$msingerName.html('<span class="errIcon"></span>歌手名称不能为空！');
				return false;
			} else {
				$msingerName.removeClass('input_tag1');
				$msingerName.removeClass('input_tag2');
				$msingerName.html('<span class="rightIcon"></span>');
			}
		});
		$rArea.focus(function() {
			$(this).addClass('select_focus');
			$mArea.removeClass('input_tag2');
			$mArea.addClass('input_tag1');
			$mArea.html('歌手的所属分类，请正确选择。');
		}).blur(function() {
			$(this).removeClass('select_focus');
			$(this).triggerHandler('change');
		}).change(function(event) {
			if ($(this).val() == '') {
				$mArea.removeClass('input_tag1');
				$mArea.addClass('input_tag2');
				$mArea.html('<span class="errIcon"></span>请选择歌手的所属分类！');
				return false;
			} else {
				$mArea.removeClass('input_tag1');
				$mArea.removeClass('input_tag2');
				$mArea.html('<span class="rightIcon"></span>');
			}
		});
		$rPic.focus(function() {
			$(this).addClass('input_focus');
			$mPic.removeClass('input_tag2');
			$mPic.addClass('input_tag1');
			$mPic.html('<span class="errIcon"></span>');
		}).blur(function() {
			$(this).removeClass('input_focus');
			$(this).triggerHandler('keyup');
		}).keyup(function() {
			if ($(this).val() == '') {
				$mPic.removeClass('input_tag1');
				$mPic.addClass('input_tag2');
				$mPic.html('<span class="errIcon"></span>');
				return false;
			} else {
				$mPic.removeClass('input_tag1');
				$mPic.removeClass('input_tag2');
				$mPic.html('<span class="rightIcon"></span>');
			}
		});
		$singerNewAdd.click(function() {
			$("#singerAddMain :input").trigger('keyup');
			$rArea.triggerHandler('change');
			var numError = $('#singerAddMain .errIcon').length;
			if (!numError) {
				$.ajax({
					type: "POST",
					global: false,
					url: zone_domain + "index.php?p=singer&a=doShare",
					data: {
						singerName: escape($rsingerName.val()),
						Area: escape($rArea.val()),
						Pic: escape($rPic.val()),
						Intro: escape($rIntro.val().replace(/[\r\n]/g, "<br>"))
					},
					dataType: "text",
					success: function(data) {
						if (data == 1001) {
							libs.userNotLogin('您需要先登录才能进行此操作!');
						} else {
							$.tipMessage('歌手创建成功，请等待审核！', 0, 3000, 0,
							function() {
							        location.href = zone_domain + "index.php?p=singer&a=pass&classId=" + $rArea.val()
							});
						}
					}
				});
			}
		});
	}
}