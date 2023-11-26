var baseDomain = window.location.host.match(/[0-9a-zA-Z]+\.(com|net|cn|in)+/g);
var browser = {};
var ua = navigator.userAgent.toLowerCase();
var browserStr; (browserStr = ua.match(/msie ([\d]+)/)) ? browser.ie = browserStr[1] : (browserStr = ua.match(/firefox\/([\d]+)/)) ? browser.firefox = browserStr[1] : (browserStr = ua.match(/chrome\/([\d]+)/)) ? browser.chrome = browserStr[1] : (browserStr = ua.match(/opera.([\d]+)/)) ? browser.opera = browserStr[1] : (browserStr = ua.match(/version\/([\d]+).*safari/)) ? browser.safari = browserStr[1] : 0;
var isPad = navigator.userAgent.match(/iPad|iPhone|iPod|Android/i) != null;
if (browser.ie == 6) {
	window.attachEvent("onunload",
	function() {
		for (var id in jQuery.cache) {
			if (jQuery.cache[id].handle) {
				try {
					jQuery.event.remove(jQuery.cache[id].handle.elem);
				} catch(e) {}
			}
		}
	});
}
 (function($) {
	jQuery.cookie = function(key, value, options) {
		if (arguments.length > 1 && (value === null || typeof value !== "object")) {
			options = jQuery.extend({},
			options);
			if (value === null) {
				options.expires = -1;
			}
			if (typeof options.expires === 'number') {
				var days = options.expires,
				t = options.expires = new Date();
				t.setDate(t.getDate() + days);
			}
			return (document.cookie = [encodeURIComponent(key), '=', options.raw ? String(value) : encodeURIComponent(String(value)), options.expires ? '; expires=' + options.expires.toUTCString() : '', options.path ? '; path=' + options.path: '', options.domain ? '; domain=' + options.domain: '', options.secure ? '; secure': ''].join(''));
		}
		options = value || {};
		var result,
		decode = options.raw ?
		function(s) {
			return s;
		}: decodeURIComponent;
		return (result = new RegExp('(?:^|; )' + encodeURIComponent(key) + '=([^;]*)').exec(document.cookie)) ? decode(result[1]) : null;
	};
})(jQuery); (function($) {
	jQuery.tipMessage = function(msg, type, time, zIndex, callback) {
		if (typeof tipMessageTimeoutId !== 'number') {
			tipMessageTimeoutId = 0;
		}
		if (typeof time !== 'number') {
			time = 2000;
		}
		if (typeof zIndex !== 'number' || zIndex == 0) {
			zIndex = 65500;
		}
		var $doc = $(document);
		var $win = $(window);
		var $tipMessage = $('#tipMessage');
		var _typeTag = '';
		var _newTop = 0;
		var _newLeft = 0;
		var _width = 0;
		var _NumCount = 1;
		var _mask = "";
		if ($tipMessage.length <= 0) {
			$("body").append('<div id="tipMessage" class="tip_message" ></div>');
			$tipMessage = $('#tipMessage');
		}
		 else {
			if (browser.ie == 6 || browser.ie == 7) {
				$tipMessage.css({
					width: '99%'
				});
			}
			 else {
				$tipMessage.css({
					width: 'auto'
				});
			}
		}
		$tipMessage.css({
			opacity: 0,
			zIndex: zIndex
		});
		clearTimeout(tipMessageTimeoutId);
		if (type == 1) {
			_typeTag = 'hits';
		}
		 else if (type == 2) {
			_typeTag = 'fail';
		}
		 else {
			_typeTag = 'succ';
		}
		if (browser.ie == 6) {
			_mask = '<iframe frameborder="0" scrolling="no" class="ie6_mask"></iframe>';
		}
		$tipMessage.html(_mask + '<div class="tip_message_content"><span class="tip_ico_' + _typeTag + '"></span><span class="tip_content" id="tip_content">' + msg + '</span><span class="tip_end"></span></div>').show();
		function _calculate() {
			_width = $('#tip_content').width() + 86;
			if ($doc.scrollTop() + $win.height() > $doc.height()) {
				_newTop = $doc.height() - $win.height() / 2 - 40;
			}
			 else {
				_newTop = $doc.scrollTop() + $win.height() / 2 - 40;
			}
			if ($win.width() >= $doc.width()) {
				_newLeft = $doc.width() / 2 - _width / 2;
			}
			 else {
				if ($win.width() <= _width) {
					if ($doc.scrollLeft() + $win.width() + (_width - $win.width()) / 2 > $doc.width()) {
						_newLeft = $doc.width() - _width;
					}
					 else {
						_newLeft = $doc.scrollLeft() + $win.width() / 2 - _width / 2;
					}
				}
				 else {
					_newLeft = $doc.scrollLeft() + $win.width() / 2 - _width / 2;
				}
			}
			if (_newLeft < 0) {
				_newLeft = 0;
			}
		}
		_calculate();
		$tipMessage.css({
			top: _newTop,
			left: _newLeft,
			width: _width,
			opacity: 10
		});
		function _reSet() {
			_calculate();
			$tipMessage.css({
				top: _newTop,
				left: _newLeft,
				width: _width
			});
		}
		function _resize() {
			if (_NumCount % 2 == 0) {
				_reSet();
				_NumCount = 1;
			}
			 else {++_NumCount;
			}
		}
		if (!isPad) {
			$win.bind({
				"scroll": _reSet,
				"resize": _resize
			});
		}
		tipMessageTimeoutId = setTimeout(function() {
			$tipMessage.remove();
			if (typeof callback == 'function') {
				callback.call();
			}
		},
		time);
	};
})(jQuery);
var core = {
	getPage: function(maxpage, path) {
		var pageNum = parseInt($("#pageNum").val());
		if (pageNum == "") {
			$.tipMessage("请输入要转向的页数！", 2, 3000);
		} else if (parseInt(maxpage) < pageNum) {
			$.tipMessage("本类最大页数为" + maxpage + "！", 2, 3000);
		} else if (pageNum < 1 || !pageNum) {
			$.tipMessage("请输入正确的页数！", 2, 3000);
		} else {
			if (path == undefined) {
				window.location.href = "../" + pageNum + "/";
			} else {
				window.location.href = path.replace("!!PageNum!!", pageNum);
			}
		}
	}
}
var user = {
	userNotLogin: function(msg) {
		$.tipMessage(msg, 1, 3000, 0,
		function() {
			libs.login();
		});
	},
	loginInit: function(tid) {
		$('#vCode').focus(function() {
			$(this).addClass('input_size');
			$(this).val("");
		});
		$("#authCode").click(function() {
			libs.changeAuthCode();
			return false;
		});
		$('#changeAuthCode').click(function() {
			libs.changeAuthCode();
			return false;
		});
		var $url = $("#refer").val();
		var $loginName = $("#loginName");
		var $password = $("#password");
		var $vCode = $('#vCode');
		var $errMessage = $('#errMessage');
		$("#submit2").click(function() {
			if ($loginName.val() == '' || $loginName.val() == '登录账号') {
				$errMessage.html('请输入正确的账号！').show();
				$loginName.val('').focus();
				return false;
			} else if ($loginName.val().length < 3) {
				$errMessage.html('账号长度应大于3位！').show();
				$loginName.focus();
				return false;
			} else if ($password.val() == '') {
				$errMessage.html('登录密码不能为空！').show();
				$password.val('').focus();
				return false;
			} else if ($password.val().length < 6) {
				$errMessage.html('密码长度应大于6位！').show();
				$password.focus();
				return false;
			} else if ($vCode.val() == '') {
				$errMessage.html('请输入验证码。').show();
				$vCode.focus();
				return false;
			} else if ($vCode.val().length != 4) {
				$errMessage.html('请正确输入四位验证码。').show();
				$vCode.focus();
				return false;
			}
			$errMessage.html('登录中，请稍后...').show();
			$.getJSON(zone_domain + "source/module/user/ajax.php?ac=dologin&callback=?", "loginName=" + escape($loginName.val()) + "&password=" + escape($password.val()) + "&vCode=" + escape($vCode.val()),
			function(data) {
				if (data['error'] == 001) {
					$errMessage.html('验证码不正确！').show();
					$vCode.val('').focus();
					$('#vCode').val("");
					libs.changeAuthCode();
					return false;
				} else if (data['error'] == 002) {
					$.dialog.get('login').close();
					location.href = zone_domain + 'index.php?p=user&a=callback&uc=o_in';
				} else if (data['error'] == 003) {
					$errMessage.html('账号已被锁定！').show();
					$('#vCode').val("");
					libs.changeAuthCode();
					return false;
				} else if (data['error'] == 004) {
					$.dialog.get('login').close();
					location.href = zone_domain + 'index.php?p=user&a=callback&uc=o_in';
				} else if (data['error'] == 005) {
					$.dialog.get('login').close();
					parent.location.reload();
				} else if (data['error'] == 006) {
					$errMessage.html('账号或密码错误！').show();
					$('#vCode').val("");
					libs.changeAuthCode();
					return false;
				} else if (data['error'] == 10000) {
					if (tid != undefined) {
						if ($url != undefined) {
							location.href = $url;
						} else {
							location.href = zone_domain + 'index.php?p=system&a=home';
						}
					} else {
						$("#welcome").hide();
						$("#userLogin").show();
						$("#siteLink").attr({
							'href': zone_domain + 'index.php?p=space&uid=' + data["uid"],
							'vip': data["vip"]
						});
						$("#userInfo").attr('src', site_domain + 'data/attachment/avatar/' + data["avatar"]);
						var dialogObj = $.dialog.get('login');
						if (typeof dialogObj == 'object') {
							dialogObj.close();
						}
					}
				}
			});
			return false;
		});
	},
	praiseUser: function(uid, nickname, rvip, mvip, num, id) {
		$praise = $('.praise_num');
		$praiseCount = $("#praiseCount");
		if (id == 1) {
			var mvip = $("#siteLink").attr('vip');
			if (typeof mvip == 'undefined') {
				mvip = 0;
			}
		}
		$.getJSON(zone_domain + "index.php?p=user&a=doUserPraiseUpdate&callback=?", "uid=" + uid,
		function(data) {
			if (data['error'] == 20001) {
				user.userNotLogin('您未登录无法执行此操作！');
			} else if (data['error'] == 10002) {
				$.tipMessage('您最近刚刚赞过 <strong>' + nickname + '</strong>！', 1, 3000);
			} else if (data['error'] == 10013) {
				$.tipMessage('您只能赞别人，不能赞自己哦!', 1, 3000);
			} else if (data['error'] == 10004) {
				$.tipMessage('该用户不存在', 2, 3000);
			} else {
				if (id == 1) {
					$("#love").remove();
					var $doc = $(document);
					if (rvip == 0 && mvip == 0) {
						$("body").append("<div id='love' class='charm'></div>");
					} else {
						$("body").append("<div id='love' class='charm2'></div>");
					}
					var $love = $("#love");
					$love.css({
						top: $doc.scrollTop() + 200
					});
					$love.animate({
						top: $doc.scrollTop() + 100,
						opacity: "show"
					},
					500);
					setTimeout(function() {
						$love.animate({
							top: $doc.scrollTop(),
							opacity: 'hide'
						},
						600,
						function() {
							$praiseCount.animate({
								paddingTop: "25px",
								height: 'toggle'
							},
							400,
							function() {
								$praiseCount.css({
									paddingTop: "0px"
								}).html(data['right']).slideDown();
								$praise.unbind('mouseover mouseout');
							});
						});
					},
					1000);
				} else {
					$praiseCount.html(num);
					if (rvip == 0 && mvip == 0) {
						$("body").append("<div id='love' class='charm'></div>");
					} else {
						$("body").append("<div id='love' class='charm2'></div>");
					}
					var $love = $("#love");
					$love.animate({
						top: "300px",
						opacity: "show"
					},
					500);
					setTimeout(function() {
						$love.animate({
							top: '100px',
							opacity: 'hide'
						},
						600,
						function() {
							$praiseCount.animate({
								paddingTop: "25px",
								height: 'toggle'
							},
							400,
							function() {
								$praiseCount.css({
									paddingTop: "0px"
								}).html(data['right']).slideDown();
								$praise.unbind('mouseover mouseout');
							});
						});
					},
					1000);
				}
			}
		});
		return false;
	},
	loginCss: function() {
		$("#loginName").focus(function() {
			$(".username").addClass('input_focus');
		}).blur(function() {
			$(".username").removeClass('input_focus');
		});
		$("#password").focus(function() {
			$(".password").addClass('input_focus');
		}).blur(function() {
			$(".password").removeClass('input_focus');
		});
	}
};
var listenMsg = {
	id: 0,
	sleepTime: 10 * 1000,
	titleCount: 0,
	oldTitle: '',
	sound: 0,
	start: function() {
		listenMsg.doListen();
	},
	stop: function() {
		clearTimeout(listenMsg.id);
		listenMsg.id = 0;
	},
	title: function() {
		listenMsg.titleCount++;
		if (listenMsg.titleCount > 20) {
			document.title = listenMsg.oldTitle;
			return false;
		}
		 else if (listenMsg.titleCount % 2 == 0) {
			document.title = '【新通知】 - ' + listenMsg.oldTitle;
		}
		 else {
			document.title = '【　　　】 - ' + listenMsg.oldTitle;
		}
		setTimeout("listenMsg.title()", 1000);
	},
	doListen: function() {
		$.getJSON(zone_domain + "index.php?p=message&a=checkNewNotification&callback=?&rand=" + Math.random(),
		function(data) {
			if (data['error'] == 20001) {
				listenMsg.stop();
				$("#msgTips").hide();
			} else {
				if (data['mnew'] > 0) {
					var player = '';
					if (listenMsg.sound == 0) {
						if (data['sound'] == 1) {
							listenMsg.oldTitle = document.title;
							listenMsg.title();
							player = '<embed style="position:absolute;top:-100000px" width="0" height="0" type="application/x-shockwave-flash" swliveconnect="true" allowscriptaccess="sameDomain" menu="false" flashvars="sFile=' + zone_domain + 'static/swf/notification.mp3" src="' + zone_domain + 'static/swf/soundPlayer.swf" />';
						}
					}
					$("#msgTips").html('<b>' + data['mnew'] + '</b>' + player).show();
					listenMsg.sound = 1;
				} else {
					$("#msgTips").hide();
				}
				if (data['fnew'] > 0) {
					$("#feedTips").html('<b>' + data['fnew'] + '</b>').show();
				} else {
					$("#feedTips").hide();
				}
				listenMsg.id = setTimeout(listenMsg.doListen, listenMsg.sleepTime);
			}
		});
		return false;
	}
};
var dancePlayer = {
	addDance: function(didStr) {
		didStr += "";
		var cookieInfo = $.cookie("playerTemporaryList");
		var infos = "";
		var didInfo = new Array();
		var currentStr = "";
		var currentStrL = "";
		var currentStrR = "";
		if (cookieInfo != null && cookieInfo != '') {
			cookieInfo = cookieInfo.split(",");
			didInfo = didStr.split(",");
			var N = cookieInfo.length - 1;
			for (var i = 0; i < N; i++) {
				var exist = $.inArray(cookieInfo[i], didInfo);
				if (exist >= 0) {
					currentStrR += cookieInfo[i] + ",";
					delete didInfo[exist];
				} else {
					currentStrR += cookieInfo[i] + ",";
				}
			}
			for (index in didInfo) {
				currentStrL += didInfo[index] + ",";
			}
			currentStr = currentStrL + currentStrR;
		} else {
			didInfo = didStr.split(",");
			didInfo.reverse();
			for (index in didInfo) {
				currentStr += didInfo[index] + ",";
			}
		}
		$.cookie('playerTemporaryList', currentStr, {
			path: '/',
			expires: 24 * 3600,
			domain: baseDomain
		});
		var cookieInfo = $.cookie("playerTemporaryList");
	},
	addPlayer: function(did) {
		dancePlayer.addDance(did);
		if (1 != $.cookie('openPlayer')) {
			window.open(site_domain + 'index.php/song/' + did + '/', 'p');
		}
		 else {
			setTimeout(function() {
				$.tipMessage('音乐已添加到列表！', 0, 1000);
			},
			500);
		}
	},
	addPlayerMore: function(didStr) {
		dancePlayer.addDance(didStr);
		if (1 != $.cookie('openPlayer')) {
			var didInfo = new Array();
			didInfo = didStr.split(",");
			window.open(site_domain + 'index.php/song/' + didInfo[0] + '/', 'p');
		} else {
			setTimeout(function() {
				$.tipMessage('音乐已添加到列表！', 0, 1000);
			},
			500);
		}
	},
	selectAllDance: function(list, ButtonId) {
		var $buttons = $("#selectAll" + ButtonId);
		var className = $buttons.attr('class');
		if (className == "select_all") {
			$('#' + list + ' :checkbox').each(function() {
				$(this).attr('checked', 'checked');
			});
			$buttons.removeAttr("class");
			$buttons.attr("class", "on_select_all");
		} else {
			$('#' + list + ' :checkbox').each(function() {
				$(this).removeAttr('checked');
			});
			$buttons.removeAttr("class");
			$buttons.attr("class", "select_all");
		}
	},
	playDance: function(list) {
		var didStr = '';
		$('#' + list + ' input:checked').each(function() {
			if ($(this).val() != '') {
				didStr += '{song}' + $(this).val() + ',';
			}
		});
		if (didStr != '') {
			window.open(site_domain + 'play.php?id=' + didStr.substr(0, didStr.length - 1), 'p');
		} else {
			$.tipMessage('请选择要播放的音乐！', 1, 2000);
		}
	},
	addInList: function(list) {
		var didStr = '';
		$('#' + list + ' input:checked').each(function() {
			if ($(this).val() != '') {
				didStr += '{song}' + $(this).val() + ',';
			}
		});
		if (didStr != '') {
			window.open(site_domain + 'play.php?id=' + didStr.substr(0, didStr.length - 1), 'p');
		} else {
			$.tipMessage('请选择要添加的音乐！', 1, 2000);
		}
	},
	AKeyPlayer: function(list) {
		var didStr = "";
		$("#" + list + " input:checkbox").each(function() {
			if ($(this).val() != "") {
				didStr += $(this).val() + ",";
			}
		});
		if (didStr != "") {
			$.cookie('playerList', "", {
				path: '/',
				expires: 24 * 3600,
				domain: baseDomain
			});
			didStr = didStr.substr(0, didStr.length - 1);
			dancePlayer.addDance(didStr);
			var didInfo = new Array();
			didInfo = didStr.split(",");
			if (1 != $.cookie('openPlayer')) {
				window.open(site_domain + 'index.php/song/' + didInfo[0] + '/', 'p');
			} else {
				window.open(site_domain + 'index.php/song/' + didInfo[0] + '/', 'p');
			}
		}
	},
	openDown: function(did, uid) {
		var url = site_domain + 'index.php/down/' + did + '/';
		window.open(url, '_blank');
	},
	playOneDance: function(did) {
		window.open(site_domain + 'index.php/song/' + did + '/', 'p');
	},
	getPage: function(maxpage, path) {
		var pageNum = parseInt($("#pageNum").val());
		if (pageNum == "") {
			$.tipMessage("请输入要转向的页数！", 2, 3000);
		} else if (parseInt(maxpage) < pageNum) {
			$.tipMessage("本类最大页数为" + maxpage + "！", 2, 3000);
		} else if (pageNum < 1 || !pageNum) {
			$.tipMessage("请输入正确的页数！", 2, 3000);
		} else {
			if (path == undefined) {
				window.location.href = "../" + pageNum + "/";
			} else {
				window.location.href = path.replace("!!PageNum!!", pageNum);
			}
		}
	}
};
var nav = {
	init: function() {
		$(function() {
			var closeCardTimer = null;
			var loadTimer = null;
			var $slidingMenu = $(".sliding_menu");
			var $menuList = $(".m_nav_list");
			$slidingMenu.mouseover(function() {
				var $this = $(this);
				if (closeCardTimer != null) {
					clearTimeout(closeCardTimer);
					closeCardTimer = null
				}
				if (loadTimer != null) {
					clearTimeout(loadTimer);
					loadTimer = null
				}
				loadTimer = setTimeout(function() {
					$menuList.hide();
					$this.next("div").show();
				},
				20);
			}).mouseout(function() {
				var $this = $(this);
				closeCardTimer = setTimeout(function() {
					$this.next("div").hide();
					if (loadTimer != null) {
						clearTimeout(loadTimer);
						loadTimer = null
					}
				},
				20);
			});
			$menuList.hover(function() {
				var $this = $(this);
				if (closeCardTimer != null) {
					clearTimeout(closeCardTimer);
					closeCardTimer = null
				}
			},
			function() {
				closeCardTimer = setTimeout(function() {
					$menuList.hide();
					if (loadTimer != null) {
						clearTimeout(loadTimer);
						loadTimer = null
					}
				},
				200)
			});
			$(".list", $menuList).hover(function() {
				$(this).addClass("hover");
			},
			function() {
				$(this).removeClass("hover");
			});
		});
		select.init("searchType");
	},
	userMenu: function() {
		$(function() {
			var closeSetTimer = null;
			var loadSetTimer = null;
			var $set = $(".set_menu");
			var $setList = $(".m_set_list");
			$set.mouseover(function() {
				var $this = $(this);
				if (closeSetTimer != null) {
					clearTimeout(closeSetTimer);
					closeSetTimer = null
				}
				if (loadSetTimer != null) {
					clearTimeout(loadSetTimer);
					loadSetTimer = null
				}
				loadSetTimer = setTimeout(function() {
					$setList.hide();
					$this.next("div").show();
				},
				20);
			}).mouseout(function() {
				var $this = $(this);
				closeSetTimer = setTimeout(function() {
					$this.next("div").hide();
					if (loadSetTimer != null) {
						clearTimeout(loadSetTimer);
						loadSetTimer = null
					}
				},
				20);
			});
			$setList.hover(function() {
				var $this = $(this);
				if (closeSetTimer != null) {
					clearTimeout(closeSetTimer);
					closeSetTimer = null
				}
			},
			function() {
				closeSetTimer = setTimeout(function() {
					$setList.hide();
					if (loadSetTimer != null) {
						clearTimeout(loadSetTimer);
						loadSetTimer = null
					}
				},
				200)
			});
		});
	},
	helpNoticeInit: function() {
		helpNoticeTimer = setTimeout(function() {
			clearInterval(helpNoticeTimer);
			var _wrap = $('#helpNotice');
			var _field = _wrap.find('li:first');
			var _h = _field.height();
			_field.appendTo(_wrap);
			nav.helpNoticeInit();
		},
		5000);
	}
};
var searchDance = {
	init: function() {
		var $search = $("#searchType");
		var sid = $search.attr("sid");
		var key = $("#txtKey").val();
		if (sid == 1) {
			if (key != "") {
				window.open(site_domain + "search.php?key=" + key, '_blank');
			} else {
				$.tipMessage('音乐关键词不能为空！', 1, 1000);
			}
		} else {
			if (key != "") {
				window.open(zone_domain + "index.php?p=user&a=userSearch&key=" + key, '_blank');
			} else {
				$.tipMessage('用户关键词不能为空！', 1, 1000);
			}
		}
	}
};
var select = {
	init: function(key) {
		$(function() {
			var loadTimer = null;
			var closeCardTimer = null;
			var $Box = $("#" + key);
			var $BoxNext = $Box.next("div");
			$Box.parent().hover(function() {
				$BoxNext.show();
				if (closeCardTimer != null) {
					clearTimeout(closeCardTimer);
					closeCardTimer = null
				}
			},
			function() {
				closeCardTimer = setTimeout(function() {
					$BoxNext.hide();
					if (loadTimer != null) {
						clearTimeout(loadTimer);
						loadTimer = null
					}
				},
				200)
			});
			$("a", $BoxNext).click(function() {
				var note = $(this).html();
				$Box.html(note + '<b class="arrow"></b>');
				$BoxNext.hide();
				if (note == "音乐") {
					$("#searchType").removeAttr("sid");
					$("#searchType").attr("sid", 1);
				}
				if (note == "用户") {
					$("#searchType").removeAttr("sid");
					$("#searchType").attr("sid", 2);
				}
			});
		});
	}
}
var openWebsite = {
	openTo: function() {
		location.href = location.href;
	}
}
var fans = {
	fansAdd: function(uid, nickname, fid) {
		var $fans = $('#fans');
		$.getJSON(zone_domain + "index.php?p=relation&a=fansAddDialog&callback=?", "uid=" + escape(uid),
		function(data) {
			if (data["error"] == 20001) {
				user.userNotLogin('您未登录无法执行此操作！');
			} else {
				var makeHtml = '';
				makeHtml += "<div id=\"addFollowing\" class=\"following_dialog_add\"><div class=\"box\"><div class=\"check\"><span><input type=\"checkbox\" name=\"checkbox\" value=\"1\"  id=\"is_quietly\"";
				if (data["data"]["is_quietly"] == 1) {
					makeHtml += "checked=\"checked\"";
				}
				makeHtml += "/></span><label for=\"is_quietly\">悄悄关注&nbsp;&nbsp;(对方和其他人不会知道您关注了他。)</label></div></div><div class=\"selection\">为“<a href=\"" + zone_domain + "index.php?p=space&uid=" + data["data"]["uid"] + "\" target=\"_blank\">" + nickname + "</a>”选择分组：</div><div class=\"box\"><div class=\"group\"><ul class=\"radio\" id=\"aa\">";
				if (data["error"]) {
					for (var n in data['error'])
					 {
						makeHtml += "<li id=\"followingGroupLine1_" + data["error"][n]["fgid"] + "\" onclick=\"$(\'#addfgName1\').attr(\'value\', \'" + unescape(data["error"][n]["fg_name"]) + "\');$(\'#edit\').attr(\'fgid\', \'" + data["error"][n]["fgid"] + "\');\"><span><input type=\"radio\" name=\"fgid\" value=\"" + data["error"][n]["fgid"] + "\"";
						if (data["data"]["fgid"] == data["error"][n]["fgid"]) {
							makeHtml += "checked=\"checked\"";
						}
						makeHtml += "id=\"radio_" + data["error"][n]["fgid"] + "\"/> </span><label for=\"radio_" + data["error"][n]["fgid"] + "\">" + unescape(data["error"][n]["fg_name"]) + "</label><span class=\"option\"><a class=\"icon edit\" title=\"编辑\" onclick=\"$(\'#editGroup\').show();$(\'#addfgName1\').attr(\'value\', \'" + unescape(data["error"][n]["fg_name"]) + "\'); $(\'#radio_" + data["error"][n]["fgid"] + "\').attr(\'checked\', \'checked\');$(\'#addGroup\').hide(); $(\'#edit\').attr(\'fgid\', \'" + data["error"][n]["fgid"] + "\')\"; href=\"javascript:;\"></a><a class=\"icon del\" title=\"删除\" onclick=\"fans.followingGroupDel(" + data["error"][n]["fgid"] + ", 1,  \'" + unescape(data["error"][n]["fg_name"]) + "\');\" href=\"javascript:;\"></a></span></li>";
					}
				}
				makeHtml += "<li onclick=\"$(\'#editGroup\').hide();$(\'#addGroup\').hide();$(\'#foundGroup\').html(\'+创建分组\');\"><span><input type=\"radio\" name=\"fgid\" value=\"\"";
				if (data["data"]["fgid"] == 0) {
					makeHtml += "checked=\"checked\"";
				}
				makeHtml += "id=\"radio_0\"/></span><label for=\"radio_0\">未分组</label></li></ul>";
				makeHtml += "<div class=\"create_group\"><a herf=\"javascript:;\" id=\"foundGroup\">+创建分组</a></div><div id=\"addGroup\" style=\"display:none;\"><input type=\"text\" maxlength=\"7\" style=\"width:121px;\" class=\"input_normal\" id=\"addfgName2\"><span class=\"button-main\"><span><button type=\"button\" uid=\"" + data["data"]["uid"] + "\" id=\"adds\">添加</button></span></span><span class=\"cancel button2-main\"><span><a href=\"#\" id=\"cancel1\">取消</a></span></span></div><div id=\"editGroup\" style=\"display:none;\"><div class=\"create_group\">编辑分组</div><input type=\"text\" maxlength=\"7\" style=\"width:121px;\" class=\"input_normal\" id=\"addfgName1\"><span class=\"button-main\"><span><button type=\"button\" uid=\"" + data["data"]["uid"] + "\" id=\"edit\">编辑</button></span></span><span class=\"cancel button2-main\"><span><a href=\"#\" id=\"cancel2\">取消</a></span></span></div></div></div></div><script type=\"text/javascript\">fans.submit();</script>";
				$.dialog({
					id: 'friendAdd',
					title: '添加关注好友',
					width: '340px',
					lock: true,
					content: makeHtml,
					okValue: '确认',
					ok: function() {
						var dialogObj = $.dialog.get('delGroup');
						if (typeof dialogObj === 'object') {
							dialogObj.close();
						}
						var fgid = $("input[type=radio]:checked").val();
						var is_quietly = $("#is_quietly:checked").val();
						$.getJSON(zone_domain + "index.php?p=relation&a=doFansAdd&callback=?", "uid=" + escape(uid) + "&fgid=" + escape(fgid) + "&is_quietly=" + escape(is_quietly),
						function(data) {
							if (data['error'] == 20001) {
								user.userNotLogin('您未登录无法执行此操作！');
							} else if (data['error'] == 10013) {
								$.tipMessage('您只能关注别人，不能关注自己哦！', 1, 3000);
							} else if (data['error'] == 10003) {
								$.tipMessage('您已经关注过了 <strong>' + nickname + '</strong> ！', 1, 3000);
								$fans.html('<a class="attention already" href="javascript:;" onClick="$call(function(){fans.fansDel(' + uid + ',\'' + nickname + '\')});"> </a>');
							} else if (data['error'] == 10004) {
								$.tipMessage('该用户不存在！', 1, 3000);
							} else if (data['error'] == 10007) {
								$.tipMessage('该分组不存在！', 1, 3000);
							} else if (data['error'] == 10006) {
								$.tipMessage('关注数量已经是最大值', 1, 3000);
							} else if (data['error'] == 1) {
								if (fid == 1) {
									location.href = location.href;
								} else {
									$.tipMessage('您成功关注了 <strong>' + nickname + '</strong> ！', 0, 3000);
									$fans.html('<a class="attention already" href="javascript:;" onClick="$call(function(){fans.fansDel(' + uid + ',\'' + nickname + '\')});"></a>');
								}
							} else if (data['error'] == 2) {
								if (fid == 1) {
									location.href = location.href;
								} else {
									$.tipMessage('您成功关注了 <strong>' + nickname + '</strong> ！', 0, 3000);
									$fans.html('<a onclick="$call(function(){fans.fansDel(' + uid + ', \'' + nickname + '\')});" class="attention mutual" href="javascript:;">');
								}
							}
						});
					},
					cancelValue: '取消',
					cancel: function() {
						var dialogObj = $.dialog.get('delGroup');
						if (typeof dialogObj === 'object') {
							dialogObj.close();
						}
					}
				});
			}
		});
	},
	fansDel: function(uid, nickname, fid) {
		$.dialog({
			id: 'friendDel12',
			title: '取消关注',
			width: '340px',
			lock: true,
			content: '<br/>你确定取消对 <strong>' + nickname + '</strong>的关注吗？<br/><br/><span style="color: #999999;">提示：取消关注后您将再也不能收到他的新鲜事。</span><br/><br/>',
			okValue: '确认',
			ok: function() {
				var $fans = $('#fans');
				$.getJSON(zone_domain + "index.php?p=relation&a=doFansDel&callback=?", "uid=" + escape(uid),
				function(data) {
					if (data['error'] == 20001) {
						user.userNotLogin('您未登录无法执行此操作！');
					} else if (data['error'] == 10004) {
						$.tipMessage('您不是 <strong>' + nickname + '</strong> 的歌迷!', 1, 3000);
					} else if (data['error'] == 10013) {
						$.tipMessage('您只能关注别人，不能关注自己哦！', 1, 3000);
					} else {
						if (fid == 1) {
							location.href = location.href;
						} else {
							$.tipMessage('您成功取消了对 <strong>' + nickname + '</strong> 的关注!', 0, 3000);
							$fans.html('<a class="attention" href="javascript:;" onClick="$call(function(){fans.fansAdd(' + uid + ',\'' + nickname + '\')});"></a>');
						}
					}
				});
			},
			cancelValue: '取消',
			cancel: function() {}
		});
	},
	submit: function() {
		$("#foundGroup").click(function() {
			$("#editGroup").hide();
			$("#addGroup").show();
		});
		$("#cancel1").click(function() {
			$("#addGroup").hide();
		});
		$("#cancel2").click(function() {
			$("#editGroup").hide();
			$("#foundGroup").html("+创建分组");
		});
		$("#edit").click(function() {
			if (!/^([^<>'"\/\\])*$/.test($('#addfgName1').val())) {
				$.tipMessage("名字中不能有 < > \' \" / \\ 等非法字符！", 1, 2000);
				return false;
			}
			var fgid = $(this).attr('fgid');
			var uid = $(this).attr("uid");
			$.getJSON(zone_domain + "index.php?p=relation&a=doFansGroupModify&callback=?", "fgid=" + escape(fgid) + "&fg_name=" + escape($('#addfgName1').val()) + "&uid=" + escape(uid),
			function(data) {
				if (data['error'] == 20001) {
					user.userNotLogin('您未登录无法执行此操作！');
				} else if (data['error'] == 20002) {
					$.tipMessage("您没有权限修改！", 1, 2000);
				} else if (data['error'] == 10007) {
					$.tipMessage("分组名称不能为空！", 1, 2000);
				} else if (data['error'] == 10006) {
					$.tipMessage("分组名超过不能超过七个字！", 1, 2000);
				} else {
					var makeHtml = '';
					for (var n in data['error'])
					 {
						makeHtml += "<li id='followingGroupLine1_" + data["error"][n]["fgid"] + "' onclick=\"$('#addfgName1').attr('value', '" + unescape(data["error"][n]["fg_name"]) + "');$('#edit').attr('fgid', '" + data["error"][n]["fgid"] + "');\"><span><input type='radio' name='fgid' value='" + data["error"][n]["fgid"] + "'";
						if (data["error"][n]["fgid"] == data["data"]["fgid"]) {
							makeHtml += "checked='checked'";
						}
						makeHtml += " id='radio_" + data["error"][n]["fgid"] + "'/></span><label for='radio_" + data["error"][n]["fgid"] + "'>" + unescape(data["error"][n]["fg_name"]) + "</label><span class='option'><a class='icon edit' title='编辑' onclick=\"$('#editGroup').show();$('#addfgName1').attr('value', '" + unescape(data["error"][n]["fg_name"]) + "'); $('#radio_" + data["error"][n]["fgid"] + "').attr('checked', 'checked');$('#addGroup').hide(); $('#edit').attr('fgid', '" + data["error"][n]["fgid"] + "')\"; href='javascript:;'></a><a class='icon del' title='删除' onclick=\"fans.followingGroupDel(" + data["error"][n]["fgid"] + ", 1, \'" + unescape(data["error"][n]["fg_name"]) + "\');\"href='javascript:;'></a></span></li>";
					}
					makeHtml += "<li onclick=\"$(\'#editGroup\').hide();$(\'#addGroup\').hide();$(\'#foundGroup\').html(\'+创建分组\');\"><span><input type=\"radio\" name=\"fgid\" value=\"\"";
					if (data["data"]["fgid"] == 0) {
						makeHtml += "checked=\"checked\""
					}
					makeHtml += "id=\"radio_0\"/></span><label for=\"radio_0\">未分组</label></li>";
					$("#aa").html(makeHtml);
				}
			});
		});
		$("#adds").click(function() {
			if (!/^([^<>'"\/\\])*$/.test($('#addfgName2').val())) {
				$.tipMessage("名字中不能有 < > \' \" / \\ 等非法字符！", 1, 2000);
				return false;
			}
			var uid = $(this).attr("uid");
			var fg_name = $("#addfgName2").val();
			$.getJSON(zone_domain + "index.php?p=relation&a=doFansGroupAdd&callback=?", "fg_name=" + escape(fg_name) + "&uid=" + escape(uid),
			function(data) {
				if (data['error'] == 20001) {
					user.userNotLogin('您未登录无法执行此操作！');
				} else if (data['error'] == 20002) {
					$.tipMessage("您没有权限添加！", 1, 2000);
				} else if (data['error'] == 10007) {
					$.tipMessage("分组名称不能为空！", 1, 2000);
				} else if (data['error'] == 10006) {
					$.tipMessage("分组名不能超过七个字！", 1, 2000);
				} else if (data['error'] == 100061) {
					$.tipMessage("分组数量不能超过8个！", 1, 2000);
				} else if (data['error'] == 10004) {
					$.tipMessage("你不是对方的歌迷", 1, 2000);
				} else {
					var makeHtml = '';
					for (var n in data['error'])
					 {
						makeHtml += "<li id='followingGroupLine1_" + data["error"][n]["fgid"] + "' onclick=\"$('#addfgName1').attr('value', '" + unescape(data["error"][n]["fg_name"]) + "');$('#edit').attr('fgid', '" + data["error"][n]["fgid"] + "');\"><span><input type='radio' name='fgid' value='" + data["error"][n]["fgid"] + "'";
						if (data["error"][n]["fgid"] == data["data"]["fgid"]) {
							makeHtml += "checked='checked'";
						}
						makeHtml += " id='radio_" + data["error"][n]["fgid"] + "'/></span><label for='radio_" + data["error"][n]["fgid"] + "'>" + unescape(data["error"][n]["fg_name"]) + "</label><span class='option'><a class='icon edit' title='编辑' onclick=\"$('#editGroup').show();$('#addfgName1').attr('value', '" + unescape(data["error"][n]["fg_name"]) + "'); $('#radio_" + data["error"][n]["fgid"] + "').attr('checked', 'checked');$('#addGroup').hide(); $('#edit').attr('fgid', '" + data["error"][n]["fgid"] + "')\"; href='javascript:;'></a><a class='icon del' title='删除' onclick=\"fans.followingGroupDel(" + data["error"][n]["fgid"] + ", 1, \'" + unescape(data["error"][n]["fg_name"]) + "\');\"href='javascript:;'></a></span></li>";
					}
					makeHtml += "<li onclick=\"$(\'#editGroup\').hide();$(\'#addGroup\').hide();$(\'#foundGroup\').html(\'+创建分组\');\"><span><input type=\"radio\" name=\"fgid\" value=\"\"";
					if (data["data"]["fgid"] == 0) {
						makeHtml += "checked=\"checked\""
					}
					makeHtml += "id=\"radio_0\"/></span><label for=\"radio_0\">未分组</label></li>";
					$("#aa").html(makeHtml);
				}
			});
		})
	},
	followingGroupDel: function(fgid, type, fgName) {
		var dialogObj = $.dialog.get('delGroup');
		if (typeof dialogObj === 'object') {
			dialogObj.close();
		}
		if (type == 1) {
			follow = $('#followingGroupLine1_' + fgid)[0];
		} else {
			follow = $('#followingGroupLine_' + fgid)[0];
		}
		$.dialog({
			id: 'delGroup',
			title: false,
			border: false,
			follow: follow,
			content: '确认删除分组"' + fgName + '"么？',
			okValue: '确认',
			ok: function() {
				$.getJSON(zone_domain + "index.php?p=relation&a=doFollowingGroupDel&callback=?", "fgid=" + escape(fgid),
				function(data) {
					if (data['error'] == 20001) {
						user.userNotLogin('您未登录无法执行此操作！');
					} else if (data['error'] == 20002) {
						$.tipMessage("您没有权限添加！", 1, 2000);
					} else {
						if (type == 1) {
							$("#followingGroupLine1_" + fgid).remove();
						} else {
							location.href = zone_domain + "index.php?p=relation&a=following";
						}
					}
				});
			},
			cancelValue: '取消',
			cancel: function() {}
		});
	}
};