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
		// console.log("firstval "+firstval);
		return addzero(firstval);
	}else{
		// console.log("firstval2 "+firstval);
	return firstval;
	}
}

//****************  For added zero 


//************ for booking date set by default starts here


	 var momentdate = moment().format("DD/MM/YYYY h:mm a");
	 var mindatereqexpire = moment().format("DD/MM/YYYY");
	 var datecur_adddate =  moment(momentdate,"DD/MM/YYYY h:mm a").add(4,"hours").format("DD/MM/YYYY"); 
	 var datecur_adddatetime =  moment(momentdate,"DD/MM/YYYY h:mm a").add(4,"hours").format("DD/MM/YYYY h:mm a");

	 //******** calling of opening time starts here
	 var openingtime = opening_time;
	 var closingtime =  closing_time;
	
	

	 //******* calling of opening time ends here

	 $('#booking_date').data("DateTimePicker").minDate(datecur_adddate);
	 $('#booking_date').data("DateTimePicker").date(null); // This is added for blank date field
	 $('#requestexpireddate').data("DateTimePicker").minDate(mindatereqexpire);	

	  openingandclosingtime(openingtime,closingtime,datecur_adddatetime);


	// alert('openingtime -- '+opening_time);
//************ for booking date set by default ends here
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
						$("#ddlViewBy").selectpicker('val',1); //******* extra added on 29-12-2016
                });


	  $('#start_time_hr').keyup(function(key){


	  	$('#start_time_hr').parent().removeClass("errorField");
	  	$('#booking_date').parent().removeClass("errorField");
        

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
						$('#booking_date').parent().addClass("errorField");
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

			convertzeroval();
			clearrequestexpiredate();

	  });


	   //********* end time minute keyup starts
	   $('#start_time_mnt').keyup(function(key)
	  {
	  	var bookingdtval = $("#booking_date").val();
	  	var start_time_hrval = $("#start_time_hr").val();
	  	if(start_time_hrval == '')
	  	{
	  		$('#start_time_hr').parent().addClass("errorField");
	  		$("#start_time_mnt").val('');

	  		if(bookingdtval == '')
	  		{
	  			$('#booking_date').parent().addClass("errorField");
	  		}

	  	}
	  });
	  //********** end time minute key up ends




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
	  	
	  	$("#end_time_mnt").val('');
	  	var flagval = checkvalexistsinstrttime();
	  
	  	if(flagval == 1)
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
			         	//alert("I am after before hour");
			         	$('#start_time_hr').parent().addClass("errorField");
			         	$('#start_time_mnt').parent().addClass("errorField");


			         }else
			         {
			         	//alert("I am after four hour");
			         	flagstrttime = starttimecheck(opening_time,closing_time);
				         	
				         	if(flagstrttime == 0)
				         	{
					         	$('#start_time_hr').parent().removeClass("errorField");
					         	$('#start_time_mnt').parent().removeClass("errorField");
				         	}else
				         	{
					         	$('#start_time_hr').parent().addClass("errorField");
					         	$('#start_time_mnt').parent().addClass("errorField");
				         	}
				         	
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


}else
{
	$('#start_time_hr').parent().addClass("errorField");
	$('#start_time_mnt').parent().addClass("errorField");
}



	  });



	  //*********end time hr key up ends

	  //********* end time minute keyup starts
	   $('#end_time_mnt').keyup(function(key)
	  {
	  	$('#end_time_mnt').parent().removeClass("errorField");
	  	var endtimenmtval = $("#end_time_mnt").val();
	  	var endtimehrval = $("#end_time_hr").val();

	  	if(endtimehrval == ''){
	  		$('#end_time_hr').parent().addClass("errorField");
	  		$("#end_time_mnt").val('');
	  	}


	  	if(endtimenmtval > 59)
	  	{
	  		$("#end_time_mnt").val('');
	  	}
	  	



	  });
	  //********** end time minute key up ends


	   //*************** end time blur 

	  $('#end_time_hr').blur(function(key)
	  {

	  	
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

						
				}



				if(end_time_hr == 00 && end_time_mnt<30)
				{
					$('#end_time_mnt').parent().addClass("errorField");
					$('#end_time_mnt').val('');
				}

				checkendtimevalue(opening_time,closing_time);

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
						//starttimecheck();
						//alert("first");
					}else
					{	
						//console.log("I am here too");
						//alert("second");
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
				//alert("third");
			}else
			{	
				//alert("fourth");
								//starttimecheck();
								$('#start_time_hr').val('');
								$('#start_time_mnt').val('');

								$('#start_time_hr').parent().addClass("errorField");
								$('#start_time_mnt').parent().addClass("errorField");

								// setTimeout(function(){
								// $("#start_time_hr_error").css("display", "none");
								// },2000);

						 
			}
		}


		var checkstrttime = starttimecheck(opening_time,closing_time);

		if(checkstrttime == 1)
		{
			$('#start_time_hr').parent().addClass("errorField");
			$('#start_time_mnt').parent().addClass("errorField");
		}

	  	$("#end_time_hr").val('');
	  	$("#end_time_mnt").val('');
	  	//$("#ddlViewend").val('');
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
                	//$('#ddlViewrequestexpire').val('');
                	$("#ddlViewrequestexpire").selectpicker('val',0);
                });


	   //******* request expire time hour key up starts
	    $('#requexpire_time_hr').keyup(function(key)
	    {
	    	$('#requexpire_time_hr').parent().removeClass("errorField");
	    	$('#reqexpire_time_mnt').val('');
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

	  	 $('#requexpire_time_hr').blur(function(key)
	  	 {
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




			convertzerovalreqexpire();




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


	  	var reqexpmnt = $('#reqexpire_time_mnt').val();
	  	var reqexpmntlen = reqexpmnt.length;
	  	if(reqexpmntlen == 1)
	  	{
	  		//alert("length is 1");
				var reqepirehrval = addzero(reqexpmnt);
				$('#reqexpire_time_mnt').val(reqepirehrval);
	  	}

					 

	  	checkcurrenttimeval();
	  	checkfourhourbeforebooking();





	  	 });
	  //******* request expire time hour blur starts



	  $("#ddlViewrequestexpire").change(function(){

	  	checkcurrenttimeval();
	  	checkfourhourbeforebooking();


	 

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

	    	bookingdateval = moment(bookingdateval,"DD/MM/YYYY").format('DD/MM/YYYY');
	    	var complete_startdate = bookingdateval+' '+bookinghrval+':'+bookingmntval+':00 '+bookingformatcheck;
	    
			var date1 = new Date(complete_startdate);
			//var date1 = new Date();
			var date2 = new Date(requestdatetime);
			var timeDiff = Math.abs(date1.getTime() - date2.getTime());

			// console.log("complete_startdate "+complete_startdate+" requestdatetime"+requestdatetime);

			var fourhourtime = (timeDiff-(1000 * 3600 * 4));
			//var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 4)); 
			// console.log("timeDiff "+timeDiff+" fourhourtime"+fourhourtime);
			
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

          var fourhourpreviousmoment = moment(curplusfour,'DD/MM/YYYY hh:mm A');
        // alert(" curplusfour "+curplusfour+" fourhourpreviousmoment "+fourhourpreviousmoment+" getcurdttimemom "+getcurdttimemom);

         var bookingdatetotadatetime = booking_dateval+' '+start_time_hrval+':'+start_time_mntval+starttimeformatval_text;
         var bookingdatetotadatetime_momentval = moment(bookingdatetotadatetime,'DD/MM/YYYY hh:mm A');

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
        	$('#requexpire_time_hr').parent().addClass("errorField");
        	$('#requexpire_time_mnt').parent().addClass("errorField");
        }

	  }
	  function getrequestexpiredatetimemoment()
	  {
	  	var requestexpiredate = $("#requestexpireddate").val();
	  	var requexpire_time_hr = $("#requexpire_time_hr").val();
	  	var reqexpire_time_mnt = $("#reqexpire_time_mnt").val();
	  	var reqexpire_time_format = $("#ddlViewrequestexpire").val();
	  	var reqexpire_time_formatval;
	  	if(reqexpire_time_format == '0'){
	  		reqexpire_time_formatval  ='am';
	  	}else
	  	{
	  		reqexpire_time_formatval  ='pm';
	  	}

	  	var totaltimeformat = requestexpiredate+' '+requexpire_time_hr+":"+reqexpire_time_mnt+" "+reqexpire_time_formatval;
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
	  		$('#requexpire_time_hr').parent().addClass("errorField");
	  	}

	  }
	  function checkfourhourbeforebookingtime()
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
	  	fourhr = moment(totaltime,"DD/MM/YYYY hh:mm A").subtract(4,"hours").format("DD/MM/YYYY hh:mm A");

	  	var fourhrmoment = moment(fourhr,"DD/MM/YYYY hh:mm A");
	   	return fourhrmoment;
	  }





	  function convertzeroval()
	  {
	  	var starttimeval = $("#start_time_hr").val();
	  	var starttimeformat = $("#ddlViewBy").val();
	  	if(starttimeval == '00' && starttimeformat == '2')
	  	{
	  		$("#start_time_hr").val('12');
	  	}
	  	
	  }
	   function convertzerovalreqexpire()
	  {
	  	
	  	var reqexpval = $("#requexpire_time_hr").val();
	  	var ddlViewrequestexpire = $("#ddlViewrequestexpire").val();
	  	if(reqexpval == '00' && ddlViewrequestexpire == '1')
	  	{
	  		$("#requexpire_time_hr").val('12');
	  	}
	  	
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

	  function clearrequestexpiretimehrmnt()
	  {
	  	$("#requexpire_time_hr").val('');
	  	$("#reqexpire_time_mnt").val('');
	  	
	  }
	  function checkvalexistsinstrttime()
	  {
	  	var endtimeval = $("#start_time_mnt").val();
	  	if(endtimeval == '')
	  	{
	  		$("#end_time_hr").val('');
	  		return 0;
	  	}else
	  	{
	  		return 1;
	  	}
	  }
	 




//************ check opening time and closing time functionlity starts here

function openingandclosingtime(opentime,closingtime,datecur_adddatetime)
{
	var momentdopening = moment(opentime,"h:mm a").format("DD/MM/YYYY h:mm a");
	var momentopeningdateformat = moment(momentdopening,"DD/MM/YYYY h:mm a");

	//var closingtime = moment(closingtime,"h:mm a").format("DD/MM/YYYY h:mm a");
	//var momentclosingdateformat = moment(closingtime,"DD/MM/YYYY h:mm a");

	var closingtimehr = moment(closingtime,"h:mm").format("HH");
	var closingtimemnt = moment(closingtime,"hh:mm").format("mm");

	
	var closingtimeaddhr = moment(momentdopening,"DD/MM/YYYY h:mm a").add(closingtimehr,"hours").format("DD/MM/YYYY hh:mm A");
	var closingtimeaddmnt = moment(closingtimeaddhr,"DD/MM/YYYY h:mm a").add(closingtimemnt,"minutes").format("DD/MM/YYYY hh:mm A");
	
	//******** match dates 
	var closingtimedate = moment(closingtimeaddmnt,"DD/MM/YYYY h:mm a").format("DD/MM/YYYY");
	var closingtimemoment = moment(closingtimeaddmnt,"DD/MM/YYYY h:mm a");
	var bookingdateval = moment(datecur_adddatetime,"DD/MM/YYYY h:mm a").format("DD/MM/YYYY h:mm a");
	var bookingdatevalmoment = moment(bookingdateval,"DD/MM/YYYY h:mm a");
	//alert("bookingdateval "+bookingdateval);
	//alert("closingdatetimeval "+closingtimeaddmnt);

	var currdate = moment().format("DD/MM/YYYY");
	var closingtimedateadd = moment(closingtimeaddmnt,"DD/MM/YYYY h:mm a").add('24',"hours").format("DD/MM/YYYY");
	//alert(" currdate is "+currdate);

	if(currdate != closingtimedate)
	{
		//$("#booking_date").data("DateTimePicker").minDate(closingtimedate);

	
	}else if(closingtimemoment < bookingdatevalmoment)
	{
		$("#booking_date").data("DateTimePicker").minDate(closingtimedateadd);
		$('#booking_date').data("DateTimePicker").date(null); // This is added for blank date field
	}

}
function starttimecheck(opentime,closingtime)
{
	var bookingdateval = $("#booking_date").val();
	var bookingstarttime = bookingdateval+" "+opentime;
	var momentdopening = moment(bookingstarttime,"DD/MM/YYYY h:mm a").format("DD/MM/YYYY h:mm a");
	var momentopeningdateformat = moment(momentdopening,"DD/MM/YYYY h:mm a");

	//var closingtime = moment(closingtime,"h:mm a").format("DD/MM/YYYY h:mm a");
	//var momentclosingdateformat = moment(closingtime,"DD/MM/YYYY h:mm a");


	var starttimehrval = $("#start_time_hr").val();
	var starttimemntval = $("#start_time_mnt").val();
	var starttimeformat = $("#ddlViewBy").val();
	var starttimeformatval;
	if(starttimeformat == 1)
	{
		starttimeformatval = 'am';
	}else
	{
		starttimeformatval = 'pm';
	}
	var completebookingstarttime = bookingdateval+' '+starttimehrval+":"+starttimemntval+" "+starttimeformatval;
	var completebookingstarttimeval = moment(completebookingstarttime,"DD/MM/YYYY hh:mm a").format("DD/MM/YYYY hh:mm a");
	var completebookingstarttimemoment = moment(completebookingstarttimeval,"DD/MM/YYYY hh:mm a");
	





	var closingtimehr = moment(closingtime,"h:mm").format("HH");
	var closingtimemnt = moment(closingtime,"hh:mm").format("mm");

	
	var closingtimeaddhr = moment(momentdopening,"DD/MM/YYYY h:mm a").add(closingtimehr,"hours").format("DD/MM/YYYY hh:mm A");
	var closingtimeaddmnt = moment(closingtimeaddhr,"DD/MM/YYYY h:mm a").add(closingtimemnt,"minutes").format("DD/MM/YYYY hh:mm A");
	
	//******** match dates 
	var closingtimedate = moment(closingtimeaddmnt,"DD/MM/YYYY h:mm a").format("DD/MM/YYYY");
	var closingdatetime = moment(closingtimeaddmnt,"DD/MM/YYYY h:mm a").format("DD/MM/YYYY hh:mm a");
	
	
	//var currdate = moment().format("DD/MM/YYYY");
	//alert(" currdate is "+currdate);
	var venuebookingdatetimemoment = moment(completebookingstarttimeval,"DD/MM/YYYY hh:mm a");
	var databasebookingdatetimemoment = moment(closingdatetime,"DD/MM/YYYY hh:mm a");
	//alert(" venuebookingdatetimemoment form"+venuebookingdatetimemoment+"======== "+completebookingstarttimeval+ "databasebookingdatetimemoment database"+databasebookingdatetimemoment);
	//alert(" momentdopening "+momentdopening);
	//alert(" completebookingstarttimeval "+completebookingstarttimeval+" closingdatetime "+closingdatetime+" momentdopening"+momentdopening);
	var momentdopeningval = moment(momentdopening,"DD/MM/YYYY hh:mm a");
	if(bookingdateval != closingtimedate)
	{
		//$("#booking_date").data("DateTimePicker").minDate(closingtimedate);
		//alert(" another date");
		if(venuebookingdatetimemoment < momentdopeningval)
		{
			// alert(" completebookingstarttimeval "+completebookingstarttimeval+" closingdatetime "+closingdatetime+" momentdopening"+momentdopening);
			// alert("i am previus");
			clear_starttime_hr();
			clear_starttime_mnt();

			return 1;
		}else{
			return 0;
		}

	
	}else
	{
		//alert("same date"+closingtimeaddmnt);
		if(venuebookingdatetimemoment > databasebookingdatetimemoment)
		{
			// alert(" completebookingstarttimeval "+completebookingstarttimeval+" closingdatetime "+closingdatetime+" momentdopening"+momentdopening);
			//  alert("I  am crossing");
			clear_starttime_hr();
			clear_starttime_mnt();

			return 1;
		
		}else if(venuebookingdatetimemoment < momentdopeningval)
		{
			// alert(" completebookingstarttimeval "+completebookingstarttimeval+" closingdatetime "+closingdatetime+" momentdopening"+momentdopening);
			// alert("i am previus 2");
			clear_starttime_hr();
			clear_starttime_mnt();

			return 1;
		}
		else
		{
			return 0;
		}
		
	}

}

//************ check opening time and closing time fuinctionlity ends here

function checkendtimevalue(opentime,closingtime)
{
	//alert("hello");
	var endtimehrval = $("#end_time_hr").val();
	var endtimemntval = $("#end_time_mnt").val();
	var bookingdateval = $("#booking_date").val();
	var bookingstarttime = bookingdateval+" "+opentime;
	var momentdopening = moment(bookingstarttime,"DD/MM/YYYY h:mm a").format("DD/MM/YYYY h:mm a");
	var momentopeningdateformat = moment(momentdopening,"DD/MM/YYYY h:mm a");

	//var closingtime = moment(closingtime,"h:mm a").format("DD/MM/YYYY h:mm a");
	//var momentclosingdateformat = moment(closingtime,"DD/MM/YYYY h:mm a");


	var starttimehrval = $("#start_time_hr").val();
	var starttimemntval = $("#start_time_mnt").val();
	var starttimeformat = $("#ddlViewBy").val();
	var starttimeformatval;
	if(starttimeformat == 1)
	{
		starttimeformatval = 'am';
	}else
	{
		starttimeformatval = 'pm';
	}
	var completebookingstarttime = bookingdateval+' '+starttimehrval+":"+starttimemntval+" "+starttimeformatval;
	var completebookingstarttimeval = moment(completebookingstarttime,"DD/MM/YYYY hh:mm a").format("DD/MM/YYYY hh:mm a");
	var completebookingstarttimemoment = moment(completebookingstarttimeval,"DD/MM/YYYY hh:mm a");
	
	var addendhr = moment(completebookingstarttimeval,"DD/MM/YYYY hh:mm a").add(endtimehrval,"hours").format("DD/MM/YYYY hh:mm a");
	var addendmnt = moment(addendhr,"DD/MM/YYYY hh:mm a").add(endtimemntval,"minutes").format("DD/MM/YYYY hh:mm a");

	


	var closingtimehr = moment(closingtime,"h:mm").format("HH");
	var closingtimemnt = moment(closingtime,"hh:mm").format("mm");

	
	var closingtimeaddhr = moment(momentdopening,"DD/MM/YYYY h:mm a").add(closingtimehr,"hours").format("DD/MM/YYYY hh:mm A");
	var closingtimeaddmnt = moment(closingtimeaddhr,"DD/MM/YYYY h:mm a").add(closingtimemnt,"minutes").format("DD/MM/YYYY hh:mm A");
	
	var closingtimemomentval = moment(closingtimeaddmnt,"DD/MM/YYYY hh:mm a");

	var addendmntmomentval = moment(addendmnt,"DD/MM/YYYY h:mm a");
	if(addendmntmomentval > closingtimemomentval)
	{
		$("#end_time_hr").val('');
		$("#end_time_mnt").val('');
		$('#end_time_hr').parent().addClass("errorField");
		$('#end_time_mnt').parent().addClass("errorField");
	}

}


 //***************************** booking request expire time day hour minute starts here 29-12-2016 *********************************************

	 $('#requexpire_day').keypress(function(key){

	if(key.charCode < 48 )
	{
		return false;
		
	}else
	{
		if(key.charCode > 57)
		return false;
	}
});
$('#reqexpire_hour').keypress(function(key){

	if(key.charCode < 48 )
	{
		return false;
		
	}else
	{
		if(key.charCode > 57)
		return false;
	}
});
$('#reqexpire_minute').keypress(function(key){

	if(key.charCode < 48 )
	{
		return false;
		
	}else
	{
		if(key.charCode > 57)
		return false;
	}
});




	  $("#requexpire_day").keyup(function(){
	  	$("#reqexpire_hour").val('');
	  	$("#reqexpire_minute").val('');
	  	
	  	$('#requexpire_day').parent().removeClass("errorField");
	  	// $('#reqexpire_minute').parent().removeClass("errorField");

	  });
	  $("#reqexpire_hour").keyup(function(){
	  	$("#reqexpire_minute").val('');
	  	$('#reqexpire_hour').parent().removeClass("errorField");
	  });

	  $("#reqexpire_minute").keyup(function(){
	  
	  	$('#reqexpire_minute').parent().removeClass("errorField");
	  });




      
	  //*************  For day *******************************


      $("#requexpire_day").blur(function(){

      	// alert("Hello here");

      	var reqexpday = $("#requexpire_day").val();

      	//****************** length checking starts here

      	if(reqexpday < 10 && reqexpday.length==1)
			{
				reqexpday_val = addzero(reqexpday);
				$('#requexpire_day').val(reqexpday_val);

			}


      	//****************** length checking ends here


      	var eventdate = $("#booking_date").val();
       	var eventstarthr = $("#start_time_hr").val();
      	var eventstartmnt = $("#start_time_mnt").val();
		var eventstartmntfrmt = $("#ddlViewBy").val();

		var eventstartmntfrmtval ='';

		if(eventstartmntfrmt == 1)
		{
			eventstartmntfrmtval= 'am';
		}else if(eventstartmntfrmt == 2)
		{
			eventstartmntfrmtval= 'pm';
		}

		// console.log(" eventdate "+eventdate+" eventstarthr "+eventstarthr+" eventstartmnt "+eventstartmnt+ "eventstartmntfrmt"+eventstartmntfrmt);
      	var totalevntdatetime = eventdate+' '+eventstarthr+':'+eventstartmnt+' '+eventstartmntfrmtval;
		// console.log(" totalevntdatetime "+totalevntdatetime);
		// var totaltimeformat_moment =moment(totalevntdatetime,"DD/MM/YYYY hh:mm A").format("DD/MM/YYYY hh:mm A");
		var totaltimeformat_moment = moment(totalevntdatetime,"DD/MM/YYYY hh:mm A");
		// console.log(" totaltimeformat_moment "+totaltimeformat_moment);


		
		var reqexpday_hrs = parseInt(reqexpday*24);
		// console.log("reqexpday_hrs "+reqexpday_hrs);

		var getcurdttime = new Date();
        var getcurdttimemom = moment(getcurdttime).format("DD/MM/YYYY hh:mm A");
        var momentofcurrenttime = moment(getcurdttimemom,"DD/MM/YYYY hh:mm A");

        // console.log(getcurdttimemom+" momentofcurrenttime "+momentofcurrenttime);

        //*********** adding days with current date
		var reqformat_momentdy = moment(getcurdttimemom,"DD/MM/YYYY hh:mm A").add(reqexpday_hrs,"hours").format("DD/MM/YYYY hh:mm A");
		
		//*********** getting moment of requesy expire date
		var reqformat_momentvl = moment(reqformat_momentdy,"DD/MM/YYYY hh:mm A");
		// console.log("reqformat_momentdy "+reqformat_momentdy+" reqformat_momentvl "+reqformat_momentvl);

		//********** checking if days go heigher strats 

		if( reqformat_momentvl > totaltimeformat_moment)
		{
			// console.log(" I am getting higher");
			$('#requexpire_day').parent().addClass("errorField");
			$('#requexpire_day').val('');
		}else{
			$('#requexpire_day').parent().removeClass("errorField");
			
		}
		//********** checking if days go heigher ends 

      });

       //*************  For hour *****************************************


       $("#reqexpire_hour").blur(function(){

      	// alert("Hello here");

      	var reqexpday = $("#requexpire_day").val();
      	var reqexphr = $("#reqexpire_hour").val();

      	//***************  greter than checking of 24 hrs starts here

      	if(reqexphr > 23)
      	{
      		$("#reqexpire_hour").val('');
      	}

      	//***************  greater than checking of 24 hrs ends here

      	//****************** length checking starts here

      	if(reqexphr < 10 && reqexphr.length==1)
			{
				reqexphr_val = addzero(reqexphr);
				$('#reqexpire_hour').val(reqexphr_val);

			}


      	//****************** length checking ends here


      	var eventdate = $("#booking_date").val();
       	var eventstarthr = $("#start_time_hr").val();
      	var eventstartmnt = $("#start_time_mnt").val();
		var eventstartmntfrmt = $("#ddlViewBy").val();

		var eventstartmntfrmtval ='';

		if(eventstartmntfrmt == 1)
		{
			eventstartmntfrmtval= 'am';
		}else if(eventstartmntfrmt == 2)
		{
			eventstartmntfrmtval= 'pm';
		}

		// console.log(" eventdate "+eventdate+" eventstarthr "+eventstarthr+" eventstartmnt "+eventstartmnt+ "eventstartmntfrmt"+eventstartmntfrmt);
      	var totalevntdatetime = eventdate+' '+eventstarthr+':'+eventstartmnt+' '+eventstartmntfrmtval;
		// console.log(" totalevntdatetime "+totalevntdatetime);
		// var totaltimeformat_moment =moment(totalevntdatetime,"DD/MM/YYYY hh:mm A").format("DD/MM/YYYY hh:mm A");
		var totaltimeformat_moment = moment(totalevntdatetime,"DD/MM/YYYY hh:mm A");
		// console.log(" totaltimeformat_moment "+totaltimeformat_moment);


		
		var reqexpday_hrs = parseInt(reqexpday*24);
		// console.log("reqexpday_hrs "+reqexpday_hrs);

		var getcurdttime = new Date();
        var getcurdttimemom = moment(getcurdttime).format("DD/MM/YYYY hh:mm A");
        var momentofcurrenttime = moment(getcurdttimemom,"DD/MM/YYYY hh:mm A");

        // console.log(getcurdttimemom+" momentofcurrenttime "+momentofcurrenttime);

        //*********** adding days with current date
		var reqformat_momentdy = moment(getcurdttimemom,"DD/MM/YYYY hh:mm A").add(reqexpday_hrs,"hours").format("DD/MM/YYYY hh:mm A");

		var reqformat_momentdyhr = moment(reqformat_momentdy,"DD/MM/YYYY hh:mm A").add(reqexphr,"hours").format("DD/MM/YYYY hh:mm A");
		
		//*********** getting moment of requesy expire date
		var reqformat_momentvl = moment(reqformat_momentdyhr,"DD/MM/YYYY hh:mm A");
		//console.log("reqformat_momentdyhr "+reqformat_momentdyhr+" reqformat_momentvl "+reqformat_momentvl);

		//********** checking if days go heigher strats 

		if( reqformat_momentvl > totaltimeformat_moment)
		{
			// console.log(" I am getting higher");
			$('#reqexpire_hour').parent().addClass("errorField");
			$('#reqexpire_hour').val('');
		}else{
			$('#reqexpire_hour').parent().removeClass("errorField");
			
		}
		//********** checking if days go heigher ends 

      });



       //***********  For minutes 

       $("#reqexpire_minute").blur(function(){



      	// alert("Hello here");

      	var reqexpday = $("#requexpire_day").val();
      	var reqexphr = $("#reqexpire_hour").val();

      	var reqexpm  =$("#reqexpire_minute").val();

      	//console.log(" reqexpm "+reqexpm);

      	//***************  greter than checking of 24 hrs starts here

      	if(reqexpm > 59)
      	{
      		$("#reqexpire_minute").val('');
      	}

      	//***************  greater than checking of 24 hrs ends here

      	//****************** length checking starts here

      		if(reqexpm < 10 && reqexpm.length==1)
			{
				reqexpm_val = addzero(reqexpm);
				$('#reqexpire_minute').val(reqexpm_val);

			}


      	//****************** length checking ends here


      	var eventdate = $("#booking_date").val();
       	var eventstarthr = $("#start_time_hr").val();
      	var eventstartmnt = $("#start_time_mnt").val();
		var eventstartmntfrmt = $("#ddlViewBy").val();

		var eventstartmntfrmtval ='';

		if(eventstartmntfrmt == 1)
		{
			eventstartmntfrmtval= 'am';
		}else if(eventstartmntfrmt == 2)
		{
			eventstartmntfrmtval= 'pm';
		}

		// console.log(" eventdate "+eventdate+" eventstarthr "+eventstarthr+" eventstartmnt "+eventstartmnt+ "eventstartmntfrmt"+eventstartmntfrmt);
      	var totalevntdatetime = eventdate+' '+eventstarthr+':'+eventstartmnt+' '+eventstartmntfrmtval;
		// console.log(" totalevntdatetime "+totalevntdatetime);
		// var totaltimeformat_moment =moment(totalevntdatetime,"DD/MM/YYYY hh:mm A").format("DD/MM/YYYY hh:mm A");
		var totaltimeformat_moment = moment(totalevntdatetime,"DD/MM/YYYY hh:mm A");
		// console.log(" totaltimeformat_moment "+totaltimeformat_moment);


		
		var reqexpday_hrs = parseInt(reqexpday*24);
		// console.log("reqexpday_hrs "+reqexpday_hrs);

		var getcurdttime = new Date();
        var getcurdttimemom = moment(getcurdttime).format("DD/MM/YYYY hh:mm A");
        var momentofcurrenttime = moment(getcurdttimemom,"DD/MM/YYYY hh:mm A");

        // console.log(getcurdttimemom+" momentofcurrenttime "+momentofcurrenttime);

        //*********** adding days with current date
		var reqformat_momentdy = moment(getcurdttimemom,"DD/MM/YYYY hh:mm A").add(reqexpday_hrs,"hours").format("DD/MM/YYYY hh:mm A");

		var reqformat_momentdyhr = moment(reqformat_momentdy,"DD/MM/YYYY hh:mm A").add(reqexphr,"hours").format("DD/MM/YYYY hh:mm A");

		var reqformat_momentdymn = moment(reqformat_momentdyhr,"DD/MM/YYYY hh:mm A").add(reqexpm,"minutes").format("DD/MM/YYYY hh:mm A");
		
		//*********** getting moment of requesy expire date
		var reqformat_momentvl = moment(reqformat_momentdymn,"DD/MM/YYYY hh:mm A");
		//console.log("reqformat_momentdymn "+reqformat_momentdymn+" reqformat_momentvl "+reqformat_momentvl);

		//********** checking if days go heigher strats 

		if( reqformat_momentvl > totaltimeformat_moment)
		{
			// console.log(" I am getting higher");
			$('#reqexpire_minute').parent().addClass("errorField");
			$('#reqexpire_minute').val('');
		}else{
			$('#reqexpire_minute').parent().removeClass("errorField");
			
		}
		//********** checking if days go heigher ends 

      });




	  //***************************** booking request expire time day hour minute ends here 29-12-2016***********************************
	 




