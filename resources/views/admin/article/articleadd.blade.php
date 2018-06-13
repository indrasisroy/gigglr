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
	$article_title='';$article_description='';$articleid=0;
	if(!empty($article))
	{
		$article_title=stripslashes($article->title);
		$article_description=stripslashes($article->description);
		$articleid=$article->id;
	}
	?>
			<div class="padding-md">
				<div class="row">
					<div class="col-md-8 col-md-offset-2">
						<div class="panel panel-default">
							
								
								<?php echo Form::open(array('url' => ADMINSEPARATOR.'/articlesave', 'method' => 'post','id'=>'articleaddfrmid','class'=>"form-horizontal form-border no-margin" )); ?>
								<div class="panel-heading">
								 Save Article
								</div>
								<div class="panel-body">
								
								
									<div class="form-group">
										<label class="control-label col-lg-2">Article Title</label>
										<input type="hidden" name="hidden_title" value="<?php echo $article_title;?>">
										<input type="hidden" name="id" value="<?php echo $articleid;?>">
										<div class="col-lg-10">
											
											<?php    
    echo Form::text("title", $value=$article_title, $attributes = array( "id"=>"title","class"=>" form-control input-sm parsley-validated ")); ?>
										<span  class="errorcustclass">{{ $errors->first('title') }}</span>		
										</div><!-- /.col -->
									</div><!-- /form-group -->
									<div class="form-group">
										<label class="control-label col-lg-2">Article Description</label>
										<div class="col-lg-10">
						<script type="text/javascript" src="{{ BASEURLPUBLICCUSTOM.'commonassets'}}/ckeditor/ckeditor.js"></script>
<?php    
    echo Form::textarea("description", $value=$article_description, $attributes = array( "id"=>"article_description","class"=>" form-control input-sm parsley-validated ")); ?>
							<script>
							CKEDITOR.replace( 'article_description',
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
									<a class="btn btn-warning" href="<?php echo  url(ADMINSEPARATOR.'/article'); ?>"><i class="fa fa-chevron-left"></i> Back</a>
								</div
									
							<?php
							
							echo Form::close();
							
							?>
						</div><!-- /panel -->
					</div>
					</div>
			</div><!-- /.padding-md -->

    
@endsection