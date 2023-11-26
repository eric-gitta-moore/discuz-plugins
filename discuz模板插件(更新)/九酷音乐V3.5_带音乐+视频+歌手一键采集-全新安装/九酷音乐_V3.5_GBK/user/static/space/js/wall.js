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
			$sW_message.html('请输入您的留言内容！');
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
					$sW_message.html('请输入您的留言内容！');
					$wallContent.emotEditor("focus");
					clearTimeout(wallLib.wallTimer);
					wallLib.wallTimer = setTimeout(function() {
						$sW_message.html('');
					},
					2000);
				} else if (data == 10006) {
					$sW_message.html('留言内容不能超过300个字！');
					$wallContent.emotEditor("focus");
					clearTimeout(wallLib.wallTimer);
					wallLib.wallTimer = setTimeout(function() {
						$sW_message.html('');
					},
					2000);
				} else if (data == 20001) {
					user.userNotLogin('您未登录无法执行此操作！');
				} else if (data == 10002) {
					$sW_message.html('您的操作太频繁，请稍后再试！');
					$wallContent.emotEditor("focus");
					clearTimeout(wallLib.wallTimer);
					wallLib.wallTimer = setTimeout(function() {
						$sW_message.html('');
					},
					8000);
				} else if (data == 10011) {
					location.href = location.href;
				} else {
					$.tipMessage('留言发表成功!', 0, 3000);
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
			content = '确认删除这条回复么？';
			$handleObj = $('#wallComment' + wid);
		} else {
			cid = 0;
			follow = $('#del-w' + wid)[0];
			content = '确认删除这条留言么？';
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
			okValue: '确认',
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
							user.userNotLogin('您未登录无法执行此操作！');
							return false;
						} else if (data == 20002) {
							$.tipMessage('您没有权限删除！', 1, 3000);
							return false;
						} else if (data == 10004) {
							$.tipMessage("留言已被删除", 1, 3000, 0,
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
						$.tipMessage("数据执行意外错误！", 2, 3000);
						return false;
					}
				});
			},
			cancelValue: '取消',
			cancel: function() {}
		});
	},
	confirmWall: function(wid, uid) {
		var $content = $("#wallCommentInput" + wid);
		var replayUser = $("#replayUser_" + wid).html();
		var validCharLength = $content.emotEditor("validCharLength");
		if (validCharLength < 1) {
			$("#wCI_message" + wid).html('请输入您的留言内容！');
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
					user.userNotLogin('您未登录无法执行此操作！');
					return false;
				} else if (data == 10004) {
					$.tipMessage("评论已被删除", 1, 3000, 0,
					function() {
						location.href = location.href;
					});
				} else if (data == 10012) {
					$("#wCI_message" + wid).html("您的操作太频繁，请稍后再试!");
					clearTimeout(wallLib.commentTimer);
					wallLib.commentTimer = setTimeout(function() {
						$("#wCI_message" + wid).html('');
					},
					5000);
					return false;
				} else if (data == 10006) {
					$("#wCI_message" + wid).html("留言回复内容超过最大限制！");
					clearTimeout(wallLib.commentTimer);
					wallLib.commentTimer = setTimeout(function() {
						$("#wCI_message" + wid).html('');
					},
					3000);
					return false;
				} else if (data == 10007) {
					$("#wCI_message" + wid).html("请输入您的回复内容！");
					$content.emotEditor("focus");
					clearTimeout(wallLib.commentTimer);
					wallLib.commentTimer = setTimeout(function() {
						$("#wCI_message" + wid).html('');
					},
					3000);
					return false;
				} else {
					$.tipMessage('回复发表成功!', 0, 3000);
					$content.emotEditor("reset", '');
					$('#wallComment' + wid).html(unescape(data));
				}
			},
			error: function() {
				$.tipMessage("数据执行错误！", 2, 3000);
				return false;
			}
		});
	},
	replyWall: function(wid, cid, toUid, toNickname, authorUid) {
		var $wallCommentInput = $("#wallCommentInput" + wid);
		if (cid) {
			if (authorUid != toUid) {
				$("#replayUser_" + wid).html("回复@" + toNickname + "[" + toUid + "]").show();
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