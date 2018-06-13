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
       
<div id="breadcrumb">
				<ul class="breadcrumb">
					 <li><i class="fa fa-pencil fa-fw"></i><a href="javascript:void(0);"> Profile </a></li>
					<!-- <li class="active">Dear</li>	 -->
				</ul>
			</div>

<div class="padding-md">
<div class="row">
<div class="col-lg-11">


                <div class="row">
                
                    <div class="col-md-offset-3 col-md-7 ">
                            <div class="panel panel-default">
                    <?php 

                   //  echo "<pre>";
                   // print_r($user_data);exit();
                    $userfullname_show = '';
                    $username_show = '';
                    $user_email_show = '';

                   
                   
                if(!empty($user_data))
                {
                    
                            $userfullname_show = $user_data->first_name; //******** getting full name
                            $username_show = $user_data->username; //********* getting username
                            $user_email_show = $user_data->email; //********* getting username
                }
                    ?>
                            <div class="panel-body">
                              <?php
                    echo Form::open(array('url' => ADMINSEPARATOR.'/editprofilesuccess', 'method' => 'post','files' => true,'id'=>'profileeditfrmid','class'=>'form-login'))
                    ?> 
                                    <div class="form-group">
                                        <label for="exampleInputName">*Name</label>
                                        <?php
                                         echo Form::text("first_name", $value=stripslashes($userfullname_show), $attributes = array("id"=>"first_name","class"=>"form-control input-sm","placeholder"=>"Name"));
                                        ?>
                                         <span class="errorcustclass">{{ $errors->first('first_name') }}</span>

                                    </div><!-- /form-group -->
                                    <div class="form-group">
                                        <label for="exampleInputUsername">*User name</label>
                                       <?php
                                            echo Form::text("username", $value=stripslashes($username_show), $attributes = array("id"=>"username","class"=>"form-control input-sm","placeholder"=>"User name"));
                                        ?>
		        <span class="errorcustclass">{{ $errors->first('username') }}</span>
                                        
                                    </div><!-- /form-group -->

                                     <div class="form-group">
                                        <label for="exampleInputUsername">*Email Address</label>
                                       <?php
                                            echo Form::text("email", $value=stripslashes($user_email_show), $attributes = array("id"=>"email","class"=>"form-control input-sm","placeholder"=>"Email address"));
                                        ?>
                                         <span class="errorcustclass">{{ $errors->first('email') }}</span>
                                    </div><!-- /form-group -->

                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Password</label>
                                       <?php
                                            echo Form::password("password",  $attributes = array("id"=>"password","class"=>"form-control input-sm","placeholder"=>"Password"));
                                        ?>
                                         <span class="errorcustclass">{{ $errors->first('password') }}</span>
                                    </div><!-- /form-group -->
                                    <div class="form-group">
                                        <label for="exampleInputPassword2">Confirm Password</label>
                                       <?php
                                            echo Form::password("confirm_password", $attributes = array("id"=>"confirm_password","class"=>"form-control input-sm","placeholder"=>"Confirm password"));
                                        ?>
                                         <span class="errorcustclass">{{ $errors->first('confirm_password') }}</span>
                                    </div><!-- /form-group -->
                                   

                                    
                                  
                                    <button type="submit" class="btn btn-success btn-sm">Update</button> <a class="btn btn-warning btn-sm" href="<?php echo  url(ADMINSEPARATOR.'/dashboard'); ?>"><i class="fa fa-chevron-left"></i> Back</a>
                              <?php echo Form::close();?>
                            </div>
                        </div><!-- /panel -->
                    </div>
                
				</div>                
                
                  


</div>
</div>
 
 </div>   
    
@endsection