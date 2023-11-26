var messageLib = {
	msgDelInit: function() {
		var $currPage = $('#currPage');
		$(".del").click(function() {
			var type = $(this).attr("type");
			var toUid = $(this).attr("toUid");
			var fromUid = $(this).attr("fromUid");
			$.ajax({
				type: "POST",
				global: false,
				url: zone_domain + "index.php?p=message&a=doMsgDel",
				data: {
					'type': type,
					'toUid': toUid,
					'fromUid': fromUid,
					'currPage': $currPage.html()
				},
				dataType: "text",
				success: function(data) {
					if (data == 20001) {
						user.userNotLogin('��δ��¼�޷�ִ�д˲�����');
					} else if (data == 20002) {
						$.tipMessage("�Բ�������Ȩɾ��", 1, 3000, 0,
						function() {
							location.href = location.href;
						});
					} else {
						if (type == 2) {
							location.href = zone_domain + "index.php?p=message&a=msg";
						} else {
							location.href = location.href;
						}
					}
				}
			});
		});
	},
	msgAllDelInit: function() {
		var fromUid = $(".delAll").attr("fromUid");
		var type = "";
		var toUid = "";
		$(".delAll").click(function() {
			$.ajax({
				type: "POST",
				global: false,
				url: zone_domain + "index.php?p=message&a=doMsgDel",
				data: {
					'type': 0,
					'toUid': 0,
					'fromUid': fromUid
				},
				dataType: "text",
				success: function(data) {
					if (data == 20001) {
						user.userNotLogin('��δ��¼�޷�ִ�д˲�����');
					} else if (data == 20002) {
						$.tipMessage('�Բ�����û�в���Ȩ��', 1, 3000);
						return false;
					} else {
						if (type == 2) {
							location.href = zone_domain + "index.php?p=message&a=msg";
						} else {
							location.href = location.href;
						}
					}
				}
			});
		});
	},
	msgIgnoreInit: function() {
		var uid = $(".ignore").attr("uid");
		$(".ignore").click(function() {
			$.ajax({
				type: "POST",
				global: false,
				url: zone_domain + "index.php?p=message&a=doMsgIgnore",
				data: {
					'uid': uid
				},
				dataType: "text",
				success: function(data) {
					if (data == 20001) {
						user.userNotLogin('��δ��¼�޷�ִ�д˲�����');
					} else if (data == 20002) {
						$.tipMessage('�Բ�����û�в���Ȩ��', 1, 3000);
						return false;
					} else {
						$('#msg').html("<div class='nothing'>û��δ��˽��!</div>");
					}
				}
			});
		});
	},
	msgAddInit: function() {
		var $fnote = $('#fnote');
		var uid = $(".reMsg").attr('toUid');
		$fnote.elastic({
			maxHeight: 130
		});
		$fnote.emotEditor({
			emot: true,
			newLine: true
		});
		$(".reMsg").click(function() {
			var validCharLength = $fnote.emotEditor("validCharLength");
			if (validCharLength < 1 || $fnote.emotEditor("content") == " ") {
				$.tipMessage('��ʲô��ûд����', 1, 2000);
				$fnote.emotEditor("focus");
				return false;
			}
			if ($fnote.html().length > 1500) {
				$.tipMessage('��д��̫���ˣ���װ�����ˣ�', 1, 2500);
				$fnote.emotEditor("focus");
				return false;
			}
			$.ajax({
				type: "POST",
				global: false,
				url: zone_domain + "index.php?p=message&a=doMsgAdd",
				data: {
					'uid': uid,
					'note': escape($fnote.emotEditor("content")),
					'type': 1
				},
				dataType: "text",
				success: function(data) {
					if (data == 20001) {
						user.userNotLogin('��δ��¼�޷�ִ�д˲�����');
					} else if (data == 10013) {
						$.tipMessage('�����ܸ��Լ���˽�ţ�', 1, 2500);
						return false;
					} else if (data == 10007) {
						$.tipMessage('��ʲô��ûд����', 1, 2500);
						$fnote.emotEditor("focus");
						return false;
					} else if (data == 10006) {
						$.tipMessage('��д��̫���ˣ���װ�����ˣ�', 1, 2500);
						$fnote.emotEditor("focus");
						return false;
					} else if (data == 20002) {
						$.tipMessage('�弶�����û��ſ��Է�˽�ţ�', 1, 2500);
						return false;
					} else {
						$('.msgList').html(data);
					}
				}
			});
		});
	},
	reMsgOneDelInit: function() {
		$(".del").click(function() {
			var mcId = $(this).attr('mcid');
			var toUid = $(this).attr('toUid');
			$.ajax({
				type: "POST",
				global: false,
				url: zone_domain + "index.php?p=message&a=doMsgOneDel",
				data: {
					'mcId': mcId,
					'toUid': toUid
				},
				dataType: "text",
				success: function(data) {
					if (data == 20001) {
						user.userNotLogin('��δ��¼�޷�ִ�д˲�����');
					} else if (data == 20002) {
						$.tipMessage("�Բ�������Ȩɾ��", 1, 3000, 0,
						function() {
							location.href = zone_domain + "index.php?p=message&a=msg";
						});
					} else if (data == 10000) {
						location.href = zone_domain + "index.php?p=message&a=msg";
					} else if (data == 10004) {
						$.tipMessage("�û�������", 1, 3000, 0,
						function() {
							location.href = zone_domain + "index.php?p=message&a=msg";
						});
					} else {
						$(".msgList").html(data);
					}
				}
			});
		});
	},
	reMsgDelInit: function() {
		var fromUid = $(".reMessage").attr('fromUid');
		var toUid = $(".reMessage").attr('toUid');
		$(".reMessage").click(function() {
			$.ajax({
				type: "POST",
				global: false,
				url: zone_domain + "index.php?p=message&a=doMsgDel",
				data: {
					'fromUid': fromUid,
					'toUid': toUid
				},
				dataType: "text",
				success: function(data) {
					if (data == 20001) {
						user.userNotLogin('��δ��¼�޷�ִ�д˲�����');
					} else if (data == 20002) {
						$.tipMessage("�Բ�������Ȩɾ��", 1, 3000, 0,
						function() {
							location.href = location.href;
						});
					} else {
						location.href = zone_domain + "index.php?p=message&a=msg";
					}
				}
			});
		});
	},
	notificationDelInit: function() {
		var $currPage = $('#currPage');
		$(".ndel").click(function() {
			var type = $("#type").html();
			var nid = $(this).attr('id');
			$.ajax({
				type: "POST",
				global: false,
				url: zone_domain + "index.php?p=message&a=doNotificationDel",
				data: {
					'nid': nid,
					'currPage': $currPage.html(),
					'type': type
				},
				dataType: "text",
				success: function(data) {
					if (data == 20001) {
						user.userNotLogin('��δ��¼�޷�ִ�д˲�����');
					} else if (data == 10004) {
						$.tipMessage('֪ͨ������', 1, 1500, 0);
					} else if (data == 20002) {
						$.tipMessage("�Բ�������Ȩɾ��", 1, 3000, 0,
						function() {
							location.href = location.href;
						});
					} else {
						$("#notification").html(data);
					}
				},
				error: function() {
					$.tipMessage('����ִ���������', 2, 3000);
				}
			});
		});
	},
	notificationAllDel: function(uid, type, month, id) {
		$.dialog({
			id: 'delAll',
			title: false,
			border: false,
			follow: $("#" + id)[0],
			content: 'ȷ��ɾ��ȫ��֪ͨô��',
			okValue: 'ȷ��',
			ok: function() {
				$.ajax({
					type: "POST",
					global: false,
					url: zone_domain + "index.php?p=message&a=doNotificationAllDel",
					data: {
						'uid': uid,
						'type': type,
						month: month
					},
					dataType: "text",
					success: function(data) {
						if (data == 20001) {
							user.userNotLogin('��δ��¼�޷�ִ�д˲�����');
						} else if (data == 20002) {
							$.tipMessage("�Բ�������Ȩɾ��", 1, 3000, 0,
							function() {
								location.href = location.href;
							});
						} else if (data == 10000) {
							location.href = location.href;
						} else {
							$.tipMessage("�Բ��𣬲�������", 1, 3000, 0,
							function() {
								location.href = location.href;
							});
						}
					}
				});
			},
			cancelValue: 'ȡ��',
			cancel: function() {}
		});
	}
}