<?PHP exit('QQÈº£º550494646');?>
<!--{template common/header}-->

<header class="header">
    <div class="nav">
        <a href="javascript:;" onclick="history.go(-1)" class="z"><i class="iconfont icon-back"></i></a>
        <span class="name">{lang upload_pic}</span>
    </div>
</header>

<!--{if $albumid}-->
<div class="ainuo_usertb cl">
    <ul class="tb amyth cl">
       <li><a href="home.php?mod=spacecp&ac=album&op=edit&albumid=$albumid">{lang edit_album_information}</a></li>
		<li><a href="home.php?mod=spacecp&ac=album&op=editpic&albumid=$albumid">{lang edit_pic}</a></li>
    </ul>
</div>
<div class="grey_line cl"></div>
<!--{/if}-->
<div class="ainuo_album_upload cl">
	<div class="cl">
		<div class="cl">
			<div class="cl">

			<!--{if $haveattachsize}--><!--From ww w.moq u8 .com -->
			<div class="dashedtip cl">
				{lang hava_attach_size} <strong>$haveattachsize</strong> (<a href="home.php?mod=spacecp&ac=upload&op=recount">{lang recount}</a>)
				<!--{if $_G['setting']['magicstatus'] && $_G[setting][magics][attachsize]}-->
				<br />
				<img src="{STATICURL}image/magic/attachsize.small.gif" alt="attachsize" class="vm" />
				<a id="a_magic_attachsize" href="home.php?mod=magic&mid=attachsize" onclick="showWindow('magics', this.href, 'get', 0)">{lang i_want_more_space}</a>
				({lang you_can_buy_magictools})
				<!--{/if}--><!--From www.moq u8 .com -->
			</div>
			<!--{/if}-->

		<!--{if empty($_GET['op'])}-->
		<form method="post" autocomplete="off" id="albumform" action="home.php?mod=spacecp&ac=upload" onsubmit="return validate(this);">
			
			<div class="acon1 cl">
				<div class="atit cl">{lang select_pic}</div>
                <div class="dashedtip cl">$alang_uppic</div>
                <div class="uppic cl">
                	<input type="file" name="Filedata" id="filedata" multiple="multiple">
                	<a href="javascript:;"><i class="iconfont icon-add1"></i>{lang upload_pic}</a>
                </div>
                <div class="imglist cl">
                	<ul id="imglist">
                    </ul>
                </div>
			</div>

				<script type="text/javascript">
					var check = false;
					no_insert = 1;
					function a_addOption() {
						var obj = $('uploadalbum');
						obj.value = 'addoption';
						addOption(obj);
					}

					function album_op(id) {
						document.getElementById('selectalbum').style.display = 'none';
						document.getElementById('creatalbum').style.display = 'none';
						document.getElementById(id).style.display = '';
						check = false;
						if(id == 'creatalbum') {
							check = true;
							document.getElementById('albumname').select();
						}
					}
				</script>
				<div class="grey_line cl"></div>				
				<div class="acon2 cl">
                	<div class="atit cl">{lang select_album}</div>
					<!--{if $albums}-->
					<div class="xzxc cl">
						<label for="albumop_selectalbum" class="lb"><input type="radio" name="albumop" id="albumop_selectalbum" class="pr" value="selectalbum" checked="checked" onclick="album_op(this.value);" />{lang add_to_existing_album}</label>
						<label for="albumop_creatalbum" class="lb"><input type="radio" name="albumop" id="albumop_creatalbum" class="pr" value="creatalbum" onclick="album_op(this.value);" />{lang create_new_album}</label>
					</div>
					<div id="selectalbum" class="cl">
						<p>{lang select_album}</p>
						<select name="albumid" id="uploadalbumid">
						<!--{loop $albums $value}-->
							<!--{if $value['albumid'] == $_GET['albumid']}-->
								<option value="$value[albumid]" selected="selected">$value[albumname]</option>
							<!--{else}-->
								<option value="$value[albumid]">$value[albumname]</option>
							<!--{/if}-->
						<!--{/loop}-->
						</select>
					</div>
					<div id="creatalbum" style="display:none;">
					<!--{else}-->
					<p class="hm cl" style=" background:#f8f8f8; font-size:14px; padding:10px 0;">{lang create_new_album}</p>
					<input type="hidden" name="albumop" value="creatalbum" />
					<div id="creatalbum">
					<!--{/if}-->
						<table cellspacing="0" cellpadding="0" width="100%">
							<tr>
								<th>{lang album_name}</th>
								<td><input type="text" name="albumname" id="albumname" class="px" value="{lang my_album}" /></td>
							</tr>
							<tr>
								<th>{lang album_depict}</th>
								<td><textarea name="depict" class="px" rows="3"></textarea></td>
							</tr>
							<!--{if $_G['setting']['albumcategorystat'] && $categoryselect}-->
							<tr>
								<th>{lang site_categories}</th>
								<td>
									$categoryselect
									<p class="d">{lang select_site_album_categories}</p>
								</td>
							</tr>
							<!--{/if}-->
							<tr>
								<th>{lang privacy_settings}</th>
								<td>
									<select name="friend" id="uploadfriend" onchange="passwordShow(this.value);" class="ps">
										<option value="0">{lang friendname_0}</option>
										<option value="1">{lang friendname_1}</option>
										<option value="2">{lang friendname_2}</option>
										<option value="3">{lang friendname_3}</option>
										<option value="4">{lang friendname_4}</option>
									</select>
								</td>
							</tr>
							<tbody id="span_password" style="display:none;">
								<tr>
									<th>{lang password}</th>
									<td><input type="text" name="password" id="uploadpassword" class="px" value="" size="10" /></td>
								</tr>
							</tbody>
							<tbody id="tb_selectgroup" style="display:none;">
								<tr>
									<th>{lang specified_friends}</th>
									<td>
										<select name="selectgroup" class="ps" onchange="getgroup(this.value);">
											<option value="">{lang from_friends_group}</option>
											<!--{loop $groups $key $value}-->
											<option value="$key">$value</option>
											<!--{/loop}-->
										</select>
										<p class="d">{lang choices_following_friends_list}</p>
									</td>
								</tr>
								<tr>
									<th>&nbsp;</th>
									<td>
										<textarea name="target_names" id="target_names" class="pt" rows="3"></textarea>
										<p class="d">{lang friend_name_space}</p>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
				<div class="upbtn cl">
					<input type="hidden" name="albumsubmit" id="albumsubmit" value="true" />
					<button type="submit" name="albumsubmit_btn" id="albumsubmit_btn" class="formdialog" value="true"{if $_G['setting']['albumcategoryrequired']} onclick="return validate(this);"{/if}>{lang upload_start}</button>
					<input type="hidden" name="formhash" value="{FORMHASH}" />
				</div>
			</form>

			<script type="text/javascript">
				<!--{if empty($albums)}-->
					if(typeof $('albumname') == 'object') {
						$('albumname').select();
					}
				<!--{/if}-->
				function validate(obj) {
					if(!$('attachbody').getElementsByTagName('tr').length) {
						showDialog('{lang select_upload_pic}', 'notice', '{lang reminder}', null, 0);
						return false;
					}
					<!--{if $_G['setting']['albumcategorystat'] && $_G['setting']['albumcategoryrequired']}-->
					var catObj = $("catid");
					if(catObj && check) {
						if (catObj.value < 1) {
							showDialog('{lang select_system_cat}', 'notice', '{lang reminder}', null, 0);
							catObj.focus();
							return false;
						}
					}
					<!--{/if}-->
					return true;
				}
			</script>

		<!--{elseif $_GET['op'] == 'cam'}-->
		</div>
		<div class="bm">
			<script type="text/javascript">
				document.write(AC_FL_RunContent(
					'width', '100%', 'height', '415',
					'src', '{IMGDIR}/cam.swf?config=$config&albumid=$_GET[albumid]',
					'quality', 'high', 'wmode', 'transparent'
				));
			</script>
		<!--{/if}-->

		</div>
	</div>
	</div>
</div>

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
					Zepto.toast('$nh_upsucess',1500,'toast');
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
						files:afile,
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
	function aupload_success(aa){
		if( aa== '') {popup.open('{lang uploadpicfailed}', 'alert');}
		var dataarr = eval('('+aa+')');
		//Zepto('.ainuooverlay').remove();
		$('#imglist').append('<li><div class="picon cl"><span aid="'+dataarr['picid']+'" class="del"><a href="javascript:;"><img src="{STATICURL}image/mobile/images/icon_del.png"></a></span><span class="p_img"><a href="javascript:;"><img id="aimg_'+dataarr['picid']+'" title="'+dataarr['picid']+'" src="'+dataarr['bigimg']+'" /></a></span><input type="hidden" name="picids['+dataarr['picid']+']" /></div><div class="picdes cl"><textarea name="title['+dataarr['picid']+']" placeholder="{$alang_picdes}" class="px"></textarea></div></li>');

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
			obj.parent().parent().remove();
		})
		.error(function() {
			popup.open('{lang networkerror}', 'alert');
		});
		return false;
	});

</script>
<!--{template common/footer}-->