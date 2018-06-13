function callforlogin(posturl,tokendata)
{
    
    //console.log("=base_url_data=>"+base_url_data);    
     
     //// custome validation sample
     //jQuery.validator.addMethod("soumik", function(value, element)
     //{
     //
     //     //alert("value==>"+value+"==element==>"+$(element).val());
     //     return false;
     //}, "soumik testing");

     
     $("#loginfrmid").validate({
       
			rules: {
				
				login_email: {
					required: true,
					email: true
				},
                login_password: {
					required: true,
					minlength: 6
				},
				
			},
			messages: {
							
				
				login_email: {
					required: "Please provide an emailid",
					email: "Provide proper emailid"
				},
				
				login_password: {
					required: "Please provide a password",
					minlength: "Your password must be at least 6 characters long"
				},
				
			}
            
            
            
		});
     
     
    
       var chkloginvalidation=  $("#loginfrmid").valid();
       
       if (chkloginvalidation)
       {
                     var email=jQuery("#login_email").val();
                   
                    var password=jQuery("#login_password").val();
                    var keepmesigned=0;
                    
                    var checkkeepmesigned=jQuery("#keepmesigned").prop('checked');
                    
                    if (checkkeepmesigned)
                    {
                        keepmesigned=1;
                    }
                    
                    //**** ajax code starts
    
                        var postdata = {_token:tokendata,email:email,password:password,keepmesigned:keepmesigned}; 
                        var urldata=base_url_data+"/"+posturl;
                        jQuery.ajax({
                            
                            data:postdata,
                            dataType:'json',
                            url:urldata,
                            type:'POST',
                            success:function(d){
                                
                              toastr.remove();// Immediately remove current toasts without using animation
                               
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
                                    //alert("Invalid data provided");
                                    
                                    poptriggerfunc(msgtype='error',titledata='',msgdata=error_message_data,sd=1000,hd=1500,tmo=null,etmo=null,poscls='toast-bottom-right');
                                
                               }
                               else
                               {
                                    //alert("Login successfully done");
                                    window.location.href=base_url_data+"/myroster";
                               }
                    
                               
                                
                               
                            }
                            
                            
                            });
            
                    //**** ajax code ends
                   
                      
       }
     
     
     
    
    
    
}