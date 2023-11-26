   function zmssms(code,mobile,verify,count,codeid,sendid,mobileid,verifyid){

        this.codeid = codeid ? codeid : '';;
        this.sendid = sendid ? sendid : '';;
        this.mobileid = mobileid ? mobileid : '';;
        this.verifyid = verifyid ? verifyid : '';;

        this.code = code ? code : jQuery("#"+this.codeid).val();
        this.mobile = mobile ? mobile :  jQuery("#"+this.mobile).val();
        this.verify = verify ? verify :  jQuery("#"+this.verifyid).val();

        this.count = count ? count : 60;
        this.curCount = this.count ? count : 60;

   }
   zmssms.prototype.sendMessage=function(requesturl,formid){
        var obj = this;
        var SetRemainTime=function(){
            var curCount;
            if (obj.curCount == 0) {
                window.clearInterval(InterValObj);
                jQuery("#"+obj.sendid).removeAttr("disabled");
                jQuery("#"+obj.sendid).html("{lang zhanmishu_sms:resend}");  
                obj.code = "";
            }else {  
                obj.curCount--; 
                curCount = obj.curCount;
                jQuery("#"+obj.sendid).html("{lang zhanmishu_sms:input_tips_sec}");  
            }              
        }
        if(this.mobile != ""){  
            code = 0;
            for (var i = 0; i < codeLength; i++) {  
                code += parseInt(Math.random() * 10).toString();
            }
            jQuery("#"+this.codeid).val(code);
            jQuery("#"+this.sendid).attr("disabled", "true");  

            InterValObj = window.setInterval(SetRemainTime, 1000);
           
            jQuery.ajax({  
                type: "POST", 
                dataType: "json", 
                url: requesturl,   
                data: jQuery("#" + formid).serialize(),
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    jQuery("#"+obj.sendid).removeAttr("disabled");
                    jQuery("#"+obj.sendid).html("{lang zhanmishu_sms:resend}");
                },  
                success: function (msg){
                    
                    if (msg.code <= 0) {
                        showDialog(msg.msg);
                        window.clearInterval(InterValObj);
                        jQuery("#"+obj.sendid).removeAttr("disabled");
                        jQuery("#"+obj.sendid).html("{lang zhanmishu_sms:resend}");
                    }else{
                    }
                }  
            });
        }else{  
        }  
   }
   zmssms.prototype.checkVerify=function(requesturl,formid){

        if (!this.code) {
            return false;
        }
        jQuery.ajax({  
            type: "POST",
            dataType: "json", 
            url: requesturl, 
            data: jQuery("#"+formid).serialize(),
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                //window.clearInterval(InterValObj);
            },  
            success: function (msg){
                if (msg.code <= 0) {
                    showDialog(msg.msg);
                }

                if (msg.code == 1) {

                }

            }  
        }); 
        return false;
   }