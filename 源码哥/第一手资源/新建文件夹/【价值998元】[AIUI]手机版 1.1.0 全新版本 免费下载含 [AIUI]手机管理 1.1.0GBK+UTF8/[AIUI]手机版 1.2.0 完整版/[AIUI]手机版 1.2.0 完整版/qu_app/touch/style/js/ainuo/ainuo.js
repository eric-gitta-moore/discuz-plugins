var supporttouch = "ontouchend" in document;
!supporttouch && (window.location.href = 'forum.php?mobile=1');

var platform = navigator.platform;
var ua = navigator.userAgent;
var ios = /iPhone|iPad|iPod/.test(platform) && ua.indexOf( "AppleWebKit" ) > -1;
var andriod = ua.indexOf( "Android" ) > -1;


(function($, window, document, undefined) {
	var dataPropertyName = "virtualMouseBindings",
		touchTargetPropertyName = "virtualTouchID",
		virtualEventNames = "vmouseover vmousedown vmousemove vmouseup vclick vmouseout vmousecancel".split(" "),
		touchEventProps = "clientX clientY pageX pageY screenX screenY".split( " " ),
		mouseHookProps = $.event.mouseHooks ? $.event.mouseHooks.props : [],
		mouseEventProps = $.event.props.concat( mouseHookProps ),
		activeDocHandlers = {},
		resetTimerID = 0,
		startX = 0,
		startY = 0,
		didScroll = false,
		clickBlockList = [],
		blockMouseTriggers = false,
		blockTouchTriggers = false,
		eventCaptureSupported = "addEventListener" in document,
		$document = $(document),
		nextTouchID = 1,
		lastTouchID = 0, threshold;
	$.vmouse = {
		moveDistanceThreshold: 10,
		clickDistanceThreshold: 10,
		resetTimerDuration: 1500
	};
	function getNativeEvent(event) {
		while( event && typeof event.originalEvent !== "undefined" ) {
			event = event.originalEvent;
		}
		return event;
	}
	function createVirtualEvent(event, eventType) {
		var t = event.type, oe, props, ne, prop, ct, touch, i, j, len;
		event = $.Event(event);
		event.type = eventType;
		oe = event.originalEvent;
		props = $.event.props;
		if(t.search(/^(mouse|click)/) > -1 ) {
			props = mouseEventProps;
		}
		if(oe) {
			for(i = props.length, prop; i;) {
				prop = props[ --i ];
				event[ prop ] = oe[ prop ];
			}
		}
		if(t.search(/mouse(down|up)|click/) > -1 && !event.which) {
			event.which = 1;
		}
		if(t.search(/^touch/) !== -1) {
			ne = getNativeEvent(oe);
			t = ne.touches;
			ct = ne.changedTouches;
			touch = (t && t.length) ? t[0] : (( ct && ct.length) ? ct[0] : undefined);
			if(touch) {
				for(j = 0, len = touchEventProps.length; j < len; j++) {
					prop = touchEventProps[j];
					event[prop] = touch[prop];
				}
			}
		}
		return event;
	}
	function getVirtualBindingFlags(element) {
		var flags = {},
			b, k;
		while(element) {
			b = $.data(element, dataPropertyName);
			for(k in b) {
				if(b[k]) {
					flags[k] = flags.hasVirtualBinding = true;
				}
			}
			element = element.parentNode;
		}
		return flags;
	}
	function getClosestElementWithVirtualBinding(element, eventType) {
		var b;
		while(element) {
			b = $.data( element, dataPropertyName );
			if(b && (!eventType || b[eventType])) {
				return element;
			}
			element = element.parentNode;
		}
		return null;
	}
	function enableTouchBindings() {
		blockTouchTriggers = false;
	}
	function disableTouchBindings() {
		blockTouchTriggers = true;
	}
	function enableMouseBindings() {
		lastTouchID = 0;
		clickBlockList.length = 0;
		blockMouseTriggers = false;
		disableTouchBindings();
	}
	function disableMouseBindings() {
		enableTouchBindings();
	}
	function startResetTimer() {
		clearResetTimer();
		resetTimerID = setTimeout(function() {
			resetTimerID = 0;
			enableMouseBindings();
		}, $.vmouse.resetTimerDuration);
	}
	function clearResetTimer() {
		if(resetTimerID ) {
			clearTimeout(resetTimerID);
			resetTimerID = 0;
		}
	}
	function triggerVirtualEvent(eventType, event, flags) {
		var ve;
		if((flags && flags[eventType]) ||
					(!flags && getClosestElementWithVirtualBinding(event.target, eventType))) {
			ve = createVirtualEvent(event, eventType);
			$(event.target).trigger(ve);
		}
		return ve;
	}
	function mouseEventCallback(event) {
		var touchID = $.data(event.target, touchTargetPropertyName);
		if(!blockMouseTriggers && (!lastTouchID || lastTouchID !== touchID)) {
			var ve = triggerVirtualEvent("v" + event.type, event);
			if(ve) {
				if(ve.isDefaultPrevented()) {
					event.preventDefault();
				}
				if(ve.isPropagationStopped()) {
					event.stopPropagation();
				}
				if(ve.isImmediatePropagationStopped()) {
					event.stopImmediatePropagation();
				}
			}
		}
	}
	function handleTouchStart(event) {
		var touches = getNativeEvent(event).touches,
			target, flags;
		if(touches && touches.length === 1) {
			target = event.target;
			flags = getVirtualBindingFlags(target);
			if(flags.hasVirtualBinding) {
				lastTouchID = nextTouchID++;
				$.data(target, touchTargetPropertyName, lastTouchID);
				clearResetTimer();
				disableMouseBindings();
				didScroll = false;
				var t = getNativeEvent(event).touches[0];
				startX = t.pageX;
				startY = t.pageY;
				triggerVirtualEvent("vmouseover", event, flags);
				triggerVirtualEvent("vmousedown", event, flags);
			}
		}
	}
	function handleScroll(event) {
		if(blockTouchTriggers) {
			return;
		}
		if(!didScroll) {
			triggerVirtualEvent("vmousecancel", event, getVirtualBindingFlags(event.target));
		}
		didScroll = true;
		startResetTimer();
	}
	function handleTouchMove(event) {
		if(blockTouchTriggers) {
			return;
		}
		var t = getNativeEvent(event).touches[0],
			didCancel = didScroll,
			moveThreshold = $.vmouse.moveDistanceThreshold,
			flags = getVirtualBindingFlags(event.target);
			didScroll = didScroll ||
				(Math.abs(t.pageX - startX) > moveThreshold ||
					Math.abs(t.pageY - startY) > moveThreshold);
		if(didScroll && !didCancel) {
			triggerVirtualEvent("vmousecancel", event, flags);
		}
		triggerVirtualEvent("vmousemove", event, flags);
		startResetTimer();
	}
	function handleTouchEnd(event) {
		if(blockTouchTriggers) {
			return;
		}
		disableTouchBindings();
		var flags = getVirtualBindingFlags(event.target), t;
		triggerVirtualEvent("vmouseup", event, flags);
		if(!didScroll) {
			var ve = triggerVirtualEvent("vclick", event, flags);
			if(ve && ve.isDefaultPrevented()) {
				t = getNativeEvent(event).changedTouches[0];
				clickBlockList.push({
					touchID: lastTouchID,
					x: t.clientX,
					y: t.clientY
				});
				blockMouseTriggers = true;
			}
		}
		triggerVirtualEvent("vmouseout", event, flags);
		didScroll = false;
		startResetTimer();
	}
	function hasVirtualBindings(ele) {
		var bindings = $.data( ele, dataPropertyName ), k;
		if(bindings) {
			for(k in bindings) {
				if(bindings[k]) {
					return true;
				}
			}
		}
		return false;
	}
	function dummyMouseHandler() {}

	function getSpecialEventObject(eventType) {
		var realType = eventType.substr(1);
		return {
			setup: function(data, namespace) {
				if(!hasVirtualBindings(this)) {
					$.data(this, dataPropertyName, {});
				}
				var bindings = $.data(this, dataPropertyName);
				bindings[eventType] = true;
				activeDocHandlers[eventType] = (activeDocHandlers[eventType] || 0) + 1;
				if(activeDocHandlers[eventType] === 1) {
					$document.bind(realType, mouseEventCallback);
				}
				$(this).bind(realType, dummyMouseHandler);
				if(eventCaptureSupported) {
					activeDocHandlers["touchstart"] = (activeDocHandlers["touchstart"] || 0) + 1;
					if(activeDocHandlers["touchstart"] === 1) {
						$document.bind("touchstart", handleTouchStart)
							.bind("touchend", handleTouchEnd)
							.bind("touchmove", handleTouchMove)
							.bind("scroll", handleScroll);
					}
				}
			},
			teardown: function(data, namespace) {
				--activeDocHandlers[eventType];
				if(!activeDocHandlers[eventType]) {
					$document.unbind(realType, mouseEventCallback);
				}
				if(eventCaptureSupported) {
					--activeDocHandlers["touchstart"];
					if(!activeDocHandlers["touchstart"]) {
						$document.unbind("touchstart", handleTouchStart)
							.unbind("touchmove", handleTouchMove)
							.unbind("touchend", handleTouchEnd)
							.unbind("scroll", handleScroll);
					}
				}
				var $this = $(this),
					bindings = $.data(this, dataPropertyName);
				if(bindings) {
					bindings[eventType] = false;
				}
				$this.unbind(realType, dummyMouseHandler);
				if(!hasVirtualBindings(this)) {
					$this.removeData(dataPropertyName);
				}
			}
		};
	}
	for(var i = 0; i < virtualEventNames.length; i++) {
		$.event.special[virtualEventNames[i]] = getSpecialEventObject(virtualEventNames[i]);
	}
	if(eventCaptureSupported) {
		document.addEventListener("click", function(e) {
			var cnt = clickBlockList.length,
				target = e.target,
				x, y, ele, i, o, touchID;
			if(cnt) {
				x = e.clientX;
				y = e.clientY;
				threshold = $.vmouse.clickDistanceThreshold;
				ele = target;
				while(ele) {
					for(i = 0; i < cnt; i++) {
						o = clickBlockList[i];
						touchID = 0;
						if((ele === target && Math.abs(o.x - x) < threshold && Math.abs(o.y - y) < threshold) ||
									$.data(ele, touchTargetPropertyName) === o.touchID) {
							e.preventDefault();
							e.stopPropagation();
							return;
						}
					}
					ele = ele.parentNode;
				}
			}
		}, true);
	}
})(jQuery, window, document);

(function($, window, undefined) {
	function triggercustomevent(obj, eventtype, event) {
		var origtype = event.type;
		event.type = eventtype;
		$.event.handle.call(obj, event);
		event.type = origtype;
	}

	$.event.special.tap = {
		setup : function() {
			var thisobj = this;
			var obj = $(thisobj);
			obj.on('vmousedown', function(e) {
				if(e.which && e.which !== 1) {
					return false;
				}
				var origtarget = e.target;
				var origevent = e.originalEvent;
				var timer;

				function cleartaptimer() {
					clearTimeout(timer);
				}
				function cleartaphandlers() {
					cleartaptimer();
					obj.off('vclick', clickhandler)
						.off('vmouseup', cleartaptimer);
					$(document).off('vmousecancel', cleartaphandlers);
				}

				function clickhandler(e) {
					cleartaphandlers();
					if(origtarget === e.target) {
						triggercustomevent(thisobj, 'tap', e);
					}
					return false;
				}

				obj.on('vmouseup', cleartaptimer)
					.on('vclick', clickhandler)
				$(document).on('touchcancel', cleartaphandlers);

				timer = setTimeout(function() {
					triggercustomevent(thisobj, 'taphold', $.Event('taphold', {target:origtarget}));
				}, 750);
				return false;
			});
		}
	};
	$.each(('tap').split(' '), function(index, name) {
		$.fn[name] = function(fn) {
			return this.on(name, fn);
		};
	});

})(jQuery, this);

var ainuopage = {
	converthtml : function() {
		var prevpage = $('div.pg .prev').prop('href');
		var nextpage = $('div.pg .nxt').prop('href');
		var lastpage = $('div.pg label span').text().replace(/[^\d]/g, '') || 0;
		var curpage =  $('div.pg input').val() || 1;

		if(!lastpage) {
			prevpage = $('div.pg .pgb a').prop('href');
		}

		var prevpagehref = nextpagehref = firstpagehref = lastpagehref = '';
		
		
		if(prevpage == undefined) {
			prevpagehref = 'javascript:;" class="grey';
			firstpagehref = 'javascript:;" class="grey';
		} else {
			prevpagehref = prevpage;
			firstpagehref = prevpage.replace(/page=\d+/, 'page=1');
		}
		if(nextpage == undefined) {
			nextpagehref = 'javascript:;" class="grey';
			lastpagehref = 'javascript:;" class="grey';
		} else {
			nextpagehref = nextpage;
			lastpagehref = nextpage.replace(/page=\d+/, 'page=' + lastpage);
		}
		
		var selector = '';
		if(lastpage) {
			selector += '<a id="select_a" style="">';
			selector += '<select id="dumppage" style="position:absolute;left:0;top:0;display:block;opacity:0;width:100%;height:100%;">';
			for(var i=1; i<=lastpage; i++) {
				selector += '<option value="'+i+'" '+ (i == curpage ? 'selected' : '') +'>第'+i+'页</option>';
			}
			selector += '</select>';
			selector += '<span>'+curpage+'/'+lastpage+'</span>';
		}

		$('div.pg').removeClass('pg').addClass('ainuopage cl').html('<a href="'+ firstpagehref +'">首页</a>' + '<a href="'+ prevpagehref +'">上一页</a>'+ selector +'<a href="'+ nextpagehref +'">下一页</a>' + '<a href="'+ lastpagehref +'">末页</a>');
		$('#dumppage').on('change', function() {
			var href = (prevpage || nextpage);
			window.location.href = href.replace(/page=\d+/, 'page=' + $(this).val());
		});
	},
};

var scrolltop = {
	obj : null,
	init : function(obj) {
		scrolltop.obj = obj;
		var fixed = this.isfixed();
		obj.css('opacity', '.618');
		if(fixed) {
			obj.css('bottom', '8px');
		} else {
			obj.css({'visibility':'visible', 'position':'absolute'});
		}
		$(window).on('resize', function() {
			if(fixed) {
				obj.css('bottom', '8px');
			} else {
				obj.css('top', ($(document).scrollTop() + $(window).height() - 40) + 'px');
			}
		});
		obj.on('tap', function() {
			$(document).scrollTop($(document).height());
		});
		$(document).on('scroll', function() {
			if(!fixed) {
				obj.css('top', ($(document).scrollTop() + $(window).height() - 40) + 'px');
			}
			if($(document).scrollTop() >= 400) {
				obj.removeClass('bottom')
				.off().on('tap', function() {
					window.scrollTo('0', '1');
				});
			} else {
				obj.addClass('bottom')
				.off().on('tap', function() {
					$(document).scrollTop($(document).height());
				});
			}
		});

	},
	isfixed : function() {
		var offset = scrolltop.obj.offset();
		var scrollTop = $(window).scrollTop();
		var screenHeight = document.documentElement.clientHeight;
		if(offset == undefined) {
			return false;
		}
		if(offset.top < scrollTop || (offset.top - scrollTop) > screenHeight) {
			return false;
		} else {
			return true;
		}
	}
};

var img = {
	init : function(is_err_t) {
		var errhandle = this.errorhandle;
		$('img').on('load', function() {
			var obj = $(this);
			obj.attr('zsrc', obj.attr('src'));
			if(obj.width() < 5 && obj.height() < 10 && obj.css('display') != 'none') {
				return errhandle(obj, is_err_t);
			}
			obj.css('display', 'inline');
			obj.css('visibility', 'visible');
			if(obj.width() > window.innerWidth) {
				obj.css('width', window.innerWidth);
			}
			obj.parent().find('.loading').remove();
			obj.parent().find('.error_text').remove();
		})
		.on('error', function() {
			var obj = $(this);
			obj.attr('zsrc', obj.attr('src'));
			errhandle(obj, is_err_t);
		});
	},
	errorhandle : function(obj, is_err_t) {
		if(obj.attr('noerror') == 'true') {
			return;
		}
		obj.css('visibility', 'hidden');
		obj.css('display', 'none');
		var parentnode = obj.parent();
		parentnode.find('.loading').remove();
		parentnode.append('<div class="loading" style="background:url('+ IMGDIR +'/imageloading.gif) no-repeat center center;width:'+parentnode.width()+'px;height:'+parentnode.height()+'px"></div>');
		var loadnums = parseInt(obj.attr('load')) || 0;
		if(loadnums < 3) {
			obj.attr('src', obj.attr('zsrc'));
			obj.attr('load', ++loadnums);
			return false;
		}
		if(is_err_t) {
			var parentnode = obj.parent();
			parentnode.find('.loading').remove();
			parentnode.append('<div class="error_text">点击重新加载</div>');
			parentnode.find('.error_text').one('click', function() {
				obj.attr('load', 0).find('.error_text').remove();
				parentnode.append('<div class="loading" style="background:url('+ IMGDIR +'/imageloading.gif) no-repeat center center;width:'+parentnode.width()+'px;height:'+parentnode.height()+'px"></div>');
				obj.attr('src', obj.attr('zsrc'));
			});
		}
		return false;
	}
};

var atap = {
	init : function() {
		$('.atap').on('tap', function() {
			var obj = $(this);
			obj.css({'background':'#6FACD5', 'color':'#FFFFFF', 'font-weight':'bold', 'text-decoration':'none', 'text-shadow':'0 1px 1px #3373A5'});
			return false;
		});
		$('.atap a').off('click');
	}
};


var POPMENU = new Object;
var popup = {
	init : function() {
		var $this = this;
		$('.popup').each(function(index, obj) {
			obj = $(obj);
			var pop = $(obj.attr('href'));
			if(pop && pop.attr('popup')) {
				pop.css({'display':'none'});
				obj.on('click', function(e) {
					$this.open(pop);
				});
			}
		});
		this.maskinit();
	},
	maskinit : function() {
		var $this = this;
		$('#amask').off().on('tap', function() {
			$this.close();
		});
	},

	open : function(pop, type, url) {
		this.close();
		this.maskinit();
		
		if(typeof pop == 'string') {
			$('#ntcmsg').remove();
			if(type == 'alert') {
				pop = '<div class="tip cl"><dt><div class="acon">'+ pop +'</div></dt><dd class="tip_one cl"><a href="javascript:;" onclick="popup.close();" class="apnc">确定</a></dd></div>'
			} else if(type == 'confirm') {
				pop = '<div class="tip cl"><dt><div class="acon">'+ pop +'</div></dt><dd class="tip_two cl"><a href="'+ url +'" onclick="popup.close();" class="apnc">确定</a><a href="javascript:;" onclick="popup.close();" class="apn">取消</dd></div>'
			} else if(type == 'wxtip') {
				pop = '<div class="tip cl"><dt><div class="acon">'+ pop +'</div></dt></div>'
			}
			$('body').append('<div id="ntcmsg" style="display:none;">'+ pop +'</div>');
			pop = $('#ntcmsg');
		}
		if(POPMENU[pop.attr('id')]) {
			$('#' + pop.attr('id') + '_popmenu').html(pop.html()).css({'height':pop.height()+'px', 'width':pop.width()+'px'});
		} else {
			
			pop.parent().append('<div class="dialogbox" id="'+ pop.attr('id') +'_popmenu" style="height:'+ pop.height() +'px;width:'+ pop.width() +'px;">'+ pop.html() +'</div>');
		}
		var popupobj = $('#' + pop.attr('id') + '_popmenu');
		var left = (window.innerWidth - popupobj.width()) / 2;
		var top = (document.documentElement.clientHeight - popupobj.height()) / 2;
		popupobj.css({'display':'block','position':'fixed','left':left,'top':top,'z-index':99999,'opacity':1});
		$('#amask').css({'display':'block','width':'100%','height':'100%','position':'fixed','top':'0','left':'0','background':'#000','opacity':'0.4','z-index':'99998'});
		POPMENU[pop.attr('id')] = pop;
	},
	close : function() {
		$('#amask').css('display', 'none');
		$.each(POPMENU, function(index, obj) {
			$('#' + index + '_popmenu').css('display','none');
		});
	}
};


var dialog = {
	init : function() {
		$(document).on('click', '.dialog', function() {
			var obj = $(this);
			popup.open('<div class="ainuooverlay"><div class="preloader-indicator-overlay"></div><div class="preloader-indicator-modal"><span class="preloader preloader-white"></span></div></div>');
			$.ajax({
				type : 'GET',
				url : obj.attr('href') + '&inajax=1',
				dataType : 'xml'
			})
			.success(function(s) {
				popup.open(s.lastChild.firstChild.nodeValue);
				evalscript(s.lastChild.firstChild.nodeValue);
				
			})
			.error(function() {
				window.location.href = obj.attr('href');
				popup.close();
			});
			return false;

		});
	},

};

var ainuodialog = {
	init : function() {
		$(document).on('click', '.ainuodialog', function() {
			var obj = $(this);
			Zepto('.page').append('<div class="ainuooverlay"><div class="preloader-indicator-overlay"></div><div class="preloader-indicator-modal"><span class="preloader preloader-white"></span></div></div>');
			$.ajax({
				type : 'GET',
				url : obj.attr('ainuoto') + '&inajax=1',
				dataType : 'xml'
			})
			.success(function(s) {
				if(s.lastChild.firstChild.nodeValue.indexOf("您已退出站点") >= 0){
					Zepto('.ainuooverlay').remove();
					Zepto.toast('感谢您的访问，已成功退出',1500,'toast');
					evalscript(s.lastChild.firstChild.nodeValue);
				}else if(s.lastChild.firstChild.nodeValue.indexOf("正在等待验证") >= 0){
					Zepto('.ainuooverlay').remove();
					Zepto.toast('已发出邀请，正在等待对方验证',1500,'toast');
				}else if(s.lastChild.firstChild.nodeValue.indexOf("您不能给自己表态") >= 0){
					Zepto('.ainuooverlay').remove();
					Zepto.toast('您不能给自己表态',1500,'toast');
				}else if(s.lastChild.firstChild.nodeValue.indexOf("您已表过态") >= 0){
					Zepto('.ainuooverlay').remove();
					Zepto.toast('您已经表态过了',1500,'toast');
				}else if(s.lastChild.firstChild.nodeValue.indexOf("群组创始人不能退出群组") >= 0){
					Zepto('.ainuooverlay').remove();
					Zepto.toast('抱歉，您是群组创始人，不能退出',1500,'toast');
				}else if(s.lastChild.firstChild.nodeValue.indexOf("已经成功退出群组") >= 0){
					Zepto('.ainuooverlay').remove();
					Zepto.toast('成功退出群组',1500,'toast');
					evalscript(s.lastChild.firstChild.nodeValue);
				}else if(s.lastChild.firstChild.nodeValue.indexOf("成功加入该群组") >= 0){
					Zepto('.ainuooverlay').remove();
					Zepto.toast('成功加入该群组',1500,'toast');
					evalscript(s.lastChild.firstChild.nodeValue);
				}else if(s.lastChild.firstChild.nodeValue.indexOf("表态成功") >= 0){
					Zepto('.ainuooverlay').remove();
					Zepto.toast('表态成功',1500,'toast');
					setTimeout(function(){
						window.location.reload();
					},500);
				}else{
					Zepto('.ainuooverlay').remove();
					popup.open(s.lastChild.firstChild.nodeValue);
					evalscript(s.lastChild.firstChild.nodeValue);
				}
			})
			.error(function() {
				window.location.href = obj.attr('href');
				Zepto('.ainuooverlay').remove();
			});
			return false;

		});
	},

};



var formdialog = {
	init : function() {
		$(document).on('click', '.formdialog', function() {
			popup.open('<div class="ainuooverlay"><div class="preloader-indicator-overlay"></div><div class="preloader-indicator-modal"><span class="preloader preloader-white"></span></div></div>');
			var obj = $(this);
			var formobj = $(this.form);
			$.ajax({
				type:'POST',
				url:formobj.attr('action') + '&handlekey='+ formobj.attr('id') +'&inajax=1',
				data:formobj.serialize(),
				dataType:'xml'
			})
			.success(function(s) {
				popup.open(s.lastChild.firstChild.nodeValue);
				evalscript(s.lastChild.firstChild.nodeValue);
			})
			.error(function() {
				window.location.href = obj.attr('href');
				popup.close();
			});
			return false;
		});
	}
};

var ainuoformdialog = {
	init : function() {
		$(document).on('click', '.ainuoformdialog', function() {
			popup.open('<div class="ainuooverlay"><div class="preloader-indicator-overlay"></div><div class="preloader-indicator-modal"><span class="preloader preloader-white"></span></div></div>');
			var obj = $(this);
			var formobj = $(this.form);
			$.ajax({
				type:'POST',
				url:formobj.attr('action') + '&handlekey='+ formobj.attr('id') +'&inajax=1',
				data:formobj.serialize(),
				dataType:'xml'
			})
			.success(function(s) {
				if(s.lastChild.firstChild.nodeValue.indexOf("下次访问时会收到通知") >= 0){
					popup.close();
					Zepto.toast('发送成功',1500,'toast');
				}else if(s.lastChild.firstChild.nodeValue.indexOf("群组建立成功") >= 0){
					popup.close();
					Zepto.toast('群组建立成功',1500,'toast');
					evalscript(s.lastChild.firstChild.nodeValue);
				}else if(s.lastChild.firstChild.nodeValue.indexOf("您的建立群组数量已达到设置上限") >= 0){
					popup.close();
					Zepto.toast('抱歉，您建立群组数量已达到上限了',1500,'toast');
				}else{
					popup.open(s.lastChild.firstChild.nodeValue);
					evalscript(s.lastChild.firstChild.nodeValue);
				}
			})
			.error(function() {
				window.location.href = obj.attr('href');
				popup.close();
			});
			return false;
		});
	}
};

var redirect = {
	init : function() {
		$(document).on('click', '.redirect', function() {
			var obj = $(this);
			popup.close();
			window.location.href = obj.attr('href');
		});
	}
};

var DISMENU = new Object;
var display = {
	init : function() {
		var $this = this;
		$('.display').each(function(index, obj) {
			obj = $(obj);
			var dis = $(obj.attr('href'));
			if(dis && dis.attr('display')) {
				dis.css({'display':'none'});
				dis.css({'z-index':'102'});
				DISMENU[dis.attr('id')] = dis;
				obj.on('click', function(e) {
					if(in_array(e.target.tagName, ['A', 'IMG', 'INPUT'])) return;
					$this.maskinit();
					if(dis.attr('display') == 'true') {
						dis.css('display', 'block');
						dis.attr('display', 'false');
						$('#mask').css({'display':'block','width':'100%','height':'100%','position':'fixed','top':'0','left':'0','background':'transparent','z-index':'100'});
					}
					return false;
				});
			}
		});
	},
	maskinit : function() {
		var $this = this;
		$('#mask').off().on('touchstart', function() {
			$this.hide();
		});
	},
	hide : function() {
		$('#mask').css('display', 'none');
		$.each(DISMENU, function(index, obj) {
			obj.css('display', 'none');
			obj.attr('display', 'true');
		});
	}
};

var geo = {
	latitude : null,
	longitude : null,
	loc : null,
	errmsg : null,
	timeout : 5000,
	getcurrentposition : function() {
		if(!!navigator.geolocation) {
			navigator.geolocation.getCurrentPosition(this.locationsuccess, this.locationerror, {
				enableHighAcuracy : true,
				timeout : this.timeout,
				maximumAge : 3000
			});
		}
	},
	locationerror : function(error) {
		geo.errmsg = 'error';
		switch(error.code) {
			case error.TIMEOUT:
				geo.errmsg = "获取位置超时，请重试";
				break;
			case error.POSITION_UNAVAILABLE:
				geo.errmsg = '无法检测到您的当前位置';
			    break;
		    case error.PERMISSION_DENIED:
		        geo.errmsg = '请允许能够正常访问您的当前位置';
		        break;
		    case error.UNKNOWN_ERROR:
		        geo.errmsg = '发生未知错误';
		        break;
		}
	},
/*	locationsuccess : function(position) {
		geo.latitude = position.coords.latitude;
		geo.longitude = position.coords.longitude;
		geo.errmsg = '';
		$.ajax({
			type:'POST',
			url:'http://maps.google.com/maps/api/geocode/json?latlng=' + geo.latitude + ',' + geo.longitude + '&language=zh-CN&sensor=true',
			dataType:'json'
		})
		.success(function(s) {
			if(s.status == 'OK') {
				geo.loc = s.results[0].formatted_address;
			}
		})
		.error(function() {
			geo.loc = null;
		});
	}*/
};

var pullrefresh = {
	init : function() {
		var pos = {};
		var status = false;
		var divobj = null;
		var contentobj = null;
		var reloadflag = false;
		$('body').on('touchstart', function(e) {
			e = mygetnativeevent(e);
			pos.startx = e.touches[0].pageX;
			pos.starty = e.touches[0].pageY;
		})
		.on('touchmove', function(e) {
			e = mygetnativeevent(e);
			pos.curposx = e.touches[0].pageX;
			pos.curposy = e.touches[0].pageY;
			if(pos.curposy - pos.starty < 0 && !status) {
				return;
			}
			if(!status && $(window).scrollTop() <= 0) {
				status = true;
				divobj = document.createElement('div');
				divobj = $(divobj);
				divobj.css({'position':'relative', 'margin-left':'-85px'});
				$('body').prepend(divobj);
				contentobj = document.createElement('div');
				contentobj = $(contentobj);
				contentobj.css({'position':'absolute', 'height':'30px', 'top': '-30px', 'left':'50%'});
				contentobj.html('<img src="'+ STATICURL + 'image/mobile/images/icon_arrow.gif" style="vertical-align:middle;margin-right:5px;-moz-transform:rotate(180deg);-webkit-transform:rotate(180deg);-o-transform:rotate(180deg);transform:rotate(180deg);"><span id="refreshtxt">下拉可以刷新</span>');
				contentobj.find('img').css({'-webkit-transition':'all 0.5s ease-in-out'});
				divobj.prepend(contentobj);
				pos.topx = pos.curposx;
				pos.topy = pos.curposy;
			}
			if(!status) {
				return;
			}
			if(status == true) {
				var pullheight = pos.curposy - pos.topy;
				if(pullheight >= 0 && pullheight < 150) {
					divobj.css({'height': pullheight/2 + 'px'});
					contentobj.css({'top': (-30 + pullheight/2) + 'px'});
					if(reloadflag) {
						contentobj.find('img').css({'-webkit-transform':'rotate(180deg)', '-moz-transform':'rotate(180deg)', '-o-transform':'rotate(180deg)', 'transform':'rotate(180deg)'});
						contentobj.find('#refreshtxt').html('下拉可以刷新');
					}
					reloadflag = false;
				} else if(pullheight >= 150) {
					divobj.css({'height':pullheight/2 + 'px'});
					contentobj.css({'top': (-30 + pullheight/2) + 'px'});
					if(!reloadflag) {
						contentobj.find('img').css({'-webkit-transform':'rotate(360deg)', '-moz-transform':'rotate(360deg)', '-o-transform':'rotate(360deg)', 'transform':'rotate(360deg)'});
						contentobj.find('#refreshtxt').html('松开可以刷新');
					}
					reloadflag = true;
				}
			}
			e.preventDefault();
		})
		.on('touchend', function(e) {
			if(status == true) {
				if(reloadflag) {
					contentobj.html('<img src="'+ STATICURL + 'image/mobile/images/icon_load.gif" style="vertical-align:middle;margin-right:5px;">正在加载...');
					contentobj.animate({'top': (-30 + 75) + 'px'}, 618, 'linear');
					divobj.animate({'height': '75px'}, 618, 'linear', function() {
						window.location.reload();
					});
					return;
				}
			}
			divobj.remove();
			divobj = null;
			status = false;
			pos = {};
		});
	}
};


function mygetnativeevent(event) {

	while(event && typeof event.originalEvent !== "undefined") {
		event = event.originalEvent;
	}
	return event;
}

function evalscript(s) {
	if(s.indexOf('<script') == -1) return s;
	var p = /<script[^\>]*?>([^\x00]*?)<\/script>/ig;
	var arr = [];
	while(arr = p.exec(s)) {
		var p1 = /<script[^\>]*?src=\"([^\>]*?)\"[^\>]*?(reload=\"1\")?(?:charset=\"([\w\-]+?)\")?><\/script>/i;
		var arr1 = [];
		arr1 = p1.exec(arr[0]);
		if(arr1) {
			appendscript(arr1[1], '', arr1[2], arr1[3]);
		} else {
			p1 = /<script(.*?)>([^\x00]+?)<\/script>/i;
			arr1 = p1.exec(arr[0]);
			appendscript('', arr1[2], arr1[1].indexOf('reload=') != -1);
		}
	}
	return s;
}

var safescripts = {}, evalscripts = [];

function appendscript(src, text, reload, charset) {
	var id = hash(src + text);
	if(!reload && in_array(id, evalscripts)) return;
	if(reload && $('#' + id)[0]) {
		$('#' + id)[0].parentNode.removeChild($('#' + id)[0]);
	}

	evalscripts.push(id);
	var scriptNode = document.createElement("script");
	scriptNode.type = "text/javascript";
	scriptNode.id = id;
	scriptNode.charset = charset ? charset : (!document.charset ? document.characterSet : document.charset);
	try {
		if(src) {
			scriptNode.src = src;
			scriptNode.onloadDone = false;
			scriptNode.onload = function () {
				scriptNode.onloadDone = true;
				JSLOADED[src] = 1;
			};
			scriptNode.onreadystatechange = function () {
				if((scriptNode.readyState == 'loaded' || scriptNode.readyState == 'complete') && !scriptNode.onloadDone) {
					scriptNode.onloadDone = true;
					JSLOADED[src] = 1;
				}
			};
		} else if(text){
			scriptNode.text = text;
		}
		document.getElementsByTagName('head')[0].appendChild(scriptNode);
	} catch(e) {}
}

function hash(string, length) {
	var length = length ? length : 32;
	var start = 0;
	var i = 0;
	var result = '';
	filllen = length - string.length % length;
	for(i = 0; i < filllen; i++){
		string += "0";
	}
	while(start < string.length) {
		result = stringxor(result, string.substr(start, length));
		start += length;
	}
	return result;
}

function stringxor(s1, s2) {
	var s = '';
	var hash = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	var max = Math.max(s1.length, s2.length);
	for(var i=0; i<max; i++) {
		var k = s1.charCodeAt(i) ^ s2.charCodeAt(i);
		s += hash.charAt(k % 52);
	}
	return s;
}

function in_array(needle, haystack) {
	if(typeof needle == 'string' || typeof needle == 'number') {
		for(var i in haystack) {
			if(haystack[i] == needle) {
					return true;
			}
		}
	}
	return false;
}

function isUndefined(variable) {
	return typeof variable == 'undefined' ? true : false;
}

function setcookie(cookieName, cookieValue, seconds, path, domain, secure) {
	if(cookieValue == '' || seconds < 0) {
		cookieValue = '';
		seconds = -2592000;
	}
	if(seconds) {
		var expires = new Date();
		expires.setTime(expires.getTime() + seconds * 1000);
	}
	domain = !domain ? cookiedomain : domain;
	path = !path ? cookiepath : path;
	document.cookie = escape(cookiepre + cookieName) + '=' + escape(cookieValue)
		+ (expires ? '; expires=' + expires.toGMTString() : '')
		+ (path ? '; path=' + path : '/')
		+ (domain ? '; domain=' + domain : '')
		+ (secure ? '; secure' : '');
}

function getcookie(name, nounescape) {
	name = cookiepre + name;
	var cookie_start = document.cookie.indexOf(name);
	var cookie_end = document.cookie.indexOf(";", cookie_start);
	if(cookie_start == -1) {
		return '';
	} else {
		var v = document.cookie.substring(cookie_start + name.length + 1, (cookie_end > cookie_start ? cookie_end : document.cookie.length));
		return !nounescape ? unescape(v) : v;
	}
}


function ao_getday(id, Year, Month, day, istime){
    var d = new Date(Year, Month, 0);
	var html = '';
	for(var k = 1; k <= d.getDate(); k++) {
		html += '<option value="' + ( k < 10 ? '0' : '') + k + '"' + (k == day ? 'selected="selected"' : '') + '>' + ( k < 10 ? '0' : '') + k + '日</option>'; 
	}
	$('.dialogbox #' + id + '_date .adays').html(html);  
	$('.dialogbox #' + id + '_date .years_name').text($('.dialogbox #' + id + '_date .years').find('option:selected').text());
	$('.dialogbox #' + id + '_date .months_name').text($('.dialogbox #' + id + '_date .months').find('option:selected').text());
	$('.dialogbox #' + id + '_date .days_name').text($('.dialogbox #' + id + '_date .adays').find('option:selected').text());
	if(istime){
		$('.dialogbox #' + id + '_date .hs_name').text($('.dialogbox #' + id + '_date .hs').find('option:selected').text());
		$('.dialogbox #' + id + '_date .ms_name').text($('.dialogbox #' + id + '_date .ms').find('option:selected').text());
	}
}
function ao_parsedate(s) {
	/(\d+)\-(\d+)\-(\d+)\s*(\d*):?(\d*)/.exec(s);
	var m1 = (RegExp.$1 && RegExp.$1 > 1899 && RegExp.$1 < 2101) ? parseFloat(RegExp.$1) : today.getFullYear();
	var m2 = (RegExp.$2 && (RegExp.$2 > 0 && RegExp.$2 < 13)) ? parseFloat(RegExp.$2) : today.getMonth() + 1;
	var m3 = (RegExp.$3 && (RegExp.$3 > 0 && RegExp.$3 < 32)) ? parseFloat(RegExp.$3) : today.getDate();
	var m4 = (RegExp.$4 && (RegExp.$4 > -1 && RegExp.$4 < 24)) ? parseFloat(RegExp.$4) : 0;
	var m5 = (RegExp.$5 && (RegExp.$5 > -1 && RegExp.$5 < 60)) ? parseFloat(RegExp.$5) : 0;
	/(\d+)\-(\d+)\-(\d+)\s*(\d*):?(\d*)/.exec("0000-00-00 00\:00");
	return new Date(m1, m2 - 1, m3, m4, m5);
}

function ao_setdate(id, istime){
	var this_id = $('#' + id);
	var date = $('.dialogbox #' + id + '_date .years').find('option:selected').val() + '-' + $('.dialogbox #' + id + '_date .months').find('option:selected').val() + '-' + $('.dialogbox #' + id + '_date .adays').find('option:selected').val() + ' ' + (istime == 'true' ? $('.dialogbox #' + id + '_date .hs').find('option:selected').val() + ':' + $('.dialogbox #' + id + '_date .ms').find('option:selected').val() : '');
	this_id.val(date);
	var title = this_id.parent().find('span').first().text().replace(/\*|\:/ig, '');
	popup.open('设置成功', 'alert');
}

$(document).ready(function() {
	$(document).on('click', '.ainuo_calendar:text', function() {
		var obj = $(this);
		var istime = $(this).hasClass("ainuo_calendar");
		obj.blur();
		var ao_date = obj.val() ? ao_parsedate(obj.val()) : new Date();
		var ao_y = ao_date.getFullYear();
		var ao_m = ao_date.getMonth() + 1;
		var ao_d = ao_date.getDate();
		var ao_h = ao_date.getHours();
		var ao_i = ao_date.getMinutes();
		var id = obj.attr('id');
		var title = obj.parent().find('span').first().text().replace(/\*|\:/ig, '');
		var datehtml = '<div class="atime_tip cl" id="' + id + '_date">' + 
		'<div class="atime_tit">' + (title ? title : '日期'+(istime ? '时间' : '')+'设置') + '</div>' + 
		'<div class="atime_acon cl">' + 
		'<div class="afirst cl">' + 
		'<div class="mysllet">' + 
		'<select nemu="years" class="years">';
		for(var k = 2020; k >= 1949; k--) {
			datehtml += '<option value="' + k + '"' + (k == ao_y ? 'selected="selected"' : '') + '>' + k + '年</option>';
		}
		datehtml += '</select>' + 
		'</div>' + 
		'<div class="mysllet">' + 
		'<select nemu="months" class="months">';
		for(var k = 1; k <= 12; k++) {
			datehtml += '<option value="' + ( k < 10 ? '0' : '') + k + '"' + (k == ao_m ? 'selected="selected"' : '') + '>' + ( k < 10 ? '0' : '') + k + '月</option>';
		}
		datehtml += '</select>' + 
		'</div>' + 
		'<div class="mysllet">' + 
		'<select nemu="adays" class="adays"></select>' + 
		'</div>' + 
		'</div>';
		if(istime){
			datehtml += '<div class="asecond cl">' + 
			'<div class="mysllet">' + 
			'<select nemu="hs" class="hs">';
			for(var k = 0; k <= 23; k++) {
				datehtml += '<option value="' + ( k < 10 ? '0' : '') + k + '"' + (k == ao_h ? 'selected="selected"' : '') + '>' + ( k < 10 ? '0' : '') + k + '时</option>';
			}
			datehtml += '</select>' + 
			'</div>' + 
			'<div class="mysllet">' + 
			'<select nemu="ms" class="ms">';
			for(var k = 0; k <= 59; k++) {
				datehtml += '<option value="' + ( k < 10 ? '0' : '') + k + '"' + (k == ao_i ? 'selected="selected"' : '') + '>' + ( k < 10 ? '0' : '') + k + '分</option>';
			}
			datehtml += '</select>' + 
			'</div>' + 
			'</div>'; 
		}
		datehtml += '</div>' + 
		'<dd class="twobtn cl">' + 
		'<a href="javascript:;" onclick="ao_setdate(\'' + id + '\', \'' + istime + '\');" class="apnc">确定</a>' + 
		'<a href="javascript:;" onclick="popup.close()" class="apn">取消</a>' + 
		'</dd>' + 
		'</div>';
		popup.open(datehtml);
		setTimeout(function(){
			ao_getday(id, ao_y, ao_m, ao_d, istime);
			$('.dialogbox #' + id + '_date .atime_acon select').on('change', function(){
				var obj = $(this);
				$('.' + obj.attr('nemu') + '_name').text(obj.find('option:selected').text());
				if(obj.attr('nemu') == 'years' || obj.attr('nemu') == 'months'){
					ao_getday(id, $('.dialogbox #' + id + '_date .years').find('option:selected').val(), $('.dialogbox #' + id + '_date .months').find('option:selected').val(), 0, istime);
				}
			});
		}, 16);
	});
});
function openDiy(){
	if(DYNAMICURL) {
		window.location.href = SITEURL+DYNAMICURL + (DYNAMICURL.indexOf('?') < 0 ? '?' : '&') + ('diy=yes');
	} else {
		window.location.href = ((window.location.href + '').replace(/[\?\&]diy=yes/g, '').split('#')[0] + ( window.location.search && window.location.search.indexOf('?diy=yes') < 0 ? '&diy=yes' : '?diy=yes'));
	}
}

$.extend({
	buildfileupload: function(s) {
		try {
			var reader = new FileReader();
			var canvaszoom = false;
			if(1 || (s.maxfilesize && s.files[0].size > s.maxfilesize * 1024)) {
				canvaszoom = true;
			}
			var picupload = function(picdata) {
				if(!XMLHttpRequest.prototype.sendAsBinary){
					XMLHttpRequest.prototype.sendAsBinary = function(datastr) {
						function byteValue(x) {
							return x.charCodeAt(0) & 0xff;
						}
						var ords = Array.prototype.map.call(datastr, byteValue);
						var ui8a = new Uint8Array(ords);
						this.send(ui8a.buffer);
					}
				}
				var xhr = new XMLHttpRequest(),
					file = s.files[0],
					index = 0,
					start_time = new Date().getTime(),
					boundary = '------multipartformboundary' + (new Date).getTime(),
					builder;
				builder = $.getbuilder(s, file.name, picdata, boundary);
				if(s.uploadpercent) {
					xhr.upload.onprogress = function(e) {
						if(e.lengthComputable) {
							var percent = Math.ceil((e.loaded / e.total) * 100);
							$('#' + s.uploadpercent).html(percent + '%');
						}
					};
				}
				xhr.open("POST", s.uploadurl, true);
				xhr.setRequestHeader('content-type', 'multipart/form-data; boundary='
					+ boundary);
				xhr.sendAsBinary(builder);
				xhr.onerror = function() {
					s.error();
				};
				xhr.onabort = function() {
					s.error();
				};
				xhr.ontimeout = function() {
					s.error();
				};
				xhr.onload = function() {
					if(xhr.responseText) {
						s.success(xhr.responseText);
					}
				};
			};
			var getorientation = function(binfile) {
				function getbyteat(offset) {
					return binfile.charCodeAt(offset) & 0xFF;
				}
				function getbytesat(offset, length) {
					var bytes = [];
					for(var i=0; i<length; i++) {
						bytes[i] = binfile.charCodeAt((offset + i)) & 0xFF;
					}
					return bytes;
				}
				function getshortat(offset, bigendian) {
					var shortat = bigendian ?
						(getbyteat(offset) << 8) + getbyteat(offset + 1)
						: (getbyteat(offset + 1) << 8) + getbyteat(offset);
					if(shortat < 0) {
						shortat += 65536;
					}
					return shortat;
				}
				function getlongat(offset, bigendian) {
					var byte1 = getbyteat(offset);
					var byte2 = getbyteat(offset + 1);
					var byte3 = getbyteat(offset + 2);
					var byte4 = getbyteat(offset + 3);
					var longat = bigendian ?
						(((((byte1 << 8) + byte2) << 8) + byte3) << 8) + byte4
						: (((((byte4 << 8) + byte3) << 8) + byte2) << 8) + byte1;
					if(longat < 0) longat += 4294967296;
					return longat;
				}
				function getslongat(offset, bigendian) {
					var ulongat = getlongat(offset, bigendian);
					if(ulongat > 2147483647) {
						return ulongat - 4294967296;
					} else {
						return ulongat;
					}
				}
				function getstringat(offset, length) {
					var str = [];
					var bytes = getbytesat(offset, length);
					for(var i=0; i<length; i++) {
						str[i] = String.fromCharCode(bytes[i]);
					}
					return str.join('');
				}
				function readtagvalue(entryoffset, tiffstart, dirstart, bigend) {
					var type = getshortat(entryoffset + 2, bigend);
					var numvalues = getlongat(entryoffset + 4, bigend);
					var valueoffset = getlongat(entryoffset + 8, bigend) + tiffstart;
					var offset, vals;
					switch(type) {
						case 1:
						case 7:
							if(numvalues == 1) {
								return getbyteat(entryoffset + 8, bigend);
							} else {
								offset = numvalues > 4 ? valueoffset : (entryoffset + 8);
								vals = [];
								for(var n=0; n<numvalues; n++) {
									vals[n] = getbyteat(offset + n);
								}
								return vals;
							}
						case 2:
							offset = numvalues > 4 ? valueoffset : (entryoffset + 8);
							return getstringat(offset, numvalues - 1);
						case 3:
							if(numvalues == 1) {
								return getshortat(entryoffset + 8, bigend);
							} else {
								offset = numvalues > 2 ? valueoffset : (entryoffset + 8);
								vals = [];
								for(var n=0;n<numvalues; n++) {

									vals[n] = getshortat(offset + 2 * n, bigend);
								}
								return vals;
							}
						case 4:
							if(numvalues == 1) {
								return getlongat(entryoffset + 8, bigend);
							} else {
								vals = [];
								for(var n=0; n<numvalues; i++) {
									vals[n] = getlongat(valueoffset + 4 * n, bigend);
								}
								return vals;
							}
						case 5:
							if(numvalues == 1) {
								var numerator = getlongat(valueoffset, bigend);
								var denominator = getlongat(valueoffset + 4, bigend);
								var val = new Number(numerator / denominator);
								val.numerator = numerator;
								val.denominator = denominator;
								return val;
							} else {
								vals = [];
								for(var n=0; n<numvalues; n++) {
									var numerator = getlongat(valueoffset + 8*n, bigend);
									var denominator = getlongat(valueoffset+4 + 8*n, bigend);
									vals[n] = new Number(numerator / denominator);
									vals[n].numerator = numerator;
									vals[n].denominator = denominator;
								}
								return vals;
							}
						case 9:
							if(numvalues == 1) {
								return getslongat(entryoffset + 8, bigend);
							} else {
								vals = [];
								for(var n=0;n<numvalues; n++) {
									vals[n] = getslongat(valueoffset + 4 * n, bigend);
								}
								return vals;
							}
						case 10:
							if(numvalues == 1) {
								return getslongat(valueoffset, bigend) / getslongat(valueoffset+4, bigend);
							} else {
								vals = [];
								for(var n=0; n<numvalues; n++) {
									vals[n] = getslongat(valuesoffset + 8*n, bigend) / getslongat(valueoffset+4 + 8*n, bigend);
								}
								return vals;
							}
					}
				}
				function readtags(tiffstart, dirstart, strings, bigend) {
					var entries = getshortat(dirstart, bigend);
					var tags = {}, entryofffset, tag;
					for(var i=0; i<entries; i++) {
						entryoffset = dirstart + i *12 + 2;
						tag = strings[getshortat(entryoffset, bigend)];
						tags[tag] = readtagvalue(entryoffset, tiffstart, dirstart, bigend);
					}
					return tags;
				}
				function readexifdata(start) {
					if(getstringat(start, 4) != 'Exif') {
						return false;
					}
					var bigend;
					var tags, tag;
					var tiffoffset = start + 6;
					if(getshortat(tiffoffset) == 0x4949) {
						bigend = false;
					} else if(getshortat(tiffoffset) == 0x4D4D) {
						bigend = true;
					} else {
						return false;
					}
					if(getshortat(tiffoffset + 2, bigend) != 0x002A) {
						return false;
					}
					if(getlongat(tiffoffset + 4, bigend) != 0x00000008) {
						return false;
					}
					var tifftags = {
						0x0112 : "Orientation"
					};
					tags = readtags(tiffoffset, tiffoffset + 8, tifftags, bigend);
					return tags;
				}
				if(getbyteat(0) != 0xFF || getbyteat(1) != 0xD8) {
					return false;
				}
				var offset = 2;
				var length = binfile.length;
				var marker;
				while(offset < length) {
					if(getbyteat(offset) != 0xFF) {
						return false;
					}
					marker = getbyteat(offset + 1);
					if(marker == 22400 || marker == 225) {
						return readexifdata(offset + 4);
					} else {
						offset += 2 + getshortat(offset + 2, true);
					}
				}
			};
			var detectsubsampling = function(img, imgwidth, imgheight) {
				if(imgheight * imgwidth > 1024 * 1024) {
					var tmpcanvas = document.createElement('canvas');
					tmpcanvas.width = tmpcanvas.height = 1;
					var tmpctx = tmpcanvas.getContext('2d');
					tmpctx.drawImage(img, -imgwidth + 1, 0);
					return tmpctx.getImageData(0, 0, 1, 1).data[3] === 0;
				} else {
					return false;
				}
			};
			var detectverticalsquash = function(img, imgheight) {
				var tmpcanvas = document.createElement('canvas');
				tmpcanvas.width = 1;
				tmpcanvas.height = imgheight;
				var tmpctx = tmpcanvas.getContext('2d');
				tmpctx.drawImage(img, 0, 0);
				var data = tmpctx.getImageData(0, 0, 1, imgheight).data;
				var sy = 0;
				var ey = imgheight;
				var py = imgheight;
				while(py > sy) {
					var alpha = data[(py - 1) * 4 + 3];
					if(alpha === 0) {
						ey = py;
					} else {
						sy = py;
					}
					py = (ey + sy) >> 1;
				}
				var ratio = py / imgheight;
				return (ratio === 0) ? 1 : ratio;
			};
			var transformcoordinate = function(canvas, ctx, width, height, orientation) {
				switch(orientation) {
					case 5:
					case 6:
					case 7:
					case 8:
						canvas.width = height;
						canvas.height = width;
						break;
					default:
						canvas.width = width;
						canvas.height = height;
				}
				switch(orientation) {
					case 2:
						ctx.translate(width, 0);
						ctx.scale(-1, 1);
						break;
					case 3:
						ctx.translate(width, height);
						ctx.rotate(Math.PI);
						break;
					case 4:
						ctx.translate(0, height);
						ctx.scale(1, -1);
						break;
					case 5:
						ctx.rotate(0.5 * Math.PI);
						ctx.scale(1, -1);
						break;
					case 6:
						ctx.rotate(0.5 * Math.PI);
						ctx.translate(0, -height);
						break;
					case 7:
						ctx.rotate(0.5 * Math.PI);
						ctx.translate(width, -height);
						ctx.scale(-1, 1);
						break;
					case 8:
						ctx.rotate(-0.5 * Math.PI);
						ctx.translate(-width, 0);
						break;
				}
			};
			var maxheight = 9000;
			var maxwidth = 9000;
			var canvas = document.createElement('canvas');
			var ctx = canvas.getContext('2d');
			var img = new Image();
			img.onload = function() {
				$this = $(this);
				var imgwidth = this.width ? this.width : $this.width();
				var imgheight = this.height ? this.height : $this.height();
				var canvaswidth = maxwidth;
				var canvasheight = maxheight;
				var newwidth = imgwidth;
				var newheight = imgheight;
				if(imgwidth/imgheight <= canvaswidth/canvasheight && imgheight >= canvasheight) {
					newheight = canvasheight;
					newwidth = Math.ceil(canvasheight/imgheight*imgwidth);
				} else if(imgwidth/imgheight > canvaswidth/canvasheight && imgwidth >= canvaswidth) {
					newwidth = canvaswidth;
					newheight = Math.ceil(canvaswidth/imgwidth*imgheight);
				}
				ctx.save();
				var imgfilebinary = this.src.replace(/data:.+;base64,/, '');
				if(typeof atob == 'function') {
					imgfilebinary = atob(imgfilebinary);
				} else {
					imgfilebinary = $.base64decode(imgfilebinary);
				}
				var orientation = getorientation(imgfilebinary);
				orientation = orientation.Orientation;
				if(detectsubsampling(this, imgwidth, imgheight)) {
					imgheight = imgheight / 2;
					imgwidth = imgwidth / 2;
				}
				var vertsquashratio = detectverticalsquash(this, imgheight);
				transformcoordinate(canvas, ctx, newwidth, newheight, orientation);
				ctx.drawImage(this, 0, 0, imgwidth, imgheight, 0, 0, newwidth, newheight/vertsquashratio);
				ctx.restore();
				var newdataurl = canvas.toDataURL(s.files[0].type).replace(/data:.+;base64,/, '');
				if(typeof atob == 'function') {
					picupload(atob(newdataurl));
				} else {
					picupload($.base64decode(newdataurl));
				}
			};
			reader.index = 0;
			reader.onloadend = function(e) {
				if(canvaszoom) {
					img.src = e.target.result;
				} else {
					picupload(e.target.result);
				}
				return;
			};
			if(canvaszoom) {
				reader.readAsDataURL(s.files[0]);
			} else {
				reader.readAsBinaryString(s.files[0]);
			}
		} catch(err) {
			return s.error();
		}
		return;
    },
	getbuilder: function(s, filename, filedata, boundary) {
		var dashdash = '--',
			crlf = '\r\n',
			builder = '';
		for(var i in s.uploadformdata) {
			builder += dashdash;
			builder += boundary;
			builder += crlf;
			builder += 'Content-Disposition: form-data; name="' + i + '"';
			builder += crlf;
			builder += crlf;
			builder += s.uploadformdata[i];
			builder += crlf;
		}
		builder += dashdash;
		builder += boundary;
		builder += crlf;
		builder += 'Content-Disposition: form-data; name="' + s.uploadinputname + '"';
		builder += '; filename="' + filename + '"';
		builder += crlf;
		builder += 'Content-Type: application/octet-stream';
		builder += crlf;
		builder += crlf;
		builder += filedata;
		builder += crlf;
		builder += dashdash;
		builder += boundary;
		builder += dashdash;
		builder += crlf;
		return builder;
	}
});
$.extend({
	base64encode: function(input) {
		var output = '';
		var chr1, chr2, chr3 = '';
		var enc1, enc2, enc3, enc4 = '';
		var i = 0;
		do {
			chr1 = input.charCodeAt(i++);
			chr2 = input.charCodeAt(i++);
			chr3 = input.charCodeAt(i++);
			enc1 = chr1 >> 2;
			enc2 = ((chr1 & 3) << 4) | (chr2 >> 4);
			enc3 = ((chr2 & 15) << 2) | (chr3 >> 6);
			enc4 = chr3 & 63;
			if (isNaN(chr2)){
				enc3 = enc4 = 64;
			} else if (isNaN(chr3)){
				enc4 = 64;
			}
			output = output+this._keys.charAt(enc1)+this._keys.charAt(enc2)+this._keys.charAt(enc3)+this._keys.charAt(enc4);
			chr1 = chr2 = chr3 = '';
			enc1 = enc2 = enc3 = enc4 = '';
		} while (i < input.length);
		return output;
	},
	base64decode: function(input) {
		var output = '';
		var chr1, chr2, chr3 = '';
		var enc1, enc2, enc3, enc4 = '';
		var i = 0;
		if (input.length%4!=0){
			return '';
		}
		var base64test = /[^A-Za-z0-9\+\/\=]/g;
		if (base64test.exec(input)){
			return '';
		}
		do {
			enc1 = this._keys.indexOf(input.charAt(i++));
			enc2 = this._keys.indexOf(input.charAt(i++));
			enc3 = this._keys.indexOf(input.charAt(i++));
			enc4 = this._keys.indexOf(input.charAt(i++));
			chr1 = (enc1 << 2) | (enc2 >> 4);
			chr2 = ((enc2 & 15) << 4) | (enc3 >> 2);
			chr3 = ((enc3 & 3) << 6) | enc4;
			output = output + String.fromCharCode(chr1);
			if (enc3 != 64){
				output+=String.fromCharCode(chr2);
			}
			if (enc4 != 64){
				output+=String.fromCharCode(chr3);
			}
			chr1 = chr2 = chr3 = '';
			enc1 = enc2 = enc3 = enc4 = '';
		} while (i < input.length);
		return output;
	},
	_keys: 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=',
});

$(document).ready(function() {

	if($('div.pg').length > 0) {
		ainuopage.converthtml();
	}
	if($('.scrolltop').length > 0) {
		scrolltop.init($('.scrolltop'));
	}
	if($('img').length > 0) {
		img.init(1);
	}
	if($('.popup').length > 0) {
		popup.init();
	}
	if($('.display').length > 0) {
		display.init();
	}
	if($('.atap').length > 0) {
		atap.init();
	}
	if($('.pullrefresh').length > 0) {
		pullrefresh.init();
	}
	dialog.init();
	ainuodialog.init();
	formdialog.init();
	ainuoformdialog.init();
	redirect.init();
});