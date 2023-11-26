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
						libs.userNotLogin('您未登录无法执行此操作！');
						return false;
					} else if (data == 10004) {
						$.tipMessage('您暂时还没有未领积分！', 1, 2000);
						return false;
					} else {
						$.tipMessage('积分已领取！', 0, 2000, 0,
						function() {
							location.href = location.href;
						});
					}
				},
				error: function() {
					$.tipMessage('数据执行意外错误！', 2, 3000);
				}
			});
		});
	},
	vipRenewals: function() {
		$("#renewals").click(function() {
			$.tipMessage('充值系统即将开放，敬请期待！', 1, 2000);
			return false;
		});
	},
	vipRecharge: function() {
		$("#recharge").click(function() {
			var myDialog = $.dialog({
				id: 'sendMsg',
				title: '充值',
				lock: true,
				okValue: '确认',
				ok: function() {
					var pid = $("input[name=pid]:checked");
					if (pid.val() == undefined) {
						$.tipMessage('请先选择您购买的类型！', 1, 3000);
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
									user.userNotLogin('您未登录无法执行此操作！');
								} else if (data == 10004) {
									$.tipMessage('非法操作，请指定操作对象！', 1, 2000);
									return false;
								} else {
									$.dialog({
										id: 'sendMsg',
										title: '充值',
										lock: true,
										content: data,
										okValue: '确认并支付',
										ok: function() {
											var cd_type = $("input[name=cd_type]:checked");
											if (cd_type.val() == undefined) {
												$.tipMessage('请先选择一种支付方式！', 1, 3000);
												return false;
											} else {
												frmadd.submit();
												return false;
											}
										},
										cancelValue: '取消',
										cancel: function() {}
									});
								}
							}
						});
					}
				},
				cancelValue: '取消',
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
						user.userNotLogin('您未登录无法执行此操作！');
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
						libs.userNotLogin('您未登录无法执行此操作！');
						return false;
					} else if (data == 10004) {
						$.tipMessage('积分大于10分才可领取！', 1, 2000);
						return false;
					} else {
						$.tipMessage('积分已领取！', 0, 2000, 0,
						function() {
							location.href = location.href;
						});
					}
				},
				error: function() {
					alert('数据执行意外错误！');
				}
			});
		});
	}
};