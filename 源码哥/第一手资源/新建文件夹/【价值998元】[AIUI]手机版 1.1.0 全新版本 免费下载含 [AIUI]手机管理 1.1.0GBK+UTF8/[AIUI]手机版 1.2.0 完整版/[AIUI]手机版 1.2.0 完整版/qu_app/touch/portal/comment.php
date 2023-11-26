<?PHP exit('QQÈº£º550494646');?>
<!--{template common/header}-->

<div class="ainuo_v_post">
	<!--{if $csubject['allowcomment'] == 1}-->
        <form id="cform" name="cform" action="portal.php?mod=portalcp&ac=comment" method="post" autocomplete="off">
            <div class="tedt">
                <div class="area">
                    <textarea name="message" cols="60" rows="3" class="pt" id="message"></textarea>
                </div>
            </div>
            <!--{if $secqaacheck || $seccodecheck}-->
                <!--{block sectpl}--><sec> <span id="sec<hash>" onclick="showMenu(this.id);"><sec></span><div id="sec<hash>_menu" class="p_pop p_opt" style="display:none"><sec></div><!--{/block}-->
                <div class="mtm"><!--{subtemplate common/seccheck}--></div>
            <!--{/if}--><!--From www.moq u8 .com -->

            <!--{if $idtype == 'topicid' }-->
                <input type="hidden" name="topicid" value="$id">
            <!--{else}-->
                <input type="hidden" name="aid" value="$id">
            <!--{/if}-->
            <input type="hidden" name="formhash" value="{FORMHASH}">
            <p class="ptn"><button type="submit" name="commentsubmit" value="true" class="a_btn1"><strong>{lang comment}</strong></button></p>
        </form>
    <!--{/if}-->
</div>



<!--{template common/footer}-->