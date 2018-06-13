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
						Support by page List
						<span class="pull-right"><a type="button" class="btn btn-xs btn-success" href="<?php echo  url(ADMINSEPARATOR.'/supportbypageadd'); ?>" >ADD</a></span>
					</div>
					<div class="panel-body">
						<div class="row">
							<div class="col-md-4 col-sm-4">
								 <?php echo Form::open(array('url' => ADMINSEPARATOR.'/supportbypage', 'method' => 'get','id'=>'languagelistfrmid','class'=>"form-horizontal form-border no-margin" ));?>
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
									</div> <!-- /input-group-btn -->
							    </div>
								<?php echo  Form::close(); ?>
							</div><!-- /.col -->
						</div><!-- /.row -->
					</div>
					<table class="table table-striped" id="responsiveTable">
						<thead>
							<tr>
								<th data-sortname="title" data-sorttype="<?php echo $sorttype1; ?>" class="sorttrackclass" width="30%">Title <i  class=" <?php echo $default_srt_class1; ?>"></i></th>
								<th width="50%">Description</th>
								<th width="10%">Action</th>
									<th width="10%">Order numbering</th>
							</tr>
						</thead>
						<tbody>
							<?php
							if(!empty($pagi_supportbypage) && ( $pagi_supportbypage->count()>0 ) )
							{
								foreach($pagi_supportbypage as $supportbypage_obj)
								{
	
									$status=$supportbypage_obj->status;
									$status_change_to=($status==1)?0:1;
									$status_icon_class=($status==1)?"fa fa-unlock fa-lg":"fa fa-lock fa-lg";
								
							?>
							<tr>
								<td>
								<?php
								$title_supportbypage = $supportbypage_obj->title;
								  $howitsdone_tile_len = strlen($title_supportbypage); //******faq title length 
								
								if($howitsdone_tile_len > 25)
                                    {
                                        $title_supportbypage = substr($title_supportbypage, 0,25).'..';
                                    }
									echo stripslashes($title_supportbypage);
								
								
								
								?></td>
								<td>
								<?php
								
								$supportbypagedescription = html_entity_decode($supportbypage_obj->description); //****** article description value 
                                $supportbypage_len = strlen($supportbypagedescription); //******article title length 
                                if($supportbypage_len > 500)
                                {
                                        $supportbypagedescription = substr($supportbypagedescription, 0,499).'..';
                                }
								
								
								echo $supportbypagedescription;
								
								
								
								
								?></td>
								<td>
									<a href="<?php echo  url(ADMINSEPARATOR.'/supportbypageadd/'.$supportbypage_obj->id); ?>"><i class="fa fa-edit fa-lg"></i></a>
									<a href="javascript:void(0);" ><i id="stat_<?php echo $supportbypage_obj->id; ?>" href="javascript:void(0);" data-faqid="<?php echo $supportbypage_obj->id; ?>" data-statuschange="<?php echo $status_change_to; ?>" class="statustrkclass <?php echo $status_icon_class; ?>"></i></a>
									<a class="delcusclass" data-delid="<?php echo $supportbypage_obj->id; ?>" href="javascript:void(0);"><i class="fa fa-trash-o fa-lg"></i></a>
								</td>
									
								<td>
								<?php
									$supportbypage_ordering = $supportbypage_obj->order_id;
									$supportbypage_mainid=$supportbypage_obj->id;
									$inid='orderid_'.$supportbypage_mainid;
									$hidorderid='hidorderid_'.$supportbypage_mainid;
									echo Form::text("orderid", $value=$supportbypage_ordering, $attributes = array("id"=>$inid,"data-lstorder"=>$supportbypage_ordering,"data-sid"=>$supportbypage_mainid,"class"=>"orderidcls form-control input-sm parsley-validated"));
								?>
								<span  class="errorcustclass">{{ $errors->first('orderid') }}</span>
									<input type="hidden" class="hidorderid" id="{{$hidorderid}}" name="{{$hidorderid}}" value="{{$supportbypage_ordering}}">
									<input type="hidden" id="bymainid" name="bymainid" value="{{$supportbypage_mainid}}">
									
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
						<?php echo $pagi_supportbypage->appends($useinPagiAr)->render(); ?>
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
			
			jQuery(".delcusclass").click(function(){
				var delid = $(this).data('delid');
				var redurl="<?php echo url(ADMINSEPARATOR.'/supportbypagedel');?>"+"/"+delid;
				
				var chkdel=confirm("Are you sure you want to delete ?");
				
				if (chkdel==true)
				{
						window.location.href=redurl;
				}
			});
			jQuery("#clearsearch").click(function(){						
					window.location.href="<?php echo url(ADMINSEPARATOR.'/supportbypage');?>";								
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
						url: "<?php echo url(ADMINSEPARATOR.'/supportbypagestatus');?>",
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
							
							window.location.href="<?php echo url(ADMINSEPARATOR.'/supportbypage');?>";
				}
				else
				{
							jQuery("#languagelistfrmid").submit();
				}
			});
			
			
			//jQuery(".orderid").blur(function(event){
			//
			//	//hidorderid=$('#hidorderid').val();
			//	
			//	//$(this).val($(this).val().replace(/[^\d].+/, hidorderid));
			//	
			//	//if ((event.which < 48 || event.which > 57)) {
			//	//	event.preventDefault();
			//		
			//		var orderid=$('#orderid').val();
			//		var bymainid=$('#bymainid').val();
			//		var hidorderid=$('#hidorderid').val();
			//
			//		var snddata = {_token:"<?php echo csrf_token(); ?>",orderid: orderid,bymainid:bymainid};
			//						  
			//		jQuery.ajax({
			//			type: "POST",
			//			data:snddata,
			//			url: "<?php echo url(ADMINSEPARATOR.'/supportbypageordering');?>",
			//			dataType:"json",
			//			success: function(data)
			//			{
			//				console.log(data);
			//				
			//				var flagdata=data.flag;
			//				var iddata=data.iddata;
			//				console.log("resflagdata"+flagdata);
			//				console.log("residdata"+iddata);
			//				if(flagdata==1)
			//				{
			//				console.log("OK");
			//					$('#orderid').val(iddata);
			//					$('#hidorderid').val(iddata);
			//					
			//					toastr.remove(); // Immediately remove current toasts without using animation
			//					poptriggerfunc(msgtype = 'success', titledata = '', msgdata = 'Ordering data saved successfully', sd = 1000, hd = 1500, tmo = 2000, etmo = 3000, poscls = 'toast-bottom-right');
			//				}
			//				else{
			//				console.log("NOT OK");
			//					$('#orderid').val(hidorderid);
			//					toastr.remove(); // Immediately remove current toasts without using animation
			//					poptriggerfunc(msgtype = 'error', titledata = '', msgdata = 'Some error occured', sd = 1000, hd = 1500, tmo = 2000, etmo = 3000, poscls = 'toast-bottom-right');
			//				}
			//			}
			//		});
			//	//}
			//});
			
			
			jQuery(document).on('blur', ".orderidcls" , function(){
				var datasave=jQuery(this).val();
				var dataid=jQuery(this).data("sid");
				var last_order = jQuery(this).data("lstorder");
				
				orderchangemain(datasave,dataid,last_order);
			});
			
			jQuery(".orderidcls").keypress(function (e) {
				var key = e.which;
				if(key == 13)  // the enter key code
				{
					var datasave=jQuery(this).val();
					var dataid=jQuery(this).data("sid");
					var last_order = jQuery(this).data("lstorder");
					
					orderchangemain(datasave,dataid,last_order);
				}
			});
						
		});
		
		
		
		function orderchangemain(datasave,dataid,last_order) {
                
				var regex = new RegExp(/^[0-9]*$/);
				if(datasave.match(regex) && datasave!='' && datasave!='0') {
					var snddata = {_token:"<?php echo csrf_token(); ?>",datasave: datasave,dataid:dataid};				  
					jQuery.ajax({
						type: "POST",
						data:snddata,
						url: "<?php echo url(ADMINSEPARATOR.'/supportbypageordering');?>",
						dataType:"json",
						success: function(data)
						{
							var flagdata=data.flag;
							var changedata=data.changedata;
							var msg=data.iddata;
							if (flagdata == 1) {
								toastr.remove();
								poptriggerfunc(msgtype = 'success', titledata = '', msgdata = msg, sd = 1000, hd = 2000, tmo = 2000, etmo = 5000, poscls = 'toast-bottom-right');
								jQuery('#hidorderid_'+dataid).val(changedata);
							}else if(flagdata == 0){
								toastr.remove();
								poptriggerfunc(msgtype = 'error', titledata = '', msgdata = msg, sd = 1000, hd = 1500, tmo = 1000, etmo = 1000, poscls = 'toast-bottom-right');
							}
						}
					});
				}else{
					var changehid=jQuery('#hidorderid_'+dataid).val();
					jQuery('#orderid_'+dataid).val(changehid);
					toastr.remove();
					poptriggerfunc(msgtype = 'error', titledata = '', msgdata = "Error! Numeric input only.", sd = 2000, hd = 1500, tmo = 1000, etmo = 1000, poscls = 'toast-bottom-right');
				}
			//});
		}
								
	</script>
    
@endsection