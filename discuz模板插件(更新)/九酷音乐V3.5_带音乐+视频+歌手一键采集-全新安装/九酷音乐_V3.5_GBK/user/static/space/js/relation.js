var relation = {
	init: function() {
		var $cancel = $("#cancel");
		var $followingGroupAdd = $("#followingGroupAdd");
		var $add = $("#add");
		$cancel.click(function() {
			$followingGroupAdd.hide();
		});
		$add.click(function() {
			var dialogObj = $.dialog.get('delGroup');
			if (typeof dialogObj === 'object') {
				dialogObj.close();
			}
			var $fgName = $('#addfgName');
			var uid = $(this).attr('uid');
			if (!/^([^<>'"\/\\])*$/.test($fgName.val())) {
				$.tipMessage("�����в����� < > \' \" / \\ �ȷǷ��ַ���", 1, 2000);
				return false;
			}
			$.ajax({
				type: "POST",
				global: false,
				url: zone_domain + "index.php?p=relation&a=doFollowingGroupAdd",
				data: {
					uid: uid,
					fgName: escape($fgName.val())
				},
				dataType: "text",
				success: function(data) {
					if (data == 20001) {
						user.userNotLogin('��δ��¼�޷�ִ�д˲�����');
					} else if (data == 20002) {
						$.tipMessage("��û��Ȩ����ӣ�", 1, 2000);
					} else if (data == 10007) {
						$.tipMessage("�������Ʋ���Ϊ�գ�", 1, 2000);
					} else if (data == 10006) {
						$.tipMessage("���������ܳ����߸��֣�", 1, 2000);
					} else if (data == 100061) {
						$.tipMessage("�����������ܳ���8����", 1, 2000);
					} else {
						$('#addfgName').val('');
						$('#followingGroupList').html(unescape(data));
					}
				}
			});
		});
	},
	userSearch: function() {
		var $province = $("#province").attr('val');
		var $keyword = $("#keyword").val();
		var $sex = $('#sex').text();
		if ($keyword == "") {
			var keyword = "";
		} else {
			var keyword = '&key=' + escape($keyword);
		}
		if ($sex == "��") {
			var sex = '&sex=1';
		} else if ($sex == "Ů") {
			var sex = '&sex=0';
		} else {
			var sex = "";
		}
		if ($province == "") {
			var province = "";
		} else {
			var province = '&code=' + escape($province);
		}
		if (keyword == "" && sex == "" && province == "") {
			$.tipMessage('������Ҫ��ѯ�Ĺؼ��ʣ�', 1, 1000);
		} else {
			location.href = zone_domain + 'index.php?p=user&a=userSearch' + keyword + sex + province;
		}
	},
	followingGroupSelect: function(fgid, friend_uid, is_quietly) {
		var newfgid = $("input[name='fgid']:checked").val();
		var $currPage = $("#currPage").html();
		$.ajax({
			type: "POST",
			global: false,
			url: zone_domain + "index.php?p=relation&a=doFollowingGroupSelect",
			data: {
				friend_uid: friend_uid,
				oldfgid: fgid,
				newfgid: newfgid,
				is_quietly: is_quietly
			},
			dataType: "text",
			success: function(data) {
				if (data == 20001) {
					user.userNotLogin('��δ��¼�޷�ִ�д˲�����');
				} else if (data == 10001) {
					location.href = zone_domain + "index.php?p=relation&a=following&pages=" + $currPage;
				} else if (data == 20002) {
					$.tipMessage('��Ȩ�޲���', 1, 3000);
				} else {
					$('#group_' + friend_uid).text(unescape(data));
					location.href = zone_domain + "index.php?p=relation&a=following&pages=" + $currPage;
				}
			}
		});
	},
	delFollowing: function(fgid, friend_uid, friend_nickname, showFgid, uid, avatar, class_id, is_quietly, status) {
		var $friend = $('#friend');
		var $fg_name = $("#group_" + friend_uid).html();
		var $currPage = $("#currPage");
		var $fgCount = $('#fgCount_' + fgid);
		var $s_fgCount = $('#s_fgCount_' + fgid);
		var $q_fgCount = $('#q_fgCount_' + fgid);
		var $fgCountAll = $('#fgCountAll');
		var nid = parseInt($("#number").attr("nid"));
		var s_fgCount = 0;
		var q_fgCount = 0;
		var fgCount = 0;
		if (avatar == '') {
			if ($fgCountAll.html() != undefined) {
				allCount = parseInt($fgCountAll.html().replace(/([\[\]])/g, ""));
			}
		}
		$.dialog({
			id: 'friendDel1',
			title: '�����˿��ϵ',
			width: '340px',
			lock: true,
			content: '<br/>��ȷ���� <strong>' + friend_nickname + '</strong> �����˿��ϵ��<br/><br/><span style="color: #999999;">��ʾ��������㽫�����յ����������¡�</span><br/><br/>',
			okValue: 'ȷ��',
			ok: function() {
				$.ajax({
					type: "POST",
					global: false,
					url: zone_domain + "index.php?p=relation&a=doFollowingDel",
					data: {
						friend_uid: friend_uid,
						fgid: showFgid,
						currPage: $currPage.html(),
						fg_name: $fg_name,
						uid: uid,
						class_id: class_id
					},
					dataType: "text",
					success: function(data) {
						if (data == 20001) {
							user.userNotLogin('��δ��¼�޷�ִ�д˲�����');
						} else if (data == 20002) {
							$.tipMessage("��û��Ȩ��ɾ����", 1, 2000);
						} else {
							if (avatar == '') {
								nid = nid - 1;
								$("#number").html("���鹲��" + nid + "��").attr('nid', "" + nid + "");
								$.tipMessage('���ɹ�������� <strong>' + friend_nickname + '</strong> �ķ�˿��ϵ��', 1, 2000, 0,
								function() {
									location.href = location.href;
								});
							}
						}
					}
				});
			},
			cancelValue: 'ȡ��',
			cancel: function() {}
		});
	},
	followingGroupModify: function(fgid) {
		if (!/^([^<>'"\/\\])*$/.test($('#modifyfgName').val())) {
			$.tipMessage("�����в����� < > \' \" / \\ �ȷǷ��ַ���", 1, 2000);
			return false;
		}
		$.ajax({
			type: "POST",
			global: false,
			url: zone_domain + "index.php?p=relation&a=doFollowingGroupModify",
			data: {
				'fgid': fgid,
				'fg_name': escape($('#modifyfgName').val())
			},
			dataType: "text",
			success: function(data) {
				if (data == 20001) {
					user.userNotLogin('��δ��¼�޷�ִ�д˲�����')
				} else if (data == 20002) {
					$.tipMessage("��û��Ȩ���޸ģ�", 1, 2000);
				} else if (data == 10007) {
					$.tipMessage("�������Ʋ���Ϊ�գ�", 1, 2000);
				} else if (data == 10006) {
					$.tipMessage("���������ܳ����߸��֣�", 1, 2000);
				} else {
					location.href = zone_domain + "index.php?p=relation&a=following&cid=4&fgid=" + fgid;
				}
			}
		});
	},
	change: function(fgid, fgName) {
		$.ajax({
			type: "POST",
			global: false,
			url: zone_domain + 'index.php?p=relation&a=modifyDialog',
			data: {
				'fgid': fgid,
				'fgName': escape(fgName)
			},
			dataType: "text",
			success: function(data) {
				$.dialog({
					id: 'login',
					title: '�༭����',
					content: data,
					lock: true
				});
			}
		});
	},
	group: function(fgid, friend_uid, nickname) {
		$.ajax({
			type: "POST",
			global: false,
			url: zone_domain + "index.php?p=relation&a=followingGroupDialog",
			data: {
				fgid: fgid,
				nickname: escape(nickname),
				friend_uid: friend_uid
			},
			dataType: "text",
			success: function(data) {
				if (data == 20001) {
					user.userNotLogin('��δ��¼�޷�ִ�д˲�����');
				} else if (data == 20002) {
					$.tipMessage("��û��Ȩ����ӣ�", 1, 2000);
				} else {
					$.dialog({
						id: "delGroup2",
						title: '�޸ķ���',
						content: data,
						okValue: 'ȷ���޸�',
						ok: function() {
							var is_quietly = $("#is_quietly:checked").val();
							relation.followingGroupSelect(fgid, friend_uid, is_quietly);
						},
						cancelValue: 'ȡ��',
						cancel: function() {
							var dialogObj = $.dialog.get('delGroup');
							if (typeof dialogObj === 'object') {
								dialogObj.close();
							}
							location.href = location.href;
						}
					});
				}
			}
		});
	}
};