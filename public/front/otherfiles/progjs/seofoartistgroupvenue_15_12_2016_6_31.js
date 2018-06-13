

            
$(document).ready(function(){
		$(".nowseourltxtcommncls").keydown(function(e) {
		                                
		                                var urlatrrid=$(this).attr("id");
		                                
		                               // alert(base_url_data+urlatrrid);

		                                
		                                var artistprofile_url_deflt=base_url_data+"/artist/";
		                                var groupprofile_url_deflt=base_url_data+"/group/";
		                                var venueprofile_url_deflt=base_url_data+"/venue/";
		                                
		                                //alert(artistprofile_url_deflt);
		                                var checkdata='';
		                                
		                                 if (urlatrrid=="pagemetatagcust_artist")
		                                  {
		                                     
		                                       checkdata=artistprofile_url_deflt;
		                                  }else if(urlatrrid=="pagemetatagcust_group")
		                                  {
		                                  	 checkdata=groupprofile_url_deflt;
		                                  }
		                                  else if(urlatrrid=="pagemetatagcust_venue")
		                                  {
		                                  	 checkdata=venueprofile_url_deflt;
		                                  }
		                                  
		                                
		                                var oldvalue=$(this).val();
		                                var field=this;
		                                //console.log(field.value.indexOf(checkdata));
		                                setTimeout(function () {
		                                if(field.value.indexOf(checkdata) !== 0) {
		                                  $(field).val(oldvalue);
		                                }
		                                }, 1);
		                                
		                                
		                });

 });

function callsavepagemetatagcustfunc() 
                {


                	   				var artistID=$(".nowseourltxtcommncls").attr("id");
                	   				var cmsgdata="Seo url is saved successfully"; 
                	   				var pagemetatagdata='';
                	   				var callingurl ='';
                	   				var replacetostring ='';
                	   				var replacedstring = '';
                	   				var redirecttourldata ='';
                	   				//alert(artistID);

                	   				if(artistID == 'pagemetatagcust_artist')
                	   				{
   							         pagemetatagdata=$('#pagemetatagcust_artist').val();
					              
					                 callingurl=base_url_data+"/savepageseotagcust";
					                 replacetostring = base_url_data+'artist/';
					                 replacedstring = pagemetatagdata.replace(base_url_data, "");
					                 replacedstring = replacedstring.replace('/artist/', "");
					                
					                 redirecttourldata = 'artist/'+replacedstring;

					               }else if(artistID == 'pagemetatagcust_group')
					               {
					               	
					               	 pagemetatagdata=$('#pagemetatagcust_group').val();
					                 callingurl=base_url_data+"/saveseourlcustgroup";  //savepagemetatagcustgroup
					                 replacetostring = base_url_data+'group/';
					                 replacedstring = pagemetatagdata.replace(base_url_data, "");
					                 replacedstring = replacedstring.replace('/group/', "");
					                //alert(" replacedstring "+replacedstring);
					                 redirecttourldata = replacedstring;
					               }
					               else if(artistID == 'pagemetatagcust_venue')
					               {
					               	
					               	 pagemetatagdata=$('#pagemetatagcust_venue').val();
					                 callingurl=base_url_data+"/saveseourlcustvenue";  //savepagemetatagcustVenue
					                 replacetostring = base_url_data+'venue/';
					                 replacedstring = pagemetatagdata.replace(base_url_data, "");
					                 replacedstring = replacedstring.replace('/venue/', "");
					                
					                 redirecttourldata = replacedstring;
					               }

					               
					               
					                

					                var callurlwithdata={_token:csrf_token_data,'pagemetatagdata':replacedstring};

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
					                                                                poptriggerfunc(msgtype='error',titledata='',msgdata=error_message_data,sd=1000,hd=1500,tmo=2000,etmo=2000,poscls='toast-top-full-width');          
					                                                }
					                                                else
					                                                {
					                                                                poptriggerfunc(msgtype='success',titledata='',msgdata=cmsgdata,sd=1000,hd=1500,tmo=3000,etmo=3000,poscls='toast-top-full-width');
					                                                                
					                                                                if(artistID == 'pagemetatagcust_artist')
                	   																{
					                                                                	$("#profileseo").attr("href", redirecttourldata);
					                                                               	}
					                                                               	 if(artistID == 'pagemetatagcust_group')
                	   																{
					                                                                	setTimeout(function(){
					                                                                	window.location.href=base_url_data+'/editgroup/'+redirecttourldata;	
					                                                                },1000);
					                                                                	
					                                                               	}
					                                                               	 if(artistID == 'pagemetatagcust_venue')
                	   																{
					                                                                	//$("#venueprofileseo").attr("href", redirecttourldata);
					                                                                	setTimeout(function(){
					                                                                	window.location.href=base_url_data+'/venue-edit/'+redirecttourldata;	
					                                                                },1000);
					                                                               	}
					                                                }     
					                                                //***************** Check response ends         
					                                }
					                });
						}










						$('.pagemetatagcustcls').click(function()
						{
								var initVal = $(this).find('.outPut').text();
								$(this).find('.editInput').val(initVal).show().focus();
								$(this).addClass('editable');

								$( "#pagemetatagcust_artist" ).on('blur', function () {

									var currentVal = $(this).val();
									$(this).parents('.btn_row').find('.outPut').text(currentVal);
									$(this).parents('.btn_row').removeClass('editable');
									$(this).parents('.btn_row').find('.editInput').hide();
									callsavepagemetatagcustfunc();
								});

								$( "#pagemetatagcust_group" ).on('blur', function () {

									var currentVal = $(this).val();
									$(this).parents('.btn_row').find('.outPut').text(currentVal);
									$(this).parents('.btn_row').removeClass('editable');
									$(this).parents('.btn_row').find('.editInput').hide();
									callsavepagemetatagcustfunc();
								});
								$( "#pagemetatagcust_venue" ).on('blur', function () {

									var currentVal = $(this).val();
									$(this).parents('.btn_row').find('.outPut').text(currentVal);
									$(this).parents('.btn_row').removeClass('editable');
									$(this).parents('.btn_row').find('.editInput').hide();
									callsavepagemetatagcustfunc();
								});

								$( "#pagemetatagcust_artist" ).bind('keyup',function( event ) {
									if ( event.which == 13 )
									{
									   $( "#pagemetatagcust_artist" ).trigger('blur');            
									}
								});
								$( "#pagemetatagcust_group" ).bind('keyup',function( event ) {
									if ( event.which == 13 )
									{
									   $( "#pagemetatagcust_group" ).trigger('blur');            
									}
								});
								$( "#pagemetatagcust_venue" ).bind('keyup',function( event ) {
									if ( event.which == 13 )
									{
									   $( "#pagemetatagcust_venue" ).trigger('blur');            
									}
								});
            			});