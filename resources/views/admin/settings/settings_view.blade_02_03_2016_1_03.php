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
                    $sitename_show = '';
                    $site_url_show = '';
                    $site_address_show = '';
                    $contact_email_show = '';
                    $meta_keywords_show = '';
                    $meta_description_show = '';
                    $recod_per_page_show = '';
                    $recod_per_page_admin_show = '';
                    $contact_phone_show = '';
                    $site_fax_show = '';
                    $email_from_show = '';

                    $sitename_chk = $settings_data->site_name; //******** getting site name
                    $site_url_chk = $settings_data->site_url; //********* getting site url
                    $site_address_chk = $settings_data->address; //******* getting site address
                    $contact_email_chk = $settings_data->contact_email; //******* getting contact email
                    $meta_keywords_chk = $settings_data->meta_keywords; //******** getting meta keywaord
                    $meta_description_chk = $settings_data->meta_description; //******** getting meta description
                    $recod_per_page_chk = $settings_data->record_per_page; //******** getting record per page
                    $recod_per_page_admn_chk = $settings_data->record_per_page_admin; //******** getting record per page admin
                    $contact_phone_chk = $settings_data->contact_phone; //******** getting contact phone
                    $site_fax_chk = $settings_data->site_fax_no; //******** getting site fax
                    $email_from_chk = $settings_data->email_from; //******** getting email from

                    if(!empty($sitename_chk)) //********** checking site name
                    {
                            $sitename_show=$sitename_chk;
                    }
                    if(!empty($site_url_chk)) //********** checking site url
                    {
                            $site_url_show=$site_url_chk;
                    }
                    if(!empty($site_address_chk)) //********** checking site address
                    {
                            $site_address_show=$site_address_chk;
                    }
                    if(!empty($contact_email_chk)) //********** checking site contact email
                    {
                            $contact_email_show=$contact_email_chk;
                    }
                    if(!empty($meta_keywords_chk)) //********** checking site meta keyword
                    {
                            $meta_keywords_show=$meta_keywords_chk;
                    }
                    if(!empty($meta_description_chk)) //********** checking site meta description
                    {
                            $meta_description_show=$meta_description_chk;
                    }
                    if(!empty($recod_per_page_chk)) //********** checking site record per page
                    {
                            $recod_per_page_show=$recod_per_page_chk;
                    }
                    if(!empty($recod_per_page_admn_chk)) //********** checking admin record per page
                    {
                            $recod_per_page_admin_show=$recod_per_page_admn_chk;
                    }
                    if(!empty($contact_phone_chk)) //********** checking admin contact phone
                    {
                            $contact_phone_show=$contact_phone_chk;
                    }
                    if(!empty($site_fax_chk)) //********** checking site fax
                    {
                            $site_fax_show=$site_fax_chk;
                    }
                    if(!empty($email_from_chk)) //********** checking email from
                    {
                            $email_from_show=$email_from_chk;
                    }

                    ?>
                            <div class="panel-body">
                              <?php
                    echo Form::open(array('url' => ADMINSEPARATOR.'/upadte_settings', 'method' => 'post','files' => true,'id'=>'settingsfrmid','class'=>'form-login'))
                    ?> 
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Site Name</label>
                                        <?php
                                         echo Form::text("site_name", $value=stripslashes($sitename_show), $attributes = array("id"=>"sitename","class"=>"form-control input-sm","placeholder"=>"Site name"));
                                        ?>
                                        {{ $errors->first('site_name') }}

                                    </div><!-- /form-group -->
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Site Url</label>
                                       <?php
                                            echo Form::text("site_url", $value=stripslashes($site_url_show), $attributes = array("id"=>"siteurl","class"=>"form-control input-sm","placeholder"=>"Site url"));
                                        ?>
                                         {{ $errors->first('site_url') }}
                                    </div><!-- /form-group -->
                                   

                                    <div class="form-group">
                                        <label class="col-lg-2 control-label">Address</label>
                                        <div class="col-lg-10">
                                        <?php 
                                        echo Form::textarea("address", $value=stripslashes($site_address_show), $attributes = array("id"=>"address","class"=>"form-control input-sm"));
                                        ?>
                                         {{ $errors->first('address') }}
                                        </div><!-- /.col -->
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Contact Email</label>
                                      <?php
                                         echo Form::text("contact_email", $value=stripslashes($contact_email_show), $attributes = array("id"=>"contact_email","class"=>"form-control input-sm","placeholder"=>"Contact Email"));
                                        ?>
                                         {{ $errors->first('contact_email') }}
                                    </div><!-- /form-group -->
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Meta keywords</label>
                                        <?php
                                         echo Form::text("meta_keywords", $value=stripslashes($meta_keywords_show), $attributes = array("id"=>"meta_keywords","class"=>"form-control input-sm","placeholder"=>"Meta Keywords"));
                                        ?>
                                        {{ $errors->first('meta_keywords') }}
                                    </div><!-- /form-group -->

                                     <div class="form-group">
                                        <label for="exampleInputPassword1">Meta Description</label>
                                        <?php 
                                            echo Form::textarea("meta_description", $value=stripslashes($meta_description_show), $attributes = array("id"=>"meta_description","class"=>"form-control input-sm"));
                                        ?>
                                        {{ $errors->first('meta_description') }}
                                   </div><!-- /form-group -->
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Record Per Page</label>
                                       <?php
                                         echo Form::text("record_per_page", $value=stripslashes($recod_per_page_show), $attributes = array("id"=>"record_per_page","class"=>"form-control input-sm","placeholder"=>"Record Per Page"));
                                        ?>
                                        {{ $errors->first('record_per_page') }}
                                    </div><!-- /form-group -->
                                     <div class="form-group">
                                        <label for="exampleInputPassword1">Record Per Page Admin</label>
                                         <?php
                                         echo Form::text("record_per_page_admin", $value=stripslashes($recod_per_page_admin_show), $attributes = array("id"=>"record_per_page_admin","class"=>"form-control input-sm","placeholder"=>"Record Per Page Admin"));
                                        ?>
                                         {{ $errors->first('record_per_page_admin') }}
                                    </div><!-- /form-group -->
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Contact Phone</label>
                                         <?php
                                         echo Form::text("contact_phone", $value=stripslashes($contact_phone_show), $attributes = array("id"=>"contact_phone","class"=>"form-control input-sm","placeholder"=>"Contact Phone"));
                                        ?>
                                        {{ $errors->first('contact_phone') }}
                                    </div><!-- /form-group -->
                                     <div class="form-group">
                                        <label for="exampleInputPassword1">Site Fax No</label>
                                        <?php
                                         echo Form::text("site_fax_no", $value=stripslashes($site_fax_show), $attributes = array("id"=>"site_fax_no","class"=>"form-control input-sm","placeholder"=>"Site Fax No"));
                                        ?>
                                        {{ $errors->first('site_fax_no') }}
                                    </div><!-- /form-group -->
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Email From</label>
                                       <?php
                                         echo Form::text("email_from", $value=stripslashes($email_from_show), $attributes = array("id"=>"email_from","class"=>"form-control input-sm","placeholder"=>"Email From"));
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