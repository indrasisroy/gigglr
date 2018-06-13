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
	<section class="profile_outer text-center">
		<div class="container">
			<div class="row">
				<div class="col-sm-offset-2 col-sm-8">
					<h2 class="support_heading"><?php echo stripslashes($titledata) ?> </h2>		
					<p class="sub_para">
						
					</p>	
				</div>
			</div>	
			
			
			<div class="text-left">
					<div id="accordion" class="panel-group row">

					<div class="col-sm-2"></div>

						<div class="col-sm-8">
							
						  <?php echo html_entity_decode($description) ?>

						</div> <!-- end of col-sm -12 -->
				<div class="col-sm-2"></div>		   
						
					   <!--  <div class="col-sm-6">
						   
						   	
					    </div> -->
				    </div>
			</div>
		</div>
	</section>	
	<!-- profile-section-end -->

	@endsection