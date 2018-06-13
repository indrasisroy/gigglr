
                         //********************FORM SUBMIT VALIDATION************
                              
                              function callforbooking(posturl,csrf)
                              {
          
                              $('#myModal5').animate({ scrollTop: 0 }, 'slow');
                              //showloderstarts(forfnctn = 'booking',delytime = '2500');
                              delaytime = 500,chk=1;
                              fadeouttime = 2000;
                              var showtext = 'Checking Your Request';
                              //bgimg = 'http://prosessionalbeta.in/front/otherfiles/progimages/bookingloder.gif';
                              //shwloder(chk,delaytime,fadeouttime,showtext,bgimg);
                                var imfpth=base_url_data+"/public/front/otherfiles/progimages/loder.gif"
                              showmycustomloader(1,'2000','1000',"Please wait . Its loading ...",imfpth);
                              
                              
                              $.validator.addMethod("charactertype", function(value, element) 
                                     {
                                          return this.optional(element) || /^[a-z]+$/i.test(value);
                                     },"Please enter valid city name");
                                
                                //*******************CUSTOM VALIDATION FOR ZIP CODE
                                
                                $.validator.addMethod("numericfield", function(value, element) 
                                     {
                                         var characterReg = /^[0-9]{5}(?:-[0-9]{4})?$/;
                                         return characterReg.test(value);
                                     },"Please enter valid booking zip code");
                                
                                //***********************custom validation for total payment
                                $.validator.addMethod("checkingamount",function(value,element)
                                {
                                  var securitymony = $("#security_payment").val().replace("$", "").replace(/,/g, "");
                                  var cancellation = $("#cancellation_payment").val().replace("$", "").replace(/,/g, "");
                                  var totalpayment = $("#total_payment").val().replace("$", "").replace(/,/g, "");
                                  
                                  var ff2 =parseFloat(totalpayment)-(parseFloat(cancellation)+parseFloat(securitymony));
                                 // ff2.toFixed(2);
                                 var f = parseFloat(ff2).toFixed(2);
                               //  console.log("Diference is=============="+f);
                                  
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
                                
                                //******************** CUSTOM FUNCTION ***************ENDS********************
                                
                              //**********************FORM VALIDATION STARTS HERE ***************************
                              
                                   $("#bookingform").validate({
                                        errorClass: "authError",
                                        errorElement: 'div',
                                        //***********************VALIDATION RULES*****************STARTS****************
                                             rules: {
                                                       booking_location: {
                                                            required: true,
                                                            minlength: 2,
                                                       },
                                                        countryId: {
                                                            required: true,
                                                       },
                                                       statelist: {
                                                            required: true,
                                                       },
                                                        town: {
                                                            required: true,
                                                            charactertype:true,
                                                       },
                                                        zip: {
                                                            required: true,
                                                            numericfield : true,
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
                                                        },
                                                        
                                                         total_payment:{
                                                            required: true,
                                                            maxlength: 20,
                                                            checkingamounttotal:true
                                                       },
                                                         cancellation_payment:{
                                                            required: true,
                                                            maxlength: 20,
                                                            checkingamount :true,
                                                       },
                                                         requestexpireddate:{
                                                            required: true,
                                                       },
                                                         requestexpiredtime:{
                                                            required: true,
                                                       },
                                                  },
                                                  //*****************VALIDATION RULES*****************************ENDS***********
                                                  
                                                  //*****************VALIDATION ERROR MESSAGES *******************STARTS*********
                                          messages: {
                                                          
                                                       booking_location: {
                                                           required: "Booking location can not be empty",
                                                           minlength: "Please enter a valid location"
                                                       },
                                                       countryId: {
                                                           required: "Please select a country",
                                                           
                                                       },
                                                        statelist: {
                                                           required: "Please select a state",
                                                           
                                                       },
                                                        town: {
                                                           required: "Please enter city name",
                                                           
                                                       },
                                                        zip: {
                                                           required: "Please enter booking zip code",
                                                           
                                                       },
                                                       bookingcat_sub: {
                                                           required: "Please select a category",
                                                           range:"Plaese select a valid option",
                                                       },
                                                       bookinggenre_sub: {
                                                           required: "Please select a genere",
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
                                                       
                                                       requestexpireddate: {
                                                       required: "Please select expire date",
                                                       },
                                                           requestexpiredtime: {
                                                           required: "Please select expire time",
                                                       },
                                                  },
                                                  
                                                  
                                                  
                                                  //*****************VALIDATION ERROR MESSAGES *******************ENDS*********
                
                                        });
                                        //************************CHECKING VALIDATION CONDITION**********************STARTS*********
                              
     
                              var chkbookingvalidation =  $("#bookingform").valid();
                              //alert(chkbookingvalidation);
                              //console.log(chkbookingvalidation);
                              if(chkbookingvalidation == true)
                              {
                                   //var total_payment2 = $("#total_payment").val();
                                   //console.log("Total payment is============> "+total_payment2);
                                   
                                   
                                   $("#cancelbtn").click(); //***modal remove
                                   $("#divLoading").removeClass("shwloder");
                                  // showmycustomloader(0,'','',"Please wait . Its loading ...",imfpth);
                                   
                                  
                                   chk = 1;
                                   delaytime = 25000;
                                   showtext='Processing your request';
                                   fadeouttime = 200;
                                   //bgimg = 'http://prosessionalbeta.in/front/otherfiles/progimages/bookingloder.gif';
                                   //bgimg = 'http://prosessionalbeta.in/front/otherfiles/progimages/bookingloder.gif';
                                    // shwloder(chk,delaytime,fadeouttime,showtext,bgimg);
                                    var imfpth=base_url_data+"/public/front/otherfiles/progimages/loder.gif"
                                    showmycustomloader(1,'2000','1000',"Please wait . Its loading ...",imfpth);
                                   // showmycustomloader(0,'','',"Please wait . Its loading ...",imfpth);
                                    
                                   var success_message_data="Thank you for your booking request! ";
                                   poptriggerfunc(msgtype='success',titledata='',msgdata=success_message_data,sd=5000,hd=1500,tmo=3000,etmo=4000,poscls='toast-bottom-right');
                                                     //****************************LOADER ENDS HERE****************************************
                                 
                                 //return 2;
                              }
                              else
                              {
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
                         var categorydata = {_token:csrf,categoryID:Catagory_Id};
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
                                                  skiloptstr+="<option >No Genere is available</option>";
                                             }
                                                         //alert(skiloptstr);
                                                       jQuery("#bookinggenre_sub").html(skiloptstr);
                                                       $("#bookinggenre_sub").selectpicker('refresh');
                                        }
                         });
                         
               }
                              //*******************FOR CATEGORY GENERE AJAX ENDS****************************
                              
                              
                      