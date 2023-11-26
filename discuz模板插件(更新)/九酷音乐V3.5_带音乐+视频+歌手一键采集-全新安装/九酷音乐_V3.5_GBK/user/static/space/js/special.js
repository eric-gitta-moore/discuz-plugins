var specialLib = {
	passDelInit: function() {
		$(".delete").click(function() {
			var did = $(this).attr("did");
			$.dialog({
				id: 'delDance',
				title: false,
				border: false,
				follow: $(this)[0],
				content: 'ȷ��Ҫɾ������ר��ô��',
				okValue: 'ȷ��',
				ok: function() {
					$.getJSON(zone_domain + "index.php?p=special&a=doShareDel&callback=?", "did=" + did,
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
			$mspecialName.html('��Ϊר����������������д�������������˲Ż�ͨ����');
		}).blur(function() {
			$(this).removeClass('input_focus');
			$(this).triggerHandler('keyup');
		}).keyup(function() {
			if ($(this).val() == '') {
				$mspecialName.removeClass('input_tag1');
				$mspecialName.addClass('input_tag2');
				$mspecialName.html('<span class="errIcon"></span>ר�����Ʋ���Ϊ�գ�');
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
			$mSingerID.html('ר�����������֣���ѡ�����һ����');
		}).blur(function() {
			$(this).removeClass('select_focus');
			$(this).triggerHandler('change');
		}).change(function(event) {
			if ($(this).val() == '') {
				$mSingerID.removeClass('input_tag1');
				$mSingerID.addClass('input_tag2');
				$mSingerID.html('<span class="errIcon"></span>��ѡ��ר�����������֣�');
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
			$mGongSi.html('ר���ķ��й�˾������ȷѡ��');
		}).blur(function() {
			$(this).removeClass('input_focus');
			$(this).triggerHandler('keyup');
		}).keyup(function() {
			if ($(this).val() == '') {
				$mGongSi.removeClass('input_tag1');
				$mGongSi.addClass('input_tag2');
				$mGongSi.html('<span class="errIcon"></span>���й�˾����Ϊ�գ�');
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
			$mclassId.html('ר�����������࣬����ȷѡ��');
		}).blur(function() {
			$(this).removeClass('select_focus');
			$(this).triggerHandler('change');
		}).change(function(event) {
			if ($(this).val() == '0') {
				$mclassId.removeClass('input_tag1');
				$mclassId.addClass('input_tag2');
				$mclassId.html('<span class="errIcon"></span>��ѡ��ר�����������࣡');
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
			$mYuYan.html('ר�����������ԣ�����ȷѡ��');
		}).blur(function() {
			$(this).removeClass('select_focus');
			$(this).triggerHandler('change');
		}).change(function(event) {
			if ($(this).val() == '') {
				$mYuYan.removeClass('input_tag1');
				$mYuYan.addClass('input_tag2');
				$mYuYan.html('<span class="errIcon"></span>��ѡ��ר�����������ԣ�');
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
							libs.userNotLogin('����Ҫ�ȵ�¼���ܽ��д˲���!');
						} else {
							$.tipMessage('ר�������ɹ�����ȴ���ˣ�', 0, 3000, 0,
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