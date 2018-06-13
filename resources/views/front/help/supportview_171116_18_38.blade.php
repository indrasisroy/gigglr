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
							<a href="#">RESOLVE A DISPUTE</a>
                            </span>
						</div>
						<div class="col-sm-4 col-xs-4">
                            <span class="faq_cols">
                                <a href="#">CONTACT SUPPORT</a>
                            </span>
						</div>
						<div class="col-sm-4 col-xs-4">
                            <span class="faq_cols faq_col2">
                                <a href="help.html">Site Help</a>
                            </span>
						</div>
					</div>					
				</div>
			</div>
			
            <h2 class="watch_heading watch_heading-custom-2">CONTACT SUPPORT</h2>
            <div class="row">
                <div class="col-sm-offset-2 col-sm-8">
                    <div class="custom-formIn xe-class">
                        <div class="inputForum clearfix">
                           <div class="from-control-custom">
                               <select class="selectpicker">
                                    <option value="0">Country</option>
                                    <option value="1">India</option>
                                    <option value="2">Germany</option>
                                    <option value="3">Dubai</option>
                                </select>
                             </div>
                            </div>
                             <div class="inputForum clearfix">
                                <label>First Name *</label>
                                 <div class="from-control-custom">
                                     <input type="text" class="form-control">
                                 </div>
                            </div>
                         <div class="inputForum clearfix">
                                <label>Last Name</label>
                                 <div class="from-control-custom">
                                     <input type="text" class="form-control">
                                 </div>
                            </div>
                         <div class="inputForum clearfix">
                                <label>E-Mail Address *</label>
                                 <div class="from-control-custom">
                                     <input type="text" class="form-control">
                                 </div>
                            </div>
                         <div class="inputForum clearfix">
                                <label>Your Message *</label>
                                 <div class="from-control-custom from-control-custom-2">
                                     <textarea class="form-control"></textarea>
                                 </div>
                            </div>
                        <div class="inputForum clearfix">
                        <div class="leftI">
                        <div class="inputForum clearfix send-copy">
                            <label>Send me a copy</label>
                            <div class="from-control-custom">
                                <div class="inlineWrap extra-margin">
                                    <div class="inline">
                                       <label class="radio-check"><input type="radio" name="na" />
                                         <span></span>Yes</label>
                                      </div>
                                        <div class="inline">
                                            <label class="radio-check"><input type="radio" name="na" />
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
                                       <label class="radio-check"><input type="radio" name="nb" checked="checked">
                                         <span></span>Yes</label>
                                      </div>
                                        <div class="inline">
                                            <label class="radio-check"><input type="radio" name="nb" checked="checked">
                                            <span></span>No</label>
                                        </div>
                                 </div>
                             </div>
                        </div>
                       </div> 
                            <div class="rightI">
                            <div class="support-btn support-btn-custom">
                                <a class="btn orange-btn support-btn" href="#">Send To Support</a>
                            </div>
                        </div>
                        </div>
                     </div>
                </div>
            </div>
            
        <h2 class="watch_heading watch_heading-custom-2">Resolve a dispute</h2>
            <div class="row">
			<div class="col-sm-offset-2 col-sm-8">
                <div class="resolve-innar" id="resolve-sec">
					<div id="accordion" class="panel-group row text-left">
							<div class="panel panel-default">				
						        <a data-toggle="collapse" class="accordian_nav collapsed" data-parent="#accordion" href="#collapse13">1. Resolve an issue with an artist</a>					
						        <div id="collapse13" class="panel-collapse collapse in">					
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
                                                    <input type='text' id="arrivaltime" class="form-control clck_outr timepicker" placeholder="3.15 pm"/>
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
                                                    <input type='text' id="leavetime" class="form-control clck_outr timepicker" placeholder="3.15 pm"/>
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
								$control_attrAr['title']="Choose the artist";
								$againstartist_def='';
								
								$fetchagainstartistArData=array();
								if(!empty($against_artist)){
									foreach($against_artist as $againstartist){
										$fetchagainstartistArData[$againstartist['element']]=$againstartist['content'];
									}
								}
								else{
									$fetchagainstartistArData[0]='No artist is available';
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
                                                    <input type='text' id="grouparrivaltime" class="form-control clck_outr timepicker" placeholder="3.15 pm"/>
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
                                                    <input type='text' id="groupleavetime" class="form-control clck_outr timepicker" placeholder="3.15 pm"/>
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
								$control_attrAr['title']="Choose the group";
								$againstgroup_def='';
							  
								$fetchagainstgroupArData=array();
								if(!empty($against_group)){
									foreach($against_group as $againstgroup){
										$fetchagainstgroupArData[$againstgroup['element']]=$againstgroup['content'];
									}
								}
								else{
									$fetchagainstgroupArData[0]='No group is available';
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
                                                    <input type='text' id="venuearrivaltime" class="form-control clck_outr timepicker" placeholder="3.15 pm"/>
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
                                                    <input type='text' id="venueleavetime" class="form-control clck_outr timepicker" placeholder="3.15 pm"/>
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
								$control_attrAr['title']="Choose the venue";
								$againstvenue_def='';
								
								$fetchagainstvenueArData=array();
								if(!empty($against_venue)){
									foreach($against_venue as $againstvenue){
										$fetchagainstvenueArData[$againstvenue['element']]=$againstvenue['content'];
									}
								}
								else{
									$fetchagainstvenueArData[0]='No venue is available';
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
                                                    <input type='text' id="bookerarrivaltime" class="form-control clck_outr timepicker" placeholder="3.15 pm"/>
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
								$control_attrAr['title']="Choose the booker";
								$againstbooker_def='';
								
								$fetchagainstbookerArData=array();
								if(!empty($against_booker)){
									foreach($against_booker as $againstbooker){
										$fetchagainstbookerArData[$againstbooker['element']]=$againstbooker['content'];
									}
								}
								else{
									$fetchagainstbookerArData[0]='No booker is available';
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
	
<!--	      <div class="modal fade" id="myModal3" tabindex="-1" role="dialog">-->
<!--  <div class="modal-dialog modal-lg" role="document">-->
<!--    <div class="modal-content popup-content">-->
<!--      <div class="modal-body popup-body wallet">-->
<!--        <div class="clearfix">-->
<!--            <div class="test">-->
<!--                <div class="payment_menus">-->
<!--                    <ul class="payment_menus_list">-->
<!--                        <li><a data-toggle="tab" href="#payone">Bank Account</a> </li>-->
<!--                        <li><a data-toggle="tab" href="#paytwo">Paypal</a> </li>-->
<!--                        <li class="active"><a data-toggle="tab" href="#paythree">Credit Card</a> </li>-->
<!--<!--                        <li><a data-toggle="tab" href="#payfour">ABN & GST</a> </li>-->-->
<!--                    </ul>-->
<!--                </div>-->
<!--            </div>-->
<!--            <div class="test1">-->
<!--            	<div class="tab-content">-->
<!--            		<div id="payone" class="tab-pane fade">-->
<!--            			Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.-->
<!--            		</div>	-->
<!--            		<div id="paytwo" class="tab-pane fade">-->
<!--            			Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.-->
<!--            		</div>-->
<!--            		<div id="paythree" class="tab-pane fade in active">-->
<!--	            		<div class="card_payments">-->
<!--		                    <div class="pay_hed">We welcome these cards-->
<!--                                <div class="credt_crd">-->
<!--		                        <Span><img src="images/c1.png" alt=""> </Span> -->
<!--		                        <Span><img src="images/c2.png" alt=""> </Span> -->
<!--		                        <Span><img src="images/c3.png" alt=""> </Span> -->
<!--                                </div>    -->
<!--		                    </div>-->
<!--		                    -->
<!--		                    <form class="card_payments_content">-->
<!--                                <div class="card_inputs">-->
<!--		                            <input class="form-control txt_color" type="text" placeholder="Name on Card" />-->
<!--		                        </div>-->
<!--		                        <div class="card_inputs card">-->
<!--		                            <select class="selectpicker ">-->
<!--		                                <option value="0">Card Type</option>-->
<!--		                                <option value="1">Visa</option>-->
<!--		                                <option value="2">Mastro Card</option>-->
<!--		                                <option value="3">American Express</option>-->
<!--		                            </select>-->
<!--		                         </div>-->
<!--		                        -->
<!--		                        <div class="card_inputs">-->
<!--		                            <input class="form-control txt_color crdinpt" type="text" placeholder="Card Number" />-->
<!--		                        </div>-->
<!--		                        -->
<!--		                        <div class="row card_inputs">-->
<!--		                            <div class="col-sm-5">-->
<!--		                                -->
<!--		                                    <input class="form-control txt_color" type="text" placeholder="CVV" />-->
<!--		                               -->
<!--		                            </div>-->
<!--		                            <div class="col-sm-7">-->
<!--		                                <div class="row exp_dates">-->
<!--		                                    <div class="col-sm-4 date_label">Expiry Date </div>-->
<!--		                                    -->
<!--		                                    <div class="col-sm-4">-->
<!--		                                        <span>-->
<!--		                                            <select class="selectpicker">-->
<!--		                                                <option value="0">MM</option>-->
<!--		                                                <option value="1">01</option>-->
<!--		                                                <option value="2">02</option>-->
<!--		                                                <option value="3">03</option>-->
<!--		                                            </select>-->
<!--		                                        </span>    -->
<!--		                                    </div>-->
<!--		                                    <div class="col-sm-4">-->
<!--		                                        <span>-->
<!--		                                            <select class="selectpicker">-->
<!--		                                                <option value="0">YY</option>-->
<!--		                                                <option value="1">2016</option>-->
<!--		                                                <option value="2">2017</option>-->
<!--		                                                <option value="3">2018</option>-->
<!--		                                            </select>-->
<!--		                                        </span>-->
<!--		                                    </div>-->
<!--		                                </div>-->
<!--		                                                                -->
<!--		                            </div>-->
<!--		                        </div>-->
<!--		                         <div class="card_inputs add_fund amount">-->
<!--		                        	<span class="fund_icon"> Amount</span>-->
<!--		                            <input class="form-control txt_color" type="text" placeholder=" $0.00" />-->
<!--		                        </div>-->
<!--		                        <div class="bttn_outer">-->
<!--		                            <button class="fund_btn" type="submit">-->
<!--		                                Add Funds-->
<!--		                            </button>-->
<!--		                        </div>-->
<!--		                        -->
<!--		                    </form>-->
<!--		                    -->
<!--		                </div>	-->
<!--            		</div>	-->
<!--	            	<div id="payfour" class="tab-pane fade">-->
<!--            			Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.-->
<!--            		</div>	-->
<!--            	</div>                -->
<!--            </div>-->
<!--<!--            <div class="modal-footer popup-footer">-->-->
<!--<!--             <div class="sign-up-tips">-->-->
<!--<!--               <span>Don't have an account?</span>-->-->
<!--                <a href="#" data-dismiss="modal" aria-label="Close" class="close popup-close wallet-close"></a>-->
<!--<!--          </div>-->-->
<!--<!--      </div>-->-->
<!--        </div>-->
<!--      </div>-->
<!--      </div>-->
<!--      </div>-->
<!--      </div>-->

	<script type="text/javascript">
		var loderImage = "{{ URL::asset('public/front')}}/otherfiles/progimages/loder.gif";
	</script>
	<script type="text/javascript" src="{{ URL::asset('public/front')}}/otherfiles/progjs/frontendhelp.js"></script>
	<script type="text/javascript" src="{{ URL::asset('public/front')}}/otherfiles/progjs/frontenddisputeform.js">
	
	@endsection
