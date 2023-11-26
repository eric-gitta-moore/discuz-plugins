kawa_id = 0;
kawa_actions = {};

function _kmid(idname)
{
    return document.getElementById(idname);
}

function km_add_keyframes(cssbody)
{
    var name = 'kawa_keyframes_' + kawa_id;
    kawa_id += 1;

    var csstext = '@-webkit-keyframes ' + name + '{' + cssbody + '}';

    var style = document.createElement('style');
    document.head.appendChild(style);
    var sheet = style.sheet;
    sheet.insertRule(csstext, 0);

    return name;
}

function add_action(ac_body)
{
    var name = 'kawa_action_' + kawa_id;
    kawa_id += 1;

    kawa_actions[name] = ac_body;
    return name;    
}

function img_url(imgname)
{
    return kawa_images[imgname].url;
}

function new_sprite(imgname, pos, visible)
{
    var x = pos.split(',')[0] + 'px';
    var y = pos.split(',')[1] + 'px';

    var one = document.createElement('div');
    var img = document.createElement('img');

    if(img_url(imgname) != '')
    {
        img.src = img_url(imgname);
    }

    one.id = 'kawa_obj_' + kawa_id;
    img.id = 'kawa_obj_' + (kawa_id + 1);

    one.appendChild(img);
    one.style.position = 'absolute';
    one.style.visibility = visible == true ? 'visible' : 'hidden';
    one.style.left = x;
    one.style.top = y;
    one.img = img;

    document.body.appendChild(one);

    kawa_id += 2;

    return one;
}

function conv_transform(text)
{
    var result = '';
    var tks1 = text.split(',');

    for(var i=0; i<tks1.length; i++)
    {
        switch(tks1[i].charAt(0))
        {
            case 'x':
                value = tks1[i].substring(1);
                result += 'translateX(' + value + 'px) ';
                break;

            case 'y':
                value = tks1[i].substring(1);
                result += 'translateY(' + value + 'px) ';
                break;

            case 'w':
                value = tks1[i].substring(1);
                result += 'scaleX(' + value + ') ';
                break;

            case 'h':
                value = tks1[i].substring(1);
                result += 'scaleY(' + value + ') ';
                break;

            case 'a':
                value = tks1[i].substring(1);
                result += 'rotate(' + value + 'deg) ';
                break;
        }
    }

    return result;
}

function new_path_action(pathstr, acmode)
{
    var total_t = 0;
    var tks = pathstr.split('->');

    for(var i=1; i<tks.length; i=i+2)
    {
        total_t += parseFloat(tks[i]);
    }

    var css = '0%{-webkit-transform:' + conv_transform(tks[0]) + ';}';
    var tc = 0;
    console.log(css);

    for(var i=1; i<tks.length; i=i+2)
    {
        tc += parseFloat(tks[i]);
        pc = tc * 100 / total_t;
        tx = pc + '% {-webkit-transform:' + conv_transform(tks[i+1]) + ';}';
        css += tx;
        console.log(tx);
    }

    var kf_name = km_add_keyframes(css);

    var ac_body = {type : 'path', keyframes : kf_name, duration : total_t, mode : acmode};
    var ac_name = add_action(ac_body);

    return ac_name;
}

function new_opacity_action(from, to, acduration, acop, acmode)
{
    var css = 'from{opacity:' + from + '} to{opacity:' + to + '}';

    var kf_name = km_add_keyframes(css);
    var ac_body = {type : 'opacity', keyframes : kf_name, duration : acduration, mode : acmode, op : acop};
    var ac_name = add_action(ac_body)

    return ac_name;
}

function trim(in_text)
{
    if(typeof(in_text) == 'undefined')
    {
        return '';
    }

    return in_text.replace(/(^\s*)|(\s*$)/g, '');
}

function extract_animation(obj, kf_name)
{
    var css = trim(obj.style.webkitAnimation);
    var tks = css.split(',');
    var new_css = new Array();
    var existed = false;

    for(var i=0; i<tks.length; i++)
    {
        var one = trim(tks[i]).split(' ')[0];
        if(one == kf_name)
        {
            existed = true;
        }
        else if(trim(tks[i]) != '')
        {
            new_css.push(tks[i]); 
        }
    }

    return {existed : existed, css : new_css};
}

function apply_action(sprite_id, action_name)
{
    var sprite = _kmid(sprite_id);
    var ac = kawa_actions[action_name];

    var er = extract_animation(sprite, ac.keyframes);
    var animation = ac.keyframes + ' ' + ac.duration + 's ' + ac.mode;

    var clean_up = er.css.join(',');
    er.css.push(animation);
    var new_css_str = er.css.join(',');

    if(er.existed)
    {
        sprite.style.webkitAnimation = clean_up;
        console.log('cleanup ' + clean_up);
        var ex1 = 'apply_action("' + sprite_id + '", "' + action_name + '")';
        var ex2 = 'setTimeout(\'' + ex1 + '\', 50);';
        console.log(ex2);
        eval(ex2);
    }
    else
    {
        console.log('**' + new_css_str);
        sprite.style.webkitAnimation = new_css_str;        
    }

    if(ac.type == 'opacity')
    {
        if(ac.op == 'show')
        {
            sprite.style.visibility = 'visible';
        }
        else if(ac.op == 'hide')
        {
            eval("setTimeout('hide_sprite(\"" + sprite_id + "\")', " + ac.duration*1000 + ");");
        }
    }
}

function hide_sprite(sprite_id)
{
    var sprite = _kmid(sprite_id);
    sprite.style.visibility = 'hidden';
}

function action_at_time(time, sprite, action)
{
    var exec_str = 'setTimeout(\'apply_action("' + sprite.id + '", "' + action + '")\', ' + time + ')';
    eval(exec_str);
}


