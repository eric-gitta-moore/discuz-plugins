//�Ҽ��˵�
jQuery(document).ready(function ($) {
    $("#spig").mousedown(function (e) {
        if(e.which==3){
        showMessage(right_click, 10000);
}
});
$("#spig").bind("contextmenu", function(e) {
    return false;
});
});

//�������Ϣ��ʱ
jQuery(document).ready(function ($) {
    $("#message").hover(function () {
       $("#message").fadeTo("100", 1);
     });
});


//������Ϸ�ʱ
jQuery(document).ready(function ($) {
    $(".mumu").mouseover(function () {
       $(".mumu").fadeTo("300", 0.3);
       //msgs = ["�������ˣ��㿴������", "�һ�����Ŷ���ٺ٣�", "���ֶ��ŵģ������ÿ���", "�����ÿ��Ҳų�����"];
       msgs = over_array;
	   var i = Math.floor(Math.random() * msgs.length);
        showMessage(msgs[i]);
    });
    $(".mumu").mouseout(function () {
        $(".mumu").fadeTo("300", 1)
    });
});

//��ʼ
jQuery(document).ready(function ($) {
        var now = (new Date()).getHours();
        if (now > 0 && now <= 5) {
            showMessage(visitor + ' ҹè����˯�������������ô�㣿', 6000);
        } else if (now > 5 && now <= 6) {
            showMessage(visitor + ' �µ�һ�쿪ʼ��Ŷ!', 6000);
        } else if (now > 6 && now <= 10) {
            showMessage(visitor + ' ���Ϻã�����������ǳ����������', 6000);
        } else if (now > 10 && now <= 13) {
            showMessage(visitor + ' �����ˣ��Է���ô����Ҫ������', 6000);
        } else if (now > 13 && now <= 16) {
            showMessage(visitor + ' �����ʱ�����Ѱ������������ڣ�', 6000);
        } else if (now > 16 && now <= 17) {
            showMessage(visitor + ' ���ڵȵ����ˣ�', 6000);
        } else if (now > 21 && now <= 23) {
            showMessage(visitor + ' ҹ���ˣ�����˯�', 6000);
        } else {
            showMessage(visitor + ' ����������ɣ�', 6000);
        }
    $(".spig").animate({
        top: $(".spig").offset().top + 300,
        left: document.body.offsetWidth - 160
    },
	{
	    queue: false,
	    duration: 1000
	});
});

//�����ĳЩԪ���Ϸ�ʱ
jQuery(document).ready(function ($) {
    $('h2 a').click(function () {//���ⱻ���ʱ
        showMessage('�����ó��̵ľ����ء�<span style="color:#0099cc;">' + $(this).text() + '</span>�����Ժ�');
    });
	
	//�ƶ����·���ı�������ʱ
    $('.fl_by div a.xi2').mouseover(function () {
        showMessage('Ҫ������<span style="color:#0099cc;">' + $(this).text() + '</span>����ƪ����ô��');
    });
	
	//�ƶ������ۿ�ʱ
    $('#fastpostmessage').mouseover(function(){
        showMessage('˵��ʲô�ɣ�');
    });
	
	//�ƶ�������������İ�ťʱ
    $('#newspecial').mouseover(function(){
        showMessage('���ɣ����ɣ����ɣ�');
    });
});


//���Ľ���ʲô
jQuery(document).ready(function ($) {

    window.setInterval(function () {
       // msgs = ["��������ɣ�", "������Ŷ���㶼�������棡", "��@����!������", "^%#&*!@*(&#)(!)(", "�ҿɰ��ɣ�����!~^_^!~~","˭����ѽ?~˭����?��������ѽ!~~��������~~","��ǰ����ɽ��ɽ�������������и��Ϻ��и�С���н����£���������ǰ����������"];
        msgs = bored_array;
		var i = Math.floor(Math.random() * msgs.length);
        showMessage(msgs[i], 10000);
    }, 35000);
});

//���Ķ���
jQuery(document).ready(function ($) {
    window.setInterval(function () {
        //msgs = ["Ǭ����Ų�ƣ�", "��Ʈ�����ˣ�~", "��Ʈ��ȥ��", "�ҵ����Ʈ��~Ʈ��~"];
        msgs = move_array;
        //�ж��Ƿ��������ƶ�
        if (onoff_move!=0){
    		var i = Math.floor(Math.random() * msgs.length);
            s = [0.1, 0.2, 0.3, 0.4, 0.5, 0.6,0.7,0.75,-0.1, -0.2, -0.3, -0.4, -0.5, -0.6,-0.7,-0.75];
            var i1 = Math.floor(Math.random() * s.length);
            var i2 = Math.floor(Math.random() * s.length);
                $(".spig").animate({
                left: document.body.offsetWidth/2*(1+s[i1]),
                top:  document.body.offsetHeight/2*(1+s[i1])
            },
    			{
    			    duration: 2000,
    			    complete: showMessage(msgs[i])
    			});
        }
    }, 45000);
});

//������ʱ��
jQuery(document).ready(function ($) {
    $("#scbar_txt").click(function () {
        showMessage('������Ҫ��Ŷ��');
        $(".spig").animate({
            top: $("#author").offset().top - 70,
            left: $("#author").offset().left - 170
        },
		{
		    queue: false,
		    duration: 1000
		});
    });
});

var spig_top = 50;
//�������ƶ�
jQuery(document).ready(function ($) {
    var f = $(".spig").offset().top;
    $(window).scroll(function () {
        $(".spig").animate({
            top: $(window).scrollTop() + f +300
        },
		{
		    queue: false,
		    duration: 1000
		});
    });
});

//�����ʱ
jQuery(document).ready(function ($) {
    var stat_click = 0;
    $(".mumu").click(function () {
        if (!ismove) {
            stat_click++;
            if (stat_click > 4) {
                msgs = ["������û��ѽ��", "���Ѿ�����" + stat_click + "����", "����ѽ������!"];
                var i = Math.floor(Math.random() * msgs.length);
                //showMessage(msgs[i]);
            } else {
                msgs = touch_array;
				var i = Math.floor(Math.random() * msgs.length);
                //showMessage(msgs[i]);
            }
            //�ж��Ƿ��������ƶ�
            if (onoff_move!=0){
                s = [0.1, 0.2, 0.3, 0.4, 0.5, 0.6,0.7,0.75,-0.1, -0.2, -0.3, -0.4, -0.5, -0.6,-0.7,-0.75];
                var i1 = Math.floor(Math.random() * s.length);
                var i2 = Math.floor(Math.random() * s.length);
                    $(".spig").animate({
                    left: document.body.offsetWidth/2*(1+s[i1]),
                    top:  document.body.offsetHeight/2*(1+s[i1])
                    },
        			{
        			    duration: 500,
        			    complete: showMessage(msgs[i])
        			});
            }
        } else {
            ismove = false;
        }
    });
});
//��ʾ��Ϣ���� 
function showMessage(a, b) {
    if (b == null) b = 10000;
    jQuery("#message").hide().stop();
    jQuery("#message").html(a);
    jQuery("#message").fadeIn();
    jQuery("#message").fadeTo("1", 1);
    jQuery("#message").fadeOut(b);
};

//�϶�
var _move = false;
var ismove = false; //�ƶ����
var _x, _y; //�����ؼ����Ͻǵ����λ��
jQuery(document).ready(function ($) {
    $("#spig").mousedown(function (e) {
        _move = true;
        _x = e.pageX - parseInt($("#spig").css("left"));
        _y = e.pageY - parseInt($("#spig").css("top"));
     });
    $(document).mousemove(function (e) {
        if (_move) {
            var x = e.pageX - _x; 
            var y = e.pageY - _y;
            var wx = $(window).width() - $('#spig').width();
            var dy = $(document).height() - $('#spig').height();
            if(x >= 0 && x <= wx && y > 0 && y <= dy) {
                $("#spig").css({
                    top: y,
                    left: x
                }); //�ؼ���λ��
            ismove = true;
            }
        }
    }).mouseup(function () {
        _move = false;
    });
});
