//      Pop Easy | jQuery Modal Plugin
//      Version 1.0
//      Created 2013 by Thomas Grauer
///////////////////////////////////////////////////////////////////////////////////////
//      Permission is hereby granted, free of charge, to any person obtaining
//      a copy of this software and associated documentation files (the
//      "Software"), to deal in the Software without restriction, including
//      without limitation the rights to use, copy, modify, merge, publish,
//      distribute, sublicense, and/or sell copies of the Software, and to
//      permit persons to whom the Software is furnished to do so, subject to
//      the following conditions:
//
//      The above copyright notice and this permission notice shall be
//      included in all copies or substantial portions of the Software.
//
//      THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
//      EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
//      MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
//      NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE
//      LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION
//      OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION
//      WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
///////////////////////////////////////////////////////////////////////////////////////

(function($){

    $.fn.modal= function(options){
       
        options = $.extend({
            trigger: '.modalLink',
            olay: 'div.overlay',
            modals: 'div.modal',
            animationEffect: 'fadeIn',
            animationSpeed: 400,
            moveModalSpeed: 'slow',
            background: '000',
            opacity: 0.8,
            openOnLoad: false,
            docClose: true,
            closeByEscape: true,
            moveOnScroll: true,
            resizeWindow: true,
            video:'',
            videoClass:'video',
            close:'.closeBtn'
            
        },options);
       
        var olay = $(options.olay);
        var modals = $(options.modals);
        var currentModal;
        var isopen=false;
       
        if (options.animationEffect==='fadein'){options.animationEffect = 'fadeIn';}
        if (options.animationEffect==='slidedown'){options.animationEffect = 'slideDown';}
        
        olay.css({opacity : 0});
                
        if(options.openOnLoad) {
            openModal();
        }else{
            olay.hide();
            modals.hide();
        }
        
        $(options.trigger).bind('click', function(e){
            e.preventDefault();
            
            if ($('.modalLink').length >1) {
                getModal = $(this).attr('href');
                currentModal = $(getModal);    
            }else{
                currentModal = $('.modal');
            }
            openModal();
        });
        
        function openModal(){
            $('.' + options.videoClass).attr('src',options.video);
            modals.hide();
            currentModal.css({
                top:$(window).height() /2 - currentModal.outerHeight() /2 + $(window).scrollTop(),
                left:$(window).width() /2 - currentModal.outerWidth() /2 + $(window).scrollLeft()
            });
                
            if(isopen===false){
                olay.css({opacity : options.opacity, backgroundColor: '#'+options.background});
                olay[options.animationEffect](options.animationSpeed);
                currentModal.delay(options.animationSpeed)[options.animationEffect](options.animationSpeed); 
            }else{
                currentModal.show();
            }
            
            isopen=true;
        }
        
        function moveModal(){
            modals
            .stop(true)
            .animate({
            top:$(window).height() /2 - modals.outerHeight() /2 + $(window).scrollTop(),
            left:$(window).width() /2 - modals.outerWidth() /2 + $(window).scrollLeft()
            },options.moveModalSpeed);
        }
        
        function closeModal(){
            $('.' + options.videoClass).attr('src',''); 
            isopen=false;
            modals.fadeOut(100, function(){
                if (options.animationEffect === 'slideDown') {
                    olay.slideUp();
                }else if (options.animationEffect === 'fadeIn') {
                    olay.fadeOut();
                }
            });
            return false;
        }
        
        if(options.docClose){
            olay.bind('click', closeModal);
        }
        
        $(options.close).bind('click', closeModal);
        
        if (options.closeByEscape) {
            $(window).bind('keyup', function(e){
                if(e.which === 27){
                    closeModal();
                }
            });
        }
        
        if (options.resizeWindow) {
            $(window).bind('resize', moveModal);
        }else{
            return false;
        }
        
        if (options.moveOnScroll) {
            $(window).bind('scroll', moveModal);
        }else{
            return false;
        }
    };
})(jQuery);

(function($){

    $.fn.locabox= function(options){
       
        options = $.extend({
            trigger: '.lbox',
            olay: 'div.overlay',
            locaboxs: 'div.locabox',
            animationEffect: 'fadeIn',
            animationSpeed: 400,
            movelocaboxSpeed: 'slow',
            background: '000',
            opacity: 0.8,
            openOnLoad: false,
            docClose: true,
            closeByEscape: true,
            moveOnScroll: true,
            resizeWindow: true,
            video:'',
            videoClass:'video',
            close:'.closeBtn'
            
        },options);
       
        var olay = $(options.olay);
        var locaboxs = $(options.locaboxs);
        var currentlocabox;
        var isopen=false;
       
        if (options.animationEffect==='fadein'){options.animationEffect = 'fadeIn';}
        if (options.animationEffect==='slidedown'){options.animationEffect = 'slideDown';}
        
        olay.css({opacity : 0});
                
        if(options.openOnLoad) {
            openlocabox();
        }else{
            olay.hide();
            locaboxs.hide();
        }
        
        $(options.trigger).bind('click', function(e){
            e.preventDefault();
            
            if ($('.lbox').length >1) {
                getlocabox = $(this).attr('href');
                currentlocabox = $(getlocabox);    
            }else{
                currentlocabox = $('.locabox');
            }
            openlocabox();
        });
        
        function openlocabox(){
            $('.' + options.videoClass).attr('src',options.video);
            locaboxs.hide();
            currentlocabox.css({
                top:$(window).height() /2 - currentlocabox.outerHeight() /2 + $(window).scrollTop(),
                left:$(window).width() /2 - currentlocabox.outerWidth() /2 + $(window).scrollLeft()
            });
                
            if(isopen===false){
                olay.css({opacity : options.opacity, backgroundColor: '#'+options.background});
                olay[options.animationEffect](options.animationSpeed);
                currentlocabox.delay(options.animationSpeed)[options.animationEffect](options.animationSpeed); 
            }else{
                currentlocabox.show();
            }
            
            isopen=true;
        }
        
        function movelocabox(){
            locaboxs
            .stop(true)
            .animate({
            top:$(window).height() /2 - locaboxs.outerHeight() /2 + $(window).scrollTop(),
            left:$(window).width() /2 - locaboxs.outerWidth() /2 + $(window).scrollLeft()
            },options.movelocaboxSpeed);
        }
        
        function closelocabox(){
            $('.' + options.videoClass).attr('src',''); 
            isopen=false;
            locaboxs.fadeOut(100, function(){
                if (options.animationEffect === 'slideDown') {
                    olay.slideUp();
                }else if (options.animationEffect === 'fadeIn') {
                    olay.fadeOut();
                }
            });
            return false;
        }
        
        if(options.docClose){
            olay.bind('click', closelocabox);
        }
        
        $(options.close).bind('click', closelocabox);
        
        if (options.closeByEscape) {
            $(window).bind('keyup', function(e){
                if(e.which === 27){
                    closelocabox();
                }
            });
        }
        
        if (options.resizeWindow) {
            $(window).bind('resize', movelocabox);
        }else{
            return false;
        }
        
        if (options.moveOnScroll) {
            $(window).bind('scroll', movelocabox);
        }else{
            return false;
        }
    };
})(jQuery);

(function($){

    $.fn.sortbox= function(options){
       
        options = $.extend({
            trigger: '.sort',
            olay: 'div.overlay',
            sortboxs: 'div.sortbox',
            animationEffect: 'fadeIn',
            animationSpeed: 400,
            movesortboxSpeed: 'slow',
            background: '000',
            opacity: 0.8,
            openOnLoad: false,
            docClose: true,
            closeByEscape: true,
            moveOnScroll: true,
            resizeWindow: true,
            video:'',
            videoClass:'video',
            close:'.closeBtn'
            
        },options);
       
        var olay = $(options.olay);
        var sortboxs = $(options.sortboxs);
        var currentsortbox;
        var isopen=false;
       
        if (options.animationEffect==='fadein'){options.animationEffect = 'fadeIn';}
        if (options.animationEffect==='slidedown'){options.animationEffect = 'slideDown';}
        
        olay.css({opacity : 0});
                
        if(options.openOnLoad) {
            opensortbox();
        }else{
            olay.hide();
            sortboxs.hide();
        }
        
        $(options.trigger).bind('click', function(e){
            e.preventDefault();
            
            if ($('.sort').length >1) {
                getsortbox = $(this).attr('href');
                currentsortbox = $(getsortbox);    
            }else{
                currentsortbox = $('.sortbox');
            }
            opensortbox();
        });
        
        function opensortbox(){
            $('.' + options.videoClass).attr('src',options.video);
            sortboxs.hide();
            currentsortbox.css({
                top:$(window).height() /2 - currentsortbox.outerHeight() /2 + $(window).scrollTop(),
                left:$(window).width() /2 - currentsortbox.outerWidth() /2 + $(window).scrollLeft()
            });
                
            if(isopen===false){
                olay.css({opacity : options.opacity, backgroundColor: '#'+options.background});
                olay[options.animationEffect](options.animationSpeed);
                currentsortbox.delay(options.animationSpeed)[options.animationEffect](options.animationSpeed); 
            }else{
                currentsortbox.show();
            }
            
            isopen=true;
        }
        
        function movesortbox(){
            sortboxs
            .stop(true)
            .animate({
            top:$(window).height() /2 - sortboxs.outerHeight() /2 + $(window).scrollTop(),
            left:$(window).width() /2 - sortboxs.outerWidth() /2 + $(window).scrollLeft()
            },options.movesortboxSpeed);
        }
        
        function closesortbox(){
            $('.' + options.videoClass).attr('src',''); 
            isopen=false;
            sortboxs.fadeOut(100, function(){
                if (options.animationEffect === 'slideDown') {
                    olay.slideUp();
                }else if (options.animationEffect === 'fadeIn') {
                    olay.fadeOut();
                }
            });
            return false;
        }
        
        if(options.docClose){
            olay.bind('click', closesortbox);
        }
        
        $(options.close).bind('click', closesortbox);
        
        if (options.closeByEscape) {
            $(window).bind('keyup', function(e){
                if(e.which === 27){
                    closesortbox();
                }
            });
        }
        
        if (options.resizeWindow) {
            $(window).bind('resize', movesortbox);
        }else{
            return false;
        }
        
        if (options.moveOnScroll) {
            $(window).bind('scroll', movesortbox);
        }else{
            return false;
        }
    };
})(jQuery);
