<?php exit;?>
<div class="ztfb_tszt cl">
	<div class="tszt_fbxm cl">
		<div class="fbxm_xmbt z">{lang debate_square_point}</div>
		<div class="fbxm_xmnr z"><textarea name="affirmpoint" id="affirmpoint" class="txt" placeholder="{$n5app['lang']['sqfbqingsrnr']}" oninput="this.style.height = this.scrollHeight + 'px';">$debate[affirmpoint]</textarea></div>
	</div>
	<div class="tszt_fbxm cl">
		<div class="fbxm_xmbt z">{lang debate_opponent_point}</div>
		<div class="fbxm_xmnr z"><textarea name="negapoint" id="negapoint" class="txt" placeholder="{$n5app['lang']['sqfbqingsrnr']}" oninput="this.style.height = this.scrollHeight + 'px';">$debate[negapoint]</textarea></div>
	</div>
	<div class="tszt_fbxm cl">
		<div class="fbxm_xmbt z">{lang endtime}</div>
		<div class="fbxm_xmnr z"><input type="text" name="endtime" id="endtime" class="px" placeholder="{$n5app['lang']['sqfbqszsjs']}" autocomplete="off" value="$debate[endtime]"  /></div>
	</div>
	<div class="tszt_fbxm cl">
		<div class="fbxm_xmbt z">{$n5app['lang']['sqtsfbbl']}{lang debate_umpire}</div>
		<div class="fbxm_xmnr z"><input type="text" name="umpire" id="umpire" class="px" placeholder="{$n5app['lang']['sqbianlunblcp']}" value="$debate[umpire]"  /></div>
	</div>
</div>