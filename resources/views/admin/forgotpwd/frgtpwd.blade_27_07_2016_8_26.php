<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>ForgotPassword</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">


    <link href="{{ URL::asset('public/admin')}}/bootstrap/css/bootstrap.min.css" rel="stylesheet">
	

	<link href="{{ URL::asset('public/admin')}}/css/font-awesome.min.css" rel="stylesheet">
	

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
						<i class="fa fa-lock fa-lg"></i> Forgot Password 
                        
                        
                       
					</div>

					<div class="pull-right">
						</div>
				</div>

				<?php
			  $msgclass=''; $flagshowmsg=0; $msgdata="";
			  if(!empty($successmsg))
			  {
				  $msgclass=" alert-success ";
				  $flagshowmsg=1;
				  $msgdata=$successmsg;
			  }
			  elseif(!empty($errormsg))
			  {
				  $msgclass=" alert-danger ";
				  $flagshowmsg=1;
				  $msgdata=$errormsg;
			  }
			  ?>
			  <?php
			  if($flagshowmsg==1)
			  {
			  ?>
				  <div class="alert <?php echo $msgclass;  ?>" id="custommsgdivid1" >
					<?php echo $msgdata; ?>
					<a  href="" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
				  </div>
			  <?php
			  }
			  ?>  
				  

				@if (count($errors) > 0)
				<div class="alert alert-danger">
				<div class="row">
				@foreach ($errors->all() as  $error)
				<div class="col-md-12">{{ $error }}</div>
				@endforeach
				</div>
				</div>
				@endif

				<div class="panel-body">
                    <?php
                    echo Form::open(array('url' => ADMINSEPARATOR.'/sendfrgtpwd', 'method' => 'post','files' => true,'id'=>'loginfrmid','class'=>'form-login'))
                    ?> 
					
                <div class="form-group">
                    <label>Email</label>
                    <?php  echo Form::text("frgt_email", $value="", $attributes = array("id"=>"frgt_email","class"=>"form-control input-sm bounceIn animation-delay2","placeholder"=>"Email"));
                    ?>
							<span  class="errorcustclass">{{ $errors->first('frgt_email') }}</span>
						</div>

						<hr/>

						<button type="submit" name="frgtchk" class="btn btn-success btn-sm bounceIn animation-delay5  pull-right" ><i class="fa fa-sign-in"></i> Submit</button>
					<?php echo Form::close();?>
				</div>
			</div>
		</div>
	</div>


    

	<script src="{{ URL::asset('public/admin')}}/js/jquery-1.10.2.min.js"></script>
    

    <script src="{{ URL::asset('public/admin')}}/bootstrap/js/bootstrap.min.js"></script>
   

	<script src="{{ URL::asset('public/admin')}}/js/modernizr.min.js"></script>
   

	<script src="{{ URL::asset('public/admin')}}/js/pace.min.js"></script>
   

	<script src="{{ URL::asset('public/admin')}}/js/jquery.popupoverlay.min.js"></script>
   

	<script src="{{ URL::asset('public/admin')}}/js/jquery.slimscroll.min.js"></script>
   

	<script src="{{ URL::asset('public/admin')}}/js/jquery.cookie.min.js"></script>


	<script src="{{ URL::asset('public/admin')}}/js/endless/endless.js"></script>
  </body>
</html>
