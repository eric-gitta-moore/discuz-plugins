<?php (!defined('IN_SANREE')&&exit('Power By ymg6.Com'))?>
<!--{template common/header}-->
<link rel="stylesheet" type="text/css" href="data/cache/style_{STYLEID}_home_space.css?{VERHASH}" />
<link rel="stylesheet" type="text/css" id="sanree_brand" href="source/plugin/sanree_brand_signature/tpl/default/sanree_brand_signature.css?{VERHASH}" />
<script language="javascript">
function sendpost(obj){		
	ajaxpost('postform', 'return_error', 'return_error' , '', '',function(){srshowdialog();});
	return false;					
}
</script>	
<script src="{sr_brand_signature_JS}/msg{C_CHARSET}.js"></script>
	<div id="pt" class="bm cl">
		<div class="z">
			<a href="./" class="nvhm" title="{lang homepage}">$_G[setting][bbname]</a> <em>&rsaquo;</em>
			<a href="{$allurl}">{$brand_config['mantitle']}</a>			
		</div>
	</div>
	<div id="ct" class="ct2_a wp cl">
			<div class="appl">
				<div class="tbn">
					<h2 class="mt bbda">{$brand_config['mantitle']}</h2>
					<ul>
						<li$actives[me]><a href="plugin.php?id=sanree_brand&mod=mybrand&view=me">{lang sanree_brand:mybrand}({$bcount[3]})</a></li>
						<li$actives[mymsg]><a href="plugin.php?id=sanree_brand&mod=mybrand&view=mymsg">{lang sanree_brand:mymsg}</a></li>
						<!--{hook/sanree_brand_userbar}-->
					</ul>
				</div>
			</div>
			<div class="mn pbm" style="border:none; margin:0">
			<div class="tbmu cl">
				<ul class="tb cl">
				    <li class="a"><a>{lang sanree_brand_signature:signatureconfig}</a></li>
				</ul>
				<div id="return_error" style=" display:none"></div>
				<FORM id=postform onsubmit="return sendpost(this);" method=post action="plugin.php?id=sanree_brand_signature&mod=mysignature" autocomplete="off">
				<input type="hidden" name="formhash" id="formhash" value="{FORMHASH}" />
				<input type="hidden" name="posttime" id="posttime" value="{TIMESTAMP}" />
				<input type="hidden" name="postsubmit" value="1" /> 		
				<table cellspacing="5" cellpadding="5" width="100%">
					<tr class="lineshow">
						<th colspan="2">{lang sanree_brand_signature:selectedtip}</th>						
					</tr>
					<tr class="lineshow">
						<th class="ntitle" valign="middle" style="width:150px;">{lang sanree_brand_signature:allowshowsignature}</th>
						<th><input type="radio" name="allowshowsignature" value="1" {$checkallowshowsignature[0]}/>{lang sanree_brand_signature:yes} <input type="radio" name="allowshowsignature" value="0"  {$checkallowshowsignature[1]}/>{lang sanree_brand_signature:no} </th>						
					</tr>											
					<tr class="lineshow">
						<th class="ntitle" valign="middle" style="width:150px;">{lang sanree_brand_signature:selected}</th>
						<th>{$brandlist}</th>						
					</tr>				
					<tr>
						<td colspan="2" align="center"><input type="submit" class="sanreebtn pn pnc"  value="{lang sanree_brand_signature:temp_submit}"></td>						
					</tr>																														
				</table>
				</form>
			</div>
		</div>
	</div>
<!--{template common/footer}-->