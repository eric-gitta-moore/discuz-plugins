<?PHP exit('QQÈº£º550494646');?>
<!--{eval $_G['home_tpl_titles'] = array('{lang pm}');}-->
<!--{template common/header}-->

<!--{if in_array($filter, array('privatepm'))}-->

    <header class="header">
        <div class="nav">
            <a href="home.php?mod=spacecp&ac=pm" class="y"><i class="iconfont icon-quillpenblack"></i></a>
            <a href="#" class="z back"><i class="iconfont icon-back"></i></a>
            <span class="name">{lang private_pm}</span>
        </div>
    </header>

    <!--{template common/top_fix}-->
    
    <div class="ainuo_pmbox cl">
        <div class="cl">
            <div class="ainuo_usertb cl">
                <ul class="tb apm cl">
                    <li$actives[privatepm] $actives[newpm]><a href="home.php?mod=space&do=pm&filter=privatepm">{lang private_pm}</a></li>
                    <li$actives[announcepm]><a href="home.php?mod=space&do=pm&filter=announcepm">{lang announce_pm}</a></li>
                    <li><a href="home.php?mod=space&do=pm&subop=setting" class="xi2">{lang pm_setting}</a></li>
                </ul>
            </div>
            <div class="grey_line cl"></div>
            <!--{if ($filter == 'privatepm' && $newpm) || $filter == 'newpm'}-->
            <div class="dashedtip cl">
                <!--{if $filter != 'newpm'}-->
                    <a href="home.php?mod=space&do=pm&filter=newpm" class="xi2">{lang view_newpm}</a>
                <!--{else}-->
                    <a href="home.php?mod=space&do=pm&filter=privatepm" class="xi2">{lang view_privatepm}</a>
                <!--{/if}-->
            </div>
            <!--{/if}-->
            <div class="cl">
    
                <!--{if $_GET['subop'] == 'view'}-->
    
                    <!--{if $list && $daterange && !$touid}-->
                        <!--{if empty($lastanchor)}--><a name="last"></a><!--{eval $lastanchor=1;}--><!--{/if}-->
                        <div class="pm_g cl">
                            <h2 class="mbm xs2"><span class="xi1">$membernum</span> {lang pm_members_message} : <span class="xi2">$subject</span></h2>
                            <div class="pm_sd">
                                <ul class="pm_mem_l{if $authorid == $_G['uid']} pm_admin{/if}">
                                <!--{loop $chatpmmemberlist $key $value}-->
                                    <li><a href="home.php?mod=space&uid=$value[uid]" target="_blank" {if $ols[$value[uid]]} class="xi2" title="{lang online}"{else} class="xg1"{/if}>$value[username]</a></li>
                                <!--{/loop}-->
                                </ul>
                                <!--{if $authorid == $_G['uid']}-->
                                    <div class="pm_add cl">
                                        <input type="text" name="username" id="username" class="px z" value="" />
                                        <span class="z">&nbsp;</span>
                                        <a href="home.php?mod=spacecp&ac=pm&op=appendmember&plid=$plid" id="a_appendmember" class="pn z" title="{lang appendchatpmmember_comment}" onclick="getchatpmappendmember();"><span>+</span></a>
                                    </div>
                                <!--{/if}-->
                            </div>
                            <div class="pm_mn">
                                <div id="msglist" class="pm_b">
                                <!--{loop $list $key $value}-->
                                    <p class="xg1 mbn"><a href="home.php?mod=space&uid=$value[authorid]" target="_blank" class="xi2">$value[author]</a> &nbsp; <!--{date($value[dateline], 'u')}--></p>
                                    <p class="mbm">$value[message]</p>
                                <!--{/loop}-->
                                </div>
                                <script type="text/javascript">
                                var refresh = true;
                                var refreshHandle = -1;
                                var autorefresh = {$refreshtime};
                                </script>
                                
                                <script type="text/javascript">
                                    var msgListObj = $('msglist');
                                    msgListObj.scrollTop = msgListObj.scrollHeight;
                                    function succeedhandle_pmsend(url, msg, values) {
                                        var pObj = document.createElement("p");
                                        pObj.className = 'xg1 mbn';
                                        pObj.innerHTML = '<a href="home.php?mod=space&uid=$_G[uid]" target="_blank" class="xi2">$_G[username]</a> &nbsp;'+ "{lang just_now}";
                                        var pObjmsg = document.createElement("p");
                                        pObjmsg.className = 'mbm';
                                        var pmMsg = $('replymessage');
                                        pObjmsg.innerHTML = bbcode2html(parseurl(pmMsg.value));
                                        msgListObj.appendChild(pObj);
                                        msgListObj.appendChild(pObjmsg);
                                        msgListObj.scrollTop = msgListObj.scrollHeight;
                                        pmMsg.value = "";
                                        showCreditPrompt();
                                    }
    
                                    function refreshMsg(refreshnow) {
                                        if(refresh) {
                                            if(autorefresh <= 0 || refreshnow){
                                                var x = new Ajax();
                                                x.get('home.php?mod=spacecp&ac=pm&op=showchatmsg&inajax=1&daterange=$daterange&plid=$plid', function(s){
                                                    msgListObj.innerHTML = s;
                                                    msgListObj.scrollTop = msgListObj.scrollHeight;
    
                                                });
                                                autorefresh = {$refreshtime};
                                            }
                                            <!--{if $refreshtime}-->
                                            $('refreshtip').innerHTML = autorefresh + ' {lang next_refresh}';
                                            <!--{/if}-->
                                            autorefresh -= 2;
                                        } else {
                                            window.clearInterval(refreshHandle);
                                        }
                                    }
                                    <!--{if $refreshtime}-->
                                    refreshHandle = window.setInterval('refreshMsg(0);', 2000);
                                    <!--{/if}-->
                                    hideMenu();
                                </script>
                            <!--/div/div-->
                    <!--{elseif $list && !$daterange}-->
                        
                    <!--{elseif $chatpmmemberlist}-->
                        <!--{if $authorid == $_G['uid']}-->
                            <div class="tbmu mtn tfm pmform cl">
                                <script type="text/javascript" src="{$_G[setting][jspath]}home_friendselector.js?{VERHASH}"></script>
                                <script type="text/javascript">
                                    var fs;
                                    var clearlist = 0;
                                </script>
                                <div class="cl">
                                    <div class="un_selector px z cl" onclick="$('username').focus();">
                                        <input type="text" name="username" id="username" autocomplete="off" />
                                    </div>
                                    <a href="home.php?mod=spacecp&ac=pm&op=appendmember&plid=$plid" id="a_appendmember" class="pn appendmb z" title="{lang appendchatpmmember_comment}" onclick="getchatpmappendmember();"><span class="z">{lang appendchatpmmember}</span></a>
                                    <a href="javascript:;" id="showSelectBox" class="z mtn showmenu" onclick="showMenu({'showid':this.id, 'duration':3, 'pos':'34!'});fs.showPMFriend('showSelectBox_menu','selectorBox', this);" title="{lang selectfromfriendlist}">{lang select_friend}</a>
                                </div>
                                <p class="d">{lang sendpm_tip}</p>
                            </div>
                            <div id="username_menu" style="display: none;">
                                <ul id="friends" class="pmfrndl"></ul>
                            </div>
                            <div class="p_pof" id="showSelectBox_menu" unselectable="on" style="display:none;">
                                <div class="pbm">
                                    <select class="ps" onchange="clearlist=1;getUser(1, this.value)">
                                        <option value="-1">{lang invite_all_friend}</option>
                                        <!--{loop $friendgrouplist $groupid $group}-->
                                            <option value="$groupid">$group</option>
                                        <!--{/loop}-->
                                    </select>
                                </div>
                                <div id="selBox" class="ptn pbn">
                                    <ul id="selectorBox" class="xl xl2 cl"></ul>
                                </div>
                                <div class="cl">
                                    <button type="button" class="y pn" onclick="fs.showPMFriend('showSelectBox_menu','selectorBox', $('showSelectBox'));doane(event)"><span>{lang close}</span></button>
                                </div>
                            </div>
    
                            <script type="text/javascript">
    
                                var page = 1;
                                var gid = -1;
                                var showNum = 0;
                                var haveFriend = true;
                                function getUser(pageId, gid) {
                                    page = parseInt(pageId);
                                    gid = isUndefined(gid) ? -1 : parseInt(gid);
                                    var x = new Ajax();
                                    x.get('home.php?mod=spacecp&ac=friend&op=getinviteuser&inajax=1&page='+ page + '&gid=' + gid + '&' + Math.random(), function(s) {
                                        var data = eval('('+s+')');
                                        var singlenum = parseInt(data['singlenum']);
                                        var maxfriendnum = parseInt(data['maxfriendnum']);
                                        fs.addDataSource(data, clearlist);
                                        haveFriend = singlenum && singlenum == 20 ? true : false;
                                        if(singlenum && fs.allNumber < 20 && fs.allNumber < maxfriendnum && maxfriendnum > 20 && haveFriend) {
                                            page++;
                                            getUser(page);
                                        }
                                    });
                                }
                                function selector() {
                                    var parameter = {'searchId':'username', 'showId':'friends', 'formId':'', 'showType':3, 'handleKey':'fs', 'selBox':'selectorBox', 'selBoxMenu':'showSelectBox_menu', 'maxSelectNumber':'20', 'selectTabId':'selectNum', 'unSelectTabId':'unSelectTab', 'maxSelectTabId':'remainNum'};
                                    fs = new friendSelector(parameter);
                                    var listObj = $('selBox');
                                    listObj.onscroll = function() {
                                        clearlist = 0;
                                        if(this.scrollTop >= this.scrollHeight/5) {
                                            page++;
                                            gid = isUndefined(gid) ? 0 : parseInt(gid);
                                            if(haveFriend) {
                                                getUser(page, gid);
                                            }
                                        }
                                    }
                                    getUser(page);
                                }
                                selector();
                            </script>
    
                        <!--{/if}-->
                        <ul class="buddy cl">
                            <li>
                                <div class="avt"><a href="home.php?mod=space&uid=$authorid" title="$chatpmmemberlist[$authorid][username]" target="_blank" c="1"><em class="gm"></em><!--{avatar($authorid,small)}--></a></div>
                                <h4><a href="home.php?mod=space&uid=$authorid" title="$chatpmmemberlist[$authorid][username]">$chatpmmemberlist[$authorid][username]</a></h4>
                                <p class="maxh">$chatpmmemberlist[$authorid][recentnote]</p>
                            </li>
                        <!--{eval unset($chatpmmemberlist[$authorid]);}-->
                        <!--{loop $chatpmmemberlist $key $value}-->
                            <li>
                                <div class="avt"><a href="home.php?mod=space&uid=$value[uid]" title="$value[username]" target="_blank" c="1"><!--{avatar($value[uid],small)}--></a></div>
                                <h4><a href="home.php?mod=space&uid=$value[uid]" title="$value[username]">$value[username]</a></h4>
                                <p class="maxh">$value[recentnote]</p>
                                <!--{if $authorid == $_G['uid']}-->
                                    <p class="xg1"><a href="home.php?mod=spacecp&ac=pm&op=kickmember&memberuid=$key&plid=$plid" id="a_kickmmeber_$key" title="{lang kickmemberwho}" onclick="showWindow(this.id, this.href, 'get', 0);">{lang kickmember}</a></p>
                                <!--{/if}-->
                            </li>
                        <!--{/loop}-->
                        </ul>
                    <!--{else}-->
                        <div class="emp"><i class="iconfont icon-meiyougengduole"></i><p>{lang no_corresponding_pm}</p></div>
                    <!--{/if}-->
    
                    
                    <!--{if $list && $daterange && !$touid}-->
                            </div>
                        </div>
                    <!--{/if}-->
    
                
    
                <!--{else}-->
    
                    <!--{if $count || $grouppms}-->
                        <form id="deletepmform" action="home.php?mod=spacecp&ac=pm&op=delete&folder=$folder" method="post" autocomplete="off" name="deletepmform">
                            <div class="pmul cl">
                                <!--{if $grouppms}-->
                                <ul>
                                    <!--{loop $grouppms $grouppm}-->
                                        <li id="gpmlist_$grouppm[id]" {if !$gpmstatus[$grouppm[id]]}class="newpm"{/if}>
                                        	<div class="avatar_img">
                                                <!--{if $grouppm[author]}-->
                                                    <img src="static/images/common/annpm.png" alt="" />
                                                <!--{else}-->
                                                    <img src="static/images/common/systempm.png" alt="" />
                                                <!--{/if}-->
                                                <span class="o">
                                                    <input type="checkbox" name="deletepm_gpmid[]" id="a_deleteg_$grouppm[id]" class="pc" value="$grouppm[id]" />
                                                </span>
                                            </div>
                                            <a href="home.php?mod=space&do=pm&subop=viewg&pmid=$grouppm[id]" id="gpmlist_$grouppm[id]_a">
                                            <!--{if $grouppm[author]}-->
                                            	<div class="atit cl">
                                                	{if !$gpmstatus[$grouppm[id]]}<span class="new">New</span>{/if}
                                                	<span>$grouppm[author] {lang say}:</span>
                                                </div>
                                             <!--{/if}-->
                                             	<div class="asec cl">
                                                	<p class="atime"><!--{date($grouppm[dateline], 'u')}--></p>
                                                <p class="axx" id="p_gpmid_$grouppm[id]">$grouppm[message]</p>
                                            	</div>
                                            </a>
                                        </li>
                                    <!--{/loop}-->
                                </ul>
                                <!--{/if}-->
                                <ul>
                                <!--{loop $list $key $value}-->
                                    <li id="gpmlist_$grouppm[id]" {if $value[new]}class="newpm"{/if}>
                                        <div class="avatar_img">
                                            <img style="height:40px;width:40px;" src="<!--{if $value[pmtype] == 2}-->{STATICURL}image/common/grouppm.png<!--{else}--><!--{avatar($value[touid] ? $value[touid] : ($value[lastauthorid] ? $value[lastauthorid] : $value[authorid]), middle, true)}--><!--{/if}-->" />
                                                <span class="o">
                                                    <!--{if $value['pmtype'] == 1}-->
                                                        <input type="checkbox" name="deletepm_deluid[]" id="a_delete_$value[plid]" class="pc" value="$value[touid]" />
                                                    <!--{elseif $value['pmtype'] == 2}-->
                                                        <!--{if $value['authorid'] == $_G['uid']}-->
                                                        <input type="checkbox" name="deletepm_delplid[]" id="a_delete_$value[plid]" class="pc" value="$value[plid]" />
                                                        <!--{else}-->
                                                        <input type="checkbox" name="deletepm_quitplid[]" id="a_delete_$value[plid]" class="pc" value="$value[plid]" />
                                                        <!--{/if}-->
                                                    <!--{/if}-->
                                                </span>    
                                        </div>
                                        <a href="home.php?mod=space&do=pm&subop=view&touid=$value[touid]">
                                            <div class="atit cl">
                                                <!--{if $value[new]}--><span class="new">$value[pmnum]</span><!--{else}--><span class="old">$value[pmnum]</span><!--{/if}-->
                                                <!--{if $value[touid]}-->
                                                    <!--{if $value[msgfromid] == $_G[uid]}-->
                                                        <span>{lang me}{lang you_to} {$value[tousername]}{lang say}:</span>
                                                    <!--{else}-->
                                                        <span>{$value[tousername]} {lang you_to}{lang me}{lang say}:</span>
                                                    <!--{/if}-->
                                                <!--{elseif $value['pmtype'] == 2}-->
                                                    <span>{lang chatpm_author}:$value['firstauthor']</span>
                                                <!--{/if}-->
                                                <!--{if $value[isnew]}--><em>$alang_newmessage</em><!--{/if}-->
                                            </div>
                                            <div class="asec cl">
                                                <p class="atime">
                                                <!--{date($value[dateline], 'u')}-->
                                                </p>
                                                <p class="axx"><!--{if $value['pmtype'] == 2}-->[{lang chatpm}]<!--{if $value[subject]}-->$value[subject]<br><!--{/if}--><!--{/if}--><!--{if $value['pmtype'] == 2 && $value['lastauthor']}--><div style="padding:0 0 0 10px;">......<br>$value['lastauthor'] : $value[message]</div><!--{else}-->$value[message]<!--{/if}--></p>
                                            </div>
                                        </a>
                                    </li>
                                 
                                <!--{/loop}-->
                                </ul>
                                <!--{if $multi}-->$multi<!--{/if}-->
                            </div>
                            
                            <!--{if $count || $grouppms}-->
                            <div class="pm_bot cl">
                              
                                <button type="submit" name="deletepmsubmit_btn" value="true">{lang delete}</button>
                            </div>
                            <!--{/if}-->
                            </div>
                            <input type="hidden" name='deletesubmit' value="true" />
                            <input type="hidden" name="formhash" value="{FORMHASH}" />
                        </form>

                    <!--{else}-->
                        <div class="emp"><i class="iconfont icon-meiyougengduole"></i><p>{lang no_corresponding_pm}</p></div>
                    <!--{/if}-->
    
                <!--{/if}-->
    
            </div>
        </div>
<!--{elseif in_array($_GET[subop], array('view'))}-->
<!--{eval require(DISCUZ_ROOT."./template/qu_app/touch/ainuo_user/pm.php");}-->
	{if $_GET[talk] == 'all'}
	<!-- header start -->
	<header class="header">
	    <div class="nav">
	        <a href="#" class="z back"><i class="iconfont icon-back"></i></a>
			<span class="name">{lang viewmypm}</span>
	    </div>
	</header>
	<!-- header end -->
    <!--{template common/top_fix}-->
    
    <div class="ainuo_nowpm">
    	{if $talklist}
		<div class="c">
			<ul class="pmb" id="msglist">
				<!--{loop $talklist $key $value}-->
				<!--{eval $class=$value['touid']==$_G['uid']?'cl':'cl pmm';}-->
				<li class="$class">
                	<div class="cl">
                        <div class="auava"><a href="home.php?mod=space&uid={$value[authorid]}&do=profile"><img src="<!--{avatar($value[authorid], middle, true)}-->" /></a></div>
                        <div class="pmt"></div>
                        <div class="pmd">{$value[message]}</div>
                    </div>
                    <div class="adate cl"><!--{date($value[dateline], 'u')}--></div>
				</li>
				<!--{/loop}-->
			</ul>
		</div>
        <!--{if $multipage}--><div class="pbm bbda cl">$multipage</div><!--{/if}-->
        {else}
        	<div class="emp"><i class="iconfont icon-meiyougengduole"></i><p>{lang no_corresponding_pm}</p></div>
        {/if}
	</div>
    
    {else}
    

    <script>
	$(document).ready(function(){
		$("#ainuo_contop").animate({ scrollTop: $('#ainuo_contop')[0].scrollHeight}, 500);
	});
	</script>
    <!-- header start -->
    <header class="header">
        <div class="nav">
            <a href="#" class="z back"><i class="iconfont icon-back"></i></a>
            <span class="name">{lang taking_with_user}</span>
            <a href="home.php?mod=space&do=pm&subop=view&touid={$touid}&talk=all&page=1" class="y"><i class="iconfont icon-time"></i></a>
        </div>
    </header>
    <!--{template common/top_fix}-->
    <!-- header end -->
    <div class="ainuo_nowpm">
   
		<div class="c">

			<ul class="pmb" id="msglist">
				<!--{loop $msglist $day $msgarr}-->
				<div class="cl">
					<h4><span>$day</span></h4>
				</div>
				<!--{loop $msgarr $key $value}-->
				<!--{eval $class=$value['touid']==$_G['uid']?'cl':'cl pmm';}-->
				<li class="$class">
                	<div class="cl">
                        <div class="auava"><a href="home.php?mod=space&uid={$value[authorid]}&do=profile"><img src="<!--{avatar($value[authorid], middle, true)}-->" /></a></div>
                        <div class="pmt"></div>
                        <div class="pmd">{$value[message]}</div>
                    </div>
                    <div class="adate cl"><!--{date($value[dateline], 'u')}--></div>
				</li>
                
				<!--{/loop}-->
				<!--{/loop}-->
			</ul>

            <div class="cl" style="width:100%; height:50px;"></div>
			<div class="pmfm cl">
				<form id="pmform_{$touid}" name="pmform_{$touid}" method="post" autocomplete="off" action="home.php?mod=spacecp&ac=pm&op=send&touid=$touid" onsubmit="this.message.value = parseurl(this.message.value);{if $_G[inajax]}ajaxpost(this.id,  'return_$_GET[handlekey]');refreshMsg();{/if}">
					<input type="hidden" name="pmsubmit" value="true" />
					<input type="hidden" name="touid" value="$touid" />
					<input type="hidden" name="formhash" value="{FORMHASH}" />
					<!--{if $_G[inajax]}-->
					<div id="return_$_GET[handlekey]" class="xi1" style="margin-bottom:5px"></div>
					<input type="hidden" name="handlekey" value="$_GET[handlekey]" />
					<!--{/if}-->
                    <div class="tedt_con">
                        <div class="tedt_l">
                            <textarea name="message" id="pmmessage" placeholder="$alang_xsds"></textarea>
                            <input type="hidden" name="messageappend" id="messageappend" value="$messageappend" />
                            
                        </div>
                        <div class="tedt_r">
                            <button type="submit" class="pn pnc send_message" id="pmsubmit_btn">{lang send}</button>
                        </div>
                    </div>
				</form>
				
			</div>
		</div>
        
	</div>
    {/if}
<!--{elseif in_array($filter, array('announcepm'))}-->
    <!-- header start -->
    <header class="header">
        <div class="nav">
            <a href="home.php?mod=spacecp&ac=pm" class="y"><i class="iconfont icon-quillpenblack"></i></a>
            <a href="#" class="z back"><i class="iconfont icon-back"></i></a>
            <span class="name">{lang announce_pm}</span>
        </div>
    </header>
    <!-- header end -->
    <!--{template common/top_fix}-->
    <div class="ainuo_pmbox cl">
        <div class="cl">
            <div class="ainuo_usertb cl">
                <ul class="tb apm cl">
                    <li$actives[privatepm] $actives[newpm]><a href="home.php?mod=space&do=pm&filter=privatepm">{lang private_pm}</a></li>
                    <li$actives[announcepm]><a href="home.php?mod=space&do=pm&filter=announcepm">{lang announce_pm}</a></li>
                    <li><a href="home.php?mod=space&do=pm&subop=setting" class="xi2">{lang pm_setting}</a></li>
                </ul>
            </div>
            <div class="grey_line cl"></div>
            <!--{if ($filter == 'privatepm' && $newpm) || $filter == 'newpm'}-->
            <div class="dashedtip cl">
                <!--{if $filter != 'newpm'}-->
                    <a href="home.php?mod=space&do=pm&filter=newpm" class="xi2">{lang view_newpm}</a>
                <!--{else}-->
                    <a href="home.php?mod=space&do=pm&filter=privatepm" class="xi2">{lang view_privatepm}</a>
                <!--{/if}-->
            </div>
            <!--{/if}-->
            <div class="cl">
    
                <!--{if $_GET['subop'] == 'view'}-->
    
                    <!--{if $list && $daterange && !$touid}-->
                        <div class="pm_g cl">
                            <h2 class="mbm xs2"><span class="xi1">$membernum</span> {lang pm_members_message} : <span class="xi2">$subject</span></h2>
                            <div class="pm_sd">
                                <ul class="pm_mem_l{if $authorid == $_G['uid']} pm_admin{/if}">
                                <!--{loop $chatpmmemberlist $key $value}-->
                                    <li><a href="home.php?mod=space&uid=$value[uid]" target="_blank" {if $ols[$value[uid]]} class="xi2" title="{lang online}"{else} class="xg1"{/if}>$value[username]</a></li>
                                <!--{/loop}-->
                                </ul>
                                <!--{if $authorid == $_G['uid']}-->
                                    <div class="pm_add cl">
                                        <input type="text" name="username" id="username" class="px z" value="" />
                                        <span class="z">&nbsp;</span>
                                        <a href="home.php?mod=spacecp&ac=pm&op=appendmember&plid=$plid" id="a_appendmember" class="pn z" title="{lang appendchatpmmember_comment}" onclick="getchatpmappendmember();"><span>+</span></a>
                                    </div>
                                <!--{/if}-->
                            </div>
                            <div class="pm_mn">
                                <div id="msglist" class="pm_b">
                                <!--{loop $list $key $value}-->
                                    <p class="xg1 mbn"><a href="home.php?mod=space&uid=$value[authorid]" target="_blank" class="xi2">$value[author]</a> &nbsp; <!--{date($value[dateline], 'u')}--></p>
                                    <p class="mbm">$value[message]</p>
                                <!--{/loop}-->
                                </div>
                                <script type="text/javascript">
                                var refresh = true;
                                var refreshHandle = -1;
                                var autorefresh = {$refreshtime};
                                </script>
                                <script type="text/javascript">var forumallowhtml = 0,allowhtml = 0,allowsmilies = true,allowbbcode = parseInt('{$_G[group][allowsigbbcode]}'),allowimgcode = parseInt('{$_G[group][allowsigimgcode]}');var DISCUZCODE = [];DISCUZCODE['num'] = '-1';DISCUZCODE['html'] = [];</script>
                                <script type="text/javascript" src="{$_G[setting][jspath]}bbcode.js?{VERHASH}"></script>
                                <script type="text/javascript">
                                    var msgListObj = $('msglist');
                                    msgListObj.scrollTop = msgListObj.scrollHeight;
                                    function succeedhandle_pmsend(url, msg, values) {
                                        var pObj = document.createElement("p");
                                        pObj.className = 'xg1 mbn';
                                        pObj.innerHTML = '<a href="home.php?mod=space&uid=$_G[uid]" target="_blank" class="xi2">$_G[username]</a> &nbsp;'+ "{lang just_now}";
                                        var pObjmsg = document.createElement("p");
                                        pObjmsg.className = 'mbm';
                                        var pmMsg = $('replymessage');
                                        pObjmsg.innerHTML = bbcode2html(parseurl(pmMsg.value));
                                        msgListObj.appendChild(pObj);
                                        msgListObj.appendChild(pObjmsg);
                                        msgListObj.scrollTop = msgListObj.scrollHeight;
                                        pmMsg.value = "";
                                        showCreditPrompt();
                                    }
    
                                    function refreshMsg(refreshnow) {
                                        if(refresh) {
                                            if(autorefresh <= 0 || refreshnow){
                                                var x = new Ajax();
                                                x.get('home.php?mod=spacecp&ac=pm&op=showchatmsg&inajax=1&daterange=$daterange&plid=$plid', function(s){
                                                    msgListObj.innerHTML = s;
                                                    msgListObj.scrollTop = msgListObj.scrollHeight;
    
                                                });
                                                autorefresh = {$refreshtime};
                                            }
                                            <!--{if $refreshtime}-->
                                            $('refreshtip').innerHTML = autorefresh + ' {lang next_refresh}';
                                            <!--{/if}-->
                                            autorefresh -= 2;
                                        } else {
                                            window.clearInterval(refreshHandle);
                                        }
                                    }
                                    <!--{if $refreshtime}-->
                                    refreshHandle = window.setInterval('refreshMsg(0);', 2000);
                                    <!--{/if}-->
                                    hideMenu();
                                </script>
                            <!--/div/div-->
                    <!--{elseif $list && !$daterange}-->
                        
                    <!--{elseif $chatpmmemberlist}-->
                        <!--{if $authorid == $_G['uid']}-->
                            <div class="tbmu mtn tfm pmform cl">
                                <script type="text/javascript" src="{$_G[setting][jspath]}home_friendselector.js?{VERHASH}"></script>
                                <script type="text/javascript">
                                    var fs;
                                    var clearlist = 0;
                                </script>
                                <div class="cl">
                                    <div class="un_selector px z cl" onclick="$('username').focus();">
                                        <input type="text" name="username" id="username" autocomplete="off" />
                                    </div>
                                    <a href="home.php?mod=spacecp&ac=pm&op=appendmember&plid=$plid" id="a_appendmember" class="pn appendmb z" title="{lang appendchatpmmember_comment}" onclick="getchatpmappendmember();"><span class="z">{lang appendchatpmmember}</span></a>
                                    <a href="javascript:;" id="showSelectBox" class="z mtn showmenu" onclick="showMenu({'showid':this.id, 'duration':3, 'pos':'34!'});fs.showPMFriend('showSelectBox_menu','selectorBox', this);" title="{lang selectfromfriendlist}">{lang select_friend}</a>
                                </div>
                                <p class="d">{lang sendpm_tip}</p>
                            </div>
                            <div id="username_menu" style="display: none;">
                                <ul id="friends" class="pmfrndl"></ul>
                            </div>
                            <div class="p_pof" id="showSelectBox_menu" unselectable="on" style="display:none;">
                                <div class="pbm">
                                    <select class="ps" onchange="clearlist=1;getUser(1, this.value)">
                                        <option value="-1">{lang invite_all_friend}</option>
                                        <!--{loop $friendgrouplist $groupid $group}-->
                                            <option value="$groupid">$group</option>
                                        <!--{/loop}-->
                                    </select>
                                </div>
                                <div id="selBox" class="ptn pbn">
                                    <ul id="selectorBox" class="xl xl2 cl"></ul>
                                </div>
                                <div class="cl">
                                    <button type="button" class="y pn" onclick="fs.showPMFriend('showSelectBox_menu','selectorBox', $('showSelectBox'));doane(event)"><span>{lang close}</span></button>
                                </div>
                            </div>
    
                            <script type="text/javascript">
    
                                var page = 1;
                                var gid = -1;
                                var showNum = 0;
                                var haveFriend = true;
                                function getUser(pageId, gid) {
                                    page = parseInt(pageId);
                                    gid = isUndefined(gid) ? -1 : parseInt(gid);
                                    var x = new Ajax();
                                    x.get('home.php?mod=spacecp&ac=friend&op=getinviteuser&inajax=1&page='+ page + '&gid=' + gid + '&' + Math.random(), function(s) {
                                        var data = eval('('+s+')');
                                        var singlenum = parseInt(data['singlenum']);
                                        var maxfriendnum = parseInt(data['maxfriendnum']);
                                        fs.addDataSource(data, clearlist);
                                        haveFriend = singlenum && singlenum == 20 ? true : false;
                                        if(singlenum && fs.allNumber < 20 && fs.allNumber < maxfriendnum && maxfriendnum > 20 && haveFriend) {
                                            page++;
                                            getUser(page);
                                        }
                                    });
                                }
                                function selector() {
                                    var parameter = {'searchId':'username', 'showId':'friends', 'formId':'', 'showType':3, 'handleKey':'fs', 'selBox':'selectorBox', 'selBoxMenu':'showSelectBox_menu', 'maxSelectNumber':'20', 'selectTabId':'selectNum', 'unSelectTabId':'unSelectTab', 'maxSelectTabId':'remainNum'};
                                    fs = new friendSelector(parameter);
                                    var listObj = $('selBox');
                                    listObj.onscroll = function() {
                                        clearlist = 0;
                                        if(this.scrollTop >= this.scrollHeight/5) {
                                            page++;
                                            gid = isUndefined(gid) ? 0 : parseInt(gid);
                                            if(haveFriend) {
                                                getUser(page, gid);
                                            }
                                        }
                                    }
                                    getUser(page);
                                }
                                selector();
                            </script>
    
                        <!--{/if}-->
                        <ul class="buddy cl">
                            <li>
                                <div class="avt"><a href="home.php?mod=space&uid=$authorid" title="$chatpmmemberlist[$authorid][username]" target="_blank" c="1"><em class="gm"></em><!--{avatar($authorid,small)}--></a></div>
                                <h4><a href="home.php?mod=space&uid=$authorid" title="$chatpmmemberlist[$authorid][username]">$chatpmmemberlist[$authorid][username]</a></h4>
                                <p class="maxh">$chatpmmemberlist[$authorid][recentnote]</p>
                            </li>
                        <!--{eval unset($chatpmmemberlist[$authorid]);}-->
                        <!--{loop $chatpmmemberlist $key $value}-->
                            <li>
                                <div class="avt"><a href="home.php?mod=space&uid=$value[uid]" title="$value[username]" target="_blank" c="1"><!--{avatar($value[uid],small)}--></a></div>
                                <h4><a href="home.php?mod=space&uid=$value[uid]" title="$value[username]">$value[username]</a></h4>
                                <p class="maxh">$value[recentnote]</p>
                                <!--{if $authorid == $_G['uid']}-->
                                    <p class="xg1"><a href="home.php?mod=spacecp&ac=pm&op=kickmember&memberuid=$key&plid=$plid" id="a_kickmmeber_$key" title="{lang kickmemberwho}" onclick="showWindow(this.id, this.href, 'get', 0);">{lang kickmember}</a></p>
                                <!--{/if}-->
                            </li>
                        <!--{/loop}-->
                        </ul>
                    <!--{else}-->
                        <div class="emp"><i class="iconfont icon-meiyougengduole"></i><p>{lang no_corresponding_pm}</p></div>
                    <!--{/if}-->
    
                    
                    <!--{if $list && $daterange && !$touid}-->
                            </div>
                        </div>
                    <!--{/if}-->
    
                
                <!--{else}-->
    
                    <!--{if $count || $grouppms}-->
                        <form id="deletepmform" action="home.php?mod=spacecp&ac=pm&op=delete&folder=$folder" method="post" autocomplete="off" name="deletepmform">
                            <div class="pmul cl">
                                <!--{if $grouppms}-->
                                <ul>
                                    <!--{loop $grouppms $grouppm}-->
                                        <li id="gpmlist_$grouppm[id]" {if !$gpmstatus[$grouppm[id]]}class="newpm"{/if}>
                                        	<div class="avatar_img">
                                                <!--{if $grouppm[author]}-->
                                                    <img src="static/images/common/annpm.png" alt="" />
                                                <!--{else}-->
                                                    <img src="static/images/common/systempm.png" alt="" />
                                                <!--{/if}-->
                                                <span class="o">
                                                    <input type="checkbox" name="deletepm_gpmid[]" id="a_deleteg_$grouppm[id]" class="pc" value="$grouppm[id]" />
                                                </span>
                                            </div>
                                            <a href="home.php?mod=space&do=pm&subop=viewg&pmid=$grouppm[id]" id="gpmlist_$grouppm[id]_a">
                                            <!--{if $grouppm[author]}-->
                                            	<div class="atit cl">
                                                	{if !$gpmstatus[$grouppm[id]]}<span class="new">New</span>{/if}
                                                	<span>$grouppm[author] {lang say}:</span>
                                                </div>
                                             <!--{/if}-->
                                             	<div class="asec cl">
                                                	<p class="atime"><!--{date($grouppm[dateline], 'u')}--></p>
                                                <p class="axx" id="p_gpmid_$grouppm[id]">$grouppm[message]</p>
                                            	</div>
                                            </a>
                                        </li>
                                    <!--{/loop}-->
                                </ul>
                                <!--{/if}-->
                                <!--{if $multi}-->$multi<!--{/if}-->
                            </div>
                            
                            <!--{if $count || $grouppms}-->
                            <div class="pm_bot cl">
                              
                                <button type="submit" name="deletepmsubmit_btn" value="true">{lang delete}</button>

                            </div>
                            <!--{/if}-->
                            </div>
                            <input type="hidden" name='deletesubmit' value="true" />
                            <input type="hidden" name="formhash" value="{FORMHASH}" />
                        </form>
                    <!--{else}-->
                        <div class="emp"><i class="iconfont icon-meiyougengduole"></i><p>{lang no_corresponding_pm}</p></div>
                    <!--{/if}-->
    
                <!--{/if}-->
    
            </div>
        </div>
<!--{elseif $_GET['subop'] == 'viewg'}-->
	<!-- header start -->
	<header class="header">
	    <div class="nav">
	        <a href="javascript:;" onclick="history.go(-1)" class="z"><i class="iconfont icon-back"></i></a>
			<span class="name">{lang viewmypm}</span>
            
	    </div>
	</header>
    <!--{template common/top_fix}-->
	<!-- header end -->
                    <!--{if $grouppm}-->
                        <div id="pm_ul" class="aggxx cl">
                        	<div class="dashedtip"><!--{if $grouppm['author']}-->{lang sendmultipmwho}<!--{else}-->{lang sendmultipmsystem}<!--{/if}--> <span class="y"><!--{date($grouppm[dateline], 'u')}--></span></div>
                            <div class="acon cl">
                                <div class="cl">
                                    <div class="amsg cl">$grouppm[message]</div>
                                    
                                </div>
                                
                            </div>
                            <!--{if $grouppm[author]}-->
                                <p class="hfat cl">
                                    <a href="home.php?mod=spacecp&ac=pm&touid=$grouppm[authorid]">{lang reply} $grouppm[author]</a>
                                </p>
                            <!--{/if}-->
                        </div>
                    <!--{else}-->
                        <div class="emp"><i class="iconfont icon-meiyougengduole"></i><p>{lang no_corresponding_pm}</p></div>
                    <!--{/if}-->
    
                <!--{elseif $_GET['subop'] == 'setting'}-->
                    <!-- header start -->
                    <header class="header">
                        <div class="nav">
                        	<a href="home.php?mod=spacecp&ac=pm" class="y"><i class="iconfont icon-quillpenblack"></i></a>
                            <a href="#" class="z back"><i class="iconfont icon-back"></i></a>
                            <span class="name">{lang pm_setting}</span>
                            
                        </div>
                    </header>
                    <!--{template common/top_fix}-->
                    <!-- header end -->
                    <div class="ainuo_usertb cl">
                        <ul class="tb apm cl">
                            <li$actives[privatepm] $actives[newpm]><a href="home.php?mod=space&do=pm&filter=privatepm">{lang private_pm}</a></li>
                            <li$actives[announcepm]><a href="home.php?mod=space&do=pm&filter=announcepm">{lang announce_pm}</a></li>
                            <li class="a"><a href="home.php?mod=space&do=pm&subop=setting">{lang pm_setting}</a></li>
                        </ul>
                    </div>
                    <div class="grey_line cl"></div>
                    <div class="ainuodxx cl">
                    <form id="pmsettingform" name="pmsettingform" method="post" autocomplete="off" action="home.php?mod=spacecp&ac=pm&op=setting">
                        <table cellspacing="0" cellpadding="0" width="100%">
                            <tr>
                                <td>
                                	<p>{lang pm_onlyacceptfriendpm}</p>
                                    <label class="lb"><input type="radio" name="onlyacceptfriendpm" class="pr" value="1"{if $acceptfriendpmstatus == 1} checked="checked"{/if} />{lang yes}</label>
                                    <label class="lb"><input type="radio" name="onlyacceptfriendpm" class="pr" value="2"{if $acceptfriendpmstatus == 2} checked="checked"{/if} />{lang no}</label>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                	<p class="iglst">{lang ignore_list}</p>
                                    <textarea id="ignorelist" name="ignorelist" rows="3" class="px" onkeydown="ctrlEnter(event, 'ignoresubmit');">$ignorelist</textarea>
                                    <div class="dashedtip">{lang ignore_member_pm_message}</div>
                                </td>
                            </tr>
                            <tr>
                                <td><button type="submit" name="settingsubmit" value="true">{lang save}</button></td>
                            </tr>
                        </table>
                        <input type="hidden" name="formhash" value="{FORMHASH}" />
                    </form>  
                    </div>      
<!--{elseif in_array($filter, array('newpm'))}-->
<header class="header">
        <div class="nav">
            <a href="home.php?mod=spacecp&ac=pm" class="y"><i class="iconfont icon-quillpenblack"></i></a>
            <a href="#" class="z back"><i class="iconfont icon-back"></i></a>
            <span class="name">{lang announce_pm}</span>
        </div>
    </header>
    <!--{template common/top_fix}-->
<div class="ainuo_pmbox cl">
        <div class="cl">
            <div class="ainuo_usertb cl">
                <ul class="tb apm cl">
                    <li$actives[privatepm] $actives[newpm]><a href="home.php?mod=space&do=pm&filter=privatepm">{lang private_pm}</a></li>
                    <li$actives[announcepm]><a href="home.php?mod=space&do=pm&filter=announcepm">{lang announce_pm}</a></li>
                    <li><a href="home.php?mod=space&do=pm&subop=setting" class="xi2">{lang pm_setting}</a></li>
                </ul>
            </div>
            <div class="grey_line cl"></div>
            <!--{if ($filter == 'privatepm' && $newpm) || $filter == 'newpm'}-->
            <div class="dashedtip cl">
                <!--{if $filter != 'newpm'}-->
                    <a href="home.php?mod=space&do=pm&filter=newpm" class="xi2">{lang view_newpm}</a>
                <!--{else}-->
                    <a href="home.php?mod=space&do=pm&filter=privatepm" class="xi2">{lang view_privatepm}</a>
                <!--{/if}-->
            </div>
            <!--{/if}-->
            <div class="cl">
    
                <!--{if $_GET['subop'] == 'view'}-->
    
                    <!--{if $list && $daterange && !$touid}-->
                        <!--{if empty($lastanchor)}--><a name="last"></a><!--{eval $lastanchor=1;}--><!--{/if}-->
                        <div class="pm_g cl">
                            <h2 class="mbm xs2"><span class="xi1">$membernum</span> {lang pm_members_message} : <span class="xi2">$subject</span></h2>
                            <div class="pm_sd">
                                <ul class="pm_mem_l{if $authorid == $_G['uid']} pm_admin{/if}">
                                <!--{loop $chatpmmemberlist $key $value}-->
                                    <li><a href="home.php?mod=space&uid=$value[uid]" target="_blank" {if $ols[$value[uid]]} class="xi2" title="{lang online}"{else} class="xg1"{/if}>$value[username]</a></li>
                                <!--{/loop}-->
                                </ul>
                                <!--{if $authorid == $_G['uid']}-->
                                    <div class="pm_add cl">
                                        <input type="text" name="username" id="username" class="px z" value="" />
                                        <span class="z">&nbsp;</span>
                                        <a href="home.php?mod=spacecp&ac=pm&op=appendmember&plid=$plid" id="a_appendmember" class="pn z" title="{lang appendchatpmmember_comment}" onclick="getchatpmappendmember();"><span>+</span></a>
                                    </div>
                                <!--{/if}-->
                            </div>
                            <div class="pm_mn">
                                <div id="msglist" class="pm_b">
                                <!--{loop $list $key $value}-->
                                    <p class="xg1 mbn"><a href="home.php?mod=space&uid=$value[authorid]" target="_blank" class="xi2">$value[author]</a> &nbsp; <!--{date($value[dateline], 'u')}--></p>
                                    <p class="mbm">$value[message]</p>
                                <!--{/loop}-->
                                </div>
                                <script type="text/javascript">
                                var refresh = true;
                                var refreshHandle = -1;
                                var autorefresh = {$refreshtime};
                                </script>
                                <script type="text/javascript">var forumallowhtml = 0,allowhtml = 0,allowsmilies = true,allowbbcode = parseInt('{$_G[group][allowsigbbcode]}'),allowimgcode = parseInt('{$_G[group][allowsigimgcode]}');var DISCUZCODE = [];DISCUZCODE['num'] = '-1';DISCUZCODE['html'] = [];</script>
                                <script type="text/javascript" src="{$_G[setting][jspath]}bbcode.js?{VERHASH}"></script>
                                <script type="text/javascript">
                                    var msgListObj = $('msglist');
                                    msgListObj.scrollTop = msgListObj.scrollHeight;
                                    function succeedhandle_pmsend(url, msg, values) {
                                        var pObj = document.createElement("p");
                                        pObj.className = 'xg1 mbn';
                                        pObj.innerHTML = '<a href="home.php?mod=space&uid=$_G[uid]" target="_blank" class="xi2">$_G[username]</a> &nbsp;'+ "{lang just_now}";
                                        var pObjmsg = document.createElement("p");
                                        pObjmsg.className = 'mbm';
                                        var pmMsg = $('replymessage');
                                        pObjmsg.innerHTML = bbcode2html(parseurl(pmMsg.value));
                                        msgListObj.appendChild(pObj);
                                        msgListObj.appendChild(pObjmsg);
                                        msgListObj.scrollTop = msgListObj.scrollHeight;
                                        pmMsg.value = "";
                                        showCreditPrompt();
                                    }
    
                                    function refreshMsg(refreshnow) {
                                        if(refresh) {
                                            if(autorefresh <= 0 || refreshnow){
                                                var x = new Ajax();
                                                x.get('home.php?mod=spacecp&ac=pm&op=showchatmsg&inajax=1&daterange=$daterange&plid=$plid', function(s){
                                                    msgListObj.innerHTML = s;
                                                    msgListObj.scrollTop = msgListObj.scrollHeight;
    
                                                });
                                                autorefresh = {$refreshtime};
                                            }
                                            <!--{if $refreshtime}-->
                                            $('refreshtip').innerHTML = autorefresh + ' {lang next_refresh}';
                                            <!--{/if}-->
                                            autorefresh -= 2;
                                        } else {
                                            window.clearInterval(refreshHandle);
                                        }
                                    }
                                    <!--{if $refreshtime}-->
                                    refreshHandle = window.setInterval('refreshMsg(0);', 2000);
                                    <!--{/if}-->
                                    hideMenu();
                                </script>
                            <!--/div/div-->
                    <!--{elseif $list && !$daterange}-->
                        
                    <!--{elseif $chatpmmemberlist}-->
                        <!--{if $authorid == $_G['uid']}-->
                            <div class="tbmu mtn tfm pmform cl">
                                <script type="text/javascript" src="{$_G[setting][jspath]}home_friendselector.js?{VERHASH}"></script>
                                <script type="text/javascript">
                                    var fs;
                                    var clearlist = 0;
                                </script>
                                <div class="cl">
                                    <div class="un_selector px z cl" onclick="$('username').focus();">
                                        <input type="text" name="username" id="username" autocomplete="off" />
                                    </div>
                                    <a href="home.php?mod=spacecp&ac=pm&op=appendmember&plid=$plid" id="a_appendmember" class="pn appendmb z" title="{lang appendchatpmmember_comment}" onclick="getchatpmappendmember();"><span class="z">{lang appendchatpmmember}</span></a>
                                    <a href="javascript:;" id="showSelectBox" class="z mtn showmenu" onclick="showMenu({'showid':this.id, 'duration':3, 'pos':'34!'});fs.showPMFriend('showSelectBox_menu','selectorBox', this);" title="{lang selectfromfriendlist}">{lang select_friend}</a>
                                </div>
                                <p class="d">{lang sendpm_tip}</p>
                            </div>
                            <div id="username_menu" style="display: none;">
                                <ul id="friends" class="pmfrndl"></ul>
                            </div>
                            <div class="p_pof" id="showSelectBox_menu" unselectable="on" style="display:none;">
                                <div class="pbm">
                                    <select class="ps" onchange="clearlist=1;getUser(1, this.value)">
                                        <option value="-1">{lang invite_all_friend}</option>
                                        <!--{loop $friendgrouplist $groupid $group}-->
                                            <option value="$groupid">$group</option>
                                        <!--{/loop}-->
                                    </select>
                                </div>
                                <div id="selBox" class="ptn pbn">
                                    <ul id="selectorBox" class="xl xl2 cl"></ul>
                                </div>
                                <div class="cl">
                                    <button type="button" class="y pn" onclick="fs.showPMFriend('showSelectBox_menu','selectorBox', $('showSelectBox'));doane(event)"><span>{lang close}</span></button>
                                </div>
                            </div>
    
                            <script type="text/javascript">
    
                                var page = 1;
                                var gid = -1;
                                var showNum = 0;
                                var haveFriend = true;
                                function getUser(pageId, gid) {
                                    page = parseInt(pageId);
                                    gid = isUndefined(gid) ? -1 : parseInt(gid);
                                    var x = new Ajax();
                                    x.get('home.php?mod=spacecp&ac=friend&op=getinviteuser&inajax=1&page='+ page + '&gid=' + gid + '&' + Math.random(), function(s) {
                                        var data = eval('('+s+')');
                                        var singlenum = parseInt(data['singlenum']);
                                        var maxfriendnum = parseInt(data['maxfriendnum']);
                                        fs.addDataSource(data, clearlist);
                                        haveFriend = singlenum && singlenum == 20 ? true : false;
                                        if(singlenum && fs.allNumber < 20 && fs.allNumber < maxfriendnum && maxfriendnum > 20 && haveFriend) {
                                            page++;
                                            getUser(page);
                                        }
                                    });
                                }
                                function selector() {
                                    var parameter = {'searchId':'username', 'showId':'friends', 'formId':'', 'showType':3, 'handleKey':'fs', 'selBox':'selectorBox', 'selBoxMenu':'showSelectBox_menu', 'maxSelectNumber':'20', 'selectTabId':'selectNum', 'unSelectTabId':'unSelectTab', 'maxSelectTabId':'remainNum'};
                                    fs = new friendSelector(parameter);
                                    var listObj = $('selBox');
                                    listObj.onscroll = function() {
                                        clearlist = 0;
                                        if(this.scrollTop >= this.scrollHeight/5) {
                                            page++;
                                            gid = isUndefined(gid) ? 0 : parseInt(gid);
                                            if(haveFriend) {
                                                getUser(page, gid);
                                            }
                                        }
                                    }
                                    getUser(page);
                                }
                                selector();
                            </script>
    
                        <!--{/if}-->
                        <ul class="buddy cl">
                            <li>
                                <div class="avt"><a href="home.php?mod=space&uid=$authorid" title="$chatpmmemberlist[$authorid][username]" target="_blank" c="1"><em class="gm"></em><!--{avatar($authorid,small)}--></a></div>
                                <h4><a href="home.php?mod=space&uid=$authorid" title="$chatpmmemberlist[$authorid][username]">$chatpmmemberlist[$authorid][username]</a></h4>
                                <p class="maxh">$chatpmmemberlist[$authorid][recentnote]</p>
                            </li>
                        <!--{eval unset($chatpmmemberlist[$authorid]);}-->
                        <!--{loop $chatpmmemberlist $key $value}-->
                            <li>
                                <div class="avt"><a href="home.php?mod=space&uid=$value[uid]" title="$value[username]" target="_blank" c="1"><!--{avatar($value[uid],small)}--></a></div>
                                <h4><a href="home.php?mod=space&uid=$value[uid]" title="$value[username]">$value[username]</a></h4>
                                <p class="maxh">$value[recentnote]</p>
                                <!--{if $authorid == $_G['uid']}-->
                                    <p class="xg1"><a href="home.php?mod=spacecp&ac=pm&op=kickmember&memberuid=$key&plid=$plid" id="a_kickmmeber_$key" title="{lang kickmemberwho}" onclick="showWindow(this.id, this.href, 'get', 0);">{lang kickmember}</a></p>
                                <!--{/if}-->
                            </li>
                        <!--{/loop}-->
                        </ul>
                    <!--{else}-->
                        <div class="emp"><i class="iconfont icon-meiyougengduole"></i><p>{lang no_corresponding_pm}</p></div>
                    <!--{/if}-->
    
                    
                    <!--{if $list && $daterange && !$touid}-->
                            </div>
                        </div>
                    <!--{/if}-->
    
                
    
                <!--{else}-->
    
                    <!--{if $count || $grouppms}-->
                        <form id="deletepmform" action="home.php?mod=spacecp&ac=pm&op=delete&folder=$folder" method="post" autocomplete="off" name="deletepmform">
                            <div class="pmul cl">
                                <!--{if $grouppms}-->
                                <ul>
                                    <!--{loop $grouppms $grouppm}-->
                                        <li id="gpmlist_$grouppm[id]" {if !$gpmstatus[$grouppm[id]]}class="newpm"{/if}>
                                        	<div class="avatar_img">
                                                <!--{if $grouppm[author]}-->
                                                    <img src="static/images/common/annpm.png" alt="" />
                                                <!--{else}-->
                                                    <img src="static/images/common/systempm.png" alt="" />
                                                <!--{/if}-->
                                                <span class="o">
                                                    <input type="checkbox" name="deletepm_gpmid[]" id="a_deleteg_$grouppm[id]" class="pc" value="$grouppm[id]" />
                                                </span>
                                            </div>
                                            <a href="home.php?mod=space&do=pm&subop=viewg&pmid=$grouppm[id]" id="gpmlist_$grouppm[id]_a">
                                            <!--{if $grouppm[author]}-->
                                            	<div class="atit cl">
                                                	{if !$gpmstatus[$grouppm[id]]}<span class="new">New</span>{/if}
                                                	<span>$grouppm[author] {lang say}:</span>
                                                </div>
                                             <!--{/if}-->
                                             	<div class="asec cl">
                                                	<p class="atime"><!--{date($grouppm[dateline], 'u')}--></p>
                                                <p class="axx" id="p_gpmid_$grouppm[id]">$grouppm[message]</p>
                                            	</div>
                                            </a>
                                        </li>
                                    <!--{/loop}-->
                                </ul>
                                <!--{/if}-->
                                <ul>
                                <!--{loop $list $key $value}-->
                                    <li id="gpmlist_$grouppm[id]" {if $value[new]}class="newpm"{/if}>
                                        <div class="avatar_img">
                                            <img style="height:40px;width:40px;" src="<!--{if $value[pmtype] == 2}-->{STATICURL}image/common/grouppm.png<!--{else}--><!--{avatar($value[touid] ? $value[touid] : ($value[lastauthorid] ? $value[lastauthorid] : $value[authorid]), middle, true)}--><!--{/if}-->" />
                                                <span class="o">
                                                    <!--{if $value['pmtype'] == 1}-->
                                                        <input type="checkbox" name="deletepm_deluid[]" id="a_delete_$value[plid]" class="pc" value="$value[touid]" />
                                                    <!--{elseif $value['pmtype'] == 2}-->
                                                        <!--{if $value['authorid'] == $_G['uid']}-->
                                                        <input type="checkbox" name="deletepm_delplid[]" id="a_delete_$value[plid]" class="pc" value="$value[plid]" />
                                                        <!--{else}-->
                                                        <input type="checkbox" name="deletepm_quitplid[]" id="a_delete_$value[plid]" class="pc" value="$value[plid]" />
                                                        <!--{/if}-->
                                                    <!--{/if}-->
                                                </span>    
                                        </div>
                                        <a href="home.php?mod=space&do=pm&subop=view&touid=$value[touid]">
                                            <div class="atit cl">
                                                <!--{if $value[new]}--><span class="new">$value[pmnum]</span><!--{else}--><span class="old">$value[pmnum]</span><!--{/if}-->
                                                <!--{if $value[touid]}-->
                                                    <!--{if $value[msgfromid] == $_G[uid]}-->
                                                        <span>{lang me}{lang you_to} {$value[tousername]}{lang say}:</span>
                                                    <!--{else}-->
                                                        <span>{$value[tousername]} {lang you_to}{lang me}{lang say}:</span>
                                                    <!--{/if}-->
                                                <!--{elseif $value['pmtype'] == 2}-->
                                                    <span>{lang chatpm_author}:$value['firstauthor']</span>
                                                <!--{/if}-->
                                                <!--{if $value[isnew]}--><em>$alang_newmessage</em><!--{/if}-->
                                            </div>
                                            <div class="asec cl">
                                                <p class="atime">
                                                <!--{date($value[dateline], 'u')}-->
                                                </p>
                                                <p class="axx"><!--{if $value['pmtype'] == 2}-->[{lang chatpm}]<!--{if $value[subject]}-->$value[subject]<br><!--{/if}--><!--{/if}--><!--{if $value['pmtype'] == 2 && $value['lastauthor']}--><div style="padding:0 0 0 10px;">......<br>$value['lastauthor'] : $value[message]</div><!--{else}-->$value[message]<!--{/if}--></p>
                                            </div>
                                        </a>
                                    </li>
                                 
                                <!--{/loop}-->
                                </ul>
                                <!--{if $multi}-->$multi<!--{/if}-->
                            </div>
                            
                            <!--{if $count || $grouppms}-->
                            <div class="pm_bot cl">
                              
                                <button type="submit" name="deletepmsubmit_btn" value="true">{lang delete}</button>
                            </div>
                            <!--{/if}-->
                            </div>
                            <input type="hidden" name='deletesubmit' value="true" />
                            <input type="hidden" name="formhash" value="{FORMHASH}" />
                        </form>

                    <!--{else}-->
                        <div class="emp"><i class="iconfont icon-meiyougengduole"></i><p>{lang no_corresponding_pm}</p></div>
                    <!--{/if}-->
    
                <!--{/if}-->
    
            </div>
        </div>
<!--{/if}--> 
<script type="text/javascript">var forumallowhtml = 0,allowhtml = 0,allowsmilies = true,allowbbcode = parseInt('{$_G[group][allowsigbbcode]}'),allowimgcode = parseInt('{$_G[group][allowsigimgcode]}');var DISCUZCODE = [];DISCUZCODE['num'] = '-1';DISCUZCODE['html'] = [];var EXTRAFUNC = [];</script>
<script>
function parseurl(str, mode, parsecode) {
	if(isUndefined(parsecode)) parsecode = true;
	if(parsecode) str= str.replace(/\[code\]([\s\S]+?)\[\/code\]/ig, function($1, $2) {return codetag($2, -1);});
	str = str.replace(/([^>=\]"'\/]|^)((((https?|ftp):\/\/)|www\.)([\w\-]+\.)*[\w\-\u4e00-\u9fa5]+\.([\.a-zA-Z0-9]+|\u4E2D\u56FD|\u7F51\u7EDC|\u516C\u53F8)((\?|\/|:)+[\w\.\/=\?%\-&~`@':+!]*)+\.(swf|flv))/ig, '$1[flash]$2[/flash]');
	str = str.replace(/([^>=\]"'\/]|^)((((https?|ftp):\/\/)|www\.)([\w\-]+\.)*[\w\-\u4e00-\u9fa5]+\.([\.a-zA-Z0-9]+|\u4E2D\u56FD|\u7F51\u7EDC|\u516C\u53F8)((\?|\/|:)+[\w\.\/=\?%\-&~`@':+!]*)+\.(mp3|wma))/ig, '$1[audio]$2[/audio]');
	str = str.replace(/([^>=\]"'\/@]|^)((((https?|ftp|gopher|news|telnet|rtsp|mms|callto|bctp|ed2k|thunder|qqdl|synacast):\/\/))([\w\-]+\.)*[:\.@\-\w\u4e00-\u9fa5]+\.([\.a-zA-Z0-9]+|\u4E2D\u56FD|\u7F51\u7EDC|\u516C\u53F8)((\?|\/|:)+[\w\.\/=\?%\-&;~`@':+!#]*)*)/ig, mode == 'html' ? '$1<a href="$2" target="_blank">$2</a>' : '$1[url]$2[/url]');
	str = str.replace(/([^\w>=\]"'\/@]|^)((www\.)([\w\-]+\.)*[:\.@\-\w\u4e00-\u9fa5]+\.([\.a-zA-Z0-9]+|\u4E2D\u56FD|\u7F51\u7EDC|\u516C\u53F8)((\?|\/|:)+[\w\.\/=\?%\-&;~`@':+!#]*)*)/ig, mode == 'html' ? '$1<a href="$2" target="_blank">$2</a>' : '$1[url]$2[/url]');
	str = str.replace(/([^\w->=\]:"'\.\/]|^)(([\-\.\w]+@[\.\-\w]+(\.\w+)+))/ig, mode == 'html' ? '$1<a href="mailto:$2">$2</a>' : '$1[email]$2[/email]');
	if(parsecode) {
		for(var i = 0; i <= DISCUZCODE['num']; i++) {
			str = str.replace("[\tDISCUZ_CODE_" + i + "\t]", DISCUZCODE['html'][i]);
		}
	}
	return str;
}
function preg_replace(search, replace, str, regswitch) {
	var regswitch = !regswitch ? 'ig' : regswitch;
	var len = search.length;
	for(var i = 0; i < len; i++) {
		re = new RegExp(search[i], regswitch);
		str = str.replace(re, typeof replace == 'string' ? replace : (replace[i] ? replace[i] : replace[0]));
	}
	return str;
}	
var re, DISCUZCODE = [];
DISCUZCODE['num'] = '-1';
DISCUZCODE['html'] = [];
EXTRAFUNC['bbcode2html'] = [];
EXTRAFUNC['html2bbcode'] = [];
function addslashes(str) {
	return preg_replace(['\\\\', '\\\'', '\\\/', '\\\(', '\\\)', '\\\[', '\\\]', '\\\{', '\\\}', '\\\^', '\\\$', '\\\?', '\\\.', '\\\*', '\\\+', '\\\|'], ['\\\\', '\\\'', '\\/', '\\(', '\\)', '\\[', '\\]', '\\{', '\\}', '\\^', '\\$', '\\?', '\\.', '\\*', '\\+', '\\|'], str);
}
function atag(aoptions, text) {
	if(trim(text) == '') {
		return '';
	}
	var pend = parsestyle(aoptions, '', '');
	href = getoptionvalue('href', aoptions);
	if(href.substr(0, 11) == 'javascript:') {
		return trim(recursion('a', text, 'atag'));
	}
	return pend['prepend'] + '[url=' + href + ']' + trim(recursion('a', text, 'atag')) + '[/url]' + pend['append'];
}
function bbcode2html(str) {
	if(str == '') {
		return '';
	}
	if(typeof(parsetype) == 'undefined') {
		parsetype = 0;
	}
	if(!fetchCheckbox('bbcodeoff') && allowbbcode && parsetype != 1) {
		str = str.replace(/\[code\]([\s\S]+?)\[\/code\]/ig, function($1, $2) {return parsecode($2);});
	}
	if(fetchCheckbox('allowimgurl')) {
		str = str.replace(/([^>=\]"'\/]|^)((((https?|ftp):\/\/)|www\.)([\w\-]+\.)*[\w\-\u4e00-\u9fa5]+\.([\.a-zA-Z0-9]+|\u4E2D\u56FD|\u7F51\u7EDC|\u516C\u53F8)((\?|\/|:)+[\w\.\/=\?%\-&~`@':+!]*)+\.(jpg|gif|png|bmp))/ig, '$1[img]$2[/img]');
	}
	if(!allowhtml || !fetchCheckbox('htmlon')) {
		str = str.replace(/</g, '&lt;');
		str = str.replace(/>/g, '&gt;');
		if(!fetchCheckbox('parseurloff')) {
			str = parseurl(str, 'html', false);
		}
	}
	for(i in EXTRAFUNC['bbcode2html']) {
		EXTRASTR = str;
		try {
			eval('str = ' + EXTRAFUNC['bbcode2html'][i] + '()');
		} catch(e) {}
	}
	if(!fetchCheckbox('smileyoff') && allowsmilies) {
		if(typeof smilies_type == 'object') {
			for(var typeid in smilies_array) {
				for(var page in smilies_array[typeid]) {
					for(var i in smilies_array[typeid][page]) {
						re = new RegExp(preg_quote(smilies_array[typeid][page][i][1]), "g");
						str = str.replace(re, '<img twt="11111" src="' + STATICURL + 'image/smiley/' + smilies_type['_' + typeid][1] + '/' + smilies_array[typeid][page][i][2] + '" border="0" smilieid="' + smilies_array[typeid][page][i][0] + '" alt="' + smilies_array[typeid][page][i][1] + '" />');
					}
				}
			}
		}
	}
	if(!fetchCheckbox('bbcodeoff') && allowbbcode) {
		str = clearcode(str);
		str = str.replace(/\[url\]\s*((https?|ftp|gopher|news|telnet|rtsp|mms|callto|bctp|thunder|qqdl|synacast){1}:\/\/|www\.)([^\[\"']+?)\s*\[\/url\]/ig, function($1, $2, $3, $4) {return cuturl($2 + $4);});
		str = str.replace(/\[url=((https?|ftp|gopher|news|telnet|rtsp|mms|callto|bctp|thunder|qqdl|synacast){1}:\/\/|www\.|mailto:)?([^\r\n\[\"']+?)\]([\s\S]+?)\[\/url\]/ig, '<a href="$1$3" target="_blank">$4</a>');
		str = str.replace(/\[email\](.*?)\[\/email\]/ig, '<a href="mailto:$1">$1</a>');
		str = str.replace(/\[email=(.[^\\=[]*)\](.*?)\[\/email\]/ig, '<a href="mailto:$1" target="_blank">$2</a>');
		str = str.replace(/\[postbg\]\s*([^\[\<\r\n;'\"\?\(\)]+?)\s*\[\/postbg\]/ig, function($1, $2) {
			addCSS = '';
			if(in_array($2, postimg_type["postbg"])) {
				addCSS = '<style type="text/css" name="editorpostbg">body{background-image:url("'+STATICURL+'image/postbg/'+$2+'");}</style>';
			}
			return addCSS;
		});
		str = str.replace(/\[color=([\w#\(\),\s]+?)\]/ig, '<font color="$1">');
		str = str.replace(/\[backcolor=([\w#\(\),\s]+?)\]/ig, '<font style="background-color:$1">');
		str = str.replace(/\[size=(\d+?)\]/ig, '<font size="$1">');
		str = str.replace(/\[size=(\d+(\.\d+)?(px|pt)+?)\]/ig, '<font style="font-size: $1">');
		str = str.replace(/\[font=([^\[\<\=]+?)\]/ig, '<font face="$1">');
		str = str.replace(/\[align=([^\[\<\=]+?)\]/ig, '<div align="$1">');
		str = str.replace(/\[p=(\d{1,2}|null), (\d{1,2}|null), (left|center|right)\]/ig, '<p style="line-height: $1px; text-indent: $2em; text-align: $3;">');
		str = str.replace(/\[float=left\]/ig, '<br style="clear: both"><span style="float: left; margin-right: 5px;">');
		str = str.replace(/\[float=right\]/ig, '<br style="clear: both"><span style="float: right; margin-left: 5px;">');
		if(parsetype != 1) {
			str = str.replace(/\[quote]([\s\S]*?)\[\/quote\]\s?\s?/ig, '<div class="quote"><blockquote>$1</blockquote></div>\n');
		}
		re = /\[table(?:=(\d{1,4}%?)(?:,([\(\)%,#\w ]+))?)?\]\s*([\s\S]+?)\s*\[\/table\]/ig;
		for (i = 0; i < 4; i++) {
			str = str.replace(re, function($1, $2, $3, $4) {return parsetable($2, $3, $4);});
		}
		str = preg_replace([
			'\\\[\\\/color\\\]', '\\\[\\\/backcolor\\\]', '\\\[\\\/size\\\]', '\\\[\\\/font\\\]', '\\\[\\\/align\\\]', '\\\[\\\/p\\\]', '\\\[b\\\]', '\\\[\\\/b\\\]',
			'\\\[i\\\]', '\\\[\\\/i\\\]', '\\\[u\\\]', '\\\[\\\/u\\\]', '\\\[s\\\]', '\\\[\\\/s\\\]', '\\\[hr\\\]', '\\\[list\\\]', '\\\[list=1\\\]', '\\\[list=a\\\]',
			'\\\[list=A\\\]', '\\s?\\\[\\\*\\\]', '\\\[\\\/list\\\]', '\\\[indent\\\]', '\\\[\\\/indent\\\]', '\\\[\\\/float\\\]'
			], [
			'</font>', '</font>', '</font>', '</font>', '</div>', '</p>', '<b>', '</b>', '<i>',
			'</i>', '<u>', '</u>', '<strike>', '</strike>', '<hr class="l" />', '<ul>', '<ul type=1 class="litype_1">', '<ul type=a class="litype_2">',
			'<ul type=A class="litype_3">', '<li>', '</ul>', '<blockquote>', '</blockquote>', '</span>'
			], str, 'g');
	}
	if(!fetchCheckbox('bbcodeoff')) {
		if(allowimgcode) {
			str = str.replace(/\[img\]\s*([^\[\"\<\r\n]+?)\s*\[\/img\]/ig, '<img src="$1" border="0" alt="" style="max-width:400px" />');
			str = str.replace(/\[attachimg\](\d+)\[\/attachimg\]/ig, function ($1, $2) {
				if(!$('#image_' + $2)) {
					return '';
				}
				width = $('#image_' + $2).getAttribute('cwidth');
				if(!width) {
					re = /cwidth=(["']?)(\d+)(\1)/i;
					var matches = re.exec($('#image_' + $2).outerHTML);
					if(matches != null) {
						width = matches[2];
					}
				}
				return '<img src="' + $('#image_' + $2).src + '" border="0" aid="attachimg_' + $2 + '" width="' + width + '" alt="" />';
			});
			str = str.replace(/\[img=(\d{1,4})[x|\,](\d{1,4})\]\s*([^\[\"\<\r\n]+?)\s*\[\/img\]/ig, function ($1, $2, $3, $4) {return '<img' + ($2 > 0 ? ' width="' + $2 + '"' : '') + ($3 > 0 ? ' _height="' + $3 + '"' : '') + ' src="' + $4 + '" border="0" alt="" />'});
		} else {
			str = str.replace(/\[img\]\s*([^\[\"\<\r\n]+?)\s*\[\/img\]/ig, '<a href="$1" target="_blank">$1</a>');
			str = str.replace(/\[img=(\d{1,4})[x|\,](\d{1,4})\]\s*([^\[\"\<\r\n]+?)\s*\[\/img\]/ig, '<a href="$3" target="_blank">$3</a>');
		}
	}
	for(var i = 0; i <= DISCUZCODE['num']; i++) {
		str = str.replace("[\tDISCUZ_CODE_" + i + "\t]", DISCUZCODE['html'][i]);
	}
	if(!allowhtml || !fetchCheckbox('htmlon')) {
		str = str.replace(/(^|>)([^<]+)(?=<|$)/ig, function($1, $2, $3) {
			return $2 + preg_replace(['\t', '   ', '  ', '(\r\n|\n|\r)'], ['&nbsp; &nbsp; &nbsp; &nbsp; ', '&nbsp; &nbsp;', '&nbsp;&nbsp;', '<br />'], $3);
		});
	} else {
		str = str.replace(/<script[^\>]*?>([^\x00]*?)<\/script>/ig, '');
	}
	return str;
}
function clearcode(str) {
	str= str.replace(/\[url\]\[\/url\]/ig, '', str);
	str= str.replace(/\[url=((https?|ftp|gopher|news|telnet|rtsp|mms|callto|bctp|thunder|qqdl|synacast){1}:\/\/|www\.|mailto:)?([^\s\[\"']+?)\]\[\/url\]/ig, '', str);
	str= str.replace(/\[email\]\[\/email\]/ig, '', str);
	str= str.replace(/\[email=(.[^\[]*)\]\[\/email\]/ig, '', str);
	str= str.replace(/\[color=([^\[\<]+?)\]\[\/color\]/ig, '', str);
	str= str.replace(/\[size=(\d+?)\]\[\/size\]/ig, '', str);
	str= str.replace(/\[size=(\d+(\.\d+)?(px|pt)+?)\]\[\/size\]/ig, '', str);
	str= str.replace(/\[font=([^\[\<]+?)\]\[\/font\]/ig, '', str);
	str= str.replace(/\[align=([^\[\<]+?)\]\[\/align\]/ig, '', str);
	str= str.replace(/\[p=(\d{1,2}), (\d{1,2}), (left|center|right)\]\[\/p\]/ig, '', str);
	str= str.replace(/\[float=([^\[\<]+?)\]\[\/float\]/ig, '', str);
	str= str.replace(/\[quote\]\[\/quote\]/ig, '', str);
	str= str.replace(/\[code\]\[\/code\]/ig, '', str);
	str= str.replace(/\[table\]\[\/table\]/ig, '', str);
	str= str.replace(/\[free\]\[\/free\]/ig, '', str);
	str= str.replace(/\[b\]\[\/b]/ig, '', str);
	str= str.replace(/\[u\]\[\/u]/ig, '', str);
	str= str.replace(/\[i\]\[\/i]/ig, '', str);
	str= str.replace(/\[s\]\[\/s]/ig, '', str);
	return str;
}
function cuturl(url) {
	var length = 65;
	var urllink = '<a href="' + (url.toLowerCase().substr(0, 4) == 'www.' ? 'http://' + url : url) + '" target="_blank">';
	if(url.length > length) {
		url = url.substr(0, parseInt(length * 0.5)) + ' ... ' + url.substr(url.length - parseInt(length * 0.3));
	}
	urllink += url + '</a>';
	return urllink;
}
function dstag(options, text, tagname) {
	if(trim(text) == '') {
		return '\n';
	}
	var pend = parsestyle(options, '', '');
	var prepend = pend['prepend'];
	var append = pend['append'];
	if(in_array(tagname, ['div', 'p'])) {
		align = getoptionvalue('align', options);
		if(in_array(align, ['left', 'center', 'right'])) {
			prepend = '[align=' + align + ']' + prepend;
			append += '[/align]';
		} else {
			append += '\n';
		}
	}
	return prepend + recursion(tagname, text, 'dstag') + append;
}
function ptag(options, text, tagname) {
	if(trim(text) == '') {
		return '\n';
	}
	if(trim(options) == '') {
		return text + '\n';
	}
	var lineHeight = null;
	var textIndent = null;
	var align, re, matches;
	re = /line-height\s?:\s?(\d{1,3})px/i;
	matches = re.exec(options);
	if(matches != null) {
		lineHeight = matches[1];
	}
	re = /text-indent\s?:\s?(\d{1,3})em/i;
	matches = re.exec(options);
	if(matches != null) {
		textIndent = matches[1];
	}
	re = /text-align\s?:\s?(left|center|right)/i;
	matches = re.exec(options);
	if(matches != null) {
		align = matches[1];
	} else {
		align = getoptionvalue('align', options);
	}
	align = in_array(align, ['left', 'center', 'right']) ? align : 'left';
	style = getoptionvalue('style', options);
	style = preg_replace(['line-height\\\s?:\\\s?(\\\d{1,3})px', 'text-indent\\\s?:\\\s?(\\\d{1,3})em', 'text-align\\\s?:\\\s?(left|center|right)'], '', style);
	if(lineHeight === null && textIndent === null) {
		return '[align=' + align + ']' + (style ? '<span style="' + style + '">' : '') + text + (style ? '</span>' : '') + '[/align]';
	} else {
		return '[p=' + lineHeight + ', ' + textIndent + ', ' + align + ']' + (style ? '<span style="' + style + '">' : '') + text + (style ? '</span>' : '') + '[/p]';
	}
}
function fetchCheckbox(cbn) {
	return $('#'+cbn) && $('#'+cbn).checked == true ? 1 : 0;
}
function fetchoptionvalue(option, text) {
	if((position = strpos(text, option)) !== false) {
		delimiter = position + option.length;
		if(text.charAt(delimiter) == '"') {
			delimchar = '"';
		} else if(text.charAt(delimiter) == '\'') {
			delimchar = '\'';
		} else {
			delimchar = ' ';
		}
		delimloc = strpos(text, delimchar, delimiter + 1);
		if(delimloc === false) {
			delimloc = text.length;
		} else if(delimchar == '"' || delimchar == '\'') {
			delimiter++;
		}
		return trim(text.substr(delimiter, delimloc - delimiter));
	} else {
		return '';
	}
}
function fonttag(fontoptions, text) {
	var prepend = '';
	var append = '';
	var tags = new Array();
	tags = {'font' : 'face=', 'size' : 'size=', 'color' : 'color='};
	for(bbcode in tags) {
		optionvalue = fetchoptionvalue(tags[bbcode], fontoptions);
		if(optionvalue) {
			prepend += '[' + bbcode + '=' + optionvalue + ']';
			append = '[/' + bbcode + ']' + append;
		}
	}
	var pend = parsestyle(fontoptions, prepend, append);
	return pend['prepend'] + recursion('font', text, 'fonttag') + pend['append'];
}
function getoptionvalue(option, text) {
	re = new RegExp(option + "(\s+?)?\=(\s+?)?[\"']?(.+?)([\"']|$|>)", "ig");
	var matches = re.exec(text);
	if(matches != null) {
		return trim(matches[3]);
	}
	return '';
}
function html2bbcode(str) {
	if((allowhtml && fetchCheckbox('htmlon')) || trim(str) == '') {
		for(i in EXTRAFUNC['html2bbcode']) {
			EXTRASTR = str;
			try {
				eval('str = ' + EXTRAFUNC['html2bbcode'][i] + '()');
			} catch(e) {}
		}
		str = str.replace(/<img[^>]+smilieid=(["']?)(\d+)(\1)[^>]*>/ig, function($1, $2, $3) {return smileycode($3);});
		str = str.replace(/<img([^>]*aid=[^>]*)>/ig, function($1, $2) {return imgtag($2);});
		return str;
	}
	str = str.replace(/<div\sclass=["']?blockcode["']?>[\s\S]*?<blockquote>([\s\S]+?)<\/blockquote>[\s\S]*?<\/div>/ig, function($1, $2) {return codetag($2);});
	if(!fetchCheckbox('bbcodeoff') && allowbbcode) {
		var postbg = '';
		str = str.replace(/<style[^>]+name="editorpostbg"[^>]*>body{background-image:url\("([^\[\<\r\n;'\"\?\(\)]+?)"\);}<\/style>/ig, function($1, $4) {
			$4 = $4.replace(STATICURL+'image/postbg/', '');
			return '[postbg]'+$4+'[/postbg]';
		});
		str = str.replace(/\[postbg\]\s*([^\[\<\r\n;'\"\?\(\)]+?)\s*\[\/postbg\]/ig, function($1, $2) {
			postbg = $2;
			return '';
		});
		if(postbg) {
			str = '[postbg]'+postbg+'[/postbg]' + str;
		}
	}
	str = preg_replace(['<style.*?>[\\\s\\\S]*?<\/style>', '<script.*?>[\\\s\\\S]*?<\/script>', '<noscript.*?>[\\\s\\\S]*?<\/noscript>', '<select.*?>[\s\S]*?<\/select>', '<object.*?>[\s\S]*?<\/object>', '<!--[\\\s\\\S]*?-->', ' on[a-zA-Z]{3,16}\\\s?=\\\s?"[\\\s\\\S]*?"'], '', str);
	str= str.replace(/(\r\n|\n|\r)/ig, '');
	str= str.replace(/&((#(32|127|160|173))|shy|nbsp);/ig, ' ');
	if(fetchCheckbox('allowimgurl')) {
		str = str.replace(/([^>=\]"'\/]|^)((((https?|ftp):\/\/)|www\.)([\w\-]+\.)*[\w\-\u4e00-\u9fa5]+\.([\.a-zA-Z0-9]+|\u4E2D\u56FD|\u7F51\u7EDC|\u516C\u53F8)((\?|\/|:)+[\w\.\/=\?%\-&~`@':+!]*)+\.(jpg|gif|png|bmp))/ig, '$1[img]$2[/img]');
	}
	if(!fetchCheckbox('parseurloff')) {
		str = parseurl(str, 'bbcode', false);
	}
	for(i in EXTRAFUNC['html2bbcode']) {
		EXTRASTR = str;
		try {
			eval('str = ' + EXTRAFUNC['html2bbcode'][i] + '()');
		} catch(e) {}
	}
	str = str.replace(/<br\s+?style=(["']?)clear: both;?(\1)[^\>]*>/ig, '');
	str = str.replace(/<br[^\>]*>/ig, "\n");
	if(!fetchCheckbox('bbcodeoff') && allowbbcode) {
		str = preg_replace([
			'<table[^>]*float:\\\s*(left|right)[^>]*><tbody><tr><td>\\\s*([\\\s\\\S]+?)\\\s*<\/td><\/tr></tbody><\/table>',
			'<table([^>]*(width|background|background-color|backcolor)[^>]*)>',
			'<table[^>]*>',
			'<tr[^>]*(?:background|background-color|backcolor)[:=]\\\s*(["\']?)([\(\)\\\s%,#\\\w]+)(\\1)[^>]*>',
			'<tr[^>]*>',
			'(<t[dh]([^>]*(left|center|right)[^>]*)>)\\\s*([\\\s\\\S]+?)\\\s*(<\/t[dh]>)',
			'<t[dh]([^>]*(width|colspan|rowspan)[^>]*)>',
			'<t[dh][^>]*>',
			'<\/t[dh]>',
			'<\/tr>',
			'<\/table>',
			'<h\\\d[^>]*>',
			'<\/h\\\d>'
		], [
			function($1, $2, $3) {return '[float=' + $2 + ']' + $3 + '[/float]';},
			function($1, $2) {return tabletag($2);},
			'[table]\n',
			function($1, $2, $3) {return '[tr=' + $3 + ']';},
			'[tr]',
			function($1, $2, $3, $4, $5, $6) {return $2 + '[align=' + $4 + ']' + $5 + '[/align]' + $6},
			function($1, $2) {return tdtag($2);},
			'[td]',
			'[/td]',
			'[/tr]\n',
			'[/table]',
			'[b]',
			'[/b]'
		], str);
		str = str.replace(/<h([0-9]+)[^>]*>([\s\S]*?)<\/h\1>/ig, function($1, $2, $3) {return "[size=" + (7 - $2) + "]" + $3 + "[/size]\n\n";});
		str = str.replace(/<hr[^>]*>/ig, "[hr]");
		str = str.replace(/<img[^>]+smilieid=(["']?)(\d+)(\1)[^>]*>/ig, function($1, $2, $3) {return smileycode($3);});
		str = str.replace(/<img([^>]*src[^>]*)>/ig, function($1, $2) {return imgtag($2);});
		str = str.replace(/<a\s+?name=(["']?)(.+?)(\1)[\s\S]*?>([\s\S]*?)<\/a>/ig, '$4');
		str = str.replace(/<div[^>]*quote[^>]*><blockquote>([\s\S]*?)<\/blockquote><\/div>([\s\S]*?)(<br[^>]*>)?/ig, "[quote]$1[/quote]");
		str = str.replace(/<div[^>]*blockcode[^>]*><blockquote>([\s\S]*?)<\/blockquote><\/div>([\s\S]*?)(<br[^>]*>)?/ig, "[code]$1[/code]");
		str = recursion('b', str, 'simpletag', 'b');
		str = recursion('strong', str, 'simpletag', 'b');
		str = recursion('i', str, 'simpletag', 'i');
		str = recursion('em', str, 'simpletag', 'i');
		str = recursion('u', str, 'simpletag', 'u');
		str = recursion('strike', str, 'simpletag', 's');
		str = recursion('a', str, 'atag');
		str = recursion('font', str, 'fonttag');
		str = recursion('blockquote', str, 'simpletag', 'indent');
		str = recursion('ol', str, 'listtag');
		str = recursion('ul', str, 'listtag');
		str = recursion('div', str, 'dstag');
		str = recursion('p', str, 'ptag');
		str = recursion('span', str, 'fonttag');
	}
	str = str.replace(/<[\/\!]*?[^<>]*?>/ig, '');
	for(var i = 0; i <= DISCUZCODE['num']; i++) {
		str = str.replace("[\tDISCUZ_CODE_" + i + "\t]", DISCUZCODE['html'][i]);
	}
	str = clearcode(str);
	return preg_replace(['&nbsp;', '&lt;', '&gt;', '&amp;'], [' ', '<', '>', '&'], str);
}
function tablesimple(s, table, str) {
	if(strpos(str, '[tr=') || strpos(str, '[td=')) {
		return s;
	} else {
		return '[table=' + table + ']\n' + preg_replace(['\\\[tr\\\]', '\\\[\\\/td\\\]\\\s?\\\[td\\\]', '\\\[\\\/tr\\\]\s?', '\\\[td\\\]', '\\\[\\\/td\\\]', '\\\[\\\/td\\\]\\\[\\\/tr\\\]'], ['', '|', '', '', '', '', ''], str) + '[/table]';
	}
}
function imgtag(attributes) {
	var width = '';
	var height = '';
	re = /src=(["']?)([\s\S]*?)(\1)/i;
	var matches = re.exec(attributes);
	if(matches != null) {
		var src = matches[2];
	} else {
		return '';
	}
	re = /(max-)?width\s?:\s?(\d{1,4})(px)?/i;
	var matches = re.exec(attributes);
	if(matches != null && !matches[1]) {
		width = matches[2];
	}
	re = /height\s?:\s?(\d{1,4})(px)?/i;
	var matches = re.exec(attributes);
	if(matches != null) {
		height = matches[1];
	}
	if(!width) {
		re = /width=(["']?)(\d+)(\1)/i;
		var matches = re.exec(attributes);
		if(matches != null) {
			width = matches[2];
		}
	}
	if(!height) {
		re = /height=(["']?)(\d+)(\1)/i;
		var matches = re.exec(attributes);
		if(matches != null) {
			height = matches[2];
		}
	}
	re = /aid=(["']?)attachimg_(\d+)(\1)/i;
	var matches = re.exec(attributes);
	if(matches != null) {
		return '[attachimg]' + matches[2] + '[/attachimg]';
	}
	width = width > 0 ? width : 0;
	height = height > 0 ? height : 0;
	return width > 0 || height > 0 ?
		'[img=' + width + ',' + height + ']' + src + '[/img]' :
		'[img]' + src + '[/img]';
}
function listtag(listoptions, text, tagname) {
	text = text.replace(/<li>(([\s\S](?!<\/li))*?)(?=<\/?ol|<\/?ul|<li|\[list|\[\/list)/ig, '<li>$1</li>') + (BROWSER.opera ? '</li>' : '');
	text = recursion('li', text, 'litag');
	var opentag = '[list]';
	var listtype = fetchoptionvalue('type=', listoptions);
	listtype = listtype != '' ? listtype : (tagname == 'ol' ? '1' : '');
	if(in_array(listtype, ['1', 'a', 'A'])) {
		opentag = '[list=' + listtype + ']';
	}
	return text ? opentag + '\n' + recursion(tagname, text, 'listtag') + '[/list]' : '';
}
function litag(listoptions, text) {
	return '[*]' + text.replace(/(\s+)$/g, '') + '\n';
}
function parsecode(text) {
	DISCUZCODE['num']++;
	DISCUZCODE['html'][DISCUZCODE['num']] = '<div class="blockcode"><blockquote>' + htmlspecialchars(text) + '</blockquote></div>';
	return "[\tDISCUZ_CODE_" + DISCUZCODE['num'] + "\t]";
}
function parsestyle(tagoptions, prepend, append) {
	var searchlist = [
		['align', true, 'text-align:\\s*(left|center|right);?', 1],
		['float', true, 'float:\\s*(left|right);?', 1],
		['color', true, '(^|[;\\s])color:\\s*([^;]+);?', 2],
		['backcolor', true, '(^|[;\\s])background-color:\\s*([^;]+);?', 2],
		['font', true, 'font-family:\\s*([^;]+);?', 1],
		['size', true, 'font-size:\\s*(\\d+(\\.\\d+)?(px|pt|in|cm|mm|pc|em|ex|%|));?', 1],
		['size', true, 'font-size:\\s*(x\\-small|small|medium|large|x\\-large|xx\\-large|\\-webkit\\-xxx\\-large);?', 1, 'size'],
		['b', false, 'font-weight:\\s*(bold);?'],
		['i', false, 'font-style:\\s*(italic);?'],
		['u', false, 'text-decoration:\\s*(underline);?'],
		['s', false, 'text-decoration:\\s*(line-through);?']
	];
	var sizealias = {'x-small':1,'small':2,'medium':3,'large':4,'x-large':5,'xx-large':6,'-webkit-xxx-large':7};
	var style = getoptionvalue('style', tagoptions);
	re = /^(?:\s|)color:\s*rgb\((\d+),\s*(\d+),\s*(\d+)\)(;?)/i;
	style = style.replace(re, function($1, $2, $3, $4, $5) {return("color:#" + parseInt($2).toString(16) + parseInt($3).toString(16) + parseInt($4).toString(16) + $5);});
	var len = searchlist.length;
	for(var i = 0; i < len; i++) {
		searchlist[i][4] = !searchlist[i][4] ? '' : searchlist[i][4];
		re = new RegExp(searchlist[i][2], "ig");
		match = re.exec(style);
		if(match != null) {
			opnvalue = match[searchlist[i][3]];
			if(searchlist[i][4] == 'size') {
				opnvalue = sizealias[opnvalue];
			}
			prepend += '[' + searchlist[i][0] + (searchlist[i][1] == true ? '=' + opnvalue + ']' : ']');
			append = '[/' + searchlist[i][0] + ']' + append;
		}
	}
	return {'prepend' : prepend, 'append' : append};
}
function parsetable(width, bgcolor, str) {
	if(isUndefined(width)) {
		var width = '';
	} else {
		try {
			width = width.substr(width.length - 1, width.length) == '%' ? (width.substr(0, width.length - 1) <= 98 ? width : '98%') : (width <= 560 ? width : '98%');
		} catch(e) { width = ''; }
	}
	if(isUndefined(str)) {
		return;
	}
	if(strpos(str, '[/tr]') === false && strpos(str, '[/td]') === false) {
		var rows = str.split('\n');
		var s = '';
		for(i = 0;i < rows.length;i++) {
			s += '<tr><td>' + preg_replace(['\r', '\\\\\\\|', '\\\|', '\\\\n'], ['', '&#124;', '</td><td>', '\n'], rows[i]) + '</td></tr>';
		}
		str = s;
		simple = ' simpletable';
	} else {
		simple = '';
		str = str.replace(/\[tr(?:=([\(\)\s%,#\w]+))?\]\s*\[td(?:=(\d{1,4}%?))?\]/ig, function($1, $2, $3) {
			return '<tr' + ($2 ? ' style="background-color: ' + $2 + '"' : '') + '><td' + ($3 ? ' width="' + $3 + '"' : '') + '>';
		});
		str = str.replace(/\[tr(?:=([\(\)\s%,#\w]+))?\]\s*\[td(?:=(\d{1,2}),(\d{1,2})(?:,(\d{1,4}%?))?)?\]/ig, function($1, $2, $3, $4, $5) {
			return '<tr' + ($2 ? ' style="background-color: ' + $2 + '"' : '') + '><td' + ($3 ? ' colspan="' + $3 + '"' : '') + ($4 ? ' rowspan="' + $4 + '"' : '') + ($5 ? ' width="' + $5 + '"' : '') + '>';
		});
		str = str.replace(/\[\/td\]\s*\[td(?:=(\d{1,4}%?))?\]/ig, function($1, $2) {
			return '</td><td' + ($2 ? ' width="' + $2 + '"' : '') + '>';
		});
		str = str.replace(/\[\/td\]\s*\[td(?:=(\d{1,2}),(\d{1,2})(?:,(\d{1,4}%?))?)?\]/ig, function($1, $2, $3, $4) {
			return '</td><td' + ($2 ? ' colspan="' + $2 + '"' : '') + ($3 ? ' rowspan="' + $3 + '"' : '') + ($4 ? ' width="' + $4 + '"' : '') + '>';
		});
		str = str.replace(/\[\/td\]\s*\[\/tr\]\s*/ig, '</td></tr>');
		str = str.replace(/<td> <\/td>/ig, '<td>&nbsp;</td>');
	}
	return '<table ' + (width == '' ? '' : 'width="' + width + '" ') + 'class="t_table"' + (isUndefined(bgcolor) ? '' : ' style="background-color: ' + bgcolor + '"') + simple +'>' + str + '</table>';
}
function preg_quote(str) {
	return (str+'').replace(/([\\\.\+\*\?\[\^\]\$\(\)\{\}\=\!<>\|\:])/g, "\\$1");
}
function recursion(tagname, text, dofunction, extraargs) {
	if(extraargs == null) {
		extraargs = '';
	}
	tagname = tagname.toLowerCase();
	var open_tag = '<' + tagname;
	var open_tag_len = open_tag.length;
	var close_tag = '</' + tagname + '>';
	var close_tag_len = close_tag.length;
	var beginsearchpos = 0;
	do {
		var textlower = text.toLowerCase();
		var tagbegin = textlower.indexOf(open_tag, beginsearchpos);
		if(tagbegin == -1) {
			break;
		}
		var strlen = text.length;
		var inquote = '';
		var found = false;
		var tagnameend = false;
		var optionend = 0;
		var t_char = '';
		for(optionend = tagbegin; optionend <= strlen; optionend++) {
			t_char = text.charAt(optionend);
			if((t_char == '"' || t_char == "'") && inquote == '') {
				inquote = t_char;
			} else if((t_char == '"' || t_char == "'") && inquote == t_char) {
				inquote = '';
			} else if(t_char == '>' && !inquote) {
				found = true;
				break;
			} else if((t_char == '=' || t_char == ' ') && !tagnameend) {
				tagnameend = optionend;
			}
		}
		if(!found) {
			break;
		}
		if(!tagnameend) {
			tagnameend = optionend;
		}
		var offset = optionend - (tagbegin + open_tag_len);
		var tagoptions = text.substr(tagbegin + open_tag_len, offset);
		var acttagname = textlower.substr(tagbegin * 1 + 1, tagnameend - tagbegin - 1);
		if(acttagname != tagname) {
			beginsearchpos = optionend;
			continue;
		}
		var tagend = textlower.indexOf(close_tag, optionend);
		if(tagend == -1) {
			break;
		}
		var nestedopenpos = textlower.indexOf(open_tag, optionend);
		while(nestedopenpos != -1 && tagend != -1) {
			if(nestedopenpos > tagend) {
				break;
			}
			tagend = textlower.indexOf(close_tag, tagend + close_tag_len);
			nestedopenpos = textlower.indexOf(open_tag, nestedopenpos + open_tag_len);
		}
		if(tagend == -1) {
			beginsearchpos = optionend;
			continue;
		}
		var localbegin = optionend + 1;
		var localtext = eval(dofunction)(tagoptions, text.substr(localbegin, tagend - localbegin), tagname, extraargs);
		text = text.substring(0, tagbegin) + localtext + text.substring(tagend + close_tag_len);
		beginsearchpos = tagbegin + localtext.length;
	} while(tagbegin != -1);
	return text;
}
function simpletag(options, text, tagname, parseto) {
	if(trim(text) == '') {
		return '';
	}
	text = recursion(tagname, text, 'simpletag', parseto);
	return '[' + parseto + ']' + text + '[/' + parseto + ']';
}
function smileycode(smileyid) {
	if(typeof smilies_type != 'object') return;
	for(var typeid in smilies_array) {
		for(var page in smilies_array[typeid]) {
			for(var i in smilies_array[typeid][page]) {
				if(smilies_array[typeid][page][i][0] == smileyid) {
					return smilies_array[typeid][page][i][1];
					break;
				}
			}
		}
	}
}
function strpos(haystack, needle, _offset) {
	if(isUndefined(_offset)) {
		_offset = 0;
	}
	var _index = haystack.toLowerCase().indexOf(needle.toLowerCase(), _offset);
	return _index == -1 ? false : _index;
}
function tabletag(attributes) {
	var width = '';
	re = /width=(["']?)(\d{1,4}%?)(\1)/i;
	var matches = re.exec(attributes);
	if(matches != null) {
		width = matches[2].substr(matches[2].length - 1, matches[2].length) == '%' ?
			(matches[2].substr(0, matches[2].length - 1) <= 98 ? matches[2] : '98%') :
			(matches[2] <= 560 ? matches[2] : '98%');
	} else {
		re = /width\s?:\s?(\d{1,4})([px|%])/i;
		var matches = re.exec(attributes);
		if(matches != null) {
			width = matches[2] == '%' ? (matches[1] <= 98 ? matches[1] + '%' : '98%') : (matches[1] <= 560 ? matches[1] : '98%');
		}
	}
	var bgcolor = '';
	re = /(?:background|background-color|bgcolor)[:=]\s*(["']?)((rgb\(\d{1,3}%?,\s*\d{1,3}%?,\s*\d{1,3}%?\))|(#[0-9a-fA-F]{3,6})|([a-zA-Z]{1,20}))(\1)/i;
	var matches = re.exec(attributes);
	if(matches != null) {
		bgcolor = matches[2];
		width = width ? width : '98%';
	}
	return bgcolor ? '[table=' + width + ',' + bgcolor + ']\n' : (width ? '[table=' + width + ']\n' : '[table]\n');
}
function tdtag(attributes) {
	var colspan = 1;
	var rowspan = 1;
	var width = '';
	re = /colspan=(["']?)(\d{1,2})(\1)/i;
	var matches = re.exec(attributes);
	if(matches != null) {
		colspan = matches[2];
	}
	re = /rowspan=(["']?)(\d{1,2})(\1)/i;
	var matches = re.exec(attributes);
	if(matches != null) {
		rowspan = matches[2];
	}
	re = /width=(["']?)(\d{1,4}%?)(\1)/i;
	var matches = re.exec(attributes);
	if(matches != null) {
		width = matches[2];
	}
	return in_array(width, ['', '0', '100%']) ?
		(colspan == 1 && rowspan == 1 ? '[td]' : '[td=' + colspan + ',' + rowspan + ']') :
		(colspan == 1 && rowspan == 1 ? '[td=' + width + ']' : '[td=' + colspan + ',' + rowspan + ',' + width + ']');
}
if(typeof jsloaded == 'function') {
	jsloaded('bbcode');
}
</script>
<script type="text/javascript">
	$('.send_message').on('click', function() {
		<!--{if !$_G[uid]}-->
			popup.open('{lang nologin_tip}', 'confirm', 'member.php?mod=logging&action=login');
			return false;
		<!--{/if}-->
		Zepto('.page').append('<div class="ainuooverlay"><div class="preloader-indicator-overlay"></div><div class="preloader-indicator-modal"><span class="preloader preloader-white"></span></div></div>');
		var obj = $(this);
		var formobj = $(this.form);
		$.ajax({
			type:'POST',
			url:formobj.attr('action') + '&handlekey='+ formobj.attr('id') +'&inajax=1',
			data:formobj.serialize(),
			dataType:'xml'
		})
		.success(function(s) {
			if(s.lastChild.firstChild.nodeValue.indexOf("\u64cd\u4f5c\u6210\u529f") >= 0){
				Zepto('.ainuooverlay').remove();
				Zepto.toast('\u53d1\u9001\u6210\u529f',1500,'toast');
				var amasgListObj = $('msglist');
				//amsgListObj.scrollTop = amsgListObj.scrollHeight;
				var apObj = document.createElement("li");
				apObj.className = 'cl pmm';
				apObj.innerHTML = '<div class="cl"><div class="auava"><a href="home.php?mod=space&uid=$_G[uid]"><img src="{$_G[setting][ucenterurl]}/avatar.php?uid={$_G[uid]}&size=middle"></a></div><div class="pmt"></div><div class="pmd">'+bbcode2html(parseurl($('#pmmessage').val()))+'</div></div><div class="adate cl">{lang just_now}</div>';
				Zepto('.ainuo_nowpm .pmb').append(apObj);
				$('#pmmessage').val('');
				$("#ainuo_contop").animate({ scrollTop: $('#ainuo_contop')[0].scrollHeight}, 1000);
				
			}else if(s.lastChild.firstChild.nodeValue.indexOf("\u4e0d\u80fd\u53d1\u9001\u7a7a\u6d88\u606f") >= 0){
				Zepto('.ainuooverlay').remove();
				Zepto.toast('\u4e0d\u80fd\u53d1\u9001\u7a7a\u6d88\u606f',1500,'toast');
			}else if(s.lastChild.firstChild.nodeValue.indexOf("\u4e24\u6b21\u53d1\u9001\u77ed\u6d88\u606f\u592a\u5feb\uff0c\u8bf7\u7a0d\u5019\u518d\u53d1\u9001") >= 0){
				Zepto('.ainuooverlay').remove();
				Zepto.toast('\u4e24\u6b21\u53d1\u9001\u77ed\u6d88\u606f\u592a\u5feb\uff0c\u8bf7\u7a0d\u5019\u518d\u53d1\u9001',1500,'toast');
			}else if(s.lastChild.firstChild.nodeValue.indexOf("\u62b1\u6b49\uff0c\u60a8\u4e0d\u80fd\u7ed9\u81ea\u5df1\u53d1\u77ed\u6d88\u606f") >= 0){
				Zepto('.ainuooverlay').remove();
				Zepto.toast('\u62b1\u6b49\uff0c\u60a8\u4e0d\u80fd\u7ed9\u81ea\u5df1\u53d1\u77ed\u6d88\u606f',1500,'toast');
			}else{
				popup.open(s.lastChild.firstChild.nodeValue);
				Zepto('.ainuooverlay').remove();
			}
		})
		.error(function() {
			window.location.href = obj.attr('href');
			Zepto('.ainuooverlay').remove();
		});
		return false;
	});

</script>
<!--{template common/footer}-->