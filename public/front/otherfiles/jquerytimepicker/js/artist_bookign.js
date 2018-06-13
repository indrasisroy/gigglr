  

  $('#end_time').timepicker({

    timeFormat: 'h:mm p',
    interval: 05,
    dynamic: false,
    dropdown: true,
    scrollbar: true

    });  

      //**********************************************************************************************************************//


  $('#start_time').timepicker({

                    timeFormat: 'h:mm p',
                    interval: 05,
                    minTime: '12:00am',
                    maxTime: '11:59pm',
                    //defaultTime: '11',
                   // startTime: '10:00',
                    dynamic: false,
                    dropdown: true,
                    scrollbar: true,
                    change: function(time) {
                                  // the input field
                                  // var element = $(this), text;
                                  // get access to this Timepicker instance
                                 // var timepicker = element.timepicker();
                                //  text = 'Selected time is: ' + timepicker.format(time);
                                 // alert(text);
                                  $('#end_time').val('');
                                  $('#end_time').timepicker('option', 'minTime', time); 





                                  //**************for request expire date starts
                                  var booking_dateval = $("#booking_date").val();
                                  var starttimeval = $("#start_time").val();
                                  var bokingtimetobesubtract = booking_dateval+" "+starttimeval;
                                  var bookingdatetimesubtract = moment(bokingtimetobesubtract,"DD/MM/YYYY h:mm A").subtract(4,"hours").format("DD/MM/YYYY" );



                                  var getcurdttime = new Date(); //getting current date in javascript format
                                  var curentdate = moment(getcurdttime).format("DD/MM/YYYY");
                                  //**************for request expire date ends



                                 // var req_expiredate = 
                                 // $('#requestexpireddate').data("DateTimePicker").minDate(curentdate);

                               
                                  $('#requestexpireddate').data("DateTimePicker").date(null);
                                  $('#requestexpireddate').data("DateTimePicker").minDate(curentdate);
                                  $('#requestexpireddate').data("DateTimePicker").maxDate(bookingdatetimesubtract);

                        
                   }

              });

    //**********************************************************************************************************************//

       
                


    //**********************************************************************************************************************//


  $('#requestexpiredtime').timepicker({

                    timeFormat: 'h:mm p',
                    interval: 05,
                    // minTime: '12:00am',
                    // maxTime: '11:59pm',
                    //defaultTime: '11',
                   // startTime: '10:00',
                    dynamic: false,
                    dropdown: true,
                    scrollbar: true,

              });

//*************************************************************************************************************************************//    
  
                   var getcurdttime = new Date(); //getting current date in javascript format
                   var curentdate = moment(getcurdttime).format("DD/MM/YYYY"); // getting current date in moment format
                   var currentdateandtime = moment(getcurdttime).format("DD/MM/YYYY hh:mm A"); // getting current date time in moment format
                   var afterfourhourdate=moment(currentdateandtime,"DD/MM/YYYY hh:mm A").add(4,"hours").format("DD/MM/YYYY");//getting date after 4 hour
                   var afterfourhourtime=moment(currentdateandtime,"DD/MM/YYYY hh:mm A").add(4,"hours").format("h:mm a");//getting time after 4 hour
                   //alert('current date time moment is '+currentdateandtime+"after four hour date and time "+afterfourhourdate+" "+afterfourhourtime);

                    //$('#booking_date').data("DateTimePicker").minDate(afterfourhourdate);


                            $('#booking_date').datetimepicker({
                             format: 'DD/MM/YYYY',
                            // minDate:afterfourhourdate
                            });

              $("#booking_date").on("dp.change", function(e)
                {
                    
                 //  $('#requestexpireddate').data("DateTimePicker").maxDate('10/11/2016'); 
                 // $("#booking_date").val('');

                   var getcurdttime = new Date(); //getting current date in javascript format
                   var curentdate = moment(getcurdttime).format("DD/MM/YYYY"); // getting current date in moment format
                   var currentdateandtime = moment(getcurdttime).format("DD/MM/YYYY hh:mm A"); // getting current date time in moment format
                   var afterfourhourdate=moment(currentdateandtime,"DD/MM/YYYY hh:mm A").add(4,"hours").format("DD/MM/YYYY");//getting date after 4 hour
                   var afterfourhourtime=moment(currentdateandtime,"DD/MM/YYYY hh:mm A").add(4,"hours").format("h:mm a");//getting time after 4 hour
                   //alert('current date time moment is '+currentdateandtime+"after four hour date and time "+afterfourhourdate+" "+afterfourhourtime);

                   $('#booking_date').data("DateTimePicker").minDate(afterfourhourdate);
                   bookingdate_val = $("#booking_date").val();


                   //**********************

                   //alert(bookingdate_val);
                  // $('#requestexpireddate').data("DateTimePicker").maxDate(bookingdate_val);
                   $('#requestexpireddate').data("DateTimePicker").date(null);

                   //**********************




                   if(bookingdate_val == afterfourhourdate)
                   {
                      $('#start_time').val('');
                      $('#end_time').val(''); 
                      $('#requestexpireddate').val('');
                      $('#requestexpiredtime').val(''); 
                      $('#start_time').timepicker('option', 'minTime', afterfourhourtime); 


                    }else{
                      //console.log("else  12:00am");
                     $('#start_time').val('');
                     $('#end_time').val(''); 
                     $('#requestexpireddate').val('');
                     $('#requestexpiredtime').val(''); 
                     
                     //$('#start_time').timepicker();

                     $('#start_time').timepicker('option', 'minTime', '12:00am'); 

                    }
                });





    //*******************************************************************************************************************************//
              
              //*************For request expire date starts here  
               $("#requestexpireddate").on("dp.change", function(e)
                 {

                                
                          
                                //**************for request expire date starts
                                  var booking_dateval = $("#booking_date").val();
                                  var starttimeval = $("#start_time").val();
                                  var bokingtimetobesubtract = booking_dateval+" "+starttimeval;
                                  var bookingdatetimesubtract = moment(bokingtimetobesubtract,"DD/MM/YYYY h:mm A").subtract(4,"hours").format("DD/MM/YYYY" );
                                  var bookingtimesubtract = moment(bokingtimetobesubtract,"DD/MM/YYYY h:mm A").subtract(4,"hours").format("hh:mm a" );
                                  var requestexpiredateval = $("#requestexpireddate").val();


                                  //***********adding 5 minutes to curent time starts

                                  var getcurdttime = new Date(); //getting current date in javascript format
                                  var curentdatetime = moment(getcurdttime).format("DD/MM/YYYY h:mm a"); // getting current date in moment format
                                  var fiveminutes=moment(curentdatetime,"DD/MM/YYYY hh:mm A").add(0,"minutes").format("hh:mm a" );//getting date after 4 hour
                                  
                                  //***********adding  5 minutes to current time ends


                                 // alert("curentdatetime"+curentdatetime);

                                  var currentdate = moment().format('DD/MM/YYYY');
                                  var currenttime = moment().format('hh:mm a');

                                  // $('#requestexpireddate').data("DateTimePicker").minDate(currentdate); //********commented
                                  // $('#requestexpireddate').data("DateTimePicker").maxDate('08/11/2016'); //********commented
                                 
                                  if(bookingdatetimesubtract == requestexpiredateval)
                                  {
                                   
                                   $('#requestexpiredtime').timepicker('option', 'maxTime', bookingtimesubtract); 

                                  }else
                                  {
                                     $('#requestexpiredtime').timepicker('option', 'maxTime', '11:55pm');
                                  }
                                  if(currentdate == requestexpiredateval)
                                  {
                                  //alert("I am here");
                                    // $('#requestexpiredtime').timepicker('option', 'minTime', fiveminutes); 
                                    $('#requestexpiredtime').timepicker('option', 'minTime', fiveminutes); 

                                  }else
                                  {
                                     $('#requestexpiredtime').timepicker('option', 'minTime', '12:00am'); 
                                   
                                  }

                                  //**************for request expire date ends


                                  $("#requestexpiredtime").val('');




                 });
            
               
//*************For request expire date ends here  

                
                 


             

           