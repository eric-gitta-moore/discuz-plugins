	function move_action(){
		var tocid = $('varsnew').value;
		var form = $('acp_papers_form');
		form.action += '&move='+tocid;
		form.submit();
	}		
	
	
	function acp_papers(mod){
		if(mod=='move'){
			showDialog($('cateDialog').innerHTML,'info','&#x6DFB;&#x52A0;&#x8BD5;&#x5377;',0,1);//Ìí¼ÓÊÔ¾í
		}
		else if(!isNaN(mod)){
			var form = $('acp_papers_form');
			form.action += "&color="+mod;
			form.submit();
		}else{
			var form = $('acp_papers_form');
			form.action += '&'+mod+'=yes';
			form.submit();
		}
	}

	var modclickcount=0;
	function pmodclick(obj) {
		if(obj.checked) {
			modclickcount++;
		} else {
			modclickcount--;
		}
		$('mdct').innerHTML = modclickcount;
		if(modclickcount > 0) {
			var top_offset = obj.offsetTop;
			while((obj = obj.offsetParent) && obj.id != 'threadlist') {
				top_offset += obj.offsetTop;
			}
			$('mdly').style.top = top_offset - 7 + 'px';
			$('mdly').style.display = '';
		} else {
			$('mdly').style.display = 'none';
		}
	}

	var mn_cid=0;
	function mn_change(cid, bOpen){
		var cites = $('menu_cate').getElementsByTagName('cite');
		var dts = $('menu_cate').getElementsByTagName('dt');
		
		if(typeof cid=='undefined'){cid = mn_cid = - !mn_cid;}
		
		var cids = new Array();
		for(var i=0; i<cites.length; i++)
		{
			var cite_cid = cites[i].getAttribute('cid');
			if(cid == cite_cid || cid<=0){
				if(cites[i].style.display=='none' || cid==-1){
					cites[i].style.display = 'block';
					dts[i].getElementsByTagName('span')[0].className = 'tree_icon_cate_open'
				}else if(bOpen!=1){
					cites[i].style.display = 'none';
					dts[i].getElementsByTagName('span')[0].className = 'tree_icon_cate_close'
				}
			}
			if(cites[i].style.display!='none'){
				cids.push(cite_cid);
			}
		}

		setcookie('cookie_cate', cids.join(';'), 1296000);
		return false;
	}
