<?php exit;?>
<!--{if $op == 'alluser'}-->
	<!--{if $adminuserlist}-->
		<div class="n5ht_gltd cl">
			<div class="gltd_btys">{lang group_admin_member}</div>
			<div class="h5ht_cylb cl">
				<ul>
					<!--{loop $adminuserlist $user}-->
					<li>
						<a href="home.php?mod=space&uid=$user[uid]">
							<!--{echo avatar($user[uid], 'middle')}-->
							<p class="cylb_hymc cylb_gltd">$user[username]<span>{if $user['level'] == 1}{$n5app['lang']['qzszyybqz']}{elseif $user['level'] == 2}{$n5app['lang']['qzszyybfqz']}{/if}</span></p>
						</a>
					</li>
					<!--{/loop}-->
				</ul>
			</div>
		</div>
	<!--{/if}-->
	<!--{if $staruserlist || $alluserlist}-->
		<div class="n5ht_gltd cl">
			<div class="gltd_btys">{lang member}</div>
			<div class="h5ht_cylb cl">
				<!--{if $alluserlist}-->
					<ul>
						<!--{if $staruserlist}-->
						<!--{loop $staruserlist $user}-->
						<li>
							<a href="home.php?mod=space&uid=$user[uid]">
							<!--{echo avatar($user[uid], 'middle')}-->
							<p class="cylb_hymc">$user[username]<span>{lang group_star_member_title}</span></p>
							<p class="cylb_jrsj">{$n5app['lang']['qzfllbqjrsj']}<!--{echo dgmdate($user[joindateline], 'u', '9999', getglobal('setting/dateformat'))}--></p>
							</a>
						</li>
						<!--{/loop}-->
						<!--{/if}-->
						<!--{loop $alluserlist $user}-->
						<li>
							<a href="home.php?mod=space&uid=$user[uid]">
							<!--{echo avatar($user[uid], 'middle')}-->
							<p class="cylb_hymc">$user[username]</p>
							<p class="cylb_jrsj">{$n5app['lang']['qzfllbqjrsj']}<!--{echo dgmdate($user[joindateline], 'u', '9999', getglobal('setting/dateformat'))}--></p>
							</a>
						</li>
						<!--{/loop}-->
					</ul>
				<!--{/if}-->
			</div>
		</div>
	<!--{/if}-->
	<!--{if $multipage}-->$multipage<!--{/if}-->
<!--{/if}-->

<div class="n5qj_wbys cl">
	<a href="forum.php?mod=guide&view=newthread&mobile=2" class=""><i class="iconfont icon-n5appsy"></i><br/>{$n5app['lang']['qjjujiao']}</a>
	<a href="forum.php?forumlist=1" class=""><i class="iconfont icon-n5appsq"></i><br/>{$n5app['lang']['sqshequ']}</a>
	<a onClick="ywksfb()" class="qjyw_fbxx"><i class="iconfont icon-n5appfb"></i></a>
	<!--{if $n5app['dbdhdsl'] == 1}--><a href="group.php" class="on"><i class="iconfont icon-n5appqzon"></i><br/>{$n5app['lang']['sssswzqz']}</a>
	<!--{elseif $n5app['dbdhdsl'] == 2}--><a href="home.php?mod=follow" class=""><i class="iconfont icon-n5appht"></i><br/>{$n5app['lang']['qjhuati']}</a>
	<!--{elseif $n5app['dbdhdsl'] == 3}--><a href="{$n5app['dbdhsasllj']}" class="qjyw_fxxx"><i class="iconfont icon-n5appdsl"></i><br/>{$n5app['dbdhsaslwz']}</a>
	<!--{/if}-->
	<!--{if $n5app['dbdhssl'] == 1}--><a href="<!--{if $_G[uid]}-->home.php?mod=space&uid=$_G[uid]&do=profile&mycenter=1<!--{else}-->member.php?mod=logging&action=login<!--{/if}-->" <!--{if $_G[uid]}-->class="qjyw_txys"<!--{/if}-->><!--{if $_G[uid]}--><!--{avatar($_G[uid])}--><!--{else}--><i class="iconfont icon-n5appwd"></i><!--{/if}--><br/>{$n5app['lang']['qjwode']}<!--{if $_G[member][newprompt]}--><b></b><!--{/if}--><!--{if $_G[member][newpm]}--><b></b><!--{/if}--></a>
	<!--{elseif $n5app['dbdhssl'] == 2}--><a href="{$n5app['dbdhssllj']}" class="qjyw_fxxx"><i class="iconfont icon-n5appfx"></i><br/>{$n5app['dbdhsslwz']}</a><!--{/if}-->
</div>
<div class="wbys_yqmb"></div>