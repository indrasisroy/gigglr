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
    <div class="padding-md">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Issue with Booker details
                    </div>
                       
                       
    <?php
    if(!empty($pagi_country))
    {
        $id=$pagi_country->id;
        $description=$pagi_country->issue_description;
        $desc=stripslashes($description);
        $leave_early=$pagi_country->leave_early;
        $arrival_time=$pagi_country->arrival;
        $receive_rider=$pagi_country->receive_rider;
        $technical_issue=$pagi_country->technical_issue;
        $able_to_complete=$pagi_country->able_to_complete;
        $required_specifications_availability=$pagi_country->required_specifications_availability;
        $arrivaldate=$pagi_country->arrival_time;
        $commencing_gig=$pagi_country->commencing_gig;
        $getting_gig=$pagi_country->getting_gig;
        $bookernickname=$pagi_country->booker_nickname;
        $bookeremail=$pagi_country->booker_email;
        $dispute_resolved_status=$pagi_country->dispute_resolved_status;
    }   
    ?>
                       
                        
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
                                <?php echo date('h:i A', strtotime($arrivaldate));?>
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
                                <?php echo $bookernickname;?>
                                <span  class="errorcustclass"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-sm-6">Booker E-mail</label>
                            <div class="col-sm-6">
                                <?php echo $bookeremail;?>
                                <span  class="errorcustclass"></span>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-sm-6">Issue Description</label>
                            <div class="col-sm-6">                                        
                                <?php echo $desc;?>
                                <span class="errorcustclass"></span>
                            </div>
                        </div>
                        <div class="panel-footer">
                            <a class="btn btn-warning" href="<?php echo  url(ADMINSEPARATOR.'/admin_issue_with_booker'); ?>"><i class="fa fa-chevron-left"></i> Back</a>
                            <a href="{{url(ADMINSEPARATOR.'/reply_from_admin_booker/'.$id)}}" id="button"  name="frgtchk" class="btn btn-success btn-sm bounceIn animation-delay5  pull-right" >
                                <i class="fa fa-sign-in"></i>
                                <?php if($dispute_resolved_status == '1'){
                                    echo "Show replies";
                                }else if($dispute_resolved_status == '0'){
                                    echo "Reply";
                                }?>
                            </a>
                        </div>
                    </div>   
                </div>
            </div>
        </div>
    </div>
@endsection


