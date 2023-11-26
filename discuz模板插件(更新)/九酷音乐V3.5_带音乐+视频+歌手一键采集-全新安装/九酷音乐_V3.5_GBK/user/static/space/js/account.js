var account = {
	doAccountInit: function() {
		$("#obtain").click(function() {
			$.ajax({
				type: "POST",
				global: false,
				url: zone_domain + "index.php?p=account&a=doAccountUpdate",
				dataType: "text",
				success: function(data) {
					if (data == 20001) {
						libs.userNotLogin('��δ��¼�޷�ִ�д˲�����');
						return false;
					} else if (data == 10004) {
						$.tipMessage('����ʱ��û��δ����֣�', 1, 2000);
						return false;
					} else {
						$.tipMessage('��������ȡ��', 0, 2000, 0,
						function() {
							location.href = location.href;
						});
					}
				},
				error: function() {
					$.tipMessage('����ִ���������', 2, 3000);
				}
			});
		});
	},
	vipRenewals: function() {
		$("#renewals").click(function() {
			$.tipMessage('��ֵϵͳ�������ţ������ڴ���', 1, 2000);
			return false;
		});
	},
	vipRecharge: function() {
		$("#recharge").click(function() {
			var myDialog = $.dialog({
				id: 'sendMsg',
				title: '��ֵ',
				lock: true,
				okValue: 'ȷ��',
				ok: function() {
					var pid = $("input[name=pid]:checked");
					if (pid.val() == undefined) {
						$.tipMessage('����ѡ������������ͣ�', 1, 3000);
						return false;
					} else {
						$.ajax({
							type: "POST",
							global: false,
							url: zone_domain + "index.php?p=account&a=order",
							data: {
								'pid': pid.val()
							},
							dataType: "text",
							success: function(data) {
								if (data == 20001) {
									user.userNotLogin('��δ��¼�޷�ִ�д˲�����');
								} else if (data == 10004) {
									$.tipMessage('�Ƿ���������ָ����������', 1, 2000);
									return false;
								} else {
									$.dialog({
										id: 'sendMsg',
										title: '��ֵ',
										lock: true,
										content: data,
										okValue: 'ȷ�ϲ�֧��',
										ok: function() {
											var cd_type = $("input[name=cd_type]:checked");
											if (cd_type.val() == undefined) {
												$.tipMessage('����ѡ��һ��֧����ʽ��', 1, 3000);
												return false;
											} else {
												frmadd.submit();
												return false;
											}
										},
										cancelValue: 'ȡ��',
										cancel: function() {}
									});
								}
							}
						});
					}
				},
				cancelValue: 'ȡ��',
				cancel: function() {}
			});
			$.ajax({
				type: "POST",
				global: false,
				url: zone_domain + "index.php?p=account&a=Recharge",
				data: {
					'uidKey': 1
				},
				dataType: "text",
				success: function(data) {
					if (data == 20001) {
						user.userNotLogin('��δ��¼�޷�ִ�д˲�����');
						return false;
					} else {
						myDialog.content(data);
					}
				}
			});
		});
	},
	doListenAccountInit: function() {
		$("#listenScore").click(function() {
			$.ajax({
				type: "POST",
				global: false,
				url: zone_domain + "index.php?p=account&a=doListenScoreUpdate",
				dataType: "text",
				success: function(data) {
					if (data == 20001) {
						libs.userNotLogin('��δ��¼�޷�ִ�д˲�����');
						return false;
					} else if (data == 10004) {
						$.tipMessage('���ִ���10�ֲſ���ȡ��', 1, 2000);
						return false;
					} else {
						$.tipMessage('��������ȡ��', 0, 2000, 0,
						function() {
							location.href = location.href;
						});
					}
				},
				error: function() {
					alert('����ִ���������');
				}
			});
		});
	}
};