//ajax ѡ�
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

//tab plugins ���
$(function(){
	
	//ѡ���껬���¼�
	$('#brandtab .tabbtn li').mouseover(function(){
		TabSelect("#brandtab .tabbtn li", "#brandtab .tabcon", "current", $(this))
	});
	$('#brandtab .tabbtn li').eq(0).trigger("mouseover");
	
	//ѡ���껬���¼�
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
//tab plugins ���
$(function(){
	
	//ѡ���껬���¼�
	$('#statetab .tabbtn li').mouseover(function(){
		TabSelect("#statetab .tabbtn li", "#statetab .tabcon", "current", $(this))
	});
	$('#statetab .tabbtn li').eq(0).trigger("mouseover");
	
	//ѡ���껬���¼�
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
//��Ϊ��ҳ
function SetHome(url){ 
	if (document.all) { 
		document.body.style.behavior='url(#default#homepage)';
		document.body.setHomePage(url);
 	} else {
		alert("��Ϊ��ҳʧ�ܣ������ֶ�������������ø�ҳ��Ϊ��ҳ!");
		}
}
 
//�����ղ�
function AddFavorite(sURL, sTitle) {
	sURL = encodeURI(sURL); 
	try{   
		window.external.addFavorite(sURL, sTitle);    
      }catch(e) {   
			try{   
				window.sidebar.addPanel(sTitle, sURL, "");   
			}catch (e) {   
					alert("�����ղ�ʧ�ܣ���ʹ��Ctrl+D�������,���ֶ����������������á�");
					}   
		}
}