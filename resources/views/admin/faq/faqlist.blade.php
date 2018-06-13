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
						FAQ List
						<span class="pull-right"><a type="button" class="btn btn-xs btn-success" href="<?php echo  url(ADMINSEPARATOR.'/faqadd'); ?>" >ADD</a></span>
					</div>
					<div class="panel-body">
						<div class="row">
							<div class="col-md-4 col-sm-4">
								 <?php echo Form::open(array('url' => ADMINSEPARATOR.'/faq', 'method' => 'get','id'=>'languagelistfrmid','class'=>"form-horizontal form-border no-margin" ));?>
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
									<?php echo Form::text("srch1", $value=$srch1, $attributes = array( "id"=>"srch1","class"=>" form-control input-sm ","placeholder"=>"Search by Faq title")); ?>
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
								<th data-sortname="title" data-sorttype="<?php echo $sorttype1; ?>" class="sorttrackclass" width="30%">Questions <i  class=" <?php echo $default_srt_class1; ?>"></i></th>
								<th >Answers</th>
								<th width="10%">Action</th>
								<th width="10%">Order numbering</th>
								<th class="col-md-1">

									<label class="label-checkbox">
										<input type="checkbox" id="chk-all">
										<span class="custom-checkbox"></span>
										<a type="button" class="btn btn-xs btn-success" id="deleteBtn" href="javascript:void(0)">Delete </a>
									</label>
								</th>
							</tr>
						</thead>
						<tbody>
							<?php
							if(!empty($pagi_faq) && ( $pagi_faq->count()>0 ) )
							{
								foreach($pagi_faq as $faq_obj)
								{
									$publish=$faq_obj->publish;
									$status_change_to=($publish==1)?0:1;
									$status_icon_class=($publish==1)?"fa fa-unlock fa-lg":"fa fa-lock fa-lg";
							?>
							<tr>
								<td>
								<?php
								$title_faq = $faq_obj->title;
								  $faq_tile_len = strlen($title_faq); //******faq title length 
								//echo stripslashes($faq_obj->title);
								if($faq_tile_len > 25)
                                    {
                                        $title_faq = substr($title_faq, 0,25).'..';
                                    }
									echo stripslashes($title_faq);
								
								
								
								?></td>
								<td><?php
								
								$faqdescription = html_entity_decode($faq_obj->description); //****** article description value 
                                $faq_desc_len = strlen($faqdescription); //******article title length 
                                if($faq_desc_len > 500)
                                {
                                        $faqdescription = substr($faqdescription, 0,499).'..';
                                }
								
								
								echo $faqdescription;
								
								
								
								
								?></td>
								<td>
									<a href="<?php echo  url(ADMINSEPARATOR.'/faqadd/'.$faq_obj->id); ?>"><i class="fa fa-edit fa-lg"></i></a>
									<a href="javascript:void(0);" ><i id="stat_<?php echo $faq_obj->id; ?>" href="javascript:void(0);" data-faqid="<?php echo $faq_obj->id; ?>" data-statuschange="<?php echo $status_change_to; ?>" class="statustrkclass <?php echo $status_icon_class; ?>"></i></a>
									<a class="delcusclass" data-delid="<?php echo $faq_obj->id; ?>" href="javascript:void(0);"><i class="fa fa-trash-o fa-lg"></i></a>
								</td>
									
								<td>
								<?php
									$faq_ordering = $faq_obj->order_id;
									$faq_mainid=$faq_obj->id;
									$hidorderid='hidorderid_'.$faq_mainid;
									
									echo Form::text("orderid", $value=$faq_ordering, $attributes = array("id"=>"orderid","data-lstorder"=>$faq_ordering,"data-fid"=>$faq_obj->id,"class"=>"orderidcls form-control input-sm parsley-validated "));
								?>
								<span  class="errorcustclass">{{ $errors->first('orderid') }}</span>
									<input type="hidden" class="hidorderid" id="{{$hidorderid}}" name="{{$hidorderid}}" value="{{$faq_ordering}}">
								</td>

									<td class="col-md-1">
									<label class="label-checkbox">
										<input type="checkbox" name="multidel" class="chk-row" data-id="<?php echo $faq_obj->id;?>">
										<span class="custom-checkbox"></span>
									</label>
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
						<?php echo $pagi_faq->appends($useinPagiAr)->render(); ?>
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
				var redurl="<?php echo url(ADMINSEPARATOR.'/faqdel');?>"+"/"+delid;
				
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
						url: "<?php echo url(ADMINSEPARATOR.'/faqstatus');?>",
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
							
							window.location.href="<?php echo url(ADMINSEPARATOR.'/faq');?>";
				}
				else
				{
							jQuery("#languagelistfrmid").submit();
				}
			});
			jQuery(".orderidcls").keypress(function(e){
			var regex = new RegExp(/^[0-9]*$/);
			if (this.value.length == 0 && e.which == 48){
			return false;
			
			}
			});
			jQuery(".orderidcls").blur(function(){	
				var datasave=jQuery(this).val();
				var dataid=jQuery(this).data("fid");
				var last_order = jQuery(this).data("lstorder");

				
				//var regex = new RegExp(/^\+?[0-9(),.-]+$/);
				var regex = new RegExp(/^[0-9]*$/);
				if(datasave.match(regex) && datasave!='' && datasave!='0') {
				
					var snddata = {_token:"<?php echo csrf_token(); ?>",datasave: datasave,dataid:dataid};
									  
					jQuery.ajax({
						type: "POST",
						data:snddata,
						url: "<?php echo url(ADMINSEPARATOR.'/faqordersave');?>",
						dataType:"json",
						success: function(data)
						{
							var flagdata=data.flag;
							var msg=data.iddata;
							if (flagdata == 1) {
								//alert(msg);
								toastr.remove(); // Immediately remove current toasts without using animation
								poptriggerfunc(msgtype = 'success', titledata = '', msgdata = msg, sd = 1000, hd = 2000, tmo = 2000, etmo = 5000, poscls = 'toast-bottom-right');
							}else if(flagdata == 0){
								//alert(msg);
								toastr.remove(); // Immediately remove current toasts without using animation
								poptriggerfunc(msgtype = 'error', titledata = '', msgdata = msg, sd = 1000, hd = 1500, tmo = 1000, etmo = 1000, poscls = 'toast-bottom-right');
							}
						}
					});
				}else{
					jQuery(this).val(last_order);
					//alert("Sorry! you have to insert only numeric value.")
					toastr.remove(); // Immediately remove current toasts without using animation
					poptriggerfunc(msgtype = 'error', titledata = '', msgdata = "Sorry! you have to insert only numeric value.", sd = 2000, hd = 1500, tmo = 1000, etmo = 1000, poscls = 'toast-bottom-right');
				}

			});
			
		jQuery(".orderidcls").keypress(function(e)
		{
		if (e.keyCode == '13') {
				var datasave=jQuery(this).val();
				var dataid=jQuery(this).data("fid");
				var last_order = jQuery(this).data("lstorder");

				
				//var regex = new RegExp(/^\+?[0-9(),.-]+$/);
				var regex = new RegExp(/^[0-9]*$/);
				if(datasave.match(regex) && datasave!='' && datasave!='0') {
				
					var snddata = {_token:"<?php echo csrf_token(); ?>",datasave: datasave,dataid:dataid};
									  
					jQuery.ajax({
						type: "POST",
						data:snddata,
						url: "<?php echo url(ADMINSEPARATOR.'/faqordersave');?>",
						dataType:"json",
						success: function(data)
						{
							var flagdata=data.flag;
							var changedata=data.changedata;
							var msg=data.iddata;
							if (flagdata == 1) {
								//alert(msg);
								toastr.remove(); // Immediately remove current toasts without using animation
								poptriggerfunc(msgtype = 'success', titledata = '', msgdata = msg, sd = 1000, hd = 2000, tmo = 2000, etmo = 5000, poscls = 'toast-bottom-right');
								jQuery('#hidorderid_'+dataid).val(changedata);
							}else if(flagdata == 0){
								//alert(msg);
								toastr.remove(); // Immediately remove current toasts without using animation
								poptriggerfunc(msgtype = 'error', titledata = '', msgdata = msg, sd = 1000, hd = 1500, tmo = 1000, etmo = 1000, poscls = 'toast-bottom-right');
							}
						}
					});
				}else{
						var changehid=jQuery('#hidorderid_'+dataid).val();
					jQuery(this).val(changehid);
					//jQuery(this).val(last_order);
					//alert("Sorry! you have to insert only numeric value.")
					toastr.remove(); // Immediately remove current toasts without using animation
					poptriggerfunc(msgtype = 'error', titledata = '', msgdata = "Sorry! you have to insert only numeric value.", sd = 2000, hd = 1500, tmo = 1000, etmo = 1000, poscls = 'toast-bottom-right');
				}
		}
		});
		});




	//**************  Multiple delete starts here ******************

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
													var redurl="<?php echo url(ADMINSEPARATOR.'/multiplefaqdelete');?>"+"/"+idval;
													var chkdel=confirm("Are you sure you want to delete ?");

													if (chkdel==true)
													{
														//alert(idval);
													window.location.href=redurl;
													}
												}else
												{
													alert('select a checkbox to delete');
												}

											});


	//**************  Multiple delete ends here ********************
								
	</script>
    
@endsection