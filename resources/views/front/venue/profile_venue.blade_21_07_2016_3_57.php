
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
$first_name=''; $facebook_url=''; $twitter_url='';
$instagram_url='';	$youtube_url='';	$residentadvisor_url='';
$tech_speech = 'No Tech Specs Provided';
$venue_creatr_id =0;
$venue_own_id ='';
 $user_description=''; $soundcloud_url='';$performence=0;$puntuality=0;$presentation=0;$roundofpuntulity=0;$roundofperformence=0;
$roundofpresentation=0;
$venue_name='';
$venue_descp='Content Not Available';
$venue_lat='25.2744';$venue_long='133.7751';

$venue_status = 0;
$available_for = 3;
$security_figure = 0.00;
$opening_time = '';
$closing_time = '';

    $fetchskillmasterArData=array();
	
	$fetchcountrydata = array();
	$fetchbookingcatData = array();
   $fetchimgData = array();
   
   $fetchbookingskillcategory =array();
   
   if(!empty($fetchuserdata))
   {

	if($fetchuserdata->status)
	$venue_status=$fetchuserdata->status;

	if($fetchuserdata->creater_id)
	$venue_creatr_id=$fetchuserdata->creater_id;



	if($fetchuserdata->id)
	$venue_own_id=$fetchuserdata->id;


	if($fetchuserdata->nickname)
	$venue_name=$fetchuserdata->nickname;
	if($fetchuserdata->venue_description)
	$venue_descp = $fetchuserdata->venue_description;

	if($fetchuserdata->venue_lat)
	$venue_lat = $fetchuserdata->venue_lat;
	if($fetchuserdata->venue_long)
	$venue_long = $fetchuserdata->venue_long;



	if($fetchuserdata->tech_spec)
	$tech_speech = $fetchuserdata->tech_spec;


	if($fetchuserdata->available_for)
	$available_for = $fetchuserdata->available_for;

	if($fetchuserdata->security_figure)
	$security_figure = $fetchuserdata->security_figure;


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

?>

@extends('layouts.front.frontendmaster',['successmsg' => $successmsg,'errormsg'=>$errormsg])
@section('content')

	<!-- profile-section-start -->
	<section class="profile_outer">
		<div class="container">
			<div class="row dj_row">
				<div class="col-sm-5">
					<div class="profile_slider myvenuesliderouterdv">
					
					
					 <?php
				      $imgurldata = asset("front/otherfiles/progimages/"."noimagefound537X507.png");
					  if(!empty($fetchimgData))
					  {

					  foreach($fetchimgData as $fetchimgData)
					  {
					  $imgurl = asset('upload/venueimage/thumb-big/'.$fetchimgData->image_name);
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
					<h2 class="prifile_heading">{{stripslashes($venue_name)}}</h2>
					<!-- hidden latitude and hidden longitude -->
					<!-- <input type="number" class="mydisplaynone" id="hiddentlat" value="-33"><input type="number" class="mydisplaynone" id="hiddentlong" value="151"> -->


					<div class="like_box">
						<a href="profile.html#review" class="add_link red-tooltip goTo" data-go-to="review_section" data-toggle="tooltip" title="Review"><img src="{{ URL::asset('public/front')}}/images/plus_icon.png" alt="" /></a>
                        
						<a href="#" class="like_link red-tooltip goTo" data-go-to="Favorite_section"  data-toggle="tooltip" title="Favorite"><img src="{{ URL::asset('public/front')}}/images/heart_icon.png" alt="" /></a>
                        
						<a href="profile.html#calendr" class="red-tooltip goTo" data-go-to="Calender_section" data-toggle="tooltip" title="Calender"><img src="{{ URL::asset('public/front')}}/images/calender_icon.png" alt="" /></a>
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
							<li>
								<a href="https://www.facebook.com/" target="_blank">
									<span class="icon_social" style="background: #3b5998;"><img src="{{ URL::asset('public/front')}}/images/fb_icon.png" alt="" /></span>
									facebook
									<!--<span class="add_icon"> </span>-->
								</a>
							</li>
							<li>
								<a href="http://www.soundcloud.com/" target="_blank">
									<span class="icon_social" style="background: #ff7e30;"><img src="{{ URL::asset('public/front')}}/images/cloud_icon.png" alt="" /></span>
									Soundcloud
									<!--<span class="add_icon"> </span>-->
								</a>
							</li>
							<li>
								<a href="https://www.residentadvisor.net/" target="_blank">
									<span class="icon_social" style="background: #ffff00;"><img src="{{ URL::asset('public/front')}}/images/advisor_icon.png" alt="" /></span>
									Resident Advisor
									<!--<span class="add_icon"> </span>-->
								</a>
							</li>
							<li>
								<a href="https://twitter.com/" target="_blank">
									<span class="icon_social" style="background: #00aced;"><img src="{{ URL::asset('public/front')}}/images/tweeter_icon.png" alt="" /></span>
									Twitter
									<!--<span class="add_icon"> </span>-->
								</a>
							</li>
							<li>
								<a href="https://www.youtube.com/" target="_blank">
									<span class="icon_social" style="background: #e32b21;"><img src="{{ URL::asset('public/front')}}/images/youtube_icon.png" alt="" /></span>
									YouTube
									<!--<span class="add_icon"> </span>-->
								</a>
							</li>
							<li>
								<a href="https://www.instagram.com/">
									<span class="icon_social" style="background: #2e5e84;"><img src="{{ URL::asset('public/front')}}/images/instagram_icon.png" alt="" /></span>
									Instagram
									<!--<span class="add_icon"> </span>-->
								</a>
							</li>
						</ul>
						<div class="col-sm-6 visitor_cols">
							<div class="btn_row">
							<?php
							if($sessn_ID =='')
							{ ?>

								<a href="#" class="book_btn bk_venue openbkgrpcls" onclick="checkvenuebookingavailability(1);">book venue</a>
							<?php 
						    } else
							{
								if($sessn_ID == $venue_creatr_id)
								{ ?>
									<a href="#" class="book_btn bk_venue openbkgrpcls" onclick="checkvenuebookingavailability(2);">book venue</a>
							<?php	}
								else
								{
									if($venue_status == 1){
									?>
									<a href="#" class="book_btn bk_venue openbkgrpcls" data-toggle="modal" data-target="#myModal5">book venue</a>
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
                          echo link_to('#', $title = 'press kit', $attributes = array("class"=>"book_btn press_btn"), $secure = null);
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
									echo link_to('#', $title = 'menu', $attributes = array("class"=>"book_btn rider_btn mnu_venuebook_btn press_btn"), $secure = null);
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
                                <span><img src="{{ URL::asset('public/front')}}/images/star_icon.png" alt="" /></span>
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
                                <span><img src="{{ URL::asset('public/front')}}/images/star_icon.png" alt="" /></span>
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
                                <span><img src="{{ URL::asset('public/front')}}/images/star_icon.png" alt="" /></span>
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
					
					 <img src="{{ URL::asset('/')}}/upload/amenities-image/source-file/{{$amenityimg_data->amenity_img}}" alt="" />
					
					</a>
					</div>
					<?php
					}
				  }
				  
				  ?>
				 

			</div>
                </div>
                 <div class="prf_venue_map" id="map" style="height:500px;width:650px">
                   
                 </div>
             </div>
            </div>
<!--            <p class="prf_venue_lst">-->
<!--			Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim quam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, quam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam,ncidunt ut Nemo enim quam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa.</p>-->

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
		                    <h3 class="pay_hed">Pay using Credit Card.
                                <div class="credt_crd">
		                        <Span><img src="images/c1.png" alt=""> </Span> 
		                        <Span><img src="images/c2.png" alt=""> </Span> 
		                        <Span><img src="images/c3.png" alt=""> </Span> 
<!--
		                        <Span><img src="images/c4.png" alt=""> </Span> 
		                        <Span><img src="images/c5.png" alt=""> </Span> 
-->
                                </div>
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
		                            <input class="form-control txt_color" type="text" placeholder=" $ 0.0 0" />
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
					<!-- <div class="select_cont location_select">
						<select class="selectpicker">
							<option>Location</option>
							<option>Location 01</option>
							<option>Location 02</option>
						</select>
					</div> -->
					<div class="select_cont search_select">
								<?php
								$control_attrAr=array();
								$control_attrAr['id']='category_sub';
								$control_attrAr['class']=" selectpicker";
								$control_attrAr['title']="Category";

								$category_sub='';
								$fetchcategorysubData=array('1'=>'Category 01','2'=>'Category 02');
								echo Form::select('category_sub', $fetchcategorysubData, $category_sub,$control_attrAr);             
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
					<!-- <div class="month_input">
						<input type="text" placeholder="Month" />
					</div> -->
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
            <div class="prodile_img"><img alt="" src="{{ URL::asset('public/front')}}/otherfiles/progimages/noimagefound52X52.jpg"></div>
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


			</div>
		</div>
	</section>	

<!-- Modal -->

<!-- Modal -->

<!--	post a gig -->
      
   
   
   


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
                              $control_attrAr['title']="Category for Request";
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
                                 $value='$'.$security_figure,
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
                        <div class="form-group inpt nb"><!-- please assit artist(s) by describing any venue specifics such as: 
                           parking areas,access times or areas,set up times, back stage areas,stage size,
                           on-site contact person details, lift access or any other technical requirements or 
                           concerns in this area here -->

                           {{$tech_speech}}
                        </div>
                        <!--                       <p> 5 lines, 50 characters maximum per line</p>-->
                     </div>
                  </div>
                  <div class="col-md-12">
				  <input type="hidden" name="venueID" value="{{$venue_own_id}}" id="venueID" >
                     <button class="btn btn-warning artist_btn reqst_btn" id="cancelbtn" data-dismiss="modal">cancel</button>
                     <button class="btn btn-warning artist_btn rqst_trm_btn"  type="button"  id="venuebookingsubmit">agree to terms </button>
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

			   
			$('#total_payment').maskMoney({prefix:'$'}); //******masking for total payment
			$('#cancellation_payment').maskMoney({prefix:'$'});//******masking for cancellation payment
			$('#security_payment').maskMoney({prefix:'$'});//*******masking for security payemnt
			
			
			
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
		   $('#venuebookingsubmit').unbind('click');
		  }else
		  {
			  $('#venuebookingsubmit').bind('click');
		  }


 		  
 		 // alert(event_type_entry);
//$message = 'Hello '.($user->get('first_name') ?: 'Guest');
		  var hidnlt = <?php echo $ltlt = $fetchuserdata->venue_lat ?: '0.000000' ;?>;
		  var hdnlng = <?php echo $lltng = $fetchuserdata->venue_long ?: '0.000000' ;?>;
//console.log("hidnlt"+hidnlt);
		google.maps.event.addDomListener(window, 'load', initialize(hidnlt,hdnlng));
		
	  });
	  
	  //*********************function for form validation==============*******in frontendpublicprofile.js page
									jQuery("#venuebookingsubmit").click(function(){
									//***check if díplay none
									if($('#sfsdfsdffd').css('display') == 'none')
									{
									$("#clickme").trigger('click');
									}
									
									
									var csrf = "<?php echo csrf_token(); ?>";
									
									   var pj = callforbookingvenue("fsdfsdf",csrf);
									
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
				var event_type_entry = "<?php echo $available_for ?>";
				var opening_time =  "<?php echo $opening_time ?>";
				var closing_time =  "<?php echo $closing_time ?>";
   </script>
	
	<!--This is a script for map starts-->
	<!--  <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDMtfReOBcDyXEUBByLlLgjOkwMKKJw86M&callback=initMap">
    </script> -->

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDMtfReOBcDyXEUBByLlLgjOkwMKKJw86M"></script>

 
	<!--This is a script for map ends-->
	<script type="text/javascript" src="{{ URL::asset('public/front')}}/otherfiles/progjs/jquery.maskMoney.js"></script>
	<!--<script type="text/javascript" src="{{ URL::asset('public/front')}}/otherfiles/progjs/frontendpublicprofilevenuecalender.js"></script>-->
	<script type="text/javascript" src="{{ URL::asset('public/front')}}/otherfiles/progjs/commoncustomloaderjs.js"></script>
	<script type="text/javascript" src="{{ URL::asset('public/front')}}/otherfiles/progjs/forntendpublicvenue.js"></script>
@endsection