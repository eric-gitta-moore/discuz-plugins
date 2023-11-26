//封装的公用选项卡
function clickTabs(tabTit,on,tabCon){
     $(tabTit).children().click(function(){
       $(this).addClass(on).siblings().removeClass(on);
       var index = $(tabTit).children().index(this);
     $(tabCon).children().eq(index).show().siblings().hide();
     });
     }
$(function(){ clickTabs(".clickTab-hd", "current", ".clickTab-bd");});		
//返回顶部
(function($){
	var goToTopTime;
	$.fn.goToTop=function(options){
		var opts = $.extend({},$.fn.goToTop.def,options);
		var $window=$(window);
		$body = (window.opera) ? (document.compatMode == "CSS1Compat" ? $('html') : $('body')) : $('html,body'); // opera fix
		//$(this).hide();
		var $this=$(this);
		clearTimeout(goToTopTime);
		goToTopTime=setTimeout(function(){
			var controlLeft;
			if ($window.width() > opts.pageHeightJg * 2 + opts.pageWidth) {
				controlLeft = ($window.width() - opts.pageWidth) / 2 + opts.pageWidth + opts.pageWidthJg;
			}else{
				controlLeft = $window.width()- opts.pageWidthJg-$this.width();
			}
			var cssfixedsupport=$.browser.msie && parseFloat($.browser.version) < 7;//判断是否ie6
			var controlTop=$window.height() - $this.height()-opts.pageHeightJg;
			controlTop=cssfixedsupport ? $window.scrollTop() + controlTop : controlTop;
			var shouldvisible=( $window.scrollTop() >= opts.startline )? true : false;
			
			if (shouldvisible){
				$this.stop().show();
			}else{
				$this.stop().hide();
			}
			
			$this.css({
				position: cssfixedsupport ? 'absolute' : 'fixed',
				top: controlTop,
				left: controlLeft
			});
		},30);
		
		$(this).click(function(event){
			$body.stop().animate( { scrollTop: $(opts.targetObg).offset().top}, opts.duration);
			$(this).blur();
			event.preventDefault();
			event.stopPropagation();
		});
	};
	
	$.fn.goToTop.def={
		pageWidth:960,//页面宽度
		pageWidthJg:5,//按钮和页面的间隔距离
		pageHeightJg:120,//按钮和页面底部的间隔距离
		startline:30,//出现回到顶部按钮的滚动条scrollTop距离
		duration:200,//回到顶部的速度时间
		targetObg:"body"//目标位置
	};
})(jQuery);
$(function(){
	$('<a href="javascript:;" class="backToTop"></a>').appendTo("body");
});
$(function(){
	$(".backToTop").goToTop({});
	$(window).bind('scroll resize',function(){
		$(".backToTop").goToTop({});
	});
});
$(function(){
 $(".top-user li.down-menu").hover(function () { $(this).toggleClass("hover"); })
});
$(function(){
 $(".setPlayXuan").live("click",function (){
		var $clThis=$(this);
		$(".setPlayXuan").not($clThis).removeClass("setPlayXuanCur");
		$clThis.toggleClass("setPlayXuanCur");
		})
});

function getTop(e){
	var offset=e.offsetTop;
	if(e.offsetParent!=null) offset+=getTop(e.offsetParent);
	return offset;
}
function getLeft(e2) {
	if (e2.offsetParent)
		return (e2.offsetLeft + getLeft(e2.offsetParent));
	else 
		return (e2.offsetLeft);
}

$(function(){
	showHis=false;
	var loagList=1;
	var hiscl=0;
$(".historyHd").each(function(){
	 $(this).hover(function(){
	  var top=getTop(this)+35
	  var left=getLeft(this)
			if(loagList==1){
				showHisList(hisCurPage);
				loagList=2;
			}
	  $(".historyBd").show().css({"position":"absolute","left":left,"top":top})
	  showHis=true;
	  },function(){
      showHis=false;
      hiscl=setTimeout("newMenuHide()",200);
						$(".historyBox").removeClass("hover");
      })
   })
$(".historyBd").hover(function(){
	 showHis=true;
		$(".historyBox").addClass("hover");
	 },function(){
	 showHis=false;
		newMenuHide();
		clearTimeout(hiscl);
 })
});

function newMenuHide(){
	if(showHis==false){
	$(".historyBd").hide();
	$(".historyBox").removeClass("hover");
	}
}

var hisCurPage=1,hisIsLoaded=0;
function getHisId(){
	var returnid="";
	var str=document.cookie;
	var num_start=str.indexOf("l_music");
	if(num_start!=-1){
		var num_end=str.indexOf("l_end");
		if(num_end>num_start){
			var str_list=str.substring(num_start,num_end).replace(/l_music=/ig,"");
			var arr_list=str_list.split(",");
			if(arr_list.length>0){
				for(i=0;i<arr_list.length;i++){
					var str_ti=arr_list[i];
					if(str_ti!=undefined||str_ti!="undefined"||str_ti!=null||str_ti!=""){
						returnid=returnid+str_ti+","
					}
				}
			}
		}
	}
	return returnid;
}

function showHisList(page){
	if(hisIsLoaded==1&&hisCurPage==page)return;
	hisCurPage=page;
	var hidstr=getHisId();
	if(hidstr==",,")hidstr="";
}

function GetCookie(name){var arr=document.cookie.match(new RegExp("(^| )"+name+"=([^;]*)(;|$)"));if(arr!=null){return unescape(arr[2]);}return null;}

function clk(type,id){
	var newx="",firstid="";
	var ok=false;
	var lens=eval("document.form.Url").length;
	if(lens==undefined){lens=1}
	if(lens>1){
		for (var i=0;i<lens;i++) 
		{
	
		var temp=eval("document.form.Url["+i+"]");
			if(temp.checked){
				if(temp.value.replace("@","")!=""&&temp.value.replace("@","")!="0"){
					if(firstid=="")firstid=temp.value.replace("@","");
					newx=newx+temp.value.replace("@","")+",";
					ok=true;
				}
			}
		}
	}else{
		ok=true;
		if(document.form.Url.value.replace("@","")!=""&&document.form.Url.value.replace("@","")!="0"){
			newx=document.form.Url.value.replace("@","")+",";
		}
	}
	if(ok){
		Addplay(newx);
	}else{
		asyncbox.tips("请先选择要加入列表的歌曲！", "wait", 1000);
	}
}