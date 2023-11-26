$(function($, window, undefined) {
	var _singleton,
	_count = 0,
	_expando = 'artDialog' + + new Date,
	_isIE6 = window.VBArray && !window.XMLHttpRequest,
	_isMobile = 'createTouch' in document && !('onmousemove' in document) || /(iPad|iPhone|iPod|Android)/i.test(navigator.userAgent),
	_isFixed = !_isIE6 && !_isMobile;
	var artDialog = function(config, ok, cancel) {
		config = config || {};
		if (typeof config === 'string' || config.nodeType === 1) {
			config = {
				content: config
			};
		};
		var api,
		defaults = artDialog.defaults;
		var elem = config.follow = this.nodeType === 1 && this || config.follow;
		for (var i in defaults) {
			if (config[i] === undefined) {
				config[i] = defaults[i];
			};
		};
		config.id = elem && elem[_expando + 'follow'] || config.id || _expando + _count;
		api = artDialog.list[config.id];
		if (api) {
			if (elem) {
				api.follow(elem)
			};
			api.zIndex();
			return api;
		};
		if (!config.button || !config.button.push) {
			config.button = [];
		};
		if (config.ok) {
			config.button.push({
				id: 'ok',
				value: config.okValue,
				callback: config.ok,
				focus: true
			});
		};
		if (config.cancel) {
			config.button.push({
				id: 'cancel',
				value: config.cancelValue,
				callback: config.cancel,
				focus: false
			});
		};
		artDialog.defaults.zIndex = config.zIndex;
		_count++;
		return artDialog.list[config.id] = _singleton ? _singleton.constructor(config) : new artDialog.fn.constructor(config);
	};
	artDialog.fn = artDialog.prototype = {
		constructor: function(config) {
			var dom;
			this.closed = false;
			this.config = config;
			this.dom = dom = this.dom || this._getDom();
			dom.close[config.cancel === false ? 'hide': 'show']();
			dom.content.css('padding', config.padding);
			this.button.apply(this, config.button);
			this.title(config.title).content(config.content).time(config.time);
			if (config.follow) {
				this.follow(config.follow);
			}
			 else {
				this.positionTop();
				this.position();
			}
			dom.wrap.css({
				opacity: 100
			});
			this.zIndex();
			config.lock && this.lock();
			this._addEvent();
			this[config.visible ? 'visible': 'hidden']();
			_singleton = null;
			config.initialize && config.initialize.call(this);
			return this;
		},
		content: function(message) {
			this.dom.wrap.css({
				width: 'auto',
				height: 'auto'
			});
			var prev,
			next,
			parent,
			display,
			that = this,
			$content = this.dom.content,
			content = $content[0];
			if (this._elemBack) {
				this._elemBack();
				delete this._elemBack;
			};
			if (typeof message === 'string') {
				$content.html(message);
			}
			 else if (message && message.nodeType === 1) {
				display = message.style.display;
				prev = message.previousSibling;
				next = message.nextSibling;
				parent = message.parentNode;
				this._elemBack = function() {
					if (prev && prev.parentNode) {
						prev.parentNode.insertBefore(message, prev.nextSibling);
					} else if (next && next.parentNode) {
						next.parentNode.insertBefore(message, next);
					} else if (parent) {
						parent.appendChild(message);
					};
					message.style.display = display;
					that._elemBack = null;
				};
				$content.html('');
				content.appendChild(message);
				$(message).show();
			};
			var elem = this.config.follow;
			elem ? this.follow(elem) : this.position();
			return this;
		},
		title: function(content) {
			var dom = this.dom,
			outer = dom.outer,
			$title = dom.title,
			className = 'd-state-noTitle';
			if (content === false) {
				$title.hide().html('');
				outer.addClass(className);
			} else {
				$title.show().html(content);
				outer.removeClass(className);
			};
			return this;
		},
		positionTop: function() {
			var dom = this.dom,
			_newTop,
			_height = dom.wrap.height(),
			dt = dom.document.scrollTop();
			if (dt + _height > dom.document.height()) {
				_newTop = dom.document.height() - _height;
			}
			 else {
				_newTop = dt + dom.window.height() / 2 - _height / 2;
			}
			_newTop = _newTop < 0 ? 0: _newTop;
			dom.wrap.css({
				top: _newTop
			});
			return this;
		},
		position: function() {
			var dom = this.dom,
			_newLeft,
			_width = dom.wrap.width(),
			dl = dom.document.scrollLeft();
			if (dom.window.width() >= dom.document.width()) {
				_newLeft = dom.document.width() / 2 - _width / 2;
			}
			 else {
				if (dom.window.width() <= _width) {
					if (dl + dom.window.width() + (_width - dom.window.width()) / 2 > dom.document.width()) {
						_newLeft = dom.document.width() - _width;
					}
					 else {
						_newLeft = dl + dom.window.width() / 2 - _width / 2;
					}
				}
				 else {
					_newLeft = dl + dom.window.width() / 2 - _width / 2;
				}
			}
			_newLeft = _newLeft < 0 ? 0: _newLeft;
			var _lockMaskWidth = _newLeft * 2 + _width;
			if (_lockMaskWidth > dom.document.width()) {
				_lockMaskWidth = dom.document.width();
			}
			dom.wrap.css({
				left: _newLeft
			});
			if (!_isFixed && this._isLock) {
				this._lockMask.css({
					width: _lockMaskWidth + 'px'
				});
			}
			return this;
		},
		follow: function(elem) {
			var $elem = $(elem),
			config = this.config;
			if (!elem || !elem.offsetWidth && !elem.offsetHeight) {
				this.positionTop();
				this.position();
				return this;
			};
			var expando = _expando + 'follow',
			dom = this.dom,
			$window = dom.window,
			$document = dom.document,
			winWidth = $window.width(),
			winHeight = $window.height(),
			docLeft = $document.scrollLeft(),
			docTop = $document.scrollTop(),
			offset = $elem.offset(),
			width = elem.offsetWidth,
			height = elem.offsetHeight,
			left = offset.left,
			top = offset.top,
			wrap = this.dom.wrap[0],
			style = wrap.style,
			wrapWidth = wrap.offsetWidth,
			wrapHeight = wrap.offsetHeight,
			setLeft = left - (wrapWidth - width) / 2,
			setTop = top + height,
			dl = docLeft,
			dt = docTop;
			setLeft = setLeft < dl ? left: (setLeft + wrapWidth > winWidth) && (left - wrapWidth > dl) ? left - wrapWidth + width: setLeft;
			setTop = (setTop + wrapHeight > winHeight + dt) && (top - wrapHeight > dt) ? top - wrapHeight: setTop;
			style.left = setLeft + 'px';
			style.top = setTop + 'px';
			this._follow && this._follow.removeAttribute(expando);
			this._follow = elem;
			elem[expando] = config.id;
			return this;
		},
		button: function() {
			var dom = this.dom,
			$buttons = dom.buttons,
			elem = $buttons[0],
			strongButton = 'd-state-highlight',
			listeners = this._listeners = this._listeners || {},
			ags = [].slice.call(arguments);
			var i = 0,
			val,
			value,
			id,
			isNewButton,
			button;
			for (; i < ags.length; i++) {
				val = ags[i];
				value = val.value;
				id = val.id || value;
				isNewButton = !listeners[id];
				button = !isNewButton ? listeners[id].elem: document.createElement('input');
				button.type = 'button';
				button.className = 'd-button';
				if (!listeners[id]) {
					listeners[id] = {};
				};
				if (value) {
					button.value = value;
				};
				if (val.width) {
					button.style.width = val.width;
				};
				if (val.callback) {
					listeners[id].callback = val.callback;
				};
				if (val.focus) {
					this._focus && this._focus.removeClass(strongButton);
					this._focus = $(button).addClass(strongButton);
				};
				button[_expando + 'callback'] = id;
				button.disabled = !!val.disabled;
				if (isNewButton) {
					listeners[id].elem = button;
					elem.appendChild(button);
				};
			};
			$buttons[0].style.display = ags.length ? '': 'none';
			return this;
		},
		visible: function() {
			this.dom.wrap.css('visibility', 'visible');
			this.dom.outer.addClass('d-state-visible');
			if (this._isLock) {
				this._lockMask.show();
			};
			return this;
		},
		hidden: function() {
			this.dom.wrap.css('visibility', 'hidden');
			this.dom.outer.removeClass('d-state-visible');
			if (this._isLock) {
				this._lockMask.hide();
			};
			return this;
		},
		close: function() {
			if (this.closed) {
				return this;
			};
			var dom = this.dom,
			$wrap = dom.wrap,
			list = artDialog.list,
			beforeunload = this.config.beforeunload,
			follow = this.config.follow;
			if (beforeunload && beforeunload.call(this) === false) {
				return this;
			};
			if (artDialog.focus === this) {
				artDialog.focus = null;
			};
			if (follow) {
				follow.removeAttribute(_expando + 'follow');
			};
			if (this._elemBack) {
				this._elemBack();
			};
			this.time();
			this.unlock();
			this._removeEvent();
			delete list[this.config.id];
			if (_singleton) {
				$wrap.remove();
			} else {
				_singleton = this;
				dom.title.html('');
				dom.content.html('');
				dom.buttons.html('');
				$wrap[0].className = $wrap[0].style.cssText = '';
				dom.outer[0].className = 'd-outer';
				$wrap.css({
					left: 0,
					top: 0,
					position: 'absolute'
				});
				for (var i in this) {
					if (this.hasOwnProperty(i) && i !== 'dom') {
						delete this[i];
					};
				};
				this.hidden();
			};
			this.closed = true;
			return this;
		},
		time: function(time) {
			var that = this,
			timer = this._timer;
			timer && clearTimeout(timer);
			if (time) {
				this._timer = setTimeout(function() {
					that._click('cancel');
				},
				time);
			};
			return this;
		},
		zIndex: function() {
			var dom = this.dom,
			top = artDialog.focus,
			index = artDialog.defaults.zIndex++;
			dom.wrap.css('zIndex', index);
			this._lockMask && this._lockMask.css('zIndex', index - 1);
			top && top.dom.outer.removeClass('d-state-focus');
			artDialog.focus = this;
			dom.outer.addClass('d-state-focus');
			return this;
		},
		lock: function() {
			if (this._isLock) {
				return this;
			};
			var that = this,
			config = this.config,
			dom = this.dom,
			$div = $('<div></div>'),
			index = artDialog.defaults.zIndex - 1;
			this.zIndex();
			dom.outer.addClass('d-state-lock');
			$div.css({
				zIndex: index,
				position: 'fixed',
				left: 0,
				top: 0,
				width: '100%',
				height: '100%',
				overflow: 'hidden'
			}).addClass('d-mask');
			if (!_isFixed) {
				$div.css({
					position: 'absolute',
					width: dom.window.width() + dom.document.scrollLeft() + 'px',
					height: dom.document.height() + 'px'
				});
			};
			$div.bind('click',
			function() {
				that._reset();
			}).bind('dblclick',
			function() {
				that._click('cancel');
			});
			$("body").append($div);
			this._lockMask = $div;
			this._isLock = true;
			return this;
		},
		unlock: function() {
			if (!this._isLock) {
				return this;
			};
			this._lockMask.remove();
			this.dom.outer.removeClass('d-state-lock');
			this._isLock = false;
			return this;
		},
		_getDom: function() {
			var name,
			dom = {};
			var wrap = $('<div>' + artDialog._templates + '</div>');
			wrap.css({
				position: 'absolute',
				opacity: 0
			});
			$("body").append(wrap);
			wrap.find("[class^='d-']").each(function() {
				name = $(this).attr("class").split('d-')[1];
				dom[name] = $(this);
			});
			dom.window = $(window);
			dom.document = $(document);
			dom.wrap = wrap;
			return dom;
		},
		_click: function(id) {
			var fn = this._listeners[id] && this._listeners[id].callback;
			return typeof fn !== 'function' || fn.call(this) !== false ? this.close() : this;
		},
		_reset: function() {
			var elem = this.config.follow;
			if (elem) {
				return this
			}
			 else {
				this.position();
			}
		},
		_addEvent: function() {
			var that = this,
			dom = this.dom;
			dom.wrap.bind('click',
			function(event) {
				var target = event.target,
				callbackID;
				if (target.disabled) {
					return false;
				};
				if (target === dom.close[0]) {
					that._click('cancel');
					return false;
				} else {
					callbackID = target[_expando + 'callback'];
					callbackID && that._click(callbackID);
				};
			}).bind('mousedown',
			function() {
				that.zIndex();
			});
		},
		_removeEvent: function() {
			this.dom.wrap.unbind();
		}
	};
	artDialog.fn.constructor.prototype = artDialog.fn;
	$.fn.dialog = $.fn.artDialog = function() {
		var config = arguments;
		this[this.live ? 'live': 'bind']('click',
		function() {
			artDialog.apply(this, config);
			return false;
		});
		return this;
	};
	artDialog.focus = null;
	artDialog.follow = null;
	artDialog.get = function(id) {
		return id === undefined ? artDialog.list: artDialog.list[id];
	};
	artDialog.list = {};
	$(document).bind('keydown',
	function(event) {
		var target = event.target,
		nodeName = target.nodeName,
		rinput = /^input|textarea$/i,
		api = artDialog.focus,
		keyCode = event.keyCode;
		if (!api || !api.config.esc || rinput.test(nodeName) && target.type !== 'button') {
			return;
		};
		keyCode === 27 && api._click('cancel');
	});
	$(window).bind({
		'scroll': function() {
			var dialogs = artDialog.list;
			for (var id in dialogs) {
				dialogs[id]._reset();
			};
		},
		'resize': function() {
			var dialogs = artDialog.list;
			for (var id in dialogs) {
				dialogs[id]._reset();
			};
		}
	});
	artDialog._templates = '<div class="d-outer"><table class="d-border"><tbody><tr><td class="d-nw"></td><td class="d-n"></td><td class="d-ne"></td></tr><tr><td class="d-w">&nbsp;</td><td class="d-c"><div class="d-inner"><table class="d-dialog"><tbody><tr><td class="d-header"><div class="d-titleBar"><div class="d-title"></div><a class="d-close" href="javascript:;">\u00d7</a></div></td></tr><tr><td class="d-main"><div class="d-content"></div></td></tr><tr><td class="d-footer"><div class="d-buttons"></div></td></tr></tbody></table></div></td><td class="d-e">&nbsp;</td></tr><tr><td class="d-sw"></td><td class="d-s"></td><td class="d-se"></td></tr></tbody></table></div>';
	artDialog.defaults = {
		content: '<div class="d-loading"><span>loading..</span></div>',
		title: 'message',
		button: null,
		ok: null,
		cancel: null,
		initialize: null,
		beforeunload: null,
		okValue: 'ok',
		cancelValue: 'cancel',
		padding: '20px 25px',
		time: null,
		esc: true,
		visible: true,
		follow: null,
		lock: false,
		zIndex: 65000
	};
	this.artDialog = $.dialog = $.artDialog = artDialog;
} (this.art || this.jQuery, this)); (function(jQuery) {
	jQuery.fn.extend({
		elastic: function(options) {
			var defaults = {
				maxHeight: 1024
			};
			var options = $.extend(defaults, options);
			var mimics = ['paddingTop', 'paddingRight', 'paddingBottom', 'paddingLeft', 'fontSize', 'lineHeight', 'fontFamily', 'width', 'fontWeight'];
			return this.each(function() {
				var $obj = $(this),
				maxheight = parseInt(options.maxHeight, 10) || Number.MAX_VALUE,
				minheight = parseInt($obj.css('height'), 10) || lineHeight * 3,
				$twin = jQuery('<div />').css({
					'position': 'absolute',
					'display': 'none',
					'word-wrap': 'break-word',
					'word-break': 'break-all'
				});
				$twin.appendTo($obj.parent());
				var i = mimics.length;
				while (i--) {
					$twin.css(mimics[i].toString(), $obj.css(mimics[i].toString()));
				}
				function update() {
					var tContent = $obj.html()
					 var twinContent = $twin.html();
					if (tContent != twinContent) {
						$twin.html(tContent);
						if (Math.abs($twin.height() - $obj.height()) > 3) {
							var goalheight = $twin.height();
							if (goalheight >= maxheight) {
								$obj.css({
									'height': maxheight + 'px',
									'overflow-y': 'auto'
								});
							}
							 else if (goalheight <= minheight) {
								$obj.css({
									'height': minheight + 'px',
									'overflow-y': 'hidden'
								});
							}
							 else {
								$obj.css({
									'height': goalheight + 'px',
									'overflow-y': 'hidden'
								});
							}
						}
					}
				}
				if (browser.ie == 6 && !$.support.style) {
					$obj.css({
						'overflow-y': 'hidden'
					});
					$obj.keyup(function() {
						update();
					});
				}
			})
		}
	})
})(jQuery);