var imgLoaded = {
	imgData: '',
	sTimer: 0,
	imgDataLenth: 0,
	iTotalCount: 0,
	loadImgNum: 20,
	itemType: 1,
	$container: '',
	init: function(obj, imgData, itemType) {
		imgLoaded.$container = $(obj);
		imgLoaded.imgDataLenth = imgData.length;
		imgLoaded.imgData = imgData;
		imgLoaded.itemType = itemType;
		imgLoaded.iTotalCount = 0;
		imgLoaded.$container.html('').masonry({
			itemSelector: '.imageBlock'
		});
		imgLoaded.loadMore();
		$(window).bind("scroll", imgLoaded.scrollHandler);
	},
	loadMore: function() {
		var str = '';
		var startId = imgLoaded.iTotalCount;
		var endId = 0;
		if (startId + imgLoaded.loadImgNum < imgLoaded.imgDataLenth) {
			endId = startId + imgLoaded.loadImgNum;
		}
		 else {
			endId = imgLoaded.imgDataLenth;
		}
		if (startId != imgLoaded.imgDataLenth) {
			for (var i = startId; i < endId; i++) {
				if (imgLoaded.itemType == 1) {
					str += '<li class="imageBlock"><div class="box"><a target="_blank" name="' + imgLoaded.imgData[i]['pid'] + '" href="' + zone_domain + 'index.php?p=space&a=album&uid=' + imgLoaded.imgData[i]['uid'] + '&id=' + imgLoaded.imgData[i]['pid'] + '"><img width="200" height="' + (imgLoaded.imgData[i]['height'] * 200 / (imgLoaded.imgData[i]['width'])) + '" src="' + imgLoaded.imgData[i]['src'] + '"></a><div class="name"><a class="avatar" target="_blank" href="' + zone_domain + 'index.php?p=space&uid=' + imgLoaded.imgData[i]['uid'] + '"><img src="' + imgLoaded.imgData[i]['avatar'] + '"></a><p class="hover"><a class="fb_f" target="_blank" href="' + zone_domain + 'index.php?p=space&uid=' + imgLoaded.imgData[i]['uid'] + '">' + imgLoaded.imgData[i]['nickname'] + '</a><span>' + imgLoaded.imgData[i]['create_time'] + '</span></p><div class="clear"></div></div><div class="info"><span id="praiseCount' + imgLoaded.imgData[i]['pid'] + '">' + imgLoaded.imgData[i]['praiseNum'] + '人喜欢</span><span id="replyNum' + imgLoaded.imgData[i]['pid'] + '" class="last">' + imgLoaded.imgData[i]['replyNum'] + '人评论</span></div></div></li>';
				} else {
					str += '<li class="imageBlock"><div class="box" onmouseover="albumLib.showInit(' + imgLoaded.imgData[i]['pid'] + ');" onmouseout="albumLib.hideInit();"><div class="act"><div class="imgpraise" style="display:none;" id="imgpraise' + imgLoaded.imgData[i]['pid'] + '"><a class="praiseImg" id="praise" onClick="albumLib.doImagePraise(' + imgLoaded.imgData[i]['uid'] + ',' + imgLoaded.imgData[i]['pid'] + ', ' + imgLoaded.imgData[i]['praiseNum'] + ', ' + imgLoaded.imgData[i]['replyNum'] + ');" href="javascript:;">喜欢</a></div></div><a href="' + zone_domain + 'index.php?p=space&a=album&uid=' + imgLoaded.imgData[i]['uid'] + '&id=' + imgLoaded.imgData[i]['pid'] + '" name="' + imgLoaded.imgData[i]['pid'] + '" target="_blank"><img src="' + imgLoaded.imgData[i]['src'] + '" width="200" height="' + (imgLoaded.imgData[i]['height'] * 200 / (imgLoaded.imgData[i]['width'])) + '"/></a><div class="info"><span id="praiseCount' + imgLoaded.imgData[i]['pid'] + '">' + imgLoaded.imgData[i]['praiseNum'] + '人喜欢</span><span id="replyNum' + imgLoaded.imgData[i]['pid'] + '" class="last">' + imgLoaded.imgData[i]['replyNum'] + '人评论</span></div><div class="end_line"></div></div></li>';
				}
				++imgLoaded.iTotalCount;
			}
			if (str != '') {
				if (imgLoaded.iTotalCount <= imgLoaded.loadImgNum) {
					imgLoaded.$container.append(str).masonry("reload");
				}
				 else {
					$str = $(str);
					imgLoaded.$container.append($str).masonry('appended', $str, true);
				}
			}
			if (imgLoaded.iTotalCount == imgLoaded.imgDataLenth) {
				$("#imgLoading").hide();
				$("#imgPages").show();
				$(window).unbind("scroll", imgLoaded.scrollHandler);
			}
			imgLoaded.scrollHandler();
		}
		 else {
			$(window).unbind("scroll", imgLoaded.scrollHandler);
		}
	},
	scrollHandler: function() {
		clearTimeout(imgLoaded.sTimer);
		imgLoaded.sTimer = setTimeout(function() {
			var h = $(window).height(),
			t = $(document).scrollTop();
			if (t + h + 500 >= imgLoaded.$container.offset().top + imgLoaded.$container.height()) {
				imgLoaded.loadMore();
			}
		},
		50);
	}
}
var albumLib = {
	spaceImageInit: function(imgData, uid) {
		imgData = imgData;
		imgUid = uid;
		$container = $('#spaceAlbumList');
		sTimer = "";
		imgDataLenth = imgData.length;
		iCount = new Array();
		iTotalCount = 0;
		imgLoadTotalCount = 0;
		loadMoreCount = 0;
		if ($container.length > 0) {
			$container.html('').masonry({
				itemSelector: '.imageBlock'
			});
			albumLib.loadMore();
			$(window).bind("scroll", albumLib.scrollHandler);
		}
	},
	loadMore: function() {
		var str = '';
		var startId = iTotalCount;
		var endId = 0;
		iCount[loadMoreCount] = 0;
		if (startId + 20 < imgDataLenth) {
			endId = startId + 20;
		}
		 else {
			endId = imgDataLenth;
		}
		if (startId != imgDataLenth) {
			for (var i = startId; i < endId; i++) {
				str += '<li class="imageBlock imageBlock_' + loadMoreCount + '"><div class="box" onmouseover="albumLib.showInit(' + imgData[i]['pid'] + ');" onmouseout="albumLib.hideInit();"><div class="act"><div class="imgpraise" style="display:none;" id="imgpraise' + imgData[i]['pid'] + '"><a class="praiseImg" id="praise" onClick="albumLib.doImagePraise(' + imgUid + ',' + imgData[i]['pid'] + ', ' + imgData[i]['praiseNum'] + ', ' + imgData[i]['replyNum'] + ');" href="javascript:;">喜欢</a></div></div><a href="' + zone_domain + 'index.php?p=space&a=album&uid=' + imgUid + '&id=' + imgData[i]['pid'] + '" name="' + imgData[i]['pid'] + '" target="_blank"><img onload="albumLib.imgLoaded(\'imageBlock_' + loadMoreCount + '\', ' + loadMoreCount + ')" onerror="albumLib.imgLoaded(\'imageBlock_' + loadMoreCount + '\', ' + loadMoreCount + ')" src="' + site_domain + 'data/attachment/' + imgData[i]['src'] + '.thumb_w200.jpg" width="200" /></a><div class="info"><span id="praiseCount' + imgData[i]['pid'] + '">' + imgData[i]['praiseNum'] + '人喜欢</span><span class="last">' + imgData[i]['replyNum'] + '人评论</span></div><div class="end_line"></div></div></li>'; ++iTotalCount;
			}
			$container.append(str);
			albumLib.scrollHandler();
		}
		 else {
			$(window).unbind("scroll", albumLib.scrollHandler);
		}
		++loadMoreCount;
	},
	scrollHandler: function() {
		clearTimeout(sTimer);
		sTimer = setTimeout(function() {
			var h = $(window).height(),
			t = $(document).scrollTop();
			if (t + h + 500 >= $container.offset().top + $container.height()) {
				albumLib.loadMore();
			}
		},
		50);
	},
	imgLoaded: function(obj, id) {++iCount[id]; ++imgLoadTotalCount;
		if (iCount[id] % 20 == 0 || imgLoadTotalCount == imgDataLenth) {
			$("." + obj).fadeIn();
			$container.masonry("reload");
			if (imgLoadTotalCount == imgDataLenth) {
				$(window).unbind("scroll", albumLib.scrollHandler);
			}
		}
	},
	imagesBatchDelInit: function() {
		$(".page #selectAll").click(function() {
			var dialogObj = $.dialog.get('delAlbum');
			if (typeof dialogObj === 'object') {
				dialogObj.close();
			}
			$('#list :checkbox').each(function() {
				$(this).attr('checked', 'checked');
			});
		});
		$(".page #selectOther").click(function() {
			var dialogObj = $.dialog.get('delAlbum');
			if (typeof dialogObj === 'object') {
				dialogObj.close();
			}
			$('#list :checkbox').each(function() {
				if ($(this).attr('checked')) {
					$(this).removeAttr('checked');
				}
				 else {
					$(this).attr('checked', 'checked');
				}
			});
		});
		$('#list input').click(function() {
			var dialogObj = $.dialog.get('delAlbum');
			if (typeof dialogObj === 'object') {
				dialogObj.close();
			}
		});
		$('.page #delButton').click(function() {
			var pidArr = new Array();
			var i = 0;
			$('#list input:checked').each(function() {
				pidArr[i] = $(this).attr('pid');
				i++;
			});
			if (pidArr.length <= 0) {
				$.tipMessage('请选择您要删除的图片！', 1, 2000);
				return false;
			}
			$.dialog({
				id: 'delAlbum',
				title: false,
				border: false,
				follow: $("#delButton")[0],
				content: '确认删除这些照片么？',
				okValue: '确认',
				ok: function() {
					$.ajax({
						type: "POST",
						global: false,
						url: zone_domain + "index.php?p=album&a=doImageBatchDel",
						data: {
							'pidArr': escape(pidArr)
						},
						dataType: "text",
						success: function(data) {
							if (data == 20001) {
								user.userNotLogin('您未登录无法执行此操作！');
							}
							 else if (data == 10000) {
								location.href = location.href;
							}
							 else if (data == 20002) {
								$.tipMessage('您没有权限！', 1, 2000);
							}
							 else if (data == 30000) {
								$.tipMessage('图片不存在或已删除！', 1, 2000, 0,
								function() {
									location.href = location.href;
								});
							} else {
								$.tipMessage(data, 1, 2000);
							}
						},
						error: function() {
							$.tipMessage('数据执行意外错误！', 2, 3000);
						}
					});
				},
				cancelValue: '取消',
				cancel: function() {}
			});
			return false;
		});
	},
	imageDelInit: function() {
		$(".delete").click(function() {
			var pidArr = new Array();
			var showType = $('#showType').val();
			var uid = $(".delete").attr("uid");
			var dialogObj = $.dialog.get('delAlbumComment');
			if (typeof dialogObj === 'object') {
				dialogObj.close();
			}
			pidArr[0] = $(this).attr('pid');
			$.dialog({
				id: 'delAlbumComment',
				title: false,
				border: false,
				follow: $(this)[0],
				content: '确认删除这张照片么？',
				okValue: '确认',
				ok: function() {
					$.ajax({
						type: "POST",
						global: false,
						url: zone_domain + "index.php?p=album&a=doImageBatchDel",
						data: {
							'pidArr': escape(pidArr)
						},
						dataType: "text",
						success: function(data) {
							if (data == 20001) {
								user.userNotLogin('您未登录无法执行此操作！');
							} else if (data == 30000) {
								if (showType == 1) {
									$.tipMessage('图片不存在或已删除！', 1, 2000, 0,
									function() {
										location.href = zone_domain + 'index.php?p=space&a=album&uid=' + uid
									});
								} else {
									$.tipMessage('图片不存在或已删除！', 1, 2000, 0,
									function() {
										location.href = location.href
									});
								}
							} else if (data == 20002) {
								$.tipMessage('您没有权限！', 1, 2000);
							} else if (data == 10005) {
								$.tipMessage('本次操作失败了，请稍后再试！', 1, 2000);
							} else if (data == 10012) {
								$.tipMessage('本次操作失败了，请稍后重试', 1, 2000);
							} else if (data == 10000) {
								if (showType == 1) {
									location.href = zone_domain + 'index.php?p=space&a=album&uid=' + uid;
								} else {
									location.href = location.href;
								}
							}
						},
						error: function() {
							$.tipMessage('数据执行意外错误！', 2, 3000);
						}
					});
				},
				cancelValue: '取消',
				cancel: function() {}
			});
		});
	},
	imageAddInit: function() {
		var hasFlash = true;
		if (browser.ie) {
			try {
				var objFlash = new ActiveXObject("ShockwaveFlash.ShockwaveFlash");
			} catch(e) {
				hasFlash = false;
			}
		}
		 else {
			if (!navigator.plugins["Shockwave Flash"]) {
				hasFlash = false;
			}
		}
		if (!hasFlash) {
			$('#upButton').html('您未安装FLASH控件，无法上传图片！请安装FLASH控件后再试。');
		}
		$(document).ready(function() {
			$("#file_upload").uploadify({
				'swf': zone_domain + 'static/space/js/jquery/uploadify/uploadify.swf',
				'buttonImage': zone_domain + 'static/space/js/jquery/uploadify/upbutton.gif',
				'cancelImage': zone_domain + 'static/space/js/jquery/uploadify/cancel.png',
				'uploader': zone_domain + 'source/module/album/doImage.php?do=add',
				'width': '100',
				'height': '32',
				'auto': false,
				'formData': {
					'userid': _userid,
					'username': _username
				},
				'queueID': 'uploadfileQueue',
				'fileTypeExts': '*.jpg;*.jpeg;*.gif;*.png',
				'fileSizeLimit': 10 * 1024 * 1024,
				'queueSizeLimit': 25,
				'removeTimeout': 2,
				'successTimeout': 0,
				'multi': true,
				'onUploadStart': function(file) {
					$('#uploadInfo').html('正在准备上传 ' + file.name + ' 请稍后！');
				},
				'onUploadSuccess': function(file, data, response) {
					if (data == 10005) {
						$('#file_upload').uploadify('cancel', '*');
						$.tipMessage('您的照片墙已满！', 2, 3000);
						location.href = zone_domain + "index.php?p=album&a=me";
					} else if (data == 10011) {
						$.tipMessage('没有文件！', 1, 2000);
						$('#file_upload').uploadify('cancel', '*');
					} else if (data == '20001') {
						$.tipMessage('用户未登录！', 1, 2000);
						$('#file_upload').uploadify('cancel', '*');
					}
				},
				'onQueueComplete': function(data) {
					$.tipMessage('图片上传完毕！', 0, 2000);
					$('#uploadInfo').html('成功上传的文件数: ' + data.uploadsSuccessful + ' - 上传出错的文件数: ' + data.uploadsErrored);
				}
			});
		});
	},
	imageSortInit: function() {
		$(document).ready(function() {
			$('#imageSort').sortable({
				tolerance: 'pointer'
			});
			$("#imageSort").disableSelection();
		});
		$("#saveButton").click(function() {
			var idArr = new Array();
			var i = 0;
			$(".imageSort .avatar").each(function() {
				idArr[i] = $(this).attr('id');
				i++;
				uid = $(this).attr('uid');
			});
			$.ajax({
				type: "POST",
				global: false,
				url: zone_domain + "index.php?p=album&a=doImageSort",
				data: {
					'idArr': escape(idArr),
					'uid': uid
				},
				dataType: "text",
				success: function(data) {
					if (data == 20001) {
						user.userNotLogin('您需要先登录才能进行删除操作！');
					} else if (data == 20002) {
						$.tipMessage('您没有权限编辑排序！', 1, 2000);
					} else if (data == 10005) {
						$.tipMessage('本次操作失败了，请稍后再试', 1, 2000);
					} else {
						$.tipMessage('照片排列结果已更新！', 0, 2000, 0,
						function() {
							location.href = zone_domain + "index.php?p=album&a=me"
						});
					}
				},
				error: function() {
					$.tipMessage('数据执行意外错误！', 2, 3000);
				}
			});
		});
	},
	imageSpaceSortInit: function() {
		var imgLength = 0;
		$(document).ready(function() {
			var $imageSort1 = ('#imageSort1');
			var $imageSort2 = ('#imageSort2');
			var imgLength = $(".imgfile", $imageSort1).length;
			$('#imageSort1, #imageSort2').sortable({
				opacity: 0.5,
				tolerance: 'pointer',
				connectWith: '.sortable'
			}).disableSelection();
			$('#imageSort1').bind('sortover',
			function(event, ui) {
				imgLength = $(".imgfile", $imageSort1).length;
				if (imgLength >= 7) {
					$("img:last", $imageSort1).prependTo("#imageSort2");
				}
			});
			$('#imageSort2').bind('sortover',
			function(event, ui) {
				imgLength = $(".imgfile", $imageSort1).length;
				if (imgLength <= 7) {
					$("img:first", $imageSort2).appendTo($imageSort1);
				}
			});
		});
		$("#saveButton").click(function() {
			var idArr = new Array();
			var i = 0;
			$(".imageSort .imgfile").each(function() {
				idArr[i] = $(this).attr('id');
				i++;
			});
			$.ajax({
				type: "POST",
				global: false,
				url: zone_domain + "index.php?p=album&a=doImageSpaceSort",
				data: {
					'idArr': escape(idArr)
				},
				dataType: "text",
				success: function(data) {
					if (data == 20001) {
						user.userNotLogin('您需要先登录才能进行删除操作！');
					} else if (data == 10005) {
						$.tipMessage('本次操作失败了，请稍后再试', 1, 2000);
					} else {
						$.tipMessage('照片排列结果已更新！', 0, 2000, 0,
						function() {
							location.href = zone_domain + "index.php?p=album&a=imageSpaceSort"
						});
					}
				},
				error: function() {
					$.tipMessage('数据执行意外错误！', 2, 3000);
				}
			});
		});
	},
	imageNameModifyInit: function() {
		var text = $(".imageShow #imageNameContent");
		$(".imageShow .explain").click(function() {
			var nameInfo = $(".nameInfo").attr("nameInfo");
			$(".imageShow #imageNameInputBox").show();
			$(".imageShow #imageNameContent").val(nameInfo).focus();
		})
		 $(".imageShow #cencel").click(function() {
			$(".imageShow #imageNameInputBox").hide();
		})
		 $(".imageShow .sends").click(function() {
			if (text.val().length < 32) {
				var pid = $(".sends").attr("pid");
				var uid = $(".sends").attr("uid");
				$.ajax({
					type: "POST",
					global: false,
					url: zone_domain + "index.php?p=album&a=doImageNameModify",
					data: {
						'pid': pid,
						'uid': uid,
						'text': escape(text.val())
					},
					dataType: "text",
					success: function(data) {
						if (data == 20001) {
							user.userNotLogin('您需要先登录才能进行删除操作！');
						} else if (data == 20002) {
							$.tipMessage('您没有权限！', 1, 2000);
						} else if (data == 30000) {
							$.tipMessage('图片不存在或已删除！', 1, 2000, 0,
							function() {
								location.href = zone_domain + 'index.php?p=space&a=album&uid=' + uid
							});
						} else if (data == 10005) {
							$.tipMessage('本次操作失败了，请稍后再试！', 1, 2000);
						} else {
							if (data != "") {
								$(".imageShow #nameInfo").html("<span class='lquotes'></span>" + unescape(data) + "<span class='rquotes'></span>");
								$(".nameInfo").attr("nameInfo", unescape(data));
							} else {
								$(".imageShow #nameInfo").html("<span class='lquotes'></span>还没有添加说明！<span class='rquotes'></span>");
							}
						}
					},
					error: function() {
						$.tipMessage('数据执行意外错误！', 2, 3000);
					}
				});
			}
			 else {
				$.tipMessage('您填写的内容太多了！', 1, 2000);
			}
		});
	},
	imageDetailInit: function() {
		var $imgItem = $("#imgItem");
		var $body = $("body");
		$imgItem.mousemove(function(e) {
			var positionX = 0;
			var $this = $(this);
			if (!browser.firefox) {
				positionX = window.event.offsetX;
			}
			 else {
				positionX = e.originalEvent.x || e.originalEvent.layerX || 0;
			}
			if (positionX <= $this.width() / 2) {
				$this.css("cursor", "url(" + zone_domain + "static/space/images/pre.cur),auto").attr('title', '点击查看上一张');
				$this.parent().attr('href', $this.attr('left'));
			}
			 else {
				$this.css("cursor", "url(" + zone_domain + "static/space/images/next.cur),auto").attr('title', '点击查看下一张');
				$this.parent().attr('href', $this.attr('right'));
			}
		});
		$("#imageClick").click(function() {
			if (browser.ie) {
				docWidth = document.documentElement.scrollWidth;
			}
			 else {
				docWidth = $(document).width();
			}
			var $background = $("<div></div>");
			$background.animate({
				'opacity': '.6'
			},
			1000).css({
				"width": docWidth,
				'height': $(document).height(),
				'background': '#656565',
				'z-index': '100',
				'position': 'absolute',
				'top': '0px',
				'left': '0px'
			});
			$body.append($background);
			var $largeimage = $("<img/>");
			$largeimage.attr("src", $imgItem.attr("src")).css({
				'position': 'absolute',
				'z-index': '101',
				'display': 'none',
				'border': '10px solid #fff'
			});
			$body.append($largeimage);
			checkLargeImageWidth();
			var $largeImageBlank = $("<div></div>");
			$largeImageBlank.css({
				"width": docWidth,
				'height': $(document).height(),
				'background': '#656565',
				'z-index': '102',
				'cursor': 'pointer',
				'position': 'absolute',
				'filter': 'alpha(opacity=1)',
				'opacity': '.01',
				'top': '0px',
				'left': '0px'
			});
			$body.append($largeImageBlank);
			$largeimage.fadeIn(2000);
			$largeImageBlank.click(function() {
				$largeimage.fadeOut(1000,
				function() {
					$largeimage.remove();
				})
				 $background.fadeOut(1000,
				function() {
					$background.remove();
				})
				 $largeImageBlank.remove();
			});
			function checkLargeImageWidth() {
				if ($largeimage.width() > 0) {
					$largeimage.css({
						'left': ($body.width() - $largeimage.width() - 20) / 2,
						'top': ($(document).height() - $largeimage.height() - 20) / 2 + 'px',
						'width': $largeimage.width() + 'px',
						'height': $largeimage.height() + 'px'
					});
				}
				 else {
					setTimeout(checkLargeImageWidth, 10);
				}
			}
		});
		var $note = $("#note");
		$note.emotEditor({
			emot: true,
			defaultText: '请在这里输入评论！',
			defaultCss: 'comments_text'
		});
		$("#submitBtn").click(function() {
			var $uid = $(this).attr("uid");
			var $pid = $(this).attr("pid");
			var $replayUser = $("#replayUser");
			var $comments = $('#comments_list');
			var validCharLength = $note.emotEditor("validCharLength");
			if (validCharLength < 1) {
				$.tipMessage('还没有填写评论！', 1, 2000);
				$note.emotEditor("focus");
				return false;
			}
			if (validCharLength <= 75) {
				$.ajax({
					type: "POST",
					global: false,
					url: zone_domain + "index.php?p=album&a=doImageCommentAdd",
					data: {
						uid: $uid,
						pid: $pid,
						replayUser: escape($replayUser.html()),
						note: escape($note.emotEditor("content"))
					},
					dataType: "text",
					success: function(data) {
						if (data == 10007) {
							$.tipMessage('评论内容不能为空！', 1, 2000);
							$note.emotEditor("focus");
							return false;
						} else if (data == 20001) {
							user.userNotLogin('您需要先登录才能进行留言操作！');
							return false;
						} else if (data == 10006) {
							$.tipMessage('您填写的内容太多了！', 1, 2000);
						} else if (data == 30000) {
							$.tipMessage('图片或评论不存在，或已删除！', 1, 2000, 0,
							function() {
								location.href = zone_domain + 'index.php?p=space&a=album&uid=' + $uid
							});
						} else if (data == 10002) {
							$.tipMessage('您操作的太频繁，请稍后再试！', 1, 2000);
							return false;
						} else if (data == 10005) {
							$.tipMessage('本次操作失败了，请稍后重试！', 1, 2000);
							return false;
						} else if (data == 10011) {
							$.tipMessage('啊，出错了！', 2, 3000);
							return false;
						} else {
							$note.emotEditor("reset");
							$("#replayUserDel").hide();
							$("#replayUser").html("").hide();
							$comments.html(data);
						}
					}
				});
			} else {
				$.tipMessage('您填写的内容太多了！', 1, 2000);
				$note.emotEditor("focus");
				return false;
			}
		});
	},
	picPraiseInit: function(uid, pid) {
		var $picPraise = $('#praise');
		var $praiseNum = $('#praiseCount');
		var $praiseImg = $('.praiseImg');
		$.ajax({
			type: "POST",
			global: false,
			url: zone_domain + "index.php?p=album&a=doImagePraiseUpdate",
			data: {
				'uid': uid,
				'pid': pid
			},
			dataType: "text",
			success: function(data) {
				if (data == 20001) {
					user.userNotLogin('您还没有登录，无法喜欢图片哦！');
					return false;
				} else if (data == 30000) {
					$.tipMessage('图片不存在或已删除！', 1, 2000, 0,
					function() {
						location.href = zone_domain + 'index.php?p=space&a=album&uid=' + uid
					});
					return false;
				} else if (data == 10013) {
					$.tipMessage('您只能喜欢别人的图片，不能喜欢自己的图片！', 1, 3000);
					return false;
				} else if (data == 10003) {
					$.tipMessage('您已经赞过这张照片了！', 1, 3000);
				} else {
					$("#picComment").html(data);
					var albumInfo = $('#praiseNum').attr('num');
					$picPraise.html("<div id='praise'><a class='praiseImg' num='" + albumInfo + "' onclick='$call(function(){albumLib.cancelPraiseInit(" + uid + ", " + pid + ")});' " + "onmouseover='$(\"#praiseCount\").html(\"-1\");' onmouseout='$(\"#praiseCount\").html(" + albumInfo + ");' title='取消喜欢'> </a></div>");
					$.tipMessage('喜欢图片成功！', 0, 2000);
				}
			},
			error: function() {
				$.tipMessage('数据执行意外错误！', 2, 3000);
			}
		});
	},
	cancelPraiseInit: function(uid, pid) {
		var $cancelPraise = $('#praise');
		var $cancelNum = $('#cancelCount');
		var $cancelImg = $('.praiseImg');
		$.ajax({
			type: "POST",
			global: false,
			url: zone_domain + "index.php?p=album&a=doImageCancelPraise",
			data: {
				'uid': uid,
				'pid': pid
			},
			dataType: "text",
			success: function(data) {
				if (data == 20001) {
					user.userNotLogin('您还没有登录，无法取消喜欢图片！');
				} else if (data == 30000) {
					$.tipMessage('图片不存在或已删除！', 1, 2000, 0,
					function() {
						location.href = zone_domain + 'index.php?p=space&a=album&uid=' + uid
					});
					return false;
				} else if (data == 10003) {
					$.tipMessage('没有赞过这张图片！', 1, 2000, 0,
					function() {
						location.href = location.href;
					});
					return false;
				} else if (data == 10013) {
					$.tipMessage('这是您自己的图片！', 1, 2000);
					return false;
				} else {
					$("#picComment").html(data);
					var albumInfo = $('#praiseNum').attr('num');
					$cancelPraise.html("<div id='praise'><a class='praiseImg' num='" + albumInfo + "' onclick='$call(function(){albumLib.picPraiseInit(" + uid + ", " + pid + ")});' " + "onmouseover='$(\"#praiseCount\").html(\"+1\");' onmouseout='$(\"#praiseCount\").html(" + albumInfo + ");' title='喜欢就点一下'> </a></div>");
					$.tipMessage('取消喜欢图片成功！', 0, 2000);
				}
			},
			error: function() {
				$.tipMessage('数据执行意外错误！', 2, 3000);
			}
		});
	},
	showInit: function(pid) {
		$("#imgpraise" + pid).show();
	},
	hideInit: function() {
		$(".imgpraise").hide();
	},
	doImagePraise: function(uid, pid, praiseNum, replyNum, filePath) {
		var $praiseNum = $('#praiseCount' + pid);
		var $replyNum = $('#replyNum' + pid);
		$.ajax({
			type: "POST",
			global: false,
			cache: false,
			url: zone_domain + "index.php?p=album&a=doImagePraiseUpdate",
			data: {
				'uid': uid,
				'pid': pid,
				filePath: filePath
			},
			dataType: "text",
			success: function(data) {
				if (data == 20001) {
					user.userNotLogin('您还没有登录，无法喜欢图片！');
				}
				 else if (data == 30000) {
					$.tipMessage('图片不存在或已删除！', 1, 2000, 0,
					function() {
						location.href = location.href;
					});
				}
				 else if (data == 10003) {
					$.tipMessage('您已经赞过这张照片了！', 1, 2000);
				}
				 else if (data == 10013) {
					$.tipMessage('您只能喜欢别人的图片，不能喜欢自己的图片！', 1, 3000);
				}
				 else {
					$praiseNum.html(++praiseNum + "人喜欢");
					$replyNum.html(++replyNum + "人评论");
					$.tipMessage("图片喜欢成功！", 0, 2000);
				}
			},
			error: function() {
				$.tipMessage('数据执行意外错误！', 2, 3000);
			}
		});
	},
	doImageCancelPraise: function(uid, pid, praiseNum, filePath) {
		var $cancelNum = $('#cancelCount' + pid);
		$.ajax({
			type: "POST",
			global: false,
			cache: false,
			url: zone_domain + "index.php?p=album&a=doImageCancelPraise",
			data: {
				'uid': uid,
				'pid': pid,
				filePath: filePath
			},
			dataType: "text",
			success: function(data) {
				if (data == 20001) {
					user.userNotLogin('您还没有登录，无法取消喜欢图片！');
				}
				 else if (data == 30000) {
					$.tipMessage('图片不存在或已删除！', 1, 2000, 0,
					function() {
						location.href = location.href;
					});
					return false;
				}
				 else if (data == 10013) {
					$.tipMessage('这是您自己的图片！', 1, 2000);
					return false;
				}
				 else {
					$praiseNum.html(--praiseNum + "人喜欢");
					$.tipmessagy("取消喜欢成功！", 0, 2000);
				}
			},
			error: function() {
				$.tipMessage('数据执行意外错误！', 2, 3000);
			}
		});
	},
	commentPageInit: function(pum, uid, pid) {
		$.ajax({
			type: "POST",
			global: false,
			url: zone_domain + "index.php?p=album&a=commentPage",
			data: {
				pum: pum,
				uid: uid,
				pid: pid
			},
			dataType: "text",
			success: function(data) {
				$("#comments_list").html(data);
			}
		});
	},
	replayUserInit: function() {
		$(".reply").click(function() {
			var authorId = $(this).attr("authorId");
			var nickname = $(this).attr("nickname");
			$("#replayUser").show();
			$("#replayUserDel").show();
			$("#replayUser").html("回复@" + nickname + "[" + authorId + "]");
			$note = $('#note');
			$note.emotEditor("focus");
		});
	},
	replayUserCancelInit: function() {
		$(".comments_input #replayUserDel").click(function() {
			$("#replayUserDel").hide();
			$("#replayUser").html("").hide();
			$('#note').emotEditor("focus");
		});
	},
	imageCommentDelInit: function() {
		$(".del").click(function() {
			var $comments = $('#commentList');
			var uid = $(".delete").attr("uid");
			var pid = $(".delete").attr("pid");
			var dialogObj = $.dialog.get('delAlbumComment');
			var cid = $(this).attr('cid');
			if (typeof dialogObj === 'object') {
				dialogObj.close();
			}
			$.dialog({
				id: 'delAlbumComment',
				title: false,
				border: false,
				follow: $(this)[0],
				content: '确认删除这条评论么？',
				okValue: '确认',
				ok: function() {
					$.ajax({
						type: "POST",
						global: false,
						url: zone_domain + "index.php?p=album&a=doImageCommentDel",
						data: {
							'cid': cid,
							'pid': pid,
							'uid': uid
						},
						dataType: "text",
						success: function(data) {
							if (data == 20001) {
								user.userNotLogin('您需要先登录才能进行操作！');
							} else if (data == 30000) {
								$.tipMessage('图片不存在或已删除！', 1, 2000, 0,
								function() {
									location.href = location.href;
								});
							} else if (data == 30001) {
								$.tipMessage('评论不存在或已删除！', 1, 2000, 0,
								function() {
									location.href = location.href;
								});
							} else if (data == 20002) {
								$.dialog({
									id: 'delMiniblog',
									title: false,
									icon: 'alert',
									width: '260px',
									lock: true,
									content: '您没有权限删除！',
									okValue: '确认',
									ok: function() {}
								});
							} else if (data == 10005) {
								$.tipMessage('本次操作失败了，请稍后重试！', 1, 2000);
							} else {
								$comments.html(data);
							}
						},
						error: function() {
							$.tipMessage('数据执行意外错误！', 2, 3000);
						}
					});
				},
				cancelValue: '取消',
				cancel: function() {}
			});
		});
	},
	imagePraiseDelInit: function() {
		var lidArr = new Array();
		var pidArr = new Array();
		$(".delete").click(function() {
			lidArr[0] = $(this).attr('id');
			pidArr[0] = $(this).attr('pid');
			$.dialog({
				id: 'delAlbum',
				title: false,
				border: false,
				follow: $(this)[0],
				content: '确认删除这张照片么？',
				okValue: '确认',
				ok: function() {
					$.ajax({
						type: "POST",
						global: false,
						url: zone_domain + "index.php?p=album&a=doImagePraiseBatchDel",
						data: {
							'lidArr': escape(lidArr),
							'pidArr': escape(pidArr)
						},
						dataType: "text",
						success: function(data) {
							if (data == 20001) {
								user.userNotLogin('您需要先登录才能进行删除操作！');
							} else if (data == 10005) {
								$.tipMessage('参数错误！', 1, 2000);
							} else if (data == 30000) {
								$.tipMessage('您喜欢的图片不存在！', 1, 2000, 0,
								function() {
									location.href = location.href;
								});
							} else if (data == 10011) {
								$.tipMessage('数据错误！', 1, 2000);
							} else if (data == 20002) {
								$.tipMessage('您没有权限！', 1, 2000, 0,
								function() {
									location.href = location.href;
								});
							} else if (data == 10012) {
								$.tipMessage('操作失败！', 1, 2000,
								function() {
									location.href = location.href;
								});
							} else {
								location.href = location.href;
							}
						},
						error: function() {
							$.tipMessage('数据执行意外错误！', 2, 3000);
						}
					});
				},
				cancelValue: '取消',
				cancel: function() {}
			});
		});
	},
	imagesPraiseBatchDelInit: function() {
		$(".page #selectAll").click(function() {
			var dialogObj = $.dialog.get('delAlbum');
			if (typeof dialogObj === 'object') {
				dialogObj.close();
			}
			$('#list :checkbox').each(function() {
				$(this).attr('checked', 'checked');
			});
		});
		$(".page #selectOther").click(function() {
			var dialogObj = $.dialog.get('delAlbum');
			if (typeof dialogObj === 'object') {
				dialogObj.close();
			}
			$('#list :checkbox').each(function() {
				if ($(this).attr('checked')) {
					$(this).removeAttr('checked');
				}
				 else {
					$(this).attr('checked', 'checked');
				}
			});
		});
		$('#list input').click(function() {
			var dialogObj = $.dialog.get('delAlbum');
			if (typeof dialogObj === 'object') {
				dialogObj.close();
			}
		});
		$('.page #delButton').click(function() {
			var lidArr = new Array();
			var i = 0;
			$('#list input:checked').each(function() {
				lidArr[i] = $(this).attr('lid');
				i++;
			});
			if (lidArr.length <= 0) {
				$.tipMessage('请选择您要删除的图片！', 1, 2000);
				return false;
			}
			$.dialog({
				id: 'delAlbum',
				title: false,
				border: false,
				follow: $("#delButton")[0],
				content: '确认删除这些照片么？',
				okValue: '确认',
				ok: function() {
					$.ajax({
						type: "POST",
						global: false,
						url: zone_domain + "index.php?p=album&a=doImagePraiseBatchDel",
						data: {
							'lidArr': escape(lidArr)
						},
						dataType: "text",
						success: function(data) {
							if (data == 20001) {
								user.userNotLogin('您需要先登录才能进行删除操作！');
							} else if (data == 10005) {
								$.tipMessage('参数错误！', 1, 2000);
							} else if (data == 10011) {
								$.tipMessage('数据错误！', 1, 2000);
							} else if (data == 20002) {
								$.tipMessage('您没有权限！', 1, 2000, 0,
								function() {
									location.href = location.href;
								});
							} else if (data == 10012) {
								$.tipMessage('操作失败！', 1, 2000, 0,
								function() {
									location.href = location.href;
								});
							} else {
								location.href = location.href;
							}
						},
						error: function() {
							$.tipMessage('数据执行意外错误！', 2, 3000);
						}
					});
				},
				cancelValue: '取消',
				cancel: function() {}
			});
			return false;
		});
	}
}