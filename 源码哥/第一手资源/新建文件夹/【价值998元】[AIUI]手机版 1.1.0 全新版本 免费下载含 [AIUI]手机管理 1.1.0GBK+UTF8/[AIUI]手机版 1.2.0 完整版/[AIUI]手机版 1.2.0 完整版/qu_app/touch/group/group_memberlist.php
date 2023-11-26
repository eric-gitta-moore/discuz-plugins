<?PHP exit('QQÈº£º550494646');?>
<!--{if $op == 'alluser'}-->
	<!--{if $adminuserlist}-->
		<div class="group_member">
			<h2>{lang group_admin_member}</h2>
			<div class="cl">
				<ul>
					<!--{loop $adminuserlist $user}-->
					<li>
						<a href="home.php?mod=space&uid=$user[uid]" title="{if $user['level'] == 1}{lang group_moderator_title}{elseif $user['level'] == 2}{lang group_moderator_vice_title}{/if}{if $user['online']} {lang login_normal_mode}{/if}">
							<!--{echo avatar($user[uid], 'middle')}-->
						</a>
						
					</li>
					<!--{/loop}-->
				</ul>
			</div>
		</div>
	<!--{/if}-->
	<!--{if $staruserlist || $alluserlist}-->
		<div class="group_member">
			<h2>{lang member}</h2>
			<div class="cl">

				<!--{if $alluserlist}--><!--From www.moq u8 .com -->
					<ul>
						<!--{loop $alluserlist $user}-->
						<li>
							<a href="home.php?mod=space&uid=$user[uid]" class="avt" c="1"><!--{echo avatar($user[uid], 'middle')}--></a>
						</li>
						<!--{/loop}-->
					</ul>
				<!--{/if}-->
			</div>
		</div>
	<!--{/if}-->
	<!--{if $multipage}-->$multipage<!--{/if}-->
<!--{/if}-->