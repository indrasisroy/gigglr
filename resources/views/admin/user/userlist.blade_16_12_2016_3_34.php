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
						User List
						<span class="pull-right"><a type="button" class="btn btn-xs btn-success" href="<?php echo  url(ADMINSEPARATOR.'/useradd'); ?>" >ADD</a></span>
					</div>
					<div class="panel-body">
						<div class="row">
							<div class="col-md-4 col-sm-4">
							<?php echo Form::open(array('url' => ADMINSEPARATOR.'/user', 'method' => 'get','id'=>'userslistsearch','class'=>"form-horizontal form-border no-margin")); ?>
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
							   
								<?php echo Form::text("srch1", $value=$srch1, $attributes = array( "id"=>"srch1","class"=>" form-control input-sm ","placeholder"=>"Search by Nickname or Email","style"=>"width:200px")); ?>
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
								<!--<th>Name</th>-->
								<th data-sortname="first_name" data-sorttype="<?php echo $sorttype1; ?>" class="sorttrackclass" >Nickname <i  class=" <?php echo $default_srt_class1; ?>"></i></th>
								<th>Name </th>
								<th>Email </th>
								<th>Deactivation Report</th>
								<th>Action</th>
								<th class="col-md-1">

									<label class="label-checkbox">
										<input type="checkbox" id="chk-all">
										<span class="custom-checkbox"></span>
										<a type="button" class="btn btn-xs btn-success" id="deleteBtn" href="javascript:void(0)">Delete </a>
									</label>
								</th>
								<th>Group Info</th>
								<th>Venue Info</th>
								<th>Review Info</th>
							</tr>
						</thead>
						<tbody>
						<?php
						
						if(!empty($pagi_user) && ( $pagi_user->count()>0 ) )
						{
							foreach($pagi_user as $users_obj)
							{
								$nick=stripslashes($users_obj->nickname);
								$fullname=stripslashes($users_obj->name);
								$umail=stripslashes($users_obj->email);
								$groupinfo=$users_obj->grp;	
								$venueinfo=$users_obj->ven;
								$recentuserid=$users_obj->id;
								$status=$users_obj->status;
								$status_change_to=($status==1)?0:1;
								$verified_status=$users_obj->verify_status;
								$status_icon_class=($status==1)? "fa fa-unlock fa-lg":"fa fa-lock fa-lg";
						?>
						
							<tr>
								<td>
									<?php
										if($nick!=''){
											echo $nick;
										}
										else{
											echo "No info available";
										}
									?>
								</td>
								<td>
									<?php
										if($fullname!=''){
											echo $fullname;
										}
										else{
											echo "No info available";
										}
									?>
								</td>
								<td>
									<?php
										if($umail!=''){
											echo $umail;
										}
										else{
											echo "No info available";
										}
									?>
								</td>
								<td><span id="deactvby_<?php echo $users_obj->id; ?>"><?php if($status!=1){ if($status=='0'){ echo "Deactivated by admin  "; }else{ echo "Deactivated by user  "; } }else{ echo "-----------------------------"; } ?></span><span id="deactvbyczinfo_<?php echo $users_obj->id; ?>"><?php if($status!=1){ ?><a href="javascript:void(0);" class="dectreason" data-recentuserid="<?php echo $recentuserid;?>" data-toggle="modal" data-target="#deactivation_reason" title="Reason"><i class="fa fa-info-circle fa-lg"></i></a><?php } ?></span></td>
								<td>
									<a href="<?php echo  url(ADMINSEPARATOR.'/useradd/'.$users_obj->id); ?>" title="Edit"><i class="fa fa-edit fa-lg"></i></a>
								
									<a href="javascript:void(0);" title="Change status"><i id="stat_<?php echo $users_obj->id; ?>" href="javascript:void(0);" data-userid="<?php echo $users_obj->id; ?>"  data-groupinfo="<?php echo $groupinfo;?>" data-venueinfo="<?php echo $venueinfo;?>" data-statuschange="<?php echo $status_change_to; ?>" class="statustrkclass <?php echo $status_icon_class; ?>"></i></a>
									
									<a class="delcusclass" data-delid="<?php echo $users_obj->id; ?>" href="javascript:void(0);" title="Delete"><i class="fa fa-trash-o fa-lg"></i></a>


									<a href="<?php echo  url(ADMINSEPARATOR.'/transctiondeatils/'.$users_obj->id); ?>" title="Transaction details"><i class="fa fa-external-link fa-lg"></i></a>

									 <a  href="javascript:void(0);" title="<?php echo ($verified_status > 0 ? 'Verified' : 'Not Verified') ?>"><i class="<?php echo ($verified_status > 0 ? 'fa fa-check fa-lg' : 'fa fa-times fa-lg') ?>"></i></a>

								</td>

								<td class="col-md-1">
									<label class="label-checkbox">
										<input type="checkbox" name="multidel" class="chk-row" data-id="<?php echo $users_obj->id;?>">
										<span class="custom-checkbox"></span>
									</label>
								</td>


								<td>
								<span id="<?php echo "spngrp".$users_obj->id;?>">
									<?php

										if($groupinfo!=''){

											if($status!=1)
											{
												?>
												<a href="<?php  echo url(ADMINSEPARATOR.'/useradd/groupadd/'.$users_obj->id.'/'.$groupinfo);?>">View Group </a>
												<?php 
											}else if($status==1){


									?>
											<a href="<?php  echo url(ADMINSEPARATOR.'/useradd/groupadd/'.$users_obj->id).'/'.$groupinfo;?>">Edit Group</a>
									<?php
								}
										}
										else{

											if($status!=1)
											{
												?>
												<a href="javascript:void(0);" onclick="openmodalfunc(1);">Group</a>
											<?php 
										} else if($status == 1)
										{
									?>
											<a href="<?php  echo url(ADMINSEPARATOR.'/useradd/groupadd/'.$users_obj->id);?>">Add Group</a>
									<?php
										}
									}
									?>
									</span>
								</td>
								<td>
									<span id="<?php echo "spnvnu".$users_obj->id;?>">
									<?php
								//	echo $venueinfo;
										if($venueinfo!=''){
											if($status!=1)
											{
												?>
									<a href="<?php  echo url(ADMINSEPARATOR.'/useradd/venueadd/'.$users_obj->id.'/'.$venueinfo);?>">View Venue </a>
											<?php 
										}else if($status==1)
										{
									?>
											<a href="<?php  echo url(ADMINSEPARATOR.'/useradd/venueadd/'.$users_obj->id.'/'.$venueinfo);?>">Edit Venue</a>
									<?php
										}
									}
										else{


											if($status!=1)
											{?>
												<a href="javascript:void(0);" onclick="openmodalfunc(0);">Venue</a>
											<?php 
										    }else if($status==1){

									?>
											<a href="<?php  echo url(ADMINSEPARATOR.'/useradd/venueadd/'.$users_obj->id);?>">Add Venue</a>
									<?php
										}
									}
									?>
									</span>
								</td>
								 <td><a href="<?php  echo url(ADMINSEPARATOR.'/userreview/'.$users_obj->id);?>">View Review </a></td>
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
			
			
<!-- modal to show deactivation reason starts -->
	<div class="modal fade" id="deactivation_reason" tabindex="-1" role="dialog" >
		<div class="modal-dialog popup-dialog" role="document">
			<div class="modal-content popup-content artist_popup">
				<div class="modal-body popup-body">
					<div class="artist_hedr">
						<button type="button" class="close popup-close " data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
						<h4>Reason for deactivation of user :</h4>
					</div>
						<hr>
					<div class="artist_form_outr clearfix">
						<div id="deactivationreasondiv"></div>
					</div>
						<br>
				</div>
			</div>
		</div>
    </div>
<!-- modal to show deactivation reason ends -->

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




<div class="modal fade" id="simpleModal">
  			<div class="modal-dialog modal-sm">
    			<div class="modal-content">
      				<!-- <div class="modal-header">
        				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4>Modal header</h4>
      				</div> -->
				    <div class="modal-body">
				        <p>This user account is already deactivated.</p><span id="msgchk"> </span>
				    </div>
				    <div class="modal-footer">
				        <button class="btn btn-sm btn-success" data-dismiss="modal" aria-hidden="true">Close</button>
						
				    </div>
			  	</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
		</div><!-- /.modal -->

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
	
		jQuery("#srchbuttonuser").click(function(){			
			var srch1data=jQuery("#srch1").val();
			if (srch1data=='')
			{
						jQuery("#sort1").val('');
						jQuery("#sorttype1").val('');
						
						window.location.href="<?php echo url(ADMINSEPARATOR.'/user');?>";
			}
			else
			{
						jQuery("#userslistsearch").submit();
			}
					
		});
		
		jQuery(".statustrkclass").click(function(){
			var chkconfstatus=confirm(" Are you sure , you want to change the status ? ");
			var statuschange_data=jQuery(this).data('statuschange');
			var userid_data=jQuery(this).data('userid');
			var groupinfo_data = jQuery(this).data('groupinfo');
			var venueinfo_data = jQuery(this).data('venueinfo');
				
			if (chkconfstatus==true)
			{
				if (statuschange_data==1) {
					changing_status(statuschange_data,userid_data,groupinfo_data,venueinfo_data);
                }
				else{
					$('#deactivation_cause').modal('show');
					$('#statuschangeto').val(statuschange_data);
					$('#statuschangeduserid').val(userid_data);
					$('#groupinfoid').val(groupinfo_data);
					$('#venueinfoid').val(venueinfo_data);
					
				}
			}
		});
		
		jQuery("#causebut").click(function(){
			var statuschange_data=$('#statuschangeto').val();
			var userid_data=$('#statuschangeduserid').val();

			var groupinfo_data = $('#groupinfoid').val();
			var venueinfo_data = $('#venueinfoid').val();

			var cause=$('#cause').val();
			var snddata = {_token:"<?php echo csrf_token(); ?>",cause:cause,userid:userid_data};
			jQuery.ajax({
				type: "POST",
				data:snddata,
				url: "<?php echo url(ADMINSEPARATOR.'/statusdeactivate');?>",
				dataType:"json",
				success: function(d)
				{
					console.log(d);
					if (d.flag_id==0)
                    {      
						var error_message=d.error_message;
						var error_message_data='';
												   
						if (error_message!=null)
						{
							 for (ermsgkey in error_message)
							 {
								  error_message_data+="<p>"+ error_message[ermsgkey]+"</p>";
							 }
						}
                        $("#causeerr").html(error_message_data);                
                    }
                    else
                    {
						changing_status(statuschange_data,userid_data,groupinfo_data,venueinfo_data);
						$('#deactivation_cause').modal('hide');
                    }
				}
			});
		});
		
		function changing_status(statuschange_data,userid_data,groupinfo_data,venueinfo_data)
		{
			if(!groupinfo_data)
			{
				groupinfo_data = 0;
			}
			if(!venueinfo_data)
			{
				venueinfo_data = 0;
			}
		//	alert(venueinfo_data);

			var snddata = {_token:"<?php echo csrf_token(); ?>",statuschange: statuschange_data,userid:userid_data,groupinfo_data:groupinfo_data,venueinfo_data:venueinfo_data}; 
		//	alert(JSON.stringify(snddata));						  
			jQuery.ajax({
				type: "POST",
				data:snddata,
				url: "<?php echo url(ADMINSEPARATOR.'/userstatus');?>",
				dataType:"json",
				success: function(data)
				{
					//var tt=JSON.stringify(data);
					//alert(tt);
					var flagdata=data.flag;
					var iddata=data.iddata;
					var ancid="stat_"+iddata;
					var deactvid="deactvby_"+iddata;
					var deactvfor=data.deactvcz;
					var deactvczinfo="deactvbyczinfo_"+iddata;
					if ( (flagdata==1) && (statuschange_data==1) )
					{	
								jQuery("#"+ancid).removeClass("fa-lock");
								jQuery("#"+ancid).addClass("fa-unlock");
								jQuery("#"+ancid).data('statuschange','0');
								jQuery("#"+deactvid).html(deactvfor);
								jQuery("#"+deactvczinfo).hide();

								// console.log('deactiveurl_group is '+deactiveurl_group);
								// console.log('deactiveurl_venue is '+deactiveurl_venue);
								
					//console.log(data);
									//$("#spn"+iddata).html('');
								$("#spngrp"+iddata).html(data.deactiveurl_group);
								$("#spnvnu"+iddata).html(data.deactiveurl_venue);
								
					}
					else if ((flagdata==1) && (statuschange_data==0))
					{	
								jQuery("#"+ancid).removeClass("fa-unlock");
								jQuery("#"+ancid).addClass("fa-lock");											
								jQuery("#"+ancid).data('statuschange','1');
								jQuery("#"+deactvid).html(deactvfor);
								jQuery("#"+deactvczinfo).show();

								// console.log('deactiveurl_group is '+deactiveurl_group);
								// console.log('deactiveurl_venue is '+deactiveurl_venue);

					//console.log(data);

								$("#spngrp"+iddata).html(data.deactiveurl_group);
								$("#spnvnu"+iddata).html(data.deactiveurl_venue);
					}
				}
			});
		}



		jQuery(".dectreason").click(function(){
		var recentuserid = jQuery(this).data('recentuserid');
		//alert(recentuserid);
		var snddata = {_token:"<?php echo csrf_token(); ?>",recentuserid:recentuserid}					  
		jQuery.ajax({
			type: "POST",
			data:snddata,
			url: "<?php echo url(ADMINSEPARATOR.'/deactivationreason');?>",
			dataType:"json",
			success: function(data)
			{
				//console.log(data);
				jQuery("#deactivationreasondiv").html(data.deactivate_reason);
			}
		});
	});
		
		
	});

function openmodalfunc(j)
{
	//console.log("j=>"+j);
	if(j == 1)
	{
		$("#msgchk").html('Therefore group can not be created.');
		$("#simpleModal").modal('show');
	}else if(j == 0)
	{
		$("#msgchk").html('Therefore venue can not be created.');
		$("#simpleModal").modal('show');
	}
}
jQuery("#clearsearch").click(function(){						
					window.location.href="<?php echo url(ADMINSEPARATOR.'/user');?>";								
					});





//*********** multiple delete starts here


$('#chk-all').click(function()
												{
													if($(this).is(':checked'))	
													{
														$('#responsiveTable').find('.chk-row').each(function()	{
														$(this).prop('checked', true);
														$(this).parent().parent().parent().addClass('selected');
														});
													}
												else{
														$('#responsiveTable').find('.chk-row').each(function()	{
														$(this).prop('checked' , false);
														$(this).parent().parent().parent().removeClass('selected');
														});
													}
												});
												$('.chk-row').change(function(){ 
												   //uncheck "select all", if one of the listed checkbox item is unchecked
												   if(false == $(this).prop("checked")){ //if this item is unchecked
													   $("#chk-all").prop('checked', false); //change "select all" checked status to false
												   }
												   //check "select all" if all checkbox items are checked
												   if ($('.chk-row:checked').length == $('.chk-row').length ){
													   $("#chk-all").prop('checked', true);
												   }
											   });
											jQuery('#deleteBtn').click(function() 
											{

												var idval = [];

												$("input[type='checkbox'][name='multidel']:checked").each(function(i)
												{
													idval[i] = $(this).data('id');
												//	console.log($(this).data('id'));
											});
												var idvllength = idval.length;
												if(idvllength  > 0)
												{
													idval.toString();
													var redurl="<?php echo url(ADMINSEPARATOR.'/multipleuserldelete');?>"+"/"+idval;
													var chkdel=confirm("Are you sure you want to delete ?");

													if (chkdel==true)
													{
													window.location.href=redurl;
												//alert('user deleted successfully');
													}
												}else
												{
													alert('select a checkbox to delete');
												}

											});


//*********** multiple delete ends here
</script>
<!-- <script type="text/javascript" src="{{ ADMINCSSPATH}}/otherfiles/progjs/userlist.js"></script> -->
	
@endsection