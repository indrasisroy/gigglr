
         $( "#country" ).change(function() {
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
                         //********************FORM SUBMIT VALIDATION************
                              
                              function callforbooking(posturl,csrf)
                              {
                                   //alert(posturl);
          
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
                                         //var characterReg = /^[0-9]{7}(?:-[0-9]{4})?$/;
                                         var characterReg = /[0-9]+/;
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
                                                       address1: {
                                                            required: true,
                                                            minlength: 2,
                                                       },
                                                        country: {
                                                            required: true,
                                                       },
                                                       select_state: {
                                                            required: true,
                                                       },
                                                        city: {
                                                            required: true,
                                                            charactertype:true,
                                                       },
                                                        zip: {
                                                            required: true,
                                                            numericfield : true,
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
                                                          
                                                       address1: {
                                                           required: "Booking location can not be empty",
                                                           minlength: "Please enter a valid location"
                                                       },
                                                       country: {
                                                           required: "Please select a country",
                                                           
                                                       },
                                                        select_state: {
                                                           required: "Please select a state",
                                                           
                                                       },
                                                        city: {
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
                              
                              toastr.remove();
                              var chkbookingvalidation =  $("#bookingform").valid();
                              if(chkbookingvalidation === true)
                              {
                                    $('.clickmeShow').show();
                                  //************ Retriving value starts here
                                   var address1val = $("#address1").val();
                                   var address2val = $("#address2").val();
                                   var countrydata = $("#country").val();
                                   var statelistdata = $("#select_state").val();
                                   var towndata = $("#city").val();
                                   var zipdata = $("#zip").val();
                                   var bookingcat_subdata = $("#bookingcat_sub").val();
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
                                   
                                   var type_entry_insert = '';
                                   //alert(event_type_entry);
                                   if (event_type_entry =='3') {
                                    type_entry_insert = $('input[name=radio_entry_type]:checked').val(); //"input[name=radio_entry_type]:checked"
                                   }else{
                                    type_entry_insert = event_type_entry;
                                   }
                                   //console.log("Booking Token========>"+csrf);
                                   //************ Retriving value ends here

                                   //************** Ajax form submission starts here
                                    var bookingformdata = {_token:csrf,type_entry:type_entry_insert,creater_id:creater_id,artist_id:groupId,type_flag:gig_type,address1val:address1val,address2val:address2val,countrydata:countrydata,statelistdata:statelistdata,towndata:towndata,zipdata:zipdata,bookingcat_subdata:bookingcat_subdata,bookinggenre_subdata:bookinggenre_subdata,security_paymentdata:security_paymentdata,total_paymentdata:total_paymentdata,cancellation_paymentdata:cancellation_paymentdata,booking_datedata:booking_datedata,start_timedata:start_timedata,end_timedata:end_timedata,requestexpireddatedata:requestexpireddatedata,requestexpiredtimedata:requestexpiredtimedata};
                                        var bookingurldata=base_url_data+"/"+posturl;
                                       // console.log("Booking Form url data========>"+bookingurldata);
                                        jQuery.ajax({
										type: "GET",
										data:bookingformdata,
										url: bookingurldata,
										dataType:"json",
                                             success: function(res)
                                             {
                                                  //alert(res.flagdata+"********"+res.message);
                                                  
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
                                                    poptriggerfunc(msgtype='error',titledata='',msgdata=res.message,sd=6000,hd=1500,tmo=3000,etmo=4000,poscls='toast-bottom-right');
                                                  }
                                                  
                                                  //console.log(res.message+"Dhiman Booking response==========>"+res.flagdata);
                                             }
                                        });
                                   //************** Ajax form submission ends here
                                  
                                   //showmycustomloader(0,'','',"Please wait ....",imfpth);
                                   var imfpth=base_url_data+"/public/front/otherfiles/progimages/loder.gif"
                                   showmycustomloader(1,'4000','2000',"Processing. Please wait ....",imfpth);
                                   $("#cancelbtn").click(); //***modal remove
                                   //var success_message_data="Thank you for your booking request! ";
                                   //poptriggerfunc(msgtype='success',titledata='',msgdata=success_message_data,sd=6000,hd=1500,tmo=3000,etmo=4000,poscls='toast-bottom-right');
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
               //**************FOR COUNTRY STATE AJAX ENDS**************************
               //*******************FOR CATEGORY GENERE AJAX************************
               
               function getGenereforCategory(requeststateUrl,Catagory_Id,csrf)
               {
                         var categorydata = {_token:csrf,categoryID:Catagory_Id,groupId:groupId};
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
			   $("#booking_date").on("dp.change", function(e)
   				{
				  var ttttttt = $("#booking_date").val();
				  console.log("Booking date is ===============>"+ttttttt);
				
					 $("#requestexpireddate").val('');
					 $('#requestexpireddate').data("DateTimePicker").date(null);
					 $('#requestexpireddate').val('').datetimepicker('update');
					 $("#requestexpiredtime").val('');
					 $('#requestexpiredtime').data("DateTimePicker").date(null);
					 $('#requestexpiredtime').val('').datetimepicker('update');
				
					 $("#start_time").val('');
					 $('#start_time').data("DateTimePicker").date(null);
					 $('#start_time').val('').datetimepicker('update');
					 $('#start_time').data("DateTimePicker").date(null);
					 $("#start_time").datetimepicker({
					 format:'LT',
					 Default:false
					 });
					 
					 //***********get curent time  plus 4 hours*********starts*** 
				     var getcurdttime = new Date();
					 var getcurdttimemom = moment(getcurdttime).format("DD/MM/YYYY hh:mm A");
					 var getcurdttimemomadd=moment(getcurdttimemom,"DD/MM/YYYY hh:mm A").add(4,"hours").format("DD/MM/YYYY" );
					 var getcurdttimemomaddtime=moment(getcurdttimemom,"DD/MM/YYYY hh:mm A").add(4,"hours").format("h:mm A" );
					 
					 var curplusfour = getcurdttimemomadd + "======="+getcurdttimemomaddtime;
					 console.log("current time plus four "+curplusfour);
					 //***********get curent time  plus 4 hours*********ends***
					 
					 
					 $('#booking_date').data("DateTimePicker").minDate(getcurdttimemomadd); //setting as min date
				
					 var startdt=$("#booking_date").val();
				     var strtmomnty =  moment(startdt,"DD-MM-YYYY").format("DD/MM/YYYY");
					 console.log("strtmomnty"+strtmomnty);
					 if(getcurdttimemomadd == strtmomnty) //if booking date is 4 hours away date
					 {
						console.log("same date");
						$('#start_time').val('').datetimepicker('update');
						$('#start_time').data("DateTimePicker").date(getcurdttimemomaddtime);
						$("#start_time").datetimepicker({
						format:'LT',
						});
					 }
					 
					 
				});
				
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
								 
								 
								 
		   	$(document).ready(function()
   	{

     if (flgBkGrp=='1') {
            $('.openbkgrpcls').trigger('click');
          }
          if (submitBtbFlag == '0' || creater_id == logID ) {
            $('#venuebookingsubmit').attr('disabled','disabled');
          }

          $( ".openmodal" ).click(function() {
            toastr.remove();
            //if ((submitBtbFlag == '0') && (creater_id == logID )) {
            if (creater_id == logID) {
              $("#subscribeloader").addClass("mydisplaynone");   
              poptriggerfunc(msgtype='error',titledata='',msgdata="You can't booked your own group & This group's rate amount is null",sd=10000,hd=1000,tmo=1000,etmo=2000,poscls='toast-bottom-right');
            }else if (submitBtbFlag == '0') {
              $("#subscribeloader").addClass("mydisplaynone");   
              poptriggerfunc(msgtype='error',titledata='',msgdata="Ops !!!.This group's rate amount is null",sd=6000,hd=1500,tmo=3000,etmo=4000,poscls='toast-bottom-right');
            }else if (logID == '') {
              $("#subscribeloader").addClass("mydisplaynone");   
              poptriggerfunc(msgtype='error',titledata='',msgdata="You must be logged in to continue",sd=6000,hd=1500,tmo=3000,etmo=4000,poscls='toast-bottom-right');
            }
          });
          
          
    });
               
               
               
               
               
               
               
               
               
               
               
               
               //**************calender js ends here************************//////////////////////////************
                      