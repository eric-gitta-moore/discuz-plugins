<?PHP exit('QQ群：550494646');?>

<!--频道文章列表开始-->
<div id="athreadlist" class="ainuo_portal_articlelist cl">
    <!--{if $ainuolist}--><!--From w ww.ymg6 .com -->
    {eval $arand = rand(1,count($ainuolist));}
	{eval $listn = 0;}
        <ul id="portalforumlist">
            <!--{loop $ainuolist $key $thread}-->
            {eval $listn++;}
                <li id="normalthread_$thread[aid]">
                    <a href="portal.php?mod=view&aid=$thread[aid]">
                    <div {if $thread['pic']}class="normal normal_1"{else}class="normal"{/if}>
                    $thread[pic]
                    <p class="tit cl">
                        {$thread[title]}
                    </p>
                    <p class="info cl"><em>{echo dgmdate($thread[dateline])}</em><em class="y">{$thread[views]} {$alang_view}</em></p>
                    </div>
                    <!--{if $configData[portal_summarynum]}--><div class="suy cl">{echo cutstr($thread[summary],$configData[portal_summarynum]*2)}</div><!--{/if}-->
                    </a>
                </li>
                <!--{if $dataad[ad_faxian2] && ($arand == $listn)}-->$dataad[ad_faxian2]<!--{/if}-->
            <!--{/loop}-->
        </ul>
    <!--{/if}-->
</div>
