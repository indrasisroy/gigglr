//<script src='https://cdn.pin.net.au/pin.v2.js'></script>  
jQuery(document).ready(function(){
              
 //********************** wallet payment related code starts ***************************       
        
        // 1. Wait for the page to load


  // 2. Create an API object with your publishable api key, and
  // specifying 'test' or 'live'.
  //
  // Be sure to use your live publishable key with the live api, and
  // your test publishable key with the test api.
        var pinApi = new Pin.Api(pin_publishable_key, pin_liveortest); //publishable key

        var form = $('form.pin'),
      submitButton = form.find(":submit"),
      errorContainer = form.find('.errors'),
      errorList = errorContainer.find('ul'),
      errorHeading = errorContainer.find('p');
              
              

  // 3. Add a submit handler to the form which calls Pin.js to
  // retrieve a card token, and then add that token to the form and
  // submit the form to your server.
  form.submit(function(e) {
    e.preventDefault();

    // Clear previous errors
    errorList.empty();
    errorHeading.empty();
    errorContainer.hide();
      
    $(".common_paymnt_errcls").empty(); 
    $(".common_paymnt_errcls").addClass("mydisplaynone");    
      
      

    // Disable the submit button to prevent multiple clicks
    submitButton.attr({disabled: true});

    // Fetch details required for the createToken call to Pin Payments
    var card = {
      number:           $('#cc-number').val(),
      name:             $('#cc-name').val(),
      expiry_month:     $('#cc-expiry-month').val(),
      expiry_year:      $('#cc-expiry-year').val(),
      cvc:              $('#cc-cvc').val(),
      address_line1:    $('#address-line1').val(),
      address_line2:    $('#address-line2').val(),
      address_city:     $('#address-city').val(),
      address_state:    $('#address-state').val(),
      address_postcode: $('#address-postcode').val(),
      address_country:  $('#address-country').val()
    };

      //address-line1 
     // alert(JSON.stringify(card));
    // Request a token for the card from Pin Payments
    pinApi.createCardToken(card).then(handleSuccess, handleError).done();
     
    //****** validate  payment amount starts *******       
            
    var pattpaymntammount = /^\d+(\.\d{1,2})*$/; 
    var cc_amount_data=$("#cc-amount").val();
    var chk_pattpaymntammount = pattpaymntammount.test(cc_amount_data); 
    console.log("chk_pattpaymntammount==>"+chk_pattpaymntammount);  
      if(chk_pattpaymntammount==false)
          {
               $("#cc-amount-error").removeClass("mydisplaynone");
               $("#cc-amount-error").text("*Invalid amount");
              
              // Re-enable the submit button
              submitButton.removeAttr('disabled');
          }
      else
      {
          submitButton.attr({disabled: true});
      }
     
    //****** validate  payment  amount starts *******  
      
   //************************ wallet payment related code  ends ******************   
      
   //************************ Bank payment related code  starts ******************   
      setTimeout(function(){
          
//          $("#bankpaymentsubmid").click(function(){
//          
//         console.log("");
//          
//          var callurlwithdata={
//                    bank_account_number:$("#bank_account_number").val(),
//                    bank_state_branch_code:$("#bank_state_branch_code").val(),
//                    account_holder_name:$("#account_holder_name").val()
//                              
//                              };
//                 var callingurl=base_url_data+"/"+"paytobank";
//                
//                 $.ajax({
//                    url:callingurl,
//                    data:callurlwithdata,
//                    type:'GET',
//                    dataType:'JSON',
//                    success:function(d){
//                     
//                        alert(JSON.stringify(d));
//                       
//                   
//                        
//                        
//                    }
//                });
//          
//          
//      });
          
      },1500);
     
  //************************ Bank payment related code  ends ******************      
      
      
  });

  function handleSuccess(card) {
    // Add the card token to the form
    //
    // Once you have the card token on your server you can use your
    // private key and Charges API to charge the credit card.
      
//    $('<input>')
//      .attr({type: 'hidden', name: 'card_token'})
//      .val(card.token)
//      .appendTo(form);

    // Resubmit the form to the server
    //
    // Only the card_token will be submitted to your server. The
    // browser ignores the original form inputs because they don't
    // have their 'name' attribute set.
    //form.get(0).submit();
      
    //****** call our custom   ajax function for making transaction starts *******
      
      chargepinpayment(card.token);     
      
    //****** call our custom   ajax function for making transaction ends *******
      
      
      
  }

  function handleError(response) {
    errorHeading.text("*"+response.error_description);
      
    $("#paymnnterrorheading").removeClass("mydisplaynone");  

    if (response.messages) {
      $.each(response.messages, function(index, paramError) {
        $('<li>')
          .text(paramError.param + ": " + paramError.message)
          .appendTo(errorList);
          
         
         //******** show control respective error starts *********
          
          //common_paymnt_errcls myerrorcolor mydisplaynone
          
          if(paramError.param=='number')
              {
                  $("#cc-number-error").removeClass("mydisplaynone");
                  $("#cc-number-error").text("*"+paramError.message);
              }
          else if(paramError.param=='name')
              {
                  $("#cc-name-error").removeClass("mydisplaynone");
                  $("#cc-name-error").text("*"+paramError.message);
                  
              }
          else if(paramError.param=='expiry_month')
              {
                  $("#cc-expiry-month-error").removeClass("mydisplaynone");
                   $("#cc-expiry-month-error").text("*Exp. month");
              }
          else if(paramError.param=='expiry_year')
              {
                  $("#cc-expiry-year-error").removeClass("mydisplaynone");
                  $("#cc-expiry-year-error").text("*Exp. year");
              }
          else if(paramError.param=='cvc')
              {
                   $("#cc-cvc-error").removeClass("mydisplaynone");
                  $("#cc-cvc-error").text("*"+paramError.message);
              }
          
          
          
         //******** show control respective error ends *********
          
          
          
      });
    }

    errorContainer.show();
    
    // Re-enable the submit button
    submitButton.removeAttr('disabled');
  };
              
  
              
              
             
              
              
              
});
           
    //****** tracking tab change event of payment modal starts **************       
    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        //e.target // newly activated tab
        //e.relatedTarget // previous active tab
        
        // var prevtabdata=$(e.relatedTarget).attr("href");    
        var paytabtargetiddata = $(e.target).attr("href"); // activated tab
        //console.log("==prevtabdata=>"+prevtabdata+"=="+paytabtargetiddata);
        
        if(paytabtargetiddata=="#paythree")
            {
               // $(paytabtargetiddata).html("<p>okkkk</p>");
                
                
                var searchdata={};var pgloadflag=0; var pagenumdata=1;
                 loadtransactiondatas(pagenumdata,pgloadflag,searchdata);        
                
                
            }
        else if(paytabtargetiddata=="#paytwo")
            {
               resetcreditcardpaymentform();                 
                
            }
            else if(paytabtargetiddata=="#payone")
            {
                    resetbankpaymentform();
                    
                    
                
                    $("#bankpaymentsubmid").click(function(){
          
                    toastr.remove();
                         
                    var allowbankpaymntflag=true;     
                         
                    //****  validate form starts *******   
                         
                    var validation_err_msg='';
                        
                    var  pattaccntholdername=/^[a-zA-Z ]+$/;  
                        
                    
                    var account_holder_name_data=$("#account_holder_name").val();
                    var chk_account_holder_name = pattaccntholdername.test(account_holder_name_data); 
                    // console.log("chk_bank_transfer_amount==>"+chk_bank_transfer_amount);  
                    if(chk_account_holder_name==false)
                    {
                        allowbankpaymntflag=false;
                        validation_err_msg=validation_err_msg+"<p>Invalid name </p>";
                    } 
                        
                        
                    var  pattbsbcode=/^[0-9]{1,6}$/;
                    var bank_state_branch_code_data=$("#bank_state_branch_code").val();
                    var chk_bank_state_branch_code = pattbsbcode.test(bank_state_branch_code_data); 
                    // console.log("chk_bank_transfer_amount==>"+chk_bank_transfer_amount);  
                    if(chk_bank_state_branch_code==false)
                    {
                        allowbankpaymntflag=false;
                        validation_err_msg=validation_err_msg+"<p>Invalid bsb code</p>";
                    }   
                        
                        
                        
                    var  pattbnkaccnt=/^[0-9]{1,9}$/;
                    var bank_account_number_data=$("#bank_account_number").val();
                    var chk_bank_account_number = pattbnkaccnt.test(bank_account_number_data); 
                    // console.log("chk_bank_transfer_amount==>"+chk_bank_transfer_amount);  
                    if(chk_bank_account_number==false)
                    {
                        allowbankpaymntflag=false;
                        validation_err_msg=validation_err_msg+"<p>Invalid account number </p>";
                    }   
                        
                         
                    var pattpaymntammount = /^\d+(\.\d{1,2})*$/; 
                    var bank_transfer_amount_data=$("#bank_transfer_amount").val();
                    var chk_bank_transfer_amount = pattpaymntammount.test(bank_transfer_amount_data); 
                    // console.log("chk_bank_transfer_amount==>"+chk_bank_transfer_amount);  
                    if(chk_bank_transfer_amount==false)
                    {
                        allowbankpaymntflag=false;
                        validation_err_msg=validation_err_msg+"<p>Invalid amount provided</p>";
                    }
                        
                        
                        
                         
                         
                    if(allowbankpaymntflag==false)
                        {
                            poptriggerfunc(msgtype='error',titledata='',msgdata=validation_err_msg,sd=1000,hd=1500,tmo=3000,etmo=4000,poscls='toast-top-full-width');
                            
                            return false;
                            
                        }
                         
                         
                    //****  validate form ends *******
                         
                         
                         
                         
          
                    var callurlwithdata={
                    bank_account_number:$("#bank_account_number").val(),
                    bank_state_branch_code:$("#bank_state_branch_code").val(),
                    account_holder_name:$("#account_holder_name").val(),
                    bank_transfer_amount:$("#bank_transfer_amount").val()
                              
                              };
                 var callingurl=base_url_data+"/"+"paytobank";
                
                $("#bankpaymentsubmid").attr('disabled','disabled'); 
                         
                 $.ajax({
                    url:callingurl,
                    data:callurlwithdata,
                    type:'GET',
                    dataType:'JSON',
                    success:function(d){
                     
                       // alert(JSON.stringify(d));
                       
                        var flagresp=d.flagresp;
                        var message=d.message;
                        
                        var updated_wallet_amount=d.updated_wallet_amount;
                        
                        if(flagresp=='1')
                            {
                                $("#wallet_amount_id").html("You have $"+updated_wallet_amount);
                                poptriggerfunc(msgtype='success',titledata='',msgdata="Amount  transfered successfully to the account",sd=1000,hd=1500,tmo=3000,etmo=4000,poscls='toast-top-full-width');
                                
                                resetbankpaymentform();
                                
                                
                                 $('a[href="#paythree"]').tab('show'); //** show payment transaction tab 
                            }
                        else
                            {
                                poptriggerfunc(msgtype='error',titledata='',msgdata=message,sd=1000,hd=1500,tmo=3000,etmo=4000,poscls='toast-top-full-width');
                                
                                 $("#bankpaymentsubmid").removeAttr('disabled'); 
                            }
                        
                        
                    }
                });
          
          
      });
            }
        
        
        
    });
    //****** tracking tab change event of payment modal ends **************  
           
    //********** tracking payment modal open and  close starts ************************       
           
        $('#myModal3paymentview').on('hidden.bs.modal', function () {
            
            //console.log("payment modal closed");
            
            resetcreditcardpaymentform();
            
        });
           
           $('#myModal3paymentview').on('shown.bs.modal', function () {
               
            //console.log("payment modal opened");
               
               $('a[href="#paytwo"]').tab('show'); //** show payment transaction tab 
               
               
        });
           
           
      
   //********** tracking payment modal open and  close ends ************************  
   
   //******* reset  payment  credit card form starts *******************************
    function resetcreditcardpaymentform()
           {
               
               $("#cc-name").val('');
               $("#cc-number").val('');
               $("#cc-cvc").val('');
               $("#cc-amount").val('');
               
               $("#cc-expiry-month").selectpicker('deselectAll');
               $("#cc-expiry-year").selectpicker('deselectAll');
               $("#paymentbutid").removeAttr('disabled');   
               
               
               $("#paymnnterrorheading").addClass("mydisplaynone");
               $("#paymnnterrorheading").empty();
               $("#cc-name-error").addClass("mydisplaynone");
               $("#cc-name-error").empty();
               $("#cc-number-error").addClass("mydisplaynone");
               $("#cc-number-error").empty();
               $("#cc-cvc-error").addClass("mydisplaynone");
               $("#cc-cvc-error").empty();
               $("#cc-expiry-month-error").addClass("mydisplaynone");
               $("#cc-expiry-month-error").empty();
               $("#cc-expiry-year-error").addClass("mydisplaynone");
               $("#cc-expiry-year-error").empty();
               $("#cc-amount-error").addClass("mydisplaynone");   
               $("#cc-amount-error").empty();
               
           }
    //******* reset  payment  credit card form starts *******************************


     //******* reset bank  payment   form starts *******************************
    function resetbankpaymentform()
           {
               
               $("#account_holder_name").val('');
               $("#bank_state_branch_code").val('');
               $("#bank_account_number").val('');
               $("#bank_transfer_amount").val('');   
               
               $("#bankpaymentsubmid").removeAttr('disabled'); 
               
               
           }
    //******* reset bank payment   form starts *******************************
           
           
     //********* loadtransactiondatas starts ******************           
      function loadtransactiondatas (pagenumdata,pgloadflag,searchdata)   
           {
                 var callurlwithdata={pagenum:pagenumdata};
                 var callingurl=base_url_data+"/"+"showtransactionlist";
                
                 $.ajax({
                    url:callingurl,
                    data:callurlwithdata,
                    type:'GET',
                    dataType:'JSON',
                    success:function(d){
                     
                        //alert(JSON.stringify(d));
                        
                        var transactionresp=d.transactionresp;
                        var now_wallet_balance='$'+d.now_wallet_balance;
                        
                        var pagination_link=d.pagination_link;
                        
                        var total_credit=d.total_credit;
                        var total_debit=d.total_debit;
                        
                        var add_debcred_html="<tr class=\"total\"><td>&nbsp;</td><td><span>Total</span></td><td><span class=\"lett-spac\">$"+total_debit+"</span></td><td><span class=\"lett-spac\">$"+total_credit+"</span></td></tr>";
                        transactionresp=transactionresp+add_debcred_html;
                        
                        $("#transbdyid").html(transactionresp);
                        $("#paym_trans_pagination_link").html(pagination_link);
                        $("#wallet_tot_bal_id").html(now_wallet_balance);
                        
                        /*
                        
                        
 <tr class="total"><td>&nbsp;</td><td><span>Total</span></td><td><span class="lett-spac">$11900</span></td><td><span class="lett-spac">$2100</span></td></tr>
                        
                        */
                        
                        setTimeout(function(){
                            
                            //**** now bind with each li starts
												jQuery('.pagination_outer_cust').find('li').each(function(){
													
													jQuery(this).click(function(){
														
														var pagenumdata=jQuery(this).find('a').data('page');
														if(pagenumdata!='nopage')
														{
															var searchdata={}; var pgloadflag=0;
                                                             loadtransactiondatas(pagenumdata,pgloadflag,searchdata);
														}
														
														});
													
													});
				        //**** now bind with each li ends	
                            
                            
                        },500);
                        
                        
                   
                        
                        
                    }
                });
           }
     //********* loadtransactiondatas ends ******************  
           
    function chargepinpayment(card_token)
      {
            var callingurl=base_url_data+"/"+"paymentwalletprocess";
            var amountdata=$("#cc-amount").val();
                var callurlwithdata={_token:csrf_token_data,card_token:card_token,amount:amountdata};
                
                $.ajax({
                    url:callingurl,
                    data:callurlwithdata,
                    type:'POST',
                    dataType:'JSON',
                    success:function(d){
                     
                        //alert(JSON.stringify(d));
                        
                        var success_data=d.paymentresp.flagresp;
                        
                        var message_data=d.paymentresp.message;
                        
                        var message_data_ar=(d.paymentresp.errormessagear).length;
                        
                        var tot_wallet_amount=d.tot_wallet_amount;
                        
                        if(success_data=="1" && (message_data=='') )
                            {
                                
                                 poptriggerfunc(msgtype='success',titledata='',msgdata="Paymen done successfully",sd=1000,hd=1500,tmo=3000,etmo=4000,poscls='toast-top-full-width');
                                
                                
                                 $('a[href="#paythree"]').tab('show'); //** show payment transaction tab 
                                
                                  if(parseFloat(tot_wallet_amount)>0) //*** update header wallet balance
                                    {
                                        $("#wallet_amount_id").html("You have $"+tot_wallet_amount);
                                    }
                                 
                                
                            }
                        else  if( success_data=="0" && message_data!=='' )
                            {
                            // Re-enable the submit button
                            $("#paymentbutid").removeAttr('disabled');     poptriggerfunc(msgtype='error',titledata='',msgdata=message_data,sd=1000,hd=1500,tmo=3000,etmo=4000,poscls='toast-top-full-width');
                            }
                        
                   
                        
                        
                    }
                });
          
      }          
        
      

     