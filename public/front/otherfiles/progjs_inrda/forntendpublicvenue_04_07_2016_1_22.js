//********
function checkvenuebookingavailability(j)
{
  var replysesponse = "";
  if(j == 1)
  replysesponse = "You must be logged in to continue";
  if(j == 2)
  replysesponse = "Your request can not be processed";
 if(j == 3)
  replysesponse = "This venue is not available for booking";

  //alert(replysesponse);
   toastr.remove();// Immediately remove current toasts without using animation
  poptriggerfunc(msgtype='error',titledata='',msgdata=replysesponse,sd=6000,hd=1500,tmo=3000,etmo=4000,poscls='toast-bottom-right');

}

//********
//this section is for google map 
//*******starting 
 
  var map;
  function initialize(ltude,lngtude) {

   if(ltude == '' && lngtude== '')
   {
    ltude = -33.868820;
    lngtude = 151.209296;

   }



        var mapOptions = {
          zoom: 16,
          center: {lat: ltude, lng: lngtude}
        };
        map = new google.maps.Map(document.getElementById('map'),
            mapOptions);

        var marker = new google.maps.Marker({
          // The below line is equivalent to writing:
          // position: new google.maps.LatLng(-34.397, 150.644)
          position: {lat: ltude, lng: lngtude},
          map: map
        });

        // You can use a LatLng literal in place of a google.maps.LatLng object when
        // creating the Marker object. Once the Marker object is instantiated, its
        // position will be available as a google.maps.LatLng object. In this case,
        // we retrieve the marker's position using the
        // google.maps.LatLng.getPosition() method.
        var infowindow = new google.maps.InfoWindow({
          content: '<p>Marker Location:' + marker.getPosition() + '</p>'
        });

        google.maps.event.addListener(marker, 'click', function() {
          infowindow.open(map, marker);
        });
      }

      // google.maps.event.addDomListener(window, 'load', initialize(hidnlt,hdnlng));



//*******ending
//********this section is for modal open if it comes from home page
//******starting
if (flgBkGrp=='1') {
            $('.openbkgrpcls').trigger('click');
			
          }
//******ending
//*******this section is for masking
//*****starting
//********masaking length for total payment attribute
   var maxLength = $("#total_payment").attr('maxlength');
   if($("#total_payment").val().length == maxLength)
   {
   	$("#total_payment").next().focus();
   }
  
   //********masaking length for total payment attribute
   var maxLength2 = $("#cancellation_payment").attr('maxlength');
   if($("#cancellation_payment").val().length == maxLength2)
   {
   	$("#cancellation_payment").next().focus();
   }
   
   //********masaking length for total payment attribute
   var maxLength3 = $("#security_payment").attr('maxlength');
   if($("#security_payment").val().length == maxLength3)
   {
   	$("#security_payment").next().focus();
   }
//****ending
//********this section is for slider 
//***starting

function showhideprevnextimgslider(totalItems,curritemnum)
             {
			 //alert("totalItems=====>"+totalItems);
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
//*****this section is for country state ajax
//*****starting

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
                                                       skiloptstr+="<option value="+vaobj.id+">"+vaobj.name+"</option>";
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

//*****ending
//*******this section is for category genere
//*****starting
 function getGenereforCategory(requeststateUrl,Catagory_Id,csrf,venuID)
               {
                         var categorydata = {_token:csrf,categoryID:Catagory_Id,venueid:venuID};
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
//*****ending
//****this section is for booking form submission
//****starting
 function callforbookingvenue(posturl,csrf)
                              {
          
                              $('#myModal5').animate({ scrollTop: 0 }, 'slow');
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
                                         var characterReg = /^[0-9]{5}(?:-[0-9]{4})?$/;
                                         return characterReg.test(value);
                                     },"Please enter valid booking zip code");
                                
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
                                },"Total paymenet must be higher than security deposit");
                                
                                //******************** CUSTOM FUNCTION ***************ENDS********************
                                
                              //**********************FORM VALIDATION STARTS HERE ***************************
                              
                                   $("#bookingform").validate({
                                        errorClass: "authError",
                                       // errorElement: 'div',
                                        //***********************VALIDATION RULES*****************STARTS****************
                                             rules: {
                                                       booking_location: {
                                                            required: true,
                                                            minlength: 2,
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
                                                       },
                                                        zip: {
                                                            required: true,
                                                          //  numericfield : true,
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
                                                       start_time:{
                                                            required: true,
                                                       },
                                                        end_time:{
                                                            required: true,
                                                       },
                                                        security_payment:{
                                                            required: true,
                                                            maxlength: 20,
                                                        },
                                                        
                                                         total_payment:{
                                                            required: true,
                                                            maxlength: 20,
                                                            checkingamounttotal:true
                                                       },
                                                         cancellation_payment:{
                                                            required: true,
                                                            maxlength: 20,
                                                            checkingamount :true,
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
                                                           required: "Please enter booking zip code",
                                                           
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
                                                       start_time: {
                                                          required: "Please select a start time",
                                                       },
                                                       end_time: {
                                                          required: "Please select a end time",
                                                       },
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
                                                       
                                                      
                                                  },
                                                  
                                                  
                                                  
                                                  //*****************VALIDATION ERROR MESSAGES *******************ENDS*********
                
                                        });
                                        //************************CHECKING VALIDATION CONDITION**********************STARTS*********
                              
     
                              var chkbookingvalidation =  $("#bookingform").valid();
                              if(chkbookingvalidation === true)
                              {
                                  //************ Retriving value starts here
                                   var address1val = $("#booking_location").val();
                                   var address2val = $("#booking_location_second").val();
                                   var countrydata = $("#country_id").val();
                                   var statelistdata = $("#statelist").val();
                                   var towndata = $("#town").val();
                                   var zipdata = $("#zip").val();
                                   var bookingcat_subdata = $("#bookingcat_subvenue").val();
                                   var bookinggenre_subdata = $("#bookinggenre_sub").val();
                                   
                                    //var securitymony = $("#security_payment").val().replace("$", "").replace(/,/g, "");
                                   var security_paymentdata = $("#security_payment").val().replace("$", "").replace(/,/g, "");
                                   var total_paymentdata = $("#total_payment").val().replace("$", "").replace(/,/g, "");
                                   var cancellation_paymentdata = $("#cancellation_payment").val().replace("$", "").replace(/,/g, "");
                                   
                                   
                                   var booking_datedata = $("#booking_date").val();
                                   var start_timedata = $("#start_time").val();
                                   var end_timedata = $("#end_time").val();
                                   var requestexpireddatedata = $("#requestexpireddate").val();
                                   var requestexpiredtimedata = $("#requestexpiredtime").val();

                                    var venueownID = $("#venueID").val();
                                   //console.log("Booking Token========>"+csrf);
                                   //************ Retriving value ends here
                                   
                                   //************** Ajax form submission starts here
                                    var bookingformdata = {_token:csrf,address1val:address1val,address2val:address2val,countrydata:countrydata,statelistdata:statelistdata,towndata:towndata,zipdata:zipdata,bookingcat_subdata:bookingcat_subdata,bookinggenre_subdata:bookinggenre_subdata,security_paymentdata:security_paymentdata,total_paymentdata:total_paymentdata,cancellation_paymentdata:cancellation_paymentdata,booking_datedata:booking_datedata,start_timedata:start_timedata,end_timedata:end_timedata,requestexpireddatedata:requestexpireddatedata,requestexpiredtimedata:requestexpiredtimedata,venueownID:venueownID};
                                        var bookingurldata=base_url_data+"/"+"venuebookingsubmission";
                                        console.log("Booking Form url data========>"+bookingurldata);
                                        jQuery.ajax({
										type: "POST",
										data:bookingformdata,
										url: bookingurldata,
										dataType:"json",
                                             success: function(res)
                                             {
                                                  
                                                  console.log("Booking response==========>"+res.flag);
                                             }
                                        });
                                   //************** Ajax form submission ends here
                                  
                                   //showmycustomloader(0,'','',"Please wait ....",imfpth);
                                   var imfpth=base_url_data+"/public/front/otherfiles/progimages/loder.gif"
                                   showmycustomloader(1,'4000','2000',"Processing. Please wait ....",imfpth);
                                   $("#cancelbtn").click(); //***modal remove
                                   var success_message_data="Thank you for your booking request! ";
                                   poptriggerfunc(msgtype='success',titledata='',msgdata=success_message_data,sd=6000,hd=1500,tmo=3000,etmo=4000,poscls='toast-bottom-right');
                                                     //****************************LOADER ENDS HERE****************************************
                                 
                                 //return 2;
                              }
                              else
                              {
                                   var error_message_data="Please complete your booking request! ";
                                   poptriggerfunc(msgtype='error',titledata='',msgdata=error_message_data,sd=6000,hd=1500,tmo=3000,etmo=4000,poscls='toast-bottom-right');
                                 //return 1;
                              }
                            //************************CHECKING VALIDATION CONDITION**********************ENDS*********
   
                              }
//****ending
//*******this section is for modal hide with error message remove
//****starting
 $('#myModal5').on('hidden.bs.modal', function () {
			   
				   //$(this).find("input,textarea,select").val('').end();
				  $("#bookingform").trigger('reset');
				   //validator.resetForm();
				   var validator = $("#bookingform").validate();
				   $('input').removeClass('authError');
				   validator.resetForm();
			   
			   });
//****ending
//*********this is for booking option date time strat time and time
//****starting
 
               
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
				
				
				
				
				//*************start date chage function starts here
					 
					 $("#start_time").on("dp.change", function(e)
					 {
					 
					 
					 
					 //***********get curent time  plus 4 hours*********starts*** 
				     var getcurdttime = new Date();
					 var getcurdttimemom = moment(getcurdttime).format("DD/MM/YYYY hh:mm A");
					 var getcurdttimemomadd=moment(getcurdttimemom,"DD/MM/YYYY hh:mm A").add(4,"hours").format("DD/MM/YYYY" );
					 var getcurdttimemomaddtime=moment(getcurdttimemom,"DD/MM/YYYY hh:mm A").add(4,"hours").format("h:mm A" );
					 
					 var curplusfour = getcurdttimemomadd+' '+getcurdttimemomaddtime;
					 var curplusfourmoment = moment(curplusfour);
					 console.log("current time plus four "+curplusfour);
					 //***********get curent time  plus 4 hours*********ends***
					
					//***************booking date value	starts		 
					 var bkngdt=$("#booking_date").val();
				     var strtmomnty =  moment(bkngdt,"DD-MM-YYYY").format("DD/MM/YYYY");
					 console.log("strtmomnty"+strtmomnty);
					 //***************booking date value*********ends
					 
					 //**********start time value starts
					 var strtimvl = $("#start_time").val();
					 var strtmomntym =  moment(strtimvl,"h:mm A").format("h:mm A");
					 console.log("strtmomntym time"+strtmomnty+"***************"+strtmomntym);
					 
					 bookingtimetotal = strtmomnty+' '+strtmomntym;
					 bookingtimemoment = moment(bookingtimetotal)
					 //***********start time value ends
 					//**********checking if booking moment is less than curent time plus four hours starts
					console.log("bookingtimemoment ============> "+bookingtimemoment);
					console.log("curplusfourmoment ============> "+curplusfourmoment);
					if (bookingtimemoment < curplusfourmoment)
					{
                        
						$("#start_time").data("DateTimePicker").date(getcurdttimemomaddtime);
                    }
					
					//*********subtract four hours from booking date and time starts
					var bokingtimetobesubtract = strtmomnty+' '+strtmomntym;
					var bookingdatetimesubtract = moment(bokingtimetobesubtract,"DD/MM/YYYY h:mm A").subtract(4,"hours").format("DD/MM/YYYY h:mm A" );
					var bookingtimesubtract = moment(bokingtimetobesubtract,"DD/MM/YYYY h:mm A").subtract(4,"hours").format("h:mm A" );
					var bookingdatesubtract = moment(bokingtimetobesubtract,"DD/MM/YYYY h:mm A").subtract(4,"hours").format("DD/MM/YYYY" );
					
					console.log("Subtracted datetime is=========>"+bookingdatetimesubtract);
					//*********subtract four hours from bôking date and time ends
					console.log("Booking date and booking time is=========> "+strtmomnty+"===="+strtmomntym);
					
					//**********checking if booking moment is less than curent time plus four hours ends
								 
						//*********place the value in request expired date and time section starts
						$("#requestexpireddate").data("DateTimePicker").maxDate(bookingdatesubtract);
						$("#requestexpireddate").data("DateTimePicker").minDate(getcurdttimemomadd);
						//$("#requestexpireddate").data("DateTimePicker").maxDate('14/06');
						//$("#requestexpiredtime").data("DateTimePicker").date(bookingdatetimesubtract);
						//*********place the value in request expired date and time section ends
								 
								 
							
								
						 });		 
							  $("#requestexpiredtime").on("dp.change", function(e)
							  {
								 
								 //*******************If request Expire time less than curent datetime
								 var ctyme = new Date();
								 var ctyme_dttime = ctyme.setDate(ctyme.getDate());
								 var ctyme_date = moment(ctyme_dttime).format("DD/MM/YYYY");
								 var ctyme_time = moment(ctyme_dttime).format("h:mm A");
								 
								 var completemomentCurnt =  ctyme_date+' '+ctyme_time;
								 
								 	console.log("Currnt time"+completemomentCurnt);
								 completemomentCurnt = moment(completemomentCurnt);
								 
								 //************Requestexpiredate time starts here
								 var requestexpiresolddt = $('#requestexpireddate').val();
								 requestexpiresolddt_moment = moment(requestexpiresolddt,"DD-MM-YYYY").format("DD/MM/YYYY");
								 var requestexpiretime = $('#requestexpiredtime').val();
								 requestexpiretimemoment = moment(requestexpiretime,"hh:mm A").format("h:mm A");
								 var completemomentREqexp =  requestexpiresolddt_moment+' '+requestexpiretimemoment;
								 completemomentREqexp =moment(completemomentREqexp);
							  
							  	console.log("Request Expire time"+requestexpiretimemoment);
								 //************requestexpires date time ends here
								 
								 if(completemomentREqexp < completemomentCurnt)
								 {
									$("#requestexpiredtime").data("DateTimePicker").date(ctyme_time);
								 }
								 
								 //*******************If request Expire time less than curent datetime
								 
								 
								 
								 
								 
								 //console.log("Totla dateetime===========>"+totaldatetime);
								 var startdatedata=$("#booking_date").val();
								 var mmmntstartdate=moment(startdatedata,"DD-MM-YYYY").format("DD/MM/YYYY");
								 var mmdata1=$("#start_time").val();
								 var mmmntstarttime=moment(mmdata1,"hh:mm A").format('h:mm A');
								 
								  var completemomenttobesubtracetd =  mmmntstartdate+' '+mmmntstarttime;
								 
				  var subtractedcompletedtime=moment(completemomenttobesubtracetd,"DD/MM/YYYY hh:mm A").subtract(4,"hours").format("DD/MM/YYYY h:mm A" );
								 
					var subtractedtime=moment(completemomenttobesubtracetd,"DD/MM/YYYY hh:mm A").subtract(4,"hours").format("h:mm A" );
								 			 var subtractedtime = moment(subtractedcompletedtime);
								 
								// console.log("STRATTIME TOTAL=============>"+subtractedtime);
								 
								  if(completemomentREqexp > subtractedtime)
								 {
									$("#requestexpiredtime").data("DateTimePicker").date(subtractedtime);
								 }
								 
								
							  });
								
								 //$('#requestexpiredtime').data("DateTimePicker").maxDate(prevstime5hrsback);
							
								 
								 
								 
								 
								 $("#requestexpireddate").on("dp.change", function(e)
								 {
									   $('#requestexpiredtime').val('').datetimepicker('update');
									   $('#requestexpiredtime').data("DateTimePicker").date(null);
									   $("#requestexpiredtime").datetimepicker({
									   format:'LT',
									   //autoclose: false,
									   Default:false
									   });
								  
								 });
								 
								 
								 
			
               
               //**************calender js ends here************************//////////////////////////************
//****ending