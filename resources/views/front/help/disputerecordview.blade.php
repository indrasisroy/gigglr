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
	
	<section class="profile_outer text-center profile_outerA">
		<div class="container">
		
			<div class="row">
				<div class="col-sm-offset-2 col-sm-8">
					<h2 class="support_heading support_headingCustom">Dispute Records</h2>		
					<p class="sub_para">
						 
					</p>	
				</div>
			</div>	
			
			<div class="row review_row">
			
			<?php
				if(count($contentheading)>0){
					foreach($contentheading as $contentele){
						$contenttext=$contentele['contenttext'];
						$disputedid=$contentele['disputedid'];
					?>

            	<div class="col-sm-12 review_cols">
					<div class="review_cell clearfix">
						<div class="col-sm-10">
							<div class="detail-text">
								{{ $contenttext }}
							</div>
						</div>
						<div class="col-sm-2">
							<div class="clearfix">
								<div class="form_right">
									<div class="support-btn">
										<button type="button" id="detailsub" data-disputeid="{{$disputedid}}" class="btn orange-btn support-btn detail-btn-view">Detail</button>
                                    </div>
								</div>
							</div>
						</div>
					</div>
				</div>
					
				<?php
					}
				}
				else{
				?>
				
				<div class="col-sm-12 review_cols">
					<div class="review_cell clearfix">
						<div class="col-sm-10">
							<div class="detail-text">
								No record is available
							</div>
						</div>
						<div class="col-sm-2">
							<div class="clearfix">
								<div class="form_right">
									<div class="support-btn">
										<button type="button" id="dis1backsub" class="btn orange-btn support-btn detail-btn-view">Back</button>
                                    </div>
								</div>
							</div>
						</div>
					</div>
				</div>
					
				<?php
				}
			?>
				
			</div>	
				
		</div>
	</section>
		
@endsection