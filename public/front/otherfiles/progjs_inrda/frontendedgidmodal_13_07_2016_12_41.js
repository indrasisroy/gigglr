
$(document).ready(function(){
  var userType = 1;
  getParentSkill(userType);
  getCountryData();
    $("#country_gigp").selectpicker('refresh');
    
    $("#select_state_gigp").selectpicker('refresh');
    
    $("#skillcategory").selectpicker('refresh');
    
    $("#skillgenre").selectpicker('refresh');
    
    
    $("#clickme1").on("click", (function () {
      $( ".new-location" ).toggle();
      $(this).parent().toggleClass('clickBorder');
      $('.new-location').find('.form-control:eq(0)').focus();
    }));
    $('.closeLoc').click(function(){
        $(".new-location").toggle();
        $(".reqField").removeClass('clickBorder');
    });
    $('.gig_type').change(function(){
      var value = $(this).val();
      if (value ==1) {
        userType = value;
        $("#skillgenre").html("");
        $("#skillgenre").selectpicker('refresh');
        getParentSkill(value);
      }else{
        userType = value;
      $("#skillgenre").html("");
      $("#skillgenre").selectpicker('refresh');
        getParentSkill(value);
      }
    });
    function getParentSkill(args) {
    var callingurl=base_url_data+"/getparentskill";
    var callurlwithdata={_token:csrf_token_data,Gigtype:args};   
            
     $.ajax({
       
       url:callingurl,
       type:'POST',
       dataType:'json',
       data:callurlwithdata,
       success:function(d){
            var subskillopt="";
            
            if (d!=null)
            {
              subskillopt+="<option value=''>Select Category</option>";
                $.each(d, function(idx, obj)
                       {
                     
                      subskillopt+="<option value='"+obj.id+"'>"+obj.name+"</option>";
                      
                      });
                
                
            }
            $("#skillcategory").html(subskillopt);
            $("#skillcategory").selectpicker('refresh');     
        
       }
       
      });
    }
    
    $('#skillcategory').on('change',function(evnt){

     var  skill_parent_data=$(this).val();
     var typeofcall="skilladd"; var catag_type=userType;              
    
     
      if (skill_parent_data!='' && skill_parent_data!=null)
      {
                 //**** call ajax to populate date to skill_sub starts
                 
                 var callingurl=base_url_data+"/"+"gigsubskill";
                 var callurlwithdata={_token:csrf_token_data,parent_id:skill_parent_data,catag_type:catag_type};
                 
                 $.ajax({
                      url:callingurl,
                      data:callurlwithdata,
                      type:'POST',
                      dataType:'JSON',
                      success:function(d){
                           var subskillopt="";
                           
                           if (d!=null)
                           {
                               $.each(d, function(idx, obj)
                                      {
                                     subskillopt+="<option value='"+obj.id+"'>"+obj.name+"</option>";
                                     });
                           }                                        
                           
                           $("#skillgenre").html(subskillopt);
                           $("#skillgenre").selectpicker('refresh');                                        
                           
                      }
                      
                      });
                 
                 //**** call ajax to populate date to skill_sub ends
                 
      }
      else
      {
                           $("#skillgenre").html("");
                           $("#skillgenre").selectpicker('refresh');
      }
     });
    function getCountryData(){
    var callingurl=base_url_data+"/getcountrydatagig";
    var callurlwithdata={_token:csrf_token_data};   
            
     $.ajax({
       
       url:callingurl,
       type:'POST',
       dataType:'json',
       data:callurlwithdata,
       success:function(d){
            var subskillopt="";
            
            if (d!=null)
            {
              subskillopt+="<option value=''>Select Country</option>";
                $.each(d, function(idx, obj)
                       {
                     
                      subskillopt+="<option value='"+obj.id+"'>"+obj.country_name+"</option>";
                      
                      });
                
                
            }
            $("#country_gigp").html(subskillopt);
            $("#country_gigp").selectpicker('refresh');     
        
       }
       
      });
    }
    $('#country_gigp').on('change',function(evnt){

     var country_gigp_data=$(this).val();
     var typeofcall="skilladd";            
    
     
      if (country_gigp_data!='' && country_gigp_data!=null)
      {
                 //**** call ajax to populate date to skill_sub starts
                 
                 var callingurl=base_url_data+"/"+"getgigstate";
                 var callurlwithdata={_token:csrf_token_data,country_data:country_gigp_data};
                 
                 $.ajax({
                      url:callingurl,
                      data:callurlwithdata,
                      type:'POST',
                      dataType:'JSON',
                      success:function(d){
                           var subskillopt="";
                           
                           if (d!=null)
                           {
                               $.each(d, function(idx, obj)
                                      {
                                     subskillopt+="<option value='"+obj.id+"'>"+obj.state_name+"</option>";
                                     });
                           }                                        
                           
                           $("#select_state_gigp").html(subskillopt);
                           $("#select_state_gigp").selectpicker('refresh');                                        
                           
                      }
                      
                      });
                 
                 //**** call ajax to populate date to skill_sub ends
                 
      }
      else
      {
                           $("#select_state_gigp").html("");
                           $("#select_state_gigp").selectpicker('refresh');
      }
     });
    
    //*********post a gig submit start***********//
    $('#cancel_post_a_gig').click(function(){
     $('#myModal6').modal('hide');
    });
    
    $('#agree_post_a_gig').click(function(){
    if($('#opnaddresssection_gig').css('display') == 'none')
    {
    $("#clickme1").trigger('click');
    }
      post_a_gig_save();
    });
    
    function post_a_gig_save() {
      
    //**********************************07-07-16**************//
    $('#myModal6').animate({ scrollTop: 0 }, 'slow');
    var showtext = 'Checking Your Request';
    var imfpth=base_url_data+"/public/front/otherfiles/progimages/loder.gif"
    showmycustomloader(1,'2000','1000',"Checking Your Request ...",imfpth);
    
    
    $.validator.addMethod("charactertype", function(value, element) 
           {
                return this.optional(element) || /^[a-z]+$/i.test(value);
           },"Please enter valid city name");
      
      //*******************CUSTOM VALIDATION FOR ZIP CODE
      
      $.validator.addMethod("numericfield", function(value, element) 
           {
               //var characterReg = /^[0-9]{7}(?:-[0-9]{4})?$/;
               var characterReg = /[0-9]+/;
               return characterReg.test(value);
           },"Please enter valid booking zip code");
      
      //***********************custom validation for total payment
      $.validator.addMethod("checkingamount",function(value,element)
      {
        var securitymony = $("#security_payment_gig").val().replace("$", "").replace(/,/g, "");
        var totalpayment = $("#total_payment_gig").val().replace("$", "").replace(/,/g, "");
        
        var ff2 =parseFloat(totalpayment)-(parseFloat(cancellation)+parseFloat(securitymony));
      
       var f = parseFloat(ff2).toFixed(2);
        
        if (f > 0) {
          return true;
        }else{
         return false;
        }
      },"Please enter a valid cancellation amount ");
      
      
       $.validator.addMethod("checkingamounttotal",function(value,element)
      {
        var securitymony = $("#security_payment_gig").val().replace("$", "").replace(/,/g, "");
        var totalpayment = $("#total_payment_gig").val().replace("$", "").replace(/,/g, "");
       
         var ff = parseFloat(totalpayment)-parseFloat(securitymony);
         var f = parseFloat(ff).toFixed(2);
       // console.log("Diference is=============="+f);
        if (f > 0) {
          return true;
        }else{
         return false;
        }
      },"Total paymenet must be higher than security deposit");
      
    //******************** CUSTOM FUNCTION ***************ENDS********************
      
    //**********************FORM VALIDATION STARTS HERE ***************************
    
         $("#gig_master_post").validate({
              errorClass: "authError",
              errorElement: 'div',
              //***********************VALIDATION RULES*****************STARTS****************
                   rules: {
                             address1_gig: {
                                  required: true,
                                  minlength: 2,
                             },
                             gig_description: {
                                  required: true,
                                  maxlength: 250,
                             },
                              country_gigp: {
                                  required: true,
                             },
                             select_state_gigp: {
                                  required: true,
                             },
                              city_gig: {
                                  required: true,
                                  charactertype:true,
                             },
                              zip_gig: {
                                  required: true,
                                  numericfield : true,
                             },
                             skillcategory: {
                                  required: true,
                             },
                              skillgenre: {
                                  required: true,
                             },
                              booking_date_gig: {
                                  required: true,
                             },
                             start_time_gig:{
                                  required: true,
                             },
                              end_time_gig:{
                                  required: true,
                             },
                             requestexpireddate_gig:{
                                  required: true,
                             },
                              requestexpiredtime_gig:{
                                  required: true,
                             },
                              security_payment_gig:{
                                  required: true,
                                  maxlength: 20,
                              },
                              
                               total_payment_gig:{
                                  required: true,
                                  maxlength: 20,
                                  checkingamounttotal:true
                             },
                        },
                        //*****************VALIDATION RULES*****************************ENDS***********
                        
                        //*****************VALIDATION ERROR MESSAGES *******************STARTS*********
                messages: {
                                
                              address1_gig: {
                                 required: "Booking location can not be empty",
                                 minlength: "Please enter a valid location"
                             },
                             gig_description: {
                                  required: "Please enter some Gig description",
                                  maxlength: "Gig description must be 250 character",
                             },
                              country_gigp: {
                                 required: "Please select a country",
                                 
                             },
                              select_state_gigp: {
                                 required: "Please select a state",
                                 
                             },
                              city_gig: {
                                 required: "Please enter city name",
                                 
                             },
                              zip_gig: {
                                 required: "Please enter booking zip code",
                                 
                             },
                             skillcategory: {
                                 required: "Please select a category",
                                 range:"Plaese select a valid option",
                             },
                             skillgenre: {
                                 required: "Please select a genere",
                                 range:"Plaese select a valid option",
                             },
                             booking_date_gig: {
                                 required: "Please select a booking date",
                             },
                             start_time_gig: {
                                required: "Please select a start time",
                             },
                             end_time_gig: {
                                required: "Please select a end time",
                             },
                             requestexpireddate_gig: {
                                required: "Please select a expired date",
                             },
                             requestexpiredtime_gig: {
                                required: "Please select a expired time",
                             },
                             security_payment_gig: {
                                required: "Please enter security amount",
                                maxlength: "Too large amount"
                             },
                             total_payment_gig: {
                               required: "Please enter an amount",
                               maxlength: "Too large amount"
                             },
                        },
                        
                        
                        
                        //*****************VALIDATION ERROR MESSAGES *******************ENDS*********

              });
              //************************CHECKING VALIDATION CONDITION**********************STARTS*********
    
    toastr.remove();
    var chkbookingvalidation =  $("#gig_master_post").valid();
    if(chkbookingvalidation === true)
    {
          //**********************************07-07-16**************//
          if (logID!='') {
          var eventType = $('input[name=radio_eventType]:checked').val();
          //alert(userType);
          var address1val = $("#address1_gig").val();
          var address2val = $("#address2_gig").val();
          var countrydata = $("#country_gigp").val();
          var statelistdata = $("#select_state_gigp").val();
          var towndata = $("#city_gig").val();
          var zipdata = $("#zip_gig").val();
          var user_type = userType;
          var bookingcat_subdata = $("#skillcategory").val();
          var bookinggenre_subdata = $("#skillgenre").val();
          
          var security_paymentdata = $("#security_payment_gig").val().replace("$", "").replace(/,/g, "");
          var total_paymentdata = $("#total_payment_gig").val().replace("$", "").replace(/,/g, "");
          
          var booking_datedata = $("#booking_date_gig").val();
          var start_timedata = $("#start_time_gig").val();
          var end_timedata = $("#end_time_gig").val();
          
          var requestexpireddatedata = $("#requestexpireddate_gig").val();
          var requestexpiredtimedata = $("#requestexpiredtime_gig").val();
          var gig_description = $("#gig_description").val();
                    
          var callingurl=base_url_data+"/"+"gigmasterpost";
          var callurlwithdata={_token:csrf_token_data,gig_description:gig_description,loginID:logID,eventType:eventType,address1val:address1val,address2val:address2val,countrydata:countrydata,statelistdata:statelistdata,towndata:towndata,zipdata:zipdata,user_type:user_type,bookingcat_subdata:bookingcat_subdata,bookinggenre_subdata:bookinggenre_subdata,security_paymentdata:security_paymentdata,total_paymentdata:total_paymentdata,booking_datedata:booking_datedata,start_timedata:start_timedata,end_timedata:end_timedata,requestexpireddatedata:requestexpireddatedata,requestexpiredtimedata:requestexpiredtimedata
          };
          
          $.ajax({
               url:callingurl,
               data:callurlwithdata,
               type:'POST',
               dataType:'JSON',
               success:function(res){
              if (res.flagdata == '1') {
                poptriggerfunc(msgtype='success',titledata='',msgdata=res.message,sd=6000,hd=1500,tmo=3000,etmo=4000,poscls='toast-bottom-right');
              }else if(res.flagdata == '01'){
                var error_message=res.message;
                var error_message_data='';
                if (error_message!=null)
                {
                            for (ermsgkey in error_message)
                         {
                              error_message_data+="<p>"+ error_message[ermsgkey]+"</p>";
                         }
                }
                poptriggerfunc(msgtype='error',titledata='',msgdata=error_message_data,sd=1000,hd=1500,tmo=null,etmo=null,poscls='toast-bottom-right');         
                }else{
                  $('#myModal6').modal('hide');
                  poptriggerfunc(msgtype='error',titledata='',msgdata=res.message,sd=6000,hd=1500,tmo=3000,etmo=4000,poscls='toast-bottom-right');
                }                               
                    
               }
               
               });
          
        }else{
          poptriggerfunc(msgtype='error',titledata='',msgdata="Please Login to continue",sd=6000,hd=1500,tmo=3000,etmo=4000,poscls='toast-bottom-right');
        }
    }else{
        var error_message_data="Please complete your post a gig request! ";
        poptriggerfunc(msgtype='error',titledata='',msgdata=error_message_data,sd=6000,hd=1500,tmo=3000,etmo=4000,poscls='toast-bottom-right');
    }
    
    //*********post a gig submit end***********//
    }
      
});
