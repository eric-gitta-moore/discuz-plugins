/**
 * jQuery's jqfaceedit Plugin
 *
 * @author cdm
 * @version 0.2
 * @copyright Copyright(c) 2012.
 * @date 2012-08-09
 */
(function($) {
    var em = [
                {'id':1,'phrase':':kaixin:','url':'1.gif'},
				{'id':2,'phrase':':daxiao:','url':'2.gif'},
				{'id':3,'phrase':':qinzui:','url':'3.gif'},
				{'id':4,'phrase':':fengnu:','url':'4.gif'},
				{'id':5,'phrase':':huaxin:','url':'5.gif'},
				{'id':6,'phrase':':ku:','url':'6.gif'},
				{'id':7,'phrase':':kuqi:','url':'7.gif'},
				{'id':8,'phrase':':jingya:','url':'8.gif'},
				{'id':9,'phrase':':bukaixin:','url':'9.gif'},
				{'id':10,'phrase':':liuhan:','url':'10.gif'},
				{'id':11,'phrase':':shuijiao:','url':'11.gif'},
				{'id':12,'phrase':':shengqi:','url':'12.gif'},
				{'id':13,'phrase':':bizui:','url':'13.gif'},
				{'id':14,'phrase':':daizhi:','url':'14.gif'},
				{'id':15,'phrase':':gaoao:','url':'15.gif'},
				{'id':16,'phrase':':tiaopi:','url':'16.gif'},
				{'id':17,'phrase':':wuyu:','url':'17.gif'},
				{'id':18,'phrase':':ciya:','url':'18.gif'},
				{'id':19,'phrase':':exin:','url':'19.gif'},
				{'id':20,'phrase':':aiqian:','url':'20.gif'},
				{'id':21,'phrase':':weiqu:','url':'21.gif'},
				{'id':22,'phrase':':keai:','url':'22.gif'},
				{'id':23,'phrase':':jingxia:','url':'23.gif'},
				{'id':24,'phrase':':zaogao:','url':'24.gif'},

            ];
    //textarea设置光标位置
    function setCursorPosition(ctrl, pos) {
        if(ctrl.setSelectionRange) {
            ctrl.focus();
            ctrl.setSelectionRange(pos, pos);
        } else if(ctrl.createTextRange) {// IE Support
            var range = ctrl.createTextRange();
            range.collapse(true);
            range.moveEnd('character', pos);
            range.moveStart('character', pos);
            range.select();
        }
    }

    //获取多行文本框光标位置
    function getPositionForTextArea(obj)
    {
        var Sel = document.selection.createRange();
        var Sel2 = Sel.duplicate();
        Sel2.moveToElementText(obj);
        var CaretPos = -1;
        while(Sel2.inRange(Sel)) {
            Sel2.moveStart('character');
            CaretPos++;
        }
       return CaretPos ;

    }

    $.fn.extend({
        jqfaceedit : function(options) {
            var defaults = {
                txtAreaObj : '', //TextArea对象
                containerObj : '', //表情框父对象
                textareaid: 'needmessage',//textarea元素的id
                popName : '', //iframe弹出框名称,containerObj为父窗体时使用
                emotions : em, //表情信息json格式，id表情排序号 phrase表情使用的替代短语url表情文件名
                top : 0, //相对偏移
                left : 0 //相对偏移
            };
            
            var options = $.extend(defaults, options);
            var cpos=0;//光标位置，支持从光标处插入数据
            var textareaid = options.textareaid;
            
            return this.each(function() {
                var Obj = $(this);
                var container = options.containerObj;
                if ( document.selection ) {//ie
                    options.txtAreaObj.bind("click keyup",function(e){//点击或键盘动作时设置光标值
                        e.stopPropagation();
                        cpos = getPositionForTextArea(document.getElementById(textareaid)?document.getElementById(textareaid):window.frames[options.popName].document.getElementById(textareaid));
                    });
                }
                $(Obj).bind("click", function(e) {
                    e.stopPropagation();
                    var faceHtml = '<div id="face">';
                    faceHtml += '<div id="facebox">';
                    faceHtml += '<div id="face_detail" class="facebox clearfix"><ul>';

                    for( i = 0; i < options.emotions.length; i++) {
                        faceHtml += '<li text=' + options.emotions[i].phrase + ' type=' + i + '><img title=' + options.emotions[i].phrase + ' src="template/zhikai_n5app/images/bq/'+ options.emotions[i].url + '"  style="cursor:pointer; position:relative;"   /></li>';
                    }
                    faceHtml += '</ul></div>';
                    faceHtml += '</div><div class="arrow arrow_t"></div></div>';

                    container.find('#face').remove();
                    container.append(faceHtml);
                    
                    container.find("#face_detail ul >li").bind("click", function(e) {
                        var txt = $(this).attr("text");
                        var faceText = txt;

                        //options.txtAreaObj.val(options.txtAreaObj.val() + faceText);
                        var tclen = options.txtAreaObj.val().length;
                        
                        var tc = document.getElementById(textareaid);
                        if ( options.popName ) {
                            tc = window.frames[options.popName].document.getElementById(textareaid);
                        }
                        var pos = 0;
                        if( typeof document.selection != "undefined") {//IE
                            options.txtAreaObj.focus();
                            setCursorPosition(tc, cpos);//设置焦点
                            document.selection.createRange().text = faceText;
                            //计算光标位置
                            pos = getPositionForTextArea(tc); 
                        } else {//火狐
                            //计算光标位置
                            pos = tc.selectionStart + faceText.length;
                            options.txtAreaObj.val(options.txtAreaObj.val().substr(0, tc.selectionStart) + faceText + options.txtAreaObj.val().substring(tc.selectionStart, tclen));
                        }
                        cpos = pos;
                        setCursorPosition(tc, pos);//设置焦点
                        container.find("#face").remove();

                    });
                    //处理js事件冒泡问题
                    $('body').bind("click", function(e) {
                        e.stopPropagation();
                        container.find('#face').remove();
                        $(this).unbind('click');
                    });
                    if(options.popName != '') {
                        $(window.frames[options.popName].document).find('body').bind("click", function(e) {
                            e.stopPropagation();
                            container.find('#face').remove();
                        });
                    }
                    container.find('#face').bind("click", function(e) {
                        e.stopPropagation();
                    });
                    var offset = $(e.target).offset();
                    offset.top += options.top;
                    offset.left += options.left;
                    container.find("#face").css(offset).show();
                });
            });
        },
    })
})(jQuery);
