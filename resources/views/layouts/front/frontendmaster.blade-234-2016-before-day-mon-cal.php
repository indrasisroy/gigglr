<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta name="description" content="">
    <meta name="author" content="">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<link rel="icon" href="images/favicon.ico" type="image/x-icon">

    <title>Prosessional</title>
	
	<!-- Bootstrap core CSS -->
    <link href="{{ }}/css/bootstrap.css" rel="stylesheet">
    <!-- plugins css -->
    <link href="{{ }}/css/bootstrap-select.css" rel="stylesheet">
    <link href="{{ }}/css/font-awesome.min.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="{{ }}/css/custom.css" rel="stylesheet">
    <!-- developer use only -->
    <link href="{{ }}/css/developer.css" rel="stylesheet">
	
	
	<!-- Bootstrap core JavaScript-->
    <script src="{{ }}/js/jquery-1.9.1.min.js"></script>
    <script src="{{ }}/js/bootstrap.min.js"></script>
    <script src="{{ }}/js/bootstrap-select.js"></script>
    <script src="{{ }}/js/Placeholders.min.js"></script>
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
          <form>
              <div class="alert error" style="display: none;">You are not register</div>
              <div class="alert success" style="display: none;">You are register successfully</div>
                  <div class="input-form">
                      <input type="text" class="form-control" placeholder="Name"/>
                  </div>
                  <div class="input-form">
                      <input type="text" class="form-control" placeholder="Email"/>
                  </div>
                  <div class="input-form">
                      <input type="text" class="form-control" placeholder="Password"/>
                  </div>
                  <div class="input-form">
                      <input type="text" class="form-control" placeholder="Confirm Password"/>
                  </div>
                <div class="form-second">
                  <h5>Select your Gender</h5>
                  <div class="inlineWrap extra-margin">
                        <div class="inline">
                           <label class="radio-check"><input type="radio" name="ab" checked="checked">
                             <span></span>Male</label>
                          </div>
                            <div class="inline">
                                <label class="radio-check"><input type="radio" name="ab" checked="checked">
                                <span></span>Female</label>
                            </div>
                            <div class="inline">
                                <label class="radio-check"><input type="radio" name="ab" checked="checked">
                                <span></span>Other</label>
                            </div>
                    </div>
                        <h5>Date of Birth</h5>
                    <div class="clearfix">
                            <div class="selectWrap adj-width">
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
                            </div>
                     </div>
                        <div class="terms-condi-col">
                            <label class="radio-check"><input type="checkbox" checked="checked">
                            <span></span>I have read the Terms and Conditions </label>
                        </div>
                      <button class="btn btn-warning">register</button>
                </div>
          </form>
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
          <form>
              <h2>Log in</h2>
              <a href="#"><img src="{{ }}/images/g-plus-btn.png" alt=""/></a>
              <span class="divider">Or</span>
              <div class="input-form">
                 <input type="text" class="form-control" placeholder="Username"/>
              </div>
               <div class="input-form">
                <input type="text" class="form-control" placeholder="Password"/>
             </div>
              <div class="form-second">
                  <div class="terms-condi-col">
                        <label class="radio-check"><input type="checkbox" checked="checked">
                        <span></span>Keep me signed in </label>
                        <a href="#">Forgot password?</a> 
                  </div>
                  <button class="btn btn-warning">login</button>
              </div>
        </form>
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
      
  </body>
</html>
