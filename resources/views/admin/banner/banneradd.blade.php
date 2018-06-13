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
	
	$id=0; $page_name=''; $title=''; $status='';
	$banner_image='';$imgurldata='';
	
	if(!empty($bannerrow))
	{
		
		$title=stripslashes($bannerrow->title);
		$status=stripslashes($bannerrow->status);
		$banner_image=stripslashes($bannerrow->banner_image);
		$id=$bannerrow->id;
		 
		 // $imgurldata = asset('public/upload/banner-image/thumb-medium/'.$bannerrow->banner_image);
		$imgurldata = BASEURLPUBLICCUSTOM.'upload/banner-image/thumb-medium/'.$bannerrow->banner_image;
	}
	
	
	

	
	?>
			<div class="padding-md">
				<div class="row">
					<div class="col-md-8 col-md-offset-2">
						<div class="panel panel-default">
							
								
								<?php echo Form::open(array('url' => ADMINSEPARATOR.'/bannersave','files' => true, 'method' => 'post','id'=>'banneraddfrmid','class'=>"form-horizontal form-border no-margin" )); ?>
								<div class="panel-heading">
								 Save Package
								</div>
								<div class="panel-body">
								
								
									
									
									<div class="form-group">
										<label class="control-label col-lg-4">*Title </label>
										<div class="col-lg-6">
											<?php    
    echo Form::text("title", $value=$title, $attributes = array( "id"=>"title","class"=>" form-control input-sm parsley-validated ")); ?>
	<span  class="errorcustclass">{{ $errors->first('title') }}</span>										
										</div><!-- /.col -->
									</div><!-- /form-group -->
									
									<div class="form-group">
										<label class="control-label col-lg-4">*Banner Image
										
										<br>Minimum Width : 1503px
										<br>Minimum Height : 710px
										<br>Allowed File Extention : .jpg /.jpeg
										</label>
											<br>
											
										<div class="col-lg-6">
											<input type="file" name="banner_image[]" class="form-control input-sm" value=""  multiple >
	<span  class="errorcustclass"><?php echo $errors->first('banner_image');  ?></span>
		
		<br><p><?php if(!empty($imgurldata)){ ?><img src="<?php echo $imgurldata; ?>" onclick="javascript:showIMageFancy('<?php echo $banner_image; ?>');"> <?php } ?></p>
		
		
		
										</div><!-- /.col -->
									</div><!-- /form-group -->
									
									
									
								</div>
								<div class="panel-footer ">
								
									<button class="btn btn-success" type="submit">Submit</button>
									<a class="btn btn-warning" href="<?php echo  url(ADMINSEPARATOR.'/banner'); ?>"><i class="fa fa-chevron-left"></i> Back</a>
								</div>
									<input type="hidden" name="bannerid" value="<?php echo $id; ?>" >
									<input type="hidden" name="prev_banner_image" value="<?php echo $banner_image; ?>" >
									
							<?php
							
							echo Form::close();
							
							?>
						</div><!-- /panel -->
					</div>
					</div>
			</div><!-- /.padding-md -->

<!-- Add fancyBox main JS and CSS files starts -->
<script type="text/javascript" src="{{ BASEURLPUBLICCUSTOM.'commonassets'}}/fancybox/source/jquery.fancybox.js?v=2.1.5"></script>
<link rel="stylesheet" type="text/css" href="{{ BASEURLPUBLICCUSTOM.'commonassets'}}/fancybox/source/jquery.fancybox.css?v=2.1.5" media="screen" />
<!-- Add fancyBox main JS and CSS files ends -->
			
			<script>
			
			function showIMageFancy(imagename)
			{
			
				if(imagename!='')
				{
					$.fancybox.open("<?php echo BASEURLPUBLICCUSTOM.'upload/banner-image/thumb-big';?>"+"/"+imagename);
				
					$('.fancybox-opened').css('z-index',999999);
				}
			}
			
			</script>
    
@endsection