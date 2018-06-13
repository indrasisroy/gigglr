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
					$disdoerid4=$disputedoerartist4[0]->disdoerid4;
					$disdoername4=$disputedoerartist4[0]->disdoername4;
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
				
				if(isset($disputeid) && $disputeid!='')
				{
					if(isset($disputereplydata) && count($disputereplydata)>0)
					{
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
					}
				}
				?>