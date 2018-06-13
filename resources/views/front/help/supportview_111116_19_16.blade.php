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
                                   
                                    <div class="panel-body">					
						                <div class="row panel-bodyA">
                                            <div class="col-sm-9">
                                                <h4>Did the artist arrive on time?</h4>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="inlineWrap extra-margin">
                                                    <div class="inline">
                                                        <label class="radio-check"><input type="radio" name="arrive" />
                                                        <span></span>Yes</label>
                                                    </div>
                                                    <div class="inline">
                                                        <label class="radio-check"><input type="radio" name="arrive" />
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
                                                    <input type='text' class="form-control clck_outr timepicker" placeholder="3.15 pm"/>
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
                                                        <label class="radio-check"><input type="radio" name="specification" />
                                                        <span></span>Yes</label>
                                                    </div>
                                                    <div class="inline">
                                                        <label class="radio-check"><input type="radio" name="specification" />
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
                                                        <label class="radio-check"><input type="radio" name="performance" />
                                                        <span></span>Yes</label>
                                                    </div>
                                                    <div class="inline">
                                                        <label class="radio-check"><input type="radio" name="performance" />
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
                                                        <label class="radio-check"><input type="radio" name="technical" />
                                                        <span></span>Yes</label>
                                                    </div>
                                                    <div class="inline">
                                                        <label class="radio-check"><input type="radio" name="technical" />
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
                                                        <label class="radio-check"><input type="radio" name="rider" checked="checked">
                                                        <span></span>Yes</label>
                                                    </div>
                                                    <div class="inline">
                                                        <label class="radio-check"><input type="radio" name="rider" checked="checked">
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
                                                        <label class="radio-check"><input type="radio" name="leave" />
                                                        <span></span>Yes</label>
                                                    </div>
                                                    <div class="inline">
                                                        <label class="radio-check"><input type="radio" name="leave" />
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
                                                    <input type='text' class="form-control clck_outr timepicker" placeholder="3.15 pm"/>
                                                    <span class="input-group-addon clck">
                                                        <span class="glyphicon glyphicon-time"></span>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="issue-zone">
                                            <div class="issue-text">
                                               <textarea class="form-control" placeholder="In your own words (500 characters max). Please describe the issue."></textarea>
                                            </div>
                                        </div>
                                        
                                        <div class="clearfix book-support-col"> 
                                            <div class="rightI">
                                                <div class="support-btn">
                                                  <a class="btn orange-btn support-btn" href="#">Send To Support</a>
                                                </div>
                                            </div>
                                        </div>
						            </div>
                                     				
						        </div>					
						    </div>
						    <div class="panel panel-default">				
						        <a data-toggle="collapse" class="accordian_nav collapsed" data-parent="#accordion" href="#collapse14">2. Resolve an issue with an group</a>					
						        <div id="collapse14" class="panel-collapse collapse">					
						            
                                    <div class="panel-body">					
						                <div class="row panel-bodyA">
                                            <div class="col-sm-9">
                                                <h4>Did the group arrive on time?</h4>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="inlineWrap extra-margin">
                                                    <div class="inline">
                                                        <label class="radio-check"><input type="radio" name="gArrive" />
                                                        <span></span>Yes</label>
                                                    </div>
                                                    <div class="inline">
                                                        <label class="radio-check"><input type="radio" name="gArrive" />
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
                                                    <input type='text' class="form-control clck_outr timepicker" placeholder="3.15 pm"/>
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
                                                        <label class="radio-check"><input type="radio" name="gSpecification" />
                                                        <span></span>Yes</label>
                                                    </div>
                                                    <div class="inline">
                                                        <label class="radio-check"><input type="radio" name="gSpecification" />
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
                                                        <label class="radio-check"><input type="radio" name="gPerformance" />
                                                        <span></span>Yes</label>
                                                    </div>
                                                    <div class="inline">
                                                        <label class="radio-check"><input type="radio" name="gPerformance" />
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
                                                        <label class="radio-check"><input type="radio" name="gTechnical" />
                                                        <span></span>Yes</label>
                                                    </div>
                                                    <div class="inline">
                                                        <label class="radio-check"><input type="radio" name="gTechnical" />
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
                                                        <label class="radio-check"><input type="radio" name="gRider" />
                                                        <span></span>Yes</label>
                                                    </div>
                                                    <div class="inline">
                                                        <label class="radio-check"><input type="radio" name="gRider" />
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
                                                        <label class="radio-check"><input type="radio" name="gLeave" checked="checked" />
                                                        <span></span>Yes</label>
                                                    </div>
                                                    <div class="inline">
                                                        <label class="radio-check"><input type="radio" name="gLeave" />
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
                                                    <input type='text' class="form-control clck_outr timepicker" placeholder="3.15 pm"/>
                                                    <span class="input-group-addon clck">
                                                        <span class="glyphicon glyphicon-time"></span>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="issue-zone">
                                            <div class="issue-text">
                                               <textarea class="form-control" placeholder="In your own words (500 characters max). Please describe the issue."></textarea>
                                            </div>
                                        </div>
                                        
                                        <div class="clearfix book-support-col"> 
                                            <div class="rightI">
                                                <div class="support-btn">
                                                  <a class="btn orange-btn support-btn" href="#">Send To Support</a>
                                                </div>
                                            </div>
                                        </div>
						            </div>
                                    
						        </div>					
						    </div>
						    <div class="panel panel-default">				
						        <a data-toggle="collapse" class="accordian_nav collapsed" data-parent="#accordion" href="#collapse15">3. Resolve an issue with an venue</a>					
						        <div id="collapse15" class="panel-collapse collapse">					
						            
                                    <div class="panel-body">					
						                <div class="row panel-bodyA">
                                            <div class="col-sm-9">
                                                <h4>Was the Venue available at the Booking start-time?</h4>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="inlineWrap extra-margin">
                                                    <div class="inline">
                                                        <label class="radio-check"><input type="radio" name="startTime" />
                                                        <span></span>Yes</label>
                                                    </div>
                                                    <div class="inline">
                                                        <label class="radio-check"><input type="radio" name="startTime" checked="checked" />
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
                                                    <input type='text' class="form-control clck_outr timepicker" placeholder="3.15 pm"/>
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
                                                        <label class="radio-check"><input type="radio" name="venueViewed" />
                                                        <span></span>Yes</label>
                                                    </div>
                                                    <div class="inline">
                                                        <label class="radio-check"><input type="radio" name="venueViewed" />
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
                                                        <label class="radio-check"><input type="radio" name="amenities" />
                                                        <span></span>Yes</label>
                                                    </div>
                                                    <div class="inline">
                                                        <label class="radio-check"><input type="radio" name="amenities" />
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
                                                        <label class="radio-check"><input type="radio" name="technicalDifficulties" />
                                                        <span></span>Yes</label>
                                                    </div>
                                                    <div class="inline">
                                                        <label class="radio-check"><input type="radio" name="technicalDifficulties" />
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
                                                        <label class="radio-check"><input type="radio" name="vacate" checked="checked" />
                                                        <span></span>Yes</label>
                                                    </div>
                                                    <div class="inline">
                                                        <label class="radio-check"><input type="radio" name="vacate" />
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
                                                    <input type='text' class="form-control clck_outr timepicker" placeholder="3.15 pm"/>
                                                    <span class="input-group-addon clck">
                                                        <span class="glyphicon glyphicon-time"></span>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="issue-zone">
                                            <div class="issue-text">
                                               <textarea class="form-control" placeholder="In your own words (500 characters max). Please describe the issue."></textarea>
                                            </div>
                                        </div>
                                        
                                        <div class="clearfix book-support-col"> 
                                            <div class="rightI">
                                                <div class="support-btn">
                                                  <a class="btn orange-btn support-btn" href="#">Send To Support</a>
                                                </div>
                                            </div>
                                        </div>
						            </div>
                                    
						        </div>					
						    </div>	
                            <div class="panel panel-default">				
						        <a data-toggle="collapse" class="accordian_nav collapsed" data-parent="#accordion" href="#collapse16">4. Resolve an issue with a booker</a>					
						        <div id="collapse16" class="panel-collapse collapse">					
						            <div class="panel-body">					
						                <div class="row panel-bodyA">
                                            <div class="col-sm-9">
                                                <h4>Did you get to the gig?</h4>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="inlineWrap extra-margin">
                                                    <div class="inline">
                                                        <label class="radio-check"><input type="radio" name="ac" checked="checked">
                                                        <span></span>Yes</label>
                                                    </div>
                                                    <div class="inline">
                                                        <label class="radio-check"><input type="radio" name="ac" checked="checked">
                                                        <span></span>No</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row panel-bodyA">
                                            <div class="col-sm-9">
                                                <h4>What time did you arrive?</h4>
                                            </div>
                                        </div>
                                         <div class="row panel-bodyA">
                                            <div class="col-sm-9">
                                                <h4>Were you able to commence the gig with your required specification?</h4>
                                            </div>
                                            <div class="col-sm-3">
                                                <div class="inlineWrap extra-margin">
                                                    <div class="inline">
                                                        <label class="radio-check"><input type="radio" name="ad" checked="checked">
                                                        <span></span>Yes</label>
                                                    </div>
                                                    <div class="inline">
                                                        <label class="radio-check"><input type="radio" name="ad" checked="checked">
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
                                                        <label class="radio-check"><input type="radio" name="ae" checked="checked">
                                                        <span></span>Yes</label>
                                                    </div>
                                                    <div class="inline">
                                                        <label class="radio-check"><input type="radio" name="ae" checked="checked">
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
                                                        <label class="radio-check"><input type="radio" name="af" checked="checked">
                                                        <span></span>Yes</label>
                                                    </div>
                                                    <div class="inline">
                                                        <label class="radio-check"><input type="radio" name="af" checked="checked">
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
                                                        <label class="radio-check"><input type="radio" name="ag" checked="checked">
                                                        <span></span>Yes</label>
                                                    </div>
                                                    <div class="inline">
                                                        <label class="radio-check"><input type="radio" name="ag" checked="checked">
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
                                                        <label class="radio-check"><input type="radio" name="ah" checked="checked">
                                                        <span></span>Yes</label>
                                                    </div>
                                                    <div class="inline">
                                                        <label class="radio-check"><input type="radio" name="ah" checked="checked">
                                                        <span></span>No</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                            <div class="issue-zone">
                                                <div class="issue-text">
                                                   <textarea class="form-control" placeholder="In your own words (500 characters max).Please describethe issue"></textarea>
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
                                                  <a class="btn orange-btn support-btn" href="#">Send To Support</a>
                                                </div>
                                            </div>
                                        </div>
						            </div>						
						        </div>					
						    </div>	
				         </div>
                        </div>
			         </div>
                </div>
		   </div>
	</section>
		
	<!-- profile-section-end -->
	
	      <div class="modal fade" id="myModal3" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content popup-content">
      <div class="modal-body popup-body wallet">
        <div class="clearfix">
            <div class="test">
                <div class="payment_menus">
                    <ul class="payment_menus_list">
                        <li><a data-toggle="tab" href="#payone">Bank Account</a> </li>
                        <li><a data-toggle="tab" href="#paytwo">Paypal</a> </li>
                        <li class="active"><a data-toggle="tab" href="#paythree">Credit Card</a> </li>
<!--                        <li><a data-toggle="tab" href="#payfour">ABN & GST</a> </li>-->
                    </ul>
                </div>
            </div>
            <div class="test1">
            	<div class="tab-content">
            		<div id="payone" class="tab-pane fade">
            			Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
            		</div>	
            		<div id="paytwo" class="tab-pane fade">
            			Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
            		</div>
            		<div id="paythree" class="tab-pane fade in active">
	            		<div class="card_payments">
		                    <div class="pay_hed">We welcome these cards
                                <div class="credt_crd">
		                        <Span><img src="images/c1.png" alt=""> </Span> 
		                        <Span><img src="images/c2.png" alt=""> </Span> 
		                        <Span><img src="images/c3.png" alt=""> </Span> 
                                </div>    
		                    </div>
		                    
		                    <form class="card_payments_content">
                                <div class="card_inputs">
		                            <input class="form-control txt_color" type="text" placeholder="Name on Card" />
		                        </div>
		                        <div class="card_inputs card">
		                            <select class="selectpicker ">
		                                <option value="0">Card Type</option>
		                                <option value="1">Visa</option>
		                                <option value="2">Mastro Card</option>
		                                <option value="3">American Express</option>
		                            </select>
		                         </div>
		                        
		                        <div class="card_inputs">
		                            <input class="form-control txt_color crdinpt" type="text" placeholder="Card Number" />
		                        </div>
		                        
		                        <div class="row card_inputs">
		                            <div class="col-sm-5">
		                                
		                                    <input class="form-control txt_color" type="text" placeholder="CVV" />
		                               
		                            </div>
		                            <div class="col-sm-7">
		                                <div class="row exp_dates">
		                                    <div class="col-sm-4 date_label">Expiry Date </div>
		                                    
		                                    <div class="col-sm-4">
		                                        <span>
		                                            <select class="selectpicker">
		                                                <option value="0">MM</option>
		                                                <option value="1">01</option>
		                                                <option value="2">02</option>
		                                                <option value="3">03</option>
		                                            </select>
		                                        </span>    
		                                    </div>
		                                    <div class="col-sm-4">
		                                        <span>
		                                            <select class="selectpicker">
		                                                <option value="0">YY</option>
		                                                <option value="1">2016</option>
		                                                <option value="2">2017</option>
		                                                <option value="3">2018</option>
		                                            </select>
		                                        </span>
		                                    </div>
		                                </div>
		                                                                
		                            </div>
		                        </div>
		                         <div class="card_inputs add_fund amount">
		                        	<span class="fund_icon"> Amount</span>
		                            <input class="form-control txt_color" type="text" placeholder=" $0.00" />
		                        </div>
		                        <div class="bttn_outer">
		                            <button class="fund_btn" type="submit">
		                                Add Funds
		                            </button>
		                        </div>
		                        
		                    </form>
		                    
		                </div>	
            		</div>	
	            	<div id="payfour" class="tab-pane fade">
            			Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
            		</div>	
            	</div>                
            </div>
<!--            <div class="modal-footer popup-footer">-->
<!--             <div class="sign-up-tips">-->
<!--               <span>Don't have an account?</span>-->
                <a href="#" data-dismiss="modal" aria-label="Close" class="close popup-close wallet-close"></a>
<!--          </div>-->
<!--      </div>-->
        </div>
      </div>
      </div>
      </div>
      </div>

	<script type="text/javascript">
		var loderImage = "{{ URL::asset('public/front')}}/otherfiles/progimages/loder.gif";
	</script>
	<script type="text/javascript" src="{{ URL::asset('public/front')}}/otherfiles/progjs/frontendhelp.js"></script>
	
	@endsection
