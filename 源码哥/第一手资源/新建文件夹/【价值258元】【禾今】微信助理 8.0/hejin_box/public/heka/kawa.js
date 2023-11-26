note_id = 0;
win_height = 0;
music_player = new Audio();
pop_up_note_mode = true;

text_prepared = false;
font_img = null;




function add_keyframes(name, cssbody)
{
    csstext = '@-webkit-keyframes ' + name + '{' + cssbody + '}';

    style = document.createElement('style');
    document.head.appendChild(style);
    sheet = style.sheet;
    sheet.insertRule(csstext, 0);
}

function create_imgdiv(url, idname, visible, x, y)
{
    imgdiv = document.createElement('div');
}

function objid(idname)
{
    return document.getElementById(idname);
}

function _kv(value)
{
    if(typeof(value) == 'undefined')
    {
        return false;
    }

    if(value == '')
    {
        return false;
    }

    if(value.charAt(0) == '#')
    {
        return false;
    }

    return true;
}

function _v(keyname)
{
    if(typeof(kawa_data[keyname]) == 'undefined')
    {
        return '';
    }

    return kawa_data[keyname];
}

// ---------------------------------------------------------------------
// text

function kawa_init_async()
{
    read_base();
    create_textdiv();
   // add_kawa_icon();
    create_music();
    //create_modify();
   // zk_create_modify();

}

function kawa_init()
{
    document.body.style.margin = '0px';
    create_base();
    setTimeout("kawa_init_async()", 100);
 }

function is_show_words()
{
    if(typeof(kawa_data.show_words) == 'undefined')
    {
        return true;
    }

    if(kawa_data.show_words != 'no')
    {
        return true;
    }

    return false;
}

function read_base()
{
    win_height = objid('basepoint').offsetTop;
}

function create_base()
{
    div = document.createElement('div');
    div.style.position = 'fixed';
    div.style.bottom = '0px';
    div.style.width = '1px';
    div.style.height = '1px';
    div.style.left = '-100px';
    div.id = 'basepoint';
    document.body.appendChild(div);
}

function make_text_animation()
{
    //if(!is_show_words())
    //    return;

    var mask = objid('textmask');
    var textdiv = objid('textdiv');

    if(kawa_data.mode == 'up')
    {
        var keycss = 'from{-webkit-transform:translate(0px, ' + mask.offsetHeight + 'px);}' +
                 'to{-webkit-transform:translate(0px, -' + textdiv.offsetHeight + 'px);}' 

        add_keyframes('textdivani', keycss);

        var dt = (mask.offsetHeight + textdiv.offsetHeight) / kawa_data.speed;

        textdiv.style.webkitAnimation = 'textdivani ' + dt + 's linear infinite';
    }
    else if(kawa_data.mode == 'left')
    {
        var keycss = 'from{-webkit-transform:translate(' + mask.offsetWidth + 'px, 0px);}' +
                 'to{-webkit-transform:translate(-' + textdiv.offsetWidth + 'px, 0px);}' 

        add_keyframes('textdivani', keycss);

        var dt = (mask.offsetWidth + textdiv.offsetWidth) / kawa_data.speed;

        textdiv.style.webkitAnimation = 'textdivani ' + dt + 's linear infinite';
    }
    else if (kawa_data.mode == 'print')
    {
        onPrint();
        setTimeout("onPrintAni()", 1500);
    }
    else if (kawa_data.mode == 'alldisplay')
    {
        objid('textdiv').style.top = objid('textmask').offsetHeight;
        var keycss = 'from{opacity:0;}' +
                 'to{opacity:1;}' 

        add_keyframes('textdivani', keycss);
        textdiv.style.webkitAnimation = 'textdivani '+kawa_data.speed+'s linear forwards';

    }
}
function onPrint()
{
    objid('textdiv').style.top = objid('textmask').offsetHeight;
    gPrText          = card_text();
    gOrgCardText       = card_text();

}

function onPrintAni()
{
    pushText = '';
    
    var reachEnd = 0;
    
    if(gPrText.length <1)
    {
        reachEnd = 1;
    }
    
    var cutlen = 0;

    if(gPrText.length >= 4 && gPrText.substring(0, 4) == '<br>')
    {
        gPrText  = gPrText .substring(4);
        pushText = '<br>';
        cutlen = 4;
    }
    else if(gPrText.substring(0, 2) == '/:')
    {
        result = ConvFaceOnBegin(gPrText );
        cutlen = result[1];
        if(cutlen > 0)
        {
            gPrText  = gPrText .substring(cutlen);
            pushText = result[0];
        }
    }
    
    if(cutlen == 0 && gPrText.length >= 1)
    {
        pushText   = gPrText.substring(0, 1);
        gPrText  = gPrText.substring(1);
    }

    objid('textdiv').innerHTML = objid('textdiv').innerHTML + pushText;
    //alert(objid('textmask').offsetHeight);
    if((objid('textdiv').offsetTop + objid('textdiv').offsetHeight)> objid('textmask').offsetHeight)
    {
        trans = objid('textmask').offsetHeight - objid('textdiv').offsetHeight;
        objid('textdiv').style.top = trans+ 'px';
        //alert(objid('textdiv').style.top);
    }

    if(reachEnd == 1)
    {
        //setTimeout("", 2000); 
        
        setTimeout("pauseShow()",2000);
        
    }
    else
    {
        var gSpeed = kawa_data.speed;
        setTimeout("onPrintAni()", gSpeed);
    }
}
function pauseShow()
{
    reachEnd=0;
    trans = 0;
    objid('textdiv').style.top =trans+'px';
    gPrText              = gOrgCardText;
    objid('textdiv').innerHTML = "";
    setTimeout("onPrintAni()",1000);
}
function show_textdiv()
{
        var box = kawa_data.text_box.split(' ');

        var mask = document.createElement('div');
        mask.id = 'textmask';
        mask.style.position = 'absolute';
        mask.style.left     = box[0] + 'px';
        mask.style.top      = box[1] + 'px';
        mask.style.width    = box[2] + 'px';
        mask.style.height   = box[3] + 'px';
        mask.style.overflow = 'hidden';

        var textdiv = document.createElement('div');
        textdiv.id = 'textdiv';
        textdiv.style.position = 'absolute';
        textdiv.style.color = kawa_data.text_color;
        textdiv.style.fontSize  = kawa_data.font_size;
        
        textdiv.style.lineHeight = kawa_data.line_height;
        textdiv.style.fontWeight = '600';       
        textdiv.style.fontFamily = 'Microsoft YaHei';

        textdiv.style.zIndex = 50000;

        if(_kv(kawa_data.text_align))
        {
            textdiv.style.textAlign = kawa_data.text_align;
        }

        if(_kv(kawa_data.font_weight))
        {
            textdiv.style.fontWeight = kawa_data.font_weight;
        }

        if(kawa_data.mode == 'left')
        {
            textdiv.style.float = 'left';
        }

        document.body.appendChild(mask);    
        mask.appendChild(textdiv);

        set_up_words();
}

function create_textdiv()
{
    if(is_show_words())
    {
        show_textdiv();
    }
}

function set_up_words()
{
    if(_kv(kawa_data.font_family))
    {
        var text = pure_card_text();

        if(kawa_data.mode == 'up')
        {
            text = wrap_text(text);
        }
        if(kawa_data.mode == 'alldisplay')
        {
            text = wrap_text_cut(text);
            textdiv.style.height= textmask.style.height;
            textdiv.style.width= textmask.style.width;
        }
        var font_ip = 'aliyun7.kagirl.cn:8000';

        if(_kv(kawa_data.font_ip))
        {
            font_ip = kawa_data.font_ip;
        }

        var re_d = /^\d+/;
        var font_size = parseFloat(re_d.exec(kawa_data.font_size)[0]);
        var line_height = parseFloat(re_d.exec(kawa_data.line_height)[0]);
        var gap = line_height - font_size;

        var box = kawa_data.text_box.split(' ');

        var color = kawa_data.text_color.substring(1);

        var url = "http://" + font_ip + "/fontimg?words=" + encodeURIComponent(text) + "&fontname=" + 
            kawa_data.font_family + "&fontsize=" + font_size + "&gap=" + gap + "&width=" + box[2] + 
            "&color=" + color;

        font_img = document.createElement('Img');
        font_img.onload = on_font_img_load;
        font_img.src = url;
        setTimeout('on_check_font_img()', 1000);
    }
    else
    {
        textdiv = objid('textdiv');
        if (kawa_data.mode=='print')
            textdiv.innerHTML = '';
        else
            textdiv.innerHTML = card_text();
        make_text_animation();
    }
}

function on_font_img_load()
{
    if(!text_prepared)
    {
        text_prepared = true;
        var textdiv = objid('textdiv');
        textdiv.appendChild(font_img);
        make_text_animation();
    }
}

function on_check_font_img()
{
    if(!text_prepared)
    {
        var textdiv = objid('textdiv');
        text_prepared = true;
        var fontSize = parseInt(textdiv.style.fontSize);
        var lineHeight = parseInt(textdiv.style.lineHeight);
        textdiv.style.fontSize = fontSize*2/3 + textdiv.style.fontSize.substring(textdiv.style.fontSize.length-2,textdiv.style.fontSize.length);
        textdiv.style.lineHeight = lineHeight*2/3 + textdiv.style.lineHeight.substring(textdiv.style.lineHeight.length-2,textdiv.style.lineHeight.length);
        textdiv.innerHTML = card_text();
        make_text_animation();
    }
}

function pure_card_text()
{
    text = kawa_data.words;

    if(kawa_data.replace_words != '#replace_words#')
    {
        text = kawa_data.replace_words;
    }

    return text;
}

function card_text()
{
    text = pure_card_text();

    if((kawa_data.mode == 'up')||(kawa_data.mode == 'print')||(kawa_data.mode =='alldisplay'))
    {
        text = wrap_text(text);
    }
    else if(kawa_data.mode == 'left')
    {
        text = '<nobr>' + text + '</nobr>';
    }

    return text;
}

function wrap_text(in_text)
{
    text = in_text.replace(/,/g, ',<br>');
    text = text.replace(/，/g, '，<br>');
    text = text.replace(/\./g, '.<br>');
    text = text.replace(/。/g, '。<br>');
    text = text.replace(/;/g, ';<br>');
    text = text.replace(/；/g, '；<br>');
    text = text.replace(/!/g, '!<br>');
    text = text.replace(/！/g, '！<br>');
    text = text.replace(/～/g, '～<br>');
    text = text.replace(/：/g, '：<br>');
    text = text.replace(/:/g, ':<br>');    
    text = text.replace(/？/g, '：<br>');
    text = text.replace(/\?/g, ':<br>');
    return text;
}
function wrap_text_cut(in_text)
{
    var text = wrap_text(in_text);
    arr_word = new Array();
    arr_word=text.split('<br>');
    var row=0;
    hangshu=arr_word.length;
    console.log(hangshu);
    myarr=new Array();
    var box = kawa_data.text_box.split(' ');
    var bound = Math.floor(box[2]/parseInt(kawa_data.font_size));
    for(var i=0;i<hangshu;i++)
    {
        if(arr_word[i].length>bound)
        {
            for(var k=0;k<Math.ceil((arr_word[i].length)/bound);k++)
            {
                if(k==Math.floor(arr_word[i].length/bound))
                    myarr[row]=arr_word[i].substring(k*bound);
                else
                    myarr[row]=arr_word[i].substring(k*bound,(k+1)*bound);
                row++;
            }
        }
        else
        {
            myarr[row]=arr_word[i];
            row++;
        }
    }
    mywords="";
    mywords=myarr.join('<br>');
    return mywords;
}
// ---------------------------------------------------------------------
// kawa icon



// ---------------------------------------------------------------------
// kawa music

var bplay = 0;              //记录是否要播放音乐
function switchsound()
{
    au = music_player
    ai = objid('sound_image');
    if(au.paused)
    {
        bplay = 1;
        au.play();
        ai.src = "http://img03.taobaocdn.com/imgextra/i3/755119556/TB2JLRdbFXXXXaWXpXXXXXXXXXX_!!755119556.png";
        pop_up_note_mode = true;
        popup_note();
        objid("music_txt").innerHTML = "&#x6253;&#x5F00;";
        objid("music_txt").style.visibility = "visible";
        setTimeout(function(){objid("music_txt").style.visibility="hidden"}, 2500);
    }
    else
    {
        bplay = 0;
        pop_up_note_mode = false;
        au.pause();
        ai.src = "http://img03.taobaocdn.com/imgextra/i3/755119556/TB2JLRdbFXXXXaWXpXXXXXXXXXX_!!755119556.png";
        objid("music_txt").innerHTML = "&#x5173;&#x95ED;";
        objid("music_txt").style.visibility = "visible";
        setTimeout(function(){objid("music_txt").style.visibility="hidden"}, 2500);
    }
}

function play_music()
{
    if(typeof(kawa_data) != 'undefined')
    {
        music = kawa_data.music;

        if(kawa_data.replace_music != '#replace_music#')
        {
            music = kawa_data.replace_music;
        }

        music_player.src = music;
        music_player.loop = 'loop';
        music_player.play();
        bplay = 1;
    }
}

function create_music()
{
    play_music();

    sound_div = document.createElement("div");
    sound_div.setAttribute("ID", "cardsound");
    sound_div.style.cssText = "position:fixed;right:20px;top:25px;z-index:50000;visibility:visible;";
    sound_div.onclick = switchsound;
    bg_htm = "<img id='sound_image' src='http://img03.taobaocdn.com/imgextra/i3/755119556/TB2JLRdbFXXXXaWXpXXXXXXXXXX_!!755119556.png'>";
    box_htm = "<div id='note_box' style='height:100px;width:44px;position:absolute;left:0px;top:-80px'></div>";
    txt_htm = "<div id='music_txt' style='color:white;position:absolute;left:-40px;top:30px;width:60px'></div>"
    sound_div.innerHTML = bg_htm + box_htm + txt_htm;
    document.body.appendChild(sound_div);

    setTimeout("popup_note()", 100);
}   
function on_pop_note_end(event)
{
    note = event.target;
    
    if(note.parentNode == objid("note_box"))
    {
        objid("note_box").removeChild(note);
    }
}

function popup_note()
{
    box = objid("note_box");
    
    note = document.createElement("span");
    note.style.cssText = "visibility:visible;position:absolute;background-image:url('http://img02.taobaocdn.com/imgextra/i2/755119556/TB2uCJfbFXXXXXEXpXXXXXXXXXX_!!755119556.png');width:15px;height:25px";
    note.style.left = Math.random() * 20 + 20;
    note.style.top = "75px";
    this_node = "music_note_" + note_id;
    note.setAttribute("ID", this_node);
    note_id += 1;
    scale = Math.random() * 0.4 + 0.4;
    note.style.webkitTransform = "rotate(" + Math.floor(360 * Math.random()) + "deg) scale(" + scale + "," + scale + ")";
    note.style.webkitTransition = "top 2s ease-in, opacity 2s ease-in, left 2s ease-in";
    note.addEventListener("webkitTransitionEnd", on_pop_note_end);
    box.appendChild(note);

    setTimeout("document.getElementById('" + this_node + "').style.left = '0px';", 100);
    setTimeout("document.getElementById('" + this_node + "').style.top = '0px';", 100);
    setTimeout("document.getElementById('" + this_node + "').style.opacity = '0';", 100);
    
    if(pop_up_note_mode)
    {
        setTimeout("popup_note()", 600);
    }   
}

// ---------------------------------------------------------------------
// weixin


function share_url()
{
            return kawa_data.share_url;

}

function share_data()
{
var desc = '';

    if(_v('user_desc') != '')
    {
        desc = _v('user_desc');
    }
    else
    {
        desc = kawa_data.desc;

        if(kawa_data.replace_words != '#replace_words#')
        {
            desc = kawa_data.replace_words;
        }        
    }


    return{
        'img_url'    : kawa_data.icon,
        'img_width'  : '640',
        'img_height' : '640',
        'link'       : share_url(),
        'desc'       : desc,
        'title'      : kawa_data.title
    }
}

function share_data_timeline()
{
	var desc = '';

    if(_v('user_desc') != '')
    {
        desc = _v('user_desc');
    }
    else
    {
	    desc = kawa_data.desc;
	    if(kawa_data.replace_words != '#replace_words#')
	    {
	        desc = kawa_data.replace_words;	    
		}
    }

    return{
        'img_url'    : kawa_data.icon,
        'img_width'  : '640',
        'img_height' : '640',
        'link'       : share_url(),
        'desc'       : desc,
        'title'      : desc
    }
}

function on_weixin_reply(res)
{
}

function on_weixin_ready()
{
    play_music();

    WeixinJSBridge.on('menu:share:appmessage', function(argv){
        WeixinJSBridge.invoke('sendAppMessage', share_data(), on_weixin_reply);
    });

    WeixinJSBridge.on('menu:share:timeline', function(argv){
        WeixinJSBridge.invoke('shareTimeline', share_data_timeline(), on_weixin_reply);
    });
}

document.addEventListener('WeixinJSBridgeReady', on_weixin_ready, false);

// ---------------------------------------------------------------------
// modify


function create_modify()
{
    zk_create_modify();
}
function initViewport()
{
    if(/Android (\d+\.\d+)/.test(navigator.userAgent))
    {
        var version = parseFloat(RegExp.$1);

        if(version>2.3)
        {
            var phoneScale = parseInt(window.screen.width)/500;
            document.write('<meta name="viewport" content="width=500, minimum-scale = '+ phoneScale +', maximum-scale = '+ phoneScale +', target-densitydpi=device-dpi">');

        }
        else
        {
            document.write('<meta name="viewport" content="width=500, target-densitydpi=device-dpi">');    
        }
    }
    else if(navigator.userAgent.indexOf('iPhone') != -1)
    {
        var phoneScale = parseInt(window.screen.width)/500;
        document.write('<meta name="viewport" content="width=500, height=750,initial-scale=' + phoneScale +'" /> ');         //0.75   0.82
    }
    else 
    {
        //document.write('<meta name="viewport" content="width=500, user-scalable=no, target-densitydpi=device-dpi">');
        document.write('<meta name="viewport" content="width=500, height=750,initial-scale=0.64" /> ');         //0.75   0.82

    }
    document.write('<style>@-webkit-keyframes rotatemusic {from {-webkit-transform: rotate(0deg);}to { -webkit-transform: rotate(360deg);}}::-webkit-input-placeholder {color: #000;}</style>');
    
}



function createTBt()
{
    closeTBt();                  //保证只存在一个弹出窗口
    var div = document.createElement('div');
    var u = navigator.userAgent;
    var ios = (u.indexOf('iPad')>-1 || u.indexOf('iPhone') > -1) && u.match(/(i[^;]+\;(U;)? CPU.+Mac OS X)/);
    if(ios != false)
    {
        div.style.position = 'absolute';
        div.style.zIndex = '90002';
    }
    else
    {
        div.style.position = 'absolute';
        div.style.zIndex = '90002';
    }
    div.style.top = (win_height) + 'px';
    div.style.backgroundColor = 'white';
    div.style.width = '96%';
    div.style.left = '2%';
    div.style.height = '550px';                 //高度不能固定 。。-webkit-transition: top 0.2s ease-in;
    div.style.webkitTransition = '-webkit-transform 0.3s linear';
    div.id = 'wind';
    //div.style.borderRadius = "5px 5px 0px 0px";
    div.style.webkitBorderRadius = "10px 10px 0px 0px";
    document.body.appendChild(div);
}
function closeTBt()
{
    var TBwind = document.getElementById("wind");
	
    if(TBwind != null)
    {
        document.body.removeChild(TBwind);		
    }
    if(zkid('player'))
    {
        zkid('player').pause();
        if(music_player != null && bplay == 1)
        {
            music_player.play();
            pop_up_note_mode = true;
            popup_note();
        }
    }
    if(zkid('div_word'))
    { 
        zkid('div_word').style.backgroundColor = 'rgb(44,46,50)';
        zkid('div_music').style.backgroundColor = 'rgb(44,46,50)';
        zkid('div_weika').style.backgroundColor = 'rgb(44,46,50)';
        zkid('div_word_bottom').style.backgroundColor = 'rgb(44,46,50)';
        zkid('div_music_bottom').style.backgroundColor = 'rgb(44,46,50)';
        zkid('div_weika_bottom').style.backgroundColor = 'rgb(44,46,50)';
    }
    else if(zkid('word_image'))
    {
        zkid('word_image').src = 'http://img01.taobaocdn.com/imgextra/i1/755119556/TB2uHBmbFXXXXbGXXXXXXXXXXXX_!!755119556.png';
        zkid('weika_image').src = 'http://img04.taobaocdn.com/imgextra/i4/755119556/TB2UcXhbFXXXXcLXXXXXXXXXXXX_!!755119556.png';
    }
}
function wrap_input(in_text)
{
    text = in_text.replace(/\n+/g, '0519');
    return text;
}


function getQueryStr(str)
{   
    /*var rs = new RegExp("(^|)"+str+"=([^/&]*)(/&|$)","gi").exec(String(window.document.location.href)), tmp;   
   
    if(tmp=rs){   
        return tmp[2];   
    }   
   */
    var reg = new RegExp("(^|&)" + str + "=([^&]*)(&|$)", "i");
    var r = window.location.search.substr(1).match(reg);
    if (r != null) return unescape(r[2]);
    // parameter cannot be found   
    return "";   
}
function zk_buildmusic_card(index)
{
    music_player.src = mp3_list.url_header + mp3_list.mp3s[index].url;
    music_player.loop = 'loop';
    if(bplay==1)
    {
        music_player.play();
    }
    kawa_data.replace_music = mp3_list.url_header + mp3_list.mp3s[index].url;
    kawa_data.replace_music_name = mp3_list.mp3s[index].name;
	closexiala();
    closeTBt();
}
function wordchange()
{
    zkid('words').value = zkid('wordselect').value;
    //txtChange();
}
function zkid(idname)
{
    return document.getElementById(idname);
}

var xmlHttp;
function GetXmlHttpObject()
{
    var xmlHttp=null;
    try
    {
        // Firefox, Opera 8.0+, Safari
        xmlHttp=new XMLHttpRequest();
    }
    catch (e)
    {
        // Internet Explorer
        try
        {
            xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
        }
        catch (e)
        {
            xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
        }
    }
    return xmlHttp;
}
function wordStateChanged() 
{ 
    if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
    { 
        document.getElementById("wordselect").innerHTML='<option>&#x70B9;&#x8FD9;&#x91CC;&#x9009;&#x62E9;&#x795D;&#x798F;&#x8BED;</option>' + xmlHttp.responseText; 
    } 
}
function on_modifyword_click()
{

    createTBt();                  //创建容器

    if(zkid('div_word'))
    { 
        zkid('div_word').style.backgroundColor = 'rgb(27,28,32)';
        zkid('div_music').style.backgroundColor = 'rgb(44,46,50)';
        zkid('div_weika').style.backgroundColor = 'rgb(44,46,50)';
        zkid('div_word_bottom').style.backgroundColor = 'rgb(27,28,32)';
        zkid('div_music_bottom').style.backgroundColor = 'rgb(44,46,50)';
        zkid('div_weika_bottom').style.backgroundColor = 'rgb(44,46,50)';
    }
    var html_body = '';
    html_body += '<div style="position:relative; width:100%;background:rgb(100,86,86);height:70px;-webkit-border-radius:5px 5px 0px 0px;border-bottom:0px;"><div style="position:relative;float:left;left:10px;top:20px;height:40px;width:40px;background:url(\'http://img03.taobaocdn.com/imgextra/i3/755119556/TB2dDRebFXXXXakXpXXXXXXXXXX_!!755119556.png\') no-repeat scroll 0 -315px transparent "></div>';//<img style="padding-top:23px;padding-left:10px;float:left;" src="http://tu.kagirl.net/pic/tubiao/tubiao_8.png"/>
    html_body += '<div style="position:relative;float:left;color:white;font-size:18pt;height:75px;line-height:75px;left:10px;">&#x5199;&#x5361;&#x7247;&#x4E0A;&#x7684;&#x6EDA;&#x52A8;&#x6587;&#x5B57;</div>';
    html_body += '<div  onclick="closeTBt()" style="position:relative;float:right;height:75px;width:75px;"><div style="position:relative;float:right;right:15px;top:20px;height:40px;width:40px;background:url(\'http://img03.taobaocdn.com/imgextra/i3/755119556/TB2dDRebFXXXXakXpXXXXXXXXXX_!!755119556.png\') no-repeat scroll 0 -135px transparent "></div></div></div>';

    html_body += '<div style="width:90%;position:relative;top:20px;left:5%;height:315px;">';
    html_body += '<br><div style="width:100%;-webkit-border-radius: 7px;background-color:#e3e3e3">';
    html_body += '<textarea id="words" maxlength="350"  placeholder="&#x4F60;&#x60F3;&#x8BF4;&#x7684;&#x8BDD;..." rows=7 onblur="this.style.backgroundColor=\'rgba(227, 227, 227,1)\';" onfocus="this.style.backgroundColor=\'rgba(227, 227, 227, 1)\';" style="line-height:33px;width:100%;padding-left:10px;-webkit-background-clip: padding-box;background: rgba(227, 227, 227,1);-webkit-border-radius: 7px;font-size:18pt;resize:none;border:none;outline:none;"></textarea></div>';
    html_body += '<div id="word_num" style="position:relative;float:right;padding-top:5px">&#x9650;300&#x5B57;</div></div>';

    html_body += '<div onclick="zk_build_card()" style="position:relative;width:90%;left:5%;height:70px;background-color:rgb(255,102,0);-webkit-border-radius:7px 7px 10px 10px;">';
    html_body += '<div style="position:relative;float:left;color:white;font-size:20pt;font-weight:bold;height:70px;line-height:70px;padding-left:40%;">&#x786E;&nbsp;&nbsp;&nbsp;&nbsp;&#x5B9A;</div>';
   
    
    zkid('wind').innerHTML = html_body;
    //$('#wind').slideDown();
    //setTimeout("zkid('wind').style.top = '" +(win_height - 550) + "px'",100);
    setTimeout("zkid('wind').style.webkitTransform = 'translateY(-550px)'",100);
    xmlHttp=GetXmlHttpObject();
    if (xmlHttp==null)
    {
        alert ("Browser does not support HTTP Request");
        return;
    }
    var url="modify.php?type=word";
    url=url+"&cardid=" + kawa_data.cardid;
    url=url+"&optfile=" + kawa_data.modify_optfile;
    if(kawa_data.modify_optwords != '#modify_optwords#')
    {
        url = url + '&optwords=' + encodeURIComponent(kawa_data.modify_optwords);
    }

    if(typeof(kawa_data.write_param) != 'undefined' && kawa_data.write_param != '')
    {
        url = url + '&' + kawa_data.write_param;
    }
    xmlHttp.onreadystatechange=wordStateChanged; 
    xmlHttp.open("GET",url,true);
    xmlHttp.send(null);
}





function switchsound1()
{
    au = music_player;
	bplay = 1;
	au.play();
	objid("sound_image3").style.display = 'none';
	objid('sound_image2').style.webkitAnimation = 'rotatemusic 5s infinite linear';
}
function switchsound2()
{
    au = music_player;
    if(au.paused)
    {
        bplay = 1;
        au.play();
        objid("sound_image3").style.display = 'none';
        objid('sound_image2').style.webkitAnimation = 'rotatemusic 5s infinite linear';
    }
    else
    {
        au.pause();
        objid("sound_image3").style.display = 'block';
        objid('sound_image2').style.webkitAnimation = '';
    }
}
var xiala = 0;
function closexiala()
{
	if(xiala == 1)
    {
        zkid('menu').style.webkitTransform = 'translateY(0px)';
		setTimeout("zkid('menu').style.webkitTransform = 'translateY(-70px)'",1000);		
		setTimeout("zkid('xiala_div').style.webkitTransform = 'translateY(60px)'",1000);
        zkid('xiala_div').style.webkitTransform = 'translateY(0px)';
        xiala = 0;
    }
}
function xialaClick()
{
    if(xiala == 0)
    {
        zkid('menu').style.webkitTransform = 'translateY(0px)';
        zkid('xiala_div').style.webkitTransform = 'translateY(0px)';
        xiala = 1;
    }
    else
    {
        zkid('menu').style.webkitTransform = 'translateY(-70px)';
        zkid('xiala_div').style.webkitTransform = 'translateY(60px)';
		
        //zkid('menu').style.webkitTransform = 'translateY(0px)';
		//setTimeout("zkid('menu').style.webkitTransform = 'translateY(-70px)'",20000);		
		//setTimeout("zkid('xiala_div').style.webkitTransform = 'translateY(60px)'",20000);
        //zkid('xiala_div').style.webkitTransform = 'translateY(0px)';
        xiala = 0;
    }
}
function zk_create_modify()
{
    if(kawa_data.modify == 'yes' || kawa_data.replace_modify == 'yes')
    {

        var u = navigator.userAgent;
        var ios = (u.indexOf('iPad')>-1 || u.indexOf('iPhone') > -1) && u.match(/(i[^;]+\;(U;)? CPU.+Mac OS X)/);
        var divla = document.createElement('div');
        divla.style.position = 'fixed';
        divla.style.height = "45px";
        divla.style.width = "45px";
        divla.style.right = '90px';
        divla.style.top = '22px';
        divla.style.zIndex = '80000';
        divla.style.display = 'inline';
        divla.id = 'xiala_div';
        divla.onclick = on_modifyword_click;
        divla.style.webkitTransition = '-webkit-transform 2s ease';
        divla.innerHTML = '<div style="height:50px;width:50px;background:url(\'http://img03.taobaocdn.com/imgextra/i3/755119556/TB2dDRebFXXXXakXpXXXXXXXXXX_!!755119556.png\') no-repeat scroll 0 -978px transparent" ></div>';
        document.body.appendChild(divla);
        
    }
    else if(location.href.indexOf('facemodify') == -1)
    {
        var divAdd = document.createElement('div');
        divAdd.id = 'add_div';
        divAdd.style.position = 'fixed';
        divAdd.style.zIndex = '90000';
        divAdd.style.left = '20px';
        divAdd.style.top = '18px';
        divAdd.onclick = addMenu;
        divAdd.innerHTML = '<div id="add_quan" style="position:absolute;float:left;left:380px;height:60px;width:60px;top:0px;-webkit-transform: rotate(-45deg);"><div style="positioin:static;height:60px;width:60px;background:url(\'http://img03.taobaocdn.com/imgextra/i3/755119556/TB2dDRebFXXXXakXpXXXXXXXXXX_!!755119556.png\') no-repeat scroll 0 -540px transparent "></div></div><div id="add_jia" style="position:absolute;float:left;left:397px;height:30px;width:30px;top:15px;-webkit-transform: rotate(-45deg);-webkit-transition: -webkit-transform 0.5s linear;"><div style="positioin:static;height:30px;width:30px;background:url(\'http://img03.taobaocdn.com/imgextra/i3/755119556/TB2dDRebFXXXXakXpXXXXXXXXXX_!!755119556.png\') no-repeat scroll -16px -663px transparent "></div></div>';
        document.body.appendChild(divAdd);

        var div = document.createElement('div');
        var bg_htm = '';
        
        //赞
        //bg_htm += '<div id="zan_div" style="position:fixed;left:380px;display:none;top:18px;z-index:90001;-webkit-transition: -webkit-transform 0.5s ease-in;" onclick="zan_click()"><div id="zan_image" style="height:60px;width:60px;background:url(\'http://img03.taobaocdn.com/imgextra/i3/755119556/TB2dDRebFXXXXakXpXXXXXXXXXX_!!755119556.png\') no-repeat scroll 0 -716px transparent "></div></div>';
        bg_htm += '<div id="shu1" style="position:fixed;right:45px;display:none;top:19px;height:30px;z-index:90001;-webkit-transition: -webkit-transform 0.2s ease-in;"><div style="height:50px;width:30px;background:url(\'http://img03.taobaocdn.com/imgextra/i3/755119556/TB2dDRebFXXXXakXpXXXXXXXXXX_!!755119556.png\') no-repeat scroll 0 -850px transparent "></div></div>';
        
        //音乐开关
        //document.body.removeChild(zkid('cardsound'));
        bg_htm += "<div id='music_div' onclick='switchsound2()' style='position:fixed;display:none;;right:49px;top:12px;z-index:90001;width:52px;height:52px;-webkit-transition: -webkit-transform 0.2s ease-in;'>"
        bg_htm += "<div style='position:absolute;float:left;left:0px;top:0px;'><div id='sound_image' style='height:60px;width:60px;background:url(\"http://img03.taobaocdn.com/imgextra/i3/755119556/TB2dDRebFXXXXakXpXXXXXXXXXX_!!755119556.png\") no-repeat scroll 0 -540px transparent' ></div></div>";
        bg_htm += "<div style='position:absolute;float:left;left:13px;top:16px;'><div id='sound_image2' style='height:30px;width:30px;background:url(\"http://img03.taobaocdn.com/imgextra/i3/755119556/TB2dDRebFXXXXakXpXXXXXXXXXX_!!755119556.png\") no-repeat scroll 0 -405px transparent;-webkit-animation:rotatemusic 5s infinite linear' ></div></div>";//
        bg_htm += "<div style='position:absolute;float:left;left:11px;top:14px;'><div id='sound_image3' style='display:none;height:33px;width:40px;background:url(\"http://img03.taobaocdn.com/imgextra/i3/755119556/TB2dDRebFXXXXakXpXXXXXXXXXX_!!755119556.png\") no-repeat scroll 0 -930px transparent' ></div></div></div>";
        bg_htm += '<div id="shu2" style="position:fixed;right:45px;display:none;top:119px;height:30px;z-index:90001;-webkit-transition: -webkit-transform 0.2s ease-in;"><div style="height:50px;width:30px;background:url(\'http://img03.taobaocdn.com/imgextra/i3/755119556/TB2dDRebFXXXXakXpXXXXXXXXXX_!!755119556.png\') no-repeat scroll 0 -850px transparent "></div></div>';
        //改文字
        bg_htm += '<div id="word_div" style="position:fixed;display:none;right:49px;top:116px;z-index:90001;width:52px;height:52px;-webkit-transition: -webkit-transform 0.2s ease-in;" onclick="on_modifyword_click()">';
        bg_htm += '<div style="position:absolute;float:left;left:0px;"><div style="height:60px;width:60px;background:url(\'http://img03.taobaocdn.com/imgextra/i3/755119556/TB2dDRebFXXXXakXpXXXXXXXXXX_!!755119556.png\') no-repeat scroll 0 -540px transparent" ></div></div>';
        bg_htm += '<div style="position:absolute;float:left;left:11px;top:13px;"><div style="height:40px;width:40px;background:url(\'http://img03.taobaocdn.com/imgextra/i3/755119556/TB2dDRebFXXXXakXpXXXXXXXXXX_!!755119556.png\') no-repeat scroll 0 -450px transparent" ></div></div></div>';
        bg_htm += '<div id="shu3" style="position:fixed;display:none;right:45px;top:220px;height:30px;z-index:90001;-webkit-transition: -webkit-transform 0.2s ease-in;"><div style="height:50px;width:30px;background:url(\'http://img03.taobaocdn.com/imgextra/i3/755119556/TB2dDRebFXXXXakXpXXXXXXXXXX_!!755119556.png\') no-repeat scroll 0 -850px transparent "></div></div>';
        //选微卡  215
        bg_htm += '<div id="weika_div" style="position:fixed;display:none;right:49px;top:215px;z-index:90001;width:52px;height:52px;-webkit-transition: -webkit-transform 0.2s ease-in;" onclick="goto_kawa()">';
        bg_htm += '<div style="position:absolute;float:left;left:0px;"><div style="height:60px;width:60px;background:url(\'http://img03.taobaocdn.com/imgextra/i3/755119556/TB2dDRebFXXXXakXpXXXXXXXXXX_!!755119556.png\') no-repeat scroll 0 -540px transparent" ></div></div>';
        bg_htm += '<div style="position:absolute;float:left;left:10px;top:18px;"><div style="height:40px;width:40px;background:url(\'http://img03.taobaocdn.com/imgextra/i3/755119556/TB2dDRebFXXXXakXpXXXXXXXXXX_!!755119556.png\') no-repeat scroll 0 -360px transparent" ></div></div></div>';
        //bg_htm += '<div id="jia1" style="position:fixed;left:80px;top:45px;z-index:90001;font-size:15pt;color:rgb(140,130,191);-webkit-transition: top 0.5s ease-in;"></div>';
        //bg_htm += '<div id="zan_num" style="position:fixed;left:75px;top:60px;z-index:90001;font-size:15pt;color:white;display:none">870</div>';
        div.innerHTML = bg_htm;
        document.body.appendChild(div);
        zkid('cardsound').style.display = 'none';
        zkid('cardsound').style.top = '0px';
    }
}

function Share()
{
  document.getElementById('card_menu').className = "hide";
  document.getElementById('shareTips').style.display="block";
  document.getElementById('shareTips').onclick = function(){
    document.getElementById('shareTips').style.display="none";
    document.getElementById('shareTips').onclick = function(){};
    document.getElementById('card_menu').className = "fade";
  }    
}

mp3_list = new Array();

music_sel = 'none';



function get_music(music_name)
{
    for(i=0; i<mp3_list.mp3s.length; i++)
    {
        if(mp3_list.mp3s[i].name == music_name)
        {
            return i;
        }
    }

    return -1;
}


function setup_lines()
{
    for(i=0; i<mp3_list.mp3s.length; i++)
    {
        div = document.createElement('div');
        div.style.position = 'relative';
        div.style.height = '90px';
        div.style.width = '98%';
        div.style.borderBottom = '2px ridge #E5E5E5';


        var div_html = '';
        div_html += '<div style="position:relative;float:left;padding-top:30px;left:5px;width:40px;height:40px"><div id="play_img_' + i + '" style="height:40px;width:40px;background:url(\'http://img03.taobaocdn.com/imgextra/i3/755119556/TB2dDRebFXXXXakXpXXXXXXXXXX_!!755119556.png\') no-repeat scroll 0 -495px transparent "></div></div>';//<img id=play_img_' + i + ' src="http://tu.kagirl.net/pic/tubiao/tubiao_15.png"/>
        div_html += '<div onclick="select_mp3(' + i +')" style="position:relative;float:left;height:90px;left:5%;width:70%;line-height:90px;font-size:20pt;font-weight:bold;">' + mp3_list.mp3s[i].title +'</div>';
        div_html += '<div onclick="zk_buildmusic_card(' + i + ')" style="position:relative;float:right;right:2%;height:90px;width:60px;top:25px"><div id="ok_img_' + i + '" style="display:none;height:38px;width:60px;background:url(\'http://img03.taobaocdn.com/imgextra/i3/755119556/TB2dDRebFXXXXakXpXXXXXXXXXX_!!755119556.png\') no-repeat scroll 0 -610px transparent "></div></div>';

        div.innerHTML = div_html;

        zkid('mp3box').appendChild(div);
    }
}

function select_mp3(index)
{
    if(music_player != null)
    {
        music_player.pause();
        //objid("sound_image3").style.display = 'inline';
        //objid('sound_image').style.webkitAnimation = '';
        pop_up_note_mode = false;
    }
    
    for(var i=0; i<mp3_list.mp3s.length; i++)
    {
        zkid('ok_img_' + i).style.display = 'none';
        zkid('play_img_' + i).style.webkitAnimation = '';
    }
    zkid('ok_img_' + index).style.display = 'block';
    zkid('play_img_' + index).style.webkitAnimation = 'rotatemusic 5s infinite linear';

    if(zkid('player').src == mp3_list.url_header + mp3_list.mp3s[index].url)
    {
        if(zkid('player').paused)
        {
            zkid('player').play();
            zkid('play_img_' + index).style.webkitAnimation = 'rotatemusic 5s infinite linear';
        }
        else
        {
            zkid('player').pause();
            zkid('play_img_' + index).style.webkitAnimation = '';
        }
    }
    else
    {
        zkid('player').src = mp3_list.url_header + mp3_list.mp3s[index].url;
        zkid('player').play();
    }
    music_sel = mp3_list.mp3s[index].name;
}


