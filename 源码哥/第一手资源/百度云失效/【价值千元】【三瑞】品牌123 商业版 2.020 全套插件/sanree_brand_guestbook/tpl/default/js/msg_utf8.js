function srshowdialog(ajaxframeid) {
	var ajaxframeid = 'ajaxframe';
	try {
		s = $(ajaxframeid).contentWindow.document.XMLDocument.text;
	} catch(e) {
		try {
			s = $(ajaxframeid).contentWindow.document.documentElement.firstChild.wholeText;
		} catch(e) {
			try {
				s = $(ajaxframeid).contentWindow.document.documentElement.firstChild.nodeValue;
			} catch(e) {
				s = '内部错误，无法显示此内容';
			}
		}
	}
	msg = s;
	if (msg.indexOf('hideWindow')<5) {
		showError(msg);
	}
	else {
		
		var p = /<script[^\>]*?>([^\x00]*?)<\/script>/ig;
		msg = msg.replace(p, '');
		if(msg !== '') {
			showDialog(msg, 'right', '', null, true, null, '', '', '', 3);
		}
	}
}