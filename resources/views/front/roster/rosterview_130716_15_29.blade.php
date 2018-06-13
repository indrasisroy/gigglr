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
					<div class="setting_icon">
						<img src="{{ URL::asset('public/front')}}/images/setting_icon.png" alt="" />	
					</div>
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
				</div>
				<div class="right_chart clearfix">
					<div class="month_input">
						<input type="text" placeholder="Month" />
					</div>
				</div>
			</div>
		</div>
		<div class="container">
			<div class="event_left sam_height">
				<div class="event_left_row">
					<h2 class="event_heading">Events</h2>
					<ul class="visitor_cols event_btn_group">
						<li>
							<a href="#" style="background: #ff635c;">								
								Show events I am a fan of
								<span class="add_icon"> </span>
							</a>
						</li>
						<li>
							<a href="#" style="background: #f1c40f;" >
								Show pending bookings
								<span class="add_icon"> </span>
							</a>
						</li>
						<li>
							<a href="#" style="background: #5a2e70;" >
								Show classified gigs
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
				
		<!-- for fetching selected date from calender starts -->
		<script>
				var fetchedDate="";
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
		
				
    
@endsection