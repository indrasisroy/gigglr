






function callforbooking(posturl)
{
     
//     $("#bookingform").validate({
//       
//			rules: {
//				
//				booking_location: {
//					required: true,
//					//minlength: 2,
//                    
//				},
//				bookingcat_sub: {
//					required: true,
//					//minlength: 6
//                  //  range: [1, 2]
//
//				},
//				bookinggenre_sub: {
//					required: true,
//                   // range: [2,3,4]
//					//minlength: 6,
//					//equalTo: "#password"
//				},
//				booking_date: {
//					required: true,
//					//email: true
//				},
//               start_time:{
//					required: true,
//					//email: true
//				},
//                end_time:{
//					required: true,
//					//email: true
//				},
//                 total_payment:{
//					required: true,
//					//email: true
//				},
//                 requestexpireddate:{
//					required: true,
//					//email: true
//				},
//                 requestexpiredtime:{
//					required: true,
//					//email: true
//				},
//                
//                
//				//termscond: {
//				//	required: true,
//				//                
//				//	
//				//},
//				
//			},
//			messages: {
//							
//				booking_location: {
//					required: "Please enter a location",
//					minlength: "Name must consist of at least 2 characters"
//				},
//				bookingcat_sub: {
//					required: "Please select a category",
//					//minlength: "Your password must be at least 6 characters long"
//                    range:"Plaese select a valid option",
//				},
//                bookinggenre_sub: {
//					required: "Please select a genre",
//                    range:"Plaese select a valid option",
//					//minlength: "Your password must be at least 6 characters long"
//				},
//               booking_date: {
//					required: "Please select a booking date",
//					//minlength: "Your password must be at least 6 characters long"
//				},
//                start_time: {
//					required: "Please select a start time",
//					//minlength: "Your password must be at least 6 characters long"
//				},
//                end_time: {
//					required: "Please select a end time",
//					//minlength: "Your password must be at least 6 characters long"
//				},
//                 total_payment: {
//					required: "Please enter an amount",
//					//minlength: "Your password must be at least 6 characters long"
//				},
//                    requestexpireddate: {
//					required: "Please select expire date",
//					//minlength: "Your password must be at least 6 characters long"
//				},
//                    requestexpiredtime: {
//					required: "Please select expire time",
//					//minlength: "Your password must be at least 6 characters long"
//				},
//                
//				//password_confirmation: {
//				//	required: "Please provide a password",
//				//	minlength: "Your password must be at least 6 characters long",
//				//	equalTo: "Please enter the same password as above"
//				//},
//				//email: "Please enter a valid email address",
//				//termscond: "Please accept our terms and conditions",
//				
//			}
//            
//            
//            
//		});
     
     
    
       //var chkbookingvalidation=  $("#bookingform").valid();
       //
       //if (chkbookingvalidation)
       //{
       //             // var dob=jQuery("#dob").val();
       //             //var first_name=jQuery("#first_name").val();
       //             //var email=jQuery("#email").val();
       //             //var password=jQuery("#password").val();
       //             //var password_confirmation=jQuery("#password_confirmation").val();
       //             //var gender=jQuery("#gender").val();
       //             //
       //             //
       //             
       //             // var checkterms=jQuery("#termscond").prop('checked');
       //             //
       //             //if (checkterms)
       //             //{
       //             //
       //             // //**** ajax code starts
       //             //
       //             //    //var postdata = {_token:tokendata,dob:dob,first_name:first_name,email:email,password:password,password_confirmation:password_confirmation,gender:gender}; 
       //             //    //var urldata=base_url_data+"/"+posturl;
       //             //    //jQuery.ajax({
       //             //    //    
       //             //    //    data:postdata,
       //             //    //    dataType:'JSON',
       //             //    //    url:urldata,
       //             //    //    type:'POST',
       //             //    //    success:function(d){
       //             //    //        
       //             //    //       
       //             //    //       
       //             //    //       if (d.flag_id==0)
       //             //    //       {
       //             //    //       
       //             //    //                            var error_message=d.error_message;
       //             //    //                           
       //             //    //                            var error_message_data='';
       //             //    //                            
       //             //    //                            if (error_message!=null)
       //             //    //                            {
       //             //    //                                        for (ermsgkey in error_message)
       //             //    //                                     {
       //             //    //                                          error_message_data+="<p>"+ error_message[ermsgkey]+"</p>";
       //             //    //                                     }
       //             //    //                            }
       //             //    //              poptriggerfunc(msgtype='error',titledata='',msgdata=error_message_data,sd=1000,hd=1500,tmo=null,etmo=null,poscls='toast-bottom-right');         
       //             //    //        
       //             //    //       }
       //             //    //       else
       //             //    //       {
       //             //    //              poptriggerfunc(msgtype='success',titledata='',msgdata="Registration done successfully",sd=1000,hd=1500,tmo=1000,etmo=1000,poscls='toast-bottom-center');
       //             //    //       }
       //             //    //
       //             //    //       
       //             //    //        
       //             //    //       
       //             //    //    }
       //             //    //    
       //             //    //    
       //             //    //    });
       //             //    //
       //             ////**** ajax code ends
       //             //}
       //             //else
       //             //{
       //             //  var error_message_data=" You haven't agreed to terms and conditions! ";
       //             //    poptriggerfunc(msgtype='error',titledata='',msgdata=error_message_data,sd=1000,hd=1500,tmo=null,etmo=null,poscls='toast-bottom-right');
       //             //}
       //            
       //             var success_message_data="Thank you for your booking request! ";
       //   poptriggerfunc(msgtype='success',titledata='',msgdata=success_message_data,sd=1000,hd=1500,tmo=null,etmo=null,poscls='toast-bottom-right');
       //   return 2;
       //}
       //else
       //{
       //   return 1;
       //   //var error_message_data="something went wrong please try after some time! ";
       //   //poptriggerfunc(msgtype='error',titledata='',msgdata=error_message_data,sd=1000,hd=1500,tmo=null,etmo=null,poscls='toast-bottom-right');  
       //}
       //
    
}
               //**************FOR COUNTRY STATE AJAX**************************
               function getStateforCountry(requeststateUrl,ProfilecountryId,csrf)
               {
                         /*console.log("Requested URL ===========> "+requeststateUrl);
                         console.log("Country Id ===========> "+ProfilecountryId);
                         console.log("CSRF Token ===========> "+csrf);
                         console.log("=base_url_data=>"+base_url_data)*/;    
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
                                                  jQuery.each(res,function(ind, vaobj){
                                                  skiloptstr+="<option value="+vaobj.id+">"+vaobj.name+"</option>";
                                              });
													
										}else
                                        {
                                             skiloptstr+="<option >No state is available</option>";
                                        }
                                   


													//alert(skiloptstr);
                                                  jQuery("#statelist").html(skiloptstr);
                                                    $("#statelist").selectpicker('refresh');
                                        }
                         });
                         
               }
               //*******************FOR CATEGORY GENERE AJAX
               
                function getGenereforCategory(requeststateUrl,Catagory_Id,csrf)
               {
                         //alert('hello');
                         //console.log("Requested URL ===========> "+requeststateUrl);
                         //console.log("Category Id ===========> "+Catagory_Id);
                         //console.log("CSRF Token ===========> "+csrf);
                         //console.log("=base_url_data=>"+base_url_data);    
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
                                                       jQuery.each(res,function(ind, vaobj){
                                                       skiloptstr+="<option value="+vaobj.id+">"+vaobj.name+"</option>";
                                                   });
                                                         
                                             }else
                                             {
                                                  skiloptstr+="<option >No Genere is available</option>";
                                             }
                                        
     
     
                                                         //alert(skiloptstr);
                                                       jQuery("#bookinggenre_sub").html(skiloptstr);
                                                       $("#bookinggenre_sub").selectpicker('refresh');
                                        }
                         });
                         
               }
               

