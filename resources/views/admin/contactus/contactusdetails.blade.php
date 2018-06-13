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
					 <li><i class="fa fa-cog fa-1x fa-fw "></i><a href="javascript:void(0);"> Contact Details </a></li>
					<!-- <li class="active">Dear</li>	 -->
				</ul>
			</div>

<div class="padding-md">
<div class="row">
<div class="col-lg-11">


                <div class="row">
                
                    <div class="col-md-offset-3 col-md-7 ">
                            <div class="panel panel-default">
                    <?php 

                 $firstnameval = "";
                
                 $category_name='';
                 $contact_email ='';
                 $contact_message ='';
                 $request_response='';
                 $send_me_copy='';
                 $contact_date='';


                if(!empty($detail_contactus))
                {
                    
                          
                    
                            $contactpersonname = $detail_contactus->contactpersonname;                     
                                             
                            $category_name = $detail_contactus->category_name;   
                            $contact_email = $detail_contactus->contact_email; 
                            $contact_message = $detail_contactus->contact_message;
                           // $request_response = $detail_contactus->request_response;
                           // $send_me_copy = $detail_contactus->send_me_copy;
                            $contact_date = $detail_contactus->contact_date;
                            $replystatus = $detail_contactus->replystatus;
                            $requestresponsestatus = $detail_contactus->requestresponsestatus;
                            $sendmecopystatus = $detail_contactus->sendmecopystatus;

                            $contact_date = $detail_contactus->contact_date;

                            $contactdate = date('Y-m-d H:i:s',strtotime($contact_date));

                            $repliedon = $detail_contactus->contactbackdate;

                           // $repliedon = date('Y-m-d H:i:s',strtotime($repliedon));

                    
            	}
                    ?>
                           
                            
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Name</label>
                                        <?php
                                         echo Form::text("firstnameval", $value=$contactpersonname, $attributes = array("id"=>"firstnameval","class"=>"form-control input-sm","placeholder"=>"Name","readonly"=>true));
                                        ?>
                                    
                                    </div><!-- /form-group -->
                                     <div class="form-group">
                                        <label for="exampleInputEmail1">Email address</label>
                                        <?php
                                         echo Form::text("site_name", $value=$contact_email, $attributes = array("id"=>"contact_email","class"=>"form-control input-sm","placeholder"=>"Email address","readonly"=>true));
                                        ?>
                                 
                                    </div><!-- /form-group -->
                                  
                                   

                                    <div class="form-group">
                                        <label class="col-lg-2 control-label">Contact Message</label>
                                        <div class="col-lg-10">
                                        <?php 
                                        echo Form::textarea("address", $value=stripslashes($contact_message), $attributes = array("id"=>"address","class"=>"form-control input-sm","readonly"=>true));
                                        ?>
                                        </div><!-- /.col -->
                                    </div>


                                    <!-- Reason name -->
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Reason Name</label>
                                        <?php
                                         echo Form::text("category_name", $value=$category_name, $attributes = array("id"=>"category_name","class"=>"form-control input-sm","placeholder"=>"Reason Name","readonly"=>true));
                                        ?>
                                   

                                    </div><!-- /form-group -->


                                    <!-- Reason name -->
                                    <div class="form-group">
                                        <label for="exampleInputEmail">Request Response</label>
                                        <?php
                                         echo Form::text("requestresponse", $value=$requestresponsestatus, $attributes = array("id"=>"requestresponse","class"=>"form-control input-sm","placeholder"=>"Reply status","readonly"=>true));
                                        ?>
                                   

                                    </div><!-- /form-group -->

                                     <!-- Reason name -->
                                    <div class="form-group">
                                        <label for="exampleInputEmail">Send me a copy</label>
                                        <?php
                                         echo Form::text("sendcopy", $value=$sendmecopystatus, $attributes = array("id"=>"sendcopy","class"=>"form-control input-sm","placeholder"=>"Reply status","readonly"=>true));
                                        ?>
                                   

                                    </div><!-- /form-group -->


                                      <!-- Reason name -->
                                    <div class="form-group">
                                        <label for="exampleInputEmail">Contact on</label>
                                        <?php
                                         echo Form::text("conatct_on", $value=$contact_date, $attributes = array("id"=>"conatct_on","class"=>"form-control input-sm","placeholder"=>"Contact on","readonly"=>true));
                                        ?>
                                   

                                    </div><!-- /form-group -->

                                        <!-- Reason name -->
                                    <div class="form-group">
                                        <label for="exampleInputEmail">Replied on</label>
                                        <?php
                                         echo Form::text("conatct_on", $value=$repliedon, $attributes = array("id"=>"conatct_on","class"=>"form-control input-sm","placeholder"=>"Replied on","readonly"=>true));
                                        ?>
                                   

                                    </div><!-- /form-group -->

                                        <!-- Reason name -->
                                    <div class="form-group">
                                        <label for="exampleInputEmail">Reply status</label>
                                        <?php
                                         echo Form::text("conatct_on", $value=$replystatus, $attributes = array("id"=>"conatct_on","class"=>"form-control input-sm","placeholder"=>"Replied on","readonly"=>true));
                                        ?>
                                   

                                    </div><!-- /form-group -->

                                      <a class="btn btn-warning" href="<?php echo  url(ADMINSEPARATOR.'/contactus'); ?>"><i class="fa fa-chevron-left"></i> Back</a>
                                  
                            
                            </div>
                        </div><!-- /panel -->
                    </div>
                
				</div>                
                
                  


</div>
</div>
 
 </div>
	<script>				
		jQuery(document).ready(function(){
		
			
		});	
		
	</script>
@endsection