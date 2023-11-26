<?PHP exit('QQÈº£º550494646');?>
<!--{if $subexists && $_G['page'] == 1}-->
<div id="subname_list" class="sub_forum cl" style="position:relative;">
    <ul>
        <!--{loop $sublist $sub}-->
        <li>
            <!--{if $sub[icon]}-->
                $sub[icon]
                <p>{$sub['name']}</p>
            <!--{else}-->
                <a href="forum.php?mod=forumdisplay&fid={$sub[fid]}"><img src="{$_G['style'][tpldir]}/touch/style/css/0.png" alt="$forum[name]" />
                <p>{$sub['name']}</p>
                </a>
            <!--{/if}-->
        </li>
        <!--{/loop}-->
    </ul>
</div>
<!--{/if}-->