var imgFous = {
	prevBtn: null,
	nextBtn: null,
	leg: null,
	num: 0,
	imgWidth: 0,
	imgLeft: 0,
	smalPic: null,
	timmer: null,
	number: 0,
	x1: 0,
	init: function(leftBtn, rightBtn, objImg, marginLeft, number) {
		imgFous.prevBtn = leftBtn;
		imgFous.nextBtn = rightBtn;
		imgFous.leg = objImg.find("li").size();
		imgFous.smalPic = objImg.find('ul').eq(0);
		imgFous.imgWidth = objImg.find("li").width();
		imgFous.imgLeft = marginLeft;
		imgFous.number = number;
		imgFous.x1 = imgFous.imgWidth + marginLeft;
		imgFous.smalPic.width(Math.floor(imgFous.leg * (imgFous.imgWidth + marginLeft)));
		leftBtn[0].onclick = imgFous.leftStart;
		rightBtn[0].onclick = imgFous.rightStart;
		if (currentPhotoIndex > 3 && imgFous.leg > 7) {
			imgFous.num = currentPhotoIndex - 3
			if (imgFous.num > imgFous.leg - imgFous.number) {
				imgFous.num = imgFous.leg - imgFous.number
			}
			imgFous.smalPic.animate({
				left: -(imgFous.num * imgFous.x1)
			},
			400);
		}
	},
	leftStart: function() {
		if (imgFous.num > 0) {
			imgFous.num -= imgFous.number
			if (imgFous.num < 0) {
				imgFous.num = 0
			}
			imgFous.smalPic.animate({
				left: -(imgFous.num * imgFous.x1)
			},
			400);
		} else {}
	},
	rightStart: function() {
		if (imgFous.num < imgFous.leg - imgFous.number) {
			imgFous.num += imgFous.number;
			if (imgFous.num > imgFous.leg - imgFous.number) {
				imgFous.num = imgFous.leg - imgFous.number
			}
			imgFous.smalPic.animate({
				left: -(imgFous.num * imgFous.x1)
			},
			400);
		}
		 else {}
	},
	imgCss: function(n) {
		$("#smalListPic>ul>li img").eq(n).addClass("select").siblings().removeClass("select");
	}
}
function initleftRight(imgHeight) {
	var objHeight = imgHeight - 25;
	$(".nph_btn_pphoto").height(objHeight);
	$(".nph_btn_nphoto").height(objHeight);
	var oBtn = $(".rotation>p");
	if (objHeight > 800) {
		oBtn.css("top", 360);
	}
	 else {
		oBtn.css("top", (objHeight - oBtn.eq(0).height()) / 2);
	}
}
function timerFn(imgHeight) {
	if (imgHeight > 100) {
		initleftRight(imgHeight)
	}
}
function xiaoGuo() {
	$("#bigImage").hide();
	$("#bigImage").fadeIn();
}
function navEffect() {
	var oBtn = $(".rotation>p");
	var offset = oBtn.eq(0).offset();
	var offset2 = oBtn.eq(1).offset();
	var fistTop = offset.top;
	var fistTop2 = oBtn.eq(1).position().top;
	var fistLeft = offset.left;
	var fistLeft1 = oBtn.eq(0).position().left;
	var fistLeft2 = offset2.left;
	var fistLeft22 = oBtn.eq(1).position().left;
	$(window).scroll(function() {
		fexed()
	});
	$(window).resize(function() {
		fexed()
	});
	var marginLeft = null;
	function fexed() {
		if ($(document).scrollTop() >= fistTop) {
			if ($.browser.msie && $.browser.version < 7) {
				oBtn.css({
					top: $(document).scrollTop() - 230
				});
			} else {
				oBtn.eq(0).css({
					position: "fixed",
					top: 0,
					left: fistLeft,
					zIndex: "3"
				});
				oBtn.eq(1).css({
					position: "fixed",
					top: 0,
					left: fistLeft2,
					zIndex: "3"
				});
			}
		} else {
			oBtn.eq(0).css({
				position: "absolute",
				top: fistTop2,
				left: fistLeft1
			});
			oBtn.eq(1).css({
				position: "absolute",
				top: fistTop2,
				left: fistLeft22
			});
		}
	}
}
$(function() {
	var scrollleft = $('#prevBtn');
	var scrollright = $('#nextBtn');
	var smalPic = $("#smalListPic");
	var imgLeft = 13;
	var areaNum = 7;
	imgFous.init(scrollleft, scrollright, smalPic, imgLeft, areaNum);
	imgFous.imgCss(currentPhotoIndex);
})