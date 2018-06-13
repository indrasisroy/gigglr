
  $("#booking_date").on("dp.change", function(e)
                {

                	 var bookingdate = $("#booking_date").val();	
                	 $("#start_time_hr").val('');
                	 $("#start_time_mnt").val(''); 
                	 $("#ddlViewBy").val('');
                });


$('#start_time_hr').change(function(key){

				
	         	var getcurdttime = new Date(); //getting current date in javascript format
                var curentdate = moment(getcurdttime).format("DD/MM/YYYY hh:mm a");

                var subtractdate =  moment(curentdate,"DD/MM/YYYY h:mm a").add(4,"hours").format("DD/MM/YYYY");
                var subtracttimehr =  moment(curentdate,"DD/MM/YYYY h:mm a").add(4,"hours").format("HH");
                var subtracttimemn =  moment(curentdate,"DD/MM/YYYY h:mm a").add(4,"hours").format("mm");

                //console.log("curentdate "+curentdate+" subtractdate "+subtractdate+" subtracttimehr "+subtracttimehr+" subtracttimemn "+subtracttimemn);

	         	
	         	var starttime_hrval = $("#start_time_hr").val();

	         	var bookingdatevalue = $("#booking_date").val();


	         	var starttime_hrvallength = starttime_hrval.toString().length;

	         	if(starttime_hrvallength > 2)
	         	{
	         		$("#start_time_hr").val('');
	         	}
	         	else
	         	{

	         	
					         	if(bookingdatevalue == subtractdate)
					         	{	
					         			if(parseInt(subtracttimehr) > parseInt(starttime_hrval))
						         		{

						         				$("#start_time_hr").val('');



						         		}else 
						         		{
							         		if(starttime_hrval >= 00 && starttime_hrval <= 23)
								         	{
								         		$("#start_time_hr").val(starttime_hrval);
								         		
								         	}else
								         	{
								         		$("#start_time_hr").val('');
								         	}
						         		}

					         			
					         	}else
					         	{
					         		if(starttime_hrval >= 00 && starttime_hrval <= 23)
							         	{
							         		$("#start_time_hr").val(starttime_hrval);
							         		
							         	}else
							         	{
							         		$("#start_time_hr").val('');
							         	}
					         	}
	            }


				$("#start_time_mnt").val(''); // cleaning minute data
			    
					
});

//************** For minutes checking starts here

$('#start_time_mnt').change(function(key){
				
	         	var getcurdttime = new Date(); //getting current date in javascript format
                var curentdate = moment(getcurdttime).format("DD/MM/YYYY hh:mm a");

                var subtractdate =  moment(curentdate,"DD/MM/YYYY h:mm a").add(4,"hours").format("DD/MM/YYYY");
                var subtracttimehr =  moment(curentdate,"DD/MM/YYYY h:mm a").add(4,"hours").format("HH");
                var subtracttimemn =  moment(curentdate,"DD/MM/YYYY h:mm a").add(4,"hours").format("mm");

                console.log("curentdate "+curentdate+" subtractdate "+subtractdate+" subtracttimehr "+subtracttimehr+" subtracttimemn "+subtracttimemn);

	         	
	         	var starttime_mnval =  $("#start_time_mnt").val(); // start time minute value
	         	
	         	var bookingdatevalue = $("#booking_date").val(); // booking date value

	         	var starttimehrval =   $("#start_time_hr").val(); // start time value

	         	var starttime_mnvallength = starttime_mnval.toString().length;


	         	var ampmvalue =$("#ddlViewBy").val();

	         	if(starttime_mnvallength > 2)
	         	{
	         		$("#start_time_mnt").val('');
	         	}
	         	else
	         	{
	         	
					         	if(bookingdatevalue == subtractdate)
					         	{
					         		console.log("We are in same date"+starttimehrval);
					         		if(starttimehrval <= 11 && ampmvalue == 2)
					         		{
					         			starttimehrval = parseInt(starttimehrval)+12
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
							         	}
					         		}else if(starttimehrval == subtracttimehr)
					         		{
					         				if(starttime_mnval >= subtracttimemn && starttime_mnval <= 59)
							         	{
							         		$("#start_time_mnt").val(starttime_mnval);
							         		
							         	}else
							         	{
							         		$("#start_time_mnt").val('');
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
							         	}
					         	}
	            }

			    
					
});

//************** For minutes checking ends here


//************* Hour on blur checking starts here

$('#start_time_hr').blur(function(key){


	var starttimeval = $('#start_time_hr').val();

	//starttimeval  = starttimeval;

	if(starttimeval!="")
	{
				if(starttimeval == '0')
				{
					$('#start_time_hr').val('00');
					$("#ddlViewBy").val(1);
				}
				else if(starttimeval == '1'){
					$('#start_time_hr').val('01');
					$("#ddlViewBy").val(1);
				}
				else if(starttimeval == '2'){
					$('#start_time_hr').val('02');
					$("#ddlViewBy").val(1);
				}
				else if(starttimeval == '3'){
					$('#start_time_hr').val('03');
					$("#ddlViewBy").val(1);
				}
				else if(starttimeval == '4'){
					$('#start_time_hr').val('04');
					$("#ddlViewBy").val(1);
				}
				else if(starttimeval == '5'){
					$('#start_time_hr').val('05');
					$("#ddlViewBy").val(1);
				}
				else if(starttimeval == '6'){
					$('#start_time_hr').val('06');
					$("#ddlViewBy").val(1);
				}
				else if(starttimeval == '7'){
					$('#start_time_hr').val('07');
					$("#ddlViewBy").val(1);
				}
				else if(starttimeval == '8'){
					$('#start_time_hr').val('08');
					$("#ddlViewBy").val(1);
				}
				else if(starttimeval == '9'){
					$('#start_time_hr').val('09');
					$("#ddlViewBy").val(1);
				}
				else if(starttimeval == '10'){
					$('#start_time_hr').val('10');
					$("#ddlViewBy").val(1);
				}
				else if(starttimeval == '11'){
					$('#start_time_hr').val('11');
					$("#ddlViewBy").val(1);
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
					$('#start_time_hr').val('02');
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

});

//************* Hour on blur chcking ends here