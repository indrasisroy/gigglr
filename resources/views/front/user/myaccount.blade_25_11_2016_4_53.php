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

$faqpagedata=array();
if(!empty($faqpage))
{
	$faqpagedata=$faqpage;
}

?>
@extends('layouts.front.frontendmaster',['successmsg' => $successmsg,'errormsg'=>$errormsg])
@section('content')
	
	<!-- profile-section-start -->
          <section class="accnt myAccnt">
              <?php // echo Form::open(array('files' => true, 'method' => 'post','id'=>'myaccountfrmid','class'=>"" )); ?>
                   <div class="container">
                        <div class="clearfix myAccnt-custom">
                            <div class="custom-col-3">
                                <div class="account-holder-pic">
								<?php
										if(!empty($img))
									{
										$image_name=$img->image_name;
										//$image_with_pth=asset('upload/userimage/thumb-medium/'.$image_name);
										$image_with_pth=BASEURLPUBLICCUSTOM.'upload/userimage/thumb-medium/'.$image_name;
										
										?>
										<img src={{$image_with_pth}} alt="">
										<?php
									}
									else{
									//$imgurldata = asset("front/otherfiles/progimages/"."noimagefound208X201.jpg");
									$imgurldata = BASEURLPUBLICCUSTOM."front/otherfiles/progimages/"."noimagefound208X201.jpg";
									
									?>
									 <img src="{{$imgurldata}}" alt=""> 
									<?php
									}
								?>
                                   
                                </div>
                                <div class="account-holder-about">
                                    <h2 class="profile-name">
									<?php
									if(strlen($userdetails->nickname)>7){
									echo substr($userdetails->nickname,0,7)."...";
									}else{
									echo $userdetails->nickname;
									}
									?></h2>
										<?php
										$seoName = '';
										if($userdetails->seo_name!=''){
										$seoName = $userdetails->seo_name;
										}else{
										//$seoName = "123";
										}?>
                                    <?php if(!empty($seoName)) {  ?><button class="btn profile-btmn viewmyprofile"  data-location = "<?php echo url('artist')."/".$seoName; ?>" >
									<!--<a href="<?php // echo url('profile')."/".$seoName; ?>" target="_blank">-->View Profile<!--</a>-->
										</button><?php } ?>
                                </div>
                            </div>
                            <div class="custom-col-8">
							<?php
							if(!empty($getemail)){
							

								if($getemail->emailid!=''){
								$ref_email = $getemail->emailid;
								}else{
								$ref_email = '';
								}
								
								$css_style="Style=display:none";
								//$css_style="";
								$hidden_ref_email=1;
							}else{
								$ref_email = '';
								$css_style ='';
								$hidden_ref_email=0;
							}
							//echo $hidden_ref_email;
							?>
							<?php echo Form::open(array('files' => true, 'method' => 'post','id'=>'myaccountfrmid','class'=>"" )); ?>
								<div class="custom-formIn exclass" <?php echo $css_style; ?>>
                                     <div class="inputForum clearfix">
                                        <label>Referrer E-mail</label>
                                         <div class="from-control-custom">
											 <?php echo Form::text("emailid", $value=$ref_email, $attributes = array( "id"=>"emailid","class"=>" form-control input-sm parsley-validated "));
											
											 ?>
											 
											 <div class="validation mydisplayblock myerrorcolor myitalicclass" style="display:none"></div>
                                         </div>
                                    </div>
                                </div>
									<?php
									echo Form::hidden('ref_email_field', $hidden_ref_email, $attributes = array( "id"=>"ref_email_field"));
									?>
    
                                <div class="custom-formIn">
                                     <div class="inputForum clearfix">
                                        <label>First Name *</label>
                                         <div class="from-control-custom">
                                             <?php echo Form::text("first_name", $value=$userdetails->first_name, $attributes = array( "id"=>"first_name","class"=>" form-control input-sm parsley-validated ")); ?>
                                         </div>
                                    </div>
                                     <div class="inputForum clearfix">
                                        <label>Middle Name</label>
                                        <div class="from-control-custom">
											 <?php echo Form::text("middle_name", $value=$userdetails->middle_name, $attributes = array( "id"=>"middle_name","class"=>" form-control input-sm parsley-validated ")); ?>
                                         </div>
                                    </div>
                                    <div class="inputForum clearfix">
                                        <label>Last Name *</label>
                                        <div class="from-control-custom">
											 <?php echo Form::text("last_name", $value=$userdetails->last_name, $attributes = array( "id"=>"last_name","class"=>" form-control input-sm parsley-validated ")); ?>
                                         </div>
                                    </div>
                                     <div class="inputForum clearfix">
                                        <label>Contact Number *</label>
                                        <div class="from-control-custom">
											 <?php echo Form::text("phone", $value=$userdetails->phone, $attributes = array( "id"=>"phone","class"=>" form-control input-sm parsley-validated ")); ?>
                                         </div>
                                    </div>
                                     <div class="inputForum clearfix">
                                        <label>E-Mail Address *</label>
                                        <div class="from-control-custom">
                                             <?php echo Form::text("email", $value=$userdetails->email, $attributes = array( "id"=>"email","class"=>" form-control input-sm parsley-validated ")); ?>
                                         </div>
                                    </div>
                                     <div class="inputForum clearfix">
                                        <label>Address 1 *</label>
                                        <div class="from-control-custom">
											 <?php echo Form::text("address1", $value=$userdetails->address1, $attributes = array( "id"=>"address1","class"=>" form-control input-sm parsley-validated ")); ?>
                                         </div>
                                    </div>
                                     <div class="inputForum clearfix">
                                        <label>Address 2</label>
                                       <div class="from-control-custom">
                                            <?php echo Form::text("address2", $value=$userdetails->address2, $attributes = array( "id"=>"address2","class"=>" form-control input-sm parsley-validated ")); ?>
                                         </div>
                                    </div>
                                    
                                    <div class="clearfix">
                                    <div class="col-custom-xs-6">
									<div class="inputForum clearfix">
                                          <label>Country *</label>
										<div class="from-control-custom">
                                        
									<?php
									
									$control_attrAr=array();
									$control_attrAr['id']='select_country';
									$control_attrAr['class']=" selectpicker ";
									$control_attrAr['title']="Select Country";
									
									$fetchskillmasterArData=array();
									$fetchskillmasterArData[]="Select Country";
									if(!empty($country)){
									foreach($country as $countryAll){
										$fetchskillmasterArData[$countryAll->id]=$countryAll->country_name;
									}
									
									}
									if($userdetails->country!=''){
									$skill_parent = $userdetails->country;
									}else{
									$skill_parent='';	
									}						
									echo Form::select('skill_parent', $fetchskillmasterArData, $skill_parent,$control_attrAr);							
									?>
									
                                    </div>
                                    </div>
                                     
                                    </div>
                                     <div class="col-custom-xs-4">
                                        <div class="inputForum clearfix right">
                                              <label>State</label>
												<div class="from-control-custom">
                                                <?php
								
													$control_attrAr=array();
													$control_attrAr['id']='select_state';
													$control_attrAr['class']="selectpicker ";
													$control_attrAr['title']="Select state";
													
													if($userdetails->state!=''){
													$select_state=$userdetails->state;
													}else{
													$select_state='';
													}
													$fetchstateData=array();
													if(!empty($state)){
														foreach($state as $stateAll){
															$fetchstateData[$stateAll->id]=$stateAll->state_3_code;
														}
													}
													
													echo Form::select('select_state', $fetchstateData, $select_state,$control_attrAr);							
												?>
                                                </div>
                                        </div>
                                    </div>
                                    </div>
                                    <div class="clearfix">
                                    <div class="col-custom-xs-6">
                                     <div class="inputForum clearfix">
                                              <label>City</label>
                                               <div class="from-control-custom">
													 <?php echo Form::text("city", $value=$userdetails->city, $attributes = array( "id"=>"city","class"=>" form-control input-sm parsley-validated ")); ?>
                                                 </div>
                                        </div>
                                    </div>
                                    <div class="col-custom-xs-4 col-custom-xs-4-short">
                                    <div class="inputForum clearfix right">
                                        <label>Post Code</label>
                                       <div class="from-control-custom">
                                             <?php echo Form::text("zip", $value=$userdetails->zip, $attributes = array( "id"=>"zip","class"=>" form-control input-sm parsley-validated ")); ?>
                                         </div>
                                    </div>
                                    </div> 
                                
                                </div>
                                        
                                <div class="inputForum clearfix dob">
                                   <label>Date of Birth *</label>
                                 <div class="from-control-custom clearfix">
								<?php
									$old_date_timestamp = strtotime($userdetails->dob);
									if($userdetails->dob = "0000-00-00 00:00:00"){
									$new_date = date('F d, Y', $old_date_timestamp);
									}else{
									$new_date = date("F d, Y");
									}
									echo Form::text("dob", $value=$new_date, $attributes = array( "id"=>"dob","class"=>" form-control  ","placeholder"=>"dob"));
								?>
						<!--<div id="dobdivid"></div>-->
						<div id="dobdivmyaccount"></div>

                                </div>
                             </div>
                                    <div class="inputForum clearfix gender-part">
                                        <label>Gender *</label>
                                        <div class="from-control-custom">
                                             <div class="inlineWrap extra-margin">
											 
												<div class="inline">
												<label class="radio-check">
												
												<?php
												if($userdetails->gender == 1){
												$male = true;
												$female = false;
												$other = false;
												}else if($userdetails->gender == 2){
												$male = false;
												$female = true;
												$other = false;
												}else{
												$male = false;
												$female = false;
												$other = true;
												}
												
												
												
												echo Form::radio('gender', '1', $male,$attributes = array("id"=>"gender_id1","class"=>""));
					 
												?>
												  <span></span>Male</label>
												</div>
												 <div class="inline">
													 <label class="radio-check">
													  <?php
												echo Form::radio('gender', '2', $female,$attributes = array("id"=>"gender_id2","class"=>""));
					 
												?>
													 <span></span>Female</label>
												 </div>
												 <div class="inline">
													 <label class="radio-check">
												<?php
												echo Form::radio('gender', '3', $other,$attributes = array("id"=>"gender_id3","class"=>""));
												?>
													 <span></span>Other</label>
												</div>
                                      
                                        </div>
                                         </div>
                                    </div>
                                    <div class="inputForum clearfix">
                                        <label>Language *</label>
                                        <div class="from-control-custom">
										<?php
										
										$control_attrAr=array();
										$control_attrAr['id']='select_Language';
										$control_attrAr['class']=" selectpicker ";
										$control_attrAr['title']="Select Language";
										
										$fetchLanguage=array();
										
										$fetchLanguage['']='Select Language';
										if(!empty($language)){
											foreach($language as $lang){
												$fetchLanguage[$lang->id]=$lang->language_name;
											}
										}
										
										if($userdetails->language!=''){
										$skill_parent = $userdetails->language;
										}else{
										$skill_parent='';	
										}							
										echo Form::select('select_Language', $fetchLanguage, $skill_parent,$control_attrAr);							
										?>  
                                    </div>
                                </div>
                                    <div class="inputForum clearfix">
                                        <label>Currency</label>
										<div class="from-control-custom">
										<?php
										
										$old_currency_code = '';
										$old_currency_icon = '';
										if($my_code !=''){
											$old_currency_code =$my_code;
										}
										if($my_icon !=''){
											$old_currency_icon =($my_icon);
										}
										
										?>
										<input id="currency" class=" form-control input-sm parsley-validated" name="currency" type="text" value="<?php echo $old_currency_code. $old_currency_icon;?>" readonly>
										</div>

                                    </div>
                                    <div class="password-section">
                                        <h4>Change Password
                                        <span>Mix uppercase and lowercase letters.<br/>
                                              Letters and numbers required. 8 Character minimum.
                                        </span>
                                        </h4>
                                        <div class="inputForum clearfix">
                                        <label>Old password</label>
                                        <div class="from-control-custom">
                                           <!--  <input type="password" class="form-control"/>-->
											 
											<?php echo Form::password("old_password",  $attributes = array( "id"=>"old_password","class"=>" form-control  ")); ?>
                                         </div>
                                        </div>
                                        <div class="inputForum clearfix">
                                        <label>New password</label>
                                        <div class="from-control-custom">
                                             <?php echo Form::password("new_password", $attributes = array( "id"=>"new_password","class"=>" form-control input-sm parsley-validated ")); ?>
                                         </div>
                                        </div>
                                        <div class="inputForum clearfix">
                                        <label>Confirm password</label>
                                        <div class="from-control-custom">
                                             <?php echo Form::password("con_password", $attributes = array( "id"=>"con_password","class"=>" form-control")); ?>
											 
                                         </div>
                                        </div>
                                    </div>
                                    </div>
                                  <div class="orange-btn-group">
                                  	
                                  	<div class="clearfix nwBtn">
                                  		<a href="#" data-toggle="modal" data-target="#password-apply" class="btn orange-btn reason" data-reason="save">save</a>
										<!--<a href="#" data-toggle="modal" data-target="#password-apply" class="btn orange-btn deactive deactive-toggle">DEACTIVATE ACCOUNT</a>  	-->
		                                <!--<a href="javascript:void(0)" data-target="#password-apply" class="btn orange-btn deactive deactive-toggle">DEACTIVATE ACCOUNT</a>-->
										<a href="javascript:void(0)" data-toggle="modal"  data-target=".password-apply-2" class="btn orange-btn deactive reason" data-reason="deactive">DEACTIVATE ACCOUNT</a>
                                  	</div>
                                    
                             </div>
                                
                                <?php 	echo Form::close();	?>
								
								<!-- Deactivation start-->
								<?php echo Form::open(array('files' => true, 'method' => 'post','id'=>'myaccountfromdeactive','class'=>"" )); ?>
                                <div class="deativationToggle deactive_div" style="display: none;">
	                                <div class="account-deativation">
	                                    <h4>Account Deactivation
	<!--                                        To deactive your account verify your passsword.<br/>-->
	                                        <span>A deactivation link will be sent to your registered email address.
	                                        </span>
	                                    </h4>
	                                    
	                                    <h4>Please let us know your reason for leaving</h4>
	                                    <div class="inputForum clearfix">
	                                        <div class="from-control-custom">
	                                             <!--<textarea class="form-control"></textarea>-->
												 <?php echo Form::textarea("deactive_reason", $value='', $attributes = array( "id"=>"deactive_reason","class"=>" form-control input-sm parsley-validated ")); ?>
	                                         </div>
	                                    </div>
	                                    <div class="recive-subscriptions">
	                                        <div class="inlineWrap">
	                                            <h4>Receive Subscriptions</h4>
	                                            <div class="inline">
	                                               <label class="radio-check">
												   <!--<input type="radio" name="ab" checked="checked">-->
												<?php
												echo Form::radio('subscriptions', '1', false,$attributes = array("id"=>"subscriptions","class"=>""));
					 
												?>
	                                                 <span></span>Yes</label>
	                                              </div>
	                                                <div class="inline">
	                                                    <label class="radio-check"><!--<input type="radio" name="ab" checked="checked">-->
												<?php
												echo Form::radio('subscriptions', '0', true,$attributes = array("id"=>"subscriptions","class"=>""));
												
												?>
	                                                    <span></span>No</label>
	                                                </div>
	                                        </div>
	                                        
	                                  </div>
	                                    <div class="recive-subscriptions">
	                                        <div class="inlineWrap">
	                                            <h4>Receive Gig Notifications</h4>
	                                            <div class="inline">
	                                               <label class="radio-check">
												   <!--<input type="radio" name="ba" checked="checked">-->
													<?php
													echo Form::radio('gig_notification', '1', false,$attributes = array("id"=>"gig_notification","class"=>""));
													
													?>
	                                                 <span></span>Yes</label>
	                                              </div>
	                                                <div class="inline">
	                                                    <label class="radio-check">
														<!--<input type="radio" name="ba" checked="checked">-->
													<?php
													echo Form::radio('gig_notification', '0', true,$attributes = array("id"=>"gig_notification","class"=>""));
													
													?>
	                                                    <span></span>No</label>
	                                                </div>
	                                        </div>
	                                </div>
	                                </div>
	                                
	                                <div class="orange-btn-group text-right">
	                                  <button type="button" class="btn orange-btn deactive" id="deactive_confirm">DEACTIVATE ACCOUNT</button>
	                                </div>
	                                
                                </div>
									<!-- Deactivation end-->
                                 <?php echo Form::close();	?>
                              </div>
                            </div>
                        </div>
                        <?php // 	echo Form::close();	?>
                    </section>

	<!-- profile-section-end -->
	<!-- modal start -->
	<div class="modal fade password-apply-2" id="password-apply" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">

    <div class="modal-content">
      <div class="modal-header">
         <button type="button" class="close popup-close wallet-close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
		<?php // echo Form::open(array('files' => true, 'method' => 'post','id'=>'myaccountfromCheckPass','class'=>"" ));?>
      <div class="modal-body">
         
       <div class="password-form">
	   	<?php
		$modal_reason='';
		echo Form::hidden('modal_reason', $modal_reason, $attributes = array( "id"=>"modal_reason_hidden"));
		?>
           <label>Please verify your password</label>
		  <?php echo Form::password("re_password", $attributes = array( "id"=>"re_password","class"=>" form-control")); ?>
		  <div class="validationpass mydisplayblock myerrorcolor myitalicclass" style="display:none" id="passerrorshowdiv"></div>
       </div>
          <div class="password-form-button">
           <button type="button" id="modal_submit" class="btn btn-primary">verify password</button>
         </div>
      </div>
		<?php // echo Form::close();?>
    </div>
  </div>
</div>
<!-- modal end-->
	<script type="text/javascript">
		var lst_first_name = "<?php echo $userdetails->first_name?>";
		var loderImage = "{{ URL::asset('public/front')}}/otherfiles/progimages/loder.gif";
		var my_wallet_amount = "<?php echo $userdetails->wallet_amount;?>";
		var my_currency = "";
		var old_country = "<?php echo $userdetails->country;?>";
		var my_old_currency = "<?php echo $userdetails->currency;?>";
	</script>
		  	<!-- for day month year calendar function calling js starts -->
	<script type="text/javascript" src="{{ URL::asset('public/front')}}/otherfiles/progjs/myaccountdaymonthyear.js"></script>
	<!-- for day month year calendar function calling js ends -->
	
	<script type="text/javascript" src="{{ URL::asset('public/front')}}/otherfiles/progjs/frontendmyaccount.js">
	</script>
	<script type="text/javascript">
			var page = "mayAccount";
			jQuery(document).ready(function(){
				
				var textboxid="#dob";
				var divspanid="#dobdivmyaccount";
				var mindateymd="1920-1-1";
				var maxdateymd="<?php echo date('Y')."-12-31"; ?>";
				calldatemonthyearMy(textboxid,divspanid,mindateymd,maxdateymd);
			});

			 $('#password-apply').on('hidden.bs.modal', function () {
			       $("#re_password").val('');
				   $('#passerrorshowdiv').html('');
			   
			   });


			 $( "#seo_name" ).on("keyup", function(e) {

				 	var alphanumers = /^[a-zA-Z0-9_.-]+$/;
				 	if(alphanumers.test($("#seo_name").val())){
	    				$('#seo_url_span').html($('#seo_name').val());
	    				$("#seo_url_span").css("color", "black");
						 $("#seo_url_span_error").css("display", "none");
	    				//console.log('fine');
					}else{
						 $("#seo_url_span").css("color", "red");
						 $("#seo_url_span_error").css("display", "block");
						 $('#seo_url_span').html($('#seo_name').val());
						//console.log('danger');
					}
			 		
			});



	</script>

	
	@endsection
