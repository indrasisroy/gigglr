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
 $user_description=''; $soundcloud_url='';$nickname='';
 $fetchskillmasterArData=array();

if(!empty($fetchuserdata))
{
	//echo "<pre>";  print_r($fetchuserdata); echo "</pre>";
	
	 $first_name=$fetchuserdata->first_name;
	 $nickname=$fetchuserdata->nickname;
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


if(empty($facebook_url))
{
	$facebook_url="https://www.facebook.com/";
}

if(empty($soundcloud_url))
{
	$soundcloud_url="https://www.soundcloud.com/";
}

if(empty($residentadvisor_url))
{
	$residentadvisor_url="https://www.residentadvisor.net/";
}

if(empty($twitter_url))
{
	$twitter_url="https://www.twitter.com/";
}

if(empty($youtube_url))
{
	$youtube_url="https://www.youtube.com/";
}

if(empty($instagram_url))
{
	$instagram_url="https://www.instagram.com/";
}
?>
@extends('layouts.front.frontendmaster',['successmsg' => $successmsg,'errormsg'=>$errormsg])
@section('content')
<!-- profile-section-start -->
	<section class="profile_outer">
		<div class="container">
			<div class="row dj_row">
				<div class="col-sm-5">
				
					<!--<div class="profileWrap">
						<img src="{{ URL::asset('public/front')}}/images/slider_img.png" alt="" />
						<a href="#" class="remove_pick" data-toggle="modal" data-target="#alertPopup"><span><img src="{{ URL::asset('public/front')}}/images/close2.png" alt="" /></span></a>
						<div class="remove_pick add_pick">
							<input type="file" />
							<span><img src="{{ URL::asset('public/front')}}/images/upload_icon.png" alt="" /></span>
						</div>
					</div>-->
					
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
					<h2 class="prifile_heading esEditor">
						<div class="userName">
	                		<span class="outPut"><?php echo $nickname; ?></span>
	                		
							<?php    
							echo Form::text("nickname", $value=$nickname, $attributes = array( "id"=>"nickname","class"=>" editInput editInputfirstname  ","placeholder"=>""));
							?>
	                	</div>	                	
	                	<a href="javascript:void(0);" class="editBtn namechnganchcls"></a>
					</h2>
                    
					 <div class="row select_ot">
                      <div class="col-sm-6 col-xs-6 selct">
                         <div class="inputbox input_selectout clearfix" >
	                         <div class="select_outer singl_arow">
	                          								
								<?php
								
								$control_attrAr=array();
								$control_attrAr['id']='skill_parent';
								$control_attrAr['class']=" selectpicker ";
								$control_attrAr['title']="Select skill";
								
								$skill_parent='';							
								echo Form::select('skill_parent', $fetchskillmasterArData, $skill_parent,$control_attrAr);							
								?>
								
	                         </div>
	                      </div>
                      </div>
						
                      <div class="col-sm-6 col-xs-6 selct">
                         <div class="inputbox input_selectout clearfix" >
	                         <div class="select_outer singl_arow">
	                          
								<?php
								
								$control_attrAr=array();
								$control_attrAr['id']='skill_sub';
								$control_attrAr['class']=" selectpicker ";
								//$control_attrAr['multiple']="";
								$control_attrAr['title']="Select sub skill";
								
								$skill_sub='';
								$fetchskillsubData=array();
								echo Form::select('skill_sub', $fetchskillsubData, $skill_sub,$control_attrAr);							
								?>
	                         </div>
	                      </div>
	                      <span class="add_icon custplus"> </span>
                      </div>
						
                     </div>
					
					<div id="skillidouterdiv">
							
							<!--<div class="name_holder skillparentclss"  data-skillparent="" >
							
								<div class="mainCategory skillparentname">DJ:</div>
								
								<div class="gener">
									pokpok,
									<span class="delsubskillclass">&times;</span>
								</div>		
								
							</div>-->
							
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
										foreach($skill_sub_data_Ar as $kk => $kvlue)
										{
											$skill_sub_data=$skill_sub_data_Ar[$kk];
											$skill_sub_txtdata=$skill_sub_txtdata_Ar[$kk];
								?>
										<div class="gener mysubcustcls" data-skillparent='<?php echo $skill_parent_data; ?>'  data-skillsub='<?php echo $skill_sub_data; ?>' >
											<?php echo $skill_sub_txtdata; ?>,
											<span class="delsubskillclass" data-skillparent='<?php echo $skill_parent_data; ?>'  data-skillsub='<?php echo $skill_sub_data; ?>' >&times;</span>
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
							<li class="link_edit">								
								<span class="icon_social" style="background: #3b5998;"><img src="{{ URL::asset('public/front')}}/images/fcebk.png" alt="" /></span>
								<span data-myurldata="facebookdefurl" data-facebookdefurl="https://www.facebook.com/"  class="outPut"><?php echo $facebook_url; ?></span>

								<?php    
								echo Form::text("facebook_url", $value=$facebook_url, $attributes = array( "id"=>"facebook_url","class"=>" editInput urlcommncustcls  ","placeholder"=>""));
								?>
								
								<!--<span class="add_icon"> </span>		-->						
							</li>
							<li class="link_edit">								
								<span class="icon_social" style="background: #ff7e30;"><img src="{{ URL::asset('public/front')}}/images/cloud_icon.png" alt="" /></span>
								<span data-myurldata="soundclouddefurl" data-soundclouddefurl="https://www.soundcloud.com/" class="outPut"><?php echo $soundcloud_url; ?></span>

								<?php    
								echo Form::text("soundcloud_url", $value=$soundcloud_url, $attributes = array( "id"=>"soundcloud_url","class"=>" editInput urlcommncustcls  ","placeholder"=>""));
								?>
								<!--<span class="add_icon"> </span>		-->						
							</li>
							<li class="link_edit">								
								<span class="icon_social" style="background: #ffff00;"><img src="{{ URL::asset('public/front')}}/images/advisor_icon.png" alt="" /></span>
								<span data-myurldata="residentadvisordefurl" data-residentadvisordefurl="https://www.residentadvisor.net/" class="outPut"><?php echo $residentadvisor_url; ?></span>
                				
								<?php    
								echo Form::text("residentadvisor_url", $value=$residentadvisor_url, $attributes = array( "id"=>"residentadvisor_url","class"=>" editInput urlcommncustcls  ","placeholder"=>""));
								?>
								<!--<span class="add_icon"> </span>		-->						
							</li>
							<li class="link_edit">								
								<span class="icon_social" style="background: #00aced;"><img src="{{ URL::asset('public/front')}}/images/tweeter_icon.png" alt="" /></span>
								<span data-myurldata="twitterdefurl" data-twitterdefurl="https://www.twitter.com/" class="outPut"><?php echo $twitter_url; ?></span>
                				
								<?php    
								echo Form::text("twitter_url", $value=$twitter_url, $attributes = array( "id"=>"twitter_url","class"=>" editInput urlcommncustcls  ","placeholder"=>""));
								?>
								<!--<span class="add_icon"> </span>	-->							
							</li>
							<li class="link_edit">								
								<span class="icon_social" style="background: #e32b21;"><img src="{{ URL::asset('public/front')}}/images/youtube_icon.png" alt="" /></span>
								<span data-myurldata="youtubedefurl" data-youtubedefurl="https://www.youtube.com/" class="outPut"><?php echo $youtube_url; ?></span>
                				
								<?php    
								echo Form::text("youtube_url", $value=$youtube_url, $attributes = array( "id"=>"youtube_url","class"=>" editInput urlcommncustcls  ","placeholder"=>""));
								?>
								<!--<span class="add_icon"> </span>	-->							
							</li>
							<li class="link_edit">								
								<span class="icon_social" style="background: #2e5e84;"><img src="{{ URL::asset('public/front')}}/images/instagram_icon.png" alt="" /></span>
								<span data-myurldata="instagramdefurl" data-instagramdefurl="https://www.instagram.com/" class="outPut"><?php echo $instagram_url; ?></span>

								<?php    
								echo Form::text("instagram_url", $value=$instagram_url, $attributes = array( "id"=>"instagram_url","class"=>" editInput urlcommncustcls  ","placeholder"=>""));
								?>
								<!--<span class="add_icon"> </span>	-->							
							</li>
						</ul>
						<div class="col-sm-6 visitor_cols2">
							<ul class="btn_input">
								<li class="btn_row">	
                					<a href="#" data-toggle="modal" data-target="#myModal4">Booking option</a>
								</li>
								<li class="btn_row upld">
									<!-- <span class="outPut">Upload press kit</span>
                					<input type="text" class="editInput" value="" /> -->
                					<a href="#">LOAD PDF PRESS KIT
                                    </a>
								</li>
								<li class="btn_row edt_rdr">
									<span class="outPut">Edit rider</span>
                					<input type="text" class="editInput" value="" />
								</li>
								<li class="btn_row abn">
									<span class="outPut">ABN</span>
                					<input type="text" class="editInput" value="" />
								</li>	
								<li class="btn_row gst">
									<a href="javascript:void(0);">Gst</a>
									<div class="gstPopHover">
										<div class="gstPopHoverInr">
											<form>
											<div class="radioCheck">
												<label><input type="radio" name="gst" /><span></span> Yes</label>
											</div>
											<div class="radioCheck">
												<label><input type="radio" name="gst" /><span></span> No</label>
											</div>
											</form>
										</div>
									</div>
								</li>	
								<li class="btn_row pg_mta">
									<span class="outPut">Page meta tag</span>
                					<input type="text" class="editInput" value="" />
								</li>		
							</ul>							

						</div>
					</div>
				</div>
			</div>
			<div class="dj_row esEditor para_edit">
                <h2 class="edt_img edt_txt ">Edit Description </h2><a href="javascript:void(0);" class="editBtn descchngancclass"></a>
                
                <div class="textWrap">
                	<p class="outPut"><?php echo $user_description; ?></p>      
					
					<?php
					 echo Form::textarea("user_description", $value=$user_description, $attributes = array("id"=>"user_description","class"=>" editInput desccommncustcls "));
					?>
		
                </div>
                
			</div>			
		</div>
	</section>	
	<section class="profile_outer event_section" id="Calender_section">
	<div class="container">
			<div class="month-chart clearfix">
				<!-- <div class="left_chart">
					<div class="setting_icon">
						<img src="images/setting_icon.png" alt="" />	
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
						<select class="selectpicker">
							<option>Location</option>
							<option>Location</option>
							<option>Location</option>
						</select>
					</div>
					<div class="select_cont search_select">
						<select class="selectpicker">
							<option>Genre</option>
							<option>Genre</option>
							<option>Genre</option>
						</select>
					</div>
					<div class="month_input">
						<input type="text" placeholder="Month" />
					</div>
				</div>
			 -->
			</div>
		</div>
		<div class="container">
			<div class="event_left sam_height">
				<div class="event_left_row">
					<h2 class="event_heading">Events Settings</h2>
					<ul class="visitor_cols event_btn_group">
						<li>
							<a href="#" style="background: #ff635c;">								
								Show when i am busy
								<span class="add_icon"> </span>
							</a>
						</li>
						<li>
							<a href="#" style="background: #f1c40f;" >
								Show my public events
								<span class="add_icon"> </span>
							</a>
						</li>
						<li>
							<a href="#" style="background: #5a2e70;" >
								Allow User Review Description
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
		
	<!-- profile-section-end -->
	
	<!--	   model book artist start-->
      <div class="modal fade" id="myModal4" tabindex="-1" role="dialog" >
  <div class="modal-dialog popup-dialog" role="document">
    <div class="modal-content popup-content artist_popup">
      <div class="modal-body popup-body">
          <div class="artist_hedr">
            <button type="button" class="close popup-close " data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
             <h2>Booking Options</h2>
          </div>
          <div class="artist_form_outr clearfix">
          <form>
              <div class="alert error" style="display: none;">Your booking failed</div>
              <div class="alert success" style="display: none;">Your booking successfully</div>
              <div class="row">
                  <div class="col-md-6">
                <div class="artist_divsn">
                  <div class="inline artist_list">
                      <span>Available for</span>
                        <select class="selectpicker artist_txt">
                            <option value="0">Public Events</option>
                            <option value="1">Public Events1</option>
                            <option value="2">Public Events2</option>
                            <option value="3">Public Events3</option>
                        </select>
                    </div>
                </div>
                  </div>
                  <div class="col-md-6">
                <div class="artist_divsn">
                  <div class="inline artist_list">
                      <span>Bookings from</span>
                        <select class="selectpicker artist_txt">
                            <option value="0">depends on fee</option>
                            <option value="1">depends on fee1</option>
                            <option value="2">depends on fee2</option>
                            <option value="3">depends on fee3</option>
                        </select>
                    </div>
                </div>
                  </div>
                  <div class="col-md-6">
                <div class="artist_divsn">
                  <div class="inline artist_list">
                      <span>Hourly Rate</span>
                        <div class="textField inline srchtxtfield artist_txt epf"><input type="text" class="form-control inpt" placeholder="$0.00" />
                    </div>
                    </div>
                </div>
                  </div>
                  <div class="col-md-6">
                <div class="artist_divsn">
                  <div class="inline artist_list">
                      <span>Security Deposit</span>
                        <div class="textField inline srchtxtfield artist_txt epf"><input type="text" class="form-control inpt" placeholder="$0.00" />
                    </div>
                    </div>
                </div>  
                  </div>
                 <div class="col-md-6">
                     <div class="inline artist_list">
                          <span>Set-up Time:</span>
                     <div class="form-group inpt">
                          <div class='input-group date' id='datetimepicker3'>
                             <input type='text' class="form-control clck_outr timepicker" />
                               <span class="input-group-addon clck">
                               <span class="glyphicon glyphicon-time"></span>
                              </span>
                          </div>
                       </div>
                     </div>
                     </div>
                    <div class="col-md-6">
                        <div class="inline artist_list">
                          <span>Pack-up Time:</span>
                     <div class="form-group inpt">
                          <div class='input-group date' id='datetimepicker4'>
                             <input type='text' class="form-control clck_outr timepicker" />
                               <span class="input-group-addon clck">
                               <span class="glyphicon glyphicon-time"></span>
                              </span>
                          </div>
                       </div>
                        </div>
                     </div>
                  
                  <div class="col-md-12">
                   <div class="inline artist_list">
                      <span>Tech Specs</span>
                       <textarea class="artist_txtaria"></textarea>
                       <p> 5 lines, 50 characters maximum per line</p>
                      </div>
                  </div>
                  <div class="col-md-12">
                    <button class="btn btn-warning artist_btn">save</button>
                  </div>
                  </div>
          </form>
            </div>
      </div>
    </div>
  </div>
      </div>


<!--      model book artist end -->
	
	
	<script type="text/javascript" src="{{ URL::asset('public/front')}}/otherfiles/progjs/frontendeditprofile.js"></script>
	
	<script>
		jQuery(document).ready(function(){
		
		//alert($("#facebook_url").val());
		
		});
	</script>
	
	
    @endsection