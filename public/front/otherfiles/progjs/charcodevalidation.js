

	$('#booking_date').datetimepicker({
   				format: 'DD/MM/YYYY',
       			});
	$('#requestexpireddate').datetimepicker({
   				format: 'DD/MM/YYYY',
       			});
	 var momentdate = moment().format("DD/MM/YYYY h:mm a");
	 var mindatereqexpire = moment().format("DD/MM/YYYY");
	 var datecur_adddate =  moment(momentdate,"DD/MM/YYYY h:mm a").add(4,"hours").format("DD/MM/YYYY"); 
	 $('#booking_date').data("DateTimePicker").minDate(datecur_adddate);
	 $('#requestexpireddate').data("DateTimePicker").minDate(mindatereqexpire);	

	 

  $("#booking_date").on("dp.change", function(e)
                {
                	 var bookingdate = $("#booking_date").val();
                	 $('#requestexpireddate').data("DateTimePicker").maxDate(bookingdate);	
                	 $("#start_time_hr").val('');
                	 $("#start_time_mnt").val(''); 
                	 $("#ddlViewBy").val('');
                	 $('#requestexpireddate').data("DateTimePicker").date(null);
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

$('#start_time_hr').keyup(function(key){

	//console.log(key.charCode);

	

	var bookingdatevalue = $("#booking_date").val(); ////****** booking date value
	var starttime_hrval = $("#start_time_hr").val(); ////****** start time
	var starttimelength = $("#start_time_hr").val().length; ////****** start time length
	//var formattypeval = $("#ddlViewBy").val(); //************* format type val


	if(bookingdatevalue == "")
	{
		$("#start_time_hr").val(''); 
	}

	if(starttimelength > 1 && starttimelength < 3)
	{
				if( starttime_hrval == '00')
				{
					$("#ddlViewBy").val(1);
																	
				}

				var strtdateformat = $("#ddlViewBy").val(); // start time format
		     	var getcurdttime = new Date(); //getting current date in javascript format
                var curentdate = moment(getcurdttime).format("DD/MM/YYYY hh:mm a"); //getting current date in  DD/MM/YYYY hh:mm a format
                var subtractdate =  moment(curentdate,"DD/MM/YYYY h:mm a").add(4,"hours").format("DD/MM/YYYY"); //****date
                var subtracttimehr =  moment(curentdate,"DD/MM/YYYY h:mm a").add(4,"hours").format("HH"); //**** hour
                var subtracttimemn =  moment(curentdate,"DD/MM/YYYY h:mm a").add(4,"hours").format("mm"); //**** minute
	         	
	         	////***** condition for checking if start date value and after four hour date value is same
	         	var subtracttimehrsec =  moment(curentdate,"DD/MM/YYYY h:mm a").add(4,"hours").format("hh"); //**** hour
	         	if(strtdateformat == '1')  //*********if we are on am format
	         	{

					         	if(bookingdatevalue == subtractdate)  //*****if we are on same date
					         	{	
					         		
					         			if(parseInt(subtracttimehr) > parseInt(starttime_hrval))
						         		{
						         				$("#start_time_hr_error").css("display", "block");

													setTimeout(function(){
													$("#start_time_hr_error").css("display", "none");
													},2000)
						         				$("#start_time_hr").val('');



						         		}else 
						         		{
							         		if(parseInt(starttime_hrval) >= 00 && parseInt(starttime_hrval) <= 23)
								         	{
								         		$("#start_time_hr").val(starttime_hrval);
								         		
								         	}else
								         	{
								         		$("#start_time_hr").val('');
								         	}
						         		}

					         			
					         	}else
					         	{
					         		if(parseInt(starttime_hrval) >= 00 && parseInt(starttime_hrval) <= 23)
							         	{
							         		$("#start_time_hr").val(starttime_hrval);
							         		
							         	}else
							         	{
							         		$("#start_time_hr_error").css("display", "block");

													setTimeout(function(){
													$("#start_time_hr_error").css("display", "none");
													},2000);
							         		$("#start_time_hr").val('');
							         	}
					         	}
	           
				}else if(strtdateformat == '2')
				{
					
					if(bookingdatevalue == subtractdate)
					         	{	
					         		//console.log("subtracttimehrsec "+subtracttimehrsec+" > starttime_hrval"+starttime_hrval);
					         			if(parseInt(subtracttimehrsec) > parseInt(starttime_hrval))
						         		{
						         			//console.log("Hello");

						         			$("#start_time_hr_error").css("display", "block");

													setTimeout(function(){
													$("#start_time_hr_error").css("display", "none");
													},2000);
						         				$("#start_time_hr").val('');



						         		}else 
						         		{
							         		if(parseInt(starttime_hrval) >= 00 && parseInt(starttime_hrval) <= 23)
								         	{
								         		$("#start_time_hr").val(starttime_hrval);
								         		
								         	}else
								         	{
								         		$("#start_time_hr_error").css("display", "block");

													setTimeout(function(){
													$("#start_time_hr_error").css("display", "none");
													},2000);
								         		$("#start_time_hr").val('');
								         	}
						         		}

					         			
					         	}else
					         	{
					         		if(parseInt(starttime_hrval) >= 00 && parseInt(starttime_hrval) <= 23)
							         	{
							         		$("#start_time_hr").val(starttime_hrval);
							         		
							         	}else
							         	{
							         		$("#start_time_hr_error").css("display", "block");

													setTimeout(function(){
													$("#start_time_hr_error").css("display", "none");
													},2000);
							         		$("#start_time_hr").val('');
							         	}
					         	}
				}

				$("#start_time_mnt").val(''); // cleaning minute data


		}
		else if(starttimelength >2)
		{
			$("#start_time_hr").val('');
		}	    
					
});




//************** For minutes checking starts here

$('#start_time_mnt').keyup(function(key){

		var starttime_mnval =  $("#start_time_mnt").val(); // start time minute value
     	var bookingdatevalue = $("#booking_date").val(); // booking date value
     	var starttimehrval =   $("#start_time_hr").val(); // start time value
     	var starttime_mnvallength = starttime_mnval.toString().length;

     	if(starttimehrval == "")
     	{
     		$("#start_time_mnt").val('');
     	}


if(starttime_mnvallength >1 && starttime_mnvallength <3)
{
				
	         	var getcurdttime = new Date(); //getting current date in javascript format
                var curentdate = moment(getcurdttime).format("DD/MM/YYYY hh:mm a");

                var subtractdate =  moment(curentdate,"DD/MM/YYYY h:mm a").add(4,"hours").format("DD/MM/YYYY");
                var subtracttimehr =  moment(curentdate,"DD/MM/YYYY h:mm a").add(4,"hours").format("HH");
                var subtracttimemn =  moment(curentdate,"DD/MM/YYYY h:mm a").add(4,"hours").format("mm");


	         	var ampmvalue =$("#ddlViewBy").val();

	         	if(starttime_mnvallength > 2)
	         	{
	         		$("#start_time_mnt").val('');


	         	}
	         	else
	         	{
	         	
					         	if(bookingdatevalue == subtractdate)
					         	{
					         		//console.log("We are in same date"+starttimehrval);
					         		if(starttimehrval <= 11 && ampmvalue == 2)
					         		{
					         			starttimehrval = parseInt(starttimehrval)+12;
					         			//alert(starttimehrval);
					         			
					         		}
					         		if(starttimehrval > subtracttimehr)
					         		{
					         			if(starttime_mnval >= 00 && starttime_mnval <= 59)
							         	{
							         		$("#start_time_mnt").val(starttime_mnval);
							         		
							         	}else
							         	{
							         		$("#start_time_mnt").val('');
							         		$("#start_time_hr_error").css("display", "block");

													setTimeout(function(){
													$("#start_time_hr_error").css("display", "none");
													},2000);
							         	}
					         		}else if(starttimehrval == subtracttimehr)
					         		{
					         			//console.log(starttimehrval + " "+subtracttimehr);
					         				if(parseInt(starttime_mnval) >= parseInt(subtracttimemn) && parseInt(starttime_mnval) <= 59)
							         	{
							         		$("#start_time_mnt").val(starttime_mnval);
							         		
							         	}else
							         	{
							         		$("#start_time_mnt").val('');
							         		$("#start_time_hr_error").css("display", "block");

													setTimeout(function(){
													$("#start_time_hr_error").css("display", "none");
													},2000);
							         	}
					         		}

							         	
					         	}else
					         	{
					         		if(starttime_mnval >= 00 && starttime_mnval <= 59)
							         	{
							         		$("#start_time_mnt").val(starttime_mnval);
							         		
							         	}else
							         	{
							         		$("#start_time_mnt").val('');
							         		$("#start_time_hr_error").css("display", "block");

													setTimeout(function(){
													$("#start_time_hr_error").css("display", "none");
													},2000);
							         	}
					         	}
	            }
	        }
	        else if(starttime_mnvallength >2)
		{
			$("#start_time_mnt").val('');
		}	

			    
					
});


$('#start_time_mnt').blur(function(){
	var start_time_mnt_val_len = $('#start_time_mnt').val().length;
	if(start_time_mnt_val_len == 1)
	{
		var start_time_mnt_val = '0'+$('#start_time_mnt').val();
		$('#start_time_mnt').val(start_time_mnt_val);
	}



	var starttime_mnval =  $("#start_time_mnt").val(); // start time minute value
     	var bookingdatevalue = $("#booking_date").val(); // booking date value
     	var starttimehrval =   $("#start_time_hr").val(); // start time value
     	var starttime_mnvallength = starttime_mnval.toString().length;

     	if(starttimehrval == "")
     	{
     		$("#start_time_mnt").val('');
     	}


if(starttime_mnvallength >1 && starttime_mnvallength <3)
{
				
	         	var getcurdttime = new Date(); //getting current date in javascript format
                var curentdate = moment(getcurdttime).format("DD/MM/YYYY hh:mm a");

                var subtractdate =  moment(curentdate,"DD/MM/YYYY h:mm a").add(4,"hours").format("DD/MM/YYYY");
                var subtracttimehr =  moment(curentdate,"DD/MM/YYYY h:mm a").add(4,"hours").format("HH");
                var subtracttimemn =  moment(curentdate,"DD/MM/YYYY h:mm a").add(4,"hours").format("mm");


	         	var ampmvalue =$("#ddlViewBy").val();

	         	if(starttime_mnvallength > 2)
	         	{
	         		$("#start_time_mnt").val('');


	         	}
	         	else
	         	{
	         	
					         	if(bookingdatevalue == subtractdate)
					         	{
					         		//console.log("We are in same date"+starttimehrval);
					         		if(starttimehrval <= 11 && ampmvalue == 2)
					         		{
					         			starttimehrval = parseInt(starttimehrval)+12;
					         			//alert(starttimehrval);
					         			
					         		}
					         		if(starttimehrval > subtracttimehr)
					         		{
					         			if(starttime_mnval >= 00 && starttime_mnval <= 59)
							         	{
							         		$("#start_time_mnt").val(starttime_mnval);
							         		
							         	}else
							         	{
							         		$("#start_time_mnt").val('');
							         		$("#start_time_hr_error").css("display", "block");

													setTimeout(function(){
													$("#start_time_hr_error").css("display", "none");
													},2000);
							         	}
					         		}else if(starttimehrval == subtracttimehr)
					         		{
					         			//console.log(starttimehrval + " "+subtracttimehr);
					         				if(parseInt(starttime_mnval) >= parseInt(subtracttimemn) && parseInt(starttime_mnval) <= 59)
							         	{
							         		$("#start_time_mnt").val(starttime_mnval);
							         		
							         	}else
							         	{
							         		$("#start_time_mnt").val('');
							         		$("#start_time_hr_error").css("display", "block");

													setTimeout(function(){
													$("#start_time_hr_error").css("display", "none");
													},2000);
							         	}
					         		}

							         	
					         	}else
					         	{
					         		if(starttime_mnval >= 00 && starttime_mnval <= 59)
							         	{
							         		$("#start_time_mnt").val(starttime_mnval);
							         		
							         	}else
							         	{
							         		$("#start_time_mnt").val('');
							         		$("#start_time_hr_error").css("display", "block");

													setTimeout(function(){
													$("#start_time_hr_error").css("display", "none");
													},2000);
							         	}
					         	}
	            }
	        }
	        else if(starttime_mnvallength >2)
		{
			$("#start_time_mnt").val('');
		}	



	
});

//************** For minutes checking ends here




//************* Hour on blur checking starts here

$('#start_time_hr').blur(function(key){


	var starttimeval = $('#start_time_hr').val();
	var strttimeformatval = $("#ddlViewBy").val();


	
	//starttimeval  = starttimeval;

	if(starttimeval!="")
	{
				if(starttimeval == '0')
				{
					$('#start_time_hr').val('00');
					$("#ddlViewBy").val(1);
				}
				else if(starttimeval == '1'){
				//	if(strttimeformatval == )
					$('#start_time_hr').val('01');
					//$("#ddlViewBy").val(1);
				}
				else if(starttimeval == '2'){
					$('#start_time_hr').val('02');
					//$("#ddlViewBy").val(1);
				}
				else if(starttimeval == '3'){
					$('#start_time_hr').val('03');
					//$("#ddlViewBy").val(1);
				}
				else if(starttimeval == '4'){
					$('#start_time_hr').val('04');
					//$("#ddlViewBy").val(1);
				}
				else if(starttimeval == '5'){
					$('#start_time_hr').val('05');
					//$("#ddlViewBy").val(1);
				}
				else if(starttimeval == '6'){
					$('#start_time_hr').val('06');
					//$("#ddlViewBy").val(1);
				}
				else if(starttimeval == '7'){
					$('#start_time_hr').val('07');
					//$("#ddlViewBy").val(1);
				}
				else if(starttimeval == '8'){
					$('#start_time_hr').val('08');
					//$("#ddlViewBy").val(1);
				}
				else if(starttimeval == '9'){
					$('#start_time_hr').val('09');
					//$("#ddlViewBy").val(1);
				}
				else if(starttimeval == '10'){
					$('#start_time_hr').val('10');
					//$("#ddlViewBy").val(1);
				}
				else if(starttimeval == '11'){
					$('#start_time_hr').val('11');
					//$("#ddlViewBy").val(1);
				}
				else if(starttimeval == '12'){
					$('#start_time_hr').val('12');
					$("#ddlViewBy").val(2);
				}
				else if(starttimeval == '13')
				{
					$('#start_time_hr').val('01');
					$("#ddlViewBy").val(2);
				}
				else if(starttimeval == '14')
				{
					$('#start_time_hr').val('02');
					$("#ddlViewBy").val(2);
				}
				else if(starttimeval == '15')
				{
					$('#start_time_hr').val('03');
					$("#ddlViewBy").val(2);
				}
				else if(starttimeval == '16')
				{
					$('#start_time_hr').val('04');
					$("#ddlViewBy").val(2);
				}
				else if(starttimeval == '17')
				{
					$('#start_time_hr').val('05');
					$("#ddlViewBy").val(2);
				}
				else if(starttimeval == '18')
				{
					$('#start_time_hr').val('06');
					$("#ddlViewBy").val(2);
				}
				else if(starttimeval == '19')
				{
					$('#start_time_hr').val('07');
					$("#ddlViewBy").val(2);
				}
				else if(starttimeval == '20')
				{
					$('#start_time_hr').val('08');
					$("#ddlViewBy").val(2);
				}
				else if(starttimeval == '21')
				{
					$('#start_time_hr').val('09');
					$("#ddlViewBy").val(2);
				}
				else if(starttimeval == '22')
				{
					$('#start_time_hr').val('10');
					$("#ddlViewBy").val(2);
				}
				else if(starttimeval == '23')
				{
					$('#start_time_hr').val('11');
					$("#ddlViewBy").val(2);
				}
		}


		var starttimevalsecond = $('#start_time_hr').val();


		var bookingdatevalue = $("#booking_date").val(); ////****** booking date value
		var getcurdttime = new Date(); //getting current date in javascript format
        var curentdate = moment(getcurdttime).format("DD/MM/YYYY hh:mm a"); //getting current date in  DD/MM/YYYY hh:mm a format
        var subtractdate =  moment(curentdate,"DD/MM/YYYY h:mm a").add(4,"hours").format("DD/MM/YYYY"); //****date
        var subtracttimehr =  moment(curentdate,"DD/MM/YYYY h:mm a").add(4,"hours").format("HH"); //**** hour

        var subtracttimehr_sec =  moment(curentdate,"DD/MM/YYYY h:mm a").add(4,"hours").format("hh"); //**** hour

        var formattypeval = $("#ddlViewBy").val();

		

		if(bookingdatevalue == subtractdate)
					         	{	
					         		if(formattypeval == 1)
					         		{
					         		
					         			if(parseInt(subtracttimehr) > parseInt(starttimevalsecond))
						         		{
												$("#start_time_hr_error").css("display", "block");

													setTimeout(function(){
													$("#start_time_hr_error").css("display", "none");
													},2000)
						         			
						         				$("#start_time_hr").val('');
						         		}
						         	}
						         	if(formattypeval == 2)
					         		{
//					         			console.log("subtracttimehr_sec > starttimevalsecond"+subtracttimehr_sec+" > "+starttimevalsecond );


										if(parseInt(starttimevalsecond) == 12)
										{
											starttimevalsecond = '00';
										}

					         			if(parseInt(subtracttimehr_sec) > parseInt(starttimevalsecond))
						         		{
												$("#start_time_hr_error").css("display", "block");

													setTimeout(function(){
													$("#start_time_hr_error").css("display", "none");
													},2000)
						         			
						         				$("#start_time_hr").val('');
						         		}
						         	}
						         }


						   //  }

});

//************* Hour on blur chcking ends here


//************* Format change option 

$('#ddlViewBy').on('change', function(e) {
  


							var starttimeval_hr = $('#start_time_hr').val();
							var bookingdatevalue = $("#booking_date").val(); ////****** booking date value



							var getcurdttime = new Date(); //getting current date in javascript format
							var curentdate = moment(getcurdttime).format("DD/MM/YYYY hh:mm a"); //getting current date in  DD/MM/YYYY hh:mm a format
							var subtractdate =  moment(curentdate,"DD/MM/YYYY h:mm a").add(4,"hours").format("DD/MM/YYYY"); //****date
							var subtracttimehr =  moment(curentdate,"DD/MM/YYYY h:mm a").add(4,"hours").format("HH"); //**** hour

							var formattypeval = $("#ddlViewBy").val();

							if(bookingdatevalue == subtractdate)
					         	{	
					         		if(parseInt(subtracttimehr) > parseInt(starttimeval_hr))
						         		{
						         			$('#start_time_hr').val('');
						         			$('#start_time_mnt').val('');
						         		}
					         	}


					         	if(formattypeval == 2)
					         	{
					         		var substrval = starttimeval_hr.substring(0,2);

					         		if(substrval == '00')
					         		{
					         			    $('#start_time_hr').val('');
						         			$('#start_time_mnt').val('');
					         		}
					         	}


					         	$('#end_time_hr').val('');
						        $('#end_time_mnt').val('');
						        $('#ddlViewend').val('');

});




//*********************  for endtime change starts here

$('#end_time_hr').keyup(function(key){

	var bookingdate = $("#booking_date").val();
	var bookingtime_hr = $('#start_time_hr').val();
	var bookingtime_mnt = $('#start_time_mnt').val();

	var endtimehr = $('#end_time_hr').val();
	var endtimehrlength = $('#end_time_hr').val().length;

	var timeformat = $('#ddlViewBy').val();
	var enddatetimeformat = $("#ddlViewend").val();
	var timeformatval = "";
	var complete_starttime ="";

	var timeformat_val = "";


	if(timeformat == 1)
	{
		timeformat_val ="am";
	}else if(timeformat == 2)
	{
		timeformat_val ="pm";
	}


	var converttime = bookingtime_hr+':'+bookingtime_mnt+" "+timeformat_val;
	var converttime_second= moment(converttime,"h:mm a").format("HH");
	var converttime_first = moment(converttime,"h:mm a" ).format("hh");
	console.log("converttime"+converttime+"converttime_first "+converttime_first+"converttime_second "+converttime_second);



			if(endtimehrlength > 1 && endtimehrlength <3)
			{
				if(bookingdate == '' || bookingtime_hr== '' || bookingtime_mnt== '')
				{
					$('#end_time_hr').val('');
				}else
				{
					if(timeformat == 1){
						bookingtime_hr = bookingtime_hr;
					}else{
						bookingtime_hr = parseInt(bookingtime_hr)+12;
					}

					if(enddatetimeformat == 1)
					{
						endtimehr = endtimehr;
					}else{
						endtimehr = parseInt(endtimehr)+12;
					}
					//alert("bookingtime_hr"+bookingtime_hr+"endtimehr"+endtimehr);
					if(parseInt(endtimehr) <24)
					{
						if(parseInt(endtimehr) < parseInt(bookingtime_hr) && parseInt(endtimehr) <24)
						{
							$('#end_time_hr').val('');
						}else if(parseInt(endtimehr) >= parseInt(bookingtime_hr) && parseInt(endtimehr) <24)
						{
							//$('#end_time_hr').val(endtimehr);
						}
					}else
					{
						$('#end_time_hr').val('');
					}
										


					
				}
			}
			else if(endtimehrlength >2)
			{
				$("#end_time_hr").val('');
			}	





});


//********************* end time on blur function 


$('#end_time_hr').blur(function(key){


	var endtimeval = $('#end_time_hr').val();

	//starttimeval  = starttimeval;

	if(endtimeval!="")
	{
				if(endtimeval == '0')
				{
					$('#end_time_hr').val('00');
					$("#ddlViewend").val(1);
				}
				else if(endtimeval == '1'){
					$('#end_time_hr').val('01');
					//$("#ddlViewend").val(1);
				}
				else if(endtimeval == '2'){
					$('#end_time_hr').val('02');
					//$("#ddlViewend").val(1);
				}
				else if(endtimeval == '3'){
					$('#end_time_hr').val('03');
					//$("#ddlViewend").val(1);
				}
				else if(endtimeval == '4'){
					$('#end_time_hr').val('04');
					//$("#ddlViewend").val(1);
				}
				else if(endtimeval == '5'){
					$('#end_time_hr').val('05');
					//$("#ddlViewend").val(1);
				}
				else if(endtimeval == '6'){
					$('#end_time_hr').val('06');
					//$("#ddlViewend").val(1);
				}
				else if(endtimeval == '7'){
					$('#end_time_hr').val('07');
					//$("#ddlViewend").val(1);
				}
				else if(endtimeval == '8'){
					$('#end_time_hr').val('08');
					//$("#ddlViewend").val(1);
				}
				else if(endtimeval == '9'){
					$('#end_time_hr').val('09');
					//$("#ddlViewend").val(1);
				}
				else if(endtimeval == '10'){
					$('#end_time_hr').val('10');
					//$("#ddlViewend").val(1);
				}
				else if(endtimeval == '11'){
					$('#end_time_hr').val('11');
					//$("#ddlViewend").val(1);
				}
				else if(endtimeval == '12'){
					$('#end_time_hr').val('12');
					$("#ddlViewend").val(2);
				}
				else if(endtimeval == '13')
				{
					$('#end_time_hr').val('01');
					$("#ddlViewend").val(2);
				}
				else if(endtimeval == '14')
				{
					$('#end_time_hr').val('02');
					$("#ddlViewend").val(2);
				}
				else if(endtimeval == '15')
				{
					$('#end_time_hr').val('03');
					$("#ddlViewend").val(2);
				}
				else if(endtimeval == '16')
				{
					$('#end_time_hr').val('04');
					$("#ddlViewend").val(2);
				}
				else if(endtimeval == '17')
				{
					$('#end_time_hr').val('05');
					$("#ddlViewend").val(2);
				}
				else if(endtimeval == '18')
				{
					$('#end_time_hr').val('06');
					$("#ddlViewend").val(2);
				}
				else if(endtimeval == '19')
				{
					$('#end_time_hr').val('07');
					$("#ddlViewend").val(2);
				}
				else if(endtimeval == '20')
				{
					$('#end_time_hr').val('08');
					$("#ddlViewend").val(2);
				}
				else if(endtimeval == '21')
				{
					$('#end_time_hr').val('09');
					$("#ddlViewend").val(2);
				}
				else if(endtimeval == '22')
				{
					$('#end_time_hr').val('10');
					$("#ddlViewend").val(2);
				}
				else if(endtimeval == '23')
				{
					$('#end_time_hr').val('11');
					$("#ddlViewend").val(2);
				}
		}






		var bookingdate = $("#booking_date").val();
	var bookingtime_hr = $('#start_time_hr').val();
	var bookingtime_mnt = $('#start_time_mnt').val();

	var endtimehr = $('#end_time_hr').val();
	var endtimehrlength = $('#end_time_hr').val().length;

	var timeformat = $('#ddlViewBy').val();
	var enddatetimeformat = $("#ddlViewend").val();
	var timeformatval = "";
	var complete_starttime ="";

	var timeformat_val = "";


	if(timeformat == 1)
	{
		timeformat_val ="am";
	}else if(timeformat == 2)
	{
		timeformat_val ="pm";
	}


	var converttime = bookingtime_hr+':'+bookingtime_mnt+" "+timeformat_val;
	var converttime_second= moment(converttime,"h:mm a").format("HH");
	var converttime_first = moment(converttime,"h:mm a" ).format("hh");
	console.log("converttime"+converttime+"converttime_first "+converttime_first+"converttime_second "+converttime_second);



			if(endtimehrlength > 1 && endtimehrlength <3)
			{
				if(bookingdate == '' || bookingtime_hr== '' || bookingtime_mnt== '')
				{
					$('#end_time_hr').val('');
				}else
				{
					if(timeformat == 1){
						bookingtime_hr = bookingtime_hr;
					}else{
						bookingtime_hr = parseInt(bookingtime_hr)+12;
					}

					if(enddatetimeformat == 1){
						endtimehr = endtimehr;
					}else{
						endtimehr = parseInt(endtimehr)+12;
					}
					//alert("bookingtime_hr"+bookingtime_hr+"endtimehr"+endtimehr);

					if(endtimehr < bookingtime_hr)
					{
						$('#end_time_hr').val('');
					}else if(endtimehr >= bookingtime_hr && endtimehr <24)
					{
						//$('#end_time_hr').val(endtimehr);
					}
										


					
				}
			}
			else if(endtimehrlength >2)
			{
				$("#end_time_hr").val('');
			}	


		

		

});

//************* Hour on blur chcking ends here




//********************* end time minute on blur function 


$('#end_time_mnt').keyup(function(key){
	var bookingdate = $("#booking_date").val();
	var starttime_hr = $('#start_time_hr').val();
	var starttime_mnt = $('#start_time_mnt').val();
	var endtime_hour = $("#end_time_hr").val();
	var endtime_minute = $("#end_time_mnt").val();
	var endtime_mntlength = endtime_minute.length;

	if(bookingdate == '' || starttime_hr == '' || starttime_mnt =='' || endtime_hour=='')
	{
		$("#end_time_mnt").val('');
	}else
	{
		if(endtime_mntlength > 1 && endtime_mntlength <3)
		{
			if(parseInt(endtime_hour) == parseInt(starttime_hr))
			{
				
				if((parseInt(endtime_minute) >= parseInt(starttime_mnt)) && parseInt(endtime_minute) < 59 )
				{
					
					$("#end_time_mnt").val(endtime_minute);
				}else
				{
					//console.log("I am here");
					$("#end_time_mnt").val('');
				}
			}

		}else if(endtime_mntlength > 2)
		{
			$("#end_time_mnt").val('');
		}
	}


});





//*************** request expire time starts











//************* request expire time hour

$("#requexpire_time_hr").keyup(function(){
	var rqexpiredate = $("#requestexpireddate").val();
	if(rqexpiredate == "")
	{
		$("#requexpire_time_hr_error").css("display", "block");

		setTimeout(function(){
			$("#requexpire_time_hr_error").css("display", "none");
		},1000);

		$("#requexpire_time_hr").val('');
	}else{
		

		var getcurdttime = new Date(); //getting current date in javascript format
        var curentdate = moment(getcurdttime).format("DD/MM/YYYY"); //getting current date in  DD/MM/YYYY hh:mm a format
        var requestexpireddate = $("#requestexpireddate").val();

        var currenttimehr = moment(getcurdttime).format("HH"); 
       	var reqexpiretimehr = $("#requexpire_time_hr").val();
       	var reqexpiretimehrlength = reqexpiretimehr.length;
        
        if(reqexpiretimehrlength >1 &&  reqexpiretimehrlength<3)
        {
	        if(requestexpireddate == curentdate)
	        {
	        	
	        	if(parseInt(reqexpiretimehr) >= parseInt(currenttimehr) && parseInt(reqexpiretimehr)<24)
	        	{
	        		$("#requexpire_time_hr").val(reqexpiretimehr);
	        		
	        	}else
	        	{
	        		$("#requexpire_time_hr").val('');
	        		
	        	}

	        }else
	        {
	        	if(parseInt(reqexpiretimehr) >= parseInt(00) && parseInt(reqexpiretimehr)<24)
	        	{
	        		$("#requexpire_time_hr").val(reqexpiretimehr);
	        		
	        	}else
	        	{
	        		$("#requexpire_time_hr").val('');
	        		
	        	}
	        }
   		}else if(reqexpiretimehrlength >2 )
   		{
   			$("#requexpire_time_hr_error").css("display", "block");
			
   			setTimeout(function(){
			$("#requexpire_time_hr_error").css("display", "none");
			},1000);
   			$("#requexpire_time_hr").val('');
	        		
   		}


	}
});

















//************* request expire time minute

$("#reqexpire_time_mnt").keyup(function(){
	var rqexpiredate = $("#requestexpireddate").val();
	if(rqexpiredate == "")
	{

		$("#requexpire_time_hr_error").css("display", "block");

		setTimeout(function(){
			$("#requexpire_time_hr_error").css("display", "none");
		},1000)



		$("#reqexpire_time_mnt").val('');
	}else
	{
		$("#requexpire_time_hr_error").css("display", "none");
	}
});

//**************  request expire time ends


 $("#requestexpireddate").on("dp.change", function(e)
                {
                	$("#requexpire_time_hr").val(''); 
                	$("#reqexpire_time_mnt").val(''); 
                	$("#ddlViewrequestexpire").val('');
                	 
                });



 //********************* end time on blur function 


$('#requexpire_time_hr').blur(function(key){


	var endtimeval = $('#requexpire_time_hr').val();

	//starttimeval  = starttimeval;

	if(endtimeval!="")
	{
				if(endtimeval == '0')
				{
					$('#requexpire_time_hr').val('00');
					$("#ddlViewrequestexpire").val(1);
				}
				
				else if(endtimeval == '1'){
					$('#requexpire_time_hr').val('01');
					$("#ddlViewrequestexpire").val(1);
				}
				
				else if(endtimeval == '2'){
					$('#requexpire_time_hr').val('02');
					$("#ddlViewrequestexpire").val(1);
				}
				else if(endtimeval == '3'){
					$('#requexpire_time_hr').val('03');
					$("#ddlViewrequestexpire").val(1);
				}
				else if(endtimeval == '4'){
					$('#requexpire_time_hr').val('04');
					$("#ddlViewrequestexpire").val(1);
				}
				else if(endtimeval == '5'){
					$('#requexpire_time_hr').val('05');
					$("#ddlViewrequestexpire").val(1);
				}
				else if(endtimeval == '6'){
					$('#requexpire_time_hr').val('06');
					$("#ddlViewrequestexpire").val(1);
				}
				else if(endtimeval == '7'){
					$('#requexpire_time_hr').val('07');
					$("#ddlViewrequestexpire").val(1);
				}
				else if(endtimeval == '8'){
					$('#requexpire_time_hr').val('08');
					$("#ddlViewrequestexpire").val(1);
				}
				else if(endtimeval == '9'){
					$('#requexpire_time_hr').val('09');
					$("#ddlViewrequestexpire").val(1);
				}
				else if(endtimeval == '10'){
					$('#requexpire_time_hr').val('10');
					$("#ddlViewrequestexpire").val(1);
				}
				else if(endtimeval == '11'){
					$('#requexpire_time_hr').val('11');
					$("#ddlViewrequestexpire").val(1);
				}
				else if(endtimeval == '12'){
					$('#requexpire_time_hr').val('12');
					$("#ddlViewrequestexpire").val(2);
				}
				else if(endtimeval == '13')
				{
					$('#requexpire_time_hr').val('01');
					$("#ddlViewrequestexpire").val(2);
				}
				else if(endtimeval == '14')
				{
					$('#requexpire_time_hr').val('02');
					$("#ddlViewrequestexpire").val(2);
				}
				else if(endtimeval == '15')
				{
					$('#requexpire_time_hr').val('03');
					$("#ddlViewrequestexpire").val(2);
				}
				else if(endtimeval == '16')
				{
					$('#requexpire_time_hr').val('04');
					$("#ddlViewrequestexpire").val(2);
				}
				else if(endtimeval == '17')
				{
					$('#requexpire_time_hr').val('05');
					$("#ddlViewrequestexpire").val(2);
				}
				else if(endtimeval == '18')
				{
					$('#requexpire_time_hr').val('06');
					$("#ddlViewrequestexpire").val(2);
				}
				else if(endtimeval == '19')
				{
					$('#requexpire_time_hr').val('07');
					$("#ddlViewrequestexpire").val(2);
				}
				else if(endtimeval == '20')
				{
					$('#requexpire_time_hr').val('08');
					$("#ddlViewrequestexpire").val(2);
				}
				else if(endtimeval == '21')
				{
					$('#requexpire_time_hr').val('09');
					$("#ddlViewrequestexpire").val(2);
				}
				else if(endtimeval == '22')
				{
					$('#requexpire_time_hr').val('10');
					$("#ddlViewrequestexpire").val(2);
				}
				else if(endtimeval == '23')
				{
					$('#requexpire_time_hr').val('11');
					$("#ddlViewrequestexpire").val(2);
				}
		}


		// var endtimevalsecond = $('#end_time_hr').val();

		var reqexpiretimehr = $('#requexpire_time_hr').val();
		var getcurdttime = new Date(); //getting current date in javascript format
        var curentdate = moment(getcurdttime).format("DD/MM/YYYY"); //getting current date in  DD/MM/YYYY hh:mm a format
        var requestexpireddate = $("#requestexpireddate").val();

        var currenttimehr = moment(getcurdttime).format("HH"); 

		if(requestexpireddate == curentdate)
	        {
	      //   	console.log("reqexpiretimehr"+reqexpiretimehr+" currenttimehr "+currenttimehr);

	      //   	if(reqexpiretimehr < 12)
	      //   	{
	      //   		reqexpiretimehr  =parseInt(reqexpiretimehr)+12;
	      //   	}

	      //   	if(parseInt(reqexpiretimehr) >= parseInt(currenttimehr) && parseInt(reqexpiretimehr)<24)
	      //   	{
	        		
	      //   			$("#requexpire_time_hr").val(reqexpiretimehr);
	        		
	        		
	      //   	}else
	      //   	{
	        				
							// $("#requexpire_time_hr_error").css("display", "block");

							// setTimeout(function(){
							// $("#requexpire_time_hr_error").css("display", "none");
							// },1000)
	      //   		$("#requexpire_time_hr").val('');
	        		
	      //   	}

	        }else
	        {
	    //     	if(parseInt(reqexpiretimehr) >= 00 && parseInt(reqexpiretimehr)<24)
	    //     	{
	    //     		$("#requexpire_time_hr").val(reqexpiretimehr);
	        		
	    //     	}else
	    //     	{
					// $("#requexpire_time_hr_error").css("display", "block");

					// setTimeout(function(){
					// $("#requexpire_time_hr_error").css("display", "none");
					// },1000)
	    //     		$("#requexpire_time_hr").val('');
	        		
	    //     	}
	        }

		

});

//************* Hour on blur chcking ends here

//************* Format change option 

$('#ddlViewrequestexpire').on('change', function(e) {
  


							var requexpire_time_hr = $('#requexpire_time_hr').val();
							var bookingdatevalue = $("#booking_date").val(); ////****** booking date value



							var getcurdttime = new Date(); //getting current date in javascript format
							var curentdate = moment(getcurdttime).format("DD/MM/YYYY hh:mm a"); //getting current date in  DD/MM/YYYY hh:mm a format
							var subtractdate =  moment(curentdate,"DD/MM/YYYY h:mm a").add(4,"hours").format("DD/MM/YYYY"); //****date
							var subtracttimehr =  moment(curentdate,"DD/MM/YYYY h:mm a").add(4,"hours").format("HH"); //**** hour

							var formattypeval = $("#ddlViewrequestexpire").val();

							// if(bookingdatevalue == subtractdate)
					  //        	{	
					  //        		if(parseInt(subtracttimehr) > parseInt(starttimeval_hr))
						 //         		{
						 //         			$('#start_time_hr').val('');
						 //         			$('#start_time_mnt').val('');
						 //         		}
					  //        	}


					         	if(formattypeval == 2)
					         	{
					         		var substrval = requexpire_time_hr.substring(0,2);

					         		if(substrval == '00')
					         		{
											$("#requexpire_time_hr_error").css("display", "block");

											setTimeout(function(){
											$("#requexpire_time_hr_error").css("display", "none");
											},1000)
					         			    $('#requexpire_time_hr').val('');
						         			// $('#start_time_mnt').val('');
					         		}
					         	}



});