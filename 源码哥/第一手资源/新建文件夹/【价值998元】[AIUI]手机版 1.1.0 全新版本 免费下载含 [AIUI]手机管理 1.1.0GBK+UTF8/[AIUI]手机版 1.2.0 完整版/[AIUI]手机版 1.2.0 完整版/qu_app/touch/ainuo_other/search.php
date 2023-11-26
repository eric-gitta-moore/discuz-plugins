<?PHP exit('QQÈº£º550494646');?>
<form id="searchform" class="searchform" method="post" autocomplete="off" action="search.php?mod=forum&mobile=2">
    <input type="hidden" name="formhash" value="{FORMHASH}" />
        <!--{if !empty($srchtype)}--><input type="hidden" name="srchtype" value="$srchtype" /><!--{/if}-->
        <div class="ainuo_search">
                <table width="100%" cellspacing="0" cellpadding="0">
                    <tbody>
                        <tr>
                            <td>
                                <input value="$keyword" autocomplete="off" class="input" name="srchtxt" id="scform_srchtxt" value="" placeholder="{lang searchthread}">
                            </td>
                            <td align="center" class="s_btn">
                                <input type="hidden" name="searchsubmit" value="yes">
                                <button type="submit" id="scform_submit"><i class="fa fa-search"></i></button>
                            </td>
                        </tr>
                    </tbody>
                </table>
        </div>
</form>