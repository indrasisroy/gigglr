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
					 <li><i class="fa fa-cog fa-spin fa-1x fa-fw "></i><a href="javascript:void(0);"> Settings </a></li>
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
                   // print_r($settings_data);
                    ?>
                            <div class="panel-body">
                              <?php
                    echo Form::open(array('url' => ADMINSEPARATOR.'/upadte_settings', 'method' => 'post','files' => true,'id'=>'settingsfrmid','class'=>'form-login'))
                    ?> 
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Site Name</label>
                                        <?php
                                         echo Form::text("site_name", $value=stripslashes($settings_data->site_name), $attributes = array("id"=>"sitename","class"=>"form-control input-sm","placeholder"=>"Site name"));
                                        ?>
                                        {{ $errors->first('site_name') }}

                                    </div><!-- /form-group -->
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Site Url</label>
                                       <?php
                                            echo Form::text("site_url", $value=stripslashes($settings_data->site_url), $attributes = array("id"=>"siteurl","class"=>"form-control input-sm","placeholder"=>"Site url"));
                                        ?>
                                         {{ $errors->first('site_url') }}
                                    </div><!-- /form-group -->
                                   

                                    <div class="form-group">
                                        <label class="col-lg-2 control-label">Address</label>
                                        <div class="col-lg-10">
                                        <?php 
                                        echo Form::textarea("address", $value=stripslashes($settings_data->address), $attributes = array("id"=>"address","class"=>"form-control input-sm"));
                                        ?>
                                         {{ $errors->first('address') }}
                                        </div><!-- /.col -->
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Contact Email</label>
                                      <?php
                                         echo Form::text("contact_email", $value=stripslashes($settings_data->contact_email), $attributes = array("id"=>"contact_email","class"=>"form-control input-sm","placeholder"=>"Contact Email"));
                                        ?>
                                         {{ $errors->first('contact_email') }}
                                    </div><!-- /form-group -->
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Meta keywords</label>
                                        <?php
                                         echo Form::text("meta_keywords", $value=stripslashes($settings_data->meta_keywords), $attributes = array("id"=>"meta_keywords","class"=>"form-control input-sm","placeholder"=>"Meta Keywords"));
                                        ?>
                                        {{ $errors->first('meta_keywords') }}
                                    </div><!-- /form-group -->

                                     <div class="form-group">
                                        <label for="exampleInputPassword1">Meta Description</label>
                                        <?php 
                                            echo Form::textarea("meta_description", $value=stripslashes($settings_data->meta_description), $attributes = array("id"=>"meta_description","class"=>"form-control input-sm"));
                                        ?>
                                        {{ $errors->first('meta_description') }}
                                   </div><!-- /form-group -->
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Record Per Page</label>
                                       <?php
                                         echo Form::text("record_per_page", $value=stripslashes($settings_data->record_per_page), $attributes = array("id"=>"record_per_page","class"=>"form-control input-sm","placeholder"=>"Record Per Page"));
                                        ?>
                                        {{ $errors->first('record_per_page') }}
                                    </div><!-- /form-group -->
                                     <div class="form-group">
                                        <label for="exampleInputPassword1">Record Per Page Admin</label>
                                         <?php
                                         echo Form::text("record_per_page_admin", $value=stripslashes($settings_data->record_per_page_admin), $attributes = array("id"=>"record_per_page_admin","class"=>"form-control input-sm","placeholder"=>"Record Per Page Admin"));
                                        ?>
                                         {{ $errors->first('record_per_page_admin') }}
                                    </div><!-- /form-group -->
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Contact Phone</label>
                                         <?php
                                         echo Form::text("contact_phone", $value=stripslashes($settings_data->contact_phone), $attributes = array("id"=>"contact_phone","class"=>"form-control input-sm","placeholder"=>"Contact Phone"));
                                        ?>
                                        {{ $errors->first('contact_phone') }}
                                    </div><!-- /form-group -->
                                     <div class="form-group">
                                        <label for="exampleInputPassword1">Site Fax No</label>
                                        <?php
                                         echo Form::text("site_fax_no", $value=stripslashes($settings_data->site_fax_no), $attributes = array("id"=>"site_fax_no","class"=>"form-control input-sm","placeholder"=>"Site Fax No"));
                                        ?>
                                        {{ $errors->first('site_fax_no') }}
                                    </div><!-- /form-group -->
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Email From</label>
                                       <?php
                                         echo Form::text("email_from", $value=stripslashes($settings_data->email_from), $attributes = array("id"=>"email_from","class"=>"form-control input-sm","placeholder"=>"Email From"));
                                        ?>
                                        {{ $errors->first('email_from') }}
                                    </div><!-- /form-group -->
                                    
                                  
                                    <button type="submit" class="btn btn-success btn-sm">Update</button> <!--  <button type="button" class="btn btn-success btn-sm">Back</button> -->
                              <?php echo Form::close();?>
                            </div>
                        </div><!-- /panel -->
                    </div>
                
				</div>                
                
                  


</div>
</div>
 
 </div>   
    
@endsection