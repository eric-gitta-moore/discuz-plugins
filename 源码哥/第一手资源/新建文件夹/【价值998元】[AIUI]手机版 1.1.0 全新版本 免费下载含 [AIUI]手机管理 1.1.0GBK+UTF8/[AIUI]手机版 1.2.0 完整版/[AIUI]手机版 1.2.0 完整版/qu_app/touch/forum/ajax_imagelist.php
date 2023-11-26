<?PHP exit('QQÈº£º550494646');?>
<!--{if $imagelist}-->
	<!--{if $_GET[type] != 'single'}-->
	<!--{eval $i = 0;}-->
	<table cellspacing="2" cellpadding="2" class="imgl"><tr>
	<!--{/if}-->
	<!--{loop $imagelist $image}-->
		<!--{eval $i++;}-->
		<!--{if $_GET[type] != 'single'}-->
		<td valign="bottom" id="image_td_$image[aid]" width="25%">
		<!--{/if}-->
			<a href="javascript:;" title="$image[filename]" id="imageattach$image[aid]"><img src="{echo getforumimg($image[aid], 1, 150, 150, 'fixnone')}" id="image_$image[aid]" onclick="insertAttachimgTag('$image[aid]');doane(event);" width="{if $image[width] < 150}$image[width]{else}150{/if}" cwidth="{if $image[width] < 150}$image[width]{else}150{/if}" /></a>
			<p class="shanchu">
				<a href="javascript:;" onclick="delImgAttach($image[aid],{if !$attach[pid]}1{else}0{/if});return false;">{lang e_attach_del}</a>
			</p>
			<p style="display:none;">
				<!--{if $image['description']}-->
					<input type="text" name="attachnew[{$image[aid]}][description]" class="px xg2" value="$image[description]" id="image_desc_$image[aid]" />
				<!--{else}-->
					<input type="text" class="px xg2" value="{lang description}" onclick="this.style.display='none';$('image_desc_$image[aid]').style.display='';$('image_desc_$image[aid]').focus();" />
					<input type="text" name="attachnew[{$image[aid]}][description]" class="px" style="display: none" id="image_desc_$image[aid]" />
				<!--{/if}-->
			</p>
		</td>
		<!--{if $_GET[type] != 'single' && $i % 4 == 0 && isset($imagelist[$i])}--></tr><tr><!--{/if}-->
	<!--{/loop}-->
	<!--{if $_GET[type] != 'single'}-->
	<!--{if ($imgpad = $i % 4) > 0}--><!--{echo str_repeat('<td width="25%"></td>', 4 - $imgpad);}--><!--{/if}-->
	</tr></table>
	<!--{/if}-->
	<!--{if $_G[inajax]}-->
		<script type="text/javascript" reload="1">
		ATTACHNUM['imageunused'] += <!--{echo count($imagelist)}-->;
		updateattachnum('image');
		if($('attachlimitnotice')) {
			ajaxget('forum.php?mod=ajax&action=updateattachlimit&fid=' + fid, 'attachlimitnotice');
		}
		</script>
	<!--{/if}-->
<!--{/if}-->