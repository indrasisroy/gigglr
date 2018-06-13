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

    
  	<div class="rainbow"></div>
  	
	
	<div class="dashboardPage">
		<div class="container">
			
			<div class="row">
				<button class="sidePanelBtn"><span></span><span></span><span></span></button>
					
@include('front.group.groupSidePanel')
<?php
	//print_r($hidden_value);//die;
	//$rqst_segmn1=Request::segment(2);
	//if($hidden_value!=''){
	//$hidden_value=$rqst_segmn1;
	//}else{
	//$hidden_value='';
	//}
	//echo Form::hidden('hiddenUrl', $hidden_value, $attributes = array( "id"=>"hiddenUrl"));
?>
<div id="fromDiv">
</div>
<div id="listDiv">
</div>
			</div>
		</div>
	</div>
		<?php
		if(!empty($seo_seg)){
			if($seo_seg!="")
			{
				$seo_url=$seo_seg;
			}else{
				$seo_url="";
			}
		}else{
		$seo_url="";
		}
		
		?>
	
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
		<script type="text/javascript">
			var seo_url="<?php echo $seo_url;?>";
		</script>
	  <script type="text/javascript" src="{{ URL::asset('public/front')}}/otherfiles/progjs/frontendgroupAjaxLoad.js">
	  
	</script>
	
 
</html>
	@endsection