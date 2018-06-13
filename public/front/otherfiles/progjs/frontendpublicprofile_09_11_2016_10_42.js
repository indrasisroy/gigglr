$(document).ready(function()
   	{
       if(showreviewornot == 0)
              {
                $("#review_section").addClass("mydisplaynone");  
              }else
              {
                $("#review_section").removeClass("mydisplaynone");
              }
     //flgBkGrp
     //$('.openbkgrpcls').click(function(){
     //     
     //     if (flgBkGrp=='1') {
     //       
     //     }
     //     
     //     });
     if (flgBkGrp=='1') {
            $('.openbkgrpcls').trigger('click');
          }
          
           $("#totalpayimg_div").on("click", (function () {
		 var valuetotalpayimg = $(this).data('totalpayimgflag');
		 if (valuetotalpayimg == '0') {
		   $('#totalpayimg_div').data('totalpayimgflag',1);
		   $("#totalpayimg_div").html(lockImg);
           totalpay_lock_id = logID;
           
		 }else{
		   $('#totalpayimg_div').data('totalpayimgflag',0);
		   $("#totalpayimg_div").html(unlockImg);
           totalpay_lock_id = '';
		 }
	  }));
   
      $("#bookingcanimg_div").on("click", (function () {
		 var valuebookingcanimg = $(this).data('bookingcanimgflag');
		 if (valuebookingcanimg == '0') {
		   $('#bookingcanimg_div').data('bookingcanimgflag',1);
		   $("#bookingcanimg_div").html(lockImg);
           booking_lock_id = logID;
		 }else{
		   $('#bookingcanimg_div').data('bookingcanimgflag',0);
		   $("#bookingcanimg_div").html(unlockImg);
           booking_lock_id = '';
		 }
	  }));
	  
      $("#securityimg_div").on("click", (function () {
		 var valuesecurityimg = $(this).data('securityimgflag');
		 if (valuesecurityimg == '0') {
		   $('#securityimg_div').data('securityimgflag',1);
		   $("#securityimg_div").html(lockImg);
           security_lock_id = logID;
		 }else{
		   $('#securityimg_div').data('securityimgflag',0);
		   $("#securityimg_div").html(unlockImg);
           security_lock_id = '';
		 }
	  }));
       
    });
          if (submitBtbFlag == '0') {
           $('#continue').attr('disabled','disabled');
          }
                         //********************FORM SUBMIT VALIDATION************
                              
                              function callforbooking(posturl,csrf)
                              {
          
                              $('#myModal5').animate({ scrollTop: 0 }, 'slow');
                              var showtext = 'Checking Your Request';
                              var imfpth=base_url_data+"/public/front/otherfiles/progimages/loder.gif"
                              showmycustomloader(1,'8000','1000',"",imfpth);
                              
                              
                              $.validator.addMethod("charactertype", function(value, element) 
                                     {
                                          // return this.optional(element) || /^[a-z]+$/i.test(value);  /^([a-zA-Z]+\s)*[a-zA-Z]+$/.test(value);
                                           return this.optional(element) || /^([a-zA-Z]+\s)*[a-zA-Z]+$/.test(value);
                                     },"Please enter valid city name");
                                
                                //*******************CUSTOM VALIDATION FOR ZIP CODE
                                
                                $.validator.addMethod("numericfield", function(value, element) 
                                     {
                                        // var characterReg = /^[0-9]{5}(?:-[0-9]{4})?$/;
                                          var characterReg = /[0-9]+/;
                                         return characterReg.test(value);
                                     },"Please enter valid booking post code");
                                
                                //***********************custom validation for total payment
                                $.validator.addMethod("checkingamount",function(value,element)
                                {
                                  var securitymony = $("#security_payment").val().replace("$", "").replace(/,/g, "");
                                  var cancellation = $("#cancellation_payment").val().replace("$", "").replace(/,/g, "");
                                  var totalpayment = $("#total_payment").val().replace("$", "").replace(/,/g, "");
                                  
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
                                  var securitymony = $("#security_payment").val().replace("$", "").replace(/,/g, "");
                                  var cancellation = $("#cancellation_payment").val().replace("$", "").replace(/,/g, "");
                                  var totalpayment = $("#total_payment").val().replace("$", "").replace(/,/g, "");
                                 
                                   var ff = parseFloat(totalpayment)-parseFloat(securitymony);
                                   var f = parseFloat(ff).toFixed(2);
                                 // console.log("Diference is=============="+f);
                                  if (f > 0) {
                                    return true;
                                  }else{
                                   return false;
                                  }
                                },"Total payment must be higher than security deposit");

                                    $.validator.addMethod("checksametime",function(value,element)
                                {
                                  var end_time = $("#end_time").val();
                                  var start_time = $("#start_time").val();
                                  var booking_date = $("#booking_date").val();

                                  var chk1 = booking_date+' '+start_time;
                                  var chk2 = booking_date+' '+end_time;
                                 
                                   // var ff = parseFloat(totalpayment)-parseFloat(securitymony);
                                   // var f = parseFloat(ff).toFixed(2);
                                 // console.log("Diference is=============="+f);
                                  if (chk1 != chk2) {
                                    return true;
                                  }else{
                                   return false;
                                  }
                                },"Ending time should be greater than starting time");

                                    //*********custom function for blank checking starts
                                     $.validator.addMethod("blnkchecklocation", function(value, element) 
                                     {
                                          // return this.optional(element) || /^[a-z]+$/i.test(value);  /^([a-zA-Z]+\s)*[a-zA-Z]+$/.test(value);
                                           return this.optional(element) || (/\S/.test(value));
                                      },"Please enter valid location");

                                      $.validator.addMethod("blnkchecklocationzip", function(value, element) 
                                     {
                                          // return this.optional(element) || /^[a-z]+$/i.test(value);  /^([a-zA-Z]+\s)*[a-zA-Z]+$/.test(value);
                                           return this.optional(element) || (/\S/.test(value));
                                      },"Please enter valid Post code");
                                    //*********custom function for blank checking ends
                                  
                                  //******************* client-side CUSTOM VALIDATION FOR numeric checking starts
                                
                $.validator.addMethod("numericfieldamount", function(value, element) 
                {
                                         var characterReg = /^([0-9]*){0,}(\.\d{1,2})?$/; ///^[1-9][0-9]+(\.\d{1,2})?$/ ;
                                         return characterReg.test(value);
                },"Please enter proper numeric value");
 
//******************* client-side CUSTOM VALIDATION FOR numeric checking ends

                                //******************** CUSTOM FUNCTION ***************ENDS********************
                                
                              //**********************FORM VALIDATION STARTS HERE ***************************
                              
                                   $("#bookingform").validate({
                                        errorClass: "authError",
                                        errorElement: 'span',
                                        //***********************VALIDATION RULES*****************STARTS****************
                                             rules: {
                                                       booking_location: {
                                                            required: true,
                                                            minlength: 2,
                                                            blnkchecklocation: true,
                                                       },
                                                        countryId: {
                                                            required: true,
                                                       },
                                                       statelist: {
                                                            required: true,
                                                       },
                                                        town: {
                                                            required: true,
                                                            charactertype:true,
                                                            //blnkchecklocation: true,
                                                       },
                                                        zip: {
                                                            required: true,
                                                            numericfield : true,
                                                             // number: true,
                                                            blnkchecklocationzip: true,

                                                       },
                                                       bookingcat_sub: {
                                                            required: true,
                                                       },
                                                        bookinggenre_sub: {
                                                            required: true,
                                                       },
                                                        booking_date: {
                                                            required: true,
                                                       },
                                                       // start_time:{
                                                       //      required: true,
                                                       // },
                                                       //  end_time:{
                                                       //      required: true,
                                                       //      checksametime:true,
                                                       // },
                                                        security_payment:{
                                                            required: true,
                                                            numericfieldamount: true,
                                                            maxlength: 20,
                                                        },
                                                        
                                                         total_payment:{
                                                            required: true,
                                                            numericfieldamount: true,
                                                            maxlength: 20,
                                                            checkingamounttotal:true
                                                       },
                                                         cancellation_payment:{
                                                            required: true,
                                                            numericfieldamount: true,
                                                            maxlength: 20,
                                                            checkingamount :true,
                                                       },
                                                         gig_description:{
                                                            required: true,
                                                            maxlength: 250,
                                                       },
                                                  },
                                                  //*****************VALIDATION RULES*****************************ENDS***********
                                                  
                                                  //*****************VALIDATION ERROR MESSAGES *******************STARTS*********
                                          messages: {
                                                          
                                                       booking_location: {
                                                           required: "Booking location can not be empty",
                                                           minlength: "Please enter a valid location"
                                                       },
                                                       countryId: {
                                                           required: "Please select a country",
                                                           
                                                       },
                                                        statelist: {
                                                           required: "Please select a state",
                                                           
                                                       },
                                                        town: {
                                                           required: "Please enter city name",
                                                           
                                                       },
                                                        zip: {
                                                           required: "Please enter booking post code",
                                                           
                                                       },
                                                       bookingcat_sub: {
                                                           required: "Please select a category",
                                                           range:"Plaese select a valid option",
                                                       },
                                                       bookinggenre_sub: {
                                                           required: "Please select a genere",
                                                           range:"Plaese select a valid option",
                                                       },
                                                       booking_date: {
                                                           required: "Please select a booking date",
                                                       },
                                                       // start_time_hr: {
                                                       //    required: "Please select a start time",
                                                       // },
                                                       // end_time_hr: {
                                                       //    required: "Please select a end time",
                                                       // },
                                                       security_payment: {
                                                          required: "Please enter security amount",
                                                          maxlength: "Too large amount"
                                                       },
                                                       total_payment: {
                                                         required: "Please enter an amount",
                                                         maxlength: "Too large amount"
                                                       },
                                                       cancellation_payment: {
                                                         required: "Please enter an amount",
                                                         maxlength: "Too large amount"
                                                       },
                                                       gig_description: {
                                                         required: "Please enter Gig description",
                                                         maxlength : "Gig description not more than 250",
                                                       },

                                                  },
                                                  
                                                  
                                                  
                                                  //*****************VALIDATION ERROR MESSAGES *******************ENDS*********
                
                                        });
                                        //************************CHECKING VALIDATION CONDITION**********************STARTS*********
                              
     
                              var chkbookingvalidation =  $("#bookingform").valid();
                              if(chkbookingvalidation === true)
                              {
                                  //************ Retriving value starts here
                                   var address1val = $("#booking_location").val().trim();
                                   var address2val = $("#booking_location_second").val().trim();
                                   var countrydata = $("#country_id").val();
                                   var statelistdata = $("#statelist").val();
                                   var towndata = $("#town").val().trim();
                                   var zipdata = $("#zip").val().trim();
                                   var bookingcat_subdata = $("#bookingcat_sub").val();
                                   var bookinggenre_subdata = $("#bookinggenre_sub").val();
                                   
                                    //var securitymony = $("#security_payment").val().replace("$", "").replace(/,/g, "");
                                   var security_paymentdata = $("#security_payment").val().replace("$", "").replace(/,/g, "");
                                   var total_paymentdata = $("#total_payment").val().replace("$", "").replace(/,/g, "");
                                   var cancellation_paymentdata = $("#cancellation_payment").val().replace("$", "").replace(/,/g, "");
                                   
                                   var gig_description =  $("#gig_description").val();
                                   var booking_datedata = $("#booking_date").val();
                                   var start_timedata = $("#start_time_hr").val()+ ':'+$("#start_time_mnt").val();
                                   var end_timedata = $("#end_time_hr").val()+ ':'+$("#end_time_mnt").val();
                                   var requestexpiredtimedata = $("#requestexpiredtime").val();

                                   var requestexpireddatedata = $("#booking_date").val();

                                   var artistID = $("#artistID").val();
                                   console.log("Booking Token========>"+csrf+"start_timedata"+start_timedata+"end_timedata"+end_timedata);
                                    var type_entry_insert = '';
                                   //alert(event_type_entry);
                                  // alert(event_type_entry);
                                   if (event_type_entry =='3') {
                                    type_entry_insert = $('input[name=radio_entry_type]:checked').val(); //"input[name=radio_entry_type]:checked"
                                   }else{
                                    type_entry_insert = event_type_entry;
                                   }
                                   //************ Retriving value ends here
                                   //********** trim value starts here
                                   // address1val = trim(address1val);
                                   // address2val = trim(address2val);
                                   // towndata = trim(towndata);
                                   // zipdata =trim(zipdata);

                                   //********** trim value ends here
                                   //************** Ajax form submission starts here
                                    var bookingformdata = {_token:csrf,type_entry:type_entry_insert,address1val:address1val,address2val:address2val,countrydata:countrydata,statelistdata:statelistdata,towndata:towndata,zipdata:zipdata,bookingcat_subdata:bookingcat_subdata,bookinggenre_subdata:bookinggenre_subdata,security_paymentdata:security_paymentdata,total_paymentdata:total_paymentdata,cancellation_paymentdata:cancellation_paymentdata,booking_datedata:booking_datedata,start_timedata:start_timedata,end_timedata:end_timedata,requestexpireddatedata:requestexpireddatedata,requestexpiredtimedata:requestexpiredtimedata,artistID:artistID,security_lock_id:security_lock_id,booking_lock_id:booking_lock_id,totalpay_lock_id:totalpay_lock_id,gig_description:gig_description};
                                        var bookingurldata=base_url_data+"/"+posturl;
                                        // console.log("Booking Form url data========>"+bookingurldata);die;
                                        jQuery.ajax({
										type: "POST",
										data:bookingformdata,
										url: bookingurldata,
										dataType:"json",
                                             success: function(d)
                                             {
                                                  // alert(d.flag_id);
                                                  // console.log("Booking response==========>"+d);

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
                                              poptriggerfunc(msgtype='error',titledata='',msgdata=error_message_data,sd=6000,hd=1500,tmo=3000,etmo=4000,poscls='toast-top-full-width');         

                                            }
                                            else if(d.flag_id==2 && d.error_message!='')
                                            {
                                               poptriggerfunc(msgtype='error',titledata='',msgdata=d.error_message,sd=6000,hd=1500,tmo=3000,etmo=4000,poscls='toast-top-full-width');         
                                            }
                                            else
                                            {

                                              var imfpth=base_url_data+"/public/front/otherfiles/progimages/loder.gif"
                                              showmycustomloader(1,'4000','2000',"",imfpth);
                                              $("#cancelbtn").click(); //***modal remove
                                            //  var success_message_data="Thank you for your booking request! ";
                                              poptriggerfunc(msgtype='success',titledata='',msgdata=d.success_message,sd=1000,hd=1500,tmo=1000,etmo=1000,poscls='toast-top-full-width');
                                            }
                                            }
                                        });
                                   //************** Ajax form submission ends here
                                  
                                   //showmycustomloader(0,'','',"Please wait ....",imfpth);
                                   // var imfpth=base_url_data+"/public/front/otherfiles/progimages/loder.gif"
                                   // showmycustomloader(1,'4000','2000',"Processing. Please wait ....",imfpth);
                                   // $("#cancelbtn").click(); //***modal remove
                                   // var success_message_data="Thank you for your booking request! ";
                                  // poptriggerfunc(msgtype='success',titledata='',msgdata=success_message_data,sd=6000,hd=1500,tmo=3000,etmo=4000,poscls='toast-top-full-width');
                                                     //****************************LOADER ENDS HERE****************************************
                                 
                                 //return 2;
                              }
                              else
                              {
                                   var error_message_data="Please complete your booking request! ";
                                   //poptriggerfunc(msgtype='error',titledata='',msgdata=error_message_data,sd=6000,hd=1500,tmo=3000,etmo=4000,poscls='toast-top-full-width');
                                 //return 1;
                              }
                            //************************CHECKING VALIDATION CONDITION**********************ENDS*********
   
                              }
               //**************FOR COUNTRY STATE AJAX**************************
               function getStateforCountry(requeststateUrl,ProfilecountryId,csrf)
               {
                         var countrydata = {_token:csrf,countryid:ProfilecountryId};
                         var urldata=base_url_data+"/"+requeststateUrl;
                         jQuery.ajax({
										type: "POST",
										data:countrydata,
										url: urldata,
										dataType:"json",
										success: function(res)
										{
                                             var tt=JSON.stringify( );
                                             var skiloptstr="";
                                             if(res.length>0)
                                             {
                                                    //   skiloptstr+="<option value=''>State</option>";
                                                       jQuery.each(res,function(ind, vaobj){
                                                       skiloptstr+="<option value="+vaobj.id+">"+vaobj.state_3_code+"</option>";
                                                   });
                                                         
                                             }else
                                             {
                                                  //skiloptstr+="<option value=''>State</option>";
                                                  skiloptstr+="<option >No state is available</option>";
                                             }
                                   				//alert(skiloptstr);
                                                  jQuery("#statelist").html(skiloptstr);
                                                    $("#statelist").selectpicker('refresh');
                                        }
                         });
                         
               }
               //**************FOR COUNTRY STATE AJAX ENDS**************************
 //********this section is for slider 
//***starting

               function showhideprevnextimgslider(totalItems,curritemnum)
             {
                     if (totalItems==1)
                  {
                         //*** hide both prev and next
                               jQuery('.owl-prev, .owl-next').hide();
                  }
                  else if (totalItems>1)
                  {
                         if(curritemnum ==1 )
                        {
                               //*** hide prev  and show next
                                   jQuery('.owl-prev').hide();
                                   jQuery('.owl-next').show();
                        }
                       else if(curritemnum < totalItems )
                        {
                               //*** show both prev and next
                               jQuery('.owl-prev, .owl-next').show();
                        }
                        else if (curritemnum == totalItems)
                        {
                           //*** hide  next and show prev
                           jQuery('.owl-next').hide();
                            jQuery('.owl-prev').show();
                        }
                  }
               
             }
             
 //***ending              
               
               
               //*******************FOR CATEGORY GENERE AJAX************************
               
               function getGenereforCategory(requeststateUrl,Catagory_Id,ArtistusrID,csrf)
               {
                         var categorydata = {_token:csrf,categoryID:Catagory_Id,artistusrid:ArtistusrID};
                         var urldata=base_url_data+"/"+requeststateUrl;
                        // console.log(urldata);
                         jQuery.ajax({
										type: "POST",
										data:categorydata,
										url: urldata,
										dataType:"json",
										success: function(res)
										{
                                             var tt=JSON.stringify();
                                             var skiloptstr="";
                                             if(res.length>0)
                                             {
                                                   //    skiloptstr+="<option value=''>Genere For Request</option>";
                                                       jQuery.each(res,function(ind, vaobj){
                                                       skiloptstr+="<option value="+vaobj.id+">"+vaobj.name+"</option>";
                                                   });
                                                         
                                             }else
                                             {
                                                 // skiloptstr+="<option value=''>Genere For Request</option>";
                                                  skiloptstr+="<option >No Genere is available</option>";
                                             }
                                                         //alert(skiloptstr);
                                                       jQuery("#bookinggenre_sub").html(skiloptstr);
                                                       $("#bookinggenre_sub").selectpicker('refresh');
                                        }
                         });
                         
               }
                              //*******************FOR CATEGORY GENERE AJAX ENDS****************************
                              
               //**************calendar js starts here************************///////////////////////////*********
               
               
               
               
               
               
               
               
               
               //****************Booking date change function starts here
			 //   $("#booking_date").on("dp.change", function(e)
   	// 			{
				//   var ttttttt = $("#booking_date").val();
				//   console.log("Booking date is ===============>"+ttttttt);
				
				// 	 $("#requestexpireddate").val('');
				// 	 $('#requestexpireddate').data("DateTimePicker").date(null);
				// 	 $('#requestexpireddate').val('').datetimepicker('update');
				// 	 $("#requestexpiredtime").val('');
				// 	 $('#requestexpiredtime').data("DateTimePicker").date(null);
				// 	 $('#requestexpiredtime').val('').datetimepicker('update');
				
				// 	 $("#start_time").val('');
				// 	 $('#start_time').data("DateTimePicker").date(null);
				// 	 $('#start_time').val('').datetimepicker('update');
				// 	 $('#start_time').data("DateTimePicker").date(null);
				// 	 $("#start_time").datetimepicker({
				// 	 format:'LT',
				// 	 Default:false
				// 	 });
					 
				// 	 //***********get curent time  plus 4 hours*********starts*** 
				//      var getcurdttime = new Date();
				// 	 var getcurdttimemom = moment(getcurdttime).format("DD/MM/YYYY hh:mm A");
				// 	 var getcurdttimemomadd=moment(getcurdttimemom,"DD/MM/YYYY hh:mm A").add(4,"hours").format("DD/MM/YYYY" );
				// 	 var getcurdttimemomaddtime=moment(getcurdttimemom,"DD/MM/YYYY hh:mm A").add(4,"hours").format("h:mm A" );
					 
				// 	 var curplusfour = getcurdttimemomadd + "======="+getcurdttimemomaddtime;
				// 	 console.log("current time plus four "+curplusfour);
				// 	 //***********get curent time  plus 4 hours*********ends***
					 
					 
				// 	 $('#booking_date').data("DateTimePicker").minDate(getcurdttimemomadd); //setting as min date
				
				// 	 var startdt=$("#booking_date").val();
				//      var strtmomnty =  moment(startdt,"DD-MM-YYYY").format("DD/MM/YYYY");
				// 	 console.log("strtmomnty"+strtmomnty);
				// 	 if(getcurdttimemomadd == strtmomnty) //if booking date is 4 hours away date
				// 	 {
				// 		console.log("same date");
				// 		$('#start_time').val('').datetimepicker('update');
				// 		$('#start_time').data("DateTimePicker").date(getcurdttimemomaddtime);
				// 		$("#start_time").datetimepicker({
				// 		format:'LT',
				// 		});
				// 	 }
					 
					 
				// });
				
			//****************Booking date change function ends here	
				
				 // $("#booking_date").on("dp.change", function(e)
     //     {
     //            $('#start_time').val('').datetimepicker('update');
     //            $('#start_time').data("DateTimePicker").date(null);

     //            $('#end_time').val('').datetimepicker('update');
     //            $('#end_time').data("DateTimePicker").date(null);


     //            $("#end_time").datetimepicker({
     //              format:'LT',
     //              //autoclose: false,
     //              Default:false
     //              });

     //     });


                                                // $('#requestexpireddate').datetimepicker({
                                                // format: 'DD/MM/YYYY',

                                                // });
                                                //  $('#booking_date').datetimepicker({
                                                // format: 'DD/MM/YYYY',

                                                // });
                                                //   var  mndate = moment().format("DD/MM/YYYY");
                                                // $("#requestexpireddate").data("DateTimePicker").minDate(mndate);

                                                //*********** This section is added on 22-07-2016 evening last moment before getting out starts here

                                                $("document").ready(function()
                                                {


                                                // var getcurdttime_first = new Date();
                                                // var getcurdttimemo_firstm = moment(getcurdttime_first).format("DD/MM/YYYY hh:mm A");
                                                // var getcurdttimemomadd_first=moment(getcurdttimemo_firstm,"DD/MM/YYYY hh:mm A").add(4,"hours").format("DD/MM/YYYY");
                                                // var getcurdttimemomaddtime_ftrst=moment(getcurdttimemo_firstm,"DD/MM/YYYY hh:mm A").add(4,"hours").format("h:mm A");
                                                // $("#booking_date").data("DateTimePicker").minDate(getcurdttimemomadd_first);
                                                });

                                                //*********** This section is added on 22-07-2016 evening last moment before getting out ends here


      // $("#booking_date").on("dp.change", function(e)
      //     {

      //                                                 $('#start_time').val('');
      //                                                 $('#start_time').val('').datetimepicker('update');
      //                                                 $("#start_time").datetimepicker({
      //                                                 format:'LT',
      //                                                 });

      //                                                // $('#requestexpireddate').val('');
      //                                                 $('#requestexpireddate').val('').datetimepicker('update');
      //                                                 $("#requestexpireddate").datetimepicker({
      //                                                 format:'DD/MM/YYYY',
      //                                                 //Default:false
      //                                                 });

      //                                                 //***********get curent time  plus 4 hours*********starts*** 
      //                                                 var getcurdttime = new Date();
      //                                                 var getcurdttimemom = moment(getcurdttime).format("DD/MM/YYYY hh:mm A");
      //                                                 var getcurdttimemomadd=moment(getcurdttimemom,"DD/MM/YYYY hh:mm A").add(4,"hours").format("DD/MM/YYYY" );
      //                                                 var getcurdttimemomaddtime=moment(getcurdttimemom,"DD/MM/YYYY hh:mm A").add(4,"hours").format("h:mm A" );

      //                                                 var curplusfour = getcurdttimemomadd + "======="+getcurdttimemomaddtime;
      //                                                 // console.log("current time plus four "+curplusfour);
      //                                                 //***********get curent time  plus 4 hours*********ends***


      //                                                // $('#booking_date').data("DateTimePicker").minDate(getcurdttimemomadd); //setting as min date commented on 12-10-2016

      //                                                 var startdt=$("#booking_date").val();
      //                                                 var strtmomnty =  moment(startdt,"DD-MM-YYYY").format("DD/MM/YYYY");
      //                                                 // console.log("strtmomnty"+strtmomnty);
      //                                                 if(getcurdttimemomadd == strtmomnty) //if booking date is 4 hours away date
      //                                                 {
      //                                                 //   console.log("same date");
      //                                                 $('#start_time').val('').datetimepicker('update');
      //                                                 $('#start_time').data("DateTimePicker").date(getcurdttimemomaddtime);
      //                                                 $("#start_time").datetimepicker({
      //                                                 format:'LT',
      //                                                 });
      //                                                 }
      //                                                 else
      //                                                 {
      //                                                 $('#start_time').data("DateTimePicker").date("12:00 AM");
      //                                                 }


      //                                                 //************special case
      //                                                 var stdt = $('#start_time').val();
      //                                                 if(stdt!='')
      //                                                 {
      //                                                   var bddt = $('#booking_date').val();
      //                                                   totl_tdt = bddt+' '+stdt;
      //                                                   fourhr = moment(totl_tdt,"DD/MM/YYYY hh:mm A").subtract(4,"hours").format("DD/MM/YYYY");
      //                                                  // $('#requestexpireddate').data("DateTimePicker").minDate(fourhr); //setting as max date
      //                                                 }else
      //                                                 {
                                                         
      //                                                 }



      //                                 // var crntmoment = moment().format("DD/MM/YYYY");
      //                                 // $("#requestexpiredtime").data("DateTimePicker").maxDate(crntmoment);                            


      //   });
				
				
				//*************start date chage function starts here
					 
// 					 $("#start_time").on("dp.change", function(e)
// 					 {
					 
					 
					 
// 					 //***********get curent time  plus 4 hours*********starts*** 
// 				    var getcurdttime = new Date();
// 					 var getcurdttimemom = moment(getcurdttime).format("DD/MM/YYYY hh:mm A");
// 					 var getcurdttimemomadd=moment(getcurdttimemom,"DD/MM/YYYY hh:mm A").add(4,"hours").format("DD/MM/YYYY" );
// 					 var getcurdttimemomaddtime=moment(getcurdttimemom,"DD/MM/YYYY hh:mm A").add(4,"hours").format("h:mm A" );
					 
// 					 var curplusfour = getcurdttimemomadd+' '+getcurdttimemomaddtime;
// 					 var curplusfourmoment = moment(curplusfour);
// 					 console.log("current time plus four "+curplusfour);
// 					 //***********get curent time  plus 4 hours*********ends***
					
// 					//***************booking date value	starts		 
// 					 var bkngdt=$("#booking_date").val();
// 				     var strtmomnty =  moment(bkngdt,"DD-MM-YYYY").format("DD/MM/YYYY");
// 					 console.log("strtmomnty"+strtmomnty);
// 					 //***************booking date value*********ends
					 
// 					 //**********start time value starts
// 					 var strtimvl = $("#start_time").val();
// 					 var strtmomntym =  moment(strtimvl,"h:mm A").format("h:mm A");
// 					 console.log("strtmomntym time"+strtmomnty+"***************"+strtmomntym);
					 
// 					 bookingtimetotal = strtmomnty+' '+strtmomntym;
// 					 bookingtimemoment = moment(bookingtimetotal)
// 					 //***********start time value ends
//  					//**********checking if booking moment is less than curent time plus four hours starts
// 					console.log("bookingtimemoment ============> "+bookingtimemoment);
// 					console.log("curplusfourmoment ============> "+curplusfourmoment);
// 					if (bookingtimemoment < curplusfourmoment)
// 					{
                        
// 						$("#start_time").data("DateTimePicker").date(getcurdttimemomaddtime);
//                     }
					
// 					//*********subtract four hours from booking date and time starts
// 					var bokingtimetobesubtract = strtmomnty+' '+strtmomntym;
// 					var bookingdatetimesubtract = moment(bokingtimetobesubtract,"DD/MM/YYYY h:mm A").subtract(4,"hours").format("DD/MM/YYYY h:mm A" );
// 					var bookingtimesubtract = moment(bokingtimetobesubtract,"DD/MM/YYYY h:mm A").subtract(4,"hours").format("h:mm A" );
// 					var bookingdatesubtract = moment(bokingtimetobesubtract,"DD/MM/YYYY h:mm A").subtract(4,"hours").format("DD/MM/YYYY" );
					
// 					console.log("Subtracted datetime is=========>"+bookingdatetimesubtract);
// 					//*********subtract four hours from bôking date and time ends
// 					console.log("Booking date and booking time is=========> "+strtmomnty+"===="+strtmomntym);
					
// 					//**********checking if booking moment is less than curent time plus four hours ends
								 
// 						//*********place the value in request expired date and time section starts
// 						$("#requestexpireddate").data("DateTimePicker").maxDate(bookingdatesubtract);
// 						$("#requestexpireddate").data("DateTimePicker").minDate(getcurdttimemomadd);
// 						//$("#requestexpireddate").data("DateTimePicker").maxDate('14/06');
// 						//$("#requestexpiredtime").data("DateTimePicker").date(bookingdatetimesubtract);
// 						//*********place the value in request expired date and time section ends
								 
						
// //********resetting the value of end time picker
//               $('#end_time').val('').datetimepicker('update');
//                 $('#end_time').data("DateTimePicker").date(null);


//                 $("#end_time").datetimepicker({
//                   format:'LT',
//                   //autoclose: false,
//                   Default:false
//                   });

							
								
// 						 });		

  // $("#start_time").on("dp.change", function(e)
  //         {

  //                                                       $('#end_time').val('').datetimepicker('update');
  //                                                       $('#end_time').data("DateTimePicker").date(null);
  //                                                       $("#end_time").datetimepicker({
  //                                                       format:'LT',

  //                                                       });

  //                                                       $('#requestexpireddate').val('').datetimepicker('update');
  //                                                       $('#requestexpireddate').data("DateTimePicker").date(null);
  //                                                       $("#requestexpireddate").datetimepicker({
  //                                                       format:'DD/MM/YYYY',

  //                                                       });
                                                         
  //                                                       //***********get curent time  plus 4 hours*********starts*** 
  //                                                       var getcurdttime = new Date();
  //                                                       var getcurdttimemom = moment(getcurdttime).format("DD/MM/YYYY hh:mm A");
  //                                                       var getcurdttimemomadd=moment(getcurdttimemom,"DD/MM/YYYY hh:mm A").add(4,"hours").format("DD/MM/YYYY");
  //                                                       var getcurdttimemomaddtime=moment(getcurdttimemom,"DD/MM/YYYY hh:mm A").add(4,"hours").format("h:mm A");

  //                                                       var strtimvalue = $("#start_time").val();
  //                                                       strtimvalue_moment = moment(strtimvalue,"h:mm A");
  //                                                       //console.log("strtimvalue_moment present*****************"+strtimvalue_moment);

  //                                                       var getcurdttimemomaddtimemom = moment(getcurdttimemomaddtime,"h:mm A");
  //                                                       //console.log("getcurdttimemomaddtimemom*******************"+getcurdttimemomaddtimemom);

  //                                                       var bookingdateval = $("#booking_date").val();
  //                                                       if(getcurdttimemomadd == bookingdateval)
  //                                                       {
  //                                                       // console.log("we are in same date");
  //                                                         if(strtimvalue_moment < getcurdttimemomaddtimemom)
  //                                                         {
  //                                                         $("#start_time").data("DateTimePicker").date(getcurdttimemomaddtime);
  //                                                         }
  //                                                       }
  //                                                       $('#requestexpireddate_gig').val('').datetimepicker('update');

  //                                                       $("#requestexpireddate").datetimepicker({
  //                                                       format:'DD/MM/YYYY',
  //                                                       //Default:false
  //                                                       });



  //                                                       //**********setting of four hours date
  //                                                       $bkdate_val = $("#booking_date").val();
  //                                                       $bk_time_val = $("#start_time").val();
  //                                                       $bk_datetime = $bkdate_val+' '+$bk_time_val;
  //                                                       bk_datetime_moment = moment($bk_datetime,"DD/MM/YYYY hh:mm A").subtract(4,"hours").format("DD/MM/YYYY");

  //                                                       //$("#requestexpireddate").data("DateTimePicker").maxDate(bk_datetime_moment); this section is commented on 04-08-2016
  //                                                       // moment()



  //         }); 


					// 		  $("#requestexpiredtime").on("dp.change", function(e)
					// 		  {
								 
					// 			 //*******************If request Expire time less than curent datetime
					// 			 var ctyme = new Date();
					// 			 var ctyme_dttime = ctyme.setDate(ctyme.getDate());
					// 			 var ctyme_date = moment(ctyme_dttime).format("DD/MM/YYYY");
					// 			 var ctyme_time = moment(ctyme_dttime).format("h:mm A");
								 
					// 			 var completemomentCurnt =  ctyme_date+' '+ctyme_time;
								 
					// 			 	console.log("Currnt time"+completemomentCurnt);
					// 			 completemomentCurnt = moment(completemomentCurnt);
								 
					// 			 //************Requestexpiredate time starts here
					// 			 var requestexpiresolddt = $('#requestexpireddate').val();
					// 			 requestexpiresolddt_moment = moment(requestexpiresolddt,"DD-MM-YYYY").format("DD/MM/YYYY");
					// 			 var requestexpiretime = $('#requestexpiredtime').val();
					// 			 requestexpiretimemoment = moment(requestexpiretime,"hh:mm A").format("h:mm A");
					// 			 var completemomentREqexp =  requestexpiresolddt_moment+' '+requestexpiretimemoment;
					// 			 completemomentREqexp =moment(completemomentREqexp);
							  
					// 		  	console.log("Request Expire time"+requestexpiretimemoment);
					// 			 //************requestexpires date time ends here
								 
					// 			 if(completemomentREqexp < completemomentCurnt)
					// 			 {
					// 				$("#requestexpiredtime").data("DateTimePicker").date(ctyme_time);
					// 			 }
								 
					// 			 //*******************If request Expire time less than curent datetime
								 
								 
								 
								 
								 
					// 			 //console.log("Totla dateetime===========>"+totaldatetime);
					// 			 var startdatedata=$("#booking_date").val();
					// 			 var mmmntstartdate=moment(startdatedata,"DD-MM-YYYY").format("DD/MM/YYYY");
					// 			 var mmdata1=$("#start_time").val();
					// 			 var mmmntstarttime=moment(mmdata1,"hh:mm A").format('h:mm A');
								 
					// 			  var completemomenttobesubtracetd =  mmmntstartdate+' '+mmmntstarttime;
								 
				 //  var subtractedcompletedtime=moment(completemomenttobesubtracetd,"DD/MM/YYYY hh:mm A").subtract(4,"hours").format("DD/MM/YYYY h:mm A" );
								 
					// var subtractedtime=moment(completemomenttobesubtracetd,"DD/MM/YYYY hh:mm A").subtract(4,"hours").format("h:mm A" );
					// 			 			 var subtractedtime = moment(subtractedcompletedtime);
								 
					// 			// console.log("STRATTIME TOTAL=============>"+subtractedtime);
								 
					// 			  if(completemomentREqexp > subtractedtime)
					// 			 {
					// 				$("#requestexpiredtime").data("DateTimePicker").date(subtractedtime);
					// 			 }
								 
								
					// 		  });

          //   $("#requestexpiredtime").on("dp.change", function(e)
          // {


          //                                         var crntdate = moment().format('DD/MM/YYYY');
          //                                         var crnttime = moment().format('hh:mm A');

          //                                         var end_time = $('#requestexpiredtime').val();
          //                                         var r =  moment(end_time,"hh:mm A");


          //                                         var l = moment(crnttime,"hh:mm A");

          //                                         var strttime = $("#requestexpireddate").val();


          //                                         if(strttime == crntdate)
          //                                         {
          //                                           if(r < l)
          //                                           {
          //                                           // alert('hello');
          //                                           $("#requestexpiredtime").data("DateTimePicker").date(crnttime);
          //                                           }

          //                                         }


          //                                         var bookingreqdate = $("#booking_date").val();
          //                                         // // console.log("bookingreqdate"+bookingreqdate);
          //                                         var strt_time_bk = $('#start_time').val();
          //                                         //  //console.log("strt_time_gig"+strt_time_gig);

          //                                         var ttmoment = bookingreqdate+' '+strt_time_bk;

          //                                         // console.log("ttmoment"+ttmoment);

          //                                         var fourhrmoment_before_date = moment(ttmoment,"DD/MM/YYYY hh:mm A").subtract(4,'hours').format("DD/MM/YYYY");
          //                                         var fourhrmoment_before_time = moment(ttmoment,"DD/MM/YYYY hh:mm A").subtract(4,'hours').format("hh:mm A");

          //                                         //  console.log("fourhrmoment_before_date"+fourhrmoment_before_date+"fourhrmoment_before_time"+fourhrmoment_before_time);
          //                                         fourhour_span = moment(fourhrmoment_before_time,"hh:mm A");

          //                                         if(fourhrmoment_before_date == strttime)
          //                                         {
                                                
          //                                           if(r > fourhour_span)
          //                                           {
          //                                           // console.log("in this section");
          //                                           $("#requestexpiredtime").data("DateTimePicker").date(fourhrmoment_before_time);
          //                                           }
                                                 
          //                                         }




                                                 



          // });
								
								 //$('#requestexpiredtime').data("DateTimePicker").maxDate(prevstime5hrsback);
							
								 // $("#end_time").on("dp.change", function(e)
         //         {
                    
         //                     //  var  endtmval = $('#start_time').val();


         //                        var startdatedata=$("#booking_date").val();
         //                        var mmmntstartdate=moment(startdatedata,"DD-MM-YYYY").format("DD/MM/YYYY");


         //                        var mmdata1=$("#start_time").val();
         //                        var mmmntstarttime=moment(mmdata1,"hh:mm A").format('h:mm A');

         //                        var completemomenttobesubtracetd =  moment(mmmntstartdate+' '+mmmntstarttime);
         //                        console.log("moment is "+completemomenttobesubtracetd);


         //                        var mmdata2=$("#end_time").val();
         //                        var mmmntendtime=moment(mmdata2,"hh:mm A").format('h:mm A');

         //                         var completemomenttobesubtracetdwith =  moment(mmmntstartdate+' '+mmmntendtime);
         //                        console.log("moment is end time "+(completemomenttobesubtracetdwith));

         //                        if(completemomenttobesubtracetdwith < completemomenttobesubtracetd)
         //                        {
         //                            console.log("moment is end time with less"+completemomenttobesubtracetdwith);
         //                            console.log("moment is "+completemomenttobesubtracetd);

         //                          console.log("going to wrong");
         //                           $("#end_time").data("DateTimePicker").date(mmmntstarttime);
         //                        }
								 
								 //  });

        //           $("#end_time").on("dp.change", function (e)
        // {
        //                                                 var crntdate = moment().format('DD/MM/YYYY');
        //                                                 var crnttime = moment().format('hh:mm A');

        //                                                 var end_time_booking = $('#end_time').val();
        //                                                 var r =  moment(end_time_booking,"hh:mm A");


        //                                                 var l = moment(crnttime,"hh:mm A");

        //                                                 var strttime = $("#booking_date").val();


        //                                                 if(strttime == crntdate)
        //                                                 {
        //                                                 // console.log('hurray!!!!!!!!!!');
        //                                                 if(r < l)
        //                                                 {
        //                                                 //  console.log('ererre!!!!!!!!!!');
        //                                                 $("#end_time").data("DateTimePicker").date(crnttime);
        //                                                 }
        //                                                 }


        //                                                 var strt_time_booking = $('#start_time').val();
        //                                                 var p =  moment(strt_time_booking,"hh:mm A");

        //                                                 if(r < p )
        //                                                 {

        //                                                 $("#end_time").data("DateTimePicker").date(strt_time_booking);
        //                                                 }


        // })
								 
								 // $("#requestexpireddate").on("dp.change", function(e)
								 // {
									//    $('#requestexpiredtime').val('').datetimepicker('update');
									//    $('#requestexpiredtime').data("DateTimePicker").date(null);
									//    $("#requestexpiredtime").datetimepicker({
									//    format:'LT',
									//    //autoclose: false,
									//    Default:false
									//    });
								  
								 // });
                 // $("#requestexpireddate").on("dp.change", function(e)
                 // {
                 //                                         var dt = $("#booking_date").val();
                 //                                         var tm = $("#start_time").val();


                 //                                         if(dt=='' || tm=='')
                 //                                         {
                 //                                         $('#requestexpireddate').datetimepicker({
                 //                                         format:'DD/MM/YYYY',
                 //                                         // useCurrent:true
                 //                                         });
                 //                                         $('#requestexpireddate').val('');

                 //                                         }

                 //                                         strtdtaetime = dt+' '+tm;
                 //                                         var strtdtaetime_date = moment(strtdtaetime,"DD/MM/YYYY hh:mm A").subtract(4,'hours').format("DD/MM/YYYY");

                 //                                         $("#requestexpireddate").data("DateTimePicker").maxDate(strtdtaetime_date);
                 //                                         $('#requestexpiredtime').datetimepicker({
                 //                                         format:'LT',
                 //                                         });


                 //                                         $('#requestexpiredtime').val('').datetimepicker('update');
                 //                                         $('#requestexpiredtime').data("DateTimePicker").date(null);
                 //                                         $("#requestexpiredtime").datetimepicker({
                 //                                         format:'LT'
                 //                                         });





                 // });
                 
								 
								 
								 
								 
               
               
               
               
               
               
               
               
               
               
               
               
               //**************calender js ends here************************//////////////////////////************
                      