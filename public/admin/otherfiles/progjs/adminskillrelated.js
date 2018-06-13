$(document).ready(function(){
                var parentid=jQuery('#parent_id').val();
                var childid=jQuery('#skillid').val();
                if (childid!='' && childid!=0) {
                    fetchusertypebysubskill(childid);
                }
                else if (parentid!='' && parentid!=0) {
                    fetchusertypebyskill(parentid);
                }
});


jQuery("#parent_id").change(function(){
                var parent_id_data=jQuery(this).val();
                if (parent_id_data!='' || parent_id_data!=0) {
                    fetchusertypebyskill(parent_id_data);
                }
});


function fetchusertypebyskill(parentid) {
                var callurl=admin_base_url_data+'/skillusertypechange';
				var snddata = {_token:admin_csrf_token_data,parent_skill_id:parentid};						  
				jQuery.ajax({
                                type: "POST",
                                data:snddata,
                                url: callurl,
                                dataType:"json",
                                success: function(data)
                                {
                                                console.log(data.length);
                                                var skillusertypeopt='';
                                                if(data.length>0)
                                                {
                                                                jQuery.each(data,function(ind, vaobj){
                                                                                skillusertypeopt+="<option value="+vaobj.typeID+">"+vaobj.typeName+"</option>";
                                                                });   
                                                }
                                                jQuery("#catag_type").html(skillusertypeopt);													
                                }
				});     
}


function fetchusertypebysubskill(childid) {
                var callurl=admin_base_url_data+'/subskillusertypechange';
				var snddata = {_token:admin_csrf_token_data,child_skill_id:childid};						  
				jQuery.ajax({
                                type: "POST",
                                data:snddata,
                                url: callurl,
                                dataType:"json",
                                success: function(data)
                                {
                                                console.log(data.length);
                                                var subskillusertypeopt='';
                                                if(data.length>0)
                                                {
                                                                jQuery.each(data,function(ind, vaobj){
                                                                                subskillusertypeopt+="<option value="+vaobj.typeID+">"+vaobj.typeName+"</option>";
                                                                });   
                                                }
                                                jQuery("#catag_type").html(subskillusertypeopt);													
                                }
				});     
}