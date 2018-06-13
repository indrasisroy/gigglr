function loadeditprofilefunc(callingurlfunc)
    {
             
            var callingurl=base_url_data+"/"+callingurlfunc;
            var callurlwithdata={_token:csrf_token_data};
            
            var cmsgdata="...";         
              
                    
             $.ajax({
               
               url:callingurl,
               type:'POST',
               dataType:'json',
               data:callurlwithdata,
               success:function(d){
                
                    
                         toastr.remove();// Immediately remove current toasts without using animation
                         
                         //***************** Check response starts
                         if (d.flag_status==0 && d.error_message!='')
                               {
                               
                                        var error_message=d.error_message;
                                       
                                        var error_message_data='';
                                        
                                        if (error_message!=null)
                                        {
                                                    for (ermsgkey in error_message)
                                                 {
                                                      error_message_data+="<p>"+ error_message[ermsgkey]+"</p>";
                                                 }
                                        }
                                      poptriggerfunc(msgtype='error',titledata='',msgdata=error_message_data,sd=1000,hd=1500,tmo=null,etmo=null,poscls='toast-top-full-width');         
                                
                               }
                               else
                               {
                                   var ep_contents=d.ep_contents;
                                      //poptriggerfunc(msgtype='success',titledata='',msgdata=cmsgdata,sd=1000,hd=1500,tmo=1000,etmo=1000,poscls='toast-top-full-width');
                               
                                    $("#epajxprofdvid").html(ep_contents);
                                    footerarea_css();
                                    
                                    
                                        
                             
                               }
                               
                         //***************** Check response ends      
                
               }
               
               });
          
       
          
    }
             
    		
			 $(document).ready(function(){
			 
                footerarea_css();
                
                var imfpth=base_url_data+"/public/front/otherfiles/progimages/loder.gif"
                showmycustomloader(1,'','',"Please wait . Its loading ...",imfpth);
                
                setTimeout(function(){
                                
                                 showmycustomloader(0,'1000','1000',"Please wait . Its loading ...",imfpth)
                                
                                loadeditprofilefunc("editprofileajax");
                                
                                
                                },3000);
               
               
                         
				
            });
             
             