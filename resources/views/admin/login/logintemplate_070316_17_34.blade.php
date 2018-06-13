<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Bootstrap core CSS -->
    <link href="{{ URL::asset('public/admin')}}/bootstrap/css/bootstrap.min.css" rel="stylesheet">
	
	<!-- Font Awesome -->
	<link href="{{ URL::asset('public/admin')}}/css/font-awesome.min.css" rel="stylesheet">
	
	<!-- Endless -->
	<link href="{{ URL::asset('public/admin')}}/css/endless.min.css" rel="stylesheet">

  </head>

  <body style="background-color:rgb(69,69,69);">
	<div class="login-wrapper">
		<div class="text-center">
			<h2 class="fadeInUp animation-delay8" style="font-weight:bold">
				<span class="text-success">Endless</span> <span style="color:#ccc; text-shadow:0 1px #fff">Admin</span>
			</h2>
		</div>
		<div class="login-widget animation-delay1">	
			<div class="panel panel-default">
				<div class="panel-heading clearfix">
					<div class="pull-left">
						<i class="fa fa-lock fa-lg"></i> Login 
                        
                        
                       
					</div>

					<div class="pull-right">
						<!--<span style="font-size:11px;">Don't have any account?</span>
						<a class="btn btn-default btn-xs login-link" href="register.html" style="margin-top:-2px;"><i class="fa fa-plus-circle"></i> Sign up</a>
					--></div>
				</div>

				@if (count($errors) > 0)
				<div class="alert alert-danger">
				<ul>
				@foreach ($errors->all() as  $error)
				<li>{{ $error }}</li>
				@endforeach
				</ul>
				</div>
				@endif

				<div class="panel-body">
                    <?php
                    echo Form::open(array('url' => ADMINSEPARATOR.'/logincheck', 'method' => 'post','files' => true,'id'=>'loginfrmid','class'=>'form-login'))
                    ?> 
					
                <div class="form-group">
                    <label>Username</label>
                    <?php  echo Form::text("username", $value="", $attributes = array("id"=>"username","class"=>"form-control input-sm bounceIn animation-delay2","placeholder"=>"Username"));
                    ?>
							
						</div>
						<div class="form-group">
							<label>Password</label>
                        <?php  echo Form::password("password",  $attributes = array("id"=>"password","class"=>"form-control input-sm bounceIn animation-delay4","placeholder"=>"Password"));
                            ?>
						</div>
						<!--
                        <div class="form-group">
							<label class="label-checkbox inline">
								<input type="checkbox" class="regular-checkbox chk-delete" />
								<span class="custom-checkbox info bounceIn animation-delay4"></span>
							</label>
							Remember me		
						</div>
                        -->
		
						<div class="seperator"></div>
						<!--<div class="form-group">
							Forgot your password?<br/>
							Click <a href="#">here</a> to reset your password
						</div>-->

						<hr/>

						<button type="submit" name="loginchk" class="btn btn-success btn-sm bounceIn animation-delay5  pull-right" ><i class="fa fa-sign-in"></i> Sign in</button>
					<?php echo Form::close();?>
				</div>
			</div><!-- /panel -->
		</div><!-- /login-widget -->
	</div><!-- /login-wrapper -->

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    
    <!-- Jquery -->
	<script src="{{ URL::asset('public/admin')}}/js/jquery-1.10.2.min.js"></script>
    
    <!-- Bootstrap -->
    <script src="{{ URL::asset('public/admin')}}/bootstrap/js/bootstrap.min.js"></script>
   
	<!-- Modernizr -->
	<script src="{{ URL::asset('public/admin')}}/js/modernizr.min.js"></script>
   
    <!-- Pace -->
	<script src="{{ URL::asset('public/admin')}}/js/pace.min.js"></script>
   
	<!-- Popup Overlay -->
	<script src="{{ URL::asset('public/admin')}}/js/jquery.popupoverlay.min.js"></script>
   
    <!-- Slimscroll -->
	<script src="{{ URL::asset('public/admin')}}/js/jquery.slimscroll.min.js"></script>
   
	<!-- Cookie -->
	<script src="{{ URL::asset('public/admin')}}/js/jquery.cookie.min.js"></script>

	<!-- Endless -->
	<script src="{{ URL::asset('public/admin')}}/js/endless/endless.js"></script>
  </body>
</html>
