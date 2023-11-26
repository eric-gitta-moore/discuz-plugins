function randomInteger(low, high)
{
    return low + Math.floor(Math.random() * (high - low));
}

function dark(name){
       $("#"+name+"").animate({opacity:'0.2'},randomInteger(2000,3000),function(){light(name)});
}
function light(name){
    $("#"+name+"").animate({opacity:'1'},randomInteger(1000,2000),function(){dark(name)});
}

function star(){
	var num=10;
	for(var i=0;i<num;i++)
	{
		var posL=Math.random()*$('#stars').width()+'px';
		var posT=Math.random()*$('#stars').height()+'px';
		$('#stars').append("<img src='http://www.fx8.cc/hejin_hekas/4900/jinxingxing"+randomInteger(1,2)+".png' id='star"+i+"' style=\'"+"left:"+posL+";top:"+posT+"\'/>");
	}
	
	$("#stars img").each(function(){
		dark($(this).attr("id"));
	});
}