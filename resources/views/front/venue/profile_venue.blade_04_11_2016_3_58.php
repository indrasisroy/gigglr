
<?php

//echo $sessn_ID;
  $successmsg='';$errormsg='';
   if(!empty($successmsgdata))
   {
           $successmsg=$successmsgdata;
   }
   
   if(!empty($errormsgdata))
   {
           $errormsg=$errormsgdata;
   }
$first_name=''; $facebook_url=''; $twitter_url='';$metadescriptiondata ='';
$instagram_url='';	$youtube_url='';	$residentadvisor_url='';
$tech_speech = '';
$venue_creatr_id =0;
$venue_own_id ='';
 $user_description=''; $soundcloud_url='';$performence=0;$puntuality=0;$presentation=0;$roundofpuntulity=0;$roundofperformence=0;
 $facebook_url_actcls ="";$soundcloud_url_actcls="";$residentadvisor_url_actcls="";$twitter_url_actcls="";$youtube_url_actcls="";$instagram_url_actcls="";

	$fbold = 'https://www.facebook.com/';
    $soundcloud_url_deflt="https://www.soundcloud.com/";
    $residentadvisor_url_deflt="https://www.residentadvisor.net/";
    $twitter_url_deflt="https://www.twitter.com/";
    $youtube_url_deflt="https://www.youtube.com/";
    $instagram_url_deflt="https://www.instagram.com/";


$roundofpresentation=0;
$venue_name='';
$venue_descp='Content Not Available';
$venue_lat='25.2744';$venue_long='133.7751';

$venue_status = 0;
$available_for = 3;
$security_figure = '';
$opening_time = '';
$closing_time = '';
$rate_amount='';

$cal_viewshowflag=1;
$cal_pendingbkshowflag=1;
$cal_publiceventshowflag=1;
$cal_privateeventshowflag=1;
$review_show_flag=1;

    $fetchskillmasterArData=array();
	
	$fetchcountrydata = array();
	$fetchbookingcatData = array();
   $fetchimgData = array();
   
   $fetchbookingskillcategory =array();
    $filterevtype=''; $filterevtypeAr=array();
   
   if(!empty($fetchuserdata))
   {
   	$metadescriptiondata = $fetchuserdata->venue_meta_data;

        $cal_viewshowflag=$fetchuserdata->cal_viewshowflag;
	  $cal_pendingbkshowflag=$fetchuserdata->cal_pendingbkshowflag;
	  $cal_publiceventshowflag=$fetchuserdata->cal_publiceventshowflag;
	  $cal_privateeventshowflag=$fetchuserdata->cal_privateeventshowflag;
	  $review_show_flag=$fetchuserdata->review_show_flag;
   
   
	if($fetchuserdata->status)
	$venue_status=$fetchuserdata->status;

	if($fetchuserdata->creater_id)
	$venue_creatr_id=$fetchuserdata->creater_id;


 
//********* social networking check starts here
	if($fetchuserdata->facebook_url)
	{
		$facebook_url = $fetchuserdata->facebook_url;
		if($facebook_url== $fbold)
		{
			$facebook_url_actcls = 'deactive';
		}
		
	}else if(!$fetchuserdata->facebook_url)
	{
		$facebook_url_actcls = 'deactive';
	}
	if($fetchuserdata->soundcloud_url)
	{
		$soundcloud_url = $fetchuserdata->soundcloud_url;
		if($soundcloud_url== $soundcloud_url_deflt)
		{
			$soundcloud_url_actcls = 'deactive';
		}
		
	}else if(!$fetchuserdata->soundcloud_url)
	{
		$soundcloud_url_actcls = 'deactive';
	}
	if($fetchuserdata->residentadvisor_url)
	{
		$residentadvisor_url = $fetchuserdata->residentadvisor_url;
		if($residentadvisor_url==$residentadvisor_url_deflt)
		{
			$residentadvisor_url_actcls = 'deactive';
		}
		
	}else if(!$fetchuserdata->residentadvisor_url)
	{
		$residentadvisor_url_actcls = 'deactive';
	}
	if($fetchuserdata->twitter_url)
	{
		$twitter_url = $fetchuserdata->twitter_url;
		if($twitter_url==$twitter_url_deflt)
		{
			$twitter_url_actcls = 'deactive';
		}
		
	}else if(!$fetchuserdata->twitter_url)
	{
		$twitter_url_actcls = 'deactive';
	}
	if($fetchuserdata->youtube_url)
	{
		$youtube_url = $fetchuserdata->youtube_url;
		if($youtube_url==$youtube_url_deflt)
		{
			$youtube_url_actcls = 'deactive';
		}
		
	}else if(!$fetchuserdata->youtube_url)
	{
		$youtube_url_actcls = 'deactive';
	}
	if($fetchuserdata->instagram_url)
	{
		$instagram_url = $fetchuserdata->instagram_url;
		if($instagram_url==$instagram_url_deflt)
		{
			$instagram_url_actcls = 'deactive';
		}
		
	}else if(!$fetchuserdata->instagram_url)
	{
		$instagram_url_actcls = 'deactive';
	}


//********* social networking check ends here



	if($fetchuserdata->id)
	$venue_own_id=$fetchuserdata->id;

    
	if($cal_pendingbkshowflag==1)
         {
            $filterevtypeAr[]="REDCLOCK";
         }
         if($cal_publiceventshowflag==1)
         {
            $filterevtypeAr[]="YELLOWSTAR";
         }
         
         if($cal_privateeventshowflag==1)
         {
            $filterevtypeAr[]="BLACKSTAR";
         }
         
         if(!empty($filterevtypeAr))
         {
            $filterevtype=implode("||",$filterevtypeAr);
         }
    
    
    
	if($fetchuserdata->nickname)
	$venue_name=$fetchuserdata->nickname;
	if($fetchuserdata->venue_description)
	$venue_descp = $fetchuserdata->venue_description;

	if($fetchuserdata->venue_lat)
	$venue_lat = $fetchuserdata->venue_lat;
	if($fetchuserdata->venue_long)
	$venue_long = $fetchuserdata->venue_long;



	if($fetchuserdata->tech_spec)
	$tech_speech = stripslashes($fetchuserdata->tech_spec);


	if($fetchuserdata->available_for)
	$available_for = $fetchuserdata->available_for;

	if($fetchuserdata->security_figure!='0.00')
	$security_figure = $fetchuserdata->security_figure;


	if($fetchuserdata->rate_amount!='0.00')
	{
	$rate_amount = $fetchuserdata->rate_amount;
	}
	else
	{
		$rate_amount='';
	}


 if($fetchuserdata->opening_time)
	 $opening_time = $fetchuserdata->opening_time;

 if($fetchuserdata->closing_time)
	 $closing_time  = $fetchuserdata->closing_time;
	
   }
      if(!empty($venue_master_img_db))
   {
	 $fetchimgData = $venue_master_img_db;
   }          
	if(!empty($fetchskillmasterAr))
	{
	$fetchskillmasterArData=$fetchskillmasterAr;
	$fetchbookingcatData = $fetchskillmasterAr;
	}
   if(!empty($venuebooking_skill))
   {
   
     $fetchbookingskillcategory =$venuebooking_skill;
   }
   
    if(!empty($country_result))
   {
	  $fetchcountrydata = $country_result;

   }

$flagBkGrp = Request::segment(3);

if($flagBkGrp!='' && $flagBkGrp=='bk'){
$flagBkGrp='1';
}
else
{
	$flagBkGrp='0';
}

 $puntualityardata_artist=0;
   if($puntualityardata)
    $puntualityardata_artist = $puntualityardata;

   $performenceardata_artist=0;
   if($performenceardata)
    $performenceardata_artist = $performenceardata;

  $presentationardata_artist=0;
   if($presentationardata)
    $presentationardata_artist = $presentationardata;
    
     //****** code to get seoname from url 
   $seo_name=Request::segment(2); 

?>

@extends('layouts.front.frontendmaster',['successmsg' => $successmsg,'errormsg'=>$errormsg,'metadescriptiondata'=>$metadescriptiondata])
@section('content')

	<!-- profile-section-start -->
	<section class="profile_outer">
		<div class="container">
			<div class="row dj_row">
				<div class="col-sm-5">
					<div class="profile_slider myvenuesliderouterdv">
					
					
					 <?php
				     // $imgurldata = asset("front/otherfiles/progimages/"."noimagefound537X507.png");
                      $imgurldata = BASEURLPUBLICCUSTOM."front/otherfiles/progimages/"."noimagefound537X507.png";
					  if(!empty($fetchimgData))
					  {

					  foreach($fetchimgData as $fetchimgData)
					  {
                      
                        // $imgurl = asset('upload/venueimage/thumb-big/'.$fetchimgData->image_name);
                       $imgurl = BASEURLPUBLICCUSTOM.'upload/venueimage/thumb-big/'.$fetchimgData->image_name;
					  ?>
					  <div class="item" style="background-image: url({{ $imgurl}});">
					  </div>
					  <?php
					  }
					  }else
					  {
                      
					 // $imgurldata = asset("front/otherfiles/progimages/"."noimagefound537X507.png");
                      $imgurldata = BASEURLPUBLICCUSTOM."front/otherfiles/progimages/"."noimagefound537X507.png";
                      ?>
					  <div class="item" style="background-image: url({{ $imgurldata}});">
					  </div>
					  <?php
					  }
					  ?>
						
					</div>
				</div>
				<div class="col-sm-7">
					<h2 class="prifile_heading">{{stripslashes($venue_name)}}</h2>
					<!-- hidden latitude and hidden longitude -->
					<!-- <input type="number" class="mydisplaynone" id="hiddentlat" value="-33"><input type="number" class="mydisplaynone" id="hiddentlong" value="151"> -->


					<div class="like_box">
						<a href="profile.html#review" class="add_link red-tooltip goTo" data-go-to="review_section" data-toggle="tooltip" title="Review"><img src="{{ FRONTCSSPATH}}/images/plus_icon.png" alt="" /></a>
                        
                        
                        
                        <!-- this section for implement myfavorite start-->
						
						
						<?php
						
						   $myfavoriteFlag = '';
						   $myfavoriteClass = '';
						   if($favorite != ''){
							  if($favorite == '1'){
								 $myfavoriteClass = 'proflhearbuttonactv';
							  }
						   }
						
						?>
						
						
						
						<!-- this section for implement myfavorite end-->
                        
                        
                      <?php  
                        if($sessn_ID == $venue_creatr_id)
								{ ?>
						<a href="javascript:void(0)" class="like_link red-tooltip goTo myfavorite deactive <?php echo $myfavoriteClass;?>" data-usertype="3" data-userId="<?php echo $fetchuserdata->id?>" data-go-to="Favorite_section"  data-toggle="tooltip" title="Favorite"><img src="{{ FRONTCSSPATH}}/images/heart_icon.png" alt="" /></a>
                            <?php
                            }else
                            {
                            ?>
                            	<a href="javascript:void(0)" class="like_link red-tooltip goTo myfavorite <?php echo $myfavoriteClass;?>" data-usertype="3" data-userId="<?php echo $fetchuserdata->id?>" data-go-to="Favorite_section"  data-toggle="tooltip" title="Favorite"><img src="{{ FRONTCSSPATH}}/images/heart_icon.png" alt="" /></a>
                         <?php   }
                            ?>
                        
						<a href="profile.html#calendr" class="red-tooltip goTo" data-go-to="Calender_section" data-toggle="tooltip" title="Calender"><img src="{{ FRONTCSSPATH}}/images/calender_icon.png" alt="" /></a>
					</div>
					<div class="name_holder">
						
						
						<!--<div class="mainCategory">VENUE:</div>  -->
						<!--<div class="gener">CLUB,</div><div class="gener">BAR,</div><div class="gener">RESTAURANT.</div>-->
						  <!--skill starts -->
						   <?php
                  if(!empty($skill_user_db))
                  {
                  	foreach($skill_user_db as $skill_user_obj)
                  	{
                  		$skill_parent_data=$skill_user_obj->skill_id;
                  		$skill_parent_txtdata=stripslashes($skill_user_obj->skill_name);
                  		$skill_sub_data_str=$skill_user_obj->skill_sub_id;
                  		$skill_sub_txtdata_str=$skill_user_obj->skill_sub_name;
                  		$skill_sub_data_Ar=explode(",",$skill_sub_data_str);
                  		$skill_sub_txtdata_Ar=explode(",",$skill_sub_txtdata_str);
                  		
                  ?>
               
                  <div class="mainCategory"><?php echo $skill_parent_txtdata; ?>:</div>
                  <?php
                     if(!empty($skill_sub_data_Ar))
                     {
                     	$skill_lim =  count($skill_sub_data_Ar);
                     	$i = 0;
                     	
                     		foreach($skill_sub_data_Ar as $kk => $kvlue)
                     		{
                     			$i++;
                     			$skill_sub_data=$skill_sub_data_Ar[$kk];
                     			$skill_sub_txtdata=$skill_sub_txtdata_Ar[$kk];
                     ?>
                  <div class="gener" data-skillparent='<?php echo $skill_parent_data; ?>'  data-skillsub='<?php echo $skill_sub_data; ?>' >
                     <?php echo $skill_sub_txtdata; ?><?php if($i == $skill_lim){echo ".";}else{echo ",";}?>
                  </div>
                  <?php
                     }
                     }
                     ?>
               
               <?php
                  }
                  }
                  ?>
						  <!--skill ends-->
						  
						  
						  
					</div>
					<div class="row row_visitor">
						<ul class="col-sm-6 visitor_cols venuevisitor">


<?php 

if($facebook_url!= '' && $facebook_url!= $fbold)
{

?>

							<li class="{{$facebook_url_actcls}}">
								<a href="{{$facebook_url}}" target="_blank">
									<span class="icon_social" style="background: #3b5998;"><img src="{{ FRONTCSSPATH}}/images/fb_icon.png" alt="" /></span>
									facebook
									<!--<span class="add_icon"> </span>-->
								</a>
							</li>
<?php 

}

?>
<?php 
if($soundcloud_url!='' && $soundcloud_url!= $soundcloud_url_deflt)
{

?>



							<li class="{{$soundcloud_url_actcls}}">
								<a href="{{$soundcloud_url}}" target="_blank">
									<span class="icon_social" style="background: #ff7e30;"><img src="{{ FRONTCSSPATH}}/images/cloud_icon.png" alt="" /></span>
									Soundcloud
									<!--<span class="add_icon"> </span>-->
								</a>
							</li>

						<?php
						 }
						?>	

<?php 
if($residentadvisor_url!='' && $residentadvisor_url!=$residentadvisor_url_deflt)
{
?>

							<li class="{{$residentadvisor_url_actcls}}">
								<a href="{{$residentadvisor_url}}" target="_blank">
									<span class="icon_social" style="background: #ffff00;"><img src="{{ FRONTCSSPATH}}/images/advisor_icon.png" alt="" /></span>
									Resident Advisor
									<!--<span class="add_icon"> </span>-->
								</a>
							</li>

<?php 

}

?>
<?php 
if($twitter_url!='' && $twitter_url!=$twitter_url_deflt)
{
?>



							<li class="{{$twitter_url_actcls}}">
								<a href="{{$twitter_url}}" target="_blank">
									<span class="icon_social" style="background: #00aced;"><img src="{{ FRONTCSSPATH}}/images/tweeter_icon.png" alt="" /></span>
									Twitter
									<!--<span class="add_icon"> </span>-->
								</a>
							</li>
							<?php 

}
							?>

<?php 
if($youtube_url!='' && $youtube_url!=$youtube_url_deflt)
{

?>


							<li class="{{$youtube_url_actcls}}">
								<a href="{{$youtube_url}}" target="_blank">
									<span class="icon_social" style="background: #e32b21;"><img src="{{ FRONTCSSPATH}}/images/youtube_icon.png" alt="" /></span>
									YouTube
									<!--<span class="add_icon"> </span>-->
								</a>
							</li>

<?php 

}
?>
<?php 
if($instagram_url!='' && $instagram_url!=$instagram_url_deflt)
{

?>

							<li class="{{$instagram_url_actcls}}">
								<a href="{{$instagram_url}}">
									<span class="icon_social" style="background: #2e5e84;"><img src="{{ FRONTCSSPATH}}/images/instagram_icon.png" alt="" /></span>
									Instagram
									<!--<span class="add_icon"> </span>-->
								</a>
							</li>

<?php 

}
?>

						</ul>
						<div class="col-sm-6 visitor_cols">
							<div class="btn_row">
							<?php
							if($sessn_ID =='')
							{ ?>

								<a href="javascript:void(0)" class="book_btn" onclick="checkvenuebookingavailability(1);">book venue</a>
							<?php 
						    }
						    //else if($hourlyrateflag == '0.00')
						    //{
                            //echo '<a href="javascript:void(0)" class="book_btn bk_venue openbkgrpcls" onclick="no_hourlyrate()">book venue</a>';
						    //}
						    else
							{
								if($sessn_ID == $venue_creatr_id)
								{ ?>
									<a href="javascript:void(0)" class="book_btn bk_venue openbkgrpcls deactive" onclick="checkvenuebookingavailability(2);">book venue</a>
							<?php	}
								else
								{
									if($venue_status == 1){
									?>
									<!--<a href="#" class="book_btn bk_venue openbkgrpcls" data-toggle="modal" data-target="#myModal5">book venue</a>-->
                                    <a href="javascript:void(0)" class="book_btn openbkgrpcls currencyVenBook" data-currency="<?php echo $venue_currency;?>" >book venue</a>
									<?php	}
								 else
						{ ?>
								<a href="#" class="book_btn bk_venue openbkgrpcls" onclick="checkvenuebookingavailability(3);">book venue</a>
					<?php
						}
								
							} }?>

							</div>
							<div class="btn_row">
								<!--<a href="#" class="book_btn press_btn pkt_venue">press kit</a>-->
								 <?php
								 
                      if($presskitvenue!='')
                      {
                            $presssecure = 'presskitdownloadvenue/'.base64_encode($presskitname = $presskitvenue->presskit_name);
                      
							echo link_to($presssecure, $title = 'press kit', $attributes = array("class"=>"book_btn press_btn","target"=>"_blank"), $secure = null);
                      }else
                     {

                          //echo link_to('#', $title = 'press kit', $attributes = array("class"=>"book_btn press_btn"), $secure = null);
                          ?>
                          <a href="#" class="book_btn press_btn deactive" onclick="showno_presskit()">press kit</a>

                     	 <?php 
                  		}
							?>
							</div>
							<div class="btn_row">

									<?php
									 
									if($venuemenu!='')
									{
									$venuemenusecure = 'menudownloadvenue/'.base64_encode($venuemenuname = $venuemenu->menu_name);

									echo link_to($venuemenusecure, $title = 'menu', $attributes = array("class"=>"book_btn rider_btn mnu_venue","target"=>"_blank"), $secure = null);
									}else
									{
									//echo link_to('#', $title = 'menu', $attributes = array("class"=>"book_btn rider_btn mnu_venuebook_btn press_btn"), $secure = null); showno_menu 
										?>
									<a href="#" class="book_btn rider_btn mnu_venuebook_btn press_btn deactive" onclick="showno_menu()">menu</a>
									<?php 
								}
									?>

								<!-- <a href="#" class="book_btn rider_btn mnu_venue">menu</a> -->




							</div>


							
							 <div class="btn_row">
                     <div class="rank_cell">
                        Performance
                        <div class="star_cell">
                             <?php

                             if($performenceardata_artist > 0)

                          {
                            for($performnc = 0;$performnc<$performenceardata_artist;$performnc++)
                            {?>
                                <span><img src="{{ FRONTCSSPATH}}/images/star_icon.png" alt="" /></span>
                        <?php    }
                      }else
                      {
                        echo "N/A";
                      }
                            ?>

                        </div>
                     </div>
                  </div>
                  <div class="btn_row">
                     <div class="rank_cell">
                        Presentation
                        <div class="star_cell">
                             <?php

                             if($presentationardata_artist > 0)
                             {

                            for($presentn = 0;$presentn<$presentationardata_artist;$presentn++)
                            {?>
                                <span><img src="{{ FRONTCSSPATH}}/images/star_icon.png" alt="" /></span>
                        <?php    }

                      }else
                      {
                        echo "N/A";
                      }



                            ?>

                        </div>
                     </div>
                  </div>
                  <div class="btn_row">
                     <div class="rank_cell">
                        Punctuality
                        <div class="star_cell">
                            
                            <?php

                            if($puntualityardata_artist > 0)
                            {

                            for($puncual = 0;$puncual<$puntualityardata_artist;$puncual++)
                            {?>
                                <span><img src="{{ FRONTCSSPATH}}/images/star_icon.png" alt="" /></span>
                        <?php    }
                      }else
                      {
                        echo "N/A";
                      }
                            ?>

                        </div>
                     </div>
                  </div>


						</div>
					</div>
				</div>
			</div>
            <div class="row">
             <div class="col-md-5">
                <!-- <h3 class="prf_venue">Teddington, Middlesex</h3> -->
                 <div class="pf-venue">
                <p class="prf_venue_lst">{{stripslashes($venue_descp)}} </p>
                     </div>
             </div>
				
					
             <div class="col-md-7">
                <div class="prf_venue_slidr">
                  <div class="venue_prf_slider">
				  <?php
				  if($venue_amenityimg_data!='')
				  {
				  foreach($venue_amenityimg_data as $amenityimg_data)
					{
					?>
					<div class="item pf_venue">
					<a class="pf_venu_sldr" href="#">
					
					 <img src="{{ BASEURLPUBLICCUSTOM}}/upload/amenities-image/source-file/{{$amenityimg_data->amenity_img}}" alt="" />
					
					</a>
					</div>
					<?php
					}
				  }
				  
				  ?>
				 

			</div>
                </div>
                 <div class="prf_venue_map mapclass" id="map" >
                   
                 </div>
             </div>
            </div>
<!--            <p class="prf_venue_lst">-->
<!--			Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim quam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, quam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam,ncidunt ut Nemo enim quam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa.</p>-->

		</div>
	</section>	
      
    <!-- endof payment -->
    <?php if( !empty($cal_viewshowflag) && ( $cal_viewshowflag==1 ) ) { ?>    
	<section class="profile_outer event_section" id="Calender_section">
	<div class="container">
			<div class="month-chart clearfix">
				<div class="left_chart">
					<!--<div class="setting_icon">
						<img src="{{ FRONTCSSPATH}}/images/setting_icon.png" alt="" />	
					</div>-->
                <ul class="week_cell clearfix">
                    <li>
                                 <a href="javascript:void(0)" class="activepanecolorforrosterleftclass" id="monthlink" >MONTH</a>
                    </li>
                    <li>
                                 <a href="javascript:void(0)" id="weeklink">WEEK</a>
                    </li>
                    <li>
                                 <a href="javascript:void(0)" id="daylink">DAY</a>
                    </li>
                </ul>
				</div>
				<div class="right_chart clearfix profileCatFen">					
				</div>
                 
                    
			</div>
		</div>
		<div class="container">
			<div class="event_left calendarHeight">
				<div class="event_left_row">
					<h2 class="event_heading">Events</h2>
					<ul class="visitor_cols event_btn_group">
						<!--<li>
							<a href="#" style="background: #ff635c;">								
								Display Events i am a fan
								<span class="add_icon"> </span>
							</a>
						</li>
						<li>
							<a href="#" style="background: #f1c40f;" >
								Display All Events in my town
								<span class="add_icon"> </span>
							</a>
						</li>
						<li>
							<a href="#" style="background: #5a2e70;" >
								Show Classifeid gigs
								<span class="add_icon"> </span>
							</a>
						</li>-->
                        <li>
				  <a href="javascript:void(0);" style="background: #ff635c;" class="allprofileeventcls" data-evtypeflag="<?php echo $cal_pendingbkshowflag;?>" data-evtype="REDCLOCK" data-typeflag="1" data-artistgrpvenueseo="<?php echo $seo_name;?>" data-pendbkpblshowfl="cal_pendingbkshowflag" data-pendingbkshowflag="1">								
				  <span class="pendbkpblshowflmsgcls">Pending Bookings</span>
				  <span class="pendbkpblshowflicocls add_icon"> </span>
				  </a>
			   </li>
				  
			   <li>
				  <a href="javascript:void(0);" style="background: #f1c40f;" class="allprofileeventcls" data-evtype="YELLOWSTAR" data-evtypeflag="<?php echo $cal_publiceventshowflag;?>" data-typeflag="1" data-artistgrpvenueid="<?php echo session('front_id_sess');?>" data-pendbkpblshowfl="cal_publiceventshowflag" data-pendingbkshowflag="1" >
				  <span class="pendbkpblshowflmsgcls">Public Events</span>
				  <span class="pendbkpblshowflicocls add_icon"> </span>
				  </a>
			   </li>
			   <li>
				  <a href="javascript:void(0);" style="background: #525252;" class="allprofileeventcls" data-evtype="BLACKSTAR" data-evtypeflag="<?php echo $cal_privateeventshowflag;?>" data-typeflag="1" data-artistgrpvenueid="<?php echo session('front_id_sess');?>" data-pendbkpblshowfl="cal_privateeventshowflag" data-pendingbkshowflag="1" >
				  <span class="pendbkpblshowflmsgcls">Private Events</span>
				  <span class="pendbkpblshowflicocls add_icon"> </span>
				  </a>
			   </li> 
                         <!----ends-->
                        
                        
					</ul>
				</div>
                 
                <div class = 'loadLeftGigList'></div>   
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
				</div>-->
                    
                    
			</div>
			<div id="calendardivid" class="event_right calendarHeight">
				<!--<img src="{{ FRONTCSSPATH}}/images/calender_img.png" alt="" />-->
			</div>
		</div>
	</section>	
	
    <?php } ?>
    
     <?php if( !empty($review_show_flag) && ( $review_show_flag==1 ) ) { ?>
    <section class="profile_outer" id="review_section">
		<div class="container">
			<h3 class="review_head">Review</h3>
			<div class="row review_row">


				 <?php
	 if(!empty($user_testi))
     {
       // echo count($user_testi);
	 foreach($user_testi as $userreview)
     {
          $ratingreview = $userreview->punctuality+$userreview->performance+$userreview->presentation;
          $ratinground = $ratingreview/5; 
         if($ratinground>0 && $ratinground<=0.6)
         {
             $points = 1;
        }else if($ratinground>0.6 && $ratinground<=1.2)
         {
              $points = 2;
         }
         else if($ratinground>1.2 && $ratinground<=1.8)
         {
              $points = 3;
         }
         else if($ratinground>1.9 && $ratinground<=2.4)
         {
              $points = 4;
         }
         else if($ratinground>2.4 && $ratinground<=3.0)
         {
              $points = 5;
         }
           
          ?>
         <div class="col-sm-6 review_cols">
          <div class="review_cell clearfix">
   
          <div class="review_img_cell">
            <div class="prodile_img"><img alt="" src="{{ FRONTCSSPATH}}/otherfiles/progimages/noimagefound52X52.jpg"></div>
       {{$userreview->nickname}}
             </div>
               <div class="review_cont_cell">
             <p>
             {{$userreview->agv_review_data}}
         </p>
                  <div class="clearfix">
         <ul class="review_date">
                   <li>
                       <img src="{{ FRONTCSSPATH}}/images/calender_icon.png" alt="" /> 
                       <?php 
         
                             $review_date =$userreview->agv_review_date;
                             echo   date('j F, Y',strtotime($review_date));
                       ?>
                        </li>
                            
                            <!-- incluede category and genre start-->
						   <?php
						   	 if(!empty($cat_gen)){
							 foreach($cat_gen as $cat_gen_arr){
							 
									if($cat_gen_arr['gigmaster_id'] == $userreview->gigmaster_id){
									
									   echo "<li>".$cat_gen_arr['category'].': '.$cat_gen_arr['genre']."</li>";
									   // echo "<li> ".$cat_gen_arr['genre']."</li>";
									   
									}
							 }

							 }
						   ?>
						   <!-- incluede category and genre end -->
                            
                            
                 <li>
                     <?php 
         
                             $review_time =$userreview->agv_review_date;
                             echo   date('g:i A',strtotime($review_time)).' | ';
                       ?>
                      
                          <span class="star_feed">
                             <?php 
                      
                              for($i=0;$i<$points;$i++)
                              {
                              ?> 
                              <img src="{{ FRONTCSSPATH}}/images/yellow_star.png" alt="" /> 

                     <?php
                              }
                              ?>
                        </span>
                </li>
        </ul>
              <div class="form_right">
         <img src="{{ FRONTCSSPATH}}/images/location_icon.png" alt="" />
                  <?php 
                  
                  if($userreview->city=='')
                  {
                      echo "Location not available";
                  }else{
                      echo ucfirst(trans($userreview->city));
                  }
                  ?>
            
                    </div>
               </div>
            </div>
            </div>
         </div>
    <?php }
	 ?>
	 
	 
	 <?php
	 
	 
	 
	 }else
	 {
	   echo "No Reviews Found";
	 }
          
          
	  ?>


			</div>
		</div>
	</section>	

    <?php } ?>
    
<!-- Modal -->

<!-- Modal -->

<!--	post a gig -->
      
   
   
   


<div class="modal fade" id="myModal5" tabindex="-1" role="dialog" >
   <div class="modal-dialog popup-dialog" role="document">
      <div class="modal-content popup-content artist_popup">
         <div class="modal-body popup-body">
            <div class="artist_hedr request booking_request">
               <button type="button" class="close popup-close " data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
               <h2 id="booking">Booking Request</h2>
            </div>
            <div class="artist_form_outr clearfix">
               <!--<form>-->
               <?php
                  echo Form::open(array('url' => '',
                  'method' => 'post',
                  'id'=>'bookingform',
                  'class'=>"",
				  'autocomplete'=>'off'
                  ));
                  ?>
               <div class="alert error" style="display: none;">Your booking failed</div>
               <div class="alert success" style="display: none;">Your booking successfully</div>
               <div class="Constitution-inner-first artist_list">
                  
                 
               <!--   <span>Public Event:</span>
                 <div class="radio_in">
                     <?php 
                       // echo Form::radio('radio', '1', false,$attributes = array("id"=>"radio1"));
                        ?>
                     <label for="radio1"><span><span></span></span>Yes</label>
                  </div>
                  <div class="radio_in">
                     <?php 
                       // echo Form::radio('radio', '2', true,$attributes = array("id"=>"radio2"));
                        ?>
                     <label for="radio2"><span><span></span></span>No</label>
                  </div>
 -->
 				 <?php
		if($available_for == '3')
         {
			   ?>
			    <span>Public Event:</span>
                 <div class="radio_in">
                     <?php 
                        echo Form::radio('radio_entry_type', '1', false,$attributes = array("id"=>"radio1"));
                        ?>
                     <label for="radio1"><span><span></span></span>Yes</label>
                  </div>
                  <div class="radio_in">
                     <?php 
                        echo Form::radio('radio_entry_type', '2', true,$attributes = array("id"=>"radio2"));
                        ?>
                     <label for="radio2"><span><span></span></span>No</label>
                  </div>
			   <?php
			   }
         else
         {
			   ?>
			   <span>
				  <?php
				  if($available_for == '1'){
				  echo "Public Event: Public Only";
				  }else{
				  echo "Public Event: Private Only";
				  }
				  ?>
			   </span>
			   <?php
			   }
			   ?>


               </div>

               <div class="row">
                  <!--For address1-->
                 
                 
                  <!--------------------------For Town and Zip ends here-------------------------------->
                  <div class="col-md-6">
                     <div class="artist_divsn">
                        <div class="inline artist_list request_list">
                           <?php
                              $control_attrAr=array();
                              $control_attrAr['id']='bookingcat_subvenue';
                              $control_attrAr['class']="selectpicker artist_txt";
                              $control_attrAr['title']="Category for Event";
                              $bookingcat_sub='';
                              echo Form::select('bookingcat_subvenue',
                              $fetchbookingskillcategory,
                              $bookingcat_sub,
                              $control_attrAr
                              );							
                              ?>
                        </div>
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="artist_divsn">
                        <div class="inline artist_list request_list">
                           <?php
                              $control_attrAr=array();
                              $control_attrAr['id']='bookinggenre_sub';
                              $control_attrAr['class']="selectpicker artist_txt";
                              $control_attrAr['title']="Genre for Event";
                              $bookinggenre_sub='';
                              $fetchbookinggenreData=array();
                              echo Form::select('bookinggenre_sub',
                              $fetchbookinggenreData,
                              $bookinggenre_sub,
                              $control_attrAr
                              );								
                              ?>
                        </div>
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="inline artist_list">
                        <span>Date of Event:</span>
                        <div class="form-group inpt input-customm">
                           <div class='input-group date'>
                              <?php    
                                 echo Form::text("booking_date",
                                 $value='',
                                 $attributes = array( "id"=>"booking_date",
                                 "class"=>"form-control date_outr datetimepicker",
                                
                                 ));
                                 ?>
                              <span class="input-group-addon dt">
                              <span class="glyphicon glyphicon-calendar clndr"></span>
                              </span>
                           </div>
                        </div>
                     </div>
                     <div class="inline artist_list">
                        <span>Start Time:</span>
                        <div class="form-group inpt input-customm">
                           <div class='input-group date' id='datetimepicker3'>
                              <!--<input type='text' class="form-control clck_outr timepicker" placeholder="3.15 pm"/>-->
                              <?php    
                                 echo Form::text("start_time",
                                 $value='',
                                 $attributes = array( "id"=>"start_time",
                                 "class"=>"form-control clck_outr timepicker",
                                
                                 ));
                                 ?>
                              <span class="input-group-addon clck">
                              <span class="glyphicon glyphicon-time"></span>
                              </span>
                           </div>
                        </div>
                     </div>
                     <div class="inline artist_list">
                        <span>End Time:</span>
                        <div class="form-group inpt input-customm input-customm-2">
                           <div class='input-group date' id='datetimepicker4'>
                              <!--<input type='text' class="form-control clck_outr timepicker" placeholder="4.20 pm"/>-->
                              <?php
                                 echo Form::text("end_time",
                                 $value='',
                                 $attributes = array( "id"=>"end_time",
                                 "class"=>"form-control clck_outr timepicker",
                                
                                 ));
                                 ?>
                              <span class="input-group-addon clck">
                              <span class="glyphicon glyphicon-time"></span>
                              </span>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="inline artist_list">
                        <span>Security Deposit:</span>
                        <div class="form-group inpt input-customm">
                           <div class='input-group date'>
                           <span class="dollar">$</span>
                              <!--<input type='text' class="form-control clck_outr lck_outr" placeholder="$0.00" />-->
                              <?php
                                 echo Form::text("security_payment",
                                 $value=$security_figure,
                                 $attributes = array( "id"=>"security_payment",
                                 "class"=>"form-control clck_outr lck_outr",
                                 //"placeholder"=>"$0.00",
                                 "maxlength"=>"16"
                                 
                                 ));
                                 ?>
                              <span class="input-group-addon clck clickable">
                              <span class="glyphicon lck"><div id="securityimg_div" data-securityimgflag='0'></div></span>
                              </span>
                           </div>
                        </div>
                     </div>
                     <div class="inline artist_list">
                        <span>Total Payment:</span>
                        <div class="form-group inpt input-customm">
                           <div class='input-group date'>
                           <span class="dollar">$</span>
                              <?php    
                                 echo Form::text("total_payment",
                                 $value=$rate_amount,
                                 $attributes = array( "id"=>"total_payment",
                                 "class"=>"form-control clck_outr lck_outr",
                                 //"placeholder"=>"$0.00",
                                 "maxlength"=>"16"
                                 ));
                                 ?>
                              <span class="input-group-addon clck clickable">
                              <span class="glyphicon lck"><div id="totalpayimg_div" data-totalpayimgflag='0'></div></span>
                              </span>
                           </div>
                        </div>
                     </div>
                     <div class="inline artist_list">
                        <span>Cancellation Fee:</span>
                        <div class="form-group inpt input-customm input-customm-2">
                           <div class='input-group date'>
                           <span class="dollar">$</span>
                              <?php
                                 echo Form::text("cancellation_payment",
                                 $value='',
                                 $attributes = array( "id"=>"cancellation_payment",
                                 "class"=>"form-control date_outr lck_outr",
                                // "placeholder"=>"$0.00",
                                 "maxlength"=>"16"
                                 ));
                                 ?>
                              <span class="input-group-addon dt clck clickable">
                              <span class="glyphicon lck"><div id="bookingcanimg_div" data-bookingcanimgflag="0"></div>
                              </span>
                              </span>
                           </div>
                        </div>
                     </div>
				  </div>
					<div class="col-md-6">
                     <div class="inline artist_list">
                        <span>Request Expire Date:</span>
                        <div class="form-group inpt input-customm input-customm-color">
                           <div class='input-group date'>
                              <?php    
                                 echo Form::text("requestexpireddate",
                                 $value='',
                                 $attributes = array( "id"=>"requestexpireddate",
                                 "class"=>"form-control date_outr datetimepicker"
                                 
                                 ));
                                 ?>
                              <span class="input-group-addon dt">
                              <span class="glyphicon glyphicon-calendar clndr"></span>
                              </span>
                           </div>
                        </div>
                     </div>
					</div><div class="col-md-6">
                     <div class="inline artist_list">
                        <span> Request Expire Time:</span>
                        <div class="form-group inpt input-customm input-customm-color">
                           <div class='input-group date' id='datetimepicker5'>
                              <?php    
                                 echo Form::text("requestexpiredtime",
                                 $value='',
                                 $attributes =array( "id"=>"requestexpiredtime",
                                 "class"=>"form-control clck_outr timepicker"
                                
                                 ));
                                 ?>
                              <span class="input-group-addon clck">
                              <span class="glyphicon glyphicon-time"></span>
                              </span>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col-md-12">
                     <div class="inline artist_list" id="tech_speech_div">
  
						                      <?php
					  
					  echo Form::textarea("gig_description", $value=stripslashes($tech_spec_venue), [ "id"=>"gig_description","disabled", "placeholder"=>"Gig Description","class"=>"form-group inpt nb form-control" ]);
					  
					  ?>
                        <!--</div>-->
                        <!--                       <p> 5 lines, 50 characters maximum per line</p>-->
                     </div>
                  </div>
                  <div class="col-md-12">
				  <input type="hidden" name="venueID" value="{{$venue_own_id}}" id="venueID" >
                     <button class="btn btn-warning artist_btn reqst_btn buttonpercentg" id="cancelbtn" data-dismiss="modal">cancel</button>
                     <button class="btn btn-warning artist_btn rqst_trm_btn agretoterm buttonpercentg"  type="button"  id="venuebookingsubmit">ok got it </button>
                  </div>
               </div>
               <!--</form>-->
               <?php
                  echo Form::close();
                  ?>
            </div>
         </div>
      </div>
   </div>
</div>
<!--book artist modal ends here-->

   <!--Boôking modal ends here-->
  
  <script>

    var filterevtype = '<?php echo $filterevtype; ?>'; //console.log("on load =>"+filterevtype);
   var pro_category = '';
   var pro_genre = '';
   var daymonth = 'month';
   var seo_name="<?php echo $seo_name; ?>";
   var type_flag=3;
   var cal_select_date=moment().format('YYYY-MM-DD');
   var someevntfired_flag=0;
   
   var cal_viewshowflag="<?php echo $cal_viewshowflag; ?>";
   var cal_pendingbkshowflag="<?php echo $cal_pendingbkshowflag; ?>";
   var cal_publiceventshowflag="<?php echo $cal_publiceventshowflag; ?>";
   var cal_privateeventshowflag="<?php echo $cal_privateeventshowflag; ?>";
   var review_show_flag="<?php echo $review_show_flag; ?>";
   
   var lockImg = "<img src='{{ URL::asset('public/front')}}/images/lock2.png' alt=''>";
   var unlockImg = "<img src='{{ URL::asset('public/front')}}/images/lock.png' alt=''>";
   
   if ($('#securityimg_div').data('securityimgflag')=='0') {
	   $("#securityimg_div").html(unlockImg);
   }
   
   if ($('#bookingcanimg_div').data('bookingcanimgflag')=='0') {
	   $("#bookingcanimg_div").html(unlockImg);
   }
   
   if ($('#totalpayimg_div').data('totalpayimgflag')=='0') {
	   $("#totalpayimg_div").html(unlockImg);
   }
   
   $(document).on('click','.currencyVenBook',function(){
   var P_currency = $(this).data("currency");
   var l_currency = "<?php echo $login_currency;?>";



   var currentloggedinuserid = "<?php echo $sessn_ID; ?>";
   var venuecreatorid = "<?php echo $venue_creatr_id; ?>";
// alert()
   var currentuserwalletamount = "<?php echo $wallet_amount; ?>";
   var venuewalletamount = "<?php echo $venue_wallet_amount; ?>";

  // alert("currentloggedinuserid"+currentloggedinuserid+"venuecreatorid"+venuecreatorid);
  
   if (l_currency == P_currency) {

   
   			 if(currentloggedinuserid!=venuecreatorid)
                    {
                           
                            if(parseFloat(currentuserwalletamount) < parseFloat(venuewalletamount))
                            {
                          
                              $('#myModal3paymentview').modal();

                            }else if(parseFloat(currentuserwalletamount) == "0.00")
                            {
                              $('#myModal3paymentview').modal('show');
                            }
                            else
                            {
                              $('#myModal5').modal('toggle');
                              $('#myModal5').modal('show');
                            }
                     } else
                    {
                      $('#myModal5').modal('toggle');
                      $('#myModal5').modal('show');
                    }
                    

	  }else{
		 toastr.remove();// Immediately remove current toasts without using animation
		 poptriggerfunc(msgtype='error',titledata='',msgdata="Venue currency mismatch",sd=1000,hd=1500,tmo=null,etmo=null,poscls='toast-bottom-right');
	  }
   })
   
   


   //********** social link
  
   //********** social link
</script>
  <!-- for full callendar related   starts  -->	
<link rel="stylesheet" href="{{ URL::asset('public/front')}}/otherfiles/fullcalendar2.8/fullcalendar.css">	
<script type="text/javascript" src="{{ URL::asset('public/front')}}/otherfiles/fullcalendar2.8/fullcalendar.min.js"></script>
<script type="text/javascript" src="{{ FRONTCSSPATH}}/otherfiles/progjs/frontendpublartgrpvencalendar.js"></script>
   <script type="text/javascript" src="{{ FRONTCSSPATH}}/otherfiles/progjs/frontendprofileFavorite.js"></script>
<!-- for full callendar related   ends  -->	
<script type="text/javascript" src="{{ FRONTCSSPATH}}/otherfiles/progjs/frontendpublicprofilegig.js"></script>  
   
   
<script>

	var flgBkGrp = "<?php echo $flagBkGrp;?>";
   	$(document).ready(function()
   	{
	
	
			//****** for binding with  user image slider on change of slider starts 
			var owl = $('.owl-carousel');
			
			owl.owlCarousel({callbacks: true});
			
			owl.on('changed.owl.carousel', function(event) {
			
			var totalItems = $(".myvenuesliderouterdv").find(".item").length;
			console.log("len=>"+totalItems);
			
			var currentitemnmbr=event.item.index;
			var curritemnum=currentitemnmbr+1; // current item number without starting  from 0 ,  if current index is o then , curr photo is 0+1=1 , if 1 then 1+1=2
			
			showhideprevnextimgslider(totalItems,curritemnum) ;                  
			
			});
			//****** for binding with  user image slider on change of slider ends
			
			
			//****** for showing right icon in image slider on load  starts
			
			
			var totalItems = $(".myvenuesliderouterdv").find(".item").length; var curritemnum=1;
			//  alert("totalItems==============> "+totalItems);
			showhideprevnextimgslider(totalItems,curritemnum);
			//****** for showing right icon in image slider on load ends

			   
			// $('#total_payment').maskMoney({prefix:'$'}); //******masking for total payment
			// $('#cancellation_payment').maskMoney({prefix:'$'});//******masking for cancellation payment
			// $('#security_payment').maskMoney({prefix:'$'});//*******masking for security payemnt
			
			
			
			var booking_date ='';
			var requestexpireddate ='';
			var datemax ='';
			//alert(booking_date);
			
			var datecur = new Date();
			datecur.setDate(datecur.getDate());
			var datecur2 = new Date();
			datecur2.setDate(datecur2.getDate());
			$('#booking_date').datetimepicker({
			format: 'DD/MM/YYYY',
			minDate:datecur,
			
			});
			$('#requestexpireddate').datetimepicker({
			format: 'DD/MM/YYYY',
			//minDate:datecur
			//minDate: datecur
			
			});
			
			
			
			$("#start_time").datetimepicker({
			format: 'LT'
			});

	
	
	  var dhourlyrateflag = '<?php echo $hourlyrateflag;?>';
	  //console.log(dhourlyrateflag);
		  if (dhourlyrateflag == 0)
		  {
		   //console.log(hourlyrateflag);
		   //$('#venuebookingsubmit').unbind('click');
		  }else
		  {
			  //$('#venuebookingsubmit').bind('click');
		  }


 		  
 		 // alert(event_type_entry);
//$message = 'Hello '.($user->get('first_name') ?: 'Guest');
		  var hidnlt = <?php echo $ltlt = $fetchuserdata->venue_lat ?: '0.000000' ;?>;
		  var hdnlng = <?php echo $lltng = $fetchuserdata->venue_long ?: '0.000000' ;?>;
//console.log("hidnlt"+hidnlt);
		google.maps.event.addDomListener(window, 'load', initialize(hidnlt,hdnlng));
		
	  });
	  
	  //*********************function for form validation==============*******in frontendpublicprofile.js page

                                     
                                     
                                     
						$('.agretoterm').click(function(){
						   $("#tech_speech_div").slideDown('fast');
						   $(this).html('send');
                            $('#gig_description').html("<?php echo $tech_speech;?>");
                            $('#gig_description').prop("disabled", false);
									jQuery("#venuebookingsubmit").click(function(){
									//***check if díplay none

									if($('#sfsdfsdffd').css('display') == 'none')
									{
									$("#clickme").trigger('click');
									}
									
									
									var csrf = "<?php echo csrf_token(); ?>";
									
									   var pj = callforbookingvenue("fsdfsdf",csrf);
									
									 });
						});
                                     
                                     
                                     
                                     
                                     
						//***************bind profile page ends here*******************************************
						
							  $("#country_id").change(function()
								{
									var ProfilecountryId = $(this).val();
									var csrf = "<?php echo csrf_token(); ?>";
									var requestStateUrl = 'countrystate';
									getStateforCountry(requestStateUrl,ProfilecountryId,csrf);
								
								});
								
								//************ For ajax genere starst here
							  $("#bookingcat_subvenue").change(function()
								{
								var csrf = "<?php echo csrf_token(); ?>";
									var Catagory_Id = $(this).val();
									var venuID = '<?php echo $venueprof_id?>';
									var requestStateUrl = 'getgenerevenue';
									getGenereforCategory(requestStateUrl,Catagory_Id,csrf,venuID);
								
								});
				//***********  For ajax genere ends here

				//*********** For show no presskit starts here
				function showno_presskit()
				{
					// alert('in am inside this secton');
					 toastr.remove();// Immediately remove current toasts without using animation
					poptriggerfunc(msgtype='error',titledata='',msgdata="Press kit not available ",sd=1000,hd=1500,tmo=2000,etmo=1000,poscls='toast-bottom-right');
				}
				function showno_menu()
				{
					// alert('in am inside this secton');
					 toastr.remove();// Immediately remove current toasts without using animation
					poptriggerfunc(msgtype='error',titledata='',msgdata="Menu not available ",sd=1000,hd=1500,tmo=2000,etmo=1000,poscls='toast-bottom-right');
				}
				function no_hourlyrate()
				{
					 toastr.remove();// Immediately remove current toasts without using animation
					poptriggerfunc(msgtype='error',titledata='',msgdata="oops! This venue rate amount is not available ",sd=1000,hd=1500,tmo=2000,etmo=1000,poscls='toast-bottom-right');
				}
				//*********** For show no presskit ends here
				//***********
				var event_type_entry = "<?php echo $available_for ?>";
				var opening_time =  "<?php echo $opening_time ?>";
				var closing_time =  "<?php echo $closing_time ?>";

				var showreviewornot = "<?php echo $fetchuserdata->review_show_flag?>";
   </script>
	
	<!--This is a script for map starts-->
	<!--  <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDMtfReOBcDyXEUBByLlLgjOkwMKKJw86M&callback=initMap">
    </script> -->

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDMtfReOBcDyXEUBByLlLgjOkwMKKJw86M"></script>

 
	<!--This is a script for map ends-->
	<script type="text/javascript" src="{{ FRONTCSSPATH}}/otherfiles/progjs/jquery.maskMoney.js"></script>
	<!--<script type="text/javascript" src="{{ FRONTCSSPATH}}/otherfiles/progjs/frontendpublicprofilevenuecalender.js"></script>-->
	<script type="text/javascript" src="{{ FRONTCSSPATH}}/otherfiles/progjs/commoncustomloaderjs.js"></script>
	<script type="text/javascript" src="{{ FRONTCSSPATH}}/otherfiles/progjs/forntendpublicvenue.js"></script>
@endsection