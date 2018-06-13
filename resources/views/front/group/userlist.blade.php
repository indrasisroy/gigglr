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


  <body>
  	<div class="rainbow"></div>
  	
	
	<div class="dashboardPage">
		<div class="container">
			
			<div class="row">
				<button class="sidePanelBtn"><span></span><span></span><span></span></button>
					
@include('front.group.groupSidePanel')
<div id="userList"></div>
			</div>
		</div>
	</div>
	
	<!-- footer -->
	
	<script>
		$(document).ready(function(){
			$(".hasAc a").click(function(){
				if(false == $(this).next('ul').is(':visible')) {
					$('.leftMentSub').slideUp(300);
					$('.hasAc').removeClass('selected');
				}
				$(this).next('.leftMentSub').slideToggle(300);
				$(this).parent('li').toggleClass('selected');
			});	
		});
	</script>

</html>
	@endsection