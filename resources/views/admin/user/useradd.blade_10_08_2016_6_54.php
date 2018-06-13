<?php

	 $formfortype = Request::segment(3); 
	  if(empty($formfortype))
	  {
	  	$formfortype = 0;
	  }else
	  {
	  	$formfortype = 1;
	  }
	//   echo $formfortype;
	// die;

$successmsg='';$errormsg='';
if(!empty($successmsgdata))
{
        $successmsg=$successmsgdata;
}

if(!empty($errormsgdata))
{
        $errormsg=$errormsgdata;
}

?>
@extends('layouts.admin.adminmaster',['successmsg' => $successmsg,'errormsg'=>$errormsg])
@section('content')
	<?php
	$uid=''; $first_name=''; $middle_name=''; $last_name=''; $username=''; $nickname=''; $email=''; $oldpass=''; $gen=''; $address1=''; $address2=''; $country_id='';$state_id=''; $city=''; $zip=''; $language_id=''; $skill_id=''; $subskill_id=''; $abn=''; $gst=''; $tfn=''; $currency=''; $rider=''; $description=''; $fburl=''; $soundcloudurl=''; $residentadvisorurl=''; $twitterurl=''; $youtubeurl=''; $instagramurl='';
	$country_id_data=array(); $language_id_data=array(); $skill_id_data=array(); $currency_id_data=array();$fetchstateidData=array();
	$date='';$pagemeta='';$userprskt_data='';
	if(!empty($userrow))
	{
		// echo "<pre>";
		// print_r($userrow);die;
		$uid=$userrow->id;
		$first_name=stripslashes($userrow->first_name);
		$middle_name=stripslashes($userrow->middle_name);
		$last_name=stripslashes($userrow->last_name);
		$username=$userrow->username;
		$nickname=$userrow->nickname;
		$email=$userrow->email;
		$oldpass=$userrow->password;
		$gen=$userrow->gender;
		$address1=$userrow->address1;
		$address2=$userrow->address2;
	 	$country_id=$userrow->country; 
		$state_id=$userrow->state;
		$city=$userrow->city;
		$zip=$userrow->zip;
		$language_id=$userrow->language;
		$abn=$userrow->abn_data;
		$gst=$userrow->gst_status;
		$tfn=$userrow->tfn_data;
		$currency=$userrow->currency;
		$rider=$userrow->rider_data;
		$description=$userrow->user_description;
		$fburl=$userrow->facebook_url;
		$soundcloudurl=$userrow->soundcloud_url;
		$residentadvisorurl=$userrow->residentadvisor_url;
		$twitterurl=$userrow->twitter_url;
		$youtubeurl=$userrow->youtube_url;
		$instagramurl=$userrow->instagram_url;

		$pagemeta = $userrow->user_meta_data;

		$date=$userrow->dob;
	}
	if(!empty($countryidAr))
	{
		$country_id_data=$countryidAr;
	}
	if(!empty($stateidAr))
	{
		$fetchstateidData=$stateidAr;
	}
	if(!empty($languageidAr))
	{
		$language_id_data=$languageidAr;
	}
	if(!empty($skillidAr))
	{
		$skill_id_data=$skillidAr;
	}
	if(!empty($currencyidAr))
	{
		$currency_id_data=$currencyidAr;
	}
	if(!empty($userpresskit))
	{
		$userprskt_data=$userpresskit->presskit_name;
	}
				if($date!='0000-00-00 00:00:00')
				{
					//echo $date;die;
					$date = date('m/d/Y',strtotime($date));
				}else if("0000-00-00 00:00:00")
				{
					$date = '';
				}
	?>
			<!-- <div class="padding-md">
				<div class="row">
					<div class="col-md-8 col-md-offset-2">

					</div>
					</div>
			</div>-->
			<!-- /.padding-md --> 



			<div class="panel panel-default">
					<div class="panel-heading">
						Save user
					</div>


					<div class="panel-tab">	
						<ul class="wizard-steps" id="wizardTab"> 
							<li class="active">
								<a href="#wizardContent1" data-toggle="tab">Basic Info</a>
							</li> 
							<li>
								<a href="#wizardContent2" data-toggle="tab">Account Info</a>
							</li> 
							
							<li>
								<a href="#wizardContent4" data-toggle="tab">Social links</a>
							</li>
							<li>
								<a href="#wizardContent3" data-toggle="tab">Profile Info</a>
							</li>
						</ul>
					</div>
					<div class="panel-body">
						<?php echo Form::open(array('url' => ADMINSEPARATOR.'/usersave','files' => true, 'method' => 'post','id'=>'useraddfrmid','class'=>"form-horizontal form-border no-margin" )); ?>
						<div class="tab-content">


						<!-- Basic information content	starts	 -->


							<div class="tab-pane fade in active" id="wizardContent1">
								
									
									
									
									
									
									
									<div class="form-group">
										<label class="control-label col-lg-4">Nickname</label>
										<div class="col-lg-4">										
											<?php    
    echo Form::text("nickname", $value=$nickname, $attributes = array( "id"=>"nickname","class"=>" form-control input-sm parsley-validated ")); ?>
											<span  class="errorcustclass">{{ $errors->first('nickname') }}</span>
										</div><!-- /.col -->
									</div><!-- /form-group -->
									
									<div class="form-group">
										<label class="control-label col-lg-4">Email</label>
										<div class="col-lg-4">
											<?php    
    echo Form::text("email", $value=$email, $attributes = array( "id"=>"email","class"=>" form-control input-sm parsley-validated ")); ?>
	<span  class="errorcustclass">{{ $errors->first('email') }}</span>										
										</div><!-- /.col -->
									</div><!-- /form-group -->
									
									<div class="form-group">
										<label class="control-label col-lg-4">Password</label>
										<div class="col-lg-4">
											
											<?php
											$passval='';
    echo Form::text("newpass", $value=$passval, $attributes = array( "id"=>"newpass","class"=>" form-control input-sm parsley-validated ")); ?>
	<span  class="errorcustclass">{{ $errors->first('newpass') }}</span>

										</div><!-- /.col -->
									</div><!-- /form-group -->
									
	<?php echo Form::hidden("oldpass", $value=$oldpass, $attributes = array( "id"=>"oldpass","class"=>" form-control input-sm parsley-validated ")); ?>
									
									<div class="form-group">
										<label class="control-label col-lg-4">Gender</label>
										<div class="col-lg-4">
											<?php    
   echo Form::select('gender', array(''=>'Choose gender', '1'=>'Male', '2'=>'Female', '3'=>'Other'), $gen,$attributes = array("id"=>"gender","class"=>"form-control input-sm parsley-validated"));
   ?>
   <span  class="errorcustclass">{{ $errors->first('gender') }}</span>	
										</div><!-- /.col -->
									</div><!-- /form-group -->

									<!-- for dob starts here -->
									<div class="form-group">
										<label class="control-label col-lg-4">Date of birth</label>
										
											<div class="col-lg-4">
												
												<div class="input-group"> <!-- datepicker div -->
												<?php 
												echo Form::text("dateofbirth",$value=$date,$attributes = array("id" => "dateofbirth","class"=>"datepicker form-control input-sm parsley-validated"))
												?>
												<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
												</div> <!-- end of datepicker div -->
												<span  class="errorcustclass">{{ $errors->first('dateofbirth') }}</span>


											</div><!-- /.col -->
									</div><!-- /form-group -->


									<!-- for dob ends here -->
							</div>

							<!-- Account content	starts	 -->

							<div class="tab-pane fade" id="wizardContent2">
							<div class="form-group">
										<label class="control-label col-lg-4">First Name</label>
										<div class="col-lg-4">
											
											<?php    
    echo Form::text("first_name", $value=$first_name, $attributes = array( "id"=>"first_name","class"=>" form-control input-sm parsley-validated ")); ?>
	<span  class="errorcustclass">{{ $errors->first('first_name') }}</span>

										</div><!-- /.col -->
									</div><!-- /form-group -->
									<div class="form-group">
										<label class="control-label col-lg-4">Middle Name</label>
										<div class="col-lg-4">
											<?php    
    echo Form::text("middle_name", $value=$middle_name, $attributes = array( "id"=>"middle_name","class"=>" form-control input-sm parsley-validated ")); ?>
											<span  class="errorcustclass">{{ $errors->first('middle_name') }}</span>
										</div><!-- /.col -->
									</div><!-- /form-group -->

									<div class="form-group">
										<label class="control-label col-lg-4">Last Name</label>
										<div class="col-lg-4">
											
											<?php    
    echo Form::text("last_name", $value=$last_name, $attributes = array( "id"=>"last_name","class"=>" form-control input-sm parsley-validated ")); ?>
	<span  class="errorcustclass">{{ $errors->first('last_name') }}</span>

										</div><!-- /.col -->
									</div><!-- /form-group -->

								<div class="form-group">
										<label class="control-label col-lg-4">Address 1</label>
										<div class="col-lg-4">
											
											<?php    
    echo Form::text("address1", $value=$address1, $attributes = array( "id"=>"address1","class"=>" form-control input-sm parsley-validated ")); ?>
	<span  class="errorcustclass">{{ $errors->first('address1') }}</span>

										</div><!-- /.col -->
									</div><!-- /form-group -->
									
									<div class="form-group">
										<label class="control-label col-lg-4">Address 2</label>
										<div class="col-lg-4">
											
											<?php    
    echo Form::text("address2", $value=$address2, $attributes = array( "id"=>"address2","class"=>" form-control input-sm parsley-validated ")); ?>
	<span  class="errorcustclass">{{ $errors->first('address2') }}</span>

										</div><!-- /.col -->
									</div><!-- /form-group -->
									
									<div class="form-group">
										<label class="control-label col-lg-4">Country</label>
										<div class="col-lg-4">
											
											<?php    
   echo Form::select('country_id',$country_id_data , $country_id,$attributes = array( "id"=>"country_id","class"=>"form-control input-sm parsley-validated"));
   ?>

	<span  class="errorcustclass">{{ $errors->first('country_id') }}</span>

										</div><!-- /.col -->
									</div><!-- /form-group -->
									
									<div class="form-group">
										<label class="control-label col-lg-4">State</label>
										<div class="col-lg-4">
   
											<?php
												// $admin_control_attrAr=array();
												// $admin_control_attrAr['id']='state_id';
												// $admin_control_attrAr['class']="form-control input-sm parsley-validated";
												// $fetchstateidData=array();
												echo Form::select('state_id', $fetchstateidData, $state_id,$attributes = array( "id"=>"state_id","class"=>"form-control input-sm parsley-validated"));							
											?>

	<span  class="errorcustclass">{{ $errors->first('state_id') }}</span>

										</div><!-- /.col -->
									</div><!-- /form-group -->
									
									<div class="form-group">
										<label class="control-label col-lg-4">City</label>
										<div class="col-lg-4">
											
											<?php    
    echo Form::text("city", $value=$city, $attributes = array( "id"=>"city","class"=>" form-control input-sm parsley-validated ")); ?>
	<span  class="errorcustclass">{{ $errors->first('city') }}</span>

										</div><!-- /.col -->
									</div><!-- /form-group -->
									
									<div class="form-group">
										<label class="control-label col-lg-4">Zip</label>
										<div class="col-lg-4">
											
											<?php    
    echo Form::text("zip", $value=$zip, $attributes = array( "id"=>"zip","class"=>" form-control input-sm parsley-validated ")); ?>
	<span  class="errorcustclass">{{ $errors->first('zip') }}</span>

										</div><!-- /.col -->
									</div><!-- /form-group -->
									
									<div class="form-group">
										<label class="control-label col-lg-4">Language</label>
										<div class="col-lg-4">
											
											<?php    
   echo Form::select('language_id',$language_id_data , $language_id,$attributes = array( "id"=>"language_id","class"=>"form-control input-sm parsley-validated"));
   ?>

	<span  class="errorcustclass">{{ $errors->first('language_id') }}</span>

										</div><!-- /.col -->
									</div><!-- /form-group -->

									<div class="form-group">
										<label class="control-label col-lg-4">Currency</label>
										<div class="col-lg-4">
											
											<?php    
   echo Form::select('currency',$currency_id_data , $currency,$attributes = array( "id"=>"currency","class"=>"form-control input-sm parsley-validated"));
   ?>

	<span  class="errorcustclass">{{ $errors->first('currency') }}</span>

										</div><!-- /.col -->
									</div><!-- /form-group -->
							</div>
					

					<!-- profile content	starts	 -->


							<div class="tab-pane fade" id="wizardContent3">
								<div class="form-group">
										<label class="control-label col-lg-4">Category</label>
										<div class="col-lg-4">
											
											<?php    
   echo Form::select('skill_id',$skill_id_data,$skill_id,$attributes=array( "id"=>"skill_id","class"=>"form-control input-sm parsley-validated"));
   ?>

	<span  class="errorcustclass">{{ $errors->first('skill_id') }}</span>

										</div><!-- /.col -->
									</div><!-- /form-group -->
									
									<div class="form-group">
										<label class="control-label col-lg-4">Sub-category</label>
										<div class="col-lg-4">
   
											<?php
												$admin_control_attrAr=array();
												$admin_control_attrAr['id']='subskill_id';
												$admin_control_attrAr['class']="selectpicker form-control input-sm parsley-validated";
												$fetchsubskillidData=array();
												echo Form::select('subskill_id', $fetchsubskillidData, $subskill_id,$admin_control_attrAr);							
											?>

	<span  class="errorcustclass">{{ $errors->first('subskill_id') }}</span>

										</div><!-- /.col -->
									</div><!-- /form-group -->
									
									<div class="form-group">
										<label class="control-label col-lg-4">ABN</label>
										<div class="col-lg-4">
											
											<?php    
    echo Form::text("abn", $value=$abn, $attributes = array( "id"=>"abn","class"=>" form-control input-sm parsley-validated ")); ?>
	<span  class="errorcustclass">{{ $errors->first('abn') }}</span>

										</div><!-- /.col -->
									</div><!-- /form-group -->
									
									<div class="form-group">
										<label class="control-label col-lg-4">GST</label>
										<div class="col-lg-4">
											<?php    
   echo Form::select('gst', array('1'=>'Yes', '0'=>'No'), $gst,$attributes = array("id"=>"gst","class"=>"form-control input-sm parsley-validated"));
   ?>
   <span  class="errorcustclass">{{ $errors->first('gst') }}</span>	
										</div><!-- /.col -->
									</div><!-- /form-group -->
									
									<div class="form-group" id="tfndiv">
										<label class="control-label col-lg-4">TFN</label>
										<div class="col-lg-4">
											
											<?php    
    echo Form::text("tfn", $value=$tfn, $attributes = array( "id"=>"tfn","class"=>" form-control input-sm parsley-validated ")); ?>
	<span  class="errorcustclass">{{ $errors->first('tfn') }}</span>

										</div><!-- /.col -->
									</div><!-- /form-group -->
									
									
									
									<div class="form-group">
                                        <label class="control-label col-lg-4">Rider</label>
                                        <div class="col-lg-4">
											<?php 
												echo Form::textarea("rider", $value=$rider, $attributes = array("id"=>"rider","class"=>"form-control input-sm"));
											?>
											<span  class="errorcustclass">{{ $errors->first('rider') }}</span>
                                        </div><!-- /.col -->
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label col-lg-4">Page Meta Tag</label>
                                        <div class="col-lg-4">
											<?php 
												echo Form::text("pagemeta", $value=$pagemeta, $attributes = array("id"=>"pagemeta","class"=>"form-control input-sm"));
											?>
											<span  class="errorcustclass">{{ $errors->first('pagemeta') }}</span>
                                        </div><!-- /.col -->
                                    </div>

										
									<div class="form-group">
                                        <label class="col-lg-4 control-label">Description</label>
                                        <div class="col-lg-4">
											<?php 
												echo Form::textarea("description", $value=$description, $attributes = array("id"=>"description","class"=>"form-control input-sm"));
											?>
											<span  class="errorcustclass">{{ $errors->first('description') }}</span>
                                        </div><!-- /.col -->
                                    </div>


                                    <div class="form-group">
                                        <label class="col-lg-4 control-label">Load Press kit</label>
                                        <div class="col-lg-4">
											<input type="file" name="presskit_name[]" id="presskit_name" class="form-control input-sm"  >

											<span  class="errorcustclass"><?php echo $errors->first('presskit_name') ?> </span>
                                        </div><!-- /.col -->
                                        <div class="col-lg-4">
                                        	<!--  <a href="" class="fa fa-download">Download Press kit</a> -->


                       <?php 
                       if(!empty($userprskt_data))
                       {
                        $userprskt_data_user = ADMINSEPARATOR.'/userpresskitadmin/'.base64_encode($userprskt_data);
						echo link_to($userprskt_data_user, $title = 'Download press kit', $attributes = array("class"=>"fa fa-download","target"=>"_blank"), $secure = null);
						}

                       ?>


                                        </div>

                                    </div>






							</div>
							<div class="tab-pane fade" id="wizardContent4">
									<div class="form-group">
										<label class="control-label col-lg-4">Facebook URL</label>
										<div class="col-lg-4">										
											<?php echo Form::text("fburl", $value=$fburl, $attributes = array("id"=>"fburl","class"=>"form-control input-sm parsley-validated ")); ?>
											<span  class="errorcustclass">{{ $errors->first('fburl') }}</span>
										</div><!-- /.col -->
									</div><!-- /form-group -->

									<div class="form-group">
										<label class="control-label col-lg-4">Soundcloud URL</label>
										<div class="col-lg-4">										
											<?php echo Form::text("soundcloudurl", $value=$soundcloudurl, $attributes = array("id"=>"soundcloudurl","class"=>"form-control input-sm parsley-validated ")); ?>
											<span  class="errorcustclass">{{ $errors->first('soundcloudurl') }}</span>
										</div><!-- /.col -->
									</div><!-- /form-group -->

											<div class="form-group">
										<label class="control-label col-lg-4">Residentadvisor URL</label>
										<div class="col-lg-4">										
											<?php echo Form::text("residentadvisorurl", $value=$residentadvisorurl, $attributes = array("id"=>"residentadvisorurl","class"=>"form-control input-sm parsley-validated ")); ?>
											<span  class="errorcustclass">{{ $errors->first('residentadvisorurl') }}</span>
										</div><!-- /.col -->
									</div><!-- /form-group -->
									
									<div class="form-group">
										<label class="control-label col-lg-4">Twitter URL</label>
										<div class="col-lg-4">										
											<?php echo Form::text("twitterurl", $value=$twitterurl, $attributes = array("id"=>"twitterurl","class"=>"form-control input-sm parsley-validated ")); ?>
											<span  class="errorcustclass">{{ $errors->first('twitterurl') }}</span>
										</div><!-- /.col -->
									</div><!-- /form-group -->
									
									<div class="form-group">
										<label class="control-label col-lg-4">Youtube URL</label>
										<div class="col-lg-4">										
											<?php echo Form::text("youtubeurl", $value=$youtubeurl, $attributes = array("id"=>"youtubeurl","class"=>"form-control input-sm parsley-validated ")); ?>
											<span  class="errorcustclass">{{ $errors->first('youtubeurl') }}</span>
										</div><!-- /.col -->
									</div><!-- /form-group -->
									
									<div class="form-group">
										<label class="control-label col-lg-4">Instagram URL</label>
										<div class="col-lg-4">										
											<?php echo Form::text("instagramurl", $value=$instagramurl, $attributes = array("id"=>"instagramurl","class"=>"form-control input-sm parsley-validated ")); ?>
											<span  class="errorcustclass">{{ $errors->first('instagramurl') }}</span>
										</div><!-- /.col -->
										<input type="hidden" name="uid" value="<?php echo $uid; ?>" >
										<input type="hidden" name="formtype" value="<?php echo $formfortype; ?>" >
									</div><!-- /form-group -->
							</div>
						</div>
						
					</div>
					<div class="panel-footer">
						<a class="btn btn-warning" id="prevStep" disabled><i class="fa fa-chevron-left"></i> Previous</a>
						<a class="btn btn-primary" id="nextStep">Next <i class="fa fa-chevron-right"></i></a>
						<span class="pull-right">
							<button class="btn btn-success" type="submit" id="addeditcomplete">Submit</button> 
							<a class="btn btn-warning" href="<?php echo  url(ADMINSEPARATOR.'/user'); ?>"><i class="fa fa-chevron-left"></i> Back</a>
						</span>
					</div>
					<div class="panel-footer" id="footer2">
						
							<button class="btn btn-success" type="button" id="addeditcomplete_btn">Submit</button> 
							<a class="btn btn-warning" href="<?php echo  url(ADMINSEPARATOR.'/user'); ?>"><i class="fa fa-chevron-left"></i> Back</a>
					
					</div>
					<?php echo Form::close();?>
				</div><!-- /panel -->
    
	 <!-- for country respective state dorpdown js starts -->
	<!-- <script type="text/javascript" src="{{ URL::asset('public/admin')}}/otherfiles/progjs/countrywisestatelist.js"></script> -->
	<script type="text/javascript" src="{{ ADMINCSSPATH}}/otherfiles/progjs/countrywisestatelist.js"></script>
	<!-- for country respective state dorpdown js ends -->
	<script>
	var typeflag = '<?php echo $formfortype;?>';
	</script>
@endsection