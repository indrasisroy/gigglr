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
   
   $metadescriptiondata ='';
   $first_name=''; $facebook_url=''; $twitter_url='';
   $instagram_url='';	$youtube_url='';	$residentadvisor_url='';
   $tech_speech = '';
   $user_description=''; $soundcloud_url='';$performence=0;$puntuality=0;$roundofpuntulity=0;$roundofperformence=0;
   $roundofpresentation=0;$rate_amount='';
   $rider_data = 'No information available';
   $security_figure = '';
   // added on 01-08 start 
   $cal_viewshowflag=1;
   $cal_pendingbkshowflag=1;
   $cal_publiceventshowflag=1;
   $review_show_flag=1;
   $cal_privateeventshowflag = 1;
   
   // added on 01-08 end
   $fetchskillmasterArData=array();
	
   $fetchcountrydata = array();
   $fetchbookingcatData = array();
   $fetchimgData = array();
   
   
 $filterevtype=''; $filterevtypeAr=array();
   
   
   if(!empty($fetchuserdata))
   {
   $creater_id = $fetchuserdata->creater_id;
   $front_id_sess= session('front_id_sess');
   
      // added on 01-08 start 
   	$groupId = $fetchuserdata->id;
	$rate_amount = $fetchuserdata->rate_amount;
	$submitBtbFlag = 1;
	if($rate_amount =='0.00'){
	$submitBtbFlag = 1;
	}

  if($rate_amount!='0.00')
  {
    $rate_amount=$fetchuserdata->rate_amount;
  }else
  {
    $rate_amount='';
  }

	// added on 01-08 end 
   $cal_viewshowflag=$fetchuserdata->cal_viewshowflag;
   $cal_pendingbkshowflag=$fetchuserdata->cal_pendingbkshowflag;
   $cal_publiceventshowflag=$fetchuserdata->cal_publiceventshowflag;
   $review_show_flag = $fetchuserdata->review_show_flag;
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
    $user_description=$fetchuserdata->group_description;
	$tech_speech = $fetchuserdata->tech_spec;
	$rider_data = $fetchuserdata->rider_data;
    $available_for = $fetchuserdata->available_for;
    $metadescriptiondata = $fetchuserdata->group_meta_data;

    $group_wallet_total_amount=$fetchuserdata->rate_amount;

     if($fetchuserdata->security_figure!='0.00')
    $security_figure = $fetchuserdata->security_figure;
    
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
   if(empty($tech_speech))
   {
	  $tech_speech = '';
   }
     if(!empty($usr_img))
   {
	 $fetchimgData = $usr_img;
   }

  ?>
  
  	   <?php
$flagBkGrp = Request::segment(3);
//$flagBkGrp = (empty($flagBkGrp)==true)?0:1;
if($flagBkGrp!='' && $flagBkGrp=='bk'){
$flagBkGrp='1';
}
$seo_name=Request::segment(2);

   $soundcloud_url_actcls = ''; $facebook_url_actcls = ''; $residentadvisor_url_actcls = ''; $twitter_url_actcls = ''; $youtube_url_actcls =''; $instagram_url_actcls = ''; $presskit_actcls = '';
      
   $facebook_url_deflt="https://www.facebook.com/";
   $soundcloud_url_deflt="https://www.soundcloud.com/";
   //$residentadvisor_url_deflt="https://www.residentadvisor.net/";
   $residentadvisor_url_deflt="https://www.mixcloud.com/";
   $twitter_url_deflt="https://www.twitter.com/";
   $youtube_url_deflt="https://www.youtube.com/";
   $instagram_url_deflt="https://www.instagram.com/";
   
   if($facebook_url=='' || $facebook_url==$facebook_url_deflt)
   {   $facebook_url_actcls = 'deactive';   }
   
    if($soundcloud_url==''||$soundcloud_url==$soundcloud_url_deflt)
   {   $soundcloud_url_actcls = 'deactive';   }
   
      if($residentadvisor_url==''||$residentadvisor_url==$residentadvisor_url_deflt)
   {   $residentadvisor_url_actcls = 'deactive';   }
   
      if($twitter_url==''||$twitter_url==$twitter_url_deflt)
   {   $twitter_url_actcls = 'deactive';   }
   
      if($youtube_url==''||$youtube_url==$youtube_url_deflt)
   {   $youtube_url_actcls = 'deactive';   }
   
      if($instagram_url==''||$instagram_url==$instagram_url_deflt)
   {   $instagram_url_actcls = 'deactive';   }
   

?>
@extends('layouts.front.frontendmaster',['successmsg' => $successmsg,'errormsg'=>$errormsg,'metadescriptiondata'=>$metadescriptiondata])
@section('content')
<!-- profile-section-start -->
<section class="profile_outer">
   <div class="container">
      <div class="row dj_row">
         <div class="col-sm-5">
            <div class="profile_slider groupprofilesliderouterdv">
             
				 <?php
				 // $imgurldata = asset("front/otherfiles/progimages/"."noimagefound537X507.png");
				  $imgurldata = BASEURLPUBLICCUSTOM."front/otherfiles/progimages/"."noimagefound537X507.png";
				 
               // $fetchimgDat2a = array();
                if(!empty($fetchimgData))
                {
                    foreach($fetchimgData as $fetchimgData)
                    {
						//$imgurl = asset('upload/groupimage/thumb-big/'.$fetchimgData->image_name);
						$imgurl = BASEURLPUBLICCUSTOM.'upload/groupimage/thumb-big/'.$fetchimgData->image_name;
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
			   if($creater_id == $front_id_sess){
			   ?>
						<a href="javascript:void(0)" class="like_link red-tooltip goTo myfavorite deactive <?php echo $myfavoriteClass;?>" data-userId="<?php echo $fetchuserdata->id?>" data-go-to="Favorite_section" data-usertype="2" data-toggle="tooltip" title="Favorite"><img src="{{ FRONTCSSPATH}}/images/heart_icon.png" alt="" /></a>
				<?php
				}
				else
				{
				?>
				<a href="javascript:void(0)" class="like_link red-tooltip goTo myfavorite <?php echo $myfavoriteClass;?>" data-userId="<?php echo $fetchuserdata->id?>" data-go-to="Favorite_section" data-usertype="2" data-toggle="tooltip" title="Favorite"><img src="{{ FRONTCSSPATH}}/images/heart_icon.png" alt="" /></a>
			<?php	}
				?>
					
                        
						<a href="profile.html#calendr" class="red-tooltip goTo" data-go-to="Calender_section" data-toggle="tooltip" title="Calender"><img src="{{ FRONTCSSPATH}}/images/calender_icon.png" alt="" /></a>
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
            </div>
            <div class="row row_visitor">
               <ul class="col-sm-6 visitor_cols">
			   <?php
			   if($facebook_url_actcls!='deactive'){
			   ?>
                  <li class = "<?php echo $facebook_url_actcls;?>">
                     <a href="{{$facebook_url}}" target="_blank">
                     <span class="icon_social" style="background: #3b5998;"><img src="{{ FRONTCSSPATH}}/images/fb_icon.png" alt="" /></span>
                     facebook
                     </a>
                  </li>
			   <?php
			   }
			   if($soundcloud_url_actcls != 'deactive'){
			   ?>
			   
                  <li class ="<?php echo $soundcloud_url_actcls;?>">
                     <a href="{{$soundcloud_url}}" target="_blank">
                     <span class="icon_social" style="background: #ff7e30;"><img src="{{ FRONTCSSPATH}}/images/cloud_icon.png" alt="" /></span>
                     Soundcloud
                     </a>
                  </li>
			   <?php
			   }
			   if($residentadvisor_url_actcls != 'deactive'){
			   ?>
                  <li class ="<?php echo $residentadvisor_url_actcls;?>">
                     <a href="{{$residentadvisor_url}}" target="_blank">
                     <span class="icon_social" style="background: #589fC3;"><img src="{{ FRONTCSSPATH}}/images/mixcloud.png" alt="" /></span>
                     Mixcloud
                     </a>
                  </li>
			   <?php
			   }
			   if($twitter_url_actcls != 'deactive'){
			   ?>
                  <li class ="<?php echo $twitter_url_actcls;?>">
                     <a href="{{$twitter_url}}" target="_blank">
                     <span class="icon_social" style="background: #00aced;"><img src="{{ FRONTCSSPATH}}/images/tweeter_icon.png" alt="" /></span>
                     Twitter
                     </a>
                  </li>
			   <?php
			   }
			   if($youtube_url_actcls != 'deactive'){
			   ?>
                  <li class ="<?php echo $youtube_url_actcls;?>">
                     <a href="{{$youtube_url}}" target="_blank">
                     <span class="icon_social" style="background: #e32b21;"><img src="{{ FRONTCSSPATH}}/images/youtube_icon.png" alt="" /></span>
                     YouTube
                     </a>
                  </li>
			   <?php
			   }
			   if($instagram_url_actcls != 'deactive'){
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
<!--                     <a href="#" class="book_btn openbkgrpcls openmodal" data-toggle="modal" data-target="#myModal5">book group</a>-->
			   <?php
			   if($creater_id == $front_id_sess || $submitBtbFlag == '0'){
			   ?>
			   <a href="javascript:void(0)" class="book_btn openbkgrpcls deactive openmodal a" data-toggle="modal">book group</a>
			   <?php
			   }else if($front_id_sess==''){
			   ?>
			   <a href="javascript:void(0)" class="book_btn openbkgrpcls  openmodal b" data-toggle="modal">book group</a>
			   <?php
			   }
			   else{
			   ?>
			   <a href="javascript:void(0)" class="book_btn openbkgrpcls currencyGrpBook" data-currency="<?php echo $group_currency;?>" >book group</a>
			   <!--<a href="#" class="book_btn openbkgrpcls openmodal" data-toggle="modal" data-target="#myModal5">book group</a>-->
			   <?php
			   }
			   ?>
			   
                  </div>
                  <div class="btn_row">
<!--                     <a href="#" class="book_btn press_btn">press kit</a>-->
                      <?php
					  if(!empty($presskit)){
						if($presskit!='')
						{
							  $presssecure = 'grouppresskitdownload/'.base64_encode($presskitname = $presskit->presskit_name);
						
							  echo link_to($presssecure, $title = 'press kit', $attributes = array("class"=>"book_btn press_btn"), $secure = null);
						}
					  }else
						{
							echo link_to('#', $title = 'press kit', $attributes = array("class"=>"book_btn press_btn deactive"), $secure = null);
						}

					 ?>
                  </div>
                  <div class="btn_row">
                     <!-- <a href="#" class="book_btn rider_btn">menu</a> -->
                     <!--<a href="#" class="book_btn rider_btn"></a>-->
						<a href="javascript:void(0);" class="book_btn rider_btn"> View Rider</a>
                  </div>
                   
                   
                   
                   
                  <div class="btn_row">
                     <div class="rank_cell">
                        Performance
                        <div class="star_cell">
                             <?php
							 if(!empty($performance)){
							  $roundofperformence = round($performance);
							  for($performnc = 0;$performnc<$roundofperformence;$performnc++)
							  {
								?>
								<span><img src="{{ FRONTCSSPATH}}/images/star_icon.png" alt="" /></span>
								<?php
							  }
							}else{
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
							 if(!empty($presentation)){
								 $roundofpresentation = round($presentation);
								 for($presentn = 0;$presentn<$roundofpresentation;$presentn++)
								 {
								 ?>
								 <span><img src="{{ FRONTCSSPATH}}/images/star_icon.png" alt="" /></span>
								 <?php
								 }
							  }else{
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
						   if(!empty($punctuality)){
							 $roundofpuntulity = round($punctuality);
                            for($puncual = 0;$puncual<$roundofpuntulity;$puncual++)
                            {?>
                                <span><img src="{{ FRONTCSSPATH}}/images/star_icon.png" alt="" /></span>
                        <?php    }
													  }else{
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

<!-- end of paymenet -->
<?php if( !empty($cal_viewshowflag) && ( $cal_viewshowflag==1 ) ) { ?>
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
         <div class="right_chart clearfix profileCatFen">
         </div>
      </div>
   </div>
   <div class="container">
      <div class="event_left calendarHeight">
         <div class="event_left_row">
            <h2 class="event_heading">Events</h2>
            <ul class="visitor_cols event_btn_group">
              <!-- <li>
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
				  
            </ul>
         </div>
		 <div class = 'loadLeftGigList'></div>

      </div>
      <div id="calendardivid" class="event_right calendarHeight">
        
      </div>
   </div>
</section>


  <?php } ?>
<!--Review Section starts here-->
   <?php if($fetchuserdata->review_show_flag == 1){ ?>
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
			<?php
			if($userreview->image_name!=''){
			?>
			<div class="prodile_img"><img alt="" src="{{ URL::asset('')}}public/upload/userimage/thumb-small/{{$userreview->image_name}}"></div>
			<?php
			}else{
			?>
			<div class="prodile_img"><img alt="" src="{{ FRONTCSSPATH}}/otherfiles/progimages/noimagefound52X52.jpg"></div>
			<?php
			}
			?>
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

									   echo "<li>".$userreview->category_name.': '.$userreview->genre_name."</li>";

						   ?>
						   <!-- incluede category and genre end-->
						   
						   
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
      <?php }?>
    <!--Review Section ends here-->
<!-- profile-section-end -->

<!--book group modal start here 24-06-->

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
			   <?php
			   if($available_for == '3'){
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
			   }else{
			   ?>
			   <span>
				  <?php
				  if($available_for == '1'){
				  echo "Public Event: Public Only";
				  }else if($available_for == '2')
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
                  <div class="new-location clearfix clickmeShow" style="display:none;" id="opnaddresssection">
                      <div class="col-md-12">
                        <div class="artist_divsn reqst_dvsn">
                          <div class="inline artist_list request_type">
                               <!--<input type="text" class="form-control form-control-B" placeholder="Address1"/>-->
							   <?php echo Form::text("address1", $value="", $attributes = array( "id"=>"address1","placeholder"=>"Address1","class"=>"form-control form-control-B" )); ?>
                              <!--<input type="text" class="form-control form-control-B" placeholder="Address2"/>-->
							  <?php echo Form::text("address2", $value="", $attributes = array( "id"=>"address2","placeholder"=>"Address2","class"=>"form-control form-control-B" )); ?>
                            </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="artist_divsn">
                          <div class="inline artist_list request_list">
						   <?php								
						   $control_attrAr=array();
						   $control_attrAr['id']='country';
						   $control_attrAr['class']=" selectpicker ";
						   $control_attrAr['title']="Select Country";
						   
						   $fetchcountryArData=array();
						//   $fetchcountryArData[]="Select country";
						   if(!empty($country)){
						   foreach($country as $countryAll){
							   $fetchcountryArData[$countryAll->id]=$countryAll->country_name;
						   }
						   }
						   if($fetchuserdata->country!=''){
						   $country = $fetchuserdata->country;
						   }else{
						   $country='';	
						   }						
						   echo Form::select('country', $fetchcountryArData, $country,$control_attrAr);							
						   ?>
                            </div>
                        </div>
                    </div>
                      <div class="col-md-6">
                        <div class="artist_divsn">
                          <div class="inline artist_list request_list">
                                <!--<select class="selectpicker artist_txt">
                                    <option value="0"> State</option>
                                    <option value="1">Arkansas</option>
                                    <option value="2">California</option>
                                    <option value="3">Delaware</option>
                                </select>-->
								 <?php
								
								 $control_attrAr=array();
								 $control_attrAr['id']='select_state';
								 $control_attrAr['class']=" selectpicker ";
								// $control_attrAr['title']="Select state";
								 
								 if($fetchuserdata->state!=''){
								 $select_state=$fetchuserdata->state;
								 }else{
								 $select_state='';
								 }
								 $fetchstateData=array();
								 if(!empty($state)){

								 	 foreach($state as $stateAll){
								 		 $fetchstateData[$stateAll->id]=$stateAll->state_3_code;
								 	 }
                   // echo "<pre>";
                   // print_r($fetchstateData);
								 }
								 
								 echo Form::select('select_state', $fetchstateData, $select_state,$control_attrAr);							
							 ?>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <div class="artist_divsn">
                          <div class="inline artist_list request_list">
                                <!--<input type="text" class="form-control" placeholder="City" />-->
								<?php echo Form::text("city", $value="", $attributes = array( "id"=>"city","placeholder"=>"City","class"=>"form-control form-control-B")); ?>
								
                            </div>
                        </div>
                    </div>
                      <div class="col-md-6">
                        <div class="artist_divsn">
                          <div class="inline artist_list request_list">
                                <!--<input type="text" class="form-control" placeholder="Zip" />-->
								<?php echo Form::text("zip", $value="", $attributes = array( "id"=>"zip","placeholder"=>"Post Code","class"=>"form-control form-control-B")); ?>
                            </div>
                        </div>
                    </div>
                    
                    <a class="closeLoc" href="javascript:void(0);"></a>
                    
                </div>
                  <!--------------------------For Town and Zip ends here-------------------------------->
                  <div class="col-md-6">
                     <div class="artist_divsn">
                        <div class="inline artist_list request_list lightYlw">
                           <?php

                              $control_attrAr=array();
                              $control_attrAr['id']='bookingcat_sub';
                              $control_attrAr['class']="selectpicker artist_txt";
                              $control_attrAr['title']="Category for Event";
                              $bookingcat_sub='';
                              echo Form::select('bookingcat_sub',
                              $fetchbookingcatData,
                              $bookingcat_sub,
                              $control_attrAr
                              );							
                              ?>
                        </div>
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="artist_divsn">
                        <div class="inline artist_list request_list lightYlw">
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
                                 "class"=>"form-control date_outr datetimepicker fadeYlw",
                                
                                 ));
                                 ?>
                              <span class="input-group-addon dt">
                              <span class="glyphicon glyphicon-calendar clndr"></span>
                              </span>
                           </div>
                        </div>
                     </div>

								      <!-- <div class="inline artist_list">
                        <span>Start Time:</span>
                        <div class="form-group inpt input-customm input-customm-2">
                           <div class='input-group date' id='datetimepicker3'>
                            
                             <?php    
                                 // echo Form::text("start_time",
                                 // $value='',
                                 // $attributes = array( "id"=>"start_time",
                                 // "class"=>"form-control clck_outr timepicker",
                                
                                 // ));
                                 ?>
                              <span class="input-group-addon clck">
                              <span class="glyphicon glyphicon-time"></span>
                              </span>


                         </div>
                        </div>
                     </div> -->

                      <div class="inline artist_list">
                        <span>Start Time:</span>
                        <div class="form-group inpt input-customm clearfix newTimeWrap">
                           <div class="timeField">
                              <input type='text' maxlength="2" class="form-control date_outr" placeholder="hh" id="start_time_hr" name="start_time_hr" />
                           </div>
                           <div class="timeField">
                           <input type='text' maxlength="2" class="form-control date_outr" placeholder="mm" id="start_time_mnt" name="start_time_mnt" /></div>
                           <div class="ampm bbbbb">
                            <select class="selectpicker artist_txt" id="ddlViewBy" name="ddlViewBy">
                            <option value="1">am</option>
                            <option value="2">pm</option>
                            </select>
                          </div>
                        </div>
                     </div>



                   
                       <!--  <div class="inline artist_list">
                        <span>End Time:</span>
                        <div class="form-group inpt input-customm input-customm-2">
                           <div class='input-group date' id='datetimepicker4'>
                                
                                <?php
                                 // echo Form::text("end_time",
                                 // $value='',
                                 // $attributes = array( "id"=>"end_time",
                                 // "class"=>"form-control clck_outr timepicker",
                                
                                 // ));
                                 ?>
                              <span class="input-group-addon clck">
                              <span class="glyphicon glyphicon-time"></span>
                              </span>


                           </div>
                        </div>
                     </div> -->

                      <div class="inline artist_list">
                        <span>Duration:</span>
                          <div class="form-group inpt input-customm clearfix newTimeWrap">
                            <div class="timeField"> 
                              <input type='text' class="form-control date_outr" maxlength="2"  placeholder="hh" id="end_time_hr" name="end_time_hr" />
                            </div>
                            <div class="timeField">
                             <input type='text' class="form-control date_outr" maxlength="2" placeholder="mm" id="end_time_mnt" name="end_time_mnt" />
                            </div>
                          </div>
                     </div> <!-- end of inline artist list -->

								
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
                              <span class="glyphicon lck"><div id="bookingcanimg_div" data-bookingcanimgflag="0"></div></span>
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
					</div>
						<div class="col-md-6">
                     <!-- <div class="inline artist_list">
                        <span>Request Expire Time:</span>
                        <div class="form-group inpt input-customm input-customm-color">
                           <div class='input-group date' id='datetimepicker5'>
                                
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
                     </div> -->

                     <div class="inline artist_list">
                              

                            <span>Request Expire Time:</span>
                            <div class="form-group inpt input-customm clearfix newTimeWrap">
                              <div class="timeField">
                              <input type='text' maxlength="2" class="form-control date_outr clck_outr fadeRed" placeholder="hh" id="requexpire_time_hr" name="requexpire_time_hr" />
                              </div>
                              <div class="timeField">
                              <input type='text' maxlength="2" class="form-control date_outr clck_outr fadeRed" placeholder="mm" id="reqexpire_time_mnt" name="reqexpire_time_mnt" /></div>
                              <div class="ampm aaaaa">
                              <select class="selectpicker artist_txt" id="ddlViewrequestexpire" name="ddlViewrequestexpire">
                              <option value="0">am</option>
                              <option value="1">pm</option>
                              </select>
                              </div>
                            </div>

</div>


                  </div>
							
                  <div class="col-md-12">
                     <div class="inline artist_list" id="tech_speech_div">
                        
												                      <?php
					  
					  echo Form::textarea("gig_description", $value=stripslashes($tech_spec_group), [ "id"=>"gig_description",  "disabled","placeholder"=>" ","class"=>"form-group inpt nb form-control" ]);
					  
					  ?>
                        <!--                       <p> 5 lines, 50 characters maximum per line</p>-->
                     </div>
                  </div>
                  <div class="col-md-12">
                     <button class="btn btn-warning artist_btn reqst_btn buttonpercentg" id="cancelbtn" data-dismiss="modal">cancel</button>
                                          <button class="btn btn-warning artist_btn rqst_trm_btn agretoterm buttonpercentg" type="button" id="venuebookingsubmit">ok got it </button>
					 <!--<button class="btn btn-warning artist_btn rqst_trm_btn" style="display:none" type="button" id="venuebookingsubmit">send </button>-->
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
   var ridervalue = "<?php echo str_replace(PHP_EOL, ' ',$rider_data);?>";
   var filterevtype = '<?php echo $filterevtype; ?>'; //console.log("on load =>"+filterevtype);
   var pro_category = '';
   var pro_genre = '';
   var daymonth = 'month';
   var seo_name="<?php echo $seo_name; ?>";
   var type_flag=2;
   var cal_select_date=moment().format('YYYY-MM-DD');
   var someevntfired_flag=0;
   
   var cal_viewshowflag="<?php echo $cal_viewshowflag; ?>";
   var cal_pendingbkshowflag="<?php echo $cal_pendingbkshowflag; ?>";
   var cal_publiceventshowflag="<?php echo $cal_publiceventshowflag; ?>";
   // added in 03-08 start
   var cal_privateeventshowflag="<?php echo $cal_privateeventshowflag; ?>";   
   // added in 03-08 end
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
   
   $(document).on('click','.currencyGrpBook',function(){
   var P_currency = $(this).data("currency");
   var l_currency = "<?php echo $login_currency;?>";



   var currentloggedinuserid = "<?php echo $front_id_sess; ?>";
   var groupcreater_id = "<?php echo $creater_id; ?>";
// alert()
   var currentuserwalletamount = "<?php echo $wallet_amount; ?>";
   var groupwalletamount = "<?php echo $group_wallet_total_amount; ?>";
  // alert(" currentuserwalletamount "+currentuserwalletamount+" groupwalletamount "+ groupwalletamount);
   
   if (l_currency == P_currency) {



        if(currentloggedinuserid!=groupcreater_id)
                    {
                        
                            if(parseFloat(currentuserwalletamount) < parseFloat(groupwalletamount))
                            {
                     
                             $('#myModal3paymentview').modal('show');
                             

                            }else if(parseFloat(currentuserwalletamount) == "0.00")
                            {
                              $('#myModal3paymentview').modal('show');
                            }else
                            {
                              $('#myModal5').modal('toggle');
                              $('#myModal5').modal('show');
                            }
                     } else
                    {
                      $('#myModal5').modal('toggle');
                      $('#myModal5').modal('show');
                    }






            		 // $('#myModal5').modal('toggle');
            		 // $('#myModal5').modal('show');


	  }else{
		 toastr.remove();// Immediately remove current toasts without using animation
		 poptriggerfunc(msgtype='error',titledata='',msgdata="Group currency mismatch",sd=1000,hd=1500,tmo=null,etmo=null,poscls='toast-bottom-right');
	  }
   })
      
</script>

<!-- for full callendar related   starts  -->	
<link rel="stylesheet" href="{{ URL::asset('public/front')}}/otherfiles/fullcalendar2.8/fullcalendar.css">	
<script type="text/javascript" src="{{ URL::asset('public/front')}}/otherfiles/fullcalendar2.8/fullcalendar.min.js"></script>
<script type="text/javascript" src="{{ FRONTCSSPATH}}/otherfiles/progjs/frontendpublartgrpvencalendar.js"></script>
      <script type="text/javascript" src="{{ FRONTCSSPATH}}/otherfiles/progjs/frontendprofileFavorite.js"></script>
<!-- for full callendar related   ends  -->	
  <script type="text/javascript" src="{{ FRONTCSSPATH}}/otherfiles/progjs/frontendpublicprofilegig.js"></script> 
  <script type="text/javascript" src="{{ FRONTCSSPATH}}/otherfiles/progjs/frontendpubliccommonprofile.js"></script> 
<script>
   // $(document).ready(function(){
   
   	
   // 	$('#total_payment').maskMoney({prefix:'$'}); //******masking for total payment
   // 	$('#cancellation_payment').maskMoney({prefix:'$'});//******masking for cancellation payment
   // 	$('#security_payment').maskMoney({prefix:'$'});//*******masking for security payemnt
   	
   // });
   // //********masaking length for total payment attribute
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
   // //$("#security_payment").next().focus();
   
     
</script>
<script>
   
   
						//***************************modal hide starts here*****************
									   $('#closemodal').click(function(){
									   $('#myModal5').modal('hide');
									  });
						//**************************modal hide ends here**********************
   
   
						//************************** bind profile page starts********************************
						//*********************function for form validation==============*******in frontendpublicprofile.js page
						//			jQuery("#profilesubmit").click(function(){
						$('#venuebookingsubmit').click(function(){
						   $("#tech_speech_div").slideDown('fast');
						   $(this).html('send');
						   $('#gig_description').html('<?php echo $tech_speech;?>');
						   $('#gig_description').prop("disabled", false);
						//   jQuery("#venuebookingsubmit").click(function(){
						   
							  if($('#opnaddresssection').css('display') == 'none')
							  {
							  $("#clickme").trigger('click');
							  }
							  
							  
							  var csrf = "<?php echo csrf_token(); ?>";
							  
							  var pj = callforbooking("groupprofilesubmit",csrf);
						   
						 //  });
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
	//  $('#agretoterm').click(function(){
	//
	//	 $("#agretoterm").css("display","none");
	//	 $("#venuebookingsubmit").css("display","");
	//	 $("#tech_speech_div").css("display","");
	//	 
	//  });

	 $('.timeField input').keyup(function(e) {
      if(this.value.length == $(this).attr('maxlength')) {
      $(this).parent().next().children().focus();
      $(this).parent().next().children().find('button').focus();
      }
      });
	//$("#msform").attr("style", "display:none");
	   $("#divLoading").css("display","none");
	  //*********
	var csrf = "<?php echo csrf_token(); ?>";
	//*********
   				var booking_date ='';
   				var requestexpireddate ='';
   				var datemax ='';
   			//alert(booking_date);
   				
   				var datecur = new Date();
   				datecur.setDate(datecur.getDate() + 3);
   				var datecur2 = new Date();
   				//$('#booking_date').datetimepicker({
   				//format: 'DD/MM/YYYY',
   				//minDate:datecur
   				//});
   				// $('#requestexpireddate').datetimepicker({
   				// format: 'DD/MM/YYYY',
   				// minDate:datecur2
   				
   				// });
   					
            $("#start_time").datetimepicker({
          format: 'LT'
          });

    $('#start_time').prop("disabled", true);
    $('#end_time').prop("disabled", true);

    $('#requestexpireddate').prop("disabled", true);
    $('#requestexpiredtime').prop("disabled", true); 

   				//***********soumik da***************************************************************************** 
   					
   		// 			$("#start_time").datetimepicker({
					// minDate: 1,
     //               format: 'LT'
     //           });
   		// 		$("#start_time").on("dp.change", function(e)
   		// 		{

   		// 			 var mmdata1=e.date;
   		// 			 console.log(e.date);
					 
					//  //alert(mmdata1);
   					 
   		// 			 var startmmnttime= mmdata1.format("HH:mm");
   		// 			console.log( "=startmmnttime=>"+startmmnttime);
   					
   					
   					
   		// 			//**** get start date starts
   					
   		// 			//moment("12/25/1995", "MM-DD-YYYY");
   		// 			var startdatedata=$("#booking_date").val();
   		// 			console.log("=startdatedata=>"+startdatedata );
   										
   					
   		// 			var mmmntstartdate=moment(startdatedata,"DD-MM-YYYY").format("YYYY-MM-DD");
   					
   		// 			console.log("=mmmntstartdate=>"+mmmntstartdate );
   					
   		// 			var totaldatetime=mmmntstartdate+' '+startmmnttime;
   					
   		// 			console.log("=totaldatetime=>"+totaldatetime );
   					
   		// 			var prevsdate5hrsback=moment(totaldatetime,"YYYY-MM-DD HH:mm").subtract(5,"hours").format("MM-DD-YYYY" );
   		// 			var prevstime5hrsback=moment(totaldatetime,"YYYY-MM-DD HH:mm").subtract(5,"hours").format("hh:mm A" );
   					
   		// 			console.log("=prevsdatetime5hrsback=>"+prevsdate5hrsback + "prevstime5hrsback=>"+ prevstime5hrsback );
   					
   		// 			//**** get start date ends
					
					// //********added by Indrasis after soumik da
					
					// var setdate=moment(prevsdate5hrsback,"MM-DD-YYYY").format("DD/MM/YYYY");
					// //var tttt = new Date(prevsdate5hrsback);
					// console.log(setdate);
					// $("#requestexpireddate").datetimepicker({
					// //minDate: 1;
					// 	//format:'DD-MM-YYYY',
					// 	//maxDate:prevsdate5hrsback
					// });
					
					// $('#requestexpireddate').data("DateTimePicker").maxDate(setdate);
					// var requestTime = $("#requestexpireddate").val();
					// var bookingTime = $("#booking_date").val();
					// console.log("request time=============>"+requestTime);
					// console.log("booking time=============>"+ bookingTime);
					// $('#requestexpiredtime').data("DateTimePicker").maxDate(prevstime5hrsback);
					// //********added by Indrasis after soumik da
   					 
   		// 		});
   				
   				//*****soumik da****************************************************************************************************
				
				
				
				
				// $("#requestexpireddate").on("dp.change", function(e)
   	// 			{
   				
   	// 				// alert('hello');
   	// 				 var mmdata1=e.date;
   	// 				 console.log(e.date);
   					 
   	// 				var startmmnttime= mmdata1.format("HH:mm");
   	// 				console.log( "=startmmnttime=>"+startmmnttime);
   					
   					
   					
   	// 				//**** get start date starts
   					
   					
   	// 				var startdatedata=$("#booking_date").val();
   	// 				console.log("=startdatedata=>"+startdatedata );
   										
   					
   	// 				var mmmntstartdate=moment(startdatedata,"DD-MM-YYYY").format("YYYY-MM-DD");
   					
   	// 				console.log("=mmmntstartdate=>"+mmmntstartdate );
   					
   	// 				var totaldatetime=mmmntstartdate+' '+startmmnttime;
   					
   	// 				console.log("=totaldatetime=>"+totaldatetime );
   					
   	// 				var prevsdate5hrsback=moment(totaldatetime,"YYYY-MM-DD HH:mm").subtract(5,"hours").format("MM-DD-YYYY" );
   	// 				var prevstime5hrsback=moment(totaldatetime,"YYYY-MM-DD HH:mm").subtract(5,"hours").format("hh:mm A" );
   					
   	// 				console.log("=prevsdatetime5hrsback=>"+prevsdate5hrsback + "prevstime5hrsback=>"+ prevstime5hrsback );
   					
   	// 				//**** get start date ends
					
				// 	//********added by Indrasis after soumik da
				// 	var requestTime = $("#requestexpireddate").val();
				// 	var bookingTime = $("#booking_date").val();
				// 	//console.log("request time=============>"+requestTime);
				// 	//console.log("booking time=============>"+ bookingTime);
					
				// 	if (requestTime == bookingTime)
				// 	{
    //                    // console.log('match found');
				// 	   $("#requestexpiredtime").show();
				// 		$('#requestexpiredtime').data("DateTimePicker").maxDate(prevstime5hrsback);
						
    //                 }
				// 	else
				// 	{
				// 		console.log('match not found');
						
				// 		//$('#requestexpiredtime').data("DateTimePicker").maxDate("null");
				// 		$("#requestexpiredtime").datetimepicker({
				// 		   maxDate:false
				// 		});
				// 		// $("#requestexpiredtime" ).data("DateTimePicker").maxDate("null");
				// 	}
					
				// 	//********added by Indrasis after soumik da
   					 
   	// 			});
				
				
				
				
				
				
				
				
   				
				//************* For ajax state starts  here
								$("#country_id").change(function()
								{
									var ProfilecountryId = $(this).val();
									//var csrf = "<?php echo csrf_token(); ?>";
									//var requestStateUrl = 'countrystate';
									var requestStateUrl = 'groupcountrystate';
									getStateforCountry(requestStateUrl,ProfilecountryId,csrf);
								
								});
				//*************  For ajax state ends here
				
				//************ For ajax genere starst here
							  $("#bookingcat_sub").change(function()
								{
									var Catagory_Id = $(this).val();
									//var requestStateUrl = 'getGenere';
									var requestStateUrl = 'groupgetGenere';
									getGenereforCategory(requestStateUrl,Catagory_Id,csrf);
								
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
			   $("#continue").click(function(){
				  //alert('hello');
				  callforbooking("bookingconfirm",csrf);
				  return false;
			   });
			   $('#myModal5').on('hidden.bs.modal', function () {
			   
				   //$(this).find("input,textarea,select").val('').end();
				  $("#bookingform").trigger('reset');
				   //validator.resetForm();
				   var validator = $("#bookingform").validate();
				  $('input').removeClass('authError');
				  $('input').parent().removeClass("errorField");
				  $('select').parent().removeClass("errorField");
				   validator.resetForm();
			   
			   });
        
        
        
        
         //****** for binding with  user image slider on change of slider starts 
                    var owl = $('.owl-carousel');
               
                     owl.owlCarousel({callbacks: true});
                
                     owl.on('changed.owl.carousel', function(event) {
                   
						   
							var totalItems = $(".groupprofilesliderouterdv").find(".item").length;
                    //var totalItems = $('.item').length;
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
   var groupId = "<?php echo $groupId;?>";
   var gig_type = '2';
   var event_type_entry = "<?php echo $available_for ?>";
   var creater_id = "<?php echo $creater_id;?>";
   var submitBtbFlag = "<?php echo $submitBtbFlag;?>";
</script>
   <script type="text/javascript" src="{{ FRONTCSSPATH}}/otherfiles/progjs/frontendpublicgroup.js"></script>
   <script type="text/javascript" src="{{ FRONTCSSPATH}}/otherfiles/progjs/jquery.maskMoney.js"></script>
<!--   <script type="text/javascript" src="{{ FRONTCSSPATH}}/otherfiles/progjs/frontendcommon.js"></script>   -->
   <!-- <script type="text/javascript" src="{{ FRONTCSSPATH}}/otherfiles/progjs/bookingdatetimevalidation.js"></script> -->

    <!-- <script type="text/javascript" src="{{ FRONTCSSPATH}}/otherfiles/progjs/frontendartistgroupdatetimepicker.js"></script>  -->
    <script type="text/javascript" src="{{ FRONTCSSPATH}}/otherfiles/progjs/bookingdatetimevalidation.js"></script>

<style>
.aaaaa button{
  background-color: #ffd9d9!important;
}
.bbbbb button{
  background-color: #fdf2e6!important;
}
</style>

@endsection