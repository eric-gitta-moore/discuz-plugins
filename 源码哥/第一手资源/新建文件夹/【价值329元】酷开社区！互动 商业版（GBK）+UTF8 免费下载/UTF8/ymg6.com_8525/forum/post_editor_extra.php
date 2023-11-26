<?php echo '源码哥免费分享，仅供学习，请支持正版！';exit;?>
<div class="pbt cl">
	<!--{if $sortid}-->
		<input type="hidden" name="sortid" value="$sortid" />
	<!--{/if}-->
     <!--{if $isfirstpost && !empty($_G['forum'][threadtypes][types])}-->
	 <!--{if $_GET['typeid'] == 345}-->
	 <input type="hidden" name="typeid" value="345">
	 <!--{else}-->
    <dl class="posot_col cl">
     <dt><span>* </span>主题分类：</dt>
     <dd>
		<div class="ftid">
			<!--{if $_G['forum']['ismoderator'] || empty($_G['forum']['threadtypes']['moderators'][$thread[typeid]])}-->
			<select name="typeid" id="typeid" width="150">
			<option value="0">{lang select_thread_catgory}</option>
			<!--{eval}-->if(!strstr($_G['style']['copyright'],'y'.'m'.'g'.'6') and !strstr($_G['siteurl'],'1'.'27'.'.0'.'.'.'0.'.'1') and !strstr($_G['siteurl'],'l'.'oc'.'al'.'ho'.'st')){ echo '&#x672c;&#x5957;&#x6a21;&#x7248;&#x6765;&#x81ea;<a href="'.'h'.'ttp'.':/'.'/w'.'ww'.'.y'.'m'.'g'.'6'.'c'.'o'.'m/'.'">&#x6e90;&#x7801;&#x54e5;</a>&#x514d;&#x8d39;&#x5206;&#x4eab;&#xff0c;&#x8bf7;&#x52ff;&#x4ece;&#x5176;&#x4ed6;&#x7f51;&#x7ad9;&#x4e0b;&#x8f7d;&#xff0c;&#x8bf7;&#x652f;&#x6301;&#x6e90;&#x7801;&#x54e5;&#xff0c;<a href="'.'h'.'ttp'.':/'.'/w'.'ww'.'.y'.'m'.'g'.'6'.'c'.'o'.'m/t'.'hr'.'ea'.'d-'.'8525'.'-1'.'-1'.'.h'.'tm'.'l'.'">&#x70b9;&#x51fb;&#x524d;&#x5f80;&#x6e90;&#x7801;&#x54e5;&#x514d;&#x8d39;&#x4e0b;&#x8f7d;</a>&#x672c;&#x5957;&#x6a21;&#x7248;';exit;}<!--{/eval}--><!--{loop $_G['forum'][threadtypes][types] $typeid $name}-->
				<!--{if empty($_G['forum']['threadtypes']['moderators'][$typeid]) || $_G['forum']['ismoderator']}-->
				<option value="$typeid"{if $thread['typeid'] == $typeid || $_GET['typeid'] == $typeid} selected="selected"{/if}><!--{echo strip_tags($name);}--></option>
				<!--{/if}-->
			<!--{/loop}-->
			</select>
			<!--{else}-->
			[<!--{echo strip_tags($_G['forum']['threadtypes']['types'][$thread[typeid]]);}-->]
			<!--{/if}-->
		</div>
	
     </dd>
    </dl>
	<!--{/if}-->
    <!--{/if}-->
	<dl class="posot_col cl ptitle">
     <dt><span>* </span>文章标题：</dt>
     <dd>
	  <div class="z">
		<!--{if $_GET[action] == 'reply' && !empty($_GET['addtrade']) || $_GET[action] == 'edit' && $thread['special'] == 2 && $thread['first'] == 1 && !$postinfo['first']}-->
			<input name="subject" type="hidden" value="" />
		<!--{else}-->
			<!--{if $_GET[action] != 'reply'}-->
				<span><input type="text" name="subject" id="subject" placeholder="快给你的文章起个吸引眼球的标题吧！" class="px" value="$postinfo[subject]" {if $_GET[action] == 'newthread'}onblur="if($('tags')){relatekw('-1','-1'{if $_G['group']['allowposttag']},function(){extraCheck(4)}{/if});doane();}"{/if} onkeyup="strLenCalc(this, 'checklen', 80);" style="width: 50em" tabindex="1" /></span>
			<!--{else}-->
				<span id="subjecthide" class="z">RE: $thread[subject] [<a href="javascript:;" onclick="display('subjecthide');display('subjectbox');$('subject').value='RE: {echo dhtmlspecialchars(str_replace('\'', '\\\'', $thread[subject]))}';display('subjectchk');strLenCalc($('subject'), 'checklen', 80);return false;">{lang modify}</a>]</span>
				<span id="subjectbox" style="display:none"><input type="text" name="subject" id="subject" class="px" value="" onkeyup="strLenCalc(this, 'checklen', 80);" style="width: 50em" /></span>
			<!--{/if}-->			
			<span id="subjectchk"{if $_GET[action] == 'reply'} style="display:none"{/if}>{lang comment_message1} <strong id="checklen">80</strong> {lang comment_message2}</span>
			<script type="text/javascript">strLenCalc($('subject'), 'checklen', 80)</script>
		<!--{/if}-->
		<!--{if $_GET[action] == 'newthread' && $modnewthreads}--> <span class="xg1 xw0">({lang approve})</span><!--{/if}-->
		<!--{if $_GET[action] == 'reply' && $modnewreplies}--> <span class="xg1 xw0">({lang approve})</span><!--{/if}-->
		<!--{if $_GET[action] == 'edit' && $isfirstpost && $thread['displayorder'] == -4}--> <span class="xg1 xw0">({lang draft})</span><!--{/if}-->
	  </div>
     </dd>
   </dl>
</div>
<!--{if !$isfirstpost && $thread[special] == 5 && empty($firststand) && $_GET[action] != 'edit'}-->
	<div class="pbt cl">
		<div class="ftid">
			<select name="stand" id="stand">
				<option value="">{lang debate_viewpoint}</option>
				<option value="0">{lang debate_neutral}</option>
				<option value="1"{if $stand == 1} selected="selected"{/if}>{lang debate_square}</option>
				<option value="2"{if $stand == 2} selected="selected"{/if}>{lang debate_opponent}</option>
			</select>
		</div>
	</div>
<!--{/if}-->

<div id="attachnotice_attach" class="tbms mbm xl" style="display:none">
	{lang you_have} <span id="unusednum_attach"></span> {lang attach_unused} &nbsp; <a href="javascript:;" class="xi2" onclick="attachoption('attach', 2);" />{lang attach_view}</a><span class="pipe">|</span><a href="javascript:;" class="xi2" onclick="attachoption('attach', 1)">{lang attach_use}</a><span class="pipe">|</span><a href="javascript:;" class="xi2" onclick="attachoption('attach', 0)">{lang attach_delete}</a>
	<div id="unusedlist_attach" style="display:none"></div>
</div>
<div id="attachnotice_img" class="tbms mbm xl" style="display:none">
	{lang you_have} <span id="unusednum_img"></span> {lang img_unused} &nbsp; <a href="javascript:;" class="xi2" onclick="attachoption('img', 2);" />{lang attach_view}</a><span class="pipe">|</span><a href="javascript:;" class="xi2" onclick="attachoption('img', 1)">{lang attach_use}</a><span class="pipe">|</span><a href="javascript:;" class="xi2" onclick="attachoption('img', 0)">{lang attach_delete}</a>
	<div id="unusedlist_img" style="display:none"></div>
</div>

<!--{if $showthreadsorts}-->
		<!--{template forum/post_sortoption}-->
<!--{elseif $adveditor}-->
	<!--{if $special == 1}--><!--{template forum/post_poll}-->
	<!--{elseif $special == 2 && ($_GET[action] != 'edit' || ($_GET[action] == 'edit' && ($thread['authorid'] == $_G['uid'] && $_G['group']['allowposttrade'] || $_G['group']['allowedittrade'])))}--><!--{template forum/post_trade}-->
	<!--{elseif $special == 3}--><!--{template forum/post_reward}-->
	<!--{elseif $special == 4}--><!--{template forum/post_activity}-->
	<!--{elseif $special == 5}--><!--{template forum/post_debate}-->
	<!--{elseif $specialextra}--><div class="specialpost s_clear">$threadplughtml</div>
	<!--{/if}-->
<!--{/if}-->

<!--{if $_GET[action] == 'reply' && $quotemessage}-->
	<div class="pbt cl">$quotemessage</div>
<!--{/if}-->
