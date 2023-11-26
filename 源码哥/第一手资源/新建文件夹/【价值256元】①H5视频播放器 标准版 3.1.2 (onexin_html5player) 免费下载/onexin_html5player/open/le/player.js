/*Created by ZY on Thu Sep 28 2017 15:24:42 GMT+0800 (CST) */
!function(e) {
    function t(i) {
        if (a[i])
            return a[i].exports;
        var s = a[i] = {
            exports: {},
            id: i,
            loaded: !1
        };
        return e[i].call(s.exports, s, s.exports, t),
        s.loaded = !0,
        s.exports
    }
    var a = {};
    return t.m = e,
    t.c = a,
    t.p = "",
    t(0)
}([function(e, t, a) {
    a(1)
}
, function(e, t, a) {
    !function() {
        var e = a(2)
          , t = a(3)
          , i = a(4)
          , s = a(6);
        if ("undefined" == typeof LETV_PLAYER && (window.LETV_PLAYER = {}),
        "undefined" == typeof LETV_PLAYER.Player) {
            var n = a(7)
              , r = a(15);
            LETV_PLAYER.playerInterface || (LETV_PLAYER.playerInterface = a(67));
            var o = 1
              , l = "http://player.hz.letv.com/hzplayer.swf/open"
              , d = "https://player.letvcdn.com/lc04_p/201612/30/17/57/17/newplayer/LetvPlayer.swf"
              , h = {
                containerId: !0,
                isH5: !0,
                playerId: !0,
                debug: !0,
                host: !0,
                width: !0,
                height: !0,
                wmode: !0,
                flashUrl: !0,
                event: !0,
                "interface": !0
            }
              , c = {
                ark: !0,
                p1: !0,
                p2: !0
            }
              , p = "U2FsdGVkX19BsgrtK3jYsXlDJGOX6pwOLazJVSp/qfdTN7DgLv8XDUYqgv+9ove8"
              , u = {
                preload: 1,
                autoMute: 0,
                forceCallback: 1,
                barrage: 0,
                camera: 0,
                isHttps: 0
            };
            LETV_PLAYER.CONFIG = {
                lan: "cn",
                region: "cn",
                version: "3.9.2"
            };
            var g = function(e) {
                t.merge(LETV_PLAYER.CONFIG, e)
            }
              , f = function(e, t) {
                if (e = e || {},
                t = t || p,
                !e.containerId)
                    return void alert("The containerId must be needed");
                if (this.cont = s("#" + e.containerId),
                !this.cont.length)
                    return void alert("Can't find the dom which id is " + e.containerId);
                if (!e.vid)
                    return void this._showErr("The vid must be needed");
                if (e = this._initOptions(e, t)) {
                    var a = this._initFlashVar(e);
                    this.config = {
                        isH5: e.isH5,
                        playerId: e.playerId,
                        cont: e.containerId,
                        flashUrl: e.flashUrl || (e.isHttps ? d : l),
                        option: {
                            w: e.width || "100%",
                            h: e.height || "100%",
                            wmode: e.wmode
                        },
                        flashvar: a
                    },
                    this.player = this.load()
                }
            };
            f.prototype = {
                splatIdList: ["101", "304", "301", "1614"],
                regionList: ["cn", "us", "hk"],
                playId: function(e, t) {
                    try {
                        this.player.isH5 ? this.player.playNewId(e, t) : this.player.playNewId(e)
                    } catch (a) {}
                },
                startUp: function() {
                    try {
                        this.player.isH5 ? this.player.resumeVideo() : this.player.startUp()
                    } catch (e) {}
                },
                getLog: function() {
                    try {
                        if (this.player.isH5)
                            return this.player.getLog()
                    } catch (e) {}
                },
                pause: function() {
                    try {
                        this.player.pauseVideo()
                    } catch (e) {}
                },
                play: function() {
                    try {
                        this.player.resumeVideo()
                    } catch (e) {}
                },
                pushBarrage: function(e) {
                    try {
                        this.player.pushBarrageData(e)
                    } catch (t) {}
                },
                seek: function(e) {
                    try {
                        this.player.seekTo(e)
                    } catch (t) {}
                },
                loginStateChange: function() {
                    try {
                        this.player.setVip()
                    } catch (e) {}
                },
                changeDefi: function(e) {
                    try {
                        this.player.changeDefi(e)
                    } catch (t) {}
                },
                setSize: function(e, t) {
                    if (this.cont.width(e),
                    this.cont.height(t),
                    this.player.isH5)
                        try {
                            this.player.resize()
                        } catch (a) {}
                },
                setChangeInteractive: function(e) {
                    try {
                        this.player.setChangeInteractive(e)
                    } catch (t) {}
                },
                setFullScreen: function(e) {
                    try {
                        this.player.changeFullScreen(e)
                    } catch (t) {}
                },
                setChangeBarrage: function(e) {
                    try {
                        this.player.setChangeBarrage(e)
                    } catch (t) {}
                },
                setEffectBarrage: function(e) {
                    try {
                        this.player.setEffectBarrage(e)
                    } catch (t) {}
                },
                getVideoInfo: function() {
                    try {
                        var e;
                        return e = this.player.isH5 ? this.player.getVideoInfo() : this.player.getVideoSetting(),
                        {
                            vid: e.vid,
                            pid: e.pid,
                            cid: e.cid,
                            nextvid: e.nextvid,
                            duration: e.duration,
                            title: e.title
                        }
                    } catch (t) {
                        return {}
                    }
                },
                getCurrentState: function() {
                    try {
                        var e, t;
                        return this.player.isH5 ? (e = this.player.getCurrTime(),
                        t = this.player.getFullScreenState()) : e = this.player.getVideoTime(),
                        {
                            curTime: e,
                            fullState: t
                        }
                    } catch (a) {
                        return {
                            curTime: 0,
                            fullState: 0
                        }
                    }
                },
                setNextVid: function(e) {
                    e && e.nextvid && this.player.setNextVid(e.nextvid)
                },
                addGoodsSuccess: function(e) {
                    this.player.isH5 || this.player.addGoodsSuccess(e)
                },
                getGoodsUrl: function(e) {
                    this.player.isH5 || this.player.getGoodsUrl(e)
                },
                load: function() {
                    var t, a = this.config;
                    return a.isH5 ? (t = new r(a),
                    t.isH5 = !0) : (a.option.wmode = a.option.wmode || (e.safari ? "gpu" : "opaque"),
                    a.option.id = "www_player_" + this.config.playerId,
                    t = new n(a.cont,a.option,a.flashvar,a.flashUrl || l,[10, 0, 0])),
                    t
                },
                reload: function(e) {
                    e && (this.config.flashvar = this.config.flashvar.replace(/vid=(\d+)/, "vid=" + e));
                    try {
                        this.config.isH5 && this.player.destroy(),
                        this.player = this.load()
                    } catch (t) {}
                },
                _initOptions: function(a, s) {
                    if (s = i.getAPIKey(s),
                    "" == s || "error" == s)
                        return this._showErr("The key is not available"),
                        null;
                    for (var n = s.split("&"), r = {}, l = 0, d = n.length; l < d; l++) {
                        var h = n[l].split("=");
                        2 == h.length && (r[h[0]] = h[1])
                    }
                    r.host = r.host || "",
                    /(letv\.com|le\.com)/.test(r.host) && (r.host = "(" + r.host + "|" + r.host.replace(RegExp.$1, "letv.com" == RegExp.$1 ? "le.com" : "letv.com") + ")");
                    var p = new RegExp(r.host.replace(/\./g, "\\."),"i");
                    if (1 == r.debug)
                        alert("此key仅供开发调试使用，正式线上请联系yangkexin@letv.com或qq群369063801获取正式秘钥");
//                    else if (!r.host || !p.test(location.hostname))
//                        return void this._showErr("This hostname does not have authority to use LETV Player SDK");
                    if (a.splatId && t.arrayIndexOf(this.splatIdList, a.splatId.toString()) < 0)
                        return void this._showErr("This splatId does not supported");
                    if (LETV_PLAYER.CONFIG.region && t.arrayIndexOf(this.regionList, LETV_PLAYER.CONFIG.region) < 0)
                        return void this._showErr("This region does not supported");
                    for (var g in c)
                        r[g] || (r[g] = "limited");
                    for (var f in r)
                        "limited" == r[f] ? "undefined" != typeof a[f] && delete a[f] : "nolimited" != r[f] && (a[f] = r[f]);
                    return a = t.merge(a, u, !0),
                    "H5" == a.playerType ? a.isH5 = 1 : "flash" == a.playerType ? a.isH5 = 0 : a.isH5 = e.Android || e.iPad || e.iPod || e.iPhone || e.mac && e.safari || e.wph || e.ps,
                    a.p1 = a.p1 || (a.isH5 ? "0" : "1"),
                    a.p2 = a.p2 || (a.isH5 ? "MPlayer" == a.pname ? "04" : "06" : "10"),
                    a.forceCDN = 1,
                    a.lan = a.lan || LETV_PLAYER.CONFIG.lan,
                    a.region = LETV_PLAYER.CONFIG.region,
                    a.playerId = o++,
                    a
                },
                _initFlashVar: function(e) {
                    var a = {
                        getCookie: function(e) {
                            return t.getCookie(e)
                        }
                    };
                    e.event = e.event || {},
                    e["interface"] = t.merge(e["interface"] || {}, a);
                    var i = []
                      , s = this
                      , n = "vjs_callback_" + ((new Date).getTime() + "" + Math.floor(100 * Math.random()));
                    window[n] = function(t, a) {
                        var i = s._getCallbackName(t);
                        if ("function" == typeof e["interface"][i])
                            return e["interface"][i](a);
                        if ("function" == typeof LETV_PLAYER.playerInterface[i])
                            return LETV_PLAYER.playerInterface[i](a);
                        var n = e.event[i];
                        return n ? n(t, a) : e.event.defaultFun && e.event.defaultFun(t, a)
                    }
                    ,
                    e.callbackJs = n;
                    for (var r in e)
                        h[r] || "undefined" == typeof e[r] || i.push(r + "=" + e[r]);
                    return i.push("hostnamestr=" + (/letv\.com/.test(location.hostname) ? "letv" : "le")),
                    i.join("&")
                },
                _showErr: function(e) {
                    var t = this.cont.height();
                    this.cont[0].innerHTML = '<div style="text-align: center;line-height: ' + t + "px;height:" + t + 'px">' + e + "</div>"
                },
                _getCallbackName: function(a) {
                    var i = "";
                    switch (a) {
                    case "PLAYER_INIT":
                        i = "onPlayerInit";
                        break;
                    case "PLAYER_VIDEO_PLAY":
                        i = "onPlayerVideoPlay";
                        var s = this.config.isH5 && !e.isPC ? "m" : "pc";
                        t.sendRequest("http://fe-go.letv.com/ds", {
                            code: "cv-play-" + s,
                            lc: t.getCookie("tj_lc"),
                            _r: Math.random()
                        });
                        break;
                    case "PLAYER_SEEK":
                        i = "onPlayerSeek";
                        break;
                    case "PLAYER_VIDEO_PAUSE":
                        i = "onPlayerVideoPause";
                        break;
                    case "PLAYER_VIDEO_RESUME":
                        i = "onPlayerVideoResume";
                        break;
                    case "PLAYER_TIMEUPDATE":
                        i = "onPlayerTimeupdate";
                        break;
                    case "PLAYER_VIDEO_COMPLETE":
                        i = "onPlayerVideoComplete";
                        break;
                    case "PLAYER_PLAY_NEXT":
                        i = "onPlayerPlayNext";
                        break;
                    case "PLAYER_ERROR":
                        i = "onPlayerPlayError";
                        break;
                    case "PLAYER_FIRSTLOOK":
                        i = "onFirstLook";
                        break;
                    case "appGuideEnd":
                        i = "onAppguideEnd";
                        break;
                    case "displayTrylook":
                        i = "onDisplayTrylook";
                        break;
                    case "CHANGE_FULLSCREEN":
                        i = "onChangeFullscreen";
                        break;
                    case "APP_GUIDE":
                        i = "onAppGuide";
                        break;
                    case "PLAYER_GET_NEXT_VID":
                        i = "onPlayerNextVid";
                        break;
                    default:
                        i = a
                    }
                    return i
                }
            },
            LETV_PLAYER.config = g,
            LETV_PLAYER.Player = f
        }
    }()
}
, function(e, t, a) {
    function i() {
        if (r.Android && r.AndroidVersion >= 5 || r.weixin || r.letvMobile || r.iPad || r.iPhone || r.iPod)
            return !1;
        for (var e = !1, t = ["cpqb", "360zqb", "p6-t00", "sm-", "samsung", "huawei"], a = 0, i = t.length; a < i; a++) {
            var s = new RegExp(t[a],"i");
            if (s.test(n)) {
                e = !0;
                break
            }
        }
        return !!e
    }
    var s = a(3)
      , n = navigator.userAgent.toLowerCase()
      , r = {
        iPhone: /iphone/.test(n),
        iPad: /ipad/.test(n),
        iPod: /ipod/.test(n),
        mac: /macintosh/.test(n),
        isLetv: /letv/.test(n),
        Android: /android/i.test(n),
        AndroidPad: /android/i.test(n) && !/mobile/.test(n),
        atwin: /win/.test(n),
        opera: /opera/.test(n),
        msie: /msie/.test(n),
        firefox: /firefox/.test(n),
        safari: /safari/i.test(n) && !/chrome/.test(n),
        wph: /windows phone/.test(n),
        ps: /playstation/.test(n),
        uc: /ucbrowser|ucweb/.test(n),
        qq: /qq(?!browser)/.test(n),
        qqbrower: /mqqbrowser/.test(n),
        browser360: /360browser/.test(n),
        liebao: /liebao/.test(n),
        xiaomi: /xiaomi/.test(n),
        weixin: /micromessenger/i.test(n),
        weibo: /__weibo__/i.test(n),
        letvMobile: /x500|x600|x800|x900|leuibrowser|EUI Browser/i.test(n),
        letvApp: /letvmobileclient|letvclient/i.test(n),
        LetvX60: /LETVX60/.test(n),
        LetvX40: /LETVX40/.test(n),
        Window: /Windows/.test(n),
        Linux: /linux/.test(n),
        IE11: /Trident/i.test(n),
        IE9: /MSIE 9.0/i.test(n),
        wifi: /nettype\/wifi/i.test(n)
    };
    r.iosVersion = (n.match(/os (\d+)/) || [])[1],
    r.chrome = /chrome/.test(n) && !r.qqbrower && !r.browser360 && !r.weibo && !r.liebao,
    r.Notplayinline = r.iPhone && !r.weixin && !r.qq && !r.letvApp && !(r.iosVersion >= 10 && r.safari),
    r.letvTv = r.isLetv && !r.letvMobile && !r.letvApp,
    r.isMobile = /Android/i.test(n) || /iPhone|iPad|iPod/i.test(n);
    var o = /(webkit)[ \/]([\w.]+)/
      , l = /(opera)(?:.*version)?[ \/]([\w.]+)/
      , d = /(msie) ([\w.]+)/
      , h = /(mozilla)(?:.*? rv:([\w.]+))?/
      , c = o.exec(n) || l.exec(n) || d.exec(n) || n.indexOf("compatible") < 0 && h.exec(n) || [];
    if (r.version = c[2] || "0",
    r.isPC = r.mac && r.safari,
    r.isIOS = r.iPad || r.iPhone || r.iPod,
    r.Android) {
        var p = n.match(/android([^;]+)/i);
        if (p && p[1]) {
            var u = Number(p[1].split(".")[0]);
            isNaN(u) || (r.AndroidVersion = u)
        }
    }
    r.supportM3U8 = s.getCookie("vjs-supportM3U8"),
    r.forceMp4 = i(),
    e.exports = r
}
, function(module, exports) {
    var nativeBind = Function.prototype.bind
      , slice = Array.prototype.slice
      , emptyFn = function() {};
    module.exports = {
        extend: function(e, t) {
            var a = function() {};
            a.prototype = t.prototype,
            e.prototype = new a,
            e.prototype.constructor = e,
            e.superClass = t.prototype,
            t.prototype.constructor == Object.prototype.constructor && (t.prototype.constructor = t)
        },
        trim: function(e) {
            return e.replace(/^\s\s*/, "").replace(/\s\s*$/, "")
        },
        each: function(e, t) {
            var a, i;
            if (e instanceof Array) {
                for (a = 0; a < e.length; a++)
                    if (t.call(this, a, e[a]) === !1)
                        return e
            } else
                for (i in e)
                    if (t.call(this, i, e[i]) === !1)
                        return e;
            return e
        },
        getParamVal: function(e, t) {
            var a = new RegExp("(^|&)" + t + "=([^&]*)(&|$)","i")
              , i = e.match(a);
            return null != i ? unescape(i[2]) : ""
        },
        merge: function(e, t, a) {
            t || (t = {});
            for (var i in t)
                !t.hasOwnProperty(i) || a && e.hasOwnProperty(i) || (e[i] = t[i]);
            return e
        },
        clearObj: function(e) {
            for (var t in e)
                delete e[t]
        },
        setCookie: function(e, t, a) {
            a = a || {},
            null === t && (t = "",
            a.expires = -1);
            var i = "";
            if (a.expires && ("number" == typeof a.expires || a.expires.toUTCString)) {
                var s;
                "number" == typeof a.expires ? (s = new Date,
                s.setTime(s.getTime() + 24 * a.expires * 60 * 60 * 1e3)) : s = a.expires,
                i = "; expires=" + s.toUTCString()
            }
            var n = a.path ? "; path=" + a.path : ""
              , r = a.domain ? "; domain=" + a.domain : ""
              , o = a.secure ? "; secure" : "";
            document.cookie = [e, "=", encodeURIComponent(t), i, n, r, o].join("")
        },
        getCookie: function(e) {
            var t, a = new RegExp("(^| )" + e + "=([^;]*)(;|$)");
            return (t = document.cookie.match(a)) ? unescape(t[2]) : ""
        },
        getJSON: function(e) {
            var t, a, i = e.url, s = e.data, n = e.success, r = e.fail, o = e.callback || "callback", l = e.timeout || 5e3, d = e.maxCount || 2, h = -1, c = 0, p = this, u = document.head || document.getElementsByTagName("head")[0] || document.documentElement, g = [];
            if (s)
                for (var f in s)
                    g.push(f + "=" + s[f]);
            i += /\?/.test(i) ? "&" + g.join("&") : "?" + g.join("&");
            var v = function() {
                var e = p.now()
                  , t = "vjs_" + e + Math.floor(100 * Math.random());
                return window[t] = function(a) {
                    m(),
                    n.call(this, a, {
                        responseTime: p.now() - e,
                        retryCount: h,
                        url: i
                    }),
                    window[t] = null
                }
                ,
                t
            }
              , m = function() {
                window[t] && (window[t] = emptyFn),
                clearTimeout(c),
                a && a.parentNode && (u.removeChild(a),
                a.onload = a.onreadystatechange = null,
                a = void 0)
            }
              , _ = function() {
                if (m(),
                h++,
                h >= d)
                    return void (r && r.call(this, {
                        url: i
                    }));
                t = v();
                var s = i;
                /(\=)\?(&|$)/i.test(s) ? s = s.replace(/(\=)\?(&|$)/i, "$1" + t + "$2") : s += "&" + o + "=" + t,
                e.log && e.log.pushLog("lib getJSON===" + s + "===" + t + "====" + h),
                a = document.createElement("script"),
                a.setAttribute("type", "text/javascript"),
                a.setAttribute("src", s),
                u.insertBefore(a, u.firstChild),
                c = setTimeout(_, l)
            };
            return _(),
            {
                destroy: m
            }
        },
        formatValidateTime: function(e) {
            return e < 10 ? "0" + e : e
        },
        ajax: function(e) {
            var t = e.url
              , a = e.data
              , i = e.type || "get"
              , s = e.success
              , n = e.fail
              , r = [];
            for (var o in a)
                r.push(o + "=" + encodeURIComponent(a[o]));
            try {
                var l = new XMLHttpRequest;
                l.onload = function() {
                    4 == l.readyState && (l.status >= 200 && l.status < 300 || 304 == l.status ? s && s(l.responseText) : n && n(l.status))
                }
                ,
                "get" == i ? (t += t.indexOf("?") >= 0 ? "&" + r.join("&") : "?" + r.join("&"),
                l.open("get", t, !0),
                l.send(null)) : (l.open("post", t, !0),
                l.setRequestHeader("Content-type", "application/x-www-form-urlencoded"),
                l.send(r.length ? r.join("&") : null))
            } catch (d) {
                n && n()
            }
        },
        getScript: function(e, t, a) {
            var i = document.head || document.getElementsByTagName("head")[0] || document.documentElement
              , s = document.createElement("script");
            s.setAttribute("type", "text/javascript"),
            s.setAttribute("src", e),
            s.setAttribute("id", t),
            s.onload = function() {
                a && a()
            }
            ,
            i.insertBefore(s, i.firstChild)
        },
        sendRequest: function(e, t) {
            var a = [];
            if (t) {
                for (var i in t)
                    a.push(i + "=" + t[i]);
                e += /\?/.test(e) ? "&" : "?",
                e += a.join("&")
            }
            var s = new Image;
            s.onload = s.onerror = s.onabort = function() {
                s.onload = s.onerror = s.onabort = null,
                s = null
            }
            ,
            s.src = e
        },
        timer: function(e, t) {
            var a, i = 0, s = !1;
            return {
                repeatCount: function() {
                    return i
                },
                delay: function() {
                    return e
                },
                running: function() {
                    return s
                },
                start: function() {
                    a && clearInterval(a),
                    i = 0,
                    s = !0,
                    a = setInterval(function() {
                        i++,
                        t && t()
                    }, e)
                },
                stop: function() {
                    clearInterval(a),
                    s = !1
                },
                reset: function() {
                    i = 0,
                    a || this.start()
                }
            }
        },
        bind: function(e, t) {
            if (e.bind === nativeBind && nativeBind)
                return nativeBind.apply(e, slice.call(arguments, 1));
            var a = slice.call(arguments, 2);
            return function() {
                return e.apply(t, a.concat(slice.call(arguments)))
            }
        },
        createElement: function(e, t) {
            var a, i = document.createElement(e);
            for (a in t)
                t.hasOwnProperty(a) && (a.indexOf("-") !== -1 ? i.setAttribute(a, t[a]) : i[a] = t[a]);
            return i
        },
        now: Date.now || function() {
            return +new Date
        }
        ,
        formatTime: function(e) {
            var t = Math.floor(e / 60);
            t = t < 10 ? "0" + t : t.toString();
            var a = Math.floor(e % 60);
            return a = a < 10 ? "0" + a : a.toString(),
            t + ":" + a
        },
        formatDate: function(e, t, a) {
            if (!e)
                return "";
            var i = e instanceof Date ? e : new Date(1e3 * e)
              , s = String(i.getFullYear()).substr(2)
              , n = i.getMonth() + 1
              , r = i.getDate()
              , o = i.getHours()
              , l = i.getMinutes()
              , d = i.getSeconds();
            return o = o < 10 ? "0" + o : o,
            l = l < 10 ? "0" + l : l,
            d = d < 10 ? "0" + d : d,
            t = t || "YY.MM.DD HH.mm.ss",
            a && (s = i.getFullYear(),
            n = n < 10 ? "0" + n : n,
            r = r < 10 ? "0" + r : r),
            t.replace(/YY|MM|DD|HH|mm|ss/gi, function(e) {
                switch (e) {
                case "YY":
                    return s;
                case "MM":
                    return n;
                case "DD":
                    return r;
                case "HH":
                    return o;
                case "mm":
                    return l;
                case "ss":
                    return d
                }
            })
        },
        formatLiveTime: function(e) {
            return this.formatDate(e, "HH:mm:ss", !0)
        },
        parseToJSON: function(e) {
            if (!e)
                return {};
            var t, a = {}, i = /(.+?)=(.+)/, s = e.replace(/^[?&]/, "").split("&");
            return s.forEach(function(e) {
                t = e.match(i),
                null != t && (a[t[1]] = unescape(t[2]))
            }),
            a
        },
        JSONTOStr: function(e) {
            if (JSON)
                return JSON.stringify(e);
            switch (typeof e) {
            case "string":
                return '"' + e.replace(/(["\\])/g, "\\$1") + '"';
            case "object":
                if (e instanceof Array) {
                    for (var t = [], a = e.length, i = 0; i < a; i++)
                        t.push(arguments.callee(e[i]));
                    return "[" + t.join(",") + "]"
                }
                if (null == e)
                    return "null";
                var s = [];
                for (var n in e)
                    s.push(arguments.callee(n) + ":" + arguments.callee(e[n]));
                return "{" + s.join(",") + "}";
            case "number":
                return e;
            case !1:
                return e;
            case void 0:
            default:
                return ""
            }
        },
        StrTOJSON: function(str) {
            return window.JSON ? JSON.parse(str) : eval("(" + str + ")")
        },
        compare: function(e) {
            return function(t, a) {
                var i = t[e]
                  , s = a[e];
                return s < i ? 1 : s > i ? -1 : 0
            }
        },
        isEmptyObj: function(e) {
            if ("function" == typeof Object.keys)
                return 0 == Object.keys(e).length;
            for (var t in e)
                return !1;
            return !0
        },
        bjTimeToLocal: function(e) {
            var t = 60 * (e.getTimezoneOffset() + 480) * 1e3;
            return new Date(e.getTime() - t)
        },
        arrayIndexOf: function(e, t) {
            if ("function" == typeof e.indexOf)
                return e.indexOf(t);
            for (var a = 0, i = e.length; a < i; a++)
                if (e[a] === t)
                    return a;
            return -1
        },
        checkFullScreenFn: function(e) {
            for (var t, a, i, s, n, r = ["webkit", "moz"], o = 0, l = r.length; o < l; o++) {
                var d = r[o] + "RequestFullScreen"
                  , h = r[o] + "CancelFullScreen";
                "function" == typeof e[d] && (t = d,
                i = e,
                n = r[o] + "fullscreenchange"),
                "function" == typeof document[h] && (a = h,
                s = document)
            }
            return t || "function" != typeof e.msRequestFullscreen || (t = "msRequestFullscreen",
            i = e),
            t || "function" != typeof e.webkitEnterFullScreen || (t = "webkitEnterFullScreen",
            i = e),
            a || "function" != typeof document.msExitFullscreen || (a = "webkitExitFullScreen",
            s = document),
            a || "function" != typeof e.webkitExitFullScreen || (a = "webkitExitFullScreen",
            s = e),
            {
                requestFn: t,
                requestEl: i,
                cancelFn: a,
                cancelEl: s,
                changeEventName: n
            }
        }
    }
}
, function(module, exports, __webpack_require__) {
    var Encode = __webpack_require__(5);
    eval(eval(function(R9, C6, C7) {
        return eval("(" + R9 + ')("' + C6 + '","' + C7 + '")')
    }("function(s,t){for(var i=0,k='',f=function(j){return parseInt(t.substr(j%(t.length),2),16)/2;};i<s.length;i+=2){var d=parseInt(s.substr(i,2),16);k+=String.fromCharCode(d-f(i));}return k;}", "ded5df8cad91bba29cdca3d1d2e1d1e3db945edae2c6e6969896ac9598eca09f6197a293acbb608cab9de0a5a6ab6996a69aaaa463a8a0a999adac9465d7a1c7a0a6a698a596a29c9de466969895eca88f8cab9598eca39d61949c93a7bb5e8cae95a0a5999cad90d195a8ae6793d1d0cbd9d2956f87a496a0a6a694d39694df9fa95dc5e1d3d7ea97d2dd95c9a899b06988e7dbd5e84ec5a1aa8a9699ad6a9ca598a2ab65a89a9da69c9de46994989aa5a46096b4a091b395a36e8d9c9eaabb5f8fa5a496ab9fa57a8a9c8eaeaa6091a8b29bb0aa9468949a9db9a85a9aa59b91b3959e678da3aaa5a262939da1ad9f9f956f879cdda5a25edba0a591b0aa946c919a96b9a85a9ba39b9ea8b29f5e9ed2c6e0e9939d979e9da09de469c595a0dddc56c4a39bd4d9dbd3a9c7aa8daaad5c9ca4b29aa0a6a55e9b9497a6a45a95a09b91b395a26d8ba099a2aa6196b49f91ae959cad989895eca98f8cabaa90ab9e9a6690b190a4a260999d96a7a4e5a168999495ecaa658fa19e969da9a96e909aa49ca9638f9fe5cb9da79465d7d091aaaf5c99a7b2999d96d2a4d194dbd5e84eaca1aa90a7a39a6d95b190a5a264959d96a69c9ea56394b197a0ab6091a4b29a9dac9469929898a5a4579d9fe59aaba99e6e8da497b9a66d8b9fe59dd899a06c8da29ca6bb5e8ca99de0a99da86d959a98b9a96d8ba7a596ad9eb1688b9cddd89f688b9fe59aad99a46d8d9f98b9a957a197a29ea2999cad949d8eb39e639a9da2ad9f9e9866919a9dacbb599698a79ba6b29e73879e9ea2ac73949b9de0a6a6957487a096a2aa609bb4989ba09de46795959fa4ee6396abaa98ec9ed074879e9ea0a7679198a79fa69b9e68a49da3b1a6a696a6ac90a4e59d658b9cdda5d8579d97a19aa299a5658d95a0bda86c94aa96caa698a95da0a1a2b5ab6d8b9fe59dd699a2698d95a3b19e66939d9999a59ba06694b1969db56591a6a19fb99fa65d8fe498a6a2669898aba59ca29e6395a096b9a75a94a09b98a7a0b16788ab8dabae5c93a6b293a6999cad929d8eaeaa5e91abaa90a4e59d6e8b9cdda5ab57a2a8a296ae95a46b8d9d9eaabb608fa79d96a8a0b16588aaa29cad6291a3a2ada4999e6888ab8daba95c9bb49d94daced8a8c4959f9ca6a697a39998ecd095739c949ba4a4619cb49f94a4e59d6688ab95eca9688b9fe59ca0a3a56398a5aaa69f6aa097a19ba299a06a8d9eaaa59f6d8ba69d96a7a6a27a8f9895eca9918ca99598eca498678f95a39ca76691a4a49fb99e9865d7a0ca9db55698a7999daab29d5e999495ecad5a9698aba5aaa39a68a49795b39e61999d9eada499a16c8d9d9eb9a9579d979de0a59d9865d79dc69db05693e7a1cea0a6b1609195a1b19e669a9d9998eca2d05e9e949da0a6a696d596a2a4e59e679da98da4ee629a9b9e98a29fa57a9095a49ca6a69c9b9de0a8cf956f959a97a8a97394ad9de0a9a0ab5d98a091a4ee62c798a790a4e5a0978ba59ca2af739598a998eca3ab5d93a493acbb5f8fa49e96aa9eb16888a68da6ad5c8fa39f96a99fa57a8a9d8eb0a6a697d4ac90a4e5a16d8ba295a2a7669cb4989a9da7e0a7d4d18eb3d76291d2d5c9e6aee05da89e8eae986e8898d2d1e8d4955dd3b0dce2985cc6d7cedab5e1947e9199929db1a0c8e3e2dae28db0699ca9a2e2eb9acfaed2ded5d9949791959fb8aa8cc4a3ea919c8fcb6e87d9b9d9a457c8d08dcd9c8f985d969e93a6bb608fa29f96a6a3b16788aaa2a6a75c9cb49da7e2e2d8a1999499a6a466a8a2999fa996a865d79dc8b3ac609d979de0a8d39865d7a08eb0ac6591ae959da99b9c6a95b195a0a76191a0a1ada696a65d97a1aaa6a25f939da2ada696a85d969f93aca773969ba198a29fa26ea49c8eb39e669c9d9f9fa8b297678b9f9ba2a9739398a790a4e5a1668b9cdda6a8579f979de0a5a5986a8d9e9db9a657a2979de0a6cf9865d79e9a9db05edba4a591afdfd1a9d4ded3efde669dd5e2d6d7e1d5a4cd94d5a99fa9d9d0df88c8a298a996a98da4ee5f989ba099a2a0a269a49f8eb0b36196ae95a1a899a56c88a68dadae5c9bb49f94a4e59d9b88a895ecaa93a2979ea1a09de46588a68da4ee5f979b9de0ad96a87295a093a7bb60a2a5a296a8b29e6f879cdda7a75a93e7a1a19daba95d8fe498ada2669b98ac9aac9ba06992b197aeaf6291ab9fa1b3959cad92a091a4ee639598a790a8a3b1678b9cdda5d7578fdda3a5dea0aaa09198b9adb194d2e195a3e8a4a8a5949ad1d9e495d7d7a891efc1a57287dcc6e6e993acdde190e4a29a98c7cdd7b5ea56d7a69694a5a49a6ca49ea1a6aa5ca2979de0aa9f9865d7a28eae9e67969da099b9a0986a939a99b9a857a1ac959ca49ba166a49c91a4ee61c798ac90ac9e9865d79d959db05693e7a0a0a0a49f63939daa9fa657a1ac959aab9ba566a49d91aca75c8cae95a0a599a36ba49e8eaea6a697a7a9a59c9de468c1989dac9f6d8ba6a394ad9d956f879cdda7a75a93e79ecc9dab946e919a9cabbb59969ba49da296ab6c979a9f9cae6191a39eada5999cad91cf8eb2b364949da4ada6aca569999497a5a45f94a1b29aa09de46a88a88da4ee60989ba49aa2a6b16888ab95eca7659d979f9fa29f9f7a90989baca46797a7b2999d969563d3dbb8e8e897d1d69590aca69865d7a2979db25693e79f9fa09de4699495a49ca86491a19e9cb99e9867929a9ab9a9579d979f96a6a3b1668ba2999db46b9a9f9ba1b99eab5d96a293a5ae67a8a09998eca19f5e999495eca8638fa8a391b0959f6c8d9f97a5bb5f8fa09b9ab99e9574879cdda5da5a93e7a09b9da79465d79fcba0a6a69a98ab90a4e59d688b9cdda79f6d93e79fa29c9de46692989ea6bb618cadaa90a4e5a09b8ba09da29f6d9ba19ba29ca1a463939f9ab9a1608f9fe59bda96a87287a39ea2a6629cb49e94ad9e9a5e9e949da5a464a8a29998eca1d15e999cdda8d96ca0a3a396aca29f7a8a9fa4a8aa5c95a3b29baea4a15e9ac09ab1ea658e9aaaa59c9de46797989da4a46098a3b2999da9a95d959d93a0a6a694a196a79c9ea4638b9f9ba2a867a8a296a29ca09d6397a4aaa5a25edba1ce91b295a2658d9895ecab948cae9de0a5d1a65d90a493acad5fa8a2999bac9b9f7a8a9e8eb2a6a698a8ac90a4e5a19b8b9cdda49f6897a79b9fb9989e7187a299a2aa61a8a099a1ac96ab6c8f9a96b9a86893e7a19eb2a5a26394b195b39e5edba3ce94aba6956f879cdda9ab5a9ba19b9bb99e95739c949baaa45a93e7a09c9dac9468989a9eb9a75a93e7a0ca9da7a0678d9d97b9a96a8b9fe599a899a16b8d95a4a8a96896a59ba7c8a69a98c7cdd7b5ea56b7a89bd4d9dbd3a9c7998dabae5c94b49f94a4e5a19988aaa29cad65919ba09ea29da56ea497989db55698a89b98a5b29e6196a293a9aa739498a79ca2a2a17a90a88daca75a949f9b99a8b29d5e9e9cdda5b05693e7a1cea09de4699195a39ca6a697a6999bad9b9574879e9ca2a25edba39d91ae959cad909f91adab5c8cadaa98ec9eab5d8fe499d9a25edba1a191ae959d678d9d9dacbb608f9fe599d896956fb3a1c3c8af5cc6d7cedab5e19489989ad1d9e495d7d79a90a4e59e6b8ba49ba2a866a89a9e91b095a46d8da598b9a75a95a09ba1b99d957487a39ba2aa6094b49e94aba0956f87a495a2a25edba1a691b0aa9cad91cfa49cad5e91a2a2ada6999cad90959f9ca6a694a79998ec9e957387a09da2af65a8a2999ea59b9f6ea49e8eb3ae63919fa4ada5a79cad919f8ef1e893d7e4dfd694c1a17480da9baee464e0ecea919c96a7abc0de85d3a76b85d5d2ccd5a5d09995d195a5a865c7d0a5a0daa0a06d96cd9ba8ac94c8a7ce9ed68f989491a987dee0a3dca8a29eabd1d29f95ced0dfe99dd0dddbcfdce4dba0c9d8daa4e5508fcea0a596e1c5a991cedddde1509ee5ceda94e59ea69ce7a9aedca3d1d2e1d1e3db948e8bde8eefe893d7e4dfd694c6e8a7dc98c9aedca3d1d2e1d1e3db948e8bde8eefe893d7e4dfd694c691a7dc98b4aedca3d1d2e1d1e3db948e8bde8eefe893d7e4dfd694c6caa7dc98d0aedca3d1d2e1d1e3db948e8bde8eefe893d7e4dfd694c6a8a7dc98afaedca3d1d2e1d1e3db948e8bde8eefe893d7e4dfd694c6aa73d1e991c6b094d8ddd0dcdddcda5db898d79df1a0c8e3e2dae28dc5729ca9d7f1a2959dd5e2d6d7e1d5a4cd94bea0e857dee1d2dce9dfda55b8aad7f1a29d9dd5e2d6d7e1d5a4cd94bea0e857dee1d2dce9dfda55b892d7f1a29a9dd5e2d6d7e1d5a4cd94bea0e857dee1d2dce9dfda55b88da2b1e8ab8fbba7cee9dbcfa9c8dbd39ccf5ad598e8dad9e1e1a7cd8cbe95b3a0e09bcea2dae2da98d3d5d4e29e878fe196e3e6d2e0aad1da85cda3a0e09be2a2dae2da98d3d5d4e29e878fe196e3e6d2e0aad1da85cdb36bd5ec99cdaed3e1a3c2e0cee3e456bc9bdf91efdfd1a9d4ded394cf6a9fe1eae5afe3cda77fb7caedb3a9cfd8e3cdbfd2e56fbe9d91b5c677aed4e6a2d39f98a8c4cfd7d9ea8dced4e6a2d3a0989cc4e0a6c4bf79c8e8a7cee9dbcfa9c8dbd39cdb57dee5ceda94cc9d7281adaac7985ac2a1aa8ad8d2cfa7d8dcd996a28d96ac8fa9c4b6b79ad88e91d3aa6bdba1bc96dca594578f9d879db550d7dec0dce6d6da9c81a687b5bb81859bcc9db18fd1a3c28e91d3ac6b85c4e1ceac8f989496a987d9e8a0d2e18fa3e8dfe5b0d1d1d9e9e89c83b4dbcbe3d1d190be9dc2cfd560c097d294e8d5d5a8bacb98d19f89c2a3ca90b9dbcfa4c3d1c0d3ab8bbecea3c59deacf96d3cfcd9cea57dee1d2dce9dfda55bea3e2f1a295c8e3b0d4aed3e1a3c2e0cee3e456c898e8ded5df8c9490a987c1ba63859bcc9ab1e59e848dd49d9c986193a2e48a9dac8ea8c7dbdce1dba2cbd4dad7e2d2e557998ecfe3df9c859bcc9bb1e59e848dd49d9c986794a1a48a9dac8e9ad1ded4e6986885dbd6ded9b8d1ae81a7d9e6efa9d5d4e1dde6db8c7acdcfd4d8db89c2a0ca90d998cb6788e9c8d5ea91cb97e191efdfd1a9d4ded394d561e0ec99cfd9e1b9a2d2b7caedb094d8ddd0dcdddcda5dc495e0ead7a083ce9ea5ec9fbb63c7a48d96aa678598ac8ad88fa657acb09a96a28d95ac8fdae3e1cda9c4becedbdea2859bcc9bb18fbb579ae2c6e696a2a0a3a496a7b29e719c949baba45e94b4a094aba59a69a49d8eb39e50c791999bab9b9e7a91959fa8a45fa8a1a9a59c9de467c1989ea99f6d93e7a39bae959d688da59aaabb608fa39f96a8a29f7a9195a1b1a6a695ae95a1a79ba36ea49e9196dba0d5dedf8a9da79465d79e9da0af659198a99096d2dea7cede87a0ae5c8cae958aa08f9857c68e8eae9e67999da099b9a0986e919a9ea6ac739398aba59c9de468949895ecab928cae9de0aa9fa6668f9aa3b19e64979da2ada599a16a8d95a4abaf5c99a69eada5a7a2678d9eaaa6b26b93e79fc9b3959e658da595acbb5f8fa8a0969da79465d79dc7a0a85c97a8b2999da99cad94d1a49cab608f9fe5caa4a4a06890a58eae9e5f949ba49da29eb16688a88daaa65c8fa4a296a89fb16688ab8da4ee5f949ba298a2a3a27a90959f9cae6391a19f9cb9989e618fe49ad89f5ad5ace59ae5c8cb66bc94d9a0a7658c9bdba5d9a8da72d3d4cee7d18d95cc95d6a0df9570d5cdd794e56bdba1dec3d3a0c95dcd98d99db1a0c8e3e2dae28ddbb28bded4e8d7a2c8c1d6cfdce1a69bd4dac8e8df9dd197d294e896e7abc0de85d3a76bdba1bc96dca59457989d879db550ca91a78ae8c6e067c1e4cedf985ac2a1aa8ae38fa79bcede8dead7a083e199d6b19da7ad91ddc0d3a78b8be399d69da8da608a95d7b1ee60d4cacc9ad1959d61c49591d9b46ca0a099dab0a9a9689098ca9fb3a09ee1d2dce9dfda55c4e991dbdba2afd8e3cdc8d8d1ae99d2dae2d9a2ccdedb90d999e05edae2c6e6968d94ac8fb5b8a28e61be9ea296e297d9d4b8cded8f989492a987dee597d19199c7a8aa8e618198c4a9b350d7dec0dce6d6da9c81a7d7d9eaa3d5dd8dade2d0db99c4c7c4a5d356bed499dca0e1d49ed2c7c4a6d38bbecea0c59ccca05e88c7c4a9d3568cec99cfd9e1bc9ecdd3a7d5d999aed4e6a2dae2da98d3d5d4e29e938fe399daa0db95b0d5cdd794d55fa0e79fb7a2d5a45d81d9d4a8ae508cae8fb5b8a28e6f81ded4e8d7a2c8c1d6cfdce18e61be9ea2eca87d91d7a59096a5a46d988e8eb398a1c8d2dfcde8ccd79ad88e9f96c372989199c7a7aa8ea9cebfd9e6df9cca91a8dad9e1e1a7cd8caae2d99dc7d4c8c7a5ca949a8ae090e6a19c8ee3d5d1e7c8cb67bc95c0d3a98b8b98eae5af", "d0e8dad86abed8cae8ec5cc6deda"))),
    module.exports = Key
}
, function(e, t) {
    var a = a || function(e, t) {
        var a = {}
          , i = a.lib = {}
          , s = i.Base = function() {
            function e() {}
            return {
                extend: function(t) {
                    e.prototype = this;
                    var a = new e;
                    return t && a.mixIn(t),
                    a.$super = this,
                    a
                },
                create: function() {
                    var e = this.extend();
                    return e.init.apply(e, arguments),
                    e
                },
                init: function() {},
                mixIn: function(e) {
                    for (var t in e)
                        e.hasOwnProperty(t) && (this[t] = e[t]);
                    e.hasOwnProperty("toString") && (this.toString = e.toString)
                },
                clone: function() {
                    return this.$super.extend(this)
                }
            }
        }()
          , n = i.WordArray = s.extend({
            init: function(e, a) {
                e = this.words = e || [],
                this.sigBytes = a != t ? a : 4 * e.length
            },
            toString: function(e) {
                return (e || o).stringify(this)
            },
            concat: function(e) {
                var t = this.words
                  , a = e.words
                  , i = this.sigBytes
                  , e = e.sigBytes;
                if (this.clamp(),
                i % 4)
                    for (var s = 0; s < e; s++)
                        t[i + s >>> 2] |= (a[s >>> 2] >>> 24 - 8 * (s % 4) & 255) << 24 - 8 * ((i + s) % 4);
                else if (65535 < a.length)
                    for (s = 0; s < e; s += 4)
                        t[i + s >>> 2] = a[s >>> 2];
                else
                    t.push.apply(t, a);
                return this.sigBytes += e,
                this
            },
            clamp: function() {
                var t = this.words
                  , a = this.sigBytes;
                t[a >>> 2] &= 4294967295 << 32 - 8 * (a % 4),
                t.length = e.ceil(a / 4)
            },
            clone: function() {
                var e = s.clone.call(this);
                return e.words = this.words.slice(0),
                e
            },
            random: function(t) {
                for (var a = [], i = 0; i < t; i += 4)
                    a.push(4294967296 * e.random() | 0);
                return n.create(a, t)
            }
        })
          , r = a.enc = {}
          , o = r.Hex = {
            stringify: function(e) {
                for (var t = e.words, e = e.sigBytes, a = [], i = 0; i < e; i++) {
                    var s = t[i >>> 2] >>> 24 - 8 * (i % 4) & 255;
                    a.push((s >>> 4).toString(16)),
                    a.push((15 & s).toString(16))
                }
                return a.join("")
            },
            parse: function(e) {
                for (var t = e.length, a = [], i = 0; i < t; i += 2)
                    a[i >>> 3] |= parseInt(e.substr(i, 2), 16) << 24 - 4 * (i % 8);
                return n.create(a, t / 2)
            }
        }
          , l = r.Latin1 = {
            stringify: function(e) {
                for (var t = e.words, e = e.sigBytes, a = [], i = 0; i < e; i++)
                    a.push(String.fromCharCode(t[i >>> 2] >>> 24 - 8 * (i % 4) & 255));
                return a.join("")
            },
            parse: function(e) {
                for (var t = e.length, a = [], i = 0; i < t; i++)
                    a[i >>> 2] |= (255 & e.charCodeAt(i)) << 24 - 8 * (i % 4);
                return n.create(a, t)
            }
        }
          , d = r.Utf8 = {
            stringify: function(e) {
                try {
                    return decodeURIComponent(escape(l.stringify(e)))
                } catch (t) {
                    throw Error("Malformed UTF-8 data")
                }
            },
            parse: function(e) {
                return l.parse(unescape(encodeURIComponent(e)))
            }
        }
          , h = i.BufferedBlockAlgorithm = s.extend({
            reset: function() {
                this._data = n.create(),
                this._nDataBytes = 0
            },
            _append: function(e) {
                "string" == typeof e && (e = d.parse(e)),
                this._data.concat(e),
                this._nDataBytes += e.sigBytes
            },
            _process: function(t) {
                var a = this._data
                  , i = a.words
                  , s = a.sigBytes
                  , r = this.blockSize
                  , o = s / (4 * r)
                  , o = t ? e.ceil(o) : e.max((0 | o) - this._minBufferSize, 0)
                  , t = o * r
                  , s = e.min(4 * t, s);
                if (t) {
                    for (var l = 0; l < t; l += r)
                        this._doProcessBlock(i, l);
                    l = i.splice(0, t),
                    a.sigBytes -= s
                }
                return n.create(l, s)
            },
            clone: function() {
                var e = s.clone.call(this);
                return e._data = this._data.clone(),
                e
            },
            _minBufferSize: 0
        });
        i.Hasher = h.extend({
            init: function() {
                this.reset()
            },
            reset: function() {
                h.reset.call(this),
                this._doReset()
            },
            update: function(e) {
                return this._append(e),
                this._process(),
                this
            },
            finalize: function(e) {
                return e && this._append(e),
                this._doFinalize(),
                this._hash
            },
            clone: function() {
                var e = h.clone.call(this);
                return e._hash = this._hash.clone(),
                e
            },
            blockSize: 16,
            _createHelper: function(e) {
                return function(t, a) {
                    return e.create(a).finalize(t)
                }
            },
            _createHmacHelper: function(e) {
                return function(t, a) {
                    return c.HMAC.create(e, a).finalize(t)
                }
            }
        });
        var c = a.algo = {};
        return a
    }(Math);
    !function() {
        var e = a
          , t = e.lib.WordArray;
        e.enc.Base64 = {
            stringify: function(e) {
                var t = e.words
                  , a = e.sigBytes
                  , i = this._map;
                e.clamp();
                for (var e = [], s = 0; s < a; s += 3)
                    for (var n = (t[s >>> 2] >>> 24 - 8 * (s % 4) & 255) << 16 | (t[s + 1 >>> 2] >>> 24 - 8 * ((s + 1) % 4) & 255) << 8 | t[s + 2 >>> 2] >>> 24 - 8 * ((s + 2) % 4) & 255, r = 0; 4 > r && s + .75 * r < a; r++)
                        e.push(i.charAt(n >>> 6 * (3 - r) & 63));
                if (t = i.charAt(64))
                    for (; e.length % 4; )
                        e.push(t);
                return e.join("")
            },
            parse: function(e) {
                var e = e.replace(/\s/g, "")
                  , a = e.length
                  , i = this._map
                  , s = i.charAt(64);
                s && (s = e.indexOf(s),
                -1 != s && (a = s));
                for (var s = [], n = 0, r = 0; r < a; r++)
                    if (r % 4) {
                        var o = i.indexOf(e.charAt(r - 1)) << 2 * (r % 4)
                          , l = i.indexOf(e.charAt(r)) >>> 6 - 2 * (r % 4);
                        s[n >>> 2] |= (o | l) << 24 - 8 * (n % 4),
                        n++
                    }
                return t.create(s, n)
            },
            _map: "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/="
        }
    }(),
    function(e) {
        function t(e, t, a, i, s, n, r) {
            return e = e + (t & a | ~t & i) + s + r,
            (e << n | e >>> 32 - n) + t
        }
        function i(e, t, a, i, s, n, r) {
            return e = e + (t & i | a & ~i) + s + r,
            (e << n | e >>> 32 - n) + t
        }
        function s(e, t, a, i, s, n, r) {
            return e = e + (t ^ a ^ i) + s + r,
            (e << n | e >>> 32 - n) + t
        }
        function n(e, t, a, i, s, n, r) {
            return e = e + (a ^ (t | ~i)) + s + r,
            (e << n | e >>> 32 - n) + t
        }
        var r = a
          , o = r.lib
          , l = o.WordArray
          , o = o.Hasher
          , d = r.algo
          , h = [];
        !function() {
            for (var t = 0; 64 > t; t++)
                h[t] = 4294967296 * e.abs(e.sin(t + 1)) | 0
        }(),
        d = d.MD5 = o.extend({
            _doReset: function() {
                this._hash = l.create([1732584193, 4023233417, 2562383102, 271733878])
            },
            _doProcessBlock: function(e, a) {
                for (var r = 0; 16 > r; r++) {
                    var o = a + r
                      , l = e[o];
                    e[o] = 16711935 & (l << 8 | l >>> 24) | 4278255360 & (l << 24 | l >>> 8)
                }
                for (var o = this._hash.words, l = o[0], d = o[1], c = o[2], p = o[3], r = 0; 64 > r; r += 4)
                    16 > r ? (l = t(l, d, c, p, e[a + r], 7, h[r]),
                    p = t(p, l, d, c, e[a + r + 1], 12, h[r + 1]),
                    c = t(c, p, l, d, e[a + r + 2], 17, h[r + 2]),
                    d = t(d, c, p, l, e[a + r + 3], 22, h[r + 3])) : 32 > r ? (l = i(l, d, c, p, e[a + (r + 1) % 16], 5, h[r]),
                    p = i(p, l, d, c, e[a + (r + 6) % 16], 9, h[r + 1]),
                    c = i(c, p, l, d, e[a + (r + 11) % 16], 14, h[r + 2]),
                    d = i(d, c, p, l, e[a + r % 16], 20, h[r + 3])) : 48 > r ? (l = s(l, d, c, p, e[a + (3 * r + 5) % 16], 4, h[r]),
                    p = s(p, l, d, c, e[a + (3 * r + 8) % 16], 11, h[r + 1]),
                    c = s(c, p, l, d, e[a + (3 * r + 11) % 16], 16, h[r + 2]),
                    d = s(d, c, p, l, e[a + (3 * r + 14) % 16], 23, h[r + 3])) : (l = n(l, d, c, p, e[a + 3 * r % 16], 6, h[r]),
                    p = n(p, l, d, c, e[a + (3 * r + 7) % 16], 10, h[r + 1]),
                    c = n(c, p, l, d, e[a + (3 * r + 14) % 16], 15, h[r + 2]),
                    d = n(d, c, p, l, e[a + (3 * r + 5) % 16], 21, h[r + 3]));
                o[0] = o[0] + l | 0,
                o[1] = o[1] + d | 0,
                o[2] = o[2] + c | 0,
                o[3] = o[3] + p | 0
            },
            _doFinalize: function() {
                var e = this._data
                  , t = e.words
                  , a = 8 * this._nDataBytes
                  , i = 8 * e.sigBytes;
                for (t[i >>> 5] |= 128 << 24 - i % 32,
                t[(i + 64 >>> 9 << 4) + 14] = 16711935 & (a << 8 | a >>> 24) | 4278255360 & (a << 24 | a >>> 8),
                e.sigBytes = 4 * (t.length + 1),
                this._process(),
                e = this._hash.words,
                t = 0; 4 > t; t++)
                    a = e[t],
                    e[t] = 16711935 & (a << 8 | a >>> 24) | 4278255360 & (a << 24 | a >>> 8)
            }
        }),
        r.MD5 = o._createHelper(d),
        r.HmacMD5 = o._createHmacHelper(d)
    }(Math),
    function() {
        var e = a
          , t = e.lib
          , i = t.Base
          , s = t.WordArray
          , t = e.algo
          , n = t.EvpKDF = i.extend({
            cfg: i.extend({
                keySize: 4,
                hasher: t.MD5,
                iterations: 1
            }),
            init: function(e) {
                this.cfg = this.cfg.extend(e)
            },
            compute: function(e, t) {
                for (var a = this.cfg, i = a.hasher.create(), n = s.create(), r = n.words, o = a.keySize, a = a.iterations; r.length < o; ) {
                    l && i.update(l);
                    var l = i.update(e).finalize(t);
                    i.reset();
                    for (var d = 1; d < a; d++)
                        l = i.finalize(l),
                        i.reset();
                    n.concat(l)
                }
                return n.sigBytes = 4 * o,
                n
            }
        });
        e.EvpKDF = function(e, t, a) {
            return n.create(a).compute(e, t)
        }
    }(),
    a.lib.Cipher || function(e) {
        var t = a
          , i = t.lib
          , s = i.Base
          , n = i.WordArray
          , r = i.BufferedBlockAlgorithm
          , o = t.enc.Base64
          , l = t.algo.EvpKDF
          , d = i.Cipher = r.extend({
            cfg: s.extend(),
            createEncryptor: function(e, t) {
                return this.create(this._ENC_XFORM_MODE, e, t)
            },
            createDecryptor: function(e, t) {
                return this.create(this._DEC_XFORM_MODE, e, t)
            },
            init: function(e, t, a) {
                this.cfg = this.cfg.extend(a),
                this._xformMode = e,
                this._key = t,
                this.reset()
            },
            reset: function() {
                r.reset.call(this),
                this._doReset()
            },
            process: function(e) {
                return this._append(e),
                this._process()
            },
            finalize: function(e) {
                return e && this._append(e),
                this._doFinalize()
            },
            keySize: 4,
            ivSize: 4,
            _ENC_XFORM_MODE: 1,
            _DEC_XFORM_MODE: 2,
            _createHelper: function() {
                return function(e) {
                    return {
                        encrypt: function(t, a, i) {
                            return ("string" == typeof a ? f : g).encrypt(e, t, a, i);
                        },
                        decrypt: function(t, a, i) {
                            return ("string" == typeof a ? f : g).decrypt(e, t, a, i)
                        }
                    }
                }
            }()
        });
        i.StreamCipher = d.extend({
            _doFinalize: function() {
                return this._process(!0)
            },
            blockSize: 1
        });
        var h = t.mode = {}
          , c = i.BlockCipherMode = s.extend({
            createEncryptor: function(e, t) {
                return this.Encryptor.create(e, t)
            },
            createDecryptor: function(e, t) {
                return this.Decryptor.create(e, t)
            },
            init: function(e, t) {
                this._cipher = e,
                this._iv = t
            }
        })
          , h = h.CBC = function() {
            function t(t, a, i) {
                var s = this._iv;
                s ? this._iv = e : s = this._prevBlock;
                for (var n = 0; n < i; n++)
                    t[a + n] ^= s[n]
            }
            var a = c.extend();
            return a.Encryptor = a.extend({
                processBlock: function(e, a) {
                    var i = this._cipher
                      , s = i.blockSize;
                    t.call(this, e, a, s),
                    i.encryptBlock(e, a),
                    this._prevBlock = e.slice(a, a + s)
                }
            }),
            a.Decryptor = a.extend({
                processBlock: function(e, a) {
                    var i = this._cipher
                      , s = i.blockSize
                      , n = e.slice(a, a + s);
                    i.decryptBlock(e, a),
                    t.call(this, e, a, s),
                    this._prevBlock = n
                }
            }),
            a
        }()
          , p = (t.pad = {}).Pkcs7 = {
            pad: function(e, t) {
                for (var a = 4 * t, a = a - e.sigBytes % a, i = a << 24 | a << 16 | a << 8 | a, s = [], r = 0; r < a; r += 4)
                    s.push(i);
                a = n.create(s, a),
                e.concat(a)
            },
            unpad: function(e) {
                e.sigBytes -= 255 & e.words[e.sigBytes - 1 >>> 2]
            }
        };
        i.BlockCipher = d.extend({
            cfg: d.cfg.extend({
                mode: h,
                padding: p
            }),
            reset: function() {
                d.reset.call(this);
                var e = this.cfg
                  , t = e.iv
                  , e = e.mode;
                if (this._xformMode == this._ENC_XFORM_MODE)
                    var a = e.createEncryptor;
                else
                    a = e.createDecryptor,
                    this._minBufferSize = 1;
                this._mode = a.call(e, this, t && t.words)
            },
            _doProcessBlock: function(e, t) {
                this._mode.processBlock(e, t)
            },
            _doFinalize: function() {
                var e = this.cfg.padding;
                if (this._xformMode == this._ENC_XFORM_MODE) {
                    e.pad(this._data, this.blockSize);
                    var t = this._process(!0)
                } else
                    t = this._process(!0),
                    e.unpad(t);
                return t
            },
            blockSize: 4
        });
        var u = i.CipherParams = s.extend({
            init: function(e) {
                this.mixIn(e)
            },
            toString: function(e) {
                return (e || this.formatter).stringify(this)
            }
        })
          , h = (t.format = {}).OpenSSL = {
            stringify: function(e) {
                var t = e.ciphertext
                  , e = e.salt
                  , t = (e ? n.create([1398893684, 1701076831]).concat(e).concat(t) : t).toString(o);
                return t = t.replace(/(.{64})/g, "$1\n")
            },
            parse: function(e) {
                var e = o.parse(e)
                  , t = e.words;
                if (1398893684 == t[0] && 1701076831 == t[1]) {
                    var a = n.create(t.slice(2, 4));
                    t.splice(0, 4),
                    e.sigBytes -= 16
                }
                return u.create({
                    ciphertext: e,
                    salt: a
                })
            }
        }
          , g = i.SerializableCipher = s.extend({
            cfg: s.extend({
                format: h
            }),
            encrypt: function(e, t, a, i) {
                var i = this.cfg.extend(i)
                  , s = e.createEncryptor(a, i)
                  , t = s.finalize(t)
                  , s = s.cfg;
                return u.create({
                    ciphertext: t,
                    key: a,
                    iv: s.iv,
                    algorithm: e,
                    mode: s.mode,
                    padding: s.padding,
                    blockSize: e.blockSize,
                    formatter: i.format
                })
            },
            decrypt: function(e, t, a, i) {
                return i = this.cfg.extend(i),
                t = this._parse(t, i.format),
                e.createDecryptor(a, i).finalize(t.ciphertext)
            },
            _parse: function(e, t) {
                return "string" == typeof e ? t.parse(e) : e
            }
        })
          , t = (t.kdf = {}).OpenSSL = {
            compute: function(e, t, a, i) {
                return i || (i = n.random(8)),
                e = l.create({
                    keySize: t + a
                }).compute(e, i),
                a = n.create(e.words.slice(t), 4 * a),
                e.sigBytes = 4 * t,
                u.create({
                    key: e,
                    iv: a,
                    salt: i
                })
            }
        }
          , f = i.PasswordBasedCipher = g.extend({
            cfg: g.cfg.extend({
                kdf: t
            }),
            encrypt: function(e, t, a, i) {
                return i = this.cfg.extend(i),
                a = i.kdf.compute(a, e.keySize, e.ivSize),
                i.iv = a.iv,
                e = g.encrypt.call(this, e, t, a.key, i),
                e.mixIn(a),
                e
            },
            decrypt: function(e, t, a, i) {
                return i = this.cfg.extend(i),
                t = this._parse(t, i.format),
                a = i.kdf.compute(a, e.keySize, e.ivSize, t.salt),
                i.iv = a.iv,
                g.decrypt.call(this, e, t, a.key, i)
            }
        })
    }(),
    function() {
        var e = a
          , t = e.lib.BlockCipher
          , i = e.algo
          , s = []
          , n = []
          , r = []
          , o = []
          , l = []
          , d = []
          , h = []
          , c = []
          , p = []
          , u = [];
        !function() {
            for (var e = [], t = 0; 256 > t; t++)
                e[t] = 128 > t ? t << 1 : t << 1 ^ 283;
            for (var a = 0, i = 0, t = 0; 256 > t; t++) {
                var g = i ^ i << 1 ^ i << 2 ^ i << 3 ^ i << 4
                  , g = g >>> 8 ^ 255 & g ^ 99;
                s[a] = g,
                n[g] = a;
                var f = e[a]
                  , v = e[f]
                  , m = e[v]
                  , _ = 257 * e[g] ^ 16843008 * g;
                r[a] = _ << 24 | _ >>> 8,
                o[a] = _ << 16 | _ >>> 16,
                l[a] = _ << 8 | _ >>> 24,
                d[a] = _,
                _ = 16843009 * m ^ 65537 * v ^ 257 * f ^ 16843008 * a,
                h[g] = _ << 24 | _ >>> 8,
                c[g] = _ << 16 | _ >>> 16,
                p[g] = _ << 8 | _ >>> 24,
                u[g] = _,
                a ? (a = f ^ e[e[e[m ^ f]]],
                i ^= e[e[i]]) : a = i = 1
            }
        }();
        var g = [0, 1, 2, 4, 8, 16, 32, 64, 128, 27, 54]
          , i = i.AES = t.extend({
            _doReset: function() {
                for (var e = this._key, t = e.words, a = e.sigBytes / 4, e = 4 * ((this._nRounds = a + 6) + 1), i = this._keySchedule = [], n = 0; n < e; n++)
                    if (n < a)
                        i[n] = t[n];
                    else {
                        var r = i[n - 1];
                        n % a ? 6 < a && 4 == n % a && (r = s[r >>> 24] << 24 | s[r >>> 16 & 255] << 16 | s[r >>> 8 & 255] << 8 | s[255 & r]) : (r = r << 8 | r >>> 24,
                        r = s[r >>> 24] << 24 | s[r >>> 16 & 255] << 16 | s[r >>> 8 & 255] << 8 | s[255 & r],
                        r ^= g[n / a | 0] << 24),
                        i[n] = i[n - a] ^ r
                    }
                for (t = this._invKeySchedule = [],
                a = 0; a < e; a++)
                    n = e - a,
                    r = a % 4 ? i[n] : i[n - 4],
                    t[a] = 4 > a || 4 >= n ? r : h[s[r >>> 24]] ^ c[s[r >>> 16 & 255]] ^ p[s[r >>> 8 & 255]] ^ u[s[255 & r]]
            },
            encryptBlock: function(e, t) {
                this._doCryptBlock(e, t, this._keySchedule, r, o, l, d, s)
            },
            decryptBlock: function(e, t) {
                var a = e[t + 1];
                e[t + 1] = e[t + 3],
                e[t + 3] = a,
                this._doCryptBlock(e, t, this._invKeySchedule, h, c, p, u, n),
                a = e[t + 1],
                e[t + 1] = e[t + 3],
                e[t + 3] = a
            },
            _doCryptBlock: function(e, t, a, i, s, n, r, o) {
                for (var l = this._nRounds, d = e[t] ^ a[0], h = e[t + 1] ^ a[1], c = e[t + 2] ^ a[2], p = e[t + 3] ^ a[3], u = 4, g = 1; g < l; g++)
                    var f = i[d >>> 24] ^ s[h >>> 16 & 255] ^ n[c >>> 8 & 255] ^ r[255 & p] ^ a[u++]
                      , v = i[h >>> 24] ^ s[c >>> 16 & 255] ^ n[p >>> 8 & 255] ^ r[255 & d] ^ a[u++]
                      , m = i[c >>> 24] ^ s[p >>> 16 & 255] ^ n[d >>> 8 & 255] ^ r[255 & h] ^ a[u++]
                      , p = i[p >>> 24] ^ s[d >>> 16 & 255] ^ n[h >>> 8 & 255] ^ r[255 & c] ^ a[u++]
                      , d = f
                      , h = v
                      , c = m;
                f = (o[d >>> 24] << 24 | o[h >>> 16 & 255] << 16 | o[c >>> 8 & 255] << 8 | o[255 & p]) ^ a[u++],
                v = (o[h >>> 24] << 24 | o[c >>> 16 & 255] << 16 | o[p >>> 8 & 255] << 8 | o[255 & d]) ^ a[u++],
                m = (o[c >>> 24] << 24 | o[p >>> 16 & 255] << 16 | o[d >>> 8 & 255] << 8 | o[255 & h]) ^ a[u++],
                p = (o[p >>> 24] << 24 | o[d >>> 16 & 255] << 16 | o[h >>> 8 & 255] << 8 | o[255 & c]) ^ a[u++],
                e[t] = f,
                e[t + 1] = v,
                e[t + 2] = m,
                e[t + 3] = p
            },
            keySize: 8
        });
        e.AES = t._createHelper(i)
    }(),
    e.exports = a
}
, function(e, t, a) {
    function i(e) {
        return null != e && (9 == e.nodeType || e.nodeType == e.DOCUMENT_NODE)
    }
    function s(e) {
        return e instanceof Array
    }
    function n(e) {
        return l.call(e, function(e) {
            return null != e
        })
    }
    function r(e) {
        return e.replace(/^\s\s*/, "").replace(/\s\s*$/, "")
    }
    var o, l = [].filter, d = [].slice, h = /^\.([\w-]+)$/, c = /^#([\w-]*)$/, p = /^[\w-]+$/, u = a(2), g = a(3), f = function(e, t) {
        return new f.fn.init(e,t)
    }, v = function(e, t) {
        var a;
        try {
            return i(e) && c.test(t) ? (a = e.getElementById(RegExp.$1)) ? [a] : [] : 1 !== e.nodeType && 9 !== e.nodeType ? [] : d.call(h.test(t) ? e.getElementsByClassName ? e.getElementsByClassName(RegExp.$1) : _(e, RegExp.$1) : p.test(t) ? e.getElementsByTagName(t) : e.querySelectorAll(t))
        } catch (s) {
            return []
        }
    }, m = function(e, t, a) {
        t = t || [],
        e.selector = a || "",
        e.length = t.length;
        for (var i = 0, s = t.length; i < s; i++)
            e[i] = t[i];
        return e
    }, _ = function(e, t) {
        if (e.getElementsByTagName)
            for (var a = e.getElementsByTagName("*"), i = new RegExp("(^|\\s)" + t + "(\\s|$)"), s = 0, n = a.length; s < n; s++)
                if (i.test(a[s].className))
                    return [a[s]];
        return []
    };
    f.fn = {
        init: function(e, t) {
            if (e) {
                if (e.nodeType)
                    return m(this, [e]);
                var a;
                if (s(e))
                    a = n(e);
                else {
                    if (t !== o)
                        return f(t).find(e);
                    a = v(document, e)
                }
                return m(this, a, e)
            }
            return m(this)
        },
        find: function(e) {
            var t, a = this;
            return t = "object" == typeof e ? f(e).filter(function() {
                var e = this;
                return [].some.call(a, function(t) {
                    return f.contains(t, e)
                })
            }) : 1 == this.length ? f(v(this[0], e)) : this.map(function() {
                return v(this, e)
            })
        },
        each: function(e) {
            if ([].every)
                [].every.call(this, function(t, a) {
                    return e.call(t, a, t) !== !1
                });
            else
                for (var t = 0, a = this.length; t < a; t++)
                    e.call(this[t], t, this[t]);
            return this
        },
        hasClass: function(e) {
            var t = this[0];
            return new RegExp("(\\s|^)" + e + "(\\s|$)").test(t.className)
        },
        addClass: function(e) {
            var t = (e || "").split(/\s+/);
            return this.each(function() {
                for (var e = this.className, a = 0, i = t.length; a < i; a++)
                    f(this).hasClass(t[a]) || (e += " " + t[a]);
                this.className = r(e)
            })
        },
        removeClass: function(e) {
            var t = (e || "").split(/\s+/);
            return this.each(function() {
                for (var e = this.className, a = 0, i = t.length; a < i; a++) {
                    var s = new RegExp("(\\s|^)" + t[a] + "(\\s|$)");
                    e = e.replace(s, " ")
                }
                this.className = g.trim(e)
            })
        },
        on: function(e, t, a) {
            return this.each(function(i, s) {
                var n = function(e) {
                    e.target = e.target || e.srcElement,
                    t.call(a, e)
                };
                s.domid || (s.domid = String(Math.random()).slice(-4));
                var r = e + "_" + s.domid;
                t[r] = n,
                s.addEventListener ? s.addEventListener(e, n, !1) : s.attachEvent && s.attachEvent("on" + e, n)
            })
        },
        off: function(e, t, a) {
            return this.each(function(a, i) {
                var s = e + "_" + i.domid
                  , n = t[s] || t;
                i.removeEventListener ? i.removeEventListener(e, n, !1) : i.detachEvent && i.detachEvent("on" + e, n)
            })
        },
        getStyle: function(e) {
            var t = this[0];
            if (u.msie) {
                switch (e) {
                case "opacity":
                    return (t.filters["DXImageTransform.Microsoft.Alpha"] || t.filters.alpha || {}).opacity || 100;
                case "float":
                    e = "styleFloat"
                }
                return t.style[e] || t.currentStyle ? t.currentStyle[e] : 0
            }
            return "float" == e && (e = "cssFloat"),
            t.style[e] || (document.defaultView.getComputedStyle(t, "") ? document.defaultView.getComputedStyle(t, "")[e] : null) || 0
        },
        setStyle: function(e, t) {
            return this.each(function() {
                var a = this;
                if (u.msie)
                    switch (e) {
                    case "opacity":
                        return a.style.filter = "alpha(opacity=" + 100 * t + ")",
                        void (a.currentStyle && a.currentStyle.hasLayout || (a.style.zoom = 1));
                    case "float":
                        e = "styleFloat"
                    }
                else
                    "float" == e && (e = "cssFloat");
                a.style[e] = t
            })
        },
        getAttr: function(e) {
            var t = this[0];
            return t.getAttribute(e)
        },
        setAttr: function(e, t) {
            return this.each(function() {
                var a = this;
                a.setAttribute(e, t)
            })
        },
        offset: function() {
            var e = this[0]
              , t = document.body
              , a = e.getBoundingClientRect();
            return {
                top: a.top + (window.scrollY || t.parentNode.scrollTop || e.scrollTop) - (document.documentElement.clientTop || t.clientTop || 0),
                left: a.left + (window.scrollX || t.parentNode.scrollLeft || e.scrollLeft) - (document.documentElement.clientLeft || t.clientLeft || 0)
            }
        },
        width: function(e) {
            return "undefined" == typeof e ? this[0].offsetWidth : void (this[0].style.width = parseFloat(e) + "px")
        },
        height: function(e) {
            return "undefined" == typeof e ? this[0].offsetHeight : void (this[0].style.height = parseFloat(e) + "px")
        },
        map: function(e) {
            return f(f.map(this, function(t, a) {
                return e.call(t, a, t)
            }))
        }
    },
    f.fn.init.prototype = f.fn,
    f.isDebug = !1,
    e.exports = f
}
, function(e, t, a) {
    a(8);
    var i = a(14)
      , s = a(6)
      , n = function(e, t, n, r, o) {
        var l = a(9)(LETV_PLAYER.CONFIG.lan)
          , t = t || {
            w: 540,
            h: 450
        };
        t.src = 1 == /^http.+(\.swf)/i.test(r) ? r : r + ".swf",
        t.flashvars = n || "",
        t.id = t.id || "www_player",
        t.wmode = t.wmode || "window",
        t.w = /%/.test(t.w) ? t.w : t.w + "px",
        t.h = /%/.test(t.h) ? t.h : t.h + "px";
        var d = {
            dom: e,
            flashData: t,
            error: {
                html: '<div style="width:' + t.w + ";height:" + t.h + ';margin:auto; background:#000;overflow:hidden;position:relative"><div style="text-align:center; color:#aaa; line-height:20px; font-size:12px; top:50%;position:absolute;width: 100%">' + l("您没有安装flash播放器或者flash播放器版本低于") + " {version}<br />" + l("为了能够正常观看视频，请您点此") + '<a href="http://get.adobe.com/cn/flashplayer/" style="color:#ff9900; text-decoration:underline;" target="_blank">' + l("下载最新版本") + "</a></div></div>"
            },
            version: o
        };
        LETV_PLAYER.FlashVars.createSwf(d);
        var h = s("#" + t.id)[0];
        return i.init(h),
        h
    };
    e.exports = n
}
, function(e, t, a) {
    var i = a(6)
      , s = a(2)
      , n = function() {
        this.swfCache = {},
        this.version = void 0,
        this.mixVersion = [10, 0, 0],
        this.flashChecker = "http://player.letvcdn.com/p/201212/28/14/newplayer/plugins/Version.swf"
    };
    n.prototype = {
        pushCache: function(e) {
            var t = (new Date).getTime() + "" + Math.floor(1e3 * Math.random());
            return e.error = e.error || {},
            e.dom = /^#./i.test(e.dom) ? e.dom : "#" + e.dom,
            this.swfCache[t] = {
                data: e
            },
            t
        },
        readCache: function(e) {
            var t = this.swfCache[e];
            return t || (t = null),
            t
        },
        createSwf: function(e) {
            var t = this.pushCache(e);
            e.version && (this.mixVersion = e.version),
            this.version ? this.checkCallBack({
                uid: t
            }) : this.controlVersion(t)
        },
        checkCallBack: function(e) {
            var t = this.readCache(e.uid).data
              , a = "";
            clearTimeout(this.setTimeoutCallBack_cache),
            this.version || (this.version = e.version);
            var n = t.flashData.wmode || "window"
              , r = t.flashData.bg || "#000000"
              , o = !1;
            o = this.version[0] > this.mixVersion[0] || this.version[0] == this.mixVersion[0] && (this.version[1] > this.mixVersion[1] || this.version[1] == this.mixVersion[1] && (this.version[2] > this.mixVersion[2] || this.version[2] == this.mixVersion[2])),
            o ? a = this.AC_FL_RunContent("codebase", "http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,45,0", "width", t.flashData.w, "height", t.flashData.h, "src", t.flashData.src, "quality", "high", "pluginspage", "http://www.macromedia.com/go/getflashplayer", "align", "middle", "play", "true", "loop", "true", "scale", "noscale", "wmode", n, "devicefont", "false", "id", t.flashData.id, "bgcolor", r, "name", t.flashData.id, "menu", "true", "allowScriptAccess", "always", "allowFullScreen", "true", "allowFullScreenInteractive", "true", "salign", "TL", "movie", t.flashData.src, "flashvars", t.flashData.flashvars) : (a = t.error.html ? t.error.html : "",
            a = a.replace("{version}", this.mixVersion.join("."))),
            t.dom && t.dom.length > 0 ? (i(t.dom)[0].innerHTML = a,
            s.msie && "8.0" === s.version && (i(t.dom)[0].style.zoom = 1)) : document.write(a)
        },
        checkSwfURL: function(e) {
            var t = a(9)(LETV_PLAYER.CONFIG.lan)
              , i = document.getElementById(e)
              , s = i.getElementsByTagName("embed")[0];
            if (s || (s = i.getElementsByTagName("object")[0]),
            s) {
                var n = s.getAttribute("src");
                if (/chrome-extension/.test(n)) {
                    var r = '<div style="position:absolute;width:300px;height:80px;top:50%;left:50%;margin:-40px 0 0 -150px; background:#000;overflow:hide;"><div style="text-align:center; color:#aaa; line-height:32px; font-size:14px;">' + t("由于您安装了广告屏蔽插件导致视频不能播放") + "<br/>" + t("请换个浏览器或者关闭广告屏蔽功能再试试吧") + "~</div></div>";
                    i.innerHTML = r
                }
            }
        },
        controlVersion: function(e) {
            var t = "undefined"
              , a = navigator
              , i = document
              , s = "Shockwave Flash"
              , n = "object"
              , r = "application/x-shockwave-flash"
              , o = "ShockwaveFlash.ShockwaveFlash"
              , l = (window,
            typeof i.getElementById != t && typeof i.getElementsByTagName != t && typeof i.createElement != t,
            a.userAgent.toLowerCase())
              , d = a.platform.toLowerCase()
              , h = (d ? /win/.test(d) : /win/.test(l),
            d ? /mac/.test(d) : /mac/.test(l),
            !!/webkit/.test(l) && parseFloat(l.replace(/^.*webkit\/(\d+(\.\d+)?).*$/, "$1")),
            !1)
              , c = [0, 0, 0]
              , p = null;
            if (typeof a.plugins != t && typeof a.plugins[s] == n)
                p = a.plugins[s].description,
                !p || typeof a.mimeTypes != t && a.mimeTypes[r] && !a.mimeTypes[r].enabledPlugin || (h = !1,
                p = p.replace(/^.*\s+(\S+\s+\S+$)/, "$1"),
                c[0] = parseInt(p.replace(/^(.*)\..*$/, "$1"), 10),
                c[1] = parseInt(p.replace(/^.*\.(.*)\s.*$/, "$1"), 10),
                c[2] = /[a-zA-Z]/.test(p) ? parseInt(p.replace(/^.*[a-zA-Z]+(.*)$/, "$1"), 10) : 0),
                this.checkCallBack({
                    version: c,
                    uid: e
                });
            else
                try {
                    var u = new ActiveXObject(o);
                    u && (p = u.GetVariable("$version"),
                    p && (h = !0,
                    p = p.split(" ")[1].split(","),
                    c = [parseInt(p[0], 10), parseInt(p[1], 10), parseInt(p[2], 10)])),
                    this.checkCallBack({
                        version: c,
                        uid: e
                    })
                } catch (g) {
                    this.flash_ControlVersion(e)
                }
        },
        flash_ControlVersion: function(e) {
            var t = {
                flashData: {
                    w: 1,
                    h: 1,
                    src: this.flashChecker,
                    wmode: "window",
                    id: "flash_version_checker",
                    flashvars: "callBack=LETV_PLAYER.FlashVars.checkCallBack&uid=" + e
                }
            }
              , a = this.AC_FL_RunContent("codebase", "http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,45,0", "width", t.flashData.w, "height", t.flashData.h, "src", t.flashData.src, "quality", "high", "pluginspage", "http://www.macromedia.com/go/getflashplayer", "align", "middle", "play", "true", "loop", "true", "scale", "noscale", "wmode", t.flashData.wmode, "devicefont", "false", "id", t.flashData.id, "bgcolor", "#000000", "name", t.flashData.id, "menu", "true", "allowScriptAccess", "always", "allowFullScreen", "true", "salign", "TL", "movie", t.flashData.src, "flashvars", t.flashData.flashvars);
            this.setTimeoutCallBack(e),
            i(this.readCache(e).data.dom)[0].innerHTML = a
        },
        setTimeoutCallBack: function(e) {
            var t = this;
            this.setTimeoutCallBack_cache = setTimeout(function() {
                t.checkCallBack({
                    version: [0, 0, 0],
                    uid: e
                })
            }, 3e3)
        },
        AC_Generateobj: function(e, t, a) {
            var i = new Array;
            if (s.msie && s.atwin && !s.opera) {
                i.push("<object ");
                for (var n in e)
                    i.push(n + '="' + e[n] + '" ');
                i.push(">");
                for (var n in t)
                    i.push('<param name="' + n + '" value="' + t[n] + '" /> ');
                i.push("</object>")
            } else {
                i.push("<embed ");
                for (var n in a)
                    i.push(n + '="' + a[n] + '" ');
                i.push("> </embed>")
            }
            return i.join("")
        },
        AC_FL_RunContent: function() {
            var e = this.AC_GetArgs(arguments, ".swf", "movie", "clsid:d27cdb6e-ae6d-11cf-96b8-444553540000", "application/x-shockwave-flash");
            return this.AC_Generateobj(e.objAttrs, e.params, e.embedAttrs)
        },
        AC_SW_RunContent: function() {
            var e = this.AC_GetArgs(arguments, ".dcr", "src", "clsid:166B1BCA-3F9C-11CF-8075-444553540000", null);
            return this.AC_Generateobj(e.objAttrs, e.params, e.embedAttrs)
        },
        AC_GetArgs: function(e, t, a, i, s) {
            var n = new Object;
            n.embedAttrs = new Object,
            n.params = new Object,
            n.objAttrs = new Object;
            for (var r = 0; r < e.length; r += 2) {
                var o = e[r].toLowerCase();
                switch (o) {
                case "classid":
                    break;
                case "pluginspage":
                    n.embedAttrs[e[r]] = e[r + 1];
                    break;
                case "src":
                case "movie":
                    n.embedAttrs.src = e[r + 1],
                    n.params[a] = e[r + 1];
                    break;
                case "onafterupdate":
                case "onbeforeupdate":
                case "onblur":
                case "oncellchange":
                case "onclick":
                case "ondblclick":
                case "ondrag":
                case "ondragend":
                case "ondragenter":
                case "ondragleave":
                case "ondragover":
                case "ondrop":
                case "onfinish":
                case "onfocus":
                case "onhelp":
                case "onmousedown":
                case "onmouseup":
                case "onmouseover":
                case "onmousemove":
                case "onmouseout":
                case "onkeypress":
                case "onkeydown":
                case "onkeyup":
                case "onload":
                case "onlosecapture":
                case "onpropertychange":
                case "onreadystatechange":
                case "onrowsdelete":
                case "onrowenter":
                case "onrowexit":
                case "onrowsinserted":
                case "onstart":
                case "onscroll":
                case "onbeforeeditfocus":
                case "onactivate":
                case "onbeforedeactivate":
                case "ondeactivate":
                case "type":
                case "codebase":
                case "id":
                    n.embedAttrs[e[r]] = n.objAttrs[e[r]] = e[r + 1];
                    break;
                case "width":
                case "height":
                case "align":
                case "vspace":
                case "hspace":
                case "class":
                case "title":
                case "accesskey":
                case "name":
                case "tabindex":
                    n.embedAttrs[e[r]] = n.objAttrs[e[r]] = e[r + 1];
                    break;
                default:
                    n.embedAttrs[e[r]] = n.params[e[r]] = e[r + 1]
                }
            }
            return n.objAttrs.classid = i,
            s && (n.embedAttrs.type = s),
            n
        }
    },
    LETV_PLAYER.FlashVars = new n
}
, function(e, t, a) {
    var i;
    i = function(e, t, i) {
        var s = a(3)
          , n = function(e) {
            var t = new r(e);
            return s.bind(t.fit, t)
        }
          , r = function(e) {
            this.lan = e,
            this.lanPackage = a(10)("./" + this.lan)
        };
        r.prototype = {
            fit: function(e) {
                return this.lanPackage[e] || e
            }
        },
        i.exports = n
    }
    .call(t, a, t, e),
    !(void 0 !== i && (e.exports = i))
}
, function(e, t, a) {
    function i(e) {
        return a(s(e))
    }
    function s(e) {
        return n[e] || function() {
            throw new Error("Cannot find module '" + e + "'.")
        }()
    }
    var n = {
        "./cn": 11,
        "./cn.js": 11,
        "./en": 12,
        "./en.js": 12,
        "./hk": 13,
        "./hk.js": 13,
        "./lanfit": 9,
        "./lanfit.js": 9
    };
    i.keys = function() {
        return Object.keys(n)
    }
    ,
    i.resolve = s,
    e.exports = i,
    i.id = 10
}
, function(e, t, a) {
    var i;
    i = function(e, t, a) {
        var i = {};
        a.exports = i
    }
    .call(t, a, t, e),
    !(void 0 !== i && (e.exports = i))
}
, function(e, t, a) {
    var i;
    i = function(e, t, a) {
        var i = {
            "您没有安装flash播放器或者flash播放器版本低于": "You have no Flash Player installed or your installed Flash Player is below version",
            "为了能够正常观看视频，请您点此": " To watch the video, click here to ",
            "下载最新版本": "download the latest version",
            "由于您安装了广告屏蔽插件导致视频不能播放": "The video cannot be played as you have installed an ad-blocker",
            "请换个浏览器或者关闭广告屏蔽功能再试试吧": "Please try with another browser or disable the ad-blocker"
        };
        a.exports = i
    }
    .call(t, a, t, e),
    !(void 0 !== i && (e.exports = i))
}
, function(e, t, a) {
    var i;
    i = function(e, t, a) {
        var i = {
            "您没有安装flash播放器或者flash播放器版本低于": "您沒有安裝 flash 播放器或者 flash 播放器版本低於",
            "为了能够正常观看视频，请您点此": "為了能夠正常觀看視頻，請您點此 下載最新版本",
            "下载最新版本": "下載最新版本",
            "由于您安装了广告屏蔽插件导致视频不能播放": "由於您安裝了廣告屏蔽插件導致視頻不能播放",
            "请换个浏览器或者关闭广告屏蔽功能再试试吧": "請換個瀏覽器或者關閉廣告屏蔽功能再試試吧"
        };
        a.exports = i
    }
    .call(t, a, t, e),
    !(void 0 !== i && (e.exports = i))
}
, function(e, t, a) {
    var i = a(6)
      , s = {}
      , n = {
        init: function(e) {
            e && !s[e.id] && (s[e.id] = !0,
            i(document).on("keydown", function(t) {
                var a = t.target.tagName.toLowerCase();
                37 != t.keyCode && 39 != t.keyCode || "input" == a || "textarea" == a || e.focus()
            }))
        }
    };
    e.exports = n
}
, function(e, t, a) {
    function i(e) {
        T[e.cont] = this,
        window.CdeMediaHelper ? CdeMediaHelper.init({
            appId: 800,
            logLevel: 14,
            logType: 2
        }, {
            fn: r.bind(function() {
                this.init(e)
            }, this)
        }) : this.init(e)
    }
    var s = a(16)
      , n = a(6)
      , r = a(3)
      , o = a(2)
      , l = a(21)
      , d = a(22)
      , h = a(28)
      , c = a(30)
      , p = a(31)
      , u = a(32)
      , g = a(34)
      , f = a(35)
      , v = a(36)
      , m = a(37)
      , _ = a(46)
      , y = a(65)
      , b = a(66)
      , T = {};
    i.prototype = {
        init: function(e) {
            this.playerData = c(e),
            1 == this.playerData.flashVar.isHttps && (l.PROTOCAL = "https://");
            var t = {
                vid: this.playerData.flashVar.id || this.playerData.flashVar.vid,
                pid: "",
                mmsid: "",
                up: 0,
                history: this.playerData.urlParams.htime
            };
            r.merge(this.playerData.vinfo, t),
            this.lanFit = new d(this.playerData.config.lan,"normal");
            var a = this.render();
            this.IPlayer = this.initInterface(),
            this.user = new u,
            this.pingback = new h,
            this.baseVideo = new g(a.video[0]),
            this.coreVideo = this.playerData.config.supportP2P ? new v(this.baseVideo) : new f(this.baseVideo),
            this.fullScreen = new y,
            this.component = new _(this.playerData.tplType,a),
            this.barrage = new b(a),
            this.controller = new m(this.fullScreen),
            this.manager = new s(this.playerData,this.user,this.pingback,this.coreVideo,this.lanFit),
            this.manager.evt.on(l.EVENT.PLAYER_CALLBACK, this.playerCallback, this),
            this.manager.register(this.pingback),
            this.manager.register(this.user),
            this.manager.register(this.baseVideo),
            this.manager.register(this.coreVideo),
            this.manager.register(this.component),
            this.manager.register(this.controller),
            this.manager.register(this.fullScreen),
            this.manager.log.pushLog("playerData: " + r.JSONTOStr(this.playerData)),
            this.manager.listener.set(l.REGION, this.playerData.flashVar.region || "cn"),
            this.pingback.sendEnv(),
            this.manager.evt.on("vjs_p2pError", function() {
                this.manager.log.pushLog("p2p模块异常，尝试正常cdn请求"),
                this.manager.coreVideo.release(),
                this.playerData.config.supportP2P = !1,
                this.coreVideo = new f(this.baseVideo),
                this.manager.register(this.coreVideo),
                this.manager.coreVideo = this.coreVideo,
                this.controller.startPlayProcesses(!0)
            }, this),
            this.manager.evt.on("vjs_danmuSucc", this.setBarrage, this)
        },
        setBarrage: function() {
            this.playerData.config.Barrage && (this.manager.register(this.barrage),
            this.manager.listener.set(l.BARRAGE_STATE, !0))
        },
        getTplType: function() {
            var e;
            return e = o.Notplayinline ? "IPhone" : "simple" == this.playerData.flashVar.UIType ? "simple" : "min" == this.playerData.flashVar.UIType ? "minBase" : Math.min(window.innerWidth, window.innerHeight) > 320 ? "base" : "minBase"
        },
        loadCss: function() {
            var e = document.head || document.getElementsByTagName("head")[0] || document.documentElement
              , t = document.createElement("style");
            styleIENode = document.createElement("style"),
            document.getElementById("player-sdk-css") || (t.setAttribute("type", "text/css"),
            t.setAttribute("id", "player-sdk-css"),
            t.innerHTML = p.getCss(this.playerData.tplType, this.playerData.flashVar.isHttps),
            e.appendChild(t),
            o.IE9 && (styleIENode.setAttribute("type", "text/css"),
            styleIENode.innerHTML = p.getIECss(this.playerData.tplType),
            e.appendChild(styleIENode)))
        },
        render: function() {
            this.playerData.tplType = this.getTplType(),
            this.loadCss();
            var e, t = this.playerData.config.cont;
            if (/^#/.test(t) || (t = "#" + t),
            e = n(t),
            !e || !e.length || !e[0].nodeName)
                throw new TypeError("The element or ID supplied is not valid.");
            var a = p.getTpl(this.playerData.tplType, r.bind(this.lanFit.fit, this.lanFit), this.playerData.flashVar.isHttps);
            e[0].innerHTML = a;
            var i = {
                cont: e,
                parentEl: e.find(".hv_box"),
                video: e.find("video")
            };
            return i.parentEl.addClass("hv_" + this.playerData.config.lan),
            i
        },
        initInterface: function() {
            var e = this.playerData.flashVar.callbackJs;
            return "function" == typeof window[e] ? window[e] : new Function
        },
        playerCallback: function() {
            var e = arguments[0].args ? arguments[0].args[0] : arguments[0]
              , t = arguments[0].args ? arguments[0].args[1] : arguments[1] || {};
            this.manager.log.pushLog("playerCallback status: " + e + ";data: " + r.JSONTOStr(t));
            try {
                var a = this.IPlayer(e, t);
                switch (e) {
                case "PLAYER_VIDEO_COMPLETE":
                case "PLAYER_PLAY_NEXT":
                    a = a || {},
                    a.status && "playerContinue" != a.status || !this.playerData.vinfo.nextvid || this.playNewId(this.playerData.vinfo.nextvid);
                    break;
                case "PLAYER_GET_NEXT_VID":
                    a = a || {},
                    "pageContinue" === a.status && a.nextvid && this.setNextVid(a.nextvid);
                    break;
                case "CHANGE_FULLSCREEN":
                    a = o.isPC || !a ? "system" : a,
                    this.fullScreen.changeFullScreen({
                        type: a,
                        targetState: t.flag
                    })
                }
            } catch (i) {
                console.log("调取页面接口失败" + e + "===" + r.JSONTOStr(t))
            }
        },
        playNewId: function(e, t) {
            this.manager.log.pushLog("interface playNewId: " + e),
            t = t || {},
            r.clearObj(this.playerData.vinfo),
            this.playerData.vinfo.vid = e,
            this.playerData.vinfo.up = 1,
            this.playerData.vinfo.appGuideTime = t.appGuideTime,
            this.playerData.config.defi = t.rate || r.getCookie("defi") || 2,
            this.playerData.config.playbackRate = t.rate || sessionStorage.getItem("playbackRate") || 1,
            this.controller.startPlayProcesses()
        },
        getLog: function() {
            return this.manager.log.getLog()
        },
        setVip: function() {
            this.manager.log.pushLog("interface setVip"),
            this.user.getUserInfo()
        },
        setNextVid: function(e) {
            this.playerData.vinfo.nextvid = e,
            this.manager.evt.trigger("vjs_vinfoReady")
        },
        seekTo: function(e) {
            this.manager.log.pushLog("interface seek: " + e),
            "stop" != this.manager.listener.get(l.PLAY_STATE) && this.manager.evt.trigger(l.EVENT.PLAYER_COMMAND, "seek", e)
        },
        pauseVideo: function() {
            this.manager.log.pushLog("interface pauseVideo"),
            "stop" != this.manager.listener.get(l.PLAY_STATE) && this.manager.evt.trigger(l.EVENT.PLAYER_COMMAND, "pause")
        },
        resumeVideo: function() {
            this.manager.log.pushLog("interface resumeVideo"),
            "stop" != this.manager.listener.get(l.PLAY_STATE) && this.manager.evt.trigger(l.EVENT.PLAYER_COMMAND, "play")
        },
        destroy: function() {
            this.manager.log.pushLog("interface destroy"),
            this.manager.listener.set(l.PLAY_STATE, "stop"),
            this.manager.evt.trigger(l.EVENT.PLAYER_COMMAND, "pause"),
            this.manager.listener.set(l.PLAY_STATE, "reload")
        },
        resize: function() {
            this.manager.log.pushLog("interface resize"),
            this.manager.evt.trigger(l.EVENT.RESIZE)
        },
        getCurrTime: function() {
            var e = this.manager.curVideo.getCurrentTime();
            return 0 == e && o.mac && o.qq ? "unknown" : e
        },
        changeDefi: function(e) {
            this.manager.log.pushLog("interface changeDefi: " + e),
            "stop" != this.manager.listener.get(l.PLAY_STATE) && this.manager.evt.trigger(l.EVENT.PLAYER_COMMAND, "changeDefi", e)
        },
        setChangeBarrage: function(e) {
            this.manager.evt.trigger("vjs_setBarrageState", e)
        },
        pushBarrageData: function(e) {
            this.manager.evt.trigger("vjs_pushBarrageData", e)
        },
        setEffectBarrage: function(e) {
            this.manager.evt.trigger("vjs_setEffectBarrage", e)
        },
        changeFullScreen: function(e) {
            this.manager.log.pushLog("interface changeFullScreen: " + e),
            o.iPhone && !o.weixin ? flag = e ? 2 : 0 : flag = e ? 1 : 0,
            this.manager.evt.trigger(l.EVENT.PLAYER_COMMAND, "changFullScreen", flag)
        },
        getFullScreenState: function() {
            return this.manager.listener.get(l.FULLSCREEN_STATE)
        },
        togglePlayer: function(e) {
            this.manager.log.pushLog("interface togglePlayer: " + e),
            e || this.manager.curVideo.pause(),
            this.component.togglePlayer(e)
        },
        setChangeInteractive: function() {
            return !1
        },
        getVideoInfo: function() {
            var e = this.playerData.vinfo;
            return {
                vid: e.vid,
                pid: e.pid,
                cid: e.cid,
                nextvid: e.nextvid,
                duration: e.gdur,
                title: e.title
            }
        }
    },
    e.exports = i
}
, function(e, t, a) {
    var i = a(3)
      , s = a(6)
      , n = a(17)
      , r = a(18)
      , o = a(19)
      , l = function(e, t, l, d, h) {
        this.playerData = e,
        this.user = t,
        this.pingback = l,
        this.coreVideo = d,
        this.curVideo = this.coreVideo,
        this.lanFit = h,
        this.evt = i.merge({}, r),
        this.listener = new o;
        var c = new Date
          , p = c.getFullYear()
          , u = c.getMonth() + 1
          , g = c.getDate()
          , f = "playerDebug=" + p + (u >= 10 ? u : "0" + u) + (g >= 10 ? g : "0" + g);
        this.isDebug = window.location.search.indexOf(f) >= 0,
        this.log = new n(this.playerData.playerVersion,this.isDebug),
        s.isDebug && (this.debuger = a(20),
        this.debuger.init())
    };
    l.prototype = {
        register: function(e) {
            e.start(this)
        },
        debug: function(e) {
            this.debuger && this.debuger.log(e)
        }
    },
    e.exports = l
}
, function(e, t, a) {
    function i() {
        var e = new Date;
        return e.getFullYear() + "/" + (e.getMonth() + 1) + "/" + e.getDate() + " " + e.getHours() + ":" + e.getMinutes() + ":" + e.getSeconds()
    }
    var s = a(3)
      , n = a(6)
      , r = function(e, t) {
        this.playerVersion = e,
        this.header = [encodeURIComponent("<p>Letv Log(H5播放器日志)<br>playerVersion: " + this.playerVersion + ";UA: " + navigator.userAgent + ";Date: " + i() + "</p>")],
        this.logs = [],
        this.flag = !1,
        this.times = 0,
        t && this.showSendBtn()
    };
    r.prototype = {
        send: function(e) {
            e = e || {},
            (this.flag || e.forceSend) && (this.pushLog("send Log"),
            s.ajax({
                url: "http://vstat-api.letv.com/vplay/apis/feedback.php",
                type: "post",
                data: {
                    from: "web",
                    errno: e.errno || "",
                    data: "playerVersion=" + this.playerVersion + "&url=" + location.href + "&errno=" + e.errno,
                    phone: e.phone || "",
                    email: e.email || "letvH5",
                    content: e.forceSend ? "userSend" : "letvH5",
                    log: this.header.concat(this.logs).join("")
                }
            }))
        },
        getLog: function() {
            return decodeURIComponent(this.header.concat(this.logs).join(""))
        },
        pushLog: function(e) {
            if ("object" == typeof e && (e = s.JSONTOStr(e)),
            /timeupdate/i.test(e)) {
                if (++this.times > 3)
                    return
            } else
                this.times = 0;
            this.logs.push(encodeURIComponent("<p>[" + i() + "] " + e + "</p>"))
        },
        clearLog: function() {
            this.logs.length = 1
        },
        showSendBtn: function() {
            var e = document.createElement("button");
            e.id = "btnSend",
            e.setAttribute("style", "position: fixed; left: 0px; bottom: 0px; z-index: 9999; width:200px;height:100px;font-size:32px"),
            e.innerHTML = "上报",
            document.getElementsByTagName("body").item(0).appendChild(e),
            n(e).on("click", function() {
                var e = prompt("请输入您的联系方式");
                this.send({
                    forceSend: !0,
                    phone: e
                })
            }, this)
        }
    },
    e.exports = r
}
, function(e, t) {
    function a(e, t, a) {
        (e || "").split(l).forEach(function(e) {
            a(e, t)
        })
    }
    function i(e) {
        return new RegExp("(?:^| )" + e.replace(" ", " .* ?") + "(?: |$)")
    }
    function s(e) {
        var t = ("" + e).split(".");
        return {
            e: t[0],
            ns: t.slice(1).sort().join(" ")
        }
    }
    function n(e, t, a, n) {
        var r, o;
        return o = s(t),
        o.ns && (r = i(o.ns)),
        e.filter(function(e) {
            return e && (!o.e || e.e === o.e) && (!o.ns || r.test(e.ns)) && (!a || e.cb === a || e.cb._cb === a) && (!n || e.ctx === n)
        })
    }
    function r(e, t) {
        return this instanceof r ? (t && $.extend(this, t),
        this.type = e,
        this) : new r(e,t)
    }
    var o = [].slice
      , l = /\s+/
      , d = function() {
        return !1
    }
      , h = function() {
        return !0
    };
    r.prototype = {
        isDefaultPrevented: d,
        isPropagationStopped: d,
        preventDefault: function() {
            this.isDefaultPrevented = h
        },
        stopPropagation: function() {
            this.isPropagationStopped = h
        }
    };
    var c = {
        on: function(e, t, i) {
            var n, r = this;
            return t ? (n = this._events || (this._events = []),
            a(e, t, function(e, t) {
                var a = s(e);
                a.cb = t,
                a.ctx = i,
                a.ctx2 = i || r,
                a.id = n.length,
                n.push(a)
            }),
            this) : this
        },
        one: function(e, t, i) {
            var s = this;
            return t ? (a(e, t, function(e, t) {
                var a = function() {
                    return s.off(e, a),
                    t.apply(i || s, arguments)
                };
                a._cb = t,
                s.on(e, a, i)
            }),
            this) : this
        },
        off: function(e, t, i) {
            var s = this._events;
            return s ? e || t || i ? (a(e, t, function(e, t) {
                n(s, e, t, i).forEach(function(e) {
                    delete s[e.id]
                })
            }),
            this) : (this._events = [],
            this) : this
        },
        trigger: function(e) {
            var t, a, i, s, l, d = -1;
            if (!this._events || !e)
                return this;
            if ("string" == typeof e && (e = new r(e)),
            t = o.call(arguments, 1),
            e.args = t,
            a = n(this._events, e.type))
                for (s = a.length; ++d < s; )
                    if ((i = e.isPropagationStopped()) || !1 === (l = a[d]).cb.call(l.ctx2, e)) {
                        i || (e.stopPropagation(),
                        e.preventDefault());
                        break
                    }
            return this
        }
    };
    e.exports = c
}
, function(e, t) {
    var a = function() {
        this._hash = {},
        this._cid = 1,
        this._ckey = "_nx_msg_ckey"
    };
    a.prototype = {
        add: function(e, t, a) {
            if (e && t) {
                t.ctx = a;
                var i = t[this._ckey];
                i || (t[this._ckey] = i = this._cid++),
                (this._hash[e] = this._hash[e] || {})[i] = t
            }
        },
        remove: function(e, t, a) {
            if (e && t) {
                var i = t[this._ckey];
                if (this._hash[e] && i && this._hash[e][i] && this._hash[e][i].ctx == a) {
                    delete this._hash[e][i];
                    for (var s in this._hash[e])
                        return;
                    delete this._hash[e]
                }
            }
        },
        send: function(e, t) {
            if (this._hash[e]) {
                var a = [];
                for (var i in this._hash[e])
                    a.push(i);
                (function() {
                    for (; a.length; )
                        try {
                            var t = this._hash[e][a.shift()];
                            t.apply(t.ctx || null, arguments)
                        } catch (i) {
                            throw i
                        } finally {
                            arguments.callee.apply(this, arguments)
                        }
                }
                ).apply(this, arguments)
            }
        }
    };
    var i = function() {
        this._cache = {},
        this.msg = new a
    };
    i.prototype = {
        on: function(e, t, a) {
            this.msg.add(e, t, a)
        },
        one: function(e, t, a) {
            var i = this
              , s = function() {
                i.msg.remove(e, s, a),
                t.apply(a, arguments)
            };
            this.msg.add(e, s, a)
        },
        off: function(e, t, a) {
            this.msg.remove(e, t, a)
        },
        set: function(e, t, a) {
            this._cache[e] = t,
            a || this.msg.send(e, t)
        },
        get: function(e) {
            return this._cache[e]
        }
    },
    e.exports = i
}
, function(module, exports) {
    function addCss() {
        var e = ".debug{width:45%;position:absolute;left:0;top:350px;z-index:9999;background-color:#f4f7fe;border:1px solid #428ed4}.debug-menu{width:100%;height:30px;border-bottom:1px solid #428ed4;cursor:pointer;}.debug-menu input{float:right;margin-top:3px;}.debug-msg{overflow-y:auto;height:220px;border-bottom:1px solid #428ed4;}.debug-msg div{border-bottom:1px solid #428ed4;line-height:20px;}.debug-msg div.error{color:red;}#debug-command{width:70%;margin-right:5px;}"
          , t = document.head || document.getElementsByTagName("head")[0] || document.documentElement
          , a = document.createElement("style");
        a.setAttribute("type", "text/css"),
        a.innerHTML = e,
        t.appendChild(a)
    }
    function log(e, t) {
        var a = "";
        switch (t) {
        case "E":
            a = "error";
            break;
        default:
            a = "info"
        }
        var i = document.createElement("div");
        i.className = a,
        i.innerHTML = (new Date).toLocaleTimeString() + "  " + e;
        var s = document.getElementsByClassName("debug-msg")[0];
        s.appendChild(i),
        s.scrollTop = s.scrollHeight
    }
    function addEvents() {
        document.getElementsByClassName("debug-clear")[0].ontouchstart = function() {
            document.getElementsByClassName("debug-msg")[0].innerHTML = ""
        }
        ,
        document.getElementsByClassName("debug-close")[0].onclick = function() {
            dom.style.display = "none"
        }
        ,
        document.getElementById("debug-execute").onclick = function() {
            var command = document.getElementById("debug-command").value;
            try {
                var result = eval(command);
                Debug.log(result)
            } catch (e) {
                Debug.log(e.message, "error")
            }
        }
    }
    function init(e) {
        addCss(),
        e = e || document.body,
        e.appendChild(dom),
        addEvents()
    }
    var model = '<div class="debug-menu"><input type="button" value="close" class="debug-close" /><input type="button" value="clear" class="debug-clear"/></div><div class="debug-msg"></div><div><input type="text" id="debug-command"/><input type="button" value="execute" id="debug-execute"/><input type="button" value="sendlog" id="debug-send-log"/></div>'
      , dom = document.createElement("div");
    dom.className = "debug",
    dom.innerHTML = model,
    Debug = {
        init: init,
        log: log
    },
    module.exports = Debug
}
, function(e, t) {
    var a = {
        REGION: "cn",
        PLAY_STATE: "playState",
        FULLSCREEN_STATE: "fullscreenState",
        IS_AD: "isAd",
        USER_INFO: "userInfo",
        BARRAGE_STATE: "barrage_state",
        GRAVITY_ACTIVE: "gravityActive",
        VR_ACTIVE: "vrActive",
        LIVE_STATE: "live_state",
        LIVE_TIMESHIFT: "live_timeshift",
        PROTOCAL: "http://",
        EVENT: {
            PLAYER_COMMAND: "playerCommand",
            PLAYER_CALLBACK: "playerCallback",
            RESIZE: "resize",
            CHANGEBARRAGE: "changebarrage"
        },
        HOST_NAME: {
            API_LETV_COM: "api.le.com",
            API_WWW_LETV_COM: "api.www.le.com",
            API_MY_LETV_COM: "api-my.le.com",
            LETV_COM: "le.com",
            D_APi_M_LETV_COM: "d-api-m.le.com",
            API_LIVE_LETV_COM: "api.live.le.com",
            WWW_LETV_COM: "www.le.com",
            PLAYER_PC_LETV_COM: "player-pc.le.com",
            APPLE_US_WWW_LETV_COM: "apple-us-www.le.com",
            APPLE_WWW_LETV_COM_HK: "apple-hk-www.le.com",
            APPLE_WWW_LETV_COM: "apple-www.le.com",
            V_STAT_LETV_COM: "vstat-api.letv.com",
            B_SCORECARDRESEARCH_COM: "b.scorecardresearch.com",
            STAT_PC_LETV_COM: "stat-pc.letv.com",
            HD_MY_LETV_COM: "hd-my.letv.com",
            FE_GO: "fe-go.letv.com"
        },
        ERROR_CODE: {
            ERROR: "600",
            AUTH_TIMEOUT: "601",
            AUTH_ARGS_ERR: "603",
            AUTH_DATA_EMPTY: "604",
            AUTH_COOKIE_CHECK_ERR: "605",
            AUTH_COOKIE_RETRY_ERROR: "606",
            AUTH_TIME_SERVER_ERROR: "611",
            USER_ABNORMAL: "612",
            GSLB_TIMEOUT: "621",
            GSLB_DATA_EMPTY: "622",
            GSLB_ERROR: "624",
            TOKEN_TIMEOUT: "623",
            URL_NOT_SUPPORT_MP4: "640",
            URL_NOT_SUPPORT_M3U8: "641",
            OUT_SEA: "643",
            ADURL_NOT_SUPPORT: "646",
            COPY_RIGHT_BAN: "647",
            OFFLINE: "648",
            CN_BAN: "650",
            GSLB_SERVER_PRESSURE_LARGE: "651",
            AREA_BAN: "652",
            DRM_BAN: "653",
            ERROR_LIVE: "700",
            LIVE_INFO_ERROR: "701",
            LIVE_INFO_API_ERROR: "702",
            LIVE_INFO_API_TIMEOUT: "703",
            STREAMID_ERROR_LIVE: "704",
            LIVE_INFO_EMPTY: "705",
            GSLB_TIMEOUT_LIVE: "721",
            GSLB_DATA_EMPTY_LIVE: "722",
            VALIDATE_TIMEOUT_LIVE: "723",
            GSLB_BAN: "724",
            GSLB_DATA_ERROR: "725",
            GSLB_TOKEN_ERROR: "726",
            LIVE_CN_BAN: "727",
            LIVE_HK_BAN: "728",
            URL_NOT_SUPPORT_LIVE: "740",
            OUT_SEA_LIVE: "743",
            HOST_RIGHT_BAN_LIVE: "747",
            PLATFORM_RIGHT_BAN_LIVE: "748",
            NOT_SUPPORT_1080P_LIVE: "749",
            GSLB_SERVER_PRESSURE_LARGE_LIVE: "751",
            LIVE_DRM_BAN: "752",
            LIVE_AREA_BAN: "753",
            LIVE_PROXY_ERROR: "754"
        }
    };
    e.exports = a
}
, function(e, t, a) {
    var i = a(23)
      , s = a(3)
      , n = function(e, t) {
        this.lan = e,
        this.playerType = t,
        this.lanPackage = a(24)("./" + this.lan)
    };
    s.extend(n, i);
    var r = {
        fit: function(e) {
            return this.lanPackage[this.playerType][e] || e
        }
    };
    s.merge(n.prototype, r),
    e.exports = n
}
, function(e, t, a) {
    var i = a(21)
      , s = a(6)
      , n = function() {};
    n.prototype = {
        start: function(e) {
            this.manager = e,
            this.jsonp = null,
            this.manager.listener.on(i.PLAY_STATE, function(e, t) {
                "init" != t && "stop" != t || (this.jsonp && this.jsonp.destroy(),
                this.jsonp = null),
                "reload" == t && this.destroy()
            }, this),
            this.init()
        },
        init: function() {},
        destroy: function() {},
        setEvents: function(e, t, a) {
            if (t.events)
                for (var i in t.events) {
                    var n = i.match(/^(\S+)\s*(.*)$/)
                      , r = "";
                    "document" === n[1] ? r = s(document) : "window" === n[1] ? r = s(window) : t.parentEl && (r = t.parentEl.find(n[1])),
                    r[e](n[2], t.events[i], a)
                }
        },
        sendError: function(e) {
            this.manager.pingback.sendError(e),
            this.manager.evt.trigger(i.EVENT.PLAYER_CALLBACK, "PLAYER_ERROR", {
                code: e
            }),
            this.manager.evt.trigger("vjs_showPopTip", e)
        }
    },
    e.exports = n
}
, function(e, t, a) {
    function i(e) {
        return a(s(e))
    }
    function s(e) {
        return n[e] || function() {
            throw new Error("Cannot find module '" + e + "'.")
        }()
    }
    var n = {
        "./cn": 25,
        "./cn.js": 25,
        "./en": 26,
        "./en.js": 26,
        "./hk": 27,
        "./hk.js": 27,
        "./lanfit": 22,
        "./lanfit.js": 22
    };
    i.keys = function() {
        return Object.keys(n)
    }
    ,
    i.resolve = s,
    e.exports = i,
    i.id = 24
}
, function(e, t) {
    var a = {
        normal: {},
        live: {}
    };
    e.exports = a
}
, function(e, t) {
    var a = {
        "请输入您的联系方式": "Please enter your contact method",
        "联系方式为空": "Contact method is empty",
        "反馈成功": "Feedback submitted",
        "本片为付费影片，开通会员可免费观看": "This movie is a premium movie free for members",
        "开通会员": "Activate membership",
        "已是会员": "If you are already a member",
        "立即登录": "Log in now",
        "试看已结束，继续观看请开通会员": "The preview has ended. To continue, please activate membership",
        "试看已结束，继续观看请开通": "The preview has ended. To continue, please activate ",
        "立即开通会员": "Activate membership now",
        "试看已结束，继续观看需使用1张观影卷(现有": "The preview is ended. To watch the full video, please use 1 ticket (",
        "使用观影券48小时内可重复观看当前影片": "Using a ticket enables you to watch this movie free for the next 48 hours",
        "立即使用": "Use now",
        "试看已结束": "Preview has ended",
        "继续欣赏请": "To watch the full video",
        "使用观影券": "please use a ticket",
        "试看已结束，本月赠送的观影卷已用完": "The preview is ended. You have used up the movie tickets for this month.",
        "分钟试看已结束": " minute preview is ended",
        "使用乐视视频APP观看完整版": "Watch the full movie with the Le app",
        "观看完整版": "Watch the full movie",
        "人太多挤爆啦，工程师正在抢修": "Oops, fixing now",
        "稍后试试看": "Try again later",
        "检测您帐号有异常，会员服务已冻结,如有问题请联系客服": "An exception has been detected for your account and your membership is suspended.Should you have any questions, please contact the customer service",
        "因版权方要求，暂不能观看": "This video is currently unavailable due to copyright restrictions",
        "很抱歉，您看的视频已经下线了": "This video is no longer available",
        "因版权方要求，此视频仅支持在中国大陆地区观看": "This video is only available for Mainland China due to copyright restrictions",
        "详情请致电乐视视频客户服务热线": "For details, please contact the customer service hotline",
        "该内容不支持在中国大陆观看": "This content is not available for Mainland China",
        "该内容不支持在当前地区观看": "This content is not available for the current region",
        "使用乐视视频APP，抢先观看当前视频": "Watch this video beforehand with the Le app",
        "前往观看": "Watch",
        "当前视频需要使用乐视视频APP观看，高清更流畅": "The Le app is required for watching this video for an HD and smooth experience.",
        "立即观看": "Watch now",
        "由于版权原因": "This video is not available for this platform",
        "该视频暂不支持在此平台播放": "due to copyright restrictions",
        "缺少可播放的视频数据": "Required video data is missing",
        "视频无法播放": "Unable to play the video",
        "提交反馈": "Submit feedback",
        "刷新重试": "Refresh to retry",
        "反馈码": "Feedback code",
        "正在为您切换清晰度...": "Switching definition...",
        "人太多挤爆了~暂只能提供低清晰度观看": "Server is busy now. Try a lower definition",
        "会员影片可试看": "You can preview a premium movie for",
        "影片可试看": "You can preview this movie for",
        "分钟": "minutes",
        "张": "remaining",
        "弹幕": "Barrage",
        "我的弹幕，总有人懂...": "Someone will understand my bullet comments...",
        "发送": "Send",
        "关闭": "Close",
        "用乐视APP超清观看": "View HD videos on Le APP",
        "流畅": "240P",
        "标清": "360P",
        "高清": "480P",
        "超清": "720P",
        "原画": "原畫",
        "极速": "144P",
        "跳过广告": "Skip ad",
        "广告": "Ad",
        "了解详情": "Learn more",
        "如果您已是会员，请登录": "Log in if you are already a member",
        "登录": "Log in",
        "会员": "member",
        "受视频格式限制，该内容不支持观看": "This content cannot be played due to video format restrictions.",
        "欢迎观看其他精彩内容": "You are welcome to peruse any of our other content"
    }
      , i = {
        "因直播版权限制，该内容暂不能观看": "Due to live copyright restrictions,The content temporarily can not be viewed",
        "只能拖到这里啦": "You are only able to move to this position",
        "返回直播": "    To live",
        "正在直播": "On air",
        "正在回看": "Replaying",
        "直播已经开始了": "Live program is started",
        "请前往乐视视频移动客户端观看": "Please watch in the Le mobile client",
        "本场直播开始时间": "Start time of this live program",
        "请稍后回来": "Please come back later",
        "直播已结束": "Live program is ended",
        "您可回看精彩内容": "You can replay for the highlights",
        "立即回看": "Replay now",
        "当前节目为付费直播内容，请付费后观看": "This program is a premium live program. Please pay to watch it",
        "因政策原因，该内容无法提供观看": "This content is unavailable due to policy restrictions",
        "由於版權限制": "Due to copyright restrictions",
        "此視頻只限於中國大陸地區播放": "This video is only available in Mainland China",
        "当前节目试看已结束，请付费后观看": "The preview of this program is ended. Please pay to watch the full program",
        "本平台不支持720p和1080P码流视频播放": "This platform does not support playing videos in the 720p or 1080P bit rate",
        "还请谅解": "Thank you for your understanding",
        "因版权方要求，此视频仅支持在中国大陆地区观看": "This video is only available for Mainland China due to copyright restrictions",
        "该内容不支持在当前地区观看": "This content is not available for the current region",
        "人太多挤爆啦，工程师正在抢修": "Oops, fixing now",
        "详情请致电乐视视频客户服务热线": "For details, please contact the customer service hotline at",
        "稍后试试看": "Try again later",
        "播放加载失败，请稍后再试": "Failed to load data. Try again later.",
        "人太多挤爆了~暂只能提供低清晰度观看": "Server is busy now. Try a lower definition",
        "提交反馈": "Submit feedback",
        "刷新重试": "Refresh to retry",
        "反馈码": "Feedback code",
        "视频无法播放": "Unable to play the video  ",
        "前往观看": "Watch",
        "请输入您的联系方式": "Please enter your contact method",
        "联系方式为空": "Contact method is empty",
        "反馈成功": "Feedback submitted",
        "正在为您切换清晰度...": "Switching definition...",
        "流畅": "240P",
        "标清": "360P",
        "高清": "480P",
        "超清": "720P",
        "原画": "original",
        "极速": "144P",
        "1080P": "1080P",
        "跳过广告": "Skip ad",
        "广告": "Ad",
        "了解详情": "Learn more",
        "如果您已是会员，请登录": "Log in if you are already a member",
        "登录": "Log in",
        "受视频格式限制，该内容不支持观看": "This content cannot be played due to video format restrictions.",
        "欢迎观看其他精彩内容": "You are welcome to peruse any of our other content"
    }
      , s = {
        normal: a,
        live: i
    };
    e.exports = s
}
, function(e, t) {
    var a = {
        "请输入您的联系方式": "請輸入您的聯繫方式",
        "联系方式为空": "聯繫方式為空",
        "反馈成功": "回饋成功",
        "本片为付费影片，开通会员可免费观看": "本片為付費影片，開通會員可免費觀看",
        "开通会员": "開通會員",
        "已是会员": "已是會員",
        "立即登录": "立即登入",
        "试看已结束，继续观看请开通会员": "試睇已結束，繼續觀看請開通會員",
        "试看已结束，继续观看请开通": "試睇已結束，繼續觀看請開通",
        "立即开通会员": "立即開通會員",
        "试看已结束，继续观看需使用1张观影卷(现有": "試睇已結束，繼續觀看需使用1張觀影券(現有",
        "使用观影券48小时内可重复观看当前影片": "使用觀影券 48 小時內可重複觀看目前影片",
        "立即使用": "立即使用",
        "试看已结束": "試睇已結束",
        "继续欣赏请": "繼續欣賞請",
        "试看已结束，本月赠送的观影卷已用完": "試睇已結束，本月贈送的觀影卷已用完",
        "分钟试看已结束": "分鐘試睇已結束",
        "使用乐视视频APP观看完整版": "使用樂視視頻 APP 觀看完整版",
        "观看完整版": "觀看完整版",
        "人太多挤爆啦，工程师正在抢修": "人數過多，工程師正在搶修",
        "稍后试试看": "請稍後再試",
        "检测您帐号有异常，会员服务已冻结": "偵測您帳戶異常，會員服務已凍結",
        "如有问题请联系客服": "如有問題請聯繫客服",
        "因版权方要求，暂不能观看": "因版權方要求，暫不能觀看",
        "很抱歉，您看的视频已经下线了": "很抱歉，您看的視頻已經下線了",
        "因版权方要求，此视频仅支持在中国大陆地区观看": "因版權方要求，此視頻僅支援在中國大陸觀看",
        "详情请致电乐视视频客户服务热线": "詳情請致電樂視視頻客戶服務熱線",
        "该内容不支持在中国大陆观看": "此內容不支援在中國大陸觀看",
        "该内容不支持在当前地区观看": "此内容不支援在目前地區觀看",
        "使用乐视视频APP，抢先观看当前视频": "使用樂視視頻 APP，搶先觀看目前視頻",
        "前往观看": "前往觀看",
        "当前视频需要使用": "當前視頻需要使用",
        "乐视视频APP观看，高清更流畅": "樂視視頻 APP 觀看，高清更流暢",
        "立即观看": "立即觀看",
        "由于版权原因": "由於版權原因",
        "该视频暂不支持在此平台播放": "本視頻暫不支援在此平台播放",
        "缺少可播放的视频数据": "缺少可播放的視頻數據",
        "视频无法播放": "視頻無法播放",
        "提交反馈": "提交回饋",
        "刷新重试": "重新整理再試",
        "反馈码": "回饋碼",
        "正在为您切换清晰度...": "正在為您切換清晰度...",
        "人太多挤爆了~暂只能提供低清晰度观看": "人數過多~暫時只提供低清晰度觀看",
        "会员影片可试看6分钟": "會員影片可試睇 6 分鐘",
        "影片可试看": "影片可試睇",
        "分钟": "分鐘",
        "张": "張",
        "弹幕": "彈幕",
        "我的弹幕，总有人懂...": "我的彈幕，總有人懂...",
        "发送": "發送",
        "关闭": "關閉",
        "用乐视APP超清观看": "用樂視APP超清觀看",
        "流畅": "流暢",
        "标清": "標清",
        "高清": "高清",
        "超清": "超清",
        "原画": "原畫",
        "极速": "極速",
        "跳过广告": "略過廣告",
        "广告": "廣告",
        "了解详情": "了解詳情",
        "如果您已是会员，请登录": "如果您已經是會員，請登入",
        "登录": "登入",
        "会员": "會員",
        "受视频格式限制，该内容不支持观看": "受視頻格式限制，該內容不支援觀看",
        "欢迎观看其他精彩内容": "歡迎觀看其他精彩內容"
    }
      , i = {
        "因直播版权限制，该内容暂不能观看": "因直播版權限制，該內容暫不能觀看",
        "只能拖到这里啦": "只能拖到這裡啦",
        "返回直播": "返回直播",
        "正在直播": "正在直播",
        "正在回看": "正在倒帶",
        "直播已经开始了": "直播已經開始了",
        "请前往乐视视频移动客户端观看": "請前往樂視視頻移動用戶端觀看",
        "本场直播开始时间": "本場直播開始時間",
        "请稍后回来": "請稍後回來",
        "直播已结束": "直播已結束",
        "您可回看精彩内容": "您可重播精彩內容",
        "立即回看": "立即重播",
        "当前节目为付费直播内容，请付费后观看": "目前節目為付費直播內容，請付費後觀看",
        "因政策原因，该内容无法提供观看": "因政策原因，此內容無法提供觀看",
        "由於版權限制": "由於版權限制",
        "此視頻只限於中國大陸地區播放": "此視頻只限於中國大陸地區播放",
        "该内容不支持在当前地区观看": "此内容不支援在目前地區觀看",
        "当前节目试看已结束，请付费后观看": "目前節目試睇已結束，請付費後觀看",
        "本平台不支持720p和1080P码流视频播放 ": "本平台不支援720P及1080P碼流視頻播放",
        "还请谅解": "敬請諒解",
        "人太多挤爆啦，工程师正在抢修": "人數過多，工程師正在搶修",
        "稍后试试看": "請稍後再試",
        "因版权方要求，此视频仅支持在中国大陆地区观看": "因版權方要求，此視頻僅支援在中國大陸觀看",
        "详情请致电乐视视频客户服务热线": "詳情請致電樂視視頻客戶服務熱線",
        "提交反馈": "提交回饋",
        "刷新重试": "重新整理再試",
        "反馈码": "回饋碼",
        "视频无法播放": "視頻無法播放",
        "播放加载失败，请稍后再试": "播放載入失敗，請稍後再試",
        "前往观看": "前往觀看",
        "请输入您的联系方式": "請輸入您的聯繫方式",
        "联系方式为空": "聯繫方式為空",
        "反馈成功": "回饋成功",
        "人太多挤爆了~暂只能提供低清晰度观看": "人數過多~暫時只提供低清晰度觀看",
        "正在为您切换清晰度...": "正在為您切換清晰度...",
        "流畅": "流暢",
        "标清": "標清",
        "高清": "高清",
        "超清": "超清",
        "原画": "原畫",
        "极速": "極速",
        "1080P": "1080P",
        "跳过广告": "略過廣告",
        "广告": "廣告",
        "了解详情": "了解詳情",
        "如果您已是会员，请登录": "如果您已經是會員，請登入",
        "登录": "登入",
        "受视频格式限制，该内容不支持观看": "受視頻格式限制，該內容不支援觀看",
        "欢迎观看其他精彩内容": "歡迎觀看其他精彩內容"
    }
      , s = {
        normal: a,
        live: i
    };
    e.exports = s
}
, function(e, t, a) {
    function i() {}
    var s = a(23)
      , n = a(3)
      , r = a(4)
      , o = a(29)
      , l = a(21)
      , d = a(5)
      , h = a(2);
    n.extend(i, s);
    var c = {
        init: function() {
            this.playerData = this.manager.playerData,
            this.isFirstVideo = !0,
            this.HEART_TIME = 120,
            this.HEART_TIMER = 5,
            this.HEART_REPORT_COUNT = parseInt(this.HEART_TIME / this.HEART_TIMER),
            this.heartAutoTime = null,
            this.heartCount = 0;
            var e = this.playerData.flashVar;
            this.Mpy = window.Stat && window.Stat.data && window.Stat.data.py || "",
            this.isLive = "live" == this.playerData.playerType || "ov-live" == this.playerData.playerType,
            this.param = {
                ver: "3.7.2",
                p1: this.playerData.config.p1,
                p2: this.playerData.config.p2,
                p3: this.playerData.config.p3,
                lc: o.getLC(),
                weid: o.getWeid(),
                os: h.mac ? "os" : h.Android ? "android" : h.iPhone || h.iPad || h.iPod ? "ios" : h.wph ? "wince" : /symbian/i.test(navigator.userAgent) ? "symbian" : "-",
                br: this.getBrowser(),
                ro: screen.width + "_" + screen.height,
                ref: this.playerData.urlParams.ref || n.getCookie("tj_ref") || (document.referrer ? encodeURIComponent(document.referrer) : this.playerData.vinfo.fcode || "-"),
                pv: this.playerData.playerVersion,
                ch: "-",
                ty: e.ty || (this.isLive ? this.playerData.vinfo.channelId ? "2" : "1" : "0"),
                xh: h.letvTv ? "tv" : h.iPad || h.AndroidPad ? "pad" : "phone",
                url: encodeURIComponent(location.href),
                lid: this.playerData.vinfo.pid,
                uid: "-",
                ilu: 1,
                uuid: "-"
            },
            this.errMap = {
                600: "0050",
                601: "0051",
                603: "0052",
                604: "0053",
                605: "0054",
                606: "0055",
                611: "0056",
                612: "0057",
                621: "1900",
                622: "1901",
                623: "0058",
                624: "1902",
                640: "0409",
                641: "0410",
                643: "0008",
                646: "0410",
                647: "0015",
                650: "0012",
                651: "0208",
                700: "1430",
                701: "1431",
                702: "1432",
                703: "1433",
                704: "1434",
                705: "1435",
                723: "1406",
                724: "1903",
                725: "1904",
                749: "1436",
                751: "0208"
            },
            this.manager.listener.on(l.REGION, function(e, t) {
                var a;
                switch (t) {
                case "us":
                    a = l.PROTOCAL + l.HOST_NAME.APPLE_US_WWW_LETV_COM;
                    break;
                case "hk":
                    a = l.PROTOCAL + l.HOST_NAME.APPLE_WWW_LETV_COM_HK;
                    break;
                case "cn":
                default:
                    a = l.PROTOCAL + l.HOST_NAME.APPLE_WWW_LETV_COM
                }
                this.urlList = {
                    EnvUrl: a + "/env/",
                    ActionUrl: a + "/pl/",
                    CNTVUrl: a + "/w/",
                    ErrorUrl: l.PROTOCAL + l.HOST_NAME.V_STAT_LETV_COM + "/vplay/flverr",
                    ErrorUrl2: a + "/er/",
                    ComScore: l.PROTOCAL + l.HOST_NAME.B_SCORECARDRESEARCH_COM + "/b",
                    statUrl: l.PROTOCAL + l.HOST_NAME.STAT_PC_LETV_COM + "/op",
                    feGo: l.PROTOCAL + l.HOST_NAME.FE_GO + "/ds"
                }
            }, this),
            this.manager.listener.on(l.USER_INFO, function(e, t) {
                this.param.uid = t ? t.ssouid : "-",
                this.param.ilu = t ? "0" : "1"
            }, this),
            this.manager.listener.on(l.PLAY_STATE, function(e, t) {
                if ("init" == t) {
                    this.param.uuid = o.getUUID();
                    var a = this.playerData.flashVar;
                    this.isFirstVideo ? this.isFirstVideo = !1 : delete a.chOnce,
                    this.param.ch = encodeURIComponent(a.chOnce || a.tg || a.ch || a.typeFrom || ("live" == this.playerData.playerType ? "letv_live" : "letv"))
                } else if ("changeDefi" == t || "changeView" == t) {
                    var i = this.param.uuid.match(/_(\d+)/);
                    null == i ? this.param.uuid += "_1" : this.param.uuid = this.param.uuid.replace(i[0], "_" + (Number(i[1]) + 1))
                } else
                    "changeReplay" == t && (this.param.uuid = o.getUUID())
            }, this)
        },
        getUUID: function() {
            return this.param.uuid
        },
        getLC: function() {
            return this.param.lc
        },
        getCH: function() {
            return this.param.ch
        },
        getBrowser: function() {
            for (var e, t, a = navigator.userAgent, i = [["qq", "(tencenttraveler)\\s([0-9].[0-9])"], ["ff", "(firefox)\\/([0-9])"], ["ff", "(minefield)\\/([0-9])"], ["ff", "(shiretoko)\\/([0-9])"], ["opera", "(opera)\\/([0-9])"], ["ie", "(msie)\\s([0-9].[0-9])"], ["chrome", "(chrome)\\/([0-9])"], ["qq", "(QQBrowser)\\/([0-9])"], ["UC", "(UCBrowser)\\/([0-9])"], ["safa", "(safari)\\/([0-9])"]], s = 0; s < i.length; s++)
                if (e = new RegExp(i[s][1],"i"),
                e.test(a)) {
                    if (t = i[s][0],
                    "ie" == t) {
                        var n = a.match(/(msie) ([\w]+)/i);
                        null != n && (t += n[2])
                    }
                    break
                }
            return t || "other"
        },
        isLogin: function() {
            var e = this.manager.listener.get(l.USER_INFO);
            return e ? "0" : "1"
        },
        getRadom: function() {
            for (var e = "", t = 0; t < 12; t++)
                e += Math.floor(10 * Math.random());
            return e
        },
        sendComStore: function() {
            if (1 != this.playerData.flashVar.isHttps) {
                var e = this.playerData.vinfo
                  , t = {
                    c1: 1,
                    c2: "8640631",
                    c3: e.vid,
                    c4: "",
                    c5: e.pid,
                    c6: e.cid
                };
                n.sendRequest(this.urlList.ComScore, t)
            }
        },
        sendFeGo: function(e) {
            if (e) {
                var t = {
                    code: e.code,
                    _r: Math.random()
                };
                n.sendRequest(this.urlList.feGo, t)
            }
        },
        sendProxyError: function(e, t) {
            this.manager.log.pushLog("sendProxyError: " + e),
            4 == String(e).length && (e = "9" + e);
            var a = {
                t: "error",
                s: this.manager.listener.get(l.REGION),
                u: encodeURIComponent(t) || "H5",
                v: e
            };
            n.sendRequest(this.urlList.statUrl, a)
        },
        sendError: function(e) {
            this.manager.log.pushLog("errCode: " + e),
            this.sendProxyError(e);
            var t = this.playerData.vinfo
              , a = {
                errno: e,
                url: this.param.url,
                vid: t.vid,
                mid: "",
                ch: this.param.ch,
                ver: this.playerData.playerVersion,
                _r: Math.random()
            };
            n.sendRequest(this.urlList.ErrorUrl, a);
            var i;
            if (i = this.errMap[e]) {
                var a = {
                    ver: this.param.ver,
                    p1: this.param.p1,
                    p2: this.param.p2,
                    p3: this.param.p3,
                    et: "pl",
                    err: i,
                    lc: this.param.lc,
                    r: this.getRadom(),
                    os: this.param.os,
                    br: this.param.br,
                    cid: t.cid || "",
                    vid: t.vid || "",
                    pid: t.pid || "",
                    zid: t.zid || "",
                    uuid: this.param.uuid,
                    app_name: "H5Player",
                    nt: "none"
                };
                n.sendRequest(this.urlList.ErrorUrl2, a)
            }
        },
        sendEnv: function() {
            var e = {
                p1: this.param.p1,
                p2: this.param.p2,
                p3: this.param.p3,
                lc: this.param.lc,
                uuid: this.param.uuid,
                mac: "-",
                nt: "none",
                os: this.param.os,
                src: "pl",
                xh: this.param.xh,
                br: this.param.br,
                ro: this.param.ro,
                r: this.getRadom(),
                app_name: "H5Player",
                ssid: "-",
                app: "-",
                ctime: (new Date).getTime(),
                ver: this.param.ver
            };
            n.sendRequest(this.urlList.EnvUrl, e)
        },
        sendPlayAction: function(e, t, a) {
            var i = this.playerData.vinfo
              , s = n.now()
              , o = this.getRadom()
              , l = {
                ac: e,
                py: encodeURIComponent("cl=" + r.getCl(this.param.lc) + "&br=" + navigator.userAgent + (this.Mpy ? "&" + this.Mpy : "")),
                ver: this.param.ver,
                p1: this.param.p1,
                p2: this.param.p2,
                p3: this.param.p3,
                ty: this.param.ty,
                uid: this.param.uid,
                lc: this.param.lc,
                uuid: this.param.uuid,
                cid: i.cid || "",
                pid: this.isLive ? "" : i.pid || "",
                vid: i.vid || "",
                lid: this.isLive ? i.pid || "" : "",
                st: this.isLive ? i.channelEname || "" : "",
                sid: i.curSid || "",
                vlen: i.gdur || "",
                ch: this.param.ch,
                url: this.param.url,
                weid: this.param.weid,
                ref: this.param.ref,
                pv: this.param.pv,
                ilu: this.param.ilu,
                ctime: s,
                r: o,
                key: r.getPingBackKey(this.param.lc.toLowerCase(), this.param.uuid.toLowerCase(), s, o),
                app_name: "H5Player",
                nt: "none",
                ipt: this.playerData.vinfo.up ? 1 : 0
            }
              , d = {
                pt: "-",
                ut: "-",
                ry: "0",
                vt: this.playerData.vinfo.curVtype || ""
            };
            n.merge(d, t),
            n.merge(l, d),
            i.zid && (l.zid = i.zid),
            this.param.lid && (l.lid = this.param.lid),
            i.owner && (l.owner = 1 == parseInt(i.owner) ? 1 : 0),
            i.urlMid && (l.mid = i.urlMid),
            i.urlSource && (l.source = i.urlSource),
            n.sendRequest(this.urlList.ActionUrl, l)
        },
        sendDuration: function(e, t) {
            e = (e / 1e3).toFixed(1),
            e = String(e).split(".")[1] > 5 ? Math.ceil(e) : Math.floor(e) + .5;
            var a = {
                t: "duration",
                s: t,
                v: e,
                k: d.MD5("pc_stat_api" + e)
            };
            n.sendRequest(this.urlList.statUrl, a)
        },
        startHeartRecord: function() {
            clearInterval(this.heartAutoTime),
            this.heartCount = 0,
            this.heartAutoTime = setInterval(n.bind(function() {
                ++this.heartCount == this.HEART_REPORT_COUNT && this.flushHeartRecord()
            }, this), 1e3 * this.HEART_TIMER)
        },
        stopHeartRecord: function() {
            clearInterval(this.heartAutoTime),
            this.flushHeartRecord()
        },
        flushHeartRecord: function() {
            this.heartCount && (this.sendPlayAction("time", {
                pt: 5 * this.heartCount
            }),
            this.heartCount = 0)
        }
    };
    n.merge(i.prototype, c),
    e.exports = i
}
, function(e, t, a) {
    var i = a(3)
      , s = a(21);
    e.exports = {
        getUUID: function() {
            return this.uuid = "1" + String((new Date).getTime()).slice(4) + String(Math.random()).slice(-6),
            this.uuid
        },
        getLC: function() {
            if (!this.lc)
                if ("undefined" != typeof Stats && "function" == typeof Stats.getLC)
                    this.lc = Stats.getLC();
                else {
                    var e = i.getCookie("tj_lc");
                    if (!e) {
                        for (var e = "", t = 32; t--; )
                            e += Math.floor(16 * Math.random()).toString(16);
                        var a = new Date;
                        a.setFullYear(a.getFullYear() + 20),
                        i.setCookie("tj_lc", e, {
                            expires: a,
                            domain: s.HOST_NAME.LETV_COM,
                            path: "/"
                        })
                    }
                    this.lc = e
                }
            return this.lc
        },
        getWeid: function() {
            return "undefined" != typeof Stats && "undefined" != typeof Stats.WEID ? Stats.WEID : "5" + (new Date).getTime() + String(Math.random()).slice(-10)
        }
    }
}
, function(e, t, a) {
    function i(e) {
        var t = s.parseToJSON(e.flashvar)
          , a = s.parseToJSON(location.search);
        for (var i in t)
            t[i] = s.trim(t[i]);
        var l = {
            cid: t.cid || "",
            zid: t.zid || "",
            appGuideTime: Number(t.appGuideTime) || 0,
            owner: t.owner || "",
            urlMid: t.mid || "",
            urlSource: t.source || ""
        }
          , d = {
            cont: e.cont,
            lan: t.lan || "cn",
            ark: t.ark,
            p1: t.p1 || "0",
            p2: t.p2 || "06",
            p3: t.p3 || (n.mac && n.safari ? "01" : ""),
            defi: t.rate || s.getCookie("defi") || r.defi,
            playbackRate: t.speed || sessionStorage.getItem("playbackRate") || r.playbackRate,
            isAutoMute: "undefined" != typeof t.autoMute ? parseInt(t.autoMute) : r.isAutoMute,
            isAutoPlay: "undefined" != typeof t.autoplay ? parseInt(t.autoplay) : r.isAutoPlay,
            isPreload: n.weixin && n.iPhone ? 1 : "undefined" != typeof t.preload ? parseInt(t.preload) : r.isPreload,
            nextBtn: "undefined" != typeof t.nextBtn ? parseInt(t.nextBtn) : r.nextBtn,
            definition: "undefined" != typeof t.definition ? parseInt(t.definition) : r.definition,
            Barrage: "MPlayer" == t.pname ? 0 : 0 == parseInt(t.barrage) ? 0 : 1,
            hideBarrage: "MPlayer" == t.pname ? 1 : 1 == parseInt(t.hideBarrage) ? 1 : 0,
            historyPlay: "1" == t.historyPlay,
            supportP2P: 1 != t.forceCDN && (!(n.forceMp4 || !window.CdeMediaHelper) && window.CdeMediaHelper.supportPlayer()),
            splatId: t.splatId || ("MPlayer" == t.pname ? "301" : "304")
        };
        n.weixin && n.Android && (d.isAutoPlay = !1);
        var h = {
            preparePlay: !1,
            startPlay: !1
        };
        if (t.rate) {
            var c = {
                350: 1,
                800: 2
            };
            c[t.rate] && (d.defi = c[t.rate])
        }
        return {
            flashVar: t,
            urlParams: a,
            vinfo: l,
            videoType: "m3u8",
            config: d,
            pname: t.pname || "",
            tryLookType: "none",
            tryLookTime: 0,
            videoFlag: h,
            playerVersion: o,
            playerType: "normal",
            interactiveType: n.Android || n.iPad || n.iPod || n.iPhone || n.wph || n.ps ? "mobile" : "PC"
        }
    }
    var s = a(3)
      , n = a(2)
      , r = {
        defi: 2,
        isAutoMute: 0,
        isAutoPlay: !(n.weixin && !n.wifi),
        isPreload: 1,
        Barrage: 0,
        hideBarrage: 0,
        nextBtn: 1,
        definition: 1,
        playbackRate: 1
    }
      , o = "3.7.0";
    e.exports = i
}
, function(e, t) {
    var a = function(e, t, a) {
        var i, s;
        switch (e) {
        case "simple":
        case "IPhone":
        case "minBase":
        case "base":
            i = ['<div class="hv_box hv_box_hide hv_box_mb">', '<div class="hv_play" style="background: none;"><video style="width:100%;height:100%;" controls preload="auto" poster="" class="html5video video-js"></video></div>', '<div class="hv_play_bg js-pannel" style="display:block;"></div>', '<div class="hv_play_poster" style="display:none;"></div>', '<div class="hv_ico_loading">', '<div class="logo"></div>', '<div class="bt_wrap">', '<span class="newLoading"></span>', '<span class="loadingText"></span>', "</div>", "</div>", '<div class="hv_ico_pasued" style="display:none;"><span></span></div>', '<div class="hv_pop js-poptip-del" style="display:none;">', '<div class="hv_pop_wrap"><div class="hv_pop_cnt"></div></div>', "</div>", '<div class="hv_play_bg js-bg" style="display:none;"></div>', "</div>"].join("");
            break;
        default:
        }
        return 1 == a && (i = i.replace(/http/g, "https")),
        i
    }
      , i = function(e) {
        var t;
        switch (e) {
        case "live":
        case "base":
        case "minBase":
        default:
            t = ""
        }
        return t
    }
      , s = function(e, t) {
        var a;
        switch (e) {
        case "live":
        case "base":
        case "minBase":
        default:
            a = '';
        }
        return 1 == t && (a = a.replace(/http/g, "https")),
        a
    };
    e.exports = {
        getTpl: a,
        getCss: s,
        getIECss: i
    }
}
, function(e, t, a) {
    function i() {}
    var s = a(33)
      , n = a(3)
      , r = a(21);
    n.extend(i, s);
    var o = {
        getToken: function(e, t, a) {
            var i = r.PROTOCAL + r.HOST_NAME.PLAYER_PC_LETV_COM + "/mms/authenticate?"
              , s = {
                pid: this.playerData.vinfo.pid || "",
                vid: this.playerData.vinfo.vid || "",
                cid: this.playerData.vinfo.cid || "",
                storepath: e,
                region: this.manager.listener.get(r.REGION)
            }
              , o = this;
            this.manager.log.pushLog("getUserInfo: "),
            n.getJSON({
                url: i,
                data: s,
                log: this.manager.log,
                maxCount: 1,
                success: function(e) {
                    o.jsonp = null,
                    e = e.msgs,
                    o.manager.log.pushLog("user.getToken Suc: " + n.JSONTOStr(e)),
                    e.error && a && a(),
                    t && t(e.token)
                },
                fail: function() {
                    o.jsonp = null,
                    o.manager.log.pushLog("user.getToken Fail"),
                    a && a()
                }
            })
        }
    };
    n.merge(i.prototype, o),
    e.exports = i
}
, function(e, t, a) {
    function i() {}
    var s = a(23)
      , n = a(21)
      , r = a(3);
    r.extend(i, s);
    var o = {
        init: function() {
            this.playerData = this.manager.playerData
        },
        getUserInfo: function(e) {
            var t = n.PROTOCAL + n.HOST_NAME.PLAYER_PC_LETV_COM + "/mms/userinfo"
              , a = this;
            this.manager.log.pushLog("getUserInfo: "),
            r.getJSON({
                url: t,
                log: this.manager.log,
                data: {
                    region: this.manager.listener.get(n.REGION)
                },
                maxCount: 1,
                success: function(t) {
                    a.manager.log.pushLog("getUserInfo Suc: " + r.JSONTOStr(t));
                    var i = t.msgs;
                    i ? a.manager.listener.set(n.USER_INFO, a.formatUserInfo(i)) : a.manager.listener.set(n.USER_INFO, null),
                    e && e()
                },
                fail: function() {
                    a.manager.log.pushLog("getUserInfo Fail"),
                    a.info = null,
                    e && e()
                }
            })
        },
        formatUserInfo: function(e) {
            if (!e || !e.ssouid)
                return null;
            e.isvip = 0 != e.vipinfo.length,
            e.vipInfoObj = {};
            for (var t = 0, a = e.vipinfo.length; t < a; t++)
                e.vipInfoObj[e.vipinfo[t].productId] = e.vipinfo[t];
            return e.isMovieVip = e.vipInfoObj[1] && e.vipInfoObj[1].isvip || e.vipInfoObj[9] && e.vipInfoObj[9].isvip,
            e
        }
    };
    r.merge(i.prototype, o),
    e.exports = i
}
, function(e, t, a) {
    var i = a(23)
      , s = a(6)
      , n = a(3)
      , r = (a(21),
    a(2))
      , o = function(e) {
        if (!e)
            throw "no video element";
        this.video = e
    };
    n.extend(o, i);
    var l = {
        init: function() {
            this.playerData = this.manager.playerData,
            this.seekId = null,
            this.preparePlayTimeout = null,
            this.eventFlag = {
                error: !1
            },
            this.fullScreenObj = n.checkFullScreenFn(this.video),
            this.addEvent()
        },
        addEvent: function() {
            return;
			var e = ["webkitendfullscreen", "canplaythrough", "stalled", "play", "playing", "pause", "waiting", "seeking", "seeked", "progress", "canplay", "ended", "durationchange", "loadstart", "loadeddata", "loadedmetadata", "timeupdate", "error"];
            n.each.call(this, e, function(e, t) {
                s(this.video).on(t, function(e) {
                    if (("error" != e.type || null != this.video.getAttribute("src") && 0 == this.getCurrentTime()) && ("waiting" != e.type && "stalled" != e.type || !this.playerData.videoFlag.preparePlay || this.playerData.videoFlag.startPlay)) {
                        if ("undefined" != typeof this.eventFlag[e.type]) {
                            if (this.eventFlag[e.type])
                                return;
                            this.eventFlag[e.type] = !0
                        }
                        this.manager.evt.trigger(e.type)
                    }
                }, this)
            })
        },
        eventPublicHandle: function(e) {
            this.manager.isDebug && "progress" != e && this.manager.log.pushLog("timeupdate" == e ? e + this.getCurrentTime() : e);
            var t = r.iPhone && r.iosVersion >= 10 && r.safari;
            ("playing" == e && t || "play" == e && !t) && !this.playerData.videoFlag.startPlay && (this.playerData.videoFlag.startPlay = !0,
            this.manager.log.pushLog("vjs_startPlay"),
            this.manager.evt.trigger("vjs_startPlay")),
            "loadstart" != e || this.playerData.videoFlag.preparePlay || this.playerData.videoFlag.startPlay || (clearTimeout(this.preparePlayTimeout),
            this.playerData.videoFlag.preparePlay = !0,
            this.manager.log.pushLog("vjs_preparPlay"),
            this.manager.evt.trigger("vjs_preparPlay"))
        },
        setPreload: function(e) {
            this.video.setAttribute("preload", 1 ? "auto" : "none")
        },
        setPlayInLine: function() {
            this.video.setAttribute("webkit-playsinline", "true"),
            this.video.setAttribute("playsinline", "true")
        },
        setMute: function() {
            this.video.muted = !0
        },
        setSrc: function(e) {	 
			//document.getElementById('j-player').innerHTML = '<video style="width:100%;height:100%;" controls="" preload="none" poster="" class="html5video video-js IIV" src="'+ e +'"></video>';
			//return;
			this.manager.log.pushLog("set videoSrc: " + e),
            this.playerData.videoFlag.preparePlay = !1,
            this.playerData.videoFlag.startPlay = !1,
            this.eventFlag.error = !1;
            try {
                this.video.removeAttribute("src")
            } catch (t) {}
            try {
                this.video.src = e
            } catch (t) {
                this.video.setAttribute("src", e)
            }							   
            clearTimeout(this.preparePlayTimeout),
            this.preparePlayTimeout = setTimeout(n.bind(function() {
                this.playerData.videoFlag.startPlay || (this.playerData.videoFlag.preparePlay = !0,
                this.manager.log.pushLog("vjs_preparPlay(timeOut)"),
                this.manager.evt.trigger("vjs_preparPlay"))
            }, this), 5e3)

        },
        setIIV: function() {
			s(this.video).addClass("IIV")
        },
        setPlayRate: function(e) {
            this.video.playbackRate = e
        },
        getSrc: function() {
            return this.video.src || ""
        },
        removeSrc: function() {
            try {
                this.video.pause(),
                this.video.removeAttribute("src")
            } catch (e) {}
        },
        play: function() {
            this.video.play()
        },
        pause: function() {
            this.video.pause()
        },
        seek: function(e) {
            if (!isNaN(e)) {
                this.seekId && clearTimeout(this.seekId);
                var t = this
                  , a = this.video.seekable;
                a ? 1 === a.length && a.end(0) > e ? this.video.currentTime = e : this.seekId = setTimeout(function() {
                    t.seek(e)
                }, 1e3) : console.log("no seekable")
            }
        },
        getCurrentTime: function() {
            try {
                return this.video.currentTime
            } catch (e) {
                return 0
            }
        },
        getBuffered: function() {
            for (var e = this.video.buffered, t = e.length, a = 0, i = []; a < t; )
                i.push({
                    start: e.start(a),
                    end: e.end(a)
                }),
                a++;
            return i
        },
        getDuration: function() {
            return this.video.duration
        },
        setCrossOrigin: function(e) {
            this.video.crossOrigin = e
        },
        changeFullScreen: function(e) {
            try {
                e ? this.fullScreenObj.requestEl[this.fullScreenObj.requestFn]() : this.fullScreenObj.cancelEl[this.fullScreenObj.cancelFn]()
            } catch (t) {}
        }
    };
    n.merge(o.prototype, l),
    e.exports = o
}
, function(e, t, a) {
    var i = a(23)
      , s = a(3)
      , n = a(2)
      , r = a(21)
      , o = function(e) {
        this.baseVideo = e
    };
    s.extend(o, i);
    var l = {
        init: function() {
            this.playerData = this.manager.playerData,
            this.currentTime = 0,
            this.seekAutoTime = null,
            this.baseVideo.setPreload(this.playerData.config.isPreload),
            n.iPhone && this.baseVideo.setIIV(),
            n.Notplayinline || this.baseVideo.setPlayInLine(),
            this.playerData.config.isAutoMute && this.baseVideo.setMute(),
            this.sendCVEvent = !1,
            this.cancellationTime = null;
            var e = ["webkitendfullscreen", "canplaythrough", "stalled", "play", "playing", "pause", "waiting", "seeking", "seeked", "progress", "canplay", "ended", "durationchange", "loadstart", "loadeddata", "loadedmetadata", "timeupdate", "error"];
            this.manager.listener.on(r.IS_AD, function(t, a) {
                a ? s.each.call(this, e, function(e, t) {
                    this.manager.evt.off(t, this.onVideoEvent, this)
                }) : s.each.call(this, e, function(e, t) {
                    this.manager.evt.on(t, this.onVideoEvent, this)
                })
            }, this),
            this.manager.listener.on(r.PLAY_STATE, this.onPlayStateChange, this)
        },
        onPlayStateChange: function(e, t) {
            "init" != t && "changeDefi" != t && "stop" != t || (clearInterval(this.seekAutoTime),
            this.currentTime = 0)
        },
        onVideoEvent: function(e) {
            var t = e.type;
            if ("progress" != t) {
                var a = "timeupdate" == t ? t + this.getCurrentTime() : t;
                this.manager.debug(a)
            }
            switch (this.baseVideo.eventPublicHandle(t),
            t) {
            case "durationchange":
                this.gdur = this.getDuration(),
                "none" == this.manager.playerData.tryLookType && (this.manager.log.pushLog("vjs_durationChange video====" + this.gdur),
                this.manager.evt.trigger("vjs_durationChange", this.gdur));
                break;
            case "webkitendfullscreen":
                this.manager.evt.trigger("vjs_webkitendfullscreen");
                break;
            case "canplaythrough":
                this.manager.evt.trigger("vjs_canplaythrough");
                break;
            case "stalled":
                this.manager.evt.trigger("vjs_stalled");
                break;
            case "play":
                var i = this.manager.listener.get(r.PLAY_STATE);
                if ("seeking" == i || "changeDefi" == i)
                    return;
                this.manager.evt.trigger("vjs_play");
                break;
            case "playing":
                this.manager.evt.trigger("vjs_playing");
                break;
            case "pause":
                this.manager.evt.trigger("vjs_pause");
                break;
            case "waiting":
                this.manager.evt.trigger("vjs_waiting");
                break;
            case "seeking":
                var n = this;
                clearInterval(this.seekAutoTime),
                this.seekAutoTime = setInterval(function() {
                    if (Math.abs(n.currentTime - n.getCurrentTime()) > 1) {
                        if (clearInterval(n.seekAutoTime),
                        "stop" == n.manager.listener.get(r.PLAY_STATE))
                            return;
                        n.play(),
                        setTimeout(function() {
                            n.manager.evt.trigger("vjs_play")
                        }, 0)
                    }
                }, 200);
                break;
            case "seeked":
                break;
            case "progress":
                this.manager.evt.trigger("vjs_progress");
                break;
            case "canplay":
                this.manager.evt.trigger("vjs_canplay");
                break;
            case "ended":
                this.manager.evt.trigger("vjs_ended");
                break;
            case "loadstart":
                this.manager.evt.trigger("vjs_loadstart");
                break;
            case "loadeddata":
                this.manager.evt.trigger("vjs_loadeddata");
                break;
            case "loadedmetadata":
                this.manager.evt.trigger("vjs_loadedmetadata");
                break;
            case "timeupdate":
                !this.sendCVEvent && this.getCurrentTime().toFixed(1) > .2 && (this.sendCVEvent = !0,
                this.manager.log.pushLog("vjs_sendCV"),
                this.manager.evt.trigger("vjs_sendCV")),
                this.manager.evt.trigger("vjs_timeupdate");
                break;
            case "error":
                s.now() - this.cancellationTime > 216e5 ? this.manager.evt.trigger("vjs_cancellation") : this.manager.evt.trigger("vjs_error")
            }
        },
        setSrc: function(e) {
            this.cancellationTime = s.now(),
            this.baseVideo.setSrc(e),
            this.sendCVEvent = !1
        },
        setPlayRate: function(e) {
            this.baseVideo.setPlayRate(e)
        },
        getSrc: function() {
            return this.baseVideo.getSrc()
        },
        play: function() {
            this.baseVideo.play()
        },
        replay: function() {
            this.baseVideo.play()
        },
        pause: function() {
            this.baseVideo.pause()
        },
        seek: function(e) {
            e = Math.max(e, 1),
            this.gdur && (e = Math.min(e, this.gdur - 5)),
            e = Math.round(e);
            var t = this.manager.listener.get(r.PLAY_STATE);
            return Math.abs(e - this.getCurrentTime()) <= 1 ? (this.play(),
            void ("changeDefi" == t && this.manager.evt.trigger("vjs_play"))) : void ("play" == t || "changeDefi" == t ? (this.manager.evt.one("pause", function() {
                this.manager.evt.trigger("vjs_seeking"),
                this.currentTime = this.getCurrentTime(),
                this.baseVideo.seek(e)
            }, this),
            this.pause()) : (this.manager.evt.trigger("vjs_seeking"),
            this.currentTime = this.getCurrentTime().toFixed(2),
            this.baseVideo.seek(e)))
        },
        getCurrentTime: function() {
            return this.baseVideo.getCurrentTime()
        },
        getBuffered: function() {
            for (var e = this.baseVideo.getBuffered(), t = this.getCurrentTime(), a = 0, i = e.length; a < i; a++)
                if (e[a].end - t >= 0)
                    return e[a].end
        },
        getDuration: function() {
            var e = this.baseVideo.getDuration();
            return isFinite(e) ? e : this.manager.playerData.vinfo.gdur
        },
        release: function() {},
        changeFullScreen: function(e) {
            this.baseVideo.changeFullScreen(e)
        }
    };
    s.merge(o.prototype, l),
    e.exports = o
}
, function(e, t, a) {
    var i = a(23)
      , s = a(3)
      , n = a(2)
      , r = a(21)
      , o = function(e) {
        this.baseVideo = e
    };
    s.extend(o, i);
    var l = {
        init: function() {
            this.playerData = this.manager.playerData,
            this.baseVideo.setPreload(this.playerData.config.isPreload),
            n.iPhone && (n.weixin || n.qq) && this.baseVideo.setPlayInLine(),
            this.sendCVEvent = !1,
            this.src = "",
            this.p2pVideo = new window.CdeMediaPlayer(null,this.baseVideo.video,null),
            this.addVideoEvent(),
            this.manager.listener.on(r.PLAY_STATE, this.onPlayStateChange, this),
            this.errMsg = "调用p2p接口出错"
        },
        onPlayStateChange: function(e, t) {
            "init" != t && "changeDefi" != t || (this.sendCVEvent = !1)
        },
        addVideoEvent: function() {
            this.p2pVideo.onvideosrc = s.bind(function() {
                this.manager.log.pushLog("p2p_videosrc"),
                this.manager.evt.trigger("vjs_loadstart")
            }, this),
            this.p2pVideo.ongslbcomplete = s.bind(function() {
                this.manager.log.pushLog("p2p_gslbcomplete"),
                this.manager.pingback.sendPlayAction("gslb", {
                    ut: 0,
                    ry: 0
                })
            }, this),
            this.p2pVideo.onprepared = s.bind(function() {
                this.manager.log.pushLog("p2p_prepared"),
                this.gdur = this.getDuration(),
                "none" == this.manager.playerData.tryLookType && (this.manager.log.pushLog("vjs_durationChange video====" + this.gdur),
                this.manager.evt.trigger("vjs_durationChange", this.gdur)),
                this.playerData.videoFlag.preparePlay || this.playerData.videoFlag.startPlay || (this.manager.log.pushLog("vjs_preparPlay"),
                this.playerData.videoFlag.preparePlay = !0,
                this.manager.evt.trigger("vjs_preparPlay"))
            }, this),
            this.p2pVideo.onplay = s.bind(function() {
                this.manager.log.pushLog("p2p_play"),
                this.playerData.videoFlag.startPlay || (this.playerData.videoFlag.startPlay = !0,
                this.manager.log.pushLog("vjs_startPlay"),
                this.manager.evt.trigger("vjs_startPlay")),
                this.manager.evt.trigger("vjs_play")
            }, this),
            this.p2pVideo.onpause = s.bind(function() {
                var e = this.manager.listener.get(r.PLAY_STATE);
                "ended" != e && "stop" != e && (this.manager.log.pushLog("p2p_pause"),
                this.manager.evt.trigger("vjs_pause"))
            }, this),
            this.p2pVideo.ontimeupdate = s.bind(function() {
                !this.sendCVEvent && this.getCurrentTime().toFixed(1) > .2 && (this.sendCVEvent = !0,
                this.manager.log.pushLog("vjs_sendCV"),
                this.manager.evt.trigger("vjs_sendCV")),
                this.manager.evt.trigger("vjs_timeupdate")
            }, this),
            this.p2pVideo.onbufferstart = s.bind(function() {
                this.manager.log.pushLog("p2p_bufferstart"),
                this.manager.evt.trigger("vjs_p2pBufferstart")
            }, this),
            this.p2pVideo.onbufferend = s.bind(function() {
                this.manager.log.pushLog("p2p_bufferend"),
                this.manager.evt.trigger("vjs_p2pBufferend")
            }, this),
            this.p2pVideo.oncomplete = s.bind(function() {
                this.manager.log.pushLog("p2p_complete"),
                this.manager.evt.trigger("vjs_ended")
            }, this),
            this.p2pVideo.onerror = s.bind(function(e, t) {
                if ("30404" == e)
                    this.manager.evt.trigger("vjs_cancellation");
                else {
                    var a = this.manager.pingback.getUUID();
                    this.manager.log.pushLog("p2p_error: uuid:" + a + "===errorCode:" + e + "===" + t);
                    try {
                        this.manager.log.pushLog(window.CdeMediaHelper.getCDELog())
                    } catch (i) {}
                    this.release(),
                    this.manager.evt.trigger("vjs_p2pError")
                }
            }, this)
        },
        setSrc: function(e) {
            this.playerData.videoFlag.preparePlay = !1,
            this.playerData.videoFlag.startPlay = !1,
            this.src = e,
            this.release();
            try {
                this.manager.log.pushLog("call p2pSetSrc: " + e),
                this.p2pVideo.setSource(e)
            } catch (t) {
                this.manager.log.pushLog("call p2pSetSrc Error:"),
                this.p2pVideo.onerror("", "")
            }
        },
        getSrc: function() {
            return this.src
        },
        play: function() {
            try {
                this.manager.log.pushLog("call p2pPlay"),
                this.p2pVideo.play()
            } catch (e) {
                this.manager.log.pushLog("call p2pPlay Error:" + e.toString()),
                this.p2pVideo.onerror("", this.errMsg)
            }
        },
        replay: function() {
            try {
                this.manager.log.pushLog("call p2pRePlay"),
                this.p2pVideo.replay()
            } catch (e) {
                this.manager.log.pushLog("call p2pRePlay Error:" + e.toString()),
                this.p2pVideo.onerror("", this.errMsg)
            }
        },
        pause: function() {
            try {
                this.manager.log.pushLog("call p2pPause"),
                this.p2pVideo.pause()
            } catch (e) {
                this.manager.log.pushLog("call p2pPause Error:" + e.toString()),
                this.p2pVideo.onerror("", this.errMsg)
            }
        },
        seek: function(e) {
            if (e = Math.max(e, 1),
            e = Math.min(e, this.playerData.vinfo.gdur - 5),
            e = Math.round(e),
            Math.abs(e - this.getCurrentTime()) <= 1)
                return void this.play();
            try {
                this.manager.log.pushLog("call p2pSeek: " + e),
                this.p2pVideo.seek(e)
            } catch (t) {
                this.manager.log.pushLog("call p2pSeek Error:" + t.toString()),
                this.p2pVideo.onerror("", this.errMsg)
            }
        },
        getCurrentTime: function() {
            try {
                var e = this.p2pVideo.getCurrentPosition();
                return e
            } catch (t) {
                return this.manager.log.pushLog("call p2pGetCurTime Error:" + t.toString()),
                this.p2pVideo.onerror("", this.errMsg),
                0
            }
        },
        getBuffered: function() {
            try {
                var e = this.p2pVideo.getCurrentBuffered();
                return Math.max(e, 0)
            } catch (t) {
                return this.manager.log.pushLog("call p2pGetBufferTime Error:" + t.toString()),
                this.p2pVideo.onerror("", this.errMsg),
                0
            }
        },
        getDuration: function() {
            try {
                var e = this.p2pVideo.getDuration();
                return this.manager.log.pushLog("call p2pGetDuration: " + e),
                e
            } catch (t) {
                return this.manager.log.pushLog("call p2pGetDuration Error:" + t.toString()),
                this.p2pVideo.onerror("", this.errMsg),
                0
            }
        },
        release: function() {
            try {
                this.manager.log.pushLog("call p2pRelease"),
                this.p2pVideo.release()
            } catch (e) {
                this.manager.log.pushLog("call p2pRelease Error:" + e.toString())
            }
        },
        changeFullScreen: function(e) {
            this.baseVideo.changeFullScreen(e)
        }
    };
    s.merge(o.prototype, l),
    e.exports = o
}
, function(e, t, a) {
    function i(e) {
        this.fullScreen = e
    }
    var s = a(38)
      , n = a(39)
      , r = a(40)
      , o = a(41)
      , l = a(21)
      , d = a(2)
      , h = a(3);
    h.extend(i, s);
    var c = {
        init: function() {
            this.mms = new n,
            this.gslb = new r,
            this.history = new o,
            this.ad = null,
            this.playerData = this.manager.playerData,
            this.mmsData = null,
            this.mmsRetryTime = 0,
            this.gslbUrls = null,
            this.gslbUrlsIndex = 0,
            this.waitingTime = null,
            this.isFirstPlay = !0,
            this.curDefi = 0,
            this.manager.register(this.mms),
            this.manager.register(this.gslb),
            this.manager.register(this.history),
            this.manager.evt.on("vjs_mmsSucc", this.onMmsSucc, this),
            this.manager.evt.on("vjs_gslbSuccess", this.onGslbSucc, this),
            this.manager.evt.on("vjs_gslbFail", this.onGslbFail, this),
            this.manager.evt.on(l.EVENT.PLAYER_COMMAND, this.onPlayerCommand, this),
            this.manager.evt.on("vjs_preparPlay", this.onPreparPlay, this),
            this.manager.evt.on("vjs_startPlay", this.onStartPlay, this),
            this.manager.evt.on("vjs_sendCV", this.sendCV, this),
            this.manager.evt.on("vjs_p2pUrlSucc", this.onP2pUrlSucc, this),
            this.manager.listener.on(l.PLAY_STATE, function(e, t) {
                if ("init" == t)
                    this.ad && this.ad.destoryAd(),
                    this.manager.evt.off("vjs_loadstart", this.onLoadstart, this),
                    this.manager.pingback.stopHeartRecord(),
                    this.changeTrylook("none", 0),
                    this.mmsData = null,
                    this.mmsRetryTime = 0,
                    this.gslbUrls = null,
                    this.gslbUrlsIndex = 0,
                    this.isFirstPlay = !0,
                    this.manager.curVideo.release();
                else if ("ended" == t)
                    this.isFirstPlay = !0,
                    this.manager.pingback.stopHeartRecord(),
                    this.manager.pingback.sendPlayAction("end"),
                    this.manager.evt.trigger(l.EVENT.PLAYER_CALLBACK, "PLAYER_VIDEO_COMPLETE", {
                        continuePlay: !0,
                        fullscreen: 0 != this.manager.listener.get(l.FULLSCREEN_STATE),
                        id: this.playerData.vinfo.vid,
                        nextvid: this.playerData.vinfo.nextvid,
                        recommendvideo: 0
                    });
                else if ("play" == t)
                    if (this.isFirstPlay) {
                        if (this.isFirstPlay = !1,
                        this.playerData.config.Barrage && this.playerData.config.hideBarrage) {
                            var a = {};
                            a.alphaBr = localStorage.getItem("alphaBr") ? localStorage.getItem("alphaBr") : 100,
                            a.densityBr = localStorage.getItem("densityBr") ? localStorage.getItem("densityBr") : 2,
                            a.banRoll = localStorage.getItem("banRoll") ? localStorage.getItem("banRoll") : 1,
                            a.banBottom = localStorage.getItem("banBottom") ? localStorage.getItem("banBottom") : 1,
                            a.banTop = localStorage.getItem("banTop") ? localStorage.getItem("banTop") : 1;
                            var i = localStorage.getItem("barrgeState") ? localStorage.getItem("barrgeState") : "true";
                            this.manager.evt.trigger(l.EVENT.PLAYER_CALLBACK, "videoStart", {
                                barrageJs: "true" == i ? 1 : 0,
                                barrageSetting: a
                            })
                        }
                        this.manager.evt.trigger(l.EVENT.PLAYER_CALLBACK, "PLAYER_VIDEO_PLAY", {
                            id: this.playerData.vinfo.vid
                        })
                    } else
                        this.manager.evt.trigger(l.EVENT.PLAYER_CALLBACK, "PLAYER_VIDEO_RESUME", {
                            id: this.playerData.vinfo.vid
                        });
                else
                    "pause" == t && "MPlayer" == this.playerData.pname && this.manager.evt.trigger(l.EVENT.PLAYER_CALLBACK, "PLAYER_VIDEO_PAUSE", {
                        id: this.playerData.vinfo.vid
                    });
                this.manager.log.pushLog("stateChange: " + t)
            }, this),
            this.manager.listener.on(l.IS_AD, function(e, t) {
                this.manager.log.pushLog("IS_AD:" + t),
                t ? this.manager.curVideo = this.ad.adVideo : this.manager.curVideo = this.manager.coreVideo
            }, this),
            this.manager.evt.on("vjs_play vjs_pause vjs_ended vjs_seeking vjs_waiting vjs_playing vjs_cancellation vjs_error", this.onVideoEvent, this),
            this.manager.listener.set(l.FULLSCREEN_STATE, 0),
            this.lanFit = h.bind(this.manager.lanFit.fit, this.manager.lanFit),
            this.startPlayProcesses()
        },
        startPlayProcesses: function(e) {
            this.manager.curVideo.pause(),
            setTimeout(h.bind(function() {
                e ? this.mmsRetryTime++ : this.manager.listener.set(l.PLAY_STATE, "init"),
                this.mms.getMms()
            }, this), 0)
        },
        onPlayerCommand: function(e) {
            var t = e.args[0];
            switch (this.manager.log.pushLog("playerCommand: " + t + ";args: " + h.JSONTOStr(e.args[1])),
            t) {
            case "play":
                this.manager.curVideo.play();
                break;
            case "pause":
                this.manager.curVideo.pause();
                break;
            case "replay":
                this.manager.curVideo.replay();
                break;
            case "seek":
                var a = e.args[1];
                if ("none" != this.playerData.tryLookType && this.checkTryLook(a))
                    return;
                this.manager.curVideo.seek(a),
                this.manager.evt.trigger(l.EVENT.PLAYER_CALLBACK, "PLAYER_SEEK", {
                    id: this.playerData.vinfo.vid,
                    time: a
                });
                break;
            case "changeDefi":
                var i = e.args[1];
                "init" != this.manager.listener.get(l.PLAY_STATE) && this.history.flush(this.manager.curVideo.getCurrentTime(), !0),
                this.manager.listener.set(l.PLAY_STATE, "changeDefi"),
                this.playVideo(i);
                break;
            case "playNext":
                var s = Boolean(e.args[1]);
                this.manager.evt.trigger(l.EVENT.PLAYER_CALLBACK, "PLAYER_PLAY_NEXT", {
                    id: this.playerData.vinfo.vid,
                    nextvid: this.playerData.vinfo.nextvid,
                    fullscreen: !1,
                    active: s
                });
                break;
            case "reload":
                this.startPlayProcesses();
                break;
            case "changFullScreen":
                var n = e.args[1]
                  , r = e.args[2];
                2 != n ? this.manager.evt.trigger(l.EVENT.PLAYER_CALLBACK, "CHANGE_FULLSCREEN", {
                    flag: n,
                    isActiveBehavior: r
                }) : this.fullScreen.changeFullScreen({
                    type: "system",
                    targetState: 2
                });
                break;
            case "changePlaySpeed":
                var o = e.args[1];
                this.manager.curVideo.setPlayRate(o)
            }
        },
        onVideoEvent: function(e) {
            var t = e.type
              , a = "";
            switch (t) {
            case "vjs_play":
                a = "play";
                break;
            case "vjs_pause":
                a = "pause";
                break;
            case "vjs_ended":
                if ("none" != this.playerData.tryLookType)
                    return;
                a = "ended";
                break;
            case "vjs_seeking":
                a = "seeking";
                break;
            case "vjs_waiting":
                this.waitingTime = h.now();
                break;
            case "vjs_playing":
                this.waitingTime && (this.manager.pingback.sendPlayAction("block", {
                    ut: h.now() - this.waitingTime
                }),
                this.waitingTime = null);
                break;
            case "vjs_cancellation":
                this.mmsRetryTime++,
                this.mms.getMms();
                break;
            case "vjs_error":
                if ("" == d.supportM3U8 && !d.forceMp4)
                    return this.manager.log.pushLog("m3u8 fail.turn to mp4"),
                    h.setCookie("vjs-supportM3U8", "0", {
                        expires: 7
                    }),
                    d.supportM3U8 = "0",
                    this.mmsRetryTime++,
                    void this.mms.getMms();
                var i = this.gslbUrls[this.gslbUrlsIndex++];
                i ? this.manager.curVideo.setSrc(i) : ("ios" == this.playerData.videoType ? this.sendError(l.ERROR_CODE.URL_NOT_SUPPORT_M3U8) : this.sendError(l.ERROR_CODE.URL_NOT_SUPPORT_MP4),
                this.manager.log.pushLog("videoSrc: " + this.manager.coreVideo.getSrc()),
                this.manager.evt.trigger(l.EVENT.PLAYER_CALLBACK, "PLAYER_VIDEO_PAUSE"))
            }
            a && this.manager.listener.set(l.PLAY_STATE, a)
        },
        onMmsSucc: function(e) {
            this.mmsData = e.args[0];
            var t = {
                350: 1,
                1000: 2,
                1300: 3,
                "720p": 4
            };
            this.curDefi = t[this.mmsData.curVType],
            this.playerData.vinfo.curVtype = this.mmsData.movieVO[this.curDefi].vtype,
            this.mmsRetryTime < 1 ? (h.merge(this.playerData.vinfo, this.mmsData.vinfo),
            this.manager.log.pushLog("vinfo: " + h.JSONTOStr(this.playerData.vinfo)),
            this.manager.evt.trigger("vjs_vinfoReady"),
            this.manager.log.pushLog("vjs_vinfoReady"),
            this.manager.evt.trigger("vjs_setPoster", this.playerData.flashVar.picStartUrl || this.playerData.vinfo.poster),
            this.manager.evt.trigger("vjs_initDefiList", this.mmsData.movieVO),
            this.gslb.setMovieVO(this.mmsData.movieVO),
            !this.mmsData.userInfo && this.playerData.validateInfo.ssouid ? this.manager.user.getUserInfo(h.bind(this.onUserInfoSuccess, this)) : (this.manager.listener.set(l.USER_INFO, this.mmsData.userInfo),
            this.onUserInfoSuccess())) : (this.gslb.setMovieVO(this.mmsData.movieVO),
            this.playVideo())
        },
        onUserInfoSuccess: function() {
            this.manager.evt.trigger(l.EVENT.PLAYER_CALLBACK, "PLAYER_INIT", {
                id: this.playerData.vinfo.vid
            }),
            this.manager.log.pushLog("上报 vv"),
            this.manager.pingback.sendPlayAction("init", {
                cdev: "-",
                caid: "-"
            }),
            this.manager.evt.trigger(l.EVENT.PLAYER_CALLBACK, "PLAYER_GET_NEXT_VID", {
                nextvid: this.playerData.vinfo.nextvid ? this.playerData.vinfo.nextvid : ""
            }),
            this.checkVideoAuth() || (this.manager.log.pushLog("trylooktype====" + this.playerData.tryLookType + "===time===" + this.playerData.tryLookTime),
            "none" != this.playerData.tryLookType && (this.manager.log.pushLog("vjs_durationChange vinfo====" + this.playerData.vinfo.gdur),
            this.manager.evt.trigger("vjs_durationChange", this.playerData.vinfo.gdur)),
            this.history.initData(h.bind(this.onHistorySucc, this)))
        },
        onHistorySucc: function() {
            if (this.manager.listener.set(l.IS_AD, !1),
            this.ad)
                try {
                    this.manager.listener.set(l.IS_AD, !0),
                    this.ad.refreshAd()
                } catch (e) {
                    this.manager.log.pushLog("ad error:" + e.toString()),
                    this.playVideo()
                }
            else {
                var t = a(43);
                if (t)
                    try {
                        this.manager.evt.on("vjs_adEnded", function() {
                            this.playVideo()
                        }, this),
                        this.ad = new t(this.manager.coreVideo.baseVideo),
                        this.manager.register(this.ad),
                        this.manager.listener.set(l.IS_AD, !0),
                        this.ad.refreshAd()
                    } catch (e) {
                        this.manager.log.pushLog("ad error:" + e.toString()),
                        this.playVideo()
                    }
                else
                    this.playVideo()
            }
        },
        onGslbSucc: function(e) {
            this.manager.pingback.sendPlayAction("gslb", {
                ut: e.args[2].responseTime,
                ry: e.args[2].retryCount
            }),
            this.mmsRetryTime = 0,
            this.curDefi = e.args[1],
            this.manager.evt.trigger("vjs_videoRateChanged", this.curDefi),
            this.manager.evt.one("vjs_loadstart", this.onLoadstart, this),
            this.gslbUrls = e.args[0],
            this.gslbUrlsIndex = 0;
            var t = this.gslbUrls[this.gslbUrlsIndex++];
            this.manager.curVideo.setSrc(t)
        },
        onGslbFail: function() {
            this.mmsRetryTime < 1 ? (this.mmsRetryTime++,
            this.mms.getMms()) : this.sendError(l.ERROR_CODE.GSLB_ERROR)
        },
        onP2pUrlSucc: function(e) {
            this.curDefi = e.args[1],
            this.manager.evt.trigger("vjs_videoRateChanged", this.curDefi),
            this.manager.evt.one("vjs_loadstart", this.onLoadstart, this);
            var t = e.args[0];
            this.manager.curVideo.setSrc(t)
        },
        checkVideoAuth: function() {
            if (1 == this.playerData.vinfo.authtype)
                return this.manager.evt.trigger("vjs_showPopTip", "authBan"),
                !0;
            if (2 == this.playerData.vinfo.authtype)
                return this.manager.evt.trigger("vjs_showPopTip", "vikiban"),
                !0;
            if (this.playerData.vinfo.firstlook)
                return this.manager.evt.trigger("vjs_showPopTip", "firstLook"),
                this.manager.evt.trigger(l.EVENT.PLAYER_CALLBACK, "PLAYER_FIRSTLOOK", {
                    htime: 0,
                    isH5: !0
                }),
                !0;
            if (this.playerData.vinfo.ispay) {
                var e = this.manager.listener.get(l.USER_INFO)
                  , t = this.playerData.validateInfo || {};
                if (e && "1" == t.isForbidden)
                    return this.sendError(l.ERROR_CODE.USER_ABNORMAL),
                    !0;
                if (!e || 1 != t.status) {
                    if (0 == this.playerData.vinfo.payTrylookTime) {
                        var a = e ? "payLoginMember" : "paynotLoginMember";
                        return this.manager.evt.trigger("vjs_showPopTip", a),
                        this.manager.evt.trigger(l.EVENT.PLAYER_CALLBACK, "displayTrylook", {
                            trylookTime: 0,
                            userInfo: e,
                            type: a
                        }),
                        !0
                    }
                    this.changeTrylook("vip", this.playerData.vinfo.payTrylookTime)
                }
                return !1
            }
            var a, i = this.playerData.config.splatId, s = this.playerData.vinfo, n = s.gdur, r = 0;
            if (s.appGuideTime > 0)
                r = s.appGuideTime,
                a = "flashvar";
            else if (s.cutoff_p && s.cutoff_p.length > 0)
                for (var o = 0, d = s.cutoff_p.length; o < d; o++)
                    if (i == s.cutoff_p[o]) {
                        r = s.cutoff_t,
                        a = "mms";
                        break
                    }
            return r > 0 && n > 60 * r && (this.changeTrylook("appGuide", r),
            this.manager.evt.trigger(l.EVENT.PLAYER_CALLBACK, "APP_GUIDE", {
                type: a,
                cutoffTime: r
            })),
            !1
        },
        playVideo: function(e) {
            this.manager.listener.get(l.IS_AD) && this.manager.listener.set(l.IS_AD, !1);
            var t, a = this.mmsData.movieVO;
            if (e && a[e])
                t = !0;
            else {
                t = !1;
                var i = this.curDefi || this.playerData.config.defi;
                i && a[i] ? e = i : a[2] ? e = "2" : a[1] ? e = "1" : a[3] && (e = "3")
            }
            this.curDefi = e,
            this.manager.log.pushLog("plavVideo Defi: " + e),
            this.playerData.vinfo.curVtype = a[e].vtype,
            this.gslb.getGslb(e, t)
        },
        onPreparPlay: function() {
            !this.manager.listener.get(l.IS_AD) && this.playerData.config.playbackRate && this.manager.curVideo.setPlayRate(this.playerData.config.playbackRate),
            this.playerData.config.isAutoPlay && this.manager.curVideo.play(),
            this.playerData.config.isAutoPlay = !0
        },
        onStartPlay: function() {
            if (!this.manager.listener.get(l.IS_AD)) {
                var e = this.history.getRecords()
                  , t = this.playerData.flashVar.htime || this.playerData.urlParams.htime
                  , a = this.manager.listener.get(l.USER_INFO)
                  , i = this.manager.playerData.validateInfo
                  , s = i.vodInfo && i.vodInfo.video && [1, 2].indexOf(i.vodInfo.video.chargeType) != -1 || !1
                  , n = i.vodInfo && i.vodInfo.video && "0" == i.vodInfo.video.chargeType && "1" == i.vodInfo.video.isCharge && "0" == i.vodInfo.video.isSupportTicket || !1
                  , r = i.vodInfo && i.vodInfo.video && "0" == i.vodInfo.video.chargeType && "1" == i.vodInfo.video.isSupportTicket || !1;
                t = Math.max(0, t),
                t = t >= this.playerData.vinfo.gdur ? 0 : t,
                "changeDefi" == this.manager.listener.get(l.PLAY_STATE) ? (this.manager.evt.trigger(l.EVENT.PLAYER_COMMAND, "seek", e),
                this.manager.evt.trigger("vjs_hideDefiTip")) : this.playerData.config.historyPlay || "none" != this.playerData.tryLookType || (t ? (this.playerData.flashVar.htime = this.playerData.urlParams.htime = 0,
                this.manager.evt.trigger(l.EVENT.PLAYER_COMMAND, "seek", t)) : e && e > 30 && e < this.playerData.vinfo.gdur - 15 && this.manager.evt.trigger(l.EVENT.PLAYER_COMMAND, "seek", e)),
                i.tvodRts && this.manager.evt.trigger("showTip", "tvod_showTime", i.tvodRts),
                "vip" == this.playerData.tryLookType ? (this.manager.evt.trigger("vjs_tryLookEnd", !1),
                "cn" == this.playerData.flashVar.region ? a ? s ? this.manager.evt.trigger("showTip", "chargeType1_Login") : n ? this.manager.evt.trigger("showTip", "tvod_Login") : r ? i.size > 0 ? this.manager.evt.trigger("showTip", "ticket_Login", i.size) : a.isMovieVip ? this.manager.evt.trigger("showTip", "noticket_vip") : this.manager.evt.trigger("showTip", "noticket_notvip") : this.manager.evt.trigger("showTip", "trylook") : s ? this.manager.evt.trigger("showTip", "chargeType1_notLogin") : n ? this.manager.evt.trigger("showTip", "tvod_notLogin") : r ? this.manager.evt.trigger("showTip", "ticket_notLogin") : this.manager.evt.trigger("showTip", "trylook") : this.manager.evt.trigger("showTip", "trylook")) : "appGuide" == this.playerData.tryLookType && this.manager.evt.trigger("showTip", "appGuide")
            }
        },
        sendCV: function() {
            this.manager.log.pushLog("上报 cv");
            var e = this.playerData.vinfo.ispay ? "none" != this.playerData.tryLookType ? 1 : 2 : 0;
            this.manager.pingback.sendPlayAction("play", {
                prl: 1,
                pay: e,
                joint: this.playerData.hasAD ? 1 : 0
            }),
            this.manager.pingback.sendComStore(),
            this.manager.pingback.startHeartRecord(),
            "ios" != this.playerData.videoType || this.playerData.config.supportP2P || (h.setCookie("vjs-supportM3U8", "1", {
                expires: 7
            }),
            d.supportM3U8 = "1")
        },
        changeTrylook: function(e, t) {
            this.manager.log.pushLog("changeTrylook: " + e + "==" + t),
            this.playerData.tryLookType = e,
            this.playerData.tryLookTime = t,
            "none" != e ? this.manager.evt.on("vjs_timeupdate", this.checkTryLook, this) : this.manager.evt.off("vjs_timeupdate", this.checkTryLook, this)
        },
        checkTryLook: function(e) {
            e = isNaN(e) ? this.manager.curVideo.getCurrentTime() : e;
            var t = this.lanFit;
            if (e >= 60 * this.playerData.tryLookTime) {
                if ("vip" == this.playerData.tryLookType) {
                    var a, i = this.manager.listener.get(l.USER_INFO), s = this.playerData.validateInfo;
                    if (i)
                        if (!s.vodInfo.video || "0" != s.vodInfo.video.chargeType && "1" != s.vodInfo.video.chargeType) {
                            a = "openGlobalMember";
                            var n = s.player_member && s.player_member[0] ? s.player_member[0].name : t("会员");
                            this.manager.evt.trigger("vjs_showPopTip", "openGlobalMember", n)
                        } else
                            s.size > 0 ? (a = "useTicket",
                            this.manager.evt.trigger("vjs_showPopTip", "useTicket", s.size)) : (a = "noMoreTicket",
                            this.manager.evt.trigger("vjs_showPopTip", "noMoreTicket", s.size));
                    else
                        a = "loginMember",
                        this.manager.evt.trigger("vjs_showPopTip", "loginMember");
                    this.manager.evt.trigger("vjs_tryLookEnd", !0),
                    this.manager.evt.trigger(l.EVENT.PLAYER_CALLBACK, "displayTrylook", {
                        trylookTime: this.playerData.tryLookTime,
                        userInfo: i,
                        vipInfo: s.player_member,
                        type: a
                    })
                } else
                    "appGuide" == this.playerData.tryLookType && (this.manager.evt.trigger("vjs_showPopTip", "appGuideEnd"),
                    this.manager.evt.trigger(l.EVENT.PLAYER_CALLBACK, "appGuideEnd"));
                return this.manager.evt.off("vjs_timeupdate", this.checkTryLook, this),
                1
            }
            return 0
        },
        onLoadstart: function() {
            this.manager.pingback.sendPlayAction("cload")
        }
    };
    h.merge(i.prototype, c),
    e.exports = i
}
, function(e, t, a) {
    function i() {}
    var s = a(23)
      , n = a(3);
    n.extend(i, s);
    var r = {
        init: function() {}
    };
    n.merge(i.prototype, r),
    e.exports = i
}
, function(e, t, a) {
    var i = a(23)
      , s = a(3)
      , n = a(4)
      , r = a(21)
      , o = a(2)
      , l = function() {};
    s.extend(l, i);
    var d = {
        init: function() {
            this.playerData = this.manager.playerData,
            this.isServerTime = !1,
            this.isDomain = 0,
            this.serverTime = null,
            this.isRetryCookie = !1,
            this.requestType = "new",
            this.manager.listener.on(r.PLAY_STATE, this.onPlayStateChange, this)
        },
        onPlayStateChange: function(e, t) {
            "init" == t && (this.isServerTime = !1,
            this.serverTime = null,
            this.isRetryCookie = !1,
            this.isDomain = 0)
        },
        getMms: function() {
            this.getRequest()
        },
        getRequest: function() {
            var e;
            if (this.isServerTime) {
                if (!this.serverTime)
                    throw "mms api need server time";
                e = this.serverTime
            } else
                e = s.now() / 1e3;
            switch (this.isDomain) {
            case 0:
                timeOut = 5e3;
                break;
            case 1:
                timeOut = 8e3;
                break;
            case 2:
            default:
                timeOut = 1e4
            }
            var t, a = r.PROTOCAL + r.HOST_NAME.PLAYER_PC_LETV_COM + "/mms/out/video/playJson.json", i = n.getMmsKey(e);
            if (this.playerData.videoType = !this.playerData.config.supportP2P && "" != o.supportM3U8 && "1" != o.supportM3U8 || o.forceMp4 ? "no" : "ios",
            parent === window)
                try {
                    t = location.host
                } catch (l) {
                    t = "." + document.domain
                }
            var d = {
                1: "350",
                2: "1000",
                3: "1300",
                4: "720p"
            }
              , h = {
                platid: 3,
                splatid: this.playerData.config.splatId,
                tss: 'no',//this.playerData.videoType,
                id: this.playerData.vinfo.vid,
                detect: this.playerData.flashVar.mmDetect || "1",
                dvtype: d[this.playerData.config.defi] || "",
                accessyx: 1,
                domain: t,
                tkey: i,
                devid: this.manager.pingback.getLC(),
                source: "1001",
                lang: this.playerData.flashVar.lan,
                region: this.manager.listener.get(r.REGION),
                isHttps: 1 == this.playerData.flashVar.isHttps ? 1 : 0
            };
            this.manager.log.pushLog("mmsGet: ===_antiLeech===" + s.getCookie("_antiLeech")),
            this.jsonp = s.getJSON({
                url: a,
                data: h,
                log: this.manager.log,
                maxCount: 1,
                timeout: timeOut,
                success: s.bind(this.onSuccess, this),
                fail: s.bind(this.onFail, this)
            })
        },
        getRequest2: function() {
            var e;
            if (this.isServerTime) {
                if (!this.serverTime)
                    throw "mms api need server time";
                e = this.serverTime
            } else
                e = s.now() / 1e3;
            var t, a = 0;
            switch (this.isDomain) {
            case 0:
                t = r.HOST_NAME.API_LETV_COM,
                a = 5e3;
                break;
            case 1:
                t = r.HOST_NAME.API_WWW_LETV_COM,
                a = 8e3;
                break;
            case 2:
            default:
                t = "MPlayer" == this.playerData.pname ? r.HOST_NAME.D_APi_M_LETV_COM : "117.121.54.104",
                a = 1e4
            }
            var i, l = r.PROTOCAL + t + "/mms/out/video/playJsonH5", d = n.getMmsKey(e);
            if (this.playerData.videoType = !this.playerData.config.supportP2P && "" != o.supportM3U8 && "1" != o.supportM3U8 || o.forceMp4 ? "no" : "ios",
            parent === window)
                try {
                    i = location.host
                } catch (h) {
                    i = "." + document.domain
                }
            var c = {
                1: "350",
                2: "1000",
                3: "1300",
                4: "720p"
            }
              , p = {
                platid: 3,
                splatid: "MPlayer" == this.playerData.pname ? "301" : "304",
                tss: this.playerData.videoType,
                id: this.playerData.vinfo.vid,
                detect: this.playerData.flashVar.mmDetect || "1",
                dvtype: c[this.playerData.config.defi] || "",
                accessyx: 1,
                domain: i,
                tkey: d,
                devid: this.manager.pingback.getLC()
            };
            this.manager.log.pushLog("mmsGet: ===_antiLeech===" + s.getCookie("_antiLeech")),
            this.jsonp = s.getJSON({
                url: l,
                data: p,
                log: this.manager.log,
                maxCount: 1,
                timeout: a,
                success: s.bind(this.onSuccess, this),
                fail: s.bind(this.onFail, this)
            })
        },
        onSuccess: function(e) {
            if (this.jsonp = null,
            this.manager.log.pushLog("mms Suc: " + s.JSONTOStr(e)),
            e.code && 1 != e.code)
                return void this.sendError(r.ERROR_CODE.ERROR);
            if (e = e.msgs || e,
            e.drmFlag)
                return void this.sendError(r.ERROR_CODE.DRM_BAN);
            if (1003 == e.statuscode)
                e.playstatus && e.playstatus.stime ? this.isServerTime ? this.sendError(r.ERROR_CODE.AUTH_TIME_SERVER_ERROR) : (this.serverTime = e.playstatus.stime,
                this.isServerTime = !0,
                this.getRequest()) : this.sendError(r.ERROR_CODE.AUTH_ARGS_ERR);
            else if (1002 == e.statuscode)
                this.sendError(r.ERROR_CODE.AUTH_ARGS_ERR);
            else if (1 == e.playstatus.status) {
                if (e.checkstatus && 1e4 != e.checkstatus) {
                    if (10005 == e.checkstatus && !this.isRetryCookie)
                        return this.isRetryCookie = !0,
                        this.manager.log.pushLog("mms cookie fail,retry"),
                        void this.retryCookie();
                    this.manager.pingback.sendError(r.ERROR_CODE.AUTH_COOKIE_CHECK_ERR),
                    1 == Math.floor(400 * Math.random() + 1) && this.manager.log.send({
                        errno: r.ERROR_CODE.AUTH_COOKIE_CHECK_ERR,
                        forceSend: !0
                    })
                }
                this.isRetryCookie = !1,
                "301" == this.playerData.config.splatId && this.manager.pingback.sendFeGo({
                    code: "playjson-m"
                }),
                this.parseMovieVO(e)
            } else
                switch (e.playstatus.flag) {
                case 0:
                    this.sendError(r.ERROR_CODE.OFFLINE);
                    break;
                case 2:
                case 3:
                case 5:
                    this.sendError(r.ERROR_CODE.COPY_RIGHT_BAN);
                    break;
                case 4:
                case 6:
                    this.sendError(r.ERROR_CODE.ERROR);
                    break;
                case 1:
                    this.sendError(r.ERROR_CODE.AREA_BAN)
                }
        },
        onFail: function(e) {
            this.jsonp = null,
            this.manager.log.pushLog("mmsFail isDomain: " + this.isDomain),
            ++this.isDomain <= 2 ? this.getRequest() : this.sendError(r.ERROR_CODE.AUTH_TIMEOUT)
        },
        retryCookie: function() {
            this.jsonp = s.getJSON({
                url: r.PROTOCAL + r.HOST_NAME.D_APi_M_LETV_COM + "/api/flushCookie",
                data: {
                    vid: this.playerData.vinfo.vid
                },
                log: this.manager.log,
                success: s.bind(function() {
                    this.getRequest()
                }, this),
                fail: s.bind(function() {
                    this.sendError(r.ERROR_CODE.AUTH_COOKIE_RETRY_ERROR)
                }, this)
            })
        },
        parseMovieVO: function(e) {
            var t = e.playurl
              , a = {
                cid: t.cid,
                pid: t.pid,
                vid: t.vid,
                title: t.title,
                nextvid: t.nextvid,
                gdur: parseInt(t.duration),
                poster: s.merge({
                    defaultPic: t.imgprefix + "/thumb/2_"
                }, t.picAll),
                ispay: 0 != e.trylook,
                payTrylookTime: Math.floor(Math.min(540, "number" == typeof e.trylookTime ? e.trylookTime : 360) / 60),
                firstlook: "0" != e.firstlook,
                cutoff_p: e.cutoff_p,
                cutoff_t: e.cutoff_t,
                isAlbumPay: e.isAlbumPay
            };
            e.danmu && this.manager.evt.trigger("vjs_danmuSucc");
            var i, n, o, l = {};
            for (var d in t.dispatch)
                if (!t.dispatch[d][2] && (o = t.dispatch[d][0],
                n = o.match(/(\?|&)vtype=([^&]+)(&|$)/)[2] || "",
                i = null,
                182 == n || 21 == n && !l[1] ? i = 1 : 183 == n || 13 == n && !l[2] ? i = 2 : 22 == n && (i = 3),
                i)) {
                    l[i] = {
                        urls: [],
                        vtype: n,
                        storePath: t.dispatch[d][1]
                    };
                    for (var h = 0, c = t.domain.length; h < c; h++)
                        l[i].urls.push(t.domain[h] + o)
                }
            if (s.isEmptyObj(l))
                return void this.sendError(r.ERROR_CODE.AUTH_DATA_EMPTY);
            !l[2] && l[1] && (l[2] = l[1]),
            !l[3] && l[2] && (l[3] = l[2]);
            var p = {
                vinfo: a,
                movieVO: l,
                userInfo: this.manager.user.formatUserInfo(e.userinfo),
                curVType: e.curVType
            };
            this.playerData.validateInfo = e.yuanxian || {},
            this.manager.log.pushLog("vjs_mmsSucc: " + s.JSONTOStr(p)),
            this.manager.evt.trigger("vjs_mmsSucc", p)
        }
    };
    s.merge(l.prototype, d),
    e.exports = l
}
, function(e, t, a) {
    var i = a(23)
      , s = a(3)
      , n = a(21)
      , r = a(2)
      , o = function() {};
    s.extend(o, i);
    var l = {
        init: function() {
            this.playerData = this.manager.playerData,
            this.currIdx = 0,
            this.movieVO = null,
            this.targetDefi = 0,
            this.isForceDefi = !1,
            this.param = ["format=1", "jsonp=?", "expect=3", "p1=" + this.playerData.config.p1, "p2=" + this.playerData.config.p2, "termid=2", "ostype=" + (r.Android && "android" || r.mac && "macos" || r.Window && "windows" || r.Linux && "linux" || "un"), "hwtype=" + (r.iPhone && "iphone" || r.iPad && "ipad" || r.LetvX60 && "X60" || r.LetvX40 && "X40" || "un")],
            this.manager.listener.on(n.PLAY_STATE, this.onPlayStateChange, this)
        },
        onPlayStateChange: function(e, t) {
            "init" == t ? (this.currIdx = 0,
            this.movieVO = null,
            this.targetDefi = 0,
            this.isForceDefi = !1) : "changeDefi" == t && (this.currIdx = 0)
        },
        setMovieVO: function(e) {
            this.movieVO = e
        },
        getGslb: function(e, t) {
            if (this.targetDefi = e,
            this.isForceDefi = t,
            "none" == this.playerData.tryLookType && this.playerData.vinfo.ispay) {
                var a = this.playerData.validateInfo || {};
                if (e == this.playerData.config.defi && a.token)
                    this.getData({
                        token: a.token
                    }),
                    delete a.token;
                else {
                    var i = this.movieVO[this.targetDefi].storePath;
                    this.manager.user.getToken(i, s.bind(function(e) {
                        this.getData({
                            token: e
                        })
                    }, this), s.bind(function() {
                        this.manager.pingback.sendError(n.ERROR_CODE.TOKEN_TIMEOUT)
                    }, this))
                }
            } else
                this.getData()
        },
        getData: function(e) {
            e = e || {};
            var t = this.movieVO[this.targetDefi].urls;
            if (this.currIdx >= t.length)
                return void this.sendError(n.ERROR_CODE.GSLB_TIMEOUT);
            var a = t[this.currIdx]
              , i = this.manager.listener.get(n.USER_INFO);
            e.token && (a += "&token=" + e.token + "&uid=" + i.ssouid),
            "appGuide" == this.playerData.tryLookType && this.playerData.tryLookTime && (a += "&cutoff=" + this.playerData.tryLookTime),
            a += "&" + this.param.join("&"),
            a += "&uuid=" + this.manager.pingback.getUUID(),
            a += "&vid=" + this.playerData.vinfo.vid,
            r.letvMobile && (a += "&devn=lephone"),
            this.playerData.config.supportP2P ? (a = a.replace(/jsonp=\?&/, ""),
            this.manager.log.pushLog("vjs_p2pUrlSucc===" + a),
            this.manager.evt.trigger("vjs_p2pUrlSucc", a, this.targetDefi)) : (this.manager.log.pushLog("getGslb: "),
            this.jsonp = s.getJSON({
                url: a,
                log: this.manager.log,
                maxCount: 1,
                success: s.bind(this.onGslbSucc, this),
                fail: s.bind(this.onGslbFail, this)
            }))
        },
        onGslbSucc: function(e) {
            if (this.jsonp = null,
            this.manager.log.pushLog("gslbSuc: " + s.JSONTOStr(e)),
            445 == e.ercode || e.playlevel >= 3 && !this.isForceDefi) {
                this.isForceDefi && this.manager.evt.trigger("showTip", "glsbPressure");
                var t, a = this.movieVO;
                if (a[1] ? t = "1" : a[2] ? t = "2" : a[3] && (t = "3"),
                t && this.targetDefi != t)
                    return void this.manager.evt.trigger(n.EVENT.PLAYER_COMMAND, "changeDefi", t)
            }
            if (0 != e.ercode && 445 != e.ercode)
                switch (e.ercode) {
                case 444:
                    this.sendError(n.ERROR_CODE.GSLB_SERVER_PRESSURE_LARGE);
                    break;
                case 424:
                    this.manager.evt.trigger("vjs_gslbFail");
                    break;
                default:
                    this.sendError(n.ERROR_CODE.GSLB_ERROR)
                }
            else if (e.nodelist && e.nodelist.length > 0) {
                for (var i = [], r = e.nodelist, o = 0, l = r.length; o < l; o++)
                    r[o].location && i.push(r[o].location);
                this.manager.evt.trigger("vjs_gslbSuccess", i, this.targetDefi, {
                    responseTime: arguments[1].responseTime,
                    retryCount: arguments[1].retryCount
                })
            } else
                this.sendError(n.ERROR_CODE.GSLB_DATA_EMPTY)
        },
        onGslbFail: function() {
            this.jsonp = null,
            this.manager.log.pushLog("gslb fail"),
            this.currIdx++,
            this.getData()
        }
    };
    s.merge(o.prototype, l),
    e.exports = o
}
, function(e, t, a) {
    function i() {
        this.remoteTimer = null,
        this.localTimer = null,
        this.remoteLastTime = 0,
        this.localLastTime = 0
    }
    var s = a(23)
      , n = a(3)
      , r = a(2)
      , o = a(21)
      , l = a(42);
    n.extend(i, s);
    var d = {
        init: function() {
            this.playerData = this.manager.playerData,
            this.vinfo = this.playerData.vinfo,
            this.reader = new c(this.vinfo),
            this.saver = new h(this.vinfo,this.reader),
            this.initRecord = !0,
            this.manager.listener.on(o.PLAY_STATE, function(e, t) {
                "play" == t || "seeking" == t ? (this.initRecord && (this.flush(0, !0),
                this.initRecord = !1),
                this.startRecord()) : this.stopRecord(),
                "ended" == t && this.flush(-1, !0),
                "init" != t && "stop" != t || (this.initRecord = !0,
                this.reader.stop())
            }, this),
            this.flag = !1,
            this.isLogin = !1,
            this.manager.listener.on(o.USER_INFO, function(e, t) {
                this.isLogin = null != t,
                this.isLogin ? this.startRemoteRecord() : this.stopRemoteRecord()
            }, this)
        },
        initData: function(e) {
            "none" != this.playerData.tryLookType || this.playerData.vinfo.gdur < 600 ? (this.flag = !1,
            e && e()) : (this.flag = !0,
            this.isLogin ? this.reader.refreshRemote(e) : (this.reader.refreshLocal(),
            e()))
        },
        flush: function(e, t) {
            (this.flag && !isNaN(e) || t) && (this.saver.flushLocal(e),
            this.isLogin && this.saver.flushRemote(e))
        },
        getRecords: function() {
            var e = this.reader.records
              , t = this.vinfo.vid;
            if (e && e.length > 0 && t > 0)
                for (var a = 0; a < e.length; a++)
                    if (e[a].vid === t)
                        return e[a].htime;
            return -1
        },
        startRecord: function() {
            this.startLocalRecord(),
            this.isLogin && this.startRemoteRecord()
        },
        startLocalRecord: function() {
            this.flag && (this.stopLocalRecord(),
            this.localTimer = setInterval(n.bind(function() {
                this.saver.flushLocal(this.manager.curVideo.getCurrentTime())
            }, this), 3e3))
        },
        startRemoteRecord: function() {
            this.flag && (this.stopRemoteRecord(),
            this.isLogin && (this.remoteTimer = setInterval(n.bind(function() {
                this.saver.flushRemote(this.manager.curVideo.getCurrentTime())
            }, this), 12e4)))
        },
        stopRecord: function() {
            this.stopLocalRecord(),
            this.stopRemoteRecord()
        },
        stopLocalRecord: function() {
            clearInterval(this.localTimer)
        },
        stopRemoteRecord: function() {
            clearInterval(this.remoteTimer)
        }
    };
    n.merge(i.prototype, d);
    var h = function(e, t) {
        this.vinfo = e,
        this.reader = t,
        this._fromID = r.letvTv ? 4 : r.iPad ? 3 : r.Android || r.iPhone || r.iPod || r.wph || r.ps ? 2 : 1
    };
    h.prototype = {
        flushRemote: function(e) {
            if (e != this.remoteLastTime && this.vinfo) {
                this.remoteLastTime = e;
                var t = this.vinfo
                  , a = o.PROTOCAL + o.HOST_NAME.API_MY_LETV_COM + "/vcs/set?htime=" + e + "&cid=" + t.cid + "&pid=" + t.pid + "&vid=" + t.vid + "&nvid=" + (t.nextvid || "") + "&from=" + this._fromID;
                n.sendRequest(a)
            }
        },
        flushLocal: function(e) {
            if (e != this.localLastTime && this.vinfo) {
                this.localLastTime = e;
                for (var t = this.reader.records, a = t.length - 1; a >= 0; a--)
                    t[a].vid == this.vinfo.vid && t.splice(a, 1);
                var i = {
                    vid: this.vinfo.vid,
                    htime: e,
                    utime: n.now()
                };
                for (t.unshift(i); t.length > 10; )
                    t.pop();
                this.reader.records = t;
                try {
                    l.set("letvPlayerHistory", this.reader.records)
                } catch (s) {}
            }
        }
    };
    var c = function(e) {
        this.vinfo = e,
        this.records = [],
        this.jsonp = null
    };
    c.prototype = {
        refreshRemote: function(e) {
            var t = this;
            this.jsonp = n.getJSON({
                url: o.PROTOCAL + o.HOST_NAME.API_MY_LETV_COM + "/vcs/get",
                data: {
                    vid: this.vinfo.vid,
                    tn: Math.random()
                },
                success: function(a) {
                    t.jsonp = null,
                    200 == a.code && (a.data.vid = t.vinfo.vid,
                    t.records = [a.data]),
                    e && e()
                },
                fail: function() {
                    t.jsonp = null,
                    e && e()
                }
            })
        },
        refreshLocal: function() {
            try {
                return this.records = l.get("letvPlayerHistory") || []
            } catch (e) {
                return []
            }
        },
        stop: function() {
            this.jsonp && this.jsonp.destroy()
        }
    },
    e.exports = i
}
, function(e, t) {
    var a, i = Object.toJSON || window.JSON && (JSON.encode || JSON.stringify), s = window.JSON && (JSON.decode || JSON.parse) || function(e) {
        return String(e).evalJSON()
    }
    ;
    try {
        "localStorage"in window ? a = window.localStorage : "globalStorage"in window && (a = window.globalStorage[window.location.hostname])
    } catch (n) {}
    var r = function(e, t) {
        try {
            a.removeItem(e);
            var s = i(t);
            a.setItem(e, s)
        } catch (n) {
            a[e] = i(t)
        }
    }
      , o = function(e, t) {
        if (e in a)
            try {
                return s(a.getItem(e))
            } catch (i) {
                return s(a[e])
            }
        return "undefined" == typeof t ? null : t
    };
    e.exports = {
        set: r,
        get: o
    }
}
, function(e, t, a) {
    var i = a(23)
      , s = a(3)
      , n = a(44)
      , r = a(2)
      , o = a(21)
      , l = a(45)
      , d = function(e) {
        this.adVideo = new n(e);
        var t = "_h5ad_" + Math.floor(Math.random() * +new Date);
        this.h5ad = new l(this,t)
    };
    s.extend(d, i);
    var h = {
        init: function() {
            this.manager.log.pushLog("init ad"),
            this.playerData = this.manager.playerData,
            this.manager.register(this.adVideo),
            this.manager.listener.on(o.PLAY_STATE, function(e, t) {
                "init" != t && "stop" != t || !this.iAd || this.iAd.call(this.h5ad, "OnRefreshAd", {
                    curAD: this.curAD,
                    curIndex: this.curIdx
                })
            }, this),
            this.adPause = new p(this)
        },
        getAdParam: function() {
            return;
			var e = this.manager.listener.get(o.USER_INFO)
              , t = this.playerData.vinfo
              , a = {
                pname: this.playerData.pname,
                tplType: this.playerData.tplType,
                cont: this.playerData.config.cont,
                ch: this.manager.pingback.getCH(),
                uid: e ? e.ssouid : null,
                up: this.playerData.vinfo.up,
                ispay: this.playerData.vinfo.ispay,
                ver: this.playerData.playerVersion,
                uuid: this.manager.pingback.getUUID(),
                lc: this.manager.pingback.getLC(),
                islive: "live" == this.playerData.playerType,
                ark: this.playerData.flashVar.ark || "",
                p1: this.playerData.config.p1,
                p2: this.playerData.config.p2,
                p3: "",
                isAlbumPay: this.playerData.vinfo.isAlbumPay,
                tryLookType: this.playerData.tryLookType,
                tryLookTime: this.playerData.tryLookTime,
                liveType: this.playerData.vinfo.liveType,
                vipInfo: e ? e.vipInfoObj : null,
                cid: this.playerData.vinfo.cid,
                Notplayinline: r.Notplayinline,
                isHttps: this.playerData.flashVar.isHttps
            };
            return a = s.merge(a, t, !0),
            this.manager.log.pushLog("adParam :" + s.JSONTOStr(a)),
            a
        },
        refreshAd: function() {
            this.manager.log.pushLog("refresh ad");
            var e = this.getAdParam();
            this.internalCallback("adEnded", null),
            this.onADLoaded(e)
        },
        destoryAd: function() {
            try {
                this.h5ad.destory()
            } catch (e) {
                console.log(e)
            }
        },
        callback: function(e, t) {
            try {
                "getCurrTime" != e && this.manager.log.pushLog("ad callback: " + e + ";data: " + s.JSONTOStr(t))
            } catch (a) {}
            try {
                if ("undefined" != typeof this.videoCtrl)
                    return this.videoCtrl.cmd(e, t)
            } catch (a) {
                this.h5ad.requestLock = !1,
                this.manager.evt.trigger("vjs_adEnded")
            }
        },
        internalCallback: function(e, t) {
            this.manager.log.pushLog("ad internalCallback: " + e + ";data: " + s.JSONTOStr(t));
            try {
                switch (e) {
                case "adEnded":
                    this.h5ad.requestLock = !1,
                    t && t.reason && this.manager.evt.trigger("vjs_adEnded"),
                    this.videoCtrl && this.videoCtrl.removeListener();
                    break;
                case "login":
                    this.manager.evt.trigger(o.EVENT.PLAYER_COMMAND, "changFullScreen", 0),
                    this.manager.evt.trigger(o.EVENT.PLAYER_CALLBACK, "openLoginDialog")
                }
            } catch (a) {
                this.h5ad.requestLock = !1,
                this.manager.log.pushLog("ad error: " + e),
                this.manager.evt.trigger("vjs_adEnded")
            }
        },
        onADLoaded: function(e) {
            var t = this.h5ad;
            "undefined" != typeof t && "function" == typeof t.initAD && (this.iAd = t.sendEvent,
            this.videoCtrl = new c(this),
            t.initAD(e, this.callback))
        },
        play: function() {}
    };
    s.merge(d.prototype, h);
    var c = function(e) {
        this.h5ad = e.h5ad,
        this.adVideo = e.adVideo,
        this.manager = e.manager,
        this.internalCallback = function() {
            e.internalCallback.apply(e, arguments)
        }
        ,
        this.config = e.playerData.config,
        this.urls = [],
        this.events = ["ad_error", "ad_play", "ad_playing", "ad_ended", "ad_pause", "ad_timeupdate"],
        this.removeListener(),
        this.installListener(),
        this.iAd = this.h5ad.sendEvent
    };
    c.prototype = {
        cmd: function(e, t) {
            switch (e) {
            case "playAD":
                this.urls = t,
                this.manager.playerData.hasAD = 0 != this.urls.length,
                this.playAD(0);
                break;
            case "stopAD":
                this.internalCallback("adEnded", t);
                break;
            case "resumeAD":
                this.adVideo.play();
                break;
            case "pauseAD":
                this.adVideo.pause();
                break;
            case "getCurrTime":
                return this.adVideo.getCurrentTime();
            case "login":
                this.internalCallback(e);
                break;
            case "seek":
                var a = Number(t);
                if (isNaN(a))
                    return;
                this.adVideo.seek(a);
                break;
            case "lanfit":
                var i = t.toString();
                return this.manager.lanFit && "function" == typeof this.manager.lanFit.fit && (i = this.manager.lanFit.fit(i)),
                i
            }
        },
        playAD: function(e) {
            this.curIdx = e || 0,
            this.urls && this.urls.length > e && this.urls[e] ? (this.curAD = this.urls[e],
            this.adVideo.setSrc(this.curAD.url)) : this.internalCallback("adEnded", {
                reason: 12
            })
        },
        installListener: function() {
            this.enabled = !0,
            s.each.call(this, this.events, function(e, t) {
                this.manager.evt.on(t, this.onVideoEvent, this)
            }),
            this.manager.listener.on(o.USER_INFO, this.onUserInfoChang, this)
        },
        removeListener: function() {
            this.enabled && (this.enabled = !1,
            s.each.call(this, this.events, function(e, t) {
                this.manager.evt.off(t, this.onVideoEvent, this)
            }))
        },
        onVideoEvent: function(e) {
            switch (e.type) {
            case "ad_play":
            case "ad_playing":
                this.callAD("AD_PLAY");
                break;
            case "ad_timeupdate":
                this.callAD("AD_TimeUpdate");
                break;
            case "ad_pause":
                this.playID && clearTimeout(this.playID),
                this.callAD("AD_PAUSE");
                break;
            case "ad_ended":
                this.callAD("AD_ENDED"),
                this.playAD(++this.curIdx);
                break;
            case "ad_error":
                this.callAD("AD_ERROR", {
                    error: 1
                });
                try {
                    this.h5ad.collectError("221&" + JSON.stringify(this.curAD))
                } catch (t) {}
                this.manager.pingback.sendError(o.ERROR_CODE.ADURL_NOT_SUPPORT),
                this.manager.log.pushLog("adSrc: " + this.adVideo.getSrc()),
                this.playAD(++this.curIdx)
            }
        },
        onUserInfoChang: function(e, t) {
            this.callAD("loginCb", {
                level: t ? t.isvip : null,
                uid: t ? t.ssouid : null
            })
        },
        callAD: function(e, t) {
            try {
                t || (t = {}),
                s.merge(t, {
                    curAD: this.curAD,
                    curIndex: this.curIdx
                }),
                this.iAd.call(this.h5ad, e, t)
            } catch (a) {}
        }
    };
    var p = function(e) {
        this.h5ad = e.h5ad,
        this.manager = e.manager,
        this.manager.listener.on(o.PLAY_STATE, function(t, a) {
            "play" == a && e.h5ad.closePauseRender(e.h5ad)
        }),
        this.manager.evt.on("vjs_activePause", function() {
            var t = {
                onTime: Math.round(1e3 * this.manager.curVideo.getCurrentTime())
            };
            e.h5ad.getPauseData(t)
        }, this)
    };
    e.exports = d
}
, function(e, t, a) {
    var i = a(23)
      , s = a(3)
      , n = a(21)
      , r = function(e) {
        this.baseVideo = e
    };
    s.extend(r, i);
    var o = {
        init: function() {
            this.playerData = this.manager.playerData,
            this.preparePlayTimeout = null;
            var e = ["webkitendfullscreen", "canplaythrough", "stalled", "play", "playing", "pause", "waiting", "seeking", "seeked", "progress", "canplay", "ended", "durationchange", "loadstart", "loadeddata", "loadedmetadata", "timeupdate", "error"];
            this.manager.listener.on(n.IS_AD, function(t, a) {
                a ? s.each.call(this, e, function(e, t) {
                    this.manager.evt.on(t, this.onVideoEvent, this)
                }) : s.each.call(this, e, function(e, t) {
                    this.manager.evt.off(t, this.onVideoEvent, this)
                })
            }, this)
        },
        onVideoEvent: function(e) {
            this.baseVideo.eventPublicHandle(e.type),
            this.manager.evt.trigger("ad_" + e.type)
        },
        setSrc: function(e) {
            this.baseVideo.setSrc(e)
        },
        getSrc: function() {
            return this.baseVideo.getSrc()
        },
        play: function() {
            this.baseVideo.play()
        },
        replay: function() {
            this.baseVideo.play()
        },
        pause: function() {
            this.baseVideo.pause()
        },
        seek: function(e) {
            this.baseVideo.seek(e)
        },
        getCurrentTime: function() {
            return this.baseVideo.getCurrentTime()
        },
        getBuffered: function() {
            for (var e = this.baseVideo.getBuffered(), t = this.getCurrentTime(), a = 0, i = e.length; a < i; a++)
                if (e[a].end - t >= 0)
                    return e[a].end
        },
        getDuration: function() {
            return this.baseVideo.getDuration()
        },
        release: function() {},
        changeFullScreen: function(e) {
            this.baseVideo.changeFullScreen(e)
        }
    };
    s.merge(r.prototype, o),
    e.exports = r
}
, function(module, exports, __webpack_require__) {
    function AdMaterial(e, t, a, i, s, n, r, o, l, d, h, c, p, u, g, f) {
        this.h5ad = e,
        this.duration = parseInt(l) || 0,
        this.impression = n || [],
        this.clickUrl = a,
        this.tracking = i,
        this.event = s,
        this.oid = r,
        this.orderid = o,
        this.curIdx = c,
        f ? this.url = t : this.resolveAdParam(t),
        this.adType = d + "",
        this.aduid = h,
        this.lc = p,
        this.sub = u || "",
        this.ord = g,
        this.initEvent()
    }
    var lib = __webpack_require__(3)
      , br = __webpack_require__(2)
      , $js = __webpack_require__(6)
      , isLeSportsM = !1
      , isLeSportsH = !1
      , adTools = {
        jsonpList: [],
        getJSON: function(e, t, a, i) {
            var s = this
              , n = lib.getJSON({
                url: e,
                maxCount: 1,
                success: function() {
                    t && t.apply(s, arguments),
                    r(n)
                },
                fail: function() {
                    a && a.apply(s, arguments),
                    r(n)
                },
                timeout: i ? i : 1e4
            })
              , r = function(e) {
                for (var t = 0; t < s.jsonpList.length; ++t)
                    if (s.jsonpList[t] == e) {
                        delete s.jsonpList[t];
                        break
                    }
            };
            this.jsonpList.push(n)
        },
        destoryJsonp: function() {
            for (var e = this.jsonpList, t = 0; t < e.length; ++t)
                try {
                    e[t] && e[t].destroy()
                } catch (a) {
                    adTools.debug(a)
                }
            this.jsonpList = []
        },
        param: function(e) {
            var t = new Array;
            if ("object" == typeof e)
                for (var a in e)
                    if (e.hasOwnProperty(a)) {
                        if ("-" === e[a])
                            continue;
                        t.push(encodeURIComponent(a) + "=" + encodeURIComponent(e[a]))
                    }
            return t.join("&")
        },
        sendLogs: function(e, t, a) {},
        wsLog: function(e) {},
        debug: function(e, t, a) {
            if (a = a || " ",
            1 == H5AD.config.DEBUG || adTools.getQuery("arkdebug"))
                if ("object" == typeof e)
                    t && (console.log("%c" + t, "color:#f0d"),
                    this.wsLog(t)),
                    this.wsLog(e),
                    console.log(e);
                else {
                    if (void 0 == e)
                        return void console.log("数据空" + a);
                    this.wsLog(e),
                    console.log(e + a)
                }
        },
        json: function(data) {
            try {
                return "string" == typeof data ? JSON && JSON.parse ? JSON.parse(data) : eval("(" + data + ")") : JSON.stringify(data)
            } catch (ex) {
                return "error"
            }
        },
        resoSid: function(e) {
            return e
        },
        getQuery: function(e, t) {
            var a = t || location.search;
            if (a.length > 0 && a.indexOf("?") != -1) {
                var i = new RegExp(e + "=([^&]*)","i")
                  , s = a.match(i);
                return s && s.length > 0 ? unescape(s[1]) : null
            }
            return null
        },
        easyClone: function(e, t) {
            for (var a in t)
                t.hasOwnProperty(a) && "object" != typeof t[a] && (e[a] = t[a])
        },
        arkMapper: function(e) {
            return;
			if ("string" == typeof e && (e = parseInt(e),
            isNaN(e)))
                return isLeSportsM ? 1128 : 132;
            if (this.isMStation && (br.iPhone || br.iPod)) {
                var t = H5AD.config.M_ARK_MAPPER[e];
                if (t)
                    return t
            }
            return isLeSportsM || isLeSportsH ? H5AD.config.ARK_Mapper[e] || (isLeSportsM ? 1128 : 1129) : H5AD.config.ARK_Mapper[e] || (this.isMStation ? 132 : 147)
        },
        removeElem: function(e) {
            if (e)
                return e.remove ? e.remove() : e.parentNode && e.parentNode.removeChild && e.parentNode.removeChild(e)
        },
        el: function(e, t) {
            var a = t ? $js(e).find(t)[0] : $js(e)[0];
            return a || (a = {
                setAttribute: function() {},
                style: {},
                isnull: !0
            }),
            a
        },
        bind: function(e, t) {
            br.isPC ? e.on("click", t) : e.on("click", t)
        },
        existEl: function(e) {
            return "object" == typeof e ? !e.isnull && (!(e instanceof Array) || e.length > 0) : "string" == typeof e && arguments.callee(this.el(e))
        },
        getAslbUrl: function(e, t, a) {
            var i, s;
            if (t.result = t.result || [],
            e instanceof Array) {
                if (s = e.shift(),
                !s)
                    return t(t.result);
                if (s.url && s.url.indexOf("https:") >= 0 ? s.url = s.url.replace("https:", "") : s.url && s.url.indexOf("http:") >= 0 && (s.url = s.url.replace("http:", "")),
                s.url && s.url.indexOf(H5AD.config.ASLB_DOMAIN) >= 0 ? i = br.iPhone || br.iPod || br.iPad ? s.url + "&tss=no&format=1&jsonp=?" : s.url + "&format=1&jsonp=?" : (t.result.push(s),
                adTools.getAslbUrl(e, t, a)),
                void 0 === i)
                    return;
                adTools.getJSON(i, function(i, n) {
                    0 == /mp4|m3u8/.test(i.location) ? (s.ryCount = $js.retryCount,
                    s.costTime = n.responseTime,
                    s.err = 474,
                    a.sendEvent(H5AD.config.SEND_EVENT_TYPE.OnASLB, {
                        curAD: s,
                        curIndex: s.curIdx
                    }),
                    H5AD.collectError("474,format error," + adTools.json(s), 3),
                    adTools.getAslbUrl(e, t, a)) : (s.rUrl = s.url,
                    s.url = i.location,
                    s.ryCount = $js.retryCount,
                    s.costTime = n.responseTime,
                    t.result.push(s),
                    a.sendEvent(H5AD.config.SEND_EVENT_TYPE.OnASLB, {
                        curAD: s,
                        curIndex: s.curIdx
                    }),
                    adTools.getAslbUrl(e, t, a))
                }, function(i) {
                    s.ryCount = $js.retryCount,
                    s.costTime = msg.responseTime,
                    s.err = 473,
                    t.result.push(s),
                    a.sendEvent(H5AD.config.SEND_EVENT_TYPE.OnASLB, {
                        curAD: s,
                        curIndex: s.curIdx
                    }),
                    H5AD.collectError("473,aslb error," + adTools.json(s), 3),
                    adTools.getAslbUrl(e, t, a)
                })
            } else {
                if (i.indexOf(H5AD.config.ASLB_DOMAIN) < 0)
                    return t([]);
                i = e + "&format=1&jsonp=?",
                adTools.getJSON(i, function(e) {
                    return t([e.location])
                }, function(e) {
                    return t([])
                })
            }
        },
        loadCss: function(e, t) {
            var a = document.head || document.getElementsByTagName("head")[0] || document.documentElement
              , i = document.createElement("style");
            i.setAttribute("type", "text/css"),
            i.id = "h5adstyle",
            i.innerHTML = e,
            a.appendChild(i)
        },
        detectUA: function() {
            var e = navigator.userAgent;
            this.easyClone(br, {
                LetvClient_iphone: /LetvClient_.+_iphone/.test(e),
                LetvClient_ipad: /LetvClient_.+_ipad/.test(e),
                LetvMobileClient_android: /LetvMobileClient_.+_android/.test(e)
            })
        },
        httpToHttps: function(e) {
            if (e)
                for (var t = 0; t < H5AD.config.httpsUrl.length; t++) {
                    var a = H5AD.config.httpsUrl[t];
                    H5AD.config[a] && (H5AD.config[a] = H5AD.config[a].replace("http:", "https:"),
                    H5AD.config[a] = H5AD.config[a].replace("apple.www.letv.", "apple-www.le."))
                }
        },
        getDeviceSize: function() {
            var e = screen;
            return {
                x: e.width > e.height ? e.width : e.height,
                y: e.width > e.height ? e.height : e.width
            }
        }(),
        canBeClicked: function() {
            return !(br.iPhone || br.iPod || br.msie)
        }(),
        isUC: br.uc,
        isMStation: !1,
        iosNotPlayInline: !0
    }
      , H5AD = function(e, t) {
        this.fid = t || "h5ad_" + Math.floor(Math.random() * +new Date),
        this.ad = e,
        this.playAdTimer = [],
        this.dynamicVars = {
            retry: 0,
            adidQueue: [],
            isFirst: !0,
            hasPlayed: !1,
            pauseOnTime: 0
        },
        this.staticVars = {
            countdownID: null,
            arkId: 132,
            countdownElem: null,
            pauseCis: 0,
            ptid: 4,
            cuid: 0,
            im: ""
        },
        this.putinVars = {}
    };
    H5AD.config = {
        AD_STYLE: {
            pre_roll: "2",
            standard: "3",
            pause: "6"
        },
        SEND_EVENT_TYPE: {
            OnStart: "AD_PLAY",
            OnComplate: "AD_ENDED",
            OnClick: "AD_CLICK",
            OnAcComplate: "AC_COMPLATE",
            OnError: "AD_ERROR",
            OnPause: "AD_PAUSE",
            OnASLB: "AD_ASLB",
            OnLoginAc: "loginCb",
            OnRefreshAd: "OnRefreshAd",
            OnTimeUpdate: "AD_TimeUpdate"
        },
        CALL_PLAYER_TYPE: {
            playAD: "playAD",
            stopAD: "stopAD",
            seek: "seek",
            pauseAD: "pauseAD",
            resumeAD: "resumeAD",
            getRealTime: "getCurrTime",
            getPlayerSize: "getVideoRect",
            doLogin: "login",
            pingback: "pingback",
            lanfit: "lanfit"
        },
        PROCESS_EVENT_TICKS: [{
            k: "firstQuartile",
            v: .25
        }, {
            k: "midpoint",
            v: .5
        }, {
            k: "thirdQuartile",
            v: .75
        }],
        crc_table: [61888, 62024, 21822, 44648, 51027, 25193, 39449, 32749, 45072, 19780, 27911, 40640, 22412, 47959, 2033, 15647, 26948, 7977, 333, 52810, 2229, 28457, 56115, 3222, 7819, 8261, 37040, 26479, 46017, 37654, 52255, 36436, 49642, 26018, 41611, 57969, 22529, 40087, 25454, 12785, 50531, 1739, 4421, 44187, 14573, 60124, 48843, 50551, 63571, 18928, 9702, 31935, 37924, 53689, 43138, 29106, 22299, 17913, 22765, 17733, 13233, 54102, 63095, 54790, 45315, 4283, 52320, 21487, 24719, 23499, 25688, 43296, 18522, 46226, 54051, 23750, 63855, 40050, 23830, 13909, 53473, 35269, 6541, 59749, 45495, 7225, 26512, 17657, 28777, 4159, 17208, 50565, 48334, 33575, 10897, 26141, 42425, 51911, 4632, 28267, 27030, 57778, 15356, 31158, 14774, 53522, 27342, 33231, 29241, 52365, 12102, 5400, 40637, 7989, 51774, 31639, 1064, 46043, 38691, 42315, 25171, 2606, 94, 25879, 50273, 48389, 61059, 63334, 38144, 34805, 17489, 9758, 21488, 31104, 40127, 47832, 19575, 8379, 62899, 64770, 6327, 15962, 35087, 34e3, 41978, 50244, 40758, 57390, 20080, 51537, 61759, 31722, 57084, 25726, 3693, 42772, 41971, 46086, 30626, 46885, 37383, 847, 38119, 23229, 59572, 58742, 40006, 20034, 62943, 57283, 50816, 54485, 36496, 28963, 5481, 23375, 51432, 3135, 18675, 20557, 968, 55963, 47914, 45119, 25284, 1646, 34994, 1493, 10573, 32670, 64131, 45013, 56896, 57534, 26361, 47505, 26941, 31536, 886, 43364, 32112, 18014, 13600, 60378, 12717, 60596, 9862, 56041, 44055, 39986, 37168, 28168, 55209, 30733, 5480, 6034, 17485, 56710, 63417, 33557, 9848, 39651, 64250, 14639, 63835, 38963, 7906, 39909, 7971, 10158, 40564, 25844, 3305, 50258, 28353, 42316, 44088, 44477, 1500, 42481, 45659, 44289, 10989, 54239, 19915, 42407, 19391, 1463, 50295, 60742, 8528, 50215, 445, 89, 39965, 42071],
        ARK_Mapper: {
            4: "140",
            5: "142",
            6: "141",
            20: "134",
            21: "133",
            22: "135",
            23: "144",
            24: "146",
            25: "143",
            26: "137",
            27: "139",
            28: "138",
            29: "136",
            88: "148",
            166: "148",
            90: "145",
            91: "147",
            100: "372",
            104: "147",
            335: "335",
            329: "329",
            292: "292",
            132: "132",
            131: "131",
            130: "130",
            129: "129",
            128: "128",
            127: "127",
            126: "126",
            125: "125",
            124: "124",
            123: "123",
            122: "122",
            121: "121",
            120: "120",
            118: "118",
            372: "372",
            419: "419",
            1038: "1038",
            1039: "1039",
            1040: "1040",
            1041: "1041",
            1042: "1042",
            1043: "1043",
            1044: "1044",
            1045: "1045",
            1046: "1046",
            1047: "1047",
            1048: "1048",
            1049: "1049",
            1050: "1050",
            1051: "1051",
            1052: "1052",
            1128: "1128",
            735: "1068",
            842: "1069",
            843: "1070",
            844: "1071",
            889: "1072",
            1119: "1073",
            845: "1074",
            846: "1075",
            847: "1076",
            1120: "1077",
            849: "1078",
            1121: "1079",
            1122: "1080",
            1123: "1081",
            838: "1082",
            1129: "1129",
            1180: "1180",
            1328: "1329",
            1329: "1329",
            1388: "1387"
        },
        M_ARK_MAPPER: {
            335: "471",
            329: "472",
            292: "473",
            132: "474",
            131: "475",
            130: "476",
            129: "477",
            128: "478",
            127: "479",
            126: "480",
            125: "481",
            124: "482",
            123: "483",
            122: "484",
            121: "486",
            120: "487",
            118: "488",
            1038: "1053",
            1039: "1054",
            1040: "1055",
            1041: "1056",
            1042: "1057",
            1043: "1058",
            1044: "1059",
            1045: "1060",
            1046: "1061",
            1047: "1062",
            1048: "1063",
            1049: "1064",
            1050: "1065",
            1051: "1066",
            1052: "1067",
            1128: "1130",
            1180: "1181",
            1328: "1329",
            1329: "1329",
            1387: "1387"
        },
        H5_ADPLAYER_VER: "aps_h5_2.1.36",
        COUNTDOWN_IMG_URL: "//i1.letvimg.com/img/201504/27/h5_10/h5_10/numbers.png",
        VIP_ICON_IMG_URL: "//i2.letvimg.com/lc06_img/201706/30/17/53/crown_icon.png",
        VDO_BG_URL: "//i2.letvimg.com/img/201504/27/h5_10/h5_10/bg.png",
        SKIPAD_IMG_URL: "//i2.letvimg.com/img/201504/27/h5_10/h5_10/skipad.png",
        SEEDETAIL_IMG_URL: "//i1.letvimg.com/img/201504/27/h5_10/h5_10/seedetail.png",
        ARK_DOMAIN: "",//"ark.letv.com/t",
        ASLB_DOMAIN: "",//"g3.letv",
        ARK_SHOW_URL: "",//"http://ark.letv.com/s?res=jsonp",
        ARK_PREVIEW_URL: "",//"http://ark.letv.com/p?res=jsonp",
        DC_AD_URL: "",//"http://apple.www.letv.com/va/?",
        SKIP_AD_CLICK: "",//"http://dc.letv.com/s/?k=sumtmp;H5PADQad",
        SKIP_AD_SUCC: "",//"http://dc.letv.com/s/?k=sumtmp;H5PADQadfc",
        REQ_ARK_TIMEOUT: 15e3,
        DOWNLOAD_URL_TIMEOUT: 1e4,
        WS_URL: "ws://10.58.88.69:8080",
        CSS_TEMPLATE: ['.precdImg{float: left;width: 14px;height: 24px;overflow: hidden;}.vdo_time_info span{margin-top: 12px;float: left;}.hv_box_mb .precdImg ,.hv_box_live_mb .precdImg{float: left;width: 8px;height: 12px;background-size: 100%;overflow: hidden;}.vdo_post_time,.vdo_post_detail{position: absolute;right: 18px;height: 50px;line-height: 50px;text-align: center;z-index: 13;}.vdo_post_time a:hover,.vdo_post_time a:visited,.vdo_post_detail a:hover,.vdo_post_detail a:visited{color:#fff}.vdo_post_time a,.vdo_post_detail a{font-family: 12px/1.5 "微软雅黑",arial;color: #fff;font-size: 20px;}.vdo_post_detail a{margin-left: 60px;}.hv_box_mb .vdo_post_detail a,.hv_box_live_mb .vdo_post_detail a{margin-left: 35px;font-size: 10px;}.vdo_post_time{top: 14px;}.vdo_post_rlt{position: relative;width: 100%;height: 50px}.vdo_time_bg,.vdo_detail_bg{position: absolute;width: 100%;height: 50px;left: 0;top: 0;background-color: #000;opacity: 0.5;border-radius: 10px;}.vdo_time_info,.vdo_detail_info{position: relative}.vdo_time_info span{float: left;margin-left: 36px;}.vdo_time_info a{margin-left: 34px;margin-right: 41px;}.hv_box_mb .vdo_time_info a, .hv_box_live_mb .vdo_time_info a{margin-left: 10px;margin-right: 10px;font-size: 10px;}.vdo_post_detail{bottom: 14px}.vdo_post_detail a,.vdo_post_detail a:hover{display: block;margin-right: 24px;}.hv_box_mb .vdo_post_detail a,.hv_box_mb .vdo_post_detail a:hover,.hv_box_live_mb .vdo_post_detail a,.hv_box_live_mb .vdo_post_detail a:hover{padding-top:1px;margin-left: 35px;margin-right: 12px;}.vdo_post_detail i{background: url(//i1.letvimg.com/img/201504/29/bg.png) no-repeat;width: 14px;height: 24px;float: right;margin-top: 14px;margin-left: 43px;}.hv_box_mb .vdo_post_detail i,.hv_box_live_mb .vdo_post_detail i{display: block;width: 7px;height: 10px;background: url(//i1.letvimg.com/img/201504/29/bg.png) no-repeat;background-size: 100%;margin-top: 6px;margin-left: 22px;}.hv_box_mb .vdo_post_time,.hv_box_live_mb .vdo_post_time{right: 9px;top: 7px;}.hv_box_mb .vdo_post_detail,.hv_box_live_mb .vdo_post_detail{bottom: 7px;right: 9px;}.hv_box_mb .vdo_post_time,.hv_box_mb .vdo_post_detail,.hv_box_live_mb .vdo_post_time,.hv_box_live_mb .vdo_post_detail{height: 26px;line-height: 26px;}.hv_box_mb .vdo_post_rlt,.hv_box_mb .vdo_time_bg,.hv_box_mb .vdo_detail_bg,.hv_box_mb .vdo_post_detail a,.hv_box_mb .vdo_post_detail,.hv_box_live_mb .vdo_post_rlt,.hv_box_live_mb .vdo_time_bg,.hv_box_live_mb .vdo_detail_bg,.hv_box_live_mb .vdo_post_detail a,.hv_box_live_mb .vdo_post_detail a:hover{height: 25px;border-radius: 5px;}.hv_box_mb .vdo_detail_info{height: 26px;width: 100%;}.hv_box_mb .vdo_time_info span,.hv_box_live_mb .vdo_time_info span{margin-left: 20px;margin-top: 7px;float: left}.aps_mask_cont{position: absolute;width: 100%;height: 100%;top: 0px;left: 0px;z-index: 12;}.aps_pop_poster{width: 100%;height: 100%;position: absolute;top: 0;left: 0;z-index: 999;}.vdo_send_log{position: absolute;top: 80px;height: 100px;right: 10px;font-size: 30px;z-index: 30}.hv_pop_poster{position: absolute;top: 50%;left: 50%;margin: -112px 0 0 -182px;width: 365px;height: 175px;overflow: hidden;background-color: #f1f1f1;}.hv_pop_poster p{text-align: center;margin-bottom: 12px}.hv_pop_poster p.hv_p1{padding-top: 48px}.hv_pop_poster a{display: inline-block;height: 40px;width: 224px;line-height: 40px;background-color: #f7f7f7;font-size: 15px;color: #7e7e7e;border: 1px solid #d1d1d1}.hv_pop_poster a.blu{background-color: #00a0e9;color: #ffffff;border: 1px solid #00a0e9}.hv_pop_poster a.close{width: 20px;height: 20px;display: block;position: absolute;top: 10px;right: 10px;border: none;background: none}.hv_pop_poster a.close i{display: block;width: 18px;height: 2px;position: absolute;top: 6px;left: 0;background: #737373;transform: rotate(-45deg);-ms-transform: rotate(-45deg);-moz-transform: rotate(-45deg);-webkit-transform: rotate(-45deg);-o-transform: rotate(-45deg)}.hv_pop_poster a.close i.i_1{transform: rotate(45deg);-ms-transform: rotate(45deg);-moz-transform: rotate(45deg);-webkit-transform: rotate(45deg);-o-transform: rotate(45deg)}.hv_pop_poster .hv_org{color: #fd6c01}'].join(""),
        DEBUG: !1,
        ArkDebug: !1,
        retryCount: 1,
        isPauseState: 0,
        securityKeys: ["rt", "oid", "im", "t", "data"],
        isHttps: 0,
        httpsUrl: ["ARK_SHOW_URL", "ARK_PREVIEW_URL", "DC_AD_URL", "SKIP_AD_CLICK", "SKIP_AD_SUCC"]
    },
    H5AD.prototype = {
        requestLock: !1,
        lastPlayTime: 0,
        adQueue: [],
        loadCss: function() {
            adTools.loadCss(H5AD.config.CSS_TEMPLATE)
        },
        prepareImages: function(e, t) {
            var a = new Image;
            a.src = e,
            "undefined" != typeof t && (a.complete ? t(a.width, a.height) : a.onload = function() {
                t(a.width, a.height),
                a.onload = null
            }
            )
        },
        destory: function(e) {
            if (e = e || this.curAd)
                try {
                    e.closeCountDown(),
                    this.callback2Player = null,
                    this.putinVars = {},
                    this.dynamicVars = {
                        retry: 0,
                        adidQueue: [],
                        isFirst: !0,
                        hasPlayed: !1
                    },
                    this.lastPlayTime = 0,
                    this.adQueue = [],
                    this.playingMonitorCount = 0,
                    this.playAdTimer && this.playAdTimer.length > 0 && clearTimeout(this.playAdTimer[e.curIndex]),
                    clearTimeout(this.downMaterialTimer),
                    clearTimeout(this.arkTimer),
                    clearTimeout(this.playingMonitor),
                    clearInterval(e.processTimer),
                    clearInterval(e.countdownTimer),
                    clearInterval(e.monitorTimer);
                    var t = adTools.el("#a_see_detail" + this.fid);
                    adTools.existEl(t) && adTools.removeElem(t),
                    this.adEventDispatcher = null
                } catch (a) {}
        },
        openApp: function(e, t) {
            var a = "letvclient://msiteAction?actionType=0&pid=" + encodeURIComponent(e) + "&vid=" + encodeURIComponent(t) + "&from=mletv";
            setTimeout(function() {
                (new Date).valueOf();
                if (br.Android) {
                    var e = document.createElement("iframe");
                    e.style.cssText = "width:0px;height:0px;position:fixed;top:0;left:0;",
                    e.src = a,
                    document.body.appendChild(e);
                } else
                    location.href = a;
                setTimeout(function() {}, 1500)
            }, 100)
        },
        initAD: function(e, t) {
            var a = this;
            if (H5AD.config.isHttps = parseInt(e.isHttps),
            adTools.httpToHttps(H5AD.config.isHttps),
            "0p" == e.p2 && (isLeSportsM = !0,
            isLeSportsH = !1),
            "0q" == e.p2 && (isLeSportsH = !0,
            isLeSportsM = !1),
            e.isMStation = e.tplType && /^min|IPhone|^simple/.test(e.tplType),
            "vip" == e.tryLookType && parseInt(e.tryLookTime) > 0 && (e.istrylook = 1),
            adTools.iosNotPlayInline = !!e.Notplayinline,
            e.vipbrand = 0,
            e.vipInfo)
                for (var i in e.vipInfo) {
                    var s = e.vipInfo[i];
                    s && (301 == s.typeGroup && 1 == s.isvip ? (e.isvip = 1,
                    0 == e.vipbrand && s.vipbrand && (e.vipbrand = s.vipbrand)) : 302 == s.typeGroup && 1 == s.isvip && (e.isSportvip = 1))
                }
            a.is_need_video_info = "",
            a.curAd && a.destory(a.curAd),
            a.staticVars.pauseCis && (a.staticVars.pauseCis = 0),
            a.loadCss(),
            a.prepareImages(H5AD.config.COUNTDOWN_IMG_URL),
            adTools.detectUA(),
            adTools.debug(e, "传过来的值：");
            var n, r = H5AD.config, o = r.SEND_EVENT_TYPE, l = r.CALL_PLAYER_TYPE;
            if (e && t) {
                if (a.callback2Player = function() {
                    try {
                        return t.apply(a.ad, arguments)
                    } catch (e) {
                        H5AD.collectError("497&err=" + (e || {}).stack, 3),
                        adTools.debug(e);
                        try {
                            t(l.stopAD, {
                                reason: 0,
                                margs: arguments
                            })
                        } catch (i) {}
                    }
                }
                ,
                a.putinVars = e,
                this.requestLock === !0)
                    return;
                this.requestLock = !0
            } else
                e = a.putinVars,
                t = a.callback2Player;
            if (a.putinVars.ark == -1)
                return a.sendEvent(o.OnAcComplate, {
                    atype: "2",
                    curAD: {},
                    curIndex: -1,
                    ia: 6
                }),
                void a.callback2Player.call(a, l.stopAD, {
                    reason: 14
                });
            if (br.isLetv && !br.LetvClient_iphone && !br.LetvClient_ipad && !br.LetvMobileClient_android || br.weixin || br.weibo || /News/.test(navigator.userAgent))
                return a.sendEvent(o.OnAcComplate, {
                    atype: "2",
                    curAD: {},
                    curIndex: -1,
                    ia: 10
                }),
                a.callback2Player.call(a, l.stopAD, {
                    reason: 1
                }),
                void adTools.debug(navigator.userAgent);
            if ("30" == a.putinVars.cid)
                return a.sendEvent(o.OnAcComplate, {
                    atype: "2",
                    curAD: {},
                    curIndex: -1,
                    ia: 105
                }),
                void a.callback2Player.call(a, l.stopAD, {
                    reason: 13
                });
            if (a.startTime = lib.now(),
            parseInt(e.isSportvip) && ("sports" == e.liveType || 4 == parseInt(e.cid)))
                return a.callback2Player.call(a, l.stopAD, {
                    reason: 15
                }),
                a.sendEvent(o.OnAcComplate, {
                    atype: "2",
                    curAD: {},
                    curIndex: -1,
                    ia: 5
                }),
                e.isMStation || a.sendEvent(o.OnAcComplate, {
                    atype: "3",
                    curAD: {},
                    curIndex: -1,
                    ia: 5
                }),
                void a.tips("tips", "您正享受乐视体育会员去广告服务");
            if ("baidullq" == adTools.getQuery("ref") && navigator.userAgent.indexOf("baidubrowser") >= 0)
                return a.callback2Player.call(a, l.stopAD, {
                    reason: 3
                }),
                a.sendEvent(o.OnAcComplate, {
                    atype: "2",
                    curAD: {},
                    curIndex: -1,
                    ia: 10
                }),
                void a.tips("tips", "百度渠道禁播");
            e.isMStation ? (br.iPhone || br.iPod ? isLeSportsM ? a.staticVars.ptid = 53 : a.staticVars.ptid = 19 : isLeSportsM ? a.staticVars.ptid = 52 : a.staticVars.ptid = 4,
            adTools.isMStation = !0,
            r.DC_AD_URL = "http://apple.www.letv.com/va/?",
            r.SKIP_AD_CLICK = "http://apple.www.letv.com/s/?k=sumtmp;H5PADQad",
            r.SKIP_AD_SUCC = "http://apple.www.letv.com/s/?k=sumtmp;H5PADQadfc",
            a.adStyle = e.style || r.AD_STYLE.pre_roll,
            adTools.httpToHttps(H5AD.config.isHttps)) : (a.adStyle = e.style || [r.AD_STYLE.pre_roll, r.AD_STYLE.standard],
            isLeSportsH ? a.staticVars.ptid = 54 : a.staticVars.ptid = 5);
            try {
                a.staticVars.countdownID = "#" + a.putinVars.cont,
                a.staticVars.countdownElem = adTools.el(a.staticVars.countdownID, "div")
            } catch (d) {
                return a.callback2Player.call(a, l.stopAD, {
                    reason: 4
                }),
                void a.sendEvent(o.OnAcComplate, {
                    error: {
                        code: 21
                    }
                })
            }
            n = a.putinVars.ark ? a.putinVars.ark : "__ADINFO__"in window && __ADINFO__.arkId ? __ADINFO__.arkId : a.putinVars.defaultStreamid ? "!" : e.isMStation ? isLeSportsM ? "1128" : "132" : isLeSportsH ? "1129" : "91",
            a.staticVars.arkId = adTools.arkMapper(n),
            a.arkTimer = setTimeout(function() {
                adTools.debug("请求ark超时,播放正片"),
                a.sendEvent(o.OnAcComplate, {
                    error: {
                        code: 451
                    }
                }),
                a.callback2Player.call(a, r.CALL_PLAYER_TYPE.stopAD, {
                    reason: 5
                })
            }, r.REQ_ARK_TIMEOUT),
            a.getArkData(a.adStyle, a.staticVars.arkId, a.putinVars.vid, a.putinVars.defaultStreamid, e.uuid)
        },
        getArkData: function(e, t, a, i, s) {
            var n, r = this, o = H5AD.config, l = o.SEND_EVENT_TYPE, d = r.dynamicVars, h = "";
            s && 16 === s.length && (h = (s + s).replace(/(.{4})/, "$1y").replace(/(.{13})/, "$1h").replace(/(.{22})/, "$1e"),
            h = r.putinVars.isvip && 1 == r.putinVars.isvip ? h.toString().replace(/(.{31})/, "$1l") : h.replace(/(.{31})/, "$1x"),
            r.staticVars.im = h),
            e instanceof Array && (e = e.join(","));
            var c = {
                ark: t,
                n: d.isFirst ? 1 : 0,
                ct: e,
                vid: a || 0,
                vvid: s || "",
                t: Math.ceil((new Date).getTime() / 1e3),
                cid: r.putinVars.cid,
                ptid: r.staticVars.ptid,
                type: r.putinVars.istrylook ? 1 : 0,
                bm: r.putinVars.vipbrand ? r.putinVars.vipbrand : "",
                hs: o.isHttps ? "1" : "0",
                v: o.isHttps ? "iPhone_" + H5AD.config.H5_ADPLAYER_VER : H5AD.config.H5_ADPLAYER_VER,
                im: h
            };
            "undefined" != typeof i && (i = adTools.resoSid(i),
            n = c.ark != adTools.arkMapper(100) ? adTools.isMStation ? br.iPhone || br.iPod ? isLeSportsM ? "1067" : "471" : isLeSportsM ? "1052" : "335" : isLeSportsH ? "1082" : "148" : c.ark,
            adTools.easyClone(c, {
                sid: i,
                b: "2",
                ark: n
            }),
            r.staticVars.arkId = n);
            var p, u = adTools.getQuery("q2"), g = adTools.getQuery("ch"), f = {
                coop_yinliu: 393,
                coop_yinliu1: 394,
                coop_yinliu2: 395,
                coop_yinliu3: 396
            }, v = {
                yl25: 1032,
                yl29: 1032,
                yl31: 1032,
                yl32: 1032,
                yl34: 1032,
                yl35: 1032,
                yl60: 1032,
                yl61: 1032,
                yl62: 1032,
                yl63: 1032,
                yl64: 1032,
                yl65: 1032,
                yl66: 1032,
                yl67: 1032,
                yl68: 1032,
                yl69: 1032,
                yl70: 1032,
                yl71: 1032,
                yl72: 1032,
                yl73: 1032,
                yl74: 1032,
                yl75: 1032
            }, m = {
                yl25: 1033,
                yl29: 1033,
                yl31: 1033,
                yl32: 1033,
                yl34: 1033,
                yl35: 1033,
                yl60: 1033,
                yl61: 1033,
                yl62: 1033,
                yl63: 1033,
                yl64: 1033,
                yl65: 1033,
                yl66: 1033,
                yl67: 1033,
                yl68: 1033,
                yl69: 1033,
                yl70: 1033,
                yl71: 1033,
                yl72: 1033,
                yl73: 1033,
                yl74: 1033,
                yl75: 1033
            }, _ = {
                yl25: 1034,
                yl29: 1034,
                yl31: 1034,
                yl32: 1034,
                yl34: 1034,
                yl35: 1034,
                yl60: 1034,
                yl61: 1034,
                yl62: 1034,
                yl63: 1034,
                yl64: 1034,
                yl65: 1034,
                yl66: 1034,
                yl67: 1034,
                yl68: 1034,
                yl69: 1034,
                yl70: 1034,
                yl71: 1034,
                yl72: 1034,
                yl73: 1034,
                yl74: 1034,
                yl75: 1034
            };
            g ? (p = br.Android ? v[g] : br.iPhone ? m[g] : _[g],
            r.putinVars.yl_channel = g) : u && (p = f[u],
            r.putinVars.yl_channel = u),
            p && (c.ark = r.staticVars.arkId = p);
            var y = [H5AD.config.ARK_SHOW_URL, adTools.param(c), "j=?"].join("&")
              , b = {
                r: adTools.getQuery("r"),
                o: adTools.getQuery("o"),
                d: adTools.getQuery("d"),
                w: adTools.getQuery("w"),
                x: adTools.getQuery("x"),
                y: adTools.getQuery("y"),
                z: adTools.getQuery("z")
            };
            d.isFirst = !1,
            b.w && b.x && b.y && b.z && (y = [H5AD.config.ARK_PREVIEW_URL, adTools.param(c), adTools.param(b), "j=?"].join("&")),
            b = null,
            adTools.debug("请求ARK地址:" + y),
            r.getArkDataTime = lib.now(),
            adTools.getJSON(y, function(a) {
                r.requestLock = !1,
                clearTimeout(r.arkTimer);
                try {
                    r._resolveData.call(r, a, e, y, t)
                } catch (i) {
                    r.callback2Player(o.CALL_PLAYER_TYPE.playAD, []),
                    r.sendEvent(l.OnAcComplate, {
                        error: {
                            code: 453
                        }
                    }),
                    adTools.debug(i, "解析异常："),
                    H5AD.collectError("827&err=reqErr&src=" + y + "&lc=" + r.putinVars.lc, 3)
                }
            }, function(e) {
                r.sendEvent(l.OnAcComplate, {
                    error: {
                        code: 450
                    }
                }),
                r.callback2Player(o.CALL_PLAYER_TYPE.stopAD, {
                    reason: 6
                }),
                clearTimeout(r.arkTimer)
            }, o.REQ_ARK_TIMEOUT)
        },
        tips: function(e, t, a) {
            switch (e) {
            case "tips":
                adTools.debug(t)
            }
        },
        _resolveData: function(e, t, a, i) {
            var s, n, r = this, o = H5AD.config, l = "-", d = 0, h = 0, c = {}, p = o.SEND_EVENT_TYPE, u = o.CALL_PLAYER_TYPE;
            if (r.adEventDispatcher = new H5AD.adEvent,
            e && e.vast) {
                if (e.vast.Policy && ("base" == r.putinVars.tplType || "live" == r.putinVars.tplType) && !r.putinVars.istrylook) {
                    var g = e.vast.Policy.CuePoint
                      , f = 0;
                    for (var v in g)
                        6 == g[v].type && g[v].id > f && (f = g[v].id);
                    r.staticVars.pauseCis = f
                }
                if (n = e.vast,
                r.staticVars.cuid = r.setCuidCookie(n.cuid),
                n.code.indexOf("110004") > 0 && (r.callback2Player.call(r, u.stopAD, {
                    reason: 2
                }),
                r.sendEvent(p.OnAcComplate, {
                    atype: "2",
                    curAD: {},
                    curIndex: -1,
                    ia: 110
                })),
                n.code.indexOf("110006") > -1)
                    return r.callback2Player.call(r, u.stopAD, {
                        reason: 15
                    }),
                    void r.sendEvent(p.OnAcComplate, {
                        atype: "2",
                        curAD: {},
                        curIndex: -1,
                        ia: 7
                    });
                s = n.Ad.length,
                adTools.easyClone(r.staticVars, n),
                r.dynamicVars.preAdCount = 0,
                r.dynamicVars.staAdCount = 0,
                r.dynamicVars.preAdLc = 0,
                r.dynamicVars.staAdLc = 0,
                adTools.debug("返回广告数：" + s),
                r.adQueue = [],
                r.dynamicVars.dur_total = 0,
                r.dynamicVars.dur = [];
                for (var m = 0, _ = function(e) {
                    var t = 0;
                    return e && (t = parseInt(Math.ceil(e / 15))),
                    t
                }, y = 0; y < s; y++) {
                    var v = n.Ad[y];
                    if (v.parent) {
                        var v = n.Ad[y]
                          , b = v.InLine
                          , T = v.cuepoint_type
                          , E = b.Creatives.Creative[0]
                          , x = {};
                        adTools.easyClone(x, v);
                        var A = new AdMaterial(this,E.Linear.AdParameters,E.Linear.VideoClicks.ClickThrough,E.Linear.VideoClicks.ClickTracking,E.Linear.TrackingEvents.Tracking,b.Impression,x.order_item_id,x.order_id,E.Linear.Duration,T,E.Linear.adzone_id,m,v.lc,v.sub,v.ord);
                        A.isSub = v.parent,
                        c[v.parent] = A
                    } else {
                        var b = v.InLine
                          , T = v.cuepoint_type
                          , E = b.Creatives.Creative[0]
                          , x = {};
                        1 === s && this.adStyle instanceof Array && (T == o.AD_STYLE.pre_roll ? this.adStyle.pop() : T == o.AD_STYLE.standard && this.adStyle.shift()),
                        adTools.easyClone(x, v);
                        var k = new AdMaterial(this,E.Linear.AdParameters,E.Linear.VideoClicks.ClickThrough,E.Linear.VideoClicks.ClickTracking,E.Linear.TrackingEvents.Tracking,b.Impression,x.order_item_id,x.order_id,E.Linear.Duration,T,E.Linear.adzone_id,m,v.lc,v.sub,v.ord);
                        if (k.hasMZ && ++d,
                        k.hasEX && ++h,
                        T == o.AD_STYLE.pre_roll) {
                            if (r.adQueue.length > 0) {
                                var D = _(r.adQueue[r.adQueue.length - 1].duration);
                                k.nord = r.adQueue[r.adQueue.length - 1].nord + D
                            } else
                                k.nord = 1;
                            r.adQueue.push(k),
                            x.duration = k.duration,
                            r.dynamicVars.dur.push(x.duration),
                            r.dynamicVars.dur_total += x.duration,
                            r.dynamicVars.preAdCount++,
                            r.dynamicVars.preAdLc = x.lc,
                            r.dynamicVars.adidQueue.push(x.order_item_id),
                            m++
                        } else
                            T != o.AD_STYLE.standard || r.putinVars.istrylook || (k.nord = 1,
                            r.adQueue.push(k),
                            x.duration = k.duration,
                            r.dynamicVars.staAdCount++,
                            r.dynamicVars.staAdLc = 1,
                            r.dynamicVars.stadur = x.duration,
                            l = x.order_item_id,
                            m++)
                    }
                }
                var w = function() {
                    adTools.getAslbUrl(r.adQueue, function(e) {
                        adTools.debug(e, "返回ASLB—Data:"),
                        r.callback2Player.call(r, o.CALL_PLAYER_TYPE.playAD, e),
                        r.downMaterialTimer = lib.now()
                    }, r)
                }
                  , L = function() {
                    for (var e = 0; e < r.adQueue.length; e++) {
                        var t = r.adQueue[e];
                        (t.hasEX || t.hasMZ) && (t.curAD = t,
                        r._sendArkTracking(5, t),
                        r._reqThirdPartyExchange(t, function(e, t, a, i, s) {
                            if ("EX" === s ? --h : "MZ" === s && --d,
                            e && r._sendArkTracking(7, r.adQueue[a]),
                            null == e && null == t && r._sendArkTracking(8, r.adQueue[a]),
                            e || !t) {
                                var n;
                                if (n = c[i])
                                    n.curIdx = a,
                                    n.nord = r.adQueue[a].nord,
                                    r.adQueue[a] = n;
                                else {
                                    var o = []
                                      , l = r.adQueue[a].adType;
                                    r.adQueue[a] = null;
                                    for (var p = 0; p < r.adQueue.length; p++)
                                        if (r.adQueue[p]) {
                                            var u = p;
                                            if (p > a && (u -= 1,
                                            r.adQueue[p].curIdx = u,
                                            2 == r.adQueue[p].adType))
                                                if (o.length > 0) {
                                                    var g = _(o[o.length - 1].duration);
                                                    r.adQueue[p].nord = o[o.length - 1].nord + g
                                                } else
                                                    r.adQueue[p].nord = 1;
                                            o.push(r.adQueue[p])
                                        }
                                    if (r.adQueue = o,
                                    2 == l) {
                                        r.dynamicVars.dur_total -= r.dynamicVars.dur[a],
                                        r.dynamicVars.preAdCount -= 1;
                                        for (var f = [], p = 0; p < r.dynamicVars.dur.length; p++)
                                            p != a && f.push(r.dynamicVars.dur[p]);
                                        r.dynamicVars.dur = f
                                    } else
                                        3 == l && (r.dynamicVars.stadur -= 5,
                                        r.dynamicVars.staAdCount -= 1)
                                }
                                return void (0 === h && 0 === d && w())
                            }
                            r._sendArkTracking(6, r.adQueue[a]),
                            r.adQueue[t.curIdx] = t,
                            0 === h && 0 === d && w()
                        }))
                    }
                };
                (d || h) && (d > 0 || h > 0) ? L() : w();
                var P = "";
                n.code.indexOf("110004") > -1 && (P = 110),
                r.sendEvent(o.SEND_EVENT_TYPE.OnAcComplate, {
                    atype: "2",
                    ct: r.dynamicVars.preAdCount,
                    ia: P
                }),
                adTools.isMStation === !1 && r.sendEvent(o.SEND_EVENT_TYPE.OnAcComplate, {
                    atype: "3",
                    ct: r.dynamicVars.staAdCount,
                    dur: r.dynamicVars.stadur || "0",
                    oiid: l,
                    ia: P
                })
            } else
                r.callback2Player.call(r, o.CALL_PLAYER_TYPE.playAD, []),
                r.sendEvent(o.EVENT_TYPE.OnAcComplate, {
                    error: {
                        code: 453
                    }
                })
        },
        _reqThirdPartyExchange: function(e, t) {
            var a, i = this, s = H5AD.config;
            if (e)
                if (e.hasMZ)
                    i._reqThirdParty(e, t);
                else if (e.hasEX === !0) {
                    a = e.url,
                    a.indexOf("[LETV_V_URL]") > -1 && (a = a.replace("[LETV_V_URL]", encodeURIComponent(location.href))),
                    a += a.indexOf("?") > -1 ? "&" : "?";
                    var n, r = 0;
                    br.iPhone || br.iPad ? (n = "IOS",
                    br.iPad && (r = 1)) : br.Android || br.AndroidPad ? (n = "ANDROID",
                    br.AndroidPad && (r = 1)) : n = "OTHERS";
                    var o = {
                        h: n,
                        l: r
                    };
                    a += adTools.param(o),
                    a += "&j=?",
                    adTools.getJSON(a, function(a) {
                        try {
                            if (!a || !a.vast.Ad || 0 == a.vast.Ad.length || a.vast.Ad[0] && !a.vast.Ad[0].InLine)
                                return t(null, null, e.curIdx, e.oid, "EX");
                            var s = a.vast.Ad[0]
                              , n = s.InLine
                              , r = n.Creatives.Creative[0]
                              , o = r.Linear.Icons
                              , l = "";
                            o && o.Icon && (l = o.Icon.cdata);
                            var d = new AdMaterial(i,r.Linear.MediaFiles.MediaFile.cdata,r.Linear.VideoClicks.ClickThrough,r.Linear.VideoClicks.ClickTracking,r.Linear.TrackingEvents.Tracking,n.Impression,"","","","","",0,"","","",(!0));
                            e.iconUrl = l,
                            e.impression = d.impression,
                            e.event || (e.event = []),
                            e.event = e.event.concat(d.event),
                            e.clickUrl = d.clickUrl,
                            e.tracking || (e.tracking = []),
                            e.tracking = e.tracking.concat(d.tracking),
                            e.url = d.url,
                            t(null, e, e.curIdx, e.oid, "EX")
                        } catch (h) {
                            console.log(h)
                        }
                    }, function(a) {
                        a = a || {
                            reason: "timeout"
                        },
                        t(a, null, e.curIdx, e.oid, "EX")
                    }, s.REQ_ARK_TIMEOUT)
                }
            return e
        },
        _reqThirdParty: function(e, t) {
            var a, i = H5AD.config;
            if (e && e.hasMZ === !0) {
                a = e.url;
                var s = adTools.getQuery("v", a);
                s ? a = a.replace(new RegExp("v=" + s), "v=2&c=?") : a += "v=2&c=?",
                adTools.getJSON(a, function(a) {
                    try {
                        if (!a || a && !a.src)
                            return t(null, null, e.curIdx, e.oid, "MZ");
                        if (e.url = a.src || "",
                        e.clickUrl || (e.clickUrl = a.ldp || ""),
                        e.tracking.constructor == Array && e.tracking.concat(a.cm || []),
                        a.pm)
                            for (var i in a.pm)
                                if (a.pm.hasOwnProperty(i))
                                    if ("0" == i)
                                        e.impression.concat(a.pm[i]);
                                    else if (a.pm[i].constructor == Array)
                                        for (var s = 0; s < a.pm[i].length; s++) {
                                            var n = a.pm[i][s];
                                            "" != n && (e.event.push({
                                                event: "progress",
                                                offset: i,
                                                cdata: n
                                            }),
                                            e.progressTicks.push(parseInt(i) || 0))
                                        }
                        t(null, e, e.curIdx, e.oid, "MZ")
                    } catch (r) {}
                }, function(a) {
                    a = a || {
                        reason: "timeout"
                    },
                    t(a, null, e.curIdx, e.oid, "MZ")
                }, i.REQ_ARK_TIMEOUT)
            }
            return e
        },
        _reqThirdPartyNonExchange: function(e, t) {
            var a, i = this;
            H5AD.config;
            if (e && e.hasEX === !0) {
                a = e.url,
                a.indexOf("[LETV_V_URL]") > -1 && (a = a.replace("[LETV_V_URL]", encodeURIComponent(location.href))),
                a += a.indexOf("?") > -1 ? "&" : "?";
                var s, n = 0;
                br.iPhone || br.iPad ? (s = "IOS",
                br.iPad && (n = 1)) : br.Android || br.AndroidPad ? (s = "ANDROID",
                br.AndroidPad && (n = 1)) : s = "OTHERS";
                var r = {
                    h: s,
                    l: n
                };
                a += adTools.param(r),
                a += "&j=?",
                adTools.getJSON(a, function(a) {
                    try {
                        if (!a || !a.vast.Ad || 0 == a.vast.Ad.length || a.vast.Ad[0] && !a.vast.Ad[0].InLine)
                            return t(null, null, 0, e.oid, "EX");
                        var s = a.vast.Ad[0]
                          , n = s.InLine
                          , r = n.Creatives.Creative[0]
                          , o = r.NonLinearAds.Icons
                          , l = "";
                        o && o.Icon && (l = o.Icon.cdata);
                        var d = new AdMaterial(i,r.NonLinearAds.StaticResource.cdata,r.NonLinearAds.NonLinear.NonLinearClickThrough,r.NonLinearAds.NonLinear.NonLinearClickTracking,"",n.Impression,"","","","","",0,"","","",(!0));
                        e.iconUrl = l,
                        e.impression = d.impression,
                        e.event || (e.event = []),
                        e.event = e.event.concat(d.event),
                        e.clickUrl = d.clickUrl,
                        e.tracking || (e.tracking = []),
                        e.tracking = e.tracking.concat(d.tracking),
                        e.url = d.url,
                        t(null, e, 0, e.oid, "EX")
                    } catch (h) {
                        console.log(h)
                    }
                }, function(a) {
                    a = a || {
                        reason: "timeout"
                    },
                    t(a, null, e.curIdx, e.oid, "EX")
                }, 2e3)
            }
            return e
        },
        getPauseData: function(e) {
            var t = this
              , a = H5AD.config
              , i = t.putinVars
              , s = t.staticVars.arkId
              , n = a.SEND_EVENT_TYPE;
            t.isPauseState = 1;
            var r = i.uuid
              , o = "";
            if (r && 16 === r.length && (o = (r + r).replace(/(.{4})/, "$1y").replace(/(.{13})/, "$1h").replace(/(.{22})/, "$1e"),
            o = t.putinVars.isvip && 1 == t.putinVars.isvip ? o.toString().replace(/(.{31})/, "$1l") : o.replace(/(.{31})/, "$1x"),
            t.staticVars.im = o),
            t.staticVars.pauseCis && !adTools.isMStation) {
                e && (t.dynamicVars.pauseOnTime = e.onTime || 0);
                var l = {
                    ark: s,
                    n: 0,
                    cis: t.staticVars.pauseCis || 0,
                    vid: i.vid || 0,
                    vvid: i.uuid || "",
                    t: Math.ceil((new Date).getTime() / 1e3),
                    hs: a.isHttps ? "1" : "0",
                    v: a.isHttps ? "iPhone_" + H5AD.config.H5_ADPLAYER_VER : H5AD.config.H5_ADPLAYER_VER,
                    im: t.staticVars.im
                };
                if (i.defaultStreamid) {
                    var d = adTools.resoSid(i.defaultStreamid);
                    adTools.easyClone(l, {
                        sid: d,
                        b: "2"
                    })
                }
                var h = [H5AD.config.ARK_SHOW_URL, adTools.param(l), "j=?"].join("&")
                  , c = {
                    r: adTools.getQuery("r"),
                    o: adTools.getQuery("o"),
                    d: adTools.getQuery("d"),
                    w: adTools.getQuery("w"),
                    x: adTools.getQuery("x"),
                    y: adTools.getQuery("y"),
                    z: adTools.getQuery("z")
                };
                c.w && c.x && c.y && c.z && (h = [H5AD.config.ARK_PREVIEW_URL, adTools.param(l), adTools.param(c), "j=?"].join("&")),
                c = null,
                adTools.debug("暂停广告请求ARK地址:" + h),
                t.getArkDataTime = lib.now(),
                t.startTime = lib.now(),
                adTools.getJSON(h, function(e) {
                    try {
                        t._resolveNonLinearData.call(t, e, 6, h, s)
                    } catch (a) {
                        t.sendEvent(n.OnAcComplate, {
                            atype: 6,
                            error: {
                                code: 453
                            }
                        }),
                        adTools.debug(a, "解析异常："),
                        H5AD.collectError("827&err=reqErr&src=" + h + "&lc=" + t.putinVars.lc, 3)
                    }
                }, function(e) {
                    t.sendEvent(n.OnAcComplate, {
                        atype: 6,
                        error: {
                            code: 450
                        }
                    })
                }, 2e3)
            }
        },
        _resolveNonLinearData: function(e, t, a, i) {
            var s, n, r = this, o = H5AD.config, l = {}, d = o.SEND_EVENT_TYPE;
            if (e && e.vast) {
                if (n = e.vast,
                r.setCuidCookie(n.cuid),
                n.code.indexOf("110004") > 0)
                    return void r.sendEvent(d.OnAcComplate, {
                        atype: "6",
                        curAD: {},
                        curIndex: -1,
                        ia: 110
                    });
                if (n.code.indexOf("110006") > -1)
                    return void r.sendEvent(d.OnAcComplate, {
                        atype: "6",
                        curAD: {},
                        curIndex: -1,
                        ia: 7
                    });
                s = n.Ad.length,
                adTools.easyClone(r.staticVars, n),
                r.adPauseQueue = [];
                for (var h = 0, c = 0, p = 0; p < s; p++) {
                    var u = n.Ad[p];
                    if (u.parent) {
                        var g = u.InLine
                          , f = u.cuepoint_type
                          , v = g.Creatives.Creative[0]
                          , m = {};
                        adTools.easyClone(m, u),
                        c = m.order_item_id;
                        var _ = new AdMaterial(this,v.NonLinearAds.NonLinear[0].AdParameters,v.NonLinearAds.NonLinear[0].NonLinearClickThrough,v.NonLinearAds.NonLinear[0].NonLinearClickTracking,v.NonLinearAds.TrackingEvents.Tracking,g.Impression,m.order_item_id,m.order_id,0,f,v.NonLinearAds.NonLinear[0].adzone_id,h,u.lc,u.sub,u.ord);
                        _.isSub = u.parent,
                        l[u.parent] = _
                    } else {
                        var g = u.InLine
                          , f = u.cuepoint_type
                          , v = g.Creatives.Creative[0]
                          , m = {};
                        adTools.easyClone(m, u),
                        c = m.order_item_id;
                        var y = new AdMaterial(this,v.NonLinearAds.NonLinear[0].AdParameters,v.NonLinearAds.NonLinear[0].NonLinearClickThrough,v.NonLinearAds.NonLinear[0].NonLinearClickTracking,v.NonLinearAds.TrackingEvents.Tracking,g.Impression,m.order_item_id,m.order_id,0,f,v.NonLinearAds.NonLinear[0].adzone_id,h,u.lc,u.sub,u.ord)
                          , b = adTools.json(v.NonLinearAds.NonLinear[0].AdParameters);
                        y.adWidth = b.width || 0,
                        y.adHeight = b.height || 0,
                        r.adPauseQueue.push(y)
                    }
                }
                var T = function(e) {
                    r._sendArkTracking(5, e),
                    r._reqThirdPartyNonExchange(e, function(e, t, a, i, s) {
                        if (e && r._sendArkTracking(7, r.adPauseQueue[0]),
                        null == e && null == t && r._sendArkTracking(8, r.adPauseQueue[0]),
                        e || !t) {
                            var n = {};
                            n = l[i],
                            n ? (r.adPauseQueue[0] = n,
                            r.adPauseQueue[0].curAD = n) : r.adPauseQueue = []
                        } else
                            r._sendArkTracking(6, r.adPauseQueue[0]),
                            r.adPauseQueue[0] = t;
                        r.adPauseQueue.length > 0 && r.renderPauseAd()
                    })
                }
                  , E = "";
                if (n.code.indexOf("110004") > -1 && (E = 110),
                r.sendEvent(o.SEND_EVENT_TYPE.OnAcComplate, {
                    oiid: c,
                    atype: "6",
                    ct: "1",
                    ia: E
                }),
                r.adPauseQueue[0] && r.adPauseQueue[0].hasEX) {
                    var x = r.adPauseQueue[0];
                    x.curAD = x,
                    T(x)
                } else
                    r.adPauseQueue[0] && r.adPauseQueue[0].url && r.renderPauseAd()
            } else
                r.callback2Player.call(r, o.CALL_PLAYER_TYPE.playAD, []),
                r.sendEvent(o.EVENT_TYPE.OnAcComplate, {
                    atype: "6",
                    error: {
                        code: 453
                    }
                })
        },
        renderPauseAd: function(e) {
            var t = this;
            if (t.staticVars.pauseCis && !adTools.isMStation && t.isPauseState) {
                var a = ""
                  , i = ""
                  , s = 0
                  , n = 0
                  , r = t.adPauseQueue[0];
                if (r.url) {
                    r && 6 == r.adType && (a = r.url,
                    i = r.iconUrl,
                    s = r.adWidth || 520,
                    n = r.adHeight || 295);
                    var o = t.staticVars.countdownElem
                      , l = adTools.el("#pause_a_content" + t.fid);
                    adTools.existEl(l) && adTools.removeElem(l),
                    l = lib.createElement("div", {
                        id: "pause_a_content" + t.fid,
                        className: "hv_pause_content"
                    });
                    var d = "";
                    i && (d = lib.createElement("img", {
                        id: "dsp_a_ico" + t.fid,
                        src: i,
                        width: "30px",
                        height: "30px"
                    }),
                    d.style.cssText = "z-index:1001;width:25px;height:25px;position:absolute;bottom:2px;left:2px;");
                    var h = lib.createElement("img", {
                        id: "close_a_ico" + t.fid,
                        src: "//i1.letvimg.com/lc06_img/201605/17/14/39/delete@3x.png",
                        width: "30px",
                        height: "30px"
                    });
                    h.style.cssText = "z-index:1001;width:30px;height:30px;position:absolute;top:-15px;right:-15px;",
                    pauseDiv = lib.createElement("div", {
                        id: "pause_a_img_div" + t.fid
                    });
                    var c = null;
                    /^http.+(html)$/.test(a) ? (c = lib.createElement("iframe", {
                        id: "pause_a_img" + t.fid,
                        src: a,
                        frameborder: "no",
                        border: "0",
                        marginwidth: "0",
                        marginheight: "0",
                        scrolling: "no"
                    }),
                    l.style.cssText = "z-index:1000;position: absolute;top: 50%;left: 50%;margin: -147.5px 0 0 -260px;",
                    pauseDiv.style.cssText = "height:295px;overflow: hidden;",
                    c.style.cssText = "height:100%;width:100%;border:0;") : (c = lib.createElement("img", {
                        id: "pause_a_img" + t.fid,
                        src: a
                    }),
                    l.style.cssText = "box-shadow:5px 5px 5px rgb(100, 100, 100); z-index:1000;position: absolute;top: 50%;left: 50%;margin: -147.5px 0 0 -260px;",
                    pauseDiv.style.cssText = "width:520px;height:295px;overflow: hidden;",
                    c.style.cssText = "height:100%;width:100%;border:0;"),
                    d && pauseDiv.appendChild(d),
                    pauseDiv.appendChild(h),
                    pauseDiv.appendChild(c),
                    l.appendChild(pauseDiv),
                    l.style.display = "block",
                    o.appendChild(l),
                    t._sendUserLog(1, {
                        oiid: r.order_item_id,
                        curAD: r,
                        curIndex: 0
                    }),
                    t._sendArkTracking(1, {
                        curAD: r,
                        curIndex: 0
                    }),
                    r.sendEvent("start", t._sendArkTracking);
                    var p = function(e) {
                        e.stopPropagation(),
                        e.cancelBubble = !0,
                        t._sendUserLog(2, {
                            oiid: r.order_item_id,
                            curAD: r,
                            curIndex: 0
                        }),
                        t._sendArkTracking(2, {
                            curAD: r,
                            curIndex: 0
                        }),
                        targetUrl = t._getCtUrl(r, 2),
                        t.pid && t.vid ? t.openInApp(t.pid, t.vid) : r.clickUrl && window.open(targetUrl, "_blank")
                    }
                      , u = function(e) {
                        e.stopPropagation(),
                        e.cancelBubble = !0,
                        t.dynamicVars.pauseOnTime = 0,
                        adTools.existEl(l) && (adTools.removeElem(l),
                        t._sendUserLog(3, {
                            oiid: r.order_item_id,
                            curAD: r,
                            curIndex: 0
                        }),
                        t.adPauseQueue = [])
                    };
                    adTools.bind($js(pauseDiv), p),
                    adTools.bind($js(h), u)
                }
            }
        },
        closePauseRender: function(e) {
            var t = this;
            if (t.isPauseState = 0,
            t.staticVars.pauseCis && !adTools.isMStation) {
                var a = adTools.el("#pause_a_content" + t.fid);
                t.dynamicVars.pauseOnTime = 0,
                adTools.existEl(a) && (adTools.removeElem(a),
                t._sendUserLog(3, {
                    oiid: t.adPauseQueue[0].order_item_id,
                    curAD: t.adPauseQueue[0],
                    curIndex: 0
                }),
                t.adPauseQueue = [])
            }
        },
        retry: function(e) {
            return
        },
        _getUniqueId: function() {
            var e = Math;
            return "ad_" + Array.prototype.join.call(arguments, "_") + String(e.ceil(1e4 * e.random()))
        },
        sendEvent: function(e, t) {
            var a = this;
            try {
                var i = H5AD.config
                  , s = i.SEND_EVENT_TYPE
                  , n = t.curAD;
                if (!n && e != s.OnAcComplate && e != s.OnRefreshAd)
                    return void H5AD.collectError("1827&err=itemIsNull&type=" + e + "&lc=" + a.putinVars.lc, 3);
                switch (e) {
                case s.OnAcComplate:
                    a._sendUserLog(0, t),
                    adTools.debug("AC结束");
                    break;
                case s.OnStart:
                    if (adTools.debug(t.curIndex + " 开始播放广告"),
                    "0" == a.dynamicVars.dur_total && "0" == a.dynamicVars.staAdCount)
                        return;
                    a.dynamicVars.hasPlayed === !1 && (0 == t.curIndex && a._sendUserLog(6, t),
                    a._sendUserLog(1, t),
                    n && !n.mppt && a._sendArkTracking(1, t),
                    n.sendEvent("start", a._sendArkTracking));
                    var r = a.callback2Player.call(a, i.CALL_PLAYER_TYPE.getRealTime);
                    0 == r && (a.playingMonitorCount = a.playingMonitorCount || 0,
                    a.playingMonitor && clearTimeout(a.playingMonitor),
                    a.playingMonitor = setTimeout(function() {
                        if (++a.playingMonitorCount,
                        a.playingMonitorCount > 5)
                            return void (a.playingMonitorCount = null);
                        var e = a.callback2Player.call(a, i.CALL_PLAYER_TYPE.getRealTime);
                        0 == e && a.callback2Player.call(a, i.CALL_PLAYER_TYPE.resumeAD)
                    }, 2e3)),
                    a.dynamicVars.hasPlayed = !0,
                    n.adType == i.AD_STYLE.pre_roll ? (n.seeDetail(),
                    n.iconUrl && n.seeDSPIcon(n.iconUrl),
                    n.closeBigPlay(),
                    n.renderRealCd(a.dynamicVars.dur_total, t, a.dynamicVars.dur),
                    a.playAdTimer = a.playAdTimer || [],
                    clearTimeout(a.playAdTimer[t.curIndex]),
                    a.playAdTimer[t.curIndex] = setTimeout(function() {
                        adTools.debug(t.curIndex + " 广告播放超时"),
                        lib.merge(t, {
                            error: {
                                code: 461
                            }
                        }),
                        a._sendUserLog(1, t),
                        a.callback2Player.call(a, i.CALL_PLAYER_TYPE.stopAD, {
                            reason: 7
                        }),
                        n.closeCountDown()
                    }, 1e3 * n.duration + i.DOWNLOAD_URL_TIMEOUT)) : n.adType == i.AD_STYLE.standard && (n.seeDetail(),
                    n.closeBigPlay(),
                    a.playAdTimer = a.playAdTimer || [],
                    clearTimeout(a.playAdTimer[t.curIndex]),
                    a.playAdTimer[t.curIndex] = setTimeout(function() {
                        adTools.debug(t.curIndex + " 广告播放超时"),
                        lib.merge(t, {
                            error: {
                                code: 461
                            }
                        }),
                        a._sendUserLog(1, t),
                        a.callback2Player.call(a, i.CALL_PLAYER_TYPE.stopAD, {
                            reason: 8
                        }),
                        n.closeSeeDetail()
                    }, 1e3 * n.duration + i.DOWNLOAD_URL_TIMEOUT)),
                    adTools.debug(t.curIndex + " 开始播放广告");
                    break;
                case s.OnComplate:
                    n.adType == i.AD_STYLE.pre_roll ? (n.closeSeeDetail(),
                    n.closeSeeDSPIcon(),
                    n.closeBigPlay(t),
                    t.curIndex + 1 == a.dynamicVars.preAdCount ? n.closeCountDown() : n.pauseCountDown(),
                    t.curIndex + 1 == a.dynamicVars.preAdCount && 0 == a.dynamicVars.staAdCount && a._sendUserLog(7, t)) : n.adType == i.AD_STYLE.standard && (n.closeCountDown(),
                    a._sendUserLog(7, t)),
                    clearTimeout(a.playAdTimer[t.curIndex]),
                    a._sendUserLog(3, t),
                    n.sendEvent("complete", a._sendArkTracking),
                    adTools.debug(t.curIndex + "段广告播放完成"),
                    a.dynamicVars.hasPlayed = !1;
                    break;
                case s.OnClick:
                    break;
                case s.OnPause:
                    a.playingMonitor && clearTimeout(a.playingMonitor),
                    a.playAdTimer && a.playAdTimer.length > 0 && clearTimeout(a.playAdTimer[t.curIndex]),
                    n.pauseCountDown(),
                    n.renderBigPlay(t),
                    adTools.debug(t.curIndex + " 暂停");
                    break;
                case s.OnError:
                    if (a._sendUserLog(1, t),
                    n.adType == i.AD_STYLE.pre_roll) {
                        clearTimeout(a.playAdTimer[t.curIndex]);
                        for (var o = a.dynamicVars.dur_total, l = 0; l < t.curIndex; l++)
                            o -= a.dynamicVars.dur[l];
                        n.closeCountDown()
                    }
                    adTools.debug(t.error, t.curIndex + " 播放器遇到错误，回调"),
                    a.dynamicVars.hasPlayed = !1;
                    break;
                case s.OnASLB:
                    a._sendUserLog(5, t);
                    break;
                case s.OnLoginAc:
                    t.level ? a.putinVars.isvip = 1 : a.putinVars.isvip = 0,
                    n.loginAc(t.level);
                    break;
                case s.OnRefreshAd:
                    adTools.destoryJsonp();
                    var d = $js(".hv_pause_content")[0];
                    adTools.existEl(d) && (a.dynamicVars.pauseOnTime = 0,
                    adTools.removeElem(d),
                    a._sendUserLog(3, {
                        oiid: curPauseAd.order_item_id,
                        curAD: curPauseAd,
                        curIndex: 0
                    }),
                    a.adPauseQueue = []);
                    break;
                case s.OnTimeUpdate:
                    a.adEventDispatcher && a.adEventDispatcher.fire("OnTimeUpdate")
                }
            } catch (h) {
                H5AD.collectError("974," + (h || {}).stack, 3)
            }
        },
        _sendUserLog: function(e, t) {
            t = t || {};
            var a = this
              , i = H5AD.config
              , s = a.putinVars
              , n = a.dynamicVars
              , r = Math;
            n.dur || lib.merge(n, {
                dur: ["-"],
                dur_total: "-",
                adCount: 0
            }),
            _adItem = t.curAD || {};
            var o = {
                act: "event",
                atype: t.atype || _adItem.adType,
                id: "-",
                ia: 0,
                err: 0,
                lc: s.lc || "-",
                ver: "2.0",
                aps: i.H5_ADPLAYER_VER,
                ch: s.yl_channel || s.ch || "letv",
                cid: s.cid || "-",
                ct: _adItem.lc || 0,
                dur: t.dur || n.dur.join("_") || "0",
                dur_total: t.dur || n.dur_total || "0",
                mmsid: s.mmsid || "-",
                pid: s.pid || "-",
                r: r.ceil(r.random() * lib.now()),
                cur_url: encodeURIComponent(location.href),
                ry: n.retry || 0,
                ref: encodeURIComponent(document.referrer) || "-",
                sys: 1,
                uname: s.uname || "-",
                uid: s.uid || "-",
                py: s.up,
                uuid: s.uuid,
                pv: s.ver,
                vid: s.vid || "-",
                vlen: s.gdur || "-",
                p1: s.p1,
                p2: s.p2,
                ontime: n.pauseOnTime || "-",
                p3: s.p3 == s.p3 ? "-" : s.p3,
                ty: s.islive ? 1 : 0,
                ctime: lib.now()
            }
              , l = {
                act: "event",
                aps: i.H5_ADPLAYER_VER,
                cid: s.cid || "-",
                ct: 0,
                dur_total: 0,
                err: 0,
                lc: s.lc || "-",
                p1: s.p1,
                p2: s.p2,
                p3: s.p3 == s.p3 ? "-" : s.p3,
                pid: s.pid || "-",
                r: r.ceil(r.random() * lib.now()),
                ty: s.islive ? 1 : 0,
                uid: s.uid || "-",
                uuid: s.uuid,
                ver: "2.0",
                vid: s.vid || "-",
                astatus: "0",
                ctime: lib.now()
            };
            switch (e) {
            case 0:
                "undefined" != typeof o.py && "" !== o.py && null != o.py ? o.py = o.py + "&ark=" + a.staticVars.arkId : o.py = "ark=" + a.staticVars.arkId,
                o.act = "ac",
                o.ry = i.retryCount,
                o.ia = t.ia || "0",
                o.ry = "0",
                t.error && (o.err = t.error.code),
                o.ut = lib.now() - a.getArkDataTime || 0,
                "3" == o.atype && (o.atype = "13"),
                o.oiid = t.oiid || a.dynamicVars.adidQueue.join("_") || "-",
                a._sendData(H5AD.config.DC_AD_URL + adTools.param(o));
                break;
            case 1:
                if (o.ut = lib.now() - a.downMaterialTimer || 0,
                a.lastCostTime = o.ut,
                t.error) {
                    switch (t.error.code) {
                    case 1:
                        o.err = 460;
                        break;
                    case 2:
                        o.err = 461;
                        break;
                    case 3:
                        o.err = 463;
                        break;
                    case 4:
                        o.err = 469;
                        break;
                    default:
                        o.err = t.error.code || 0
                    }
                    o.loc = encodeURIComponent(_adItem.url)
                }
                "undefined" != typeof o.py && "" !== o.py && null != o.py ? o.py = o.py + "&ark=" + a.staticVars.arkId + "&slotid=" + _adItem.aduid : o.py = "ark=" + a.staticVars.arkId + "&slotid=" + _adItem.aduid,
                o.dur = _adItem.duration,
                o.ftype = "video",
                o.id = e,
                o.ry = i.retryCount,
                o.atype = _adItem.adType,
                o.ord = _adItem.ord || (parseInt(_adItem.curIdx) || 0) + 1,
                o.ct > 0 && o.ord > o.ct && (o.ord = _adItem.ord || 1,
                H5AD.collectError("1129&data=" + o.ord + "&idx=" + _adItem.curIndex + "&lc=" + a.putinVars.lc, 3)),
                o.atype == i.AD_STYLE.standard && (o.dur_total = o.dur,
                o.ord = 1),
                6 == o.atype && (o.ord = 0),
                "3" == o.atype && (o.atype = "13"),
                o.oiid = _adItem.oid || a.dynamicVars.adidQueue[t.curIndex],
                o.nord = _adItem.nord ? _adItem.nord : 0,
                o.parent_id = _adItem.isSub ? _adItem.isSub : 0,
                a._sendData(H5AD.config.DC_AD_URL + adTools.param(o));
                break;
            case 2:
            case 3:
                "undefined" != typeof o.py && "" !== o.py && null != o.py ? o.py = o.py + "&ark=" + a.staticVars.arkId + "&slotid=" + _adItem.aduid : o.py = "ark=" + a.staticVars.arkId + "&slotid=" + _adItem.aduid,
                o.dur = _adItem.duration,
                o.ut = lib.now() - a.downMaterialTimer - a.lastCostTime || 0,
                o.ftype = "video",
                o.id = e,
                o.atype = _adItem.adType,
                o.ord = _adItem.ord || (parseInt(_adItem.curIdx) || 0) + 1,
                o.ct > 0 && o.ord > o.ct && (o.ord = _adItem.ord || 1,
                H5AD.collectError("1129&data=" + o.ord + "&idx=" + _adItem.curIndex + "&lc=" + a.putinVars.lc, 3)),
                o.atype == i.AD_STYLE.standard && (o.dur_total = o.dur,
                o.ord = 1),
                6 == o.atype && (o.ord = 0),
                "3" == o.atype && (o.atype = "13"),
                o.oiid = _adItem.oid || a.dynamicVars.adidQueue[_adItem.curIdx],
                o.nord = _adItem.nord ? _adItem.nord : 0,
                o.parent_id = _adItem.isSub ? _adItem.isSub : 0,
                a._sendData(H5AD.config.DC_AD_URL + adTools.param(o)),
                3 == e && (a.downMaterialTimer = lib.now());
                break;
            case 5:
                adTools.debug("ASLB结束"),
                _adItem.err && (o.loc = encodeURIComponent(_adItem.url),
                o.err = _adItem.err),
                "undefined" != typeof o.py && "" !== o.py && null != o.py ? o.py = o.py + "&ark=" + a.staticVars.arkId + "&slotid=" + _adItem.aduid : o.py = "ark=" + a.staticVars.arkId + "&slotid=" + _adItem.aduid,
                o.act = "aslb",
                o.ut = _adItem.costTime,
                o.ry = "undefined" == typeof _adItem.ryCount ? i.retryCount : _adItem.ryCount,
                o.atype = _adItem.adType,
                o.ord = _adItem.ord || (parseInt(_adItem.curIdx) || 0) + 1,
                o.ct > 0 && o.ord > o.ct && (o.ord = _adItem.ord || 1),
                o.atype == i.AD_STYLE.standard && (o.ord = 1,
                H5AD.collectError("1129&data=" + o.ord + "&idx=" + _adItem.curIndex + "&lc=" + a.putinVars.lc, 3)),
                o.oiid = _adItem.oid || a.dynamicVars.adidQueue[_adItem.curIdx],
                delete o.ct,
                delete o.dur,
                delete o.dur_total,
                delete o.ia,
                "3" == o.atype && (o.atype = "13"),
                o.nord = _adItem.nord ? _adItem.nord : 0,
                o.parent_id = _adItem.isSub ? _adItem.isSub : 0,
                a._sendData(H5AD.config.DC_AD_URL + adTools.param(o));
                break;
            case 6:
                adTools.debug("AB 前置广告开始"),
                l.act = "ab",
                t.error && (l.err = t.error.code),
                "number" == typeof n.preAdLc && (l.ct += n.preAdLc),
                "number" == typeof n.staAdLc && (l.ct += n.staAdLc),
                "number" == typeof n.dur_total && (l.dur_total += n.dur_total),
                "number" == typeof n.stadur && (l.dur_total += n.stadur),
                a._sendData(H5AD.config.DC_AD_URL + adTools.param(l));
                break;
            case 7:
                adTools.debug("AE 前置广告结束"),
                l.act = "ae",
                t.error && (l.err = t.error.code),
                "number" == typeof n.preAdLc && (l.ct += n.preAdLc),
                "number" == typeof n.staAdLc && (l.ct += n.staAdLc),
                "number" == typeof n.dur_total && (l.dur_total += n.dur_total),
                "number" == typeof n.stadur && (l.dur_total += n.stadur),
                a._sendData(H5AD.config.DC_AD_URL + adTools.param(l))
            }
        },
        _getCtUrl: function(e, t) {
            return t = t || 2,
            this._getAttachParam(e.clickUrl, e.aduid, t, 1, e)
        },
        _getAdStyle: function(e) {
            return this.adStyle ? this.adStyle instanceof Array && this.adStyle.length - 1 >= e ? this.adStyle[e] : this.adStyle : null
        },
        _sendArkTracking: function(e, t) {
            var a, i = this, s = [], n = t ? t.curAD : {};
            switch (e) {
            case 1:
                for (s = n.impression,
                a = 0; a < s.length; a++) {
                    var r = "";
                    "object" == typeof s[a] ? s[a].cdata && s[a].cdata.length > 0 && (r = s[a].cdata) : r = s[a],
                    i._sendData(i._getAttachParam, r, n.aduid, e, 1, n),
                    n.impression = []
                }
                break;
            case 2:
                for (s = n.tracking,
                a = 0; a < s.length; a++) {
                    var r = "";
                    "object" == typeof s[a] ? s[a].cdata && s[a].cdata.length > 0 && (r = s[a].cdata) : r = s[a],
                    i._sendData(i._getAttachParam, r, n.aduid, 3, 1, n)
                }
                break;
            case 4:
                s = t;
                var n = arguments[2];
                if (s && s.length > 0)
                    for (a = 0; a < s.length; a++) {
                        var o, r = "";
                        "object" == typeof s[a] ? (s[a].cdata && s[a].cdata.length > 0 && (r = s[a].cdata),
                        o = s[a].type && s[a].type.length > 0 ? s[a].type : e,
                        i._sendData(i._getAttachParam, r, n.aduid, o, 1, n)) : (r = s[a],
                        i._sendData(i._getAttachParam, r, n.aduid, e, 1, n))
                    }
                break;
            case 5:
                if (s = n.reqImpr,
                s && s.constructor == Array)
                    for (a = 0; a < s.length; a++)
                        i._sendData(i._getAttachParam, s[a].cdata, n.aduid, 1, 1, n);
                break;
            case 6:
                if (s = n.reqResult,
                s && s.constructor == Array)
                    for (a = 0; a < s.length; a++)
                        i._sendData(i._getAttachParam, s[a], n.aduid, 4, 1, n);
                break;
            case 7:
                if (s = n.reqError,
                s && s.constructor == Array)
                    for (a = 0; a < s.length; a++)
                        "reach_err_0" === s[a].event && i._sendData(i._getAttachParam, s[a].cdata, n.aduid, 4, 1, n);
                break;
            case 8:
                if (s = n.reqError,
                s && s.constructor == Array)
                    for (a = 0; a < s.length; a++)
                        "reach_err_4" === s[a].event && i._sendData(i._getAttachParam, s[a].cdata, n.aduid, 4, 1, n)
            }
        },
        _getAttachParam: function(e, t, a, i, s) {
            var n = this
              , r = H5AD.config;
            if (s && 6 == s.adType && (s.ord = 0),
            "object" == typeof e && e.cdata)
                return e = e.cdata;
            if (!e || "javascript:void(0)" === e)
                return "javascript:void(0)";
            if (e.indexOf(r.ARK_DOMAIN) > -1) {
                var o = (new Date).getTime()
                  , l = n.staticVars
                  , d = n.putinVars
                  , h = l.stime + Math.ceil((o - n.startTime) / 1e3)
                  , c = s.isSub ? s.isSub : 0
                  , p = s.nord ? s.nord : 0
                  , u = {
                    rt: a,
                    oid: s.oid,
                    im: void 0 === i ? 1 : i,
                    t: h,
                    cuid: l.cuid,
                    data: [t, l.area_id, l.arkId || 0, d.uuid, s.orderid, d.vid || "", d.pid || "", d.cid || "", s.lc || "1", s.adType || "2", n.putinVars.yl_channel || n.putinVars.ch || "letv", adTools.resoSid(n.putinVars.defaultStreamid) || "", s.ord + "" || s.curIdx + 1 || 0, Math.ceil(o / 1e3), 0, n.putinVars.ver, "", 0, "", h, c, "", "", n.staticVars.ptid, n.putinVars.istrylook ? 1 : 0, n.putinVars.vipbrand ? n.putinVars.vipbrand : 0, "", "", p].join(",")
                };
                if (u.s = n._getSecurityKey(u),
                2 == a) {
                    e = n._replaceUrlArguments(e, t, a, i, s);
                    var g = e.split("&u=");
                    e = [g[0], adTools.param(u), "u=" + g[1]].join("&")
                } else
                    e += "&" + adTools.param(u)
            } else
                e = n._replaceUrlArguments(e, t, a, i, s);
            return e
        },
        _replaceUrlArguments: function(e, t, a, i, s) {
            var n = this
              , r = {
                "[randnum]": (new Date).getTime(),
                "[M_IESID]": "LETV_" + t,
                "[M_ADIP]": n.staticVars.ip,
                "[A_ADIP]": n.staticVars.ip,
                __LE_UUID__: n.putinVars.uuid,
                __REQUESTID__: n.putinVars.uuid || ""
            };
            lib.getCookie("ARK_IPX") && (r.__IPDX__ = "letv");
            var o = n.is_need_video_info;
            if (o)
                try {
                    for (var l = o.split("|"), d = "letv_", h = 0; h < l.length; ++h)
                        d += (n.putinVars[l[h]] || 0) + "_";
                    d = d.substr(0, d.length - 1),
                    r.__DRA__ = d,
                    r.__LE_VID__ = r.__VID__ = n.putinVars.vid || ""
                } catch (c) {}
            for (var p in r)
                r.hasOwnProperty(p) && e.indexOf(p) >= 0 && (e = e.replace(p, r[p]));
            return e
        },
        _getSecurityKey: function(e) {
            var t = H5AD.config.crc_table
              , a = 0
              , i = 0
              , s = 0
              , n = ""
              , r = "";
            for (var a in H5AD.config.securityKeys)
                r += e[H5AD.config.securityKeys[a]];
            for (n = r.length,
            a = 0; a < n; a++) {
                var o = r.charCodeAt(a)
                  , l = 15 & i | (15 & o) << 4;
                s = t[l],
                i = i >> 4 ^ s,
                s = t[15 & i | 240 & o],
                i = i >> 4 ^ s
            }
            return i.toString(16)
        },
        _sendData: function(e) {
            var t = e;
            if ("function" == typeof arguments[0] && (t = arguments[0].apply(this, [].slice.call(arguments, 1))),
            t && "" != t) {
                var a = lib.createElement("img", {
                    src: t
                });
                adTools.debug("发起url : " + t),
                $js(a).on("load", function() {
                    a = null
                })
            }
        },
        setCuidCookie: function(e) {
            var t = lib.getCookie("ark_uuid");
            return location.host.indexOf(".le.com") >= 0 && e && (!t || t != e) && (t = e,
            lib.setCookie("ark_uuid", e, {
                expires: new Date(2060,0,1,8,0,1),
                domain: "le.com"
            })),
            t
        }
    },
    H5AD.collectError = function(e, t) {}
    ,
    H5AD.adEvent = function() {
        this.ad_eventlistener = {}
    }
    ,
    H5AD.adEvent.prototype = {
        on: function(e, t, a) {
            var i = this.ad_eventlistener[e];
            void 0 === i && (i = [],
            this.ad_eventlistener[e] = i);
            var s = {
                type: e,
                func: t,
                context: a
            };
            return i.push(s),
            s
        },
        off: function(e, t, a) {
            var i = this.ad_eventlistener[e];
            if (void 0 !== i)
                for (var s = i.length, n = 0; n < s; n++) {
                    var r = i[n];
                    if (r.type == e && r.context === a)
                        return void i.splice(n, 1)
                }
        },
        fire: function(e, t) {
            var a = this.ad_eventlistener[e];
            if (void 0 !== a)
                for (var i = a.length, s = 0; s < i; s++) {
                    var n = a[s]
                      , r = n.func
                      , o = n.context;
                    null != o ? r.call(o, t) : r(t)
                }
        }
    },
    AdMaterial.prototype = {
        resolveAdParam: function(e) {
            var t = adTools.json(e);
            t.hdurl && t.hdurl.length > 0 && adTools.getDeviceSize.x > 960 && adTools.getDeviceSize.y > 640 ? (this.url = t.hdurl,
            this.url && this.url.indexOf("https:") >= 0 ? this.url = this.url.replace("https:", "") : this.url && this.url.indexOf("http:") >= 0 && (this.url = this.url.replace("http:", ""))) : t.hpg_url && t.hpg_url.length > 0 ? (this.url = t.hpg_url,
            this.hasMZ = !0) : t.reachmax_data_url && t.reachmax_data_url.length > 0 ? (this.url = t.reachmax_data_url,
            this.hasEX = !0) : this.url = t.url,
            t.mppt && (this.mppt = parseInt(t.mppt) || 0),
            t.is_need_video_info && (this.h5ad.is_need_video_info = t.is_need_video_info),
            "1" !== t.sg && void 0 !== t.sg && adTools.isMStation !== !1 || (this.renderCd = !0),
            t.duration && (this.duration = parseInt(t.duration)),
            this.pid = t.pid || 0,
            this.vid = t.vid || 0
        },
        initEvent: function() {
            var e, t, a, i = H5AD.config.PROCESS_EVENT_TICKS;
            if (this.progressTicks = [],
            this.hasEX || this.hasMZ) {
                if (this.reqImpr = [],
                this.mppt) {
                    var s, n;
                    if (this.impression && this.impression.length > 0)
                        for (t = 0; t < this.impression.length; t++)
                            n = this.impression[t],
                            s = {
                                event: "progress",
                                cdata: n.cdata,
                                offset: this.mppt,
                                type: "2" == n.type ? "2" : "1",
                                isimpression: !0
                            },
                            this.progressTicks.push(parseFloat(this.mppt)),
                            this.event.push(s)
                } else
                    this.reqImpr = this.impression;
                this.reqResult = [],
                this.reqError = [],
                this.impression = []
            }
            if (this.event && this.event.length > 0)
                for (t = 0; t < this.event.length; t++) {
                    if (e = this.event[t],
                    this.hasEX || this.hasMZ) {
                        if ("reachs" == e.event) {
                            var s;
                            this.mppt ? (s = {
                                event: "progress",
                                cdata: e.cdata,
                                offset: this.mppt,
                                type: "4"
                            },
                            this.progressTicks.push(parseFloat(this.mppt))) : s = {
                                cdata: e.cdata,
                                event: "start",
                                type: "4"
                            },
                            this.event.push(s);
                            continue
                        }
                        if ("reachr" == e.event) {
                            this.reqResult.push(e.cdata);
                            continue
                        }
                        if (/^reach_err/.test(e.event)) {
                            this.reqError.push(e);
                            continue
                        }
                    }
                    if (void 0 != e.offset)
                        this.progressTicks.push(parseFloat(e.offset));
                    else
                        for (a = 0; a < i.length; a++)
                            e.event == i[a].k && (this.event[t].event = "progress",
                            this.event[t].offset = this.duration * i[a].v || 0,
                            this.progressTicks.push(parseFloat(this.event[t].offset)))
                }
            this.h5ad.curAd = this
        },
        sendEvent: function(e, t, a) {
            try {
                var i = this.getTrackArr(e, a);
                t.call(this.h5ad, 4, i, this)
            } catch (s) {
                adTools.debug("进度监测出错" + s.stack)
            }
        },
        getTrackArr: function(e, t) {
            var a, i = [];
            if (this.event && this.event.length > 0)
                for (a = 0; a < this.event.length; a++)
                    this.event[a].event == e && (void 0 != t ? t == this.event[a].offset && (this.mppt && this.event[a].isimpression ? i.push(this.event[a]) : i.push(this.event[a].cdata),
                    this.event[a].event = "hadSent") : (this.mppt && this.event[a].isimpression ? i.push(this.event[a]) : i.push(this.event[a].cdata),
                    this.event[a].event = "hadSent"));
            return i
        },
        processMonitor: function() {
            var e = this
              , t = e.h5ad
              , a = H5AD.config.CALL_PLAYER_TYPE
              , i = 0
              , s = function() {
                return i = t.callback2Player(a.getRealTime) || 0,
                isNaN(i) && (i = 0),
                e.mppt && Math.abs(i - e.mppt) < 1 && t._sendArkTracking(1, {
                    curAD: e,
                    curIndex: e.curIdx
                }),
                i - t.lastPlayTime > 2 ? void t.callback2Player.call(t, a.seek, t.lastPlayTime) : void (t.lastPlayTime = i)
            };
            t.adEventDispatcher && (t.adEventDispatcher.off("OnTimeUpdate", s),
            t.adEventDispatcher.on("OnTimeUpdate", s))
        },
        languageFit: function(e) {
            var t = e.toString()
              , a = this.h5ad.callback2Player(H5AD.config.CALL_PLAYER_TYPE.lanfit, t);
            return a
        },
        renderRealCd: function(e, t, a) {
            var i, s, n, r, o, l, d = this, h = e, c = 0, p = Math, u = this.h5ad, g = adTools.el("#div_cdown" + d.h5ad.fid), f = adTools.el("#div_vip_recommend" + d.h5ad.fid), v = e, m = u.putinVars.tplType, _ = m && /^min|^simple/.test(m), y = _ ? 12 : 24;
            if (d.processMonitor(),
            d.progressTicks.length > 0 ? (clearInterval(d.processTimer),
            d.processTimer = setInterval(function() {
                l = u.callback2Player(H5AD.config.CALL_PLAYER_TYPE.getRealTime) || 0;
                for (var e = 0; e < d.progressTicks.length; e++)
                    if (p.abs(d.progressTicks[e] - l) <= 1 && (adTools.debug("进度监测：offset:" + d.progressTicks[e] + ",curTime:" + l + "," + e),
                    d.sendEvent("progress", u._sendArkTracking, d.progressTicks[e]),
                    d.progressTicks.splice(e, 1),
                    --e,
                    0 == d.progressTicks.length)) {
                        clearInterval(d.processTimer);
                        break
                    }
            }, 1e3)) : clearInterval(d.processTimer),
            adTools.canBeClicked || !adTools.iosNotPlayInline) {
                if (1 != d.renderCd)
                    return void adTools.removeElem(adTools.el("#vdo_post_time" + d.h5ad.fid));
                for (i = d.curIdx; i >= 0; i--)
                    v -= a[i];
                var b = function(e, t, a) {
                    if ("-" == e)
                        if (a instanceof Array) {
                            for (var i = 0, s = 0; s < a.length; s++)
                                i += a[s];
                            e = i
                        } else
                            e = "--";
                    var r = e;
                    for (n = r.toString().length,
                    s = 0; s < d.curIdx; s++)
                        r -= a[s];
                    return c = u.callback2Player(H5AD.config.CALL_PLAYER_TYPE.getRealTime) || 0,
                    r -= p.ceil(c)
                };
                s = b.apply(this, arguments);
                var T = function(e) {
                    var t, a = e.toString(), i = "";
                    for (t = 0; t < n; t++)
                        i += '<em id="cd' + u.fid + "_" + String(t) + '" class="precdImg" style="' + (a.length < 2 ? "float:right;" : "") + "background-image:url(" + H5AD.config.COUNTDOWN_IMG_URL + ");background-position:0 " + -parseInt(a.charAt(t)) * y + 'px;background-repeat: no-repeat;"></em>';
                    return i
                }
                  , E = function() {
                    if (adTools.existEl(f))
                        o = adTools.el("#div_vip_recommend" + d.h5ad.fid);
                    else {
                        o = lib.createElement("div", {
                            className: "vdo_post_time",
                            id: "div_vip_recommend" + d.h5ad.fid
                        });
                        var e = "14px"
                          , t = "24px"
                          , a = "24px";
                        adTools.isMStation && (e = "4px",
                        t = "20px",
                        a = "18px"),
                        o.innerHTML = ['<div class="vdo_post_rlt">', '<div class="vdo_time_bg"></div>', '<div class="vdo_time_info"><span style="margin-top:' + e + '" id="div_vip_icon' + d.h5ad.fid + '"></span><a style="color:#e1c096;" href="javascript:;" > 会员电影推荐</a></div>', "</div>"].join(""),
                        o.style.cssText = "left:10px;right: auto;",
                        u.staticVars.countdownElem.appendChild(o),
                        $js("#div_vip_icon" + d.h5ad.fid)[0].innerHTML = '<em id="vip_cd' + d.h5ad.fid + '" class="precdImg" style="background-image:url(' + H5AD.config.VIP_ICON_IMG_URL + ");background-repeat: no-repeat;width:" + t + ";height:" + a + ';"></em>'
                    }
                };
                if (adTools.existEl(g))
                    r = adTools.el("#div_cdown" + d.h5ad.fid);
                else {
                    r = lib.createElement("div", {
                        className: "vdo_post_time",
                        id: "vdo_post_time" + d.h5ad.fid
                    });
                    var x = '<a href="javascript:;" id="vdo_skip_pre' + d.h5ad.fid + '"> ' + d.languageFit("跳过广告") + "</a>";
                    adTools.isMStation && (x = '<a href="https://ibuy.le.com/v2/buy/package.html?ref=m_play_1201_010" id="vdo_skip_pre_clickthrough' + d.h5ad.fid + '"> ' + d.languageFit("会员免广告") + "</a>"),
                    d.h5ad.putinVars.isvip && 1 == d.h5ad.putinVars.isvip && (x = x = '<a href="javascript:;" id="vdo_close_recommend_pre' + d.h5ad.fid + '"> 关闭此推荐</a>',
                    E()),
                    r.innerHTML = ['<div class="vdo_post_rlt">', '<div class="vdo_time_bg"></div>', '<div class="vdo_time_info"><span id="div_cdown' + d.h5ad.fid + '"></span>' + x + "</div>", "</div>"].join(""),
                    u.staticVars.countdownElem.appendChild(r),
                    $js("#vdo_skip_pre" + d.h5ad.fid).on("click", function() {
                        d.skipAd()
                    }),
                    $js("#div_cdown" + d.h5ad.fid)[0].innerHTML = T(s),
                    $js("#vdo_close_recommend_pre" + d.h5ad.fid).on("click", function() {
                        u._sendUserLog(3, {
                            curAD: d,
                            curIndex: t.curIndex
                        }),
                        clearTimeout(u.playAdTimer[t.curIndex]),
                        d.loginAc(null, !0)
                    })
                }
                clearInterval(d.countdownTimer),
                d.countdownTimer = setInterval(function() {
                    var s = b(h, t, a);
                    if (s < 0)
                        return void d.closeCountDown();
                    if (s < v)
                        return void d.pauseCountDown();
                    var n = s.toString()
                      , r = e.toString().length - n.length;
                    if (i = 0,
                    r > 0)
                        for (i = 0; i < r; i++)
                            adTools.el("#cd" + u.fid + "_" + String(i)).style.backgroundPosition = "0 -" + (_ ? 122 : 244) + "px";
                    for (j = n.length - 1; j >= 0; j--) {
                        var o = parseInt(n.charAt(j)) * y
                          , l = adTools.el("#cd" + u.fid + "_" + String(j + i));
                        if (!adTools.existEl(l))
                            return clearInterval(d.countdownTimer),
                            clearInterval(d.processTimer),
                            void clearInterval(d.monitorTimer);
                        l.style.backgroundPosition = "0 " + -o + "px"
                    }
                }, 500)
            }
        },
        renderBigPlay: function(e) {
            if (adTools.canBeClicked || !adTools.iosNotPlayInline) {
                var t = this
                  , a = this.h5ad
                  , i = a.staticVars.countdownElem
                  , s = adTools.el("#btn_a_resume" + a.fid);
                adTools.existEl(s) && adTools.removeElem(s),
                s = lib.createElement("div", {
                    id: "btn_a_resume" + a.fid,
                    className: "hv_ico_pasued"
                }),
                s.style.display = "block",
                s.innerHTML = "<span></span>",
                i.appendChild(s),
                adTools.bind($js(s), function(i) {
                    i.stopPropagation(),
                    i.cancelBubble = !0,
                    t.closeBigPlay(e),
                    a.callback2Player(H5AD.config.CALL_PLAYER_TYPE.resumeAD)
                })
            }
        },
        seeDetail: function() {
            var e = this.h5ad;
            if (adTools.canBeClicked || !adTools.iosNotPlayInline) {
                var t = this
                  , a = adTools.el("#a_see_detail" + e.fid)
                  , i = adTools.el("#a_see_more" + e.fid)
                  , s = e.staticVars.countdownElem
                  , n = adTools.el(e.staticVars.countdownID + " .hv_ico_pasued")
                  , r = "javascript:;";
                if (adTools.existEl(i))
                    ;
                else {
                    a = lib.createElement("a", {
                        target: "_blank",
                        href: r,
                        id: "a_see_detail" + e.fid,
                        className: "aps_mask_cont"
                    }),
                    i = lib.createElement("div", {
                        className: "vdo_post_detail",
                        id: "vdo_post_detail" + e.fid
                    }),
                    i.innerHTML = ['<div class="vdo_post_rlt">', ' <div class="vdo_detail_bg"></div>', '<div class="vdo_detail_info"><a id="a_see_more' + e.fid + '" href="' + r + '" target="_blank"><span style="float:left">' + t.languageFit("了解详情") + "</span><i></i></a></div>", "</div>"].join(""),
                    adTools.existEl(n) ? (adTools.isUC || s.insertBefore(a, n),
                    s.insertBefore(i, n)) : (adTools.isUC || s.appendChild(a),
                    s.appendChild(i));
                    var o = function(a) {
                        a.stopPropagation(),
                        a.cancelBubble = !0,
                        e.dynamicVars.hasPlayed !== !1 && (r = e._getCtUrl(t, 2),
                        e.callback2Player(H5AD.config.CALL_PLAYER_TYPE.pauseAD),
                        e._sendUserLog(2, {
                            curAD: t,
                            curIndex: 0
                        }),
                        e._sendArkTracking(2, {
                            curAD: t,
                            curIndex: 0
                        }),
                        t.pid && t.vid ? t.openInApp(t.pid, t.vid) : window.open(r, "_blank"))
                    };
                    adTools.bind($js(a), o),
                    adTools.bind($js(i), o)
                }
            }
        },
        seeDSPIcon: function(e) {
            var t = this.h5ad;
            if (adTools.canBeClicked || !adTools.iosNotPlayInline) {
                var a = adTools.el("#vdo_dsp_icon" + t.fid)
                  , i = t.staticVars.countdownElem
                  , s = adTools.el(t.staticVars.countdownID + " .hv_ico_pasued");
                e ? adTools.existEl(a) ? adTools.el("#img_dsp_icon" + this.h5ad.fid).setAttribute("src", e) : (a = lib.createElement("div", {
                    className: "vdo_dsp_icon",
                    id: "vdo_dsp_icon" + t.fid
                }),
                a.style.cssText = "height:25px;position:absolute;z-index:13;left:2px;bottom:2px;",
                a.innerHTML = ['<img id="img_dsp_icon' + t.fid + '" src="' + e + '" height="25" width="25">'].join(""),
                adTools.existEl(s) ? i.insertBefore(a, s) : i.appendChild(a)) : adTools.existEl(a) && adTools.removeElem(a)
            }
        },
        openInApp: function(e, t, a) {
            var i = "letvclient://msiteAction?actionType=0&pid=" + encodeURIComponent(e) + "&vid=" + encodeURIComponent(t) + "&from=mletv";
            if (br.Android) {
                var s = document.createElement("iframe");
                s.style.cssText = "width:0px;height:0px;position:fixed;top:0;left:0;",
                s.src = i,
                document.body.appendChild(s)
            } else
                location.href = i
        },
        closeSeeDetail: function() {
            if (adTools.canBeClicked || !adTools.iosNotPlayInline) {
                var e = adTools.el("#a_see_detail" + this.h5ad.fid)
                  , t = adTools.el("#vdo_post_detail" + this.h5ad.fid);
                adTools.existEl(e) && adTools.removeElem(e),
                adTools.existEl(t) && adTools.removeElem(t)
            }
        },
        closeSeeDSPIcon: function() {
            if (adTools.canBeClicked || !adTools.iosNotPlayInline) {
                var e = adTools.el("#vdo_dsp_icon" + this.h5ad.fid);
                adTools.existEl(e) && adTools.removeElem(e)
            }
        },
        closeBigPlay: function(e) {
            if (adTools.canBeClicked || !adTools.iosNotPlayInline) {
                var t = this.h5ad
                  , a = adTools.el("#btn_a_resume" + t.fid);
                adTools.existEl(a) && adTools.removeElem(a)
            }
        },
        closeCountDown: function() {
            if (clearInterval(this.monitorTimer),
            adTools.canBeClicked || !adTools.iosNotPlayInline) {
                clearInterval(this.countdownTimer),
                clearInterval(this.processTimer);
                var e = adTools.el("#vdo_post_time" + this.h5ad.fid);
                adTools.existEl(e) && (this.pauseCountDown(),
                adTools.removeElem(e));
                var t = adTools.el("#div_vip_recommend" + this.h5ad.fid);
                adTools.existEl(t) && adTools.removeElem(t),
                this.closeBigPlay(),
                this.closeSeeDetail(),
                this.closeSeeDSPIcon()
            }
        },
        pauseCountDown: function() {
            clearInterval(this.monitorTimer),
            !adTools.canBeClicked && adTools.iosNotPlayInline || (clearInterval(this.countdownTimer),
            clearInterval(this.processTimer))
        },
        skipAd: function(e) {
            var t, a = this.h5ad, i = H5AD.config, s = i.CALL_PLAYER_TYPE, n = a.callback2Player, r = a.staticVars.countdownElem;
            t = adTools.el("#aps_login" + a.fid),
            n.call(a, s.pauseAD),
            adTools.existEl(t) || (t = lib.createElement("div", {
                className: "aps_pop_poster",
                id: "aps_login" + a.fid
            }),
            t.innerHTML = ['<div class="hv_pop_poster">', '<p class="hv_p1">' + this.languageFit("如果您已是会员，请登录") + "</p>", '<p><a href="javascript:;" id="aps_login_button' + a.fid + '">' + this.languageFit("登录") + "</a></p>", '<a href="javascript:;" id="aps_login_close" class="close"><i></i><i class="i_1"></i></a></div>'].join(""),
            r.appendChild(t),
            a._sendData(i.SKIP_AD_CLICK),
            $js("#aps_login_button" + a.fid).on("click", function(e) {
                n(s.doLogin)
            }),
            $js("#aps_login_close").on("click", function(e) {
                n.call(a, s.resumeAD),
                adTools.removeElem(adTools.el("#aps_login" + a.fid))
            })),
            adTools.debug("点击跳过广告")
        },
        loginAc: function(e, t) {
            var a = this.h5ad
              , i = H5AD.config
              , s = i.CALL_PLAYER_TYPE
              , n = a.callback2Player;
            t ? (n(s.stopAD, {
                reason: 9
            }),
            this.closeCountDown()) : e ? (n(s.stopAD, {
                reason: 9
            }),
            this.closeCountDown(),
            a._sendData(i.SKIP_AD_SUCC)) : n(s.resumeAD),
            adTools.debug("登录完成，返回level：" + e),
            adTools.removeElem($js(".aps_pop_poster")[0])
        }
    },
    module.exports = H5AD
}
, function(e, t, a) {
    var i = a(47)
      , s = a(3)
      , n = a(2)
      , r = function(e, t) {
        r.superClass.constructor.call(this, e, t),
        this.active = {
            isDrag: !1
        }
    };
    s.extend(r, i);
    var o = {
        init: function() {
            r.superClass.init.call(this)
        },
        initPoster: function(e) {
            if (e) {
                var t;
                if ("object" == typeof e) {
                    var a = this.dom.parentEl.width()
                      , i = this.dom.parentEl.height()
                      , s = a / i
                      , n = [];
                    for (var r in e) {
                        var o = r.split("*");
                        2 == o.length && n.push({
                            pw: o[0],
                            ph: o[1],
                            prd: Math.abs(o[0] / o[1] - s),
                            url: e[r]
                        })
                    }
                    n.length && (n.sort(function(e, t) {
                        return e.prd - t.prd
                    }),
                    n[0].prd <= .3 && a / n[0].pw <= 1.3 && (t = n[0].url)),
                    t || (a && i || (a = 320,
                    i = 180),
                    t = e.defaultPic + a + "_" + i + ".jpg")
                } else
                    t = e;
                var m = this.dom.parentEl.find(".html5video")[0];
				m.poster = t;
				var l = this.dom.parentEl.find(".hv_play_poster")[0];
                l.style.backgroundImage = "url(" + t + ")",
                l.style.display = "block"
            }
        },
        initChildren: function() {
            var e;
            switch (this.tplType) {
            case "base":
                e = ["/playingPannel", "/defiBtn", "/playBtn", "/nextVideoBtn", "/fullScreenBtn", "/progressBar", "/popTip", "/tip"],
                n.Android || n.isPC || e.push("/shotcutSeek"),
                this.playerData.config.hideBarrage || e.push("/barrageBtn"),
                n.isPC && e.push("/settingBtn");
                break;
            case "minBase":
                e = ["/playingPannel", "/playBtn", "/fullScreenBtn", "/progressBar", "/popTip", "/tip"],
                this.playerData.config.hideBarrage || e.push("/barrageBtn");
                break;
            case "simple":
                e = ["/simplePlayingPannel", "/popTip"];
                break;
            case "IPhone":
                e = ["/iphonePlayingPannel", "/popTip"]
            }
            for (var t = 0, i = e.length; t < i; t++) {
                var s = a(48)("." + e[t]);
                this.manager.register(new s(this))
            }
        }
    };
    s.merge(r.prototype, o),
    e.exports = r
}
, function(e, t, a) {
    var i = a(23)
      , s = a(3)
      , n = (a(2),
    a(21))
      , r = function(e, t) {
        this.tplType = e,
        this.dom = t,
        this.sendLogTime = 0,
        this.sendLogCount = 0,
        this.hasSend = !1
    };
    s.extend(r, i);
    var o = {
        init: function() {
            this.coreVideo = {
                getCurrentTime: s.bind(function() {
                    return this.manager.coreVideo.getCurrentTime()
                }, this),
                getBuffered: s.bind(function() {
                    return this.manager.coreVideo.getBuffered()
                }, this)
            },
            this.playerData = this.manager.playerData,
            this.initChildren(),
            this.manager.evt.trigger(n.EVENT.RESIZE),
            this.manager.evt.on("vjs_setPoster", function(e) {
                this.initPoster(e.args[0])
            }, this),
            this.dom.cont.on("touchstart", function(e) {
                if (!this.hasSend) {
                    var t = (new Date).getTime();
                    t - this.sendLogTime <= 500 && e.touches && 3 == e.touches.length ? ++this.sendLogCount >= 6 && (this.hasSend = !0,
                    this.manager.log.send({
                        forceSend: !0,
                        phone: "hack send"
                    }),
                    this.sendLogCount = 0) : this.sendLogCount = 0,
                    this.sendLogTime = t
                }
            }, this)
        },
        initChildren: function() {
            throw "need defined the function of Component.initChildren"
        },
        initPoster: function(e) {
            if (e) {
                var t = this.dom.parentEl.find(".hv_play_poster")[0];
                t.style.backgroundImage = "url(" + e + ")",
                t.style.display = "block"
            }
        },
        togglePlayer: function(e) {
            this.dom.parentEl[0].style.display = e ? "block" : "none"
        }
    };
    s.merge(r.prototype, o),
    e.exports = r
}
, function(e, t, a) {
    function i(e) {
        return a(s(e))
    }
    function s(e) {
        return n[e] || function() {
            throw new Error("Cannot find module '" + e + "'.")
        }()
    }
    var n = {
        "./appBtn": 49,
        "./appBtn.js": 49,
        "./barrageBtn": 51,
        "./barrageBtn.js": 51,
        "./component": 46,
        "./component.js": 46,
        "./defiBtn": 52,
        "./defiBtn.js": 52,
        "./fullScreenBtn": 53,
        "./fullScreenBtn.js": 53,
        "./iphonePlayingPannel": 54,
        "./iphonePlayingPannel.js": 54,
        "./nextVideoBtn": 55,
        "./nextVideoBtn.js": 55,
        "./playBtn": 56,
        "./playBtn.js": 56,
        "./playingPannel": 57,
        "./playingPannel.js": 57,
        "./popTip": 58,
        "./popTip.js": 58,
        "./progressBar": 59,
        "./progressBar.js": 59,
        "./settingBtn": 61,
        "./settingBtn.js": 61,
        "./shotcutSeek": 62,
        "./shotcutSeek.js": 62,
        "./simplePlayingPannel": 63,
        "./simplePlayingPannel.js": 63,
        "./tip": 64,
        "./tip.js": 64,
        "./tpl": 31,
        "./tpl.js": 31
    };
    i.keys = function() {
        return Object.keys(n)
    }
    ,
    i.resolve = s,
    e.exports = i,
    i.id = 48
}
, function(e, t, a) {
    var i = a(23)
      , s = a(3)
      , n = a(21)
      , r = a(50)
      , o = function(e) {
        this.contDom = e.dom.cont,
        this.parentEl = e.dom.parentEl
    };
    s.extend(o, i);
    var l = {
        init: function() {
            this.playerData = this.manager.playerData,
            this.nodes = {
                appPlay: this.parentEl.find(".hv_app_play")
            },
            this.isShow = !1,
            this.addEvent()
        },
        addEvent: function() {
            this.nodes.appPlay.on("touchend", function() {
                r.init({
                    vid: this.playerData.vinfo.vid
                })
            }, this),
            this.manager.listener.on(n.IS_AD, function(e, t) {
                this.toggleAppBtn(!t)
            }, this),
            this.manager.evt.on("vjs_toggleAppBtn", function(e) {
                this.toggleAppBtn(e.args[0])
            }, this),
            this.manager.evt.on(n.EVENT.RESIZE, this.onResize, this)
        },
        toggleAppBtn: function(e) {
            e && this.isShow ? this.nodes.appPlay[0].style.display = "block" : e || (this.nodes.appPlay[0].style.display = "none")
        },
        onResize: function() {
            this.contDom.width() > 410 ? (this.nodes.appPlay[0].style.display = "block",
            this.isShow = !0) : (this.nodes.appPlay[0].style.display = "none",
            this.isShow = !1)
        }
    };
    s.merge(o.prototype, l),
    e.exports = o
}
, function(e, t) {
    var a = {
        init: function(e) {
            if (/from=appjump/.test(window.location.href))
                return !1;
            var t = e.vid
              , a = 0
              , i = 0;
            url = "iPadLetvClient://msiteAction?actionType=" + i + "&vid=" + (t || 0) + "&pid=" + (a || 0) + "&from=pcsite",
            targetDownloadUrl = "https://itunes.apple.com/cn/app/le-shi-ying-shihd/id412395632?mt=8";
            var s = document.createElement("iframe");
            s.style.display = "none";
            var n, r = document.body, o = function(t, a) {
                !e.isOnlyOpen && a && (location.href = targetDownloadUrl),
                window.removeEventListener("pagehide", l, !0),
                window.removeEventListener("pageshow", l, !0),
                s && (s.onload = null,
                r.removeChild(s),
                s = null)
            }, l = function(e) {
                clearTimeout(n),
                o(e, !1)
            };
            window.addEventListener("pagehide", l, !0),
            window.addEventListener("pageshow", l, !0),
            s.onload = o,
            s.src = url,
            r.appendChild(s);
            var d = +new Date;
            n = setTimeout(function() {
                n = setTimeout(function() {
                    var e = +new Date;
                    d - e > 1300 ? o(null, !1) : o(null, !0)
                }, 1200)
            }, 60)
        }
    };
    e.exports = a
}
, function(e, t, a) {
    var i = a(23)
      , s = (a(6),
    a(3))
      , n = a(21)
      , r = function(e) {
        this.contDom = e.dom.cont,
        this.parentEl = e.dom.parentEl,
        this.coreVideo = e.coreVideo
    };
    s.extend(r, i);
    var o = {
        init: function() {
            this.playerData = this.manager.playerData,
            this.isOn = !1,
            this.inputText = "",
            this.isShowInput = !1,
            this.isended = !1,
            this.vertical = !0,
            this.isflag = !1,
            this.nodes = {
                barrageBtn: this.parentEl.find(".hv_ico_barrage"),
                showBtn: this.parentEl.find(".btn_barrage_wrap"),
                barrageInput: this.parentEl.find(".b_input_Barrge"),
                sendBtn: this.parentEl.find(".b_send"),
                closeBtn: this.parentEl.find(".b_close"),
                Inputbar: this.parentEl.find(".hv_barrage_cmt"),
                textTotal: this.parentEl.find(".b_cmt_count"),
                fakeInput: this.parentEl.find(".hv_screen_input")
            },
            this.addEvent(),
            this.manager.listener.on(n.PLAY_STATE, function(e, t) {
                this.isflag && ("ended" == t || "stop" == t ? (this.isended = !0,
                this.isShowInput = !1,
                this.nodes.barrageBtn.setStyle("display", "none"),
                this.nodes.showBtn.setStyle("display", "none"),
                this.nodes.Inputbar.setStyle("display", "none"),
                this.hideFakeInput(),
                this.manager.evt.trigger("vjs_toggleInput", !1)) : "play" == t ? (this.nodes.fakeInput.setStyle("display", "none"),
                this.isended = !1,
                this.playerData.config.Barrage ? this.playerData.config.hideBarrage || (this.nodes.barrageBtn.setStyle("display", "block"),
                this.manager.evt.trigger("vjs_showbarrageBtn"),
                "PC" != this.playerData.interactiveType ? this.nodes.showBtn.setStyle("display", this.isOn ? "block" : "none") : "min" == this.playerData.flashVar.UIType && (this.nodes.showBtn.setStyle("display", "block"),
                this.nodes.Inputbar.setStyle("display", "none"))) : this.nodes.barrageBtn.setStyle("display", "none")) : "init" == t ? (this.nodes.Inputbar.setStyle("display", "none"),
                this.isended = !1) : this.isended = !1)
            }, this),
            this.manager.listener.on(n.BARRAGE_STATE, function(e, t) {
                t ? (this.isOn = localStorage.getItem("barrgeState") ? "false" != localStorage.getItem("barrgeState") : t,
                this.playerData.config.Barrage && this.isOn && this.nodes.barrageBtn.addClass("active"),
                "PC" == this.playerData.interactiveType && ("min" == this.playerData.flashVar.UIType ? (this.nodes.showBtn.setStyle("display", "block"),
                this.nodes.Inputbar.setStyle("display", "none")) : (this.nodes.showBtn.setStyle("display", "none"),
                this.nodes.closeBtn[0].innerHTML = "",
                this.nodes.closeBtn.setStyle("cursor", "default")))) : (this.isOn = !1,
                this.nodes.barrageBtn.removeClass("active"),
                this.nodes.Inputbar.setStyle("display", "none"),
                this.nodes.showBtn.setStyle("display", "none"),
                this.nodes.fakeInput.setStyle("display", "none"))
            }, this)
        },
        addEvent: function() {
            "PC" == this.playerData.interactiveType ? (this.nodes.barrageBtn.on("click", this.toggleBarrge, this),
            this.nodes.showBtn.on("click", this.toggleInputArea, this),
            this.nodes.sendBtn.on("click", this.toSendBarrge, this),
            this.nodes.closeBtn.on("click", this.closeBarrge, this),
            this.nodes.barrageInput.on("input", this.changeBarrge, this)) : (this.nodes.barrageBtn.on("touchend", this.toggleBarrge, this),
            this.nodes.sendBtn.on("touchend", this.toSendBarrge, this),
            this.nodes.closeBtn.on("touchend", this.closeBarrge, this)),
            this.nodes.fakeInput.on("focus", this.inputFocus, this),
            this.nodes.fakeInput.on("input", this.changeBarrge, this),
            this.manager.evt.on("vjs_showInputPannel", this.toggleBarrgeInput, this),
            this.manager.evt.on("vjs_setBarrageState", this.setBarrageState, this),
            this.manager.evt.on(n.EVENT.RESIZE, this.onResize, this);
            var e = this;
            document.onkeydown = function(t) {
                "13" == t.which && e.toSendBarrge()
            }
            ,
            this.manager.evt.on("vjs_danmuSucc", function() {
                this.isflag = !0
            }, this)
        },
        setBarrageState: function(e) {
            e.args[0] != this.isOn && this.toggleBarrge()
        },
        toggleBarrge: function() {
            this.isOn = !this.isOn,
            this.isOn ? (this.nodes.barrageBtn.addClass("active"),
            "PC" == this.playerData.interactiveType ? this.playerData.config.hideBarrage || ("min" == this.playerData.flashVar.UIType ? this.nodes.showBtn.setStyle("display", "block") : this.nodes.Inputbar.setStyle("display", "block")) : (this.nodes.showBtn.setStyle("display", "block"),
            this.nodes.fakeInput.setStyle("display", "block"),
            this.nodes.fakeInput.setStyle("zIndex", 3),
            this.nodes.Inputbar.setStyle("display", "none")),
            this.manager.evt.trigger("vjs_toggleBarrge", !0)) : (this.nodes.barrageBtn.removeClass("active"),
            this.nodes.showBtn.setStyle("display", "none"),
            this.nodes.fakeInput.setStyle("display", "none"),
            this.nodes.Inputbar.setStyle("display", "none"),
            this.manager.evt.trigger("vjs_toggleBarrge", !1))
        },
        onResize: function() {
            if (this.nodes.fakeInput.hasClass("fakeoff")) {
                var e = this.nodes.barrageInput.getStyle("width").slice(0, -2) + "px";
                this.nodes.fakeInput.setStyle("width", e)
            }
        },
        inputFocus: function(e) {
            if (this.nodes.fakeInput.hasClass("fake")) {
                this.isShowInput = !0,
                this.nodes.fakeInput.removeClass("fake"),
                this.nodes.fakeInput.addClass("fakeoff"),
                this.nodes.showBtn.setStyle("display", "none"),
                this.nodes.Inputbar.setStyle("display", "block");
                var t = this.nodes.barrageInput.getStyle("width").slice(0, -2) + "px";
                this.nodes.fakeInput.setStyle("width", t),
                this.manager.evt.trigger("vjs_toggleInput", !0)
            }
        },
        toggleInputArea: function() {
            this.isShowInput = !0,
            this.nodes.showBtn.setStyle("display", "none"),
            this.nodes.Inputbar.setStyle("display", "block"),
            this.manager.evt.trigger("vjs_toggleInput", !0)
        },
        changeBarrge: function() {
            "PC" == this.playerData.interactiveType ? (this.inputText = this.nodes.barrageInput[0].value,
            this.nodes.textTotal[0].innerText = 50 - this.nodes.barrageInput[0].value.length) : (this.inputText = this.nodes.fakeInput[0].value,
            this.nodes.textTotal[0].innerText = 50 - this.nodes.fakeInput[0].value.length),
            this.nodes.textTotal[0].innerText <= 0 ? (this.nodes.textTotal[0].innerText = "0",
            this.nodes.textTotal.setStyle("color", "red")) : this.nodes.textTotal.setStyle("color", "white"),
            this.manager.evt.trigger("vjs_autoHidePannel")
        },
        toggleBarrgeInput: function(e) {
            "PC" == this.playerData.interactiveType ? this.isShowInput || (this.isended ? this.nodes.Inputbar.setStyle("display", "none") : 0 == this.manager.listener.get(n.IS_AD) && (this.nodes.showBtn.setStyle("display", e.args[0] && this.isOn && !this.playerData.config.hideBarrage && "min" == this.playerData.flashVar.UIType ? "block" : "none"),
            this.nodes.fakeInput.setStyle("display", e.args[0] && this.isOn && !this.playerData.config.hideBarrage && "min" == this.playerData.flashVar.UIType ? "block" : "none"),
            this.nodes.Inputbar.setStyle("display", e.args[0] && this.isOn && !this.playerData.config.hideBarrage && "min" != this.playerData.flashVar.UIType ? "block" : "none"))) : this.isShowInput || (this.isended ? this.nodes.Inputbar.setStyle("display", "none") : (this.nodes.showBtn.setStyle("display", e.args[0] && this.isOn && !this.playerData.config.hideBarrage ? "block" : "none"),
            setTimeout(s.bind(function() {
                this.nodes.fakeInput.setStyle("display", e.args[0] && this.isOn && !this.playerData.config.hideBarrage ? "block" : "none"),
                "block" == this.nodes.fakeInput.getStyle("display") ? this.nodes.fakeInput.setStyle("zIndex", 3) : this.nodes.fakeInput.setStyle("zIndex", 0)
            }, this), 500)),
            this.nodes.Inputbar.setStyle("display", "none"))
        },
        toSendBarrge: function() {
            this.manager.evt.trigger("vjs_sendBarrge", this.inputText, s.bind(this.setInputStatus, this)),
            this.clearInput()
        },
        clearInput: function() {
            this.inputText = "",
            this.nodes.barrageInput[0].value = "",
            this.nodes.fakeInput[0].value = "",
            this.nodes.textTotal[0].innerText = "50",
            this.nodes.textTotal.setStyle("color", "white")
        },
        setInputStatus: function(e) {
            "success" == e ? "PC" != this.playerData.interactiveType && (this.nodes.Inputbar.setStyle("display", "none"),
            this.hideFakeInput(),
            this.nodes.showBtn.setStyle("display", "block"),
            this.manager.evt.trigger("vjs_toggleInput", !1),
            this.isShowInput = !1) : ("min" == this.playerData.flashVar.UIType && this.manager.evt.trigger("vjs_toggleInput", !0),
            this.isShowInput = !0,
            this.nodes.Inputbar.setStyle("display", "block"),
            this.nodes.fakeInput.setStyle("display", "block"),
            "PC" == this.playerData.interactiveType ? this.nodes.barrageInput[0].value = e : (this.nodes.fakeInput[0].value = e,
            this.nodes.barrageInput[0].value = e),
            setTimeout(s.bind(function() {
                this.resetInput()
            }, this), 2e3))
        },
        resetInput: function() {
            "PC" == this.playerData.interactiveType ? this.nodes.barrageInput[0].value = this.inputText : this.nodes.fakeInput[0].value = this.inputText
        },
        closeBarrge: function() {
            this.manager.evt.trigger("vjs_toggleInput", !1),
            this.isShowInput = !1,
            this.hideFakeInput(),
            this.nodes.Inputbar.setStyle("display", "none")
        },
        hideFakeInput: function() {
            this.nodes.fakeInput.hasClass("fakeoff") && (this.nodes.fakeInput.removeClass("fakeoff"),
            this.nodes.fakeInput.addClass("fake"),
            this.nodes.fakeInput.setStyle("width", "36px"),
            this.nodes.fakeInput.setStyle("display", "none"),
            this.nodes.fakeInput[0].blur())
        }
    };
    s.merge(r.prototype, o),
    e.exports = r
}
, function(e, t, a) {
    var i = a(23)
      , s = a(6)
      , n = a(3)
      , r = a(21)
      , o = (a(2),
    function(e) {
        this.contDom = e.dom.cont,
        this.parentEl = e.dom.parentEl,
        this.coreVideo = e.coreVideo
    }
    );
    n.extend(o, i);
    var l = {
        init: function() {
            this.playerData = this.manager.playerData;
            var e = n.bind(this.manager.lanFit.fit, this.manager.lanFit);
            this.curDefi = 0,
            this.nodes = {
                defiCon: this.parentEl.find(".hv_ico_clear"),
                optDefi: this.parentEl.find(".clear_ul"),
                btnDefi: this.parentEl.find(".hv_ico_clarity")
            },
            this.defiEnum = {
                1: e("流畅"),
                2: e("标清"),
                3: e("高清"),
                4: e("超清"),
                5: e("1080P"),
                6: e("原画"),
                7: e("极速")
            },
            this.addEvent()
        },
        addEvent: function() {
            this.manager.listener.on(r.PLAY_STATE, function(e, t) {
                "ended" == t ? (this.nodes.defiCon.addClass("gray"),
                this.nodes.optDefi.removeClass("hover")) : this.nodes.defiCon.removeClass("gray")
            }, this),
            this.manager.evt.on("vjs_hideBotBar", this.hidePanel, this),
            this.manager.evt.on("hideDefiPanel", this.hidePanel, this),
            this.manager.evt.on("vjs_initDefiList", this.initDefi, this),
            this.manager.evt.on("vjs_videoRateChanged", this.onVideoRateChanged, this),
            "PC" == this.playerData.interactiveType ? (this.nodes.btnDefi.on("click", this.onBtnDefi, this),
            this.nodes.optDefi.on("click", this.onOptDefi, this)) : (this.nodes.btnDefi.on("touchend", this.onBtnDefi, this),
            this.nodes.optDefi.on("touchend", this.onOptDefi, this)),
            "base" == this.playerData.tplType && this.manager.evt.on(r.EVENT.RESIZE, this.onResize, this)
        },
        onResize: function() {
            this.nodes.defiCon[0].style.display = "1" == this.playerData.config.definition && this.contDom.width() > 370 ? "block" : "none"
        },
        onBtnDefi: function() {
            if (!this.nodes.defiCon.hasClass("gray")) {
                var e = this.nodes.optDefi
                  , t = this.nodes.btnDefi;
                e.hasClass("hover") ? (e.removeClass("hover"),
                t.removeClass("ico-active")) : (e.addClass("hover"),
                t.addClass("ico-active"),
                this.manager.evt.trigger("hideSettingPanel", !1))
            }
        },
        hidePanel: function() {
            var e = this.nodes.optDefi;
            e.hasClass("hover") && e.removeClass("hover"),
            this.nodes.btnDefi.removeClass("ico-active")
        },
        onOptDefi: function(e) {
            var t = e.target;
            if ("li" == t.tagName.toLowerCase()) {
                var a = s(t).getAttr("value");
                if (a == this.curDefi)
                    return;
                n.setCookie("defi", a, {
                    path: "/",
                    domain: r.HOST_NAME.LETV_COM,
                    expires: new Date(2099,12,30,23,59,59)
                }),
                this.manager.evt.trigger("showTip", "changeDefi"),
                this.manager.evt.trigger(r.EVENT.PLAYER_COMMAND, "changeDefi", a)
            }
            this.nodes.optDefi.removeClass("hover"),
            this.nodes.btnDefi.removeClass("ico-active")
        },
        onVideoRateChanged: function(e) {
            this.curDefi = e.args[0];
            for (var t = this.nodes.optDefi[0], a = 0, i = t.children.length; a < i; a++) {
                var n = t.children[a];
                n.getAttribute("value") == this.curDefi ? s(n).addClass("hover") : s(n).removeClass("hover")
            }
            this.nodes.btnDefi[0].innerHTML = this.defiEnum[parseInt(this.curDefi)]
        },
        initDefi: function(e) {
            for (var t = e.args[0], a = this.nodes.optDefi[0], i = [7, 1, 2, 3, 4, 5, 6], s = [], n = 0, r = i.length; n < r; n++)
                t[i[n]] && s.push('<li value="' + i[n] + '">' + this.defiEnum[parseInt(i[n])] + "</li>");
            a.innerHTML = s.join("")
        }
    };
    n.merge(o.prototype, l),
    e.exports = o
}
, function(e, t, a) {
    var i = a(23)
      , s = a(3)
      , n = a(21)
      , r = a(2)
      , o = function(e) {
        this.contDom = e.dom.cont,
        this.parentEl = e.dom.parentEl,
        this.coreVideo = e.coreVideo
    };
    s.extend(o, i);
    var l = {
        init: function() {
            this.playerData = this.manager.playerData,
            this.nodes = {
                fullBtn: this.parentEl.find(".hv_ico_screen"),
                pannel: this.parentEl.find(".js-pannel")
            },
            "PC" == this.playerData.interactiveType ? this.nodes.fullBtn.on("click", this.onFullBtnClick, this) : this.nodes.fullBtn.on("touchend", this.onFullBtnClick, this),
            "base" == this.playerData.tplType && (this.nodes.pannel.on("gesturestart", function(e) {
                e.preventDefault(),
                e.stopPropagation()
            }, this),
            this.nodes.pannel.on("gestureend", this.onGetsure, this)),
            this.manager.listener.on(n.FULLSCREEN_STATE, function(e, t) {
                0 == t ? this.nodes.fullBtn.removeClass("hv_ico_allscreen") : this.nodes.fullBtn.addClass("hv_ico_allscreen")
            }, this),
            this.addEvent()
        },
        addEvent: function() {
            "base" == this.playerData.tplType && this.manager.evt.on(n.EVENT.RESIZE, this.onResize, this)
        },
        onResize: function() {
            this.nodes.fullBtn[0].style.display = this.contDom.width() > 310 ? "block" : "none"
        },
        onFullBtnClick: function(e) {
            e.preventDefault();
            var t = 0 == this.manager.listener.get(n.FULLSCREEN_STATE) ? 1 : 0;
            1 == t && (r.isPC || "lepai" == this.playerData.pname && r.ipad) && (t = 2),
            this.manager.evt.trigger(n.EVENT.PLAYER_COMMAND, "changFullScreen", t, !0)
        },
        onGetsure: function(e) {
            e.preventDefault();
            var t, a = this.manager.listener.get(n.FULLSCREEN_STATE);
            e.scale > 1 ? 0 == a ? t = 1 : 1 == a && (t = 2) : t = 0,
            this.manager.evt.trigger(n.EVENT.PLAYER_COMMAND, "changFullScreen", t, !0)
        }
    };
    s.merge(o.prototype, l),
    e.exports = o
}
, function(e, t, a) {
    var i = a(23)
      , s = a(3)
      , n = a(21)
      , r = function(e) {
        this.contDom = e.dom.cont,
        this.parentEl = e.dom.parentEl,
        this.active = e.active
    };
    s.extend(r, i);
    var o = {
        init: function() {
            this.playerData = this.manager.playerData,
            this.nodes = {
                bigPlayBtn: this.parentEl.find(".hv_ico_pasued"),
                loading: this.parentEl.find(".hv_ico_loading"),
                shadow: this.parentEl.find(".js-bg")
            },
            this.addEvent()
        },
        addEvent: function() {
            this.manager.listener.on(n.PLAY_STATE, function(e, t) {
                "init" == t && (this.manager.evt.off("vjs_preparPlay", this.onPreparPlay, this),
                this.manager.evt.one("vjs_preparPlay", this.onPreparPlay, this))
            }, this),
            this.nodes.bigPlayBtn.on("click", this.toPlay, this)
        },
        toPlay: function() {
            this.manager.evt.trigger(n.EVENT.PLAYER_COMMAND, "play")
        },
        onPreparPlay: function() {
            this.nodes.loading[0].style.display = "none",
            this.nodes.bigPlayBtn[0].style.display = "block"
        },
        stopPropagation: function(e) {
            e.stopPropagation()
        }
    };
    s.merge(r.prototype, o),
    e.exports = r
}
, function(e, t, a) {
    var i = a(23)
      , s = a(3)
      , n = a(21)
      , r = (a(2),
    function(e) {
        this.contDom = e.dom.cont,
        this.parentEl = e.dom.parentEl,
        this.coreVideo = e.coreVideo
    }
    );
    s.extend(r, i);
    var o = {
        init: function() {
            this.playerData = this.manager.playerData,
            this.nodes = {
                nextVideoBtn: this.parentEl.find(".hv_ico_next")
            },
            this.manager.evt.on("vjs_vinfoReady", function() {
                this.playerData.vinfo.nextvid && this.nodes.nextVideoBtn.removeClass("gray")
            }, this),
            this.manager.listener.on(n.PLAY_STATE, function(e, t) {
                "init" == t && this.nodes.nextVideoBtn.addClass("gray")
            }, this),
            "PC" == this.playerData.interactiveType ? this.nodes.nextVideoBtn.on("click", this.onNextVideoBtnClick, this) : this.nodes.nextVideoBtn.on("touchend", this.onNextVideoBtnClick, this),
            this.addEvent()
        },
        addEvent: function() {
            "base" == this.playerData.tplType && this.manager.evt.on(n.EVENT.RESIZE, this.onResize, this)
        },
        onResize: function() {
            this.nodes.nextVideoBtn[0].style.display = "1" == this.playerData.config.nextBtn && this.contDom.width() > 410 ? "block" : "none"
        },
        onNextVideoBtnClick: function() {
            this.nodes.nextVideoBtn.hasClass("gray") || this.manager.evt.trigger(n.EVENT.PLAYER_COMMAND, "playNext", !0)
        }
    };
    s.merge(r.prototype, o),
    e.exports = r
}
, function(e, t, a) {
    var i = a(23)
      , s = a(3)
      , n = a(21)
      , r = (a(2),
    function(e) {
        this.contDom = e.dom.cont,
        this.parentEl = e.dom.parentEl,
        this.coreVideo = e.coreVideo
    }
    );
    s.extend(r, i);
    var o = {
        init: function() {
            this.playerData = this.manager.playerData,
            this.nodes = {
                playBtn: this.parentEl.find(".hv_start span")
            },
            this.addEvent()
        },
        addEvent: function() {
            "PC" == this.playerData.interactiveType ? this.nodes.playBtn.on("click", this.onBtnPlay, this) : this.nodes.playBtn.on("touchend", this.onBtnPlay, this),
            this.manager.evt.on("vjs_play", this.onPlay, this),
            this.manager.evt.on("vjs_pause", this.onPause, this),
            this.manager.evt.on("vjs_ended", this.onEnded, this)
        },
        onBtnPlay: function() {
            switch (this.nodes.playBtn[0].className) {
            case "hv_ico_star":
                this.manager.evt.trigger(n.EVENT.PLAYER_COMMAND, "pause"),
                this.manager.evt.trigger("vjs_activePause");
                break;
            case "hv_ico_stop":
                this.manager.evt.trigger(n.EVENT.PLAYER_COMMAND, "play");
                break;
            case "hv_ico_refresh":
                this.manager.evt.trigger(n.EVENT.PLAYER_COMMAND, "replay")
            }
        },
        onPlay: function() {
            this.nodes.playBtn[0].className = "hv_ico_star"
        },
        onPause: function() {
            this.nodes.playBtn[0].className = "hv_ico_stop"
        },
        onEnded: function() {
            this.nodes.playBtn[0].className = "hv_ico_refresh"
        }
    };
    s.merge(r.prototype, o),
    e.exports = r
}
, function(e, t, a) {
    var i = a(23)
      , s = a(3)
      , n = a(21)
      , r = (a(2),
    function(e) {
        this.contDom = e.dom.cont,
        this.parentEl = e.dom.parentEl,
        this.active = e.active
    }
    );
    s.extend(r, i);
    var o = {
        init: function() {
            this.playerData = this.manager.playerData,
            this.nodes = {
                pannel: this.parentEl.find(".js-pannel"),
                poster: this.parentEl.find(".hv_play_poster"),
                loading: this.parentEl.find(".hv_ico_loading"),
                title: this.parentEl.find(".hv_tit"),
                optDefi: this.parentEl.find(".clear_ul"),
                settingPanel: this.parentEl.find(".hv_setting_panel"),
                bigPlayBtn: this.parentEl.find(".hv_ico_pasued"),
                playBtn: this.parentEl.find(".hv_start span"),
                shadow: this.parentEl.find(".js-bg"),
                controlBar: this.parentEl.find(".hv_botbar"),
                topBar: this.parentEl.find(".hv_topbar"),
                barrgeBar: this.parentEl.find(".hv_barrage_cmt")
            },
            this.autoHideTime = null,
            this.delayTime = null,
            this.showLoadingTime = null,
            this.isPcFullscreen = !1,
            this.isShowInputBar = !1,
            this.fixed = !1,
            this.isShowBarrageBtn = !1,
            this.addEvent()
        },
        addEvent: function() {
            this.manager.listener.on(n.PLAY_STATE, function(e, t) {
                "init" == t ? (this.manager.evt.off("vjs_preparPlay", this.onPreparPlay, this),
                this.manager.evt.one("vjs_preparPlay", this.onPreparPlay, this),
                this.nodes.loading[0].style.display = "block",
                this.nodes.bigPlayBtn[0].style.display = "none",
                this.hidePannel()) : "stop" == t && this.hidePannel()
            }, this),
            this.manager.evt.on("vjs_startPlay", this.onStartPlay, this),
            this.manager.evt.on("vjs_hidePanel", this.hidePannel, this),
            this.manager.evt.on("vjs_toggleInput", this.toggleBarrgeInput, this),
            this.manager.evt.on("vjs_vinfoReady", function() {
                this.nodes.title[0] && (this.nodes.title[0].innerHTML = this.playerData.vinfo.title || "")
            }, this),
            this.nodes.bigPlayBtn.on("click", this.toPlay, this),
            "PC" == this.playerData.interactiveType ? (this.nodes.pannel.on("click", function(e) {
                "pause" == this.manager.listener.get(n.PLAY_STATE) ? this.manager.evt.trigger(n.EVENT.PLAYER_COMMAND, "play") : this.manager.evt.trigger(n.EVENT.PLAYER_COMMAND, "pause")
            }, this),
            this.nodes.barrgeBar.on("mouseleave", function(e) {
                this.fixed = !0,
                setTimeout(s.bind(function() {
                    this.fixed = !1
                }, this), 1e3)
            }, this),
            this.parentEl.on("mousemove", function(e) {
                this.fixed || this.isShowInputBar || "init" == this.manager.listener.get(n.PLAY_STATE) || "stop" == this.manager.listener.get(n.PLAY_STATE) || this.showPannel()
            }, this),
            this.nodes.shadow.on("click", this.stopPropagation)) : (this.nodes.pannel.on("touchend", this.togglePannel, this),
            this.nodes.shadow.on("touchend", this.stopPropagation),
            this.nodes.controlBar.on("touchend", this.showPannel, this)),
            this.manager.evt.on("vjs_showPannel", this.showPannel, this),
            this.manager.evt.on("vjs_hideLoading", this.hideLoading, this),
            this.manager.evt.on("vjs_autoHidePannel", this.autoHidePannel, this),
            this.manager.evt.on("vjs_timeupdate vjs_pause vjs_p2pBufferend", this.hideLoading, this),
            this.manager.evt.on("vjs_seeking vjs_waiting vjs_stalled vjs_p2pBufferstart", this.showLoading, this),
            this.manager.evt.on(n.EVENT.RESIZE, this.onResize, this),
            this.manager.evt.on("vjs_showbarrageBtn", this.onIsshowBarrageBtn, this)
        },
        onIsshowBarrageBtn: function() {
            this.isShowBarrageBtn = !0,
            this.onResize()
        },
        onResize: function() {
            this.isShowBarrageBtn ? this.nodes.title[0].style.width = this.contDom.width() - 100 + "px" : this.nodes.title[0].style.width = this.contDom.width() - 35 + "px"
        },
        toPlay: function() {
            this.manager.evt.trigger(n.EVENT.PLAYER_COMMAND, "play")
        },
        onStartPlay: function() {
            this.nodes.poster[0].style.display = "none",
            this.nodes.bigPlayBtn[0].style.display = "none",
            this.nodes.shadow[0].style.display = "none",
            this.loadFlag && this.hideLoadingLogo(),
            this.manager.listener.get(n.IS_AD) || (this.nodes.loading[0].style.display = "block")
        },
        onPreparPlay: function() {
            this.nodes.loading[0].style.display = "none",
            this.loadFlag && this.hideLoadingLogo(),
            this.nodes.bigPlayBtn[0].style.display = "block"
        },
        togglePannel: function(e) {
            !e || e.target !== this.nodes.pannel[0] && e.target.parentNode !== this.nodes.pannel[0] || this.active.isDrag || (this.delayTime ? (clearTimeout(this.delayTime),
            this.delayTime = null) : this.delayTime = setTimeout(s.bind(function() {
                if (!this.isShowInputBar) {
                    var e = this.isPay();
                    this.parentEl.hasClass("hv_box_hide") ? (this.parentEl.removeClass("hv_box_hide"),
                    e && this.manager.evt.trigger("vjs_showInputPannel", !0)) : (this.parentEl.addClass("hv_box_hide"),
                    this.manager.evt.trigger("vjs_hideBotBar"),
                    e && this.manager.evt.trigger("vjs_showInputPannel", !1))
                }
                this.autoHidePannel(),
                this.delayTime = null
            }, this), 200)),
            this.manager.evt.trigger("vjs_togglePannel")
        },
        isPay: function() {
            var e = this.manager.playerData.validateInfo;
            if (e && e.tvodRts)
                return 1;
            if ("vip" == this.playerData.tryLookType) {
                var t = e.vodInfo && e.vodInfo.video && [1, 2].indexOf(e.vodInfo.video.chargeType) != -1 || !1
                  , a = e.vodInfo && e.vodInfo.video && "0" == e.vodInfo.video.chargeType && "1" == e.vodInfo.video.isCharge && "0" == e.vodInfo.video.isSupportTicket || !1
                  , i = e.vodInfo && e.vodInfo.video && "0" == e.vodInfo.video.chargeType && "1" == e.vodInfo.video.isSupportTicket || !1;
                return i || t || a || 0
            }
            return 0
        },
        autoHidePannel: function() {
            clearTimeout(this.autoHideTime),
            this.autoHideTime = setTimeout(s.bind(function() {
                this.active.isDrag || (this.parentEl.addClass("hv_box_hide"),
                this.manager.evt.trigger("vjs_hideBotBar"),
                this.isPay() ? this.manager.evt.trigger("vjs_showInputPannel", !1) : this.manager.evt.trigger("vjs_tryLookEnd", !0))
            }, this), 5e3)
        },
        showPannel: function() {
            this.parentEl.removeClass("hv_box_hide"),
            this.autoHidePannel(),
            this.isPay() && this.manager.evt.trigger("vjs_showInputPannel", !0)
        },
        hidePannel: function() {
            this.parentEl.addClass("hv_box_hide"),
            this.manager.evt.trigger("vjs_hideBotBar", !0)
        },
        toggleBarrgeInput: function(e) {
            this.hidePannel(),
            this.isShowInputBar = e.args[0]
        },
        showLoading: function(e) {
            if (!this.playerData.config.supportP2P) {
                var t = this.manager.listener.get(n.PLAY_STATE);
                if ("vjs_stalled" == e.type && ("pause" == t || "init" == t || "ended" == t || "stop" == t || "changeDefi" == t))
                    return
            }
            "vjs_seeking" == e.type ? this.nodes.loading[0].style.display = "block" : (clearTimeout(this.showLoadingTime),
            this.showLoadingTime = setTimeout(s.bind(function() {
                this.nodes.loading[0].style.display = "block"
            }, this), 500))
        },
        loadFlag: !0,
        hideLoading: function(e) {
            if (!this.playerData.config.supportP2P) {
                var t = this.manager.listener.get(n.PLAY_STATE);
                if ("vjs_timeupdate" == e.type && "seeking" == t || this.isPcFullscreen)
                    return
            }
            this.showLoadingTime && (clearTimeout(this.showLoadingTime),
            this.showLoadingTime = null),
            this.nodes.loading[0].style.display = "none",
            this.loadFlag && this.hideLoadingLogo()
        },
        hideLoadingLogo: function(e) {
            this.loadFlag && (this.nodes.loading.find(".logo")[0].style.display = "none",
            this.nodes.loading.find(".bt_wrap").addClass("bt_wrap2"),
            this.loadFlag = !1)
        },
        stopPropagation: function(e) {
            e.stopPropagation()
        }
    };
    s.merge(r.prototype, o),
    e.exports = r
}
, function(e, t, a) {
    var i = a(23)
      , s = a(6)
      , n = a(3)
      , r = a(21)
      , o = function(e) {
        this.contDom = e.dom.cont,
        this.parentEl = e.dom.parentEl,
        this.coreVideo = e.coreVideo
    };
    n.extend(o, i);
    var l = {
        init: function() {
            this.playerData = this.manager.playerData,
            this.lanFit = n.bind(this.manager.lanFit.fit, this.manager.lanFit),
            this.erroCode = "",
            this.nodes = {
                popTip: this.parentEl.find(".js-poptip"),
                popTipCon: this.parentEl.find(".js-poptip .hv_pop_cnt"),
                optDefi: this.parentEl.find(".clear_ul"),
                shadow: this.parentEl.find(".js-bg"),
                bigPlay: this.parentEl.find(".hv_ico_pasued"),
                loading: this.parentEl.find(".hv_ico_loading"),
                videoCon: this.parentEl.find(".hv_play")
            },
            //this.nodes.popTip.on("click", this.onTipClick, this),
            this.manager.evt.on("vjs_showPopTip", function(e) {
					return;
                var t = e.args[0]
                  , a = e.args[1];
                this.show(t, a)
            }, this),
            this.manager.listener.on(r.PLAY_STATE, function(e, t) {
					return;
                "init" == t && this.hide()
            }, this),
            this.isClick = !1
        },
        onTipClick: function(e) {
            var t = this.lanFit
              , a = s(e.target).getAttr("type");
            switch (a) {
            case "login":
                try {
                    this.manager.evt.trigger(r.EVENT.PLAYER_CALLBACK, "openLoginDialog")
                } catch (e) {}
                break;
            case "back-home":
                location.href = "http://" + r.HOST_NAME.WWW_LETV_COM;
                break;
            case "refresh":
                location.reload();
                break;
            case "costTicket":
                if (this.isClick)
                    return;
                this.isClick = !0;
                var i = this;
                this.jsonp = n.getJSON({
                    url: r.PROTOCAL + r.HOST_NAME.PLAYER_PC_LETV_COM + "/mms/useticket",
                    data: {
                        pid: this.playerData.vinfo.pid || "",
                        vid: this.playerData.vinfo.vid || "",
                        region: this.manager.listener.get(r.REGION)
                    },
                    log: this.manager.log,
                    success: function(e) {
                        i.jsonp = null,
                        i.isClick = !1,
                        1 == e.code && i.manager.evt.trigger(r.EVENT.PLAYER_COMMAND, "reload")
                    },
                    fail: function() {
                        i.jsonp = null
                    }
                });
                break;
            case "close":
                this.hide();
                break;
            case "open-app":
                var o = s(e.target).getAttr("open-type") || "";
                this.manager.evt.trigger(r.EVENT.PLAYER_CALLBACK, "openApp", {
                    vid: this.playerData.vinfo.vid,
                    openType: o
                });
                break;
            case "send-log":
                var l = prompt(t("请输入您的联系方式"));
                if ("" == n.trim(l))
                    return void alert(t("联系方式为空"));
                this.manager.log.send({
                    errno: this.erroCode,
                    phone: l,
                    forceSend: !0
                }),
                e.target.innerHTML = t("反馈成功"),
                e.target.removeAttribute("type")
            }
        },
        show: function(e, t) {
            var a = this.lanFit
              , i = this.manager.playerData.config.lan
              , s = "";
            switch (t = t || {},
            this.erroCode = "",
            e) {
            case "paynotLoginMember":
                s = ['<p class="hv_font14">', a("本片为付费影片，开通会员可免费观看"), "</p>", '<p class="hv_font14">', a("已是会员"), ' <a href="javascript:void(0);" type="login" class="hv_org">', a("立即登录"), "</a></p>"].join("");
                break;
            case "payLoginMember":
                s = ['<p class="hv_font14">', a("本片为付费影片，开通会员可免费观看"), "</p>"].join("");
                break;
            case "loginMember":
                s = ['<p class="hv_font14">', a("试看已结束，继续观看请开通会员"), "</p>", '<p class="hv_font14">', a("已是会员"), ' <a href="javascript:void(0);" type="login" class="hv_org">', a("立即登录"), "</a></p>"].join("");
                break;
            case "openGlobalMember":
                s = ['<p class="hv_font14">', a("试看已结束，继续观看请开通"), "</p>", '<p class="hv_font14"><span class="hv_org">', t, "</span></p>"].join("");
                break;
            case "useTicket":
                s = ['<p class="hv_font12">', a("试看已结束，继续观看需使用1张观影券(现有"), '<span class="hv_org">', t, "</span>", a("张"), ")</p>", '<p class="hv_font12 hv_opa">', a("使用观影券48小时内可重复观看当前影片"), "</p>", '<p><a href="javascript:void(0);" type="costTicket" class="hv_btn_org">', a("立即使用"), "</a></p>"].join("");
                break;
            case "noMoreTicket":
                s = ['<p class="hv_font14">', a("试看已结束，本月赠送的观影券已用完"), "</p>"].join("");
                break;
            case "appGuideEnd":
                s = ['<p class="hv_font14">', this.playerData.tryLookTime, a("分钟试看已结束"), "</p>", '<p class="hv_font14">', a("使用乐视视频APP观看完整版"), "</p>", '<p><a href="javascript:void(0);" type="open-app" open-type="app-guide" class="hv_btn_org">', a("观看完整版"), "</a></p>"].join("");
                break;
            case r.ERROR_CODE.GSLB_SERVER_PRESSURE_LARGE:
                this.erroCode = e,
                s = ['<p class="hv_font14">', a("人太多挤爆啦，工程师正在抢修"), "</p>", '<p class="hv_font14">', a("稍后试试看"), "</p>"].join("");
                break;
            case r.ERROR_CODE.USER_ABNORMAL:
                s = "en" == i ? '<p class="hv_font12">' + a("检测您帐号有异常，会员服务已冻结,如有问题请联系客服") + ": 4000300104</p>" : ['<p class="hv_font12">', a("检测您帐号有异常，会员服务已冻结"), "</p>", '<p class="hv_font12">', a("如有问题请联系客服"), "：4000300104</p>"].join("");
                break;
            case r.ERROR_CODE.COPY_RIGHT_BAN:
                this.erroCode = e,
                s = ['<p class="hv_font14">', a("因版权方要求，暂不能观看"), "</p>"].join("");
                break;
            case r.ERROR_CODE.OFFLINE:
                this.erroCode = e,
                s = ['<p class="hv_font14">', a("很抱歉，您看的视频已经下线了"), "</p>"].join("");
                break;
            case r.ERROR_CODE.AREA_BAN:
                this.erroCode = e,
                s = '<p class="hv_font14">' + a("该内容不支持在当前地区观看") + "</p>";
                break;
            case "firstLook":
                s = ['<p class="hv_font14">', a("使用乐视视频APP，抢先观看当前视频"), "</p>"].join(""),
                "MPlayer" == this.playerData.pname && (s += '<p><a href="javascript:void(0);" type="open-app" open-type="firstlook" class="hv_btn_blue">' + a("前往观看") + "</a></p>");
                break;
            case "authBan":
                s = "en" == i ? ['<p class="hv_font14">', a("当前视频需要使用乐视视频APP观看，高清更流畅"), "</p>", '<p><a href="javascript:void(0);" type="open-app" open-type="auth-ban"  class="hv_btn_blue">', a("立即观看"), "</a></p>"].join("") : ['<p class="hv_font16">', a("当前视频需要使用"), "</p>", '<p class="hv_font16">', a("乐视视频APP观看，高清更流畅"), "</p>", '<p><a href="javascript:void(0);" type="open-app" open-type="auth-ban"  class="hv_btn_blue">', a("立即观看"), "</a></p>"].join("");
                break;
            case "vikiBan":
                s = ['<p class="hv_font14">', a("由于版权原因"), "</p>", '<p class="hv_font14">', a("该视频暂不支持在此平台播放"), "</p>"].join("");
                break;
            case r.ERROR_CODE.AUTH_DATA_EMPTY:
                this.erroCode = e,
                s = ['<p class="hv_font14">', a("缺少可播放的视频数据"), "</p>"].join("");
                break;
            case r.ERROR_CODE.DRM_BAN:
                this.erroCode = e,
                s = ['<p class="hv_font14">', a("受视频格式限制，该内容不支持观看"), "</p>", '<p class="hv_font14">', a("欢迎观看其他精彩内容"), "</p>"].join("");
                break;
            case r.ERROR_CODE.AUTH_TIMEOUT:
            case r.ERROR_CODE.AUTH_ARGS_ERR:
            case r.ERROR_CODE.AUTH_TIME_SERVER_ERROR:
            case r.ERROR_CODE.AUTH_COOKIE_RETRY_ERROR:
            case r.ERROR_CODE.GSLB_TIMEOUT:
            case r.ERROR_CODE.GSLB_ERROR:
            case r.ERROR_CODE.TOKEN_TIMEOUT:
            case r.ERROR_CODE.GSLB_DATA_EMPTY:
            case r.ERROR_CODE.URL_NOT_SUPPORT_MP4:
            case r.ERROR_CODE.URL_NOT_SUPPORT_M3U8:
            case r.ERROR_CODE.ERROR:
                this.erroCode = e,
                s = ['<p class="hv_font14">', a("视频无法播放"), ' <a type="send-log" href="javascript:void(0);" class="hv_blu">', a("提交反馈"), "</a></p>", '<p class="hv_font12"><a type="refresh" href="javascript:void(0);" class="hv_blu">', a("刷新重试"), "</a></p>"].join("")
            }
            s && (this.erroCode && (s += '<p class="hv_font12">' + this.lanFit("反馈码") + "：" + this.erroCode + "</p>"),
            this.manager.evt.trigger(r.EVENT.PLAYER_COMMAND, "pause"),
            setTimeout(n.bind(function() {
                this.manager.listener.set(r.PLAY_STATE, "stop"),
                //this.nodes.popTipCon[0].innerHTML = s,
                //this.nodes.popTip[0].style.display = "block",
                this.nodes.shadow[0].style.display = "block",
                this.parentEl.addClass("hv_box_hide"),
                this.nodes.optDefi.removeClass("hover"),
                this.nodes.videoCon[0].style.display = "none",
                this.nodes.bigPlay[0].style.display = "none",
                this.manager.evt.trigger("vjs_hideLoading"),
                this.manager.evt.trigger(r.EVENT.PLAYER_CALLBACK, "SHOW_MESSAGE", {
                    type: e
                }),
                this.manager.evt.trigger(r.EVENT.PLAYER_COMMAND, "changFullScreen", 0)
            }, this), 0))
        },
        hide: function() {
            this.nodes.videoCon[0].style.display = "block",
            //this.nodes.popTip[0].style.display = "none",
            this.nodes.shadow[0].style.display = "none"
        }
    };
    n.merge(o.prototype, l),
    e.exports = o
}
, function(e, t, a) {
    var i = a(23)
      , s = (a(6),
    a(3))
      , n = (a(2),
    a(21))
      , r = a(60)
      , o = function(e) {
        this.contDom = e.dom.cont,
        this.parentEl = e.dom.parentEl,
        this.active = e.active,
        this.coreVideo = e.coreVideo
    };
    s.extend(o, i);
    var l = {
        init: function() {
            this.playerData = this.manager.playerData,
            this.nodes = {
                progressBar: this.parentEl.find(".progress_bar"),
                sliderBtn: this.parentEl.find(".hv_ico_playing"),
                currentBar: this.parentEl.find(".progress_line"),
                bufferBar: this.parentEl.find(".progress_downloadline"),
                totalTimeTip: this.parentEl.find(".hv_total_time"),
                currentTimeTip: this.parentEl.find(".hv_time span"),
                barBg: this.parentEl.find(".hv_scroll_cnt"),
                bar: this.parentEl.find(".hv_scroll_all")
            },
            this.events = {
                ".hv_scroll_cnt click": this.onPrograssBarClick,
                "document keydown": this.onKeyDown,
                "document keyup": this.onKeyUp,
                ".hv_scroll_all mouseover": this.onMouseOver,
                ".hv_scroll_all mouseout": this.onMouseOut
            },
            this.totalTimeTipWidth = 0,
            this.isTotalTimeTipHide = !1,
            this.currentTimeTipPosition = "right",
            this.seekTime = null,
            this.duration = 0,
            this.sliderBtnWidth = 16,
            this.manager.listener.on(n.PLAY_STATE, function(e, t) {
                "init" == t && (this.duration = 0,
                this.seekTime = null),
                "init" != t && "ended" != t || this.setProgress(0)
            }, this),
            this.addEvent()
        },
        addEvent: function() {
            this.manager.evt.on(n.EVENT.RESIZE, this.onResize, this),
            "PC" == this.playerData.interactiveType ? (this.setEvents("on", {
                parentEl: this.parentEl,
                events: this.events
            }, this),
            this.silderTouchable = new r(this.nodes.sliderBtn[0],{
                isPC: !0
            }),
            this.silderTouchable.on("mousedown", this.onSliderTouchStart, this),
            this.silderTouchable.on("mousemove", this.onSliderTouchMove, this),
            this.silderTouchable.on("mouseup", this.onSliderTouchEnd, this)) : (this.silderTouchable = new r(this.nodes.sliderBtn[0]),
            this.silderTouchable.on("touchstart", this.onSliderTouchStart, this),
            this.silderTouchable.on("touchmove", this.onSliderTouchMove, this),
            this.silderTouchable.on("touchend", this.onSliderTouchEnd, this)),
            this.manager.evt.on("vjs_durationChange", this.onSetDuration, this),
            this.manager.evt.on("vjs_updateSeekTime", function(e) {
                this.setProgress(e.args[0])
            }, this),
            this.manager.evt.on("vjs_timeupdate", this.onTimeUpdate, this)
        },
        onResize: function() {
            this.progressBarWidth = this.nodes.progressBar.width(),
            this.progressBarOffset = this.nodes.progressBar.offset().left,
            parseFloat(this.nodes.currentBar[0].style.width) / 100 > 1 && this.setProgress(1, "percent")
        },
        onTimeUpdate: function() {
            var e = this.manager.listener.get(n.PLAY_STATE);
            this.active.isDrag || "play" != e || this.setProgress()
        },
        onSliderTouchStart: function(e) {
            var t = e.args[1];
            t.preventDefault(),
            t.stopPropagation(),
            this.diffX = e.args[0].startTouch.x - this.nodes.sliderBtn.offset().left;
            var a = this.manager.listener.get(n.PLAY_STATE);
            "pause" != a && this.manager.evt.trigger(n.EVENT.PLAYER_COMMAND, "pause"),
            document.body.focus(),
            document.onselectstart = function() {
                return !1
            }
            ,
            this.nodes.sliderBtn.addClass("press")
        },
        onSliderTouchMove: function(e) {
            var t = e.args[1];
            t.stopPropagation(),
            this.active.isDrag = !0;
            var a = "PC" == this.playerData.interactiveType ? this.nodes.progressBar.offset().left : this.progressBarOffset
              , i = e.args[0].currentTouch.x - a - this.diffX
              , s = i / this.progressBarWidth;
            this.setProgress(s, "percent")
        },
        onSliderTouchEnd: function() {
            this.active.isDrag = !1;
            var e = parseFloat(this.nodes.sliderBtn.getStyle("left")) / 100 * this.duration;
            this.manager.evt.trigger(n.EVENT.PLAYER_COMMAND, "seek", e),
            document.onselectstart = null,
            this.nodes.sliderBtn.removeClass("press")
        },
        onPrograssBarClick: function(e) {
            var t = (e.clientX - this.nodes.progressBar.offset().left - this.sliderBtnWidth / 2) / this.progressBarWidth;
            this.setProgress(t, "percent");
            var a = parseFloat(this.nodes.sliderBtn.getStyle("left")) / 100 * this.duration;
            this.manager.evt.trigger(n.EVENT.PLAYER_COMMAND, "seek", a)
        },
        onKeyDown: function(e) {
            if (37 === e.keyCode || 39 === e.keyCode) {
                var t = this.manager.listener.get(n.PLAY_STATE);
                "pause" != t && this.manager.evt.trigger(n.EVENT.PLAYER_COMMAND, "pause"),
                null == this.seekTime && (this.seekTime = this.coreVideo.getCurrentTime()),
                this.seekTime = 37 == e.keyCode ? this.seekTime - 15 : this.seekTime + 15,
                this.seekTime = Math.max(0, this.seekTime),
                this.seekTime = Math.min(this.seekTime, this.duration),
                this.setProgress(this.seekTime)
            }
        },
        onKeyUp: function(e) {
            null == this.seekTime || 37 !== e.keyCode && 39 !== e.keyCode || (this.manager.evt.trigger(n.EVENT.PLAYER_COMMAND, "seek", this.seekTime),
            this.seekTime = null)
        },
        onMouseOver: function(e) {
            this.nodes.sliderBtn.setStyle("display", "block"),
            this.nodes.progressBar.setStyle("height", "6px")
        },
        onMouseOut: function(e) {
            this.nodes.sliderBtn.setStyle("display", "none"),
            this.nodes.progressBar.setStyle("height", "2px")
        },
        onSetDuration: function(e) {
            this.duration = e.args[0] || 0,
            this.nodes.totalTimeTip[0].innerHTML = s.formatTime(this.duration),
            this.nodes.totalTimeTip[0].style.display = "",
            this.isTotalTimeTipHide = !1,
            this.totalTimeTipWidth = this.nodes.totalTimeTip.width()
        },
        toggleTotalTimeTip: function(e) {
            e = e || parseFloat(this.nodes.sliderBtn[0].style.left) / 100,
            e >= this.hideTotalTimeTipPercent ? this.isTotalTimeTipHide || (this.nodes.totalTimeTip[0].style.display = "none",
            this.isTotalTimeTipHide = !0) : this.isTotalTimeTipHide && (this.nodes.totalTimeTip[0].style.display = "",
            this.isTotalTimeTipHide = !1)
        },
        setProgress: function(e, t) {
            var a, i;
            if (0 == this.duration)
                a = 0;
            else if ("percent" == t)
                a = e;
            else {
                if (i = parseInt("undefined" != typeof e ? e : this.coreVideo.getCurrentTime()),
                i == this.currentTime || i > this.duration)
                    return;
                this.currentTime = i,
                a = i / this.duration
            }
            if (a = Math.max(0, a),
            a = Math.min(a, 1),
            i = i || a * this.duration || 0,
            this.nodes.currentTimeTip[0].innerHTML = s.formatTime(i),
            this.nodes.currentTimeTip[0].currentTime = i,
            a = 100 * a,
            this.nodes.sliderBtn[0].style.left = a + "%",
            this.nodes.currentBar[0].style.width = a + "%",
            this.nodes.currentTimeTip[0].style.left = a + "%",
            "undefined" == typeof e) {
                var n = this.coreVideo.getBuffered()
                  , r = n / this.duration * 100;
                r = Math.max(r, 0),
                r = Math.min(r, 100),
                r = r && r > a ? r : a,
                this.nodes.bufferBar.setStyle("width", r + "%")
            }
        },
        switchCurrentTimePosition: function(e) {
            e = "undefined" != typeof e ? e : parseFloat(this.nodes.sliderBtn[0].style.left) / 100,
            e * this.progressBarWidth > 45 ? "left" != this.currentTimeTipPosition && (this.nodes.currentTimeTip.setStyle("marginLeft", "-45px"),
            this.currentTimeTipPosition = "left") : "right" != this.currentTimeTipPosition && (this.nodes.currentTimeTip.setStyle("marginLeft", "22px"),
            this.currentTimeTipPosition = "right")
        },
        destroy: function() {
            this.silderTouchable.destroy(),
            this.setEvents("off", {
                parentEl: this.parentEl,
                events: this.events
            }, this)
        }
    };
    s.merge(o.prototype, l),
    e.exports = o
}
, function(e, t, a) {
    function i(e, t) {
        return e.clientY - t.clientY
    }
    var s = a(3)
      , n = a(18)
      , r = function(e, t) {
        this.node = e,
        this.isPC = t && t.isPC || !1,
        this.inDoubleTap = !1,
        this.isOneFingerGesture = !1,
        this.doubleTapTimer = null,
        this.longTapTimer = null,
        t = t || {},
        this.startTouch = {
            x: 0,
            y: 0
        },
        this.currentTouch = {
            x: 0,
            y: 0
        },
        this.previousTouch = {
            x: 0,
            y: 0
        },
        this.currentDelta = {
            x: 0,
            y: 0
        },
        this.currentStartDelta = {
            x: 0,
            y: 0
        },
        this.eventNode = t.isTargetNode ? this.node : document,
        this.touchStartFn = s.bind(this.touchStart, this),
        this.touchMoveFn = s.bind(this.touchMove, this),
        this.touchEndFn = s.bind(this.touchEnd, this),
        this.isPC ? this.node.addEventListener("mousedown", this.touchStartFn, !1) : this.node.addEventListener("touchstart", this.touchStartFn, !1)
    };
    r.prototype = {
        touchStart: function(e) {
            var t = this;
            if (this.reset(),
            e.touches) {
                if (!e.touches.length || this.isCurrentlyTouching)
                    return !1;
                if (this.isCurrentlyTouching = !0,
                this.isOneFingerGesture = 1 == e.touches.length,
                1 == e.touches.length)
                    this.startTouch.x = this.currentTouch.x = e.touches[0].clientX,
                    this.startTouch.y = this.currentTouch.y = e.touches[0].clientY;
                else if (e.touches.length > 1) {
                    for (var a = [], s = 0, n = e.touches.length; s < n; s++)
                        a.push(e.touches[s]);
                    a.sort(i);
                    var n = a.length - 1;
                    this.startTouch.x = this.currentTouch.x = a[n].clientX,
                    this.startTouch.y = this.currentTouch.y = a[n].clientY
                }
                this.eventNode.addEventListener("touchmove", this.touchMoveFn, !1),
                this.eventNode.addEventListener("touchend", this.touchEndFn, !1)
            } else
                this.startTouch.x = this.currentTouch.x = e.pageX,
                this.startTouch.y = this.currentTouch.y = e.pageY,
                this.eventNode.addEventListener("mousemove", this.touchMoveFn, !1),
                this.eventNode.addEventListener("mouseup", this.touchEndFn, !1);
            this.target = e.target,
            this.currentTarget = e.currentTarget,
            this.hitTarget = document.elementFromPoint ? document.elementFromPoint(this.startTouch.x, this.startTouch.y) : null,
            this.inDoubleTap ? (this.trigger("doubleTouch", this),
            clearTimeout(t.doubleTapTimer),
            this.inDoubleTap = !1) : (this.inDoubleTap = !0,
            this.doubleTapTimer = setTimeout(function() {
                t.inDoubleTap = !1
            }, 500)),
            this.longTapTimer = setTimeout(function() {
                t.trigger("longTouch", t)
            }, 1e3),
            this.isPC ? this.trigger("mousedown", this, e) : this.trigger("touchstart", this, e)
        },
        touchMove: function(e) {
            if (this.previousTouch.x = this.currentTouch.x,
            this.previousTouch.y = this.currentTouch.y,
            e.touches) {
                if (!e.touches.length || !this.isOneFingerGesture)
                    return;
                if (e.touches.length > 1)
                    return void (this.isOneFingerGesture = !1);
                this.currentTouch.x = e.touches[0].clientX,
                this.currentTouch.y = e.touches[0].clientY
            } else
                this.currentTouch.x = e.pageX,
                this.currentTouch.y = e.pageY;
            this.currentDelta.x = this.currentTouch.x - this.previousTouch.x,
            this.currentDelta.y = this.currentTouch.y - this.previousTouch.y,
            this.currentStartDelta.x = this.currentTouch.x - this.startTouch.x,
            this.currentStartDelta.y = this.currentTouch.y - this.startTouch.y,
            this.target = e.target,
            this.currentTarget = e.currentTarget,
            this.isPC ? this.trigger("mousemove", this, e) : this.trigger("touchmove", this, e),
            this.longTapTimer && clearTimeout(this.longTapTimer)
        },
        touchEnd: function(e) {
            if (e.touches) {
                if (e.targetTouches.length)
                    return;
                this.eventNode.removeEventListener("touchmove", this.touchMoveFn, !1),
                this.eventNode.removeEventListener("touchend", this.touchEndFn, !1)
            } else
                this.eventNode.removeEventListener("mousemove", this.touchMoveFn, !1),
                this.eventNode.removeEventListener("mouseup", this.touchEndFn, !1);
            this.isCurrentlyTouching = !1,
            this.longTapTimer && clearTimeout(this.longTapTimer),
            this.isPC ? this.trigger("mouseup", this, e) : this.trigger("touchend", this, e)
        },
        reset: function() {
            this.startTouch = {
                x: 0,
                y: 0
            },
            this.currentTouch = {
                x: 0,
                y: 0
            },
            this.previousTouch = {
                x: 0,
                y: 0
            },
            this.currentDelta = {
                x: 0,
                y: 0
            },
            this.currentStartDelta = {
                x: 0,
                y: 0
            }
        },
        destroy: function() {
            this.isPC ? this.node.removeEventListener("mousedown", this.touchStartFn, !1) : this.node.removeEventListener("touchstart", this.touchStartFn, !1)
        }
    },
    s.merge(r.prototype, n),
    e.exports = r
}
, function(e, t, a) {
    var i = a(23)
      , s = a(6)
      , n = a(3)
      , r = a(21)
      , o = (a(2),
    function(e) {
        this.contDom = e.dom.cont,
        this.parentEl = e.dom.parentEl,
        this.coreVideo = e.coreVideo
    }
    );
    n.extend(o, i);
    var l = {
        init: function() {
            this.playerData = this.manager.playerData,
            this.nodes = {
                settingBtn: this.parentEl.find(".hv_ico_setting"),
                speedTip: this.parentEl.find(".hv_settingTip"),
                settingPanel: this.parentEl.find(".hv_setting_panel"),
                speedRange: this.parentEl.find(".hv_speed_range"),
                speedItems: this.parentEl.find(".hv_speed_item")
            },
            this.initSpeed(),
            this.addEvent()
        },
        addEvent: function() {
            this.manager.listener.on(r.PLAY_STATE, function(e, t) {
                "ended" == t ? (this.nodes.settingBtn.addClass("gray"),
                this.nodes.settingPanel.removeClass("hover")) : this.nodes.settingBtn.removeClass("gray")
            }, this),
            this.manager.evt.on("vjs_hideBotBar", this.hidePanel, this),
            this.manager.evt.on("hideSettingPanel", this.hidePanel, this),
            this.nodes.settingBtn.on("click", this.onBtnSetting, this),
            this.nodes.speedRange.on("click", this.onSpeedRange, this)
        },
        onBtnSetting: function() {
            if (!this.nodes.settingBtn.hasClass("gray")) {
                var e = this.nodes.settingPanel
                  , t = this.nodes.settingBtn;
                e.hasClass("hover") ? (e.removeClass("hover"),
                t.removeClass("ico-active")) : (e.addClass("hover"),
                t.addClass("ico-active"),
                this.manager.evt.trigger("hideDefiPanel", "speedPanel"),
                this.manager.pingback.sendFeGo({
                    code: "player-setting"
                }))
            }
        },
        onSpeedRange: function(e) {
            var t = e.target;
            if ("span" == t.tagName.toLowerCase()) {
                var a = s(t)
                  , i = a.getAttr("data-speed");
                if (i == this.curSpeed)
                    return;
                var n = "player-speed";
                parseFloat(i) < 1 ? n += "-slow" : parseFloat(i) > 1 && (n += "-fast"),
                this.nodes.speedItems.removeClass("active"),
                a.addClass("active"),
                this.manager.playerData.config.playbackRate = i,
                this.curSpeed = i,
                window.sessionStorage && sessionStorage.setItem("playbackRate", i),
                this.manager.evt.trigger("showTip", "changePlaySpeed"),
                this.manager.evt.trigger(r.EVENT.PLAYER_COMMAND, "changePlaySpeed", i),
                this.manager.pingback.sendFeGo({
                    code: n
                }),
                this.manager.evt.trigger("hideSettingPanel", !1)
            }
        },
        hidePanel: function() {
            var e = this.nodes.settingPanel;
            e.hasClass("hover") && e.removeClass("hover"),
            this.nodes.settingBtn.removeClass("ico-active")
        },
        initSpeed: function() {
            var e = this
              , t = this.playerData.config.playbackRate;
            t && (this.nodes.speedItems.removeClass("active"),
            this.nodes.speedItems.each(function(a, i) {
                i = s(i);
                var n = i.getAttr("data-speed");
                n == t && (i.addClass("active"),
                e.curSpeed = n)
            }),
            this.manager.evt.trigger("showTip", "changePlaySpeed"))
        }
    };
    n.merge(o.prototype, l),
    e.exports = o
}
, function(e, t, a) {
    var i = a(23)
      , s = a(3)
      , n = a(2)
      , r = a(21)
      , o = a(60)
      , l = function(e) {
        this.contDom = e.dom.cont,
        this.parentEl = e.dom.parentEl,
        this.active = e.active,
        this.coreVideo = e.coreVideo
    };
    s.extend(l, i);
    var d = {
        init: function() {
            this.playerData = this.manager.playerData,
            this.nodes = {
                pannel: this.parentEl.find(".js-pannel"),
                loading: this.parentEl.find(".hv_ico_loading"),
                seekTip: this.parentEl.find(".hv_fastslide"),
                seekTipImg: this.parentEl.find(".hv_ico_fastslide"),
                seekTipCurrentTime: this.parentEl.find(".js-seek-curtime"),
                seekTipTotalTime: this.parentEl.find(".js-seek-tottime"),
                seekTipBar: this.parentEl.find(".hv_fastslide_bar")
            },
            this.pannelTouchable = new o(this.nodes.pannel[0],{
                isTargetNode: !0
            }),
            this.seekTotalTime = 180,
            this.seekTime = null,
            this.startSeekTime = null,
            this.seekDir = "",
            this.pannelWidth = 0,
            this.duration = 0,
            this.disable = !0,
            this.manager.evt.on("vjs_durationChange", this.onSetDuration, this),
            this.manager.evt.on(r.EVENT.RESIZE, this.onResize, this),
            n.Android || n.isPC || (this.pannelTouchable.on("touchstart", this.onPannelTouchStart, this),
            this.pannelTouchable.on("touchmove", this.onPannelTouchMove, this),
            this.pannelTouchable.on("touchend", this.onPannelTouchEnd, this)),
            this.onResize()
        },
        onSetDuration: function(e) {
            this.duration = e.args[0],
            this.nodes.seekTipTotalTime[0].innerHTML = s.formatTime(this.duration)
        },
        onResize: function() {
            this.pannelWidth = this.nodes.pannel.width(),
            this.disable = this.contDom.width() <= 310
        },
        onPannelTouchStart: function() {
            clearTimeout(this.prepareSeekTime)
        },
        onPannelTouchMove: function(e) {
            var t = this.manager.listener.get(r.PLAY_STATE);
            if ("init" != t && "chaneDefi" != t && "seeking" != t && !this.disable) {
                var a = this.pannelTouchable.currentStartDelta.x / this.pannelWidth;
                if (Math.abs(a) >= .15 && !this.active.isDrag && (this.active.isDrag = !0,
                this.nodes.seekTip[0].style.display = "block",
                this.nodes.loading[0].style.display = "none",
                this.manager.evt.trigger(r.EVENT.PLAYER_COMMAND, "pause")),
                this.active.isDrag) {
                    null == this.startSeekTime && (this.startSeekTime = this.coreVideo.getCurrentTime());
                    var i = e.args[1];
                    i.preventDefault();
                    var n = this.pannelTouchable.currentDelta.x;
                    if (Math.abs(n) < 2)
                        return;
                    (!this.seekDir || "right" == this.seekDir && n <= 0 || "left" == this.seekDir && n > 0) && (n > 0 ? (this.nodes.seekTipImg.removeClass("hv_ico_returnback"),
                    this.seekDir = "right") : (this.nodes.seekTipImg.addClass("hv_ico_returnback"),
                    this.seekDir = "left")),
                    this.seekTime = this.startSeekTime + a * this.seekTotalTime,
                    this.seekTime = Math.max(0, this.seekTime),
                    this.seekTime = Math.min(this.seekTime, this.duration),
                    this.nodes.seekTipBar.setStyle("width", this.seekTime / this.duration * 100 + "%"),
                    this.nodes.seekTipCurrentTime[0].innerHTML = s.formatTime(this.seekTime),
                    this.manager.evt.trigger("vjs_updateSeekTime", this.seekTime)
                }
            }
        },
        onPannelTouchEnd: function(e) {
            if (this.active.isDrag) {
                var t = e.args[1];
                t.stopPropagation(),
                this.startSeekTime = this.seekTime,
                this.prepareSeekTime = setTimeout(s.bind(function() {
                    this.nodes.seekTip[0].style.display = "none",
                    this.active.isDrag = !1,
                    this.startSeekTime = null,
                    this.manager.evt.trigger(r.EVENT.PLAYER_COMMAND, "seek", this.seekTime),
                    this.manager.evt.trigger("vjs_autoHidePannel")
                }, this), 500)
            }
        }
    };
    s.merge(l.prototype, d),
    e.exports = l
}
, function(e, t, a) {
    var i = a(23)
      , s = a(3)
      , n = a(21)
      , r = function(e) {
        this.contDom = e.dom.cont,
        this.parentEl = e.dom.parentEl,
        this.active = e.active
    };
    s.extend(r, i);
    var o = {
        init: function() {
            this.playerData = this.manager.playerData,
            this.nodes = {
                pannel: this.parentEl.find(".js-pannel"),
                poster: this.parentEl.find(".hv_play_poster"),
                loading: this.parentEl.find(".hv_ico_loading"),
                bigPlayBtn: this.parentEl.find(".hv_ico_pasued"),
                shadow: this.parentEl.find(".js-bg")
            },
            this.showLoadingTime = null,
            this.addEvent()
        },
        addEvent: function() {
            this.manager.listener.on(n.PLAY_STATE, function(e, t) {
                "init" == t && (this.manager.evt.off("vjs_preparPlay", this.onPreparPlay, this),
                this.manager.evt.off("vjs_startPlay", this.onStartPlay, this),
                this.manager.evt.one("vjs_preparPlay", this.onPreparPlay, this),
                this.manager.evt.one("vjs_startPlay", this.onStartPlay, this),
                this.nodes.loading[0].style.display = "block",
                this.nodes.bigPlayBtn[0].style.display = "none")
            }, this),
            this.nodes.bigPlayBtn.on("click", function() {
                this.manager.evt.trigger(n.EVENT.PLAYER_COMMAND, "play")
            }, this),
            this.nodes.pannel.on("click", function(e) {
                e.target == this.nodes.pannel[0] && "play" == this.manager.listener.get(n.PLAY_STATE) && this.manager.evt.trigger(n.EVENT.PLAYER_COMMAND, "pause")
            }, this),
            this.manager.evt.on("vjs_play", function() {
                this.nodes.bigPlayBtn[0].style.display = "none"
            }, this),
            this.manager.evt.on("vjs_pause", function() {
                this.nodes.bigPlayBtn[0].style.display = "block"
            }, this),
            this.manager.evt.on("vjs_hideLoading", this.hideLoading, this),
            this.manager.evt.on("vjs_timeupdate vjs_pause vjs_p2pBufferend", this.hideLoading, this),
            this.manager.evt.on("vjs_seeking vjs_waiting vjs_stalled vjs_p2pBufferstart", this.showLoading, this)
        },
        onStartPlay: function() {
            this.nodes.poster[0].style.display = "none",
            this.nodes.bigPlayBtn[0].style.display = "none",
            this.nodes.shadow[0].style.display = "none",
            this.manager.listener.get(n.IS_AD) || (this.nodes.loading[0].style.display = "block")
        },
        onPreparPlay: function() {
            this.nodes.loading[0].style.display = "none",
            this.nodes.bigPlayBtn[0].style.display = "block"
        },
        showLoading: function(e) {
            if (!this.playerData.config.supportP2P) {
                var t = this.manager.listener.get(n.PLAY_STATE);
                if ("vjs_stalled" == e.type && ("pause" == t || "init" == t || "ended" == t || "stop" == t))
                    return
            }
            "vjs_seeking" == e.type ? this.nodes.loading[0].style.display = "block" : (clearTimeout(this.showLoadingTime),
            this.showLoadingTime = setTimeout(s.bind(function() {
                this.nodes.loading[0].style.display = "block"
            }, this), 500))
        },
        hideLoading: function(e) {
            if (!this.playerData.config.supportP2P) {
                var t = this.manager.listener.get(n.PLAY_STATE);
                if ("vjs_timeupdate" == e.type && "seeking" == t)
                    return
            }
            this.showLoadingTime && (clearTimeout(this.showLoadingTime),
            this.showLoadingTime = null),
            this.nodes.loading[0].style.display = "none"
        }
    };
    s.merge(r.prototype, o),
    e.exports = r
}
, function(e, t, a) {
    var i = a(23)
      , s = a(3)
      , n = a(6)
      , r = a(2)
      , o = a(21)
      , l = function(e) {
        this.contDom = e.dom.cont,
        this.parentEl = e.dom.parentEl,
        this.coreVideo = e.coreVideo
    };
    s.extend(l, i);
    var d = {
        init: function() {
            this.nodes = {
                container: this.parentEl.find(".js-tip"),
                msg: this.parentEl.find(".js-tip-msg"),
                closeBtn: this.parentEl.find(".js_tip_close"),
                btnText: this.parentEl.find(".hv_btn_text"),
                btn: this.parentEl.find(".hv_buy"),
                btnBg: this.parentEl.find(".hv_buy_bg")
            },
            this.playerData = this.manager.playerData,
            this.autoTime = null,
            this.autoMobileTime = null,
            this.addEvent(),
            this.btnText = "",
            this.locked = !1,
            this.isPayed = !1
        },
        addEvent: function() {
            this.nodes.closeBtn.on("click", this.hide, this),
            this.nodes.container.on("click", this.onTipClick, this),
            this.nodes.btn.on("click", this.onTipClick, this),
            this.manager.evt.on("showTip", function(e) {
                this.show(e.args[0], e.args[1])
            }, this),
            this.manager.listener.on(o.PLAY_STATE, function(e, t) {
                "init" == t && this.hide()
            }, this),
            this.manager.evt.on("vjs_tryLookEnd", this.clearTvodTip, this),
            this.manager.evt.on("vjs_showInputPannel", this.toggleTip, this),
            this.manager.evt.on("vjs_hideDefiTip", this.hideDefiTip, this)
        },
        onTipClick: function(e) {
            var t = n(e.target)
              , a = t.getAttr("type")
              , i = t.getAttr("ref");
            switch (1 == this.manager.listener.get(o.FULLSCREEN_STATE) && r.isPC && this.manager.evt.trigger(o.EVENT.PLAYER_COMMAND, "changFullScreen", 0, !0),
            a) {
            case "buy":
                window.open("https://ibuy.le.com/v2/buy/package-ondemind.html?moiveId=" + this.playerData.vinfo.pid + "&ref=m_play_" + i + "_020&frontUrl=" + encodeURIComponent(location.href));
                break;
            case "login":
                try {
                    this.manager.evt.trigger(o.EVENT.PLAYER_CALLBACK, "openLoginDialog")
                } catch (e) {}
                break;
            case "open":
                window.open("https://ibuy.le.com/v2/buy/package.html?frontUrl=" + encodeURIComponent(location.href) + "&type=42?ref=m_play_" + i + "_010");
                break;
            case "useTicket":
                try {
                    this.manager.evt.trigger(o.EVENT.PLAYER_CALLBACK, "useTicket")
                } catch (e) {}
                break;
            case "consumeTicket":
                window.open("https://ibuy.le.com/v2/buy/package.html?frontUrl=" + encodeURIComponent(location.href) + "&type=62?ref=m_play_" + i + "_010")
            }
        },
        show: function(e, t) {
            var a = s.bind(this.manager.lanFit.fit, this.manager.lanFit)
              , i = "";
            if (!this.locked) {
                switch (this.isPayed = !1,
                e) {
                case "changeDefi":
                    i = a("正在为您切换清晰度..."),
                    this.locked = !0;
                    break;
                case "glsbPressure":
                    i = a("人太多挤爆了~暂只能提供低清晰度观看"),
                    this.locked = !0;
                    break;
                case "trylook":
                    i = a("会员影片可试看") + " " + this.manager.playerData.tryLookTime + " " + a("分钟");
                    break;
                case "appGuide":
                    i = a("影片可试看") + " " + this.manager.playerData.tryLookTime + " " + a("分钟");
                    break;
                case "tvod_notLogin":
                    i = '试看6分钟,观看全片请<a class="tip-yellow" type="buy" ref="1105">立即购买</a>，已购买可<a class="tip-yellow" type="login">登录观看</a>',
                    this.btnText = '<span class="hv_btn_text" type="buy" ref="1106">立即购买</span><i class="arrow-right"></i>';
                    break;
                case "tvod_Login":
                    i = '试看6分钟,观看全片请<a class="tip-yellow" type="buy" ref="1105">立即购买</a>',
                    this.btnText = '<span class="hv_btn_text" type="buy" ref="1106">立即购买</span><i class="arrow-right"></i>';
                    break;
                case "tvod_showTime":
                    i = "您已购买本片，观影有效期至：" + s.formatDate(new Date(t), "YY-MM-DD HH:mm", !0),
                    this.isPayed = !0;
                    break;
                case "chargeType1_notLogin":
                    i = '试看6分钟，观看全片请<a class="tip-yellow" type="open" ref="1102">开通会员</a>，已是会员请<a class="tip-yellow" type="login">登录观看</a>',
                    this.btnText = '<span class="hv_btn_text" type="open" ref="1103">开通会员</span><i class="arrow-right"></i>';
                    break;
                case "chargeType1_Login":
                    i = '试看6分钟，观看全片请<a class="tip-yellow" type="open" ref="1102">开通会员</a>',
                    this.btnText = '<span class="hv_btn_text" type="open" ref="1103">开通会员</span><i class="arrow-right"></i>';
                    break;
                case "ticket_Login":
                    i = '试看6分钟，观看全片请使用1张观影券<a class="tip-yellow" type="useTicket">立即使用</a>',
                    this.btnText = '<span class="hv_btn_text" type="useTicket">用券观看</span><i class="arrow-right"></i>';
                    break;
                case "noticket_vip":
                    i = '试看6分钟,观看全片可<a class="tip-yellow" type="consumeTicket" ref="1102">续费会员</a>用券观看或<a class="tip-yellow" type="buy" ref="1105">购买本片</a>',
                    this.btnText = '<span class="hv_btn_text" type="consumeTicket" ref="1103">续费会员</span><i class="arrow-right"></i>';
                    break;
                case "noticket_notvip":
                    i = '试看6分钟，观看全片可<a class="tip-yellow" type="open" ref="1102">开通会员</a>获赠观影券或<a class="tip-yellow" type="buy" ref="1105">购买本片</a>',
                    this.btnText = '<span class="hv_btn_text" type="open" ref="1103">开通会员</span><i class="arrow-right"></i>';
                    break;
                case "ticket_notLogin":
                    i = '试看6分钟,<a class="tip-yellow" type="open" ref="1102">开通会员</a>赠券观看全片，已有券<a class="tip-yellow" type="login">登录观看</a>',
                    this.btnText = '<span class="hv_btn_text" type="open" ref="1103">开通会员</span><i class="arrow-right"></i>';
                    break;
                case "changePlaySpeed":
                    i = a("正在以") + '<span class="speed">' + this.manager.playerData.config.playbackRate + "</span>" + a("倍速度播放")
                }
                this.nodes.msg[0].innerHTML = i,
                "PC" == this.playerData.interactiveType && (this.nodes.container[0].style.display = "block",
                clearTimeout(this.autoTime),
                this.autoTime = setTimeout(s.bind(this.changeMode, this), 5e3)),
                this.manager.evt.trigger("vjs_showPannel"),
                this.btnText && (this.nodes.btnBg[0].innerHTML = this.btnText)
            }
        },
        changeMode: function() {
            this.locked = !1,
            this.nodes.container[0].style.display = "none",
            this.btnText && (this.nodes.btn[0].style.display = "block")
        },
        hide: function() {
            clearTimeout(this.autoMobileTime),
            clearTimeout(this.autoTime),
            this.nodes.container[0].style.display = "none",
            this.nodes.btn[0].style.display = "none"
        },
        clearTvodTip: function(e) {
            this.tvodLookEnd = e.args[0],
            this.tvodLookEnd && this.hide()
        },
        toggleTip: function(e) {
            if ("mobile" == this.playerData.interactiveType && (clearTimeout(this.autoMobileTime),
            clearTimeout(this.autoTime),
            this.btnText || this.isPayed))
                if (e.args[0])
                    this.nodes.btn[0].style.display = "none",
                    this.nodes.container[0].style.display = "none";
                else {
                    if (this.tvodLookEnd)
                        return;
                    this.nodes.container[0].style.display = "block",
                    this.nodes.btn[0].style.display = "none",
                    this.autoMobileTime = setTimeout(s.bind(this.changeMode, this), 5e3)
                }
        },
        hideDefiTip: function() {
            clearTimeout(this.autoTime),
            setTimeout(s.bind(this.changeMode, this), 1200)
        }
    };
    s.merge(l.prototype, d),
    e.exports = l
}
, function(e, t, a) {
    function i() {}
    var s = a(23)
      , n = a(2)
      , r = a(21)
      , o = a(6)
      , l = a(3);
    l.extend(i, s);
    var d, h = {
        init: function() {
            this.playerData = this.manager.playerData,
            this.parentEl = o("#" + this.playerData.config.cont + " .hv_box"),
            n.isPC && (this.containerFullscreenObj = l.checkFullScreenFn(this.parentEl[0]),
            this.parentEl.on("webkitfullscreenchange", function() {
                document.webkitIsFullScreen ? (this.parentEl.addClass("hv_fullscreen"),
                this.manager.listener.set(r.FULLSCREEN_STATE, 1)) : (this.parentEl.removeClass("hv_fullscreen"),
                this.manager.listener.set(r.FULLSCREEN_STATE, 0)),
                this.manager.evt.trigger(r.EVENT.RESIZE)
            }, this)),
            this.onWindowResize = l.bind(c, this)
        },
        changeFullScreen: function(e) {
            var t = e.targetState
              , a = e.type;
            switch (a) {
            case "custom":
                0 == t && this.manager.curVideo.changeFullScreen(!1),
                this.manager.listener.set(r.FULLSCREEN_STATE, t);
                break;
            case "normal":
                if (1 == t) {
                    document.addEventListener("touchmove", this.preventDefault, !1),
                    window.scrollTo(0, -1),
                    this.parentEl.addClass("hv_fullscreen");
                    for (var i = this.parentEl[0].parentNode; "body" != i.tagName.toLowerCase(); ) {
                        var s = i.style.position;
                        if (s && "static" != s)
                            i.defaultPosition = s,
                            i.style.position = "static";
                        else {
                            var o = document.defaultView.getComputedStyle(i);
                            "static" != o.position && (i.style.position = "static")
                        }
                        i = i.parentNode
                    }
                    this.onWindowResize(),
                    window.addEventListener("resize", this.onWindowResize, !1)
                } else {
                    this.manager.curVideo.changeFullScreen(t),
                    document.removeEventListener("touchmove", this.preventDefault, !1),
                    this.parentEl.removeClass("hv_fullscreen");
                    for (var i = this.parentEl[0].parentNode; "body" != i.tagName.toLowerCase(); )
                        i.style.position = i.defaultPosition || "",
                        i = i.parentNode;
                    this.parentEl[0].style.width = "",
                    this.parentEl[0].style.height = "",
                    window.removeEventListener("resize", this.onWindowResize, !1)
                }
                this.manager.listener.set(r.FULLSCREEN_STATE, t),
                this.manager.evt.trigger(r.EVENT.RESIZE);
                break;
            case "system":
            default:
                t = 0 == t ? 0 : 1,
                n.isPC ? t ? this.containerFullscreenObj.requestEl[this.containerFullscreenObj.requestFn]() : this.containerFullscreenObj.cancelEl[this.containerFullscreenObj.cancelFn]() : this.manager.curVideo.changeFullScreen(t)
            }
        },
        preventDefault: function(e) {
            e.preventDefault()
        }
    }, c = function() {
        var e = window.innerWidth
          , t = window.innerHeight;
        this.parentEl.width(e),
        this.parentEl.height(t),
        clearTimeout(d),
        d = setTimeout(l.bind(function() {
            this.manager.evt.trigger(r.EVENT.RESIZE)
        }, this), 200)
    };
    l.merge(i.prototype, h),
    e.exports = i
}
, function(e, t, a) {
    function i(e) {
        this.nodes = e,
        this.videoWidth = this.nodes.parentEl.width(),
        this.videoHeight = this.nodes.parentEl.height()
    }
    var s = a(3)
      , n = a(23)
      , r = (a(2),
    a(6))
      , o = a(21);
    s.extend(i, n);
    var l = {
        init: function() {
            this.playerData = this.manager.playerData,
            this.totalArr = {},
            this.currentArr = {},
            this.currentArrIndex = 0,
            this.curentIndex = 0,
            this.ulendArr = [],
            this.ulNum = 0,
            this.ulGap = 35,
            this.ulIndex = 0,
            this.isOn = !0,
            this.BarrageObj = {},
            this.barrageGap = 30,
            this.stop = null,
            this.isgetData = !1,
            this.isChange = !1,
            this.laststate = "",
            this.lis = [],
            this.vol = 5,
            this.ulNumArray = [],
            this.sendBarrgeText = "",
            this.setInputStatus = null,
            this.expr = 604800,
            this.effectBarrageObj = {
                densityBr: 2,
                alphaBr: 100,
                banRoll: 1,
                banBottom: 1,
                banTop: 1
            },
            this.div = this.nodes.parentEl.find(".hv_barrage")[0],
            this.manager.evt.on(o.EVENT.RESIZE, this.onResize, this),
            this.manager.evt.on("vjs_toggleBarrge", this.toggleBarrge, this),
            this.manager.evt.on("vjs_setBarrageState", this.toggleBarrge, this),
            this.manager.evt.on("vjs_sendBarrge", this.sendBarrage, this),
            this.manager.evt.on("vjs_pushBarrageData", this.sendPageBarrage, this),
            this.manager.evt.on("vjs_setEffectBarrage", this.setEffectBarrage, this);
            var e = (new Date).getTime();
            if (null != localStorage.getItem("barrageTime")) {
                var t = localStorage.getItem("barrageTime");
                (e - t) / 1e3 < this.expr ? (this.effectBarrageObj.alphaBr = localStorage.getItem("alphaBr"),
                this.effectBarrageObj.densityBr = localStorage.getItem("densityBr"),
                this.effectBarrageObj.banRoll = localStorage.getItem("banRoll"),
                this.effectBarrageObj.banBottom = localStorage.getItem("banBottom"),
                this.effectBarrageObj.banTop = localStorage.getItem("banTop"),
                this.isOn = localStorage.getItem("barrgeState")) : (localStorage.removeItem("barrageTime"),
                localStorage.removeItem("alphaBr"),
                localStorage.removeItem("densityBr"),
                localStorage.removeItem("banRoll"),
                localStorage.removeItem("banBottom"),
                localStorage.removeItem("banTop"),
                localStorage.removeItem("barrgeState"))
            }
            this.startListen(),
            this.manager.listener.on(o.BARRAGE_STATE, function(e, t) {
                this.isOn = localStorage.getItem("barrgeState") ? "false" != localStorage.getItem("barrgeState") : t
            }, this)
        },
        startListen: function() {
            this.manager.listener.on(o.PLAY_STATE, function(e, t) {
                "init" == t ? (this.removeAllItem(),
                this.totalArr = {},
                this.onResize(),
                this.currentArrIndex = 0,
                this.curentIndex = 0,
                this.ulNum = 0,
                this.ulIndex = 0,
                this.isChange = !1,
                this.setVol()) : "play" == t ? "seeking" == this.laststate || "ended" == this.laststate ? (this.removeAllItem(),
                this.getData()) : this.getTotalData() : "stop" == t ? this.removeAllItem() : "changeDefi" == t && this.removeAllItem(),
                this.laststate = t
            }, this)
        },
        getData: function() {
            this.currentArrIndex = Math.floor(this.manager.curVideo.getCurrentTime() / 300),
            this.totalArr[this.currentArrIndex] ? (this.curentIndex = 0,
            this.currentArr = this.totalArr[this.currentArrIndex],
            this.stop && (clearInterval(this.stop),
            this.stop = null),
            this.stop = setInterval(s.bind(this.updateBarrage, this), 100)) : this.getTotalData()
        },
        toggleBarrge: function(e) {
            this.isOn = e.args[0],
            e.args[0] ? this.getData() : this.removeAllItem(),
            localStorage.setItem("barrgeState", this.isOn)
        },
        setEffectBarrage: function(e) {
            this.effectBarrageObj = e.args[0],
            this.setBanBarrage(),
            this.setBarrgeAlpha(),
            this.setDensityBr();
            var t = (new Date).getTime();
            localStorage.setItem("barrageTime", t),
            localStorage.setItem("alphaBr", this.effectBarrageObj.alphaBr),
            localStorage.setItem("densityBr", this.effectBarrageObj.densityBr),
            localStorage.setItem("banRoll", this.effectBarrageObj.banRoll),
            localStorage.setItem("banBottom", this.effectBarrageObj.banBottom),
            localStorage.setItem("banTop", this.effectBarrageObj.banTop)
        },
        setBanBarrage: function() {
            var e = document.getElementsByClassName("hv_barrage")[0];
            if (2 == this.effectBarrageObj.banRoll) {
                for (var t = e.getElementsByClassName("roll"), a = t.length - 1; a >= 0; a--)
                    t[a].parentNode.removeChild(t[a]);
                for (var i = 0; i < this.ulendArr.length; i++)
                    this.ulendArr[i] = null
            }
            if (2 == this.effectBarrageObj.banBottom)
                for (var t = e.getElementsByClassName("bottom"), a = t.length - 1; a >= 0; a--)
                    t[a].parentNode.removeChild(t[a]);
            if (2 == this.effectBarrageObj.banTop)
                for (var t = e.getElementsByClassName("top"), a = t.length - 1; a >= 0; a--)
                    t[a].parentNode.removeChild(t[a])
        },
        setDensityBr: function() {
            this.setUlNum(),
            this.effectBarrageObj.densityBr == -1 ? this.barrageGap = 1 : 2 == this.effectBarrageObj.densityBr ? this.barrageGap = 30 : 1 == this.effectBarrageObj.densityBr ? (this.ulNum = Math.floor(this.ulNum / 2),
            this.removeBarrge(this.ulNum)) : 0 == this.effectBarrageObj.densityBr && (this.ulNum = Math.floor(this.ulNum / 4),
            this.removeBarrge(this.ulNum))
        },
        removeBarrge: function(e) {
            this.barrageGap = 30;
            for (var t = document.getElementsByClassName("hv_barrage")[0], a = t.getElementsByTagName("ul"), i = e; i < a.length; i++)
                a[i].innerHTML = ""
        },
        setBarrgeAlpha: function() {
            var e = document.getElementsByClassName("hv_barrage")[0];
            if (e)
                for (var t = e.getElementsByTagName("li"), a = 0; a < t.length; a++)
                    t[a].style.opacity = this.effectBarrageObj.alphaBr / 100
        },
        sendPageBarrage: function(e) {
            this.BarrageObj = e.args[0]
        },
        sendBarrage: function(e) {
            this.sendTextTemp = e.args[0],
            this.setInputStatus = e.args[1];
            var t = this.manager.listener.get(o.USER_INFO);
            if (t) {
                var a = o.PROTOCAL + o.HOST_NAME.HD_MY_LETV_COM + "/danmu/add"
                  , i = {
                    vid: this.playerData.vinfo.vid,
                    pid: this.playerData.vinfo.pid,
                    cid: this.playerData.vinfo.cid,
                    start: this.manager.curVideo.getCurrentTime(),
                    isIdentify: 1,
                    txt: e.args[0],
                    color: "FFFFFF",
                    font: "m",
                    type: "txt",
                    position: "4"
                };
                this.jsonp = s.getJSON({
                    url: a,
                    data: i,
                    success: s.bind(this.onsendSuccess, this),
                    fail: s.bind(this.onsendFail, this)
                })
            } else
                this.manager.evt.trigger(o.EVENT.PLAYER_CALLBACK, "openLoginDialog")
        },
        onsendSuccess: function(e) {
            this.jsonp = null;
            405 == e.code ? (this.setInputStatus("用户未实名认证"),
            this.manager.evt.trigger(o.EVENT.PLAYER_CALLBACK, "openAuthentication")) : 403 == e.code ? (this.setInputStatus("用户未登录"),
            this.manager.evt.trigger(o.EVENT.PLAYER_CALLBACK, "openLoginDialog")) : 401 == e.code ? this.setInputStatus("含有敏感词") : 402 == e.code ? this.setInputStatus("发布太频繁，喝口水吧") : 404 == e.code ? this.setInputStatus("用户被禁言") : 406 == e.code ? this.setInputStatus("没有ip") : 500 == e.code ? this.setInputStatus("失败") : (this.BarrageObj.txt = this.sendTextTemp,
            this.BarrageObj.position = "4",
            this.BarrageObj.font = "m",
            this.BarrageObj.color = "FFFFFF",
            this.setInputStatus("success"))
        },
        onsendFail: function() {
            this.jsonp = null
        },
        onResize: function() {
            this.removeAllItem(),
            this.videoWidth = this.nodes.parentEl.width(),
            this.videoHeight = this.nodes.parentEl.height(),
            this.getTotalData(),
            this.setVol()
        },
        setVol: function() {
            this.vol = this.videoWidth > 640 ? 8 : 5
        },
        getTotalData: function() {
            var e = o.PROTOCAL + o.HOST_NAME.HD_MY_LETV_COM + "/danmu/list"
              , t = {
                vid: this.playerData.vinfo.vid,
                start: this.manager.curVideo.getCurrentTime() + 5,
                amount: 2e3
            };
            this.jsonp = s.getJSON({
                url: e,
                data: t,
                success: s.bind(this.onSuccess, this),
                fail: s.bind(this.onFail, this)
            })
        },
        onSuccess: function(e) {
            this.jsonp = null,
            200 == e.code && (this.parseBarrageVO(e),
            this.showBarrage())
        },
        onFail: function() {
            this.jsonp = null
        },
        parseBarrageVO: function(e) {
            this.currentArrIndex = Math.floor((this.manager.curVideo.getCurrentTime() + 5) / 300),
            this.curentIndex = 0,
            this.totalArr[this.currentArrIndex] = e.data.list,
            this.totalArr[this.currentArrIndex].sort(s.compare("start")),
            this.currentArr = this.totalArr[this.currentArrIndex];
            for (var t = 0; t < this.totalArr.length; t++)
                if (this.currentArr[t].start >= this.manager.curVideo.getCurrentTime()) {
                    this.curentIndex = t;
                    break
                }
            this.stop && (clearInterval(this.stop),
            this.stop = null),
            this.stop = setInterval(s.bind(this.updateBarrage, this), 100),
            this.isgetData = !1
        },
        showBarrage: function() {
            if (!this.isChange) {
                var e = "";
                this.setUlNum(),
                this.ulNumArray = [];
                for (var t = 0; t < this.ulNum; t++)
                    this.ulNumArray.push(0),
                    e += '<ul style="position:relative;top:' + (t * this.ulGap + 30) + 'px"></ul>';
                this.div.innerHTML = e,
                this.div.style.top = "0px",
                this.isChange = !1,
                this.setDensityBr()
            }
        },
        setUlNum: function() {
            this.ulNum = Math.floor((this.videoHeight - 80) / 35),
            this.ulGap = 35,
            this.ulNum > 10 && (this.ulNum = 10,
            this.ulGap = Math.floor((this.videoHeight - 80) / 10))
        },
        updateBarrage: function() {
            if ("pause" != this.laststate && this.isOn && !this.manager.listener.get(o.IS_AD)) {
                if (this.currentArr) {
                    for (var e = this.curentIndex; e < this.currentArr.length; e++) {
                        if (this.currentArr[e].start > this.manager.curVideo.getCurrentTime()) {
                            "string" == typeof this.BarrageObj.txt && this.insertItem(0);
                            break
                        }
                        if (!(this.currentArr[e].start < this.manager.curVideo.getCurrentTime() - 3)) {
                            for (var t = 0; t <= this.ulNum; t++)
                                if (!this.ulendArr[t] || (this.ulendArr[t].offsetWidth + this.videoWidth) * this.ulendArr[t].interval / (1e3 * this.vol) - this.ulendArr[t].offsetWidth > this.barrageGap) {
                                    this.ulIndex = t;
                                    break
                                }
                            this.ulIndex < this.ulNum && this.insertItem(this.ulIndex);
                            break
                        }
                        this.curentIndex++
                    }
                    0 == this.currentArr.length && "string" == typeof this.BarrageObj.txt && this.insertItem(0)
                }
                for (var t = 0; t < this.ulendArr.length; t++)
                    this.ulendArr[t] && (this.ulendArr[t].interval += 100)
            }
            if (this.currentArr && !this.isgetData) {
                this.currentArr.length;
                this.manager.curVideo.getCurrentTime() >= 300 * this.currentArrIndex + 300 && (this.totalArr[this.currentArrIndex + 1] ? (this.currentArrIndex++,
                this.currentArr = this.totalArr[this.currentArrIndex],
                this.curentIndex = 0) : (this.isChange = !0,
                this.isgetData = !0,
                this.getTotalData()))
            }
        },
        setColor: function(e) {
            return 6 != e.length || "" == e || "000000" == e ? "FFFFFF" : e
        },
        mapFontsize: function(e) {
            return "l" == e ? "24px" : "m" == e ? "20px" : "s" == e ? "18px" : "20px"
        },
        insertItem: function(e) {
            var t, a = this, i = document.createElement("li"), s = {};
            if (s = this.currentArr[this.curentIndex],
            i.style["float"] = "left",
            i.style.position = "absolute",
            i.style.lineHeight = "25px",
            i.style.whiteSpace = "nowrap",
            i.style.listStyle = "none",
            i.style.opacity = this.effectBarrageObj.alphaBr / 100,
            i.style.textShadow = "1px 1px 2px #000000",
            s && (i.style.color = "#" + this.setColor(s.color),
            i.style.fontSize = this.mapFontsize(s.font),
            i.innerText = s.txt,
            i.position = s.position),
            "string" == typeof this.BarrageObj.txt ? (i.style.fontSize = this.mapFontsize(this.BarrageObj.font),
            i.style.color = "#" + this.BarrageObj.color,
            i.innerText = this.BarrageObj.txt,
            i.position = this.BarrageObj.position) : this.curentIndex++,
            i.style.padding = "0rem 1rem",
            1 == i.position) {
                if (1 == parseInt(this.effectBarrageObj.banTop) || "string" == typeof this.BarrageObj.txt) {
                    for (var n = -1, o = 0; o < this.ulNumArray.length; o++)
                        if (0 == this.ulNumArray[o]) {
                            n = o,
                            this.ulNumArray[o] = 1;
                            break
                        }
                    n > -1 && (t = this.div.childNodes[n],
                    t && t.appendChild(i),
                    i.style.left = (this.videoWidth - i.offsetWidth) / 2 + "px",
                    i.index = n,
                    i.className = "top",
                    setTimeout(function() {
                        i.parentNode && i.parentNode.removeChild(i),
                        a.ulNumArray[i.index] = 0
                    }, 4e3))
                }
            } else if (3 == i.position) {
                if (1 == parseInt(this.effectBarrageObj.banBottom) || "string" == typeof this.BarrageObj.txt) {
                    for (var l = -1, d = this.ulNumArray.length - 1; d >= 0; d--)
                        if (0 == this.ulNumArray[d]) {
                            l = d,
                            this.ulNumArray[d] = 1;
                            break
                        }
                    l > -1 && (t = this.div.childNodes[l],
                    t && t.appendChild(i),
                    i.style.left = (this.videoWidth - i.offsetWidth) / 2 + "px",
                    i.index = l,
                    i.className = "bottom",
                    setTimeout(function() {
                        i.parentNode && i.parentNode.removeChild(i),
                        a.ulNumArray[i.index] = 0
                    }, 4e3))
                }
            } else
                1 != parseInt(this.effectBarrageObj.banRoll) && "string" != typeof this.BarrageObj.txt || (t = this.div.childNodes[e],
                t && t.appendChild(i),
                this.ulendArr[e] = i,
                this.ulendArr[e].interval = 0,
                i.style.transitionTimingFunction = "linear",
                i.className = "roll",
                r(i).setStyle("-webkit-transform", "translateX(" + this.videoWidth + "px)"),
                r(i).setStyle("-moz-transform", "translateX(" + this.videoWidth + "px)"),
                r(i).setStyle("-ms-transform", "translateX(" + this.videoWidth + "px)"),
                r(i).setStyle("-o-transform", "translateX(" + this.videoWidth + "px)"),
                r(i).setStyle("transform", "translateX(" + this.videoWidth + "px)"),
                i.offsetWidth,
                r(i).setStyle("-webkit-transitionDuration", this.vol + "s"),
                r(i).setStyle("-webkit-transitionTimingFunction", "linear"),
                r(i).setStyle("-webkit-transform", "translateX(" + -i.offsetWidth + "px)"),
                r(i).setStyle("transitionDuration", this.vol + "s"),
                r(i).setStyle("transitionTimingFunction", "linear"),
                r(i).setStyle("transform", "translateX(" + -i.offsetWidth + "px)"),
                i.addEventListener("webkitTransitionEnd", function() {
                    i && i.parentNode.removeChild(i)
                }, !1));
            this.BarrageObj = {}
        },
        removeAllItem: function() {
            var e = document.getElementsByClassName("hv_barrage")[0];
            if (e) {
                for (var t = e.getElementsByTagName("li"), a = t.length - 1; a >= 0; a--)
                    t[a].parentNode.removeChild(t[a]);
                for (var i = 0; i < this.ulendArr.length; i++)
                    this.ulendArr[i] = null
            }
            this.currentArrIndex = Math.floor((this.manager.curVideo.getCurrentTime() + 5) / 300),
            this.curentIndex = 0,
            this.stop && (clearInterval(this.stop),
            this.stop = null)
        }
    };
    s.merge(i.prototype, l),
    e.exports = i
}
, function(e, t, a) {
    var i = a(3)
      , s = a(5)
      , n = {
        getHostName: function() {
            return window.location.hostname
        },
        getDocumentReferrer: function() {
            var e = document.referrer;
            return e && e.length > 0 ? e : "-"
        },
        getUserInfo: function() {
            var e = i.getCookie("m")
              , t = (i.getCookie("u"),
            i.getCookie("ui"),
            i.getCookie("ssouid"));
            return t && e ? e : "-"
        },
        getUserSSOUID: function() {
            var e = (i.getCookie("m"),
            i.getCookie("u"))
              , t = (i.getCookie("ui"),
            i.getCookie("ssouid"));
            if (t && e) {
                var a = i.StrTOJSON(s.enc.Base64.parse(e).toString(s.enc.Utf8));
                return a.ssouid
            }
            return "-"
        },
        getBaiduUID: function() {
            var e = i.getCookie("baidu_uid");
            if (e)
                return window.name += "&baidu_uid=" + e,
                i.setCookie("baidu_uid", ""),
                e;
            if (window.name.indexOf("&baidu_uid=") >= 0) {
                var t = window.name.match(/(^|&)baidu_uid=([^&]*)(&|$)/);
                if (null != t)
                    return t[2]
            }
            return "-"
        },
        getNikename: function() {
            return i.getCookie("sso_nickname") || "-"
        },
        getWeid: function() {
            return String((new Date).getTime()) + String(Math.random()).slice(-7)
        },
        setLc: function(e) {
            i.setCookie("tj_lc", e, {
                expires: 3650
            })
        },
        openLoginDialog: void 0,
        addComment: void 0
    };
    e.exports = n
}
]);
