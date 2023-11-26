$(function() {
	if ($(".sp_card").length <= 0) {
		var html = '<div class="sp_card" style="display:none; height:180px;">' + '<div class="sp_card_content">' + '<div class="sp_card_loading" style="display:none;"><img src="' + zone_domain + 'static/images/loading.gif" width="32" height="32" alt="正在加载中..." /></div>' + '<dl class="sp_card_view">' + '<dt><a href="javascript:;" target="_blank"><img src="' + zone_domain + 'static/images/none.gif" border="0" width="48" height="48" /></a></dt>' + '<dd></dd>' + '</dl>' + '<div class="sp_card_intro"></div>' + '<div class="sp_card_medal">' + '<ul class="medal">' + '</ul>' + '</div>' + '<div class="sp_card_follow"><a href="javascript:;" class="sp_follow_bnt" style="display:none;">+&nbsp;关注</a><a href="javascript:;" class="sp_follow_bnt sp_unfollow_bnt" style="display:none;">已关注&nbsp;|&nbsp;取消</a><a href="javascript:;" class="sp_follow_bnt sp_unfollow_bnt" style="display:none;">相互关注&nbsp;|&nbsp;取消</a></div>' + '<b class="sp_caret sp_caret_out"></b>' + '<b class="sp_caret sp_caret_in"></b>' + '</div>' + '</div>';
		$(html).appendTo("body");
	}
	var $card = $(".sp_card");
	var v = $(".sp_card .sp_card_view"),
	uci = $(".sp_card .sp_card_intro");
	var w = $(".sp_card .sp_card_medal"),
	ucf = $(".sp_card .sp_card_follow"),
	ucl = $(".sp_card .sp_card_loading");
	var $sp_caret = $card.find(".sp_caret");
	var closeCardTimer = null;
	var loadTimer = null;
	function bindCardInfo(res) {
		if (res.success) {
			v.find("dt > a").attr("href", zone_domain + 'index.php?p=space&uid=' + res.uid).children("img").attr("src", res.avatar);
			var siteHtml = '<a target="_blank" href="' + zone_domain + 'index.php?p=space&uid=' + res.uid + '" style="display:inline;float:left;font-weight: bold;">' + res.nickname + '</a>' + res.producer + res.vip_str + '<br />关注&nbsp;' + '<a target="_blank" href="' + zone_domain + 'index.php?p=space&a=following&uid=' + res.uid + '">' + res.following_num + '</a>&nbsp;&nbsp;|&nbsp;&nbsp;粉丝&nbsp;<a target="_blank" href="' + zone_domain + 'index.php?p=space&a=fans&uid=' + res.uid + '">' + res.fans_num + '</a>&nbsp;&nbsp;|&nbsp;&nbsp;';
			if (res.medal['share']['role'] > 0) {
				siteHtml += '分享&nbsp;<a target="_blank" href="' + zone_domain + 'index.php?p=space&a=dance&uid=' + res.uid + '">' + res.dance_num + '</a>';
			} else {
				siteHtml += '推荐&nbsp;<a target="_blank" href="' + zone_domain + 'index.php?p=space&a=favorites&uid=' + res.uid + '">' + res.recommend_num + '</a>';
			}
			v.find("dd").html(siteHtml);
			uci.html(res.describes != null && res.describes.length > 0 ? res.describes: "暂无介绍...");
			var medalHtml = "";
			for (var n in res.medal)
			 {
				medalHtml += "<li><a href='javascript:;' title='" + res.medal[n]['title'] + "' onclick=\"openWebsite.openTo(\'" + n + "\');\">";
				if (res.medal[n]['display'] != 0) {
					medalHtml += "<em class='" + n + "'></em>";
				} else {
					medalHtml += "<em class='" + n + "_none'></em>";
				}
				if (res.medal[n]['role'] != 0) {
					if (n == "sign") {
						if (res.medal[n]['role'] > 9) {
							medalHtml += "<b class='num n9n'></b>";
						} else {
							medalHtml += "<b class='num n" + res.medal[n]['role'] + "'></b>";
						}
					} else {
						medalHtml += "<b class='num n" + res.medal[n]['role'] + "'></b>";
					}
				}
				medalHtml += "</a></li>";
			}
			w.find("ul").html(medalHtml);
			if (res.follow[res.uid] == 1 || res.follow[res.uid] == 2) {
				ucf.find("a").hide().eq(res.follow[res.uid]).show();
			} else {
				ucf.find("a").hide().eq(0).show();
			}
			ucf.find("span").html("");
			ucl.hide();
			v.show();
			uci.show();
			w.show();
			ucf.show().find("a").attr("uid", res.uid).attr("nickname", res.nickname);
		}
		 else {
			$card.hide();
		}
	}
	$card.hover(function() {
		if (closeCardTimer != null) {
			clearTimeout(closeCardTimer);
			closeCardTimer = null;
		}
	},
	function() {
		closeCardTimer = setTimeout(function() {
			$card.hide();
			if (loadTimer != null) {
				clearTimeout(loadTimer);
				loadTimer = null;
			}
		},
		400)
	});
	ucf.find("a").each(function(i, k) {
		var command = "";
		var callback = function() {};
		switch (i) {
		case 0:
			command = "fansAddDialog";
			callback = function(data) {
				var uid = $(k).attr("uid");
				var $fans = $('#fans');
				var nickname = $(k).attr("nickname");
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
							makeHtml += "<li id=\"followingGroupLine1_" + data["error"][n]["fgid"] + "\" onclick=\"$(\'#addfgName1\').attr(\'value\', \'" + data["error"][n]["fg_name"] + "\');$(\'#edit\').attr(\'fgid\', \'" + data["error"][n]["fgid"] + "\');\"><span><input type=\"radio\" name=\"fgid\" value=\"" + data["error"][n]["fgid"] + "\"";
							if (data["data"]["fgid"] == data["error"][n]["fgid"]) {
								makeHtml += "checked=\"checked\"";
							}
							makeHtml += "id=\"radio_" + data["error"][n]["fgid"] + "\"/> </span><label for=\"radio_" + data["error"][n]["fgid"] + "\">" + data["error"][n]["fg_name"] + "</label><span class=\"option\"><a class=\"icon edit\" title=\"编辑\" onclick=\"$(\'#editGroup\').show();$(\'#addfgName1\').attr(\'value\', \'" + data["error"][n]["fg_name"] + "\'); $(\'#radio_" + data["error"][n]["fgid"] + "\').attr(\'checked\', \'checked\');$(\'#addGroup\').hide(); $(\'#edit\').attr(\'fgid\', \'" + data["error"][n]["fgid"] + "\')\"; href=\"javascript:;\"></a><a class=\"icon del\" title=\"删除\" onclick=\"fans.followingGroupDel(" + data["error"][n]["fgid"] + ", 1,  \'" + data["error"][n]["fg_name"] + "\');\" href=\"javascript:;\"></a></span></li>";
						}
					}
					makeHtml += "<li onclick=\"$(\'#editGroup\').hide();$(\'#addGroup\').hide();$(\'#foundGroup\').html(\'+创建分组\');\"><span><input type=\"radio\" name=\"fgid\" value=\"\"";
					if (data["data"]["fgid"] == 0) {
						makeHtml += "checked=\"checked\"";
					}
					makeHtml += "id=\"radio_93\"/></span><label for=\"radio_93\">未分组</label></li></ul>";
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
								}
								 else if (data['error'] == 10013) {
									$.tipMessage('您只能关注别人，不能关注自己哦！', 1, 3000);
								}
								 else if (data['error'] == 10003) {
									$.tipMessage('您已经关注过了 <strong>' + nickname + '</strong> ！', 1, 3000);
									$fans.html('<a class="attention already" href="javascript:;" onClick="$call(function(){fans.fansDel(' + uid + ',\'' + nickname + '\')});"> </a>');
								}
								 else if (data['error'] == 10004) {
									$.tipMessage('该用户不存在！', 1, 3000);
								} else if (data['error'] == 10007) {
									$.tipMessage('该分组不存在！', 1, 3000);
								}
								 else if (data['error'] == 10006) {
									$.tipMessage('关注数量已经是最大值', 1, 3000);
								}
								 else {
									$("body").data("userCard" + uid, 0);
									$.tipMessage('您成功关注了 <strong>' + nickname + '</strong> ！', 0, 3000);
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
			};
			break;
		case 1:
		case 2:
			{
				command = "doFansDel";
				callback = function(data) {
					var uid = $(k).attr("uid");
					var nickname = $(k).attr("nickname");
					if (data['error'] == 20001) {
						user.userNotLogin('您未登录无法执行此操作！');
					} else if (data['error'] == 10004) {
						$.tipMessage('您不是 <strong>' + nickname + '</strong> 的歌迷!', 1, 3000);
					} else if (data['error'] == 10013) {
						$.tipMessage('您只能关注别人，不能关注自己哦！', 1, 3000);
					} else {
						$("body").data("userCard" + uid, 0);
						$.tipMessage('您成功取消了对 <strong>' + nickname + '</strong> 的关注!', 0, 3000);
					}
				};
				break;
			}
		default:
			break;
		}
		if (command == "fansAddDialog") {
			$(k).click(function() {
				var uid = $(this).attr("uid");
				if (uid && uid.length > 0) {
					$.getJSON(zone_domain + "index.php?p=relation&a=" + command + "&callback=?", {
						uid: uid
					},
					callback)
				}
				return false;
			})
		} else if (command == "doFansDel") {
			$(k).click(function() {
				var nickname = $(this).attr("nickname");
				var uid = $(this).attr("uid");
				$.dialog({
					id: 'friendDel12',
					title: '取消关注',
					width: '340px',
					lock: true,
					content: '<br/>你确定取消对 <strong>' + nickname + '</strong>的关注吗？<br/><br/><span style="color: #999999;">提示：取消关注后您将再也不能收到他的新鲜事。</span><br/><br/>',
					okValue: '确认',
					ok: function() {
						if (uid && uid.length > 0) {
							$.getJSON(zone_domain + "index.php?p=relation&a=" + command + "&callback=?", {
								uid: uid
							},
							callback)
						}
					},
					cancelValue: '取消',
					cancel: function() {}
				});
			})
		}
	})
});