<?PHP exit('QQÈº£º550494646');?>
<!--{eval $_G['home_tpl_titles'] = array('{lang message}');}-->
<!--{template common/header}-->
<!--{if $space[uid] == $_G[uid]}-->
<header class="header">
    <div class="nav">
        <a href="javascript:;" onclick="history.go(-1)" class="z"><i class="iconfont icon-back"></i></a>
        <span class="category"><span class="name">{lang message}</span>
        </span>
    </div>
</header>
<!--{else}-->
<!--{subtemplate common/usertop}-->
<!--{subtemplate common/usernav}-->
<!--{/if}--> 

<div class="ainuo_uwall cl">
	<div class="cl">
		<div id="div_main_content" class="cl">
			<div id="comment">
            {if $list}
				<div id="comment_ul" class="wall_list cl">
                    <ul>
                    <!--{loop $list $k $value}-->
                        <!--{template home/space_comment_li}-->
                    <!--{/loop}-->
                    </ul>
				</div>
            {else}
            	<div class="emp"><i class="iconfont icon-meiyougengduole"></i><p>$alang_wallsofa</p></div>
            {/if}
			</div>
			<div class="pgs cl mtm">$multi</div>
		</div>
		<script type="text/javascript">
			/*var elems = selector('dd[class~=magicflicker]');
			for(var i=0; i<elems.length; i++){
				magicColor(elems[i]);
			}
			function succeedhandle_qcwall_{$space[uid]}(url, msg, values) {
				wall_add(values['cid']);
			}*/
		</script>

	</div>
    <!--{if helper_access::check_module('wall')}-->
    <div class="cl" style="height:68px; width:100%"></div>
        <div class="ainuo_viewdoing_bottom cl">
            <form id="quickcommentform_{$space[uid]}" action="home.php?mod=spacecp&ac=comment" method="post" autocomplete="off" onsubmit="ajaxpost('quickcommentform_{$space[uid]}', 'return_qcwall_$space[uid]');doane(event);">
            <div class="acon cl">

                <div class="ainuo_nologin area">
					<textarea id="comment_message" onkeydown="ctrlEnter(event, 'commentsubmit_btn');" onclick="showFace(this.id, 'comment_message');return false;" name="message" class="px" placeholder="{$alang_xsds}"></textarea>
                </div>

                <div class="bton cl">
                    <input type="hidden" name="referer" value="home.php?mod=space&uid=$wall[uid]&do=wall" />
                    <input type="hidden" name="id" value="$space[uid]" />
                    <input type="hidden" name="idtype" value="uid" />
                    <input type="hidden" name="handlekey" value="qcwall_{$space[uid]}" />
                    <input type="hidden" name="commentsubmit" value="true" />
                    <input type="hidden" name="quickcomment" value="true" />
                    <button type="submit" name="commentsubmit_btn"value="true" id="commentsubmit_btn" class="ainuo_nologin">{lang leave_comments}</button>
                    <span id="return_qcwall_{$space[uid]}"></span>
                </div>
                <input type="hidden" name="formhash" value="{FORMHASH}" />
            </div>
            <div id="ainuo_facemenu"></div>
            </form>
            
        </div>
    <!--{/if}-->
</div>
<!--{subtemplate common/showface}-->


<!--{template common/footer}-->