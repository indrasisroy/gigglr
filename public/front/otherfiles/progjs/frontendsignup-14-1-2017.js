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
    
     // Disable the submit button to prevent multiple clicks
     jQuery("#registerbuttonid").attr({disabled: true});
    
     

     
     //******************* CUSTOM VALIDATION FOR Password for atleast one uppercase, one lowercase, one digit and one special character in SIGNUP Form
     $.validator.addMethod("checkpwdformat", function(value, element) 
     {
          var characterReg = /^(?=.{8,16})(?=[a-zA-Z0-9^\w\s]*)(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).*$/; //(?=.*[^\w\s])
          return characterReg.test(value);
     },"Your password must be at least 8 characters long and should contain atleast one uppercase, one lowercase, one digit and between 8-16 characters");
     
     //******************** CUSTOMe Email Validation
     
     $.validator.addMethod("checkemailformat", function(value, element) 
     {
          var emailpattern = /^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/;
     //var emailpattern = /^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i;
     return emailpattern.test(value);
     },"Email should be valid");
     $.validator.addMethod("checknameformat", function(value, element) 
     {
          var namepattern=/^[a-zA-Z]+(\s[a-zA-Z]+)?$/;
           return namepattern.test(value);
     },"Name should be valid only letters and no spaces");
  var signupvalidator = $("#signupfrmid").validate({
     
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
				
				nickname: {
					required: true,
					minlength: 2,
                         checknameformat: true
                    
				},
				password: {
					required: true,
					minlength: 8,
                    maxlength: 16,
                    checkpwdformat: true,
				},
				password_confirmation: {
					required: true,
					equalTo: "#password"
				},
				email: {
					required: true,
					email: true,
                    checkemailformat: true
				},
				termscond: {
					required: true,	
				},
				
			},
			messages: {
							
				nickname: {
					required: "Please enter a name",
					minlength: "Name must consist of at least 2 characters",
                         nameformat:"Please enter a valid name"
				},
				password: {
					required: "Please provide a password",
					minlength: "Your password must be at least 8 characters long and should contain atleast one uppercase, one lowercase, one digit and one special character",
                    maxlength: "Your password can be maximum 15 characters long"
				},
				password_confirmation: {
					required: "Please provide the password",
					equalTo: "Please enter the same password as above"
				},
				email: "Please enter a valid email address",
                    
				termscond:"Please accept our terms and conditions"				
			}
            
            
            
		});
     
          $(".signupclose").click(function() {
        signupvalidator.resetForm();
     });   
  
  $('.signinmodal').on('hidden.bs.modal', function () {
                            signupvalidator.resetForm();
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
                    var gender=jQuery('input[name=gender]:checked').val();

                    /**#######################  For google Signup Check Start   ############################**/
                    var is_g_plus_signup=jQuery("#is_g_plus_signup").val();
                    /**#######################  For google Signup Check Ends   ############################**/
                    
                    
                     var checkterms=jQuery("#termscond").prop('checked');
                    
                    if (checkterms)
                    {
        
                         //$("#signuploader").removeClass("mydisplaynone");
                         
//                         jQuery('html, body').animate({
//									scrollTop: jQuery("#signuploader").offset().top + 5 }, 'slow');
                         
                         
                     //**** ajax code starts
    
                        var postdata = {_token:tokendata,dob:dob,nickname:nickname,email:email,is_g_plus_signup:is_g_plus_signup,password:password,password_confirmation:password_confirmation,gender:gender,regtype:'normal'}; 
                        
                        postdataforregistration(postdata,posturl); // newly added 26/10/2016
                      
            
                    //**** ajax code ends
                    }
                    else
                    {
                      var error_message_data="You can only use this site if you read and agree to the Terms & Conditions";
                        poptriggerfunc(msgtype='error',titledata='',msgdata=error_message_data,sd=1000,hd=1500,tmo=null,etmo=null,poscls='toast-top-full-width');
                    
                        jQuery("#registerbuttonid").removeAttr('disabled');
                    }
                    
                      $('.signupmodal').modal('hide');                         
                          
       }
       else
       {
          jQuery("#registerbuttonid").removeAttr('disabled');
           
          $('.signinmodal').on('hidden.bs.modal', function () {
                            $("#email").val('');
                            $("#nickname").val('');
                            $("#password").val('');
                            $("#password_confirmation").val('');
                            $('input:checkbox[name=termscond]').attr('checked',false);
                        });    
       }
    
}

function postdataforregistration(postdata,posturl)
{
//    var postdata = {_token:tokendata,dob:dob,nickname:nickname,email:email,password:password,password_confirmation:password_confirmation,gender:gender,regtype:'normal'}; 
                        var urldata=base_url_data+"/"+posturl;
                        jQuery.ajax({
                            
                            data:postdata,
                            dataType:'JSON',
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
                                      //$("#signuploader").addClass("mydisplaynone");              
                                      poptriggerfunc(msgtype='error',titledata='',msgdata=error_message_data,sd=1000,hd=1500,tmo=null,etmo=null,poscls='toast-top-full-width');         
                                
                                     jQuery("#registerbuttonid").removeAttr('disabled');
                               }
                               else
                               {
                                   poptriggerfunc(msgtype='success',titledata='',msgdata="Great, thanks. We have sent you an account activation email",sd=3000,hd=2000,tmo=1000,etmo=1000,poscls='toast-top-full-width');
                                   $("#email").prop('disabled', false);
                                   $("#signupfrmid").trigger("reset");
                                   //$("#signuploader").addClass("mydisplaynone");
                                   $('#myModal').modal('hide');
                                   
                                   
                              }
                    
                               
                                
                               
                            }
                            
                            
                            });
}