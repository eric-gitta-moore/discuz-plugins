<?php echo '源码哥商业模板保护！下载获取正版模板请访问源码哥官网：www.fx8.cc';exit;?>
<!--{if $wk_service}-->
<link href="$_G['style']['styleimgdir']/service/service.css" rel="stylesheet" type="text/css" />

<div class="main-im">
  <div id="open_im" class="open-im">&nbsp;</div>  
  <div class="im_main" id="im_main">
    <div id="close_im" class="close-im"><a href="javascript:void(0);" title="$week_lang[21]">&nbsp;</a></div>
    <a href="http://wpa.qq.com/msgrd?v=3&uin=$week_lang[23]&site=qq&menu=yes" target="_blank" class="im-qq qq-a" title="$week_lang[22]">
        <div class="qq-container"></div>
        <div class="qq-hover-c"><img class="img-qq" src="$_G['style']['styleimgdir']/service/images/qq.png"></div>
        <span>$week_lang[24]</span>
    </a>
    <div class="im-tel">
      <dt>$week_lang[25]</dt>
      <dt class="tel-num">$week_lang[26]</dt>
      <dt>$week_lang[27]</dt>
      <dt class="tel-num">$week_lang[28]</dt>
    </div>
    <div class="im-footer" style="position:relative">
      <div class="weixing-container">
        <div class="weixing-show">
          <div class="weixing-txt">$week_lang[29]</div>
          <img class="weixing-ma" src="$_G['style']['styleimgdir']/weixin.jpg">
          <div class="weixing-sanjiao"></div>
          <div class="weixing-sanjiao-big"></div>
        </div>
      </div>
      <div class="go-top"><a href="javascript:;" title="$week_lang[30]"></a> </div>
	 <div style="clear:both"></div>
    </div>
  </div>
</div>

<script type="text/javascript">
FOM(function(){
	FOM('#close_im').bind('click',function(){
		FOM('#main-im').css("height","0");
		FOM('#im_main').hide();
		FOM('#open_im').show();
	});
	FOM('#open_im').bind('click',function(e){
		FOM('#main-im').css("height","272");
		FOM('#im_main').show();
		FOM(this).hide();
	});
	FOM('.go-top').bind('click',function(){
		FOM(window).scrollTop(0);
	});
	FOM(".weixing-container").bind('mouseenter',function(){
		FOM('.weixing-show').show();
	})
	FOM(".weixing-container").bind('mouseleave',function(){        
		FOM('.weixing-show').hide();
	});
});
</script>
<!--{/if}-->