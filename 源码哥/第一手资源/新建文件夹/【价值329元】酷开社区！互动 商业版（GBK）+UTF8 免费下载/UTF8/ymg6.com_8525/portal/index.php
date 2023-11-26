<?php echo '源码哥免费分享，仅供学习，请支持正版！';exit;?>
<!--{subtemplate common/header}-->
<div id="wp" class="wp">
    <style id="diy_style" type="text/css"></style>
    <script type="text/javascript" src="$_G['style']['styleimgdir']/js/jquery.masonry.min.js"></script> 
    <script type="text/javascript" src="$_G['style']['styleimgdir']/js/jPages.js"></script>
    

    
    <script type="text/javascript" src="$_G['style']['styleimgdir']/js/jquery.SuperSlide.js"></script> 
    <!--[diy=headeraddiy]--><div id="headeraddiy" class="area"></div><!--[/diy]-->
    <div class="main">
        <div class="web_widht">
            <div class="box_right index_right">                         
                <div>
                    <!--[diy=diypo01]--><div id="diypo01" class="area"></div><!--[/diy]-->
                </div>
                
                <div id="ct">
                    <div class="sd nbk">
                        <!--[diy=diypo02]--><div id="diypo02" class="area"></div><!--[/diy]-->

                        <!--[diy=diypo03]--><div id="diypo03" class="area"></div><!--[/diy]-->

                        <!--[diy=diypo04]--><div id="diypo04" class="area"></div><!--[/diy]-->

                        <!--[diy=diypo05]--><div id="diypo05" class="area"></div><!--[/diy]-->

                        <!--[diy=diypo06]--><div id="diypo06" class="area"></div><!--[/diy]-->

                        <!--[diy=diypo07]--><div id="diypo07" class="area"></div><!--[/diy]-->

                        <!--[diy=diypo08]--><div id="diypo08" class="area"></div><!--[/diy]-->

                        <!--[diy=diypo09]--><div id="diypo09" class="area"></div><!--[/diy]-->

                        <!--[diy=diypo10]--><div id="diypo10" class="area"></div><!--[/diy]-->
                    </div>
                </div>
            </div>
        </div>

        <div class="box_left" style="margin-top:0;">
            <div class="por_pt cl">
                <!--[diy=diypor01]--><div id="diypor01" class="area"></div><!--[/diy]-->
            </div>
            
            <div class="banner">
                <div id="frameWS6X6s">
                    <div id="frameWS6X6s_left">
                        <div id="frameWS6X6s_left_temp" class="move-span temp"></div>
                        <!--[diy=diypor02]--><div id="diypor02" class="area"></div><!--[/diy]-->
                    </div>
                </div>
            </div>
            
            <div class="recomapp" {if $_GET[ 'diy']=='yes' } style="margin-top:50px;" {/if}>
                <div class="line">
                    <ul class="recomappTab">
                        <li class="active" rel="hotapp">热门应用</li>
                        <li rel="recoma">推荐应用</li>
                    </ul>
                    <script>
                        jQuery(function() {
                            jQuery(".recomappTab li").hover(function() {
                                jQuery(".appList").hide();
                                jQuery(".recomappTab li").removeClass("active");
                                jQuery(this).addClass("active");
                                var liRel = jQuery(this).attr("rel");
                                if (liRel == "hotapp") {
                                    jQuery(".hotapp").show();
                                } else {
                                    jQuery(".recoma").show();
                                }
                            }, function() {})
                        })
                    </script>
                    <div class="ques"><em></em>
                       <a href="./">如何安装第三方应用？</a>
                    </div> <a href="./" class="more"><em>*</em>更多应用推荐</a> 
                </div>
                <div class="clear"></div>
                <style>
                .box_left .recomapp .appList {
                    display: block;
                }
                </style>
                
                <div id="recomapp">
                    <div class="frame block">
                        <!--[diy=diypor03]--><div id="diypor03" class="area"></div><!--[/diy]-->
                    </div>
                </div>
            </div>
            <script>
                jQuery(function() {
                    jQuery(".appicon").hover(function() {
                        jQuery(this).find('.recomtips').show();
                    }, function() {
                        jQuery(this).find('.recomtips').hide();
                    });
                })
            </script>

            <div class="index_guangao">
                <!--[diy=diypor04]--><div id="diypor04" class="area"></div><!--[/diy]-->
                
                <!--[diy=diypor05]--><div id="diypor05" class="area"></div><!--[/diy]-->
            </div>
        </div>
        <div class="clear"></div>
        <div class="marginTop">
            <a href="./" target="_blank">
                <img src="$_G['style']['directory']/images/ai3.jpg" height="60" width="990" alt="0元秒杀" border="0">
            </a>
        </div>
        
        </div>
    </div>

<!--{subtemplate common/footer}-->

<script type="text/javascript">
(function(jQuery){
    jQuery.fn.th_focus_swing = function(options)
    {
        var defaults = {
            time        :6500,      //轮换秒数
            index       :1,         //默认第几张     
            speed       :500,       //切换时间
            dis         :587,
            splits      :1          //总标签
        };
        var opts = jQuery.extend(defaults, options);
        
        var _index = opts.index;
        var _time = opts.time;
        var _speed = opts.speed;
        var _dis = opts.dis;
        var _splits = opts.splits;
        
        var _this = jQuery(this);
        
        var node_ul = _this.find(".contentimg");    
        var node_li = node_ul.find("li");
        var node_li_desc = jQuery(".contentdesc").find("li");
        var node_li_nav = jQuery(".mfoc_nav").find("li");
        
        var li_len = node_li.length;
        
        var _countIndex = (node_li.length/opts.split -  1)    
        var _start_left = node_ul.css("left");                
        
        var _timer = setInterval(show, _time);
        var desc = "";
        for(i=0; i<4; i++){
            var imgAlt = jQuery(".contentimg li:eq("+i+")").find("img").attr("alt");
            jQuery(".ac-tive:eq(" + i +")").find("h4").text(imgAlt);
            var imgSrc = jQuery(".contentimg li:eq("+i+")").find("img").attr("src");
            jQuery(".mfoc_nav li:eq("+i+") img").attr("src",imgSrc);
        }
        jQuery(".navbox").show();
        init();
        //alert(1);
        function init() {
            node_ul.mouseover(function() {
                _timer = clearInterval(_timer);
            }).mouseout(function() {
                _timer = setInterval(show, _time);
            });
            node_li_desc.mouseover(function() {
                _timer = clearInterval(_timer);
            }).mouseout(function() {
                _timer = setInterval(show, _time);
            });
            
            node_li_nav.mouseover(function() {
                 node_ul.stop(true, true);
                 node_li_desc.stop(true, true);
                 node_li_desc.eq(_index-1).css("display", "none");
                 node_li_nav.eq(_index-1).removeClass("selected");
                 _index = parseInt(jQuery(this).attr("_index"));
                 node_li_desc.eq(_index-1).fadeIn(_speed);
                 node_li_nav.eq(_index-1).addClass("selected");
                 _left = -_dis*(_index - 1); 
                 node_ul.animate({"left": _left}, _speed);
                _timer = clearInterval(_timer);
            }).mouseout(function() {
                _timer = setInterval(show, _time);
            });
        }
        
        function show() {
                        //alert(2);
            node_ul.stop(true, true);
            node_li_nav.eq(_index-1).removeClass("selected");
            node_li_desc.eq(_index-1).css("display", "none");
            _index++;
            if(_index > li_len) {
                node_ul.append(node_ul.find("li:lt(1)"));
                node_ul.css("left", parseInt(node_ul.css("left")) + _dis);
                node_li_nav.eq(0).addClass("selected");
                node_li_desc.eq(0).fadeIn(_speed);
            }
            else {
                node_li_nav.eq(_index-1).addClass("selected");
                node_li_desc.eq(_index-1).fadeIn(_speed);
            }
            var _left = parseInt(node_ul.css("left")) - _dis;
            node_ul.animate({"left": _left}, _speed, function() {
                    if(_index > li_len) {
                        node_ul.prepend(node_ul.find("li:gt("+(li_len-_splits-1)+")"));
                        node_ul.css("left", 0);
                        _index = 1;
                    }
                    
            });
            
        }
    }
})(jQuery);    
</script> 
<script>
jQuery(document).ready(function(){
    //focus
    jQuery(".focusbox").th_focus_swing();
});
</script>