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
			<div class="col-md-12">
				<div class="panel panel-default table-responsive">
					<div class="panel-heading">
						Contact List
					</div>
					<div class="panel-body">
						<div class="row">
							<div class="col-md-4 col-sm-4">
								<?php echo Form::open(array('url' => ADMINSEPARATOR.'/contactus', 'method' => 'get','id'=>'contactuslistfrmid','class'=>"form-horizontal form-border no-margin" ));?>
									<div class="input-group">
									<?php
									$srch1='';$sort1='';$sorttype1='ASC';
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
									<?php echo Form::text("srch1", $value=$srch1, $attributes = array( "id"=>"srch1","class"=>" form-control input-sm ","placeholder"=>"Search by First Name or Last Name or Email-ID","style"=> "width: 300px")); ?>
									<?php echo Form::hidden("sort1", $value=$sort1, $attributes = array( "id"=>"sort1","class"=>" form-control input-sm ")); ?>
									<?php echo Form::hidden("sorttype1", $value=$sorttype1, $attributes = array( "id"=>"sorttype1","class"=>" form-control input-sm ")); ?>    
										<div class="input-group-btn">
											<button tabindex="-1" class="btn btn-sm btn-success" type="button" id="srchbutton" style="margin-right:10px;">Search</button>
											<button tabindex="-1" class="btn btn-sm btn-info" type="button" id="clearsearchbtn">Clear search</button>	
										</div> <!-- /input-group-btn -->
									</div>
								<?php echo  Form::close(); ?>
							</div><!-- /.col -->
						</div><!-- /.row -->
					</div>
					<table class="table table-striped" id="responsiveTable">
						<thead>
							<tr>
								<th data-sortname="contact_first_name" data-sorttype="<?php echo $sorttype1; ?>" class="sorttrackclass" >Name <i  class=" <?php echo $default_srt_class1; ?>"></i></th>
								<th>Email </th>
								<!-- <th>Phone</th> -->
								<th>Reason</th>
								<th>Reply status</th>
								<th>Last reply date</th>
								<!-- <th>Date</th> -->
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							<?php
							if(!empty($pagi_contactus) && ( $pagi_contactus->count()>0 ) )
							{
								foreach($pagi_contactus as $contactus_obj)
								{	
							?>
							<tr>
								<td><?php echo stripslashes($contactus_obj->contactpersonname); ?></td>
								<td><?php echo trim($contactus_obj->contact_email); ?></td>
								<!-- <td><?php //echo $contactus_obj->contact_email; ?></td> -->
								<td><?php echo stripslashes($contactus_obj->category_name); ?></td>
								<!-- <td><?php //echo stripslashes($contactus_obj->contact_message); ?></td> -->
								<!-- <td><?php //$cndt=$contactus_obj->contact_date; echo date("jS F, Y H:i A", strtotime($cndt)); ?></td> -->
								<td>
									<?php echo stripslashes($contactus_obj->replystatus);?>
								</td>
								<td>
									<?php echo stripslashes($contactus_obj->contactbackdate);?>
								</td>

								<td>
									


									<a href="javascript:void(0);" title="Click here to reply" class="viewemailcls" data-viewemailid =<?php echo $contactus_obj->id?>><i class="fa fa-envelope fa-lg"></i></a>
									

									<a href="javascript:void(0);" class="viewdetailscls"  title="view details" data-viewdetailsid =<?php echo $contactus_obj->id?>><i class="fa fa-external-link fa-lg"></i></a> 
								</td>	
							</tr>
							<?php
								}	
							}
							else
							{
							?>
							<tr>
								<td colspan="4" >No data found.</td>
							</tr>	
							<?php
							}
							?>
						</tbody>
					</table>
					<div class="panel-footer clearfix">
						<?php echo $pagi_contactus->appends($useinPagiAr)->render(); ?>
					</div>
				</div><!-- /panel -->	
			</div>
		</div>
	</div><!-- /.padding-md -->
	<script>				
		jQuery(document).ready(function(){
		
			jQuery(".sorttrackclass").click(function(){
				sortname = jQuery(this).data('sortname');
				sorttype = jQuery(this).data('sorttype');
				if (sorttype == 'ASC') {
						setsorttype = 'DESC';
				}
				else{
						setsorttype = 'ASC';
				}
				//alert(setsorttype);
				jQuery("#sort1").val(sortname);
				jQuery("#sorttype1").val(setsorttype);
				jQuery('#contactuslistfrmid').submit();
			});
			
			jQuery(".delcusclass").click(function(){
					var delid = $(this).data('delid');
					var redurl="<?php echo url(ADMINSEPARATOR.'/contactusdel');?>"+"/"+delid;
					var chkdel=confirm("Are you sure you want to delete ?");
					if (chkdel==true)
					{
							window.location.href=redurl;
					}
			});

			jQuery("#srchbutton").click(function(){
				var srch1data=jQuery("#srch1").val();
				if (srch1data=='')
				{
					jQuery("#sort1").val('');
					jQuery("#sorttype1").val('');
					window.location.href="<?php echo url(ADMINSEPARATOR.'/contactus');?>";
				}
				else
				{
					jQuery("#contactuslistfrmid").submit();
				}
			});

			$("#clearsearchbtn").click(function(){

				window.location.href="<?php echo url(ADMINSEPARATOR.'/contactus');?>";
			});

			
			$('.viewdetailscls').click(function()
			{	
				var viewid = $(this).data('viewdetailsid');
				window.location.href="<?php echo url(ADMINSEPARATOR.'/contactusdetails');?>"+"/"+viewid;
				

			});
			$('.viewemailcls').click(function(){
				var viewid = $(this).data('viewemailid');
				window.location.href="<?php echo url(ADMINSEPARATOR.'/contactusdetailsemail');?>"+"/"+viewid;
			});
			
		});	
		
	</script>
@endsection