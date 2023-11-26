var miniblogLib = {
	miniblogTimer: 0,
	miniblogAddInit: function() {
		var $note = $("#note");
		var noteContent = "��һ��˵˵, �ô��֪��������ʲô...";
		$note.emotEditor({
			emot: true,
			charCount: true,
			defaultText: noteContent,
			defaultCss: 'default_color'
		});
		$("#send").click(function() {
			var $currPage = $('#currPage');
			var $miniblogMessage = $('#miniblogMessage');
			var $miniblogList = $('#miniblogList');
			var validCharLength = $note.emotEditor("validCharLength");
			if (validCharLength < 1 || $note.emotEditor("content") == "") {
				$miniblogMessage.html('������˵˵���ݣ�');
				clearTimeout(miniblogLib.miniblogTimer);
				miniblogLib.miniblogTimer = setTimeout(function() {
					$miniblogMessage.html('');
				},
				2000);
				$note.emotEditor("focus");
				return false;
			}
			$.ajax({
				type: "POST",
				global: false,
				url: zone_domain + "index.php?p=miniblog&a=doMiniblogAdd",
				data: {
					'note': escape($note.emotEditor("content")),
					'currPage': $currPage.html()
				},
				dataType: "text",
				success: function(data) {
					if (data == 10007) {
						$miniblogMessage.html('������˵˵���ݣ�');
						$note.emotEditor("focus");
						clearTimeout(miniblogLib.miniblogTimer);
						miniblogLib.miniblogTimer = setTimeout(function() {
							$miniblogMessage.html('');
						},
						2000);
						return false;
					} else if (data == 10006) {
						$miniblogMessage.html('˵˵���ݲ��ܳ���140���֣�');
						$note.emotEditor("focus");
						clearTimeout(miniblogLib.miniblogTimer);
						miniblogLib.miniblogTimer = setTimeout(function() {
							$miniblogMessage.html('');
						},
						2000);
						return false;
					} else if (data == 20001) {
						libs.userNotLogin('����Ҫ�ȵ�¼���ܽ������Բ���!');
					} else if (data == 10002) {
						$miniblogMessage.html('���Ĳ���̫Ƶ�������Ժ����ԣ�');
						$note.emotEditor("focus");
						clearTimeout(miniblogLib.miniblogTimer);
						miniblogLib.miniblogTimer = setTimeout(function() {
							$miniblogMessage.html('');
						},
						2000);
						return false;
					} else if (data == 10005) {
						$.tipMessage('�弶�����û��ſ��Է���˵˵��', 1, 3000);
						return false;
					} else {
						$note.emotEditor("reset");
						$.tipMessage("����˵˵�ɹ�", 1, 2000, 0,
						function() {
							location.href = location.href;
						});
					}
				}
			});
			return false;
		});
	},
	replayUserInit: function() {
		$(".comment").click(function() {
			var authorId = $(this).attr("authorId");
			var nickname = $(this).attr("nickname");
			$(".replayUser").show();
			$(".dells").show();
			$(".replayUser").html("�ظ�@" + nickname + "[" + authorId + "]");
			$note = $('#note');
			$note.focus();
		});
	},
	replayUserDelInit: function() {
		$(".dells").click(function() {
			$(".dells").hide();
			$(".replayUser").html("").hide();
			$note = $('#note');
			$note.focus();
		});
	},
	commentAddInit: function() {
		$("#note").elastic({
			maxHeight: 90
		});
		var num = "";
		$(".send").click(function() {
			var $uid = $("#uid");
			var $bid = $("#bid");
			var $replyNum = $('#replyNum');
			var $replayUser = $("#replayUser");
			var $note = $("#note");
			var $miniblogCommentList = $('#miniblogCommentList');
			$.ajax({
				type: "POST",
				global: false,
				url: zone_domain + "index.php?p=miniblog&a=doCommentAdd",
				data: {
					uid: $uid.val(),
					bid: $bid.val(),
					replayUser: escape($replayUser.html()),
					note: escape($.trim($note.val()))
				},
				dataType: "text",
				success: function(data) {
					if (data == 10007) {
						$.tipMessage('����˵��ʲô�ɣ�', 1, 3000);
						$note.focus();
						return false;
					} else if (data == 10006) {
						$.tipMessage('�ظ����ݲ��ܳ���140���֣�', 1, 3000);
						$note.focus();
						return false;
					} else if (data == 20001) {
						libs.userNotLogin('����Ҫ�ȵ�¼���ܽ������Բ��� ��');
					} else if (data == 10002) {
						$.tipMessage('���Ĳ���̫Ƶ�������Ժ����ԣ�', 1, 3000);
						$note.focus();
						return false;
					} else if (data == 10004) {
						$.tipMessage("˵˵�ѱ�ɾ��", 1, 3000, 0,
						function() {
							location.href = location.href;
						});
					} else {
						$(".dells").hide();
						$(".replayUser").html("").hide();
						$note.val('').focus();
						$miniblogCommentList.html(data);
						num = $("#nums").attr("num");
						$replyNum.html("����[" + num + "]");
					}
				},
				error: function() {
					$.tipMessage('����ִ���������', 2, 3000);
				}
			});
		});
	},
	miniblogDelInit: function() {
		$(".del").click(function() {
			var $miniblogList = $('#miniblogList');
			var $currPage = $('#currPage');
			var uid = $(this).attr("uid");
			var showType = $('#showType').val();
			var bid = $(this).attr('bid');
			var dialogObj = $.dialog.get('delMiniblogAndComment');
			var kernelType = $("#kernelType").val();
			if (typeof dialogObj === 'object') {
				dialogObj.close();
			}
			$.dialog({
				id: 'delMiniblogAndComment',
				title: false,
				border: false,
				follow: $(this)[0],
				content: 'ȷ��ɾ������˵˵ô��',
				okValue: 'ȷ��',
				ok: function() {
					$.ajax({
						type: "POST",
						global: false,
						url: zone_domain + "index.php?p=miniblog&a=doMiniblogDel",
						data: {
							'bid': bid,
							'showType': showType,
							'currPage': $currPage.html(),
							'uid': uid,
							"kernelType": kernelType
						},
						dataType: "text",
						success: function(data) {
							if (data == 20001) {
								libs.userNotLogin('����Ҫ�ȵ�¼���ܽ��в��� ��');
							} else if (data == 20002) {
								$.tipMessage('�Բ�����û�в���Ȩ��', 1, 3000);
								return false;
							} else if (data == 10005) {
								$.tipMessage('���β���ʧ���ˣ����Ժ�����', 1, 3000);
								return false;
							} else if (data == 10004) {
								$.tipMessage("˵˵�ѱ�ɾ��", 1, 3000, 0,
								function() {
									location.href = location.href;
								});
							} else {
								if (showType == 1) {
									location.href = zone_domain + 'index.php?p=space&a=miniblog&uid=' + uid;
								} else {
									$.tipMessage("˵˵�ѱ�ɾ��", 1, 2000, 0,
									function() {
										location.href = location.href;
									});
								}
							}
						},
						error: function() {
							$.tipMessage('����ִ���������', 2, 3000);
						}
					});
				},
				cancelValue: 'ȡ��',
				cancel: function() {}
			});
		});
	},
	commentDelInit: function() {
		var num = "";
		$(".dell").click(function() {
			var $miniblogCommentList = $('#miniblogCommentList');
			var $replyNum = $('#replyNum');
			var bid = $(".del").attr("id");
			cid = $(this).attr('cid');
			var dialogObj = $.dialog.get('delMiniblogAndComment');
			if (typeof dialogObj === 'object') {
				dialogObj.close();
			}
			$.dialog({
				id: 'delMiniblogAndComment',
				title: false,
				border: false,
				follow: $(this)[0],
				content: 'ȷ��ɾ����������ô��',
				okValue: 'ȷ��',
				ok: function() {
					$.ajax({
						type: "POST",
						global: false,
						url: zone_domain + "index.php?p=miniblog&a=doCommentDel",
						data: {
							'cid': cid,
							'bid': bid
						},
						dataType: "text",
						success: function(data) {
							if (data == 20001) {
								libs.userNotLogin('����Ҫ�ȵ�¼���ܽ��в��� ��');
							} else if (data == 20002) {
								$.tipMessage('�Բ�����û�в���Ȩ��', 1, 3000);
								return false;
							} else if (data == 10005) {
								$.tipMessage('���β���ʧ���ˣ����Ժ�����', 1, 3000);
								return false;
							} else if (data == 10004) {
								$.tipMessage("�����ѱ�ɾ��", 1, 3000, 0,
								function() {
									location.href = location.href;
								});
							} else {
								$miniblogCommentList.html(data);
								num = $("#nums").attr("num");
								$replyNum.html("����[" + num + "]");
							}
						},
						error: function() {
							$.tipMessage('����ִ���������', 2, 3000);
						}
					});
				},
				cancelValue: 'ȡ��',
				cancel: function() {}
			});
		});
	},
	miniblogHomeAddInit: function() {
		var $note = $("#note");
		var noteContent = "��һ��˵˵, �ô��֪��������ʲô...";
		$note.emotEditor({
			emot: true,
			charCount: true,
			defaultText: noteContent,
			defaultCss: 'default_color'
		});
		$(".send").click(function() {
			var validCharLength = $note.emotEditor("validCharLength");
			if (validCharLength < 1 || $note.emotEditor("content") == "") {
				$.tipMessage('������˵˵���ݣ�', 1, 3000);
				$note.emotEditor("focus");
				return false;
			}
			$.ajax({
				type: "POST",
				global: false,
				url: zone_domain + "index.php?p=miniblog&a=doMiniblogAdd",
				data: {
					'note': escape($note.emotEditor("content"))
				},
				dataType: "text",
				success: function(data) {
					if (data == 10007) {
						$.tipMessage('������˵˵���ݣ�', 1, 3000);
						$note.emotEditor("focus");
						return false;
					} else if (data == 10006) {
						$.tipMessage('˵˵���ݲ��ܳ���140���֣�', 1, 3000);
						$note.emotEditor("focus");
						return false;
					} else if (data == 20001) {
						libs.userNotLogin('����Ҫ�ȵ�¼���ܽ��в��� ��');
					} else if (data == 10002) {
						$.tipMessage('���Ĳ���̫Ƶ�������Ժ����ԣ�', 1, 3000);
						$note.emotEditor("focus");
						return false;
					} else if (data == 10005) {
						$.tipMessage('�弶�����û��ſ��Է���˵˵��', 1, 3000);
						return false;
					} else {
						location.href = zone_domain + "index.php?p=miniblog&a=me";
					}
				}
			});
			return false;
		});
	}
}