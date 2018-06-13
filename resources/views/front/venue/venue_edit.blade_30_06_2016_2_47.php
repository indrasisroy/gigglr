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
$ridercustdata = '';
$abncustdata = '';
$gstcustdata = '';
$pagemetatagcustdata = '';
$statedata = '';
$addrs1data = '';
$addrs2data = '';
$citydata = '';
$zipcodedata = '';
$countrydatavenue = '';
$statedatavenue = '';
 $availablefor_dbdata ='';
 $hourlyrate_dbdata ='';
  $techspec_dbdata ='';
  $openingtimedata ='';
  $closingtimedata ='';
  $securitydeposit_dbdata ='';
$fetchskillmasterArData=array();
$amenities_qryArData =array();
$fetchcountrydata = array();
$fetamenities = array();
$stateIDArdata =array();
if(!empty($fetchuserdata))
{
	//echo "<pre>";  print_r($fetchuserdata); echo "</pre>";
	
	$first_name="Indrasis";
	if($fetchuserdata->nickname)
    {
	  $nickname=$fetchuserdata->nickname;
    }else
    {
    $nickname="Venue Profile -".$fetchuserdata->id;
    }
	if($fetchuserdata->facebook_url)
	$facebook_url=$fetchuserdata->facebook_url;
	
	if($fetchuserdata->twitter_url)
	$twitter_url=$fetchuserdata->twitter_url;
	if($fetchuserdata->instagram_url)
	$instagram_url=$fetchuserdata->instagram_url;
	if($fetchuserdata->youtube_url)
	$youtube_url=$fetchuserdata->youtube_url;
	if($fetchuserdata->soundcloud_url)
	$soundcloud_url=$fetchuserdata->soundcloud_url;
	if($fetchuserdata->residentadvisor_url)
	$residentadvisor_url=$fetchuserdata->residentadvisor_url;
	if($fetchuserdata->venue_description)
	$user_description=$fetchuserdata->venue_description;
	if($fetchuserdata->abn_data)
	$abncustdata = $fetchuserdata->abn_data;
	if($fetchuserdata->tfn_data)
	$gstcustdata = $fetchuserdata->tfn_data;
	if($fetchuserdata->venue_meta_data)
	$pagemetatagcustdata = $fetchuserdata->venue_meta_data;
	
	if($fetchuserdata->address_1)
	$addrs1data = $fetchuserdata->address_1;
	if($fetchuserdata->address_2)
	$addrs2data = $fetchuserdata->address_2;
	
	if($fetchuserdata->city)
	$citydata = $fetchuserdata->city;
	if($fetchuserdata->zip)
	$zipcodedata = $fetchuserdata->zip;
	
	if($fetchuserdata->country)
	$countrydatavenue = $fetchuserdata->country;
	if($fetchuserdata->state)
	$statedatavenue = $fetchuserdata->state;

	if($fetchuserdata->available_for)
	$availablefor_dbdata = $fetchuserdata->available_for;

if($fetchuserdata->rate_amount)
	$hourlyrate_dbdata = $fetchuserdata->rate_amount;
 // $hourlyrate_dbdata

if($fetchuserdata->security_figure)
	$securitydeposit_dbdata = $fetchuserdata->security_figure;
 // $hourlyrate_dbdata

if($fetchuserdata->tech_spec)
	$techspec_dbdata = $fetchuserdata->tech_spec;

if($fetchuserdata->opening_time)
	$openingtimedata = $fetchuserdata->opening_time;

$openingtimedata = date('H:i:s',strtotime($openingtimedata));


if($fetchuserdata->closing_time)
	$closingtimedata = $fetchuserdata->closing_time;

$closingtimedata = date('H:i:s',strtotime($closingtimedata));

	
}






if(!empty($fetchskillmasterAr))
{
	$fetchskillmasterArData=$fetchskillmasterAr;

	
}
if(!empty($stateIDAr))
{
	$stateIDArdata=$stateIDAr;
	

	
}
if(!empty($amenitiesqry_venue))
{
	$amenitiesqry_venue=$amenitiesqry_venue;
	

}
 if(!empty($country_result))
   {
	  $fetchcountrydata = $country_result;
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
				
					<div class="progressbarouter" >
						<!--progressive  starts-->	
							<div class='userprofimgprogress' id="progress_div">
									<div class='userprofimgbar' id='bar'></div>
									<div class='userprofimgpercent' id='percent'>0%</div>
							</div>
						<!--progressive  ends-->
						<!--file control form for image upload  starts-->							
										<?php echo Form::open(array('url' => '/userimagesaveVenue','files' => true, 'method' => 'post','id'=>'imgfrmid','class'=>"form-horizontal form-border no-margin mydisplaynone" )); ?>
													
													<input type="file" id="image_name" name="image_name[]"  />
													<input class="mydisplaynone" type="submit" id="submitbutnid" name='submit_image' value="Submit Comment" onclick='upload_image("imgfrmid");'/>
										<?php echo Form::close(); ?>							
						<!--file control form for image upload ends-->
						
						<!--file control for presskit upload  form  starts-->							
										<?php echo Form::open(array('url' => '/presskituploadsaveVenue','files' => true, 'method' => 'post','id'=>'presskitfrmid','class'=>"form-horizontal form-border no-margin mydisplaynone" )); ?>
													
													<input type="file" id="presskit_name" name="presskit_name[]"  />
													<input class="mydisplaynone" type="submit" id="presskitsubmitbutnid" name='submit_image' value="Submit Comment" onclick='upload_presskit("presskitfrmid");'/>
										<?php echo Form::close(); ?>							
						<!--file control for presskit upload  form  ends-->
						
						
						<!--file control for Menu upload  form  starts-->							
										<?php echo Form::open(array('url' => '/menuuploadsaveVenue','files' => true, 'method' => 'post','id'=>'menufrmid','class'=>"form-horizontal form-border no-margin mydisplaynone" )); ?>
													
													<input type="file" id="menu_name" name="menu_name[]"  />
													<input class="mydisplaynone" type="submit" id="menusubmitbutnid" name='submit_image' value="Submit Comment" onclick='upload_menu("menufrmid");'/>
										<?php echo Form::close(); ?>							
						<!--file control for Menu upload  form  ends-->	
					
				
					
					<div class="profile_slider edit_profile" id="profsldroutrdivid">
						<!--<div class="item" style="background-image: url({{ URL::asset('public/front')}}/images/slider_img.png);">
                            <a href="#" class="remove_pick" data-toggle="modal" data-target="#alertPopup"><span class="cls"><img src="{{ URL::asset('public/front')}}/images/close2.png" alt="" /></span></a>
						<div class="remove_pick add_pick">
							
							<span class="upld"><img src="{{ URL::asset('public/front')}}/images/upload_icon.png" alt="" />
                              
                            </span>
						</div>
                        </div>
						
						<div class="item" style="background-image: url({{ URL::asset('public/front')}}/images/slider_img.png);"> 
                          <a href="#" class="remove_pick" data-toggle="modal" data-target="#alertPopup"><span class="cls"><img src="{{ URL::asset('public/front')}}/images/close2.png" alt="" /></span></a>
                        </div>-->
						
						<?php
						if(!empty($user_master_img_db))
						{
							$totimg=count($user_master_img_db);
							
							foreach($user_master_img_db as $user_master_dta)
							{
							  $default_status=$user_master_dta->default_status;
							  
							  $imgurldata = asset('upload/venueimage/thumb-big/'.$user_master_dta->image_name);
							  
							  $first_image_flag=0;
							   if( $default_status==1)
								{        
								 $first_image_flag=1;
								}
						?>
						
						
						<div class="item" style="background-image: url({{ $imgurldata}});">
							<a href="javascript:void(0);" class="remove_pick mycustdelimgcls" data-firstimageflag="<?php echo $first_image_flag; ?>" data-imageid="<?php echo $user_master_dta->id; ?>" data-imagename="<?php echo $user_master_dta->image_name; ?>" data-toggle="modal" data-target="#alertPopup"><span class="cls"><img src="{{ URL::asset('public/front')}}/images/close2.png" alt="" /></span></a>
							
							  <?php if($totimg<=2){  ?>              
							  <div class="remove_pick add_pick">
							  <!--<input type="file" />-->
							  
							  <span class="upld userimgupldcls"><img src="{{ URL::asset('public/front')}}/images/upload_icon.png" alt="" />
							  
							  </span>
							  </div>
							  <?php  }  ?>   
						</div>
						
						
											
							<?php
							}
						  }
						   else
						  {
						    $imgurldata = asset("front/otherfiles/progimages/"."noimagefound537X507.png");
							?>
						
						  <!--default image starts	-->
						  <div class="item" style="background-image: url({{ $imgurldata}});">
							<!--<a href="#" class="remove_pick" data-toggle="modal" data-target="#alertPopup"><span class="cls"><img src="{{ URL::asset('public/front')}}/images/close2.png" alt="" /></span></a>-->
							<div class="remove_pick add_pick">
														
							<span class="upld userimgupldcls"><img src="{{ URL::asset('public/front')}}/images/upload_icon.png" alt="" />
							
							</span>
							</div>
						  </div>
						  <!--default image ends	-->
							<?php
							
							}
							?>
						
						
					</div>
					
					  
					  
				</div>
				  
				  <div class="mydisplaynone">*Allowed Image extentions : .jpg/.jpeg/.png </div>  
				  <div class="mydisplaynone">*Minimum Resolutions : 537 (Width)  x 507 (Height) </div> 
						
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
								$control_attrAr['title']="Select Category";
								
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
								$control_attrAr['title']="Select Genere";
								
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
                					<a href="javascript:void(0);" class="presskitupld">LOAD PDF PRESS KIT
                                    </a>
								</li>
								<li class="btn_row edt_rdr ridercustcls">
<!--									<span class="outPut"><?php if($ridercustdata!=''){ echo $ridercustdata; } else{ echo "Edit rider"; }?></span>-->
<!--                					<input type="text" id="ridercust" class="editInput" value="" />-->
									<a href="javascript:void(0);" class="menuupld">UPLOAD MENU
                                    </a>
								</li>
								<li class="btn_row abn abncustcls">
									<span class="outPut"><?php if($abncustdata!=''){ echo $abncustdata; } else{ echo "ABN"; }?></span>
                					<input type="text" id="abncust" class="editInput" value="" />
								</li>	
								<li class="btn_row gst gstcustcls">
										<span class="outPut"><?php if($gstcustdata!=''){ echo $gstcustdata; } else{ echo "GST"; }?></span>
										<input type="text" id="gstcust" class="editInput" value="" />
									<!--<a href="javascript:void(0);">Gst</a>
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
									</div>-->
								</li>	
								<li class="btn_row pg_mta pagemetatagcustcls">
									<span class="outPut"><?php if($pagemetatagcustdata!=''){ echo $pagemetatagcustdata; } else{ echo "Page meta tag"; }?></span>
                					<input type="text" id="pagemetatagcust" class="editInput" value="" />
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
				
				
				
				
				
				
				
	<div class="row dj_row">
	<?php echo Form::open(array('method' => 'post','id'=>'venueaddresslocationfrm' )); ?>
										
		<div class="col-sm-6">
			<!--<h2 class="edt_img edt_txt ">Edit Description </h2><a href="javascript:void(0);" class="editBtn descchngancclass"></a>-->
			<div class="row">
			<div class="col-md-12 ">
                     <div class="artist_divsn">
                        <!--For address1-->
                        <div class="inline artist_list request_type">
                           <!--<span>Address:</span>-->
						   <h2 class="edt_img edt_txt ">Address </h2>
                           <?php
                              echo Form::text("venueaddress1",
                              $value=$addrs1data,
                              $attributes = array( "id"=>"venueaddress1",
                              "class"=>" form-control",
                              "placeholder"=>"Venue address 1"
							 
                              ));
                              ?>
							  
                        </div>
						   <!--<div id="booking_locationError"></div>-->
                        <!--For address2-->
                        <div class="inline artist_list request_type">
						
                           <?php
                              echo Form::text("venueaddress2",
                              $value=$addrs2data,
                              $attributes = array( "id"=>"venueaddress2",
                              "class"=>" form-control",
                              "placeholder"=>"Venue address 2",
							  ));
                              ?>
                        </div>
                     </div>
                  </div>
					 
					 
                  <!---------------------For Country State starts here------------------------>
                  <div class="col-md-6">
                     <div class="artist_divsn">
                        <div class="inline artist_list request_list">
                           <?php
						 
                              $control_attrAr=array();
                              $control_attrAr['id']='venueaddresscountry';
                              $control_attrAr['class']="selectpicker artist_txt";
                              $control_attrAr['title']="Country";
                              $country_name='';
                              echo Form::select('venueaddresscountry',
                              $fetchcountrydata,
                              $countrydatavenue,
                              $control_attrAr
							  );							
                              ?>
						   </div>
							   
                     </div>
                  </div>
<!--					  <div class="col-md-6">
					 <div id="countryIdError"></div>
					  </div>-->
						
                  <div class="col-md-6">
                     <div class="artist_divsn">
                        <div class="inline artist_list request_list">
                           <?php
                              $control_attrAr=array();
							
							  $control_attrAr['id']='venueaddressstatelist';
                              $control_attrAr['class']="selectpicker artist_txt";
                              $control_attrAr['title']="State";
                              $bookingstate_sub='';
                              echo Form::select('venueaddressstatelist',
                              $stateIDArdata,
							  $statedatavenue,
                              $control_attrAr
                              );								
                              ?>
                        </div>
                     </div>
                  </div>
<!--					 <div class="col-md-6">
					 <div id="stateIdError"></div>
					  </div>-->
                  <!--------------------------For Country State ends here-------------------------------->
                  <!--------------------------For Town and Zip starts here------------------------------>
                  <div class="col-md-6">
                     <div class="inline artist_list">
                        <span>City:</span>
                        <div class="form-group inpt input-customm">
                           <div class='input-group date'>
                              <!--<input type='text' class="form-control clck_outr lck_outr" placeholder="$0.00" />-->
                              <?php
                                 echo Form::text("venueaddresstown",
                                 $value=$citydata,
                                 $attributes = array( "id"=>"venueaddresstown",
                                 "class"=>"form-control inpt",
                                 "placeholder"=>"",
                                 ));
                                 ?>
                              <!--<span class="input-group-addon clck">
                              <span class="glyphicon lck"><img src="{{ URL::asset('public/front')}}/images/lock.png" alt=""/></span>
                              </span>-->
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="inline artist_list">
                        <span>Zip:</span>
                        <div class="form-group inpt input-customm">
                           <div class='input-group date'>
                              <!--<input type='text' class="form-control clck_outr lck_outr" placeholder="$0.00" />-->
                              <?php
                                 echo Form::text("venueaddresszip",
                                 $value=$zipcodedata,
                                 $attributes = array( "id"=>"venueaddresszip",
                                 "class"=>"form-control inpt",
                                 "placeholder"=>"",
                                 ));
                                 ?>
                            <!--  <span class="input-group-addon clck">
                              <span class="glyphicon lck"><img src="{{ URL::asset('public/front')}}/images/lock.png" alt=""/></span>
                              </span>-->
                           </div>
                        </div>
                     </div>
                  </div>
			</div>
			
			
			
			
			
		</div>
    
    <div class="col-sm-6">
	 <h2 class="edt_img edt_txt ">Select Amenities </h2><a href="javascript:void(0);" class=""></a>
<div class="containerchkbox">

	<div class="amenitiesCheckScroll">
	<div class="amenitiesCheckWrap">
	
	<?php 
	
			if(!empty($user_venue_amenities))
			{
			
								foreach($user_venue_amenities as $venue_amenities)
								{
									$amenitiesID = $venue_amenities->id;
									$amenitiesdata=stripslashes(ucfirst($venue_amenities->amenity_name));
									 $imgurldata = asset('upload/amenities-image/source-file/'.$venue_amenities->amenity_img);
									?>
								<label class="radio-check amenitiesCheck">
								<input type="checkbox" value="{{$amenitiesID}}" name="venueamenities[]" id="venueamenities"
								<?php echo ((in_array($amenitiesID, $amenitiesqry_venue))? 'checked' : '');?>
								/>
								<span></span>{{$amenitiesdata}} <img src="{{ $imgurldata}}" alt="" class="amnt-img"/>
								</label>
								
									<?php
								}
			}
								else{
								$noamenities = "No Amemities Available";
								?>
								{{$noamenities}}
								<?php 
								}
			
	?>
	
	

					</div>
				</div>

					
					
</div>	
	
	</div>
		<?php echo Form::close(); ?>
		
		<div class="col-sm-12">
			<div class="text-right btnWrap">
			<button data-dismiss="modal" id="venueaddresssubmit" class="btn btn-warning artist_btn reqst_btn" type="button">Submit</button>
			</div>
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
        <!--   <form> -->
        		<?php
						echo Form::open(array('url'=>'', 'method'=>'post', 'id'=>'bookingoption_frmid_venue', 'class'=>"", 'autocomplete'=>'off' ));
                ?>
              <div class="alert error" style="display: none;">Your booking failed</div>
              <div class="alert success" style="display: none;">Your booking successfully</div>
              <div class="row">
                  <div class="col-md-12">
                <div class="artist_divsn">
                  <div class="inline artist_list">
                      <span>Available for</span>
                       <!--  <select class="selectpicker artist_txt">
                            <option value="3">All Events</option>
                            <option value="1">Public Events</option>
                            <option value="2">Private Events</option>
                            
                        </select> -->
                        <?php   
                        $availablefor_arrdata=array('3'=>'All','1'=>'Public','2'=>'Private'); 
                       
								echo Form::select('typeEvent', $availablefor_arrdata, $availablefor_dbdata,
								$attributes = array( "id"=>"typeEvent", "class"=>"selectpicker artist_txt", "title"=>"Available For" ));
						?>
                    </div>
                </div>
                  </div>
                
                  <div class="col-md-6">
                <div class="artist_divsn">
                  <div class="inline artist_list">
                      <span>Hourly Rate</span>
                        <div class="textField inline srchtxtfield artist_txt epf">

                        <!-- <input type="text" class="form-control inpt" placeholder="$0.00" /> -->
                        <?php
                        
                                echo Form::text("hourly_rate", $value=$hourlyrate_dbdata,
                                $attributes = array( "id"=>"hourly_rate", "class"=>"form-control inpt" ,"placeholder" => "0.00" ));
                        ?>

                    	</div>
                    </div>
                </div>
                  </div>
                  <div class="col-md-6">
                <div class="artist_divsn">
                  <div class="inline artist_list">
                      <span>Security Deposit</span>
                        <div class="textField inline srchtxtfield artist_txt epf">
	                       <!--  <input type="text" class="form-control inpt" placeholder="$0.00" /> -->
	                       <?php
	                      
                                echo Form::text("security_deposit", $value=$securitydeposit_dbdata,
                                $attributes = array( "id"=>"security_deposit", "class"=>"form-control inpt" ,"placeholder" => "0.00"));
                        	?>
    	                </div>
                    </div>
                </div>  
                  </div>
                 <div class="col-md-6">
                     <div class="inline artist_list">
                          <span>Opening Time:</span>
                     	<div class="form-group inpt">
                          <div class='input-group date' id='datetimepicker3'>
                             <?php
                             	



                             	 echo Form::text("openingtime", $value=$openingtimedata,
                                $attributes = array( "id"=>"openingtime", "class"=>"form-control clck_outr timepicker"));
						?>
                             <!-- <input type='text' class="form-control clck_outr timepicker" /> -->

                               <span class="input-group-addon clck">
                               <span class="glyphicon glyphicon-time"></span>
                              </span>
                          </div>
                       </div>
                     </div>
                     </div>
                    <div class="col-md-6">
                        <div class="inline artist_list">
                          <span>Closing Time:</span>
                     <div class="form-group inpt">
                          <div class='input-group date' id='datetimepicker4'>

                             <!-- <input type='text' class="form-control clck_outr timepicker" /> -->
                              <?php
                             	
                             	 echo Form::text("closingtime", $value=$closingtimedata,
                                $attributes = array( "id"=>"closingtime", "class"=>"form-control clck_outr timepicker"));
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
                      <span>Tech Specs</span>
                       <!-- <textarea class="artist_txtaria"></textarea> -->
                        <?php 
                       
                                echo Form::textarea("tech_spec", $value=$techspec_dbdata,
								$attributes = array( "id"=>"tech_spec", "class"=>"artist_txtaria" ));
						?>
                       <p> 5 lines, 50 characters maximum per line</p>
                      </div>
                  </div>
                  <div class="col-md-12">
                    <button class="btn btn-warning artist_btn" id="booking_opt_but_ven" type="button">save</button>
                  </div>
                  </div>
        <!--   </form> -->
         <?php echo Form::close(); ?>
            </div>
      </div>
    </div>
  </div>
      </div>


<!--      model book artist end -->
<script>
	jQuery("#venueaddresssubmit").click(function(){
	
	//alert("register");
	var tokendata="<?php echo csrf_token(); ?>";
	callforvenueaddress("venueaddress",tokendata);
	
	});
	//************* For ajax state starts  here
								$("#venueaddresscountry").change(function()
								{
									var ProfilecountryId = $(this).val();
									var csrf = "<?php echo csrf_token(); ?>";
									var requestStateUrl = 'countrystatevenue';
									getStateforCountryvenue(requestStateUrl,ProfilecountryId,csrf);
								
								});
				//*************  For ajax state ends here
</script>
	<!--for ajax file upload starts-->
		<script type="text/javascript" src="{{ URL::asset('public/front')}}/otherfiles/progjs/jqueryfileupload1/jquery.form.js"></script>
		<script type="text/javascript" src="{{ URL::asset('public/front')}}/otherfiles/progjs/jqueryfileupload1/venueimageupload.js"></script>
		<script type="text/javascript" src="{{ URL::asset('public/front')}}/otherfiles/progjs/jqueryfileupload1/venuepresskitupload.js"></script>
		<script type="text/javascript" src="{{ URL::asset('public/front')}}/otherfiles/progjs/jqueryfileupload1/venuemenuupload.js"></script>
	<!--for ajax file upload ends-->
	
	<script type="text/javascript" src="{{ URL::asset('public/front')}}/otherfiles/progjs/frontendeditvenue.js"></script>
	<style>
		.containerchkbox {
			border:2px solid #ccc; 			
			padding: 24px 0 24px 50px;
			    min-height: 235px;
		}
		.amenitiesCheckScroll {
			overflow-y: auto;
			max-height: 186px;
			/*padding-right: 24px;*/
		}
		.containerchkbox .amenitiesCheck {
			width: 48%;
			padding-right: 6px;
			padding-left: 6px;
			margin-bottom: 5px;
			
		}
		.amenitiesCheck.radio-check input[type="checkbox"] + span {
			background-color: transparent;
			border-radius: 0;
			border-color: #ccc;
		}
		.tttyyyyyy{
			margin-left: -23px;

		}
		.amenitiesCheck img
		{
		margin-left: 6px;
		}
		.amnt-img{
			width:17px;
			height:14px;
		}
	</style>
	
    @endsection