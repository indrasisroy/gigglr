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
   $user_description=''; $soundcloud_url='';$performence=0;$puntuality=0;$presentation=0;$roundofpuntulity=0;$roundofperformence=0;
   $rider_data='No information available';
   $roundofpresentation=0;
   $artist_own_id = 0;
   $available_for = 3;
   $security_figure = 0.00;
   
   $cal_viewshowflag=1;
   $cal_pendingbkshowflag=1;
   $cal_publiceventshowflag=1;
   $review_show_flag=1;
   $cal_privateeventshowflag = 1;

	  $fetchskillmasterArData=array();
	  
	  $fetchcountrydata = array();
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
	  if($rate_amount =='0.00')
	  {
	  $submitBtbFlag = 0;	
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

	  $tech_speech = $fetchuserdata->tech_spec;
	  $available_for = $fetchuserdata->available_for;

	  if($fetchuserdata->security_figure)
	  $security_figure = $fetchuserdata->security_figure;

     if($fetchuserdata->id)
	 $artist_own_id=$fetchuserdata->id;


	  if($fetchuserdata->rider_data)
	  $rider_data=$fetchuserdata->rider_data;



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
	  $tech_speech = 'No Tech Specs Provided';
   }
     if(!empty($usr_img))
   {
	 $fetchimgData = $usr_img;
   }
   
    if(!empty($artistbooking_skill))
   {
   
     $fetchbookingskillcategory =$artistbooking_skill;
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
						
						<a href="javascript:void(0)" class="like_link red-tooltip goTo myfavorite <?php echo $myfavoriteClass;?>" data-userId="<?php echo $fetchuserdata->id?>" data-go-to="Favorite_section" data-usertype="1" data-toggle="tooltip" title="Favorite"><img src="{{ FRONTCSSPATH}}/images/heart_icon.png" alt="" /></a>
                        
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
                     	echo "<pre>";
                      print_r($skill_sub_data_Ar);
                     		foreach($skill_sub_data_Ar as $kk => $kvlue)
                     		{
                     			$i++;
                     			$skill_sub_data=$skill_sub_data_Ar[$kk];
                     		echo "hello".$skill_sub_txtdata=$skill_sub_txtdata_Ar[$kk];die;
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
                     <a href="javascript:void(0)" class="book_btn openbkgrpcls" onclick="booking_modalnotopen(1);">book artist</a>
                  
                  <?php 
                  }else
                  { 
                    if($atrist_sessionID == $artist_own_id)
                    { ?>
                    <a href="javascript:void(0)" class="book_btn openbkgrpcls" onclick="booking_modalnotopen(2);">book artist</a>
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
                     <a href="javascript:void(0);" class="book_btn rider_btn">{{$rider_data}}</a>
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
<div class="modal fade" id="myModal3" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
   <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content popup-content">
         <div class="modal-body popup-body wallet">
            <div class="clearfix">
               <div class="test">
                  <div class="payment_menus">
                     <ul class="payment_menus_list">
                        <li><a data-toggle="tab" href="#payone">Bank Account</a> </li>
                        <li><a data-toggle="tab" href="#paytwo">Paypal</a> </li>
                        <li class="active"><a data-toggle="tab" href="#paythree">Credit Card</a> </li>
                        <!--                        <li><a data-toggle="tab" href="#payfour">ABN & GST</a> </li>-->
                     </ul>
                  </div>
               </div>
               <div class="test1">
                  <div class="tab-content">
                     <div id="payone" class="tab-pane fade">
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                     </div>
                     <div id="paytwo" class="tab-pane fade">
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                     </div>
                     <div id="paythree" class="tab-pane fade in active">
                        <div class="card_payments">
                           <h3 class="pay_hed">
                              We welcome these cards
                              <Span><img src="{{ FRONTCSSPATH}}/images/c1.png" alt=""> </Span> 
                              <Span><img src="{{ FRONTCSSPATH}}/images/c2.png" alt=""> </Span> 
                              <Span><img src="{{ FRONTCSSPATH}}/images/c3.png" alt=""> </Span> 
                              <!--
                                 <Span><img src="images/c4.png" alt=""> </Span> 
                                 <Span><img src="images/c5.png" alt=""> </Span> 
                                 -->
                           </h3>
                           <form class="card_payments_content">
                              <div class="card_inputs">
                                 <input class="form-control txt_color" type="text" placeholder="Name on Card" />
                              </div>
                              <div class="card_inputs card">
                                 <select class="selectpicker">
                                    <option value="0">Card Type</option>
                                    <option value="1">Visa</option>
                                    <option value="2">Mastro Card</option>
                                    <option value="3">American Express</option>
                                 </select>
                              </div>
                              <div class="card_inputs">
                                 <input class="form-control txt_color" type="text" placeholder="Card Number" />
                              </div>
                              <div class="row card_inputs">
                                 <div class="col-sm-5">
                                    <input class="form-control txt_color" type="text" placeholder="CVV" />
                                 </div>
                                 <div class="col-sm-7">
                                    <div class="row exp_dates">
                                       <div class="col-sm-4 date_label">Expiry Date </div>
                                       <div class="col-sm-4">
                                          <span>
                                             <select class="selectpicker">
                                                <option value="0">MM</option>
                                                <option value="1">01</option>
                                                <option value="2">02</option>
                                                <option value="3">03</option>
                                             </select>
                                          </span>
                                       </div>
                                       <div class="col-sm-4">
                                          <span>
                                             <select class="selectpicker">
                                                <option value="0">YY</option>
                                                <option value="1">2016</option>
                                                <option value="2">2017</option>
                                                <option value="3">2018</option>
                                             </select>
                                          </span>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <div class="card_inputs add_fund amount">
                                 <span class="fund_icon"> Amount</span>
                                 <input class="form-control txt_color" type="text" placeholder=" $0.00" />
                              </div>
                              <div class="bttn_outer">
                                 <button class="fund_btn" type="submit">
                                 Add Funds
                                 </button>
                              </div>
                           </form>
                        </div>
                     </div>
                     <div id="payfour" class="tab-pane fade">
                        Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                     </div>
                  </div>
               </div>
               <!--            <div class="modal-footer popup-footer">-->
               <!--             <div class="sign-up-tips">-->
               <!--               <span>Don't have an account?</span>-->
               <a href="#" data-dismiss="modal" aria-label="Close" class="close popup-close"></a>
               <!--          </div>-->
               <!--      </div>-->
            </div>
         </div>
      </div>
   </div>
</div>
   <!--Review Section starts here-->
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
      <div class="event_left sam_height">
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
      <div id="calendardivid" class="event_right sam_height">
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
            <div class="artist_hedr request">
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
                              $control_attrAr['title']="Country";
                              $country_name='';
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
               $statelist='';
                              $control_attrAr=array();
                $fetchstatelistdata=array();
                              $control_attrAr['id']='statelist';
                              $control_attrAr['class']="selectpicker artist_txt";
                              $control_attrAr['title']="State";
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
                "placeholder"=>"Zip"
                
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
                              $control_attrAr['title']="Category for Request";
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
                              $control_attrAr['title']="Genre for Request";
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
                              <!--<input type='text' class="form-control clck_outr lck_outr" placeholder="$0.00" />-->
                              <?php
                                 echo Form::text("security_payment",
                                 $value='$'.$security_figure,
                                 $attributes = array( "id"=>"security_payment",
                                 "class"=>"form-control clck_outr lck_outr",
                                 "placeholder"=>"$0.00",
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
                              <?php    
                                 echo Form::text("total_payment",
                                 $value='',
                                 $attributes = array( "id"=>"total_payment",
                                 "class"=>"form-control clck_outr lck_outr",
                                 "placeholder"=>"$0.00",
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
                              <?php
                                 echo Form::text("cancellation_payment",
                                 $value='',
                                 $attributes = array( "id"=>"cancellation_payment",
                                 "class"=>"form-control date_outr lck_outr",
                                 "placeholder"=>"$0.00",
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
                     <div class="inline artist_list">
                        <!--                      <span>Tech Specs</span>-->
                        <div class="form-group inpt nb"><!--please assit artist(s) by describing any venue specifics such as: 
                           parking areas,access times or areas,set up times, back stage areas,stage size,
                           on-site contact person details, lift access or any other technical requirements or 
                           concerns in this area here.--><?php echo $tech_speech;?>
                        </div>
                        <!--                       <p> 5 lines, 50 characters maximum per line</p>-->
                     </div>
                  </div>
                  <div class="col-md-12">
                      <input type="hidden" name="artistID" value="{{$artist_own_id}}" id="artistID" >
                     <button class="btn btn-warning artist_btn reqst_btn" id="cancelbtn" data-dismiss="modal">cancel</button>
                     <button class="btn btn-warning artist_btn rqst_trm_btn" id="continue" type="button">agree to terms </button>
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

<!--book artist modal ends here-->
<script>
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
   
   if (l_currency == P_currency) {
		 $('#myModal5').modal('toggle');
		 $('#myModal5').modal('show');
	  }else{
		 toastr.remove();// Immediately remove current toasts without using animation
		 poptriggerfunc(msgtype='error',titledata='',msgdata="Currency mismatch",sd=1000,hd=1500,tmo=null,etmo=null,poscls='toast-bottom-right');
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

  <script type="text/javascript" src="{{ FRONTCSSPATH}}/otherfiles/progjs/frontendpublicprofilegig.js"></script> 

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
   var maxLength = $("#total_payment").attr('maxlength');
   if($("#total_payment").val().length == maxLength)
   {
   	$("#total_payment").next().focus();
   }
   //$("#security_payment").next().focus();
   //********masaking length for total payment attribute
   var maxLength2 = $("#cancellation_payment").attr('maxlength');
   if($("#cancellation_payment").val().length == maxLength2)
   {
   	$("#cancellation_payment").next().focus();
   }
   //$("#security_payment").next().focus();
   //********masaking length for total payment attribute
   var maxLength3 = $("#security_payment").attr('maxlength');
   if($("#security_payment").val().length == maxLength3)
   {
   	$("#security_payment").next().focus();
   }
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
	
	  $('#total_payment').maskMoney({prefix:'$'}); //******masking for total payment
	  $('#cancellation_payment').maskMoney({prefix:'$'});//******masking for cancellation payment
	  $('#security_payment').maskMoney({prefix:'$'});//*******masking for security payemnt
	  
	  
	  
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
			   $("#continue").click(function(){
				  //alert('hello');
          if($('#sfsdfsdffd').css('display') == 'none')
                  {
                  $("#clickme").trigger('click');
                  }
				  callforbooking("bookingconfirmartist",csrf);
				  return false;
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
  replysesponse = "You must be logged in to continue"
  if(j == 2)
  replysesponse = "Your request can not be processed"

  //alert(replysesponse);
  poptriggerfunc(msgtype='error',titledata='',msgdata=replysesponse,sd=6000,hd=1500,tmo=3000,etmo=4000,poscls='toast-bottom-right');

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
@endsection