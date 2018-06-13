<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta name="description" content="">
    <meta name="author" content="">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<link rel="icon" href="{{ }}/images/favicon.ico" type="image/x-icon">

    <title>Prosessional</title>
	
	<!-- Bootstrap core CSS -->
    <link href="{{ }}/css/bootstrap.css" rel="stylesheet">
    <!-- plugins css -->
    <link href="{{ }}/css/bootstrap-select.css" rel="stylesheet">
    <link href="{{ }}/css/font-awesome.min.css" rel="stylesheet">
    <!-- Custom styles for this template -->
	 <link href="{{ }}/css/owl.carousel.css" rel="stylesheet">
    <link href="{{ }}/css/custom.css" rel="stylesheet">
    <!-- developer use only -->
    <link href="{{ }}/css/developer.css" rel="stylesheet">
	
	
	<!-- Bootstrap core JavaScript-->
    <script src="{{ }}/js/jquery-1.9.1.min.js"></script>
    <script src="{{ }}/js/bootstrap.min.js"></script>
	<script src="{{ }}/js/retina.js"></script>
    <script src="{{ }}/js/bootstrap-select.js"></script>
    <script src="{{ }}/js/Placeholders.min.js"></script>
	<script src="{{ }}/js/owl.carousel.js"></script>
    <script src="{{ }}/js/custom.js"></script>
	
	  

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    
    <script> var ISOLDIE = false; </script>
	<!--[if lt IE 9]>
	     <script> var ISOLDIE = true; </script>
	<![endif]-->
	<script>
	     if(ISOLDIE) {
	          alert("Your browser currently does not support this feature. Please upgrade.");
	          window.location = 'http://www.microsoft.com/en-us/download/internet-explorer-9-details.aspx';
	     }	
	</script>
  </head>

  <body>
  	<div class="rainbow"></div>
  	
	<!--header starts-->
	<?php	
	$headerdataAr=array();
	$headerdataAr['testdata']="test1";	
	?>
	@include('front.includefolder.header', $headerdataAr)
	<!--header ends-->
	
	<?php	
	$bannerdataAr=array();
	$bannerdataAr['testdata']="test1";	
	?>
	<!--banner starts-->
	@include('front.includefolder.banner', $bannerdataAr)
	<!--banner ends-->
	@yield('content')
	
	<!-- footer starts -->
	@include('front.includefolder.footer', $bannerdataAr)
	<!-- footer ends -->
<!-- Modal -->


<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog popup-dialog" role="document">
    <div class="modal-content popup-content">
      <div class="modal-body popup-body">
          <button type="button" class="close popup-close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h2>SIGN UP FOR <span>FREE</span></h2>
          <?php echo Form::open(array('url' => 'registeruser','files' => true, 'method' => 'post','id'=>'signupfrmid','class'=>"" )); ?>
              <div class="alert error" style="display: none;">You are not register</div>
              <div class="alert success" style="display: none;">You are register successfully</div>
                  <div class="input-form">
                      
					<?php    
					echo Form::text("first_name", $value='', $attributes = array( "id"=>"first_name","class"=>" form-control  ","placeholder"=>"Name"));
					?>
                  </div>
                  <div class="input-form">
                      <?php    
					echo Form::text("email", $value='', $attributes = array( "id"=>"email","class"=>" form-control  ","placeholder"=>"Email"));
					?>
                  </div>
                  <div class="input-form">
                      <?php    
					echo Form::password("password",  $attributes = array( "id"=>"password","class"=>" form-control  ","placeholder"=>"Password"));
					?>
                  </div>
                  <div class="input-form">
                     <?php    
					echo Form::password("password_confirmation",  $attributes = array( "id"=>"password_confirmation","class"=>" form-control  ","placeholder"=>"Confirm password"));
					?>
                  </div>
                <div class="form-second">
                  <h5>Select your Gender</h5>
                  <div class="inlineWrap extra-margin">
                        <div class="inline">
                           <label class="radio-check">
						  
						   <?php
						   echo Form::radio('gender', '1', true,$attributes = array("id"=>"gender_id1","onclick"=>""));

						   ?>
                             <span></span>Male</label>
                          </div>
                            <div class="inline">
                                <label class="radio-check">
								 <?php
						   echo Form::radio('gender', '2', false,$attributes = array("id"=>"gender_id2","onclick"=>""));

						   ?>
                                <span></span>Female</label>
                            </div>
                            <div class="inline">
                                <label class="radio-check">
						   <?php
						   echo Form::radio('gender', '3', false,$attributes = array("id"=>"gender_id3","onclick"=>""));
						   ?>
                                <span></span>Other</label>
                            </div>
                    </div>
                        <h5>Date of Birth</h5>
                    <div class="clearfix">
                            <div class="selectWrap adj-width">
							
							 <?php    
					echo Form::text("dob", $value=date("F d, Y"), $attributes = array( "id"=>"dob","class"=>" form-control  ","placeholder"=>"dob"));
					?>
                                
                            </div>
							
							<div id="dobdivid">
							  
								  <!--<div class="selectWrap adj-width">
									<select class="selectpicker">
										<option value="0">Date</option>
										<option value="1">2</option>
										<option value="2">5</option>
										<option value="3">10</option>
									</select>
								</div>
								<div class="selectWrap extra-width">
									<select class="selectpicker ">
										<option value="0">Month</option>
										<option value="1">January</option>
										<option value="2">February</option>
										<option value="3">March</option>
									</select>
								</div>
								<div class="selectWrap extra-width">
									<select class="selectpicker">
										<option value="0">Year</option>
										<option value="1">2013</option>
										<option value="2">2014</option>
										<option value="3">2015</option>
									</select>
								</div>-->
							  
							  
							</div>  
							
                     </div>
                        <div class="terms-condi-col">
                            <label class="radio-check">
							<!--<input type="checkbox" checked="checked">-->
							<?php
							echo Form::checkbox('termscond', '1', false,$attributes = array("id"=>"termscond","onclick"=>""));
							?>
                            <span></span>I have read the Terms and Conditions </label>
                        </div>
                      <button class="btn btn-warning" type="button" id="registerbuttonid" >register</button>
                </div>
          <?php 	echo Form::close();	?>
      </div>
    </div>
  </div>
</div>
  
  
      
<!-- Modal -->
<div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog popup-dialog" role="document">
    <div class="modal-content popup-content">
      <div class="modal-body popup-body loginPopup">
       <button type="button" class="popup-close close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <?php echo Form::open(array('url' => 'loginuser','files' => true, 'method' => 'post','id'=>'loginfrmid','class'=>"" )); ?>
              <h2>Log in</h2>
              <a href="#"><img src="{{ }}/images/g-plus-btn.png" alt=""/></a>
              <span class="divider">Or</span>
              <div class="input-form">
                 
				 <?php    
					echo Form::text("login_email", $value='', $attributes = array( "id"=>"login_email","class"=>" form-control  ","placeholder"=>"Email"));
					?>
              </div>
               <div class="input-form">
                <?php    
					echo Form::password("login_password",  $attributes = array( "id"=>"login_password","class"=>" form-control  ","placeholder"=>"Password"));
				?>
             </div>
              <div class="form-second">
                  <div class="terms-condi-col">
                        <label class="radio-check">
						
						<?php
							echo Form::checkbox('keepmesigned', '1', false,$attributes = array("id"=>"keepmesigned","onclick"=>""));
							?>
                        <span></span>Keep me signed in </label>
                        <a href="#">Forgot password?</a> 
                  </div>
                  <button id="loginbuttonid" type="button" class="btn btn-warning">login</button>
              </div>
		   <?php 	echo Form::close();	?>
      </div>
        <div class="modal-footer popup-footer">
             <div class="sign-up-tips">
               <span>Don't have an account?</span>
                <a href="#" data-dismiss="modal" aria-label="Close" class="open-signup">Sign up for FREE</a>
          </div>
      </div>
          
    </div>
  </div>
</div>
  
	<!-- for day month year calendar  starts -->	
	<script type="text/javascript" src="{{ }}/otherfiles/day-month-year-calendar/day-month-year-calendar_files/day-month-year-calendar.js"></script>
	<script type="text/javascript" src="{{ }}/otherfiles/day-month-year-calendar/day-month-year-calendar_files/datepicker.js"></script>
	<script type="text/javascript" src="{{ }}/otherfiles/day-month-year-calendar/day-month-year-calendar_files/moment.js"></script>		
	<!-- for day month year calendar  ends -->
	
	<!-- for day month year calendar function calling js starts -->
	<script type="text/javascript" src="{{ }}/otherfiles/progjs/daymonthyear.js"></script>
	<!-- for day month year calendar function calling js ends -->
  
	
	 <!-- for client side validation starts -->
	<link rel="stylesheet" href="{{ }}/otherfiles/jquery-validation-1.15.0/css/screen.css">
	<script src="{{ }}/otherfiles/jquery-validation-1.15.0/dist/jquery.validate.js"></script>
	  <!-- for client side validation ends -->
	  
	  <!-- for signup js starts -->
	<script type="text/javascript" src="{{ }}/otherfiles/progjs/frontendsignup.js"></script>
	<!-- for signup js ends -->
	  <!-- for login js starts -->
	<script type="text/javascript" src="{{ }}/otherfiles/progjs/frontendlogin.js"></script>
	<!-- for login js ends -->
  
  <script>
  var base_url_data="<?php  echo url(''); ?>";
	jQuery(document).ready(function(){
	
	
	
	
	var textboxid="#dob";
	var divspanid="#dobdivid";
	var mindateymd="1920-1-1";
	var maxdateymd="<?php echo date('Y')."-12-31"; ?>";
	
	calldatemonthyear(textboxid,divspanid,mindateymd,maxdateymd);
	
		
	//**** bind registerbuttonid starts
	jQuery("#registerbuttonid").click(function(){
	
	//alert("register");
	var tokendata="<?php echo csrf_token(); ?>";
	callforregister("registeruser",tokendata);
	
	});
	
	//**** bind registerbuttonid ends
	
	
	//**** bind loginbuttonid starts
	jQuery("#loginbuttonid").click(function(){
	
	//alert("register");
	var tokendata="<?php echo csrf_token(); ?>";
	callforlogin("loginuser",tokendata);
	
	});
	
	//**** bind loginbuttonid ends
	
	
	});
  </script>
  
      
  </body>
</html>
