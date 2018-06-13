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
	$package_categ_id='';$package_type_id='';$package_price='';$package_expiry='';$status='';
	$create_date='';$modified_date='';$id=0; $package_categ_id_data=array(); $package_type_id_data=array();
	
	if(!empty($packagerow))
	{
		$package_categ_id=stripslashes($packagerow->package_categ_id);
		$package_type_id=stripslashes($packagerow->package_type_id);
		$package_price=stripslashes($packagerow->package_price);
		$package_expiry=stripslashes($packagerow->package_expiry);
		$status=stripslashes($packagerow->status);
		 $id=$packagerow->id;
		 
		 
	}
	
	if(!empty($package_categAr))
	{
		$package_categ_id_data=$package_categAr;
	}
	
	if(!empty($package_typeAr))
	{
		$package_type_id_data=$package_typeAr;
	}
	

	
	?>
			<div class="padding-md">
				<div class="row">
					<div class="col-md-8 col-md-offset-2">
						<div class="panel panel-default">
							
								
								<?php echo Form::open(array('url' => ADMINSEPARATOR.'/packagesave', 'method' => 'post','id'=>'packageaddfrmid','class'=>"form-horizontal form-border no-margin" )); ?>
								<div class="panel-heading">
								 Save Package
								</div>
								<div class="panel-body">
								
								
									<div class="form-group">
										<label class="control-label col-lg-4">*Package category</label>
										<div class="col-lg-6">
											
	<?php    
   echo Form::select('package_categ_id',$package_categ_id_data , $package_categ_id,$attributes = array( "id"=>"package_categ_id","class"=>"form-control input-sm parsley-validated"));
   ?>
	
	<span  class="errorcustclass">{{ $errors->first('package_categ_id') }}</span>

										</div><!-- /.col -->
									</div><!-- /form-group -->
									<div class="form-group">
										<label class="control-label col-lg-4">*Package type  </label>
										<div class="col-lg-6">
											
	<?php    
   echo Form::select('package_type_id',$package_type_id_data , $package_type_id,$attributes = array( "id"=>"package_type_id","class"=>"form-control input-sm parsley-validated"));
   ?>
	<span  class="errorcustclass">{{ $errors->first('package_type_id') }}</span>									
										</div><!-- /.col -->
									</div><!-- /form-group -->
									<div class="form-group">
										<label class="control-label col-lg-4">*Package Price ($) </label>
										<div class="col-lg-6">
											<?php    
    echo Form::text("package_price", $value=$package_price, $attributes = array( "id"=>"package_price","class"=>" form-control input-sm parsley-validated ")); ?>
	<span  class="errorcustclass">{{ $errors->first('package_price') }}</span>										
										</div><!-- /.col -->
									</div><!-- /form-group -->
									<div class="form-group">
										<label class="control-label col-lg-4">*Package Expiry (Days)</label>
										<div class="col-lg-6">
											<?php    
    echo Form::text("package_expiry", $value=$package_expiry, $attributes = array( "id"=>"package_expiry","class"=>" form-control input-sm parsley-validated ")); ?>
	<span  class="errorcustclass">{{ $errors->first('package_expiry') }}</span>											
										</div><!-- /.col -->
									</div><!-- /form-group -->
									
									
								</div>
								<div class="panel-footer ">
								
									<button class="btn btn-success" type="submit">Submit</button>
									<a class="btn btn-warning" href="<?php echo  url(ADMINSEPARATOR.'/package'); ?>"><i class="fa fa-chevron-left"></i> Back</a>
								</div>
									<input type="hidden" name="packageid" value="<?php echo $id; ?>" >
							<?php
							
							echo Form::close();
							
							?>
						</div><!-- /panel -->
					</div>
					</div>
			</div><!-- /.padding-md -->

			
    
@endsection