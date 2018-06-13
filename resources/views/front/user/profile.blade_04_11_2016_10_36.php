
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
   
   
   $first_name=''; $facebook_url=''; $twitter_url='';$metadescriptiondata ='';
   $instagram_url='';	$youtube_url='';	$residentadvisor_url='';
   $tech_speech = '';
   $statelist='';
   $user_description=''; $soundcloud_url='';$performence=0;$puntuality=0;$presentation=0;$roundofpuntulity=0;$roundofperformence=0;
   $rider_data='No information available';
   $roundofpresentation=0;
   $artist_own_id = 0;
   $available_for = 3;
   $security_figure = '';
   
   $walletamountprofile = 0;

   $cal_viewshowflag=1;
   $cal_pendingbkshowflag=1;
   $cal_publiceventshowflag=1;
   $review_show_flag=1;
   $cal_privateeventshowflag = 1;

	  $fetchskillmasterArData=array();
	  
	  $fetchcountrydata = array();
    $fetchstatelistdata=array();
	  $fetchbookingcatData = array();
	  $fetchbookingskillcategory =array();
	  $fetchimgData = array();
	  
	  $filterevtype=''; $filterevtypeAr=array();
   
   if(!empty($fetchuserdata))
   {
	  $pro_currency = $fetchuserdata->currency;
   $metadescriptiondata = $fetchuserdata->user_meta_data;
	  $rate_amount = $fetchuserdata->rate_amount;
	  $submitBtbFlag = 1;
	  // if($rate_amount =='0.00')
	  // {
	  // $submitBtbFlag = 0;	
	  //    }
    $walletamountprofile = $fetchuserdata->wallet_amount;

    if($rate_amount!='0.00')
    {
      $rate_amount = $fetchuserdata->rate_amount;
    }else
    {
      $rate_amount='';
    }
	
	  $cal_viewshowflag=$fetchuserdata->cal_viewshowflag;
	  $cal_pendingbkshowflag=$fetchuserdata->cal_pendingbkshowflag;
	  $cal_publiceventshowflag=$fetchuserdata->cal_publiceventshowflag;
	  $review_show_flag=$fetchuserdata->review_show_flag;
	  $cal_privateeventshowflag = $fetchuserdata->cal_privateeventshowflag;
	  
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
		 
	
	  $first_name=$fetchuserdata->nickname;
	  $facebook_url=$fetchuserdata->facebook_url;
	  $twitter_url=$fetchuserdata->twitter_url;
	  $instagram_url=$fetchuserdata->instagram_url;
	  $youtube_url=$fetchuserdata->youtube_url;
	  $soundcloud_url=$fetchuserdata->soundcloud_url;
	  $residentadvisor_url=$fetchuserdata->residentadvisor_url;

	  $user_description=$fetchuserdata->user_description;
	  if($user_description=='')
	  {
		$user_description = 'No description available';
	  }

	  $tech_speech = stripslashes($fetchuserdata->tech_spec);
	  $available_for = $fetchuserdata->available_for;

	  if($fetchuserdata->security_figure!='0.00')
	  $security_figure = $fetchuserdata->security_figure;

     if($fetchuserdata->id)
	 $artist_own_id=$fetchuserdata->id;


	  if($fetchuserdata->rider_data)
	  $rider_data=stripslashes($fetchuserdata->rider_data);



   }
   
   if(!empty($fetchskillmasterAr))
   {
   	$fetchskillmasterArData=$fetchskillmasterAr;
	$fetchbookingcatData = $fetchskillmasterAr;
   }
   
   if(!empty($country_result))
   {
	  $fetchcountrydata = $country_result;
   }
   if(!empty($state_result))
   {
    $fetchstatelistdata = $state_result;
   }
   if(empty($tech_speech))
   {
	  $tech_speech = "";
	  
   }
     if(!empty($usr_img))
   {
	 $fetchimgData = $usr_img;
   }
   
    if(!empty($artistbooking_skill))
   {
   
     $fetchbookingskillcategory =$artistbooking_skill;
   }

if(!empty($state_id))
{
  $statelist=$state_id;
}
	
	$flagBkGrp = Request::segment(3);

if($flagBkGrp!='' && $flagBkGrp=='bk'){
$flagBkGrp='1';
   }



   //***********get artist ratings 
   $puntualityardata_artist=0;
   if($puntualityardata)
    $puntualityardata_artist = $puntualityardata;

   $performenceardata_artist=0;
   if($performenceardata)
    $performenceardata_artist = $performenceardata;

  $presentationardata_artist=0;
   if($presentationardata)
    $presentationardata_artist = $presentationardata;


   //*****-----------------**************

   //****** code to get seoname from url 
   $seo_name=Request::segment(2);
   
   $soundcloud_url_actcls = ''; $facebook_url_actcls = ''; $residentadvisor_url_actcls = ''; $twitter_url_actcls = ''; $youtube_url_actcls =''; $instagram_url_actcls = ''; $presskit_actcls = '';

   $fbold = 'https://www.facebook.com/';
     $soundcloud_url_deflt="https://www.soundcloud.com/";
                                 $residentadvisor_url_deflt="https://www.residentadvisor.net/";
                                 $twitter_url_deflt="https://www.twitter.com/";
                                 $youtube_url_deflt="https://www.youtube.com/";
                                 $instagram_url_deflt="https://www.instagram.com/";

   if($facebook_url=='' || $facebook_url== $fbold)
   {   $facebook_url_actcls = 'deactive';   }
   
    if($soundcloud_url=='' || $soundcloud_url== $soundcloud_url_deflt)
   {   $soundcloud_url_actcls = 'deactive';   }
   
      if($residentadvisor_url=='' || $residentadvisor_url==$residentadvisor_url_deflt)
   {   $residentadvisor_url_actcls = 'deactive';   }
   
      if($twitter_url=='' || $twitter_url==$twitter_url_deflt)
   {   $twitter_url_actcls = 'deactive';   }
   
      if($youtube_url=='' || $youtube_url==$youtube_url_deflt)
   {   $youtube_url_actcls = 'deactive';   }
   
      if($instagram_url=='' || $instagram_url==$instagram_url_deflt)
   {   $instagram_url_actcls = 'deactive';   }
   

//echo "session id".$atrist_sessionID;die;
  //echo "user wallet amount ======>".$walletamountprofile; 

   ?>
@extends('layouts.front.frontendmaster',['successmsg' => $successmsg,'errormsg'=>$errormsg,'metadescriptiondata'=>$metadescriptiondata])
@section('content')
	
<!-- profile-section-start -->
<section class="profile_outer">
   <div class="container">
      <div class="row dj_row">
         <div class="col-sm-5">
            <div class="profile_slider">
             
				 <?php
				 // $imgurldata = asset("front/otherfiles/progimages/"."noimagefound537X507.jpg");
				   $imgurldata = BASEURLPUBLICCUSTOM."front/otherfiles/progimages/"."noimagefound537X507.jpg";
               // $fetchimgDat2a = array();
                if(!empty($fetchimgData))
                {
                    foreach($fetchimgData as $fetchimgData)
                    {
                     //$imgurl = asset('upload/userimage/thumb-big/'.$fetchimgData->image_name);
					 $imgurl = BASEURLPUBLICCUSTOM.'upload/userimage/thumb-big/'.$fetchimgData->image_name;
                        ?>
                          <div class="item" style="background-image: url({{ $imgurl}});">
                          </div>
                <?php
                }
            }else
                {
                     //$imgurldata = asset("front/otherfiles/progimages/"."noimagefound537X507.png");
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
            <h2 class="prifile_heading"><?php echo $first_name;?></h2>
            <div class="like_box">
						<a href="profile.html#review" class="add_link red-tooltip goTo" data-go-to="review_section" data-toggle="tooltip" data-trigger="hover" title="Review"><img src="{{ FRONTCSSPATH}}/images/plus_icon.png" alt="" /></a>
                        
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

                  if($atrist_sessionID == $artist_own_id)
                  {

                   ?>
						<a href="javascript:void(0)" class="like_link red-tooltip goTo myfavorite deactive<?php echo $myfavoriteClass;?>" data-userId="<?php echo $fetchuserdata->id?>" data-go-to="Favorite_section" data-usertype="1" data-toggle="tooltip" data-trigger="hover" title="Favorite"><img src="{{ FRONTCSSPATH}}/images/heart_icon.png" alt="" /></a>
							<?php
							}
							else
							{
							?>
							<a href="javascript:void(0)" class="like_link red-tooltip goTo myfavorite<?php echo $myfavoriteClass;?>" data-userId="<?php echo $fetchuserdata->id?>" data-go-to="Favorite_section" data-usertype="1" data-toggle="tooltip" data-trigger="hover" title="Favorite"><img src="{{ FRONTCSSPATH}}/images/heart_icon.png" alt="" /></a>
							
							
							
					<?php		}
							?>
                        
						<a href="profile.html#calendr" class="red-tooltip goTo" data-go-to="Calender_section" data-trigger="hover" data-toggle="tooltip" title="Calender"><img src="{{ FRONTCSSPATH}}/images/calender_icon.png" alt="" /></a>
			</div>
			
            <div class="name_holder">
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
                     	// echo "<pre>";
                      // print_r($skill_sub_data_Ar);
                     		foreach($skill_sub_data_Ar as $kk => $kvlue)
                     		{
                     			$i++;
                     			$skill_sub_data=$skill_sub_data_Ar[$kk];
                     		$skill_sub_txtdata=$skill_sub_txtdata_Ar[$kk];//die;
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
            </div>
            <div class="row row_visitor">
               <ul class="col-sm-6 visitor_cols">


<?php 

 if($facebook_url!='' && $facebook_url!= $fbold)
{
?>


                  <li
				  class = "<?php echo $facebook_url_actcls;?>"
				  
				  >
                     <a href="{{$facebook_url}}" target="_blank">
                     <span class="icon_social" style="background: #3b5998;"><img src="{{ FRONTCSSPATH}}/images/fb_icon.png" alt="" /></span>
                     facebook
                     </a>
                  </li>

                  <?php 

}
                  ?>

<?php 
 if($soundcloud_url!='' && $soundcloud_url!= $soundcloud_url_deflt)

{
?>

                  <li class ="<?php echo $soundcloud_url_actcls;?>">
                     <a href="{{$soundcloud_url}}" target="_blank">
                     <span class="icon_social" style="background: #ff7e30;"><img src="{{ FRONTCSSPATH}}/images/cloud_icon.png" alt="" /></span>
                     Soundcloud
                     </a>
                  </li>
<?php 

}
?>

<?php 

if($residentadvisor_url!='' && $residentadvisor_url!=$residentadvisor_url_deflt)
{
?>


                  <li class ="<?php echo $residentadvisor_url_actcls;?>">
                     <a href="{{$residentadvisor_url}}" target="_blank">
                     <span class="icon_social" style="background: #ffff00;"><img src="{{ FRONTCSSPATH}}/images/advisor_icon.png" alt="" /></span>
                     Resident Advisor
                     </a>
                  </li>

                  <?php 

}

                  ?>

                  <?php 

 if($twitter_url!='' && $twitter_url!=$twitter_url_deflt)
 {

 

                  ?>
                  <li class ="<?php echo $twitter_url_actcls;?>">
                     <a href="{{$twitter_url}}" target="_blank">
                     <span class="icon_social" style="background: #00aced;"><img src="{{ FRONTCSSPATH}}/images/tweeter_icon.png" alt="" /></span>
                     Twitter
                     </a>
                  </li>
<?php

}
 ?>

<?php 

if($youtube_url!='' && $youtube_url!=$youtube_url_deflt)
{


?>


                  <li class ="<?php echo $youtube_url_actcls;?>">
                     <a href="{{$youtube_url}}" target="_blank">
                     <span class="icon_social" style="background: #e32b21;"><img src="{{ FRONTCSSPATH}}/images/youtube_icon.png" alt="" /></span>
                     YouTube
                     </a>
                  </li>
<?php 

}
?>
<?php 

 if($instagram_url!='' && $instagram_url!=$instagram_url_deflt)
 {
?>


                  <li class ="<?php echo $instagram_url_actcls;?>">
                     <a href="{{$instagram_url}}">
                     <span class="icon_social" style="background: #2e5e84;"><img src="{{ FRONTCSSPATH}}/images/instagram_icon.png" alt="" /></span>
                     Instagram
                     </a>
                  </li>
<?php 

}
?>

               </ul>
               <div class="col-sm-6 visitor_cols">
                  <div class="btn_row">

                  <?php

                  if($atrist_sessionID == '')
                  {

                   ?>
                     <a href="javascript:void(0)" class="book_btn" onclick="booking_modalnotopen(1);">book artist</a>
                  
                  <?php
                  }else
                  { 
                    if($atrist_sessionID == $artist_own_id)
                    {
					?>
                    <a href="javascript:void(0)" class="book_btn openbkgrpcls deactive" onclick="booking_modalnotopen(2);">book artist</a>
                    <?php 
                  }
                  //else if($submitBtbFlag == 0)
                  //{
				  //echo '<a href="javascript:void(0)" class="book_btn openbkgrpcls"  onclick="booking_modal_norate();">book artist</a>';
                  //}
                  else
                  {
                    ?>
					 <a href="javascript:void(0)" class="book_btn openbkgrpcls currencyBook" data-currency="<?php echo $pro_currency;?>" >book artist</a>
                    <!--<a href="#" class="book_btn openbkgrpcls" data-toggle="modal" data-target="#myModal5">book artist</a>-->
                    <?php

                  }
                  
                }
                  ?>
                  </div>
                  <div class="btn_row">
<!--                     <a href="#" class="book_btn press_btn">press kit</a>-->
                      <?php
                      if($presskit!='')
                      {
                            $presssecure = 'presskitdownload/'.base64_encode($presskitname = $presskit->presskit_name);
                      
							echo link_to($presssecure, $title = 'press kit', $attributes = array("class"=>"book_btn press_btn"), $secure = null);
                      }else
                      {
                          //echo link_to('#', $title = 'press kit', $attributes = array("class"=>"book_btn press_btn"), $secure = null);
                          ?>
                           <a href="javascript:void(0)" class="book_btn press_btn deactive" onclick="no_presskit()">press kit</a>
               <?php
                      }
							?>
                  </div>
                  <div class="btn_row">
                     <!-- <a href="#" class="book_btn rider_btn">menu</a> -->
                     <a href="javascript:void(0);" class="book_btn rider_btn"> View Rider</a>
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
      <div class="dj_row">
         <h2 class="edt_img edt_txt "> description </h2>
         <p class="outPut">{{$user_description}}</p>
      </div>
   </div>
</section>



   <!--Review Section starts here-->
   <?php if( !empty($cal_viewshowflag) && ( $cal_viewshowflag==1 ) ) { ?>
	 <script type="text/javascript" src="{{ FRONTCSSPATH}}/otherfiles/progjs/frontendpublicprofilegig.js"></script>
   <section class="profile_outer event_section" id="Calender_section">
   <div class="container">
      <div class="month-chart clearfix">
         <div class="left_chart">
<!--            <div class="setting_icon">
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
         <div class="right_chart clearfix" id="profileCatFen">
         </div>
      </div>
   </div>
   <div class="container">
      <div class="event_left calendarHeight">
         <div class="event_left_row">
            <h2 class="event_heading">Events</h2>
            <ul class="visitor_cols event_btn_group">

			   
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
				  
            </ul>
         </div>
		 <div class = 'loadLeftGigList'></div>
<!--         <div class="event_left_row">
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
        <!-- <img src="{{ FRONTCSSPATH}}/images/calender_img.png" alt="" />-->
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
									
									   //echo "<li>".$cat_gen_arr['category']."</li>";
									   //echo "<li> ".$cat_gen_arr['genre']."</li>";
									   echo "<li>".$cat_gen_arr['category'].": ".$cat_gen_arr['genre']."</li>";
									   
									}
							 }

							 }
						   ?>
						   <!-- incluede category and genre end-->
                 <li>
                     <?php 
         
                             $review_time =$userreview->agv_review_date;
                             echo date('g:i A',strtotime($review_time))." | ";
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
	<!--Review Section ends here-->
<!-- profile-section-end -->
<!--book artist model booking request      -->
<!--book artist model booking request      -->
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


                  <!-- <span>Public Event:</span>
                  <div class="radio_in">
                     <?php 
                      //  echo Form::radio('radio', '1', false,$attributes = array("id"=>"radio3"));
                        ?>
                     <label for="radio3"><span><span></span></span>Yes</label>
                  </div>
                  <div class="radio_in">
                     <?php 
                       // echo Form::radio('radio', '2', true,$attributes = array("id"=>"radio4"));
                        ?>
                     <label for="radio4"><span><span></span></span>No</label>
                  </div> -->

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
          }else
          {
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
                  <div class="col-md-12">
                     <div class="artist_divsn reqst_dvsn">
                        <div class="inline artist_list request_type lacTxt">
                          <span>Location:</span>
                        </div>
                        <div class="reqField"><a href="javascript:void(0);" id="clickme" class="tBtn form-control">Required Field.</a></div>
                    </div>
                  </div>
                 <div class="new-location clearfix" style="display:none;" id="sfsdfsdffd">
                      <div class="col-md-12">
                        <div class="artist_divsn reqst_dvsn">
                          <div class="inline artist_list request_type">
                           <!--    <input type="text" class="form-control form-control-B" placeholder="Address1"/>-->
                 
                <?php
                echo Form::text("booking_location",
                $value='',
                $attributes = array( "id"=>"booking_location",
                "class"=>"form-control form-control-B",
                "placeholder"=>"Address1"
                
                ));
                ?>
                              <!--<input type="text" class="form-control form-control-B" placeholder="Address2"/>-->
                <?php
                echo Form::text("booking_location_second",
                $value='',
                $attributes = array( "id"=>"booking_location_second",
                "class"=>"form-control form-control-B",
                "placeholder"=>"Address2"
                
                ));
                ?>
                            </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="artist_divsn">
                         <div class="inline artist_list request_list">
                           <?php
                              $control_attrAr=array();
                              $control_attrAr['id']='country_id';
                              $control_attrAr['class']="selectpicker artist_txt";
                              //$control_attrAr['title']="Country";
                              $country_name=$country_iddata;
                              echo Form::select('countryId',
                              $fetchcountrydata,
                              $country_name,
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
                
                              $control_attrAr['id']='statelist';
                              $control_attrAr['class']="selectpicker artist_txt";
                           //   $control_attrAr['title']="State";
                              $bookinggenre_sub='';
                             
                              echo Form::select('statelist',
                              $fetchstatelistdata,
                              $statelist,
                              $control_attrAr
                              );                
                              ?>
                        </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="artist_divsn">
                          <div class="inline artist_list request_list">
                                <!--<input type="text" class="form-control" placeholder="City" />-->
                <?php
                                 echo Form::text("town",
                                 $value='',
                                 $attributes = array( "id"=>"town",
                                 "class"=>"form-control",
                                 "placeholder"=>"City"
                                
                                 ));
                                 ?>
                            </div>
                        </div>
                    </div>
                      <div class="col-md-6">
                        <div class="artist_divsn">
                          <div class="inline artist_list request_list">
                                <!--<input type="text" class="form-control" placeholder="Zip" />-->
                <?php
                echo Form::text("zip",
                $value='',
                $attributes = array( "id"=>"zip",
                "class"=>"form-control",
                "placeholder"=>"Post Code"
                
                ));
                ?>
                            </div>
                        </div>
                    </div>
                    
                    <a class="closeLoc" href="javascript:void(0);"></a>
                    
                </div>
                  <!---------------------------For Town and Zip ends here-------------------------------->
                  <div class="col-md-6">
                     <div class="artist_divsn">
                        <div class="inline artist_list request_list">
                           <?php
                              $control_attrAr=array();
                              $control_attrAr['id']='bookingcat_sub';
                              $control_attrAr['class']="selectpicker artist_txt";
                              $control_attrAr['title']="Category for Event";
                              $bookingcat_sub='';
                              echo Form::select('bookingcat_sub',
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
                                 "class"=>"form-control datepicker",
                                
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
                              <input type='text' class="form-control clck_outr timepicker" placeholder="3.15 pm" id="start_time" name="start_time"/>
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
                           <input type='text' class="form-control clck_outr timepicker" placeholder="3.15 pm" id="end_time" name="end_time"/>
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
                               //  "placeholder"=>"0.00",
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
                              //  "placeholder"=>"0.00",
                                 "maxlength"=>"16"
                                 ));
                                 ?>
                              <span class="input-group-addon clck clickable">
                              <span class="glyphicon lck">
							  <div id="totalpayimg_div" data-totalpayimgflag='0'></div>
							  </span>
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
                              //  "placeholder"=>"0.00",
                                 "maxlength"=>"16"
                                 ));
                                 ?>
                              <span class="input-group-addon dt clck clickable">
                              <span class="glyphicon lck">
							  <div id="bookingcanimg_div" data-bookingcanimgflag="0"></div>
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
                                 "class"=>"form-control clck_outr datepicker"
                                 
                                 ));
                                 ?>
                              <span class="input-group-addon dt">
                              <span class="glyphicon glyphicon-calendar clndr"></span>
                              </span>
                           </div>
                        </div>
                     </div>
					 </div>
						<div class="col-md-6">
                     <div class="inline artist_list">
                        <span>Request Expire Time:</span>
                        <div class="form-group inpt input-customm input-customm-color">
                           <div class='input-group date' id='datetimepicker5'>
                            <input type='text' class="form-control clck_outr timepicker" placeholder="3.15 pm" id="requestexpiredtime" name="requestexpiredtime"/>
                              <?php    
                                 // echo Form::text("requestexpiredtime",
                                 // $value='',
                                 // $attributes =array( "id"=>"requestexpiredtime",
                                 // "class"=>"form-control clck_outr timepicker"
                                
                                 // ));
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
                        <!--                      <span>Tech Specs</span>-->
                        <!--<div class="form-group inpt nb">-->
                        <!--</div>-->
						                      <?php
					  
					  echo Form::textarea("gig_description", $value=stripslashes($tech_spec_artist), [ "id"=>"gig_description", "disabled", "placeholder"=>" ","maxlength"=>"500","class"=>"form-group inpt nb form-control" ]);
					  
					  ?>
                        <!--                       <p> 5 lines, 50 characters maximum per line</p>-->
                     </div>
							<input type="hidden" id="fieldtocountbookingartist" value="500">
							 <p  style="display:none" id="CharCountLabelartistbooking" ></p>
                  </div>
                  <div class="col-md-12">
                      <input type="hidden" name="artistID" value="{{$artist_own_id}}" id="artistID" >
                     <button class="btn btn-warning artist_btn reqst_btn buttonpercentg" id="cancelbtn" data-dismiss="modal">cancel</button>
                     <button class="btn btn-warning artist_btn rqst_trm_btn agretoterm buttonpercentg" id="continue" type="button">ok got it </button>
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

<div class="modal fade" id="myModalPro" tabindex="-1" role="dialog">
	<div class="profilemodal"></div>		
</div>
   
   
<div class="modal fade" id="myRider" tabindex="-1" role="dialog">
   <div class="myRiderShow">
   </div>
</div>

<!--book artist modal ends here-->
<script>
   var rider_type = 'view';
   var ridervalue = "<?php echo str_replace(PHP_EOL, ' ', $rider_data);?>";
   var lockImg = "<img src='{{ URL::asset('public/front')}}/images/lock2.png' alt=''>";
   var unlockImg = "<img src='{{ URL::asset('public/front')}}/images/lock.png' alt=''>";
   var filterevtype = '<?php echo $filterevtype; ?>'; //console.log("on load =>"+filterevtype);
   var pro_category = '';
   var pro_genre = '';
   var daymonth = 'month';
   var seo_name="<?php echo $seo_name; ?>";
   var type_flag=1;
   var cal_select_date=moment().format('YYYY-MM-DD');
   var someevntfired_flag=0;
   
   //*************currency job start **********//
   var pro_currency = "<?php echo $pro_currency;?>";
   //*************currency job start **********//
   
   var cal_viewshowflag="<?php echo $cal_viewshowflag; ?>";
   var cal_pendingbkshowflag="<?php echo $cal_pendingbkshowflag; ?>";
   var cal_publiceventshowflag="<?php echo $cal_publiceventshowflag; ?>";
   var review_show_flag="<?php echo $review_show_flag; ?>";
   var cal_privateeventshowflag="<?php echo $cal_privateeventshowflag; ?>";   
   
   var security_lock_id = '';
   var booking_lock_id = '';
   var totalpay_lock_id = '';
   
   if ($('#securityimg_div').data('securityimgflag')=='0') {
	   $("#securityimg_div").html(unlockImg);
   }
   
   if ($('#bookingcanimg_div').data('bookingcanimgflag')=='0') {
	   $("#bookingcanimg_div").html(unlockImg);
   }
   
   if ($('#totalpayimg_div').data('totalpayimgflag')=='0') {
	   $("#totalpayimg_div").html(unlockImg);
   }
   
   
   
   $(document).on('click','.currencyBook',function(){
   var P_currency = $(this).data("currency");
   var l_currency = "<?php echo $login_currency;?>";



   var currentloggeduser = "<?php echo $atrist_sessionID;?>";
   var currentprofileid = "<?php echo $artist_own_id;?>";
   var wallet_amountloggeduser = "<?php echo $wallet_amount;?>";
   var walletamount_currentprofile = "<?php echo $walletamountprofile;?>";
   if (l_currency == P_currency) {

		 
                    if( currentloggeduser!=currentprofileid )
                    {
                           
                            if(wallet_amountloggeduser < walletamount_currentprofile)
                            {

                              $("#myModal3paymentview").modal('show');

                            }else
                            {
                              $('#myModal5').modal('toggle');
                              $('#myModal5').modal('show');
                            }
                     }
                     else
                    {
                      $('#myModal5').modal('toggle');
                      $('#myModal5').modal('show');
                    }



                   



	  }else{
		 toastr.remove();// Immediately remove current toasts without using animation
		 poptriggerfunc(msgtype='error',titledata='',msgdata="Currency mismatch",sd=1000,hd=1500,tmo=null,etmo=null,poscls='toast-top-full-width');
	  }
   })
	  
   
   
</script>

<!-- for full callendar related   starts  -->	
<link rel="stylesheet" href="{{ URL::asset('public/front')}}/otherfiles/fullcalendar2.8/fullcalendar.css">	
<script type="text/javascript" src="{{ URL::asset('public/front')}}/otherfiles/fullcalendar2.8/fullcalendar.min.js"></script>
<script type="text/javascript" src="{{ FRONTCSSPATH}}/otherfiles/progjs/frontendpublartgrpvencalendar.js"></script>
   <script type="text/javascript" src="{{ FRONTCSSPATH}}/otherfiles/progjs/frontendprofileFavorite.js"></script>
<!-- for full callendar related   ends  -->	
<!--<script type="text/javascript" src="{{ FRONTCSSPATH}}/otherfiles/progjs/frontendpublicprofilegig.js"></script> -->


   <script type="text/javascript" src="{{ FRONTCSSPATH}}/otherfiles/progjs/frontendpubliccommonprofile.js"></script> 

<script>
$(window).load(function() {
      // $('window').fadeIn('slow');
	   var imfpth=base_url_data+"/public/front/otherfiles/progimages/loder.gif";
       //showmycustomloader(1,'2500','1000',"",imfpth);
});

   
</script>
<script>
   //$(document).ready(function(){
   //
   //	
   //	$('#total_payment').maskMoney({prefix:'$'}); //******masking for total payment
   //	$('#cancellation_payment').maskMoney({prefix:'$'});//******masking for cancellation payment
   //	$('#security_payment').maskMoney({prefix:'$'});//*******masking for security payemnt
   //	
   //});
   //********masaking length for total payment attribute
   // var maxLength = $("#total_payment").attr('maxlength');
   // if($("#total_payment").val().length == maxLength)
   // {
   // 	$("#total_payment").next().focus();
   // }
   // //$("#security_payment").next().focus();
   // //********masaking length for total payment attribute
   // var maxLength2 = $("#cancellation_payment").attr('maxlength');
   // if($("#cancellation_payment").val().length == maxLength2)
   // {
   // 	$("#cancellation_payment").next().focus();
   // }
   // //$("#security_payment").next().focus();
   // //********masaking length for total payment attribute
   // var maxLength3 = $("#security_payment").attr('maxlength');
   // if($("#security_payment").val().length == maxLength3)
   // {
   // 	$("#security_payment").next().focus();
   // }
   //$("#security_payment").next().focus();
   
    var event_type_entry = "<?php echo $available_for ?>"; 
</script>
<script>
   
   
						//***************************modal hide starts here*****************
									   $('#closemodal').click(function(){
									   $('#myModal5').modal('hide');
									  });
						//**************************modal hide ends here**********************
   
   
						//************************** bind profile page starts********************************
						//*********************function for form validation==============*******in frontendpublicprofile.js page
									jQuery("#profilesubmit").click(function(){
									var csrf = "<?php echo csrf_token(); ?>";
									
									   var pj = callforbooking("publicprofile",csrf);
									
									 });
						//***************bind profile page ends here*******************************************
    
     function showhideprevnextimgslider(totalItems,curritemnum)
             {
                     if (totalItems==1)
                  {
                         //*** hide both prev and next
                               jQuery('.owl-prev, .owl-next').hide();
                  }
                  else if (totalItems>1)
                  {
                         if(curritemnum ==1 )
                        {
                               //*** hide prev  and show next
                                   jQuery('.owl-prev').hide();
                                   jQuery('.owl-next').show();
                        }
                       else if(curritemnum < totalItems )
                        {
                               //*** show both prev and next
                               jQuery('.owl-prev, .owl-next').show();
                        }
                        else if (curritemnum == totalItems)
                        {
                           //*** hide  next and show prev
                           jQuery('.owl-next').hide();
                            jQuery('.owl-prev').show();
                        }
                  }
               
             }
   	$(document).ready(function()
   	{
	
	  // $('#total_payment').maskMoney({prefix:'$'}); //******masking for total payment
	  // $('#cancellation_payment').maskMoney({prefix:'$'});//******masking for cancellation payment
	  // $('#security_payment').maskMoney({prefix:'$'});//*******masking for security payemnt
	  
	   $("#divLoading").css("display","none");
	  //*********
	var csrf = "<?php echo csrf_token(); ?>";
	//*********
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
         // useCurrent: false,
   			//	minDate:datecur,
				minDate:datecur,
   				});
   				$('#requestexpireddate').datetimepicker({
   				format: 'DD/MM/YYYY',
   				//minDate:datecur
				//minDate: datecur
   			//	startDate:datecur
   				});
   					
   			
   					
				  // $("#start_time").datetimepicker({
				  // format: 'LT'
				  // });
			
			
								// } 
					
   				
				//************* For ajax state starts  here
								$("#country_id").change(function()
								{
									var ProfilecountryId = $(this).val();
									//var csrf = "<?php echo csrf_token(); ?>";
									var requestStateUrl = 'countrystate';
									getStateforCountry(requestStateUrl,ProfilecountryId,csrf);
								
								});
				//*************  For ajax state ends here
				
				//************ For ajax genere starst here
							  $("#bookingcat_sub").change(function()
								{
									var Catagory_Id = $(this).val();
									var requestStateUrl = 'getartistgenere';
                  var artistusr_id = '<?php echo $artistusr_id?>';
                  // var csrft = "<?php //echo csrf_token(); ?>";
                 //  alert(csrf);
									getGenereforCategory(requestStateUrl,Catagory_Id,artistusr_id,csrf);
								
								});
				//***********  For ajax genere ends here
				
				$("#cancelbtn").click(function(e){
				//return false;
				//e.preventDefault();
				//alert('hello');
				//  $("#bookingform").reset();
				$("#bookingform").trigger('reset');
				  
				});
				$("#cancelbtn2").click(function(){
				return false;
				});
				
				//***************  For form submit
				
				
			   $('.agretoterm').click(function(){
				  $("#tech_speech_div").slideDown('fast');
				  $("#CharCountLabelartistbooking").slideDown('fast');
				  $(this).html('send');
				  $('#gig_description').html('<?php echo $tech_speech;?>');
				  $('#gig_description').prop("disabled", false);
			   $("#continue").click(function(){
			   
				  if($('#sfsdfsdffd').css('display') == 'none')
                  {
                  $("#clickme").trigger('click');
                  }
				  callforbooking("bookingconfirmartist",csrf);
				  return false;
			   });
			   });

			   $('#myModal5').on('hidden.bs.modal', function () {
			   
				   //$(this).find("input,textarea,select").val('').end();
				  $("#bookingform").trigger('reset');
				   //validator.resetForm();
				   var validator = $("#bookingform").validate();
				   $('input').removeClass('authError');
				   validator.resetForm();
			   
			   });
        
        
        
        
         //****** for binding with  user image slider on change of slider starts 
                    var owl = $('.owl-carousel');
               
                     owl.owlCarousel({callbacks: true});
                
                     owl.on('changed.owl.carousel', function(event) {
                  
                    var totalItems = $('.item').length;
                     //console.log("len=>"+totalItems);
                
                    var currentitemnmbr=event.item.index;
                    var curritemnum=currentitemnmbr+1; // current item number without starting  from 0 ,  if current index is o then , curr photo is 0+1=1 , if 1 then 1+1=2
                  
                     showhideprevnextimgslider(totalItems,curritemnum) ;                  
               
                     });
               //****** for binding with  user image slider on change of slider ends
               
               
                //****** for showing right icon in image slider on load  starts 
               var totalItems = $('.item').length; var curritemnum=1;
               showhideprevnextimgslider(totalItems,curritemnum);
               //****** for showing right icon in image slider on load ends
   				
   				 
   	});

   	
   	//**** bind profile page ends
</script>
   <script>
  var flgBkGrp = "<?php echo $flagBkGrp;?>";
  var submitBtbFlag = "<?php echo $submitBtbFlag;?>";

  var showreviewornot = "<?php echo $fetchuserdata->review_show_flag?>";

function booking_modalnotopen(j)
{
  var replysesponse = "";
  if(j == 1)
  {
  // replysesponse = "You must be logged in to continue"
  $("#myModal1").modal('show');
  }
  if(j == 2){
   replysesponse = "Your request can not be processed"
   poptriggerfunc(msgtype='error',titledata='',msgdata=replysesponse,sd=6000,hd=1500,tmo=3000,etmo=4000,poscls='toast-top-full-width');
}

  //alert(replysesponse);
  

}


</script>

<script>
function no_presskit()
{
   toastr.remove();// Immediately remove current toasts without using animation
  poptriggerfunc(msgtype='error',titledata='',msgdata="Press kit not available",sd=1000,hd=1500,tmo=2000,etmo=1000,poscls='toast-bottom-right');
}
function booking_modal_norate()
{
   toastr.remove();// Immediately remove current toasts without using animation
   poptriggerfunc(msgtype='error',titledata='',msgdata="Hourly rate amount is not provided by this user",sd=1000,hd=1500,tmo=2000,etmo=1000,poscls='toast-bottom-right');
}
</script>
   <script type="text/javascript" src="{{ FRONTCSSPATH}}/otherfiles/progjs/frontendpublicprofile.js"></script>
	   
   <script type="text/javascript" src="{{ FRONTCSSPATH}}/otherfiles/progjs/jquery.maskMoney.js"></script>
   <script type="text/javascript" src="{{ FRONTCSSPATH}}/otherfiles/progjs/commoncustomloaderjs.js"></script> 




  <link rel="stylesheet" href="{{ FRONTCSSPATH}}/otherfiles/jquerytimepicker/css/jquery.timepicker.min.css">
 <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>   -->

  <script type="text/javascript" src="{{ FRONTCSSPATH}}/otherfiles/jquerytimepicker/js/jquery.timepicker.min.js"></script> 

  <script type="text/javascript" src="{{ FRONTCSSPATH}}/otherfiles/jquerytimepicker/js/artist_bookign.js"></script> 

 




@endsection