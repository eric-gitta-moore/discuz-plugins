jQuery(document).ready(function(){

    jQuery('.modalLink').modal({
        trigger: '.modalLink',          // id or class of link or button to trigger modal
        olay:'div.overlay',             // id or class of overlay
        modals:'div.modal',             // id or class of modal
        animationEffect: 'fadeIn',   // overlay effect | slideDown or fadeIn | default=fadeIn
        animationSpeed: 100,            // speed of overlay in milliseconds | default=400
        moveModalSpeed: 'fast',         // speed of modal movement when window is resized | slow or fast | default=false
        background: '000',           // hexidecimal color code - DONT USE #
        opacity: 0.5,                   // opacity of modal |  0 - 1 | default = 0.8
        openOnLoad: false,              // open modal on page load | true or false | default=false
        docClose: true,                 // click document to close | true or false | default=true    
        closeByEscape: true,            // close modal by escape key | true or false | default=true
        moveOnScroll: true,             // move modal when window is scrolled | true or false | default=false
        resizeWindow: true,             // move modal when window is resized | true or false | default=false
        video: 'http://player.vimeo.com/video/2355334?color=eb5a3d',    // enter the url of the video
        videoClass:'video',             // class of video element(s)
        close:'.closeBtn'               // id or class of close button
    });
});
jQuery(document).ready(function(){

    jQuery('.lbox').locabox({
            trigger: '.lbox',
            olay: 'div.overlay',
            locaboxs: 'div.locabox',
            animationEffect: 'fadeIn',
            animationSpeed: 100,
            movelocaboxSpeed: 'fast',
            background: '000',
            opacity: 0.5,
            openOnLoad: false,
            docClose: true,
            closeByEscape: true,
            moveOnScroll: true,
            resizeWindow: true,
            video:'',
            videoClass:'video',
            close:'.closeBtn'
    });
});
jQuery(document).ready(function(){

    jQuery('.lbox').locabox({
            trigger: '.lbox',
            olay: 'div.overlay',
            locaboxs: 'div.locabox',
            animationEffect: 'fadeIn',
            animationSpeed: 100,
            movelocaboxSpeed: 'fast',
            background: '000',
            opacity: 0.5,
            openOnLoad: false,
            docClose: true,
            closeByEscape: true,
            moveOnScroll: true,
            resizeWindow: true,
            video:'',
            videoClass:'video',
            close:'.closeBtn'
    });
});

jQuery(document).ready(function(){

    jQuery('.sort').sortbox({
            trigger: '.sort',
            olay: 'div.overlay',
            sortboxs: 'div.sortbox',
            animationEffect: 'fadeIn',
            animationSpeed: 100,
            movesortboxSpeed: 'fast',
            background: '000',
            opacity: 0.5,
            openOnLoad: false,
            docClose: true,
            closeByEscape: true,
            moveOnScroll: true,
            resizeWindow: true,
            video:'',
            videoClass:'video',
            close:'.closeBtn'
    });
});