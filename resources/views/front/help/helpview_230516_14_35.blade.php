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
@extends('layouts.front.frontendmaster',['successmsg' => $successmsg,'errormsg'=>$errormsg])
@section('content')
  
	
	<!-- profile-section-start -->
	<section class="profile_outer text-center">
		<div class="container">
			<div class="row">
				<div class="col-sm-offset-2 col-sm-8">
					<h2 class="support_heading">Help & Support</h2>
						<?php
						if(!empty($artile)){
						?>
						{!! html_entity_decode($artile->description) !!}
						<?php
						}
						?>
				</div>
			</div>	
			<div class="row">
				<div class="col-sm-offset-2 col-sm-8">
					<div class="row faq_cols_outer">
						<div class="col-sm-4 col-xs-4">
							<a href="javascript:void(0)" class="faq_cols">FAQ</a>
						</div>
						<div class="col-sm-4 col-xs-4">
							<a href="javascript:void(0)" class="faq_cols faq_col2">How-To</a>
						</div>
						<div class="col-sm-4 col-xs-4">
							<a href="javascript:void(0)" class="faq_cols faq_col3">Docs</a>
						</div>
					</div>					
				</div>
			</div>	

				<?php
				$watch_link_color = ['watch_link','watch_link blue_bg','watch_link green_bg','watch_link orange_bg','watch_link purple_bg'];
				$images_array = ['magnifying_glass','book_icon','chat_icon','calender2','account_icon'];
				$watch_col_span = ['watch_col_span pink_col','watch_col_span','watch_col_span','watch_col_span','watch_col_span','watch_col_span'];

					if(!empty($howitsdone) && $howitsdone!='')
				{
				?>
				<h2 class="watch_heading">WATCH HOW IT'S DONE</h2>	
				<div class="watch_col_outer clearfix">
				<?php
				$howit['index']=$howitsdone;
				$arryLen = count($howitsdone);
						for($i=0;$i<$arryLen;$i++)
					{
				$idindex = ($howit['index'][$i]->id) - 1;
					?>
				<div class="watch_col">
							<a href="javascript:void(0)" class="<?php echo $watch_link_color[$idindex];?> videoClass" data-id="<?php  echo $howit['index'][$i]->id;?>" data-youtube_embed="<?php  echo $howit['index'][$i]->youtube_embed;?>">
								<span class="watch_col_span pink_col"><?php  echo $howit['index'][$i]->title;?></span>
								<img src="{{ URL::asset('public/front')}}/images/<?php echo $images_array[$idindex];?>.png" alt="" />
							</a>
						</div>
					<?php
					}
				?>
				</div>
				<?php
				}
				?>
				<div id="loderDiv" class="marginbottom20" style="display:none">
				
				<img src="{{ URL::asset('public/front')}}/otherfiles/progimages/loder.gif" alt="Smiley face">
				<h4>Loading...</h4>
				</div>
					<div class="row">
						<div class="youtubeplay marginbottom30 col-md-12" style="display:none">
					
					<object width="640" height="390">
					
					<!--  <embed src="https://www.youtube.com/v/M7lc1UVf-VE?version=3&autoplay=1"
							 type="application/x-shockwave-flash"
							 allowscriptaccess="always"
							 width="640" height="390"></embed>-->
					<!--<iframe width="854" height="480" src="https://www.youtube.com/embed/3n-qi14f6y8?autoplay=1" frameborder="0" allowfullscreen></iframe>-->
					</object>
				</div>
					</div>
				

					<div id="accordion" class="panel-group row">
					<?php
					$counter = count($supportbypage);
					$j = 0;
					if($counter>0)
					{
					?>
					<h2 class="watch_heading">SUPPORT BY PAGE</h2>		
					<div class="text-left">
					<?php
		
					
					foreach($supportbypage as $suppor)
					{
					if($j%3==0)
					{
					?>
						<div class="col-sm-6">
					<?php
					}
					?>		<div class="panel panel-default">				
						        <a data-toggle="collapse" class="accordian_nav collapsed" data-parent="#accordion" href="#collapse<?php echo ($j+1);?>"><?php echo ($j+1).". ".$suppor->title?></a>					
						        <div id="collapse<?php echo ($j+1);?>" class="panel-collapse collapse">					
						            <div class="panel-body">					
						                <p>
						                	<?php
											echo $suppor->description;
											?>
						                </p>
						            </div>					
						        </div>
							</div>
					<?php
					$j++;
					if($j%3==0)
					{
					?>
						</div>
					<?php
					}
					}
					?>
					</div>
					<?php
					}
					?>


					 
				    </div>
			</div>
		</div>
	</section>	
	<!-- profile-section-end -->
	<script type="text/javascript">
		var loderImage = "{{ URL::asset('public/front')}}/otherfiles/progimages/loder.gif";
	</script>
	<script type="text/javascript" src="{{ URL::asset('public/front')}}/otherfiles/progjs/frontendhelp.js"></script>
	
	@endsection
