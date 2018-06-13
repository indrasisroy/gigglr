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
$dispute_resolved_status = '';
if(!empty($pagi_country))
	{
	//echo '<pre>';print_r($pagi_country);exit;
		$id=$pagi_country->id;
		
		$complained_by=$pagi_country->dispute_opener_id;
		$complaint_against=$pagi_country->artist_id;
		
		$gig_id=$pagi_country->gig_id;
		$gig_unique_id=$pagi_country->gig_unique_id;
		$dispute_type=$pagi_country->dispute_type;
		$gig_name=$pagi_country->gig_name;
		$description=$pagi_country->issue_description;
		
		$event_start_date_time=$pagi_country->event_start_date_time;
		$event_city=$pagi_country->event_city;
		$dispute_opening_date=$pagi_country->dispute_opening_date;
		
		$booker_email=$pagi_country->booker_email;
		$booker_nick_name=$pagi_country->booker_nickname;
		$venue_creator_email = $pagi_country->venue_creator_email;
		$venue_creator_nickname = $pagi_country->venue_creator_nickname;
		$dispute_resolved_status = $pagi_country->dispute_resolved_status;
	}
?>
@extends('layouts.admin.adminmaster',['successmsg' => $successmsg,'errormsg'=>$errormsg])
@section('content')
<div class="padding-md">
<div class="row">
<div class="col-md-8 col-md-offset-2">
<div class="panel panel-default">
<div class="panel-heading">
Issue with venue reply section
</div>
	
		<!--here all the replys listing-->
	
	<div class="panel-body">
	
		<div id="reply_responce">
			@if(count($reply_messeges) > 0)
				<?php $i = 0;?>
				@foreach($reply_messeges as $all_reply)
					<?php $i++?>
					<h4>{{$all_reply->reply_by_user}}</h4>
					<span>{{date('d M Y , h:i A', strtotime($all_reply->reply_date))}}</span>
					<div class="seperator"></div>
					<div class="seperator"></div>
					<p>{{ucwords($all_reply->reply_content)}}</p><hr></hr>
						
				@endforeach
				<div style="display:none" id="last_row" data-row="{{$i}}"></div>
			@endif
		</div>
		<div id="loadDiv">
			
		</div>
	</div>
	
		
	<!--here all the replys listing end-->
	<!--load more section-->
	
	<div class="from-group" >
		<input type="hidden" name="total_data" id="total_data" value="{{$total_data}}">
		<input type="hidden" name="limit" id="limit" value="4">
		@if($total_data > 4)
		<button type="button" id="load" class="btn btn-default btn-sm bounceIn animation-delay5" style="align:centre">load previous</button><hr></hr>
	   @endif
	</div>
	
	<!--end-->
	
<div class="panel-body">
<?php
echo Form::open(array('url' => '','method' =>'post','id'=>'formdisputeid','class'=>"form-horizontal form-border no-margin" ));?>
	
	<!--for Resolve the dispute button-->
	<?php if($dispute_resolved_status == '0'){
	?>
	<div class="form-group row">
		<div class="panel-footer">
			  <a type="button" id="resolve_the_dispute_button" class="btn btn-warning pull-right">Resolve the dispute</a>
		</div>
	</div>
	<?php }
	else if($dispute_resolved_status == '1'){
	?>
	
	<div class="form-group row">
		<div class="panel-footer">
			  <a type="button" id="resolve_the_dispute_details" class="btn btn-warning pull-right">Resolved the dispute details</a>
		</div>
	</div>
	<div class="form-group row" id="resolved_details" style="display:none">
		<div class="form-group">
			<label class="col-lg-6 control-label">Total amount to pay</label>
				<div class="col-lg-6">
					<label class="control-label">
						{{$sddetails['total_amount']}}
					</lebel>
				</div>
		</div>
		<div class="form-group">
			<label class="col-lg-6 control-label">Pay to booker</label>
				<div class="col-lg-6">
					<input class="form-control" type="text" id="pay_to_booker" name="pay_to_booker" readonly value="{{$dispute_resolved_amount['booker_amount']}}" placeholder="input here...">
				</div>
		</div>
		<div class="form-group">
			<label class="col-lg-6 control-label">Pay to artist</label>
				<div class="col-lg-6">
					<input class="form-control" type="text" id="pay_to_artist" name="pay_to_artist" readonly value="{{$dispute_resolved_amount['artist_amount']}}" placeholder="input here...">
				</div>
		</div>
		<div class="form-group">
			<label class="col-lg-6 control-label">Resolved the dispute date</label>
				<div class="col-lg-6">
					<input class="form-control" type="text" id="pay_to_booker" name="pay_to_booker" readonly value="{{date("d-m-Y", strtotime($dispute_resolved_amount['modified_date']))}}" placeholder="input here...">
				</div>
		</div>
			<hr></hr>
	</div>
	<?php
	}
	?>
	<!--for Resolve the dispute button end-->

	<div class="form-group row" id="resolve_the_dispute_div" style="display:none">
	
		<div class="form-group">
			<label class="col-lg-6 control-label">Total amount to pay</label>
				<div class="col-lg-6">
					<label class="control-label">
						{{$sddetails['total_amount']}}
					</lebel>
				</div>
		</div>
		<div class="form-group">
			<label class="col-lg-6 control-label">Pay to booker</label>
				<div class="col-lg-6">
					<input class="form-control" type="text" id="pay_to_booker" name="pay_to_booker" data-booker="{{$complained_by}}" placeholder="input here...">
				</div>
		</div>
		<div class="form-group">
			<label class="col-lg-6 control-label">Pay to artist</label>
				<div class="col-lg-6">
					<input class="form-control" type="text" id="pay_to_artist" name="pay_to_artist"  data-artist="{{$pagi_country->artist_id}}" placeholder="input here...">
				</div>
		</div>
		<div class="panel-footer">
			<button class="btn btn-xs btn-success pull-right" id="paybutton" type="button">Pay</button>
		</div>
			<hr></hr>
		
	</div>

	
					<!--Reply Section Div -->
<div class="form-group row" id="div_open_hide">
	<?php if($dispute_resolved_status == '0'){
	?>
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
               
           
             <span class="custom-checkbox"></span>
            
             <?php
                $attrbar = array();
                $attrbar['class'] = "control-label";
            ?>
            {{ Form::label('artist_email','Venue creator email',$attrbar)}}
           <!-- Artist email-->
            <?php
                $attrbar = array();
                $attrbar['id'] = "artist_id";
                $attrbar['class'] = "email";
            ?>    
            {{ Form::checkbox('artist_email', $complaint_against,null,$attrbar) }}  
               
                 <span class="custom-checkbox"></span>
            
              
            </div>
    </div>

    <div class="form-group row" id="div_open_hide">
        <label class="control-label col-lg-2">Reply Content</label>
			<script type="text/javascript" src="{{ BASEURLPUBLICCUSTOM.'commonassets'}}/ckeditor/ckeditor.js"></script>
            <div class="col-sm-10">
                <textarea id="description" class="form-control input-sm " name="description" cols="50" rows="10"></textarea>
					<script>
							CKEDITOR.replace( 'description',
                {
                    filebrowserBrowseUrl :'{{ BASEURLPUBLICCUSTOM.'commonassets'}}/ckeditor/filemanager/browser/default/browser.html?Connector={{ BASEURLPUBLICCUSTOM.'commonassets'}}/ckeditor/filemanager/connectors/php/connector.php',
                    filebrowserImageBrowseUrl : '{{ BASEURLPUBLICCUSTOM.'commonassets'}}/ckeditor/filemanager/browser/default/browser.html?Type=Image&Connector={{ BASEURLPUBLICCUSTOM.'commonassets'}}/ckeditor/filemanager/connectors/php/connector.php',
                    filebrowserFlashBrowseUrl :'{{ BASEURLPUBLICCUSTOM.'commonassets'}}/ckeditor/filemanager/browser/default/browser.html?Type=Flash&Connector={{ BASEURLPUBLICCUSTOM.'commonassets'}}/ckeditor/filemanager/connectors/php/connector.php',
					filebrowserUploadUrl  :'{{ BASEURLPUBLICCUSTOM.'commonassets'}}/ckeditor/filemanager/connectors/php/upload.php?Type=File',
					filebrowserImageUploadUrl : '{{ BASEURLPUBLICCUSTOM.'commonassets'}}/ckeditor/filemanager/connectors/php/upload.php?Type=Image',
					filebrowserFlashUploadUrl : '{{ BASEURLPUBLICCUSTOM.'commonassets'}}/ckeditor/filemanager/connectors/php/upload.php?Type=Flash'
				});
								  
								</script>	
                    <span  class="errorcustclass"></span>	
            </div>
    </div><?php } ?>
</div>
    
<input type="hidden" name="resolve_dispute_id" id="resolve_dispute_id" value="{{$id}}">
<input type="hidden" id="gig_id" value="{{$gig_id}}">
<input type="hidden" id="gig_unique_id" value="{{$gig_unique_id}}">
<input type="hidden" id="dispute_type" value="{{$dispute_type}}">

<input type="hidden" id="booker_email_hidden" value="{{$booker_email}}">
<input type="hidden" id="booker_nick_name_hidden" value="{{$booker_nick_name}}">
<input type="hidden" id="venue_creator_email" value="{{$venue_creator_email}}">
<input type="hidden" id="venue_creator_nickname" value="{{$venue_creator_nickname}}">

<input type="hidden" id="event_start_date_time" value="{{$event_start_date_time}}">
<input type="hidden" id="event_city" value="{{$event_city}}">
<input type="hidden" id="dispute_opening_date" value="{{$dispute_opening_date}}">


<!--Reply Section div closes-->
</div>
<div class="panel-footer">


    

        <?php if($dispute_resolved_status == '1'){
		?>
    <a class="btn btn-warning" href="{{ url(ADMINSEPARATOR.'/view_venue/'.$id) }}"><i class="fa fa-chevron-left"></i> Back</a>
    
		<?php
        }else if($dispute_resolved_status == '0'){
		?>
    <a class="btn btn-warning" href="{{ url(ADMINSEPARATOR.'/view_venue/'.$id) }}"><i class="fa fa-chevron-left"></i> Back</a>
    
    <button type="button" id="disputeartistreply" data-typeid="3" class="btn btn-success btn-sm bounceIn animation-delay5  pull-right">Submit</button>
		<?php
        }?>
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
             var typeidun = $(this).data("typeid");
			 
            var description_field = CKEDITOR.instances.description.getData();
            if(description_field === "undefined" || description_field === ""){
                    alert ('Description field cannot remail blank!');
            }
                        
            var booker_ID = '';
            
            if($("input[name^=booker_email]:checked")){
            
                booker_ID = $("input[name^=booker_email]:checked").val();	//  $("#booker_email").val();
            }
			
			
			
			
                    
            var artist_ID = '';
            
            if($("input[name^=artist_email]:checked")){
                
                artist_ID = $("input[name^=artist_email]:checked").val();
            }
			
			
			
			
        
            if((jQuery.type(artist_ID) === "undefined") && (jQuery.type(booker_ID) === "undefined")){
                
                alert ('You didn\'t choose any of the checkboxes!');
            }
            else{
              
                var description=$("#description").val();
                var resolve_dispute_id=$("#resolve_dispute_id").val();
                var gig_id=$("#gig_id").val();
                var booker_id=$("#booker_id").val();
                var artist_id=$("#artist_id").val();
                var gig_unique_id=$('#gig_unique_id').val();
                var url= "<?php echo url(ADMINSEPARATOR.'/reply');?>";
				var user_type='3';
                var last_row = $("#last_row").data('row');
                var snddata = {_token:"<?php echo csrf_token(); ?>",description:description_field,resolve_dispute_id:resolve_dispute_id,gig_id:gig_id,gig_unique_id:gig_unique_id,booker_id:booker_id,artist_id:artist_id,booker_ID:booker_ID,artist_ID:artist_ID,last_row:last_row,user_type:user_type,typeidun:typeidun};
				var respdata;
                console.log(snddata);
                
                $.ajax({
                	    url:url,
                		type:"POST",
                		data:snddata,
						dataType:'json',
                		success:function(d)
                		{
                            console.log(d);
							respdata=d.reply_content;
							toster_type=d.type;
							toster_data=d.message;
							$('#loadDiv').html(' ');
							$('#limit').val('4');
							$("#reply_responce").html(respdata);
							if($("#load").is(":hidden")){
								$('#load').show();	
							}
                            $('#booker_id').attr('checked', false);
                            $('#artist_id').attr('checked', false);
                            $('#description').val(' ');
							toastr.remove(); 
							poptriggerfunc(msgtype = toster_type, titledata = '', msgdata = toster_data, sd = 1000, hd = 1500, tmo = 1000, etmo = 1000, poscls = 'toast-bottom-right');
                		}
                	});
            }
        });
		//load more
		$('#load').click(function(){
            var respdata = '';
            var total_data = $('#total_data').val();
            var limit = $('#limit').val();
            var next_limit = +limit+4;
			var resolve_dispute_id=$("#resolve_dispute_id").val();
			var url= "<?php echo url(ADMINSEPARATOR.'/load-more');?>";
			
            //alert(total_data+'  '+limit+'  '+next_limit);
            
            $.ajax({
                        url:url,
                        type: "POST",
						dataType:'json',
                        data:{'limit':limit,'resolve_dispute_id':resolve_dispute_id,'_token':$('meta[name="csrf-token"]').attr('content')},
                        success:function(d){
                            
							respdata=d.reply_content;
							console.log(respdata);
							$('#loadDiv').append(respdata);
                                if (total_data > next_limit ){
                                        $('#load').show();	
                                }
                                else{
                                        $('#load').hide();
                                }
                                $('#limit').val(next_limit);
                                //$('#append_form').html(data);  
                        }
                });
        });
		
		//-----------for resolve the dispute button click------------//
			$('#resolve_the_dispute_button').click(function(){
				
				
					if($("#resolve_the_dispute_div").is(':hidden')){
						  $('#resolve_the_dispute_div').show();
					}else{
						  $('#resolve_the_dispute_div').hide();
					}
				
			});
		//------------------END--------------------------------//
		
			$('#resolve_the_dispute_details').click(function(){
				
				
					if($("#resolved_details").is(':hidden')){
						  $('#resolved_details').show();
					}else{
						  $('#resolved_details').hide();
					}
				
			});		
		
		//-----------pay to booker and artist start-------------//
		$('#paybutton').click(function(){
			$(this).prop("disabled",true);
			var intRegex = /^\d+$/;
			var floatRegex = /^((\d+(\.\d *)?)|((\d*\.)?\d+))$/;
			var trasactionFlag = '1';
			
			var gig_id=$("#gig_id").val();
			var gig_unique_id=$('#gig_unique_id').val();
			var pay_to_booker_id = $('#pay_to_booker').data('booker');
			var resolve_dispute_id=$("#resolve_dispute_id").val();
			var pay_to_booker_id_value = 0;
			
			if ($('#pay_to_booker').val()!='') {
				if(intRegex.test($('#pay_to_booker').val()) || floatRegex.test($('#pay_to_booker').val())) {
					pay_to_booker_id_value = parseInt($('#pay_to_booker').val());
				}else{
					trasactionFlag = '0';
				}
            }
			
			var pay_to_artist_id = $('#pay_to_artist').data('artist');
			var pay_to_artist_id_value = 0;
			
			if ($('#pay_to_artist').val()!='') {
				if(intRegex.test($('#pay_to_artist').val()) || floatRegex.test($('#pay_to_artist').val())) {
					pay_to_artist_id_value = parseInt($('#pay_to_artist').val());
				}else{
					trasactionFlag = '0';
				}
            }
			
			var total_amount = {{$sddetails['total_amount']}};
			var calAmount = pay_to_booker_id_value + pay_to_artist_id_value;
			



			//if (parseInt(total_amount) >= calAmount && trasactionFlag == '1' ) {
			if (parseInt(total_amount) == calAmount && trasactionFlag == '1' ) {
			
			var r = confirm("Are you sure ?");
			if (r == true) {
				//---------------ajax call to pay ammount start----------------//
				var url= "<?php echo url(ADMINSEPARATOR.'/artistbookertransactionbyadmin');?>";
				    $.ajax({
                        url:url,
                        type: "POST",
						dataType:'json',
                        data:{'artist_type':'3','pay_to_booker_id':pay_to_booker_id,'pay_to_booker_id_value':pay_to_booker_id_value,'pay_to_artist_id':pay_to_artist_id,'pay_to_artist_id_value':pay_to_artist_id_value,'resolve_dispute_id':resolve_dispute_id,'gig_id':gig_id,'gig_unique_id':gig_unique_id,'_token':$('meta[name="csrf-token"]').attr('content')},
                        success:function(d){
						toastr.remove();
						var flag = "";
						if (d.returnflag == '1') {
//                            flag = "success";
//							$('#resolve_the_dispute_button').hide();
//							$('#resolve_the_dispute_div').hide();
//							$('#div_open_hide').hide();
//							$('#disputeartistreply').hide();


                            flag = "success";
							$('#resolve_the_dispute_button').hide();
							$('#resolve_the_dispute_div').hide();
							$('#div_open_hide').hide();
							$('#disputeartistreply').hide();
							$('#resolve_the_dispute_div').show();
							$('#pay_to_booker').attr('readonly', 'readonly');
							$('#pay_to_artist').attr('readonly', 'readonly');
							$('#paybutton').hide();
							
                        }else if (d.returnflag == '0') {
							flag = "error";
                        }
						//console.log(d);
                            

							poptriggerfunc(msgtype = flag, titledata = '', msgdata = d.msg, sd = 1000, hd = 1500, tmo = 1000, etmo = 1000, poscls = 'toast-bottom-right');
                        }
                });				
				//---------------ajax call to pay ammount end----------------//
			}
			else{
				$(this).prop("disabled",false);
			}

            }else{
				poptriggerfunc(msgtype = "error", titledata = '', msgdata = "Sorry, Please enter proper value!", sd = 1000, hd = 1500, tmo = 1000, etmo = 1000, poscls = 'toast-bottom-right');
				$(this).prop("disabled",false);
			}
			//alert(pay_to_booker_id+" -> "+pay_to_booker_id_value+" "+pay_to_artist_id+" -> "+pay_to_artist_id_value+"  -----   "+total_amount);
			
		});
		
		//-----------pay to booker and artist end-----------//
    });
  
</script>

