<?php exit;?>
<div class="ztfb_tszt cl">
    <input type="hidden" name="polls" value="yes" />
    <input type="hidden" name="fid" value="$_G[fid]" />
    <!--{if $_GET[action] == 'newthread'}-->
    <input type="hidden" name="tpolloption" value="2" />
	<div class="tszt_fbxm cl">
		<div class="fbxm_xmbt z">{lang post_poll_options}</div>
		<div class="fbxm_xmnr z"><textarea name="polloptions" class="txt" placeholder="{lang post_poll_comment},{lang post_poll_comment_s}" rows="3"/></textarea></div>
	</div>
    <!--{else}--> 
    <!--{loop $poll['polloption'] $key $option}-->
    <p>
      <input type="hidden" name="polloptionid[{$poll[polloptionid][$key]}]" value="$poll[polloptionid][$key]" />
      <input type="text" name="displayorder[{$poll[polloptionid][$key]}]" class="pxs" autocomplete="off"  value="$poll[displayorder][$key]" />
      <input type="text" name="polloption[{$poll[polloptionid][$key]}]" class="px" autocomplete="off" style="width:200px;"  value="$option"{if !$_G['group']['alloweditpoll']} readonly="readonly"{/if} />
    </p>
    <!--{/loop}--> 
    <!--{/if}-->
	<div class="tszt_fbxm cl">
		<div class="fbxm_xmbt z">{lang post_poll_allowmultiple}</div>
		<div class="fbxm_xmnr z"><input type="text" name="maxchoices" id="maxchoices" class="px" placeholder="{$n5app['lang']['sqfbbitiansm']}" value="{if $_GET[action] == 'edit' && $poll[maxchoices]}$poll[maxchoices]{else}1{/if}"  />{lang post_option}</div>
	</div>
	<div class="tszt_fbxm cl">
		<div class="fbxm_xmbt z">{lang post_poll_expiration}</div>
		<div class="fbxm_xmnr z"><input type="text" name="expiration" id="polldatas" class="px" placeholder="{$n5app['lang']['sqfbbitiansm']}" value="{if $_GET[action] == 'edit'}{if !$poll[expiration]}0{elseif $poll[expiration] < 0}{lang poll_close}{elseif $poll[expiration] < TIMESTAMP}{lang poll_finish}{else}{echo (round(($poll[expiration] - TIMESTAMP) / 86400))}{/if}{/if}"  />{lang days}</div>
	</div>
	<div class="tszt_fbxm cl">
		<div class="fbxm_xmbt fbxm_xmbta z">{lang poll_after_result}</div>
		<div class="fbxm_xmnr fbxm_xmnra z"><input type="checkbox" name="visibilitypoll" id="sendreasonpm" class="pc" value="1"{if $_GET[action] == 'edit' && !$poll[visible]} checked{/if}/><label for="sendreasonpm" class="y" style="margin-top: 2px;"></label></div>
	</div>
	<div class="tszt_fbxm cl">
		<div class="fbxm_xmbt fbxm_xmbta z">{lang post_poll_overt}</div>
		<div class="fbxm_xmnr fbxm_xmnra z"><input type="checkbox" name="overt" id="sendreasonpma" class="pc" value="1"{if $_GET[action] == 'edit' && $poll[overt]} checked{/if}  /><label for="sendreasonpma" class="y" style="margin-top: 2px;"></label></div>
	</div>
</div>