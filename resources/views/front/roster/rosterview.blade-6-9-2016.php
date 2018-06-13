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
							<a href="javascript:void(0);" class="mwdclicked" data-id="month">MONTH</a>
						</li>
						<li>
							<a href="javascript:void(0);" class="mwdclicked" data-id="week">WEEK</a>
						</li>
						<li>
							<a href="javascript:void(0);" class="mwdclicked activepanecolorforrosterleftclass" data-id="daily">DAY</a>
						</li>
					</ul>
						<input type="hidden" id="hidmwd">
				</div>
				<div class="right_chart clearfix">
					<!--<div class="month_input">
						<input type="text" placeholder="Month" />
					</div>-->
				</div>
			</div>
		</div>
		<div class="container">
			<div class="event_left sam_height">
				<div class="event_left_row">
					<h2 class="event_heading">Events</h2>
					<ul class="visitor_cols event_btn_group">
						<li>
							<a class="commnevttypecls" data-evnttypeshowflag="REDCLOCK" data-evntshowstatus="0" href="javascript:void(0);" style="background: #ff635c;">								
								<span class="evnttxtcls">Hide my pending bookings</span>
								<span class="add_icon"> </span>
							</a>
						</li>
						<li>
							<a class="commnevttypecls" data-evnttypeshowflag="STARICON" data-evntshowstatus="0" href="javascript:void(0);" style="background: #f1c40f;" >
								<span class="evnttxtcls"  >Hide events i am booked for</span>
								<span class="add_icon"> </span>
							</a>
						</li>
						<li>
							<a class="commnevttypecls" data-evnttypeshowflag="PURPLE" data-evntshowstatus="0" href="javascript:void(0);" style="background: #5a2e70;" >
								<span class="evnttxtcls" >Hide classified gigs</span>
								<span class="add_icon"> </span>
							</a>
						</li>
								
						<li>
							<a class="commnevttypecls" data-evnttypeshowflag="BLUEBOOK" data-evntshowstatus="0" href="javascript:void(0);" style="background: #64d0e4;" >
								<span class="evnttxtcls" >Hide events i have booked </span>
								<span class="add_icon"> </span>
							</a>
						</li>		
					</ul>
				</div>
				<div id="rosterleftlistresponseid" class="scrollforrosterleftclass">
				</div>
			</div>
			<div class="event_right sam_height" id="calendardivid" >
				<!--<img src="{{ URL::asset('public/front')}}/images/calender_img.png" alt="" />-->
				
			</div>
		</div>
	</section>
		
		<div class="modal fade" id="myRosterGigModal" tabindex="-1" role="dialog">
		<div id="gigrosterDiv"></div>
		</div>
		
		<!-- modal for review start -->
				<div id="review_div_open"></div>
		<!-- modal for review end -->
		<!-- for fetching selected date from calender starts -->
		<script>
				var fetchedDate="";
				var mwd="";
				
				var evnttypeshowflagAr=[];
				
				evnttypeshowflagAr.push("REDCLOCK");
				evnttypeshowflagAr.push("STARICON");
				evnttypeshowflagAr.push("PURPLE");
				evnttypeshowflagAr.push("BLUEBOOK");
				
				//var evnttypeshowflag="REDCLOCK||STARICON||PURPLE||BLUEBOOK"; //"REDCLOCK","STARICON","PURPLE","BLUEBOOK","ALL"
				var evnttypeshowflag=evnttypeshowflagAr.join("||");
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
    
@endsection