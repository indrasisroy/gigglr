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
          
          /********* added date 22th november 2016 start ***********/ 
          /*****add parent class*****/
          highlight: function(element) {
              $(element).parent().addClass("errorField");
          },
          /*****remove parent class*****/
          unhighlight: function(element) {
              $(element).parent().removeClass("errorField");
          },   
          /*****remove error text*****/
          errorPlacement: function () {
              return false;
          },
          /********* added date 22th november 2016 end ***********/
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
                                    
                                    poptriggerfunc(msgtype='error',titledata='',msgdata=error_message_data,sd=1000,hd=1500,tmo=1500,etmo=1500,poscls='toast-top-full-width');
                                
                               }
                               else
                               {
                                    //alert("Login successfully done");
                                    if(currentbkurl!='' && (currentbkurl!=base_url_data) )
                                    {
                                        
                                       // window.location.href=currentbkurl;

                                        var artistprofilematch = currentbkurl.match("/profile/"); //********matching for artist
                                        var groupprofilematch = currentbkurl.match("/groupprofile/"); //********matching for artist
                                        var venueprofilematch = currentbkurl.match("/venue/"); //********matching for artist
                                        if(artistprofilematch != null || groupprofilematch!= null || venueprofilematch!= null)
                                        {

                                            if(bookingmodalcheckoption == 'artist-modal-open'){
                                                window.location.href=currentbkurl+'/bk';
                                            }else if(bookingmodalcheckoption == 'venue-modal-open')
                                            {
                                                 window.location.href=currentbkurl+'/bk';
                                             }else if(bookingmodalcheckoption == 'group-modal-open')
                                             {
                                                 window.location.href=currentbkurl+'/bk';
                                             }
                                            else
                                            {
                                                window.location.href=currentbkurl;
                                            }


                                           // alert("Hello");
                                        }else{
                                        
                                            window.location.href=currentbkurl;
                                        }


                                    }
                                    else
                                    {
                                         window.location.href=base_url_data+"/myroster";
                                    }
                                   
                               }
                    
                               
                                
                               
                            }
                            
                            
                            });
            
                    //**** ajax code ends
                   
                      
       }
     
     
     
    
    
    
}