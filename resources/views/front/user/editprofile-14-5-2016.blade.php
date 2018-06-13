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
	//echo "<pre>";  print_r($fetchuserdata); echo "</pre>";
	
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
					<div class="profileWrap">
						<img src="{{ URL::asset('public/front')}}/images/slider_img.png" alt="" />
						<a href="#" class="remove_pick" data-toggle="modal" data-target="#alertPopup"><span><img src="{{ URL::asset('public/front')}}/images/close2.png" alt="" /></span></a>
						<div class="remove_pick add_pick">
							<input type="file" />
							<span><img src="{{ URL::asset('public/front')}}/images/upload_icon.png" alt="" /></span>
						</div>
					</div>
				</div>
				<div class="col-sm-7">
					<h2 class="prifile_heading esEditor">
						<div class="userName">
	                		<span class="outPut"><?php echo $first_name; ?></span>
	                		
							<?php    
							echo Form::text("first_name", $value=$first_name, $attributes = array( "id"=>"first_name","class"=>" editInput editInputfirstname  ","placeholder"=>""));
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
								<span class="outPut">https://www.facebook.com/</span>

								<?php    
								echo Form::text("facebook_url", $value=$facebook_url, $attributes = array( "id"=>"facebook_url","class"=>" editInput urlcommncustcls  ","placeholder"=>""));
								?>
								
								<span class="add_icon"> </span>								
							</li>
							<li class="link_edit">								
								<span class="icon_social" style="background: #ff7e30;"><img src="{{ URL::asset('public/front')}}/images/cloud_icon.png" alt="" /></span>
								<span class="outPut">http://www.soundcloud.com/</span>

								<?php    
								echo Form::text("soundcloud_url", $value=$soundcloud_url, $attributes = array( "id"=>"soundcloud_url","class"=>" editInput urlcommncustcls  ","placeholder"=>""));
								?>
								<span class="add_icon"> </span>								
							</li>
							<li class="link_edit">								
								<span class="icon_social" style="background: #ffff00;"><img src="{{ URL::asset('public/front')}}/images/advisor_icon.png" alt="" /></span>
								<span class="outPut">https://www.residentadvisor.net/</span>
                				
								<?php    
								echo Form::text("residentadvisor_url", $value=$residentadvisor_url, $attributes = array( "id"=>"residentadvisor_url","class"=>" editInput urlcommncustcls  ","placeholder"=>""));
								?>
								<span class="add_icon"> </span>								
							</li>
							<li class="link_edit">								
								<span class="icon_social" style="background: #00aced;"><img src="{{ URL::asset('public/front')}}/images/tweeter_icon.png" alt="" /></span>
								<span class="outPut">https://twitter.com/</span>
                				
								<?php    
								echo Form::text("twitter_url", $value=$twitter_url, $attributes = array( "id"=>"twitter_url","class"=>" editInput urlcommncustcls  ","placeholder"=>""));
								?>
								<span class="add_icon"> </span>								
							</li>
							<li class="link_edit">								
								<span class="icon_social" style="background: #e32b21;"><img src="{{ URL::asset('public/front')}}/images/youtube_icon.png" alt="" /></span>
								<span class="outPut">https://www.youtube.com/</span>
                				
								<?php    
								echo Form::text("youtube_url", $value=$youtube_url, $attributes = array( "id"=>"youtube_url","class"=>" editInput urlcommncustcls  ","placeholder"=>""));
								?>
								<span class="add_icon"> </span>								
							</li>
							<li class="link_edit">								
								<span class="icon_social" style="background: #2e5e84;"><img src="{{ URL::asset('public/front')}}/images/instagram_icon.png" alt="" /></span>
								<span class="outPut">https://www.instagram.com/</span>

								<?php    
								echo Form::text("instagram_url", $value=$instagram_url, $attributes = array( "id"=>"instagram_url","class"=>" editInput urlcommncustcls  ","placeholder"=>""));
								?>
								<span class="add_icon"> </span>								
							</li>
						</ul>
						<div class="col-sm-6 visitor_cols2">
							<ul class="btn_input">
								<li class="btn_row">	
                					<a href="#">Booking option</a>
								</li>
								<li class="btn_row upld">
									<!-- <span class="outPut">Upload press kit</span>
                					<input type="text" class="editInput" value="" /> -->
                					<a href="#">Upload press kit</a>
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
	
	
	<script type="text/javascript" src="{{ URL::asset('public/front')}}/otherfiles/progjs/frontendeditprofile.js"></script>
	
	<script>
		jQuery(document).ready(function(){
		
		//alert($("#facebook_url").val());
		});
	</script>
	
	
    @endsection