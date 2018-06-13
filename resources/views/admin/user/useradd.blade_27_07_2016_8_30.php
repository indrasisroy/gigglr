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

?>
@extends('layouts.admin.adminmaster',['successmsg' => $successmsg,'errormsg'=>$errormsg])
@section('content')
	<?php
	$uid=''; $first_name=''; $middle_name=''; $last_name=''; $username=''; $nickname=''; $email=''; $oldpass=''; $gen=''; $address1=''; $address2=''; $country_id='';$state_id=''; $city=''; $zip=''; $language_id=''; $skill_id=''; $subskill_id=''; $abn=''; $gst=''; $tfn=''; $currency=''; $rider=''; $description=''; $fburl=''; $soundcloudurl=''; $residentadvisorurl=''; $twitterurl=''; $youtubeurl=''; $instagramurl='';
	$country_id_data=array(); $language_id_data=array(); $skill_id_data=array(); $currency_id_data=array();
	
	if(!empty($userrow))
	{
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
	}
	if(!empty($countryidAr))
	{
		$country_id_data=$countryidAr;
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
	?>
			<div class="padding-md">
				<div class="row">
					<div class="col-md-8 col-md-offset-2">
						<div class="panel panel-default">
							
								
								<?php echo Form::open(array('url' => ADMINSEPARATOR.'/usersave', 'method' => 'post','id'=>'useraddfrmid','class'=>"form-horizontal form-border no-margin" )); ?>
								<div class="panel-heading">
								 Save User
								</div>
								<div class="panel-body">
								
								
									<div class="form-group">
										<label class="control-label col-lg-4">First Name</label>
										<div class="col-lg-6">
											
											<?php    
    echo Form::text("first_name", $value=$first_name, $attributes = array( "id"=>"first_name","class"=>" form-control input-sm parsley-validated ")); ?>
	<span  class="errorcustclass">{{ $errors->first('first_name') }}</span>

										</div><!-- /.col -->
									</div><!-- /form-group -->
									
									<div class="form-group">
										<label class="control-label col-lg-4">Middle Name</label>
										<div class="col-lg-6">
											<?php    
    echo Form::text("middle_name", $value=$middle_name, $attributes = array( "id"=>"middle_name","class"=>" form-control input-sm parsley-validated ")); ?>
											<span  class="errorcustclass">{{ $errors->first('middle_name') }}</span>
										</div><!-- /.col -->
									</div><!-- /form-group -->
									
									<div class="form-group">
										<label class="control-label col-lg-4">Last Name</label>
										<div class="col-lg-6">
											
											<?php    
    echo Form::text("last_name", $value=$last_name, $attributes = array( "id"=>"last_name","class"=>" form-control input-sm parsley-validated ")); ?>
	<span  class="errorcustclass">{{ $errors->first('last_name') }}</span>

										</div><!-- /.col -->
									</div><!-- /form-group -->
									<div class="form-group">
										<label class="control-label col-lg-4">Username </label>
										<div class="col-lg-6">
											<?php    
    echo Form::text("username", $value=$username, $attributes = array( "id"=>"username","class"=>" form-control input-sm parsley-validated ")); ?>
	<span  class="errorcustclass">{{ $errors->first('username') }}</span>									
										</div><!-- /.col -->
									</div><!-- /form-group -->
									
									<div class="form-group">
										<label class="control-label col-lg-4">Nickname</label>
										<div class="col-lg-6">										
											<?php    
    echo Form::text("nickname", $value=$nickname, $attributes = array( "id"=>"nickname","class"=>" form-control input-sm parsley-validated ")); ?>
											<span  class="errorcustclass">{{ $errors->first('nickname') }}</span>
										</div><!-- /.col -->
									</div><!-- /form-group -->
									
									<div class="form-group">
										<label class="control-label col-lg-4">Email</label>
										<div class="col-lg-6">
											<?php    
    echo Form::text("email", $value=$email, $attributes = array( "id"=>"email","class"=>" form-control input-sm parsley-validated ")); ?>
	<span  class="errorcustclass">{{ $errors->first('email') }}</span>										
										</div><!-- /.col -->
									</div><!-- /form-group -->
									
									<div class="form-group">
										<label class="control-label col-lg-4">Password</label>
										<div class="col-lg-6">
											
											<?php
											$passval='';
    echo Form::text("newpass", $value=$passval, $attributes = array( "id"=>"newpass","class"=>" form-control input-sm parsley-validated ")); ?>
	<span  class="errorcustclass">{{ $errors->first('newpass') }}</span>

										</div><!-- /.col -->
									</div><!-- /form-group -->
									
	<?php echo Form::hidden("oldpass", $value=$oldpass, $attributes = array( "id"=>"oldpass","class"=>" form-control input-sm parsley-validated ")); ?>
									
									<div class="form-group">
										<label class="control-label col-lg-4">Gender</label>
										<div class="col-lg-6">
											<?php    
   echo Form::select('gender', array(''=>'Choose gender', '1'=>'Male', '2'=>'Female', '3'=>'Other'), $gen,$attributes = array("id"=>"gender","class"=>"form-control input-sm parsley-validated"));
   ?>
   <span  class="errorcustclass">{{ $errors->first('gender') }}</span>	
										</div><!-- /.col -->
									</div><!-- /form-group -->
									
									<div class="form-group">
										<label class="control-label col-lg-4">Address 1</label>
										<div class="col-lg-6">
											
											<?php    
    echo Form::text("address1", $value=$address1, $attributes = array( "id"=>"address1","class"=>" form-control input-sm parsley-validated ")); ?>
	<span  class="errorcustclass">{{ $errors->first('address1') }}</span>

										</div><!-- /.col -->
									</div><!-- /form-group -->
									
									<div class="form-group">
										<label class="control-label col-lg-4">Address 2</label>
										<div class="col-lg-6">
											
											<?php    
    echo Form::text("address2", $value=$address2, $attributes = array( "id"=>"address2","class"=>" form-control input-sm parsley-validated ")); ?>
	<span  class="errorcustclass">{{ $errors->first('address2') }}</span>

										</div><!-- /.col -->
									</div><!-- /form-group -->
									
									<div class="form-group">
										<label class="control-label col-lg-4">Country</label>
										<div class="col-lg-6">
											
											<?php    
   echo Form::select('country_id',$country_id_data , $country_id,$attributes = array( "id"=>"country_id","class"=>"form-control input-sm parsley-validated"));
   ?>

	<span  class="errorcustclass">{{ $errors->first('country_id') }}</span>

										</div><!-- /.col -->
									</div><!-- /form-group -->
									
									<div class="form-group">
										<label class="control-label col-lg-4">State</label>
										<div class="col-lg-6">
   
											<?php
												$admin_control_attrAr=array();
												$admin_control_attrAr['id']='state_id';
												$admin_control_attrAr['class']="selectpicker form-control input-sm parsley-validated";
												$fetchstateidData=array();
												echo Form::select('state_id', $fetchstateidData, $state_id,$admin_control_attrAr);							
											?>

	<span  class="errorcustclass">{{ $errors->first('state_id') }}</span>

										</div><!-- /.col -->
									</div><!-- /form-group -->
									
									<div class="form-group">
										<label class="control-label col-lg-4">City</label>
										<div class="col-lg-6">
											
											<?php    
    echo Form::text("city", $value=$city, $attributes = array( "id"=>"city","class"=>" form-control input-sm parsley-validated ")); ?>
	<span  class="errorcustclass">{{ $errors->first('city') }}</span>

										</div><!-- /.col -->
									</div><!-- /form-group -->
									
									<div class="form-group">
										<label class="control-label col-lg-4">Zip</label>
										<div class="col-lg-6">
											
											<?php    
    echo Form::text("zip", $value=$zip, $attributes = array( "id"=>"zip","class"=>" form-control input-sm parsley-validated ")); ?>
	<span  class="errorcustclass">{{ $errors->first('zip') }}</span>

										</div><!-- /.col -->
									</div><!-- /form-group -->
									
									<div class="form-group">
										<label class="control-label col-lg-4">Language</label>
										<div class="col-lg-6">
											
											<?php    
   echo Form::select('language_id',$language_id_data , $language_id,$attributes = array( "id"=>"language_id","class"=>"form-control input-sm parsley-validated"));
   ?>

	<span  class="errorcustclass">{{ $errors->first('language_id') }}</span>

										</div><!-- /.col -->
									</div><!-- /form-group -->
									
									<div class="form-group">
										<label class="control-label col-lg-4">Skill</label>
										<div class="col-lg-6">
											
											<?php    
   echo Form::select('skill_id',$skill_id_data,$skill_id,$attributes=array( "id"=>"skill_id","class"=>"form-control input-sm parsley-validated"));
   ?>

	<span  class="errorcustclass">{{ $errors->first('skill_id') }}</span>

										</div><!-- /.col -->
									</div><!-- /form-group -->
									
									<div class="form-group">
										<label class="control-label col-lg-4">Sub-skill</label>
										<div class="col-lg-6">
   
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
										<div class="col-lg-6">
											
											<?php    
    echo Form::text("abn", $value=$abn, $attributes = array( "id"=>"abn","class"=>" form-control input-sm parsley-validated ")); ?>
	<span  class="errorcustclass">{{ $errors->first('abn') }}</span>

										</div><!-- /.col -->
									</div><!-- /form-group -->
									
									<div class="form-group">
										<label class="control-label col-lg-4">GST</label>
										<div class="col-lg-6">
											<?php    
   echo Form::select('gst', array('1'=>'Yes', '0'=>'No'), $gst,$attributes = array("id"=>"gst","class"=>"form-control input-sm parsley-validated"));
   ?>
   <span  class="errorcustclass">{{ $errors->first('gst') }}</span>	
										</div><!-- /.col -->
									</div><!-- /form-group -->
									
									<div class="form-group" id="tfndiv">
										<label class="control-label col-lg-4">TFN</label>
										<div class="col-lg-6">
											
											<?php    
    echo Form::text("tfn", $value=$tfn, $attributes = array( "id"=>"tfn","class"=>" form-control input-sm parsley-validated ")); ?>
	<span  class="errorcustclass">{{ $errors->first('tfn') }}</span>

										</div><!-- /.col -->
									</div><!-- /form-group -->
									
									<div class="form-group">
										<label class="control-label col-lg-4">Currency</label>
										<div class="col-lg-6">
											
											<?php    
   echo Form::select('currency',$currency_id_data , $currency,$attributes = array( "id"=>"currency","class"=>"form-control input-sm parsley-validated"));
   ?>

	<span  class="errorcustclass">{{ $errors->first('currency') }}</span>

										</div><!-- /.col -->
									</div><!-- /form-group -->
									
									<div class="form-group">
                                        <label class="control-label col-lg-4">Rider</label>
                                        <div class="col-lg-6">
											<?php 
												echo Form::textarea("rider", $value=$rider, $attributes = array("id"=>"rider","class"=>"form-control input-sm"));
											?>
											<span  class="errorcustclass">{{ $errors->first('rider') }}</span>
                                        </div><!-- /.col -->
                                    </div>
										
									<div class="form-group">
                                        <label class="col-lg-4 control-label">Description</label>
                                        <div class="col-lg-6">
											<?php 
												echo Form::textarea("description", $value=$description, $attributes = array("id"=>"description","class"=>"form-control input-sm"));
											?>
											<span  class="errorcustclass">{{ $errors->first('description') }}</span>
                                        </div><!-- /.col -->
                                    </div>
									
									<div class="form-group">
										<label class="control-label col-lg-4">Facebook URL</label>
										<div class="col-lg-6">										
											<?php echo Form::text("fburl", $value=$fburl, $attributes = array("id"=>"fburl","class"=>"form-control input-sm parsley-validated ")); ?>
											<span  class="errorcustclass">{{ $errors->first('fburl') }}</span>
										</div><!-- /.col -->
									</div><!-- /form-group -->
									
									<div class="form-group">
										<label class="control-label col-lg-4">Soundcloud URL</label>
										<div class="col-lg-6">										
											<?php echo Form::text("soundcloudurl", $value=$soundcloudurl, $attributes = array("id"=>"soundcloudurl","class"=>"form-control input-sm parsley-validated ")); ?>
											<span  class="errorcustclass">{{ $errors->first('soundcloudurl') }}</span>
										</div><!-- /.col -->
									</div><!-- /form-group -->
									
									<div class="form-group">
										<label class="control-label col-lg-4">Residentadvisor URL</label>
										<div class="col-lg-6">										
											<?php echo Form::text("residentadvisorurl", $value=$residentadvisorurl, $attributes = array("id"=>"residentadvisorurl","class"=>"form-control input-sm parsley-validated ")); ?>
											<span  class="errorcustclass">{{ $errors->first('residentadvisorurl') }}</span>
										</div><!-- /.col -->
									</div><!-- /form-group -->
									
									<div class="form-group">
										<label class="control-label col-lg-4">Twitter URL</label>
										<div class="col-lg-6">										
											<?php echo Form::text("twitterurl", $value=$twitterurl, $attributes = array("id"=>"twitterurl","class"=>"form-control input-sm parsley-validated ")); ?>
											<span  class="errorcustclass">{{ $errors->first('twitterurl') }}</span>
										</div><!-- /.col -->
									</div><!-- /form-group -->
									
									<div class="form-group">
										<label class="control-label col-lg-4">Youtube URL</label>
										<div class="col-lg-6">										
											<?php echo Form::text("youtubeurl", $value=$youtubeurl, $attributes = array("id"=>"youtubeurl","class"=>"form-control input-sm parsley-validated ")); ?>
											<span  class="errorcustclass">{{ $errors->first('youtubeurl') }}</span>
										</div><!-- /.col -->
									</div><!-- /form-group -->
									
									<div class="form-group">
										<label class="control-label col-lg-4">Instagram URL</label>
										<div class="col-lg-6">										
											<?php echo Form::text("instagramurl", $value=$instagramurl, $attributes = array("id"=>"instagramurl","class"=>"form-control input-sm parsley-validated ")); ?>
											<span  class="errorcustclass">{{ $errors->first('instagramurl') }}</span>
										</div><!-- /.col -->
									</div><!-- /form-group -->
									
								</div>
								<div class="panel-footer ">
								
									<button class="btn btn-success" type="submit">Submit</button>
									<a class="btn btn-warning" href="<?php echo  url(ADMINSEPARATOR.'/user'); ?>"><i class="fa fa-chevron-left"></i> Back</a>
								</div>
									<input type="hidden" name="uid" value="<?php echo $uid; ?>" >
							<?php
							
							echo Form::close();
							
							?>
						</div><!-- /panel -->
					</div>
					</div>
			</div><!-- /.padding-md -->

    
	 <!-- for country respective state dorpdown js starts -->
	<script type="text/javascript" src="{{ URL::asset('public/admin')}}/otherfiles/progjs/countrywisestatelist.js"></script>
	<!-- for country respective state dorpdown js ends -->
	
@endsection