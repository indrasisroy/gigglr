<?php
$successmsg='';$errormsg='';
if(!empty($successmsgdata))
{
        $successmsg=$successmsgdata;
}

if(!empty($errormsgdata))
{
        $errormsg=$errormsgdata;
}

?>
@extends('layouts.admin.adminmaster',['successmsg' => $successmsg,'errormsg'=>$errormsg])
@section('content')
			<div class="padding-md">
				<div class="row">
					<div class="col-md-12">
						
										<div class="panel panel-default table-responsive">
					<div class="panel-heading">
						Transaction List
						<span class="pull-right"><a type="button" class="btn btn-xs btn-success" href="<?php echo  url(ADMINSEPARATOR.'/user'); ?>" >Back to user list</a></span>
					</div>
					<div class="panel-body">
						<div class="row">
							<div class="col-md-4 col-sm-4">
							 
							<?php echo Form::open(array('url' => ADMINSEPARATOR.'/transctiondeatils/'.$userid, 'method' => 'get','id'=>'userslistsearch','class'=>"form-horizontal form-border no-margin")); ?>
							<div class="input-group">
							<?php
								$srch1=''; $sort1=''; $sorttype1='ASC';
								$default_srt_class1="fa fa-sort fa-sm";
								if( !empty($useinPagiAr) && array_key_exists('srch1',$useinPagiAr))
								{
												$srch1=$useinPagiAr['srch1'];
								}
								if( !empty($useinPagiAr) && array_key_exists('sorttype1',$useinPagiAr))
								{
												$sorttype1=$useinPagiAr['sorttype1']; // original sort type  ASC or DESC
												
												if(!empty($sorttype1) && ($sorttype1=="ASC") )
												{
																$default_srt_class1="fa fa-sort-desc fa-sm";
												}
												elseif(!empty($sorttype1) && ($sorttype1=="DESC") )
												{
													  
													   $default_srt_class1="fa fa-sort-asc fa-sm";	
												}
												
								}
								
								if( !empty($useinPagiAr) && array_key_exists('sort1',$useinPagiAr))
								{
												$sort1=$useinPagiAr['sort1'];											
												
												
								}
								?>
							   
								<?php echo Form::text("srch1", $value=$srch1, $attributes = array( "id"=>"srch1","class"=>" form-control input-sm ","placeholder"=>"Search by Invoice")); ?>
								<?php echo Form::hidden("sort1", $value=$sort1, $attributes = array( "id"=>"sort1","class"=>" form-control input-sm ")); ?>
								<?php echo Form::hidden("sorttype1", $value=$sorttype1, $attributes = array( "id"=>"sorttype1","class"=>" form-control input-sm ")); ?>
								
									<div class="input-group-btn">
										<button tabindex="-1" style="margin-right:10px;" class="btn btn-sm btn-success" type="button" id="srchbuttonuser">Search</button>
										<button tabindex="-1" type="button" class="btn btn-sm btn-info" id="clearsearch">Clear Search</button>	
									</div> <!-- /input-group-btn -->
							    </div>
									<?php echo Form::close(); ?>
							</div><!-- /.col -->
						</div><!-- /.row -->
					</div>
					<table class="table table-striped" id="responsiveTable">
						<thead>
							<tr>
								<!--<th>Name</th>-->
								<th>Date and time</th>
								<th>Invoice Number</th>
								<th>Activity Summary </th>
								<th>Debit </th>
								<th>Credit </th>
							</tr>
						</thead>
						<tbody>
						<?php
						
						if(!empty($pagi_user) && ( $pagi_user->count()>0 ) )
						{
							foreach($pagi_user as $user_trans_data)
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
                    W=>PAYMENT TO WALLET,BP=>PAYMENT TO BANK, EA=> ESCROWED  FOR ARTIST, EG=>ESCROWED  FOR GROUP , EV => ESCROWED  FOR VENUE 
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
                         // $appenddatatoactivity=1000000+$gigmaster_id;
                         // $activity_summary="EVE-A".$appenddatatoactivity;  
                    	$activity_summary=$giguniqueid;
                    }
                    elseif($payment_for=='EBG') //** escrowed for group for booking request 
                    {
                         // $appenddatatoactivity=1000000+$gigmaster_id;
                         // $activity_summary="EVE-G".$appenddatatoactivity;  
                    	 $activity_summary=$giguniqueid;
                    }
                    elseif($payment_for=='EBV') //** escrowed for venue for booking request 
                    {
                        // $appenddatatoactivity=1000000+$gigmaster_id;
                        //  $activity_summary="EVE-V".$appenddatatoactivity; 
                        $activity_summary=$giguniqueid;

                    }
                    elseif($payment_for=='EGA') //** escrowed for artist for gig request 
                    {
                        // $appenddatatoactivity=1000000+$gigmaster_id;
                        //  $activity_summary="GIG-A".$appenddatatoactivity; 
                         $activity_summary=$giguniqueid;
                    }
                    elseif($payment_for=='EGG') //** escrowed for group for gig request 
                    {
                         // $appenddatatoactivity=1000000+$gigmaster_id;
                         // $activity_summary="GIG-G".$appenddatatoactivity; 
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
						?>
						
							<tr>
								<td>
									<span> <?php echo date("d-m-y",strtotime($create_date)); ?></span>
                                    <span><?php echo date("H:i",strtotime($create_date)); ?></span>
								</td>
								<td>
								 <?php if(!empty($invoice_num)){ ?>
                                                        <span class="lett-spac"><?php echo $invoice_num; ?></span>
                                     <?php }else{ echo "----"; } ?>
								</td>
								<td>
									<span class=""><?php echo $activity_summary; ?></span>
								</td>
								<td>
									 <?php if(!empty($debit_price)){ ?>
                                                        <span class="lett-spac">$<?php echo $debit_price; ?></span>
                                     <?php }else{ echo "----"; } ?>
								</td>

								<td>
									<?php if(!empty($credit_price)){ ?>
                                                        <span class="lett-spac">$<?php echo $credit_price; ?></span>
                                   	<?php }else{ echo "----"; } ?>
								</td>
								 
							</tr>
								
							<?php
							}	

						}
						else{
						?>
							
							<tr><td colspan="5">No Transaction record found!</td></tr>
							
						<?php
						}
						?>
						</tbody>
					</table>


					<?php 

					if(!empty($pagi_user) && ( $pagi_user->count()>0 ) )
						{

					?>

					<table class="table table-striped">
					<thead>

							<tr>
								<th></th>
								
								<th>Total</th>
								
								<th><?php echo '$'.$total_debit; ?> </th>

								<th style="width: 10px;padding-right: 83px;"><?php echo '$'.$total_credit; ?></th>
							</tr>

							<tr>
								<th></th>
								
								<th>Wallet Balance</th>
								
								<th style="width: 10px;padding-right: 106px;"> </th>

								<th style="width: 10px;padding-right: 80px;float: right;"><?php echo '$'.$now_wallet_balance; ?></th>
							</tr>
						</thead>

					</table>


<?php 
}
?>



					<div class="panel-footer clearfix">
					<?php echo $pagi_user->appends($useinPagiAr)->render(); ?>
					</div>
				</div><!-- /panel -->

						
					</div>
					</div>
			</div><!-- /.padding-md -->
			
			









<script>

	jQuery(document).ready(function(){
	
		jQuery(".sorttrackclass").click(function(){
		
			sortname = jQuery(this).data('sortname');
			sorttype = jQuery(this).data('sorttype');
			
			if (sorttype == 'ASC') {
					setsorttype = 'DESC';
			}
			else{
					setsorttype = 'ASC';
			}
			
			jQuery("#sort1").val(sortname);
			jQuery("#sorttype1").val(setsorttype);
			jQuery('#userslistsearch').submit();
			
		});
	
		jQuery("#srchbuttonuser").click(function(){			
			var srch1data=jQuery("#srch1").val();
			if (srch1data=='')
			{
						jQuery("#sort1").val('');
						jQuery("#sorttype1").val('');
						
						window.location.href="<?php echo url(ADMINSEPARATOR.'/transctiondeatils/'.$userid);?>";
						//location.reload();	
			}
			else
			{
						jQuery("#userslistsearch").submit();
			}
					
		});
		
		
	});


jQuery("#clearsearch").click(function(){						
	// location.reload();						
	window.location.href="<?php echo url(ADMINSEPARATOR.'/transctiondeatils/'.$userid);?>";
});


</script>
<!-- <script type="text/javascript" src="{{ ADMINCSSPATH}}/otherfiles/progjs/userlist.js"></script> -->
	
@endsection