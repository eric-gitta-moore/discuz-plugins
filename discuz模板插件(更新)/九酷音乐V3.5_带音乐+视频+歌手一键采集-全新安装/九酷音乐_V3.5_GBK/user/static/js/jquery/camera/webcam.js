window.webcam = {
	version: '1.0.9',
	ie: !!navigator.userAgent.match(/MSIE/),
	protocol: location.protocol.match(/https/i) ? 'https': 'http',
	callback: null,
	swf_url: zone_domain + 'static/js/jquery/camera/webcam.swf',
	shutter_url: zone_domain + 'static/js/jquery/camera/shutter.mp3',
	api_url: '',
	loaded: false,
	quality: 90,
	shutter_sound: true,
	stealth: false,
	hooks: {
		onLoad: null,
		onComplete: null,
		onError: null
	},
	set_hook: function(name, callback) {
		if (typeof(this.hooks[name]) == 'undefined')
		 return alert("Hook type not supported: " + name);
		this.hooks[name] = callback;
	},
	fire_hook: function(name, value) {
		if (this.hooks[name]) {
			if (typeof(this.hooks[name]) == 'function') {
				this.hooks[name](value);
			}
			 else if (typeof(this.hooks[name]) == 'array') {
				this.hooks[name][0][this.hooks[name][1]](value);
			}
			 else if (window[this.hooks[name]]) {
				window[this.hooks[name]](value);
			}
			return true;
		}
		return false;
	},
	set_api_url: function(url) {
		this.api_url = url;
	},
	set_swf_url: function(url) {
		this.swf_url = url;
	},
	get_html: function(width, height, server_width, server_height) {
		if (!server_width) server_width = width;
		if (!server_height) server_height = height;
		var html = '';
		var flashvars = 'shutter_enabled=' + (this.shutter_sound ? 1: 0) + '&shutter_url=' + escape(this.shutter_url) + '&width=' + width + '&height=' + height + '&server_width=' + server_width + '&server_height=' + server_height;
		if (this.ie) {
			html += '<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="' + this.protocol + '://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,0,0" width="' + width + '" height="' + height + '" id="webcam_movie" align="middle"><param name="allowScriptAccess" value="always" /><param name="allowFullScreen" value="false" /><param name="movie" value="' + this.swf_url + '" /><param name="loop" value="false" /><param name="menu" value="false" /><param name="quality" value="best" /><param name="bgcolor" value="#ffffff" /><param name="flashvars" value="' + flashvars + '"/></object>';
		}
		 else {
			html += '<embed id="webcam_movie" src="' + this.swf_url + '" loop="false" menu="false" quality="best" bgcolor="#ffffff" width="' + width + '" height="' + height + '" name="webcam_movie" align="middle" allowScriptAccess="always" allowFullScreen="false" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" flashvars="' + flashvars + '" />';
		}
		this.loaded = false;
		return html;
	},
	get_movie: function() {
		if (!this.loaded) return $.tipMessage("请检查摄像设备驱动！", 2, 3000);
		var movie = document.getElementById('webcam_movie');
		if (!movie) $.tipMessage("设备连接有误，请刷新页面后重试！", 2, 3000);
		return movie;
	},
	set_stealth: function(stealth) {
		this.stealth = stealth;
	},
	snap: function(url, callback, stealth) {
		if (callback) this.set_hook('onComplete', callback);
		if (url) this.set_api_url(url);
		if (typeof(stealth) != 'undefined') this.set_stealth(stealth);
		this.get_movie()._snap(this.api_url, this.quality, this.shutter_sound ? 1: 0, this.stealth ? 1: 0);
	},
	freeze: function() {
		if (typeof(this.get_movie()) == "object") {
			this.get_movie()._snap('', this.quality, this.shutter_sound ? 1: 0, 0);
			return 1;
		}
	},
	upload: function(url, callback) {
		if (callback) this.set_hook('onComplete', callback);
		if (url) this.set_api_url(url);
		this.get_movie()._upload(this.api_url);
	},
	reset: function() {
		if (typeof(this.get_movie()) == "object") {
			this.get_movie()._reset();
		}
	},
	configure: function(panel) {
		if (!panel) panel = "camera";
		this.get_movie()._configure(panel);
	},
	set_quality: function(new_quality) {
		this.quality = new_quality;
	},
	set_shutter_sound: function(enabled, url) {
		this.shutter_sound = enabled;
		this.shutter_url = url ? url: 'shutter.mp3';
	},
	flash_notify: function(type, msg) {
		switch (type) {
		case 'flashLoadComplete':
			this.loaded = true;
			this.fire_hook('onLoad');
			break;
		case 'error':
			if (!this.fire_hook('onError', msg)) {
				$.tipMessage("未检测到拍照设备，无法进行拍照！", 2, 3000);
			}
			break;
		case 'success':
			this.fire_hook('onComplete', msg.toString());
			break;
		default:
			alert("jpegcam flash_notify: " + type + ": " + msg);
			break;
		}
	}
};