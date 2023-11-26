function hasClass(ele, cls) {
    return ele.className.match(new RegExp('(\\s|^)' + cls + '(\\s|$)'));
}
function addClass(ele, cls) {
    if (!this.hasClass(ele, cls)) ele.className += " " + cls;
}
function removeClass(ele, cls) {
    if (hasClass(ele, cls)) {
        var reg = new RegExp('(\\s|^)' + cls + '(\\s|$)');
        ele.className = ele.className.replace(reg, ' ');
    }
}
function itemhide(ele) {
	if (ele) ele.style.display = 'none';
}
function itemshow(ele) {
	if (ele) ele.style.display = 'block';
}
function reloadimg(obj){
	if (obj.src == '') {
		obj.src = obj.getAttribute('file');
	}
}
function loadingshowimg(obj){
	if ($(obj+"_menu")) {
		var imgli = $(obj+"_menu").getElementsByTagName("img");
		for (var i = 0; i < imgli.length; i++) {
			reloadimg(imgli[i]);
		}	
	}
}
function showrecommend(obj) {
    var len = recommendtablist.length;
    var onclass = 'on';
    for (var i = 0; i < len; i++) {
        var itemclass = recommendtablist[i];
        removeClass($('sr_' + itemclass), onclass);
        itemhide($('sr_' + itemclass + '_menu'));
    }
    addClass(obj, onclass);
    itemshow($(obj.id + '_menu'));
	if (sr_loadimg) {
		loadingshowimg(obj.id);
	}
}
function mshowitem(obj) {
    var len = newtablist.length;
    var onclass = 'c_active';
    for (var i = 0; i < len; i++) {
        var itemclass = newtablist[i];
        removeClass($('r_' + itemclass), onclass);
        itemhide($('r_' + itemclass + '_menu'));
    }
    addClass(obj, onclass);
    itemshow($(obj.id + '_menu'));
	if (sr_loadimg) {
		loadingshowimg(obj.id);
	}	
}
function onmousemove_hello(obj){
	if (obj) {
		obj.className = 'onedata2';
	}
}
function onmouseout_hello(obj){
	if (obj) {
		obj.className = 'onedata1';
	}
}
function getClient() {
    var l, t, w, h;
    l = document.documentElement.scrollLeft || document.body.scrollLeft;
    t = document.documentElement.scrollTop || document.body.scrollTop;
    w = document.documentElement.clientWidth;
    h = document.documentElement.clientHeight;
    return {
        'left': l,
        'top': t,
        'width': w,
        'height': h
    };
}
function getSubClient(p) {
    var l = 0,
    t = 0,
    w, h;
    w = p.offsetWidth;
    h = p.offsetHeight;
    while (p.offsetParent) {
        l += p.offsetLeft;
        t += p.offsetTop;
        p = p.offsetParent;
    }
    return {
        'left': l,
        'top': t,
        'width': w,
        'height': h
    };
}
function intens(rec1, rec2) {
    var lc1, lc2, tc1, tc2, w1, h1;
    lc1 = rec1.left + rec1.width / 2;
    lc2 = rec2.left + rec2.width / 2;
    tc1 = rec1.top + rec1.height / 2;
    tc2 = rec2.top + rec2.height / 2;
    w1 = (rec1.width + rec2.width) / 2;
    h1 = (rec1.height + rec2.height) / 2;
    return Math.abs(lc1 - lc2) < w1 && Math.abs(tc1 - tc2) < h1;
}
function jiance(arr, prec1, callback) {　
    var prec2;　
    for (var i = arr.length - 1; i >= 0; i--) {
        if (arr[i]) {
            prec2 = getSubClient(arr[i]);
            if (intens(prec1, prec2)) {
                callback(arr[i]);
                delete arr[i];
            }
        }　
    }
}
function autocheck() {
    var prec1 = getClient();
    jiance(arr, prec1,
    function(obj) {
		if ($("branditem")) {
			var imgli = $("branditem").getElementsByTagName("img");
			for (var i = 0; i < imgli.length; i++) {
				if (imgli[i].className == 'brlogo') {
					reloadimg(imgli[i]);
				}
			}
		}
		if ($("r_goods_menu")) {
			var imgli = $("r_goods_menu").getElementsByTagName("img");
			for (var i = 0; i < imgli.length; i++) {
				if (imgli[i].className == 'goodslogo') {
					reloadimg(imgli[i]);
				}
			}
		}		
    })
}

var Class = {
    create: function() {
        return function() {
            this.initialize.apply(this, arguments)
        }
    }
}
var Bind = function(object, fun) {
    return function() {
        return fun.apply(object, arguments)
    }
}
var BindAsEventListener = function(object, fun) {
    return function(event) {
        return fun.call(object, (event || window.event))
    }
}
var Extend = function(destination, source) {
    for (var property in source) {
        destination[property] = source[property]
    }
}
function addEventHandler(oTarget, sEventType, fnHandler) {
    if (oTarget.addEventListener) {
        oTarget.addEventListener(sEventType, fnHandler, false)
    } else if (oTarget.attachEvent) {
        oTarget.attachEvent("on" + sEventType, fnHandler)
    } else {
        oTarget["on" + sEventType] = fnHandler
    }
};
function removeEventHandler(oTarget, sEventType, fnHandler) {
    if (oTarget.removeEventListener) {
        oTarget.removeEventListener(sEventType, fnHandler, false)
    } else if (oTarget.detachEvent) {
        oTarget.detachEvent("on" + sEventType, fnHandler)
    } else {
        oTarget["on" + sEventType] = null
    }
};
var sBrandLideShow = Class.create();
sBrandLideShow.prototype = {
    initialize: function(slide, options) {
        this.SetOptions(options);
        this.width = this.options.width;
        this.Remaintime = this.options.Remaintime;
        this.slide = $(slide);
        this.slide_prve = $(this.options.slide_prve);
        this.slide_next = $(this.options.slide_next);
        this.index = 0;
        this.length = $(slide).getElementsByTagName("li").length;
		if (this.length<2) return;
        this.picTimer = null;
        this.onOver = this.options.onOver;
        this.onOut = this.options.onOut;
        this.Action();
    },
    SetOptions: function(options) {
        this.options = {
            slide_prve: 'slide_prve',
            slide_next: 'slide_next',
            Remaintime: 5000,
            width: '960',
            onStart: function() {},
            onOver: function() {},
            onOut: function() {}
        }
        Extend(this.options, options || {});
    },
    Action: function() {
        var Handel = this;
        addEventHandler(this.slide, "mouseover", BindAsEventListener(this, this.Over));
        addEventHandler(this.slide, "mouseout", BindAsEventListener(this, this.Out));
        addEventHandler(this.slide_prve, "click", BindAsEventListener(this, this.Prve));
        addEventHandler(this.slide_prve, "mouseover", BindAsEventListener(this, this.Over));
        addEventHandler(this.slide_prve, "mouseout", BindAsEventListener(this, this.Out));
        addEventHandler(this.slide_next, "click", BindAsEventListener(this, this.Next));
        addEventHandler(this.slide_next, "mouseover", BindAsEventListener(this, this.Over));
        addEventHandler(this.slide_next, "mouseout", BindAsEventListener(this, this.Out));
        this.Out();
    },
    Next: function() {
        if (this.index == this.length) {
            this.index = 0;
        }
        this.showPics(this.index);
        this.index++;
    },
    Prve: function() {
        this.index--;
        if (this.index < 0) {
            this.index = 4;
        }
        this.showPics(this.index);
    },
    Over: function(oEvent) {
        this.onOver();
        clearInterval(this.picTimer);
    },
    Out: function(oEvent) {
        this.onOut();
        var Handel = this;
        this.picTimer = setInterval(function() {
            Handel.showPics(Handel.index);
            Handel.index++;
            if (Handel.index == Handel.length) {
                Handel.index = 0;
            }
        },
        Handel.Remaintime);
    },
    showPics: function(nindex) {
        var nowLeft = -nindex * this.width;
        var Handel = this;
        this.slide.style.marginLeft = nowLeft + 'px';
    }
};
if (isbigslide) {
	new sBrandLideShow('slideul');
}
if (sr_loadimg) {
	var d1 = document.getElementById("branditem");
	var d2 = document.getElementById("r_goods_menu");
	var arr = [d1,d2];
	window.onscroll = function() {
		autocheck();
	}
	window.onresize = function() {
		autocheck();
	}
}
/*
var catebarli=$("xp2").getElementsByTagName("a");
for(var i=0;i<catebarli.length;i++){
	catebarli[i].onclick= function(){
		this.href = this.href + '#xp1';
	};
}	
var optionli=$("option").getElementsByTagName("a");
for(var i=0;i<optionli.length;i++){
	optionli[i].onclick= function(){
		this.href = this.href + '#xp2';
	};
}	
if ($("xp3")) {
	var optionli=$("xp3").getElementsByTagName("a");
	for(var i=0;i<optionli.length;i++){
		optionli[i].onclick= function(){
			this.href = this.href + '#xp2';
		};
	}	
}*/