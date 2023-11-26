<?PHP exit('QQÈº£º550494646');?>
<div id="subname_list" class="subname_list">
    <div class="mysub_forum cl">
        <ul>
            <!--{loop $sublist $sub}-->
            <li>
                <!--{if $sub[icon]}-->
                    $sub[icon]
                    <p>{$sub['name']}</p>
                <!--{else}-->
                    <a href="forum.php?mod=forumdisplay&fid={$sub[fid]}"><img src="template/qu_app/touch/style/css/0.png" alt="$forum[name]" />
                    <p>{$sub['name']}</p>
                    </a>
                <!--{/if}-->
            </li>
            <!--{/loop}-->
        </ul>
    </div>
</div>
