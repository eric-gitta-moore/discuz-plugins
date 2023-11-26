var videoLib = {
	passDelInit: function() {
		$(".delete").click(function() {
			var did = $(this).attr("did");
			$.dialog({
				id: 'delDance',
				title: false,
				border: false,
				follow: $(this)[0],
				content: 'ȷ��Ҫɾ�������Ƶô��',
				okValue: 'ȷ��',
				ok: function() {
					$.getJSON(zone_domain + "index.php?p=video&a=doShareDel&callback=?", "did=" + did,
					function(data) {
						if (data['error'] == 20001) {
							libs.userNotLogin('����Ҫ�ȵ�¼���ܽ��д˲���!');
							return false;
						} else {
							$.tipMessage("����ִ�гɹ�", 0, 1500, 0,
							function() {
								location.href = location.href;
							});
						}
					});
				},
				cancelValue: 'ȡ��',
				cancel: function() {}
			});
		});
	},
	shareAddInit: function() {
		var $videoAddMain = $('#videoAddMain');
		var $rvideoName = $('#rvideoName');
		var $mvideoName = $('#mvideoName');
		var $rSingerID = $('#rSingerID');
		var $mSingerID = $('#mSingerID');
		var $rclassId = $('#rclassId');
		var $mclassId = $('#mclassId');
		var $rPlay = $('#rPlay');
		var $mPlay = $('#mPlay');
		var $rPic = $('#rPic');
		var $mPic = $('#mPic');
		var $videoNewAdd = $('#videoNewAdd');
		$rvideoName.focus(function() {
			$(this).addClass('input_focus');
			$mvideoName.removeClass('input_tag2');
			$mvideoName.addClass('input_tag1');
			$mvideoName.html('��Ϊ��Ƶ��������������д�������������˲Ż�ͨ����');
		}).blur(function() {
			$(this).removeClass('input_focus');
			$(this).triggerHandler('keyup');
		}).keyup(function() {
			if ($(this).val() == '') {
				$mvideoName.removeClass('input_tag1');
				$mvideoName.addClass('input_tag2');
				$mvideoName.html('<span class="errIcon"></span>��Ƶ���Ʋ���Ϊ�գ�');
				return false;
			} else {
				$mvideoName.removeClass('input_tag1');
				$mvideoName.removeClass('input_tag2');
				$mvideoName.html('<span class="rightIcon"></span>');
			}
		});
		$rSingerID.focus(function() {
			$(this).addClass('select_focus');
			$mSingerID.removeClass('input_tag2');
			$mSingerID.addClass('input_tag1');
			$mSingerID.html('��Ƶ���������֣���ѡ�����һ����');
		}).blur(function() {
			$(this).removeClass('select_focus');
			$(this).triggerHandler('change');
		}).change(function(event) {
			if ($(this).val() == '') {
				$mSingerID.removeClass('input_tag1');
				$mSingerID.addClass('input_tag2');
				$mSingerID.html('<span class="errIcon"></span>��ѡ����Ƶ���������֣�');
				return false;
			} else {
				$mSingerID.removeClass('input_tag1');
				$mSingerID.removeClass('input_tag2');
				$mSingerID.html('<span class="rightIcon"></span>');
			}
		});
		$rclassId.focus(function() {
			$(this).addClass('select_focus');
			$mclassId.removeClass('input_tag2');
			$mclassId.addClass('input_tag1');
			$mclassId.html('��Ƶ���������࣬����ȷѡ��');
		}).blur(function() {
			$(this).removeClass('select_focus');
			$(this).triggerHandler('change');
		}).change(function(event) {
			if ($(this).val() == '0') {
				$mclassId.removeClass('input_tag1');
				$mclassId.addClass('input_tag2');
				$mclassId.html('<span class="errIcon"></span>��ѡ����Ƶ���������࣡');
				return false;
			} else {
				$mclassId.removeClass('input_tag1');
				$mclassId.removeClass('input_tag2');
				$mclassId.html('<span class="rightIcon"></span>');
			}
		});
		$rPlay.focus(function() {
			$(this).addClass('input_focus');
			$mPlay.removeClass('input_tag2');
			$mPlay.addClass('input_tag1');
			$mPlay.html('<span class="errIcon"></span>');
		}).blur(function() {
			$(this).removeClass('input_focus');
			$(this).triggerHandler('keyup');
		}).keyup(function() {
			if ($(this).val() == '') {
				$mPlay.removeClass('input_tag1');
				$mPlay.addClass('input_tag2');
				$mPlay.html('<span class="errIcon"></span>');
				return false;
			} else {
				$mPlay.removeClass('input_tag1');
				$mPlay.removeClass('input_tag2');
				$mPlay.html('<span class="rightIcon"></span>');
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
		$videoNewAdd.click(function() {
			$("#videoAddMain :input").trigger('keyup');
			$rSingerID.triggerHandler('change');
			$rclassId.triggerHandler('change');
			var numError = $('#videoAddMain .errIcon').length;
			if (!numError) {
				$.ajax({
					type: "POST",
					global: false,
					url: zone_domain + "index.php?p=video&a=doShare",
					data: {
						videoName: escape($rvideoName.val()),
						SingerID: $rSingerID.val(),
						classId: $rclassId.val(),
						Play: escape($rPlay.val()),
						Pic: escape($rPic.val())
					},
					dataType: "text",
					success: function(data) {
						if (data == 1001) {
							libs.userNotLogin('����Ҫ�ȵ�¼���ܽ��д˲���!');
						} else {
							$.tipMessage('��Ƶ�����ɹ�����ȴ���ˣ�', 0, 3000, 0,
							function() {
							        location.href = zone_domain + "index.php?p=video&a=pass&classId=" + $rclassId.val()
							});
						}
					}
				});
			}
		});
	}
}