<?php (!defined('IN_SANREE')&&exit('Power By ymg6.Com'))?>
{subtemplate common/header}	
<div class="viewconsumer">
  <h3 class="flb mn sr"><em>{lang sanree_brand_coupon:viewconsumer}</em> <span>    
    <a href="javascript:;" class="flbc" onclick="hideWindow('viewdlg', 0, 1);" title="{lang close}">{lang close}</a>
    </span> </h3>
  <div class="item">
    <table class="fire" border="1" bordercolor="E6E6E6" cellpadding="3" cellspacing="0">  		
      <tr class="bitian">
        <td class="lefttip">{lang sanree_brand_coupon:printlogid}</td>
        <td colspan="2" class="rightcontent">{$result['printlogid']}</td>
      </tr>	
      <tr class="bitian">
        <td class="lefttip">{lang sanree_brand_coupon:printcode1}</td>
        <td colspan="2" class="rightcontent">{$result['printcode']}</td>
      </tr>		  	
      <tr class="bitian">
        <td class="lefttip">{lang sanree_brand_coupon:status1}</td>
        <td colspan="2" class="rightcontent">{$result['status']}</td>
      </tr>	 
      <tr class="bitian">
        <td class="lefttip">{lang sanree_brand_coupon:printtime1}</td>
        <td colspan="2" class="rightcontent">{$result['dateline']}</td>
      </tr>	
      <tr class="bitian">
        <td class="lefttip">{lang sanree_brand_coupon:usedateline}</td>
        <td colspan="2" class="rightcontent">{$result['usedateline']}</td>
      </tr>	
      <tr class="bitian">
        <td class="lefttip">{lang sanree_brand_coupon:rebatesdate}</td>
        <td colspan="2" class="rightcontent">{$result['rebatesdate']}</td>
      </tr>		  	  	  		  	  	  	  	  	   	   
	 </table>
  </div>
</div>
{subtemplate common/footer}