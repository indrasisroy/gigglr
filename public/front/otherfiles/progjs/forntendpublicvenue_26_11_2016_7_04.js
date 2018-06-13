//********

   var security_lock_id_vnu = '';
   var booking_lock_id_vnu = '';
   var totalpay_lock_id_vnu = '';
      $("#totalpayimg_div").on("click", (function () {
		 var valuetotalpayimg = $(this).data('totalpayimgflag');
		 if (valuetotalpayimg == '0') {
		   $('#totalpayimg_div').data('totalpayimgflag',1);
		   $("#totalpayimg_div").html(lockImg);
           totalpay_lock_id_vnu = logID;
		 }else{
		   $('#totalpayimg_div').data('totalpayimgflag',0);
		   $("#totalpayimg_div").html(unlockImg);
           totalpay_lock_id_vnu = '';
		 }
	  }));
   
      $("#bookingcanimg_div").on("click", (function () {
		 var valuebookingcanimg = $(this).data('bookingcanimgflag');
		 if (valuebookingcanimg == '0') {
		   $('#bookingcanimg_div').data('bookingcanimgflag',1);
		   $("#bookingcanimg_div").html(lockImg);
           booking_lock_id_vnu = logID;
		 }else{
		   $('#bookingcanimg_div').data('bookingcanimgflag',0);
		   $("#bookingcanimg_div").html(unlockImg);
           booking_lock_id_vnu = "";
		 }
	  }));
	  
      $("#securityimg_div").on("click", (function () {
		 var valuesecurityimg = $(this).data('securityimgflag');
		 if (valuesecurityimg == '0') {
		   $('#securityimg_div').data('securityimgflag',1);
		   $("#securityimg_div").html(lockImg);
           security_lock_id_vnu = logID;
		 }else{
		   $('#securityimg_div').data('securityimgflag',0);
		   $("#securityimg_div").html(unlockImg);
           security_lock_id_vnu = '';
		 }
	  }));

//security_lock_id:security_lock_id_vnu,booking_lock_id:booking_lock_id_vnu,totalpay_lock_id:totalpay_lock_id_vnu




function checkvenuebookingavailability(j)
{
  var replysesponse = "";
  if(j == 1)
  {
    // replysesponse = "You must be logged in to continue";
    bookingmodalcheckoption = "venue-modal-open"; // for venue modal open in click into booking request without login
     $("#myModal1").modal('show');
  }
  if(j == 2)
  {
  replysesponse = "Your request can not be processed";
   toastr.remove();// Immediately remove current toasts without using animation
  poptriggerfunc(msgtype='error',titledata='',msgdata=replysesponse,sd=6000,hd=1500,tmo=3000,etmo=4000,poscls='toast-top-full-width');
  }
 if(j == 3)
 {
  replysesponse = "This venue is not available for booking";
   toastr.remove();// Immediately remove current toasts without using animation
  poptriggerfunc(msgtype='error',titledata='',msgdata=replysesponse,sd=6000,hd=1500,tmo=3000,etmo=4000,poscls='toast-top-full-width');
}

  //alert(replysesponse);
  //  toastr.remove();// Immediately remove current toasts without using animation
  // poptriggerfunc(msgtype='error',titledata='',msgdata=replysesponse,sd=6000,hd=1500,tmo=3000,etmo=4000,poscls='toast-top-full-width');

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
                              showmycustomloader(1,'2000','1000',"",imfpth);
                              
                              
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
                                },"Total payment must be higher than security deposit");
                                
                                //******************** CUSTOM FUNCTION ***************ENDS********************
                                 $.validator.addMethod("numericfieldamount", function(value, element) 
                {
                                         var characterReg = /^([0-9]*){0,}(\.\d{1,2})?$/; ///^[1-9][0-9]+(\.\d{1,2})?$/ ;
                                         return characterReg.test(value);
                },"Please enter proper numeric value");
                              //**********************FORM VALIDATION STARTS HERE ***************************
                              
                                   $("#bookingform").validate({
                                    
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
                                       errorElement: 'span',//'div',
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
                                                       // start_time_hr:{
                                                       //      required: true,
                                                       // },
                                                       //  start_time_mnt:{
                                                       //      required: true,
                                                       // },
                                                       //  end_time_hr:{
                                                       //      required: true,
                                                       // },
                                                       // end_time_mnt:{
                                                       //      required: true,
                                                       // },
                                                       start_time: {
                                                            required: true,
                                                       },
                                                       end_time:{
                                                            required: true,
                                                       },
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
                                                       // start_time_hr: {
                                                       //    required: "Please select a start time",
                                                       // },
                                                       //  start_time_mnt: {
                                                       //    required: "Please select a start time",
                                                       // },
                                                       // end_time_hr: {
                                                       //    required: "Please select a end time",
                                                       // },
                                                       //  end_time_mnt: {
                                                       //    required: "Please select a end time",
                                                       // },
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
                                   
                                   var gig_description =  $("#gig_description").val();
                                   
                                   var booking_datedata = $("#booking_date").val();
                                   


                                  var start_timedata = $("#start_time").val();

                                   //  var start_timedata_format = $("#ddlViewBy").val();
                                   //  var starttimehr_val = $("#start_time_hr").val();
                                   //  var starttimemin_val = $("#start_time_mnt").val();

                                   //  if(start_timedata_format == 2)
                                   //  {
                                   //    starttimehr_val = parseInt(starttimehr_val)+12;
                                   //  }

                                   // var start_timedata = starttimehr_val+ ':'+starttimemin_val;




                                   var end_timedata = $("#end_time").val();

                                    // var end_timedata_format = $("#ddlViewend").val();
                                   // var endtimehr_val = $("#end_time_hr").val();
                                   // var endtimemin_val = $("#end_time_mnt").val();

                                   //  //  if(end_timedata_format == 2)
                                   //  // {
                                   //  //   endtimehr_val = parseInt(endtimehr_val)+12;
                                   //  // }

                                   // var end_timedata = endtimehr_val+':'+endtimemin_val;


                                   var requestexpireddatedata = $("#requestexpireddate").val();


                                   var requestexpiredtimedata = $("#requestexpiredtime").val();

                                   //  var requestexpire_timedata_format = $("#ddlViewrequestexpire").val();
                                   //  var reqexpirehr = $("#requexpire_time_hr").val();
                                   //  var reqexpminval = $("#reqexpire_time_mnt").val();


                                   //  if(requestexpire_timedata_format == 2){
                                   //    reqexpirehr = parseInt(reqexpirehr)+12;
                                   //  }

                                   // var requestexpiredtimedata = reqexpirehr+':'+reqexpminval;//$("#requestexpiredtime").val();


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
                                    var bookingformdata = {_token:csrf,gig_description:gig_description,type_entry:type_entry_insert,bookingcat_subdata:bookingcat_subdata,bookinggenre_subdata:bookinggenre_subdata,security_paymentdata:security_paymentdata,total_paymentdata:total_paymentdata,cancellation_paymentdata:cancellation_paymentdata,booking_datedata:booking_datedata,start_timedata:start_timedata,end_timedata:end_timedata,requestexpireddatedata:requestexpireddatedata,requestexpiredtimedata:requestexpiredtimedata,venueownID:venueownID,security_lock_id:security_lock_id_vnu,booking_lock_id:booking_lock_id_vnu,totalpay_lock_id:totalpay_lock_id_vnu};
                                        var bookingurldata=base_url_data+"/"+"venuebookingsubmission";
                                        //console.log("Booking Form url data========>"+bookingurldata);
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
                                            poptriggerfunc(msgtype='error',titledata='',msgdata=error_message_data,sd=7000,hd=2500,tmo=3000,etmo=4000,poscls='toast-top-full-width');         

                                            }
                                            else
                                            {

                                              var imfpth=base_url_data+"/public/front/otherfiles/progimages/loder.gif"
                                              showmycustomloader(1,'4000','2000',"",imfpth);
                                              $("#cancelbtn").click(); //***modal remove
                                              var success_message_data="Thank you for your booking request! ";
                                              poptriggerfunc(msgtype='success',titledata='',msgdata=success_message_data,sd=7000,hd=2500,tmo=3000,etmo=4000,poscls='toast-top-full-width');
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
                                   // poptriggerfunc(msgtype='success',titledata='',msgdata=success_message_data,sd=6000,hd=1500,tmo=3000,etmo=4000,poscls='toast-top-full-width');
                                                     //****************************LOADER ENDS HERE****************************************
                                 
                                 //return 2;
                              }
                              else
                              {
                                   var error_message_data="Please complete your booking request! ";
                                  // poptriggerfunc(msgtype='error',titledata='',msgdata=error_message_data,sd=6000,hd=1500,tmo=3000,etmo=4000,poscls='toast-top-full-width');
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
                   $('.artist_txt').removeClass('errorField');
				   validator.resetForm();
			   
			   });
//****ending
//*********this is for booking option date time strat time and time
//****starting
            
//*********added on 08-07 starts

            // $("#end_time").datetimepicker({
            //       format:'HH:mm',
            // });
            $("#end_time").datetimepicker({
                  format:'HH:mm',
            });
            $("#end_time").data("DateTimePicker").minDate("00:30");
            $("#end_time").data("DateTimePicker").maxDate("23:59");

//*******this function is calling on bodyload------------------------**************************************
            $("document").ready(function()
            {
              //alert(showreviewornot);
              if(showreviewornot == 0)
              {
                $("#review_section").addClass("mydisplaynone");  
              }else
              {
                $("#review_section").removeClass("mydisplaynone");
              }
              

          
                                                  // var getcurdttime_first = new Date();
                                                  // var getcurdttimemo_firstm = moment(getcurdttime_first).format("DD/MM/YYYY hh:mm A");
                                                  // var getcurdttimemomadd_first=moment(getcurdttimemo_firstm,"DD/MM/YYYY hh:mm A").add(4,"hours").format("DD/MM/YYYY");
                                                  // var getcurdttimemomaddtime_ftrst=moment(getcurdttimemo_firstm,"DD/MM/YYYY hh:mm A").add(4,"hours").format("h:mm A");
                                                  // $("#booking_date").data("DateTimePicker").minDate(getcurdttimemomadd_first);

                                  var getcurdttime_first = new Date();
                                  var getcurdttimemo_firstm = moment(getcurdttime_first).format("DD/MM/YYYY hh:mm A");
                                  var getcurdttimemomadd_first=moment(getcurdttimemo_firstm,"DD/MM/YYYY hh:mm A").add(4,"hours").format("DD/MM/YYYY");
                                  var getcurdttimemomaddtime_ftrst=moment(getcurdttimemo_firstm,"DD/MM/YYYY hh:mm A").add(4,"hours").format("h:mm A");
                                  $("#booking_date").data("DateTimePicker").minDate(getcurdttimemomadd_first);
            });
                     

//*******this function is calling on booking_date change------------------------**************************************

            // $("#booking_date").on("dp.change", function(e)
            // {
            //                                                       $('#start_time').val('').datetimepicker('update');
            //                                                       $('#start_time').data("DateTimePicker").date(null);
            //                                                       $("#start_time").datetimepicker({
            //                                                       format:'LT',
            //                                                       //Default:false
            //                                                       });

            //                                 // if(opening_time!='00:00:00')
            //                                 //       {
            //                                                       var getcurdttime_first = new Date();
            //                                                       var getcurdttimemo_firstm = moment(getcurdttime_first).format("DD/MM/YYYY hh:mm A");
            //                                                       var getcurdttimemomadd_first=moment(getcurdttimemo_firstm,"DD/MM/YYYY hh:mm A").add(4,"hours").format("DD/MM/YYYY");
            //                                                       var getcurdttimemomaddtime_ftrst=moment(getcurdttimemo_firstm,"DD/MM/YYYY hh:mm A").add(4,"hours").format("h:mm A");
            //                                                       var curentfourmoment = moment(getcurdttimemomadd_first+'  '+getcurdttimemomaddtime_ftrst,"DD/MM/YYYY hh:mm A");
            //                                                       var opening_timemom = moment(opening_time,"HH:mm").format("hh:mm A");
            //                                                       var ctyme = $("#booking_date").val();
            //                                                       var ctyme_date = moment(ctyme,"DD/MM/YYYY").format("DD/MM/YYYY");
            //                                                       var startingtime_booking = ctyme_date+' '+opening_timemom;

            //                                                       var bookingtimemoment = moment(startingtime_booking,"DD/MM/YYYY hh:mm A");
            //                                                       var added_oneday =  moment(getcurdttimemo_firstm,"DD/MM/YYYY hh:mm A").add(24,"hours").format("DD/MM/YYYY");
                                                                
            //                                                       if(curentfourmoment > bookingtimemoment)
            //                                                       {
            //                                                       // alert(added_oneday);
            //                                                       $("#booking_date").data("DateTimePicker").date(added_oneday);
            //                                                       $("#booking_date").data("DateTimePicker").minDate(added_oneday);
            //                                                       }
            //                                     //    }


            // });


//*********added on 08-07 ends
               
      	
				
				
				
				
				//*************start date chage function starts here
					 
					 // $("#start_time").on("dp.change", function(e)
					 // {



      //                                                             var strtdtaetime =   moment().format('DD/MM/YYYY hh:mm A');
      //                                                             var strtdtaetime_date = moment(strtdtaetime,"DD/MM/YYYY hh:mm A").add(4,'hours').format("DD/MM/YYYY");
      //                                                             var strtdtaetime_time = moment(strtdtaetime,"DD/MM/YYYY hh:mm A").add(4,'hours').format("hh:mm A");



      //                                                             var crntdate = moment().format('DD/MM/YYYY');
      //                                                             var crnttime = moment().format('hh:mm A');

      //                                                             var start_time_gig = $('#start_time').val();
      //                                                             var r =  moment(start_time_gig,"hh:mm A");

      //                                                             var l = moment(strtdtaetime_time,"hh:mm A"); //*** crnttime

      //                                                             var strttime = $("#booking_date").val();


      //                                                             if(strttime == strtdtaetime_date)
      //                                                             {
      //                                                             // console.log('hurray!!!!!!!!!!');
      //                                                                 if(r < l)
      //                                                                 {
      //                                                                 // console.log('ererre!!!!!!!!!!');
      //                                                                    $("#start_time").data("DateTimePicker").date(strtdtaetime_time);
      //                                                                 }
      //                                                             }


      //                                                             if(opening_time!='00:00:00')
      //                                                             {

      //                                                                   var strtimvl = $("#start_time").val();
      //                                                                   var strtmomntym =  moment(strtimvl,"h:mm A").format("h:mm A");
      //                                                                   var mmmnt_openingtime=moment(opening_time,"hh:mm A").format('h:mm A');
      //                                                                   var strtmomntym_moment = moment(strtmomntym,"hh:mm A");
      //                                                                   var gtmomentopng_time = moment(mmmnt_openingtime,"hh:mm A");

      //                                                                   if(strtmomntym_moment < gtmomentopng_time)
      //                                                                   {
      //                                                                     $("#start_time").data("DateTimePicker").date(mmmnt_openingtime);
      //                                                                   }
      //                                                             }

      //                                                             if(closing_time!='00:00:00')
      //                                                             {
      //                                                                   var mmmnt_opentime=moment(opening_time,"hh:mm A").format('h:mm A');
      //                                                                   var mmmnt_closeime=moment(closing_time,"HH:mm").format('HH:mm');
      //                                                                   var today_date = moment().format('DD/MM/YYYY');
      //                                                                   var bookign_date = $("#booking_date").val();
      //                                                                   var bking_datetime = bookign_date+' '+mmmnt_opentime;

      //                                                                   var resultsplit = mmmnt_closeime.split(':');
      //                                                                   var addcompleteddate=moment(bking_datetime,"DD/MM/YYYY h:mm A").add(resultsplit[0],"hours").format("DD/MM/YYYY h:mm A" );
      //                                                                   var addcompletedtime=moment(addcompleteddate,"DD/MM/YYYY h:mm A").add(resultsplit[1],"m").format("DD/MM/YYYY hh:mm A" );
      //                                                                   var sub_complettim = moment(addcompletedtime,"DD/MM/YYYY h:mm A").subtract(30,"m").format("hh:mm A" );

      //                                                                   //****
      //                                                                   //alert(addcompletedtime); 
      //                                                                   // var indrasis = moment(addcompletedtime,"DD/MM/YYYY hh:mm A");
      //                                                                   // alert(indrasis);

      //                                                                   //****

      //                                                                   var completedate = moment(addcompletedtime,"DD/MM/YYYY h:mm A").format("DD/MM/YYYY");
      //                                                                  if(completedate == bookign_date)
      //                                                                  {
      //                                                                   var sub_complettim_mom = moment(sub_complettim,"hh:mm A");
      //                                                                   var strttime_vl = $("#start_time").val();
      //                                                                   var strttime_vl_format = moment(strttime_vl,"hh:mm A").format("hh:mm A");
      //                                                                   var strttime_vl_moment = moment(strttime_vl_format,"hh:mm A");
      //                                                                   // console.log("strttime_vl -----------------> "+strttime_vl+" and the moment is -------------------->"+strttime_vl_moment);
      //                                                                   // console.log("----------------------We are in same date and time before ending is ------------------"+sub_complettim+"moment is --------->"+sub_complettim_mom);
      //                                                                       if(strttime_vl_moment > sub_complettim_mom)
      //                                                                       {
      //                                                                         $("#start_time").data("DateTimePicker").date(sub_complettim);
      //                                                                       }
      //                                                                  }else
      //                                                                  {
      //                                                                    //console.log("----------------------We are not in same date ------------------");
                                                                       
      //                                                                             var strttmvalue = $("#start_time").val();
      //                                                                             var othertime = bookign_date+' '+strttmvalue;
      //                                                                             //console.log("othertime"+othertime);
      //                                                                             var othrttimemoment = moment(strttmvalue,"hh:mm A");
                                                                                 
      //                                                                             var sub_complettim_datetime = moment(addcompletedtime,"DD/MM/YYYY h:mm A").subtract(30,"m").format("DD/MM/YYYY  hh:mm A" );
      //                                                                             //console.log("sub_complettim_datetime"+sub_complettim_datetime);
      //                                                                             var sub_complettim_date = moment(addcompletedtime,"DD/MM/YYYY h:mm A").subtract(30,"m").format("DD/MM/YYYY" );
      //                                                                             var sub_complettim_time = moment(addcompletedtime,"DD/MM/YYYY h:mm A").subtract(30,"m").format("hh:mm A" );

      //                                                                             var sub_complettim_ime_only = moment(sub_complettim_time,"hh:mm A");

      //                                                                                 if(bookign_date == sub_complettim_date)
      //                                                                                 {
      //                                                                                         //console.log("I am Running");
      //                                                                                         if(othrttimemoment > sub_complettim_ime_only)
      //                                                                                         {
      //                                                                                         $("#start_time").data("DateTimePicker").date(sub_complettim_time);
      //                                                                                         //******
      //                                                                                         //console.log("I am Running");

      //                                                                                         }
      //                                                                                 }

                                                                            
      //                                                                  }
      //                                                                  // var fourhr = moment(bking_datetime,"DD/MM/YYYY h:mm A").add()

      //                                                             }
                                                                 


      //                                                             $('#end_time').val('').datetimepicker('update');
      //                                                             $('#end_time').data("DateTimePicker").date(null);
      //                                                             $("#end_time").datetimepicker({
      //                                                             format:'LT',
      //                                                             });


      //                                                             $('#requestexpireddate').val('').datetimepicker('update');
      //                                                             $('#requestexpireddate').data("DateTimePicker").date(null);
      //                                                             $("#requestexpireddate").datetimepicker({
      //                                                             format:'DD/MM/YYYY',
      //                                                             //   Default:false
      //                                                             });

      //                                                             $("#end_time").data("DateTimePicker").date("00:30");

                                        
      //                                                                              //$("#end_time").data("DateTimePicker").date("00:30");
								
						//  });	
              

             
								
								 //$('#requestexpiredtime').data("DateTimePicker").maxDate(prevstime5hrsback);
							
                // $("#end_time").on("dp.change", function(e)
                // {

                //                                                         //**********chk starttimeval and booking date val
                //                                                         var strt_timeval = $("#start_time").val();
                //                                                         var bookingdate_val = $("#booking_date").val();
                //                                                         // alert(strt_timeval);

                //                                                         if(strt_timeval=="" || bookingdate_val=="")
                //                                                         {
                //                                                         //  alert("hello");
                //                                                         $("#end_time").datetimepicker({
                //                                                         format:'HH:mm',
                //                                                         // maxDate:subtraction_res_minutes,
                //                                                         });
                //                                                         $("#end_time").val('');
                //                                                         }




                //                                                         var mmdata1=$("#start_time").val();
                //                                                         var mmmntstarttime=moment(mmdata1,"hh:mm A").format('h:mm A');



                //                                                         var bkng_datedata=$("#booking_date").val();
                //                                                         var mmmntbkng_datedata=moment(bkng_datedata,"DD/MM/YYYY").format("DD/MM/YYYY");


                //                                                         var closingtimeget = moment(closing_time,'hh:mm:ss').format('HH:mm');
                //                                                         var starttimeselected = moment(mmmntstarttime,"hh:mm A").format("HH:mm"); //******* mmmntstarttime is start time moment


                //                                                         //  alert(opening_time+"============="+closing_time+"start time selected"+starttimeselected);
                //                                                         var mmmnt_openingtime=moment(opening_time,"HH:mm").format('HH:mm');
                //                                                         var gtmomentopng_time = moment(mmmnt_openingtime,"HH:mm");



                //                                                         var result = closingtimeget.split(':');


                //                                                         var compltedatetime = moment(mmmntbkng_datedata+" "+mmmnt_openingtime,"DD/MM/YYYY HH:mm");


                //                                                         var added_date = moment(compltedatetime,"DD/MM/YYYY HH:mm").add(result[0],"hours").format("DD/MM/YYYY HH:mm" );
                //                                                         var added_time = moment(added_date,"DD/MM/YYYY HH:mm").add(result[1],"m").format("DD/MM/YYYY HH:mm" );




                //                                                         if(closing_time!='00:00:00')
                //                                                         {

                //                                                         closingtimeget_new = moment(closingtimeget,"HH:mm").add(0,'m').format("HH:mm");

                //                                                         // alert(closingtimeget);
                //                                                         var venuebookingdate = $("#booking_date").val();
                //                                                         var venuebookingtime = $("#start_time").val();
                //                                                         var venuebookingtime_24_format = moment(venuebookingtime,"hh:mm A").format("HH:mm");
                //                                                         //alert(venuebookingdate+"======="+venuebookingtime+"==========="+venuebookingtime_24_format+"============"+mmmnt_openingtime);

                //                                                         // convert into javascript format
                //                                                         var venuebooking_date = moment(venuebookingdate,"DD/MM/YYYY").format("YYYY/MM/DD");

                //                                                         var venuebooking_datetime = venuebooking_date+" "+venuebookingtime_24_format;
                //                                                         var venue_defineddatetime = venuebooking_date+" "+mmmnt_openingtime;
                //                                                         //alert(venue_defineddatetime);

                //                                                         var startTime_venue_defineddatetime = new Date(venue_defineddatetime); 
                //                                                         var endTime_venuebooking_datetime = new Date(venuebooking_datetime);
                //                                                         var difference = endTime_venuebooking_datetime.getTime() - startTime_venue_defineddatetime.getTime(); // This will give difference in milliseconds
                //                                                         var resultInMinutes = Math.round(difference / 60000);
                //                                                         // alert(resultInMinutes);


                //                                                         var sec_num = parseInt(resultInMinutes, 10); // don't forget the second param
                //                                                         var hours   = Math.floor(sec_num / 3600);
                //                                                         var minutes = Math.floor((sec_num - (hours * 3600)) / 60);
                //                                                         var seconds = sec_num - (hours * 3600) - (minutes * 60);

                //                                                         if (hours   < 10) {hours   = "0"+hours;}
                //                                                         if (minutes < 10) {minutes = "0"+minutes;}
                //                                                         if (seconds < 10) {seconds = "0"+seconds;}
                //                                                         // seconds = seconds-1;
                //                                                         //alert(hours+':'+minutes+':'+seconds);

                //                                                         //********after subtraction time will be
                //                                                         var subtraction_res_hours = moment(closingtimeget_new,"HH:mm").subtract(minutes,'hours').format("HH:mm");
                //                                                         var subtraction_res_minutes = moment(subtraction_res_hours,"HH:mm").subtract(seconds,'m').format("HH:mm");
                //                                                         var substractionmoment = moment(subtraction_res_minutes,"HH:mm");
                //                                                         //console.log("end_time=======>"+substractionmoment+subtraction_res_minutes);
                //                                                         var  endtimeval = $('#end_time').val();

                //                                                         var endtimeval_moment = moment(endtimeval,"HH:mm");
                //                                                         if(endtimeval_moment > substractionmoment){
                //                                                         //alert(endtimeval);
                //                                                         $("#end_time").data("DateTimePicker").date(subtraction_res_minutes);
                //                                                         }

                //                                                         // alert(subtraction_res_minutes);
                //                                                         if(subtraction_res_minutes !='00:00')
                //                                                         {
                //                                                         //  alert('hello 00:00');
                //                                                         $("#end_time").datetimepicker({
                //                                                         format:'HH:mm',
                //                                                         // maxDate:subtraction_res_minutes,
                //                                                         });

                //                                                         //  $("#end_time").data("DateTimePicker").date(subtraction_res_minutes);

                //                                                         // $("#end_time").data("DateTimePicker").maxDate(subtraction_res_minutes);
                //                                                         $("#end_time").data("DateTimePicker").maxDate(subtraction_res_minutes);
                //                                                         $("#end_time").data("DateTimePicker").minDate("00:30");

                //                                                         }
                //                                                         else
                //                                                         {
                //                                                         // $("#end_time").data("DateTimePicker").maxDate("23:45");
                //                                                         // $("#end_time").data("DateTimePicker").minDate("00:30");
                //                                                         //$("#end_time").data("DateTimePicker").maxDate(closingtimeget);
                //                                                         //alert('hello');
                //                                                         // $("#end_time").datetimepicker({
                //                                                         //    format:'HH:mm',
                //                                                         //   // maxDate:subtraction_res_minutes,
                //                                                         //    });

                //                                                         // $('#end_time').data("DateTimePicker").disabledTimeIntervals(
                //                                                         // [moment({ h: 00,m: 00 }), moment({ h: 00,m: 30 })]
                //                                                         // )
                //                                                         }

                //                                                       }
                //                                                       else
                //                                                       {
                //                                                       //***********this section is for minimum booking time
                //                                                     /*  $("#end_time").data("DateTimePicker").minDate("00:30");
                //                                                       $("#end_time").data("DateTimePicker").maxDate("23:46");*/
                //                                                       // $('#end_time').data("DateTimePicker").disabledTimeIntervals(
                //                                                       //            [moment({ h: 00,m: 00 }), moment({ h: 00,m: 30 })] );
                //                                                       }


                //                                                       //************get hours minutes difference in seconds starts javascript

                //                                                       //   alert(hh);

                //                                                       //  alert(starttimeselected);
                //                                                       //****************






                // });


								 
								  //*************start date chage function ends here

               

                    // $("#requestexpiredtime").on("dp.change", function (e)
                    // {

                    //                                                       var crntdate = moment().format('DD/MM/YYYY');
                    //                                                       var crnttime = moment().format('hh:mm A');

                    //                                                       var end_time_gig = $('#requestexpiredtime').val();
                    //                                                       var r =  moment(end_time_gig,"hh:mm A");


                    //                                                       var l = moment(crnttime,"hh:mm A");

                    //                                                       var strttime = $("#requestexpireddate").val();


                    //                                                       if(strttime == crntdate)
                    //                                                       {
                    //                                                       if(r < l)
                    //                                                       {
                    //                                                       // alert('hello');
                    //                                                       $("#requestexpiredtime").data("DateTimePicker").date(crnttime);
                    //                                                       }

                    //                                                       }


                    //                                                       var bookingreqdate = $("#booking_date").val();
                    //                                                       // // console.log("bookingreqdate"+bookingreqdate);
                    //                                                       var strt_time_gig = $('#start_time').val();
                    //                                                       //  //console.log("strt_time_gig"+strt_time_gig);

                    //                                                       var ttmoment = bookingreqdate+' '+strt_time_gig;

                    //                                                       // console.log("ttmoment"+ttmoment);

                    //                                                       var fourhrmoment_before_date = moment(ttmoment,"DD/MM/YYYY hh:mm A").subtract(4,'hours').format("DD/MM/YYYY");
                    //                                                       var fourhrmoment_before_time = moment(ttmoment,"DD/MM/YYYY hh:mm A").subtract(4,'hours').format("hh:mm A");

                    //                                                       //  console.log("fourhrmoment_before_date"+fourhrmoment_before_date+"fourhrmoment_before_time"+fourhrmoment_before_time);
                    //                                                       fourhour_span = moment(fourhrmoment_before_time,"hh:mm A");

                    //                                                       if(fourhrmoment_before_date == strttime)
                    //                                                       {
                    //                                                       //console.log('date matched'+fourhour_span);
                    //                                                       if(r > fourhour_span)
                    //                                                       {
                    //                                                       // console.log("in this section");
                    //                                                       $("#requestexpiredtime").data("DateTimePicker").date(fourhrmoment_before_time);
                    //                                                       }
                    //                                                       //else
                    //                                                       // {
                    //                                                       //   $("#requestexpiredtime_gig").data("DateTimePicker").date(end_time_gig);
                    //                                                       // }
                    //                                                       }




                    // })

								
                                                              // $('#requestexpireddate').datetimepicker({
                                                              // format:'DD/MM/YYYY',
                                                              // });
                                                              // var strdt = moment().format('DD/MM/YYYY');
                                                              // $("#requestexpireddate").data("DateTimePicker").minDate(strdt);

                  // $("#requestexpireddate").on("dp.change", function (e)
                  // { 

                  //                                             var dt = $("#booking_date").val();
                  //                                             var tm = $("#start_time").val();


                  //                                             if(dt=='' || tm=='')
                  //                                             {
                  //                                             $('#requestexpireddate').datetimepicker({
                  //                                             format:'DD/MM/YYYY',
                  //                                             // useCurrent:true
                  //                                             });
                  //                                             $('#requestexpireddate').val('');

                  //                                             }

                  //                                             strtdtaetime = dt+' '+tm;
                  //                                             // console.log("strtdtaetime"+strtdtaetime);

                  //                                             var strtdtaetime_date = moment(strtdtaetime,"DD/MM/YYYY hh:mm A").subtract(4,'hours').format("DD/MM/YYYY");

                  //                                             $("#requestexpireddate").data("DateTimePicker").maxDate(strtdtaetime_date);



                  //                                             $('#requestexpiredtime').datetimepicker({
                  //                                             format:'LT',
                  //                                             // useCurrent:true
                  //                                             });


                  //                                             $('#requestexpiredtime').val('').datetimepicker('update');
                  //                                             $('#requestexpiredtime').data("DateTimePicker").date(null);
                  //                                             $("#requestexpiredtime").datetimepicker({
                  //                                             format:'LT'
                  //                                             //Default:false
                  //                                             });






                  // })

								 


               
								 
								 
			
               
               //**************calender js ends here************************//////////////////////////************
//****ending




//*******this function is calling on booking_date change------------------------**************************************

            $("#booking_date").on("dp.change", function(e)
            {
                                                                  $('#start_time').val('').datetimepicker('update');
                                                                  $('#start_time').data("DateTimePicker").date(null);
                                                                  $("#start_time").datetimepicker({
                                                                  format:'LT',
                                                                  //Default:false
                                                                  });

                                            // if(opening_time!='00:00:00')
                                            //       {
                                                                  var getcurdttime_first = new Date();
                                                                  var getcurdttimemo_firstm = moment(getcurdttime_first).format("DD/MM/YYYY hh:mm A");
                                                                  var getcurdttimemomadd_first=moment(getcurdttimemo_firstm,"DD/MM/YYYY hh:mm A").add(4,"hours").format("DD/MM/YYYY");
                                                                  var getcurdttimemomaddtime_ftrst=moment(getcurdttimemo_firstm,"DD/MM/YYYY hh:mm A").add(4,"hours").format("h:mm A");
                                                                  var curentfourmoment = moment(getcurdttimemomadd_first+'  '+getcurdttimemomaddtime_ftrst,"DD/MM/YYYY hh:mm A");
                                                                  var opening_timemom = moment(opening_time,"HH:mm").format("hh:mm A");
                                                                  var ctyme = $("#booking_date").val();
                                                                  var ctyme_date = moment(ctyme,"DD/MM/YYYY").format("DD/MM/YYYY");
                                                                  var startingtime_booking = ctyme_date+' '+opening_timemom;

                                                                  var bookingtimemoment = moment(startingtime_booking,"DD/MM/YYYY hh:mm A");
                                                                  var added_oneday =  moment(getcurdttimemo_firstm,"DD/MM/YYYY hh:mm A").add(24,"hours").format("DD/MM/YYYY");
                                                                
                                                                  if(curentfourmoment > bookingtimemoment)
                                                                  {
                                                                  // alert(added_oneday);
                                                                  $("#booking_date").data("DateTimePicker").date(added_oneday);
                                                                  $("#booking_date").data("DateTimePicker").minDate(added_oneday);
                                                                  }
                                                //    }

                                                                      $('#requestexpireddate').prop("disabled", false);
                                                                      $('#requestexpiredtime').prop("disabled", false); 
                                                                      $('#end_time').prop("disabled", false); 
                                                                      $('#start_time').prop("disabled", false); 


            });


//*********added on 08-07 ends
               
        
        
        
        
        
        //*************start date chage function starts here
           
           $("#start_time").on("dp.change", function(e)
           {



                                                                  var strtdtaetime =   moment().format('DD/MM/YYYY hh:mm A');
                                                                  var strtdtaetime_date = moment(strtdtaetime,"DD/MM/YYYY hh:mm A").add(4,'hours').format("DD/MM/YYYY");
                                                                  var strtdtaetime_time = moment(strtdtaetime,"DD/MM/YYYY hh:mm A").add(4,'hours').format("hh:mm A");



                                                                  var crntdate = moment().format('DD/MM/YYYY');
                                                                  var crnttime = moment().format('hh:mm A');

                                                                  var start_time_gig = $('#start_time').val();
                                                                  var r =  moment(start_time_gig,"hh:mm A");

                                                                  var l = moment(strtdtaetime_time,"hh:mm A"); //*** crnttime

                                                                  var strttime = $("#booking_date").val();


                                                                  if(strttime == strtdtaetime_date)
                                                                  {
                                                                  // console.log('hurray!!!!!!!!!!');
                                                                      if(r < l)
                                                                      {
                                                                      // console.log('ererre!!!!!!!!!!');
                                                                         $("#start_time").data("DateTimePicker").date(strtdtaetime_time);
                                                                      }
                                                                  }


                                                                  if(opening_time!='00:00:00')
                                                                  {

                                                                        var strtimvl = $("#start_time").val();
                                                                        var strtmomntym =  moment(strtimvl,"h:mm A").format("h:mm A");
                                                                        var mmmnt_openingtime=moment(opening_time,"hh:mm A").format('h:mm A');
                                                                        var strtmomntym_moment = moment(strtmomntym,"hh:mm A");
                                                                        var gtmomentopng_time = moment(mmmnt_openingtime,"hh:mm A");

                                                                        if(strtmomntym_moment < gtmomentopng_time)
                                                                        {
                                                                          $("#start_time").data("DateTimePicker").date(mmmnt_openingtime);
                                                                        }
                                                                  }

                                                                  if(closing_time!='00:00:00')
                                                                  {
                                                                        var mmmnt_opentime=moment(opening_time,"hh:mm A").format('h:mm A');
                                                                        var mmmnt_closeime=moment(closing_time,"HH:mm").format('HH:mm');
                                                                        var today_date = moment().format('DD/MM/YYYY');
                                                                        var bookign_date = $("#booking_date").val();
                                                                        var bking_datetime = bookign_date+' '+mmmnt_opentime;

                                                                        var resultsplit = mmmnt_closeime.split(':');
                                                                        var addcompleteddate=moment(bking_datetime,"DD/MM/YYYY h:mm A").add(resultsplit[0],"hours").format("DD/MM/YYYY h:mm A" );
                                                                        var addcompletedtime=moment(addcompleteddate,"DD/MM/YYYY h:mm A").add(resultsplit[1],"m").format("DD/MM/YYYY hh:mm A" );
                                                                        var sub_complettim = moment(addcompletedtime,"DD/MM/YYYY h:mm A").subtract(30,"m").format("hh:mm A" );

                                                                        //****
                                                                        //alert(addcompletedtime); 
                                                                        // var indrasis = moment(addcompletedtime,"DD/MM/YYYY hh:mm A");
                                                                        // alert(indrasis);

                                                                        //****

                                                                        var completedate = moment(addcompletedtime,"DD/MM/YYYY h:mm A").format("DD/MM/YYYY");
                                                                       if(completedate == bookign_date)
                                                                       {
                                                                        var sub_complettim_mom = moment(sub_complettim,"hh:mm A");
                                                                        var strttime_vl = $("#start_time").val();
                                                                        var strttime_vl_format = moment(strttime_vl,"hh:mm A").format("hh:mm A");
                                                                        var strttime_vl_moment = moment(strttime_vl_format,"hh:mm A");
                                                                        // console.log("strttime_vl -----------------> "+strttime_vl+" and the moment is -------------------->"+strttime_vl_moment);
                                                                        // console.log("----------------------We are in same date and time before ending is ------------------"+sub_complettim+"moment is --------->"+sub_complettim_mom);
                                                                            if(strttime_vl_moment > sub_complettim_mom)
                                                                            {
                                                                              $("#start_time").data("DateTimePicker").date(sub_complettim);
                                                                            }
                                                                       }else
                                                                       {
                                                                         //console.log("----------------------We are not in same date ------------------");
                                                                       
                                                                                  var strttmvalue = $("#start_time").val();
                                                                                  var othertime = bookign_date+' '+strttmvalue;
                                                                                  //console.log("othertime"+othertime);
                                                                                  var othrttimemoment = moment(strttmvalue,"hh:mm A");
                                                                                 
                                                                                  var sub_complettim_datetime = moment(addcompletedtime,"DD/MM/YYYY h:mm A").subtract(30,"m").format("DD/MM/YYYY  hh:mm A" );
                                                                                  //console.log("sub_complettim_datetime"+sub_complettim_datetime);
                                                                                  var sub_complettim_date = moment(addcompletedtime,"DD/MM/YYYY h:mm A").subtract(30,"m").format("DD/MM/YYYY" );
                                                                                  var sub_complettim_time = moment(addcompletedtime,"DD/MM/YYYY h:mm A").subtract(30,"m").format("hh:mm A" );

                                                                                  var sub_complettim_ime_only = moment(sub_complettim_time,"hh:mm A");

                                                                                      if(bookign_date == sub_complettim_date)
                                                                                      {
                                                                                              //console.log("I am Running");
                                                                                              if(othrttimemoment > sub_complettim_ime_only)
                                                                                              {
                                                                                              $("#start_time").data("DateTimePicker").date(sub_complettim_time);
                                                                                              //******
                                                                                              //console.log("I am Running");

                                                                                              }
                                                                                      }

                                                                            
                                                                       }
                                                                       // var fourhr = moment(bking_datetime,"DD/MM/YYYY h:mm A").add()

                                                                  }
                                                                 


                                                                  $('#end_time').val('').datetimepicker('update');
                                                                  $('#end_time').data("DateTimePicker").date(null);
                                                                  $("#end_time").datetimepicker({
                                                                  format:'LT',
                                                                  });


                                                                  $('#requestexpireddate').val('').datetimepicker('update');
                                                                  $('#requestexpireddate').data("DateTimePicker").date(null);
                                                                  $("#requestexpireddate").datetimepicker({
                                                                  format:'DD/MM/YYYY',
                                                                  //   Default:false
                                                                  });

                                                                  $("#end_time").data("DateTimePicker").date("00:30");

                                        
                                                                                   //$("#end_time").data("DateTimePicker").date("00:30");
                
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




                                                                        var mmdata1=$("#start_time").val();
                                                                        var mmmntstarttime=moment(mmdata1,"hh:mm A").format('h:mm A');



                                                                        var bkng_datedata=$("#booking_date").val();
                                                                        var mmmntbkng_datedata=moment(bkng_datedata,"DD/MM/YYYY").format("DD/MM/YYYY");


                                                                        var closingtimeget = moment(closing_time,'hh:mm:ss').format('HH:mm');
                                                                        var starttimeselected = moment(mmmntstarttime,"hh:mm A").format("HH:mm"); //******* mmmntstarttime is start time moment


                                                                        //  alert(opening_time+"============="+closing_time+"start time selected"+starttimeselected);
                                                                        var mmmnt_openingtime=moment(opening_time,"HH:mm").format('HH:mm');
                                                                        var gtmomentopng_time = moment(mmmnt_openingtime,"HH:mm");



                                                                        var result = closingtimeget.split(':');


                                                                        var compltedatetime = moment(mmmntbkng_datedata+" "+mmmnt_openingtime,"DD/MM/YYYY HH:mm");


                                                                        var added_date = moment(compltedatetime,"DD/MM/YYYY HH:mm").add(result[0],"hours").format("DD/MM/YYYY HH:mm" );
                                                                        var added_time = moment(added_date,"DD/MM/YYYY HH:mm").add(result[1],"m").format("DD/MM/YYYY HH:mm" );




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
                                                                        // $("#end_time").data("DateTimePicker").maxDate("23:45");
                                                                        // $("#end_time").data("DateTimePicker").minDate("00:30");
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
                                                                    /*  $("#end_time").data("DateTimePicker").minDate("00:30");
                                                                      $("#end_time").data("DateTimePicker").maxDate("23:46");*/
                                                                      // $('#end_time').data("DateTimePicker").disabledTimeIntervals(
                                                                      //            [moment({ h: 00,m: 00 }), moment({ h: 00,m: 30 })] );
                                                                      }


                                                                      //************get hours minutes difference in seconds starts javascript

                                                                      //   alert(hh);

                                                                      //  alert(starttimeselected);
                                                                      //****************






                });


                 
                  //*************start date chage function ends here

               

                    $("#requestexpiredtime").on("dp.change", function (e)
                    {

                                                                          var crntdate = moment().format('DD/MM/YYYY');
                                                                          var crnttime = moment().format('hh:mm A');

                                                                          var end_time_gig = $('#requestexpiredtime').val();
                                                                          var r =  moment(end_time_gig,"hh:mm A");


                                                                          var l = moment(crnttime,"hh:mm A");

                                                                          var strttime = $("#requestexpireddate").val();


                                                                          if(strttime == crntdate)
                                                                          {
                                                                          if(r < l)
                                                                          {
                                                                          // alert('hello');
                                                                          $("#requestexpiredtime").data("DateTimePicker").date(crnttime);
                                                                          }

                                                                          }


                                                                          var bookingreqdate = $("#booking_date").val();
                                                                          // // console.log("bookingreqdate"+bookingreqdate);
                                                                          var strt_time_gig = $('#start_time').val();
                                                                          //  //console.log("strt_time_gig"+strt_time_gig);

                                                                          var ttmoment = bookingreqdate+' '+strt_time_gig;

                                                                          // console.log("ttmoment"+ttmoment);

                                                                          var fourhrmoment_before_date = moment(ttmoment,"DD/MM/YYYY hh:mm A").subtract(4,'hours').format("DD/MM/YYYY");
                                                                          var fourhrmoment_before_time = moment(ttmoment,"DD/MM/YYYY hh:mm A").subtract(4,'hours').format("hh:mm A");

                                                                          //  console.log("fourhrmoment_before_date"+fourhrmoment_before_date+"fourhrmoment_before_time"+fourhrmoment_before_time);
                                                                          fourhour_span = moment(fourhrmoment_before_time,"hh:mm A");

                                                                          if(fourhrmoment_before_date == strttime)
                                                                          {
                                                                          //console.log('date matched'+fourhour_span);
                                                                          if(r > fourhour_span)
                                                                          {
                                                                          // console.log("in this section");
                                                                          $("#requestexpiredtime").data("DateTimePicker").date(fourhrmoment_before_time);
                                                                          }
                                                                          //else
                                                                          // {
                                                                          //   $("#requestexpiredtime_gig").data("DateTimePicker").date(end_time_gig);
                                                                          // }
                                                                          }




                    })

                
                                                              $('#requestexpireddate').datetimepicker({
                                                              format:'DD/MM/YYYY',
                                                              });
                                                              var strdt = moment().format('DD/MM/YYYY');
                                                              $("#requestexpireddate").data("DateTimePicker").minDate(strdt);

                  $("#requestexpireddate").on("dp.change", function (e)
                  { 

                                                              var dt = $("#booking_date").val();
                                                              var tm = $("#start_time").val();


                                                              if(dt=='' || tm=='')
                                                              {
                                                              $('#requestexpireddate').datetimepicker({
                                                              format:'DD/MM/YYYY',
                                                              // useCurrent:true
                                                              });
                                                              $('#requestexpireddate').val('');

                                                              }

                                                              strtdtaetime = dt+' '+tm;
                                                              // console.log("strtdtaetime"+strtdtaetime);

                                                              var strtdtaetime_date = moment(strtdtaetime,"DD/MM/YYYY hh:mm A").subtract(4,'hours').format("DD/MM/YYYY");

                                                              $("#requestexpireddate").data("DateTimePicker").maxDate(strtdtaetime_date);



                                                              $('#requestexpiredtime').datetimepicker({
                                                              format:'LT',
                                                              // useCurrent:true
                                                              });


                                                              $('#requestexpiredtime').val('').datetimepicker('update');
                                                              $('#requestexpiredtime').data("DateTimePicker").date(null);
                                                              $("#requestexpiredtime").datetimepicker({
                                                              format:'LT'
                                                              //Default:false
                                                              });






                  })

                 


               
                 
                 
      
               
               //**************calender js ends here************************//////////////////////////************
//****ending

