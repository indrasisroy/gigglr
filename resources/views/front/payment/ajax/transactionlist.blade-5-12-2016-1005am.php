<?php

// echo "<pre>"; print_r($user_trans_data);  echo "</pre>";
 if(!empty($user_trans_data))
 {
     $grandtotal=0;
      foreach($user_trans_data as $user_trans_data)
	  {
          
          
                    $debit_price=0; $credit_price=0;
          
					 $payment_for=$user_trans_data->payment_for;
					 $charge_token=$user_trans_data->charge_token;
					 $payment_description=$user_trans_data->payment_description;
					 $payment_scheme=$user_trans_data->payment_scheme;
					 $debitorcredit=$user_trans_data->debitorcredit;
					 
					 $invoice_num=$user_trans_data->invoice_num;
                     $create_date=$user_trans_data->create_date;
                     $total_price=$user_trans_data->total_price;
                     $gigmaster_id=$user_trans_data->gigmaster_id;
                     $giguniqueid=$user_trans_data->giguniqueid;
          
                    /*
                    W=>PAYMENT TO WALLET,BP=>PAYMENT TO BANK, EBA=> ESCROWED FOR ARTIST FOR BOOKING REQUEST, EBG=>ESCROWED FOR GROUP FOR BOOKING REQUEST, EBV => ESCROWED FOR VENUE FOR BOOKING REQUEST , EGA=> ESCROWED FOR ARTIST FOR GIG REQUEST, EGG=>ESCROWED FOR GROUP FOR GIG REQUEST , COM=>COMMISSION , DPR=>Dispute payment release ,MPR=>Manual Payment release ,AFPR=>Automated Full Payment Release,APPR=>Automated Partial Payment Release, CPR=> Cancellation payment release , SCP=>Site Commission payment , RD=>Referal Debit, RC=>Referal Credit
                    */
          
                    $activity_summary=''; 
          
                    if($payment_for=='W')
                    {
                        $activity_summary="Funds Added to Wallet";
                    }
                    elseif($payment_for=='BP')
                    {
                       $activity_summary="Transferred to Bank";
                    }
                    elseif($payment_for=='EBA') //** escrowed for artist for booking request 
                    {
                         //$appenddatatoactivity=1000000+$gigmaster_id;
                         //$activity_summary="EVE-A".$appenddatatoactivity;  
                        $activity_summary=$giguniqueid;
                    }
                    elseif($payment_for=='EBG') //** escrowed for group for booking request 
                    {
                         //$appenddatatoactivity=1000000+$gigmaster_id;
                         //$activity_summary="EVE-G".$appenddatatoactivity;  
                        $activity_summary=$giguniqueid;
                    }
                    elseif($payment_for=='EBV') //** escrowed for venue for booking request 
                    {
                        //$appenddatatoactivity=1000000+$gigmaster_id;
                        // $activity_summary="EVE-V".$appenddatatoactivity; 
                        $activity_summary=$giguniqueid;

                    }
                    elseif($payment_for=='EGA') //** escrowed for artist for gig request 
                    {
                        //$appenddatatoactivity=1000000+$gigmaster_id;
                         //$activity_summary="GIG-A".$appenddatatoactivity; 
                        $activity_summary=$giguniqueid;
                    }
                    elseif($payment_for=='EGG') //** escrowed for group for gig request 
                    {
                         //$appenddatatoactivity=1000000+$gigmaster_id;
                         //$activity_summary="GIG-G".$appenddatatoactivity;
                        $activity_summary=$giguniqueid;

                    }
                    elseif($payment_for=='SCP')
                    {
                       $activity_summary="Site Commission payment";
                    }
                    elseif($payment_for=='DPR')
                    {
                       $activity_summary="Dispute payment release";
                    }
                    elseif($payment_for=='RC')
                    {
                       $activity_summary="Referal Credit";
                    }
                    elseif($payment_for=='RD')
                    {
                       $activity_summary="Referal Debit";
                    }

                
          
          
                    if($debitorcredit=='D')
                    {
                        $debit_price=$total_price; 
                        $credit_price=0;
                    }
                    elseif($debitorcredit=='C')
                    {
                        $debit_price=0; 
                        $credit_price=$total_price;
                    }
					  
					
?>


                    <tr>
                                                    <td>
                                                        <div class="lett-spac">
                                                        <span> <?php echo date("d-m-y",strtotime($create_date)); ?></span>
                                                        <span><?php echo date("H:i",strtotime($create_date)); ?></span>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <span class=""><?php echo $activity_summary; ?></span>
                                                    </td>
                                                    <td>
                                                        <?php if(!empty($debit_price)){ ?>
                                                        <span class="lett-spac">$<?php echo $debit_price; ?></span>
                                                        <?php } ?>
                                                    </td>
                                                    <td>
                                                         <?php if(!empty($credit_price)){ ?>
                                                        <span class="lett-spac">$<?php echo $credit_price; ?></span>
                                                        <?php } ?>

                                                    </td>
                                                </tr>
                


                    <?php
                    }
}
?>