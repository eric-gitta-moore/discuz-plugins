//ajax 选项卡
$('#ajaxtab .tabbtn li a').click(function(){
	var thiscity = $(this).attr("href");
	$("#ajaxtab .loading").ajaxStart(function(){
		$(this).show();
	}); 
	$("#ajaxtab .loading").ajaxStop(function(){
		$(this).hide();
	}); 
	$('#ajaxtab .tabcon').load(thiscity);
	$('#ajaxtab .tabbtn li a').parents().removeClass("current");
	$(this).parents().addClass("current");
	return false;
});
$('#ajaxtab .tabbtn li a').eq(0).trigger("click");

//tab plugins 插件
$(function(){
	
	//选项卡鼠标滑过事件
	$('#brandtab .tabbtn li').mouseover(function(){
		TabSelect("#brandtab .tabbtn li", "#brandtab .tabcon", "current", $(this))
	});
	$('#brandtab .tabbtn li').eq(0).trigger("mouseover");
	
	//选项卡鼠标滑过事件
	$('#clicktab .tabbtn li').click(function(){
		TabSelect("#clicktab .tabbtn li", "#clicktab .tabcon", "current", $(this))
	});
	$('#clicktab .tabbtn li').eq(0).trigger("click");

	function TabSelect(tab,con,addClass,obj){
		var $_self = obj;
		var $_nav = $(tab);
		$_nav.removeClass(addClass),
		$_self.addClass(addClass);
		var $_index = $_nav.index($_self);
		var $_con = $(con);
		$_con.hide(),
		$_con.eq($_index).show();
	}
	
});
//tab plugins 插件
$(function(){
	
	//选项卡鼠标滑过事件
	$('#statetab .tabbtn li').mouseover(function(){
		TabSelect("#statetab .tabbtn li", "#statetab .tabcon", "current", $(this))
	});
	$('#statetab .tabbtn li').eq(0).trigger("mouseover");
	
	//选项卡鼠标滑过事件
	$('#clicktab .tabbtn li').click(function(){
		TabSelect("#clicktab .tabbtn li", "#clicktab .tabcon", "current", $(this))
	});
	$('#clicktab .tabbtn li').eq(0).trigger("click");

	function TabSelect(tab,con,addClass,obj){
		var $_self = obj;
		var $_nav = $(tab);
		$_nav.removeClass(addClass),
		$_self.addClass(addClass);
		var $_index = $_nav.index($_self);
		var $_con = $(con);
		$_con.hide(),
		$_con.eq($_index).show();
	}
	
});
//设为首页
function SetHome(url){ 
	if (document.all) { 
		document.body.style.behavior='url(#default#homepage)';
		document.body.setHomePage(url);
 	} else {
		alert("设为首页失败，请您手动在浏览器里设置该页面为首页!");
		}
}
 
//加入收藏
function AddFavorite(sURL, sTitle) {
	sURL = encodeURI(sURL); 
	try{   
		window.external.addFavorite(sURL, sTitle);    
      }catch(e) {   
			try{   
				window.sidebar.addPanel(sTitle, sURL, "");   
			}catch (e) {   
					alert("加入收藏失败，请使用Ctrl+D进行添加,或手动在浏览器里进行设置。");
					}   
		}
}