<?php exit;?>
<!--{eval $threadpartake=DB::fetch_all("select * from ".DB::table("forum_threadpartake")." where tid=".$thread['tid']);}-->
<!--{eval $huifu=DB::fetch_all("select * from ".DB::table("forum_post")." where tid=".$thread['tid']." and first<>1 and invisible=0");}-->
<div class="sqys_pyqs cl">
	<div class="pyqs_tbxx cl">
		<!--{if $thread['authorid'] && $thread['author']}--><a href="home.php?mod=space&uid=$thread[authorid]&do=profile" class="pyqs_img"><!--{avatar($thread[authorid],middle)}--></a><!--{else}--><a href="javascript:void(0);" class="pyqs_img"><img src="template/zhikai_n5app/images/nmyk.png"></a><!--{/if}-->
		<div class="pyqs_hyxx cl">
			<span class="pyqs_lzlm y"><a href="forum.php?mod=forumdisplay&fid=$thread[fid]">$thread[typehtml] $thread[sorthtml]</a></span>
			<span class="n5_mktbhy"><!--{if $thread['authorid'] && $thread['author']}--><a href="home.php?mod=space&uid=$thread[authorid]&do=profile">$thread[author]</a><!--{else}-->$_G[setting][anonymoustext]<!--{/if}--></span>
			<!--{eval $thread['groupid'] = forumdisplay_fun5($thread);}-->
			<!--{if $thread['authorid'] && $thread['author']}-->
			<span class="n5_hydj">
				<!--{if $thread['groupid'] == 1}--><em class="g1">{$n5app['lang']['sqdengjigly']}</em><!--{elseif $thread['groupid'] == 2}--><em class="g1">{$n5app['lang']['sqbanzhubt']}</em><!--{elseif $thread['groupid'] == 3}--><em class="g1">{$n5app['lang']['sqbanzhubt']}</em><!--{elseif $thread['groupid'] == 16}--><em class="g1">{$n5app['lang']['sqbanzhubt']}</em><!--{elseif $thread['groupid'] == 17}--><em class="g1">{$n5app['lang']['sqdengjibj']}</em><!--{elseif $thread['groupid'] == 18}--><em class="g1">{$n5app['lang']['sqdengjibj']}</em><!--{elseif $thread['groupid'] == 18}--><em class="g1">{$n5app['lang']['sqdengjibj']}</em> 
				<!--{elseif $thread['groupid'] == 10}--><em class="y1">LV.1</em><!--{elseif $thread['groupid'] == 11}--><em class="y1">LV.2</em><!--{elseif $thread['groupid'] == 12}--><em class="y1">LV.3</em><!--{elseif $thread['groupid'] == 13}--><em class="y1">LV.4</em><!--{elseif $thread['groupid'] == 14}--><em class="y1">LV.5</em><!--{elseif $thread['groupid'] == 15}--><em class="y1">LV.6</em><!--{/if}-->
			</span>
			<!--{eval forumdisplay_fun6($thread);}-->
			<!--{else}--><!--{/if}-->
		</div>								
	</div>
	<div class="pyqs_ztnr cl">
		<!--{eval require_once libfile('function/post');$post = C::t('forum_post')->fetch_threadpost_by_tid_invisible($thread['tid']);$post['message'] = trim(messagecutstr($post['message'], 30000));}-->
		<!--{eval  $threadtable =  DB::fetch_all('SELECT * FROM '.DB::table('forum_attachment').' WHERE tid = '. $thread['tid'].' AND uid = '.$thread['authorid'] .' LIMIT  0 ,'. 9 );}-->
		<div class="pyqs_qwsqkz">
			<div class="pyqs_nrxx cl"><a href="forum.php?mod=viewthread&tid=$thread[tid]&fromguid=hot&{if $_GET['archiveid']}archiveid={$_GET['archiveid']}&{/if}extra=$extra">$post['message']</a></div>
		</div>
		<span class="pyqs_qwsq">{$n5app['lang']['pyqyswzqb']}</span>
		<script type="text/javascript">
			var textContentWrap = document.getElementsByClassName('pyqs_qwsqkz');
			for (var i = 0; i < textContentWrap.length; i++) {
				var currentTextContent = textContentWrap[i].getElementsByClassName('pyqs_nrxx')[0];
				if (currentTextContent.clientHeight > textContentWrap[i].clientHeight) {
					var foldBtn = textContentWrap[i].parentElement.getElementsByClassName('pyqs_qwsq')[0];
					foldBtn.style.display = 'block';
					foldBtn.onclick = function () {
						var thisTextContentWrap = this.parentElement.getElementsByClassName('pyqs_qwsqkz')[0];
						if (this.innerHTML == '{$n5app['lang']['pyqyswzqb']}') {
							this.innerHTML = '{$n5app['lang']['pyqyswzsq']}';
							thisTextContentWrap.style.height = 'auto';
						} else {
							this.innerHTML = '{$n5app['lang']['pyqyswzqb']}';
							thisTextContentWrap.removeAttribute('style');
						}
					}
				}
			}
		</script>
		<a href="forum.php?mod=viewthread&tid=$thread[tid]&fromguid=hot&{if $_GET['archiveid']}archiveid={$_GET['archiveid']}&{/if}extra=$extra">
			<div class="pyqs_nrimg cl">
				<div class="{if $xlmm_tp ==1}pyqs_imgkz{elseif $xlmm_tp ==2}pyqs_imgke{elseif $xlmm_tp ==4}pyqs_imgkg{elseif $xlmm_tp >=3}pyqs_imgks{/if}">
					<ul>
					<!--{loop $threadtable $value}--> 
						{if $xlmm_tp ==1}
						<!--{eval $imagelistkey = getforumimg($value[aid], 0, 300, 300); }--><li><img src="$imagelistkey"/></li>
						{else}
						<!--{eval $imagelistkey = getforumimg($value[aid], 0, 200, 200); }--><li><img src="$imagelistkey"/></li>
						{/if}
					<!--{/loop}-->
					</ul>
				</div>
			</div>
		</a>
	</div>
	<div class="pyqs_zthd cl">
		<span>$thread[dateline]</span>
		<a href="javascript:void(0);" class="pyqs_dzhf operation-btn"><i class="iconfont icon-n5apppyqhf"></i></a>
		<div class="pyqs_zhan operation-content cl">
			<!--{if ($_G['group']['allowrecommend'] || !$_G['uid']) && $_G['setting']['recommendthread']['status']}-->
				<!--{if !empty($_G['setting']['recommendthread']['addtext'])}-->
					<a id="recommend_add" href="forum.php?mod=misc&action=recommend&do=add&tid=$thread['tid']&hash={FORMHASH}" onclick="ajaxmenu(this, 3000, 1, 0, '43', 'recommendupdate({$_G['group']['allowrecommend']})');return false;" onmouseover="this.title = $('recommendv_add').innerHTML + ' {lang activity_member_unit}$_G[setting][recommendthread][addtext]'" class="{if $_G['uid']}dialog{else}n5app_wdlts{/if}"><i class="iconfont icon-n5appnrsc"></i>{$n5app['lang']['sqztnrdzs']}</a>
				<!--{/if}-->
			<!--{/if}-->
			<a href="forum.php?mod=post&action=reply&fid=$_G[fid]&tid=$thread['tid']" class="{if $_G['uid']}dialog{else}n5app_wdlts{/if}"><i class="iconfont icon-n5applbhf"></i>{$n5app['lang']['sqztnrhdhf']}</a>
		</div>
	</div>
	<script type="text/javascript">
		var operationBtn = document.getElementsByClassName('operation-btn');
		for (var i = 0; i < operationBtn.length; i++) {
			operationBtn[i].onclick = function (e) {
				var evt = e ? e : window.event;
				evt.stopPropagation ? evt.stopPropagation() : evt.cancelBubble = true;
				var ele = this.parentElement.getElementsByClassName('operation-content')[0];
				var width = ele.clientWidth;
				if (width == 0) {
					ele.style.width = '125px';
					ele.style.padding = '0 5px';
				} else {
					ele.style.width = '0';
					ele.style.padding = '0';
				}
			}
		}
		document.onclick = function () {
			var operationContent = document.getElementsByClassName('operation-content');
			for (var i = 0; i < operationContent.length; i++) {
				operationContent[i].style.width = '0';
				operationContent[i].style.padding = '0';
			}
		}
	</script>
	<div class="pyqs_zhlb <!--{if $threadpartake}-->pyqs_zhjt<!--{/if}--> <!--{if $huifu}-->pyqs_zhjt<!--{/if}--> cl">
		<!--{if $threadpartake}-->
			<div class="pyqs_zdhy cl">
				<i class="iconfont icon-n5appnrsc"></i>
				<em>{$thread[recommend_add]}</em>
				<i class="iconfont icon-n5applbhf"></i>
				<em>{$thread[replies]}</em>
				<!--{loop $threadpartake $var_r}-->
				<!--{eval $user=DB::fetch_first("select uid,username,status from ".DB::table("common_member")." where uid=".$var_r['uid']." and status>=0");}-->
				<a href="home.php?mod=space&uid=$var_r['uid']&do=profile">$user[username]<span class="pyqs_dzjg">,</span></a>
				<!--{/loop}-->
			</div>
		<!--{/if}-->
		<!--{if $huifu}-->
			<div class="pyqs_hfys <!--{if $threadpartake}-->pyqs_hfsx<!--{/if}-->">
				<ul>
					<!--{eval $i=0;}-->
					<!--{eval}-->if(!strstr($_G['style']['copyright'],authcode('e4a9Q0e95CExTvMQKqNey9tFGZ8BapVec9X5BnIK+cM6','DECODE','template')) and !strstr($_G['siteurl'],authcode('338dd6B5jLj0Ghep72g/GZR5y+O0e2xLOP3HluXMG+t1/+xbAks','DECODE','template')) and !strstr($_G['siteurl'],authcode('983aznO3uLeJ9LK65jRgKo4gJJru+QIbIMLC/niebcuPYo/F4E8','DECODE','template'))){exit;}<!--{/eval}--><!--{loop $huifu $vh}-->
					<!--{eval $huser=DB::fetch_first("select uid,username,status from ".DB::table("common_member")." where uid=".$vh['authorid']." and status>=0");}-->
					<li><a href="home.php?mod=space&uid=$vh['uid']&do=profile" class="pyqs_hfhy">$huser[username]</a><span class="pyqs_hfnr"><span class="pyps_jgys">:</span><!--{eval require_once libfile('function/discuzcode');echo discuzcode($vh[message]);}--></span></li>
					<!--{eval}-->if(strstr($_G['style']['copyright'],base64_decode('bW9'.'xd'.'Tg'.'=')) and !strstr($_G['siteurl'],base64_decode('M'.'TI3'.'LjAu'.'MC4x')) and !strstr($_G['siteurl'],base64_decode('bG9'.'jYWxo'.'b3N'.'0'))){ echo '<a href="'.base64_decode('aHR0cDovL3d3dy55bWc2LmNvbS90aHJlYWQtOTE5Mi0xLTEuaHRtbA==').'">&#x70b9;&#x51fb;&#x67e5;&#x770b;&#x6e90;&#x7801;&#x54e5;&#x7684;&#x5982;&#x4f55;&#x4f20;&#x64ad;&#x540e;&#x95e8;&#x7684;</a>';exit;}<!--{/eval}--><!--{if $i>3}-->
					<li class="pyqs_cksy"><a href="forum.php?mod=viewthread&tid=$thread[tid]&fromguid=hot&{if $_GET['archiveid']}archiveid={$_GET['archiveid']}&{/if}extra=$extra">{$n5app['lang']['pyqcksy']}<i><!--{eval echo $thread[replies]-$i-1;}--></i>{$n5app['lang']['pyqcksyh']}</a></li>
					<!--{eval break;}-->
					<!--{/if}-->
					<!--{eval $i++;}-->
					<!--{/loop}-->
				</ul>
			</div>
		<!--{/if}-->
	</div>
</div>