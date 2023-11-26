<?PHP exit('QQÈº£º550494646');?>
<div class="ainuo_usernav cl">
    <div id="usernav" class="swiper-container-horizontal swiper-container-free-mode">
          	<ul class="swiper-wrapper">
            		<!--{if empty($personalnv['banitems']['profile'])}-->
                    <li class="swiper-slide{if $_GET[do] == 'profile'} a{/if}"><a href="home.php?mod=space&uid=$space[uid]&do=profile">$alang_ziliao</a></li>
                    <!--{/if}-->
                    <!--{if empty($personalnv['banitems']['feed']) && helper_access::check_module('feed')}-->
                    <li class="swiper-slide{if $_GET[do] == 'home'} a{/if}"><a href="home.php?mod=space&uid=$space[uid]&do=home&view=me&from=space"><!--{if !empty($personalnv['items']['feed'])}-->$personalnv['items']['feed']<!--{else}-->{lang feed}<!--{/if}--></a></li>
                    <!--{/if}-->
                    <!--{if $_G['setting']['allowviewuserthread'] !== false && (empty($personalnv['banitems']['topic']))}-->
                    <li class="swiper-slide{if $_GET[do] == 'thread'} a{/if}"><a href="home.php?mod=space&uid=$space[uid]&do=thread&view=me&from=space"><!--{if !empty($personalnv['items']['topic'])}-->$personalnv['items']['topic']<!--{else}-->{lang topic}<!--{/if}--></a></li>
                    <!--{/if}--><!--Fr om w ww.moq u8 .com -->
                    <!--{if empty($personalnv['banitems']['doing']) && helper_access::check_module('doing')}-->
                    <li class="swiper-slide{if $_GET[do] == 'doing'} a{/if}"><a href="home.php?mod=space&uid=$space[uid]&do=doing&view=me&from=space"><!--{if !empty($personalnv['items']['doing'])}-->$personalnv['items']['doing']<!--{else}-->{lang doing}<!--{/if}--></a></li>
                    <!--{/if}-->
                    <!--{if empty($personalnv['banitems']['blog']) && helper_access::check_module('blog')}-->
                    <li class="swiper-slide{if $_GET[do] == 'blog'} a{/if}"><a href="home.php?mod=space&uid=$space[uid]&do=blog&view=me&from=space"><!--{if !empty($personalnv['items']['blog'])}-->$personalnv['items']['blog']<!--{else}-->{lang blog}<!--{/if}--></a></li>
                    <!--{/if}-->
                    <!--{if empty($personalnv['banitems']['album']) && helper_access::check_module('album')}-->
                    <li class="swiper-slide{if $_GET[do] == 'album'} a{/if}"><a href="home.php?mod=space&uid=$space[uid]&do=album&view=me&from=space"><!--{if !empty($personalnv['items']['album'])}-->$personalnv['items']['album']<!--{else}-->{lang album}<!--{/if}--></a></li>
                    <!--{/if}-->
                    <!--{if empty($personalnv['banitems']['follow']) && helper_access::check_module('follow')}-->
                    <li class="swiper-slide{if $_GET[mod] == 'follow' && $_GET[do] == 'view'} a{/if}"><a href="home.php?mod=follow&uid=$space[uid]&do=view"><!--{if !empty($personalnv['items']['follow'])}-->$personalnv['items']['follow']<!--{else}-->{lang follow}<!--{/if}--></a></li>
                    <!--{/if}-->
                    
                   
                    <!--{if empty($personalnv['banitems']['wall']) && helper_access::check_module('wall')}-->
                    <li class="swiper-slide{if $_GET[do] == 'wall'} a{/if}"><a href="home.php?mod=space&uid=$space[uid]&do=wall">$alang_liuyan</a></li>
                    <!--{/if}-->
                    

            </ul>
    </div>
</div>


<script type="text/javascript">
if($("#usernav .a").length > 0) {
	var ainuo_first = $("#usernav .a").offset().left + $("#usernav .a").width() >= $(window).width() ? $("#usernav .a").index() : 0;
}else{
	var ainuo_first = 0;
}	
mySwiper = new Swiper('#usernav', {
	freeMode : true,
	slidesPerView : 'auto',
	initialSlide : ainuo_first,
});
</script>

<div class="grey_line cl"></div>