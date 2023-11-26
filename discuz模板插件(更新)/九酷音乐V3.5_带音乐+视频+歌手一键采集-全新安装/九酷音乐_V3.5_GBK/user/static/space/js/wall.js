var wallLib = {
	wallTimer: 0,
	commentTimer: 0,
	wallAddInit: function(uid, uidkey) {
		var $wallContent = $("#wallContent");
		var type = $('#praise').attr('uid');
		var $currPage = $('#currPage');
		var $sW_message = $('#sW_message');
		var validCharLength = $wallContent.emotEditor("validCharLength");
		if (validCharLength < 1) {
			$sW_message.html('�����������������ݣ�');
			clearTimeout(wallLib.wallTimer);
			wallLib.wallTimer = setTimeout(function() {
				$sW_message.html('');
			},
			2000);
			$wallContent.emotEditor("focus");
			return;
		}
		$("#wallSubmit").attr('disabled', 'disabled');
		setTimeout(function() {
			$("#wallSubmit").removeAttr('disabled');
		},
		5000);
		$.ajax({
			type: "POST",
			global: false,
			url: zone_domain + "index.php?p=wall&a=doWallAdd",
			data: {
				'uid': uid,
				'wallContent': escape($wallContent.emotEditor("content")),
				'currPage': $currPage.html(),
				type: type,
				uidkey: uidkey
			},
			dataType: "text",
			success: function(data) {
				if (data == 10007) {
					$sW_message.html('�����������������ݣ�');
					$wallContent.emotEditor("focus");
					clearTimeout(wallLib.wallTimer);
					wallLib.wallTimer = setTimeout(function() {
						$sW_message.html('');
					},
					2000);
				} else if (data == 10006) {
					$sW_message.html('�������ݲ��ܳ���300���֣�');
					$wallContent.emotEditor("focus");
					clearTimeout(wallLib.wallTimer);
					wallLib.wallTimer = setTimeout(function() {
						$sW_message.html('');
					},
					2000);
				} else if (data == 20001) {
					user.userNotLogin('��δ��¼�޷�ִ�д˲�����');
				} else if (data == 10002) {
					$sW_message.html('���Ĳ���̫Ƶ�������Ժ����ԣ�');
					$wallContent.emotEditor("focus");
					clearTimeout(wallLib.wallTimer);
					wallLib.wallTimer = setTimeout(function() {
						$sW_message.html('');
					},
					8000);
				} else if (data == 10011) {
					location.href = location.href;
				} else {
					$.tipMessage('���Է���ɹ�!', 0, 3000);
					$wallContent.emotEditor("reset", '');
					if ($currPage.html() > 1) {
						location.href = zone_domain + "index.php?p=space&a=wall&uid=" + uid;
					} else {
						wallLib.moreWall(uid, 1);
					}
				}
			}
		});
	},
	doDelWall: function(uid, wid, cid, showType) {
		var follow,
		content,
		$handleObj,
		$currPage = $("#currPage"),
		dialogObj = $.dialog.get('delWall'),
		type = $('#praise').attr('uid');
		if (cid) {
			follow = $('#del-c' + cid)[0];
			content = 'ȷ��ɾ�������ظ�ô��';
			$handleObj = $('#wallComment' + wid);
		} else {
			cid = 0;
			follow = $('#del-w' + wid)[0];
			content = 'ȷ��ɾ����������ô��';
			$handleObj = $('#wall_content');
		}
		if (typeof dialogObj === 'object') {
			dialogObj.close();
		}
		$.dialog({
			id: 'delWall',
			title: false,
			border: false,
			follow: follow,
			content: content,
			okValue: 'ȷ��',
			ok: function() {
				$.ajax({
					type: "POST",
					global: false,
					url: zone_domain + "index.php?p=wall&a=doWallDel",
					data: {
						uid: uid,
						wid: wid,
						cid: cid,
						currPage: $currPage.html(),
						showType: showType,
						type: type
					},
					dataType: "text",
					success: function(data) {
						if (data == 20001) {
							user.userNotLogin('��δ��¼�޷�ִ�д˲�����');
							return false;
						} else if (data == 20002) {
							$.tipMessage('��û��Ȩ��ɾ����', 1, 3000);
							return false;
						} else if (data == 10004) {
							$.tipMessage("�����ѱ�ɾ��", 1, 3000, 0,
							function() {
								location.href = location.href;
							});
						} else {
							if (cid) {
								$('#wallComment' + wid).html(unescape(data));
							} else {
								if ($currPage.html() == 0) {
									location.href = location.href;
								} else {
									wallLib.moreWall(uid, 1);
								}
							}
						}
					},
					error: function() {
						$.tipMessage("����ִ���������", 2, 3000);
						return false;
					}
				});
			},
			cancelValue: 'ȡ��',
			cancel: function() {}
		});
	},
	confirmWall: function(wid, uid) {
		var $content = $("#wallCommentInput" + wid);
		var replayUser = $("#replayUser_" + wid).html();
		var validCharLength = $content.emotEditor("validCharLength");
		if (validCharLength < 1) {
			$("#wCI_message" + wid).html('�����������������ݣ�');
			$content.emotEditor("focus");
			clearTimeout(wallLib.commentTimer);
			wallLib.commentTimer = setTimeout(function() {
				$("#wCI_message" + wid).html('');
			},
			2000);
			return;
		}
		if (replayUser != '') {
			replayUser = replayUser.substring(3);
		}
		$("#wallcontSubmit").attr('disabled', 'disabled');
		setTimeout(function() {
			$("#wallcontSubmit").removeAttr('disabled');
		},
		5000);
		$.ajax({
			type: "POST",
			global: false,
			url: zone_domain + "index.php?p=wall&a=doWallCommentAdd",
			data: {
				wid: wid,
				content: escape($content.emotEditor("content")),
				replayUser: escape(replayUser),
				uid: uid
			},
			dataType: "text",
			success: function(data) {
				if (data == 20001) {
					user.userNotLogin('��δ��¼�޷�ִ�д˲�����');
					return false;
				} else if (data == 10004) {
					$.tipMessage("�����ѱ�ɾ��", 1, 3000, 0,
					function() {
						location.href = location.href;
					});
				} else if (data == 10012) {
					$("#wCI_message" + wid).html("���Ĳ���̫Ƶ�������Ժ�����!");
					clearTimeout(wallLib.commentTimer);
					wallLib.commentTimer = setTimeout(function() {
						$("#wCI_message" + wid).html('');
					},
					5000);
					return false;
				} else if (data == 10006) {
					$("#wCI_message" + wid).html("���Իظ����ݳ���������ƣ�");
					clearTimeout(wallLib.commentTimer);
					wallLib.commentTimer = setTimeout(function() {
						$("#wCI_message" + wid).html('');
					},
					3000);
					return false;
				} else if (data == 10007) {
					$("#wCI_message" + wid).html("���������Ļظ����ݣ�");
					$content.emotEditor("focus");
					clearTimeout(wallLib.commentTimer);
					wallLib.commentTimer = setTimeout(function() {
						$("#wCI_message" + wid).html('');
					},
					3000);
					return false;
				} else {
					$.tipMessage('�ظ�����ɹ�!', 0, 3000);
					$content.emotEditor("reset", '');
					$('#wallComment' + wid).html(unescape(data));
				}
			},
			error: function() {
				$.tipMessage("����ִ�д���", 2, 3000);
				return false;
			}
		});
	},
	replyWall: function(wid, cid, toUid, toNickname, authorUid) {
		var $wallCommentInput = $("#wallCommentInput" + wid);
		if (cid) {
			if (authorUid != toUid) {
				$("#replayUser_" + wid).html("�ظ�@" + toNickname + "[" + toUid + "]").show();
				$("#replayUserDel_" + wid).show();
			}
			 else {
				$("#replayUser_" + wid).empty().hide();
				$("#replayUserDel_" + wid).hide();
			}
		}
		 else {
			$("#replayUser_" + wid).empty().hide();
			$("#replayUserDel_" + wid).hide();
		}
		$('.wallCommentInputBox').hide();
		$("#wallCommentInputBox" + wid).show();
		$wallCommentInput.emotEditor({
			emot: true,
			focus: true,
			newLine: true
		});
		return false;
	},
	delReplayUser: function(wid) {
		$("#replayUser_" + wid).empty().hide();
		$("#replayUserDel_" + wid).hide();
		return false;
	},
	cancelWall: function(wid) {
		$("#wallCommentInputBox" + wid).hide();
	},
	moreWall: function(uid, currPage) {
		$.ajax({
			type: "POST",
			global: false,
			url: zone_domain + "index.php?p=wall&a=fetchSpaceWall",
			data: {
				uid: uid,
				currPage: currPage
			},
			dataType: "text",
			success: function(data) {
				$("#wall_content").html(unescape(data));
			}
		});
	}
}