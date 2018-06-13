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
	$first_name='';$last_name='';$username='';$email='';$uid='';
	if(!empty($userrow))
	{
		$first_name=stripslashes($userrow->first_name);
		$last_name=stripslashes($userrow->last_name);
		$username=$userrow->username;
		$email=$userrow->email;
		$uid=$userrow->id;
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
										<label class="control-label col-lg-4">Email</label>
										<div class="col-lg-6">
											<?php    
    echo Form::text("email", $value=$email, $attributes = array( "id"=>"email","class"=>" form-control input-sm parsley-validated ")); ?>
	<span  class="errorcustclass">{{ $errors->first('email') }}</span>										
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

    
@endsection