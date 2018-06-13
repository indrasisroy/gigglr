
   var security_lock_id_grp = '';
   var booking_lock_id_grp = '';
   var totalpay_lock_id_grp = '';
      $("#totalpayimg_div").on("click", (function () {
		 var valuetotalpayimg = $(this).data('totalpayimgflag');
		 if (valuetotalpayimg == '0') {
		   $('#totalpayimg_div').data('totalpayimgflag',1);
		   $("#totalpayimg_div").html(lockImg);
          totalpay_lock_id_grp = logID;
		 }else{
		   $('#totalpayimg_div').data('totalpayimgflag',0);
		   $("#totalpayimg_div").html(unlockImg);
           totalpay_lock_id_grp = '';
		 }
	  }));
   
      $("#bookingcanimg_div").on("click", (function () {
		 var valuebookingcanimg = $(this).data('bookingcanimgflag');
		 if (valuebookingcanimg == '0') {
		   $('#bookingcanimg_div').data('bookingcanimgflag',1);
		   $("#bookingcanimg_div").html(lockImg);
            booking_lock_id_grp = logID;
		 }else{
		   $('#bookingcanimg_div').data('bookingcanimgflag',0);
		   $("#bookingcanimg_div").html(unlockImg);
            booking_lock_id_grp = '';
		 }
	  }));
	  
      $("#securityimg_div").on("click", (function () {
		 var valuesecurityimg = $(this).data('securityimgflag');
		 if (valuesecurityimg == '0') {
		   $('#securityimg_div').data('securityimgflag',1);
		   $("#securityimg_div").html(lockImg);
            security_lock_id_grp = logID;
		 }else{
		   $('#securityimg_div').data('securityimgflag',0);
		   $("#securityimg_div").html(unlockImg);
            security_lock_id_grp = '';
            //security_lock_id:security_lock_id_grp,booking_lock_id:booking_lock_id_grp,totalpay_lock_id:totalpay_lock_id_grp
		 }
	  }));
      
      
         $( "#country" ).change(function() {
          var selected_value = $(this).val();
            city_drop(selected_value);
          });
         
          function city_drop(selected_value) {
            var myaccount_city_url=base_url_data+"/countrystate";
            var myaccount_city_data={_token:csrf_token_data,'countryid':selected_value};
             $.ajax({
               
               url:myaccount_city_url,
               type:'POST',
               dataType:'json',
               data:myaccount_city_data,
               success:function(d){
                         
                                        var select_state_html="";
                                        // select_state_html+="<option value=''>Select state</option>";
                                        if (d!=null)
                                        {
                                            $.each(d, function(idx, obj)
                                                   {
                                                 
                                                  select_state_html+="<option value='"+obj.state_id+"'>"+obj.state_3_code+"</option>";
                                                  
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
                              //alert("Dhiman "+totalpay_lock_id_grp);
                              $('#myModal5').animate({ scrollTop: 0 }, 'slow');
                              var showtext = 'Checking Your Request';
                              var imfpth=base_url_data+"/public/front/otherfiles/progimages/loder.gif"
                              showmycustomloader(1,'2000','1000',"",imfpth);
                              
                              
                              $.validator.addMethod("charactertype", function(value, element) 
                                     {
                                          // return this.optional(element) || /^[a-z]+$/i.test(value);
                                            return this.optional(element) || /^([a-zA-Z]+\s)*[a-zA-Z]+$/.test(value);
                                     },"Please enter valid city name");
                                
                                //*******************CUSTOM VALIDATION FOR ZIP CODE
                                
                                $.validator.addMethod("numericfield", function(value, element) 
                                     {
                                         //var characterReg = /^[0-9]{7}(?:-[0-9]{4})?$/;
                                         var characterReg = /[0-9]+/;
                                         return characterReg.test(value);
                                     },"Please enter valid booking post code");
                                
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

                                 $.validator.addMethod("blnkchecklocation", function(value, element) 
                                     {
                                          // return this.optional(element) || /^[a-z]+$/i.test(value);  /^([a-zA-Z]+\s)*[a-zA-Z]+$/.test(value);
                                           return this.optional(element) || (/\S/.test(value));
                                      },"Please enter valid location");

                                  $.validator.addMethod("blnkchecklocationzip", function(value, element) 
                                     {
                                          // return this.optional(element) || /^[a-z]+$/i.test(value);  /^([a-zA-Z]+\s)*[a-zA-Z]+$/.test(value);
                                           return this.optional(element) || (/\S/.test(value));
                                      },"Please enter valid post code");
                                

                                  $.validator.addMethod("numericfieldamount", function(value, element) 
                                  {
                                  var characterReg = /^([0-9]*){0,}(\.\d{1,2})?$/; ///^[1-9][0-9]+(\.\d{1,2})?$/ ;
                                  return characterReg.test(value);
                                  },"Please enter proper numeric value");
                              //******************** CUSTOM FUNCTION ***************ENDS********************
                                
                              //**********************FORM VALIDATION STARTS HERE ***************************
                              
                                   $("#bookingform").validate({
                                        errorClass: "authError",
                                        errorElement: 'span',//'div',
                                        //***********************VALIDATION RULES*****************STARTS****************
                                             rules: {
                                                       address1: {
                                                            required: true,
                                                            minlength: 2,
                                                            blnkchecklocation: true,
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
                                                            blnkchecklocationzip: true,
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
                                                            numericfieldamount: true,
                                                        },
                                                        
                                                         total_payment:{
                                                            required: true,
                                                            maxlength: 20,
                                                            numericfieldamount: true,
                                                            checkingamounttotal:true,
                                                       },
                                                         cancellation_payment:{
                                                            required: true,
                                                            maxlength: 20,
                                                            numericfieldamount: true,
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
                                                           required: "Please enter booking post code",
                                                           
                                                       },
                                                       bookingcat_sub: {
                                                           required: "Please select a category",
                                                           range:"Plaese select a valid option",
                                                       },
                                                       bookinggenre_sub: {
                                                           required: "Please select a genre",
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
                                   var address1val = $("#address1").val().trim();
                                   var address2val = $("#address2").val().trim();
                                   var countrydata = $("#country").val();
                                   var statelistdata = $("#select_state").val();
                                   var towndata = $("#city").val().trim();
                                   var zipdata = $("#zip").val().trim();
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
                                    var bookingformdata = {_token:csrf,type_entry:type_entry_insert,creater_id:creater_id,artist_id:groupId,type_flag:gig_type,address1val:address1val,address2val:address2val,countrydata:countrydata,statelistdata:statelistdata,towndata:towndata,zipdata:zipdata,bookingcat_subdata:bookingcat_subdata,bookinggenre_subdata:bookinggenre_subdata,security_paymentdata:security_paymentdata,total_paymentdata:total_paymentdata,cancellation_paymentdata:cancellation_paymentdata,booking_datedata:booking_datedata,start_timedata:start_timedata,end_timedata:end_timedata,requestexpireddatedata:requestexpireddatedata,requestexpiredtimedata:requestexpiredtimedata,security_lock_id:security_lock_id_grp,booking_lock_id:booking_lock_id_grp,totalpay_lock_id:totalpay_lock_id_grp};
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
                                   showmycustomloader(1,'4000','2000',"",imfpth);
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
                                                  skiloptstr+="<option >No Genre is available</option>";
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


                               // var strdt = moment().format('DD/MM/YYYY');
                                  $('#requestexpireddate').datetimepicker({
                                        format: 'DD/MM/YYYY',
                                     
                                  });

                                var  mndate = moment().format("DD/MM/YYYY");
                                $("#requestexpireddate").data("DateTimePicker").minDate(mndate);
                              //  alert(mndate);

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


                                                      $('#booking_date').data("DateTimePicker").minDate(getcurdttimemomadd); //setting as min date

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
                                                      //  $('#booking_date').data("DateTimePicker").minDate(fourhr); //setting as max date
                                                      }else
                                                      {
                                                         
                                                      }



                                      // var crntmoment = moment().format("DD/MM/YYYY");
                                      // $("#requestexpiredtime").data("DateTimePicker").maxDate(crntmoment);                            


				});
				
			//****************Booking date change function ends here	
				
				
				
			




				//*************start date chage function starts here
					 
          $("#start_time").on("dp.change", function(e)
          {

                                                        $('#end_time').val('').datetimepicker('update');
                                                        $('#end_time').data("DateTimePicker").date(null);
                                                        $("#end_time").datetimepicker({
                                                        format:'LT',

                                                        });

                                                        $('#requestexpireddate').val('').datetimepicker('update');
                                                        $('#requestexpireddate').data("DateTimePicker").date(null);
                                                        $("#requestexpireddate").datetimepicker({
                                                        format:'DD/MM/YYYY',

                                                        });
                                                         
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
                                                        // moment()



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
								
								 //$('#requestexpiredtime').data("DateTimePicker").maxDate(prevstime5hrsback);
							
								 
								 
								 
								 
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
                      