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
  
	
	<!-- profile-section-start -->
	<section class="profile_outer text-center profile_outerA">
		<div class="container">
			<div class="row">
				<div class="col-sm-offset-2 col-sm-8">
					<h2 class="support_heading support_headingCustom">SUPPORT</h2>		
					<p class="sub_para">
						Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt 
					</p>	
				</div>
			</div>	
			<div class="row">
				<div class="col-sm-offset-2 col-sm-8">
					<div class="row faq_cols_outer faq_cols_outerCustom">
                        <div class="col-sm-4 col-xs-4">
                            <span class="faq_cols faq_col3">
							<a href="javascript:void(0);" id="disputeurl" >RESOLVE A DISPUTE</a>
                            </span>
						</div>
						<div class="col-sm-4 col-xs-4">
                            <span class="faq_cols">
                                <a href="javascript:void(0);" id="contact_support" >CONTACT SUPPORT</a>
                            </span>
						</div>
						<div class="col-sm-4 col-xs-4">
                            <span class="faq_cols faq_col2">
                                <a href="javascript:void(0);" id="helpurl">Site Help</a>
                            </span>
						</div>
					</div>					
				</div>
			</div>
			
            <h2 class="watch_heading watch_heading-custom-2" id="contact_supportid">CONTACT SUPPORT</h2>
            <div class="row">
                <div class="col-sm-offset-2 col-sm-8">
				<?php echo Form::open(array('files' => true, 'method' => 'post','id'=>'contactsupportfrmid','class'=>"" )); ?>
                    <div class="custom-formIn xe-class">
                        <div class="inputForum clearfix">
							<label>Contact reason *</label>
							<div class="from-control-custom">
								<!--<select class="selectpicker">
                                    <option value="0">Country</option>
                                    <option value="1">India</option>
                                    <option value="2">Germany</option>
                                    <option value="3">Dubai</option>
                                </select>-->
									
								<?php
								$control_attrAr=array();
								$control_attrAr['id']='contactreason';
								$control_attrAr['class']="selectpicker";
								$control_attrAr['title']="Choose the reason";
								$contactreason='';
								
								$fetchcontactreasonArData=array();
								if(!empty($reasonarr)){
									foreach($reasonarr as $rsnarr){
										$fetchcontactreasonArData[$rsnarr['element']]=$rsnarr['content'];
									}
								}
								else{
									$fetchcontactreasonArData[0]='No reason is available';
								}
							  
								echo Form::select('contactreason',
								$fetchcontactreasonArData,
								$contactreason,
								$control_attrAr
								);							
								?>
									
                            </div>
                        </div>
                             <div class="inputForum clearfix">
                                <label>First Name *</label>
                                 <div class="from-control-custom">
                                     <input type="text" class="form-control" name="confname" id="confname">
                                 </div>
                            </div>
                         <div class="inputForum clearfix">
                                <label>Last Name</label>
                                 <div class="from-control-custom">
                                     <input type="text" class="form-control" name="conlname" id="conlname">
                                 </div>
                            </div>
                         <div class="inputForum clearfix">
                                <label>E-Mail Address *</label>
                                 <div class="from-control-custom">
                                     <input type="text" class="form-control" name="conemail" id="conemail">
                                 </div>
                            </div>
                         <div class="inputForum clearfix">
                                <label>Your Message *</label>
                                 <div class="from-control-custom from-control-custom-2">
                                     <textarea class="form-control" name="condesc" id="condesc"></textarea>
                                 </div>
                            </div>
                        <div class="inputForum clearfix">
                        <div class="leftI">
                        <div class="inputForum clearfix send-copy">
                            <label>Request response</label>
                            <div class="from-control-custom">
                                <div class="inlineWrap extra-margin">
                                    <div class="inline">
                                       <label class="radio-check"><!--<input type="radio" name="na" />-->
									   <?php $yes=''; echo Form::radio('reqres', '1', $yes, $attributes = array("id"=>"reqres1","class"=>"")); ?>
                                         <span></span>Yes</label>
                                      </div>
                                        <div class="inline">
                                            <label class="radio-check"><!--<input type="radio" name="na" />-->
											<?php $no=''; echo Form::radio('reqres', '0', $no, $attributes = array("id"=>"reqres2","class"=>"")); ?>
                                            <span></span>No</label>
                                        </div>
                                 </div>
                             </div>
                        </div>
                            <div class="inputForum clearfix send-copy">
                            <label>Send me a copy</label>
                            <div class="from-control-custom">
                                <div class="inlineWrap extra-margin">
                                    <div class="inline">
                                       <label class="radio-check"><!--<input type="radio" name="nb" checked="checked">-->
									   <?php $yes=''; echo Form::radio('mecopy', '1', $yes, $attributes = array("id"=>"mecopy1","class"=>"")); ?>
                                         <span></span>Yes</label>
                                      </div>
                                        <div class="inline">
                                            <label class="radio-check"><!--<input type="radio" name="nb" checked="checked">-->
											<?php $no=''; echo Form::radio('mecopy', '0', $no, $attributes = array("id"=>"mecopy2","class"=>"")); ?>
                                            <span></span>No</label>
                                        </div>
                                 </div>
                             </div>
                        </div>
                       </div>
						
                            <div class="rightI">
                            <div class="support-btn support-btn-custom">
                                <a class="btn orange-btn support-btn" id="consupsub" href="javascript:void(0);">Send To Support</a>
                            </div>
                        </div>
                        </div>
                     </div>
						<?php echo Form::close();?>
                </div>
            </div>
            
        <h2 class="watch_heading watch_heading-custom-2" id="disputeid">Resolve a dispute</h2>
            <div class="row">
			<div class="col-sm-offset-2 col-sm-8">
                <div class="resolve-innar" id="resolve-sec">
					<div id="accordion" class="panel-group row text-left">
							<div class="panel panel-default">				
						        <a data-toggle="collapse" class="accordian_nav collapsed" data-parent="#accordion" href="#collapse13">1. Resolve an issue with an artist</a>					
						        <div id="collapse13" class="panel-collapse collapse">					
                                   <?php echo Form::open(array('files' => true, 'method' => 'post','id'=>'againstartistfrmid','class'=>"" )); ?>
                                    <div class="panel-body">					
						                <div class="row panel-bodyA">
                                            <div class="col-sm-9">
                                                <h4>Did the artist arrive on time?</h4>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="inlineWrap extra-margin">
                                                    <div class="inline">
                                                        <label class="radio-check">
														<!--<input type="radio" name="arrive" />-->
														<?php $yes=''; echo Form::radio('arrive', '1', $yes, $attributes = array("id"=>"arrive1","class"=>"")); ?>
                                                        <span></span>Yes</label>
                                                    </div>
                                                    <div class="inline">
                                                        <label class="radio-check">
														<!--<input type="radio" name="arrive" />-->
                                                        <?php $no=''; echo Form::radio('arrive', '2', $no, $attributes = array("id"=>"arrive2","class"=>"")); ?>
														<span></span>No</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row panel-bodyA">
                                            <div class="col-sm-9">
                                                <h4>What time did you arrive?</h4>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class='input-group date' id='datetimepicker3'>
                                                    <input type='text' id="arrivaltime" class="form-control clck_outr timepicker" placeholder="12.00 am"/>
                                                    <span class="input-group-addon clck">
                                                        <span class="glyphicon glyphicon-time"></span>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row panel-bodyA">
                                            <div class="col-sm-9">
                                                <h4>Were the artists required specifications available?</h4>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="inlineWrap extra-margin">
                                                    <div class="inline">
                                                        <label class="radio-check">
														<!--<input type="radio" name="specification" />-->
                                                        <?php $yes=''; echo Form::radio('specification', '1', $yes, $attributes = array("id"=>"specification1","class"=>"")); ?>
														<span></span>Yes</label>
                                                    </div>
                                                    <div class="inline">
                                                        <label class="radio-check">
														<!--<input type="radio" name="specification" />-->
                                                        <?php $no=''; echo Form::radio('specification', '2', $no, $attributes = array("id"=>"specification2","class"=>"")); ?>
														<span></span>No</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row panel-bodyA">
                                            <div class="col-sm-9">
                                                <h4>Were the artists able to complete the performance?</h4>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="inlineWrap extra-margin">
                                                    <div class="inline">
                                                        <label class="radio-check">
														<!--<input type="radio" name="performance" />-->
														<?php $yes=''; echo Form::radio('performance', '1', $yes, $attributes = array("id"=>"performance1","class"=>"")); ?>
                                                        <span></span>Yes</label>
                                                    </div>
                                                    <div class="inline">
                                                        <label class="radio-check">
														<!--<input type="radio" name="performance" />-->
														<?php $no=''; echo Form::radio('performance', '2', $no, $attributes = array("id"=>"performance2","class"=>"")); ?>
                                                        <span></span>No</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row panel-bodyA">
                                            <div class="col-sm-9">
                                                <h4>Were there any technical issues during the performance?</h4>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="inlineWrap extra-margin">
                                                    <div class="inline">
                                                        <label class="radio-check">
														<!--<input type="radio" name="technical" />-->
														<?php $yes=''; echo Form::radio('technical', '1', $yes, $attributes = array("id"=>"technical1","class"=>"")); ?>
                                                        <span></span>Yes</label>
                                                    </div>
                                                    <div class="inline">
                                                        <label class="radio-check">
														<!--<input type="radio" name="technical" />-->
                                                        <?php $no=''; echo Form::radio('technical', '2', $no, $attributes = array("id"=>"technical2","class"=>"")); ?>
														<span></span>No</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row panel-bodyA">
                                            <div class="col-sm-9">
                                                <h4>Did the artist receive their rider?</h4>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="inlineWrap extra-margin">
                                                    <div class="inline">
                                                        <label class="radio-check">
														<!--<input type="radio" name="rider" checked="checked">-->
                                                        <?php $yes=''; echo Form::radio('rider', '1', $yes, $attributes = array("id"=>"rider1","class"=>"")); ?>
														<span></span>Yes</label>
                                                    </div>
                                                    <div class="inline">
                                                        <label class="radio-check">
														<!--<input type="radio" name="rider" checked="checked">-->
                                                        <?php $no=''; echo Form::radio('rider', '2', $no, $attributes = array("id"=>"rider2","class"=>"")); ?>
														<span></span>No</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row panel-bodyA">
                                            <div class="col-sm-9">
                                                <h4>Did the artist leave early?</h4>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="inlineWrap extra-margin">
                                                    <div class="inline">
                                                        <label class="radio-check">
														<!--<input type="radio" name="leave" />-->
                                                        <?php $yes=''; echo Form::radio('leave', '1', $yes, $attributes = array("id"=>"leave1","class"=>"")); ?>
														<span></span>Yes</label>
                                                    </div>
                                                    <div class="inline">
                                                        <label class="radio-check">
														<!--<input type="radio" name="leave" />-->
														<?php $no=''; echo Form::radio('leave', '2', $no, $attributes = array("id"=>"leave2","class"=>"")); ?>
                                                        <span></span>No</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="row panel-bodyA">
                                            <div class="col-sm-9">
                                                <h4>What time did the artist(s) leave?</h4>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class='input-group date' id='datetimepicker3'>
                                                    <input type='text' id="leavetime" class="form-control clck_outr timepicker" placeholder="12.00 am"/>
                                                    <span class="input-group-addon clck">
                                                        <span class="glyphicon glyphicon-time"></span>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
											
										<div class="row panel-bodyA">
                                            <div class="col-sm-9">
                                                <h4>Select the artist</h4>
                                            </div>
                                            <div class="col-sm-3">
                                                <?php
								$control_attrAr=array();
								$control_attrAr['id']='againstartist';
								$control_attrAr['class']="selectpicker artist_txt";
								$control_attrAr['title']="Choose the event";
								$againstartist_def='';
								
								$fetchagainstartistArData=array();
								if(!empty($against_artist)){
									foreach($against_artist as $againstartist){
										$fetchagainstartistArData[$againstartist['element']]=$againstartist['content'];
									}
								}
								else{
									$fetchagainstartistArData[0]='No event is available';
								}
							  
								echo Form::select('againstartist',
								$fetchagainstartistArData,
								$againstartist_def,
								$control_attrAr
								);							
								?>
                                            </div>
                                        </div>
                                        
                                        <div class="issue-zone">
                                            <div class="issue-text">
                                               <textarea class="form-control" id="summary" name="summary" placeholder="In your own words (500 characters max). Please describe the issue."></textarea>
                                            </div>
                                        </div>
                                        
                                        <div class="clearfix book-support-col"> 
                                            <div class="rightI">
                                                <div class="support-btn">
                                                  <!--<a class="btn orange-btn support-btn" href="#">Send To Support</a>-->
												  <button type="button" id="artistsub" class="btn orange-btn support-btn">Send To Support</button>
                                                </div>
                                            </div>
                                        </div>
						            </div>
                                    <?php echo Form::close();?> 				
						        </div>					
						    </div>
						    <div class="panel panel-default">				
						        <a data-toggle="collapse" class="accordian_nav collapsed" data-parent="#accordion" href="#collapse14">2. Resolve an issue with a group</a>					
						        <div id="collapse14" class="panel-collapse collapse">					
						             <?php echo Form::open(array('files' => true, 'method' => 'post','id'=>'againstgroupfrmid','class'=>"" )); ?>
                                    <div class="panel-body">					
						                <div class="row panel-bodyA">
                                            <div class="col-sm-9">
                                                <h4>Did the group arrive on time?</h4>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="inlineWrap extra-margin">
                                                    <div class="inline">
                                                        <label class="radio-check">
														<!--<input type="radio" name="gArrive" />-->
														<?php $yes=''; echo Form::radio('grouparrive', '1', $yes, $attributes = array("id"=>"grouparrive1","class"=>"")); ?>
                                                        <span></span>Yes</label>
                                                    </div>
                                                    <div class="inline">
                                                        <label class="radio-check">
														<!--<input type="radio" name="gArrive" />-->
														<?php $no=''; echo Form::radio('grouparrive', '2', $no, $attributes = array("id"=>"grouparrive2","class"=>"")); ?>
                                                        <span></span>No</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row panel-bodyA">
                                            <div class="col-sm-9">
                                                <h4>What time did you arrive?</h4>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class='input-group date' id='datetimepicker3'>
                                                    <input type='text' id="grouparrivaltime" class="form-control clck_outr timepicker" placeholder="12.00 am"/>
                                                    <span class="input-group-addon clck">
                                                        <span class="glyphicon glyphicon-time"></span>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row panel-bodyA">
                                            <div class="col-sm-9">
                                                <h4>Was the groups required specifications available?</h4>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="inlineWrap extra-margin">
                                                    <div class="inline">
                                                        <label class="radio-check">
														<!--<input type="radio" name="gSpecification" />-->
                                                        <?php $yes=''; echo Form::radio('groupspecification', '1', $yes, $attributes = array("id"=>"groupspecification1","class"=>"")); ?>
														<span></span>Yes</label>
                                                    </div>
                                                    <div class="inline">
                                                        <label class="radio-check">
														<!--<input type="radio" name="gSpecification" />-->
                                                        <?php $no=''; echo Form::radio('groupspecification', '2', $no, $attributes = array("id"=>"groupspecification2","class"=>"")); ?>
														<span></span>No</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row panel-bodyA">
                                            <div class="col-sm-9">
                                                <h4>Was the group able to complete the performance?</h4>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="inlineWrap extra-margin">
                                                    <div class="inline">
                                                        <label class="radio-check">
														<!--<input type="radio" name="gPerformance" />-->
                                                        <?php $yes=''; echo Form::radio('groupperformance', '1', $yes, $attributes = array("id"=>"groupperformance1","class"=>"")); ?>
														<span></span>Yes</label>
                                                    </div>
                                                    <div class="inline">
                                                        <label class="radio-check">
														<!--<input type="radio" name="gPerformance" />-->
                                                        <?php $no=''; echo Form::radio('groupperformance', '2', $no, $attributes = array("id"=>"groupperformance2","class"=>"")); ?>
														<span></span>No</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row panel-bodyA">
                                            <div class="col-sm-9">
                                                <h4>Were there any technical issues during the performance?</h4>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="inlineWrap extra-margin">
                                                    <div class="inline">
                                                        <label class="radio-check">
														<!--<input type="radio" name="gTechnical" />-->
                                                        <?php $yes=''; echo Form::radio('grouptechnical', '1', $yes, $attributes = array("id"=>"grouptechnical1","class"=>"")); ?>
														<span></span>Yes</label>
                                                    </div>
                                                    <div class="inline">
                                                        <label class="radio-check">
														<!--<input type="radio" name="gTechnical" />-->
                                                        <?php $no=''; echo Form::radio('grouptechnical', '2', $no, $attributes = array("id"=>"grouptechnical2","class"=>"")); ?>
														<span></span>No</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row panel-bodyA">
                                            <div class="col-sm-9">
                                                <h4>Did the group receive their rider?</h4>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="inlineWrap extra-margin">
                                                    <div class="inline">
                                                        <label class="radio-check">
														<!--<input type="radio" name="gRider" />-->
														<?php $yes=''; echo Form::radio('grouprider', '1', $yes, $attributes = array("id"=>"grouprider1","class"=>"")); ?>
                                                        <span></span>Yes</label>
                                                    </div>
                                                    <div class="inline">
                                                        <label class="radio-check">
														<!--<input type="radio" name="gRider" />-->
														<?php $no=''; echo Form::radio('grouprider', '2', $no, $attributes = array("id"=>"grouprider2","class"=>"")); ?>
                                                        <span></span>No</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row panel-bodyA">
                                            <div class="col-sm-9">
                                                <h4>Did the group (or any members) leave early?</h4>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="inlineWrap extra-margin">
                                                    <div class="inline">
                                                        <label class="radio-check">
														<!--<input type="radio" name="gLeave" checked="checked" />-->
														<?php $yes=''; echo Form::radio('groupleave', '1', $yes, $attributes = array("id"=>"groupleave1","class"=>"")); ?>
                                                        <span></span>Yes</label>
                                                    </div>
                                                    <div class="inline">
                                                        <label class="radio-check">
														<!--<input type="radio" name="gLeave" />-->
														<?php $no=''; echo Form::radio('groupleave', '2', $no, $attributes = array("id"=>"groupleave2","class"=>"")); ?>
                                                        <span></span>No</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="row panel-bodyA">
                                            <div class="col-sm-9">
                                                <h4>what time did members leave?</h4>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class='input-group date' id='datetimepicker3'>
                                                    <input type='text' id="groupleavetime" class="form-control clck_outr timepicker" placeholder="12.00 am"/>
                                                    <span class="input-group-addon clck">
                                                        <span class="glyphicon glyphicon-time"></span>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
											
										<div class="row panel-bodyA">
                                            <div class="col-sm-9">
                                                <h4>Select the group</h4>
                                            </div>
                                            <div class="col-sm-3">
                                                <?php
								$control_attrAr=array();
								$control_attrAr['id']='againstgroup';
								$control_attrAr['class']="selectpicker artist_txt";
								$control_attrAr['title']="Choose the event";
								$againstgroup_def='';
							  
								$fetchagainstgroupArData=array();
								if(!empty($against_group)){
									foreach($against_group as $againstgroup){
										$fetchagainstgroupArData[$againstgroup['element']]=$againstgroup['content'];
									}
								}
								else{
									$fetchagainstgroupArData[0]='No event is available';
								}
							  
								echo Form::select('againstgroup',
								$fetchagainstgroupArData,
								$againstgroup_def,
								$control_attrAr
								);							
								?>
                                            </div>
                                        </div>
                                        
                                        <div class="issue-zone">
                                            <div class="issue-text">
                                               <textarea class="form-control" id="groupsummary" placeholder="In your own words (500 characters max). Please describe the issue."></textarea>
                                            </div>
                                        </div>
                                        
                                        <div class="clearfix book-support-col"> 
                                            <div class="rightI">
                                                <div class="support-btn">
                                                  <!--<a class="btn orange-btn support-btn" href="#">Send To Support</a>-->
												  <button type="button" id="groupsub" class="btn orange-btn support-btn">Send To Support</button>
                                                </div>
                                            </div>
                                        </div>
						            </div>
                                    <?php echo Form::close();?> 
						        </div>					
						    </div>
						    <div class="panel panel-default">				
						        <a data-toggle="collapse" class="accordian_nav collapsed" data-parent="#accordion" href="#collapse15">3. Resolve an issue with a venue</a>					
						        <div id="collapse15" class="panel-collapse collapse">					
						            <?php echo Form::open(array('files' => true, 'method' => 'post','id'=>'againstvenuefrmid','class'=>"" )); ?>
                                    <div class="panel-body">					
						                <div class="row panel-bodyA">
                                            <div class="col-sm-9">
                                                <h4>Was the Venue available at the Booking start-time?</h4>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="inlineWrap extra-margin">
                                                    <div class="inline">
                                                        <label class="radio-check">
														<!--<input type="radio" name="startTime" />-->
                                                        <?php $yes=''; echo Form::radio('venuearrive', '1', $yes, $attributes = array("id"=>"venuearrive1","class"=>"")); ?>
														<span></span>Yes</label>
                                                    </div>
                                                    <div class="inline">
                                                        <label class="radio-check">
														<!--<input type="radio" name="startTime" checked="checked" />-->
                                                        <?php $no=''; echo Form::radio('venuearrive', '2', $no, $attributes = array("id"=>"venuearrive2","class"=>"")); ?>
														<span></span>No</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row panel-bodyA">
                                            <div class="col-sm-9">
                                                <h4>what time was the Venue available to accommodate your event?</h4>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class='input-group date' id='datetimepicker3'>
                                                    <input type='text' id="venuearrivaltime" class="form-control clck_outr timepicker" placeholder="12.00 am"/>
                                                    <span class="input-group-addon clck">
                                                        <span class="glyphicon glyphicon-time"></span>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row panel-bodyA">
                                            <div class="col-sm-9">
                                                <h4>Was the presentation of the Venue as you viewed in the profile?</h4>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="inlineWrap extra-margin">
                                                    <div class="inline">
                                                        <label class="radio-check">
														<!--<input type="radio" name="venueViewed" />-->
                                                        <?php $yes=''; echo Form::radio('venuepresentation', '1', $yes, $attributes = array("id"=>"venuepresentation1","class"=>"")); ?>
														<span></span>Yes</label>
                                                    </div>
                                                    <div class="inline">
                                                        <label class="radio-check">
														<!--<input type="radio" name="venueViewed" />-->
                                                        <?php $no=''; echo Form::radio('venuepresentation', '2', $no, $attributes = array("id"=>"venuepresentation2","class"=>"")); ?>
														<span></span>No</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row panel-bodyA">
                                            <div class="col-sm-9">
                                                <h4>Were the venues profile amenities available and in working order?</h4>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="inlineWrap extra-margin">
                                                    <div class="inline">
                                                        <label class="radio-check">
														<!--<input type="radio" name="amenities" />-->
                                                        <?php $yes=''; echo Form::radio('venuespecification', '1', $yes, $attributes = array("id"=>"venuespecification1","class"=>"")); ?>
														<span></span>Yes</label>
                                                    </div>
                                                    <div class="inline">
                                                        <label class="radio-check">
														<!--<input type="radio" name="amenities" />-->
                                                        <?php $no=''; echo Form::radio('venuespecification', '2', $no, $attributes = array("id"=>"venuespecification2","class"=>"")); ?>
														<span></span>No</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row panel-bodyA">
                                            <div class="col-sm-9">
                                                <h4>Were there any technical difficulties that disturbed your event?</h4>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="inlineWrap extra-margin">
                                                    <div class="inline">
                                                        <label class="radio-check">
														<!--<input type="radio" name="technicalDifficulties" />-->
                                                        <?php $yes=''; echo Form::radio('venuetechnical', '1', $yes, $attributes = array("id"=>"venuetechnical1","class"=>"")); ?>
														<span></span>Yes</label>
                                                    </div>
                                                    <div class="inline">
                                                        <label class="radio-check">
														<!--<input type="radio" name="technicalDifficulties" />-->
                                                        <?php $no=''; echo Form::radio('venuetechnical', '2', $no, $attributes = array("id"=>"venuetechnical2","class"=>"")); ?>
														<span></span>No</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row panel-bodyA">
                                            <div class="col-sm-9">
                                                <h4>Were you asked to vacate the venue early?</h4>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="inlineWrap extra-margin">
                                                    <div class="inline">
                                                        <label class="radio-check">
														<!--<input type="radio" name="vacate" checked="checked" />-->
                                                        <?php $yes=''; echo Form::radio('venueleave', '1', $yes, $attributes = array("id"=>"venueleave1","class"=>"")); ?>
														<span></span>Yes</label>
                                                    </div>
                                                    <div class="inline">
                                                        <label class="radio-check">
														<!--<input type="radio" name="vacate" />-->
                                                        <?php $no=''; echo Form::radio('venueleave', '2', $no, $attributes = array("id"=>"venueleave2","class"=>"")); ?>
														<span></span>No</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="row panel-bodyA">
                                            <div class="col-sm-9">
                                                <h4>what time did you leave the venue?</h4>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class='input-group date' id='datetimepicker3'>
                                                    <input type='text' id="venueleavetime" class="form-control clck_outr timepicker" placeholder="12.00 am"/>
                                                    <span class="input-group-addon clck">
                                                        <span class="glyphicon glyphicon-time"></span>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
											
										<div class="row panel-bodyA">
                                            <div class="col-sm-9">
                                                <h4>Select the venue</h4>
                                            </div>
                                            <div class="col-sm-3">
                                                <?php
								$control_attrAr=array();
								$control_attrAr['id']='againstvenue';
								$control_attrAr['class']="selectpicker artist_txt";
								$control_attrAr['title']="Choose the event";
								$againstvenue_def='';
								
								$fetchagainstvenueArData=array();
								if(!empty($against_venue)){
									foreach($against_venue as $againstvenue){
										$fetchagainstvenueArData[$againstvenue['element']]=$againstvenue['content'];
									}
								}
								else{
									$fetchagainstvenueArData[0]='No event is available';
								}
							  
								echo Form::select('againstvenue',
								$fetchagainstvenueArData,
								$againstvenue_def,
								$control_attrAr
								);							
								?>
                                            </div>
                                        </div>
                                        
                                        <div class="issue-zone">
                                            <div class="issue-text">
                                               <textarea class="form-control" id="venuesummary" placeholder="In your own words (500 characters max). Please describe the issue."></textarea>
                                            </div>
                                        </div>
                                        
                                        <div class="clearfix book-support-col"> 
                                            <div class="rightI">
                                                <div class="support-btn">
                                                  <!--<a class="btn orange-btn support-btn" href="#">Send To Support</a>-->
													<button type="button" id="venuesub" class="btn orange-btn support-btn">Send To Support</button>
												</div>
                                            </div>
                                        </div>
						            </div>
                                     <?php echo Form::close();?>
						        </div>					
						    </div>	
                            <div class="panel panel-default">				
						        <a data-toggle="collapse" class="accordian_nav collapsed" data-parent="#accordion" href="#collapse16">4. Resolve an issue with a booker</a>					
						        <div id="collapse16" class="panel-collapse collapse">
								<?php echo Form::open(array('files' => true, 'method' => 'post','id'=>'againstbookerfrmid','class'=>"" )); ?>
						            <div class="panel-body">					
						                <div class="row panel-bodyA">
                                            <div class="col-sm-9">
                                                <h4>Did you get to the gig?</h4>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="inlineWrap extra-margin">
                                                    <div class="inline">
                                                        <label class="radio-check">
														<!--<input type="radio" name="ac" checked="checked">-->
                                                        <?php $yes=''; echo Form::radio('getgig', '1', $yes, $attributes = array("id"=>"getgig1","class"=>"")); ?>
														<span></span>Yes</label>
                                                    </div>
                                                    <div class="inline">
                                                        <label class="radio-check">
														<!--<input type="radio" name="ac" checked="checked">-->
                                                        <?php $no=''; echo Form::radio('getgig', '2', $no, $attributes = array("id"=>"getgig2","class"=>"")); ?>
														<span></span>No</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row panel-bodyA">
                                            <div class="col-sm-9">
                                                <h4>What time did you arrive?</h4>
                                            </div>
											<div class="col-sm-3">
                                                <div class='input-group date' id='datetimepicker3'>
                                                    <input type='text' id="bookerarrivaltime" class="form-control clck_outr timepicker" placeholder="12.00 am"/>
                                                    <span class="input-group-addon clck">
                                                        <span class="glyphicon glyphicon-time"></span>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                         <div class="row panel-bodyA">
                                            <div class="col-sm-9">
                                                <h4>Were you able to commence the gig with your required specification?</h4>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="inlineWrap extra-margin">
                                                    <div class="inline">
                                                        <label class="radio-check">
														<!--<input type="radio" name="ad" checked="checked">-->
                                                        <?php $yes=''; echo Form::radio('commencegig', '1', $yes, $attributes = array("id"=>"commencegig1","class"=>"")); ?>
														<span></span>Yes</label>
                                                    </div>
                                                    <div class="inline">
                                                        <label class="radio-check">
														<!--<input type="radio" name="ad" checked="checked">-->
                                                        <?php $no=''; echo Form::radio('commencegig', '2', $no, $attributes = array("id"=>"commencegig2","class"=>"")); ?>
														<span></span>No</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                         <div class="row panel-bodyA">
                                            <div class="col-sm-9">
                                                <h4>Did any technical issues arise during your gig?</h4>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="inlineWrap extra-margin">
                                                    <div class="inline">
                                                        <label class="radio-check">
														<!--<input type="radio" name="ae" checked="checked">-->
                                                        <?php $yes=''; echo Form::radio('bookertechnical', '1', $yes, $attributes = array("id"=>"bookertechnical1","class"=>"")); ?>
														<span></span>Yes</label>
                                                    </div>
                                                    <div class="inline">
                                                        <label class="radio-check">
														<!--<input type="radio" name="ae" checked="checked">-->
                                                        <?php $no=''; echo Form::radio('bookertechnical', '2', $no, $attributes = array("id"=>"bookertechnical2","class"=>"")); ?>
														<span></span>No</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                         <div class="row panel-bodyA">
                                            <div class="col-sm-9">
                                                <h4>Were you able to complete the gig with your required specifications?</h4>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="inlineWrap extra-margin">
                                                    <div class="inline">
                                                        <label class="radio-check">
														<!--<input type="radio" name="af" checked="checked">-->
                                                        <?php $yes=''; echo Form::radio('bookerspecification', '1', $yes, $attributes = array("id"=>"bookerspecification1","class"=>"")); ?>
														<span></span>Yes</label>
                                                    </div>
                                                    <div class="inline">
                                                        <label class="radio-check">
														<!--<input type="radio" name="af" checked="checked">-->
                                                        <?php $no=''; echo Form::radio('bookerspecification', '2', $no, $attributes = array("id"=>"bookerspecification2","class"=>"")); ?>
														<span></span>No</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                         <div class="row panel-bodyA">
                                            <div class="col-sm-9">
                                                <h4>Did you receive your rider?</h4>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="inlineWrap extra-margin">
                                                    <div class="inline">
                                                        <label class="radio-check">
														<!--<input type="radio" name="ag" checked="checked">-->
                                                        <?php $yes=''; echo Form::radio('bookerrider', '1', $yes, $attributes = array("id"=>"bookerrider1","class"=>"")); ?>
														<span></span>Yes</label>
                                                    </div>
                                                    <div class="inline">
                                                        <label class="radio-check">
														<!--<input type="radio" name="ag" checked="checked">-->
                                                        <?php $no=''; echo Form::radio('bookerrider', '2', $no, $attributes = array("id"=>"bookerrider2","class"=>"")); ?>
														<span></span>No</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row panel-bodyA">
                                            <div class="col-sm-9">
                                                <h4>Did you leave early?</h4>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="inlineWrap extra-margin">
                                                    <div class="inline">
                                                        <label class="radio-check">
														<!--<input type="radio" name="ah" checked="checked">-->
                                                        <?php $yes=''; echo Form::radio('bookerleave', '1', $yes, $attributes = array("id"=>"bookerleave1","class"=>"")); ?>
														<span></span>Yes</label>
                                                    </div>
                                                    <div class="inline">
                                                        <label class="radio-check">
														<!--<input type="radio" name="ah" checked="checked">-->
                                                        <?php $no=''; echo Form::radio('bookerleave', '2', $no, $attributes = array("id"=>"bookerleave2","class"=>"")); ?>
														<span></span>No</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
											
										<div class="row panel-bodyA">
                                            <div class="col-sm-9">
                                                <h4>Select the booker</h4>
                                            </div>
                                            <div class="col-sm-3">
                                                <?php
								$control_attrAr=array();
								$control_attrAr['id']='againstbooker';
								$control_attrAr['class']="selectpicker artist_txt";
								$control_attrAr['title']="Choose the event";
								$againstbooker_def='';
								
								$fetchagainstbookerArData=array();
								if(!empty($against_booker)){
									foreach($against_booker as $againstbooker){
										$fetchagainstbookerArData[$againstbooker['element']]=$againstbooker['content'];
									}
								}
								else{
									$fetchagainstbookerArData[0]='No event is available';
								}
							  
								echo Form::select('againstbooker',
								$fetchagainstbookerArData,
								$againstbooker_def,
								$control_attrAr
								);							
								?>
                                            </div>
                                        </div>
											
                                            <div class="issue-zone">
                                                <div class="issue-text">
                                                   <textarea class="form-control" id="bookersummary" placeholder="In your own words (500 characters max).Please describethe issue"></textarea>
                                                </div>
                                            </div>
                                        <div class="clearfix book-support-col"> 
                                            <div class="leftI">
                                                <div class="booking-id-no">
                                                    <h4>Booking-id#</h4>
                                                </div>
                                            </div>
                                            <div class="rightI">
                                                <div class="support-btn">
                                                  <!--<a class="btn orange-btn support-btn" href="#">Send To Support</a>-->
												  <button type="button" id="bookersub" class="btn orange-btn support-btn">Send To Support</button>
                                                </div>
                                            </div>
                                        </div>
						            </div>
										<?php echo Form::close();?>
						        </div>					
						    </div>	
				         </div>
                        </div>
			         </div>
                </div>
		   </div>
	</section>
		
	<!-- profile-section-end -->
	


	<script type="text/javascript">
		var loderImage = "{{ URL::asset('public/front')}}/otherfiles/progimages/loder.gif";
		
		$("#helpurl").click(function(){

          window.location.href = "<?php echo url("help"); ?>";
        });
	
	</script>
	<script type="text/javascript" src="{{ URL::asset('public/front')}}/otherfiles/progjs/frontendhelp.js"></script>
	<!--<script type="text/javascript" src="{{ URL::asset('public/front')}}/otherfiles/progjs/frontenddisputeform.js"></script>-->
	
	@endsection
