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
						Subscriber List
						<!--<span class="pull-right"><a type="button" class="btn btn-xs btn-success" href="<?php echo  url(ADMINSEPARATOR.'/useradd'); ?>" >ADD</a></span>-->
					</div>
					<div class="panel-body">
						<div class="row">
							<div class="col-md-4 col-sm-4">
								<?php echo Form::open(array('url' => ADMINSEPARATOR.'/subscription', 'method' => 'get','id'=>'subscriberlistsearch','class'=>"form-horizontal form-border no-margin")); ?>
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
									<?php echo Form::text("srch1", $value=$srch1, $attributes = array( "id"=>"srch1","class"=>" form-control input-sm ","placeholder"=>"Search by email")); ?>
									<?php echo Form::hidden("sort1", $value=$sort1, $attributes = array( "id"=>"sort1","class"=>" form-control input-sm ")); ?>
									<?php echo Form::hidden("sorttype1", $value=$sorttype1, $attributes = array( "id"=>"sorttype1","class"=>" form-control input-sm ")); ?>
									<div class="input-group-btn">
										<button tabindex="-1" style="margin-right:10px;" class="btn btn-sm btn-success" type="button" id="srchbuttonuser">Search</button>
									    <button tabindex="-1" type="button" class="btn btn-sm btn-info" id="clearsearch">Clear Search</button>
									</div> <!-- /input-group-btn -->
							    </div>
								<?php echo Form::close(); ?>
							</div><!-- /.col -->
						</div><!-- /.row -->
					</div>
					<table class="table table-striped" id="responsiveTable">
						<thead>
							<tr>
								<th data-sortname="email" data-sorttype="<?php echo $sorttype1; ?>" class="sorttrackclass" >Email<i class="<?php echo $default_srt_class1; ?>"></i></th>
								<th>Subscription Date</th>
								<th>Deactivate Date</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							<?php
								if(!empty($pagi_user) && ( $pagi_user->count()>0 ) )
								{
									foreach($pagi_user as $users_obj)
									{
										$status=$users_obj->status;
										$status_change_to=($status==1)?0:1;
										$status_icon_class=($status==1)? "fa fa-unlock fa-lg":"fa fa-lock fa-lg";
										
										$deactvondt=$users_obj->deactivate_date;
										if($deactvondt!='' && $deactvondt!='0000-00-00 00:00:00')
										{
											$deactivated=date('d-m-Y H:i A',strtotime($deactvondt));
										}
										else{
											$deactivated='------------------------------';
										}
							?>
							<tr>	
								<td><?php echo stripslashes($users_obj->email); ?></td>
								<td><?php $crt_dt=stripslashes($users_obj->create_date); echo date('d-m-Y H:i A',strtotime($crt_dt)); ?></td>
								<td><span id="deactv_<?php echo $users_obj->id; ?>"><?php echo $deactivated;?></span</td>
								<td>
									<a href="javascript:void(0);" ><i id="stat_<?php echo $users_obj->id; ?>" href="javascript:void(0);" data-userid="<?php echo $users_obj->id; ?>" data-statuschange="<?php echo $status_change_to; ?>" class="statustrkclass <?php echo $status_icon_class; ?>"></i></a>
									<!--<a class="delcusclass" data-delid="<?php echo $users_obj->id; ?>" href="javascript:void(0);"><i class="fa fa-trash-o fa-lg"></i></a>-->
								</td>
							</tr>
							<?php
									}	
								}
								else{
							?>
							<tr><td colspan="4">No record found!</td></tr>
							<?php
								}
							?>
						</tbody>
					</table>
					<div class="panel-footer clearfix">
						<?php echo $pagi_user->appends($useinPagiAr)->render(); ?>
					</div>
				</div><!-- /panel -->
			</div>
		</div>
	</div><!-- /.padding-md -->
	<script>
		jQuery(document).ready(function(){
	
			jQuery(".delcusclass").click(function(){	
				var delid = $(this).data('delid');
				var redurl="<?php echo url(ADMINSEPARATOR.'/subscriptiondel');?>"+"/"+delid;
				var chkdel=confirm("Are you sure you want to delete this subscriber ?");
				if (chkdel==true)
				{
					window.location.href=redurl;
				}			
			});
	        jQuery("#clearsearch").click(function(){						
					window.location.href="<?php echo url(ADMINSEPARATOR.'/subscription');?>";								
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
				jQuery('#subscriberlistsearch').submit();
			});
	
			jQuery("#srchbuttonuser").click(function(){		
				var srch1data=jQuery("#srch1").val();
				if (srch1data=='')
				{
					jQuery("#sort1").val('');
					jQuery("#sorttype1").val('');		
					window.location.href="<?php echo url(ADMINSEPARATOR.'/subscription');?>";
				}
				else
				{
					jQuery("#subscriberlistsearch").submit();
				}
						
			});
		
			jQuery(".statustrkclass").click(function(){	
				var chkconfstatus=confirm(" Are you sure , you want to change the status ? ");
				var statuschange_data=jQuery(this).data('statuschange');
				//alert("statuschange_data==>"+statuschange_data);
				var userid_data=jQuery(this).data('userid');
				//alert("userid_data==>"+userid_data);
				if (chkconfstatus==true)
				{
					var snddata = {_token:"<?php echo csrf_token(); ?>",statuschange: statuschange_data,userid:userid_data};
												  
					//alert(JSON.stringify(snddata));					  
					jQuery.ajax({
						type: "POST",
						data:snddata,
						url: "<?php echo url(ADMINSEPARATOR.'/subscriptionstatus');?>",
						dataType:"json",
						success: function(data)
						{
							//var tt=JSON.stringify(data);
							//alert(tt);
							//console.log(data);
							var flagdata=data.flag;
							var iddata=data.iddata;
							var ancid="stat_"+iddata;
							var deactvid="deactv_"+iddata;
							var deactvon=data.deactvdt;
							if ( (flagdata==1) && (statuschange_data==1) )
							{	
										jQuery("#"+ancid).removeClass("fa-lock");
										jQuery("#"+ancid).addClass("fa-unlock");
										jQuery("#"+ancid).data('statuschange','0');
										jQuery("#"+deactvid).html(deactvon);
							}
							else if ((flagdata==1) && (statuschange_data==0))
							{	
										jQuery("#"+ancid).removeClass("fa-unlock");
										jQuery("#"+ancid).addClass("fa-lock");											
										jQuery("#"+ancid).data('statuschange','1');
										jQuery("#"+deactvid).html(deactvon);
							}
							subscriptionmail(statuschange_data,iddata);
						}
					});
				}
			});
			
			function subscriptionmail(statuschange_data,iddata) {
				var snddata1 = {_token:"<?php echo csrf_token(); ?>",statuschange:statuschange_data,iddata:iddata};
				//alert(JSON.stringify(snddata1));
                jQuery.ajax({
					type: "POST",
					data:snddata1,
					url: "<?php echo url(ADMINSEPARATOR.'/subscriptionstatusmail');?>",
					success: function(data)
					{
					}
				});
            }
		});
	</script>	
@endsection