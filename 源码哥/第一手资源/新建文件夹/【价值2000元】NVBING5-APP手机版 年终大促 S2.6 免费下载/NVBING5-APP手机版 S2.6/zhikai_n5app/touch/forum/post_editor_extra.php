<?php exit;?>
<script type="text/javascript" src="template/zhikai_n5app/js/supload.js"></script>
<!--{if $_GET['action'] != 'reply'}-->
<div class="n5sq_fbbt cl">
	<div class="fbbt_btbt z">{lang thread_subject}</div>
    <div class="fbbt_btsr z"><input type="text" name="subject" value="$postinfo[subject]" id="needsubject" placeholder="<!--{if $_GET[action] == 'edit'}-->{$n5app['lang']['sqbianjihfts']}<!--{else}-->{$n5app['lang']['sqfbbitiansm']}<!--{/if}-->" class="txt"/></div>
</div>
<!--{else}-->
<div class="n5sq_hfzs cl">
    RE: $thread['subject']<!--{if $quotemessage}-->$quotemessage <!--{/if}--> 
</div>
<!--{/if}--> 
<!--{if $sortid}-->
<input type="hidden" name="sortid" value="$sortid" />
<!--{/if}--> 
<!--{if $isfirstpost && !empty($_G['forum'][threadtypes][types])}-->
<div class="n5sq_flxz cl">
	<div class="flxz_btbt z">{$n5app['lang']['sqbianjixzfl']}</div>
    <div class="selectbox z" style="display: block;">
		<select name="typeid" id="typeid" class="flxz_xzys">
			<option value="0">{$n5app['lang']['sqbianjixflts']}</option>
			<!--{loop $_G['forum'][threadtypes][types] $typeid $name}--> 
			<!--{if empty($_G['forum']['threadtypes']['moderators'][$typeid]) || $_G['forum']['ismoderator']}-->
			<option value="$typeid"{if $thread['typeid'] == $typeid || $_GET['typeid'] == $typeid} selected="selected"{/if}>
			<!--{echo strip_tags($name);}-->
			</option>
			<!--{/if}--> 
			<!--{/loop}-->
		</select>
    </div>
</div>
<!--{/if}-->
<!--{if $showthreadsorts}-->
<div class="ztfb_flfb cl"> 
  <!--{template forum/post_sortoption}--> 
</div>
<!--{elseif $adveditor}--> 
<!--{if $special == 1}--><!--{template forum/post_poll}--> 
<!--{elseif $special == 2 && ($_GET[action] != 'edit' || ($_GET[action] == 'edit' && ($thread['authorid'] == $_G['uid'] && $_G['group']['allowposttrade'] || $_G['group']['allowedittrade'])))}-->
<!--{template forum/post_trade}--> 
<!--{elseif $special == 3}--><!--{template forum/post_reward}--> 
<!--{elseif $special == 4}--><!--{template forum/post_activity}--> 
<!--{elseif $special == 5}--><!--{template forum/post_debate}--> 
<!--{elseif $specialextra}-->
<div class="specialpost s_clear">$threadplughtml</div>
<!--{/if}--> 
<!--{/if}--> 