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
   
   
   $first_name=''; $facebook_url=''; $twitter_url='';
   $instagram_url='';	$youtube_url='';	$residentadvisor_url='';
   $tech_speech = '';
   $user_description=''; $soundcloud_url='';$performence=0;$puntuality=0;$roundofpuntulity=0;$roundofperformence=0;
   $roundofpresentation=0;
   $rider_data = '';

   $fetchskillmasterArData=array();
	
   $fetchcountrydata = array();
   $fetchbookingcatData = array();
   $fetchimgData = array();
   if(!empty($fetchuserdata))
   {
   $creater_id = $fetchuserdata->creater_id;
   $front_id_sess= session('front_id_sess');
   
   	$groupId = $fetchuserdata->id;
	$rate_amount = $fetchuserdata->rate_amount;
	$submitBtbFlag = 1;
	if($rate_amount =='0.00'){
	$submitBtbFlag = 0;
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

  ?>
  
  	   <?php
$flagBkGrp = Request::segment(3);
//$flagBkGrp = (empty($flagBkGrp)==true)?0:1;
if($flagBkGrp!='' && $flagBkGrp=='bk'){
$flagBkGrp='1';
}


?>
@extends('layouts.front.frontendmaster',['successmsg' => $successmsg,'errormsg'=>$errormsg])
@section('content')
<!-- profile-section-start -->
<section class="profile_outer">
   <div class="container">
      <div class="row dj_row">
         <div class="col-sm-5">
            <div class="profile_slider">
             
				 <?php
				  $imgurldata = asset("front/otherfiles/progimages/"."noimagefound537X507.png");
               // $fetchimgDat2a = array();
                if(!empty($fetchimgData))
                {
                    foreach($fetchimgData as $fetchimgData)
                    {
                     $imgurl = asset('upload/groupimage/thumb-big/'.$fetchimgData->image_name);
                        ?>
                          <div class="item" style="background-image: url({{ $imgurl}});">
                          </div>
                <?php
                }
            }else
                {
                     $imgurldata = asset("front/otherfiles/progimages/"."noimagefound537X507.png");?>
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
						<a href="profile.html#review" class="add_link red-tooltip goTo" data-go-to="review_section" data-toggle="tooltip" title="Review"><img src="{{ URL::asset('public/front')}}/images/plus_icon.png" alt="" /></a>
                        
						<a href="#" class="like_link red-tooltip goTo" data-go-to="Favorite_section"  data-toggle="tooltip" title="Favorite"><img src="{{ URL::asset('public/front')}}/images/heart_icon.png" alt="" /></a>
                        
						<a href="profile.html#calendr" class="red-tooltip goTo" data-go-to="Calender_section" data-toggle="tooltip" title="Calender"><img src="{{ URL::asset('public/front')}}/images/calender_icon.png" alt="" /></a>
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
                  <li>
                     <a href="{{$facebook_url}}" target="_blank">
                     <span class="icon_social" style="background: #3b5998;"><img src="{{ URL::asset('public/front')}}/images/fb_icon.png" alt="" /></span>
                     facebook
                     </a>
                  </li>
                  <li>
                     <a href="{{$soundcloud_url}}" target="_blank">
                     <span class="icon_social" style="background: #ff7e30;"><img src="{{ URL::asset('public/front')}}/images/cloud_icon.png" alt="" /></span>
                     Soundcloud
                     </a>
                  </li>
                  <li>
                     <a href="{{$residentadvisor_url}}" target="_blank">
                     <span class="icon_social" style="background: #ffff00;"><img src="{{ URL::asset('public/front')}}/images/advisor_icon.png" alt="" /></span>
                     Resident Advisor
                     </a>
                  </li>
                  <li>
                     <a href="{{$twitter_url}}" target="_blank">
                     <span class="icon_social" style="background: #00aced;"><img src="{{ URL::asset('public/front')}}/images/tweeter_icon.png" alt="" /></span>
                     Twitter
                     </a>
                  </li>
                  <li>
                     <a href="{{$youtube_url}}" target="_blank">
                     <span class="icon_social" style="background: #e32b21;"><img src="{{ URL::asset('public/front')}}/images/youtube_icon.png" alt="" /></span>
                     YouTube
                     </a>
                  </li>
                  <li>
                     <a href="{{$instagram_url}}">
                     <span class="icon_social" style="background: #2e5e84;"><img src="{{ URL::asset('public/front')}}/images/instagram_icon.png" alt="" /></span>
                     Instagram
                     </a>
                  </li>
               </ul>
               <div class="col-sm-6 visitor_cols">
                  <div class="btn_row">
<!--                     <a href="#" class="book_btn openbkgrpcls openmodal" data-toggle="modal" data-target="#myModal5">book group</a>-->
			   <?php
			   if($creater_id == $front_id_sess || $submitBtbFlag == '0'){
			   ?>
			   <a href="#" class="book_btn openbkgrpcls openmodal" data-toggle="modal">book group</a>
			   <?php
			   }else if($front_id_sess==''){
			   ?>
			   <a href="#" class="book_btn openbkgrpcls openmodal" data-toggle="modal">book group</a>
			   <?php
			   }
			   else{
			   ?>
			   <a href="#" class="book_btn openbkgrpcls openmodal" data-toggle="modal" data-target="#myModal5">book group</a>
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
							echo link_to('#', $title = 'press kit', $attributes = array("class"=>"book_btn press_btn"), $secure = null);
						}

					 ?>
                  </div>
                  <div class="btn_row">
                     <!-- <a href="#" class="book_btn rider_btn">menu</a> -->
                     <a href="#" class="book_btn rider_btn"><?php
					 if(!empty($rider_data)){
					 echo $rider_data;
					 }else{
					 echo "Menu";
					 }
					 ?></a>
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
								<span><img src="{{ URL::asset('public/front')}}/images/star_icon.png" alt="" /></span>
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
								 <span><img src="{{ URL::asset('public/front')}}/images/star_icon.png" alt="" /></span>
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
                                <span><img src="{{ URL::asset('public/front')}}/images/star_icon.png" alt="" /></span>
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
                              <Span><img src="{{ URL::asset('public/front')}}/images/c1.png" alt=""> </Span> 
                              <Span><img src="{{ URL::asset('public/front')}}/images/c2.png" alt=""> </Span> 
                              <Span><img src="{{ URL::asset('public/front')}}/images/c3.png" alt=""> </Span> 
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
<section class="profile_outer event_section" id="Calender_section">
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
            <div class="select_cont location_select">
               <?php
                  $control_attrAr=array();
                  $control_attrAr['id']='loc_sub';
                  $control_attrAr['class']=" selectpicker ";
                  $control_attrAr['title']="Location";
                  
                  $loc_sub='';
                  $fetchlocationsubData=array('a'=>'Location1','b'=>'Location2');
                  echo Form::select('skill_sub', $fetchlocationsubData, $loc_sub,$control_attrAr);							
                  ?>
            </div>
            <div class="select_cont search_select">
               <?php
                  $control_attrAr=array();
                  $control_attrAr['id']='genre_sub';
                  $control_attrAr['class']=" selectpicker";
                  $control_attrAr['title']="Genre";
                  
                  $genre_sub='';
                  $fetchgenresubData=array('1'=>'Genre 01','2'=>'Genre 02');
                  echo Form::select('genre_sub', $fetchgenresubData, $genre_sub,$control_attrAr);							
                  ?>
            </div>
            <div class="month_input">
               <?php echo Form::text("month_text", $value='', $attributes = array( "id"=>"","placeholder"=>"Month")); ?>
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
      <div class="event_right sam_height">
         <img src="{{ URL::asset('public/front')}}/images/calender_img.png" alt="" />
      </div>
   </div>
</section>
   <!--Review Section starts here-->
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
			<div class="prodile_img"><img alt="" src="{{ URL::asset('')}}/upload/userimage/thumb-small/{{$userreview->image_name}}"></div>
			<?php
			}else{
			?>
			<div class="prodile_img"><img alt="" src="{{ URL::asset('public/front')}}/otherfiles/progimages/noimagefound52X52.jpg"></div>
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
                       <img src="{{ URL::asset('public/front')}}/images/calender_icon.png" alt="" /> 
                       <?php 
         
                             $review_date =$userreview->agv_review_date;
                             echo   date('j F, Y',strtotime($review_date));
                       ?>
                        </li>
                 <li>
                     <?php 
         
                             $review_time =$userreview->agv_review_date;
                             echo   date('g.ia',strtotime($review_time));
                       ?>
                      
                          <span class="star_feed">
                             <?php 
                      
                              for($i=0;$i<$points;$i++)
                              {
                              ?> 
                              <img src="{{ URL::asset('public/front')}}/images/yellow_star.png" alt="" /> 

                     <?php
                              }
                              ?>
                        </span>
                </li>
        </ul>
              <div class="form_right">
         <img src="{{ URL::asset('public/front')}}/images/location_icon.png" alt="" />
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
         <!--<div class="col-sm-6 review_cols">-->
         <!--   <div class="review_cell clearfix">-->
         <!--      <div class="review_img_cell">-->
         <!--         <div class="prodile_img"><img alt="" src="{{ URL::asset('public/front')}}/images/profile_img.jpg"></div>-->
         <!--         Zainab-->
         <!--      </div>-->
         <!--      <div class="review_cont_cell">-->
         <!--         <p>-->
         <!--            Quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut-->
         <!--         </p>-->
         <!--         <div class="clearfix">-->
         <!--            <ul class="review_date">-->
         <!--               <li>-->
         <!--                  <img src="{{ URL::asset('public/front')}}/images/calender_icon.png" alt="" />30 January, 2014-->
         <!--               </li>-->
         <!--               <li>-->
         <!--                  3.30 pm-->
         <!--                  <span class="star_feed"><img src="{{ URL::asset('public/front')}}/images/yellow_star.png" alt="" /> <img src="{{ URL::asset('public/front')}}/images/yellow_star.png" alt="" /> <img src="{{ URL::asset('public/front')}}/images/yellow_star.png" alt="" /> <img src="{{ URL::asset('public/front')}}/images/yellow_star.png" alt="" /></span>-->
         <!--               </li>-->
         <!--            </ul>-->
         <!--            <div class="form_right">-->
         <!--               <img src="{{ URL::asset('public/front')}}/images/location_icon.png" alt="" />-->
         <!--               From Mumbai-->
         <!--            </div>-->
         <!--         </div>-->
         <!--      </div>-->
         <!--   </div>-->
         <!--</div>-->
         <!--<div class="col-sm-6 review_cols">-->
         <!--   <div class="review_cell clearfix">-->
         <!--      <div class="review_img_cell">-->
         <!--         <div class="prodile_img"><img alt="" src="{{ URL::asset('public/front')}}/images/profile_img.jpg"></div>-->
         <!--         Zainab-->
         <!--      </div>-->
         <!--      <div class="review_cont_cell">-->
         <!--         <p>-->
         <!--            Quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut-->
         <!--         </p>-->
         <!--         <div class="clearfix">-->
         <!--            <ul class="review_date">-->
         <!--               <li>-->
         <!--                  <img src="{{ URL::asset('public/front')}}/images/calender_icon.png" alt="" />30 January, 2014-->
         <!--               </li>-->
         <!--               <li>-->
         <!--                  3.30 pm-->
         <!--                  <span class="star_feed"><img src="{{ URL::asset('public/front')}}/images/yellow_star.png" alt="" /> <img src="{{ URL::asset('public/front')}}/images/yellow_star.png" alt="" /> <img src="{{ URL::asset('public/front')}}/images/yellow_star.png" alt="" /> <img src="{{ URL::asset('public/front')}}/images/yellow_star.png" alt="" /></span>-->
         <!--               </li>-->
         <!--            </ul>-->
         <!--            <div class="form_right">-->
         <!--               <img src="{{ URL::asset('public/front')}}/images/location_icon.png" alt="" />-->
         <!--               From Mumbai-->
         <!--            </div>-->
         <!--         </div>-->
         <!--      </div>-->
         <!--   </div>-->
         <!--</div>-->
         <!--<div class="col-sm-6 review_cols">-->
         <!--   <div class="review_cell clearfix">-->
         <!--      <div class="review_img_cell">-->
         <!--         <div class="prodile_img"><img alt="" src="{{ URL::asset('public/front')}}/images/profile_img.jpg"></div>-->
         <!--         Zainab-->
         <!--      </div>-->
         <!--      <div class="review_cont_cell">-->
         <!--         <p>-->
         <!--            Quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut-->
         <!--         </p>-->
         <!--         <div class="clearfix">-->
         <!--            <ul class="review_date">-->
         <!--               <li>-->
         <!--                  <img src="{{ URL::asset('public/front')}}/images/calender_icon.png" alt="" />30 January, 2014-->
         <!--               </li>-->
         <!--               <li>-->
         <!--                  3.30 pm-->
         <!--                  <span class="star_feed"><img src="{{ URL::asset('public/front')}}/images/yellow_star.png" alt="" /> <img src="{{ URL::asset('public/front')}}/images/yellow_star.png" alt="" /> <img src="{{ URL::asset('public/front')}}/images/yellow_star.png" alt="" /> <img src="{{ URL::asset('public/front')}}/images/yellow_star.png" alt="" /></span>-->
         <!--               </li>-->
         <!--            </ul>-->
         <!--            <div class="form_right">-->
         <!--               <img src="{{ URL::asset('public/front')}}/images/location_icon.png" alt="" />-->
         <!--               From Mumbai-->
         <!--            </div>-->
         <!--         </div>-->
         <!--      </div>-->
         <!--   </div>-->
         <!--</div>-->
         <!--<div class="col-sm-6 review_cols">-->
         <!--   <div class="review_cell clearfix">-->
         <!--      <div class="review_img_cell">-->
         <!--         <div class="prodile_img"><img alt="" src="{{ URL::asset('public/front')}}/images/profile_img.jpg"></div>-->
         <!--         Zainab-->
         <!--      </div>-->
         <!--      <div class="review_cont_cell">-->
         <!--         <p>-->
         <!--            Quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut-->
         <!--         </p>-->
         <!--         <div class="clearfix">-->
         <!--            <ul class="review_date">-->
         <!--               <li>-->
         <!--                  <img src="{{ URL::asset('public/front')}}/images/calender_icon.png" alt="" />30 January, 2014-->
         <!--               </li>-->
         <!--               <li>-->
         <!--                  3.30 pm-->
         <!--                  <span class="star_feed"><img src="{{ URL::asset('public/front')}}/images/yellow_star.png" alt="" /> <img src="{{ URL::asset('public/front')}}/images/yellow_star.png" alt="" /> <img src="{{ URL::asset('public/front')}}/images/yellow_star.png" alt="" /> <img src="{{ URL::asset('public/front')}}/images/yellow_star.png" alt="" /></span>-->
         <!--               </li>-->
         <!--            </ul>-->
         <!--            <div class="form_right">-->
         <!--               <img src="{{ URL::asset('public/front')}}/images/location_icon.png" alt="" />-->
         <!--               From Mumbai-->
         <!--            </div>-->
         <!--         </div>-->
         <!--      </div>-->
         <!--   </div>-->
         <!--</div>-->
         <!--<div class="col-sm-6 review_cols">-->
         <!--   <div class="review_cell clearfix">-->
         <!--      <div class="review_img_cell">-->
         <!--         <div class="prodile_img"><img alt="" src="{{ URL::asset('public/front')}}/images/profile_img.jpg"></div>-->
         <!--         Zainab-->
         <!--      </div>-->
         <!--      <div class="review_cont_cell">-->
         <!--         <p>-->
         <!--            Quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut-->
         <!--         </p>-->
         <!--         <div class="clearfix">-->
         <!--            <ul class="review_date">-->
         <!--               <li>-->
         <!--                  <img src="{{ URL::asset('public/front')}}/images/calender_icon.png" alt="" />30 January, 2014-->
         <!--               </li>-->
         <!--               <li>-->
         <!--                  3.30 pm-->
         <!--                  <span class="star_feed"><img src="{{ URL::asset('public/front')}}/images/yellow_star.png" alt="" /> <img src="{{ URL::asset('public/front')}}/images/yellow_star.png" alt="" /> <img src="{{ URL::asset('public/front')}}/images/yellow_star.png" alt="" /> <img src="{{ URL::asset('public/front')}}/images/yellow_star.png" alt="" /></span>-->
         <!--               </li>-->
         <!--            </ul>-->
         <!--            <div class="form_right">-->
         <!--               <img src="{{ URL::asset('public/front')}}/images/location_icon.png" alt="" />-->
         <!--               From Mumbai-->
         <!--            </div>-->
         <!--         </div>-->
         <!--      </div>-->
         <!--   </div>-->
         <!--</div>-->
         <!--<div class="col-sm-6 review_cols">-->
         <!--   <div class="review_cell clearfix">-->
         <!--      <div class="review_img_cell">-->
         <!--         <div class="prodile_img"><img alt="" src="{{ URL::asset('public/front')}}/images/profile_img.jpg"></div>-->
         <!--         Zainab-->
         <!--      </div>-->
         <!--      <div class="review_cont_cell">-->
         <!--         <p>-->
         <!--            Quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut-->
         <!--         </p>-->
         <!--         <div class="clearfix">-->
         <!--            <ul class="review_date">-->
         <!--               <li>-->
         <!--                  <img src="{{ URL::asset('public/front')}}/images/calender_icon.png" alt="" />30 January, 2014-->
         <!--               </li>-->
         <!--               <li>-->
         <!--                  3.30 pm-->
         <!--                  <span class="star_feed"><img src="{{ URL::asset('public/front')}}/images/yellow_star.png" alt="" /> <img src="{{ URL::asset('public/front')}}/images/yellow_star.png" alt="" /> <img src="{{ URL::asset('public/front')}}/images/yellow_star.png" alt="" /> <img src="{{ URL::asset('public/front')}}/images/yellow_star.png" alt="" /></span>-->
         <!--               </li>-->
         <!--            </ul>-->
         <!--            <div class="form_right">-->
         <!--               <img src="{{ URL::asset('public/front')}}/images/location_icon.png" alt="" />-->
         <!--               From Mumbai-->
         <!--            </div>-->
         <!--         </div>-->
         <!--      </div>-->
         <!--   </div>-->
         <!--</div>-->
      </div>
   </div>
</section>
    <!--Review Section ends here-->
<!-- profile-section-end -->

<!--book group modal start here 24-06-->

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
						   $fetchcountryArData[]="Select country";
						   if(!empty($country)){
						   foreach($country as $countryAll){
							   $fetchcountryArData[$countryAll->id]=$countryAll->country_name;
						   }
						   }
						   //if($userdetails->country!=''){
						   //$country = $userdetails->country;
						   //}else{
						   $country='';	
						   //}						
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
								 $control_attrAr['title']="Select state";
								 
								 //if($userdetails->state!=''){
								 //$select_state=$userdetails->state;
								 //}else{
								 $select_state='';
								 //}
								 $fetchstateData=array();
								 //if(!empty($state)){
								 //	 foreach($state as $stateAll){
								 //		 $fetchstateData[$stateAll->id]=$stateAll->state_name;
								 //	 }
								 //}
								 
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
								<?php echo Form::text("zip", $value="", $attributes = array( "id"=>"zip","placeholder"=>"ZIP","class"=>"form-control form-control-B")); ?>
                            </div>
                        </div>
                    </div>
                    
                    <a class="closeLoc" href="javascript:void(0);"></a>
                    
                </div>
                  <!--------------------------For Town and Zip ends here------------------------------->
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
                              <!--<input type='text' class="form-control clck_outr lck_outr" placeholder="$0.00" />-->
                              <?php
                                 echo Form::text("security_payment",
                                 $value='',
                                 $attributes = array( "id"=>"security_payment",
                                 "class"=>"form-control clck_outr lck_outr",
                                 "placeholder"=>"$0.00",
                                 "maxlength"=>"16"
                                 
                                 ));
                                 ?>
                              <span class="input-group-addon clck">
                              <span class="glyphicon lck"><img src="{{ URL::asset('public/front')}}/images/lock2.png" alt=""/></span>
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
                              <span class="input-group-addon clck">
                              <span class="glyphicon lck"><img src="{{ URL::asset('public/front')}}/images/lock.png" alt=""/></span>
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
                              <span class="input-group-addon dt clck">
                              <span class="glyphicon lck"><img src="{{ URL::asset('public/front')}}/images/lock2.png" alt=""/></span>
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
                     <div class="inline artist_list">
                        <!--                      <span>Tech Specs</span>-->
                        <div class="form-group inpt nb">please assit artist(s) by describing any venue specifics such as: 
                           parking areas,access times or areas,set up times, back stage areas,stage size,
                           on-site contact person details, lift access or any other technical requirements or 
                           concerns in this area here
                        </div>
                        <!--                       <p> 5 lines, 50 characters maximum per line</p>-->
                     </div>
                  </div>
                  <div class="col-md-12">
                     <button class="btn btn-warning artist_btn reqst_btn" id="cancelbtn" data-dismiss="modal">cancel</button>
                     <button class="btn btn-warning artist_btn rqst_trm_btn"  type="button" id="venuebookingsubmit">agree to terms </button>
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



<script>
   $(document).ready(function(){
     //  $('[data-toggle="tooltip"]').tooltip();   
   });
</script>
<script>
   $(document).ready(function(){
   
   	
   	$('#total_payment').maskMoney({prefix:'$'}); //******masking for total payment
   	$('#cancellation_payment').maskMoney({prefix:'$'});//******masking for cancellation payment
   	$('#security_payment').maskMoney({prefix:'$'});//*******masking for security payemnt
   	
   });
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
						jQuery("#venuebookingsubmit").click(function(){
						
						if($('#opnaddresssection').css('display') == 'none')
						{
						$("#clickme").trigger('click');
						}
						
						
									var csrf = "<?php echo csrf_token(); ?>";
									
									   var pj = callforbooking("groupprofilesubmit",csrf);
									
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
   				$('#booking_date').datetimepicker({
   				format: 'DD/MM/YYYY',
   				minDate:datecur
   				});
   				$('#requestexpireddate').datetimepicker({
   				format: 'DD/MM/YYYY',
   				minDate:datecur2
   				
   				});
   					
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
   var groupId = "<?php echo $groupId;?>";
   var gig_type = '2';
   var event_type_entry = "<?php echo $available_for ?>";
   var creater_id = "<?php echo $creater_id;?>";
   var submitBtbFlag = "<?php echo $submitBtbFlag;?>";
</script>
   <script type="text/javascript" src="{{ URL::asset('public/front')}}/otherfiles/progjs/frontendpublicgroup.js"></script>
   <script type="text/javascript" src="{{ URL::asset('public/front')}}/otherfiles/progjs/jquery.maskMoney.js"></script>
<!--   <script type="text/javascript" src="{{ URL::asset('public/front')}}/otherfiles/progjs/frontendcommon.js"></script>   -->
@endsection