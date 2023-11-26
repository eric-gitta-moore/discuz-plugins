<?PHP exit('QQÈº£º550494646');?>
<!--{eval $_G['home_tpl_titles'] = array('{lang remind}');}-->
<!--{template common/header}-->
<!-- header start -->
<header class="header">
    <div class="nav">
        <a href="#" class="z back"><i class="iconfont icon-back"></i></a>
        <span class="category"><span class="name">{lang remind}</span>
        </span>
    </div>
</header>
<!-- header end -->

<div class="ainuo_mn">
		<div class="ainuo_usertb cl">
            <ul class="tb atx cl">
                <!--{loop $_G['notice_structure'] $key $type}-->
                <li $opactives[$key]><a href="home.php?mod=space&do=notice&view=$key"><!--{eval echo lang('template', 'notice_'.$key)}--><!--{if $_G['member']['category_num'][$key]}--><em></em><!--{/if}--></a></li>
                <!--{/loop}-->
                <!--{if $_G['setting']['my_app_status']}-->
                <li$actives[userapp]><a href="home.php?mod=space&do=notice&view=userapp">{lang applications_news}{if $mynotice}<em></em>{/if}</a></li>
                <!--{/if}--><!--From www.moq u8 .com -->
            </ul>
        </div>
        <div class="grey_line cl"></div>
		<div class="ainuo_remind" id="ainuo_remind">
			<ul class="tb cl">
            	<!--{if $_G['notice_structure'][$view] && ($view == 'mypost' || $view == 'interactive')}-->
					<!--{loop $_G['notice_structure'][$view] $subtype}-->
						<li$readtag[$subtype]><a href="home.php?mod=space&do=notice&view=$view&type=$subtype"><!--{eval echo lang('template', 'notice_'.$view.'_'.$subtype)}--><!--{if $_G['member']['newprompt_num'][$subtype]}--><em></em><!--{/if}--></a></li>
					<!--{/loop}-->
				<!--{else}-->
					<li class="a"><a href="home.php?mod=space&do=notice&view=$view"><!--{eval echo lang('template', 'notice_'.$view)}--></a></li>
				<!--{/if}-->
			</ul>
		<!--{if $view=='system' || $view=='manage' || $view=='app'}-->
        <style>.ainuo_remind .tb{ display:none;}</style>
        <!--{/if}-->
		<!--{if $view=='userapp'}-->

			<script type="text/javascript">
				function manyou_add_userapp(hash, url) {
					if(isUndefined(url)) {
						$(hash).innerHTML = "<tr><td colspan=\"2\">{lang successfully_ignored_information}</td></tr>";
					} else {
						$(hash).innerHTML = "<tr><td colspan=\"2\">{lang is_guide_you_in}</td></tr>";
					}
					var x = new Ajax();
					x.get('home.php?mod=misc&ac=ajax&op=deluserapp&hash='+hash, function(s){
						if(!isUndefined(url)) {
							location.href = url;
						}
					});
				}
			</script>

			<div class="ct_vw cl">
				<div class="ct_vw_sd">
					<ul class="mtw">
						<!--{if $list}--><li><a href="home.php?mod=space&do=notice&view=userapp">{lang all_applications_news}</a></li><!--{/if}-->
						<!--{loop $apparr $type $val}-->
						<li class="mtn">
							<a href="home.php?mod=userapp&id=$val[0][appid]&uid=$space[uid]" title="$val[0][typename]"><img src="http://appicon.manyou.com/icons/$val[0][appid]" alt="$val[0][typename]" class="vm" /></a>
							<a href="home.php?mod=space&do=notice&view=userapp&type=$val[0][appid]"> <!--{eval echo count($val);}--> {lang unit} $val[0][typename] <!--{if $val[0][type]}-->{lang request}<!--{else}-->{lang invite}<!--{/if}--></a>
						</li>
						<!--{/loop}-->
					</ul>
				</div>
				<div class="ct_vw_mn">
					<!--{if $list}-->
						<!--{loop $list $key $invite}-->
							<h4 class="mtw mbm">
								<a href="home.php?mod=space&do=notice&view=userapp&op=del&appid=$invite[0][appid]" class="y xg1">{lang ignore_invitations_application}</a>
								<a href="home.php?mod=userapp&id=$invite[0][appid]&uid=$space[uid]" title="$apparr[$invite[0][appid]]"><img src="http://appicon.manyou.com/icons/$invite[0][appid]" alt="$apparr[$invite[0][appid]]" class="vm" /></a>
								{lang notice_you_have} <!--{eval echo count($invite);}--> {lang unit} $invite[0][typename] <!--{if $invite[0][type]}-->{lang request}<!--{else}-->{lang invite}<!--{/if}-->
							</h4>
							<div class="xld xlda">
							<!--{loop $invite $value}-->
								<dl class="bbda cl">
									<dd class="m avt mbn">
										<a href="home.php?mod=space&uid=$value[fromuid]"><!--{avatar($value[fromuid],small)}--></a>
									</dd>
									<dt id="$value[hash]">
										<div class="xw0 xi3">$value[myml]</div>
									</dt>
								</dl>
							<!--{/loop}-->
							</div>
						<!--{/loop}-->
						<!--{if $multi}--><div class="pgs cl">$multi</div><!--{/if}-->
					<!--{else}-->
                        <div class="emp"><i class="iconfont icon-meiyougengduole"></i><p>{lang no_request_applications_invite}</p></div>
					<!--{/if}-->
				</div>
			</div>

		<!--{else}-->
			<!--{if empty($list)}-->
			<div class="emp mtw ptw hm xs2">
				<!--{if $new == 1}-->
					{lang no_new_notice}<a href="home.php?mod=space&do=notice&isread=1">{lang view_old_notice}</a>
				<!--{else}-->
					{lang no_notice}
				<!--{/if}-->
			</div>
			<!--{/if}-->

			<script type="text/javascript">

				function deleteQueryNotice(uid, type) {
					var dlObj = $(type + '_' + uid);
					if(dlObj != null) {
						var id = dlObj.getAttribute('notice');
						var x = new Ajax();
						x.get('home.php?mod=misc&ac=ajax&op=delnotice&inajax=1&id='+id, function(s){
							dlObj.parentNode.removeChild(dlObj);
						});
					}
				}

				function errorhandle_pokeignore(msg, values) {
					deleteQueryNotice(values['uid'], 'pokeQuery');
				}
			</script>

			<!--{if $list}-->
				<div class="xld">
					<div class="nts">
						<!--{loop $list $key $value}-->
							<div class="ntsimg {if $value['new']}ntsimgcolor{/if} cl" $value[rowid] notice="$value[id]">
								<div class="img_l">
									<!--{if $value[authorid]}-->
									<a href="home.php?mod=space&uid=$value[authorid]"><!--{avatar($value[authorid],middle)}--></a>
									<!--{else}-->
									<img src="{IMGDIR}/systempm.png" alt="systempm" />
									<!--{/if}-->
								</div>
                                <div class="img_r" id="ntc_content">
                                    <p class="atime"><!--{date($value[dateline], 'u')}--></p>
                                    <p class="ntc_body">$value[note]</p>
                                    <!--{if $value[from_num]}-->
                                    <p class="dashedtip">{lang ignore_same_notice_message}</p>
                                    <!--{/if}-->
                                </div>
								
							</div>
						<!--{/loop}-->
					</div>
				</div>

				<!--{if $view!='userapp' && $space[notifications]}-->
				<div class="mtm mbm"><a href="home.php?mod=space&do=notice&ignore=all">{lang ignore_same_notice_message} <em>&rsaquo;</em></a></div>
				<!--{/if}-->

				<!--{if $multi}--><div class="pgs cl">$multi</div><!--{/if}-->
            <!--{/if}-->

		<!--{/if}-->
		</div>
	</div>

<script>
	function modifyTarget(){
		var aN = document.getElementById("ainuo_remind").getElementsByTagName("a");
		for(var i =0; i < aN.length; i++){
		aN[i].target ="_self";
		}
	}
	modifyTarget();
</script>

<!--{template common/footer}-->