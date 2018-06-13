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
						Country List
						<span class="pull-right"><a type="button" class="btn btn-xs btn-success" href="<?php echo  url(ADMINSEPARATOR.'/countryadd'); ?>" >ADD</a></span>
					</div>
					<div class="panel-body">
						<div class="row">
							<div class="col-md-4 col-sm-4">
								<!--<select class="input-sm form-control inline" style="width:130px;"> 
									<option value="0">All</option> 
									<option value="1">Men</option> 
									<option value="2">Women</option> 
									<option value="3">Accessary</option> 
								</select>
								<a class="btn btn-default btn-sm">Apply</a>-->
								
								
								
								 <?php echo Form::open(array('url' => ADMINSEPARATOR.'/country', 'method' => 'get','id'=>'countrylistfrmid','class'=>"form-horizontal form-border no-margin" ));?>
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
							   
								<?php echo Form::text("srch1", $value=$srch1, $attributes = array( "id"=>"srch1","class"=>" form-control input-sm ","placeholder"=>"search by country name")); ?>
							      
								  <?php echo Form::hidden("sort1", $value=$sort1, $attributes = array( "id"=>"sort1","class"=>" form-control input-sm ")); ?>
								<?php echo Form::hidden("sorttype1", $value=$sorttype1, $attributes = array( "id"=>"sorttype1","class"=>" form-control input-sm ")); ?>    
										<div class="input-group-btn">
							            	<button tabindex="-1" class="btn btn-sm btn-success" type="button" id="srchbutton">Search</button>
							            	
							            </div> <!-- /input-group-btn -->
								
							        </div>
								<?php echo  Form::close(); ?>
								
							</div><!-- /.col -->
						</div><!-- /.row -->
					</div>
					<table class="table table-striped" id="responsiveTable">
						<thead>
							<tr>
								<!--<th>
									<label class="label-checkbox">
										<input type="checkbox" id="chk-all">
										<span class="custom-checkbox"></span>
									</label>
								</th>-->
								<th data-sortname="country_name" data-sorttype="<?php echo $sorttype1; ?>" class="sorttrackclass" >Country Name <i  class=" <?php echo $default_srt_class1; ?>"></i></th>
								<th>Country 2 Letter Code </th>
								<th>Country 3 Letter Code</th>
								<th>Action</th>
								
							</tr>
						</thead>
						<tbody>
						<?php
						
						if(!empty($pagi_country) && ( $pagi_country->count()>0 ) )
						{
						
								foreach($pagi_country as $countries_obj)
								{
									$status=$countries_obj->published;
									$status_change_to=($status==1)?0:1;
									
									$status_icon_class=($status==1)? "fa fa-unlock fa-lg":"fa fa-lock fa-lg";
									
									
						?>
							<tr>
								<!--<td>
									<label class="label-checkbox">
										<input type="checkbox" class="chk-row">
										<span class="custom-checkbox"></span>
									</label>
								</td>-->
								<td><?php echo stripslashes($countries_obj->country_name); ?></td>
								<td><?php echo stripslashes($countries_obj->country_3_code); ?></td>
								<td><?php echo stripslashes($countries_obj->country_2_code); ?></td>
								<td>
								<a href="<?php echo  url(ADMINSEPARATOR.'/countryadd/'.$countries_obj->id); ?>"><i class="fa fa-edit fa-lg"></i></a>
								<a href="javascript:void(0);" ><i id="stat_<?php echo $countries_obj->id; ?>" href="javascript:void(0);" data-countryid="<?php echo $countries_obj->id; ?>" data-statuschange="<?php echo $status_change_to; ?>" class="statustrkclass <?php echo $status_icon_class; ?>"></i></a>
								<a class="delcusclass" data-delid="<?php echo $countries_obj->id; ?>" href="javascript:void(0);"><i class="fa fa-trash-o fa-lg"></i></a>
								</td>
								
							</tr>
								
								<?php
								}
								
							}
							else
							{
								?>
							<tr><td colspan="4" >No data found.</td> </tr>	
								<?php
								}
								?>
							
						</tbody>
					</table>
					<div class="panel-footer clearfix">
						<!--<ul class="pagination pagination-xs m-top-none pull-right">
							<li class="disabled"><a href="#">Previous</a></li>
							<li class="active"><a href="#">1</a></li>
							<li><a href="#">2</a></li>
							<li><a href="#">3</a></li>
							<li><a href="#">4</a></li>
							<li><a href="#">5</a></li>
							<li><a href="#">Next</a></li>
						</ul>-->
						<?php echo $pagi_country->appends($useinPagiAr)->render(); ?>
						
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
						jQuery('#countrylistfrmid').submit();
				});
				
				
				jQuery(".delcusclass").click(function(){
				
						var delid = $(this).data('delid');
						var redurl="<?php echo url(ADMINSEPARATOR.'/countrydel');?>"+"/"+delid;
						
						var chkdel=confirm("Are you sure you want to delete ?");
						
						if (chkdel==true)
						{
								window.location.href=redurl;
						}
								
				
				});
				
				
				jQuery(".statustrkclass").click(function(){
				
				
				var chkconfstatus=confirm(" Are you sure , you want to change the status ? ");
				
				var statuschange_data=jQuery(this).data('statuschange');
				//alert("statuschange_data==>"+statuschange_data);
				var countryid_data=jQuery(this).data('countryid');
				
				if (chkconfstatus==true)
				{
				
								var snddata = {_token:"<?php echo csrf_token(); ?>",statuschange: statuschange_data,countryid:countryid_data};
												  
								//alert(JSON.stringify(snddata));
										  
								jQuery.ajax({
												type: "POST",
												data:snddata,
												url: "<?php echo url(ADMINSEPARATOR.'/countrystatus');?>",
												dataType:"json",
												success: function(data)
												{
													
													//var tt=JSON.stringify(data);
													//alert(tt);
													
													var flagdata=data.flag;
													var iddata=data.iddata;
													var ancid="stat_"+iddata;
													
													
													
													
													if ( (flagdata==1) && (statuschange_data==1) )
													{
																
																jQuery("#"+ancid).removeClass("fa-lock");
																jQuery("#"+ancid).addClass("fa-unlock");
																jQuery("#"+ancid).data('statuschange','0');
													}
													else if ((flagdata==1) && (statuschange_data==0))
													{
															
																jQuery("#"+ancid).removeClass("fa-unlock");
																jQuery("#"+ancid).addClass("fa-lock");																
																jQuery("#"+ancid).data('statuschange','1');															
																
													}
													
													
													
												}
									   });
				}
				
				
				
				});
					
					
					jQuery("#srchbutton").click(function(){
					
					var srch1data=jQuery("#srch1").val();
					if (srch1data=='')
					{
								jQuery("#sort1").val('');
								jQuery("#sorttype1").val('');
								
								window.location.href="<?php echo url(ADMINSEPARATOR.'/country');?>";
					}
					else
					{
								jQuery("#countrylistfrmid").submit();
					}
					
					
					
					
					});
							
								
								});			
								
								
								
				</script>
    
@endsection