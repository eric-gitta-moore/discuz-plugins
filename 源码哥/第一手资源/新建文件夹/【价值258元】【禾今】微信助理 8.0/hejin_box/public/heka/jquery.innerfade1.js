/* =========================================================

// jquery.innerfade.js

// Datum: 2008-02-14
// Firma: Medienfreunde Hofmann & Baldes GbR
// Author: Torsten Baldes
// Mail: t.baldes@medienfreunde.com
// Web: http://medienfreunde.com

// based on the work of Matt Oakes http://portfolio.gizone.co.uk/applications/slideshow/
// and Ralf S. Engelschall http://trainofthoughts.org/

 *
 *  <ul id="news"> 
 *      <li>content 1</li>
 *      <li>content 2</li>
 *      <li>content 3</li>
 *  </ul>
 *  
 *  $('#news').innerfade({ 
 *	  animationtype: Type of animation 'fade' or 'slide' (Default: 'fade'), 
 *	  speed: Fading-/Sliding-Speed in milliseconds or keywords (slow, normal or fast) (Default: 'normal'), 
 *	  timeout: Time between the fades in milliseconds (Default: '2000'), 
 *	  type: Type of slideshow: 'sequence', 'random' or 'random_start' (Default: 'sequence'), 
 * 		containerheight: Height of the containing element in any css-height-value (Default: 'auto'),
 *	  runningclass: CSS-Class which the container get’s applied (Default: 'innerfade'),
 *	  children: optional children selector (Default: null)
 *		自己增加 autoStop和reloadWeb
 *  }); 
 *

// ========================================================= */


(function($) {



    $.fn.innerfade = function(options) {
        return this.each(function() {   
            $.innerfade(this, options);
        });
    };

    $.innerfade = function(container, options) {
        var settings = {
        	'animationtype':    'fade',
            'speed':            'normal',
            'type':             'sequence',
            'timeout':          2000,
            'containerheight':  '0',
            'runningclass':     'innerfade',
            'children':         null,
			'autoStop':			'no',  //是否在播放结束后停止
			'reloadWeb':		null,//播放结束后需要转跳的网址
			'replayLeft':		'70%',//重播按钮位置与图片链接
			'replayTop':		'15%',
			'replayImgURL':		null,
			'startIndex':		0,//开始的图片，默认从第一张开始
			'insertFuncPos':	-1,
			'insertFunc': 		null,//第5张结束后的动画
			'setTimePicNo':		-1,//单独设置图片的编号，需要-1
			'setPictime':		0//单独设置的停留时间
        };
		
        if (options)
            $.extend(settings, options);
        if (settings.children === null)
            var elements = $(container).children();
        else
            var elements = $(container).children(settings.children);
        if (elements.length > 1) {
            $(container).css('position', 'relative').css('height', settings.containerheight).addClass(settings.runningclass);
            for (var i = 0; i < elements.length; i++) {
                $(elements[i]).css('z-index', String(elements.length-i)).css('position', 'absolute').hide();
            };
            if (settings.type == "sequence") {
                setTimeout(function() {
                    $.innerfade.next(elements, settings, settings.startIndex+1, settings.startIndex);
                }, settings.timeout);
                $(elements[settings.startIndex]).show();
            } else if (settings.type == "random") {
            	var last = Math.floor ( Math.random () * ( elements.length ) );
                setTimeout(function() {
                    do { 
						current = Math.floor ( Math.random ( ) * ( elements.length ) );
					} while (last == current );             
					$.innerfade.next(elements, settings, current, last);
                }, settings.timeout);
                $(elements[last]).show();
			} else if ( settings.type == 'random_start' ) {
				settings.type = 'sequence';
				var current = Math.floor ( Math.random () * ( elements.length ) );
				setTimeout(function(){
					$.innerfade.next(elements, settings, (current + 1) %  elements.length, current);
				}, settings.timeout);
				$(elements[current]).show();
			}	else {
				alert('Innerfade-Type must either be \'sequence\', \'random\' or \'random_start\'');
			}
		}
    };

    $.innerfade.next = function(elements, settings, current, last) {
		
		
		
		if(current==0 && settings.autoStop == "yes"){
			var replayDiv = document.createElement('div');
			replayDiv.style.top = ""+settings.replayTop;
			replayDiv.style.left = ""+settings.replayLeft;
			replayDiv.style.zIndex = "5000";
			replayDiv.style.position = "absolute";

			var replayA = document.createElement('a');
			replayA.href = ""+settings.reloadWeb;
			
			var replayImg = document.createElement('img');
			replayImg.src = ""+settings.replayImgURL;
			
			replayA.appendChild(replayImg);
			replayDiv.appendChild(replayA);

			document.body.appendChild(replayDiv);
			

			return;
		}
        if (settings.animationtype == 'slide') {
            $(elements[last]).slideUp(settings.speed);
            $(elements[current]).slideDown(settings.speed);
        } else if (settings.animationtype == 'fade') {
            $(elements[last]).fadeOut(settings.speed);
            $(elements[current]).fadeIn(settings.speed, function() {
							removeFilter($(this)[0]);
						});
        } else
            alert('Innerfade-animationtype must either be \'slide\' or \'fade\'');
        if (settings.type == "sequence") {
            if ((current + 1) < elements.length) {
                current = current + 1;
                last = current - 1;
            } else {
				current = 0;
                last = elements.length - 1;
            }
        } else if (settings.type == "random") {
            last = current;
            while (current == last)
                current = Math.floor(Math.random() * elements.length);
        } else
            alert('Innerfade-Type must either be \'sequence\', \'random\' or \'random_start\'');
        
		if(current == settings.setTimePicNo){
			setTimeout((function() {
				$.innerfade.next(elements, settings, current, last);
			}), settings.setPictime);
		}else{
			setTimeout((function() {
				$.innerfade.next(elements, settings, current, last);
			}), settings.timeout);
		}
		
		if(current ==settings.insertFuncPos-1){
		
			if(current == settings.setTimePicNo){
				setTimeout( (function() {
					settings.insertFunc();
				}),settings.setPictime);
			}else{
				setTimeout( (function() {
					settings.insertFunc();
				}),settings.timeout);
			}
		}
    };

})(jQuery);

// **** remove Opacity-Filter in ie ****
function removeFilter(element) {
	if(element.style.removeAttribute){
		element.style.removeAttribute('filter');
	}
}
