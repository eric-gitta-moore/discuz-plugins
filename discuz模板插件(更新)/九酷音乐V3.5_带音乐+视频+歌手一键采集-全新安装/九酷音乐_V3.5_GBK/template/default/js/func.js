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
  show=false;
	$(".dongBox").hover(function(){
	  var top=getTop(this)+30
	  var left=getLeft(this)
	  $(".dong03").show().css({"position":"absolute","left":left,"top":top+35})
	  show=true;
	  },function(){
      show=false;
      setTimeout("newMenuHide()",500);
      })
$(".dong03").hover(function(){
	 show=true;
	 },function(){
	show=false;newMenuHide();
 })
});
function newMenuHide(){
	if(show==false){
	$(".dong03").hide();
	}
}