<?PHP exit('QQÈº£º550494646');?>
<!--{template common/header}-->
<style>
.ainuo_pop .acon{ padding:10px;}
</style>
<!--{if $_GET[op] == 'delete'}-->
<div class="ainuo_pop cl">
	<div class="atit cl">{lang delete_blog}</div>
<form method="post" autocomplete="off" action="home.php?mod=spacecp&ac=blog&op=delete&blogid=$blogid">
	<input type="hidden" name="referer" value="{echo dreferer()}" />
	<input type="hidden" name="deletesubmit" value="true" />
	<input type="hidden" name="formhash" value="{FORMHASH}" />
	<div class="acon cl">{lang sure_delete_blog}</div>
	<div class="ainuo_popbottom cl">
		<button type="submit" name="btnsubmit" value="true" class="formdialog aconfirm">{lang determine}</button>
        <a href="javascript:;" onclick="popup.close()" class="acancel">{lang cancel}</a>
	</div>
</form>
</div>
<!--{elseif $_GET[op] == 'stick'}-->
<div class="ainuo_pop cl">
	<div class="atit cl"><!--{if $stickflag}-->{lang stick_blog}<!--{else}-->{lang cancel_stick_blog}<!--{/if}--></div>
<form method="post" autocomplete="off" action="home.php?mod=spacecp&ac=blog&op=stick&blogid=$blogid">
	<input type="hidden" name="referer" value="{echo dreferer()}" />
	<input type="hidden" name="sticksubmit" value="true" />
	<input type="hidden" name="stickflag" value="$stickflag" />
	<input type="hidden" name="formhash" value="{FORMHASH}" />
	<div class="acon cl"><!--{if $stickflag}-->{lang sure_stick_blog}<!--{else}-->{lang sure_cancel_stick_blog}<!--{/if}--></div>
	<div class="ainuo_popbottom cl">
		<button type="submit" name="btnsubmit" value="true" class="formdialog aconfirm">{lang determine}</button>
        <a href="javascript:;" onclick="popup.close()" class="acancel">{lang cancel}</a>
	</div>
</form>
</div>
<!--{elseif $_GET[op] == 'addoption'}-->
<div class="ainuo_pop cl">
	<div class="atit cl">{lang create_category}</div>
	<div class="acon cl">
		<input type="text" name="newsort" id="newsort" class="px" placeholder="{lang name}" />
	</div>
	<div class="ainuo_popbottom cl">
		<button type="button" name="btnsubmit" value="true" class="ainuoformdialog aconfirm" onclick="if(blogAddOption('newsort', '$_GET[oid]'))hideWindow('$_GET[handlekey]');">{lang create}</button>
        <a href="javascript:;" onclick="popup.close()" class="acancel">{lang cancel}</a>
	</div>
	<script type="text/javascript">
		$('newsort').focus();
	</script>
</div>
<!--{elseif $_GET[op] == 'edithot'}-->
<div class="ainuo_pop cl">
	<div class="atit cl">{lang adjust_hot}</div>
<form method="post" autocomplete="off" action="home.php?mod=spacecp&ac=blog&op=edithot&blogid=$blogid">
	<input type="hidden" name="referer" value="{echo dreferer()}" />
	<input type="hidden" name="hotsubmit" value="true" />
	<input type="hidden" name="formhash" value="{FORMHASH}" />
	<div class="acon cl">
		<input type="text" name="hot" placeholder="{lang new_hot}" value="$blog[hot]" class="px" />
	</div>
	<div class="ainuo_popbottom cl">
		<button type="submit" name="btnsubmit" value="true" class="formdialog aconfirm">{lang determine}</button>
        <a href="javascript:;" onclick="popup.close()" class="acancel">{lang cancel}</a>
	</div>
</form>
</div>
<!--{else}-->
<!-- header start -->
<header class="header">
    <div class="nav">
        <a href="javascript:;" onclick="history.go(-1)" class="z"><i class="iconfont icon-back"></i></a>
        <span class="category"><span class="name">
		<!--{if $blog[blogid]}-->
			{lang edit_blog}
		<!--{else}-->
			{lang memcp_blog}
		<!--{/if}-->
        </span></span>
    </div>
</header>
<!-- header end -->


<div class="ainuo_postblog cl">
	<div class="cl">
		<div class="cl">
			<div class="cl">
			<form id="ttHtmlEditor" method="post" autocomplete="off" action="home.php?mod=spacecp&ac=blog&blogid=$blog[blogid]{if $_GET[modblogkey]}&modblogkey=$_GET[modblogkey]{/if}" onsubmit="validate(this);" enctype="multipart/form-data">
				
				<!--{hook/spacecp_blog_top}-->
				<table cellspacing="0" cellpadding="0" width="100%">
					<tr>
						<td><input type="text" id="subject" name="subject" placeholder="{lang title}" value="$blog[subject]" {if $_GET[op] != 'edit'}onblur="relatekw();"{/if} class="px atit" /></td>
					</tr>
					<tr>
						<td>
						
						<textarea class="px acont" name="message" id="uchome-ttHtmlEditor" style="height:200px;" placeholder="{lang content}">$blog[message]</textarea>
						<div class="upimg cl">
                        	<input type="file" name="Filedata" id="filedata" multiple="multiple">
                            <i class="iconfont icon-pic"></i>
                        </div>
                        <ul id="imglist" class="cl"></ul>
						</td>
					</tr>
				</table>

				<table cellspacing="0" cellpadding="0" width="100%">

					<!--{if $_G['setting']['blogcategorystat'] && $categoryselect}-->
					<tr>
						<td>
                        	<p>{lang site_categories}</p>
							$categoryselect
							({lang select_site_blog_categories})
						</td>
					</tr>
					<!--{/if}-->

					<tr>
						
						<td>
                        	<p>{lang personal_category}</p>
							<select name="classid" id="classid" onchange="addSort(this)" >
								<option value="0">$alang_select</option>
								<!--{loop $classarr $value}-->
								<!--{if $value['classid'] == $blog['classid']}-->
								<option value="$value[classid]" selected>$value[classname]</option>
								<!--{else}-->
								<option value="$value[classid]">$value[classname]</option>
								<!--{/if}-->
								<!--{/loop}-->
								<!--{if !$blog['uid'] || $blog['uid']==$_G['uid']}--><option value="addoption" style="color:red;">+{lang create_new_categories}</option><!--{/if}-->
							</select>
                            <div id="anewoption" style="display:none;" class="pns cl">
                                <input type="text" name="newsort" id="newsort" class="px" placeholder="{lang name}" />
                                <button type="button" name="btnsubmit" value="true" onclick="blogAddOption('newsort', 'classid')">{lang create}</button>
                            </div>
						</td>
					</tr>
                    

					<tr>
						
						<td class="pns">
                        <p>{lang label}</p>
                        <input type="text" class="px" id="tag" name="tag" value="$blog[tag]" />
                        <button type="button" name="clickbutton[]" onclick="relatekw();">{lang auto_keyword}</button>
                        </td>
					</tr>

				<!--{if $blog['uid'] && $blog['uid']!=$_G['uid']}-->
				<!--{eval $selectgroupstyle='display:none';}-->
				</table>
				<table style="display:none;">
				<!--{/if}-->

					<tr>
						<td>
                        	<p>{lang privacy_settings}</p>
							<select name="friend" onchange="passwordShow(this.value);" class="ps">
								<option value="0"$friendarr[0]>{lang friendname_0}</option>
								<option value="1"$friendarr[1]>{lang friendname_1}</option>
								<option value="2"$friendarr[2]>{lang friendname_2}</option>
								<option value="3"$friendarr[3]>{lang friendname_3}</option>
								<option value="4"$friendarr[4]>{lang friendname_4}</option>
							</select>
							<label><input type="checkbox" name="noreply" value="1" class="pc"{if $blog[noreply]} checked="checked"{/if}> {lang comments_not_allowed}</label>
						</td>
					</tr>
					<tbody id="span_password" style="$passwordstyle">
						<tr>
							<td class="pns"><input type="text" name="password" placeholder="{lang password}" value="$blog[password]" onkeyup="value=value.replace(/[^\w\.\/]/ig,'')" class="px" /></td>
						</tr>
					</tbody>

				<!--{if $blog['uid'] && $blog['uid']!=$_G['uid']}-->
				</table>
				<table cellspacing="0" cellpadding="0" width="100%">
				<!--{/if}-->

					<tbody id="tb_selectgroup" style="$selectgroupstyle">
						<tr>
							
							<td>
                            	<p>{lang specified_friends}</p>
								<select name="selectgroup" onchange="getgroup(this.value);" class="ps">
									<option value="">{lang from_friends_group}</option>
									<!--{loop $groups $key $value}-->
									<option value="$key">$value</option>
									<!--{/loop}-->
								</select>
								<p class="d">{lang choices_following_friends_list}</p>
							</td>
						</tr>
						<tr>
							<td>
								<textarea name="target_names" id="target_names" rows="3" class="pt">$blog[target_names]</textarea>
								<p class="d">{lang friend_name_space}</p>
							</td>
						</tr>
					</tbody>

					<!--{if checkperm('manageblog')}-->
					<tr>
						
						<td>
                        	<p>{lang hot}</p>
							<input type="text" class="px" name="hot" id="hot" value="$blog[hot]" size="5" />
						</td>
					</tr>
					<!--{/if}-->
					<!--{if helper_access::check_module('feed')}-->
					<tr>
						
						<td>
                        	<p>{lang feed_option}</p>
							<label for="makefeed"><input type="checkbox" name="makefeed" id="makefeed" value="1" class="pc"{if ckprivacy('blog', 'feed')} checked="checked"{/if}>{lang make_feed}</label>
						</td>
					</tr>
					<!--{/if}-->
					<!--{if $secqaacheck || $seccodecheck}-->
					</table>
						<!--{eval $sectpl = '<table cellspacing="0" cellpadding="0" width="100%" class="tfm"><tr><th><sec></th><td class="pns"><sec><div class="d"><sec></div></td></tr></table>';}-->
						<!--{subtemplate common/seccheck}-->
					<table cellspacing="0" cellpadding="0" width="100%">
					<!--{/if}-->
				</table>
                <div class="pospn cl"><button type="submit" id="issuance" class="formdialog">{lang save_publish}</button></div>
				<input type="hidden" name="blogsubmit" value="true" />

				<input type="hidden" name="formhash" value="{FORMHASH}" />
			</form>
			<script type="text/javascript">
				function validate(obj) {
					<!--{if $_G['setting']['blogcategorystat'] && $_G['setting']['blogcategoryrequired']}-->
					var catObj = $("catid");
					if(catObj) {
						if (catObj.value < 1) {
							alert("{lang select_system_cat}");
							catObj.focus();
							return false;
						}
					}
					<!--{/if}-->
					var makefeed = $('makefeed');
					if(makefeed) {
						if(makefeed.checked == false) {
							if(!confirm("{lang no_feed_notice}")) {
								return false;
							}
						}
					}

					if($('seccode')) {
						var code = $('seccode').value;
						var x = new Ajax();
						x.get('home.php?mod=spacecp&ac=common&op=seccode&inajax=1&code=' + code, function(s){
							s = trim(s);
							if(s.indexOf('succeed') == -1) {
								alert(s);
								$('seccode').focus();
						   		return false;
							} else {
								edit_save();
								return true;
							}
						});
					} else {
						edit_save();
						return true;
					}
				}
			</script>


			<!--{hook/spacecp_blog_bottom}-->
			</div>
		</div>
	</div>
</div>

<!--{/if}-->
<script type="text/javascript">
function relatekw() {
	var subject = cnCode(document.getElementById('subject').value);
	var message = cnCode(document.getElementById('uchome-ttHtmlEditor').value);
	if(message) {
		message = message.substr(0, 500);
	}
	$.ajax({
		type : 'GET',
		url : 'home.php?mod=spacecp&ac=relatekw&subjectenc=' + subject + '&messageenc=' + message,
		dataType : 'xml'
	})
	.success(function(s) {
		var newkey = cnCode(s.lastChild.firstChild.nodeValue);
		if(newkey){
			document.getElementById('tag').value = newkey;
		}
	})
}

function cnCode(str) {
	str = str.replace(/<\/?[^>]+>|\[\/?.+?\]|"/ig, "");
	str = str.replace(/\s{2,}/ig, ' ');
	return str;
}
function addSort(obj) {
	if (obj.value == 'addoption') {
		$('#anewoption').css('display', 'block');
		$('#newsort').focus();
	}
}
function blogAddOption(sid, aid) {
	var obj = document.getElementById(aid);
	var newOption = document.getElementById(sid).value;
	newOption = newOption.replace(/^\s+|\s+$/g,"");
	document.getElementById(sid).value = "";
	if (newOption!=null && newOption!='') {
		var newOptionTag=document.createElement('option');
		newOptionTag.text=newOption;
		newOptionTag.value="new:" + newOption;
		try {
			obj.add(newOptionTag, obj.options[0]);
		} catch(ex) {
			obj.add(newOptionTag, obj.selecedIndex);
		}
		obj.value="new:" + newOption;
		var obj = document.getElementById(aid);
		obj.value=obj.options[0].value;
		$('#anewoption').css('display', 'none');
		popup.open('$alang_sz_success', 'alert');
	} else {
		popup.open('$alang_not_empty', 'alert');
		$('#newsort').focus();
	}
}	

</script>
<script type="text/javascript" src="{STATICURL}js/mobile/ajaxfileupload.js?{VERHASH}"></script>
<script type="text/javascript" src="{STATICURL}js/mobile/buildfileupload.js?{VERHASH}"></script>
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
	$(document).on('change', '#filedata', function() {
		var afile = new Array();
		var afileon = 0;
		var afilelength = this.files.length;	
			Zepto('.page').append('<div class="ainuooverlay"><div class="preloader-indicator-overlay"></div><div class="preloader-indicator-modal"><span class="preloader preloader-white"></span></div></div>');

			uploadsuccess = function(data) {
				afileon++;
				var err = aupload_success(data);
				if(err == false){
					return false;
				}
				if(afileon == afilelength){
					Zepto('.ainuooverlay').remove();
				}		
			};
			uploaderror = function() {
				afileon++;
				popup.open('{lang uploadpicfailed}', 'alert');
			};

			if(typeof FileReader != 'undefined' && this.files[0]) {
				for (var i = 0; i < this.files.length; i++){
					afile[0] = this.files[i];
					$.buildfileupload({
						uploadurl:'misc.php?mod=swfupload&action=swfupload&operation=album&type=image',
						files:this.files,
						uploadformdata:{uid:"$_G[uid]", hash:"$swfconfig[hash]"},
						uploadinputname:'Filedata',
						maxfilesize:"$swfconfig[max]",
						success:uploadsuccess,
						error:function() {
							popup.open('{lang uploadpicfailed}', 'alert');
						}
					});
				}
			} else {

				$.ajaxfileupload({
					url:'misc.php?mod=swfupload&action=swfupload&operation=album&type=image',
					data:{uid:"$_G[uid]", hash:"$swfconfig[hash]"},
					dataType:'text',
					fileElementId:'filedata',
					success:uploadsuccess,
					error: function() {
						popup.open('{lang uploadpicfailed}', 'alert');
					}
				});

			}
	});
	function aupload_success(data){
		if(data == '') {popup.open('{lang uploadpicfailed}', 'alert');}
		var dataarr = eval('('+data+')');
		Zepto('.ainuooverlay').remove();
		$('#imglist').append('<li><span aid="'+dataarr['picid']+'" class="del"><a href="javascript:;"><img src="{STATICURL}image/mobile/images/icon_del.png"></a></span><span class="p_img"><a href="javascript:;"><img style="height:54px;width:54px;" id="aimg_'+dataarr['picid']+'" title="'+dataarr['picid']+'" src="'+dataarr['bigimg']+'" /></a></span><input type="hidden" name="picids['+dataarr['picid']+']" /></li>');
	}


	<!--{if 0 && $_G['setting']['mobile']['geoposition']}-->
	geo.getcurrentposition();
	<!--{/if}-->
	
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

<!--{template common/footer}-->