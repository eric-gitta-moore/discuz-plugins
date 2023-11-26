function saveorder()
{
	if($('postform')) {
		ajaxpost('postform', 'return_error', 'return_error' , '', '',function(){srshowdialog();});
	}

}	
function kshowthis(id) {
	var obj = $('con'+id);
	if (obj) obj.style.display ='block';
}
function khidethis(id) {
	var obj = $('con'+id);
	if (obj) obj.style.display ='none';
}	
				
function showthis(id) {
   var obj =$('albumname'+id);
   if (obj) obj.style.display='block';
}
function hidethis(id) {
   var obj =$('albumname'+id);
   if (obj) obj.style.display='none';
}
function clickshow(id) {
   var obj =$('picture'+id);
   if (obj) obj.click();
}