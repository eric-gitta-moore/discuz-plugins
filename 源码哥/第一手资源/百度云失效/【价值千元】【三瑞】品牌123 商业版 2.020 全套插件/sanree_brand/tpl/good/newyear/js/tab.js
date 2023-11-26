function setthis(obj) {
	obj.value="";
	obj.style.color='#000000';
}

var $a = jQuery.noConflict();

$a(function(){
	
	$a('#brandtab .tabbtn li').mouseover(function(){
		TabSelect("#brandtab .tabbtn li", "#brandtab .tabcon", "current", $a(this))
	});
	$a('#brandtab .tabbtn li').eq(0).trigger("mouseover");

	$a('#statetab .tabbtn li').mouseover(function(){
		TabSelect("#statetab .tabbtn li", "#statetab .tabcon", "current", $a(this))
	});
	$a('#statetab .tabbtn li').eq(0).trigger("mouseover");
	
	function TabSelect(tab,con,addClass,obj){
		var $_self = obj;
		var $_nav = $a(tab);
		$_nav.removeClass(addClass),
		$_self.addClass(addClass);
		var $_index = $_nav.index($_self);
		var $_con = $a(con);
		$_con.hide(),
		$_con.eq($_index).show();
	}
	
});

function SetHome(url){ 
	if (document.all) { 
		document.body.style.behavior='url(#default#homepage)';
		document.body.setHomePage(url);
 	} 
}
 
function AddFavorite(sURL, sTitle) {
	sURL = encodeURI(sURL); 
	try{   
		window.external.addFavorite(sURL, sTitle);    
      }catch(e) {   
			try{   
				window.sidebar.addPanel(sTitle, sURL, "");   
			}catch (e) {}   
		}
}