//jQuery.noConflict();
function showmanage(show){
	if (!$('managebar')) return;
	if (show==1) {
		if (document.getElementById('managebar').style.display=='none') {
			document.getElementById('managebar').style.display='block';
		} else {
			document.getElementById('managebar').style.display='none';
		}
	} else {
		document.getElementById('managebar').style.display='none';
	}
}