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