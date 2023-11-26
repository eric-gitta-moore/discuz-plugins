function setthis(obj) {
	obj.value="";
	obj.style.color='#000000';
}
function favoriteupdate() {
	var obj = $('favoritenumber'+stid);
	if (obj)obj.innerHTML = parseInt(obj.innerHTML) + 1;
}
function shareupdate() {
	var obj = $('sharenumber'+stid);
	if (obj) obj.innerHTML = parseInt(obj.innerHTML) + 1;
}
