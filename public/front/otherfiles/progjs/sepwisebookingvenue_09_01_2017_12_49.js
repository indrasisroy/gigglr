
var flagform5 = 1;
var flagform6 = 1;
var flagform7 = 1;
var flagform8 = 1;


$("#revertbacktofive").click(function(){
	$('#myModal5').modal('show');
	 
});
$("#revertbacktosix").click(function(){
	$('#myModal_6').modal({ show:true })
	 
});
$("#revertbacktoseven").click(function(){
	$('#myModal_7').modal({ show:true })
	 
});

//******************************** Modal for 1/4 function starts here *******************************************
$("#continuetosix").click(function(){


							$("#bookingform1").validate({                                   
                                    
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
                                   
                                    
                                        errorClass: "authError",
                                        errorElement: 'span',
                                        //***********************VALIDATION RULES*****************STARTS****************
                                             rules: {
                                                       
                                                        booking_date: {
                                                            required: true,
                                                       },
                                                       start_time_hr:{
                                                             required: true,
                                                            
                                                       },
                                                        start_time_mnt:{
                                                             required: true,
                                                       },
                                                        end_time_hr:{
                                                             required: true,
                                                       },
                                                        end_time_mnt:{
                                                             required: true,

                                                       },
                                                      
                                                  },
                                                 
                                          messages: {
                                                          
                                                       
                                                       start_time_hr: {
                                                          required: "Please select a start time",
                                                       },
                                                       end_time_hr: {
                                                          required: "Please select a end time",
                                                       },
                                                        end_time_hr: {
                                                          required: "Please select a start time",
                                                       },
                                                       end_time_mnt: {
                                                          required: "Please select a end time",
                                                       },
                                                      

                                                  },
                                       
                                        });
                                      
                              
     
                              var chkbookingvalidation =  $("#bookingform1").valid();
                              var artistduplicatedata = base_url_data+"/"+"venueduplicatedatafunc";


									var start_timedata_format = $("#ddlViewBy").val();
									var starttimehr_val = $("#start_time_hr").val();
									var starttimemin_val = $("#start_time_mnt").val();

									var bookingdateval = $("#booking_date").val();
									var start_timedata_formatval;

                                    if(start_timedata_format == 2)
                                    {
                                     // starttimehr_val = parseInt(starttimehr_val)+12;
                                      start_timedata_formatval = 'pm';
                                    }else if(start_timedata_format == 1)
                                    {
                                       start_timedata_formatval = 'am';
                                    }
                                    var artistID = $("#venueID").val();
                                    //alert(artistID);

                                   var start_timedata = starttimehr_val+ ':'+starttimemin_val+" "+start_timedata_formatval;

                               if(chkbookingvalidation === true)
                            	{
										              flagform5 = 1;
                            		jQuery.ajax({
											type: "POST",
											data:{_token:csrf_token_data,start_timedata:start_timedata,bookingdateval:bookingdateval,artistid:artistID},
											url: artistduplicatedata,
											dataType:"json",
				                                 success: function(d)
				                                 {                                     
				                                 	//console.log("asas"+d.respflag);
				                                 	   
				                                    if (d.respflag == 1)
				                                    {
				                                    	 // return false; 
                                                flagform5 = 0;
				                                    	checkaddrflag = 0;
				                                     	//return false;
				                                      	poptriggerfunc(msgtype='error',titledata='',msgdata="You have already booked this venue please select another date time to continue",sd=1000,hd=1500,tmo=3000,etmo=4000,poscls='toast-top-full-width'); 
                                                 //************ Modal Will show if error occurs starts 03-01-2017
                                               
                                                setTimeout(function()
                                                  {
                                                     $('#myModal_6').modal('show');
                                                  }, 1000);
                                                 //************ Modal Will show if error occurs ends 03-01-2017  


				                                    }else if(d.respflag == 0)
				                                    {
				                                    	//console.log("Hello here");
				                                    	 // return false; 
				                                    	//checkaddrflag = 1;
				                                    	// console.log("I am here")
				                                     	//return false;
				                                     	$('#myModal_6').modal('show');
				                                      

				                                    }
				                                  
				                                    
				                                }
			                                });



										//$('#myModal_6').modal({show:true});
                            	}else
                          		{
                          			//return false;
                                  //************ Modal Will show if error occurs starts 03-01-2017
                                                flagform5 = 0;
                                                setTimeout(function()
                                                  {
                                                     $('#myModal_6').modal('show');
                                                  }, 500);
                                //************ Modal Will show if error occurs ends 03-01-2017
                          		}

});
	

//******************************** Modal for 1/4 function ends here *******************************************



//******************************** Modal for 2/4 function starts here *******************************************

$("#continuetoseven").click(function(){


    $("#myModal_7").modal('show');

	 // $.validator.addMethod("blnkchecklocationzip", function(value, element) 
  //                                    {
  //                                         // return this.optional(element) || /^[a-z]+$/i.test(value);  /^([a-zA-Z]+\s)*[a-zA-Z]+$/.test(value);
  //                                          return this.optional(element) || (/\S/.test(value));
  //                                     },"Please enter valid Post code");

	 //  $.validator.addMethod("charactertype", function(value, element) 
  //                                    {
  //                                         // return this.optional(element) || /^[a-z]+$/i.test(value);  /^([a-zA-Z]+\s)*[a-zA-Z]+$/.test(value);
  //                                          return this.optional(element) || /^([a-zA-Z]+\s)*[a-zA-Z]+$/.test(value);
  //                                    },"Please enter valid city name");

		// 		$("#bookingform2").validate({                                   
                                    
  //                                   /*****add parent class*****/
  //                                   highlight: function(element) {
  //                                       $(element).parent().addClass("errorField");
  //                                   },
  //                                   /*****remove parent class*****/
  //                                   unhighlight: function(element) {
  //                                       $(element).parent().removeClass("errorField");
  //                                   },   
  //                                   /*****remove error text*****/
  //                                   errorPlacement: function () {
  //                                       return false;
  //                                   },
                                   
                                    
  //                                       errorClass: "authError",
  //                                       errorElement: 'span',
  //                                       //***********************VALIDATION RULES*****************STARTS****************
  //                                            rules: {
                                                       
  //                                                       booking_location: {
  //                                                           required: true,
  //                                                      },
  //                                                      town:{
  //                                                            required: true,
  //                                                            charactertype:true,
                                                            
  //                                                      },
  //                                                       zip:{
  //                                                            required: true,
  //             												 blnkchecklocationzip: true,
  //                                                      },
                                                       
  //                                                 },
                                                 
  //                                         messages: {
                                                          
                                                       
  //                                                      booking_location: {
  //                                                         required: "Please enter a booking address",
  //                                                      },
  //                                                      town: {
  //                                                         required: "Please select a booking city",

  //                                                      },
  //                                                       zip: {
  //                                                         required: "Please select a booking zip",
                                                          
  //                                                      },
                                                       
                                                      

  //                                                 },
                                       
  //                                       });

		// 					   var chkbookingvalidation_second =  $("#bookingform2").valid();



		// 					       var address1val = $("#booking_location").val().trim();
  //                                  var address2val = $("#booking_location_second").val().trim();
  //                                  var countrydata = $("#country").val();
  //                                  var statelistdata = $("#select_state").val();
  //                                  var towndata = $("#town").val().trim();
  //                                  var zipdata = $("#zip").val().trim();
  //                                  var checkaddrflag = 0;



  //                                  //************************** ajax validation for address validation starts here

  //                                  var addressvalidationurl=base_url_data+"/"+"groupbookingaddrescheck";
  //                                   var addressdata = {_token:csrf_token_data,address1val:address1val,address2val:address2val,countrydata:countrydata,statelistdata:statelistdata,towndata:towndata,zipdata:zipdata};
                                  

		// 						if(chkbookingvalidation_second === true)
		// 						{
									
		// 							 jQuery.ajax({
		// 									type: "POST",
		// 									data:addressdata,
		// 									url: addressvalidationurl,
		// 									dataType:"json",
		// 		                                 success: function(d)
		// 		                                 {                                     
		// 		                                 	//console.log("asas"+d.respflag);
				                                 	   
		// 		                                    if (d.respflag == 0)
		// 		                                    {
		// 		                                    	 // return false; 
		// 		                                    	checkaddrflag = 0;
		// 		                                     	//return false;
		// 		                                      	poptriggerfunc(msgtype='error',titledata='',msgdata="Sorry, but that does not look like a legitimate address",sd=1000,hd=1500,tmo=3000,etmo=4000,poscls='toast-top-full-width');   


		// 		                                    }else if(d.respflag == 1)
		// 		                                    {
		// 		                                    	 // return false; 
		// 		                                    	checkaddrflag = 1;
		// 		                                    	// console.log("I am here")
		// 		                                     	//return false;
		// 		                                     	$("#myModal_7").modal('show');
				                                      

		// 		                                    }
				                                  
				                                    
		// 		                                }
		// 	                                });

		// 							 if(checkaddrflag == 0)
		// 							 {
		// 							 	return false;
		// 							 	toastr.remove();
		// 							 	poptriggerfunc(msgtype='error',titledata='',msgdata="Sorry, but that does not look like a legitimate address",sd=1000,hd=1500,tmo=1000,etmo=1000,poscls='toast-top-full-width');   

		// 							 }else if(checkaddrflag == 1)
		// 							 {
		// 							 	//alert("Hello");
		// 							 	//return true;
		// 							 	$("#myModal_7").modal('show');
		// 							 }
									 


		// 						}else
		// 						{
		// 							return false;
		// 						}

                              



});

//******************************** Modal for 2/4 function ends here *******************************************



//******************************** Modal for 3/4 function starts here *******************************************

$("#continuetoeight").click(function()
{
	
					$("#bookingform3").validate({                                   
                                    
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
                                   
                                    
                                        errorClass: "authError",
                                        errorElement: 'span',
                                        //***********************VALIDATION RULES*****************STARTS****************
                                             rules: {
                                                       
                                                       bookingcat_subvenue: {
                                                            required: true,
                                                       },
                                                       bookinggenre_sub:{
                                                             required: true,
                                                            
                                                       },
                                                        gig_description:{
                                                             required: true,
                                                       },
                                                       
                                                  },
                                                 
                                          messages: {
                                                          
                                                       
                                                       bookingcat_subvenue: {
                                                          required: "Please select a talent category",
                                                       },
                                                       bookinggenre_sub: {
                                                          required: "Please select a genre",
                                                       },
                                                        gig_description: {
                                                          required: "Enter booking description",
                                                       },
                                                       
                                                      

                                                  },
                                       
                                        });

							   var chkbookingvalidation_third =  $("#bookingform3").valid();
                               if(chkbookingvalidation_third === true)
                            	{
                                flagform7 = 1;
                            		$("#myModal_8").modal('show');
                            	}else
                          		{
                          			//return false;
                                 flagform7 = 0;
                                      setTimeout(function(){
                                      $("#myModal_8").modal('show');
                                      },500);
                          		}
	
});


//******************************** Modal for 3/4 function ends here *******************************************


//******************************** Modal for 4/4 function starts here *******************************************



$("#continue_tosubmit").click(function()
{
	var aggreeval = $('input[name=i_agree]:checked').val();
	if(aggreeval != '') 
		{



					 $.validator.addMethod("numericfieldamount", function(value, element) 
                {
                                         var characterReg = /^([0-9]*){0,}(\.\d{1,2})?$/; ///^[1-9][0-9]+(\.\d{1,2})?$/ ;
                                         return characterReg.test(value);
                },"Please enter proper numeric value");

					$.validator.addMethod("checkingamount",function(value,element)
                                {
                                  var securitymony = $("#security_payment").val().replace("$", "").replace(/,/g, "");
                                  var cancellation = $("#cancellation_payment").val().replace("$", "").replace(/,/g, "");
                                  var totalpayment = $("#total_payment").val().replace("$", "").replace(/,/g, "");
                                  
                                   if(cancellation !='')
                                  {

                                    if(securitymony == '')
                                    {
                                      securitymony ="0.00";
                                    }
                                    if(cancellation =="")
                                    {
                                      cancellation="0.00";
                                    }

                                    var ff2 =parseFloat(totalpayment)-(parseFloat(cancellation)+parseFloat(securitymony));
                                  
                                   var f = parseFloat(ff2).toFixed(2);
                                    
                                    if (f > 0) {
                                      return true;
                                    }else{
                                     return false;
                                    }
                                  }else
                                  {
                                    return true;
                                  }


                                },"Please enter a valid cancellation amount ");
                                
                                
                                 $.validator.addMethod("checkingamounttotal",function(value,element)
                                {
                                  var securitymony = $("#security_payment").val().replace("$", "").replace(/,/g, "");
                                  var cancellation = $("#cancellation_payment").val().replace("$", "").replace(/,/g, "");
                                  var totalpayment = $("#total_payment").val().replace("$", "").replace(/,/g, "");
                                 


                                   if(securitymony == '')
                                  {
                                    securitymony ="0.00";
                                  }
                                  if(cancellation =="")
                                  {
                                    cancellation="0.00";
                                  }


                                   var ff = parseFloat(totalpayment)-parseFloat(securitymony);
                                   var f = parseFloat(ff).toFixed(2);
                                 // console.log("Diference is=============="+f);
                                  if (f > 0) {
                                    return true;
                                  }else{
                                   return false;
                                  }
                                },"Total payment must be higher than security deposit");


						$("#bookingform4").validate({                                   
                                    
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
                                   
                                    
                                        errorClass: "authError",
                                        errorElement: 'span',
                                        //***********************VALIDATION RULES*****************STARTS****************
                                             rules: {
                                                       
                                                       security_payment:{
                                                            //required: true,
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
                                                            //required: true,
                                                            numericfieldamount: true,
                                                            maxlength: 20,
                                                            checkingamount :true,
                                                       },
                                                       
                                                       
                                                  },
                                                 
                                          messages: {
                                                          
                                                       
                                                       total_payment: {
                                                          required: "Total amount is required",
                                                       },
                                                       
                                                       
                                                      

                                                  },
                                       
                                        });

							   var chkbookingvalidation_fourth =  $("#bookingform4").valid();

                  if(aggreeval == 'za')
                {

                  $("#readiodefaultcheckerror").parent().removeClass('radioerrorcolor');


                               if(chkbookingvalidation_fourth === true)
                            	{
                            		//alert(flagform5+' '+flagform6+' '+flagform7+' '+flagform8)
                                flagform8 = 1;


                            	}else
                          		{
                          			//return false;
                                 flagform8 = 0;
                          		}
                      }else
                {
                  $("#readiodefaultcheckerror").parent().addClass('radioerrorcolor');
                  flagform8 = 0;
                }        



                          		}else
								{
                  flagform8 = 0;
									toastr.remove();
									poptriggerfunc(msgtype='error',titledata='',msgdata="Please agree terms and conditions to continue",sd=1000,hd=1500,tmo=1000,etmo=1000,poscls='toast-top-full-width');  
								}

                  if(flagform5 == 1 && flagform6 == 1 && flagform7 == 1 && flagform8 == 1 )
                {
                   // $("#missingsomethingerror").addClass('mydisplaynone');
                 

                                $("#continue_tosubmit" ).prop( "disabled", true );
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
                                   

                                      if(security_paymentdata == '')
                                  {
                                    security_paymentdata ="0.00";
                                  }
                                  if(cancellation_paymentdata =="")
                                  {
                                    cancellation_paymentdata="0.00";
                                  }
                                   
                                   var gig_description =  $("#gig_description").val();
                                   
                                   var booking_datedata = $("#booking_date").val();
                                   


                                  //var start_timedata = $("#start_time").val();

                                   //  var start_timedata_format = $("#ddlViewBy").val();
                                   //  var starttimehr_val = $("#start_time_hr").val();
                                   //  var starttimemin_val = $("#start_time_mnt").val();

                                   //  if(start_timedata_format == 2)
                                   //  {
                                   //    starttimehr_val = parseInt(starttimehr_val)+12;
                                   //  }

                                   // var start_timedata = starttimehr_val+ ':'+starttimemin_val;


                                   var start_timedata_format = $("#ddlViewBy").val();
                                    var starttimehr_val = $("#start_time_hr").val();
                                    var starttimemin_val = $("#start_time_mnt").val();
                                     var start_timedata_formatval;
                                    if(start_timedata_format == 2)
                                    {
                                     // starttimehr_val = parseInt(starttimehr_val)+12;
                                      start_timedata_formatval = 'pm';
                                    }else if(start_timedata_format == 1)
                                    {
                                       start_timedata_formatval = 'am';
                                    }

                                   var start_timedata = starttimehr_val+ ':'+starttimemin_val+" "+start_timedata_formatval;




                                  // var end_timedata = $("#end_time").val();

                                    // var end_timedata_format = $("#ddlViewend").val();
                                   var endtimehr_val = $("#end_time_hr").val();
                                   var endtimemin_val = $("#end_time_mnt").val();




                                   //  //  if(end_timedata_format == 2)
                                   //  // {
                                   //  //   endtimehr_val = parseInt(endtimehr_val)+12;
                                   //  // }

                                   // var end_timedata = endtimehr_val+':'+endtimemin_val;


                                   //var requestexpireddatedata = $("#requestexpireddate").val();


                                  // var requestexpiredtimedata = $("#requestexpiredtime").val();

                                   //  var requestexpire_timedata_format = $("#ddlViewrequestexpire").val();
                                   //  var reqexpirehr = $("#requexpire_time_hr").val();
                                   //  var reqexpminval = $("#reqexpire_time_mnt").val();


                                   //  if(requestexpire_timedata_format == 2){
                                   //    reqexpirehr = parseInt(reqexpirehr)+12;
                                   //  }

                                   // var requestexpiredtimedata = reqexpirehr+':'+reqexpminval;//$("#requestexpiredtime").val();


                                    var endtimedata = booking_datedata+' '+start_timedata;
                                   var endtimeformat = moment(endtimedata,"DD/MM/YYYY hh:mm A").format("DD/MM/YYYY hh:mm A");
                                   var endtimeformataddhrs = moment(endtimeformat,"DD/MM/YYYY h:mm a").add(endtimehr_val,"hours").format("DD/MM/YYYY h:mm a"); //**** hour
                                   var endtimeformataddmnts = moment(endtimeformataddhrs,"DD/MM/YYYY h:mm a").add(endtimemin_val,"minutes").format("DD/MM/YYYY h:mm a"); //**** hour
                                   var endtimedt = moment(endtimeformataddmnts,"DD/MM/YYYY h:mm a").format("DD/MM/YYYY"); //**** hour
                                   var endtimehrs = moment(endtimeformataddmnts,"DD/MM/YYYY h:mm a").format("hh:mm A"); //**** hour
                                   //*********************** total end time ends here

                                  // console.log(" start date "+booking_datedata+" start time "+ start_timedata +" end time "+end_timedata+" endtimeformataddhrs "+endtimeformataddhrs);
                                   // var end_timedata = $("#end_time").val();
                                   // console.log(" start time data "+endtimedata);
                                   // console.log(" endtimeformataddmnts "+endtimeformataddmnts);
                                   // console.log(" endtimedt "+endtimedt);
                                   // console.log(" endtimehrs "+endtimehrs);
                                   var end_timedata = endtimehrs;

                                    var requestexpire_timedata_format = $("#ddlViewrequestexpire").val();
                                    var reqexpirehr = $("#requexpire_time_hr").val();
                                    var reqexpminval = $("#reqexpire_time_mnt").val();


                                    if(requestexpire_timedata_format == 1 && reqexpirehr!= 12){
                                      reqexpirehr = parseInt(reqexpirehr)+12;
                                    }

                                 //  var requestexpiredtimedata = reqexpirehr+':'+reqexpminval;//$("#requestexpiredtime").val();
                                  // console.log(" requestexpiredtimedata "+requestexpiredtimedata);

                                  //****************** getting new request expire date time format starts 29-12-2016

                                    var reqexpday = $("#requexpire_day").val();
                                    var reqexphr = $("#reqexpire_hour").val();
                                    var reqexpm  =$("#reqexpire_minute").val();

                                   
                                     var requestexpireddatedata ='';
                                     var requestexpiredtimedata ='';

                                    if(reqexpday!='' || reqexphr!='' || reqexpm!='')

                                    {

                                      if(reqexpday == '')
                                    {
                                      reqexpday = 0;
                                    }
                                    if(reqexphr == '')
                                    {
                                      reqexphr = 0;
                                    }
                                    if(reqexpm == '')
                                    {
                                      reqexpm = 0;
                                    }


                                    var reqexpday_hrs = parseInt(reqexpday*24);

                                    var getcurdttime = new Date();
                                    var getcurdttimemom = moment(getcurdttime).format("DD/MM/YYYY hh:mm A");
                                    var momentofcurrenttime = moment(getcurdttimemom,"DD/MM/YYYY hh:mm A");

                                    // console.log(getcurdttimemom+" momentofcurrenttime "+momentofcurrenttime);

                                    //*********** adding days with current date
                                    var reqformat_momentdy = moment(getcurdttimemom,"DD/MM/YYYY hh:mm A").add(reqexpday_hrs,"hours").format("DD/MM/YYYY hh:mm A");

                                    var reqformat_momentdyhr = moment(reqformat_momentdy,"DD/MM/YYYY hh:mm A").add(reqexphr,"hours").format("DD/MM/YYYY hh:mm A");

                                    var reqformat_momentdymn = moment(reqformat_momentdyhr,"DD/MM/YYYY hh:mm A").add(reqexpm,"minutes").format("DD/MM/YYYY hh:mm A");
                                    // alert("Hello");
                                    // alert(" reqformat_momentdymn hello "+reqformat_momentdymn);

                                    requestexpireddatedata = moment(reqformat_momentdymn,"DD/MM/YYYY hh:mm A").format("DD/MM/YYYY");
                                    requestexpiredtimedata = moment(reqformat_momentdymn,"DD/MM/YYYY hh:mm A").format("hh:mm A");
                                 }


                                    //****************** getting new request expire date time format ends 29-12-2016


                                    var venueownID = $("#venueID").val();

                                    var type_entry_insert = '';
                                   //alert(event_type_entry);
                                  // alert(event_type_entry);
                                   if (event_type_entry =='3') {
                                    type_entry_insert = $('input[name=radio_entry_type]:checked').val(); //"input[name=radio_entry_type]:checked"
                                   }else{
                                    type_entry_insert = event_type_entry;
                                   }
                                  // console.log(" type_entry_insert "+type_entry_insert);
                                   //console.log("Booking Token========>"+csrf);
                                   //************ Retriving value ends here
                                   
                                   //************** Ajax form submission starts here
                                    var bookingformdata = {_token:csrf_token_data,gig_description:gig_description,type_entry:type_entry_insert,bookingcat_subdata:bookingcat_subdata,bookinggenre_subdata:bookinggenre_subdata,security_paymentdata:security_paymentdata,total_paymentdata:total_paymentdata,cancellation_paymentdata:cancellation_paymentdata,booking_datedata:booking_datedata,start_timedata:start_timedata,end_timedata:end_timedata,enddatetime:endtimeformataddmnts,endtimedt:endtimedt,requestexpireddatedata:requestexpireddatedata,requestexpiredtimedata:requestexpiredtimedata,venueownID:venueownID,security_lock_id:security_lock_id_vnu,booking_lock_id:booking_lock_id_vnu,totalpay_lock_id:totalpay_lock_id_vnu,endtimehr_val:endtimehr_val,endtimemin_val:endtimemin_val};
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
                                              $("#continue_tosubmit" ).prop( "disabled", false );


                                               //******************** Extra added on 06-01-2017 starts here

                                              $("#myModal5").modal('hide');
                                              $("#myModal_6").modal('hide');
                                              $("#myModal_7").modal('hide');

                                              //******************** Extra added on 06-01-2017 ends here


                                               $("#myModal_8").modal('hide');
                                                clerallfrmfields();
                                                   toastr.remove();
                                              // var imfpth=base_url_data+"/public/front/otherfiles/progimages/loder.gif"
                                              // showmycustomloader(1,'4000','2000',"",imfpth);
                                              // $("#cancelbtn").click(); //***modal remove
                                              var success_message_data="Great! your Booking Request was sent ";
                                              poptriggerfunc(msgtype='success',titledata='',msgdata=success_message_data,sd=7000,hd=2500,tmo=3000,etmo=4000,poscls='toast-top-full-width');
                                              // alert('ewrewr');
                                              // console.log('werewrewrewrewrerewr');
                                            }
                                            }


                                        });


                                    //**************************************


                }else
                {
                 // $("#missingsomethingerror").removeClass('mydisplaynone');
                  toastr.remove();
                  poptriggerfunc(msgtype='error',titledata='',msgdata="Please ensure required fields are complete before submitting your request",sd=1000,hd=3000,tmo=2000,etmo=1000,poscls='toast-top-full-width'); 
                }

	return false;
});
//******************************** Modal for 3/4 function ends here *******************************************


// $('#myModal5').on('hidden.bs.modal', function () {
// 						// $("#bookingform1").trigger('reset');
// 						// $("#bookingform2").trigger('reset');
// 						// $("#bookingform3").trigger('reset');
// 						// $("#bookingform4").trigger('reset');
// 						$('input').parent().removeClass("errorField");
// 					    $('select').parent().removeClass("errorField");

					    
// 			   });

$('.popup-close').click(function(){
  clerallfrmfields();
})
$('#cancelbtn').click(function(){
  clerallfrmfields();
});

function clerallfrmfields()
{
   // $('#country_id').selectpicker('refresh');
    $('input').parent().removeClass("errorField");
    $('select').parent().removeClass("errorField");
    $("#bookingform1").trigger('reset');
    $("#bookingform2").trigger('reset');
    $("#bookingform3").trigger('reset');
    $("#bookingform4").trigger('reset');

     //******* extra added on 06-01-2017
    // $('#country_id').selectpicker('refresh');
    // $('#statelist').selectpicker('refresh');
    $("#ddlViewBy").selectpicker('val',2); 
    //******* extra added on 06-01-2017
}








