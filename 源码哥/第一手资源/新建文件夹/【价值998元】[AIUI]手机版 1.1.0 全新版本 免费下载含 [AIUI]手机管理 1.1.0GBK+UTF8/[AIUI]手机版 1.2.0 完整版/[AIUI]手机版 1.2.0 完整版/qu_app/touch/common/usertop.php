<?PHP exit('QQÈº£º550494646');?>

<div class="ainuo_gotomy_menu_cover cl" id="gotomaskmenu" style="display:none;"></div>
<div id="ainuo_gotomy_menu" class="ainuo_gotomy_menu cl" style="display:none;">
    <a href="forum.php?mod=guide&view=hot"><i class="iconfont icon-home"></i>$alang_backhome</a>
    <a href="home.php?mod=space&uid=$_G[uid]&do=profile"><i class="iconfont icon-forward"></i>$alang_myhome</a>
    <a href="home.php?mod=space&uid=$_G[uid]&do=profile&mycenter=1" style="border:none;"><i class="iconfont icon-settings"></i>$alang_myset</a>
</div>
<style>
.useravabg{ position:absolute; width:100%; height:100%; background:url({avatar($space[uid], big, true)}) no-repeat;background-position:center;background-size: cover;}
</style>
<div class="ainuo_user_avatar">
	<div class="useravabg ainuo-blur" id="useravabg"></div>
	<div class="ausertop cl">
    	<a href="javascript:;" onclick="history.go(-1)" class="z"><i class="iconfont icon-back"></i></a>
        <!--{if $space[uid] == $_G[uid]}-->
        <em>{lang memcp_profile}</em>
        <!--{else}--><!--Fr om w ww.m oq u8 .com -->
        <em>$space[username]{$alang_tahome}</em>
        <!--{/if}-->
		<span><a href="javascript:;" class="ainuo_nologin ainuo_gotomy" id="ainuo_gotomy"><i class="iconfont icon-more"></i></a></span>
    </div>

    
    <div class="avatar_m cl">
    	<div class="img_left cl">
        	<img src="{avatar($space[uid], middle, true)}" />
            {if $_G[uid] == $space[uid]}
            <a href="javascript:;" class="modifi_ava ainuoxgtxya">$alang_umodifyava</a>
            <input type="file" id="file" accept="image/*">
            {/if}
        </div>
        <div class="img_right cl">
        	<h2><a href="home.php?mod=space&uid=$space[uid]&do=profile">$space[username]</a>
            <span class="uid">UID:{$space[uid]}</span>
            <!--{if $_G['ols'][$space[uid]]}-->
				<span>{lang online}</span>
            <!--{/if}-->
            </h2>
            {eval $agroupid = DB::result_first('SELECT `groupid` FROM '.DB::table('common_member').' WHERE `uid` ='.$space[uid].'')}
            {eval $agrouptitle = DB::result_first('SELECT `grouptitle` FROM '.DB::table('common_usergroup').' WHERE `groupid` ='.$agroupid.'')}
            <p>{$agrouptitle}</p>
            
			<!--{if helper_access::check_module('follow') && $space[uid] != $_G[uid]}-->
            <div class="guanzhu cl">
                <!--{eval $follow = 0;}-->
                <!--{eval $follow = C::t('home_follow')->fetch_all_by_uid_followuid($_G['uid'], $space['uid']);}-->
                
                <!--{if !$follow}-->
                    <a onclick="guanzhutis('$space[uid]')" href="javascript:;"><i class="iconfont icon-like"></i><span id="tex_{$space[uid]}" class="tex_{$space[uid]}">$alang_guanzhu</span></a>
                <!--{else}-->
                    <a onclick="guanzhutis('$space[uid]')" href="javascript:;" ><i class="iconfont icon-like"></i><span id="tex_{$space[uid]}" class="tex_{$space[uid]}">$alang_yiguanzhu</span></a>
				<!--{/if}-->
											
            </div>
            <!--{/if}-->
        </div>
    </div>
    <div class="ainuo_user_avatarbg"></div>
</div>


<link href="template/qu_app/touch/style/avatar/css/avatar.css?{VERHASH}" rel="stylesheet" type="text/css" media="all">


<section id="reset_avatar">
    <div id="canvas_fullscreen" style="display: none;position:absolute;bottom:0px;left:0px; z-index:189;">
        <div class="header" style="z-index:199">
            <div class="nav">
                <a href="javascript:;" class="cancel z" onclick="$('#canvas_fullscreen').hide();$('html,body').removeClass('hidden');">{lang cancel}</a>
                <span class="name">$alang_umodifyava</span>
				<a id="finish" href="javascript:;" class="y" style="font-size:14px;">$alang_wancheng</a>
            </div>
        </div>

        <div id="canvas_content">

            <div class="canvas_edit">
                <div id="canvas_area"></div>
                <div class="canvas_opera" style="z-index:999;">
                    <button id="positive-rotate"><i class="iconfont icon-youxuanzhuan"></i></button>
                    <button id="inverse-rotate"><i class="iconfont icon-zuoxuanzhuan"></i></button>
                    <button id="reduction"><i class="iconfont icon-suoxiao"></i></button>
                    <button id="magnification"><i class="iconfont icon-fangda"></i></button>
                </div>
            </div>
            <img fileName="" id="canvas_view" class="hide">
            <canvas id="canvas_preview"></canvas>
        </div>

    </div>

    <div class="canvas_lazy_tip hide"><span>1%</span><div class="spinner"></div></div>
    <div class="canvas_lazy_cover hide"></div>

</section>


<script>
var jsvar=[];
	jsvar['siteurl'] = '{$_G[siteurl]}';
	jsvar['appurl'] = 'plugin.php?id=qu_app';
	jsvar['avatar_big'] = '{$auser[avatar_big]}';
	jsvar['formhash'] = '{FORMHASH}';
</script>
<script>
function canvasShow(){
    $('.canvas_lazy_cover,.canvas_lazy_tip').hide();
    $('#canvas_fullscreen').show();
    $('html,body').addClass("hidden");
}

function canvasToImage(base64){
    var imgData = base64 || document.getElementById('canvas_preview').toDataURL('image/jpeg',1);
    $('.photo-clip-rotateLayer img').attr('src',imgData);
    canvasShow();
}

function uploadImage(img_data) {
	Zepto('.page').append('<div class="ainuooverlay"><div class="preloader-indicator-overlay"></div><div class="preloader-indicator-modal"><span class="preloader preloader-white"></span></div></div>');
    $.ajax({
        type:'POST',
        url:jsvar['appurl']+'&m=avatar',
        data:{image_file:img_data,formhash:jsvar['formhash']},
        dataType: 'JSON',
        beforeSend: function(XMLHttpRequest){
            $('.canvas_lazy_cover,.canvas_lazy_tip').show();
        }, 
		success:function(data) {
			if(data.status) {
				 $('.img_left img').attr('src',img_data);
				 document.getElementById('useravabg').style.background = 'url('+img_data+')';
				 $('#canvas_fullscreen,.canvas_lazy_cover,.canvas_lazy_tip').hide();
				 $('html,body').removeClass('hidden');
				 Zepto('.ainuooverlay').remove();
				 Zepto.toast('$alang_cz_success',1500,'toast');
			}
        }, 
		error:function(){
            alert('$alang_pleasetye');
        }
	});
}
</script>


<script type="text/javascript">
	function guanzhutis(aid){
		<!--{if !$_G[uid]}-->
			popup.open('{lang nologin_tip}', 'confirm', 'member.php?mod=logging&action=login');
			return false;
		<!--{/if}-->
		if(document.getElementById("tex_"+aid).innerHTML.indexOf("$alang_guanzhu") >= 0){
			var ahref = 'home.php?mod=spacecp&ac=follow&op=add&fuid='+aid+'&hash={FORMHASH}';
		}else{
			var ahref = 'home.php?mod=spacecp&ac=follow&op=del&fuid='+aid;
		}
		Zepto('.page').append('<div class="ainuooverlay"><div class="preloader-indicator-overlay"></div><div class="preloader-indicator-modal"><span class="preloader preloader-white"></span></div></div>');
		$.ajax({
			type:'GET',
			url:ahref + '&inajax=1',
			dataType:'xml',
		})
		.success(function(s) {	
			if(s.lastChild.firstChild.nodeValue.indexOf("$alang_cgshouting") >= 0){
				$(".tex_"+aid).text('$alang_yiguanzhu');
				Zepto('.ainuooverlay').remove();
				Zepto.toast('$alang_cgshouting2',1500,'toast');
			}else if(s.lastChild.firstChild.nodeValue.indexOf("$alang_qxchenggong") >= 0){
				$(".tex_"+aid).text('$alang_guanzhu');
				//$("."+clsa).attr('href','home.php?mod=spacecp&ac=follow&op=del&fuid='+aid); 
				Zepto('.ainuooverlay').remove();
				Zepto.toast('$alang_qxchenggong2',1500,'toast');
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
	};
</script>

<script>
$(document).ready(function(){
	$("#ainuo_gotomy").click(function(){
		<!--{if !$_G[uid]}-->
			popup.open('{lang nologin_tip}', 'confirm', 'member.php?mod=logging&action=login');
			return false;
		<!--{/if}-->
		$("#ainuo_gotomy_menu").slideToggle();
		$("#gotomaskmenu").toggle();
	});	
	$("#gotomaskmenu").click(function(){
		$("#gotomaskmenu").toggle();
		$("#ainuo_gotomy_menu").slideToggle();
	});
	
});
</script>