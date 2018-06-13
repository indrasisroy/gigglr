<?php

	$successmsg='';
	$errormsg='';
	
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

	$name='';
	$id=0;
	$catag_type=0;
	$skill_id=0;
	$genre_id=0;
	$association_id=0;
	$usertype_id_data=array();
	$userskilltype_id_data=array();
	$usercoreasso_id_data=array();
	$usergenre_id_data=array();
	$userselasso_id_data=array();
	
	if(!empty($skillrow))
	{
		$name=stripslashes($skillrow->name);
		$id=$skillrow->id;
		$genre_id=$skillrow->id;
		$catag_type = $skillrow->catag_type;
		$skill_id =   $skillrow->parent_id;
	}
	
	if(!empty($uesrselassoidAr))
	{
		$userselasso_id_data=$uesrselassoidAr;
	}
	
	if(!empty($uesrtypeidAr))
	{
		$usertype_id_data=$uesrtypeidAr;
	}
	
	if(!empty($uesrskilltypeidAr))
	{
		$userskilltype_id_data=$uesrskilltypeidAr;
	}
	
	if(!empty($uesrgenreidAr))
	{
		$usergenre_id_data=$uesrgenreidAr;
	}
	
	if(!empty($uesrcoreassoidAr))
	{
		$usercoreasso_id_data=$uesrcoreassoidAr;
	}
	
?>

	<div class="padding-md">
		<div class="row">
			<div class="col-md-8 col-md-offset-2">
				<div class="panel panel-default">
				
					<?php echo Form::open(array('url' => ADMINSEPARATOR.'/associationsave', 'method' => 'post','id'=>'skilladdfrmid','class'=>"form-horizontal form-border no-margin" )); ?>
					
						<div class="panel-heading">
							Save Association
						</div>
							
						<div class="panel-body">
						
							<div class="form-group">
								<label class="control-label col-lg-4">* User Type </label>
								<div class="col-lg-6">
									<?php echo Form::select('catag_type',$usertype_id_data , $catag_type,$attributes = array( "id"=>"catag_type","class"=>"form-control input-sm parsley-validated")); ?>
									<span  class="errorcustclass">{{ $errors->first('catag_type') }}</span>
								</div><!-- /.col -->
							</div><!-- /form-group -->
							
							<div class="form-group">
								<label class="control-label col-lg-4">* Category </label>
								<div class="col-lg-6">
									<?php echo Form::select('parent_id',$userskilltype_id_data , $skill_id,$attributes = array( "id"=>"parent_id","class"=>"form-control input-sm")); ?>
									<span  class="errorcustclass">{{ $errors->first('parent_id') }}</span>
								</div><!-- /.col -->
							</div><!-- /form-group -->
							
							<div class="form-group">
								<label class="control-label col-lg-4">* Genre</label>
								<div class="col-lg-6">
									<?php echo Form::select('genre_id',$usergenre_id_data , $genre_id,$attributes = array( "id"=>"genre_id","class"=>"form-control input-sm")); ?>
									<span  class="errorcustclass">{{ $errors->first('genre_id') }}</span>
								</div><!-- /.col -->
							</div><!-- /form-group -->
							
							<div class="form-group">
								<label class="control-label col-lg-4">* Association <br>( Choose maximum any 3 options )</label>
								<div class="col-lg-6">
									<?php echo Form::select('association_id[]',$usercoreasso_id_data , $userselasso_id_data,$attributes = array( "id"=>"association_id","class"=>"form-control input-sm parsley-validated","multiple"=>true)); ?>
									<span  class="errorcustclass">{{ $errors->first('association_id') }}</span>
								</div><!-- /.col -->
							</div><!-- /form-group -->
							
						</div>
							
						<div class="panel-footer ">
							<button class="btn btn-success" type="submit">Submit</button>
							<a class="btn btn-warning" href="<?php echo  url(ADMINSEPARATOR.'/association'); ?>"><i class="fa fa-chevron-left"></i> Back</a>
						</div>
							
						<input type="hidden" name="skillid" value="<?php echo $id; ?>" >
						
					<?php echo Form::close(); ?>
					
				</div><!-- /panel -->
			</div>
		</div>
	</div><!-- /.padding-md -->
	
<script>

	jQuery("#catag_type").change(function(){
		var gnroptstr="<option value=''>Select a genre</option>";
		jQuery("#genre_id").html(gnroptstr);
		var catag_type_data=jQuery(this).val();
		// alert(catag_type_data);exit();
		//alert("statuschange_data==>"+statuschange_data);
		// var skillid_data=jQuery(this).data('skillid');
		var snddata = {_token:"<?php echo csrf_token(); ?>",userid:catag_type_data};				  
		// alert(JSON.stringify(snddata));		  
		jQuery.ajax({
			type: "POST",
			data:snddata,
			url: "<?php echo url(ADMINSEPARATOR.'/associationcategorynamechange');?>",
			dataType:"json",
			success: function(data)
			{
				var tt=JSON.stringify(data);
				// alert(tt);
				// alert(data.length);
				var skiloptstr="<option value=''>Select a category</option>";
				if(data.length>0)
				{
					jQuery.each(data,function(ind, vaobj){
						skiloptstr+="<option value="+vaobj.id+">"+vaobj.name+"</option>";
					});
				}
				//alert(skiloptstr);
				jQuery("#parent_id").html(skiloptstr);
			}
		});		
	});
				
	jQuery("#parent_id").change(function(){
		var parent_id_data=jQuery(this).val();
		// alert(catag_type_data);exit();
		//alert("statuschange_data==>"+statuschange_data);
		// var skillid_data=jQuery(this).data('skillid');
		var snddata = {_token:"<?php echo csrf_token(); ?>",userid:parent_id_data};				  
		// alert(JSON.stringify(snddata));		  
		jQuery.ajax({
			type: "POST",
			data:snddata,
			url: "<?php echo url(ADMINSEPARATOR.'/associationgenrenamechange');?>",
			dataType:"json",
			success: function(data)
			{
				var tt=JSON.stringify(data);
				// alert(tt);
				// alert(data.length);
				var gnroptstr="<option value=''>Select a genre</option>";
				if(data.length>0)
				{
					jQuery.each(data,function(ind, vaobj){
						gnroptstr+="<option value="+vaobj.id+">"+vaobj.name+"</option>";
					});
				}
				//alert(skiloptstr);
				jQuery("#genre_id").html(gnroptstr);
			}
		});		
	});
	
</script>
    
@endsection