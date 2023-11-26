jq.extend({
	createuploadiframe: function(id, url) {
		var iframeid = 'uploadiframe' + id;
		var iframe = '<iframe id="' + iframeid + '" name="' + iframeid + '"';
		if(window.ActiveXObject) {
			if(typeof url == 'boolean') {
				iframe += ' src="' + 'javascript:false' + '"';
			} else if(typeof url == 'string') {
				iframe += ' src="' + url + '"';
			}
		}
		iframe += ' />';
		jq(iframe).css({'position':'absolute', 'top':'-1200px', 'left':'-1200px'}).appendTo(document.body);
		return jq('#' + iframeid).get(0);
    },
	createuploadform: function(id, fileobjid, data) {
		var formid = 'uploadform' + id;
		var fileid = 'uploadfile' + id;
		var form = jq('<form method="post" name="' + formid + '" id="' + formid + '" enctype="multipart/form-data"></form>');
		if(data) {
			for(var i in data) {
				jq('<input type="hidden" name="' + i + '" value="' + data[i] + '" />').appendTo(form);
			}
		}
		var oldobj = jq('#' + fileobjid);
		var newobj = jq(oldobj).clone();
		jq(oldobj).attr('id', fileid).before(newobj).appendTo(form);
		jq(form).css({'position':'absolute', 'top':'-1200px', 'left':'-1200px'}).appendTo(document.body);
		return form;
	},
	ajaxfileupload: function(s) {
		s = jq.extend({}, jq.ajaxSettings, s);
		var id = new Date().getTime();
		var form = jq.createuploadform(id, s.fileElementId, (typeof(s.data)=='undefined'?false:s.data));
		var io = jq.createuploadiframe(id, s.secureuri);
		var iframeid = 'uploadiframe' + id;
		var formid = 'uploadform' + id;

		if(s.global && ! jq.active++) {
			jq.event.trigger("ajaxStart");
		}
		var requestDone = false;
        var xml = {};
        if(s.global) {
			jq.event.trigger("ajaxSend", [xml, s]);
		}
		var uploadcallback = function(istimeout) {
			var io = document.getElementById(iframeid);
			try {
				if(io.contentWindow) {
					xml.responseText = io.contentWindow.document.body?io.contentWindow.document.body.innerHTML:null;
					xml.responseXML = io.contentWindow.document.XMLDocument?io.contentWindow.document.XMLDocument:io.contentWindow.document;
				} else if(io.contentDocument) {
					xml.responseText = io.contentDocument.document.body?io.contentDocument.document.body.innerHTML:null;
					xml.responseXML = io.contentDocument.document.XMLDocument?io.contentDocument.document.XMLDocument:io.contentDocument.document;
				}
			} catch(e) {
				jq.handleerror(s, xml, null, e);
			}
			if(xml||istimeout == 'timeout') {
				requestdone = true;
				var status;
				try {
					status = istimeout != 'timeout' ? 'success' : 'error';
					if(status != 'error') {
						var data = jq.uploadhttpdata(xml, s.dataType);
						if(s.success) {
							s.success( data, status );
						}
						if(s.global) {
							jq.event.trigger("ajaxSuccess", [xml, s]);
						}
					} else {
                        jq.handleerror(s, xml, status);
					}
				} catch(e) {
					status = 'error';
					jq.handleerror(s, xml, status, e);
				}
				if(s.global) {
					jq.event.trigger("ajaxComplete", [xml, s]);
				}

				if(s.global && ! --jq.active) {
					jq.event.trigger("ajaxStop");
				}

				if (s.complete) {
					s.complete(xml, status);
				}

				jq(io).off();

				setTimeout(function() {
					try {
						jq(io).remove();
						jq(form).remove();
					} catch(e) {
						jq.handleerror(s, xml, null, e);
					}
				}, 100);

				xml = null;
			}
		}
		if(s.timeout > 0) {
			setTimeout(function() {
				if(!requestdone) {
					uploadcallback('timeout');
				}
			}, s.timeout);
		}
		try {
			var form = jq('#' + formid);
			jq(form).attr('action', s.url).attr('method', 'post').attr('target', iframeid);
			if(form.encoding) {
				jq(form).attr('encoding', 'multipart/form-data');
			} else {
				jq(form).attr('enctype', 'multipart/form-data');
			}
			jq(form).submit();
		} catch(e) {
			jq.handleerror(s, xml, null, e);
		}

		jq('#' + iframeid).load(uploadcallback);
		return {abort: function () {}};
    },
	uploadhttpdata: function(r, type) {
		var data = !type;
		data = type == 'xml' || data ? r.responseXML : r.responseText;
		if(type == 'script') {
			jq.globalEval(data);
		}
		if(type == "json") {
			eval("data = " + data);
		}
		if(type == "html") {
			jq("<div>").html(data);
		}
		return data;
	},
	handleerror: function(s, xhr, status, e) {
		if(s.error) {
			s.error.call(s.context || s, xhr, status, e);
		}
		if(s.global) {
			(s.context ? jq(s.context) : jq.event).trigger("ajaxError", [xhr, s, e]);
		}
	}
});