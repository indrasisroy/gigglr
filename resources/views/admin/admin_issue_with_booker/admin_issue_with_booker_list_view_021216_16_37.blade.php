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
<?php

if(!empty($pagi_country))
{
foreach($pagi_country as $countries_obj)
{

	$id=$countries_obj->id;
    $description=$countries_obj->issue_description;
	$leave_early=$countries_obj->leave_early;
	$arrival_time=$countries_obj->arrival;
	$receive_rider=$countries_obj->receive_rider;
	$technical_issue=$countries_obj->technical_issue;
	$able_to_complete=$countries_obj->able_to_complete;
	$required_specifications_availability=$countries_obj->required_specifications_availability;
$arrivaldate=$countries_obj->arrival_time;
}
?>
@extends('layouts.admin.adminmaster',['successmsg' => $successmsg,'errormsg'=>$errormsg])
@section('content')
<div class="padding-md">
<div class="row">
<div class="col-md-8 col-md-offset-2">
<div class="panel panel-default">
<div class="panel-heading">
Issue with Booker details
</div>
<div class="panel-body">
<div class="form-group row">
<label class="control-label col-sm-6">Did you get to the gig?</label>
<div class="col-sm-6">

<?php
if($getting_gig=1){
	echo"Yes";
}else{
	echo"No";
}
?>
<span  class="errorcustclass"></span>
</div>
</div>
<div class="form-group row">
<label class="control-label col-sm-6">What time did you arrive?</label>
<div class="col-sm-6">   
<?php

echo date('h:i A', strtotime($arrivaldate));
?> 
<span  class="errorcustclass"></span>									
</div>
</div>
<div class="form-group row">
<label class="control-label col-sm-6">Were you able to commence the gig with your required specification?</label>
<div class="col-sm-6" >
<?php
if($commencing_gig=1){
	echo"Yes";
}else{
	echo"No";
}
?>
<span  class="errorcustclass"></span>										
</div>
</div>
<div class="form-group row">
<label class="control-label col-sm-6">Did any technical issues arise during your gig?</label>
<div class="col-sm-6">
<?php
if($technical_issue=1){
	echo"Yes";
}else{
	echo"No";
}
?>
<span  class="errorcustclass"></span>											
</div>
</div>
<div class="form-group row">
<label class="control-label col-sm-6">Were you able to complete the gig with your required specifications?</label>
<div class="col-sm-6">
<?php
if($required_specifications_availability=1){
	echo"Yes";
}else{
	echo"No";
}
?>
<span  class="errorcustclass"></span>									
</div>
</div>
<div class="form-group row">
<label class="control-label col-sm-6">Did you receive your rider?</label>
<div class="col-sm-6">
<?php
if($receive_rider=1){
	echo"Yes";
}else{
	echo"No";
}
?>
<span  class="errorcustclass"></span>									
</div>
</div>
<div class="form-group row">
<label class="control-label col-sm-6">Did you leave early?</label>
<div class="col-sm-6">
<?php
if($leave_early=1){
	echo"Yes";
}else{
	echo"No";
}
?>
<span  class="errorcustclass"></span>									
</div>
</div>
<div class="form-group row">
<label class="control-label col-sm-6">Booker Nickname</label>
<div class="col-sm-6">
<?php echo stripslashes($user_master[0]->nickname); ?>
<span  class="errorcustclass"></span>
</div>
</div>
<div class="form-group row">
<label class="control-label col-sm-6">Booker E-mail</label>
<div class="col-sm-6">
<?php echo stripslashes($user_master[0]->email); ?>
<span  class="errorcustclass"></span>
</div>
</div>
<div class="form-group row">
<label class="control-label col-sm-6">Issue Description</label>
<div class="col-sm-6">                                        
<!--<textarea id="techspecs" class="form-control input-sm parsley-validated " name="techspecs" cols="50" rows="10">-->
{{$description}}  
<!--</textarea>-->
<span class="errorcustclass"></span>
</div>
<span  class="errorcustclass"></span>
</div>
</div>
<div class="panel-footer">
<a class="btn btn-warning" href="<?php echo  url(ADMINSEPARATOR.'/admin_issue_with_booker'); ?>"><i class="fa fa-chevron-left"></i> Back</a>
</div>
<?php
echo Form::close();
?>
</div>
</div>
</div>
</div>
@endsection


