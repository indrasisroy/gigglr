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
						Association List
						<span class="pull-right"><a type="button" class="btn btn-xs btn-success" href="<?php echo  url(ADMINSEPARATOR.'/associationadd'); ?>" >ADD</a></span>
					</div>
						
					<div class="panel-body">
						<div class="row">
							<div class="col-md-4 col-sm-4">
							
								<?php echo Form::open(array('url' => ADMINSEPARATOR.'/association', 'method' => 'get','id'=>'associationlistfrmid','class'=>"form-horizontal form-border no-margin" ));?>
								
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
										
										<?php echo Form::text("srch1", $value=$srch1, $attributes = array( "id"=>"srch1","class"=>" form-control input-sm ","placeholder"=>"Search by association")); ?>
										
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
								<th data-sortname="genre_name" data-sorttype="<?php echo $sorttype1; ?>" class="sorttrackclass" >Genre <i  class=" <?php echo $default_srt_class1; ?>"></i></th>
								<th>Association Name</th>
								<th>Category</th>
								<th>User type</th>	
								<th>Action</th>
							</tr>
						</thead>
							
						<tbody>
							<?php
							if(!empty($pagi_association) && ( $pagi_association->count()>0 ) )
							{
								foreach($pagi_association as $association_obj)
								{	
							?>
							<tr>
								<td><?php echo stripslashes($association_obj->genre_name); ?></td>
								<td><?php echo ucwords(stripslashes($association_obj->association_names)); ?></td>
								<td><?php echo stripslashes($association_obj->category_name); ?></td>
								<td><?php echo ucwords(stripslashes($association_obj->typename)); ?></td>
								<td>
									<a href="<?php echo  url(ADMINSEPARATOR.'/associationadd/'.$association_obj->genre_id); ?>"><i class="fa fa-edit fa-lg"></i></a>
									<a class="delcusclass" data-delid="<?php echo $association_obj->genre_id; ?>" href="javascript:void(0);"><i class="fa fa-trash-o fa-lg"></i></a>
								</td>
							</tr>
							<?php
								}
							}
							else
							{
							?>
							<tr><td colspan="5" >No data found.</td></tr>	
							<?php
							}
							?>
						</tbody>
					</table>
					<div class="panel-footer clearfix">
						<?php echo $pagi_association->appends($useinPagiAr)->render(); ?>
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
				jQuery("#sort1").val(sortname);
				jQuery("#sorttype1").val(setsorttype);
				jQuery('#associationlistfrmid').submit();
									
			});
				
			jQuery(".delcusclass").click(function(){
				
				var delid = $(this).data('delid');
				var redurl="<?php echo url(ADMINSEPARATOR.'/associationdel');?>"+"/"+delid;
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
					window.location.href="<?php echo url(ADMINSEPARATOR.'/association');?>";
				}
				else
				{
					jQuery("#associationlistfrmid").submit();
				}
				
			});
												
		});			
					
	</script>
    
@endsection