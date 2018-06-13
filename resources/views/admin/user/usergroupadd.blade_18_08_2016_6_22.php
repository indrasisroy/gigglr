<?php

	 $formfortype = Request::segment(3); 
	 $ucreaterid = Request::segment(4); 
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
	$date='';$pagemeta='';$venuerow_press_kit='';$uvenue_id='';$venuerowmenu='';$select_amenity =array();$user_status = '';
	if(!empty($uservenuerow))
	{
		
		$uid=$uservenuerow->id; 
		$ucreaterid=$uservenuerow->creater_id;
		$nickname=stripslashes(ucfirst($uservenuerow->nickname));

		$address1=stripslashes($uservenuerow->address_1);
		$address2=stripslashes($uservenuerow->address_2);
	 	$country_id=$uservenuerow->country; 
		$state_id=$uservenuerow->state;
		$city=stripslashes($uservenuerow->city);
		$zip=$uservenuerow->zip;
		
		$abn=$uservenuerow->abn_data;
		$gst=$uservenuerow->gst_status;
		$tfn=$uservenuerow->tfn_data;
		
		$rider=$uservenuerow->rider_data;
		$description=$uservenuerow->group_description;
		$fburl=$uservenuerow->facebook_url;
		$soundcloudurl=$uservenuerow->soundcloud_url;
		$residentadvisorurl=$uservenuerow->residentadvisor_url;
		$twitterurl=$uservenuerow->twitter_url;
		$youtubeurl=$uservenuerow->youtube_url;
		$instagramurl=$uservenuerow->instagram_url;

		$pagemeta = $uservenuerow->group_meta_data;

		
	}
	if(!empty($countryidAr))
	{
		$country_id_data=$countryidAr;
	}
	if(!empty($stateidAr))
	{
		$fetchstateidData=$stateidAr;
	}
	
	if(!empty($skillidAr))
	{
		$skill_id_data=$skillidAr;
	}
	
	if(!empty($venuerow_press))
	{
		$venuerow_press_kit=$venuerow_press->presskit_name;
	}



		if(!empty($venuerow_menu))
		{
			//echo 'sadsa';

		$venuerowmenu=$venuerow_menu->menu_name;
		}




	if(!empty($qry_select_amenity))
{
	
	$select_amenity=$qry_select_amenity;
	


}
if($user_status_chk == 0 || $user_status_chk > 0)
{
	$user_status = $user_status_chk;
}

// echo "<pre>";
// print_r($uvenue_id);die;
// 	if(!empty($uvenue_id))
// 	{
// 		echo 'erere';

// 		echo $uvenue_id=$uvenue_id; die;
// 	}
				
	?>
			
			<div class="panel panel-default">
					<div class="panel-heading">
						Save Group
					</div>


					<div class="panel-tab">	
						<ul class="wizard-steps" id="wizardTab"> 
							<li class="active">
								<a href="#wizardContent1" data-toggle="tab">Account Info</a>
							</li> 
							<li>
								<a href="#wizardContent2" data-toggle="tab">Social links</a>
							</li> 
							<li>
								<a href="#wizardContent3" data-toggle="tab">Profile Info</a>
							</li>
						</ul>
					</div>
					<div class="panel-body">
						<?php echo Form::open(array('url' => ADMINSEPARATOR.'/usergroupsave','files' => true, 'method' => 'post','id'=>'uservenueaddfrmid','class'=>"form-horizontal form-border no-margin" )); ?>
						<div class="tab-content">


						<!-- Basic information content	starts	 -->


							<div class="tab-pane fade in active" id="wizardContent1">
								
									
									
									
													<div class="form-group">
													<label class="control-label col-lg-4">Group Name</label>
													<div class="col-lg-4">

													<?php    
													echo Form::text("nickname", $value=$nickname, $attributes = array( "id"=>"nickname","class"=>" form-control input-sm parsley-validated ")); ?>
													<span  class="errorcustclass">{{ $errors->first('nickname') }}</span>

													</div><!-- /.col -->
													</div><!-- /form-group --><!--/ Nickname-->
													

													<div class="form-group">
													<label class="control-label col-lg-4">Address 1</label>
													<div class="col-lg-4">

													<?php    
													echo Form::text("address1", $value=$address1, $attributes = array( "id"=>"address1","class"=>" form-control input-sm parsley-validated ")); ?>
													<span  class="errorcustclass">{{ $errors->first('address1') }}</span>

													</div><!-- /.col -->
													</div><!-- /form-group --><!--/ Address1-->

													<div class="form-group">
													<label class="control-label col-lg-4">Address 2</label>
													<div class="col-lg-4">

													<?php    
													echo Form::text("address2", $value=$address2, $attributes = array( "id"=>"address2","class"=>" form-control input-sm parsley-validated ")); ?>
													<span  class="errorcustclass">{{ $errors->first('address2') }}</span>

													</div><!-- /.col -->
													</div><!-- /form-group --><!--/ Address2-->

													<div class="form-group">
													<label class="control-label col-lg-4">Country</label>
													<div class="col-lg-4">

													<?php    
													echo Form::select('country_id',$country_id_data , $country_id,$attributes = array( "id"=>"country_id","class"=>"form-control input-sm parsley-validated"));
													?>

													<span  class="errorcustclass">{{ $errors->first('country_id') }}</span>

													</div><!-- /.col -->
													</div><!-- /form-group --><!--/ Country-->

													<div class="form-group">
													<label class="control-label col-lg-4">State</label>
													<div class="col-lg-4">

													<?php
													// $admin_control_attrAr=array();
													// $admin_control_attrAr['id']='state_id';
													// $admin_control_attrAr['class']="form-control input-sm parsley-validated";
													// $fetchstateidData=array();

													// echo "<pre>";
													// print_r($fetchstateidData);
													echo Form::select('state_id', $fetchstateidData, $state_id,$attributes = array( "id"=>"state_id","data-venueid"=>"venueIDchk","class"=>"form-control input-sm parsley-validated"));							
													?>

													<span  class="errorcustclass">{{ $errors->first('state_id') }}</span>

													</div><!-- /.col -->
													</div><!-- /form-group --><!--/ State-->

													<div class="form-group">
													<label class="control-label col-lg-4">City</label>
													<div class="col-lg-4">

													<?php    
													echo Form::text("city", $value=$city, $attributes = array( "id"=>"city","class"=>" form-control input-sm parsley-validated ")); ?>
													<span  class="errorcustclass">{{ $errors->first('city') }}</span>

													</div><!-- /.col -->
													</div><!-- /form-group --><!--/ City-->

													<div class="form-group">
													<label class="control-label col-lg-4">Zip</label>
													<div class="col-lg-4">

													<?php    
													echo Form::text("zip", $value=$zip, $attributes = array( "id"=>"zip","class"=>" form-control input-sm parsley-validated ")); ?>
													<span  class="errorcustclass">{{ $errors->first('zip') }}</span>

													</div><!-- /.col -->
													</div><!-- /form-group --><!--/ Zip-->

												
									
							</div>

							<!-- Account content	starts	 -->

							<div class="tab-pane fade" id="wizardContent2">
							


														<div class="form-group">
														<label class="control-label col-lg-4">Facebook URL</label>
														<div class="col-lg-4">										
														<?php echo Form::text("fburl", $value=$fburl, $attributes = array("id"=>"fburl","class"=>"form-control input-sm parsley-validated ")); ?>
														<span  class="errorcustclass">{{ $errors->first('fburl') }}</span>
														</div><!-- /.col -->
														</div><!-- /form-group --><!--/ Facebook URL-->

														<div class="form-group">
														<label class="control-label col-lg-4">Soundcloud URL</label>
														<div class="col-lg-4">										
														<?php echo Form::text("soundcloudurl", $value=$soundcloudurl, $attributes = array("id"=>"soundcloudurl","class"=>"form-control input-sm parsley-validated ")); ?>
														<span  class="errorcustclass">{{ $errors->first('soundcloudurl') }}</span>
														</div><!-- /.col -->
														</div><!-- /form-group --><!--/ Soundcloud URL-->

														<div class="form-group">
														<label class="control-label col-lg-4">Residentadvisor URL</label>
														<div class="col-lg-4">										
														<?php echo Form::text("residentadvisorurl", $value=$residentadvisorurl, $attributes = array("id"=>"residentadvisorurl","class"=>"form-control input-sm parsley-validated ")); ?>
														<span  class="errorcustclass">{{ $errors->first('residentadvisorurl') }}</span>
														</div><!-- /.col -->
														</div><!-- /form-group --><!--/ Residentadvisor URL-->

														<div class="form-group">
														<label class="control-label col-lg-4">Twitter URL</label>
														<div class="col-lg-4">										
														<?php echo Form::text("twitterurl", $value=$twitterurl, $attributes = array("id"=>"twitterurl","class"=>"form-control input-sm parsley-validated ")); ?>
														<span  class="errorcustclass">{{ $errors->first('twitterurl') }}</span>
														</div><!-- /.col -->
														</div><!-- /form-group --><!--/ Twitter URL-->

														<div class="form-group">
														<label class="control-label col-lg-4">Youtube URL</label>
														<div class="col-lg-4">										
														<?php echo Form::text("youtubeurl", $value=$youtubeurl, $attributes = array("id"=>"youtubeurl","class"=>"form-control input-sm parsley-validated ")); ?>
														<span  class="errorcustclass">{{ $errors->first('youtubeurl') }}</span>
														</div><!-- /.col -->
														</div><!-- /form-group --><!--/ Youtube URL-->

														<div class="form-group">
														<label class="control-label col-lg-4">Instagram URL</label>
														<div class="col-lg-4">										
														<?php echo Form::text("instagramurl", $value=$instagramurl, $attributes = array("id"=>"instagramurl","class"=>"form-control input-sm parsley-validated ")); ?>
														<span  class="errorcustclass">{{ $errors->first('instagramurl') }}</span>
														</div><!-- /.col -->
														<input type="hidden" name="uid" value="<?php echo $uid; ?>" >
														<input type="hidden" name="ucreaterid" value="<?php echo $ucreaterid; ?>" >
														<input type="hidden" name="formtype" value="<?php echo $formfortype; ?>" >
														</div><!-- /form-group --><!--/ Instagram URL-->









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
														</div><!-- /form-group --><!--/ -category-->

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
														</div><!-- /form-group --><!--/ Sub-category-->

														<div class="form-group">
														<label class="control-label col-lg-4">ABN</label>
														<div class="col-lg-4">

														<?php    
														echo Form::text("abn", $value=$abn, $attributes = array( "id"=>"abn","class"=>" form-control input-sm parsley-validated ")); ?>
														<span  class="errorcustclass">{{ $errors->first('abn') }}</span>

														</div><!-- /.col -->
														</div><!-- /form-group --><!--/ ABN-->

														<div class="form-group">
														<label class="control-label col-lg-4">GST</label>
														<div class="col-lg-4">
														<?php    
														echo Form::select('gst', array('1'=>'Yes', '0'=>'No'), $gst,$attributes = array("id"=>"gst","class"=>"form-control input-sm parsley-validated"));
														?>
														<span  class="errorcustclass">{{ $errors->first('gst') }}</span>	
														</div><!-- /.col -->
														</div><!-- /form-group --><!--/ GST-->

														<div class="form-group" id="tfndiv">
														<label class="control-label col-lg-4">TFN</label>
														<div class="col-lg-4">

														<?php    
														echo Form::text("tfn", $value=$tfn, $attributes = array( "id"=>"tfn","class"=>" form-control input-sm parsley-validated ")); ?>
														<span  class="errorcustclass">{{ $errors->first('tfn') }}</span>

														</div><!-- /.col -->
														</div><!-- /form-group --><!--/ TFN-->



														<div class="form-group">
														<label class="control-label col-lg-4">Rider</label>
														<div class="col-lg-4">
														<?php 
														echo Form::textarea("rider", $value=$rider, $attributes = array("id"=>"rider","class"=>"form-control input-sm"));
														?>
														<span  class="errorcustclass">{{ $errors->first('rider') }}</span>
														</div><!-- /.col -->
														</div><!--/ Rider-->

														<div class="form-group">
														<label class="control-label col-lg-4">Page Meta Tag</label>
														<div class="col-lg-4">
														<?php 
														echo Form::text("pagemeta", $value=$pagemeta, $attributes = array("id"=>"pagemeta","class"=>"form-control input-sm"));
														?>
														<span  class="errorcustclass">{{ $errors->first('pagemeta') }}</span>
														</div><!-- /.col -->
														</div><!--/ Page Meta Tag-->






														<div class="form-group">
														<label class="col-lg-4 control-label">Description</label>
														<div class="col-lg-4">
														<?php 
														echo Form::textarea("description", $value=$description, $attributes = array("id"=>"description","class"=>"form-control input-sm"));
														?>
														<span  class="errorcustclass">{{ $errors->first('description') }}</span>
														</div><!-- /.col -->
														</div><!--/ description-->



														<div class="form-group">
														<label class="col-lg-4 control-label">Load Press kit</label>
														<div class="col-lg-4">
														<input type="file" name="presskit_name[]" id="presskit_name" class="form-control input-sm"  >

														<span  class="errorcustclass"><?php echo $errors->first('presskit_name') ?> </span>
														</div><!-- /.col -->
														<div class="col-lg-4">
														<!--  <a href="" class="fa fa-download">Download Press kit</a> -->


														<?php 
														if(!empty($venuerow_press_kit))
														{
														$uservnuprskt_data_user = ADMINSEPARATOR.'/usergrouppresskitadmin/'.base64_encode($venuerow_press_kit);
														echo link_to($uservnuprskt_data_user, $title = 'Download press kit', $attributes = array("class"=>"fa fa-download","target"=>"_blank"), $secure = null);
														}

														?>


														</div>

														</div><!--/ Press kit-->

														




														






							</div>
						<!-- 	<div class="tab-pane fade" id="wizardContent4">
									
							</div> -->
						</div>
						
					</div>
					<div class="panel-footer">
						<a class="btn btn-warning" id="prevStepvenue" disabled><i class="fa fa-chevron-left"></i> Previous</a>
						<a class="btn btn-primary" id="nextStepvenue">Next <i class="fa fa-chevron-right"></i></a>
						<span class="pull-right">
							<button class="btn btn-success" type="submit" id="addeditcompletevenue">Submit</button> 
							<a class="btn btn-warning" href="<?php echo  url(ADMINSEPARATOR.'/user'); ?>"><i class="fa fa-chevron-left"></i> Back</a>
						</span>
					</div>
					<!--  -->
					<?php echo Form::close();?>
				</div><!-- /panel -->
    
	 <!-- for country respective state dorpdown js starts -->
	<!-- <script type="text/javascript" src="{{ URL::asset('public/admin')}}/otherfiles/progjs/countrywisestatelist.js"></script> -->
	<script type="text/javascript" src="{{ ADMINCSSPATH}}/otherfiles/progjs/countrywisestatelist.js"></script>
	<!-- for country respective state dorpdown js ends -->
	<script>
	var typeflag = '<?php echo $formfortype;?>';
	var ststus_chk = '<?php echo $user_status;?>';


	if(ststus_chk!=1)
	{
		$("#uservenueaddfrmid input").attr('readonly','readonly');
		$("#country_id").attr('readonly','readonly');
		$("#skill_id").attr('readonly','readonly');
		

		$("#subskill_id").attr('readonly','readonly');
		$("#gst").attr('readonly','readonly');

		$("#rider").attr('readonly','readonly');

		$("#description").attr('readonly','readonly');

		$('[data-venueid="venueIDchk"]').prop('disabled', true);
		//$("#state_id").data('venueid').attr('disabled','disabled');

		$("input.lblcheckbox").attr("disabled", true);
		 
		
		//gst
		
	}

	</script>
@endsection