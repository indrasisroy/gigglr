
function callforsubscription(posturl)
{
     $("#subscribeform").validate({
       
		  rules: {
               email: {
                   required: true,
                   email: true
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

          $("#subscribeloader").removeClass("mydisplaynone");                        
                         
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
                         $("#subscribeloader").addClass("mydisplaynone");              
                         poptriggerfunc(msgtype='error',titledata='',msgdata=error_message_data,sd=3000,hd=2000,tmo=2000,etmo=2000,poscls='toast-bottom-right');                
                           }, 1000);
                    }
                    else
                    {
                         setTimeout(function()
                         { 
                              poptriggerfunc(msgtype='success',titledata='',msgdata="You have subscribed successfully",sd=3000,hd=2000,tmo=1000,etmo=1000,poscls='toast-bottom-right');
                              $("#subscribeform").trigger("reset");
                              $("#subscribeloader").addClass("mydisplaynone");
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
        });