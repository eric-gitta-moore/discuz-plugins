<?php exit;?>
<!--{template common/header}-->
<div class="tip">
<!--{if ($_GET['optgroup'] == 1 && $operation == '') || ($_GET['optgroup'] == 3 && $operation == 'delete') || ($_GET['optgroup'] == 4 && $operation == '') }-->
    <form id="moderateform" method="post" autocomplete="off" action="forum.php?mod=topicadmin&action=moderate&optgroup=$optgroup&modsubmit=yes&mobile=2" >
        <input type="hidden" name="frommodcp" value="$frommodcp" />
        <input type="hidden" name="formhash" value="{FORMHASH}" />
        <input type="hidden" name="fid" value="$_G[fid]" />
        <input type="hidden" name="redirect" value="{echo dreferer()}" />
        <input type="hidden" name="reason" value="{lang topicadmin_mobile_mod}" />
        <!--{loop $threadlist $thread}-->
            <input type="hidden" name="moderate[]" value="$thread[tid]" />
        <!--{/loop}-->
		<!--{if $_GET['optgroup'] == 1}-->
				<dt>
				<!--{if count($threadlist) > 1 || empty($defaultcheck[recommend])}-->
					<!--{if $_G['group']['allowstickthread']}-->
						<div class="n5sz_ztzd n5sz_ztjz cl">
							<div class="z cl">
								<div class="z cl"><input type="checkbox" id="sendreasonpm" name="operations[]" onclick="if(this.checked) switchitemcp('itemcp_stick')" value="stick" $defaultcheck[stick] /><label for="sendreasonpm"></label></div>
								<span onclick="switchitemcp('itemcp_stick')" class="n5sz_wzys">{lang thread_stick}</span>
							</div>
							<div class="y cl">
								<select class="ps" name="sticklevel">
								<!--{if $_G['forum']['status'] != 3}-->
									<option value="0">{lang none}</option>
									<option value="1" $stickcheck[1]>$_G['setting']['threadsticky'][2]</option>
								<!--{if $_G['group']['allowstickthread'] >= 2}-->
									<option value="2" $stickcheck[2]>$_G['setting']['threadsticky'][1]</option>
								<!--{if $_G['group']['allowstickthread'] == 3}-->
									<option value="3" $stickcheck[3]>$_G['setting']['threadsticky'][0]</option>
								<!--{/if}-->
								<!--{/if}-->
								<!--{else}-->
									<option value="0">{lang no}&nbsp;</option>
									<option value="1" $stickcheck[1]>{lang yes}&nbsp;</option>
								<!--{/if}-->
								</select>
							</div>
						</div>
					<!--{/if}-->
					<!--{if $_G['group']['allowdigestthread']}-->
						<div class="n5sz_ztjz cl">
							<div class="z cl">
								<div class="z cl"><input type="checkbox" id="sendreasonpma" name="operations[]" onclick="if(this.checked) switchitemcp('itemcp_digest')" value="digest" $defaultcheck[digest] /><label for="sendreasonpma"></label></div>
								<span onclick="switchitemcp('itemcp_digest')" class="n5sz_wzys">{lang admin_digest_add}</span>
							</div>
							<div class="y cl">
								<select class="ps" name="digestlevel">
									<option value="0">{lang admin_digest_remove}</option>
									<option value="1" $digestcheck[1]>{lang thread_digest} 1</option>
									<!--{if $_G['group']['allowdigestthread'] >= 2}-->
									<option value="2" $digestcheck[2]>{lang thread_digest} 2</option>
									<!--{if $_G['group']['allowdigestthread'] == 3}-->
									<option value="3" $digestcheck[3]>{lang thread_digest} 3</option>
									<!--{/if}-->
									<!--{/if}-->
								</select>
							</div>
						</div>
					<!--{/if}-->
				<!--{/if}-->
				</dt>
				<dd><input type="submit" name="modsubmit" id="modsubmit"  value="{lang confirms}" class="formdialog button2"><a href="javascript:;" onclick="popup.close();">{lang cancel}</a></dd>
        <!--{elseif $_GET['optgroup'] == 3}-->
            <!--{if $operation == 'delete'}-->
                <!--{if $_G['group']['allowdelpost']}-->
                    <input name="operations[]" type="hidden" value="delete"/>
                    <dt>{lang admin_delthread_confirm}</dt>
					<dd><input type="submit" class="formdialog button2" name="modsubmit" id="modsubmit"  value="{lang confirms}"><a href="javascript:;" onclick="popup.close();">{lang cancel}</a></dd>
                <!--{else}-->
                    <dt>{lang admin_delthread_nopermission}</dt>
                <!--{/if}-->
            <!--{/if}-->
		<!--{elseif $_GET['optgroup'] == 4}-->
				<dt>
                <p>
                    {lang expire}: <input type="text" name="expirationclose" id="expirationclose" class="px" autocomplete="off" value="$expirationclose"  />
                </p>
                <p>{lang admin_close_expire_comment}</p>
                <p>
                    <label><input type="radio" name="operations[]" class="pr" value="open" $closecheck[0] />{lang admin_open}</label></p>
                <p>
                    <label><input type="radio" name="operations[]" class="pr" value="close" $closecheck[1] />{lang admin_close}</label></p>
				</dt>
				<dd><input type="submit" name="modsubmit" id="modsubmit"  value="{lang confirms}" class="formdialog button2"><a href="javascript:;" onclick="popup.close();">{lang cancel}</a></dd>
        <!--{/if}-->
		
    </form>
<!--{else}-->
    	<dt>{lang admin_threadtopicadmin_error}</dt>
		<dd><input type="button" onclick="popup.close();" value="{lang confirms}" class="button2"></dd>
<!--{/if}-->
</div>
<!--{template common/footer}-->
