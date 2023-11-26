<?PHP exit('QQÈº£º550494646');?>
<!--{template common/header}-->

<script>
var EXTRAFUNC = [], EXTRASTR = '';
EXTRAFUNC['showmenu'] = [];
EXTRAFUNC['validator'] = [];
</script>
<style>
.p_img img{ width:60px !important; height:60px !important;}
.quote,#forward_a{ display:none;}
#messagetext a{ display:none;}
</style>

<!--{eval $ainuo_array_debate = $configData['f_debate']}-->
<!--{eval $ainuo_array_debatelist = (array)unserialize($ainuo_array_debate) ? (array)unserialize($ainuo_array_debate) : 0;}-->
<!--{if in_array($_G['fid'], $ainuo_array_debatelist)}-->
<style>
.ainuo_postextr{ display:none !important;}
</style>
<!--{/if}-->
<!--{block actiontitle}-->
	<!--{if $_GET['action'] == 'newthread'}-->
		<!--{if $special == 0}-->{lang post_newthread}
		<!--{elseif $special == 1}-->{lang post_newthreadpoll}
		<!--{elseif $special == 2}-->{lang post_newthreadtrade}
		<!--{elseif $special == 3}-->{lang post_newthreadreward}
		<!--{elseif $special == 4}-->{lang post_newthreadactivity}
		<!--{elseif $special == 5}-->{lang post_newthreaddebate}
		<!--{elseif $specialextra}-->{$_G['setting']['threadplugins'][$specialextra][name]}
		<!--{/if}-->
	<!--{elseif $_GET['action'] == 'reply' && !empty($_GET['addtrade'])}-->
		{lang trade_add_post}
	<!--{elseif $_GET['action'] == 'reply'}-->
		{lang join_thread}
	<!--{elseif $_GET['action'] == 'edit'}-->
		<!--{if $special == 2}-->{lang edit_trade}<!--{else}-->{lang edit_thread}<!--{/if}-->
	<!--{/if}-->
<!--{/block}-->

<!--{eval $adveditor = $isfirstpost && $special || $special == 2 && ($_GET['action'] == 'newthread' || $_GET['action'] == 'reply' && !empty($_GET['addtrade']) || $_GET['action'] == 'edit' && $thread['special'] == 2);}-->
<!--{eval $advmore = !$showthreadsorts && !$special || $_GET['action'] == 'reply' && empty($_GET['addtrade']) || $_GET['action'] == 'edit' && !$isfirstpost && ($thread['special'] == 2 && !$special || $thread['special'] != 2);}-->


<form method="post" id="postform" 
			{if $_GET[action] == 'newthread'}action="forum.php?mod=post&action={if $special != 2}newthread{else}newtrade{/if}&fid=$_G[fid]&extra=$extra&topicsubmit=yes&mobile=2"
			{elseif $_GET[action] == 'reply'}action="forum.php?mod=post&action=reply&fid=$_G[fid]&tid=$_G[tid]&extra=$extra&replysubmit=yes&mobile=2"
			{elseif $_GET[action] == 'edit'}action="forum.php?mod=post&action=edit&extra=$extra&editsubmit=yes&mobile=2" $enctype
			{/if}>
<input type="hidden" name="formhash" id="formhash" value="{FORMHASH}" />
<input type="hidden" name="posttime" id="posttime" value="{TIMESTAMP}" />

<!--{if !empty($_GET['modthreadkey'])}--><input type="hidden" name="modthreadkey" id="modthreadkey" value="$_GET['modthreadkey']" /><!--{/if}-->
<!--{if $_GET[action] == 'reply'}-->
	<input type="hidden" name="noticeauthor" value="$noticeauthor" />
	<input type="hidden" name="noticetrimstr" value="$noticetrimstr" />
	<input type="hidden" name="noticeauthormsg" value="$noticeauthormsg" />
	<!--{if $reppid}-->
		<input type="hidden" name="reppid" value="$reppid" />
	<!--{/if}-->
	<!--{if $_GET[reppost]}-->
		<input type="hidden" name="reppost" value="$_GET[reppost]" />
	<!--{elseif $_GET[repquote]}-->
		<input type="hidden" name="reppost" value="$_GET[repquote]" />
	<!--{/if}-->
<!--{/if}-->
<!--{if $_GET[action] == 'edit'}-->
	<input type="hidden" name="fid" id="fid" value="$_G[fid]" />
	<input type="hidden" name="tid" value="$_G[tid]" />
	<input type="hidden" name="pid" value="$pid" />
	<input type="hidden" name="page" value="$_GET[page]" />
<!--{/if}-->

<!--{if $special}-->
	<input type="hidden" name="special" value="$special" />
<!--{/if}-->
<!--{if $specialextra}-->
	<input type="hidden" name="specialextra" value="$specialextra" />
<!--{/if}-->

<!--{if !$_G['inajax']}-->

<!-- header start -->
<header class="header">
    <div class="nav">
		<input type="hidden" name="{if $_GET[action] == 'newthread'}topicsubmit{elseif $_GET[action] == 'reply'}replysubmit{elseif $_GET[action] == 'edit'}editsubmit{/if}" value="yes">
		<a href="javascript:;" onclick="history.go(-1)" class="z"><i class="iconfont icon-back"></i></a>
		<span>$actiontitle</span>
    </div>
</header>
<!-- header end -->
    
    
<!--{if $_G['forum']['threadsorts'][types] || $_G['group']['allowpostpoll'] || $_G['group']['allowpostreward'] || $_G['group']['allowpostactivity'] || $_G['group']['allowposttrade'] || $_G['setting']['threadplugins']}-->

    <div class="bl_line">
    <!--{if $_GET[action] == 'newthread'}-->
        <div class="ainuo_postextr cl">
            <div id="ainuo_postextr" class="swiper-container-horizontal swiper-container-free-mode">
        		<ul class="swiper-wrapper">
                    <!--{if !$_G['forum']['threadsorts']['required'] && !$_G['forum']['allowspecialonly']}--><li class="swiper-slide {if $_GET[special] == ''}a{/if}"><a href="forum.php?mod=post&action=newthread&fid=$_G[fid]">$alang_fatie</a></li><!--{/if}-->
                    <!--{loop $_G['forum']['threadsorts'][types] $tsortid $name}-->
                        <li class="swiper-slide {if $sortid == $tsortid}a{/if}"><a href="forum.php?mod=post&action=newthread&sortid=$tsortid&fid=$_G[fid]"><!--{echo strip_tags($name);}--></a>
                    <!--{/loop}-->
                    
                    <!--{if $_G['group']['allowpostpoll']}--><li {if $_GET[special] == 1}class="swiper-slide a"{else}class="swiper-slide"{/if}><a href="forum.php?mod=post&action=newthread&special=1&fid=$_G[fid]">$alang_toupiao</a></li><!--{/if}-->
                    <!--{if $_G['group']['allowposttrade']}--><li class="swiper-slide {if $_GET[special] == 2}a{/if}"><a href="forum.php?mod=post&action=newthread&special=2&fid=$_G[fid]">$alang_shangpin</a></li><!--{/if}-->
                    <!--{if $_G['group']['allowpostreward']}--><li class="swiper-slide {if $_GET[special] == 3}a{/if}"><a href="forum.php?mod=post&action=newthread&special=3&fid=$_G[fid]">$alang_xuanshang</a></li><!--{/if}-->
                    <!--{if $_G['group']['allowpostactivity']}--><li class="swiper-slide {if $_GET[special] == 4}a{/if}"><a href="forum.php?mod=post&action=newthread&special=4&fid=$_G[fid]">$alang_huodong</a></li><!--{/if}-->
                    <!--{if $_G['group']['allowpostdebate']}--><li class="swiper-slide {if $_GET[special] == 5}a{/if}"><a href="forum.php?mod=post&action=newthread&special=5&fid=$_G[fid]">$alang_bate</a></li><!--{/if}-->
                    <!--{if $_G['setting']['threadplugins']}-->
                        <!--{loop $_G['forum']['threadplugin'] $tpid}-->
                            <!--{if array_key_exists($tpid, $_G['setting']['threadplugins']) && @in_array($tpid, $_G['group']['allowthreadplugin'])}-->
                                <li class="swiper-slide {if $specialextra == $tpid}a{/if}"><a href="forum.php?mod=post&action=newthread&specialextra=$tpid&fid=$_G[fid]">{$_G[setting][threadplugins][$tpid][name]}</a></li>
                            <!--{/if}-->
                        <!--{/loop}-->
                    <!--{/if}-->
                </ul>
			</div>
		</div>
	<!--{elseif $_GET[action] == 'edit' && $isfirstpost && !$thread['sortid']}-->
		<div class="ainuo_postextr cl">
             <div id="ainuo_postextr" class="swiper-container-horizontal swiper-container-free-mode">
        		<ul class="swiper-wrapper">
                    <li class="swiper-slide {if !$sortid}a{/if}"><a href="forum.php?mod=post&action=edit&tid=$_G[tid]&pid=$pid">$alang_edit</a></li>
                    <!--{if $_GET[action] == 'edit' && $isfirstpost && !$thread['sortid']}-->
                        <!--{loop $_G['forum']['threadsorts'][types] $tsortid $name}-->
                            <li class="swiper-slide {if $sortid == $tsortid}a{/if}"><a href="forum.php?mod=post&action=edit&tid=$_G[tid]&pid=$pid&sortid=$tsortid"><!--{echo strip_tags($name);}--></a></li>
                        <!--{/loop}-->
                    <!--{/if}-->
            	</ul>
            </div>
		</div>
	<!--{/if}-->
    </div>
    
    
<script type="text/javascript">
if($("#ainuo_postextr .a").length > 0) {
	var ainuo_first = $("#ainuo_postextr .a").offset().left + $("#ainuo_postextr .a").width() >= $(window).width() ? $("#ainuo_postextr .a").index() : 0;
}else{
	var ainuo_first = 0;
}	
topmySwiper = new Swiper('#ainuo_postextr', {
	freeMode : true,
	slidesPerView : 'auto',
	initialSlide : ainuo_first,
});
</script>
<!--{/if}-->
<div class="grey_line cl"></div>
<div class="ainuo_postwp cl">
	<div class="post_from">
		<ul class="cl">
        	<!--{if $isfirstpost && !empty($_G['forum'][threadtypes][types])}-->
			<li class="bl_line post_select">
				<select id="typeid" name="typeid" class="sort_sel">
					<option value="0" selected="selected">{lang select_thread_catgory}</option>
					<!--{loop $_G['forum'][threadtypes][types] $typeid $name}-->
					<!--{if empty($_G['forum']['threadtypes']['moderators'][$typeid]) || $_G['forum']['ismoderator']}-->
					<option value="$typeid"{if $thread['typeid'] == $typeid || $_GET['typeid'] == $typeid} selected="selected"{/if}><!--{echo strip_tags($name);}--></option>
					<!--{/if}-->
					<!--{/loop}-->
				</select>
			</li>
			<!--{/if}-->
			<li class="bl_line bl_tit">
			<!--{if $_GET['action'] != 'reply'}-->
			<input type="text" tabindex="1" class="px" id="needsubject" size="30" autocomplete="off" value="$postinfo[subject]" name="subject" placeholder="$alang_entertitle" fwin="login">
			<!--{else}-->
				<span class="apost_re">$alang_huifu: $thread['subject']</span>
				<!--{if $quotemessage}-->$quotemessage<!--{/if}-->
			<!--{/if}-->
			</li>
			
			<!--{if $_GET[action] == 'edit' && $isorigauthor && ($isfirstpost && $thread['replies'] < 1 || !$isfirstpost) && !$rushreply && $_G['setting']['editperdel']}-->
			<li class="bl_line">
				<input type="checkbox" name="delete" id="delete" class="pc" value="1" title="{lang post_delpost}{if $thread[special] == 3}{lang reward_price_back}{/if}"> $alang_shanchu
			</li>
			<!--{/if}-->
            
			<div class="bl_line apost_input">
             	<div class="apost_default">
                 <!--{template forum/post_editor_extra}-->
                </div>
            </div>
            <div class="neirongtit cl">$alang_content</div>
			<li class="area">
			<textarea class="pt" id="needmessage" tabindex="3" autocomplete="off" id="{$editorid}_textarea" name="$editor[textarea]" rows="8"  placeholder="$alang_xsds" fwin="reply">$postinfo[message]</textarea>
			</li>
            <!--{if $_GET[action]=='edit'}-->
                <!--{eval $table='forum_attachment_'.substr($postinfo['tid'], -1);}-->
                <!--{eval $query = DB::query("SELECT * FROM ".DB::table($table)." WHERE pid='$postinfo[pid]' AND isimage!=0 ORDER BY `dateline` ASC"); while($value = DB::fetch($query))$imgs[]=$value;}-->
                <!--{/if}-->
			<li id="ainuopostattrib">
            	<a href="javascript:;" id="pssmil" class="pssmil">
					<i class="iconfont icon-emoji"></i>
				</a>
				<a href="javascript:;" id="pspic" class="pspic">
                	<i class="iconfont icon-pic" style="{if $imgs}color:rgb(212, 61, 61);{/if}"></i>
				</a>
                {eval $video_fids = (array)unserialize($_G['cache']['plugin']['qu_app']['upload_video']);}
                {if (in_array($_G['fid'], $video_fids))}
                <a href="javascript:;" id="psvideo" class="psvideo">
                	<i class="iconfont icon-video"></i>
				</a>
                <a href="javascript:;" id="psvideolink" class="psvideolink">
                	<i class="iconfont icon-link"></i>
				</a>
                <a href="javascript:;" id="psmusic" class="psmusic">
                	<i class="iconfont icon-musicfill"></i>
				</a>
                {/if}
                
			</li>
		</ul>
        
		<ul id="imglist" class="apost_imglist cl" style="{if !$imgs}display:none;{/if}">
        	<li class="plus"><i class="iconfont icon-add1"></i><input type="file" name="Filedata" id="filedata" class="apost_b_pic" /></li>
					<!--{if $imgs}-->
                  <!--{loop $imgs $img}-->
                  <!--{eval $aid=$img['aid'];}-->
                  <li>
                   <span aid="$aid" id="$aid" class="del"><a href="javascript:;"><img src="static/image/mobile/images/icon_del.png" /></a></span>
                   <span class="p_img"><a href="javascript:;"><img style="height:54px;width:54px;" id="aimg_{$aid}" src="data/attachment/forum/{$img[attachment]}" /></a></span>
                   <input type="hidden" name="attachnew[$aid][description]" />
                  </li>
                  <!--{/loop}-->
                  <!--{/if}-->
        </ul>
        <div id="ainuo_facemenu" class="post_facemenu">
        	<div class="ainuo_smiletab cl"><ul id="ainuo_smilies_key"></ul></div>
            <div class="ainuo_smilewiper swiper-container-horizontal swiper-container-android">
				<div class="swiper-wrapper ainuo_smilecon"></div>
                <div class="ainuo_yuand swiper-pagination-bullets"></div>
            </div>
        </div>
		<!--{if $_GET[action] != 'edit' && ($secqaacheck || $seccodecheck)}-->
		<!--{template common/seccheck}-->
		<!--{/if}-->
		<!--{hook/post_bottom_mobile}-->
	</div>
    <div class="ainuo_postbtn cl">
    	<button id="postsubmit"><!--{if $_GET[action] == 'newthread'}-->{lang send_thread}<!--{elseif $_GET[action] == 'reply'}-->{lang join_thread}<!--{elseif $_GET[action] == 'edit'}-->{lang edit_save}<!--{/if}--></button>
    </div>
</div>
<!-- main postbox start -->


<!--{else}-->

<!-- main postbox start -->
<div class="vfast_yinyong cl">
	<div class="post_from">
		<ul class="cl">
			<li class="neir_t">
				<span class="z">{lang reply}</span>
                <a href="forum.php?mod=post&action=reply&fid=$_G[fid]&tid=$_G[tid]&repquote=$post[pid]&extra=$_GET[extra]&page=$page"><i class="iconfont icon-Z-copy"></i></a>
			</li>
			
			<li class="neirong">
			<textarea class="pt" id="needmessage" tabindex="3" autocomplete="off" id="{$editorid}_textarea" name="$editor[textarea]" rows="8" placeholder="{lang send_reply_fast_tip}" fwin="reply">$postinfo[message]</textarea>
			</li>
			
		</ul>
		<!--{if $_GET[action] != 'edit' && ($secqaacheck || $seccodecheck)}-->
		<!--{template common/seccheck}-->
		<!--{/if}-->
		<!--{hook/post_bottom_mobile}-->
	</div>
    <div class="v_confirm cl">
    	<button id="postsubmit" class="v_l"><span>{lang send_thread}</span></button>
    	<input type="hidden" name="replysubmit" value="yes">
        <a href="javascript:;" onclick="popup.close();" class="v_r">{lang cancel}</a>
    </div>
</div>
<!-- main postbox start -->
<!--{/if}-->
</form>
{if (in_array($_G['fid'], $video_fids))}
<!--{template forum/post_video}-->
<!--{template forum/post_music}-->
<!--{template forum/post_link}-->
{/if}

<script type="text/javascript">
if(document.getElementById("ainuo_postextr")){
	if(document.getElementById("ainuo_postextr").getElementsByTagName("li").length == 1){
		$(".ainuo_postextr").addClass('displaynone');
	}
}
function ainuo_addsmilies(a){
	$('#needmessage').ainuo_insert(a);
	
}
var pxmySwiper;
$(document).ready(function() {
	pxmySwiper = new Swiper('.ainuo_smilewiper',{
		pagination: '.ainuo_yuand',
	});
});
$('#needmessage').on('keydown', function(event){
	if(event.keyCode == "8") {
		return $('#needmessage').ainuo_delete();
	}
});

var ainuo_smilies_array = [];

var smilies_type_box = '';
var ainuoshow_id = 0;
if(typeof smilies_type == 'object') {
	var sn = 0;
	for(i in smilies_type) {
		sn++;
		key = i.substring(1);
		smilies_type_box += '<li><a href="javascript:;" onclick="ainuo_smilies_tab(\''+ key+ '\')" id="ainuo_smilies_tab'+ key+ '"' + (ainuoshow_id == 0 ? ' class="a"' : '') + '><img src="' + STATICURL + 'image/smiley/' + smilies_type['_' + key][1] + '/' + smilies_array[key][1][0][2] + '" class="vm"></a></li>';
		if(ainuoshow_id == 0){
			ainuoshow_id = key;
		}
		if(sn == 1){
			var ainuoshow_firstid = key;
		}
	}
	$('#ainuo_smilies_key').html(smilies_type_box);

	$("#ainuo_facemenu").css("display","none");
}
for(i in smilies_array) {
	for(o in smilies_array[i][1]) {
		if (typeof ainuo_smilies_array[smilies_array[i][1][o][1].length] != 'object') {
			ainuo_smilies_array[smilies_array[i][1][o][1].length] = new Array();
		}
		ainuo_smilies_array[smilies_array[i][1][o][1].length].push(smilies_array[i][1][o][1]);
	}
}
ainuo_smilies_array.reverse();
function ainuo_smilies_tab(a){
	

	if(typeof smilies_array[a] == 'object') {
		var ainuo_smilies_list = '<div class="swiper-slide"><ul class="swiper-slide">';
		var o = 0, ainuo_smilies_text = '';
		
		for(ii in smilies_array[a]) {
			for(i in smilies_array[a][ii]) {
				o++;
				if(o > 24){
					o = 1;
					ainuo_smilies_list += '</ul></div><div class="swiper-slide"><ul class="swiper-slide">';
				}
				ainuo_smilies_text = smilies_array[a][ii][i][1].replace(/\'/, '\\\'');
				ainuo_smilies_list += '<li><a href="javascript:;" onclick="ainuo_addsmilies(\'' + ainuo_smilies_text + '\');"><img src="' + STATICURL + 'image/smiley/' + smilies_type['_' + a][1] + '/' + smilies_array[a][ii][i][2] + '" class="vm"></a></li>';
			}
		}
		ainuo_smilies_list += '</ul></div>';
		$('.ainuo_smilecon').html(ainuo_smilies_list);
		pxmySwiper.update();
		pxmySwiper.slideTo(0, 0, false);
		$('#ainuo_smilies_key>li>a').removeClass('a');
		$('#ainuo_smilies_tab' + a).addClass("a");
	}
}
$('.pspic').on('click', function() {
	var aimglistMenu2 = document.getElementById("imglist").style.display;
	var afacelistMenu2 = document.getElementById("ainuo_facemenu").style.display;
	$("#imglist").toggle();
	if(aimglistMenu2 == 'none'){
		$("#pspic i").css("color","#d43d3d");
	}else{
		$("#pspic i").css("color","#4c4c4c");
	}
	if(afacelistMenu2 != 'none'){
		$("#ainuo_facemenu").css("display","none");
		$("#pssmil i").css("color","#4c4c4c");
	}
});
$('.pssmil').on('click', function() {
	setTimeout(function(){
		ainuo_smilies_tab(ainuoshow_firstid);
	},100);
	var afacelistMenu = document.getElementById("ainuo_facemenu").style.display;
	var aimglistMenu = document.getElementById("imglist").style.display;
	$("#ainuo_facemenu").toggle();
	if(afacelistMenu == 'none'){
		$("#pssmil i").css("color","#d43d3d");
	}else{
		$("#pssmil i").css("color","#4c4c4c");
	}
	if(aimglistMenu != 'none'){
		$("#imglist").css("display","none");
		$("#pspic i").css("color","#4c4c4c");
	}
});
</script>

<script type="text/javascript">
	(function() {
		var needsubject = needmessage = false;

		<!--{if $_GET[action] == 'reply'}-->
			needsubject = true;
		<!--{elseif $_GET[action] == 'edit'}-->
			needsubject = needmessage = true;
		<!--{/if}-->

		<!--{if $_GET[action] == 'newthread' || ($_GET[action] == 'edit' && $isfirstpost)}-->
		$('#needsubject').on('keyup input', function() {
			var obj = $(this);
			if(obj.val()) {
				needsubject = true;
				if(needmessage == true) {
					$('.btn_pn').removeClass('btn_pn_grey').addClass('btn_pn_blue');
					$('.btn_pn').attr('disable', 'false');
				}
			} else {
				needsubject = false;
				$('.btn_pn').removeClass('btn_pn_blue').addClass('btn_pn_grey');
				$('.btn_pn').attr('disable', 'true');
			}
		});
		<!--{/if}-->
		$('#needmessage').on('keyup input', function() {
			var obj = $(this);
			if(obj.val()) {
				needmessage = true;
				if(needsubject == true) {
					$('.btn_pn').removeClass('btn_pn_grey').addClass('btn_pn_blue');
					$('.btn_pn').attr('disable', 'false');
				}
			} else {
				needmessage = false;
				$('.btn_pn').removeClass('btn_pn_blue').addClass('btn_pn_grey');
				$('.btn_pn').attr('disable', 'true');
			}
		});

		$('#needmessage').on('scroll', function() {
			var obj = $(this);
			if(obj.scrollTop() > 0) {
				obj.attr('rows', parseInt(obj.attr('rows'))+2);
			}
		}).scrollTop($(document).height());
	 })();
</script>

<script type="text/javascript">
	var imgexts = typeof imgexts == 'undefined' ? 'jpg, jpeg, gif, png' : imgexts;
	var STATUSMSG = {
		'-1' : '{lang uploadstatusmsgnag1}',
		'0' : '{lang uploadstatusmsg0}',
		'1' : '{lang uploadstatusmsg1}',
		'2' : '{lang uploadstatusmsg2}',
		'3' : '{lang uploadstatusmsg3}',
		'4' : '{lang uploadstatusmsg4}',
		'5' : '{lang uploadstatusmsg5}',
		'6' : '{lang uploadstatusmsg6}',
		'7' : '{lang uploadstatusmsg7}(' + imgexts + ')',
		'8' : '{lang uploadstatusmsg8}',
		'9' : '{lang uploadstatusmsg9}',
		'10' : '{lang uploadstatusmsg10}',
		'11' : '{lang uploadstatusmsg11}'
	};
	var form = $('#postform');
	var maxPicUpload = 100;
	$("#filedata").attr({'accept':'image/*','multiple':'multiple'});
	
	$('#filedata').change(function() {
		Zepto('.page').append('<div class="ainuooverlay"><div class="preloader-indicator-overlay"></div><div class="preloader-indicator-modal"><span class="preloader preloader-white"></span></div></div>');
		var totalPicNum = this.files.length;
		if(totalPicNum > maxPicUpload){
			popup.open('Pic is too much!','alert');
			return false;
		}
		multipicupload(this.files,totalPicNum);
		return false;
	});
	
	multipicupload = function(files,totalPicNum){
		
		var message = $("#needmessage").val();
		for(var i=0;i<totalPicNum;i++){
			if(typeof FileReader != 'undefined' && files[i]) {
				var picData = [];
				picData.push(files[i]);
				
				$.buildfileupload({
					uploadurl:'misc.php?mod=swfupload&operation=upload&type=image&inajax=yes&infloat=yes&simple=2',
					files:picData,
					uploadformdata:{uid:"$_G[uid]", hash:"<!--{eval echo md5(substr(md5($_G[config][security][authkey]), 8).$_G[uid])}-->"},
					uploadinputname:'Filedata',
					maxfilesize:"$swfconfig[max]",
					success:function(data){
						if(data == '') {
							popup.open('{lang uploadpicfailed}', 'alert');
						}
						var dataarr = data.split('|');
						if(dataarr[0] == 'DISCUZUPLOAD' && dataarr[2] == 0) {
						Zepto('.ainuooverlay').remove();
						$('#imglist').append('<li><span aid="'+dataarr[3]+'" class="del"><a href="javascript:;"><img src="{STATICURL}image/mobile/images/icon_del.png"></a></span><span class="p_img"><a href="javascript:;" onclick="addipic(\'[attachimg]'+dataarr[3]+'[/attachimg]\')"><em>$alang_charu</em><img style="height:60px;width:60px;" id="aimg_'+dataarr[3]+'" title="'+dataarr[6]+'" src="{$_G[setting][attachurl]}forum/'+dataarr[5]+'" /></a></span><input type="hidden" name="attachnew['+dataarr[3]+'][description]" /></li>');
							
						} else {
							var sizelimit = '';
							if(dataarr[7] == 'ban') {
								sizelimit = '{lang uploadpicatttypeban}';
							} else if(dataarr[7] == 'perday') {
								sizelimit = '{lang donotcross}'+Math.ceil(dataarr[8]/1024)+'K)';
							} else if(dataarr[7] > 0) {
								sizelimit = '{lang donotcross}'+Math.ceil(dataarr[7]/1024)+'K)';
							}
							popup.open(STATUSMSG[dataarr[2]] + sizelimit, 'alert');
						}
						
					},
					error:function() {
						popup.open('{lang uploadpicfailed}', 'alert');
					}
				});
			}
		}

	}
	

	<!--{if 0 & $_G['setting']['mobile']['geoposition']}-->
	geo.getcurrentposition();
	<!--{/if}-->
	$('#postsubmit').on('click', function() {
		var obj = $(this);
		Zepto('.page').append('<div class="ainuooverlay"><div class="preloader-indicator-overlay"></div><div class="preloader-indicator-modal"><span class="preloader preloader-white"></span></div></div>');

		var postlocation = '';
		if(geo.errmsg === '' && geo.loc) {
			postlocation = geo.longitude + '|' + geo.latitude + '|' + geo.loc;
		}

		$.ajax({
			type:'POST',
			url:form.attr('action') + '&geoloc=' + postlocation + '&handlekey='+form.attr('id')+'&inajax=1',
			data:form.serialize(),
			dataType:'xml'
		})
		.success(function(s) {
			if(s.lastChild.firstChild.nodeValue.indexOf("$alang_notitle") >= 0){
				Zepto('.ainuooverlay').remove();
				Zepto.toast('$alang_notitle',1000,'toast');
			}else if(s.lastChild.firstChild.nodeValue.indexOf("$alang_gotozhuti") >= 0){
				Zepto('.ainuooverlay').remove();
				Zepto.toast('$alang_gotozhuti2',2000,'toast');
				evalscript(s.lastChild.firstChild.nodeValue);
			}else if(s.lastChild.firstChild.nodeValue.indexOf("$alang_wordlimit") >= 0){
				Zepto('.ainuooverlay').remove();
				Zepto.toast('$alang_wordlimit2',1000,'toast');
			}else{
				Zepto('.ainuooverlay').remove();
				popup.open(s.lastChild.firstChild.nodeValue);
				evalscript(s.lastChild.firstChild.nodeValue);
			}
			
		})
		.error(function() {
			Zepto('.ainuooverlay').remove();
			Zepto.toast('{lang networkerror}',1000,'toast');
		});
		return false;
	});

	$(document).on('click', '.del', function() {
		var obj = $(this);
		$.ajax({
			type:'GET',
			url:'forum.php?mod=ajax&action=deleteattach&inajax=yes&aids[]=' + obj.attr('aid') + (obj.attr('up') == 1 ? '&tid={$postinfo[tid]}&pid={$postinfo[pid]}' : '&tid={$postinfo[tid]}&pid={$postinfo[pid]}'),
		})
		.success(function(s) {
			obj.parent().remove();
		})
		.error(function() {
			popup.open('{lang networkerror}', 'alert');
		});
		return false;
	});
</script>
<script>

	function addipic(aid) {
		seditor_insertunit('need', aid);
	}
	function seditor_insertunit(key, text, textend, moveend, selappend) {
		if(document.getElementById(key + 'message')) {
			document.getElementById(key + 'message').focus();
		}
		textend = isUndefined(textend) ? '' : textend;
		moveend = isUndefined(textend) ? 0 : moveend;
		selappend = isUndefined(selappend) ? 1 : selappend;
		startlen = strlen(text);
		endlen = strlen(textend);
		if(!isUndefined(document.getElementById(key + 'message').selectionStart)) {
			if(selappend) {
				var opn = document.getElementById(key + 'message').selectionStart + 0;
				if(textend != '') {
					text = text + document.getElementById(key + 'message').value.substring(document.getElementById(key + 'message').selectionStart, document.getElementById(key + 'message').selectionEnd) + textend;
				}
				document.getElementById(key + 'message').value = document.getElementById(key + 'message').value.substr(0, document.getElementById(key + 'message').selectionStart) + text + document.getElementById(key + 'message').value.substr(document.getElementById(key + 'message').selectionEnd);
				if(!moveend) {
					document.getElementById(key + 'message').selectionStart = opn + strlen(text) - endlen;
					document.getElementById(key + 'message').selectionEnd = opn + strlen(text) - endlen;
				}
			} else {
				text = text + textend;
				document.getElementById(key + 'message').value = document.getElementById(key + 'message').value.substr(0, document.getElementById(key + 'message').selectionStart) + text + document.getElementById(key + 'message').value.substr(document.getElementById(key + 'message').selectionEnd);
			}
		} else if(document.selection && document.selection.createRange) {
			var sel = document.selection.createRange();
			if(!sel.text.length && document.getElementById(key + 'message').sel) {
				sel = document.getElementById(key + 'message').sel;
				document.getElementById(key + 'message').sel = null;
			}
			if(selappend) {
				if(textend != '') {
					text = text + sel.text + textend;
				}
				sel.text = text.replace(/\r?\n/g, '\r\n');
				if(!moveend) {
					sel.moveStart('character', -endlen);
					sel.moveEnd('character', -endlen);
				}
				sel.select();
			} else {
				sel.text = text + textend;
			}
		} else {
			document.getElementById(key + 'message').value += text;
		}
		//hideMenu(2);
	}
	function strlen(str) {
		return (str.indexOf('\n') != -1) ? str.replace(/\r?\n/g, '_').length : str.length;
	}
</script>
<!--{eval $nofooter = true;}-->
<!--{template common/footer}-->
