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

$faqpagedata=array();
if(!empty($faqpage))
{
	$faqpagedata=$faqpage;
}

?>

@extends('layouts.front.frontendmaster',['successmsg' => $successmsg,'errormsg'=>$errormsg])
@section('content')
	
	<section class="profile_outer text-center profile_outerA">
		<div class="container">
		
			<div class="row">
				<div class="col-sm-offset-2 col-sm-8">
					<h2 class="support_heading support_headingCustom">Dispute and Reply</h2>		
					
					<?php
					if(isset($contentmain))
					{
					?>
					
					<p class="disputereply-headcontent">
						{{$contentmain}}
					</p>
						
					<?php
					}
					?>
						
				</div>
			</div>	
			
			<div class="row review_row">
			
			
			<?php
				if(isset($sessionloggedinid) && $sessionloggedinid!=''){
					$loggedinsessionid=$sessionloggedinid;
				}
				else{
					$loggedinsessionid='';
				}
				
				if(isset($disputeopenerdetails) && count($disputeopenerdetails)>0){
					$idopener=$disputeopenerdetails["disputeopenerid"];
					$nameopener=$disputeopenerdetails["disputeopenername"];
					$mailopener=$disputeopenerdetails["disputeopenermail"];
					if($idopener!=''){
						$iddisputeopener=$idopener;
					}
					else{
						$iddisputeopener='';
					}
					if($nameopener!=''){
						$namedisputeopener=$nameopener;
					}
					else{
						$namedisputeopener='';
					}
					if($mailopener!=''){
						$maildisputeopener=$mailopener;
					}
					else{
						$maildisputeopener='';
					}
				}
				else{
					$iddisputeopener='';
					$namedisputeopener='';
					$maildisputeopener='';
				}
				
				if(isset($disputeagainstdetails) && count($disputeagainstdetails)>0){
					$againstmainiddata=$disputeagainstdetails["againstmainid"];
					$againstmainnamedata=$disputeagainstdetails["againstmainname"];
					$againstcreatoriddata=$disputeagainstdetails["againstcreatorid"];
					$againstcreatornamedata=$disputeagainstdetails["againstcreatorname"];
					$againstcreatormaildata=$disputeagainstdetails["againstcreatormail"];
					if($againstmainiddata!=''){
						$againstmainid=$againstmainiddata;
					}
					else{
						$againstmainid='';
					}
					if($againstmainnamedata!=''){
						$againstmainname=$againstmainnamedata;
					}
					else{
						$againstmainname='';
					}
					if($againstcreatoriddata!=''){
						$againstcreatorid=$againstcreatoriddata;
					}
					else{
						$againstcreatorid='';
					}
					if($againstcreatornamedata!=''){
						$againstcreatorname=$againstcreatornamedata;
					}
					else{
						$againstcreatorname='';
					}
					if($againstcreatormaildata!=''){
						$againstcreatormail=$againstcreatormaildata;
					}
					else{
						$againstcreatormail='';
					}
				}
				else{
					$againstmainid='';
					$againstmainname='';
					$againstcreatorid='';
					$againstcreatorname='';
					$againstcreatormail='';
				}
				
				if(isset($disputegigdata) && count($disputegigdata)>0)
				{
					$replybooker=$disputegigdata[0]->bookerid;
					$replyartist=$disputegigdata[0]->artistid;
					$replygigtype=$disputegigdata[0]->flagtypo;
					$gigBookerName=$disputegigdata[0]->gigBookerName;
					$gigBookerMail=$disputegigdata[0]->gigBookerMail;
					$disputegigmstruniqueid=$disputegigdata[0]->gigUniqueId;
				}
				
				if(isset($disputedoerartist4) && count($disputedoerartist4)>0)
				{
					$disdoerid4=$disputedoerartist4['disdoerid4'];
					$disdoername4=$disputedoerartist4['disdoername4'];
				}
				
				if(isset($adminset) && count($adminset)>0)
				{
					$adminconmail=$adminset[0]->contact_email;
				}
				
				if(isset($disputegigmainid) && $disputegigmainid!='')
				{
					$disputegigmstrid=$disputegigmainid;
				}
				else{
					$disputegigmstrid='';
				}
				
				if(isset($disputetypo) && $disputetypo!='')
				{
					$typedispute=$disputetypo;
				}
				else{
					$typedispute='';
				}
				
				if(isset($disputereplyallcount) && $disputereplyallcount!='')
				{
					$totalreplydata=$disputereplyallcount;
				}
				else{
					$totalreplydata=0;
				}
				
				if(isset($frontperpage) && $frontperpage!='')
				{
					$frontperpagelimit=$frontperpage;
				}
				else{
					$frontperpagelimit=0;
				}
				
				if(isset($disputeid) && $disputeid!='')
				{
					if(isset($disputereplydata) && count($disputereplydata)>0)
					{
					?>
					
					<div id="nextreply">
					
						<?php
						foreach($disputereplydata as $disputereply)
						{
							$replyid = $disputereply->replyid;
							$replydistype = $disputereply->replydistype;
							$replyby = $disputereply->replyby;
							$replyto1 = $disputereply->replyto1;
							$replyto2 = $disputereply->replyto2;
							$replycon = $disputereply->replycon;
							$replydat = $disputereply->replydt;
							$replydt = date('M d, Y h:i A',strtotime($replydat));
							
							if($replyby==1)
							{
								$replybydata='Admin reply';
							}
							else{
								if($replyby==$iddisputeopener)
								{
									if($replydistype!=4)
									{
										if($loggedinsessionid==$replyby)
										{
											$replybydata='My reply [ Booker ]';
											
										}
										else{
											$replybydata=$namedisputeopener.' reply [ Booker ]';
										}
									}
									else{
										if($loggedinsessionid==$replyby)
										{
											$replybydata='My reply [ Artist ]';
										}
										else{
											$replybydata=$namedisputeopener.' reply [ Artist ]';
										}
									}
								}
								else{
									if($replydistype==4)
									{
										if($loggedinsessionid==$replyby)
										{
											$replybydata='My reply [ Booker ]';
										}
										else{
											$replybydata=$againstmainname.' reply [ Booker ]';
										}
									}
									elseif($replydistype==1)
									{
										if($loggedinsessionid==$replyby)
										{
											$replybydata='My reply [ Artist ]';
										}
										else{
											$replybydata=$againstmainname.' reply [ Artist ]';
										}
									}
									elseif($replydistype==2)
									{
										if($loggedinsessionid==$againstcreatorid)
										{
											$replybydata='My '.$againstmainname.' group reply [ Group ]';
										}
										else{
											$replybydata=$againstmainname.' group reply [ Group ]';
										}
									}
									elseif($replydistype==3)
									{
										if($loggedinsessionid==$againstcreatorid)
										{
											$replybydata='My '.$againstmainname.' venue reply [ Venue ]';
										}
										else{
											$replybydata=$againstmainname.' venue reply [ Venue ]';
										}
									}
								}
							}
				?>

            	<div class="col-sm-12 review_cols">
					<div class="review_cell clearfix">
						<div class="col-sm-2">
							<div class="clearfix">
								<div class="">
									<div class="for-align for-left">
										{{$replybydata}}<br>{{$replydt}}
                                    </div>
								</div>
							</div>
						</div>
						<div class="col-sm-10">
							<div class="detail-text">
								{{ $replycon }}
							</div>
						</div>
					</div>
				</div>
					
				<?php
						}
						?>
						
					</div>
						
						<div id="frontloadDiv"></div>
						
						<div class="from-group" >
							<input type="hidden" name="total_data" id="total_data" value="{{$totalreplydata}}">
							<input type="hidden" name="limit" id="limit" value="{{$frontperpagelimit}}">
							<input type="hidden" name="actuallimit" id="actuallimit" value="{{$frontperpagelimit}}">
							
							<input type="hidden" id="hid_hiddisputeid" value="{{$disputeid}}">
							<input type="hidden" id="hid_hiddisputegigid" value="{{$disputegigmstrid}}">
							<input type="hidden" id="hid_hiddisputegiguniqueid" value="{{$disputegigmstruniqueid}}">
							<input type="hidden" id="hid_hiddisputetype" value="{{$typedispute}}">
							<input type="hidden" id="hid_hiddisputegigbookerid" value="{{$replybooker}}">
							<input type="hidden" id="hid_hiddisputegigartistid" value="{{$replyartist}}">
							<input type="hidden" id="hid_hiddisputegigtype" value="{{$replygigtype}}">
							
							<?php
							if($totalreplydata > $frontperpagelimit)
							{
							?>
							
								<button type="button" id="frontreplyload" class="btn btn-default btn-sm bounceIn animation-delay5" style="align:centre">Load Previous Replies</button><hr></hr>
							
							<?php
							}
							?>
						
						</div>
							
					<?php
					}
					else{
					?>
					
				<div class="col-sm-12 review_cols">
					<div class="review_cell clearfix">
						<div class="col-sm-12">
							<div class="detail-text">
								No record is available
							</div>
						</div>
					</div>
				</div>
					
					<?php
					}
				?>
						
				<div class="col-sm-12 ">
					<div class="">
						<div class="col-sm-2">
							<div class="clearfix">
								<div class="for-left">
									<div class="support-btn">
										<button type="button" id="disback1" data-disputeid="" class="btn dull-button support-btn detail-btn-view">Back</button>
                                    </div>
								</div>
							</div>
						</div>
						<div class="col-sm-8">
							<div class="detail-text">
							</div>
						</div>
						<div class="col-sm-2">
							<div class="clearfix">
								<div class="form_right">
									<div class="support-btn">
										<button type="button" id="" data-disputeid="" data-toggle="modal" data-target="#disrpl" class="btn orange-btn support-btn detail-btn-view">Reply</button>
                                    </div>
								</div>
							</div>
						</div>	
					</div>
				</div>
						
				<?php
				}
				else{
				?>
				
				<div class="col-sm-12 review_cols">
					<div class="review_cell clearfix">
						<div class="col-sm-12">
							<div class="detail-text">
								No record is available
							</div>
						</div>
					</div>
				</div>	
				<div class="col-sm-12 ">
					<div class="">
						<div class="col-sm-2">
							<div class="clearfix">
								<div class="for-left">
									<div class="support-btn">
										<button type="button" id="disback2" data-disputeid="" class="btn dull-button support-btn detail-btn-view">Back</button>
                                    </div>
								</div>
							</div>
						</div>
						<div class="col-sm-10">
							<div class="detail-text">
							</div>
						</div>	
					</div>
				</div>
					
				<?php
				}
				?>
				
			</div>	
				
		</div>
	</section>
		
		
	<div class="modal fade" id="disrpl" tabindex="-1" role="dialog">
		<div class="exportICSshow">
			<div class="modal-dialog popup-dialog" role="document">
				<div class="modal-content popup-content artist_popup">
					<div class="modal-body popup-body">
						<div class="artist_hedr request">
							<button type="button" class="close popup-close " data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							<h2 id="booking">Reply to the dispute</h2>
						</div>
						<div class="artist_form_outr clearfix">
							<div id="ridertet">
								<div class="col-md-12 margintop20">
									<!-- <div class="inline artist_list">-->
										<!--<div class="input-group input-daterange">-->
										<?php echo Form::open(array('method' => 'post','id'=>'frontdisputereplyfrm' )); ?>
											<label class="radio-check amenitiesCheck">
												<input type="checkbox" value="1" name="admincheck[]" id="admincheck" class="checkboxcheck_admin">
												<span></span>Admin
											</label>
											<input type="hidden" id="adminemailid" value="{{$adminconmail}}">	
									<?php
									if($loggedinsessionid==$idopener)
									{
										if($typedispute==1 || $typedispute==4)
										{
										?>
											<label class="radio-check amenitiesCheck">
												<input type="checkbox" class="checkboxcheck_opponent" value="{{$againstmainid}}" name="opponentcheck[]" id="opponentcheck">
												<span></span>{{$againstmainname}}
											</label>
											<input type="hidden" id="opponentemailid" value="{{$againstcreatormail}}">
										<?php
										}
										elseif($typedispute==2 || $typedispute==3)
										{
										?>
											<label class="radio-check amenitiesCheck">
												<input type="checkbox" class="checkboxcheck_opponent" value="{{$againstcreatorid}}" name="opponentcheck[]" id="opponentcheck">
												<span></span>{{$againstmainname}}
											</label>
											<input type="hidden" id="opponentemailid" value="{{$againstcreatormail}}">
										<?php
										}
									}
									else{
										if($typedispute!=4)
										{
										?>
											<label class="radio-check amenitiesCheck">
												<input type="checkbox" class="checkboxcheck_opponent" value="{{$replybooker}}" name="opponentcheck[]" id="opponentcheck">
												<span></span>{{$gigBookerName}}
											</label>
											<input type="hidden" id="opponentemailid" value="{{$gigBookerMail}}">
										<?php
										}
										else{
										?>
											<label class="radio-check amenitiesCheck">
												<input type="checkbox" class="checkboxcheck_opponent" value="{{$iddisputeopener}}" name="opponentcheck[]" id="opponentcheck">
												<span></span>{{$namedisputeopener}}
											</label>
											<input type="hidden" id="opponentemailid" value="{{$maildisputeopener}}">	
										<?php
										}
									}
									?>	
											
											<textarea id="opponent_description" class="form-group inpt nb form-control" name="opponent_description" cols="50" rows="10"></textarea>
												
											<input type="hidden" id="hiddisputeid" value="{{$disputeid}}">
											<input type="hidden" id="hiddisputegigid" value="{{$disputegigmstrid}}">
											<input type="hidden" id="hiddisputegiguniqueid" value="{{$disputegigmstruniqueid}}">
											<input type="hidden" id="hiddisputetype" value="{{$typedispute}}">
											<input type="hidden" id="hiddisputegigbookerid" value="{{$replybooker}}">
											<input type="hidden" id="hiddisputegigartistid" value="{{$replyartist}}">
											<input type="hidden" id="hiddisputegigtype" value="{{$replygigtype}}">
											<input type="hidden" name="hidmodlimit" id="hidmodlimit" value="{{$frontperpagelimit}}">
											
											<button type="button" class="btn export-button-width export-data-button" id="subreply">Submit</button>
										<?php echo Form::close(); ?>
									   <!--</div>-->
									<!--</div>-->
								</div>   
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
		
@endsection