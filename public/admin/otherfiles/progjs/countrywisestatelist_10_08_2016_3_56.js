$(document).ready(function(){
				var currentStep = 1;
				$('#wizardTab li a').click(function()	{
				return false;
				});
				$("#prevStep").attr('style',"display:none");
				$("#addeditcomplete").attr('style',"display:none");

				$('#footer2').attr('style',"display:none");

if(typeflag == 0)
{
	$('.panel-tab').attr('style',"display:none");
	$('.panel-footer').attr('style',"display:none");

	$('#footer2').removeAttr('style',"display:none");
}


		$('.datepicker').datepicker({
			format:'mm/dd/yyyy',
			//startDate:'01/08/2016'	
		})
	$('#tfndiv').hide();
	
//*** check if gst is yes or no and tfn block showing respect of that starts

	var gstonload=$('#gst').val();
	
	if (gstonload==0) {
		$('#tfndiv').hide();
	}
	else{
		$('#tfndiv').show();
	}
	
	jQuery('#gst').on('change',function(evnt){
		
		var gstchangeval=this.value;
		
		if (gstchangeval==1) {
			$('#tfndiv').show('slow');
		}
		else{
			$('#tfndiv').hide('slow');
		}
		
	});

//*** check if gst is yes or no and tfn block showing respect of that ends

//*** populate state on selecting country  starts

	jQuery('#country_id').on('change',function(evnt){
		
		var country_id=this.value;
		callurl=admin_base_url_data+'/countrywisestate';
		var snddata = {_token:admin_csrf_token_data,country_id:country_id}
		jQuery.ajax({
			url: callurl,
			data: snddata,
			type: "POST",
			dataType:'JSON',
			success: function(d)
			{	
				state_opt_html='';
				
				if (d!=null)
				{
					$.each(d, function(idx, obj)
					{ 
						state_opt_html+="<option value='"+obj.state_id+"'>"+obj.state_name+"</option>"; 
					});
				}                                        
				
				$("#state_id").html(state_opt_html);
			//	$("#state_id").selectpicker('refresh');
			}
		});
	});
		
//*** populate state on selecting country  ends

//*** populate subskill on selecting skill  starts

	jQuery('#skill_id').on('change',function(evnt){
		
		var skill_id=this.value;
		callurl=admin_base_url_data+'/skillwisesubskill';
		var snddata = {_token:admin_csrf_token_data,skill_id:skill_id}
		jQuery.ajax({
			url: callurl,
			data: snddata,
			type: "POST",
			dataType:'JSON',
			success: function(d)
			{	
				subskill_opt_html='';
				
				if (d!=null)
				{
					$.each(d, function(idx, obj)
					{ 
						subskill_opt_html+="<option value='"+obj.subskill_id+"'>"+obj.subskill_name+"</option>"; 
					});
				}                                        
				
				$("#subskill_id").html(subskill_opt_html);
				//$("#subskill_id").selectpicker('refresh');
			}
		});
	});
		
//*** populate subskill on selecting skill  ends



		// $("#dateofbirth").on("dp.change", function (e) {
		// 	$('#dateofbirth').data("DatePicker").maxDate(e.date);
		// });

		$('#nextStep').click(function()	{
				
				currentStep++;
				
				if(currentStep == 2)	{
					$('#wizardTab li:eq(1) a').tab('show');
					$("#prevStep").removeAttr('style',"display:none");
					$("#nextStep").removeAttr('style',"display:none");

					$('#prevStep').attr('disabled',false);
					$('#prevStep').removeClass('disabled');
				}
				else if(currentStep == 3)	{
					$('#wizardTab li:eq(2) a').tab('show');
					$("#prevStep").removeAttr('style',"display:none");
					$("#nextStep").removeAttr('style',"display:none");

					
					$('#nextStep').attr('disabled',false);
					$('#nextStep').removeClass('disabled');
				}
				else if(currentStep == 4)	{
					$('#wizardTab li:eq(3) a').tab('show');
					$("#prevStep").removeAttr('style',"display:none");
					$("#nextStep").attr('style',"display:none");


					$("#addeditcomplete").removeAttr('style',"display:none");
				}
				
				return false;
			});
		$('#prevStep').click(function()	{
				$("#addeditcomplete").attr('style',"display:none");

				currentStep--;
				
				if(currentStep == 1)	{
				
					$('#wizardTab li:eq(0) a').tab('show');
				//	$('#wizardProgress').css("width","66%");
						
					$("#prevStep").attr('style',"display:none");
					$("#nextStep").removeAttr('style',"display:none");
					
					//$('#wizardProgress').css("width","33%");
				}
				else if(currentStep == 2)	{
				
					$('#wizardTab li:eq(1) a').tab('show');
					//$('#wizardProgress').css("width","66%");

					$("#prevStep").removeAttr('style',"display:none");
					$("#nextStep").removeAttr('style',"display:none");


							
					$('#nextStep').attr('disabled',false);
					$('#nextStep').removeClass('disabled');
					
				//	$('#wizardProgress').css("width","33%");
				}
				else if(currentStep == 3)	{
				
					$('#wizardTab li:eq(2) a').tab('show');
				//	$('#wizardProgress').css("width","66%");
							
					$("#prevStep").removeAttr('style',"display:none");
					$("#nextStep").removeAttr('style',"display:none");

					$('#nextStep').attr('disabled',false);
					$('#nextStep').removeClass('disabled');
					
				//	$('#wizardProgress').css("width","66%");
				}
				
				return false;
			});

});


$("#addeditcomplete_btn").click(function()	{

$('#useraddfrmid').submit();
});
