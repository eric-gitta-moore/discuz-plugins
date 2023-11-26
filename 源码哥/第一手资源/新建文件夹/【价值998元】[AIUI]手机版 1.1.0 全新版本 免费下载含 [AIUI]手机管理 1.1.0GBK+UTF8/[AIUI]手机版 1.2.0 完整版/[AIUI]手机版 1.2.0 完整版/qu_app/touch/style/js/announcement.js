/*
	$Id: announcement.js Ô´Âë¸çwww.ymg6.com   QQÈº£º550494646 $
*/

function announcement() {
	var ann = new Object();
	ann.anndelay = 3000;ann.annst = 0;ann.annstop = 0;ann.annrowcount = 0;ann.anncount = 0;ann.annlis = document.getElementById('anc').getElementsByTagName("li");ann.annrows = new Array();
	ann.announcementScroll = function () {
		if(this.annstop) {this.annst = setTimeout(function () {ann.announcementScroll();}, this.anndelay);return;}
		if(!this.annst) {
			var lasttop = -1;
			for(i = 0;i < this.annlis.length;i++) {
				if(lasttop != this.annlis[i].offsetTop) {
					if(lasttop == -1) lasttop = 0;
					this.annrows[this.annrowcount] = this.annlis[i].offsetTop - lasttop;this.annrowcount++;
				}
				lasttop = this.annlis[i].offsetTop;
			}
			if(this.annrows.length == 1) {
				document.getElementById('an').onmouseover = document.getElementById('an').onmouseout = null;
			} else {
				this.annrows[this.annrowcount] = this.annrows[1];
				document.getElementById('ancl').innerHTML += document.getElementById('ancl').innerHTML;
				this.annst = setTimeout(function () {ann.announcementScroll();}, this.anndelay);
				document.getElementById('an').onmouseover = function () {ann.annstop = 1;};
				document.getElementById('an').onmouseout = function () {ann.annstop = 0;};
			}
			this.annrowcount = 1;
			return;
		}
		if(this.annrowcount >= this.annrows.length) {
			document.getElementById('anc').scrollTop = 0;
			this.annrowcount = 1;
			this.annst = setTimeout(function () {ann.announcementScroll();}, this.anndelay);
		} else {
			this.anncount = 0;
			this.announcementScrollnext(this.annrows[this.annrowcount]);
		}
	};
	ann.announcementScrollnext = function (time) {
		document.getElementById('anc').scrollTop++;
		this.anncount++;
		if(this.anncount != time) {
			this.annst = setTimeout(function () {ann.announcementScrollnext(time);}, 10);
		} else {
			this.annrowcount++;
			this.annst = setTimeout(function () {ann.announcementScroll();}, this.anndelay);
		}
	};
	ann.announcementScroll();
}