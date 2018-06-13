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
			<div class="padding-md">
				<div class="row">
				
				<div class="alert" id="messege_id" style="display: none;">
					<a href="javascript:void(0);" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
				</div>
					
					<div class="col-md-12">
						
			<div class="panel panel-default table-responsive">
					<div class="panel-heading">
						Dispute Reason List
						<span class="pull-right"><a type="button" class="btn btn-xs btn-success" href="{{url(ADMINSEPARATOR.'/disputereasonadd')}}">Add</a></span>
					</div>
					<div class="panel-body">
                     <!--Search funtionality div-->
                    
                        <div class="row">
							<div class="col-md-4 col-sm-4">
                                <?php
                                $rqst_segmn1=Request::segment(3);
                                ?>
							<?php echo Form::open(array('url' => ADMINSEPARATOR.'/disputereason/'.$rqst_segmn1.'', 'method' => 'get','id'=>'disputereasonsearch','class'=>"form-horizontal form-border no-margin")); ?>
							<div class="input-group">
							<?php
								$srch1=''; $sort1=''; $sorttype1='ASC';
								$default_srt_class1="fa fa-sort fa-sm";
								if( !empty($useinPagiAr) && array_key_exists('srch1',$useinPagiAr))
								{
									$srch1=$useinPagiAr['srch1'];
								}
								if( !empty($useinPagiAr) && array_key_exists('sorttype1',$useinPagiAr))
								{
									$sorttype1=$useinPagiAr['sorttype1']; // original sort type  ASC or DESC
									
									if(!empty($sorttype1) && ($sorttype1=="ASC") )
									{
										$default_srt_class1="fa fa-sort-desc fa-sm";
									}
									elseif(!empty($sorttype1) && ($sorttype1=="DESC") )
									{
										$default_srt_class1="fa fa-sort-asc fa-sm";	
									}
								}
								if( !empty($useinPagiAr) && array_key_exists('sort1',$useinPagiAr))
								{
									$sort1=$useinPagiAr['sort1'];											
								}
								?>
							   
								<input type="hidden" name="srch1" id="reviewid" value="<?php echo $rqst_segmn1;?>">
                                 <label >Filter By</label>
                                 <?php
                                        $srch12 = array(''=>'Select Filter Type','1'=>'As a booker','2'=>'As a artist','3'=>'As a Group','4'=>' As a Venue');
                                        $attrbar = array();
                                        $attrbar['id'] = "srch1";
                                        $attrbar['class'] = "form-control input-sm parsley-validated";
                                        echo Form::select('srch1',$srch12,"$srch1",$attrbar );
                                ?>
                                
								<?php echo Form::hidden("sort1", $value=$sort1, $attributes = array( "id"=>"sort1","class"=>" form-control input-sm ")); ?>
								<?php echo Form::hidden("sorttype1", $value=$sorttype1, $attributes = array( "id"=>"sorttype1","class"=>" form-control input-sm ")); ?>
								
									<div class="input-group-btn arunmoy">
										<button tabindex="-1" class="btn btn-sm btn-success" type="button" id="srchbutondisputeReason" style="margin-top: 22px; margin-right:10px; ">Search</button>
									    <button tabindex="-1"  style="margin-top: 22px;" type="button" class="btn btn-sm btn-info" id="clearsearch">Clear Search</button>
									</div> <!-- /input-group-btn -->
                                   
							    </div>
									<?php echo Form::close(); ?>
							</div><!-- /.col -->
                            
						</div><!-- /.row -->
                        
                        
                        
					</div>
					<table class="table table-striped" id="responsiveTable">
						<thead>
							<tr>
								
								<th>Complaint By</th>
                                <th>Type</th>
                                <th>Complaint Against</th>
                                <th>Type</th>
								<th>Question</th>
                                <th>Date</th>
                                <th>Action</th>
							</tr>
						</thead>
						<tbody>
						@if(count($DisputeReason)>0)
                        @foreach ($DisputeReason as $reasons)
						
							<tr>
								<td>
                                   <?php
                                    if($reasons->complaint_by == '1'){
                                        $Complaint_by = 'Booker';
                                    }elseif($reasons->complaint_by == '2'){
                                        $Complaint_by = 'Booked artist / Group / Venue';
                                    }
                                    ?>
                                    {{$Complaint_by}}
								</td>
                                <td>
                                    <?php
                                    if($reasons->complaint_by_type == '1'){
                                        $Complaint_type = 'Artist';
                                    }elseif($reasons->complaint_by_type == '2'){
                                        $Complaint_type = 'Group';
                                    }elseif($reasons->complaint_by_type == '3'){
                                        $Complaint_type = 'Venue';
                                    }
                                    ?>
                                    {{$Complaint_type}}
                                </td>
                                <td>
                                    <?php
                                    $Complaint_against="-";
                                    if($reasons->complaint_against == '1'){
                                        $Complaint_against = 'Booker';
                                    }elseif($reasons->complaint_against == '2'){
                                        $Complaint_against = 'Booked artist / Group / Venue';
                                    }
                                    ?>
                                    {{$Complaint_against}}
                                </td>
                                <td>
                                    <?php
                                    if($reasons->complaint_against_type == '1'){
                                        $Complaint_against_type = 'Artist';
                                    }elseif($reasons->complaint_against_type == '2'){
                                        $Complaint_against_type = 'Group';
                                    }elseif($reasons->complaint_against_type == '3'){
                                        $Complaint_against_type = 'Venue';
                                    }
                                    ?>
                                    {{$Complaint_against_type}}
                                </td>
                                <td>
                                    <!-- {{ucwords($reasons->question)}} -->
                                    <?php echo stripslashes(ucwords($reasons->question))?>
                                </td>
                                <td>
                                    {{ date('l d F Y',strtotime($reasons->modified_date))}}
                                </td>
								<td>
									@if($reasons->status == '1')
									<?php $StatusHtml = '<i class="fa fa-unlock fa-lg"></i>';?>
									@else
									<?php $StatusHtml = '<i class="fa fa-lock fa-lg"></i>'; ?>
									@endif
                                    <a href="{{url(ADMINSEPARATOR.'/disputereasonadd/'.$reasons->id)}}"><i class="fa fa-edit fa-lg"></i></a>
                                    <a href="javascript:void(0);" id="changeStatus{{$reasons->id}}" class="changeStatus" data-id="{{$reasons->id}}">{!! $StatusHtml!!}</a>
									<a href="javascript:void(0);" id="deletereason{{$reasons->id}}" class="deletereason" data-delid="{{$reasons->id}}"><i class="fa fa-trash-o fa-lg"></i></a>
                                </td>
							</tr>
						@endforeach		
						@else
                        <tr><td colspan="4">No record found!</td></tr>
                        @endif
						</tbody>
					</table>
					<div class="panel-footer clearfix">
                       {{$DisputeReason->appends($useinPagiAr)->render()}}
					</div>
			</div><!-- /panel -->

						
					</div>
					</div>
			</div><!-- /.padding-md -->
			
			


<!-- modal to provide deactivation reason starts -->
	<div class="modal fade" id="deactivation_cause" tabindex="-1" role="dialog" >
		<div class="modal-dialog popup-dialog" role="document">
			<div class="modal-content popup-content artist_popup">
				<div class="modal-body popup-body">
					<div class="artist_hedr">
						<button type="button" class="close popup-close " data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4>Provide reason for deactivating the user :</h4>
					</div>
						<hr>
					<?php
						echo Form::open(array('url'=>'','method'=>'post','files'=>true,'id'=>'','class'=>'form-login'))
                    ?> 
					<div class="artist_form_outr clearfix">
						<div class="form-group">
                            <div class="col-lg-12">
								<?php 
                                    echo Form::textarea("cause", $value="", $attributes = array("id"=>"cause","class"=>"form-control input-sm"));
                                ?>
                                <div id="causeerr"></div>
                            </div><!-- /.col -->
                        </div>
					</div>
						<?php echo Form::hidden("statuschangeto", $value="", $attributes=array("id"=>"statuschangeto")); ?>
						<?php echo Form::hidden("statuschangeduserid", $value="", $attributes=array("id"=>"statuschangeduserid")); ?>
						<?php echo Form::hidden("groupinfoid", $value="", $attributes=array("id"=>"groupinfoid")); ?>

						<?php echo Form::hidden("venueinfoid", $value="", $attributes=array("id"=>"venueinfoid")); ?>
					<br>
					<div class="col-lg-2">
                        <button type="button" id="causebut" class="btn btn-success btn-sm">Deactive</button>
					</div>
						<br>
						<br>
					<?php echo Form::close();?>
				</div>
			</div>
		</div>
    </div>
<!-- modal to provide deactivation reason ends -->

<script>

	jQuery(document).ready(function(){
	
		$('#deactivation_cause').modal('hide');
	
		jQuery(".delcusclass").click(function(){
				
			var delid = $(this).data('delid');
			
			var redurl="<?php echo url(ADMINSEPARATOR.'/userdel');?>"+"/"+delid;
			
			var chkdel=confirm("Are you sure you want to delete this user ?");
			
			if (chkdel==true)
			{
					window.location.href=redurl;
			}
						
		});
	    						jQuery("#clearsearch").click(function()
			{			
			window.location.href="<?php echo url(ADMINSEPARATOR.'/disputereason');?>";								
			});	
		jQuery(".sorttrackclass").click(function(){
		
			sortname = jQuery(this).data('sortname');
			sorttype = jQuery(this).data('sorttype');
			
			if (sorttype == 'ASC') {
					setsorttype = 'DESC';
			}
			else{
					setsorttype = 'ASC';
			}
			
			jQuery("#sort1").val(sortname);
			jQuery("#sorttype1").val(setsorttype);
			jQuery('#userslistsearch').submit();
			
		});
	//for Search
		jQuery("#srchbutondisputeReason").click(function(){	
             
			var srch1data=jQuery("#srch1").val();
            var url="<?php echo url(ADMINSEPARATOR.'/disputereason/');?>";
            
			if (srch1data=='')
			{
				jQuery("#sort1").val('');
				jQuery("#sorttype1").val('');
				window.location.href=url;
			}
			else
			{
				jQuery("#disputereasonsearch").submit();
			}
					
		});
	//End Search
	//for Status change
 jQuery(".changeStatus").click(function(){  //**********Update Status Change Starts here
				
        var chkconfstatus=confirm(" Are you sure , you want to change the status ? ");
                
        var statuschange_data=jQuery(this).data('id');

        if (chkconfstatus==true)
        {
            var snddata = {_token:"<?php echo csrf_token(); ?>",statuschange: statuschange_data};
                                                  
            //alert(JSON.stringify(snddata));
                                          
            jQuery.ajax({
				type: "POST",
				data:snddata,
				url: "<?php echo url(ADMINSEPARATOR.'/disputereasonstatus');?>",
				dataType:"json",
				success: function(data)
				{
					var flagdata=data.flag;
					
					if (flagdata==1)
					{
						$('#changeStatus'+statuschange_data).html('<i class="fa fa-unlock fa-lg"></i>');
					}
					else if (flagdata==0)
					{
						$('#changeStatus'+statuschange_data).html('<i class="fa fa-lock fa-lg"></i>');
					}
                }
            });
        }
    });
	//End status Change
	//Delete Row start	
		jQuery(".deletereason").click(function(){
			var urlto="<?php echo url(ADMINSEPARATOR.'/disputereason/');?>";
			var chkconfdelete=confirm(" Are you sure , you want to delete ? ");
			
			var delete_id=jQuery(this).data('delid');
			
			if (chkconfdelete==true)
			{
				var snddata = {_token:"<?php echo csrf_token(); ?>",delete_id:delete_id};
				jQuery.ajax({
					type: "GET",
					data:snddata,
					url: "<?php echo url(ADMINSEPARATOR.'/disputereasondel');?>",
					dataType:"json",
					success: function(d)
					{
						console.log(d);
						if (d.type=='error')
						{
							$("#messege_id").html(d.messege);
							$("#messege_id").addClass('alert-danger');
							$("#messege_id").fadeIn('slow');
							$('#messege_id').delay(1000).fadeOut('slow');
						}
						else
						{
							 // window.location.assign("http://www.w3schools.com")
							 window.location.href=urlto;
							// $("#messege_id").html("Deleted successfully");
							// $("#messege_id").addClass('alert-success');
							// $("#messege_id").fadeIn('slow');
							// $('#messege_id').delay(1000).fadeOut('slow');
						}
					}
				});
			}
			
		});
	//Delete Row END
	});
</script>
<!-- <script type="text/javascript" src="{{ ADMINCSSPATH}}/otherfiles/progjs/userlist.js"></script> -->
	
@endsection