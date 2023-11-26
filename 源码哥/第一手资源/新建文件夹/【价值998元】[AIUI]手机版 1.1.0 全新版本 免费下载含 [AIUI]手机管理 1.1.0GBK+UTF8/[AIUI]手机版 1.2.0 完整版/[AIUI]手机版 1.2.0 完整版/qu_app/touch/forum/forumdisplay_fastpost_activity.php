<?PHP exit('QQÈº£º550494646');?>
<style>
.ainuo_viewbi{ display:none;}
.ainuo_factpostbottom{ position:fixed; bottom:0;width: 100%;height: 50px;background:#fff;font-size: 20px;z-index: 100;color: #999; border-top:1px solid #efefef;}
.ainuo_factpostbottom ul li{ float:left; font-size:12px; text-align:center;}
.ainuo_factpostbottom ul li p{ font-weight:400;}
.ainuo_factpostbottom ul li a i{ color:#777; font-size:18px; font-weight:100;}
.ainuo_factpostbottom ul li a{ display:block; position:relative; padding:4px 30px;}
.ainuo_factpostbottom ul li.acanjia{height: 50px; line-height:50px;overflow: hidden;float: none;}
.ainuo_factpostbottom ul li.acanjia a{ background:#ff9900; color:#fff; font-size:14px; padding:0;}
.ainuo_factpostbottom ul li.acanjia a.ajoinc{ background:#f60;}
.ainuo_factpostbottom ul li.acanjia a.aover{ background:#999;}
</style>
<!--{if $_G['uid']}-->
<!--{eval $favid = DB::result_first('SELECT count(*) FROM '.DB::table('home_favorite').' WHERE id='.$_G[tid].' and uid='.$_G[uid].'');}-->
<!--{else}-->
<!--{eval $favid = 0;}-->
<!--{/if}-->
<!--{eval $zanfouzan = C::t('forum_memberrecommend')->fetch_by_recommenduid_tid($_G['uid'], $_G['tid'])}-->
<div style="height:68px; width:100%;"></div>
<div class="ainuo_factpostbottom cl">
	<ul>
        
        {if $_G[uid]}
		<li><a href="javascript:;" class="acthuifu"><i class="iconfont icon-comment"></i><p>$alang_newhuifu</p></a></li>
        {else}
        <li><a href="javascript:;" class="ainuo_nologin"><i class="iconfont icon-comment"></i><p>$alang_newhuifu</p></a></li>
        {/if}
        <li><a href="javascript:;" class="favbtn" style="border-left:1px solid #eee;">
        	{if !$favid}
            	<i class="iconfont icon-favor"></i><p>$alang_fav</p>
            {else}
            	<i class="iconfont icon-favorfill iconfontzanfill"></i><p class="iconfontzanfill">$alang_yifav</p>
            {/if}
            </a></li>
        <li class="acanjia">
        	{if $_G[uid]}
            <!--{if $aexpiration}-->
                <!--{if $anowtime < $aexpiration}-->
                        <!--{if $applied && $isverified < 2}-->
                            <!--{if !$activityclose}--><a href="javascript:;" class="ajoinc acttoggle_cancel">{lang activity_join_cancel}</a><!--{/if}-->
                        <!--{elseif !$activityclose}-->
                                <!--{if $isverified != 2}-->
                                    <!--{if !$activity['number'] || $aboutmembers > 0}--><a href="javascript:;" class="ajoin acttoggle_join">{lang activity_join}</a><!--{/if}-->
                                <!--{else}-->
                                    <a href="javascript:;" onclick="showDialog($('activityjoin').innerHTML, 'info', '{lang complete_data}')">{lang complete_data}</a>
                                <!--{/if}-->
                        <!--{/if}-->
                <!--{else}-->
                    <a href="javascript:;" class="aover">$alang_activity_over</a>
                <!--{/if}-->
            <!--{else}-->
                <!--{if $astarttimeto}-->
                    <!--{if $astarttimeto < $anowtime}-->
                        <a href="javascript:;" class="ajoin acttoggle_join">{lang activity_join}</a>
                    <!--{else}-->
                        <!--{if $applied && $isverified < 2}-->
                            <!--{if !$activityclose}--><a href="javascript:;" class="ajoinc acttoggle_cancel">{lang activity_join_cancel}</a><!--{/if}-->
                        <!--{elseif !$activityclose}-->
                                <!--{if $isverified != 2}-->
                                    <!--{if !$activity['number'] || $aboutmembers > 0}--><a href="javascript:;" class="ajoin acttoggle_join">{lang activity_join}</a><!--{/if}-->
                                <!--{else}-->
                                    <a href="javascript:;" onclick="showDialog($('activityjoin').innerHTML, 'info', '{lang complete_data}')">{lang complete_data}</a>
                                <!--{/if}-->
                        <!--{/if}-->
                    <!--{/if}-->
                <!--{else}-->
                    <!--{if $applied && $isverified < 2}-->
                        <!--{if !$activityclose}--><a href="javascript:;" class="ajoinc acttoggle_cancel">{lang activity_join_cancel}</a><!--{/if}-->
                    <!--{elseif !$activityclose}-->
                            <!--{if $isverified != 2}-->
                                <!--{if !$activity['number'] || $aboutmembers > 0}--><a href="javascript:;" class="ajoin acttoggle_join">{lang activity_join}</a><!--{/if}-->
                            <!--{else}-->
                                <a href="javascript:;" onclick="showDialog($('activityjoin').innerHTML, 'info', '{lang complete_data}')">{lang complete_data}</a>
                            <!--{/if}-->
                    <!--{/if}-->
                <!--{/if}-->
            <!--{/if}-->
            {else}
            <a href="javascript:;" class="ajoin ainuo_nologin">{lang activity_join}</a>
            {/if}
        </li> 
	</ul>
</div>

<div id="afastreply" class="afastreply">
<div class="afastreply_con">
    <form method="post" autocomplete="off" id="fastpostform" action="forum.php?mod=post&action=reply&fid=$_G[fid]&tid=$_G[tid]&extra=$_GET[extra]&replysubmit=yes&mobile=2">
        <input type="hidden" name="formhash" value="{FORMHASH}" />
        <div class="cl">
            <!--{if $_G[forum_thread][special] == 5 && empty($firststand)}-->
            <div class="af_select cl">
            <select id="stand" name="stand" >
                <option value="">{lang debate_viewpoint}</option>
                <option value="0">{lang debate_neutral}</option>
                <option value="1">{lang debate_square}</option>
                <option value="2">{lang debate_opponent}</option>
            </select>
            </div>
            <!--{/if}-->
            <div class="af_text cl">
            <textarea type="text" placeholder="{lang send_reply_fast_tip}" class="input grey" color="gray" name="message" id="fastpostmessage"></textarea>
            </div>

            <div id="fastpostsubmitline" class="cl">
            	<!--{if $secqaacheck || $seccodecheck}--><!--{subtemplate common/seccheck}--><!--{/if}-->
                <input type="button" value="$alang_postreply" class="fbpl" name="replysubmit" id="fastpostsubmit">
                <a class="cenclepl" href="javascript:;">{lang cancel}</a>
                <a href="javascript:;" id="pssmil" class="pssmil">
					<i class="iconfont icon-emoji"></i>
				</a>
                <a href="javascript:;" class="pspic" id="pspic">
                	<i class="iconfont icon-pic"></i>
				</a>
                
                <!--{hook/viewthread_fastpost_button_mobile}-->
			</div>
            <ul id="imglist" class="post_imglist cl" style="display:none;">
            	<li class="plus">
                <a href="javascript:;">
            		<i class="iconfont icon-add1"></i>
                	<input type="file" name="Filedata" id="filedata" />
                </a>
                </li>
            </ul>
            <div id="ainuo_facemenu" class="post_facemenu">
                <div class="ainuo_smiletab cl"><ul id="ainuo_smilies_key"></ul></div>
                <div class="ainuo_smilewiper swiper-container-horizontal swiper-container-android">
                    <div class="swiper-wrapper ainuo_smilecon"></div>
                    <div class="ainuo_yuand swiper-pagination-bullets"></div>
                </div>
            </div>
        </div>
    </form>
</div>
</div>
<script>
function ainuo_addsmilies(a){
	$('#fastpostmessage').ainuo_insert(a);
}
$('#fastpostmessage').on('keydown', function(event){
	if(event.keyCode == "8") {
		return $('#fastpostmessage').ainuo_delete();
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
pxmySwiper = new Swiper('.ainuo_smilewiper',{
	pagination: '.ainuo_yuand',
});

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
		var form = $('#fastpostform');

		$('#fastpostsubmit').on('click', function() {
			var msgobj = $('#fastpostmessage');
			if(msgobj.val() == '{lang send_reply_fast_tip}') {
				msgobj.attr('value', '');
			}
			Zepto('.page').append('<div class="ainuooverlay"><div class="preloader-indicator-overlay"></div><div class="preloader-indicator-modal"><span class="preloader preloader-white"></span></div></div>');
			$.ajax({
				type:'POST',
				url:form.attr('action') + '&handlekey=fastpost&loc=1&inajax=1',
				data:form.serialize(),
				dataType:'xml'
			})
			.success(function(s) {
				evalscript(s.lastChild.firstChild.nodeValue);
				$('.afastreply').removeClass('is-visible');
			})
			.error(function() {
				window.location.href = obj.attr('href');
				Zepto('.ainuooverlay').remove();
			});
			return false;
		});

	})();
	function succeedhandle_fastpost(locationhref, message, param) {
		var pid = param['pid'];
		var tid = param['tid'];
		if(pid) {			
			$.ajax({
				type:'POST',
				url:'forum.php?mod=viewthread&tid=' + tid + '&viewpid=' + pid + '&mobile=2',
				dataType:'xml'
			})
			.success(function(s) {
				//$('#post_new').append(s.lastChild.firstChild.nodeValue);
				Zepto.toast('$alang_success',1500,'toast');
				Zepto('.ainuooverlay').remove();
				setTimeout(function(){window.location.reload();},500);})
			.error(function() {
				window.location.href = 'forum.php?mod=viewthread&tid=' + tid;
				Zepto('.ainuooverlay').remove();
			});
		} else {
			if(!message) {
				message = '{lang postreplyneedmod}';
			}
			Zepto('.ainuooverlay').remove();
			Zepto.toast(message,1500,'toast');
		}
		$('#fastpostmessage').attr('value', '');
		if(param['sechash']) {
			$('.seccodeimg').click();
		}
	}

	function errorhandle_fastpost(message, param) {
		Zepto.toast(message,1500,'toast');
		Zepto('.ainuooverlay').remove();
	}
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
				popup.open('<div class="ainuooverlay"><div class="preloader-indicator-overlay"></div><div class="preloader-indicator-modal"><span class="preloader preloader-white"></span></div></div>');
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
						popup.close();
						$('#imglist').append('<li><span aid="'+dataarr[3]+'" class="del"><a href="javascript:;"><img src="{STATICURL}image/mobile/images/icon_del.png"></a></span><span class="p_img"><a href="javascript:;"><img style="height:54px;width:54px;" id="aimg_'+dataarr[3]+'" title="'+dataarr[6]+'" src="{$_G[setting][attachurl]}forum/'+dataarr[5]+'" /></a></span><input type="hidden" name="attachnew['+dataarr[3]+'][description]" /></li>');
							
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
	
	


	<!--{if 0 && $_G['setting']['mobile']['geoposition']}-->
	geo.getcurrentposition();
	<!--{/if}-->
	$('#postsubmit').on('click', function() {
		var obj = $(this);
		if(obj.attr('disable') == 'true') {
			return false;
		}

		obj.attr('disable', 'true').removeClass('btn_pn_blue').addClass('btn_pn_grey');
		popup.open('<img src="' + IMGDIR + '/imageloading.gif">');

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
			popup.open(s.lastChild.firstChild.nodeValue);
		})
		.error(function() {
			popup.open('{lang networkerror}', 'alert');
		});
		return false;
	});

	$(document).on('click', '.del', function() {
		var obj = $(this);
		$.ajax({
			type:'GET',
			url:'forum.php?mod=ajax&action=deleteattach&inajax=yes&aids[]=' + obj.attr('aid'),
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