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
	$emailtemplate_subject='';$emailtemplate_description='';$emailtemplateid=0;
	if(!empty($email_details))
	{
		$emailtemplate_subject=stripslashes($email_details->subject);
		$emailtemplate_description=stripslashes($email_details->message);
		$emailtemplateid=$email_details->id;
	}
	?>
			<div class="padding-md">
				<div class="row">
					<div class="col-md-8 col-md-offset-2">
						<div class="panel panel-default">
							
								
								<?php echo Form::open(array('url' => ADMINSEPARATOR.'/emailtemplatesave', 'method' => 'post','id'=>'emailtemplateaddfrmid','class'=>"form-horizontal form-border no-margin" )); ?>
								<div class="panel-heading">
								 Save Email Template
								</div>
								<div class="panel-body">
								
								
									<div class="form-group">
										<label class="control-label col-lg-2">Email Template Subject</label>
										<input type="hidden" name="hidden_title" value="<?php echo $emailtemplate_subject;?>">
										<input type="hidden" name="id" value="<?php echo $emailtemplateid;?>">
										<div class="col-lg-10">
											
											<?php    
    echo Form::text("subject", $value=$emailtemplate_subject, $attributes = array( "id"=>"subject","class"=>" form-control input-sm parsley-validated ")); ?>
										<span  class="errorcustclass">{{ $errors->first('subject') }}</span>		
										</div><!-- /.col -->
									</div><!-- /form-group -->
									<div class="form-group">
										<label class="control-label col-lg-2">Email Template Description</label>
										<div class="col-lg-10">
						<script type="text/javascript" src="{{ URL::asset('commonassets')}}/ckeditor/ckeditor.js"></script>
<?php    
    echo Form::textarea("description", $value=$emailtemplate_description, $attributes = array( "id"=>"description","class"=>" form-control input-sm parsley-validated ")); ?>
							<script>
							CKEDITOR.replace( 'description',
                {
                    filebrowserBrowseUrl :'{{ URL::asset('commonassets')}}/ckeditor/filemanager/browser/default/browser.html?Connector={{ URL::asset('commonassets')}}/ckeditor/filemanager/connectors/php/connector.php',
                    filebrowserImageBrowseUrl : '{{ URL::asset('commonassets')}}/ckeditor/filemanager/browser/default/browser.html?Type=Image&Connector={{ URL::asset('commonassets')}}/ckeditor/filemanager/connectors/php/connector.php',
                    filebrowserFlashBrowseUrl :'{{ URL::asset('commonassets')}}/ckeditor/filemanager/browser/default/browser.html?Type=Flash&Connector={{ URL::asset('commonassets')}}/ckeditor/filemanager/connectors/php/connector.php',
					filebrowserUploadUrl  :'{{ URL::asset('commonassets')}}/ckeditor/filemanager/connectors/php/upload.php?Type=File',
					filebrowserImageUploadUrl : '{{ URL::asset('commonassets')}}/ckeditor/filemanager/connectors/php/upload.php?Type=Image',
					filebrowserFlashUploadUrl : '{{ URL::asset('commonassets')}}/ckeditor/filemanager/connectors/php/upload.php?Type=Flash'
				});
								  
								</script>			
					<span  class="errorcustclass">{{ $errors->first('description') }}</span>	
				

										</div><!-- /.col -->
									</div><!-- /form-group -->
									
								
								</div>
								<div class="panel-footer ">
								
									<button class="btn btn-success" type="submit">Submit</button>
									<a class="btn btn-warning" href="<?php echo  url(ADMINSEPARATOR.'/email-template'); ?>"><i class="fa fa-chevron-left"></i> Back</a>
								</div
									
							<?php
							
							echo Form::close();
							
							?>
						</div><!-- /panel -->
					</div>
					</div>
			</div><!-- /.padding-md -->

    
@endsection