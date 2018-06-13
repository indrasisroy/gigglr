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
   
	$front_id_sess= session('front_id_sess');
	
	$eventfanmsg='Show Events I am a fan';
	$eventgenremsg='Show my profile genres only';
	$eventtownmsg='Hide events in my town';
	$eventfanshowflag='1';$eventgenreshowflag='1';	$eventtownshowflag='0';
	
	if(!empty($front_id_sess))
	{
		$eventfanshowflag='0';$eventgenreshowflag='0';	$eventtownshowflag='0';
		
		$eventfanmsg='Hide Events I am a fan';
		$eventgenremsg='Hide my profile genres';
		$eventtownmsg='Hide events in my town';
	}
   
?>
@extends('layouts.front.frontendmaster',['successmsg' => $successmsg,'errormsg'=>$errormsg])
@section('content')
	<section class="profile_outer event_back">
		<div class="container">
			<div class="event_slider">
                
				<?php
				if(!empty($gigtopsliderdata))
				{
				
				
					foreach($gigtopsliderdata as $gigtopsliderdataobj)
					{
					
						$type_flag=$gigtopsliderdataobj->type_flag;
					
						 //***** for profile image starts
					 
						// $image_with_pth = asset("front/otherfiles/progimages/"."noimagefound208X201.jpg");
						 $image_with_pth = BASEURLPUBLICCUSTOM."front/otherfiles/progimages/"."noimagefound208X201.jpg";
						 $image_name=$gigtopsliderdataobj->image_name;
						 if(!empty($image_name) &&  $image_name!="noimage")
						 {
											  if($type_flag==1)
											  {
											  //$image_with_pth=asset('upload/userimage/thumb-medium/'.$image_name);
															$image_with_pth=BASEURLPUBLICCUSTOM.'upload/userimage/thumb-medium/'.$image_name;
															
											  }
											  elseif($type_flag==2)
											  {
											 // $image_with_pth=asset('upload/groupimage/thumb-medium/'.$image_name);
															$image_with_pth=BASEURLPUBLICCUSTOM.'upload/groupimage/thumb-medium/'.$image_name;
											  }
											  elseif($type_flag==3)
											  {
											  //$image_with_pth=asset('upload/venueimage/thumb-medium/'.$image_name);
															$image_with_pth=BASEURLPUBLICCUSTOM.'upload/venueimage/thumb-medium/'.$image_name;
											  }
						 }
						 //***** for profile image ends
						 
						 
						 //***** for profile link starts
					
						$profilelinkurl=url('/');
						 if($type_flag==1)
						 {
							  $profilelinkurl.="/profile/".$gigtopsliderdataobj->seo_name;
						  }
						 elseif($type_flag==2)
						 {
								$profilelinkurl.="/groupprofile/".$gigtopsliderdataobj->seo_name;
						 }
						  elseif($type_flag==3)
						 {
							 $profilelinkurl.="/venue/".$gigtopsliderdataobj->seo_name;
						 }
						  //***** for profile link ends
					
					
					?>
						 <div class="item event_item">
					<a href="<?php echo $profilelinkurl; ?>" target="_blank">
						<div class="event_number">
							<?php echo date("m",strtotime($gigtopsliderdataobj->event_start_date_time)); ?>
						</div>
						<img width="147" height="122" src="<?php echo $image_with_pth; ?>" alt="" />
						<div class="event_name" style="background: rgba(251, 170, 55, 1);">
						<?php echo stripslashes( $gigtopsliderdataobj->profile_name ); ?>
						</div>
					</a>
						 </div>
					<?php
					}
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
					<!--<div class="month_input">
						<input type="text" placeholder="Month" />
					</div>-->
				</div>
			</div>
		</div>
		<div class="container">
			<div class="event_left calendarHeight mCustomScrollbar">
				<div class="event_left_row">
					<h2 class="event_heading">Events</h2>
					<ul class="visitor_cols event_btn_group">
						<li>
							<a data-showevntflag="<?php echo $eventfanshowflag='0'; ?>" class="mycustevntcls" data-filterevtype="EVENTFAN" href="javascript:void(0);" style="background: #ff635c;">								
								<span class="evntxtdtacls"  ><?php echo $eventfanmsg; ?></span>
								<span class="add_icon"> </span>
							</a>
						</li>
						<li>
							<a data-showevntflag="<?php echo $eventgenreshowflag; ?>" class="mycustevntcls" data-filterevtype="EVENTGENRE" href="javascript:void(0);" style="background: #f1c40f;" >
							<span class="evntxtdtacls" ><?php echo $eventgenremsg; ?></span>
								
								<span class="add_icon"> </span>
							</a>
						</li>
						<li>
							<a data-showevntflag="<?php echo $eventtownshowflag ;?>"  class="mycustevntcls" data-filterevtype="EVENTTOWN" href="javascript:void(0);" style="background: #64d0e4;">
								<span class="evntxtdtacls" ><?php echo $eventtownmsg; ?></span>
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
   
			<div id="calendardivid" class="event_right calendarHeight">
			<!-- <img src="{{ FRONTCSSPATH}}/images/calender_img.png" alt="" />-->
			</div>   
			   
		</div>
	</section>
	     <div class="modal fade" id="myModalGuide" tabindex="-1" role="dialog">
      <div class="Guidemodal"></div>		
   </div>

<script>
   var curr_lat_data='';
   var curr_long_data='';
	
	var evnttypeshowflagAr=[];
	
	<?php if(!empty($front_id_sess)){ ?>			
	evnttypeshowflagAr.push("EVENTFAN");
	evnttypeshowflagAr.push("EVENTGENRE");
	<?php } ?>
	evnttypeshowflagAr.push("EVENTTOWN");
				
	var filterevtype=evnttypeshowflagAr.join("||");	//console.log("on load =>"+filterevtype); //EVENTFAN||EVENTGENRE||EVENTTOWN		
	
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