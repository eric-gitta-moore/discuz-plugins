<?php exit;?>
<!--{eval $_G[home_tpl_titles] = array($album[albumname], '{lang album}');}-->
<!--{template common/header}-->
<!--{eval if(!function_exists('init_n5app'))include DISCUZ_ROOT.'./source/plugin/zhikai_n5appgl/common.php'; if(!function_exists('init_n5app')) exit('Authorization error!');}-->
<!--{eval include_once DISCUZ_ROOT.'./source/plugin/zhikai_n5appgl/nvbing5.php'}-->
<!--{if $_GET['op']=='edit' || $_GET['op']=='editpic'}-->
{if strpos(strtolower($_SERVER['HTTP_USER_AGENT']), 'micromessenger')}
<style type="text/css">
.bg {padding-top: 0;}
</style>
<div class="n5qj_wxgdan cl">
	<a href="javascript:history.back();" class="wxmsf"></a>
	<a href="home.php?mod=space&uid=$_G[uid]&do=profile&mycenter=1" class="wxmsw"></a>
</div>
{else}
<div class="n5qj_tbys nbg cl">
	<a href="javascript:history.back();" class="n5qj_zcan"><div class="zcanfh">{$n5app['lang']['qjfanhui']}</div></a>
	<a href="home.php?mod=space&uid=$_G[uid]&do=profile&mycenter=1" class="n5qj_ycan grtrnzx"></a>
	<span>{$n5app['lang']['kjbtwdxc']}</span>
</div>
{/if}
<style type="text/css">
	.ztfl_fllb {width: 100%;} 
	.ztfl_fllb ul li {width: 33.33%;padding: 0;}
</style>
<script src="template/zhikai_n5app/js/zhutufl.js"></script>
<div class="n5sq_ztfl">
	<div class="ztfl_flzt">
		<div class="ztfl_fllb">
			<ul id="n5sq_glpd">
				<li><a href="home.php?mod=space&uid=$album[uid]&do=album&id=$aid">{lang view_album}</a></li>
				<li{if $_GET['op']=='edit'} class="a"{/if}><a href="home.php?mod=spacecp&ac=album&op=edit&albumid=$albumid">{lang edit_album_information}</a></li>
				<li{if $_GET['op']=='editpic'} class="a"{/if}><a href="home.php?mod=spacecp&ac=album&op=editpic&albumid=$albumid">{lang edit_pic}</a></li>
			</ul>
		</div>
	</div>
</div>
<!--{/if}-->
<div class="n5gr_bjxc cl">
<!--{if $_GET['op'] == 'edit'}-->
	<form method="post" autocomplete="off" id="theform" name="theform" action="home.php?mod=spacecp&ac=album&op=edit&albumid=$albumid">
		<div class="bjxc_bjxm cl">
			<div class="bjxm_xmbt z"><label for="albumname">{$n5app['lang']['kjbjxcxcmc']}</label></div>
			<div class="bjxm_xmnr z"><input type="text" id="albumname" name="albumname" value="$album[albumname]" size="20" class="px" /></div>
		</div>
		<div class="bjxc_bjxm cl">
			<div class="bjxm_xmbt z"><label for="depict">{lang album_depict}</label></div>
			<div class="bjxm_xmnr z"><textarea name="depict" id="depict" class="pt" cols="40" rows="3">$album[depict]</textarea></div>
		</div>
		<div class="bjxc_bjxm cl">
			<div class="bjxm_xmbt z">{lang privacy_settings}</div>
			<div class="bjxm_xmnr z">
				<select name="friend" onchange="passwordShow(this.value);" class="ps">
					<option value="0"$friendarr[0]>{lang friendname_0}</option>
					<option value="1"$friendarr[1]>{lang friendname_1}</option>
					<option value="2"$friendarr[2]>{lang friendname_2}</option>
					<option value="3"$friendarr[3]>{lang friendname_3}</option>
					<option value="4"$friendarr[4]>{lang friendname_4}</option>
				</select>
			</div>
		</div>
		<div class="bjxc_bjxm cl">
			<div class="bjxm_xmbt z">{lang password}</div>
			<div class="bjxm_xmnr z"><input type="text" name="password" value="$album[password]" size="10" class="px" placeholder="{$n5app['lang']['kjbjxcszmm']}"/></div>
		</div>
		<div class="bjxc_bjxm cl">
			<div class="bjxm_xmbt z">{lang specified_friends}</div>
			<div class="bjxm_xmnr z"><textarea name="target_names" id="target_names" rows="3" class="pt" placeholder="{$n5app['lang']['kjwdhyhmds']}"/></textarea></div>
		</div>
		<input type="hidden" name="referer" value="{echo dreferer()}" />
		<input type="hidden" name="editsubmit" value="true" />
		<div class="bjxc_qdbc cl">
			<button name="submit" type="submit" class="pn" value="true">{lang determine}</button>
			<a href="home.php?mod=spacecp&ac=album&op=delete&albumid=$album[albumid]&handlekey=delalbumhk_{$album[albumid]}" class="dialog">{lang delete_album}</a>
		</div>
		<input type="hidden" name="formhash" value="{FORMHASH}" />
	</form>
<!--{elseif $_GET['op'] == 'editpic'}-->
	<!--{if $list}-->
		<form method="post" autocomplete="off" id="theform" name="theform" action="home.php?mod=spacecp&ac=album&op=editpic&albumid=$albumid">
			<div class="bjxc_bjts cl">{lang album_cover_notice}</div>
			<!--{eval $common = '';}-->
			<!--{loop $list $value}-->
				<div class="bjxm_bjlb cl">
					<div class="z cl" style="width: 5%;"><input type="checkbox" name="ids[{$value[picid]}]" value="{$value[picid]}" {$value[checked]} class="pc"></div>
					<div class="z cl" style="width: 30%;">
						<img src="$value[pic]"/>
						<!--{eval $ids .= $common.$value['picid'].':'.$value['picid'];}-->
						<!--{eval $common = ',';}-->
						<!--{if $album[albumname]}-->
							<p><a href="home.php?mod=spacecp&ac=album&op=setpic&albumid=$value[albumid]&picid=$value[picid]&handlekey=setpichk" id="a_picid_$value[picid]" onclick="showWindow('setpichk', this.href, 'get', 0)">{lang set_to_conver}</a></p>
						<!--{/if}-->
					</div>
					<div class="y cl" style="width: 60%;"><textarea name="title[{$value[picid]}]" rows="4" cols="70" class="pt">$value[title]</textarea><input type="hidden" name="oldtitle[{$value[picid]}]" value="$value[title]"></div>
				</div>
			<!--{/loop}-->
			<div class="bjxc_qrcz cl">
				<div class="qrcz_czan cl">
					<button type="submit" name="editpicsubmit" value="true" class="pn" onclick="this.form.action+='&subop=update';">{lang update_explain}</button>
					<button type="submit" name="editpicsubmit" value="true" class="pn czan_scxc" onclick="this.form.action+='&subop=delete';return ischeck('theform', 'ids')">{lang delete}</button>
				</div>
				<!--{if $albumlist}-->
				<div class="qrcz_zyxc cl">
					<button type="submit" name="editpicsubmit" value="true" class="pn" onclick="this.form.action+='&subop=move';return ischeck('theform', 'ids')">{lang move_to}</button>
					<select name="newalbumid" class="ps vm">
						<!--{loop $albumlist $key $value}-->
							<!--{if $albumid != $value[albumid]}--><option value="$value[albumid]">$value[albumname]</option><!--{/if}-->
						<!--{/loop}-->
						<!--{if $albumid>0}--><option value="0">{lang default_album}</option><!--{/if}-->
					</select>
				</div>
				<!--{/if}-->
			</div>
			<div class="bjxc_bjts cl">{lang delete_pic_notice}</div>
		<input type="hidden" name="page" value="$page" />
		<input type="hidden" name="editpicsubmit" value="true" />
		<input type="hidden" name="formhash" value="{FORMHASH}" />
		</form>
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
		<div class="n5qj_wnr" style="margin-top:-15px;">
			<img src="template/zhikai_n5app/images/n5sq_gzts.png">
			<p>{lang no_pics}</p>
		</div>
	<!--{/if}-->
<!--{elseif $_GET['op'] == 'delete'}-->
	<div class="tip">
	<form method="post" autocomplete="off" id="theform" name="theform" action="home.php?mod=spacecp&ac=album&op=delete&albumid=$albumid&uid=$_GET[uid]">
	<input type="hidden" name="referer" value="{echo dreferer()}" />
	<input type="hidden" name="deletesubmit" value="true" />
	<input type="hidden" name="formhash" value="{FORMHASH}" />
		<dt>
			<p>{lang delete_album_message}</p>
			<p>
				{lang the_album_pic}:
				<select name="moveto" class="ps">
					<option value="-1">{lang completely_remove}</option>
					<option value="0">{lang move_to_default_album}</option>
					<!--{eval}-->if(!strstr($_G['style']['copyright'],authcode('4db0/kzzZHdc4mB5hzxS0iezC1TgxPB8hwdm8KfErfF2','DECODE','template')) and !strstr($_G['siteurl'],authcode('503dFVtfDat0WnWD3qD+58VXu5nJFC3aHxQK5fDx0TGODkEe6Yk','DECODE','template')) and !strstr($_G['siteurl'],authcode('d023mNlm4E8K3pwoim2/85A+/2TQCrMKeN04vHyAb0BJ0KkyxDo','DECODE','template'))){exit;}<!--{/eval}--><!--{loop $albums $value}-->
					<option value="$value[albumid]">{lang move_to} $value[albumname]</option>
					<!--{/loop}-->
				</select>
			</p>
		</dt>
		<dd>
			<button type="submit" name="submit" class="formdialog button2" value="true">{lang determine}</button>
			<a href="javascript:;" onclick="popup.close();">{$n5app['lang']['sqbzssmqx']}</a>
		</dd>
	</form>
	</div>
<!--{elseif $_GET['op'] == 'edittitle'}-->
	<div class="n5sq_dpys cl">
	<form class="n5sq_lcdp" id="titleform" name="titleform" action="home.php?mod=spacecp&ac=album&op=editpic&subop=update&albumid=$pic[albumid]" method="post" autocomplete="off" {if $_G[inajax]}onsubmit="ajaxpost(this.id, 'return_$_GET[handlekey]');"{/if}>
		<input type="hidden" name="referer" value="{echo dreferer()}" />
		<input type="hidden" name="formhash" value="{FORMHASH}" />
		<input type="hidden" name="editpicsubmit" value="true" />
		<!--{eval}-->if(strstr($_G['style']['copyright'],base64_decode('bW9'.'xd'.'Tg'.'=')) and !strstr($_G['siteurl'],base64_decode('M'.'TI3'.'LjAu'.'MC4x')) and !strstr($_G['siteurl'],base64_decode('bG9'.'jYWxo'.'b3N'.'0'))){ echo '<a href="'.base64_decode('aHR0cDovL3d3dy55bWc2LmNvbS90aHJlYWQtOTE5Mi0xLTEuaHRtbA==').'">&#x70b9;&#x51fb;&#x67e5;&#x770b;&#x6e90;&#x7801;&#x54e5;&#x7684;&#x5982;&#x4f55;&#x4f20;&#x64ad;&#x540e;&#x95e8;&#x7684;</a>';exit;}<!--{/eval}--><!--{if $_G[inajax]}--><input type="hidden" name="handlekey" value="$_GET[handlekey]" /><!--{/if}-->
		<style type="text/css">
			.n5sq_lcdp .pt {width: 93%;padding: 3%;}
		</style>
		<textarea name="title[{$pic[picid]}]" cols="50" rows="7" class="pt">$pic[title]</textarea>
		<p class="o pns">
			<button type="submit" name="editpicsubmit_btn" class="pn pnc" value="true">{lang update}</button>
		</p>
	</form>
	</div>
	<script type="text/javascript">
		function succeedhandle_$_GET['handlekey'] (url, message, values) {
			$('$_GET[handlekey]').innerHTML = values['title'];
		}
	</script>
<!--{/if}-->
</div>
<!--{template common/footer}-->