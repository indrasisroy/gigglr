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
                	 //$('#requestexpireddate').data("DateTimePicker").maxDate(bookingdate);	
                	 $("#start_time_hr_gig").val('');
                	 $("#start_time_mnt_gig").val(''); 
                	 $("#ddlViewBy_gig").val('');
                	 $('#requestexpireddate_gig').data("DateTimePicker").date(null);

						$("#end_time_hr_gig").val('');
						$("#end_time_mnt_gig").val('');
						$("#ddlViewend_gig").val('');
                });


	  $('#start_time_hr_gig').keyup(function(key){

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
				$("#ddlViewBy_gig").val(2);


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

	  });




	  //*************** start minute blur 

	  $('#start_time_mnt_gig').blur(function(key)
	  {

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







	  });

	  //*********end time hr key up

	  $('#end_time_hr_gig').keyup(function(key){
	  	var endtimehr_val = $('#end_time_hr_gig').val().length;
	  	if(endtimehr_val > 2)
	  	{
	  		$('#end_time_hr_gig').val('');
	  	}



//*****************  For hour logic starts

	  	var bookingdatevalue = $("#booking_date_gig").val(); ////****** booking date value

		var strtdateformat = $("#ddlViewBy_gig").val(); // start time format
		var getcurdttime = new Date(); //getting current date in javascript format
		var curentdate = moment(getcurdttime).format("DD/MM/YYYY hh:mm a"); //getting current date in  DD/MM/YYYY hh:mm a format
		var subtractdate =  moment(curentdate,"DD/MM/YYYY h:mm a").add(4,"hours").format("DD/MM/YYYY"); //****date
		var subtracttimehr_24 =  moment(curentdate,"DD/MM/YYYY h:mm a").add(4,"hours").format("HH"); //**** hour
		var subtracttimemn =  moment(curentdate,"DD/MM/YYYY h:mm a").add(4,"hours").format("mm"); //**** minute
		var subtracttimehr_ampm =  moment(curentdate,"DD/MM/YYYY h:mm a").add(4,"hours").format("hh"); //**** hour

		var htmntfrmat = moment(curentdate,"DD/MM/YYYY h:mm a").add(4,"hours").format("a");

		var starttimeval = $('#start_time_hr_gig').val();
		var strtimeminute = $('#start_time_mnt_gig').val();

		if(htmntfrmat == 'am')
		{
			htmntfrmat_check =1; 
		}else if(htmntfrmat == 'pm')
		{
			htmntfrmat_check =2; 
		}


		if(starttimeval == 00){
			starttimeval =12;
		}


// console.log("bookingdatevalue "+bookingdatevalue+" subtractdate "+subtractdate);
		if(bookingdatevalue == subtractdate)
		{

			// console.log("subtracttimehr_ampm ==== "+subtracttimehr_ampm);
			// console.log("starttimeval "+starttimeval);
			// console.log("strtimeminute "+strtimeminute);
			// console.log("subtracttimemn "+subtracttimemn);
				//alert("htmntfrmat_check "+htmntfrmat_check+" strtdateformat "+strtdateformat);
			if(htmntfrmat_check == strtdateformat)
			{
				// alert("starttimeval "+starttimeval+" subtracttimehr_ampm "+subtracttimehr_ampm);
				// alert("strtimeminute "+strtimeminute+" subtracttimemn "+subtracttimemn);
				if(starttimeval >= subtracttimehr_ampm)
				{
					if(starttimeval == subtracttimehr_ampm)
					{
						if(strtimeminute > subtracttimemn)
						{
							$('#start_time_hr_gig').val(starttimeval);
						}else
						{

							$('#start_time_mnt_gig').val('');
								$('#start_time_hr_gig').val('');

								$("#start_time_hr_gig_error").html('You can continue your booking after 4 hour of current time');
								$("#start_time_hr_gig_error").css("display", "block");

								setTimeout(function(){
								$("#start_time_hr_gig_error").css("display", "none");
								},2000);
						}
						
					}else if(starttimeval > subtracttimehr_ampm)
					{
						$('#start_time_hr_gig').val(starttimeval);
					}
					

				}else
				{
					//console.log("I am here");
								$('#start_time_mnt_gig').val('');
								$('#start_time_hr_gig').val('');

								$("#start_time_hr_gig_error").html('You can continue your booking after 4 hour of current time');
								$("#start_time_hr_gig_error").css("display", "block");

								setTimeout(function(){
								$("#start_time_hr_gig_error").css("display", "none");
								},2000);
				}
			}


			else if(htmntfrmat_check > strtdateformat)
			{
				
				
								$('#start_time_mnt_gig').val('');
								$('#start_time_hr_gig').val('');

								$("#start_time_hr_gig_error").html('You can continue your booking after 4 hour of current time');
								$("#start_time_hr_gig_error").css("display", "block");

								setTimeout(function(){
								$("#start_time_hr_gig_error").css("display", "none");
								},2000);
				
			}


		}

//***************** Four hour login ends

	  });

	  //*********end time hr key up


	   //*************** end time blur 

	  $('#end_time_hr_gig').blur(function(key){

	  	//*******end time value
	  	var end_time_hr = $('#end_time_hr_gig').val();
		var ddlViewend_gig = $("#ddlViewend_gig").val();
		//*****

		//*******start time value
		var start_time_hr_gig = $('#start_time_hr_gig').val();
		var ddlViewBy_gig = $("#ddlViewBy_gig").val();
		//*****

		if(end_time_hr!="" && end_time_hr < 24)
		{
			if(end_time_hr < 10 && end_time_hr.length==1 && (ddlViewend_gig == ddlViewBy_gig || ddlViewend_gig > ddlViewBy_gig))
			{
				end_time_hr =addzero(end_time_hr);
				$('#end_time_hr_gig').val(end_time_hr);
				//console.log("end_time_hr "+end_time_hr+" start_time_hr_gig "+start_time_hr_gig);
				if(end_time_hr >= start_time_hr_gig)
				{

					$('#end_time_hr_gig').val(end_time_hr);
				}else
				{
					$("#end_time_hr_gig_error").html('You have entered a old   value');
					$("#end_time_hr_gig_error").css("display", "block");

							setTimeout(function(){
							$("#end_time_hr_gig_error").css("display", "none");
							},2000);
					$("#end_time_hr_gig").val('');
					$("#ddlViewend_gig").val('');
				}


			}
			else if(end_time_hr < 10 && end_time_hr.length==2 && (ddlViewend_gig == ddlViewBy_gig || ddlViewend_gig > ddlViewBy_gig))
			{
				console.log("end_time_hr_gig"+end_time_hr);
				console.log("start_time_hr_gig"+start_time_hr_gig);
				if(end_time_hr >= start_time_hr_gig)
				{
					$('#end_time_hr_gig').val(end_time_hr);
				}else
				{
					$("#end_time_hr_gig_error").html('You have entered a old  value');
					$("#end_time_hr_gig_error").css("display", "block");

							setTimeout(function(){
							$("#end_time_hr_gig_error").css("display", "none");
							},2000);
					$('#end_time_hr_gig').val('');
					$("#ddlViewend_gig").val('');
				}
			}
			else if(end_time_hr < 10 && end_time_hr.length==2 && ddlViewend_gig < ddlViewBy_gig)
			{
				console.log("end_time_hr_gig"+end_time_hr);
				console.log("start_time_hr_gig"+start_time_hr_gig);
				
					$("#end_time_hr_gig_error").html('You have entered a old  value');
					$("#end_time_hr_gig_error").css("display", "block");

							setTimeout(function(){
							$("#end_time_hr_gig_error").css("display", "none");
							},2000);
					$('#end_time_hr_gig').val('');
					//$("#ddlViewend_gig").val('');
				
			}
			else if(end_time_hr >= 10 && end_time_hr.length==2 && ddlViewend_gig < ddlViewBy_gig)
			{
				console.log("ddlViewend_gig"+ddlViewend_gig);
				console.log("ddlViewBy_gig"+ddlViewBy_gig);
				end_time_hr = addhr_ampm(end_time_hr);
				if(end_time_hr >= start_time_hr_gig)
				{
					$('#end_time_hr_gig').val(end_time_hr);
					$("#ddlViewend_gig").val(2);
				}else{
					$("#end_time_hr_gig_error").html('You have entered a old  value');
					$("#end_time_hr_gig_error").css("display", "block");

							setTimeout(function(){
							$("#end_time_hr_gig_error").css("display", "none");
							},2000);
					$('#end_time_hr_gig').val('');

				}
					//$("#ddlViewend_gig").val('');
				
			}
			else if(end_time_hr > 12 && end_time_hr.length==2 && end_time_hr <24 && end_time_hr >= start_time_hr_gig)
			{
				
				end_time_hr = addhr_ampm(end_time_hr);

				$('#end_time_hr_gig').val(end_time_hr);
				$("#ddlViewend_gig").val(2);

				if(end_time_hr >= start_time_hr_gig)
				{
					$('#end_time_hr_gig').val(end_time_hr);
				}else
				{
					$("#end_time_hr_gig_error").html('You have entered a old  value');
					$("#end_time_hr_gig_error").css("display", "block");

							setTimeout(function(){
							$("#end_time_hr_error").css("display", "none");
							},2000);
					$('#end_time_hr_gig').val('');
					$("#ddlViewend_gig").val('');
				}

			}else if(end_time_hr < 12 && end_time_hr.length==2 && end_time_hr <24 && end_time_hr >= start_time_hr_gig)
			{
				
				$('#end_time_hr_gig').val(end_time_hr);
			}else if(end_time_hr > start_time_hr_gig && ddlViewend_gig == ddlViewBy_gig)
			{
				$('#end_time_hr_gig').val(end_time_hr);
			}
			else if( ddlViewend_gig < ddlViewBy_gig)
			{
				$('#end_time_hr_gig').val('');

				$("#end_time_hr_gig_error").html('You have entered a old  value');
				$("#end_time_hr_gig_error").css("display", "block");

													setTimeout(function(){
													$("#end_time_hr_gig_error").css("display", "none");
													},2000);
			}
			else
			{	
				$("#end_time_hr_gig_error").html('You have entered a wrong  value');
				$("#end_time_hr_gig_error").css("display", "block");

													setTimeout(function(){
													$("#end_time_hr_gig_error").css("display", "none");
													},2000);
				$('#end_time_hr_gig').val('');
			}
		}else{
						$('#end_time_hr_gig').val('');
						$("#end_time_hr_gig_error").html('You have entered a invalid value');
						$("#end_time_hr_gig_error").css("display", "block");

													setTimeout(function(){
													$("#end_time_hr_gig_error").css("display", "none");
													},2000);
		}
					$("#end_time_mnt_gig").val('');







					//*********** Setting up of data for request expire date

			var booking_date_val = $("#booking_date_gig").val();
			var booking_bookingtime_hrval = $("#start_time_hr_gig").val();
			var booking_bookingtime_mntval = $("#start_time_mnt_gig").val();
			var booking_bookingtime_frmatval = $("#ddlViewBy_gig").val();
			var booking_bookingtime_frmatval_check = "";
			 if(booking_bookingtime_frmatval ==  1)
			 {
			 	booking_bookingtime_frmatval_check = 'am';
			 }else
			 {
			 	booking_bookingtime_frmatval_check = 'pm';
			 }

			if(booking_date_val!="" && booking_bookingtime_hrval!="" && booking_bookingtime_mntval!="")
			{
				var totalbookingdatetime = booking_date_val+' '+booking_bookingtime_hrval+':'+booking_bookingtime_mntval+' '+booking_bookingtime_frmatval_check;

				//console.log(" totalbookingdatetime "+totalbookingdatetime);
				var subtractdateval = moment(totalbookingdatetime,"DD/MM/YYYY h:mm a").subtract(4,"hours").format("DD/MM/YYYY");
				//console.log(" subtractdateval "+subtractdateval);
				$('#requestexpireddate_gig').data("DateTimePicker").maxDate(subtractdateval);
				$('#requestexpireddate_gig').data("DateTimePicker").date(null);	

				// alert("booking_bookingtime_hrval "+booking_bookingtime_hrval+" booking_bookingtime_mntval "+booking_bookingtime_mntval+" booking_bookingtime_frmatval "+booking_bookingtime_frmatval);
			}
					






					
	  });




	  //*************** end minute blur 

	  $('#end_time_mnt_gig').blur(function(key){

	  	//**********end time starts
	  	var end_time_hr = $('#end_time_hr_gig').val();
	  	var end_time_mnt = $('#end_time_mnt_gig').val();
		var ddlViewend_gig = $("#ddlViewend_gig").val();

		//******** start time starts

		var start_time_hr_gig = $('#start_time_hr_gig').val();
	  	var start_time_mnt_gig = $('#start_time_mnt_gig').val();
		var ddlViewBy_gig = $("#ddlViewBy_gig").val();


		if(end_time_mnt!="" && end_time_mnt < 60)
		{
			if(end_time_mnt < 10 && end_time_mnt.length==1)
			{
				end_time_mnt =addzero(end_time_mnt);
				//$('#end_time_mnt').val(end_time_mnt);
				//console.log("end_time_mnt"+end_time_mnt);
				if(end_time_hr == start_time_hr_gig)
				{
						if(start_time_mnt_gig < end_time_mnt)
						{
							$('#end_time_mnt_gig').val(end_time_mnt);
						}else
						{
							$('#end_time_mnt_gig').val('');
							$("#end_time_hr_gig_error").html('You have entered a old  value');
							$("#end_time_hr_gig_error").css("display", "block");

							setTimeout(function(){
							$("#end_time_hr_gig_error").css("display", "none");
							},2000);
						}
				}else
				{
					$('#end_time_mnt_gig').val(end_time_mnt);
				}




			}
			else if(end_time_hr > start_time_hr_gig &&  ddlViewBy_gig < ddlViewend_gig)
			{
				$('#end_time_mnt_gig').val(end_time_mnt);
			}
			else if(end_time_hr >= start_time_hr_gig &&  ddlViewBy_gig == ddlViewend_gig)
			{

				if(end_time_hr == start_time_hr_gig)
				{
						if(start_time_mnt_gig < end_time_mnt)
						{
							$('#end_time_mnt_gig').val(end_time_mnt);
						}else
						{
							$('#end_time_mnt_gig').val('');
							$("#end_time_hr_gig_error").html('You have entered a old  value');
							$("#end_time_hr_gig_error").css("display", "block");

							setTimeout(function(){
							$("#end_time_hr_gig_error").css("display", "none");
							},2000);
						}
				}else if(end_time_hr > start_time_hr_gig)
				{
					$('#end_time_mnt_gig').val(end_time_mnt);
				}
			}
			else
			{
				$('#end_time_mnt_gig').val(end_time_mnt);

				$("#end_time_hr_gig_error").html('You have entered a old  value');
				$("#end_time_hr_gig_error").css("display", "block");

					setTimeout(function(){
					$("#end_time_hr_gig_error").css("display", "none");
					},2000);
			}
		}else{
				$('#end_time_mnt_gig').val('');

				$("#end_time_hr_gig_error").html('You have entered a invalid value');
				$("#end_time_hr_gig_error").css("display", "block");

					setTimeout(function(){
					$("#end_time_hr_gig_error").css("display", "none");
					},2000);
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
								$("#start_time_hr_gig_error").html('You have entered a old value');
								$("#start_time_hr_gig_error").css("display", "block");

								setTimeout(function(){
								$("#start_time_hr_gig_error").css("display", "none");
								},2000);

								} 
				
			}else if(startdateformat < ddlViewBy_gigval)
			{

			}else
			{
								$('#start_time_hr_gig').val('');
								$('#start_time_mnt_gig').val('');
								$("#start_time_hr_gig_error").html('You have entered a old  value');
								$("#start_time_hr_gig_error").css("display", "block");

								setTimeout(function(){
								$("#start_time_hr_gig_error").css("display", "none");
								},2000);

						 
			}
		}



	  	$("#end_time_hr_gig").val('');
	  	$("#end_time_mnt_gig").val('');
	  	$("#ddlViewend_gig").val('');





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
                	$('#ddlViewrequestexpire_gig').val('');
                });


	   //******* request expire time hour key up starts
	    $('#requexpire_time_hr_gig').keyup(function(key){

	    	var requestexpireddate_val = $("#requestexpireddate_gig").val();
	    	if(requestexpireddate_val == "")
	    	{
	    		$('#requexpire_time_hr_gig').val('');
	    	}

	    	var requestexpireddate_length = $('#requexpire_time_hr_gig').val().length;
		  	if(requestexpireddate_length > 2)
		  	{
		  		$('#requexpire_time_hr_gig').val('');
		  	}

	    });



	  //******* request expire time hour key up ends


	  //******* request expire time hour blur starts

	  	 $('#requexpire_time_hr_gig').blur(function(key){


	  	 	var requestexpireddate_val = $("#requestexpireddate_gig").val();

	  	 	var requestexpireddatehr_val = $("#requexpire_time_hr_gig").val();
	  	 	var requestexpireddatemnt_val = $("#reqexpire_time_mnt_gig").val();
	  	 	var requestexpireformat = $("#ddlViewrequestexpire_gig").val();

	  	 	var requestexpireformatval = "";

	  	 	// if(requestexpireformat == 1)
	  	 	// {
	  	 	// 	requestexpireformatval = 'am';
	  	 	// }else
	  	 	// {
	  	 	// 	requestexpireformatval = 'pm';
	  	 	// }

	  	 	if(requestexpireddatemnt_val == "")
	  	 	{
	  	 		requestexpireddatemnt_val = '00';
	  	 	}



if(requestexpireddatehr_val!="" && requestexpireddatehr_val < 24)
		{
				if(requestexpireddatehr_val < 10 && requestexpireddatehr_val.length==1)
				{
					requestexpireddatehr_val =addzero(requestexpireddatehr_val);

					$("#requexpire_time_hr_gig").val(requestexpireddatehr_val);
				}else if(requestexpireddatehr_val > 12 && requestexpireddatehr_val.length==2 && requestexpireddatehr_val <24)
				{
					
					requestexpireddatehr_val = addhr_ampm(requestexpireddatehr_val);
					$('#requexpire_time_hr_gig').val(requestexpireddatehr_val);
					$("#ddlViewrequestexpire_gig").val(2);

					 requestexpireformat = $("#ddlViewrequestexpire_gig").val();
				}

			if(requestexpireformat == 1)
	  	 	{
	  	 		requestexpireformatval = 'am';
	  	 	}else
	  	 	{
	  	 		requestexpireformatval = 'pm';
	  	 	}
				console.log("requestexpireddatehr_val "+requestexpireddatehr_val+" requestexpireddatemnt_val "+requestexpireddatemnt_val+"requestexpireformat "+requestexpireformatval);



	  	 	requestexpireddate_val = moment(requestexpireddate_val,"DD/MM/YYYY").format('MM/DD/YYYY');
	  	 	var requestexpiretimeval = requestexpireddate_val+' '+requestexpireddatehr_val+':'+requestexpireddatemnt_val+":00 "+requestexpireformatval;

	    	var getcurdttime = new Date(); //getting current date in javascript format
			var curentdate = moment(getcurdttime).format("DD/MM/YYYY hh:mm a"); //getting current date in  DD/MM/YYYY 

			

			var reqestexpiretimefunc = reqestexpiredateconversion(requestexpiretimeval);
	    		
	    	
	    	if(reqestexpiretimefunc == false)
	    	{
	    						$('#requexpire_time_hr_gig').val('');
								$('#reqexpire_time_mnt_gig').val('');
								$('#ddlViewrequestexpire_gig').val('');
								$("#requexpire_time_hr_gig_error").html('You have entered  invalid value');
								$("#requexpire_time_hr_gig_error").css("display", "block");

								setTimeout(function(){
								$("#requexpire_time_hr_gig_error").css("display", "none");
								},2000);
	    	}

	    	var reqestexpiretimefuncmin = reqestexpiredateconversionmindate(requestexpiretimeval);

	    	if(reqestexpiretimefuncmin == false)
	    	{
	    						$('#requexpire_time_hr_gig').val('');
								$('#reqexpire_time_mnt_gig').val('');
								$('#ddlViewrequestexpire_gig').val('');
								$("#requexpire_time_hr_gig_error").html('You have entered  invalid value');
								$("#requexpire_time_hr_gig_error").css("display", "block");

								setTimeout(function(){
								$("#requexpire_time_hr_gig_error").css("display", "none");
								},2000);
	    	}
	    	
	    }else{
	    					$('#requexpire_time_hr_gig').val('');
								$('#reqexpire_time_mnt_gig').val('');
								$('#ddlViewrequestexpire_gig').val('');
								$("#requexpire_time_hr_gig_error").html('You have entered  invalid value');
								$("#requexpire_time_hr_gig_error").css("display", "block");

								setTimeout(function(){
								$("#requexpire_time_hr_gig_error").css("display", "none");
								},2000);





	    }


	  	 });
	  //******* request expire time hour blur starts
	  $('#reqexpire_time_mnt_gig').keyup(function(key){

	  	var requestexpiretimeval  =$("#requexpire_time_hr_gig").val();

				if( requestexpiretimeval == "")
		  	 	{
		  	 		$("#reqexpire_time_mnt_gig").val('');
		  	 	}

		 var requestexpireddate_length = $('#reqexpire_time_mnt_gig').val().length;
		  	if(requestexpireddate_length > 2)
		  	{
		  		$('#reqexpire_time_mnt_gig').val('');
		  	}

});


	  $('#reqexpire_time_mnt_gig').blur(function(key){

	  	 	var requestexpireddate_val = $("#requestexpireddate_gig").val();

	  	 	var requestexpireddatehr_val = $("#requexpire_time_hr_gig").val();
	  	 	var requestexpireddatemnt_val = $("#reqexpire_time_mnt_gig").val();
	  	 	var requestexpireformat = $("#ddlViewrequestexpire_gig").val();

	  	 	var requestexpireformatval = "";

	  	 	if(requestexpireformat == 1)
	  	 	{
	  	 		requestexpireformatval = 'am';
	  	 	}else
	  	 	{
	  	 		requestexpireformatval = 'pm';
	  	 	}

	  	 	if(requestexpireddatemnt_val == "")
	  	 	{
	  	 		requestexpireddatemnt_val = '00';
	  	 	}


	  	 	if(requestexpireddatemnt_val < 10 && requestexpireddatemnt_val.length==1)
			{
				requestexpireddatemnt_val =addzero(requestexpireddatemnt_val);
				$("#reqexpire_time_mnt_gig").val(requestexpireddatemnt_val);
			}


if(requestexpireddatemnt_val!="" && requestexpireddatemnt_val < 60)
		{


	  	 	requestexpireddate_val = moment(requestexpireddate_val,"DD/MM/YYYY").format('MM/DD/YYYY');
	  	 	var requestexpiretimeval = requestexpireddate_val+' '+requestexpireddatehr_val+':'+requestexpireddatemnt_val+":00 "+requestexpireformatval;

	    	var getcurdttime = new Date(); //getting current date in javascript format
			var curentdate = moment(getcurdttime).format("DD/MM/YYYY hh:mm a"); //getting current date in  DD/MM/YYYY 

			// console.log("curentdate"+curentdate+" requestexpireddate_val "+requestexpireddate_val);
			//console.log("requestexpiretimeval"+requestexpiretimeval);

			var reqestexpiretimefunc = reqestexpiredateconversion(requestexpiretimeval);
	    		
	    	//console.log(reqestexpiretimefunc);
	    	if(reqestexpiretimefunc == false)
	    	{
	    						$('#requexpire_time_hr_gig').val('');
								$('#reqexpire_time_mnt_gig').val('');
								$('#ddlViewrequestexpire_gig').val('');
								$("#requexpire_time_hr_gig_error").html('You have entered  invalid value');
								$("#requexpire_time_hr_gig_error").css("display", "block");

								setTimeout(function(){
								$("#requexpire_time_hr_gig_error").css("display", "none");
								},2000);
	    	}

	    	var reqestexpiretimefuncmin = reqestexpiredateconversionmindate(requestexpiretimeval);

	    	if(reqestexpiretimefuncmin == false)
	    	{
	    						$('#requexpire_time_hr_gig').val('');
								$('#reqexpire_time_mnt_gig').val('');
								$('#ddlViewrequestexpire_gig').val('');
								$("#requexpire_time_hr_gig_error").html('You have entered  invalid value');
								$("#requexpire_time_hr_gig_error").css("display", "block");

								setTimeout(function(){
								$("#requexpire_time_hr_gig_error").css("display", "none");
								},2000);
	    	}
	    	
}else{

								$('#reqexpire_time_mnt_gig').val('');
								$('#ddlViewrequestexpire_gig').val('');
								$("#requexpire_time_hr_gig_error").html('You have entered  invalid value');
								$("#requexpire_time_hr_gig_error").css("display", "block");

								setTimeout(function(){
								$("#requexpire_time_hr_gig_error").css("display", "none");
								},2000);
}


	  	 });
	  //******* request expire time hour blur starts



	  $("#ddlViewrequestexpire_gig").change(function(){


	  		var requestexpireddate_val = $("#requestexpireddate_gig").val();

	  	 	var requestexpireddatehr_val = $("#requexpire_time_hr_gig").val();
	  	 	var requestexpireddatemnt_val = $("#reqexpire_time_mnt_gig").val();
	  	 	var requestexpireformat = $("#ddlViewrequestexpire_gig").val();

	  	 	var requestexpireformatval = "";

		  	 if(requestexpireddatehr_val!="" && requestexpireddatemnt_val!="")	
		  	 {

		  	 	if(requestexpireformat == 1)
		  	 	{
		  	 		requestexpireformatval = 'am';
		  	 	}else
		  	 	{
		  	 		requestexpireformatval = 'pm';
		  	 	}

		  	 	if(requestexpireddatemnt_val == "")
		  	 	{
		  	 		requestexpireddatemnt_val = '00';
		  	 	}





				  	 	requestexpireddate_val = moment(requestexpireddate_val,"DD/MM/YYYY").format('MM/DD/YYYY');
				  	 	var requestexpiretimeval = requestexpireddate_val+' '+requestexpireddatehr_val+':'+requestexpireddatemnt_val+":00 "+requestexpireformatval;

				    	var getcurdttime = new Date(); //getting current date in javascript format
						var curentdate = moment(getcurdttime).format("DD/MM/YYYY hh:mm a"); //getting current date in  DD/MM/YYYY 

						// console.log("curentdate"+curentdate+" requestexpireddate_val "+requestexpireddate_val);
						//console.log("requestexpiretimeval"+requestexpiretimeval);

						var reqestexpiretimefunc = reqestexpiredateconversion(requestexpiretimeval);
				    		
				    	//console.log(reqestexpiretimefunc);
				    	if(reqestexpiretimefunc == false)
				    	{
				    						$('#requexpire_time_hr_gig').val('');
											$('#reqexpire_time_mnt_gig').val('');
											//$('#ddlViewrequestexpire_gig').val('');
											$("#requexpire_time_hr_gig_error").html('You have entered  invalid value');
											$("#requexpire_time_hr_gig_error").css("display", "block");

											setTimeout(function(){
											$("#requexpire_time_hr_gig_error").css("display", "none");
											},2000);
				    	}

				    	var reqestexpiretimefuncmin = reqestexpiredateconversionmindate(requestexpiretimeval);

				    	if(reqestexpiretimefuncmin == false)
				    	{
				    						$('#requexpire_time_hr_gig').val('');
											$('#reqexpire_time_mnt_gig').val('');
										//	$('#ddlViewrequestexpire_gig').val('');
											$("#requexpire_time_hr_gig_error").html('You have entered  invalid value');
											$("#requexpire_time_hr_gig_error").css("display", "block");

											setTimeout(function(){
											$("#requexpire_time_hr_gig_error").css("display", "none");
											},2000);
				    	}



			}

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
