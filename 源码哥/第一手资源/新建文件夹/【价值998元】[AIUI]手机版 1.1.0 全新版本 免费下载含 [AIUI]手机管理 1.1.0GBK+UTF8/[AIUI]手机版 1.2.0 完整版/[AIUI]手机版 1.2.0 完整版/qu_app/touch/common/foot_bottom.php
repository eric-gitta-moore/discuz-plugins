<?PHP exit('QQÈº£º550494646');?>

<style>.ainuo_contop{padding-bottom:53px !important;}</style>

<div class="ainuo_foot_nav cl">
    <ul>
        <li>
        	<a href="forum.php?mod=guide&view=hot" {if $_GET['mod'] == 'guide'}class="foothover"{/if}>
            	<i class="nohover iconfont icon-home"></i>
                <i class="hover iconfont icon-homefill"></i>
                <p>$alang_home</p>
			</a>
		</li>
        <li>
        	<a href="forum.php?forumlist=1" {if $_GET['forumlist']}class="foothover"{/if}>
            	<i class="nohover iconfont icon-discover"></i>
                <i class="hover iconfont icon-discoverfill"></i>
                <p>$alang_forum</p>
			</a>
		</li>
        <li>
        	<a href="javascript:;" class="botpost">
                <i class="iconfont icon-roundaddfill"></i>
                <p>$alang_post</p>
			</a>
		</li>
        
        <li>
        	<a href="forum.php?mod=forumdisplay&fid=49">
            	<i class="nohover iconfont icon-video"></i>
                <i class="hover iconfont icon-video_videofill"></i>
                <p>$nh_video</p>
			</a>
		</li>
        <li class="amy">
        	<a href="home.php?mod=space&uid=$_G[uid]&do=profile&mycenter=1" {if $_GET['mod']=='space'}class="foothover ainuo_nologin"{else}class="ainuo_nologin"{/if}>
            	<i class="nohover iconfont icon-my"></i>
                <i class="hover iconfont icon-myfill"></i>
                {if $_G[member][newprompt] || $_G[member][newpm]}<em></em>{/if}
                <p>$alang_my</p>
			</a>
		</li>
    </ul>
</div>

<style>
#apostmask{position: fixed;width: 100%;height: 100%;bottom: 0;background: rgba(0,0,0,0.5); z-index:100000;}
</style>
<div id="apostmask" style="display:none;">
	<div class="mask_top cl">	
    	
    </div>
	<div class="mask_post_bottom cl">
    	<div class="mask_con cl">
        	<div class="atit cl">$alang_postwhat</div>
           	{loop $quicknav $nav}
            {if $nav[disable]}
            <a href="$nav[url]">
                <i class="iconfont icon-$nav[pic]" style="background:$nav[color]"></i>
                <p>$nav[title]</p>
            </a>
            {/if}
            {/loop}
        </div>
        <div class="aclose cl"><a href="javascript:;" id="aclose"><i class="iconfont icon-close"></i></a></div>
    </div>
</div>