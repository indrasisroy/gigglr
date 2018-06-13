
//$(document).ready(function(){
  
  var security_lock_by_id ="";

      $("#securityimg_div").on("click", (function () {
    
      var valuetotalpayimg = $(this).data('securityimgflag');
      //alert(valuetotalpayimg);
      if (valuetotalpayimg == '0') {
        //$(this).data('securityimgflag',1);
        $(".securityimg").data('securityimgflag',1);
        $('#securityimg_div').data('securityimgflag',1);
        $("#securityimg_div").html(lockImg);
      }else{
        //$(this).data('securityimgflag',0);
        $(".securityimg").data('securityimgflag',1);
        $('#securityimg_div').data('securityimgflag',0);
        $("#securityimg_div").html(unlockImg);
      }
  }));
  
    //$(".totalpayimg").on("click", (function () {
        
    $("#totalpayimg_div").on("click", (function () {
      var valuetotalpayimg = $(this).data('totalpayimgflag');
      if (valuetotalpayimg == '0') {
        //$(this).data('totalpayimgflag',1);
        $(".totalpayimg").data('totalpayimgflag',1);
        $('#totalpayimg_div').data('totalpayimgflag',1);
        $("#totalpayimg_div").html(lockImg);
      }else{
        //$(this).data('totalpayimgflag',0);
        $(".totalpayimg").data('totalpayimgflag',0);
        $('#totalpayimg_div').data('totalpayimgflag',0);
        $("#totalpayimg_div").html(unlockImg);
      }

  }));
  
    //$(".bookingcanimg").on("click", (function () {
    $("#bookingcanimg_div").on("click", (function () {
      var valuebookingcanimg = $(this).data('bookingcanimgflag');
      if (valuebookingcanimg == '0') {
        //$(this).data('bookingcanimgflag',1);
        $(".bookingcanimg").data('bookingcanimgflag',1);
        $('#bookingcanimg_div').data('bookingcanimgflag',1);
        $("#bookingcanimg_div").html(lockImg);
      }else{
        //$(this).data('bookingcanimgflag',0);
        $(".bookingcanimg").data('bookingcanimgflag',0);
        $('#bookingcanimg_div').data('bookingcanimgflag',0);
        $("#bookingcanimg_div").html(unlockImg);
      }
  }));
  
  
  $("#cancel_bid_reqst").on("click", (function () {

    var whoami = $("#whoamiidval").val();
    var whoamitext = $("#whoamitextval").val();
    var w_am_id_agv = $("#whoamiagv").val();


        var confirmMsg = '1';//confirm("Are you sure here?");
        if (confirmMsg) {
            var callingurl= '';
            if (whoamitext == 'BKR') {
              callingurl = base_url_data+"/gigcancelbybooker";
            }else{
              callingurl = base_url_data+"/gigcancelbyartist";
            }
            var security_payment = $("#security_payment_gig").val();
            var total_payment = $("#total_payment_gig").val();
            var cancellation_fee = $("#cancellation_fee").val();
            var gig_description = $("#gig_description").val();
            //var expireday = $("#gig_description").val();

            //var canceled_by = logID;
            var canceled_by = '';
            if (type_flag == 1) {
              canceled_by = logID;
            }else{
              canceled_by = negotiation_id;
            }
            
            var callurlwithdata={_token:csrf_token_data,gigmaster_id:gigmaster_id,gigunique_id:gigunique_id,gig_bidrequest_id:gig_bidrequest_id,security_payment:security_payment,total_payment:total_payment,cancellation_fee:cancellation_fee,gig_description:gig_description,canceled_by:canceled_by,type_flag:type_flag,Last_updated_by:whoami,lastupdatettpe:whoamitext,w_am_id_agv:w_am_id_agv};
      
        
            if (logID!='') {

//***
$.confirm({
                                    theme: 'material',

                                    title: false,
                                    content: "<p style='text-align:center;'>Are you sure, you want to exit from negoriation process ?</p>",
                                    closeIcon: true,
                                    closeIconClass: 'fa fa-close',

                                    buttons: {
                                       buttonok: {
                                            text: 'yes',
                                           btnClass: 'btn-blue mycustlogoutcls',
                                            action: function () {
//***


 $("#cancel_bid_reqst" ).prop( "disabled", true );
 $("#negotiated_bid_reqst" ).prop( "disabled", true );
 $("#accept_bid_reqst_booker_artst").prop("disabled",true);
 // $("#accept_bid_reqst_booker")prop("disabled", true);

             $.ajax({
               
               url:callingurl,
               type:'GET',
               dataType:'json',
               data:callurlwithdata,
               success:function(d){
                //alert(d);
                //alert(d.flag+" ======== "+d.msg);
                toastr.remove();
                if (d.flag==0 && d.msg!='')
                {
                   $("#cancel_bid_reqst" ).prop( "disabled", false );
                   $("#negotiated_bid_reqst" ).prop( "disabled", false );
                   $("#accept_bid_reqst_booker_artst").prop("disabled",true);
                   // $("#accept_bid_reqst_booker")prop("disabled", false);
                    poptriggerfunc(msgtype='error',titledata='',msgdata=d.msg,sd=6000,hd=1500,tmo=3000,etmo=4000,poscls='toast-top-full-width');          
                }else{
                  $("#cancel_bid_reqst" ).prop( "disabled", false );
                  $("#negotiated_bid_reqst" ).prop( "disabled", false );
                  $("#accept_bid_reqst_booker_artst").prop("disabled",true);
                   //$("#accept_bid_reqst_booker")prop("disabled", false);
                  
                  toastr.remove();
                  removeallnegotiationmodal();
                    poptriggerfunc(msgtype='success',titledata='',msgdata=d.msg,sd=1000,hd=1500,tmo=3000,etmo=3000,poscls='toast-top-full-width');
                    $('#myRosterGigModal').modal('hide');
                    
                        //********** refresh calender and left panel start *****//
                        var newdefdt=selecteddate;            
                        $('#calendardivid').fullCalendar('destroy'); // destroy instance and call full calendar            
                        renderCustCalendarRoster(newdefdt); // call  and reinitialize calendar
                        callleftlistbycurdt();
                        //********** refresh calender and left panel end *****//
                    
                }
        
               }
               
              });





             //***

               }
                                        },
                                        buttonCancel: {
                                            text: 'no',
                                             btnClass: 'btn-red mycustlogoutcls',
                                            action: function () {

                                            }
                                        }


                                    }
                                });

             //***





            }else{
              poptriggerfunc(msgtype='error',titledata='',msgdata="Please Login to continue",sd=6000,hd=1500,tmo=3000,etmo=4000,poscls='toast-top-full-width');          
            }
        }


  }));
  
  //*****************from post for bid request start*************//
  $("#negotiated_bid_reqst").on("click", (function () {

    var submittrueorflase = $("#submittrueorflase").val();
    var submittotalamountval = $("#total_payment_gig").val();
    var aggreeval = $('input[name=i_agree]:checked').val();
  
    var validatedatachk = validatenegotiationaccept(submittrueorflase,submittotalamountval,aggreeval);

   if( (validatedatachk != 1) || (submittrueorflase != 1))
   {

         toastr.remove();
         poptriggerfunc(msgtype='error',titledata='',msgdata="Please ensure required fields are complete before submitting your request",sd=1000,hd=3000,tmo=2000,etmo=1000,poscls='toast-top-full-width');  
        return false;
   }

    // console.log(" submittrueorflase "+submittrueorflase+" validatedatachk "+validatedatachk);
  


    // return false;

    var confirmMsg = '1';//confirm("Are you sure to negotiate here?");
    if (confirmMsg) {
      
        //**************************11-08-16 added by soumik da start **************//      
        clickedformagnify=true;
        $('#calendardivid').fullCalendar('destroy');
        
        renderCustCalendarRoster(selecteddate);
        
        //**************************11-08-16 added by soumik da start **************//      
      
        //var chkgigvalidation =  $("#gig_master_post").valid();
       // if(chkgigvalidation === true)
        //{
            var bcf_lock_id = '';
            var asd_lock_id = '';
            var ta_lock_id = '';
            var secconverval =''; 
            var securityamoutnlockflagval='';
            var totalamoutnlockflagval='';
            var cancellationamoutnlockflagval='';
            
            var security_payment = $("#security_payment_gig").val();
            var total_payment = $("#total_payment_gig").val();
            var cancellation_fee = $("#cancellation_fee").val();
            var gig_description = $("#gig_description").val();
            var reqexpday = $("#reqexpire_time_day").val();
            var reqexphr = $("#reqexpire_time_hrs").val();
            var reqexpm = $("#reqexpire_time_mnt").val();


            //******************  Getting Who am I value starts here **********


           var whoami = $("#whoamiidval").val();
           var whoamitext = $("#whoamitextval").val();


            //****************** GEtting who am I value ends here  *************
            

           if(reqexpday!='' || reqexphr!='' || reqexpm!='')

                                   {

                                     if(reqexpday == '')
                                   {
                                     reqexpday = 0;
                                   }
                                   if(reqexphr == '')
                                   {
                                     reqexphr = 0;
                                   }
                                   if(reqexpm == '')
                                   {
                                     reqexpm = 0;
                                   }


                     secconverval = (parseInt(reqexpday)*24*60*60)+(parseInt(reqexphr)*60*60)+(parseInt(reqexpm)*60);


                                 }


            
            
              if(security_payment == '')
            {
              security_payment ="0.00";
            }
            if(cancellation_fee =="")
            {
              cancellation_fee="0.00";
            }
          
          
            var negotiated_by = negotiation_id;
            
            
            //*******************this section for booking cancel******************//
            var bcf_flag = $(".bookingcanimg").data('bookingcanimgflag');
            var bcf_lock_by = $("#bookingcanimg_div").data('booking_lock_by');
            if (bcf_lock_by == '0') {
              if (bcf_flag =='1') {
                bcf_lock_id = whoami;
                cancellationamoutnlockflagval=whoamitext;

              }
            }else{
              bcf_lock_id = bcf_lock_by;
              cancellationamoutnlockflagval=cancellationamoutnlockflag;
            }
          
          
            //*******************this section for security deposite******************//
            var asd_flag = $(".securityimg").data('securityimgflag'); 
            var asd_lock_by = $("#securityimg_div").data('security_lock_by');
            if (asd_lock_by == '0') {
              if (asd_flag=='1') {
                asd_lock_id = whoami;
                securityamoutnlockflagval=whoamitext;
              }
            }else{
              asd_lock_id = asd_lock_by;
              securityamoutnlockflagval=securityamoutnlockflag;
            }
          
            //alert(asd_flag+"       =============        "+asd_lock_by);
            
            //*******************this section for total payment******************//
            var ta_lock_by = $('#totalpayimg_div').data('totalpay_lock_by');
            var ta_flag = $(".totalpayimg").data('totalpayimgflag');
            if (ta_lock_by == '0') {
              if (ta_flag=='1') {
                ta_lock_id = whoami;
                totalamoutnlockflagval=whoamitext;
              }
            }else{
              ta_lock_id = ta_lock_by;
              totalamoutnlockflagval=totalamoutnlockflag;
            }
            // alert(totalamoutnlockflag+" -> securityamoutnlockflagval->"+securityamoutnlockflagval+"cancellationamoutnlockflagval -> "+cancellationamoutnlockflagval);return false;
            
            if (gig_type=="1") {
              //alert(gig_description+" "+total_payment+" "+security_payment);
              var callurlwithdata={_token:csrf_token_data,gigpostrequestflagjs:gigpostrequestflagjs,gig_bidrequest_id:gig_bidrequest_id,gigmaster_id:gigmaster_id,ta_lock_id:ta_lock_id,asd_lock_id:asd_lock_id,bcf_lock_id:bcf_lock_id,Last_updated_by:whoami,type_flag:type_flag,artist_id:artist_id,gigunique_id:gigunique_id,booker_id:booker_id,negotiated:negotiated_by,gig_description:gig_description,total_payment:total_payment,security_payment:security_payment,secconverval:secconverval,lastupdatettpe:whoamitext,totalamoutnlockflagval:totalamoutnlockflagval,securityamoutnlockflagval:securityamoutnlockflagval,cancellationamoutnlockflagval:cancellationamoutnlockflagval};
            }else{
              //alert(cancellation_fee+" "+total_payment+" "+security_payment);
              var callurlwithdata={_token:csrf_token_data,gigpostrequestflagjs:gigpostrequestflagjs,gig_bidrequest_id:gig_bidrequest_id,gigmaster_id:gigmaster_id,ta_lock_id:ta_lock_id,asd_lock_id:asd_lock_id,bcf_lock_id:bcf_lock_id,Last_updated_by:whoami,type_flag:type_flag,artist_id:artist_id,gigunique_id:gigunique_id,booker_id:booker_id,negotiated:negotiated_by,cancellation_fee:cancellation_fee,total_payment:total_payment,security_payment:security_payment,gig_description:gig_description,secconverval:secconverval,lastupdatettpe:whoamitext,totalamoutnlockflagval:totalamoutnlockflagval,securityamoutnlockflagval:securityamoutnlockflagval,cancellationamoutnlockflagval:cancellationamoutnlockflagval};
            }
            var callingurl=base_url_data+"/savegigbidrequest";
            
              
              if (logID!='') {



$.confirm({
                                    theme: 'material',

                                    title: false,
                                    content: "<p style='text-align:center;'>Are you sure, you want to Renegotiate ?</p>",
                                    closeIcon: true,
                                    closeIconClass: 'fa fa-close',

                                    buttons: {
                                       buttonok: {
                                            text: 'yes',
                                           btnClass: 'btn-blue mycustlogoutcls',
                                            action: function () {
                $("#negotiated_bid_reqst" ).prop( "disabled", true );
                $("#cancel_bid_reqst" ).prop( "disabled", true );
                $("#accept_bid_reqst_booker_artst").prop("disabled",true);

               $.ajax({
                 
                 url:callingurl,
                 type:'GET',
                 dataType:'json',
                 data:callurlwithdata,
                 success:function(d){
                  toastr.remove();
                  if (d.flag==0 && d.msg!='')
                  {
                    $("#negotiated_bid_reqst" ).prop( "disabled", false );

                    $("#cancel_bid_reqst" ).prop( "disabled", false );
                    $("#accept_bid_reqst_booker_artst").prop("disabled",false);

                      poptriggerfunc(msgtype='error',titledata='',msgdata="Something wrong",sd=6000,hd=1500,tmo=3000,etmo=4000,poscls='toast-top-full-width');          
                  }else{
                     $("#negotiated_bid_reqst" ).prop( "disabled", false );

                     $("#cancel_bid_reqst" ).prop( "disabled", false );
                    $("#accept_bid_reqst_booker_artst").prop("disabled",false);

                      removeallnegotiationmodal();


                      poptriggerfunc(msgtype='success',titledata='',msgdata=d.msg,sd=1000,hd=1500,tmo=3000,etmo=3000,poscls='toast-top-full-width');
                     // $('#myRosterGigModal').modal('hide');
                      
                        //********** refresh calender and left panel start *****//
                        var newdefdt=selecteddate;            
                        $('#calendardivid').fullCalendar('destroy'); // destroy instance and call full calendar            
                        renderCustCalendarRoster(newdefdt); // call  and reinitialize calendar
                        callleftlistbycurdt();
                        //********** refresh calender and left panel end *****//
                        
                  }
              
                 }
                 
                });
              










                            } // ends of new confirm  starts
                                        },
                                        buttonCancel: {
                                            text: 'no',
                                             btnClass: 'btn-red mycustlogoutcls',
                                            action: function () {

                                            }
                                        }


                                    }
                                });// ends of new confirm  starts





              }else{
                poptriggerfunc(msgtype='error',titledata='',msgdata="Please Login to continue",sd=6000,hd=1500,tmo=3000,etmo=4000,poscls='toast-top-full-width');          
              }
        //}
        //else
       // {
          //   var error_message_data="Please complete your booking request! ";
           //  poptriggerfunc(msgtype='error',titledata='',msgdata=error_message_data,sd=6000,hd=1500,tmo=3000,etmo=4000,poscls='toast-top-full-width');
       // }

    }


  }));
  

//*****************  Accecpt bid request starts  here ****************************


  //*******************accept artist bid request*******//
    $("#accept_bid_reqst").on("click", (function () {
      
        //******************  Getting Who am I value starts here **********
           var whoami = $("#whoamiidval").val();
           var whoamitext = $("#whoamitextval").val();
           var w_am_id_agv = $("#whoamiagv").val();
        //****************** GEtting who am I value ends here  *************



        //************  request expire date time value starts here *******

            var reqexpday = $("#reqexpire_time_day").val();
            var reqexphr = $("#reqexpire_time_hrs").val();
            var reqexpm = $("#reqexpire_time_mnt").val();
            var secconverval = '';


           if(reqexpday!='' || reqexphr!='' || reqexpm!='')

                                   {

                                     if(reqexpday == '')
                                   {
                                     reqexpday = 0;
                                   }
                                   if(reqexphr == '')
                                   {
                                     reqexphr = 0;
                                   }
                                   if(reqexpm == '')
                                   {
                                     reqexpm = 0;
                                   }


                     secconverval = (parseInt(reqexpday)*24*60*60)+(parseInt(reqexphr)*60*60)+(parseInt(reqexpm)*60);


                                 }

        //************  request expire date time value ends here ********





    //console.log(artist_id+" "+first_accepted_by+" "+gigpostrequestflagjs);
    ckingFrom_gig_master_post();
    var confirmMsg = '1';//confirm("Are you sure ?");
    if (confirmMsg) {
      
      
    //**************************11-08-16 added by soumik da start **************//      
    clickedformagnify=true;
    $('#calendardivid').fullCalendar('destroy');
    renderCustCalendarRoster(selecteddate);
    
    //**************************11-08-16 added by soumik da start **************//  
      
        var chkgigvalidation = true;// $("#gig_master_post").valid();
        if(chkgigvalidation === true)
        {
                //if (gig_bidrequest_id!="") {
                    var security_payment = $("#security_payment_gig").val();
                    var total_payment = $("#total_payment_gig").val();
                    var cancellation_fee = $("#cancellation_fee").val();
                    var gig_description = $("#gig_description").val();
                    var accept_by = '';
                    if (type_flag == 1) {
                        accept_by = logID;
                    }else{
                        accept_by = negotiation_id;
                    }
                    
                    var callurlwithdata={_token:csrf_token_data,type_flag:type_flag,booker_id:booker_id,gigmaster_id:gigmaster_id,gigunique_id:gigunique_id,gig_bidrequest_id:gig_bidrequest_id,security_payment:security_payment,total_payment:total_payment,cancellation_fee:cancellation_fee,gig_description:gig_description,accept_by:accept_by,whoami:whoami,whoamitext:whoamitext,w_am_id_agv:w_am_id_agv,secconverval:secconverval};
                    

                    console.log(" callurlwithdata "+callurlwithdata);

                    var callingurl=base_url_data+"/accptbidrequestbyartist";
                
                
                    if (logID!='') {


                      //*******

$.confirm({
                                    theme: 'material',

                                    title: false,
                                    content: "<p style='text-align:center;'>Are you sure, you want to accecpt this Bid?</p>",
                                    closeIcon: true,
                                    closeIconClass: 'fa fa-close',

                                    buttons: {
                                       buttonok: {
                                            text: 'yes',
                                           btnClass: 'btn-blue mycustlogoutcls',
                                            action: function () {
//*******




                     $.ajax({
                       
                       url:callingurl,
                       type:'GET',
                       dataType:'json',
                       data:callurlwithdata,
                       success:function(d){
                        toastr.remove();
                        if (d.flag==0 && d.msg!='')
                        {
                            poptriggerfunc(msgtype='error',titledata='',msgdata=d.msg,sd=6000,hd=1500,tmo=3000,etmo=4000,poscls='toast-top-full-width');          
                        }else{
                            poptriggerfunc(msgtype='success',titledata='',msgdata=d.msg,sd=1000,hd=1500,tmo=3000,etmo=3000,poscls='toast-top-full-width');
                            $('#myRosterGigModal').modal('hide');
                            
                            //********** refresh calender and left panel start *****//
                            var newdefdt=selecteddate;            
                            $('#calendardivid').fullCalendar('destroy'); // destroy instance and call full calendar            
                            renderCustCalendarRoster(newdefdt); // call  and reinitialize calendar
                            callleftlistbycurdt();
                            //********** refresh calender and left panel end *****//
                            
                        }
                
                       }
                       
                      });


//**********
 }
                                        },
                                        buttonCancel: {
                                            text: 'no',
                                             btnClass: 'btn-red mycustlogoutcls',
                                            action: function () {

                                            }
                                        }


                                    }
                                });
//**********



                    }else{
                      poptriggerfunc(msgtype='error',titledata='',msgdata="Please Login to continue",sd=6000,hd=1500,tmo=3000,etmo=4000,poscls='toast-top-full-width');          
                    }
                //}else{
                //      poptriggerfunc(msgtype='error',titledata='',msgdata="Please negotiat first to accept this bid",sd=6000,hd=1500,tmo=3000,etmo=4000,poscls='toast-top-full-width');  
                //}
            }
            else
            {
                 var error_message_data="Please complete your booking request! ";
                 poptriggerfunc(msgtype='error',titledata='',msgdata=error_message_data,sd=6000,hd=1500,tmo=3000,etmo=4000,poscls='toast-top-full-width');
            }
        }
    }));
    
  //******************* accecpt by booker starts here *******//


    $("#accept_bid_reqst_booker_artst").on("click", (function () {
      
      // console.log(artist_id+" "+first_accepted_by+" "+gigpostrequestflagjs);//exit();

      // return false;


    // if ((artist_id == first_accepted_by) && (gigpostrequestflagjs == '1')) {

    //   poptriggerfunc(msgtype='error',titledata='',msgdata="Sorry, but the request needs to be accepted first",sd=6000,hd=1500,tmo=3000,etmo=4000,poscls='toast-top-full-width');          

    // }else{
      
      // if (first_accepted_by == '0') {
      //  poptriggerfunc(msgtype='error',titledata='',msgdata="Sorry, but the request needs to be accepted first",sd=6000,hd=1500,tmo=3000,etmo=4000,poscls='toast-top-full-width');          
      // }else{



        //**************** lock value starts here

            var whoami = $("#whoamiidval").val();
            var whoamitext = $("#whoamitextval").val();
            var w_am_id_agv = $("#whoamiagv").val();

            var bcf_lock_id = '';
            var asd_lock_id = '';
            var ta_lock_id = '';
            var secconverval =''; 
            var securityamoutnlockflagval='';
            var totalamoutnlockflagval='';
            var cancellationamoutnlockflagval='';

        //*******************this section for booking cancel******************//
            var bcf_flag = $(".bookingcanimg").data('bookingcanimgflag');
            var bcf_lock_by = $("#bookingcanimg_div").data('booking_lock_by');
            if (bcf_lock_by == '0') {
              if (bcf_flag =='1') {
                bcf_lock_id = whoami;
                cancellationamoutnlockflagval=whoamitext;

              }
            }else{
              bcf_lock_id = bcf_lock_by;
              cancellationamoutnlockflagval=cancellationamoutnlockflag;
            }
          
          
            //*******************this section for security deposite******************//
            var asd_flag = $(".securityimg").data('securityimgflag'); 
            var asd_lock_by = $("#securityimg_div").data('security_lock_by');
            if (asd_lock_by == '0') {
              if (asd_flag=='1') {
                asd_lock_id = whoami;
                securityamoutnlockflagval=whoamitext;
              }
            }else{
              asd_lock_id = asd_lock_by;
              securityamoutnlockflagval=securityamoutnlockflag;
            }
          
            //alert(asd_flag+"       =============        "+asd_lock_by);
            
            //*******************this section for total payment******************//
            var ta_lock_by = $('#totalpayimg_div').data('totalpay_lock_by');
            var ta_flag = $(".totalpayimg").data('totalpayimgflag');
            if (ta_lock_by == '0') {
              if (ta_flag=='1') {
                ta_lock_id = whoami;
                totalamoutnlockflagval=whoamitext;
              }
            }else{
              ta_lock_id = ta_lock_by;
              totalamoutnlockflagval=totalamoutnlockflag;
            }
            // alert(totalamoutnlockflag+" -> securityamoutnlockflagval->"+securityamoutnlockflagval+"cancellationamoutnlockflagval -> "+cancellationamoutnlockflagval);return false;


        //****************  lock vaue ends here

        var submittrueorflase = $("#submittrueorflase").val();
        var submittotalamountval = $("#total_payment_gig").val();
        var aggreeval = $('input[name=i_agree]:checked').val();

        var validatedatachk = validatenegotiationaccept(submittrueorflase,submittotalamountval,aggreeval);

        if( (validatedatachk != 1) || (submittrueorflase != 1))
        {

         toastr.remove();
         poptriggerfunc(msgtype='error',titledata='',msgdata="Please ensure required fields are complete before submitting your request",sd=1000,hd=3000,tmo=2000,etmo=1000,poscls='toast-top-full-width');  
        return false;
        }
        
        ckingFrom_gig_master_post();
        var confirmMsg = '1';//confirm("Are you sure ?");
            if (confirmMsg) {
              
              
              
              //**************************11-08-16 added by soumik da start **************//      
              clickedformagnify=true;
              $('#calendardivid').fullCalendar('destroy');
              
              renderCustCalendarRoster(selecteddate);
              
              //**************************11-08-16 added by soumik da start **************//  
              
              
              
                var chkgigvalidation =  true;// $("#gig_master_post").valid();
                if(chkgigvalidation === true)
                {


                   //************  request expire date time value starts here *******

            var reqexpday = $("#reqexpire_time_day").val();
            var reqexphr = $("#reqexpire_time_hrs").val();
            var reqexpm = $("#reqexpire_time_mnt").val();
            var secconverval = '';


           if(reqexpday!='' || reqexphr!='' || reqexpm!='')

                                   {

                                     if(reqexpday == '')
                                   {
                                     reqexpday = 0;
                                   }
                                   if(reqexphr == '')
                                   {
                                     reqexphr = 0;
                                   }
                                   if(reqexpm == '')
                                   {
                                     reqexpm = 0;
                                   }


                     secconverval = (parseInt(reqexpday)*24*60*60)+(parseInt(reqexphr)*60*60)+(parseInt(reqexpm)*60);


                                 }

        //************  request expire date time value ends here ********





                // if (gig_bidrequest_id!="") 
                // {
                    var security_payment = $("#security_payment_gig").val();
                    var total_payment = $("#total_payment_gig").val();
                    var cancellation_fee = $("#cancellation_fee").val();
                    var gig_description = $("#gig_description").val();

                     
                    var accept_by = logID;
                    
                    var callurlwithdata={_token:csrf_token_data,gigpostrequestflagjs,gigpostrequestflagjs,type_flag:type_flag,bid_request_artist_id:bid_request_artist_id,gigmaster_id:gigmaster_id,gigunique_id:gigunique_id,gig_bidrequest_id:gig_bidrequest_id,security_payment:security_payment,total_payment:total_payment,cancellation_fee:cancellation_fee,gig_description:gig_description,accept_by:accept_by,whoami:whoami,whoamitext:whoamitext,w_am_id_agv:w_am_id_agv,booker_id:booker_id,secconverval:secconverval,totalamoutnlockflagval:totalamoutnlockflagval,securityamoutnlockflagval:securityamoutnlockflagval,cancellationamoutnlockflagval:cancellationamoutnlockflagval,bcf_lock_id:bcf_lock_id,asd_lock_id:asd_lock_id,ta_lock_id:ta_lock_id};
                    // console.log("Here abc");
                    // console.log(callurlwithdata);return false;

                    var callingurl=base_url_data+"/accptbidrequestbybooker";
                    var callingurlescrow = base_url_data+"/sendescrowmailtobkr";

                     var callurlwithdataescrowemail={_token:csrf_token_data,gigmaster_id:gigmaster_id};
                     console.log("Gig master id ==> "+callurlwithdataescrowemail.gigmaster_id);
                
                    if (logID!='') {


//*******

$.confirm({
                                    theme: 'material',

                                    title: false,
                                    content: "<p style='text-align:center;'>Are you sure, you want to accecpt this Bid?</p>",
                                    closeIcon: true,
                                    closeIconClass: 'fa fa-close',

                                    buttons: {
                                       buttonok: {
                                            text: 'yes',
                                           btnClass: 'btn-blue mycustlogoutcls',
                                            action: function () {
//*******




                           $("#negotiated_bid_reqst" ).prop( "disabled", true );
                           $("#cancel_bid_reqst" ).prop( "disabled", true );
                           $("#accept_bid_reqst_booker_artst").prop("disabled",true);




                     $.ajax({
                       
                       url:callingurl,
                       type:'GET',
                       dataType:'json',
                       data:callurlwithdata,
                       success:function(d){
                        //alert(d);
                        //alert(d.flag+" ======== "+d.msg);
                        toastr.remove();
                        if (d.flag==0 && d.msg!='')
                        {

                           $("#negotiated_bid_reqst" ).prop( "disabled", false );
                           $("#cancel_bid_reqst" ).prop( "disabled", false );
                           $("#accept_bid_reqst_booker_artst").prop("disabled",false);

                            poptriggerfunc(msgtype='error',titledata='',msgdata=d.msg,sd=6000,hd=1500,tmo=3000,etmo=4000,poscls='toast-top-full-width');          
                        }else{

                           $("#negotiated_bid_reqst" ).prop( "disabled", false );
                           $("#cancel_bid_reqst" ).prop( "disabled", false );
                           $("#accept_bid_reqst_booker_artst").prop("disabled",false);
                          $('#myRosterGigModal').modal('hide');
                            poptriggerfunc(msgtype='success',titledata='',msgdata=d.msg,sd=1000,hd=1500,tmo=3000,etmo=3000,poscls='toast-top-full-width');
                            // $('#myRosterGigModal').modal('hide');
                            removeallnegotiationmodal();
                            
                            //$('#wallet_amount_id').html("You have $"+d.booker_curent_balance);
                            
                            
                            //********** refresh calender and left panel start *****//
                            var newdefdt=selecteddate;            
                            $('#calendardivid').fullCalendar('destroy'); // destroy instance and call full calendar            
                            renderCustCalendarRoster(newdefdt); // call  and reinitialize calendar
                            callleftlistbycurdt();
                            //********** refresh calender and left panel end *****//



                            console.log("flag response ==> "+d.escrow_flagresponse);
                            //****** 
                             if(d.escrow_flagresponse == 1)
                             {
                                    $.ajax({

                                    url:callingurlescrow,
                                    type:'POST',
                                    dataType:'json',
                                    data:callurlwithdataescrowemail,
                                    success:function(d){
                                      console.log("Gig email send succussfully");
                                         }

                                    });
                             }

                            //******



                        }
                
                       }
                       
                      });

//**********
 }
                                        },
                                        buttonCancel: {
                                            text: 'no',
                                             btnClass: 'btn-red mycustlogoutcls',
                                            action: function () {

                                            }
                                        }


                                    }
                                });
//**********





                    }else{
                      poptriggerfunc(msgtype='error',titledata='',msgdata="Please Login to continue",sd=6000,hd=1500,tmo=3000,etmo=4000,poscls='toast-top-full-width');          
                    }
                // }
                // else{
                //       poptriggerfunc(msgtype='error',titledata='',msgdata="Please negotiate first before accepting this offer",sd=6000,hd=1500,tmo=3000,etmo=4000,poscls='toast-top-full-width');  
                //  }
                }
            }
    //   }
      

    // }
    }));
    
//******************* accecpt by booker ends here *******//



//*****************  Accecpt bid request ends here


  function ckingFrom_gig_master_post() {
    
    $.validator.addMethod("checkingamount",function(value,element)
    {
        var securitymony = $("#security_payment_gig").val().replace("$", "").replace(/,/g, "");
        var cancellation = $("#cancellation_fee").val().replace("$", "").replace(/,/g, "");
        var totalpayment = $("#total_payment_gig").val().replace("$", "").replace(/,/g, "");
        
        
        if(securitymony == '')
       {
         securitymony ="0.00";
       }
       if(cancellation =="")
       {
        cancellation="0.00";
       }
        
        
        var ff2 =parseFloat(totalpayment)-(parseFloat(cancellation)+parseFloat(securitymony));
        
        var f = parseFloat(ff2).toFixed(2);
        
        if (f > 0) {
          return true;
        }else{
         return false;
        }
        
    },"Please enter a valid cancellation amount ");
    
    //******************* client-side CUSTOM VALIDATION FOR numeric checking starts
                               
    $.validator.addMethod("numericfieldamount", function(value, element) 
    {
        var characterReg = /^([0-9]*){0,}(\.\d{1,2})?$/; ///^[1-9][0-9]+(\.\d{1,2})?$/ ;
        return characterReg.test(value);
    },"Please enter proper numeric value");

    //******************* client-side CUSTOM VALIDATION FOR numeric checking ends   
    $.validator.addMethod("checkingamounttotal",function(value,element)
    {
        var securitymony = $("#security_payment_gig").val().replace("$", "").replace(/,/g, "");
        var cancellation = $("#cancellation_fee").val().replace("$", "").replace(/,/g, "");
        var totalpayment = $("#total_payment_gig").val().replace("$", "").replace(/,/g, "");
        
        
        if(securitymony == '')
       {
         securitymony ="0.00";
       }
       if(cancellation =="")
       {
        cancellation="0.00";
       }
        
        
        var ff = parseFloat(totalpayment)-parseFloat(securitymony);
        var f = parseFloat(ff).toFixed(2);
        if (f > 0) {
          return true;
        }else{
         return false;
        }
    },"Total paymenet must be higher than security deposit");
    
    //**********************FORM VALIDATION STARTS HERE ***************************
    $("#gig_master_post").validate({
      
    /********* added date 22th november 2016 start ***********/ 
    /*****add parent class*****/
    highlight: function(element) {
        $(element).parent().addClass("errorField");
    },
    /*****remove parent class*****/
    unhighlight: function(element) {
        $(element).parent().removeClass("errorField");
    },   
    /*****remove error text*****/
    errorPlacement: function () {
        return false;
    },
    /********* added date 22th november 2016 end ***********/
          
    errorClass: "authError",
    errorElement: 'span',
    //***********************VALIDATION RULES*****************STARTS****************
    rules: {
               security_payment_gig:{
                   //required: true,
                   maxlength: 20,
                   numericfieldamount:true,
               },
               
                total_payment_gig:{
                   required: true,
                   maxlength: 20,
                   checkingamounttotal:true,
                   numericfieldamount:true,
                },
                cancellation_fee:{
                   //required: {
                   //            depends: function(element)
                   //            {
                   //                      return $("#cancellation_fee").val()!='';
                   //            }
                   //          },
                   //required:true,
                   maxlength: 20,
                   numericfieldamount:true,
                   checkingamount :{
                               depends: function(element)
                               {
                                         return $("#cancellation_fee").val()!='';
                               }
                             },
              },
         },
         //*****************VALIDATION RULES*****************************ENDS***********
         
         //*****************VALIDATION ERROR MESSAGES *******************STARTS*********
    messages: {
    
              security_payment_gig: {
                 required: "Please enter security amount",
                 maxlength: "Too large amount",
                 numericfieldamount: "Please enter proper numeric value",
              },
              total_payment_gig: {
                required: "Please enter an amount",
                maxlength: "Too large amount",
                numericfieldamount: "Please enter proper numeric value",
              },
              cancellation_fee: {
                //required: "Please enter an amount Dhiman",
                maxlength: "Too large amount",
                numericfieldamount: "Please enter proper numeric value",
              },
    
         },
         //*****************VALIDATION ERROR MESSAGES *******************ENDS*********
    
    });
  }




  //*********************  remove all negotiation modal starts here 

  function removeallnegotiationmodal()
  {
    $("#reqmodal1").modal('hide');
    $("#reqmodal2").modal('hide');
    $("#reqmodal3").modal('hide');
    $("#reqmodal4").modal('hide');
  }
  //********************* remove all negotiation modal ends here


  function validatenegotiationaccept(submittrueorflase,submittotalamountval,aggreeval)
  {
    

    var cancellation_fee = $("#cancellation_fee").val();
    var security_payment_gig = $("#security_payment_gig").val();  
    var flagval = 0;
    var characterReg = /^([0-9]*){0,}(\.\d{1,2})?$/; ///^[1-9][0-9]+(\.\d{1,2})?$/ ;

    var t1 = characterReg.test(cancellation_fee);
    var t2 = characterReg.test(security_payment_gig);

    var flagval = 0;
    var characterReg = /^([0-9]*){0,}(\.\d{1,2})?$/; ///^[1-9][0-9]+(\.\d{1,2})?$/ ;
    var t = characterReg.test(submittotalamountval);
  
   if(t == false || submittotalamountval=='')
   {
    flagval = 0;
    $("#total_payment_gig").parent().addClass('errorField');
   }
   else if(t == false || submittotalamountval=='')
   {
     $("#i_agree_id").parent().addClass('radioerrorcolor');
     flagval = 0;
   }
   else if(aggreeval == 'za')
   {
     $("#i_agree_id").parent().addClass('radioerrorcolor');
     flagval = 0;
   }else if(t1 == false)
   {
     $("#cancellation_fee").parent().addClass('errorField');
     flagval = 0;
   }
   else if(t2 == false)
   {
     $("#security_payment_gig").parent().addClass('errorField');
     flagval = 0;
   }

   else
   {
    $("#total_payment_gig").parent().removeClass('errorField');
    $("#i_agree_id").parent().removeClass('radioerrorcolor');
    $("#cancellation_fee").parent().removeClass('errorField');
    $("#security_payment_gig").parent().removeClass('errorField');
    flagval = 1;
   }

  // console.log(" flagval "+flagval);
    return flagval;
  }


