
function ding(the){the.className = the.className!='ding_on' ? 'ding_on' : 'ding_off';}

function cal_score(){
	var tds = $('nobox').getElementsByTagName('td');
	var total = 0;
	console.log(tds)
	
	for(var i = 0; i<tds.length; i++){
		var td = tds[i];		
		var type   = td.getAttribute('type');
		var result = td.getAttribute('result');
		//var answer = td.getAttribute('answer');
		var answer = td.getElementsByTagName('input')[0].value;
		if(answer!=''){
			if(type<=3)
			{	
				if(result==answer){
					total += parseFloat(td.getAttribute('score'));
					td.style.textDecoration = '';
					td.style.color = 'green';
				}else{
					td.style.textDecoration = 'line-through';
					td.style.color = 'red';
				}
				
			}else{
				if(answer>0){
					total += parseFloat(answer);
					td.style.textDecoration = 'none';
					td.style.color = '';
				}else{
					td.style.textDecoration = 'line-through';
					td.style.color = 'red';
				}
			}
		}
		else{
			td.style.textDecoration = 'line-through';
		}
	}
	return total;
}
var RESULT = '';
var last_submit_time = 0;
function submit()
{
	if(((new Date()).getTime() - last_submit_time)<11000){
		return;
	}

	last_submit_time = (new Date()).getTime();

	if(RESULT!=''){
		return;
	}
    

    jq.post(jq("#examination_form").attr("action"), jq("#examination_form").serialize(), function(v){

         ajaxresult = v;
         
		if(ajaxresult=='checkPaperFalse'){
			alert('Not login or Your group has no authority');
			return false;
		}
		else if(ajaxresult.substr(0,5)=='score'){
			var uscore = ajaxresult.substr(6);
			var msg = "&#x6211;&#x7684;&#x5F97;&#x5206;: "+uscore+"&#x5206;<br>" + $('summary').innerText;
			$('submitbox').innerHTML = msg;
			$('p_msg').style.display='block';
			return false;
		}
		else if(ajaxresult.substr(0,1)=='{'){
			RESULT = eval( '(' + ajaxresult + ')' );

			var tds = $('nobox').getElementsByTagName('td');

			for(var i = 0; i<tds.length;i++){
				var td = tds[i];
				var eid=td.getAttribute('id');
				var e  = RESULT[eid];
				if(e){
					var type = td.getAttribute('type');
					td.setAttribute('result', e['sys_result']);
					td.setAttribute('note', e['sys_note']);
				}
	
			}

	
			var uscore = cal_score();
			var msg = "&#x6211;&#x7684;&#x5F97;&#x5206;: "+uscore+"&#x5206;<br>" + $('summary').innerText;
			$('submitbox').innerHTML = msg;
			$('p_msg').style.display='block';

			show_exam(eidArr[$('seek').innerHTML-1]);
		}
		else if(ajaxresult=='re_subject'){
			alert('Ã·ΩªÃ´∆µ∑±,«Î÷ÿ ‘...');
			//alert('&#x63D0;&#x4EA4;&#x9891;&#x7E41;, 10&#x79D2;&#x540E;&#x91CD;&#x8BD5;');
		}
		else{
			alert('Œ¥÷™¥ÌŒÛ');
			//alert('&#x672A;&#x77E5;&#x9519;&#x8BEF;');
		}
	});
}

function nv_click(mode)
{
	if(RESULT=='')$('p_msg').style.display='none';
		
	if(mode=='no'){
		$('submitbox').style.display='none';
		var nb = $('numbox');
		nb.style.display = nb.style.display=='block' ? 'none' : 'block';
	}
	else if(mode=='prev'){
		$('submitbox').style.display='none'; 
		var k = Math.max(1, parseInt($('seek').innerHTML)-1);
		show_exam(eidArr[k-1]);
		$('seek').innerHTML = k;
	}
	else if(mode=='next'){
		$('submitbox').style.display='none';
		var k = Math.min(eidArr.length, parseInt($('seek').innerHTML)+1);
		show_exam(eidArr[k-1]);
		$('seek').innerHTML = k;
	}
	else if(mode=='submit'){
		$('numbox').style.display='none';
		var sb = $('submitbox');
		sb.style.display = sb.style.display=='block' ? 'none' : 'block';
	}		
	else if(mode=='result'){
		var k = Math.max(1, parseInt($('seek').innerHTML));
		var td = $(eidArr[k-1]);
		var result = td.getAttribute('_result');
		var note = td.getAttribute('_note');
		var type = td.getAttribute('type');
		$('p_result').innerHTML  = '&#x53C2;&#x8003;&#x7B54;&#x6848;: '+ (type==1?(result==1?'&#x6B63;&#x786E;':'&#x9519;&#x8BEF;'): result);
		$('p_note').innerHTML    = '&#x672C;&#x9898;&#x89E3;&#x91CA;: '+  note;
		$('p_msg').style.display ='block';
	}				
}

function elabel(eid, v)
{
	if($('p_msg').style.display=='block')
		return;

	var td   = $(eid);
	var type = td.getAttribute('type');
	var lis  = $('p_data').getElementsByTagName('li');

	if(type==3){
		var str = '';
		for(var i=0;i<lis.length;i++){
			if(lis[i].getAttribute('value')==v){
				lis[i].className =  lis[i].className=='option_on' ? 'option_off' : 'option_on';
			}
			if(lis[i].className=='option_on')str += lis[i].getAttribute('value');
		}
		//td.setAttribute('answer', str);
		td.getElementsByTagName('input')[0].value=str
	}else{
		for(var i=0;i<lis.length;i++){
			lis[i].className = lis[i].getAttribute('value')==v ? 'check_on' : 'check_off';
		}
		//td.setAttribute('answer', v);
		td.getElementsByTagName('input')[0].value = v;
	}
	td.style.color = 'blue';
}

var type_string = {1:'&#x5224;&#x65AD;&#x9898;', 2:'&#x5355;&#x9009;&#x9898;', 3:'&#x591A;&#x9009;&#x9898;', 4:'&#x586B;&#x7A7A;&#x9898;', 5:'&#x95EE;&#x7B54;&#x9898;'}

function show_exam(eid)
{
	var the    = $(eid);
	var groupct= the.getAttribute('group');
	var type   = the.getAttribute('type');
	var score  = the.getAttribute('score');
	var result = the.getAttribute('result');
	var answer = the.getElementsByTagName('input')[0].value;//the.getAttribute('answer');
	var subject= the.getAttribute('subject');
	var data   = the.getAttribute('data');
	var note   = the.getAttribute('note');
	var image  = the.getAttribute('image');

	$('p_subject').innerHTML = '['+type_string[type] +'] '+ subject + '('+score+'&#x5206;)';
	$('p_image').innerHTML = image=='' ? '' : '<img src="'+image+'" border=0>';

	var datastr ='';
	var bPass = false;
	if(type==1){
		datastr += '<li class="'+(answer==1?"check_on":"check_off")+'" value="1" onclick="elabel('+eid+', 1)">&#x6B63;&#x786E;</li>';
		datastr += '<li class="'+(answer==2?"check_on":"check_off")+'" value="2" onclick="elabel('+eid+', 2)">&#x9519;&#x8BEF;</li>';
		bPass = answer && answer == result;
	}
	if(type==2 || type==3){
		var arr = data.split("\n");
		var nA = 65;
		for(var k=0 in arr){
			var A = String.fromCharCode(nA++);
			datastr += '<li class="'+(type==2 ? 'check' : 'option')+(answer.indexOf(A)==-1?"_off":"_on")+'" value="'+A+'" onclick="elabel('+eid+',\''+A+'\')">' + A +'. '+ arr[k] + '</li>';
		}
		bPass = answer && answer == result;
	}
	else if(type==4 || type==5){
		datastr += '<li class="'+(answer==='0'    ?"check_on":"check_off")+'" value="0"           onclick="elabel('+eid+', 0)">&#x81EA;&#x6211;&#x8BC4;&#x5206;: 0 &#x5206;</li>'
		datastr += '<li class="'+(answer==score/2 ?"check_on":"check_off")+'" value="'+score/2+'" onclick="elabel('+eid+', '+score/2+')">&#x81EA;&#x6211;&#x8BC4;&#x5206;: '+score/2+' &#x5206;</li>'
		datastr += '<li class="'+(answer==score   ?"check_on":"check_off")+'" value="'+score+'"   onclick="elabel('+eid+', '+score+')">&#x81EA;&#x6211;&#x8BC4;&#x5206;: '+score  +' &#x5206;</li>'
		datastr += '<div class="p_data_msg">(&#x6CE8;: &#x624B;&#x673A;&#x7248;&#x586B;&#x7A7A;&#x9898;&#x548C;&#x95EE;&#x7B54;&#x9898;&#x53EA;&#x652F;&#x6301;&#x81EA;&#x6211;&#x8BC4;&#x5206;)</div>'
		bPass = answer > 0;
	}
	$('p_data').innerHTML  = datastr;
	$('p_groupct').innerHTML  = groupct;
 
	if($('p_msg').style.display=='block'){
		$('p_icon').className = bPass? 'icon_right' : 'icon_wrong'	 
		$('p_result').innerHTML = '&#x53C2;&#x8003;&#x7B54;&#x6848;: '+ (type==1?(result==1?'&#x6B63;&#x786E;':'&#x9519;&#x8BEF;'): result)					
		$('p_note').innerHTML = !note ? '' : '&#x672C;&#x9898;&#x89E3;&#x91CA;:<br>'+note;
	}
}

	
	