     $(document).ready(function()
     {
               $('.open-forgotpass').click(function()
               {
                      setTimeout(function(){
                          $('.btnfrgt').click();
                      }, 1000);
               });
               
               
               
               $('#forgotpass_email').keypress(function(e) {
              if (e.keyCode == '13') {
                 e.preventDefault();
                 //your code here
               }
             });
             
     });


//function callforregister(posturl,tokendata)
//{
//    
//    //console.log("=base_url_data=>"+base_url_data);    
//     
//     //// custome validation sample
//     //jQuery.validator.addMethod("soumik", function(value, element)
//     //{
//     //
//     //     //alert("value==>"+value+"==element==>"+$(element).val());
//     //     return false;
//     //}, "soumik testing");
//
//     
//     $("#signupfrmid").validate({
//       
//			rules: {
//				
//				first_name: {
//					required: true,
//					minlength: 2,
//                    
//				},
//				password: {
//					required: true,
//					minlength: 6
//				},
//				password_confirmation: {
//					required: true,
//					minlength: 6,
//					equalTo: "#password"
//				},
//				email: {
//					required: true,
//					email: true
//				},
//				termscond: {
//					required: true,
//                    
//					
//				},
//				
//			},
//			messages: {
//							
//				first_name: {
//					required: "Please enter a username",
//					minlength: "Name must consist of at least 2 characters"
//				},
//				password: {
//					required: "Please provide a password",
//					minlength: "Your password must be at least 6 characters long"
//				},
//				password_confirmation: {
//					required: "Please provide a password",
//					minlength: "Your password must be at least 6 characters long",
//					equalTo: "Please enter the same password as above"
//				},
//				email: "Please enter a valid email address",
//				termscond: "Please accept our terms and conditions",
//				
//			}
//            
//            
//            
//		});
//     
//     
//    
//       var chksignupvalidation=  $("#signupfrmid").valid();
//       
//       if (chksignupvalidation)
//       {
//                     var dob=jQuery("#dob").val();
//                    var first_name=jQuery("#first_name").val();
//                    var email=jQuery("#email").val();
//                    var password=jQuery("#password").val();
//                    var password_confirmation=jQuery("#password_confirmation").val();
//                    var gender=jQuery("#gender").val();
//                    
//                    
//                    
//                     var checkterms=jQuery("#termscond").prop('checked');
//                    
//                    if (checkterms)
//                    {
//        
//                     //**** ajax code starts
//    
//                        var postdata = {_token:tokendata,dob:dob,first_name:first_name,email:email,password:password,password_confirmation:password_confirmation,gender:gender}; 
//                        var urldata=base_url_data+"/"+posturl;
//                        jQuery.ajax({
//                            
//                            data:postdata,
//                            dataType:'JSON',
//                            url:urldata,
//                            type:'POST',
//                            success:function(d){
//                                
//                               
//                               
//                               if (d.flag_id==0)
//                               {
//                               
//                                                    var error_message=d.error_message;
//                                                   
//                                                    var error_message_data='';
//                                                    
//                                                    if (error_message!=null)
//                                                    {
//                                                                for (ermsgkey in error_message)
//                                                             {
//                                                                  error_message_data+="<p>"+ error_message[ermsgkey]+"</p>";
//                                                             }
//                                                    }
//                                    alert("Invalid data provided");                
//                                
//                               }
//                               else
//                               {
//                                    alert("Registration successfully done");
//                               }
//                    
//                               
//                                
//                               
//                            }
//                            
//                            
//                            });
//            
//                    //**** ajax code ends
//                    }
//                    else
//                    {
//                       alert(" You haven't agreed to terms and conditions! ");
//                    }
//       }
//     
//}
function callforforgotpassword(posturl,tokendata)
{
    //alert(posturl+'Token Data is '+tokendata);
    
    $("#frgtpassfrm").validate({
       
			rules: {
				forgotpass_email: {
					required: true,
					email: true
				},
				
			},
			messages: {
			   email: "Please enter a valid email address",
               required: "Please enter an email address",
              
			}
            
            
            
		});
    
    var chksignupvalidation=  $("#frgtpassfrm").valid();
    
    
       
       if (chksignupvalidation)
       {
          
               var forgotemail=jQuery("#forgotpass_email").val();
                               
               var postdata = {_token:tokendata,forgotemail:forgotemail}; 
               var urldata=base_url_data+"/"+posturl;
               
               //alert("Post data =======>"+postdata+"url data =========="+urldata);
               jQuery.ajax({
               data:postdata,
               dataType:'JSON',
               url:urldata,
               type:'POST',
               success:function(d)
               {
                  if (d.flag_id==0)
                               {
                                   
                               //alert("Invalid data provided");
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
                                   //alert("valid data provided");
                                    poptriggerfunc(msgtype='success',titledata='',msgdata="Please check your Mail to Reset your password",sd=1000,hd=1500,tmo=1000,etmo=1000,poscls='toast-bottom-center');
                               }
               }
               
             });                   
          
         // alert('form validate successfully');   
       }/*else
       {
          alert('form not validated');
          return false;
       }*/
       
    
    
}