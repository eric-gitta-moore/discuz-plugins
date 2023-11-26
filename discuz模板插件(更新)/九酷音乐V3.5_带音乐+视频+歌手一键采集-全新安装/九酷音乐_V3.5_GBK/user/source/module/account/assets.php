<?php
	include "../source/global/global_inc.php";
        global $db;
	VerifyLogin($qianwei_in_userid);
	$new = SafeRequest("new","get");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
<title>个人账户 - <?php echo cd_webname; ?></title>
<link type="text/css" href="<?php echo cd_upath; ?>static/css/core.css" rel="stylesheet" />
<link type="text/css" href="<?php echo cd_upath; ?>static/site/css/common.css" rel="stylesheet" />
<link type="text/css" href="<?php echo cd_upath; ?>static/space/css/common.css" rel="stylesheet" media="all" />
<link type="text/css" href="<?php echo cd_upath; ?>static/space/css/user.css" rel="stylesheet" media="all" />
<script type="text/javascript">
var domIsReady=false,domReadyList=[],domReadyObject=[],$call=function(callback,obj){if(typeof obj!=='object'){obj=document}if(domIsReady){callback.call(obj)}else{domReadyList.push(callback);domReadyObject.push(obj)}};
var site_domain="<?php echo cd_webpath; ?>";zone_domain="<?php echo cd_upath; ?>";
</script>
</head>
<body>
<div class="header"><?php include "source/module/system/header.php"; ?></div>
<div class="user">
	<div class="user_center">
		<div class="user_menu" id="account">
			<?php include "source/module/system/left_menu.php"; ?>
		</div>
		<div class="user_main">
			<div class="uMain_content">
				<div class="main_nav">
					<ul>
						<li class="me_account">
							<a class="on" href="<?php echo cd_upath.rewrite_url('index.php?p=account&a=assets'); ?>">个人账户</a>
						</li>
						<li class="me_score">
							<a href="<?php echo cd_upath.rewrite_url('index.php?p=account&a=scoreBill'); ?>">积分账单</a>
						</li>
					</ul>
				</div>
				<div class="main">
					<div id="tooltip" class="refresh">
					</div>
				</div>
					<div class="minHeight500">
						<div id="modifyProfile" class="account">
							<div class="title">积分详情</div>
							<?php
								$sql="select sum(cd_points) from ".tname('bill')." where cd_type=1 and cd_uid='$qianwei_in_userid' and DateDiff(DATE(cd_endtime),'".getupdatetime()."')=0";
								if($res = $db->query($sql)){
									list($sum)=mysql_fetch_row($res);
									mysql_free_result($res);
									if($sum){
										$sum_yes = $sum;
									}else{
										$sum_yes = '0';
									}
								}
							?>
							<div class="condition"><span>提醒：</span>您有 <strong><?php echo $sum_yes; ?></strong> 积分将在<strong><?php echo getupdatetime(); ?></strong>过期，请您及时消费掉将要过期的积分。</div>

							<div>
								<div class="available">可以使用的积分<span><?php echo $qianwei_in_points; ?></span></div>
								<div class="will">将要过期的积分<span><?php echo $sum_yes; ?></span></div>
								<div class="not">未领取的积分<span>
								<?php
								$sql="select sum(cd_points) from ".tname('bill')." where cd_type=1 and cd_state=1 and cd_uid='$qianwei_in_userid'";
								if($res = $db->query($sql)){
									list($sum_no)=mysql_fetch_row($res);
									mysql_free_result($res);
									if($sum_no){
										echo $sum_no;
									}else{
										echo '0';
									}
								}
								?></span></div>
							</div>
							<div class="remark">
								<p><b></b>部分获得的积分需到"账户"中领取，"账户"中超过7天未领取的积分将被清除.<br/><b></b>每年1月1日清空上一年7月1日以前获得的积分，每年7月1日清空当年1月1日以前获得的积分。</p>
								<button class="receive" id="obtain">领取积分</button>
							</div>
						</div>
						<div class="member">
							<div class="member_left">
								<div class="title">用户信息</div>
								<div class="rank">
									<div class="yellow">
										<span>用户等级：<?php echo getmrank($qianwei_in_rank); ?>&nbsp;&nbsp;&nbsp;&nbsp;经验值<?php echo $qianwei_in_rank; ?></span>
										<div class="rank_box">
											<p<?php if($qianwei_in_rank){ echo ' style="width:'.getmrank($qianwei_in_rank,4).';"';} ?>></p>
										</div>
										<span class="share"><?php echo getmrank($qianwei_in_rank,4); ?></span>
									</div>
									<div class="green">
										<span>分享等级：<?php echo getdancerank($qianwei_in_musicnum); ?>&nbsp;&nbsp;&nbsp;&nbsp;经验值<?php echo $qianwei_in_musicnum; ?></span>
										<div class="rank_box">
											<p<?php if($qianwei_in_musicnum){ echo ' style="width:'.getdancerank($qianwei_in_musicnum,4).';"';} ?>></p>
										</div>
										<span class="share"><?php echo getdancerank($qianwei_in_musicnum,4); ?></span>
									</div>
									<div class="blue">
										<span>评审等级：Lv0&nbsp;&nbsp;&nbsp;&nbsp;经验值0</span>
										<div class="rank_box">
											<p ></p>
										</div>
										<span class="share">0%</span>
									</div>
								</div>
							</div>
							<div class="member_right">
								<div class="title">VIP会员成长信息</div>
								<?php if($qianwei_in_grade==1){ ?>
									<div class="rank">
										<div class="rank_box">
											<div class="vip"></div>
											<ul>
												<?php if(getviprank($qianwei_in_viprank,0)==1){ ?>
													<li class="go1">
														<p style="width:<?php echo getviprank($qianwei_in_viprank,1); ?>;"></p>
														<div class="share" style="top:38px;left:0%;"><?php echo $qianwei_in_viprank; ?></div>
													</li>
												<?php }else{ ?>
													<li class="<?php if(getviprank($qianwei_in_viprank,0)>=1){ echo 'go1'; }else{ echo 'vip1'; }?>">
														<p style="width:0%;"></p>
														<div class="share" style="top:38px;left:0%;display: none;">0</div>
													</li>
												<?php } ?>

												<?php if(getviprank($qianwei_in_viprank,0)==2){ ?>
													<li class="go2">
														<p style="width:<?php echo getviprank($qianwei_in_viprank,1); ?>;"></p>
														<div class="share" style="top:38px;left:0%;"><?php echo $qianwei_in_viprank; ?></div>
													</li>
												<?php }else{ ?>
													<li class="<?php if(getviprank($qianwei_in_viprank,0)>=2){ echo 'go2'; }else{ echo 'vip2'; }?>">
														<p style="width:0%;"></p>
														<div class="share" style="top:38px;left:0%;display: none;">0</div>
													</li>
												<?php } ?>

												<?php if(getviprank($qianwei_in_viprank,0)==3){ ?>
													<li class="go3">
														<p style="width:<?php echo getviprank($qianwei_in_viprank,1); ?>;"></p>
														<div class="share" style="top:38px;left:0%;"><?php echo $qianwei_in_viprank; ?></div>
													</li>
												<?php }else{ ?>
													<li class="<?php if(getviprank($qianwei_in_viprank,0)>=3){ echo 'go3'; }else{ echo 'vip3'; }?>">
														<p style="width:0%;"></p>
														<div class="share" style="top:38px;left:0%;display: none;">0</div>
													</li>
												<?php } ?>

												<?php if(getviprank($qianwei_in_viprank,0)==4){ ?>
													<li class="go4">
														<p style="width:<?php echo getviprank($qianwei_in_viprank,1); ?>;"></p>
														<div class="share" style="top:38px;left:0%;"><?php echo $qianwei_in_viprank; ?></div>
													</li>
												<?php }else{ ?>
													<li class="<?php if(getviprank($qianwei_in_viprank,0)>=4){ echo 'go4'; }else{ echo 'vip4'; }?>">
														<p style="width:0%;"></p>
														<div class="share" style="top:38px;left:0%;display: none;">0</div>
													</li>
												<?php } ?>

												<?php if(getviprank($qianwei_in_viprank,0)==5){ ?>
													<li class="go5">
														<p style="width:<?php echo getviprank($qianwei_in_viprank,1); ?>;"></p>
														<div class="share" style="top:38px;left:0%;"><?php echo $qianwei_in_viprank; ?></div>
													</li>
												<?php }else{ ?>
													<li class="<?php if(getviprank($qianwei_in_viprank,0)>=5){ echo 'go5'; }else{ echo 'vip5'; }?>">
														<p style="width:0%;"></p>
														<div class="share" style="top:38px;left:0%;display: none;">0</div>
													</li>
												<?php } ?>


												<?php if(getviprank($qianwei_in_viprank,0)==6){ ?>
													<li class="go6">
														<p style="width:<?php echo getviprank($qianwei_in_viprank,1); ?>;"></p>
														<div class="share" style="top:38px;left:0%;"><?php echo $qianwei_in_viprank; ?></div>
													</li>
												<?php }else{ ?>
													<li class="<?php if(getviprank($qianwei_in_viprank,0)>=6){ echo 'go6'; }else{ echo 'vip6'; }?>">
														<p style="width:0%;"></p>
														<div class="share" style="top:38px;left:0%;display: none;">0</div>
													</li>
												<?php } ?>


												<?php if(getviprank($qianwei_in_viprank,0)==7){ ?>
													<li class="go7">
														<p style="width:<?php echo getviprank($qianwei_in_viprank,1); ?>;"></p>
														<div class="share" style="top:38px;left:0%;"><?php echo $qianwei_in_viprank; ?></div>
													</li>
												<?php }else{ ?>
													<li class="<?php if(getviprank($qianwei_in_viprank,0)>=7){ echo 'go7'; }else{ echo 'vip7'; }?>">
														<p style="width:0%;"></p>
														<div class="share" style="top:38px;left:0%;display: none;">0</div>
													</li>
												<?php } ?>


												<?php if(getviprank($qianwei_in_viprank,0)==8){ ?>
													<li class="go8">
														<p style="width:<?php echo getviprank($qianwei_in_viprank,1); ?>;"></p>
														<div class="share" style="top:38px;left:0%;"><?php echo $qianwei_in_viprank; ?></div>
													</li>
												<?php }else{ ?>
													<li class="<?php if(getviprank($qianwei_in_viprank,0)>=8){ echo 'go8'; }else{ echo 'vip8'; }?>">
														<p style="width:0%;"></p>
														<div class="share" style="top:38px;left:0%;display: none;">0</div>
													</li>
												<?php } ?>


												<?php if(getviprank($qianwei_in_viprank,0)==9){ ?>
													<li class="go9">
														<p style="width:<?php echo getviprank($qianwei_in_viprank,1); ?>;"></p>
														<div class="share" style="top:38px;left:0%;"><?php echo $qianwei_in_viprank; ?></div>
													</li>
												<?php }else{ ?>
													<li class="<?php if(getviprank($qianwei_in_viprank,0)>=9){ echo 'go9'; }else{ echo 'vip9'; }?>">
														<p style="width:0%;"></p>
														<div class="share" style="top:38px;left:0%;display: none;">0</div>
													</li>
												<?php } ?>


												<?php if(getviprank($qianwei_in_viprank,0)==10){ ?>
													<li class="go10">
														<p style="width:<?php echo getviprank($qianwei_in_viprank,1); ?>;"></p>
														<div class="share" style="top:38px;left:0%;"><?php echo $qianwei_in_viprank; ?></div>
													</li>
												<?php }else{ ?>
													<li class="<?php if(getviprank($qianwei_in_viprank,0)>=10){ echo 'go10'; }else{ echo 'vip10'; }?>">
														<p style="width:0%;"></p>
														<div class="share" style="top:38px;left:0%;display: none;">0</div>
													</li>
												<?php } ?>
											</ul>
										</div>

										<?php
											if($qianwei_in_vipgrade==1){
												$cd_viptitle = 'VIP月付会员';
												$cd_speed = '5';
											}elseif($qianwei_in_vipgrade==2){
												$cd_viptitle = 'VIP年付会员';
												$cd_speed = '10';
											}
										?>

										<div class="text">
											<p><span class="green">成长值：</span>您的总成长值为&nbsp;<b><?php echo $qianwei_in_viprank; ?></b>，预计<b><?php echo sprintf("%01.0f",(getviprank($qianwei_in_viprank,3)-$qianwei_in_viprank)/$cd_speed); ?></b>天后即可成为尊贵<b>VIP<?php echo getviprank($qianwei_in_viprank,0)+1; ?></b></p>
											<p>
												<span class="green">成长速度：</span>
												<b>年付会员&nbsp;&nbsp;&nbsp;10</b>&nbsp;点/天&nbsp;&nbsp;&nbsp;&nbsp;<b>月付会员&nbsp;&nbsp;&nbsp;5&nbsp;</b>点/天<br/>
												您是<b><?php echo $cd_viptitle; ?></b>，当前成长速度&nbsp;<?php echo '<b>'.$cd_speed.'</b>'; ?>&nbsp;点/天&nbsp;
											</p>
											<p style="margin-top:6px;"><span class="green">充值VIP：</span><span class="renew" id="recharge">充值</span></p>
										</div>
									</div>
								<?php }else{ ?>
									<?php if($qianwei_in_viprank>=1){ ?>
										<div class="rankno">
											<div class="rank_box">
												<div class="vip"></div>
												<ul>
													<?php for($k=1;$k<=10;$k++){ ?>
														<?php if(getviprank($qianwei_in_viprank,0)==$k){ ?>
															<li class="go<?php echo $k; ?>">
																<p style="width:<?php echo getviprank($qianwei_in_viprank,1); ?>;"></p>
																<div class="share" style="top:38px;left:0%;"><?php echo $qianwei_in_viprank; ?></div>
														</li>
														<?php }else{ ?>
															<li class="<?php if(getviprank($qianwei_in_viprank,0)>=$k){ echo 'go'.$k; }else{ echo 'vip'.$k; }?>">
																<p style="width:0%;"></p>
																<div class="share" style="top:38px;left:0%;display: none;">0</div>
															</li>
														<?php } ?>
													<?php } ?>
												</ul>
											</div>
											<?php
												if($qianwei_in_vipgrade==1){
													$cd_viptitle = 'VIP月付会员';
													$cd_speed = '5';
												}elseif($qianwei_in_vipgrade==2){
													$cd_viptitle = 'VIP年付会员';
													$cd_speed = '10';
												}
											?>
											<div class="text">
												<p><span class="green">成长值：</span>您的总成长值为&nbsp;<b><?php echo $qianwei_in_viprank; ?></b>，充值即可成为尊贵<b>VIP<?php echo getviprank($qianwei_in_viprank,0); ?></b></p>
												<p>
													<span class="green">成长速度：</span>
													<b>年付会员&nbsp;&nbsp;&nbsp;10</b>&nbsp;点/天&nbsp;&nbsp;&nbsp;&nbsp;<b>月付会员&nbsp;&nbsp;&nbsp;5&nbsp;</b>点/天<br/>
													您的VIP会员已过期，当前成长值正以&nbsp;<b>5</b>&nbsp;点/天的速度下降&nbsp;
												</p>
												<p style="margin-top:6px;"><span class="green">充值VIP：</span><span class="renew" id="recharge">充值</span></p>
											</div>
										</div>
									<?php }else{ ?>
										<div class="rankno">
											<div class="rank_box">
												<div class="vip"></div>
												<ul>
													<?php for($k=1;$k<=10;$k++){ ?>
														<li class="vip<?php echo $k; ?>">
															<p style="width:0%;"></p>
															<div class="share" style="top:38px;left:0%;display: none;">0</div>
														</li>
													<?php } ?>
												</ul>
											</div>
											<div class="text">
												<p><span class="green">成长值：</span>您的总成长值为&nbsp;<b>0</b>，充值即可成为尊贵<b>VIP1</b></p>
												<p><span class="green">成长速度：</span><b>年付会员&nbsp;&nbsp;&nbsp;10</b>&nbsp;点/天&nbsp;&nbsp;&nbsp;&nbsp;<b>月付会员&nbsp;&nbsp;&nbsp;5&nbsp;</b>点/天<br/>（您还不是VIP，没有成长速度）</p>
												<p style="margin-top:6px;"><span class="green">充值VIP：</span><span class="renew" id="recharge">充值</span></p>
											</div>
										</div>
									<?php } ?>
								<?php } ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	<div class="user_copyright"><?php include "source/module/system/footer.php"; ?></div>
</div>
<script type="text/javascript" src="<?php echo cd_upath; ?>static/js/jquery/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo cd_upath; ?>static/js/core.js"></script>
<script type="text/javascript" src="<?php echo cd_upath; ?>static/js/card.js"></script>
<script type="text/javascript" src="<?php echo cd_upath; ?>static/js/dialog.js"></script>
<script type="text/javascript" src="<?php echo cd_upath; ?>static/js/jquery/jquery.plugins.js"></script>
<script type="text/javascript" src="<?php echo cd_upath; ?>static/space/js/common.js"></script>
<script type="text/javascript">listenMsg.start();nav.init();nav.userMenu();nav.helpNoticeInit();</script>
<script type="text/javascript" src="<?php echo cd_upath; ?>static/space/js/account.js"></script>
<script type="text/javascript">
	account.doAccountInit(); 
	account.vipRenewals(); 
	account.vipRecharge(); 
</script>
</body>
</html>