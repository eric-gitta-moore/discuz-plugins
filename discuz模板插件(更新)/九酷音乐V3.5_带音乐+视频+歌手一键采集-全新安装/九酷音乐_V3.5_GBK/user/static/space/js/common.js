var libs = {
	praise: function(rvip, mvip, num) {
		$praise = $('.praise_num');
		$praiseCount = $("#praiseCount");
		$praise.mouseover(function() {
			if (rvip == 0 && mvip == 0) {
				$praiseCount.html("+1");
			} else {
				$praiseCount.html("+2");
			}
		}).mouseout(function() {
			$praiseCount.html(num);
		});
	},
	allSelect: function(objName) {
		$('#' + objName + ' :checkbox').each(function() {
			if (!$(this).attr('disabled')) {
				$(this).attr('checked', 'checked');
			}
		});
	},
	otherSelect: function(objName) {
		$('#' + objName + ' :checkbox').each(function() {
			if ($(this).attr('checked')) {
				$(this).removeAttr('checked');
			}
			 else {
				if (!$(this).attr('disabled')) {
					$(this).attr('checked', 'checked');
				}
			}
		});
	},
	login: function() {
		$.ajax({
			type: "POST",
			global: false,
			url: zone_domain + 'index.php?p=user&a=loginDialog',
			dataType: "text",
			success: function(data) {
				$.dialog({
					id: 'login',
					title: '会员登录',
					content: data,
					lock: true
				});
			}
		});
	},
	spaceInit: function() {
		upTop.init();
	},
	spaceHomeInit: function() {
		$("#wallContent").elastic({
			maxHeight: 130
		}).emotEditor({
			allowed: 300,
			charCount: true,
			emot: true,
			newLine: true
		});
		upTop.init();
		$('#selectAllaa').click(function() {
			$('#list :checkbox').each(function() {
				if (!$(this).attr('disabled')) {
					$(this).attr('checked', 'checked');
				}
			});
		});
		$('#selectOtheraa').click(function() {
			$('#list :checkbox').each(function() {
				if ($(this).attr('checked')) {
					$(this).removeAttr('checked');
				} else {
					if (!$(this).attr('disabled')) {
						$(this).attr('checked', 'checked');
					}
				}
			});
		});
	},
	player: function(objName) {
		var isiPad = navigator.userAgent.match(/iPad|iPhone|iPod/i) != null;
		if (isiPad) {
			$.tipMessage('iPad、iPhone、iPod设备的连播功能即将开放，敬请期待！', 1, 3000);
			return;
		}
		var mIdSrt = '';
		$('#' + objName + ' :checkbox').each(function() {
			if ($(this).attr('checked')) {
				mIdSrt += '{song}' + $(this).val() + ',';
			}
		});
		if (mIdSrt) {
			window.open(site_domain + 'play.php?id=' + mIdSrt.substr(0, mIdSrt.length - 1), 'p');
		}
		 else {
			$.tipMessage('您没有选择要连放的音乐！', 1, 3000);
		}
	},
	changeAuthCode: function() {
		var num = new Date().getTime();
		var rand = Math.round(Math.random() * 10000);
		var num = num + rand;
		$("#authCode").attr('src', zone_domain + "index.php?p=system&a=getVCode&t=" + num);
	},
	cityPopup: function(objName) {
		$("#" + objName).cityPopup({
			popupDistance: "-160",
			popupLeft: "2",
			popupWidth: "680",
			level: "3"
		});
	},
	reloadcode: function(_id) {
		if (_id != '') {
			$('#' + _id).attr('src', zone_domain + 'index.php?p=system&a=getVCode&rand=' + Math.random());
		}
	},
	redirect: function(url) {
		location.href = url;
	},
	imageError: function(obj) {
		obj.onerror = null;
		obj.src = zone_domain + "static/images/none.gif";
	},
	feed: function() {
		var cid = 0;
		$.ajax({
			type: "POST",
			global: false,
			url: zone_domain + "index.php?p=feed&a=fetchFeed",
			data: {
				cid: cid
			},
			dataType: "text",
			success: function(data) {
				if (data == 20001) {
					$.tipMessage('您没有登录或已经退出，请登录后再进行操作！', 1, 3000);
					location.href = zone_domain + 'index.php?p=user&a=login';
				} else {
					$("#feed").html(data);
					cid = $("#feedItem").attr('cid');
					$(".current").removeClass('current');
					if (typeof cid == "undefined" || cid == 0) {
						$('#a1').show();
						$("#a2").hide();
						$("#a3").hide();
						$("#feed_all").removeClass('on');
						$("#friend_feed").addClass('on');
						$("#feed_me").removeClass('on');
						var $targetLink = $('#feed_' + 0)
					} else if (cid == 2) {
						$('#a1').hide();
						$("#a2").show();
						$("#a3").hide();
						$("#friend_feed").removeClass('on');
						$("#feed_me").removeClass('on');
						$("#feed_all").addClass('on');
						var $targetLink = $('#feedA_' + 0)
					}
					$targetLink.addClass('current');
				}
			}
		});
	},
	feedNew: function(cid) {
		$(".current").removeClass('current');
		if (typeof cid == "undefined" || cid == 0) {
			$('#a1').show();
			$("#a2").hide();
			$("#a3").hide();
			$("#feed_all").removeClass('on');
			$("#friend_feed").addClass('on');
			$("#feed_me").removeClass('on');
			var $targetLink = $('#feed_' + 0)
		} else if (cid == 2) {
			$('#a1').hide();
			$("#a2").show();
			$("#a3").hide();
			$("#friend_feed").removeClass('on');
			$("#feed_me").removeClass('on');
			$("#feed_all").addClass('on');
			var $targetLink = $('#feedA_' + 0)
		} else if (cid == 3) {
			$('#a1').hide();
			$("#a2").hide();
			$("#a3").show();
			$("#feed_all").removeClass('on');
			$("#friend_feed").removeClass('on');
			$("#feed_me").addClass('on');
			var $targetLink = $('#feedM_' + 0)
		}
		$targetLink.addClass('current');
		$.ajax({
			type: "POST",
			global: false,
			url: zone_domain + "index.php?p=feed&a=fetchFeed",
			data: {
				cid: cid
			},
			dataType: "text",
			success: function(data) {
				$("#feed").html(data);
			}
		});
	},
	currItem: 0,
	showFeedMenu: function(type, cid) {
		var $feed = $("#feed");
		if (cid == 0) {
			var $currLink = $('#feed_' + libs.currItem);
			var $targetLink = $('#feed_' + type);
		} else if (cid == 2) {
			var $currLink = $('#feedA_' + libs.currItem);
			var $targetLink = $('#feedA_' + type);
		} else if (cid == 3) {
			var $currLink = $('#feedM_' + libs.currItem);
			var $targetLink = $('#feedM_' + type);
		}
		$(".current").removeClass('current');
		$targetLink.addClass('current');
		libs.currItem = type;
		$.ajax({
			type: "POST",
			global: false,
			url: zone_domain + "index.php?p=feed&a=fetchFeed",
			data: {
				'type': type,
				cid: cid
			},
			dataType: "text",
			success: function(data) {
				if (data == 20001) {
					$.tipMessage('您没有登录或已经退出，请登录后再进行操作！', 1, 3000);
					location.href = zone_domain + 'index.php?p=user&a=login';
				} else {
					$feed.html(data);
				}
			}
		});
	},
	showFeedMenu1: function() {
		$("#refresh").click(function() {
			var cid = $(this).attr("cid");
			var type = $(this).attr("type");
			var $feed = $("#feed");
			$.ajax({
				type: "POST",
				global: false,
				url: zone_domain + "index.php?p=feed&a=fetchFeed",
				data: {
					'type': type,
					cid: cid
				},
				dataType: "text",
				success: function(data) {
					if (data == 20001) {
						$.tipMessage('您没有登录或已经退出，请登录后再进行操作！', 1, 3000);
						location.href = zone_domain + 'index.php?p=user&a=login';
					} else {
						$feed.html(data);
					}
				}
			});
		});
	},
	userSign1: function() {
		$.ajax({
			type: "POST",
			global: false,
			url: zone_domain + "index.php?p=user&a=userSign",
			dataType: "text",
			success: function(data) {
				if (data == 20001) {
					user.userNotLogin('您未登录无法执行此操作！');
				} else if (data == 10002) {
					$.tipMessage('今天已经签过到了！', 1, 3000);
					return false;
				} else {
					$("#time").html(data);
					var num = 0;
					if (data >= 3) {
						num = 50;
						if (data >= 10) {
							num = 100;
						}
					} else {
						num = 30;
					}
					$.tipMessage('签到成功，已领取' + num + '积分。', 0, 3000);
				}
			}
		});
	},
	userSign: function() {
		$("#user_sign_but").attr('disabled', "disabled");
		$.getJSON(zone_domain + "index.php?p=user&a=userSign&callback=?",
		function(data) {
			if (data['error'] == 20001) {
				user.userNotLogin('您未登录无法执行此操作！');
				$("#user_sign_but").removeAttr('disabled');
			} else if (data['error'] == 10002) {
				$.tipMessage('今天已经签过到了！', 1, 3000);
				$("#user_sign_but").removeAttr('disabled');
				return false;
			} else if (data['error'] == 20007) {
				$.ajax({
					type: "POST",
					global: false,
					url: zone_domain + "index.php?p=user&a=userLast",
					dataType: "text",
					success: function(data) {
						$.dialog({
							id: 'userlast',
							title: '会员签到',
							content: ' ' + data + '',
							lock: true
						});
						$("#user_sign_but").removeAttr('disabled');
					}
				});
			} else {
				var num = $("#user_sign").attr('num');
				if (num != 0) {
					var num1 = ++num;
				} else {
					var num1 = 1;
				}
				$("#time").html(data["sign_num"]);
				$("#user_sign").attr({
					'title': "已经连续签到" + data["sign_num"] + "天, 累计签到" + num1 + "天"
				});
				$.tipMessage('签到成功，已领取' + data['score'] + '积分。', 0, 3000);
				$("#user_sign_but").removeAttr('disabled');
			}
		});
		return false;
	},
	rand: function() {
		$.ajax({
			type: "POST",
			global: false,
			url: zone_domain + "index.php?p=user&a=userSlot",
			dataType: "text",
			success: function(data) {
				$("#rand").show();
				$("#rand").html(data);
			}
		});
	},
	homeguest: function(uid) {
		$.ajax({
			type: "POST",
			global: false,
			url: zone_domain + "index.php?p=space&a=doGuest",
			data: {
				uid: uid
			},
			dataType: "text",
			success: function(data) {
				$("#ListGuest").html(unescape(data));
			}
		});
	}
};
var upTop = {
	defaults: {
		right: 20,
		bottom: 30
	},
	isIe6: ($.browser.msie && parseInt($.browser.version) == 6) ? true: false,
	isPad: navigator.userAgent.match(/iPad|iPhone|iPod|Android/i) != null,
	mask: '',
	$this: '',
	$doc: '',
	$win: '',
	init: function() {
		if (! (this.isIe6 && screen.width < 1000) && !this.isPad) {
			if (this.isIe6) {
				this.mask = '<iframe frameborder="0" scrolling="no" class="ie6_mask"></iframe>';
			}
			$("body").append('<div id="top_control" class="top_control" title="返回顶部">' + this.mask + '<span></span></div>');
			this.$this = $('#top_control');
			this.$doc = $(document);
			this.$win = $(window);
			if (this.isIe6) {
				this.$this.css('position', 'absolute').click(function() {
					$("html, body").animate({
						scrollTop: 0
					},
					120);
				});
				this.resize();
				this.show();
				this.$win.bind({
					"scroll": this.scroll,
					"resize": this.resize
				});
			}
			 else {
				this.$this.css({
					position: 'fixed',
					right: this.defaults.right,
					bottom: this.defaults.bottom
				}).click(function() {
					$("html, body").animate({
						scrollTop: 0
					},
					120);
				});
				this.show();
				this.$win.bind({
					"scroll": this.scroll
				});
			}
		}
	},
	scroll: function() {
		upTop.show();
		if (upTop.isIe6) {
			var topTemp = upTop.$doc.scrollTop() + upTop.$win.height() - upTop.$this.height() - upTop.defaults.bottom;
			var leftTemp = upTop.$doc.scrollLeft() + upTop.$win.width() - upTop.$this.width() - upTop.defaults.right;
			upTop.$this.css({
				top: topTemp,
				left: leftTemp
			});
		}
	},
	show: function() { (upTop.$doc.scrollTop() > 100) ? upTop.$this.show() : upTop.$this.hide();
	},
	resize: function() {
		if (upTop.$doc.scrollTop() + upTop.$win.height() > upTop.$doc.height()) {
			var topTemp = upTop.$doc.height() - upTop.$this.height() - upTop.defaults.bottom;
		}
		 else {
			var topTemp = upTop.$doc.scrollTop() + upTop.$win.height() - upTop.$this.height() - upTop.defaults.bottom;
		}
		if (upTop.$win.width() == upTop.$doc.width()) {
			var leftTemp = upTop.$doc.width() - upTop.$this.width() - upTop.defaults.right;
		}
		 else {
			if (upTop.$doc.width() > screen.width) {
				var leftTemp = upTop.$win.width() - upTop.$this.width() - upTop.defaults.right;
			}
			 else {
				var leftTemp = upTop.$doc.scrollLeft() + upTop.$win.width() - upTop.$this.width() - upTop.defaults.right;
			}
		}
		upTop.$this.css({
			top: topTemp,
			left: leftTemp
		});
	}
};
var appSendMoney = {
	money: function(val) {
		if (val <= 30) {
			text = "恭喜您获得本时段空间奖励" + val + "积分";
		} else if (val <= 60) {
			text = "嗯，还不错哦！您获得了本时段空间奖励" + val + "积分";
		} else if (val <= 90) {
			text = "哇塞，您的人品不错哦！本次获得了" + val + "积分";
		} else if (val <= 100) {
			text = "您的人品大爆发啦，本次获得了" + val + "积分";
		}
		$(document).ready(function() {
			setTimeout(function() {
				$.dialog({
					id: 'money',
					title: '奖励',
					content: text,
					okValue: '领取奖励',
					ok: function() {}
				});
			},
			1000);
		});
	}
};
var message = {
	msgSendInit: function(uid, uidKey, sessionUid) {
		if (uid != sessionUid) {
			$.ajax({
				type: "POST",
				global: false,
				url: zone_domain + "index.php?p=message&a=msgSendDialog",
				data: {
					'uidKey': uidKey
				},
				dataType: "text",
				success: function(data) {
					if (data == 20001) {
						user.userNotLogin('您未登录无法执行此操作！');
						return false;
					} else if (data == 10004) {
						$.tipMessage('用户不存在！', 1, 3000);
						return false;
					} else {
						$.dialog({
							id: 'sendMsg',
							title: '发送私信',
							width: '340px',
							lock: true,
							content: data,
							okValue: '确认',
							ok: function() {
								var $fnote = $("#fnote");
								var validCharLength = $fnote.emotEditor("validCharLength");
								if (validCharLength < 1 || $fnote.emotEditor("content") == "") {
									$.tipMessage('请输入消息内容', 1, 3000);
									$fnote.emotEditor("focus");
									return false;
								}
								if ($fnote.html().length < 501) {
									var uid = $("#uid").attr("uid");
									$.ajax({
										type: "POST",
										global: false,
										url: zone_domain + "index.php?p=message&a=doMsgAdd",
										data: {
											'uid': uid,
											'note': escape($fnote.emotEditor("content"))
										},
										dataType: "text",
										success: function(data) {
											if (data == 20001) {
												user.userNotLogin('您未登录无法执行此操作！');
											} else if (data == 10013) {
												$.tipMessage('您不能给自己发私信！', 1, 3000);
												return false;
											} else if (data == 10007) {
												$.tipMessage('请先写点什么吧！', 1, 3000);
												return false;
											} else if (data == 10004) {
												$.tipMessage('对不起，用户不存在！', 1, 3000);
												return false;
											} else if (data == 20002) {
												$.tipMessage('五级以上用户才可以发私信！', 1, 2500);
												return false;
											} else {
												$.tipMessage('私信已发出！', 0, 3000);
											}
										}
									});
								} else {
									$.tipMessage('您写的太多了，我装不下了！', 1, 3000);
									$fnote.focus();
									return false;
								}
							},
							cancelValue: '取消',
							cancel: function() {}
						});
					}
				}
			});
		} else {
			$.tipMessage('对不起，您不能给自己发私信！', 1, 2000);
			return false;
		}
	}
};
var spaceDance = {
	spaceDanceStatus: function(status) {
		if (didStr != "") {
			if (status == "love" || status == "past") {
				var didArr = new Array();
				didArr = didStr.split(",");
				if (status == "love") {
					for (i = 0; i < didArr.length; i++) {
						$("#d" + didArr[i]).html("<b class='love' title='我喜欢的'> </b>");
					}
				} else {
					for (i = 0; i < didArr.length; i++) {
						$("#d" + didArr[i]).html("<b class='past' title='我最近听过'> </b>");
					}
				}
			} else {
				$.getJSON(zone_domain + "index.php?p=dance&a=doSpaceStatus&callback=?", "pageType=&page=0&didStr=" + escape(didStr),
				function(data) {
					if (data['favorite'].length != 0) {
						for (i = 0; i < data['favorite'].length; i++) {
							$("#d" + data['favorite'][i]).html("<b class='love' title='我喜欢的'> </b>");
						}
					}
					if (data['dislike'].length != 0) {
						for (i = 0; i < data['dislike'].length; i++) {
							$("#d" + data['dislike'][i]).html("<b class='dislike' title='我讨厌的'> </b>");
						}
					}
					if (data['past'].length != 0) {
						for (i = 0; i < data['past'].length; i++) {
							$("#d" + data['past'][i]).html("<b class='past' title='我最近听过'> </b>");
						}
					}
				});
				return false;
			}
		}
	}
};