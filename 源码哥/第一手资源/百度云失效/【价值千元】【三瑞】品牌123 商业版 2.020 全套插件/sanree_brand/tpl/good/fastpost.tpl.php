<?php (!defined('IN_SANREE')&&exit('Power By ymg6.Com'))?>
{template common/header_ajax}
<script language="javascript">
	var votersucceed= '{$votersucceed}';
</script>
<script src="{sr_brand_JS}/msg{C_CHARSET}.js"></script>
<span id="fastreturn_error" style="display:none"></span>
<div class="brandcomment">
  <div class="hd"></div>
  <div class="bd">
    <ul class="commentlist" id="commentlist">
	<!--{loop $postthread $thread}-->
      <li class=clearall><a class="avatar" href="home.php?mod=space&amp;uid={$thread['authorid']}"><img alt="{$thread[author]}" src="<!--{echo avatar($thread['authorid'],'middle',1)}-->"></a>
        <div class="rightbar">
          <div class="ctopbar clearall"><span class="leftarrow"><span></span></span><span class="timeshow"><!--{eval echo dgmdate($thread[dateline])}--></span><a href="home.php?mod=space&amp;uid={$thread['authorid']}" target=_blank>{$thread[author]}:</a>
            <p class="fontrow"></p>
          </div>
          <div class="bottombar clearall"><span class="toparrow"><span></span></span>
            <div>
              <label>
			    <p class="fontrows">{$thread[message]}</p>				
			  </label>	 
            </div>
          </div>
        </div>
      </li>
	  <!--{/loop}-->
    </ul>
	<div class="pager clearall">{$multi}</div>
	<div class="sendcomment clearall">
	<form  autocomplete="off" id="fastpostform" action="plugin.php?id=sanree_brand&mod=fastpost" method="post"  onSubmit="return fastpost(this);">
	    <INPUT id="star" value="0" type=hidden name="star">
	    <a class="avatar" href="home.php?mod=space&amp;uid={$_G['uid']}"><img alt="{$_G['username']}" src="<!--{echo avatar($_G['uid'],'middle',1)}-->"></a>
		<div class="rightbar">
          <div class="ctopbar clearall"><span class="leftarrow"><span></span></span>
		  <div class="lmtimeshow">
		  {lang sanree_brand:sendstar}
		  <em id="brandstar">
		  <div><a onmouseup="setstar(1,'brandstar',0)"></a></div>
		  <div><a onmouseup="setstar(2,'brandstar',0)"></a></div>
		  <div><a onmouseup="setstar(3,'brandstar',0)"></a></div>
		  <div><a onmouseup="setstar(4,'brandstar',0)"></a></div>
		  <div><a onmouseup="setstar(5,'brandstar',0)"></a></div>
		  </em>
		  </div>{lang sanree_brand:yousay}
            <p class="fontrow"></p>
          </div>
          <div class="sendbottombar clearall"><span class="toparrow"><span></span></span>
            <div class="fastsend">
				<!--{eval $seditor = array('fastpost', array('bold', 'color', 'link', 'quote', 'smilies'));}-->
				<!--{subtemplate common/seditor}-->
				<!--{if $_G['uid']}-->
					<TEXTAREA id="fastpostmessage" class=pt tabIndex="9" rows=5 cols=60 name=message></TEXTAREA>
				<!--{else}-->
					<div class="pt hm">
						{lang sanree_brand:login_to_reply} <a href="member.php?mod=logging&action=login" onclick="showWindow('login', this.href)" class="xi2">{lang login}</a> | <a href="member.php?mod={$_G[setting][regname]}" class="xi2">$_G['setting']['reglinkname']</a>
						<!--{hook/global_login_text}-->
					</div>
				<!--{/if}-->
            </div>
            <!--{if $_G[uid]}-->
              <!--{if $dzvflag}-->
                    <!--{if $seccodecheck}-->
                    <div class="sendseccode">
                        <!--{block sectpl}--><div class="rfm"><table><tr><th><sec>: </th><td><span id="sec<hash>" onclick="showMenu({'ctrlid':'sec<hash>','pos':'*'})"><sec></span><br /><div id="sec<hash>_menu" class="p_pop p_opt" style="display:none"><sec></div></td></tr></table></div><!--{/block}-->
                        <div class="mtm sec"><!--{subtemplate common/seccheck}--></div>
                    </div>
                    <!--{/if}-->
              <!--{else}-->
                    <!--{if $_G['uid']&&checkperm('seccode') && ($secqaacheck || $seccodecheck)}-->
                    <div class="sendseccode">
                        <!--{if checkperm('seccode') && ($secqaacheck || $seccodecheck)}-->
                            <!--{block sectpl}--><sec> <span id="sec<hash>" onclick="showMenu({'ctrlid':'sec<hash>','pos':'*'})"><sec></span><div id="sec<hash>_menu" class="p_pop p_opt" style="display:none"><sec></div><!--{/block}-->
                            <div class="mtm sec"><!--{subtemplate common/seccheck}--></div>
                        <!--{/if}-->
                    </div>	
                    <!--{/if}-->
              <!--{/if}-->
			<!--{/if}-->		
			<div class="fastbtn">
			<input type="hidden" name="usesig" value="$usesigcheck" />
			<input type="hidden" name="postsubmit" value="true" />
			<input type="hidden" name="formhash" id="formhash" value="{FORMHASH}" />
			<input type="hidden" name="posttime" id="posttime" value="{TIMESTAMP}" />
			<input type="hidden" name="inajax" id="inajax" value="{$_G[inajax]}" />
			<input type="hidden" name="tid" id="tid" value="{$tid}" />	
			<input type="hidden" name="bid" id="bid" value="{$bid}" />			
			<input type="image" src="{sr_brand_IMG}/send.jpg" align="absmiddle" />
			<span id="desc">{lang sanree_brand:notclickstar}</span>
			</div>
          </div>
        </div>	
		</form>	
	</div>
  </div>
</div>
<script language="javascript" reload="1">mestuHover();</script>
{template common/footer_ajax}