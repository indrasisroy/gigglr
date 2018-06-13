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

	$id=0; $page_name=''; $homesearch_title=''; $homesearch_location=''; $homesearch_description=''; $homesearch_skillid=''; $homesearch_image=''; $homesearch_imagetitle=''; $status=''; $imgurldata=''; $homesearch_genreid='';
	$home_skillid_data=array(); $home_genreid_data=array();
	
	if(!empty($homeskillidarr))
	{
		$home_skillid_data=$homeskillidarr;
	}

    if(!empty($home_genreidarr))
    {
        $home_genreid_data=$home_genreidarr;
    }
    
	
	if(!empty($homesearchrow))
	{
		$id=$homesearchrow->id;
		$homesearch_title=stripslashes($homesearchrow->title);
		$homesearch_location=stripslashes($homesearchrow->location);
		$homesearch_description=stripslashes($homesearchrow->description);
		$homesearch_skillid=stripslashes($homesearchrow->skill_id);
        $homesearch_genreid=stripslashes($homesearchrow->skill_sub_id);
		$homesearch_image=stripslashes($homesearchrow->image_name);
		$imgurldata = BASEURLPUBLICCUSTOM.'upload/homesearch-image/thumb-medium/'.$homesearchrow->image_name;
		$homesearch_imagetitle=stripslashes($homesearchrow->image_title);
		$status=stripslashes($homesearchrow->status);
	}
	
?>

<div class="padding-md">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
			
				<?php echo Form::open(array('url' => ADMINSEPARATOR.'/homesearchsave','files' => true, 'method' => 'post','id'=>'homesearchaddfrmid','class'=>"form-horizontal form-border no-margin" )); ?>
				
					<div class="panel-heading">
						<!--Save Home-search-->
						Save Banner-Dynamic
					</div>
						
					<div class="panel-body">
					
						<div class="form-group">
							<label class="control-label col-lg-4">* Headline</label>
							<div class="col-lg-6">
								<?php echo Form::text("homesearch_title", $value=$homesearch_title, $attributes = array( "id"=>"homesearch_title","class"=>" form-control input-sm parsley-validated ")); ?>
								<span  class="errorcustclass">{{ $errors->first('homesearch_title') }}</span>
							</div><!-- /.col -->
						</div><!-- /form-group -->
							
						<!--<div class="form-group">
							<label class="control-label col-lg-4"> Location</label>
							<div class="col-lg-6">
								<?php echo Form::text("homesearch_location", $value=$homesearch_location, $attributes = array( "id"=>"homesearch_location","class"=>" form-control input-sm parsley-validated ")); ?>
								<span  class="errorcustclass">{{ $errors->first('homesearch_location') }}</span>		
							</div>
						</div>-->
									
						<div class="form-group">
                            <label class="col-lg-4 control-label">* Description</label>
                            <div class="col-lg-6">
                                <?php echo Form::textarea("homesearch_description", $value=$homesearch_description, $attributes = array("id"=>"homesearch_description","class"=>"form-control input-sm ")); ?>
                                <span  class="errorcustclass">{{ $errors->first('homesearch_description') }}</span>
                            </div><!-- /.col -->
                        </div>
							
						<div class="form-group" id="pData">
							<label class="control-label col-lg-4">* Category</label>
							<div class="col-lg-6">
								<?php
									$skillparentproper=array();
									$homeskillproper['id']="homesearch_skillid";
									$homeskillproper['class']="form-control input-sm";
									echo Form::select('homesearch_skillid', $home_skillid_data , $homesearch_skillid, $attributes = $homeskillproper);
								?>
								<span  class="errorcustclass">{{ $errors->first('homesearch_skillid') }}</span>
							</div><!-- /.col -->
						</div><!-- /form-group -->
                        
                        <div class="form-group" id="pData">
							<label class="control-label col-lg-4"> Genre</label>
							<div class="col-lg-6">
								<?php
									$skillparentproper=array();
                                    $homesubskillproper=array();
									$homesubskillproper['id']="skill_sub_id";
									$homesubskillproper['class']="form-control input-sm";
									echo Form::select('skill_sub_id', $home_genreid_data , $homesearch_genreid, $attributes = $homesubskillproper);
								?>
								<span  class="errorcustclass">{{ $errors->first('skill_sub_id') }}</span>
							</div><!-- /.col -->
						</div><!-- /form-group -->
									
						<div class="form-group">
							<label class="control-label col-lg-4">* Image
								<br>Width : 570px
								<br>Height : 634px
								<br>Allowed File Extention : .jpg
							</label>
							<br>
							<div class="col-lg-6">
								<input type="file" name="homesearch_image[]" class="form-control input-sm" value=""  multiple >
								<span class="errorcustclass"><?php echo $errors->first('homesearch_image'); ?></span>
								<br>
								<p><?php if(!empty($imgurldata)){ ?><img src="<?php echo $imgurldata; ?>" onclick="javascript:showIMageFancy('<?php echo $homesearch_image; ?>');"> <?php } ?></p>
							</div><!-- /.col -->
						</div><!-- /form-group -->
						
						<div class="form-group">
							<label class="control-label col-lg-4">* Image Title</label>
							<div class="col-lg-6">
								<?php echo Form::text("homesearch_imagetitle", $value=$homesearch_imagetitle, $attributes = array( "id"=>"homesearch_imagetitle","class"=>" form-control input-sm parsley-validated ")); ?>
								<span  class="errorcustclass">{{ $errors->first('homesearch_imagetitle') }}</span>
							</div><!-- /.col -->
						</div><!-- /form-group -->
									
					</div>
								
					<div class="panel-footer ">
						<button class="btn btn-success" type="submit">Submit</button>
						<a class="btn btn-warning" href="<?php echo  url(ADMINSEPARATOR.'/homesearch'); ?>"><i class="fa fa-chevron-left"></i> Back</a>
					</div>
					
					<input type="hidden" name="homesearchid" value="<?php echo $id; ?>" >
					<input type="hidden" name="prev_homesearch_image" value="<?php echo $homesearch_image; ?>" >
									
				<?php echo Form::close(); ?>
					
			</div><!-- /panel -->
		</div>
	</div>
</div><!-- /.padding-md -->

<!-- Add fancyBox main JS and CSS files starts -->

<script type="text/javascript" src="{{BASEURLPUBLICCUSTOM.'commonassets'}}/fancybox/source/jquery.fancybox.js?v=2.1.5"></script>
<link rel="stylesheet" type="text/css" href="{{ BASEURLPUBLICCUSTOM.'commonassets'}}/fancybox/source/jquery.fancybox.css?v=2.1.5" media="screen" />

<!-- Add fancyBox main JS and CSS files ends -->
			
<script>

    var homesearch_genreid_data="<?php echo $homesearch_genreid; ?>";
    var genreiderr="<?php echo $errors->first('skill_sub_id') ?>";
    
	function showIMageFancy(imagename)
	{
		if(imagename!='')
		{
			$.fancybox.open("<?php echo BASEURLPUBLICCUSTOM.'upload/homesearch-image/source-file';?>"+"/"+imagename);
		
			$('.fancybox-opened').css('z-index',999999);
		}
	}
    
    
    
    
    function populategenre(categoryid)
    {
       var  callurl = admin_base_url_data + '/populategenre';
       var snddata = {
           _token: admin_csrf_token_data,
           skill_id: categoryid
       }
       
       jQuery.ajax({
           url: callurl,
           data: snddata,
           type: "POST",
           dataType: 'JSON',
           success: function(d) {
               subskill_opt_html = '';

               if (d != null) {
                   subskill_opt_html += "<option value=''>Select Genre</option>";
                   $.each(d, function(idx, obj) {
                       subskill_opt_html += "<option value='" + obj.subskill_id + "'>" + obj.subskill_name + "</option>";
                   });
               }

               $("#skill_sub_id").html(subskill_opt_html);
               
               if(homesearch_genreid_data!='' )
                   {
                       if(genreiderr!='' || (parseInt(homesearch_genreid_data)==0))
                           {
                               jQuery('#skill_sub_id').val('');
                           }
                       else
                           {
                               jQuery('#skill_sub_id').val(homesearch_genreid_data);
                           }
                       
                   }
               else
                   {
                       jQuery('#skill_sub_id').val('');
                   }
               
               //$("#subskill_id").selectpicker('refresh');
           }
       });
        
    }
    
    $(document).ready(function(){
        
        
        
        
       
      
        
            jQuery('#homesearch_skillid').on('change', function(evnt) {

            var skill_id = this.value;

            populategenre(skill_id);


            });
        
            var homesearch_skillid_data=jQuery('#homesearch_skillid').val();
        
            if(homesearch_skillid_data!='')
                {
                    populategenre(homesearch_skillid_data);
                }
        
        
        
    });
    
	
</script>
    
@endsection