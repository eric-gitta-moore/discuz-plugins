<?php exit;?>
<!--{hook/global_footer_mobile}-->
<!--{eval $useragent = strtolower($_SERVER['HTTP_USER_AGENT']);$clienturl = ''}-->
<!--{if strpos($useragent, 'iphone') !== false || strpos($useragent, 'ios') !== false}-->
<!--{eval $clienturl = $_G['cache']['mobileoem_data']['iframeUrl'] ? $_G['cache']['mobileoem_data']['iframeUrl'].'&platform=ios' : 'http://www.discuz.net/mobile.php?platform=ios';}-->
<!--{elseif strpos($useragent, 'android') !== false}-->
<!--{eval $clienturl = $_G['cache']['mobileoem_data']['iframeUrl'] ? $_G['cache']['mobileoem_data']['iframeUrl'].'&platform=android' : 'http://www.discuz.net/mobile.php?platform=android';}-->
<!--{elseif strpos($useragent, 'windows phone') !== false}-->
<!--{eval $clienturl = $_G['cache']['mobileoem_data']['iframeUrl'] ? $_G['cache']['mobileoem_data']['iframeUrl'].'&platform=windowsphone' : 'http://www.discuz.net/mobile.php?platform=windowsphone';}-->
<!--{/if}-->
<div id="mask" style="display:none;"></div>
<script>
$(function(){
	$(window).on('scroll', function(){
		if($(window).scrollTop() > 10){
			$('.n5qj_tbys').removeClass('large').addClass('small');
		} else {
			$('.n5qj_tbys').removeClass('small').addClass('large');
		}
	});
});
</script>
{if $n5app['kqxhyctw']}
<script type="text/javascript">
var jq = jQuery.noConflict(); 
jq(function(){     
    var cubuk_seviye = jq(document).scrollTop();  
	var header_yuksekligi = jq('.n5qj_tbys').outerHeight();
    var header_yuksekligi = jq('.n5qj_wbys').outerHeight();  
	var header_yuksekligi = jq('.n5sq_nrdb').outerHeight();  
	var header_yuksekligi = jq('.n5sq_flfb').outerHeight();  
	var header_yuksekligi = jq('.wbys_yqmb').outerHeight(); 
    jq(window).scroll(function() {  
        var kaydirma_cubugu = jq(document).scrollTop();  //From w ww.ymg 6.com

        if (kaydirma_cubugu > header_yuksekligi){jq('.n5qj_wbys').addClass('n5qj_wbysy');}   
        else {jq('.n5qj_wbys').removeClass('n5qj_wbysy');}  
        if (kaydirma_cubugu > cubuk_seviye){jq('.n5qj_wbys').removeClass('n5qj_wbysx');}   
        else {jq('.n5qj_wbys').addClass('n5qj_wbysx');} 
		
		if (kaydirma_cubugu > header_yuksekligi){jq('.n5sq_nrdb').addClass('n5sq_nrdby');}   
        else {jq('.n5sq_nrdb').removeClass('n5sq_nrdby');}  
        if (kaydirma_cubugu > cubuk_seviye){jq('.n5sq_nrdb').removeClass('n5sq_nrdbx');}   
        else {jq('.n5sq_nrdb').addClass('n5sq_nrdbx');}  
		
		if (kaydirma_cubugu > header_yuksekligi){jq('.n5qj_tbys').addClass('n5qj_tbysy');}   
        else {jq('.n5qj_tbys').removeClass('n5qj_tbysy');}  
        if (kaydirma_cubugu > cubuk_seviye){jq('.n5qj_tbys').removeClass('n5qj_tbysx');}   
        else {jq('.n5qj_tbys').addClass('n5qj_tbysx');} 
		
		if (kaydirma_cubugu > header_yuksekligi){jq('.n5sq_flfb').addClass('n5sq_flfby');}   
        else {jq('.n5sq_flfb').removeClass('n5sq_flfby');}  
        if (kaydirma_cubugu > cubuk_seviye){jq('.n5sq_flfb').removeClass('n5sq_flfbx');}   
        else {jq('.n5sq_flfb').addClass('n5sq_flfbx');} //From ww w.ymg6.co m 
		
		if (kaydirma_cubugu > header_yuksekligi){jq('.wbys_yqmb').addClass('wbys_yqmby');}   
        else {jq('.wbys_yqmb').removeClass('wbys_yqmby');}  
        if (kaydirma_cubugu > cubuk_seviye){jq('.wbys_yqmb').removeClass('wbys_yqmbx');}   
        else {jq('.wbys_yqmb').addClass('wbys_yqmbx');}
		
        cubuk_seviye = jq(document).scrollTop();   
     });  
});  
</script>
{/if}
<div style="display: none;"><span><input type="radio" name="modal" id="t1" class="regular-checkbox" /><label for="t1"></label></span><span><input type="radio" name="modal" id="t2" class="regular-checkbox" /><label for="t2"></label></span><span><input type="radio" name="modal" id="t3" class="regular-checkbox" /><label for="t3"></label></span><span><input type="radio" name="modal" id="t4" class="regular-checkbox" /><label for="t4"></label></span><span><input type="radio" name="modal" id="t5" class="regular-checkbox" /><label for="t5"></label></span><span><input type="radio" name="modal" id="t6" class="regular-checkbox" /><label for="t6"></label></span></div>
<script type="text/javascript">
    var rememberObj = {
        keepDays: 30,//保存天数
        modalStyleToggle: function () {
            var modal = document.getElementsByName('modal');
            var _this = this;
            if (!localStorage.modalStyle) {//如果用户没有进行设置就默认使用白天模式
                document.getElementById('{$n5app['ztfgxz']}').checked = true;
                toggleStyle('{$n5app['ztfgxz']}');
            } else {//如果用户进行了设置就使用用户设置的模式
                document.getElementById(localStorage.modalStyle).checked = true;
                toggleStyle(localStorage.modalStyle);
            }//Fro m www.xhkj5.com
            for (var i = 0; i < modal.length; i++) {//点击radio选项切换并记住style
                modal[i].onclick = function () {
                    toggleStyle(this.id);
                    localStorage.modalStyle = this.id;
                    localStorage.lastTime = parseInt(new Date() / 1000);
                }
            }
            function toggleStyle(modal) {//切换样式函数
                var modalStyle = document.getElementsByClassName('modal-style')[0];
                var cssPath = 'template/zhikai_n5app/style/' + modal + '/style.css'
                if (modalStyle) {//如果页面已经加载了相关css
                    modalStyle.setAttribute('href', cssPath);
                } else {//如果没有加载
                    var head = document.getElementsByTagName('head')[0];
                    var link = document.createElement('link');
                    link.setAttribute('rel', 'stylesheet');
                    link.setAttribute('type', 'text/css');
                    link.setAttribute('class', 'modal-style');
                    link.setAttribute('href', cssPath);
                    head.appendChild(link);
                }
            }//From ww w.ymg6.c om
            if (localStorage.lastTime) {//计时重置用户设置
                var passTime = parseInt(new Date() / 1000) - Number(localStorage.lastTime);
                if (passTime / 3600 / 24 > _this.keepDays) {//如果从第一次设置计时算起到现在已经过keepDays天，重置用户设置
                    localStorage.lastTime = '';
                    localStorage.modalStyle = '';
                }
            }
        }
    };
    rememberObj.modalStyleToggle();
</script>
</body>
</html>
<!--{eval updatesession();}-->
<!--{if defined('IN_MOBILE')}-->
	<!--{eval function_exists('huoyue_mobile_rewrite') ? huoyue_mobile_rewrite() : '';}-->
	<!--{eval output();}-->
<!--{else}-->
	<!--{eval output_preview();}-->
<!--{/if}-->