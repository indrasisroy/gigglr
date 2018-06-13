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
@extends('layouts.admin.adminmaster',['successmsg' => $successmsg,'errormsg'=>$errormsg])
@section('content')
	<?php
	
	$id=0; $page_name=''; $amenity_name=''; $status='';
	$amenity_img='';$imgurldata='';
	
	if(!empty($amenitiesrow))
	{
		
		$amenity_name=stripslashes($amenitiesrow->amenity_name);
		$status=stripslashes($amenitiesrow->status);
		$amenity_img=stripslashes($amenitiesrow->amenity_img);
		$id=$amenitiesrow->id;
		 
		 $imgurldata = asset('upload/amenities-image/source-file/'.$amenitiesrow->amenity_img);
	}
	
	
	

	
	?>
			<div class="padding-md">
				<div class="row">
					<div class="col-md-8 col-md-offset-2">
						<div class="panel panel-default">
							
								
								<?php echo Form::open(array('url' => ADMINSEPARATOR.'/amenitiessave','files' => true, 'method' => 'post','id'=>'amenitiesaddfrmid','class'=>"form-horizontal form-border no-margin" )); ?>
								<div class="panel-heading">
								 Save Amenity
								</div>
								<div class="panel-body">
								
								
									
									
									<div class="form-group">
										<label class="control-label col-lg-4">* Name</label>
										<div class="col-lg-6">
											<?php    
    echo Form::text("amenity_name", $value=$amenity_name, $attributes = array( "id"=>"amenity_name","class"=>" form-control input-sm parsley-validated ")); ?>
	<span  class="errorcustclass">{{ $errors->first('amenity_name') }}</span>										
										</div><!-- /.col -->
									</div><!-- /form-group -->
									
									<div class="form-group">
										<label class="control-label col-lg-4">* Image
										
										<br>Width : 27px
										<br>Height : 27px
										<br>Allowed File Extention : .png
										</label>
											<br>
											
										<div class="col-lg-6">
											<input type="file" name="amenity_img[]" class="form-control input-sm" value=""  multiple >
	<span  class="errorcustclass"><?php echo $errors->first('amenity_img');  ?></span>
		
		<br><p><?php if(!empty($imgurldata)){ ?><img src="<?php echo $imgurldata; ?>" onclick="javascript:showIMageFancy('<?php echo $amenity_img; ?>');"> <?php } ?></p>
		
		
		
										</div><!-- /.col -->
									</div><!-- /form-group -->
									
									
									
								</div>
								<div class="panel-footer ">
								
									<button class="btn btn-success" type="submit">Submit</button>
									<a class="btn btn-warning" href="<?php echo  url(ADMINSEPARATOR.'/amenities'); ?>"><i class="fa fa-chevron-left"></i> Back</a>
								</div>
									<input type="hidden" name="amenitiesid" value="<?php echo $id; ?>" >
									<input type="hidden" name="prev_amenities_image" value="<?php echo $amenity_img; ?>" >
									
							<?php
							
							echo Form::close();
							
							?>
						</div><!-- /panel -->
					</div>
					</div>
			</div><!-- /.padding-md -->

<!-- Add fancyBox main JS and CSS files starts -->
<script type="text/javascript" src="{{ URL::asset('commonassets')}}/fancybox/source/jquery.fancybox.js?v=2.1.5"></script>
<link rel="stylesheet" type="text/css" href="{{ URL::asset('commonassets')}}/fancybox/source/jquery.fancybox.css?v=2.1.5" media="screen" />
<!-- Add fancyBox main JS and CSS files ends -->
			
			<script>
			
			function showIMageFancy(imagename)
			{
			
				if(imagename!='')
				{
					$.fancybox.open("<?php echo URL::asset('upload/amenities-image/source-file');?>"+"/"+imagename);
				
					$('.fancybox-opened').css('z-index',999999);
				}
			}
			
			</script>
    
@endsection