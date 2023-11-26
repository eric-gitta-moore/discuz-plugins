<?php
function GetTemp($tpl,$ids){
	$tplpath=_qianwei_root_.cd_templatedir.$tpl;
	$Mark_Text=@file_get_contents($tplpath);
	$Mark_Text=Common_Mark($Mark_Text,$ids);
	return $Mark_Text;
}

function topandbottom($Mark_Text){
	$top_txt=@file_get_contents(_qianwei_root_.cd_templatedir."head.html");
	$bottom_txt=@file_get_contents(_qianwei_root_.cd_templatedir."bottom.html");
	$Mark_Text=str_replace('[qianwei:head]',$top_txt,$Mark_Text);
	$Mark_Text=str_replace('[qianwei:bottom]',$bottom_txt,$Mark_Text);
	return $Mark_Text;
}

function Common_Mark($Mark_Text,$IDs){
	global $db;
	if(!IsNul($Mark_Text)) die(html_message("错误信息","模板文件无内容或不存在！"));
	$TempImg=cd_webpath.substr(substr(cd_templatedir,0,strlen(cd_templatedir)-1),0,strrpos(substr(cd_templatedir,0,strlen(cd_templatedir)-1),'/')+1);
	$HttpHost=$_SERVER['HTTP_HOST'];
	$CopyTime=date('Y',time());
	$usernum=$db->num_rows($db->query("select * from ".tname('user')));
	if(cd_webhtml==3){
		$singersearch=cd_webpath."singertag/";
		$user_mod=cd_webpath."mod/";
	}else{
		$singersearch=cd_webpath."search.php?action=singer&key=";
		$user_mod=cd_webpath."user.php?mod=";
	}
	$sqllabel="select cd_name,cd_selflable from ".tname('label')." order by cd_priority asc";
	$resultslabel=$db->query($sqllabel);
	if($resultslabel){
		while ($rowlabel=$db->fetch_array($resultslabel)){
			$labelname=$rowlabel['cd_name'];
			$Mark_Text = ReplaceStr($Mark_Text,"{tag:".$labelname."}",html_entity_decode(stripslashes($rowlabel['cd_selflable'])));
		}
	}
	$Mark_Text = topandbottom($Mark_Text);
	$Mark_Text = ReplaceStr($Mark_Text,"[qianwei:webname]",cd_webname);
	$Mark_Text = ReplaceStr($Mark_Text,"[qianwei:weburl]",cd_weburl);
	$Mark_Text = ReplaceStr($Mark_Text,"[qianwei:path]",cd_webpath);
	$Mark_Text = ReplaceStr($Mark_Text,"[qianwei:userpath]",cd_upath);
	$Mark_Text = ReplaceStr($Mark_Text,"[qianwei:mail]",cd_webmail);
	$Mark_Text = ReplaceStr($Mark_Text,"[qianwei:qq]",cd_webqq);
	$Mark_Text = ReplaceStr($Mark_Text,"[qianwei:icp]",cd_webicp);
	$Mark_Text = ReplaceStr($Mark_Text,"[qianwei:keywords]",cd_keywords);
	$Mark_Text = ReplaceStr($Mark_Text,"[qianwei:description]",cd_description);
	$Mark_Text = ReplaceStr($Mark_Text,"[qianwei:webstat]",html_entity_decode(stripslashes(cd_webstat)));
	$Mark_Text = ReplaceStr($Mark_Text,"[qianwei:tempurl]",$TempImg);
	$Mark_Text = ReplaceStr($Mark_Text,"[qianwei:httphost]",$HttpHost);
	$Mark_Text = ReplaceStr($Mark_Text,"[qianwei:copytime]",$CopyTime);
	$Mark_Text = ReplaceStr($Mark_Text,"[qianwei:usernum]",$usernum);
	$Mark_Text = ReplaceStr($Mark_Text,"[qianwei:singertag]",$singersearch);
	$Mark_Text = ReplaceStr($Mark_Text,"[qianwei:mod]",$user_mod);
	return Data_Mark($Mark_Text,$IDs);
}

function Data_Mark($Mark_Text,$IDs){
	global $db;
	if(!IsNul($Mark_Text)) die(html_message("错误信息","模板文件无内容！"));
	preg_match_all('/{qianwei:([\S]+)\s+(.*?)}([\s\S]+?){\/qianwei:\1}/',$Mark_Text,$Mark_Arr);
	if(!empty($Mark_Arr)){
		for($i=0;$i<count($Mark_Arr[0]);$i++){
			$table=cd_tablename.$Mark_Arr[1][$i];
			$para=$Mark_Arr[2][$i];
			$sql=Mark_Sql($table,$para,$IDs);
			$result=$db->query($sql);
			$resultcount=$db->num_rows($result);
			if($result){
				if($resultcount==0){
					$Data_Content="";
					$Mark_Text=ReplaceStr($Mark_Text,$Mark_Arr[0][$i],$Data_Content);
				}else{
					$Data_Content='';$Data_Content_Temp='';$sorti=1;
					while($row=$db->fetch_array($result)){	
						switch($table){
							case tname("music"):$Data_Content.=datamusic($Mark_Arr[0][$i],$Mark_Arr[3][$i],$row,$sorti);break;
							case tname("class"):$Data_Content.=dataclass($Mark_Arr[0][$i],$Mark_Arr[3][$i],$row,$sorti);break;
							case tname("video"):$Data_Content.=datavideo($Mark_Arr[0][$i],$Mark_Arr[3][$i],$row,$sorti);break;
							case tname("videoclass"):$Data_Content.=datavideoclass($Mark_Arr[0][$i],$Mark_Arr[3][$i],$row,$sorti);break;
							case tname("special"):$Data_Content.=dataspecial($Mark_Arr[0][$i],$Mark_Arr[3][$i],$row,$sorti);break;
							case tname("singer"):$Data_Content.=datasinger($Mark_Arr[0][$i],$Mark_Arr[3][$i],$row,$sorti);break;
							case tname("link"):$Data_Content.=datalink($Mark_Arr[0][$i],$Mark_Arr[3][$i],$row,$sorti);break;
							case tname("user"):$Data_Content.=datauser($Mark_Arr[0][$i],$Mark_Arr[3][$i],$row,$sorti);break;
						}
						$sorti=$sorti+1;
					}
				}
				$Mark_Text=ReplaceStr($Mark_Text,$Mark_Arr[0][$i],$Data_Content);	
			}
		}
	}
	$Mark_Text=labelif($Mark_Text);
	return $Mark_Text;
}

function datamusic($para,$label,$row,$sorti){
	preg_match_all('/\[music:\s*([0-9a-zA-Z]+)([\s]*[len|style]*)[=]??([\da-zA-Z\-\\\\:\s]*)\]/',$para,$field_arr);
	$datatmp=$label;
	if(!empty($field_arr)){
		for($i=0;$i<count($field_arr[0]);$i++){
			switch($field_arr[1][$i]){
				case 'link':$datatmp=ReplaceStr($datatmp,'[music:link]',LinkUrl("music",$row['CD_ClassID'],1,$row['CD_ID']));break;
				case 'downlink':$datatmp=ReplaceStr($datatmp,'[music:downlink]',LinkDownUrl($row['CD_ID']));break;
				case 'diangelink':$datatmp=ReplaceStr($datatmp,'[music:diangelink]',LinkDianGeUrl($row['CD_ID']));break;
				case 'favlink':$datatmp=ReplaceStr($datatmp,'[music:favlink]',LinkFavUrl($row['CD_ID']));break;
				case 'errorlink':$datatmp=ReplaceStr($datatmp,'[music:errorlink]',LinkErrorUrl($row['CD_ID']));break;
				case 'pic':$datatmp=ReplaceStr($datatmp,'[music:pic]',LinkPicUrl($row['CD_Pic']));break;
				case 'id':$datatmp=ReplaceStr($datatmp,'[music:id]',$row['CD_ID']);break;
				case 'i':$datatmp=ReplaceStr($datatmp,'[music:i]',$sorti);break;
				case 'color':$datatmp=ReplaceStr($datatmp,'[music:color]',$row['CD_Color']);break;
				case 'hits':$datatmp=ReplaceStr($datatmp,'[music:hits]',$row['CD_Hits']);break;
				case 'speciallink':$datatmp=ReplaceStr($datatmp,'[music:speciallink]',LinkSpecialUrl('special',$row['CD_ClassID'],1,$row['CD_SpecialID']));break;
				case 'specialname':$datatmp=ReplaceStr($datatmp,'[music:specialname]',GetSpecialAlias('qianwei_special','CD_Name','CD_ID',$row['CD_SpecialID']));break;
				case 'singerlink':$datatmp=ReplaceStr($datatmp,'[music:singerlink]',LinkSingerUrl('singer',$row['CD_ClassID'],1,$row['CD_SingerID']));break;
				case 'singername':$datatmp=ReplaceStr($datatmp,'[music:singername]',GetSingerAlias('qianwei_singer','CD_Name','CD_ID',$row['CD_SingerID']));break;
				case 'downhits':$datatmp=ReplaceStr($datatmp,'[music:downhits]',$row['CD_DownHits']);break;
				case 'favhits':$datatmp=ReplaceStr($datatmp,'[music:favhits]',$row['CD_FavHits']);break;
				case 'diangehits':$datatmp=ReplaceStr($datatmp,'[music:diangehits]',$row['CD_DianGeHits']);break;
				case 'goodhits':$datatmp=ReplaceStr($datatmp,'[music:goodhits]',$row['CD_GoodHits']);break;
				case 'badhits':$datatmp=ReplaceStr($datatmp,'[music:badhits]',$row['CD_BadHits']);break;
				case 'bestnul':$datatmp=ReplaceStr($datatmp,'[music:bestnul]',str_isbest($row['CD_IsBest']));break;
				case 'bestnum':$datatmp=ReplaceStr($datatmp,'[music:bestnum]',$row['CD_IsBest']);break;
				case 'points':$datatmp=ReplaceStr($datatmp,'[music:points]',$row['CD_Points']);break;
				case 'classlink':$datatmp=ReplaceStr($datatmp,"[music:classlink]",LinkClassUrl("music",$row['CD_ClassID'],1,1));break;
				case 'classname':$datatmp=ReplaceStr($datatmp,"[music:classname]",GetAlias("qianwei_class","CD_Name","CD_ID",$row['CD_ClassID']));break;
				case 'userlink':$datatmp=ReplaceStr($datatmp,"[music:userlink]",linkweburl(GetAlias("qianwei_user","cd_id","cd_name",$row['CD_User']),$row['CD_User']));break;
				case 'usersex':$datatmp=ReplaceStr($datatmp,"[music:usersex]",str_sex(GetAlias("qianwei_user","cd_sex","cd_name",$row['CD_User'])));break;
				case 'userqq':$datatmp=ReplaceStr($datatmp,"[music:userqq]",GetAlias("qianwei_user","cd_qq","cd_name",$row['CD_User']));break;
				case 'useraddress':$datatmp=ReplaceStr($datatmp,"[music:useraddress]",GetAlias("qianwei_user","cd_address","cd_name",$row['CD_User']));break;
				case 'userbirthday':$datatmp=ReplaceStr($datatmp,"[music:userbirthday]",GetAlias("qianwei_user","cd_birthday","cd_name",$row['CD_User']));break;
				case 'userpic':$datatmp=ReplaceStr($datatmp,"[music:userpic]",getavatars($row['CD_UserID'],0));break;
				case 'userpic1':$datatmp=ReplaceStr($datatmp,"[music:userpic1]",getavatars($row['CD_UserID'],1));break;
				case 'userpic2':$datatmp=ReplaceStr($datatmp,"[music:userpic2]",getavatars($row['CD_UserID'],2));break;
				case 'usernicheng':$datatmp=ReplaceStr($datatmp,"[music:usernicheng]",$row['CD_UserNicheng']);break;
				case 'name':
					$name=getlen($field_arr[2][$i],$field_arr[3][$i],$row['CD_Name']);
					$datatmp=ReplaceStr($datatmp,$field_arr[0][$i],$name);
					break;
				case 'user':
					$user=getlen($field_arr[2][$i],$field_arr[3][$i],$row['CD_User']);
					$datatmp=ReplaceStr($datatmp,$field_arr[0][$i],$user);
					break;
				case 'word':
					$word=getlen($field_arr[2][$i],$field_arr[3][$i],$row['CD_Word']);
					$datatmp=ReplaceStr($datatmp,$field_arr[0][$i],$word);
					break;
				case 'words':
					$words=getlen($field_arr[2][$i],$field_arr[3][$i],$row['CD_Word']);
					$datatmp=ReplaceStr($datatmp,$field_arr[0][$i],str_r_n($words));
					break;
				case 'time':
					$datatmp=ReplaceStr($datatmp,$field_arr[0][$i],date(ReplaceStr($field_arr[3][$i],'f','i'),strtotime($row['CD_AddTime'])));
					break;
			}
		}
	}
	unset($field_arr);
	return $datatmp;
}

function dataclass($para,$label,$row,$sorti){
	preg_match_all('/\[class:\s*([0-9a-zA-Z]+)([\s]*[len|style]*)[=]??([\da-zA-Z\-\\\\:\s]*)\]/',$para,$field_arr);
	$datatmp=$label;
	if(!empty($field_arr)){
		for($i=0;$i<count($field_arr[0]);$i++){
			switch($field_arr[1][$i]){
				case 'aliasname':$datatmp=ReplaceStr($datatmp,'[class:aliasname]',$row['CD_AliasName']);break;	
				case 'name':$datatmp=ReplaceStr($datatmp,'[class:name]',$row['CD_Name']);break;			
				case 'link':$datatmp=ReplaceStr($datatmp,'[class:link]',LinkClassUrl("music",$row['CD_ID'],$row['CD_SystemID'],1));break;
				case 'fmlink':$datatmp=ReplaceStr($datatmp,'[class:fmlink]',LinkFmUrl($row['CD_ID']));break;
				case 'id':$datatmp=ReplaceStr($datatmp,'[class:id]',$row['CD_ID']);break;
				case 'i':$datatmp=ReplaceStr($datatmp,'[class:i]',$sorti);break;
			}
		}
	}
	unset($field_arr);
	return $datatmp;
}

function datavideo($para,$label,$row,$sorti){
	preg_match_all('/\[video:\s*([0-9a-zA-Z]+)([\s]*[len|style]*)[=]??([\da-zA-Z\-\\\\:\s]*)\]/',$para,$field_arr);
	$datatmp=$label;
	if(!empty($field_arr)){
		for($i=0;$i<count($field_arr[0]);$i++){
			switch($field_arr[1][$i]){
				case 'i':$datatmp=ReplaceStr($datatmp,'[video:i]',$sorti);break;
				case 'id':$datatmp=ReplaceStr($datatmp,'[video:id]',$row['CD_ID']);break;
				case 'link':$datatmp=ReplaceStr($datatmp,'[video:link]',LinkUrl("video",$row['CD_ClassID'],1,$row['CD_ID']));break;
				case 'isbest':$datatmp=ReplaceStr($datatmp,'[video:isbest]',$row['CD_IsBest']);break;
				case 'play':$datatmp=ReplaceStr($datatmp,'[video:play]',LinkVideoUrl($row['CD_Play'],1,$row['CD_ID']));break;
				case 'pic':$datatmp=ReplaceStr($datatmp,'[video:pic]',LinkPicUrl($row['CD_Pic']));break;
				case 'color':$datatmp=ReplaceStr($datatmp,'[video:color]',$row['CD_Color']);break;
				case 'singerlink':$datatmp=ReplaceStr($datatmp,'[video:singerlink]',LinkSingerUrl('singer',$row['CD_ClassID'],1,$row['CD_SingerID']));break;
				case 'singername':$datatmp=ReplaceStr($datatmp,'[video:singername]',GetSingerAlias('qianwei_singer','CD_Name','CD_ID',$row['CD_SingerID']));break;
				case 'hits':$datatmp=ReplaceStr($datatmp,'[video:hits]',$row['CD_Hits']);break;
				case 'classlink':$datatmp=ReplaceStr($datatmp,"[video:classlink]",LinkClassUrl("video",$row['CD_ClassID'],"",1));break;
				case 'classname':$datatmp=ReplaceStr($datatmp,"[video:classname]",GetAlias("qianwei_videoclass","CD_Name","CD_ID",$row['CD_ClassID']));break;
				case 'userlink':$datatmp=ReplaceStr($datatmp,"[video:userlink]",linkweburl(GetAlias("qianwei_user","cd_id","cd_name",$row['CD_User']),$row['CD_User']));break;
				case 'name':
					$name=getlen($field_arr[2][$i],$field_arr[3][$i],$row['CD_Name']);
					$datatmp=ReplaceStr($datatmp,$field_arr[0][$i],$name);
					break;
				case 'user':
					$user=getlen($field_arr[2][$i],$field_arr[3][$i],$row['CD_User']);
					$datatmp=ReplaceStr($datatmp,$field_arr[0][$i],$user);
					break;
				case 'time':
					$datatmp=ReplaceStr($datatmp,$field_arr[0][$i],date(ReplaceStr($field_arr[3][$i],'f','i'),strtotime($row['CD_AddTime'])));
					break;
			}
		}
	}
	unset($field_arr);
	return $datatmp;
}

function datavideoclass($para,$label,$row,$sorti){
	preg_match_all('/\[videoclass:\s*([0-9a-zA-Z]+)([\s]*[len|style]*)[=]??([\da-zA-Z\-\\\\:\s]*)\]/',$para,$field_arr);
	$datatmp=$label;
	if(!empty($field_arr)){
		for($i=0;$i<count($field_arr[0]);$i++){
			switch($field_arr[1][$i]){
				case 'name':$datatmp=ReplaceStr($datatmp,'[videoclass:name]',$row['CD_Name']);break;
				case 'link':$datatmp=ReplaceStr($datatmp,'[videoclass:link]',LinkClassUrl("video",$row['CD_ID'],"",1));break;
				case 'id':$datatmp=ReplaceStr($datatmp,'[videoclass:id]',$row['CD_ID']);break;
				case 'i':$datatmp=ReplaceStr($datatmp,'[videoclass:i]',$sorti);break;
			}
		}
	}
	unset($field_arr);
	return $datatmp;
}

function dataspecial($para,$label,$row,$sorti){
	preg_match_all('/\[special:\s*([0-9a-zA-Z]+)([\s]*[len|style]*)[=]??([\da-zA-Z\-\\\\:\s]*)\]/',$para,$field_arr);
	$datatmp=$label;
	if(!empty($field_arr)){
		for($i=0;$i<count($field_arr[0]);$i++){
			switch($field_arr[1][$i]){
				case 'i':$datatmp=ReplaceStr($datatmp,'[special:i]',$sorti);break;
				case 'id':$datatmp=ReplaceStr($datatmp,'[special:id]',$row['CD_ID']);break;
				case 'link':$datatmp=ReplaceStr($datatmp,'[special:link]',LinkUrl("special",$row['CD_ClassID'],1,$row['CD_ID']));break;
				case 'isbest':$datatmp=ReplaceStr($datatmp,'[special:isbest]',$row['CD_IsBest']);break;
				case 'singerlink':$datatmp=ReplaceStr($datatmp,'[special:singerlink]',LinkSingerUrl('singer',$row['CD_ClassID'],1,$row['CD_SingerID']));break;
				case 'singername':$datatmp=ReplaceStr($datatmp,'[special:singername]',GetSingerAlias('qianwei_singer','CD_Name','CD_ID',$row['CD_SingerID']));break;
				case 'hits':$datatmp=ReplaceStr($datatmp,'[special:hits]',$row['CD_Hits']);break;
				case 'pic':$datatmp=ReplaceStr($datatmp,'[special:pic]',LinkPicUrl($row['CD_Pic']));break;
				case 'classlink':$datatmp=ReplaceStr($datatmp,"[special:classlink]",LinkClassUrl("music",$row['CD_ClassID'],1,1));break;
				case 'classname':$datatmp=ReplaceStr($datatmp,"[special:classname]",GetAlias("qianwei_class","CD_Name","CD_ID",$row['CD_ClassID']));break;
				case 'userlink':$datatmp=ReplaceStr($datatmp,"[special:userlink]",linkweburl(GetAlias("qianwei_user","cd_id","cd_name",$row['CD_User']),$row['CD_User']));break;
				case 'name':
					$name=getlen($field_arr[2][$i],$field_arr[3][$i],$row['CD_Name']);
					$datatmp=ReplaceStr($datatmp,$field_arr[0][$i],$name);
					break;
				case 'user':
					$user=getlen($field_arr[2][$i],$field_arr[3][$i],$row['CD_User']);
					$datatmp=ReplaceStr($datatmp,$field_arr[0][$i],$user);
					break;
				case 'gongsi':
					$gongsi=getlen($field_arr[2][$i],$field_arr[3][$i],$row['CD_GongSi']);
					$datatmp=ReplaceStr($datatmp,$field_arr[0][$i],$gongsi);
					break;
				case 'yuyan':
					$yuyan=getlen($field_arr[2][$i],$field_arr[3][$i],$row['CD_YuYan']);
					$datatmp=ReplaceStr($datatmp,$field_arr[0][$i],$yuyan);
					break;
				case 'intro':
					$intro=getlen($field_arr[2][$i],$field_arr[3][$i],$row['CD_Intro']);
					$datatmp=ReplaceStr($datatmp,$field_arr[0][$i],$intro);
					break;
				case 'intros':
					$intros=getlen($field_arr[2][$i],$field_arr[3][$i],$row['CD_Intro']);
					$datatmp=ReplaceStr($datatmp,$field_arr[0][$i],str_r_n($intros));
					break;
				case 'time':
					$datatmp=ReplaceStr($datatmp,$field_arr[0][$i],date(ReplaceStr($field_arr[3][$i],'f','i'),strtotime($row['CD_AddTime'])));
					break;
			}
		}
	}
	unset($field_arr);
	return $datatmp;
}

function datasinger($para,$label,$row,$sorti){
	preg_match_all('/\[singer:\s*([0-9a-zA-Z]+)([\s]*[len|style]*)[=]??([\da-zA-Z\-\\\\:\s]*)\]/',$para,$field_arr);
	$datatmp=$label;
	if(!empty($field_arr)){
		for($i=0;$i<count($field_arr[0]);$i++){
			switch($field_arr[1][$i]){
				case 'i':$datatmp=ReplaceStr($datatmp,'[singer:i]',$sorti);break;
				case 'id':$datatmp=ReplaceStr($datatmp,'[singer:id]',$row['CD_ID']);break;
				case 'link':$datatmp=ReplaceStr($datatmp,'[singer:link]',LinkUrl("singer",$row['CD_ID'],1,$row['CD_ID']));break;
				case 'isbest':$datatmp=ReplaceStr($datatmp,'[singer:isbest]',$row['CD_IsBest']);break;
				case 'hits':$datatmp=ReplaceStr($datatmp,'[singer:hits]',$row['CD_Hits']);break;
				case 'pic':$datatmp=ReplaceStr($datatmp,'[singer:pic]',LinkPicUrl($row['CD_Pic']));break;
				case 'userlink':$datatmp=ReplaceStr($datatmp,"[singer:userlink]",linkweburl(GetAlias("qianwei_user","cd_id","cd_name",$row['CD_User']),$row['CD_User']));break;
				case 'name':
					$name=getlen($field_arr[2][$i],$field_arr[3][$i],$row['CD_Name']);
					$datatmp=ReplaceStr($datatmp,$field_arr[0][$i],$name);
					break;
				case 'user':
					$user=getlen($field_arr[2][$i],$field_arr[3][$i],$row['CD_User']);
					$datatmp=ReplaceStr($datatmp,$field_arr[0][$i],$user);
					break;
				case 'area':
					$area=getlen($field_arr[2][$i],$field_arr[3][$i],$row['CD_Area']);
					$datatmp=ReplaceStr($datatmp,$field_arr[0][$i],$area);
					break;
				case 'intro':
					$intro=getlen($field_arr[2][$i],$field_arr[3][$i],$row['CD_Intro']);
					$datatmp=ReplaceStr($datatmp,$field_arr[0][$i],$intro);
					break;
				case 'intros':
					$intros=getlen($field_arr[2][$i],$field_arr[3][$i],$row['CD_Intro']);
					$datatmp=ReplaceStr($datatmp,$field_arr[0][$i],str_r_n($intros));
					break;
				case 'time':
					$datatmp=ReplaceStr($datatmp,$field_arr[0][$i],date(ReplaceStr($field_arr[3][$i],'f','i'),strtotime($row['CD_AddTime'])));
					break;
			}
		}
	}
	unset($field_arr);
	return $datatmp;
}

function datalink($para,$label,$row,$sorti){
	preg_match_all('/\[link:\s*([0-9a-zA-Z]+)([\s]*[len|style]*)[=]??([\da-zA-Z\-\\\\:\s]*)\]/',$para,$field_arr);
	$datatmp=$label;
	if(!empty($field_arr)){
		for($i=0;$i<count($field_arr[0]);$i++){
			switch($field_arr[1][$i]){		
				case 'url':$datatmp=ReplaceStr($datatmp,'[link:url]',$row['cd_url']);break;
				case 'id':$datatmp=ReplaceStr($datatmp,'[link:id]',$row['cd_id']);break;
				case 'i':$datatmp=ReplaceStr($datatmp,'[link:i]',$sorti);break;
				case 'pic':$datatmp=ReplaceStr($datatmp,'[link:pic]',LinkPicUrl($row['cd_pic']));break;
				case 'name':
					$name=getlen($field_arr[2][$i],$field_arr[3][$i],$row['cd_name']);
					$datatmp=ReplaceStr($datatmp,$field_arr[0][$i],$name);
					break;
			}
		}
	}
	unset($field_arr);
	return $datatmp;
}

function datauser($para,$label,$row,$sorti){
	preg_match_all('/\[user:\s*([0-9a-zA-Z]+)([\s]*[len|style]*)[=]??([\da-zA-Z\-\\\\:\s]*)\]/',$para,$field_arr);
	$datatmp=$label;
	if(!empty($field_arr)){
		for($i=0;$i<count($field_arr[0]);$i++){
			switch($field_arr[1][$i]){
				case 'i':$datatmp=ReplaceStr($datatmp,'[user:i]',$sorti);break;
				case 'id':$datatmp=ReplaceStr($datatmp,'[user:id]',$row['cd_id']);break;
				case 'link':$datatmp=ReplaceStr($datatmp,'[user:link]',linkweburl($row['cd_id'],$row['cd_name']));break;
				case 'email':$datatmp=ReplaceStr($datatmp,'[user:email]',$row['cd_email']);break;
				case 'sex':$datatmp=ReplaceStr($datatmp,'[user:sex]',str_sex($row['cd_sex']));break;
				case 'qq':$datatmp=ReplaceStr($datatmp,"[user:qq]",$row['cd_qq']);break;
				case 'points':$datatmp=ReplaceStr($datatmp,"[user:points]",$row['cd_points']);break;
				case 'photo':$datatmp=ReplaceStr($datatmp,'[user:photo]',getavatars($row['cd_id'],0));break;
				case 'photo1':$datatmp=ReplaceStr($datatmp,'[user:photo1]',getavatars($row['cd_id'],1));break;
				case 'photo2':$datatmp=ReplaceStr($datatmp,'[user:photo2]',getavatars($row['cd_id'],2));break;
				case 'address':$datatmp=ReplaceStr($datatmp,"[user:address]",$row['cd_address']);break;
				case 'birthday':$datatmp=ReplaceStr($datatmp,"[user:birthday]",$row['cd_birthday']);break;
				case 'hits':$datatmp=ReplaceStr($datatmp,"[user:hits]",$row['cd_hits']);break;
				case 'rank':$datatmp=ReplaceStr($datatmp,"[user:rank]",$row['cd_rank']);break;
				case 'fans':$datatmp=ReplaceStr($datatmp,"[user:fans]",$row['cd_fansnum']);break;
				case 'music':$datatmp=ReplaceStr($datatmp,"[user:music]",$row['cd_musicnum']);break;
				case 'isbest':$datatmp=ReplaceStr($datatmp,"[user:isbest]",$row['cd_isbest']);break;
				case 'grade':$datatmp=ReplaceStr($datatmp,"[user:grade]",$row['cd_grade']);break;
				case 'name':
					$name=getlen($field_arr[2][$i],$field_arr[3][$i],$row['cd_name']);
					$datatmp=ReplaceStr($datatmp,$field_arr[0][$i],$name);
					break;
				case 'nicheng':
					$nicheng=getlen($field_arr[2][$i],$field_arr[3][$i],$row['cd_nicheng']);
					$datatmp=ReplaceStr($datatmp,$field_arr[0][$i],$nicheng);
					break;
				case 'note':
					$note=getlen($field_arr[2][$i],$field_arr[3][$i],$row['cd_introduce']);
					$datatmp=ReplaceStr($datatmp,$field_arr[0][$i],$note);
					break;
				case 'time':
					$datatmp=ReplaceStr($datatmp,$field_arr[0][$i],date(ReplaceStr($field_arr[3][$i],'f','i'),strtotime($row['cd_regdate'])));
					break;
			}
		}
	}
	unset($field_arr);
	return $datatmp;
}

function Mark_Sql($table,$para,$ids){
	$loop='';$order='';$sort='';$start='';$classid='';$stars='';$specialid='';$singerid='';$sex='';
	preg_match_all('/([a-z0-9]+)=([a-z0-9|,]+)/',$para,$para_arr);
	if(!empty($para_arr)){
		for($i=0;$i<count($para_arr[0]);$i++){
			switch($para_arr[1][$i]){
				case 'loop':$loop=$para_arr[2][$i];break;
				case 'order':$order=$para_arr[2][$i];break;
				case 'sort':$sort=$para_arr[2][$i];break;
				case 'start':$start=$para_arr[2][$i];break;
				case 'classid':$classid=$para_arr[2][$i];break;
				case 'stars':$stars=$para_arr[2][$i];break;
				case 'specialid':$specialid=$para_arr[2][$i];break;
				case 'singerid':$singerid=$para_arr[2][$i];break;
				case 'sex':$sex=$para_arr[2][$i];break;
			}
		}
		$sql="select * from `$table` where";
		if(!isset($order) || empty($order) || $order!="asc"){$order="desc";}
		switch($table){
			case tname("music"):
				if(!isset($start) || empty($start) || $start==0){$start=1;}
				if(!isset($sort) || empty($sort) || $sort=="time"){
					$sort="UNIX_TIMESTAMP(CD_AddTime)";
				}elseif($sort=="rand"){
					$sort="rand()";
				}elseif($sort=="id"){
					$sort="CD_ID";
				}elseif($sort=="hits"){
					$sort="CD_Hits";
				}elseif($sort=="stars"){
					$sort="CD_IsBest";
					$sql.=" CD_IsBest>0 and";
				}elseif($sort=="favhits"){
					$sort="CD_FavHits";
					$sql.=" CD_FavHits>0 and";
				}elseif($sort=="downhits"){
					$sort="CD_DownHits";
					$sql.=" CD_DownHits>0 and";
				}elseif($sort=="goodhits"){
					$sort="CD_GoodHits";
					$sql.=" CD_GoodHits>0 and";
				}elseif($sort=="badhits"){
					$sort="CD_BadHits";
					$sql.=" CD_BadHits>0 and";
				}elseif($sort=="free"){
					$sort="CD_Grade";
					$sql.=" CD_Grade>1 and CD_Points=0 and";
				}else{
					$sort="UNIX_TIMESTAMP(CD_AddTime)";
				}
				if($classid!="all" && !empty($classid) && $classid!="auto"){
					$sql.=" CD_ClassID in ($classid) and";
				}elseif($classid=="auto" && !empty($ids)){
					$sql.=" CD_ClassID in($ids) and";
				}
				if($specialid!="all" && !empty($specialid) && $specialid!="auto"){
					$sql.=" CD_SpecialID in ($specialid) and";
				}elseif($specialid=="auto"){
					$sql.=" CD_SpecialID in ($ids) and";
				}
				if($singerid!="all" && !empty($singerid) && $singerid!="auto"){
					$sql.=" CD_SingerID in ($singerid) and";
				}elseif($singerid=="auto"){
					$sql.=" CD_SingerID in ($ids) and";
				}
				if(!empty($stars) && $stars!="all"){$sql.=" CD_IsBest in ($stars) and";}
				$sql.=" CD_Passed=0 and CD_Deleted=0 and CD_ClassID<>0  order by ".$sort." ".$order;
				if($loop!="all" && !empty($loop)){$sql.=" LIMIT ".($start-1).",".$loop;}
				break;
			case tname("class"):
				if(!isset($start) || empty($start) || $start==0){$start=1;}
				if(!isset($sort) || empty($sort) || $sort=="id"){
					$sort="CD_ID";
				}elseif($sort=="turn"){
					$sort="CD_TheOrder";
				}else{
					$sort="CD_ID";
				}
				if($classid!="all" && !empty($classid) && $classid!="auto"){
					$sql.=" CD_ID in ($classid) and";
				}else{
					$sql.=" CD_FatherID=1 and";
				}
				$sql.=" CD_IsHide=0 order by ".$sort." ".$order;
				if($loop!="all" && !empty($loop)){$sql.=" LIMIT ".($start-1).",".$loop;}
				break;
			case tname("video"):
				if(!isset($start) || empty($start) || $start==0){$start=1;}
				if(!isset($sort) || empty($sort) || $sort=="time"){
					$sort="UNIX_TIMESTAMP(CD_AddTime)";
				}elseif($sort=="id"){
					$sort="CD_ID";
				}elseif($sort=="hits"){
					$sort="CD_Hits";
				}elseif($sort=="stars"){
					$sort="CD_IsBest";
					$sql.=" CD_IsBest>0 and";
				}else{
					$sort="UNIX_TIMESTAMP(CD_AddTime)";
				}
				if($classid!="all" && !empty($classid) && $classid!="auto"){
					$sql.=" CD_ClassID in ($classid) and";
				}elseif($classid=="auto" && !empty($ids)){
					$sql.=" CD_ClassID in($ids) and";
				}
				if($singerid!="all" && !empty($singerid) && $singerid!="auto"){
					$sql.=" CD_SingerID in ($singerid) and";
				}elseif($singerid=="auto"){
					$sql.=" CD_SingerID in ($ids) and";
				}
				if(!empty($stars) && $stars!="all"){$sql.=" CD_IsBest in ($stars) and";}
				$sql.=" CD_IsIndex=0 and CD_ClassID<>0  order by ".$sort." ".$order;
				if($loop!="all" && !empty($loop)){$sql.=" LIMIT ".($start-1).",".$loop;}
				break;
			case tname("videoclass"):
				if(!isset($start) || empty($start) || $start==0){$start=1;}
				if(!isset($sort) || empty($sort) || $sort=="id"){
					$sort="CD_ID";
				}elseif($sort=="turn"){
					$sort="CD_TheOrder";
				}else{
					$sort="CD_ID";
				}
				if($classid!="all" && !empty($classid) && $classid!="auto"){
					$sql.=" CD_ID in ($classid) and";
				}
				$sql.=" CD_IsIndex=0 order by ".$sort." ".$order;
				if($loop!="all" && !empty($loop)){$sql.=" LIMIT ".($start-1).",".$loop;}
				break;
			case tname("special"):
				if(!isset($start) || empty($start) || $start==0){$start=1;}
				if(!isset($sort) || empty($sort) || $sort=="time"){
					$sort="UNIX_TIMESTAMP(CD_AddTime)";
				}elseif($sort=="id"){
					$sort="CD_ID";
				}elseif($sort=="hits"){
					$sort="CD_Hits";
				}elseif($sort=="stars"){
					$sort="CD_IsBest";
					$sql.=" CD_IsBest>0 and";
				}else{
					$sort="UNIX_TIMESTAMP(CD_AddTime)";
				}
				if($classid!="all" && !empty($classid) && $classid!="auto"){
					$sql.=" CD_ClassID in ($classid) and";
				}elseif($classid=="auto" && !empty($ids)){
	                                global $db;
	                                $sqlspecial="select * from ".tname('special')." where CD_ID=".$ids;
	                                $rowspecial=$db->getrow($sqlspecial);
	                                if($rowspecial){
					        $ids=$rowspecial['CD_ClassID'];
	                                }
					$sql.=" CD_ClassID in($ids) and";
				}
				if($singerid!="all" && !empty($singerid) && $singerid!="auto"){
					$sql.=" CD_SingerID in ($singerid) and";
				}elseif($singerid=="auto"){
					$sql.=" CD_SingerID in ($ids) and";
				}
				if(!empty($stars) && $stars!="all"){$sql.=" CD_IsBest in ($stars) and";}
				$sql.=" CD_Passed=0 and CD_ClassID<>0  order by ".$sort." ".$order;
				if($loop!="all" && !empty($loop)){$sql.=" LIMIT ".($start-1).",".$loop;}
				break;
			case tname("singer"):
				if(!isset($start) || empty($start) || $start==0){$start=1;}
				if(!isset($sort) || empty($sort) || $sort=="time"){
					$sort="UNIX_TIMESTAMP(CD_AddTime)";
				}elseif($sort=="id"){
					$sort="CD_ID";
				}elseif($sort=="hits"){
					$sort="CD_Hits";
				}elseif($sort=="stars"){
					$sort="CD_IsBest";
					$sql.=" CD_IsBest>0 and";
				}else{
					$sort="UNIX_TIMESTAMP(CD_AddTime)";
				}
				if(!empty($stars) && $stars!="all"){$sql.=" CD_IsBest in ($stars) and";}
				$sql.=" CD_Passed=0  order by ".$sort." ".$order;
				if($loop!="all" && !empty($loop)){$sql.=" LIMIT ".($start-1).",".$loop;}
				break;
			case tname("link"):
				if(!isset($start) || empty($start) || $start==0){$start=1;}
				if(!isset($sort) || empty($sort) || $sort=="turn"){
					$sort="cd_theorder";
				}elseif($sort=="id"){
					$sort="cd_id";
				}else{
					$sort="cd_theorder";
				}
				if($classid=="pic"){
					$sql.=" cd_classid=2 and";
				}else{
					$sql.=" cd_classid=1 and";
				}
				$sql.=" cd_isverify=0 and cd_isindex=0 order by ".$sort." ".$order;
				if($loop!="all" && !empty($loop)){$sql.=" LIMIT ".($start-1).",".$loop;}
				break;
			case tname("user"):
				if(!isset($start) || empty($start) || $start==0){$start=1;}
				if(!isset($sort) || empty($sort) || $sort=="time"){
					$sort="UNIX_TIMESTAMP(cd_regdate)";
				}elseif($sort=="id"){
					$sort="cd_id";
				}elseif($sort=="hits"){
					$sort="cd_hits";
				}elseif($sort=="rank"){
					$sort="cd_rank";
				}elseif($sort=="points"){
					$sort="cd_points";
				}elseif($sort=="music"){
					$sort="cd_musicnum";
				}elseif($sort=="fans"){
					$sort="cd_fansnum";
				}else{
					$sort="UNIX_TIMESTAMP(cd_regdate)";
				}
				if($stars=="isbest"){
					$sql.=" cd_isbest=1 and";
				}
				if($stars=="music"){
					$sql.=" cd_checkmusic=1 and";
				}
				if($stars=="mm"){
					$sql.=" cd_checkmm=1 and";
				}
				if($sex=="gg"){
					$sql.=" cd_sex=1 and";
				}elseif($sex=="mm"){
					$sql.=" cd_sex=0 and";
				}
				if($stars=="vip"){
					$sql.=" cd_grade=1 and";
				}
				$sql.=" cd_lock=0 order by ".$sort." ".$order;
				if($loop!="all" && !empty($loop)){$sql.=" LIMIT ".($start-1).",".$loop;}
				break;
		}
		unset($para_arr);
		return $sql;
	}
}

function SpanmusicPlay($ids){
	global $db,$userlogined,$qianwei_in_userid,$qianwei_in_username;
	$sql="select * from ".tname('music')." where CD_ID=".$ids;
	$row=$db->getrow($sql);
	if($row){
                if($userlogined){
                        $listensql="select cd_id from ".tname('listen')." where cd_uid=".$qianwei_in_userid." and cd_musicid=".$row['CD_ID'];
                        $listen=$db->getrow($listensql);
                        if($listen){
                                $db->query("update ".tname('listen')." set cd_addtime=".time()." where cd_id=".$listen['cd_id']);
                        }else{
                                $setarr = array(
                                        'cd_uid' => $qianwei_in_userid,
                                        'cd_uname' => $qianwei_in_username,
                                        'cd_musicid' => $row['CD_ID'],
                                        'cd_musicname' => $row['CD_Name'],
                                        'cd_classid' => $row['CD_ClassID'],
                                        'cd_addtime' => time()
                                );
                                inserttable('listen', $setarr, 1);
                        }
                }
		$db->query("update ".tname('music')." set CD_Hits=CD_Hits+1 where CD_ID=".$ids);
		$Mark_Text=@file_get_contents(_qianwei_root_.cd_templatedir.$row['CD_Skin']);
		$Mark_Text=topandbottom($Mark_Text);
		$Mark_Text=Common_Mark($Mark_Text,$row['CD_ClassID']);
		$Mark_Text=datamusic($Mark_Text,$Mark_Text,$row,'1');
		echo $Mark_Text;
	}else{
		die(html_message("错误信息","数据不存在或已被删除！"));
	}
}

function SpanmusicList($ids){
	global $db;
	$data_content="";
	$sql="select * from ".tname('class')." where CD_ID=".$ids;
	$row=$db->getrow($sql);
	if($row){
		if(IsNul($row['CD_Template']) && file_exists(_qianwei_root_.cd_templatedir.$row['CD_Template'])){
			$Mark_Text=@file_get_contents(_qianwei_root_.cd_templatedir.$row['CD_Template']);
		}else{
			$Mark_Text=@file_get_contents(_qianwei_root_.cd_templatedir."list.html");
		}	
	}else{
		$Mark_Text=@file_get_contents(_qianwei_root_.cd_templatedir."list.html");
	}
	$Mark_Text=topandbottom($Mark_Text);
	$Mark_Text=ReplaceStr($Mark_Text,"[music:classname]",$row['CD_Name']);
	$Mark_Text=ReplaceStr($Mark_Text,"[music:aliasname]",$row['CD_AliasName']);
	$Mark_Text=ReplaceStr($Mark_Text,"[music:classlink]",LinkClassUrl("music",$row['CD_ID'],$row['CD_SystemID'],1));
	$Mark_Text=ReplaceStr($Mark_Text,"[music:classid]",$row['CD_ID']);
	$pagenum=getpagenum($Mark_Text);
	preg_match_all('/{qianwei:music(.*?pagesize=([\S]+).*?)}([\s\S]+?){\/qianwei:music}/',$Mark_Text,$page_arr);
	if(!empty($page_arr) && !empty($page_arr[2])){
		$sqlstr=Mark_Sql(tname("music"),$page_arr[1][0],$ids);
		$li="";
		$lis="";
		$lisp="";
		preg_match_all('/<pagestyle>([\s\S]+?)<\/pagestyle>/',$Mark_Text,$page_style);
		if(!empty($page_style) && !empty($page_style[1][0])){
	                $i=explode("|",$page_style[1][0]);
	                $li=$i[0];
	                $lis=$i[1];
	                $lisp=$i[2];
	                $Mark_Text=ReplaceStr($Mark_Text,$page_style[0][0],"");
		}
		$Arr=spanpage("music",$row['CD_ID'],$sqlstr,$page_arr[2][0],$li,$lis,$lisp,$pagenum);
		$result=$db->query($Arr[2]);
		$recount=$db->num_rows($result);
		if($recount==0){
			$data_content="<div align=\"center\">该栏目暂无数据！</div>";
		}else{
			if($result){
				$sorti=1;
				while ($row2 = $db ->fetch_array($result)){
					$datatmp=datamusic($page_arr[0][0],$page_arr[3][0],$row2,$sorti);
					$sorti=$sorti+1;
					$data_content.=$datatmp;
				}
			}
		}
		$Mark_Text=Page_Mark($Mark_Text,$Arr);	
		$Mark_Text=ReplaceStr($Mark_Text,$page_arr[0][0],$data_content);
		unset($Arr);
	}
	preg_match_all('/{qianwei:special(.*?pagesize=([\S]+).*?)}([\s\S]+?){\/qianwei:special}/',$Mark_Text,$page_arr);
	if(!empty($page_arr) && !empty($page_arr[2])){
		$sqlstr=Mark_Sql(tname("special"),$page_arr[1][0],$ids);
		$li="";
		$lis="";
		$lisp="";
		preg_match_all('/<pagestyle>([\s\S]+?)<\/pagestyle>/',$Mark_Text,$page_style);
		if(!empty($page_style) && !empty($page_style[1][0])){
	                $i=explode("|",$page_style[1][0]);
	                $li=$i[0];
	                $lis=$i[1];
	                $lisp=$i[2];
	                $Mark_Text=ReplaceStr($Mark_Text,$page_style[0][0],"");
		}
		$Arr=spanpage("music",$row['CD_ID'],$sqlstr,$page_arr[2][0],$li,$lis,$lisp,$pagenum);
		$result=$db->query($Arr[2]);
		$recount=$db->num_rows($result);
		if($recount==0){
			$data_content="<div align=\"center\">该栏目暂无数据！</div>";
		}else{
			if($result){
				$sorti=1;
				while ($row2 = $db ->fetch_array($result)){
					$datatmp=dataspecial($page_arr[0][0],$page_arr[3][0],$row2,$sorti);
					$sorti=$sorti+1;
					$data_content.=$datatmp;
				}
			}
		}
		$Mark_Text=Page_Mark($Mark_Text,$Arr);	
		$Mark_Text=ReplaceStr($Mark_Text,$page_arr[0][0],$data_content);
		unset($Arr);
	}
	preg_match_all('/{qianwei:singer(.*?pagesize=([\S]+).*?)}([\s\S]+?){\/qianwei:singer}/',$Mark_Text,$page_arr);
	if(!empty($page_arr) && !empty($page_arr[2])){
		$sqlstr=Mark_Sql(tname("singer"),$page_arr[1][0],$ids);
		$li="";
		$lis="";
		$lisp="";
		preg_match_all('/<pagestyle>([\s\S]+?)<\/pagestyle>/',$Mark_Text,$page_style);
		if(!empty($page_style) && !empty($page_style[1][0])){
	                $i=explode("|",$page_style[1][0]);
	                $li=$i[0];
	                $lis=$i[1];
	                $lisp=$i[2];
	                $Mark_Text=ReplaceStr($Mark_Text,$page_style[0][0],"");
		}
		$Arr=spanpage("music",$row['CD_ID'],$sqlstr,$page_arr[2][0],$li,$lis,$lisp,$pagenum);
		$result=$db->query($Arr[2]);
		$recount=$db->num_rows($result);
		if($recount==0){
			$data_content="<div align=\"center\">该栏目暂无数据！</div>";
		}else{
			if($result){
				$sorti=1;
				while ($row2 = $db ->fetch_array($result)){
					$datatmp=datasinger($page_arr[0][0],$page_arr[3][0],$row2,$sorti);
					$sorti=$sorti+1;
					$data_content.=$datatmp;
				}
			}
		}
		$Mark_Text=Page_Mark($Mark_Text,$Arr);	
		$Mark_Text=ReplaceStr($Mark_Text,$page_arr[0][0],$data_content);
		unset($Arr);
	}
	unset($page_arr);
	unset($page_style);
	$Mark_Text=Common_Mark($Mark_Text,$ids);
	echo $Mark_Text;
}

function SpanvideoIntro($ids){
	global $db;
	$sql="select * from ".tname('video')." where CD_ID=".$ids;
	$row=$db->getrow($sql);
	if($row){
		$db->query("update ".tname('video')." set CD_Hits=CD_Hits+1 where CD_ID=".$ids);
		$Mark_Text=@file_get_contents(_qianwei_root_.cd_templatedir."video.html");
		$Mark_Text=topandbottom($Mark_Text);
		$Mark_Text=Common_Mark($Mark_Text,$row['CD_ClassID']);
		$Mark_Text=datavideo($Mark_Text,$Mark_Text,$row,'1');
		echo $Mark_Text;
	}else{
		die(html_message("错误信息","数据不存在或已被删除！"));
	}
}

function SpanvideoList($ids){
	global $db;
	$data_content="";
	$sql="select * from ".tname('videoclass')." where CD_ID=".$ids;
	$row=$db->getrow($sql);
	if($row){
		$Mark_Text=@file_get_contents(_qianwei_root_.cd_templatedir."videolist.html");	
	}else{
		$Mark_Text=@file_get_contents(_qianwei_root_.cd_templatedir."videolist.html");
	}
	$Mark_Text=topandbottom($Mark_Text);
	$Mark_Text=ReplaceStr($Mark_Text,"[video:classname]",$row['CD_Name']);
	$Mark_Text=ReplaceStr($Mark_Text,"[video:classlink]",LinkClassUrl("video",$row['CD_ID'],"",1));
	$Mark_Text=ReplaceStr($Mark_Text,"[video:classid]",$row['CD_ID']);
	$pagenum=getpagenum($Mark_Text);
	preg_match_all('/{qianwei:video(.*?pagesize=([\S]+).*?)}([\s\S]+?){\/qianwei:video}/',$Mark_Text,$page_arr);
	if(!empty($page_arr) && !empty($page_arr[2])){
		$sqlstr=Mark_Sql(tname("video"),$page_arr[1][0],$ids);
		$li="";
		$lis="";
		$lisp="";
		preg_match_all('/<pagestyle>([\s\S]+?)<\/pagestyle>/',$Mark_Text,$page_style);
		if(!empty($page_style) && !empty($page_style[1][0])){
	                $i=explode("|",$page_style[1][0]);
	                $li=$i[0];
	                $lis=$i[1];
	                $lisp=$i[2];
	                $Mark_Text=ReplaceStr($Mark_Text,$page_style[0][0],"");
		}
		$Arr=spanpage("video",$row['CD_ID'],$sqlstr,$page_arr[2][0],$li,$lis,$lisp,$pagenum);
		$result=$db->query($Arr[2]);
		$recount=$db->num_rows($result);
		if($recount==0){
			$data_content="<div align=\"center\">该栏目暂无数据！</div>";
		}else{
			if($result){
				$sorti=1;
				while ($row2 = $db ->fetch_array($result)){
					$datatmp=datavideo($page_arr[0][0],$page_arr[3][0],$row2,$sorti);
					$sorti=$sorti+1;
					$data_content.=$datatmp;
				}
			}
		}
		$Mark_Text=Page_Mark($Mark_Text,$Arr);	
		$Mark_Text=ReplaceStr($Mark_Text,$page_arr[0][0],$data_content);
		unset($Arr);
	}
	unset($page_arr);
	unset($page_style);
	$Mark_Text=Common_Mark($Mark_Text,$ids);
	echo $Mark_Text;
}

function SpanmusicSpecial($ids){
	global $db;
	$sql="select * from ".tname('special')." where CD_ID=".$ids;
	$row=$db->getrow($sql);
	if($row){
		$db->query("update ".tname('special')." set CD_Hits=CD_Hits+1 where CD_ID=".$ids);
		$Mark_Text=@file_get_contents(_qianwei_root_.cd_templatedir."special.html");
		$Mark_Text=topandbottom($Mark_Text);
		$Mark_Text=Common_Mark($Mark_Text,$row['CD_ID']);
		$Mark_Text=dataspecial($Mark_Text,$Mark_Text,$row,'1');
		echo $Mark_Text;
	}else{
		die(html_message("错误信息","数据不存在或已被删除！"));
	}
}

function SpanmusicSinger($ids){
	global $db;
	$sql="select * from ".tname('singer')." where CD_ID=".$ids;
	$row=$db->getrow($sql);
	if($row){
		$db->query("update ".tname('singer')." set CD_Hits=CD_Hits+1 where CD_ID=".$ids);
		$Mark_Text=@file_get_contents(_qianwei_root_.cd_templatedir."singer.html");
		$Mark_Text=topandbottom($Mark_Text);
		$Mark_Text=Common_Mark($Mark_Text,$row['CD_ID']);
		$Mark_Text=datasinger($Mark_Text,$Mark_Text,$row,'1');
		echo $Mark_Text;
	}else{
		die(html_message("错误信息","数据不存在或已被删除！"));
	}
}

function SpanmusicDown($ids){
	global $db;
	$sql="select * from ".tname('music')." where CD_ID=".$ids;
	$row=$db->getrow($sql);
	if($row){
		$Mark_Text=@file_get_contents(_qianwei_root_.cd_templatedir."down.html");
		$Mark_Text=topandbottom($Mark_Text);
		$Mark_Text=Common_Mark($Mark_Text,$row['CD_ClassID']);
		$Mark_Text=datamusic($Mark_Text,$Mark_Text,$row,'1');
		echo $Mark_Text;
	}else{
		die(html_message("错误信息","数据不存在或已被删除！"));
	}
}

function SpanmusicPage($ids){
	global $db;
	$sql="select * from ".tname('page')." where cd_id=".$ids;
	$row=$db->getrow($sql);
	if($row){
		$Mark_Text=@file_get_contents(_qianwei_root_.cd_templatedir.$row['cd_template']);
		$Mark_Text=topandbottom($Mark_Text);
		$Mark_Text=Common_Mark($Mark_Text,$ids);
		echo $Mark_Text;
	}else{
		die(html_message("错误信息","数据不存在或已被删除！"));
	}
}

function getpagenum($Mark_Text){
	preg_match('/\{qianwei:(pagenum)\s*([a-zA-Z=]*)\s*([\d]*)\}/',$Mark_Text,$pagearr);
	if(!empty($pagearr)){
		if(trim($pagearr[3])!=""){
			$pagenum=$pagearr[3];
		}else{
			$pagenum=10;
		}	
	}else{
		$pagenum=10;
	}
	unset($pagearr);
	return $pagenum;
}

function spanpage($Table,$id,$mysql,$pagesize,$li,$lis,$lisp,$pagenum=10){
	global $db;
	$qianwei_ID=explode("/",$_SERVER['PATH_INFO']);
	$qianwei_ID[2]=$id;
	$pages=$qianwei_ID[3];
	$pagesok=$pagesize;
  	if (!isset($pages)||$pages==""||!is_numeric($pages)||$pages<=0) $pages=1;
  	$sqlstr=$mysql;
  	$res=$db -> query($sqlstr);
 	$nums= $db -> num_rows($res);
	if($nums==0){$nums=1;}
	$pagejs=ceil($nums/$pagesok);
	if($pages>$pagejs){
		$pages=$pagejs;
	}
	$sql=$sqlstr." LIMIT ".$pagesok*($pages-1).",".$pagesok;
	$result = $db -> query($sql);
	$str="";
	$first=LinkClassUrl($Table,$id,1,1);
	$pageup=LinkClassUrl($Table,$qianwei_ID[2],1,($pages-1)==0?1:($pages-1));
	$pagenext=LinkClassUrl($Table,$qianwei_ID[2],1,($pages+1));
	$last=LinkClassUrl($Table,$qianwei_ID[2],1,$pagejs);
	$pagelist="<select onchange=\"window.location.href=''+this.options[this.selectedIndex].value+'';\">\r\n<option value=\"".LinkClassUrl($Table,$qianwei_ID[2],1,1)."\">跳转</option>\r\n";
	for($k=1;$k<=$pagejs;$k++){
		if($k==$pages){
			$pagelist.="<option value=\"".LinkClassUrl($Table,$qianwei_ID[2],1,$k)."\" selected>第".$k."页</option>\r\n";
	        }else{
			$pagelist.="<option value=\"".LinkClassUrl($Table,$qianwei_ID[2],1,$k)."\">第".$k."页</option>\r\n";
	        }
	}
	$pagelist.="</select>";
	if($pagejs<=$pagenum){
  		for($i=1;$i<=$pagejs;$i++){
   			if($i==$pages){
   				$str.=ReplaceStr($lis,"[link]",LinkClassUrl($Table,$qianwei_ID[2],1,$i)).$i.$lisp;
   			}else{
   				$str.=ReplaceStr($li,"[link]",LinkClassUrl($Table,$qianwei_ID[2],1,$i)).$i.$lisp;
   			}
 	 	}
	}else{
 		if($pages>=($pagenum)){
 			for($i=$pages-intval($pagenum/2);$i<=$pages+(intval($pagenum/2));$i++){
   				if($i<=$pagejs){
   				        if($i==$pages){
   						$str.=ReplaceStr($lis,"[link]",LinkClassUrl($Table,$qianwei_ID[2],1,$i)).$i.$lisp;
   				        }else{
   						$str.=ReplaceStr($li,"[link]",LinkClassUrl($Table,$qianwei_ID[2],1,$i)).$i.$lisp;
   				        }
    				}
  			}
   		}else{
  			for($i=1;$i<=$pagenum;$i++){
   				if($i==$pages){
   					$str.=ReplaceStr($lis,"[link]",LinkClassUrl($Table,$qianwei_ID[2],1,$i)).$i.$lisp;
   				}else{
   					$str.=ReplaceStr($li,"[link]",LinkClassUrl($Table,$qianwei_ID[2],1,$i)).$i.$lisp;
   				}
 			}
 		 }
	}
	while ($row = $db -> fetch_array($result) ){ }
	$arr=array($str,$result,$sql,$nums,$pagelist,$pages,$pagejs,$first,$pageup,$pagenext,$last,$pagesok);
	@mysql_free_result($res);
	return $arr;
}

function Page_Mark($Mark_Text,$Arr){
	$Mark_Text=preg_replace('/\{qianwei:pagenum(.*?)\}/','{qianwei:pagenum}',$Mark_Text);
	$Mark_Text=ReplaceStr($Mark_Text,'{qianwei:pagedata}',$Arr[3]);
	$Mark_Text=ReplaceStr($Mark_Text,'{qianwei:pagedown}',$Arr[9]);
	$Mark_Text=ReplaceStr($Mark_Text,'{qianwei:pagenow}',$Arr[5]);
	$Mark_Text=ReplaceStr($Mark_Text,'{qianwei:pagecout}',$Arr[6]);
	$Mark_Text=ReplaceStr($Mark_Text,'{qianwei:pagelist}',$Arr[4]);
	$Mark_Text=ReplaceStr($Mark_Text,'{qianwei:pagesize}',$Arr[11]);
	$Mark_Text=ReplaceStr($Mark_Text,'{qianwei:pagefirst}',$Arr[7]);
	$Mark_Text=ReplaceStr($Mark_Text,'{qianwei:pageup}',$Arr[8]);
	$Mark_Text=ReplaceStr($Mark_Text,'{qianwei:pagenum}',$Arr[0]);
	$Mark_Text=ReplaceStr($Mark_Text,'{qianwei:pagelast}',$Arr[10]);	
	return $Mark_Text;
}

function labelif($Mark_Text){
	$prg='/{if:(.*?)}(.*?){end if}/';
	preg_match_all($prg,$Mark_Text,$arr);
	if(!empty($arr[0]) && !empty($arr[0][0])){
		for($i=0;$i<count($arr[0]);$i++){
			$else=explode('{else}',$arr[2][$i]);
			if(count($else)==2){
				$evalstr="if(".$arr[1][$i]."){return '".$else[0]."';}else{return '".$else[1]."';}";	
				$str=eval($evalstr);
				$Mark_Text=ReplaceStr($Mark_Text,$arr[0][$i],$str);
			}else{
				$evalstr="if(".$arr[1][$i]."){return '".$arr[2][$i]."';}";
				$str=eval($evalstr);
				$Mark_Text=ReplaceStr($Mark_Text,$arr[0][$i],$str);
			}
		}
	}
	return $Mark_Text;
}
?>