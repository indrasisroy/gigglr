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
	$language_name='';$language_3_code='';$id=0;
	if(!empty($languagerow))
	{
		$language_name=stripslashes($languagerow->language_name);
		$language_3_code=stripslashes($languagerow->language_3_code);
		$id=$languagerow->id; 
	}
	?>
	<div class="padding-md">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<div class="panel panel-default">
					<?php echo Form::open(array('url' => ADMINSEPARATOR.'/languagesave', 'method' => 'post','id'=>'languageaddfrmid','class'=>"form-horizontal form-border no-margin" )); ?>
					<div class="panel-heading">
						Save Language
					</div>
					<div class="panel-body">
						<div class="form-group">
							<label class="control-label col-lg-4">Language Name</label>
							<div class="col-lg-6">
								<?php echo Form::text("language_name", $value=$language_name, $attributes = array( "id"=>"language_name","class"=>" form-control input-sm parsley-validated ")); ?>
								<span  class="errorcustclass">{{ $errors->first('language_name') }}</span>
							</div><!-- /.col -->
						</div><!-- /form-group -->
						<div class="form-group">
							<label class="control-label col-lg-4">Language 3 Letter Code</label>
							<div class="col-lg-6">
								<?php echo Form::text("language_3_code", $value=$language_3_code, $attributes = array( "id"=>"language_3_code","class"=>" form-control input-sm parsley-validated ")); ?>
								<span  class="errorcustclass">{{ $errors->first('language_3_code') }}</span>								</div><!-- /.col -->
						</div><!-- /form-group -->	
					</div>
					<div class="panel-footer ">
						<button class="btn btn-success" type="submit">Submit</button>
						<a class="btn btn-warning" href="<?php echo  url(ADMINSEPARATOR.'/language'); ?>"><i class="fa fa-chevron-left"></i> Back</a>
					</div>
					<input type="hidden" name="languageid" value="<?php echo $id; ?>" >
					<?php
					echo Form::close();
					?>
				</div><!-- /panel -->
			</div>
		</div>
	</div><!-- /.padding-md -->
			
@endsection