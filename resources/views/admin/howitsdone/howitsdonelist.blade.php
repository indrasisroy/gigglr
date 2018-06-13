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
						How its done List
						<!--<span class="pull-right"><a type="button" class="btn btn-xs btn-success" href="<?php echo  url(ADMINSEPARATOR.'/howitsdoneadd'); ?>" >ADD</a></span>-->
					</div>
					<div class="panel-body">
						<div class="row">
<!--							<div class="col-md-4 col-sm-4">
								 <?php echo Form::open(array('url' => ADMINSEPARATOR.'/howitsdone', 'method' => 'get','id'=>'languagelistfrmid','class'=>"form-horizontal form-border no-margin" ));?>
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
									<?php echo Form::text("srch1", $value=$srch1, $attributes = array( "id"=>"srch1","class"=>" form-control input-sm ","placeholder"=>"Search by title")); ?>
									<?php echo Form::hidden("sort1", $value=$sort1, $attributes = array( "id"=>"sort1","class"=>" form-control input-sm ")); ?>
									<?php echo Form::hidden("sorttype1", $value=$sorttype1, $attributes = array( "id"=>"sorttype1","class"=>" form-control input-sm ")); ?>    
									<div class="input-group-btn">
							            <button tabindex="-1" style="margin-right:10px;" class="btn btn-sm btn-success" type="button" id="srchbutton">Search</button>
							             <button tabindex="-1" type="button" class="btn btn-sm btn-info" id="clearsearch">Clear Search</button>
									</div>
							    </div>
								<?php echo  Form::close(); ?>
							</div>
-->						</div>
					</div>
					<table class="table table-striped" id="responsiveTable">
						<thead>
							<tr>
								<th data-sortname="title" data-sorttype="<?php echo $sorttype1; ?>" class="sorttrackclass" width="30%">Title <i  class=" <?php echo $default_srt_class1; ?>"></i></th>
								
								<th width="20%">Action</th>
							</tr>
						</thead>
						<tbody>
							<?php
							if(!empty($pagi_howitsdone) && ( $pagi_howitsdone->count()>0 ) )
							{
								foreach($pagi_howitsdone as $howitsdone_obj)
								{
	
									$status=$howitsdone_obj->status;
									$status_change_to=($status==1)?0:1;
									$status_icon_class=($status==1)?"fa fa-unlock fa-lg":"fa fa-lock fa-lg";
								
							?>
							<tr>
								<td>
								<?php
								$title_howitsdone = $howitsdone_obj->title;
								  $howitsdone_tile_len = strlen($title_howitsdone); //******faq title length 
								
								if($howitsdone_tile_len > 25)
                                    {
                                        $title_howitsdone = substr($title_howitsdone, 0,25).'..';
                                    }
									echo stripslashes($title_howitsdone);
								
								
								
								?></td>
								<!--<td>-->
								<?php
								
								$howitsdonedescription = html_entity_decode($howitsdone_obj->description); //****** article description value 
                                $howitsdone_desc_len = strlen($howitsdonedescription); //******article title length 
                                if($howitsdone_desc_len > 500)
                                {
                                        $howitsdonedescription = substr($howitsdonedescription, 0,499).'..';
                                }
								
								
								//echo $howitsdonedescription;
								
								
								
								
								?><!--</td>-->
								<td>
									<a href="<?php echo  url(ADMINSEPARATOR.'/howitsdoneadd/'.$howitsdone_obj->id); ?>"><i class="fa fa-edit fa-lg"></i></a>
									<!--<a href="javascript:void(0);" ><i id="stat_<?php echo $howitsdone_obj->id; ?>" href="javascript:void(0);" data-faqid="<?php echo $howitsdone_obj->id; ?>" data-statuschange="<?php echo $status_change_to; ?>" class="statustrkclass <?php echo $status_icon_class; ?>"></i></a>
									<a class="delcusclass" data-delid="<?php echo $howitsdone_obj->id; ?>" href="javascript:void(0);"><i class="fa fa-trash-o fa-lg"></i></a>-->
								</td>
							</tr>
							<?php
								}	
							}
							else
							{
							?>
							<tr><td colspan="3" >No data found.</td></tr>	
							<?php
							}
							?>	
						</tbody>
					</table>
					<div class="panel-footer clearfix">
						<?php echo $pagi_howitsdone->appends($useinPagiAr)->render(); ?>
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
				jQuery('#languagelistfrmid').submit();
			});
			jQuery("#clearsearch").click(function(){						
					window.location.href="<?php echo url(ADMINSEPARATOR.'/howitsdone');?>";								
					});
			jQuery(".delcusclass").click(function(){
				var delid = $(this).data('delid');
				var redurl="<?php echo url(ADMINSEPARATOR.'/howitsdonedel');?>"+"/"+delid;
				
				var chkdel=confirm("Are you sure you want to delete ?");
				
				if (chkdel==true)
				{
						window.location.href=redurl;
				}
			});
			
			jQuery(".statustrkclass").click(function(){
			
				var chkconfstatus=confirm(" Are you sure , you want to change the status ? ");
				
				var statuschange_data=jQuery(this).data('statuschange');
				
				var faqid_data=jQuery(this).data('faqid');
				
				if (chkconfstatus==true)
				{
			
					var snddata = {_token:"<?php echo csrf_token(); ?>",statuschange: statuschange_data,faqid:faqid_data};
									  
					jQuery.ajax({
						type: "POST",
						data:snddata,
						url: "<?php echo url(ADMINSEPARATOR.'/howitsdonestatus');?>",
						dataType:"json",
						success: function(data)
						{
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
							
							window.location.href="<?php echo url(ADMINSEPARATOR.'/howitsdone');?>";
				}
				else
				{
							jQuery("#languagelistfrmid").submit();
				}
			});
						
		});
								
	</script>
    
@endsection