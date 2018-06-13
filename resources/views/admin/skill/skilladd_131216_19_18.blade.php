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
	<?php
	$name='';$id=0; $usertype_id_data=array();$userskilltype_id_data=array(); $catag_type=0;$skill_id=0;
	if(!empty($skillrow))
	{
		$name=stripslashes($skillrow->name);
		$id=$skillrow->id;
		$catag_type = $skillrow->catag_type;
		$skill_id =   $skillrow->parent_id;
	}
	
	if(!empty($id))
	{
		$disParent=true;
		$disUtype=true;
	}
	else{
		$disParent=false;
		$disUtype=false;
	}
	
	if(!empty($uesrtypeidAr))
	{
		$usertype_id_data=$uesrtypeidAr;
		// echo "<pre>";
		//  print_r($usertype_id_data);
		// exit();
	}
	if(!empty($uesrskilltypeidAr))
	{
		$userskilltype_id_data=$uesrskilltypeidAr;
		//  echo "<pre>";
		//  print_r($uesrskilltypeidAr);
		// exit();
	}
	
	?>
			<div class="padding-md">
				<div class="row">
					<div class="col-md-8 col-md-offset-2">
						<div class="panel panel-default">
							
								
								<?php echo Form::open(array('url' => ADMINSEPARATOR.'/skillsave', 'method' => 'post','id'=>'skilladdfrmid','class'=>"form-horizontal form-border no-margin" )); ?>
								<div class="panel-heading">
								 Save Skill
								</div>
								<div class="panel-body">
								
								
									<!--<div class="form-group">
										<label class="control-label col-lg-4">*User Type </label>
										<div class="col-lg-6">
											
											<?php    
   echo Form::select('catag_type',$usertype_id_data , $catag_type,$attributes = array( "id"=>"catag_type","class"=>"form-control input-sm parsley-validated"));
   ?>

	<span  class="errorcustclass">{{ $errors->first('catag_type') }}</span>

										</div>--><!-- /.col -->
									<!--</div>--><!-- /form-group -->
									
									

									<div class="form-group" id="pData">
										<label class="control-label col-lg-4">Parent Skill </label>
										<div class="col-lg-6">
											
											<?php
											$skillparentproper=array();
											$skillparentproper['id']="parent_id";
											$skillparentproper['class']="form-control input-sm";
											if(!empty($id))
											{
												$skillparentproper['disabled']="";
											}
											
   echo Form::select('parent_id', $userskilltype_id_data , $skill_id, $attributes = $skillparentproper);
   ?>

										</div><!-- /.col -->
									</div><!-- /form-group -->


									
									<div class="form-group">
										<label class="control-label col-lg-4">*Skill Name<br>*Only letters and spaces are allowed</label>

										<div class="col-lg-6">
											
											<?php    
    echo Form::text("name", $value=$name, $attributes = array( "id"=>"name","class"=>" form-control input-sm parsley-validated ")); ?>
	<span  class="errorcustclass">{{ $errors->first('name') }}</span>


										</div><!-- /.col -->
									</div><!-- /form-group -->
									
									
									<div class="form-group" id="utypeData">
										<label class="control-label col-lg-4">*User Type </label>
										<div class="col-lg-6">
											
											<?php
											$skillutypeproper=array();
											$skillutypeproper['multiple']="multiple";
											$skillutypeproper['id']="catag_type";
											$skillutypeproper['class']="form-control input-sm parsley-validated";
											if(!empty($id))
											{
												$skillutypeproper['disabled']="";
											}
											
											
   echo Form::select('catag_type[]', $usertype_id_data , $catag_type, $attributes = $skillutypeproper);
   ?>

	<span  class="errorcustclass">{{ $errors->first('catag_type') }}</span>

										</div><!-- /.col -->
									</div><!-- /form-group -->
									
								
								</div>
								<div class="panel-footer ">
								
									<button class="btn btn-success" type="submit">Submit</button>
									<a class="btn btn-warning" href="<?php echo  url(ADMINSEPARATOR.'/skill'); ?>"><i class="fa fa-chevron-left"></i> Back</a>
								</div>
									<input type="hidden" name="skillid" value="<?php echo $id; ?>" id="skillid" >
							<?php
							
							echo Form::close();
							
							?>
						</div><!-- /panel -->
					</div>
					</div>
			</div><!-- /.padding-md -->
<script>
			//jQuery("#catag_type").change(function(){
			//	
			//	
			//	
			//	
			//	var catag_type_data=jQuery(this).val();
			//	// alert(catag_type_data);exit();
			//	//alert("statuschange_data==>"+statuschange_data);
			//	// var skillid_data=jQuery(this).data('skillid');
			//	
			//	
			//	
			//					var snddata = {_token:"<?php echo csrf_token(); ?>",userid:catag_type_data};
			//									  
			//					// alert(JSON.stringify(snddata));
			//							  
			//					jQuery.ajax({
			//									type: "POST",
			//									data:snddata,
			//									url: "<?php echo url(ADMINSEPARATOR.'/skillnamechange');?>",
			//									dataType:"json",
			//									success: function(data)
			//									{
			//										
			//
			//										var tt=JSON.stringify(data);
			//										// alert(tt);
			//										// alert(data.length);
			//
			//										var skiloptstr="<option value=''>Select a skill</option>";
			//										if(data.length>0)
			//										{
			//											jQuery.each(data,function(ind, vaobj){
			//
			//												skiloptstr+="<option value="+vaobj.id+">"+vaobj.name+"</option>";
			//											});
			//											
			//										}
			//
			//
			//
			//										//alert(skiloptstr);
			//
			//										jQuery("#parent_id").html(skiloptstr);
			//										
			//										
			//									}
			//						   });
			//	
			//	
			//	
			//	
			//	});
</script>
	
	<!-- for skill respective state dorpdown js starts -->
	<!-- <script type="text/javascript" src="{{ URL::asset('public/admin')}}/otherfiles/progjs/adminskillrelated.js"></script> -->
	<script type="text/javascript" src="{{ ADMINCSSPATH}}/otherfiles/progjs/adminskillrelated.js"></script>
	<!-- for skill respective state dorpdown js ends -->
    
@endsection