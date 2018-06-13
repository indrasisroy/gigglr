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
							<a href="#">MONTH</a>
						</li>
						<li>
							<a href="#">WEEK</a>
						</li>
						<li>
							<a href="#">DAY</a>
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
				<div class="event_left_row">
					<h2>March 2015</h2>
					<ul class="event_list">
						<li class="zoom_nav"><a href="#">Natus Errorsit Volupta 12 ccusan</a></li>
						<li class="home_nav"><a href="#">Rackspace Peyments</a></li>
						<li class="like_nav"><a href="#">Tiny Cartridge $ 10</a></li>
						<li class="zoom_nav"><a href="#">Check Wii U game manuals</a></li>
						<li class="home_nav"><a href="#">Natus Errorsit Volupta 12 ccusan</a></li>
						<li class="like_nav"><a href="#">Rackspace Peyments</a></li>
					</ul>
				</div>
				<div class="event_left_row">
					<h2>February 2015</h2>
					<ul class="event_list">
						<li class="zoom_nav"><a href="#">Natus Errorsit Volupta 12 ccusan</a></li>
						<li class="home_nav"><a href="#">Rackspace Peyments</a></li>
						<li class="like_nav"><a href="#">Natus Errorsit Volupta 12 ccusan</a></li>
						<li class="home_nav"><a href="#">Rackspace Peyments</a></li>
						<li class="zoom_nav"><a href="#">Tiny Cartridge $ 10</a></li>
					</ul>
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
		
		<!-- for full callendar related   starts  -->	
		<link rel="stylesheet" href="{{ URL::asset('public/front')}}/otherfiles/fullcalendar2.8/fullcalendar.css">	
		<script type="text/javascript" src="{{ URL::asset('public/front')}}/otherfiles/fullcalendar2.8/fullcalendar.min.js"></script>
		<script type="text/javascript" src="{{ URL::asset('public/front')}}/otherfiles/progjs/frontendrosterfcalendar.js"></script>		
		<!-- for full callendar related   ends  -->			
		<!-- for gig related  starts modal starts  -->		
		<script type="text/javascript" src="{{ URL::asset('public/front')}}/otherfiles/progjs/frontendGigRoster.js"></script>
		<!-- for gig related  starts modal ends  -->	
		
				
    
@endsection