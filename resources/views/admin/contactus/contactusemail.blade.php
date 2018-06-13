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
    $article_title='';$article_description='';$articleid=0;$receivername='';$emaildescription='';$$receivername='';

    // echo "<pre>";
    // print_r($detail_contactus);die;
    $senderemail='';
    if(!empty($detail_contactus))
    {
        $senderemail=stripslashes($detail_contactus->contact_email);
         $senderid=stripslashes($detail_contactus->id);
         $receivername = stripslashes($detail_contactus->contact_first_name).' '.stripslashes($detail_contactus->contact_last_name);
      
    }
    ?>
            <div class="padding-md">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <div class="panel panel-default">
                            
                                
                                <?php echo Form::open(array('url' => ADMINSEPARATOR.'/sendemailcontactform', 'method' => 'post','id'=>'contactusemailform','class'=>"form-horizontal form-border no-margin" )); ?>
                                <div class="panel-heading">
                                Write Email
                                </div>
                                <div class="panel-body">
                                
                                
                                    <div class="form-group">
                                        <label class="control-label col-lg-2">Send to</label>
                                        <input type="hidden" name="emailto" value="<?php echo $senderemail;?>">
                                        <input type="hidden" name="id" value="<?php echo $senderid;?>">
                                        <input type="hidden" name="receivename" value="<?php echo $receivername;?>">
                                        <div class="col-lg-10">
                                            
                                            <?php    
    echo Form::text("receiveremail", $value=$senderemail, $attributes = array( "id"=>"receiveremail","class"=>" form-control input-sm parsley-validated ","readonly"=>true)); ?>
                                        <span  class="errorcustclass">{{ $errors->first('receiveremail') }}</span>      
                                        </div><!-- /.col -->
                                    </div><!-- /form-group -->
                                    <div class="form-group">
                                        <label class="control-label col-lg-2">Email Content</label>
                                        <div class="col-lg-10">
                       
<?php    
    echo Form::textarea("emaildescription", $value=$emaildescription, $attributes = array( "id"=>"emaildescription","class"=>" form-control input-sm parsley-validated ")); ?>
                                   
                    <span  class="errorcustclass">{{ $errors->first('emaildescription') }}</span>    
                

                                        </div><!-- /.col -->
                                    </div><!-- /form-group -->
                                    
                                
                                </div>
                                <div class="panel-footer ">
                                
                                    <button class="btn btn-success" type="submit">Submit</button>
                                    <a class="btn btn-warning" href="<?php echo  url(ADMINSEPARATOR.'/contactus'); ?>"><i class="fa fa-chevron-left"></i> Back</a>
                                </div
                                    
                            <?php
                            
                            echo Form::close();
                            
                            ?>
                        </div><!-- /panel -->
                    </div>
                    </div>
            </div><!-- /.padding-md -->

 <!-- <script type="text/javascript" src="{{ BASEURLPUBLICCUSTOM.'commonassets'}}/ckeditor/ckeditor.js"></script> -->
  <script>
// CKEDITOR.replace( 'article_description',
// {
// filebrowserBrowseUrl :'{{ BASEURLPUBLICCUSTOM.'commonassets'}}/ckeditor/filemanager/browser/default/browser.html?Connector={{ BASEURLPUBLICCUSTOM.'commonassets'}}/ckeditor/filemanager/connectors/php/connector.php',
// filebrowserImageBrowseUrl : '{{ BASEURLPUBLICCUSTOM.'commonassets'}}/ckeditor/filemanager/browser/default/browser.html?Type=Image&Connector={{ BASEURLPUBLICCUSTOM.'commonassets'}}/ckeditor/filemanager/connectors/php/connector.php',
// filebrowserFlashBrowseUrl :'{{ BASEURLPUBLICCUSTOM.'commonassets'}}/ckeditor/filemanager/browser/default/browser.html?Type=Flash&Connector={{ BASEURLPUBLICCUSTOM.'commonassets'}}/ckeditor/filemanager/connectors/php/connector.php',
// filebrowserUploadUrl  :'{{ BASEURLPUBLICCUSTOM.'commonassets'}}/ckeditor/filemanager/connectors/php/upload.php?Type=File',
// filebrowserImageUploadUrl : '{{ BASEURLPUBLICCUSTOM.'commonassets'}}/ckeditor/filemanager/connectors/php/upload.php?Type=Image',
// filebrowserFlashUploadUrl : '{{ BASEURLPUBLICCUSTOM.'commonassets'}}/ckeditor/filemanager/connectors/php/upload.php?Type=Flash'
// });
</script>   
    
@endsection