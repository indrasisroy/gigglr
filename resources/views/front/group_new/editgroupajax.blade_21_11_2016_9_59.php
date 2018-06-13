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
for ($i = 15; $i <= 240; $i+=15)
{
	if($i == 105)
	{
		$i=$i+15; 
	}
	if($i == 135)
	{
		$i=$i+45; 
	}
	if($i == 195)
	{
		$i=$i+45; 
	}

		$setuptime_arrdata[$i] = $i.' Minutes';
}

for ($i = 15; $i <= 240; $i+=15)
{

	if($i == 105)
	{
		$i=$i+15; 
	}
	if($i == 135)
	{
		$i=$i+45; 
	}
	if($i == 195)
	{
		$i=$i+45; 
	}
		$packuptime_arrdata[$i] = $i.' Minutes';
}
 
 $first_name=''; $facebook_url=''; $twitter_url=''; $instagram_url=''; $youtube_url=''; $residentadvisor_url='';
 $user_description=''; $soundcloud_url='';
 $availablefor_dbdata = '';
 $bookingfrom_dbdata = '';
 $hourlyrate_dbdata = '';
 $securitydeposit_dbdata ='';
 $setuptime_dbdata ='';
 $packuptime_dbdata ='';
 $techspec_dbdata = '';
 $seo_name=''; $ridercustdata=''; $abncustdata=''; $gstcustdata=''; $pagemetatagcustdata='';
 $availablefor_arrdata=array('3'=>'All','1'=>'Public','2'=>'Private');
$bookingfrom_arrdata=array('1'=>'Anywhere','2'=>'My country','3'=>'My state');
 $fetchskillmasterArData=array();

 $cal_viewshowflag=1; $cal_pendingbkshowflag=1; $cal_publiceventshowflag=1; $cal_privateeventshowflag = 1; 
if(!empty($fetchuserdata))
{
	//echo "<pre>";  print_r($fetchuserdata); echo "</pre>";die;
	

	
		$first_name = $fetchuserdata->nickname;
        $group_id_session = $fetchuserdata->id;
		if($fetchuserdata->nickname==''){
		$seo_name=str_replace("-"," ",$fetchuserdata->seo_name);
		}else{
		$seo_name=$fetchuserdata->nickname;
		}
		$facebook_url=$fetchuserdata->facebook_url;
		$twitter_url=$fetchuserdata->twitter_url;
		$instagram_url=$fetchuserdata->instagram_url;
		$youtube_url=$fetchuserdata->youtube_url;
		$soundcloud_url=$fetchuserdata->soundcloud_url;
		$ridercustdata=stripslashes($fetchuserdata->rider_data);
		$abncustdata=$fetchuserdata->abn_data;
		$gstcustdata=$fetchuserdata->tfn_data;
        $availablefor_dbdata=trim($fetchuserdata->available_for);
        $pagemetatagcustdata=stripslashes($fetchuserdata->group_meta_data);
        $pageseourldata=stripslashes($fetchuserdata->seo_name);

        if(!empty($fetchuserdata->booking_from))
        {
        	$bookingfrom_dbdata=trim($fetchuserdata->booking_from);	
        }
        else
        {
        	$bookingfrom_dbdata=1;
        }


        $hourlyrate_dbdata=stripslashes($fetchuserdata->rate_amount);
        
        $securitydeposit_dbdata=stripslashes($fetchuserdata->security_figure);

        if(!empty($fetchuserdata->setup_time))
        {
        	 $setuptime_dbdata=stripslashes($fetchuserdata->setup_time);
        }else
        {
        	$setuptime_dbdata=15;
        }

       
		 if(!empty($fetchuserdata->packup_time))
		 {
		 	$packuptime_dbdata=stripslashes($fetchuserdata->packup_time);
		 }else
		 {
		 	$packuptime_dbdata=15;
		 }

        
        $techspec_dbdata=stripslashes($fetchuserdata->tech_spec);
		$residentadvisor_url=$fetchuserdata->residentadvisor_url;
		$user_description=$fetchuserdata->group_description;
        
        
        		//*********25-07 start **********//
		$cal_viewshowflag=stripslashes($fetchuserdata->cal_viewshowflag);
		$cal_pendingbkshowflag=stripslashes($fetchuserdata->cal_pendingbkshowflag);
		$cal_publiceventshowflag = stripslashes($fetchuserdata->cal_publiceventshowflag);
        $cal_privateeventshowflag = stripslashes($fetchuserdata->cal_privateeventshowflag);
        
                //*********25-07 end **********//
}
    
    		if ($cal_pendingbkshowflag==0)
		{
				 $pendingmsgdata="Show Pending Booking";
		}
		else
		{
				$pendingmsgdata="Hide Pending Booking";	
		}
		
		
		if ($cal_publiceventshowflag==0)
		{
				 $publiceventshowmsgdata="Show Pending Booking";
		}
		else
		{
				$publiceventshowmsgdata="Hide Pending Booking";	
		}
        
		if ($cal_privateeventshowflag==0)
		{
				 $privateeventshowmsgdata="Show Private Booking";
		}
		else
		{
				$privateeventshowmsgdata="Hide Private Booking";	
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


$groupurl = url('/').'/group/';

?>
@extends('layouts.front.frontendmaster',['successmsg' => $successmsg,'errormsg'=>$errormsg])
@section('content')
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
										<?php  echo Form::open(array('url' => '/groupimagesave','files' => true, 'method' => 'post','id'=>'imgfrmid','class'=>"form-horizontal form-border no-margin mydisplaynone" )); ?>
													
													<input type="file" id="image_name" name="image_name[]"  />
													<input class="mydisplaynone" type="submit" id="submitbutnid" name='submit_image' value="Submit Comment" onclick='upload_image("imgfrmid");'/>
										<?php echo Form::close(); ?>							
						<!--file control form for image upload ends-->
						
						<!--file control for presskit upload  form  starts-->							
										<?php echo Form::open(array('url' => '/presskituploadsavegroup','files' => true, 'method' => 'post','id'=>'presskitfrmid','class'=>"form-horizontal form-border no-margin mydisplaynone" )); ?>
													
													<input type="file" id="presskit_name" name="presskit_name[]"  />
													<input class="mydisplaynone" type="submit" id="presskitsubmitbutnid" name='submit_image' value="Submit Comment" onclick='upload_presskit("presskitfrmid");'/>
										<?php echo Form::close(); ?>							
						<!--file control for presskit upload  form  ends-->	
					
				
					
					<div class="profile_slider edit_profile" id="profsldroutrdivid">
						<!--<div class="item" style="background-image: url({{ FRONTCSSPATH}}/images/slider_img.png);">
                            <a href="#" class="remove_pick" data-toggle="modal" data-target="#alertPopup"><span class="cls"><img src="{{ FRONTCSSPATH}}/images/close2.png" alt="" /></span></a>
						<div class="remove_pick add_pick">
							
							<span class="upld"><img src="{{ FRONTCSSPATH}}/images/upload_icon.png" alt="" />
                              
                            </span>
						</div>
                        </div>
						
						<div class="item" style="background-image: url({{ FRONTCSSPATH}}/images/slider_img.png);"> 
                          <a href="#" class="remove_pick" data-toggle="modal" data-target="#alertPopup"><span class="cls"><img src="{{ FRONTCSSPATH}}/images/close2.png" alt="" /></span></a>
                        </div>-->
						
						<?php
						if(!empty($group_master_img_db))
						{
						//print_r($group_master_img_db);die;
							$totimg=count($group_master_img_db);
							
							foreach($group_master_img_db as $user_master_dta)
							{
								$default_status=$user_master_dta->default_status;
							 
							  
							  //$imgurldata = asset('upload/groupimage/thumb-big/'.$user_master_dta->image_name);
							  $imgurldata = BASEURLPUBLICCUSTOM.'upload/groupimage/thumb-big/'.$user_master_dta->image_name;
							  
							  $first_image_flag=0;
							   if( $default_status==1)
								{        
								 $first_image_flag=1;
								}
						?>
						
						
						<div class="item" style="background-image: url({{ $imgurldata}});">
							<a href="javascript:void(0);" class="remove_pick mycustdelimgcls" data-firstimageflag="<?php echo $first_image_flag; ?>" data-imageid="<?php echo $user_master_dta->id; ?>" data-imagename="<?php echo $user_master_dta->image_name; ?>" data-toggle="modal" data-target="#alertPopup"><span class="cls"><img src="{{ FRONTCSSPATH}}/images/close2.png" alt="" /></span></a>
							
							  <?php if($totimg<=2){  ?>              
							  <div class="remove_pick add_pick">
							  
							  <span class="upld userimgupldcls"><img src="{{ FRONTCSSPATH}}/images/upload_icon.png" alt="" />
							  
							  </span>
							  </div>
							  <?php  }  ?>   
						</div>
						
						
											
							<?php
							}
						  }
						   else
						  {
						    //$imgurldata = asset("front/otherfiles/progimages/"."noimagefound537X507.png");
                            $imgurldata = BASEURLPUBLICCUSTOM."front/otherfiles/progimages/"."noimagefound537X507.png";
							?>
						
						  <!--default image starts	-->
						  <div class="item" style="background-image: url({{ $imgurldata}});">
							<!--<a href="#" class="remove_pick" data-toggle="modal" data-target="#alertPopup"><span class="cls"><img src="{{ FRONTCSSPATH}}/images/close2.png" alt="" /></span></a>-->
							<div class="remove_pick add_pick">
														
							<span class="upld userimgupldcls"><img src="{{ FRONTCSSPATH}}/images/upload_icon.png" alt="" />
							
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
	                		<span class="outPut"><?php echo $seo_name; ?></span>
	                		
							<?php    
							echo Form::text("seo_name", $value=$seo_name, $attributes = array( "id"=>"seo_name","class"=>" editInput editInputfirstname  ","placeholder"=>""));
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
								$control_attrAr['title']="Select Genre";
								
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
								$str_txt = '';
								if(!empty($skill_sub_data_Ar))
								{
                                    $cntsskar=count($skill_sub_data_Ar);
                                    $ccn=1;
										foreach($skill_sub_data_Ar as $kk => $kvlue)
										{
											$skill_sub_data=$skill_sub_data_Ar[$kk];
											$skill_sub_txtdata=$skill_sub_txtdata_Ar[$kk];
                                            
                                            $dotorcomatxt=",";
                                            if($ccn==$cntsskar)
                                            {
                                                $dotorcomatxt=".";
                                            }
								?>
										<div class="gener mysubcustcls" data-skillparent='<?php echo $skill_parent_data; ?>'  data-skillsub='<?php echo $skill_sub_data; ?>' >
											<?php echo $skill_sub_txtdata; ?><?php echo $dotorcomatxt;?>
											<span class="delsubskillclass" data-skillparent='<?php echo $skill_parent_data; ?>'  data-skillsub='<?php echo $skill_sub_data; ?>' >&times;</span>
										</div>
								<?php
                                $ccn++;
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
								<span class="icon_social" style="background: #3b5998;"><img src="{{ FRONTCSSPATH}}/images/fcebk.png" alt="" /></span>
								<span data-myurldata="facebookdefurl" data-facebookdefurl="https://www.facebook.com/"  class="outPut"><?php echo $facebook_url; ?></span>

								<?php    
								echo Form::text("facebook_url", $value=$facebook_url, $attributes = array( "id"=>"facebook_url","class"=>" editInput urlcommncustcls  ","placeholder"=>""));
								?>
								
								<!--<span class="add_icon"> </span>		-->						
							</li>
							<li class="link_edit">								
								<span class="icon_social" style="background: #ff7e30;"><img src="{{ FRONTCSSPATH}}/images/cloud_icon.png" alt="" /></span>
								<span data-myurldata="soundclouddefurl" data-soundclouddefurl="https://www.soundcloud.com/" class="outPut"><?php echo $soundcloud_url; ?></span>

								<?php    
								echo Form::text("soundcloud_url", $value=$soundcloud_url, $attributes = array( "id"=>"soundcloud_url","class"=>" editInput urlcommncustcls  ","placeholder"=>""));
								?>
								<!--<span class="add_icon"> </span>		-->						
							</li>
							<li class="link_edit">								
								<span class="icon_social" style="background: #ffff00;"><img src="{{ FRONTCSSPATH}}/images/advisor_icon.png" alt="" /></span>
								<span data-myurldata="residentadvisordefurl" data-residentadvisordefurl="https://www.residentadvisor.net/" class="outPut"><?php echo $residentadvisor_url; ?></span>
                				
								<?php    
								echo Form::text("residentadvisor_url", $value=$residentadvisor_url, $attributes = array( "id"=>"residentadvisor_url","class"=>" editInput urlcommncustcls  ","placeholder"=>""));
								?>
								<!--<span class="add_icon"> </span>		-->						
							</li>
							<li class="link_edit">								
								<span class="icon_social" style="background: #00aced;"><img src="{{ FRONTCSSPATH}}/images/tweeter_icon.png" alt="" /></span>
								<span data-myurldata="twitterdefurl" data-twitterdefurl="https://www.twitter.com/" class="outPut"><?php echo $twitter_url; ?></span>
                				
								<?php    
								echo Form::text("twitter_url", $value=$twitter_url, $attributes = array( "id"=>"twitter_url","class"=>" editInput urlcommncustcls  ","placeholder"=>""));
								?>
								<!--<span class="add_icon"> </span>	-->							
							</li>
							<li class="link_edit">								
								<span class="icon_social" style="background: #e32b21;"><img src="{{ FRONTCSSPATH}}/images/youtube_icon.png" alt="" /></span>
								<span data-myurldata="youtubedefurl" data-youtubedefurl="https://www.youtube.com/" class="outPut"><?php echo $youtube_url; ?></span>
                				
								<?php    
								echo Form::text("youtube_url", $value=$youtube_url, $attributes = array( "id"=>"youtube_url","class"=>" editInput urlcommncustcls  ","placeholder"=>""));
								?>
								<!--<span class="add_icon"> </span>	-->							
							</li>
							<li class="link_edit">								
								<span class="icon_social" style="background: #2e5e84;"><img src="{{ FRONTCSSPATH}}/images/instagram_icon.png" alt="" /></span>
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
                					<a href="javascript:void(0);" class="presskitupld">

                					<?php $chkpdf =  ($presskitflagcheck > 0 ? 'CHANGE' : 'LOAD'); ?>

                					<?php// echo $chkpdf; ?> UPLOAD PDF KIT
                                    </a>
								</li>
								<li class="btn_row edt_rdr ridercustcls">
							
                					<a href="javascript:void(0);" class="book_btn rider_btn"> Edit Rider</a>
								</li>
								<li class="btn_row abn abncustcls">
									<span class="outPut"><?php if($abncustdata!=''){ echo $abncustdata; } else{ echo "ABN"; }?></span>
                					<input type="text" id="abncust" class="editInput" value="" />
								</li>	
								<li class="btn_row gst gstcustcls">
									<a href="javascript:void(0);"><span class="outPut"><?php if($gstcustdata!=''){ echo $gstcustdata; } else{ echo "GST"; }?></span></a>
										<input type="text" id="gstcust" class="editInput" value="" />
									<!--<a href="javascript:void(0);">Gst</a>-->
									<div class="gstPopHover">
										<div class="gstPopHoverInr">
											<form>
											<div class="radioCheck">
												<label><input type="radio" name="gst" value="1"/><span></span> Yes</label>
											</div>
											<div class="radioCheck">
												<label><input type="radio" name="gst" value="0"/><span></span> No</label>
											</div>
											</form>
										</div>
									</div>
								</li>	
								

								

								<!-- new  -->

								<li class="btn_row pg_mta pagemetatagcustcls nowseourlcommnlicls" style="text-transform: lowercase !important;">
									<span class="outPut"><?php if($pageseourldata!=''){ echo $groupurl.$pageseourldata; } else{ echo $groupurl; }?></span>
                					<input type="text" id="pagemetatagcust_group" class="editInput nowseourltxtcommncls" value="" />
								</li>




								<!-- new ends -->


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
				 <div class="left_chart">

					
					<div class="setting_icon">
						<a href="javascript:void(0);" class="calendarPopBtn"><img src="{{ FRONTCSSPATH}}/images/setting_icon.png" alt="" /></a> <!-- Calendar Setting --><span class="cal_setting_txtcls"> Calendar Settings</span>
						<div class="showHideCalendarPopup">
							<a href="javascript:void(0);" data-calviewshowflag="0" data-typeflag="2" data-artistgrpvenueid="<?php echo $group_id_session;?>" class="calviewshowflagcls hideCalendar <?php if($cal_viewshowflag==0){ echo 'active';} ?> " >Hide Calendar</a>
							<a href="javascript:void(0);" data-calviewshowflag="1" data-typeflag="2" data-artistgrpvenueid="<?php echo $group_id_session;?>" class="calviewshowflagcls showCalendar <?php if($cal_viewshowflag==1){ echo 'active';} ?>">Show Calendar</a>
						</div>
					</div>
				</div>
						
						
						
				
			 
			</div>
		</div>
		<div class="container calsettingsdvcls">
			<div class="event_left calendarHeight">
				<div class="event_left_row">
					<h2 class="event_heading">Events Settings</h2>
					<ul class="visitor_cols event_btn_group">
						<li>
							<a href="javascript:void(0);" style="background: #ff635c;" class="pendbkpblshowflcls" data-typeflag="2" data-artistgrpvenueid="<?php echo $group_id_session;?>" data-pendbkpblshowfl="cal_pendingbkshowflag" data-pendingbkshowflag="<?php echo ($cal_pendingbkshowflag==1)?0:1; ?>">								
								<span class="pendbkpblshowflmsgcls"><?php echo $pendingmsgdata; ?></span>
								<span class="pendbkpblshowflicocls add_icon"> </span>
							</a>
						</li>
						<li>
							<a href="javascript:void(0);" style="background: #f1c40f;" class="pendbkpblshowflcls" data-typeflag="2" data-artistgrpvenueid="<?php echo $group_id_session;?>" data-pendbkpblshowfl="cal_publiceventshowflag" data-pendingbkshowflag="<?php echo ($cal_publiceventshowflag==1)?0:1; ?>" >
								<span class="pendbkpblshowflmsgcls"><?php echo $publiceventshowmsgdata; ?></span>
								<span class="pendbkpblshowflicocls add_icon"> </span>
							</a>
						</li>
                        <li>
							<a href="javascript:void(0);" style="background: #525252;" class="pendbkpblshowflcls" data-typeflag="2" data-artistgrpvenueid="<?php echo $group_id_session;?>" data-pendbkpblshowfl="cal_privateeventshowflag" data-pendingbkshowflag="<?php echo ($cal_privateeventshowflag==1)?0:1; ?>" >
								<span class="pendbkpblshowflmsgcls"><?php echo $privateeventshowmsgdata; ?></span>
								<span class="pendbkpblshowflicocls add_icon"> </span>
							</a>
						</li>

					</ul>
				</div>
				
				
			</div>
			<div class="event_right calendarHeight" id="calendardivid">
				
			</div>
		</div>
	</section>
		<!-- this section is for review section  -->
		<section class="profile_outer">
		<div class="container">
			<div class="clearfix revEdit">
				<h3 class="review_head">Review</h3> 
				<div class="radioCheckWrap">
					<label class="radio-check">
						<input type="radio" name="revShow" value="1"  <?php if($fetchuserdata->review_show_flag == 1){echo "checked =true";} ?>/>
						<span></span>
						Yes
					</label>
					<label class="radio-check">
						<input type="radio" name="revShow" value="0" <?php if($fetchuserdata->review_show_flag == 0){echo "checked =true";} ?> />
						<span></span>
						No
					</label>
<!--					<input type="hidden" value="<?php echo $group_id_session;?>" id="venuehiddenid">
					<input type="hidden" value="<?php echo $fetchuserdata->review_show_flag;?>" id="venuehiddenval">-->


				</div>
			</div>
			<div class="row review_row" id="showreviewnt">
            <?php
            for($i=0;$i<6;$i++){
            
            ?>
            	<div class="col-sm-6 review_cols">
					<div class="review_cell clearfix">
						<div class="review_img_cell">
							<div class="prodile_img"><img alt="" src="{{ FRONTCSSPATH}}/images/profile_img.jpg"></div>
							Zainab
						</div>
						<div class="review_cont_cell">
							<p>
								Quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut
							</p>
							<div class="clearfix">
								<ul class="review_date">
									<li>
										<img src="{{ FRONTCSSPATH}}/images/calender_icon.png" alt="" />30 January, 2014
									</li>
                                    <li>Music: Classical</li>
                                    <!--<li>CLASSICAL</li>-->
									<li>
										3:30 PM 
									</li>
									<li>
										<span class="star_feed"><img src="{{ FRONTCSSPATH}}/images/yellow_star.png" alt="" /> <img src="{{ FRONTCSSPATH}}/images/yellow_star.png" alt="" /> <img src="{{ FRONTCSSPATH}}/images/yellow_star.png" alt="" /> <img src="{{ FRONTCSSPATH}}/images/yellow_star.png" alt="" /></span>
									</li>
								</ul>
								
								<div class="form_right">
									<img src="{{ FRONTCSSPATH}}/images/location_icon.png" alt="" />
									Mumbai
								</div>
							</div>
						</div>
					</div>
				</div>

            <?php
            
            }
            ?>

			</div>
        </div>
	</section>	
	<!-- profile-section-end -->
		
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
          <!--<form>-->
				<?php
						echo Form::open(array('url'=>'', 'method'=>'post', 'id'=>'goup_bookingoption_frmid', 'class'=>"", 'autocomplete'=>'off' ));
                ?>
              <div class="alert error" style="display: none;">Your booking failed</div>
              <div class="alert success" style="display: none;">Your booking successfully</div>
              <div class="row">
                  <div class="col-md-6">
                <div class="artist_divsn">
                  <div class="inline artist_list">
                      <span>Available for</span>
						<?php    
								echo Form::select('typeEvent', $availablefor_arrdata, $availablefor_dbdata,
								$attributes = array( "id"=>"typeEvent", "class"=>"selectpicker artist_txt", "title"=>"Available For" ));
						?>
                    </div>
                </div>
                  </div>
                  <div class="col-md-6">
                <div class="artist_divsn">
                  <div class="inline artist_list">
                      <span>Bookings from</span>
						<?php    
								echo Form::select('bookingfrom', $bookingfrom_arrdata, $bookingfrom_dbdata,
								$attributes = array( "id"=>"bookingfrom", "class"=>"selectpicker artist_txt","title"=>"Bookings From" ));
						?>
                    </div>
                </div>
                  </div>
                  <div class="col-md-6">
                <div class="artist_divsn">
                  <div class="inline artist_list">
                      <!--<span>Hourly Rate</span>-->
                      <span>Total Payment</span>
                        <div class="textField inline srchtxtfield artist_txt epf">
                         <span class="dollar">$</span>
						<!--<input type="text" class="form-control inpt" placeholder="" id="hourly_rate" name="hourly_rate" value="{{ $hourlyrate_dbdata }}" />-->
						<?php
                                echo Form::text("hourly_rate", $value=$hourlyrate_dbdata,
                                $attributes = array( "id"=>"hourly_rate", "class"=>"form-control inpt" ));
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
                         <span class="dollar">$</span>
						<!--<input type="text" class="form-control inpt" placeholder="" id="security_deposit" name="security_deposit" value="{{ $securitydeposit_dbdata }}" />-->
						<?php
                                echo Form::text("security_deposit", $value=$securitydeposit_dbdata,
                                $attributes = array( "id"=>"security_deposit", "class"=>"form-control inpt" ));
                        ?>
                    </div>
                    </div>
                </div>  
                  </div>
                 <div class="col-md-6">
                     <div class="inline artist_list">
                          <span>Set-up Time:</span>
                     <!--<div class="form-group inpt">
                          <div class='input-group date' id='datetimepicker3'>
                             <input type='text' class="form-control clck_outr timepicker" />
                               <span class="input-group-addon clck">
                               <span class="glyphicon glyphicon-time"></span>
                              </span>
                          </div>
                       </div>-->
						<?php
								echo Form::select('setuptime', $setuptime_arrdata, $setuptime_dbdata,
								$attributes = array( "id"=>"setuptime", "class"=>"selectpicker artist_txt","title"=>"Set-up Time" ));
						?>
                     </div>
                     </div>
                    <div class="col-md-6">
                        <div class="inline artist_list">
                          <span>Pack-up Time:</span>
                     <!--<div class="form-group inpt">
                          <div class='input-group date' id='datetimepicker4'>
                             <input type='text' class="form-control clck_outr timepicker" />
                               <span class="input-group-addon clck">
                               <span class="glyphicon glyphicon-time"></span>
                              </span>
                          </div>
                       </div>-->
						<?php
								echo Form::select('packuptime', $packuptime_arrdata, $packuptime_dbdata,
								$attributes = array( "id"=>"packuptime", "class"=>"selectpicker artist_txt","title"=>"Pack-up Time" ));
						?>
                        </div>
                     </div>
                  
                  <div class="col-md-12 margintop20">
                   <div class="inline artist_list">
                      <span>Tech Specs</span>
                       <!--<textarea class="artist_txtaria" id="tech_spec" ><?php echo $techspec_dbdata;?></textarea>-->
                       <div class="posRltv">
							   <?php 
		                                echo Form::textarea("tech_spec", $value=stripslashes($techspec_dbdata),
										$attributes = array( "id"=>"tech_spec", "class"=>"artist_txtaria" ,"cols"=>"50", "rows"=>"10", "maxlength"=>"250" ));
								?>
						</div>
                       <!-- <p> 5 lines, 50 characters maximum per line</p> -->
                       	<input type="hidden" id="fieldtocount" value="250">
						 <p id="CharCountLabel1"></p>
                      </div>
                  </div>
                  <div class="col-md-12">
                    <button type="button" id="group_booking_opt_but" class="btn btn-warning artist_btn">save</button>
                  </div>
                  </div>
          <!--</form>-->
		  <?php echo Form::close(); ?>
            </div>
      </div>
    </div>
  </div>
</div>



    <!--model book artist end-->
    <!-- modal for rider -->
<div class="modal fade" id="myRider" tabindex="-1" role="dialog">
   <div class="myRiderShow">
   </div>
</div>
<!-- modal for rider ends -->
<script>


        var previus_reviewstatus = "<?php echo $fetchuserdata->review_show_flag;?>";
        if(previus_reviewstatus == 1)
        {
            $("#showreviewnt").slideDown(); 
        }
        else if(previus_reviewstatus == 0)
        {
            $("#showreviewnt").slideUp(); 
        }
        var groupID = "<?php echo $group_id_session;?>";
        var viewshowflag="<?php echo $cal_viewshowflag; ?>";
		var pendingbkshowflag_trk="<?php echo $cal_pendingbkshowflag; ?>";
		var publiceventshowflag_trk="<?php echo $cal_publiceventshowflag; ?>";
        var privateeventshowflag_trk="<?php echo $cal_privateeventshowflag; ?>";
        
        var rider_type = 'edit';
		var ridervalue = "<?php echo str_replace(PHP_EOL, ' ',$ridercustdata);?>";
		var profilehiddenid = groupID;
		
		var usertype = '2';

        //alert(viewshowflag+" a "+pendingbkshowflag_trk+" a "+publiceventshowflag_trk);
</script>

	<!--for ajax file upload starts-->
<!--		<script type="text/javascript" src="{{ FRONTCSSPATH}}/otherfiles/progjs/jqueryfileupload1/jquery.form.js"></script>
		<script type="text/javascript" src="{{ FRONTCSSPATH}}/otherfiles/progjs/jqueryfileupload1/userimageupload.js"></script>
		<script type="text/javascript" src="{{ FRONTCSSPATH}}/otherfiles/progjs/jqueryfileupload1/presskitupload.js"></script>-->
	<!--for ajax file upload ends-->
    
<link rel="stylesheet" href="{{ FRONTCSSPATH}}/otherfiles/fullcalendar2.8/fullcalendar.css">	
<script type="text/javascript" src="{{ FRONTCSSPATH}}/otherfiles/fullcalendar2.8/fullcalendar.min.js"></script>
<script type="text/javascript" src="{{ FRONTCSSPATH}}/otherfiles/progjs/frontendpublicprofcalendar.js"></script>	

	<!--for ajax file upload starts-->
		<script type="text/javascript" src="{{ FRONTCSSPATH}}/otherfiles/progjs/jqueryfileupload1/jquery.form.js"></script>
		<script type="text/javascript" src="{{ FRONTCSSPATH}}/otherfiles/progjs/jqueryfileupload1/groupimageupload.js"></script>
		<script type="text/javascript" src="{{ FRONTCSSPATH}}/otherfiles/progjs/jqueryfileupload1/grouppresskitupload.js"></script>
	<!--for ajax file upload ends-->	
	<script type="text/javascript" src="{{ FRONTCSSPATH}}/otherfiles/progjs/frontendeditgroup.js"></script>

	  <script type="text/javascript" src="{{ FRONTCSSPATH}}/otherfiles/progjs/frontendpubliccommonprofile.js"></script> 
	   <script type="text/javascript" src="{{ FRONTCSSPATH}}/otherfiles/progjs/seofoartistgroupvenue.js"></script>  
		    @endsection