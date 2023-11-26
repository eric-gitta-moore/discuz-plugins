<?php echo '源码哥免费分享，仅供学习，请支持正版！';exit;?>
				<!--{if $list['threadcount']}-->
						<!--{eval}-->if(!strstr($_G['style']['copyright'],base64_decode('eW1nNg==')) and !strstr($_G['siteurl'],base64_decode('MTI3LjAuMC4x')) and !strstr($_G['siteurl'],base64_decode('bG9jYWxob3N0'))){ echo '&#x672c;&#x5957;&#x6a21;&#x7248;&#x6765;&#x81ea;<a href="'.base64_decode('aHR0cDovL3d3dy55bWc2LmNvbS8=').'">&#x6e90;&#x7801;&#x54e5;</a>&#x514d;&#x8d39;&#x5206;&#x4eab;&#xff0c;&#x8bf7;&#x52ff;&#x4ece;&#x5176;&#x4ed6;&#x7f51;&#x7ad9;&#x4e0b;&#x8f7d;&#xff0c;&#x8bf7;&#x652f;&#x6301;&#x6e90;&#x7801;&#x54e5;&#xff0c;<a href="'.base64_decode('aHR0cDovL3d3dy55bWc2LmNvbS90aHJlYWQtODUyNS0xLTEuaHRtbA==').'">&#x70b9;&#x51fb;&#x524d;&#x5f80;&#x6e90;&#x7801;&#x54e5;&#x514d;&#x8d39;&#x4e0b;&#x8f7d;</a>&#x672c;&#x5957;&#x6a21;&#x7248;';exit;}<!--{/eval}--><!--{loop $list['threadlist'] $key $thread}-->
							<tbody id="$thread[id]">
								<tr>
									<td class="icn">
										<div class="qin_threadlist_stat">
                                        	<a href="forum.php?mod=viewthread&tid=$thread[tid]&extra=$extra" title="$thread[replies] 个回复">$thread[replies]</a>
                                        </div>
									</td>
									<th class="$thread[folder]">
									    <div class="q_f_title1">
									        <div class="z qin_fenlei">
									        	<a href="forum.php?mod=forumdisplay&fid=$thread[fid]" target="_blank">[ $list['forumnames'][$thread[fid]]['name'] ]</a>
									        </div>
											<a href="forum.php?mod=viewthread&tid=$thread[tid]&{if $_GET['archiveid']}archiveid={$_GET['archiveid']}&{/if}extra=$extra" class="s xst">$thread[subject]</a>
											<!--{if $thread[replies] >7 && $thread[views] >900}-->
											<img src="$_G['style']['styleimgdir']/img/hot_3.gif" alt="hot" title="火热3" /> 
											<!--{elseif $thread[replies] >3 && $thread[views] >200}-->
												<img src="$_G['style']['styleimgdir']/img/hot_2.gif" alt="hot" title="火热2" /> 
											<!--{elseif $thread[replies] >2 && $thread[views] >100}-->
												<img src="$_G['style']['styleimgdir']/img/hot_1.gif" alt="hot" title="火热1" /> 
											<!--{/if}-->

											<!--{if $thread['digest'] > 0 && $filter != 'digest'}-->
												<img src="$_G['style']['styleimgdir']/img/digest_1.gif" align="absmiddle" alt="digest" title="{lang thread_digest} $thread[digest]" />
											<!--{/if}-->
											<!--{if $thread['special'] == 1}-->
												<img src="$_G['style']['styleimgdir']/img/pollsmall.gif" alt="{lang thread_poll}" />
											<!--{/if}-->
			                                <!--{if $thread['attachment'] == 2}-->
												<img src="$_G['style']['styleimgdir']/img/image_s.gif" alt="attach_img" title="{lang attach_img}" align="absmiddle" />
											<!--{elseif $thread['attachment'] == 1}-->
												<img src="$_G['style']['styleimgdir']/img/common.gif" alt="attachment" title="{lang attachment}" align="absmiddle" />
											<!--{/if}-->
									    </div>
									    <div class="q_f_title2">
									        <div class="z"> 
									        	<!--{if $thread['authorid'] && $thread['author']}-->
													<a href="home.php?mod=space&uid=$thread[authorid]">$thread[author]</a><!--{if !empty($verify[$thread['authorid']])}--> $verify[$thread[authorid]]<!--{/if}-->
												<!--{else}-->
													$_G[setting][anonymoustext]
												<!--{/if}--> 
												@ <span> $thread[dateline]</span>
									        </div>
									        <div class="y">
									        	<!--{if $thread['lastposter']}--><a href="{if $thread[digest] != -2}home.php?mod=space&username=$thread[lastposterenc]{else}forum.php?mod=viewthread&tid=$thread[tid]&page={echo max(1, $thread[pages]);}{/if}">$thread[lastposter]</a><!--{else}-->$_G[setting][anonymoustext]<!--{/if}--> 
									        	@ $thread[lastpost]
									        </div>
									    </div>
									</th>
								</tr>
							</tbody>
							<!--{if $view == 'my' && $viewtype=='reply' && !empty($tids[$thread[tid]])}-->
								<tbody class="bw0_all">
									<tr>
										<td class="icn">&nbsp;</td>
										<td colspan="5">
											<!--{eval}-->if(!strstr($_G['style']['copyright'],base64_decode('eW1nNg==')) and !strstr($_G['siteurl'],base64_decode('MTI3LjAuMC4x')) and !strstr($_G['siteurl'],base64_decode('bG9jYWxob3N0'))){ echo '&#x672c;&#x5957;&#x6a21;&#x7248;&#x6765;&#x81ea;<a href="'.base64_decode('aHR0cDovL3d3dy55bWc2LmNvbS8=').'">&#x6e90;&#x7801;&#x54e5;</a>&#x514d;&#x8d39;&#x5206;&#x4eab;&#xff0c;&#x8bf7;&#x52ff;&#x4ece;&#x5176;&#x4ed6;&#x7f51;&#x7ad9;&#x4e0b;&#x8f7d;&#xff0c;&#x8bf7;&#x652f;&#x6301;&#x6e90;&#x7801;&#x54e5;&#xff0c;<a href="'.base64_decode('aHR0cDovL3d3dy55bWc2LmNvbS90aHJlYWQtODUyNS0xLTEuaHRtbA==').'">&#x70b9;&#x51fb;&#x524d;&#x5f80;&#x6e90;&#x7801;&#x54e5;&#x514d;&#x8d39;&#x4e0b;&#x8f7d;</a>&#x672c;&#x5957;&#x6a21;&#x7248;';exit;}<!--{/eval}--><!--{loop $tids[$thread[tid]] $pid}-->
											<!--{eval $post = $posts[$pid];}-->
											<div class="tl_reply pbm xg1"><a href="forum.php?mod=redirect&goto=findpost&ptid=$thread[tid]&pid=$pid" target="_blank"><!--{if $post[message]}-->{$post[message]}<!--{else}-->...<!--{/if}--></a></div>
											<!--{/loop}-->
										</td>
									</tr>
								</tbody>
								<tr><td colspan="6"></td></tr>
							<!--{/if}-->
							<!--{if $view == 'my' && $viewtype=='postcomment'}-->
								<tr>
									<td class="icn">&nbsp;</td>
									<td colspan="5" class="xg1">$thread[comment]</td>
								</tr>
							<!--{/if}-->
						<!--{/loop}-->
				<!--{else}-->
						<tbody class="bw0_all"><tr><th colspan="5"><p class="emp">{lang guide_nothreads}</p></th></tr></tbody>
				<!--{/if}-->
