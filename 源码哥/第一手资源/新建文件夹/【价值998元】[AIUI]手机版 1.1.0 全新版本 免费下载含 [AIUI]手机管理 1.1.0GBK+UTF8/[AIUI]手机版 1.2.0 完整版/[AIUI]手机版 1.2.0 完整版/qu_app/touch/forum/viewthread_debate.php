<?PHP exit('QQÈº£º550494646');?>
<div class="ainuo_view_debate cl">

    <!--{if $debate[umpire]}-->
        <!--{if $debate['umpirepoint']}-->
        <div class="section1 cl">
            <p>
                <!--{if $debate[winner]}-->
                <!--{if $debate[winner] == 1}-->
                <label><strong style="color:#ff0000">{lang debate_square}{lang debate_winner}</strong></label>
                <!--{elseif $debate[winner] == 2}-->
                <label><strong style="color:#ff0000">{lang debate_opponent}{lang debate_winner}</strong></label>
                <!--{else}-->
                <label><strong>{lang debate_draw}</strong></label>
                <!--{/if}-->
                <!--{/if}-->
                <em>{lang debate_comment_dateline}: $debate[endtime]</em>
            </p>
            <!--{if $debate[umpirepoint]}--><p><strong>{lang debate_umpirepoint}</strong>: $debate[umpirepoint]</p><!--{/if}-->
            <!--{if $debate[bestdebater]}--><p><strong>{lang debate_bestdebater}</strong>: $debate[bestdebater]</p><!--{/if}-->
        </div>
        <!--{/if}-->
    <!--{/if}-->

    <div class="section2 cl">
    	<div class="acon1 cl">
            <div class="zhengfang cl">
            	<div class="akj cl">
                    <a href="javascript:;" id="affirmbutton" class="atoupiao1">
                        <em>$debate[affirmvotes]</em>
                        <p>$alang_zhengfang</p>
                    </a>
                </div>
            </div>
            <div class="fanfang cl">
            	<div class="akj cl">
                    <a href="javascript:;" id="negabutton" class="atoupiao2">
                        <em>$debate[negavotes]</em>
                        <p>$alang_fanfang</p>
                    </a>
                </div>
            </div>
        </div>
        {eval $ainuo_tootlenum = $debate[affirmvotes] + $debate[negavotes]}
        {eval $zfjd_p = round(($debate[affirmvotes] / $ainuo_tootlenum) * 100)}
        {eval $ffjd_p = 100 - $zfjd_p}
        <div class="acon2 cl">
        	<div class="zf_precent cl">{$zfjd_p}%</div>
        	<div class="progres cl">
            	<span class="zfjd" style="width:{$zfjd_p}%;"></span>
                <span class="ffjd" style="width:{$ffjd_p}%;"></span>
            </div>
            <div class="ff_precent cl">{$ffjd_p}%</div>
        </div>
        <div class="acon3 cl">
        	<div class="zfgd cl">
            	<div class="akj cl">
                    <div class="atit cl">{lang debate_square_point}</div>
                    <div class="acon cl">$debate[affirmpoint]</div>
                </div>
            </div>
            <div class="ffgd cl">
            	<div class="akj cl">
                    <div class="atit">{lang debate_opponent_point}</div>
                    <div class="acon cl">$debate[negapoint]</div>
                </div>
            </div>
        </div>
        
    </div>
    
    <div class="section3 cl">
    <!--{if $debate[endtime]}-->
        <p>{lang endtime}: $debate[endtime] <!--{if $debate[umpire]}-->{lang debate_umpire}: $debate[umpire]<!--{/if}--></p>
    <!--{/if}-->
    
    <!--{if $debate[umpire] && $_G['username'] && $debate[umpire] == $_G['member']['username']}-->
        <p class="jieshu">
        <!--{if $debate[remaintime] && !$debate[umpirepoint]}-->
         <a href="forum.php?mod=misc&action=debateumpire&tid=$_G[tid]&pid=$post[pid]{if $_GET[from]}&from=$_GET[from]{/if}" class="dialog">{lang debate_umpire_end}</a>
        <!--{elseif TIMESTAMP - $debate['dbendtime'] < 3600}-->
         <a href="forum.php?mod=misc&action=debateumpire&tid=$_G[tid]&pid=$post[pid]{if $_GET[from]}&from=$_GET[from]{/if}" class="dialog">{lang debate_umpirepoint_edit}</a>
        <!--{/if}-->
        </p>
    <!--{/if}-->
    </div>

</div>

<div id="postmessage_$post[pid]" class="postmessage">$post[message]</div>

<script type="text/javascript">
$('.atoupiao1').on('click', function() {
	<!--{if !$_G[uid]}-->
		popup.open('{lang nologin_tip}', 'confirm', 'member.php?mod=logging&action=login');
		return false;
	<!--{/if}-->
	Zepto('.page').append('<div class="ainuooverlay"><div class="preloader-indicator-overlay"></div><div class="preloader-indicator-modal"><span class="preloader preloader-white"></span></div></div>');
	var obj = $(this);
	$.ajax({
		type:'POST',
		url:'forum.php?mod=misc&action=debatevote&tid=$_G[tid]&stand=1&inajax=1',
		data:{'formhash':'{FORMHASH}'},
		dataType:'xml',
	})
	.success(function(s) {
		if(s.lastChild.firstChild.nodeValue.indexOf("$alang_debatetp1") >= 0){
			Zepto('.ainuooverlay').remove();
			Zepto.toast('$alang_debatetp1',1500,'toast');
		}else if(s.lastChild.firstChild.nodeValue.indexOf("$alang_debatesuccess1") >= 0){
			Zepto('.ainuooverlay').remove();
			Zepto.toast('$alang_debatesuccess1',1500,'toast');
		}else if(s.lastChild.firstChild.nodeValue.indexOf("$alang_debategd4") >= 0){
			Zepto('.ainuooverlay').remove();
			Zepto.toast('$alang_debategd4',1500,'toast');
		}else{
			Zepto('.ainuooverlay').remove();
			popup.open(s.lastChild.firstChild.nodeValue);
			evalscript(s.lastChild.firstChild.nodeValue);
		}
	})
	.error(function() {
		window.location.href = obj.attr('href');
		Zepto('.ainuooverlay').remove();
	});
	return false;
});
$('.atoupiao2').on('click', function() {
	<!--{if !$_G[uid]}-->
		popup.open('{lang nologin_tip}', 'confirm', 'member.php?mod=logging&action=login');
		return false;
	<!--{/if}-->
	Zepto('.page').append('<div class="ainuooverlay"><div class="preloader-indicator-overlay"></div><div class="preloader-indicator-modal"><span class="preloader preloader-white"></span></div></div>');
	var obj = $(this);
	$.ajax({
		type:'POST',
		url:'forum.php?mod=misc&action=debatevote&tid=$_G[tid]&stand=2&inajax=1',
		data:{'formhash':'{FORMHASH}'},
		dataType:'xml',
	})
	.success(function(s) {
		if(s.lastChild.firstChild.nodeValue.indexOf("$alang_debatetp1") >= 0){
			Zepto('.ainuooverlay').remove();
			Zepto.toast('$alang_debatetp1',1500,'toast');
		}else if(s.lastChild.firstChild.nodeValue.indexOf("$alang_debatesuccess1") >= 0){
			Zepto('.ainuooverlay').remove();
			Zepto.toast('$alang_debatesuccess1',1500,'toast');
		}else if(s.lastChild.firstChild.nodeValue.indexOf("$alang_debategd4") >= 0){
			Zepto('.ainuooverlay').remove();
			Zepto.toast('$alang_debategd4',1500,'toast');
		}else{
			Zepto('.ainuooverlay').remove();
			popup.open(s.lastChild.firstChild.nodeValue);
			evalscript(s.lastChild.firstChild.nodeValue);
		}
	})
	.error(function() {
		window.location.href = obj.attr('href');
		Zepto('.ainuooverlay').remove();
	});
	return false;
});
</script>