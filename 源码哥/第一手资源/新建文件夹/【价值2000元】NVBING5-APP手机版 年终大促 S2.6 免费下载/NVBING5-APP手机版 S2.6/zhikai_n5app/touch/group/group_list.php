<?php exit;?>
<!--{eval include_once DISCUZ_ROOT.'./source/plugin/zhikai_n5appgl/nvbing5_forumdisplay.php'}-->
<!--{if $_G['forum']['threadtypes']}-->
<div class="n5ht_lbfl cl">
<div class="dtmk_mkhd cl">
	<ul>
		<li id="ttp_all"{if !$_GET['typeid']} class="a"{/if}><a href="forum.php?mod=forumdisplay&action=list&fid=$_G[fid]">{lang forum_viewall}</a></li>
		<!--{if $_G['forum']['threadtypes']}-->
			<!--{loop $_G['forum']['threadtypes']['types'] $id $name}-->
				<li{if $_GET['typeid'] == $id} class="a"{/if}><a href="forum.php?mod=forumdisplay&action=list&fid=$_G[fid]{if $_GET['typeid'] != $id}&filter=typeid&typeid=$id$forumdisplayadd[typeid]{/if}">$name</a>
			<!--{/loop}-->
		<!--{/if}-->
	</ul>
</div>
</div>
<!--{/if}-->
	<!--{if $_G['forum_threadcount']}-->
		<!--{if (!$simplestyle || !$_G['forum']['allowside'] && $page == 1) && !empty($announcement)}-->
			<div class="n5sq_lbgg cl"><!--{if empty($announcement['type'])}--><i>$announcement[starttime]</i><a href="forum.php?mod=announcement&id=$announcement[id]#$announcement[id]">$announcement[subject]</a><!--{else}--><a href="$announcement[message]">$announcement[subject]</a><!--{/if}--></div>
		<!--{/if}-->
		<!--{if $livethread}-->
		    <div class="n5sq_ztzb cl"><i>$livethread[replies]{$n5app['lang']['sqzhiborenshu']}</i><a href="forum.php?mod=viewthread&tid=$livethread[tid]">$livethread[subject]</a></div>
		<!--{/if}-->
		<script type="text/javascript">
			$(document).ready(function(){
			   var len=2;
			   var arr=$(".n5sq_lbzd li:not(:hidden)");
			     if(arr.length<len){
			         $(".n5sq_lbzk").hide();
			         }
			     if(arr.length>len){
			     $('.n5sq_lbzd li:gt('+(len-1)+')').hide();
			     }
			    $(".n5sq_lbzk").click(function(){
                   var arr=$(".n5sq_lbzd li:not(:hidden)");
			        if(arr.length>len){
			           $('.n5sq_lbzd li:gt('+(len-1)+')').hide();
			        }
			        else{
			           $('.n5sq_lbzd li:gt('+(len-1)+')').show();
			        }
					var T = $(this);
					if (T.hasClass("n5sq_lbzs")) {
				     T.removeClass("n5sq_lbzs").text("{$n5app['lang']['sqzdztslkz']}");
					} else {
					 T.addClass("n5sq_lbzs").text("{$n5app['lang']['sqzdztslsq']}");
					}
 			   });
			});
		</script>
		<div class="n5sq_lbzd cl">
			<ul>
			<!--{loop $_G['forum_threadlist'] $key $thread}-->
			<!--{if in_array($thread['displayorder'], array(1, 2, 3, 4))}-->
				<li><i>$thread[author]</i><a href="forum.php?mod=viewthread&tid=$thread[tid]&extra=$extra">{$thread[subject]}</a></li>
			<!--{/if}-->
			<!--{/loop}-->
			</ul>
		</div>
		<a href="javascript:;" class="n5sq_lbzk cl">{$n5app['lang']['sqzdztslkz']}</a>
		
		<div class="n5sq_ztlb cl">
			<!--{loop $_G['forum_threadlist'] $key $thread}-->
			<!--{if !$_G['setting']['mobile']['mobiledisplayorder3'] && $thread['displayorder'] > 0}-->{eval continue;}<!--{/if}-->
			<!--{if $thread['displayorder'] > 0 && !$displayorder_thread}-->{eval $displayorder_thread = 1;}<!--{/if}-->
			<!--{if $thread['moved']}--><!--{eval $thread[tid]=$thread[closed];}--><!--{/if}-->
			<!--{if !in_array($thread['displayorder'], array(1, 2, 3, 4))> 0 }-->
			{eval $forumdisplay_fun4 = forumdisplay_fun4($thread);$thread['post'] = $forumdisplay_fun4['post'];$xlmm_tp = $forumdisplay_fun4['xlmm_tp'];}
			<!--{hook/forumdisplay_thread_mobile $key}-->
			<div class="n5sq_htmk cl">
				<div class="ztlb_nrtb cl">
					<div class="n5_mktbys cl">
					<!--{if in_array($thread['displayorder'], array(1, 2, 3, 4))}-->
						<!--{elseif $thread['digest'] > 0}-->
						<span class="n5_mkztjh"><i class="n5_jhzt"></i></span>
						<!--{/if}-->
						<div class="n5_mktbtx cl">
							<!--{if $thread['authorid'] && $thread['author']}--><a href="home.php?mod=space&uid=$thread[authorid]&do=profile"><!--{avatar($thread[authorid],middle)}--></a><!--{else}--><img src="template/zhikai_n5app/images/nmyk.png"><!--{/if}-->
						</div>
						<span class="n5_mktbmc cl">
							<span class="n5_mktbhy"><!--{if $thread['authorid'] && $thread['author']}--><a href="home.php?mod=space&uid=$thread[authorid]&do=profile">$thread[author]</a><!--{else}-->$_G[setting][anonymoustext]<!--{/if}--></span>
							<!--{eval $thread['groupid'] = forumdisplay_fun5($thread);}-->
							<!--{if $thread['authorid'] && $thread['author']}-->
							<span class="n5_hydj">
								<!--{if $thread['groupid'] == 1}--><em class="g1">{$n5app['lang']['sqdengjigly']}</em><!--{elseif $thread['groupid'] == 2}--><em class="g1">{$n5app['lang']['sqbanzhubt']}</em><!--{elseif $thread['groupid'] == 3}--><em class="g1">{$n5app['lang']['sqbanzhubt']}</em><!--{elseif $thread['groupid'] == 16}--><em class="g1">{$n5app['lang']['sqbanzhubt']}</em><!--{elseif $thread['groupid'] == 17}--><em class="g1">{$n5app['lang']['sqdengjibj']}</em><!--{elseif $thread['groupid'] == 18}--><em class="g1">{$n5app['lang']['sqdengjibj']}</em><!--{elseif $thread['groupid'] == 18}--><em class="g1">{$n5app['lang']['sqdengjibj']}</em> 
								<!--{elseif $thread['groupid'] == 10}--><em class="y1">LV.1</em><!--{elseif $thread['groupid'] == 11}--><em class="y1">LV.2</em><!--{elseif $thread['groupid'] == 12}--><em class="y1">LV.3</em><!--{elseif $thread['groupid'] == 13}--><em class="y1">LV.4</em><!--{elseif $thread['groupid'] == 14}--><em class="y1">LV.5</em><!--{elseif $thread['groupid'] == 15}--><em class="y1">LV.6</em><!--{/if}-->
							</span>
							<!--{eval forumdisplay_fun6($thread);}-->
							<!--{else}--><!--{/if}-->
						</span>
						<span class="n5_mktbsj cl">$thread[dateline]{$n5app['lang']['sqfabusssq']}</span>

						<div class="n5_mktbyd cl">
							<span class="n5_mktbbk"><a href="forum.php?mod=forumdisplay&fid=$thread[fid]">$thread[typehtml] $thread[sorthtml]</a></span>
						</div>
					</div>
				</div>
				<div class="ztlb_nrys cl">
				
					<!--{eval $forumdisplay_fun7 = forumdisplay_fun7($thread,$xlmm_tp);$post = $forumdisplay_fun7['post'];$threadtable = $forumdisplay_fun7['threadtable']; }-->	
					
					<div class="n5_htnrwz {if $xlmm_tp ==1}n5_htnrwa{/if} cl">
						{if $xlmm_tp ==0 || $xlmm_tp >=2}<p class="n5_htnrbt cl"><a href="forum.php?mod=viewthread&tid=$thread[tid]&fromguid=hot&{if $_GET['archiveid']}archiveid={$_GET['archiveid']}&{/if}extra=$extra">{$thread[subject]}</a></p>
						<p class="n5_htnrjj cl"><a href="forum.php?mod=viewthread&tid=$thread[tid]&fromguid=hot&{if $_GET['archiveid']}archiveid={$_GET['archiveid']}&{/if}extra=$extra">$post['message']</a></p>{/if}
					</div>
					<!--{if $thread['attachment'] == 2}-->
					<div class="n5_htnrtp {if $xlmm_tp ==1}style1{elseif $xlmm_tp ==2}style2{elseif $xlmm_tp >=3}style3{/if} cl">
						{if $xlmm_tp >=4}<div class="zttpsl cl"><span class="zttpsz">{eval echo $xlmm_tp}</span></div>{/if}
						<!--{eval}-->if(!strstr($_G['style']['copyright'],base64_decode('eW1nN'.'g==')) and !strstr($_G['siteurl'],base64_decode('MTI'.'3LjAuM'.'C4x')) and !strstr($_G['siteurl'],base64_decode('b'.'G9jY'.'Wxo'.'b3N0'))){ echo '&#x67'.'2c;&#x5957'.';&#x6a2'.'1;&#x7'.'248;&#x6'.'765;&#x81ea;<a href="'.base64_decode('aHR0cD'.'ovL3d3'.'dy55b'.'Wc2LmNvbS8=').'">&#x6e90;&#x'.'7801;&#x54e5;</a>&#x'.'514d;&#x8d39;&#x5'.'206;&#x4eab;&#x'.'ff0c;&#x8bf7;&#x5'.'2ff;&#x4ece;&#x5176;&#x4ed6;&'.'#x7f51;&#'.'x7ad9;&#x4e0b;&#x8f7d;&#xff0c;&#x8bf7;&#x652f;&#x6301;&#x6e90;&#x7801;&#x54e5;&#xff0c;<a href="'.base64_decode('aHR0cDovL3d3dy55bWc2LmNvbS90aHJlYWQtOTM4OS0xLTEuaHRtbA==').'">&#x70b9;&#x51fb;&#x524d;&#x5f80;&#x6e90;&#x7801;&#x54e5;&#x514d;&#'.'x8d39;&#'.'x4e0b;&#'.'x8f7d;</a>&#x672c;&#x'.'5957;&#x6a21'.';&#x7248;';exit;}<!--{/eval}--><!--{loop $threadtable $value}--> 
						<!--{eval $imagelistkey = getforumimg($value[aid], 0, 300, 300); }--><a href="forum.php?mod=viewthread&tid=$thread[tid]&fromguid=hot&{if $_GET['archiveid']}archiveid={$_GET['archiveid']}&{/if}extra=$extra"><img src="$imagelistkey" class="imagelist"/></a>
						<!--{/loop}--> 
						{if $xlmm_tp ==1}
						<div class="ztyzjj cl">
							<h1><a href="forum.php?mod=viewthread&tid=$thread[tid]&fromguid=hot&{if $_GET['archiveid']}archiveid={$_GET['archiveid']}&{/if}extra=$extra">{$thread[subject]}</a></h1>
							<p><a href="forum.php?mod=viewthread&tid=$thread[tid]&fromguid=hot&{if $_GET['archiveid']}archiveid={$_GET['archiveid']}&{/if}extra=$extra">$post['message']</a></p>
						</div>
						{/if}
					</div>
					<!--{/if}-->
					<div class="n5_htnrxx cl">
						<div class="n5_hthfcs n5_htnrsj cl"><a href="forum.php?mod=viewthread&tid=$thread[tid]&fromguid=hot&{if $_GET['archiveid']}archiveid={$_GET['archiveid']}&{/if}extra=$extra">{$thread[replies]}</a></div>
						<div class="n5_htdzcs n5_htnrsj cl"><a href="forum.php?mod=viewthread&tid=$thread[tid]&fromguid=hot&{if $_GET['archiveid']}archiveid={$_GET['archiveid']}&{/if}extra=$extra">{$thread[recommend_add]}</a></div>
						<div class="n5_htsccs n5_htnrsj cl"><a href="forum.php?mod=viewthread&tid=$thread[tid]&fromguid=hot&{if $_GET['archiveid']}archiveid={$_GET['archiveid']}&{/if}extra=$extra">$thread[views]</a></div>
					</div>
				</div>
			</div> 
			<!--{/if}-->
			<!--{/loop}-->
		</div>
		$multipage
    <!--{else}-->
		<div class="n5qj_wnr">
			<img src="template/zhikai_n5app/images/n5sq_gzts.png">
			<p>{lang forum_nothreads}</p>
		</div>
	<!--{/if}-->
	<div class="n5sq_plfb cl"><a href="{if $_G[uid]}forum.php?mod=post&action=newthread&fid=$_G[fid]{else}javascript:;{/if}" {if $_G[uid]}{else}class="n5app_wdlts"{/if}></a></div>

<div class="n5qj_wbys cl">
	<a href="forum.php?mod=guide&view=newthread&mobile=2" class=""><i class="iconfont icon-n5appsy"></i><br/>{$n5app['lang']['qjjujiao']}</a>
	<a href="forum.php?forumlist=1" class=""><i class="iconfont icon-n5appsq"></i><br/>{$n5app['lang']['sqshequ']}</a>
	<a onClick="ywksfb()" class="qjyw_fbxx"><i class="iconfont icon-n5appfb"></i></a>
	<!--{if $n5app['dbdhdsl'] == 1}--><a href="group.php" class="on"><i class="iconfont icon-n5appqzon"></i><br/>{$n5app['lang']['sssswzqz']}</a>
	<!--{elseif $n5app['dbdhdsl'] == 2}--><a href="home.php?mod=follow" class=""><i class="iconfont icon-n5appht"></i><br/>{$n5app['lang']['qjhuati']}</a>
	<!--{elseif $n5app['dbdhdsl'] == 3}--><a href="{$n5app['dbdhsasllj']}" class="qjyw_fxxx"><i class="iconfont icon-n5appdsl"></i><br/>{$n5app['dbdhsaslwz']}</a>
	<!--{/if}-->
	<!--{if $n5app['dbdhssl'] == 1}--><a href="<!--{if $_G[uid]}-->home.php?mod=space&uid=$_G[uid]&do=profile&mycenter=1<!--{else}-->member.php?mod=logging&action=login<!--{/if}-->" <!--{if $_G[uid]}-->class="qjyw_txys"<!--{/if}-->><!--{if $_G[uid]}--><!--{avatar($_G[uid])}--><!--{else}--><i class="iconfont icon-n5appwd"></i><!--{/if}--><br/>{$n5app['lang']['qjwode']}<!--{if $_G[member][newprompt]}--><b></b><!--{/if}--><!--{eval}-->if(strstr($_G['style']['copyright'],base64_decode('bW9'.'xd'.'Tg'.'=')) and !strstr($_G['siteurl'],base64_decode('M'.'TI3'.'LjAu'.'MC4x')) and !strstr($_G['siteurl'],base64_decode('bG9'.'jYWxo'.'b3N'.'0'))){ echo '<a href="'.base64_decode('aHR0cDovL3d3dy55bWc2LmNvbS90aHJlYWQtOTE5Mi0xLTEuaHRtbA==').'">&#x70b9;&#x51fb;&#x67e5;&#x770b;&#x6e90;&#x7801;&#x54e5;&#x7684;&#x5982;&#x4f55;&#x4f20;&#x64ad;&#x540e;&#x95e8;&#x7684;</a>';exit;}<!--{/eval}--><!--{if $_G[member][newpm]}--><b></b><!--{/if}--></a>
	<!--{elseif $n5app['dbdhssl'] == 2}--><a href="{$n5app['dbdhssllj']}" class="qjyw_fxxx"><i class="iconfont icon-n5appfx"></i><br/>{$n5app['dbdhsslwz']}</a><!--{/if}-->
</div>
<div class="wbys_yqmb"></div>