

//copycontent('123123123123====12312http://asdfasd.asdfas.adfaf/asdfasdf?asdfasdf=asdfasdf&adfadsf=adf', 'ctrl-e-copyBtn-layer');
/*
 * copyCon: 要复制的内容
 * swfboxid: 复制按钮容器ID
 * width: 按钮宽
 * height:按钮高
 * btnimg:按钮图片
 */
function copycontent(copyCon, swfboxid, width, height, btnimg) {
	width = width >0 ? width : 52;
	height = height >0 ? height : 25;
	btnimg = btnimg ? btnimg : 'source/plugin/levimgfall/statics/copy/flash_copy_btn.png';
	var flashvars = {
	    content: encodeURIComponent(copyCon),
	    uri: btnimg
	};
	var params = {
	    wmode: "transparent",
	    allowScriptAccess: "always"
	};
	swfobject.embedSWF("clipboard.swf", swfboxid, width, height, "9.0.0", null, flashvars, params);
}
function copySuccess(){
    //flash回调
    alert("复制成功！");
}
