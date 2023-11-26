<?php echo 'www.ymg6.com,感谢大家的支持';?>
<!--{template common/header}-->
<script type="text/javascript" src="$_G['style'][styleimgdir]/js/jquery.flexslider-min.js"></script>
<script type="text/javascript">
            jq(document).ready(function(){
                jq('.flexslider').flexslider({
                    directionNav: true,
                    pauseOnAction: false
                });
            });
            </script>
<div class="wp">
	<!--[diy=diy1]--><div id="diy1" class="area"></div><!--[/diy]-->
    <div class="deanone">
    	<div class="w1180">
        	<div class="deanflash">
            	<div class="focusBox deanactions fadeInUp">
                	<!--[diy=focusBox]--><div id="focusBox" class="area"></div><!--[/diy]-->
                    
                    <a class="prev" href="javascript:void(0)"></a>
                    <a class="next" href="javascript:void(0)"></a>
                    <ul class="hd">
                        <li></li>
                        <li></li>
                        <li></li>
                        <li></li>
                        <li></li>
                    </ul>
            </div>
        
            <script type="text/javascript">
                jQuery(".focusBox").slide({ mainCell:".pic",effect:"left", autoPlay:true, delayTime:300});
            </script>
            </div>
            <div class="deandisplays">
            	<div class="deandisplaytop">
                	<div class="deandpl">原创作品推荐</div>
                    <div class="deandpnotice deanactions bounceInLeft">
                    	<!--[diy=deanrollgg]--><div id="deanrollgg" class="area"></div><!--[/diy]-->
                    	
                    </div>
                    <script type="text/javascript">
					jQuery(".deandpnotice").slide({ mainCell:".deanrollgg", effect:"topLoop", vis:1, opp:true, autoPlay:true, delayTime:800 });
					</script>
                    <div class="deanupload"><a onclick="showWindow('nav', this.href, 'get', 0)" href="forum.php?mod=misc&amp;action=nav">发布作品</a></div>
                    <div class="clear"></div>
                </div>
                <div class="deanzxlists">
                    <ul>
                    	<!--[diy=deanzxlists]--><div id="deanzxlists" class="area"></div><!--[/diy]-->
                        
                        
                        <div class="clear"></div>
                       
                    </ul>
                </div>
                <div class="jquery_pagnation"></div>
                <script type="text/javascript">
                    (function(dfsj_jq){
                        var dfsj_items = dfsj_jq('.deanzxlists li');
                        var dfsj_items2 = 16;
                        var total = dfsj_items.size();
                        total>0 && dfsj_jq('.jquery_pagnation').pagination({pagetotal:total,target:dfsj_items,perpage:dfsj_items2});
                        })(jQuery);
                </script>
            </div>
            
            
        </div>
    </div>
    
    <div class="deanshare">
        <div class="w1180">
            <div class="deandisplaytop">
                <div class="deandpl">经验分享</div>
                <div class="deanupload">
                	<ul>
                    	<li class="cur">设计教程</li>
                        <li>经验分享</li>
                        <li>视频教程</li>
                    </ul>
                </div>
                <div class="clear"></div>
            </div>
            <div class="deansharebottom">
            	<dl>
                	<dd style="display:block;">
                    	<div class="deanzxlists">
                            <ul>
                                <!--[diy=deanzxlists1]--><div id="deanzxlists1" class="area"></div><!--[/diy]-->
                                <div class="clear"></div>
                               
                            </ul>
                        </div>
                    </dd>
                    <dd>
                    	<div class="deanzxlists">
                            <ul>
                                <!--[diy=deanzxlists2]--><div id="deanzxlists2" class="area"></div><!--[/diy]-->
                                <div class="clear"></div>
                               
                            </ul>
                        </div>
                    </dd>
                    <dd>
                    	<div class="deanzxlists">
                            <ul>
                                <!--[diy=deanzxlists3]--><div id="deanzxlists3" class="area"></div><!--[/diy]-->
                                <div class="clear"></div>
                               
                            </ul>
                        </div>
                    </dd>
                </dl>
            </div>
            <script type="text/javascript">
	jq(".deanupload ul li").each(function(s){
		jq(this).hover(function(){
			jq(this).addClass("cur").siblings().removeClass("cur");
			jq(".deansharebottom dl dd").eq(s).show().siblings().hide();
			})
		})
</script>
        </div>
    </div>
    
    <div class="deantools">
    	<div class="w1180">
        	<div class="deantoolsbox">
            	<ul>
                	<li>
                    	<!--[diy=deantoolsbox]--><div id="deantoolsbox" class="area"></div><!--[/diy]-->
                    	
                    </li>
                    <li>
                    	<!--[diy=deantoolsbox1]--><div id="deantoolsbox1" class="area"></div><!--[/diy]-->
                    	
                    </li>
                    <li>
                    	<!--[diy=deantoolsbox2]--><div id="deantoolsbox2" class="area"></div><!--[/diy]-->
                    	
                    </li>
                    <li>
                    	<!--[diy=deantoolsbox3]--><div id="deantoolsbox3" class="area"></div><!--[/diy]-->
                    	
                    </li>
                    <div class="clear"></div>
                </ul>
            </div>
        </div>
    </div>
    
    <div class="deanwenzhang">
    	<div class="w1180">
        	<div class="deanwzl">
            	<div class="deanqiehuan">
                	<ul>
                    	<li class="curs">推荐文章</li>
                        <li>最新文章</li>
                        <div class="clear"></div>
                    </ul>
                </div>
                <div class="deannewslists">
                	<dl>
                    	<dd style="display:block;">
                        	<div class="deanwzlists">
                                <ul>
                                	<!--[diy=deanwzlists1x]--><div id="deanwzlists1x" class="area"></div><!--[/diy]-->
                                    
                                </ul>
                            </div>
                        </dd>
                        <dd>
                        	<div class="deanwzlists">
                                <ul>
                                    <!--[diy=deanwzlists1x1]--><div id="deanwzlists1x1" class="area"></div><!--[/diy]-->
                                </ul>
                            </div>
                        </dd>
                    </dl>
                </div>
                 <script type="text/javascript">
					jq(".deanqiehuan ul li").each(function(s){
						jq(this).hover(function(){
							jq(this).addClass("curs").siblings().removeClass("curs");
							jq(".deannewslists dl dd").eq(s).show().siblings().hide();
							})
						})
				</script>
            </div>
            <div class="deanwzr">
            	<div class="deannewintros deanactions bounceInUp">
                	<div class="deannewitop"><a href="#" target="_blank"><img width="285" src="$_G['style'][styleimgdir]/xinshou.png" /></a></div>
                    <div class="deannewibottom">
                    	<ul>
                        	 <!--[diy=deannewibottom]--><div id="deannewibottom" class="area"></div><!--[/diy]-->
                        	
                        </ul>
                    </div>
                </div>
                <div class="deannewintros deanactions bounceInUp">
                	<div class="deannewitop"><a href="#" target="_blank"><img width="285" src="$_G['style'][styleimgdir]/sj520_app_in.png" /></a></div>
                    <div class="deannewibottom">
                    	<ul>
                        	<!--[diy=deannewibottom1]--><div id="deannewibottom1" class="area"></div><!--[/diy]-->
                        	
                        </ul>
                    </div>
                </div>
                <div class="deannewintros deanactions bounceInUp">
                	<div class="deannewitop"><a href="#" target="_blank"><img width="285" src="$_G['style'][styleimgdir]/sj520_sc.png" /></a></div>
                    <div class="deannewibottom">
                    	<div class="deanin_dl"> 
                        	<!--[diy=deanin_dl]--><div id="deanin_dl" class="area"></div><!--[/diy]-->
                           
                         </div>
                    </div>
                </div>
            </div>
            <div class="clear"></div>
        </div>
    </div>
    
    <div class="deanone" style="margin-top:50px;">
        <div class="w1180">
            <div class="deandisplaytop">
                <div class="deandpl">灵感创意</div>
                <div class="deanmorebutton">
                	<a href="#" target="_blank">更多》</a>
                </div>
                <div class="clear"></div>
            </div>
            <div class="deanzxlists">
                <ul>
                	<!--[diy=deanin_dl2]--><div id="deanin_dl2" class="area"></div><!--[/diy]-->
                    
                    <div class="clear"></div>
                </ul>
            </div>
            
            <div class="deandesigners deanactions bounceInLeft">
            	<div class="design_r_title">
                    <h2>推荐设计师</h2>
                    <a href="#" target="_blank">更多<b>&gt;&gt;</b></a>
                </div>
                <div class="design_r_list">
                	<!--[diy=design_r_list]--><div id="design_r_list" class="area"></div><!--[/diy]-->
                    
                </div>
            </div>        	
            <div class="deandesignbrands deanactions bounceInRight">
            	<div class="design_r_title">
                    <h2>推荐品牌</h2>
                    <a href="#" target="_blank">更多<b>&gt;&gt;</b></a>
                </div>
                <div class="deanbrands">
                	<!--[diy=deanbrands]--><div id="deanbrands" class="area"></div><!--[/diy]-->
                	
                    <div class="clear"></div>
                </div>
            </div>   
            <div class="clear"></div>  
            
            <div class="deanads"><!--[diy=deanads1]--><div id="deanads1" class="area"></div><!--[/diy]--></div> 
            
            <div class="deanfriendlinks">
            	<div class="design_r_title">
                    <h2>友情链接</h2>
                    <a href="#" target="_blank">更多<b>&gt;&gt;</b></a>
                </div>
                <div class="design_ra"><!--[diy=design_ra]--><div id="design_ra" class="area"></div><!--[/diy]--></div>
                <div class="clear"></div>
                </div>
            </div>  
        </div>
    </div>
</div>

<script src="misc.php?mod=diyhelp&action=get&type=index&diy=yes&r={echo random(4)}" type="text/javascript"></script>
<!--{template common/footer}-->

