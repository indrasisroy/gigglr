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
			<div class="event_slider">
                
				<?php
				for($cnt=1;$cnt<=7;$cnt++)
				{
				?>
                <div class="item event_item">
				<a href="#">
					<div class="event_number">30</div>
					<img src="{{FRONTCSSPATH}}/images/event_img3.png" alt="" />
					<div class="event_name" style="background: rgba(251, 170, 55, 1);">Andy Hart</div>
				</a>
                </div>
				<?php
				}
				?>
				  
			</div>
		</div>
		<div class="container">
			<div class="month-chart clearfix">
				<div class="left_chart">
					<!--<div class="setting_icon">
						<img src="images/setting_icon.png" alt="" />	
					</div>-->
					<ul class="week_cell clearfix">
						<li>
							<a href="javascript:void(0)" class="clickMWD" data-mdw="month">MONTH</a>
						</li>
						<li>
							<a href="javascript:void(0)" class="clickMWD" data-mdw="week">WEEK</a>
						</li>
						<li>
							<a href="javascript:void(0)" class="clickMWD" data-mdw="day">DAY</a>
						</li>
					</ul>
				</div>
					 <div class="right_chart clearfix">
						<div class="select_cont search_select">
						<?php
						$control_attrAr=array();
						$control_attrAr['id']='Category_guide';
						$control_attrAr['class']=" selectpicker";
						$control_attrAr['title']="Category";
						
						$genre_sub='';
						$fetchgenresubData=array();
						echo Form::select('genre_sub', $fetchgenresubData, $genre_sub,$control_attrAr);
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
						<!--<div class="month_input">
						<input type="text" placeholder="Month" />
						</div>-->
						</div>
			</div>
		</div>
		<div class="container">
			<div class="event_left sam_height mCustomScrollbar">
				<div class="event_left_row">
					<h2 class="event_heading">Events</h2>
					<ul class="visitor_cols event_btn_group">
						<li>
							<a class="mycustevntcls" data-filterevtype="EVENTFAN" href="javascript:void(0);" style="background: #ff635c;">								
								<span class="evntxtdtacls"  >Show Events i am a fan</span>
								<span class="add_icon"> </span>
							</a>
						</li>
						<li>
							<a class="mycustevntcls" data-filterevtype="EVENTGENRE" href="javascript:void(0);" style="background: #f1c40f;" >
							<span class="evntxtdtacls" >Show my profile genres only</span>
								
								<span class="add_icon"> </span>
							</a>
						</li>
						<li>
							<a  class="mycustevntcls" data-filterevtype="EVENTTOWN" href="javascript:void(0);" style="background: #5a2e70;">
								<span class="evntxtdtacls" >Show events in my town</span>
								<span class="add_icon"> </span>
							</a>
						</li>
					</ul>
				</div>
				<!--<div class="event_left_row">
					<h2>March 2015</h2>
					<ul class="event_list">
						<li class="zoom_nav"><a href="#">Natus Errorsit Volupta 12 ccusan</a></li>
						<li class="home_nav"><a href="#">Rackspace Peyments</a></li>
						<li class="like_nav"><a href="#">Tiny Cartridge $ 10</a></li>
						<li class="zoom_nav"><a href="#">Check Wii U game manuals</a></li>
						<li class="home_nav"><a href="#">Natus Errorsit Volupta 12 ccusan</a></li>
						<li class="like_nav"><a href="#">Rackspace Peyments</a></li>
					</ul>
				</div>-->
				<div id="gigleftpanneldvid"  >
				  
				</div>
				  
			</div>
   
			<div id="calendardivid" class="event_right sam_height">
			<!-- <img src="{{ FRONTCSSPATH}}/images/calender_img.png" alt="" />-->
			</div>   
			   
		</div>
	</section>

<script>
   var curr_lat_data='';
   var curr_long_data='';
   var filterevtype = 'EVENTTOWN'; //console.log("on load =>"+filterevtype); //EVENTFAN||EVENTGENRE||EVENTTOWN
   var pro_category = '';
   var pro_genre = '';
   var daymonth = 'month';
   
   
   var cal_select_date=moment().format('YYYY-MM-DD');
     
   
   
</script>
   
   <!--for latitude longitude starts-->
   <script type="text/javascript" src="https://www.google.com/jsapi"></script>
   <script type="text/javascript" src="{{ FRONTCSSPATH}}/otherfiles/progjs/latlongfromjsapi.js"></script>			
   <script type="text/javascript" src="{{ FRONTCSSPATH}}/otherfiles/progjs/latlongonlyfrombrowser.js"></script>
   <!--for latitude longitude starts-->  
   
<!-- for full callendar related   starts  -->	
<link rel="stylesheet" href="{{ URL::asset('public/front')}}/otherfiles/fullcalendar2.8/fullcalendar.css">	
<script type="text/javascript" src="{{ URL::asset('public/front')}}/otherfiles/fullcalendar2.8/fullcalendar.min.js"></script>
<script type="text/javascript" src="{{ FRONTCSSPATH}}/otherfiles/progjs/frontendgigguidepgcalendar.js"></script>	
<!-- for full callendar related   ends  -->	
  <script type="text/javascript" src="{{ FRONTCSSPATH}}/otherfiles/progjs/frontendgigguideleftpannel.js"></script> 

@endsection