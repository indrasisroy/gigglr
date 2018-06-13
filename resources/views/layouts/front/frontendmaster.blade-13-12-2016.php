<?php
$front_id_sess= session('front_id_sess');
$otherpagemetadesc='';

	//**** fetch meta_description from settings - starts
                
                $fetchtype='single'; $tablename="settings";
                $fieldnames=" welcome_text,default_radius,max_radius_limit,
                site_fax_no,meta_description,pin_secret_key,
                pin_publishable_key,pin_liveortest,service_charge ";
                $wherear=array();
                $wherear['id']=1;
                $orderbyfield="id"; $orderbytype="asc";
                $limitstart=0;$limitend=0;  $default_radius=0;$max_radius_limit=100;
                $welcometxt_heading=''; $meta_description='';
                $pin_secret_key='';$pin_publishable_key='';$pin_liveortest='';$service_charge=0;
                $fetchfrontwelcomedata=getdatafromtable($fetchtype,$tablename,$fieldnames,$wherear,$orderbyfield='',$orderbytype,$limitstart,$limitend);
                
                $frontwelcomedata='';
                if(!empty($fetchfrontwelcomedata))
                {
                     $frontwelcomedata=stripslashes($fetchfrontwelcomedata->welcome_text);
                     $default_radius=$fetchfrontwelcomedata->default_radius;
                     $max_radius_limit=$fetchfrontwelcomedata->max_radius_limit;
                     $welcometxt_heading=stripslashes($fetchfrontwelcomedata->site_fax_no);
                     $meta_description=stripslashes($fetchfrontwelcomedata->meta_description);
                     $pin_secret_key=stripslashes($fetchfrontwelcomedata->pin_secret_key);
                     $pin_publishable_key=stripslashes($fetchfrontwelcomedata->pin_publishable_key);
                     $pin_liveortest=stripslashes($fetchfrontwelcomedata->pin_liveortest);
                     $service_charge = stripslashes($fetchfrontwelcomedata->service_charge);
                    
                  
                        
                        if (fmod($service_charge, 1) == 0) 
                        {
                             //echo "no decimal";
                            $service_charge=intval($service_charge);
                            
                        }
                        else
                        {
                             //$only_decimal=fmod($service_charge, 1);
                            //echo "yes decimal=>".$only_decimal;
                            $service_charge=$service_charge;
                            

                        }
                    
                }
								
								$otherpagemetadesc=$meta_description;
							
								$routename=Route::currentRouteName(); // get route name
								
								$pgaroutenmar=array();
								$pgaroutenmar[]="frontendprofile";
								$pgaroutenmar[]="frontendgroup";
								$pgaroutenmar[]="frontendpublicVenue";
								
								//** other than artist profile page , group profile page and venue profile page get meta description from settings table
								if(!in_array($routename,$pgaroutenmar))
								{
											$metadescriptiondata=$otherpagemetadesc;
								}
								
                
	//**** fetch meta_description from settings - ends

     //************ if user is logged in then get addr_lat and addr_long  for center point for radius search starts*****
                  
                $loggedin_user_email=''; $loggedin_user_address1=''; $loggedin_user_countryid='';
                $loggedin_user_stateid=''; $loggedin_user_country_name=''; $loggedin_user_state_3_code='';
                    $loggedin_user_city_name='' ;

                    if(!empty($front_id_sess))
                   {
                        //***** fetch user data starts *****************
                        
                        $fetchtype='single'; $tablename="user_master";
                        $fieldnames=" email,address1,country,state,city ";
                        $wherear=array();
                        $wherear['id']=$front_id_sess;
                        $orderbyfield="id"; $orderbytype="asc";
                        $limitstart=0;$limitend=0;                

                        $fetchuserdata=getdatafromtable($fetchtype,$tablename,$fieldnames,$wherear,$orderbyfield='',$orderbytype,$limitstart,$limitend);


                        if(!empty($fetchuserdata))
                        {

                            $loggedin_user_email= stripslashes($fetchuserdata->email);                            
                            $loggedin_user_address1=stripslashes($fetchuserdata->address1);
                            $loggedin_user_countryid=stripslashes($fetchuserdata->country); 
                            $loggedin_user_stateid=stripslashes($fetchuserdata->state);
                            $loggedin_user_city_name=stripslashes($fetchuserdata->city);
                             
                        } 
                        
                        //***** fetch user data ends *****************
                        
                        //********** fetch country name starts **********
                        
                        if(!empty($loggedin_user_countryid))
                        {
                            $fetchtype='single'; $tablename="location_country";
                            $fieldnames=" id,country_name ";
                            $wherear=array();
                            $wherear['id']=$loggedin_user_countryid;
                            $orderbyfield="id"; $orderbytype="asc";
                            $limitstart=0;$limitend=0;                

                            $fetchuserdata=getdatafromtable($fetchtype,$tablename,$fieldnames,$wherear,$orderbyfield='',$orderbytype,$limitstart,$limitend);


                            if(!empty($fetchuserdata))
                            {

                                $loggedin_user_country_name= stripslashes($fetchuserdata->country_name);                            


                            }          
                        }
                        
                        //********** fetch country name ends **********
                        
                        
                        //********** fetch state code starts **********
                        
                        if(!empty($loggedin_user_stateid))
                        {
                            
                            $fetchtype='single'; $tablename="location_state";
                            $fieldnames=" id,state_name,state_3_code ";
                            $wherear=array();
                            $wherear['id']=$loggedin_user_stateid;
                            $orderbyfield="id"; $orderbytype="asc";
                            $limitstart=0;$limitend=0;                

                            $fetchuserdata=getdatafromtable($fetchtype,$tablename,$fieldnames,$wherear,$orderbyfield='',$orderbytype,$limitstart,$limitend);


                            if(!empty($fetchuserdata))
                            {

                                $loggedin_user_state_3_code= stripslashes($fetchuserdata->state_3_code);                            


                            }    
                        }
                        
                        //********** fetch state code ends **********

                        
                        
                        
                        
                        
                        
                   }
                //*********** if user is logged in then get addr_lat and addr_long  for center point for radius search ends *******

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta name="description" content="<?php if(!empty($metadescriptiondata)) { echo $metadescriptiondata;  }?>">
    <meta name="author" content="">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<link rel="icon" href="{{ FRONTCSSPATH}}/images/favicon.ico" type="image/x-icon">

    <title>Prosessional</title>
	
	<!-- Bootstrap core CSS -->
    <link href="{{ FRONTCSSPATH}}/css/bootstrap.css" rel="stylesheet">
    <!-- plugins css -->
    <link href="{{ FRONTCSSPATH}}/css/bootstrap-select.css" rel="stylesheet">
	<link href="{{ FRONTCSSPATH}}/css/bootstrap-datetimepicker.css" rel="stylesheet">
    <link href="{{ FRONTCSSPATH}}/css/font-awesome.min.css" rel="stylesheet">
    <!-- Custom styles for this template -->
	 <link href="{{ FRONTCSSPATH}}/css/owl.carousel.css" rel="stylesheet">
	 <link href="{{ FRONTCSSPATH}}/css/jquery.mCustomScrollbar.css" rel="stylesheet">
    <link href="{{ FRONTCSSPATH}}/css/custom.css" rel="stylesheet">
    <!-- developer use only -->
    <link href="{{ FRONTCSSPATH}}/css/developer.css" rel="stylesheet">
	<link href="{{ FRONTCSSPATH}}/css/bootstrap-slider.css" rel="stylesheet">
	
		
	
	<!-- Bootstrap core JavaScript-->
    <script src="{{ FRONTCSSPATH}}/js/jquery-1.9.1.min.js"></script>
    <script src="{{ FRONTCSSPATH}}/js/bootstrap.min.js"></script>
<!--	<script src="{{ FRONTCSSPATH}}/js/retina.js"></script>-->
	<script src="{{ FRONTCSSPATH}}/js/moment-with-locales.js"></script>
	<script src="{{ FRONTCSSPATH}}/js/bootstrap-datetimepicker.js"></script>
    <script src="{{ FRONTCSSPATH}}/js/jquery.mCustomScrollbar.js"></script> 
    <script src="{{ FRONTCSSPATH}}/js/bootstrap-select.js"></script>
    <script src="{{ FRONTCSSPATH}}/js/Placeholders.min.js"></script>
	<script src="{{ FRONTCSSPATH}}/js/owl.carousel.js"></script>
    <script src="{{ FRONTCSSPATH}}/js/custom.js"></script>
	<script src="{{ FRONTCSSPATH}}/js/bootstrap-slider.js"></script>
	  
	  
	
	  

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
	
	if(!empty($display_flag))
	{
		$other_dataAr=array();
		if(!empty($categoryAr))
		{
		  $other_dataAr['categoryAr']=$categoryAr;
		}
		$bannerdataAr=array();
		$bannerdataAr['banner_image']=$banner_image;
		$bannerdataAr['other_data']=$other_dataAr;
	?>
	<!--banner starts-->
	@include('front.includefolder.banner', $bannerdataAr)
	<!--banner ends-->
	<?php
	}
	?>
	@yield('content')
	
	<!-- footer starts -->
	<?php	
	$footerdataAr=array();
	$footerdataAr['testdata']="test1";	
	?>
	@include('front.includefolder.footer', $footerdataAr)
	<!-- footer ends -->
<!-- Modal -->


<div class="modal fade signinmodal" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog popup-dialog" role="document">
    <div class="modal-content popup-content">
      <div class="modal-body popup-body">
          <button type="button" class="close popup-close signupclose" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
         <a id="newgooglesignup" href="javascript:void(0);"><img src="{{ FRONTCSSPATH}}/images/signup-google.png" alt=""/> </a>        
         <span class="divider">Or</span> 
          <h2>SIGN UP BELOW</h2>
          <?php echo Form::open(array('url' => 'registeruser','files' => true, 'method' => 'post','id'=>'signupfrmid','class'=>"" )); ?>
              <div class="alert error" style="display: none;">You are not register</div>
              <div class="alert success" style="display: none;">You are register successfully</div>
                  <div class="input-form">
                      
					<?php    
					echo Form::text("nickname", $value='', $attributes = array( "id"=>"nickname","class"=>" form-control  ","placeholder"=>"Name"));
					?>
                  </div>
                  <div class="input-form">
                      <?php    
					echo Form::text("email", $value='', $attributes = array( "id"=>"email","class"=>" form-control  ","placeholder"=>"Email"));
					?>
					<!--******************** Check Field For G+ Start   ************************-->
					<?php    
					echo Form::hidden("is_g_plus_signup", $value='0', $attributes = array( "id"=>"is_g_plus_signup","class"=>" form-control  "));
					?>
					<!--******************** Check Field For G+ Ends   ************************-->

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
					echo Form::text("dob", $value=date("F d, Y", strtotime('1985-01-01')), $attributes = array( "id"=>"dob","class"=>" form-control  ","placeholder"=>"dob"));
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
                  <p>Please read the <a class="fntBold" target="_blank" href="<?php echo url('terms-and-conditions');?>">Terms &amp; Conditions</a> before using your wallet.</p>
								</div>-->
							  
							  
							</div>  
							
                     </div>
                        <div class="terms-condi-col">
                            <label class="radio-check">
							<!--<input type="checkbox" checked="checked">-->
							<?php
							echo Form::checkbox('termscond', '1', false,$attributes = array("id"=>"termscond","onclick"=>""));
							?>
                            <span></span> </label> I read and agree to the  <a class="fntBold" style="float: inherit !important" target="_blank" href="<?php echo url('terms-and-conditions');?>">Terms &amp; Conditions</a>
                        </div>
                      <button class="btn btn-warning" type="button" id="registerbuttonid" >register</button>
						<!--loader for signup starts-->
						<div id="signuploader" class="row margintop5 mydisplaynone">
							<div class="col-sm-4">&nbsp;</div>
							<div class="col-sm-4">
							
								<div class="row mytextcenter">
								<img width="35" src="{{ FRONTCSSPATH}}/otherfiles/progimages/loder.gif" alt="Loading...">
								</div>
								<div class="row mytextcenter">Please wait...</div>
							
							</div>
							<div class="col-sm-4">&nbsp;</div>
							
						</div>
						<!--loader for signup ends-->  
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
              <a id="glusloginancid" href="javascript:void(0);"><img src="{{ FRONTCSSPATH}}/images/g-plus-btn.png" alt=""/></a>
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
                        <!--<a href="#">Forgot password?</a> -->
						<a href="#" data-dismiss="modal" aria-label="Close" class="open-forgotpass">Forgot password?</a>
                  </div>
                  <button id="loginbuttonid" type="button" class="btn btn-warning">login</button>
              </div>
		   <?php 	echo Form::close();	?>
      </div>
        <div class="modal-footer popup-footer">
             <div class="sign-up-tips">
               <span>Don't have an account?</span>
                <a href="#" data-dismiss="modal" aria-label="Close" onclick="opensignupfrm()">Sign up for FREE</a>
          </div>
      </div>
          
    </div>
  </div>
</div>
  
  

<!--Modal For Forget Password starts here-->
  
  
<div class="modal fade forgotpassmodal" id="myModalFrgt" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog popup-dialog" role="document">
    <div class="modal-content popup-content">
      <div class="modal-body popup-body loginPopup">
       <button type="button" class="popup-close close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <?php echo Form::open(array('url' => 'forgotpass','files' => true, 'method' => 'post','id'=>'frgtpassfrm','class'=>"" )); ?>
              <h2>Forgot password ? </h2>
              <div class="input-form">
                 
				 <?php    
					echo Form::text("forgotpass_email", $value='', $attributes = array( "id"=>"forgotpass_email","class"=>" form-control  ","placeholder"=>"Email"));
					?>
              </div>
              <div class="form-second">
				  <button id="frgtpasswordbtnid" type="button" class="btn btn-warning">Submit</button>
              </div>
		   <?php 	echo Form::close();	?>
      </div>
        <div class="modal-footer popup-footer">
             <div class="sign-up-tips">
               <span>Don't have an account?</span>
                <a href="#" data-dismiss="modal" aria-label="Close" onclick="opensignupfrm()">Sign up for FREE</a>
          </div>
      </div>
          
    </div>
  </div>
</div>
	
	
  
 
 
 <!--******************* modal for payment view starts******** -->
 
 <!-- <div class="modal fade" id="myModal3paymentvieww" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content popup-content">
      <div class="modal-body popup-body wallet">
        <div class="clearfix">
          
            <div class="test1">
            	<div class="tab-content">
            		<div id="payone" class="tab-pane fade">
            			Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
            		</div>	
            		<div id="paytwo" class="tab-pane fade">
            			Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
            		</div>
            		<div id="paythree" class="tab-pane fade in active">
	            		<div class="card_payments">
		                    <h3 class="pay_hed">Pay to Wallet
                                <div class="credt_crd">
		                       
                                </div>
		                    </h3>
		                    
		                   
												<?php // echo Form::open(array('url' => 'paytowallet','files' => true, 'method' => 'post','id'=>'cardpaymentfrmid','class'=>"card_payments_content" )); ?>
                                
		                       <div class="card_inputs add_fund amount">
		                        	<span class="fund_icon"> Amount</span>
		                           
										<?php    
														// echo Form::text("price", $value='',
														// $attributes = array( "id"=>"price","class"=>"form-control txt_color","placeholder"=>"$0.00"));
														?>
		                        </div>
		                        <div class="bttn_outer">
		                            <button class="fund_btn" type="button" id="paybuttonid">
		                                Add Funds
		                            </button>
		                        </div>
		                    <?php 	//echo Form::close();	?>
		                    
		                </div>	
            		</div>	
	            	<div id="payfour" class="tab-pane fade">
            			Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
            		</div>	
            	</div>                
            </div>

                <a href="#" data-dismiss="modal" aria-label="Close" class="close popup-close wallet-close"></a>

        </div>
      </div>
      </div>
      </div>
</div> -->

   <div class="modal fade" id="myModal3paymentview" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
          <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content popup-content">
              <div class="modal-body popup-body wallet">
                <div class="clearfix">
                    <div class="test">
                        <div class="payment_menus">
                            <ul class="payment_menus_list">
                                <li ><a data-toggle="tab" href="#payone">Bank Account</a></li>
                                <li class="active"><a data-toggle="tab" href="#paytwo">Credit Card</a></li>
                                <li><a data-toggle="tab" href="#paythree">Transaction History</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="test1">
                        <div class="tab-content">
                            <div id="payone" class="tab-pane fade ">
                                <div class="card_payments">
                                    <h3 class="pay_hed fnt18">Bank Account</h3>

                                    <form class="card_payments_content" id="bankpaymentformid">
                                        
                                       
                                        
                                        <div class="minHeight">
                                            <div class="card_inputs">
                                                
                                            <?php

                                            $control_attrAr=array();
                                            $control_attrAr['id']='account_holder_name';
                                            $control_attrAr['class']=" form-control txt_color ";
                                            $control_attrAr['placeholder']='Name of Account Holder';

                                            echo Form::text("account_holder_name", $value="", $control_attrAr);

                                            ?>  
                                            <p class="common_paytobnk_errcls myerrorcolor mydisplaynone" id="account_holder_name_error"></p>    
                                                
                                            </div>
                                            <div class="row card_inputs">
                                                <div class="col-sm-4 col-md-3 col-xs-5">
                                                    
                                            <?php

                                            $control_attrAr=array();
                                            $control_attrAr['id']='bank_state_branch_code';
                                            $control_attrAr['class']=" form-control txt_color ";
                                            $control_attrAr['placeholder']='BCB 000';
                                            $control_attrAr['maxlength']='6';        

                                            echo Form::text("bank_state_branch_code", $value="", $control_attrAr);

                                            ?>
                                            <p class="common_paytobnk_errcls myerrorcolor mydisplaynone" id="bank_state_branch_code_error"></p>
                                                    
                                                    
                                                    
                                                </div>
                                                <div class="col-sm-6 col-md-5 col-xs-7">
                                                    
                                                <?php

                                                $control_attrAr=array();
                                                $control_attrAr['id']='bank_account_number';
                                                $control_attrAr['class']=" form-control txt_color ";
                                                $control_attrAr['placeholder']='Account Number';

                                                echo Form::text("bank_account_number", $value="", $control_attrAr);

                                                ?>
                                                <p class="common_paytobnk_errcls myerrorcolor mydisplaynone" id="bank_account_number_error"></p>    
                                                    
                                                </div>
                                             </div>
                                            
                                          
                                        </div>
                                        
                                        <div class="amount priceGap">
                                            <div class="card_inputs add_fund" data-currency="$">
                                                <span class="fund_icon">Amount</span>
                                                                                                
                                                 <?php

                                                $control_attrAr=array();
                                                $control_attrAr['id']='bank_transfer_amount';
                                                $control_attrAr['class']=" form-control txt_color ";
                                                $control_attrAr['placeholder']='0.00';
                                                $control_attrAr['maxlength']='4';
                                                         
                                                     
                                                echo Form::text("bank_transfer_amount", $value="", $control_attrAr);

                                                ?>
                                                <p class="common_paytobnk_errcls myerrorcolor mydisplaynone" id="bank_transfer_amount_error"></p> 
                                                
                                            </div>                                          
                                        </div>                                     
                                        
                                        
                                        
                                        <div class="clearfix btnLeftRight">
                                            <div class="inlineNew amount leftBtn">
                                                <button  id="bankpaymentsubmid" class="fund_btn" type="button">Send to my bank</button>
                                            </div>
                                            <div class="inlineNew"><span>Please Note:</span> Minimum transfer per day: $50
                                            Maximum transfer per day: $5000

                                            </div>
                                            
<!--
                                            <div class="rightBtn amount">
                                                <button class="fund_btn" type="submit">Verify Account</button>
                                            </div>
-->
                                        </div>
                                        
                                        <p>Please read the <a class="fntBold" href="<?php echo url('terms-and-conditions');?>">Terms & Conditions</a> before using your wallet.</p>

                                    </form>

                                </div>
                            </div>	
                            <div id="paytwo" class="tab-pane fade in active">
                                <div class="card_payments">
                                    <h3 class="pay_hed fnt18">We welcome
                                        <div class="credt_crd">
                                            <Span><img src="{{ FRONTCSSPATH}}/images/c1.png" alt=""> </Span> 
                                            <Span><img src="{{ FRONTCSSPATH}}/images/c2.png" alt=""> </Span> 
<!--                                            <Span><img src="images/c3.png" alt=""> </Span> -->
                                        </div>
                                    </h3>

                                    <form class="card_payments_content pin" action='posturlpage.php' method='post'>
                                        
                                         <!--for pin paymnet error show starts -->
                                        <div class='errors '>
                                        <p id="paymnnterrorheading" class="myerrorcolor mydisplaynone"></p>
                                        <ul class="mydisplaynone" ></ul>
                                        </div>
                                         <!--for pin paymnet error show ends -->
                                        
                                         <!-- hidden payment fields starts -->
                                        <div id="hiddnpaymntflddivid" style="display:none;">
                                            <div class="card_inputs">
                                                <?php

                                            $control_attrAr=array();
                                            $control_attrAr['id']='address-line1';
                                            $control_attrAr['class']=" form-control txt_color ";
                                            $control_attrAr['placeholder']='address-line1';

                                            echo Form::text("address-line1", $value="2 Sevenoaks St", $control_attrAr);

                                            ?>                                           
                                            </div>

                                             <div class="card_inputs">
                                                <?php

                                            $control_attrAr=array();
                                            $control_attrAr['id']='address-city';
                                            $control_attrAr['class']=" form-control txt_color ";
                                            $control_attrAr['placeholder']='address-city';

                                            echo Form::text("address-city", $value=$loggedin_user_city_name, $control_attrAr);

                                            ?>                                           
                                            </div>

                                             <div class="card_inputs">
                                                <?php
                                            $control_attrAr=array();
                                            $control_attrAr['id']='address-state';
                                            $control_attrAr['class']=" form-control txt_color ";
                                            $control_attrAr['placeholder']='address-state';

                                            echo Form::text("address-state", $value=$loggedin_user_state_3_code, $control_attrAr);
                                                 
                                                 

                                            ?>                                           
                                            </div>

                                            <div class="card_inputs">
                                                <?php

                                            $control_attrAr=array();
                                            $control_attrAr['id']='address-postcode';
                                            $control_attrAr['class']=" form-control txt_color ";
                                            $control_attrAr['placeholder']='address-postcode';

                                            echo Form::text("address-postcode", $value="6454", $control_attrAr);

                                            ?>                                           
                                            </div>

                                            <div class="card_inputs">
                                                <?php

                                            $control_attrAr=array();
                                            $control_attrAr['id']='address-country';
                                            $control_attrAr['class']=" form-control txt_color ";
                                            $control_attrAr['placeholder']='address-country';

                                            echo Form::text("address-country", $value=$loggedin_user_country_name, $control_attrAr);

                                            ?>                                           
                                            </div>
                                        
                                        </div>
                                        <!-- hidden payment fields ends -->
                                        
                                        
                                        <div class="card_inputs">
                                            <?php

                                        $control_attrAr=array();
                                        $control_attrAr['id']='cc-name';
                                        $control_attrAr['class']=" form-control txt_color ";
                                        $control_attrAr['placeholder']='Name on Card';

                                        echo Form::text("cc-name", $value="", $control_attrAr);
                                            
                                         
                                        ?>
                                            <p id="cc-name-error" class="common_paymnt_errcls myerrorcolor mydisplaynone"></p>
                                           
                                        </div>
<!--
                                        <div class="card_inputs txt_color card">
                                            <select class="selectpicker">
                                                <option value="0">Card Type</option>
                                                <option value="1">Visa</option>
                                                <option value="2">Mastro Card</option>
                                                <option value="3">American Express</option>
                                            </select>
                                         </div>
-->

                                        <div class="card_inputs">
                                            <?php

                                        $control_attrAr=array();
                                        $control_attrAr['id']='cc-number';
                                        $control_attrAr['class']=" form-control txt_color ";
                                        $control_attrAr['placeholder']='Card Number';
                                        $control_attrAr['maxlength']='16';    

                                        echo Form::text("cc-number", $value="", $control_attrAr);

                                        ?>
                                        <p id="cc-number-error" class="common_paymnt_errcls myerrorcolor mydisplaynone"></p>
                                           
                                        </div>

                                        <div class="row card_inputs">
                                            <div class="col-sm-5">
                                        <?php

                                        $control_attrAr=array();
                                        $control_attrAr['id']='cc-cvc';
                                        $control_attrAr['class']=" form-control txt_color ";
                                        $control_attrAr['placeholder']='CVV';
                                        //$control_attrAr['maxlength']='4';

                                        echo Form::text("cc-cvc", $value="", $control_attrAr);

                                        ?>
                                           <p id="cc-cvc-error" class="common_paymnt_errcls myerrorcolor mydisplaynone"></p>          

                                            </div>
                                            <div class="col-sm-7">
                                                <div class="row exp_dates">
                                                    <div class="col-sm-4 date_label">Expiry Date </div>

                                                    <div class="col-sm-4">
                                                        <span>
                                    <?php 
                                    $control_attrAr=array();
                                    $control_attrAr['id']='cc-expiry-month';
                                    $control_attrAr['class']=" selectpicker ";


                                    $expiry_monthAr=array();
                                    $expiry_monthAr[""]="MM";	$expirymonthsel='';
                                    $expcurrmonthdata=1;  $expendmonthdata=12;                          
                                    for( $mm=$expcurrmonthdata; $mm<=$expendmonthdata; $mm++)
                                    {
                                        if($mm<=9)
                                        {
                                            $mm='0'.$mm;
                                        }
                                        $expiry_monthAr[$mm]=$mm;
                                    }
                            echo Form::select('cc-expiry-month', $expiry_monthAr, $expirymonthsel,$control_attrAr);	

                                    ?>
                                                        </span>    
                                                        <p id="cc-expiry-month-error" class="common_paymnt_errcls myerrorcolor mydisplaynone"></p>
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <span>
                                                            <?php 
                                                            
                                                            $control_attrAr=array();
                                                            $control_attrAr['id']='cc-expiry-year';
                                                            $control_attrAr['class']=" selectpicker ";


                                                            $expiry_yearAr=array();
                                                            $expiry_yearAr[""]="YYYY";	$expiryyearsel='';
                                                            $expcurryeardata=date("Y");  $expendyeardata=intval($expcurryeardata)+15;                          
                                                            for( $yy=$expcurryeardata; $yy<=$expendyeardata; $yy++)
                                                            {
                                                                    $expiry_yearAr[$yy]=$yy;
                                                            }
                                                            
                                                                //echo "<pre>"; print_r($expiry_yearAr);
								
								                            echo Form::select('cc-expiry_year', $expiry_yearAr, $expiryyearsel,$control_attrAr);	
                                                            
                                                            
           
                                                            
                                                            ?>
                                                           
                                                        </span>
                                                        <p id="cc-expiry-year-error" class="common_paymnt_errcls myerrorcolor mydisplaynone"></p>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                       <div class="card_inputs add_fund amount" data-currency="$">
                                            <span class="fund_icon">Amount</span>
                                        <?php

                                        $control_attrAr=array();
                                        $control_attrAr['id']='cc-amount';
                                        $control_attrAr['class']=" form-control txt_color ";
                                        $control_attrAr['placeholder']='0.00';
                                        $control_attrAr['maxlength']='4';

                                        echo Form::text("cc-amount", $value="", $control_attrAr);

                                        ?>
                                        <p id="cc-amount-error" class="common_paymnt_errcls myerrorcolor mydisplaynone"></p>    
                                        </div>
                                        <div class="btmGap">
                                            <div class="inlineNew amount leftBtn">
                                                <button id="paymentbutid" class="fund_btn " type="submit">
                                                Add Funds
                                                </button>
                                            
                                                
                                                
                                                
                                            </div>
                                            <div class="inlineNew"><span>Please Note:</span> 
                                            Credit Card purchases and refunds incur an additional <?php echo $service_charge; ?>% transaction fee.    
                                            <p>Minimum purchase per day: $50 Maximum purchase per day: $5000</p>
                                            
                                            
                                                
                                            
                                            </div>
                                        </div>
                                        
                                        <p>Please read the <a class="fntBold" target="_blank" href="<?php echo url('terms-and-conditions');?>">Terms &amp; Conditions</a> before using your wallet.</p>
                                        
                                    </form>

                                </div>	
                            </div>	
                            <div id="paythree" class="tab-pane fade">
                                
                                
                                <div class="card_payments card_paymentsC">
                                    <h3 class="pay_hed fnt18">Transaction History</h3>
<!--                                    <div class="text-center noData">No Transaction History</div>-->
<!--                                    <div class="netFund">Funds on your Wallet: <span>$1467.00</span></div>-->
                                    
<!--                                    mCustomScrollbar-->
                                    
                                    <div class="payTableCol">
                                        <div class="payTableList">
<!--                                            <h3>pro - <span>a</span><sup>* * * * *</sup> = Paid to Artist</h3>-->
                                        <table class="table payTable">
                                            <thead>
                                                <tr>
                                                    <th style="width: 95px;">
                                                        Date &amp; Time
                                                    </th>
                                                     <th style="width: 158px;">
                                                        Activity Summary
                                                    </th>
                                                    <th style="width: 95px;">
                                                        Debit
                                                    </th>
                                                    <th style="width: 95px;">
                                                        Credit
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody id="transbdyid">

                                               
                                            </tbody>
<!--
                                            <tfoot>
                                                <tr>
                                                    <th>&nbsp;</th>
                                                    <th>
                                                         <span>Total</span>
                                                    </th>
                                                    <th>
                                                        <span class="lett-spac">$11900</span>
                                                    </th>
                                                    <th>
                                                        <span class="lett-spac">$2100</span>
                                                    </th>
                                                </tr>
                                            </tfoot>
-->
                                        </table>
                                        <div class="netFund clearfix">Wallet Balance: <span id='wallet_tot_bal_id'></span></div>
                                        
                                            <div id="paym_trans_pagination_link"></div>
                                            
                                        </div>
                                    </div>
<!--
                                    <div class="full-info">
                                            <span>EVE - Event</span>
                                            <span>GIG - Gig</span>
                                            <span>COM - Commission</span>
                                            <span>A - Artist</span>
                                            <span>G - Group</span>
                                            <span>V - Venue</span>
                                        </div>
-->
                                </div>
                                
                                
                                
                            </div>	
                        </div>                
                    </div>
        <!--            <div class="modal-footer popup-footer">-->
        <!--             <div class="sign-up-tips">-->
        <!--               <span>Don't have an account?</span>-->
                        <a href="#" data-dismiss="modal" aria-label="Close" class="close popup-close wallet-close"></a>
        <!--          </div>-->
        <!--      </div>-->
                </div>
              </div>
              </div>
              </div>

      </div>
 
 <!--******************* modal for payment view ends******** -->
 
  <!--******************* common loader starts******** -->
	<div id="divLoading" class="mydisplaynone">
	<div id="loaderimgdivid">
		<img src="">
		<span id="loadercustomtxt">       
		</span>
      </div>
      
    </div>
	<!--******************* common loader ends******** -->

      <script>
  var base_url_data="<?php  echo url(''); ?>";
  
  var csrf_token_data="<?php echo csrf_token(); ?>";
  var gploginbuttonclickedflag=0;
  var googleloginfiredfrom="";//  signupmodal/loginmodal   





  	var bookingmodalcheckoption = "";   //artist-modal-open    venue-modal-open  group-modal-open



  
      </script>
<!--Modal For Forget Password ends here-->
   <!-- for developer purpose css starts -->
	<link rel="stylesheet" href="{{ FRONTCSSPATH}}/otherfiles/progcss/mydevelopmentcustom.css">
	 <!-- for developer purpose css ends -->
  
	<!-- for day month year calendar  starts -->	
	<script type="text/javascript" src="{{ FRONTCSSPATH}}/otherfiles/day-month-year-calendar/day-month-year-calendar_files/day-month-year-calendar.js"></script>
	<script type="text/javascript" src="{{ FRONTCSSPATH}}/otherfiles/day-month-year-calendar/day-month-year-calendar_files/datepicker.js"></script>
	<script type="text/javascript" src="{{ FRONTCSSPATH}}/otherfiles/day-month-year-calendar/day-month-year-calendar_files/moment.js"></script>		
	<!-- for day month year calendar  ends -->
	
	<!-- for day month year calendar function calling js starts -->
	<script type="text/javascript" src="{{ FRONTCSSPATH}}/otherfiles/progjs/daymonthyear.js"></script>
	<!-- for day month year calendar function calling js ends -->
  
	
	 <!-- for client side validation starts -->
	<link rel="stylesheet" href="{{ FRONTCSSPATH}}/otherfiles/jquery-validation-1.15.0/css/screen.css">
	<script src="{{ FRONTCSSPATH}}/otherfiles/jquery-validation-1.15.0/dist/jquery.validate.js"></script>
	  <!-- for client side validation ends -->
	  
	  <!-- for popup alert starts -->
	  <link rel="stylesheet" href="{{ FRONTCSSPATH}}/otherfiles/toastr/toastr.min.css">
	<script type="text/javascript" src="{{ FRONTCSSPATH}}/otherfiles/toastr/toastr.min.js"></script>
	<script type="text/javascript" src="{{ FRONTCSSPATH}}/otherfiles/toastr/mycustomtoastr.js"></script> 
	<!-- for popup alert starts -->
	  
	  <!-- for signup js starts -->
	<script type="text/javascript" src="{{ FRONTCSSPATH}}/otherfiles/progjs/frontendsignup.js"></script>
	<!-- for signup js ends -->
	  <!-- for login js starts -->
	<script type="text/javascript" src="{{ FRONTCSSPATH}}/otherfiles/progjs/frontendlogin.js"></script>
	<!-- for login js ends -->
	
	<!-- for forgotpassword js starts -->
	<script type="text/javascript" src="{{ FRONTCSSPATH}}/otherfiles/progjs/frontendforgotpass.js"></script>
	<!-- for forgotpassword js ends -->
	
	
	
  <!-- for confirm box css and js starts -->
	 <link rel="stylesheet" type="text/css" href="{{ FRONTCSSPATH}}/otherfiles/confirmboxlib/css/jquery-confirm.css" />
   <script type="text/javascript" src="{{ FRONTCSSPATH}}/otherfiles/confirmboxlib/js/jquery-confirm.js"></script>
	<!-- for confirm box css and js ends -->
	
  
      <script>
      function opensignupfrm()
      {
          setTimeout(function(){
			              
              $("#myModal").modal('show');
			}, 500);
          
      	
      }
  
	jQuery(document).ready(function(){
	
	
	
	
	
	var textboxid="#dob";
	var divspanid="#dobdivid";
	var mindateymd="1920-1-1";
	var maxdateymd="<?php echo date('Y')."-12-31"; ?>";
	
	calldatemonthyear(textboxid,divspanid,mindateymd,maxdateymd);
	
		
	//**** bind registerbuttonid starts
	jQuery("#registerbuttonid").click(function(){
	
	//alert("register");
	//var tokendata="<?php echo csrf_token(); ?>";
	callforregister("registeruser",csrf_token_data);
	
	});
	
	//**** bind registerbuttonid ends
	
	//*** bind login button with password field starts 

	$('#login_password').keypress(function (e) {
	var key = e.which;
		if(key == 13)  // the enter key code
		{
			$('#loginbuttonid').trigger('click');
		
		}
	});  

	//*** bind login button with password field ends
	
	//**** bind loginbuttonid starts
	jQuery("#loginbuttonid").click(function(){
	
	//alert("register");
	//var tokendata="<?php echo csrf_token(); ?>";
	callforlogin("loginuser",csrf_token_data);
	
	});
	
	//**** bind loginbuttonid ends
	
	//**************bind forgot password button starts here
	
	jQuery("#frgtpasswordbtnid").click(function(){
	
	//alert("register");
	//var tokendata="<?php echo csrf_token(); ?>";
	callforforgotpassword("forgotpass",csrf_token_data);
	
	});
	
	//************** bind forgot password button ends here
	
	
	//*** for message popup call starts
	
	var msgtype='success';	
	var msgdata='';
	var tmo=2000; var etmo=500; var sd=1000; var hd=1500; var poscls='toast-bottom-center';
	
	
	var poscls='toast-top-full-width'; //toast-bottom-center
	
	<?php if(!empty($successmsgdata)) { ?>
	
	<?php if(!empty($etmodata)){ ?>tmo="<?php  echo $tmodata; ?>";	<?php } ?>
	<?php if(!empty($etmodata)){ ?>etmo="<?php  echo $etmodata; ?>";	<?php } ?>
	<?php if(!empty($sddata)){ ?>sd="<?php  echo $sddata; ?>";<?php } ?>
	<?php if(!empty($hddata)){ ?>hd="<?php  echo $hddata; ?>";<?php } ?>
	<?php if(!empty($posclsdata)){ ?>poscls='<?php  echo $posclsdata;?>'; <?php } ?>
	
	msgtype='success';	msgdata="<?php echo $successmsgdata; ?>";
	
	poptriggerfunc(msgtype,titledata='',msgdata,sd,hd,tmo,etmo,poscls);
	
	
		
	
	<?php } ?>
	
	<?php if(!empty($errormsgdata)) { ?>
	
	<?php if(!empty($etmodata)){ ?>tmo="<?php  echo $tmodata; ?>";	<?php } ?>
	<?php if(!empty($etmodata)){ ?>etmo="<?php  echo $etmodata; ?>";	<?php } ?>
	<?php if(!empty($sddata)){ ?>sd="<?php  echo $sddata; ?>";<?php } ?>
	<?php if(!empty($hddata)){ ?>hd="<?php  echo $hddata; ?>";<?php } ?>
	<?php if(!empty($posclsdata)){ ?>poscls='<?php  echo $posclsdata;?>'; <?php } ?>
	
	msgtype='error';	msgdata="<?php echo $errormsgdata; ?>";
	poptriggerfunc(msgtype,titledata='',msgdata,sd,hd,tmo,etmo,poscls);
	
	<?php } ?>
	
	
	
	//*** for message popup call ends
        
        
        
         
	
	jQuery(document).ready(function(){
      
        jQuery("#newgooglesignup").click(function(){
            
                googleloginfiredfrom="signupmodal";
            
                $("#gConnect").find("div").eq(0).find("button").trigger('click');
                gploginbuttonclickedflag=1;
        });
           
       /********** For Account Complete Start Here  **********/ 

       /********** For Account Complete Ends Here  **********/  
	
	jQuery("#glusloginancid").click(function(){
	
	googleloginfiredfrom="loginmodal";
        
	$("#gConnect").find("div").eq(0).find("button").trigger('click');
	gploginbuttonclickedflag=1;
	
	});
	
	
	});
	
	
	});
  </script>

@if ( session()->has('status') )
			<script type="text/javascript">
			poptriggerfunc(msgtype='error',titledata='',msgdata='{{ session()->get('status') }}',sd=1000,hd=1500,tmo=5000,etmo=null,poscls='toast-top-full-width');         
			</script>	
@endif

	
	<?php
	if(empty($front_id_sess))
	{
	$settingsdatares = getsettingdata();
  	$settingsgoogleapi = $settingsdatares->client_id ? $settingsdatares->client_id : '';
  	// data-clientid="638262739500-o32j0h4docpjbib4q59i6bicui0n6jhp.apps.googleusercontent.com"
	?>
	<!--*************** script for googleplus login starts -->
	
  <style>
  iframe[src^="https://apis.google.com"] {
  display: none;
  }
  </style>

 <!-- Include the API client and Google+ client. -->
    <script src = "https://plus.google.com/js/client:platform.js" async defer></script>
 
    <!--  Container with the Sign-In button. -->
    <div id="gConnect" class="button" style="display:none;">
      <button class="g-signin"
          data-scope="email"
          data-clientid="<?php echo $settingsgoogleapi; ?>"
          data-callback="onSignInCallback"
          data-theme="dark"
          data-cookiepolicy="single_host_origin">
      </button>
      <!-- Textarea for outputting data -->
      <div id="response" class="hide">
        <textarea id="responseContainer" style="width:100%; height:150px"></textarea>
      </div>
    </div>
	  
  <script>
  var gplus_access_token='';
  </script>
	
	<script type="text/javascript" src="{{ FRONTCSSPATH}}/otherfiles/progjs/googlepluscustom.js"></script>
	
  <!--******************* script for googleplus login ends -->
    <?php } ?>
	
	<script type="text/javascript" src="{{ FRONTCSSPATH}}/otherfiles/progjs/commoncustomloaderjs.js"></script>
      
    <?php if(!empty($front_id_sess)){  ?>
      
	     <!-- for payment  related js starts -->
            <script>
            var pin_publishable_key="<?php echo $pin_publishable_key; ?>";  
            var pin_liveortest="<?php echo $pin_liveortest; ?>";
            var loggedin_user_state_3_code="<?php echo $loggedin_user_state_3_code; ?>"; 
            var loggedin_user_country_name="<?php echo $loggedin_user_country_name; ?>";
            </script>   
            <!--	<script type="text/javascript" src="{{ FRONTCSSPATH}}/otherfiles/progjs/frontendpayment.js"></script>-->
            <script src='https://cdn.pin.net.au/pin.v2.js'></script>  
            <script src="{{ FRONTCSSPATH}}/otherfiles/progjs/frontendtransactiontable.js"></script> 
            <script src="{{ FRONTCSSPATH}}/otherfiles/progjs/pinpaymnetmycustom.js"></script> 
        <!-- for payment  related js ends -->
   
  <?php } ?>    
      
	
  </body>
</html>
