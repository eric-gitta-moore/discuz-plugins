var skinLib = {
	skinUpdate: function() {
		var skinPath = "";
		$(".ornament-content").click(function() {
			skinPath = $(this).attr("skinPath");
			$("#skin").attr("href", zone_domain + "static/space/skin/" + skinPath + "/style.css");
		}).hover(function() {
			var id = $(this).attr("skinId");
			$("#on" + id).show();
		},
		function() {
			$(".click-preview").hide();
		});
		$("#change").click(function() {
			var uid = $(this).attr("uid");
			var BskinPath = $(this).attr("BskinPath");
			var showType = 1;
			if (skinPath != "") {
				$.ajax({
					type: "POST",
					global: false,
					url: zone_domain + "index.php?p=space&a=doSkinUpdate",
					data: {
						'skinPath': skinPath,
						'BskinPath': BskinPath,
						'showType': showType
					},
					dataType: "text",
					success: function(data) {
						if (data == 10000) {
							location.href = zone_domain + "index.php?p=space&uid=" + uid;
							return false;
						} else if (data == 20001) {
							$.tipMessage('����û�е�¼����¼���ܻ�����!', 1, 3000);
							return false;
						} else if (data == 10004) {
							$.tipMessage('�Բ���Ƥ���ѱ�ɾ��', 1, 3000, 0,
							function() {
								location.href = location.href;
							});
							return false;
						} else if (data == 20005) {
							$.tipMessage('�Բ��𣬻��ֲ���', 1, 3000, 0,
							function() {
								location.href = location.href;
							});
							return false;
						}
					},
					error: function() {
						$.tipMessage('����ִ���������', 2, 3000);
					}
				});
				return false;
			} else {
				location.href = zone_domain + "index.php?p=space&uid=" + uid;
			}
		});
		$("#default").click(function() {
			var uid = $(this).attr("uid");
			var BskinPath = $(this).attr("BskinPath");
			var skinPath = "";
			var showType = 0;
			$.ajax({
				type: "POST",
				global: false,
				url: zone_domain + "index.php?p=space&a=doSkinUpdate",
				data: {
					'skinPath': skinPath,
					'BskinPath': BskinPath,
					'showType': showType
				},
				dataType: "text",
				success: function(data) {
					if (data == 10000) {
						location.href = zone_domain + "index.php?p=space&uid=" + uid;
						return false;
					} else if (data == 20001) {
						$.tipMessage('����û�е�¼����¼���ܻ�����!', 1, 3000);
						return false;
					}
				},
				error: function() {
					$.tipMessage('����ִ���������', 2, 3000);
				}
			});
			return false;
		});
	}
}