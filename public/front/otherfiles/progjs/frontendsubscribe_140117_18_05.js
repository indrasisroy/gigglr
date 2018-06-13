
function callforsubscription(posturl)
{
     
     //******************** CUSTOMe Email Validation
     
     $.validator.addMethod("checkemailformat", function(value, element) 
     {
     var emailpattern = /^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i;
     return emailpattern.test(value);
     },"Email should valid");
     
     $("#subscribeform").validate({
       
		  rules: {
               email: {
                   required: true,
                   email: true,
                   checkemailformat: true
               },
		  },
		  messages: {
				email: "Please enter a valid email address",
		  }
	 });
       
     var chksubscribevalidation=  $("#subscribeform").valid();
       
     toastr.remove();// Immediately remove current toasts without using animation
       
     if (chksubscribevalidation)
     {
          var email=jQuery("#subscribe_email").val();

          //$("#subscribeloader").removeClass("mydisplaynone");                        
                         
          //**** ajax code starts
    
          var postdata = {_token:csrf_token_data,email:email}; 
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
                         
                        setTimeout(function()
                        {                
                         //$("#subscribeloader").addClass("mydisplaynone");              
                         poptriggerfunc(msgtype='error',titledata='',msgdata=error_message_data,sd=3000,hd=2000,tmo=2000,etmo=2000,poscls='toast-top-full-width');                
                           }, 1000);
                    }
                    else
                    {
                         setTimeout(function()
                         { 
                              poptriggerfunc(msgtype='success',titledata='',msgdata="You are now subscibed to the Prosessional mailing list",sd=3000,hd=2000,tmo=1000,etmo=1000,poscls='toast-top-full-width');
                              $("#subscribeform").trigger("reset");
                              //$("#subscribeloader").addClass("mydisplaynone");
                          }, 1500);
                    }
               }                 
          });
            
          //**** ajax code ends
     }    
}

jQuery(document).ready(function(){
                    
        $('#subscribebut').click(function(){
              callforsubscription("subscribe");
          });


        //**********for disable eneter button starts here

              $('#subscribe_email').keypress(function(event) {
              if (event.keyCode == 13) {
                event.preventDefault();
              }
              });


        //**********for disable enter buton ends here

        });