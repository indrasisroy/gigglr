
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
        var confirmMsg = confirm("Are you sure ?");
        if (confirmMsg) {
            var callingurl= '';
            if (logID == booker_id) {
              callingurl = base_url_data+"/gigcancelbybooker";
            }else{
              callingurl = base_url_data+"/gigcancelbyartist";
            }
            var security_payment = $("#security_payment_gig").val();
            var total_payment = $("#total_payment_gig").val();
            var cancellation_fee = $("#cancellation_fee").val();
            var gig_description = $("#gig_description").val();
            var canceled_by = logID;
            
            var callurlwithdata={_token:csrf_token_data,gigmaster_id:gigmaster_id,gigunique_id:gigunique_id,gig_bidrequest_id:gig_bidrequest_id,security_payment:security_payment,total_payment:total_payment,cancellation_fee:cancellation_fee,gig_description:gig_description,canceled_by:canceled_by};
      
        
            if (logID!='') {
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
                    poptriggerfunc(msgtype='error',titledata='',msgdata=d.msg,sd=6000,hd=1500,tmo=3000,etmo=4000,poscls='toast-bottom-right');          
                }else{
                    poptriggerfunc(msgtype='success',titledata='',msgdata=d.msg,sd=1000,hd=1500,tmo=3000,etmo=3000,poscls='toast-bottom-right');
                    $('#myRosterGigModal').modal('hide');
                }
        
               }
               
              });
            }else{
              poptriggerfunc(msgtype='error',titledata='',msgdata="Please Login to continue",sd=6000,hd=1500,tmo=3000,etmo=4000,poscls='toast-bottom-right');          
            }
        }


  }));
  
  //*****************from post for bid request start*************//
  $("#negotiated_bid_reqst").on("click", (function () {

    ckingFrom_gig_master_post();
    var confirmMsg = confirm("Are you sure ?");
    if (confirmMsg) {
      
//**************************11-08-16 added by soumik da start **************//      
clickedformagnify=true;
$('#calendardivid').fullCalendar('destroy');

renderCustCalendarRoster(selecteddate);

//**************************11-08-16 added by soumik da start **************//      
      
        var chkgigvalidation =  $("#gig_master_post").valid();
        if(chkgigvalidation === true)
        {
            var bcf_lock_id = '';
            var asd_lock_id = '';
            var ta_lock_id = '';
            
            var security_payment = $("#security_payment_gig").val();
            var total_payment = $("#total_payment_gig").val();
            var cancellation_fee = $("#cancellation_fee").val();
            var gig_description = $("#gig_description").val();
            
          
            var negotiated_by = negotiation_id;
            
            
            //*******************this section for booking cancel******************//
            var bcf_flag = $(".bookingcanimg").data('bookingcanimgflag');
            var bcf_lock_by = $("#bookingcanimg_div").data('booking_lock_by');
            if (bcf_lock_by == '0') {
              if (bcf_flag =='1') {
                bcf_lock_id = logID;
              }
            }else{
              bcf_lock_id = bcf_lock_by;
            }
          
          
            //*******************this section for security deposite******************//
            var asd_flag = $(".securityimg").data('securityimgflag'); 
            var asd_lock_by = $("#securityimg_div").data('security_lock_by');
            if (asd_lock_by == '0') {
              if (asd_flag=='1') {
                asd_lock_id = logID;
              }
            }else{
              asd_lock_id = asd_lock_by;
            }
          
            //alert(asd_flag+"       =============        "+asd_lock_by);
            
            //*******************this section for total payment******************//
            var ta_lock_by = $('#totalpayimg_div').data('totalpay_lock_by');
            var ta_flag = $(".totalpayimg").data('totalpayimgflag');
            if (ta_lock_by == '0') {
              if (ta_flag=='1') {
                ta_lock_id = logID;
              }
            }else{
              ta_lock_id = ta_lock_by;
            }
            //alert(bcf_lock_id+" -> ddd->"+asd_lock_id+" -> "+ta_lock_id);
            
            if (gig_type=="1") {
              //alert(gig_description+" "+total_payment+" "+security_payment);
              var callurlwithdata={_token:csrf_token_data,gigpostrequestflagjs:gigpostrequestflagjs,gig_bidrequest_id:gig_bidrequest_id,gigmaster_id:gigmaster_id,ta_lock_id:ta_lock_id,asd_lock_id:asd_lock_id,bcf_lock_id:bcf_lock_id,Last_updated_by:logID,type_flag:type_flag,artist_id:artist_id,gigunique_id:gigunique_id,booker_id:booker_id,negotiated:negotiated_by,gig_description:gig_description,total_payment:total_payment,security_payment:security_payment};
            }else{
              //alert(cancellation_fee+" "+total_payment+" "+security_payment);
              var callurlwithdata={_token:csrf_token_data,gigpostrequestflagjs:gigpostrequestflagjs,gig_bidrequest_id:gig_bidrequest_id,gigmaster_id:gigmaster_id,ta_lock_id:ta_lock_id,asd_lock_id:asd_lock_id,bcf_lock_id:bcf_lock_id,Last_updated_by:logID,type_flag:type_flag,artist_id:artist_id,gigunique_id:gigunique_id,booker_id:booker_id,negotiated:negotiated_by,cancellation_fee:cancellation_fee,total_payment:total_payment,security_payment:security_payment,gig_description:gig_description};
            }
            var callingurl=base_url_data+"/savegigbidrequest";
            
              
              if (logID!='') {
               $.ajax({
                 
                 url:callingurl,
                 type:'GET',
                 dataType:'json',
                 data:callurlwithdata,
                 success:function(d){
                  toastr.remove();
                  if (d.flag==0 && d.msg!='')
                  {
                      poptriggerfunc(msgtype='error',titledata='',msgdata="Something wrong",sd=6000,hd=1500,tmo=3000,etmo=4000,poscls='toast-bottom-right');          
                  }else{
                      poptriggerfunc(msgtype='success',titledata='',msgdata=d.msg,sd=1000,hd=1500,tmo=3000,etmo=3000,poscls='toast-bottom-right');
                      $('#myRosterGigModal').modal('hide');
                  }
              
                 }
                 
                });
              }else{
                poptriggerfunc(msgtype='error',titledata='',msgdata="Please Login to continue",sd=6000,hd=1500,tmo=3000,etmo=4000,poscls='toast-bottom-right');          
              }
        }
        else
        {
             var error_message_data="Please complete your booking request! ";
             poptriggerfunc(msgtype='error',titledata='',msgdata=error_message_data,sd=6000,hd=1500,tmo=3000,etmo=4000,poscls='toast-bottom-right');
        }

    }
  }));
  
  //*******************accept artist bid request*******//
    $("#accept_bid_reqst").on("click", (function () {
      
      

        
    ckingFrom_gig_master_post();
    var confirmMsg = confirm("Are you sure ?");
    if (confirmMsg) {
      
      
  //**************************11-08-16 added by soumik da start **************//      
  clickedformagnify=true;
  $('#calendardivid').fullCalendar('destroy');
  
  renderCustCalendarRoster(selecteddate);
  
  //**************************11-08-16 added by soumik da start **************//  
      
        var chkgigvalidation =  $("#gig_master_post").valid();
        if(chkgigvalidation === true)
        {
                //if (gig_bidrequest_id!="") {
                    var security_payment = $("#security_payment_gig").val();
                    var total_payment = $("#total_payment_gig").val();
                    var cancellation_fee = $("#cancellation_fee").val();
                    var gig_description = $("#gig_description").val();
                    var accept_by = logID;
                    
                    var callurlwithdata={_token:csrf_token_data,type_flag:type_flag,booker_id:booker_id,gigmaster_id:gigmaster_id,gigunique_id:gigunique_id,gig_bidrequest_id:gig_bidrequest_id,security_payment:security_payment,total_payment:total_payment,cancellation_fee:cancellation_fee,gig_description:gig_description,accept_by:accept_by};
                    
                    var callingurl=base_url_data+"/accptbidrequestbyartist";
                
                
                    if (logID!='') {
                     $.ajax({
                       
                       url:callingurl,
                       type:'GET',
                       dataType:'json',
                       data:callurlwithdata,
                       success:function(d){
                        toastr.remove();
                        if (d.flag==0 && d.msg!='')
                        {
                            poptriggerfunc(msgtype='error',titledata='',msgdata=d.msg,sd=6000,hd=1500,tmo=3000,etmo=4000,poscls='toast-bottom-right');          
                        }else{
                            poptriggerfunc(msgtype='success',titledata='',msgdata=d.msg,sd=1000,hd=1500,tmo=3000,etmo=3000,poscls='toast-bottom-right');
                            $('#myRosterGigModal').modal('hide');
                        }
                
                       }
                       
                      });
                    }else{
                      poptriggerfunc(msgtype='error',titledata='',msgdata="Please Login to continue",sd=6000,hd=1500,tmo=3000,etmo=4000,poscls='toast-bottom-right');          
                    }
                //}else{
                //      poptriggerfunc(msgtype='error',titledata='',msgdata="Please negotiat first to accept this bid",sd=6000,hd=1500,tmo=3000,etmo=4000,poscls='toast-bottom-right');  
                //}
            }
            else
            {
                 var error_message_data="Please complete your booking request! ";
                 poptriggerfunc(msgtype='error',titledata='',msgdata=error_message_data,sd=6000,hd=1500,tmo=3000,etmo=4000,poscls='toast-bottom-right');
            }
        }
    }));
    
  //*******************accept booker bid request*******//
    $("#accept_bid_reqst_booker").on("click", (function () {
        
    if (gig_bid_status !='2') {
        poptriggerfunc(msgtype='error',titledata='',msgdata="Artist needs to accep first",sd=6000,hd=1500,tmo=3000,etmo=4000,poscls='toast-bottom-right');          
    }else{
    ckingFrom_gig_master_post();
    var confirmMsg = confirm("Are you sure ?");
        if (confirmMsg) {
          
          
      
  //**************************11-08-16 added by soumik da start **************//      
  clickedformagnify=true;
  $('#calendardivid').fullCalendar('destroy');
  
  renderCustCalendarRoster(selecteddate);
  
  //**************************11-08-16 added by soumik da start **************//  
          
          
          
            var chkgigvalidation =  $("#gig_master_post").valid();
            if(chkgigvalidation === true)
            {
            if (gig_bidrequest_id!="") {
                var security_payment = $("#security_payment_gig").val();
                var total_payment = $("#total_payment_gig").val();
                var cancellation_fee = $("#cancellation_fee").val();
                var gig_description = $("#gig_description").val();
                var accept_by = logID;
                
                var callurlwithdata={_token:csrf_token_data,gigpostrequestflagjs,gigpostrequestflagjs,type_flag:type_flag,bid_request_artist_id:bid_request_artist_id,gigmaster_id:gigmaster_id,gigunique_id:gigunique_id,gig_bidrequest_id:gig_bidrequest_id,security_payment:security_payment,total_payment:total_payment,cancellation_fee:cancellation_fee,gig_description:gig_description,accept_by:accept_by};
                
                var callingurl=base_url_data+"/accptbidrequestbybooker";
            
            
                if (logID!='') {
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
                        poptriggerfunc(msgtype='error',titledata='',msgdata=d.msg,sd=6000,hd=1500,tmo=3000,etmo=4000,poscls='toast-bottom-right');          
                    }else{
                        poptriggerfunc(msgtype='success',titledata='',msgdata=d.msg,sd=1000,hd=1500,tmo=3000,etmo=3000,poscls='toast-bottom-right');
                        $('#myRosterGigModal').modal('hide');
                    }
            
                   }
                   
                  });
                }else{
                  poptriggerfunc(msgtype='error',titledata='',msgdata="Please Login to continue",sd=6000,hd=1500,tmo=3000,etmo=4000,poscls='toast-bottom-right');          
                }
            }else{
                  poptriggerfunc(msgtype='error',titledata='',msgdata="Please negotiat first to accept this bid",sd=6000,hd=1500,tmo=3000,etmo=4000,poscls='toast-bottom-right');  
            }
            }
        }
    }
    }));
    

  function ckingFrom_gig_master_post() {
    $.validator.addMethod("checkingamount",function(value,element)
    {
        var securitymony = $("#security_payment_gig").val().replace("$", "").replace(/,/g, "");
        var cancellation = $("#cancellation_fee").val().replace("$", "").replace(/,/g, "");
        var totalpayment = $("#total_payment_gig").val().replace("$", "").replace(/,/g, "");
        
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
        //var cancellation = $("#cancellation_fee").val().replace("$", "").replace(/,/g, "");
        var totalpayment = $("#total_payment_gig").val().replace("$", "").replace(/,/g, "");
        
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
    errorClass: "authError",
    errorElement: 'span',
    //***********************VALIDATION RULES*****************STARTS****************
    rules: {
               security_payment_gig:{
                   required: true,
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
                required: "Please enter an amount",
                maxlength: "Too large amount",
                numericfieldamount: "Please enter proper numeric value",
              },
    
         },
         //*****************VALIDATION ERROR MESSAGES *******************ENDS*********
    
    });
  }


