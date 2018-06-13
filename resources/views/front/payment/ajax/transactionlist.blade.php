<?php

// echo "<pre>"; print_r($user_trans_data);  echo "</pre>";
 if(!empty($user_trans_data))
 {
     $grandtotal=0;
     
      foreach($user_trans_data as $user_trans_data)
	  {
          
                   
                    $debit_price=0; $credit_price=0;
          
                      $ordid=$user_trans_data->id;
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
                     $refund_status=$user_trans_data->refund_status;
                     $charge_token=$user_trans_data->charge_token;
                     $refund_resp_token=$user_trans_data->refund_resp_token;
          
                     $create_date_tz=$user_trans_data->create_date_tz;
                    //$local_tz_data
          
          
                    if (fmod($total_price, 1) == 0) 
                        {
                             //echo "no decimal";
                            $total_price=intval($total_price);
                            
                        }
          
                    /*
                   W=>PAYMENT TO WALLET,BP=>PAYMENT TO BANK, EBA=> ESCROWED  FOR ARTIST FOR BOOKING REQUEST, EBG=>ESCROWED  FOR GROUP FOR BOOKING REQUEST, EBV => ESCROWED  FOR VENUE FOR BOOKING REQUEST ,           EGA=> ESCROWED  FOR ARTIST FOR GIG REQUEST, EGG=>ESCROWED  FOR GROUP FOR GIG REQUEST , COM=>COMMISSION , DPR=>Dispute payment release ,MPR=>Manual Payment release ,AFPR=>Automated Full Payment Release,APPR=>Automated Partial Payment Release, CPR=> Cancellation payment release , SCP=>Site Commission payment , RD=>Referal Debit, RC=>Referal Credit 
                    */
          
                    $activity_summary=''; 
          
                    if($payment_for=='W')
                    {
                        $activity_summary="Funds added to wallet";
                    }
                    elseif($payment_for=='BP')
                    {
                       $activity_summary="Transferred to bank";
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
                       $activity_summary="Site commission ".$giguniqueid;
                    }
                    elseif($payment_for=='DPR')
                    {
                       $activity_summary="Dispute payment released for ".$giguniqueid;
                    }
                    elseif($payment_for=='RC')
                    {
                       $activity_summary="Referral credit for ".$giguniqueid;
                    }
                    elseif($payment_for=='RD')
                    {
                       $activity_summary="Referral debit for ".$giguniqueid;
                    }
                    elseif($payment_for=='AFPR')
                    {
                       $activity_summary="Automated full payment released";
                    }  
                    elseif($payment_for=='APPR')
                    {
                       $activity_summary="Payment released for ".$giguniqueid;
                    }  
                    elseif($payment_for=='MPR')
                    {
                       $activity_summary="Manual payment released";
                    }
                     elseif($payment_for=='CPR')
                    {
                       $activity_summary="Cancellation payment released for ".$giguniqueid;
                    } 
                    elseif($payment_for=='SMR')
                    {
                       $activity_summary="Security money released for ".$giguniqueid;
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
          
                    
         if(!empty($local_tz_data))
                            {
    $revdtcnv= convertdatetothistz($dttm=$create_date,$ftmzn=$create_date_tz,$ttmzn=$local_tz_data,$cnvrtdtdrmt='Y-m-d H:i:s');
                                if(array_key_exists('converteddatetime',$revdtcnv))
                                {
                                    $create_date=$revdtcnv['converteddatetime'];
                                }
                                
                               
                                
                                
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
                                                        
                                                        <?php 
                                                        $refund_msg=''; $custrefundclass='';
                                                            if($payment_for=="W")
                                                            {
                                                                if( $refund_status==1)
                                                                {
                                                                    $refund_msg="Refunded";
                                                                }
                                                                elseif( $refund_status==2)
                                                                {
                                                                    $refund_msg="Refund is under pending";
                                                                    $custrefundclass=" refundpendcls ";
                                                                }
                                                                elseif( $refund_status==3)
                                                                {
                                                                    $refund_msg="Refund cancelled";
                                                                }
                                                                elseif( $refund_status==0)
                                                                {
                                                                    $refund_msg="Click to refund ";
                                                                    $custrefundclass=" custrefundclass ";
                                                                }
                                                                
                                                                
                                                            }
                                                        ?>
                                                        
                                                        <?php if($payment_for=="W"){ ?> 
                                                        <p class="new_refund_cust_class"><a id="orderanc_<?php echo $ordid; ?>" class="<?php echo $custrefundclass; ?>"  data-refundstatus="<?php echo $refund_status; ?>" data-paymentfor="<?php echo $payment_for; ?>" data-uordid="<?php echo $ordid; ?>" data-amount="<?php echo $total_price; ?>"   href='javascript:void(0);'><span id="refund_msg_<?php echo $ordid; ?>"><?php echo $refund_msg; ?></span></a></p> 
                                                        <?php }?>
                                                        
                                                       
                                                        
                                                    </td>
                                                    <td>
                                                        
                                                        <?php if(!empty($debit_price)){ ?>
                                                        <span id="debit_<?php echo $ordid; ?>" class="lett-spac debitamountclscust">
                                                            $<?php echo $debit_price; ?>
                                                         
                                                        </span>
                                                        <?php } ?>
                                                        
                                                        <?php if($payment_for=="W" && ( $refund_status==0) ) { ?>
                                                        <span id="debit_<?php echo $ordid; ?>" class="lett-spac"></span>
                                                        <?php } ?>
                                                        
                                                        
                                                        <?php if($payment_for=="W" && ( $refund_status==1 ||  $refund_status==2) ) { ?>
                                                        <span class="lett-spac">
                                                            $<?php echo $total_price; ?>
                                                            
                                                        </span>
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