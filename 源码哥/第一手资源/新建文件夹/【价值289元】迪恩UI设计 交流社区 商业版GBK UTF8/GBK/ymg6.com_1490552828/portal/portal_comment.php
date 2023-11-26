
<div id="comment" class="bm">
  <div class="portal_tit cl"> 
    <em class="y">此篇文章已有<span style="color:#1A87F3; ">$data[commentnum]</span>人参与评论</em>
    <h3>请发表评论</h3>
    
  </div>
  <div id="comment_ul"> 
    
    <!--{if !empty($pricount)}-->
    <p class="mtn mbn y">{lang hide_portal_comment}</p>
    <!--{/if}--> 
    
    <!--{if !$data[htmlmade]}-->
    
    
    
    <form id="cform" name="cform" action="$form_url" method="post" autocomplete="off">
				<div class="tedt" id="tedt">
					<div class="area">
						<textarea name="message" rows="3" class="pt" id="message"  {if !$_G['uid']} placeholder="立即登录发表您的看法吧^0^"{/if} onkeydown="ctrlEnter(event, 'commentsubmit_btn');"></textarea>
					</div>
				</div>
                <div class="mb15 cl">


				<!--{if $secqaacheck || $seccodecheck}-->
					<!--{block sectpl}--><sec> <span id="sec<hash>" onclick="showMenu(this.id);"><sec></span><div id="sec<hash>_menu" class="p_pop p_opt" style="display:none"><sec></div><!--{/block}-->
					<div class="mtm z"><!--{subtemplate common/seccheck}--></div>
				<!--{/if}-->
				<!--{if !empty($topicid) }-->
					<input type="hidden" name="referer" value="$topicurl#comment" />
					<input type="hidden" name="topicid" value="$topicid">
				<!--{else}-->
					<input type="hidden" name="portal_referer" value="$viewurl#comment">
					<input type="hidden" name="referer" value="$viewurl#comment" />
					<input type="hidden" name="id" value="$data[id]" />
					<input type="hidden" name="idtype" value="$data[idtype]" />
					<input type="hidden" name="aid" value="$aid">
				<!--{/if}-->
				<input type="hidden" name="formhash" value="{FORMHASH}">
				<input type="hidden" name="replysubmit" value="true">
				<input type="hidden" name="commentsubmit" value="true" />
				<p class="pt10 cl y"><button type="submit" name="commentsubmit_btn" id="commentsubmit_btn" value="true" class="pn y">{lang comment}</button></p>
                </div>
			</form>
    
    
    

   
    
        <script type="text/javascript">
    jQuery(function(){
		jQuery("#tedt .pt").focus(function(){
			  jQuery(this).addClass("bgchange");
		}).blur(function(){
			  jQuery(this).removeClass("bgchange");
		});
    });
    </script> 

    <h3>全部评论</h3>
    <!--{/if}--> 
    <ul>
    <!--{loop $commentlist $comment}--> 
    <!--{template portal/comment_li}--> 
    <!--{if !empty($aimgs[$comment[cid]])}--> 
    <script type="text/javascript" reload="1">aimgcount[{$comment[cid]}] = [<!--{echo implode(',', $aimgs[$comment[cid]]);}-->];attachimgshow($comment[cid]);</script> 
    <!--{/if}--> 
    <!--{/loop}-->
    </ul>
    <p class="ptn cl" style=" text-align:center">
        <!--{if $data[commentnum]}--><a href="$common_url" class="xi2">查看全部评论>></a><!--{/if}-->
      </p>
  </div>
</div>
