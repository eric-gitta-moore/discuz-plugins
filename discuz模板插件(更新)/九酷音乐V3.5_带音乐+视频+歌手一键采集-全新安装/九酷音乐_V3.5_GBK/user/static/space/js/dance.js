var danceLib = {
	favoritesDelInit: function() {
		$(".del").click(function() {
			var did = $(this).attr("did");
			$.dialog({
				id: 'delDance',
				title: false,
				border: false,
				follow: $(this)[0],
				content: 'ȷ��Ҫȡ���ղ�ô��',
				okValue: 'ȷ��',
				ok: function() {
					$.getJSON(zone_domain + "index.php?p=dance&a=doFavoritesDel&callback=?", "did=" + escape(did),
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
	likeDelInit: function() {
		$(".del").click(function() {
			var did = $(this).attr("did");
			$.dialog({
				id: 'delDance',
				title: false,
				border: false,
				follow: $(this)[0],
				content: 'ȷ��Ҫɾ����������ô��',
				okValue: 'ȷ��',
				ok: function() {
					$.getJSON(zone_domain + "index.php?p=dance&a=doLikeDel&callback=?", "did=" + escape(did),
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
	dislikeDelInit: function() {
		$(".del").click(function() {
			var did = $(this).attr("did");
			$.dialog({
				id: 'delDance',
				title: false,
				border: false,
				follow: $(this)[0],
				content: 'ȷ��Ҫɾ����������ô��',
				okValue: 'ȷ��',
				ok: function() {
					$.getJSON(zone_domain + "index.php?p=dance&a=doDislikeDel&callback=?", "did=" + escape(did),
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
	listenDelInit: function() {
		$(".del").click(function() {
			var did = $(this).attr("did");
			$.dialog({
				id: 'delDance',
				title: false,
				border: false,
				follow: $(this)[0],
				content: 'ȷ��Ҫɾ����������ô��',
				okValue: 'ȷ��',
				ok: function() {
					$.getJSON(zone_domain + "index.php?p=dance&a=doListenDel&callback=?", "did=" + escape(did),
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
	downDelInit: function() {
		$(".del").click(function() {
			var did = $(this).attr("did");
			$.dialog({
				id: 'delDance',
				title: false,
				border: false,
				follow: $(this)[0],
				content: 'ȷ��Ҫɾ����������ô��',
				okValue: 'ȷ��',
				ok: function() {
					$.getJSON(zone_domain + "index.php?p=dance&a=doDownDel&callback=?", "did=" + did,
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
	passDelInit: function() {
		$(".del").click(function() {
			var did = $(this).attr("did");
			$.dialog({
				id: 'delDance',
				title: false,
				border: false,
				follow: $(this)[0],
				content: 'ȷ��Ҫɾ����������ô��',
				okValue: 'ȷ��',
				ok: function() {
					$.getJSON(zone_domain + "index.php?p=dance&a=doShareDel&callback=?", "did=" + did,
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
		var $danceAddMain = $('#danceAddMain');
		var $rdanceName = $('#rdanceName');
		var $mdanceName = $('#mdanceName');
		var $rSingerID = $('#rSingerID');
		var $mSingerID = $('#mSingerID');
		var $rclassId = $('#rclassId');
		var $mclassId = $('#mclassId');
		var $rSpecialID = $('#rSpecialID');
		var $mSpecialID = $('#mSpecialID');
		var $rUrl = $('#rUrl');
		var $mUrl = $('#mUrl');
		var $rServer = $('#rServer');
		var $rPic = $('#rPic');
		var $rLrc = $('#rLrc');
		var $rnote = $('#rnote');
		var $danceNewAdd = $('#danceNewAdd');
		$rdanceName.focus(function() {
			$(this).addClass('input_focus');
			$mdanceName.removeClass('input_tag2');
			$mdanceName.addClass('input_tag1');
			$mdanceName.html('��Ϊ������������������д�������������˲Ż�ͨ����');
		}).blur(function() {
			$(this).removeClass('input_focus');
			$(this).triggerHandler('keyup');
		}).keyup(function() {
			if ($(this).val() == '') {
				$mdanceName.removeClass('input_tag1');
				$mdanceName.addClass('input_tag2');
				$mdanceName.html('<span class="errIcon"></span>�������Ʋ���Ϊ�գ�');
				return false;
			} else {
				$mdanceName.removeClass('input_tag1');
				$mdanceName.removeClass('input_tag2');
				$mdanceName.html('<span class="rightIcon"></span>');
			}
		});
		$rSingerID.focus(function() {
			$(this).addClass('select_focus');
			$mSingerID.removeClass('input_tag2');
			$mSingerID.addClass('input_tag1');
			$mSingerID.html('���ֵ��������֣���ѡ�����һ����');
		}).blur(function() {
			$(this).removeClass('select_focus');
			$(this).triggerHandler('change');
		}).change(function(event) {
			if ($(this).val() == '') {
				$mSingerID.removeClass('input_tag1');
				$mSingerID.addClass('input_tag2');
				$mSingerID.html('<span class="errIcon"></span>��ѡ�����ֵ��������֣�');
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
			$mclassId.html('���ֵ��������࣬����ȷѡ��');
		}).blur(function() {
			$(this).removeClass('select_focus');
			$(this).triggerHandler('change');
		}).change(function(event) {
			if ($(this).val() == '0') {
				$mclassId.removeClass('input_tag1');
				$mclassId.addClass('input_tag2');
				$mclassId.html('<span class="errIcon"></span>��ѡ�����ֵ��������࣡');
				return false;
			} else {
				$mclassId.removeClass('input_tag1');
				$mclassId.removeClass('input_tag2');
				$mclassId.html('<span class="rightIcon"></span>');
			}
		});
		$rSpecialID.focus(function() {
			$(this).addClass('select_focus');
			$mSpecialID.removeClass('input_tag2');
			$mSpecialID.addClass('input_tag1');
			$mSpecialID.html('ֻ��ʾ��������ר������ѡ�����һ����');
		}).blur(function() {
			$(this).removeClass('select_focus');
			$(this).triggerHandler('change');
		}).change(function(event) {
			if ($(this).val() == '') {
				$mSpecialID.removeClass('input_tag1');
				$mSpecialID.addClass('input_tag2');
				$mSpecialID.html('<span class="errIcon"></span>��ѡ�����ֵ�����ר����');
				return false;
			} else {
				$mSpecialID.removeClass('input_tag1');
				$mSpecialID.removeClass('input_tag2');
				$mSpecialID.html('<span class="rightIcon"></span>');
			}
		});
		$rUrl.focus(function() {
			$(this).addClass('input_focus');
			$mUrl.removeClass('input_tag2');
			$mUrl.addClass('input_tag1');
			$mUrl.html('<span class="errIcon"></span>');
		}).blur(function() {
			$(this).removeClass('input_focus');
			$(this).triggerHandler('keyup');
		}).keyup(function() {
			if ($(this).val() == '') {
				$mUrl.removeClass('input_tag1');
				$mUrl.addClass('input_tag2');
				$mUrl.html('<span class="errIcon"></span>');
				return false;
			} else {
				$mUrl.removeClass('input_tag1');
				$mUrl.removeClass('input_tag2');
				$mUrl.html('<span class="rightIcon"></span>');
			}
		});
		$danceNewAdd.click(function() {
			$("#danceAddMain :input").trigger('keyup');
			$rSingerID.triggerHandler('change');
			$rclassId.triggerHandler('change');
			$rSpecialID.triggerHandler('change');
			var numError = $('#danceAddMain .errIcon').length;
			if (!numError) {
				$.ajax({
					type: "POST",
					global: false,
					url: zone_domain + "index.php?p=dance&a=doShare",
					data: {
						danceName: escape($rdanceName.val()),
						SingerID: $rSingerID.val(),
						classId: $rclassId.val(),
						SpecialID: $rSpecialID.val(),
						Url: escape($rUrl.val()),
						Server: $rServer.val(),
						Pic: escape($rPic.val()),
						Lrc: escape($rLrc.val()),
						note: escape($rnote.val().replace(/[\r\n]/g, "<br>"))
					},
					dataType: "text",
					success: function(data) {
						if (data == 1001) {
							libs.userNotLogin('����Ҫ�ȵ�¼���ܽ��д˲���!');
						} else {
							$.tipMessage('���ַ���ɹ�����ȴ���ˣ�', 0, 3000, 0,
							function() {
							        location.href = zone_domain + "index.php?p=dance&a=pass&classId=" + $rclassId.val()
							});
						}
					}
				});
			}
		});
	}
}