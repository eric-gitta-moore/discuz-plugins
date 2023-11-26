<?php
include "../source/global/global.php";
include "../source/global/global_function.php";

define('S_ROOT', dirname(__FILE__).'/../');
$step = empty($_GET['step']) ? 0 : intval($_GET['step']);
$charset = cd_charset;
$version = cd_version;
$build = cd_build;
$year = date('Y',time());

$lock = S_ROOT.'./data/install.xml';
if(file_exists($lock)) {
	show_msg('警告！您已经安装过QianWei Music！<br>为了保证数据安全，请立即删除 ../install/index.php 文件！<br>如果您想重新安装QianWei Music，请删除 ../data/install.xml 文件！', 999);
}
$sql = S_ROOT.'./install/table.sql';
if(!file_exists($sql)) {
	show_msg('缺少 ../install/table.sql 数据库结构文件，请检查！', 999);
}
$global = S_ROOT.'./source/global/global.php';
if(!@$fp = fopen($global, 'a')) {
	show_msg('文件 ../source/global/global.php 读写权限设置错误，请先设置为可写！', 999);
} else {
	@fclose($fp);
}
$globalconfig = S_ROOT.'./source/global/global_config.php';
if(!@$fp = fopen($globalconfig, 'a')) {
	show_msg('文件 ../source/global/global_config.php 读写权限设置错误，请先设置为可写！', 999);
} else {
	@fclose($fp);
}

if(empty($step)) {
	$phpos = PHP_OS;
	$phpversion = PHP_VERSION;
	$attachmentupload = @ini_get('file_uploads') ? '<td class="w pdleft1">'.ini_get('upload_max_filesize').'</td>' : '<td class="nw pdleft1">unknow</td>';
	if(function_exists('disk_free_space')) {
		$diskspace = '<td class="w pdleft1">'.floor(disk_free_space(S_ROOT) / (1024*1024)).'M</td>';
	} else {
		$diskspace = '<td class="nw pdleft1">unknow</td>';
	}
	$checkok = true;
	$perms = array();
	if(!checkfdperm(S_ROOT.'./source/global/global.php', 1)) {
		$perms['global'] = '<td class="nw pdleft1">不可写</td>';
		$checkok = false;
	} else {
		$perms['global'] = '<td class="w pdleft1">可写</td>';
	}
	if(!checkfdperm(S_ROOT.'./source/global/global_config.php', 1)) {
		$perms['globalconfig'] = '<td class="nw pdleft1">不可写</td>';
		$checkok = false;
	} else {
		$perms['globalconfig'] = '<td class="w pdleft1">可写</td>';
	}
	if(!checkfdperm(S_ROOT.'./client/ucenter.php', 1)) {
		$perms['ucenter'] = '<td class="nw pdleft1">不可写</td>';
		$checkok = false;
	} else {
		$perms['ucenter'] = '<td class="w pdleft1">可写</td>';
	}
	if(!checkfdperm(S_ROOT.'./data/')) {
		$perms['data'] = '<td class="nw pdleft1">不可写</td>';
		$checkok = false;
	} else {
		$perms['data'] = '<td class="w pdleft1">可写</td>';
	}
	if(!checkfdperm(S_ROOT.'./source/plugin/')) {
		$perms['plugin'] = '<td class="nw pdleft1">不可写</td>';
		$checkok = false;
	} else {
		$perms['plugin'] = '<td class="w pdleft1">可写</td>';
	}
	if(!checkfdperm(S_ROOT.'./template/')) {
		$perms['template'] = '<td class="nw pdleft1">不可写</td>';
		$checkok = false;
	} else {
		$perms['template'] = '<td class="w pdleft1">可写</td>';
	}
	$check_mysql_connect = (function_exists('mysql_connect') ? '<td class="w pdleft1">支持</td>' : '<td class="nw pdleft1">不支持</td>');
	$check_file_get_contents = (function_exists('file_get_contents') ? '<td class="w pdleft1">支持</td>' : '<td class="nw pdleft1">不支持</td>');
	$check_allow_url_fopen = (ini_get('allow_url_fopen') ? '<td class="w pdleft1">支持</td>' : '<td class="nw pdleft1">不支持</td>');
	show_header();
	print<<<END
	<div class="setup step1">
	<h2>开始安装</h2>
	<p>环境以及文件目录权限检查</p>
	</div>
	<div class="stepstat">
	<ul>
	<li class="current">检查安装环境</li>
	<li class="unactivated">创建数据库</li>
	<li class="unactivated">设置后台管理员</li>
	<li class="unactivated last">安装</li>
	</ul>
	<div class="stepstatbg stepstat1"></div>
	</div>
	</div>
	<div class="main">
	<div class="licenseblock">
	<div class="license">
	<h1>产品授权协议 适用于所有用户</h1>

	<p>版权所有 (c) 2008-$year 前卫音乐保留所有权利。</p>

	<p>感谢您选择QianWei Music。希望我们的努力能为您提供一个高效快速、强大的音乐系统解决方案。前卫音乐网址为 www.qianwei.in，产品官方讨论区网址为 www.qianwe.com。</p>

	<p>用户须知：本协议是您与前卫音乐之间关于您使用前卫音乐提供的软件产品及服务的法律协议。无论您是个人或组织、盈利与否、用途如何（包括以学习和研究为目的），均需仔细阅读本协议，包括免除或者限制前卫音乐的免责条款及对您的权利限制。请您审阅并接受或不接受本服务条款。如您不同意本服务条款及/或前卫音乐随时对其的修改，您应不使用或主动取消前卫音乐提供的产品。否则，您的任何对前卫音乐产品中的相关服务的注册、登陆、下载、查看等使用行为将被视为您对本服务条款全部的完全接受，包括接受前卫音乐对服务条款随时所做的任何修改。</p>

	<p>本服务条款一旦发生变更, 前卫音乐将在网页上公布修改内容。修改后的服务条款一旦在网站管理后台上公布即有效代替原来的服务条款。您可随时登陆前卫音乐官方论坛查阅最新版服务条款。如果您选择接受本条款，即表示您同意接受协议各项条件的约束。如果您不同意本服务条款，则不能获得使用本服务的权利。您若有违反本条款规定，前卫音乐有权随时中止或终止您对前卫音乐产品的使用资格并保留追究相关法律责任的权利。</p>

	<p>在理解、同意、并遵守本协议的全部条款后，方可开始使用前卫音乐产品。您可能与前卫音乐直接签订另一书面协议，以补充或者取代本协议的全部或者任何部分。</p>

	<p>前卫音乐拥有本软件的全部知识产权。本软件只供许可协议，并非出售。前卫音乐只允许您在遵守本协议各项条款的情况下复制、下载、安装、使用或者以其他方式受益于本软件的功能或者知识产权。</p>

	<h3>I. 协议许可的权利</h3>
	<ol>
	&nbsp;  <li>您可以在完全遵守本许可协议的基础上，将本软件应用于非商业用途，而不必支付软件版权许可费用。</li>
	&nbsp;  <li>您可以在协议规定的约束和限制范围内修改前卫音乐产品源代码(如果被提供的话)或界面风格以适应您的网站要求。</li>
	&nbsp;  <li>您拥有使用本软件构建的网站中全部会员资料、文章及相关信息的所有权，并独立承担与使用本软件构建的网站内容的审核、注意义务，确保其不侵犯任何人的合法权益，独立承担因使用前卫音乐软件和服务带来的全部责任，若造成前卫音乐或用户损失的，您应予以全部赔偿。</li>
	&nbsp;  <li>若您需将前卫音乐软件或服务用户商业用途，必须另行获得前卫音乐的书面许可，您在获得商业授权之后，您可以将本软件应用于商业用途，同时依据所购买的授权类型中确定的技术支持期限、技术支持方式和技术支持内容，自购买时刻起，在技术支持期限内拥有通过指定的方式获得指定范围内的技术支持服务。商业授权用户享有反映和提出意见的权力，相关意见将被作为首要考虑，但没有一定被采纳的承诺或保证。</li>
	&nbsp;  <li>您可以从前卫音乐提供的应用中心服务中下载适合您网站的应用程序，但应向应用程序开发者/所有者支付相应的费用。</li>
	</ol>

	<h3>II. 协议规定的约束和限制</h3>
	<ol>
	&nbsp;  <li>未获前卫音乐书面商业授权之前，不得将本软件用于商业用途（包括但不限于企业网站、经营性网站、以营利为目或实现盈利的网站）。购买商业授权请登陆www.qianwe.com参考相关说明，也可以发送邮件到web@qianwe.com了解详情。</li>
	&nbsp;  <li>不得对本软件或与之关联的商业授权进行出租、出售、抵押或发放子许可证。</li>
	&nbsp;  <li>无论如何，即无论用途如何、是否经过修改或美化、修改程度如何，只要使用前卫音乐产品的整体或任何部分，未经书面许可，页面页脚处的前卫音乐产品名称和前卫音乐下属网站（www.qianwe.com、或 www.qianwei.in） 的链接都必须保留，而不能清除或修改。</li>
	&nbsp;  <li>禁止在前卫音乐产品的整体或任何部分基础上以发展任何派生版本、修改版本或第三方版本用于重新分发。</li>
	&nbsp;  <li>您从应用中心下载的应用程序，未经应用程序开发者/所有者的书面许可，不得对其进行反向工程、反向汇编、反向编译等，不得擅自复制、修改、链接、转载、汇编、发表、出版、发展与之有关的衍生产品、作品等。</li>
	&nbsp;  <li>如果您未能遵守本协议的条款，您的授权将被终止，所许可的权利将被收回，同时您应承担相应法律责任。</li>
	</ol>

	<h3>III. 有限担保和免责声明</h3>
	<ol>
	&nbsp;  <li>本软件及所附带的文件是作为不提供任何明确的或隐含的赔偿或担保的形式提供的。</li>
	&nbsp;  <li>用户出于自愿而使用本软件，您必须了解使用本软件的风险，在尚未购买产品技术服务之前，我们不承诺提供任何形式的技术支持、使用担保，也不承担任何因使用本软件而产生问题的相关责任。</li>
	&nbsp;  <li>前卫音乐不对使用本软件构建的网站中或者论坛中的文章或信息承担责任，全部责任由您自行承担。</li>
	&nbsp;  <li>前卫音乐无法全面监控由第三方上传至应用中心的应用程序，因此不保证应用程序的合法性、安全性、完整性、真实性或品质等；您从应用中心下载应用程序时，同意自行判断并承担所有风险，而不依赖于前卫音乐。但在任何情况下，前卫音乐有权依法停止应用中心服务并采取相应行动，包括但不限于对于相关应用程序进行卸载，暂停服务的全部或部分，保存有关记录，并向有关机关报告。由此对您及第三人可能造成的损失，前卫音乐不承担任何直接、间接或者连带的责任。</li>
	&nbsp;  <li>前卫音乐对其提供的软件和服务之及时性、安全性、准确性不作担保，由于不可抗力因素、前卫音乐无法控制的因素（包括黑客攻击、停断电等）等造成软件使用和服务中止或终止，而给您造成损失的，您同意放弃追究前卫音乐责任的全部权利。</li>
	&nbsp;  <li>前卫音乐特别提请您注意，前卫音乐为了保障公司业务发展和调整的自主权，前卫音乐拥有随时经或未经事先通知而修改服务内容、中止或终止部分或全部软件使用和服务的权利，修改会公布于前卫音乐网站相关页面上，一经公布视为通知。 前卫音乐行使修改或中止、终止部分或全部软件使用和服务的权利而造成损失的，前卫音乐不需对您或任何第三方负责。</li>
	</ol>

	<p>有关前卫音乐产品最终用户授权协议、商业授权与技术服务的详细内容，均由前卫音乐独家提供。前卫音乐拥有在不事先通知的情况下，修改授权协议和服务价目表的权利，修改后的协议或价目表对自改变之日起的新授权用户生效。</p>

	<p>一旦您开始安装前卫音乐产品，即被视为完全理解并接受本协议的各项条款，在享有上述条款授予的权利的同时，受到相关的约束和限制。协议许可范围以外的行为，将直接违反本授权协议并构成侵权，我们有权随时终止授权，责令停止损害，并保留追究相关责任的权力。</p>

	<p>本许可协议条款的解释，效力及纠纷的解决，适用于中华人民共和国大陆法律。</p>

	<p>若您和前卫音乐之间发生任何纠纷或争议，首先应友好协商解决，协商不成的，您在此完全同意将纠纷或争议提交前卫音乐所在地人民法院管辖。前卫音乐拥有对以上各项条款内容的解释权及修改权。</p>

	<p>（正文完）</p>

	<p align="right">前卫音乐</p>
	</div>
	</div>
	<h2 class="title">环境检查</h2>
	<table class="tb" style="margin:20px 0 20px 55px;">
	<tr>
	<th>项目</th>
	<th class="padleft">所需配置</th>
	<th class="padleft">最佳配置</th>
	<th class="padleft">当前状态</th>
	</tr>
	<tr>
	<td>操作系统</td>
	<td class="padleft">不限制</td>
	<td class="padleft">类Unix</td>
	<td class="w pdleft1">$phpos</td>
	</tr>
	<tr>
	<td>PHP 版本</td>
	<td class="padleft">5.1</td>
	<td class="padleft">5.3</td>
	<td class="w pdleft1">$phpversion</td>
	</tr>
	<tr>
	<td>附件上传</td>
	<td class="padleft">不限制</td>
	<td class="padleft">8M</td>
	$attachmentupload
	</tr>
	<tr>
	<td>磁盘空间</td>
	<td class="padleft">12M</td>
	<td class="padleft">不限制</td>
	$diskspace
	</tr>
	</table>
	<h2 class="title">目录、文件权限检查</h2>
	<table class="tb" style="margin:20px 0 20px 55px;width:90%;">
	<tr><th>目录文件</th><th class="padleft">所需状态</th><th class="padleft">当前状态</th></tr>
	<tr><td>../source/global/global.php</td><td class="w pdleft1">可写</td>$perms[global]</tr>
	<tr><td>../source/global/global_config.php</td><td class="w pdleft1">可写</td>$perms[globalconfig]</tr>
	<tr><td>../client/ucenter.php</td><td class="w pdleft1">可写</td>$perms[ucenter]</tr>
	<tr><td>../data/</td><td class="w pdleft1">可写</td>$perms[data]</tr>
	<tr><td>../source/plugin/</td><td class="w pdleft1">可写</td>$perms[plugin]</tr>
	<tr><td>../template/</td><td class="w pdleft1">可写</td>$perms[template]</tr>
	</table>
	<h2 class="title">函数依赖性检查</h2>
	<table class="tb" style="margin:20px 0 20px 55px;width:90%;">
	<tr>
	<th>函数名称</th>
	<th class="padleft">检查结果</th>
	<th class="padleft">建议</th>
	</tr>
	<tr>
	<td>mysql_connect()</td>
	$check_mysql_connect
	<td class="padleft">无</td>
	</tr>
	<tr>
	<td>file_get_contents()</td>
	$check_file_get_contents
	<td class="padleft">无</td>
	</tr>
	<tr>
	<td>allow_url_fopen</td>
	$check_allow_url_fopen
	<td class="padleft">无</td>
	</tr>
	</table>
END;
	if(!$checkok) {
		echo "<div class=\"btnbox marginbot\"><form method=\"post\" action=\"index.php?step=1\"><input type=\"submit\" value=\"强制继续\"><input type=\"button\" value=\"关闭\" onclick=\"windowclose();\"></form></div>";
	} else {
		print <<<END
		<div class="btnbox marginbot">
		<form method="post" action="index.php?step=1">
		<input type="submit" value="同意并安装">
		<input type="button" value="不同意" onclick="windowclose();">
		</form>
		</div>
END;
	}
	show_footer();

} elseif ($step == 1) {
	show_header();
	print<<<END
	<div class="setup step2">
	<h2>安装数据库</h2>
	<p>正在执行数据库安装</p>
	</div>
	<div class="stepstat">
	<ul>
	<li class="unactivated">检查安装环境</li>
	<li class="current">创建数据库</li>
	<li class="unactivated">设置后台管理员</li>
	<li class="unactivated last">安装</li>
	</ul>
	<div class="stepstatbg stepstat1"></div>
	</div>
	</div>
	<div class="main">
	<form name="themysql" method="post" action="index.php?step=2">
	<div class="desc"><b>填写数据库信息</b></div>
	<table class="tb2">
	<tr><th class="tbopt" align="left">&nbsp;数据库主机:</th>
	<td><input type="text" name="dbhost" value="localhost" size="35" class="txt"></td>
	<td>数据库服务器地址，一般为 localhost</td>
	</tr>
	<tr><th class="tbopt" align="left">&nbsp;数据库名称:</th>
	<td><input type="text" name="dbname" value="test" size="35" class="txt"></td>
	<td>如果不存在，则会尝试自动创建</td>
	</tr>
	<tr><th class="tbopt" align="left">&nbsp;数据库用户名:</th>
	<td><input type="text" name="dbuser" value="root" size="35" class="txt"></td>
	<td></td>
	</tr>
	<tr><th class="tbopt" align="left">&nbsp;数据库密码:</th>
	<td><input type="password" name="dbpw" value="" size="35" class="txt"></td>
	<td></td>
	</tr>
	</table>
	<div class="desc"><b>其它可选设置项</b></div>
	<table class="tb2">
	<tr><th class="tbopt" align="left">&nbsp;数据库表前缀:</th>
	<td><input type="text" name="dbtablepre" value="prefix_" size="35" class="txt"></td>
	<td>不能为空，默认为prefix_</td>
	</tr>
	</table>
	<table class="tb2">
	<tr><th class="tbopt" align="left">&nbsp;</th>
	<td><input type="submit" name="submitmysql" value="创建数据库" onclick="return checkmysql();" class="btn"></td>
	<td></td>
	</tr>
	</table>
	</form>
END;
	show_footer();

} elseif ($step == 2) {
	if(!submitcheck('submitmysql')){show_msg('表单验证不符，无法提交！', 999);}
	$path=$_SERVER['PHP_SELF'];
	$path=ReplaceStr(strtolower($path),"install/index.php","");
	$host=SafeRequest("dbhost","post");
	$name=SafeRequest("dbname","post");
	$user=SafeRequest("dbuser","post");
	$pw=SafeRequest("dbpw","post");
	$tablepre=SafeRequest("dbtablepre","post");
	$havedata = false;
	if(!@mysql_connect($host, $user, $pw)) {
		show_msg('数据库信息填写有误，请更改！');
	}
	$config=file_get_contents("../source/global/global.php");
	$config=preg_replace('/"cd_sqlservername","(.*?)"/', '"cd_sqlservername","'.$host.'"', $config);
	$config=preg_replace('/"cd_sqldbname","(.*?)"/', '"cd_sqldbname","'.$name.'"', $config);
	$config=preg_replace('/"cd_sqluserid","(.*?)"/', '"cd_sqluserid","'.$user.'"', $config);
	$config=preg_replace('/"cd_sqlpwd","(.*?)"/', '"cd_sqlpwd","'.$pw.'"', $config);
	$config=preg_replace('/"cd_webpath","(.*?)"/', '"cd_webpath","'.$path.'"', $config);
	$config=preg_replace('/"cd_upath","(.*?)"/', '"cd_upath","'.$path.'user/"', $config);
	$config=preg_replace('/"cd_tablename","(.*?)"/', '"cd_tablename","'.$tablepre.'"', $config);
	$config=preg_replace('/"cd_cookiepath","(.*?)"/', '"cd_cookiepath","'.$path.'"', $config);
	$ifile = new iFile('../source/global/global.php', 'w');
	$ifile->WriteFile($config, 3);
	if(mysql_select_db($name)) {
		if(mysql_query("SELECT COUNT(*) FROM ".$tablepre."admin")) {
			$havedata = true;
		}
	} else {
		if(!mysql_query("CREATE DATABASE `".$name."`")) {
			show_msg('设定的数据库无权限操作，请先手工新建后，再执行安装程序！');
		}
	}
	if($havedata) {
		show_msg('危险！指定的数据库已有数据，如果继续将会清空原有数据！', ($step+1));
	} else {
		show_msg('数据库信息配置成功，即将开始安装数据...', ($step+1), 1);
	}

} elseif ($step == 3) {
	$lnk=mysql_connect(cd_sqlservername, cd_sqluserid, cd_sqlpwd) or show_msg('数据库连接异常，无法执行！', 999);
	mysql_select_db(cd_sqldbname, $lnk) or show_msg('数据库连接异常，无法执行！', 999);
	mysql_query("SET NAMES gb2312",$lnk);
	$table=file_get_contents("table.sql");
	$table=ReplaceStr($table,"prefix_",cd_tablename);
	$tablearr=explode(";",$table);
	$data=file_get_contents("data.sql");
	$data=ReplaceStr($data,"prefix_",cd_tablename);
	$dataarr=explode("--preset--",$data);
	$sqlarr=explode("结构*/",$table);
	$str="<p>正在安装数据...</p>{replace}";
	for($i=0;$i<count($tablearr)-1;$i++){
		mysql_query($tablearr[$i]);
	}
	for($i=0;$i<count($dataarr);$i++){
		mysql_query($dataarr[$i]);
	}
	for($i=0;$i<count($sqlarr)-1;$i++){
		$strsql=explode("/*数据",$sqlarr[$i]);
		$str.=$strsql[1];
	}
	$str=ReplaceStr($str,"表 `","<p>建立数据表 ");
	$str=ReplaceStr($str,"` 的"," ... 成功</p>{replace}");
	$str=$str."<p>安装附加数据 ... 成功</p>{replace}";
	show_header();
	print<<<END
	<div class="setup step2">
	<h2>安装数据库</h2>
	<p>正在执行数据库安装</p>
	</div>
	<div class="stepstat">
	<ul>
	<li class="unactivated">检查安装环境</li>
	<li class="current">创建数据库</li>
	<li class="unactivated">设置后台管理员</li>
	<li class="unactivated last">安装</li>
	</ul>
	<div class="stepstatbg stepstat1"></div>
	</div>
	</div>
	<div class="main">
	<div class="notice" id="log">
	<div class="license" id="loginner">
	</div>
	</div>
	<div class="btnbox margintop marginbot">
	<input type="button" value="正在安装..." disabled="disabled">
	</div>
	<script type="text/javascript">
	var log = "$str";
	var n = 0;
	var timer = 0;
	log = log.split('{replace}');
	function GoPlay() {
		if (n > log.length-1) {
		        n=-1;
		        clearIntervals();
		}
		if (n > -1) {
		        postcheck(n);
		        n++;
		}
	}
	function postcheck(n) {
		document.getElementById('loginner').innerHTML += log[n];
		document.getElementById('log').scrollTop = document.getElementById('log').scrollHeight;
	}
	function setIntervals() {
		timer = setInterval('GoPlay()', 100);
	}
	function clearIntervals() {
		clearInterval(timer);
		window.location.href = "index.php?step=4";
	}
	setTimeout(setIntervals, 42);
	</script>
END;
	show_footer();

} elseif ($step == 4) {
	show_header();
	print<<<END
	<div class="setup step3">
	<h2>创建管理员</h2>
	<p>正在设置后台管理帐号</p>
	</div>
	<div class="stepstat">
	<ul>
	<li class="unactivated">检查安装环境</li>
	<li class="unactivated">创建数据库</li>
	<li class="current">设置后台管理员</li>
	<li class="unactivated last">安装</li>
	</ul>
	<div class="stepstatbg stepstat1"></div>
	</div>
	</div>
	<div class="main">
	<form name="theuser" method="post" action="index.php?step=5">
	<div class="desc"><b>填写管理员信息</b></div>
	<table class="tb2">
	<tr><th class="tbopt" align="left">&nbsp;管理员帐号:</th>
	<td><input type="text" name="uname" value="" size="35" class="txt" onkeyup="value=value.replace(/[\W]/g,'')" onbeforepaste="clipboardData.setData('text',clipboardData.getData('text').replace(/[^\d]/g,''))"></td>
	<td>不允许设置特殊字符</td>
	</tr>
	<tr><th class="tbopt" align="left">&nbsp;管理员密码:</th>
	<td><input type="password" name="upw" value="" size="35" class="txt"></td>
	<td>密码设置越复杂，安全级别越高</td>
	</tr>
	<tr><th class="tbopt" align="left">&nbsp;重复密码:</th>
	<td><input type="password" name="upw1" value="" size="35" class="txt"></td>
	<td></td>
	</tr>
	<tr><th class="tbopt" align="left">&nbsp;认证码:</th>
	<td><input type="text" name="ucode" value="" size="35" class="txt"></td>
	<td>设置后，可以在后台选择开启或关闭</td>
	</tr>
	</table>
	<table class="tb2">
	<tr><th class="tbopt" align="left">&nbsp;</th>
	<td><input type="submit" name="submituser" value="创建管理员" onclick="return checkuser();" class="btn"></td>
	<td></td>
	</tr>
	</table>
	</form>
END;
	show_footer();

} elseif ($step == 5) {
	if(!submitcheck('submituser')){show_msg('表单验证不符，无法提交！', 999);}
	$lnk=mysql_connect(cd_sqlservername, cd_sqluserid, cd_sqlpwd) or show_msg('数据库连接异常，无法执行！', 999);
	mysql_select_db(cd_sqldbname, $lnk) or show_msg('数据库连接异常，无法执行！', 999);
	mysql_query("SET NAMES gb2312",$lnk);
	$name=SafeRequest("uname","post");
	$pw=SafeRequest("upw","post");
	$pw1=SafeRequest("upw1","post");
	$code=SafeRequest("ucode","post");
	$config=file_get_contents("../source/global/global_config.php");
	$config=preg_replace('/"cd_weburl","(.*?)"/', '"cd_weburl","'.$_SERVER['HTTP_HOST'].'"', $config);
	$config=preg_replace('/"cd_webcodeb","(.*?)"/', '"cd_webcodeb","'.$code.'"', $config);
	fwrite(fopen("../source/global/global_config.php","wb"),$config);
	$sqla="insert into `".tname('admin')."` (CD_AdminUserName,CD_AdminPassWord,CD_Permission,CD_LoginNum,CD_IsLock) values ('".$name."','".md5($pw1)."','1,2,3,4,5,6,7,8,9','0','0')";
	$sqlu="insert into `".tname('user')."` (cd_name,cd_nicheng,cd_password,cd_email,cd_regdate,cd_loginnum,cd_grade,cd_lock,cd_points,cd_hits,cd_isbest,cd_friendnum,cd_rank,cd_uhits,cd_weekhits,cd_musicnum,cd_fansnum,cd_idolnum,cd_favnum,cd_qqprivacy,cd_groupnum,cd_checkmm,cd_checkmusic,cd_review,cd_sign,cd_signcumu,cd_ucenter,cd_skinid,cd_vipgrade,cd_viprank,cd_ulevel) values ('".$name."','管理员','".substr(md5($pw1),8,16)."','web@qianwe.com','".date('Y-m-d H:i:s')."','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0','0')";
	$sqls="insert into `".tname('server')."` (CD_Name,CD_Url,CD_DownUrl,CD_Yes) values ('会员上传','http://".$_SERVER['HTTP_HOST'].cd_webpath."','http://".$_SERVER['HTTP_HOST'].cd_webpath."','0')";
	if(mysql_query($sqla) && mysql_query($sqlu) && mysql_query($sqls)) {
		fwrite(fopen("../data/install.xml","wb+"),date('Y-m-d H:i:s'));
		show_msg('恭喜！QianWei Music 顺利安装完成！<br>为了保证数据安全，请手动删除install目录！<br><br>您的后台管理员帐号与前台会员帐号已经成功建立。接下来，您可以：<br><br><a href="../index.php" target="_blank">进入网站首页</a><br>或 <a href="../admin.php" target="_blank">进入管理后台</a> 以管理员身份对站点参数进行设置！', 999);
	} else {
		show_msg(mysql_error(), 999);
	}
}

function show_header() {
	global $charset, $version, $build;
	print<<<END
	<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
	<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=gb2312" />
	<title>QianWei Music 安装向导</title>
	<link rel="stylesheet" href="images/style.css" type="text/css" media="all" />
	<link href="../source/plugin/asynctips/asynctips.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src="../source/plugin/asynctips/jquery.min.js"></script>
	<script type="text/javascript" src="../source/plugin/asynctips/asyncbox.v1.4.5.js"></script>
	<script type="text/javascript">
	function windowclose() {
		var browserName = navigator.appName;
		if (browserName=="Netscape") {
        		window.open('', '_self', '');
        		window.close();
        	} else {
        		if (browserName=="Microsoft Internet Explorer") {
        		        window.opener = "whocares";
        		        window.opener = null;
        		        window.open('', '_top');
        		        window.close();
        		}
        	}
        }
	function checkmysql() {
        	if (this.themysql.dbhost.value=="") {
        		asyncbox.tips("数据库主机不能为空，请填写！", "wait", 1000);
        		this.themysql.dbhost.focus();
        		return false;
        	} else if (this.themysql.dbname.value=="") {
        		asyncbox.tips("数据库名称不能为空，请填写！", "wait", 1000);
        		this.themysql.dbname.focus();
        		return false;
        	} else if (this.themysql.dbuser.value=="") {
        		asyncbox.tips("数据库用户名不能为空，请填写！", "wait", 1000);
        		this.themysql.dbuser.focus();
        		return false;
        	} else if (this.themysql.dbpw.value=="") {
        		asyncbox.tips("数据库密码不能为空，请填写！", "wait", 1000);
        		this.themysql.dbpw.focus();
        		return false;
        	} else if (this.themysql.dbtablepre.value=="") {
        		asyncbox.tips("数据库表前缀不能为空，请填写！", "wait", 1000);
        		this.themysql.dbtablepre.focus();
        		return false;
        	} else {
        		return true;
        	}
	}
	function checkuser() {
        	if (this.theuser.uname.value=="") {
        		asyncbox.tips("管理员帐号不能为空，请填写！", "wait", 1000);
        		this.theuser.uname.focus();
        		return false;
        	} else if (this.theuser.upw.value=="") {
        		asyncbox.tips("管理员密码不能为空，请填写！", "wait", 1000);
        		this.theuser.upw.focus();
        		return false;
        	} else if (this.theuser.upw1.value=="") {
        		asyncbox.tips("重复密码不能为空，请填写！", "wait", 1000);
        		this.theuser.upw1.focus();
        		return false;
        	} else if (this.theuser.upw1.value!==this.theuser.upw.value) {
        		asyncbox.tips("两次输入密码不一致，请更改！", "error", 1000);
        		this.theuser.upw1.focus();
        		return false;
        	} else if (this.theuser.ucode.value=="") {
        		asyncbox.tips("认证码不能为空，请填写！", "wait", 1000);
        		this.theuser.ucode.focus();
        		return false;
        	} else {
        		return true;
        	}
	}
	</script>
	</head>
	<body>
	<div class="container">
	<div class="header">
	<h1>QianWei Music 安装向导</h1>
	<span>QianWei Music $version 简体中文$charset $build</span>
END;
}

function show_footer() {
	global $year;
	print<<<END
	<div class="footer">&copy;2008 - $year <a href="http://www.qianwe.com/" target="_blank">QianWe</a> Inc.</div>
	</div>
	</div>
	</body>
	</html>
END;
}

function show_msg($message, $next=0, $jump=0) {
	$nextstr = '';
	$backstr = '';
	if(empty($next)) {
		$backstr .= "<a href=\"index.php?step=1\">返回上一步</a>";
	} elseif ($next == 999) {
	} else {
		$url_forward = "index.php?step=$next";
		if($jump) {
			$nextstr .= "<a href=\"$url_forward\">请稍等...</a><script>setTimeout(\"window.location.href ='$url_forward';\", 1000);</script>";
		} else {
			$nextstr .= "<a href=\"$url_forward\">继续下一步</a>";
			$backstr .= "<a href=\"index.php?step=1\">返回上一步</a>";
		}
	}
	show_header();
	print<<<END
	<div class="setup">
	<h2>安装提示</h2>
	</div>
	<div class="stepstat">
	<ul>
	<li class="unactivated">检查安装环境</li>
	<li class="unactivated">创建数据库</li>
	<li class="unactivated">设置后台管理员</li>
	<li class="current last">安装</li>
	</ul>
	<div class="stepstatbg"></div>
	</div>
	</div>
	<div class="main">
	<div class="desc" align="center"><b>提示信息</b></div>
	<table class="tb2">
	<tr><td class="desc" align="center">$message</td>
	</tr>
	</table>
	<div class="btnbox marginbot">$backstr $nextstr</div>
END;
	show_footer();
	exit();
}

function checkfdperm($path, $isfile=0) {
	if($isfile) {
		$file = $path;
		$mod = 'a';
	} else {
		$file = $path.'./install_tmptest.data';
		$mod = 'w';
	}
	if(!@$fp = fopen($file, $mod)) {
		return false;
	}
	if(!$isfile) {
		fwrite($fp, ' ');
		fclose($fp);
		if(!@unlink($file)) {
			return false;
		}
		if(is_dir($path.'./install_tmpdir')) {
			if(!@rmdir($path.'./install_tmpdir')) {
				return false;
			}
		}
		if(!@mkdir($path.'./install_tmpdir')) {
			return false;
		}
		if(!@rmdir($path.'./install_tmpdir')) {
			return false;
		}
	} else {
		fclose($fp);
	}
	return true;
}
?>