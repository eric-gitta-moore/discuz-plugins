<?PHP exit('QQÈº£º550494646');?>
<!--{eval $_G[home_tpl_titles] = array($album[albumname], '{lang album}');}-->
<!--{template common/header}-->

<!--{if $_GET['op']=='edit' || $_GET['op']=='editpic'}-->
<header class="header">
    <div class="nav">
        <a href="javascript:;" onclick="history.go(-1)" class="z"><i class="iconfont icon-back"></i></a>
        <span class="category"><span class="name">{lang edit_album}</span></span>
    </div>
</header>

<div class="ainuo_pic_edit cl">
    <div class="ainuo_usertb cl">
        <ul class="tb aeditpic cl">
           <!--{eval $aid = $albumid ? $albumid : -1;}-->
            <li{if $_GET['op']=='edit'} class="a"{/if}><a href="home.php?mod=spacecp&ac=album&op=edit&albumid=$albumid">{lang edit_album_information}</a></li>
            <li{if $_GET['op']=='editpic'} class="a"{/if}><a href="home.php?mod=spacecp&ac=album&op=editpic&albumid=$albumid">{lang edit_pic}</a></li>
            <li><a href="home.php?mod=space&uid=$album[uid]&do=album&id=$aid">{lang view_album}</a></li>
        </ul>
    </div>
	<div class="grey_line cl"></div>

	<div class="cl">
		<div class="cl">
			
<!--{/if}-->

<!--{if $_GET['op'] == 'edit'}-->
			<div class="acon1 cl">
			<form method="post" autocomplete="off" id="theform" name="theform" action="home.php?mod=spacecp&ac=album&op=edit&albumid=$albumid">
				<table cellspacing="0" cellpadding="0" width="100%">
					<tr>
						<th><label for="albumname">{lang album_name}</label></th>
						<td><input type="text" id="albumname" name="albumname" value="$album[albumname]" class="px" /></td>
					</tr>
					<tr>
						<th><label for="depict">{lang album_depict}</label></th>
						<td><textarea name="depict" id="depict" class="px" rows="3">$album[depict]</textarea></td>
					</tr>
					<!--{if $categoryselect}-->
					<tr>
						<th>{lang site_categories}</th>
						<td>
							$categoryselect
							({lang select_site_album_categories})
						</td>
					</tr>
					<!--{/if}-->
					<tr>
						<th>{lang privacy_settings}</th>
						<td>
							<select name="friend" onchange="passwordShow(this.value);" class="ps">
								<option value="0"$friendarr[0]>{lang friendname_0}</option>
								<option value="1"$friendarr[1]>{lang friendname_1}</option>
								<option value="2"$friendarr[2]>{lang friendname_2}</option>
								<option value="3"$friendarr[3]>{lang friendname_3}</option>
								<option value="4"$friendarr[4]>{lang friendname_4}</option>
							</select>
						</td>
					</tr>
					<tbody id="span_password" style="$passwordstyle">
						<tr>
							<th>{lang password}</th>
							<td><input type="text" name="password" value="$album[password]" class="px" /></td>
						</tr>
					</tbody>
					<tbody id="tb_selectgroup" style="$selectgroupstyle">
						<tr>
							<th>{lang specified_friends}</th>
							<td>
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
							<th>&nbsp;</th>
							<td>
								<textarea name="target_names" id="target_names" rows="3" class="px">$album[target_names]</textarea>
								<p class="d">{lang friend_name_space}</p>
							</td>
						</tr>
					</tbody>
					<tr>
						<td colspan="2">
                        	<div class="upbtn cl">
							<input type="hidden" name="referer" value="{echo dreferer()}" />
							<input type="hidden" name="editsubmit" value="true" />
							<button name="submit" type="submit" class="formdialog" value="true">{lang determine}</button>
                            </div>
						</td>
					</tr>
					
				</table>
				<input type="hidden" name="formhash" value="{FORMHASH}" />
			</form>
			</div>
<!--{elseif $_GET['op'] == 'editpic'}-->

		<!--{if $list}-->
        <div class="acon2 cl">
			<form method="post" autocomplete="off" id="theform" name="theform" action="home.php?mod=spacecp&ac=album&op=editpic&albumid=$albumid">
				<table cellspacing="0" cellpadding="0" width="100%">
					<div class="dashedtip cl">{lang album_cover_notice}</div>
					<!--{eval $common = '';}-->
					<!--{loop $list $value}-->
					<tr>
						<td width="30" align="center"><input type="checkbox" name="ids[{$value[picid]}]" value="{$value[picid]}" {$value[checked]} class="pc"></td>
						<td width="84" align="left" class="gt">
							<img src="$value[pic]" width="74" />
							<!--{eval $ids .= $common.$value['picid'].':'.$value['picid'];}-->
							<!--{eval $common = ',';}-->
							<!--{if $album[albumname]}--><p><a ainuoto="home.php?mod=spacecp&ac=album&op=setpic&albumid=$value[albumid]&picid=$value[picid]&handlekey=setpichk" id="a_picid_$value[picid]" class="ainuodialog">{lang set_to_conver}</a></p><!--{/if}-->
						</td>
						<td><textarea name="title[{$value[picid]}]" rows="3" class="px">$value[title]</textarea><input type="hidden" name="oldtitle[{$value[picid]}]" value="$value[title]"></td>
					</tr>
					<!--{/loop}-->
					<tr>
						<td colspan="3" class="pbtn">
							<label for="chkall" onclick="checkAll(this.form, 'ids')"><input type="checkbox" name="chkall" id="chkall" class="pc" />{lang select_all}</label>
							<button type="submit" name="editpicsubmit" value="true" class="pn" onclick="this.form.action+='&subop=update';"><strong>{lang update_explain}</strong></button>
							<button type="submit" name="editpicsubmit" value="true" class="pn" onclick="this.form.action+='&subop=delete';return ischeck('theform', 'ids')"><strong>{lang delete}</strong></button>

							<!--{if $albumlist}-->
							<button type="submit" name="editpicsubmit" value="true" class="pn" onclick="this.form.action+='&subop=move';return ischeck('theform', 'ids')"><strong>{lang move_to}</strong></button>
							<select name="newalbumid" class="ps vm">
							<!--{loop $albumlist $key $value}-->
							<!--{if $albumid != $value[albumid]}--><option value="$value[albumid]">$value[albumname]</option><!--{/if}-->
							<!--{/loop}-->
							<!--{if $albumid>0}--><option value="0">{lang default_album}</option><!--{/if}-->
							</select>
							<!--{/if}-->
							<div class="dashedtip cl">{lang delete_pic_notice}</div>
						</td>
					</tr>
				</table>
				<input type="hidden" name="page" value="$page" />
				<input type="hidden" name="editpicsubmit" value="true" />
				<input type="hidden" name="formhash" value="{FORMHASH}" />
			</form>
            </div>
			<!--{if $multi}--><div class="pgs cl">$multi</div><!--{/if}-->
			<script type="text/javascript">
				var picObj = {{$ids}};
				function succeedhandle_setpichk(url, msg, values) {
					for(var id in picObj) {
						$('a_picid_' + picObj[id]).innerHTML = "{lang set_to_conver}";
					}
					if(values['picid']) {
						$('a_picid_' + values['picid']).innerHTML = "{lang cover_pic}";
					}
				}
			</script>
		<!--{else}-->
			<div class="emp">{lang no_pics}</div>
		<!--{/if}-->

<!--{elseif $_GET['op'] == 'delete'}-->
<div class="ainuo_pop cl">
	<div class="atit cl">{lang delete_album}</div>
	<form method="post" autocomplete="off" id="theform" name="theform" action="home.php?mod=spacecp&ac=album&op=delete&albumid=$albumid&uid=$_GET[uid]">
		<input type="hidden" name="referer" value="{echo dreferer()}" />
		<input type="hidden" name="deletesubmit" value="true" />
		<input type="hidden" name="formhash" value="{FORMHASH}" />
		<div class="acon cl">
			<p>{lang delete_album_message}</p>
			<p>
				{lang the_album_pic}:
				<select name="moveto" class="ps">
					<option value="-1">{lang completely_remove}</option>
					<option value="0">{lang move_to_default_album}</option>
					<!--{loop $albums $value}-->
					<option value="$value[albumid]">{lang move_to} $value[albumname]</option>
					<!--{/loop}-->
				</select>
			</p>
		</div>
        <div class="ainuo_popbottom cl">
            <button type="submit" name="submit" class="formdialog aconfirm" value="true">{lang determine}</button>
        	<a href="javascript:;" onclick="popup.close()" class="acancel">{lang cancel}</a>
    	</div>
	</form>
</div>
<!--{elseif $_GET['op'] == 'edittitle'}-->
<div class="ainuo_pop cl">
	<div class="atit cl">{lang edit_description}</div>
	<form id="titleform" name="titleform" action="home.php?mod=spacecp&ac=album&op=editpic&subop=update&albumid=$pic[albumid]" method="post" autocomplete="off" {if $_G[inajax]}onsubmit="ajaxpost(this.id, 'return_$_GET[handlekey]');"{/if}>
		<input type="hidden" name="referer" value="{echo dreferer()}" />
		<input type="hidden" name="formhash" value="{FORMHASH}" />
		<input type="hidden" name="editpicsubmit" value="true" />
		<!--{if $_G[inajax]}--><input type="hidden" name="handlekey" value="$_GET[handlekey]" /><!--{/if}-->
		<div class="acon cl">
			<textarea name="title[{$pic[picid]}]"  rows="5" class="px">$pic[title]</textarea>
		</div>
        <div class="ainuo_popbottom cl">
            <button type="submit" name="editpicsubmit_btn" class="formdialog aconfirm" value="true">{lang update}</button>
        	<a href="javascript:;" onclick="popup.close()" class="acancel">{lang cancel}</a>
    	</div>
	</form>
</div>
	<script type="text/javascript">
		function succeedhandle_$_GET['handlekey'] (url, message, values) {
			$('$_GET[handlekey]').innerHTML = values['title'];
		}
	</script>
<!--{elseif $_GET[op] == 'edithot'}-->
<div class="ainuo_pop cl">
	<div class="atit cl">{lang adjust_hot}</div>
	<form method="post" autocomplete="off" action="home.php?mod=spacecp&ac=album&op=edithot&picid=$picid">
		<input type="hidden" name="referer" value="{echo dreferer()}" />
		<input type="hidden" name="hotsubmit" value="true" />
		<input type="hidden" name="formhash" value="{FORMHASH}" />
		<div class="acon cl">
			{lang new_hot}:<input type="text" name="hot" value="$pic[hot]" class="px" />
		</div>
        <div class="ainuo_popbottom cl">
            <button type="submit" name="btnsubmit" value="true" class="formdialog aconfirm">{lang determine}</button>
        	<a href="javascript:;" onclick="popup.close()" class="acancel">{lang cancel}</a>
    	</div>
	</form>
</div>
<!--{elseif $_GET[op] == 'saveforumphoto'}-->
<div class="ainuo_pop cl">
	<div class="atit cl">{lang save_to_album}</div>
	<form id="saveforumphoto" method="post" autocomplete="off" action="home.php?mod=spacecp&ac=album&op=saveforumphoto&aid=$_GET[aid]" {if $_G[inajax]}onsubmit="ajaxpost(this.id, 'return_$_GET[handlekey]');return false;"{/if}>
		<input type="hidden" name="referer" value="{echo dreferer()}" />
		<input type="hidden" name="savephotosubmit" value="true" />
		<input type="hidden" name="formhash" value="{FORMHASH}" />
		<input type="hidden" name="aid" value="$_GET[aid]" />
		<!--{if $_G[inajax]}--><input type="hidden" name="handlekey" value="$_GET[handlekey]" /><!--{/if}-->
		<div class="acon cl">
			{lang save_to}: <select name="albumid" class="ps vm">
			<!--{loop $albumlist $key $value}-->
				<option value="$value[albumid]">$value[albumname]</option>
			<!--{/loop}-->
			<option value="0">{lang default_album}</option>
			</select>
		</div>
		<div class="ainuo_popbottom cl">
			<button type="submit" name="btnsubmit" value="true" class="formdialog aconfirm">{lang determine}</button>
        	<a href="javascript:;" onclick="popup.close()" class="acancel">{lang cancel}</a>
		</p>
	</form>
</div>
	<script type="text/javascript">
		function succeedhandle_$_GET['handlekey'] (url, message, values) {
			
		}
	</script>
<!--{/if}-->

<!--{if $_GET['op']=='edit' || $_GET['op']=='editpic'}-->
		</div>
	</div>
</div>
<!--{/if}-->
<script>
function checkAll(form, name) {
	for(var i = 0; i < form.elements.length; i++) {
		var e = form.elements[i];
		if(e.name.match(name)) {
			e.checked = form.elements['chkall'].checked;
		}
	}
}
</script>
<!--{template common/footer}-->
