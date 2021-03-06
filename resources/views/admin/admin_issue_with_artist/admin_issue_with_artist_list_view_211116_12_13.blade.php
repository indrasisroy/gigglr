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
<?php

if(!empty($pagi_country))
{
foreach($pagi_country as $countries_obj)
{
	$id=$countries_obj->id;
	$complained_by=$countries_obj->dispute_opener_id;
	$gig_id=$countries_obj->gig_id;
	$gig_unique_id=$countries_obj->gig_unique_id;
	$dispute_type=$countries_obj->dispute_type;
	$gig_name=$countries_obj->gig_name;
	$description=$countries_obj->issue_description;
	$leave_early=$countries_obj->leave_early;
	$arrival_time=$countries_obj->arrival;
	$receive_rider=$countries_obj->receive_rider;
	$technical_issue=$countries_obj->technical_issue;
	$able_to_complete=$countries_obj->able_to_complete;
	$required_specifications_availability=$countries_obj->required_specifications_availability;
}
}
?>
@extends('layouts.admin.adminmaster',['successmsg' => $successmsg,'errormsg'=>$errormsg])
@section('content')
<div class="padding-md">
<div class="row">
<div class="col-md-8 col-md-offset-2">
<div class="panel panel-default">
<div class="panel-heading">
Issue with artist details
</div>
<div class="panel-body">
<?php
echo Form::open(array('url' => '','method' =>'post','id'=>'formdisputeid','class'=>"form-horizontal form-border no-margin" ));?>
<div class="form-group row">
<label class="control-label col-sm-6">Gig Name</label>
<div class="col-sm-6">   
{{$gig_name}}
<span  class="errorcustclass"></span>									
</div>
</div>
<div class="form-group row">
<label class="control-label col-sm-6">Did the artist arrive on time?</label>
<div class="col-sm-6">

<?php
if($arrival=1){
	echo"Yes";
}else{
	echo"No";
}
?>
<span  class="errorcustclass"></span>
</div>
</div>
<div class="form-group row">
<label class="control-label col-sm-6">What time did you arrive?</label>
<div class="col-sm-6">   
<?php
$date=$countries_obj->arrival_time;
echo date('h:i A', strtotime($date));
?> 
<span  class="errorcustclass"></span>									
</div>
</div>
<div class="form-group row">
<label class="control-label col-sm-6">Were the artists required specifications available?</label>
<div class="col-sm-6" >
<?php
if($required_specifications_availability=1){
	echo"Yes";
}else{
	echo"No";
}
?>
<span  class="errorcustclass"></span>										
</div>
</div>
<div class="form-group row">
<label class="control-label col-sm-6">Were the artists able to complete the performance?</label>
<div class="col-sm-6">
<?php
if($able_to_complete=1){
	echo"Yes";
}else{
	echo"No";
}
?>
<span  class="errorcustclass"></span>											
</div>
</div>
<div class="form-group row">
<label class="control-label col-sm-6">Were there any technical issues during the performance?</label>
<div class="col-sm-6">
<?php
if($technical_issue=1){
	echo"Yes";
}else{
	echo"No";
}
?>
<span  class="errorcustclass"></span>									
</div>
</div>
<div class="form-group row">
<label class="control-label col-sm-6">Did the artist receive their rider?</label>
<div class="col-sm-6">
<?php
if($receive_rider=1){
	echo"Yes";
}else{
	echo"No";
}
?>
<span  class="errorcustclass"></span>									
</div>
</div>
<div class="form-group row">
<label class="control-label col-sm-6">Did the artist leave early?</label>
<div class="col-sm-6">
<?php
if($leave_early=1){
	echo"Yes";
}else{
	echo"No";
}
?>
<span  class="errorcustclass"></span>									
</div>
</div>
<div class="form-group row">
<label class="control-label col-sm-6">What time did the artist(s) leave?</label>
<div class="col-sm-6">
	<?php
$date=$countries_obj->leaving_time;
echo date('h:i A', strtotime($date));
?> 
<span  class="errorcustclass"></span>									
</div>
</div>
<div class="form-group row">
<label class="control-label col-sm-6">Booker nickname</label>
<div class="col-sm-6">
<?php echo stripslashes($first_sql[0]->nickname); ?>
<span  class="errorcustclass"></span>
</div>
</div>
<div class="form-group row">
<label class="control-label col-sm-6">Artist nickname</label>
<div class="col-sm-6">
<?php echo stripslashes($artist_details[0]->nickname); ?>
<span  class="errorcustclass"></span>
</div>
</div>
<div class="form-group row">
<label class="control-label col-sm-6">Compalined by(Booker)</label>
<div class="col-sm-6">
<?php echo stripslashes($first_sql[0]->email); ?>
<span  class="errorcustclass"></span>
</div>
</div>
<div class="form-group row">
<label class="control-label col-sm-6">Compalin against(Artist)</label>
<div class="col-sm-6">
<?php echo stripslashes($artist_details[0]->email); ?>
<span  class="errorcustclass"></span>
</div>
</div>
<div class="form-group row">
<label class="control-label col-sm-6">Issue Description</label>
<div class="col-sm-6">                                        
{{$description}}  
<span class="errorcustclass"></span>
</div>
<span  class="errorcustclass"></span>
</div>
					<!--Reply Section Div -->
<div class="form-group row" style="display:none" id="div_open_hide">
    <div class="form-group row">
        <label class="control-label col-sm-6">Select recipients to reply:</label>
            <div class="col-sm-6">
            
            <?php
                $attrbar = array();
                $attrbar['class'] = "control-label";
            ?>
            {{ Form::label('booker_email','Booker email',$attrbar)}}
            
           <!-- Booker email-->
            <?php
                $attrbar = array();
                $attrbar['id'] = "booker_id";
                $attrbar['class'] = "email";
            ?>
           {{ Form::checkbox('booker_email', $complained_by,null,$attrbar) }}
               
            {{--
                Booker email<input type="checkbox" value="{{$complained_by}}" class="email" name="booker_email" id="booker_id">
                
                <span class="custom-checkbox"></span>
            --}}
             <span class="custom-checkbox"></span>
            
             <?php
                $attrbar = array();
                $attrbar['class'] = "control-label";
            ?>
            {{ Form::label('artist_email','Artist email',$attrbar)}}
           <!-- Artist email-->
            <?php
                $attrbar = array();
                $attrbar['id'] = "artist_id";
                $attrbar['class'] = "email";
            ?>    
            {{ Form::checkbox('artist_email', stripslashes($first_sql[0]->artist_id),null,$attrbar) }}  
               
                 <span class="custom-checkbox"></span>
            
                {{--
                <input type="checkbox" value="{{stripslashes($first_sql[0]->artist_id)}}" class="email" name="artist_email" id="artist_id" >
                <span class="custom-checkbox"></span>
                --}}    
            </div>
    </div>

    <div class="form-group row" id="div_open_hide">
        <label class="control-label col-lg-2">Reply Content</label>
            <div class="col-sm-10">
                <textarea id="description" class="form-control input-sm " name="description" cols="50" rows="10"></textarea>		
                    <span  class="errorcustclass"></span>	
            </div>
    </div>
</div>
    
<input type="hidden" name="resolve_dispute_id" id="resolve_dispute_id" value="{{$id}}">
<input type="hidden" id="gig_id" value="{{$gig_id}}">
<input type="hidden" id="gig_unique_id" value="{{$gig_unique_id}}">
<input type="hidden" id="dispute_type" value="{{$dispute_type}}">
<!--<input type="hidden" id="url" value="<?php echo url(ADMINSEPARATOR.'/reply');?>">-->
<!--<input type="hidden" id="complained_to" value="<?php //echo stripslashes($first_sql[0]->artist_id);?>">
<input type="hidden" id="complained_by" value="{{$complained_by}}">-->

<!--Reply Section div closes-->
</div>
<div class="panel-footer">
<a class="btn btn-warning" href="<?php echo  url(ADMINSEPARATOR.'/admin_issue_with_artist'); ?>"><i class="fa fa-chevron-left"></i> Back</a>
<span id="button"  name="frgtchk" onclick="showhide()" class="btn btn-success btn-sm bounceIn animation-delay5  pull-right" ><i class="fa fa-sign-in"></i> Reply</span>
<!--<input type="button" id="submit" class="btn btn-success btn-sm bounceIn animation-delay5  pull-right" style="display:none;">-->
<button type="button" id="disputeartistreply" class="btn btn-success btn-sm bounceIn animation-delay5  pull-right" style="display:none;">Submit</button>
</div> 
<?php
echo Form::close();
?>
</div>
</div>
</div>
</div>
@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script type="text/javascript">

$(document).ready(function () {
        
        $(document).on('click','#disputeartistreply',function(){
       // jQuery("#disputeartistreply").click(function(){
            
            var booker_email_id = '';
            
            if($("input[name^=booker_email]:checked")){
            
                booker_email_id = $("input[name^=booker_email]:checked").val();	//  $("#booker_email").val();
            }
                    
            var artist_email_id = '';
            
            if($("input[name^=artist_email]:checked")){
                
                artist_email_id = $("input[name^=artist_email]:checked").val();
            }
        
            if((jQuery.type(artist_email_id) === "undefined") && (jQuery.type(booker_email_id) === "undefined")){
            
                alert ('You didn\'t choose any of the checkboxes!');
            }
            else{
               // console.log('else part');
                //$('#formdisputeid').submit();
        
                var description=$("#description").val();
                var resolve_dispute_id=$("#resolve_dispute_id").val();
                var gig_id=$("#gig_id").val();
                var booker_id=$("#booker_id").val();
                var artist_id=$("#artist_id").val();
                var gig_unique_id=$('#gig_unique_id').val();
                var url= "<?php echo url(ADMINSEPARATOR.'/reply');?>";
                
                var snddata = {_token:"<?php echo csrf_token(); ?>",description:description,resolve_dispute_id:resolve_dispute_id,gig_id:gig_id,gig_unique_id:gig_unique_id,booker_id:booker_id,artist_id:artist_id};
                console.log(url);
                
                $.ajax({
                	    url:url,
                		type:"POST",
                		data:snddata,				
                		
                		dataType:"json",
                		success:function(d)
                		{
                		//console.log(d);
                		alert(d);                    
                		}
                	});
            
                //forreplysectionsub(snddata);
            }
            
        });
    });
    function  forreplysectionsub(snddata){
        console.log('second ajax');

            jQuery.ajax({
                type: "POST",
                data:snddata,
                url: "<?php echo url(ADMINSEPARATOR.'/reply');?>",
                dataType:"json",
                success: function(data)
                {
                    console.log('this is for testing');
                }
            });
    }

</script>
    
<script>
function showhide()
{
    var div = document.getElementById("div_open_hide");
    if (div.style.display !== "none") {
        div.style.display = "none";
        $('#disputeartistreply').hide();
        $('#button').show();
    }
    else {
        div.style.display = "block";
        
        $('#button').hide();
        $('#disputeartistreply').show();
        
    }
}
</script>

