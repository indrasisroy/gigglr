$('#requestexpireddate').datetimepicker({
                                                format: 'DD/MM/YYYY',

                                                });
                                                 $('#booking_date').datetimepicker({
                                                format: 'DD/MM/YYYY',

                                                });
                                                  var  mndate = moment().format("DD/MM/YYYY");
                                                $("#requestexpireddate").data("DateTimePicker").minDate(mndate);

                                                //*********** This section is added on 22-07-2016 evening last moment before getting out starts here

                                                $("document").ready(function()
                                                {


                                                var getcurdttime_first = new Date();
                                                var getcurdttimemo_firstm = moment(getcurdttime_first).format("DD/MM/YYYY hh:mm A");
                                                var getcurdttimemomadd_first=moment(getcurdttimemo_firstm,"DD/MM/YYYY hh:mm A").add(4,"hours").format("DD/MM/YYYY");
                                                var getcurdttimemomaddtime_ftrst=moment(getcurdttimemo_firstm,"DD/MM/YYYY hh:mm A").add(4,"hours").format("h:mm A");
                                               $("#booking_date").data("DateTimePicker").minDate(getcurdttimemomadd_first);
                                                });

                                                //*********** This section is added on 22-07-2016 evening last moment before getting out ends here


      $("#booking_date").on("dp.change", function(e)
          {


                                              $('#booking_date').datetimepicker({
                                                 format: 'DD/MM/YYYY',

                                                });




                                                      $('#start_time').val('');
                                                      $('#start_time').val('').datetimepicker('update');
                                                      $("#start_time").datetimepicker({
                                                      format:'LT',
                                                      });

                                                     // $('#requestexpireddate').val('');
                                                      $('#requestexpireddate').val('').datetimepicker('update');
                                                      $("#requestexpireddate").datetimepicker({
                                                      format:'DD/MM/YYYY',
                                                      //Default:false
                                                      });

                                                      //***********get curent time  plus 4 hours*********starts*** 
                                                      var getcurdttime = new Date();
                                                      var getcurdttimemom = moment(getcurdttime).format("DD/MM/YYYY hh:mm A");
                                                      var getcurdttimemomadd=moment(getcurdttimemom,"DD/MM/YYYY hh:mm A").add(4,"hours").format("DD/MM/YYYY" );
                                                      var getcurdttimemomaddtime=moment(getcurdttimemom,"DD/MM/YYYY hh:mm A").add(4,"hours").format("h:mm A" );

                                                      var curplusfour = getcurdttimemomadd + "======="+getcurdttimemomaddtime;
                                                      // console.log("current time plus four "+curplusfour);
                                                      //***********get curent time  plus 4 hours*********ends***


                                                     // $('#booking_date').data("DateTimePicker").minDate(getcurdttimemomadd); //setting as min date commented on 12-10-2016

                                                      var startdt=$("#booking_date").val();
                                                      var strtmomnty =  moment(startdt,"DD-MM-YYYY").format("DD/MM/YYYY");
                                                      // console.log("strtmomnty"+strtmomnty);
                                                      if(getcurdttimemomadd == strtmomnty) //if booking date is 4 hours away date
                                                      {
                                                      //   console.log("same date");
                                                      $('#start_time').val('').datetimepicker('update');
                                                      $('#start_time').data("DateTimePicker").date(getcurdttimemomaddtime);
                                                      $("#start_time").datetimepicker({
                                                      format:'LT',
                                                      });
                                                      }
                                                      else
                                                      {
                                                      $('#start_time').data("DateTimePicker").date("12:00 AM");
                                                      }


                                                      //************special case
                                                      var stdt = $('#start_time').val();
                                                      if(stdt!='')
                                                      {
                                                        var bddt = $('#booking_date').val();
                                                        totl_tdt = bddt+' '+stdt;
                                                        fourhr = moment(totl_tdt,"DD/MM/YYYY hh:mm A").subtract(4,"hours").format("DD/MM/YYYY");
                                                       // $('#requestexpireddate').data("DateTimePicker").minDate(fourhr); //setting as max date
                                                      }else
                                                      {
                                                         
                                                      }



                                      // var crntmoment = moment().format("DD/MM/YYYY");
                                      // $("#requestexpiredtime").data("DateTimePicker").maxDate(crntmoment);   
                                       $('#requestexpireddate').prop("disabled", false);  
                                       $('#requestexpiredtime').prop("disabled", false);                           


        });
        
        
        //*************start date chage function starts here
           


  $("#start_time").on("dp.change", function(e)
          {

                        //$('#end_time').val('').datetimepicker('update');
                        // $('#end_time').data("DateTimePicker").date(null);
                        $("#end_time").datetimepicker({
                        format:'LT',
                        });

                        $('#end_time').val('').datetimepicker('update');
                        $("#end_time").data("DateTimePicker").date(null);

                        $('#requestexpireddate').val('').datetimepicker('update');
                        $('#requestexpireddate').data("DateTimePicker").date(null);
                        // $("#requestexpireddate").datetimepicker({
                        // format:'DD/MM/YYYY',

                        // });
                         
                        //***********get curent time  plus 4 hours*********starts*** 
                        var getcurdttime = new Date();
                        var getcurdttimemom = moment(getcurdttime).format("DD/MM/YYYY hh:mm A");
                        var getcurdttimemomadd=moment(getcurdttimemom,"DD/MM/YYYY hh:mm A").add(4,"hours").format("DD/MM/YYYY");
                        var getcurdttimemomaddtime=moment(getcurdttimemom,"DD/MM/YYYY hh:mm A").add(4,"hours").format("h:mm A");

                        var strtimvalue = $("#start_time").val();
                        strtimvalue_moment = moment(strtimvalue,"h:mm A");
                        //console.log("strtimvalue_moment present*****************"+strtimvalue_moment);

                        var getcurdttimemomaddtimemom = moment(getcurdttimemomaddtime,"h:mm A");
                        //console.log("getcurdttimemomaddtimemom*******************"+getcurdttimemomaddtimemom);

                        var bookingdateval = $("#booking_date").val();
                        if(getcurdttimemomadd == bookingdateval)
                        {
                        // console.log("we are in same date");
                          if(strtimvalue_moment < getcurdttimemomaddtimemom)
                          {
                          $("#start_time").data("DateTimePicker").date(getcurdttimemomaddtime);
                          }
                        }
                        $('#requestexpireddate_gig').val('').datetimepicker('update');

                        $("#requestexpireddate").datetimepicker({
                        format:'DD/MM/YYYY',
                        //Default:false
                        });



                        //**********setting of four hours date
                        $bkdate_val = $("#booking_date").val();
                        $bk_time_val = $("#start_time").val();
                        $bk_datetime = $bkdate_val+' '+$bk_time_val;
                        bk_datetime_moment = moment($bk_datetime,"DD/MM/YYYY hh:mm A").subtract(4,"hours").format("DD/MM/YYYY");

                       // $("#requestexpireddate").data("DateTimePicker").maxDate(bk_datetime_moment); this section is commented on 04-08-2016
                      //  moment()



          }); 


          

            $("#requestexpiredtime").on("dp.change", function(e)
          {


                                                  var crntdate = moment().format('DD/MM/YYYY');
                                                  var crnttime = moment().format('hh:mm A');

                                                  var end_time = $('#requestexpiredtime').val();
                                                  var r =  moment(end_time,"hh:mm A");


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
                                                  var strt_time_bk = $('#start_time').val();
                                                  //  //console.log("strt_time_gig"+strt_time_gig);

                                                  var ttmoment = bookingreqdate+' '+strt_time_bk;

                                                  // console.log("ttmoment"+ttmoment);

                                                  var fourhrmoment_before_date = moment(ttmoment,"DD/MM/YYYY hh:mm A").subtract(4,'hours').format("DD/MM/YYYY");
                                                  var fourhrmoment_before_time = moment(ttmoment,"DD/MM/YYYY hh:mm A").subtract(4,'hours').format("hh:mm A");

                                                  //  console.log("fourhrmoment_before_date"+fourhrmoment_before_date+"fourhrmoment_before_time"+fourhrmoment_before_time);
                                                  fourhour_span = moment(fourhrmoment_before_time,"hh:mm A");

                                                  if(fourhrmoment_before_date == strttime)
                                                  {
                                                
                                                    if(r > fourhour_span)
                                                    {
                                                    // console.log("in this section");
                                                    $("#requestexpiredtime").data("DateTimePicker").date(fourhrmoment_before_time);
                                                    }
                                                 
                                                  }




                                                 



          });
                
                 

                  $("#end_time").on("dp.change", function (e)
        {
                                                        var crntdate = moment().format('DD/MM/YYYY');
                                                        var crnttime = moment().format('hh:mm A');

                                                        var end_time_booking = $('#end_time').val();
                                                        var r =  moment(end_time_booking,"hh:mm A");


                                                        var l = moment(crnttime,"hh:mm A");

                                                        var strttime = $("#booking_date").val();


                                                        if(strttime == crntdate)
                                                        {
                                                        // console.log('hurray!!!!!!!!!!');
                                                        if(r < l)
                                                        {
                                                        //  console.log('ererre!!!!!!!!!!');
                                                        $("#end_time").data("DateTimePicker").date(crnttime);
                                                        }
                                                        }


                                                        var strt_time_booking = $('#start_time').val();
                                                        var p =  moment(strt_time_booking,"hh:mm A");

                                                        if(r < p )
                                                        {

                                                        $("#end_time").data("DateTimePicker").date(strt_time_booking);
                                                        }


        })
                 
              
                 $("#requestexpireddate").on("dp.change", function(e)
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
                                                         var strtdtaetime_date = moment(strtdtaetime,"DD/MM/YYYY hh:mm A").subtract(4,'hours').format("DD/MM/YYYY");

                                                         $("#requestexpireddate").data("DateTimePicker").maxDate(strtdtaetime_date);
                                                         $('#requestexpiredtime').datetimepicker({
                                                         format:'LT',
                                                         });


                                                         $('#requestexpiredtime').val('').datetimepicker('update');
                                                         $('#requestexpiredtime').data("DateTimePicker").date(null);
                                                         $("#requestexpiredtime").datetimepicker({
                                                         format:'LT'
                                                         });





                 });
                 
                
               //**************calender js ends here************************//////////////////////////************
                      
                      