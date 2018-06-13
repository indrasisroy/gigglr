function callforregister(posturl,tokendata)
{
    
    //console.log("=base_url_data=>"+base_url_data);    
     
     //// custome validation sample
     //jQuery.validator.addMethod("soumik", function(value, element)
     //{
     //
     //     //alert("value==>"+value+"==element==>"+$(element).val());
     //     return false;
     //}, "soumik testing");

     
     $("#signupfrmid").validate({
       
			rules: {
				
				nickname: {
					required: true,
					minlength: 2,
                    
				},
				password: {
					required: true,
					minlength: 6
				},
				password_confirmation: {
					required: true,
					minlength: 6,
					equalTo: "#password"
				},
				email: {
					required: true,
					email: true
				},
				termscond: {
					required: true,
                    
					
				},
				
			},
			messages: {
							
				nickname: {
					required: "Please enter a nick name",
					minlength: "Name must consist of at least 2 characters"
				},
				password: {
					required: "Please provide a password",
					minlength: "Your password must be at least 6 characters long"
				},
				password_confirmation: {
					required: "Please provide a password",
					minlength: "Your password must be at least 6 characters long",
					equalTo: "Please enter the same password as above"
				},
				email: "Please enter a valid email address",
				termscond: "Please accept our terms and conditions",
				
			}
            
            
            
		});
     
     
    
       var chksignupvalidation=  $("#signupfrmid").valid();
       
       toastr.remove();// Immediately remove current toasts without using animation
       
       if (chksignupvalidation)
       {
                     var dob=jQuery("#dob").val();
                    var nickname=jQuery("#nickname").val();
                    var email=jQuery("#email").val();
                    var password=jQuery("#password").val();
                    var password_confirmation=jQuery("#password_confirmation").val();
                    var gender=jQuery("#gender").val();
                    
                    
                    
                     var checkterms=jQuery("#termscond").prop('checked');
                    
                    if (checkterms)
                    {
        
                         $("#signuploader").removeClass("mydisplaynone");
                         
//                         jQuery('html, body').animate({
//									scrollTop: jQuery("#signuploader").offset().top + 5 }, 'slow');
                         
                         
                     //**** ajax code starts
    
                        var postdata = {_token:tokendata,dob:dob,nickname:nickname,email:email,password:password,password_confirmation:password_confirmation,gender:gender}; 
                        var urldata=base_url_data+"/"+posturl;
                        jQuery.ajax({
                            
                            data:postdata,
                            dataType:'JSON',
                            url:urldata,
                            type:'POST',
                            success:function(d){
                                
                               
                               
                               if (d.flag_id==0)
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
                                      $("#signuploader").addClass("mydisplaynone");              
                                      poptriggerfunc(msgtype='error',titledata='',msgdata=error_message_data,sd=1000,hd=1500,tmo=null,etmo=null,poscls='toast-bottom-right');         
                                
                              
                               }
                               else
                               {
                                   poptriggerfunc(msgtype='success',titledata='',msgdata="Registration done successfully",sd=3000,hd=2000,tmo=1000,etmo=1000,poscls='toast-bottom-right');
                                   $("#signupfrmid").trigger("reset");
                                   $("#signuploader").addClass("mydisplaynone");
                                   //$('#myModal').modal('hide');
                                   
                                   

                                   
                              }
                    
                               
                                
                               
                            }
                            
                            
                            });
            
                    //**** ajax code ends
                    }
                    else
                    {
                      var error_message_data=" You haven't agreed to terms and conditions! ";
                        poptriggerfunc(msgtype='error',titledata='',msgdata=error_message_data,sd=1000,hd=1500,tmo=null,etmo=null,poscls='toast-bottom-right');
                    }
       }
      
     
     
     
    
    
    
}