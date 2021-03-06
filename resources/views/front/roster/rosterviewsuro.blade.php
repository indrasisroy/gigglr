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
@extends('layouts.front.frontendmaster',['successmsg' => $successmsg,'errormsg'=>$errormsg])

@section('content')

<section class="profile_outer event_back">		
		<div class="container">
			<div class="month-chart clearfix">
				<div class="left_chart">
					<!--<div class="setting_icon">
						
						<a href="javascript:void(0);" class="calendarPopBtn"><img src="{{ URL::asset('public/front')}}/images/setting_icon.png" alt="" /></a>
						<div class="showHideCalendarPopup">
							<a href="javascript:void(0);" class="hideCalendar">Hide Calendar</a>
							<a href="javascript:void(0);" class="showCalendar active">Show Calendar</a>
						</div>
					</div>-->
					<ul class="week_cell clearfix">
						<li>
							<a href="javascript:void(0);" class="mwdclicked activepanecolorforrosterleftclass" data-id="month">MONTH</a>
						</li>
						<li>
							<a href="javascript:void(0);" class="mwdclicked" data-id="week">WEEK</a>
						</li>
						<li>
							<a href="javascript:void(0);" class="mwdclicked " data-id="daily">DAY</a>
						</li>
					</ul>
						<input type="hidden" id="hidmwd">
				</div>
				<div class="right_chart clearfix ">
					<!--<div class="month_input">
						<input type="text" placeholder="Month" />
					</div>-->
                    <div class="input-group input-daterange right_daterng_cust_wdth">
						<input type="button" data-toggle="modal" data-target="#exportICS" value="Export Events" class="btn export-data-button">
					</div>
                    <div class="select_cont search_select">
					 <?php
						$control_attrAr=array();
						$control_attrAr['id']='Category_roster';
						$control_attrAr['class']=" selectpicker";
						$control_attrAr['title']="Category";
						
						$cat_sub='';
						$fetchgenresubData=array();
						echo Form::select('cat_sub', $fetchgenresubData, $cat_sub,$control_attrAr);							
						?>
				  </div>
					 
					<div class="select_cont search_select">
					 <?php
						$control_attrAr=array();
						$control_attrAr['id']='Genre_guide';
						$control_attrAr['class']=" selectpicker";
						$control_attrAr['title']="Genre";
						
						$genre_sub='';
						$fetchgenresubData=array();
						echo Form::select('genre_sub', $fetchgenresubData, $genre_sub,$control_attrAr);							
						?>
					</div>
                    
                    
					
					
				</div>
			</div>
		</div>
		<div class="container">
			<div class="event_left calendarHeight">
				<div class="event_left_row">
					<h2 class="event_heading">Events</h2>
					<ul class="visitor_cols event_btn_group">
						<li>
							<a class="commnevttypecls" data-evnttypeshowflag="REDCLOCK" data-evntshowstatus="0" href="javascript:void(0);" style="background: #ff635c;">								
								<span class="evnttxtcls">Hide my pending bookings</span>
								<span class="commonaddminus add_icon"> </span>
							</a>
						</li>
						<li>
							<a class="commnevttypecls" data-evnttypeshowflag="STARICON" data-evntshowstatus="0" href="javascript:void(0);" style="background: #f1c40f;" >
								<span class="evnttxtcls"  >Hide events i am booked for</span>
								<span class="commonaddminus add_icon"> </span>
							</a>
						</li>
						<li>
							<a class="commnevttypecls" data-evnttypeshowflag="PURPLE" data-evntshowstatus="0" href="javascript:void(0);" style="background: #5a2e70;" >
								<span class="evnttxtcls" >Hide classified gigs</span>
								<span class="commonaddminus add_icon"> </span>
							</a>
						</li>
								
						<li>
							<a class="commnevttypecls" data-evnttypeshowflag="BLUEBOOK" data-evntshowstatus="0" href="javascript:void(0);" style="background: #64d0e4;" >
								<span class="evnttxtcls" >Hide events i have booked </span>
								<span class="commonaddminus add_icon"> </span>
							</a>
						</li>		
					</ul>
				</div>
				<div id="rosterleftlistresponseid" class="scrollforrosterleftclass">
				</div>
			</div>
			<div class="event_right calendarHeight" id="calendardivid" >
				<!--<img src="{{ URL::asset('public/front')}}/images/calender_img.png" alt="" />-->
				
			</div>
		</div>
	</section>
		
		<div class="modal fade" id="myRosterGigModal" tabindex="-1" role="dialog">
		<div id="gigrosterDiv"></div>
		</div>
		
		<div class="modal fade" id="exportICS" tabindex="-1" role="dialog">
				<div class="exportICSshow">
						<div class="modal-dialog popup-dialog" role="document">
								<div class="modal-content popup-content artist_popup">
								   <div class="modal-body popup-body">
									  <div class="artist_hedr request">
										 <button type="button" class="close popup-close " data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
										 <h2 id="booking">Export calendar events</h2>
									  </div>
									  <div class="artist_form_outr clearfix">
										 <div id="ridertet">
											<div class="col-md-12 margintop20">
											  <!-- <div class="inline artist_list">-->
												  <div class="input-group input-daterange">
													 <input id='frmdtpick' type="text" class="datepicker form-control export-date-text">
													 <span class="input-group-addon">to</span>
													 <input id='todtpick' type="text" class="datepicker form-control export-date-text">
													 <button type="button" class="btn export-button-width export-data-button" id="expoertEvents">Export</button>
												 </div>
											  <!--</div>-->
											</div>   
										 </div>
									  </div>
								   </div>
								</div>
						</div>
				</div>
		</div>
		
		<!-- modal for review start -->
				<div id="review_div_open"></div>
		<!-- modal for review end -->
		<!-- for fetching selected date from calender starts -->
		<script>
				var fetchedDate="";
				var mwd="";
				
				var evnttypeshowflagAr=[];
				var pro_category = '';
                                var pro_genre = '';
				
				evnttypeshowflagAr.push("REDCLOCK");
				evnttypeshowflagAr.push("STARICON");
				evnttypeshowflagAr.push("PURPLE");
				evnttypeshowflagAr.push("BLUEBOOK");
				
				//var evnttypeshowflag="REDCLOCK||STARICON||PURPLE||BLUEBOOK"; //"REDCLOCK","STARICON","PURPLE","BLUEBOOK","ALL"
				var evnttypeshowflag=evnttypeshowflagAr.join("||");


				//****script for modal open and close starts
									// $('#clickme').click(function(){
									// $( ".new-location" ).toggle();
									// $(this).parent().toggleClass('clickBorder');
									// $('.new-location').find('.form-control:eq(0)').focus();
									// });
									// $('.closeLoc').click(function(){
									// $(".new-location").toggle();
									// $(".reqField").removeClass('clickBorder');
									// });
				//****script for modal open and close ends
                          $('#frmdtpick').click(function(){
					
					$(".ui-datepicker").addClass('rosterdatepicker');
				 });				

		</script>
		<!-- for fetching selected date from calender ends -->
		
		<!-- for full callendar related   starts  -->	
		<link rel="stylesheet" href="{{ URL::asset('public/front')}}/otherfiles/fullcalendar2.8/fullcalendar.css">	
		<script type="text/javascript" src="{{ URL::asset('public/front')}}/otherfiles/fullcalendar2.8/fullcalendar.min.js"></script>
		<script type="text/javascript" src="{{ URL::asset('public/front')}}/otherfiles/progjs/frontendrosterfcalendar.js"></script>		
		<!-- for full callendar related   ends  -->			
		<!-- for gig related  starts modal starts  -->		
		<script type="text/javascript" src="{{ URL::asset('public/front')}}/otherfiles/progjs/frontendGigRoster.js"></script>
		<!-- for gig related  starts modal ends  -->
		
		<!-- for roster-leftpanel starts  -->		
		<script type="text/javascript" src="{{ URL::asset('public/front')}}/otherfiles/progjs/frontendroster.js"></script>
		<!-- for roster-leftpanel ends  -->
		<!-- for review rationg start lib start  -->
		<link rel="stylesheet" href="{{ URL::asset('public/front')}}/otherfiles/reviewratingstartlib/star-rating.css" media="all" rel="stylesheet" type="text/css"/>
		<script src="{{ URL::asset('public/front')}}/otherfiles/reviewratingstartlib/star-rating.js" type="text/javascript"></script>
		<!-- for review rationg start lib ends  -->
		
		<script src="{{ ADMINCSSPATH}}/js/bootstrap-datepicker.min.js"></script>
		<link rel="stylesheet" href="{{ URL::asset('public/admin')}}/otherfiles/progcss/bootstrap-datepicker3.min.css">
		<link href="{{ ADMINCSSPATH}}/css/datepicker.css" rel="stylesheet">
		<!--<link href="{{ ADMINCSSPATH}}/bootstrap/css/bootstrap.min.css" rel="stylesheet">-->
    
@endsection