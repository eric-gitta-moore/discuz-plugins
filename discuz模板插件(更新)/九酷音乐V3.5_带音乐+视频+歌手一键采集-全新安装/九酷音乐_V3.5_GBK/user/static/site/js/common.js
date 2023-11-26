var mpPlayer = {
	iframeId: '',
	play: function(id) {
		if (mpPlayer.iframeId == '') {
			mpPlayer.iframeId = document.getElementById('player').contentWindow
		}
		mpPlayer.iframeId.mp.obj.doPlay(id);
	},
	closeList: function() {
		mpPlayer.iframeId.mp.closeList();
	}
};
var libs = {
	flag: 0,
	adsfix: function(id) {
		var $id = $("#" + id);
		var h = $id.offset().top;
		$(window).bind('scroll',
		function() {
			var top = $(window).scrollTop();
			if (top >= h) {
				if (libs.flag != 1) {
					$id.addClass("adsfix");
					libs.flag = 1;
				}
			} else {
				if (libs.flag != 2) {
					$id.removeClass("adsfix");
					libs.flag = 2;
				}
			}
		});
	},
	checkLogin: function() {
		var $userLogin = $("#userLogin");
		var $userInfo = $("#userInfo");
		var $welcome = $("#welcome");
		var $siteLink = $("#siteLink");
		$.getJSON(zone_domain + "index.php?p=user&a=jsonCheckLogin&callback=?",
		function(data) {
			if (data["uid"] != 0 && data["avatar"] != '') {
				listenMsg.start();
				$welcome.hide();
				$userLogin.show();
				$siteLink.attr({
					'href': zone_domain + 'index.php?p=space&uid=' + data["uid"],
					'vip': data["vip"]
				});
				$userInfo.attr('src', data["avatar"]);
			}
		});
		return false;
	},
	logout: function() {
		var $userLogin = $("#userLogin");
		var $welcome = $("#welcome");
		$.getJSON(zone_domain + "index.php?p=user&a=jsonDoLogout&callback=?",
		function(data) {
			if (data['error'] == 1) {
				$.tipMessage('未登录！', 2, 3000);
			} else {
				$welcome.show();
				$userLogin.hide();
			}
		});
		return false;
	},
	login: function() {
		$.ajax({
			type: "GET",
			global: false,
			url: zone_domain + 'index.php?p=user&a=loginDialog&r=' + Math.random(),
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
		return false;
	},
	select: function(objName, type) {
		if (type == 1) {
			$('#' + objName + ' :checkbox').each(function() {
				if (!$(this).attr('disabled')) {
					$(this).attr('checked', 'checked');
				}
			});
		} else {
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
		}
	},
	changeAuthCode: function() {
		var num = new Date().getTime();
		var rand = Math.round(Math.random() * 10000);
		var num = num + rand;
		$("#authCode").attr('src', zone_domain + "index.php?p=system&a=getVCode&t=" + num);
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
		} else {
			$.tipMessage('您没有选择要连放的音乐！', 1, 3000);
		}
	},
	spaceDanceStatus: function(pageType, category, didStr) {
		$.getJSON(zone_domain + "index.php?p=dance&a=doSpaceStatus&callback=?", "pageType=" + escape(pageType) + "&category=" + escape(category) + "&didStr=" + escape(didStr) + "&keyHash=" + $.cookie('loginKey'),
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
	},
	spaceDanceListSmall: function(listType, num) {
		$.getJSON(zone_domain + "index.php?p=dance&a=indexRecommend&callback=?", "listType=" + escape(listType) + "&num=" + escape(num),
		function(data) {
			var medalHtml = "";
			var i = 0;
			for (var n in data)
			 {
				medalHtml += "<li ";
				if (i == 0) {
					medalHtml += "class='c1'>";
				} else {
					medalHtml += ">";
				}
				medalHtml += "<span class='icon'><a title='" + data[n]['nickname'] + "' target='_blank' href='" + zone_domain + "index.php?p=space&uid=" + data[n]['uid'] + "'><img class='avatar-58' src='" + data[n]['avatar'] + "' onerror=\"pubLibs.avatarError(this,'small');\" alt='" + data[n]['nickname'] + "'></a></span><span class='nickname'><strong><a class='lanse' title='" + data[n]['nickname'] + "' target='_blank' href='" + zone_domain + "index.php?p=space&uid=" + data[n]['uid'] + "'>" + data[n]['nickname'] + "</a></strong>收藏了音乐</span><span class='time'>" + data[n]['create_time'] + "</span><span class='mname'><a href='" + data[n]['dlink'] + "' target='p'>" + data[n]['dance_name'] + "</a></span><a class='add' href='javascript:;' title='添加' onclick='dancePlayer.addPlayer(" + data[n]['did'] + ", 0);'> </a></li>";
				i++;
			}
			$("#listSmall").html(medalHtml);
		});
		return false;
	},
	selectList: function() {
		var closeCardTimer = null;
		var loadTimer = null;
		$(".sList").hover(function() {
			var list = $(this).attr("sid");
			var $this = $(this);
			if (list == "list2") {
				$("#list2").show();
				$("#list3").hide();
				$("#list4").hide();
				$("#list5").hide();
			} else if (list == "list3") {
				$("#list2").hide();
				$("#list3").show();
				$("#list4").hide();
				$("#list5").hide();
			} else if (list == "list4") {
				$("#list2").hide();
				$("#list3").hide();
				$("#list4").show();
				$("#list5").hide();
			} else {
				$("#list2").hide();
				$("#list3").hide();
				$("#list4").hide();
				$("#list5").show();
			}
			$(".sList").parent().removeAttr("class");
			$(this).parent().attr("class", "on");
			if (closeCardTimer != null) {
				clearTimeout(closeCardTimer);
				closeCardTimer = null;
			}
		},
		function() {
			closeCardTimer = setTimeout(function() {
				if (loadTimer != null) {
					clearTimeout(loadTimer);
					loadTimer = null;
				}
			},
			200)
		});
		$(".sLists").hover(function() {
			var list = $(this).attr("sid");
			var $this = $(this);
			if (list == "listHot2") {
				$("#listHot2").show();
				$("#listHot3").hide();
				$("#listHot4").hide();
				$("#listHot5").hide();
			} else if (list == "listHot3") {
				$("#listHot2").hide();
				$("#listHot3").show();
				$("#listHot4").hide();
				$("#listHot5").hide();
			} else if (list == "listHot4") {
				$("#listHot2").hide();
				$("#listHot3").hide();
				$("#listHot4").show();
				$("#listHot5").hide();
			} else {
				$("#listHot2").hide();
				$("#listHot3").hide();
				$("#listHot4").hide();
				$("#listHot5").show();
			}
			$(".sLists").parent().removeAttr("class");
			$(this).parent().attr("class", "on");
			if (closeCardTimer != null) {
				clearTimeout(closeCardTimer);
				closeCardTimer = null;
			}
		},
		function() {
			closeCardTimer = setTimeout(function() {
				if (loadTimer != null) {
					clearTimeout(loadTimer);
					loadTimer = null;
				}
			},
			200)
		});
		$(".indexList").hover(function() {
			var list = $(this).attr("sid");
			var $this = $(this);
			if (list == "indexlist2") {
				$("#indexlist2").show();
				$("#indexlist3").hide();
				$("#indexlist5").hide();
				$("#indexlist1").hide();
			} else if (list == "indexlist3") {
				$("#indexlist3").show();
				$("#indexlist2").hide();
				$("#indexlist5").hide();
				$("#indexlist1").hide();
			} else if (list == "indexlist5") {
				$("#indexlist5").show();
				$("#indexlist3").hide();
				$("#indexlist2").hide();
				$("#indexlist1").hide();
			} else {
				$("#indexlist1").show();
				$("#indexlist3").hide();
				$("#indexlist5").hide();
				$("#indexlist2").hide();
			}
			$(".indexList").parent().removeAttr("class");
			$(this).parent().attr("class", "on");
			if (closeCardTimer != null) {
				clearTimeout(closeCardTimer);
				closeCardTimer = null;
			}
		},
		function() {
			closeCardTimer = setTimeout(function() {
				if (loadTimer != null) {
					clearTimeout(loadTimer);
					loadTimer = null;
				}
			},
			200)
		});
		$(".uDList").hover(function() {
			var list = $(this).attr("sid");
			var $this = $(this);
			if (list == "userRec2") {
				$("#userRec2").show();
				$("#userRec1").hide();
			} else {
				$("#userRec1").show();
				$("#userRec2").hide();
			}
			$(".uDList").parent().removeAttr("class");
			$(this).parent().attr("class", "on");
			if (closeCardTimer != null) {
				clearTimeout(closeCardTimer);
				closeCardTimer = null;
			}
		},
		function() {
			closeCardTimer = setTimeout(function() {
				if (loadTimer != null) {
					clearTimeout(loadTimer);
					loadTimer = null;
				}
			},
			200)
		});
	},
	active: function() {
		$.dialog({
			id: 'delActive',
			title: '提升排名',
			width: '420px',
			lock: true,
			content: '<br/>确认提升排名么？<br/><br/><span style="color: #999999;">提示：每次提升排名需要花费10积分。</span><br/><br/>',
			okValue: '确认',
			ok: function() {
				$.getJSON(zone_domain + "index.php?p=user&a=doRaiseActive&callback=?",
				function(data) {
					if (data["error"] == 20001) {
						user.userNotLogin('您需要先登录才能进行此操作！');
						return false;
					} else if (data["error"] == 10011) {
						$.tipMessage('您还不是活跃用户哦！', 1, 2000);
						return false;
					} else if (data["error"] == 20005) {
						$.tipMessage('抱歉，您的积分不足！', 1, 2000);
						return false;
					} else {
						$.tipMessage('恭喜，提升排名成功！', 0, 1000);
						window.setTimeout('document.location.reload()', 1000);
					}
				});
				return false;
			},
			cancelValue: '取消',
			cancel: function() {}
		});
	}
}
var autoScrollMiniblog = {
	$miniblog: '',
	$ul: '',
	autoFlag: 1,
	type: 1,
	liLength: 0,
	init: function(type) {
		autoScrollMiniblog.type = type;
		autoScrollMiniblog.$miniblog = $("#miniblog");
		autoScrollMiniblog.$ul = autoScrollMiniblog.$miniblog.children("ul:eq(0)");
		var ulHeight = autoScrollMiniblog.$ul.height();
		autoScrollMiniblog.liLength = autoScrollMiniblog.$ul.children("li").length;
		autoScrollMiniblog.$ul.mouseover(function(event) {
			autoScrollMiniblog.autoFlag = 0;
		}).mouseout(function(event) {
			autoScrollMiniblog.autoFlag = 1;
		});
		if (autoScrollMiniblog.liLength > 1) {
			setInterval(autoScrollMiniblog.autoScroll, 3000);
		}
	},
	autoScroll: function() {
		if (autoScrollMiniblog.autoFlag == 1) {
			var $last = autoScrollMiniblog.$ul.children("li:last");
			if (autoScrollMiniblog.type == 1) {
				var lineHeight = $last.height();
				autoScrollMiniblog.$miniblog.height(lineHeight + 16);
			}
			$last.prependTo(autoScrollMiniblog.$ul);
		}
	}
}
var dance = {
	favoritesAdd: function(did, uid) {
		$.getJSON(zone_domain + "index.php?p=dance&a=doFavoritesAdd&callback=?", {
			did: escape(did),
			uid: escape(uid),
			rand: Math.random()
		},
		function(data) {
			var statusHtml1 = "";
			var statusHtml2 = "";
			var statusHtml3 = "";
			if (data['error'] == 10003) {
				$.tipMessage('您已经喜欢过本音乐！', 1, 2000);
				return false;
			} else if (data['error'] == 10011) {
				$.tipMessage('音乐不存在或已被删除！', 1, 2000);
				return false;
			} else if (data['error'] == 10013) {
				$.tipMessage('您不能喜欢自己上传的音乐！', 1, 2000);
				return false;
			} else if (data['error'] == 20001) {
				user.userNotLogin('您需要先登录才能进行此操作!');
				return false;
			} else {
				$.tipMessage('本首音乐喜欢成功！', 0, 2000);
				$("#isLike").removeAttr("class");
				$("#isLike").attr("class", "hover1");
				statusHtml1 = "<a id='likeClick' href='javascript:;' class='likeClick' onClick=\"dance.favoritesSpaceDel(" + did + "," + uid + ");return false;\" title=\"标记为喜欢\">喜欢</a>"
				$("#isLike").html(statusHtml1);
				var statusClass = "";
				statusClass = $("#isDislike").attr("class");
				if (statusClass == "hover2") {
					$("#isDislike").removeAttr("class");
					$("#isDislike").attr("class", "recom_btn");
					statusHtml2 = "<a id='dislikeClick' href='javascript:;' class='dislikeClick' onClick=\"dance.dislikeAdd(" + did + "," + uid + ");return false;\" title=\"标记为讨厌\">讨厌</a>";
					$("#isDislike").html(statusHtml2);
				}
			}
		});
		return false;
	},
	favoritesSpaceDel: function(did, uid) {
		$.getJSON(zone_domain + "index.php?p=dance&a=doFavoritesDel&callback=?", {
			did: escape(did),
			uid: escape(uid),
			rand: Math.random()
		},
		function(data) {
			var statusHtml1 = "";
			var statusHtml2 = "";
			var statusHtml3 = "";
			if (data['error'] == 20001) {
				user.userNotLogin('您需要先登录才能进行此操作!');
				return false;
			} else if (data['error'] == 20002) {
				$.tipMessage('您没有喜欢过此音乐！', 1, 2000);
				return false;
			} else {
				$.tipMessage('操作执行成功！', 0, 2000);
				$("#isLike").removeAttr("class");
				$("#isLike").attr("class", "default_btn");
				statusHtml1 = "<a id='likeClick' href='javascript:;' class='likeClick' onClick=\"dance.favoritesAdd(" + did + "," + uid + ");return false;\" title=\"标记为喜欢\">喜欢</a>";
				$("#isLike").html(statusHtml1);
				var statusClass = "";
				statusClass = $("#isRecommend").attr("class");
				if (statusClass == "hover3") {
					$("#isRecommend").removeAttr("class");
					$("#isRecommend").attr("class", "past_btn");
					var num = "";
					num = $("#recommendNum").attr("num");
					statusHtml3 = "<strong id='recommendNum' num='" + num + "'>" + num + "</strong><a id='recommendClick' href='javascript:;' onClick=\"dance.recommendSpaceUpdate(" + did + "," + uid + ");return false;\" title=\"推荐到我的主页\">推荐</a>";
					$("#isRecommend").html(statusHtml3);
					if (num - 1 < 0) {
						$("#recommendNum").attr("num", "0");
						$("#recommendNum").html(0);
					} else {
						$("#recommendNum").attr("num", --num);
						$("#recommendNum").html(num);
					}
				}
			}
		});
		return false;
	},
	dislikeAdd: function(did, uid) {
		$.getJSON(zone_domain + "index.php?p=dance&a=doDislikeAdd&callback=?", {
			did: escape(did),
			uid: escape(uid),
			rand: Math.random()
		},
		function(data) {
			var statusHtml1 = "";
			var statusHtml2 = "";
			var statusHtml3 = "";
			if (data['error'] == 10003) {
				$.tipMessage('您已经收藏过本音乐！', 1, 2000);
				return false;
			} else if (data['error'] == 10001) {
				$.tipMessage('音乐不存在或已被删除！', 1, 2000);
				return false;
			} else if (data['error'] == 10013) {
				$.tipMessage('您不能讨厌自己上传的音乐！', 1, 2000);
				return false;
			} else if (data['error'] == 20001) {
				user.userNotLogin('您需要先登录才能进行此操作!');
				return false;
			} else {
				$.tipMessage('操作执行成功！', 0, 2000);
				$("#isDislike").removeAttr("class");
				$("#isDislike").attr("class", "hover2");
				statusHtml2 = "<a id='dislikeClick' href='javascript:;' class='dislikeClick' onClick=\"dance.dislikeDel(" + did + "," + uid + ");return false;\" title=\"标记为讨厌\">讨厌</a>";
				$("#isDislike").html(statusHtml2);
				var statusClass = "";
				var statusClass1 = "";
				statusClass = $("#isLike").attr("class");
				if (statusClass == "hover1") {
					$("#isLike").removeAttr("class");
					$("#isLike").attr("class", "default_btn");
					statusHtml1 = "<a id='likeClick' href='javascript:;' class='likeClick' onClick=\"dance.favoritesAdd(" + did + "," + uid + ");return false;\" title=\"标记为喜欢\">喜欢</a>";
					$("#isLike").html(statusHtml1);
				}
				statusClass1 = $("#isRecommend").attr("class");
				if (statusClass1 == "hover3") {
					$("#isRecommend").removeAttr("class");
					$("#isRecommend").attr("class", "past_btn");
					var num = "";
					num = $("#recommendNum").attr("num");
					statusHtml3 = "<strong id='recommendNum' num='" + num + "'>" + num + "</strong><a id='recommendClick' href='javascript:;' onClick=\"dance.recommendSpaceUpdate(" + did + "," + uid + ");return false;\" title=\"收藏到我的主页\">收藏</a>";
					$("#isRecommend").html(statusHtml3);
					if (num - 1 < 0) {
						$("#recommendNum").attr("num", "0");
						$("#recommendNum").html(0);
					} else {
						$("#recommendNum").attr("num", --num);
						$("#recommendNum").html(num);
					}
				}
			}
		});
		return false;
	},
	dislikeDel: function(did, uid) {
		$.getJSON(zone_domain + "index.php?p=dance&a=doDislikeDel&callback=?", {
			did: escape(did),
			uid: escape(uid),
			rand: Math.random()
		},
		function(data) {
			var statusHtml1 = "";
			var statusHtml2 = "";
			var statusHtml3 = "";
			if (data['error'] == 10001) {
				$.tipMessage('音乐不存在或已被删除！', 1, 2000);
				return false;
			} else if (data['error'] == 20001) {
				user.userNotLogin('您需要先登录才能进行此操作!');
				return false;
			} else {
				$.tipMessage('操作执行成功！', 0, 2000);
				$("#isDislike").removeAttr("class");
				$("#isDislike").attr("class", "recom_btn");
				statusHtml2 = "<a id='dislikeClick' href='javascript:;' class='dislikeClick' onClick=\"dance.dislikeAdd(" + did + "," + uid + ");return false;\" title=\"标记为讨厌\">讨厌</a>";
				$("#isDislike").html(statusHtml2);
			}
		});
		return false;
	},
	recommendSpaceUpdate: function(did, uid, type) {
		$.getJSON(zone_domain + "index.php?p=dance&a=doRecommendAdd&callback=?", {
			did: escape(did),
			uid: escape(uid),
			rand: Math.random()
		},
		function(data) {
			var statusHtml1 = "";
			var statusHtml2 = "";
			var statusHtml3 = "";
			if (data['error'] == 20001) {
				user.userNotLogin('您需要先登录才能进行此操作!');
				return false;
			} else if (data['error'] == 10005) {
				$.tipMessage('参数出错了！', 1, 2000);
				return false;
			} else if (data['error'] == 10001) {
				$.tipMessage('音乐不存在或已被删除！', 1, 2000);
				return false;
			} else if (data['error'] == 10013) {
				$.tipMessage('您不能收藏自己的音乐！', 1, 2000);
				return false;
			} else if (data['error'] == 10006) {
				$.tipMessage('您的收藏数量已达最大值！', 1, 2000);
				return false;
			} else if (data['error'] == 20002) {
				$.tipMessage('您已经收藏过此音乐了！', 1, 2000);
				return false;
			} else {
				if (type == 1) {
					$.tipMessage('本首音乐收藏成功！', 0, 2000);
					return false;
				} else {
					$.tipMessage('本首音乐收藏成功！', 0, 2000);
					$("#isRecommend").removeAttr("class");
					$("#isRecommend").attr("class", "hover3");
					var num = "";
					num = $("#recommendNum").attr("num");
					$("#recommendNum").attr("num", ++num);
					statusHtml3 = "<strong id='recommendNum' num='" + num + "'>" + num + "</strong><a id='recommendClick' href='javascript:;' onClick=\"dance.recommendSpaceDel(" + did + "," + uid + ");return false;\" title=\"收藏到我的主页\">收藏</a>";
					$("#isRecommend").html(statusHtml3);
					$("#recommendNum").html(num);
					var statusClass = "";
					statusClass = $("#isDislike").attr("class");
					if (statusClass == "hover2") {
						$("#isDislike").removeAttr("class");
						$("#isDislike").attr("class", "recom_btn");
						statusHtml2 = "<a id='dislikeClick' href='javascript:;' class='dislikeClick' onClick=\"dance.dislikeAdd(" + did + "," + uid + ");return false;\" title=\"标记为讨厌\">讨厌</a>";
						$("#isDislike").html(statusHtml2);
					}
					var statusClass1 = "";
					statusClass1 = $("#isLike").attr("class");
					if (statusClass1 == "default_btn") {
						$("#isLike").removeAttr("class");
						$("#isLike").attr("class", "hover1");
						statusHtml1 = "<a id='likeClick' href='javascript:;' class='likeClick' onClick=\"dance.favoritesSpaceDel(" + did + "," + uid + ");return false;\" title=\"标记为喜欢\">喜欢</a>";
						$("#isLike").html(statusHtml1);
					}
				}
			}
		});
		return false;
	},
	recommendSpaceDel: function(did, uid) {
		$.getJSON(zone_domain + "index.php?p=dance&a=doRecommendDel&callback=?", {
			did: escape(did),
			uid: escape(uid),
			rand: Math.random()
		},
		function(data) {
			var statusHtml1 = "";
			var statusHtml2 = "";
			var statusHtml3 = "";
			if (data['error'] == 20001) {
				user.userNotLogin('您需要先登录才能进行此操作!');
				return false;
			} else {
				$.tipMessage('操作执行成功！', 0, 2000);
				$("#isRecommend").removeAttr("class");
				$("#isRecommend").attr("class", "past_btn");
				var num = "";
				num = $("#recommendNum").attr("num");
				statusHtml3 = "<strong id='recommendNum' num='" + num + "'>" + num + "</strong><a id='recommendClick' href='javascript:;' onClick=\"dance.recommendSpaceUpdate(" + did + "," + uid + ");return false;\" title=\"收藏到我的主页\">收藏</a>";
				$("#isRecommend").html(statusHtml3);
				if (num - 1 < 0) {
					$("#recommendNum").attr("num", "0");
					$("#recommendNum").html(0);
				} else {
					$("#recommendNum").attr("num", --num);
					$("#recommendNum").html(num);
				}
				var statusClass = "";
				statusClass = $("#isLike").attr("class");
				if (statusClass == "hover1") {
					$("#isLike").removeAttr("class");
					$("#isLike").attr("class", "default_btn");
					statusHtml1 = "<a id='likeClick' href='javascript:;' class='likeClick' onClick=\"dance.favoritesAdd(" + did + "," + uid + ");return false;\" title=\"标记为喜欢\">喜欢</a>";
					$("#isLike").html(statusHtml1);
				}
			}
		});
		return false;
	}
};
var rolling = {
	up: function(id) {
		clearInterval(play2);
		var _wrap = $('#' + id + '');
		var _field = _wrap.find('li:last');
		var _h = _field.height();
		_field.prependTo(_wrap);
		rolling.startDown();
	},
	down: function(id) {
		clearInterval(play2);
		var _wrap = $('#' + id + '');
		var _field = _wrap.find('li:first');
		var _h = _field.height();
		_field.appendTo(_wrap);
		rolling.startDown();
	},
	startDown: function() {
		play2 = setTimeout(function() {
			$('.bot').trigger('click');
		},
		10000);
	}
}