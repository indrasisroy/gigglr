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
       
<div id="breadcrumb">
				<ul class="breadcrumb">
					 <li><i class="fa fa-cog fa-1x fa-fw "></i><a href="javascript:void(0);"> Admin Test Mail </a></li>
					<!-- <li class="active">Dear</li>	 -->
				</ul>
			</div>

<div class="padding-md">
<div class="row">
<div class="col-lg-11">


                <div class="row">
                
                    <div class="col-md-offset-3 col-md-7 ">
                            <div class="panel panel-default">
                   
                            <div class="panel-body">
                              <?php
                    echo Form::open(array('url' => ADMINSEPARATOR.'/sendadmintestmail', 'method' => 'post','files' => true,'id'=>'settingsfrmid','class'=>'form-login'))
                    ?> 
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">*Receiver Email</label>
                                        <?php
                                         echo Form::text("receiver_email", $value='', $attributes = array("id"=>"receiver_email","class"=>"form-control input-sm","placeholder"=>"Email"));
                                        ?>
                                     <span  class="errorcustclass">   {{ $errors->first('receiver_email') }}</span>

                                    </div><!-- /form-group -->
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">*Mail Subject &nbsp;&nbsp;  (Max: 100 characters)</label>
                                       <?php
                                            echo Form::text("mail_subject", $value='', $attributes = array("id"=>"mail_subject","class"=>"form-control input-sm","placeholder"=>"Mail Subject"));
                                        ?>
                                     <span  class="errorcustclass">     {{ $errors->first('mail_subject') }} </span>
                                    </div><!-- /form-group -->
                                   
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">*Mail Text &nbsp;&nbsp;  (Max: 600 characters)</label>
                                        <?php 
                                            echo Form::textarea("mail_text", $value='', $attributes = array("id"=>"mail_text","class"=>"form-control input-sm"));
                                        ?>
                                     <span  class="errorcustclass">    {{ $errors->first('mail_text') }}</span>
                                   </div><!-- /form-group -->

                                  
                                  
									
                                  <div class="col-lg-4">
                                    <button type="submit" class="btn btn-success btn-sm">Send</button> 
                                    <button type="button" class="btn btn-success btn-sm rstclscustom">Reset</button> 
								  </div>
                                
                                  
                                
                              <?php echo Form::close();?>
                            </div>
                        </div><!-- /panel -->
                    </div>
                
				</div>                
                
                  


</div>
</div>
 
 </div>
				
				
				
				<!-- Add fancyBox main JS and CSS files starts -->
<script type="text/javascript" src="{{ BASEURLPUBLICCUSTOM}}commonassets/fancybox/source/jquery.fancybox.js?v=2.1.5"></script>
<link rel="stylesheet" type="text/css" href="{{ BASEURLPUBLICCUSTOM}}commonassets/fancybox/source/jquery.fancybox.css?v=2.1.5" media="screen" />
<!-- Add fancyBox main JS and CSS files ends -->
			
			<script>
			
			function showIMageFancy(imagename)
			{
			
				if(imagename!='')
				{
					$.fancybox.open("<?php echo BASEURLPUBLICCUSTOM.'upload/settings-image/source-file';?>"+"/"+imagename);
				
					$('.fancybox-opened').css('z-index',999999);
				}
			}
                
                $(document).ready(function(){
                    
                    $(".rstclscustom").click(function(){
                        
                        window.location.href="<?php echo url(ADMINSEPARATOR."/admintestmail"); ?>";
                        
                    });
                    
                });
                
			
			</script>
    
@endsection