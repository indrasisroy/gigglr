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
                                   //alert(event_type_entry);
          
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
                                       errorElement: 'div',
                                        //***********************VALIDATION RULES*****************STARTS****************
                                             rules: {
                                                       // booking_location: {
                                                       //      required: true,
                                                       //      minlength: 2,
                                                       // },
                                                       //  countryId: {
                                                       //      required: true,
                                                       // },
                                                       // statelist: {
                                                       //      required: true,
                                                       // },
                                                       //  town: {
                                                       //      required: true,
                                                       //      charactertype:true,
                                                       // },
                                                       //  zip: {
                                                       //      required: true,
                                                       //    //  numericfield : true,
                                                       // },
                                                       bookingcat_subvenue: {
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
                                                          
                                                       // booking_location: {
                                                       //     required: "Booking location can not be empty",
                                                       //     minlength: "Please enter a valid location"
                                                       // },
                                                       // countryId: {
                                                       //     required: "Please select a country",
                                                           
                                                       // },
                                                       //  statelist: {
                                                       //     required: "Please select a state",
                                                           
                                                       // },
                                                       //  town: {
                                                       //     required: "Please enter city name",
                                                           
                                                       // },
                                                       //  zip: {
                                                       //     required: "Please enter booking zip code",
                                                           
                                                       // },
                                                       bookingcat_subvenue: {
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
                                   // var address1val = $("#booking_location").val();
                                   // var address2val = $("#booking_location_second").val();
                                   // var countrydata = $("#country_id").val();
                                   // var statelistdata = $("#statelist").val();
                                   // var towndata = $("#town").val();
                                   // var zipdata = $("#zip").val();
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

                                    var type_entry_insert = '';
                                   //alert(event_type_entry);
                                  // alert(event_type_entry);
                                   if (event_type_entry =='3') {
                                    type_entry_insert = $('input[name=radio_entry_type]:checked').val(); //"input[name=radio_entry_type]:checked"
                                   }else{
                                    type_entry_insert = event_type_entry;
                                   }
                                   //console.log("Booking Token========>"+csrf);
                                   //************ Retriving value ends here
                                   
                                   //************** Ajax form submission starts here
                                    var bookingformdata = {_token:csrf,type_entry:type_entry_insert,bookingcat_subdata:bookingcat_subdata,bookinggenre_subdata:bookinggenre_subdata,security_paymentdata:security_paymentdata,total_paymentdata:total_paymentdata,cancellation_paymentdata:cancellation_paymentdata,booking_datedata:booking_datedata,start_timedata:start_timedata,end_timedata:end_timedata,requestexpireddatedata:requestexpireddatedata,requestexpiredtimedata:requestexpiredtimedata,venueownID:venueownID};
                                        var bookingurldata=base_url_data+"/"+"venuebookingsubmission";
                                        console.log("Booking Form url data========>"+bookingurldata);
                                        jQuery.ajax({
                        										type: "POST",
                        										data:bookingformdata,
                        										url: bookingurldata,
                        										dataType:"json",
                                             // success: function(res)
                                             // {
                                                  
                                             //      console.log("Booking response==========>"+res.flag);
                                             // }

                                             success: function(d)
                                             {
                                              // alert(d.error_message);
                                              // alert(d.flag_id);
                                              //alert("Vnue iD"+venueownID);
                                                  //alert(d.error_message);
                                                  //console.log("Booking response==========>"+d.flag_id+"  d.error_message "+d.error_message);

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
                                            poptriggerfunc(msgtype='error',titledata='',msgdata=error_message_data,sd=7000,hd=2500,tmo=3000,etmo=4000,poscls='toast-bottom-right');         

                                            }
                                            else
                                            {

                                              var imfpth=base_url_data+"/public/front/otherfiles/progimages/loder.gif"
                                              showmycustomloader(1,'4000','2000',"Processing. Please wait ....",imfpth);
                                              $("#cancelbtn").click(); //***modal remove
                                              var success_message_data="Thank you for your booking request! ";
                                              poptriggerfunc(msgtype='success',titledata='',msgdata=success_message_data,sd=7000,hd=2500,tmo=3000,etmo=4000,poscls='toast-bottom-right');
                                              // alert('ewrewr');
                                              // console.log('werewrewrewrewrerewr');
                                            }
                                            }


                                        });
                                   //************** Ajax form submission ends here
                                  
                                   //showmycustomloader(0,'','',"Please wait ....",imfpth);
                                   // var imfpth=base_url_data+"/public/front/otherfiles/progimages/loder.gif"
                                   // showmycustomloader(1,'4000','2000',"Processing. Please wait ....",imfpth);
                                   // $("#cancelbtn").click(); //***modal remove
                                   // var success_message_data="Thank you for your booking request! ";
                                   // poptriggerfunc(msgtype='success',titledata='',msgdata=success_message_data,sd=6000,hd=1500,tmo=3000,etmo=4000,poscls='toast-bottom-right');
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
            
//*********added on 08-07 starts

        $("#end_time").datetimepicker({
              format:'HH:mm',
        });

//*******this function is calling on bodyload------------------------**************************************
          $("document").ready(function()
          {

        
                  var getcurdttime_first = new Date();
                  var getcurdttimemo_firstm = moment(getcurdttime_first).format("DD/MM/YYYY hh:mm A");
                  var getcurdttimemomadd_first=moment(getcurdttimemo_firstm,"DD/MM/YYYY hh:mm A").add(4,"hours").format("DD/MM/YYYY");
                  var getcurdttimemomaddtime_ftrst=moment(getcurdttimemo_firstm,"DD/MM/YYYY hh:mm A").add(4,"hours").format("h:mm A");

                  // console.log('Rockbaj is back=======>'+getcurdttimemomadd_first + '  '+getcurdttimemomaddtime_ftrst);
                  $("#booking_date").data("DateTimePicker").minDate(getcurdttimemomadd_first);

                // var curentfourmoment = moment(getcurdttimemomadd_first+'  '+getcurdttimemomaddtime_ftrst,"DD/MM/YYYY hh:mm A");
                // console.log("curentfourmoment"+curentfourmoment+moment(curentfourmoment,"DD/MM/YYYY hh:mm A").format("DD/MM/YYYY hh:mm A"));
         
          });

//*******this function is calling on booking_date change------------------------**************************************

           $("#booking_date").on("dp.change", function(e)
           {
              $('#start_time').val('').datetimepicker('update');
            // $('#start_time').data("DateTimePicker").date(getcurdttimemomadd_first);
              $("#start_time").datetimepicker({
              format:'LT',
              });



              //************* booking date time when given starts here

                      var getcurdttime_first = new Date();
                      var getcurdttimemo_firstm = moment(getcurdttime_first).format("DD/MM/YYYY hh:mm A");
                      var getcurdttimemomadd_first=moment(getcurdttimemo_firstm,"DD/MM/YYYY hh:mm A").add(4,"hours").format("DD/MM/YYYY");
                      var getcurdttimemomaddtime_ftrst=moment(getcurdttimemo_firstm,"DD/MM/YYYY hh:mm A").add(4,"hours").format("h:mm A");

                     // console.log('Rockbaj is back=======>'+getcurdttimemomadd_first + '  '+getcurdttimemomaddtime_ftrst);
                   //   $("#booking_date").data("DateTimePicker").minDate(getcurdttimemomadd_first);

                      var curentfourmoment = moment(getcurdttimemomadd_first+'  '+getcurdttimemomaddtime_ftrst,"DD/MM/YYYY hh:mm A");
                     // console.log("curentfourmoment"+curentfourmoment+"------"+moment(curentfourmoment,"DD/MM/YYYY hh:mm A").format("DD/MM/YYYY hh:mm A"));

              //************* booking date time when given ends here


           
                          var opening_timemom = moment(opening_time,"HH:mm").format("hh:mm A");
                        
                          var ctyme = $("#booking_date").val();
                       //   var ctyme_dttime = ctyme.setDate(ctyme.getDate());
                          var ctyme_date = moment(ctyme,"DD/MM/YYYY").format("DD/MM/YYYY");

                        //  console.log("opening_time"+opening_timemom+"date"+ctyme_date);
                          var startingtime_booking = ctyme_date+' '+opening_timemom;
                          //console.log("startingtime_booking"+moment(startingtime_booking,"DD/MM/YYYY hh:mm A")+"----------"+startingtime_booking);
                          var bookingtimemoment = moment(startingtime_booking,"DD/MM/YYYY hh:mm A");



                        var added_oneday =  moment(getcurdttimemo_firstm,"DD/MM/YYYY hh:mm A").add(24,"hours").format("DD/MM/YYYY");
                        // alert()

                          

                          if(curentfourmoment > bookingtimemoment)
                          {
                             // alert(added_oneday);
                              $("#booking_date").data("DateTimePicker").date(added_oneday);
                              $("#booking_date").data("DateTimePicker").minDate(added_oneday);
                          }


           });


//*********added on 08-07 ends
               
        //****************Booking date change function starts here
			 //   $("#booking_date").on("dp.change", function(e)
   	// 			{
  		// 		  var ttttttt = $("#booking_date").val();
  				  
  		// 			 $("#start_time").datetimepicker({
  		// 			 format:'LT',
  		// 			 //Default:false
  		// 			 });
					 
				// 	 //***********get curent time  plus 4 hours*********starts*** 
    //             var getcurdttime = new Date();
    //             var getcurdttimemom = moment(getcurdttime).format("DD/MM/YYYY hh:mm A");
    //             var getcurdttimemomadd=moment(getcurdttimemom,"DD/MM/YYYY hh:mm A").add(4,"hours").format("DD/MM/YYYY" );
    //             var getcurdttimemomaddtime=moment(getcurdttimemom,"DD/MM/YYYY hh:mm A").add(4,"hours").format("h:mm A" );
					 
				// 	 var curplusfour = getcurdttimemomadd + "======="+getcurdttimemomaddtime;
				// 	 console.log("current time plus four "+curplusfour);
    //       // alert(getcurdttimemomadd);
				// 	 //***********get curent time  plus 4 hours*********ends***
					 
				// 	// alert(getcurdttimemomadd);
				// 	$('#booking_date').data("DateTimePicker").minDate("'"+getcurdttimemomadd+"'"); //setting as min date
				
				// 	 var startdt=$("#booking_date").val();
				//      var strtmomnty =  moment(startdt,"DD-MM-YYYY").format("DD/MM/YYYY");
				// 	 console.log("strtmomnty"+strtmomnty);
				// 	 if(getcurdttimemomadd == strtmomnty) //if booking date is 4 hours away date
				// 	 {
				// 		//console.log("same date");
    // 						$('#start_time').val('').datetimepicker('update');
    // 						$('#start_time').data("DateTimePicker").date(getcurdttimemomaddtime);
    // 						$("#start_time").datetimepicker({
    // 						format:'LT',
    // 						});
				// 	 }
					 
					 
				// });
				
			//****************Booking date change function ends here	
				
				
				
				
				//*************start date chage function starts here
					 
					 $("#start_time").on("dp.change", function(e)
					 {
					   $("#start_time").data("DateTimePicker").maxDate("11:59 PM");
					 
					 
					 //***********get curent time  plus 4 hours*********starts*** 
				   var getcurdttime = new Date();
					 var getcurdttimemom = moment(getcurdttime).format("DD/MM/YYYY hh:mm A");
					 var getcurdttimemomadd=moment(getcurdttimemom,"DD/MM/YYYY hh:mm A").add(4,"hours").format("DD/MM/YYYY" );
					 var getcurdttimemomaddtime=moment(getcurdttimemom,"DD/MM/YYYY hh:mm A").add(4,"hours").format("h:mm A" );
					 
					 var curplusfour = getcurdttimemomadd+' '+getcurdttimemomaddtime;
					 var curplusfourmoment = moment(curplusfour);
					// console.log("current time plus four "+curplusfour);
					 //***********get curent time  plus 4 hours*********ends***
					
					//***************booking date value	starts		 
					 var bkngdt=$("#booking_date").val();
				     var strtmomnty =  moment(bkngdt,"DD-MM-YYYY").format("DD/MM/YYYY");
					 //console.log("strtmomnty"+strtmomnty);
					 //***************booking date value*********ends
					 
					 //**********start time value starts
					 var strtimvl = $("#start_time").val();
					 var strtmomntym =  moment(strtimvl,"h:mm A").format("h:mm A");
					// console.log("strtmomntym time"+strtmomnty+"***************"+strtmomntym);
					 
					 bookingtimetotal = strtmomnty+' '+strtmomntym;
					 bookingtimemoment = moment(bookingtimetotal)
					 //***********start time value ends
 					//**********checking if booking moment is less than curent time plus four hours starts
					//console.log("bookingtimemoment ============> "+bookingtimemoment);
					//console.log("curplusfourmoment ============> "+curplusfourmoment);
					if (bookingtimemoment < curplusfourmoment)
					{
                        
						$("#start_time").data("DateTimePicker").date(getcurdttimemomaddtime);
                    }
					
					//*********subtract four hours from booking date and time starts
					var bokingtimetobesubtract = strtmomnty+' '+strtmomntym;
					var bookingdatetimesubtract = moment(bokingtimetobesubtract,"DD/MM/YYYY h:mm A").subtract(4,"hours").format("DD/MM/YYYY h:mm A" );
					var bookingtimesubtract = moment(bokingtimetobesubtract,"DD/MM/YYYY h:mm A").subtract(4,"hours").format("h:mm A" );
					var bookingdatesubtract = moment(bokingtimetobesubtract,"DD/MM/YYYY h:mm A").subtract(4,"hours").format("DD/MM/YYYY" );
					
				//	console.log("Subtracted datetime is=========>"+bookingdatetimesubtract);
					//*********subtract four hours from bôking date and time ends
				//	console.log("Booking date and booking time is=========> "+strtmomnty+"===="+strtmomntym);
					
					//**********checking if booking moment is less than curent time plus four hours ends
								 
						//*********place the value in request expired date and time section starts
						$("#requestexpireddate").data("DateTimePicker").maxDate(bookingdatesubtract);
						$("#requestexpireddate").data("DateTimePicker").minDate(getcurdttimemomadd);
						//$("#requestexpireddate").data("DateTimePicker").maxDate('14/06');
						//$("#requestexpiredtime").data("DateTimePicker").date(bookingdatetimesubtract);
						//*********place the value in request expired date and time section ends
								 
								 
							//***********setting request expire time into null
                  $('#end_time').val('').datetimepicker('update');
                  $('#end_time').data("DateTimePicker").date(null);
                  $("#end_time").datetimepicker({
                  format:'LT',
                  //autoclose: false,
                  Default:false
                  });
              //***********setting request expire time into null

              //***************setting up of opening time
              if(opening_time!='00:00:00')
              {
                    var mmmnt_openingtime=moment(opening_time,"hh:mm A").format('h:mm A');
                    var strtmomntym_moment = moment(strtmomntym,"hh:mm A");
                    var gtmomentopng_time = moment(mmmnt_openingtime,"hh:mm A");

                  
                    // console.log("starttime moment is"+strtmomntym_moment+"strtmomntym"+strtmomntym);
                    // console.log("to be set time moment is"+gtmomentopng_time+"to be set "+mmmnt_openingtime);

                    if(strtmomntym_moment < gtmomentopng_time)
                    {
                       //console.log("asdasdsad asdsad");
                      $("#start_time").data("DateTimePicker").date(mmmnt_openingtime);
                    }
              }
            
              //***************setting up of opening time

              //***********set up for closing time
              $("#end_time").data("DateTimePicker").date("00:30");
               if(closing_time!='00:00:00')
              {
                    var mmmnt_openingtime=moment(opening_time,"hh:mm A").format('h:mm A');
                    var mmmnt_closingtime=moment(closing_time,"HH:mm").format('HH:mm');

                    var ctyme_crntdate = new Date();
                    var ctyme_dattime = ctyme_crntdate.setDate(ctyme_crntdate.getDate());
                    var ctyme_datetim = moment(ctyme_dattime).format("DD/MM/YYYY");

                    var currentdate_opn = ctyme_datetim+" "+mmmnt_openingtime;


                   // alert(currentdate_opn+"mmmnt_closingtime"+mmmnt_closingtime);
                    var resultsplit = mmmnt_closingtime.split(':');
                    var addcompleteddate=moment(currentdate_opn,"DD/MM/YYYY hh:mm A").add(resultsplit[0],"hours").format("DD/MM/YYYY hh:mm A" );
                    var addcompletedtime=moment(addcompleteddate,"DD/MM/YYYY hh:mm A").add(resultsplit[1],"m").format("DD/MM/YYYY hh:mm A" );
                    var sub_complettim = moment(addcompletedtime,"DD/MM/YYYY hh:mm A").subtract(30,"m").format("hh:mm A" );
                    

                    var startingtime_moment = moment(ctyme_datetim+" "+sub_complettim,"DD/MM/YYYY hh:mm A");

                     //alert(startingtime_moment);

                     var t  = moment(sub_complettim,"hh:mm A");
                   //  alert("t is "+t+"-------------========="+sub_complettim);
                       opntim_moment = moment(opening_time,"hh:mm A");
                       if(opntim_moment < t)
                       {
                         $("#start_time").data("DateTimePicker").maxDate(sub_complettim);
                       }

                   //  $("#start_time").data("DateTimePicker").maxDate(sub_complettim);

                    // $("#start_time").data("DateTimePicker").date(sub_complettim);

                  //  alert(sub_complettim);
                  // alert("mmmnt_closingtime"+mmmnt_closingtime);


                      var strtimvl_selected = $("#start_time").val();
                      var strtmomntym_selected =  moment(strtimvl_selected,"h:mm A").format("hh:mm A");




                    var strtmomntym_moment = moment(strtmomntym_selected,"hh:mm A");
                    var gtmomentopng_time = moment(mmmnt_openingtime,"hh:mm A");

                  
                    // console.log("starttime moment is"+strtmomntym_moment+"strtmomntym"+strtmomntym);
                    // console.log("to be set time moment is"+gtmomentopng_time+"to be set "+mmmnt_openingtime);

                    // alert("strtmomntym_moment========>"+strtmomntym_moment+"t===========>"+mmmnt_openingtime);

                    if(strtmomntym_moment > t)
                    {
                      // console.log("asdasdsad asdsad"+sub_complettim);
                      // $("#start_time").data("DateTimePicker").date(sub_complettim); 
                       $("#start_time").data("DateTimePicker").minDate(mmmnt_openingtime);
                       $("#start_time").data("DateTimePicker").maxDate(sub_complettim);
                    }
              }
               // $("#end_time").data("DateTimePicker").date("00:30");
               // $("#end_time").val(00:30');
      
              //***********set up for closing time
                // $('#end_time').val('').datetimepicker('update');
                // $('#end_time').data("DateTimePicker").date(null);
                // $("#end_time").datetimepicker({
                // format:'HH:mm',
                // //autoclose: false,
                // Default:30
                // });
               $("#end_time").data("DateTimePicker").date("00:30");
								
						 });		 
							  $("#requestexpiredtime").on("dp.change", function(e)
							  {
								 
								 //*******************If request Expire time less than curent datetime
                              var ctyme = new Date();
                              var ctyme_dttime = ctyme.setDate(ctyme.getDate());
                              var ctyme_date = moment(ctyme_dttime).format("DD/MM/YYYY");
                              var ctyme_time = moment(ctyme_dttime).format("h:mm A");

                              var completemomentCurnt =  ctyme_date+' '+ctyme_time;

                            //  console.log("Currnt time"+completemomentCurnt);
                              completemomentCurnt = moment(completemomentCurnt);

                              //************Requestexpiredate time starts here
                                    var requestexpiresolddt = $('#requestexpireddate').val();
                                    requestexpiresolddt_moment = moment(requestexpiresolddt,"DD-MM-YYYY").format("DD/MM/YYYY");
                                    var requestexpiretime = $('#requestexpiredtime').val();
                                    requestexpiretimemoment = moment(requestexpiretime,"hh:mm A").format("h:mm A");
                                    var completemomentREqexp =  requestexpiresolddt_moment+' '+requestexpiretimemoment;
                                    completemomentREqexp =moment(completemomentREqexp);

                                    //console.log("Request Expire time"+requestexpiretimemoment);
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


                                    var splitdate = moment(subtractedcompletedtime,"DD/MM/YYYY hh:mm A").format("DD/MM/YYYY");
                                    var splittime = moment(subtractedcompletedtime,"DD/MM/YYYY hh:mm A").format("h:mm A");
								 
								              console.log("STRATTIME TOTAL=============>"+subtractedcompletedtime+"   "+requestexpiresolddt);
                              console.log("splitdate==>"+splitdate+"splittime"+splittime+"requestexpiresolddt"+requestexpiresolddt);

                              $("#requestexpiredtime").data("DateTimePicker").minDate("12:00 AM");
                              if(splitdate ==  requestexpiresolddt)
                              {
                                $("#requestexpiredtime").data("DateTimePicker").maxDate(splittime);
                              }else
                              {
                                $("#requestexpiredtime").data("DateTimePicker").maxDate("11:59 PM");
                              }
								 
                  								 //  if(completemomentREqexp > subtractedtime)
                  								 // {
                           //          alert('hello');
                  									// $("#requestexpiredtime").data("DateTimePicker").date(subtractedtime);
                  								 // }
                  								 
								
							  });
								
								 //$('#requestexpiredtime').data("DateTimePicker").maxDate(prevstime5hrsback);
							
								  $("#end_time").on("dp.change", function(e)
                 {

                  //**********chk starttimeval and booking date val
                  var strt_timeval = $("#start_time").val();
                  var bookingdate_val = $("#booking_date").val();
                 // alert(strt_timeval);

                  if(strt_timeval=="" || bookingdate_val=="")
                  {
                      //  alert("hello");
                        $("#end_time").datetimepicker({
                        format:'HH:mm',
                        // maxDate:subtraction_res_minutes,
                        });
                        $("#end_time").val('');
                  }

                  //alert(closing_time);
                    
                             //  var  endtmval = $('#start_time').val();


                                // var startdatedata=$("#booking_date").val();
                                // var mmmntstartdate=moment(startdatedata,"DD-MM-YYYY").format("DD/MM/YYYY");


                                var mmdata1=$("#start_time").val();
                                var mmmntstarttime=moment(mmdata1,"hh:mm A").format('h:mm A');

                                // var completemomenttobesubtracetd =  moment(mmmntstartdate+' '+mmmntstarttime);
                                // console.log("moment is "+completemomenttobesubtracetd);


                                // var mmdata2=$("#end_time").val();
                                // var mmmntendtime=moment(mmdata2,"hh:mm A").format('h:mm A');

                                //  var completemomenttobesubtracetdwith =  moment(mmmntstartdate+' '+mmmntendtime);
                                // console.log("moment is end time "+(completemomenttobesubtracetdwith));

                                // if(completemomenttobesubtracetdwith < completemomenttobesubtracetd)
                                // {
                                //     console.log("moment is end time with less"+completemomenttobesubtracetdwith);
                                //     console.log("moment is "+completemomenttobesubtracetd);

                                //   console.log("going to wrong");
                                //    $("#end_time").data("DateTimePicker").date(mmmntstarttime);
                                // }





                                //*************for closing time venue
                                    // if(closing_time!="00:00:00")
                                    // {
                                    //   console.log("closing time showing"+closing_time);
                                    //   var mmmnt_closingtime=moment(closing_time,"hh:mm A").format('h:mm A');
                                      
                                    //   var gtmomentoclosing_time = moment(mmmnt_closingtime,"hh:mm A");

                                    //   var completemomenttobeset =  mmmntstartdate+' '+mmmnt_closingtime;
                                    //   var completemomenttobeset_moment = moment(completemomenttobeset);

                                    //   var completemomenttobesubtracetdwith =  mmmntstartdate+' '+mmmntendtime;
                                    //   var endmomntym_moment = moment(completemomenttobesubtracetdwith);
                                     


                                    //   console.log("end time moment is"+endmomntym_moment+"strtmomntym"+mmmntendtime);
                                    //   console.log("to be set time moment is"+gtmomentoclosing_time+"to be set "+mmmnt_closingtime);

                                    //   if(endmomntym_moment > completemomenttobeset_moment)
                                    //   {
                                    //   console.log("going to wrong again");
                                    //   $("#end_time").data("DateTimePicker").date(mmmnt_closingtime);
                                    //   }
                                    // }
                                //*************for closing time venue


                                //**************** 09-07

                                    var bkng_datedata=$("#booking_date").val();
                                    var mmmntbkng_datedata=moment(bkng_datedata,"DD/MM/YYYY").format("DD/MM/YYYY");


                                    var closingtimeget = moment(closing_time,'hh:mm:ss').format('HH:mm');
                                    var starttimeselected = moment(mmmntstarttime,"hh:mm A").format("HH:mm"); //******* mmmntstarttime is start time moment


                                    //  alert(opening_time+"============="+closing_time+"start time selected"+starttimeselected);
                                      var mmmnt_openingtime=moment(opening_time,"HH:mm").format('HH:mm');
                                      var gtmomentopng_time = moment(mmmnt_openingtime,"HH:mm");

                                    // console.log("gtmomentopng_time"+mmmnt_openingtime);

                                   //  alert(mmmnt_openingtime+"wew"+mmmntbkng_datedata+" "+mmmnt_openingtime+"closingtimeget"+closingtimeget);

                                     var result = closingtimeget.split(':');
                                     //  alert(result[0]+"======"+result[1]);
                                     //****complete date and time to be calculated
                                   // alert(mmmntbkng_datedata+' '+mmmnt_openingtime);

                                     var compltedatetime = moment(mmmntbkng_datedata+" "+mmmnt_openingtime,"DD/MM/YYYY HH:mm");
                                 // alert(compltedatetime);

                                     var added_date = moment(compltedatetime,"DD/MM/YYYY HH:mm").add(result[0],"hours").format("DD/MM/YYYY HH:mm" );
                                     var added_time = moment(added_date,"DD/MM/YYYY HH:mm").add(result[1],"m").format("DD/MM/YYYY HH:mm" );
                                    
                                    // var t =  (compltedatetime);
                                     //alert(added_time);
                                    //var hh = moment(added_time,"DD/MM/YYYY HH:mm");
                                    //  $("#end_time").data("DateTimePicker").minDate('00:30');
                                    // $("#end_time").data("DateTimePicker").maxDate(closingtimeget);


                            //************get hours minutes difference in seconds starts javascript
                                        // var startTime = new Date('2016/07/09 18:00'); 
                                        // var endTime = new Date('2016/07/09 18:00');
                                        // var difference = endTime.getTime() - startTime.getTime(); // This will give difference in milliseconds
                                        // var resultInMinutes = Math.round(difference / 60000);
                                       // alert(resultInMinutes);

                                        // var sec_num = parseInt(resultInMinutes, 10); // don't forget the second param
                                        // var hours   = Math.floor(sec_num / 3600);
                                        // var minutes = Math.floor((sec_num - (hours * 3600)) / 60);
                                        // var seconds = sec_num - (hours * 3600) - (minutes * 60);

                                        // if (hours   < 10) {hours   = "0"+hours;}
                                        // if (minutes < 10) {minutes = "0"+minutes;}
                                        // if (seconds < 10) {seconds = "0"+seconds;}
                                      //  alert(hours+':'+minutes+':'+seconds);



                                        //********** venues own defined start time

                                        if(closing_time!='00:00:00')
                                        {

                                          closingtimeget_new = moment(closingtimeget,"HH:mm").add(0,'m').format("HH:mm");

                                               // alert(closingtimeget);
                                                      var venuebookingdate = $("#booking_date").val();
                                                      var venuebookingtime = $("#start_time").val();
                                                      var venuebookingtime_24_format = moment(venuebookingtime,"hh:mm A").format("HH:mm");
                                                      //alert(venuebookingdate+"======="+venuebookingtime+"==========="+venuebookingtime_24_format+"============"+mmmnt_openingtime);

                                                      // convert into javascript format
                                                      var venuebooking_date = moment(venuebookingdate,"DD/MM/YYYY").format("YYYY/MM/DD");
                                                     
                                                      var venuebooking_datetime = venuebooking_date+" "+venuebookingtime_24_format;
                                                      var venue_defineddatetime = venuebooking_date+" "+mmmnt_openingtime;
                                                      //alert(venue_defineddatetime);

                                                      var startTime_venue_defineddatetime = new Date(venue_defineddatetime); 
                                                      var endTime_venuebooking_datetime = new Date(venuebooking_datetime);
                                                      var difference = endTime_venuebooking_datetime.getTime() - startTime_venue_defineddatetime.getTime(); // This will give difference in milliseconds
                                                      var resultInMinutes = Math.round(difference / 60000);
                                                      // alert(resultInMinutes);


                                                      var sec_num = parseInt(resultInMinutes, 10); // don't forget the second param
                                                      var hours   = Math.floor(sec_num / 3600);
                                                      var minutes = Math.floor((sec_num - (hours * 3600)) / 60);
                                                      var seconds = sec_num - (hours * 3600) - (minutes * 60);

                                                      if (hours   < 10) {hours   = "0"+hours;}
                                                      if (minutes < 10) {minutes = "0"+minutes;}
                                                      if (seconds < 10) {seconds = "0"+seconds;}
                                         // seconds = seconds-1;
                                           //alert(hours+':'+minutes+':'+seconds);

                                           //********after subtraction time will be
                                                      var subtraction_res_hours = moment(closingtimeget_new,"HH:mm").subtract(minutes,'hours').format("HH:mm");
                                                      var subtraction_res_minutes = moment(subtraction_res_hours,"HH:mm").subtract(seconds,'m').format("HH:mm");
                                                      var substractionmoment = moment(subtraction_res_minutes,"HH:mm");
                                                      //console.log("end_time=======>"+substractionmoment+subtraction_res_minutes);
                                                       var  endtimeval = $('#end_time').val();

                                                      var endtimeval_moment = moment(endtimeval,"HH:mm");
                                                      if(endtimeval_moment > substractionmoment){
                                                       //alert(endtimeval);
                                                       $("#end_time").data("DateTimePicker").date(subtraction_res_minutes);
                                                      }

                                                      // alert(subtraction_res_minutes);
                                                      if(subtraction_res_minutes !='00:00')
                                                      {
                                                      //  alert('hello 00:00');
                                                            $("#end_time").datetimepicker({
                                                            format:'HH:mm',
                                                           // maxDate:subtraction_res_minutes,
                                                            });

                                                      //  $("#end_time").data("DateTimePicker").date(subtraction_res_minutes);

                                                        // $("#end_time").data("DateTimePicker").maxDate(subtraction_res_minutes);
                                                        $("#end_time").data("DateTimePicker").maxDate(subtraction_res_minutes);
                                                        $("#end_time").data("DateTimePicker").minDate("00:30");

                                                      }
                                                      else
                                                      {
                                                       $("#end_time").data("DateTimePicker").maxDate("23:45");
                                                       $("#end_time").data("DateTimePicker").minDate("00:30");
                                                          //$("#end_time").data("DateTimePicker").maxDate(closingtimeget);
                                                          //alert('hello');
                                                          // $("#end_time").datetimepicker({
                                                          //    format:'HH:mm',
                                                          //   // maxDate:subtraction_res_minutes,
                                                          //    });

                                                          // $('#end_time').data("DateTimePicker").disabledTimeIntervals(
                                                          // [moment({ h: 00,m: 00 }), moment({ h: 00,m: 30 })]
                                                          // )
                                                      }

                                              }
                                              else
                                              {
                                                //***********this section is for minimum booking time
                                                $("#end_time").data("DateTimePicker").minDate("00:30");
                                                $("#end_time").data("DateTimePicker").maxDate("23:46");
                                               // $('#end_time').data("DateTimePicker").disabledTimeIntervals(
                                               //            [moment({ h: 00,m: 00 }), moment({ h: 00,m: 30 })] );
                                              }
                                          

                            //************get hours minutes difference in seconds starts javascript

                                 //   alert(hh);

                                  //  alert(starttimeselected);
                                //****************



                   
                    
                  
                 });
								 
								 
								 
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
								 


                 //***********working on 05-07-2016
                 // $("#end_time").on("dp.change", function(e)
                 // {
                    
                 //    var  endtmval = $('#start_time').val();


                 //                var startdatedata=$("#booking_date").val();
                 //                var mmmntstartdate=moment(startdatedata,"DD-MM-YYYY").format("DD/MM/YYYY");
                 //                var mmdata1=$("#start_time").val();
                 //                var mmmntstarttime=moment(mmdata1,"hh:mm A").format('h:mm A');

                 //                var completemomenttobesubtracetd =  mmmntstartdate+' '+mmmntstarttime;
                 //                console.log("moment is "+moment(completemomenttobesubtracetd);
                   
                    
                  
                 // });
                 
                 //***********working on 05-07-2016
								 
								 
			
               
               //**************calender js ends here************************//////////////////////////************
//****ending