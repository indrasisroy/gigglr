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
if(!empty($pagi_country))
    {
        $id=$pagi_country->id;
        $complained_by=$pagi_country->dispute_opener_id;
        $gig_id=$pagi_country->gig_id;
        $gig_unique_id=$pagi_country->gig_unique_id;
        $dispute_type=$pagi_country->dispute_type;
        $gig_name=$pagi_country->gig_name;
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
Issue with artist details
</div>
<div class="panel-body">
<?php
echo Form::open(array('url' => '','method' =>'post','id'=>'formdisputeid','class'=>"form-horizontal form-border no-margin" ));?>
<div class="form-group row">
<label class="control-label col-sm-6">Gig Name</label>
<div class="col-sm-6">   
{{$gig_name}}
<span  class="errorcustclass"></span>									
</div>
</div>
<div class="form-group row">
<label class="control-label col-sm-6">Did the artist arrive on time?</label>
<div class="col-sm-6">

<?php
    if($arrival=1){
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
    $date=$pagi_country->arrival_time;
    echo date('h:i A', strtotime($date));
?> 
<span  class="errorcustclass"></span>									
</div>
</div>
<div class="form-group row">
<label class="control-label col-sm-6">Were the artists required specifications available?</label>
<div class="col-sm-6" >
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
<label class="control-label col-sm-6">Were the artists able to complete the performance?</label>
<div class="col-sm-6">
<?php
    if($able_to_complete=1){
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
<label class="control-label col-sm-6">Did the artist receive their rider?</label>
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
<label class="control-label col-sm-6">Did the artist leave early?</label>
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
<label class="control-label col-sm-6">What time did the artist(s) leave?</label>
<div class="col-sm-6">
    <?php
        $date=$pagi_country->leaving_time;
        echo date('h:i A', strtotime($date));
    ?> 
<span  class="errorcustclass"></span>									
</div>
</div>
<div class="form-group row">
<label class="control-label col-sm-6">Booker nickname</label>
<div class="col-sm-6">
    {{ stripslashes($pagi_country->nickname) }}
<span  class="errorcustclass"></span>
</div>
</div>
<div class="form-group row">
<label class="control-label col-sm-6">Artist nickname</label>
<div class="col-sm-6">
    {{ stripslashes($pagi_country->artist_nickname) }}
<span  class="errorcustclass"></span>
</div>
</div>
<div class="form-group row">
<label class="control-label col-sm-6">Compalined by(Booker)</label>
<div class="col-sm-6">
    {{stripslashes($pagi_country->email)}}
<span  class="errorcustclass"></span>
</div>
</div>
<div class="form-group row">
<label class="control-label col-sm-6">Compalin against(Artist)</label>
<div class="col-sm-6">
{{ stripslashes($pagi_country->artist_email) }}
<span  class="errorcustclass"></span>
</div>
</div>
<div class="form-group row">
<label class="control-label col-sm-6">Issue Description</label>
<div class="col-sm-6">                                        
{{$description}}  
<span class="errorcustclass"></span>
</div>
<span  class="errorcustclass"></span>
</div>
    
</div>
<div class="panel-footer">
    <a class="btn btn-warning" href="<?php echo  url(ADMINSEPARATOR.'/admin_issue_with_artist'); ?>"><i class="fa fa-chevron-left"></i> Back</a>
   
    <a href="{{url(ADMINSEPARATOR.'/reply_from_admin_artist/'.$id)}}" id="button"  name="frgtchk" class="btn btn-success btn-sm bounceIn animation-delay5  pull-right" >
    <i class="fa fa-sign-in"></i>
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


