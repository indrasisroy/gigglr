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
	$bkr_hospitality='';$bkr_environment='';$bkr_readiness='';$bkr_review_data='';$punctuality='';$performance='';$presentation='';$agv_review_data='';$reviewid=0;
	if(!empty($review))
	{
		$bkr_hospitality=stripslashes($review->bkr_hospitality);
		$bkr_environment=stripslashes($review->bkr_environment);
        $bkr_readiness=stripslashes($review->bkr_readiness);
        $bkr_review_data=stripslashes($review->bkr_review_data);
        
        $punctuality=stripslashes($review->punctuality);
        $performance=stripslashes($review->performance);
        $presentation=stripslashes($review->presentation);
        $agv_review_data=stripslashes($review->agv_review_data);
		$reviewid=$review->id;
	}
	?>
			<div class="padding-md">
				<div class="row">
					<div class="col-md-8 col-md-offset-2">
						<div class="panel panel-default">
							
								
								<?php echo Form::open(array('url' => ADMINSEPARATOR.'/reviewsave', 'method' => 'post','id'=>'reviewaddfrmid','class'=>"form-horizontal form-border no-margin" )); ?>
								<div class="panel-heading">
								 Save Review
								</div>
								<div class="panel-body">
								   <div class="form-group" id="pData">
                                          <label class="control-label col-lg-4">Booker Hospitality</label>
                                       <input type="hidden" name="id" value="<?php echo $reviewid;?>">
                                            <div class="col-lg-6">
                                                <?php
                                                   $hospitality_data = array(''=>'Select','1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5');
                                                   $attrbar = array();
                                                   $attrbar['id'] = "hospitality";
                                                   $attrbar['class'] = "form-control input-sm parsley-validated";
                                                   echo Form::select('hospitality',$hospitality_data,$bkr_hospitality,$attrbar );
                                              ?><span  class="errorcustclass">{{ $errors->first('hospitality') }}</span>
                                           </div><!-- /.col -->
						            </div><!-- /form-group -->
                                    <div class="form-group" id="pData">
                                          <label class="control-label col-lg-4">Booker Environment</label>
                                            <div class="col-lg-6">
                                                <?php
                                                   $environment_data = array(''=>'Select','1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5');
                                                   $attrbar = array();
                                                   $attrbar['id'] = "environment";
                                                   $attrbar['class'] = "form-control input-sm parsley-validated";
                                                   echo Form::select('environment',$environment_data,$bkr_environment,$attrbar );
                                              ?><span  class="errorcustclass">{{ $errors->first('environment') }}</span>
                                           </div><!-- /.col -->
						            </div><!-- /form-group -->
                                     <div class="form-group" id="pData">
                                          <label class="control-label col-lg-4">Booker Readiness</label>
                                            <div class="col-lg-6">
                                                <?php
                                                   $readiness_data = array(''=>'Select','1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5');
                                                   $attrbar = array();
                                                   $attrbar['id'] = "readiness";
                                                   $attrbar['class'] = "form-control input-sm parsley-validated";
                                                   echo Form::select('readiness',$readiness_data,$bkr_readiness,$attrbar );
                                              ?><span  class="errorcustclass">{{ $errors->first('readiness') }}</span>
                                           </div><!-- /.col -->
						            </div><!-- /form-group -->
									<div class="form-group">
										<label class="control-label col-lg-2">Booker Review</label>
										<div class="col-lg-10">
						<script type="text/javascript" src="{{ BASEURLPUBLICCUSTOM.'commonassets'}}/ckeditor/ckeditor.js"></script>
<?php    
    echo Form::textarea("bkr_review_data", $value=$bkr_review_data, $attributes = array( "id"=>"bkr_review_data","class"=>" form-control input-sm parsley-validated ")); ?>
							<script>
							CKEDITOR.replace( 'bkr_review_data',
                {
                    filebrowserBrowseUrl :'{{ BASEURLPUBLICCUSTOM.'commonassets'}}/ckeditor/filemanager/browser/default/browser.html?Connector={{ BASEURLPUBLICCUSTOM.'commonassets'}}/ckeditor/filemanager/connectors/php/connector.php',
                    filebrowserImageBrowseUrl : '{{ BASEURLPUBLICCUSTOM.'commonassets'}}/ckeditor/filemanager/browser/default/browser.html?Type=Image&Connector={{ BASEURLPUBLICCUSTOM.'commonassets'}}/ckeditor/filemanager/connectors/php/connector.php',
                    filebrowserFlashBrowseUrl :'{{ BASEURLPUBLICCUSTOM.'commonassets'}}/ckeditor/filemanager/browser/default/browser.html?Type=Flash&Connector={{ BASEURLPUBLICCUSTOM.'commonassets'}}/ckeditor/filemanager/connectors/php/connector.php',
					filebrowserUploadUrl  :'{{ BASEURLPUBLICCUSTOM.'commonassets'}}/ckeditor/filemanager/connectors/php/upload.php?Type=File',
					filebrowserImageUploadUrl : '{{ BASEURLPUBLICCUSTOM.'commonassets'}}/ckeditor/filemanager/connectors/php/upload.php?Type=Image',
					filebrowserFlashUploadUrl : '{{ BASEURLPUBLICCUSTOM.'commonassets'}}/ckeditor/filemanager/connectors/php/upload.php?Type=Flash'
				});
								  
								</script>			
					<span  class="errorcustclass">{{ $errors->first('bkr_review_data') }}</span>	
				

										</div><!-- /.col -->
									</div><!-- /form-group -->
                                    
                                     <div class="form-group" id="pData">
                                          <label class="control-label col-lg-4">Punctuality</label>
                                            <div class="col-lg-6">
                                                <?php
                                                   $punctualityy_data = array(''=>'Select','1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5');
                                                   $attrbar = array();
                                                   $attrbar['id'] = "punctualityy";
                                                   $attrbar['class'] = "form-control input-sm parsley-validated";
                                                   echo Form::select('punctualityy',$punctualityy_data,$punctuality,$attrbar );
                                              ?><span  class="errorcustclass">{{ $errors->first('punctualityy') }}</span>
                                           </div><!-- /.col -->
						            </div><!-- /form-group -->
                                    
                                    <div class="form-group" id="pData">
                                          <label class="control-label col-lg-4">Performance</label>
                                            <div class="col-lg-6">
                                                <?php
                                               
                                                   $performance_data = array(''=>'Select','1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5');
                                                   $attrbar = array();
                                                   $attrbar['id'] = "performance";
                                                   $attrbar['class'] = "form-control input-sm parsley-validated";
                                                   echo Form::select('performance',$performance_data,$performance,$attrbar );
                                              ?><span  class="errorcustclass">{{ $errors->first('performance') }}</span>
                                           </div><!-- /.col -->
						            </div><!-- /form-group -->
                                     <div class="form-group" id="pData">
                                          <label class="control-label col-lg-4">Presentation</label>
                                            <div class="col-lg-6">
                                                <?php
                                               
                                                   $presentation_data = array(''=>'Select','1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5');
                                                   $attrbar = array();
                                                   $attrbar['id'] = "presentation";
                                                   $attrbar['class'] = "form-control input-sm parsley-validated";
                                                   echo Form::select('presentation',$presentation_data,$presentation,$attrbar );
                                              ?><span  class="errorcustclass">{{ $errors->first('presentation') }}</span>
                                           </div><!-- /.col -->
						            </div><!-- /form-group -->
                                    	<div class="form-group">
										<label class="control-label col-lg-2">Booker Review</label>
										<div class="col-lg-10">
						<script type="text/javascript" src="{{ BASEURLPUBLICCUSTOM.'commonassets'}}/ckeditor/ckeditor.js"></script>
<?php    
    echo Form::textarea("agv_review_data", $value=$agv_review_data, $attributes = array( "id"=>"agv_review_data","class"=>" form-control input-sm parsley-validated ")); ?>
							<script>
							CKEDITOR.replace( 'agv_review_data',
                {
                    filebrowserBrowseUrl :'{{ BASEURLPUBLICCUSTOM.'commonassets'}}/ckeditor/filemanager/browser/default/browser.html?Connector={{ BASEURLPUBLICCUSTOM.'commonassets'}}/ckeditor/filemanager/connectors/php/connector.php',
                    filebrowserImageBrowseUrl : '{{ BASEURLPUBLICCUSTOM.'commonassets'}}/ckeditor/filemanager/browser/default/browser.html?Type=Image&Connector={{ BASEURLPUBLICCUSTOM.'commonassets'}}/ckeditor/filemanager/connectors/php/connector.php',
                    filebrowserFlashBrowseUrl :'{{ BASEURLPUBLICCUSTOM.'commonassets'}}/ckeditor/filemanager/browser/default/browser.html?Type=Flash&Connector={{ BASEURLPUBLICCUSTOM.'commonassets'}}/ckeditor/filemanager/connectors/php/connector.php',
					filebrowserUploadUrl  :'{{ BASEURLPUBLICCUSTOM.'commonassets'}}/ckeditor/filemanager/connectors/php/upload.php?Type=File',
					filebrowserImageUploadUrl : '{{ BASEURLPUBLICCUSTOM.'commonassets'}}/ckeditor/filemanager/connectors/php/upload.php?Type=Image',
					filebrowserFlashUploadUrl : '{{ BASEURLPUBLICCUSTOM.'commonassets'}}/ckeditor/filemanager/connectors/php/upload.php?Type=Flash'
				});
								  
								</script>			
					<span  class="errorcustclass">{{ $errors->first('agv_review_data') }}</span>	
				

										</div><!-- /.col -->
									</div><!-- /form-group -->
									
								
								</div>
								<div class="panel-footer ">
								
									<button class="btn btn-success" type="submit">Submit</button>
									<a class="btn btn-warning" onclick="history.go(-1);"><i class="fa fa-chevron-left"></i> Back</a>
								</div
									
							<?php
							
							echo Form::close();
							
							?>
						</div><!-- /panel -->
					</div>
					</div>
			</div><!-- /.padding-md -->

    
@endsection