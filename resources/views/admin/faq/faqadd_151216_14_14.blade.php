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
	$title='';$description='';$id=0;
	if(!empty($faqrow))
	{
		$title=stripslashes($faqrow->title);
		$description=stripslashes($faqrow->description);
		$id=$faqrow->id; 
	}
	?>
	<div class="padding-md">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<div class="panel panel-default">
					<?php echo Form::open(array('url' => ADMINSEPARATOR.'/faqsave', 'method' => 'post','id'=>'languageaddfrmid','class'=>"form-horizontal form-border no-margin" )); ?>
					<div class="panel-heading">
						Save FAQ
					</div>
					<div class="panel-body">
						<div class="form-group">
							<label class="control-label col-lg-2">Question<br>(Maximum 100 charecters)</label>
							<div class="col-lg-10">
								<?php echo Form::text("title", $value=$title, $attributes = array( "id"=>"title","class"=>" form-control input-sm parsley-validated ")); ?>
								<span  class="errorcustclass">{{ $errors->first('title') }}</span>
							</div><!-- /.col -->
						</div><!-- /form-group -->
						<div class="form-group">
										<label class="control-label col-lg-2">Answer <br>(Maximum 500 charecters)</label>
							<div class="col-lg-10">
						<script type="text/javascript" src="{{ BASEURLPUBLICCUSTOM.'commonassets'}}/ckeditor/ckeditor.js"></script>
						<?php    
						 echo Form::textarea("description", $value=$description, $attributes = array( "id"=>"description","class"=>" form-control input-sm parsley-validated "));
						 ?>
							<script>
							CKEDITOR.replace( 'description',
							{
								filebrowserBrowseUrl :'{{ BASEURLPUBLICCUSTOM.'commonassets'}}/ckeditor/filemanager/browser/default/browser.html?Connector={{ BASEURLPUBLICCUSTOM.'commonassets'}}/ckeditor/filemanager/connectors/php/connector.php',
								filebrowserImageBrowseUrl : '{{ BASEURLPUBLICCUSTOM.'commonassets'}}/ckeditor/filemanager/browser/default/browser.html?Type=Image&Connector={{ BASEURLPUBLICCUSTOM.'commonassets'}}/ckeditor/filemanager/connectors/php/connector.php',
								filebrowserFlashBrowseUrl :'{{ BASEURLPUBLICCUSTOM.'commonassets'}}/ckeditor/filemanager/browser/default/browser.html?Type=Flash&Connector={{ BASEURLPUBLICCUSTOM.'commonassets'}}/ckeditor/filemanager/connectors/php/connector.php',
								filebrowserUploadUrl  :'{{ BASEURLPUBLICCUSTOM.'commonassets'}}/ckeditor/filemanager/connectors/php/upload.php?Type=File',
								filebrowserImageUploadUrl : '{{ BASEURLPUBLICCUSTOM.'commonassets'}}/ckeditor/filemanager/connectors/php/upload.php?Type=Image',
								filebrowserFlashUploadUrl : '{{ BASEURLPUBLICCUSTOM.'commonassets'}}/ckeditor/filemanager/connectors/php/upload.php?Type=Flash'
							});
											  
							</script>			
							<span  class="errorcustclass">{{ $errors->first('description') }}</span>	
				

										</div><!-- /.col -->
							</div><!-- /form-group -->
					</div>
					<div class="panel-footer ">
						<button class="btn btn-success" type="submit">Submit</button>
						<a class="btn btn-warning" href="<?php echo  url(ADMINSEPARATOR.'/faq'); ?>"><i class="fa fa-chevron-left"></i> Back</a>
					</div>
					<input type="hidden" name="faqid" value="<?php echo $id; ?>" >
					<?php
					echo Form::close();
					?>
				</div><!-- /panel -->
			</div>
		</div>
	</div><!-- /.padding-md -->
			
@endsection