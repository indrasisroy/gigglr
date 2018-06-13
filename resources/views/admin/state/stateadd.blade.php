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
	$state_name='';$state_2_code='';$state_3_code='';$lat='';$lng='';$id=0; $country_id_data=array(); $country_id=0;
	if(!empty($staterow))
	{
		$state_name=stripslashes($staterow->state_name);
		$state_2_code=stripslashes($staterow->state_2_code);
		$state_3_code=stripslashes($staterow->state_3_code);
		$lat=stripslashes($staterow->lat);
		$lng=stripslashes($staterow->lng);
		 $id=$staterow->id;
		  $country_id=$staterow->country_id;
	}
	
	if(!empty($countryidAr))
	{
		$country_id_data=$countryidAr;
	}
	
	
	
	?>
			<div class="padding-md">
				<div class="row">
					<div class="col-md-8 col-md-offset-2">
						<div class="panel panel-default">
							
								
								<?php echo Form::open(array('url' => ADMINSEPARATOR.'/statesave', 'method' => 'post','id'=>'stateaddfrmid','class'=>"form-horizontal form-border no-margin" )); ?>
								<div class="panel-heading">
								 Save State
								</div>
								<div class="panel-body">
								
								
									<div class="form-group">
										<label class="control-label col-lg-4">*Country </label>
										<div class="col-lg-6">
											
											<?php    
   echo Form::select('country_id',$country_id_data , $country_id,$attributes = array( "id"=>"country_id","class"=>"form-control input-sm parsley-validated"));
   ?>

	<span  class="errorcustclass">{{ $errors->first('country_id') }}</span>

										</div><!-- /.col -->
									</div><!-- /form-group -->
									
									<div class="form-group">
										<label class="control-label col-lg-4">*State Name</label>
										<div class="col-lg-6">
											
											<?php    
    echo Form::text("state_name", $value=$state_name, $attributes = array( "id"=>"state_name","class"=>" form-control input-sm parsley-validated ")); ?>
	<span  class="errorcustclass">{{ $errors->first('state_name') }}</span>

										</div><!-- /.col -->
									</div><!-- /form-group -->
									

									<div class="form-group">
										<label class="control-label col-lg-4">*State 3 Letter Code</label>
										<div class="col-lg-6">
											<?php    
    echo Form::text("state_3_code", $value=$state_3_code, $attributes = array( "id"=>"state_3_code","class"=>" form-control input-sm parsley-validated ")); ?>
	<span  class="errorcustclass">{{ $errors->first('state_3_code') }}</span>										
										</div><!-- /.col -->
									</div><!-- /form-group -->
									<div class="form-group">
										<label class="control-label col-lg-4">*Latitude</label>
										<div class="col-lg-6">
											<?php    
    echo Form::text("lat", $value=$lat, $attributes = array( "id"=>"lat","class"=>" form-control input-sm parsley-validated ")); ?>
	<span  class="errorcustclass">{{ $errors->first('lat') }}</span>											
										</div><!-- /.col -->
									</div><!-- /form-group -->
									<div class="form-group">
										<label class="control-label col-lg-4">*Longitude</label>
										<div class="col-lg-6">
											<?php    
    echo Form::text("lng", $value=$lng, $attributes = array( "id"=>"lng","class"=>" form-control input-sm parsley-validated ")); ?>
	<span  class="errorcustclass">{{ $errors->first('lng') }} </span>									
										</div><!-- /.col -->
									</div><!-- /form-group -->
									
								</div>
								<div class="panel-footer ">
								
									<button class="btn btn-success" type="submit">Submit</button>
									<a class="btn btn-warning" href="<?php echo  url(ADMINSEPARATOR.'/state'); ?>"><i class="fa fa-chevron-left"></i> Back</a>
								</div>
									<input type="hidden" name="stateid" value="<?php echo $id; ?>" >
							<?php
							
							echo Form::close();
							
							?>
						</div><!-- /panel -->
					</div>
					</div>
			</div><!-- /.padding-md -->

			
    
@endsection