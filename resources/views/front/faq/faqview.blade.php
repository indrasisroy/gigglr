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


  	
<!-- profile-section-start -->
	
<section id="faqsecid" class="profile_outer text-center">
	<div class="container">
		<div class="row">
			<div class="col-sm-offset-2 col-sm-8">	
			</div>
		</div>	
		<div class="row">	
		</div>	
		<div class="row">
		</div>
		<div id="accordion2" class="panel-group row">
		<?php
			$counterfaq = count($faqpage);
			$j = 0;
			$divfaq = round($counterfaq / 2);
			if($counterfaq>0)
			{
		?>
			<h2 class="watch_heading">FAQ</h2>		
			<div class="text-left">
			<?php
				foreach($faqpage as $faq)
				{
					if($j%$divfaq==0)
					{
			?>
				<div class="col-sm-6">
				<?php
					}
				?>
					<div class="panel panel-default">				
						<a data-toggle="collapse" class="accordian_nav collapsed" data-parent="#accordion" href="#collapse<?php echo ($j+100);?>"><?php echo ($j+1).". ".$faq->title?></a>					
						<div id="collapse<?php echo ($j+100);?>" class="panel-collapse collapse">					
							<div class="panel-body">					
								{!! html_entity_decode($faq->description) !!}
							</div>					
						</div>
					</div>
				<?php
					$j++;
					if($j%$divfaq==0)
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
</section>
		

