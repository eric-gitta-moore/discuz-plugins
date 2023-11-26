<?PHP exit('QQÈº£º550494646');?>
<!--{template common/header}-->
	<!--{subtemplate home/spacecp_header}-->
			<!--{hook/spacecp_promotion_top}-->
			<!--{if $_G['setting']['creditspolicy']['promotion_visit'] || $_G['setting']['creditspolicy']['promotion_register']}-->
				<div class="dashedtip cl">
					<!--{if $_G['setting']['creditspolicy']['promotion_visit']}--><p>
						{lang post_promotion_url}
					</p><!--{/if}-->

					<!--{if $_G['setting']['creditspolicy']['promotion_register']}-->
					<p>
					<!--{if $_G['setting']['creditspolicy']['promotion_visit']}-->
						{lang post_promotion_reg}
					<!--{else}-->
						{lang post_promotion}
					<!--{/if}-->
					</p>
					<!--{/if}--><!--From www.moq u8 .com -->
				</div>
                <div class="tuiguang cl">
				<table cellspacing="0" cellpadding="0" width="100%">
					<tr>
						<td class="pns">
                        <p>{lang post_promotion_url1}</p>
							<input type="text" class="px vm" onclick="this.select();setCopy('{$copystr}'+'\n'+this.value, '{lang promotion_url_copied}');" value="$_G[siteurl]?fromuid=$_G[uid]" />
							
						</td>
					</tr>
					<tr>
						
						<td class="pns">
                        <p>{lang post_promotion_url2}</p>
							<input type="text" class="px vm" onclick="this.select();setCopy('{$copystr}'+'\n'+this.value, '{lang promotion_url_copied}');" value="$_G[siteurl]?fromuser={echo rawurlencode($_G[username])}" />
							
						</td>
					</tr>
				</table>
                </div>
			<!--{/if}-->
			<!--{hook/spacecp_promotion_bottom}-->
		</div>
	</div>
</div>
<!--{template common/footer}-->