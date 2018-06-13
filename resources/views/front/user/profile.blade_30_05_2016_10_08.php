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
 $user_description=''; $soundcloud_url='';
 $fetchskillmasterArData=array();

if(!empty($fetchuserdata))
{
	
	
	$first_name=$fetchuserdata->first_name;
	$facebook_url=$fetchuserdata->facebook_url;
    $twitter_url=$fetchuserdata->twitter_url;
	$instagram_url=$fetchuserdata->instagram_url;
	$youtube_url=$fetchuserdata->youtube_url;
	$soundcloud_url=$fetchuserdata->soundcloud_url;
	$residentadvisor_url=$fetchuserdata->residentadvisor_url;
    $user_description=$fetchuserdata->user_description;
}

if(!empty($fetchskillmasterAr))
{
	$fetchskillmasterArData=$fetchskillmasterAr;
	
}

?>
@extends('layouts.front.frontendmaster',['successmsg' => $successmsg,'errormsg'=>$errormsg])
@section('content')



	<!-- profile-section-start -->
	<section class="profile_outer">
		<div class="container">
			<div class="row dj_row">
				<div class="col-sm-5">
					
						<div class="profile_slider edit_profile">
						<div class="item" style="background-image: url({{ URL::asset('public/front')}}/images/slider_img.png);">
                            <a href="#" class="remove_pick" data-toggle="modal" data-target="#alertPopup"><span class="cls"><img src="{{ URL::asset('public/front')}}/images/close2.png" alt="" /></span></a>
						<div class="remove_pick add_pick">
							<input type="file" />
							<span class="upld"><img src="{{ URL::asset('public/front')}}/images/upload_icon.png" alt="" />
                              
                            </span>
						</div>
                        </div>
						<div class="item" style="background-image: url({{ URL::asset('public/front')}}/images/slider_img.png);"> 
                          <a href="#" class="remove_pick" data-toggle="modal" data-target="#alertPopup"><span class="cls"><img src="{{ URL::asset('public/front')}}/images/close2.png" alt="" /></span></a>
                        </div>
					</div>
						
						
				</div>
				<div class="col-sm-7">
					<!--<h2 class="prifile_heading">Andy Hart</h2>-->
					<h2 class="prifile_heading"><?php echo $first_name;?></h2>
					<div class="like_box">
						<a href="profile.html#review" class="add_link red-tooltip goTo" data-go-to="review_section" data-toggle="tooltip" title="Review"><img src="{{ URL::asset('public/front')}}/images/plus_icon.png" alt="" /></a>
                        
						<a href="#" class="like_link red-tooltip goTo" data-go-to="Favorite_section"  data-toggle="tooltip" title="Favorite"><img src="{{ URL::asset('public/front')}}/images/heart_icon.png" alt="" /></a>
                        
						<a href="profile.html#calendr" class="red-tooltip goTo" data-go-to="Calender_section" data-toggle="tooltip" title="Calender"><img src="{{ URL::asset('public/front')}}/images/calender_icon.png" alt="" /></a>
					</div>
					
					
						<div id="skillidouterdiv">
													
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
							<div class="name_holder skillparentclss"  data-skillparent='<?php echo $skill_parent_data; ?>' >
							
								<div class="mainCategory skillparentname"><?php echo $skill_parent_txtdata; ?>:</div>
								
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
										<div class="gener mysubcustcls" data-skillparent='<?php echo $skill_parent_data; ?>'  data-skillsub='<?php echo $skill_sub_data; ?>' >
											<?php echo $skill_sub_txtdata; ?><?php if($i == $skill_lim){echo ".";}else{echo ",";}?>
										</div>
								<?php
										}
								}
								?>
								
							</div>
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
								<a href="#" class="book_btn" data-toggle="modal" data-target="#myModal5">book artist</a>
							</div>
							<div class="btn_row">
								<a href="#" class="book_btn press_btn">press kit</a>
							</div>
							<div class="btn_row">
								<!-- <a href="#" class="book_btn rider_btn">menu</a> -->
								<a href="#" class="book_btn rider_btn">Rider</a>
							</div>
							<div class="btn_row">
								<div class="rank_cell">
									Performance
									<div class="star_cell">
										<span><img src="{{ URL::asset('public/front')}}/images/star_icon.png" alt="" /></span>
										<span><img src="{{ URL::asset('public/front')}}/images/star_icon.png" alt="" /></span>
										<span><img src="{{ URL::asset('public/front')}}/images/star_icon.png" alt="" /></span>
									</div>
								</div>
							</div>	
							<div class="btn_row">
								<div class="rank_cell">
									Presentation
									<div class="star_cell">
										<span><img src="{{ URL::asset('public/front')}}/images/star_icon.png" alt="" /></span>
										<span><img src="{{ URL::asset('public/front')}}/images/star_icon.png" alt="" /></span>
										<span><img src="{{ URL::asset('public/front')}}/images/star_icon.png" alt="" /></span>
										<span><img src="{{ URL::asset('public/front')}}/images/star_icon.png" alt="" /></span>
                                        
									</div>
								</div>
							</div>	
							<div class="btn_row">
								<div class="rank_cell">
									Punctuality
									<div class="star_cell">
										<span><img src="{{ URL::asset('public/front')}}/images/star_icon.png" alt="" /></span>
										<span><img src="{{ URL::asset('public/front')}}/images/star_icon.png" alt="" /></span>
										<span><img src="{{ URL::asset('public/front')}}/images/star_icon.png" alt="" /></span>
										<span><img src="{{ URL::asset('public/front')}}/images/star_icon.png" alt="" /></span>
                                        <span><img src="{{ URL::asset('public/front')}}/images/star_icon.png" alt="" /></span>
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
		                    <h3 class="pay_hed">We welcome these cards
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
	<section class="profile_outer" id="review_section">
		<div class="container">
			<h3 class="review_head">Review</h3>
			<div class="row review_row">
				<div class="col-sm-6 review_cols">
					<div class="review_cell clearfix">
						<div class="review_img_cell">
							<div class="prodile_img"><img alt="" src="{{ URL::asset('public/front')}}/images/profile_img.jpg"></div>
							Zainab
						</div>
						<div class="review_cont_cell">
							<p>
								Quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut
							</p>
							<div class="clearfix">
								<ul class="review_date">
									<li>
										<img src="{{ URL::asset('public/front')}}/images/calender_icon.png" alt="" />30 January, 2014
									</li>
									<li>
										3.30 pm
										<span class="star_feed"><img src="{{ URL::asset('public/front')}}/images/yellow_star.png" alt="" /> <img src="{{ URL::asset('public/front')}}/images/yellow_star.png" alt="" /> <img src="{{ URL::asset('public/front')}}/images/yellow_star.png" alt="" /> <img src="{{ URL::asset('public/front')}}/images/yellow_star.png" alt="" /></span>
									</li>
								</ul>
								
								<div class="form_right">
									<img src="{{ URL::asset('public/front')}}/images/location_icon.png" alt="" />
									From Mumbai
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-sm-6 review_cols">
					<div class="review_cell clearfix">
						<div class="review_img_cell">
							<div class="prodile_img"><img alt="" src="{{ URL::asset('public/front')}}/images/profile_img.jpg"></div>
							Zainab
						</div>
						<div class="review_cont_cell">
							<p>
								Quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut
							</p>
							<div class="clearfix">
								<ul class="review_date">
									<li>
										<img src="{{ URL::asset('public/front')}}/images/calender_icon.png" alt="" />30 January, 2014
									</li>
									<li>
										3.30 pm
										<span class="star_feed"><img src="{{ URL::asset('public/front')}}/images/yellow_star.png" alt="" /> <img src="{{ URL::asset('public/front')}}/images/yellow_star.png" alt="" /> <img src="{{ URL::asset('public/front')}}/images/yellow_star.png" alt="" /> <img src="{{ URL::asset('public/front')}}/images/yellow_star.png" alt="" /></span>
									</li>
								</ul>
								
								<div class="form_right">
									<img src="{{ URL::asset('public/front')}}/images/location_icon.png" alt="" />
									From Mumbai
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-sm-6 review_cols">
					<div class="review_cell clearfix">
						<div class="review_img_cell">
							<div class="prodile_img"><img alt="" src="{{ URL::asset('public/front')}}/images/profile_img.jpg"></div>
							Zainab
						</div>
						<div class="review_cont_cell">
							<p>
								Quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut
							</p>
							<div class="clearfix">
								<ul class="review_date">
									<li>
										<img src="{{ URL::asset('public/front')}}/images/calender_icon.png" alt="" />30 January, 2014
									</li>
									<li>
										3.30 pm
										<span class="star_feed"><img src="{{ URL::asset('public/front')}}/images/yellow_star.png" alt="" /> <img src="{{ URL::asset('public/front')}}/images/yellow_star.png" alt="" /> <img src="{{ URL::asset('public/front')}}/images/yellow_star.png" alt="" /> <img src="{{ URL::asset('public/front')}}/images/yellow_star.png" alt="" /></span>
									</li>
								</ul>
								
								<div class="form_right">
									<img src="{{ URL::asset('public/front')}}/images/location_icon.png" alt="" />
									From Mumbai
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-sm-6 review_cols">
					<div class="review_cell clearfix">
						<div class="review_img_cell">
							<div class="prodile_img"><img alt="" src="{{ URL::asset('public/front')}}/images/profile_img.jpg"></div>
							Zainab
						</div>
						<div class="review_cont_cell">
							<p>
								Quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut
							</p>
							<div class="clearfix">
								<ul class="review_date">
									<li>
										<img src="{{ URL::asset('public/front')}}/images/calender_icon.png" alt="" />30 January, 2014
									</li>
									<li>
										3.30 pm
										<span class="star_feed"><img src="{{ URL::asset('public/front')}}/images/yellow_star.png" alt="" /> <img src="{{ URL::asset('public/front')}}/images/yellow_star.png" alt="" /> <img src="{{ URL::asset('public/front')}}/images/yellow_star.png" alt="" /> <img src="{{ URL::asset('public/front')}}/images/yellow_star.png" alt="" /></span>
									</li>
								</ul>
								
								<div class="form_right">
									<img src="{{ URL::asset('public/front')}}/images/location_icon.png" alt="" />
									From Mumbai
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-sm-6 review_cols">
					<div class="review_cell clearfix">
						<div class="review_img_cell">
							<div class="prodile_img"><img alt="" src="{{ URL::asset('public/front')}}/images/profile_img.jpg"></div>
							Zainab
						</div>
						<div class="review_cont_cell">
							<p>
								Quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut
							</p>
							<div class="clearfix">
								<ul class="review_date">
									<li>
										<img src="{{ URL::asset('public/front')}}/images/calender_icon.png" alt="" />30 January, 2014
									</li>
									<li>
										3.30 pm
										<span class="star_feed"><img src="{{ URL::asset('public/front')}}/images/yellow_star.png" alt="" /> <img src="{{ URL::asset('public/front')}}/images/yellow_star.png" alt="" /> <img src="{{ URL::asset('public/front')}}/images/yellow_star.png" alt="" /> <img src="{{ URL::asset('public/front')}}/images/yellow_star.png" alt="" /></span>
									</li>
								</ul>
								
								<div class="form_right">
									<img src="{{ URL::asset('public/front')}}/images/location_icon.png" alt="" />
									From Mumbai
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-sm-6 review_cols">
					<div class="review_cell clearfix">
						<div class="review_img_cell">
							<div class="prodile_img"><img alt="" src="{{ URL::asset('public/front')}}/images/profile_img.jpg"></div>
							Zainab
						</div>
						<div class="review_cont_cell">
							<p>
								Quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut
							</p>
							<div class="clearfix">
								<ul class="review_date">
									<li>
										<img src="{{ URL::asset('public/front')}}/images/calender_icon.png" alt="" />30 January, 2014
									</li>
									<li>
										3.30 pm
										<span class="star_feed"><img src="{{ URL::asset('public/front')}}/images/yellow_star.png" alt="" /> <img src="{{ URL::asset('public/front')}}/images/yellow_star.png" alt="" /> <img src="{{ URL::asset('public/front')}}/images/yellow_star.png" alt="" /> <img src="{{ URL::asset('public/front')}}/images/yellow_star.png" alt="" /></span>
									</li>
								</ul>
								
								<div class="form_right">
									<img src="{{ URL::asset('public/front')}}/images/location_icon.png" alt="" />
									From Mumbai
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>	
	<!-- profile-section-end -->
	
	

<!--book artist model booking request      -->
<div class="modal fade" id="myModal5" tabindex="-1" role="dialog" >
  <div class="modal-dialog popup-dialog" role="document">
    <div class="modal-content popup-content artist_popup">
      <div class="modal-body popup-body">
          <div class="artist_hedr request">
            <button type="button" class="close popup-close " data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
             <h2>Booking Request</h2>
          </div>
          <div class="artist_form_outr clearfix">
          <!--<form>-->
		  <?php echo Form::open(array('url' => '', 'method' => 'post','id'=>'','class'=>"" )); ?>
		  
		  
              <div class="alert error" style="display: none;">Your booking failed</div>
              <div class="alert success" style="display: none;">Your booking successfully</div>
              <div class="Constitution-inner-first artist_list">
						<span>Public Event:</span>
						<div class="radio_in">
						
							<?php 
							echo Form::radio('radio', '1', true,$attributes = array("id"=>"radio3"));
							?>

							<label for="radio3"><span><span></span></span>Yes</label>
						  </div>
						  <div class="radio_in">
						  
						  
						   <?php 
							echo Form::radio('radio', '2', false,$attributes = array("id"=>"radio4"));
							?>
							
							<label for="radio4"><span><span></span></span>No</label>
						  </div>
              </div>

              <div class="row">
                  <div class="col-md-12">
                <div class="artist_divsn reqst_dvsn">
                  <div class="inline artist_list request_type">
                      <span>Location:</span>
						<?php    
    echo Form::text("booking_location", $value='', $attributes = array( "id"=>"booking_location","class"=>" form-control","placeholder"=>"USA")); ?>

					   
                    </div>
                </div>
                  </div>
                  <div class="col-md-6">
                <div class="artist_divsn">
                  <div class="inline artist_list request_list">
							
							<?php
								
								$control_attrAr=array();
								$control_attrAr['id']='bookingcat_sub';
								$control_attrAr['class']="selectpicker artist_txt";
								$control_attrAr['title']="Category for Request";
								$bookingcat_sub='';
								$fetchbookingcatData=array('0'=>'Category for Request','1'=>'DJ','2'=>'DANCER');
								echo Form::select('bookingcat_sub', $fetchbookingcatData, $bookingcat_sub,$control_attrAr);							
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
								$fetchbookinggenreData=array('0'=>'Genre for Request','1'=>'Funk','2'=>'Jazz','3'=>'Belly Dancer');
								echo Form::select('bookinggenre_sub', $fetchbookinggenreData, $bookinggenre_sub,$control_attrAr);							
								?>
											
                    </div>
                </div>
                  </div>
                  <div class="col-md-6">
                <div class="artist_divsn">
                  <div class="inline artist_list">
                      <span>Date of Event:</span>
                      <div class="form-group inpt input-customm">
                          <div class='input-group date'>
						  
                             <?php    
    echo Form::text("booking_date", $value='', $attributes = array( "id"=>"booking_date","class"=>"form-control date_outr datetimepicker","placeholder"=>"03.05.16")); ?>
	
                               <span class="input-group-addon dt">
                               <span class="glyphicon glyphicon-calendar clndr"></span>
                              </span>
                          </div>
                       </div>
<!--
                        <div class="textField inline srchtxtfield artist_txt"><input type="text" class="form-control inpt" placeholder=" Location" />
                    </div>
-->
                    </div>
                </div>  
                  </div>
                 <div class="col-md-6">
                     <div class="inline artist_list">
                          <span>Start:</span>
                     <div class="form-group inpt input-customm">
                          <div class='input-group date' id='datetimepicker3'>
						  
						  <?php    
    echo Form::text("start_time", $value='', $attributes = array( "id"=>"start_time","class"=>"form-control clck_outr timepicker","placeholder"=>"3.15 pm")); ?>
						  
						       <span class="input-group-addon clck">
                               <span class="glyphicon glyphicon-time"></span>
                              </span>
                          </div>
                       </div>
                     </div>
                     </div>
                    <div class="col-md-6">
                        <div class="inline artist_list">
                          <span>End:</span>
                     <div class="form-group inpt input-customm">
                          <div class='input-group date' id='datetimepicker4'>
						   <?php    
    echo Form::text("end_time", $value='', $attributes = array( "id"=>"end_time","class"=>"form-control clck_outr timepicker","placeholder"=>"4.20 pm")); ?>
                             
						       <span class="input-group-addon clck">
                               <span class="glyphicon glyphicon-time"></span>
                              </span>
                          </div>
                       </div>
                        </div>
                      </div>
                      <div class="col-md-6">
                     <div class="inline artist_list">
                          <span>Total Payment:</span>
                     <div class="form-group inpt input-customm">
                          <div class='input-group date'>
						    <?php    
    echo Form::text("total_payment", $value='', $attributes = array( "id"=>"total_payment","class"=>"form-control clck_outr lck_outr","placeholder"=>"$0.00"));?>
                               <span class="input-group-addon clck">
                               <span class="glyphicon lck"><img src="{{ URL::asset('public/front')}}/images/lock.png" alt=""/></span>
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
                          <?php    
    echo Form::text("security_payment", $value='', $attributes = array( "id"=>"security_payment","class"=>"form-control clck_outr lck_outr","placeholder"=>"$0.00"));?>
							   <span class="input-group-addon clck">
                               <span class="glyphicon lck"><img src="{{ URL::asset('public/front')}}/images/lock2.png" alt=""/></span>
                              </span>
                          </div>
                       </div>
                     </div>
                     </div>
                     <div class="col-md-6">
                <div class="artist_divsn">
                  <div class="inline artist_list">
                      <span>Cancellation Fee:</span>
                      <div class="form-group inpt input-customm">
                          <div class='input-group date'>
                             
							<?php    
    echo Form::text("cancellation_payment", $value='', $attributes = array( "id"=>"cancellation_payment","class"=>"form-control date_outr lck_outr","placeholder"=>"$0.00"));?>
							 
							 <!--<input type='text' class="form-control date_outr lck_outr" placeholder="$0.00" />-->
							 
							 
                               <span class="input-group-addon dt clck">
                               <span class="glyphicon lck"><img src="{{ URL::asset('public/front')}}/images/lock2.png" alt=""/></span>
                              </span>
                          </div>
                       </div>
<!--
                        <div class="textField inline srchtxtfield artist_txt"><input type="text" class="form-control inpt" placeholder=" Location" />
                    </div>
-->
                    </div>
                </div>  
                  </div>
                 <div class="col-md-6">
                     <div class="inline artist_list">
                          <span>Request Expires:</span>
                     <div class="form-group inpt input-customm">
                          <div class='input-group date'>
						  
                             <!--<input type='text' class="form-control date_outr datetimepicker" />-->
							 <?php    
    echo Form::text("requestexpiredtime", $value='', $attributes = array( "id"=>"requestexpiredtime","class"=>"form-control date_outr datetimepicker"));?>
							 
							 
                               <span class="input-group-addon dt">
                               <span class="glyphicon glyphicon-calendar clndr"></span>
                              </span>
                          </div>
                       </div>
                     </div>
                     </div>
                    <div class="col-md-6">
                        <div class="inline artist_list">
                          <span>Time:</span>
                     <div class="form-group inpt input-customm">
                          <div class='input-group date' id='datetimepicker4'>
						  
							<?php    
    echo Form::text("requestexpiredtime", $value='', $attributes =array( "id"=>"requestexpiredtime","class"=>"form-control clck_outr timepicker","placeholder"=>"4.20 pm"));?>
						  
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
                        concerns in this area here.</div>
<!--                       <p> 5 lines, 50 characters maximum per line</p>-->
                      </div>
                  </div>
                  <div class="col-md-12">
                    <button class="btn btn-warning artist_btn reqst_btn">cancel</button>
                    <button class="btn btn-warning artist_btn rqst_trm_btn">agree to terms </button>
                  </div>
                  </div>
				<?php
				echo Form::close();
				?>
		  
            </div>
      </div>
    </div>
  </div>
      </div>
		
	<!--<script type="text/javascript" src="{{ URL::asset('public/front')}}/otherfiles/progjs/frontendeditprofile.js"></script>-->
    <script>
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();   
        });
    </script>
     
    @endsection
