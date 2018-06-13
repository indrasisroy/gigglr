$(document).ready(function(){
          var flag = 0;
          var ref_email_blurchk = true;
          $( "#select_country" ).change(function() {
          var selected_value = $(this).val();
          
          //console.log(my_wallet_amount);
          //console.log(parseInt(my_wallet_amount));
          //console.log("my_wallet_amount 0");
          
          toastr.remove();
          //if (my_wallet_amount != "0.00" || my_wallet_amount > 0.00 || parseInt(my_wallet_amount) != '0') {
          if (parseInt(my_wallet_amount) != 0){
                    
                    poptriggerfunc(msgtype='error',titledata='',msgdata="The Country, State or Currency can not be altered at this time",sd=6000,hd=1500,tmo=3000,etmo=4000,poscls='toast-top-full-width');
                    $( "#select_country").val(old_country);
          }
          else if (my_wallet_amount > 0.00) {
                    poptriggerfunc(msgtype='error',titledata='',msgdata="You can't change country 2, state & currency right now.",sd=6000,hd=1500,tmo=3000,etmo=4000,poscls='toast-top-full-width');
                    $( "#select_country").val(old_country);
          }else{
                    city_drop(selected_value);
          }

          });
          
          $(document).on('click','.reason',function(){
          var modal_reason=$(this).data("reason");
          $('#modal_reason_hidden').val(modal_reason);
          });
          
          
          $(document).on('click','.viewmyprofile',function(){
                    var location = $(this).data("location");
                    //alert("viewmyprofile "+location);
                    window.location.href = location;
          });
          
          
          
          $( "#currency" ).change(function() {
          var selected_value = $(this).val();
            toastr.remove();
            if (my_wallet_amount != "0.00" || my_wallet_amount > 0.00) {
                    poptriggerfunc(msgtype='error',titledata='',msgdata="Your con change currency right now",sd=6000,hd=1500,tmo=3000,etmo=4000,poscls='toast-top-full-width');          
                    if (my_currency != '') {
                        $(this).val(my_currency);
                    }
            }
          });
          
          
          
          $(document).on('blur','#emailid',function(){
                    var ref_email = $(this).val();
                    var pattern = new RegExp(/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i);
                    if (ref_email.length == 0) {
                              //alert("Too short");
                               $('#emailid').css('border-color', '');
                                $('.validation').hide();
                             // $('.validation').html("Please enter email address");
                              ref_email_blurchk = true;
                              
                    }else if (!pattern.test(ref_email)) {
                              $('#emailid').css('border-color', 'red');
                              $('.validation').show();
                              //$('.validation').html("Please enter valid address"); //errorField
                              $("#emailid").parent().addClass("errorField");
                              ref_email_blurchk = false;
                    }else{
                              $('#emailid').css('border-color', '');
                              $("#emailid").parent().removeClass("errorField");
                              $('.validation').hide();
                              ref_email_blurchk = true;
                              checkrefermail(ref_email);
                    }
                    

          });
          function city_drop(selected_value) {
            var myaccount_city_url=base_url_data+"/myaccountcity";
            var myaccount_city_data={_token:csrf_token_data,'country':selected_value};
             $.ajax({
               
               url:myaccount_city_url,
               type:'POST',
               dataType:'json',
               data:myaccount_city_data,
               success:function(d)
               {

                    //console.log(d.state.length);
                         
                    var select_state_html="";
                    select_state_html+="<option value=''>Select state</option>";
                    if (d.state.length > 0 && d.state.length!='')
                    {
                        $.each(d.state, function(idx, obj)
                              {
                              
                              select_state_html+="<option value='"+obj.state_id+"'>"+obj.state_3_code+"</option>";
                              
                              });
                        
                        
                    }
                    $("#select_state").html(select_state_html);
                    $("#select_state").selectpicker('refresh');
                    if (d.currency_code!='' && d.currency_icon!='' ) {
                              var code = '';
                              if (d.currency_code!='0') {
                                code = d.currency_code;
                              }
                              var icon = '';
                              if (d.currency_icon!='0') {
                                icon = d.currency_icon;
                              }
                              $('#currency').val(code+" ( "+icon+" )");
                              my_currency = d.country;
                    }else{
                              $('#currency').val("");
                              my_currency = d.country;
                    }
                
               }
               });
          }
          
          function checkrefermail(ref_email)
          {
          
          var myaccountreferemail_url=base_url_data+"/myaccountreferemail";
          var myaccountreferemail_data={_token:csrf_token_data,'ref_email':ref_email};
            
             $.ajax({
               
               url:myaccountreferemail_url,
               type:'POST',
               dataType:'json',
               data:myaccountreferemail_data,
               success:function(d){
                         //***************** Check refer email start
                         if (d.msg=="not") {
                              $('#emailid').css('border-color', 'red');
                              $('.validation').show();
                              //$('.validation').html("You can't refer this email address");
                              $("#emailid").parent().addClass("errorField");
                              ref_email_blurchk = false;
                         }else if(d.msg=="you"){
                              $('#emailid').css('border-color', 'red');
                              $('.validation').show();
                              //$('.validation').html("You can't refer this email address");
                              $("#emailid").parent().addClass("errorField");
                              ref_email_blurchk = false;
                         }else{
                              $('.validation').hide();
                              $('#emailid').css('border-color', '');
                              $("#emailid").parent().removeClass("errorField");
                              ref_email_blurchk = true;
                              
                         }
                         //***************** Check refer email ends      
               }
               
               });
          }
          
          $(document).on('click','#modal_submit',function(){
                   
                    //**********New code 01-06-16 start*********//
                    /*validationCheckPasswordConfirm();
                    var myaccountCheckPasswordValidation =  $("#myaccountfromCheckPass").valid();
                    //alert(myaccountCheckPasswordValidation);
                    /*if (myaccountCheckPasswordValidation == false) {
                              $('.validationpass').hide();
                              $('#re_password').val("");
                              $('#password-apply').modal('toggle');
                              if (modal_reason_hidden=="save") {
                                myaccountfrmidsubmit();
                              }else{
                                $('.deactive_div').show();
                              }
                    }else{
                              //alert("true");

                    }
                    if (myaccountCheckPasswordValidation) {
                    //doneCheckPasswordValidation();
                    alert("true check");
                    }else{
                    alert("false check");
                    }*/

                    //**********New code 01-06-16 end*********//
                    //**************Old code star**********//
                    
                    var re_password = $('#re_password').val();
                    if (re_password.length > 0) {
                             recheckpassword(re_password);
                    }else{
                    $('.validationpass').show();
                    //$('.validationpass').html("Please enter your password");
                    $('#re_password').val(re_password);
                    $("#re_password").parent().addClass("errorField");
                    }
                    
                    //**************Old code end**********
          });
          function doneCheckPasswordValidation(){
           var modal_reason_hidden = $('#modal_reason_hidden').val();
           alert(modal_reason_hidden);
          }
          
          function recheckpassword(re_password) {
          var modal_reason_hidden = $('#modal_reason_hidden').val();
          var myaccountchkpass_url=base_url_data+"/myaccountchkpass";
          var myaccountchkpass_data={_token:csrf_token_data,'re_password':re_password};
            
             $.ajax({
               
               url:myaccountchkpass_url,
               type:'POST',
               //dataType:'json',
               data:myaccountchkpass_data,
               success:function(d){
                    
                    if (d=='false') {
                              
                              $('#re_password').val(re_password);
                              $("#re_password").parent().addClass("errorField");
                              //$('.validationpass').show();
                              //$('.validationpass').html("Wrong Password");
                              
                    }else{
                              $("#re_password").parent().removeClass("errorField");
                              //$('.validationpass').hide();
                              $('#re_password').val("");
                              $('#password-apply').modal('toggle');
                              if (modal_reason_hidden=="save") {
                              myaccountfrmidsubmit();
                              }else{
                              $('.deactive_div').show();
                              }
                    }
     
               }
               
               });
          }
          $(document).on('click','#deactive_confirm',function(){
                    //alert("deactive from sumbit action"); 
                    validationDeactiveConfirm();
                    var myaccountDeactiveValidation =  $("#myaccountfromdeactive").valid();
                    if (myaccountDeactiveValidation== true) {
                        ajaxDeactivefromsubmit();
                    }
          });
          
          function myaccountfrmidsubmit(){
                    validationMyAccount();
                    var chkmyaccountvalidation =  $("#myaccountfrmid").valid();
                    
                    var passwordchangemsg = passwordchange();
                    toastr.remove();
                    if (chkmyaccountvalidation== true) {
                             
                              ajaxfromsubmit();
                    }else{
                           //  poptriggerfunc(msgtype='error',titledata='',msgdata="Please fill all mandatory field",sd=1000,hd=1500,tmo=null,etmo=null,poscls='toast-top-full-width');
                             $("html, body").animate({ scrollTop: 0 }, 500);
                    }
          }
          function passwordchange() {
                  var old_password = $('#old_password').val();
                  var new_password = $('#new_password').val();
                  var con_password = $('#con_password').val();

          }
          
    function  ajaxfromsubmit() {
    var ref_email_field = $('#ref_email_field').val();
    var dob = $('#dob').val();
    var referemail_data ='';
    var referemail = $('#emailid').val();
    if (ref_email_field!=1) {
        referemail_data = referemail;
    }
    
    var first_name = $('#first_name').val();

    var seo_name = $('#seo_name').val();
    


    var middle_name = $('#middle_name').val();
    var last_name = $('#last_name').val();
    var phone = $('#phone').val();
    var email = $('#email').val();
    var address1 = $('#address1').val();
    var address2 = $('#address2').val();
    var select_country = $('#select_country').val();
    var select_state = $('#select_state').val();
    var city = $('#city').val();
    var zip = $('#zip').val();
    var phone = $('#phone').val();
    var dobDays = $('#dobDays').val();
    var dobMonths = $('#dobMonths').val();
    var dobYears = $('#dobYears').val();    
    var genderradio = $('input[name=gender]:checked', '#myaccountfrmid').val();
    var select_Language = $('#select_Language').val();

    var currency = '';
    if (my_currency!='') {
        currency = my_currency;
    }else{
        currency = my_old_currency;
    }
    
    var old_password = $('#old_password').val();
    var new_password = $('#new_password').val();
    var con_password = $('#con_password').val();

    var myaccountfrm_url=base_url_data+"/myaccountfrmsubmit";
    
    var myaccountfrm_data={_token:csrf_token_data,'referemail':referemail_data,'dob':dob,'seo_name':seo_name,'first_name':first_name,'middle_name':middle_name,'last_name':last_name,'phone':phone,'email':email,'address1':address1,'address2':address2,'select_country':select_country,'select_state':select_state,'city':city,'zip':zip,'phone':phone,'dobDays':dobDays,'dobMonths':dobMonths,'dobYears':dobYears,'genderradio':genderradio,'select_Language':select_Language,'currency':currency,'old_password':old_password,'new_password':new_password,'con_password':con_password};
          toastr.remove();
          $.ajax({
               
               url:myaccountfrm_url,
               type:'POST',
               dataType:'json',
               data:myaccountfrm_data,
               success:function(d){
                    //console.log(d);
                    if (d.flag_id == 1) {
                    
                              if (first_name != lst_first_name) {
                                   $(".myaccountname").html("Hi "+first_name+",");
                                   //console.log("Hi "+first_name+",");
                              }else{
                              //alert("not change");
                              }
                        //alert(d.flag_id);
                    }else{
                        //alert(d.flag_id);      
                    }
                    
                    if (d.flag_id == 0)
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
                              poptriggerfunc(msgtype='error',titledata='',msgdata=error_message_data,sd=1000,hd=1500,tmo=1000,etmo=1000,poscls='toast-top-full-width');
                         }
                         
                    }else if (d.flag_id == 3) {
                        $("#subscribeloader").addClass("mydisplaynone");              
                              poptriggerfunc(msgtype='error',titledata='',msgdata="Please check that your address",sd=1000,hd=1500,tmo=1000,etmo=1000,poscls='toast-top-full-width');
                    }
                    else
                    {
                         poptriggerfunc(msgtype='success',titledata='',msgdata="Your account details have been saved",sd=3000,hd=2000,tmo=1000,etmo=1000,poscls='toast-top-full-width');
                         $("#subscribeform").trigger("reset");
                         $("#subscribeloader").addClass("mydisplaynone");
                    
                    }

               }
          });
    }
    function ajaxDeactivefromsubmit() {
    var deactive_reason = $('#deactive_reason').val();
    var subscriptions = $('input[name=subscriptions]:checked', '#myaccountfromdeactive').val();
    var gig_notification = $('input[name=gig_notification]:checked', '#myaccountfromdeactive').val();
    
    var myaccountfromdeactive_url=base_url_data+"/myaccountdeactivefrmsubmit";
    
    var myaccountfromdeactive_data={_token:csrf_token_data,'deactive_reason':deactive_reason,'subscriptions':subscriptions,'gig_notification':gig_notification};
    
          $.ajax({
               
               url:myaccountfromdeactive_url,
               data:myaccountfromdeactive_data,
               type:'POST',
               dataType:'json',
               success:function(d){
                    //console.log(d);
                    /*
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
                                      
                         $("#subscribeloader").addClass("mydisplaynone");              
                         poptriggerfunc(msgtype='error',titledata='',msgdata=error_message_data,sd=1000,hd=1500,tmo=null,etmo=null,poscls='toast-top-full-width');                
                    }

                    if (d.my_msg.type==0) {
                       var error_message=d.error_message;
                         var error_message_data='';
                                                    
                         if (error_message!=null)
                         {
                              for (ermsgkey in error_message)
                              {
                                   error_message_data+="<p>"+ error_message[ermsgkey]+"</p>";
                              }
                         }
                                      
                         $("#subscribeloader").addClass("mydisplaynone");              
                         poptriggerfunc(msgtype='error',titledata='',msgdata=d.my_msg.text,sd=1000,hd=1500,tmo=null,etmo=null,poscls='toast-top-full-width');                
                    
                    }else{
                          poptriggerfunc(msgtype='success',titledata='',msgdata=d.my_msg.text,sd=3000,hd=2000,tmo=1000,etmo=1000,poscls='toast-top-full-width');
                         $("#subscribeform").trigger("reset");
                         $("#subscribeloader").addClass("mydisplaynone");    
                    }
                    if (d.my_msg.type_deact==0) {
                       var error_message=d.error_message;
                         var error_message_data='';
                                                    
                         if (error_message!=null)
                         {
                              for (ermsgkey in error_message)
                              {
                                   error_message_data+="<p>"+ error_message[ermsgkey]+"</p>";
                              }
                         }
                                      
                         $("#subscribeloader").addClass("mydisplaynone");              
                         poptriggerfunc(msgtype='error',titledata='',msgdata=d.my_msg.text_deact,sd=1000,hd=1500,tmo=null,etmo=null,poscls='toast-top-full-width');                
                    
                    }else{
                          poptriggerfunc(msgtype='success',titledata='',msgdata=d.my_msg.text_deact,sd=3000,hd=2000,tmo=1000,etmo=1000,poscls='toast-top-full-width');
                         $("#subscribeform").trigger("reset");
                         $("#subscribeloader").addClass("mydisplaynone");    
                    }
                    //alert(d.my_msg.text_deact);
                    //window.location.assign(base_url_data);
                  */
                    window.location.assign(base_url_data);
               }
          });
    }
});

//*************Deactive from validation start******
function validationDeactiveConfirm() {
$("#myaccountfromdeactive").validate({
       
			rules: {
				
				deactive_reason: {
					required: true,
					maxlength: 200,
				}
			},
			messages: {
							
				deactive_reason: {
					required: "Please enter deactivation reason",
					maxlength: "Name must consist maximum 200 characters"
				}
                
			}
		});
}
//*************Deactive from validation end******


//*************Check password from validation start******
function validationCheckPasswordConfirm() {
$("#myaccountfromCheckPass").validate({
       
			rules: {
				
				re_password: {
					required: true,
                    remote: {
                         url: base_url_data+"/myaccountchkpass",
                         type: "post",
                         data: {
                                   
                                   re_password: function() {
                                            var OldPass=$("#re_password").val();
                                            return OldPass;
                              
                                   },
                                   _token:function(){
                                        return csrf_token_data;
                                   }
                            }
                    }
				}
			},
			messages: {
							
				re_password: {
					required: "Please enter your password",
					remote:"Wrong password",
				}
                
			}
		});
}
//*************Check password from validation start******


//*************My Account update from validation start******
function validationMyAccount() {
$.validator.addMethod("checkpwdformat", function(value, element) 
{
          //var characterReg = /(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}/;
          var characterReg = /^(?=.{8,15})(?=[a-zA-Z0-9^\w\s]*)(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*[^\w\s]).*$/;
          return characterReg.test(value);
},"Password should contain atleast one uppercase, one lowercase, one digit and one special character");

$.validator.addMethod("checkemailformat", function(value, element) 
{
var emailpattern = /^([0-9a-zA-Z]+([_.-]?[0-9a-zA-Z]+)*@[0-9a-zA-Z]+[0-9,a-z,A-Z,.,-]*(.){1}[a-zA-Z]{2,4})+$/;
return emailpattern.test(value);
},"Email should valid");

     $("#myaccountfrmid").validate({
          
    /********* added date 22th november 2016 start ***********/ 
    /*****add parent class*****/
    highlight: function(element) {
        $(element).parent().addClass("errorField");
    },
    /*****remove parent class*****/
    unhighlight: function(element) {
        $(element).parent().removeClass("errorField");
       // $(select).parent().removeClass("errorField");
    },   
    /*****remove error text*****/
    errorPlacement: function () {
        return false;
    },
    /********* added date 22th november 2016 end ***********/
    
       errorElement:'span',
       errorClass: 'authError',
			rules: {
				seo_name: {
          required: true,
          minlength: 6
                    },
			
            	first_name: {
					required: true,
					minlength: 2,
                    
				},
				last_name: {
					required: true,
					minlength: 2
				},
				phone: {
					required: true,
          number:true,
					maxlength: 10
				},
				email: {
					required: true,
                    checkemailformat: true,
					email: true
				},
                address1: {
					required: true,
				},
         skill_parent: {
          required: true,
        },
         select_state: {
          required: true,
        },
        city: {
          required: true,
        },
        zip: {
          required: true,
        },
          re_password: {
					required: true,
				},
                select_Language :{ required: true },
                old_password :{
                    remote: {
                                                  url: base_url_data+"/myaccountchkpass",
                                                  type: "post",
                                                  data: {
                                                            
                                                             re_password: function() {
                                                                      var OldPass=$("#old_password").val();
                                                                     return OldPass;
                                                  
                                                             },
                                                             _token:function(){
                                                                      return csrf_token_data;
                                                             }
                                                      }
                               }
                },
                new_password :{
                    required :{
                                        depends: function(element)
                                        {
                                                  return $("#old_password").val()!='';
                                        }
                              },
                    minlength : 8,
                    checkpwdformat :{
                                        depends: function(element)
                                        {
                                                  return $("#old_password").val()!='';
                                        }
                              },
                },
                con_password :{
                    minlength : 8,
                      equalTo : "#new_password"
                },
                gender :{
                    required: true,
                }
				
			},
			messages: {
				seo_name: {
          required: "Please enter your seo url",
          minlength: "SEO url must consist of at least 6 characters"
        },			
				first_name: {
					required: "Please enter a username",
					minlength: "Name must consist of at least 2 characters"
				},
				last_name: {
					required: "Please provide a last name",
					minlength: "Your password must be at least 2 characters long"
				},
				phone: {
					required: "Please provide a contact number",
                                                   number: "Please provide only number",
					maxlength: "Your contact number must be 10 characters",
				},
				email: "Please enter a valid email address",
				termscond: "Please accept our terms and conditions",
				address1:{
                    required:"Please provide complete adress",
                },
                re_password:{
                    required:"Please provide password",
                },
                select_Language: { required: "Please select an language!" },
                old_password :{
                    remote:"Wrong Password",
                },
                new_password :{
                    required:"Please correct password",
                    minlength : "Please, 8 Character minimum"
                },
                con_password :{
                    minlength : "Please, 8 Character minimum",
                      equalTo : "Please, confirm your new password"
                },
                gender :{
                    required: "Please provide gender",
                }   
			} 
		});
}
//*************My Account update from validation start******