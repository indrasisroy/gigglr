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
$dispute_resolved_status = '';
if(!empty($pagi_country)){
        
        $id=$pagi_country->id;
        $description=$pagi_country->issue_description;
        $leave_early=$pagi_country->leave_early;
        $arrival_time=$pagi_country->arrival;
        $receive_rider=$pagi_country->receive_rider;
        $technical_issue=$pagi_country->technical_issue;
        $able_to_complete=$pagi_country->able_to_complete;
        $required_specifications_availability=$pagi_country->required_specifications_availability;
        $dispute_resolved_status = $pagi_country->dispute_resolved_status;
    }
?>
@extends('layouts.admin.adminmaster',['successmsg' => $successmsg,'errormsg'=>$errormsg])
@section('content')
<div class="padding-md">
<div class="row">
<div class="col-md-8 col-md-offset-2">
<div class="panel panel-default">
<div class="panel-heading">
Issue with Group details
</div>

<div class="panel-body">
<div class="form-group row">
<label class="control-label col-sm-6">Did the group arrive on time?</label>
<div class="col-sm-6">

<?php
if($arrival_time=='1'){
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

{{ date('h:i A', strtotime($pagi_country->arrival_time)) }}

<span  class="errorcustclass"></span>									
</div>
</div>
<div class="form-group row">
<label class="control-label col-sm-6">Was the groups required specifications available?</label>
<div class="col-sm-6" >
<?php
if($required_specifications_availability=='1'){
	echo"Yes";
}else{
	echo"No";
}
?>
<span  class="errorcustclass"></span>										
</div>
</div>
<div class="form-group row">
<label class="control-label col-sm-6">Was the group able to complete the performance?</label>
<div class="col-sm-6">
<?php
if($able_to_complete=='1'){
	echo"Yes";
}else{
	echo"No";
}
?>
<span  class="errorcustclass"></span>											
</div>
</div>
<div class="form-group row">
<label class="control-label col-sm-6">Were there any technical issues during the performance?</label>
<div class="col-sm-6">
<?php
if($technical_issue=='1'){
	echo"Yes";
}else{
	echo"No";
}
?>
<span  class="errorcustclass"></span>									
</div>
</div>
   
<div class="form-group row"> 
<label class="control-label col-sm-6">Did the group receive their rider?</label>
<div class="col-sm-6">
<?php
if($receive_rider=='1'){
	echo"Yes";
}else{
	echo"No";
}
?>
<span  class="errorcustclass"></span>									
</div>
</div>
    
<div class="form-group row">
<label class="control-label col-sm-6">Did the group (or any members) leave early?</label>
<div class="col-sm-6">
<?php
if($leave_early=='1'){
	echo"Yes";
}else{
	echo"No";
}
?>
<span  class="errorcustclass"></span>									
</div>
</div>
<div class="form-group row">
<label class="control-label col-sm-6">What time did members leave?</label>
<div class="col-sm-6">
	
{{ date('h:i A', strtotime($pagi_country->leaving_time)) }}

<span  class="errorcustclass"></span>									
</div>
</div>
<div class="form-group row">
<label class="control-label col-sm-6">Group Nickname</label>
<div class="col-sm-6">

{{ stripslashes($pagi_country->group_nickname) }}

<span  class="errorcustclass"></span>
</div>
</div>
<div class="form-group row">
<label class="control-label col-sm-6">Group Creator E-mail</label>
<div class="col-sm-6">

{{ stripslashes($pagi_country->group_creater_email) }}

<span  class="errorcustclass"></span>
</div>
</div>
<div class="form-group row">
<label class="control-label col-sm-6">Issue Description</label>
<div class="col-sm-6">                                        

{{ucwords($description)}}  

<span class="errorcustclass"></span>
</div>
<span  class="errorcustclass"></span>
</div>
</div>

<div class="panel-footer">
<a class="btn btn-warning" href="{{ url(ADMINSEPARATOR.'/admin_issue_with_group') }}"><i class="fa fa-chevron-left"></i> Back</a>
<a class="btn btn-success pull-right" href="{{url(ADMINSEPARATOR.'/reply_from_admin_group/'.$id)}}" >    <i class="fa fa-sign-in"></i>
        <?php if($dispute_resolved_status == '1'){
            echo "Show replies";
        }else if($dispute_resolved_status == '0'){
            echo "Reply";
        }?>
    </a>
</div>
<?php
echo Form::close();
?>
</div>
</div>
</div>
</div>
@endsection


