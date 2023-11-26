note_id = 0;
win_height = 0;
music_player = new Audio();
pop_up_note_mode = true;

text_prepared = false;
font_img = null;



// pure_card_text

// ---------------------------------------------------------------------
// sdk

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
    add_kawa_icon();
    create_music();
    //create_modify();
    zk_create_modify();

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


        var re_d = /^\d+/;
        var font_size = parseFloat(re_d.exec(kawa_data.font_size)[0]);
        var line_height = parseFloat(re_d.exec(kawa_data.line_height)[0]);
        var gap = line_height - font_size;

        var box = kawa_data.text_box.split(' ');

        var color = kawa_data.text_color.substring(1);


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

function get_host()
{
    if(location.href.indexOf('jielanhua') != -1)
    {
        return 'hg.jielanhua.cn';
    }
    if(location.href.indexOf('work.kagirl.net') != -1)
    {
        return 'work.kagirl.net';
    }

    //n = Math.floor(Math.random() * 30 + 1);
    //eturn 'cd' + n + '.nightsun-led.cn';

    //n = Math.floor(Math.random() * 50 + 1);
    //return 'cd' + n + '.naturalgift.cc';

    return 'weika5.kagirl.net';
}

function share_url()
{
    if(_v('use_share_url') == 'yes' && _kv(kawa_data.share_url))
    {
        //if(kawa_data.modify == 'yes' || kawa_data.replace_modify == 'yes')
        {
            return kawa_data.share_url;
        }
    }
    /*
    if(_v('short_url') != '')
    {
        if(kawa_data.replace_words == '#replace_words#')
        {
            return _v('short_url'); 
        }

        if(kawa_data.replace_words == kawa_data.words)
        {
            return _v('short_url'); 
        }
    }
    */
    url = 'http://' + get_host() + '/kawa2/show.php'
    url = url + '?cardid=' + kawa_data.cardid;

    encoded_words = encodeURIComponent(pure_card_text());
    url = url + '&words=' + encoded_words;

    url = url + '&cookie=' + Math.random() * 1000000;

    if(_v('replace_music_name') != '#replace_music_name#')
    {
        url = url + '&music=' + kawa_data.replace_music_name;
    }

    if(_v('openid') != '#openid#')
    {
        url = url + '&openid_u=' + kawa_data.openid;
    }

    if(_v('headimgurl') != '#headimgurl#')
    {
        url = url + '&headimgurl_u=' + encodeURIComponent(kawa_data.headimgurl);
    }

    if(_v('nickname') != '#nickname#')
    {
        url = url + '&nickname_u=' + encodeURIComponent(kawa_data.nickname);
    }
    

    return url;
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
    switch(res.err_msg)
    {
        case "share_timeline:confirm":
        case "share_timeline:ok":
            location.href = 'tongji.php?action=timeline&cardid='+kawa_data.cardid;
            break;
        case "send_app_msg:confirm":
        case "send_app_msg:ok":
            location.href = 'tongji.php?action=message&cardid='+kawa_data.cardid;
            break;

        //location.href="http://mp.weixin.qq.com/s?__biz=MjM5MDg0OTE0Mw==&mid=209500314&idx=1&sn=c4b319fb642639a02821411fb859435c#wechat_redirect"
    }
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

function on_modify_click()
{
    url = 'write.php?cardid=' + kawa_data.cardid;
    url = url + '&optfile=' + kawa_data.modify_optfile;

    if(kawa_data.modify_optwords != '#modify_optwords#')
    {
        url = url + '&optwords=' + encodeURIComponent(kawa_data.modify_optwords);
    }

    if(typeof(kawa_data.write_param) != 'undefined' && kawa_data.write_param != '')
    {
        url = url + '&' + kawa_data.write_param;
    }

    location.href = url;
}

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
    text = in_text.replace(/,\n/g, ',');
    text = text.replace(/，\n/g, '，');
    text = text.replace(/\.\n/g, '.');
    text = text.replace(/。\n/g, '。');
    text = text.replace(/;\n/g, ';');
    text = text.replace(/；\n/g, '；');
    text = text.replace(/!\n/g, '!');
    text = text.replace(/！\n/g, '！');
    text = text.replace(/～\n/g, '～');
    text = text.replace(/：\n/g, '：');
    text = text.replace(/:\n/g, ':');    
    text = text.replace(/？\n/g, '：');
    text = text.replace(/\?\n/g, ':');
    text = text.replace(/\n+/g, '。');
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
}








