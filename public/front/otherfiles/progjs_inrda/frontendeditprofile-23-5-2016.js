
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
   
    function callsaveskilldata(catag_type_id,skill_id,skill_sub_id,callingurlfunc)
    {
                   
                    
            var callingurl=base_url_data+"/"+callingurlfunc;
            var callurlwithdata={_token:csrf_token_data,'catag_type_id':catag_type_id,'skill_id':skill_id,'skill_sub_id':skill_sub_id};
            
            var cmsgdata='Skill saved successfully';
               
                      
                           
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
    
    function  calldeletemyskill(skill_sub_id,callingurlfunc)
    {
                   
                    
            var callingurl=base_url_data+"/"+callingurlfunc;
            var callurlwithdata={_token:csrf_token_data,'skill_sub_id':skill_sub_id};
            
            var cmsgdata='Skill deleted successfully';
               
                      
                           
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
    function populatessubkill(skill_parent_data,catag_type,typeofcall)
    {
          
                   if (skill_parent_data!='' && skill_parent_data!=null)
                   {
                              console.log("inside populatessubkill 1 ...");
                              //**** call ajax to populate date to skill_sub starts
                              
                              var callingurl=base_url_data+"/"+"populatesubskill";
                              var callurlwithdata={_token:csrf_token_data,parent_id:skill_parent_data,catag_type:catag_type};
                              
                              $.ajax({
                                   url:callingurl,
                                   data:callurlwithdata,
                                   type:'POST',
                                   dataType:'JSON',
                                   success:function(d){
                                        
                                        //console.log(JSON.stringify(d));
                                        
                                        var subskillopt="";
                                        
                                        if (d!=null)
                                        {
                                            $.each(d, function(idx, obj)
                                                   {
                                                 
                                                  subskillopt+="<option value='"+obj.id+"'>"+obj.name+"</option>";
                                                  
                                                  });
                                            
                                            
                                        }                                        
                                        
                                        $("#skill_sub").html(subskillopt);
                                        $("#skill_sub").selectpicker('refresh');
                                          
                                        
                                       // console.log(skill_parent_data+"refreshed sub ");
                                        if (typeofcall=='skilldelete')
                                        {
                                             //code
                                        }
                                        else if(typeofcall=='skilladd')
                                        {
                                             
                                        }
                                        
                                        
                                        
                                        
                                   }
                                   
                                   });
                              
                              //**** call ajax to populate date to skill_sub ends
                              
                   }
                   else
                   {
                                        console.log("inside populatessubkill 2 ...");
                                  
                                        $("#skill_sub").html("");
                                        $("#skill_sub").selectpicker('refresh');
                                          //console.log(skill_parent_data+"===refreshed sub ");
                   }
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
				
   
				
				$('[data-toggle="tooltip"]').tooltip();
                
               
               //*** for skill add starts 
              
               
                $('#skill_parent').on('change',function(evnt){
                    
                   // alert($(this).val());
                    
                    var  skill_parent_data=$(this).val();
                    
                    var typeofcall="skilladd"; var catag_type=1;              
                   
                    
                   if (skill_parent_data!='' && skill_parent_data!=null)
                   {
                              //**** call ajax to populate date to skill_sub starts
                              
                              var callingurl=base_url_data+"/"+"populatesubskill";
                              var callurlwithdata={_token:csrf_token_data,parent_id:skill_parent_data,catag_type:1};
                              
                              $.ajax({
                                   url:callingurl,
                                   data:callurlwithdata,
                                   type:'POST',
                                   dataType:'JSON',
                                   success:function(d){
                                        
                                        //console.log(JSON.stringify(d));
                                        
                                        var subskillopt="";
                                        
                                        if (d!=null)
                                        {
                                            $.each(d, function(idx, obj)
                                                   {
                                                 
                                                  subskillopt+="<option value='"+obj.id+"'>"+obj.name+"</option>";
                                                  
                                                  });
                                            
                                            
                                        }                                        
                                        
                                        $("#skill_sub").html(subskillopt);
                                        $("#skill_sub").selectpicker('refresh');                                        
                                        
                                   }
                                   
                                   });
                              
                              //**** call ajax to populate date to skill_sub ends
                              
                   }
                   else
                   {
                                        $("#skill_sub").html("");
                                        $("#skill_sub").selectpicker('refresh');
                   }
                    
                    
                    });
               
               //*** for skill add ends
               
               
               
               //*** for skill sub add starts 
              
               var parentskilladdedar=[];
                $('#skill_sub').on('change',function(evnt){
                    
                   // alert($(this).val());
                    
                    var skill_parent_data=parseInt($("#skill_parent").find(":selected").val());
                    var skill_parent_txtdata=$("#skill_parent").find(":selected").text();
                    var  skill_sub_data=parseInt($(this).val());
                    var  skill_sub_txtdata=$(this).find(":selected").text();
                    
                    //console.log("=skill_parent_data=>"+skill_parent_data+"=skill_parent_txtdata=>"+skill_parent_txtdata+"==skill_sub_data=>"+skill_sub_data+"==skill_sub_txtdata=>"+skill_sub_txtdata);
                    
                    var totcnt=$("#skillidouterdiv").find('.skillparentclss').length;
                   
                   
                    if (totcnt>0)
                    {
                         
                        $("#skillidouterdiv").find('.skillparentclss').each(function(){
                         
                          var skillparclss_data=parseInt($(this).data("skillparent"));
                                                   
                          var check_skillparclss_data= $.inArray( skillparclss_data, parentskilladdedar );
                           
                         // console.log("=check parent id "+skillparclss_data+" present or not =>"+check_skillparclss_data);
                           
                              if (check_skillparclss_data==-1)
                              {
                                  parentskilladdedar.push(skillparclss_data);
                                  // console.log("=now after adding new parent total parent skill length=>"+parentskilladdedar.length+"---contnt ar=>"+parentskilladdedar.toString());
                              }
                               
                         
                         }); 
                         
                   
                    
                    
                              var check_parispresent= $.inArray( skill_parent_data, parentskilladdedar );
                              
                              //console.log("=parentskilladdedar array data=>"+parentskilladdedar.toString()+"==parent id "+skill_parent_data+" present check =>"+check_parispresent);
                        
                              if (check_parispresent!=-1)
                              {
                                   //***** create small  structure  starts
                                   
                                   console.log(" 22 parent skill div exists add new sub skill");
                                   
                                   var prntsklobj=$("#skillidouterdiv").find(".skillparentclss[data-skillparent='" + skill_parent_data + "']"); // get the parent skill div obj
                                 
                                   
                                             //** check whether sub skill present in the structure or not starts
                                             
                                            var suskillobjchk=prntsklobj.find(".mysubcustcls[data-skillsub='" + skill_sub_data + "']");
                                          
                                             //alert("22 check =suskillobjchk=>"+suskillobjchk);
                                             //** check whether sub skill present in the structure or not ends 
                                             
                                                  if (suskillobjchk.data("skillsub")==null)
                                                  {
                                                       var prevklmstrdivstruc=prntsklobj.html();
                                                       var newsklmstrdivstruc="<div class='gener mysubcustcls' data-skillparent='"+skill_parent_data+"' data-skillsub='"+skill_sub_data+"'  >"+skill_sub_txtdata+",<span class='delsubskillclass' data-skillparent='"+skill_parent_data+"' data-skillsub='"+skill_sub_data+"' >&times;</span></div>";
                                                     
                                                       //alert("=prevklmstrdivstruc=>"+prevklmstrdivstruc);
                                                      // alert("newsklmstrdivstruc=>"+newsklmstrdivstruc);
                                                       
                                                       //if (typeof(prevklmstrdivstruc)=="undefined")
                                                       //{
                                                       //    alert("undefined== so add new sub struct into it ");
                                                       //}
                                                       //else
                                                       //{
                                                       //      alert("not undefined== concatenate ");
                                                       //}
                                                       
                                                       
                                                       prntsklobj.html(prevklmstrdivstruc+newsklmstrdivstruc);
                                                       callsaveskilldata(1,skill_parent_data,skill_sub_data,"saveskilldata");
                                                  }
                                                  else
                                                  {
                                                       //alert("already sub struct present");
                                                       toastr.remove();// Immediately remove current toasts without using animation
                                                       poptriggerfunc(msgtype='error',titledata='',msgdata="This skill already exist",sd=1000,hd=1500,tmo=10000,etmo=2000,poscls='toast-bottom-right');
                         
                                                  }
                                   
                                  
                                  //***** create small  structure  ends
                                  
                                   //**** bind delete to skill starts
                              
                                   $(".delsubskillclass").click(function(){
                                                   var sk_parent_data=$(this).data("skillparent");
                                                   var sk_sub_data=$(this).data("skillsub");
                                                  calldeletemyskill(sk_sub_data,"deletemyskill");
                                                  
                                                  
                                                  var currentskillcount=$(this).parent(".mysubcustcls").parent(".skillparentclss").find('.mysubcustcls').length;
                                                  
                                                  //**** count skill , if 0 then delete parent shill structure starts                                  
                                   
                                                  //console.log("currentskillcount=>"+currentskillcount);
                                                  if ((currentskillcount-1)==0)
                                                  {
                                                       $(this).parent(".mysubcustcls").parent(".skillparentclss").remove();
                                                       
                                                       //*****remove that element from the parentskilladdedar array so that they can be added later on starts 
                                                       if (parentskilladdedar.length>0)
                                                       {
                                                          
                                                            var check_skillpar_preent= $.inArray( sk_parent_data, parentskilladdedar );
                                                            if (check_skillpar_preent!=-1)
                                                            {
                                                                 parentskilladdedar.splice(check_skillpar_preent,1);
                                                            }
                                                       }
                                                       //*****remove that element from the parentskilladdedar array so that they can be added later on ends 
                                                      
                                                  }
                                                  else
                                                  {
                                                       $(this).parent(".mysubcustcls").remove();
                                                  }
                                                  
                                                   //**** count skill , if 0 then delete parent shill structure ends
                                  
                                                 //var skill_pr_data=parseInt($("#skill_parent").find(":selected").val());
                                                 // var chk_sp=isNaN(skill_pr_data);
                                                 // if (chk_sp==false && (sk_parent_data==skill_pr_data) )
                                                 // {
                                                 //      //alert("1...refresh");
                                                 //      populatessubkill(sk_parent_data,1,'skilladd'); // refresh sub skill drop down 
                                                 // }
                                                  
                                   
                                   });
                                   
                                   //**** bind delete to skill ends
                              }
                              else
                              {
                                    console.log(" 333 create new whole structure parent skill div struct ");
                                   //***** create new whole structure  starts
                                   
                                              // alert("parent skill not present add new whole");
                                        var prevklmstrdivstruc=$("#skillidouterdiv").html();
                                        var newsklmstrdivstruc="<div class='name_holder skillparentclss'  data-skillparent='"+skill_parent_data+"' ><div class='mainCategory skillparentname'>"+skill_parent_txtdata+":</div><div class='gener mysubcustcls' data-skillparent='"+skill_parent_data+"' data-skillsub='"+skill_sub_data+"' >"+skill_sub_txtdata+",<span class='delsubskillclass' data-skillparent='"+skill_parent_data+"' data-skillsub='"+skill_sub_data+"'>&times;</span></div></div>";
                                        $("#skillidouterdiv").html(prevklmstrdivstruc+newsklmstrdivstruc);
                                  
                                         callsaveskilldata(1,skill_parent_data,skill_sub_data,"saveskilldata");
                                  
                                   //***** create new whole structure  ends
                                    //**** bind delete to skill starts
                              
                                   $(".delsubskillclass").click(function(){
                                        
                                              var sk_parent_data=$(this).data("skillparent");
                                              var sk_sub_data=$(this).data("skillsub");
                                              calldeletemyskill(sk_sub_data,"deletemyskill");
                                  
                                              var currentskillcount=$(this).parent(".mysubcustcls").parent(".skillparentclss").find('.mysubcustcls').length;
                                  
                                              //**** count skill , if 0 then delete parent shill structure starts                                  
                                   
                                                  //console.log("currentskillcount=>"+currentskillcount);
                                                  if ((currentskillcount-1)==0)
                                                  {
                                                       $(this).parent(".mysubcustcls").parent(".skillparentclss").remove();
                                                       
                                                       //*****remove that element from the parentskilladdedar array so that they can be added later on starts 
                                                        if (parentskilladdedar.length>0)
                                                       {
                                                          
                                                            var check_skillpar_preent= $.inArray( sk_parent_data, parentskilladdedar );
                                                            if (check_skillpar_preent!=-1)
                                                            {
                                                                 parentskilladdedar.splice(check_skillpar_preent,1);
                                                            }
                                                       }
                                                       //*****remove that element from the parentskilladdedar array so that they can be added later on ends 
                                                  }
                                                  else
                                                  {
                                                       $(this).parent(".mysubcustcls").remove();
                                                  }
                                                  
                                                   //**** count skill , if 0 then delete parent shill structure ends
                                  
                                                  //var skill_pr_data=parseInt($("#skill_parent").find(":selected").val());
                                                  //var chk_sp=isNaN(skill_pr_data);
                                                  //
                                                  //if (chk_sp==false && (sk_parent_data==skill_pr_data) )
                                                  //{
                                                  //    // alert("2...refresh");
                                                  //     populatessubkill(sk_parent_data,1,'skilladd'); // refresh sub skill drop down 
                                                  //}
                                  
                                  
                                   
                                   });
                                   
                                   //**** bind delete to skill ends
                              
                               }
                    
                    
                    
                    
                    }
                    else
                    {
                         parentskilladdedar.push(skill_parent_data);
                         //console.log("=parentskilladdedar array contnt => "+parentskilladdedar.toString()+"--length of array=>"+parentskilladdedar.length)
                               //***** create structure  starts
                              
                             //alert("add new whole skill struct");
                             //console.log("11 not a singl struct present create 1st new struct");
                             var newsklmstrdivstruc="<div class='name_holder skillparentclss'  data-skillparent='"+skill_parent_data+"' ><div class='mainCategory skillparentname'   >"+skill_parent_txtdata+":</div><div class='gener mysubcustcls' data-skillparent='"+skill_parent_data+"' data-skillsub='"+skill_sub_data+"' >"+skill_sub_txtdata+",<span class='delsubskillclass' data-skillparent='"+skill_parent_data+"' data-skillsub='"+skill_sub_data+"'>&times;</span></div></div>";
                             $("#skillidouterdiv").html(newsklmstrdivstruc);
                                                         
                             callsaveskilldata(1,skill_parent_data,skill_sub_data,"saveskilldata");
                             
                              //***** create structure  ends
                              
                              //**** bind delete to skill starts
                              
                              $(".delsubskillclass").click(function(){
                                   
                                   var sk_parent_data=$(this).data("skillparent");
                                   var sk_sub_data=$(this).data("skillsub");
                                  calldeletemyskill(sk_sub_data,"deletemyskill");
                                  
                                  var currentskillcount=$(this).parent(".mysubcustcls").parent(".skillparentclss").find('.mysubcustcls').length;
                                  
                                  //**** count skill , if 0 then delete parent shill structure starts                                  
                                   
                                   //console.log("currentskillcount=>"+currentskillcount);
                                   if ((currentskillcount-1)==0)
                                                  {
                                                       $(this).parent(".mysubcustcls").parent(".skillparentclss").remove();
                                                       
                                                       //*****remove that element from the parentskilladdedar array so that they can be added later on starts 
                                                        if (parentskilladdedar.length>0)
                                                       {
                                                          
                                                            var check_skillpar_preent= $.inArray( sk_parent_data, parentskilladdedar );
                                                            if (check_skillpar_preent!=-1)
                                                            {
                                                                 parentskilladdedar.splice(check_skillpar_preent,1);
                                                            }
                                                       }
                                                       
                                                       //*****remove that element from the parentskilladdedar array so that they can be added later on ends 
                                                  }
                                                  else
                                                  {
                                                       $(this).parent(".mysubcustcls").remove();
                                                  }
                                  //**** count skill , if 0 then delete parent shill structure ends
                                  
                                  
                                   
                                  // var skill_pr_data=parseInt($("#skill_parent").find(":selected").val());
                                  // var chk_sp=isNaN(skill_pr_data);
                                  //// alert(chk_sp);
                                  // if (chk_sp==false && (sk_parent_data==skill_pr_data) )
                                  // {
                                  //      //alert("3  refresh...");
                                  //      populatessubkill(sk_parent_data,1,'skilladd'); // refresh sub skill drop down 
                                  // }
                                   
                              
                              });
                              
                              //**** bind delete to skill ends
                              
                    }
                   
                    
                    
                     // populatessubkill(skill_parent_data,1,'skilladd'); // refresh sub skill drop down 
                             
                    
                    });
               
               //*** for skill sub add ends
               
               
               //***** add data starts
               
                     var totcnt=$("#skillidouterdiv").find('.skillparentclss').length;
                   
                   
                    if (totcnt>0)
                    {
                         
                        $("#skillidouterdiv").find('.skillparentclss').each(function(){
                         
                          var skillparclss_data=parseInt($(this).data("skillparent"));
                                                   
                          var check_skillparclss_data= $.inArray( skillparclss_data, parentskilladdedar );
                           
                         // console.log("=check parent id "+skillparclss_data+" present or not =>"+check_skillparclss_data);
                           
                              if (check_skillparclss_data==-1)
                              {
                                  parentskilladdedar.push(skillparclss_data);
                                  // console.log("=now after adding new parent total parent skill length=>"+parentskilladdedar.length+"---contnt ar=>"+parentskilladdedar.toString());
                              }
                               
                         
                         });
                    }
               
               
               //***** add data ends
               
                //**** bind delete to skill starts
                              
                              $(".delsubskillclass").click(function(){
                              
                                    var sk_parent_data=$(this).data("skillparent");
                                   var sk_sub_data=$(this).data("skillsub");
                                  calldeletemyskill(sk_sub_data,"deletemyskill");
                                  
                                  var currentskillcount=$(this).parent(".mysubcustcls").parent(".skillparentclss").find('.mysubcustcls').length;
                                  
                                  //**** count skill , if 0 then delete parent shill structure starts
                                  
                                   
                                   //console.log("currentskillcount=>"+currentskillcount);
                                   if ((currentskillcount-1)==0)
                                                  {
                                                       $(this).parent(".mysubcustcls").parent(".skillparentclss").remove();
                                                       
                                                       //*****remove that element from the parentskilladdedar array so that they can be added later on starts 
                                                       
                                                       if (parentskilladdedar.length>0)
                                                       {
                                                          
                                                            var check_skillpar_preent= $.inArray( sk_parent_data, parentskilladdedar );
                                                            if (check_skillpar_preent!=-1)
                                                            {
                                                                 parentskilladdedar.splice(check_skillpar_preent,1);
                                                            }
                                                       }
                                                       //*****remove that element from the parentskilladdedar array so that they can be added later on ends 
                                                  }
                                                  else
                                                  {
                                                       $(this).parent(".mysubcustcls").remove();
                                                  }
                                  //**** count skill , if 0 then delete parent shill structure ends                                   
                                   
                                   
                                   //var skill_pr_data=parseInt($("#skill_parent").find(":selected").val());
                                   //var chk_sp=isNaN(skill_pr_data);
                                   ////alert(chk_sp);
                                   //if (chk_sp==false && (sk_parent_data==skill_pr_data) )
                                   //{
                                   //    // alert("refresh...");
                                   //     populatessubkill(sk_parent_data,1,'skilladd'); // refresh sub skill drop down 
                                   //}
                                  
                                   
                                   
                                  
                              
                              });
                              
                    //**** bind delete to skill ends
                     //**** bind custplus starts
                     
                     $(".custplus").click(function(){
                         
                         //var slp= $("#skill_parent").selectpicker();
                          //slp.selectpicker('refresh');
                          $('#skill_parent').selectpicker('deselectAll');
                          
                          $("#skill_sub").html('');
                          $("#skill_sub").selectpicker('refresh');
                         
                         });
                     //**** bind custplus ends
               
               
               
               
				
            });