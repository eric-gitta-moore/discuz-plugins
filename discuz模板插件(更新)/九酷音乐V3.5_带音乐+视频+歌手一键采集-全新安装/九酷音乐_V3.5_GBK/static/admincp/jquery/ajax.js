function createXMLHttpRequest(){
       	if (window.XMLHttpRequest) {
		XMLHttpReq=new XMLHttpRequest();
	}
	else if (window.ActiveXObject) {
	    try {
	        XMLHttpReq=new ActiveXObject("Msxml2.XMLHTTP");
	    } catch (e) {
	        try{
		    XMLHttpReq=new ActiveXObject("Micrsost.XMLHTTP");
		} catch(e){}
	    }
	}
}
function ShowStar(level, ids){
	var htmlStr="";
	if(level==0){level=0;}
	if (level>0){htmlStr+="<img src='static/admincp/images/star_del.png' border='0' style='cursor:pointer;margin-left:2px;' title='取消推荐' onclick='EditIsBest("+ids+", 0)' />";}
	for(i=1;i<=level;i++){
		htmlStr+= "<img src='static/admincp/images/star_yes.gif' border='0' style='cursor:pointer;margin-left:2px;' title='推荐为"+i+"星级' id='star"+ids+"_"+i+"' onclick='EditIsBest("+ids+", "+i+")' />";
	}
	for(j=level+1;j<=5;j++){
		htmlStr+= "<img src='static/admincp/images/star_no.gif' border='0' style='cursor:pointer;margin-left:2px;' title='推荐为"+j+"星级' id='star"+ids+"_"+j+"' onclick='EditIsBest("+ids+", "+j+")' />";
	}
        document.getElementById("CD_IsBest"+ids).innerHTML = htmlStr;
}
function EditIsBest(_id, _l){
	 createXMLHttpRequest();
	 XMLHttpReq.open("GET", "?iframe=ajax&action=editisbest&id="+_id+"&l="+_l, true);
	 XMLHttpReq.onreadystatechange= function(){
		if(XMLHttpReq.readyState == 4){
			if(XMLHttpReq.status == 200){
				if(XMLHttpReq.responseText==1){
					if(_l>0){
					        asyncbox.tips("推荐为"+_l+"星级", "success", 1000);
					}else{
					        asyncbox.tips("取消推荐", "success", 1000);
					}
					ShowStar(_l, _id);
				}else{
					document.getElementById("CD_IsBest"+_id).innerHTML = "提交失败！";
				}
			}else{
					asyncbox.tips("网络异常，请检查网络连接！", "error", 1000);
			}
		}
	}
	XMLHttpReq.send(null);
}