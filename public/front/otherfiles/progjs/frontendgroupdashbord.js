function validationGroup() {
    $("#groupdashbordfrmid").validate({
       errorElement:'div',
       errorClass: 'authError',
			rules: {
				
				group_name: {
					required: true,
                    maxlength: 50,
                    remote: {
                         url: base_url_data+"/groupChekGrpName",
                         type: "post",
                         data: {
                                   
                                   re_password: function() {
                                            var group_name=$("#group_name").val();
                                            return group_name;
                              
                                   },
                                   _token:function(){
                                        return csrf_token_data;
                                   }
                            }
                    }
				},
                group_email:{
					required: true,
					email: true,
                    remote: {
                         url: base_url_data+"/groupChekEmail",
                         type: "post",
                         data: {
                                   
                                   re_password: function() {
                                            var group_email=$("#group_email").val();
                                            return group_email;
                              
                                   },
                                   _token:function(){
                                        return csrf_token_data;
                                   }
                            }
                    }
                },
                group_contact:{
					required: true,
                    number:true,
					minlength: 10
                },
                group_web_url:{
					required: true,
                },
                address_1: {
					required: true,
				}
			},
			messages: {
							
				group_name: {
					required: "Please group name",
                    maxlength:"Group name length maximum 50",
                    remote:"Group name must be unique",
				},
                group_email:{
				email: "Please enter a valid email address",
				termscond: "Please accept our terms and conditions",
                remote:"Group email must be unique",
                },
                group_contact:{
					required: "Please provide a cantact number",
                    number: "Please provide only number",
					minlength: "Your cantact number must be at least 10 characters long",
                },
                group_web_url:{
					required: "Please provide a cantact number",
                },
                address_1:{
                    required:"Please provide complete adress",
                },
			}
		});
}


$(document).ready(function(){
    
    $(document).on('click','#group_submit',function(){
    groupdashbordsubmit();
    });
    
    $( "#select_country" ).change(function() {
    var selected_value = $(this).val();
    city_drop(selected_value);
    });
    
    function city_drop(selected_value) {
    var myaccount_city_url=base_url_data+"/myaccountcity";
    var myaccount_city_data={_token:csrf_token_data,'country':selected_value};
    $.ajax({
     
     url:myaccount_city_url,
     type:'POST',
     dataType:'json',
     data:myaccount_city_data,
     success:function(d){
               
                         var select_state_html="";
                         select_state_html+="<option value=''>Select state</option>";
                         if (d!=null)
                         {
                         $.each(d, function(idx, obj)
                                {
                              
                               select_state_html+="<option value='"+obj.state_id+"'>"+obj.state_name+"</option>";
                               
                               });
                         }
                         $("#select_state").html(select_state_html);
                         $("#select_state").selectpicker('refresh');     
      
     }
     
     });
    }
    function groupdashbordsubmit(){
    validationGroup();
        var chkgroupdashbordfrmidvalidation =  $("#groupdashbordfrmid").valid();
        if (chkgroupdashbordfrmidvalidation == true) {
                
                 ajaxfromsubmit();
        }
    }
    function ajaxfromsubmit() {
                         
    var group_name = $('#group_name').val();
    var group_email = $('#group_email').val();
    var group_contact = $('#group_contact').val();
    var group_web_url = $('#group_web_url').val();
    var address_1 = $('#address_1').val();
    var address_2 = $('#address_2').val();
    var select_country = $('#select_country').val();
    var select_state = $('#select_state').val();
    var city = $('#city').val();
    var zip = $('#zip').val();
    var edit_group = $('#edit_group').val();
    
    var myaccountfrm_url=base_url_data+"/groupdashboardfrmsubmit";
    
    var myaccountfrm_data={_token:csrf_token_data,'edit_group':edit_group,'group_name':group_name,'group_email':group_email,'group_contact':group_contact,'group_web_url':group_web_url,'address_1':address_1,'address_2':address_2,'select_country':select_country,'select_state':select_state,'city':city,'zip':zip};
    
          $.ajax({
               
               url:myaccountfrm_url,
               type:'POST',
               dataType:'json',
               data:myaccountfrm_data,
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
                         if (error_message_data!='') {
                              $("#subscribeloader").addClass("mydisplaynone");              
                              poptriggerfunc(msgtype='error',titledata='',msgdata=error_message_data,sd=1000,hd=1500,tmo=null,etmo=null,poscls='toast-top-full-width');
                         }  
                    }
                    else if (d.flag_id==1) {
                         poptriggerfunc(msgtype='success',titledata='',msgdata="Your group created successfully",sd=3000,hd=2000,tmo=1000,etmo=1000,poscls='toast-top-full-width');
                         $("#subscribeform").trigger("reset");
                         $("#subscribeloader").addClass("mydisplaynone");
                         //alert(base_url_data+d.url);
                         //window.location.assign(base_url_data+"/groupedit/"+d.url);
                         window.location.assign(base_url_data+"/group/"+d.url);
                    }else
                    {
                         poptriggerfunc(msgtype='success',titledata='',msgdata="Your group updated successfully",sd=3000,hd=2000,tmo=1000,etmo=1000,poscls='toast-top-full-width');
                         $("#subscribeform").trigger("reset");
                         $("#subscribeloader").addClass("mydisplaynone");
                         //alert(base_url_data+d.url);
                         //window.location.assign(base_url_data+"/groupedit/"+d.url);
                         window.location.assign(base_url_data+"/group/"+d.url);
                    }
                    

               }
          });
    }
    
    
     $('#select_country').selectpicker();
     //$("#select_state").html('');
     $("#select_state").selectpicker('refresh');
     
});
