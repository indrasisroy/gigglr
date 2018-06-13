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
		
		<link rel="stylesheet" href="{{ URL::asset('public/front')}}/otherfiles/fullcalendar2.8/fullcalendar.css">	
		<script type="text/javascript" src="{{ URL::asset('public/front')}}/otherfiles/fullcalendar2.8/fullcalendar.min.js"></script>
		<script>

	$(document).ready(function() {

		$('#calendardivid').fullCalendar({
			header: {
				left: 'title',
				
				right: 'prev,month,next'
			},
			defaultDate: '2016-06-12',
			editable: true,
			eventLimit: true, // allow "more" link when too many events
			//events: [
			//	
			//	
			//	{
			//		title: 'twitter',
			//		start: '2016-06-12T20:00:00'
			//	},
			//	{
			//		title: 'Google',
			//		start: '2016-06-12T20:00:00'
			//	},
			//	
			//	{
			//		title: 'facebook',
			//		start: '2016-06-12 20:10:20',
			//		end: '2016-06-12 30:15:20',
			//		url:'https://facebook.com'
			//		
			//	},
			//	
			//	
			//	
			//	{
			//		title: 'Birthday Party',
			//		start: '2016-06-13T07:00:00'
			//	},
			//	{
			//		title: 'Click for Google',
			//		url: 'http://google.com/',
			//		start: '2016-06-28'
			//	}
			//],
			
				   events: {
        url: base_url_data+'/giguserfeeds',
        type: 'POST',
        data: {
            custom_param1: 'something',
            custom_param2: 'somethingelse'
        },
        error: function() {
            alert('there was an error while fetching events!');
        },
        color: 'yellow',   // a non-ajax option
        textColor: 'black' // a non-ajax option
    },
			
			eventClick: function(calEvent, jsEvent, view) {
			
			console.log('Event: ' + calEvent.title);
			console.log('Coordinates: ' + jsEvent.pageX + ',' + jsEvent.pageY);
			console.log('View: ' + view.name);
			console.log('Event start date time: ' + calEvent.start.format("YYYY-MM-DD HH:mm" ));
			
			
			// change the border color just for fun
			//$(this).css('border-color', 'red');
			
			if ($(this).hasClass('highlightme')==false)
			{
				$(this).addClass('highlightme')
			}
			
			 if (calEvent.url) {
            window.open(calEvent.url);
            return false;
            }
			
			
			
			},
			
			eventMouseover :function ( event, jsEvent, view ) {
				
			console.log('Mouse over Event start date time: ' + event.start.format("YYYY-MM-DD HH:mm" ));
			
			if ($(this).hasClass('magnifycustclass')==false)
			{
				$(this).addClass('magnifycustclass')
			}
			
				},
				
			
			
			eventMouseout :function ( event, jsEvent, view ) {
				
			console.log('Mouse out Event start date time: ' + event.start.format("YYYY-MM-DD HH:mm" ));
			
			if ($(this).hasClass('magnifycustclass')==true)
			{
				$(this).removeClass('magnifycustclass');
			}
			
				},
		
		dayClick: function(date, jsEvent, view) {

        console.log('Clicked on: ' + date.format());

        console.log('Coordinates: ' + jsEvent.pageX + ',' + jsEvent.pageY);

        console.log('Current view: ' + view.name);

        // change the day's background color just for fun
        $(this).css('background-color', 'red');
		
		var chk=$(this).find(".magnifyclass");
		
		console.log(chk.length);
		
		if (chk.length==0)
		{
				$("#calendardivid").find(".magnifyclass").each(function(){
				
				$(this).removeClass("magnifyclass");
				
				});
				
		        var cntnt=$(this).html();
				cntnt+='<div class="magnifyclass"> add magnifying class </div>';
				$(this).html(cntnt);
		}
		else
		{
				
				//$(this).html('<div class="magnifyclass"> add magni </div>');
				
				
				
				
		}
		
		

        }		
			
				
			
		});
		
	});

</script>		
				
    
@endsection