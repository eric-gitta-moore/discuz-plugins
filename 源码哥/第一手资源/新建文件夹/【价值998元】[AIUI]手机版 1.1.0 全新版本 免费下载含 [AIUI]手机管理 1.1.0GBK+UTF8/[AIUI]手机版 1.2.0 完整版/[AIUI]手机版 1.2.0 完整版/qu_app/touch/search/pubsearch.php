<?PHP exit('QQÈº£º550494646');?>
<!--{eval $keywordenc = $keyword ? rawurlencode($keyword) : '';}-->
<!--{if $searchid || ($_GET['adv'] && CURMODULE == 'forum')}-->
<div class="ainuo_searchtb cl">
        <!--{if $_G['setting']['portalstatus'] && $_G['setting']['search']['portal']['status'] && ($_G['group']['allowsearch'] & 1 || $_G['adminid'] == 1)}--><!--{block slist[portal]}--><a href="search.php?mod=portal{if $keyword}&srchtxt=$keywordenc&searchsubmit=yes{/if}"{if CURMODULE == 'portal'} class="a"{/if}>{lang portal}</a><!--{/block}--><!--{/if}-->
        <!--{if $_G['setting']['search']['forum']['status'] && ($_G['group']['allowsearch'] & 2 || $_G['adminid'] == 1)}--><!--{block slist[forum]}--><a href="search.php?mod=forum{if $keyword}&srchtxt=$keywordenc&searchsubmit=yes{/if}"{if CURMODULE == 'forum'} class="a"{/if}>{lang thread}</a><!--{/block}--><!--{/if}-->
        <!--{if helper_access::check_module('blog') && $_G['setting']['search']['blog']['status'] && ($_G['group']['allowsearch'] & 4 || $_G['adminid'] == 1)}--><!--{block slist[blog]}--><a href="search.php?mod=blog{if $keyword}&srchtxt=$keywordenc&searchsubmit=yes{/if}"{if CURMODULE == 'blog'} class="a"{/if}>{lang blog}</a><!--{/block}--><!--{/if}-->
        <!--{if helper_access::check_module('album') && $_G['setting']['search']['album']['status'] && ($_G['group']['allowsearch'] & 8 || $_G['adminid'] == 1)}--><!--{block slist[album]}--><a href="search.php?mod=album{if $keyword}&srchtxt=$keywordenc&searchsubmit=yes{/if}"{if CURMODULE == 'album'} class="a"{/if}>{lang album}</a><!--{/block}--><!--{/if}--><!--From www.m oq u8 .com -->
        <!--{if $_G['setting']['groupstatus'] && $_G['setting']['search']['group']['status'] && ($_G['group']['allowsearch'] & 16 || $_G['adminid'] == 1)}--><!--{block slist[group]}--><a href="search.php?mod=group{if $keyword}&srchtxt=$keywordenc&searchsubmit=yes{/if}"{if CURMODULE == 'group'} class="a"{/if}>$_G['setting']['navs'][3]['navname']</a><!--{/block}--><!--{/if}-->
        <!--{echo implode("", $slist);}-->
</div>
<div class="grey_line cl"></div>

<div class="as cl">
	<table id="scform" cellspacing="0" cellpadding="0" width="100%">
		<tr>

						<td class="td_srchtxt"><input type="text" id="scform_srchtxt" name="srchtxt" class="px" value="$keyword" placeholder="{lang enter_content}" tabindex="1" x-webkit-speech speech /></td>
						<td class="td_srchbtn"><input type="hidden" name="searchsubmit" value="yes" /><button type="submit" id="scform_submit" class="schbtn">{lang search}</button></td>

		</tr>
	</table>
</div>
		<!--{if $_G['setting']['srchhotkeywords']}-->
        <div class="slist cl">
        {eval $snum = 0;}
          <!--{loop $_G['setting']['srchhotkeywords'] $val}-->
          {eval $snum++;}
          {eval $snum = ($snum)%5}
              <!--{if $val=trim($val)}-->
                  <!--{eval $valenc=rawurlencode($val);}-->

                      <!--{if !empty($searchparams[url])}-->
                          <a href="$searchparams[url]?q=$valenc&source=hotsearch{$srchotquery}" class="bg_{$snum}" sc="1">$val</a>
                      <!--{else}-->
                          <a href="search.php?mod=forum&srchtxt=$valenc&formhash={FORMHASH}&searchsubmit=true&source=hotsearch" class="bg_{$snum}" sc="1">$val</a>
                      <!--{/if}-->

              <!--{/if}-->
          <!--{/loop}-->
       </div>
          <!--{echo implode('', $srchhotkeywords);}-->
      <!--{/if}-->
<!--{else}-->
	<!--{if !empty($srchtype)}--><input type="hidden" name="srchtype" value="$srchtype" /><!--{/if}-->
	<!--{if $srchtype != 'threadsort'}-->
        <div class="ainuo_searchtb cl">
            <!--{if helper_access::check_module('portal') && $_G['setting']['search']['portal']['status'] && ($_G['group']['allowsearch'] & 1 || $_G['adminid'] == 1)}--><!--{block slist[portal]}--><a href="search.php?mod=portal{if $keyword}&srchtxt=$keywordenc&searchsubmit=yes{/if}"{if CURMODULE == 'portal'} class="a"{/if}>{lang portal}</a><!--{/block}--><!--{/if}-->
            <!--{if $_G['setting']['search']['forum']['status'] && ($_G['group']['allowsearch'] & 2 || $_G['adminid'] == 1)}--><!--{block slist[forum]}--><a href="search.php?mod=forum{if $keyword}&srchtxt=$keywordenc&searchsubmit=yes{/if}"{if CURMODULE == 'forum'} class="a"{/if}>{lang thread}</a><!--{/block}--><!--{/if}-->
            <!--{if helper_access::check_module('blog') && $_G['setting']['search']['blog']['status'] && ($_G['group']['allowsearch'] & 4 || $_G['adminid'] == 1) && helper_access::check_module('blog')}--><!--{block slist[blog]}--><a href="search.php?mod=blog{if $keyword}&srchtxt=$keywordenc&searchsubmit=yes{/if}"{if CURMODULE == 'blog'} class="a"{/if}>{lang blog}</a><!--{/block}--><!--{/if}-->
            <!--{if helper_access::check_module('album') && $_G['setting']['search']['album']['status'] && ($_G['group']['allowsearch'] & 8 || $_G['adminid'] == 1) && helper_access::check_module('album')}--><!--{block slist[album]}--><a href="search.php?mod=album{if $keyword}&srchtxt=$keywordenc&searchsubmit=yes{/if}"{if CURMODULE == 'album'} class="a"{/if}>{lang album}</a><!--{/block}--><!--{/if}-->
            <!--{if helper_access::check_module('group') && $_G['setting']['search']['group']['status'] && ($_G['group']['allowsearch'] & 16 || $_G['adminid'] == 1)}--><!--{block slist[group]}--><a href="search.php?mod=group{if $keyword}&srchtxt=$keywordenc&searchsubmit=yes{/if}"{if CURMODULE == 'group'} class="a"{/if}>$_G['setting']['navs'][3]['navname']</a><!--{/block}--><!--{/if}-->
           
            <!--{echo implode("", $slist);}-->
        </div>
        <div class="grey_line cl"></div>
            
        <div class="as cl">
            <table id="scform" cellspacing="0" cellpadding="0" style="margin: 0 auto;" width="100%">
                <tr>
                    <td class="td_srchtxt"><input type="text" id="scform_srchtxt" name="srchtxt" value="$keyword"  placeholder="{lang enter_content}" class="px" tabindex="1" /></td>
                    <td class="td_srchbtn"><input type="hidden" name="searchsubmit" value="yes" /><button type="submit" id="scform_submit" value="true">{lang search}</button></td>
                </tr>
            </table>
        </div>
        <!--{if $_G['setting']['srchhotkeywords']}-->
            <div class="slist cl">
            {eval $snum = 0;}
              <!--{loop $_G['setting']['srchhotkeywords'] $val}-->
              {eval $snum++;}
              {eval $snum = $snum % 5}
                  <!--{if $val=trim($val)}-->
                      <!--{eval $valenc=rawurlencode($val);}-->
                          <!--{if !empty($searchparams[url])}-->
                              <a href="$searchparams[url]?q=$valenc&source=hotsearch{$srchotquery}" class="bg_{$snum}" sc="1">$val</a>
                          <!--{else}-->
                              <a href="search.php?mod=forum&srchtxt=$valenc&formhash={FORMHASH}&searchsubmit=true&source=hotsearch" class="bg_{$snum}" sc="1">$val</a>
                          <!--{/if}-->
                  <!--{/if}-->
              <!--{/loop}-->
            </div>
        <!--{/if}-->
	<!--{/if}-->
<!--{/if}-->
<!--{if CURMODULE == 'forum'}-->
	<ul id="quick_sch_menu" class="p_pop" style="display: none;">
		<li><a href="search.php?mod=forum&srchfrom=3600&searchsubmit=yes">{lang search_quick_hour_1}</a></li>
		<li><a href="search.php?mod=forum&srchfrom=14400&searchsubmit=yes">{lang search_quick_hour_4}</a></li>
		<li><a href="search.php?mod=forum&srchfrom=28800&searchsubmit=yes">{lang search_quick_hour_8}</a></li>
		<li><a href="search.php?mod=forum&srchfrom=86400&searchsubmit=yes">{lang search_quick_hour_24}</a></li>
		<li><a href="search.php?mod=forum&srchfrom=604800&searchsubmit=yes">{lang search_quick_day_7}</a></li>
		<li><a href="search.php?mod=forum&srchfrom=2592000&searchsubmit=yes">{lang search_quick_day_30}</a></li>
		<li><a href="search.php?mod=forum&srchfrom=15552000&searchsubmit=yes">{lang search_quick_day_180}</a></li>
		<li><a href="search.php?mod=forum&srchfrom=31536000&searchsubmit=yes">{lang search_quick_day_365}</a></li>
	</ul>
<!--{/if}-->