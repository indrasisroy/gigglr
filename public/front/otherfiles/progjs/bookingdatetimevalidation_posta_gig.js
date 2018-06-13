$('#booking_date_gig').datetimepicker({
   				format: 'DD/MM/YYYY',
       			});
	$('#requestexpireddate_gig').datetimepicker({
   				format: 'DD/MM/YYYY',
       			});


	$('#start_time_hr_gig').keypress(function(key){

	if(key.charCode < 48 )
	{
		return false;
		
	}else
	{
		if(key.charCode > 57)
		return false;
	}
});
$('#start_time_mnt_gig').keypress(function(key){

	if(key.charCode < 48 )
	{
		return false;
		
	}else
	{
		if(key.charCode > 57)
		return false;
	}
});$('#end_time_hr_gig').keypress(function(key){

	if(key.charCode < 48 )
	{
		return false;
		
	}else
	{
		if(key.charCode > 57)
		return false;
	}
});$('#end_time_mnt_gig').keypress(function(key){

	if(key.charCode < 48 )
	{
		return false;
		
	}else
	{
		if(key.charCode > 57)
		return false;
	}
});
$('#requexpire_time_hr_gig').keypress(function(key){

	if(key.charCode < 48 )
	{
		return false;
		
	}else
	{
		if(key.charCode > 57)
		return false;
	}
});
$('#reqexpire_time_mnt_gig').keypress(function(key){

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
	 $('#booking_date_gig').data("DateTimePicker").minDate(datecur_adddate);
	 $('#requestexpireddate_gig').data("DateTimePicker").minDate(mindatereqexpire);	

	  $("#booking_date_gig").on("dp.change", function(e)
                {
                	 var bookingdate = $("#booking_date_gig").val();
                	 //$('#requestexpireddate_gig').data("DateTimePicker").maxDate(bookingdate);	
                	 $("#start_time_hr_gig").val('');
                	 $("#start_time_mnt_gig").val(''); 
                	 $("#ddlViewBy_gig").val('');
                	 $('#requestexpireddate_gig').data("DateTimePicker").date(null);

						$("#end_time_hr_gig").val('');
						$("#end_time_mnt_gig").val('');
						//$("#ddlViewend_gig").val('');

						$("#ddlViewBy_gig").selectpicker('refresh');
						$("#ddlViewBy_gig").selectpicker('val',0);
                });


	  $('#start_time_hr_gig').keyup(function(key){


	  	$('#start_time_hr_gig').parent().removeClass("errorField");
	  	$('#booking_date_gig').parent().removeClass("errorField");
        

				var bookingdatevalue = $("#booking_date_gig").val(); ////****** booking date value
				var starttime_hrval = $("#start_time_hr_gig").val(); ////****** start time
				var starttimelength = $("#start_time_hr_gig").val().length; ////****** start time length
				//var formattypeval = $("#ddlViewBy_gig").val(); //************* format type val
				var strtdateformat = $("#ddlViewBy_gig").val(); // start time format
				var getcurdttime = new Date(); //getting current date in javascript format
                var curentdate = moment(getcurdttime).format("DD/MM/YYYY hh:mm a"); //getting current date in  DD/MM/YYYY hh:mm a format
                var subtractdate =  moment(curentdate,"DD/MM/YYYY h:mm a").add(4,"hours").format("DD/MM/YYYY"); //****date
                var subtracttimehr_24 =  moment(curentdate,"DD/MM/YYYY h:mm a").add(4,"hours").format("HH"); //**** hour
                var subtracttimemn =  moment(curentdate,"DD/MM/YYYY h:mm a").add(4,"hours").format("mm"); //**** minute
                var subtracttimehr_ampm =  moment(curentdate,"DD/MM/YYYY h:mm a").add(4,"hours").format("hh"); //**** hour

					if(bookingdatevalue == "")
					{
						$('#booking_date_gig').parent().addClass("errorField");
						$("#start_time_hr_gig").val(''); 
					}

				if(starttimelength > 1 && starttimelength < 3)
				{

					////***** condition for checking if start date value and after four hour date value is same
						

				}
				else if(starttimelength >2)
				{
					$("#start_time_hr_gig").val('');
				}	    

				$("#end_time_hr_gig").val('');
				$("#end_time_mnt_gig").val('');
				$("#ddlViewend_gig").val('');
				$("#start_time_mnt_gig").val(''); // cleaning minute data
	  });


	  //*************** start time blur 







	  $('#start_time_hr_gig').blur(function(key){

	  	var starttimeval_hr = $('#start_time_hr_gig').val();
		var strttimeformatval = $("#ddlViewBy_gig").val();




		var bookingdatevalue = $("#booking_date_gig").val(); ////****** booking date value

		var strtdateformat = $("#ddlViewBy_gig").val(); // start time format
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
			// 	$('#start_time_hr_gig').val('00');
			// }else if(starttimeval_hr == 12 && strtdateformat == 2)
			// {
			// 	$('#start_time_hr_gig').val(starttimeval_hr);
			// }else if(starttimeval_hr == 00 && strtdateformat == 1)
			// {
			// 	$('#start_time_hr_gig').val(starttimeval_hr);
			// }
			// else if(starttimeval_hr == 00 && strtdateformat == 2)
			// {
			// 	$('#start_time_hr_gig').val(12);
			// }




			if(starttimeval_hr < 10 && starttimeval_hr.length==1)
			{
				starttimeval_hr = addzero(starttimeval_hr);
				$('#start_time_hr_gig').val(starttimeval_hr);

			}else if(starttimeval_hr > 12 && starttimeval_hr.length==2 && starttimeval_hr <24)
			{
				
				starttimeval_hr = addhr_ampm(starttimeval_hr);
				$('#start_time_hr_gig').val(starttimeval_hr);
				// $("#ddlViewBy_gig").val(2);
			//	alert("Hello");
				$("#ddlViewBy_gig").selectpicker('refresh');
				$("#ddlViewBy_gig").selectpicker('val',2);


			}
		}else
		{
						$('#start_time_hr_gig').val('');
						$("#start_time_hr_gig_error").html('You have entered a invalid value');
						$("#start_time_hr_gig_error").css("display", "block");

						setTimeout(function(){
						$("#start_time_hr_gig_error").css("display", "none");
						},2000);
		}



			$("#end_time_hr_gig").val('');
			$("#end_time_mnt_gig").val('');
			$("#ddlViewend_gig").val('');
			$("#start_time_mnt_gig").val(''); // cleaning minute data

			convertzeroval();
			clearrequestexpiredate();

	  });


	   //********* end time minute keyup starts
	   $('#start_time_mnt_gig').keyup(function(key)
	  {
	  	var bookingdtval = $("#booking_date_gig").val();
	  	var start_time_hr_gigval = $("#start_time_hr_gig").val();
	  	if(start_time_hr_gigval == '')
	  	{
	  		$('#start_time_hr_gig').parent().addClass("errorField");
	  		$("#start_time_mnt_gig").val('');

	  		if(bookingdtval == '')
	  		{
	  			$('#booking_date_gig').parent().addClass("errorField");
	  		}

	  	}
	  });
	  //********** end time minute key up ends




	  //*************** start minute blur 

	  $('#start_time_mnt_gig').blur(function(key)
	  {
	  	$('#start_time_mnt_gig').parent().removeClass("errorField");
	  	var starttimeval_mnt = $('#start_time_mnt_gig').val();
		var strttimeformatval = $("#ddlViewBy_gig").val();

		if(starttimeval_mnt!="" && starttimeval_mnt <60 )
		{



			if(starttimeval_mnt < 10 && starttimeval_mnt.length==1)
			{
				starttimeval_mnt =addzero(starttimeval_mnt);
				$('#start_time_mnt_gig').val(starttimeval_mnt);
			}

		}else{
						$('#start_time_mnt_gig').val('');
						$("#start_time_hr_gig_error").html('You have entered a invalid value');
						$("#start_time_hr_gig_error").css("display", "block");

						setTimeout(function(){
						$("#start_time_hr_gig_error").css("display", "none");
						},2000);
		}

					$("#end_time_hr_gig").val('');
					$("#end_time_mnt_gig").val('');
					$("#ddlViewend_gig").val('');
					 clearrequestexpiredate();







	  });

	  //*********end time hr key up starts

	  $('#end_time_hr_gig').keyup(function(key)
	  {
	  	var flagval = checkvalexistsinstrttime();
	  	$("#end_time_mnt_gig").val('');
	  
	  	if(flagval == 1)
{
				  	$('#end_time_hr_gig').parent().removeClass("errorField");
					var res = fourhrcalcularion_start();
					var r = res.split(",");

					var fourhourpreviousmoment = r[0];
					var bookingdatetotadatetime_momentval = r[1];

			         if(bookingdatetotadatetime_momentval < fourhourpreviousmoment)
			         {
			         	
			         	clear_starttime_hr();
			         	clear_starttime_mnt();

			         	$('#start_time_hr_gig').parent().addClass("errorField");
			         	$('#start_time_mnt_gig').parent().addClass("errorField");


			         }else
			         {
			         	$('#start_time_hr_gig').parent().removeClass("errorField");
			         	$('#start_time_mnt_gig').parent().removeClass("errorField");
			         }



			         var bookingdatevalue = $("booking_date_gig").val();
			         if(bookingdatevalue!='')
							{
								$('#requestexpireddate_gig').prop("disabled", false);  
			                    $('#requestexpiredtime').prop("disabled", false);   
							}

					 //***************set request expire date starts here
					 setrequestexpiredate();
					 clearrequestexpiredate();
					 //***************set request expire date ends here


}else
{
	$('#start_time_hr_gig').parent().addClass("errorField");
	$('#start_time_mnt_gig').parent().addClass("errorField");
}



	  });



	  //*********end time hr key up ends

	  //********* end time minute keyup starts
	   $('#end_time_mnt_gig').keyup(function(key)
	  {
	  	$('#end_time_mnt_gig').parent().removeClass("errorField");
	  	var endtimenmtval = $("#end_time_mnt_gig").val();
	  	var endtimehrval = $("#end_time_hr_gig").val();

	  	if(endtimehrval == ''){
	  		$('#end_time_hr_gig').parent().addClass("errorField");
	  		$("#end_time_mnt_gig").val('');
	  	}


	  	if(endtimenmtval > 59)
	  	{
	  		$("#end_time_mnt_gig").val('');
	  	}
	  	



	  });
	  //********** end time minute key up ends


	   //*************** end time blur 

	  $('#end_time_hr_gig').blur(function(key)
	  {

	  	
	  			var end_time_hr_gig = $('#end_time_hr_gig').val();
				if(end_time_hr_gig < 10 && end_time_hr_gig.length==1)
				{
					end_time_hr_gig =addzero(end_time_hr_gig);
					$('#end_time_hr_gig').val(end_time_hr_gig);
				}else if(end_time_hr_gig > 23)
				{
					$('#end_time_hr_gig').parent().addClass("errorField");
					$('#end_time_hr_gig').val('');
				}


				
			

					
	  });




	  //*************** end minute blur 

	  $('#end_time_mnt_gig').blur(function(key)
	  {

	  	//**********end time starts
	  	var end_time_hr_gig = $('#end_time_hr_gig').val();
	  	var end_time_mnt_gig = $('#end_time_mnt_gig').val();
		var ddlViewend_gig = $("#ddlViewend_gig").val();

		//******** start time starts

		var start_time_hr_gig = $('#start_time_hr_gig').val();
	  	var start_time_mnt_gig = $('#start_time_mnt_gig').val();
		var ddlViewBy_gig = $("#ddlViewBy_gig").val();


		

				if(end_time_mnt_gig!="" && end_time_mnt_gig < 60)
				{
					if(end_time_mnt_gig < 10 && end_time_mnt_gig.length==1)
					{
						end_time_mnt_gig =addzero(end_time_mnt_gig);
						$('#end_time_mnt_gig').val(end_time_mnt_gig);
					
					}
					
				}else{
						$('#end_time_mnt_gig').val('');

						// $("#end_time_hr_gig_error").html('You have entered a invalid value');
						// $("#end_time_hr_gig_error").css("display", "block");

						// 	setTimeout(function(){
						// 	$("#end_time_hr_gig_error").css("display", "none");
						// 	},2000);
				}



				if(end_time_hr_gig == 00 && end_time_mnt_gig<30)
				{
					$('#end_time_mnt_gig').parent().addClass("errorField");
					$('#end_time_mnt_gig').val('');
				}



	  });


	  //**** start time option starts here

	  $("#ddlViewBy_gig").change(function(){
	  	
	  	var startdateval = $("#booking_date_gig").val();
	  	var starttimehrval =  $("#start_time_hr_gig").val();
	  	var starttimemnval =  $("#start_time_mnt_gig").val();
	  	var ddlViewBy_gigval = $("#ddlViewBy_gig").val();

	  	var getcurdttime = new Date(); //getting current date in javascript format
		var curentdate = moment(getcurdttime).format("DD/MM/YYYY hh:mm a"); //getting current date in  DD/MM/YYYY hh:mm a format
		var subtractdate =  moment(curentdate,"DD/MM/YYYY h:mm a").add(4,"hours").format("DD/MM/YYYY"); //****date
		var subtracttimehr_24 =  moment(curentdate,"DD/MM/YYYY h:mm a").add(4,"hours").format("HH"); //**** hour
		var subtracttimemn =  moment(curentdate,"DD/MM/YYYY h:mm a").add(4,"hours").format("mm"); //**** minute
		var subtracttimehr_ampm =  moment(curentdate,"DD/MM/YYYY h:mm a").add(4,"hours").format("hh"); //**** hour
		var subtractdatetimeformat = moment(curentdate,"DD/MM/YYYY h:mm a").add(4,"hours").format("a"); //**** hour


		//console.log("subtractdatetimeformat "+subtractdatetimeformat+" ddlViewBy_gigval "+ddlViewBy_gigval);


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
			if(ddlViewBy_gigval == startdateformat)
			{
				
					if( starttimehrval >= subtracttimehr_ampm)
					{
						
					}else
					{	
						//console.log("I am here too");

								$('#start_time_hr_gig').val('');
								$('#start_time_mnt_gig').val('');

								$('#start_time_hr_gig').parent().addClass("errorField");
								$('#start_time_mnt_gig').parent().addClass("errorField");

								// setTimeout(function(){
								// $("#start_time_hr_gig_error").css("display", "none");
								// },2000);

								} 
				
			}else if(startdateformat < ddlViewBy_gigval)
			{

			}else
			{
								$('#start_time_hr_gig').val('');
								$('#start_time_mnt_gig').val('');

								$('#start_time_hr_gig').parent().addClass("errorField");
								$('#start_time_mnt_gig').parent().addClass("errorField");

								// setTimeout(function(){
								// $("#start_time_hr_gig_error").css("display", "none");
								// },2000);

						 
			}
		}



	  	$("#end_time_hr_gig").val('');
	  	$("#end_time_mnt_gig").val('');
	  	//$("#ddlViewend_gig").val('');
	  	clearrequestexpiredate();




	  });


	  //**** ends time option ends here

	  $("#ddlViewend_gig").change(function(){
	  	
	  	var ddlViewend_gig = $("#ddlViewend_gig").val();
	  	var ddlViewBy_gig = $("#ddlViewBy_gig").val();

	  	if(ddlViewBy_gig > ddlViewend_gig)
	  	{
			$("#end_time_hr_gig").val('');
			$("#end_time_mnt_gig").val('');
			$("#ddlViewend_gig").val('');
	  	}



	  });





	  //**************** request expire date and time starts here

	   $("#requestexpireddate_gig").on("dp.change", function(e)
                {
                	$('#requexpire_time_hr_gig').val('');
                	$('#reqexpire_time_mnt_gig').val('');
                	// $('#ddlViewrequestexpire_gig').val('');
                	$("#ddlViewrequestexpire_gig").selectpicker('refresh');
					$("#ddlViewrequestexpire_gig").selectpicker('val',0);
                });


	   //******* request expire time hour key up starts
	    $('#requexpire_time_hr_gig').keyup(function(key)
	    {
	    	$('#requexpire_time_hr_gig').parent().removeClass("errorField");
	    	$('#reqexpire_time_mnt_gig').val('');
	    	var requestexpireddate_gig_val = $("#requestexpireddate_gig").val();
	    	if(requestexpireddate_gig_val == "")
	    	{
	    		$('#requexpire_time_hr_gig').val('');
	    	}

	    	var requestexpireddate_gig_length = $('#requexpire_time_hr_gig').val().length;
		  	if(requestexpireddate_gig_length > 2)
		  	{
		  		$('#requexpire_time_hr_gig').val('');
		  	}

		  	var reqepirehrval = $('#requexpire_time_hr_gig').val();
		  	if(reqepirehrval > 23)
		  	{
		  		$('#requexpire_time_hr_gig').val('');
		  		//$('#requexpire_time_hr_gig').parent().Class("errorField");
		  	}

	    });



	  //******* request expire time hour key up ends


	  //******* request expire time hour blur starts

	  	 $('#requexpire_time_hr_gig').blur(function(key)
	  	 {
	  	 	var reqepirehrval = $('#requexpire_time_hr_gig').val();
		  	if(reqepirehrval > 23)
		  	{
		  		$('#requexpire_time_hr_gig').val('');
		  		$('#requexpire_time_hr_gig').parent().addClass("errorField");
		  	}


		  	if(reqepirehrval < 10 && reqepirehrval.length==1)
			{
				reqepirehrval = addzero(reqepirehrval);
				$('#requexpire_time_hr_gig').val(reqepirehrval);

			}else if(reqepirehrval > 12 && reqepirehrval.length==2 && reqepirehrval <24)
			{
				
				reqepirehrval = addhr_ampm(reqepirehrval);
				$('#requexpire_time_hr_gig').val(reqepirehrval);
				$("#ddlViewrequestexpire_gig").selectpicker('refresh');
				$("#ddlViewrequestexpire_gig").selectpicker('val',1);
			

			}




			convertzerovalreqexpire();




 });


	$('#reqexpire_time_mnt_gig').keyup(function(key){
		//alert("Hello");


			var requestexpireddate_gig_length = $('#reqexpire_time_mnt_gig').val().length;
		  	if(requestexpireddate_gig_length > 2)
		  	{
		  		$('#reqexpire_time_mnt_gig').val('');
		  	}
		  	var reqexpiremntval = $('#reqexpire_time_mnt_gig').val();
		  	if(reqexpiremntval > 59)
		  	{
		  		$('#reqexpire_time_mnt_gig').val('');
		  	}


	});

	  $('#reqexpire_time_mnt_gig').blur(function(key){

// alert("Hello");
	  	var reqexpmnt = $('#reqexpire_time_mnt_gig').val();
	  	var reqexpmntlen = reqexpmnt.length;
	  	if(reqexpmntlen == 1)
	  	{
	  		//alert("length is 1");
				var reqepirehrval = addzero(reqexpmnt);
				$('#reqexpire_time_mnt_gig').val(reqepirehrval);
	  	}

					 

	  	checkcurrenttimeval();
	  	checkfourhourbeforebooking();





	  	 });
	  //******* request expire time hour blur starts



	  $("#ddlViewrequestexpire_gig").change(function(){

	  	checkcurrenttimeval();
	  	checkfourhourbeforebooking();


	 

	  });






	  //****************  request expire date and time ends here


	  function reqestexpiredateconversion(requestdatetime)
	  {
	  		var bookingdateval = $("#booking_date_gig").val();
	    	var bookinghrval = $("#start_time_hr_gig").val();
	    	var bookingmntval = $("#start_time_mnt_gig").val(); 
	    	var bookingformat = $("#ddlViewBy_gig").val(); 
	    	var bookingformatcheck = "";
	    	if(bookingformat == 1)
	    	{
	    		bookingformatcheck = 'am';
	    	}else if(bookingformat == 2)
	    	{
	    		bookingformatcheck = 'pm';
	    	}
	    	
	    		//bookingdateval = "22/10/2016";

	    	bookingdateval = moment(bookingdateval,"DD/MM/YYYY").format('DD/MM/YYYY');
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
	  		var bookingdateval = $("#booking_date_gig").val();
	    	var bookinghrval = $("#start_time_hr_gig").val();
	    	var bookingmntval = $("#start_time_mnt_gig").val(); 
	    	var bookingformat = $("#ddlViewBy_gig").val(); 
	    	var bookingformatcheck = "";
	    	if(bookingformat == 1)
	    	{
	    		bookingformatcheck = 'am';
	    	}else if(bookingformat == 2)
	    	{
	    		bookingformatcheck = 'pm';
	    	}
	    	

	    	bookingdateval = moment(bookingdateval,"DD/MM/YYYY").format('DD/MM/YYYY');
	    	var complete_startdate = bookingdateval+' '+bookinghrval+':'+bookingmntval+':00 '+bookingformatcheck;
	    
			//var date1 = new Date(complete_startdate);
			var date1 = new Date();

			date1 = moment(date1).format("DD/MM/YYYY hh:mm:ss a");
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
	  	  var booking_date_gigval = $("#booking_date_gig").val();
		  var start_time_hr_gigval = $("#start_time_hr_gig").val();
		  var start_time_mnt_gigval = $("#start_time_mnt_gig").val();
		  var starttimeformatval = $("#ddlViewBy_gig").val();
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

          var fourhourpreviousmoment = moment(curplusfour,'DD/MM/YYYY hh:mm A');
        // alert(" curplusfour "+curplusfour+" fourhourpreviousmoment "+fourhourpreviousmoment+" getcurdttimemom "+getcurdttimemom);

         var bookingdatetotadatetime = booking_date_gigval+' '+start_time_hr_gigval+':'+start_time_mnt_gigval+starttimeformatval_text;
         var bookingdatetotadatetime_momentval = moment(bookingdatetotadatetime,'DD/MM/YYYY hh:mm A');

         var aaaa = fourhourpreviousmoment+','+bookingdatetotadatetime_momentval;

         return aaaa;
	  }


	  //*************** set request expire date starts here

		function setrequestexpiredate()
	  {
	  	var booking_date_gigval = $("#booking_date_gig").val();
	  	var start_time_hr_gig = $("#start_time_hr_gig").val();
	  	var start_time_mnt_gig = $("#start_time_mnt_gig").val();
	  	var ddlViewBy_gig = $("#ddlViewBy_gig").val();
	  	var timeformat;
	  	 if(ddlViewBy_gig == 1)
	  	{
	  		 timeformat = 'am';
	  	}else
	  	{
	  		timeformat = 'pm';
	  	}

	  	// console.log(" booking_date_gigval "+booking_date_gigval+" start_time_hr_gig "+start_time_hr_gig+" start_time_mnt_gig "+start_time_mnt_gig+" timeformat"+timeformat);
	  	var totaltime =  booking_date_gigval+" "+start_time_hr_gig+":"+start_time_mnt_gig+" "+timeformat;
	  	fourhr = moment(totaltime,"DD/MM/YYYY hh:mm A").subtract(4,"hours").format("DD/MM/YYYY");
	  	//console.log(" totaltime "+totaltime+" fourhr "+fourhr);
	  	$("#requestexpireddate_gig").data("DateTimePicker").maxDate(fourhr);




	  }


	  //********** check current time validation starts here


	  function checkcurrenttimeval()
	  {
	  	var getcurdttime = new Date();
        var getcurdttimemom = moment(getcurdttime).format("DD/MM/YYYY hh:mm A");
        var momentofcurrenttime = moment(getcurdttimemom,"DD/MM/YYYY hh:mm A");
        var reqexpiretimemom = getrequestexpiredatetimemoment();

        //console.log(" momentofcurrenttime "+momentofcurrenttime+" reqexpiretimemom"+reqexpiretimemom);

        if(reqexpiretimemom < momentofcurrenttime)
        {
        	clearrequestexpiretimehrmnt();
        	$('#requexpire_time_hr_gig').parent().addClass("errorField");
        	$('#requexpire_time_mnt').parent().addClass("errorField");
        }

	  }
	  function getrequestexpiredatetimemoment()
	  {
	  	var requestexpiredate = $("#requestexpireddate_gig").val();
	  	var requexpire_time_hr_gig = $("#requexpire_time_hr_gig").val();
	  	var reqexpire_time_mnt_gig = $("#reqexpire_time_mnt_gig").val();
	  	var reqexpire_time_format = $("#ddlViewrequestexpire_gig").val();
	  	var reqexpire_time_formatval;
	  	if(reqexpire_time_format == '0'){
	  		reqexpire_time_formatval  ='am';
	  	}else
	  	{
	  		reqexpire_time_formatval  ='pm';
	  	}

	  	var totaltimeformat = requestexpiredate+' '+requexpire_time_hr_gig+":"+reqexpire_time_mnt_gig+" "+reqexpire_time_formatval;
	  	// var totaltimeformat_val = moment(totaltimeformat).format("DD/MM/YYYY hh:mm A");
	  	var totaltimeformat_moment =moment(totaltimeformat,"DD/MM/YYYY hh:mm A");

	  	
	  	//console.log(" totaltimeformat "+totaltimeformat+" totaltimeformat_moment "+totaltimeformat_moment);
	  	return totaltimeformat_moment;
	  }

	  //**********  check current time validation ends here


	  function checkfourhourbeforebooking()
	  {
	  	var reqexxpdttimmoment = getrequestexpiredatetimemoment();
	  	var getcheckfourhourbeforebookingtime = checkfourhourbeforebookingtime();
	  	// console.log(" reqexxpdttimmoment ==  checkfourhourbeforebooking "+reqexxpdttimmoment);
	  	// console.log(" getcheckfourhourbeforebookingtime "+getcheckfourhourbeforebookingtime);

	  	if(reqexxpdttimmoment > getcheckfourhourbeforebookingtime)
	  	{
	  		clearrequestexpiretimehrmnt();
	  		$('#requexpire_time_hr_gig').parent().addClass("errorField");
	  	}

	  }
	  function checkfourhourbeforebookingtime()
	  {
	  	var booking_date_gigval = $("#booking_date_gig").val();
	  	var start_time_hr_gig = $("#start_time_hr_gig").val();
	  	var start_time_mnt_gig = $("#start_time_mnt_gig").val();
	  	var ddlViewBy_gig = $("#ddlViewBy_gig").val();
	  	var timeformat;
	  	 if(ddlViewBy_gig == 1)
	  	{
	  		 timeformat = 'am';
	  	}else
	  	{
	  		timeformat = 'pm';
	  	}

	  	// console.log(" booking_date_gigval "+booking_date_gigval+" start_time_hr_gig "+start_time_hr_gig+" start_time_mnt_gig "+start_time_mnt_gig+" timeformat"+timeformat);
	  	var totaltime =  booking_date_gigval+" "+start_time_hr_gig+":"+start_time_mnt_gig+" "+timeformat;
	  	fourhr = moment(totaltime,"DD/MM/YYYY hh:mm A").subtract(4,"hours").format("DD/MM/YYYY hh:mm A");

	  	var fourhrmoment = moment(fourhr,"DD/MM/YYYY hh:mm A");
	   	return fourhrmoment;
	  }





	  function convertzeroval()
	  {
	  	var starttimeval = $("#start_time_hr_gig").val();
	  	var starttimeformat = $("#ddlViewBy_gig").val();
	  	if(starttimeval == '00' && starttimeformat == '2')
	  	{
	  		$("#start_time_hr_gig").val('12');
	  	}
	  	
	  }
	   function convertzerovalreqexpire()
	  {
	  	
	  	var reqexpval = $("#requexpire_time_hr_gig").val();
	  	var ddlViewrequestexpire_gig = $("#ddlViewrequestexpire_gig").val();
	  	if(reqexpval == '00' && ddlViewrequestexpire_gig == '1')
	  	{
	  		$("#requexpire_time_hr_gig").val('12');
	  	}
	  	
	  }



	  function clear_starttime_hr()
	  {
	  	$("#start_time_hr_gig").val('');
	  }
	   function clear_starttime_mnt()
	  {
	  	$("#start_time_mnt_gig").val('');
	  }

	   function clearrequestexpiredate()
	  {
	  	$("#requestexpireddate_gig").val('');
	  	// $("#requestexpireddate_gig").data('');
	  	$("#requestexpireddate_gig").data("DateTimePicker").date(null);
	  }

	  function clearrequestexpiretimehrmnt()
	  {
	  	$("#requexpire_time_hr_gig").val('');
	  	$("#reqexpire_time_mnt_gig").val('');
	  	
	  }
	  function checkvalexistsinstrttime()
	  {
	  	var endtimeval = $("#start_time_mnt_gig").val();
	  	if(endtimeval == '')
	  	{
	  		$("#end_time_hr_gig").val('');
	  		return 0;
	  	}else
	  	{
	  		return 1;
	  	}
	  }
	 


