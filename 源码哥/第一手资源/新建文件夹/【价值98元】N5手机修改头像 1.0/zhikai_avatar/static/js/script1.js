$(function(){

    $(document).on('tap','ul>li:first>a', function() {
        $('#reset_name').fadeIn();
        $('#reset_name>span').text(lang._32);
    });

    $('header>div>img').on('tap',function() {
        var big_avatar = jsvar['avatar_big']+'&rand='+Math.random()*1000;
        $('body').append('<div id="view_avatar"><img src="'+big_avatar+'"><a><i class="icon iconfont">X</i></a></div>');
        $('#view_avatar').fadeIn();
    });

    $(document).on('tap','#view_avatar',function() {
        $(this).fadeOut(function() {
            $(this).remove();
        });
    });

    $('header>div').fadeIn('slow',function(){
        $('header>div>a').animate({top:'67px'});
    });

})