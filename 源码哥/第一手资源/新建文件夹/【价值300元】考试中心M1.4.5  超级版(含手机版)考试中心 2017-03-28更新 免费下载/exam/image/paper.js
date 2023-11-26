		function exam_note_show(eid){
			showWindow('ajaxwaitid', 'plugin.php?id=exam:ajax&formhash='+formhash+'&action=user_show_exam_note&eid='+eid+'&'+Math.random() );
		}

		function label_click(input){
			var eid = input.parentNode.getAttribute('eid');
			var exam     = $('item_'+eid);
			var etype	 = exam.getAttribute('type');
 
			(input.type.toLowerCase()=='radio') && input.checked && (getInputValue(eid)==exam.getAttribute('result')) && (input.checked = false);

			var newvalue = getInputValue(eid);	

			exam.setAttribute('result', newvalue)
 
			if(	newvalue == '' ){
				if(rgb2hex(exam.parentNode.style.backgroundColor) != COLOR_FLAG)
					exam.parentNode.style.background = COLOR_UNSELECT;
				$('a_'+eid).className = 'e_undo';
			}else{

				if(rgb2hex(exam.parentNode.style.backgroundColor) != COLOR_FLAG)
					exam.parentNode.style.background = COLOR_SELECT;
				$('a_'+eid).className = 'e_right';//e_do
			}

			if(RESULT){
				if(etype<=4){
					RESULT[eid]['user_result'] = newvalue;
				}else if(etype==5){
					RESULT[eid]['user_score']  = newvalue;
				}
				result_msg_print();
			}

		}
 
		var exam_submit_status = 0;
		function exam_submit_check(){
			if(exam_submit_status==0){
				showError('&#x6B63;&#x5728;&#x63D0;&#x4EA4;&#x4E2D;, &#x8BF7;&#x7A0D;&#x7B49;...');
			}
			else if(exam_submit_status==1){
				showError('&#x6B63;&#x5728;&#x63D0;&#x4EA4;&#x4E2D;, &#x8BF7;&#x7A0D;&#x7B49;...');
			}
			else if(exam_submit_status==2){
				showError('&#x4F60;&#x5DF2;&#x7ECF;&#x4EA4;&#x5377;!');
			}
			else if(exam_submit_status==-1){
				showError('&#x63D0;&#x4EA4;&#x5931;&#x8D25;');
			}
		}
 
 		function exam_submit(){
			exam_submit_check();
			exam_submit_get_result();
		}	
		
		function exam_submit_get_result(){
			if(exam_submit_status!=0)
				return;


			if(TIME_LEFT>0 && SUBMIT_WAIT-TIME_PASS>0){
				//showError('考试开始后至少 '+ Math.ceil(SUBMIT_WAIT/60) +' 分钟后才能交卷, 请再等待: '+  time_second_ms(SUBMIT_WAIT-TIME_PASS));
				showError('&#x8003;&#x8BD5;&#x5F00;&#x59CB;&#x540E;&#x81F3;&#x5C11; '+ Math.ceil(SUBMIT_WAIT/60) +' &#x5206;&#x949F;&#x540E;&#x624D;&#x80FD;&#x4EA4;&#x5377;, &#x8BF7;&#x518D;&#x7B49;&#x5F85;: '+  time_second_ms(SUBMIT_WAIT-TIME_PASS));	
				return;
			}
			exam_submit_status = 1;
			
			if(!RESULT){
                jq.post(jq("#examination_form").attr("action"), jq("#examination_form").serialize(), function(v)
                {
					var ajaxresult = v;
					ajaxresult = ajaxresult.replace(/&lt;/g, '<');
					ajaxresult = ajaxresult.replace(/&gt;/g, '>');
					ajaxresult = ajaxresult.replace(/&#61;/g, '=');

					if($('showUserInfoli')){
						if($('userinfo[]'))
							$('showUserInfoli').innerHTML = '';
						else
							$('showUserInfoli').style.display = 'none';
					}
 
					//if(ajaxresult=='' || ajaxresult=='null_post' || ajaxresult=='null_pid' || ajaxresult=='null_score' ){
					//	return false;
					//}
					if(ajaxresult=='re_subject'){
						showError('&#x6B63;&#x5728;&#x51C6;&#x5907;&#x4E2D;, 10&#x79D2;&#x540E;&#x8BF7;&#x91CD;&#x8BD5;...');
						exam_submit_status = 0;
						return false;
					}					
					else if(ajaxresult.substr(0,5)=='score'){
						showError('&#x4EA4;&#x5377;&#x6210;&#x529F;');
						var user_score = ajaxresult.substr(6);
						$('p_result').innerHTML = '<p><em>'+user_score+'</em>&#x5206;</p><p>'+(user_score >= SCORE_PASS ? '&#x6210;&#x7EE9;&#x5408;&#x683C;' : '&#x6210;&#x7EE9;&#x4E0D;&#x5408;&#x683C;')+'</p>';
						$('p_time').style.display = 'none';		
						exam_submit_status = 2;
						//if(user_score>=100){
						//	window.open('网址')
						//}
						return false;
					}
					else if(ajaxresult.substr(0,1)!='{'){
						showError('&#x83B7;&#x53D6;&#x6570;&#x62A4;&#x5931;&#x8D25;');
						exam_submit_status = -1;
						return false;
					}

					exam_submit_status = 2;
					
					$('append_parent').innerHTML='';
						
					RESULT = eval( '(' + ajaxresult + ')' );
					var user_score = result_msg_print();
					
					//if(user_score>=100){
					//	window.open('网址')
					//}

					$('ajaxresult').innerHTML = '';
					$('counter').style.visibility   = 'visible';
					$('counter').style.marginTop    = '15px';
					$('counter').style.marginBottom = '20px';
					$('p_time').style.display 		= 'none';		
				}); 
			}
		}

		function each_exam_score_cal(eid){
 
			if(!RESULT)return -2;
			var e = RESULT[eid];
			var score = 0;
			if(e['type']<=4){
				if(e['user_result'].toString().replace(/(^\s*)/g,'') === ''){
					score = -1;
				}else if(e['user_result'].toString() === e['sys_result'].toString()){
					score = e['sys_score']==0 ? '' : e['sys_score'] * 1;
				}else{
					score = 0;
				}
			}else if(e['type']==5){
				if(e['user_score'].toString().replace(/(^\s*)/g,'') === ''){
					score = -1;
				}else{
					score = e['user_score'] * 1;
				}
			}
	 
			return score;//-2:没有答案;-1:未做; 0:错误;  >0:正确
		}

		function result_msg_print(){
 			if(!RESULT)return;
			var user_score  = 0;
			var count_right = 0;
			var count_undo  = 0;
			var count_wrong = 0;
 
			var marks = $('examination_form').getElementsByTagName('map');

			for(var i=0; i<marks.length; i++){
				var mark  = marks[i];
				var eid   = mark.getAttribute('eid');
				var score = each_exam_score_cal( eid );//用户得分
 
				var cite  = mark.getElementsByTagName('cite')[0];
				//cite.style.visibility = 'visible';

				cite.style.display = 'inline-block';

				var spans = cite.getElementsByTagName('span');
				spans[0].className = (score > 0 || score ==='') ? 'right' : 'wrong'; 
				spans[1].innerHTML = RESULT[eid]['type']==5 ? '<p style="font-size:12px">'+RESULT[eid]['sys_result']+'</p>' : (RESULT[eid]['type']==1 ? (RESULT[eid]['sys_result'].toString()==1 ? '&#x6B63;&#x786E;' : (RESULT[eid]['sys_result'].toString()==2 ? '&#x9519;&#x8BEF;' : '')) : RESULT[eid]['sys_result']);

				if(score<=-1){//未作
					count_undo++;
					$('a_'+eid).className = 'e_wrong';
				}else if(score===0){//得分0,答题错误
					count_wrong++;
					$('a_'+eid).className = 'e_wrong';
				}else{//有得分,正确
					count_right++;
					user_score += score;
					$('a_'+eid).className = 'e_right';
				}

			}

			$('count_do').innerHTML    = count_right + count_wrong;
			$('count_wrong').innerHTML = count_wrong;
			$('count_undo').innerHTML  = count_undo;

			$('p_result').innerHTML = '<p><em>'+user_score+'</em>&#x5206;</p><p>'+(user_score >= SCORE_PASS ? '&#x6210;&#x7EE9;&#x5408;&#x683C;' : '&#x6210;&#x7EE9;&#x4E0D;&#x5408;&#x683C;')+'</p>';//成绩合格' : '成绩不合格

			TIME_LEFT = -1;
			time_counter();
			return user_score;
		}


		function getInputValue(eid){
			var item = document.getElementsByName('e_'+eid+'[]');
			var itemvalue = '';

			for(var i=0; i<item.length; i++){
				if(item[i].type=='checkbox' && item[i].checked){ 
					itemvalue += item[i].value;
				}else if(item[i].type=='radio' && item[i].checked){ 
					itemvalue = item[i].value;
					break;
				}else if(item[i].type=='text' || item[i].type=='hidden'){ 
					itemvalue += item[i].value + "\n";
				}
			}
			return itemvalue.replace(/^(\s+)|(\s+)$/g, '');
		}

		//对列表中的每一道试题绑定鼠标事件,绑定在label上面,单选题,多选题,判断题绑定onclick, 填空和完形填空绑定在onchange
		function label_bind_click(){
			var form = $('examination_form');
			if(!form)return false;
			var marks = form.getElementsByTagName('map');
			if(!marks)return false;
			


			for(var i=0; i<marks.length; i++){
				var labels= marks[i].getElementsByTagName('label');
				var type  = marks[i].getAttribute('type');
				var score = marks[i].getAttribute('score');
				var eid   = marks[i].getAttribute('eid');
				for(var j=0; j<labels.length; j++){
					labels[j].setAttribute('type',  type);
					labels[j].setAttribute('score', score);
					labels[j].setAttribute('eid',   eid); 
					if(type<=3){
						labels[j].onclick  = function(e){
							e = e || window.event;
							var input =  e.srcElement || e.target;
							if(input.tagName.toLowerCase()=='input'){
								label_click(input);
							}
						}
					}else if(type==4){
						labels[j].onchange = function(e){
							e = e || window.event;
							var input =  e.srcElement || e.target;
							var tname = input.tagName.toLowerCase();
							if(tname=='input' || tname=='select' ){
								label_click(input);
							}
						}

					}else if(type==5){
						labels[j].onchange = function(e){
							e = e || window.event;
							var input =  e.srcElement || e.target;
							if(input.tagName.toLowerCase()=='input'){
								var score = this.getAttribute('score');
								if(!input.value.match(/^[\d\.]+$/)){
									//showError('自我估分错误,请输入合理的分值!');
									showError('&#x81EA;&#x6211;&#x4F30;&#x5206;&#x9519;&#x8BEF;,&#x8BF7;&#x8F93;&#x5165;&#x5408;&#x7406;&#x7684;&#x5206;&#x503C;!');
								}else if(input.type=='text' && input.value*1 > score*1){
									//showError('自我估分高于满分, 系统自动修正为满分('+score+'分).');
									showError('&#x81EA;&#x6211;&#x4F30;&#x5206;&#x9AD8;&#x4E8E;&#x6EE1;&#x5206;, &#x7CFB;&#x7EDF;&#x81EA;&#x52A8;&#x4FEE;&#x6B63;&#x4E3A;&#x6EE1;&#x5206;('+score+'&#x5206;).');
									input.value = score;
								}
								label_click(input);
							}
						}
					}
					if(getInputValue(eid)!=='') marks[i].parentNode.style.background = COLOR_SELECT;	
				}
				
				_attachEvent(marks[i].parentNode.getElementsByTagName('a')[0], 'click', function(){
						var eid = this.parentNode.getElementsByTagName('map')[0].getAttribute('eid');
						var enode = this.parentNode;
						var curColor = rgb2hex(enode.style.backgroundColor);
						if(curColor != COLOR_FLAG){
							enode.style.backgroundColor = COLOR_FLAG;
							var layer_eidobj = $('a_'+eid);
							layer_eidobj.style.backgroundRepeat = 'no-repeat';							
							layer_eidobj.style.backgroundImage  = 'url(source/plugin/exam/image/flag2.gif?0001)';
						}else{
							enode.style.backgroundColor = '';
							$('a_'+eid).style.backgroundImage = '';
						}
				});
			}
			return true;
		}

		function rgb2hex(rgb) {
			rgb = rgb.match(/^rgb\((\d+),\s*(\d+),\s*(\d+)\)$/i);
			if(rgb != null){
				function hex(x) {
					return ("0" + parseInt(x).toString(16)).slice(-2).toUpperCase();
				}
				return "#" + hex(rgb[1]) + hex(rgb[2]) + hex(rgb[3]);
			}
		}
		
		
		function time_counter(){
			if(TIME_LEFT==300){
				//showError('注意，还有5分钟考试结束, 考试结束后将自动交卷!');  		
				showError('&#x6CE8;&#x610F;&#xFF0C;&#x8FD8;&#x6709;5&#x5206;&#x949F;&#x8003;&#x8BD5;&#x7ED3;&#x675F;, &#x8003;&#x8BD5;&#x7ED3;&#x675F;&#x540E;&#x5C06;&#x81EA;&#x52A8;&#x4EA4;&#x5377;!');				
			}
			else if(TIME_LEFT==60){
				//showError('注意，还有1分钟考试结束, 考试结束后将自动交卷!');  	
				showError('&#x6CE8;&#x610F;&#xFF0C;&#x8FD8;&#x6709;1&#x5206;&#x949F;&#x8003;&#x8BD5;&#x7ED3;&#x675F;, &#x8003;&#x8BD5;&#x7ED3;&#x675F;&#x540E;&#x5C06;&#x81EA;&#x52A8;&#x4EA4;&#x5377;!');  				
			}
			else if(TIME_LEFT<=0){ 
				exam_submit_get_result();
				if(TIME_TIMER){
					clearInterval(TIME_TIMER);
					TIME_TIMER = null;	
				}
				if(TIME_LEFT==0){
					//showError('考试时间结束, 系统自动完成交卷!');  		
					showError('&#x8003;&#x8BD5;&#x65F6;&#x95F4;&#x7ED3;&#x675F;, &#x7CFB;&#x7EDF;&#x81EA;&#x52A8;&#x5B8C;&#x6210;&#x4EA4;&#x5377;!');  						
				}
			}
 
			$("p_time").innerHTML = time_second_ms(TIME_LEFT);

			TIME_PASS++;
			TIME_LEFT--;
		} 
		function time_second_ms(sec){
			var m = Math.floor(sec / 60); if (m < 10) {m = "0"+ m;}
			var s = Math.floor(sec % 60); if (s < 10) {s = "0"+ s;}
			return m +':'+ s;
		}
 
 		function test_show_exam(){
				var map = currentElement.getElementsByTagName('map')[0];
				var _result = map.getAttribute('_result');
				var _type = map.getAttribute('type');
				var cite  = currentElement.getElementsByTagName('cite')[0];
				cite.style.visibility = 'visible';
				cite.style.display = 'inline-block';

				var spans = cite.getElementsByTagName('span');
				spans[0].className = (getInputValue(currentElement.id.substr(6))==_result) ? 'right' : 'wrong'; 
				spans[1].innerHTML = _type==5 ? '<p style="font-size:12px"></p>' : (_type==1 ? (_result==1 ? '&#x6B63;&#x786E;' : (_result==2 ? '&#x9519;&#x8BEF;' : '')) : _result);
		}
 
 
		function test_btnNav(mode){
			var newElement = null, eid = null;
			if(mode=='prev') newElement = getPrevElement(currentElement);
			else if(mode=='next') newElement = getNextElement(currentElement);
		
			if(!newElement || !(eid=newElement.id.substr(6))){
				if(mode=='prev') showError('&#x5DF2;&#x5230;&#x8FBE;&#x7B2C;&#x4E00;&#x9898;');
				else if(mode=='next') showError('&#x5DF2;&#x5230;&#x8FBE;&#x6700;&#x540E;&#x4E00;&#x9898;');
				return;
			}
			currentElement.style.display = 'none';
			currentElement = newElement;
			currentElement.style.display = 'block';
			window.location.hash = currentElement.id.substr(6);
		}						

		function getNextElement(node) {
			if (node = node.nextSibling) {
				if(node.nodeType == 1)return node;
				return getNextElement(node);
			}
			return null;
		};
		function getPrevElement(node) {
			if (node = node.previousSibling) {
				if(node.nodeType == 1) return node;
				return getPrevElement(node);
			}
			return null;
		};