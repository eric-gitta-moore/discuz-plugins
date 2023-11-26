<?PHP exit('QQÈº£º550494646');?>
<!--{loop $adata $key $list}-->   
    <div id="athreadlist" class="ainuo_portal_threadlist cl">
        <!--{if $list['threadcount']}-->
        {eval $arand = rand(1,count($list['threadcount']));}
        {eval $listn = 0;}
            <ul id="portalforumlist">
                <!--{loop $list['threadlist'] $key $thread}-->
                {eval $listn++;}
                        <li id="$thread[id]">
                            <a href="forum.php?mod=viewthread&tid=$thread[tid]&extra=$extra" {if $thread[num] == 1}class="normal normal_1"{elseif $thread[num] == 2}class="normal normal_2"{else}class="normal"{/if}>
                            <p $thread[highlight] class="tit cl">
                                <!--{if in_array($thread['displayorder'], array(1, 2, 3, 4))}-->
                                    <em class="ding">$alang_ding</em>
                                <!--{/if}-->
                                <!--{if $thread['digest'] > 0}-->
                                    <em class="jing">$alang_jing</em>
                                <!--{/if}-->
                                {$thread[subject]}
                                <br />
                                <span class="onepic y viw"><i class="iconfont icon-view"></i>{$thread[views]}</span><span class="onepic tim"><i class="iconfont icon-time"></i>$thread[dateline]</span>
                            </p>
                            {if $thread['image']}
                                <div class="list_pic cl">
                                	$thread['image']
                                </div>
                            {/if}
                            <p class="info cl"><span class="viw"><i class="iconfont icon-view"></i>{$thread[views]}</span><span class="tim"><i class="iconfont icon-time"></i>$thread[dateline]</span></p>
							$thread['summary']
                            </a>
                        </li>
                        <!--{if $dataad[ad_faxian2] && ($arand == $listn)}-->$dataad[ad_faxian2]<!--{/if}-->
                <!--{/loop}--><!--From w ww.ymg6 .com -->
            </ul>
            
        <!--{/if}-->
    </div>
    
<!--{/loop}-->

