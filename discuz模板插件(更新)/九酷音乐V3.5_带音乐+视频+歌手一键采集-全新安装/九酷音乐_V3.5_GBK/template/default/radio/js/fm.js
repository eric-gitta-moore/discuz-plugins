var jsonaray = null;
var playid = 0;
var playpos = 0;
var leixing="";
var pu = new Playergeci();
var $song_data = new Array();
$song_data[0]={songlist:[]};
var preplay = new Array();
var playbfqid=0;
//start
function getstart() {
	if(leixing=="fg"){
		getstyle(playid);
	}else if(leixing=="zhuanti"){
		getzhuanti(playid);
	}else{
		getrand();
	}
}


//背景图片
function setBackground(url) {
	var bg = document.getElementById("radiobgImg");
	bg.src = url;
	if (bg.className == "hideImg") {
		initBgImg();
	}
}

function initBgImg() {
	var bg = document.getElementById("radiobgImg");
	if (typeof(bg.complete) == "undefined" || bg.complete) {
		bg.className = "";
		refreshBg();
	} else {
		setTimeout("initBgImg()",30);
	}
}

function refreshBg() {
	var bgWidth = 1680;
	var bgHeight = 1050;
	var w = $(window).width();
	var h = $(window).height();
	var bgDiv = $("#radiobg");
	if (w < 960) {
		return;
	}
	var wRate = bgWidth / w;
	var hRate = bgHeight / h;
	var bgImg = $("#radiobgImg");
	bgDiv.css({
		"height": h,
		"width": w
	});
	if (wRate > hRate) {
		var imgW = parseInt(bgWidth / hRate);
		var l = "-" + parseInt((imgW - w) / 2) + "px";
		bgImg.css({
			"height": h,
			"width": imgW,
			"left": l,
			"top": "0"
		});
	} else {
		var imgH = parseInt(bgHeight / wRate);
		var t = "-" + parseInt((imgH - h) / 2) + "px";
		bgImg.css({
			"width": w,
			"height": imgH,
			"left": "0",
			"top": t
		});
	}
}

$(function(){
	refreshBg();
});
$(window).resize(function(){
	initBgImg()
});


//ie
if(isIE){
	$(function () {		   
		(function ($) {
			$.fn.slider = function (options) {
				var f = 0,
				q = $(this).offset(),
				t = options.slide,
				r = $(this).width(),
				k = function (s) {
					var d = s - q.left;
					if (d >= options.min && d <= options.max) {
						t.call(this, d)
					}
			};
			$(this).mousedown(function (e) {
				f = 1;
				k.call(this, e.clientX);
				$(document).mouseup(function () {
					f = 0
				})
			}).mouseup(function (e) {
				f = 0;
				c = e.clientX;
				$(document).unbind('mouseup')
				}).mousemove(function (e) {
					if (f == 1) {
						k.call(this, e.clientX)
					}
				}).get(0).setAttribute('unselectable', 'on')
			}
		})($);
	});

	$(document).ready(function () {
		var e = document.getElementById('mediaPlayerObj');
		$('.jp-volume-bar-value').attr('vol', 70);
		$('.jp-volume-bar-value').css('width', '70px');
		$('.jp-volume-bar').slider({
			value: 70,
			min: 0,
			max: 100,
			slide: function (d) {
				e.settings.volume=d+20;
				$('.jp-unmute').hide();$('.jp-mute').show();
				$('.jp-volume-bar-value').attr('vol', d);
				$('.jp-volume-bar-value').css('width', d + 'px');
			}
		});	
		getstart();
		ssplay();
	});
}else{
	//非Ie
	$(function(){
		$("#radioPlayer").jPlayer({
			supplied: "mp3",
			swfPath: "/template/qianwe_002/static/js",
			wmode: "window",
			ready: function () { getstart(); },
			ended: function () { getpre();getnext(); }
		});
	});
}

//--------------播放器效果---------------//
//再听一遍
$(function(){
	$("#backFm").hover(function(){
		$("#backFm-overlay").show();
	},function(){
		$("#backFm-overlay").hide();
	})
})	
		
//更换频道
$(function(){
	$("#tool_channel").live("click",function(){
		$(this).attr("id","tool_channel_active");
		$(".tool_skin").removeClass("active").html("更换皮肤<b></b>").attr("id","tool_skin");
		$(this).addClass("active").html("关闭<b></b>");
		$("#fmPlayer").hide();
		$("#skinDiv").hide();
		$("#channelDiv").show();
		return false;
		});
		$("#tool_channel_active").live("click",function(){
			$(this).attr("id","tool_channel");
			$(this).removeClass("active").html("更换频道<b></b>");
		$("#fmPlayer").show();
		$("#channelDiv").hide();
		return false;
		});
		
		$(".channel-btn").hover(function(){
			$(this).addClass("channel-btn-hover");
			},function(){
			$(this).removeClass("channel-btn-hover");
				})
				
			$(".channel-btn").click(function(){
				var channelText=$(this).find("a").text();
				playid=$(this).attr("data-id");
				leixing=$(this).attr("data-lei");
				
				$(".channel-btn").removeClass("channel-btn-current");
				$(this).addClass("channel-btn-current");
				$("#channel_name").text(channelText);
				$(".tool_channel").removeClass("active").html("更换频道<b></b>").attr("id","tool_channel");
		  $("#channelDiv").hide();
				$("#fmPlayer").show();
				//alert(leixing+playid);
				getstart();
				})	
	})					
//更换皮肤
//jQuery.cookie 插件
jQuery.cookie = function(name, value, options) {
    if (typeof value != 'undefined') { // name and value given, set cookie
        options = options || {};
        if (value === null) {
            value = '';
            options.expires = -1;
        }
        var expires = '';
        if (options.expires && (typeof options.expires == 'number' || options.expires.toUTCString)) {
            var date;
            if (typeof options.expires == 'number') {
                date = new Date();
                date.setTime(date.getTime() + (options.expires * 24 * 60 * 60 * 1000));
            } else {
                date = options.expires;
            }
            expires = '; expires=' + date.toUTCString(); // use expires attribute, max-age is not supported by IE
        }
        var path = options.path ? '; path=' + (options.path) : '';
        var domain = options.domain ? '; domain=' + (options.domain) : '';
        var secure = options.secure ? '; secure' : '';
        document.cookie = [name, '=', encodeURIComponent(value), expires, path, domain, secure].join('');
    } else { // only name given, get cookie
        var cookieValue = null;
        if (document.cookie && document.cookie != '') {
            var cookies = document.cookie.split(';');
            for (var i = 0; i < cookies.length; i++) {
                var cookie = jQuery.trim(cookies[i]);
                // Does this cookie string begin with the name we want?
                if (cookie.substring(0, name.length + 1) == (name + '=')) {
                    cookieValue = decodeURIComponent(cookie.substring(name.length + 1));
                    break;
                }
            }
        }
        return cookieValue;
    }
};
$(function(){
	$("#tool_skin").live("click",function(){
		$(this).attr("id","tool_skin_active");
		$(".tool_channel").removeClass("active").html("更换频道<b></b>").attr("id","tool_channel");
		$(this).addClass("active").html("关闭<b></b>");
		$("#channelDiv").hide();
		$("#fmPlayer").show();
		$("#skinDiv").show();
		return false;
	})
	$("#tool_skin_active").live("click",function(){
		$(this).attr("id","tool_skin");
		$(this).removeClass("active").html("更换皮肤<b></b>");
		$("#skinDiv").hide();
		return false;
	})
	//设置皮肤
	$(".skinList li").click(function(){
		var skinSrc=$(this).find("a").attr("dataimg")
		$(this).siblings().find("#bgSelectFlag").remove();
		$(this).siblings().removeClass("skinSelect");
		$(this).addClass("skinSelect").append('<span id="bgSelectFlag"></span>')
		$("#radiobgImg").attr("src",skinSrc)
		refreshBg();
		$.cookie( "fmSkin" ,this.id, { path: '/', expires: 10 });
	})
	//判断是否存在cookie
	var cookie_skin = $.cookie( "fmSkin");
	if (cookie_skin) {
		var skinSrc=$("#"+cookie_skin).find("a").attr("dataimg")
		$("#"+cookie_skin).siblings().find("#bgSelectFlag").remove();
		$("#"+cookie_skin).siblings().removeClass("skinSelect");
		$("#"+cookie_skin).addClass("skinSelect").append('<span id="bgSelectFlag"></span>')
		$("#radiobgImg").attr("src",skinSrc)
		refreshBg();
		$.cookie( "fmSkin" ,  cookie_skin  , { path: '/', expires: 10 });
	}
})

//风格
function getstyle(ids) {
	//alert(ids);
	var url = 'template/qianwe_002/php/ajax.php?action=getfmurl&do=fg&id='+ escape(ids);
	getdownload(url);
}

//专题
function getzhuanti(ids) {
	//alert(ids);
	var url = 'template/qianwe_002/php/ajax.php?action=getfmurl&do=zhuanti&id='+ ids;
	getdownload(url);
}

//随机
function getrand() {
	//var url = '/fm/rand.js';
	var url = 'template/qianwe_002/php/ajax.php?action=getfmurl';
	getdownload(url);
}

function getnext() {
	if (jsonaray != null) {
		if (playpos >= jsonaray.length) playpos = 0;
		$(".playing-song").html('<a href="music.php?mod=play&id=' + jsonaray[playpos][1] + '" target="_blank">' + jsonaray[playpos][2] + '</a>');
		$(".playing-singer").html('<a href="music.php?mod=singer&id='+escape(jsonaray[playpos][4])+'" target="_blank">' + jsonaray[playpos][4] + '</a>');
		if(jsonaray[playpos][6].length>0){
			if(jsonaray[playpos][5]>0){
				$(".playing-album").html('<a href="home.php?mod=space&uid=' + jsonaray[playpos][5] + '" target="_blank">《' + jsonaray[playpos][6] + '》</a>');
			}else{
				$(".playing-album").html('');
			}
		}else{

			if(jsonaray[playpos][5]>0){
				$(".playing-album").html('<a href="home.php?mod=space&uid=' + jsonaray[playpos][5] + '" target="_blank">' + jsonaray[playpos][6] + '</a>');
			}else{
				$(".playing-album").html('');
			}
		}
		if(jsonaray[playpos][5]>0){
			$('#albumPic').attr('href', 'home.php?mod=space&uid=' + jsonaray[playpos][5] + '');
			$('#albumPic').attr('target', '_blank');
		}else{
			$('#albumPic').attr('href', 'javascript:;');
			$('#albumPic').attr('target', '_self');
		}

		if (jsonaray[playpos][8].length < 3) {
			$('#albumPic img').attr('src', "template/qianwe_002/static/images/fm/noAlbumPic.png");											
		} else {
			$('#albumPic img').attr('src', jsonaray[playpos][8]);
		}
		$('.btnDownloadIcon').attr('href', 'music.php?mod=play&id=' + jsonaray[playpos][1]);
		$('.downMusic').attr('href', 'music.php?mod=down&do=attachment&id=' + jsonaray[playpos][1]);
		document.title = jsonaray[playpos][2] + '-' + jsonaray[playpos][4];
		var firstplay = getMusicPath(jsonaray[playpos][7]);
		if(isIE){
			document.getElementById("mediaPlayerObj").URL = firstplay; 
		}else{
			$("#radioPlayer").jPlayer("setMedia", { mp3: unescape(firstplay) }).jPlayer("play");
		}

		sid=jsonaray[playpos][1];
		pu.downloadlrc(sid);
		pu.PlayLrc(sid); 

		//单击下一首 获取歌手歌曲 只有第一次单击有用
		$(".jp-next").unbind();
		$(".jp-next").one("click", function () { getpre();getnext(); return false; });
		playpos++;
	} else {
		alert('播放列表空');
	}
}

function randnum(maxnum) {
	return Math.floor(Math.random() * (maxnum + 1))
}

/*判断歌曲地址 不同目录前缀服务器不一样*/

var getMusicPath = function (music) {
	music = music;
	return music;
}

function getdownload(URL){Tag = document.createElement("script");Tag.type="text/javascript";Tag.src=URL;document.getElementsByTagName("head")[0].appendChild(Tag);}

function song_list(i,k)
{
//alert($song_data[0]);
//  var data2 = '(' + $song_data[0] + ')';
//            var json = eval(data2);
            var json=$song_data[0];
            playpos = 0;
            jsonaray = null;
//alert(json.songlist.length);
            if (json.songlist.length > 0) {
                jsonaray = new Array();
                for (var ss = 0; ss < json.songlist.length; ss++) {
                    if (json.songlist[ss] != undefined) {
                        jsonaray[ss] = new Array();
                        jsonaray[ss][0] = randnum(9999);
                        jsonaray[ss][1] = json.songlist[ss].gqid;
                        jsonaray[ss][2] = json.songlist[ss].gqname;
                        jsonaray[ss][3] = json.songlist[ss].gsid;
                        jsonaray[ss][4] = json.songlist[ss].gsname;
                        jsonaray[ss][5] = json.songlist[ss].zjid;
                        jsonaray[ss][6] = json.songlist[ss].zjname;
                        jsonaray[ss][7] = json.songlist[ss].mp3;
                        if (json.songlist[ss].zjpic.length > 3) {
                            jsonaray[ss][8] = (json.songlist[ss].zjpic.indexOf('http:') > -1 ? '' : '') + json.songlist[ss].zjpic;
                        } else {
                            jsonaray[ss][8] = "";
                        }
                    }
                }

                jsonaray.sort(function (x, y) {
                    return x[0] - y[0];
                });
getpre();
getnext();
}
}

//上一首
function getpre(){
	if(jsonaray != null && playpos>0){
		preplay= jsonaray[playpos-1];
		if (preplay[8].length < 3) {
			$('#backFm-img img').attr('src', "template/qianwe_002/static/images/fm/noAlbumPic.png");
		} else {
			$('#backFm-img img').attr('src', preplay[8]);
		}
		$("#jq-tooltip").html(preplay[2]+"-"+preplay[4]);
		$("#backFm-overlay").unbind();
		$("#backFm-overlay").one("click", function () { getrepeat(); return false; });
	}
}

function getrepeat() {
	if (jsonaray != null) {
		$(".playing-song").html('<a href="music.php?mod=play&id=' + preplay[1] + '" target="_blank">' + preplay[2] + '</a>');
		$(".playing-singer").html('<a href="music.php?mod=singer&id='+escape(preplay[4])+'" target="_blank">' + preplay[4] + '</a>');
		if(preplay[6].length>0){
			if(preplay[5]>0){
				$(".playing-album").html('<a href="home.php?mod=space&uid=' + preplay[5] + '" target="_blank">《' + preplay[6] + '》</a>');
			}else{
				$(".playing-album").html('');
			}
		}else{
			if(preplay[5]>0){
				$(".playing-album").html('<a href="home.php?mod=space&uid=' + preplay[5] + '" target="_blank">' + preplay[6] + '</a>');
			}else{
				$(".playing-album").html('');
			}
		}
		if(preplay[5]>0){
			$('#albumPic').attr('href', 'home.php?mod=space&uid=' + preplay[5]);
			$('#albumPic').attr('target', '_blank');
			$('.downMusic').attr('href', 'music.php?mod=down&do=attachment&id=' + preplay[1]);
			$('.downMusic').attr('target', '_blank');
		}else{
			$('#albumPic').attr('href', 'javascript:;');
			$('#albumPic').attr('target', '_self');
			$('.downMusic').attr('href', 'javascript:;');	
			$('.downMusic').attr('target', '_self');	
		}
		 
        	if (preplay[8].length < 3) {
			$('#albumPic img').attr('src', "template/qianwe_002/static/images/fm/noAlbumPic.png");
		} else {
			$('#albumPic img').attr('src', preplay[8]);
		}

		$('.btnDownloadIcon').attr('href', 'music.php?mod=play&id=' + preplay[1]);
		document.title = preplay[2] + '-' + preplay[4];
		var firstplay = getMusicPath(preplay[7]);
		if(isIE){
			document.getElementById("mediaPlayerObj").URL = firstplay; 
		}else{
			$("#radioPlayer").jPlayer("setMedia", { mp3: unescape(firstplay) }).jPlayer("play");
		}
        	sid=preplay[1];
        	pu.downloadlrc(sid);
		pu.PlayLrc(sid);
        	//单击下一首 获取歌手歌曲 只有第一次单击有用
		$("#backFm-overlay").unbind();
		$("#backFm-overlay").one("click", function () { getrepeat(); return false; });
		$(".jp-next").unbind();
		$(".jp-next").one("click", function () { getnext(); return false; });
	} else {
		alert('播放列表空');
	}
}
var buffering=0;
var stoped=0;
var linking=0;
var ready=0;
function ssplay(){
/*播放器状态检测*/
var jiuku=document.getElementById("mediaPlayerObj");
var currentZt = jiuku.playState;
switch(currentZt){
	case 10://准备就绪
		document.getElementById('PlayStateTxt').innerHTML="准备就绪：";
		ready+=2;
		if(ready>=120){
			ready=0;
			getpre();getnext();
		}
		//ajaxly();
		break;
	case 9://正在连接
		document.getElementById('PlayStateTxt').innerHTML="正在连接...";
		linking+=2;
		if(linking>=480){
			linking=0;
			getpre();getnext();
		}
		break;
	case 6://正在缓冲
		document.getElementById('PlayStateTxt').innerHTML="正在缓冲...";
		buffering+=2;
		if(buffering>=480){buffering=0;
			getpre();getnext();
		}
		break;
	case 3://正在播放
		if(parseInt(jiuku.controls.currentPosition)>1){stnumk=0;}
		$(".jp-play").hide();
		$(".jp-pause").show();
		try {
			$(".jp-current-time").text(showPlayingTime(parseInt(jiuku.controls.currentPosition)));
			$(".jp-duration").text(showPlayingTime(parseInt(jiuku.currentMedia.duration)));
			var d=parseInt(parseInt(jiuku.controls.currentPosition) / parseInt(jiuku.currentMedia.duration)*100);
			document.getElementById('PlayStateTxt').innerHTML="正在播放...";
		} catch (e) {}
		buffering=0;
		stoped=0;
		linking=0;
		ready=0;
		break;
	case 2://暂停
		document.getElementById('PlayStateTxt').innerHTML="暂停...";
		$(".jp-play").show();
		$(".jp-pause").hide();
		break;
	case 1:	//播放完停止了
		$('.jp-play-bar').css('width', '0px');
		getpre();getnext();
		break;
	default://其他
		document.getElementById('PlayStateTxt').innerHTML="-";
		stoped+=2;
		if(stoped>=480){stoped=0;
			getpre();getnext();
		}
		break;
}/*检测结束*/
playbfqid=setTimeout("ssplay()", 200); 
}
//暂停
function btnpause(){try{document.getElementById('mediaPlayerObj').controls.pause();}catch(e){return(false);}}
//播放按钮
function btnplay(){try{document.getElementById('mediaPlayerObj').controls.play();}catch(e){return(false);}}
//静音
function btnmute(){try{document.getElementById('mediaPlayerObj').settings.volume=0;$('.jp-volume-bar-value').css('width', '0px');$('.jp-unmute').show();$('.jp-mute').hide();}catch(e){return(false);}}
//取消静音
function btnunmute(){try{var d=$('.jp-volume-bar-value').attr('vol');document.getElementById('mediaPlayerObj').settings.volume=d+20;$('.jp-volume-bar-value').css('width', d+'px');$('.jp-unmute').hide();$('.jp-mute').show();}catch(e){return(false);}}

function showPlayingTime(seconds){
var minute=parseInt(seconds/60);
var second=parseInt(seconds-minute*60);
if(minute<10){minute='0'+minute;}if(second<10){second='0'+second;}
return minute+':'+second;
};

document.onkeydown=function(event){
	if(event.keyCode=='39'){
		getpre();getnext();
	}else if (event.keyCode == '32') {
		if (($(".jp-play").is(":visible"))) {
			$(".jp-play").click();
		}else {
			$(".jp-pause").click();
		}
		return false;

	}
}