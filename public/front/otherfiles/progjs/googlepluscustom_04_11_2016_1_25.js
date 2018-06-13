
  /**
   * Handler for the signin callback triggered after the user selects an account.
   */
  function onSignInCallback(resp) {
			if (resp['access_token'])
			{
			  // The user has authorized the app, so lets see who we've got here...
				
				gplus_access_token=resp['access_token'];
			    //console.log("==access_token==>"+gplus_access_token);
			   
			   gapi.client.load('plus', 'v1', apiClientLoaded);
			}
			else if (resp['error'])
			{
			  // User has not authorized the G+ App!
			  
			   //console.log("==access_token not fetched==>"+resp['error']);
			}
    
  }

  /**
   * Sets up an API call after the Google API client loads.
   */
  function apiClientLoaded() {
    gapi.client.plus.people.get({userId: 'me'}).execute(handleEmailResponse);
  }

  /**
   * Response callback for when the API client receives a response.
   *
   * @param resp The API response object with the user email and profile information.
   */
  function handleEmailResponse(resp) {
    var primaryEmail=''; var displayName=''; var gender=''; var image_url='';
	
	//console.log("---->"+typeof(resp.emails));
	
	if (typeof(resp.emails)!="undefined")
	{
		 for (var i=0; i < resp.emails.length; i++) {
			if (resp.emails[i].type === 'account') primaryEmail = resp.emails[i].value;
		  }
		  //document.getElementById('responseContainer').value = 'Primary email: ' +
		  //    primaryEmail + '\n\nFull Response:\n' + JSON.stringify(resp);
        
        console.log("gmail=>");
       console.log(JSON.stringify(resp));
	}
	
	if (typeof(resp.displayName)!="undefined")
	{
		displayName=resp.displayName;
	}
	
	if (typeof(resp.gender)!="undefined")
	{
		gender=resp.gender;
	}
	
	if ( typeof(resp.image)!="undefined" && typeof(resp.image.url)!="undefined")
	{
		image_url=resp.image.url;
	}
	
	
	//console.log("==primaryEmail==>"+primaryEmail+"==response==>"+JSON.stringify(resp));
	//console.log("displayName=>"+displayName+"==gender=>"+gender+"==image_url==>"+image_url);
	
	if (primaryEmail!='' && gploginbuttonclickedflag==1)
	{
		var posturl="checkgooglepluslogin";
		callcheckemailforgooglepluslogin(primaryEmail,displayName,posturl);
    }
	
	
  }
  
  function callcheckemailforgooglepluslogin(primaryEmail,displayName,posturl)
  {
	
	 //**** ajax code starts
    
                        var postdata = {_token:csrf_token_data,email:primaryEmail,nickname:displayName,gplus_access_token:gplus_access_token}; 
                        var urldata=base_url_data+"/"+posturl;
                        jQuery.ajax({
                            
                            data:postdata,
                            dataType:'JSON',
                            url:urldata,
                            type:'POST',
                            success:function(d){
                                
                               var user_type=d.user_type;
                               
                               if (d.flag_id==0)
                               {
                               
                                                    var error_message=d.error_message;
                                                   
                                                    var error_message_data=error_message;                                                   
                                                   
													 
                                                 toastr.remove();
                                   
                                                if(user_type=='')
                                                    {
                                                        //***** populate dat from google and show signup modal starts
                                                        $("#nickname").val(displayName);
                                                        $("#email").val(primaryEmail);

                                                        $("#is_g_plus_signup").val(1);
                                                        $("#email").prop('disabled', true);

                                                        $("#myModal1").modal('hide');                                   
                                                        $("#myModal").modal('show');
                                                        //***** populate dat from google and show signup modal ends
                                                        
                                                        
                                                       if(googleloginfiredfrom!="signupmodal")
                                                       {
                                                          poptriggerfunc(msgtype='error',titledata='',msgdata=error_message_data,sd=1000,hd=1500,tmo=null,etmo=null,poscls='toast-top-full-width'); 
                                                       }
                                                    }
                                                   else
                                                       {
                                                           poptriggerfunc(msgtype='error',titledata='',msgdata=error_message_data,sd=1000,hd=1500,tmo=null,etmo=null,poscls='toast-top-full-width'); 
                                                       }
                                                    
                                   
                                   
                                   
                                   
                                   
                                
                               }
                               else
                               {
                                     // poptriggerfunc(msgtype='success',titledata='',msgdata="Registration done successfully",sd=1000,hd=1500,tmo=1000,etmo=1000,poscls='toast-bottom-center');
                              
				//window.location.href=base_url_data+"/myroster";
                                                                                          
                                        if(currentbkurl!='' && (currentbkurl!=base_url_data) )
                                                     {
                                                         // window.location.href=currentbkurl;


                                                          var artistprofilematch = currentbkurl.match("/profile/"); //********matching for artist
                                                          var groupprofilematch = currentbkurl.match("/groupprofile/"); //********matching for artist
                                                          var venueprofilematch = currentbkurl.match("/venue/"); //********matching for artist
                                                        //  alert("Hello");
                                                            if(artistprofilematch != null || groupprofilematch!= null || venueprofilematch!= null)
                                                            {
                                                               window.location.href=currentbkurl+'/bk';
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