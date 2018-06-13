function samesize() {
                $('.container').each(function(){  
                  var highestBox = 0;
                  $('.sam_height', this).each(function(){
                    if($(this).outerHeight() > highestBox) {
                      highestBox = $(this).outerHeight();
                    }                  
                  });  
                  $('.sam_height',this).outerHeight(highestBox);
                                
                });
            }
            
    function callsaveuserurls(controlname,controlnamedata,callingurlfunc)
    {
                   
                    
            var callingurl=base_url_data+"/"+callingurlfunc;
            var callurlwithdata={_token:csrf_token_data,controlname:controlname,controlnamedata:controlnamedata};
            
            var cmsgdata='';
               if (controlname=="facebook_url")
               {
                    cmsgdata="Facebook url saved sucessfully";
               
               }
               else if (controlname=="soundcloud_url")
               {
                    cmsgdata="Soundcloud url saved sucessfully";
               
               }
               else if (controlname=="residentadvisor_url")
               {
               
                     cmsgdata="Residentadvisor url saved sucessfully";
               }
               else if (controlname=="twitter_url")
               {
               
                    cmsgdata="Twitter_url  saved sucessfully";
               }
               else if (controlname=="youtube_url")
               {
                    cmsgdata="Youtube  saved sucessfully";
               
               }
               else if (controlname=="instagram_url")
               {
               
                    cmsgdata="Instagram  saved sucessfully";
               }
            
                           
             $.ajax({
               
               url:callingurl,
               type:'POST',
               dataType:'json',
               data:callurlwithdata,
               success:function(d){
                    
                         toastr.remove();// Immediately remove current toasts without using animation
                         
                         //***************** Check response starts
                         if (d.flag_id==0 && d.error_message!='')
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
                                      poptriggerfunc(msgtype='error',titledata='',msgdata=error_message_data,sd=1000,hd=1500,tmo=null,etmo=null,poscls='toast-bottom-right');         
                                
                               }
                               else
                               {
                                      poptriggerfunc(msgtype='success',titledata='',msgdata=cmsgdata,sd=1000,hd=1500,tmo=1000,etmo=1000,poscls='toast-bottom-right');
                               }
                               
                         //***************** Check response ends      
                
               }
               
               });
          
       
          
    }
    
    function callsaveuserdesc(controlname,controlnamedata,callingurlfunc)
    {
                   
                    
            var callingurl=base_url_data+"/"+callingurlfunc;
            var callurlwithdata={_token:csrf_token_data,'user_description':controlnamedata};
            
            var cmsgdata='';
            if (controlname=="user_description")
               {
                    cmsgdata="Description saved sucessfully";
               
               }
              
            
                           
             $.ajax({
               
               url:callingurl,
               type:'POST',
               dataType:'json',
               data:callurlwithdata,
               success:function(d){
                    
                         toastr.remove();// Immediately remove current toasts without using animation
                         
                         //***************** Check response starts
                         if (d.flag_id==0 && d.error_message!='')
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
                                      poptriggerfunc(msgtype='error',titledata='',msgdata=error_message_data,sd=1000,hd=1500,tmo=null,etmo=null,poscls='toast-bottom-right');         
                                
                               }
                               else
                               {
                                      poptriggerfunc(msgtype='success',titledata='',msgdata=cmsgdata,sd=1000,hd=1500,tmo=1000,etmo=1000,poscls='toast-bottom-right');
                               }
                               
                         //***************** Check response ends      
                
               }
               
               });
          
       
          
    }
    
			
		 function callsaveusername(controlname,controlnamedata,callingurlfunc)
    {
                   
                    
            var callingurl=base_url_data+"/"+callingurlfunc;
            var callurlwithdata={_token:csrf_token_data,'first_name':controlnamedata};
            
            var cmsgdata='';
               if (controlname=="first_name")
               {
                    cmsgdata="Name saved sucessfully";
               
               }
              
            
                           
             $.ajax({
               
               url:callingurl,
               type:'POST',
               dataType:'json',
               data:callurlwithdata,
               success:function(d){
                    
                         toastr.remove();// Immediately remove current toasts without using animation
                         
                         //***************** Check response starts
                         if (d.flag_id==0 && d.error_message!='')
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
                                      poptriggerfunc(msgtype='error',titledata='',msgdata=error_message_data,sd=1000,hd=1500,tmo=null,etmo=null,poscls='toast-bottom-right');         
                                
                               }
                               else
                               {
                                      poptriggerfunc(msgtype='success',titledata='',msgdata=cmsgdata,sd=1000,hd=1500,tmo=1000,etmo=1000,poscls='toast-bottom-right');
                               }
                               
                         //***************** Check response ends      
                
               }
               
               });
          
       
          
    }
    
    
    
			
			 $(document).ready(function(){
			 
			  $( window ).resize(function() {
						 samesize()
							 });
							 
				$( window ).load(function() {
					  samesize()
			   });
			   			 
			 
            	$('.descchngancclass').click(function(){
            		var initVal = $(this).parent('.esEditor').find('.outPut').text();
            		$(this).parent('.esEditor').find('.editInput').val(initVal).show().focus();
            		$(this).parent('.esEditor').addClass('editable');
                    
                    console.log("opened description");
                    
            	});
                
               $('.namechnganchcls').click(function(){
            		var initVal = $(this).parent('.esEditor').find('.outPut').text();
                    var orignamedata=$('.editInputfirstname').val();
            		$(this).parent('.esEditor').find('.editInput').val(initVal).show().focus();
            		$(this).parent('.esEditor').addClass('editable');
                    
                   // console.log("name change");
                   

                   $('.editInputfirstname').keyup(function( event ) {
                    
                    
                         if ( (event.which) == 13  )
                         {
                               //console.log(nmchngflg);
                               
                               
                               var controlname=$(this).attr('name');
                               var controlnamedata=$(this).val();
                               var callingurlfunc="saveusername";
                               
                               $(this).trigger('blur');
                               
                               //callsaveusername(controlname,controlnamedata,callingurlfunc)
                         }
                   }
                         );
                   
               //****** bind first_name with blur starts
               
              
                    $(".editInputfirstname").one('blur', function () {
                    var currentVal = $(this).val();
                    $(this).parents('.esEditor').find('.outPut').text(currentVal);
                    $(this).parents('.esEditor').removeClass('editable');
                    $(this).parents('.esEditor').find('.editInput').hide();
                    
                     //**** find the first_name control id on blur starts
                                var control_id_data=$(this).attr('id');					
                                //console.log("==control_id_data==>"+control_id_data);					
                                if (typeof control_id_data != 'undefined')
                                {
                                    
                                    if (control_id_data=="first_name")
                                    {
                                        var controlnamedata=$(this).val();
                                        //console.log("=facebook_url_data=>"+facebook_url_data);
                                           
                                           var controlname=$("#"+control_id_data).attr('name');               							
                                           callsaveusername(controlname,controlnamedata,'saveusername');
                                       }
                                   }
              //**** find the first_name control id on blur ends  
                                        
                                        
                    
                    				});
                  
               //****** bind first_name with blur ends             
                    
            	});
                
                
            	$(".desccommncustcls").on('blur', function () {
            		var currentVal = $(this).val();
				    $(this).parents('.esEditor').find('.outPut').text(currentVal);
				    $(this).parents('.esEditor').removeClass('editable');
				    $(this).parents('.esEditor').find('.editInput').hide();
                    
                    
                    //console.log(currentVal+"===="+$(this).attr('id'));
                    
                    
                    //**** find the control id on blur starts
               					var control_id_data=$(this).attr('id');					
               					//console.log("==control_id_data==>"+control_id_data);					
               					if (typeof control_id_data != 'undefined')
               					{
               						
               						if (control_id_data=="user_description")
               						{
               							var controlnamedata=$(this).val();
               							//console.log("=facebook_url_data=>"+facebook_url_data);
                                           
                                           var controlname=$("#"+control_id_data).attr('name');               							
                                           callsaveuserdesc(controlname,controlnamedata,'saveuserdesc');
                                       }
                                   }
                    //**** find the control id on blur ends               
                    
                    
				});
				
				
				$('.add_icon').click(function(){
            		var initVal = $(this).parent('.link_edit').find('.outPut').text();
                 
                    var currcntrlobjval = $(this).parent('.link_edit').find('.editInput').val(); // newly added
                    
                    var datatoshow=initVal; // newly added
                    
                    if (currcntrlobjval!='')
                    {
                         datatoshow=currcntrlobjval; // newly added
                    }
                    
                    
            		$(this).parent('.link_edit').find('.editInput').val(datatoshow).show().focus();
            		$(this).parent('.link_edit').addClass('editable');
                    
                    //**** here enter key code starts
                    var control_id_data=$(this).parent('.link_edit').find('input').attr('id');	
                    $( "#"+control_id_data ).keyup(function( event ) {
                         if ( event.which == 13 )
                         {
                             
                              //**** find the control id on blur starts
                              				
                              //console.log("==control_id_data==>"+control_id_data);					
                              if (typeof control_id_data != 'undefined')
                              {
                                  
                                  if (control_id_data=="facebook_url")
                                  {
                                      var controlnamedata=$("#"+control_id_data).val();
                                      //console.log("=facebook_url_data=>"+facebook_url_data);
                                      
                                      var controlname=$("#"+control_id_data).attr('name');
                                      
                                      //callsaveuserurls(controlname,controlnamedata,'saveuserurls');
                                      
                                       $( "#"+control_id_data ).trigger('blur');
                                      
                                       
                                  }
                                  else if (control_id_data=="soundcloud_url")
                                  {
                                      var controlnamedata=$("#"+control_id_data).val();
                                      
                                      
                                      var controlname=$("#"+control_id_data).attr('name');
                                      
                                     // callsaveuserurls(controlname,controlnamedata,'saveuserurls');
                                      $( "#"+control_id_data ).trigger('blur');
                                       
                                  }
                                  else if (control_id_data=="residentadvisor_url")
                                  {
                                      var controlnamedata=$("#"+control_id_data).val();
                                      
                                      
                                      var controlname=$("#"+control_id_data).attr('name');
                                      
                                     // callsaveuserurls(controlname,controlnamedata,'saveuserurls');
                                      $( "#"+control_id_data ).trigger('blur');
                                       
                                  }
                                   else if (control_id_data=="twitter_url")
                                  {
                                      var controlnamedata=$("#"+control_id_data).val();
                                      
                                      
                                      var controlname=$("#"+control_id_data).attr('name');
                                      
                                    //  callsaveuserurls(controlname,controlnamedata,'saveuserurls');
                                     $( "#"+control_id_data ).trigger('blur');
                                       
                                  }
                                  else if (control_id_data=="youtube_url")
                                  {
                                      var controlnamedata=$("#"+control_id_data).val();
                                      
                                      
                                      var controlname=$("#"+control_id_data).attr('name');
                                      
                                     // callsaveuserurls(controlname,controlnamedata,'saveuserurls');
                                      $( "#"+control_id_data ).trigger('blur');
                                       
                                  }
                                  else if (control_id_data=="instagram_url")
                                  {
                                      var controlnamedata=$("#"+control_id_data).val();
                                      
                                      
                                      var controlname=$("#"+control_id_data).attr('name');
                                      
                                     //  callsaveuserurls(controlname,controlnamedata,'saveuserurls');
                                     
                                      $( "#"+control_id_data ).trigger('blur');
                                       
                                  }
                                  
                              
                                  
                              }					
                              //**** find the control id on blur ends
                              
                              
                               $(this).parent('.link_edit').removeClass('editable');
                               $(this).parent('.link_edit').find('.editInput').hide();
                              
                              
                         }
                    });
                    
               //**** here enter key code ends
                    
               //*****  url blur code starts     
                    
            	$(".urlcommncustcls").one('blur', function () {
            		var currentVal = $(this).val(); console.log("==currentVal==>"+currentVal);
				    $(this).parents('.link_edit').find('.outPut').text(currentVal);
				    $(this).parents('.link_edit').removeClass('editable');
				    $(this).parents('.link_edit').find('.editInput').hide();
					
					//**** find the control id on blur starts
					var control_id_data=$(this).parent('.link_edit').find('input').attr('id');					
					//console.log("==control_id_data==>"+control_id_data);					
					if (typeof control_id_data != 'undefined')
					{
                         
						
						if (control_id_data=="facebook_url")
						{
							var controlnamedata=$("#"+control_id_data).val();
							//console.log("=facebook_url_data=>"+facebook_url_data);
                            
                            var controlname=$("#"+control_id_data).attr('name');
							
                            callsaveuserurls(controlname,controlnamedata,'saveuserurls');                            
							 
						}
                        else if (control_id_data=="soundcloud_url")
						{
							var controlnamedata=$("#"+control_id_data).val();
							
                            
                            var controlname=$("#"+control_id_data).attr('name');
							
                            callsaveuserurls(controlname,controlnamedata,'saveuserurls');                            
							 
						}
                        else if (control_id_data=="residentadvisor_url")
						{
							var controlnamedata=$("#"+control_id_data).val();
							
                            
                            var controlname=$("#"+control_id_data).attr('name');
							
                            callsaveuserurls(controlname,controlnamedata,'saveuserurls');                            
							 
						}
                         else if (control_id_data=="twitter_url")
						{
							var controlnamedata=$("#"+control_id_data).val();
							
                            
                            var controlname=$("#"+control_id_data).attr('name');
							
                            callsaveuserurls(controlname,controlnamedata,'saveuserurls');                            
							 
						}
                        else if (control_id_data=="youtube_url")
						{
							var controlnamedata=$("#"+control_id_data).val();
							
                            
                            var controlname=$("#"+control_id_data).attr('name');
							
                            callsaveuserurls(controlname,controlnamedata,'saveuserurls');                            
							 
						}
                        else if (control_id_data=="instagram_url")
						{
							var controlnamedata=$("#"+control_id_data).val();
							
                            
                            var controlname=$("#"+control_id_data).attr('name');
							
                            callsaveuserurls(controlname,controlnamedata,'saveuserurls');                            
							 
						}
                        
                        
                        
                        
					}					
					//**** find the control id on blur ends

				});
                    
                //*****  url blur code starts    
                    
                    
                    
                    
            	});
				
				
				
				$('.btn_row').click(function(){
            		var initVal = $(this).find('.outPut').text();
            		$(this).find('.editInput').val(initVal).show().focus();
            		$(this).addClass('editable');
            	});
				
     //            	$(".editInput").on('blur', function () {
     //            		var currentVal = $(this).val();
     //				    $(this).parents('.btn_row').find('.outPut').text(currentVal);
     //				    $(this).parents('.btn_row').removeClass('editable');
     //				    $(this).parents('.btn_row').find('.editInput').hide();
     //                    
     //
     //				});
     

				
				
				$('[data-toggle="tooltip"]').tooltip();
               
				
            });