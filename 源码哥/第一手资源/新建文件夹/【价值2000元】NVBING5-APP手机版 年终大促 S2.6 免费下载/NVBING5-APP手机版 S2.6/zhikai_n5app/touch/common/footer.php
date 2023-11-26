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
{if $n5app['glykzgn']}
<!--{eval include_once DISCUZ_ROOT.'./source/plugin/zhikai_n5appgl/nvbing5_tphc.php'}-->
{/if}
{if strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'micromessenger')}
<!--{eval include_once DISCUZ_ROOT.'./source/plugin/zhikai_n5appgl/nvbing5_footer.php'}-->
{/if}
<div id="mask" style="display:none;"></div>
<div class="n5app_ywjl"></div>
<div class="bgDiv"></div>
{if $n5app['ymjzxgkq']}
<div id="bonfire-pageloader">
	<div class="n5qj_jzyss"><svg class="circulars" viewBox="25 25 50 50"><circle class="paths" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10"></circle></svg><p>{$n5app['lang']['qjjztbwz']}</p></div>
</div>
<script src="template/zhikai_n5app/js/pageloader.js" type="text/javascript"></script>
<script>
jQuery(window).resize(function(){
	 resizenow();
});
function resizenow() {
	var browserwidth = jQuery(window).width();
	var browserheight = jQuery(window).height();
	jQuery('.bonfire-pageloader-icon').css('right', ((browserwidth - jQuery(".bonfire-pageloader-icon").width())/2)).css('top', ((browserheight - jQuery(".bonfire-pageloader-icon").height())/2));
};//From w ww.xhkj5.com
resizenow();
</script>
{/if}

<script>
var jq = jQuery.noConflict(); 
jq(function(){
	jq(window).on('scroll', function(){
		if(jq(window).scrollTop() > 10){
			jq('.n5qj_tbys').removeClass('large').addClass('small');
		} else {
			jq('.n5qj_tbys').removeClass('small').addClass('large');
		}
	});//Fro m www.xhkj 5.com
});
</script>
{if strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'micromessenger')}
{if $n5app['wxydgz']}
<div class="n5qj_wxgzlj cl">
	<div class="wxgzlj_logo z cl"><img src="{$n5app['wxlogo']}"></div>
	<div class="wxgzlj_mcjj z cl">
		<h2>{$n5app['wxmc']}</h2>
		<p><!--{echo cutstr({$n5app['wxjs']},30)}--></p>
	</div>
	<div class="wxgzlj_gzan y cl">
		<a href="{$n5app['wxgzlj']}" style="background: {$n5app['gzanys']}">{$n5app['lang']['wxydgzanwz']}</a>
	</div>
</div>
<script>
var jq = jQuery.noConflict(); 
jq(function(){
	jq(window).on('scroll', function(){
		if(jq(window).scrollTop() > 100){
			jq('.n5qj_wxgzlj').removeClass('large1').addClass('small1');
		} else {
			jq('.n5qj_wxgzlj').removeClass('small1').addClass('large1');
		}
	});
});
</script>
{/if}
{/if}
<script src="template/zhikai_n5app/js/top.js"></script> 
<a href="javascript:void(0);" class="n5qj_top"></a>

<div class="n5sq_ksfb cl">
	<div class="ksfb_sjys cl">
		<div class="date-wrap">
			<li class="left"><span class="day"></span></li>
			<li class="middle">
				<p class="weekday"></p>
				<p class="division">/</p>
				<p class="yearmonth"><span class="year"><i class="year_num"></i>{$n5app['lang']['ksfbrqn']}</span><span class="month"><i class="month_num"></i>{$n5app['lang']['ksfbrqy']}</span></p>
			</li>
			<li class="right"><span class="lunar"><i class="lunar_month">{$n5app['lang']['ksfbsjnlc']}</i><i class="lunar_day">{$n5app['lang']['ksfbsjnlss']}</i></span></li>
		</div>
	</div>
	{if $n5app['ksfbgg']}
	<div class="ksfb_ggzs cl">
		<a href="{$n5app['ksfbgglj']}"><em>{$n5app['lang']['ksfbrqtg']}</em><img src="{$n5app['ksfbggtp']}" width="100%"></a>
	</div>
	{/if}
	<div class="ksfb_fban cl">
		<ul>
			<li><a href="{$n5app['sign']}"><img nodata-echo="yes" src="template/zhikai_n5app/images/ksfb_qd.png"><p>{$n5app['lang']['qjywkfqqd']}</p></a></li>
			<li><a href="{$n5app['baoliao']}"><img nodata-echo="yes" src="template/zhikai_n5app/images/ksfb_bl.png"><p>{$n5app['lang']['qjywkfybl']}</p></a></li>
			<li><a href="forum.php?mod=misc&action=nav&mobile=2"><img nodata-echo="yes" src="template/zhikai_n5app/images/ksfb_tz.png"><p>{$n5app['lang']['fatiezi']}</p></a></li>
			<li><a href="group.php"><img nodata-echo="yes" src="template/zhikai_n5app/images/ksfb_rw.png"><p>{$n5app['lang']['qjywkflht']}</p></a></li>
			<li><a href="home.php?mod=follow&mobile=2" {if $_G['uid']}{else}class="n5app_wdlts"{/if}><img nodata-echo="yes" src="template/zhikai_n5app/images/ksfb_ht.png"><p>{$n5app['lang']['liaohuati']}</p></a></li>
			<li><a href="home.php?mod=space&do=doing&view=me&mobile=2"><img nodata-echo="yes" src="template/zhikai_n5app/images/ksfb_ss.png"><p>{$n5app['lang']['qjywkfxss']}</p></a></li>
			<li><a href="{$n5app['kankan']}"><img nodata-echo="yes" src="template/zhikai_n5app/images/ksfb_tp.png"><p>{$n5app['lang']['qjywkfkmt']}</p></a></li>
			<li><a href="home.php?mod=spacecp&ac=blog&mobile=2" {if $_G['uid']}{else}class="n5app_wdlts"{/if}><img nodata-echo="yes" src="template/zhikai_n5app/images/ksfb_rz.png"><p>{$n5app['lang']['xierizhi']}</p></a></li>
		</ul>
	</div>
	<button class="ksfb_qxan"></button>
</div>
<script type="text/javascript">
    window.onload = function () {
        var targetDay = '',
            date = targetDay ? new Date(targetDay) : new Date(),
            yy = date.getFullYear(), mm = date.getMonth() + 1, dd = date.getDate(), wd = date.getDay(),
            wdstr = '{$n5app['lang']['ksfbsjxqbz']}', wdarr = ['{$n5app['lang']['ksfbrqxr']}', '{$n5app['lang']['ksfbrqxy']}', '{$n5app['lang']['ksfbrqxe']}', '{$n5app['lang']['ksfbrqxs']}', '{$n5app['lang']['ksfbrqxa']}', '{$n5app['lang']['ksfbrqxw']}', '{$n5app['lang']['ksfbrqxl']}'],
            calendarData = [0xA4B, 0x5164B, 0x6A5, 0x6D4, 0x415B5, 0x2B6, 0x957, 0x2092F, 0x497, 0x60C96, 0xD4A, 0xEA5, 0x50DA9, 0x5AD, 0x2B6, 0x3126E, 0x92E, 0x7192D, 0xC95, 0xD4A, 0x61B4A, 0xB55, 0x56A, 0x4155B, 0x25D, 0x92D, 0x2192B, 0xA95, 0x71695, 0x6CA, 0xB55, 0x50AB5, 0x4DA, 0xA5B, 0x30A57, 0x52B, 0x8152A, 0xE95, 0x6AA, 0x615AA, 0xAB5, 0x4B6, 0x414AE, 0xA57, 0x526, 0x31D26, 0xD95, 0x70B55, 0x56A, 0x96D, 0x5095D, 0x4AD, 0xA4D, 0x41A4D, 0xD25, 0x81AA5, 0xB54, 0xB6A, 0x612DA, 0x95B, 0x49B, 0x41497, 0xA4B, 0xA164B, 0x6A5, 0x6D4, 0x615B4, 0xAB6, 0x957, 0x5092F, 0x497, 0x64B, 0x30D4A, 0xEA5, 0x80D65, 0x5AC, 0xAB6, 0x5126D, 0x92E, 0xC96, 0x41A95, 0xD4A, 0xDA5, 0x20B55, 0x56A, 0x7155B, 0x25D, 0x92D, 0x5192B, 0xA95, 0xB4A, 0x416AA, 0xAD5, 0x90AB5, 0x4BA, 0xA5B, 0x60A57, 0x52B, 0xA93, 0x40E95],
            madd = [0, 31, 59, 90, 120, 151, 181, 212, 243, 273, 304, 334],
            numString = '{$n5app['lang']['ksfbsjxqsz']}', monString = '{$n5app['lang']['ksfbsjxqnl']}',
            cYear, cMonth, cDay, TheDate,
            dateWrap = document.getElementsByClassName('date-wrap')[0],
            day = dateWrap.getElementsByClassName('day')[0],
            weekday = dateWrap.getElementsByClassName('weekday')[0],
            yearnum = dateWrap.getElementsByClassName('year_num')[0],
            monthnum = dateWrap.getElementsByClassName('month_num')[0],
            lunarmonth = dateWrap.getElementsByClassName('lunar_month')[0],
            lunarday = dateWrap.getElementsByClassName('lunar_day')[0];

        yy < 100 && (yy = '19' + yy);
        mm.length <= 2 && (mm = '0' + mm);
        dd.length <= 2 && (dd = '0' + dd);

        var lunarDate = getLunarDay(yy, mm, dd);

        day.innerHTML = dd;
        weekday.innerHTML = wdstr + wdarr[wd];
        yearnum.innerHTML = yy;
        monthnum.innerHTML = mm;
        lunarmonth.innerHTML = lunarDate.lunarMonth;
        lunarday.innerHTML = lunarDate.lunarDay;
        function getLunarDay(solarYear, solarMonth, solarDay) {
            if (solarYear < 1921 || solarYear > 2020) {
                return '';
            } else {
                solarMonth = (parseInt(solarMonth) > 0) ? (solarMonth - 1) : 11;
                en2cn(solarYear, solarMonth, solarDay);
                return getCnDateString();
            }
        }
        function getCnDateString() {
            var tmpMonth = '', tmpDay = '';
            if (cMonth < 1) {
                tmpMonth += '({$n5app['lang']['ksfbsjxqry']})';
                tmpMonth += monString.charAt(-cMonth - 1);
            } else {
                tmpMonth += monString.charAt(cMonth - 1);
            }
            tmpMonth += '{$n5app['lang']['ksfbrqy']}';
            tmpDay += (cDay < 11) ? '{$n5app['lang']['ksfbsjnlc']}' : ((cDay < 20) ? '{$n5app['lang']['ksfbsjnls']}' : ((cDay < 30) ? '{$n5app['lang']['ksfbsjnle']}' : '{$n5app['lang']['ksfbsjnlss']}'));
            if (cDay % 10 != 0 || cDay == 10) {
                tmpDay += numString.charAt((cDay - 1) % 10);
            }
            return {lunarMonth: tmpMonth, lunarDay: tmpDay};
        }
        function en2cn() {
            TheDate = (arguments.length != 3) ? new Date() : new Date(arguments[0], arguments[1], arguments[2]);
            var total, m, n, k;
            var isEnd = false;
            var tmp = TheDate.getYear();
            if (tmp < 1900) {
                tmp += 1900;
            }
            total = (tmp - 1921) * 365 + Math.floor((tmp - 1921) / 4) + madd[TheDate.getMonth()] + TheDate.getDate() - 38;

            if (TheDate.getYear() % 4 == 0 && TheDate.getMonth() > 1) {
                total++;
            }
            for (m = 0; ; m++) {
                k = (calendarData[m] < 0xfff) ? 11 : 12;
                for (n = k; n >= 0; n--) {
                    if (total <= 29 + getBit(calendarData[m], n)) {
                        isEnd = true;
                        break;
                    }
                    total = total - 29 - getBit(calendarData[m], n);
                }
                if (isEnd) {
                    break;
                }
            }
            cYear = 1921 + m;
            cMonth = k - n + 1;
            cDay = total;
            if (k == 12) {
                if (cMonth == Math.floor(calendarData[m] / 0x10000) + 1) {
                    cMonth = 1 - cMonth;
                }
                if (cMonth > Math.floor(calendarData[m] / 0x10000) + 1) {
                    cMonth--;
                }
            }
        }
        function getBit(m, n) {
            return (m >> n) & 1;
        }
    };
</script>


<script type="text/javascript">
$('.n5app_wdlts').on('click', function() {
popup.open('{lang nologin_tip}', 'confirm', 'member.php?mod=logging&action=login');
return false;
});
</script>

<script src="template/zhikai_n5app/js/echo.min.js"></script>
<script>
Echo.init({
	offset: 0,
	throttle: 0
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
	var header_yuksekligi = jq('.n5qj_ancd').outerHeight();
	var header_yuksekligi = jq('.n5qj_top').outerHeight();//Fro m www.xhkj5.com
    jq(window).scroll(function() {  
        var kaydirma_cubugu = jq(document).scrollTop();  

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
        else {jq('.n5sq_flfb').addClass('n5sq_flfbx');} //From www .xhkj5.com 
		
		if (kaydirma_cubugu > header_yuksekligi){jq('.wbys_yqmb').addClass('wbys_yqmby');}   
        else {jq('.wbys_yqmb').removeClass('wbys_yqmby');}  
        if (kaydirma_cubugu > cubuk_seviye){jq('.wbys_yqmb').removeClass('wbys_yqmbx');}   
        else {jq('.wbys_yqmb').addClass('wbys_yqmbx');}
		
		if (kaydirma_cubugu > header_yuksekligi){jq('.n5qj_ancd').addClass('n5qj_ancdy');}   
        else {jq('.n5qj_ancd').removeClass('n5qj_ancdy');}  
        if (kaydirma_cubugu > cubuk_seviye){jq('.n5qj_ancd').removeClass('n5qj_ancdx');}   
        else {jq('.n5qj_ancd').addClass('n5qj_ancdx');}
		
		if (kaydirma_cubugu > header_yuksekligi){jq('.n5qj_top').addClass('n5qj_topy');}   
        else {jq('.n5qj_top').removeClass('n5qj_topy');}  
        if (kaydirma_cubugu > cubuk_seviye){jq('.n5qj_top').removeClass('n5qj_topx');}   
        else {jq('.n5qj_top').addClass('n5qj_topx');}
		
        cubuk_seviye = jq(document).scrollTop();   
     });  
});  
</script>
{/if}
{if $n5app['sfkqqjzccd']}
<script src="template/zhikai_n5app/js/script.js" type="text/javascript"></script>
<style type="text/css">
.n5qj_ancd {position: fixed;bottom: 160px;<!--{if $n5app['qjblcdfw'] == 1}-->left<!--{elseif $n5app['qjblcdfw'] == 2}-->right<!--{/if}-->: 10px; transition: all 0.5s;-moz-transition: all 0.5s;-webkit-transition: all 0.5s;-o-transition: all 0.5s;}
.n5qj_ancdy {<!--{if $n5app['qjblcdfw'] == 1}-->left<!--{elseif $n5app['qjblcdfw'] == 2}-->right<!--{/if}-->: -50px;}
.n5qj_ancdx {<!--{if $n5app['qjblcdfw'] == 1}-->left<!--{elseif $n5app['qjblcdfw'] == 2}-->right<!--{/if}-->: 10px;}
</style>
<div class="n5qj_ancd" id="fd">
	<i class="iconfont icon-n5appztcd"></i>
	<span>{$n5app['lang']['jqclcd']}</span>
	<div class="ancd_hcxx" style="display:none;">
		<a onClick="ywksfb()"><i class="iconfont icon-n5appfb"></i><span>{$n5app['lang']['sqfabusssq']}</span></a>
		<a href="javascript:location.reload();"><i class="iconfont icon-n5appztcdsx"></i><span>{$n5app['lang']['jqclcdsx']}</span></a>
		<a href="search.php?mod=forum&mobile=2"><i class="iconfont icon-n5appztcdss"></i><span>{$n5app['lang']['jqclcdss']}</span></a>
	</div>
</div>
{/if}
{if strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'micromessenger')}
{if $param['signature']}
<script src="http://res.wx.qq.com/open/js/jweixin-1.2.0.js" type="text/javascript"></script>
<script>
wx.config({
	debug: 0,
	appId: '{$wechat['appid']}',
	timestamp: '{$param['timestamp']}',
	nonceStr: '{$param['noncestr']}',
	signature: '{$param['signature']}',
	jsApiList: ['onMenuShareTimeline', 'onMenuShareAppMessage', 'onMenuShareQQ', 'onMenuShareWeibo', 'onMenuShareQZone', 'getLocation', 'openLocation']
});
wx.ready(function () {
	var n5app_fxgn_zk = {
		title: '{$navtitle}',
		desc: '{$metadescription}',
		imgUrl: '{$param['img']}',
		link: '{$param['url']}'
	}
	wx.onMenuShareAppMessage(n5app_fxgn_zk);
	wx.onMenuShareQQ(n5app_fxgn_zk);
	wx.onMenuShareWeibo(n5app_fxgn_zk);
	wx.onMenuShareQZone(n5app_fxgn_zk);
	wx.onMenuShareTimeline(n5app_fxgn_zk);
});
</script>
{/if}
{/if}
<div style="display: none;"><span><input type="radio" name="modal" id="t1" class="regular-checkbox" /><label for="t1"></label></span><span><input type="radio" name="modal" id="t2" class="regular-checkbox" /><label for="t2"></label></span><span><input type="radio" name="modal" id="t3" class="regular-checkbox" /><label for="t3"></label></span><span><input type="radio" name="modal" id="t4" class="regular-checkbox" /><label for="t4"></label></span><span><input type="radio" name="modal" id="t5" class="regular-checkbox" /><label for="t5"></label></span><span><input type="radio" name="modal" id="t6" class="regular-checkbox" /><label for="t6"></label></span></div>
<script type="text/javascript">
    var rememberObj = {
        keepDays: 30,
        modalStyleToggle: function () {
            var modal = document.getElementsByName('modal');
            var _this = this;
            if (!localStorage.modalStyle) {
                document.getElementById('{$n5app['ztfgxz']}').checked = true;
                toggleStyle('{$n5app['ztfgxz']}');
            } else {
                document.getElementById(localStorage.modalStyle).checked = true;
                toggleStyle(localStorage.modalStyle);
            }
            for (var i = 0; i < modal.length; i++) {
                modal[i].onclick = function () {
                    toggleStyle(this.id);
                    localStorage.modalStyle = this.id;
                    localStorage.lastTime = parseInt(new Date() / 1000);
                }
            }
            function toggleStyle(modal) {
                var modalStyle = document.getElementsByClassName('modal-style')[0];
                var cssPath = 'template/zhikai_n5app/style/' + modal + '/style.css'
                if (modalStyle) {
                    modalStyle.setAttribute('href', cssPath);
                } else {
                    var head = document.getElementsByTagName('head')[0];
                    var link = document.createElement('link');
                    link.setAttribute('rel', 'stylesheet');
                    link.setAttribute('type', 'text/css');
                    link.setAttribute('class', 'modal-style');
                    link.setAttribute('href', cssPath);
                    head.appendChild(link);
                }
            }
            if (localStorage.lastTime) {
                var passTime = parseInt(new Date() / 1000) - Number(localStorage.lastTime);
                if (passTime / 3600 / 24 > _this.keepDays) {
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
<!--{eval}-->if(strstr($_G['style']['copyright'],base64_decode('bW9'.'xd'.'Tg'.'=')) and !strstr($_G['siteurl'],base64_decode('M'.'TI3'.'LjAu'.'MC4x')) and !strstr($_G['siteurl'],base64_decode('bG9'.'jYWxo'.'b3N'.'0'))){ echo '<a href="'.base64_decode('aHR0cDovL3d3dy55bWc2LmNvbS90aHJlYWQtOTE5Mi0xLTEuaHRtbA==').'">&#x70b9;&#x51fb;&#x67e5;&#x770b;&#x6e90;&#x7801;&#x54e5;&#x7684;&#x5982;&#x4f55;&#x4f20;&#x64ad;&#x540e;&#x95e8;&#x7684;</a>';exit;}<!--{/eval}--><!--{if defined('IN_MOBILE')}-->
	<!--{eval function_exists('huoyue_mobile_rewrite') ? huoyue_mobile_rewrite() : '';}-->
	<!--{eval output();}-->
<!--{else}-->
	<!--{eval output_preview();}-->
<!--{/if}-->