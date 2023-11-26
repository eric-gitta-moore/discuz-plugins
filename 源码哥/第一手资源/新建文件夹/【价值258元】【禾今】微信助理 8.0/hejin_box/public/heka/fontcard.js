

function obj(objid)
{
    return document.getElementById(objid)
}

function onMoveEnd()
{
    win_height = obj("textsuper").offsetHeight;
    
    var item = obj("textsub");
    item.style.webkitTransition = "";
    item.style.top = "" + win_height + "px";
    moveUp();
}

function moveUp()
{
    var win_height = obj("textsuper").offsetHeight;
    var img_h = obj("fontimg").height;
    var t_use = (img_h+win_height)/g_speed;
    var item  = obj("textsub");
    item.style.webkitTransition = "top " + t_use + "s linear";
    item.style.top = "-" + img_h + "px";
}

function onTextLoad()
{
    obj("textsuper").style.top = g_text_y;
    obj("textsuper").style.left = g_text_x;
    obj("textsuper").style.width = g_text_w;
    obj("textsuper").style.height = g_text_h;
    win_height = obj("textsuper").offsetHeight;
    var item = obj("textsub");
    item.style.top = "" + win_height + "px";
    obj("textsub").addEventListener("webkitTransitionEnd", onMoveEnd, false)
    moveUp();
}

function loadFontImg()
{
    if(typeof(g_words) == "undefined" || g_words == "")
    {
        return;
    }
    
	host = "aliyun7.kagirl.cn:8000";
	
	if(typeof(font_svr_ip) != "undefined")
	{
		host = font_svr_ip;
	}
	
    var url = "http://" + host + "/fontimg?words=" + encodeURIComponent(g_words) + "&fontname=" + g_font_name + "&fontsize=" + g_font_size + "&gap=" + g_gap + "&width=" + g_width_c + "&date=" + g_date + "&color=" + g_color;

    obj("fontimg").style.top = 2000;
	obj("fontimg").style.left = 0;
    obj("fontimg").onload = onTextLoad;
    obj("fontimg").src = url;
}