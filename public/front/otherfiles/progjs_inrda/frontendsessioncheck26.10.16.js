function myFunctionsetintervl(showsessionexiststrue)
{
    console.log("call from footer func");
    setInterval(function()
      {
        console.log("call from footer func too");
         var sesdata = {_token:csrf_token_data,logIDchk:logID};
                         var urldata=base_url_data+"/"+showsessionexiststrue;
                         jQuery.ajax({
										type: "POST",
										data:sesdata,
										url: urldata,
										dataType:"json",
										success: function(res)
										{
                                            //if(res.flag_id != 2)
                                            //{
                                                if(res.flag_id == 1)
                                                {
                                                    window.location.href = base_url_data;
                                                }
                                           // }
                                        }
                         });

           
        
      }, 10000);
}

jQuery(document).ready(function(){
				
//        $('#subscribebut').click(function(){
//		    callforsubscription("subscribe",csrf_token_data);
//		});
//        $('#clickme1').click(function(){
//        	$( ".new-location" ).toggle();
//			$(this).parent().toggleClass('clickBorder');
//			$('.new-location').find('.form-control:eq(0)').focus();
//		});	
console.log("call from footer");
								//***********for session check
								myFunctionsetintervl("showsessionexiststrue");	//******** called in  frontendsessioncheck
    });