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
Issue with Booker List					
</div>
<div class="panel-body">
<div class="row">
<div class="col-md-4 col-sm-4">

<?php echo Form::open(array('url' => ADMINSEPARATOR.'/admin_issue_with_booker', 'method' => 'get','id'=>'countrylistfrmid','class'=>"form-horizontal form-border no-margin" ));?>
<div class="input-group">
<?php

$srch1='';$sort1='';$sorttype1='ASC';
$default_srt_class1="fa fa-sort fa-sm";
$default_srt_class2="fa fa-sort fa-sm";
$default_srt_class3="fa fa-sort fa-sm";
$default_srt_class4="fa fa-sort fa-sm";

if( !empty($useinPagiAr) && array_key_exists('srch1',$useinPagiAr))
{
		$srch1=$useinPagiAr['srch1'];
}

if( !empty($useinPagiAr) && array_key_exists('sort1',$useinPagiAr))
{
		$sort1=$useinPagiAr['sort1'];
}

if( !empty($useinPagiAr) && array_key_exists('sorttype1',$useinPagiAr))
{
		$sorttype1=$useinPagiAr['sorttype1']; // original sort type  ASC or DESC
		
    if($sort1 == 'gig_name'){    
		if(!empty($sorttype1) && ($sorttype1=="ASC") )
		{
				$default_srt_class1="fa fa-sort-desc fa-sm";
		}
		elseif(!empty($sorttype1) && ($sorttype1=="DESC") )
		{
			   $default_srt_class1="fa fa-sort-asc fa-sm";	
		}
    }
    else if($sort1 == 'bookernickname'){
        if(!empty($sorttype1) && ($sorttype1=="ASC") )
        {
                $default_srt_class2="fa fa-sort-desc fa-sm";
        }
        elseif(!empty($sorttype1) && ($sorttype1=="DESC") )
        {
                $default_srt_class2="fa fa-sort-asc fa-sm";	
        }
    }
    else if($sort1 == 'artistnickname'){
        if(!empty($sorttype1) && ($sorttype1=="ASC") )
        {
                $default_srt_class3="fa fa-sort-desc fa-sm";
        }
        elseif(!empty($sorttype1) && ($sorttype1=="DESC") )
        {
                $default_srt_class3="fa fa-sort-asc fa-sm";	
        }
    }
    else if($sort1 == 'resolved'){
        if(!empty($sorttype1) && ($sorttype1=="ASC") )
        {
                $default_srt_class4="fa fa-sort-desc fa-sm";
        }
        elseif(!empty($sorttype1) && ($sorttype1=="DESC") )
        {  
               $default_srt_class4="fa fa-sort-asc fa-sm";	
        }
    }
		
}

?>

<?php echo Form::text("srch1", $value=$srch1, $attributes = array( "id"=>"srch1","class"=>" form-control input-sm ","placeholder"=>"Search by Gig Name or Booker Nickname or Artist Nickname")); ?>

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
<th data-sortname="gig_name" data-sorttype="<?php echo $sorttype1; ?>" class="sorttrackclass" >Gig name<i  class=" <?php echo $default_srt_class1; ?>"></i></th>
<th>Dispute opening date</th>
<th data-sortname="bookernickname" data-sorttype="<?php echo $sorttype1; ?>" class="sorttrackclass">Booker Nickname<i  class=" <?php echo $default_srt_class2; ?>"></i></th>
<th data-sortname="artistnickname" data-sorttype="<?php echo $sorttype1; ?>" class="sorttrackclass">Artist Nickname<i  class=" <?php echo $default_srt_class3; ?>"></i></th>
<th data-sortname="resolved" data-sorttype="<?php echo $sorttype1; ?>" class="sorttrackclass">Dispute resolved status<i  class=" <?php echo $default_srt_class4; ?>"></i></th>
<th>Action</th>
</tr>
</thead>
<tbody>
<?php

if(!empty($pagi_country) && ( $pagi_country->count()>0 ) )
{
foreach($pagi_country as $countries_obj)

{
	$id=$countries_obj->id;
	//print_r($countries_obj);die();
?>

<tr>							
<td><?php echo stripslashes($countries_obj->gig_name); ?></td>
<td><?php
$date=$countries_obj->dispute_opening_date;
echo date('d M Y', strtotime($date));
?>
</td>
<td><?php echo stripslashes($countries_obj->booker_nickname); ?></td>
<td><?php echo stripslashes($countries_obj->nickname); ?></td>
<td>
    <?php
        if(stripslashes($countries_obj->dispute_resolved_status) == '1'){
            echo "Yes";
        }else if(stripslashes($countries_obj->dispute_resolved_status) == '0'){
            echo "No";
        }
    ?>
</td>
<td><a href="<?php echo  url(ADMINSEPARATOR.'/view_booker/'.$id);?>"><i class="fa fa-eye" title="View Details" aria-hidden="true"></i></a></td>
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
		
		$('#chk-all').click(function()	{
		if($(this).is(':checked'))	{
		$('#responsiveTable').find('.chk-row').each(function()	{
		$(this).prop('checked', true);
		$(this).parent().parent().parent().addClass('selected');
		});
		}
		else	{
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
		

		
		jQuery("#clearsearch").click(function(){						
		window.location.href="<?php echo url(ADMINSEPARATOR.'/admin_issue_with_booker');?>";								
		});
		jQuery("#srchbutton").click(function(){
		
		var srch1data=jQuery("#srch1").val();
		if (srch1data=='')
		{
		jQuery("#sort1").val('');
		jQuery("#sorttype1").val('');
		
		window.location.href="<?php echo url(ADMINSEPARATOR.'/admin_issue_with_booker');?>";
		}
		else
		{
		jQuery("#countrylistfrmid").submit();
		}
		
		
		
		
		});
		
		
		});			
		
		
		
		</script>

@endsection