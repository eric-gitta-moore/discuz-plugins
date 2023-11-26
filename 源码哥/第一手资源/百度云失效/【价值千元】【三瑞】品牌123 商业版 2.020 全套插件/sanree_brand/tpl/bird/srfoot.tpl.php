<?php (!defined('IN_SANREE')&&exit('Power By ymg6.Com'))?>
<!--{block srfoot}-->
<div class="sr_comment">
  <div class="cbox">
    <div class="ctit">
      <div class="lct l"><i class="icon"></i>{lang sanree_brand:bird_item_fourm}</div>
      <div class="rr r"><a href="javascript:;" onClick="document.getElementById('fastpostform').message.focus();">{lang sanree_brand:bird_item_fourm}</a></div>
    </div>
    <div class="clear"></div>
    <div class="sr_commain">
      <ul>
        <!--{loop $postthread $thread}-->
        <li>
          <div class="user_avatar l"><img src="{$thread[img]}" /></div>
          <div class="user_content r">
            <div class="uc">
              <div class="topmeta"> <span class="l"><a href="home.php?mod=space&amp;uid={$thread['authorid']}" target=_blank>{$thread[author]}</a></span> <span class="l">{lang sanree_brand:bird_item_report} <em><!--{$thread[dateline]}--></em></span> <span class="l">{lang sanree_brand:satisfaction}</span>
                <div class="star"> <span class="staroff"> <span class="staron" style="width: {$thread[satisfaction]}%;"></span></span></div>
              </div>
              <div class="clear"></div>
              <div class="bc"> {$thread[message]} </div>
            </div>
            <div class="la"></div>
          </div>
        </li>
        <!--{/loop}-->
      </ul>
      <div class="pager clearall">{$multi}</div>
    </div>
    <div class="report">
      <form  autocomplete="off" id="fastpostform" action="plugin.php?id=sanree_brand&mod=fastpost" method="post"  onSubmit="return fastnewpost(this);">
        <INPUT id="star" value="{$satisfaction}" type=hidden name="star">
        <input type="hidden" name="usesig" value="$usesigcheck" />
        <input type="hidden" name="postsubmit" value="true" />
        <input type="hidden" name="formhash" id="formhash" value="{FORMHASH}" />
        <input type="hidden" name="posttime" id="posttime" value="{TIMESTAMP}" />
        <input type="hidden" name="inajax" id="inajax" value="{$_G[inajax]}" />
        <input type="hidden" name="tid" id="tid" value="{$tid}" />
        <input type="hidden" name="bid" id="bid" value="{$bid}" />
        <div class="re_tit">{lang sanree_brand:bird_item_of} <strong>{$brandresult[name]}</strong> {lang sanree_brand:bird_item_idea}</div>
        <div class="input_area">
          <div class="user_avatar l"><img src="{$selfimg}" /></div>
          <div class="text_area r">
            <div class="t_infor">
              <div class="t_meta l">{lang sanree_brand:bird_item_hello}<a href="home.php?mod=space&amp;uid={$_G['uid']}">{$_G[username]}</a></div>
              <div class="r_star r"> <span class="l">{lang sanree_brand:bird_item_first}</span> 
                <!--{if !$satisfaction}-->
                <div class="star" id="newstar">
                    <span onMouseover="setnewstar(1,'newstar',0)"><img src="source/plugin/sanree_brand/tpl/bird/images/staroff.png"  /></span>
                    <span onMouseover="setnewstar(2,'newstar',0)"><img src="source/plugin/sanree_brand/tpl/bird/images/staroff.png"  /></span>
                    <span onMouseover="setnewstar(3,'newstar',0)"><img src="source/plugin/sanree_brand/tpl/bird/images/staroff.png"  /></span>
                    <span onMouseover="setnewstar(4,'newstar',0)"><img src="source/plugin/sanree_brand/tpl/bird/images/staroff.png" /></span>
                    <span onMouseover="setnewstar(5,'newstar',0)"><img src="source/plugin/sanree_brand/tpl/bird/images/staroff.png" /></span>
                </div>                
                <!--{else}-->
                <div class="star"> <span class="staroff"> <span class="staron" style="width: {$satisfaction}%;"></span></span></div>
                <!--{/if}--> 
              </div>
            </div>
            <div class="clear"></div>
            <div class="inputbox">
              <!--{if $_G['uid']}--> 
              <!--{subtemplate common/seditor}-->
              <textarea id="fastpostmessage" class=pt tabIndex="9" rows=5 cols=60 name=message></textarea>
              <!--{else}-->
              <div class="pt hm"> {lang sanree_brand:login_to_reply} <a href="member.php?mod=logging&action=login" class="xi2">{lang login}</a> | <a href="member.php?mod={$_G[setting][regname]}" class="xi2">$_G['setting']['reglinkname']</a> 
              </div>
              <!--{/if}--> 
            </div>
            <div class="la"></div>
          </div>
          <div class="clear"></div>
          <!--{if $_G[uided]}-->
              <!--{if $dzvflag}-->
                    <!--{if $seccodecheck}-->
                    <div class="text_area r">
                        {eval
                            $sechash = !isset($sechash) ? 'S'.($_G['inajax'] ? 'A' : '').$_G['sid'] : $sechash.random(3);
                            $sectpl = str_replace("'", "\'", $sectpl);
                        }
                        <!--{if $seccodecheck}-->
                                <span id="seccode_c$sechash"></span>		
                                <script type="text/javascript" reload="1">updateseccode('c$sechash', '$sectpl', '{$_G[basescript]}::{CURMODULE}');</script>
                        <!--{/if}-->
                    </div>
                    <!--{/if}-->
              <!--{else}-->
                  <!--{if $secqaacheck || $seccodecheck}-->
                  <div class="text_area r">
                      {eval
                            $_G['sechashi'] = !empty($_G['cookie']['sechashi']) ? $_G['sechash'] + 1 : 0;
                            $sechash = 'S'.($_G['inajax'] ? 'A' : '').$_G['sid'].$_G['sechashi'];
                            $sectpl = !empty($sectpl) ? explode("<sec>", $sectpl) : array('<br />',': ','<br />','');
                            $sectpldefault = $sectpl;
                            $sectplqaa = str_replace('<hash>', 'qaa'.$sechash, $sectpldefault);
                            $sectplcode = str_replace('<hash>', 'code'.$sechash, $sectpldefault);
                            $secshow = !isset($secshow) ? 1 : $secshow;
                            $sectabindex = !isset($sectabindex) ? 1 : $sectabindex;
                        }
                        <input name="sechash" type="hidden" value="$sechash" />
                        <!--{if $sectpl}-->
                            <!--{if $secqaacheck}-->
                                {$sectplqaa[0]}{lang secqaa}{$sectplqaa[1]}<input name="secanswer" id="secqaaverify_$sechash" type="text" autocomplete="off" style="width:100px" class="txt px vm" onblur="checksec('qaa', '$sechash')" tabindex="$sectabindex" />
                                <a href="javascript:;" onclick="updatesecqaa('$sechash');doane(event);" class="xi2">{lang seccode_change}</a>
                                <span id="checksecqaaverify_$sechash"><img src="{STATICURL}image/common/none.gif" width="16" height="16" class="vm" /></span>
                                $sectplqaa[2]<span id="secqaa_$sechash"></span>
                                <!--{if $secshow}--><script type="text/javascript" reload="1">updatesecqaa('$sechash');</script><!--{/if}-->
                                $sectplqaa[3]
                            <!--{/if}-->
                            <!--{if $seccodecheck}-->
                                {$sectplcode[0]}{lang seccode}{$sectplcode[1]}<input name="seccodeverify" id="seccodeverify_$sechash" type="text" autocomplete="off" style="{if $_G[setting][seccodedata][type] != 1}ime-mode:disabled;{/if}width:100px" class="txt px vm" onblur="checksec('code', '$sechash')" tabindex="$sectabindex" />
                                <a href="javascript:;" onclick="updateseccode('$sechash');doane(event);" class="xi2">{lang seccode_change}</a>
                                <span id="checkseccodeverify_$sechash"><img src="{STATICURL}image/common/none.gif" width="16" height="16" class="vm" /></span>
                                {$sectplcode[2]}<span id="seccode_$sechash"></span>
                                <!--{if $secshow}--><script type="text/javascript" reload="1">updateseccode('$sechash');</script><!--{/if}-->
                                $sectplcode[3]
                            <!--{/if}-->
                        <!--{/if}-->
                  </div>
                   <!--{/if}-->
              <!--{/if}-->
          <!--{/if}-->
          <div class="c_btn"><a >
            <input type="submit" value="{lang sanree_brand:bird_item_fourm}" align="absmiddle" />
            </a></div>
        </div>
      </form>
    </div>
  </div>
</div>
<div class="overlay"></div>
<div class="sr_map l">
  <div id="modal1" class="modal">
    <div class="modal_main">
      <div class="main_cc">
        <div class="modal1tit">
          <div class="toptit"><i class="icon"></i>{lang sanree_brand:bird_item_map}</div>
          <div class="closeBtn"><a href="#"></a></div>
        </div>
        <!--{if $lng}-->
        	<!--{if $_G[sr_extra]}-->
			<script type="text/javascript" src="http://api.map.baidu.com/api?v=1.2"></script>
            <!--{/if}-->
        <div style="width:500px;height:300px;" id="windowmap"></div>
        <script type="text/javascript">
                var lng = '{$lng}';
                var lat = '{$lat}';	
                var popupID="popupID";
                var remindID ="remindID";
                var confirmHTML = '<div id="' + popupID + '"><div id="' + remindID + '" class="content">{$info}</div></div></div>';
                var opts1 = {title : '<span style="font-size:14px;color:#0A8021">{$info}</span>'};
                var t1 = "<div style='line-height:1.8em;font-size:12px; width:200px'><b>{lang sanree_brand:map_address}</b>{$brandresult['address']}<br /><b>{lang sanree_brand:map_tel}</b>{$brandresult['tel']}<br /><b>{lang sanree_brand:map_mouth}</b>";
                var t2 = "<!--{loop $starlist $star}--><img src='{$_G[siteurl]}{sr_brand_IMG}/st.png' /><!--{/loop}-->";
                var t3= "<a style='text-decoration:none;color:#2679BA;float:right'>>></a></div>";
                try{
                    var infoWindow1 =new BMap.InfoWindow(t1 + t2 + t3, opts1);	
                    var confirmWindow = new BMap.InfoWindow(confirmHTML, {offset: new BMap.Size(0, -8),width: 240});  	
                    var markerImage= "http://ditu.baidu.com/img/markers.png";
                    var I = new BMap.Icon(markerImage, new BMap.Size(23, 25), {imageOffset: new BMap.Size(0, 0 - 27 * 25 + 3)});
                    var map = new BMap.Map("windowmap");
                    var point = new BMap.Point(lng||116.404, lat||39.915);
                    map.centerAndZoom(point, 15);
                    var marker = new BMap.Marker(point, {icon: I});
                    map.addOverlay(marker);
                    var opts = {type: BMAP_NAVIGATION_CONTROL_LARGE}  
                    map.addControl(new BMap.NavigationControl(opts));
                    map.addOverlay(infoWindow1);
                    marker.openInfoWindow(infoWindow1);
                    map.centerAndZoom(point,15);
                }
                catch(e){
                    alert(e);
                }
                </script> 
        <!--{else}--> 
        &nbsp; 
        <!--{/if}--> 
      </div>
    </div>
  </div>
</div>
</div>
<script language="javascript">
	var langvoter=Array();
	langvoter[0] = '{lang sanree_brand:pleasestar}';
	langvoter[1] = '{lang sanree_brand:pleasestarstr}';
</script> 
<script src="{sr_brand_JS}/voter.js?{VERHASH}"></script>
<!--{/block}-->