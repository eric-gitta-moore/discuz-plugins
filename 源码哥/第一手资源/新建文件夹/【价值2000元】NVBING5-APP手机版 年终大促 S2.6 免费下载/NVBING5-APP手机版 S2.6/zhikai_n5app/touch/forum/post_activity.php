<?php exit;?>
<div class="ztfb_tszt cl"> 
	<table cellspacing="0" cellpadding="0">
	<div class="tszt_fbxm cl">
		<div class="fbxm_xmbt z">{lang post_event_time}</div>
		<div class="fbxm_xmnr z">
			<div id="certainstarttime" {if $activity['starttimeto']}style="display: none"{/if}>
				<input type="text" name="starttimefrom[0]" id="starttimefrom_0" class="px" autocomplete="off" placeholder="{$n5app['lang']['sqfbqszsjs']}" value="$activity[starttimefrom]" tabindex="1" />
			</div>
			<div id="uncertainstarttime" {if !$activity['starttimeto']}style="display: none"{/if}>
				<input type="text" name="starttimefrom[1]" id="starttimefrom_1" class="px pxs" placeholder="{$n5app['lang']['sqfbqingsz']}" autocomplete="off" value="$activity[starttimefrom]" tabindex="1" />
				<em> ~ </em>
				<input type="text" autocomplete="off" id="starttimeto" name="starttimeto" class="px pxs" placeholder="{$n5app['lang']['sqfbqingsz']}" value="{if $activity['starttimeto']}$activity[starttimeto]{/if}" tabindex="1" />
			</div>
			<div class="xmnr_hdsj cl"><input type="checkbox" id="activitytime" name="activitytime" class="pc" onclick="if(this.checked) {$('#certainstarttime').hide();$('#uncertainstarttime').show();} else {$('#certainstarttime').show();$('#uncertainstarttime').hide();}" value="1" {if $activity['starttimeto']}checked{/if} tabindex="1" /><label for="activitytime"></label>{lang activity_starttime_endtime}</div>
		</div>
	</div>
	<div class="tszt_fbxm cl">
		<div class="fbxm_xmbt z">{lang activity_space}</div>
		<div class="fbxm_xmnr z"><input type="text" name="activityplace" id="activityplace" class="px" placeholder="{$n5app['lang']['sqfbbitiansm']}" value="$activity[place]" tabindex="1" /></div>
	</div>
	<!--{if $_GET[action] == 'newthread'}-->
	<div class="tszt_fbxm cl">
		<div class="fbxm_xmbt z">{lang activity_city}</div>
		<div class="fbxm_xmnr z"><input name="activitycity" id="activitycity" class="px" placeholder="{$n5app['lang']['sqfbbitiansm']}" type="text" tabindex="1" /></div>
	</div>
	<!--{/if}-->
	<div class="tszt_fbxm cl">
		<div class="fbxm_xmbt z">{lang activiy_sort}</div>
		<div class="fbxm_xmnr z"><select id="activityclass" name="activityclass" class="ps" value="$activity[class]" >
          <!--{if $activitytypelist}--> 
          <!--{loop $activitytypelist $type}-->
          <option value="$type">$type</option>
          <!--{/loop}--> 
          <!--{/if}-->
        </select></div>
	</div>
	<div class="tszt_fbxm cl">
		<div class="fbxm_xmbt z">{lang activity_need_member}</div>
		<div class="fbxm_xmnr z">
			<input type="text" name="activitynumber" id="activitynumber" class="px pxs z" placeholder="{$n5app['lang']['sqfbqingsrrs']}" onkeyup="checkvalue(this.value, 'activitynumbermessage')" value="$activity[number]" tabindex="1" />
			<select name="gender" id="gender" width="38" class="ps pss y">
				<option value="0" {if !$activity['gender']}selected="selected"{/if}>{lang unlimited}</option>
				<option value="1" {if $activity['gender'] == 1}selected="selected"{/if}>{lang male}</option>
				<option value="2" {if $activity['gender'] == 2}selected="selected"{/if}>{lang female}</option>
			</select>
			<span id="activitynumbermessage"></span>
		</div>
	</div>
	<!--{if $_G['setting']['activityfield']}-->
	<div class="tszt_fbxm cl">
		<div class="fbxm_xmbt z">{lang optional_data}</div>
		<div class="fbxm_xmnr z">
			<ul class="xl2 cl">
			<!--{loop $_G['setting']['activityfield'] $key $val}-->
				<li>
					<label for="userfield_$key">
						<input type="checkbox" name="userfield[]" id="userfield_$key" class="pc" value="$key"{if $activity['ufield']['userfield'] && in_array($key, $activity['ufield']['userfield'])} checked="checked"{/if} />
					$val</label>
				</li>
			<!--{/loop}-->
			</ul>
		</div>
	</div>
	<!--{/if}-->
    <!--{if $_G['setting']['activityextnum']}-->
	<div class="tszt_fbxm cl">
		<div class="fbxm_xmbt z">{lang other_data}</div>
		<div class="fbxm_xmnr z">
			<textarea name="extfield" id="extfield" class="pt" cols="50" placeholder="{lang post_activity_message} $_G['setting']['activityextnum'] {lang post_option}"><!--{if $activity['ufield']['extfield']}-->$activity[ufield][extfield]<!--{/if}--></textarea>
		</div>
	</div>
    <!--{/if}--> 
	<!--{if $_G['setting']['activitycredit']}-->
	<div class="tszt_fbxm cl">
		<div class="fbxm_xmbt z">{lang consumption_credit}</div>
		<div class="fbxm_xmnr z"><input type="text" name="activitycredit" id="activitycredit" class="px" placeholder="{lang user_consumption_money}" value="$activity[credit]" />{$_G['setting']['extcredits'][$_G['setting']['activitycredit']][title]}</div>
	</div>
	<!--{/if}-->
	<div class="tszt_fbxm cl">
		<div class="fbxm_xmbt z">{lang activity_payment}</div>
		<div class="fbxm_xmnr z"><input type="text" name="cost" id="cost" class="px" placeholder="{$n5app['lang']['sqfbbitiansm']}" onkeyup="checkvalue(this.value, 'costmessage')" value="$activity[cost]" tabindex="1" />{lang payment_unit} <span id="costmessage"></span></div>
    </div>
    <div class="tszt_fbxm cl">
		<div class="fbxm_xmbt z">{lang post_closing}</div>
		<div class="fbxm_xmnr z"><input type="text" name="activityexpiration" id="activityexpiration" class="px datetime" placeholder="{$n5app['lang']['sqfbqszsjs']}" autocomplete="off" value="$activity[expiration]" tabindex="1" /></div>
    </div>
    <!--{if $allowpostimg}-->
    <div class="tszt_fbxm cl">
		<div class="fbxm_xmbt z">{lang post_topic_image}</div>
		<div class="fbxm_xmnr z">
			<button type="button" class="pn" onclick="uploadWindow($_G['fid'],function (aid, url){activityaid_upload(aid, url)})"><!--{if $activityattach[attachment]}-->{lang update}<!--{else}-->{lang upload}<!--{/if}--></button>
			<input type="hidden" name="activityaid" id="activityaid" {if $activityattach[attachment]}value="$activityattach[aid]" {/if}/>
			<input type="hidden" name="activityaid_url" id="activityaid_url" />
			<div id="activityattach_image" class="fbxm_hdtp"> 
				<!--{if $activityattach[attachment]}--> 
				<a href="$activityattach[url]/$activityattach[attachment]" target="_blank"><img class="spimg" src="$activityattach[url]/{if $activityattach['thumb']}{eval echo getimgthumbname($activityattach['attachment']);}{else}$activityattach[attachment]{/if}" alt="" /></a> 
				<!--{/if}--> 
			</div>
		</div>
    </div>
    <!--{/if}--> 
    <!--{hook/post_activity_extra}-->
  </table>
</div>
<script type="text/javascript">
		function activityaid_upload(aid, url) {
	Scratching('activityaid_url').value = url;
	updateactivityattach(aid, url, '{$_G['setting']['attachurl']}forum');
}
</script> 