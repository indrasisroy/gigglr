  //******* reset  payment  credit card form starts *******************************
    function resetcreditcardpaymentform()
           {
               
               $("#cc-name").val('');
               $("#cc-number").val('');
               $("#cc-cvc").val('');
               $("#cc-amount").val('');
               $("#paymentbutid").removeAttr('disabled'); 
               
               
               
               
               $("#cc-expiry-month").selectpicker('deselectAll');
               $("#cc-expiry-year").selectpicker('deselectAll');
                 
               
               
               $("#paymnnterrorheading").addClass("mydisplaynone");
               
               
               //$("#paymnnterrorheading").empty();
               //$("#cc-name-error").addClass("mydisplaynone");
               //$("#cc-name-error").empty();
               //$("#cc-number-error").addClass("mydisplaynone");
               //$("#cc-number-error").empty();
               //$("#cc-cvc-error").addClass("mydisplaynone");
               //$("#cc-cvc-error").empty();
               //$("#cc-expiry-month-error").addClass("mydisplaynone");
               //$("#cc-expiry-month-error").empty();
               //$("#cc-expiry-year-error").addClass("mydisplaynone");
               //$("#cc-expiry-year-error").empty();
               //$("#cc-amount-error").addClass("mydisplaynone");   
               //$("#cc-amount-error").empty();
               
               
                $("#cc-number").parent().removeClass("errorField");
                $("#cc-name").parent().removeClass("errorField");
                $("#cc-expiry-month").parent().parent().removeClass("errorField");
                $("#cc-expiry-year").parent().parent().removeClass("errorField");
                $("#cc-cvc").parent().removeClass("errorField");
                $("#cc-amount").parent().removeClass("errorField");
               
               
               
           }
    //******* reset  payment  credit card form starts *******************************


     //******* reset bank  payment   form starts *******************************
    function resetbankpaymentform()
           {
               
               $("#account_holder_name").val('');
               $("#bank_state_branch_code").val('');
               $("#bank_account_number").val('');
               $("#bank_transfer_amount").val('');   
               
               //$(".common_paytobnk_errcls").empty(); 
               //$(".common_paytobnk_errcls").addClass("mydisplaynone"); 
               
                $("#account_holder_name").parent().removeClass("errorField");
                $("#bank_state_branch_code").parent().removeClass("errorField");
                $("#bank_account_number").parent().removeClass("errorField");
                $("#bank_transfer_amount").parent().removeClass("errorField");
               
               $("#bankpaymentsubmid").removeAttr('disabled'); 
               
               
           }
    //******* reset bank payment   form starts *******************************
           
           
     //********* loadtransactiondatas starts ******************           
      function loadtransactiondatas (pagenumdata,pgloadflag,searchdata)   
           {
                 var callurlwithdata={_token:csrf_token_data,pagenum:pagenumdata};
                 var callingurl=base_url_data+"/"+"showtransactionlist";
                
                 $.ajax({
                    url:callingurl,
                    data:callurlwithdata,
                    type:'POST',
                    dataType:'JSON',
                    success:function(d){
                     
                        //alert(JSON.stringify(d));
                        
                        var transactionresp=d.transactionresp;
                        var now_wallet_balance='$'+d.now_wallet_balance;
                        
                        var pagination_link=d.pagination_link;
                        
                        var total_credit=d.total_credit;
                        var total_debit=d.total_debit;
                        
                        var add_debcred_html="<tr class=\"total\"><td>&nbsp;</td><td><span>Total</span></td><td><span id=\"totdebitid\" class=\"lett-spac\">$"+total_debit+"</span></td><td><span id=\"totcreditid\" class=\"lett-spac\">$"+total_credit+"</span></td></tr>";
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
                            
                            
                            //***** bind confirm popup for refund starts ********
                            
                            $(".custrefundclass").unbind( "click" );
                             $(".custrefundclass").click(function(){
                            
                                
                                 var refundancobj=$(this);
                                 
                                 var uordid=$(this).data("uordid");
                                
                                $.confirm({
                                    theme: 'material',

                                    title: false,
                                    content: "<p style='text-align:center;'>Are you sure, you want to refund ?</p>",
                                    closeIcon: true,
                                    closeIconClass: 'fa fa-close',

                                    buttons: {
                                       buttonok: {
                                            text: 'yes',
                                           btnClass: 'btn-blue mycustlogoutcls',
                                            action: function () {

                                               //**** code to call ajax to make refund starts ******
                                              //  console.log("call to rerefund");
                                                
                                                var callingurl=base_url_data+"/"+"makecreditcardpaymentrefund";
            
                var callurlwithdata={_token:csrf_token_data,userorderid:uordid};
                
                $.ajax({
                    url:callingurl,
                    data:callurlwithdata,
                    type:'POST',
                    dataType:'JSON',
                    success:function(d){
                     
                      //  alert(JSON.stringify(d));
                        
                                               
                        var flagresp=d.flagresp;
                         var message=d.message;
                        var now_wallet_balance=d.now_wallet_balance;
                        var tot_wallet_amount=d.updated_wallet_amount;
                                               
                        var total_credit=d.total_credit;
                        var total_debit=d.total_debit;
                        var amount_refunded=d.amount_refunded;
                        var userorderid=d.userorderid;
                      
                        
                        
                        if(flagresp=='1')
                            {
                                
                                
                                
                                if(parseFloat(now_wallet_balance)>=0) //*** update transaction balance
                                    {
                                       $("#wallet_tot_bal_id").html("$"+now_wallet_balance);
                                    }
                                
                                if(parseFloat(tot_wallet_amount)>=0) //*** update header wallet balance
                                    {
                                        $("#wallet_amount_id").html("You have $"+tot_wallet_amount);
                                    }
                                
                                 if(parseFloat(total_credit)>0) //*** update transaction credit balance
                                    {
                                        $("#totcreditid").html("$"+total_credit);
                                    }
                                
                                  if(parseFloat(total_debit)>0) //*** update transaction debit balance
                                    {
                                        $("#totdebitid").html("$"+total_debit);
                                    }
                                
                                    var userorderid_debit="debit_"+userorderid;
                                    $("#"+userorderid_debit).html("$"+amount_refunded); //*** update  debit column
                                
                                    var userorderid_ref_msg="refund_msg_"+userorderid;
                                    $("#"+userorderid_ref_msg).html("Refund is under pending"); //*** update  debit column
                                
                                    var  orderanc_id="orderanc_"+userorderid;
                                    $("#"+orderanc_id).unbind(); //*** unbind click event on anchor 
                                    
                                
                                    $(refundancobj).addClass("refundpendcls");
                                
                                
                            }
                        else if(flagresp=='0')
                            {
                                poptriggerfunc(msgtype='error',titledata='',msgdata=message,sd=1000,hd=1500,tmo=3000,etmo=4000,poscls='toast-top-full-width');
                            }
                        
                       
                     
                        
                        
                    }
                });
                                                
                                                
                                                
                                               //**** code to call ajax to make refund ends ******


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
                      
                                 
                                 
                             });
                            
                            //***** bind confirm popup for refund ends   ********
                            
                            
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
                                
                                 poptriggerfunc(msgtype='success',titledata='',msgdata="Thank you. Your payment was successful",sd=1000,hd=1500,tmo=3000,etmo=4000,poscls='toast-top-full-width');
                                
                                
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
    
    //**** previously done for clearing starts *************************   
    //$(".common_paymnt_errcls").empty(); 
    //$(".common_paymnt_errcls").addClass("mydisplaynone");
    //**** previously done for clearing ends ************************* 
      
    //**** newly done for clearing starts *************************      
    $("#cc-number").parent().removeClass("errorField");
    $("#cc-name").parent().removeClass("errorField");
    $("#cc-expiry-month").parent().parent().removeClass("errorField");
    $("#cc-expiry-year").parent().parent().removeClass("errorField");
    $("#cc-cvc").parent().removeClass("errorField");  
     $("#cc-amount").parent().removeClass("errorField");
    //**** newly done for clearing ends *************************  
      
      
      
      

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
     
   
      
   //************************ wallet payment related code  ends ******************   
      
   
      
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
      
      
     //****** validate  payment amount starts *******       
            
    var chkvalidateamount = validateamountforcreditcard();
     
    //****** validate  payment  amount starts *******    
      
      
      
    //****** call our custom   ajax function for making transaction starts ******
      if(chkvalidateamount==true)
          {
                chargepinpayment(card.token);  
          }
      
    //****** call our custom   ajax function for making transaction ends *******
      
      
      
  }

  function handleError(response) {
    errorHeading.text("*"+response.error_description);
      
    //$("#paymnnterrorheading").removeClass("mydisplaynone");  

    if (response.messages) {
      $.each(response.messages, function(index, paramError) {
        $('<li>')
          .text(paramError.param + ": " + paramError.message)
          .appendTo(errorList);
          
         
         //******** show control respective error starts *********
          
          
          
          validateamountforcreditcard(); // validate amount
          
          //common_paymnt_errcls myerrorcolor mydisplaynone
          
          if(paramError.param=='number')
              {
                  //$("#cc-number-error").removeClass("mydisplaynone");
                  //$("#cc-number-error").text("*"+paramError.message);
                  
                   $("#cc-number").parent().addClass("errorField");
                  
                  
              }
          else if(paramError.param=='name')
              {
                  //$("#cc-name-error").removeClass("mydisplaynone");
                  //$("#cc-name-error").text("*"+paramError.message);
                  
                   $("#cc-name").parent().addClass("errorField");
                  
              }
          else if(paramError.param=='expiry_month')
              {
                  //$("#cc-expiry-month-error").removeClass("mydisplaynone");
                  // $("#cc-expiry-month-error").text("*Exp. month");
                  
                   $("#cc-expiry-month").parent().parent().addClass("errorField");
              }
          else if(paramError.param=='expiry_year')
              {
                  //$("#cc-expiry-year-error").removeClass("mydisplaynone");
                  //$("#cc-expiry-year-error").text("*Exp. year");
                  
                  
                  $("#cc-expiry-year").parent().parent().addClass("errorField");
              }
          else if(paramError.param=='cvc')
              {
                   //$("#cc-cvc-error").removeClass("mydisplaynone");
                  //$("#cc-cvc-error").text("*"+paramError.message);
                  
                   $("#cc-cvc").parent().addClass("errorField");
              }
          
          
          
         //******** show control respective error ends *********
          
          
          
      });
    }

    errorContainer.show();
    
    // Re-enable the submit button
    submitButton.removeAttr('disabled');
  };
              
  
   function validateamountforcreditcard()
    {
        
                //****** validate  payment amount starts *******       

               // var pattpaymntammount = /^\d{1,4}$/; 
                var pattpaymntammount = /^\d{2,4}$/; 
                var cc_amount_data=$("#cc-amount").val();
                var chk_pattpaymntammount = pattpaymntammount.test(cc_amount_data); 
                //console.log("chk_pattpaymntammount==>"+chk_pattpaymntammount);  
                if(chk_pattpaymntammount==false)
                {
                    //$("#cc-amount-error").empty();
                    //$("#cc-amount-error").removeClass("mydisplaynone");
                    //$("#cc-amount-error").text("Invalid amount");
                    
                     $("#cc-amount").parent().addClass("errorField");

                    // Re-enable the submit button
                    submitButton.removeAttr('disabled');
                }
                else
                {
                    //if( (cc_amount_data>=1) && (cc_amount_data <=5000) )
                    
                    if( (cc_amount_data>=50) && (cc_amount_data <=5000) )
                        {
                            
                            //$("#cc-amount-error").addClass("mydisplaynone");
                            //$("#cc-amount-error").empty();
                            
                            $("#cc-amount").parent().removeClass("errorField");

                            submitButton.attr({disabled: true});
                            
                        }
                    else
                        {
                             
                             
                            
                             var crcaamntsrmsg=''; chk_pattpaymntammount=false;
                            
                                //if(cc_amount_data<1)
                                if(cc_amount_data<50)
                                    {
                                        crcaamntsrmsg="Amount is lesser than  $50";
                                       // crcaamntsrmsg="Amount is lesser than  $1";
                                    }
                                else if(cc_amount_data>5000)
                                {
                                    crcaamntsrmsg="Amount exceeds $5000";
                                }
                            
                             //$("#cc-amount-error").empty();
                             //$("#cc-amount-error").removeClass("mydisplaynone");   
                             //$("#cc-amount-error").text(crcaamntsrmsg);
                            
                             $("#cc-amount").parent().addClass("errorField");
                            
                               //  Re-enable the submit button
                                submitButton.removeAttr('disabled');
                            
                        }
                    
                    
                    
                   
                }

                //****** validate  payment  amount starts *******  
        
            return chk_pattpaymntammount;
        
    }
              
      
    
    //****** bind cc-amount keyup event for not allowing dot starts *****
    
    $("#cc-amount").bind('keyup',function(e){
        
        
        //console.log("key pressed");
        //console.log("key pressed =>"+e.keyCode +"||"+ e.which);
        
         var code = e.keyCode || e.which;
         if(code === 190) { 


            var self = this;
            setTimeout(function () 
                       {
                            //console.log(self.value)

                            if(self.value==".")
                                {
                                   self.value ='';
                                }
                            else
                                {
                                    if (self.value.indexOf('.') != -1) self.value = parseInt(self.value, 10);
                                }


                    }, 0);

             return false;
         }
        
       
        
    });
    
    
     $("#bank_transfer_amount").bind('keyup',function(e){
        
        
        //console.log("key pressed");
        //console.log("key pressed =>"+e.keyCode +"||"+ e.which);
        
         var code = e.keyCode || e.which;
         if(code === 190) { 


            var self = this;
            setTimeout(function () 
                       {
                            //console.log(self.value)

                            if(self.value==".")
                                {
                                   self.value ='';
                                }
                            else
                                {
                                    if (self.value.indexOf('.') != -1) self.value = parseInt(self.value, 10);
                                }


                    }, 0);

             return false;
         }
        
       
        
    });
    
    //****** bind cc-amount keyup event for not allowing dot ends *****
              
              
              
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
                    
                    $("#bankpaymentsubmid").off('click');
                
                    $("#bankpaymentsubmid").on('click',function(){
          
                    toastr.remove();
                         
                    var allowbankpaymntflag=true;  
                        
                     //console.log("hey baby");  
                        
                         
                    //****  validate form starts *******   
                        
                    var ac_hld_nm_ermsg='';
                    var ac_bsb_ermsg=''; 
                    var ac_nmbr_ermsg=''; 
                    var ac_trnsfr_amt_ermsg=''; 
                         
                    var validation_err_msg='';
                        
                    var  pattaccntholdername=/^[a-zA-Z ]+$/;  
                        
                    
                    var account_holder_name_data=$("#account_holder_name").val();
                    var chk_account_holder_name = pattaccntholdername.test(account_holder_name_data); 
                    // console.log("chk_bank_transfer_amount==>"+chk_bank_transfer_amount);  
                    if(chk_account_holder_name==false)
                    {
                        allowbankpaymntflag=false;
                        ac_hld_nm_ermsg="Invalid name";
                        validation_err_msg=validation_err_msg+ac_hld_nm_ermsg; 
                        
                        //$("#account_holder_name_error").html(ac_hld_nm_ermsg);
                        //$("#account_holder_name_error").removeClass("mydisplaynone");  
                        $("#account_holder_name").parent().addClass("errorField");
                        
                    }
                    else
                    {
                        //$("#account_holder_name_error").empty();
                        //$("#account_holder_name_error").addClass("mydisplaynone"); 
                        
                        $("#account_holder_name").parent().removeClass("errorField");

                    }
                        
                        
                        
                    var  pattbsbcode=/^[0-9]{1,6}$/;
                    var bank_state_branch_code_data=$("#bank_state_branch_code").val();
                    var chk_bank_state_branch_code = pattbsbcode.test(bank_state_branch_code_data); 
                    // console.log("chk_bank_transfer_amount==>"+chk_bank_transfer_amount);  
                    if(chk_bank_state_branch_code==false)
                    {
                        allowbankpaymntflag=false;
                        ac_bsb_ermsg="Invalid bcb code";
                        validation_err_msg=validation_err_msg+ac_bsb_ermsg;  
                        //$("#bank_state_branch_code_error").html(ac_bsb_ermsg);
                        //$("#bank_state_branch_code_error").removeClass("mydisplaynone");   
                        
                        $("#bank_state_branch_code").parent().addClass("errorField");
                        
                        
                    }
                    else
                    {
                        //$("#bank_state_branch_code_error").empty();
                        //$("#bank_state_branch_code_error").addClass("mydisplaynone"); 
                        
                        
                         $("#bank_state_branch_code").parent().removeClass("errorField");

                    }
                        
                        
                        
                    var  pattbnkaccnt=/^[0-9]{1,9}$/;
                    var bank_account_number_data=$("#bank_account_number").val();
                    var chk_bank_account_number = pattbnkaccnt.test(bank_account_number_data); 
                    // console.log("chk_bank_transfer_amount==>"+chk_bank_transfer_amount);  
                    if(chk_bank_account_number==false)
                    {
                        allowbankpaymntflag=false;
                        ac_nmbr_ermsg="Invalid account number";
                        validation_err_msg=validation_err_msg+ac_nmbr_ermsg; 
                        //$("#bank_account_number_error").html(ac_nmbr_ermsg);
                        //$("#bank_account_number_error").removeClass("mydisplaynone");  
                        
                         $("#bank_account_number").parent().addClass("errorField");
                        
                        
                    }
                    else
                    {
                        //$("#bank_account_number_error").empty();
                        //$("#bank_account_number_error").addClass("mydisplaynone"); 
                        
                        $("#bank_account_number").parent().removeClass("errorField");
                    }
                        
                         
                    var pattpaymntammount = /^\d{2,4}$/; 
                    var bank_transfer_amount_data=$("#bank_transfer_amount").val();
                    var chk_bank_transfer_amount = pattpaymntammount.test(bank_transfer_amount_data); 
                    // console.log("chk_bank_transfer_amount==>"+chk_bank_transfer_amount);  
                    if(chk_bank_transfer_amount==false)
                    {
                        allowbankpaymntflag=false;
                        ac_trnsfr_amt_flg="Invalid amount provided";
                        validation_err_msg=validation_err_msg+ac_trnsfr_amt_flg;   
                        //$("#bank_transfer_amount_error").html(ac_trnsfr_amt_flg);
                        //$("#bank_transfer_amount_error").removeClass("mydisplaynone"); 
                        
                        $("#bank_transfer_amount").parent().addClass("errorField");
                         
                         
                    }
                    else
                    {
                        if( (bank_transfer_amount_data>=50) && (bank_transfer_amount_data <=5000) )
                        {
                                //$("#bank_transfer_amount_error").empty();
                                //$("#bank_transfer_amount_error").addClass("mydisplaynone"); 
                            
                            
                                $("#bank_transfer_amount").parent().removeClass("errorField");
                            
                        }
                        else
                        {
                           
                             var crcaamntsrmsg=''; allowbankpaymntflag=false;
                            
                                if(bank_transfer_amount_data<50)
                                    {
                                        crcaamntsrmsg="Amount is lesser than  $50";
                                    }
                                else if(bank_transfer_amount_data>5000)
                                {
                                    crcaamntsrmsg="Amount exceeds $5000";
                                }
                            
                                //$("#bank_transfer_amount_error").html(crcaamntsrmsg);
                                //$("#bank_transfer_amount_error").removeClass("mydisplaynone"); 
                            
                                $("#bank_transfer_amount").parent().removeClass("errorField");
                            
                                                    
                        }
                    
                        
                            
                    }
                        
                        
                        
                        
                        
                         
                         
                    if(allowbankpaymntflag==false)
                        {
                            //                            poptriggerfunc(msgtype='error',titledata='',msgdata=validation_err_msg,sd=1000,hd=1500,tmo=3000,etmo=4000,poscls='toast-top-full-width');
                            
                            return false;
                            
                        }
                         
                         
                    //****  validate form ends *******
                  
                    var callurlwithdata={
                        _token:csrf_token_data,
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
                    type:'POST',
                    dataType:'JSON',
                    success:function(d){
                     
                       // alert(JSON.stringify(d));
                       
                        var flagresp=d.flagresp;
                        var message=d.message;
                        
                        var updated_wallet_amount=d.updated_wallet_amount;
                        
                        if(flagresp=='1')
                            {
                                $("#wallet_amount_id").html("You have $"+updated_wallet_amount);
                                poptriggerfunc(msgtype='success',titledata='',msgdata="Thank you. Your Bank Account transfer was successful",sd=1000,hd=1500,tmo=3000,etmo=4000,poscls='toast-top-full-width');
                                
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
   
 
        
      

     