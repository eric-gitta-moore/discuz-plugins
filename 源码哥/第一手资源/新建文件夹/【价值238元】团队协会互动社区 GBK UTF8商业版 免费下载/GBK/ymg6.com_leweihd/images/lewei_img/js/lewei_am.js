
jQuery('ul.lewei_tq li').hover(function() {

jQuery(".lewei_bts", this).stop().animate({height: '100%'},{queue: false,duration: 160});},function() {

jQuery(".lewei_bts", this).stop().animate({height: '30px'},{queue: false,duration: 160});});
