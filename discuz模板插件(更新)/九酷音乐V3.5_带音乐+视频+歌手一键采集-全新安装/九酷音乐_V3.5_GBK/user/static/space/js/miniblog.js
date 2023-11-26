var miniblogLib = {
	miniblogTimer: 0,
	miniblogAddInit: function() {
		var $note = $("#note");
		var noteContent = "发一条说说, 让大家知道你在做什么...";
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
				$miniblogMessage.html('请输入说说内容！');
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
						$miniblogMessage.html('请输入说说内容！');
						$note.emotEditor("focus");
						clearTimeout(miniblogLib.miniblogTimer);
						miniblogLib.miniblogTimer = setTimeout(function() {
							$miniblogMessage.html('');
						},
						2000);
						return false;
					} else if (data == 10006) {
						$miniblogMessage.html('说说内容不能超过140个字！');
						$note.emotEditor("focus");
						clearTimeout(miniblogLib.miniblogTimer);
						miniblogLib.miniblogTimer = setTimeout(function() {
							$miniblogMessage.html('');
						},
						2000);
						return false;
					} else if (data == 20001) {
						libs.userNotLogin('您需要先登录才能进行留言操作!');
					} else if (data == 10002) {
						$miniblogMessage.html('您的操作太频繁，请稍后再试！');
						$note.emotEditor("focus");
						clearTimeout(miniblogLib.miniblogTimer);
						miniblogLib.miniblogTimer = setTimeout(function() {
							$miniblogMessage.html('');
						},
						2000);
						return false;
					} else if (data == 10005) {
						$.tipMessage('五级以上用户才可以发表说说！', 1, 3000);
						return false;
					} else {
						$note.emotEditor("reset");
						$.tipMessage("发表说说成功", 1, 2000, 0,
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
			$(".replayUser").html("回复@" + nickname + "[" + authorId + "]");
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
						$.tipMessage('请先说点什么吧！', 1, 3000);
						$note.focus();
						return false;
					} else if (data == 10006) {
						$.tipMessage('回复内容不能超过140个字！', 1, 3000);
						$note.focus();
						return false;
					} else if (data == 20001) {
						libs.userNotLogin('您需要先登录才能进行留言操作 ！');
					} else if (data == 10002) {
						$.tipMessage('您的操作太频繁，请稍后再试！', 1, 3000);
						$note.focus();
						return false;
					} else if (data == 10004) {
						$.tipMessage("说说已被删除", 1, 3000, 0,
						function() {
							location.href = location.href;
						});
					} else {
						$(".dells").hide();
						$(".replayUser").html("").hide();
						$note.val('').focus();
						$miniblogCommentList.html(data);
						num = $("#nums").attr("num");
						$replyNum.html("评论[" + num + "]");
					}
				},
				error: function() {
					$.tipMessage('数据执行意外错误！', 2, 3000);
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
				content: '确认删除这条说说么？',
				okValue: '确认',
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
								libs.userNotLogin('您需要先登录才能进行操作 ！');
							} else if (data == 20002) {
								$.tipMessage('对不起，您没有操作权限', 1, 3000);
								return false;
							} else if (data == 10005) {
								$.tipMessage('本次操作失败了，请稍后重试', 1, 3000);
								return false;
							} else if (data == 10004) {
								$.tipMessage("说说已被删除", 1, 3000, 0,
								function() {
									location.href = location.href;
								});
							} else {
								if (showType == 1) {
									location.href = zone_domain + 'index.php?p=space&a=miniblog&uid=' + uid;
								} else {
									$.tipMessage("说说已被删除", 1, 2000, 0,
									function() {
										location.href = location.href;
									});
								}
							}
						},
						error: function() {
							$.tipMessage('数据执行意外错误！', 2, 3000);
						}
					});
				},
				cancelValue: '取消',
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
				content: '确认删除这条评论么？',
				okValue: '确认',
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
								libs.userNotLogin('您需要先登录才能进行操作 ！');
							} else if (data == 20002) {
								$.tipMessage('对不起，您没有操作权限', 1, 3000);
								return false;
							} else if (data == 10005) {
								$.tipMessage('本次操作失败了，请稍后重试', 1, 3000);
								return false;
							} else if (data == 10004) {
								$.tipMessage("评论已被删除", 1, 3000, 0,
								function() {
									location.href = location.href;
								});
							} else {
								$miniblogCommentList.html(data);
								num = $("#nums").attr("num");
								$replyNum.html("评论[" + num + "]");
							}
						},
						error: function() {
							$.tipMessage('数据执行意外错误！', 2, 3000);
						}
					});
				},
				cancelValue: '取消',
				cancel: function() {}
			});
		});
	},
	miniblogHomeAddInit: function() {
		var $note = $("#note");
		var noteContent = "发一条说说, 让大家知道你在做什么...";
		$note.emotEditor({
			emot: true,
			charCount: true,
			defaultText: noteContent,
			defaultCss: 'default_color'
		});
		$(".send").click(function() {
			var validCharLength = $note.emotEditor("validCharLength");
			if (validCharLength < 1 || $note.emotEditor("content") == "") {
				$.tipMessage('请输入说说内容！', 1, 3000);
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
						$.tipMessage('请输入说说内容！', 1, 3000);
						$note.emotEditor("focus");
						return false;
					} else if (data == 10006) {
						$.tipMessage('说说内容不能超过140个字！', 1, 3000);
						$note.emotEditor("focus");
						return false;
					} else if (data == 20001) {
						libs.userNotLogin('您需要先登录才能进行操作 ！');
					} else if (data == 10002) {
						$.tipMessage('您的操作太频繁，请稍后再试！', 1, 3000);
						$note.emotEditor("focus");
						return false;
					} else if (data == 10005) {
						$.tipMessage('五级以上用户才可以发表说说！', 1, 3000);
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