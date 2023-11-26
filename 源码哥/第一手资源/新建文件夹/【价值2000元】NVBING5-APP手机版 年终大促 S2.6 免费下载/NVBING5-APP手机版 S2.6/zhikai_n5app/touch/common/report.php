<?php exit;?>
<!--{template common/header}-->
<!--{eval if(!function_exists('init_n5app'))include DISCUZ_ROOT.'./template/zhikai_n5app/lang.php';}-->
<div class="tip n5sq_ztjb">
<form id="report" method="post" autocomplete="off" action="misc.php?mod=report&modsubmit=yes&mobile=2" >
    <dt id="report_reasons" class="n5_xxjbys">
	    <ul>
			<li><input type="radio" name="message" value="{$n5app['lang']['jbgglj']}" /> {$n5app['lang']['jbgglj']}</li>
			<li><input type="radio" name="message" value="{$n5app['lang']['jbxjnr']}" /> {$n5app['lang']['jbxjnr']}</li>
			<li><input type="radio" name="message" value="{$n5app['lang']['jbwgnr']}" /> {$n5app['lang']['jbwgnr']}</li>
			<li><input type="radio" name="message" value="{$n5app['lang']['jbeygs']}" /> {$n5app['lang']['jbeygs']}</li>
			<li><input type="radio" name="message" value="{$n5app['lang']['jbcfft']}" /> {$n5app['lang']['jbcfft']}</li>
		</ul>
	</dt>
	<dd><input type="submit" class="formdialog button2" name="report_submit" id="report_submit"  value="{lang confirms}"><a href="javascript:;" onclick="popup.close();">{lang cancel}</a></dd>
	<input type="hidden" name="referer" value="{echo dreferer()}" />
	<input type="hidden" name="reportsubmit" value="true" />
	<input type="hidden" name="rtype" value="$_GET[rtype]" />
	<input type="hidden" name="rid" value="$_GET[rid]" />
	<!--{if $_GET['fid']}-->
	<input type="hidden" name="fid" value="$_GET[fid]" />
	<!--{/if}-->
	<!--{if $_GET['uid']}-->
	<input type="hidden" name="uid" value="$_GET[uid]" />
	<!--{/if}-->
	<input type="hidden" name="url" value="$_GET[url]" />
	<input type="hidden" name="inajax" value="$_G[inajax]" />
	<input type="hidden" name="formhash" value="{FORMHASH}" />
</form>
</div>
<!--{template common/footer}-->