
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
                                     subskillopt+="<option value='"+obj.id+"'>"+obj.state_3_code+"</option>";
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
    showmycustomloader(1,'2000','1000',"",imfpth);
    
    
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
           },"Please enter valid post code");
      
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

                  $.validator.addMethod("blnkchecklocation", function(value, element) 
                  {
                  // return this.optional(element) || /^[a-z]+$/i.test(value);  /^([a-zA-Z]+\s)*[a-zA-Z]+$/.test(value);
                  return this.optional(element) || (/\S/.test(value));
                  },"Please enter valid location");
                    $.validator.addMethod("blnkchecklocationzip", function(value, element) 
                    {
                    // return this.optional(element) || /^[a-z]+$/i.test(value);  /^([a-zA-Z]+\s)*[a-zA-Z]+$/.test(value);
                    return this.optional(element) || (/\S/.test(value));
                    },"Please enter valid post code");
      
    //******************** CUSTOM FUNCTION ***************ENDS********************
      
    //**********************FORM VALIDATION STARTS HERE ***************************
    
         $("#gig_master_post").validate({
          
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
          
              errorClass: "authError",
              errorElement: 'span',
              //***********************VALIDATION RULES*****************STARTS****************
                   rules: {
                             address1_gig: {
                                  required: true,
                                  minlength: 2,
                                  blnkchecklocation: true,
                             },
                             gig_description: {
                                  required: true,
                                  maxlength: 500,
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
                                  blnkchecklocationzip: true,
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
                             // start_time_gig:{
                             //      required: true,
                             // },
                             // end_time_gig:{
                             //      required: true,
                             // },
                             start_time_hr_gig:{
                                  required: true,
                             },
                             start_time_mnt_gig:{
                                  required: true,
                             },
                              end_time_hr_gig:{
                                  required: true,
                             },
                              end_time_mnt_gig:{
                                  required: true,
                             },
                             requestexpireddate_gig:{
                                  required: true,
                             },
                              requexpire_time_hr_gig:{
                                  required: true,
                             },
                              reqexpire_time_mnt_gig:{
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
                                 required: "Gig location can not be empty",
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
                                 required: "Please enter post code",
                                 
                             },
                             skillcategory: {
                                 required: "Please select a category",
                                 range:"Plaese select a valid option",
                             },
                             skillgenre: {
                                 required: "Please select a genre",
                                 range:"Plaese select a valid option",
                             },
                             booking_date_gig: {
                                 required: "Please select a date",
                             },
                             start_time_hr_gig: {
                                required: "Please select a start time",
                             },
                             start_time_mnt_gig: {
                                required: "Please select a start time",
                             },
                             end_time_hr_gig: {
                                required: "Please select a end time",
                             },
                             end_time_mnt_gig: {
                                required: "Please select a end time",
                             },
                             //  start_time_gig: {
                             //    required: "Please select a start time",
                             // },
                             //  end_time_gig: {
                             //    required: "Please select a end time",
                             // },
                             requestexpireddate_gig: {
                                required: "Please select a expired date",
                             },
                             requexpire_time_hr_gig: {
                                required: "Please select a expired time",
                             },
                              reqexpire_time_mnt_gig: {
                                required: "Please select a expired time",
                             },
                             //  requestexpiredtime_gig: {
                             //    required: "Please select a expired time",
                             // },
                             
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
          var requestexpireddatedata = $("#requestexpireddate_gig").val();


         
         

          var start_timedata_format = $("#ddlViewBy_gig").val();
          var starttimehr_val = $("#start_time_hr_gig").val();
          var starttimemin_val = $("#start_time_mnt_gig").val();

           if(start_timedata_format == 2 && starttimehr_val != 12)
            {
              starttimehr_val = parseInt(starttimehr_val)+12;
            }

            //var start_timedata = $("#start_time_gig").val();
            var start_timedata = starttimehr_val+ ':'+starttimemin_val;

              

              //var end_timedata_format = $("#ddlViewend_gig").val();
              var endtimehr_val = $("#end_time_hr_gig").val();
              var endtimemin_val = $("#end_time_mnt_gig").val();

                                    //  if(end_timedata_format == 2 && endtimehr_val > 12)
                                    // {
                                    //   endtimehr_val = parseInt(endtimehr_val)+12;
                                    // }

              // var end_timedata =  $("#end_time_gig").val();//endtimehr_val+':'+endtimemin_val;
           //   var end_timedata = endtimehr_val+':'+endtimemin_val;

          
          
        

          // var requestexpire_timedata_format = $("#ddlViewrequestexpire_gig").val();
          // var reqexpirehr = $("#requexpire_time_hr_gig").val();
          // var reqexpminval = $("#reqexpire_time_mnt_gig").val();


          // if(requestexpire_timedata_format == 2){
          //   reqexpirehr = parseInt(reqexpirehr)+12;
          // }

          //  var requestexpiredtimedata = $("#requestexpiredtime_gig").val();//reqexpirehr+':'+reqexpminval;

           //*********************** total end time starts here

                                   var endtimedata = booking_datedata+' '+start_timedata;
                                   var endtimeformat = moment(endtimedata,"DD/MM/YYYY hh:mm A").format("DD/MM/YYYY hh:mm A");
                                   var endtimeformataddhrs = moment(endtimeformat,"DD/MM/YYYY h:mm a").add(endtimehr_val,"hours").format("DD/MM/YYYY h:mm a"); //**** hour
                                   var endtimeformataddmnts = moment(endtimeformataddhrs,"DD/MM/YYYY h:mm a").add(endtimemin_val,"minutes").format("DD/MM/YYYY h:mm a"); //**** hour
                                   var endtimedt = moment(endtimeformataddmnts,"DD/MM/YYYY h:mm a").format("DD/MM/YYYY"); //**** hour
                                   var endtimehrs = moment(endtimeformataddmnts,"DD/MM/YYYY h:mm a").format("hh:mm A"); //**** hour
                                   //*********************** total end time ends here

                                  // console.log(" start date "+booking_datedata+" start time "+ start_timedata +" end time "+end_timedata+" endtimeformataddhrs "+endtimeformataddhrs);
                                   // var end_timedata = $("#end_time").val();
                                   console.log(" start time data "+endtimedata);
                                   console.log(" endtimeformataddmnts "+endtimeformataddmnts);
                                   console.log(" endtimedt "+endtimedt);
                                   console.log(" endtimehrs "+endtimehrs);
                                   var end_timedata = endtimehrs;

                                    var requestexpire_timedata_format = $("#ddlViewrequestexpire_gig").val();
                                    var reqexpirehr = $("#requexpire_time_hr_gig").val();
                                    var reqexpminval = $("#reqexpire_time_mnt_gig").val();


                                    if(requestexpire_timedata_format == 1){
                                      reqexpirehr = parseInt(reqexpirehr)+12;
                                    }

                                   var requestexpiredtimedata = reqexpirehr+':'+reqexpminval;//$("#requestexpiredtime").val();



          var gig_description = $("#gig_description").val();
                    
          var callingurl=base_url_data+"/"+"gigmasterpost";
          var callurlwithdata={_token:csrf_token_data,gig_description:gig_description,loginID:logID,eventType:eventType,address1val:address1val,address2val:address2val,countrydata:countrydata,statelistdata:statelistdata,towndata:towndata,zipdata:zipdata,user_type:user_type,bookingcat_subdata:bookingcat_subdata,bookinggenre_subdata:bookinggenre_subdata,security_paymentdata:security_paymentdata,total_paymentdata:total_paymentdata,booking_datedata:booking_datedata,start_timedata:start_timedata,end_timedata:end_timedata,enddatetime:endtimeformataddmnts,endtimedt:endtimedt,requestexpireddatedata:requestexpireddatedata,requestexpiredtimedata:requestexpiredtimedata
          };
          
          $.ajax({
               url:callingurl,
               data:callurlwithdata,
               type:'POST',
               dataType:'JSON',
               success:function(res){
                //console.log(res);
              if (res.flagdata == '1') {
                $('#myModal6').modal('hide');
                poptriggerfunc(msgtype='success',titledata='',msgdata=res.message,sd=6000,hd=1500,tmo=3000,etmo=4000,poscls='toast-top-full-width');
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
                poptriggerfunc(msgtype='error',titledata='',msgdata=error_message_data,sd=1000,hd=1500,tmo=null,etmo=null,poscls='toast-top-full-width');         
                }else{
                 // $('#myModal6').modal('hide');
                  poptriggerfunc(msgtype='error',titledata='',msgdata=res.message,sd=6000,hd=1500,tmo=3000,etmo=4000,poscls='toast-top-full-width');
                }                               
                    
               }
               
               });
          
        }else{
          poptriggerfunc(msgtype='error',titledata='',msgdata="Please Login to continue",sd=6000,hd=1500,tmo=3000,etmo=4000,poscls='toast-top-full-width');
        }
    }else{
        var error_message_data="Please complete your post a gig request! ";
       // poptriggerfunc(msgtype='error',titledata='',msgdata=error_message_data,sd=6000,hd=1500,tmo=3000,etmo=4000,poscls='toast-top-full-width');
    }
    
    //*********post a gig submit end***********//
    }
      
});



//**********this section is for date management begins*********************************
                            

                            //*********initialing of datetimepicker
                                 //  $('#booking_date_gig').datetimepicker({
                                 //  format:'DD/MM/YYYY',
                                 // // useCurrent:true
                                 //  });


                                //    $('#start_time_gig').datetimepicker({
                                //   format:'LT',
                                // //  useCurrent:true
                                //   });

                                 //    $('#requestexpireddate_gig').datetimepicker({
                                 //  format:'DD/MM/YYYY',
                                 // // useCurrent:true
                                 //  });
                                     // $("#end_time_gig").datetimepicker({
                                     //          format:'LT',
                                     //          //Default:false
                                     //      });

                                      // var strtdtaetime =   moment().format('DD/MM/YYYY hh:mm A');
                                      // var strtdtaetime_date = moment(strtdtaetime,"DD/MM/YYYY hh:mm A").add(4,'hours').format("DD/MM/YYYY");
                                      // var strtdtaetime_time = moment(strtdtaetime,"DD/MM/YYYY hh:mm A").add(4,'hours').format("hh:mm A");
                                     
                                      // var strdt = moment().format('DD/MM/YYYY');
                                      // $("#booking_date_gig").data("DateTimePicker").minDate(strtdtaetime_date);
                                      // $("#requestexpireddate_gig").data("DateTimePicker").minDate(strdt);

                            // $("#booking_date_gig").on("dp.change", function (e)
                            // {
                            //  // console.log('hello');
                               
                            //              $('#start_time_gig').val('').datetimepicker('update');
                            //              $('#start_time_gig').data("DateTimePicker").date(null);
                            //               $("#start_time_gig").datetimepicker({
                            //                   format:'LT',
                            //                   //Default:false
                            //               });

                            //             //  $('#end_time_gig').val('').datetimepicker('update');
                            //             //  $('#end_time_gig').data("DateTimePicker").date(null);
                            //               $("#end_time_gig").datetimepicker({
                            //                   format:'LT',
                            //                   //Default:false
                            //               });








                            //           //    $('#requestexpiredtime_gig').val('').datetimepicker('update');
                            //           //    $('#requestexpiredtime_gig').data("DateTimePicker").date(null);
                            //               $("#requestexpiredtime_gig").datetimepicker({
                            //                   format:'LT',
                            //                  // Default:false
                            //               });
                            //           //     $('#requestexpireddate_gig').val('').datetimepicker('update');
                            //           //    $('#requestexpireddate_gig').data("DateTimePicker").date(null);
                            //               $("#requestexpireddate_gig").datetimepicker({
                            //                   format:'DD/MM/YYYY',
                            //                   //Default:false
                            //               });



                               
                            // })



                                      // $("#requestexpireddate_gig").on("dp.change", function (e)
                                      // { 

                                      // var dt = $("#booking_date_gig").val();
                                      // var tm = $("#start_time_gig").val();


                                      // if(dt=='' || tm=='')
                                      // {
                                      // $('#requestexpireddate_gig').datetimepicker({
                                      // format:'DD/MM/YYYY',
                                      // // useCurrent:true
                                      // });
                                      // $('#requestexpireddate_gig').val('');

                                      // }

                                      // strtdtaetime = dt+' '+tm;
                                      // // console.log("strtdtaetime"+strtdtaetime);

                                      // var strtdtaetime_date = moment(strtdtaetime,"DD/MM/YYYY hh:mm A").subtract(4,'hours').format("DD/MM/YYYY");

                                      // $("#requestexpireddate_gig").data("DateTimePicker").maxDate(strtdtaetime_date);



                                      // $('#requestexpiredtime_gig').datetimepicker({
                                      // format:'LT',
                                      // // useCurrent:true
                                      // });


                                      // $('#requestexpiredtime_gig').val('').datetimepicker('update');
                                      // $('#requestexpiredtime_gig').data("DateTimePicker").date(null);
                                      // $("#requestexpiredtime_gig").datetimepicker({
                                      // format:'LT'
                                      // //Default:false
                                      // });






                                      // })








                            //  $("#start_time_gig").on("dp.change", function (e)
                            // {

                            //   //clear_alldatadatetime();

                            //                     // $('#end_time_gig').val('').datetimepicker('update');
                            //                     // $('#end_time_gig').data("DateTimePicker").date(null);
                            //                     // $("#end_time_gig").datetimepicker({
                            //                     // format:'LT',
                            //                     // });

                            //                     // $('#requestexpiredtime_gig').val('').datetimepicker('update');
                            //                     // $('#requestexpiredtime_gig').data("DateTimePicker").date(null);
                            //                     // $("#requestexpiredtime_gig").datetimepicker({
                            //                     // format:'LT',
                            //                     // //  Default:false
                            //                     // });
                            //                     $('#requestexpireddate_gig').val('').datetimepicker('update');
                            //                     // $('#requestexpireddate_gig').data("DateTimePicker").date(null);
                            //                     // $("#requestexpireddate_gig").datetimepicker({
                            //                     // format:'DD/MM/YYYY',
                            //                     // //   Default:false
                            //                     // });


                            //           var strtdtaetime =   moment().format('DD/MM/YYYY hh:mm A');
                            //           var strtdtaetime_date = moment(strtdtaetime,"DD/MM/YYYY hh:mm A").add(4,'hours').format("DD/MM/YYYY");
                            //           var strtdtaetime_time = moment(strtdtaetime,"DD/MM/YYYY hh:mm A").add(4,'hours').format("hh:mm A");



                            //         var crntdate = moment().format('DD/MM/YYYY');
                            //         var crnttime = moment().format('hh:mm A');

                            //         var start_time_gig = $('#start_time_gig').val();
                            //         var r =  moment(start_time_gig,"hh:mm A");

                            //         var l = moment(strtdtaetime_time,"hh:mm A"); //*** crnttime

                            //         var strttime = $("#booking_date_gig").val();


                            //         if(strttime == strtdtaetime_date)
                            //         {
                            //         // console.log('hurray!!!!!!!!!!');
                            //         if(r < l)
                            //         {
                            //         // console.log('ererre!!!!!!!!!!');
                            //         $("#start_time_gig").data("DateTimePicker").date(strtdtaetime_time);
                            //         }
                            //         }

                                                               







                            //                                     $('#end_time_gig').val('').datetimepicker('update');
                            //                                     $('#end_time_gig').data("DateTimePicker").date(null);
                            //                                     $("#end_time_gig").datetimepicker({
                            //                                     format:'LT',
                            //                                  //   Default:false
                            //                                     });
                            //                                  //    $('#requestexpiredtime_gig').val('').datetimepicker('update');
                            //                                  //    $('#requestexpiredtime_gig').data("DateTimePicker").date(null);
                            //                                  //    $("#requestexpiredtime_gig").datetimepicker({
                            //                                  //    format:'LT',
                            //                                  //  //  Default:false
                            //                                  //    });
                            //                                     $('#requestexpireddate_gig').val('').datetimepicker('update');
                            //                                     $('#requestexpireddate_gig').data("DateTimePicker").date(null);
                            //                                     $("#requestexpireddate_gig").datetimepicker({
                            //                                     format:'DD/MM/YYYY',
                            //                                  //   Default:false
                            //                                     });
                               
                            // })


                            //   $("#end_time_gig").on("dp.change", function (e)
                            // {
                            //         var crntdate = moment().format('DD/MM/YYYY');
                            //         var crnttime = moment().format('hh:mm A');

                            //         var end_time_gig = $('#end_time_gig').val();
                            //         var r =  moment(end_time_gig,"hh:mm A");


                            //         var l = moment(crnttime,"hh:mm A");

                            //         var strttime = $("#booking_date_gig").val();


                            //         if(strttime == crntdate)
                            //         {
                            //        // console.log('hurray!!!!!!!!!!');
                            //         if(r < l)
                            //         {
                            //       //  console.log('ererre!!!!!!!!!!');
                            //         $("#end_time_gig").data("DateTimePicker").date(crnttime);
                            //         }
                            //         }


                            //         var strt_time_gig = $('#start_time_gig').val();
                            //         var p =  moment(strt_time_gig,"hh:mm A");

                            //         if(r < p )
                            //         {

                            //         $("#end_time_gig").data("DateTimePicker").date(strt_time_gig);
                            //         }
                             
                               
                            // })


                            //   $("#requestexpiredtime_gig").on("dp.change", function (e)
                            // {

                            //   // $("#requestexpiredtime_gig").data("DateTimePicker").minDate("11:59 PM");
                            //         var crntdate = moment().format('DD/MM/YYYY');
                            //         var crnttime = moment().format('hh:mm A');

                            //         var end_time_gig = $('#requestexpiredtime_gig').val();
                            //         var r =  moment(end_time_gig,"hh:mm A");


                            //         var l = moment(crnttime,"hh:mm A");

                            //         var strttime = $("#requestexpireddate_gig").val();


                            //         if(strttime == crntdate)
                            //         {
                            //             if(r < l)
                            //             {
                            //              // alert('hello');
                            //              $("#requestexpiredtime_gig").data("DateTimePicker").date(crnttime);
                            //             }

                            //         }


                            //         var bookingreqdate = $("#booking_date_gig").val();
                            //        // // console.log("bookingreqdate"+bookingreqdate);
                            //         var strt_time_gig = $('#start_time_gig').val();
                            //        //  //console.log("strt_time_gig"+strt_time_gig);

                            //         var ttmoment = bookingreqdate+' '+strt_time_gig;

                            //        // console.log("ttmoment"+ttmoment);

                            //         var fourhrmoment_before_date = moment(ttmoment,"DD/MM/YYYY hh:mm A").subtract(4,'hours').format("DD/MM/YYYY");
                            //         var fourhrmoment_before_time = moment(ttmoment,"DD/MM/YYYY hh:mm A").subtract(4,'hours').format("hh:mm A");

                            //        //  console.log("fourhrmoment_before_date"+fourhrmoment_before_date+"fourhrmoment_before_time"+fourhrmoment_before_time);
                            //          fourhour_span = moment(fourhrmoment_before_time,"hh:mm A");

                            //         if(fourhrmoment_before_date == strttime)
                            //         {
                            //           //console.log('date matched'+fourhour_span);
                            //           if(r > fourhour_span)
                            //           {
                            //            // console.log("in this section");
                            //             $("#requestexpiredtime_gig").data("DateTimePicker").date(fourhrmoment_before_time);
                            //           }
                            //           //else
                            //           // {
                            //           //   $("#requestexpiredtime_gig").data("DateTimePicker").date(end_time_gig);
                            //           // }
                            //         }

                                   
                             
                               
                            // })


// function clear_alldatadatetime()
// {
//     // $('#end_time_gig').val('').datetimepicker('update');
//                                                 $('#end_time_gig').data("DateTimePicker").date(null);
//                                                 $("#end_time_gig").datetimepicker({
//                                                 format:'LT',
//                                                 });

//                                                 $('#requestexpiredtime_gig').val('');
//                                                 // $('#requestexpiredtime_gig').data("DateTimePicker").date(null);
//                                                 // $("#requestexpiredtime_gig").datetimepicker({
//                                                 // format:'LT',
                                                
//                                                 // });
//                                                 $('#requestexpireddate_gig').val('');
//                                                 // $('#requestexpireddate_gig').data("DateTimePicker").date(null);
//                                                 // $("#requestexpireddate_gig").datetimepicker({
//                                                 // format:'DD/MM/YYYY',
//                                                 // //   Default:false
//                                                 // });

// }





  //*********initialing of datetimepicker
                                 //  $('#booking_date_gig').datetimepicker({
                                 //  format:'DD/MM/YYYY',
                                 // // useCurrent:true
                                 //  });


                                //    $('#start_time_gig').datetimepicker({
                                //   format:'LT',
                                // //  useCurrent:true
                                //   });

                                 //    $('#requestexpireddate_gig').datetimepicker({
                                 //  format:'DD/MM/YYYY',
                                 // // useCurrent:true
                                 //  });
                                     // $("#end_time_gig").datetimepicker({
                                     //          format:'LT',
                                     //          //Default:false
                                     //      });

                                      // var strtdtaetime =   moment().format('DD/MM/YYYY hh:mm A');
                                      // var strtdtaetime_date = moment(strtdtaetime,"DD/MM/YYYY hh:mm A").add(4,'hours').format("DD/MM/YYYY");
                                      // var strtdtaetime_time = moment(strtdtaetime,"DD/MM/YYYY hh:mm A").add(4,'hours').format("hh:mm A");
                                     
                                      // var strdt = moment().format('DD/MM/YYYY');
                                      // $("#booking_date_gig").data("DateTimePicker").minDate(strtdtaetime_date);
                                      // $("#requestexpireddate_gig").data("DateTimePicker").minDate(strdt);

                            // $("#booking_date_gig").on("dp.change", function (e)
                            // {
                            //  // console.log('hello');
                               
                            //              $('#start_time_gig').val('').datetimepicker('update');
                            //              $('#start_time_gig').data("DateTimePicker").date(null);
                            //               $("#start_time_gig").datetimepicker({
                            //                   format:'LT',
                            //                   //Default:false
                            //               });

                            //             //  $('#end_time_gig').val('').datetimepicker('update');
                            //             //  $('#end_time_gig').data("DateTimePicker").date(null);
                            //               $("#end_time_gig").datetimepicker({
                            //                   format:'LT',
                            //                   //Default:false
                            //               });








                            //           //    $('#requestexpiredtime_gig').val('').datetimepicker('update');
                            //           //    $('#requestexpiredtime_gig').data("DateTimePicker").date(null);
                            //               $("#requestexpiredtime_gig").datetimepicker({
                            //                   format:'LT',
                            //                  // Default:false
                            //               });
                            //           //     $('#requestexpireddate_gig').val('').datetimepicker('update');
                            //           //    $('#requestexpireddate_gig').data("DateTimePicker").date(null);
                            //               $("#requestexpireddate_gig").datetimepicker({
                            //                   format:'DD/MM/YYYY',
                            //                   //Default:false
                            //               });

                            //                 $('#start_time_gig').prop("disabled", false);  
                            //                 $('#end_time_gig').prop("disabled", false);  
                            //                 $('#requestexpiredtime_gig').prop("disabled", false);  
                            //                 $('#requestexpireddate_gig').prop("disabled", false);  
                               
                            // })



                                      // $("#requestexpireddate_gig").on("dp.change", function (e)
                                      // { 

                                      // var dt = $("#booking_date_gig").val();
                                      // var tm = $("#start_time_gig").val();


                                      // if(dt=='' || tm=='')
                                      // {
                                      // $('#requestexpireddate_gig').datetimepicker({
                                      // format:'DD/MM/YYYY',
                                      // // useCurrent:true
                                      // });
                                      // $('#requestexpireddate_gig').val('');

                                      // }

                                      // strtdtaetime = dt+' '+tm;
                                      // // console.log("strtdtaetime"+strtdtaetime);

                                      // var strtdtaetime_date = moment(strtdtaetime,"DD/MM/YYYY hh:mm A").subtract(4,'hours').format("DD/MM/YYYY");

                                      // $("#requestexpireddate_gig").data("DateTimePicker").maxDate(strtdtaetime_date);



                                      // $('#requestexpiredtime_gig').datetimepicker({
                                      // format:'LT',
                                      // // useCurrent:true
                                      // });


                                      // $('#requestexpiredtime_gig').val('').datetimepicker('update');
                                      // $('#requestexpiredtime_gig').data("DateTimePicker").date(null);
                                      // $("#requestexpiredtime_gig").datetimepicker({
                                      // format:'LT'
                                      // //Default:false
                                      // });






                                      // })








                            //  $("#start_time_gig").on("dp.change", function (e)
                            // {

                            //   //clear_alldatadatetime();

                            //                     // $('#end_time_gig').val('').datetimepicker('update');
                            //                     // $('#end_time_gig').data("DateTimePicker").date(null);
                            //                     // $("#end_time_gig").datetimepicker({
                            //                     // format:'LT',
                            //                     // });

                            //                     // $('#requestexpiredtime_gig').val('').datetimepicker('update');
                            //                     // $('#requestexpiredtime_gig').data("DateTimePicker").date(null);
                            //                     // $("#requestexpiredtime_gig").datetimepicker({
                            //                     // format:'LT',
                            //                     // //  Default:false
                            //                     // });
                            //                     $('#requestexpireddate_gig').val('').datetimepicker('update');
                            //                     // $('#requestexpireddate_gig').data("DateTimePicker").date(null);
                            //                     // $("#requestexpireddate_gig").datetimepicker({
                            //                     // format:'DD/MM/YYYY',
                            //                     // //   Default:false
                            //                     // });


                            //           var strtdtaetime =   moment().format('DD/MM/YYYY hh:mm A');
                            //           var strtdtaetime_date = moment(strtdtaetime,"DD/MM/YYYY hh:mm A").add(4,'hours').format("DD/MM/YYYY");
                            //           var strtdtaetime_time = moment(strtdtaetime,"DD/MM/YYYY hh:mm A").add(4,'hours').format("hh:mm A");



                            //         var crntdate = moment().format('DD/MM/YYYY');
                            //         var crnttime = moment().format('hh:mm A');

                            //         var start_time_gig = $('#start_time_gig').val();
                            //         var r =  moment(start_time_gig,"hh:mm A");

                            //         var l = moment(strtdtaetime_time,"hh:mm A"); //*** crnttime

                            //         var strttime = $("#booking_date_gig").val();


                            //         if(strttime == strtdtaetime_date)
                            //         {
                            //         // console.log('hurray!!!!!!!!!!');
                            //         if(r < l)
                            //         {
                            //         // console.log('ererre!!!!!!!!!!');
                            //         $("#start_time_gig").data("DateTimePicker").date(strtdtaetime_time);
                            //         }
                            //         }

                                                               







                            //                                     $('#end_time_gig').val('').datetimepicker('update');
                            //                                     $('#end_time_gig').data("DateTimePicker").date(null);
                            //                                     $("#end_time_gig").datetimepicker({
                            //                                     format:'LT',
                            //                                  //   Default:false
                            //                                     });
                            //                                  //    $('#requestexpiredtime_gig').val('').datetimepicker('update');
                            //                                  //    $('#requestexpiredtime_gig').data("DateTimePicker").date(null);
                            //                                  //    $("#requestexpiredtime_gig").datetimepicker({
                            //                                  //    format:'LT',
                            //                                  //  //  Default:false
                            //                                  //    });
                            //                                     $('#requestexpireddate_gig').val('').datetimepicker('update');
                            //                                     $('#requestexpireddate_gig').data("DateTimePicker").date(null);
                            //                                     $("#requestexpireddate_gig").datetimepicker({
                            //                                     format:'DD/MM/YYYY',
                            //                                  //   Default:false
                            //                                     });
                               
                            // })


                            //   $("#end_time_gig").on("dp.change", function (e)
                            // {
                            //         var crntdate = moment().format('DD/MM/YYYY');
                            //         var crnttime = moment().format('hh:mm A');

                            //         var end_time_gig = $('#end_time_gig').val();
                            //         var r =  moment(end_time_gig,"hh:mm A");


                            //         var l = moment(crnttime,"hh:mm A");

                            //         var strttime = $("#booking_date_gig").val();


                            //         if(strttime == crntdate)
                            //         {
                            //        // console.log('hurray!!!!!!!!!!');
                            //         if(r < l)
                            //         {
                            //       //  console.log('ererre!!!!!!!!!!');
                            //         $("#end_time_gig").data("DateTimePicker").date(crnttime);
                            //         }
                            //         }


                            //         var strt_time_gig = $('#start_time_gig').val();
                            //         var p =  moment(strt_time_gig,"hh:mm A");

                            //         if(r < p )
                            //         {

                            //         $("#end_time_gig").data("DateTimePicker").date(strt_time_gig);
                            //         }
                             
                               
                            // })


                            //   $("#requestexpiredtime_gig").on("dp.change", function (e)
                            // {

                            //   // $("#requestexpiredtime_gig").data("DateTimePicker").minDate("11:59 PM");
                            //         var crntdate = moment().format('DD/MM/YYYY');
                            //         var crnttime = moment().format('hh:mm A');

                            //         var end_time_gig = $('#requestexpiredtime_gig').val();
                            //         var r =  moment(end_time_gig,"hh:mm A");


                            //         var l = moment(crnttime,"hh:mm A");

                            //         var strttime = $("#requestexpireddate_gig").val();


                            //         if(strttime == crntdate)
                            //         {
                            //             if(r < l)
                            //             {
                            //              // alert('hello');
                            //              $("#requestexpiredtime_gig").data("DateTimePicker").date(crnttime);
                            //             }

                            //         }


                            //         var bookingreqdate = $("#booking_date_gig").val();
                            //        // // console.log("bookingreqdate"+bookingreqdate);
                            //         var strt_time_gig = $('#start_time_gig').val();
                            //        //  //console.log("strt_time_gig"+strt_time_gig);

                            //         var ttmoment = bookingreqdate+' '+strt_time_gig;

                            //        // console.log("ttmoment"+ttmoment);

                            //         var fourhrmoment_before_date = moment(ttmoment,"DD/MM/YYYY hh:mm A").subtract(4,'hours').format("DD/MM/YYYY");
                            //         var fourhrmoment_before_time = moment(ttmoment,"DD/MM/YYYY hh:mm A").subtract(4,'hours').format("hh:mm A");

                            //        //  console.log("fourhrmoment_before_date"+fourhrmoment_before_date+"fourhrmoment_before_time"+fourhrmoment_before_time);
                            //          fourhour_span = moment(fourhrmoment_before_time,"hh:mm A");

                            //         if(fourhrmoment_before_date == strttime)
                            //         {
                            //           //console.log('date matched'+fourhour_span);
                            //           if(r > fourhour_span)
                            //           {
                            //            // console.log("in this section");
                            //             $("#requestexpiredtime_gig").data("DateTimePicker").date(fourhrmoment_before_time);
                            //           }
                            //           //else
                            //           // {
                            //           //   $("#requestexpiredtime_gig").data("DateTimePicker").date(end_time_gig);
                            //           // }
                            //         }

                                   
                             
                               
                            // })


function clear_alldatadatetime()
{
    // $('#end_time_gig').val('').datetimepicker('update');
                                                $('#end_time_gig').data("DateTimePicker").date(null);
                                                $("#end_time_gig").datetimepicker({
                                                format:'LT',
                                                });

                                                $('#requestexpiredtime_gig').val('');
                                                // $('#requestexpiredtime_gig').data("DateTimePicker").date(null);
                                                // $("#requestexpiredtime_gig").datetimepicker({
                                                // format:'LT',
                                                
                                                // });
                                                $('#requestexpireddate_gig').val('');
                                                // $('#requestexpireddate_gig').data("DateTimePicker").date(null);
                                                // $("#requestexpireddate_gig").datetimepicker({
                                                // format:'DD/MM/YYYY',
                                                // //   Default:false
                                                // });

}