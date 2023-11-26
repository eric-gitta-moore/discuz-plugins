var profile = {
	init: function() {
		libs.cityPopup('raddress');
		var $cprofile = $('#cprofile');
		var $cavatar = $('#cavatar');
		var $cpassword = $('#cpassword');
		var $cprotection = $('#cprotection');
		var $cnickname = $('#cnickname');
		var $modifyProfile = $('#modifyProfile');
		var $modifyAvatar = $('#modifyAvatar');
		var $modifyPassword = $('#modifyPassword');
		var $modifyProtection = $('#modifyProtection');
		var $modifyNickname = $('#modifyNickname');
		var $rsex = $('#rsex');
		var $ryear = $('#ryear');
		var $rmonth = $('#rmonth');
		var $rday = $('#rday');
		var $mbirth = $('#mbirth');
		var $raddress = $('#raddress');
		var $maddress = $('#maddress');
		var $rqq = $('#rqq');
		var $mqq = $('#mqq');
		var $remail = $('#remail');
		var $memail = $('#memail');
		var $rselfIntroduce = $('#rselfIntroduce');
		var $mselfIntroduce = $('#mselfIntroduce');
		var $rnickname = $('#rnickname');
		var $mnickname = $('#mnickname');
		var $roldpassword = $('#roldpassword');
		var $moldpassword = $('#moldpassword');
		var $rpassword = $('#rpassword');
		var $mpassword = $('#mpassword');
		var $rpassword2 = $('#rpassword2');
		var $mpassword2 = $('#mpassword2');
		var $rpasswords = $('#rpasswords');
		var $mpasswords = $('#mpasswords');
		var $rquestion = $('#rquestion');
		var $mquestion = $('#mquestion');
		var $ranswer = $('#ranswer');
		var $manswer = $('#manswer');
		var $seveProfile = $('#seveProfile');
		var $sevePassword = $('#sevePassword');
		var $seveProtection = $('#seveProtection');
		var $seveNickname = $('#seveNickname');
		$cprofile.click(function() {
			$(this).attr('class', 'current');
			$cavatar.attr('class', '');
			$cpassword.attr('class', '');
			$cprotection.attr('class', '');
			$cnickname.attr('class', '');
			$modifyProfile.show();
			$modifyAvatar.hide();
			$modifyPassword.hide();
			$modifyProtection.hide();
			$modifyNickname.hide();
		});
		$cavatar.click(function() {
			$cprofile.attr('class', '');
			$(this).attr('class', 'current');
			$cpassword.attr('class', '');
			$cprotection.attr('class', '');
			$cnickname.attr('class', '');
			$modifyProfile.hide();
			$modifyAvatar.show();
			$modifyPassword.hide();
			$modifyProtection.hide();
			$modifyNickname.hide();
		});
		$cpassword.click(function() {
			$cprofile.attr('class', '');
			$cavatar.attr('class', '');
			$(this).attr('class', 'current');
			$cprotection.attr('class', '');
			$cnickname.attr('class', '');
			$modifyProfile.hide();
			$modifyAvatar.hide();
			$modifyPassword.show();
			$modifyProtection.hide();
			$modifyNickname.hide();
		});
		$cprotection.click(function() {
			$cprofile.attr('class', '');
			$cavatar.attr('class', '');
			$cpassword.attr('class', '');
			$(this).attr('class', 'current');
			$cnickname.attr('class', '');
			$modifyProfile.hide();
			$modifyAvatar.hide();
			$modifyPassword.hide();
			$modifyProtection.show();
			$modifyNickname.hide();
		});
		$cnickname.click(function() {
			$cprofile.attr('class', '');
			$cavatar.attr('class', '');
			$cpassword.attr('class', '');
			$cprotection.attr('class', '');
			$(this).attr('class', 'current');
			$modifyProfile.hide();
			$modifyAvatar.hide();
			$modifyPassword.hide();
			$modifyProtection.hide();
			$modifyNickname.show();
		});
		var check2Month = function() {
			if ($ryear.val() != 0 && $rmonth.val() == '02') {
				for (i = 29; i <= 31; i++) {
					$options = $rday.children("[value=" + i + "]");
					if ($ryear.val() % 400 == 0 || ($ryear.val() % 4 == 0 && $ryear.val() % 100 != 0)) {
						if ($options.val() != i && i <= 29) {
							$rday.append("<option value=\"" + i + "\">" + i + "</option>");
						}
						if (i > 29) {
							$options.remove();
						}
					}
					 else {
						if ($options.val() == i) {
							$options.remove();
						}
					}
				}
			}
		}
		check2Month();
		$ryear.focus(function() {
			$mbirth.removeClass('input_tag2');
			$mbirth.addClass('input_tag1');
			$(this).addClass('select_focus');
			$mbirth.html('请选择您的生日。');
		}).blur(function() {
			$(this).removeClass('select_focus');
			$rday.triggerHandler('change');
		}).change(function() {
			check2Month();
			$rday.triggerHandler('change');
		});
		$rmonth.focus(function() {
			$mbirth.removeClass('input_tag2');
			$mbirth.addClass('input_tag1');
			$(this).addClass('select_focus');
			$mbirth.html('请选择您的生日。');
		}).blur(function() {
			$(this).removeClass('select_focus');
			$rday.triggerHandler('change');
		}).change(function() {
			if ($ryear.val() != 0) {
				for (i = 29; i <= 31; i++) {
					$options = $rday.children("[value=" + i + "]");
					if ($rmonth.val() == '') {
						if ($options.val() != i) {
							$rday.append("<option value=\"" + i + "\">" + i + "</option>");
						}
					} else if ($rmonth.val() == '02') {
						if ($ryear.val() % 400 == 0 || ($ryear.val() % 4 == 0 && $ryear.val() % 100 != 0)) {
							if ($options.val() != i && i <= 29) {
								$rday.append("<option value=\"" + i + "\">" + i + "</option>");
							}
							if (i > 29) {
								$options.remove();
							}
						} else {
							if ($options.val() == i) {
								$options.remove();
							}
						}
					} else if ($rmonth.val() == '04' || $rmonth.val() == '06' || $rmonth.val() == '09' || $rmonth.val() == '11') {
						if ($options.val() != i && i <= 30) {
							$rday.append("<option value=\"" + i + "\">" + i + "</option>");
						}
						if (i > 30) {
							$options.remove();
						}
					} else {
						if ($options.val() != i) {
							$rday.append("<option value=\"" + i + "\">" + i + "</option>");
						}
					}
				}
			}
			$rday.triggerHandler('change');
		});
		$rday.focus(function() {
			$mbirth.removeClass('input_tag2');
			$mbirth.addClass('input_tag1');
			$(this).addClass('select_focus');
			$mbirth.html('请选择您的生日。');
		}).blur(function() {
			$(this).removeClass('select_focus');
			$ryear.triggerHandler('change');
		}).change(function() {
			if ($ryear.val() == 0 || $rmonth.val() == 0 || $rday.val() == 0) {
				$mbirth.removeClass('input_tag1');
				$mbirth.addClass('input_tag2');
				$mbirth.html('<span class="errIcon"></span>请正确选择您的生日！');
				return false;
			} else {
				$mbirth.removeClass('input_tag1');
				$mbirth.removeClass('input_tag2');
				$mbirth.html('<span class="rightIcon"></span>');
			}
		});
		$raddress.focus(function() {
			$maddress.removeClass('input_tag2');
			$maddress.addClass('input_tag1');
			$(this).addClass('input_focus');
			$maddress.html('请单击选择您的所在城市。');
		}).blur(function() {
			$(this).removeClass('input_focus');
			$(this).triggerHandler('keyup');
		}).keyup(function() {
			if ($(this).val() == '' || $(this).val() == '请选择城市') {
				$maddress.removeClass('input_tag1');
				$maddress.addClass('input_tag2');
				$maddress.html('<span class="errIcon"></span>请选择您所在的城市！');
				return false;
			} else {
				$maddress.removeClass('input_tag1');
				$maddress.removeClass('input_tag2');
				$maddress.html('<span class="rightIcon"></span>');
			}
		});
		$rqq.focus(function() {
			$mqq.removeClass('input_tag2');
			$mqq.addClass('input_tag1');
			$(this).addClass('input_focus');
			$mqq.html('输入您的QQ号，只供站务人员联系使用，不会公开。');
		}).blur(function() {
			$(this).removeClass('input_focus');
			$(this).triggerHandler('keyup');
		}).keyup(function() {
			var search_str = /^[1-9][0-9]{4,}$/;
			if ($(this).val() == '') {
				$mqq.removeClass('input_tag1');
				$mqq.addClass('input_tag2');
				$mqq.html('<span class="errIcon"></span>请输入您的QQ号码！');
				return false;
			}
			if (!search_str.test($(this).val())) {
				$mqq.removeClass('input_tag1');
				$mqq.addClass('input_tag2');
				$mqq.html('<span class="errIcon"></span>请输入正确的QQ号！');
				return false;
			} else {
				$mqq.removeClass('input_tag1');
				$mqq.removeClass('input_tag2');
				$mqq.html('<span class="rightIcon"></span>');
			}
		});
		$remail.focus(function() {
			$memail.removeClass('input_tag2');
			$memail.addClass('input_tag1');
			$(this).addClass('input_focus');
			$memail.html('安全邮箱能够帮您取回您忘记的密码。');
		}).blur(function() {
			$(this).removeClass('input_focus');
			$(this).triggerHandler('keyup');
		}).keyup(function() {
			var search_str = /^[\w\-\.]+@[\w\-\.]+(\.\w+)+$/;
			if ($(this).val() == '') {
				$memail.removeClass('input_tag1');
				$memail.addClass('input_tag2');
				$memail.html('<span class="errIcon"></span>请输入您的email！');
				return false;
			} else if (!search_str.test($(this).val())) {
				$memail.removeClass('input_tag1');
				$memail.addClass('input_tag2');
				$memail.html('<span class="errIcon"></span>email格式不正确！');
				return false;
			}
			$.ajax({
				type: "POST",
				global: false,
				url: zone_domain + "index.php?p=user&a=checkEmail",
				data: {
					email: escape($remail.val())
				},
				dataType: "text",
				success: function(data) {
					if (data == 20011) {
						$memail.removeClass('input_tag1');
						$memail.addClass('input_tag2');
						$memail.html('<span class="errIcon"></span>此邮箱已经存在，请更换一个。');
						return false;
					} else if (data == 10000) {
						$memail.removeClass('input_tag1');
						$memail.removeClass('input_tag2');
						$memail.html('<span class="rightIcon"></span>');
					} else if (data == 1) {
						$memail.removeClass('input_tag1');
						$memail.addClass('input_tag2');
						$memail.html('<span class="errIcon"></span>输入的电子邮箱格式不正确。');
						return false;
					} else {
						$.tipMessage("执行失败。" + data, 2, 2000);
						return false;
					}
				},
				error: function() {
					$.tipMessage("数据执行错误。", 2, 3000);
					return false;
				}
			});
		});
		$rselfIntroduce.focus(function() {
			$mselfIntroduce.removeClass('input_tag2');
			$mselfIntroduce.addClass('input_tag1');
			$(this).addClass('input_focus');
			$mselfIntroduce.html('内容不能超过160个字母或80个汉字');
		}).blur(function() {
			$(this).removeClass('input_focus');
			$(this).triggerHandler('keyup');
		}).keyup(function() {
			$mselfIntroduce.removeClass('input_tag1');
			$mselfIntroduce.removeClass('input_tag2');
			$mselfIntroduce.html('<span class="rightIcon"></span>');
		});
		$seveProfile.click(function() {
			$("#modifyProfile :input").trigger('keyup');
			$ryear.triggerHandler('change');
			var numError = $('#modifyProfile .errIcon').length;
			if (!numError) {
				var note = $("#openQQ").text();
				if (note == "公开QQ") {
					var qqPrivacy = 1;
				} else {
					var qqPrivacy = 0;
				}
				if ($rselfIntroduce.val().length > 160) {
					$mselfIntroduce.html('内容不能超过160个字母或80个汉字');
					$rselfIntroduce.focus();
					return false;
				}
				$.ajax({
					type: "POST",
					global: false,
					url: zone_domain + "index.php?p=user&a=doProfileModify",
					data: {
						sex: $rsex.val(),
						year: $ryear.val(),
						month: $rmonth.val(),
						day: $rday.val(),
						address: escape($raddress.val()),
						qq: $rqq.val(),
						email: $remail.val(),
						selfIntroduce: escape($rselfIntroduce.val()),
						qqPrivacy: qqPrivacy
					},
					dataType: "text",
					success: function(data) {
						if (data == 20001) {
							libs.userNotLogin('您没有登录，无法更新个人设置！');
						} else if (data == 10004) {
							$.tipMessage('请选择正确的城市！', 1, 1000);
						} else if (data == 2) {
							$mselfIntroduce.removeClass('input_tag1');
							$mselfIntroduce.addClass('input_tag2');
							$mselfIntroduce.html('<span class="errIcon"></span>超过字符限制');
							return false;
						} else if (data == 3) {
							$mselfIntroduce.removeClass('input_tag1');
							$mselfIntroduce.addClass('input_tag2');
							$mselfIntroduce.html('<span class="errIcon"></span>昵称中至少要含有一个字母或汉字');
							return false;
						} else if (data == 10000) {
							$.tipMessage('资料已经更新！', 0, 3000);
						} else {
							$mselfIntroduce.removeClass('input_tag1');
							$mselfIntroduce.addClass('input_tag2');
							$mselfIntroduce.html('<span class="errIcon"></span>昵称中不能含有 ' + data + ' 等字符！');
						}
					}
				});
			}
		});
		$roldpassword.focus(function() {
			$(this).addClass('input_focus');
			$moldpassword.removeClass('input_tag2');
			$moldpassword.addClass('input_tag1');
			$moldpassword.html('请输入您当前使用的密码。');
		}).blur(function() {
			$(this).removeClass('input_focus');
			$(this).triggerHandler('keyup');
		}).keyup(function() {
			if ($(this).val() == '') {
				$moldpassword.removeClass('input_tag1');
				$moldpassword.addClass('input_tag2');
				$moldpassword.html('<span class="errIcon"></span>请输入您当前的密码！');
				return false;
			} else if ($(this).val().length < 6) {
				$moldpassword.removeClass('input_tag1');
				$moldpassword.addClass('input_tag2');
				$moldpassword.html('<span class="errIcon"></span>密码长度应大于6位！');
				return false;
			}
			 else {
				$moldpassword.removeClass('input_tag1');
				$moldpassword.removeClass('input_tag2');
				$moldpassword.html('<span class="rightIcon"></span>');
			}
		});
		$rpassword.focus(function() {
			$(this).addClass('input_focus');
			$mpassword.removeClass('input_tag2');
			$mpassword.addClass('input_tag1');
			$mpassword.html('6个字符以上，字母区分大小写。');
		}).blur(function() {
			$(this).removeClass('input_focus');
			$(this).triggerHandler('keyup');
		}).keyup(function() {
			if ($(this).val() == '') {
				$mpassword.removeClass('input_tag1');
				$mpassword.addClass('input_tag2');
				$mpassword.html('<span class="errIcon"></span>请输入您的新密码！');
				return false;
			} else if ($(this).val().length < 6) {
				$mpassword.removeClass('input_tag1');
				$mpassword.addClass('input_tag2');
				$mpassword.html('<span class="errIcon"></span>密码长度应大于6位！');
				return false;
			} else {
				$mpassword.removeClass('input_tag1');
				$mpassword.removeClass('input_tag2');
				$mpassword.html('<span class="rightIcon"></span>');
			}
		});
		$rpassword2.focus(function() {
			$(this).addClass('input_focus');
			$mpassword2.removeClass('input_tag2');
			$mpassword2.addClass('input_tag1');
			$mpassword2.html('再次输入您所设置的新密码，以确认密码无误。');
		}).blur(function() {
			$(this).removeClass('input_focus');
			$(this).triggerHandler('keyup');
		}).keyup(function() {
			if ($(this).val() == '') {
				$mpassword2.removeClass('input_tag1');
				$mpassword2.addClass('input_tag2');
				$mpassword2.html('<span class="errIcon"></span>请输入确认新密码！');
				return false;
			} else if ($(this).val() != $rpassword.val()) {
				$mpassword2.removeClass('input_tag1');
				$mpassword2.addClass('input_tag2');
				$mpassword2.html('<span class="errIcon"></span>两次输入密码不相同！');
				return false;
			} else {
				$mpassword2.removeClass('input_tag1');
				$mpassword2.removeClass('input_tag2');
				$mpassword2.html('<span class="rightIcon"></span>');
			}
		});
		$sevePassword.click(function() {
			$("#modifyPassword :input").trigger('keyup');
			$ryear.triggerHandler('change');
			var numError = $('#modifyPassword .errIcon').length;
			if (!numError) {
				$.ajax({
					type: "POST",
					global: false,
					url: zone_domain + "index.php?p=user&a=doPasswordModify",
					data: {
						oldPassword: $roldpassword.val(),
						password: $rpassword.val(),
						password2: $rpassword2.val()
					},
					dataType: "text",
					success: function(data) {
						if (data == 20001) {
							libs.userNotLogin('您没有登录，无法更新个人设置！');
						} else if (data == 20021) {
							$.tipMessage('两次输入密码不一致，请重新输入！', 2, 3000);
						} else if (data == 20022) {
							$.tipMessage('当前密码不正确，请重新输入！', 2, 3000);
							$("#roldpassword").focus();
						} else {
							$.tipMessage('密码已经更新！', 0, 3000);
						}
					}
				});
			}
		});
		$rpasswords.focus(function() {
			$(this).addClass('input_focus');
			$mpasswords.removeClass('input_tag2');
			$mpasswords.addClass('input_tag1');
			$mpasswords.html('请输入您当前的登陆密码！');
		}).blur(function() {
			$(this).removeClass('input_focus');
			$(this).triggerHandler('keyup');
		}).keyup(function() {
			if ($(this).val() == '') {
				$mpasswords.removeClass('input_tag1');
				$mpasswords.addClass('input_tag2');
				$mpasswords.html('<span class="errIcon"></span>请输入您当前的登陆密码！');
				return false;
			} else if ($(this).val().length < 6) {
				$mpasswords.removeClass('input_tag1');
				$mpasswords.addClass('input_tag2');
				$mpasswords.html('<span class="errIcon"></span>密码长度应大于6位！');
				return false;
			} else {
				$mpasswords.removeClass('input_tag1');
				$mpasswords.removeClass('input_tag2');
				$mpasswords.html('<span class="rightIcon"></span>');
			}
		});
		$rquestion.focus(function() {
			$(this).addClass('input_focus');
			$mquestion.removeClass('input_tag2');
			$mquestion.addClass('input_tag1');
			$mquestion.html('2到20个字符，中文、英文字母（区分大小写）、符号或数字。');
		}).blur(function() {
			$(this).removeClass('input_focus');
			$(this).triggerHandler('keyup');
		}).keyup(function() {
			if ($(this).val() == '') {
				$mquestion.removeClass('input_tag1');
				$mquestion.addClass('input_tag2');
				$mquestion.html('<span class="errIcon"></span>请输入您的密保问题！');
				return false;
			} else if ($(this).val().length < 2) {
				$mquestion.removeClass('input_tag1');
				$mquestion.addClass('input_tag2');
				$mquestion.html('<span class="errIcon"></span>密保问题长度应大于2位！');
				return false;
			} else {
				$mquestion.removeClass('input_tag1');
				$mquestion.removeClass('input_tag2');
				$mquestion.html('<span class="rightIcon"></span>');
			}
		});
		$ranswer.focus(function() {
			$(this).addClass('input_focus');
			$manswer.removeClass('input_tag2');
			$manswer.addClass('input_tag1');
			$manswer.html('2到20个字符，中文、英文字母（区分大小写）、符号或数字。');
		}).blur(function() {
			$(this).removeClass('input_focus');
			$(this).triggerHandler('keyup');
		}).keyup(function() {
			if ($(this).val() == '') {
				$manswer.removeClass('input_tag1');
				$manswer.addClass('input_tag2');
				$manswer.html('<span class="errIcon"></span>请输入您的密保答案！');
				return false;
			} else if ($(this).val().length < 2) {
				$manswer.removeClass('input_tag1');
				$manswer.addClass('input_tag2');
				$manswer.html('<span class="errIcon"></span>密保答案长度应大于2位！');
				return false;
			} else if ($(this).val() == $rquestion.val()) {
				$manswer.removeClass('input_tag1');
				$manswer.addClass('input_tag2');
				$manswer.html('<span class="errIcon"></span>问题和答案不能相同！');
				return false;
			} else {
				$manswer.removeClass('input_tag1');
				$manswer.removeClass('input_tag2');
				$manswer.html('<span class="rightIcon"></span>');
			}
		});
		$seveProtection.click(function() {
			$("#modifyProtection :input").trigger('keyup');
			$ryear.triggerHandler('change');
			var numError = $('#modifyProtection .errIcon').length;
			if (!numError) {
				$.ajax({
					type: "POST",
					global: false,
					url: zone_domain + "index.php?p=user&a=doProtectionModify",
					data: {
						password: $rpasswords.val(),
						question: escape($rquestion.val()),
						answer: escape($ranswer.val())
					},
					dataType: "text",
					success: function(data) {
						if (data == 1001) {
							libs.userNotLogin('您没有登录，无法更新个人设置！');
						} else if (data == 1014) {
							$.tipMessage('问题和答案不能相同，请重新输入！', 2, 3000);
						} else if (data == 1015) {
							$.tipMessage('当前登陆密码不正确，请重新输入！', 2, 3000);
						} else {
							$.tipMessage('密保已经更新！', 0, 2000);
							window.setTimeout("location.href='"+zone_domain+"index.php?p=user&a=profileModify&i=protection';", 2000);
						}
					}
				});
			}
		});
		$rnickname.focus(function() {
			$(this).addClass('input_focus');
			$mnickname.removeClass('input_tag2');
			$mnickname.addClass('input_tag1');
			$mnickname.html('请填写您的昵称（不能使用空格、数字、和 < > \' \" / \ 等非法字符）。');
		}).blur(function() {
			$(this).removeClass('input_focus');
			$(this).triggerHandler('keyup');
		}).keyup(function() {
			if ($(this).val() == '') {
				$mnickname.removeClass('input_tag1');
				$mnickname.addClass('input_tag2');
				$mnickname.html('<span class="errIcon"></span>请填写您的昵称！');
				return false;
			} else if (!/^([\S])*$/.test($(this).val())) {
				$mnickname.removeClass('input_tag1');
				$mnickname.addClass('input_tag2');
				$mnickname.html('<span class="errIcon"></span>昵称中不能有空格！');
				return false;
			} else if (!/^([^0-9])*$/.test($(this).val())) {
				$mnickname.removeClass('input_tag1');
				$mnickname.addClass('input_tag2');
				$mnickname.html('<span class="errIcon"></span>昵称中不能有数字！');
				return false;
			} else if (!/^([^<>'"\/\\])*$/.test($(this).val())) {
				$mnickname.removeClass('input_tag1');
				$mnickname.addClass('input_tag2');
				$mnickname.html('<span class="errIcon"></span>昵称中不能有 < > \' \" / \\ 等非法字符！');
				return false;
			} else if ($(this).val().length < 2) {
				$mnickname.removeClass('input_tag1');
				$mnickname.addClass('input_tag2');
				$mnickname.html('<span class="errIcon"></span>昵称最少要2位以上！');
				return false;
			} else if ($(this).val().length > 12) {
				$mnickname.removeClass('input_tag1');
				$mnickname.addClass('input_tag2');
				$mnickname.html('<span class="errIcon"></span>昵称不能大于12位！');
				return false;
			}
			$.ajax({
				type: "POST",
				global: false,
				url: zone_domain + "index.php?p=user&a=checkNickname",
				data: {
					nickname: escape($rnickname.val())
				},
				dataType: "text",
				success: function(data) {
					if (data == 1) {
						$mnickname.removeClass('input_tag1');
						$mnickname.addClass('input_tag2');
						$mnickname.html('<span class="errIcon"></span>' + $rnickname.val() + ' 已被别人使用，请更换一个！');
						return false;
					} else if (data == 10000) {
						$mnickname.removeClass('input_tag1');
						$mnickname.removeClass('input_tag2');
						$mnickname.html('<span class="rightIcon"></span>');
					} else if (data == 2) {
						$mnickname.removeClass('input_tag1');
						$mnickname.addClass('input_tag2');
						$mnickname.html('<span class="errIcon"></span>昵称不能超过12个字母或6个汉字');
						return false;
					} else if (data == 3) {
						$mnickname.removeClass('input_tag1');
						$mnickname.addClass('input_tag2');
						$mnickname.html('<span class="errIcon"></span>昵称中至少要含有一个字母或汉字');
						return false;
					} else {
						$mnickname.removeClass('input_tag1');
						$mnickname.addClass('input_tag2');
						$mnickname.html("<span class='errIcon'></span>昵称中不能含有 " + data + " 等字符！");
						return false;
					}
				},
				error: function() {
					$.tipMessage('数据执行错误！', 2, 3000);
					return false;
				}
			});
		});
		$seveNickname.click(function() {
			$("#modifyNickname :input").trigger('keyup');
			var numError = $('#modifyNickname .errIcon').length;
			if (!numError) {
				$.ajax({
					type: "POST",
					global: false,
					url: zone_domain + "index.php?p=user&a=doNicknameModify",
					data: {
						nickname: escape($rnickname.val())
					},
					dataType: "text",
					success: function(data) {
						if (data == 20001) {
							libs.userNotLogin('您没有登录，无法更新个人设置！');
						} else if (data == 10001) {
							libs.redirect(zone_domain + 'index.php?p=user&a=profileModify&i=nickname');
						} else if (data == 10002) {
							$mnickname.removeClass('input_tag1');
							$mnickname.addClass('input_tag2');
							$mnickname.html('<span class="errIcon"></span>' + $rnickname.val() + ' 已被别人使用，请更换一个！');
							return false;
						} else {
							$.tipMessage('昵称已经更新！', 0, 2000);
							window.setTimeout("location.href='"+zone_domain+"index.php?p=user&a=profileModify&i=nickname';", 2000);
						}
					}
				});
			}
		});
	},
	retreat: function() {
		$.ajax({
			type: "POST",
			global: false,
			url: zone_domain + "index.php?p=user&a=retreat",
			dataType: "text",
			success: function(data) {
				if (data == 20001) {
					libs.userNotLogin('您没有登录，无法更新个人设置！');
				} else if (data == 10001) {
					$.tipMessage('无法修改昵称！', 2, 3000);
					libs.redirect(zone_domain + 'index.php?p=user&a=profileModify&i=nickname');
				} else {
					$.tipMessage('修改昵称申请已经提交！', 0, 2000);
					libs.redirect(zone_domain + 'index.php?p=user&a=profileModify&i=nickname');
				}
			}
		});
	},
	certifyInit: function() {
		webcam.set_swf_url(zone_domain + 'static/js/jquery/camera/webcam.swf');
		webcam.set_api_url(zone_domain + 'index.php?p=user&a=doApplyCertify');
		webcam.set_quality(80);
		webcam.set_shutter_sound(true, zone_domain + 'static/js/jquery/camera/shutter.mp3');
		var cam = $("#webcam");
		cam.html(webcam.get_html(cam.width(), cam.height()));
		$("#btn_shoot").click(function() {
			if (webcam.freeze() == 1) {
				$("#shoot").hide();
				$("#upload").show();
			}
			return false;
		});
		$('#btn_cancel').click(function() {
			webcam.reset();
			$("#shoot").show();
			$("#upload").hide();
			return false;
		});
		$('#btn_upload').click(function() {
			webcam.upload();
			$("#loading").show();
			$("#upload").hide();
			return false;
		});
		webcam.set_hook('onComplete',
		function(msg) {
			msg = $.parseJSON(msg);
			if (msg.error) {
				alert(msg.message);
				location.href = location.href;
			} else {
				$("#loading").hide();
				$.tipMessage("照片上传成功，请等待审核！", 0, 3000);
				location.href = location.href;
			}
		});
	}
}