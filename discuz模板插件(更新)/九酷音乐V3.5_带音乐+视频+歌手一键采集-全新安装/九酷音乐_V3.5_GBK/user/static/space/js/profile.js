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
			$mbirth.html('��ѡ���������ա�');
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
			$mbirth.html('��ѡ���������ա�');
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
			$mbirth.html('��ѡ���������ա�');
		}).blur(function() {
			$(this).removeClass('select_focus');
			$ryear.triggerHandler('change');
		}).change(function() {
			if ($ryear.val() == 0 || $rmonth.val() == 0 || $rday.val() == 0) {
				$mbirth.removeClass('input_tag1');
				$mbirth.addClass('input_tag2');
				$mbirth.html('<span class="errIcon"></span>����ȷѡ���������գ�');
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
			$maddress.html('�뵥��ѡ���������ڳ��С�');
		}).blur(function() {
			$(this).removeClass('input_focus');
			$(this).triggerHandler('keyup');
		}).keyup(function() {
			if ($(this).val() == '' || $(this).val() == '��ѡ�����') {
				$maddress.removeClass('input_tag1');
				$maddress.addClass('input_tag2');
				$maddress.html('<span class="errIcon"></span>��ѡ�������ڵĳ��У�');
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
			$mqq.html('��������QQ�ţ�ֻ��վ����Ա��ϵʹ�ã����ṫ����');
		}).blur(function() {
			$(this).removeClass('input_focus');
			$(this).triggerHandler('keyup');
		}).keyup(function() {
			var search_str = /^[1-9][0-9]{4,}$/;
			if ($(this).val() == '') {
				$mqq.removeClass('input_tag1');
				$mqq.addClass('input_tag2');
				$mqq.html('<span class="errIcon"></span>����������QQ���룡');
				return false;
			}
			if (!search_str.test($(this).val())) {
				$mqq.removeClass('input_tag1');
				$mqq.addClass('input_tag2');
				$mqq.html('<span class="errIcon"></span>��������ȷ��QQ�ţ�');
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
			$memail.html('��ȫ�����ܹ�����ȡ�������ǵ����롣');
		}).blur(function() {
			$(this).removeClass('input_focus');
			$(this).triggerHandler('keyup');
		}).keyup(function() {
			var search_str = /^[\w\-\.]+@[\w\-\.]+(\.\w+)+$/;
			if ($(this).val() == '') {
				$memail.removeClass('input_tag1');
				$memail.addClass('input_tag2');
				$memail.html('<span class="errIcon"></span>����������email��');
				return false;
			} else if (!search_str.test($(this).val())) {
				$memail.removeClass('input_tag1');
				$memail.addClass('input_tag2');
				$memail.html('<span class="errIcon"></span>email��ʽ����ȷ��');
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
						$memail.html('<span class="errIcon"></span>�������Ѿ����ڣ������һ����');
						return false;
					} else if (data == 10000) {
						$memail.removeClass('input_tag1');
						$memail.removeClass('input_tag2');
						$memail.html('<span class="rightIcon"></span>');
					} else if (data == 1) {
						$memail.removeClass('input_tag1');
						$memail.addClass('input_tag2');
						$memail.html('<span class="errIcon"></span>����ĵ��������ʽ����ȷ��');
						return false;
					} else {
						$.tipMessage("ִ��ʧ�ܡ�" + data, 2, 2000);
						return false;
					}
				},
				error: function() {
					$.tipMessage("����ִ�д���", 2, 3000);
					return false;
				}
			});
		});
		$rselfIntroduce.focus(function() {
			$mselfIntroduce.removeClass('input_tag2');
			$mselfIntroduce.addClass('input_tag1');
			$(this).addClass('input_focus');
			$mselfIntroduce.html('���ݲ��ܳ���160����ĸ��80������');
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
				if (note == "����QQ") {
					var qqPrivacy = 1;
				} else {
					var qqPrivacy = 0;
				}
				if ($rselfIntroduce.val().length > 160) {
					$mselfIntroduce.html('���ݲ��ܳ���160����ĸ��80������');
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
							libs.userNotLogin('��û�е�¼���޷����¸������ã�');
						} else if (data == 10004) {
							$.tipMessage('��ѡ����ȷ�ĳ��У�', 1, 1000);
						} else if (data == 2) {
							$mselfIntroduce.removeClass('input_tag1');
							$mselfIntroduce.addClass('input_tag2');
							$mselfIntroduce.html('<span class="errIcon"></span>�����ַ�����');
							return false;
						} else if (data == 3) {
							$mselfIntroduce.removeClass('input_tag1');
							$mselfIntroduce.addClass('input_tag2');
							$mselfIntroduce.html('<span class="errIcon"></span>�ǳ�������Ҫ����һ����ĸ����');
							return false;
						} else if (data == 10000) {
							$.tipMessage('�����Ѿ����£�', 0, 3000);
						} else {
							$mselfIntroduce.removeClass('input_tag1');
							$mselfIntroduce.addClass('input_tag2');
							$mselfIntroduce.html('<span class="errIcon"></span>�ǳ��в��ܺ��� ' + data + ' ���ַ���');
						}
					}
				});
			}
		});
		$roldpassword.focus(function() {
			$(this).addClass('input_focus');
			$moldpassword.removeClass('input_tag2');
			$moldpassword.addClass('input_tag1');
			$moldpassword.html('����������ǰʹ�õ����롣');
		}).blur(function() {
			$(this).removeClass('input_focus');
			$(this).triggerHandler('keyup');
		}).keyup(function() {
			if ($(this).val() == '') {
				$moldpassword.removeClass('input_tag1');
				$moldpassword.addClass('input_tag2');
				$moldpassword.html('<span class="errIcon"></span>����������ǰ�����룡');
				return false;
			} else if ($(this).val().length < 6) {
				$moldpassword.removeClass('input_tag1');
				$moldpassword.addClass('input_tag2');
				$moldpassword.html('<span class="errIcon"></span>���볤��Ӧ����6λ��');
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
			$mpassword.html('6���ַ����ϣ���ĸ���ִ�Сд��');
		}).blur(function() {
			$(this).removeClass('input_focus');
			$(this).triggerHandler('keyup');
		}).keyup(function() {
			if ($(this).val() == '') {
				$mpassword.removeClass('input_tag1');
				$mpassword.addClass('input_tag2');
				$mpassword.html('<span class="errIcon"></span>���������������룡');
				return false;
			} else if ($(this).val().length < 6) {
				$mpassword.removeClass('input_tag1');
				$mpassword.addClass('input_tag2');
				$mpassword.html('<span class="errIcon"></span>���볤��Ӧ����6λ��');
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
			$mpassword2.html('�ٴ������������õ������룬��ȷ����������');
		}).blur(function() {
			$(this).removeClass('input_focus');
			$(this).triggerHandler('keyup');
		}).keyup(function() {
			if ($(this).val() == '') {
				$mpassword2.removeClass('input_tag1');
				$mpassword2.addClass('input_tag2');
				$mpassword2.html('<span class="errIcon"></span>������ȷ�������룡');
				return false;
			} else if ($(this).val() != $rpassword.val()) {
				$mpassword2.removeClass('input_tag1');
				$mpassword2.addClass('input_tag2');
				$mpassword2.html('<span class="errIcon"></span>�����������벻��ͬ��');
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
							libs.userNotLogin('��û�е�¼���޷����¸������ã�');
						} else if (data == 20021) {
							$.tipMessage('�����������벻һ�£����������룡', 2, 3000);
						} else if (data == 20022) {
							$.tipMessage('��ǰ���벻��ȷ�����������룡', 2, 3000);
							$("#roldpassword").focus();
						} else {
							$.tipMessage('�����Ѿ����£�', 0, 3000);
						}
					}
				});
			}
		});
		$rpasswords.focus(function() {
			$(this).addClass('input_focus');
			$mpasswords.removeClass('input_tag2');
			$mpasswords.addClass('input_tag1');
			$mpasswords.html('����������ǰ�ĵ�½���룡');
		}).blur(function() {
			$(this).removeClass('input_focus');
			$(this).triggerHandler('keyup');
		}).keyup(function() {
			if ($(this).val() == '') {
				$mpasswords.removeClass('input_tag1');
				$mpasswords.addClass('input_tag2');
				$mpasswords.html('<span class="errIcon"></span>����������ǰ�ĵ�½���룡');
				return false;
			} else if ($(this).val().length < 6) {
				$mpasswords.removeClass('input_tag1');
				$mpasswords.addClass('input_tag2');
				$mpasswords.html('<span class="errIcon"></span>���볤��Ӧ����6λ��');
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
			$mquestion.html('2��20���ַ������ġ�Ӣ����ĸ�����ִ�Сд�������Ż����֡�');
		}).blur(function() {
			$(this).removeClass('input_focus');
			$(this).triggerHandler('keyup');
		}).keyup(function() {
			if ($(this).val() == '') {
				$mquestion.removeClass('input_tag1');
				$mquestion.addClass('input_tag2');
				$mquestion.html('<span class="errIcon"></span>�����������ܱ����⣡');
				return false;
			} else if ($(this).val().length < 2) {
				$mquestion.removeClass('input_tag1');
				$mquestion.addClass('input_tag2');
				$mquestion.html('<span class="errIcon"></span>�ܱ����ⳤ��Ӧ����2λ��');
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
			$manswer.html('2��20���ַ������ġ�Ӣ����ĸ�����ִ�Сд�������Ż����֡�');
		}).blur(function() {
			$(this).removeClass('input_focus');
			$(this).triggerHandler('keyup');
		}).keyup(function() {
			if ($(this).val() == '') {
				$manswer.removeClass('input_tag1');
				$manswer.addClass('input_tag2');
				$manswer.html('<span class="errIcon"></span>�����������ܱ��𰸣�');
				return false;
			} else if ($(this).val().length < 2) {
				$manswer.removeClass('input_tag1');
				$manswer.addClass('input_tag2');
				$manswer.html('<span class="errIcon"></span>�ܱ��𰸳���Ӧ����2λ��');
				return false;
			} else if ($(this).val() == $rquestion.val()) {
				$manswer.removeClass('input_tag1');
				$manswer.addClass('input_tag2');
				$manswer.html('<span class="errIcon"></span>����ʹ𰸲�����ͬ��');
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
							libs.userNotLogin('��û�е�¼���޷����¸������ã�');
						} else if (data == 1014) {
							$.tipMessage('����ʹ𰸲�����ͬ�����������룡', 2, 3000);
						} else if (data == 1015) {
							$.tipMessage('��ǰ��½���벻��ȷ�����������룡', 2, 3000);
						} else {
							$.tipMessage('�ܱ��Ѿ����£�', 0, 2000);
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
			$mnickname.html('����д�����ǳƣ�����ʹ�ÿո����֡��� < > \' \" / \ �ȷǷ��ַ�����');
		}).blur(function() {
			$(this).removeClass('input_focus');
			$(this).triggerHandler('keyup');
		}).keyup(function() {
			if ($(this).val() == '') {
				$mnickname.removeClass('input_tag1');
				$mnickname.addClass('input_tag2');
				$mnickname.html('<span class="errIcon"></span>����д�����ǳƣ�');
				return false;
			} else if (!/^([\S])*$/.test($(this).val())) {
				$mnickname.removeClass('input_tag1');
				$mnickname.addClass('input_tag2');
				$mnickname.html('<span class="errIcon"></span>�ǳ��в����пո�');
				return false;
			} else if (!/^([^0-9])*$/.test($(this).val())) {
				$mnickname.removeClass('input_tag1');
				$mnickname.addClass('input_tag2');
				$mnickname.html('<span class="errIcon"></span>�ǳ��в��������֣�');
				return false;
			} else if (!/^([^<>'"\/\\])*$/.test($(this).val())) {
				$mnickname.removeClass('input_tag1');
				$mnickname.addClass('input_tag2');
				$mnickname.html('<span class="errIcon"></span>�ǳ��в����� < > \' \" / \\ �ȷǷ��ַ���');
				return false;
			} else if ($(this).val().length < 2) {
				$mnickname.removeClass('input_tag1');
				$mnickname.addClass('input_tag2');
				$mnickname.html('<span class="errIcon"></span>�ǳ�����Ҫ2λ���ϣ�');
				return false;
			} else if ($(this).val().length > 12) {
				$mnickname.removeClass('input_tag1');
				$mnickname.addClass('input_tag2');
				$mnickname.html('<span class="errIcon"></span>�ǳƲ��ܴ���12λ��');
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
						$mnickname.html('<span class="errIcon"></span>' + $rnickname.val() + ' �ѱ�����ʹ�ã������һ����');
						return false;
					} else if (data == 10000) {
						$mnickname.removeClass('input_tag1');
						$mnickname.removeClass('input_tag2');
						$mnickname.html('<span class="rightIcon"></span>');
					} else if (data == 2) {
						$mnickname.removeClass('input_tag1');
						$mnickname.addClass('input_tag2');
						$mnickname.html('<span class="errIcon"></span>�ǳƲ��ܳ���12����ĸ��6������');
						return false;
					} else if (data == 3) {
						$mnickname.removeClass('input_tag1');
						$mnickname.addClass('input_tag2');
						$mnickname.html('<span class="errIcon"></span>�ǳ�������Ҫ����һ����ĸ����');
						return false;
					} else {
						$mnickname.removeClass('input_tag1');
						$mnickname.addClass('input_tag2');
						$mnickname.html("<span class='errIcon'></span>�ǳ��в��ܺ��� " + data + " ���ַ���");
						return false;
					}
				},
				error: function() {
					$.tipMessage('����ִ�д���', 2, 3000);
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
							libs.userNotLogin('��û�е�¼���޷����¸������ã�');
						} else if (data == 10001) {
							libs.redirect(zone_domain + 'index.php?p=user&a=profileModify&i=nickname');
						} else if (data == 10002) {
							$mnickname.removeClass('input_tag1');
							$mnickname.addClass('input_tag2');
							$mnickname.html('<span class="errIcon"></span>' + $rnickname.val() + ' �ѱ�����ʹ�ã������һ����');
							return false;
						} else {
							$.tipMessage('�ǳ��Ѿ����£�', 0, 2000);
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
					libs.userNotLogin('��û�е�¼���޷����¸������ã�');
				} else if (data == 10001) {
					$.tipMessage('�޷��޸��ǳƣ�', 2, 3000);
					libs.redirect(zone_domain + 'index.php?p=user&a=profileModify&i=nickname');
				} else {
					$.tipMessage('�޸��ǳ������Ѿ��ύ��', 0, 2000);
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
				$.tipMessage("��Ƭ�ϴ��ɹ�����ȴ���ˣ�", 0, 3000);
				location.href = location.href;
			}
		});
	}
}