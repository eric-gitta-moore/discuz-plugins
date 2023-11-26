var specialLib = {
	passDelInit: function() {
		$(".delete").click(function() {
			var did = $(this).attr("did");
			$.dialog({
				id: 'delDance',
				title: false,
				border: false,
				follow: $(this)[0],
				content: '确认要删除这张专辑么？',
				okValue: '确认',
				ok: function() {
					$.getJSON(zone_domain + "index.php?p=special&a=doShareDel&callback=?", "did=" + did,
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
	songSetInit: function() {
		$(".set").click(function() {
			var sid = $(this).attr("sid");
			window.open(zone_domain + "index.php?p=special&a=song&id=" + sid, '_blank');
		});
	},
	shareAddInit: function() {
		var $specialAddMain = $('#specialAddMain');
		var $rspecialName = $('#rspecialName');
		var $mspecialName = $('#mspecialName');
		var $rSingerID = $('#rSingerID');
		var $mSingerID = $('#mSingerID');
		var $rGongSi = $('#rGongSi');
		var $mGongSi = $('#mGongSi');
		var $rclassId = $('#rclassId');
		var $mclassId = $('#mclassId');
		var $rYuYan = $('#rYuYan');
		var $mYuYan = $('#mYuYan');
		var $rPic = $('#rPic');
		var $mPic = $('#mPic');
		var $rIntro = $('#rIntro');
		var $specialNewAdd = $('#specialNewAdd');
		$rspecialName.focus(function() {
			$(this).addClass('input_focus');
			$mspecialName.removeClass('input_tag2');
			$mspecialName.addClass('input_tag1');
			$mspecialName.html('作为专辑名称请您认真填写，合理的名称审核才会通过。');
		}).blur(function() {
			$(this).removeClass('input_focus');
			$(this).triggerHandler('keyup');
		}).keyup(function() {
			if ($(this).val() == '') {
				$mspecialName.removeClass('input_tag1');
				$mspecialName.addClass('input_tag2');
				$mspecialName.html('<span class="errIcon"></span>专辑名称不能为空！');
				return false;
			} else {
				$mspecialName.removeClass('input_tag1');
				$mspecialName.removeClass('input_tag2');
				$mspecialName.html('<span class="rightIcon"></span>');
			}
		});
		$rSingerID.focus(function() {
			$(this).addClass('select_focus');
			$mSingerID.removeClass('input_tag2');
			$mSingerID.addClass('input_tag1');
			$mSingerID.html('专辑的所属歌手，请选择加入一个。');
		}).blur(function() {
			$(this).removeClass('select_focus');
			$(this).triggerHandler('change');
		}).change(function(event) {
			if ($(this).val() == '') {
				$mSingerID.removeClass('input_tag1');
				$mSingerID.addClass('input_tag2');
				$mSingerID.html('<span class="errIcon"></span>请选择专辑的所属歌手！');
				return false;
			} else {
				$mSingerID.removeClass('input_tag1');
				$mSingerID.removeClass('input_tag2');
				$mSingerID.html('<span class="rightIcon"></span>');
			}
		});
		$rGongSi.focus(function() {
			$(this).addClass('input_focus');
			$mGongSi.removeClass('input_tag2');
			$mGongSi.addClass('input_tag1');
			$mGongSi.html('专辑的发行公司，请正确选择。');
		}).blur(function() {
			$(this).removeClass('input_focus');
			$(this).triggerHandler('keyup');
		}).keyup(function() {
			if ($(this).val() == '') {
				$mGongSi.removeClass('input_tag1');
				$mGongSi.addClass('input_tag2');
				$mGongSi.html('<span class="errIcon"></span>发行公司不能为空！');
				return false;
			} else {
				$mGongSi.removeClass('input_tag1');
				$mGongSi.removeClass('input_tag2');
				$mGongSi.html('<span class="rightIcon"></span>');
			}
		});
		$rclassId.focus(function() {
			$(this).addClass('select_focus');
			$mclassId.removeClass('input_tag2');
			$mclassId.addClass('input_tag1');
			$mclassId.html('专辑的所属分类，请正确选择。');
		}).blur(function() {
			$(this).removeClass('select_focus');
			$(this).triggerHandler('change');
		}).change(function(event) {
			if ($(this).val() == '0') {
				$mclassId.removeClass('input_tag1');
				$mclassId.addClass('input_tag2');
				$mclassId.html('<span class="errIcon"></span>请选择专辑的所属分类！');
				return false;
			} else {
				$mclassId.removeClass('input_tag1');
				$mclassId.removeClass('input_tag2');
				$mclassId.html('<span class="rightIcon"></span>');
			}
		});
		$rYuYan.focus(function() {
			$(this).addClass('select_focus');
			$mYuYan.removeClass('input_tag2');
			$mYuYan.addClass('input_tag1');
			$mYuYan.html('专辑的所属语言，请正确选择。');
		}).blur(function() {
			$(this).removeClass('select_focus');
			$(this).triggerHandler('change');
		}).change(function(event) {
			if ($(this).val() == '') {
				$mYuYan.removeClass('input_tag1');
				$mYuYan.addClass('input_tag2');
				$mYuYan.html('<span class="errIcon"></span>请选择专辑的所属语言！');
				return false;
			} else {
				$mYuYan.removeClass('input_tag1');
				$mYuYan.removeClass('input_tag2');
				$mYuYan.html('<span class="rightIcon"></span>');
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
		$specialNewAdd.click(function() {
			$("#specialAddMain :input").trigger('keyup');
			$rSingerID.triggerHandler('change');
			$rclassId.triggerHandler('change');
			$rYuYan.triggerHandler('change');
			var numError = $('#specialAddMain .errIcon').length;
			if (!numError) {
				$.ajax({
					type: "POST",
					global: false,
					url: zone_domain + "index.php?p=special&a=doShare",
					data: {
						SpecialName: escape($rspecialName.val()),
						SingerID: $rSingerID.val(),
						GongSi: escape($rGongSi.val()),
						classId: $rclassId.val(),
						YuYan: escape($rYuYan.val()),
						Pic: escape($rPic.val()),
						Intro: escape($rIntro.val().replace(/[\r\n]/g, "<br>"))
					},
					dataType: "text",
					success: function(data) {
						if (data == 1001) {
							libs.userNotLogin('您需要先登录才能进行此操作!');
						} else {
							$.tipMessage('专辑制作成功，请等待审核！', 0, 3000, 0,
							function() {
							        location.href = zone_domain + "index.php?p=special&a=pass&classId=" + $rclassId.val()
							});
						}
					}
				});
			}
		});
	}
}