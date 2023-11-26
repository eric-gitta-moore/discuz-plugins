<?php echo '源码哥商业模板保护！下载获取正版模板请访问源码哥官网：www.fx8.cc';exit;?>
<!--{if $_G['uid']}-->

<ul class="log-dropdown wk_userzt" style="display:none;">
	<!--{hook/global_usernav_extra1}-->
    <!--{hook/global_usernav_extra2}-->
    <!--{hook/global_usernav_extra3}-->
    <li><a href="home.php?mod=space&uid=$_G[uid]" target="_blank" title="{lang visit_my_space}" onMouseOver="showMenu({'ctrlid':this.id,'ctrlclass':'a'})">$week_lang[20]</a></li>
    <!--{if check_diy_perm($topic)}-->
        <li><a href="javascript:saveUserdata('diy_advance_mode', '');openDiy();" title="DIY{lang header_diy_mode_simple}">DIY{lang header_diy_mode_simple}</a></li>
        <li><a href="javascript:saveUserdata('diy_advance_mode', '1');openDiy();" title="DIY{lang header_diy_mode_adv}">DIY{lang header_diy_mode_adv}</a></li>
    <!--{/if}-->
    <li><a href="home.php?mod=space&do=notice" title="{lang remind}">{lang remind} <!--{if $_G[member][newprompt]}--><span class="msg-num">($_G[member][newprompt])</span><!--{/if}--></a></li>
    <!--{if $_G['setting']['taskon'] && !empty($_G['cookie']['taskdoing_'.$_G['uid']])}-->
    <li><a href="home.php?mod=task&item=doing" title="{lang task_doing}">{lang task_doing}</a></li>
    <!--{/if}-->
    <!--{if $_G['uid']}-->
      <li><a href="forum.php?mod=guide&view=my" title="$week_lang[7]">$week_lang[7]</a></li>
      <li><a href="home.php?mod=space&do=favorite&view=me" title="{lang favorite}">{lang favorite}</a></li>
      <li><a href="home.php?mod=space&do=friend" title="{lang friends}">{lang friends}</a></li>
      <li><a href="home.php?mod=space&do=pm" title="{lang pm_center}">{lang pm_center}</a></li>
      <!--{hook/global_myitem_extra}-->
    <!--{/if}--> 
    <li><a href="home.php?mod=spacecp&ac=credit&showcredit=1" title="{lang credits}:$_G[member][credits]">{lang credits}: <span class="msg-num">$_G[member][credits]</span></a></li>
    <li><a href="home.php?mod=spacecp" title="{lang setup}">{lang setup}</a></li>
    <!--{if ($_G['group']['allowmanagearticle'] || $_G['group']['allowpostarticle'] || $_G['group']['allowdiy'] || getstatus($_G['member']['allowadmincp'], 4) || getstatus($_G['member']['allowadmincp'], 6) || getstatus($_G['member']['allowadmincp'], 2) || getstatus($_G['member']['allowadmincp'], 3))}-->
    <li><a href="portal.php?mod=portalcp"><!--{if $_G['setting']['portalstatus'] }-->{lang portal_manage}<!--{else}-->{lang portal_block_manage}<!--{/if}--></a></li>
    <!--{/if}--> 
    <!--{if $_G['uid'] && $_G['adminid'] == 1 && $_G['setting']['cloud_status']}-->
    <li><a href="admin.php?frames=yes&action=cloud&operation=applist" target="_blank" title="{lang cloudcp}">{lang cloudcp}</a></li>
    <!--{/if}--> 
    <!--{if $_G['uid'] && $_G['group']['radminid'] > 1}-->
    <li><a href="forum.php?mod=modcp&fid=$_G[fid]" target="_blank" title="{lang forum_manager}">{lang forum_manager}</a></li>
    <!--{/if}--> 
    <!--{if $_G['uid'] && getstatus($_G['member']['allowadmincp'], 1)}-->
    <li><a href="admin.php" target="_blank" title="{lang admincp}">{lang admincp}</a></li>
    <!--{/if}--> 
    <li><a href="member.php?mod=logging&action=logout&formhash={FORMHASH}" title="{lang logout}">{lang logout}</a></li>
    <!--{hook/global_usernav_extra4}-->
</ul>
    
<!--{elseif !empty($_G['cookie']['loginuser'])}-->

<ul class="log-dropdown" style="display:none;">
    <li><a id="loginuser" class="username"><!--{echo dhtmlspecialchars($_G['cookie']['loginuser'])}--></a></li>
    <li><a href="member.php?mod=logging&action=login" onClick="showWindow('login', this.href)" title="{lang activation}">{lang activation}</a></li>
    <li><a href="member.php?mod=logging&action=logout&formhash={FORMHASH}" title="{lang logout}">{lang logout}</a></li>
</ul> 
    
<!--{elseif !$_G[connectguest]}-->

<ul class="log-dropdown" style="display:none;">
    <li><a href="member.php?mod=logging&action=login&referer={echo rawurlencode($dreferer)}" onclick="showWindow('login', this.href);return false;" title="$week_lang[4]" onMouseOver="showMenu({'ctrlid':this.id,'ctrlclass':'a'})" class="week-button week-button-primary center" style="color:#FFF !important;">$week_lang[4]</a></li>
    <li class="signup-help">$week_lang[0] <a href="member.php?mod={$_G[setting][regname]}" title="$week_lang[3]">$week_lang[3]</a></li>
    <li><hr class="log-dd-sep"></li>
    <li><a href="connect.php?mod=login&amp;op=init&amp;referer=index.php&amp;statfrom=login" title="$week_lang[2]"><span class="i_qq"></span>$week_lang[2]</a></li>
    <!--{if $wk_wxdl}-->
    <li><a href="plugin.php?id=wechat:login" title="$week_lang[1]"><span class="i_wx"></span>$week_lang[1]</a></li>
    <!--{else}-->
    <li><a href="javascript:;" onClick="showWindow('wechat_bind', 'plugin.php?id=wechat:bind')" title="$week_lang[1]"><span class="i_wx"></span>$week_lang[1]</a></li>
    <!--{/if}-->
</ul> 
        
<!--{else}-->

<ul class="log-dropdown" style="display:none;">
    <li><a href="home.php?mod=spacecp&ac=usergroup" class="nousername" title="{$_G[member][username]}">{$_G[member][username]}</a></li>
    <li><a href="member.php?mod=logging&action=logout&formhash={FORMHASH}" title="{lang logout}">{lang logout}</a></li>
</ul>
    
<!--{/if}-->