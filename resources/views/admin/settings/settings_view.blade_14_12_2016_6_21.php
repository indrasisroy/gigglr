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
					 <li><i class="fa fa-cog fa-1x fa-fw "></i><a href="javascript:void(0);"> Settings </a></li>
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

                    $sitename_show = ''; $site_url_show = ''; $site_address_show = ''; $contact_email_show = ''; $meta_keywords_show = ''; $meta_description_show = ''; $recod_per_page_show = ''; $recod_per_page_admin_show = ''; $contact_phone_show = ''; $site_fax_show = ''; $email_from_show = ''; $wctext_show = ''; $youtube_url=''; $instagram_url=''; $google_url=''; $twitter_url=''; $facebook_url=''; $default_radius = ''; $max_radius_limit=''; $google_api_key = ''; $client_id = ''; $client_secret_key = '';$pin_secret_key = '';$pin_publishable_key = '';$pin_live_test='';
                    $service_charge=0;
					$bfloginimgurldata=''; // before login logo 
				    $afterloginimgurldata=''; // after login logo 
					$footerimgurldata=''; // Footer logo 
				    $emailtemplateimgurldata=''; // Email Template logo 
                    $email_copyright_show = ''; //emailtemplate year 
					$emailfromname='';
					$site_commission = '';
					$referral_commission = '';

                if(!empty($settings_data))
                {
							$referral_commission = $settings_data->referral_commission;	
								
							$site_commission = $settings_data->site_commission; //******** getting site commission 
								
                            $sitename_show = $settings_data->site_name; //******** getting site name 
                    
                            $site_url_show = $settings_data->site_url; //********* getting site url 
                    
                            $site_address_show = $settings_data->address; //******* getting site address 
                    
                            $contact_email_show = $settings_data->contact_email; //******* getting contact email 
                   
                            $meta_keywords_show = $settings_data->meta_keywords; //******** getting meta keywaord 
                   
                            $meta_description_show = $settings_data->meta_description; //******** getting meta description 
                    
                            $recod_per_page_show = $settings_data->record_per_page; //******** getting record per page
                    
                            $recod_per_page_admin_show = $settings_data->record_per_page_admin; //******** getting record per page admin
							
                            $contact_phone_show = $settings_data->contact_phone; //******** getting contact phone 
                   
                            $site_fax_show = $settings_data->site_fax_no; //******** getting site fax 
                    
                            $email_from_show = $settings_data->email_from; //******** getting email from 

                            $email_copyright_show = $settings_data->copyright_year; //******** getting email copyright 
							
				            $wctext_show = $settings_data->welcome_text; //******** getting email copyright
							$emailfromname = $settings_data->emailfromname;
							
							    $facebook_url = $settings_data->facebook_url; //******** getting email copyright
				            	$twitter_url = $settings_data->twitter_url; //******** getting email copyright
								$google_url = $settings_data->google_url; //******** getting email copyright
							    $instagram_url = $settings_data->instagram_url; //******** getting email copyright
								$youtube_url = $settings_data->youtube_url; //******** getting email copyright
							
							$default_radius = $settings_data->default_radius;
							$max_radius_limit= $settings_data->max_radius_limit;
							$google_api_key = $settings_data->google_api_key;
							$client_id = $settings_data->client_id;
							$client_secret_key = $settings_data->client_secret_key;
								$pin_secret_key = $settings_data->pin_secret_key;
								$pin_publishable_key = $settings_data->pin_publishable_key;
								$pin_live_test	= $settings_data->pin_liveortest;
								$service_charge = $settings_data->service_charge;
																	
							 
				            $site_logo_image = $settings_data->site_logo_image;
				            $bfloginimgurldata = BASEURLPUBLICCUSTOM.'upload/settings-image/source-file/'.$settings_data->site_logo_image;
							
							$afterlogin_logo_image = $settings_data->afterlogin_logo_image;
				            $afterloginimgurldata = BASEURLPUBLICCUSTOM.'upload/settings-image/source-file/'.$settings_data->afterlogin_logo_image;
							
							$footer_logo_image = $settings_data->footer_logo_image;
				            $footerimgurldata = BASEURLPUBLICCUSTOM.'upload/settings-image/source-file/'.$settings_data->footer_logo_image;
							
							$email_template_logo_image = $settings_data->email_template_logo_image;
							$emailtemplateimgurldata = BASEURLPUBLICCUSTOM.'upload/settings-image/source-file/'.$settings_data->email_template_logo_image;
							
                    
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
                                     <span  class="errorcustclass">   {{ $errors->first('site_name') }}</span>

                                    </div><!-- /form-group -->
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Site Url</label>
                                       <?php
                                            echo Form::text("site_url", $value=stripslashes($site_url_show), $attributes = array("id"=>"siteurl","class"=>"form-control input-sm","placeholder"=>"Site url"));
                                        ?>
                                     <span  class="errorcustclass">     {{ $errors->first('site_url') }} </span>
                                    </div><!-- /form-group -->
                                   

                                    <div class="form-group">
                                        <label class="col-lg-2 control-label">Address</label>
                                        <div class="col-lg-10">
                                        <?php 
                                        echo Form::textarea("address", $value=stripslashes($site_address_show), $attributes = array("id"=>"address","class"=>"form-control input-sm"));
                                        ?>
                                     <span  class="errorcustclass">     {{ $errors->first('address') }}</span>
                                        </div><!-- /.col -->
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Contact Email</label>
                                      <?php
                                         echo Form::text("contact_email", $value=stripslashes($contact_email_show), $attributes = array("id"=>"contact_email","class"=>"form-control input-sm","placeholder"=>"Contact Email"));
                                        ?>
                                     <span  class="errorcustclass">     {{ $errors->first('contact_email') }}</span>
                                    </div><!-- /form-group -->
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Meta keywords</label>
                                        <?php
                                         echo Form::text("meta_keywords", $value=stripslashes($meta_keywords_show), $attributes = array("id"=>"meta_keywords","class"=>"form-control input-sm","placeholder"=>"Meta Keywords"));
                                        ?>
                                     <span  class="errorcustclass">    {{ $errors->first('meta_keywords') }}</span>
                                    </div><!-- /form-group -->

                                     <div class="form-group">
                                        <label for="exampleInputPassword1">Meta Description</label>
                                        <?php 
                                            echo Form::textarea("meta_description", $value=stripslashes($meta_description_show), $attributes = array("id"=>"meta_description","class"=>"form-control input-sm"));
                                        ?>
                                     <span  class="errorcustclass">    {{ $errors->first('meta_description') }}</span>
                                   </div><!-- /form-group -->
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Record Per Page</label>
                                       <?php
                                         echo Form::text("record_per_page", $value=stripslashes($recod_per_page_show), $attributes = array("id"=>"record_per_page","class"=>"form-control input-sm","placeholder"=>"Record Per Page"));
                                        ?>
                                      <span  class="errorcustclass">   {{ $errors->first('record_per_page') }}</span>
                                    </div><!-- /form-group -->
                                     <div class="form-group">
                                        <label for="exampleInputPassword1">Record Per Page Admin</label>
                                         <?php
                                         echo Form::text("record_per_page_admin", $value=stripslashes($recod_per_page_admin_show), $attributes = array("id"=>"record_per_page_admin","class"=>"form-control input-sm","placeholder"=>"Record Per Page Admin"));
                                        ?>
                                     <span  class="errorcustclass">     {{ $errors->first('record_per_page_admin') }}</span>
                                    </div><!-- /form-group -->
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Contact Phone</label>
                                         <?php
                                         echo Form::text("contact_phone", $value=stripslashes($contact_phone_show), $attributes = array("id"=>"contact_phone","class"=>"form-control input-sm","placeholder"=>"Contact Phone"));
                                        ?>
                                     <span  class="errorcustclass">    {{ $errors->first('contact_phone') }}</span>
                                    </div><!-- /form-group -->
                                    
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">Email From</label>
                                       <?php
                                         echo Form::text("email_from", $value=stripslashes($email_from_show), $attributes = array("id"=>"email_from","class"=>"form-control input-sm","placeholder"=>"Email From"));
                                        ?>
                                     <span  class="errorcustclass">    {{ $errors->first('email_from') }}</span>
                                    </div><!-- /form-group -->

                                    <!-- email template from name -->
                                     <div class="form-group">
                                        <label for="exampleInputPassword1">Email From Name</label>
                                       <?php
                                         echo Form::text("emailfromname", $value=stripslashes($emailfromname), $attributes = array("id"=>"emailfromname","class"=>"form-control input-sm","placeholder"=>"Email From Name"));
                                        ?>
                                     <span  class="errorcustclass">    {{ $errors->first('emailfromname') }} </span>
                                    </div><!-- /form-group -->


                                     <div class="form-group">
                                        <label for="exampleInputPassword1">Copyright Year</label>
                                       <?php
                                         echo Form::text("copyright_year", $value=stripslashes($email_copyright_show), $attributes = array("id"=>"copyright_year","class"=>"form-control input-sm","placeholder"=>"Copyright Year"));
                                        ?>
                                     <span  class="errorcustclass">    {{ $errors->first('copyright_year') }}</span>
                                    </div><!-- /form-group -->
									
                                     <div class="form-group">
                                        <label for="exampleInputPassword1">Welcome Text Heading</label>
                                        <?php
                                         echo Form::text("site_fax_no", $value=stripslashes($site_fax_show), $attributes = array("id"=>"site_fax_no","class"=>"form-control input-sm","placeholder"=>"Welcome text heading"));
                                        ?>
                                     <span  class="errorcustclass">    {{ $errors->first('site_fax_no') }}</span>
                                    </div><!-- /form-group -->

									  <div class="form-group">
                                        <label for="exampleInputPassword1">Welcome Text Description</label>
                                        <?php 
                                            echo Form::textarea("wctext", $value=stripslashes($wctext_show), $attributes = array("id"=>"wctext","class"=>"form-control input-sm"));
                                        ?>
                                     <span  class="errorcustclass">    {{ $errors->first('wctext') }}</span>
                                   </div><!-- /form-group -->
								   <!--Facebook link-->
								    <div class="form-group">
                                        <label for="exampleInputPassword1">Facebook Link</label>
                                       <?php
                                         echo Form::text("facebook_url", $value=stripslashes($facebook_url), $attributes = array("id"=>"facebook_url","class"=>"form-control input-sm","placeholder"=>"Facebook Link"));
                                        ?>
                                     <span  class="errorcustclass">    {{ $errors->first('facebook_url') }}</span>
                                    </div><!-- /form-group -->
									<!--Twitter Link-->
									 <div class="form-group">
                                        <label for="exampleInputPassword1">Twitter Link</label>
                                       <?php
                                         echo Form::text("twitter_url", $value=stripslashes($twitter_url), $attributes = array("id"=>"twitter_url","class"=>"form-control input-sm","placeholder"=>"Twitter Link"));
                                        ?>
                                     <span  class="errorcustclass">    {{ $errors->first('twitter_url') }}</span>
                                    </div><!-- /form-group -->
									<!--Google Link-->
									 <div class="form-group">
                                        <label for="exampleInputPassword1">Google Link</label>
                                       <?php
                                         echo Form::text("google_url", $value=stripslashes($google_url), $attributes = array("id"=>"google_url","class"=>"form-control input-sm","placeholder"=>"Google Link"));
                                        ?>
                                     <span  class="errorcustclass">    {{ $errors->first('google_url') }} </span>
                                    </div><!-- /form-group -->
									<!--Insta Link-->
									 <div class="form-group">
                                        <label for="exampleInputPassword1">Instagram Link</label>
                                       <?php
                                         echo Form::text("instagram_url", $value=stripslashes($instagram_url), $attributes = array("id"=>"instagram_url","class"=>"form-control input-sm","placeholder"=>"Instagram Link"));
                                        ?>
                                     <span  class="errorcustclass">    {{ $errors->first('instagram_url') }}</span>
                                    </div><!-- /form-group -->
									<!--You tube Link-->
									 <div class="form-group">
                                        <label for="exampleInputPassword1">Youtube Link</label>
                                       <?php
                                         echo Form::text("youtube_url", $value=stripslashes($youtube_url), $attributes = array("id"=>"youtube_url","class"=>"form-control input-sm","placeholder"=>"Youtube Link"));
                                        ?>
                                      <span  class="errorcustclass">   {{ $errors->first('youtube_url') }}</span>
                                    </div><!-- /form-group -->
									
									<!-- default radius -->
									 <div class="form-group">
                                        <label for="exampleInputPassword1">Default Radius (in Km.)</label>
                                       <?php
                                         echo Form::text("default_radius", $value=stripslashes($default_radius), $attributes = array("id"=>"default_radius","class"=>"form-control input-sm","placeholder"=>"Default Radius"));
                                        ?>
                                     <span  class="errorcustclass">    {{ $errors->first('default_radius') }} </span>
                                    </div><!-- /form-group -->
									
									<!-- max radius -->
									 <div class="form-group">
                                        <label for="exampleInputPassword1">Maximum Radius Limit (in Km.)</label>
                                       <?php
                                         echo Form::text("max_radius_limit", $value=stripslashes($max_radius_limit), $attributes = array("id"=>"max_radius_limit","class"=>"form-control input-sm","placeholder"=>"Maximum Radius"));
                                        ?>
                                     <span  class="errorcustclass">    {{ $errors->first('max_radius_limit') }}</span>
                                    </div><!-- /form-group -->
									
								<!-- goolge api key -->
									 <div class="form-group">
                                        <label for="exampleInputPassword1">Google API Key</label>
                                       <?php
                                         echo Form::text("google_api_key", $value=stripslashes($google_api_key), $attributes = array("id"=>"google_api_key","class"=>"form-control input-sm","placeholder"=>"Google API Key"));
                                        ?>
                                     <span  class="errorcustclass">    {{ $errors->first('google_api_key') }} </span>
                                    </div><!-- /form-group -->
									
								<!--You tube Link-->
									 <div class="form-group">
                                        <label for="exampleInputPassword1">Google Client ID</label>
                                       <?php
                                         echo Form::text("client_id", $value=stripslashes($client_id), $attributes = array("id"=>"client_id","class"=>"form-control input-sm","placeholder"=>"Google Client ID"));
                                        ?>
                                     <span  class="errorcustclass">    {{ $errors->first('client_id') }} </span>
                                    </div><!-- /form-group -->
									
								<!--You tube Link-->
									 <div class="form-group">
                                        <label for="exampleInputPassword1">Google Client Secret Key</label>
                                       <?php
                                         echo Form::text("client_secret_key", $value=stripslashes($client_secret_key), $attributes = array("id"=>"client_secret_key","class"=>"form-control input-sm","placeholder"=>"Google Client Secret Key"));
                                        ?>
                                     <span  class="errorcustclass">    {{ $errors->first('client_secret_key') }} </span>
                                    </div><!-- /form-group -->
									 <div class="form-group">
                                        <label for="exampleInputPassword1">Pin Secret Key</label>
                                       <?php
                                         echo Form::text("pin_secret_key", $value=stripslashes($pin_secret_key), $attributes = array("id"=>"pin_secret_key","class"=>"form-control input-sm","placeholder"=>"Pin Secret Key"));
                                        ?>
                                     <span  class="errorcustclass">    {{ $errors->first('pin_secret_key') }} </span>
                                    </div><!-- /form-group -->
		
		 <div class="form-group">
                                        <label for="exampleInputPassword1">Pin Publishable Key</label>
                                       <?php
                                         echo Form::text("pin_publishable_key", $value=stripslashes($pin_publishable_key), $attributes = array("id"=>"pin_publishable_key","class"=>"form-control input-sm","placeholder"=>"Pin Publishable Key"));
                                        ?>
                                     <span  class="errorcustclass">    {{ $errors->first('pin_publishable_key') }} </span>
                                    </div><!-- /form-group -->

		    
		 <div class="form-group">
                                <label for="exampleInputPassword1">Pin Live/Test</label>
                                
		<?php
			echo Form::select('pin_live_test', array(
			'test' => 'Test',
			'live' => 'Live'
			), $pin_live_test, $attributes = array(
			"id" => "gst",
			"class" => "form-control input-sm"
			));
		?>
       
                            </div><!-- /form-group --> 



                             <div class="form-group">
                                        <label for="exampleInputPassword1">Service Charge Person</label>
                                       <?php
                                         echo Form::text("service_charge", $value=stripslashes($service_charge), $attributes = array("id"=>"service_charge","class"=>"form-control input-sm","placeholder"=>"Service Charge Person"));
                                        ?>
                                     <span  class="errorcustclass">    {{ $errors->first('service_charge') }} </span>
                                    </div><!-- /form-group -->


                             <div class="form-group">
                                <label for="exampleInputPassword1">Site commission</label>
                                       <?php
                                         echo Form::text("site_commission", $value=stripslashes($site_commission), $attributes = array("id"=>"site_commission","class"=>"form-control input-sm","placeholder"=>"Site commission"));
                                        ?>
                                <span  class="errorcustclass">    {{ $errors->first('site_commission') }} </span>
							</div><!-- /form-group -->
                             					
												
									
                             <div class="form-group">
                                <label for="exampleInputPassword1">Referral commission</label>
                                       <?php
                                         echo Form::text("referral_commission", $value=stripslashes($referral_commission), $attributes = array("id"=>"referral_commission","class"=>"form-control input-sm","placeholder"=>"Referral commission"));
                                        ?>
                                <span  class="errorcustclass">    {{ $errors->first('referral_commission') }} </span>
							 </div><!-- /form-group -->

								<div class="form-group">
										<label class="form-group">*Before Login Logo Image (Minimum Width : 445px) (Minimum Height : 82px)
										<br>Allowed File Extention : .png
										</label>
											<br>
											
										<div class="form-group">
											<input type="file" name="site_logo_image[]" class="form-control input-sm" value="">
	<span  class="errorcustclass"><?php echo $errors->first('site_logo_image');  ?></span>
		
		<br><p><?php if(!empty($bfloginimgurldata)){ ?><img src="<?php echo $bfloginimgurldata; ?>" onclick="javascript:showIMageFancy('<?php echo $site_logo_image; ?>');"> <?php } ?></p>
		
		
		
										</div><!-- /.col -->
								</div><!-- /form-group -->
								
								<!--Image 2 For After Login-->
								<div class="form-group">
										<label class="form-group">*After Login Logo Image (Minimum Width : 66px) (Minimum Height : 49px)
										<br>Allowed File Extention : .png
										</label>
											<br>
											
										<div class="form-group">
											<input type="file" name="afterlogin_logo_image[]" class="form-control input-sm" value="" >
	<span  class="errorcustclass"><?php echo $errors->first('afterlogin_logo_image');  ?></span>
		
		<br><p><?php if(!empty($afterloginimgurldata)){ ?><img src="<?php echo $afterloginimgurldata; ?>" onclick="javascript:showIMageFancy('<?php echo $afterlogin_logo_image; ?>');"> <?php } ?></p>
		
		
		
										</div><!-- /.col -->
								</div><!-- /form-group -->
								
								<!--Image 3 For Footer Logo-->
								
								<div class="form-group">
										<label class="form-group">*Footer Logo Image (Minimum Width : 254px ) (Minimum Height : 48px )
										<br>Allowed File Extention : .png
										</label>
											<br>
											
										<div class="form-group">
											<input type="file" name="footer_logo_image[]" class="form-control input-sm" value="" >
	<span  class="errorcustclass"><?php echo $errors->first('footer_logo_image');  ?></span>
		
		<br><p><?php if(!empty($footerimgurldata)){ ?><img src="<?php echo $footerimgurldata; ?>" onclick="javascript:showIMageFancy('<?php echo $footer_logo_image; ?>');"> <?php } ?></p>
		
		
		
										</div><!-- /.col -->
								</div><!-- /form-group -->
								
								<!--Image 4 For Email Template Banner-->
								
								<div class="form-group">
										<label class="form-group">*Email Template Logo Image (Minimum Width : 254px) (Minimum Height : 48px)
										<br>Allowed File Extention : .png
										</label>
											<br>
											
										<div class="form-group">
											<input type="file" name="email_template_logo_image[]" class="form-control input-sm" value="">
	<span  class="errorcustclass"><?php echo $errors->first('email_template_logo_image');  ?></span>
		
		<br><p><?php if(!empty($emailtemplateimgurldata)){ ?><img src="<?php echo $emailtemplateimgurldata; ?>" onclick="javascript:showIMageFancy('<?php echo $email_template_logo_image; ?>');"> <?php } ?></p>
		
		
		
										</div><!-- /.col -->
								</div><!-- /form-group -->

                                    <input type="hidden" name="firstprev_banner_image" value="<?php echo $site_logo_image;?>" >
									<input type="hidden" name="secondprev_banner_image" value="<?php echo $afterlogin_logo_image;?>" >
									
									<input type="hidden" name="thirdprev_banner_image" value="<?php echo $footer_logo_image;?>" >
									
									<input type="hidden" name="fourthprev_banner_image" value="<?php echo $email_template_logo_image;?>" >
									
                                  <div class="col-lg-2">
                                    <button type="submit" class="btn btn-success btn-sm">Update</button> <!--  <button type="button" class="btn btn-success btn-sm">Back</button> -->
								  </div>
                              <?php echo Form::close();?>
                            </div>
                        </div><!-- /panel -->
                    </div>
                
				</div>                
                
                  


</div>
</div>
 
 </div>
				
				
				
				<!-- Add fancyBox main JS and CSS files starts -->
<script type="text/javascript" src="{{ BASEURLPUBLICCUSTOM}}commonassets/fancybox/source/jquery.fancybox.js?v=2.1.5"></script>
<link rel="stylesheet" type="text/css" href="{{ BASEURLPUBLICCUSTOM}}commonassets/fancybox/source/jquery.fancybox.css?v=2.1.5" media="screen" />
<!-- Add fancyBox main JS and CSS files ends -->
			
			<script>
			
			function showIMageFancy(imagename)
			{
			
				if(imagename!='')
				{
					$.fancybox.open("<?php echo BASEURLPUBLICCUSTOM.'upload/settings-image/source-file';?>"+"/"+imagename);
				
					$('.fancybox-opened').css('z-index',999999);
				}
			}
			
			</script>
    
@endsection