$('#booking_date').datetimepicker({
   				format: 'DD/MM/YYYY',
       			});
	$('#requestexpireddate').datetimepicker({
   				format: 'DD/MM/YYYY',
       			});


	$('#start_time_hr').keypress(function(key){

	if(key.charCode < 48 )
	{
		return false;
		
	}else
	{
		if(key.charCode > 57)
		return false;
	}
});
$('#start_time_mnt').keypress(function(key){

	if(key.charCode < 48 )
	{
		return false;
		
	}else
	{
		if(key.charCode > 57)
		return false;
	}
});$('#end_time_hr').keypress(function(key){

	if(key.charCode < 48 )
	{
		return false;
		
	}else
	{
		if(key.charCode > 57)
		return false;
	}
});$('#end_time_mnt').keypress(function(key){

	if(key.charCode < 48 )
	{
		return false;
		
	}else
	{
		if(key.charCode > 57)
		return false;
	}
});
$('#requexpire_time_hr').keypress(function(key){

	if(key.charCode < 48 )
	{
		return false;
		
	}else
	{
		if(key.charCode > 57)
		return false;
	}
});
$('#reqexpire_time_mnt').keypress(function(key){

	if(key.charCode < 48 )
	{
		return false;
		
	}else
	{
		if(key.charCode > 57)
		return false;
	}
});



//**************** For added zero 

function addzero(val1)
{
	return '0'+val1;
}
function addhr_ampm(val2)
{
	var firstval = (parseInt(val2)-12);
	if(firstval.toString().length == 1)
	{
		console.log("firstval "+firstval);
		return addzero(firstval);
	}else{
		console.log("firstval2 "+firstval);
	return firstval;
	}
}

//****************  For added zero 



	 var momentdate = moment().format("DD/MM/YYYY h:mm a");
	 var mindatereqexpire = moment().format("DD/MM/YYYY");
	 var datecur_adddate =  moment(momentdate,"DD/MM/YYYY h:mm a").add(4,"hours").format("DD/MM/YYYY"); 
	 $('#booking_date').data("DateTimePicker").minDate(datecur_adddate);
	 $('#requestexpireddate').data("DateTimePicker").minDate(mindatereqexpire);	

	  $("#booking_date").on("dp.change", function(e)
                {
                	 var bookingdate = $("#booking_date").val();
                	 //$('#requestexpireddate').data("DateTimePicker").maxDate(bookingdate);	
                	 $("#start_time_hr").val('');
                	 $("#start_time_mnt").val(''); 
                	 $("#ddlViewBy").val('');
                	 $('#requestexpireddate').data("DateTimePicker").date(null);

						$("#end_time_hr").val('');
						$("#end_time_mnt").val('');
						$("#ddlViewend").val('');
                });


	  $('#start_time_hr').keyup(function(key){


	  	$('#start_time_hr').parent().removeClass("errorField");
        

				var bookingdatevalue = $("#booking_date").val(); ////****** booking date value
				var starttime_hrval = $("#start_time_hr").val(); ////****** start time
				var starttimelength = $("#start_time_hr").val().length; ////****** start time length
				//var formattypeval = $("#ddlViewBy").val(); //************* format type val
				var strtdateformat = $("#ddlViewBy").val(); // start time format
				var getcurdttime = new Date(); //getting current date in javascript format
                var curentdate = moment(getcurdttime).format("DD/MM/YYYY hh:mm a"); //getting current date in  DD/MM/YYYY hh:mm a format
                var subtractdate =  moment(curentdate,"DD/MM/YYYY h:mm a").add(4,"hours").format("DD/MM/YYYY"); //****date
                var subtracttimehr_24 =  moment(curentdate,"DD/MM/YYYY h:mm a").add(4,"hours").format("HH"); //**** hour
                var subtracttimemn =  moment(curentdate,"DD/MM/YYYY h:mm a").add(4,"hours").format("mm"); //**** minute
                var subtracttimehr_ampm =  moment(curentdate,"DD/MM/YYYY h:mm a").add(4,"hours").format("hh"); //**** hour

					if(bookingdatevalue == "")
					{
						$("#start_time_hr").val(''); 
					}

				if(starttimelength > 1 && starttimelength < 3)
				{

					////***** condition for checking if start date value and after four hour date value is same
						

				}
				else if(starttimelength >2)
				{
					$("#start_time_hr").val('');
				}	    

				$("#end_time_hr").val('');
				$("#end_time_mnt").val('');
				$("#ddlViewend").val('');
				$("#start_time_mnt").val(''); // cleaning minute data
	  });


	  //*************** start time blur 







	  $('#start_time_hr').blur(function(key){

	  	var starttimeval_hr = $('#start_time_hr').val();
		var strttimeformatval = $("#ddlViewBy").val();




		var bookingdatevalue = $("#booking_date").val(); ////****** booking date value

		var strtdateformat = $("#ddlViewBy").val(); // start time format
		var getcurdttime = new Date(); //getting current date in javascript format
		var curentdate = moment(getcurdttime).format("DD/MM/YYYY hh:mm a"); //getting current date in  DD/MM/YYYY hh:mm a format
		var subtractdate =  moment(curentdate,"DD/MM/YYYY h:mm a").add(4,"hours").format("DD/MM/YYYY"); //****date
		var subtracttimehr_24 =  moment(curentdate,"DD/MM/YYYY h:mm a").add(4,"hours").format("HH"); //**** hour
		var subtracttimemn =  moment(curentdate,"DD/MM/YYYY h:mm a").add(4,"hours").format("mm"); //**** minute
		var subtracttimehr_ampm =  moment(curentdate,"DD/MM/YYYY h:mm a").add(4,"hours").format("hh"); //**** hour

		var htmntfrmat = moment(curentdate,"DD/MM/YYYY h:mm a").add(4,"hours").format("a");

		if(htmntfrmat == 'am')
		{
			htmntfrmat_check =1; 
		}else if(htmntfrmat == 'pm')
		{
			htmntfrmat_check =2; 
		}

//console.log("subtracttimehr_ampm "+subtracttimehr_ampm+" "+htmntfrmat_check);


		if(starttimeval_hr!="" && starttimeval_hr < 24)
		{
			

			// if(starttimeval_hr == 12 && strtdateformat == 1)
			// {
			// 	$('#start_time_hr').val('00');
			// }else if(starttimeval_hr == 12 && strtdateformat == 2)
			// {
			// 	$('#start_time_hr').val(starttimeval_hr);
			// }else if(starttimeval_hr == 00 && strtdateformat == 1)
			// {
			// 	$('#start_time_hr').val(starttimeval_hr);
			// }
			// else if(starttimeval_hr == 00 && strtdateformat == 2)
			// {
			// 	$('#start_time_hr').val(12);
			// }




			if(starttimeval_hr < 10 && starttimeval_hr.length==1)
			{
				starttimeval_hr = addzero(starttimeval_hr);
				$('#start_time_hr').val(starttimeval_hr);

			}else if(starttimeval_hr > 12 && starttimeval_hr.length==2 && starttimeval_hr <24)
			{
				
				starttimeval_hr = addhr_ampm(starttimeval_hr);
				$('#start_time_hr').val(starttimeval_hr);
				// $("#ddlViewBy").val(2);
			//	alert("Hello");
				$("#ddlViewBy").selectpicker('val',2);


			}
		}else
		{
						$('#start_time_hr').val('');
						$("#start_time_hr_error").html('You have entered a invalid value');
						$("#start_time_hr_error").css("display", "block");

						setTimeout(function(){
						$("#start_time_hr_error").css("display", "none");
						},2000);
		}



			$("#end_time_hr").val('');
			$("#end_time_mnt").val('');
			$("#ddlViewend").val('');
			$("#start_time_mnt").val(''); // cleaning minute data
			 clearrequestexpiredate();

	  });




	  //*************** start minute blur 

	  $('#start_time_mnt').blur(function(key)
	  {
	  	$('#start_time_mnt').parent().removeClass("errorField");
	  	var starttimeval_mnt = $('#start_time_mnt').val();
		var strttimeformatval = $("#ddlViewBy").val();

		if(starttimeval_mnt!="" && starttimeval_mnt <60 )
		{



			if(starttimeval_mnt < 10 && starttimeval_mnt.length==1)
			{
				starttimeval_mnt =addzero(starttimeval_mnt);
				$('#start_time_mnt').val(starttimeval_mnt);
			}

		}else{
						$('#start_time_mnt').val('');
						$("#start_time_hr_error").html('You have entered a invalid value');
						$("#start_time_hr_error").css("display", "block");

						setTimeout(function(){
						$("#start_time_hr_error").css("display", "none");
						},2000);
		}

					$("#end_time_hr").val('');
					$("#end_time_mnt").val('');
					$("#ddlViewend").val('');
					 clearrequestexpiredate();







	  });

	  //*********end time hr key up starts

	  $('#end_time_hr').keyup(function(key)
	  {
	  	$('#end_time_hr').parent().removeClass("errorField");
		var res = fourhrcalcularion_start();
		var r = res.split(",");

		var fourhourpreviousmoment = r[0];
		var bookingdatetotadatetime_momentval = r[1];

         if(bookingdatetotadatetime_momentval < fourhourpreviousmoment)
         {
         	
         	clear_starttime_hr();
         	clear_starttime_mnt();

         	$('#start_time_hr').parent().addClass("errorField");
         	$('#start_time_mnt').parent().addClass("errorField");


         }else
         {
         	$('#start_time_hr').parent().removeClass("errorField");
         	$('#start_time_mnt').parent().removeClass("errorField");
         }



         var bookingdatevalue = $("booking_date").val();
         if(bookingdatevalue!='')
				{
					$('#requestexpireddate').prop("disabled", false);  
                    $('#requestexpiredtime').prop("disabled", false);   
				}

		 //***************set request expire date starts here
		 setrequestexpiredate();
		 clearrequestexpiredate();
		 //***************set request expire date ends here






	  });

	  //*********end time hr key up ends

	  //********* end time minute keyup starts
	   $('#end_time_mnt').keyup(function(key)
	  {
	  	var endtimenmtval = $("#end_time_mnt").val();
	  	if(endtimenmtval > 59)
	  	{
	  		$("#end_time_mnt").val('');
	  	}
	  });
	  //********** end time minute key up ends


	   //*************** end time blur 

	  $('#end_time_hr').blur(function(key){

	  	
	  			var end_time_hr = $('#end_time_hr').val();
				if(end_time_hr < 10 && end_time_hr.length==1)
				{
					end_time_hr =addzero(end_time_hr);
					$('#end_time_hr').val(end_time_hr);
				}else if(end_time_hr > 23)
				{
					$('#end_time_hr').parent().addClass("errorField");
					$('#end_time_hr').val('');
				}
			

					
	  });




	  //*************** end minute blur 

	  $('#end_time_mnt').blur(function(key)
	  {

	  	//**********end time starts
	  	var end_time_hr = $('#end_time_hr').val();
	  	var end_time_mnt = $('#end_time_mnt').val();
		var ddlViewend = $("#ddlViewend").val();

		//******** start time starts

		var start_time_hr = $('#start_time_hr').val();
	  	var start_time_mnt = $('#start_time_mnt').val();
		var ddlViewBy = $("#ddlViewBy").val();


		if(end_time_mnt!="" && end_time_mnt < 60)
		{
			if(end_time_mnt < 10 && end_time_mnt.length==1)
			{
				end_time_mnt =addzero(end_time_mnt);
				$('#end_time_mnt').val(end_time_mnt);
			
			}
			
		}else{
				$('#end_time_mnt').val('');

				$("#end_time_hr_error").html('You have entered a invalid value');
				$("#end_time_hr_error").css("display", "block");

					setTimeout(function(){
					$("#end_time_hr_error").css("display", "none");
					},2000);
		}



	  });


	  //**** start time option starts here

	  $("#ddlViewBy").change(function(){
	  	
	  	var startdateval = $("#booking_date").val();
	  	var starttimehrval =  $("#start_time_hr").val();
	  	var starttimemnval =  $("#start_time_mnt").val();
	  	var ddlViewByval = $("#ddlViewBy").val();

	  	var getcurdttime = new Date(); //getting current date in javascript format
		var curentdate = moment(getcurdttime).format("DD/MM/YYYY hh:mm a"); //getting current date in  DD/MM/YYYY hh:mm a format
		var subtractdate =  moment(curentdate,"DD/MM/YYYY h:mm a").add(4,"hours").format("DD/MM/YYYY"); //****date
		var subtracttimehr_24 =  moment(curentdate,"DD/MM/YYYY h:mm a").add(4,"hours").format("HH"); //**** hour
		var subtracttimemn =  moment(curentdate,"DD/MM/YYYY h:mm a").add(4,"hours").format("mm"); //**** minute
		var subtracttimehr_ampm =  moment(curentdate,"DD/MM/YYYY h:mm a").add(4,"hours").format("hh"); //**** hour
		var subtractdatetimeformat = moment(curentdate,"DD/MM/YYYY h:mm a").add(4,"hours").format("a"); //**** hour


		//console.log("subtractdatetimeformat "+subtractdatetimeformat+" ddlViewByval "+ddlViewByval);


		var startdateformat = "";
		if(subtractdatetimeformat == 'am')
		{
			startdateformat = 1;
		}else if(subtractdatetimeformat == 'pm')
		{
			startdateformat = 2;
		}

		if(subtractdate == startdateval)
		{
			if(ddlViewByval == startdateformat)
			{
				
					if( starttimehrval >= subtracttimehr_ampm)
					{
						
					}else
					{	
						//console.log("I am here too");

								$('#start_time_hr').val('');
								$('#start_time_mnt').val('');

								$('#start_time_hr').parent().addClass("errorField");
								$('#start_time_mnt').parent().addClass("errorField");

								// setTimeout(function(){
								// $("#start_time_hr_error").css("display", "none");
								// },2000);

								} 
				
			}else if(startdateformat < ddlViewByval)
			{

			}else
			{
								$('#start_time_hr').val('');
								$('#start_time_mnt').val('');

								$('#start_time_hr').parent().addClass("errorField");
								$('#start_time_mnt').parent().addClass("errorField");

								// setTimeout(function(){
								// $("#start_time_hr_error").css("display", "none");
								// },2000);

						 
			}
		}



	  	$("#end_time_hr").val('');
	  	$("#end_time_mnt").val('');
	  	$("#ddlViewend").val('');
	  	clearrequestexpiredate();




	  });


	  //**** ends time option ends here

	  $("#ddlViewend").change(function(){
	  	
	  	var ddlViewend = $("#ddlViewend").val();
	  	var ddlViewBy = $("#ddlViewBy").val();

	  	if(ddlViewBy > ddlViewend)
	  	{
			$("#end_time_hr").val('');
			$("#end_time_mnt").val('');
			$("#ddlViewend").val('');
	  	}



	  });





	  //**************** request expire date and time starts here

	   $("#requestexpireddate").on("dp.change", function(e)
                {
                	$('#requexpire_time_hr').val('');
                	$('#reqexpire_time_mnt').val('');
                	$('#ddlViewrequestexpire').val('');
                });


	   //******* request expire time hour key up starts
	    $('#requexpire_time_hr').keyup(function(key){
	    	$('#requexpire_time_hr').parent().removeClass("errorField");
	    	var requestexpireddate_val = $("#requestexpireddate").val();
	    	if(requestexpireddate_val == "")
	    	{
	    		$('#requexpire_time_hr').val('');
	    	}

	    	var requestexpireddate_length = $('#requexpire_time_hr').val().length;
		  	if(requestexpireddate_length > 2)
		  	{
		  		$('#requexpire_time_hr').val('');
		  	}

		  	var reqepirehrval = $('#requexpire_time_hr').val();
		  	if(reqepirehrval > 23)
		  	{
		  		$('#requexpire_time_hr').val('');
		  		//$('#requexpire_time_hr').parent().Class("errorField");
		  	}

	    });



	  //******* request expire time hour key up ends


	  //******* request expire time hour blur starts

	  	 $('#requexpire_time_hr').blur(function(key){
	  	 	var reqepirehrval = $('#requexpire_time_hr').val();
		  	if(reqepirehrval > 23)
		  	{
		  		$('#requexpire_time_hr').val('');
		  		$('#requexpire_time_hr').parent().addClass("errorField");
		  	}


		  	if(reqepirehrval < 10 && reqepirehrval.length==1)
			{
				reqepirehrval = addzero(reqepirehrval);
				$('#requexpire_time_hr').val(reqepirehrval);

			}else if(reqepirehrval > 12 && reqepirehrval.length==2 && reqepirehrval <24)
			{
				
				reqepirehrval = addhr_ampm(reqepirehrval);
				$('#requexpire_time_hr').val(reqepirehrval);
				$("#ddlViewrequestexpire").selectpicker('val',1);
			

			}







// 	  	 	var requestexpireddate_val = $("#requestexpireddate").val();

// 	  	 	var requestexpireddatehr_val = $("#requexpire_time_hr").val();
// 	  	 	var requestexpireddatemnt_val = $("#reqexpire_time_mnt").val();
// 	  	 	var requestexpireformat = $("#ddlViewrequestexpire").val();

// 	  	 	var requestexpireformatval = "";

// 	  	 	// if(requestexpireformat == 1)
// 	  	 	// {
// 	  	 	// 	requestexpireformatval = 'am';
// 	  	 	// }else
// 	  	 	// {
// 	  	 	// 	requestexpireformatval = 'pm';
// 	  	 	// }

// 	  	 	if(requestexpireddatemnt_val == "")
// 	  	 	{
// 	  	 		requestexpireddatemnt_val = '00';
// 	  	 	}



// if(requestexpireddatehr_val!="" && requestexpireddatehr_val < 24)
// 		{
// 				if(requestexpireddatehr_val < 10 && requestexpireddatehr_val.length==1)
// 				{
// 					requestexpireddatehr_val =addzero(requestexpireddatehr_val);

// 					$("#requexpire_time_hr").val(requestexpireddatehr_val);
// 				}else if(requestexpireddatehr_val > 12 && requestexpireddatehr_val.length==2 && requestexpireddatehr_val <24)
// 				{
					
// 					requestexpireddatehr_val = addhr_ampm(requestexpireddatehr_val);
// 					$('#requexpire_time_hr').val(requestexpireddatehr_val);
// 					$("#ddlViewrequestexpire").val(2);

// 					 requestexpireformat = $("#ddlViewrequestexpire").val();
// 				}

// 			if(requestexpireformat == 1)
// 	  	 	{
// 	  	 		requestexpireformatval = 'am';
// 	  	 	}else
// 	  	 	{
// 	  	 		requestexpireformatval = 'pm';
// 	  	 	}
// 				console.log("requestexpireddatehr_val "+requestexpireddatehr_val+" requestexpireddatemnt_val "+requestexpireddatemnt_val+"requestexpireformat "+requestexpireformatval);



// 	  	 	requestexpireddate_val = moment(requestexpireddate_val,"DD/MM/YYYY").format('MM/DD/YYYY');
// 	  	 	var requestexpiretimeval = requestexpireddate_val+' '+requestexpireddatehr_val+':'+requestexpireddatemnt_val+":00 "+requestexpireformatval;

// 	    	var getcurdttime = new Date(); //getting current date in javascript format
// 			var curentdate = moment(getcurdttime).format("DD/MM/YYYY hh:mm a"); //getting current date in  DD/MM/YYYY 

			

// 			var reqestexpiretimefunc = reqestexpiredateconversion(requestexpiretimeval);
	    		
	    	
// 	    	if(reqestexpiretimefunc == false)
// 	    	{
// 	    						$('#requexpire_time_hr').val('');
// 								$('#reqexpire_time_mnt').val('');
// 								$('#ddlViewrequestexpire').val('');
// 								$("#requexpire_time_hr_error").html('You have entered  invalid value');
// 								$("#requexpire_time_hr_error").css("display", "block");

// 								setTimeout(function(){
// 								$("#requexpire_time_hr_error").css("display", "none");
// 								},2000);
// 	    	}

// 	    	var reqestexpiretimefuncmin = reqestexpiredateconversionmindate(requestexpiretimeval);

// 	    	if(reqestexpiretimefuncmin == false)
// 	    	{
// 	    						$('#requexpire_time_hr').val('');
// 								$('#reqexpire_time_mnt').val('');
// 								$('#ddlViewrequestexpire').val('');
// 								$("#requexpire_time_hr_error").html('You have entered  invalid value');
// 								$("#requexpire_time_hr_error").css("display", "block");

// 								setTimeout(function(){
// 								$("#requexpire_time_hr_error").css("display", "none");
// 								},2000);
// 	    	}
	    	
// 	    }else{
// 	    					$('#requexpire_time_hr').val('');
// 								$('#reqexpire_time_mnt').val('');
// 								$('#ddlViewrequestexpire').val('');
// 								$("#requexpire_time_hr_error").html('You have entered  invalid value');
// 								$("#requexpire_time_hr_error").css("display", "block");

// 								setTimeout(function(){
// 								$("#requexpire_time_hr_error").css("display", "none");
// 								},2000);





// 	    }


// 	  	 });
// 	  //******* request expire time hour blur starts
// 	  $('#reqexpire_time_mnt').keyup(function(key){

// 	  	var requestexpiretimeval  =$("#requexpire_time_hr").val();

// 				if( requestexpiretimeval == "")
// 		  	 	{
// 		  	 		$("#reqexpire_time_mnt").val('');
// 		  	 	}

// 		 var requestexpireddate_length = $('#reqexpire_time_mnt').val().length;
// 		  	if(requestexpireddate_length > 2)
// 		  	{
// 		  		$('#reqexpire_time_mnt').val('');
// 		  	}
// 		  	var reqexpiremntval = $('#reqexpire_time_mnt').val();
// 		  	if(reqexpiremntval > 59)
// 		  	{
// 		  		$('#reqexpire_time_mnt').val('');
// 		  	}

 });


	$('#reqexpire_time_mnt').keyup(function(key){
		//alert("Hello");


			var requestexpireddate_length = $('#reqexpire_time_mnt').val().length;
		  	if(requestexpireddate_length > 2)
		  	{
		  		$('#reqexpire_time_mnt').val('');
		  	}
		  	var reqexpiremntval = $('#reqexpire_time_mnt').val();
		  	if(reqexpiremntval > 59)
		  	{
		  		$('#reqexpire_time_mnt').val('');
		  	}


	});

	  $('#reqexpire_time_mnt').blur(function(key){

// 	  	 	var requestexpireddate_val = $("#requestexpireddate").val();

// 	  	 	var requestexpireddatehr_val = $("#requexpire_time_hr").val();
// 	  	 	var requestexpireddatemnt_val = $("#reqexpire_time_mnt").val();
// 	  	 	var requestexpireformat = $("#ddlViewrequestexpire").val();

// 	  	 	var requestexpireformatval = "";

// 	  	 	if(requestexpireformat == 1)
// 	  	 	{
// 	  	 		requestexpireformatval = 'am';
// 	  	 	}else
// 	  	 	{
// 	  	 		requestexpireformatval = 'pm';
// 	  	 	}

// 	  	 	if(requestexpireddatemnt_val == "")
// 	  	 	{
// 	  	 		requestexpireddatemnt_val = '00';
// 	  	 	}


// 	  	 	if(requestexpireddatemnt_val < 10 && requestexpireddatemnt_val.length==1)
// 			{
// 				requestexpireddatemnt_val =addzero(requestexpireddatemnt_val);
// 				$("#reqexpire_time_mnt").val(requestexpireddatemnt_val);
// 			}


// if(requestexpireddatemnt_val!="" && requestexpireddatemnt_val < 60)
// 		{


// 	  	 	requestexpireddate_val = moment(requestexpireddate_val,"DD/MM/YYYY").format('MM/DD/YYYY');
// 	  	 	var requestexpiretimeval = requestexpireddate_val+' '+requestexpireddatehr_val+':'+requestexpireddatemnt_val+":00 "+requestexpireformatval;

// 	    	var getcurdttime = new Date(); //getting current date in javascript format
// 			var curentdate = moment(getcurdttime).format("DD/MM/YYYY hh:mm a"); //getting current date in  DD/MM/YYYY 

// 			// console.log("curentdate"+curentdate+" requestexpireddate_val "+requestexpireddate_val);
// 			//console.log("requestexpiretimeval"+requestexpiretimeval);

// 			var reqestexpiretimefunc = reqestexpiredateconversion(requestexpiretimeval);
	    		
// 	    	//console.log(reqestexpiretimefunc);
// 	    	if(reqestexpiretimefunc == false)
// 	    	{
// 	    						$('#requexpire_time_hr').val('');
// 								$('#reqexpire_time_mnt').val('');
// 								$('#ddlViewrequestexpire').val('');
// 								$("#requexpire_time_hr_error").html('You have entered  invalid value');
// 								$("#requexpire_time_hr_error").css("display", "block");

// 								setTimeout(function(){
// 								$("#requexpire_time_hr_error").css("display", "none");
// 								},2000);
// 	    	}

// 	    	var reqestexpiretimefuncmin = reqestexpiredateconversionmindate(requestexpiretimeval);

// 	    	if(reqestexpiretimefuncmin == false)
// 	    	{
// 	    						$('#requexpire_time_hr').val('');
// 								$('#reqexpire_time_mnt').val('');
// 								$('#ddlViewrequestexpire').val('');
// 								$("#requexpire_time_hr_error").html('You have entered  invalid value');
// 								$("#requexpire_time_hr_error").css("display", "block");

// 								setTimeout(function(){
// 								$("#requexpire_time_hr_error").css("display", "none");
// 								},2000);
// 	    	}
	    	
// }else{

// 								$('#reqexpire_time_mnt').val('');
// 								$('#ddlViewrequestexpire').val('');
// 								$("#requexpire_time_hr_error").html('You have entered  invalid value');
// 								$("#requexpire_time_hr_error").css("display", "block");

// 								setTimeout(function(){
// 								$("#requexpire_time_hr_error").css("display", "none");
// 								},2000);
// }


	  	 });
	  //******* request expire time hour blur starts



	  $("#ddlViewrequestexpire").change(function(){


	  // 		var requestexpireddate_val = $("#requestexpireddate").val();

	  // 	 	var requestexpireddatehr_val = $("#requexpire_time_hr").val();
	  // 	 	var requestexpireddatemnt_val = $("#reqexpire_time_mnt").val();
	  // 	 	var requestexpireformat = $("#ddlViewrequestexpire").val();

	  // 	 	var requestexpireformatval = "";

		 //  	 if(requestexpireddatehr_val!="" && requestexpireddatemnt_val!="")	
		 //  	 {

		 //  	 	if(requestexpireformat == 1)
		 //  	 	{
		 //  	 		requestexpireformatval = 'am';
		 //  	 	}else
		 //  	 	{
		 //  	 		requestexpireformatval = 'pm';
		 //  	 	}

		 //  	 	if(requestexpireddatemnt_val == "")
		 //  	 	{
		 //  	 		requestexpireddatemnt_val = '00';
		 //  	 	}





			// 	  	 	requestexpireddate_val = moment(requestexpireddate_val,"DD/MM/YYYY").format('MM/DD/YYYY');
			// 	  	 	var requestexpiretimeval = requestexpireddate_val+' '+requestexpireddatehr_val+':'+requestexpireddatemnt_val+":00 "+requestexpireformatval;

			// 	    	var getcurdttime = new Date(); //getting current date in javascript format
			// 			var curentdate = moment(getcurdttime).format("DD/MM/YYYY hh:mm a"); //getting current date in  DD/MM/YYYY 

			// 			// console.log("curentdate"+curentdate+" requestexpireddate_val "+requestexpireddate_val);
			// 			//console.log("requestexpiretimeval"+requestexpiretimeval);

			// 			var reqestexpiretimefunc = reqestexpiredateconversion(requestexpiretimeval);
				    		
			// 	    	//console.log(reqestexpiretimefunc);
			// 	    	if(reqestexpiretimefunc == false)
			// 	    	{
			// 	    						$('#requexpire_time_hr').val('');
			// 								$('#reqexpire_time_mnt').val('');
			// 								//$('#ddlViewrequestexpire').val('');
			// 								$("#requexpire_time_hr_error").html('You have entered  invalid value');
			// 								$("#requexpire_time_hr_error").css("display", "block");

			// 								setTimeout(function(){
			// 								$("#requexpire_time_hr_error").css("display", "none");
			// 								},2000);
			// 	    	}

			// 	    	var reqestexpiretimefuncmin = reqestexpiredateconversionmindate(requestexpiretimeval);

			// 	    	if(reqestexpiretimefuncmin == false)
			// 	    	{
			// 	    						$('#requexpire_time_hr').val('');
			// 								$('#reqexpire_time_mnt').val('');
			// 							//	$('#ddlViewrequestexpire').val('');
			// 								$("#requexpire_time_hr_error").html('You have entered  invalid value');
			// 								$("#requexpire_time_hr_error").css("display", "block");

			// 								setTimeout(function(){
			// 								$("#requexpire_time_hr_error").css("display", "none");
			// 								},2000);
			// 	    	}



			// }

	  });






	  //****************  request expire date and time ends here


	  function reqestexpiredateconversion(requestdatetime)
	  {
	  		var bookingdateval = $("#booking_date").val();
	    	var bookinghrval = $("#start_time_hr").val();
	    	var bookingmntval = $("#start_time_mnt").val(); 
	    	var bookingformat = $("#ddlViewBy").val(); 
	    	var bookingformatcheck = "";
	    	if(bookingformat == 1)
	    	{
	    		bookingformatcheck = 'am';
	    	}else if(bookingformat == 2)
	    	{
	    		bookingformatcheck = 'pm';
	    	}
	    	
	    		//bookingdateval = "22/10/2016";

	    	bookingdateval = moment(bookingdateval,"DD/MM/YYYY").format('MM/DD/YYYY');
	    	var complete_startdate = bookingdateval+' '+bookinghrval+':'+bookingmntval+':00 '+bookingformatcheck;
	    
			var date1 = new Date(complete_startdate);
			//var date1 = new Date();
			var date2 = new Date(requestdatetime);
			var timeDiff = Math.abs(date1.getTime() - date2.getTime());

			console.log("complete_startdate "+complete_startdate+" requestdatetime"+requestdatetime);

			var fourhourtime = (timeDiff-(1000 * 3600 * 4));
			//var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 4)); 
			console.log("timeDiff "+timeDiff+" fourhourtime"+fourhourtime);
			
			if(fourhourtime >= 0)
			{
				return true;
			}else
			{
				return false;
			}
			
			//return diffDays;
			//console.log();

	  }


	  

	  function reqestexpiredateconversionmindate(requestdatetime)
	  {
	  		var bookingdateval = $("#booking_date").val();
	    	var bookinghrval = $("#start_time_hr").val();
	    	var bookingmntval = $("#start_time_mnt").val(); 
	    	var bookingformat = $("#ddlViewBy").val(); 
	    	var bookingformatcheck = "";
	    	if(bookingformat == 1)
	    	{
	    		bookingformatcheck = 'am';
	    	}else if(bookingformat == 2)
	    	{
	    		bookingformatcheck = 'pm';
	    	}
	    	

	    	bookingdateval = moment(bookingdateval,"DD/MM/YYYY").format('MM/DD/YYYY');
	    	var complete_startdate = bookingdateval+' '+bookinghrval+':'+bookingmntval+':00 '+bookingformatcheck;
	    
			//var date1 = new Date(complete_startdate);
			var date1 = new Date();

			date1 = moment(date1).format("MM/DD/YYYY hh:mm:ss a");
			date1  = new Date(date1);
			var date2 = new Date(requestdatetime);
			

			if(date2.getTime() > date1.getTime())
			{
				return true;
			}else
			{
				return false;
			}


	  }

	  //reqestexpiredateconversion('22/10/2016');




	  function fourhrcalcularion_start()
	  {
	  	  var booking_dateval = $("#booking_date").val();
		  var start_time_hrval = $("#start_time_hr").val();
		  var start_time_mntval = $("#start_time_mnt").val();
		  var starttimeformatval = $("#ddlViewBy").val();
		  var starttimeformatval_text;
		  if(starttimeformatval == 1)
		  {
		  	
		  	starttimeformatval_text = 'am';

		  }else if(starttimeformatval == 2)
		  {
		  	starttimeformatval_text = 'pm';
		  }

		  var getcurdttime = new Date();
          var getcurdttimemom = moment(getcurdttime).format("DD/MM/YYYY hh:mm A");
          var getcurdttimemomadd=moment(getcurdttimemom,"DD/MM/YYYY hh:mm A").add(4,"hours").format("DD/MM/YYYY" );
          var getcurdttimemomaddtime=moment(getcurdttimemom,"DD/MM/YYYY hh:mm A").add(4,"hours").format("h:mm A" );

          var curplusfour = getcurdttimemomadd +" "+getcurdttimemomaddtime;

          var fourhourpreviousmoment = moment(curplusfour,'MM/DD/YYYY hh:mm A');
        // alert(" curplusfour "+curplusfour+" fourhourpreviousmoment "+fourhourpreviousmoment+" getcurdttimemom "+getcurdttimemom);

         var bookingdatetotadatetime = booking_dateval+' '+start_time_hrval+':'+start_time_mntval+starttimeformatval_text;
         var bookingdatetotadatetime_momentval = moment(bookingdatetotadatetime,'MM/DD/YYYY hh:mm A');

         var aaaa = fourhourpreviousmoment+','+bookingdatetotadatetime_momentval;

         return aaaa;
	  }


	  //*************** set request expire date starts here

		function setrequestexpiredate()
	  {
	  	var booking_dateval = $("#booking_date").val();
	  	var start_time_hr = $("#start_time_hr").val();
	  	var start_time_mnt = $("#start_time_mnt").val();
	  	var ddlViewBy = $("#ddlViewBy").val();
	  	var timeformat;
	  	 if(ddlViewBy == 1)
	  	{
	  		 timeformat = 'am';
	  	}else
	  	{
	  		timeformat = 'pm';
	  	}

	  	// console.log(" booking_dateval "+booking_dateval+" start_time_hr "+start_time_hr+" start_time_mnt "+start_time_mnt+" timeformat"+timeformat);
	  	var totaltime =  booking_dateval+" "+start_time_hr+":"+start_time_mnt+" "+timeformat;
	  	fourhr = moment(totaltime,"DD/MM/YYYY hh:mm A").subtract(4,"hours").format("DD/MM/YYYY");
	  	//console.log(" totaltime "+totaltime+" fourhr "+fourhr);
	  	$("#requestexpireddate").data("DateTimePicker").maxDate(fourhr);




	  }





	  function clear_starttime_hr()
	  {
	  	$("#start_time_hr").val('');
	  }
	   function clear_starttime_mnt()
	  {
	  	$("#start_time_mnt").val('');
	  }

	   function clearrequestexpiredate()
	  {
	  	$("#requestexpireddate").val('');
	  	// $("#requestexpireddate").data('');
	  	$("#requestexpireddate").data("DateTimePicker").date(null);
	  }
	 


