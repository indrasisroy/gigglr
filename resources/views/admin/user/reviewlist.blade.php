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
						Review List
						
					</div>
						<div class="padding-md clearfix">
						<div class="col-md-8">
									
					  <?php
                                $rqst_segmn1=Request::segment(3);
                                ?>
					          	 <?php echo Form::open(array('url' => ADMINSEPARATOR.'/userreview/'.$rqst_segmn1.'', 'method' => 'get','id'=>'reviewlistsearch','class'=>"form-inline" ));?>
								 <div class="m-bottom-md">
								<?php
								$srch2='';$sorttype2='ASC';$sort2='';$srch1='';$sort1='';$sorttype1='ASC';
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
								if( !empty($useinPagiAr) && array_key_exists('srch2',$useinPagiAr))
								{
												$srch2=$useinPagiAr['srch2'];
								}
								if( !empty($useinPagiAr) && array_key_exists('sorttype2',$useinPagiAr))
								{
												$sorttype2=$useinPagiAr['sorttype2']; // original sort type  ASC or DESC
												
												if(!empty($sorttype2) && ($sorttype2=="ASC") )
												{
																$default_srt_class1="fa fa-sort-desc fa-sm";
												}
												elseif(!empty($sorttype2) && ($sorttype2=="DESC") )
												{
													  
													   $default_srt_class1="fa fa-sort-asc fa-sm";	
												}
												
								}
								
								if( !empty($useinPagiAr) && array_key_exists('sort2',$useinPagiAr))
								{
												$sort2=$useinPagiAr['sort2'];											
												
												
								}
								?>
							   <input type="hidden" name="reviewid" id="reviewid" value="<?php echo $rqst_segmn1;?>">
								<?php echo Form::text("srch1", $value=$srch1, $attributes = array( "id"=>"srch1","class"=>" form-control input-sm ","placeholder"=>"Search by Gig Unique Id")); ?>
								
								 <?php echo Form::hidden("sort1", $value=$sort1, $attributes = array( "id"=>"sort1","class"=>" form-control")); ?>
								<?php echo Form::hidden("sorttype1", $value=$sorttype1, $attributes = array( "id"=>"sorttype1","class"=>" form-control")); ?>   
								
								
							      <?php
                                                   $srch12 = array(''=>'Select Filter Type','1'=>'As a Booker','2'=>'As a Artist','3'=>'As a Group','4'=>' As a Venue');
                                                   $attrbar = array();
                                                   $attrbar['id'] = "srch2";
                                                   $attrbar['class'] = "form-control";
                                                   echo Form::select('srch2',$srch12,"$srch2",$attrbar );
                                ?>
								  <?php echo Form::hidden("sort2", $value=$sort2, $attributes = array( "id"=>"sort2","class"=>" form-control")); ?>
								<?php echo Form::hidden("sorttype2", $value=$sorttype2, $attributes = array( "id"=>"sorttype2","class"=>" form-control")); ?>    
							            	<button tabindex="-1" class="btn btn-sm btn-success" type="button" id="srchbuttonreview">Search</button>  
								            <button tabindex="-1" type="button" class="btn btn-sm btn-info" id="clearsearch">Clear Search</button>	
		
							    </div>
	
					<?php echo Form::close(); ?>	
							 <!--  </form>-->
						</div>	

					<table class="table table-striped" id="responsiveTable">
						<thead>
							<tr>
								<th>Gig Unique Id</th>
								<th >Role 1</th>
                                <th>Hospitality</th>
								<th>Environment</th>
                                <th>Readiness</th>
                                <th>Review</th>
								<th>Role 2</th>
								<th>Punctuality</th>
                                <th>Performance</th>
                                <th>Presentation</th>
                                <th>Review</th>
							
							</tr>
						</thead>
						<tbody>
						<?php
					//	echo "<pre>";
						//print_r($pagi_user);
						
						if(!empty($pagi_user) && ( $pagi_user->count()>0 ) )
						{
						
							foreach($pagi_user as $users_obj)
							{
                                $booker_id=$users_obj->booker_id;
							    $artistid=$users_obj->artist_id ;
	
								
                                $artistgroupvenue_id=$users_obj->artistgroupvenue_id;
                                $userid=Request::segment(3);
                               // echo $userid;
								$status=$users_obj->status;
								$status_change_to=($status==1)?0:1;
								$status_icon_class=($status==1)? "fa fa-unlock fa-lg":"fa fa-lock fa-lg";
						?>
						
							<tr>
							
								<td>{{$users_obj->giguniqueid}}</td>
								<td>
                                    
                                    
									<?php
										if($userid == $users_obj->booker_id && $users_obj->type_flag='1')
                                        { 
                                            echo "Review received as booker";
											
                                        }
										  elseif($userid==$users_obj->booker_id && $users_obj->type_flag='2')
                                        {
                                            echo "Review received as group";
                                        }
                                       elseif($userid==$users_obj->booker_id && $users_obj->type_flag='3')
                                        {
                                            echo "Review received as venue";
                                        }
                                       elseif($userid !=$users_obj->booker_id && $users_obj->type_flag='1')
                                        {
                                            echo "Review given to booker";
                                        }
                                       elseif($userid != $users_obj->booker_id && $users_obj->type_flag='2')
                                        {
                                            echo "Review given to group";
                                        }
                                      elseif($userid != $users_obj->booker_id && $users_obj->type_flag='3')
                                        {
                                            echo "Review given to venue";
                                        }
									?>
								</td>
                                <td>
                                    <?php
										if($users_obj->bkr_hospitality !=''){
											echo $users_obj->bkr_hospitality;
										}
										else{
											echo "No info available";
										}
									?>
                                </td>
                                 <td>
                                    <?php
										if($users_obj->bkr_environment !=''){
											echo $users_obj->bkr_environment;
										}
										else{
											echo "No info available";
										}
									?>
                                </td>
                                 <td>
                                    <?php
										if($users_obj->bkr_readiness !=''){
											echo $users_obj->bkr_readiness;
										}
										else{
											echo "No info available";
										}
									?>
                                </td>
                                <td>
                                    <?php
										if($users_obj->bkr_review_data !=''){
											echo strip_tags($users_obj->bkr_review_data);
										}
										else{
											echo "No info available";
										}
									?>
                                </td>
                                
								<td>
				
									<?php
									if($users_obj->roll2 !=''){
								      echo $users_obj->roll2;
									  }
									?>
								</td>
                                <td>
                                    <?php
										if($users_obj->punctuality !=''){
											echo $users_obj->punctuality;
										}
										else{
											echo "No info available";
										}
									?>
                                </td>
                                 <td>
                                    <?php
										if($users_obj->performance !=''){
											echo $users_obj->performance;
										}
										else{
											echo "No info available";
										}
									?>
                                </td>
                                 <td>
                                    <?php
										if($users_obj->presentation !=''){
											echo $users_obj->presentation;
										}
										else{
											echo "No info available";
										}
									?>
                                </td>
                                <td>
                                    <?php
										if($users_obj->agv_review_data !=''){
											echo strip_tags($users_obj->agv_review_data);
										}
										else{
											echo "No info available";
										}
									?>
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
	
	    jQuery("#clearsearch").click(function(){
		             var reviewid=jQuery("#reviewid").val();
					window.location.href="<?php echo url(ADMINSEPARATOR.'/userreview/');?>"+'/'+reviewid;								
					});
	
	
		jQuery("#srchbuttonreview").click(function(){	
             
			var srch1data=jQuery("#srch1").val();
			var searchdata = jQuery("#srch2").val();
           // alert(srch1data);
            var reviewid=jQuery("#reviewid").val();
            var url="<?php echo url(ADMINSEPARATOR.'/userreview/');?>";
            var newurl=url+'/'+reviewid;
			if (srch1data=='' && searchdata=='' )
			{
						jQuery("#sort1").val('');
						jQuery("#sorttype1").val('');
						jQuery("#sort2").val('');
						jQuery("#sorttype2").val('');
						//jQuery("#srch2").val('');
						window.location.href=newurl;
			}
			
			
			else
			{
						jQuery("#reviewlistsearch").submit();
			}
					
		});
		
	
 jQuery(".statustrkclass").click(function(){  //**********Update Status Change Starts here

                var chkconfstatus=confirm(" Are you sure , you want to change the status ? ");
                
                var statuschange_data=jQuery(this).data('statuschange');
                //alert("statuschange_data==>"+statuschange_data);
                var articleid_data=jQuery(this).data('articlestsid');
                
                if (chkconfstatus==true)
                {
                
                                var snddata = {_token:"<?php echo csrf_token(); ?>",statuschange: statuschange_data,articleid:articleid_data};
                                                  
                                //alert(JSON.stringify(snddata));
                                          
                                jQuery.ajax({
                                                type: "POST",
                                                data:snddata,
                                                url: "<?php echo url(ADMINSEPARATOR.'/reviewchangestatus');?>",
                                                dataType:"json",
                                                success: function(data)
                                                {
                                                    
                                                    // var tt=JSON.stringify(data);
                                                    // alert(tt);
                                                    
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


</script>
<!-- <script type="text/javascript" src="{{ ADMINCSSPATH}}/otherfiles/progjs/userlist.js"></script> -->
	
@endsection