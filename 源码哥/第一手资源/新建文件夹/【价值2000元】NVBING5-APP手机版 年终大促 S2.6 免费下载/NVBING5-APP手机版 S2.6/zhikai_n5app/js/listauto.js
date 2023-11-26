




$(function() {
 $('.listbox').css({display: 'none'});
 $("#page_loading").css({display: 'block'});
	$("#thumbslist .listbox").css({ opacity: 1 });
    var $container = $('#thumbslist');
    $container.imagesLoaded(function(){
      $container.masonry({
        itemSelector : '.listbox',
      });
	  $('.listbox').show();
  });
  

var sentIt = true;
nextHref = $("#next_page a").attr("href");
$(window).bind("scroll",function(){
    if( $(document).scrollTop() + $(window).height() > $(document).height() - 50  && sentIt ) {
        if( nextHref != undefined ) {
            $("#page_loading").show("slow");
            $.ajax( {
                url: $("#next_page a").attr("href"),
                type: "GET",
                beforeSend: function(){sentIt = false; },
                success: function(data) {
                    result = $(data).find("#thumbslist .listbox");
                    nextHref = $(data).find("#next_page a").attr("href");
                    $("#next_page a").attr("href", nextHref);
                    $("#thumbslist").append(result);
                    $newElems = result.css({ opacity: 0 });
                    $newElems.imagesLoaded(function(){
                        $container.masonry( 'appended', $newElems, true );
                        $newElems.animate({ opacity: 1 });
						$("#stopfetch").show("slow");	
                    });
  
                },
        complete: function(){setTimeout(sentIt = true, 600); }
            });
        } else {
			$("#page_loading").addClass("nobg");
			$("#page_loading span").text("亲，木有了！");
			$("#page_loading").show("fast");
			setTimeout("$('#page_loading').hide()",2000);
			setTimeout("$('#page_loading').remove()",2200);
        }
    }
});
});
